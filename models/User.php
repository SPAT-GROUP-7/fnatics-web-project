<?php
/**
 * Created by PhpStorm.
 * User: sgb959
 * Date: 09/01/20
 * Time: 12:24
 */

class User
{
    protected $_userID, $_teamName, $_username, $_password, $_firstName, $_lastName, $_dateCreated, $_dateLastUpdated, $_isAdmin;

    public function __construct($dbRow)
    {
        $this->_userID = $dbRow['userID'];
        $this->_teamName = $dbRow['teamName'];
        $this->_username = $dbRow['username'];
        $this->_password = $dbRow['password'];
        $this->_firstName = $dbRow['firstName'];
        $this->_lastName = $dbRow['lastName'];
        $this->_dateCreated = $dbRow['dateCreated'];
        $this->_dateLastUpdated = $dbRow['lastUpdate'];
        // TODO: Maybe a better way of doing this?
        $this->_isAdmin = $dbRow['isAdmin'] == 1 ? "Yes" : "No";
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->_userID;
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
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->_lastName;
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

    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->_isAdmin;
    }


}