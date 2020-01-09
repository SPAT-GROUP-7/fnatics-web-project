<?php
require_once ("models/UserData.php");

$teamID = 0;
$username = "testUser@fanatics.co.uk";
$password = "testpass";
$firstName = "tester";
$lastName = "Mc Testface";
$isAdmin = false;

$userData = new UserData();
$userData->createUser($teamID, $username, $password, $firstName, $lastName, $isAdmin);