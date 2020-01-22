<?php
/**
 * Created by PhpStorm.
 * User: sgb959
 * Date: 09/01/20
 * Time: 12:24
 */

class Team implements JsonSerializable
{
    /**
     * @var $_teamID : the ID of the team
     */
    /**
     * @var $_teamName : The name of the team
     */
    /**
     * @var $_isBusy : status whether the team is eligible to be on a Schedule
     */
    /**
     * @var $_dateCreated : The DateTime the team was created
     */
    /**
     * @var $_dateLastUpdated : The DateTime the team was last modified
     */
    /**
     * @var $_memberCount : An Integer representing how many users are in a team
     */
    protected $_teamID, $_teamName, $_isBusy, $_dateCreated, $_dateLastUpdated, $_memberCount;

    /**
     * Team constructor.
     * @param $dbRow : A database row containing information to create a Team Object
     */
    public function __construct($dbRow)
    {
        $this->_teamID = $dbRow['teamID'];
        $this->_teamName = $dbRow['teamName'];
        $this->_isBusy = $dbRow['isBusy'] == 1 ? "Yes" : "No" ;
        $this->_dateCreated = $dbRow['dateCreated'];
        $this->_dateLastUpdated = $dbRow['lastUpdate'];
        $this->_memberCount = $dbRow['memberCount'];
    }

    /**
     * @return mixed : The ID of the Team
     */
    public function getTeamID()
    {
        return $this->_teamID;
    }

    /**
     * @return mixed : The name of the Team
     */
    public function getTeamName()
    {
        return $this->_teamName;
    }

    /**
     * @return mixed : The busy status of the Team
     */
    public function getIsBusy()
    {
        return $this->_isBusy;
    }

    /**
     * @return mixed : The DateTime the team was created
     */
    public function getDateCreated()
    {
        return $this->_dateCreated;
    }

    /**
     * @return mixed : The DateTime the team was last modified
     */
    public function getDateLastUpdated()
    {
        return $this->_dateLastUpdated;
    }

    /**
     * @return mixed : How many users the Team has
     */
    public function getMemberCount() {
        return $this->_memberCount;
    }

    /** This function allows the PHP Object to be converted to JSON
     *
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}