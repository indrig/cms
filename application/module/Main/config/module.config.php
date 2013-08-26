<?php

return array(
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

    'service_manager' => array(
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
            'navigation'    => 'Zend\Navigation\Service\DefaultNavigationFactory',

        ),
    ),

    'translator' => array(
        'locale' => 'ru',
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
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'             => __DIR__ . '/../view/layout/layout.phtml',
            'main/index/index'          => __DIR__ . '/../view/main/index/index.phtml',
            'error/404'                 => __DIR__ . '/../view/error/404.phtml',
            'error/index'               => __DIR__ . '/../view/error/index.phtml',
            'partial/navbar'            => __DIR__ . '/../view/partial/navbar.phtml'
        ),
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
