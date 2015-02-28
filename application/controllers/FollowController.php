<?php

class FollowController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function followingAction()
    {
        $this->_helper->getHelper('viewRenderer')->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $request = $this->getRequest();
        $userId = (int)$request->getParam("id");

        if (!is_numeric($userId)){
            $this->_helper->redirector('dashboard', "user");
        }

        $auth = Zend_Auth::getInstance();
        $following = new Application_Model_Following();
        $following->setUserId($userId)
                  ->setFollowerId($auth->getIdentity()->id);

        $followingMapper = new Application_Model_FollowingMapper();
        $followingMapper->followUser($following);
        $this->_helper->redirector('dashboard', "user");

    }

    public function unfollowingAction()
    {
        $this->_helper->getHelper('viewRenderer')->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $request = $this->getRequest();
        $userId = (int)$request->getParam("id");

        if (!is_numeric($userId)){
            $this->_helper->redirector('viewallfollowing', "user");
        }

        $auth = Zend_Auth::getInstance();
        $following = new Application_Model_Following();
        $following->setUserId($userId)
            ->setFollowerId($auth->getIdentity()->id);

        $followingMapper = new Application_Model_FollowingMapper();
        $followingMapper->unfollowUser($following);
        $this->_helper->redirector('viewallfollowing', "user");

    }
}

