<?php
session_start();
$view = new stdClass();
$view->title = "Rota View";

require_once ("views/rota.phtml");
