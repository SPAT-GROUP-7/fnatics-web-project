<?php
require_once("models/ScheduleData.php");

session_start();
$view = new stdClass();
$rotaData = new ScheduleData();
$view->title = "Generate new Schedule";
$view->rotas = $rotaData->generateRotas("01-01-2020", 6);
require_once ("views/generateRota.phtml");