<?php
require_once ("models/TeamData.php");

if (isset($_POST['submit'])) {

    $teamData = new TeamData();

    $_teamName = htmlentities($_POST['teamName']);
    $_isBusy = htmlentities($_POST['isBusy']);

    $teamData->createTeam($_teamName, $_isBusy);

    header("Location: index.php");
}
