<?php
require_once ("models/TeamData.php");

if (isset($_POST['submit'])) {

    $teamData = new TeamData();

    $_teamID = htmlentities($_POST['teamId']);
    $_teamName = htmlentities($_POST['teamName']);
    $_isBusy = htmlentities($_POST['isBusy']);
    $_dateCreated = htmlentities($_POST['dateCreated']);
    $_dateLastUpdated = htmlentities($_POST['dateUpdated']);

    $teamData->createTeam($_teamID, $_teamName, $_isBusy, $_dateCreated, $_dateLastUpdated);

    header("Location: newTeam.php");
}
