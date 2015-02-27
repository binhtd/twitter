<?php

class Application_Model_Following
{
    protected $_user_id;
    protected $_follower_id;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid following property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid following property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

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

