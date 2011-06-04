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
    <link rel="stylesheet" type="text/css"
	href="../../javascript/extensible/resources/css/extensible-all.css"></link>
<?php if(isset($_SESSION[$theme])) { ?>
<link rel="stylesheet"
	href="<?php if(isset($_SESSION['theme'])) {
echo $_SESSION[$theme];
} ?>"></link>
<?php } ?>
<style>
.header {
	background: #7F99BE url(../../javascript/examples/layout-browser/images/layout-browser-hd-bg.gif) repeat-x center;
	 font-size: 16px;
    color: #fff;
    font-weight:bold;
    padding: 5px 10px;
}
  .paste-icon {background-image:url(../../javascript/ribbon/images/paste_32.png) !important;}
            .copy-icon {background-image:url(../../javascript/ribbon/images/copy_16.png) !important;}
            .cut-icon {background-image:url(../../javascript/ribbon/images/cut_16.png) !important;}
            .add-icon {background-image:url(../../javascript/ribbon/images/add.png) !important;}
            .add2-icon {background-image:url(../../javascript/ribbon/images/add2.png) !important;}
            .book-icon {background-image:url(../../javascript/ribbon/images/book.png) !important;}
            .pencil-icon {background-image:url(../../javascript/ribbon/images/pencil.png) !important;}
            .branch1-icon {background-image:url(../../javascript/ribbon/images/branch1.png) !important;}
            .branch2-icon {background-image:url(../../javascript/ribbon/images/branch2.png) !important;}
            .t1-icon {background-image:url(../../javascript/ribbon/images/table1.png) !important;}
            .t2-icon {background-image:url(../../javascript/ribbon/images/table2.png) !important;}
            .t3-icon {background-image:url(../../javascript/ribbon/images/table3.png) !important;}
            .db1-icon {background-image:url(../../javascript/ribbon/images/t1.png) !important;}
            .db2-icon {background-image:url(../../javascript/ribbon/images/t2.png) !important;}
            .spy-icon {background-image:url(../../javascript/ribbon/images/spy.png) !important;}
            .jar-icon {background-image:url(../../javascript/ribbon/images/jar.png) !important;}
 </style>
</head>
<body>
</body>
<script language="javascript" type="text/javascript" src="../../javascript/adapter/ext/ext-base.js"></script>
<script language="javascript" type="text/javascript" src="../../javascript/ext-all.js"></script>
<script type="text/javascript" src="../../javascript/examples/ux/iframe.js"></script>
  <script type="text/javascript" src="../../javascript/examples/ux/treegrid/TreeGridSorter.js"></script>
        <script type="text/javascript" src="../../javascript/examples/ux/treegrid/TreeGridColumnResizer.js"></script>
        <script type="text/javascript" src="../../javascript/examples/ux/treegrid/TreeGridNodeUI.js"></script>
        <script type="text/javascript" src="../../javascript/examples/ux/treegrid/TreeGridLoader.js"></script>

        <script type="text/javascript" src="../../javascript/examples/ux/treegrid/TreeGridColumns.js"></script>
        <script type="text/javascript" src="../../javascript/examples/ux/treegrid/TreeGrid.js"></script>
