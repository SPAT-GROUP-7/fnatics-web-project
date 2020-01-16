<?php
require_once ("models/TeamData.php");
require_once ("models/LogsData.php");
require_once ("models/Team.php");
session_start();


$teamID = $_GET['teamID'];
$teamData = new TeamData();
$logData = new LogsData();

$teamName = $teamData->getTeamNameByID($teamID);
$logData->addLog($_SESSION['userID'], 'deleted', null, $teamName);
$delTeam = $teamData->deleteTeam($teamID);

header("Location: index.php");