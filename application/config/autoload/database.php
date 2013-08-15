<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 14.08.13
 * Time: 11:11
 */
return array(
    'db' => array(
        'driver'            => 'Pdo',
        'username'          => 'root',
        'password'          => '',
        'dsn'               => 'mysql:dbname=cms;host=localhost',
        'driver_options'    => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
);