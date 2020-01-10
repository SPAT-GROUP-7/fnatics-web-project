<?php
require_once ("Database.php");
require_once ("Team.php");

class TeamData
{
    protected  $_dbHandle, $_dbInstance;

    // Establish a connection to the DB
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }

    //Fetch team by ID
    public function fetchTeam($teamID){
        $statement = $this->_dbHandle->prepare("SELECT teamName, isBusy, firstName, lastName  FROM Teams, Users ORDER BY teamName DESC");
        $statement->execute();
        $this->_dbInstance->destruct();

        $dataSet = [];
        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new Team($dbRow);
        }
        return $dataSet;
    }

    //Fetches all teams
    public function fetchAllTeams(){
        $sqlQuery = "SELECT * FROM Teams";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new Team($dbRow);
        }

        $this->_dbInstance->destruct();
        return $dataSet;
    }

    public function getAllUsers() {
        $sqlQuery = "SELECT * FROM Users U";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new User($dbRow);
        }

        $this->_dbInstance->destruct();

        return $data;
    }

    //Creates a team
    public function createTeam($teamName, $isBusy) {
        $sqlQuery = "INSERT INTO Teams (teamName, dateCreated, lastUpdate, isBusy)
                     VALUES (:teamName, NOW(), NOW(), :isBusy)"
        ;
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":teamName", $teamName, PDO::PARAM_STR);
        $statement->bindValue(":isBusy", $isBusy, PDO::PARAM_INT);


        $statement->execute();

        $this->_dbInstance->destruct();

    }

    public function updateTeam(){
        $statement = $this->_dbHandle->prepare("UPDATE Teams SET teamName, ");
        $statement->execute();
        $this->_dbInstance->destruct();

        $dataSet = [];
        while ($dbRow = $statement->fetch()) {
            $dataSet[] = new Team($dbRow);
        }
        return $dataSet;
    }

    //Deletes a team
    public function deleteTeam($teamName){
        $sqlQuery = "DELETE * FROM Teams WHERE teamName = $teamName ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $this->_dbInstance->destruct();
    }

}