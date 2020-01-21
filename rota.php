<?php
session_start();
require_once("models/ScheduleData.php");
require_once ("models/UserData.php");



$rotaData = new ScheduleData();
$userData = new UserData();

$view = new stdClass();
$view->title = "Rota";
$view->pageName = "admin";
$from = date("Y-m-d");
$to = date("Y-m-d", strtotime($from. ' + 56 days'));
$view->rotas = $rotaData->getRotas($from, $to);
$view->users = $userData->getAllNonAdmins();

if (isset($_POST['submit'])) {
    $from = $_POST['dateFrom'];
    $to = $_POST['dateTo'];

    $view->rotas = $rotaData->getRotas($from, $to);
}
require_once ("views/rota.phtml");
