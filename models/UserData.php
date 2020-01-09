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
        $sqlQuery = "SELECT * FROM User U";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new User($dbRow);
        }

        return $data;
    }

    public function getUserByID($id) {
        $sqlQuery = "SELECT  * FROM User U
                     WHERE U.userID = :id";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":id", $id, PDO::PARAM_INT);

        $statement->execute();

        $dbRow = $statement->fetch(PDO::FETCH_ASSOC);

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

    }
}