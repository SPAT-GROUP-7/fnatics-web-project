<?php
require_once ("models/TeamData.php");

if (isset($_POST['submit'])) {

    $id = $_GET['teamID'];

    $teamData->deleteTeam($id);

    header("Location: index.php");
}