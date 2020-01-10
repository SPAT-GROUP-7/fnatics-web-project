<?php
require_once ("models/UserData.php");

if (isset($_POST['submit'])) {

    $userData = new UserData();

    $teamID = htmlentities($_POST['teamID']);
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $firstName = htmlentities($_POST['firstName']);
    $lastName = htmlentities($_POST['lastName']);
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

    $userData->createUser($teamID, $username, $password, $firstName, $lastName, $isAdmin);

    header("Location: index.php");
}
