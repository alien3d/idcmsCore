Ext
		.onReady(function() {
			Ext.QuickTips.init();
			Ext.BLANK_IMAGE_URL = "../../javascript/resources/images/s.gif";
			Ext.form.Field.prototype.msgTarget = "under";
			Ext.Ajax.timeout = 90000;
			var pageCreate;
			var pageCreateList;
			var pageReload;
			var pageReloadList;
			var pagePrint;
			var pagePrintList;
			var perPage = 500;
			var encode = false;
			var local = false;
			var jsonResponse;
			var duplicate = 0;
			var auditButtonlabel ='audit';
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

			// master table
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
				baseParams : {
					method : "read",
					grid : "master",
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
					name : "By",
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

			// detail table
			var religionDetailProxy = new Ext.data.HttpProxy({
				url : "../controller/religionDetailController.php",
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
			var filters = new Ext.ux.grid.GridFilters({ // encode and local
				// configuration options
				// defined previously
				// for
				// easier reuse
				encode : encode,
				// json encode the filter query
				local : false,
				// defaults to false (remote filtering)
				filters : [ {
					type : 'string',
					dataIndex : 'religionDesc',
					column : 'religionDesc',
					table : 'religion'
				}, {
					type : "list",
					dataIndex : "By",
					column : "By",
					table : "religion",
					labelField : "staffName",
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dateFormat : 'Y-m-d H:i:s',
					dataIndex : 'createTime',
					column : 'createTime',
					table : 'religion'
				} ]
			});
			var isDefaultGrid = new Ext.ux.grid.CheckColumn({
				header : 'Default',
				dataIndex : 'isDefault',
				hidden : isDefaultHidden
			});
			var isNewGrid = new Ext.ux.grid.CheckColumn({
				header : 'New',
				dataIndex : 'isNew',
				hidden : isNewHidden
			});
			var isDraftGrid = new Ext.ux.grid.CheckColumn({
				header : 'Draft',
				dataIndex : 'isDraft',
				hidden : isDraftHidden
			});
			var isUpdateGrid = new Ext.ux.grid.CheckColumn({
				header : 'Update',
				dataIndex : 'isUpdate',
				hidden : isUpdateHidden
			});
			var isDeleteGrid = new Ext.ux.grid.CheckColumn({
				header : 'Delete',
				dataIndex : 'isDelete'
			});
			var isActiveGrid = new Ext.ux.grid.CheckColumn({
				header : 'Active',
				dataIndex : 'isActive',
				hidden : isActiveHidden
			});
			var isApprovedGrid = new Ext.ux.grid.CheckColumn({
				header : 'Approved',
				dataIndex : 'isApproved',
				hidden : isApprovedHidden
			});

			var isReviewGrid = new Ext.ux.grid.CheckColumn({
				header : 'Review',
				dataIndex : 'isReview',
				hidden : isReviewHidden
			});
			var isPostGrid = new Ext.ux.grid.CheckColumn({
				header : 'Post',
				dataIndex : 'isPost',
				hidden : isPostHidden
			});

			var isDefaultGridDetail = new Ext.ux.grid.CheckColumn({
				header : 'Default',
				dataIndex : 'isDefault',
				hidden : isDefaultHidden
			});
			var isNewGridDetail = new Ext.ux.grid.CheckColumn({
				header : 'New',
				dataIndex : 'isNew',
				hidden : isNewHidden
			});
			var isDraftGridDetail = new Ext.ux.grid.CheckColumn({
				header : 'Draft',
				dataIndex : 'isDraft',
				hidden : isDraftHidden
			});
			var isUpdateGridDetail = new Ext.ux.grid.CheckColumn({
				header : 'Update',
				dataIndex : 'isUpdate',
				hidden : isUpdateHidden
			});
			var isDeleteGridDetail = new Ext.ux.grid.CheckColumn({
				header : 'Delete',
				dataIndex : 'isDelete'
			});
			var isActiveGridDetail = new Ext.ux.grid.CheckColumn({
				header : 'Active',
				dataIndex : 'isActive',
				hidden : isActiveHidden
			});
			var isApprovedGridDetail = new Ext.ux.grid.CheckColumn({
				header : 'Approved',
				dataIndex : 'isApproved',
				hidden : isApprovedHidden
			});

			var isReviewGridDetail = new Ext.ux.grid.CheckColumn({
				header : 'Review',
				dataIndex : 'isReview',
				hidden : isReviewHidden
			});
			var isPostGridDetail = new Ext.ux.grid.CheckColumn({
				header : 'Post',
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
						header : createByLabel,
						hidden : true,
						width : 100
					}, {
						dataIndex : 'executeTime',
						header : createTimeLabel,
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
						header : createByLabel,
						hidden : true,
						width : 100
					}, {
						dataIndex : 'executeTime',
						header : createTimeLabel,
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
						plugins : [ filters ],
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
												// load the detail grid
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
										text : 'Check All',
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
										text : 'Clear All',
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
										text : 'save',
										iconCls : 'bullet_disk',
										listeners : {
											'click' : function(c) {
												var url;
												var count = religionStore
														.getCount();
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
						}),
						view : new Ext.ux.grid.BufferView({
							// custom row height
							rowHeight : 34,
							// render rows as they come into viewable area.
							scrollDelay : false
						})

					});
			var religionDetailEditor = new Ext.ux.grid.RowEditor(
					{
						saveText : 'Save',
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
								} else if (record.get('religionDetailId') > 0) {
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
							// custom row height
							rowHeight : 34,
							// render rows as they come into viewable area.
							scrollDelay : false
						}),
						tbar : {
							items : [
									{
										iconCls : 'add',
										id : 'add_record',
										name : 'add_record',
										text : 'New Record',
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
										text : 'Check All',
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												var count = religionDetailStore
														.getCount();
												religionDetailStore
														.each(function(rec) {
															for ( var access in accessDetailArray) { // alert(access);
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
										text : 'Clear All',
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
										text : 'save',
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
							// custom row height
							rowHeight : 34,
							// render rows as they come into viewable area.
							scrollDelay : false
						})
					});
			var gridPanel = new Ext.Panel(
					{
						title : leafNote,
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
				id : 'religionId'
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

			var endRecord = new Ext.form.Hidden({
				name : 'endRecord',
				id : 'endRecord'
			});
			var formPanel = new Ext.form.FormPanel(
					{
						url : '../controller/religionController.php',
						method : 'post',
						frame : true,
						title : 'Religion',
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

						buttonVAlign : 'top',
						buttonAlign : 'left',
						buttons : [
						           {
						        	 text : auditButtonLabel,
						        	 name : 'auditButtonLabel',
						        	 id :'auditButtonLabel',
						        	 type:'button',
						        	 iconCls : 'key',
						        	 disabled : true,
						        	 handler : function() {
						        		 // open popup grid lastest sql statemet.. fuh fuh fuh..
						        	 }
						           },

								{
									text : newButtonLabel,
									type : 'button',
									iconCls : 'new',
									handler : function() {
										var id = 0;
										var id = Ext.getCmp('religionId')
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
									text : saveButtonLabel,
									iconCls : 'bullet_disk',
									disabled : true,
									handler : function() {
										var id = 0;
										var id = Ext.getCmp('religionId')
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
									iconCls : 'trash',
									disabled : true,
									handler : function() {
										formPanel.getForm().reset();
									}
								},
								{
									text : resetButtonLabel,
									type : 'reset',
									iconCls : 'database_refresh',
									handler : function() {
										formPanel.getForm().reset();
									}

								},
								{
									text : postButtonLabel,
									type : 'button',
									iconCls : 'lock',
									handler : function() {
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
															if (jsonReponse.success == true) {
																Ext
																		.getCmp(
																				'firstRecord')
																		.setValue(
																				jsonResponse.firstRecord);
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
										}
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
														// load the detail grid
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
									disabled : true,
									handler : function() {
										if (Ext.getCmp('previousRecord')
												.getValue() == '') {
											Ext.MessageBox
													.alert("Please Pick A Record First Ya");

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
										if (Ext.getCmp('nextRecord').getValue() == '') {
											Ext.MessageBox
													.alert("Please Pick A Record First Ya");

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
										if (Ext.getCmp('lastRecord').getValue() == '') {
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
															if (jsonReponse.success == true) {
																Ext
																		.getCmp(
																				'lastRecord')
																		.setValue(
																				jsonResponse.lastRecord);
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
			var viewPort = new Ext.Viewport({
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