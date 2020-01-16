<?php
session_start();

require_once("models/ScheduleData.php");

$view = new stdClass();
$view->title = "Schedule System - Fanatics";
$view->pageName = "index";
$rotaData = new ScheduleData();
if (isset($_SESSION['userID'])) {
    //TODO: change this with test data so there is a user on the schedule that we can login with
    $id = 129;
//    $id = $_SESSION['userID'];
    $view->rotas = $rotaData->getUserSchedules($id);
} else {
    $view->rotas = $rotaData->getAllRotas();
}



require_once("views/index.phtml");