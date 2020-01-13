<?php
session_start();

require_once("models/ScheduleData.php");
$data = $_POST['rotas'];
$uns = array(json_decode($data));

//$rotaData->createRota($from, $to, $devA, $devB);

//header("Location: rota.php");