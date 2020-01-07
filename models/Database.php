<?php


class Database
{
    protected static $_dbInstance = null;
    protected $_dbHandle;

    public function __construct($username, $password, $host, $dbName) {
        try {
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getInstance() {
        $username = "TEST";
        $password = "TEST";
        $host = "TEST";
        $dbName = "TEST";

        if (self::$_dbInstance == null) {
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }

        return self::$_dbInstance;
    }

    public function getConnection() {
        return $this->_dbHandle;
    }

    public function destruct() {
        $this->_dbHandle = null;
    }
}