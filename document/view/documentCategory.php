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
	href="../../javascript/examples/ux/gridfilters/css/GridFilters.css" />
<link rel="stylesheet" type="text/css"
	href="../../javascript/examples/ux/gridfilters/css/RangeMenu.css" />
<link rel="stylesheet" type="text/css"
	href="../../javascript/examples/ux/statusbar/css/statusbar.css">
    <link rel="stylesheet" type="text/css"
	href="../../javascript/examples/ux/css/RowEditor.css">
<?php // only execute when exist
if(isset($_SESSION[$theme])) { ?>
<link rel="stylesheet" href="<?php echo $_SESSION['theme']; ?>">

<?php } ?>
</head>
<style>
x-grid3-row-alt {
	background-color: red !important;
}
</style>
<body>
</body>
<?php require_once("../../shared/setting.php"); ?>
<script  type="text/javascript"
	src="../../javascript/adapter/ext/ext-base.js"></script>
<script  type="text/javascript"
	src="../../javascript/ext-all.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/gridfilters/menu/RangeMenu.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/gridfilters/menu/ListMenu.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/gridfilters/GridFilters.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/gridfilters/filter/Filter.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/gridfilters/filter/StringFilter.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/gridfilters/filter/DateFilter.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/gridfilters/filter/ListFilter.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/gridfilters/filter/NumericFilter.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/gridfilters/filter/BooleanFilter.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/SearchField.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/statusbar/StatusBar.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/statusbar/ValidationStatus.js"></script>
	<script type="text/javascript"
	src="../../javascript/examples/ux/checkColumn.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/RowEditor.js"></script>
	<script type="text/javascript"
	src="../../javascript/examples/ux/BufferView.js"></script>	
<script type="text/javascript"
	src="../../javascript/examples/ux/RowExpander.js"></script>
<script  type="text/javascript"
	src="../javascript/original/documentCategory.js?<?php echo time(); ?>"></script>
</html>
