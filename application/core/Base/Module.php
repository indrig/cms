<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 25.07.13
 * Time: 12:08
 */

namespace Core\Base;

abstract class Module
{
    private $_app;

    public function __construct(Application $app)
    {
        $this->_app = $app;
    }

    /**
     * Возврашает указатель на класс приложения
     *
     * @return Application
     */
    protected function app()
    {
        return $this->_app;
    }
}
