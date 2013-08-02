<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Indrig
 * Date: 02.08.13
 * Time: 20:05
 * To change this template use File | Settings | File Templates.
 */
namespace Main\Auth;

use Core\Web\Application,
    Core\Web\Auth\AdapterInterface;

class Adapter implements AdapterInterface
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function authenticate()
    {

    }

    public function login()
    {

    }

    public function logout()
    {

    }
}