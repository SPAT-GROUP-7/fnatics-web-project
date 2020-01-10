<?php
require_once ("models/UserData.php");

$id = $_GET['userID'];

$userData = new UserData();

$userData->deleteUser($id);

header("Location: index.php");