<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 14.08.13
 * Time: 11:18
 */

namespace Main\Model;

use Indrig\Db\TableGateway,
    Zend\Db\Adapter\AdapterInterface,
    Zend\Db\ResultSet\ResultSet,
    Zend\Cache\Storage\StorageInterface,
    Zend\Math\Rand;

class ModuleTable extends TableGateway
{
    public function __construct(AdapterInterface $dbAdapter, StorageInterface $storageAdapter = null)
    {
        //$resultSetPrototype = new ResultSet();

        parent::__construct('module', $dbAdapter, $storageAdapter);

        //$resultSetPrototype->setArrayObjectPrototype(new Setting(array('module', 'name'), $this->table, $this->sql));
        //  $this->resultSetPrototype = $resultSetPrototype;
    }


}