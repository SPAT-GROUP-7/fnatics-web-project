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

        $sqlQuery = "SELECT U.userID, U.username, U.password, U.firstName, U.lastName, U.isAdmin, U.dateCreated, U.lastUpdate, T.teamName 
                     FROM Users U
                        JOIN Teams T on U.teamID = T.teamID
                     WHERE U.userName = :username";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(':username', $username, PDO::PARAM_STR);

        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        $this->_dbInstance->destruct();

        if ($user == null) {

            return false;
        } else {

            $validPassword = password_verify($password, $user['password']);


            if ($validPassword) {

                return new User($user);
            } else {

                return false;
            }
        }
    }
}