<?php
session_start();

require_once ("models/UserData.php");

$view = new stdClass();
$view->title = "Rota System - Fanatics";

$userData = new UserData();

$view->users = $userData->getAllUsers();
require_once("views/index.phtml");