<?php
namespace Core\Web;


abstract class Controller
{
    protected $app;
    protected $moduleName;
    protected $controllerClassName;
    /**
     * @var \Core\Translator\TranslateManager
     */
    private $translator;
    /**
     * Конструктор класса
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app                  = $app;
        $this->translator           = $app->getTranslator();
        $this->controllerClassName  = get_called_class();
        $this->moduleName           = substr($this->controllerClassName, 0, strpos($this->controllerClassName, '\\'));
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
        //$this->app()->get->setTemplate($templateName);
    }

    /**
     * @return Application
     */
    protected function app()
    {
        return $this->app;
    }

    /**
     * @param string $modelName
     * @return \Core\Db\TableGateway\AbstractTableGateway
     */
    public function table($name)
    {
        return $this->app()->getDB()->table($name);
    }

    /**
     * Перевод строки
     * @param string $message Сообщение для перевода
     * @return string
     */
    public function translate($message)
    {
        return $this->translator->translate($message);
    }

    /**
     * Получение имени модуля
     *
     * @return string
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * @param string $action
     * @return string
     */
    public function getDefaultViewFile($action)
    {

    }
}