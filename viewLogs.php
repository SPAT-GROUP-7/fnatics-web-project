<?php
session_start();

require_once("models/LogsData.php");

$view = new stdClass();
$view->title = "Schedule System - Fanatics";
$view->pageName = "logs";

$logs = new LogsData();

$view->logs = $logs->viewLog();

require_once("views/logs.phtml");