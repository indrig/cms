<?php
namespace Core\Web\Form;

use Exception;

class Form extends AbstractElement
{
    const ORIENTATION_VERTICAL      = 1;
    const ORIENTATION_HORIZONTAL    = 2;
    /**
     * @var array
     */
    protected $attributes = array(
        'method' => 'POST',
    );

    /**
     * @var array
     */
    protected $elements = array();

    /**
     * @var array
     */
    protected $data;

    protected $orientation = self::ORIENTATION_VERTICAL;

    public function __construct($name = null, $options = array(), $parent = null)
    {
        parent::__construct($name, $options, $parent);

        if(isset($this->options['orientation']))
        {

        }
    }

    public function setOrientation($orientation)
    {
        if($orientation !== self::ORIENTATION_VERTICAL || $orientation !== self::ORIENTATION_HORIZONTAL)
        {
            throw new Exception('Incorrect form orientation value');
        }
        $this->orientation =$orientation;
        return $this;
    }

    public function getOrientation()
    {
        return $this->orientation;
    }
    /**
     * Устангавливает массив данных для полей формы
     * @param array $data
     */
    public function setData(array $data)
    {

    }


    public function render()
    {
        $view = new View\Form();
        return $view->render($this);
    }

    /**
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    public function __call($name, $arguments)
    {
        if(substr($name, 0, 3) === 'add')
        {
            if(!ctype_alnum($name))
            {
                throw new Exception('Incorrect element name');
            }
            $class = '\\Core\\Web\\Form\\Element\\'.substr($name, 3);
            if(!class_exists($class))
            {
                throw new Exception('Incorrect element name');
            }

            if(sizeof($arguments) === 0)
            {
                throw new Exception('Incorrect element name');
            }
            $this->elements[] = new $class($arguments[0], isset($arguments[1]) ? $arguments[1] : null, $this);
            return $this;
            //
        }
        return null;
    }
}