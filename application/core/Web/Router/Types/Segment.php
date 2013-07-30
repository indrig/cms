<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 26.07.13
 * Time: 10:55
 */
namespace Core\Web\Router\Types;

use Exception,
    Core\Web\Request,
    Core\Web\Router\RouteInterface;

class Segment implements RouteInterface
{
    /**
     * Parts of the route.
     *
     * @var array
     */
    protected $parts;

    /**
     * Regex used for matching the route.
     *
     * @var string
     */
    protected $regex;

    /**
     * Map from regex groups to parameter names.
     *
     * @var array
     */
    protected $paramMap = array();

    /**
     * Default values.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Translation keys used in the regex.
     *
     * @var array
     */
    protected $translationKeys = array();

    /**
     * Create a new regex route.
     *
     * @param  string $route
     * @param  array  $constraints
     * @param  array  $defaults
     */
    public function __construct($route, array $constraints = array(), array $defaults = array())
    {
        $this->defaults = $defaults;
        $this->parts    = $this->parseRouteDefinition($route);
        $this->regex    = $this->buildRegex($this->parts, $constraints);
    }

    public function match(Request $request)
    {

    }

    /**
     * factory(): defined by RouteInterface interface.
     *
     * @see    RouteInterface::factory()
     * @param  array $options
     * @return Segment
     * @throws Exception
     */
    public static function factory($options = array())
    {
        if (!is_array($options))
        {
            throw new Exception(__METHOD__ . ' expects an array or Traversable set of options');
        }

        if (!isset($options['route'])) {
            throw new Exception('Missing "route" in options array');
        }

        if (!isset($options['constraints'])) {
            $options['constraints'] = array();
        }

        if (!isset($options['defaults'])) {
            $options['defaults'] = array();
        }

        return new static($options['route'], $options['constraints'], $options['defaults']);
    }

    /**
     * Parse a route definition.
     *
     * @param  string $def
     * @return array
     * @throws Exception
     */
    protected function parseRouteDefinition($def)
    {
        $currentPos = 0;
        $length     = strlen($def);
        $parts      = array();
        $levelParts = array(&$parts);
        $level      = 0;

        while ($currentPos < $length) {
            preg_match('(\G(?P<literal>[^:{\[\]]*)(?P<token>[:{\[\]]|$))', $def, $matches, 0, $currentPos);

            $currentPos += strlen($matches[0]);

            if (!empty($matches['literal'])) {
                $levelParts[$level][] = array('literal', $matches['literal']);
            }

            if ($matches['token'] === ':') {
                if (!preg_match('(\G(?P<name>[^:/{\[\]]+)(?:{(?P<delimiters>[^}]+)})?:?)', $def, $matches, 0, $currentPos)) {
                    throw new Exception('Found empty parameter name');
                }

                $levelParts[$level][] = array('parameter', $matches['name'], isset($matches['delimiters']) ? $matches['delimiters'] : null);

                $currentPos += strlen($matches[0]);
            } elseif ($matches['token'] === '{') {
                if (!preg_match('(\G(?P<literal>[^}]+)\})', $def, $matches, 0, $currentPos)) {
                    throw new Exception('Translated literal missing closing bracket');
                }

                $currentPos += strlen($matches[0]);

                $levelParts[$level][] = array('translated-literal', $matches['literal']);
            } elseif ($matches['token'] === '[') {
                $levelParts[$level][] = array('optional', array());
                $levelParts[$level + 1] = &$levelParts[$level][count($levelParts[$level]) - 1][1];

                $level++;
            } elseif ($matches['token'] === ']') {
                unset($levelParts[$level]);
                $level--;

                if ($level < 0) {
                    throw new Exception('Found closing bracket without matching opening bracket');
                }
            } else {
                break;
            }
        }

        if ($level > 0) {
            throw new Exception('Found unbalanced brackets');
        }

        return $parts;
    }

    /**
     * Build the matching regex from parsed parts.
     *
     * @param  array   $parts
     * @param  array   $constraints
     * @param  int $groupIndex
     * @return string
     */
    protected function buildRegex(array $parts, array $constraints, &$groupIndex = 1)
    {
        $regex = '';

        foreach ($parts as $part) {
            switch ($part[0]) {
                case 'literal':
                    $regex .= preg_quote($part[1]);
                    break;

                case 'parameter':
                    $groupName = '?P<param' . $groupIndex . '>';

                    if (isset($constraints[$part[1]])) {
                        $regex .= '(' . $groupName . $constraints[$part[1]] . ')';
                    } elseif ($part[2] === null) {
                        $regex .= '(' . $groupName . '[^/]+)';
                    } else {
                        $regex .= '(' . $groupName . '[^' . $part[2] . ']+)';
                    }

                    $this->paramMap['param' . $groupIndex++] = $part[1];
                    break;

                case 'optional':
                    $regex .= '(?:' . $this->buildRegex($part[1], $constraints, $groupIndex) . ')?';
                    break;

                case 'translated-literal':
                    $regex .= '#' . $part[1] . '#';
                    $this->translationKeys[] = $part[1];
                    break;
            }
        }

        return $regex;
    }
}