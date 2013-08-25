<?php
namespace Indrig\Table\View\Helper;

use Indrig\Table\Element\Header as HeaderElement;

class TableHeader extends AbstractHelper
{
    public function __invoke(HeaderElement $header= null)
    {
        if (!$header) {
            return $this;
        }

        return $this->render($header);
    }

    /**
     * Render a form from the provided $form,
     *
     * @param  HeaderElement $form
     * @return string
     */
    public function render(HeaderElement $header)
    {
        $label = $header->getLabel();
        if (isset($label) && '' !== $label) {
            // Translate the label
            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate(
                    $label, $this->getTranslatorTextDomain()
                );
            }
        }

        return '<th'.($header->getSortable() ? ' class="sortable"' : '').'>'. $label. '<span class="order"></span></th>';
    }
}