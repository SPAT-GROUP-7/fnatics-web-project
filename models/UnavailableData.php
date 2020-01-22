<?php
require_once 'models/Unavailable.php';
require_once ("Database.php");

/**
 * Class UnavailableData
 */
class UnavailableData
{
    /**
     * @var PDO
     */
    /**
     * @var Database|PDO
     */
    protected $_dbHandle, $_dbInstance;

    /** Establish a connection to the database
     *
     * UnavailableData constructor.
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }


    /**
     * @param $userID : the ID of the User
     * @param $teamID : the ID of the Users Team
     * @param $dateFrom : the start date of the absence
     * @param $dateTo : the end date of the absence
     */
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

    /** This function will return all unavailable Users in the system
     *
     * @return array : a collection of Unavailable Objects
     */
    public function getAllUnavailableUsers() {
        $sqlQuery = "SELECT U2.unaID, CONCAT(U.firstName, ' ', U.lastName) as 'name', T.teamID, U2.dateFrom, U2.dateTo 
                     FROM Unavailable U2
                        JOIN Users U  ON U2.userID = U.userID
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












