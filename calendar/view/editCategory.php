<?php	session_start();
$staffId='staffId';
$theme ='theme';
if (strlen($_SESSION[$staffId])==0) {
	// check if the any session equal to zero redirect to index.php
	$page="../index.php?message=Masa tamat";
	print"<script>parent.location.replace('".$page."')</script>";
}
include('../../Connections/main.php');	?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/ext-all.css">
<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/icons.css">
    <link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/empty.css">
<?php // only execute when exist
if(isset($_SESSION[$theme])) { ?>
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
<script  type="text/javascript"
	src="../javascript/original/editCategory.js?<?php echo time(); ?>"></script>
</html>
