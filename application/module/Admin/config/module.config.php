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
                    'system' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/system',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\System',
                                'action'        => 'index',
                            )
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
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/module',
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Module',
                                        'action'        => 'index',
                                    )
                                )
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
                    'system' => array(
                        'label'     => 'System',
                        'resource'  => 'Admin',
                        'privilege' => 'setting',
                        'route'    => 'admin/system',
                        'pages' => array(
                            array(
                                'label'     => 'Modules',
                                'route'     => 'admin/system/module',
                            ),
                            array(
                                'label'     => 'Settings',
                                'route'     => 'admin/system/settings',
                            )
                        )
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