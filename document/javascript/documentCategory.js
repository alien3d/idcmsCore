Ext
		.onReady(function() {
			Ext.QuickTips.init();
			Ext.form.Field.prototype.msgTarget = 'under';
			var pageCreate;
			var pageCreateList;
			var pageReload;
			var pageReloadList;
			var pagePrint;
			var pagePrintList;
			var duplicate = 0; // bypassing the extjs bugs
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
			Ext.BLANK_IMAGE_URL = '../javascript/resources/images/s.gif';
			var perPage = 10;
			var encode = false;
			var local = false;

			var documentCategoryProxy = new Ext.data.HttpProxy({
				url : "../controller/documentController.php",
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
				pruneModifiedRecords : true,
				method : 'POST',
				baseParams : {
					method : "read",
					page : "master",
					leafId : leafId
				},
				root : "data",
				fields : [ {
					name : 'documentId',
					type : 'int'
				}, {
					name : 'documentCategoryTitle',
					type : 'int'
				}, {
					name : 'documentCategoryDesc',
					type : 'string'
				}, {
					name : 'documentDesc',
					type : 'string'
				}, {
					name : 'documentExtension',
					type : 'string'
				}, {
					name : 'documentCategoryTitle',
					type : 'string'
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
						if (serverMessage.success == false) {
							Ext.MessageBox
									.alert("Error", serverMessage.message);
						}
					}
				}
			});

			var staffByProxy = new Ext.data.HttpProxy({
				url : "../controller/documentCategoryController.php?",
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

			var filters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : false,
				filters : [ {
					type : 'string',
					dataIndex : 'documentCategoryTitle',
					column : 'documentCategoryTitle',
					table : 'doc_cat'
				}, {
					type : 'string',
					dataIndex : 'Nleaf',
					column : 'leafNote',
					table : 'leaf'
				} ]
			});

			var filtersList = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : false,
				filters : [ {
					type : 'string',
					dataIndex : 'documentCategoryTitle',
					column : 'documentCategoryTitle',
					table : 'doc_cat'
				}, {
					type : 'string',
					dataIndex : 'Nleaf',
					column : 'leafNote',
					table : 'leaf'
				} ]
			});

			var columnModel = [
					new Ext.grid.RowNumberer(),{
				        id: 'action',
				        header: 'Task',
				        xtype: 'actioncolumn',
				        width: 50,
				        items: [{
				            icon: '../../javascript/resources/images/icon/application_edit.png',
				            tooltip: updateRecordToolTipLabel,
				            handler: function(grid, rowIndex, colIndex) {
				                var record = documentCategoryStore.getAt(rowIndex);
				                formPanel.getForm().reset();
				                formPanel.form.load({
				                    url: "../controller/documentCategoryController.php",
				                    method: "POST",
				                    waitTitle: systemLabel,
				                    waitMsg: waitMessageLabel,
				                    params: {
				                        method: "read",
				                        mode: "update",
				                        documentCategoryId: record.data.documentCategoryId,
				                        leafId: leafId
				                    },
				                    success: function(form, action) {
				                        Ext.getCmp("documentCategoryDesc_temp").setValue(record.data.documentCategoryDesc);
				                        Ext.getCmp('deleteButton').enable();
				                        viewPort.items.get(1).expand();
				                    },
				                    failure: function(form, action) {
				                        Ext.MessageBox.alert(systemErrorLabel, action.result.message);
				                    }
				                });
				                win.hide();
				            }
				        },
				        {
				            icon: '../../javascript/resources/images/icon/trash.gif',
				            tooltip: deleteRecordToolTipLabel,
				            handler: function(grid, rowIndex, colIndex) {
				                var record = documentCategoryStore.getAt(rowIndex);
				                Ext.Msg.show({
				                    title: deleteRecordTitleMessageLabel,
				                    msg: deleteRecordMessageLabel,
				                    icon: Ext.Msg.QUESTION,
				                    buttons: Ext.Msg.YESNO,
				                    scope: this,
				                    fn: function(response) {
				                        if ("yes" == response) {
				                            Ext.Ajax.request({
				                                url: "../controller/documentCategoryController.php",
				                                params: {
				                                    method: "delete",
				                                    documentCategoryId: record.data.documentCategoryId,
				                                    leafId: leafId
				                                },
				                                success: function(response, options) {
				                                    jsonResponse = Ext.decode(response.responseText);
				                                    if (jsonResponse.success == true) {
				                                        title = successLabel;
				                                    } else {
				                                        title = failureLabel;
				                                    }
				                                    documentCategoryStore.reload({
				                                        params: {
				                                            leafId: leafId,
				                                            start: 0,
				                                            limit: perPage
				                                        }
				                                    });
				                                    documentCategoryStoreList.reload({
				                                        params: {
				                                            leafId: leafId,
				                                            start: 0,
				                                            limit: perPage
				                                        }
				                                    });
				                                    Ext.MessageBox.alert(systemErrorLabel,
																	jsonResponse.message);
				                                },
				                                failure: function(response, options) {
				                                    Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + response.statusText);
				                                }
				                            });
				                        }
				                    }
				                });
				            }
				        }]
				    },
					{
						dataIndex : 'documentCategoryTitle',
						header : documentCategoryTitleLabel,
						sortable : true,
						hidden : false
					},
					{
						dataIndex : 'documentCategoryDesc',
						header : documentCategoryDescLabel,
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
					{
						dataIndex : "By",
						header : byLabel,
						sortable : true,
						hidden : false,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return record.data.staffName;
						}
					},
					{
						dataIndex : "Time",
						header : timeLabel,
						sortable : true,
						hidden : false,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return Ext.util.Format.date(value, 'd-m-Y H:i:s');
						}
					} ];
			
			var accessArray = [ 'isDefault', 'isNew', 'isDraft', 'isUpdate',
								'isDelete', 'isActive', 'isApproved' ];

			var grid = new Ext.grid.GridPanel(
					{
						border : false,
						store : store,
						autoHeight : false,
						height : 450,
						columns : columnModel,
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
											var e = new documentCategoryEntity(
													{
														documentCategoryId : '',
														documentCategoryDesc : '',
														By : '',
														staffName : '',
														isDefault : '',
														isNew : '',
														isDraft : '',
														isUpdate : '',
														isDelete : '',
														isActive : '',
														isApproved : '',
														Time : ''
													});
											documentCategoryEditor
													.stopEditing();
											documentCategoryStore.insert(0, e);
											var s = documentCategoryGrid
													.getSelectionModel()
													.getSelections();
											documentCategoryEditor
													.startEditing(0);
										}
									},
									{
										text : 'Check All',
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												var count = documentCategoryStore
														.getCount();
												documentCategoryStore
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
												documentCategoryStore
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
												var count = documentCategoryStore
														.getCount();
												url = '../controller/documentCategoryController.php?';
												var sub_url;
												sub_url = '';

												var modified = documentCategoryStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = documentCategoryStore
															.getAt(i);

													if (record
															.get('documentCategoryId')) {
														sub_url = sub_url
																+ '&documentCategoryId[]='
																+ record
																		.get('documentCategoryId');
													} else {
														alert("testing for error"
																+ i)
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
													}
												}
												url = url + sub_url; // reques
																		// and
																		// ajax

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
																	documentCategoryStore
																			.removeAll(); // force
																							// to
																							// remove
																							// all
																							// data
																	documentCategoryStore
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
							store : documentCategoryStore,
							pageSize : perPage
						})
					});

			var toolbarPanel = new Ext.Toolbar(
					{
						items : [
								{
									text : 'Reload',
									iconCls : 'database_refresh',
									id : 'pageReload',
									disabled : pageReload,
									handler : function() {
										store.reload();
									}
								},
								{
									text : 'Rekod Baru',
									iconCls : 'add',
									id : 'pageCreate',
									disabled : pageCreate,
									handler : function() {
										viewPort.items.get(1).expand();
									}
								},
								{
									text : 'Printer',
									iconCls : 'printer',
									id : 'pagePrinter',
									disabled : pagePrint,
									handler : function() {
										Ext.ux.GridPrinter.print(grid);
									}
								},
								{
									text : 'Word',
									iconCls : 'page_word',
									id : 'page_word',
									disabled : pagePrint,
									handler : function() {
										// testing filter by grid

										Ext.Ajax
												.request({
													url : '../controller/documentCategoryController.php?method=report&mode=word&limit='
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
																	.open("../document/document/word/doc_cat.docx");
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
														Ext.MessageBox
																.alert(
																		systemLabel,
																		escape(status_code)
																				+ ":"
																				+ status_message);
													}

												});

									}
								},
								{
									text : 'Excel',
									iconCls : 'page_excel',
									id : 'page_excel',
									disabled : pagePrint,
									handler : function() {
										Ext.Ajax
												.request({
													url : '../controller/documentCategoryController.php?method=report&mode=excel&limit='
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
																	.open("../document/document/excel/doc_cat.xlsx");
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
														Ext.MessageBox
																.alert(
																		systemLabel,
																		escape(status_code)
																				+ ":"
																				+ status_message);
													}

												});
									}
								},
								{
									text : 'PDF',
									iconCls : 'page_white_acrobat',
									id : 'page_white_acrobat',
									disabled : pagePrint,
									handler : function() {
										window.location
												.replace('../controller/documentCategoryController.php?method=report&mode=pdf&limit='
														+ perPage
														+ '&leafId='
														+ leafId);
									}
								} ]
					});

			var gridPanel = new Ext.Panel({
				title : 'Senarai ' + leafNote,
				height : 50,
				layout : 'fit',
				iconCls : 'application_view_detail',
				tbar : [ toolbarPanel ],
				items : [ grid ]
			});

			var leafF = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : 'Leaf ID <span style="color: red;">*</span>',
				name : 'leafId',
				valueField : 'leafId',
				hiddenName : 'leafId',
				id : 'leaf',
				displayField : 'leafN',
				typeAhead : false,
				emptyText : 'Sila Pilih Leaf ID',
				triggerAction : 'all',
				mode : 'local',
				store : leaf_store,
				anchor : '95%',
				selectOnFocus : true,
				allowBlank : false,
				blankText : 'Sila Pilih Dokument ID',
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

			var documentCategoryTitle = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : 'Penerangan',
				hiddenName : 'Nama',
				name : 'documentCategoryTitle',
				allowBlank : false,
				blankText : 'Sila isi Nama',
				anchor : '95%'
			});

			var documentCategoryId = new Ext.form.Hidden({
				name : 'documentCategoryId',
				id : 'documentCategoryId'
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
						url : '../controller/documentCategoryController.php',
						id : 'formPanel',
						method : 'post',
						frame : true,
						title : 'Borang ' + leafNote,
						border : false,
						bodyStyle : 'padding:5px',
						width : 600,
						items : [ documentCategoryId, leafF,
								documentCategoryTitle ],
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
									text : 'Save',
									iconCls : 'bullet_disk',
									handler : function() {
										if (formPanel.getForm().isValid()) {
											var id = 0;
											id = Ext.getCmp(
													'documentCategoryId')
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
																waitMsg : 'Saving',
																params : {
																	method : method,
																	leafId : leafId
																},
																success : function(
																		form,
																		action) {
																	var title = 'Message Successfull';
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
																	// be
																	// separate
																	// to avoid
																	// other
																	// error
																	var title = 'Message Failure';
																	if (duplicate == 1) {
																		Ext.MessageBox
																				.alert(
																						title,
																						duplicateMsg);
																	}

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
									text : 'Rekod Baru',
									type : 'button',
									iconCls : 'add',
									handler : function() {
										formPanel.getForm().reset();
									}
								}, {
									text : 'Reset',
									type : 'reset',
									iconCls : 'table_refresh',
									handler : function() {
										formPanel.getForm().reset();
									}
								}, {
									text : 'Senarai',
									type : 'button',
									iconCls : 'table',
									handler : function() {
										if (win) {
											win.show().center();
										}
									}
								}, {
									text : 'Cancel',
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
				items : [ gridPanel, formPanel ]
			});
		});
