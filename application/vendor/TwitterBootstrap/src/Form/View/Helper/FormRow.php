<?php
namespace TwitterBootstrap\Form\View\Helper;

use Zend\Form\View\Helper\FormRow as ZendFormRow,
    Zend\Form\Element\Button,
    Zend\Form\ElementInterface,
    TwitterBootstrap\Form\Form as TBForm;

class FormRow extends ZendFormRow
{
    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  null|ElementInterface $element
     * @param  null|string           $labelPosition
     * @param  bool                  $renderErrors
     * @param  string|null           $partial
     * @return string|FormRow
     */
    public function __invoke(ElementInterface $element = null, $labelPosition = null, $renderErrors = null, $partial = null, $formType = null)
    {
        if (!$element) {
            return $this;
        }

        if ($labelPosition !== null) {
            $this->setLabelPosition($labelPosition);
        } elseif ($this->labelPosition === null) {
            $this->setLabelPosition(self::LABEL_PREPEND);
        }

        if ($renderErrors !== null) {
            $this->setRenderErrors($renderErrors);
        }

        if ($partial !== null) {
            $this->setPartial($partial);
        }

        return $this->render($element, $formType);
    }
    /**
     * Utility form helper that renders a label (if it exists), an element and errors
     *
     * @param  ElementInterface $element
     * @throws \Zend\Form\Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element, $formType = null)
    {
        switch($formType)
        {
            case TBForm::FORM_TYPE_HORIZONTAL:
                return $this->renderHorizontal($element);
            default:
                return $this->renderDefault($element);
        }

    }

   /**
 * Utility form helper that renders a label (if it exists), an element and errors
 *
 * @param  ElementInterface $element
 * @throws \Zend\Form\Exception\DomainException
 * @return string
 */
    public function renderHorizontal(ElementInterface $element)
    {
        $escapeHtmlHelper    = $this->getEscapeHtmlHelper();
//        $labelHelper         = $this->getLabelHelper();
        $elementHelper       = $this->getElementHelper();
        //$elementErrorsHelper = $this->getElementErrorsHelper();

        $label           = $element->getLabel();


        if (isset($label) && '' !== $label)
        {
            if (null !== ($translator = $this->getTranslator()))
            {
                $label = $translator->translate($label, $this->getTranslatorTextDomain());
            }
        }

        if ($this->partial)
        {
            $vars = array(
                'element'           => $element,
                'label'             => $label,
                'labelAttributes'   => $this->labelAttributes,
                'labelPosition'     => $this->labelPosition,
                'renderErrors'      => $this->renderErrors,
            );

            return $this->view->render($this->partial, $vars);
        }


        $hasError = false;
        $elementErrors = '';
        if ($this->renderErrors)
        {

            $hasError           = sizeof($element->getMessages()) > 0;
            if(sizeof($hasError) > 0)
            {
                $elementErrors .= '<ul class="help-block">';
                foreach($element->getMessages() as $message)
                {
                    $elementErrors .= '<li>'.$message.'</li>';
                }
                $elementErrors .= '</ul>';
            }
           // $elementErrors      = $elementErrorsHelper->render($element);
        }

        $type = $element->getAttribute('type');
        $lg = max(1, min(intval($element->getOption('lg') ? : 9), 9));

        switch($type)
        {
            case 'checkbox':
                $elementContainerClass = 'checkbox';
                $this->labelPosition = self::LABEL_APPEND;
                break;
            default:
               // $elementContainerClass = 'col-lg-'.$lg;
                $newElementClass = ($element->hasAttribute('class') ? $element->getAttribute('class').' ' : '').'form-control';
                $element->setAttribute('class', $newElementClass);
                break;
        }
        $hasLabel = (isset($label) && strlen($label) > 0);

        if($hasLabel)
        {

            $label = $escapeHtmlHelper($label);
            if($element->hasAttribute('id'))
            {
                $labelFor = $element->getAttribute('id');
            }
            else
            {
                $labelFor = 'control-tb-'.$element->getName();
                $element->setAttribute('id', $labelFor);
            }
            $elementString = $elementHelper->render($element);
            switch ($this->labelPosition)
            {
                case self::LABEL_PREPEND:
                    $markup = '<label class="col-lg-3 control-label" for="'.$labelFor.'">' . $label. '</label><div class="col-lg-9"><div class="row"><div class="col-lg-'.$lg.'">' . $elementString.'</div></div>'.$elementErrors.'</div>';
                    break;
                case self::LABEL_APPEND:
                default:
                    $markup = '<div class="col-lg-offset-3 col-lg-'.$lg.'"><div class="'.$elementContainerClass.'"><label>'. $elementString . $label .'</label>'.$elementErrors.'</div></div>';
                    break;
            }

        }
        else
        {
            $elementString = $elementHelper->render($element);
            $markup = '<div class="col-lg-offset-3 col-lg-'.$lg.'">'.$elementString.$elementErrors.'</div>';
        }
        return '  <div class="form-group'.($hasError ? ' has-error' : '').'">'.$markup.'</div>';
    }

    /**
     * Utility form helper that renders a label (if it exists), an element and errors
     *
     * @param  ElementInterface $element
     * @throws \Zend\Form\Exception\DomainException
     * @return string
     */
    public function renderDefault(ElementInterface $element)
    {
        $escapeHtmlHelper    = $this->getEscapeHtmlHelper();
        $labelHelper         = $this->getLabelHelper();
        $elementHelper       = $this->getElementHelper();
        $elementErrorsHelper = $this->getElementErrorsHelper();

        $label           = $element->getLabel();


        if (isset($label) && '' !== $label)
        {
            if (null !== ($translator = $this->getTranslator()))
            {
                $label = $translator->translate($label, $this->getTranslatorTextDomain());
            }
        }




        if ($this->partial)
        {
            $vars = array(
                'element'           => $element,
                'label'             => $label,
                'labelAttributes'   => $this->labelAttributes,
                'labelPosition'     => $this->labelPosition,
                'renderErrors'      => $this->renderErrors,
            );

            return $this->view->render($this->partial, $vars);
        }


        $hasError = false;
        if ($this->renderErrors)
        {
            $hasError           = sizeof($element->getMessages()) > 0;
            $elementErrors      = $elementErrorsHelper->render($element);
        }

        $hasLabel = (isset($label) && strlen($label) > 0);
        $newElementClass = ($element->hasAttribute('class') ? $element->getAttribute('class').' ' : '').'form-control';
        $element->setAttribute('class', $newElementClass);


        if($hasLabel)
        {
            $label = $escapeHtmlHelper($label);
            if($element->hasAttribute('id'))
            {
                $labelFor = $element->getAttribute('id');
            }
            else
            {
                $labelFor = 'control-tb-'.$element->getName();
                $element->setAttribute('id', $labelFor);
            }
            $elementString = $elementHelper->render($element);
            switch ($this->labelPosition)
            {
                case self::LABEL_PREPEND:
                    $markup = '<label for="'.$labelFor.'">' . $label. '</label>' . $elementString .'';
                    break;
                case self::LABEL_APPEND:
                default:
                    $markup = '<label>'. $elementString . $label .'</label>';
                    break;
            }

        }
        else
        {
            $elementString = $elementHelper->render($element);
            $markup = $elementString;
        }
        return '  <div class="form-group'.($hasError ? ' has-error' : '').'">'.$markup.'</div>';
    }
}