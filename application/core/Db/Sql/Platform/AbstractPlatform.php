<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core\Db\Sql\Platform;

use Exception,
    Core\Db\AdapterInterface,
    Core\Db\Platform\PlatformInterface,
    Core\Db\StatementContainerInterface,
    Core\Db\Sql\PreparableSqlInterface,
    Core\Db\Sql\SqlInterface;

class AbstractPlatform implements PlatformDecoratorInterface, PreparableSqlInterface, SqlInterface
{
    /**
     * @var object
     */
    protected $subject = null;

    /**
     * @var PlatformDecoratorInterface[]
     */
    protected $decorators = array();

    /**
     * @param $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param $type
     * @param PlatformDecoratorInterface $decorator
     */
    public function setTypeDecorator($type, PlatformDecoratorInterface $decorator)
    {
        $this->decorators[$type] = $decorator;
    }

    /**
     * @return array|PlatformDecoratorInterface[]
     */
    public function getDecorators()
    {
        return $this->decorators;
    }

    /**
     * @param AdapterInterface $adapter
     * @param StatementContainerInterface $statementContainer
     * @throws Exception
     * @return void
     */
    public function prepareStatement(AdapterInterface $adapter, StatementContainerInterface $statementContainer)
    {
        if (!$this->subject instanceof PreparableSqlInterface) {
            throw new Exception('The subject does not appear to implement Zend\Db\Sql\PreparableSqlInterface, thus calling prepareStatement() has no effect');
        }

        $decoratorForType = false;
        foreach ($this->decorators as $type => $decorator) {
            if ($this->subject instanceof $type && $decorator instanceof PreparableSqlInterface) {
                /** @var $decoratorForType PreparableSqlInterface|PlatformDecoratorInterface */
                $decoratorForType = $decorator;
                break;
            }
        }
        if ($decoratorForType) {
            $decoratorForType->setSubject($this->subject);
            $decoratorForType->prepareStatement($adapter, $statementContainer);
        } else {
            $this->subject->prepareStatement($adapter, $statementContainer);
        }
    }

    /**
     * @param null|\Core\Db\Platform\PlatformInterface $adapterPlatform
     * @return mixed
     * @throws Exception
     */
    public function getSqlString(PlatformInterface $adapterPlatform = null)
    {
        if (!$this->subject instanceof SqlInterface) {
            throw new Exception('The subject does not appear to implement Zend\Db\Sql\PreparableSqlInterface, thus calling prepareStatement() has no effect');
        }

        $decoratorForType = false;
        foreach ($this->decorators as $type => $decorator) {
            if ($this->subject instanceof $type && $decorator instanceof SqlInterface) {
                /** @var $decoratorForType SqlInterface|PlatformDecoratorInterface */
                $decoratorForType = $decorator;
                break;
            }
        }
        if ($decoratorForType) {
            $decoratorForType->setSubject($this->subject);
            return $decoratorForType->getSqlString($adapterPlatform);
        }

        return $this->subject->getSqlString($adapterPlatform);
    }
}
