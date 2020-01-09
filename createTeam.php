<?php
require_once ("models/TeamData.php");

if (isset($_POST['submit'])) {

    $teamData = new TeamData();

    $_teamName = htmlentities($_POST['teamName']);
    $_isBusy = isset($_POST['isBusy']) ? 1 : 0;


    $teamData->createTeam($_teamName, $_isBusy);
    header("Location: index.php");
}
