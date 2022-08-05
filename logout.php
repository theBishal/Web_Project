<?php
require_once (__DIR__."/controller/Controller.php");
$ctrlObject = new Controller();

session_start();
$ctrlObject->logout();
header('Location: ./');

?>
