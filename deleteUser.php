<?php
require_once ("models/UserData.php");
require_once ("models/LogsData.php");
require_once ("models/User.php");
session_start();

// Grab the User by the ID provided and delete them from the System and update the Logs

$id = $_GET['userID'];
$userData = new UserData();
$logData = new LogsData();

$username = $userData->getUsernameByID($id);

$logData->addLog($_SESSION['userID'], 'deleted', $username, null, null);

$delUser = $userData->deleteUser($id);

header("Location: adminPanel.php");