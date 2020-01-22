<?php
require_once ("Database.php");
require_once ("Logs.php");

/**
 * Class LogsData
 * This class is used to aggregate a collection of Log Objects
 */
class LogsData
{
    /**
     * @var PDO
     */
    /**
     * @var Database|PDO
     */
    protected $_dbHandle, $_dbInstance;

    // Establish a connection to the DB

    /**
     * LogsData constructor.
     * Establishes a connection to the database
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }

    /** This function will retrieve a colllection of Logs created in a specified time frame
     *
     * @param $from : The DateTime in format Y-m-d from which to start the search
     * @param $to : The DateTime in format Y-m-d from which to end the search
     * @return array : An array containing a collection of Log Objects matching the search criteria
     */
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


    /** This function will return a collection of all Log Objects in the database
     *
     * @return array : A collection of all Log Objects
     */
    public function viewLog()
    {
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

    /** This function will add a new Log to the database
     *
     * @param $logEditor : The ID of the admin who caused the Log to be created
     * @param $actionType : The action of the created Log
     * @param $affectedUser : The ID of the user affected by the Log
     * @param $affectedTeam : The ID of the team affected by the Log
     * @param $affectedRota : The ID of the schedule affected by the Log
     */
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