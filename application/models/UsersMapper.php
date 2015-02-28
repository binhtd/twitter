<?php
require_once "MapperBase.php";

class Application_Model_UsersMapper extends Mapper_Base
{
    protected $_dbTable_Class_Name = "Application_Model_DbTable_Users";

    public function save(Application_Model_Users $user)
    {
        $data = array(
            'id'    => $user->getId(),
            'username'   => $user->getUsername(),
            'password' => $user->getPassword(),
            'salt' => $user->getSalt(),
            'role' => $user->getDateCreated(),
            'is_active' => $user->getIsActive(),
            'is_deleted' => $user->getIsDeleted(),
            'phone_number' => $user->getPhoneNumber(),
            'email' => $user->getEmail(),
            'fullname' => $user->getFullname(),
        );

        if (null === ($id = $user->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }


    public function find($id, Application_Model_Users $user)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $user->setId($row->id)
            ->setPassword($row->password)
            ->setSalt($row->salt)
            ->setRole($row->role)
            ->setDateCreated($row->date_created)
            ->setIsActive($row->is_active)
            ->setIsDeleted($row->is_deleted)
            ->setPhoneNumber($row->phone_number)
            ->setEmail($row->email)
            ->setFullname($row->fullname);
    }

    public function findByWhoIDontFollowing($follower_id, $limit=3){
        $following = new Application_Model_FollowingMapper();
        $resultSet = $following->findByWhoIDontFollowing($follower_id);

        $userIds = array();
        foreach($resultSet as $row)
        {
            array_push($userIds, $row->getUserId());
        }

        if (count($userIds) == 0)
        {
            return;
        }


        $db = $this->getDbTable();
        $select = $db->select()
            ->where('id in (?)', $userIds)
            ->where('is_active = 1')
            ->where('is_deleted = 0')
            ->order("rand()")
            ->limit($limit);

        $resultSet = $db->fetchAll($select);

        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Following();
            $entry->setUserId($row->user_id)
                ->setFollowerId($row->follower_id);
            $entries[] = $entry;
        }
        return $entries;

        return $this->getUserByListUserIds($userIds);
    }

    public function findByWhoIFollowing($follower_id){
        $following = new Application_Model_FollowingMapper();
        $resultSet = $following->findByWhoIFollowing($follower_id);

        $userIds = array();
        foreach($resultSet as $row)
        {
            array_push($userIds, $row->getUserId());
        }

        if (count($userIds) == 0)
        {
            return;
        }

        return $this->getUserByListUserIds($userIds);
    }

    public function findByWhoFolowingMe($user_id){
        $following = new Application_Model_FollowingMapper();
        $resultSet = $following->findByWhoFolowingMe($user_id);

        $userIds = array();
        foreach($resultSet as $row)
        {
            array_push($userIds, $row->getUserId());
        }

        if (count($userIds) == 0)
        {
            return;
        }

        return $this->getUserByListUserIds($userIds);
    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            if (($row->is_active == 0) || ($row->is_deleted == 1))
            {
                continue;
            }

            $entry = new Application_Model_Users();
            $entry->setId($row->id)
                ->setPassword($row->password)
                ->setSalt($row->salt)
                ->setRole($row->role)
                ->setDateCreated($row->date_created)
                ->setIsActive($row->is_active)
                ->setIsDeleted($row->is_deleted)
                ->setPhoneNumber($row->phone_number)
                ->setEmail($row->email)
                ->setFullname($row->fullname);

            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id)
    {
        $users = $this->getDbTable()->find( (int)$id);

        if (count($users) == 0){
            return;
        }

        $users[0]->delete();
    }

    private function getUserByListUserIds($userIds)
    {
        $db = $this->getDbTable();
        $select = $db->select()
            ->where('id in (?)', $userIds)
            ->where('is_active = 1')
            ->where('is_deleted = 0');

        $resultSet = $db->fetchAll($select);

        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Users();
            $entry->setId($row->id)
                ->setPassword($row->password)
                ->setSalt($row->salt)
                ->setRole($row->role)
                ->setDateCreated($row->date_created)
                ->setIsActive($row->is_active)
                ->setIsDeleted($row->is_deleted)
                ->setPhoneNumber($row->phone_number)
                ->setEmail($row->email)
                ->setFullname($row->fullname);
            $entries[] = $entry;
        }
        return $entries;
    }
}

