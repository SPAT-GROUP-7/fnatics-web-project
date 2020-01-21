<?php


class Logs
{
    private $logID, $logEditor, $logAction, $logAffectedUser, $logAffectedTeam, $logDate, $logAffectedSchedule;

    /**
     * Logs constructor.
     * @param $dbRow
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

        //var_dump($this->logID, $this->logEditor, $this->logAction, $this->logAffectedUser, $this->logAffectedTeam, $this->logDate);
    }

    /**
     * @return mixed
     */
    public function getLogID()
    {
        return $this->logID;
    }

    /**
     * @param mixed $logID
     */
    public function setLogID($logID): void
    {
        $this->logID = $logID;
    }

    /**
     * @return mixed
     */
    public function getLogEditor()
    {
        return $this->logEditor;
    }

    /**
     * @param mixed $logEditor
     */
    public function setLogEditor($logEditor): void
    {
        $this->logEditor = $logEditor;
    }

    /**
     * @return mixed
     */
    public function getLogAction()
    {
        return $this->logAction;
    }

    /**
     * @param mixed $logAction
     */
    public function setLogAction($logAction): void
    {
        $this->logAction = $logAction;
    }

    /**
     * @return mixed
     */
    public function getLogAffectedUser()
    {
        return $this->logAffectedUser;
    }

    /**
     * @param mixed $logAffectedUser
     */
    public function setLogAffectedUser($logAffectedUser): void
    {
        $this->logAffectedUser = $logAffectedUser;
    }

    /**
     * @return mixed
     */
    public function getLogAffectedTeam()
    {
        return $this->logAffectedTeam;
    }

    /**
     * @param mixed $logAffectedTeam
     */
    public function setLogAffectedTeam($logAffectedTeam): void
    {
        $this->logAffectedTeam = $logAffectedTeam;
    }

    /**
     * @return mixed
     */
    public function getLogDate()
    {
        return $this->logDate;
    }

    /**
     * @param mixed $logDate
     */
    public function setLogDate($logDate): void
    {
        $this->logDate = $logDate;
    }

    public function getLogAffectedSchedule() {
        return $this->logAffectedSchedule;
    }


}