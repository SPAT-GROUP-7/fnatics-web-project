<?php
require_once("models/ScheduleData.php");

session_start();

$dateFrom = htmlentities($_POST['dateFrom']);
$dateTo = htmlentities($_POST['dateTo']);

$dateRange = new ScheduleData();
$dateRange->generateRotas($dateFrom, $dateTo);

$view = new stdClass();
$view->title = "Generating new Schedule";
$view->rotas = $rotaData->generateRotas($dateFrom, $dateTo);

header("Location: generateRota.phtml");
require_once("views/generateRota.phtml");
?>