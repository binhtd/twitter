<?php

class Application_Model_AuthMapper
{
    public function authenticateUserLogin($identify) {
        // Get our authentication adapter and check credentials
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($identify['username']);
        $adapter->setCredential($identify['password']);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);

            if ($identify["remember_me"]){
                Zend_Session::rememberMe();
            }
            return true;
        }
        return false;
    }

    protected function _getAuthAdapter() {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('users')
            ->setIdentityColumn('username')
            ->setCredentialColumn('password')
            ->setCredentialTreatment('SHA1(CONCAT(?,salt))');

        $authAdapter->getDbSelect()
                    ->where('is_active = 1')
                    ->where('is_deleted = 0');
        return $authAdapter;
    }
}

