<?php
namespace Indrig\Table\View;

use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Service manager configuration for form view helpers
 */
class HelperConfig implements ConfigInterface
{
    /**
     * Pre-aliased view helpers
     *
     * @var array
     */
    protected $invokables = array(
        'table'                => 'Indrig\Form\View\Helper\Table',
        'tablecell'            => 'Indrig\Form\View\Helper\TableCell',
        'tablecow'             => 'Indrig\Form\View\Helper\TableRow',
        'tableheader'          => 'Indrig\Form\View\Helper\Captcha\TableHeader',
    );

    /**
     * Configure the provided service manager instance with the configuration
     * in this class.
     *
     * Adds the invokables defined in this class to the SM managing helpers.
     *
     * @param  ServiceManager $serviceManager
     * @return void
     */
    public function configureServiceManager(ServiceManager $serviceManager)
    {
        foreach ($this->invokables as $name => $service) {
            $serviceManager->setInvokableClass($name, $service);
        }
    }
}