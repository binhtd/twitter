<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function signupAction()
    {
        $this->_helper->getHelper('viewRenderer')->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $request = $this->getRequest();

        $password = $request->getParam('password');

        $userCfg = array(
            'username'  => $request->getParam('email'), //use email for username
            'role'      => 'user',
            'is_active' => 1,
            'fullname'  => $request->getParam('name'),
            'email'     => $request->getParam('email'),
            'date_created'  => date('Y-m-d H:i:s'),
            'is_deleted'    => 0
        );

        $salt = uniqid();
        $password = sha1($password.'-'.$salt);
        $userCfg['salt'] = $salt;
        $userCfg['password'] = $password;

        $userDao = new Model_DbTable_User();
        $userDao->insert($userCfg);

        //Send email after ward for activate this account

        //auto login

        //redirect to page thank you or whatever
        $this->_redirect(APPLICATION_HOST . $this->view->url(array('controller' => 'user', 'action' => 'dashboard')));
    }

    public function dashboardAction()
    {
        // action body
    }


}





