<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 21.08.13
 * Time: 11:55
 */
namespace User\Table;

use Indrig\Table\Table;

class UserList extends Table
{
    public function __construct()
    {
        $this->addHeader('id',
            array(
                'label' => 'ID'

            ));
        $this->addHeader('login',
            array(
                'label' => 'Login'
            ));
    }
}