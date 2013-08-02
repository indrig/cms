<?php
namespace Main;

use Core\AutoLoader;
use Core\Base\Application;
use Main\Model\UserTable;


class Module extends \Core\Base\Module
{
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->createRoutes();
        $this->registerTables();

        //$app->getDB()->query("SELECT * FROM user");

        AutoLoader::getInstance()->registerNamespace('Main', __DIR__.'/sources');

        /**
         * @var UserTable $userTable
         */
        $userTable = $app->getDB()->table('user');
        var_dump($userTable->test());
    }
    /**
     * Созданием маршрутов
     */
    private function createRoutes()
    {
        $router = $this->app()->getRouter();

        $router->addRoute('user',
            array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        'controller' => 'Main\\Controller\\UserController',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'admin' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/admin',
                            'defaults' => array(
                                'controller' => 'Main\\Controller\\UserAdminController',
                                'action' => 'index'
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'edit' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/edit',
                                    'defaults' => array(
                                        'action' => 'edit'
                                    )
                                )
                            )
                        )
                    )
                )
            )
        );

        $router->addRoute('login',
            array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'Main\\Controller\\UserController',
                        'action'     => 'login',
                    ),
                )));
        $router->addRoute('signup',
            array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/signup',
                    'defaults' => array(
                        'controller' => 'Main\\Controller\\UserController',
                        'action'     => 'signup',
                    ),
                )));
    }

    /**
     * Регистрация классов для таблиц
     */
    private function registerTables()
    {
        $db = $this->app()->getDB();

        $db->registerTable('user', '\\Main\\Model\\UserTable');

    }
}