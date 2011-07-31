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
<head>

<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/icons.css">
<?php // only execute when exist
if($_SESSION['theme']) { ?>
<link rel="stylesheet" href="<?php echo $_SESSION['theme']; ?>">
<?php } ?>

<?php require_once("../../shared/setting.php"); ?>
<!-- App -->
<link rel="stylesheet" type="text/css"
	href="../../javascript/extensible-1.0.1/resources/css/extensible-all.css">
</head>
<body>
	
</body>
<script  type="text/javascript"
	src="../../javascript/adapter/ext/ext-base.js"></script>
<script  type="text/javascript"
	src="../../javascript/ext-all.js"></script>
<script language="javascript" type="text/javascript" src="../../javascript/extensible-1.0.1/extensible-all-debug.js"></script> 
<script language="javascript" type="text/javascript" src="../javascript/calendar.js"></script>   
</html>
