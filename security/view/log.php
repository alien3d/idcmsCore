<?php
session_start();
if (strlen($_SESSION['staffId'])==0) {
	// check if the any session equal to zero redirect to index.php
	$f->redirect("index.php");
}
include('../../Connections/kospek.php');	?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/ext-all.css">
<?php // only execute when exist
if($_SESSION['theme']) { ?>
<link rel="stylesheet" href="<?php echo $_SESSION['theme']; ?>">
<?php } ?>
</head>
<body>
</body>
<Script language="javascript" type="text/javascript"
	src="../../javascript/ext-all.js"></script>
<script language="javascript" type="text/javascript"
	src="../../javascript/examples/ux/SearchField.js"></script>
<script language="javascript" type="text/javascript"
	src="../../javascript/examples/ux/gridfilters/GridFilters.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/statusbar/StatusBar.js"></script>
<?php require_once("../../shared/setting.php"); ?>

<script language="javascript" type="text/javascript" src="../javascript/log.js"></script>
</html>
