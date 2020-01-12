<?php
session_start();

require_once ("models/UserData.php");
require_once ("models/TeamData.php");
require_once("models/ScheduleData.php");

$view = new stdClass();
$view->title = "Schedule System - Fanatics";
$view->pageName = "index";

$userData = new UserData();

//Creates a Team data object
$teamData = new TeamData();

// Creates a Schedule data object
$rotaData = new ScheduleData();

$view->users = $userData->getAllUsers();

//Fetches all teams to view
$view->teams = $teamData->fetchAllTeams();

require_once("views/index.phtml");