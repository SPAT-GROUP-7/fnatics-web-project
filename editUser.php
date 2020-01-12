<?php

require_once ("models/UserData.php");
require_once ("models/TeamData.php");

$id = $_GET['userID'];
echo $id;
var_dump($id);

$username = htmlentities($_POST['username']);
$password = password_hash(htmlentities($_POST['password']), PASSWORD_BCRYPT);
$firstName = htmlentities($_POST['firstName']);
$lastName = htmlentities($_POST['lastName']);
$isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

$userData = new UserData();
$userData->updateUser($id, $username, $firstName, $lastName, $isAdmin);

header("Location: adminPanel.php");

