<?php
require_once ("models/UserData.php");

$id = $_GET['userID'];

$teamData = new TeamData();

$teamData->updateTeam($id);

header("Location: index.php");