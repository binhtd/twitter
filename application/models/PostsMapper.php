<?php

require_once "MapperBase.php";

class Application_Model_PostsMapper extends Mapper_Base
{
    protected $_dbTable_Class_Name = "Application_Model_DbTable_Posts";

    public function save(Application_Model_Posts $post)
    {
        $data = array(
            'user_id'   => $post->getUserId(),
            'body' => $post->getBody(),
            'stamp' => date('Y-m-d H:i:s'),
        );

        if (null === ($id = $post->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_Posts $post)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $post->setId($row->id)
            ->setUserId($row->user_id)
            ->setBody($row->body)
            ->setStamp($row->stamp);
    }

    public function findByUserId($user_id, $limit=20){
        if (is_array($user_id)){
            return $this->findByUserIds($user_id, $limit);
        }

        if (is_numeric($user_id)){
            $following = new Application_Model_FollowingMapper();
            $userFollowings = $following->findByWhoIFollowing($user_id);
            $userIds = array($user_id);

            foreach ($userFollowings as $row){
                array_push($user_id, $row->user_id);
            }

            return $this->findByUserIds($userIds, $limit);
        }

        return;
    }

    public function findByUserIds($user_ids, $limit=20)
    {
        $db = $this->getDbTable();
        $select = $db->select();

        if (count($user_ids) > 0)
        {
            $select->where('user_id in (?)', $user_ids);
        }

        $select->order("stamp");

        if ($limit != 0){
            $select->limit($limit, 0);
        }


        $resultSet = $db->fetchAll($select);

        if (0 == count($resultSet)) {
            return;
        }

        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Posts();
            $entry->setId($row->id)
                ->setUserId($row->user_id)
                ->setBody($row->body)
                ->setStamp($row->stamp);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Posts();
            $entry->setId($row->id)
                ->setUserId($row->user_id)
                ->setBody($row->body)
                ->setStamp($row->stamp);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id)
    {
        $posts = $this->getDbTable()->find( (int)$id);

        if (count($posts) == 0){
            return;
        }

        $posts[0]->delete();
    }
}

