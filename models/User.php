<?php
/**
 * Created by PhpStorm.
 * User: sgb959
 * Date: 09/01/20
 * Time: 12:24
 */

class User
{
    /**
     * @var $_userID : the ID of the User
     */
    /**
     * @var $_teamName : the name of the Team the User belongs to
     */
    /**
     * @var $_username : the username of the User
     */
    /**
     * @var $_password : the password of the User
     */
    /**
     * @var $_firstName : the first name of the User
     */
    /**
     * @var $_lastName : the last name of the User
     */
    /**
     * @var $_dateCreated : the DateTime the User was created in the System
     */
    /**
     * @var $_dateLastUpdated : the DateTime the User was last modified
     */
    /**
     * @var $_isAdmin : a flag set whether the user has Administrator privileges
     */
    protected $_userID, $_teamName, $_username, $_password, $_firstName, $_lastName, $_dateCreated, $_dateLastUpdated, $_isAdmin;

    /**
     * User constructor.
     * @param $dbRow : a database row containing information to create a User Object
     */
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
     * @return mixed : the ID of the User
     */
    public function getUserID()
    {
        return $this->_userID;
    }

    /**
     * @return mixed : the teamName of the User
     */
    public function getTeamName()
    {
        return $this->_teamName;
    }

    /**
     * @return mixed : the Username of the User
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @return mixed : the FirstName of the User
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * @return mixed : the LastName of the User
     */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * @return mixed : the DateTime the user was created
     */
    public function getDateCreated()
    {
        return $this->_dateCreated;
    }

    /**
     * @return mixed : the DateTime the User was last modified
     */
    public function getDateLastUpdated()
    {
        return $this->_dateLastUpdated;
    }

    /**
     * @return mixed : whether the User is an admin
     */
    public function getIsAdmin()
    {
        return $this->_isAdmin;
    }


}