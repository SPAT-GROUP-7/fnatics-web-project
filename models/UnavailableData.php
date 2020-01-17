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

    public function getAllUnavailableUsers() {
        $sqlQuery = "SELECT CONCAT(U.firstName, ' ', U.lastName), T.teamName, U2.dateFrom, U2.dateTo 
                     FROM Users U
                        JOIN Unavailable U2 ON U.userID = U2.userID
                        JOIN Teams T ON U2.teamID = T.teamID";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new Unavailable($dbRow);
        }

        $this->_dbInstance->destruct();

        return $data;
    }

}