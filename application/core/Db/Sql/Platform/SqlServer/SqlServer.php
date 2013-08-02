<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core\Db\Sql\Platform\SqlServer;

use Core\Db\Sql\Platform\AbstractPlatform;

class SqlServer extends AbstractPlatform
{

    public function __construct(SelectDecorator $selectDecorator = null)
    {
        $this->setTypeDecorator('Core\Db\Sql\Select', ($selectDecorator) ?: new SelectDecorator());
    }
}
