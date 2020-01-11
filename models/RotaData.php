<?php
require_once ("Database.php");
require_once ("Rota.php");
require_once ("UserData.php");


class RotaData
{
    protected $_dbHandle, $_dbInstance, $_userData;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
        $this->_userData = new UserData();
    }

    public function getRota($id) {

    }

    public function getRotas($from, $to) {

    }

    public function createRota($from, $to, $devA, $devB) {
//        $sqlQuery = "INSERT INTO Rota (rotaID, dateFrom, dateTo, devA, devB)";
    }

    public function updateRota() {

    }

    public function deleteRota() {

    }

    public function generateRota() {
        $nonAdmins = $this->_userData->getAllNonAdmins();

//        var_dump($nonAdmins);
        $devA =  $nonAdmins[array_rand($nonAdmins, 1)]->getUserID();
        $devB =  $nonAdmins[array_rand($nonAdmins, 1)]->getUserID();

        $sqlQuery = "INSERT INTO Rota (dateFrom, dateTo, devA, devB)
                     VALUES (NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY), :devA, :devB)";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":devA", $devA, PDO::PARAM_INT);
        $statement->bindValue(":devB", $devB, PDO::PARAM_INT);

        $statement->execute();

        $this->_dbInstance->destruct();

        // TODO: maybe add a proper check on this
        return true;
    }
}