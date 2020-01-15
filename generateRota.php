<?php
require_once("models/ScheduleData.php");

session_start();
$view = new stdClass();
$scheduleData = new ScheduleData();
$view->title = "Generate new Schedule";

if (isset($_POST['submit'])) {
    // Generate of given date ranges
    $to = $_POST['to'];
    $from = $_POST['from'];

    $view->schedules = $scheduleData->generateRotas($from, $to);
} else {
    $view->schedules = $scheduleData->generateRotas("12-01-2020", "10-02-2020");
}

require_once ("views/generateRota.phtml");