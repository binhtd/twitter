<?php
/**
 * Created by PhpStorm.
 * User: binhtd
 * Date: 2/27/15
 * Time: 2:34 PM
 */

class Mapper_Base {
    protected $_dbTable;
    protected $_dbTable_Class_Name = "";

    public function setDbTable($dbTable)
    {
        if (empty($dbTable)){
            throw new Exception("Model class name is not set");
        }

        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable($this->_dbTable_Class_Name);
        }
        return $this->_dbTable;
    }
} 