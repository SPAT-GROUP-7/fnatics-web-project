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

    public function getLogs($from, $to) {
        $sqlQuery = "SELECT L.logID, concat(U.firstName, ' ', U.lastName) as name, L.logActionType, IFNULL(L.logAffectedUser, 'n/a') as logAffectedUser, IFNULL(L.logAffectedTeam, 'n/a') as logAffectedTeam, L.logDate
                     FROM Logs L
                        JOIN Users U on L.logEditorID = U.userID
                     WHERE L.logDate >= :dateFrom AND L.logDate <= :dateTo";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":dateFrom", $from, PDO::PARAM_STR);
        $statement->bindValue(":dateTo", $to, PDO::PARAM_STR);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new Logs($dbRow);
        }

        $this->_dbInstance->destruct();

        return $data;
    }

    //Views all logs in the system
    public function viewLog(){
        $sqlQuery = "SELECT logID, concat(U.firstName, ' ', U.lastName) as name, logActionType, IFNULL(logAffectedUser, 'n/a') as logAffectedUser, IFNULL(logAffectedTeam, 'n/a') as logAffectedTeam, logDate,
                     IF(logAffectedSchedule,
                        (SELECT R.dateFrom
                         FROM Rota R WHERE logAffectedSchedule = R.rotaID), 'n/a') AS 'logAffectedSchedule'
                     FROM Logs
                        JOIN Users U ON Logs.logEditorID = U.userID
                     ORDER BY logDate DESC";

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
    public function addLog($logEditor, $actionType, $affectedUser, $affectedTeam, $affectedRota){
        $sqlQuery = "INSERT INTO Logs (logEditorID, logActionType, logAffectedUser, logAffectedTeam, logDate, logAffectedSchedule) VALUES (:logEditor, :logAction, :logAffectedUser, :logAffectedTeam, NOW(), :logAffectedRota)";
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":logEditor", $logEditor, PDO::PARAM_INT);
        $statement->bindValue(":logAction", $actionType, PDO::PARAM_STR);
        $statement->bindValue(":logAffectedUser", $affectedUser, PDO::PARAM_STR);
        $statement->bindValue(":logAffectedTeam", $affectedTeam, PDO::PARAM_STR);
        $statement->bindValue(":logAffectedRota", $affectedRota, PDO::PARAM_STR);

        $statement->execute();
        $this->_dbInstance->destruct();

    }
}