<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 26.08.13
 * Time: 10:50
 */
namespace Indrig\Db;

use Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\TableGateway\Feature,
    Zend\Db\TableGateway\Exception,
    Zend\Db\Adapter\AdapterInterface,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\ResultSet\ResultSetInterface,
    Zend\Db\Sql\Sql,
    Zend\Db\Sql\TableIdentifier;


class TableGateway extends AbstractTableGateway
{

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
    public function __construct($table, AdapterInterface $adapter)
    {
        // table
        if (!(is_string($table) || $table instanceof TableIdentifier)) {
            throw new Exception\InvalidArgumentException('Table name must be a string or an instance of Zend\Db\Sql\TableIdentifier');
        }
        $this->table = $table;

        // adapter
        $this->adapter = $adapter;

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
     *  @return \Indrig\Db\RowGateway
     */
    public function newRow()
    {
        return clone $this->getResultSetPrototype()->getArrayObjectPrototype();
    }
}
