<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Main\Controller;

use Indrig\Controller\AbstractController;

/**
 *  @method \User\Adapter\Authentication user()
 */
class IndexController extends AbstractController
{

    public function indexAction()
    {
        echo $a;
       // $this->layout()
        /**
         * @var \Zend\Db\Adapter\Adapter $dbAdapter
         */

    }
}
