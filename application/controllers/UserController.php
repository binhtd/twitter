<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {

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
            'isactive' => 1,
            'fullname'  => $request->getParam('name'),
            'email'     => $request->getParam('email'),
            'datecreated'  => date('Y-m-d H:i:s'),
            'isdeleted'    => 0,
            'phonenumber' => $request->getParam("phonenumber"),
        );

        $salt = uniqid();
        $password = sha1($password.$salt);
        $userCfg['salt'] = $salt;
        $userCfg['password'] = $password;

        $user = new Application_Model_Users($userCfg);
        $userMapper = new Application_Model_UsersMapper();
        $userMapper->save($user);

        //TODO Send email after ward for activate this account

        //auto login
        $auth = new Application_Model_AuthMapper();
        $identify = array();
        $identify['username'] = $userCfg['username'];
        $identify['password'] = $request->getParam('password');
        $identify["remember_me"] = false;

        if ($auth->authenticateUserLogin($identify)) {
            $this->_helper->redirector('dashboard', "user");
        }
    }

    public function dashboardAction()
    {
        $this->_helper->layout->setLayout('layout-dashboard');
        $auth = Zend_Auth::getInstance();
        $userMapper = new Application_Model_UsersMapper();
        $this->view->unFollowingUser = $userMapper->findByWhoIDontFollowing($auth->getIdentity()->id, 3);
    }


}





