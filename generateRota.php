<?php
require_once("models/ScheduleData.php");

session_start();
$view = new stdClass();
$rotaData = new ScheduleData();
$view->title = "Generate new Schedule";
$view->rota = $rotaData->generateRota();
require_once ("views/generateRota.phtml");