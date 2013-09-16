<?php
/**
 * User: Igor Bubnevich aka Core
 * Date: 26.08.13
 * Time: 10:50
 */
namespace Engine\Db;

use Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\TableGateway\Feature,
    Zend\Db\TableGateway\Exception,
    Zend\Db\Adapter\AdapterInterface,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\ResultSet\ResultSetInterface,
    Zend\Cache\Storage\StorageInterface,
    Zend\Db\Sql\Sql,
    Zend\Db\Sql\TableIdentifier,
    Zend\Db\Sql\Expression;


class TableGateway extends AbstractTableGateway
{
    /**
     * @var StorageInterface
     */
    protected $storageAdapter = null;
    /**
     * Constructor
     *
     * @param string $table
     * @param AdapterInterface $adapter
     * @param Feature\AbstractFeature|Feature\FeatureSet|Feature\AbstractFeature[] $features
     * @param ResultSetInterface $resultSetPrototype
     * @param Sql $sql
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($table, AdapterInterface $dbAdapter, StorageInterface $storageAdapter = null)
    {
        // table
        if (!(is_string($table) || $table instanceof TableIdentifier)) {
            throw new Exception\InvalidArgumentException('Table name must be a string or an instance of Zend\Db\Sql\TableIdentifier');
        }
        $this->table = $table;

        // adapter
        $this->adapter = $dbAdapter;

        $this->storageAdapter   = $storageAdapter;

        $this->sql = new Sql($this->adapter, $this->table);


        // check sql object bound to same table
        /*
        if ($this->sql->getTable() != $this->table)
        {
            throw new Exception\InvalidArgumentException('The table inside the provided Sql object must match the table of this TableGateway');
        }
*/
        $this->initialize();
    }

    /**
     * Получить все записи таблицы
     *
     * @return ResultSet
     */
    public function all()
    {
        return $this->select();
    }

    /**
     *  Создает экземпляр новой записи для таблицы
     *  @return \Engine\Db\RowGateway
     */
    public function newRow()
    {
        return clone $this->getResultSetPrototype()->getArrayObjectPrototype();
    }

    /**
     * @return StorageInterface
     */
    public function getCache()
    {
        return $this->storageAdapter;
    }

    public function cacheSet($key, $value)
    {
        $cache = $this->getCache();
        if($cache)
            return $cache->setItem($key, $value);

        return false;
    }

    public function cacheGet($key)
    {
        $cache = $this->getCache();
        if($cache)
            return $cache->getItem($key);

        return null;
    }

    public function cacheRemove($key)
    {
        $cache = $this->getCache();
        if($cache)
            return $cache->removeItem($key);

        return false;
    }

    /**
     * Update
     *
     * @param  array $insert
     * @param  array $where
     * @return int
     */
    public function insertOrUpdate($set, $where)
    {
        if($this->update($set, $where) === 0)
        {
            $set = array_merge($set, $where);
            $this->insert($set);
        }
    }


    public function beginTransaction()
    {
        $this->getAdapter()->getDriver()->getConnection()->beginTransaction();
    }


    public function commit()
    {
        $this->getAdapter()->getDriver()->getConnection()->commit();
    }

    public function rollback()
    {
        $this->getAdapter()->getDriver()->getConnection()->rollback();
    }
}
