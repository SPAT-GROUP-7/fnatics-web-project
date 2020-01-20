<?php

require_once ("models/UserData.php");
require_once ("models/LogsData.php");
require_once ("models/ScheduleData.php");

session_start();



$view = new stdClass();

$users = new UserData();
$schedule = new ScheduleData();

$devA = htmlentities($_POST['devA']);
$devB = htmlentities($_POST['devB']);
$scheduleID = htmlentities($_POST['scheduleID']);

$schedule->updateRota($scheduleID, $devA, $devB);

$view->users = $users->getAllNonAdmins();

$view->schedules = $schedule->getAllRotas();
