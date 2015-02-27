<?php

require_once "ModelBase.php";

class Application_Model_Following extends Model_Base
{
    protected $_model_name = "following";
    protected $_user_id;
    protected $_follower_id;

    public function setUserId($user_id)
    {
        $this->_user_id = (int)$user_id;
        return $this;
    }

    public function getUserId()
    {
        return $this->_user_id;
    }

    public function setFollowerId($follower_id)
    {
        $this->_follower_id = (int)$follower_id;
        return $this;
    }

    public function getFollowedId()
    {
        return $this->_follower_id;
    }
}

