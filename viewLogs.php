<?php
session_start();

require_once("models/LogsData.php");
require_once("models/UserData.php");
require_once("models/TeamData.php");
require_once("models/ScheduleData.php");

$editor = $_SESSION['username'];

$logs = new LogsData();
$team = new TeamData();
$user = new ScheduleData();

require_once("views/logs.phtml");