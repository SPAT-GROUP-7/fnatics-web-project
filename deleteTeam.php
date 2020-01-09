<?php
require_once ("models/TeamData.php");

if (isset($_POST['submit'])) {

    $teamData = new TeamData();

    $_teamName = htmlentities($_POST['teamName']);

    $teamData->deleteTeam($_teamName);

    header("Location: index.php");
}
