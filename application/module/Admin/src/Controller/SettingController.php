<?php
namespace Admin\Controller;

use Zend\Mvc\MvcEvent,
    Core\Controller\AbstractController,
    Admin\Form\Setting;

class SettingController extends AbstractController
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
         * @var \Admin\Form\Setting $form
         */
        $form = new Setting();

        /**
         * @var \Main\Model\SettingTable $service
         */
        $service = $this->table('setting');

        $form->setData(
            array(
                'headTitle' => $service->get('main', 'headTitle', '')
            )
        );

        /**
         * @var \Zend\Http\Request $request
         */
        $request = $this->getRequest();

        //
        if($request->isPost())
        {
            $form->setData($request->getPost());

            if($form->isValid())
            {
                $service->set('main', 'headTitle', $form->get('headTitle')->getValue());

                $service->flush();
                $this->redirect()->toRoute('admin/settings');
            }
        }

        return array('form' => $form);
    }
}