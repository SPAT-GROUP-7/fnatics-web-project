<?php
require_once ("models/RotaData.php");

session_start();
$view = new stdClass();
$rotaData = new RotaData();
$view->title = "Generate new Rota";
$view->rota = $rotaData->generateRota();
require_once ("views/generateRota.phtml");