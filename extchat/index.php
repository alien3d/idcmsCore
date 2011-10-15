<?php session_start(); include("config.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Aplikasi Chatting</title>
<link rel="stylesheet" type="text/css" href="<?php echo $ext_folder; ?>/resources/css/ext-all.css">
<script type="text/javascript" src="<?php echo $ext_folder; ?>/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="<?php echo $ext_folder; ?>/ext-all.js"></script>
<script type="text/javascript">Ext.BLANK_IMAGE_URL = "<?php echo $ext_folder; ?>/resources/images/default/s.gif"</script>
<script type="text/javascript"><?php
	include_once("remote.php"); 
	$x = cekuser($_SESSION['username']); 
	$x = json_decode($x); 
	$user = $x->true?$x->username:null;   
	echo "var username ='".$user."';" ?> 
</script>
<script type="text/javascript" src="js/TabCloseMenu.js"> </script>
<script type="text/javascript" src="js/chat.js"> </script>
<script type="text/javascript" src="js/ajax.js"> </script>
<script type="text/javascript" src="js/privchat.js"> </script>
<script type="text/javascript" src="js/index.js"> </script>
<style type="text/css">
body {
    font-family:'lucida grande',tahoma,arial,sans-serif;
    font-size:11px;
	 /*outline: none; */
}
a:link, a:visited, a:hover {
    text-decoration: none;
}
span.blink {
	color: #B22222;
	text-decoration: blink;
}
span.title {
	color: #00008B;
	text-decoration: none;
}
.x-form-item  {
	font-size: 11px; 
}
.x-form-field{
	font-size: 11px; 
}
.box-chat {
	font-family:'arial';
	font-size:9pt;
	padding:2px;
	border-bottom:1px solid #EEEEEE;
}
.global-chat {
 background-image:url(images/comments.png) !important
}
.private-chat {
 background-image:url(images/comment.png) !important
}
</style>
</head>
<body>
</body>
</html>