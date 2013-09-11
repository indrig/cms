<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Content\Controller\Index' => 'Content\Controller\IndexController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'content' => array(
                'type'      => 'regex',
                'priority'  => -1000,
                'options' => array(
                    'regex' => '/(?<page>[\/a-zA-Z0-9_-]+)',
                    'spec' => '/%page%',
                    'defaults' => array(
                        'controller' => 'Content\Controller\Index',
                        'action' => 'index'
                    )
                ),

            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

);