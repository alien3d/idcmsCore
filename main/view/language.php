<?php	session_start();
$_SESSION['languageId']=$_GET['languageId'];
include('../../Connections/main.php');
if($q->vendor=='normal' || $q->vendor=='lite') {
	$sql="
	UPDATE	`staff`
	SET 	`languageId`='".$_SESSION['languageId']."'";
} else if ($q->vendor=='microsoft') {
	$sql="
	UPDATE	[staff]
	SET 	[languageId]='".$_SESSION['languageId']."'";
} else if ($q->vendor=='oracle'){
	$sql="
	UPDATE	\"staff\"
	SET 	\"languageId\"='".$_SESSION['languageId']."'";
}
$q->fast($sql);
header('location:main.php');
?>