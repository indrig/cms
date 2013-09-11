<?php

return array(
    'navigation' => array(
        'default' => array(
            array(
                'label'     => 'Home',
                'route'     => 'home',
                'visible'   => false
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Main\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type'     => 'PhpArray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s/validate_form.php',
            ),
            array(
                'type'     => 'PhpArray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s/global.php',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Main\Controller\Index' => 'Main\Controller\IndexController'
        ),
    ),
    'view_manager' => array(

        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    // Placeholder for console routes
    /*'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    */

);
