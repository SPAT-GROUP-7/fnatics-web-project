<?php

require_once ("models/UserData.php");
require_once ("models/TeamData.php");

$view = new stdClass();

if (isset($_POST['submit']))
{
    $username = htmlentities($_POST['username']);
    $password = password_hash(htmlentities($_POST['password']), PASSWORD_BCRYPT);
    $firstName = htmlentities($_POST['firstName']);
    $lastName = htmlentities($_POST['lastName']);
    $teamID = htmlentities($_POST['teamID']);
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

    $userData = new UserData();
    $userData->updateUser();

    header("Location: adminPanel.php");
}

$teamData  = new TeamData();
$view->teams = $teamData->fetchAllTeams();

require_once("views/editUser.phtml");