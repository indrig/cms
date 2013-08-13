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
    private $folder;
    private $view_folder;
    private $template = 'default';
    private $title = '';
    public function __construct($config, Application $app)
    {
        parent::__construct($config, $app);
        $this->folder = IsSet($this->config['folder']) ? $this->config['folder'] : realpath(__DIR__.'/../../../templates');
        $this->view_folder = IsSet($this->config['view_folder']) ? $this->config['view_folder'] : realpath(__DIR__.'/../../../view');
    }

    /**
     * @param string $name
     */
    public function setTemplate($name)
    {
        $this->template = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Возврашает полный путь к котологу с файлом шаблона
     * @return string
     */
    public function getTemplateFolder()
    {
        return $this->folder.'/'.$this->template;
    }

    /**
     * Возврашает полный путь к котологу с файлом шаблона
     * @return string
     */
    public function getViewFolder()
    {
        return $this->view_folder;
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
        $model->setFile($this->view_folder.'/error/'.$file.'.phtml');
        $renderer = new ViewRenderer($this->app());
        $renderer->render($model);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
}