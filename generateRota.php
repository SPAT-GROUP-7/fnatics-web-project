<?php
require_once("models/ScheduleData.php");

session_start();
$view = new stdClass();
$scheduleData = new ScheduleData();
$view->title = "Generate new Schedule";
$view->schedules = $scheduleData->generateRotas("13-01-2020", "10-02-2020");
require_once ("views/generateRota.phtml");