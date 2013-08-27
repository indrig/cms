<?php
/**
 * User: Igor Bubnevich aka Indrig
 * Date: 27.08.13
 * Time: 12:28
 */
namespace Admin\Controller;

use Indrig\Controller\AbstractController,
    Admin\Form\Setting;

class SettingController extends AbstractController
{
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