<?php

require_once ("Secrets.php");

/**
 * Class Database : This class allows connection to a database using the singleton pattern
 */
class Database
{
    /**
     * @var $_dbInstance : the current instance of a database connection
     */
    protected static $_dbInstance = null;
    /**
     * @var $_dbHandle : The handler for the database connection
     */
    protected $_dbHandle;

    // Establish a connection to the DB

    /**
     * Database constructor.
     * @param $username : The username used to connect to the database
     * @param $password : The password used to connect to the database
     * @param $host : The host of the database
     * @param $dbName : The name of the database
     */
    public function __construct($username, $password, $host, $dbName) {
        try {
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    /**
     * @return Database : If there is a current connection to the database, return it
     *                    otherwise establish a new connection
     */
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


    /**
     * @return PDO - return the currently active connection to the database
     */
    public function getConnection() {
        return $this->_dbHandle;
    }


    /**
     * Release the current database connection to free resources
     */
    public function destruct() {
        $this->_dbHandle = null;
    }
}