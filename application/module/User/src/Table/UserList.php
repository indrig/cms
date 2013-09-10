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
        $this->addHeader('action',
            array(
                'label'     => 'Actions',
            ));
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


        $this->addCell('action', array(
            /**
             * @var \Zend\I18n\View\Helper\AbstractTranslatorHelper $viewHelper
             */
            'render' => function($data, $viewHelper)
            {

                //var_dump($this->translate('Yes'));
                return '<div class="btn-group">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <span class="glyphicon glyphicon-th-large"></span> <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="'.$viewHelper->getView()->url('user/admin/edit', array('id' => $data->id)).'">'.$viewHelper->getView()->translate('Edit').'</a></li>
    <li class="divider"></li>
    <li><a href="#">'.$viewHelper->getView()->translate('Delete').'</a></li>
  </ul>
</div>';
            }
        ));

        $this->setAdapter(new DbTableGateway($table));
    }

}