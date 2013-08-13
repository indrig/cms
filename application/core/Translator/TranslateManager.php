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
    protected $messages = array();
    protected $files = array();
    protected $locate;

    public function translate($message)
    {
        return isset($this->messages[$message]) ? $this->messages[$message] : $message;
    }

    /**
     * Добавления файла перевода
     * @param $filename
     */
    public function addTranslationFile($filename)
    {

    }
}