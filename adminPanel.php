<?php
session_start();

require_once ("models/UserData.php");
require_once ("models/TeamData.php");
require_once("models/ScheduleData.php");
require_once("models/LogsData.php");

$view = new stdClass();
$view->title = "Admin Panel";
$view->pageName = "admin";

$userData = new UserData();

//Creates a Team data object
$teamData = new TeamData();

// Creates a Schedule data object
$rotaData = new ScheduleData();


$logs = new LogsData();

// if set, filter Users, otherwise grab all Users
if (isset($_POST['nameSubmit'])) {
    $name = htmlentities($_POST['name']);
    $view->users = $userData->getUsers($name);
} else {
    $view->users = $userData->getAllUsers();
}

// If set, filter Teams, otherwise grab all Teams
if (isset($_POST['teamSubmit'])) {
    $name = htmlentities($_POST['name']);
    $view->teams = $teamData->fetchTeams($name);
} else {
    //Fetches all teams to view
    $view->teams = $teamData->fetchAllTeams();
}

// If set, filter Logs, otherwise grab all Logs
if (isset($_POST['logsSubmit'])) {
    $from = htmlentities($_POST['from']);
    $to = htmlentities($_POST['to']);
    $view->logs = $logs->getLogs($from, $to);
} else {
    //Fetches all modifications made to the log view
    $view->logs = $logs->viewLog();
}

require_once ("views/adminPanel.phtml");