<?php
namespace Core\Table\View\Helper;

use Core\Table\Table as TableElement;

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

        $tableContent .= '<tr>';
        foreach($headers as $header)
        {
            $tableContent .= $headerHelper($header);
        }
        $tableContent .= '</tr>';


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
        $content = '<div id="'.$id.'_wrapper" class="table-wrapper">';
        $content .= '<div class="row">';
        $content .= '<div class="col-lg-8">';
        $content .= '</div>';
        $content .= '<div class="col-lg-4">';
        $content .= '<input class="form-control" placeholder="'.$this->getTranslator()->translate('Search').'..." name="'.$id.'_search" />';
        $content .= '</div>';
        $content .= '</div>';
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
        $id = $table->getId();

        $content = '</table>';
        $content .= '<div class="row">';

        $content .= '<div class="col-lg-6">';
        $content .= '<ul class="pagination"></ul>';
        $content .= '</div>';

        $content .= '<div class="col-lg-4">';
        $content .= '</div>';

        $content .= '<div class="col-lg-2">';
        $content .= '<select class="form-control per-page">';
        $content .= '<option value="10">10</option>';
        $content .= '<option value="25">25</option>';
        $content .= '<option value="50">50</option>';
        $content .= '<option value="100">100</option>';
        $content .= '<option value="250">250</option>';
        $content .= '</select>';
        $content .= '</div>';

        $content .= '</div>';
        $content .= '</div>';
        $content .= '<script>';
        $content .= '$(document).ready(function() {$(\'#'.$table->getId().'\').table(
        {
            "dataUrl": "'.$table->getRequest()->getUriString().'"
        }
        );} );';
        $content .= '</script>';

        //Add JS and CSS
        $this->getView()->headLink()->appendStylesheet($this->getView()->basePath().'/assets/css/jquery.table.css');
        $this->getView()->headScript()->appendFile($this->getView()->basePath().'/assets/js/jquery.table.js');
        return $content;
    }

    /**
     * @param TableElement $table
     * @param null|\Zend\Http\Response $response
     * @return string
     */
    public function renderContent(TableElement $table, $response = null)
    {
        $type = $table->getRenderType();
        /**
         * @var \Zend\Paginator\Paginator $data
         */

        $data = $table->getData();
        $a = array();

        $keys = array_keys($table->getHeaders());
        $cells = $table->getCells();


        foreach($data as $row)
        {
            $tmp = array();
            foreach($keys as $key)
            {
                if(isset($cells[$key]))
                {
                    $tmp[] = $this->getView()->tableCell()->renderContent($cells[$key], $row);
                }
                else
                {
                    $tmp[] = $row->$key;
                }
            }
            $a[] = $tmp;
        }

        $content = json_encode(array(
            'data'              => $a,
            'total'             => $table->getAdapter()->getTotalItemCount(),
            'page'              => $table->getAdapter()->getCurrentPageNumber(),
            'per_page'          => $table->getAdapter()->getItemCountPerPage(),

        ));


        if($response !== null)
        {
            return $response->setContent($content);
        }

        return $content;
    }
}