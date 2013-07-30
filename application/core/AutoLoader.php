<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 11:06
 */

namespace Core;

class AutoLoader
{
    const LOAD_NS               = 'namespaces';
    const LOAD_PREFIX           = 'prefixes';
    const AUTOREGISTER_CORE     = 'autoregister_core';

    const NS_SEPARATOR          = '\\';
    const PREFIX_SEPARATOR      = '_';

    private static $_instance   = null;

    public static function getInstance()
    {

    }

    public static function init()
    {
        self::$_instance = new AutoLoader(
            array(
                'autoregister_core' => true
            )
        );

        self::$_instance->register();
    }
    /**
     * @var array Namespace/directory pairs to search; Сщку library added by default
     */
    protected $namespaces = array();

    /**
     * @var array Prefix/directory pairs to search
     */
    protected $prefixes = array();

    /**
     * Constructor
     *
     * @param  null|array
     */
    public function __construct($options = null)
    {
        if (null !== $options) {
            $this->setOptions($options);
        }
    }

    /**
     * Configure autoloader
     * @param array $option
     */
    public function setOptions($options)
    {
        if (!is_array($options))
        {
            return false;
        }

        foreach ($options as $type => $pairs)
        {
            switch ($type) {
                case self::AUTOREGISTER_CORE:
                    if ($pairs) {
                        $this->registerNamespace('Core', __DIR__);
                    }
                    break;
                case self::LOAD_NS:
                    if (is_array($pairs))
                    {
                        $this->registerNamespaces($pairs);
                    }
                    break;
                case self::LOAD_PREFIX:
                    if (is_array($pairs))
                    {
                        $this->registerPrefixes($pairs);
                    }
                    break;

                default:
                    // ignore
            }
        }
        return $this;
    }

    /**
     * Автозагрузка класса
     *
     * @param string $class
     * @return bool|string
     */
    public function autoload($class)
    {
        if (false !== strpos($class, self::NS_SEPARATOR))
        {
            if ($this->loadClass($class, self::LOAD_NS))
            {
                return $class;
            }
            return false;
        }
        if (false !== strpos($class, self::PREFIX_SEPARATOR))
        {
            if ($this->loadClass($class, self::LOAD_PREFIX))
            {
                return $class;
            }
            return false;
        }
        return false;
    }

    /**
    * Load a class, based on its type (namespaced or prefixed)
    *
    * @param  string $class
    * @param  string $type
    * @return bool|string
    */
    protected function loadClass($class, $type)
    {

        if (!in_array($type, array(self::LOAD_NS, self::LOAD_PREFIX)))
        {
            return false;
        }
//        echo $class;

        // Namespace and/or prefix autoloading
        foreach ($this->$type as $leader => $path)
        {
            if (0 === strpos($class, $leader))
            {
                // Trim off leader (namespace or prefix)
                $trimmedClass = substr($class, strlen($leader));

                // create filename
                $filename = $this->transformClassNameToFilename($trimmedClass, $path);

                if (file_exists($filename))
                {
                    return include $filename;
                }
                return false;
            }
        }
        return false;
    }

    /**
     * Transform the class name to a filename
     *
     * @param  string $class
     * @param  string $directory
     * @return string
     */
    protected function transformClassNameToFilename($class, $directory)
    {
        // $class may contain a namespace portion, in  which case we need
        // to preserve any underscores in that portion.
        $matches = array();
        preg_match('/(?P<namespace>.+\\\)?(?P<class>[^\\\]+$)/', $class, $matches);

        $class     = (isset($matches['class'])) ? $matches['class'] : '';
        $namespace = (isset($matches['namespace'])) ? $matches['namespace'] : '';

        return $directory . str_replace(self::NS_SEPARATOR, '/', $namespace) . str_replace(self::PREFIX_SEPARATOR, '/', $class) . '.php';
    }

    /**
     * Register the autoloader with spl_autoload
     *
     * @return void
     */
    public function register()
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * Register many namespace/directory pairs at once
     *
     * @param  array $namespaces
     * @return AutoLoader
     */
    public function registerNamespaces($namespaces)
    {
        if (!is_array($namespaces))
        {
            return false;
        }

        foreach ($namespaces as $namespace => $directory)
        {
            $this->registerNamespace($namespace, $directory);
        }
        return $this;
    }

    /**
     * Register a namespace/directory pair
     *
     * @param  string $namespace
     * @param  string $directory
     * @return AutoLoader
     */
    public function registerNamespace($namespace, $directory)
    {
        $namespace = rtrim($namespace, self::NS_SEPARATOR) . self::NS_SEPARATOR;
        $this->namespaces[$namespace] = $this->normalizeDirectory($directory);
        return $this;
    }

    /**
     * Register many namespace/directory pairs at once
     *
     * @param  array $prefixes

     * @return AutoLoader
     */
    public function registerPrefixes($prefixes)
    {
        if (!is_array($prefixes)) {
            return false;
        }

        foreach ($prefixes as $prefix => $directory)
        {
            $this->registerPrefix($prefix, $directory);
        }
        return $this;
    }

    /**
     * Register a prefix/directory pair
     *
     * @param  string $prefix
     * @param  string $directory
     * @return AutoLoader
     */
    public function registerPrefix($prefix, $directory)
    {
        $prefix = rtrim($prefix, self::PREFIX_SEPARATOR). self::PREFIX_SEPARATOR;
        $this->prefixes[$prefix] = $this->normalizeDirectory($directory);
        return $this;
    }

    /**
     * Normalize the directory to include a trailing directory separator
     *
     * @param  string $directory
     * @return string
     */
    protected function normalizeDirectory($directory)
    {
        $last = $directory[strlen($directory) - 1];
        if (in_array($last, array('/', '\\'))) {
            $directory[strlen($directory) - 1] = DIRECTORY_SEPARATOR;
            return $directory;
        }
        $directory .= DIRECTORY_SEPARATOR;
        return $directory;
    }
}