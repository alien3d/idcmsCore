<?php	session_start();
if (strlen($_SESSION['staffId'])==0) {
	// check if the any session equal to zero redirect to index.php
	$page="../index.php?message=Masa tamat";
	print"<script>parent.location.replace(\"".$page."\")</script>";
}
include('../../Connections/kospek.php');	?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/ext-all.css"></link>
<?php // only execute when exist
if($_SESSION['theme']) { ?>
<link rel="stylesheet" href="<?php echo $_SESSION['theme']; ?>"></link>
<?php } ?>
</head>
<body>
</body>
<?php require_once("../../shared/setting.php"); ?>
<script language="javascript" type="text/javascript"
	src="../../javascript/ext-all.js"></script>
<script language="javascript" type="text/javascript"
	src="../../javascript/examples/ux/SearchField.js"></script>
<script language="javascript" type="text/javascript"
	src="../../javascript/examples/ux/gridfilters/GridFilters.js"></script>
<script language="javascript" type="text/javascript"
	src="../../javascript/examples/ux/statusbar/StatusBar.js"></script>
<script language="javascript" type="text/javascript"
	src="../../javascript/iconcombo.js"></script>
<script language="javascript" type="text/javascript"
	src="../javascript/group.js"></script>
</html>
