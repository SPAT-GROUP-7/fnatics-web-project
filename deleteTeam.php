<?php
require_once ("models/TeamData.php");
require_once ("models/LogsData.php");
require_once ("models/Team.php");
session_start();


$teamID = $_GET['teamID'];
$teamData = new TeamData();
$logData = new LogsData();

$teamName = $teamData->getTeamNameByID($teamID);
$delTeam = $teamData->deleteTeam($teamID);

if ($delTeam) {
    $logData->addLog($_SESSION['userID'], 'delete', null, $teamName);
}


header("Location: index.php");