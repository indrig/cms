<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core\Db\Sql\Platform\Mysql;

use Core\Db\Sql\Platform\AbstractPlatform;

class Mysql extends AbstractPlatform
{
    public function __construct()
    {
        $this->setTypeDecorator('Core\Db\Sql\Select', new SelectDecorator());
        $this->setTypeDecorator('Core\Db\Sql\Ddl\CreateTable', new Ddl\CreateTableDecorator());
    }
}
