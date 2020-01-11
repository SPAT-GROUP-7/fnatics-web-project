<?php
session_start();
$view = new stdClass();
$view->pageTitle = "Rota View";

require_once ("views/rota.phtml");
