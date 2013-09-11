<?php
namespace Content\Controller;

use Core\Controller\AbstractController,
    Zend\View\Model\ViewModel;

class IndexController extends AbstractController
{

    public function __construct()
    {

    }
    public function indexAction()
    {
        $page = $this->params('page');

        $file = false;
        if(file_exists('./public/'.$page.'.phtml') || is_file('./public/'.$page.'.phtml'))
        {
            $file = './public/'.$page.'.phtml';
        }

        if(file_exists('./public/'.$page.'/index.phtml') || is_file('./public/'.$page.'/index.phtml'))
        {
            $file = './public/'.$page.'/index.phtml';
        }

        if(!$file)
            return $this->notFoundAction();


        return array('file' => $file);
    }
}
