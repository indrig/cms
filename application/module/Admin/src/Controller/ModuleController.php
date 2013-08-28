<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 27.08.13
 * Time: 12:28
 */
namespace Admin\Controller;

use Indrig\Controller\AbstractController,
    Indrig\SetupInterface,
    Admin\Form\Setting;

class ModuleController extends AbstractController
{
    public function indexAction()
    {
        /**
         * @var \Zend\ModuleManager\ModuleManager $moduleManager
         */
        $moduleManager = $this->service('ModuleManager');

        $systemModules = $moduleManager->getModules();
        //Список всех модулей находящихся в системе
        $availableModules = $this->getAvailableModules();

        $activeModules      = $systemModules;
        $installedModules   = $activeModules;

        $defaultModuleInfo = array(
            'name'          => '',
            'description'   => '',
            'version'       => false
        );
        $modules = array();
        foreach($availableModules as $moduleName => $modulePath)
        {
            /**
             * @var \Indrig\SetupInterface $setup
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
                    'installed'     => in_array($moduleName, $installedModules),
                    'active'        => in_array($moduleName, $activeModules),
                    'system'        => in_array($moduleName, $systemModules)
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