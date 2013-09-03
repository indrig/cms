<?php
/**
 * User: Igor Bubnevich aka Core
 * Date: 14.08.13
 * Time: 11:18
 */

namespace Main\Model;

use Core\Db\TableGateway,
    Zend\Db\Adapter\AdapterInterface,
    Zend\Db\ResultSet\ResultSet,
    Zend\Cache\Storage\StorageInterface,
    Zend\Math\Rand;

class ModuleTable extends TableGateway
{
    public function __construct(AdapterInterface $dbAdapter, StorageInterface $storageAdapter = null)
    {
        parent::__construct('module', $dbAdapter, $storageAdapter);
    }

    public function getAll()
    {
        $cache = $this->cacheGet('module_all');

        if(is_array($cache))
        {
            return $cache;
        }
        else
        {
            $data = array();
            $result = $this->select();
            /**
             * @var \Zend\Db\RowGateway\RowGateway $module
             */
            foreach($result as $module)
            {
                $data[$module->name] = array('name' => $module->name, 'active' => (bool)$module->active);
            }
            $this->cacheSet('module_all', $data);
            return $data;
        }
    }

    public function getActive()
    {
        $cache = $this->cacheGet('module_active');

        if(is_array($cache))
        {
            return $cache;
        }
        else
        {
            $data = array();
            $result = $this->select(array('active' => 1));
            /**
             * @var \Zend\Db\RowGateway\RowGateway $module
             */
            foreach($result as $module)
            {
                $data[] = $module->name;
            }
            $this->cacheSet('module_active', $data);
            return $data;
        }
    }

    public function addModule($name)
    {
        $this->beginTransaction();
        try
        {
            $result = $this->insert(array('name' => $name));
            $this->commit();
            return $result;
        }catch (\Exception $e)
        {
            $this->rollback();
            return false;
        }

    }

    public function removeModule($name)
    {
        $this->beginTransaction();
        try
        {
            $result = $this->delete(array('name' => $name));
            $this->commit();
            return $result;
        }catch (\Exception $e)
        {
            $this->rollback();
            return false;
        }
    }


    public function setModuleActive($name, $active)
    {
        $this->beginTransaction();
        try
        {
            $result = $this->update(array('active' => ($active) ? '1' : '0'), array('name' => $name));
            $this->commit();
            return $result;
        }catch (\Exception $e)
        {
            $this->rollback();
            return false;
        }
    }

    public function cacheClean()
    {
        $this->cacheRemove('module_active');
        $this->cacheRemove('module_all');
    }
}