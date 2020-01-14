<?php
session_start();

require_once("models/ScheduleData.php");

$scheduleData = new ScheduleData();
$schedules = unserialize(base64_decode($_POST['schedules']));


foreach ($schedules as $schedule) {
    $convertedFromDate = date_format(date_create($schedule->getFrom()), "Y-m-d");
    $convertedToDate = date_format(date_create($schedule->getTo()), "Y-m-d");

    $scheduleData->createRota($convertedFromDate, $convertedToDate, $schedule->getDevA()->getUserID(), $schedule->getDevB()->getUserID());
}

header("Location: rota.php");

//$rotaData->createRota($from, $to, $devA, $devB);

//header("Location: rota.php");