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
	href="../../javascript/resources/css/ext-all.css">
	<link rel="stylesheet" type="text/css"
		href="../../javascript/extensible/resources/css/extensible-all.css">
		<?php if(isset($_SESSION[$theme])) { ?>
		<link rel="stylesheet"
			href="<?php if(isset($_SESSION['theme'])) {
echo $_SESSION[$theme];
} ?>">
<?php } ?>
			<style>
.header {
	background: #7F99BE
		url(../../javascript/examples/layout-browser/images/layout-browser-hd-bg.gif)
		repeat-x center;
	font-size: 16px;
	color: #fff;
	font-weight: bold;
	padding: 5px 10px;
}

.paste-icon {
	background-image: url(../../javascript/ribbon/images/paste_32.png)
		!important;
}

.copy-icon {
	background-image: url(../../javascript/ribbon/images/copy_16.png)
		!important;
}

.cut-icon {
	background-image: url(../../javascript/ribbon/images/cut_16.png)
		!important;
}

.add-icon {
	background-image: url(../../javascript/ribbon/images/add.png) !important;
}

.add2-icon {
	background-image: url(../../javascript/ribbon/images/add2.png)
		!important;
}

.book-icon {
	background-image: url(../../javascript/ribbon/images/book.png)
		!important;
}

.pencil-icon {
	background-image: url(../../javascript/ribbon/images/pencil.png)
		!important;
}

.branch1-icon {
	background-image: url(../../javascript/ribbon/images/branch1.png)
		!important;
}

.branch2-icon {
	background-image: url(../../javascript/ribbon/images/branch2.png)
		!important;
}

.t1-icon {
	background-image: url(../../javascript/ribbon/images/table1.png)
		!important;
}

.t2-icon {
	background-image: url(../../javascript/ribbon/images/table2.png)
		!important;
}

.t3-icon {
	background-image: url(../../javascript/ribbon/images/table3.png)
		!important;
}

.db1-icon {
	background-image: url(../../javascript/ribbon/images/t1.png) !important;
}

.db2-icon {
	background-image: url(../../javascript/ribbon/images/t2.png) !important;
}

.spy-icon {
	background-image: url(../../javascript/ribbon/images/spy.png) !important;
}

.jar-icon {
	background-image: url(../../javascript/ribbon/images/jar.png) !important;
}
</style>

</head>
<body>
</body>
<script type="text/javascript"
	src="../../javascript/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="../../javascript/ext-all.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/iframe.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/treegrid/TreeGridSorter.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/treegrid/TreeGridColumnResizer.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/treegrid/TreeGridNodeUI.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/treegrid/TreeGridLoader.js"></script>

<script type="text/javascript"
	src="../../javascript/examples/ux/treegrid/TreeGridColumns.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/treegrid/TreeGrid.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/Ext.ux.TabCloseMenu/Ext.ux.TabCloseMenu.js"></script>
<script type="text/javascript"
	src="../../javascript/examples/ux/TabScrollerMenu.js"></script>
<script type="text/javascript"
	src="../../javascript/ribbon/Ext.ux.Ribbon.js"></script>
