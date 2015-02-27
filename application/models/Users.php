<?php
require_once "ModelBase.php";

class Application_Model_Users extends Model_Base
{
    protected $_model_name = "users";
    protected $_id;
    protected $_username;
    protected $_password;
    protected $_salt;
    protected $_role;
    protected $_date_created;
    protected $_is_active;
    protected $_is_deleted;
    protected $_phone_number;
    protected $_email;
    protected $_fullname;

    public function setId($id)
    {
        $this->_id = (int)$id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setUsername($user_name)
    {
        $this->_username = (string)$user_name;
        return $this;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function setPassword($password)
    {
        $this->_password = (string)$password;
        return $this;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function setSalt($salt)
    {
        $this->_salt = (string)$salt;
        return $this;
    }

    public function getSalt()
    {
        return $this->_salt;
    }

    public function setRole($role)
    {
        $this->_role = (string)$role;
        return $this;
    }

    public function getRole()
    {
        return $this->_role;
    }

    public function setDateCreated($date_created)
    {
        $this->_date_created = (string)$date_created;
        return $this;
    }

    public function getDateCreated()
    {
        return $this->_date_created;
    }

    public function setIsActive($is_active)
    {
        $this->_is_active = (int)$is_active;
        return $this;
    }

    public function getIsActive()
    {
        return $this->_is_active;
    }

    public function setIsDeleted($is_deleted)
    {
        $this->_is_deleted = (int)$is_deleted;
        return $this;
    }

    public function getIsDeleted()
    {
        return $this->_is_deleted;
    }

    public function setPhoneNumber($phone_number)
    {
        $this->_phone_number = (string)$phone_number;
        return $this;
    }

    public function getPhoneNumber()
    {
        return $this->_phone_number;
    }

    public function setEmail($email)
    {
        $this->_email = (string)$email;
        return $this;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setFullname($fullname)
    {
        $this->_fullname = (string)$fullname;
        return $this;
    }

    public function getFullname()
    {
        return $this->_fullname;
    }
}

