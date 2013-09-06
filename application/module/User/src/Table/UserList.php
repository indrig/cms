<?php
namespace User\Table;

use Core\Table\Table,
    Core\Table\Adapter\DbTableGateway,
    Zend\Http\Request;
class UserList extends Table
{
    /**
     * @var \User\Model\UserTable
     */

    protected $table;

    public function __construct($table, Request $request)
    {
        $this->setRequest($request);
        $this->addHeader('id',
            array(
                'label'     => 'ID',
                'sortable'   => true
            ));
        $this->addHeader('email',
            array(
                'label'     => 'Email address',
                'sortable'   => true
            ));

        $this->setAdapter(new DbTableGateway($table));
    }

}