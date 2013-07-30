<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 15:53
 */

namespace Core\Web;

use \A;

abstract class Controller
{
    /**
     * Кеширует вывод выполнения
     */
    protected function startCache()
    {

    }

    /**
     * Устанавливает шаблон для страницы
     */
    protected function setTemplate($templateName)
    {
        A::app()->template->setTemplate($templateName);
    }


}