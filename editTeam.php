<?php
require_once ("models/UserData.php");

$teamID = $_GET['teamID'];
echo "DELETING " . $teamID;

$teamName = htmlentities($_POST['teamName']);
$isBusy = htmlentities($_POST['isBusy']);
$teamData = new TeamData();
$teamData->updateTeam($teamID);

header("Location: index.php");