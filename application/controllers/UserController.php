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
        $formRegister = new Application_Form_Users('register');
        $this->view->formRegister = $formRegister;

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return;
        }

        $postData = $request->getPost();
        if (!$formRegister->isValid($postData)) {
            return;
        }

        $password = $request->getParam('password');
        $userCfg = array(
            'username'  => $request->getParam('email'), //use email for username
            'phonenumber' => $request->getParam("phonenumber"),
            'fullname'  => $request->getParam('name'),
            'email'     => $request->getParam('email'),

            'datecreated'  => date('Y-m-d H:i:s'),
            'isdeleted'    => 0,
            'role'      => 'user',
            'isactive' => 1,
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

        $postMapper = new Application_Model_PostsMapper();
        $this->view->posts = $postMapper->findByUserId((int)$auth->getIdentity()->id, 10);
    }

    public function viewallAction()
    {
        $this->_helper->layout->setLayout('layout-dashboard');
        $auth = Zend_Auth::getInstance();
        $userMapper = new Application_Model_UsersMapper();
        $this->view->allUnFollowingUser = $userMapper->findByWhoIDontFollowing($auth->getIdentity()->id, 0);
    }

    public function viewallfollowingAction()
    {
        $this->_helper->layout->setLayout('layout-dashboard');
        $auth = Zend_Auth::getInstance();
        $userMapper = new Application_Model_UsersMapper();
        $this->view->allFollowingUser = $userMapper->findByWhoIFollowing($auth->getIdentity()->id);
    }

    public function addtweetAction()
    {
        $this->_helper->layout->setLayout('layout-dashboard');
        $request = $this->getRequest();
        $form    = new Application_Form_Posts();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $auth = Zend_Auth::getInstance();
                $post = new Application_Model_Posts();
                $post->setUserId($auth->getIdentity()->id)
                     ->setBody($request->getPost("body"))
                     ->setStamp(date('Y-m-d H:i:s'));
                $mapper  = new Application_Model_PostsMapper();
                $mapper->save($post);

                $this->_helper->redirector('dashboard', "user");
            }
        }

        $this->view->form = $form;
    }
}





