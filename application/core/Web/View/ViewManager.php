<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 31.07.13
 * Time: 16:13
 */
namespace Core\Web\View;

use Exception,
    Core\Web\Application,
    Core\Base\Plugin,
    Core\Web\View\Model\ModelInterface,
    Core\Web\View\Model\ViewModel,
    Core\Web\View\Model\JsonModel,
    Core\Web\View\Renderer\ViewRenderer;

class ViewManager extends Plugin
{
    private $_folder;
    private $_view_folder;
    private $_template = 'default';
    public function __construct($config, Application $app)
    {
        parent::__construct($config, $app);
        $this->_folder = IsSet($this->_config['folder']) ? $this->_config['folder'] : realpath(__DIR__.'/../../../templates');
        $this->_view_folder = IsSet($this->_config['view_folder']) ? $this->_config['view_folder'] : realpath(__DIR__.'/../../../view');
    }

    /**
     * @param string $name
     */
    public function setTemplate($name)
    {
        $this->_template = $name;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * Возврашает полный путь к котологу с файлом шаблона
     * @return string
     */
    public function getTemplateFolder()
    {
        return $this->_folder.'/'.$this->_template;
    }

    /**
     * Возврашает полный путь к котологу с файлом шаблона
     * @return string
     */
    public function getViewFolder()
    {
        return $this->_view_folder;
    }

    /**
     * @param ModelInterface $model
     * @throws \Exception
     */
    public function render(ModelInterface $model)
    {
        $renderer = null;
        if($model instanceof ViewModel)
        {
            $renderer = new ViewRenderer($this->app());
            $renderer->render($model);
        }
        else
        {
            throw new Exception('Unknown model for ViewManager');
        }
    }

    public function renderError($file, $variables = null)
    {
        $model = new ViewModel($variables);
        $model->setFile($this->_view_folder.'/error/'.$file.'.phtml');
        $renderer = new ViewRenderer($this->app());
        $renderer->render($model);
    }
}