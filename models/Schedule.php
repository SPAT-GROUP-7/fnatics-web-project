<?php
/**
 * Created by PhpStorm.
 * User: sgb959
 * Date: 10/01/20
 * Time: 14:11
 */

class Schedule implements JsonSerializable
{
    /**
     * @var $_scheduleID : The ID of the Schedule Object
     */
    /**
     * @var $_from: The start date in the format "10th January 2020" of the Schedule
     */
    /**
     * @var $_to : The end date in the format "10th January 2020" of the Schedule
     */
    /**
     * @var $_devA : The ID of the 1st developer on the Schedule
     */
    /**
     * @var $_devB : The ID of the 2nd developer on the Schedule
     */
    protected $_scheduleID, $_from, $_to, $_devA, $_devB;

    /**
     * Schedule constructor.
     * Does nothing as PHP doesn't support multiple constructors so we simply need a way to create an instance
     */
    public function __construct() {

    }

    /**
     * @param $dbRow : A row from the database containing the information required to construct a Schedule Object
     * @return Schedule : A schedule Object from the provided data
     */
    public static function fromRow($dbRow) {
        $instance = new self();

        $instance->_scheduleID = $dbRow['rotaID'];
        $instance->_from = date('F j, Y',strtotime($dbRow['dateFrom']));
        $instance->_to = date('F, j, Y', strtotime($dbRow['dateTo']));
        $instance->_devA = $dbRow['devA'];
        $instance->_devB = $dbRow['devB'];

        return $instance;
    }

    /** This function allows us to create a "temporary" Schedule without actually committing it to the database
     *  this is helpful when generating schedules that may change before being added to the database
     *
     * @param $from : The start date of the Schedule in the format Y-m-d
     * @param $to : The end date of the Schedule in the format Y-m-d
     * @param $devA : The ID of the 1st developer
     * @param $devB : The ID of the 2nd developer
     * @return Schedule : A schedule Object created from the provided information
     */
    public static function fromString($from, $to, $devA, $devB) {
        $instance = new self();

        $instance->_from  = $from;
        $instance->_to = $to;
        $instance->_devA  = $devA;
        $instance->_devB  = $devB;

        return $instance;
    }

    /**
     * @return mixed : Retrieve the ID of a given Schedule Object
     */
    public function getScheduleID() {
        return $this->_scheduleID;
    }

    /**
     * @return mixed : Retrieve the From date of a given Schedule Object
     */
    public function getFrom() {
        return $this->_from;
    }

    /**
     * @return mixed : Retrieve the To date of a given Schedule Object
     */
    public function getTo(){
        return $this->_to;
    }

    /**
     * @return mixed : Retrieve the ID of the 1st developer
     */
    public function getDevA() {
        return $this->_devA;
    }

    /**
     * @return mixed : Retrieve the ID of the 2nd developer
     */
    public function getDevB() {
        return $this->_devB;
    }

    /**
     * @return array
     */
    public function getDevs() {
        return array($this->_devA, $this->_devB);
    }

    /**
     * This function is purely for debugging purposes and will display the schedule object in a formatted way
     */
    public function displayRota() {
        echo $this->_from . " : " . $this->_to . " : " . $this->_devA . " : " . $this->_devB . "</br>";
    }

    /** This function is used when passing the PHP Object to Javascript code
     *  It allows it to be serialised into JSON format
     *
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}