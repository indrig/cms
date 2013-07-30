<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 10:51
 */
namespace Core\Web;

class Application extends \Core\Base\Application
{
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

        $router->addRoute('test',
            array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/test',
                    'defaults' => array(
                        'controller' => 'bar-index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'rss' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/rss',
                            'defaults' => array(
                                'action' => 'rss'
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'subrss' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/sub',
                                    'defaults' => array(
                                        'action' => 'subrss'
                                    )
                                )
                            )
                        )
                    )
                )
            )
        );

       // var_dump($router->getRoutes());

        $macth = $router->match($this->getRequest());
        var_dump($macth);
       // $route=$this->getUrlManager()->parseUrl($this->getRequest());
        //var_dump($macth);
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
        $this->setPlugin('template', array('class' => '\Core\Web\Template'));
    }

    /**
     * @return UrlManager
     */
    public function getUrlManager()
    {
        return $this->getPlugin('urlManager');
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
}