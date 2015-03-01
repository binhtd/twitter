<?php

class AuthController extends Zend_Controller_Action
{

    public function loginAction()
    {
        $request = $this->getRequest();
        $formLogin = new Application_Form_Login('login');

        $this->view->formLogin = $formLogin;
        $this->view->invalidUserNameOrPass = false;

        if ($request->isPost()) {
            $identify = $request->getPost();
            $auth = new Application_Model_AuthMapper();
            if (!$formLogin->isValid($identify) ||
                !$auth->authenticateUserLogin($identify)) {
                $this->view->invalidUserNameOrPass = true;
                return;
            }
            $this->_helper->redirector('dashboard', "user");
        }
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index', 'index'); // back to login page
    }

    public function forgotAction()
    {
        // action body
    }
}







