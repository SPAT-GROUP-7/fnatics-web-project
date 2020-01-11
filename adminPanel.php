<?php
session_start();
$view = new stdClass();
$view->pageTitle = "Admin Panel";

require_once ("views/adminPanel.phtml");