<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 22.08.13
 * Time: 10:34
 */
namespace Indrig\Table\Adapter;

use Zend\Db\Sql\Select;

class DbSelect implements AdapterInterface
{
    public function __construct(Select $select)
    {

    }
}
