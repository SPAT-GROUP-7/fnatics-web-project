<?php
require_once ("models/TeamData.php");

$view = new stdClass();
$view->title = "Some Test Thing";

$teamData = new TeamData();

$view->teams = $teamData->fetchAllTeams();

$view->members = [];
foreach ($view->teams as $team) {
    $members = $teamData->getTeamMembers($team->getTeamID());
    $view->members[] = $members;
}

require_once("views/rotaDisplay.phtml");