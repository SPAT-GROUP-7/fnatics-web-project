<?php
require_once ("models/TeamData.php");

$teamID = $_GET['teamID'];
echo "DELETING " . $teamID;

$teamData = new TeamData();
$teamData->deleteTeam($teamID);

header("Location: index.php");