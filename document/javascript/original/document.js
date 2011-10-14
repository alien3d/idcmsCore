Ext
		.onReady(function() {
			Ext.QuickTips.init();
			Ext.BLANK_IMAGE_URL = "../../javascript/resources/images/s.gif";
			Ext.form.Field.prototype.msgTarget = 'under';
			var pageCreate;
			var pageCreateList;
			var pageReload;
			var pageReloadList;
			var pagePrint;
			var pagePrintList;
			var duplicate = 0; // bypassing the extjs bugs
			if (leafAccessCreateValue == 1) {
				pageCreate = false;
				pageCreateList = false;
			} else {
				pageCreate = true;
				pageCreateList = true;
			}
			if (leafAccessReadValue == 1) {
				pageReload = false;
				pageReloadList = false;
			} else {
				pageReload = true;
				pageReloadList = true;
			}
			if (leafAccessPrintValue == 1) {
				pagePrint = false;
				pagePrintList = false;
			} else {
				pagePrint = true;
				pagePrintList = true;
			}

			var perPage = 10;
			var encode = false;
			var local = false;

			var documentProxy = new Ext.data.HttpProxy({
				url : "../controller/documentController.php",
				method : 'POST',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
					} else {
						Ext.MessageBox.alert(systemErrorLabel + "kk",
								jsonResponse.message);
					}
				},
				failure : function(response, options) {
					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ":"
									+ escape(response.statusText));
				}
			});

			var documentReader = new Ext.data.JsonReader({

				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "documentId"

			});

			var documentStore = new Ext.data.JsonStore({
				proxy : documentProxy,
				reader : documentReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				method : 'POST',
				baseParams : {
					method : "read",
					leafId : leafId
				},
				root : "data",
				fields : [ {
					name : 'documentId',
					type : 'int'
				}, {
					name : 'documentCategoryId',
					type : 'int'
				}, {
					name : 'documentTitle',
					type : 'string'
				}, {
					name : 'documentDesc',
					type : 'string'
				}, {
					name : 'documentPath',
					type : 'string'
				}, {
					name : 'documentOriginalFilename',
					type : 'string'
				}, {
					name : 'documentDownloadFilename',
					type : 'string'
				}, {
					name : 'documentExtension',
					type : 'string'
				}, {
					name : 'documentVersion',
					type : 'string'
				}, {
					name : 'executeBy',
					type : 'int'
				}, {
					name : 'executeTime',
					type : 'date',
					dateFormat : 'Y-m-d H:i:s'
				} ]
			});

			var staffByProxy = new Ext.data.HttpProxy({
				url : "../controller/documentController.php?",
				method : "GET",
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(successLabel,jsonResponse.message);
						// uncommen for testing purpose
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

			var documentCategoryProxy = new Ext.data.HttpProxy({
				url : "../controller/documentController.php",
				method : 'GET',
				params : {
					mode : 'read',
					field : 'documentCategoryId',
					leafId : leafId
				},
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
			var documentCategoryReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "documentCategoryId"
			});

			var documentCategoryStore = new Ext.data.JsonStore({
				proxy : documentCategoryProxy,
				reader : documentCategoryReader,
				autoLoad : true,
				autoDestroy : true,
				baseParams : {
					method : 'read',
					field : 'documentCategoryId',
					leafId : leafId
				},
				root : 'documentCategory',
				fields : [ {
					name : "documentCategoryId",
					type : "int"
				}, {
					name : "documentCategoryTitle",
					type : "string"
				} ]
			});

			var filters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : false,
				filters : [ {
					type : 'string',
					dataIndex : 'documentCategoryTitle',
					column : 'documentCategoryTitle',
					table : 'documentCategory'
				}, {
					type : 'string',
					dataIndex : 'documentTitle',
					column : 'documentTitle',
					table : 'document'
				}, {
					type : 'string',
					dataIndex : 'documentPath',
					column : 'documentPath',
					table : 'document'
				}, {
					type : 'string',
					dataIndex : 'documentOriginalFilename',
					column : 'documentOriginalFilename',
					table : 'document'
				}, {
					type : 'string',
					dataIndex : 'documentDownloadFilename',
					column : 'documentDownloadFilename'
				}, {
					type : 'string',
					dataIndex : 'documentExtension',
					column : 'documentExtension',
					table : 'document'
				}, {
					type : 'string',
					dataIndex : 'documentVersion',
					column : 'documentVersion',
					table : 'document'
				}, {
					type : 'list',
					dataIndex : 'executeBy',
					column : 'executeBy',
					table : 'document',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'document'
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
				hidden : isReviewHidden
			});
			var isPostGrid = new Ext.ux.grid.CheckColumn({
				header : 'Post',
				dataIndex : 'isPost',
				hidden : isPostHidden
			});

			var documentColumnModel = [
					new Ext.grid.RowNumberer(),
					{
						id : 'action',
						header : 'Task',
						xtype : 'actioncolumn',
						width : 50,
						items : [
								{
									icon : '../../javascript/resources/images/icon/application_edit.png',
									tooltip : updateRecordToolTipLabel,
									handler : function(grid, rowIndex, colIndex) {
										var record = documentStore
												.getAt(rowIndex);
										formPanel.getForm().reset();
										formPanel.form
												.load({
													url : "../controller/documentController.php",
													method : "POST",
													waitTitle : systemLabel,
													waitMsg : waitMessageLabel,
													params : {
														method : "read",
														mode : "update",
														documentId : record.data.documentId,
														leafId : leafId
													},
													success : function(form,
															action) {
														Ext
																.getCmp(
																		"documentDesc_temp")
																.setValue(
																		record.data.documentDesc);
														Ext.getCmp(
																'deleteButton')
																.enable();
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
									icon : '../../javascript/resources/images/icon/trash.gif',
									tooltip : deleteRecordToolTipLabel,
									handler : function(grid, rowIndex, colIndex) {
										var record = documentStore
												.getAt(rowIndex);
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
																		url : "../controller/documentController.php",
																		params : {
																			method : "delete",
																			documentId : record.data.documentId,
																			leafId : leafId
																		},
																		success : function(
																				response,
																				options) {
																			jsonResponse = Ext
																					.decode(response.responseText);
																			if (jsonResponse.success == true) {
																				title = successLabel;
																			} else {
																				title = failureLabel;
																			}
																			documentStore
																					.reload({
																						params : {
																							leafId : leafId,
																							start : 0,
																							limit : perPage
																						}
																					});

																			Ext.MessageBox
																					.alert(
																							systemErrorLabel,
																							jsonResponse.message);
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
								} ]
					},
					{
						dataIndex : 'documentId',
						header : documentIdLabel,
						sortable : true,
						hidden : false
					},
					{
						dataIndex : 'documentTitle',
						header : documentTitleLabel,
						sortable : true,
						hidden : false
					},
					{
						dataIndex : 'documentDesc',
						header : documentDescLabel,
						sortable : true,
						hidden : false
					},
					{
						dataIndex : 'documentPath',
						header : documentPathLabel,
						sortable : true,
						hidden : false
					},

					{
						dataIndex : 'documentOriginalFilename',
						header : documentOriginalFilenameLabel,
						sortable : true,
						hidden : false
					},
					{
						dataIndex : 'documentDownloadFilename',
						header : documentDownloadFilenameLabel,
						sortable : true,
						hidden : false
					},
					{
						dataIndex : 'documentExtension',
						header : documentExtensionLabel,
						sortable : true,
						hidden : false
					},
					{
						dataIndex : 'documentVersion',
						header : documentVersionLabel,
						sortable : true,
						hidden : false
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
			var documentGrid = new Ext.grid.GridPanel(
					{
						border : false,
						store : documentStore,
						autoHeight : false,
						height : 450,
						columns : documentColumnModel,
						loadMask : true,
						plugins : [ filters ],
						sm : new Ext.grid.RowSelectionModel({
							singleSelect : true
						}),
						viewConfig : {
							forceFit : true,
							emptyText : 'No rows to display'
						},
						iconCls : 'application_view_detail',
						tbar : {
							items : [
									{
										iconCls : 'add',
										id : 'add_record',
										name : 'add_record',
										text : 'New Record',
										handler : function() {

										}
									},
									{
										text : 'Check All',
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												var count = documentStore
														.getCount();
												documentStore
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
										text : 'Clear All',
										iconCls : 'row-check-sprite-uncheck',
										listeners : {
											'click' : function() {
												documentStore
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
										text : 'save',
										iconCls : 'bullet_disk',
										listeners : {
											'click' : function(c) {
												var url;
												var count = documentStore
														.getCount();
												url = '../controller/documentController.php?';
												var sub_url;
												sub_url = '';

												var modified = documentStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = documentStore
															.getAt(i);

													if (record
															.get('documentId')) {
														sub_url = sub_url
																+ '&documentId[]='
																+ record
																		.get('documentId');
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
																	documentStore
																			.removeAll();
																	documentStore
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
							store : documentStore,
							pageSize : perPage
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
									text : addToolbarLabel,
									iconCls : 'add',
									id : 'pageCreate',
									disabled : pageCreate,
									handler : function() {
										viewPort.items.get(1).expand();
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
													url : '../controller/documentController.php?method=report&mode=excel&limit='
															+ perPage
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														jsonResponse = Ext
																.decode(response.responseText);
														if (jsonResponse == true) {
															// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
															window
																	.open("../document/document/excel/document.xlsx");
														} else {
															Ext.MessageBox
																	.alert(
																			systemLabel,
																			jsonResponse.message);
														}

													}

												});
									}
								} ]
					});

			var documentCategoryId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : documentCategoryIdLabel
						+ '<span style="color: red;">*</span>',
				name : 'documentCategoryId',
				valueField : 'documentCategoryId',
				hiddenName : 'documentCategoryId',
				id : 'documentCategoryId',
				hiddenId : 'documentCategoryFake',
				displayField : 'documentCategoryTitle',
				typeAhead : false,
				emptyText : emptyTextLabel,
				triggerAction : 'all',
				mode : 'local',
				store : documentCategoryStore,
				anchor : '95%',
				selectOnFocus : true,
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

			var documentCode = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : documentCodeLabel,
				hiddenName : 'documentCode',
				name : 'documentCode',
				allowBlank : false,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			var documentSequence = new Ext.form.NumberField({
				labelAlign : 'left',
				fieldLabel : documentSequenceLabel,
				hiddenName : 'documentSequence',
				name : 'documentSequence',
				allowBlank : false,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			var documentNote = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : documentNoteLabel,
				hiddenName : 'documentDesc',
				name : 'documentDesc',
				allowBlank : false,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			var documentTitle = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : documentTitleLabel,
				hiddenName : 'documentDesc',
				name : 'documentDesc',
				allowBlank : false,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			var documentDesc = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : documentDescLabel,
				hiddenName : 'documentDesc',
				name : 'documentDesc',
				allowBlank : false,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			var documentPath = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : documentPathLabel,
				hiddenName : 'documentPath',
				name : 'documentPath',
				allowBlank : false,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			var documentId = new Ext.form.Hidden({
				name : 'documentId',
				id : 'documentId'
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

			var formPanel = new Ext.FormPanel(
					{
						method : 'POST',
						id : 'formPanel',
						url : '../controller/documentController.php',
						title : leafNote,
						border : false,
						width : 600,
						fileUpload : true,
						frame : true,
						autoheight : true,
						bodyStyle : 'padding: 10px 10px 0 10px;',
						labelWidth : 60,
						buttonVAlign : 'top',
						buttonAlign : 'left',
						defaults : {
							anchor : '95%',
							msgTarget : 'side'
						},
						iconCls : 'application_form',
						bbar : new Ext.ux.StatusBar({
							id : 'form-statusbar',

							defaultText : 'Ready',
							plugins : new Ext.ux.ValidationStatus({
								form : 'formPanel'
							})
						}),
						items : [ documentCategoryId, documentDesc, documentId,
								{
									xtype : 'fileuploadfield',
									id : 'form-file',
									fieldLabel : documentFilenameLabel,
									name : 'documentFilename',
									id : 'documentFilename',
									allowBlank : false,
									blankText : blankTextLabel,
									buttonCfg : {
										text : '',
										iconCls : 'bullet_disk'
									}
								} ],
						buttons : [
								{
									text : uploadButtonLabel,
									iconCls : 'bullet_disk',
									handler : function() {

										if (formPanel.getForm().isValid()) {
											var id = 0;
											id = Ext.getCmp('documentId')
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
																waitTitle : waitMessageLabel,
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
																		documentStore
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
																						systemErrorLabel,
																						action.result.message);
																	}
																}
															});
										}
									}

								}, {
									text : newButtonLabel,
									type : 'button',
									iconCls : 'add',
									handler : function() {
										formPanel.getForm().reset();
									}
								}, {
									text : resetButtonLabel,
									type : 'reset',
									iconCls : 'table_refresh',
									handler : function() {
										formPanel.getForm().reset();
									}
								}, {
									text : gridButtonLabel,
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

			var viewPort = new Ext.Viewport({
				id : 'viewport',
				region : 'center',
				layout : 'accordion',
				layoutConfig : {
					titleCollapse : true,
					animate : false,
					activeOnTop : true
				},
				items : [ documentGrid, formPanel ]
			});
		});