<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        $formRegister = new Application_Form_Users('register');
        $this->view->formRegister = $formRegister;

        if ($auth->hasIdentity()){
            $this->_helper->redirector('dashboard', "user");
        }
    }
}

