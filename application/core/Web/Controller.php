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
     * @return \Core\Db\TableGateway\AbstractTableGateway
     */
    public function table($name)
    {
        return $this->app()->getDB()->table($name);
    }

    public function translate($message)
    {
        return $this->app()->getTranslator()->translate($message);
    }
}