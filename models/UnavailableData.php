<?php
require_once 'models/Unavailable.php';
require_once ("Database.php");

class UnavailableData
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }


    public function markAsAbsent($userID, $teamID, $dateFrom, $dateTo){
        $sqlQuery = "INSERT INTO Unavailable (userID, teamID, dateFrom, dateTo) VALUES (:userID, :teamID, :dateFrom, :dateTo)";
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue('userID', $userID, PDO::PARAM_INT);
        $statement->bindValue('teamID', $teamID, PDO::PARAM_INT);
        $statement->bindValue('dateFrom', $dateFrom);
        $statement->bindValue('dateTo', $dateTo);

        $statement->execute();
        $this->_dbInstance->destruct();
    }

}