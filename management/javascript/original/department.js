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
			var perPage = 15;
			var encode = false;
			var local = false;
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
			var departmentProxy = new Ext.data.HttpProxy({
				url : "../controller/departmentController.php",
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
				pruneModifiedRecords : true,
				baseParams : {
					method : "read",
					grid : "master",
					leafId : leafId,
					isAdmin : isAdmin,
					start : 0,
					perPage : perPage
				},
				root : "data",
				fields : [ {
					name : "departmentId",
					type : "int"
				}, {
					name : "departmentSequence",
					type : "string"
				}, {
					name : "departmentCode",
					type : "string"
				}, {
					name : "departmentNote",
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
				url : "../controller/departmentController.php?",
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
					type : "string",
					dataIndex : "departmentSequence",
					column : "departmentSequence",
					table : "department"
				}, {
					type : "string",
					dataIndex : "departmentCode",
					column : "departmentCode",
					table : "department"
				}, {
					type : "string",
					dataIndex : "departmentNote",
					column : "departmentNote",
					table : "department"
				}, {
					type : "list",
					dataIndex : "By",
					column : "By",
					table : "department",
					labelField : "staffName",
					store : staffByStore,
					phpMode : true
				}, {
					type : "date",
					dataIndex : "Time",
					column : "Time",
					table : "department"
				} ]
			});

			var departmentSequence = new Ext.form.TextField({
				labelAlign : "left",
				fieldLabel : departmentSequenceLabel
						+ '<span style="color: red;">*</span>',
				hiddenName : "departmentSequence",
				name : "departmentSequence",
				id : "departmentSequence",
				allowBlank : false,
				blankText : blankTextLabel,
				style : {
					textTransform : "uppercase"
				},
				anchor : "95%"
			});

			var departmentCode = new Ext.form.TextField({
				labelAlign : "left",
				fieldLabel : departmentCodeLabel
						+ '<span style="color: red;">*</span>',
				hiddenName : "departmentCode",
				name : "departmentCode",
				id : "departmentCode",
				allowBlank : false,
				blankText : blankTextLabel,
				style : {
					textTransform : "uppercase"
				},
				anchor : "95%"
			});

			var departmentNote = new Ext.form.TextField({
				labelAlign : "left",
				fieldLabel : departmentNoteLabel
						+ '<span style="color: red;">*</span>',
				hiddenName : "departmentNote",
				name : "departmentNote",
				id : "departmentNote",
				allowBlank : false,
				blankText : blankTextLabel,
				style : {
					textTransform : "uppercase"
				},
				anchor : "95%"
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
				hidden : isReviewHidden
			});
			var departmentColumnModelGrid = [
					new Ext.grid.RowNumberer(),
					{
						dataIndex : "departmentSequence",
						header : departmentSequenceLabel,
						sortable : true,
						hidden : false,
						editor : departmentSequence

					},
					{
						dataIndex : "departmentCode",
						header : departmentCodeLabel,
						sortable : true,
						hidden : false,
						editor : departmentCode

					},
					{
						dataIndex : "departmentNote",
						header : departmentNoteLabel,
						sortable : true,
						hidden : false,
						editor : departmentNote

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
						header : byLabel,
						sortable : true,
						hidden : false,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return record.data.staffName;
						}
					},
					{
						dataIndex : "executeTime",
						header : timeLabel,
						sortable : true,
						hidden : false,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return Ext.util.Format.date(value, 'd-m-Y H:i:s');
						}
					} ];
			var accessArray = [ 'isDefault', 'isNew', 'isDraft', 'isUpdate',
					'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost' ];
			var departmentEditor = new Ext.ux.grid.RowEditor(
					{
						saveText : 'Save',
						listeners : {
							CancelEdit : function(rowEditor, changes, record,
									rowIndex) {
								departmentStore.reload();
							},
							afteredit : function(rowEditor, changes, record,
									rowIndex) {
								var method;
								this.save = true; // update record manually
								var record = this.grid.getStore().getAt(
										rowIndex);
								if (record.get('departmentId') > 0) {
									method = 'save';
								} else {
									method = 'create';
								}

								Ext.Ajax
										.request({
											url : '../controller/departmentController.php',
											method : 'POST',
											params : {
												method : method,
												leafId : leafId,
												departmentSequence : record
														.get('departmentSequence'),
												departmentCode : record
														.get('departmentCode'),
												departmentNote : record
														.get('departmentNote'),
												departmentId : record
														.get('departmentId'),
												duplicateTest : true
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
								departmentStore.reload();
							}
						}
					});
			var departmentEntity = Ext.data.Record.create([ {
				name : "departmentId",
				type : "int"
			}, {
				name : "departmentSequence",
				type : "string"
			}, {
				name : "departmentCode",
				type : "string"
			}, {
				name : "departmentNote",
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
			var departmentGrid = new Ext.grid.GridPanel(
					{
						border : false,
						store : departmentStore,
						autoHeight : false,
						height : 400,
						columns : departmentColumnModelGrid,
						plugins : [ filters, departmentEditor ],
						sm : new Ext.grid.RowSelectionModel({
							singleSelect : true
						}),
						viewConfig : {
							emptyText : emptyTextLabel
						},
						iconCls : "application_view_detail",
						tbar : {
							items : [
									{
										iconCls : 'add',
										id : 'add_record',
										name : 'add_record',
										text : 'New Record',
										handler : function() {
											var e = new departmentEntity({
												departmentId : '',
												departmentSequence : '',
												departmentCode : '',
												departmentNote : '',
												executeBy : '',
												staffName : '',
												isDefault : '',
												isNew : '',
												isDraft : '',
												isUpdate : '',
												isDelete : '',
												isActive : '',
												isApproved : '',
												isReview : '',
												isPost : '',
												executeTime : ''
											});
											departmentEditor.stopEditing();
											departmentStore.insert(0, e);
											departmentGrid
													.getSelectionModel()
													.getSelections();
											departmentEditor.startEditing(0);
										}
									},
									{
										text : 'Check All',
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												departmentStore
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
												departmentStore
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
												url = '../controller/departmentController.php?';
												var sub_url;
												sub_url = '';

												var modified = departmentStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = departmentStore
															.getAt(i);

													if (record
															.get('departmentId')) {
														sub_url = sub_url
																+ '&departmentId[]='
																+ record
																		.get('departmentId');
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
																	departmentStore
																			.removeAll(); // force
																	// to
																	// remove
																	// all
																	// data
																	departmentStore
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
							store : departmentStore,
							pageSize : perPage
						})
					});
		
			var gridPanel = new Ext.Panel(
					{
						title : leafNote,
						iconCls : "application_view_detail",
						layout : 'fit',
						tbar : [
								{
									text : reloadToolbarLabel,
									iconCls : "database_refresh",
									id : "pageReload",
									disabled : pageReload,
									handler : function() {
										departmentStore.reload();
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
													url : "../controller/departmentController.php",
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
									store : departmentStore,
									width : 320
								}) ],
						items : [ departmentGrid ]
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
				items : [ gridPanel ]
			});
		});