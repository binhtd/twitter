<?php

require_once "ModelBase.php";

class Application_Model_Posts extends Model_Base
{
    protected $_model_name = "posts";
    protected $_id;
    protected $_user_id;
    protected $_body;
    protected $_stamp;

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setUserId($user_id)
    {
        $this->_user_id = $user_id;
        return $this;
    }

    public function getUserId()
    {
        return $this->_user_id;
    }

    public function setBody($body)
    {
        $this->_body = (string)$body;
        return $this;
    }

    public function getBody()
    {
        return $this->_body;
    }

    public function setStamp($date_created)
    {
        $this->_stamp = (string)$date_created;
        return $this;
    }

    public function getStamp()
    {
        return $this->_stamp;
    }
}


