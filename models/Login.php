<?php

require_once ("Database.php");
require_once ("UserData.php");

class Login
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }

    public function login($username, $password) {
        
    }
}