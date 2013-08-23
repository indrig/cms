<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 22.08.13
 * Time: 10:27
 */
namespace Indrig\Table\Adapter;

interface AdapterInterface
{
    public function getData();
    public function setItemCountPerPage($i);
    public function setCurrentPageNumber($i);
    public function getItemCountPerPage();
    public function getCurrentPageNumber();
}