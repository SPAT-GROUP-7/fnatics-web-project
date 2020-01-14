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

$view->users = $userData->getAllUsers();

//Fetches all teams to view
$view->teams = $teamData->fetchAllTeams();

//Fetches all modifications made to the log view
$view->logs = $logs->viewLog();

require_once ("views/adminPanel.phtml");