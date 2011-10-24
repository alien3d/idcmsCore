Ext
		.onReady(function() {
			Ext.QuickTips.init();
			Ext.BLANK_IMAGE_URL = "../../javascript/resources/images/s.gif";
			Ext.form.Field.prototype.msgTarget = "under";
			Ext.Ajax.timeout = 90000;
			
			var pageCreate;
			var pageReload;
			var pagePrint;;
			var perPage = 15;
			var encode = false;
			var local = false;
			var jsonResponse;
			var duplicate = 0;
			
			if (leafAccessCreateValue == 1) {
				pageCreate = false;
			} else {
				pageCreate = true;
			}
			if (leafAccessReadValue == 1) {
				pageReload = false;
			} else {
				pageReload = true;
			}
			if (leafAccessPrintValue == 1) {
				pagePrint = false;
			} else {
				pagePrint = true;
			}
			
			
			var logStore = new Ext.data.JsonStore({
				autoDestroy : true,
				url : '../controller/logController.php',
				remoteSort : true,
				root : 'data',
				totalProperty : 'total',
				baseParams : {
					method : 'read',
					mode : 'view',
					leafId : leafId
				},
				fields : [ {
					name : 'logId',
					type : 'int'
				}, {
					name : 'leafId',
					type : 'int'
				}, {
					name : 'operation',
					type : 'string'
				}, {
					name : 'sql',
					type : 'string'
				}, {
					name : 'date',
					type : 'date',
					dateFormat : 'Y-m-d'
				}, {
					name : 'staffId',
					type : 'int'
				}, {
					name : 'access',
					type : 'string'
				}, {
					name : 'logError',
					type : 'string'
				} ]
			});

			

			var staffByProxy = new Ext.data.HttpProxy({
				url : "../controller/departmentController.php?",
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
			var staffByReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "staffId"
			});
			var staffByStore = new Ext.data.JsonStore({
				proxy : staffByProxy,
				reader : staffByReader,
				autoLoad : true,
				autoDestroy : true,
				baseParams : {
					method : 'read',
					field : 'staffId',
					leafId : leafId
				},
				root : 'staff',
				fields : [ {
					name : "staffId",
					type : "int"
				}, {
					name : "staffName",
					type : "string"
				} ]
			});

			var logFilters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : local,
				filters : [

				{
					type : 'numeric',
					dataIndex : 'logId',
					column : 'logId',
					table : 'log'
				},

				{
					type : 'numeric',
					dataIndex : 'leafId',
					column : 'leafId',
					table : 'log'
				},

				{
					type : 'string',
					dataIndex : 'operation',
					column : 'operation',
					table : 'log'
				},

				{
					type : 'string',
					dataIndex : 'sql',
					column : 'sql',
					table : 'log'
				},

				{
					type : 'date',
					dataIndex : 'date',
					column : 'date',
					table : 'log'
				},

				{
					type : 'numeric',
					dataIndex : 'staffId',
					column : 'staffId',
					table : 'log'
				},

				{
					type : 'string',
					dataIndex : 'access',
					column : 'access',
					table : 'log'
				},

				{
					type : 'string',
					dataIndex : 'logError',
					column : 'logError',
					table : 'log'
				} ]
			});

			
			this.action = new Ext.ux.grid.RowActions({
				header : actionLabel,
				bodyStyle : 'padding:5px',
				dataIndex : 'logId',
				actions : [ {
					iconCls : 'application_edit',
					tooltip : updateRecordToolTipLabel,
					callback : function(grid, record, action, row, col) {

						formPanel.getForm().reset();
						formPanel.form.load({
							url : 'logData.php',
							method : 'POST',
							waitMsg : waitMessageLabel,
							params : {
								method : 'read',
								mode : 'update',
								logId : record.data.logId,
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
				} ]
			});

			

			var logColumnModel = [ new Ext.grid.RowNumberer(), this.action, {
				dataIndex : 'logId',
				header : logIdLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'leafId',
				header : leafIdLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'operation',
				header : operationLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'sql',
				header : sqlLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'date',
				header : dateLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'staffId',
				header : staffIdLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'access',
				header : accessLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'logError',
				header : logErrorLabel,
				sortable : true,
				hidden : false
			} ];

			
			var grid = new Ext.grid.GridPanel({
				border : false,
				store : logStore,
				autoHeight : false,
				height : 400,
				columns : columnModel,
				loadMask : true,
				plugins : [ this.action, logFilters ],
				sm : new Ext.grid.RowSelectionModel({
					singleSelect : true
				}),
				viewConfig : {
					forceFit : true,
					emptyText : emptyRowLabel
				},
				iconCls : 'application_view_detail',
				listeners : {
					render : {
						fn : function() {
							store.load({
								params : {
									start : 0,
									limit : perPage,
									method : 'read',
									mode : 'view',
									plugin : [ logFilters ]
								}
							});
						}
					}
				},
				bbar : new Ext.PagingToolbar({
					store : store,
					pageSize : perPage,
					plugins : [ new Ext.ux.plugins.PageComboResizer() ]
				})
			});

			

			var toolbarPanel = new Ext.Toolbar(
					{
						items : [
								{
									text : reloadToolbarLabel,
									iconCls : 'database_refresh',
									id : 'pageReload',
									disabled : pageReload,
									handler : function() {
										store.reload();
									}
								},
								{
									text : printerToolbarLabel,
									iconCls : 'printer',
									id : 'pagePrinter',
									disabled : pagePrint,
									handler : function() {
										Ext.ux.GridPrinter.print(grid);
									}
								},
								{
									text : excelToolbarLabel,
									iconCls : 'page_excel',
									id : 'page_excel',
									disabled : pagePrint,
									handler : function() {
										Ext.Ajax
												.request({
													url : 'logData.php?method=report&mode=excel&limit='
															+ perPage
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														jsonResponse = Ext.decode(response.responseText);
														if (jsonResponse == true) {

															window
																	.open("../security/document/excel/log.xlsx");
														} else {
															Ext.MessageBox
																	.alert(
																			systemLabel,
																			jsonResponse.message);
														}

													},
													failure : function(
															response, options) {
														status_code = response.status;
														status_message = response.statusText;
														Ext.MessageBox.alert(systemLabel,
																		escape(status_code)
																				+ ":"
																				+ status_message);
													}

												});
									}
								} ]
					});

			

			var gridPanel = new Ext.Panel({
				title : leafEnglish,
				height : 50,
				layout : 'fit',
				iconCls : 'application_view_detail',
				tbar : [ toolbarPanel, '->', new Ext.ux.form.SearchField({
					store : store,
					width : 320
				}) ],
				items : [ logGrid ]
			});

			var logId = new Ext.form.Hidden({
				name : 'logId'
			});

			var sql = new Ext.form.TextArea({
				labelAlign : 'left',
				fieldLabel : sqlLabel,
				hiddenName : 'sql',
				style : 'height: 50%',
				name : 'sql',
				anchor : '95%'
			});

			var operation = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : operationLabel,
				hiddenName : 'operation',
				name : 'operation',
				allowBlank : false,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			var access = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : accessLabel,
				hiddenName : 'access',
				name : 'access',
				allowBlank : false,
				blankText : blankTextLabel,
				vtype : 'alpha',
				anchor : '95%'
			});

			var logError = new Ext.form.TextArea({
				labelAlign : 'left',
				fieldLabel : logErrorLabel,
				hiddenName : 'logError',
				style : 'height: 35%',
				name : 'logError',
				allowBlank : true,
				blankText : blankTextLabel,
				anchor : '95%'
			});
			
			var firstRecord = new Ext.form.Hidden({
				name : 'firstRecord',
				id : 'firstRecord'
			});

			var nextRecord = new Ext.form.Hidden({
				name : 'nextRecord',
				id : 'nextRecord'
			});

			var previousRecord = new Ext.form.Hidden({
				name : 'previousRecord',
				id : 'previousRecord'
			});
			var lastRecord = new Ext.form.Hidden({
				name : 'lastRecord',
				id : 'lastRecord'
			});

			var formPanel = new Ext.form.FormPanel(
					{
						url : 'logData.php',
						name :'formPanel',
						id : 'formPanel',
						method : 'post',
						frame : true,
						title : leafEnglish,
						border : false,
						width : 600,
						bodyStyle : 'padding:5px',
						items : [

						logId,

						sql,

						operation,

						access,

						logError

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
						buttons : [
								{
									text : saveButtonLabel,
									iconCls : 'bullet_disk',
									handler : function() {
										if (formPanel.getForm().isValid()) {
											formPanel
													.getForm()
													.submit(
															{
																waitMsg : waitMessageLabel,
																params : {
																	method : 'save',
																	leafId : leafId
																},
																success : function(
																		form,
																		action) {
																	Ext.MessageBox
																			.alert(
																					'Message',
																					'Data have been saved');
																	formPanel
																			.getForm()
																			.reset();
																	store
																			.reload();
																},
																failure : function(
																		form,
																		action) {
																	var title = 'Message Failure';
																	if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																		alert("Client ada Error 1 ");
																	} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
																		// here
																		// will
																		// be
																		// error
																		// if
																		// duplicate
																		// code
																		alert("Client ada Error 2");
																	} else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
																		Ext.Msg
																				.alert(
																						'Failure',
																						'Server reported:'
																								+ form.response.status
																								+ ' '
																								+ form.response.statusText);
																	} else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
																		Ext.Msg
																				.alert(
																						title,
																						action.result.message);
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
									text : gridButtonLabel, type : 'button',
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
								} ]
					});

			var win = new Ext.Window({
				tbar : toolbarPanelList,
				items : [ gridList ],
				title : leafEnglish,
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
				items : [ gridPanel, formPanel ]
			});
		});
