<?php

require_once ("models/UserData.php");
require_once ("models/TeamData.php");

$id = $_GET['userID'];

$username = htmlentities($_POST['username']); $password = password_hash(htmlentities($_POST['password']), PASSWORD_BCRYPT);
$firstName = htmlentities($_POST['firstName']);
$lastName = htmlentities($_POST['lastName']);
$teamID = htmlentities($_POST['teamID']);
$isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

$userData = new UserData();
$userData->updateUser($id);

header("Location: adminPanel.php");

