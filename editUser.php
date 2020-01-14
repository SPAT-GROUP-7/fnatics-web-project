<?php

require_once ("models/UserData.php");

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

    if ($usernameQuery){
        $userData->updateUser($userID, $teamID, $username, $firstName, $lastName, $isAdmin);
    } else {
        $output = '<div class="alert alert-danger" id="error-message" role="alert">
                            <strong>Error:</strong> A user with that email already exists!
                        </div>';
    }

    echo $output;
}

