<?php

require_once ("models/UserData.php");
require_once ("models/LogsData.php");
session_start();

$logData = new LogsData();

if (isset($_POST['username'])){
    $output = '';

    $userID = htmlentities($_POST['userID']);
    $username = htmlentities($_POST['username']);
    $firstName = htmlentities($_POST['firstName']);
    $lastName = htmlentities($_POST['lastName']);
    $teamID = htmlentities($_POST['teamID']);
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

    $userData = new UserData();
    $usernameQuery = $userData->checkUsernameExistsIgnore($username, $userID);

    $user = $userData->getUsernameByID($userID);

    if ($usernameQuery){
        $userData->updateUser($userID, $teamID, $username, $firstName, $lastName, $isAdmin);
        $logData->addLog($_SESSION['userID'], 'UPDATED', $user, null);
    } else {
        $output = '<div class="alert alert-danger" id="error-message" role="alert">
                            <strong>Error:</strong> A user with that email already exists!
                        </div>';
    }

    echo $output;
}

