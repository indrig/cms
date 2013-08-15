<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Main\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
/**
 *  @method \User\Adapter\Authentication user()
 */
class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        /**
         * @var \Zend\Db\Adapter\Adapter $dbAdapter
         */
        $dbAdapter = $this->getServiceLocator()->get('database');
        return new ViewModel();
    }
}
