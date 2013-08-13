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

    protected $alert;
    protected $alert_style;

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
        return View\Form::instance()->render($this);
    }

    public function renderRow()
    {
        return $this->render();
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
                throw new Exception('Method ' . $name . ' not exists');
            }

            return ($this->elements[] = new $class(isset($arguments[0]) ? $arguments[0] : null, isset($arguments[1]) ? $arguments[1] : null, $this));
        }
        elseif(substr($name, 0, 6) === 'create')
        {
            if(!ctype_alnum($name))
            {
                throw new Exception('Incorrect element name');
            }
            $class = '\\Core\\Web\\Form\\Element\\'.substr($name, 6);
            if(!class_exists($class))
            {
                throw new Exception('Method ' . $name . ' not exists');
            }

            return (new $class($arguments[0], isset($arguments[1]) ? $arguments[1] : null, $this));
        }

        throw new Exception('Method ' . $name . ' not exists');
    }

    /**
     *
     */
    public function validate()
    {

    }

    public function setAlert($message, $style = null)
    {
        $this->alert = $message;

        if($style !== null)
        {
            $this->setAlertStyle($style);
        }
    }

    public function setAlertStyle($style = null)
    {
        if(in_array($style, array(null, 'danger', 'success', 'info')))
        {
            $this->alert_style = $style;
        }
    }

    public function getAlert()
    {
        return $this->alert;
    }

    public function isAlert()
    {
        return is_string($this->alert);
    }

    public function getAlertStyle()
    {
        return $this->alert_style;
    }

    public function translate($message)
    {
        return \Core\Application::app()->getTranslator()->translate($message);
    }
}