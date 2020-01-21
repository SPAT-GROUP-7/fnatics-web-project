<?php
require_once ("models/TeamData.php");
require_once ("models/LogsData.php");
session_start();

if (isset($_POST['teamName'])) {

    $teamData = new TeamData();
    $logData = new LogsData();
    $output = '';


    $_teamName = htmlentities($_POST['teamName']);
    $_isBusy = isset($_POST['isBusy']) ? 1 : 0;


    if ($teamData->checkTeamNameExists($_teamName)){
        $teamData->createTeam($_teamName, $_isBusy);
        $logData->addLog($_SESSION['userID'], 'created', null, $_teamName, null);
    } else {
        $output = '<div class="alert alert-danger" id="error-message" role="alert">
                            <strong>Error:</strong> A team with that name already exists!
                        </div>';
    }

    echo $output;
}
