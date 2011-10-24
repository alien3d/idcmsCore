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
			

			var jsonResponse;
			var duplicate = 0;
			if (leafAccessReadValue == 1) {
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
			var religionProxy = new Ext.data.HttpProxy({
				url : "../controller/religionController.php",
				method : 'POST',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
						// uncomment it for debugging purpose
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
			var religionListProxy = new Ext.data.HttpProxy({
				url : "../controller/religionController.php",
				method : 'POST',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(successLabel, jsonResponse.message); //uncomment for testing
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
			var religionListReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "religionId"
			});
			var religionStoreList = new Ext.data.JsonStore({
				proxy : religionListProxy,
				reader : religionListReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				baseParams : {
					method : "read",
					grid : "master",
					leafId : leafId,
					isAdmin : isAdmin,
					start : 0,
					limit : perPage
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
						// uncomment for testing purpose
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
			var filtersList = new Ext.ux.grid.GridFilters({
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
			var columnModel = [ new Ext.grid.RowNumberer(), {
				dataIndex : "religionDesc",
				header : religionDescLabel,
				sortable : true,
				hidden : false
			}, isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid,
					isDeleteGrid, isActiveGrid, isApprovedGrid, isReviewGrid,
					isPostGrid ];
			var columnModelList = [
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
										var record = religionStore
												.getAt(rowIndex);
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
									icon : '../../javascript/resources/images/icon/trash.gif',
									tooltip : deleteRecordToolTipLabel,
									handler : function(grid, rowIndex, colIndex) {
										var record = religionStore
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
																				title = successLabel;
																			} else {
																				title = failureLabel;
																			}
																			religionStore
																					.reload({
																						params : {
																							leafId : leafId,
																							start : 0,
																							limit : perPage
																						}
																					});
																			religionStoreList
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
						dataIndex : "religionDesc",
						header : religionDescLabel,
						sortable : true,
						hidden : false
					},
					{
						dataIndex : "isDefault",
						header : isDefaultLabel,
						sortable : true,
						hidden : isDefaultHidden,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							if (value == true) {
								return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
							} else if (value == false) {
								return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
							}
						}
					},
					{
						dataIndex : "isNew",
						header : isNewLabel,
						sortable : true,
						hidden : isNewHidden,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							if (value == true) {
								return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
							} else if (value == false) {
								return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
							}
						}
					},
					{
						dataIndex : "isUpdate",
						header : isUpdateLabel,
						sortable : true,
						hidden : isUpdateHidden,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							if (value == true) {
								return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
							} else if (value == false) {
								return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
							}
						}
					},
					{
						dataIndex : "isDelete",
						header : isDeleteLabel,
						sortable : true,
						hidden : isDeleteHidden,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							if (value == true) {
								return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
							} else if (value == false) {
								return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
							}
						}
					},
					{
						dataIndex : "isActive",
						header : isActiveLabel,
						sortable : true,
						hidden : isActiveHidden,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							if (value == true) {
								return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
							} else if (value == false) {
								return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
							}
						}
					},
					{
						dataIndex : "isApproved",
						header : isApprovedLabel,
						sortable : true,
						hidden : isApprovedHidden,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							if (value == true) {
								return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
							} else if (value == false) {
								return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
							}
						}
					},
					{
						dataIndex : "isReview",
						header : isReviewLabel,
						sortable : true,
						hidden : isReviewHidden,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							if (value == true) {
								return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
							} else if (value == false) {
								return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
							}
						}
					},
					{
						dataIndex : "isPost",
						header : isPostLabel,
						sortable : true,
						hidden : isPostHidden,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							if (value == true) {
								return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
							} else if (value == false) {
								return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
							}
						}
					},
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
							return Ext.util.Format.date(value, 'Y-m-d H:i:s');
						}
					} ];
			var accessArray = [ 'isDefault', 'isNew', 'isDraft', 'isUpdate',
					'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost' ];
			var religionGrid = new Ext.grid.GridPanel(
					{
						border : false,
						store : religionStore,
						autoHeight : false,
						height : 400,
						columns : columnModel,
						plugins : [ filters ],
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
												url = url + sub_url; // reques
												// and
												// ajax
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
			var religionGridList = new Ext.grid.GridPanel({
				border : false,
				store : religionStoreList,
				autoHeight : false,
				height : 400,
				columns : columnModelList,
				loadMask : true,
				plugins : [ filtersList ],
				sm : new Ext.grid.RowSelectionModel({
					singleSelect : true
				}),
				viewConfig : {
					emptyText : emptyTextLabel
				},
				iconCls : "application_view_detail",
				listeners : {
					'rowclick' : function(object, rowIndex, e) {
						var record = religionStoreList.getAt(rowIndex);
						formPanel.getForm().reset();
						formPanel.form.load({
							url : "../controller/religionController.php",
							method : "POST",
							waitTitle : systemLabel,
							waitMsg : waitMessageLabel,
							params : {
								method : "read",
								mode : "update",
								religionId : record.data.religionId,
								leafId : leafId
							},
							success : function(form, action) {
								Ext.getCmp("religionDesc_temp").setValue(
										record.data.religionDesc);
								viewPort.items.get(1).expand();
							},
							failure : function(form, action) {
								Ext.MessageBox.alert(systemErrorLabel,
										action.result.message);
							}
						});
					}
				},
				bbar : new Ext.PagingToolbar({
					store : religionStoreList,
					pageSize : perPage
				})
			});
			var toolbarPanel = new Ext.Toolbar(
					{
						items : [
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
													url : "../controller/religionController.php?method=report&mode=excel&limit="
															+ perPage
															+ "&leafId="
															+ leafId,
													method : "GET",
													success : function(
															response, options) {
														jsonResponse = Ext
																.decode(response.responseText);
														if (jsonResponse.success == true) {
															window
																	.open("../../setting/document/excel/"
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
								} ]
					});
			var toolbarPanelList = new Ext.Toolbar(
					{
						items : [
								{
									text : reloadToolbarLabel,
									iconCls : "database_refresh",
									id : "pageReloadList",
									disabled : pageReloadList,
									handler : function() {
										religionStoreList.reload();
									}
								},
								{
									text : addToolbarLabel,
									iconCls : "add",
									id : "pageCreateList",
									disabled : pageCreateList,
									handler : function() {
										viewPort.items.get(1).expand();
										win.hide();
									}
								},
								{
									text : excelToolbarLabel,
									iconCls : "page_excel",
									id : "page_excelList",
									disabled : pagePrintList,
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
																			systemLabel,
																			jsonResponse.message);
														}
													},
													failure : function(
															response, options) {
														Ext.MessageBox
																.alert(
																		systemLabel,
																		escape(response.status)
																				+ ":"
																				+ escape(response.statusText));
													}
												});
									}
								} ]
					});
			var gridPanel = new Ext.Panel(
					{
						title : leafEnglish,
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
						name :"formPanel",
						id : "formPanel",
						method : "post",
						frame : true,
						title : leafEnglish,
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
									items : [ isDefault, isNew, isDraft,
											isUpdate, isDelete, isActive,
											isApproved, isReview, isPost ]
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
									id : 'saveButton',
									text : saveButtonLabel,
									iconCls : "bullet_disk",
									handler : function() {
										if (formPanel.getForm().isValid()) {
											var id = 0;
											id = Ext.getCmp('religionId')
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
																waitTitle : waitTitleLabel,
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
																					successLabel,
																					action.result.message);
																	Ext
																			.getCmp(
																					'religionId')
																			.setValue(
																					action.result.religionId);
																	formPanel
																			.getForm()
																			.reset();
																	religionStore
																			.reload();
																	religionStoreList
																			.reload();
																},
																failure : function(
																		form,
																		action) {
																	if (duplicate == 1) {
																		Ext.MessageBox
																				.alert(
																						systemErrorLabel,
																						duplicateMessageLabel);
																	}
																	if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																		Ext.Msg.alert(systemErrorLabel,loadFailureLabel);
																	} else {
																		if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
																			Ext.Msg.alert(systemErrorLabel,clientInvalidLabel);
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
									id : 'deleteButton',
									text : 'Delete',
									type : 'button',
									iconCls : 'trash',
									disabled : true,
									handler : function() {
										alert('please delete me');
									}
								}, {
									id : 'newButton',
									text : newButtonLabel,
									type : "button",
									iconCls : "add",
									handler : function() {
										formPanel.getForm().reset();
									}
								}, {
									id : 'resetButton',
									text : resetButtonLabel,
									type : "reset",
									iconCls : "table_refresh",
									handler : function() {
										formPanel.getForm().reset();
									}
								}, {
									id : 'listButton',
									text : gridButtonLabel,
									type : "button",
									iconCls : "table",
									handler : function() {
										if (win) {
											win.show().center();
										}
									}
								}, {
									id : 'cancelButton',
									text : cancelButtonLabel,
									type : "button",
									iconCls : "delete",
									handler : function() {
										if (win) {
											win.hide();
										}
										formPanel.getForm().reset();
										religionStore.reload();
										viewPort.items.get(0).expand();
									}
								} ]
					});
			var win = new Ext.Window({
				tbar : toolbarPanelList,
				items : [ religionGridList ],
				title : leafEnglish,
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