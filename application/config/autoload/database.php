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
                'dsn'               => 'mysql:dbname=cms;host=localhost',
                'driver_options'    => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                )
            )
        )
    )
);