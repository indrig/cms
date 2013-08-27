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

    'translator' => array(
        'locale' => 'ru'
    )
);
