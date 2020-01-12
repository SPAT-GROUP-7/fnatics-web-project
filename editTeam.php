<?php
require_once ("models/UserData.php");

$teamID = $_GET['teamID'];

$teamName = htmlentities($_POST['teamName']);
echo $teamName;
$isBusy = htmlentities($_POST['isBusy']);
$teamData = new TeamData();
$teamData->updateTeam($teamID, $teamName, $isBusy);

header("Location: index.php");