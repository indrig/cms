<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 10:51
 */
namespace Core\Web;

class Application extends \Core\Base\Application
{
    protected $_controller;
    /**
     * @param $config   файл конфигурации
     */
    public function __construct($config)
    {
        parent::__construct($config);
    }

    /**
     *
     */
    protected function processRequest()
    {
        $router = $this->getRouter();

        $match = $router->match($this->getRequest());
        if($match !== null)
        {
            $params = $match->getParams();
            if(!IsSet($params['action']))
                $params['action'];
            if(is_subclass_of($params['controller'], '\Core\Web\Controller'))
            {
                $this->_controller = new $params['controller']($this);
                $methodName = 'action'.$params['action'];
                if(method_exists($this->_controller, $methodName))
                {
                    $controllerResult = call_user_func_array(array($this->_controller, $methodName), array());
                    if($controllerResult !== false)
                    {
                        //Используем по умолчанию HTML вывод
                        if(is_array($controllerResult) || $controllerResult === null)
                        {
                            $controllerResult = new View\Model\ViewModel($controllerResult);
                        }
                        $this->getRenderer()->render($controllerResult);
                    }
                }
            }
        }
        else
        {

            $this->getRenderer()->renderError(404);
        }
    }

    /**
     * Регистрация необходимых компонентов
     */
    protected function registerCoreComponents()
    {
        parent::registerCoreComponents();

        //Управление маршрутами
        $this->setPlugin('router', array('class' => '\Core\Web\Router\RouterManager'));

        //Запросы
        $this->setPlugin('request', array('class' => '\Core\Web\Request'));

        //Сессии
        $this->setPlugin('session', array('class' => '\Core\Web\Session'));

        //Шаблонизатор
        $this->setPlugin('renderer', array('class' => '\Core\Web\View\ViewManager'));
    }


    public function getRequest()
    {
        return $this->getPlugin('request');
    }

    /**
     * @return \Core\Web\Router\RouterManager
     */
    public function getRouter()
    {
        return $this->getPlugin('router');
    }

    /**
     * @return \Core\Web\View\ViewManager
     */
    public function getRenderer()
    {
        return $this->getPlugin('renderer');
    }

    /**
     * Обработчик исключений
     *
     * @param $exception
     */
    public function handleException($exception)
    {
        $model = new View\Model\ViewModel(array('exception' => $exception));
        $this->getRenderer()->render($model);
    }

    /**
     * Обрабочик ошибок
     *
     * @param $code
     * @param $message
     * @param $file
     * @param $line
     */
    public function handleError($code, $message, $file, $line)
    {
        return true;
        if($code & error_reporting())
        {

        }
    }
}