<?php
require_once ("models/TeamData.php");

if (isset($_POST['teamName'])) {
    $teamID = htmlentities($_POST['teamID']);
    $teamName = htmlentities($_POST['teamName']);
    $isBusy = isset($_POST['isBusy']) ? 1 : 0;

    $teamData = new TeamData();
    $teamData->updateTeam(intval($teamID), $teamName, $isBusy);
}

header("Location: adminPanel.php");