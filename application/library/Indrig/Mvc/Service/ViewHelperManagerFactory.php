<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 21.08.13
 * Time: 10:35
 */
namespace Indrig\Mvc\Service;

use Zend\Mvc\Service\AbstractPluginManagerFactory,
    Zend\Mvc\Exception,
    Zend\ServiceManager\ConfigInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\View\Helper as ViewHelper,
    Zend\View\Helper\HelperInterface as ViewHelperInterface;


class ViewHelperManagerFactory extends AbstractPluginManagerFactory
{
    protected $defaultHelperMapClasses = array(
        'Indrig\Table\View\HelperConfig',
    );

    /**
     * Create and return the view helper manager
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ViewHelperInterface
     * @throws Exception\RuntimeException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $plugins = $serviceLocator->get('Zend\View\HelperPluginManager');
        //'ViewHelperManager'              => 'Zend\Mvc\Service\ViewHelperManagerFactory',
        foreach ($this->defaultHelperMapClasses as $configClass) {
            if (is_string($configClass) && class_exists($configClass)) {
                $config = new $configClass;

                if (!$config instanceof ConfigInterface) {
                    throw new Exception\RuntimeException(sprintf(
                        'Invalid service manager configuration class provided; received "%s", expected class implementing %s',
                        $configClass,
                        'Zend\ServiceManager\ConfigInterface'
                    ));
                }

                $config->configureServiceManager($plugins);
            }
        }
    }
}