Ext
		.onReady(function() {
			Ext.QuickTips.init();
			Ext.form.Field.prototype.msgTarget = "under";
			 Ext.Ajax.timeout = 90000;
			var page_create;
			var page_createList;
			var page_reload;
			var page_reloadList;
			var page_print;
			var page_printList;
			var duplicate = 0;
			if (leafReadAccessValue == 1) {
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
			Ext.BLANK_IMAGE_URL = "../../javascript/resources/images/s.gif";
			var per_page = 15;
			var encode = false;
			var local = false;
			
			

			var store = new Ext.data.JsonStore({
				autoDestroy : true,
				proxy: new Ext.data.HttpProxy(
								{
									url : "../controller/religionController.php",
									method : "POST",
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
				remoteSort : true,
				root : "data",
				totalProperty : "total",
				baseParams : {
					method : "read",
					mode : "view",
					leafId : leafId
				},
				fields : [ {
					name : "religionId",
					type : "int"
				}, {
					name : "religionDesc",
					type : "string"
				}, {
					name : "By",
					type : "int"
				}, {
					name : "Time",
					type : "date",
					dateFormat : "Y-m-d H:i:s"
				} ],
				listeners : {
					exception : function(DataProxy, type, action, options,
							response, arg) {
						var serverMessage = Ext.util.JSON
								.decode(response.responseText);
						if (serverMessage.success == false
								) {
							Ext.MessageBox
									.alert(systemErrorLabel, serverMessage.message);
						}
					}
				}
			});
			var storeList = new Ext.data.JsonStore({
				autoDestroy : true,
				url : "../controller/religionController.php",
				remoteSort : true,
				root : "data",
				totalProperty : "total",
				baseParams : {
					method : "read",
					mode : "view",
					leafId : leafId
				},
				fields : [ {
					name : "religionId",
					type : "int"
				}, {
					name : "religionDesc",
					type : "string"
				}, {
					name : "By",
					type : "int"
				}, {
					name : "Time",
					type : "date",
					dateFormat : "Y-m-d H:i:s"
				} ],
				listeners : {
					exception : function(DataProxy, type, action, options,
							response, arg) {
						var serverMessage = Ext.util.JSON
								.decode(response.responseText);
						if (serverMessage.success == false
								) {
							Ext.MessageBox
									.alert(systemErrorLabel, serverMessage.message);
						}
					}
				}
			});
			var staff_reader = new Ext.data.JsonReader({
				root : "staff",
				id : "staffId"
			}, [ "staffId", "staffName" ]);
			var staff_store = new Ext.data.Store(
					{
						proxy : new Ext.data.HttpProxy(
								{
									url : "../controller/religionController.php?method=read&field=staffId&leafId="
											+ leafId,
									method : "GET",
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
						reader : staff_reader,
						remoteSort : false
					});
			staff_store.load();
			var filters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : false,
				filters : [ {
					type : "string",
					dataIndex : "religionDesc",
					column : "religionDesc",
					table : "religion"
				}, {
					type : "list",
					dataIndex : "By",
					column : "By",
					table : "religion",
					labelField : "staffName",
					store : staff_store,
					phpMode : true
				}, {
					type : "date",
					dataIndex : "Time",
					column : "Time",
					table : "religion"
				}]
			});
			var filtersList = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : false,
				filters : [ {
					type : "string",
					dataIndex : "religionDesc",
					column : "religionDesc",
					table : "religion"
				}, {
					type : "list",
					dataIndex : "By",
					column : "By",
					table : "religion",
					labelField : "staffName",
					store : staff_store,
					phpMode : true
				}, {
					type : "date",
					dataIndex : "Time",
					column : "Time",
					table : "religion"
				}]
			});
			this.action = new Ext.ux.grid.RowActions(
					{
						header 		: 	actionLabel,
						width  		:	50,	
						dataIndex 	: 	"religionId",
						bodyStyle 	: 	"padding:5px",
						actions 	: 	[{
											iconCls 	:	"application_edit",
											tooltip 	:	updateRecordToolTipLabel,
											bodyStyle	: 	"padding:5px",
											callback 	: 	function(grid, record, action,row, col) {
												formPanel.getForm().reset();
												formPanel.form.load({
													url 	: "../controller/religionController.php",
													method 	: "POST",
													waitMsg : waitMessageLabel,
													params 	: {
														method 		: 	"read",
														mode 		: 	"update",
														religionId 	: 	record.data.religionId,
														leafId 		:	leafId
													},
													success : function(form,action) {
														Ext.getCmp(
																		"religionDesc_temp")
																.setValue(
																		record.data.religionDesc);
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
								},
								{
									iconCls : "trash",
									tooltip : deleteRecordToolTipLabel,
									bodyStyle : "padding:5px",
									callback : function(grid, record, action,
											row, col) {
										Ext.Msg
												.show({
													title : deleteRecordTitleMessageLabel,
													msg : deleteRecordMessageLabel,
													icon : Ext.Msg.QUESTION,
													buttons : Ext.Msg.YESNO,
													scope : this,
													fn : function(response) {
														if ("yes" == response) {
															Ext.Ajax
																	.request({
																		url : "../controller/religionController.php",
																		params : {
																			method : "delete",
																			religionId : record.data.religionId,
																			leafId : leafId
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
																			Ext.MessageBox.alert(
																							systemLabel,
																							x.message);
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
								} ]
					});
			this.actionList = new Ext.ux.grid.RowActions(
					{
						header : actionLabel,
						dataIndex : "religionId",
						bodyStyle : "padding:5px",
						actions : [
								{
									iconCls : "application_edit",
									tooltip : updateRecordToolTipLabel,
									bodyStyle : "padding:5px",
									callback : function(grid, record, action,
											row, col) {
										formPanel.getForm().reset();
										formPanel.form
												.load({
													url : "../controller/religionController.php",
													method : "POST",
													waitMsg : waitMessageLabel,
													params : {
														method : "read",
														mode : "update",
														religionId : record.data.religionId,
														leafId : leafId
													},
													success : function(form,
															action) {
														Ext
																.getCmp(
																		"religionDesc_temp")
																.setValue(
																		record.data.religionDesc);
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
										win.hide();
									}
								},
								{
									iconCls : "trash",
									tooltip : deleteRecordToolTipLabel,
									bodyStyle : "padding:5px",
									callback : function(grid, record, action,
											row, col) {
										Ext.Msg
												.show({
													title : deleteRecordTitleMessageLabel,
													msg : deleteRecordMessageLabel,
													icon : Ext.Msg.QUESTION,
													buttons : Ext.Msg.YESNO,
													scope : this,
													fn : function(response) {
														if ("yes" == response) {
															Ext.Ajax
																	.request({
																		url : "../controller/religionController.php",
																		params : {
																			method : "delete",
																			religionId : record.data.religionId,
																			leafId : leafId
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
								} ]
					});
			var columnModel = [ new Ext.grid.RowNumberer(), this.action, {
				dataIndex : "religionDesc",
				header : religionDescLabel,
				sortable : true,
				hidden : false
			}, {
				dataIndex : "byLabel",
				header : createByLabel,
				sortable : true,
				hidden : true
			}, {
				dataIndex : "timeLabel",
				header :  timeLabel,
				sortable : true,
				hidden : true,
				renderer    :   function(value) {
					return Ext.util.Format.date(value, 'Y-m-d H:i:s');
				}
			}];
			var columnModelList = [ new Ext.grid.RowNumberer(),
					this.actionList, {
						dataIndex : "religionDesc",
						header : religionDescLabel,
						sortable : true,
						hidden : false
					}, {
						dataIndex : "byLabel",
						header : createByLabel,
						sortable : true,
						hidden : true
					}, {
						dataIndex : "timeLabel",
						header :  timeLabel,
						sortable : true,
						hidden : true,
						renderer    :   function(value) {
							return Ext.util.Format.date(value, 'Y-m-d H:i:s');
						}
					}];
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
					emptyText : emptyTextLabel
				},
				iconCls : "application_view_detail",
				listeners : {
					render : {
						fn : function() {
							store.load({
								params : {
									start : 0,
									limit : per_page,
									method : "read",
									mode : "view",
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
				height : 400,
				columns : columnModelList,
				loadMask : true,
				plugins : [ this.actionList, filtersList ],
				sm : new Ext.grid.RowSelectionModel({
					singleSelect : true
				}),
				viewConfig : {
					forceFit : true,
					emptyText : emptyTextLabel
				},
				iconCls : "application_view_detail",
				listeners : {
					render : {
						fn : function() {
							storeList.load({
								params : {
									start : 0,
									limit : per_page,
									method : "read",
									mode : "view",
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
									iconCls : "database_refresh",
									id : "page_reload",
									disabled : page_reload,
									handler : function() {
										store.reload();
									}
								},
								{
									text : addToolbarLabel,
									iconCls : "add",
									id : "page_create",
									disabled : page_create,
									handler : function() {
										viewPort.items.get(1).expand();

									}
								},
								{
									text : printerToolbarLabel,
									iconCls : "printer",
									id : "page_printer",
									disabled : page_print,
									handler : function() {
										Ext.ux.GridPrinter.print(grid);
									}
								},
								{
									text : excelToolbarLabel,
									iconCls : "page_excel",
									id : "page_excel",
									disabled : page_print,
									handler : function() {
										Ext.Ajax
												.request({
													url : "../controller/religionController.php?method=report&mode=excel&limit="
															+ per_page
															+ "&leafId="
															+ leafId,
													method : "GET",
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == "true") {
															window
																	.open("../../setting/document/excel/"+x.filename);
														} else {
															Ext.MessageBox
																	.alert(
																			successLabel,
																			x.message);
														}
													},
													failure : function(response, options) {
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
									text : reloadToolbarLabel,
									iconCls : "database_refresh",
									id : "page_reloadList",
									disabled : page_reloadList,
									handler : function() {
										storeList.reload();
									}
								},
								{
									text : addToolbarLabel,
									iconCls : "add",
									id : "page_createList",
									disabled : page_createList,
									handler : function() {
										viewPort.items.get(1).expand();
										win.hide();
									}
								},
								{
									text : printerToolbarLabel,
									iconCls : "printer",
									id : "printerList",
									disabled : page_printList,
									handler : function() {
										Ext.ux.GridPrinter.print(grid);
									}
								},
								{
									text : excelToolbarLabel,
									iconCls : "page_excel",
									id : "page_excelList",
									disabled : page_printList,
									handler : function() {
										Ext.Ajax
												.request({
													url : "../controller/religionController.php?method=report&mode=excel&limit="
															+ per_page
															+ "&leafId="
															+ leafId,
													method : "GET",
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == "true") {
															window
																	.open("../../basic/document/excel/"+x.filename);
														} else {
															Ext.MessageBox
																	.alert(
																			"SYSTEM",
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
								} ]
					});
			var gridPanel = new Ext.Panel({
				title :  leafName,
				height : 50,
				layout : "fit",
				iconCls : "application_view_detail",
				tbar : [ {
									text : reloadToolbarLabel,
									iconCls : "database_refresh",
									id : "page_reload",
									disabled : page_reload,
									handler : function() {
										store.reload();
									}
								},
								{
									text : addToolbarLabel,
									iconCls : "add",
									id : "page_create",
									disabled : page_create,
									handler : function() {
										viewPort.items.get(1).expand();

									}
								},
								{
									text : printerToolbarLabel,
									iconCls : "printer",
									id : "page_printer",
									disabled : page_print,
									handler : function() {
										Ext.ux.GridPrinter.print(grid);
									}
								},
								{
									text : excelToolbarLabel,
									iconCls : "page_excel",
									id : "page_excel",
									disabled : page_print,
									handler : function() {
										Ext.Ajax
												.request({
													url : "../controller/religionController.php?method=report&mode=excel&limit="
															+ per_page
															+ "&leafId="
															+ leafId,
													method : "GET",
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == "true") {
															window
																	.open("../../basic/document/excel/"+x.filename);
														} else {
															Ext.MessageBox
																	.alert(
																			successLabel,
																			x.message);
														}
													},
													failure : function(response, options) {
																			status_code = response.status;
																			status_message = response.statusText;
																			Ext.MessageBox.alert(systemErrorLabel,escape(status_code)
																			+ ":"+ status_message);
																		}
												});
									}
								} ,new Ext.ux.form.SearchField({
                store: store,
                width:320
            })],
				items : [ grid ]
			});
			var religionDesc_temp = new Ext.form.Hidden({
				name : "religionDesc_temp",
				id : "religionDesc_temp"
			});
			var religionDesc = new Ext.form.TextField(
					{
						labelAlign : "left",
						fieldLabel : religionDescLabel+'<span style="color: red;">*</span>',
						hiddenName : "religionDesc",
						name : "religionDesc",
						id : "religionDesc",
						allowBlank : false,
						blankText : blankTextLabel,
						style : {
							textTransform : "uppercase"
						},
						anchor : "95%",
						listeners : {
							blur : function() {
								if (Ext.getCmp("religionDesc")
										.getValue().length > 0) {
									Ext.Ajax
											.request({
												url : "../controller/religionController.php?method=duplicate&leafId="
														+ leafId
														+ "&religionDesc="
														+ Ext
																.getCmp(
																		"religionDesc")
																.getValue(),
												method : "GET",
												success : function(response,
														options) {
													x = Ext
															.decode(response.responseText);
													if (x.success == "true") {
														if (x.total > 0) {
															if (Ext
																	.getCmp(
																			"religionDesc_temp")
																	.getValue() != Ext
																	.getCmp(
																			"religionDesc")
																	.getValue()) {
																duplicate = 1;
																duplicateMessageLabel= duplicateMessageLabel+
																			Ext.util.Format
																				.uppercase(Ext
																						.getCmp(
																								"religionDesc")
																						.getValue())
																		
																		+ ":"+
																		+ Ext.util.Format
																				.uppercase(x.religionDesc);
																Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				duplicateMessageLabel);
																Ext
																		.getCmp(
																				"religionDesc")
																		.setValue(
																				"");
															}
														}
													} else {
														Ext.MessageBox.alert(
																systemLabel,
																x.message);
													}
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
						}
					});
			var religionId = new Ext.form.Hidden({
				name : "religionId",
				id	 : "religionId"
			});
			var formPanel = new Ext.form.FormPanel(
					{
						url : "../controller/religionController.php",
						id : "formPanel",
						method : "post",
						frame : true,
						title : leafName,
						border : false,
						bodyStyle : "padding:5px",
						width : 600,
						items : [ religionId, religionDesc,
								religionDesc_temp ],
						buttonVAlign : "top",
						buttonAlign : "left",
						iconCls : "application_form",
						bbar : new Ext.ux.StatusBar({
							id : "form-statusbar",
							defaultText : defaultTextLabel,
							plugins : new Ext.ux.ValidationStatus({
								form : "formPanel"
							})
						}),
						buttons : [
								{
									text : saveButtonLabel,
									iconCls : "bullet_disk",
									handler : function() {
										if (formPanel.getForm().isValid()) {
											var id =0;
											id  = Ext.getCmp('religionId').getValue();
											var method ;
											if(id.length > 0 ) { 
												method = 'save';
											} else {
												method = 'create';
											}
											formPanel
													.getForm()
													.submit(
															{
																waitMsg : waitMessageLabel,
																params : {
																	method : method,
																	leafId : leafId
																},
																success : function(
																		form,
																		action) {
																	var title = successLabel;
																	Ext.MessageBox
																			.alert(
																					title,
																					action.result.message);
																	formPanel
																			.getForm()
																			.reset();
																	store
																			.reload();
																	storeList
																			.reload();
																},
																failure : function(
																		form,
																		action) {
																	
																	if (duplicate == 1) {
																		Ext.MessageBox
																				.alert(
																						title,
																						duplicateMessageLabel);
																	}
																	if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																		alert(loadFailureMessageLabel);
																	} else {
																		if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
																			alert(clientInvalidMessageLabel);
																		} else {
																			if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
																				Ext.Msg
																						.alert(
																								connectFailureLabel,
																								"Server reported:"
																										+ form.response.status
																										+ " "
																										+ form.response.statusText);
																			} else {
																				if (action.failureType === Ext.form.Action.SERVER_INVALID) {
																					Ext.Msg
																							.alert(
																									serverInvalidLabel,
																									action.result.message);
																				}
																			}
																		}
																	}
																}
															});
										}
									}
								}, {
									text :	newButtonLabel,
									type : "button",
									iconCls : "add",
									handler : function() {
										formPanel.getForm().reset();
									}
								}, {
									text : resetButtonLabel,
									type : "reset",
									iconCls : "table_refresh",
									handler : function() {
										formPanel.getForm().reset();
									}
								}, {
									text : listButtonLabel,
									type : "button",
									iconCls : "table",
									handler : function() {
										if (win) {
											win.show().center();
										}
									}
								}, {
									text : cancelButtonLabel,
									type : "button",
									iconCls : "delete",
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
				title :	leafName,
				closeAction : "hide",
				maximizable : true,
				layout : "fit",
				width : 500,
				autoScroll : true
			});
			var viewPort = new Ext.Viewport({
				id : "viewport",
				region : "center",
				layout : "accordion",
				layoutConfig : {
					titleCollapse : true,
					animate : false,
					activeOnTop : true
				},
				items : [ gridPanel, formPanel ]
			});
		});
