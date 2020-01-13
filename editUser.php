<?php

require_once ("models/UserData.php");

if (isset($_POST['username'])){
    $userID = htmlentities($_POST['userID']);
    $username = htmlentities($_POST['username']);
    $firstName = htmlentities($_POST['firstName']);
    $lastName = htmlentities($_POST['lastName']);
    $teamID = htmlentities($_POST['teamID']);
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

    $userData = new UserData();
    $userData->updateUser($userID, $teamID, $username, $firstName, $lastName, $isAdmin);
}


header("Location: adminPanel.php");

