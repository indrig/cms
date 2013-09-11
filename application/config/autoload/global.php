<?php
return array(
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
            'Zend\Db\Adapter\AdapterAbstractServiceFactory'
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
            'navigation'    => 'Zend\Navigation\Service\DefaultNavigationFactory',
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'error/404'                 => __DIR__ . '/../../view/error/404.phtml',
            'error/index'               => __DIR__ . '/../../view/error/index.phtml',
            'partial/menu'              => __DIR__ . '/../../view/partial/menu.phtml',
            'partial/breadcrumbs'       => __DIR__ . '/../../view/partial/breadcrumbs.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../../template',
            __DIR__ . '/../../view',
        ),
    ),
);
