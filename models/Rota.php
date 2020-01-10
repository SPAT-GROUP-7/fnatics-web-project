<?php
/**
 * Created by PhpStorm.
 * User: sgb959
 * Date: 10/01/20
 * Time: 14:11
 */

class Rota
{
    protected $_from, $_to, $_devA, $_devB;
    public function __construct($dbRow) {
        $this->_from = $dbRow['from'];
        $this->_to = $dbRow['to'];
        $this->_devA = $dbRow['devA'];
        $this->_devB = $dbRow['devB'];
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

}