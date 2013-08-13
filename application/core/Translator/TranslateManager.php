<?php
namespace Core\Translator;

use Core\Base\Plugin;
class TranslateManager extends Plugin
{
    protected $messages = array();
    protected $files = array();
    protected $locate;

    /**
     * Перевод строки
     *
     * @param $message
     * @return mixed
     */
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