<?php	session_start();
$staffId='staffId';
$theme ='theme';
if (strlen($_SESSION[$staffId])==0) {
	// check if the any session equal to zero redirect to index.php
	$page="../index.php?message=Masa tamat";
	print"<script>parent.location.replace(\"".$page."\")</script>";
}
include('../../Connections/main.php');	?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/ext-all.css"></link>
<?php // only execute when exist
if($_SESSION[$theme]) { ?>
<link rel="stylesheet" href="<?php echo $_SESSION['theme']; ?>"></link>
<?php } ?>
</head>
<body>
</body>
<?php require_once("../../shared/setting.php"); ?>
<script language="javascript" type="text/javascript"
	src="../../javascript/ext-all.js"></script>
<script language="javascript" type="text/javascript"
	src="../javascript/edit_cat.js"></script>
</html>
