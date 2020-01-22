<?php

require_once ("models/UserData.php");
require_once ("models/LogsData.php");
require_once ("models/UnavailableData.php");
session_start();

$logData = new LogsData();

// If set, attempt to update a User and add to the Logs
if (isset($_POST['username'])){
    $output = '';

    $userID = htmlentities($_POST['userID']);
    $username = htmlentities($_POST['username']);
    $firstName = htmlentities($_POST['firstName']);
    $lastName = htmlentities($_POST['lastName']);
    $teamID = htmlentities($_POST['teamID']);
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;
    $dateFrom = $_POST['absentDateFrom'];
    $dateTo = $_POST['absentDateTo'];

    $userData = new UserData();
    $unavailable = new UnavailableData();
    $usernameQuery = $userData->checkUsernameExistsIgnore($username, $userID);

    $user = $userData->getUsernameByID($userID);

    if ($usernameQuery){
        $userData->updateUser($userID, $teamID, $username, $firstName, $lastName, $isAdmin);
        if ($isAbsent = isset($_POST['isAbsent'])){
            $unavailable->markAsAbsent($userID, $teamID, $dateFrom, $dateTo);
        }
        $logData->addLog($_SESSION['userID'], 'updated', $user, null, null);
    } else {
        $output = '<div class="alert alert-danger" id="error-message" role="alert">
                            <strong>Error:</strong> A user with that email already exists!
                        </div>';
    }

    echo $output;
}

