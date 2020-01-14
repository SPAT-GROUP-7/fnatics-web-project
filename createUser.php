<?php
require_once ("models/UserData.php");

if (isset($_POST['firstName'])) {

    $userData = new UserData();
    $output = '';

    $teamID = htmlentities($_POST['teamID']);
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $firstName = htmlentities($_POST['firstName']);
    $lastName = htmlentities($_POST['lastName']);
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

    $emailExists = $userData->checkUsernameExists($username);

    if ($emailExists) {
        $userData->createUser($teamID, $username, $password, $firstName, $lastName, $isAdmin);
    } else {
        $output = '<div class="alert alert-danger" id="error-message" role="alert">
                            <strong>Error:</strong> A user with that email already exists!
                        </div>';
    }

    echo $output;
}
