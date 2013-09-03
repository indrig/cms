<?php
/**
 * Клнфигурация адаптеров баз данных
 */
return array(
    'db' => array(
        'adapters' => array(
            'Db\Default' => array(
                'driver'            => 'Pdo',
                'username'          => 'root',
                'password'          => '',
                'dsn'               => 'mysql:dbname=cms;host=127.0.0.1',
                'driver_options'    => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                    PDO::ATTR_PERSISTENT => true
                )
            )
        )
    )
);