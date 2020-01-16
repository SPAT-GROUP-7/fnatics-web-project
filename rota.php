<?php
session_start();
require_once("models/ScheduleData.php");

$rotaData = new ScheduleData();
$view = new stdClass();
$view->title = "Schedule View";
$view->rotas = $rotaData->getRotas("2020-01-01", "2020-02-28");

require_once ("views/rota.phtml");
