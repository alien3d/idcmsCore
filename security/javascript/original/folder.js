Ext
		.onReady(function() {
			Ext.QuickTips.init();
			Ext.form.Field.prototype.msgTarget = "under";
			Ext.Ajax.timeout = 90000;
			Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';

			var pageCreate;
			var pageReload;
			var pagePrint;
			var perPage = 10;
			var encode = false;
			var local = false;
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

			var folderProxy = new Ext.data.HttpProxy({
				url : "../controller/folderController.php",
				method : "POST",
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

			var folderReader = new Ext.data.JsonReader({

				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "folderId"

			});
			var folderStore = new Ext.data.JsonStore({
				proxy : folderProxy,
				reader : folderReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,

				baseParams : {
					method : "read",
					isAdmin : isAdmin,
					leafId : leafId
				},
				root : "data",
				fields : [ {
					name : 'folderId',
					type : 'int'
				}, {
					name : 'folderSequence',
					type : 'int'
				}, {
					name : 'moduleId',
					type : 'int'
				}, {
					name : 'moduleEnglish',
					type : 'string'
				}, {
					name : 'folderEnglish',
					type : 'string'
				}, {
					name : 'folderPath',
					type : 'string'
				}, {
					name : 'iconId',
					type : 'int'
				}, {
					name : 'iconName',
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
					name : "executeTime",
					type : "date",
					dateFormat : "Y-m-d H:i:s"
				} ]
			});

			var folderTranslateProxy = new Ext.data.HttpProxy({
				url : "../controller/folderTranslateController.php",
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

			var folderTranslateReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "folderTranslateId"

			});
			var folderTranslateStore = new Ext.data.JsonStore({
				autoDestroy : true,
				proxy : folderTranslateProxy,
				reader : folderTranslateReader,
				baseParams : {
					method : "read",
					leafId : leafId
				},
				root : 'data',
				fields : [ {
					name : 'folderTranslateId',
					type : 'int'
				}, {
					name : 'folderId',
					type : 'int'
				}, {
					name : 'languageId',
					type : 'int'
				}, {
					name : 'languageCode',
					type : 'string'
				}, {
					name : 'languageDesc',
					type : 'string'
				}, {
					name : 'folderNative',
					type : 'string'
				} ]
			});
			
			
			var folderAccessProxy = new Ext.data.HttpProxy({
				url : "../controller/folderAccessController.php",
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
			var folderAccessReader = new Ext.data.JsonReader({

				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "folderAccessId"

			});
			/*
			 * cannot create autoload here
			 */
			var folderAccessStore = new Ext.data.JsonStore({

				autoDestroy : true,
				proxy : folderAccessProxy,
				reader : folderAccessReader,
				baseParams : {
					method : "read",
					isAdmin : isAdmin,
					leafId : leafId
				},
				root : "data",
				fields : [ {
					name : 'moduleId',
					type : 'int'
				}, {
					name : 'moduleEnglish',
					type : 'string'
				}, {
					name : 'teamId',
					type : 'int'
				}, {
					name : 'teamEnglish',
					type : 'string'
				}, {
					name : 'folderId',
					type : 'int'
				}, {
					name : 'folderAccessId',
					type : 'int'
				}, {
					name : 'folderEnglish',
					type : 'string'
				}, {
					name : 'folderAccessValue',
					type : 'boolean'
				} ]
			});
			

			var staffByProxy = new Ext.data.HttpProxy({
				url : "../controller/folderController.php?",
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

			var moduleProxy = new Ext.data.HttpProxy({
				url : "../controller/folderController.php?",
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

			var moduleReader = new Ext.data.JsonReader({

				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "moduleId"
			});

			var moduleStore = new Ext.data.JsonStore({
				proxy : moduleProxy,
				reader : moduleReader,
				autoLoad : true,
				autoDestroy : true,
				baseParams : {
					method : 'read',
					field : 'moduleId',
					type : 1,
					leafId : leafId
				},
				root : 'module',
				fields : [ {
					name : "moduleId",
					type : "int"
				}, {
					name : "moduleEnglish",
					type : "string"
				} ]
			});
			
			var teamProxy = new Ext.data.HttpProxy({
				url : "../controller/folderAccessController.php",
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
				pruneModifiedRecords : true,

				baseParams : {
					method : "read",
					field : "teamId",
					leafId : leafId
				},
				root : 'team',
				fields : [ {
					name : 'teamId',
					type : 'int'
				}, {
					name : 'teamEnglish',
					type : 'string'
				} ]

			});

			var logProxy = new Ext.data.HttpProxy({
				url : "../../security/controller/logController.php?",
				method : "POST",
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(successLabel,jsonResponse.message);
						// //uncommen for testing purpose
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
			var logReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "logId"
			});
			var logStore = new Ext.data.JsonStore({
				proxy : logProxy,
				reader : logReader,
				autoLoad : true,
				autoDestroy : true,
				baseParams : {
					method : "read",
					leafId : leafId,
					isAdmin : isAdmin,
					start : 0,
					limit : perPage,
					perPage : perPage
				},
				root : 'data',
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

			var logAdvanceProxy = new Ext.data.HttpProxy({
				url : "../../security/controller/logAdvanceController.php?",
				method : "POST",
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(successLabel,jsonResponse.message);//
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
			var logAdvanceReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "logAdvanceId"
			});
			var logAdvanceStore = new Ext.data.JsonStore({
				proxy : logAdvanceProxy,
				reader : logAdvanceReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				method : 'POST',
				baseParams : {
					method : "read",
					leafId : leafId,
					isAdmin : isAdmin,
					start : 0,
					limit : perPage,
					perPage : perPage
				},
				root : 'data',
				fields : [ {
					name : 'logAdvanceId',
					type : 'int'
				}, {
					name : 'logAdvanceText',
					type : 'string'
				}, {
					name : 'logAdvanceType',
					type : 'string'
				}, {
					name : 'logAdvanceComparison',
					type : 'string'
				}, {
					name : 'refTableName',
					type : 'int'
				} ,{
					name :'leafId',
					type : 'int'
						
				}]
			});
			var folderFilters = new Ext.ux.grid.GridFilters({
				encode : encode, 
				local : local, 
				filters : [ {
					type : 'list',
					dataIndex : 'moduleEnglish',
					column : 'moduleId',
					table : 'module',
					labelField : 'moduleEnglish',
					store : moduleStore,
					phpMode : true
				}, {
					type : 'numeric',
					dataIndex : 'folderSequence',
					column : 'folderSequence',
					table : 'folder'
				}, {
					type : 'string',
					dataIndex : 'folderEnglish',
					column : 'folderEnglish',
					table : 'folder'
				}, {
					type : 'string',
					dataIndex : 'folderPath',
					column : 'folderPath',
					table : 'folder'
				}, {
					type : 'string',
					dataIndex : 'iconId',
					column : 'iconId',
					table : 'folder'
				}, {
					type : 'list',
					dataIndex : 'executeBy',
					column : 'executeBy',
					table : 'folder',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dateFormat : 'Y-m-d H:i:s',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'folder'
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
				header : isPostLabel,
				dataIndex : 'isPost',
				hidden : isPostHidden
			});
			var folderColumnModel = [
					new Ext.grid.RowNumberer(),
				
					{
						dataIndex : 'folderSequence',
						header : folderSequenceLabel
					},
					{
						dataIndex : 'moduleEnglish',
						header : moduleEnglishLabel
					},
					{
						dataIndex : 'folderEnglish',
						header : folderEnglishLabel
					},
					{
						dataIndex : 'folderPath',
						header : folderPathLabel
					},
					{
						dataIndex : 'iconName',
						header : iconNameLabel,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return '<img src=\'../../javascript/resources/images/icon/'
									+ value
									+ '.png\' width=\'12\' height=\'12\'> '
									+ value;
						}
					}, isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid,
					isDeleteGrid, isActiveGrid, isApprovedGrid, isReviewGrid,
					isPostGrid, {
						dataIndex : 'executeBy',
						header : executeByLabel,
						sortable : true,
						hidden : true,
						width : 100
					}, {
						dataIndex : 'executeTime',
						header : executeTimeLabel,
						type : 'date',
						sortable : true,
						hidden : true,
						width : 100
					} ];

			var folderTranslateColumnModel = [ new Ext.grid.RowNumberer(), {
				dataIndex : "folderEnglish",
				header : folderSequenceLabel,
				sortable : true,
				hidden : true,
				width : 50
			}, {
				dataIndex : "languageCode",
				header : languageCodeLabel,
				sortable : true,
				hidden : false,
				width : 100
			}, {
				dataIndex : "languageDesc",
				header : languageDescLabel,
				sortable : true,
				hidden : false,
				width : 100

			}, {
				dataIndex : "folderNative",
				header : folderNativeLabel,
				sortable : true,
				hidden : false,
				width : 100,

				editor : {
					xtype : 'textfield',
					id : 'folderNative'
				}

			} ];

			var accessArray = [ 'isDefault', 'isNew', 'isDraft', 'isUpdate',
					'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost' ];

			var folderGrid = new Ext.grid.GridPanel(
					{
						border : false,
						store : folderStore,
						autoHeight : false,
						columns : folderColumnModel,
						loadMask : true,
						plugins : [ folderFilters ],
						sm : new Ext.grid.RowSelectionModel({
							singleSelect : true
						}),
						viewConfig : {
							forceFit : true
						},
						iconCls : 'application_view_detail',
						listeners : {
							'rowclick' : function(object, rowIndex, e) {
								var record = folderStore.getAt(rowIndex);
								formPanel.getForm().reset();
								formPanel.form.load({
									url : "../controller/folderController.php",
									method : "POST",
									waitTitle : systemLabel,
									waitMsg : waitMessageLabel,
									params : {
										method : "read",
										mode : "update",
										folderId : record.data.folderId,
										leafId : leafId,
										isAdmin : isAdmin
									},
									success : function(form, action) {
										

										viewPort.items.get(1).expand();
									},
									failure : function(form, action) {
										Ext.MessageBox.alert(systemErrorLabel,
												action.result.message);
									}
								});
								folderTranslateStore.load({
									params : {
										method :'read',
										folderId : record.data.folderId,
										leafId : leafId,
										isAdmin : isAdmin
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

												folderStore
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
												folderStore
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

												url = '../controller/folderController.php?';
												var sub_url;
												sub_url = '';
												var modified = folderStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = folderStore
															.getAt(i);
													sub_url = sub_url
															+ '&folderId[]='
															+ record
																	.get('folderId');
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
																	folderStore
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
							store : folderStore,
							pageSize : perPage
						})
					});

			var folderTranslateEditor = new Ext.ux.grid.RowEditor(
					{
						saveText : 'Save',
						listeners : {
							CancelEdit : function(rowEditor, changes, record,
									rowIndex) {
								folderTranslateStore.reload();

							},
							afteredit : function(rowEditor, changes, record,
									rowIndex) {

								this.save = true;

								var record = this.grid.getStore().getAt(
										rowIndex);
								Ext.Ajax
										.request({
											url : '../controller/folderTranslateController.php',
											method : 'POST',
											waitMsg : waitMeassageLabel,
											params : {
												leafId : leafId,
												method : 'save',
												folderTranslateId : record
														.get('folderTranslateId'),
												folderNative : Ext.getCmp(
														'folderNative')
														.getValue()

											},
											success : function(response,
													options) {
												jsonResponse = Ext
														.decode(response.responseText);
												if (jsonResponse == false) {
													Ext.MessageBox
															.alert(
																	systemLabel,
																	jsonResponse.message);
												} else {

													Ext.MessageBox
															.alert(
																	systemLabel,
																	jsonResponse.message);
													folderTranslateStore
															.reload();
												}

											},
											failure : function(response,
													options) {

												Ext.MessageBox
														.alert(
																systemLabel,
																escape(response.status)
																		+ ":"
																		+ escape(response.statusText));
											}
										});

							}
						}
					});

			var folderTranslateEntity = Ext.data.Record.create([ {
				name : "folderTranslateId",
				type : "int"
			}, {
				name : "folderId",
				type : "int"
			}, {
				name : "folderTranslateNative",
				type : "string"
			}, {
				name : "languageId",
				type : "int"
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
				name : "executeTime",
				type : "date",
				dateFormat : "Y-m-d H:i:s"
			} ]);

			var folderTranslateGrid = new Ext.grid.GridPanel(
					{
						name : 'folderTranslateGrid',
						id : 'folderTranslateGrid',
						title :'Translation',
						border : false,
						store : folderTranslateStore,
						height : 400,
						autoScroll : true,
						columns : folderTranslateColumnModel,
						viewConfig : {
							autoFill : true,
							forceFit : true
						},

						layout : 'fit',
						plugins : [ folderTranslateEditor ],
						tbar : {
							items : [
									{
										iconCls : 'add',
										id : 'add_record',
										name : 'add_record',
										text : newButtonLabel,
										handler : function() {
											var e = new folderTranslateEntity({
												folderTranslateId : '',
												folderId : '',
												folderTranslateNative : '',
												languageId : '',
												executeBy : '',
												staffName : '',
												isDefault : '',
												isNew : '',
												isDraft : '',
												isUpdate : '',
												isReview : '',
												isPost : '',
												isDelete : '',
												isActive : '',
												isApproved : '',
												executeTime : ''
											});
											folderTranslateEditor.stopEditing();
											folderTranslateStore.insert(0, e);
											folderTranslateGrid
													.getSelectionModel()
													.getSelections();
											folderTranslateEditor
													.startEditing(0);
										}
									},
									{
										text : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												folderTranslateStore
														.each(function(rec) {
															for ( var access in accessDetailArray) {
																rec
																		.set(
																				accessDetailArray[access],
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
												folderTranslateStore
														.each(function(rec) {
															for ( var access in accessDetailArray) {
																rec
																		.set(
																				accessDetailArray[access],
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

												url = '../controller/folderTranslateController.php?';
												var sub_url;
												sub_url = '';
												var modified = folderTranslateStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = folderTranslateStore
															.getAt(i);
													sub_url = sub_url
															+ '&folderTranslateId[]='
															+ record
																	.get('folderTranslateId');
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
																	folderTranslateStore
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
							store : folderTranslateStore,
							pageSize : perPage
						}),
						view : new Ext.ux.grid.BufferView({
							// custom row height
							rowHeight : 34,
							// render rows as they come into viewable area.
							scrollDelay : false
						})
					});
					
			
			
			
			// folder access field
			var teamId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : teamIdLabel,
				name : 'teamId',
				hiddenName : 'teamId',
				valueField : 'teamId',
				hiddenId : 'team_fake',
				id : 'teamId',
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
				},
				listeners : {
					'select' : function(combo, record, index) {
					
						folderAccessStore.load({
							params : {
								method : 'read',
								leafId : leafId,
								teamId : this.value,
								type : 2
							}
						});
						Ext.getCmp('folderAccess').enable();
					}
				}
			});
			
			var folderAccessValue = new Ext.ux.grid.CheckColumn({
				header : 'Access',
				dataIndex : 'folderAccessValue'
			});
			
			
			var folderAccessColumnModel = new Ext.grid.ColumnModel({
				columns : [ teamId,{
					header : moduleEnglishLabel,
					dataIndex : 'moduleEnglish'
				}, folderAccessValue ]
			});		
			
			var folderAccessArray = [ 'folderAccessValue' ];
			
			
			
			var folderAccessGrid = new Ext.grid.GridPanel(
					{
						name :'folderAccessGrid',
						id :'folderAccessGrid',
						region : 'west',
						store : folderAccessStore,
						cm : folderAccessColumnModel,
						frame : true,
						title : 'Folder Access Grid',
						autoHeight : true,
						disabled : true,
						selModel : folderAccessValue,
						iconCls : 'application_view_detail',
						viewConfig : {
							forceFit : true,
							emptyText : emptyTextLabel
						},
						tbar : {
							items : [
									{
										text : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {

												folderAccessStore
														.each(function(rec) {
															for ( var access in folderAccessArray) {
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
												folderAccessStore
														.each(function(rec) {
															for ( var access in folderAccessArray) {
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
												

												url = '../controller/folderAccessController.php?method=update&leafId='
														+ leafId;
												var sub_url;
												sub_url = '';
												var modified = folderAccessStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = folderAccessStore
															.getAt(i);
													sub_url = sub_url
															+ '&teamId='
															+ Ext.getCmp(
																	'teamId')
																	.getValue()
															+ '&moduleId='
															+ Ext
																	.getCmp('moduleId').value
															+ '&folderAccessId[]='
															+ record
																	.get('folderAccessId')
															+ '&folderAccessValue[]='
															+ record
																	.get('folderAccessValue');
												}
												url = url + sub_url;
												// reques and ajax
												Ext.Ajax
														.request({
															url : url,
															success : function(
																	response,
																	options) {
																jsonResponse = Ext
																		.decode(response.responseText);
																
																if (jsonResponse == true) {
																
																	Ext.MessageBox
																			.alert(
																					systemLabel,
																					jsonResponse.message);
																} else if (jsonResponse == false) {
																	
																	Ext.MessageBox
																			.alert(
																					systemErrorLabel,
																					jsonResponse.message);
																}
																// reload the
																// store
																folderAccessStore
																		.reload();
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
												// refresh the store
											}

										}
									} ]
						}
					});

			
			
			
			var gridPanel = new Ext.Panel(
					{
						title : 'Folder Listing',
						height : 50,
						layout : 'fit',
						iconCls : 'application_view_detail',
						tbar : [
								' ',
								{
									text : reloadToolbarLabel,
									iconCls : 'database_refresh',
									id : 'pageReload',
									disabled : pageReload,
									handler : function() {
										folderStore.reload();
									}
								},
								'-',
								{
									text : addToolbarLabel,
									iconCls : 'add',
									id : 'pageCreate',
									disabled : pageCreate,
									handler : function() {

										viewPort.items.get(1).expand();
									}
								},
								'-',

								{
									text : excelToolbarLabel,
									iconCls : 'page_excel',
									id : 'page_excel',
									disabled : pagePrint,
									handler : function() {
										Ext.Ajax
												.request({
													url : '../controller/folderController.php?method=report&mode=excel&limit='
															+ perPage
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														jsonResponse = Ext
																.decode(response.responseText);
														if (jsonResponse == true) {

															window
																	.open("../../security/document/excel/folder.xlsx");
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
								}, '->', new Ext.ux.form.SearchField({
									store : folderStore,
									width : 320
								}) ],
						items : [ folderGrid ]
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

			var expander = new Ext.ux.grid.RowExpander({
				tpl : new Ext.Template(
						'<br><p><b>Operation:</b> {operation}</p><br>',
						'<p><b>SQL STATEMENT:</b> {sql}</p><br>')
			});
			var logColumnModel = [ expander, new Ext.grid.RowNumberer(), {
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

			var logGrid = new Ext.grid.GridPanel({
				border : false,
				store : logStore,
				autoHeight : false,
				height : 400,
				columns : logColumnModel,
				loadMask : true,
				plugins : [ logFilters, expander ],
				collapsible : true,
				animCollapse : false,
				sm : new Ext.grid.RowSelectionModel({
					singleSelect : true
				}),
				viewConfig : {
					emptyText : emptyRowLabel
				},
				iconCls : 'application_view_detail',
				listeners : {
					render : {
						fn : function() {
							logStore.load({
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
					store : logStore,
					pageSize : perPage,
					plugins : [ new Ext.ux.plugins.PageComboResizer() ]
				})
			});
			// audit advance grid
			var logAdvancefilters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : local,
				filters : [

				{
					type : 'numeric',
					dataIndex : 'logAdvanceId',
					column : 'logAdvanceId',
					table : 'logAdvance'
				},

				{
					type : 'string',
					dataIndex : 'logAdvanceText',
					column : 'logAdvanceText',
					table : 'logAdvance'
				},

				{
					type : 'string',
					dataIndex : 'logAdvanceType',
					column : 'logAdvanceType',
					table : 'logAdvance'
				},

				{
					type : 'string',
					dataIndex : 'logAdvanceComparison',
					column : 'logAdvanceComparison',
					table : 'logAdvance'
				},

				{
					type : 'string',
					dataIndex : 'refTableName',
					column : 'refTableName',
					table : 'logAdvance'
				},

				{
					type : 'list',
					dataIndex : 'executeBy',
					column : 'executeBy',
					table : 'logAdvance',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				},

				{
					type : 'date',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'logAdvance'
				}]
			});

			var logAdvanceColumnModel = [ new Ext.grid.RowNumberer(), {
				dataIndex : 'logAdvanceId',
				header : logAdvanceIdLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'logAdvanceText',
				header : logAdvanceTextLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'logAdvanceType',
				header : logAdvanceTypeLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'logAdvanceComparision',
				header : logAdvanceComparisionLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'refTableName',
				header : refTableNameLabel,
				sortable : true,
				hidden : false
			} ,{
				dataIndex :'leafId',
				header :leafIdLabel,
				sortable :true,
				hidden : false
			}];

			var logAdvanceGrid = new Ext.grid.GridPanel({
				border : false,
				store : logAdvanceStore,
				autoHeight : false,
				height : 400,
				columns : logAdvanceColumnModel,
				loadMask : true,
				plugins : [ logAdvancefilters ],
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
							logAdvanceStore.load({
								params : {
									start : 0,
									limit : perPage,
									method : 'read',
									mode : 'view',
									plugin : [ logAdvancefilters ]
								}
							});
						}
					}
				},
				bbar : new Ext.PagingToolbar({
					store : logAdvanceStore,
					pageSize : perPage,
					plugins : [ new Ext.ux.plugins.PageComboResizer() ]
				}),
				view : new Ext.ux.grid.BufferView({
					// custom row height
					rowHeight : 34,
					// render rows as they come into viewable area.
					scrollDelay : false
				})
			});

			// viewport just save information,items will do separate
			// only load store when viewport is open

			var moduleId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : moduleIdLabel,
				name : 'moduleId',
				hiddenName : 'moduleId',
				valueField : 'moduleId',
				hiddenId : 'module_fake',
				id : 'moduleId',
				displayField : 'moduleEnglish',
				typeAhead : false,
				triggerAction : 'all',
				store : moduleStore,
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
				},
				listeners : {

					'select' : function(combo, record, index) {
						Ext.Ajax.request({
							url : '../controller/folderController.php',
							method : 'GET',
							params : {
								method : 'read',
								field : 'sequence',
								table : 'folder',
								moduleId : combo.value,
								leafId : leafId
							},
							success : function(response, options) {
								jsonResponse = Ext
										.decode(response.responseText);
								if (jsonResponse.success == false) {
									Ext.MessageBox.alert(systemLabel,
											jsonResponse.message);
								} else {

									Ext.getCmp('folderSequence').setValue(
											jsonResponse.nextSequence);

								}

							},
							failure : function(response, options) {

								Ext.MessageBox.alert(systemLabel,
										escape(response.status) + ":"
												+ escape(response.statusText));
							}

						});
					}
				}
			});

			var folderEnglish = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : folderEnglishLabel,
				hiddenName : 'folderEnglish',
				name : 'folderEnglish',
				anchor : '95%'
			});

			var folderSequence = new Ext.form.NumberField({
				labelAlign : 'left',
				fieldLabel : folderSequenceLabel,
				hiddenName : 'folderSequence',
				name : 'folderSequence',
				id : 'folderSequence',
				anchor : '95%'
			});

			var folderPath = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : folderPathLabel,
				hiddenName : 'folderPath',
				name : 'folderPath',
				anchor : '95%'
			});

			var iconData = [ [ '29', 'accept' ], [ '31', 'acroread' ],
					[ '32', 'add' ], [ '34', 'aktion' ], [ '35', 'anchor' ],
					[ '36', 'application' ], [ '40', 'application_double' ],
					[ '41', 'application_edit' ],
					[ '42', 'application_error' ],
					[ '43', 'application_form' ], [ '48', 'application_get' ],
					[ '49', 'application_go' ], [ '50', 'application_home' ],
					[ '51', 'application_key' ],
					[ '52', 'application_lightning' ],
					[ '53', 'application_link' ], [ '54', 'application_osx' ],
					[ '55', 'application_osx_terminal' ],
					[ '56', 'application_put' ], [ '71', 'application_xp' ],
					[ '72', 'application_xp_terminal' ], [ '73', 'ark' ],
					[ '94', 'arts' ], [ '95', 'ascend' ],
					[ '96', 'asterisk_orange' ], [ '97', 'asterisk_yellow' ],
					[ '98', 'attach' ], [ '100', 'award_star_add' ],
					[ '101', 'award_star_bronze_1' ],
					[ '102', 'award_star_bronze_2' ],
					[ '103', 'award_star_bronze_3' ],
					[ '104', 'award_star_delete' ],
					[ '105', 'award_star_gold_1' ],
					[ '106', 'award_star_gold_2' ],
					[ '107', 'award_star_gold_3' ],
					[ '108', 'award_star_silver_1' ],
					[ '109', 'award_star_silver_2' ],
					[ '110', 'award_star_silver_3' ], [ '111', 'basket' ],
					[ '119', 'bell' ], [ '125', 'bin' ], [ '130', 'bomb' ],
					[ '144', 'box' ], [ '358', 'cursor' ], [ '359', 'cut' ],
					[ '361', 'database' ], [ '385', 'delete' ],
					[ '386', 'descend' ], [ '387', 'disconnect' ],
					[ '389', 'disk_multiple' ], [ '391', 'document' ],
					[ '392', 'door' ], [ '395', 'door_out' ],
					[ '396', 'drink' ], [ '398', 'drive' ], [ '415', 'dvd' ],
					[ '423', 'email' ], [ '442', 'error' ],
					[ '445', 'error_go' ], [ '447', 'exclamation' ],
					[ '449', 'exec' ], [ '450', 'eye' ],
					[ '153', 'briefcase' ], [ '154', 'browser' ],
					[ '155', 'bug' ], [ '162', 'building' ], [ '197', 'cake' ],
					[ '198', 'calculator' ], [ '212', 'camera' ],
					[ '220', 'cancel' ], [ '221', 'car' ], [ '222', 'cart' ],
					[ '235', 'cd' ], [ '242', 'chart_bar' ],
					[ '270', 'clock' ], [ '281', 'cog' ], [ '287', 'coins' ],
					[ '290', 'colors' ], [ '291', 'color_swatch' ],
					[ '292', 'color_wheel' ], [ '300', 'compress' ],
					[ '301', 'computer' ], [ '309', 'connect' ],

					[ '339', 'cookie' ], [ '341', 'creditcards' ],
					[ '342', 'cross' ], [ '461', 'female' ], [ '481', 'find' ],
					[ '526', 'gimp' ], [ '491', 'folder' ], [ '527', 'group' ],
					[ '536', 'heart' ], [ '539', 'help' ],
					[ '541', 'hourglass' ], [ '546', 'house' ],
					[ '549', 'html' ], [ '556', 'image' ],
					[ '560', 'image_edit' ], [ '561', 'image_link' ],
					[ '565', 'information' ], [ '566', 'ipod' ],
					[ '571', 'java' ], [ '572', 'java_jar' ],
					[ '573', 'joystick' ], [ '578', 'key' ],
					[ '579', 'keyboard' ], [ '586', 'kservices' ],
					[ '587', 'layers' ], [ '597', 'lightbulb' ],
					[ '601', 'lightning' ], [ '605', 'link' ],
					[ '612', 'lock' ], [ '619', 'lorry' ],
					[ '626', 'magifier_zoom_out' ], [ '627', 'magnifier' ],
					[ '628', 'magnifier_zoom_in' ], [ '629', 'male' ],
					[ '630', 'map' ], [ '651', 'mime' ], [ '652', 'money' ],
					[ '655', 'money_dollar' ], [ '656', 'money_euro' ],
					[ '657', 'money_pound' ], [ '658', 'money_yen' ],
					[ '659', 'monitor' ], [ '667', 'mouse' ], [ '674', 'new' ],
					[ '675', 'newspaper' ], [ '680', 'note' ],
					[ '685', 'note_go' ], [ '686', 'ooo_gulls' ],
					[ '687', 'openoffice' ], [ '688', 'overlays' ],

					[ '783', 'paintbrush' ], [ '784', 'paintcan' ],
					[ '785', 'palette' ], [ '789', 'pencil' ],
					[ '793', 'phone' ], [ '797', 'photo' ],
					[ '798', 'photos' ], [ '802', 'php-icon' ],
					[ '803', 'picture' ], [ '814', 'pilcrow' ],
					[ '815', 'pill' ], [ '830', 'printer' ],
					[ '837', 'quicktime' ], [ '838', 'rainbow' ],
					[ '839', 'realplayer' ], [ '841', 'report' ],
					[ '842', 'report_add' ], [ '843', 'report_delete' ],
					[ '844', 'report_disk' ], [ '845', 'report_edit' ],
					[ '846', 'report_go' ], [ '847', 'report_key' ],
					[ '848', 'report_link' ], [ '849', 'report_magnify' ],
					[ '850', 'report_picture' ], [ '851', 'report_user' ],
					[ '852', 'report_word' ], [ '857', 'rosette' ],
					[ '858', 'rpm' ], [ '902', 'shading' ],
					[ '928', 'shield' ], [ '932', 'sitemap' ],
					[ '933', 'sitemap_color' ], [ '934', 'sound' ],
					[ '949', 'star' ], [ '954', 'stop' ], [ '963', 'tab' ],
					[ '985', 'tag' ], [ '986', 'tag_blue' ],
					[ '987', 'tag_blue_add' ], [ '988', 'tag_blue_delete' ],
					[ '989', 'tag_blue_edit' ], [ '990', 'tag_green' ],
					[ '991', 'tag_orange' ], [ '992', 'tag_pink' ],
					[ '993', 'tag_purple' ], [ '994', 'tag_red' ],
					[ '995', 'tag_yellow' ], [ '996', 'tar' ],
					[ '997', 'telephone' ], [ '1008', 'terminal' ],
					[ '1052', 'tgz' ], [ '1054', 'thumb_down' ],
					[ '1055', 'thumb_up' ], [ '1056', 'tick' ],
					[ '1058', 'time' ], [ '1062', 'time_go' ],
					[ '1063', 'transmit' ], [ '1070', 'tux' ],
					[ '1072', 'user' ], [ '1084', 'vcard' ],
					[ '1088', 'vector' ], [ '1091', 'video' ],
					[ '1093', 'wand' ], [ '1123', 'zoom' ],
					[ '1124', 'zoom_in' ], [ '1125', 'zoom_out' ] ];
			var iconId = new Ext.ux.form.IconCombo({
				name : 'iconId',
				hiddenName : 'iconId',
				mode : 'local',
				id : 'iconId',
				hiddenId : 'FakeiconId',
				store : new Ext.data.ArrayStore({
					fields : [ 'iconId', 'iconName' ],
					data : iconData
				}),
				emptyText : emptyTextLabel,
				fieldLabel : iconIdLabel,
				anchor : '95%',
				triggerAction : 'all',
				valueField : 'iconId',
				displayField : 'iconName',
				iconClsTpl : '{iconName}'
			});

			// hidden id for updated
			var folderId = new Ext.form.Hidden({
				name : 'folderId',
				id : 'folderId'
			});

			var firstRecord = new Ext.form.Hidden({
				name : 'firstRecord',
				id : 'firstRecord',
				value : ''
			});

			var nextRecord = new Ext.form.Hidden({
				name : 'nextRecord',
				id : 'nextRecord',
				value : ''
			});

			var previousRecord = new Ext.form.Hidden({
				name : 'previousRecord',
				id : 'previousRecord',
				value : ''
			});
			var lastRecord = new Ext.form.Hidden({
				name : 'lastRecord',
				id : 'lastRecord',
				value : ''
			});

			var endRecord = new Ext.form.Hidden({
				name : 'endRecord',
				id : 'endRecord',
				value : ''
			});
			
			
			
		

			var formPanel = new Ext.form.FormPanel(
					{
						url : '../controller/folderController.php',
						id : "formPanel",
						name :"formPanel",
						method : 'post',
						frame : true,
						border : false,
						title :'Folder Entry',
						width : 600,
						items : [ {
							xtype : 'panel',
						
							bodyStyle : "padding:1px",
							layout : 'form',
							items : [ {
								xtype : 'fieldset',
								
								layout : 'form',
								bodyStyle : "padding:5px;",
								border : true,
								frame : true,
								
								items : [folderId, moduleId, folderEnglish,

							folderSequence, folderPath, iconId, folderId  ]
							} ]
						}, {
							xtype :'tabpanel',
							activeTab: 0 ,
							items :[folderTranslateGrid,folderAccessGrid ]
						}],
						buttonVAlign : 'top',
						buttonAlign : 'left',
						iconCls : 'application_form',
						bbar : new Ext.ux.StatusBar({
							id : "form-statusbar",
							defaultText : "Ready",
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
										// reload the store
										
										if (auditWindow) {
											logStore.reload();
											logAdvanceStore.reload();
											auditWindow.show().center();
										}
									}
								},

								{
									text : newButtonLabel,
									id :'newButton',
									title:'newButton',
									type : 'button',
									iconCls : 'new',
									handler : function() {
										Ext.getCmp('folderTranslateGrid').enable();
										Ext.getCmp('folderAccessGrid').enable();
										var id = 0;
										var id = Ext.getCmp('folderId')
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
																var title = successLabel;
																Ext.MessageBox
																		.alert(
																				title,
																				action.result.message);
																Ext
																		.getCmp(
																				'folderTranslateGrid')
																		.enable();
																Ext
																		.getCmp(
																				'deleteButton')
																		.enable();

																folderStore
																		.reload({
																			params : {
																				leafId : leafId,
																				start : 0,
																				limit : perPage
																			}
																		});
																Ext
																		.getCmp(
																				'folderId')
																		.setValue(
																				action.result.folderId);

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
										Ext.getCmp('folderTranslateGrid').disable();
										Ext.getCmp('folderAccessGrid').disable();
										var id = 0;
										var id = Ext.getCmp('folderId')
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
																leafId : leafId,
																page : 'master'
															},
															success : function(
																	form,
																	action) {
																var title = successLabel;
																Ext.MessageBox
																		.alert(
																				title,
																				action.result.message);
																Ext
																		.getCmp(
																				'folderTranslateGrid')
																		.enable();
																Ext
																		.getCmp(
																				'deleteButton')
																		.enable();

																folderStore
																		.reload({
																			params : {
																				leafId : leafId,
																				start : 0,
																				limit : perPage
																			}
																		});
																Ext
																		.getCmp(
																				'folderId')
																		.setValue(
																				action.result.folderId);

															},
															failure : function(
																	form,
																	action) {

																if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																	alert(loadFailureMessageLabel);
																} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {

																	alert(clientInvalidMessageLabel);
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
										Ext.getCmp('folderTranslateGrid').disable();
										Ext.getCmp('folderAccessGrid').disable();
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
																		url : "../controller/folderController.php",
																		params : {
																			method : "delete",
																			folderId : Ext
																					.getCmp(
																							'folderId')
																					.getValue(),
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

																				folderStore
																						.reload({
																							params : {
																								leafId : leafId,
																								start : 0,
																								limit : perPage
																							}
																						});
																						
																						
																				Ext
																						.getCmp(
																								'folderTranslateGrid')
																						.disable();
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
																				Ext
																						.getCmp(
																								'translation')
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
										Ext.getCmp('folderTranslateGrid').disable();
										Ext.getCmp('folderAccessGrid').disable();
										formPanel.getForm().reset();
									}

								},
								{
									text : postButtonLabel,
									type : 'button',
									name : 'postButton',
									id : 'postButton',
									iconCls : 'lock',
									handler : function() {
										Ext.getCmp('newButton').disable();
										Ext.getCmp('folderTranslateGrid').disable();
										Ext.getCmp('folderAccessGrid').disable();
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
										Ext.getCmp('teamId').enable();
										Ext.getCmp('folderAccessGrid').enable();
										if (Ext.getCmp('firstRecord')
												.getValue() == ''
												|| Ext.getCmp('firstRecord')
														.getValue() == undefined) {

											Ext.Ajax
													.request({
														url : "../controller/folderController.php",
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
																			url : "../controller/folderController.php",
																			method : "POST",
																			waitTitle : systemLabel,
																			waitMsg : waitMessageLabel,
																			params : {
																				method : "read",

																				folderId : Ext
																						.getCmp(
																								'firstRecord')
																						.getValue(),
																				leafId : leafId,
																				isAdmin : isAdmin
																			},
																			success : function(
																					form,
																					action) {
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
																				folderTranslateStore
																						.load({
																							params : {
																								leafId : leafId,
																								isAdmin : isAdmin,
																								folderId : action.result.data.folderId
																							}
																						});

																				folderTranslateGrid
																						.enable();
																						
																				folderAccessStore
																						.load({
																							params : {
																								leafId : leafId,
																								isAdmin : isAdmin,
																								folderId : action.result.data.folderId
																							}
																						});

																				folderAccessGrid
																						.enable();
																						
																				viewPort.items
																						.get(
																								1)
																						.expand();
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
										} else {

											formPanel.form
													.load({
														url : "../controller/folderController.php",
														method : "POST",
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : "read",

															folderId : Ext
																	.getCmp(
																			'firstRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {
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
															// load the detail
															// grid
															Ext
																	.getCmp(
																			'previousButton')
																	.disable();
															folderTranslateStore
																	.load({
																		params : {
																			leafId : leafId,
																			isAdmin : isAdmin,
																			folderId : action.result.data.folderId
																		}
																	});

															folderTranslateGrid
																	.enable();
															folderAccessStore
																						.load({
																							params : {
																								leafId : leafId,
																								isAdmin : isAdmin,
																								folderId : action.result.data.folderId
																							}
																						});

																				folderAccessGrid
																						.enable();		
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
										Ext.getCmp('folderTranslateGrid').enable();
										Ext.getCmp('folderAccessGrid').enable();
										if (Ext.getCmp('previousRecord')
												.getValue() == ''
												|| Ext.getCmp('previousRecord')
														.getValue() == undefined) {
											Ext.MessageBox
													.alert("Please Pick A Record First Ya");

										}
										if (Ext.getCmp('firstRecord')
												.getValue() >= 1) {
											formPanel.form
													.load({
														url : "../controller/folderController.php",
														method : "POST",
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : "read",

															folderId : Ext
																	.getCmp(
																			'previousRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {
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
															
															folderTranslateStore
																	.load({
																		params : {
																			leafId : leafId,
																			isAdmin : isAdmin,
																			folderId : action.result.data.folderId
																		}
																	});
																	
															folderAccessStore
																						.load({
																							params : {
																								leafId : leafId,
																								isAdmin : isAdmin,
																								folderId : action.result.data.folderId
																							}
																						});

																						
															if (Ext
																	.getCmp(
																			'previousRecord')
																	.getValue() == 0) {
																Ext
																		.getCmp(
																				'previousButton')
																		.disable();
															}
															folderTranslateGrid
																	.enable();
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
									disabled : true,
									iconCls : 'resultset_next',
									handler : function() {
										
										Ext.getCmp('newButton').disable();
										Ext.getCmp('folderTranslateGrid').enable();
										Ext.getCmp('folderAccessGrid').enable();
										
										if (Ext.getCmp('nextRecord').getValue() == ''
												|| Ext.getCmp('nextRecord')
														.getValue() == undefined) {
											Ext.MessageBox
													.alert("Please Pick A Record First Ya");

										}
										if (Ext.getCmp('nextRecord').getValue() <= Ext
												.getCmp('lastRecord')
												.getValue()) {

											formPanel.form
													.load({
														url : "../controller/folderController.php",
														method : "POST",
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : "read",

															folderId : Ext
																	.getCmp(
																			'nextRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {
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
															
															folderTranslateStore
																	.load({
																		params : {
																			leafId : leafId,
																			isAdmin : isAdmin,
																			folderId : action.result.data.folderId
																		}
																	});
																	
															folderAccessStore
																						.load({
																							params : {
																								leafId : leafId,
																								isAdmin : isAdmin,
																								folderId : action.result.data.folderId
																							}
																						});

																					
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
															folderTranslateGrid
																	.enable();
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
										Ext.getCmp('newButton').disable();
										Ext.getCmp('folderTranslateGrid').enable();
										Ext.getCmp('folderAccessGrid').enable();
										if (Ext.getCmp('lastRecord').getValue() == ''
												|| Ext.getCmp('lastRecord')
														.getValue() == undefined) {
											Ext.Ajax
													.request({
														url : "../controller/folderController.php",
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
																			url : "../controller/folderController.php",
																			method : "POST",
																			waitTitle : systemLabel,
																			waitMsg : waitMessageLabel,
																			params : {
																				method : "read",

																				folderId : Ext
																						.getCmp(
																								'lastRecord')
																						.getValue(),
																				leafId : leafId,
																				isAdmin : isAdmin
																			},
																			success : function(
																					form,
																					action) {
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
																				
																				folderTranslateStore
																						.load({
																							params : {
																								leafId : leafId,
																								isAdmin : isAdmin,
																								folderId : action.result.data.folderId
																							}
																						});
																				
																				folderAccessStore
																						.load({
																							params : {
																								leafId : leafId,
																								isAdmin : isAdmin,
																								folderId : action.result.data.folderId
																							}
																						});

																			
																				Ext
																						.getCmp(
																								'nextButton')
																						.disable();
																				Ext
																						.getCmp(
																								'previousButton')
																						.enable();

																				folderTranslateGrid
																						.enable();
																				viewPort.items
																						.get(
																								1)
																						.expand();
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
										} else {
											if (Ext.getCmp('folderId')
													.getValue() <= Ext.getCmp(
													'lastRecord').getValue()) {
												formPanel.form
														.load({
															url : "../controller/folderController.php",
															method : "POST",
															waitTitle : systemLabel,
															waitMsg : waitMessageLabel,
															params : {
																method : "read",

																folderId : Ext
																		.getCmp(
																				'lastRecord')
																		.getValue(),
																leafId : leafId,
																isAdmin : isAdmin
															},
															success : function(
																	form,
																	action) {
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
																
																folderTranslateStore
																		.load({
																			params : {
																				leafId : leafId,
																				isAdmin : isAdmin,
																				folderId : action.result.data.folderId
																			}
																		});
																Ext
																		.getCmp(
																				'nextButton')
																		.disable();
																Ext
																		.getCmp(
																				'previousButton')
																		.enable();

																folderTranslateGrid
																		.enable();
																viewPort.items
																		.get(1)
																		.expand();
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
												// empty record
												Ext.MessageBox.alert(
														systemErrorLabel,
														'Record Not Found');
											}
										}
									}
								},
								{
									text : 'Translation',
									name : 'translation',
									id : 'translation',
									disabled : true,
									handler : function() {
										Ext.getCmp('newButton').disable();
										Ext.Ajax
												.request({

													url : "../controller/folderController.php",
													method : 'GET',
													params : {
														leafId : leafId,
														method : 'translate',
														folderId : Ext.getCmp(
																'folderId')
																.getValue()
													},
													success : function(
															response, options) {
														jsonResponse = Ext
																.decode(response.responseText);
														if (jsonResponse.success == true) {
															Ext.MessageBox
																	.alert(
																			systemLabel,
																			jsonResponse.message);

															folderTranslateStore
																	.reload();

														} else {
															Ext.MessageBox
																	.alert(
																			systemErrorLabel,
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

			var auditWindow = new Ext.Window({
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
