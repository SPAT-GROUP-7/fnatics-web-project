<?php
session_start();

require_once ("models/UserData.php");
require_once ("models/TeamData.php");

$view = new stdClass();
$view->title = "Rota System - Fanatics";

$userData = new UserData();

//Creates a Team data object
$teamData = new TeamData();

$view->users = $userData->getAllUsers();

//Fetches all teams to view
$view->teams = $teamData->fetchAllTeams();

require_once("views/index.phtml");