<?php
/**
 * User: Igor Bubnevich aka Core
 * Date: 22.08.13
 * Time: 10:30
 */

namespace Core\Table\Adapter;

use Zend\Db\TableGateway\TableGateway,
    Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\DbTableGateway as DbTableGatewayPaginator;

class DbTableGateway implements AdapterInterface
{
    protected $paginator;
    protected $tableGateway;

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
        return $paginator->getCurrentItems();
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
         //   $this->paginator->setItemCountPerPage($this->itemCountPerPage);
         //   $this->paginator->setCurrentPageNumber($this->currentPageNumber);
        }
        return $this->paginator;
    }

    /**
     * @param int $i
     * @return $this
     */
    public function setItemCountPerPage($i)
    {
        $this->getPaginator()->setItemCountPerPage($i);
        return $this;
    }

    /**
     * @param int $i
     * @return $this
     */
    public function setCurrentPageNumber($i)
    {
        $this->getPaginator()->setCurrentPageNumber($i);
        return $this;
    }
    /**
     * @param Paginator $paginator
     */
    public function setPaginator(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function getItemCountPerPage()
    {
        return $this->getPaginator()->getItemCountPerPage();
    }

    public function getCurrentPageNumber()
    {
        return $this->getPaginator()->getCurrentPageNumber();
    }

    public function getTotalItemCount()
    {
        return $this->getPaginator()->getTotalItemCount();
    }
}
