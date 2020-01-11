<?php
session_start();
require_once("models/ScheduleData.php");

$rotaData = new ScheduleData();
$view = new stdClass();
$view->title = "Schedule View";
$view->rotas = $rotaData->getAllRotas();

require_once ("views/rota.phtml");
