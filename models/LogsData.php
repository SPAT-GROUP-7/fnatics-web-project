<?php

require_once ("Database.php");
require_once("ScheduleData.php");
require_once("UserData.php");
require_once ("Logs.php");

class LogsData
{
    //Creates a connection to the database
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }

    //Views all logs in the system
    public function viewLog(){
        $sqlQuery = "SELECT * FROM Logs ORDER BY logDate DESC";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new Logs($dbRow);
        }

        $this->_dbInstance->destruct();
        return $dataSet;
    }
    //Adds new log in the system
    public function addNewLog($logEditor, $actionType, $affectedUser, $afftectedTeam){
        $sqlQuery = "INSERT INTO Logs VALUES (:logEditor, :logAction, :logAffectedUser, :logAffectedTeam, NOW())";
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":logEditor", $logEditor, PDO::PARAM_INT);
        $statement->bindValue(":logAction", $actionType, PDO::PARAM_STR);
        $statement->bindValue(":logAffectedUser", $affectedUser, PDO::PARAM_INT);
        $statement->bindValue(":logAffectedTeam", $afftectedTeam, PDO::PARAM_INT);

        $statement->execute();
        $this->_dbInstance->destruct();

    }

}