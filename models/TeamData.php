<?php
require_once ("Database.php");
require_once ("Team.php");
require_once ("User.php");

/**
 * Class TeamData
 * This class is used to aggregate collections of Teams
 */
class TeamData
{
    /**
     * @var PDO
     */
    /**
     * @var Database|PDO
     */
    protected  $_dbHandle, $_dbInstance;


    /** Establish a connection to the database
     *
     * TeamData constructor.
     */
    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getConnection();
    }


    /** This function retrieves a team with a given ID
     *
     * @param $teamID : The ID of the team to retrieve
     * @return array : A team Object
     */
    public function fetchTeam($teamID){
        $sqlQuery = "SELECT * FROM Teams WHERE teamID = :teamID";
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(':teamID', $teamID, PDO::PARAM_INT);

        $statement->execute();
        $this->_dbInstance->destruct();

        $dataSet = [];
        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new Team($dbRow);
        }
        return $dataSet;
    }

    /** This function allows users to filter teams by providing a partial name, it will then perform a wildcard search
     *
     * @param $partialName : The name of the team to serach for
     * @return array : a collection of all teams which match the search criteria
     */
    public function fetchTeams($partialName) {
        $sqlQuery = "SELECT T.teamID, T.teamID, T.teamName, T.dateCreated, T.lastUpdate, T.isBusy, (select count(userID)
                      FROM Users where Users.teamID = T.teamID) as'memberCount'        
                     FROM Teams T
                     WHERE T.teamName LIKE concat(:partialName, '%')";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":partialName", $partialName, PDO::PARAM_STR);

        $statement->execute();

        $data = [];

        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new Team($dbRow);
        }

        $this->_dbInstance->destruct();

        return $data;
    }

    /** This function will retrieve all teams in the system
     * @return array : a collection of teams
     */
    public function fetchAllTeams(){
        $sqlQuery = "SELECT teamID, teamID, teamName, dateCreated, lastUpdate, isBusy, (select count(userID)
                      FROM Users where Users.teamID = Teams.teamID) as'memberCount'        
                     FROM Teams";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataSet = [];
        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new Team($dbRow);

        }

        $this->_dbInstance->destruct();
        return $dataSet;
    }


    /** This function will add a new team to the system
     * @param $teamName : the name of the new team
     * @param $isBusy : a flag stating whether the team is busy
     */
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

    /** This function will update a team with a given ID
     *
     * @param $teamID : the ID of the team to update
     * @param $teamName : the potentially new name of the team
     * @param $isBusy : the potentially new flag on whether the team is busy
     */
    public function updateTeam($teamID, $teamName, $isBusy){
        $statement = $this->_dbHandle->prepare("UPDATE Teams SET teamName = :teamName, isBusy = :isBusy WHERE teamID = :teamID");


        $statement->bindValue(":teamID", $teamID, PDO::PARAM_INT);
        $statement->bindValue(":teamName", $teamName, PDO::PARAM_STR);
        $statement->bindValue(":isBusy", $isBusy, PDO::PARAM_BOOL);

        $statement->execute();
        $this->_dbInstance->destruct();
    }


    /** This function will delete a team with the matching ID
     *
     * @param $id : The id of the team to delete
     */
    public function deleteTeam($id){
        $sqlQuery = "DELETE FROM Teams WHERE teamID = :teamID";
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":teamID", $id, PDO::PARAM_INT);
        $statement->execute();
        $this->_dbInstance->destruct();

    }

    /** This function will retrieve the teamname of a team with a given ID
     *
     * @param $id : The ID of the team to fetch
     * @return string : the TeamName if found
     */
    public function getTeamNameByID($id){
        $sqlQuery = "SELECT teamName FROM Teams T
                     WHERE T.teamID = :teamID";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindValue(":teamID", $id, PDO::PARAM_INT);
        $statement->execute();
        $this->_dbInstance->destruct();

        $r = '';
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $r = $row['teamName'];
        }

        return $r;
    }


    /** This function will check the current list of teams for a matching teamname when a new team is being created / updated
     *
     * @param $teamName : the name of the team to search for
     * @return bool : whether any team was found
     */
    public function checkTeamNameExists($teamName){
        $sqlQuery = "SELECT * FROM Teams
                     WHERE teamName = :teamName";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindValue(":teamName", $teamName, PDO::PARAM_STR);
        $statement->execute();
        $this->_dbInstance->destruct();

        return ($statement->fetch() == null);
    }


    /**
     * @param $newTeamName
     * @param $id
     * @return bool
     */
    public function checkTeamNameExistsIgnore($newTeamName, $id){
        $sqlQuery = "SELECT teamName FROM Teams
                     WHERE teamID = :teamID"; // Get user's old email.

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindValue(":teamID", $id, PDO::PARAM_STR);
        $statement->execute();
        $this->_dbInstance->destruct();

        $r = $statement->fetch();

        if (!$this->checkTeamNameExists($newTeamName)){ //If new team name exists
            if ($r['teamName'] == $newTeamName){ //If new team name == old team name
                return true; //New team name == old username
            } else {
                return false; //New team name already exists.
            }
        } else {
            return true; //New team name is new.
        }
    }

    /** This function will retrieve all members for a given team
     *
     * @param $teamID : the ID of the team
     * @return array : an array of members for that given team
     */
    public function getTeamMembers($teamID){
        $sqlQuery = "SELECT U.firstName, U.lastName FROM Users U
                     WHERE U.teamID = :teamID";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindValue(":teamID", $teamID, PDO::PARAM_STR);
        $statement->execute();
        $this->_dbInstance->destruct();

        $data = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $firstName = $row['firstName'];
            $lastName = $row['lastName'];
            $data[] = $firstName . ' '. $lastName;
        }

        return $data;
    }

    /**
     * @param $teamID
     * @return array
     */
    public function getTeamMembersNew($teamID) {
        $sqlQuery = "SELECT U.userID, T.teamName, U.username, U.password, U.firstName, U.lastName, U.dateCreated, U.lastUpdate, U.isAdmin 
                     FROM Users U
                     JOIN Teams T on U.teamID = T.teamID
                     WHERE U.teamID = :teamID";

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindValue(":teamID", $teamID, PDO::PARAM_STR);
        $statement->execute();


        $data = [];
        while ($dbRow = $statement->fetch(PDO::FETCH_ASSOC)){
            $data[] = new User($dbRow);
        }

        $this->_dbInstance->destruct();
        return $data;
    }


    /** This function determines whether a team is empty or not
     *
     * @param $teamID : the id of the team to check
     * @return bool : whether the team has any members
     */
    public function isTeamEmpty($teamID) {
        $sqlQuery = "SELECT U.userID
                     FROM Users U
                     JOIN Teams T on U.teamID = :teamID";

        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindValue(":teamID", $teamID, PDO::PARAM_INT);

        $statement->execute();

        $members = $statement->rowCount();

        $this->_dbInstance->destruct();

        return $members > 0;
    }
}