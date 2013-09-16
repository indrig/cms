<?php
namespace Engine\Table\View\Helper;

use Engine\Table\Element\Cell;

class TableCell extends AbstractHelper
{
    public function __invoke(Cell $cell= null, $row = null)
    {
        if (!$cell)
        {
            return $this;
        }

        return $this->render($cell, $row);
    }

    public function render(Cell $cell, $row)
    {
        return $this->openTag($cell).$this->renderContent($cell, $row).$this->closeTag();
    }

    public function renderContent(Cell $cell, $row)
    {
        return call_user_func_array($cell->getRender(), array($row, $this));
    }

    public function openTag(Cell $cell)
    {
        return '<tr>';
    }

    public function closeTag()
    {
        return '</tr>';
    }
}