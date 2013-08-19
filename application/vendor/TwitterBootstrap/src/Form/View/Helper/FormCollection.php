<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Indrig
 * Date: 19.08.13
 * Time: 21:49
 * To change this template use File | Settings | File Templates.
 */
namespace TwitterBootstrap\Form\View\Helper;

use Zend\Form\View\Helper\FormCollection as ZendFormCollection,
    RuntimeException,
 Zend\Form\Element,
 Zend\Form\ElementInterface,
 Zend\Form\Element\Collection as CollectionElement,
 Zend\Form\FieldsetInterface,
 Zend\View\Helper\AbstractHelper as BaseAbstractHelper;

class FormCollection extends ZendFormCollection
{
    protected $defaultElementHelper = 'TBFormRow';

    /**
     * Invoke helper as function
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @param  bool                  $wrap
     * @param  int                  $formType
     * @return string|FormCollection
     */
    public function __invoke(ElementInterface $element = null, $wrap = true, $formType = null)
    {
        if (!$element) {
            return $this;
        }

        $this->setShouldWrap($wrap);

        return $this->render($element, $formType);
    }

    /**
     * Render a collection by iterating through all fieldsets and elements
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element, $formType = null)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $markup           = '';
        $templateMarkup   = '';
        $escapeHtmlHelper = $this->getEscapeHtmlHelper();
        $elementHelper    = $this->getElementHelper();
        $fieldsetHelper   = $this->getFieldsetHelper();

        if ($element instanceof CollectionElement && $element->shouldCreateTemplate()) {
            $templateMarkup = $this->renderTemplate($element);
        }

        foreach ($element->getIterator() as $elementOrFieldset)
        {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $fieldsetHelper($elementOrFieldset);
            } elseif ($elementOrFieldset instanceof ElementInterface) {

                $markup .= $elementHelper($elementOrFieldset, null, null, null, $formType);
            }
        }

        // If $templateMarkup is not empty, use it for simplify adding new element in JavaScript
        if (!empty($templateMarkup)) {
            $markup .= $templateMarkup;
        }

        // Every collection is wrapped by a fieldset if needed
        if ($this->shouldWrap) {
            $label = $element->getLabel();

            if (!empty($label)) {

                if (null !== ($translator = $this->getTranslator())) {
                    $label = $translator->translate(
                        $label, $this->getTranslatorTextDomain()
                    );
                }

                $label = $escapeHtmlHelper($label);

                $markup = sprintf(
                    '<fieldset><legend>%s</legend>%s</fieldset>',
                    $label,
                    $markup
                );
            }
        }

        return $markup;
    }
}