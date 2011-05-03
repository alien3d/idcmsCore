<?php	session_start();
$staffId='staffId';
$theme='theme';
if(isset($_SESSION[$staffId])) {
	if (strlen($_SESSION[$staffId])==0) {
		// check if the any session equal to zero redirect to index.php
		echo "<script language=javascript>window.location.href='../../index.php';</script>";
	}
}
include('../../Connections/main.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Naaa</title>

<link rel="stylesheet" type="text/css"
	href="../../javascript/resources/css/ext-all.css"></link>
<?php if(isset($_SESSION[$theme])) { ?>
<link rel="stylesheet"
	href="<?php if(isset($_SESSION['theme'])) {
echo $_SESSION[$theme];
} ?>"></link>
<?php } ?>
</head>
<body></body>
<script language="javascript" type="text/javascript" src="../../javascript/ext-all.js"></script>
<script type="text/javascript" src="../../javascript/examples/ux/iframe.js"></script>
<script type="text/javascript" src="../../javascript/examples/ux/Ext.ux.TabCloseMenu/Ext.ux.TabCloseMenu.js"></script>
<script language="javascript" type="text/javascript">
	// used Dreamweaver for easy javascript viewing.

	Ext.onReady(function(){
		// remember new code style
	
		
    	Ext.BLANK_IMAGE_URL ='../../javascript/resources/images/s.gif';
    	<?php
				if($q->vendor=='normal' || $q->vendor=='lite') {
					$sql='SET NAMES "utf8"';
					$q->fast($sql);
				}
				if($q->vendor=='normal' || $q->vendor=='lite') {
					$sql="SELECT * FROM `staff` WHERE `staffId`='".$_SESSION[$staffId]."' LIMIT 1";
				} else if ($q->vendor=='microsoft') {
						$sql="SELECT TOP 1 * FROM [staff] WHERE [staffId]='".$_SESSION[$staffId]."'";
				} else if ($q->vendor=='oracle') {
						$sql="SELECT * FROM \"staff\"						WHERE \"staffId\"='".$_SESSION[$staffId]."' AND  rownum <=1 ";
				}



			 	$result=$q->fast($sql);

				$row  =$q->fetchArray($result);
			  $staff_name	= $row['staffName']; ?>
		var username	= ' : <?php echo strtoupper($staff_name); ?>';
		var theme_selecter = new Ext.data.SimpleStore({
			fields	: ['display', 'value'],
			data	: [	['Default (Blue)', ''],
						['Black', '../../js/resources/css/xtheme-black.css'],

						['Blue', '../../js/resources/css/xtheme-blue.css'],
						['Access', '../js/resources/css/xtheme-access.css'],
						['Dark Gray', '../../js/resources/css/xtheme-darkgray.css'],
						['Gray', '../../js/resources/css/xtheme-gray.css'],
						['Olive', '../../js/resources/css/xtheme-olive.css'],
						['Pink', '../../js/resources/css/xtheme-pink.css'],
						['Galdaka', '../../js/resources/css/xtheme-galdaka.css'],
						['Chocolate', '../../js/resources/css/xtheme-chocolate.css'],
						['Silver Cherry', '../../js/resources/css/xtheme-silverCherry.css'],
						['Slickness', '../../js/resources/css/xtheme-slickness.css'],
						['Midnight', '../../js/resources/css/xtheme-midnight.css'],
						['Indigo', '../../js/resources/css/xtheme-indigo.css'],
						['Pepermint','../../js/resources/css/xtheme-peppermint.css'],
						['Ubuntu','../../js/resources/css/xtheme-human.css']]
		});
		<?php 	$str=null;
					if($q->vendor=='normal' || $q->vendor=='lite') {
						$sql="SELECT * FROM `language`";
					} else if ($q->vendor=='microsoft') {
						$sql="SELECT * FROM [language]";
					} else if ($q->vendor=='oracle') {
						$sql="SELECT * FROM \"language\" ";
					}

					$result=$q->fast($sql);
					$data = $q->activeRecord($result);

					foreach($data as $row) {
							
								$str.="['".$row['languageDesc']."','".$row['languageId']."'],";
							
					}
			$str=substr($str,0,-1);
		?>
		var language_selecter = new Ext.data.SimpleStore({
			fields : ['language','languageId'],
			data: [
						<?php echo  $str; ?>
					]
		});
		var tabPanel 		= new Ext.TabPanel({
        	region			: 'center',
        	id				: 'centerTabs',
        	deferredRender	: true,
        	activeTab		: 0,
        	defaults		: {	closable: true	},
			autoScroll: true,
			enableTabScroll:true,
			plugins: new Ext.ux.TabCloseMenu(),

			items			: [{
				id				: 'tab1',
				title			: 'Introduction',
				xtype			: 'iframepanel',
				defaultSrc		: './welcome.php'
			    }]
    	 });
    	var treePanel;

    	function AddCenterTabIF(tabTitle,tabUrl) {
     	//	tabUrl='http://www.yahoo.com';
			var tab = tabPanel.add({
            	xtype      : 'iframepanel',
            	title      : tabTitle,
            	defaultSrc : tabUrl,
            	loadMask   : false,
            	closable   : true,
            	autoScroll : true

		   });
        	tabPanel.rendered && tabPanel.doLayout();
        	tabPanel.setActiveTab(tab);
        	return tab;
    	}
		new Ext.Viewport({
			id			: 'screenPage',
			layout		: 'border',
			items		: [
			{ // raw
              
				xtype:'panel',
                height:30,
            id:'north',
			name:'north',
			region		: 'north',

			tbar		:	[{
							 	xtype	:	'label',
								text	:	'Welcome '+username,
								iconCls	:	'user'
							 },'->',
							{
									xtype	:	'button',
									text	:	'Log Out',
									iconCls	:	'house',
									handler	:	function() {
											window.location.replace("../../index.php");
									}
							},'->',
							{
									xtype			:	'combo',
									fieldLabel		:	'Change Language',
									displayField	:	'language',
									mode			: 	'local',
									triggerAction	: 	'all',
									selectOnFocus	:	true,
									resizable		:	false,
									listWidth		: 	100,
									width			: 	100,
									valueField		: 	'languageId',
									emptyText		:	'Language',
									store			:	language_selecter,
									listeners		: 	{
										select: function () {
											window.location.replace("language.php?languageId="+this.getValue());
										}
									}
							},'->',
							{
							 	xtype	:	'label',
								html	:	'  &nbsp;'
							},'->',{
									xtype			:	'combo',
									fieldLabel		:	'Change Theme',
									displayField	:	'display',
									mode			: 	'local',
									triggerAction	: 	'all',
									selectOnFocus	:	true,
									resizable		:	false,
									listWidth		: 	100,
									width			: 	100,
									valueField		: 	'value',
									emptyText		:	'Color',
									store			:	theme_selecter,
									listeners		: 	{
										select: function () {
											window.location.replace("theme.php?theme="+this.getValue());
										}
									}

			}]
			
		} , {
			region		: 'west',
			id			: 'west-panel',
			title		: 'Menu',
			width		: 200,
			minSize		: 200,
			maxSize		: 400,
			collapsible	: true,
			layout		: 'accordion',
			iconCls		:	'house',
			animCollapse: false,
			    layoutConfig: {
        // layout-specific configs go here
        titleCollapse: true,
        animate: false,
        activeOnTop: true
    },
			items		: [
				<?php // module configuration
				$counter_accordion = 0;
				if($q->vendor=='normal' || $q->vendor=='lite') {
					$sql_accordion		=	"
					SELECT 	*
					FROM 	`accordionAccess`
					JOIN 	`accordion`
					USING 	(`accordionId`)
					JOIN	`accordionTranslate`
					USING	(`accordionId`)
					JOIN	`icon`
					USING   (`iconId`)
					WHERE 	`accordionAccess`.`groupId`=(
																SELECT `groupId`
																FROM 	`staff`
																WHERE 	`staffId`='".$_SESSION[$staffId]."'
																LIMIT 1
															  )
					AND 	`accordionAccess`.`accordionAccessValue`=	1
					AND		`accordionTranslate`.`languageId`='".$_SESSION['languageId']."'
					ORDER BY `accordion`.`accordionSequence` ";
				}  else if($q->vendor=='microsoft') {

					$sql_accordion		=	"
					SELECT 	*
					FROM 	[accordionAccess]
					JOIN 	[accordion]
					ON		[accordionAccess].[accordionId]=[accordion].[accordionId]
					JOIN		[accordionTranslate]
					ON		[accordionTranslate].[accordionId]=[accordion].[accordionId]
					JOIN		[icon]
					ON		[icon].[iconId]=[accordion].[iconId]
					WHERE 	[accordionAccess].[groupId]=(
																SELECT TOP 1 [groupId]
																FROM 	[staff]
																WHERE 	[staffId]='".$_SESSION[$staffId]."'

															  )
					AND 	[accordionAccess].[accordionAccessValue]=	1
					AND	[accordionTranslate].[languageId]='".$_SESSION['languageId']."'
					ORDER BY [accordion].[accordionSequence] ";
				} else if ($q->vendor=='oracle') {

					$sql_accordion		=	"
					SELECT 	*
					FROM 	\"accordionAccess\"
					JOIN 	\"accordion\"
					USING	(\"accordionId\")
					JOIN	\"accordionTranslate\"
					USING	(\"accordionId\")
					JOIN	\"icon\"
					USING	(\"iconId\")
					WHERE 	\"accordionAccess\".\"groupId\"=(
																SELECT  \"groupId\"
																FROM 	\"staff\"
																WHERE 	\"staffId\"='".$_SESSION[$staffId]."'
																AND		rownum <=1
															  )
					AND \"accordionAccess\".\"accordionAccessValue\"=	1
					AND	\"accordionTranslate\".\"languageId\"='".$_SESSION['languageId']."'
					ORDER BY \"accordion\".\"accordionSequence\"";
				}
				$result_accordion 	= $q->fast($sql_accordion);



				$total_accordion  = $q->numberRows($result_accordion,$sql_accordion);

				if($total_accordion >  0 ) {

					while($row_accordion  = $q->fetchArray($result_accordion)) {

							$accordionTranslate =$row_accordion['accordionTranslate'];
							$iconName=$row_accordion['iconName'];
							$accordionId =$row_accordion['accordionId'];

						$counter_accordion++; ?>
				<?php echo " { "; ?>
				title		: '<?php echo $accordionTranslate; ?>',
				border		: false,
				layout		: 'border',
				iconCls		: '<?php echo $iconName; ?>',
				items		: [	new Ext.tree.TreePanel({
					id			: 'tree-panel',
					autoScroll	: true,
					width		: 200,
					region		: 'center',
					minSize		: 200,
					maxSize		: 400,
					// tree-specific configs:
					rootVisible : false,
					lines		: false,
					singleExpand: true,
					useArrows	: true,
					animate		: false,
					root		: new Ext.tree.AsyncTreeNode({
						expanded	: true,
						children	: [

							<?php	// folder configuration
									$counter_folder=0;
							   		if($q->vendor=='normal' || $q->vendor=='lite') {
										$sql_folder	="
										SELECT		*
										FROM 		`folderAccess`
										JOIN		`folder`
										USING		(`folderId`)
										JOIN		`folderTranslate`
										USING		(`folderId`)
										JOIN		`icon`
										USING		(`iconId`)
										WHERE 		`accordionId`='".$accordionId."'
										AND 		`folderAccess`.`groupId`=(
																SELECT `groupId`
																FROM 	`staff`
																WHERE	`staff`.`staffId`='".$_SESSION[$staffId]."'
																LIMIT 1
															  )
										AND 	`folderAccess`.`folderAccessValue`=	1
										AND		`folderTranslate`.`languageId`='".$_SESSION['languageId']."'
										ORDER BY 	`folder`.`folderSequence`	";
									} else  if ($q->vendor=='microsoft') {
										$sql_folder	="
										SELECT		*
										FROM 		[folderAccess]
										JOIN			[folder]
										ON			[folderAccess].[folderId]=[folder].[folderId]
										JOIN			[folderTranslate]
										ON			[folderTranslate].[folderId]=[folder].[folderId]
										JOIN			[icon]
										ON			[icon].[iconId]=[folder].[iconId]
										WHERE 		[accordionId]='".$accordionId."'
										AND 			[folderAccess].[groupId]=(
																SELECT TOP 1 [groupId]
																FROM 	[staff]
																WHERE	[staff].[staffId]='".$_SESSION[$staffId]."'
															  )
										AND 	[folderAccess].[folderAccessValue]=	1
										AND		[folderTranslate].[languageId]='".$_SESSION['languageId']."'
										ORDER BY 	[folder].[folderSequence]	";

									} else if ($q->vendor=='oracle') {

									$sql_folder	="
										SELECT		*
										FROM 		\"folderAccess\"
										JOIN		\"folder\"
										USING		(\"folderId\")
										JOIN		\"folderTranslate\"
										USING		(\"folderId\")
										JOIN		\"icon\"
										USING		(\"iconId\")
										WHERE 		\"accordionId\"='".$accordionId."'
										AND 		\"folderAccess\".\"groupId\"=(
																SELECT \"groupId\"
																FROM 	\"staff\"
																WHERE	\"staff\".\"staffId\"='".$_SESSION[$staffId]."'
																AND		rownum <=1
															  )
										AND 		\"folderAccess\".\"folderAccessValue\"=	1
										AND			\"folderTranslate\".\"languageId\"='".$_SESSION['languageId']."'
										ORDER BY 	\"folder\".\"folderSequence\"	";
									}
							   		//echo $sql_fol/der;
									$result_folder = $q->fast($sql_folder);
									$total_folder  = $q->numberRows($result_folder,$sql_folder);
									if( $total_folder > 0 ) {
										while($row_folder = $q->fetchArray($result_folder)) {
												$folderTranslate =$row_folder['folderTranslate'];
												$iconName=$row_folder['iconName'];
												$folderId	=$row_folder['folderId'];
												$folderPath = $row_folder['folderPath'];

											$counter_folder++; ?>
											<?php echo " { "; ?>
							expanded	: true,
							text		: '<?php echo $folderTranslate ; ?>',
							iconCls 	: '<?php echo $iconName; ?>',
							children	: [
						<?php  //  program configuration
							    $counter_leaf=0;
							   	if($q->vendor=='normal' || $q->vendor=='lite') {
									$sql_leaf	="
									SELECT		*
									FROM		`leafAccess`
									JOIN		`leaf`
									USING		(`leafId`)
									JOIN		`leafTranslate`
									USING		(`leafId`)
									JOIN		`icon`
									USING		(`iconId`)
									WHERE 		`folderId`='".$folderId."'
									AND			`accordionId`='".$accordionId."'
									AND			`leafAccess`.`staffId`='".$_SESSION[$staffId]."'
									AND			`leafTranslate`.`languageId`='".$_SESSION['languageId']."'
								ORDER BY	`leaf`.`leafSequence`";
								} else if ($q->vendor=='microsoft') {
									$sql_leaf	="
									SELECT		*
									FROM		[leafAccess]
									JOIN			[leaf]
									ON			[leafAccess].[leafId]=[leaf].[leafId]
									JOIN			[leafTranslate]
									ON			[leafTranslate].[leafId]=[leaf].[leafId]
									JOIN			[icon]
									ON			[icon].[iconId]=[leaf].[iconId]
									WHERE 		[folderId]='".$folderId."'
									AND			[accordionId]='".$accordionId."'
									AND			[leafAccess].[staffId]='".$_SESSION[$staffId]."'
									AND			[leafTranslate].[languageId]='".$_SESSION['languageId']."'
									ORDER BY	[leaf].[leafSequence]";
								} else if ( $q->vendor=='oracle') {
									$sql_leaf	="
									SELECT		*
									FROM		\"leafAccess\"
									JOIN		\"leaf\"
									USING		(\"leafId\")
									JOIN		\"leafTranslate\"
									USING		(\"leafId\")
									JOIN		\"icon\"
									USING		(\"iconId\")
									WHERE 		\"folderId\"='".$folderId."'
									AND			\"accordionId\"='".$accordionId."'
									AND			\"leafAccess\".\"staffId\"='".$_SESSION[$staffId]."'
									AND			\"leafTranslate\".\"languageId\"='".$_SESSION['languageId']."'";
								}
								$result_leaf = $q->fast($sql_leaf);
								$total_leaf  = $q->numberRows($result_leaf,$sql_leaf);
								if($total_leaf > 0 ) {
									while($row_leaf = $q->fetchArray($result_leaf)) {

												$leafTranslate =	$row_leaf['leafTranslate'];
												$iconName	=	$row_leaf['iconName'];
												$leafFilename	=	$row_leaf['leafFilename'];

										$counter_leaf++;
										 echo " { "; ?>

									text		: '<?php echo $leafTranslate ; ?>\n',
									leaf		: true,
									iconCls 	: '<?php echo $iconName; ?>',
									listeners	: {
										click		:
										function	()	{
										Ext.getCmp('west-panel').collapse() ;
											// just alert to see the path

											AddCenterTabIF('<?php echo $leafTranslate; ?>','../../<?php echo $folderPath; ?>/view/<?php echo $leafFilename; ?>') ;

										}


									}
								} <?php if($counter_leaf != $total_leaf) { echo ","; } else { echo "]"; } // this is for javascript ',' ?>
									<?php } }  else { echo "{ text:'No Leaf Identify',leaf:true }]"; } //end looping ?>
							}<?php if($counter_folder != $total_folder) { echo ","; } else { echo "]"; } // this is for javascript ',' ?>
								<?php } }  else { echo "{ text:'No Folder Identify',expanded:true }]";  } //end looping ?>

						 })
				      })]
				} <?php if($counter_accordion != $total_accordion) { echo ","; } else { echo "]"; } // this is for javascript ',' ?>



				<?php }   }  // end menu configuration ?>
			}, {
				region		: 	'center',
				layout		:	'border',
				items		: 	[tabPanel]
		      }]
    });
});
</script>
</html>
