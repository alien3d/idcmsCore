<?php
	require_once("util.php");
	$extRoot = getExtRoot();
?>
		<link rel="stylesheet" type="text/css" href="<?php echo($extRoot); ?>/resources/css/ext-all.css"/>
		<script type="text/javascript" src="<?php echo($extRoot); ?>/adapter/ext/ext-base-debug.js"></script>
		<script type="text/javascript" src="<?php echo($extRoot); ?>/ext-all-debug.js"></script>
		<script type="text/javascript">
			Ext.BLANK_IMAGE_URL = '<?php echo($extRoot); ?>/resources/images/default/s.gif';
		</script>
