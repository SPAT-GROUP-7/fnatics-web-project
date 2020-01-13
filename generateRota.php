<?php
require_once("models/ScheduleData.php");

session_start();
$view = new stdClass();
$rotaData = new ScheduleData();
$view->title = "Generate new Schedule";
$view->rotas = $rotaData->generateRotas(date('d-m-Y'), $_POST['num']);
require_once ("views/generateRota.phtml");