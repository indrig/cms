<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 12:20
 */
namespace Core\Web;

use Core\Base\Component;

class Template extends Component
{
    protected $_templateName    = 'default';
    protected $_folder;
    protected $_config;

    public function __construct($config)
    {
        if(IsSet($config['folder']) && is_string($config['folder']))
            $this->_folder = $config['folder'];
    }

    public function __toString()
    {
        include $this->_folder.$this->_templateName.'/template.php';
        return '';
    }
}