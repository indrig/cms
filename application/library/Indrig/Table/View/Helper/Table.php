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

        //Include css and js


        $headerHelper = $this->getView()->TableHeader();
        $tableContent = '';
        $headers = $table->getHeaders();

        $tableContent .= '<thead><tr>';
        foreach($headers as $header)
        {
            $tableContent .= $headerHelper($header);
        }
        $tableContent .= '</tr></thead>';

        return $this->openTag($table) . $tableContent . $this->closeTag($table);
    }

    /**
     * Generate an opening form tag
     *
     * @param  null|TableElement $form
     * @return string
     */
    public function openTag(TableElement $table)
    {

        return '<table class="table" id="'.$table->getId().'">';
    }

    /**
     * Generate a closing form tag
     *
     * @return string
     */
    public function closeTag(TableElement $table)
    {
        $content = '</table>';
        $content .= '<script>';
        $content .= '$(document).ready(function() {$(\'#'.$table->getId().'\').dataTable();} );';
        $content .= '</script>';

        //Add JS and CSS
        $this->getView()->headLink()->appendStylesheet($this->getView()->basePath().'/assets/css/jquery.dataTables.css');
        $this->getView()->headScript()->appendFile($this->getView()->basePath().'/assets/js/jquery.dataTables.js');
        return $content;
    }
}