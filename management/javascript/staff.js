Ext
		.onReady(function() {
			Ext.QuickTips.init();
			// get current information of the page

			Ext.form.Field.prototype.msgTarget = 'under';
			var pageCreate;
			var pageCreateList;
			var pageReload;
			var pageReloadList;
			var pagePrint;
			var pagePrintList;
			if (leafCreateAccessValue == 1) {
				pageCreate = false;
				pageCreateList = false;
			} else {
				pageCreate = true;
				pageCreateList = true;
			}
			if (leafReadAccessValue == 1) {
				pageReload = false;
				pageReloadList = false;
			} else {
				pageReload = true;
				pageReloadList = true;
			}
			if (leafPrintAccessValue == 1) {
				pagePrint = false;
				pagePrintList = false;
			} else {
				pagePrint = true;
				pagePrintList = true;
			}
			Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';
			var perPage = 15;
			var encode = false;
			var local = false;
			var staffProxy = new Ext.data.HttpProxy({
				url : "../controller/staffController.php",
				method : 'POST',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
						// //uncomment it for debugging

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
			var staffReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "staffId"
					
			});
			var staffStore = new Ext.data.JsonStore({
				proxy : staffProxy,
				reader : staffReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				baseParams : {
					method : 'read',
					mode : 'view',
					leafId : leafId
				},
				fields : [ {
					name : 'staffId',
					type : 'int'
				}, {
					name : 'groupId',
					type : 'int'
				}, {
					name : 'departmentId',
					type : 'int'
				}, {
					name : 'groupName',
					type : 'string'
				}, {
					name : 'staffName',
					type : 'string'
				}, {
					name : 'staffIc',
					type : 'string'
				}, {
					name : 'staffNo',
					type : 'string'
				}, {
					name : "isDefault",
					type : "boolean"
				}, {
					name : "isNew",
					type : "boolean"
				}, {
					name : "isDraft",
					type : "boolean"
				}, {
					name : "isUpdate",
					type : "boolean"
				}, {
					name : "isDelete",
					type : "boolean"
				}, {
					name : "isActive",
					type : "boolean"
				}, {
					name : "isApproved",
					type : "boolean"
				}, {
					name : "By",
					type : "int"
				}, {
					name : "Time",
					type : "date",
					dateFormat : "Y-m-d H:i:s"
				} ]
			});

			var staffByProxy = new Ext.data.HttpProxy({
				url : "../controller/staffController.php?",
				method : "GET",
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(successLabel,
						// jsonResponse.message); //uncommen for testing purpose
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

			var groupProxy = new Ext.data.HttpProxy({
				url : "../controller/staffController.php",
				method : 'GET',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
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

			var groupReader = new Ext.data.JsonReader({

				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "groupId"

			});

			var groupStore = new Ext.data.JsonStore({
				proxy : groupProxy,
				reader : groupReader,
				autoLoad : true,
				autoDestroy : true,
				baseParams : {
					method : 'read',
					field : 'group',
					leafId : leafId
				},
				root : 'group',
				fields : [ {
					name : "groupId",
					type : "int"
				}, {
					name : "groupNote",
					type : "string"
				}, {
					name : "groupTranslate",
					type : "string"
				} ]
			});

			var departmentProxy = new Ext.data.HttpProxy({
				url : "../controller/staffController.php",
				method : 'GET',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
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

			var departmentReader = new Ext.data.JsonReader({

				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "departmentId"

			});

			var departmentStore = new Ext.data.JsonStore({
				proxy : departmentProxy,
				reader : departmentReader,
				autoLoad : true,
				autoDestroy : true,
				baseParams : {
					method : 'read',
					field : 'department',
					leafId : leafId
				},
				root : 'department',
				fields : [ {
					name : "departmentId",
					type : "int"
				}, {
					name : "departmentNote",
					type : "string"
				}, {
					name : "departmentTranslate",
					type : "string"
				} ]
			});

			var staffFilters = new Ext.ux.grid.GridFilters({
				// encode and local configuration options defined previously for
				// easier reuse
				encode : encode, // json encode the filter query
				local : false, // defaults to false (remote filtering)
				filters : [ {
					type : 'list',
					dataIndex : 'groupId',
					column : 'groupId',
					table : 'staff',
					labelField : 'groupTranslate',
					store : groupStore,
					phpMode : true
				}, {
					type : 'list',
					dataIndex : 'departmentId',
					column : 'groupId',
					table : 'staff',
					labelField : 'groupTranslate',
					store : groupStore,
					phpMode : true
				}, {
					type : 'string',
					dataIndex : 'staffName',
					column : 'staffName',
					table : 'staff'
				}, {
					type : 'string',
					dataIndex : 'staffIc',
					column : 'staffIc',
					table : 'staff'
				}, {
					type : 'string',
					dataIndex : 'staffNo',
					column : 'staffNo',
					table : 'staff'
				}, {
					type : 'list',
					dataIndex : 'by',
					column : 'by',
					table : 'staff',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dataIndex : 'Time',
					column : 'Time',
					table : 'staff'
				} ]
			});

			var staffColumnModel = [ new Ext.grid.RowNumberer(), {
				dataIndex : 'groupTranslate',
				header : groupTranslateLabel,
				hidden : false,
				sortable : true
			}, {
				dataIndex : 'departmentTranslate',
				header : departmentTranslateLabel,
				hidden : false,
				sortable : true
			}, {
				dataIndex : 'staffName',
				header : staffNameLabel,
				hidden : false,
				sortable : true
			}, {
				dataIndex : 'staffIc',
				header : staffIcLabel,
				hidden : false,
				sortable : true
			}, {
				dataIndex : 'staffNo',
				header : staffNoLabel,
				hidden : false,
				sortable : true
			}, {
				dataIndex : 'By',
				header : byLabel,
				hidden : true,
				sortable : true
			}, {
				dataIndex : 'createTime',
				header : timeLabel,
				hidden : true,
				sortable : true,
				renderer : function(value) {
					return Ext.util.Format.date(value, 'Y-m-d H:i:s');
				}
			} ];

			var staffGrid = new Ext.grid.GridPanel({
				border : false,
				store : staffStore,
				autoHeight : false,
				height : 400,
				columns : staffColumnModel,
				loadMask : true,
				plugins : [ staffFilters ],
				sm : new Ext.grid.RowSelectionModel({
					singleSelect : true
				}),
				viewConfig : {
					forceFit : true,
					emptyText : emptyRowLabel
				},
				iconCls : 'application_view_detail'
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
									text : addToolbarLabel,
									iconCls : 'add',
									id : 'pageCreate',
									disabled : pageCreate,
									handler : function() {
										viewPort.items.get(1).expand();
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
													url : '../controller/staffController.php?method=report&mode=excel&limit='
															+ perPage
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == 'true') {

															window
																	.open("../pentabiran/document/excel/staff.xlsx");
														} else {
															Ext.MessageBox
																	.alert(
																			systemErrorLabel,
																			x.message);
														}

													},
													failure : function(
															response, options) {
														status_code = response.status;
														status_message = response.statusText;
														Ext.MessageBox
																.alert(
																		systemErrorLabel,
																		escape(status_code)
																				+ ":"
																				+ status_message);
													}

												});
									}
								} ]
					});

			var gridPanel = new Ext.Panel(
					{
						title : leafNote,
						height : 50,
						layout : 'fit',
						iconCls : 'application_view_detail',
						tbar : [
								{
									text : reloadToolbarLabel,
									iconCls : "database_refresh",
									id : "pageReload",
									disabled : pageReload,
									handler : function() {
										groupStore.reload();
									}
								},

								'-',
								{
									text : excelToolbarLabel,
									iconCls : "page_excel",
									id : "page_excel",
									disabled : pagePrint,
									handler : function() {
										Ext.Ajax
												.request({
													url : "../controller/groupController.php",
													method : "GET",
													params : {
														method : 'report',
														mode : 'excel',
														limit : perPage,
														leafId : leafId
													},
													success : function(
															response, options) {
														jsonResponse = Ext
																.decode(response.responseText);
														if (jsonResponse.success == true) {
															window
																	.open("../../management/document/excel/"
																			+ jsonResponse.filename);
														} else {
															Ext.MessageBox
																	.alert(
																			successLabel,
																			jsonResponse.message);
														}
													},
													failure : function(
															response, options) {
														Ext.MessageBox
																.alert(
																		systemErrorLabel,
																		escape(response.status)
																				+ ":"
																				+ escape(response.statusText));
													}
												});
									}
								}, '-', new Ext.ux.form.SearchField({
									store : groupStore,
									width : 320
								}) ],
						items : [ staffGrid ]
					});

			// viewport just save information,items will do separate
			var groupId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : groupIdLabel,
				name : 'groupId',
				hiddenName : 'groupId',
				valueField : 'groupId',
				id : 'group_fake',
				displayField : 'groupName',
				typeAhead : false,
				triggerAction : 'all',
				store : groupStore,
				anchor : '95%',
				selectOnFocus : true,
				mode : 'local',
				allowBlank : false,
				blankText : blankTextLabel,
				createValueMatcher : function(value) {
					value = String(value).replace(/\s*/g, '');
					if (Ext.isEmpty(value, false)) {
						return new RegExp('^');
					}
					value = Ext.escapeRe(value.split('').join('\\s*')).replace(
							/\\\\s\\\*/g, '\\s*');
					return new RegExp('\\b(' + value + ')', 'i');
				}
			});

			var departmentId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : departmentIdLabel,
				name : 'departmentId',
				hiddenName : 'departmentId',
				valueField : 'departmentId',
				id : 'department_fake',
				displayField : 'departmentName',
				typeAhead : false,
				triggerAction : 'all',
				store : departmentStore,
				anchor : '95%',
				selectOnFocus : true,
				mode : 'local',
				allowBlank : false,
				blankText : blankTextLabel,
				createValueMatcher : function(value) {
					value = String(value).replace(/\s*/g, '');
					if (Ext.isEmpty(value, false)) {
						return new RegExp('^');
					}
					value = Ext.escapeRe(value.split('').join('\\s*')).replace(
							/\\\\s\\\*/g, '\\s*');
					return new RegExp('\\b(' + value + ')', 'i');
				}
			});

			var staffName = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : staffNameLabel,
				hiddenName : 'staffName',
				name : 'staffName',
				allowBlank : false,
				blankText : blankTextLabel,
				style : {
					textTransform : "uppercase"
				},
				anchor : '95%'
			});

			var staffIc = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : staffIcLabel,
				hiddenName : 'staffIc',
				name : 'staffIc',
				allowBlank : false,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			var staffNo = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : staffNoLabel,
				hiddenName : 'staffNo',
				name : 'staffNo',
				allowBlank : false,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			var staffPassword = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : staffPasswordLabel,
				hiddenName : 'staffPassword',
				name : 'staffPassword',
				inputType : 'password',
				allowBlank : false,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			// hidden id for updated
			var staffId = new Ext.form.Hidden({
				name : 'staffId'
			});

			var formPanel = new Ext.form.FormPanel(
					{
						id : 'formPanel',
						url : '../controller/staffController.php',
						method : 'post',
						frame : true,
						title : leafNote,
						border : false,

						width : 600,
						items : [ groupId, departmentId, staffId, staffName,
								staffIc, staffNo, staffPassword ],
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
										// check groupId field value

										if (!(is_int(Ext.getCmp('group_fake')
												.getValue()))) {
											Ext.getCmp('group_fake').setValue(
													'');
										} else {
											if (formPanel.getForm().isValid()) {
												var id = 0;
												id = Ext.getCmp('staffId')
														.getValue();
												var method;
												if (id.length > 0) {
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
																		Ext.MessageBox
																				.alert(
																						title,
																						action.result.message);

																		formPanel
																				.getForm()
																				.reset();
																		store
																				.reload({
																					params : {
																						leafId : leafId,
																						start : 0,
																						limit : perPage
																					}
																				});
																		// should
																		// be
																		// refresh
																		// back
																		// the
																		// main
																		// parent.
																		viewPort.items
																				.get(
																						0)
																				.expand();
																	},
																	failure : function(
																			form,
																			action) {

																		if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																			alert(loadFailureMessageLabel);
																		} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
																			// here
																			// will
																			// be
																			// error
																			// if
																			// duplicate
																			// code
																			alert(clientInvalidMessageLabel);
																		} else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
																			Ext.Msg
																					.alert(connectFailureLabel
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
										// formPanel.getForm().reset();

										var win;
										win = new Ext.Window({
											items : [ gridPanelList ],
											closeAction : 'hide',
											maximizable : true,
											title : leafNote,
											layout : 'fit',
											width : 500,
											autoScroll : true
										});
										win.show(this);
									}
								} ]
					});

			var viewPort = new Ext.Viewport({
				id : 'viewport',
				region : 'center',
				layout : 'accordion',
				layoutConfig : {
					// layout-specific configs go here
					titleCollapse : true,
					animate : false,
					activeOnTop : true
				},
				items : [ gridPanel, formPanel ]
			});

		});
