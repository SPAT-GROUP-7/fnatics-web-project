<?php
require_once ("models/TeamData.php");
require_once ("models/ScheduleData.php");
require_once ("models/UnavailableData.php");
session_start();

$view = new stdClass();
$view->title = "Admin Rota View";

$teamData = new TeamData();
$scheduleData = new ScheduleData();
$unaData = new UnavailableData();
$view->teams = $teamData->fetchAllTeams();

$view->members = [];
foreach ($view->teams as $team) {
    $members = $teamData->getTeamMembers($team->getTeamID());
    $view->members[] = $members;
}

$view->schedules = $scheduleData->getAllRotas();
$view->unavailable = $unaData->getAllUnavailableUsers();

require_once("views/rotaDisplay.phtml");