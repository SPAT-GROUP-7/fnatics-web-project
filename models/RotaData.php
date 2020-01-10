<?php
require_once ("Database.php");
require_once ("Rota.php");

class RotaData
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }

    public function getRota($id) {

    }

    public function getRotas($from, $to) {

    }

    public function createRota() {

    }

    public function updateRota() {

    }

    public function deleteRota() {

    }
}