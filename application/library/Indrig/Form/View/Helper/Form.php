<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 27.08.13
 * Time: 14:36
 */

namespace Indrig\Form\View\Helper;

use Zend\Form\View\Helper\Form as ZendForm,
    Zend\Form\FormInterface;

class Form extends ZendForm
{
    const FORM_TYPE_HORIZONTAL = 'form-horizontal';
    const FORM_TYPE_VERTICAL   = 'form-vertical';
    const FORM_TYPE_INLINE     = 'form-inline';
    const FORM_TYPE_SEARCH     = 'form-search';

    /**
     * Mapping of form types to form css classes
     * @var array
     */
    protected static $formTypeMap      = array(
        self::FORM_TYPE_HORIZONTAL => 'form-horizontal',
        self::FORM_TYPE_VERTICAL   => 'form-vertical',
        self::FORM_TYPE_INLINE     => 'form-inline',
        self::FORM_TYPE_SEARCH     => 'form-search',
    );


    public function __invoke(FormInterface $form = null, $formType = null)
    {
        if (!$form)
        {
            return $this;
        }

        $form->setOptions('tb_render_type', $formType);
        return $this->render($form);
    }

    public function openTag(FormInterface $form = null, $formType = null)
    {
        $formTypeClass = isset(self::$formTypeMap[$formType]) ? self::$formTypeMap[$formType] : 'form-horizontal';

        if ($form)
        {
            $class = $form->hasAttribute('class') ? $form->getAttribute('class').' '.$formTypeClass : $formTypeClass;
            $form->setAttribute('class', $class);

        }
        return parent::openTag($form);
    }
}