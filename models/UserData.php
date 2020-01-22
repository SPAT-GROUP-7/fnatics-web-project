<?php
require_once ("Database.php");
require_once ("User.php");

/**
 * Class UserData
 * This class is used to represent an aggregation of User Objects
 */
class UserData
{
    /**
     * @var PDO
     */
    /**
     * @var Database|PDO
     */
    protected $_dbHandle, $_dbInstance;


    /** Establish a connection to the database
     *
     * UserData constructor.
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }

    /** This function retrieves all Users from the system
     *
     * @return array : a collection of Users
     */
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

    /** This function retrieves a user with a given ID
     *
     * @param $id : the ID of the user to Retrieve
     * @return string : the Username of the User with a given ID
     */
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

    /** This function retrieves a User with a given Username
     *
     * @param $username : the username to search
     * @return mixed : a User Object
     */
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

    /** This function retrieves a User with a given ID
     * @param $id : the ID to search for
     * @return User : the User Object
     */
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

    /** This function allows the filtering of Users with a partial first name
     *
     * @param $partialName : the first name to search form
     * @return array : a collection of User Objects
     */
    public function getUsers($partialName) {
        $sqlQuery = "SELECT U.userID, T.teamName, U.username, U.password, U.firstName, U.lastName, U.dateCreated, U.lastUpdate, U.isAdmin
                     FROM Users U
                        JOIN Teams T on U.teamID = T.teamID
                     WHERE U.firstName LIKE concat(:partialName, '%')";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":partialName", $partialName, PDO::PARAM_STR);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new User($dbRow);
        }

        $this->_dbInstance->destruct();

        return $data;
    }

    /** This function retrieves all users who are unavailable for a given date range
     *
     * @param $from : the start date
     * @return array : a collection of User Objects
     */
    public function getAllUnavailableUsers($from) {

        $sqlQuery = "SELECT U.userID, T.teamName, U.username, U.password, U.firstName, U.lastName, U.dateCreated, U.lastUpdate, U.isAdmin 
                     FROM Users U
                        JOIN Unavailable U2 ON U.userID = U2.userID
                        JOIN Teams T ON U2.teamID = T.teamID
                     WHERE U2.dateTo > :dateFrom";

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

    /** This function will retrieve all non admin Users
     *
     * @return array : a collection of User Objects
     */
    public function getAllNonAdmins() {
        $sqlQuery = "SELECT U.userID, T.teamName, U.username, U.password, U.firstName, U.lastName, U.dateCreated, U.lastUpdate, U.isAdmin
                     FROM Users U
                        JOIN Teams T On U.teamID = T.teamID
                     WHERE (U.isAdmin = 0) AND (PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM NOW()), EXTRACT(YEAR_MONTH FROM U.startDate)) >= 4)";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new User($dbRow);
        }

        $this->_dbInstance->destruct();

        return $data;
    }




    /** This function will add a new User to the System
     *
     * @param $teamID : the ID of the Users Team
     * @param $username : the username of the User
     * @param $password : the password of the User
     * @param $firstName : the firstName of the User
     * @param $lastName : the lastName of the User
     * @param $isAdmin : whether the User is an admin
     */
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

    }


    /** This function will update a given User
     *
     * @param $userID : the ID of the User to update
     * @param $teamID : the teamID of the User
     * @param $username : the username of the User
     * @param $firstName : the firstName of the User
     * @param $lastName : the lastName of the User
     * @param $isAdmin : Whether the User is an admin or not
     */
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
    }


    /** This function will delete a given user
     * @param $id : the ID of the User to delete
     */
    public function deleteUser($id) {
        $sqlQuery = "DELETE FROM Users
                     WHERE userID = :userID";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":userID", $id, PDO::PARAM_INT);

        $statement->execute();

        $this->_dbInstance->destruct();
    }


    /** This function will try to find any existing Users with a matching Username
     * @param $username : the Username to check
     * @return bool : Whether a match was found
     */
    public function checkUsernameExists($username){
        $sqlQuery = "SELECT * FROM Users
                     WHERE username = :username";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindValue(":username", $username, PDO::PARAM_STR);
        $statement->execute();
        $this->_dbInstance->destruct();

        return ($statement->fetch() == null);
    }


    /**
     * @param $newUsername
     * @param $id
     * @return bool
     */
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