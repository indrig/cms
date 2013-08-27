<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Main;

use Zend\Mvc\ModuleRouteListener,
    Zend\Mvc\MvcEvent,
    Zend\Http\AbstractMessage,
    Indrig\AbstractModule;

class Module extends AbstractModule
{
    public function onBootstrap(MvcEvent $e)
    {
        parent::onBootstrap($e);

        $this->registerTable('\Main\Model\SettingTable', 'setting');

        //
        $eventManager           = $e->getApplication()->getEventManager();
        $moduleRouteListener    = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        //Применение настроик
        $this->setupView();

        $eventManager->attach(MvcEvent::EVENT_FINISH,
            function(MvcEvent $e)
            {
                $response = $e->getResponse();
                if ($response instanceof AbstractMessage)
                {
                    $response->getHeaders()->addHeaders(array(
                        'X-Powered-By'  => 'Nashny CMS',
                        'Server'        => 'Nashny Script'
                    ));
                }
            }, 500);
    }

    /**
     * Установка настроик
     */
    public function setupView()
    {
        $translator = $this->service('translator');
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);

        /**
         *  @var \Main\Model\SettingTable $setting
         */
        $setting = $this->table('setting');
        $viewHelper = $this->getView();

        //  Установка параметров страницы
        $viewHelper->get('headTitle')->set($setting->get('main', 'headTitle'));
        $navigation = $viewHelper->get('navigation');
        $navigation->menu()->setPartial('partial/menu');
        $navigation->breadcrumbs()->setPartial('partial/breadcrumbs');
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array
            (
                'namespaces' => array
                (
                    __NAMESPACE__ => __DIR__ . '/src/'
                )
            )
        );
    }
}
