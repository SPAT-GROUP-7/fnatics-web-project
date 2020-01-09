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
        echo "REACHED";
    }

    public function login($username, $password) {

        $sqlQuery = "SELECT * FROM Users U
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

                return true;
            } else {

                return false;
            }
        }
    }
}