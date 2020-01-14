<?php
require_once ("models/TeamData.php");

if (isset($_POST['teamName'])) {
    $output = '';

    $teamID = $_POST['teamID'];
    $teamName = htmlentities($_POST['teamName']);
    $isBusy = isset($_POST['isBusy']) ? 1 : 0;

    $teamData = new TeamData();

    if ($teamData->checkTeamNameExists($teamName)){
        $teamData->updateTeam(intval($teamID), $teamName, $isBusy);
    } else {
        $output = '<div class="alert alert-danger" id="error-message" role="alert">
                            <strong>Error:</strong> A team with that name already exists!
                        </div>';
    }

    echo $output;
}