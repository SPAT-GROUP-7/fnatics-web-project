<?php
session_start();

require_once("models/ScheduleData.php");

$view = new stdClass();
$view->title = "Schedule System - Fanatics";
$view->pageName = "index";

$rotaData = new ScheduleData();
$view->rotas = $rotaData->getAllRotas();

require_once("views/index.phtml");