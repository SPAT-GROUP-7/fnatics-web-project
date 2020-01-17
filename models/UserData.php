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
        $sqlQuery = "SELECT U.userID, T.teamName, U.username, U.password, U.firstName, U.lastName, U.dateCreated, U.lastUpdate, U.isAdmin 
        FROM Users U
        JOIN Teams T On U.teamID = T.teamID
        ORDER BY T.teamName";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new User($dbRow);
        }

        $this->_dbInstance->destruct();

        return $data;
    }

    public function getUsernameByID($id){
        $sqlQuery = "SELECT username FROM Users
                     WHERE userID = :userID";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindValue(":userID", $id, PDO::PARAM_INT);
        $statement->execute();
        $this->_dbInstance->destruct();

        $r = '';
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $r = $row['username'];
        }

        return $r;
    }

    public function getUserByUsername($username) {
        $sqlQuery = "SELECT * FROM Users U
                     WHERE U.username = :username";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":username", $username, PDO::PARAM_STR);

        $statement->execute();

        $user = $statement->fetch();

        $this->_dbInstance->destruct();

        return $user;
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

    public function getAllUnavailableUsers($from) {
        $sqlQuery = "SELECT U.userID, T.teamName, U.username, U.password, U.firstName, U.lastName, U.dateCreated, U.lastUpdate, U.isAdmin
                     FROM Users U
                        JOIN Unavailable U2 ON U.userID = U2.userID
                        JOIN Teams T ON U2.teamID = T.teamID
                     WHERE (U2.dateTo > :dateFrom)";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":dateFrom", $from, PDO::PARAM_STR);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new User($dbRow);
        }

        $this->_dbInstance->destruct();

        return $data;
    }

    public function getAllAvailableUsers($from, $to) {
        $sqlQuery = "SELECT U.userID, T.teamName, U.username, U.password, U.firstName, U.lastName, U.dateCreated, U.lastUpdate, U.isAdmin
                     FROM Users U
                      JOIN Teams T on U.teamID = T.teamID
                      JOIN Unavailable U2 ON U.userID = U2.userID
                     WHERE (U.isAdmin = 0) AND (:dateTo < U2.dateFrom OR :dateFrom > U2.dateTo)
                     UNION ALL
                    # Get all non-admin users
                     SELECT U3.userID, T1.teamName, U3.username, U3.password, U3.firstName, U3.lastName, U3.dateCreated, U3.lastUpdate, U3.isAdmin
                     FROM Users U3
                      JOIN Teams T1 on U3.teamID = T1.teamID
                     WHERE U3.isAdmin = 0";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":dateTo", $to, PDO::PARAM_STR);
        $statement->bindValue(":dateFrom", $from, PDO::PARAM_STR);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new User($dbRow);

        }

        $this->_dbInstance->destruct();

        return $data;
    }

    public function getAllNonAdmins() {
        $sqlQuery = "SELECT U.userID, T.teamName, U.username, U.password, U.firstName, U.lastName, U.dateCreated, U.lastUpdate, U.isAdmin
                     FROM Users U
                     JOIN Teams T On U.teamID = T.teamID
                     WHERE U.isAdmin = 0";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new User($dbRow);
        }

        $this->_dbInstance->destruct();

        return $data;
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
    public function updateUser($userID, $teamID, $username, $firstName, $lastName, $isAdmin) {
        $sqlQuery = "UPDATE Users U 
                     SET U.username = :username,
                         U.teamID = :teamID,
                         U.firstName = :firstName,
                         U.lastName = :lastName,
                         U.lastUpdate = NOW(),
                         U.isAdmin = :isAdmin
                     WHERE U.userID = :userID";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":username", $username, PDO::PARAM_STR);
        $statement->bindValue(":teamID", $teamID, PDO::PARAM_STR);
        $statement->bindValue(":firstName",$firstName, PDO::PARAM_STR);
        $statement->bindValue(":lastName", $lastName, PDO::PARAM_STR);
        $statement->bindValue(":isAdmin", $isAdmin, PDO::PARAM_INT);
        $statement->bindValue(":userID", $userID, PDO::PARAM_INT);

        $statement->execute();

        $this->_dbInstance->destruct();

        return true;
    }

    //Delete user
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

    //Check Username Exists
    public function checkUsernameExists($username){
        $sqlQuery = "SELECT * FROM Users
                     WHERE username = :username";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindValue(":username", $username, PDO::PARAM_STR);
        $statement->execute();
        $this->_dbInstance->destruct();

        return ($statement->fetch() == null);
    }

    //Check Username Exists, Ignore Current Username
    public function checkUsernameExistsIgnore($newUsername, $id){
        $sqlQuery = "SELECT username FROM Users
                     WHERE userID = :userID"; // Get user's old email.

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindValue(":userID", $id, PDO::PARAM_STR);
        $statement->execute();
        $this->_dbInstance->destruct();

        $r = $statement->fetch();

        if (!$this->checkUsernameExists($newUsername)){ //If new username exists
            if ($r['username'] == $newUsername){ //If new username == old username
                return true; //New username == old username
            } else {
                return false; //New username already exists.
            }
        } else {
            return true; //New username is new.
        }
    }
}