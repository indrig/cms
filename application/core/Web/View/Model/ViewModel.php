<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 31.07.13
 * Time: 15:45
 */
namespace Core\Web\View\Model;

use Exception;

class ViewModel implements ModelInterface
{
    protected $_variables   = array();
    protected $_children    = array();
    protected $_file;

    public function __construct($variables = null, $options = null)
    {
        if(is_array($variables))
        {
           $this->_variables = $variables;
        }
        else
        {
            if($variables !== null)
                throw new Exception('Incorrect variables type');
        }
    }

    public function render()
    {
        extract($this->_variables);
        if(!is_string($this->_file) || strlen($this->_file) === 0)
            throw new Exception('Incorrect view file name, must not empty string');
        try {
            ob_start();
            include $this->_file;
            $result = ob_get_clean();
        } catch (\Exception $ex) {
            ob_end_clean();
            throw $ex;
        }

        return $result;
    }

    public function setFile($file)
    {
        $this->_file = $file;
    }
}