<?php require_once("../../shared/setting.php"); ?>
<script type="text/javascript">

	// used Dreamweaver for easy javascript viewing.

	Ext.onReady(function(){
		// remember new code style
	var perPage=100;

    	Ext.BLANK_IMAGE_URL ='../../javascript/resources/images/s.gif';

		var username	= ' : <?php echo strtoupper($_SESSION['staffName']); ?>';
		var theme_selecter = new Ext.data.SimpleStore({
			fields	: ['display', 'value'],
			data	: [	['Default (Blue)', ''],
						['Black',   '../../javascript/resources/css/xtheme-black.css'],
						['Vampire', '../../javascript/resources/css/xtheme-vampire.css'],
						['Toxic', '../../javascript/resources/css/xtheme-Toxic.css'],
						['Darkness', '../../javascript/resources/css/xtheme-darkness.css'],
						['BlackNW', '../../javascript/resources/css/xtheme-blacknw.css'],
						['Blue', '../../javascript/resources/css/xtheme-blue.css'],
						['Access', '../js/resources/css/xtheme-access.css'],
						['Dark Gray', '../../javascript/resources/css/xtheme-darkgray.css'],
						['Gray', '../../javascript/resources/css/xtheme-gray.css'],
						['Olive', '../../javascript/resources/css/xtheme-olive.css'],
						['Pink', '../../javascript/resources/css/xtheme-pink.css'],
						['Galdaka', '../../javascript/resources/css/xtheme-galdaka.css'],
						['Chocolate', '../../javascript/resources/css/xtheme-chocolate.css'],
						['Silver Cherry', '../../javascript/resources/css/xtheme-silverCherry.css'],
						['Slickness', '../../javascript/resources/css/xtheme-slickness.css'],
						['Midnight', '../../javascript/resources/css/xtheme-midnight.css'],
						['Indigo', '../../javascript/resources/css/xtheme-indigo.css'],
						['Pepermint','../../javascript/resources/css/xtheme-peppermint.css'],
						['Ubuntu','../../javascript/resources/css/xtheme-human.css']]
		});
		

		var themeProxy = new Ext.data.HttpProxy({
			url : "../controller/themeController.php?",
			method : "GET",
			success : function(response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,
					// jsonResponse.message);
					// //uncommen for testing
					// purpose
				} else {
					Ext.MessageBox.alert(systemErrorLabel,
							jsonResponse.message);
				}
			},
			failure : function(response, options) {
				Ext.MessageBox.alert(systemErrorLabel,
						escape(response.Status) + ":"
								+ escape(response.statusText));
			}
		});
		var themeReader = new Ext.data.JsonReader({
			totalProperty : "total",
			successProperty : "success",
			messageProperty : "message",
			idProperty : "themeId"
		});
		var themeStore = new Ext.data.JsonStore({
			proxy : themeProxy,
			reader : themeReader,
			autoLoad : true,
			autoDestroy : true,
			baseParams : {
				method : 'read',
				field : 'staffId',
				leafId : leafId
			},
			root : 'theme',
			fields : [ {
				name : "themeId",
				type : "int"
			}, {
				name : "themeName",
				type : "string"
			} ,{
				name :"themePath",
				type:"string"
			}]
		});

		var languageProxy = new Ext.data.HttpProxy({
			url : "../controller/languageController.php?",
			method : "GET",
			success : function(response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,
					// jsonResponse.message);
					// //uncommen for testing
					// purpose
				} else {
					Ext.MessageBox.alert(systemErrorLabel,
							jsonResponse.message);
				}
			},
			failure : function(response, options) {
				Ext.MessageBox.alert(systemErrorLabel,
						escape(response.Status) + ":"
								+ escape(response.statusText));
			}
		});
		var languageReader = new Ext.data.JsonReader({
			totalProperty : "total",
			successProperty : "success",
			messageProperty : "message",
			idProperty : "languageId"
		});
		var languageStore = new Ext.data.JsonStore({
			proxy : languageProxy,
			reader : languageReader,
			autoLoad : true,
			autoDestroy : true,
			baseParams : {
				method : 'read',
				field : 'languageId',
				leafId : leafId
			},
			root : 'language',
			fields : [ {
				name : "languageId",
				type : "int"
			}, {
				name : "languageDesc",
				type : "string"
			} ]
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

    	var tree = new Ext.tree.TreePanel({
    	    
    	    useArrows: true,
    	    autoScroll: true,
    	    animate: true,
    	    enableDD: true,
    	    containerScroll: true,
    	    border: false,
    	    // auto create TreeLoader
    	    dataUrl: '../controller/treeController.php',
	
    	    root: {
    	        nodeType: 'async',
    	        text: 'Ext JS',
    	        draggable: false,
    	        id: 'module'
    	    }
    	});



var treeJS = new Ext.tree.TreePanel( {
animate:true,
enableDD:false,
singleExpand: true,
loader: new Ext.tree.TreeLoader({
	dataUrl:"../controller/treeController.php"
}), // Note: no dataurl, register a TreeLoader to make use of createNode()
lines:false,
expanded:false,
root: new Ext.tree.AsyncTreeNode({
draggable:false,
id:'source'
}),
rootVisible:false
});
//treeJs.expand();
    	
	    
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
										height: 30
									},{
										xtype:'panel',
                						height:30,
										bbar		:	['-',{
																xtype			:	'combo',
																fieldLabel		:	'Quick Code',
																displayField	:	'Quick Code',
																mode			: 	'local',
																triggerAction	: 	'all',
																selectOnFocus	:	true,
																resizable		:	false,
																listWidth		: 	800,
																width			: 	800,
																valueField		: 	'leafId',
																emptyText		:	'Quick Menu',
																store			:	language_selecter,
																disabled		:   false,
																listeners		: 	{
																	select: function () {
																		// if user type in name or code similiar to it.. open new tab
																		window.location.replace("language.php?languageId="+this.getValue());
																	}
																}
														},'->',{
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
																disabled		:   true,
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
				title:'Tree Menu',
				width : '250',
				minSize		: 400,

				maxSize		: 400,
				collapsible	: true,
				items :[treeJS]
		},{
				region		: 	'center',
				layout		:	'border',
				html        :  'tstin',
				margins		: 	'5 0 5 5',
				items		: 	[tabPanel]
		      },{
			  	region  :'south',
				xtype :'panel',
				bbar :[{
					xtype	:	'label',
					text	:	'Welcome '+username,
					iconCls	:	'user'
				 },'->',{
			xtype :'button',
			title :'calendar',
			iconCls :'calendar',
			disabled: true
	   },'-',{
			xtype :'button',
			title :'chat',
			iconCls :'group',
			disabled: true
	   },'-',{
			xtype :'button',
			title :'mail',
			iconCls :'email',
			disabled : true
	   },'-',{
			xtype :'button',
			title :'todo',
			iconCls :'lightbulb',
			disabled : true
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
