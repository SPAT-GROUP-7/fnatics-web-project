<?php
require_once ("models/TeamData.php");
require_once ("models/ScheduleData.php");

$view = new stdClass();
$view->title = "Some Test Thing";

$teamData = new TeamData();
$scheduleData = new ScheduleData();
$view->teams = $teamData->fetchAllTeams();

$view->members = [];
foreach ($view->teams as $team) {
    $members = $teamData->getTeamMembers($team->getTeamID());
    $view->members[] = $members;
}

$view->schedules = $scheduleData->getAllRotas();

require_once("views/rotaDisplay.phtml");