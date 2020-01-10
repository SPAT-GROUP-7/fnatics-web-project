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
        $sqlQuery = "SELECT * FROM Users U";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new User($dbRow);
        }

        $this->_dbInstance->destruct();

        return $data;
    }

    public function getUserByID($id) {
        $sqlQuery = "SELECT  * FROM Users U
                     WHERE U.userID = :id";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":id", $id, PDO::PARAM_INT);

        $statement->execute();

        $dbRow = $statement->fetch(PDO::FETCH_ASSOC);

        $this->_dbInstance->destruct();

        return new User($dbRow);
    }

    public function getUsers($search) {

    }

    public function getAllAdmins() {

    }

    public function getAdminByID($id) {

    }

    public function createUser($teamID, $username, $password, $firstName, $lastName, $isAdmin)
    {
        $options = ['cost' => 11];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);
        $sqlQuery = "INSERT INTO Users (teamID, username, password, firstName, lastName, dateCreated, lastUpdate, isAdmin) 
                     VALUES (:teamID, :username, :password, :firstName, :lastName, NOW(), NOW(), :isAdmin)";

        $this->_dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":teamID", $teamID, PDO::PARAM_INT);
        $statement->bindValue(":username", $username, PDO::PARAM_STR);
        $statement->bindValue(":password", $hashedPassword, PDO::PARAM_STR);
        $statement->bindValue(":firstName", $firstName, PDO::PARAM_STR);
        $statement->bindValue(":lastName", $lastName, PDO::PARAM_STR);
        $statement->bindValue(":isAdmin", $isAdmin, PDO::PARAM_BOOL);

        $statement->execute();

        $this->_dbInstance->destruct();

        // TODO: figure out a proper check for this?
        return true;
    }

    // Unsure of the parameters for this
    public function updateUser() {

    }

    public function deleteUser($id) {
        $sqlQuery = "DELETE FROM Users
                     WHERE userID = :userID";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":userID", $id, PDO::PARAM_INT);

        $statement->execute();

        $this->_dbInstance->destruct();

        // TODO: Add a check for this
        return true;
    }
}