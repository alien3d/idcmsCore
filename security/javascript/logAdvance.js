Ext.onReady(function() {
    Ext.QuickTips.init();
	Ext.form.Field.prototype.msgTarget = 'under';
	var page_create;
	var page_createList;
	var page_reload;
	var page_reloadList;
	var page_print;
	var page_printList;
	if (leafCreateAccessValue == 1) {
		var page_create = false;
	} else {
		var page_create = true;
	}
	if (leafReadAccessValue == 1) {
		var page_reload = false;
	} else {
		var page_reload = true;
	}
	if (leafPrintAccessValue == 1) {
		var page_print = false;
	} else {
		var page_print = true;
	}
	Ext.BLANK_IMAGE_URL = '../javascript/resources/images/s.gif';
	var per_page = 10;
	var encode = false;
	var local = false;
	var store = new Ext.data.JsonStore({
				autoDestroy : true,
				url : '../controller/logAdvanceController.php',
				remoteSort : true,
				root : 'data',
				totalProperty : 'total',
				baseParams : {
					method : 'read',
					mode : 'view',
					leafId : leafId
				},
				fields: [
				{name : 'log_advance_uniqueId',
                 type : 'int'				
				},{
				 name : 'log_advance_text',
				 type : 'string'
				},{
				 name : 'log_advance_type',
				 type : 'string'
				},{
				 name : 'log_advance_comparison',
				 type : 'string'
				},{
				 name : 'ref_uniqueId',
				 type : 'int'
				},{
				 name : 'createBy',
				 type : 'int'
				},{
				 name : 'createTime',
				 type : 'date',
				 dateFormat : 'Y-m-d H:i:s'
				},{
				 name : 'updatedBy',
				 type : 'int'
				},{
				 name : 'updatedTime',
				 type : 'date',
				 dateFormat : 'Y-m-d H:i:s'
				}]
	 });
	 
	var storeList = new Ext.data.JsonStore({
				autoDestroy : true,
				url : '../controller/logAdvanceController.php',
				remoteSort : true,
				root : 'data',
				totalProperty : 'total',
				baseParams : {
					method : 'read',
					mode : 'view',
					leafId : leafId
				},
				fields: [
				{name : 'log_advance_uniqueId',
                 type : 'int'				
				},{
				 name : 'log_advance_text',
				 type : 'string'
				},{
				 name : 'log_advance_type',
				 type : 'string'
				},{
				 name : 'log_advance_comparison',
				 type : 'string'
				},{
				 name : 'ref_uniqueId',
				 type : 'int'
				},{
				 name : 'createBy',
				 type : 'int'
				},{
				 name : 'createTime',
				 type : 'date',
				 dateFormat : 'Y-m-d H:i:s'
				},{
				 name : 'updatedBy',
				 type : 'int'
				},{
				 name : 'updatedTime',
				 type : 'date',
				 dateFormat : 'Y-m-d H:i:s'
				}]
	 });
	var staff_reader = new Ext.data.JsonReader({
				root : 'staff',
				id : 'staffId'
			}, ['staffId', 'staffName']);
	var staff_store = new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
				url : '../controller/logAdvanceController.php?method=read&field=staffId',
                                                                method : 'GET'
						}),
				reader : staff_reader,
				remoteSort : false
			});
			
	var filters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : false,
				filters: [
	
				{type : 'numeric',
				dataIndex : 'log_advance_uniqueId',
				column : 'log_advance_uniqueId',
				table : 'log_advance'},
	
				{type : 'string',
				dataIndex : 'log_advance_text',
				column : 'log_advance_text',
				table : 'log_advance'},
	
				{type : 'string',
				dataIndex : 'log_advance_type',
				column : 'log_advance_type',
				table : 'log_advance'},
	
				{type : 'string',
				dataIndex : 'log_advance_comparison',
				column : 'log_advance_comparison',
				table : 'log_advance'},
	
				{type : 'numeric',
				dataIndex : 'ref_uniqueId',
				column : 'ref_uniqueId',
				table : 'log_advance'},
	
				{type : 'list',
				dataIndex : 'createBy',
				column : 'createBy',
				table : 'log_advance',
				labelField : 'staffName',
				store : staff_store,
				phpMode : true},
	
				{type : 'date',
				dataIndex : 'createTime',
				column : 'createTime',
				table : 'log_advance'},
	
				{type : 'list',
				dataIndex : 'updatedBy',
				column : 'updatedBy',
				table : 'log_advance',
				labelField : 'staffName',
				store : staff_store,
				phpMode : true},
	
				{type : 'date',
				dataIndex : 'updatedTime',
				column : 'updatedTime',
				table : 'log_advance'}]
	 });

	var filtersList = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : false,
				filters: [
	
				{type : 'numeric',
				dataIndex : 'log_advance_uniqueId',
				column : 'log_advance_uniqueId',
				table : 'log_advance'},
	
				{type : 'string',
				dataIndex : 'log_advance_text',
				column : 'log_advance_text',
				table : 'log_advance'},
	
				{type : 'string',
				dataIndex : 'log_advance_type',
				column : 'log_advance_type',
				table : 'log_advance'},
	
				{type : 'string',
				dataIndex : 'log_advance_comparison',
				column : 'log_advance_comparison',
				table : 'log_advance'},
	
				{type : 'numeric',
				dataIndex : 'ref_uniqueId',
				column : 'ref_uniqueId',
				table : 'log_advance'},
	
				{type : 'list',
				dataIndex : 'createBy',
				column : 'createBy',
				table : 'log_advance',
				labelField : 'staffName',
				store : staff_store,
				phpMode : true},
	
				{type : 'date',
				dataIndex : 'createTime',
				column : 'createTime',
				table : 'log_advance'},
	
				{type : 'list',
				dataIndex : 'updatedBy',
				column : 'updatedBy',
				table : 'log_advance',
				labelField : 'staffName',
				store : staff_store,
				phpMode : true},
	
				{type : 'date',
				dataIndex : 'updatedTime',
				column : 'updatedTime',
				table : 'log_advance'}]
	 });
	 
	this.action = new Ext.ux.grid.RowActions({
			header : actionLabel,
 			dataIndex : 'log_advance_uniqueId',
                actions : [{
			iconCls : 'application_edit',
			tooltip : updateRecordToolTipLabel,
			callback : function(grid, record, action, row, col) {
				//Ext.MessageBox.alert('message', 'This is for update button');
				formPanel.getForm().reset();
				formPanel.form.load({
				url : '../controller/logAdvanceController.php',
							method : 'POST',
							waitMsg : waitMessageLabel,
							params : {
								method : 'read',
								mode : 'update',
				                                                log_advance_uniqueId : record.data.log_advance_uniqueId,
								leafId : leafId
							},
							success : function(form, action) {
								viewPort.items.get(1).expand();
							},
							failure : function(action) {
								Ext.MessageBox.alert('Message',
										'Load failed.grid');
							}
						});
			}
		}]
	});

	this.actionList = new Ext.ux.grid.RowActions({
			header : actionLabel,
 			dataIndex : 'log_advance_uniqueId',
                actions : [{
			iconCls : 'application_edit',
			tooltip :  updateRecordToolTipLabel,
			callback : function(grid, record, action, row, col) {
				//Ext.MessageBox.alert('message', 'This is for update button');
				formPanel.getForm().reset();
				formPanel.form.load({
				url : '../controller/logAdvanceController.php',
							method : 'POST',
							waitMsg : waitMessageLabel,
							params : {
								method : 'read',
								mode : 'update',
				                log_advance_uniqueId : record.data.log_advance_uniqueId,
								leafId : leafId
							},
							success : function(form, action) {
								viewPort.items.get(1).expand();
							},
							failure : function(action) {
								Ext.MessageBox.alert('Message',
										'Load failed.grid');
							}
						});
						win.hide();
			}
		}]
	});

				var columnModel = [new Ext.grid.RowNumberer(), this.action,
					{dataIndex : 'log_advance_uniqueId',
					header : log_advance_uniqueIdLabel,
					sortable : true,
					hidden : false},
					
					{dataIndex : 'log_advance_text',
					header : log_advance_textLabel,
					sortable : true,
					hidden : false},
					
					{dataIndex : 'log_advance_type',
					header : log_advance_typeLabel,
					sortable : true,
					hidden : false},
					
					{dataIndex : 'log_advance_comparison',
					header : log_advance_comparisonLabel,
					sortable : true,
					hidden : false},
					
					{dataIndex : 'ref_uniqueId',
					header : ref_uniqueIdLabel,
					sortable : true,
					hidden : false},
					
					{dataIndex : 'createBy',
					header : createByLabel,
					sortable : true,
					hidden : true},
					
					{dataIndex : 'createTime',
					header : createTimeLabel,
					sortable : true,
					hidden : true},
					
					{dataIndex : 'updatedBy',
					header : updatedByLabel,
					sortable : true,
					hidden : true},
					
					{dataIndex : 'updatedTime',
					header : updatedTimeLabel,
					sortable : true,
					hidden : true}];
					
				var columnModelList = [new Ext.grid.RowNumberer(), this.action,
					{dataIndex : 'log_advance_uniqueId',
					header : log_advance_uniqueIdLabel,
					sortable : true,
					hidden : false},
					
					{dataIndex : 'log_advance_text',
					header : log_advance_textLabel,
					sortable : true,
					hidden : false},
					
					{dataIndex : 'log_advance_type',
					header : log_advance_typeLabel,
					sortable : true,
					hidden : false},
					
					{dataIndex : 'log_advance_comparison',
					header : log_advance_comparisonLabel,
					sortable : true,
					hidden : false},
					
					{dataIndex : 'ref_uniqueId',
					header : ref_uniqueIdLabel,
					sortable : true,
					hidden : false},
					
					{dataIndex : 'createBy',
					header : createByLabel,
					sortable : true,
					hidden : true},
					
					{dataIndex : 'createTime',
					header : createTimeLabel,
					sortable : true,
					hidden : true},
					
					{dataIndex : 'updatedBy',
					header : updatedByLabel,
					sortable : true,
					hidden : true},
					
					{dataIndex : 'updatedTime',
					header : updatedTimeLabel,
					sortable : true,
					hidden : true}];
					
	var grid = new Ext.grid.GridPanel({
				border : false,
				store : store,
				autoHeight : false,
				height : 400,
				columns : columnModel,
				loadMask : true,
				plugins : [this.action, filters],
				sm : new Ext.grid.RowSelectionModel({
							singleSelect : true
						}),
				viewConfig : {
					forceFit : true,
					emptyText : 'No rows to display'
				},
				iconCls : 'application_view_detail',
				listeners : {
					render : {
						fn : function() {
							store.load({
										params : {
											start : 0,
											limit : per_page,
											method : 'read',
											mode : 'view',
											plugin : [filters]
										}
									});
						}
					}
				},
				bbar : new Ext.PagingToolbar({
							store : store,
							pageSize : per_page,
							plugins : [new Ext.ux.plugins.PageComboResizer()]
						})
			});
	var gridList = new Ext.grid.GridPanel({
				border : false,
				store : storeList,
				autoHeight : false,
				columns : columnModelList,
				loadMask : true,
				plugins : [this.actionList, filtersList],
				sm : new Ext.grid.RowSelectionModel({
							singleSelect : true
						}),
				viewConfig : {
					forceFit : true,
					emptyText : 'No rows to display'
				},
				iconCls : 'application_view_detail',
				listeners : {
					render : {
						fn : function() {
							storeList.load({
										params : {
											start : 0,
											limit : per_page,
											method : 'read',
											mode : 'view',
											plugin : [filtersList]
										}
									});
						}
					}
				},
				bbar : new Ext.PagingToolbar({
							store : storeList,
							pageSize : per_page,
							plugins : [new Ext.ux.plugins.PageComboResizer()]
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
					text : printerToolbarLabel,
					iconCls : 'printer',
					id : 'page_printer',
					disabled : page_print,
					handler : function() {
						Ext.ux.GridPrinter.print(grid);
					}
				}, {
					text :  excelToolbarLabel,
					iconCls : 'page_excel',
					id : 'page_excel',
					disabled : page_print,
					handler : function() {
						Ext.Ajax
						.request( {
							url : '../controller/logAdvanceController.php?method=report&mode=excel&limit='
								+ per_page
								+ '&leafId='
								+ leafId,
							method : 'GET',
							success : function(response,options) {
								x = Ext.decode(response.responseText);
								if(x.success=='true') {
								//	Ext.MessageBox.alert('SYSTEM',x.message);
									window.open("../security/document/excel/log_advance.xlsx");
								} else{
									Ext.MessageBox.alert('SYSTEM',x.message);
								}
									
							},
							failure : function(response, options) 
							{
								status_code = response.status;
								status_message = response.statusText;
								Ext.MessageBox.alert('system',escape(status_code)
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
							text : reloadToolbarLabel,
							iconCls : 'database_refresh',
							id : 'page_reloadList',
							disabled : page_reloadList,
							handler : function() {
								storeList.reload();
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
							text : wordToolbarLabel,
							iconCls : 'page_word',
							id : 'page_wordList',
							disabled : page_printList,
							handler : function() {
								Ext.Ajax
								.request( {
									url : '../controller/logAdvanceController.php?method=report&mode=word&limit='
										+ per_page
										+ '&leafId='
										+ leafId,
									method : 'GET',
									success : function(response,options) {
										x = Ext.decode(response.responseText);
										if(x.success=='true') {
										//	Ext.MessageBox.alert('SYSTEM',x.message);
											window.open("../security/document/word/log_advance.docx");
										} else{
											Ext.MessageBox.alert('SYSTEM',x.message);
										}
											
									},
									failure : function(response, options) 
									{
										status_code = response.status;
										status_message = response.statusText;
										Ext.MessageBox.alert('system',escape(status_code)
										+ ":"+ status_message);
									}
										
								});
							}
						},
						{
							text :  excelToolbarLabel,
							iconCls : 'page_excel',
							id : 'page_excelList',
							disabled : page_printList,
							handler : function() {
								Ext.Ajax
								.request( {
									url : '../controller/logAdvanceController.php?method=report&mode=excel&limit='
										+ per_page
										+ '&leafId='
										+ leafId,
									method : 'GET',
									success : function(response,options) {
										x = Ext.decode(response.responseText);
										if(x.success=='true') {
										//	Ext.MessageBox.alert('SYSTEM',x.message);
											window.open("../security/document/excel/log_advance.xlsx");
										} else{
											Ext.MessageBox.alert('SYSTEM',x.message);
										}
											
									},
									failure : function(response, options) 
									{
										status_code = response.status;
										status_message = response.statusText;
										Ext.MessageBox.alert('system',escape(status_code)
										+ ":"+ status_message);
									}
										
								});
							}
						},
						{
							text : PDFToolbarLabel,
							iconCls : 'page_white_acrobat',
							id : 'page_white_acrobatList',
							disabled : page_print,
							handler : function() {
								window.location
										.replace('../controller/logAdvanceController.php?method=report&mode=pdf&limit='
												+ per_page
												+ '&leafId='
												+ leafId);
							}
						} ]
			});

	        var gridPanel = new Ext.Panel({
				title :  leafName,
				height : 50,
				layout : 'fit',
				iconCls : 'application_view_detail',
				tbar : [toolbarPanel],
                items : [grid]
			});

                var log_advance_uniqueId = new Ext.form.Hidden({
				name : 'log_advance_uniqueId'
				});
				
                var log_advance_text         = new Ext.form.TextArea({
				         labelAlign : 'left',
				         fieldLabel : log_advance_text_view_Label,
				         hiddenName : 'log_advance_text',
						 style: 'height: 20%',
				         name : 'log_advance_text',
				         anchor : '95%'
				    });
				
		      	var log_advance_type = new Ext.form.TextField({
						labelAlign  :	'left',
			            fieldLabel  :	log_advance_type_Label,
			            hiddenName  :	'log_advance_type',
			            name		:	'log_advance_type',
						vtype       :   'alpha',
						allowBlank : false,
						blankText :  blankTextLabel,
			            anchor      :	'95%'
					});
				
                var log_advance_comparison = new Ext.form.TextArea({
				       labelAlign : 'left',
				       fieldLabel : 'log advance comparison view',
				       hiddenName : 'log_advance_comparison',
					   style: 'height: 60%',
			       	   name : 'log_advance_comparison',
				       anchor : '95%'
				    });
					
			    var ref_uniqueId = new Ext.form.NumberField(
					{
						labelAlign  :	'left',
			            fieldLabel  :	ref_uniqueId_Label,
			            hiddenName  :	'ref_uniqueId',
			            name		:	'ref_uniqueId',
						allowBlank  :  false,
						blankText   :  blankTextLabel,
			            anchor      :	'95%'
					});
 
	var formPanel = new Ext.form.FormPanel({
				url : '../controller/logAdvanceController.php',
                id : 'formPanel',
				method : 'post',
				frame : true,
				title :  leafName,
				border : false,
				width : 600,
				bodyStyle : 'padding:5px',
				items : [
 
	
				log_advance_uniqueId, 
	
				log_advance_text, 
	
				log_advance_type, 
	
				log_advance_comparison, 
	
				ref_uniqueId, 

				],
				buttonVAlign : 'top',
				buttonAlign : 'left',
				iconCls : 'application_form',
				bbar : new Ext.ux.StatusBar({
							id : 'form-statusbar',
							defaultText : 'Ready',
							plugins : new Ext.ux.ValidationStatus({
										form : 'formPanel'
									})
						}),
				buttons : [{
					text : saveButtonLabel,
					iconCls : 'bullet_disk',
					handler : function() {
						if (formPanel.getForm().isValid()) {
							formPanel.getForm().submit({
								waitMsg : waitMessageLabel,
								params : {
									method : 'save',
									leafId : leafId
								},
								success : function(form, action) {
									Ext.MessageBox.alert('Message',
											'Data have been saved');
									formPanel.getForm().reset();
									store.reload();
								},
								failure : function(form, action) {
									var title='Message Failure';
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
						}
					}
				}, {
					text : resetButtonLabel,
					type : 'reset',
					iconCls : 'table_refresh',
					handler : function() {
						formPanel.getForm().reset();
					}
				}, {
					text :  listButtonLabel,
					type : 'button',
					iconCls : 'table',
					handler : function() {
						if (win) {
							win.show().center();
						}
					}
				}, {
					text : cancelButtonLabel,
					type : 'button',
					iconCls : 'delete',
					handler : function() {
						if (win) {
							win.hide();
						}
						formPanel.getForm().reset();
						store.reload();
						viewPort.items.get(0).expand();
					}
				}]
			});

	var win = new Ext.Window({
				tbar : toolbarPanelList,
				items : [gridList],
				title :  leafName,
				closeAction : 'hide',
				maximizable : true,
				layout : 'fit',
				width : 500,
				autoScroll : true
			});

	var viewPort = new Ext.Viewport({
				id : 'viewport',
				region : 'center',
				layout : 'accordion',
				layoutConfig : {
					titleCollapse : true,
					animate : false,
					activeOnTop : true
				},
				items : [gridPanel, formPanel]
			});
});
