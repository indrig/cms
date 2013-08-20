<?php
error_reporting(E_ALL | E_NOTICE);
chdir(__DIR__);
include  'library/Zend/Loader/AutoloaderFactory.php';

if (!class_exists('Zend\Loader\AutoloaderFactory'))
{
     throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
}

Zend\Loader\AutoloaderFactory::factory(
	array(
		'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf'   => true,
                'namespaces'        => array(
                    'Indrig'        => 'library/Indrig'
                )
        )
    )
);
