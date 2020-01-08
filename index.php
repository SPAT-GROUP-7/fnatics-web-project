<?php
session_start();

$view = new stdClass();
$view->title = "Rota System - Fanatics";

require_once("views/index.phtml");