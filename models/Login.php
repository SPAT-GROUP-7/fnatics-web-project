<?php

require_once ("Database.php");
require_once ("UserData.php");

/**
 * Class Login
 */
class Login
{
    /**
     * @var PDO
     */
    /**
     * @var Database|PDO
     */
    protected $_dbHandle, $_dbInstance;

    /**
     * Login constructor.
     * Establishes a connection to the database
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }

    /**
     * @param $username : The username of the account that is trying to be authenticated
     * @param $password : The password of the account that is trying to be authenticated
     * @return bool|User : If the credentials are not matched to an account in the database
     *                     the method will return false, otherwise it will return the User account
     */
    public function login($username, $password) {

        $sqlQuery = "SELECT U.userID, U.username, U.password, U.firstName, U.lastName, U.isAdmin, U.dateCreated, U.lastUpdate, T.teamName 
                     FROM Users U
                        JOIN Teams T on U.teamID = T.teamID
                     WHERE U.userName = :username";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(':username', $username, PDO::PARAM_STR);

        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        $this->_dbInstance->destruct();

        // User account not found in the database
        if ($user == null) {

            return false;
        } else {

            $validPassword = password_verify($password, $user['password']);

            // Password provided matches the value in the database for a given account
            if ($validPassword) {
                // Return the associated User
                return new User($user);
            } else {

                return false;
            }
        }
    }
}