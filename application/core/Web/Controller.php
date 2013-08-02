<?php
namespace Core\Web;


abstract class Controller
{
    protected $_app;
    public function __construct(Application $app)
    {
        $this->_app = $app;
    }
    /**
     * Кеширует вывод выполнения
     */
    protected function startCache()
    {

    }

    /**
     * Устанавливает шаблон для страницы
     */
    protected function setTemplate($templateName)
    {
        //A::app()->template->setTemplate($templateName);
    }

    protected function app()
    {
        return $this->_app;
    }

    /**
     * @param string $modelName
     */
    public function table($modelName = '', $moduleName = null)
    {

    }
}