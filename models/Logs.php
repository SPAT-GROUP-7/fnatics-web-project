<?php


/**
 * Class Logs
 * This class is used to represent a Log Object which provides an audit trail for changes made to the system
 */
class Logs
{
    /**
     * @var $logID : The ID in the database for a given Log Object
     */
    /**
     * @var $logEditor : The ID of the Admin user which performed the action
     */
    /**
     * @var $logAction : The action that caused the log to be triggered
     */
    /**
     * @var $logAffectedUser : The ID of the user affected by the action
     */
    /**
     * @var $logAffectedTeam : The ID of the team affected by the action
     */
    /**
     * @var $logDate : The timestamp corresponding to when the log was added to the database
     */
    /**
     * @var $logAffectedSchedule : The ID of the schedule affected by the action
     */
    private $logID, $logEditor, $logAction, $logAffectedUser, $logAffectedTeam, $logDate, $logAffectedSchedule;

    /**
     * Logs constructor.
     * @param $dbRow : A row from the database containing the information required to construct a Log Object
     */
    public function __construct($dbRow)
    {
        $this->logID = $dbRow['logID'];
        $this->logEditor = $dbRow['name'];
        $this->logAction = $dbRow['logActionType'];
        $this->logAffectedUser = $dbRow['logAffectedUser'];
        $this->logAffectedTeam = $dbRow['logAffectedTeam'];
        $this->logDate = $dbRow['logDate'];
        $this->logAffectedSchedule = $dbRow['logAffectedSchedule'];

    }

    /**
     * @return mixed $logID : retrieve the ID of the Log
     */
    public function getLogID()
    {
        return $this->logID;
    }

    /**
     * @param mixed $logID : The new ID for the given Log Object
     */
    public function setLogID($logID): void
    {
        $this->logID = $logID;
    }

    /**
     * @return mixed $logEditor : Retrieve the ID of the Admin associated with the Log Object
     */
    public function getLogEditor()
    {
        return $this->logEditor;
    }

    /**
     * @param mixed $logEditor : The new ID for the editor of the Log Object
     */
    public function setLogEditor($logEditor): void
    {
        $this->logEditor = $logEditor;
    }

    /**
     * @return mixed $logAction : Retrieve the action associated with the Log Object
     */
    public function getLogAction()
    {
        return $this->logAction;
    }

    /**
     * @param mixed $logAction : The new action for the Log Object
     */
    public function setLogAction($logAction): void
    {
        $this->logAction = $logAction;
    }

    /**
     * @return mixed : Retrieve the ID of the user affected by this Log Object
     */
    public function getLogAffectedUser()
    {
        return $this->logAffectedUser;
    }

    /**
     * @param mixed $logAffectedUser : The new ID of the user affected by this Log Object
     */
    public function setLogAffectedUser($logAffectedUser): void
    {
        $this->logAffectedUser = $logAffectedUser;
    }

    /**
     * @return mixed $logAffectedTeam : Retrieve the ID of the team affected by this Log Object
     */
    public function getLogAffectedTeam()
    {
        return $this->logAffectedTeam;
    }

    /**
     * @param mixed $logAffectedTeam : The new ID of the team affected by this Log Object
     */
    public function setLogAffectedTeam($logAffectedTeam): void
    {
        $this->logAffectedTeam = $logAffectedTeam;
    }

    /**
     * @return mixed $logDate : Retrieve the timestamp at which this Log was created
     */
    public function getLogDate()
    {
        return $this->logDate;
    }

    /**
     * @param mixed $logDate : The new Timestamp for when this Log was created
     */
    public function setLogDate($logDate): void
    {
        $this->logDate = $logDate;
    }

    /**
     * @return mixed : Retrieve the ID of the schedule affected by this Log Object
     */
    public function getLogAffectedSchedule() {
        return $this->logAffectedSchedule;
    }


}