<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Login Dialog Extension Demo</title>

<link rel="stylesheet" type="text/css"
	href="javascript/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css"
	href="javascript/examples/ux/logindialog/css/overrides.css" />

<link rel="stylesheet" type="text/css"
	href="javascript/examples/ux/logindialog/css/flags.css" />
<link rel="stylesheet" type="text/css"
	href="javascript/examples/ux/logindialog/css/virtualkeyboard.css" />

</head>
<body <?php

if(isset($_GET['message'])) {  ?> onload="message()"
<?php }   ?>>
</body>
<script type="text/javascript"   src="javascript/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="javascript/ext-all.js"></script>
<script type="text/javascript"
	src="javascript/examples/ux/logindialog/js/virtualkeyboard.js"></script>
<script type="text/javascript"
	src="javascript/examples/ux/logindialog/js/plugins/virtualkeyboard.js"></script>
<script type="text/javascript"
	src="javascript/examples/ux/logindialog/js/Ext.ux.Crypto.SHA1.js"></script>
<script type="text/javascript"
	src="javascript/examples/ux/logindialog/js/Ext.ux.form.IconCombo.js"></script>
<script type="text/javascript"
	src="javascript/examples/ux/logindialog/js/Ext.ux.form.LoginDialog.js"></script>

<script type="text/javascript"
	src="javascript/examples/ux/logindialog/js/LoginDialogExample.js"></script>
<?php

if(isset($_GET['message'])) {  ?> 
<script language="javascript">
	function message() { 	alert('<?php echo $_GET['message']; ?>. Please Login to the system');	}
        </script>
		<?php }   ?>
</html>
