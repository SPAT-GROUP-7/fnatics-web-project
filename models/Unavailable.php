<?php


/**
 * Class Unavailable
 * This class is used to represent absent users
 */
class Unavailable implements JsonSerializable
{
    /**
     * @var $unavailableID : the ID of the instance
     */
    /**
     * @var $userID : the ID of the user who is unavailable
     */
    /**
     * @var $teamID : the ID of the team which a user belongs to
     */
    /**
     * @var $dateFrom : the start date of the absence
     */
    /**
     * @var $dateTo : the end date of the absence
     */
    protected $unavailableID, $userID, $teamID, $dateFrom, $dateTo;

    /**
     * @param $dbRow : the database row containing the information to construct an Object
     * Unavailable constructor.
     */
    public function __construct($dbRow)
    {
        $this->unavailableID = $dbRow['unaID'];
        $this->userID = $dbRow['name'];
        $this->teamID = $dbRow['teamID'];
        $this->dateFrom = date('F j, Y',strtotime($dbRow['dateFrom']));;
        $this->dateTo = date('F j, Y',strtotime($dbRow['dateTo']));;
    }

    /**
     * @return mixed : get the ID of the instance
     */
    public function getUnavailableID()
    {
        return $this->unavailableID;
    }

    /**
     * @param mixed $unavailableID : the new ID of the instance
     */
    public function setUnavailableID($unavailableID): void
    {
        $this->unavailableID = $unavailableID;
    }

    /**
     * @return mixed : the ID of the User
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param mixed $userID : the new ID of the User
     */
    public function setUserID($userID): void
    {
        $this->userID = $userID;
    }

    /**
     * @return mixed : the ID of the team
     */
    public function getTeamID()
    {
        return $this->teamID;
    }

    /**
     * @param mixed $teamID : the new ID of the team
     */
    public function setTeamID($teamID): void
    {
        $this->teamID = $teamID;
    }

    /**
     * @return mixed : the start date
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param mixed $dateFrom : the new start date
     */
    public function setDateFrom($dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return mixed : the end date
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param mixed $dateTo : the new end date
     */
    public function setDateTo($dateTo): void
    {
        $this->dateTo = $dateTo;
    }

    /** Allows the PHP object to be encoded in JSON
     *
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}