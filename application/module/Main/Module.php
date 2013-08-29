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

        set_error_handler(array($this, 'errorHandle'));
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
        $viewHelper->get('headTitle')->set($setting->get('main', 'headTitle', ''));
        $navigation = $viewHelper->get('navigation');
        $navigation->menu()->setPartial('partial/menu');
        $navigation->breadcrumbs()->setPartial('partial/breadcrumbs');

        /**
         * @var \Zend\Mvc\View\Http\DefaultRenderingStrategy $renderingStrategy
         */
        $renderingStrategy = $this->service('DefaultRenderingStrategy');
        if(file_exists(__DIR__.'/view/layout/layout.phtml'))
        {

        }

        //var_dump($renderingStrategy->getLayoutTemplate());
       // $renderingStrategy->setLayoutTemplate(__DIR__.'/view/layout/layout2.phtml');
      //  var_dump($renderingStrategy->getLayoutTemplate());
//        $viewManager->getViewModel()->setTemplate();

    }

    /**
     * Обработчик ошибок
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @throws \Exception
     */
    public static function errorHandle($errno, $errstr, $errfile, $errline)
    {
        throw new \Exception($errstr . " in $errfile:$errline". $errno);
    }


    /**
     * Получение конфигурации для модуля
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Регистрация автозагрущика для модуля
     *
     * @return array
     */
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

    /**
     * Список прав доступных для модуля
     *
     * @return array
     */
    public function getModulePrivilege()
    {
        return array('debug');
    }
}
