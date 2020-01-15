<?php
require_once ("models/TeamData.php");
require_once ("models/LogsData.php");
require_once ("models/Team.php");


$teamID = $_GET['teamID'];

$teamData = new TeamData();

$logs = new LogsData();

$team = $teamData->fetchTeam($teamID);

var_dump($team);
die();
$teamData->deleteTeam($teamID);

$logs->addNewLog(1, 'DELETED', NULL, NULL);


header("Location: index.php");