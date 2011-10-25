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
			
			
			var staffProxy = new Ext.data.HttpProxy({
				url : "../controller/staffController.php",
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
				root : "data",
				fields : [ {
					name : 'staffId',
					type : 'int'
				}, {
					name : 'teamId',
					type : 'int'
				}, {
					name : 'departmentId',
					type : 'int'
				}, {
					name : 'teamName',
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
					name : "isReview",
					type : "int"
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
				url : "../controller/staffController.php?",
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

			var teamProxy = new Ext.data.HttpProxy({
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

			var teamReader = new Ext.data.JsonReader({

				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "teamId"

			});

			var teamStore = new Ext.data.JsonStore({
				proxy : teamProxy,
				reader : teamReader,
				autoLoad : true,
				autoDestroy : true,
				baseParams : {
					method : 'read',
					field : 'team',
					leafId : leafId
				},
				root : 'team',
				fields : [ {
					name : "teamId",
					type : "int"
				}, {
					name : "teamNative",
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
					name : "departmentNative",
					type : "string"
				} ]
			});

			var staffFilters = new Ext.ux.grid.GridFilters({
				encode : encode, 
				local : local, 
				filters : [ {
					type : 'list',
					dataIndex : 'teamId',
					column : 'teamId',
					table : 'staff',
					labelField : 'teamEnglish',
					store : teamStore,
					phpMode : true
				}, {
					type : 'list',
					dataIndex : 'departmentId',
					column : 'departmentId',
					table : 'staff',
					labelField : 'departmentNote',
					store : departmentStore,
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
					dataIndex : 'executeBy',
					column : 'executeBy',
					table : 'staff',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'staff'
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
				dataIndex : 'isActive',
				hidden : isActiveHidden
			});
			var isPostGrid = new Ext.ux.grid.CheckColumn({
				header : isApprovedLabel,
				dataIndex : 'isApproved',
				hidden : isApprovedHidden
			});

			var staffColumnModel = [
					new Ext.grid.RowNumberer(),
					{
						dataIndex : 'teamId',
						header : teamEnglishLabel,
						hidden : false,
						sortable : true,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return record.data.teamEnglish;
						}
					},
					{
						dataIndex : 'departmentId',
						header : departmentNoteLabel,
						hidden : false,
						sortable : true,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return record.data.departmentNote;
						}
					},
					{
						dataIndex : 'staffName',
						header : staffNameLabel,
						hidden : false,
						sortable : true
					},
					{
						dataIndex : 'staffIc',
						header : staffIcLabel,
						hidden : false,
						sortable : true
					},
					{
						dataIndex : 'staffNo',
						header : staffNoLabel,
						hidden : false,
						sortable : true
					},
					isDefaultGrid,
					isNewGrid,
					isDraftGrid,
					isUpdateGrid,
					isDeleteGrid,
					isActiveGrid,
					isApprovedGrid,
					isReviewGrid,
					isPostGrid,
					{
						dataIndex : "executeBy",
						header : executeByLabel,
						sortable : true,
						hidden : false,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return record.data.staffName;
						}
					},
					{
						dataIndex : "executeTime",
						header : executeTimeLabel,
						sortable : true,
						hidden : false,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return Ext.util.Format.date(value, 'd-m-Y H:i:s');
						}
					} ];

			var accessArray = [ 'isDefault', 'isNew', 'isDraft', 'isUpdate',
					'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost' ];

			var staffGrid = new Ext.grid.GridPanel(
					{
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
						iconCls : 'application_view_detail',
						listeners : {
							'rowclick' : function(object, rowIndex, e) {
								var record = staffStore.getAt(rowIndex);
								formPanel.getForm().reset();
								formPanel.form
										.load({
											url : "../controller/staffController.php",
											method : "POST",
											waitTitle : systemLabel,
											waitMsg : waitMessageLabel,
											params : {
												method : "read",

												staffId : record.data.staffId,
												leafId : leafId,
												isAdmin : isAdmin
											},
											success : function(form, action) {
												if (action.result.firstRecord > 0) {
													Ext.getCmp('firstButton')
															.enable();
													Ext
															.getCmp(
																	'firstRecord')
															.setValue(
																	action.result.firstRecord);
												} else {
													Ext.getCmp('firstButton')
															.disable();
												}
												// alert("testing"+action.result.nextRecord);
												if (action.result.nextRecord > 0) {
													Ext.getCmp('nextButton')
															.enable();
													Ext
															.getCmp(
																	'nextRecord')
															.setValue(
																	action.result.nextRecord);
												} else {

													Ext.getCmp('nextButton')
															.disable();

												}
												if (action.result.previousRecord > 0) {
													Ext
															.getCmp(
																	'previousButton')
															.enable();
													Ext
															.getCmp(
																	'previousRecord')
															.setValue(
																	action.result.previousRecord);
												} else {
													Ext
															.getCmp(
																	'previousButton')
															.disable();
												}
												if (action.result.firstRecord > 0) {
													Ext.getCmp('endButton')
															.enable();
													Ext
															.getCmp(
																	'lastRecord')
															.setValue(
																	action.result.lastRecord);
												} else {
													Ext.getCmp('lastRecord')
															.disable();
												}
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
										iconCls : 'add',
										id : 'add_record',
										name : 'add_record',
										text : newButtonLabel,
										handler : function() {
											formPanel.getForm().reset();
											viewPort.items.get(1).expand();
										}
									},
									{
										text : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												staffStore
														.each(function(rec) {
															for ( var access in accessArray) { // alert(access);
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
										text:ClearAllLabel,
										iconCls : 'row-check-sprite-uncheck',
										listeners : {
											'click' : function() {
												staffStore
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
												url = '../controller/staffController.php?';
												var sub_url;
												sub_url = '';

												var modified = staffStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = staffStore
															.getAt(i);

													if (record.get('staffId')) {
														sub_url = sub_url
																+ '&staffId[]='
																+ record
																		.get('staffId');
													} else {
														alert("testing for error"
																+ i);
													}
													if (isAdmin == 1) {
														sub_url = sub_url
																+ '&isDefault[]='
																+ record
																		.get('isDefault');
														sub_url = sub_url
																+ '&isNew[]='
																+ record
																		.get('isNew');
														sub_url = sub_url
																+ '&isDraft[]='
																+ record
																		.get('isDraft');
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
																method : 'updateStatus',
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
																	staffStore
																			.removeAll(); 
																
																	staffStore
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
							store : staffStore,
							pageSize : perPage
						})
					});

			var gridPanel = new Ext.Panel(
					{
						title : leafEnglish,
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
										staffStore.reload();
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
													url : "../controller/teamController.php",
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
									store : staffStore,
									width : 320
								}) ],
						items : [ staffGrid ]
					});

			// viewport just save information,items will do separate
			var teamId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : teamIdLabel,
				name : 'teamId',
				hiddenName : 'teamId',
				valueField : 'teamId',
				id : 'team_fake',
				displayField : 'teamEnglish',
				typeAhead : false,
				triggerAction : 'all',
				store : teamStore,
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
				displayField : 'departmentNote',
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
				allowBlank : true,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			var staffNo = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : staffNoLabel,
				hiddenName : 'staffNo',
				name : 'staffNo',
				allowBlank : true,
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
				name : 'staffId',
				id : 'staffId'
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
						
						url : '../controller/staffController.php',
						name :'formPanel',
						id : 'formPanel',
						method : 'post',
						frame : true,
						title : leafEnglish,
						border : false,

						width : 600,
						items : [ teamId, departmentId, staffId, staffName,
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
										// check teamId field value

										if (!(is_int(Ext.getCmp('team_fake')
												.getValue()))) {
											Ext.getCmp('team_fake')
													.setValue('');
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

																		if (action.result.success == true) {
																			Ext.MessageBox
																					.alert(
																							systemLabel,
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
																			if (action.result.firstRecord > 0) {
																				Ext
																						.getCmp(
																								'firstButton')
																						.enable();
																				Ext
																						.getCmp(
																								'firstRecord')
																						.setValue(
																								action.result.firstRecord);
																			} else {
																				Ext
																						.getCmp(
																								'firstButton')
																						.disable();
																			}

																			if (action.result.nextRecord > 0) {
																				Ext
																						.getCmp(
																								'nextButton')
																						.enable();
																				Ext
																						.getCmp(
																								'nextRecord')
																						.setValue(
																								action.result.nextRecord);
																			} else {

																				Ext
																						.getCmp(
																								'nextButton')
																						.disable();

																			}
																			if (action.result.previousRecord > 0) {
																				Ext
																						.getCmp(
																								'previousButton')
																						.enable();
																				Ext
																						.getCmp(
																								'previousRecord')
																						.setValue(
																								action.result.previousRecord);
																			} else {
																				Ext
																						.getCmp(
																								'previousButton')
																						.disable();
																			}
																			if (action.result.firstRecord > 0) {
																				Ext
																						.getCmp(
																								'endButton')
																						.enable();
																				Ext
																						.getCmp(
																								'lastRecord')
																						.setValue(
																								action.result.lastRecord);
																			} else {
																				Ext
																						.getCmp(
																								'endButton')
																						.disable();
																			}
																			viewPort.items
																					.get(
																							0)
																					.expand();
																		} else {

																			alert(action.result.message);
																		}
																	},
																	failure : function(
																			form,
																			action) {

																		if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																			Ext.Msg.alert(systemErrorLabel,loadFailureLabel);
																		} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
																	
																			Ext.Msg.alert(systemErrorLabel,clientInvalidLabel);
																		} else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
																			Ext.Msg
																					.alert(connectFailureLabel
																							+ form.response.status
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
										}
									}
								},
								{
									text : newButtonLabel,
									type : 'button',
									iconCls : 'new',
									handler : function() {
										formPanel.getForm().reset();
										viewPort.items.get(1).expand();
									}
								},
								{
									text : draftButtonLabel,
									type : 'button',
									iconCls : 'page_white',
									handler : function() {
										formPanel.getForm().reset();
									}
								},
								{
									text : cancelButtonLabel,
									type : 'button',
									iconCls : 'cancel',
									handler : function() {
										formPanel.getForm().reset();
									}
								},
								{
									text : deleteButtonLabel,
									type : 'button',
									iconCls : 'trash',
									handler : function() {
										formPanel.getForm().reset();
									}
								},
								{
									text : resetButtonLabel,
									type : 'reset',
									iconCls : 'arrow_refresh',
									handler : function() {
										formPanel.getForm().reset();
									}
								},
								{
									text : gridButtonLabel,
									type : 'button',
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

										formPanel.form
												.load({
													url : "../controller/staffController.php",
													method : "POST",
													waitTitle : systemLabel,
													waitMsg : waitMessageLabel,
													params : {
														method : "read",

														staffId : Ext.getCmp(
																'firstRecord')
																.getValue(),
														leafId : leafId,
														isAdmin : isAdmin
													},
													success : function(form,
															action) {

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
									text : previousButtonLabel,
									name : 'previousButton',
									id : 'previousButton',
									type : 'button',
									iconCls : 'resultset_previous',
									handler : function() {
										if (Ext.getCmp('firstRecord')
												.getValue() >= 1) {
											formPanel.form
													.load({
														url : "../controller/staffController.php",
														method : "POST",
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : "read",

															staffId : Ext
																	.getCmp(
																			'previousRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {

															viewPort.items.get(
																	1).expand();
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
											// empty record
											Ext.MessageBox.alert(
													systemErrorLabel,
													'Record Not Found');
										}
									}
								},
								{
									text : nextButtonLabel,
									name : 'nextButton',
									id : 'nextButton',
									type : 'button',
									iconCls : 'resultset_next',
									handler : function() {
										if (Ext.getCmp('nextRecord').getValue() <= Ext
												.getCmp('lastRecord')
												.getValue()) {
											formPanel.form
													.load({
														url : "../controller/staffController.php",
														method : "POST",
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : "read",

															staffId : Ext
																	.getCmp(
																			'nextRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {

															viewPort.items.get(
																	1).expand();
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
											// empty record
											Ext.MessageBox.alert(
													systemErrorLabel,
													'Record Not Found');
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
										if (Ext.getCmp('endRecord').getValue() <= Ext
												.getCmp('lastRecord')
												.getValue()) {
											formPanel.form
													.load({
														url : "../controller/staffController.php",
														method : "POST",
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : "read",

															staffId : Ext
																	.getCmp(
																			'lastRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {

															viewPort.items.get(
																	1).expand();
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
											// empty record
											Ext.MessageBox.alert(
													systemErrorLabel,
													'Record Not Found');
										}
									}
								} ]
					});

			
			var auditWindow = new Ext.Window({
				name :'auditWindow',
				id:'auditWindow',
				layout : 'fit',
				width : 500,
				height : 300,
				closeAction : 'hide',
				plain : true,
				items : {
					xtype : 'tabpanel',
					activeTab : 0,
					items : [ {
						xtype : 'panel',
						layout : "fit",
						title : 'Log Sql Statement',
						items : [ logGrid ]
					}, {
						xtype : 'panel',
						layout : "fit",
						title : 'Log Sql Statement',
						items : [ logAdvanceGrid ]
					} ]

				},
				title : 'Sql Statement audit',
				maximizable : true,
				autoScroll : true
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
