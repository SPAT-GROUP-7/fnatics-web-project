<?php
session_start();
$view = new stdClass();
$view->title = "Admin Panel";

require_once ("views/adminPanel.phtml");