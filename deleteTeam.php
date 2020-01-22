<?php
require_once ("models/TeamData.php");
require_once ("models/LogsData.php");
require_once ("models/Team.php");
session_start();

// Grab the Team by the provided ID and delete them from the system and update the Logs

$teamID = $_GET['teamID'];
$teamData = new TeamData();
$logData = new LogsData();

$teamName = $teamData->getTeamNameByID($teamID);
$logData->addLog($_SESSION['userID'], 'deleted', null, $teamName, null);
$delTeam = $teamData->deleteTeam($teamID);

header("Location: adminPanel.php");