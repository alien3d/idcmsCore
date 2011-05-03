Ext
		.onReady(function() {
			Ext.QuickTips.init();
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
			Ext.BLANK_IMAGE_URL = '../javascript/resources/images/s.gif';
			var per_page = 10;
			var encode = false;
			var local = false;
			var store = new Ext.data.JsonStore({
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
					name : 'log_error',
					type : 'string'
				} ]
			});

			var storeList = new Ext.data.JsonStore({
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
					name : 'log_error',
					type : 'string'
				} ]
			});

			var staff_reader = new Ext.data.JsonReader({
				root : 'staff',
				id : 'staffId'
			}, [ 'staffId', 'staffName' ]);

			var staff_store = new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : 'logData.php?method=read&field=staffId&leafId='+leafId,
					method : 'GET',
					listeners : {
						exception : function(DataProxy, type, action, options,
								response, arg) {
							var serverMessage = Ext.util.JSON
									.decode(response.responseText);
							if (serverMessage.success == false) {
								Ext.MessageBox.alert(systemErrorLabel,
										serverMessage.message);
							}
						}
					}
				}),
				reader : staff_reader,
				remoteSort : false
			});

			var filters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : false,
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
					dataIndex : 'log_error',
					column : 'log_error',
					table : 'log'
				} ]
			});

			var filtersList = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : false,
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
					dataIndex : 'log_error',
					column : 'log_error',
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

			this.actionList = new Ext.ux.grid.RowActions({
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
						win.hide();
					}
				} ]
			});

			var columnModel = [ new Ext.grid.RowNumberer(), this.action, {
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
				dataIndex : 'log_error',
				header : log_errorLabel,
				sortable : true,
				hidden : false
			} ];

			var columnModelList = [ new Ext.grid.RowNumberer(), this.action, {
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
				dataIndex : 'log_error',
				header : log_errorLabel,
				sortable : true,
				hidden : false
			} ];

			var grid = new Ext.grid.GridPanel({
				border : false,
				store : store,
				autoHeight : false,
				height : 400,
				columns : columnModel,
				loadMask : true,
				plugins : [ this.action, filters ],
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
									limit : per_page,
									method : 'read',
									mode : 'view',
									plugin : [ filters ]
								}
							});
						}
					}
				},
				bbar : new Ext.PagingToolbar({
					store : store,
					pageSize : per_page,
					plugins : [ new Ext.ux.plugins.PageComboResizer() ]
				})
			});

			var gridList = new Ext.grid.GridPanel({
				border : false,
				store : storeList,
				autoHeight : false,
				columns : columnModelList,
				loadMask : true,
				plugins : [ this.actionList, filtersList ],
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
							storeList.load({
								params : {
									start : 0,
									limit : per_page,
									method : 'read',
									mode : 'view',
									plugin : [ filtersList ]
								}
							});
						}
					}
				},
				bbar : new Ext.PagingToolbar({
					store : storeList,
					pageSize : per_page,
					plugins : [ new Ext.ux.plugins.PageComboResizer() ]
				})
			});

			var toolbarPanel = new Ext.Toolbar(
					{
						items : [
								{
									text : reloadToolbarLabel,
									iconCls : 'database_refresh',
									id : 'page_reload',
									disabled : page_reload,
									handler : function() {
										store.reload();
									}
								},
								{
									text : printerToolbarLabel,
									iconCls : 'printer',
									id : 'page_printer',
									disabled : page_print,
									handler : function() {
										Ext.ux.GridPrinter.print(grid);
									}
								},
								{
									text : excelToolbarLabel,
									iconCls : 'page_excel',
									id : 'page_excel',
									disabled : page_print,
									handler : function() {
										Ext.Ajax
												.request({
													url : 'logData.php?method=report&mode=excel&limit='
															+ per_page
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == 'true') {

															window
																	.open("../security/document/excel/log.xlsx");
														} else {
															Ext.MessageBox
																	.alert(
																			'SYSTEM',
																			x.message);
														}

													},
													failure : function(
															response, options) {
														status_code = response.status;
														status_message = response.statusText;
														Ext.MessageBox
																.alert(
																		'system',
																		escape(status_code)
																				+ ":"
																				+ status_message);
													}

												});
									}
								} ]
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
									text : excelToolbarLabel,
									iconCls : 'page_excel',
									id : 'page_excelList',
									disabled : page_printList,
									handler : function() {
										Ext.Ajax
												.request({
													url : 'logData.php?method=report&mode=excel&limit='
															+ per_page
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == 'true') {
															// Ext.MessageBox.alert('SYSTEM',x.message);
															window
																	.open("../security/document/excel/log.xlsx");
														} else {
															Ext.MessageBox
																	.alert(
																			'SYSTEM',
																			x.message);
														}

													},
													failure : function(
															response, options) {
														status_code = response.status;
														status_message = response.statusText;
														Ext.MessageBox
																.alert(
																		'system',
																		escape(status_code)
																				+ ":"
																				+ status_message);
													}

												});
									}
								} ]
					});

			var gridPanel = new Ext.Panel({
				title : leafName,
				height : 50,
				layout : 'fit',
				iconCls : 'application_view_detail',
				tbar : [ toolbarPanel, '->', new Ext.ux.form.SearchField({
					store : store,
					width : 320
				}) ],
				items : [ grid ]
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

			var log_error = new Ext.form.TextArea({
				labelAlign : 'left',
				fieldLabel : log_errorLabel,
				hiddenName : 'log_error',
				style : 'height: 35%',
				name : 'log_error',
				allowBlank : true,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			var formPanel = new Ext.form.FormPanel(
					{
						url : 'logData.php',
						id : 'formPanel',
						method : 'post',
						frame : true,
						title : leafName,
						border : false,
						width : 600,
						bodyStyle : 'padding:5px',
						items : [

						logId,

						sql,

						operation,

						access,

						log_error

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
									text : listButtonLabel,
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
								} ]
					});

			var win = new Ext.Window({
				tbar : toolbarPanelList,
				items : [ gridList ],
				title : leafName,
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
