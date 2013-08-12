<?php
namespace Core\Web\Form\View;

use Exception;

class Label extends AbstractView
{
    protected $type;

    /**
     * @param array $attributes
     * @param string $content
     * @return string
     * @throws \Exception
     */
    public function render($attributes, $content)
    {
        return $this->openTag($attributes).$content.$this->closeTag();
    }

    public function openTag($attributes)
    {
        return sprintf('<label %s>', $this->createAttributesString($attributes));
    }

    public function closeTag()
    {
        return '</label>';
    }
}