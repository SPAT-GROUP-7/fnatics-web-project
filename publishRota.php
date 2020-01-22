<?php
session_start();

require_once("models/ScheduleData.php");
require_once ("models/LogsData.php");

$scheduleData = new ScheduleData();
$logsData = new LogsData();

// Data provided is serialized, decode it
$schedules = unserialize(base64_decode($_POST['schedules']));

// insert each record into the database and update the Logs
foreach ($schedules as $schedule) {
    $convertedFromDate = date_format(date_create($schedule->getFrom()), "Y-m-d");
    $convertedToDate = date_format(date_create($schedule->getTo()), "Y-m-d");

    $scheduleData->createRota($convertedFromDate, $convertedToDate, $schedule->getDevA()->getUserID(), $schedule->getDevB()->getUserID());

}

$logsData->addLog($_SESSION['userID'], 'published a new rota', null, null, null);


header("Location: rota.php");

//$rotaData->createRota($from, $to, $devA, $devB);

//header("Location: rota.php");