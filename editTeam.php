<?php
require_once ("models/TeamData.php");
require_once ("models/LogsData.php");
require_once ("models/UnavailableData.php");
session_start();

$logData = new LogsData();
$unavailable = new UnavailableData();

// if set, attempt to edit a Team and update the Logs
if (isset($_POST['teamName'])) {
    $output = '';

    $teamID = $_POST['teamID'];
    $teamName = htmlentities($_POST['teamName']);
    $isBusy = isset($_POST['isBusy']) ? 1 : 0;
    $isBusyFrom = htmlentities($_POST['isBusyFrom']);
    $isBusyTo = htmlentities($_POST['isBusyTo']);

    $teamData = new TeamData();
    $teamData->getTeamNameByID($teamID);

    // Ensure the team name doesn't already exist in the system
    if ($teamData->checkTeamNameExistsIgnore($teamName, $teamID)){
        $teamData->updateTeam(intval($teamID), $teamName, $isBusy);
        $logData->addLog($_SESSION['userID'], 'updated', null, $teamName, null);
        if ($isBusy == 1){
            $members = $teamData->getTeamMembersNew($teamID);

            foreach ($members as $member) {
                    $unavailable->markAsAbsent($member->getUserID(), $teamID, $isBusyFrom, $isBusyTo);

            }

        }
    } else {
        $output = '<div class="alert alert-danger" id="error-message" role="alert">
                            <strong>Error:</strong> A team with that name already exists!
                        </div>';
    }

    echo $output;
}