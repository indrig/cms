<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 11:34
 */
return array(
    'components' => array(
        'db' => array(
            'driver'    => 'Pdo',
            'username'  => 'root',
            'password'  => '',
            'dsn'       => 'mysql:dbname=cms;host=127.0.0.1',
            'driver_options' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
            ),
        )
    )
);