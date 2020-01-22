<?php
require_once ("models/UserData.php");
require_once ("models/LogsData.php");
session_start();

// If set, attempt to create a new User and update the Logs
if (isset($_POST['firstName'])) {

    $userData = new UserData();
    $logData = new LogsData();
    $output = '';

    $teamID = htmlentities($_POST['teamID']);
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $firstName = htmlentities($_POST['firstName']);
    $lastName = htmlentities($_POST['lastName']);
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;


    // Ensure no one with that Username already exists (must be unique)
    $emailExists = $userData->checkUsernameExists($username);

    if ($emailExists) {
        $userData->createUser($teamID, $username, $password, $firstName, $lastName, $isAdmin);
        $logData->addLog($_SESSION['userID'], 'created', $firstName . $lastName, null, null);
    } else {
        $output = '<div class="alert alert-danger" id="error-message" role="alert">
                            <strong>Error:</strong> A user with that email already exists!
                        </div>';
    }

    echo $output;
}
