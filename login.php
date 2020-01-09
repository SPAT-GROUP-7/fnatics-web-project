<?php

session_start();

require_once ("models/Login.php");

$view = new stdClass();

if (isset($_POST['submit'])) {
    // Login
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);

    $Login = new Login();

    if ($Login->login($username, $password)) {
        // Authenticated
        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $username;

        header("Location: index.php");
    } else {
        // Failure redirect
        header("Location: index.php");
    }
} else {
    echo "Unauthorised";
}