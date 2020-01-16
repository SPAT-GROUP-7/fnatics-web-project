<?php
require_once ("Database.php");
require_once ("Logs.php");

class LogsData
{
    protected $_dbHandle, $_dbInstance;

    // Establish a connection to the DB
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }

    //Views all logs in the system
    public function viewLog(){
        $sqlQuery = "SELECT logID, logEditorID, logActionType, IFNULL(logAffectedUser, 'n/a') as logAffectedUser, IFNULL(logAffectedTeam, 'n/a') as logAffectedTeam, logDate FROM Logs ORDER BY logDate DESC";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $this->_dbInstance->destruct();

        $dataSet = [];
        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new Logs($dbRow);
        }

        return $dataSet;
    }

    //Adds new log in the system
    public function addLog($logEditor, $actionType, $affectedUser, $affectedTeam){
        $sqlQuery = "INSERT INTO Logs (logEditorID, logActionType, logAffectedUser, logAffectedTeam, logDate) VALUES (:logEditor, :logAction, :logAffectedUser, :logAffectedTeam, NOW())";
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":logEditor", $logEditor, PDO::PARAM_INT);
        $statement->bindValue(":logAction", $actionType, PDO::PARAM_STR);
        $statement->bindValue(":logAffectedUser", $affectedUser, PDO::PARAM_STR);
        $statement->bindValue(":logAffectedTeam", $affectedTeam, PDO::PARAM_STR);

        $statement->execute();
        $this->_dbInstance->destruct();

    }
}