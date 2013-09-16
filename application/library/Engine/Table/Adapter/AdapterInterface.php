<?php
/**
 * User: Igor Bubnevich aka Core
 * Date: 22.08.13
 * Time: 10:27
 */
namespace Engine\Table\Adapter;

interface AdapterInterface
{
    public function getData();
    public function setItemCountPerPage($i);
    public function setCurrentPageNumber($i);
    public function getItemCountPerPage();
    public function getCurrentPageNumber();
    public function getTotalItemCount();
}