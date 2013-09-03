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

class SettingTable extends TableGateway
{
    protected $is_load              = false;
    protected $settings             = array();
    protected $settings_need_save   = array();

    public function __construct(AdapterInterface $dbAdapter, StorageInterface $storageAdapter = null)
    {
        parent::__construct('setting', $dbAdapter, $storageAdapter);
    }

    public function load()
    {
        $cached =$this->cacheGet('settings');
        if(is_array($cached))
        {
            $this->settings = $cached;
        }
        else
        {
            $result = $this->select();
            foreach($result as $setting)
            {
                $this->settings[$setting->module][$setting->name] = $setting->value;
            }
            $this->cacheSet('settings', $this->settings);
        }
    }
    /**
     * @param $module
     * @param $name
     * @param $default
     * @return string|mixed
     */
    public function get($module, $name, $default = null)
    {
        /*$this->getCache())
        {


        }*/
        if(!$this->is_load)
            $this->load();

        return isset($this->settings[$module][$name]) ? $this->settings[$module][$name] : $default;
    }

    /**
     * @param $module
     * @param $name
     * @param int $default
     * @return null
     */
    public function getInt($module, $name, $default = 0)
    {
        return intval($this->get($module, $name, $default));
    }

    /**
     * @param $module
     * @param $name
     * @param int $default
     * @return null
     */
    public function getFloat($module, $name, $default = 0.0)
    {
        return floatval($this->get($module, $name, $default));
    }

    /**
     * @param $module
     * @param $name
     * @param $value
     */
    public function set($module, $name, $value)
    {
        if(!$this->is_load)
            $this->load();


        if(!isset($this->settings[$module][$name]) || $this->settings[$module][$name] != $value)
        {
            $this->settings_need_save[$module][$name]   = true;
        }
        $this->settings[$module][$name] = $value;
    }

    /**
     * Сохранение настроик в БД
     * @return bool
     */
    public function flush()
    {
        //Нету изменений
        if(sizeof($this->settings_need_save) === 0)
            return true;

        $connection = $this->getAdapter()->getDriver()->getConnection();
        $connection->beginTransaction();
        try
        {
            foreach($this->settings_need_save as $module => $moduleSetting)
            {
                foreach($moduleSetting as $name => $need)
                {
                    $this->insertOrUpdate(array('value' => $this->settings[$module][$name]), array('module' => $module, 'name' => $name));
                }
            }
            $this->settings_need_save = array();
            $this->cacheSet('settings', $this->settings);
            $connection->commit();
            return true;
        }
        catch (\Exception $e)
        {
            $connection->rollback();
            return false;
        }
    }
}