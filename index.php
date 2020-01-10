<?php
session_start();

require_once ("models/UserData.php");
require_once ("models/TeamData.php");
require_once ("models/RotaData.php");

$view = new stdClass();
$view->title = "Rota System - Fanatics";

$userData = new UserData();

//Creates a Team data object
$teamData = new TeamData();

// Creates a Rota data object
$rotaData = new RotaData();

$view->users = $userData->getAllUsers();

//Fetches all teams to view
$view->teams = $teamData->fetchAllTeams();

require_once("views/index.phtml");