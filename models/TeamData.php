<?php
require_once ("Database.php");
require_once ("Team.php");

class TeamData
{
    protected  $_dbHandle, $_dbInstance;

    // Establish a connection to the DB
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }
}