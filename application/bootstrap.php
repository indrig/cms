<?php
define('IN_CMS', true);

error_reporting(E_ALL | E_NOTICE);
//Глобпльные настройки
//define('CMS_ENABLE_EXCEPTION_HANDLER',  true);  //Перехватовать CMS исключения
//define('CMS_ENABLE_ERROR_HANDLER',      true);  //Перехватывать CMS ошибки

//Подключение автозагрущика
include __DIR__.'/core/AutoLoader.php';

//Иницилизация автозагрущика
\Core\AutoLoader::init();

if(!class_exists('A'))
{
    class A extends \Core\Application
    {

    }
}

