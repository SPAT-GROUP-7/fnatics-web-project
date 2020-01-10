<?php
/**
 * Created by PhpStorm.
 * User: sgb959
 * Date: 09/01/20
 * Time: 12:24
 */

class Team
{
    protected $_teamID, $_teamName, $_isBusy, $_dateCreated, $_dateLastUpdated;

    public function __construct($dbRow)
    {
        $this->_teamID = $dbRow['teamID'];
        $this->_teamName = $dbRow['teamName'];
        $this->_isBusy = $dbRow['isBusy'] == 1 ? "Yes" : "No" ;
        $this->_dateCreated = $dbRow['dateCreated'];
        $this->_dateLastUpdated = $dbRow['lastUpdate'];
    }

    /**
     * @return mixed
     */
    public function getTeamID()
    {
        return $this->_teamID;
    }

    /**
     * @return mixed
     */
    public function getTeamName()
    {
        return $this->_teamName;
    }

    /**
     * @return mixed
     */
    public function getIsBusy()
    {
        return $this->_isBusy;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->_dateCreated;
    }

    /**
     * @return mixed
     */
    public function getDateLastUpdated()
    {
        return $this->_dateLastUpdated;
    }


}