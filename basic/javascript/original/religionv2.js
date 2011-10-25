Ext
		.onReady(function() {
			Ext.QuickTips.init();
			Ext.BLANK_IMAGE_URL = "../../javascript/resources/images/s.gif";
			Ext.form.Field.prototype.msgTarget = "under";
			Ext.Ajax.timeout = 90000;

			var pageCreate;
			var pageReload;
			var pagePrint;
			var perPage = 15;
			var encode = false;
			var local = false;
			var jsonResponse;
			var duplicate = 0;

			if (leafAccessReadValue == 1) {
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
				pagePrintList = true;
			}
			var religionProxy = new Ext.data.HttpProxy({
				url : "../controller/religionController.php",
				method : 'POST',
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
			var religionReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "religionId"
			});
			var religionStore = new Ext.data.JsonStore({
				proxy : religionProxy,
				reader : religionReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				baseParams : {
					method : "read",
					leafId : leafId,
					isAdmin : isAdmin,
					start : 0,
					perPage : perPage
				},
				root : "data",
				fields : [ {
					name : "religionId",
					type : "int"
				}, {
					name : "religionDesc",
					type : "string"
				}, {
					name : "executeBy",
					type : "int"
				}, {
					name : "staffName",
					type : "string"
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
					name : "isReview",
					type : "boolean"
				}, {
					name : "isPost",
					type : "boolean"
				}, {
					name : "executeBy",
					type : "int"
				}, {
					name : "executeTime",
					type : "date",
					dateFormat : "Y-m-d H:i:s"
				} ]
			});

			var staffByProxy = new Ext.data.HttpProxy({
				url : "../controller/religionController.php?",
				method : "GET",
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(successLabel,jsonResponse.message);
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
			var religionFilters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : local,
				filters : [ {
					type : "string",
					dataIndex : "religionDesc",
					column : "religionDesc",
					table : "religion"
				}, {
					type : "list",
					dataIndex : "executeBy",
					column : "executeBy",
					table : "religion",
					labelField : "staffName",
					store : staffByStore,
					phpMode : true
				}, {
					type : "date",
					dataIndex : "executeTime",
					column : "executeTime",
					table : "religion"
				} ]
			});

			var isDefaultGrid = new Ext.ux.grid.CheckColumn({
				header : isDefaultLabel,
				dataIndex : 'isDefault',
				hidden : isDefaultHidden
			});
			var isNewGrid = new Ext.ux.grid.CheckColumn({
				header : 'New',
				dataIndex : 'isNew',
				hidden : isNewHidden
			});
			var isDraftGrid = new Ext.ux.grid.CheckColumn({
				header : isDraftLabel,
				dataIndex : 'isDraft',
				hidden : isDraftHidden
			});
			var isUpdateGrid = new Ext.ux.grid.CheckColumn({
				header : isUpdateLabel,
				dataIndex : 'isUpdate',
				hidden : isUpdateHidden
			});
			var isDeleteGrid = new Ext.ux.grid.CheckColumn({
				header : isDeleteLabel,
				dataIndex : 'isDelete'
			});
			var isActiveGrid = new Ext.ux.grid.CheckColumn({
				header : isActiveLabel,
				dataIndex : 'isActive',
				hidden : isActiveHidden
			});
			var isApprovedGrid = new Ext.ux.grid.CheckColumn({
				header : isApprovedLabel,
				dataIndex : 'isApproved',
				hidden : isApprovedHidden
			});
			var isReviewGrid = new Ext.ux.grid.CheckColumn({
				header : isReviewLabel,
				dataIndex : 'isReview',
				hidden : isActiveHidden
			});
			var isPostGrid = new Ext.ux.grid.CheckColumn({
				header : 'Post',
				dataIndex : 'isPost',
				hidden : isPostHidden
			});
			var religionColumnModel = [ new Ext.grid.RowNumberer(), {
				dataIndex : "religionDesc",
				header : religionDescLabel,
				sortable : true,
				hidden : false
			}, isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid,
					isDeleteGrid, isActiveGrid, isApprovedGrid, isReviewGrid,
					isPostGrid ];

			var accessArray = [ 'isDefault', 'isNew', 'isDraft', 'isUpdate',
					'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost' ];
			var religionGrid = new Ext.grid.GridPanel(
					{
						border : false,
						store : religionStore,
						autoHeight : false,
						height : 400,
						columns : religionColumnModel,
						plugins : [ religionFilters ],
						sm : new Ext.grid.RowSelectionModel({
							singleSelect : true
						}),
						viewConfig : {
							emptyText : emptyTextLabel
						},
						iconCls : "application_view_detail",
						listeners : {
							'rowclick' : function(object, rowIndex, e) {
								var record = religionStore.getAt(rowIndex);
								formPanel.getForm().reset();
								formPanel.form
										.load({
											url : "../controller/religionController.php",
											method : "POST",
											waitTitle : systemLabel,
											waitMsg : waitMessageLabel,
											params : {
												method : "read",
												mode : "update",
												religionId : record.data.religionId,
												leafId : leafId,
												isAdmin : isAdmin
											},
											success : function(form, action) {
												Ext
														.getCmp(
																"religionDesc_temp")
														.setValue(
																record.data.religionDesc);
												Ext.getCmp('deleteButton')
														.enable();
												viewPort.items.get(1).expand();
											},
											failure : function(form, action) {
												Ext.MessageBox.alert(
														systemErrorLabel,
														action.result.message);
											}
										});
							}
						},
						tbar : {
							items : [
									{
										text : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {

												religionStore
														.each(function(rec) {
															for ( var access in accessArray) { 
																rec
																		.set(
																				accessArray[access],
																				true);
															}
														});
											}
										}
									},
									{
										text : ClearAllLabel,
										iconCls : 'row-check-sprite-uncheck',
										listeners : {
											'click' : function() {
												religionStore
														.each(function(rec) {
															for ( var access in accessArray) {
																rec
																		.set(
																				accessArray[access],
																				false);
															}
														});
											}
										}
									},
									{
										text : saveButtonLabel,
										iconCls : 'bullet_disk',
										listeners : {
											'click' : function(c) {
												var url;

												url = '../controller/religionController.php?';
												var sub_url;
												sub_url = '';
												var modified = religionStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = religionStore
															.getAt(i);
													sub_url = sub_url
															+ '&religionId[]='
															+ record
																	.get('religionId');
													if (isAdmin == 1) {
														sub_url = sub_url
																+ '&isDraft[]='
																+ record
																		.get('isDraft');
														sub_url = sub_url
																+ '&isNew[]='
																+ record
																		.get('isNew');
														sub_url = sub_url
																+ '&isUpdate[]='
																+ record
																		.get('isUpdate');
													}
													sub_url = sub_url
															+ '&isDelete[]='
															+ record
																	.get('isDelete');
													if (isAdmin == 1) {
														sub_url = sub_url
																+ '&isActive[]='
																+ record
																		.get('isActive');
														sub_url = sub_url
																+ '&isApproved[]='
																+ record
																		.get('isApproved');
														sub_url = sub_url
																+ '&isReview[]='
																+ record
																		.get('isReview');
														sub_url = sub_url
																+ '&isPost[]='
																+ record
																		.get('isPost');
													}
												}
												url = url + sub_url;
												Ext.Ajax
														.request({
															url : url,
															method : 'GET',
															params : {
																leafId : leafId,
																method : 'updateStatus'
															},
															success : function(
																	response,
																	options) {
																jsonResponse = Ext
																		.decode(response.responseText);
																if (jsonResponse.success == true) {
																	Ext.MessageBox
																			.alert(
																					systemLabel,
																					jsonResponse.message);
																	religionStore
																			.reload();
																} else if (jsonResponse.success == false) {
																	Ext.MessageBox
																			.alert(
																					systemErrorLabel,
																					jsonResponse.message);
																}
															},
															failure : function(
																	response,
																	options) {
																Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				escape(response.status)
																						+ ":"
																						+ escape(response.statusText));
															}
														}); // refresh the store
											}
										}
									} ]
						},
						bbar : new Ext.PagingToolbar({
							store : religionStore,
							pageSize : perPage
						})
					});

			var gridPanel = new Ext.Panel(
					{
						title : leafNative,
						iconCls : "application_view_detail",
						layout : 'fit',
						tbar : [
								{
									text : reloadToolbarLabel,
									iconCls : "database_refresh",
									id : "pageReload",
									disabled : pageReload,
									handler : function() {
										religionStore.reload();
									}
								},
								'-',
								{
									text : addToolbarLabel,
									iconCls : "add",
									id : "pageCreate",
									disabled : pageCreate,
									handler : function() {
										viewPort.items.get(1).expand();
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
													url : "../controller/religionController.php",
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
																	.open("../../basic/document/excel/"
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
									store : religionStore,
									width : 320
								}) ],
						items : [ religionGrid ]

					});
			var religionDesc_temp = new Ext.form.Hidden({
				name : "religionDesc_temp",
				id : "religionDesc_temp"
			});
			// form entry
			var religionDesc = new Ext.form.TextField(
					{
						labelAlign : "left",
						fieldLabel : religionDescLabel
								+ '<span style="color: red;">*</span>',
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
								if (Ext.getCmp("religionDesc").getValue().length > 0) {
									Ext.Ajax
											.request({
												url : "../controller/religionController.php",
												method : "GET",
												params : {
													method : "duplicate",
													leafId : leafId,
													religionDesc : Ext.getCmp(
															"religionDesc")
															.getValue()
												},
												success : function(response,
														options) {
													jsonResponse = Ext
															.decode(response.responseText);
													if (jsonResponse.success == true) {
														if (jsonResponse.total > 0) {
															if (Ext
																	.getCmp(
																			"religionDesc_temp")
																	.getValue() != Ext
																	.getCmp(
																			"religionDesc")
																	.getValue()) {
																duplicate = 1;
																duplicateMessageLabel = duplicateMessageLabel
																		+ Ext.util.Format
																				.uppercase(Ext
																						.getCmp(
																								"religionDesc")
																						.getValue())
																		+ ":"
																		+ +Ext.util.Format
																				.uppercase(jsonResponse.religionDesc);
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
														Ext.MessageBox
																.alert(
																		systemLabel,
																		jsonResponse.message);
													}
												},
												failure : function(response,
														options) {
													Ext.MessageBox
															.alert(
																	systemErrorLabel,
																	escape(response.status)
																			+ ":"
																			+ escape(response.statusText));
												}
											});
								}
							}
						}
					});

			var religionId = new Ext.form.Hidden({
				name : "religionId",
				id : "religionId"
			});
			// end form entry
			// start System Validation

			var isDefault = new Ext.form.Checkbox({
				name : 'isDefault',
				id : 'isDefault',
				fieldLabel : isDefaultLabel,
				hidden : isDefaultHidden
			});

			var isNew = new Ext.form.Checkbox({
				name : 'isNew',
				id : 'isNew',
				fieldLabel : isNewLabel,
				hidden : isNewHidden
			});

			var isDraft = new Ext.form.Checkbox({
				name : 'isDraft',
				id : 'isDraft',
				fieldLabel : isDraftLabel,
				hidden : isDraftHidden
			});
			var isUpdate = new Ext.form.Checkbox({
				name : 'isUpdate',
				id : 'isUpdate',
				fieldLabel : isUpdateLabel,
				hidden : isUpdateHidden
			});

			var isDelete = new Ext.form.Checkbox({
				name : 'isDelete',
				id : 'isDelete',
				fieldLabel : isDeleteLabel,
				hidden : isDeleteHidden
			});

			var isActive = new Ext.form.Checkbox({
				name : 'isActive',
				id : 'isActive',
				fieldLabel : isActiveLabel,
				hidden : isActiveHidden
			});

			var isApproved = new Ext.form.Checkbox({
				name : 'isApproved',
				id : 'isApproved',
				fieldLabel : isApprovedLabel,
				hidden : isApprovedHidden
			});

			var isReview = new Ext.form.Checkbox({
				name : 'isReview',
				id : 'isReview',
				fieldLabel : isReviewLabel,
				hidden : isReviewHidden
			});

			var isPost = new Ext.form.Checkbox({
				name : 'isPost',
				id : 'isPost',
				fieldLabel : isPostLabel,
				hidden : isPostHidden
			});

			// end System Validation
			var formPanel = new Ext.form.FormPanel(
					{
						url : "../controller/religionController.php",
						name : "formPanel",
						id : "formPanel",
						method : "post",
						frame : true,
						title : leafNative,
						border : false,
						bodyStyle : "padding:5px",
						width : 600,
						items : [
								{
									xtype : 'fieldset',
									title : 'Form Entry',
									items : [ religionId, religionDesc,
											religionDesc_temp ]
								},
								{
									xtype : 'fieldset',
									title : 'System Administration',
									layout : 'column',
									items : [{
												columnWidth:0.3,
												layout:'form',
												border:false,
												items:[isDefault, isNew, isDraft]
											},
											{
												columnWidth:0.3,
												layout:'form',
												border:false,
												items:[isUpdate, isDelete, isActive]
											},
											{
												columnWidth:0.3,
												layout:'form',
												border:false,
												items:[isApproved, isReview, isPost] 
											}]
								} ],
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
									text : auditButtonLabel,
									name : 'auditButtonLabel',
									id : 'auditButtonLabel',
									type : 'button',
									iconCls : 'key',
									disabled : auditButtonLabelDisabled,
									handler : function() {

										if (auditWindow) {
											religionStore.reload();
											auditWindow.show().center();
										}
									}
								},

								{
									text : newButtonLabel,
									name:'newButton',
									id:'newButton',
									type : 'button',
									iconCls : 'new',
									handler : function() {
										var id = 0;
										var id = Ext.getCmp('religionId')
												.getValue();
										var method = 'create';
										
										formPanel
												.getForm()
												.submit(
														{
															waitMsg : waitMessageLabel,
															params : {
																method : method,
																leafId : leafId,
																isAdmin : isAdmin
															},
															success : function(
																	form,
																	action) {
																if(action.result.success==true) { 
																Ext.MessageBox
																		.alert(
																				systemLabel,
																				action.result.message);
																
																Ext
																		.getCmp(
																				'deleteButton')
																		.enable();

																religionStore
																		.reload({
																			params : {
																				leafId : leafId,
																				start : 0,
																				limit : perPage
																			}
																		});
																Ext
																		.getCmp(
																				'religionId')
																		.setValue(
																				action.result.religionId);
																} else {
																	Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				action.result.message);
																}																

															},
															failure : function(
																	form,
																	action) {

																if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																	Ext.Msg
																			.alert(
																					systemErrorLabel,
																					loadFailureLabel);
																} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {

																	Ext.Msg
																			.alert(
																					systemErrorLabel,
																					clientInvalidLabel);
																} else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
																	Ext.Msg
																			.alert(form.response.status
																					+ ' '
																					+ form.response.statusText);
																} else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
																	Ext.Msg
																			.alert(
																					systemErrorLabel,
																					action.result.message);
																}
															}
														});
									}
								},
								{
									text : saveButtonLabel,
									name : 'saveButton',
									id : 'saveButton',
									iconCls : 'bullet_disk',
									disabled : true,
									handler : function() {
										Ext.getCmp('newButton').disable();

										var id = 0;
										var id = Ext.getCmp('religionId')
												.getValue();
										var method= 'save';

							
										formPanel
												.getForm()
												.submit(
														{
															waitMsg : waitMessageLabel,
															params : {
																method : method,
																leafId : leafId,
																isAdmin : isAdmin
															},
															success : function(
																	form,
																	action) {
																if(action.result.success==true) { 
																Ext.MessageBox
																		.alert(
																				systemLabel,
																				action.result.message);
																
																Ext
																		.getCmp(
																				'deleteButton')
																		.enable();

																religionStore
																		.reload({
																			params : {
																				leafId : leafId,
																				start : 0,
																				limit : perPage
																			}
																		});
																
																} else {
																	Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				action.result.message);
																}								

															},
															failure : function(
																	form,
																	action) {

																if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																	Ext.Msg
																			.alert(
																					systemErrorLabel,
																					loadFailureLabel);
																} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {

																	Ext.Msg
																			.alert(
																					systemErrorLabel,
																					clientInvalidLabel);
																} else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
																	Ext.Msg
																			.alert(form.response.status
																					+ ' '
																					+ form.response.statusText);
																} else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
																	Ext.Msg
																			.alert(
																					systemErrorLabel,
																					action.result.message);
																}
															}
														});
									}
								},
								{
									text : deleteButtonLabel,
									type : 'button',
									name : 'deleteButton',
									id : 'deleteButton',
									iconCls : 'trash',
									disabled : true,
									handler : function() {
										Ext.getCmp('newButton').disable();

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
																			leafId : leafId,
																			isAdmin : isAdmin
																		},
																		success : function(
																				response,
																				options) {
																			jsonResponse = Ext
																					.decode(response.responseText);
																			if (jsonResponse.success == true) {

																				Ext.MessageBox
																						.alert(
																								systemLabel,
																								jsonResponse.message);

																				religionStore
																						.reload({
																							params : {
																								leafId : leafId,
																								start : 0,
																								limit : perPage
																							}
																						});
																				
																				Ext
																						.getCmp(
																								'saveButton')
																						.disable();
																				Ext
																						.getCmp(
																								'nextButton')
																						.disable();
																				Ext
																						.getCmp(
																								'previousButton')
																						.disable();

																			} else {

																				Ext.MessageBox
																						.alert(
																								systemErrorLabel,
																								jsonResponse.message);
																			}

																		},
																		failure : function(
																				response,
																				options) {
																			Ext.MessageBox
																					.alert(
																							systemErrorLabel,
																							escape(response.status)
																									+ ":"
																									+ response.statusText);
																		}
																	});
														}
													}
												});
									}
								},
								{
									text : resetButtonLabel,
									type : 'reset',
									name : 'resetButton',
									id : 'resetButton',
									iconCls : 'database_refresh',
									handler : function() {
										Ext.getCmp('newButton').enable();

										formPanel.getForm().reset();
									}

								},
								{
									text : postButtonLabel,
									type : 'button',
									name : 'postButton',
									id : 'postButton',
									iconCls : 'lock',
									disabled: true,
									handler : function() {
										Ext.getCmp('newButton').disable();

										formPanel.getForm().reset();
									}

								},
								{
									text : gridButtonLabel,
									type : 'button',
									name : 'gridButton',
									id : 'gridButton',
									iconCls : 'table',
									handler : function() {
										formPanel.getForm().reset();
										viewPort.items.get(0).expand();
									}
								},
								{
									text : firstButtonLabel,
									name : 'firstButton',
									id : 'firstButton',
									type : 'button',
									iconCls : 'resultset_first',
									handler : function() {
										Ext.getCmp('newButton').disable();
										

										if (Ext.getCmp('firstRecord')
												.getValue() == '') {
											Ext.Ajax
													.request({
														url : "../controller/religionController.php",
														method : "GET",
														params : {
															method : "dataNavigationRequest",
															leafId : leafId,
															dataNavigation : 'firstRecord'
														},
														success : function(
																response,
																options) {

															jsonResponse = Ext
																	.decode(response.responseText);
															if (jsonResponse.success == true) {
																Ext
																		.getCmp(
																				'firstRecord')
																		.setValue(
																				jsonResponse.firstRecord);
																				
																formPanel.form
												.load({
													url : "../controller/religionController.php",
													method : "POST",
													waitTitle : systemLabel,
													waitMsg : waitMessageLabel,
													params : {
														method : "read",

														religionId : Ext
																.getCmp(
																		'firstRecord')
																.getValue(),
														leafId : leafId,
														isAdmin : isAdmin
													},
													success : function(form,
															action) {
														if(action.result.success==true) { 
														if(action.result.nextRecord == 0 ) { 
															Ext.getCmp('nextButton').disable();
														} else {
															Ext.getCmp('nextButton').enable();
														}
														Ext
																.getCmp(
																		'firstRecord')
																.setValue(
																		action.result.firstRecord);
														Ext
																.getCmp(
																		'previousRecord')
																.setValue(
																		action.result.previousRecord);
														Ext
																.getCmp(
																		'nextRecord')
																.setValue(
																		action.result.nextRecord);
														Ext
																.getCmp(
																		'lastRecord')
																.setValue(
																		action.result.lastRecord);
														Ext
																.getCmp(
																		'endRecord')
																.setValue(
																		(action.result.lastRecord + 1));
														
														Ext
																.getCmp(
																		'previousButton')
																.disable();
														
														} else {
															Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				action.result.message);
														}
													},
													failure : function(form,
															action) {
														Ext.MessageBox
																.alert(
																		systemErrorLabel,
																		action.result.message);
													}
												});				
															} else {
																Ext.MessageBox
																		.alert(
																				systemLabel,
																				jsonResponse.message);
															}
														},
														failure : function(
																response,
																options) {
															Ext.MessageBox
																	.alert(
																			systemErrorLabel,
																			escape(response.status)
																					+ ":"
																					+ escape(response.statusText));
														}
													});
										} else  { 
										formPanel.form
												.load({
													url : "../controller/religionController.php",
													method : "POST",
													waitTitle : systemLabel,
													waitMsg : waitMessageLabel,
													params : {
														method : "read",

														religionId : Ext
																.getCmp(
																		'firstRecord')
																.getValue(),
														leafId : leafId,
														isAdmin : isAdmin
													},
													success : function(form,
															action) {
														if(action.result.success==true) {
														if(action.result.nextRecord == 0 ) { 
															Ext.getCmp('nextButton').disable();
														} else {
															Ext.getCmp('nextButton').enable();
														}								
														Ext
																.getCmp(
																		'firstRecord')
																.setValue(
																		action.result.firstRecord);
														Ext
																.getCmp(
																		'previousRecord')
																.setValue(
																		action.result.previousRecord);
														Ext
																.getCmp(
																		'nextRecord')
																.setValue(
																		action.result.nextRecord);
														Ext
																.getCmp(
																		'lastRecord')
																.setValue(
																		action.result.lastRecord);
														Ext
																.getCmp(
																		'endRecord')
																.setValue(
																		(action.result.lastRecord + 1));
														
														Ext
																.getCmp(
																		'previousButton')
																.disable();
														
														} else {
															Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				action.result.message);
														}
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

										

									}
								},
								{
									text : previousButtonLabel,
									name : 'previousButton',
									id : 'previousButton',
									type : 'button',
									iconCls : 'resultset_previous',
									disabled : true,
									handler : function() {
										Ext.getCmp('newButton').disable();

										if (Ext.getCmp('previousRecord')
												.getValue() == ''
												||

												Ext.getCmp('previousRecord')
														.getValue() == undefined) {
											Ext.MessageBox
													.alert(systemErrorLabel,chooseRecordLabel);

										}
										if (Ext.getCmp('firstRecord')
												.getValue() >= 1) {
											formPanel.form
													.load({
														url : "../controller/religionController.php",
														method : "POST",
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : "read",

															religionId : Ext
																	.getCmp(
																			'previousRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {
															if(action.result.success==true) { 
															Ext
																	.getCmp(
																			'firstRecord')
																	.setValue(
																			action.result.firstRecord);
															Ext
																	.getCmp(
																			'previousRecord')
																	.setValue(
																			action.result.previousRecord);
															Ext
																	.getCmp(
																			'nextRecord')
																	.setValue(
																			action.result.nextRecord);
															Ext
																	.getCmp(
																			'lastRecord')
																	.setValue(
																			action.result.lastRecord);
															Ext
																	.getCmp(
																			'endRecord')
																	.setValue(
																			(action.result.lastRecord + 1));

															
															if (Ext
																	.getCmp(
																			'previousRecord')
																	.getValue() == 0) {
																Ext
																		.getCmp(
																				'previousButton')
																		.disable();
															}
															
															} else{
																Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				action.result.message);
															}
														},
														failure : function(
																form, action) {
															Ext.MessageBox
																	.alert(
																			systemErrorLabel,
																			action.result.message);
														}
													});
										} else {
											
											Ext.MessageBox.alert(
													systemErrorLabel,
													recordNotFoundLabel);
										}
									}
								},
								{
									text : nextButtonLabel,
									name : 'nextButton',
									id : 'nextButton',
									type : 'button',
									disabled : true,
									iconCls : 'resultset_next',
									handler : function() {
										Ext.getCmp('newButton').disable();
										if (Ext.getCmp('nextRecord').getValue() == ''
												|| Ext.getCmp('nextRecord')
														.getValue() == undefined

										) {
											Ext.MessageBox
													.alert(systemErrorLabel,chooseRecordLabel);

										}
										if (Ext.getCmp('nextRecord').getValue() <= Ext
												.getCmp('lastRecord')
												.getValue()) {

											formPanel.form
													.load({
														url : "../controller/religionController.php",
														method : "POST",
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : "read",

															religionId : Ext
																	.getCmp(
																			'nextRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {
															if(action.result.success==true) { 
															Ext
																	.getCmp(
																			'firstRecord')
																	.setValue(
																			action.result.firstRecord);
															Ext
																	.getCmp(
																			'previousRecord')
																	.setValue(
																			action.result.previousRecord);
															Ext
																	.getCmp(
																			'nextRecord')
																	.setValue(
																			action.result.nextRecord);
															Ext
																	.getCmp(
																			'lastRecord')
																	.setValue(
																			action.result.lastRecord);
															Ext
																	.getCmp(
																			'endRecord')
																	.setValue(
																			(action.result.lastRecord + 1));

															
															if (Ext
																	.getCmp(
																			'nextRecord')
																	.getValue() > Ext
																	.getCmp(
																			'lastRecord')
																	.getValue()) {
																Ext
																		.getCmp(
																				'nextButton')
																		.disable();
															}
															if (Ext
																	.getCmp(
																			'nextRecord')
																	.getValue() == 0) {
																Ext
																		.getCmp(
																				'nextButton')
																		.disable();
															}
															Ext
																	.getCmp(
																			'previousButton')
																	.enable();
															
															} else{
																Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				action.result.message);
															}
														},
														failure : function(
																form, action) {
															Ext.MessageBox
																	.alert(
																			systemErrorLabel,
																			action.result.message);
														}
													});
										} else {
											
											Ext.MessageBox.alert(
													systemErrorLabel,
													recordNotFoundLabel);
										}
									}

								},
								{
									text : endButtonLabel,
									name : 'endButton',
									id : 'endButton',
									type : 'button',
									iconCls : 'resultset_last',
									handler : function() {
										Ext.getCmp('newButton').disable();

										if (Ext.getCmp('lastRecord').getValue() == ''
												|| Ext.getCmp('lastRecord')
														.getValue() == undefined) {
											Ext.Ajax
													.request({
														url : "../controller/religionController.php",
														method : "GET",
														params : {
															method : "dataNavigationRequest",
															leafId : leafId,
															dataNavigation : 'lastRecord'
														},
														success : function(
																response,
																options) {

															jsonResponse = Ext
																	.decode(response.responseText);
															if (jsonResponse.success == true) {
																Ext
																		.getCmp(
																				'lastRecord')
																		.setValue(
																				jsonResponse.lastRecord);

																formPanel.form
																		.load({
																			url : "../controller/religionController.php",
																			method : "POST",
																			waitTitle : systemLabel,
																			waitMsg : waitMessageLabel,
																			params : {
																				method : "read",

																				religionId : Ext
																						.getCmp(
																								'lastRecord')
																						.getValue(),
																				leafId : leafId,
																				isAdmin : isAdmin
																			},
																			success : function(
																					form,
																					action) {
																				if(action.result.success==true) { 	
																					if(action.result.previousRecord == 0 ) { 
																						Ext.getCmp('previousButton').disable();
																					} else {
																						Ext.getCmp('previousButton').enable();
																					}
																				Ext
																						.getCmp(
																								'firstRecord')
																						.setValue(
																								action.result.firstRecord);
																				Ext
																						.getCmp(
																								'previousRecord')
																						.setValue(
																								action.result.previousRecord);
																				Ext
																						.getCmp(
																								'nextRecord')
																						.setValue(
																								action.result.nextRecord);
																				Ext
																						.getCmp(
																								'lastRecord')
																						.setValue(
																								action.result.lastRecord);
																				Ext
																						.getCmp(
																								'endRecord')
																						.setValue(
																								(action.result.lastRecord + 1));

																				
																				Ext
																						.getCmp(
																								'nextButton')
																						.disable();
																				Ext
																						.getCmp(
																								'previousButton')
																						.enable();

																				
																				
																				} else {
																					Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				action.result.message);	
																				}
																				
																			},
																			failure : function(
																					form,
																					action) {
																				Ext.MessageBox
																						.alert(
																								systemErrorLabel,
																								action.result.message);
																			}
																		});
															} else {
																Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				jsonResponse.message);
															}
														},
														failure : function(
																response,
																options) {
															Ext.MessageBox
																	.alert(
																			systemErrorLabel,
																			escape(response.status)
																					+ ":"
																					+ escape(response.statusText));
														}
													});
										}
										if (Ext.getCmp('religionId').getValue() <= Ext
												.getCmp('lastRecord')
												.getValue()) {
											formPanel.form
													.load({
														url : "../controller/religionController.php",
														method : "POST",
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : "read",
															religionId : Ext
																	.getCmp(
																			'lastRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {
															if(action.result.success==true) {
															if(action.result.previousRecord == 0 ) { 
																Ext.getCmp('previousButton').disable();
															} else {
																Ext.getCmp('previousButton').enable();
															}
															Ext
																	.getCmp(
																			'firstRecord')
																	.setValue(
																			action.result.firstRecord);
															Ext
																	.getCmp(
																			'previousRecord')
																	.setValue(
																			action.result.previousRecord);
															Ext
																	.getCmp(
																			'nextRecord')
																	.setValue(
																			action.result.nextRecord);
															Ext
																	.getCmp(
																			'lastRecord')
																	.setValue(
																			action.result.lastRecord);
															Ext
																	.getCmp(
																			'endRecord')
																	.setValue(
																			(action.result.lastRecord + 1));

															
															Ext
																	.getCmp(
																			'nextButton')
																	.disable();
															Ext
																	.getCmp(
																			'previousButton')
																	.enable();

															
															} else{
																Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				action.result.message);
															}
															
															
														},
														failure : function(
																form, action) {
															Ext.MessageBox
																	.alert(
																			systemErrorLabel,
																			action.result.message);
														}
													});
										} else {
										
											Ext.MessageBox.alert(
													systemErrorLabel,
													recordNotFoundLabel);
										}
									}
								} ]
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