<?php
require_once ("Database.php");
require_once ("User.php");

class UserData
{
    protected $_dbHandle, $_dbInstance;

    // Establish a connection to the DB
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }

    public function getAllUsers() {

    }

    public function getUserByID($id) {

    }

    public function getUsers($search) {

    }

    public function getAllAdmins() {

    }

    public function getAdminByID($id) {

    }

    public function createUser($teamID, $username, $password, $firstName, $lastName, $isAdmin)
    {

    }

    // Unsure of the parameters for this
    public function updateUser() {

    }

    public function deleteUser($id) {

    }
}