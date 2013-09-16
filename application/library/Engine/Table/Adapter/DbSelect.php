<?php
/**
 * User: Igor Bubnevich aka Core
 * Date: 22.08.13
 * Time: 10:34
 */
namespace Engine\Table\Adapter;

use Zend\Db\Sql\Select;

class DbSelect implements AdapterInterface
{
    public function __construct(Select $select)
    {

    }
}
