<?php

require_once ("Secrets.php");
class Database
{
    protected static $_dbInstance = null;
    protected $_dbHandle;

    // Establish a connection to the DB
    public function __construct($username, $password, $host, $dbName) {
        try {
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // return an instance of the DB, if an instance is already active use it, otherwise create a new instance
    public static function getInstance() {
        $username = Secrets::$USERNAME;
        $password = Secrets::$PASSWORD;
        $host = Secrets::$HOST;
        $dbName = Secrets::$DB_NAME;

        if (self::$_dbInstance == null) {
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }

        return self::$_dbInstance;
    }

    // Return the current connection to the DB
    public function getConnection() {
        return $this->_dbHandle;
    }

    // Close the connection to the DB and release the resources used
    public function destruct() {
        $this->_dbHandle = null;
    }
}