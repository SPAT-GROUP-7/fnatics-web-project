<?php
require_once("models/ScheduleData.php");
require_once ("models/LogsData.php");
require_once ("models/UserData.php");

session_start();
$view = new stdClass();
$scheduleData = new ScheduleData();
$logData = new LogsData();
$userData = new UserData();

$view->title = "Generate new Schedule";

// If set, attempt to generate a list of N temporary rotas and update the Logs
if (isset($_POST['submit'])) {
    // Generate of given date ranges
    $to = $_POST['to'];
    $from = $_POST['from'];

    $view->schedules = $scheduleData->generateRotas($from, $to);
    $logData->addLog($_SESSION['userID'], 'generated a new rota', null, null, null);
} else {
    $from = date("d-m-Y");
    $to = date("d-m-Y", strtotime($from . "+ 56 days"));
    $view->schedules = $scheduleData->generateRotas($from, $to);
}
$view->users = $userData->getAllNonAdmins();
require_once ("views/generateRota.phtml");