<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 22.08.13
 * Time: 10:30
 */

namespace Indrig\Table\Adapter;

use Zend\Db\TableGateway\TableGateway,
    Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\DbTableGateway as DbTableGatewayPaginator;

class DbTableGateway implements AdapterInterface
{
    protected $paginator;
    protected $tableGateway;
    protected $itemCountPerPage = 10;
    protected $currentPageNumber = 1;

    public function __construct(TableGateway $tableGateway = null, $where = null, $order = null)
    {
        if($tableGateway != null)
            $this->setTableGateway($tableGateway);
    }

    public function setTableGateway($tableGateway)
    {
        $this->tableGateway = $tableGateway;
        return $this;
    }

    /**
     * @return TableGateway|null
     */
    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    public function getData()
    {
        $paginator = $this->getPaginator();
        return $paginator;
    }

    /**
     *
     * @return \Zend\Paginator\Paginator
     */
    public function getPaginator()
    {
        if (!$this->paginator)
        {
            $adapter = new DbTableGatewayPaginator($this->getTableGateway());
            $this->paginator = new Paginator($adapter);
            //$this->initQuery();
            //$this->initPaginator();
            $this->paginator->setItemCountPerPage($this->itemCountPerPage);
            $this->paginator->setCurrentPageNumber($this->currentPageNumber);
        }
        return $this->paginator;
    }

    /**
     * @param int $i
     * @return $this
     */
    public function setItemCountPerPage($i)
    {
        $this->itemCountPerPage = $i;
        return $this;
    }

    /**
     * @param int $i
     * @return $this
     */
    public function setCurrentPageNumber($i)
    {
        $this->currentPageNumber = $i;
        return $this;
    }
    /**
     * @param Paginator $paginator
     */
    public function setPaginator(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function getItemCountPerPage($i)
    {
        $this->itemCountPerPage;
    }

    public function getCurrentPageNumber($i)
    {
        return $this->currentPageNumber;
    }
}
