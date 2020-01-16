<?php
require_once ("models/TeamData.php");
require_once ("models/LogsData.php");
session_start();

$logData = new LogsData();

if (isset($_POST['teamName'])) {
    $output = '';

    $teamID = $_POST['teamID'];
    $teamName = htmlentities($_POST['teamName']);
    $isBusy = isset($_POST['isBusy']) ? 1 : 0;

    $teamData = new TeamData();
    $teamData->getTeamNameByID($teamID);

    if ($teamData->checkTeamNameExistsIgnore($teamName, $teamID)){
        $teamData->updateTeam(intval($teamID), $teamName, $isBusy);
        $logData->addLog($_SESSION['userID'], 'UPDATED', null, $teamName);
    } else {
        $output = '<div class="alert alert-danger" id="error-message" role="alert">
                            <strong>Error:</strong> A team with that name already exists!
                        </div>';
    }

    echo $output;
}