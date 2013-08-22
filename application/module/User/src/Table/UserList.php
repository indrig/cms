<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 21.08.13
 * Time: 11:55
 */
namespace User\Table;

use Indrig\Table\Table,
    Indrig\Table\Adapter\DbTableGateway,
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
                'label' => 'ID'

            ));
        $this->addHeader('login',
            array(
                'label' => 'Login'
            ));

        $this->setAdapter(new DbTableGateway($table));
    }

}