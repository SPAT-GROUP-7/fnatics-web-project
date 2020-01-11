<?php

session_start();

require_once ("models/Login.php");

if (isset($_POST['username'])) {
    // Login
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);

    $Login = new Login();
    $modalOutput = '';

    if ($Login->login($username, $password)) {
        // Authenticated
        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $username;
    } else {
        // Failure redirect
        $modalOutput = '<div class="alert alert-danger" id="error-message" role="alert">
                            <strong>Error:</strong> Invalid Username or Password!
                        </div>';
    }

    echo $modalOutput;
}