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
        $this->_dbInstance->__destruct();

        $dataSet = [];
        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new Team($dbRow);
        }
        return $dataSet;
    }

    //Fetches all teams
    public function fetchAllTeams(){
        $statement = $this->_dbHandle->prepare("SELECT teamName, isBusy, firstName, lastName FROM Teams, Users");
        $statement->execute();
        $this->_dbInstance->__destruct();

        $dataSet = [];
        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new Team($dbRow);
        }
        return $dataSet;
    }

    //Creates a team
    public function createTeam($teamID, $teamName, $dateCreated, $lastUpdate, $isBusy){
        $statement = $this->_dbHandle->prepare("INSERT INTO Teams (teamID, teamName, dateCreated, lastUpdate, isBusy) VALUES :teamId, :teamName:, :dateCreated, :lastUpdate, :isBusy");

        $statement->bindValue(":teamID", $teamID, PDO::PARAM_INT);
        $statement->bindValue(":teamName", $teamName, PDO::PARAM_STR);
        $statement->bindValue(":dateCreated", $dateCreated, PDO::PARAM_STR);
        $statement->bindValue(":lastUpdate", $lastUpdate, PDO::PARAM_STR);
        $statement->bindValue(":isBusy", $isBusy, PDO::PARAM_STR);

        $statement->execute();

        $this->_dbInstance->__destruct();

    }

    public function updateTeam(){
        $statement = $this->_dbHandle->prepare("UPDATE Teams SET teamName, ");
        $statement->execute();
        $this->_dbInstance->__destruct();

        $dataSet = [];
        while ($dbRow = $statement->fetch()) {
            $dataSet[] = new Team($dbRow);
        }
        return $dataSet;
    }

    public function deleteTeam($teamName){
        $statement = $this->_dbHandle->prepare("DELETE * FROM Teams WHERE teamName = $teamName ");
        $statement->execute();
        $this->_dbInstance->__destruct();

        $dataSet = [];
        while ($dbRow = $statement->fetch()) {
            $dataSet[] = new Team($dbRow);
        }
        return $dataSet;
    }

}