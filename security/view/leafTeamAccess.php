<?php	session_start();
if (strlen($_SESSION['staffId'])==0) {
	// check if the any session equal to zero redirect to index.php
	$page="../index.php?message=Masa tamat";
	print"<script>parent.location.replace('".$page."')</script>";
}
include('../../Connections/main.php');	?>
<html>
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/ext-all.css">
<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/icons.css">
<?php // only execute when exist
if($_SESSION['theme']) { ?>
<link rel="stylesheet" href="<?php echo $_SESSION['theme']; ?>">
<?php } ?>
</head>
<body>
</body>
<?php require_once("../../shared/setting.php"); ?>
<script  type="text/javascript"
	src="../../javascript/adapter/ext/ext-base.js"></script>
<script  type="text/javascript"
	src="../../javascript/ext-all.js"></script>
		<script type="text/javascript"
	src="../../javascript/examples/ux/checkColumn.js"></script>
<script  type="text/javascript"
	src="../javascript/leafTeamAccess.js?<?php echo time(); ?>"></script>

</html>