<script type="text/javascript" src="../../javascript/examples/ux/Ext.ux.TabCloseMenu/Ext.ux.TabCloseMenu.js"></script>
<script type="text/javascript" src="../../javascript/examples/ux/TabScrollerMenu.js"></script>
<script type="text/javascript" src="../../javascript/ribbon/Ext.ux.Ribbon.js"></script>
<?php require_once("../../shared/setting.php"); ?>
<script language="javascript" type="text/javascript">

	// used Dreamweaver for easy javascript viewing.

	Ext.onReady(function(){
		// remember new code style
	var perPage=100;
		
    	Ext.BLANK_IMAGE_URL ='../../javascript/resources/images/s.gif';
    	<?php
				if($q->vendor=='normal' || $q->vendor=='mysql') {
					$sql='SET NAMES "utf8"';
					$q->fast($sql);
				}
				if($q->vendor=='normal' || $q->vendor=='mysql') {
					$sql="SELECT * FROM `staff` WHERE `staffId`='".$_SESSION[$staffId]."' LIMIT 1";
				} else if ($q->vendor=='microsoft') {
						$sql="SELECT TOP 1 * FROM [staff] WHERE [staffId]='".$_SESSION[$staffId]."'";
				} else if ($q->vendor=='oracle') {
						$sql="SELECT * FROM \"staff\"	WHERE \"staffId\"='".$_SESSION[$staffId]."' AND  rownum <=1 ";
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
					if($q->vendor=='normal' || $q->vendor=='mysql') {
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
		
		var leafUserProxy = new Ext.data.HttpProxy({
        url: "../controller/leafUserController.php",
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { //Ext.MessageBox.alert(systemLabel, jsonResponse.message); //uncomment it for debugging purpose
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var leafUserReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "leafUserId"
    });
    var leafUserStore = new Ext.data.JsonStore({
        proxy: leafUserProxy,
        reader: leafUserReader,
        autoLoad: true,
        autoDestroy: true,
        baseParams: {
            method: "read",
            grid: "master",
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            perPage: perPage
        },
        root: "data",
        fields: [{
            name: "leafUserId",
            type: "int"
        },
        {
            name: "leafId",
            type: "int"
        },
        {
            name: "leafSequence",
            type: "int"
        },
        {
            name: "staffId",
            type: "int"
        },
        {
            name: "leafTranslate",
            type: "string"
        }]
    });
	
	var columnModel = [new Ext.grid.RowNumberer(), 
		   {
        dataIndex: "leafTranslate",
        header: 'Application ',
        sortable: true,
        hidden: false
    },{
        id: 'action',
        header: 'Task',
        xtype: 'actioncolumn',
        width: 75,
        items: [{
            icon: '../../javascript/resources/images/icon/arrow_up.png',
            tooltip: updateRecordToolTipLabel,
            handler: function(grid, rowIndex, colIndex) {
                var record = leafUserStore.getAt(rowIndex);
                Ext.Ajax.request({
                                url: "../controller/leafUserController.php",
                                params: {
                                    method: "up",
                                    leafUserId: record.data.leafUserId,
                                    leafId: leafId
                                },
                                success: function(response, options) {
                                    jsonResponse = Ext.decode(response.responseText);
                                    if (jsonResponse.success == true) {
                                        title = successLabel;
                                    } else {
                                        title = failureLabel;
                                    }
                                    leafUserStore.reload({
                                        params: {
                                            leafId: leafId,
                                            start: 0,
                                            limit: perPage
                                        }
                                    });
                                    leafUserStoreList.reload({
                                        params: {
                                            leafId: leafId,
                                            start: 0,
                                            limit: perPage
                                        }
                                    });
                                    Ext.MessageBox.alert(title, jsonResponse.message);
                                },
                                failure: function(response, options) {
                                    Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + response.statusText);
                                }
                            });
            }
        },{
            icon: '../../javascript/resources/images/icon/arrow_down.png',
            tooltip: updateRecordToolTipLabel,
            handler: function(grid, rowIndex, colIndex) {
                var record = leafUserStore.getAt(rowIndex);
                Ext.Ajax.request({
                                url: "../controller/leafUserController.php",
                                params: {
                                    method: "down",
                                    leafUserStore: record.data.leafUserStore,
                                    leafId: leafId
                                },
                                success: function(response, options) {
                                    jsonResponse = Ext.decode(response.responseText);
                                    if (jsonResponse.success == true) {
                                        title = successLabel;
                                    } else {
                                        title = failureLabel;
                                    }
                                    leafUserStore.reload({
                                        params: {
                                            leafId: leafId,
                                            start: 0,
                                            limit: perPage
                                        }
                                    });
                                    leafUserStoreList.reload({
                                        params: {
                                            leafId: leafId,
                                            start: 0,
                                            limit: perPage
                                        }
                                    });
                                    Ext.MessageBox.alert(title, jsonResponse.message);
                                },
                                failure: function(response, options) {
                                    Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + response.statusText);
                                }
                            });
            }
        },
        {
            icon: '../../javascript/resources/images/icon/trash.gif',
            tooltip: deleteRecordToolTipLabel,
            handler: function(grid, rowIndex, colIndex) {
                var record = leafUserStore.getAt(rowIndex);
                Ext.Msg.show({
                    title: deleteRecordTitleMessageLabel,
                    msg: deleteRecordMessageLabel,
                    icon: Ext.Msg.QUESTION,
                    buttons: Ext.Msg.YESNO,
                    scope: this,
                    fn: function(response) {
                        if ("yes" == response) {
                            Ext.Ajax.request({
                                url: "../controller/leafUserController.php",
                                params: {
                                    method: "delete",
                                    leafUserStore: record.data.leafUserStore,
                                    leafId: leafId
                                },
                                success: function(response, options) {
                                    jsonResponse = Ext.decode(response.responseText);
                                    if (jsonResponse.success == true) {
                                        title = successLabel;
                                    } else {
                                        title = failureLabel;
                                    }
                                    leafUserStore.reload({
                                        params: {
                                            leafId: leafId,
                                            start: 0,
                                            limit: perPage
                                        }
                                    });
                                    leafUserStoreList.reload({
                                        params: {
                                            leafId: leafId,
                                            start: 0,
                                            limit: perPage
                                        }
                                    });
                                    Ext.MessageBox.alert(title, jsonResponse.message);
                                },
                                failure: function(response, options) {
                                    Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + response.statusText);
                                }
                            });
                        }
                    }
                });
            }
        }]
    }];
		var tabPanel 		= new Ext.TabPanel({
        	region			: 'center',
        	id				: 'centerTabs',
        	deferredRender	: true,
			height : 50,
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
		var ribbon = new Ext.ux.Ribbon({
                   
                    activeTab : 0,
                    items : [{
                            title : 'Home',
                            ribbon : [{
                                    title : 'Clipboard',
                                    cfg : {
                                        columns : 2,
                                        defaults : {
                                            width : 60
                                        }
                                    },
                                    items : [{
                                            text : 'Paste',
                                            iconCls : "paste-icon",
                                            rowspan : 3,
                                            width : 50,
                                            height : 70
                                        },{
                                            text : 'Edit',
                                            iconCls : 'pencil-icon',
                                            scale : 'small',
                                            iconAlign : 'left'
                                        },{
                                            text : 'Copy',
                                            scale : 'small',
                                            iconCls : 'copy-icon',
                                            iconAlign : 'left'
                                        },{
                                            text    : "Cut",
                                            iconCls : "cut-icon",
                                            scale : 'small',
                                            iconAlign : 'left'
                                        }]
                                },{
                                    title : 'Records',
                                    cfg : {
                                        defaults : {
                                            width : 60
                                        }
                                    },
                                    items : [{
                                            text : 'Simple Add',
                                            iconCls : 'add-icon'
                                        },{
                                            text : 'Complex Add',
                                            iconCls : 'add2-icon'
                                        },{
                                            text : 'Grid Search',
                                            iconCls : 'book-icon'
                                        }]
                                },{
                                    title : 'Database',
                                    cfg : {
                                        columns: 3,
                                        defaults: {
                                            allowDepress : true,
                                            enableToggle : true,
                                            toggleGroup : 'tg-ribbon'
                                        }
                                    },
                                    items : [{
                                            text : 'Scheme Branch',
                                            iconCls : 'branch1-icon',
                                            rowspan : 3,
                                            pressed : true
                                        },{
                                            text : 'Table Element',
                                            iconCls : 'branch2-icon',
                                            rowspan : 3
                                        },{
                                            text : 'Create a new table',
                                            iconCls : 't1-icon',
                                            scale : 'small',
                                            iconAlign : 'left'
                                        },{
                                            text : 'Connect an existing table',
                                            iconCls : 't2-icon',
                                            scale : 'small',
                                            iconAlign : 'left'
                                        },{
                                            text : 'Delete an existing table',
                                            iconCls : 't3-icon',
                                            scale : 'small',
                                            iconAlign : 'left'
                                        }]
                                }]
                        },{
                            title : 'Office Sample',
                            ribbon : [{
                                    title : '<blink>Click me</blink>',
                                    onTitleClick : function(){
                                        Ext.Msg.alert('Yes','You have been clicked on ribbon title.');
                                    },
                                    items :[{
                                            text : 'Connect',
                                            iconCls : 'db1-icon',
                                            arrowAlign : 'bottom',
                                            menu : [{
                                                    text : 'Option1',
                                                    iconCls : 't1-icon'
                                                }]
                                        },{
                                            text : 'Select',
                                            iconCls : 'db2-icon',
                                            arrowAlign : 'bottom',
                                            menu : [{
                                                    text : 'Option1',
                                                    iconCls : 't2-icon'
                                                }]
                                        }]
                                },{
                                    title : 'Title on Top',
                                    topTitle : true,
                                    cfg : {
                                        columns : 2
                                    },
                                    items : [{
                                            text : 'Personal Info',
                                            iconCls : 'spy-icon',
                                            rowspan : 3,
                                            style : 'padding-right:5px'
                                        },{
                                            xtype : 'textfield',
                                            anchor : '100%',
                                            emptyText : 'Display text'
                                        },{
                                            xtype : 'textfield',
                                            anchor : '100%',
                                            emptyText : 'Display text'
                                        },{
                                            text : "Work Exp. & Others",
                                            iconCls : "pencil-icon",
                                            scale : "small",
                                            iconAlign : "left"
                                        }]
                                },{
                                    title : 'Only icons',
                                    cfg : {
                                        columns : 3,
                                        defaults : {
                                            height : 25,
                                            scale : 'small',
                                            iconAlign : 'left'
                                        }
                                    },
                                    items :[{
                                            text : '',
                                            iconCls : 'pencil-icon'
                                        },{
                                            text : '',
                                            iconCls : 't1-icon'
                                        },{
                                            text : '',
                                            iconCls : 'pencil-icon'
                                        },{
                                            text : '',
                                            iconCls : 't1-icon'
                                        },{
                                            text : '',
                                            iconCls : 'pencil-icon'
                                        },{
                                            text : '',
                                            iconCls : 't1-icon'
                                        },{
                                            text : '',
                                            iconCls : 'pencil-icon'
                                        },{
                                            text : '',
                                            iconCls : 't1-icon'
                                        },{
                                            text : '',
                                            iconCls : 'pencil-icon'
                                        }]
                                },{
                                    title : 'Form components',
                                    topTitle : true,
                                    cfg : {
                                        columns : 2
                                    },
                                    items : [{
                                            text : 'JAR Preferences',
                                            iconCls : 'jar-icon',
                                            rowspan : 3,
                                            style : 'padding-right:5px'
                                        },{
                                            xtype : 'checkbox',
                                            anchor : '100%',
                                            boxLabel : 'This is a checkbox'
                                        },{
                                            xtype : 'radio',
                                            anchor : '100%',
                                            name : 'radion1',
                                            boxLabel : 'This a radio option1'
                                        },{
                                            xtype : 'radio',
                                            anchor : '100%',
                                            name : 'radion1',
                                            boxLabel : 'This a radio option2'
                                        }]
                                }]
                        }]
                });
		var clock =new Ext.Toolbar.TextItem('');
		new Ext.Viewport({
			id			: 'screenPage',
			layout		: 'border',
			items		: [{
						   	xtype: 'panel',
							height: 105,
							region :'north',
							items :[{
										xtype: 'box',
										html:'IDCMS Core System',
										cls: 'header',
										height: 30,
									},{ 
										xtype:'panel',
                						height:30,
										bbar		:	[{
															xtype	:	'label',
															text	:	'Welcome '+username,
															iconCls	:	'user'
														 },'->',{
																xtype			:	'combo',
																fieldLabel		:	'Quick Code',
																displayField	:	'Quick Code',
																mode			: 	'local',
																triggerAction	: 	'all',
																selectOnFocus	:	true,
																resizable		:	false,
																listWidth		: 	300,
																width			: 	300,
																valueField		: 	'leafId',
																emptyText		:	'Quick Menu',
																store			:	language_selecter,
																listeners		: 	{
																	select: function () {
																		// if user type in name or code similiar to it.. open new tab
																		//window.location.replace("language.php?languageId="+this.getValue());
																	}
																}
														},'-',{
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
														},'-',{
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
														},'-',{
																xtype	:	'button',
																text	:	'Log Out',
																iconCls	:	'house',
																handler	:	function() {
																		window.location.replace("../../index.php");
																}
							
														}]
			 },{
					xtype:'panel',
					padding :'8px',
					
					tbar :[{
								xtype:'button',
								scale :'large',
								text:'setting',
								iconCls:'cog'
					},'-',{
								xtype:'button',
								scale :'large',
								text:'Management',
								iconCls:'user'
					},'-',{
								xtype:'button',
								scale :'large',
								text:'security',
								iconCls:'key'
					}]
			 }]
			
		} ,  {
				xtype:'panel',
				region :'west',
				html :'<p> this is where <br>tree loader execute<br>And it will load the lastest folder and leaf</p>'
		},{
				region		: 	'center',
				layout		:	'border',
				html        :  'tstin',
				margins		: 	'5 0 5 5',
				items		: 	[tabPanel]
		      },{
			  	region  :'south',
				xtype :'panel',
				bbar :['->',{
			xtype :'button',
			title :'calendar',
			iconCls :'calendar'
	   },'-',{
			xtype :'button',
			title :'chat',
			iconCls :'group'
	   },'-',{
			xtype :'button',
			title :'mail',
			iconCls :'email'
	   },'-',{
			xtype :'button',
			title :'todo',
			iconCls :'lightbulb'
	   },'-',clock]
			  }], listeners: {
            render: {
                fn: function(){
                   

                    // Kick off the clock timer that updates the clock el every second:
				    Ext.TaskMgr.start({
				        run: function(){
				            Ext.fly(clock.getEl()).update(new Date().format('g:i:s A'));
							// check status whos'online for chatting
							//check status email
							
				        },
				        interval: 1000
				    });
                },
                delay: 100
            }
        }
    });
});
</script>
</html>
