<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 31.07.13
 * Time: 15:46
 */
namespace Core\Web\View\Model;

interface ModelInterface
{
    public function __construct($variables = null, $options = null);
    public function render();

}