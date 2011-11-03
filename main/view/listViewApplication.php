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
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/ext-all.css">
<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/icons.css">
<link rel="stylesheet" type="text/css"
	href="../../javascript/examples/ux/gridfilters/css/GridFilters.css" />
<link rel="stylesheet" type="text/css"
	href="../../javascript/examples/ux/gridfilters/css/RangeMenu.css" />
<link rel="stylesheet" type="text/css"
	href="../../javascript/examples/ux/statusbar/css/statusbar.css">
<link rel="stylesheet" type="text/css"
	href="../../javascript/examples/ux/css/RowEditor.css">
<link rel="stylesheet" type="text/css"
	href="../../javascript/examples/view/animated-dataview.css">	
<?php // only execute when exist
if(isset($_SESSION['theme'])) { ?>
<link rel="stylesheet" href="<?php echo $_SESSION['theme']; ?>">

<?php }  ?>
</head>
<body>
</body>
<script type="text/javascript"
	src="../../javascript/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="../../javascript/ext-all.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/DataViewTransition.js"></script>
<?php require_once("../../shared/setting.php"); ?>
<script type="text/javascript" src="../javascript/original/listViewApplication.js?time="<?php echo time(); ?>></script>
</html>


