<?php
namespace Indrig\Table\View\Helper;

use Indrig\Table\Table as TableElement;

class Table extends AbstractHelper
{
    public function __invoke(TableElement $table= null)
    {
        if (!$table) {
            return $this;
        }

        return $this->render($table);
    }

    /**
     * Render a form from the provided $form,
     *
     * @param  TableElement $form
     * @return string
     */
    public function render(TableElement $table)
    {
        if (method_exists($table, 'prepare'))
        {
            $table->prepare();
        }

        $headerHelper = $this->getView()->TableHeader();
        $tableContent = '';
        $headers = $table->getHeaders();

        $tableContent .= '<tr>';
        foreach($headers as $header)
        {
            $tableContent .= $headerHelper($header);
        }
        $tableContent .= '</tr>';

        return $this->openTag($table) . $tableContent . $this->closeTag();
    }

    /**
     * Generate an opening form tag
     *
     * @param  null|TableElement $form
     * @return string
     */
    public function openTag(TableElement $form = null)
    {
        return '<table class="table">';
    }

    /**
     * Generate a closing form tag
     *
     * @return string
     */
    public function closeTag()
    {
        return '</table>';
    }
}