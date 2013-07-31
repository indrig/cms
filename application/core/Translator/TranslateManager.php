<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Indrig
 * Date: 31.07.13
 * Time: 19:24
 * To change this template use File | Settings | File Templates.
 */
namespace Core\Translator;

use Core\Base\Plugin;
class TranslateManager extends Plugin
{
    protected $_messages = array();
    protected $_files = array();
    protected $_locate;

    public function translate($message)
    {

    }
}