<?php

require_once ("models/UserData.php");
require_once ("models/LogsData.php");
require_once ("models/User.php");
require_once ("models/ScheduleData.php");

session_start();

$view = new stdClass();


$devA = htmlentities($_POST['devA']);
$devA = htmlentities($_POST['devB']);

$view->schedules = $scheduleData->getAllRotas();

header("Location: generateRota.php");