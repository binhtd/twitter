<?php

class AuthController extends Zend_Controller_Action
{

    public function loginAction()
    {
        //no need view
        $this->_helper->getHelper('viewRenderer')->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $values['username'] = $request->getParam('username_signin');
            $values['password'] = $request->getParam('password_signin');
            $auth = new Application_Model_AuthMapper();

            if ($auth->process($values)) {
                $this->_helper->redirector('user', 'dashboard');
            }
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







