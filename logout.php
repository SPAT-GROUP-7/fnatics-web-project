<?php
session_start();

// A user has logged out so clear all session information associated with them
session_destroy();
header("Location: index.php");