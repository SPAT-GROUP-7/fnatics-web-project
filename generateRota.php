<?php
require_once("models/ScheduleData.php");

session_start();
$view = new stdClass();
$scheduleData = new ScheduleData();
$view->title = "Generate new Schedule";
$view->schedules = $scheduleData->generateRotas(date('d-m-Y'), $_POST['num']);
require_once ("views/generateRota.phtml");