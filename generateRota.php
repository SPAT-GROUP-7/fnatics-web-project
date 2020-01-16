<?php
require_once("models/ScheduleData.php");
require_once ("models/LogsData.php");

session_start();
$view = new stdClass();
$scheduleData = new ScheduleData();
$logData = new LogsData();

$view->title = "Generate new Schedule";

if (isset($_POST['submit'])) {
    // Generate of given date ranges
    $to = $_POST['to'];
    $from = $_POST['from'];

    $view->schedules = $scheduleData->generateRotas($from, $to);
    $logData->addLog($_SESSION['userID'], 'GENERATED A NEW ROTA', null, null);
} else {
    $view->schedules = $scheduleData->generateRotas("12-01-2020", "10-02-2020");
}

require_once ("views/generateRota.phtml");