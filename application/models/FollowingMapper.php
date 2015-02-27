<?php

require_once "MapperBase.php";

class Application_Model_FollowingMapper extends Mapper_Base
{
    protected $_dbTable_Class_Name = "Application_Model_DbTable_Following";

    public function findByWhoIFollowing($follower_id)
    {
        $db = $this->getDbTable();
        $select = $db->select()
            ->where('follower_id = ?', $follower_id);

        $resultSet = $db->fetchAll($select);

        if (0 == count($resultSet)) {
            return;
        }

        return $this->getListFollowingObjectFromResultset($resultSet);
    }

    public function findByWhoFolowingMe($user_id){
        $db = $this->getDbTable();
        $select = $db->select()
            ->where('user_id = ?', $user_id);

        $resultSet = $db->fetchAll($select);

        if (0 == count($resultSet)) {
            return;
        }

        return $this->getListFollowingObjectFromResultset($resultSet);
    }

    public function followUser(Application_Model_Following $following)
    {
        $count = isUserFollowingSomeone($following->getFollowedId(),$following->getUserId());

        if ($count == 0){
            return $this->save($following);
        }

        return 0;
    }

    public function unfollowUser(Application_Model_Following $following)
    {
        $count = isUserFollowingSomeone($following->getFollowedId(),$following->getUserId());

        if ($count != 0){
            return $this->delete($following);
        }

        return 0;
    }

    public function save(Application_Model_Following $following)
    {
        $data = array(
            'user_id'   => $following->getUserId(),
            'follower_id' => $following->getFollowedId(),
        );

        return $this->getDbTable()->insert($data);
    }

    public function delete(Application_Model_Following $following)
    {
        $db = $this->getDbTable();
        $select = $db->select()
            ->where('user_id = ?', $following->getUserId())
            ->where('follower_id = ?', $following->getFollowedId());

        $resultSet = $db->fetchAll($select);
        return $resultSet[0]->delete();
    }

    protected function isUserFollowingSomeone($me, $them){
        $db = $this->getDbTable();
        $select = $db->select()
            ->where('user_id = ?', $them)
            ->where('follower_id = ?', $me);

        $resultSet = $db->fetchAll($select);

        return count($resultSet);
    }

    private function getListFollowingObjectFromResultset($resultSet)
    {
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Following();
            $entry->setUserId($row->user_id)
                ->setFollowerId($row->follower_id);
            $entries[] = $entry;
        }
        return $entries;
    }
}

