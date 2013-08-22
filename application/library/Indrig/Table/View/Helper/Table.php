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

        $data = $table->getData();
      //  var_dump($data);
        foreach($data as $v)
        {
            //$tableContent .= '<tr><td>'.$v->id.'</td><td>'.$v->login.'</td></tr>';
        }
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
        $id = $table->getId();
        $content = '<div id="'.$id.'_wrapper">';
        $content .= '<div class="row">10</div>';
        $content .= '<table class="table table-striped table-hover table-bordered" id="'.$id.'">';
        $content .= '';
        return $content;
    }

    /**
     * Generate a closing form tag
     *
     * @return string
     */
    public function closeTag(TableElement $table)
    {
        $content = '</table>';
        $content .= '</div>';
        $content .= '<script>';
        $content .= '$(document).ready(function() {$(\'#'.$table->getId().'\').table(
        {
            "bServerSide": true,
            "bProcessing": true,
            //"iTotalRecords": 0,
            "sServerMethod": "POST",
            "sAjaxSource": "'.$table->getRequest()->getUriString().'"
        }
        );} );';
        $content .= '</script>';

        //Add JS and CSS
        $this->getView()->headLink()->appendStylesheet($this->getView()->basePath().'/assets/css/jquery.dataTables.css');
        $this->getView()->headScript()->appendFile($this->getView()->basePath().'/assets/js/jquery.table.js');
        return $content;
    }
}