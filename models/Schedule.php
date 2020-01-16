<?php
/**
 * Created by PhpStorm.
 * User: sgb959
 * Date: 10/01/20
 * Time: 14:11
 */

class Schedule implements JsonSerializable
{
    protected $_from, $_to, $_devA, $_devB;
    public function __construct() {

    }

    public static function fromRow($dbRow) {
        $instance = new self();

        $instance->_from = date('F j, Y',strtotime($dbRow['dateFrom']));
        $instance->_to = date('F, j, Y', strtotime($dbRow['dateTo']));
        $instance->_devA = $dbRow['devA'];
        $instance->_devB = $dbRow['devB'];

        return $instance;
    }

    public static function fromString($from, $to, $devA, $devB) {
        $instance = new self();

        $instance->_from  = $from;
        $instance->_to = $to;
        $instance->_devA  = $devA;
        $instance->_devB  = $devB;

        return $instance;
    }

    public function getFrom() {
        return $this->_from;
    }

    public function getTo(){
        return $this->_to;
    }

    public function getDevA() {
        return $this->_devA;
    }

    public function getDevB() {
        return $this->_devB;
    }

    public function getDevs() {
        return array($this->_devA, $this->_devB);
    }

    public function displayRota() {
        echo $this->_from . " : " . $this->_to . " : " . $this->_devA->getUserID() . " : " . $this->_devB->getUserID() . "</br>";
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}