<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 27.08.13
 * Time: 12:28
 */
namespace Admin\Controller;

use Zend\Mvc\MvcEvent,
    Indrig\Controller\AbstractController,
    Indrig\SetupInterface;

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

        $systemModules = $moduleManager->getModules();
        //Список всех модулей находящихся в системе
        $availableModules = $this->getAvailableModules();

        $activeModules      = $systemModules;
        $installedModules   = $systemModules;
        /**
         * @var \Main\Model\ModuleTable $moduleTable
         */
        //Вставка данных в дб
        $moduleTable = $this->table('module');
        $modules = $moduleTable->getAll();
        foreach($modules as $item)
        {
            $installedModules[] = $item['name'];
            if($item['active'] === true)
            {
                $activeModules[]    = $item['name'];
            }
        }

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

    public function installAction()
    {

        $module = $this->getModuleFromParams();
        if(!is_array($module))
        {
            return $module;
        }

        $setup      = $module['setup'];
        $moduleName = $module['name'];

        /**
         * @var \Main\Model\ModuleTable $moduleTable
         */
        //Вставка данных в дб
        $moduleTable    = $this->table('module');
        $modules        = $moduleTable->getAll();
        if(isset($modules[$moduleName]))
        {
            return $this->notFoundAction();
        }

       // list($moduleName, $setup) = $module;
        /**
         * @var \Zend\Http\Request $request
         */
        $request =  $this->getRequest();
        $install = intval($request->getPost('install')) !== 0;
        $error = false;

        if($install)
        {
            //Установка модуля
            if($setup->install($this->getServiceLocator()))
            {
                /**
                 * @var \Main\Model\ModuleTable $moduleTable
                 */
                //Вставка данных в дб
                $moduleTable = $this->table('module');
                $moduleTable->addModule($moduleName);
                $moduleTable->cacheClean();

                return $this->redirect()->toRoute('admin/module');
            }
            $error = true;
        }

        //Настроки для модуля если есть
        $htmlOptions = '';
        if(method_exists($setup, 'installHtmlOptions'))
        {
            $htmlOptions = $setup->installHtmlOptions($this->getServiceLocator());
        }

        return array('module' => $moduleName, 'htmlOptions' => $htmlOptions, 'error' => $error);
    }

    public function unInstallAction()
    {
        $module = $this->getModuleFromParams();
        if(!is_array($module))
        {
            return $module;
        }

        $setup      = $module['setup'];
        $moduleName = $module['name'];

        /**
         * @var \Main\Model\ModuleTable $moduleTable
         */
        //Вставка данных в дб
        $moduleTable    = $this->table('module');
        $modules        = $moduleTable->getAll();
        if(!isset($modules[$moduleName]))
        {
            return $this->notFoundAction();
        }

        // list($moduleName, $setup) = $module;
        /**
         * @var \Zend\Http\Request $request
         */
        $request =  $this->getRequest();
        $uninstall = intval($request->getPost('uninstall')) !== 0;
        $error = false;

        if($uninstall)
        {
            //Установка модуля
            if($setup->unInstall($this->getServiceLocator()))
            {
                /**
                 * @var \Main\Model\ModuleTable $moduleTable
                 */
                //Вставка данных в дб
                $moduleTable = $this->table('module');
                $moduleTable->removeModule($moduleName);
                $moduleTable->cacheClean();

                return $this->redirect()->toRoute('admin/module');
            }
            $error = true;
        }

        //Настроки для модуля если есть
        $htmlOptions = '';
        if(method_exists($setup, 'unInstallHtmlOptions'))
        {
            $htmlOptions = $setup->unInstallHtmlOptions($this->getServiceLocator());
        }

        return array('module' => $moduleName, 'htmlOptions' => $htmlOptions, 'error' => $error);
    }

    public function activateAction()
    {
        $module = $this->getModuleFromParams();
        if(!is_array($module))
        {
            return $module;
        }

        /**
         * @var \Main\Model\ModuleTable $moduleTable
         */
        //Вставка данных в дб
        $moduleTable = $this->table('module');
        $moduleTable->setModuleActive($module['name'], true);
        $moduleTable->cacheClean();

        return $this->redirect()->toRoute('admin/module');
    }

    public function deActivateAction()
    {
        $module = $this->getModuleFromParams();
        if(!is_array($module))
        {
            return $module;
        }
        /**
         * @var \Main\Model\ModuleTable $moduleTable
         */
        //Вставка данных в дб
        $moduleTable = $this->table('module');
        $moduleTable->setModuleActive($module['name'], false);
        $moduleTable->cacheClean();

        return $this->redirect()->toRoute('admin/module');
    }

    public function getModuleFromParams()
    {
        $moduleName = $this->params('module');
        /**
         * @var \Zend\ModuleManager\ModuleManager $moduleManager
         */
        //Список всех модулей находящихся в системе
        $availableModules = $this->getAvailableModules();

        if(!isset($availableModules[$moduleName]))
        {
            return $this->notFoundAction();
        }

        $setup = include $availableModules[$moduleName].'/Setup.php';

        if(!($setup instanceof SetupInterface))
        {
            return $this->notFoundAction();
        }

        return array(
            'name'  => $moduleName,
            'setup' => $setup
        );
    }
}