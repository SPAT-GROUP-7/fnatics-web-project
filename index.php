<?php
session_start();

require_once("models/ScheduleData.php");

$view = new stdClass();
$view->title = "Schedule System - Fanatics";
$view->page = "index";
$rotaData = new ScheduleData();

// if set, a User is logged in, try to retrieve their personalised schedule, otherwise grab the next 4 schedules
if (isset($_SESSION['userID'])) {
    $id = $_SESSION['userID'];
    $view->rotas = $rotaData->getUserSchedules($id);
} else {
    $from = date("Y-m-d");
    $to = date("Y-m-d", strtotime($from. ' + 56 days'));
    $view->rotas = $rotaData->getRotas($from, $to);
}



require_once("views/index.phtml");