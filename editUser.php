<?php

require_once ("models/UserData.php");

if (isset($_POST['submit']))
{
    $username = htmlentities($_POST['username']);
    $password = password_hash(htmlentities($_POST['password']), PASSWORD_BCRYPT);
    $firstName = htmlentities($_POST['firstName']);
    $lastName = htmlentities($_POST['lastName']);
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

    $userData = new UserData();
    $userData->updateUser();

    header("Location: index.php");
}