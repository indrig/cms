<?php
namespace TwitterBootstrap\Form;

use Zend\Form\Form as ZendForm;

class Form extends ZendForm
{
    const FORM_TYPE_HORIZONTAL = 'form-horizontal';
    const FORM_TYPE_VERTICAL   = 'form-vertical';
    const FORM_TYPE_INLINE     = 'form-inline';
    const FORM_TYPE_SEARCH     = 'form-search';
}