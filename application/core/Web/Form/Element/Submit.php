<?php
namespace Core\Web\Form\Element;

use Core\Web\Form\AbstractElement,
    Core\Web\Form\View;

class Submit extends Button
{
    protected $attributes = array(
        'type' => 'submit'
    );

    protected $style = 'primary';
}