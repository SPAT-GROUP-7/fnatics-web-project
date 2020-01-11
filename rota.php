<?php
session_start();
require_once ("models/RotaData.php");

$rotaData = new RotaData();
$view = new stdClass();
$view->title = "Rota View";
$view->rotas = $rotaData->getAllRotas();

require_once ("views/rota.phtml");
