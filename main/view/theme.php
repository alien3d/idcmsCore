<?php	session_start();
$_SESSION['theme']=$_GET['theme'];
header('location:main.php');
?>