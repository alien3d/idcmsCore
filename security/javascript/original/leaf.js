Ext
		.onReady(function() {
			Ext.Ajax.timeout = 90000000;

			var temp;

			var pageCreate;
			var pageReload;
			var pagePrint;

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
			Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';
			var perPage = 15;
			var encode = false;
			var local = false;

			var leafProxy = new Ext.data.HttpProxy({
				url : "../controller/leafController.php",
				method : 'POST',

				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);

					// Ext.MessageBox.alert(systemLabel, jsonResponse.message);
				},
				failure : function(response, options) {

					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ":"
									+ escape(response.statusText));
				}
			});

			var leafReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "leafId"

			});
			var leafStore = new Ext.data.JsonStore({

				proxy : leafProxy,
				reader : leafReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				baseParams : {
					method : "read",
					leafIdTemp : leafIdTemp
				},
				root : "data",
				fields : [ {
					name : 'leafId',
					type : 'int'
				}, {
					name : 'moduleId',
					type : 'int'
				}, {
					name : 'moduleEnglish',
					type : 'string'
				}, {
					name : 'folderId',
					type : 'int'
				}, {
					name : 'folderEnglish',
					type : 'string'
				}, {
					name : 'leafEnglish',
					type : 'string'
				}, {
					name : 'leafEnglish',
					type : 'string'
				}, {
					name : 'leafSequence',
					type : 'int'
				}, {
					name : 'leafFilename',
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
					name : "isReview",
					type : "boolean"
				}, {
					name : "isPost",
					type : "boolean"
				}, {
					name : "executeTime",
					type : "date",
					dateFormat : "Y-m-d H:i:s"
				} ]
			});

			var leafTranslateProxy = new Ext.data.HttpProxy({
				url : "../controller/leafTranslateController.php",
				method : 'POST',

				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {

						// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
					}
				},
				failure : function(response, options) {

					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ":"
									+ escape(response.statusText));
				}
			});

			var leafTranslateReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "leafTranslateId"

			});
			var leafTranslateStore = new Ext.data.JsonStore({
				proxy : leafTranslateProxy,
				reader : leafTranslateReader,
				autoLoad : false,
				autoDestroy : true,
				pruneModifiedRecords : true,
				baseParams : {
					method : "read",
					leafIdTemp : leafIdTemp
				},
				root : "data",
				fields : [ {
					name : 'leafTranslateId',
					type : 'int'
				}, {
					name : 'leafId',
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
					name : 'leafNative',
					type : 'string'
				} ]
			});

			var staffByProxy = new Ext.data.HttpProxy({
				url : "../controller/leafController.php?",
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
					leafIdTemp : leafIdTemp
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
				url : "../controller/leafController.php?",
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
					leafIdTemp : leafIdTemp
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

			var folderProxy = new Ext.data.HttpProxy({
				url : "../controller/leafController.php?",
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
				baseParams : {
					method : 'read',
					field : 'folderId',
					type : 1,
					leafIdTemp : leafIdTemp
				},
				root : 'folder',
				fields : [ {
					name : "folderId",
					type : "int"
				}, {
					name : "folderEnglish",
					type : "string"
				} ]
			});

			var leafFilters = new Ext.ux.grid.GridFilters({

				encode : encode,
				local : local,
				filters : [ {
					type : 'list',
					dataIndex : 'moduleNative',
					column : 'moduleId',
					table : 'module',
					labelField : 'moduleNative',
					store : moduleStore,
					phpMode : true
				}, {
					type : 'list',
					dataIndex : 'folderNative',
					column : 'folderId',
					table : 'folder',
					labelField : 'folderNative',
					store : folderStore,
					phpMode : true

				}, {
					type : 'string',
					dataIndex : 'leafEnglish',
					column : 'leafEnglish',
					column : 'leafEnglish',
					table : 'leaf'
				}, {
					type : 'numeric',
					dataIndex : 'leafSequence',
					column : 'leafSequence',
					table : 'leaf'
				}, {
					type : 'string',
					dataIndex : 'leafFilename',
					column : 'leafFilename',
					table : 'leaf'
				}, {
					type : 'string',
					dataIndex : 'iconId',
					column : 'iconId',
					table : 'leaf'
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
				hidden : isReviewHidden
			});
			var isPostGrid = new Ext.ux.grid.CheckColumn({
				header : 'Post',
				dataIndex : 'isPost',
				hidden : isPostHidden
			});

			var leafColumnModel = [
					new Ext.grid.RowNumberer(),

					{
						dataIndex : 'leafSequence',
						header : leafSequenceLabel,
						type : 'string',
						sortable : false,
						hidden : false
					},
					{
						dataIndex : 'leafEnglish',
						header : leafEnglishLabel,
						type : 'string',
						sortable : false,
						hidden : false
					},
					{
						dataIndex : 'leafFilename',
						header : leafFilenameLabel,
						type : 'string',
						sortable : false,
						hidden : false
					},
					{
						dataIndex : 'iconName',
						header : iconNameLabel,
						type : 'string',
						sortable : false,
						hidden : false,
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
						header : createTimeLabel,
						type : 'date',
						sortable : true,
						hidden : true,
						width : 100
					} ];
			var leafTranslateColumnModel = [ new Ext.grid.RowNumberer(), {
				dataIndex : "leafEnglish",
				header : "leafEnglish",
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
				dataIndex : "leafNative",
				header : "leafNative",
				sortable : true,
				hidden : false,
				width : 100,

				editor : {
					xtype : 'textfield',
					id : 'leafNative'
				}

			} ];

			var accessArray = [ 'isDefault', 'isNew', 'isDraft', 'isUpdate',
					'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost' ];

			var leafGrid = new Ext.grid.GridPanel(
					{
						border : false,
						store : leafStore,
						autoHeight : false,
						columns : leafColumnModel,
						loadMask : true,
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
								var record = leafStore.getAt(rowIndex);
								formPanel.getForm().reset();
								formPanel.form.load({
									url : "../controller/leafController.php",
									method : "POST",
									waitTitle : systemLabel,
									waitMsg : waitMessageLabel,
									params : {
										method : "read",
										mode : "update",
										leafId : record.data.leafId,
										leafIdTemp : leafIdTemp
									},
									success : function(form, action) {

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
										text :CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												leafStore
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
												leafStore
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
												url = '../controller/leafController.php?';
												var sub_url;
												sub_url = '';
												var modified = leafStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = leafStore
															.getAt(i);
													sub_url = sub_url
															+ '&leafId[]='
															+ record
																	.get('leafId');
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
																	leafStore
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
							store : leafStore,
							pageSize : perPage
						})
					});

			var leafTranslateEditor = new Ext.ux.grid.RowEditor(
					{
						saveText : 'Save',
						listeners : {
							CancelEdit : function(rowEditor, changes, record,
									rowIndex) {
								leafTranslateStore.reload();

							},
							afteredit : function(rowEditor, changes, record,
									rowIndex) {

								this.save = true;
								// update record manually
								var record = this.grid.getStore().getAt(
										rowIndex);

								Ext.Ajax
										.request({
											url : '../controller/leafTranslateController.php',
											method : 'POST',
											waitTitle : 'Harap Sabar',
											waitMsg : waitMessageLabel,
											params : {
												leafId : leafId,
												method : 'save',
												leafTranslateId : record
														.get('leafTranslateId'),
												leafTranslate : Ext.getCmp(
														'leafTranslate')
														.getValue()

											},
											success : function(response,
													options) {
												jsonResponse = Ext
														.decode(response.responseText);
												if (jsonResponse == false) {
													Ext.MessageBox
															.alert(
																	systemErrorLabel,
																	jsonResponse.message);
												} else {

													// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
													leafTranslateStore.reload();
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
					});

			function deleteRow(btn) {
				if (btn == 'yes') {
					var selections = approved.selModel.getSelections();
					var prez = [];
					var i =0;
					for (i ; i < approved.selModel.getCount(); i++) {
						prez.push(selections[i].json.leafTranslateId);
					}
					var encoded_array = Ext.encode(prez);

					Ext.Ajax.request({
						url : '../controller/leafController.php',
						method : 'POST',
						params : {
							method : "DELETE",
							ids : encoded_array,
							leafId : leafId
						},
						success : function(response, options) {
							jsonResponse = Ext.decode(response.responseText);
							if (jsonResponse.success == true) {
								Ext.MessageBox.alert(systemLabel,
										jsonResponse.message);
							} else {
								Ext.MessageBox.alert(systemErrorLabel,
										jsonResponse.message);
							}

						},
						failure : function(response, options) {

							Ext.MessageBox.alert(systemErrorLabel,
									escape(response.status) + ":"
											+ escape(response.statusText));
						}
					});

					leafTranslate.reload();
				}
			}

			var leafTranslateGrid = new Ext.grid.GridPanel({
				name : 'leafTranslateGrid',
				id : 'leafTranslateGrid',
				border : false,
				store : leafTranslateStore,
				height : 400,
				autoScroll : true,
				columns : leafTranslateColumnModel,
				disabled : true,
				viewConfig : {
					autoFill : true,
					forceFit : true
				},

				layout : 'fit',
				plugins : [ leafTranslateEditor ]
			});

			var gridPanel = new Ext.Panel(
					{
						title : 'Menu Listing',
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
										leafStore.reload();
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
													url : '../controller/leafController.php?method=report&mode=excel&limit='
															+ perPage
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														jsonResponse = Ext
																.decode(response.responseText);
														if (jsonResponse.success == true) {

															window
																	.open("../security/document/excel/leaf.xlsx");
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
								}, '->', new Ext.ux.form.SearchField({
									store : leafStore,
									width : 320
								}) ],
						items : [ leafGrid ]
					});
			// viewport just save information,items will do separate

			var moduleId = new Ext.ux.form.ComboBoxMatch(
					{
						labelAlign : 'left',
						fieldLabel : moduleIdLabel,
						name : 'moduleId',
						hiddenName : 'moduleId',
						valueField : 'moduleId',
						id : 'module_fake',
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
							value = Ext.escapeRe(value.split('').join('\\s*'))
									.replace(/\\\\s\\\*/g, '\\s*');
							return new RegExp('\\b(' + value + ')', 'i');
						},
						listeners : {
							'select' : function() {

								folderStore.proxy = new Ext.data.HttpProxy(
										{
											url : '../controller/leafController.php?method=read&field=folderId&type=1&moduleId='
													+ this.value
													+ '&leafIdTemp='
													+ leafIdTemp,
											method : "GET",
											success : function(response,
													options) {
												jsonResponse = Ext
														.decode(response.responseText);
												if (jsonResponse.totalCount == 0) {

													folderId.disable();
												} else {

													folderId.enable();
												}
												if (jsonResponse.success == true) {
													/*
													 * Ext.MessageBox .alert(
													 * systemLabel,
													 * jsonResponse.message);
													 * 
													 * leafTranslateStore
													 * .reload();
													 */

												} else {
													/*
													 * Ext.MessageBox .alert(
													 * systemErrorLabel,
													 * jsonResponse.message);
													 */
												}
											},
											listeners : {

												exception : function(DataProxy,
														type, action, options,
														response, arg) {
													var serverMessage = Ext.util.JSON
															.decode(response.responseText);

													if (serverMessage.success == false) {
														Ext.MessageBox
																.alert(
																		systemErrorLabel,
																		'Error ka'
																				+ serverMessage.message);
													}
												}
											}
										});

								folderStore.load();
							}
						}
					});

			var folderId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : folderIdLabel,
				name : 'folderId',
				hiddenName : 'folderId',
				valueField : 'folderId',
				id : 'folder_fake',
				displayField : 'folderEnglish',
				typeAhead : false,
				triggerAction : 'all',
				store : folderStore,
				anchor : '95%',
				selectOnFocus : true,
				mode : 'local',
				allowBlank : false,
				blankText : blankTextLabel,
				disabled : true,
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
							url : '../controller/leafController.php',
							method : 'GET',
							params : {
								method : 'read',
								field : 'sequence',
								table : 'leaf',
								moduleId : Ext.getCmp('tab_fake').getValue(),
								folderId : combo.value,
								leafId : leafIdTemp
							},
							success : function(response, options) {
								jsonResponse = Ext
										.decode(response.responseText);
								if (jsonResponse.success == false) {
									Ext.MessageBox.alert(systemErrorLabel,
											jsonResponse.message);
								} else {

									Ext.getCmp('leafSequence').setValue(
											jsonResponse.nextSequence);

								}

							},
							failure : function(response, options) {

								Ext.MessageBox.alert(systemErrorLabel,
										escape(response.status) + ":"
												+ escape(response.statusText));
							}

						});
					}
				}
			});

			var leafCode = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : leafCodeLabel,
				hiddenName : 'leafCode',
				name : 'leafCode',
				anchor : '95%'
			});

			var leafEnglish = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : leafEnglishLabel,
				hiddenName : 'leafEnglish',
				name : 'leafEnglish',
				anchor : '95%'
			});

			var leafSequence = new Ext.form.NumberField({
				labelAlign : 'left',
				fieldLabel : leafSequenceLabel,
				hiddenName : 'leafSequence',
				name : 'leafSequence',
				id : 'leafSequence',
				anchor : '95%'
			});

			var leafFilename = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : leafFilenameLabel,
				hiddenName : 'leafFilename',
				name : 'leafFilename',
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
			var leafId = new Ext.form.Hidden({
				name : 'leafId',
				id : 'leafId'
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
						url : '../controller/leafController.php',
						method : 'post',
						frame : true,
						title : 'Menu Administration',
						border : false,
						bodyStyle : 'padding: 10px',
						width : 600,
						iconCls : 'application_form',
						items : [
								{
									xtype : 'panel',
									title : leafEnglish,
									bodyStyle : "padding:5px",
									layout : 'form',
									frame : true,
									items : [ moduleId, folderId, leafCode,leafEnglish,
											leafSequence, leafFilename, iconId,
											leafId ]
								}, {
									xtype : 'panel',
									title : 'Leaf Translation',
									items : [ leafTranslateGrid ]
								} ],
						buttonVAlign : 'top',
						buttonAlign : 'left',
						buttons : [
								{
									text : saveButtonLabel,
									iconCls : 'bullet_disk',
									handler : function() {
										var id = 0;
										id = Ext.getCmp('leafId').getValue();
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
																leafIdTemp : leafIdTemp
															},
															success : function(
																	form,
																	action) {
																Ext.MessageBox
																		.alert(
																				systemLabel,
																				action.result.message);

																leafStore
																		.reload({
																			params : {
																				leafIdTemp : leafIdTemp,
																				start : 0,
																				limit : perPage
																			}
																		});
																Ext
																		.getCmp(
																				'translation')
																		.enable();
																Ext
																		.getCmp(
																				'leafId')
																		.setValue(
																				action.result.leafId);
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

													url : "../controller/leafController.php",
													method : 'GET',
													params : {
														leafIdTemp : leafIdTemp,
														method : 'translate',
														leafId : Ext.getCmp(
																'leafId')
																.getValue()
													},
													success : function(
															response, options) {
														jsonReponse = Ext
																.decode(response.responseText);
														if (jsonResponse.success == true) {
															Ext.MessageBox
																	.alert(
																			systemLabel,
																			jsonResponse.message);

															leafTranslateStore
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
