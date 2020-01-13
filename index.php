<?php
session_start();


$view = new stdClass();
$view->title = "Schedule System - Fanatics";
$view->pageName = "index";



require_once("views/index.phtml");