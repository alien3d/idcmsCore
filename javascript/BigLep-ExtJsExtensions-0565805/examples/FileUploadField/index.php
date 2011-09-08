<?php
	require_once("../common/util.php");
	
	$title = "Ext.ux.form.FileUploadField example";
	require_once("../common/htmlToTitle.php");
	require_once("../common/extJsIncludes.php");
	require_once("../common/iconIncludes.php");
	
	$useExtFileUploadField = $_GET['useExtFileUploadField'];
	
	if ($useExtFileUploadField) {
		$examplesDir = getExtRoot() . "/examples";
?>
		<script type="text/javascript" src="<?php echo($examplesDir); ?>/ux/FileUploadField.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo($examplesDir); ?>/form/css/file-upload.css"/>
<?php 
	} else {
		$fileUploadFieldDirPath = "../../src/FileUploadField";
?>
		<script type="text/javascript" src="<?php echo($fileUploadFieldDirPath); ?>/FileUploadField.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo($fileUploadFieldDirPath); ?>/css/fileuploadfield.css"/>
<?php 
	}
	
	$showBrowseButton = $_GET['showBrowseButton'];
	if ($showBrowseButton) {
?>
		<style type="text/css">
			/* Undo fileupload.css opacity settings */
			.x-form-file-wrap .x-form-file {
				filter:alpha(opacity: 100);
				opacity: 1.0;
			}
		</style>
<?php 
	}
?>
	<script type="text/javascript">
		Ext.onReady(function(){
			Ext.QuickTips.init();
			var buttonWithIconCfg = {
				buttonOnly : true,
				buttonCfg : {
					text: 'Add Screenshot',
					iconCls: 'image-add-icon',
					tooltip: 'Click here to upload a screenshot.'
				},
				name : 'screenshot'
			};
			var buttonWithoutIconCfg = {
				buttonOnly : true,
				buttonCfg : {
					text: 'Add Screenshot',
					tooltip: 'Click here to upload a screenshot.'
				},
				name : 'screenshot'
			};
			
			// Define the grid to display the store's data.
			var panel = new Ext.Panel({
				height:350,
				width:375,
				title:'Ext.ux.form.FileUploadField example',
				frame : true,
				tbar : [
					new Ext.ux.form.FileUploadField(buttonWithIconCfg),
					new Ext.ux.form.FileUploadField(buttonWithoutIconCfg)
				],
				items : [
					new Ext.ux.form.FileUploadField(buttonWithIconCfg),
					new Ext.ux.form.FileUploadField(buttonWithoutIconCfg)
				]
			});
			panel.render('panel');
		});
	</script>
<?php
	require_once("../common/endHeadToBody.php");
?>
	<div id="panel"></div>
	<ul>
		<li>Controlling whether to use Ext's provided Ext.ux.form.FileUploadField can be set by adding "useExtFileUploadField=[1|0]" to the query string.</li>
		<li>Controlling whether to show the File Browse button can be set by adding "showBrowseButton=[1|0]" to the query string.</li>
	</ul>
	<br/>
<?php
	require_once("../common/footer.php");
?>