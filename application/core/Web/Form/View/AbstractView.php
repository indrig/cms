<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Indrig
 * Date: 03.08.13
 * Time: 12:35
 * To change this template use File | Settings | File Templates.
 */
namespace Core\Web\Form\View;

use Exception,
    Core\Web\Form\AbstractElement;

abstract class AbstractView
{
    protected static $views = array();
    /**
    * @var \Core\Web\Form\AbstractElement
    */
    protected $element;
    /**
    * Standard boolean attributes, with expected values for enabling/disabling
    *
    * @var array
    */
    protected $booleanAttributes = array(
        'autocomplete' => array('on' => 'on',        'off' => 'off'),
        'autofocus'    => array('on' => 'autofocus', 'off' => ''),
        'checked'      => array('on' => 'checked',   'off' => ''),
        'disabled'     => array('on' => 'disabled',  'off' => ''),
        'multiple'     => array('on' => 'multiple',  'off' => ''),
        'readonly'     => array('on' => 'readonly',  'off' => ''),
        'required'     => array('on' => 'required',  'off' => ''),
        'selected'     => array('on' => 'selected',  'off' => ''),
    );

    /**
     * Create a string of all attribute/value pairs
     *
     * Escapes all attribute values
     *
     * @param  array $attributes
     * @return string
     */
    public function createAttributesString(array $attributes)
    {
        $strings    = array();

        foreach ($attributes as $key => $value)
        {
            $key = strtolower($key);

            //Булевые атрибуты
            if(IsSet($this->booleanAttributes[$key]))
            {
                $value = empty($value) ? $this->booleanAttributes[$key]['off'] : $this->booleanAttributes[$key]['on'];
            }
            $strings[] = sprintf('%s="%s"', $key, $value);
        }
        return implode(' ', $strings);
    }

    /**
     *
     * @return mixed
     */
    public static function instance()
    {
        $name = get_called_class();
        if(IsSet(self::$views[$name]))
            return self::$views[$name];

        return (self::$views[$name] = new $name());
    }
}
