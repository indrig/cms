<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 31.07.13
 * Time: 15:45
 */
namespace Core\Web\View\Model;

use Core\Application;
use Exception;

class ViewModel implements ModelInterface
{
    protected $variables   = array();
    protected $children    = array();
    protected $file;
    protected $translator;

    public function __construct($variables = null, $options = null)
    {
        if($variables !== null)
        {
            $this->setVariables($variables);
        }
        $this->translator = Application::app()->getTranslator();
    }

    public function setVariable($variable, $value)
    {
        $this->variables[$variable] = $value;
    }

    public function setVariables($variables)
    {
        if(is_array($variables))
        {
            $this->variables = $variables;
        }
        else
        {
            if($variables !== null)
                throw new Exception('Incorrect variables type');
        }
    }

    public function render()
    {
        extract($this->variables);
        if(!is_string($this->file) || strlen($this->file) === 0)
            throw new Exception('Incorrect view file name, must not empty string');
        try {
            ob_start();
            include $this->file;
            $result = ob_get_clean();
        } catch (\Exception $ex) {
            ob_end_clean();
            throw $ex;
        }

        return $result;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function translate($message)
    {
        return $this->translator->translate($message);
    }
}