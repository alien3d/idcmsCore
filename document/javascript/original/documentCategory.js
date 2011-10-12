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
			var documentCategoryProxy = new Ext.data.HttpProxy({
				url : "../controller/documentCategoryController.php",
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
					name : "documentCategoryId",
					type : "int"
				}, {
					name : "documentCategoryTitle",
					type : "string"
				}, {
					name : "documentCategoryDesc",
					type : "string"
				}, {
					name : "documentCategorySequence",
					type : "string"
				}, {
					name : "documentCategoryCode",
					type : "string"
				}, {
					name : "documentCategoryNote",
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
				},  {
		            name: "isReview",
		            type: "boolean"
		        },
		        {
		            name: "isPost",
		            type: "boolean"
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
				url : "../controller/documentCategoryController.php?",
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
			var filters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : false,
				filters : [ {
					type : "string",
					dataIndex : "documentCategoryTitle",
					column : "documentCategoryTitle",
					table : "documentCategory"
				}, {
					type : "string",
					dataIndex : "documentCategoryDesc",
					column : "documentCategoryDesc",
					table : "documentCategory"
				}, {
					type : "string",
					dataIndex : "documentCategorySequence",
					column : "documentCategorySequence",
					table : "documentCategory"
				}, {
					type : "string",
					dataIndex : "documentCategoryCode",
					column : "documentCategoryCode",
					table : "documentCategory"
				}, {
					type : "string",
					dataIndex : "documentCategoryNote",
					column : "documentCategoryNote",
					table : "documentCategory"
				}, {
					type : "list",
					dataIndex : "By",
					column : "By",
					table : "documentCategory",
					labelField : "staffName",
					store : staffByStore,
					phpMode : true
				}, {
					type : "date",
					dataIndex : "Time",
					column : "Time",
					table : "documentCategory"
				} ]
			});

			var documentCategoryTitle = new Ext.form.TextField({
				labelAlign : "left",
				fieldLabel : documentCategoryTitleLabel
						+ '<span style="color: red;">*</span>',
				hiddenName : "documentCategoryTitle",
				name : "documentCategoryTitle",
				id : "documentCategoryTitle",

				blankText : blankTextLabel,
				style : {
					textTransform : "uppercase"
				},
				anchor : "95%"
			});

			var documentCategoryDesc = new Ext.form.TextField({
				labelAlign : "left",
				fieldLabel : documentCategoryDescLabel
						+ '<span style="color: red;">*</span>',
				hiddenName : "documentCategoryDesc",
				name : "documentCategoryDesc",
				id : "documentCategoryDesc",

				blankText : blankTextLabel,
				style : {
					textTransform : "uppercase"
				},
				anchor : "95%"
			});
			var documentCategorySequence = new Ext.form.NumberField({
				labelAlign : "left",
				fieldLabel : documentCategorySequenceLabel
						+ '<span style="color: red;">*</span>',
				hiddenName : "documentCategorySequence",
				name : "documentCategorySequence",
				id : "documentCategorySequence",

				blankText : blankTextLabel,
				style : {
					textTransform : "uppercase"
				},
				anchor : "95%"
			});

			var documentCategoryCode = new Ext.form.TextField({
				labelAlign : "left",
				fieldLabel : documentCategoryCodeLabel
						+ '<span style="color: red;">*</span>',
				hiddenName : "documentCategoryCode",
				name : "documentCategoryCode",
				id : "documentCategoryCode",

				blankText : blankTextLabel,
				style : {
					textTransform : "uppercase"
				},
				anchor : "95%"
			});

			var documentCategoryNote = new Ext.form.TextField({
				labelAlign : "left",
				fieldLabel : documentCategoryNoteLabel
						+ '<span style="color: red;">*</span>',
				hiddenName : "documentCategoryNote",
				name : "documentCategoryNote",
				id : "documentCategoryNote",

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
			var documentCategoryColumnModelGrid = [
					new Ext.grid.RowNumberer(),
					{
						dataIndex : "documentCategoryTitle",
						header : documentCategoryTitleLabel,
						sortable : true,
						hidden : false,
						editor : documentCategoryTitle

					},
					{
						dataIndex : "documentCategoryDesc",
						header : documentCategoryDescLabel,
						sortable : true,
						hidden : false,
						editor : documentCategoryDesc

					},
					{
						dataIndex : "documentCategorySequence",
						header : documentCategorySequenceLabel,
						sortable : true,
						hidden : false,
						editor : documentCategorySequence

					},
					{
						dataIndex : "documentCategoryCode",
						header : documentCategoryCodeLabel,
						sortable : true,
						hidden : false,
						editor : documentCategoryCode

					},
					{
						dataIndex : "documentCategoryNote",
						header : documentCategoryNoteLabel,
						sortable : true,
						hidden : false,
						editor : documentCategoryNote

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
			var documentCategoryEditor = new Ext.ux.grid.RowEditor(
					{
						saveText : 'Save',
						listeners : {
							CancelEdit : function(rowEditor, changes, record,
									rowIndex) {
								documentCategoryStore.reload();
							},
							afteredit : function(rowEditor, changes, record,
									rowIndex) {
								var method;
								this.save = true; // update record manually
								var record = this.grid.getStore().getAt(
										rowIndex);
								if (record.get('documentCategoryId') > 0) {
									method = 'save';
								} else {
									method = 'create';
								}

								Ext.Ajax
										.request({
											url : '../controller/documentCategoryController.php',
											method : 'POST',
											params : {
												method : method,
												leafId : leafId,
												documentCategoryTitle : record
														.get('documentCategoryTitle'),
												documentCategoryDesc : record
														.get('documentCategoryDesc'),
												documentCategorySequence : record
														.get('documentCategorySequence'),
												documentCategoryCode : record
														.get('documentCategoryCode'),
												documentCategoryNote : record
														.get('documentCategoryNote'),
												documentCategoryId : record
														.get('documentCategoryId'),
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
								documentCategoryStore.reload();
							}
						}
					});
			var documentCategoryEntity = Ext.data.Record.create([ {
				name : "documentCategoryId",
				type : "int"
			}, {
				name : "documentCategorySequence",
				type : "string"
			}, {
				name : "documentCategoryCode",
				type : "string"
			}, {
				name : "documentCategoryNote",
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
				name : "executeTime",
				type : "date",
				dateFormat : "Y-m-d H:i:s"
			} ]);
			var documentCategoryGrid = new Ext.grid.GridPanel(
					{
						border : false,
						store : documentCategoryStore,
						autoHeight : false,
						height : 400,
						columns : documentCategoryColumnModelGrid,
						plugins : [ filters, documentCategoryEditor ],
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
											var e = new documentCategoryEntity(
													{
														documentCategoryId : '',
														documentCategorySequence : '',
														documentCategoryCode : '',
														documentCategoryNote : '',
														executeBy : '',
														staffName : '',
														isDefault : '',
														isNew : '',
														isDraft : '',
														isUpdate : '',
														isDelete : '',
														isActive : '',
														isApproved : '',
														executeTime : ''
													});
											documentCategoryEditor
													.stopEditing();
											documentCategoryStore.insert(0, e);
											 documentCategoryGrid
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
																			.removeAll();
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
										documentCategoryStore.reload();
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
													url : "../controller/documentCategoryController.php",
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
									store : documentCategoryStore,
									width : 320
								}) ],
						items : [ documentCategoryGrid ]
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