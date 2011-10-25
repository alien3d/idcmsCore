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
				baseParams : {
					method : "read",
					leafId : leafId,
					isAdmin : isAdmin,
					start : 0,
					limit : perPage,
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

	
			var religionDetailProxy = new Ext.data.HttpProxy({
				url : "../controller/religionDetailController.php",
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
			var religionDetailReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "religionDetailId"
			});
			var religionDetailStore = new Ext.data.JsonStore({
				proxy : religionDetailProxy,
				reader : religionDetailReader,
				autoLoad : false,
				autoDestroy : true,
				baseParams : {
					method : "read",
					leafId : leafId,
					isAdmin : isAdmin,
					start : 0,
					limit : perPage,
					perPage : perPage
				},
				root : "dataDetail",
				fields : [ {
					name : "religionDetailId",
					type : "int"
				}, {
					name : "religionId",
					type : "int"
				}, {
					name : "religionDesc",
					type : "string"
				}, {
					name : "religionDetailTitle",
					type : "string"
				}, {
					name : "religionDetailDesc",
					type : "string"
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

			var logProxy = new Ext.data.HttpProxy({
				url : "../../security/controller/logController.php?",
				method : "POST",
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
				}, {
					name : 'leafId',
					type : 'int'
				} ]
			});
			var religionFilters = new Ext.ux.grid.GridFilters({ 
				encode : encode,
				local : local,
				filters : [ {
					type : 'string',
					dataIndex : 'religionDesc',
					column : 'religionDesc',
					table : 'religion'
				}, {
					type : "list",
					dataIndex : "executeBy",
					column : "executeBy",
					table : "religion",
					labelField : "staffName",
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dateFormat : 'Y-m-d H:i:s',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'religion'
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

			var isDefaultGridDetail = new Ext.ux.grid.CheckColumn({
				header : isDefaultLabel,
				dataIndex : 'isDefault',
				hidden : isDefaultHidden
			});
			var isNewGridDetail = new Ext.ux.grid.CheckColumn({
				header : isNewLabel,
				dataIndex : 'isNew',
				hidden : isNewHidden
			});
			var isDraftGridDetail = new Ext.ux.grid.CheckColumn({
				header : isDraftLabel,
				dataIndex : 'isDraft',
				hidden : isDraftHidden
			});
			var isUpdateGridDetail = new Ext.ux.grid.CheckColumn({
				header : isUpdateLabel,
				dataIndex : 'isUpdate',
				hidden : isUpdateHidden
			});
			var isDeleteGridDetail = new Ext.ux.grid.CheckColumn({
				header : isDeleteLabel,
				dataIndex : 'isDelete'
			});
			var isActiveGridDetail = new Ext.ux.grid.CheckColumn({
				header : isActiveLabel,
				dataIndex : 'isActive',
				hidden : isActiveHidden
			});
			var isApprovedGridDetail = new Ext.ux.grid.CheckColumn({
				header : isApprovedLabel,
				dataIndex : 'isApproved',
				hidden : isApprovedHidden
			});

			var isReviewGridDetail = new Ext.ux.grid.CheckColumn({
				header : isReviewLabel,
				dataIndex : 'isReview',
				hidden : isReviewHidden
			});
			var isPostGridDetail = new Ext.ux.grid.CheckColumn({
				header : isPostLabel,
				dataIndex : 'isPost',
				hidden : isPostHidden
			});
			var religionColumnModel = [ new Ext.grid.RowNumberer(),

			{
				dataIndex : "religionDesc",
				header : religionDescLabel,
				hidden : false,
				width : 100
			}, isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid,
					isDeleteGrid, isActiveGrid, isApprovedGrid, isReviewGrid,
					isPostGrid, {
						dataIndex : 'executeBy',
						header : executeByLabel,
						hidden : true,
						width : 100
					}, {
						dataIndex : 'executeTime',
						header : executeTimeLabel,
						type : 'date',
						hidden : true,
						width : 100
					} ];
			var religionDetailColumnModel = [ new Ext.grid.RowNumberer(), {
				dataIndex : "religionDesc",
				header : "Religion Desc",
				hidden : false,
				width : 100
			}, {
				dataIndex : "religionDetailTitle",
				header : "Religion Title",
				hidden : false,
				width : 100,
				editor : {
					xtype : 'textfield',
					id : 'religionDetailTitle'
				}
			}, {
				dataIndex : "religionDetailDesc",
				header : "religion Detail Description",
				hidden : false,
				width : 100,
				editor : {
					xtype : 'textfield',
					id : 'religionDetailDesc'
				}
			}, isDefaultGridDetail, isNewGridDetail, isDraftGridDetail,
					isUpdateGridDetail, isDeleteGridDetail, isActiveGridDetail,
					isApprovedGridDetail, isReviewGridDetail, isPostGridDetail,
					{
						dataIndex : 'executeBy',
						header : executeByLabel,
						hidden : true,
						width : 100
					}, {
						dataIndex : 'executeTime',
						header : executeTimeLabel,
						type : 'date',
						hidden : true,
						width : 100
					} ];

			var accessArray = [ 'isDefault', 'isNew', 'isDraft', 'isUpdate',
					'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost' ];
			var accessDetailArray = [ 'isDefault', 'isNew', 'isDraft',
					'isUpdate', 'isDelete', 'isActive', 'isApproved',
					'isReview', 'isPost' ];
			var religionGrid = new Ext.grid.GridPanel(
					{
						border : false,
						store : religionStore,
						autoHeight : false,
						columns : religionColumnModel,
						loadMask : true,
						plugins : [ religionFilters ],
						autoScroll : true,

						sm : new Ext.grid.RowSelectionModel({
							singleSelect : true
						}),
						viewConfig : {
							forceFit : true
						},
						iconCls : 'application_view_detail',
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
														.getCmp('firstRecord')
														.setValue(
																action.result.firstRecord);
												Ext
														.getCmp(
																'previousRecord')
														.setValue(
																action.result.previousRecord);
												Ext
														.getCmp('nextRecord')
														.setValue(
																action.result.nextRecord);
												Ext
														.getCmp('lastRecord')
														.setValue(
																action.result.lastRecord);
												Ext
														.getCmp('endRecord')
														.setValue(
																(action.result.lastRecord + 1));
												
												religionDetailStore
														.load({
															params : {
																leafId : leafId,
																isAdmin : isAdmin,
																religionId : record.data.religionId
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
												if (Ext.getCmp('nextRecord')
														.getValue() == 0) {
													Ext.getCmp('nextButton')
															.disable();
												}
												religionDetailGrid.enable();
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
														}); 
											}
										}
									} ]
						},
						bbar : new Ext.PagingToolbar({
							store : religionStore,
							pageSize : perPage
						}),
						view : new Ext.ux.grid.BufferView({
							rowHeight : 34,
							scrollDelay : false
						})

					});
			var religionDetailEditor = new Ext.ux.grid.RowEditor(
					{
						saveText : saveButtonLabel,
						cancelText : cancelButtonLabel,
						listeners : {
							cancelEdit : function(rowEditor, changes, record,
									rowIndex) {
								religionDetailStore.reload();
							},
							afteredit : function(rowEditor, changes, record,
									rowIndex) {
								var method;
								this.save = true; // update record manually
								var record = this.grid.getStore().getAt(
										rowIndex);

								if (parseInt(record.get('religionDetailId')) == 'NaN') {
									method = 'create';
								} else if (record.get('religionDetailId') == '') {
									method = 'create';
								}  else if (record.get('religionDetailId') == undefined) {
									method = 'create';
								}else if (record.get('religionDetailId') > 0) {
									method = 'save';
								} else {
									method = 'create';
								}
								Ext.Ajax
										.request({
											url : '../controller/religionDetailController.php',
											method : 'POST',
											params : {
												leafId : leafId,
												method : method,
												page : 'detail',
												religionDetailId : record
														.get('religionDetailId'),
												religionId : Ext.getCmp(
														'religionId')
														.getValue(),
												religionDetailTitle : Ext
														.getCmp(
																'religionDetailTitle')
														.getValue(),
												religionDetailDesc : Ext
														.getCmp(
																'religionDetailDesc')
														.getValue()
											},
											success : function(response,
													options) {
												jsonResponse = Ext
														.decode(response.responseText);
												if (jsonResponse.success == false) {
													Ext.MessageBox
															.alert(
																	systemLabel,
																	jsonResponse.message);
												} else {
													religionDetailStore
															.reload({
																params : {
																	leafId : leafId,
																	isAdmin : isAdmin,
																	religionId : Ext
																			.getCmp(
																					'religionId')
																			.getValue()
																}
															});
												}
											},
											failure : function(response,
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
			var religionDetailEntity = Ext.data.Record.create([ {
				name : "religionDetailId",
				type : "int"
			}, {
				name : "religionId",
				type : "int"
			}, {
				name : "religionDetail",
				type : "string"
			}, {
				name : "religionDetailTitle",
				type : "int"
			}, {
				name : "religionDetailDesc",
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
				name : "executeTime",
				type : "date",
				dateFormat : "Y-m-d H:i:s"
			} ]);
			var religionDetailGrid = new Ext.grid.GridPanel(
					{
						id : "religionDetailGrid",
						border : false,
						store : religionDetailStore,
						autoScroll : true,
						columns : religionDetailColumnModel,
						frame : true,
						forceLayout : true,
						disabled : true,
						viewConfig : {
							forceFit : true
						},
						height : 275,
						plugins : [ religionDetailEditor ],

						view : new Ext.ux.grid.BufferView({
							rowHeight : 34,
							scrollDelay : false
						}),
						tbar : {
							items : [
									{
										iconCls : 'add',
										id : 'add_record',
										name : 'add_record',
										text : newButtonLabel,
										handler : function() {
											var e = new religionDetailEntity({
												religionDetailId : '',
												religionId : '',
												religionDetailTitle : '',
												religionDetailDesc : '',
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
											religionDetailEditor.stopEditing();
											religionDetailStore.insert(0, e);
											religionDetailGrid
													.getSelectionModel()
													.getSelections();
											religionDetailEditor
													.startEditing(0);
										}
									},
									{
										text : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												religionDetailStore
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
												religionDetailStore
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

												url = '../controller/religionDetailController.php?';
												var sub_url;
												sub_url = '';
												var modified = religionDetailStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = religionDetailStore
															.getAt(i);
													sub_url = sub_url
															+ '&religionDetailId[]='
															+ record
																	.get('religionDetailId');
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
																	religionDetailStore
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
							store : religionDetailStore,
							pageSize : perPage
						}),
						view : new Ext.ux.grid.BufferView({
							rowHeight : 34,
							scrollDelay : false
						})
					});
			var gridPanel = new Ext.Panel(
					{
						title : leafEnglish,
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
										religionStore.reload();
									}
								},
								'-',
								{
									text : addToolbarLabel,
									iconCls : 'add',
									id : 'pageCreate',
									disabled : pageCreate,
									xtype : 'button',
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
													url : '../religionController.php?method=report&mode=excel&limit='
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
																	.open("../basic/document/excel/religion.xlsx");
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
									store : religionStore,
									width : 320
								}) ],
						items : [ religionGrid ]
					}); // viewport just save information,items will do separate

			// audit grid

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
					type : 'numeric',
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
				} ]
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
			} ];

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
				
					rowHeight : 34,

					scrollDelay : false
				})
			});

			// starting form entry
			var religionDesc_temp = new Ext.form.Hidden({
				name : "religionDesc_temp",
				id : "religionDesc_temp"
			});
			// form entry

			var religionDesc = new Ext.form.TextField({
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
				anchor : "95%"
			});
			var religionId = new Ext.form.Hidden({
				name : 'religionId',
				id : 'religionId',
				value:''
			});

			var firstRecord = new Ext.form.Hidden({
				name : 'firstRecord',
				id : 'firstRecord',
				value:''
			});

			var nextRecord = new Ext.form.Hidden({
				name : 'nextRecord',
				id : 'nextRecord',
				value:''
			});

			var previousRecord = new Ext.form.Hidden({
				name : 'previousRecord',
				id : 'previousRecord',
				value:''
			});
			var lastRecord = new Ext.form.Hidden({
				name : 'lastRecord',
				id : 'lastRecord',
				value:''
			});

			var endRecord = new Ext.form.Hidden({
				name : 'endRecord',
				id : 'endRecord',
				value:''
			});
			var formPanel = new Ext.form.FormPanel(
					{
						url : '../controller/religionController.php',
						name : 'formPanel',
						id : 'formPanel',
						method : 'post',
						frame : true,
						title :  leafNative,
						border : false,

						width : 600,
						items : [
								{
									xtype : 'panel',

									items : [ {
										xtype : 'fieldset',
										layout : 'form',
										bodyStyle : "padding:5px",
										border : true,
										frame : true,
										items : [ religionId, religionDesc,
												religionDesc_temp ]
									} ]
								}, religionDetailGrid ],

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
											religionDetailStore.reload();
											auditWindow.show().center();
										}
									}
								},

								{
									text : newButtonLabel,
									name :'newButton',
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
																				'religionDetailGrid')
																		.enable();
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
																page : 'master'
															},
															success : function(
																	form,
																	action) {
																if(action.result.success==true) { 
																Ext.MessageBox
																		.alert(
																				title,
																				action.result.message);
																Ext
																		.getCmp(
																				'religionDetailGrid')
																		.enable();
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
																								'religionDetail')
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
									disable: true,
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
														religionDetailStore
																.load({
																	params : {
																		leafId : leafId,
																		isAdmin : isAdmin,
																		religionId : action.result.data.religionId
																	}
																});

														religionDetailGrid
																.enable();
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
										} else {
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
														religionDetailStore
																.load({
																	params : {
																		leafId : leafId,
																		isAdmin : isAdmin,
																		religionId : action.result.data.religionId
																	}
																});

														religionDetailGrid
																.enable();
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

															religionDetailStore
																	.load({
																		params : {
																			leafId : leafId,
																			isAdmin : isAdmin,
																			religionId : action.result.data.religionId
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
															religionDetailGrid
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

															religionDetailStore
																	.load({
																		params : {
																			leafId : leafId,
																			isAdmin : isAdmin,
																			religionId : action.result.data.religionId
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
															religionDetailGrid
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
																				if(action.result.nextRecord == 0 ) { 
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

																				religionDetailStore
																						.load({
																							params : {
																								leafId : leafId,
																								isAdmin : isAdmin,
																								religionId : action.result.data.religionId
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

																				religionDetailGrid
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
															if(action.result.nextRecord == 0 ) { 
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

															religionDetailStore
																	.load({
																		params : {
																			leafId : leafId,
																			isAdmin : isAdmin,
																			religionId : action.result.data.religionId
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

															religionDetailGrid
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

			var auditWindow = new Ext.Window({
				name :'auditWindow',
				id :'auditWindow',
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
				name :'viewport',
				id : 'viewport',
				region : 'center',
				layout : 'accordion',
				layoutConfig : { // layout-specific configs go here
					titleCollapse : true,
					animate : false,
					activeOnTop : true
				},
				items : [ gridPanel, formPanel ]
			});
		});