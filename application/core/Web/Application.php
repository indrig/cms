<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 10:51
 */
namespace Core\Web;

use Core\Event\Event;

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
                $this->event('onControllerCreated', new Event($this, array('controller' => $this->_controller)));

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
                }else{
                    //Нету метода такого в контролре
                    $this->getRenderer()->renderError(404);
                }
            }
            else
            {
                //Конролеер левый, не контроллер он
                $this->getRenderer()->renderError(404);
            }
        }
        else
        {
            //Нету такого маршрута
            $this->getRenderer()->renderError(404);
        }
    }

    /**
     * Регистрация необходимых компонентов
     */
    protected function registerCorePlugins()
    {
        parent::registerCorePlugins();

        //
        $this->setPlugin('translator', array('class' => '\Core\Translator\TranslateManager'));

        //Управление маршрутами
        $this->setPlugin('router', array('class' => '\Core\Web\Router\RouterManager'));

        //Управление навигация
        $this->setPlugin('navigation', array('class' => '\Core\Web\Navigation\NavigationManager'));

        //Запросы
        $this->setPlugin('request', array('class' => '\Core\Web\Request'));

        //Сессии
        $this->setPlugin('session', array('class' => '\Core\Web\Session'));

        //Шаблонизатор
        $this->setPlugin('renderer', array('class' => '\Core\Web\View\ViewManager'));

        //Сессии
        $this->setPlugin('auth', array('class' => '\Core\Web\AuthManager'));
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
     * @return \Core\Translator\TranslateManager
     */
    public function getTranslator()
    {
        return $this->getPlugin('translator');
    }


    /**
     * Обработчик исключений
     *
     * @param $exception
     */
    public function handleException($exception)
    {
        parent::handleException($exception);

        $this->getRenderer()->renderError('exception', array(
            'exception'      => $exception,
        ));
        $this->finish();
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
        parent::handleError($code, $message, $file, $line);
        $backtrace = array_reverse(debug_backtrace(false));

        $this->getRenderer()->renderError('error', array(
            'code'      => $code,
            'message'   => $message,
            'file'      => $file,
            'line'      => $line,
            'backtrace' => $backtrace
        ));
        $this->finish();
    }
}