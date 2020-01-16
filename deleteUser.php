<?php
require_once ("models/UserData.php");
require_once ("models/LogsData.php");
require_once ("models/User.php");
session_start();

$id = $_GET['userID'];
$userData = new UserData();
$logData = new LogsData();

$username = $userData->getUsernameByID($id);

$logData->addLog($_SESSION['userID'], 'deleted', $username, null);

$delUser = $userData->deleteUser($id);

header("Location: index.php");