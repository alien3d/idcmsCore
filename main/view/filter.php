<?php
session_start();
$_SESSION['applicationId'] = $_GET['applicationId'];
$applicationFilename = $_GET['applicationFilename'];
header('location:'.$applicationFilename);
?>