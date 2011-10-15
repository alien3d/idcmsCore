Ext
		.onReady(function() {
			Ext.Ajax.timeout = 90000000;
			Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';

			var pageCreate;
			var pageReload;
			var pagePrint;
			if (leafAccessCreateValue == 1) {
				var pageCreate = false;
			} else {
				var pageCreate = true;
			}
			if (leafAccessReadValue == 1) {
				var pageReload = false;
			} else {
				var pageReload = true;
			}
			if (leafAccessPrintValue == 1) {
				var pagePrint = false;
			} else {
				var pagePrint = true;
			}
			var perPage = 10;
			var encode = false;
			var local = false;
			var defaultLabelProxy = new Ext.data.HttpProxy({
				url : "../controller/defaultLabelController.php",
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

			var defaultLabelReader = new Ext.data.JsonReader({

				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "defaultLabelId"

			});
			var defaultLabelStore = new Ext.data.JsonStore({
				proxy : defaultLabelProxy,
				reader : defaultLabelReader,
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
					name : 'defaultLabelId',
					type : 'int'
				}, {
					name : 'defaultLabel',
					type : 'string'
				}, {
					name : 'defaultLabelEnglish',
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
					name : "Time",
					type : "date",
					dateFormat : "Y-m-d H:i:s"
				} ]
			});

			var defaultLabelTranslateProxy = new Ext.data.HttpProxy({
				url : "../controller/defaultLabelController.php",
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

			var defaultLabelTranslateReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "defaultLabelTranslateId"

			});
			var defaultLabelTranslateStore = new Ext.data.JsonStore({
				autoDestroy : true,
				proxy : defaultLabelTranslateProxy,
				reader : defaultLabelTranslateReader,
				baseParams : {
					method : "read",
					page : "detail",
					leafId : leafId
				},
				root : 'data',
				fields : [ {
					name : 'defaultLabelTranslateId',
					type : 'int'
				}, {
					name : 'defaultLabelId',
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
					name : 'defaultLabelTranslate',
					type : 'string'
				} ]
			});

			var staffProxy = new Ext.data.HttpProxy({
				url : "../controller/defaultLabelController.php?",
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
			
		    var staffByProxy = new Ext.data.HttpProxy({
		        url: "../controller/defaultLabelController.php?",
		        method: "GET",
		        success: function(response, options) {
		            jsonResponse = Ext.decode(response.responseText);
		            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,
		                // jsonResponse.message);
		                // //uncommen for testing
		                // purpose
		            } else {
		                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
		            }
		        },
		        failure: function(response, options) {
		            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
		        }
		    });
		    var staffByReader = new Ext.data.JsonReader({
		        totalProperty: "total",
		        successProperty: "success",
		        messageProperty: "message",
		        idProperty: "staffId"
		    });
		    var staffByStore = new Ext.data.JsonStore({
		        proxy: staffByProxy,
		        reader: staffByReader,
		        autoLoad: true,
		        autoDestroy: true,
		        baseParams: {
		            method: 'read',
		            field: 'staffId',
		            leafId: leafId
		        },
		        root: 'staff',
		        fields: [{
		            name: "staffId",
		            type: "int"
		        },
		        {
		            name: "staffName",
		            type: "string"
		        }]
		    });

			

			var filters = new Ext.ux.grid.GridFilters({
				// encode and local configuration options defined previously for
				// easier reuse
				encode : encode, // json encode the filter query
				local : false, // defaults to false (remote filtering)
				filters : [  {
					type : 'string',
					dataIndex : 'defaultLabel',
					column : 'defaultLabel',
					table : 'defaultLabel'
				}, {
					type : 'string',
					dataIndex : 'defaultLabelEnglish',
					column : 'defaultLabelEnglish',
					table : 'defaultLabel'
				},  {
					type : 'list',
					dataIndex : 'By',
					column : 'staffId',
					table : 'defaultLabel',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dateFormat : 'Y-m-d H:i:s',
					dataIndex : 'Time',
					column : 'Time',
					table : 'defaultLabel'
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
			var defaultLabelColumnModel = [
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
										var record = defaultLabelStore
												.getAt(rowIndex);
										formPanel.getForm().reset();
										formPanel.form
												.load({
													url : "../controller/defaultLabelController.php",
													method : "POST",
													waitTitle : systemLabel,
													waitMsg : waitMessageLabel,
													params : {
														method : "read",
														mode : "update",
														defaultLabelId : record.data.defaultLabelId,
														leafId : leafId
													},
													success : function(form,
															action) {
														Ext
																.getCmp(
																		"defaultLabelDesc_temp")
																.setValue(
																		record.data.defaultLabelDesc);
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
										var record = defaultLabelStore
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
																		url : "../controller/defaultLabelController.php",
																		params : {
																			method : "delete",
																			defaultLabelId : record.data.defaultLabelId,
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
																			defaultLabelStore
																					.reload({
																						params : {
																							leafId : leafId,
																							start : 0,
																							limit : perPage
																						}
																					});
																			defaultLabelStoreList
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
						dataIndex : 'defaultLabel',
						header : defaultLabel
					},
					{
						dataIndex : 'defaultLabelEnglish',
						header : defaultLabelEnglish
					}, isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid,
					isDeleteGrid, isActiveGrid, isApprovedGrid, {
						dataIndex : 'By',
						header : executeByLabel,
						sortable : true,
						hidden : true,
						width : 100
					}, {
						dataIndex : 'Time',
						header : createTimeLabel,
						type : 'date',
						sortable : true,
						hidden : true,
						width : 100
					}  ];

			
			var defaultLabelTranslateColumnModel = [ new Ext.grid.RowNumberer(), {
				dataIndex : "defaultLabelNote",
				header : defaultLabelSequenceLabel,
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
				dataIndex : "defaultLabelTranslate",
				header : "defaultLabelTranslate",
				sortable : true,
				hidden : false,
				width : 100,

				editor : {
					xtype : 'textfield',
					id : 'defaultLabelTranslate'
				}

			} ];
			
			 var accessArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved'];
			 
			var defaultLabelGrid = new Ext.grid.GridPanel(
					{
						border : false,
						store : defaultLabelStore,
						autoHeight : false,
						columns : defaultLabelColumnModel,
						loadMask : true,
						plugins : [ filters ],
						sm : new Ext.grid.RowSelectionModel({
							singleSelect : true
						}),
						viewConfig : {
							forceFit : true
						},
						iconCls : 'application_view_detail',
						listeners : {
							'rowclick' : function(object, rowIndex, e) {
								var record = defaultLabelStore.getAt(rowIndex);
								formPanel.getForm().reset();
								formPanel.form.load({
									url : "../controller/defaultLabelController.php",
									method : "POST",
									waitTitle : systemLabel,
									waitMsg : waitMessageLabel,
									params : {
										method : "read",
										mode : "update",
										defaultLabelId : record.data.defaultLabelId,
										leafId : leafId
									},
									success : function(form, action) {
										Ext.getCmp("defaultLabelDesc_temp").setValue(
												record.data.defaultLabelDesc);
										
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
										text : 'Check All',
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												
												defaultLabelStore
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
												defaultLabelStore
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
												var count = defaultLabelStore
														.getCount();
												url = '../controller/defaultLabelController.php?';
												var sub_url;
												sub_url = '';
												   var modified = defaultLabelStore.getModifiedRecords();
							                        for(var i = 0; i < modified.length; i++) {
													var record = defaultLabelStore
															.getAt(i);
													sub_url = sub_url
															+ '&defaultLabelId[]='
															+ record
																	.get('defaultLabelId');
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
																	defaultLabelStore
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
							store : defaultLabelStore,
							pageSize : perPage
						})
					});

			var defaultLabelTranslateEditor = new Ext.ux.grid.RowEditor(
					{
						saveText : 'Save',
						listeners : {
							CancelEdit : function(rowEditor, changes, record,
									rowIndex) {
								defaultLabelStore.reload();

							},
							afteredit : function(rowEditor, changes, record,
									rowIndex) {

								this.save = true;
								// @todo update record manually
								//var curr_store = this.grid.getStore().getAt(rowIndex);

								Ext.Ajax.request({
									url : '../controller/defaultLabelController.php',
									method : 'POST',
									waitMsg : 'Harap Bersabar',
									params : {
										leafId : leafId,
										method : 'save',
										page : 'detail',
										defaultLabelTranslateId : record
												.get('defaultLabelTranslateId'),
										defaultLabelTranslate : Ext.getCmp(
												'defaultLabelTranslate').getValue()

									},
									success : function(response, options) {
										jsonResponse = Ext.decode(response.responseText);
										if (jsonResponse == false) {
											Ext.MessageBox.alert(systemErrorLabel,
													jsonResponse.message);
										} else {
											// if required messagebox to check
											// status uncomment below
											Ext.MessageBox.alert(systemLabel,
													jsonResponse.message);
											defaultLabelTranslateStore.reload();
										}

									},
									failure : function(response, options) {
										
										Ext.MessageBox.alert(systemErrorLabel,
												escape(statusCode) + ":"
														+ escape(response.statusText));
									}
								});

							}
						}
					});

			var defaultLabelTranslateGrid = new Ext.grid.GridPanel({
				border : false,
				store : defaultLabelTranslateStore,
				height : 400,
				autoScroll : true,
				columns : defaultLabelTranslateColumnModel,
				viewConfig : {
					autoFill : true,
					forceFit : true
				},

				layout : 'fit',
				plugins : [ defaultLabelTranslateEditor ]
			});

			var gridPanel = new Ext.Panel(
					{
						title : 'defaultLabel Listing',
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
										defaultLabelStore.reload();
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
													url : '../controller/defaultLabelController.php?method=report&mode=excel&limit='
															+ perPage
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														jsonResponse = Ext.decode(response.responseText);
														if (jsonResponse == true) {

															window
																	.open("../../security/document/excel/defaultLabel.xlsx");
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
									store : defaultLabelStore,
									width : 320
								}) ],
						items : [ defaultLabelGrid ]
					});

			// viewport just save information,items will do separate
			// only load store when viewport is open

			var defaultLabel = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : defaultLabel,
				hiddenName : 'defaultLabel',
				name : 'defaultLabel',
				anchor : '95%'
			});
			var defaultLabelEnglish = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : defaultLabelEnglish,
				hiddenName : 'defaultLabelEnglish',
				name : 'defaultLabelEnglish',
				anchor : '95%'
			});

			

			

			// hidden id for updated
			var defaultLabelId = new Ext.form.Hidden({
				name : 'defaultLabelId',
				id : 'defaultLabelId'
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
						url : '../controller/defaultLabelController.php',
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
							items : [ defaultLabelId,defaultLabel,

							defaultLabelEnglish,defaultLabelId ]
						}, {
							xtype : 'panel',
							title : 'defaultLabel Translation',
							items : [ defaultLabelTranslateGrid ]
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
										id = Ext.getCmp('defaultLabelId').getValue();
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

																defaultLabelStore
																		.reload({
																			params : {
																				leafId : leafId,
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
																				'defaultLabelId')
																		.setValue(
																				action.result.defaultLabelId);
															},
															failure : function(
																	form,
																	action) {

																if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																	alert(loadFailureMessageLabel);
																} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
																	// here will
																	// be error
																	// if
																	// duplicate
																	// code
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

													url : "../controller/defaultLabelController.php",
													method : 'GET',
													waitTitle:'Translation',
													waitMessage:'Translation in Progress',
													params : {
														leafId : leafId,
														method : 'translate',
														defaultLabelId : Ext.getCmp(
																'defaultLabelId')
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

															defaultLabelTranslateStore
																	.reload();
															
														} else if (jsonResponse.success == false) {
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
