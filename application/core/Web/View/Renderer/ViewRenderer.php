<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 31.07.13
 * Time: 15:51
 */
namespace Core\Web\View\Renderer;

use Core\Web\Application,
    Core\Web\View\Model\ModelInterface;

class ViewRenderer implements RendererInterface
{
    private $_template;
    private $_content;
    private $_app;
    private $_title;

    public function __construct(Application $app)
    {
        $this->_app = $app;
    }

    /**
     *
     * @return Application
     */
    protected function app()
    {
        return $this->_app;
    }

    public function render(ModelInterface $model)
    {

        $this->_content = $model->render();

        $renderer = $this->app()->getRenderer();
        $templateFolder = $renderer->getTemplateFolder();
        try {
            ob_start();
            include $templateFolder.'/template.phtml';
            $result = ob_get_clean();
        } catch (\Exception $ex) {
            ob_end_clean();
            throw $ex;
        }

        echo $result;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    public function getContent()
    {
        return $this->_content;
    }

    public function getTitle()
    {
        return $this->app()->getRenderer()->getTitle();
    }
}