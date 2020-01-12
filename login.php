<?php

session_start();

require_once ("models/Login.php");

if (isset($_POST['username'])) {
    // Login
    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);

    $Login = new Login();
    $modalOutput = '';

    $user = $Login->login($username, $password);

    if ($user != null) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $user->getUsername();
        if ($user->getIsAdmin() == 'Yes') {
            $_SESSION['isAdmin'] = true;
        }
    } else {
        // Failure redirect
        $modalOutput = '<div class="alert alert-danger" id="error-message" role="alert">
                            <strong>Error:</strong> Invalid Username or Password!
                        </div>';
    }
//    if ($Login->login($username, $password)) {
//        // Authenticated
//        $_SESSION['loggedIn'] = true;
//        $_SESSION['username'] = $username;
//        // TODO: Make isAdmin session if the user is an admin.
//    } else {
//
//    }

    echo $modalOutput;
}