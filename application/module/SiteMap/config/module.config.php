<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'SiteMap\Controller\Index' => 'Main\Controller\IndexController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'sitemap' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/sitemap',
                    'defaults' => array(
                        'controller' => 'SiteMap\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
);