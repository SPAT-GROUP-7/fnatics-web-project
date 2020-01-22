<?php
require_once ("models/Setup.php");

// the user runs this the first time they use the app, perform a first time initialization for them
$setup = new Setup();

$setup->initialiseTables();