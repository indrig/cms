<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core\Db\RowGateway\Feature;

use Core\Db\RowGateway\AbstractRowGateway,
    Exception;

abstract class AbstractFeature extends AbstractRowGateway
{

    /**
     * @var AbstractRowGateway
     */
    protected $rowGateway = null;

    /**
     * @var array
     */
    protected $sharedData = array();

    /**
     * @return string
     */
    public function getName()
    {
        return get_class($this);
    }

    /**
     * @param AbstractRowGateway $rowGateway
     */
    public function setRowGateway(AbstractRowGateway $rowGateway)
    {
        $this->rowGateway = $rowGateway;
    }

    /**
     * @throws Exception
     */
    public function initialize()
    {
        throw new Exception('This method is not intended to be called on this object.');
    }

    /**
     * @return array
     */
    public function getMagicMethodSpecifications()
    {
        return array();
    }
}
