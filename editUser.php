<?php
require_once ("models/UserData.php");

$id = $_GET['userID'];

$userData = new UserData();

$userData->updateUser($id);

header("Location: index.php");