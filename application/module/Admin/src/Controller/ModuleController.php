<?php
namespace Admin\Controller;

use Zend\Mvc\MvcEvent,
    Core\Controller\AbstractController,
    Core\SetupInterface;

class ModuleController extends AbstractController
{
    public function onDispatch(MvcEvent $e)
    {
        if(!$this->isAllowed('setting'))
        {
            return $this->notFoundAction();
        }
        return parent::onDispatch($e);
    }

    public function indexAction()
    {
        /**
         * @var \Zend\ModuleManager\ModuleManager $moduleManager
         */
        $moduleManager = $this->service('ModuleManager');

        //Список всех модулей находящихся в системе
        $availableModules = $this->getAvailableModules();

        $activeModules      = $moduleManager->getModules();


        $defaultModuleInfo = array(
            'name'          => '',
            'description'   => '',
            'version'       => false
        );
        $modules = array();
        foreach($availableModules as $moduleName => $modulePath)
        {
            /**
             * @var \Core\SetupInterface $setup
             */
            $setup = include $modulePath.'/Setup.php';
            if($setup instanceof SetupInterface)
            {
                $info = $setup->getInfo();
                if(!is_array($info))
                    $info = array();

                $info = array_merge($defaultModuleInfo, $info);

                $modules[] = array(
                    'name'          => $moduleName,
                    'info'          => $modulePath,
                    'active'        => in_array($moduleName, $activeModules),

                );
            }
        }

        return array('modules' => $modules);
    }

    /**
     * Список модулей
     */
    protected function getAvailableModules()
    {
        $result = array();
        $configuration    = $this->service('ApplicationConfig');
        foreach($configuration['module_listener_options']['module_paths'] as $path)
        {
            if(file_exists($path) && is_dir($path) && is_readable($path))
            {
                $h = opendir($path);
                while($f = readdir($h))
                {
                    if($f === '.' || $f === '..' || !is_dir($path.'/'.$f))
                        continue;

                    if(file_exists($path.'/'.$f.'/Module.php') && file_exists($path.'/'.$f.'/Setup.php'))
                    {
                        $result[$f] = $path.'/'.$f;
                    }
                }
                closedir($h);
            }
        }

        return $result;
    }


}