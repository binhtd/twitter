<?php

require_once "MapperBase.php";

class Application_Model_PostsMapper extends Mapper_Base
{
    protected $_dbTable_Class_Name = "Application_Model_DbTable_Posts";

    public function save(Application_Model_Posts $posts)
    {
        $data = array(
            'user_id'   => $posts->getUserId(),
            'body' => $posts->getBody(),
            'stamp' => date('Y-m-d H:i:s'),
        );

        if (null === ($id = $posts->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_Posts $posts)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $posts->setId($row->id)
            ->setUserId($row->user_id)
            ->setBody($row->body)
            ->setStamp($row->stamp);
    }

    public function findByUserId($user_id)
    {
        $db = $this->getDbTable();
        $select = $db->select()->where('user_id = ?', $user_id);
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
        $post = $this->getDbTable()->find( (int)$id);

        if (count($post) == 0){
            return;
        }

        $post[0]->delete();
    }
}

