<?php
session_start();

// if the user is an administrator, allow them access and retrieve all information needed to display the rota calendar
if (isset($_SESSION['isAdmin']) && ($_SESSION['isAdmin'] == true)) {

    require_once ("models/TeamData.php");
    require_once ("models/ScheduleData.php");
    require_once ("models/UnavailableData.php");

    $view = new stdClass();
    $view->title = "Fanatics Rota Display";

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

} else {
    echo "You need to be an admin to view this page.";
}