<?php	session_start();
if (strlen($_SESSION['staff_uniqueId'])==0) {
	// check if the any session equal to zero redirect to index.php
	$page="../index.php?message=Masa tamat";
	print"<script>parent.location.replace(\"".$page."\")</script>";
}
include('../Connections/main.php');	?>
<html>
<head>
<script  type="text/javascript"
	src="../../javascript/adapter/ext/ext-base.js"></script>
<script  type="text/javascript"
	src="../../javascript/ext-all.js"></script>
<link rel="stylesheet" type="text/css"
	href="../javascript/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/icons.css">
<?php // only execute when exist
if($_SESSION['theme']) { ?>
<link rel="stylesheet" href="<?php echo $_SESSION['theme']; ?>">
<?php } ?>
<link rel="stylesheet" type="text/css"
	href="../javascript/examples/calendar/resources/css/calendar.css" />
<script type="text/javascript"
	src="../javascript/examples/calendar/src/Ext.calendar.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/templates/DayHeaderTemplate.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/templates/DayBodyTemplate.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/templates/DayViewTemplate.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/templates/BoxLayoutTemplate.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/templates/MonthViewTemplate.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/dd/CalendarScrollManager.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/dd/StatusProxy.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/dd/CalendarDD.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/dd/DayViewDD.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/EventRecord.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/views/MonthDayDetailView.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/widgets/CalendarPicker.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/WeekEventRenderer.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/views/CalendarView.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/views/MonthView.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/views/DayHeaderView.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/views/DayBodyView.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/views/DayView.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/views/WeekView.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/widgets/DateRangeField.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/widgets/ReminderField.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/EventEditForm.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/EventEditWindow.js"></script>
<script type="text/javascript"
	src="../javascript/examples/calendar/src/CalendarPanel.js"></script>
<?php require_once("../shared/setting.php"); ?>
<!-- App -->
<link rel="stylesheet" type="text/css"
	href="../javascript/examples/calendar/resources/css/examples.css" />
<script type="text/javascript" src="app/calendar-list.js"></script>
<script type="text/javascript" src="app/event-list.js"></script>
<script type="text/javascript" src="app/test-app.js"></script>
</head>
<body>
	<div style="display: none;">
		<div id="app-header-content">
			<div id="app-logo">
				<div class="logo-top">&nbsp;</div>
				<div id="logo-body">&nbsp;</div>
				<div class="logo-bottom">&nbsp;</div>
			</div>
			<h1>IDCMS Core Calendar</h1>
			<span id="app-msg" class="x-hidden"></span>
		</div>
	</div>
	<script>
   var updateLogoDt = function(){
        document.getElementById('logo-body').innerHTML = new Date().getDate();
    }
    updateLogoDt();
    setInterval(updateLogoDt, 1000);

    //removes the highlight on updated events
    Ext.override(Ext.calendar.CalendarView, {
        doUpdateFx: Ext.emptyFn
    });
</script>
</body>
</html>
