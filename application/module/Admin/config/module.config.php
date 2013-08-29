<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Setting'  => 'Admin\Controller\SettingController',
            'Admin\Controller\Module'   => 'Admin\Controller\ModuleController',
            'Admin\Controller\Index'   => 'Admin\Controller\IndexController'
        ),
    ),
    //Пути
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'settings' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/settings',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Setting',
                                'action'        => 'index',
                            )
                        )
                    ),
                    'module' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/module[/:action][/:module]',
                            'constraints' => array(
                                'module'    => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'action'    => '[a-zA-Z][a-zA-Z0-9_-]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Module',
                                'action'        => 'index',
                            )
                        )

                    )
                )
            )
        )
    ),
    //  Настройки для навигации
    ///////////////////////////////////////////////////////////////////////////
    'navigation' => array(
        'default' => array(
            'admin' => array(
                'label'     => 'Management',
                'route'     => 'admin',
                'resource'  => 'Admin',
                'privilege' => 'read',
                'pages' => array(
                    array(
                        'label'     => 'Modules',
                        'route'     => 'admin/module',
                        'resource'  => 'Admin',
                        'privilege' => 'setting'
                    ),
                    array(
                        'label'     => 'Settings',
                        'route'     => 'admin/settings',
                        'resource'  => 'Admin',
                        'privilege' => 'setting'
                    )
                )
            )
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);