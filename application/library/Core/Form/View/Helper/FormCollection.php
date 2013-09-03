<?php
/**
 * User: Igor Bubnevich aka Core
 * Date: 27.08.13
 * Time: 14:36
 */

namespace Core\Form\View\Helper;

use Zend\Form\View\Helper\FormCollection as ZendFormCollection;

class FormCollection extends ZendFormCollection
{
    protected $defaultElementHelper = 'tbformrow';
}