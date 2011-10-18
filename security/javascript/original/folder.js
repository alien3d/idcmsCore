Ext
		.onReady(function() {
			Ext.Ajax.timeout = 90000000;
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

			var folderFilters = new Ext.ux.grid.GridFilters({
				// encode and local configuration options defined previously for
				// easier reuse
				encode : encode, // json encode the filter query
				local : local, // defaults to false (remote filtering)
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
						id : 'action',
						header : 'Task',
						xtype : 'actioncolumn',
						width : 50,
						items : [
								{
									icon : '../../javascript/resources/images/icon/application_edit.png',
									tooltip : updateRecordToolTipLabel,
									handler : function(grid, rowIndex, colIndex) {
										var record = folderStore
												.getAt(rowIndex);
										formPanel.getForm().reset();
										formPanel.form
												.load({
													url : "../controller/folderController.php",
													method : "POST",
													waitTitle : systemLabel,
													waitMsg : waitMessageLabel,
													params : {
														method : "read",
														mode : "update",
														folderId : record.data.folderId,
														leafId : leafId
													},
													success : function(form,
															action) {
														Ext
																.getCmp(
																		"folderDesc_temp")
																.setValue(
																		record.data.folderDesc);
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
										var record = folderStore
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
																		url : "../controller/folderController.php",
																		params : {
																			method : "delete",
																			folderId : record.data.folderId,
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
																			folderStore
																					.reload({
																						params : {
																							leafId : leafId,
																							start : 0,
																							limit : perPage
																						}
																					});
																			folderStoreList
																					.reload({
																						params : {
																							leafId : leafId,
																							start : 0,
																							limit : perPage
																						}
																					});
																			Ext.MessageBox
																					.alert(
																							title,
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
					isDeleteGrid, isActiveGrid, isApprovedGrid,isReviewGrid,isPostGrid, {
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
				header : "languageCode",
				sortable : true,
				hidden : false,
				width : 100
			}, {
				dataIndex : "languageDesc",
				header : "languageDesc",
				sortable : true,
				hidden : false,
				width : 100

			}, {
				dataIndex : "folderNative",
				header : "folderNative",
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
										Ext.getCmp("folderDesc_temp").setValue(
												record.data.folderDesc);

										viewPort.items.get(1).expand();
									},
									failure : function(form, action) {
										Ext.MessageBox.alert(systemErrorLabel,
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
								folderStore.reload();

							},
							afteredit : function(rowEditor, changes, record,
									rowIndex) {

								this.save = true;
								// update record manually
								//var curr_store = this.grid.getStore().getAt(rowIndex);

								Ext.Ajax.request({
									url : '../controller/folderTranslateController.php',
									method : 'POST',
									waitMsg : waitMeassageLabel,
									params : {
										leafId : leafId,
										method : 'save',
										folderTranslateId : record
												.get('folderTranslateId'),
										folderTranslate : Ext.getCmp(
												'folderTranslate').getValue()

									},
									success : function(response, options) {
										jsonResponse = Ext
												.decode(response.responseText);
										if (jsonResponse == false) {
											Ext.MessageBox.alert(systemLabel,
													jsonResponse.message);
										} else {
											
											Ext.MessageBox.alert(systemLabel,
													jsonResponse.message);
											folderTranslateStore.reload();
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

			var folderTranslateGrid = new Ext.grid.GridPanel({
				name : 'folderTranslateGrid',
				id :'folderTranslateGrid',
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
				plugins : [ folderTranslateEditor ]
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

			// viewport just save information,items will do separate
			// only load store when viewport is open

			var moduleId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : moduleIdLabel,
				name : 'moduleId',
				hiddenName : 'moduleId',
				valueField : 'moduleId',
				hiddenId 	: 'module_fake',
				id :'moduleId',
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
						url : '../controller/folderController.php',
						method : 'post',
						frame : true,
						title : 'Menu Administration',
						border : false,

						width : 600,
						items : [ {
							xtype : 'panel',
							title : leafEnglish,
							bodyStyle : "padding:5px",
							layout : 'form',
							items : [ folderId, moduleId, folderEnglish,

							folderSequence, folderPath, iconId, folderId ]
						}, {
							xtype : 'panel',
							title : 'Folder Translation',
							items : [ folderTranslateGrid ]
						} ],
						buttonVAlign : 'top',
						buttonAlign : 'left',
						iconCls : 'application_form',
						buttons : [
								{
									text : saveButtonLabel,
									iconCls : 'bullet_disk',
									handler : function() {
										var id = 0;
										id = Ext.getCmp('folderId').getValue();
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
																page : 'master',
																leafId : leafId
															},
															success : function(
																	form,
																	action) {
																Ext.MessageBox
																		.alert(
																				systemLabel,
																				action.result.message);

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
																		.enable();
																folderTranslateStore.load({
																	params:{
																		leafId : leafId,
																		isAdmin: isAdmin,
																		folderId :action.result.folderId 
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
																			.alert(
																					connectFailureLabel,
																					'Server reported:'
																							+ form.response.status
																							+ ' '
																							+ form.response.statusText);
																} else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
																	Ext.Msg
																			.alert(
																					serverInvalidLabel,
																					action.result.message);
																}
															}
														});
									}
								},
								{
									text : resetButtonLabel,
									type : 'reset',
									iconCls : 'table_refresh',
									handler : function() {
										formPanel.getForm().reset();
									}
								},
								{
									text : 'Translation',
									id : 'translation',
									disabled : true,
									handler : function() {

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
															box.hide();
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
