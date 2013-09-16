<?php
namespace Engine\Mail\Transport;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Mail\Transport\File,
    Zend\Mail\Transport\FileOptions,
    Zend\Mail\Transport\Sendmail,
    Zend\Mail\Transport\Smtp,
    Zend\Mail\Transport\SmtpOptions,
    Zend\Mail\Transport\TransportInterface,
    Zend\Mail\Transport\Exception;
class TransportServiceFactory implements FactoryInterface
{

    /**
     * Create db adapter service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TransportInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        if(!isset($config['mail']['transport']) || $config['mail']['transport']['type'])
            throw new Exception\RuntimeException('Mail transport not configured');

        $options = isset($config['mail']['transport']['options']) ? $config['mail']['transport']['options'] : array();

        switch(strtolower($config['mail']['transport']['type']))
        {
            case 'sendmail':
                {
                    return new Sendmail($options);
                }
            case 'snmp':
            {
                return new Smtp(new SmtpOptions($options));
            }
            case 'file':
            {
                return new File(new FileOptions($options));
            }
            default:
               throw new Exception\RuntimeException('Incorect transport type');
        }
    }
}