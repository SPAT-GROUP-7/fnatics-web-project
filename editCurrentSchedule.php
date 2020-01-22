<?php

require_once ("models/UserData.php");
require_once ("models/LogsData.php");
require_once ("models/ScheduleData.php");

session_start();

/*
 *  Update the selected schedule and update the logs accordingly
 */

$view = new stdClass();

$users = new UserData();
$schedule = new ScheduleData();
$logs = new LogsData();

$devA = htmlentities($_POST['devA']);
$devB = htmlentities($_POST['devB']);
$scheduleID = htmlentities($_POST['scheduleID']);

$schedule->updateRota($scheduleID, $devA, $devB);

$logs->addLog($_SESSION['userID'], "updated a rota", null, null, $scheduleID);

$view->users = $users->getAllNonAdmins();

$view->schedules = $schedule->getAllRotas();
