<?php
session_start();
require_once("models/ScheduleData.php");
require_once ("models/UserData.php");



$rotaData = new ScheduleData();
$userData = new UserData();

$view = new stdClass();
$view->title = "Rota";
$view->pageName = "admin";

$view->rotas = $rotaData->getAllRotas();
$view->users = $userData->getAllNonAdmins();

// if set, filter the rotas, otherwise just display all rotas
if (isset($_POST['submit'])) {
    $from = $_POST['dateFrom'];
    $to = $_POST['dateTo'];

    $view->rotas = $rotaData->getRotas($from, $to);
}
require_once ("views/rota.phtml");
