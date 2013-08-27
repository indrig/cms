<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 27.08.13
 * Time: 14:36
 */

namespace Indrig\Form\View\Helper;

use Zend\Form\View\Helper\FormCollection as ZendFormCollection;

class FormCollection extends ZendFormCollection
{
    protected $defaultElementHelper = 'tbformrow';
}