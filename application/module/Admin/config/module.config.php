<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Setting' => 'Admin\Controller\SettingController'
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
                'pages' => array(
                    array(
                        'label'     => 'Settings',
                        'route'     => 'admin/settings',
                        'resource'  => 'Admin'
                    )
                )
            )
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);