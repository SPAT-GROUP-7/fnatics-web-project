<?php
session_start();

require_once("models/ScheduleData.php");

$view = new stdClass();
$view->title = "Schedule System - Fanatics";
$view->pageName = "index";
$rotaData = new ScheduleData();
if (isset($_SESSION['userID'])) {
    $id = $_SESSION['userID'];
    $view->rotas = $rotaData->getUserSchedules($id);
} else {
    $view->rotas = $rotaData->getAllRotas();
}



require_once("views/index.phtml");