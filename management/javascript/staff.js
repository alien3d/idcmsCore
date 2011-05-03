Ext.onReady(function(){
		Ext.QuickTips.init();
		// get current information  of the page
		
	Ext.form.Field.prototype.msgTarget = 'under';
	var page_create;
	var page_createList;
	var page_reload;
	var page_reloadList;
	var page_print;
	var page_printList;
	if (leafCreateAccessValue == 1) {
		page_create = false;
		page_createList = false;
	} else {
		page_create = true;
		page_createList = true;
	}
	if (leafReadAccessValue == 1) {
		page_reload = false;
		page_reloadList = false;
	} else {
		page_reload = true;
		page_reloadList = true;
	}
	if (leafPrintAccessValue == 1) {
		page_print = false;
		page_printList = false;
	} else {
		page_print = true;
		page_printList = true;
	}
		Ext.BLANK_IMAGE_URL ='../../javascript/resources/images/s.gif';
    	var per_page		= 	15;
		var encode 			=	false;
    	var local 			= 	false;
		var store 			= 	new Ext.data.JsonStore({
        	autoDestroy		:	true,
        	url				: 	'../controller/staffController.php',
        	remoteSort		: 	true,
        	storeId			:	'myStore',
        	root			:	'data',
        	totalProperty	:	'total',
			baseParams		: 	{ 
									method			:	'read',	
									mode			:	'view',
									leafId	:	leafId
								}, 
        	fields			: [	
							   	{	name		:	'staffId',	
								    type        :   'int'
								},{
        	         			 	name		:	'groupId',	
								    type        :   'int'
								},{
								 	name		:	'groupName',
                                    type        :   'string'									
								},{
									name		:	'staffName',
                                    type        :   'string'									
								},{
        	         			 	name		:	'staffIc',
                                    type        :   'string'									
								},{
									name		:	'staffNo',
                                    type        :   'string'									
								},{
								 	name		:	'createBy',
                                    type        :   'int'									
								},{
									name		:	'createTime',
                                    type        :   'date',
					                dateFormat  :   'Y-m-d H:i:s'									
								},{ 
								 	name		:	'updatedBy',
                                    type        :   'int'									
								},{
								 	name		:	'updatedTime',
                                    type        :   'date',
					                dateFormat  :   'Y-m-d H:i:s'									
								}
					 		],
									listeners : {
										exception : function(DataProxy, type,
												action, options, response, arg) {
											var serverMessage = Ext.util.JSON
													.decode(response.responseText);
											if (serverMessage.success == false
													) {
												Ext.MessageBox.alert(systemErrorLabel,
														serverMessage.message);
											}
										}
									}
    	});

		var storeList 			= 	new Ext.data.JsonStore({
        	autoDestroy		:	true,
        	url				: 	'../controller/staffController.php',
        	remoteSort		: 	true,
        	root			:	'data',
        	totalProperty	:	'total',
			baseParams		: 	{ 
									method			:	'read',	
									mode			:	'view',
									leafId	:	leafId
								}, 
        	fields			: [	
							   	{	name		:	'staffId',	
								    type        :   'int'
								},{
        	         			 	name		:	'groupId',	
								    type        :   'int'
								},{
								 	name		:	'groupName',
                                    type        :   'string'									
								},{
									name		:	'staffName',
                                    type        :   'string'									
								},{
        	         			 	name		:	'staffIc',
                                    type        :   'string'									
								},{
									name		:	'staffNo',
                                    type        :   'string'									
								},{
								 	name		:	'createBy',
                                    type        :   'int'									
								},{
									name		:	'createTime',
                                    type        :   'date',
					                dateFormat  :   'Y-m-d H:i:s'									
								},{ 
								 	name		:	'updatedBy',
                                    type        :   'int'									
								},{
								 	name		:	'updatedTime',
                                    type        :   'date',
					                dateFormat  :   'Y-m-d H:i:s'									
								}
					 		],
									listeners : {
										exception : function(DataProxy, type,
												action, options, response, arg) {
											var serverMessage = Ext.util.JSON
													.decode(response.responseText);
											if (serverMessage.success == false
													) {
												Ext.MessageBox.alert(systemErrorLabel,
														serverMessage.message);
											}
										}
									}
    	});
		
		
		var staff_reader	= new Ext.data.JsonReader({ root:'staff',id:'staffId' }, [ 'staffId', 'staffName']);
	    
		
		var staff_store 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'../controller/staffController.php?method=read&field=staffId&leafId='+leafId,
					method:'GET',
									listeners : {
										exception : function(DataProxy, type,
												action, options, response, arg) {
											var serverMessage = Ext.util.JSON
													.decode(response.responseText);
											if (serverMessage.success == false
													) {
												Ext.MessageBox.alert(systemErrorLabel,
														serverMessage.message);
											}
										}
									}
				}),
			reader		:	staff_reader,
			remoteSort	:	false 
		});
		
		var group_reader	= new Ext.data.JsonReader({ root:'group',id:'groupId' }, [ 'groupId', 'groupName']);
	    
		
		var group_store 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'../controller/staffController.php?method=read&field=groupId&leafId='+leafId,
					method:'GET',
									listeners : {
										exception : function(DataProxy, type,
												action, options, response, arg) {
											var serverMessage = Ext.util.JSON
													.decode(response.responseText);
											if (serverMessage.success == false
													) {
												Ext.MessageBox.alert(systemErrorLabel,
														serverMessage.message);
											}
										}
									}
				}),
			reader		:	group_reader,
			remoteSort	:	false 
		});
		group_store.load();
		var filters 		= 	new Ext.ux.grid.GridFilters({
        	// encode and local configuration options defined previously for easier reuse
        	encode	:	encode, // json encode the filter query
        	local	:	false,   // defaults to false (remote filtering)
        	filters: [	{	
							type		: 	'list',
							dataIndex	:	'groupId',
							column		:	'groupId',
							table		:	'staff',
							labelField	:	'groupName',
							store		:	group_store,
							phpMode		:	true	
						},{	
							type		: 	'string',
							dataIndex	:	'staffName',
							column		:	'staffName',
							table		:	'staff'
        				},{	
							type		: 	'string',
							dataIndex	:	'staffIc',
							column		:	'staffIc',
							table		:	'staff'
        				},{	
							type		: 	'string',
							dataIndex	:	'staffNo',
							column		:	'staffNo',
							table		:	'staff'
        				},{	
							type		: 	'list',
							dataIndex	:	'createBy',
							column		:	'createBy',
							table		:	'staff',
							labelField	:	'staffName',
							store		:	staff_store,
							phpMode		:	true		
        				},{	
							type		: 	'date',
							dataIndex	:	'createTime',
							column		:	'createTime',
							table		:	'staff'
						},{	
							type		: 	'list',
							dataIndex	:	'updatedBy',
							column		:	'updatedBy',
							table		:	'staff',
							labelField	:	'staffName',
							store		:	staff_store,
							phpMode		:	true
						},{	
							type		: 	'date',
							dataIndex	:	'updatedTime',
							column		:	'updatedTime',
							table		:	'staff'
						}]
    	});
		var filtersList 		= 	new Ext.ux.grid.GridFilters({
        	// encode and local configuration options defined previously for easier reuse
        	encode	:	encode, // json encode the filter query
        	local	:	false,   // defaults to false (remote filtering)
        	filters: [	{	
							type		: 	'list',
							dataIndex	:	'groupId',
							column		:	'groupId',
							table		:	'staff',
							labelField	:	'groupName',
							store		:	group_store,
							phpMode		:	true	
						},{	
							type		: 	'string',
							dataIndex	:	'staffName',
							column		:	'staffName',
							table		:	'staff'
        				},{	
							type		: 	'string',
							dataIndex	:	'staffIc',
							column		:	'staffIc',
							table		:	'staff'
        				},{	
							type		: 	'string',
							dataIndex	:	'staffNo',
							column		:	'staffNo',
							table		:	'staff'
        				},{	
							type		: 	'list',
							dataIndex	:	'createBy',
							column		:	'createBy',
							table		:	'staff',
							labelField	:	'staffName',
							store		:	staff_store,
							phpMode		:	true		
        				},{	
							type		: 	'date',
							dataIndex	:	'createTime',
							column		:	'createTime',
							table		:	'staff'
						},{	
							type		: 	'list',
							dataIndex	:	'updatedBy',
							column		:	'updatedBy',
							table		:	'staff',
							labelField	:	'staffName',
							store		:	staff_store,
							phpMode		:	true
						},{	
							type		: 	'date',
							dataIndex	:	'updatedTime',
							column		:	'updatedTime',
							table		:	'staff'
						}]
    	});
		this.action 		= 	new Ext.ux.grid.RowActions({
        	header		:	actionLabel,
			dataIndex	:	'staffId',
			actions		:	[{
          		iconCls		:	'application_edit',
				toolTip		:	updateRecordToolTipLabel,
            	callback 	: function(grid, record, action, row, col){ 
							
								formPanel.getForm().reset();
								formPanel.form.load({ 
									url		:	'../controller/staffController.php',
									method	:	'POST',
									waitMsg	:	waitMessageLabel,
									params	:	{	
													method 					:	'read',
													mode					:	'update',
													staffId			:	record.data.staffId,
													leafId			:	leafId
												}, 
									success	:	function(form,action) {
                						
										viewPort.items.get(1).expand();
									},        	
            						failure	:	function(form,action) {
                						Ext.MessageBox.alert(systemErrorLabel,
																		action.result.message);
            						}
   								});
								win.hide();
			}
		},{
			iconCls		:	'trash',
			toolTip		:	deleteRecordToolTipLabel,
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
							url		:	'staff_data.php',
							params	:	{	
											method			:	'delete',
											staffId	:	record.data.staffId,
											leafId	:	leafId
										},
							success	:	function(response,options){
								var x =  Ext.decode(response.responseText);
								if(x.success=='false') {
									Ext.MessageBox.alert(systemLabel,x.message);		
									} else {	
									Ext.MessageBox.alert(systemLabel,x.message);	
									
								}				
								
								store.reload({
									params :{
										leafId:leafId,
										start:0,
										limit:per_page
									}
								});
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

		this.actionList 		= 	new Ext.ux.grid.RowActions({
        	header		:	actionLabel,
			dataIndex	:	'staffId',
			actions		:	[{
          		iconCls		:	'application_edit',
				toolTip		:	updateRecordToolTipLabel,
            	callback 	: function(grid, record, action, row, col){ 
								//Ext.MessageBox.alert('message','This is for update button');
								formPanel.getForm().reset();
								formPanel.form.load({ 
									url		:	'../controller/staffController.php',
									method	:	'POST',
									waitMsg	:	waitMessageLabel,
									params	:	{	
													method 					:	'read',
													mode					:	'update',
													staffId			:	record.data.staffId,
													leafId			:	leafId
												}, 
									success	:	function(form,action) {
                						
										viewPort.items.get(1).expand();
									},        	
            						failure	:	function(form,action) {
                						Ext.MessageBox.alert(systemErrorLabel,
																		action.result.message);
            						}
   								});
								win.hide();
								
			}
		},{
			iconCls		:	'trash',
			toolTip		:	deleteRecordToolTipLabel,
			callback	: 	function(grid, record, action, row, col) {
				Ext.Msg.show({
			 		title : deleteRecordTitleMessageLabel,
					msg : deleteRecordMessageLabel,
					icon	:	Ext.Msg.QUESTION,
					buttons	:	Ext.Msg.YESNO,
					scope	:	this,
					fn		:	function(response) {
					if('yes' == response) {
						Ext.Ajax.request({ 
							url		:	'../controller/staffController.php',
							params	:	{	
											method			:	'delete',
											staffId	:	record.data.staffId,
											leafId	:	leafId
										},
							success : function(
																				response,
																				options) {
																			var x = Ext
																					.decode(response.responseText);
																			
																			if (x.success == "true") {
																				title = successLabel;
																			} else {
																				title = failureLabel;
																			}
																			store
																					.reload({
																						params:{
																							leafId:leafId,
																							start:0,
																							limit:per_page
																						}
																						
																					});
																			storeList
																					.reload({
																						params:{
																							leafId:leafId,
																							start:0,
																							limit:per_page
																						}
																						
																					});
																			Ext.MessageBox
																					.alert(
																							title,
																							x.message);
																		},
																		failure : function(response, options) {
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
	   
		var columnModel 	=	[ new Ext.grid.RowNumberer(),this.action,{		
				dataIndex	:	'groupName',
				header		:	groupNameLabel,
				hidden		:	false,
				sortable	: 	true
		},{		
				dataIndex	:	'staffName',
				header		:	staffNameLabel,
				hidden		:	false,
				sortable	: 	true
		},{		
				dataIndex	:	'staffIc',
				header		:	staffIcLabel,
				hidden		:	false,
				sortable	: 	true
		},{		
				dataIndex	:	'staffNo',
				header		:	staffNoLabel,
				hidden		:	false,
				sortable	: 	true
		},{		
				dataIndex	:	'createBy',
				header		:	 createByLabel,
				hidden		:	true,
				sortable	: 	true
		},{		
				dataIndex	:	'createTime',
				header		:	 createTimeLabel,
				hidden		:	true,
				sortable	: 	true,
				renderer    :   function(value) {
			   		return Ext.util.Format.date(value, 'Y-m-d H:i:s');
		        }
		},{		
				dataIndex	:	'updatedBy',
				header		:	 updatedByLabel,
				hidden		:	true,
				sortable	: 	true
		},{		
				dataIndex	:	'updatedTime',
				header		:	updatedTimeLabel,
				hidden		:	true,
				sortable	: 	true,
				renderer    :   function(value) {
			                       return Ext.util.Format.date(value, 'Y-m-d H:i:s');
		                           }
		}];

		 
		var columnModelList 	=	[ new Ext.grid.RowNumberer(),this.actionList,{		
			dataIndex	:	'groupName',
			header		:	groupNameLabel,
			hidden		:	false,
			sortable	: 	true
		},{		
			dataIndex	:	'staffName',
			header		:	staffNameLabel,
			hidden		:	false,
			sortable	: 	true
		},{		
			dataIndex	:	'staffIc',
			header		:	staffIcLabel,
		    hidden		:	false,    
			sortable	: 	true
		},{		
			dataIndex	:	'staffNo',
			header		:	staffNoLabel,
			hidden		:	false,
			sortable	: 	true
		},{		
			dataIndex	:	'createBy',
			header		:	createByLabel,
			hidden		:	true,
			sortable	: 	true
		},{		
			dataIndex	:	'createTime',
			header		:	createTimeLabel,
			sortable	: 	true,
			hidden		: 	true,
			renderer    :   function(value) {
			                       return Ext.util.Format.date(value, 'Y-m-d H:i:s');
		                           }
		},{		
			dataIndex	:	'updatedBy',
			header		:	 updatedByLabel,
			hidden 		: 	true,
			sortable	: 	true
		},{		
			dataIndex	:	'updatedTime',
			header		:	updatedTimeLabel,
			sortable	: 	true,
			hidden 		: 	true,
			renderer    :   function(value) {
				return Ext.util.Format.date(value, 'Y-m-d H:i:s');
		    }
		}];
		
		var grid 			=	new Ext.grid.GridPanel({
			border				:	false,
			store				:	store,
			autoHeight          :   false,
			height				:	400,
			columns				:	columnModel,
			loadMask			: 	true,
			plugins				: 	[this.action,filters],
			sm					: 	new Ext.grid.RowSelectionModel({singleSelect: true}),
			viewConfig			: 	{	
										forceFit			: 	true, 
										emptyText			:	emptyRowLabel 
									},
			iconCls				:	'application_view_detail',
			
			listeners			: 	{
				render			: {
					fn			: function(){
									store.load({
										params	:	{
											start	:	0,
											limit	: 	per_page,
											method	:	'read',
											mode	:	'view',
											plugin	:   [filters]
										}
									});
								}
							}
				},
			bbar				: 	new Ext.PagingToolbar({
				store				:	store,
				pageSize			:	per_page,
				plugins             : [ new Ext.ux.plugins.PageComboResizer()]
			})
		});

		var gridList 			=	new Ext.grid.GridPanel({
			border				:	false,
			store				:	storeList,
			autoHeight          :   false,
			height				:	400,
			columns				:	columnModelList,
			loadMask			: 	true,
			plugins				: 	[this.actionList,filtersList],
			sm					: 	new Ext.grid.RowSelectionModel({singleSelect: true}),
			viewConfig			: 	{	
										forceFit			: 	true, 
										emptyText			:	emptyRowLabel
									},
			iconCls				:	'application_view_detail',
			
			listeners			: 	{
				render			: {
					fn			: function(){
									storeList.load({
										params	:	{
											start	:	0,
											limit	: 	per_page,
											method	:	'read',
											mode	:	'view',
											plugin	:   [filtersList]
										}
									});
								}
							}
				},
			bbar				: 	new Ext.PagingToolbar({
				store				:	storeList,
				pageSize			:	per_page,
				plugins             : [ new Ext.ux.plugins.PageComboResizer()]
			})
		});
	
		var toolbarPanel = new Ext.Toolbar({
				items : [{
					text : reloadToolbarLabel,
					iconCls : 'database_refresh',
					id : 'page_reload',
					disabled : page_reload,
					handler : function() {
						store.reload();
					}
				}, {
					text : addToolbarLabel,
					iconCls : 'add',
					id : 'page_create',
					disabled : page_create,
					handler : function() {
						viewPort.items.get(1).expand();
					}
				}, {
					text : printerToolbarLabel,
					iconCls : 'printer',
					id : 'page_printer',
					disabled : page_print,
					handler : function() {
						Ext.ux.GridPrinter.print(grid);
					}
				}, {
					text : excelToolbarLabel,
					iconCls : 'page_excel',
					id : 'page_excel',
					disabled : page_print,
					handler : function() {
						Ext.Ajax
						.request( {
							url : '../controller/staffController.php?method=report&mode=excel&limit='
								+ per_page
								+ '&leafId='
								+ leafId,
							method : 'GET',
							success : function(response,options) {
								x = Ext.decode(response.responseText);
								if(x.success=='true') {
								
									window.open("../pentabiran/document/excel/staff.xlsx");
								} else{
									Ext.MessageBox.alert(systemErrorLabel,x.message);
								}
									
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
				}]
	});
	var toolbarPanelList = new Ext.Toolbar(
			{
				items : [
						{
							text :reloadToolbarLabel,
							iconCls : 'database_refresh',
							id : 'page_reloadList',
							disabled : page_reloadList,
							handler : function() {
								storeList.reload();
							}
						},
						{
							text : addToolbarLabel,
							iconCls : 'add',
							id : 'page_createList',
							disabled : page_createList,
							handler : function() {
								viewPort.items.get(1).expand();
							}
						},
						{
							text : printerToolbarLabel,
							iconCls : 'printer',
							id : 'printerList',
							disabled : page_printList,
							handler : function() {
								Ext.ux.GridPrinter.print(grid);
							}
						},
						{
							text : excelToolbarLabel,
							iconCls : 'page_excel',
							id : 'page_excelList',
							disabled : page_printList,
							handler : function() {
								Ext.Ajax
								.request( {
									url : '../controller/staffController.php?method=report&mode=excel&limit='
										+ per_page
										+ '&leafId='
										+ leafId,
									method : 'GET',
									success : function(response,options) {
										x = Ext.decode(response.responseText);
										if(x.success=='true') {
										
											window.open("../management/document/excel/staff.xlsx");
										} else{
											Ext.MessageBox.alert(systemErrorLabel,x.message);
										}
											
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
						} ]
			});
		var gridPanel	  	= 	new Ext.Panel ({ 
			title:leafName,
			height:50,
			layout : 'fit',
			iconCls:'application_view_detail',
			tbar : [toolbarPanel ,'->',new Ext.ux.form.SearchField({
                store: store,
                width:320
            })],
            items : [grid]
		});

		var gridPanelList	  	= 	new Ext.Panel ({ 
			autoHeight:true,
			iconCls:'application_view_detail',
			items:[toolbarPanelList,gridList]
		});
		// viewport just save information,items will do separate		
		var groupId  		=	new Ext.ux.form.ComboBoxMatch({ 
			labelAlign			:	'left',
			fieldLabel			:   groupIdLabel,
			name				:  	'groupId',
			hiddenName			:	'groupId',
			valueField			:  	'groupId',
			id					:	'group_fake',
			displayField		:	'groupName',
			typeAhead			: 	false,
        	triggerAction		: 	'all',
			store				: 	group_store,
			anchor      		:	'95%',
			selectOnFocus		:	true,
			mode				:	'local',
			allowBlank			: 	false ,
			blankText			:	blankTextLabel,
			createValueMatcher	: function(value) {
            	value = String(value).replace(/\s*/g, '');
            	if(Ext.isEmpty(value, false)){
                	return new RegExp('^');
            	}
            	value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
            	return new RegExp('\\b(' + value + ')', 'i');
        	}
		});
		var staffName 	= 	new Ext.form.TextField({
			labelAlign  :	'left',
			fieldLabel  :	staffNameLabel,
			hiddenName  :	'staffName',
			name		:	'staffName',
			allowBlank	:	false,
			blankText	:	blankTextLabel,
			style 		: 	{textTransform: "uppercase"},
			anchor      :	'95%'
		});

		var staffIc	= 	new Ext.form.TextField({
			labelAlign  :	'left',
			fieldLabel  :	staffIcLabel,
			hiddenName  :	'staffIc',
			name		:	'staffIc',
			allowBlank	:	false,
			blankText	:	blankTextLabel,
			anchor      :	'95%'
		});
		
		var staffNo	= 	new Ext.form.TextField({
			labelAlign  :	'left',
			fieldLabel  :	staffNoLabel,
			hiddenName  :	'staffNo',
			name		:	'staffNo',
			allowBlank	:	false,
			blankText	:	blankTextLabel,
			anchor      :	'95%'
		});
		
		var staffPassword	= 	new Ext.form.TextField({
			labelAlign  :	'left',
			fieldLabel  :	staffPasswordLabel,
			hiddenName  :	'staffPassword',
			name		:	'staffPassword',
			inputType	:	'password',
			allowBlank	:	false,
			blankText	:	blankTextLabel,
			anchor      :	'95%'
		});

		// hidden id for updated
		var staffId	= 	new Ext.form.Hidden({ name:'staffId' });

		var formPanel 		= 	new Ext.form.FormPanel({
      		id			:	'formPanel',
			url			: 	'../controller/staffController.php',
			method		:  	'post',
			frame       : 	 true,
			title       : 	leafName,
        	border      : 	false,

        	width		: 	600,
			items   	:	[ 
							 	groupId,
								staffId,
								staffName,
								staffIc,
								staffNo,
								staffPassword
							],
			buttonVAlign: 	'top',
			buttonAlign	: 	'left',
			iconCls		:	'application_form',
			bbar		: 	new Ext.ux.StatusBar({
            				  id: 'form-statusbar',

							defaultText	:	'Ready',
            				plugins		: 	new Ext.ux.ValidationStatus({form:'formPanel'})
        	}),
			buttons 	: 	[	{		
							 		text	:	saveButtonLabel,
							 		iconCls	:	'bullet_disk',
							 		handler :	function () { 
										// check groupId field value
									
										if(!(is_int( Ext.getCmp('group_fake').getValue()))) { 
											Ext.getCmp('group_fake').setValue('');
										} else 	{
											if(formPanel.getForm().isValid()) {
											var id =0;
											id  = Ext.getCmp('staffId').getValue();
											var method ;
											if(id.length > 0 ) { 
												method = 'save';
											} else {
												method = 'create';
											}						
											formPanel.getForm().submit({
										waitMsg	:	waitMessageLabel,
										params	:	{ 
														method			:	method,
														leafId	:	leafId 
													}, 
										success	:	function(form,action){
												Ext.MessageBox.alert(title,
																					action.result.message);	
											
												formPanel.getForm().reset();
												store.reload({
													params:{
														leafId:leafId,
														start:0,
														limit:per_page
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
												// here will be error if duplicate code
												    alert(clientInvalidMessageLabel);
												}
												else if (action.failureType === Ext.form.Action.CONNECT_FAILURE){
                                    			    Ext.Msg.alert(connectFailureLabel+form.response.status+' '+form.response.statusText);
                                				}
                                			    else if (action.failureType === Ext.form.Action.SERVER_INVALID){
                                    				Ext.Msg.alert(title, action.result.message);
                                				}
											}
											
											});
										}}
							 }
								},{ 	
									    text 	: resetButtonLabel,
										type	:	'reset',
										iconCls	:	'table_refresh',
										handler	: 	function(){ 
											formPanel.getForm().reset(); 
										} 
								},{ 	
									text 	: 	listButtonLabel,
									type	:	'button',
									iconCls	:'table',
									handler	: 	function(){ 
										//formPanel.getForm().reset();
									     
										var win; 
										win = new Ext.Window({
											items:[gridPanelList],
											closeAction:'hide',
											maximizable:true,
											title:leafName,
											layout:'fit',
							                width:500,
							                autoScroll : true
							                });
										win.show(this);
									} 
								}]
		}); 
		
		
		var viewPort		=	new Ext.Viewport({
			id				:	'viewport',
			region			:	'center',
			layout			:	'accordion',
			layoutConfig	: 	{
        		// layout-specific configs go here
        		titleCollapse	: true,
        		animate			: false,
        		activeOnTop		: true
    		},
			items	:	[gridPanel,formPanel]
		});
	
	});
