Ext.onReady(function(){
	// get current information  of the page
	var pageCreate;
	var pageReload;
	var pagePrint;
	if(leafCreateAccessValue  == 1 ) {
		pageCreate = false;
	} else { 
		pageCreate = true;
	}
	if(leafReadAccessValue  == 1 ){ 
		pageReload=false;
	} else { 
		pageReload=true;
	} 
	if(leafPrintAccessValue == 1 ) {
		pagePrint=false;
	} else {
		pagePrint=true;
	}				
	Ext.BLANK_IMAGE_URL ='../../javascript/resources/images/s.gif';
	var perPage		= 	10;
	var encode 			=	false;
	var local 			= 	false;
	var store 			= 	new Ext.data.JsonStore({
		autoDestroy		:	true,
		url				: 	'../controller/groupController.php',
		remoteSort		: 	true,
		storeId			:	'myStore',
		root			:	'data',
		totalProperty	:	'total',
		baseParams		: 	
		{  	
			method				:	'read',	
			mode				:	'view', 		
			leafId	:	leafId
		}, 
fields: [	
		{	name		:	'groupId',
			type        :   'int'						
		},{
			name		:	'groupTranslate',
			type        :   'string'							
		},{
			name		:	'groupNote',
			type        :   'string'							
		}, {
            name: "isDefault",
            type: "boolean"
        }, {
            name: "isNew",
            type: "boolean"
        }, {
            name: "isDraft",
            type: "boolean"
        }, {
            name: "isUpdate",
            type: "boolean"
        }, {
            name: "isDelete",
            type: "boolean"
        }, {
            name: "isActive",
            type: "boolean"
        }, {
            name: "isApproved",
            type: "boolean"
        }, {
            name: "Time",
            type: "date",
            dateFormat: "Y-m-d H:i:s"
        }
		]
	});
	
	var staffProxy = new Ext.data.HttpProxy({
		url : "../controller/groupController.php",
		method : "GET",
		params : {
			method : 'read',
			field : 'staffId',
			leafId : leafId
		},
		success : function(response, options) {
			var x = Ext.decode(response.responseText);
			if (x.success == "true") {
				title = successLabel;
			} else {
				title = failureLabel;
			}
			Ext.MessageBox.alert(systemLabel, x.message);
		},
		failure : function(response, options) {

			Ext.MessageBox.alert(systemErrorLabel,
					escape(response.Status) + ":"
							+ escape(response.statusText));
		}

	});
	var staffReader = new Ext.data.JsonReader({
		root : "staff",
		id : "staffId"
	}, [ "staffId", "staffName" ]);
	var staffStore = new Ext.data.Store({
		proxy : staffProxy,
		reader : staffReader,
		remoteSort : false
	});
	staffStore.load();
	var filters 		= 	new Ext.ux.grid.GridFilters({
	
		encode	:	encode,
		local	:	false,   
filters: [	
		{	
			type		: 	'string',
			dataIndex	:	'groupTranslate',
			column		:	'groupTranslate',
			table		:	'group'
		},{	
			type		:   'string',
			dataIndex	:	'groupNote',
			column		:	'groupNote',
			table		:	'group'
		}]
	});
	this.action 		= 	new Ext.ux.grid.RowActions({
		header		:	actionLabel,
		dataIndex	:	'groupId',
		actions		:	[{
			iconCls		:	'application_edit',
			callback 	: function(grid, record, action, row, col){ 
			
				formPanel.getForm().reset();
				formPanel.form.load({ 
					url		:	'../controller/groupController.php',
					method	:	'POST',
					waitMsg	:	waitMessageLabel,
					params	:	{ 	
						method				:	'read',
						mode				:	'update',
						groupId		:	record.data.groupId, 
						leafId 	: 	leafId
					}, 
					success : function(form,action) {
						
						viewPort.items.get(1)
						.expand();
					},
					failure : function(form,
					action) {
						
						Ext.MessageBox
						.alert(
						systemErrorLabel,
						action.result.message);
					}
				});
			}
		},{
			iconCls		:	'application_form_delete',
			callback	: 	function(grid, record, action, row, col) {
				Ext.Msg.show({
					title	:	deleteRecordTitleMessageLabel,
					msg		:	deleteRecordMessageLabel,
					icon	:	Ext.Msg.QUESTION,
					buttons	:	Ext.Msg.YESNO,
					scope	:	this,
					fn		:	function(response) {
						if('yes' == response) {
							Ext.Ajax.request({ 
								url		:	'../controller/groupController.php',
								params	:	{	
									method				:	'delete',
									groupId		:	record.data.groupId, 
									leafId 	: 	leafId
								},
								success : function(response, options) {
									var x = Ext.decode(response.responseText);
									var title = "Message";
									if (x.success == "true") {
										title = title + " Success";
									} else {
										title = title + " Failure";
									}
									Ext.MessageBox.alert(title, x.message);
									store.reload();
									
								},
								failure : function(response, options) 
								{
									status_code = response.status;
									status_message = response.statusText;
									Ext.MessageBox.alert(systemErrorLabel,escape(status_code)
									+ ":"+ status_message);
								}
							});
						} 
					}
				});
			}
		}]
	});
	var columnModel 	=	[ this.action,{		
		dataIndex	:	'groupTranslate',
		header		:	groupTranslateLabel,
		width		:	'100px'
	},{		
		dataIndex	:	'groupNote',
		header		:	groupNoteLabel,
		width		: 	'400px'
	}];
	var grid 			=	new Ext.grid.GridPanel({
		border				:	false,
		store				:	store,
		autoHeight			:	'auto',
		columns				:	columnModel,
		loadMask			: 	true,
		plugins				: 	[this.action,filters],
		sm					: 	new Ext.grid.RowSelectionModel({singleSelect: true}),
		
		listeners			: 	{
			render			: {
				fn			: function(){
					store.load({
						params	:	{
							start	:	0,
							limit	: 	perPage,
							method	:	'read',
							mode	:	'view'
						}
					});
				}
			}
		},
		bbar				: 	new Ext.PagingToolbar({
			store				:	store,
			pageSize			:	perPage,
			plugins				:	[filters]
		})
	});
	
	var toolbarPanel		= new Ext.Toolbar({ 
items:[{
			text 	: reloadToolbarLabel,		
			iconCls : 'database_refresh',
			handler : function () { 
				store.reload();
			} 
		},{	
			text 	: addToolbarLabel, 	
			iconCls : 'add',
			handler	:	function () {
				viewPort.items.get(1).expand();
			} 
		},{
									text : excelToolbarLabel,
									iconCls : "page_excel",
									id : "page_excelList",
									disabled : pagePrint,
									handler : function() {
										Ext.Ajax
												.request({
													url : "../controller/groupController.php?method=report&mode=excel&limit="
															+ perPage
															+ "&leafId="
															+ leafId,
													method : "GET",
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == "true") {
															window
																	.open("../group/document/excel/group.xlsx");
														} else {
															Ext.MessageBox
																	.alert(
																			systemErrorLabel,
																			x.message);
														}
													},
													failure : function(response, options) {
																			status_code = response.status;
																			status_message = response.statusText;
																			Ext.MessageBox.alert('system',escape(status_code)
																			+ ":"+ status_message);
																		}
												});
									}
								}] 
	});
	var gridPanel	  	= 	new Ext.Panel ({ 
title:leafNote,
height:50,
tbar:[ toolbarPanel,'->',new Ext.ux.form.SearchField({
                store: store,
                width:320
            })],
items:[grid]
	});
	// viewport just save information,items will do separate
	
	
	var groupTranslate 		= 	new Ext.form.TextField({
		labelAlign  :	'left',
		fieldLabel  :	groupTranslateLabel,
		hiddenName  :	'groupTranslate',
		name		:	'groupTranslate',
		anchor      :	'95%'
	});
	
	var groupNote	= 	new Ext.form.TextArea({ 
		labelAlign  : 	'left',
		fieldLabel	: 	groupNoteLabel,
		id			:   'groupNote',
		name		: 	'groupNote',
		height 		:	50,
		anchor 		:	'95%'
	});

	// hidden id for updated
	var groupId	= 	new Ext.form.Hidden({ name:'groupId'	});
	
	var formPanel 		= 	new Ext.form.FormPanel({
		url			: 	'../controller/groupController.php',
		params		:	{ method:'save',groupId:groupId.value }, 
		method		:  	'post',
		frame       : 	 true,
		title       : 	leafNote,
		border      : 	false,

		width		: 	600,
		items   	:	[  groupId,groupTranslate,groupNote],
buttonVAlign: 	'top',
		buttonAlign	: 	'left',
		buttons 	: 	[	{		text	:saveButtonLabel,
			handler :	function () { 
			 var id =0;
			 id  = Ext.getCmp('groupId').getValue();
											var method ;
											if(id.length > 0 ) { 
												method = 'save';
											} else {
												method = 'create';
											}
				formPanel.getForm().submit({
					waitMsg	:	waitMessageLabel,
					params	:	{ 
						method				:	method,
					
						leafId	:	leafId
					}, 
					success	:	function(form,action){
						
						formPanel.getForm().reset();
						store.reload({
							params: {
								leafId:leafId,
								start:0,
								limit:perPage
							}
						});
						// should be refresh back the main parent.
						viewPort.items.get(0).expand();
						
					},
					failure	:	function(form,action){
					
						if (action.failureType === Ext.form.Action.LOAD_FAILURE){
							alert(loadFailureMessageLabel);
						}
						else if (action.failureType === Ext.form.Action.CLIENT_INVALID){
							alert(clientInvalidMessageLabel);
						}
						else if (action.failureType === Ext.form.Action.CONNECT_FAILURE){
							Ext.Msg.alert(systemErrorLabel, 'Server reported:'+form.response.status+' '+form.response.statusText);
						}
						else if (action.failureType === Ext.form.Action.SERVER_INVALID){
							Ext.Msg.alert(systemErrorLabel, action.result.message);
						}
					}
					
				}); 
			} 
		},{ 	text 	: 	resetButtonLabel,
			type	:	'reset',
			handler	: 	function(){ 
				formPanel.getForm().reset(); 
				

				
			} }]
	}); 
	
	
	var viewPort		=	new Ext.Viewport({
		id				:	'viewport',
		region			:	'center',
		layout			:	'accordion',
		
		layoutConfig	: 	{
			// layout-specific configs go here
			titleCollapse	: true,
			animate			: true,
			activeOnTop		: true
		},
		items	:	[gridPanel,formPanel]
	});
	
});
