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
				pagePrint = false
			} else {
				pagePrint = true;
			}
			var teamProxy = new Ext.data.HttpProxy({
				url : "../controller/teamController.php",
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
					grid : "master",
					leafId : leafId,
					isAdmin : isAdmin,
					start : 0,
					perPage : perPage
				},
				root : "data",
				fields : [ {
					name : "teamId",
					type : "int"
				}, {
					name : "teamSequence",
					type : "string"
				}, {
					name : "teamCode",
					type : "string"
				}, {
					name : "teamEnglish",
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
					type : "int"
				}, {
					name : "isPost",
					type : "boolean"
				}, {
					name : "executeTime",
					type : "date",
					dateFormat : "Y-m-d H:i:s"
				} ]
			});
			var staffByProxy = new Ext.data.HttpProxy({
				url : "../controller/teamController.php?",
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
			var filters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : local,
				filters : [ {
					type : "string",
					dataIndex : "teamSequence",
					column : "teamSequence",
					table : "team"
				}, {
					type : "string",
					dataIndex : "teamCode",
					column : "teamCode",
					table : "team"
				}, {
					type : "string",
					dataIndex : "teamEnglish",
					column : "teamEnglish",
					table : "team"
				}, {
					type : "list",
					dataIndex : "executeBy",
					column : "executeBy",
					table : "team",
					labelField : "staffName",
					store : staffByStore,
					phpMode : true
				}, {
					type : "date",
					dataIndex : "executeTime",
					column : "executeTime",
					table : "team"
				} ]
			});

			var teamSequence = new Ext.form.TextField({
				labelAlign : "left",
				fieldLabel : teamSequenceLabel
						+ '<span style="color: red;">*</span>',
				hiddenName : "teamSequence",
				name : "teamSequence",
				id : "teamSequence",
				allowBlank : false,
				blankText : blankTextLabel,
				style : {
					textTransform : "uppercase"
				},
				anchor : "95%"
			});

			var teamCode = new Ext.form.TextField({
				labelAlign : "left",
				fieldLabel : teamCodeLabel
						+ '<span style="color: red;">*</span>',
				hiddenName : "teamCode",
				name : "teamCode",
				id : "teamCode",
				allowBlank : false,
				blankText : blankTextLabel,
				style : {
					textTransform : "uppercase"
				},
				anchor : "95%"
			});

			var teamEnglish = new Ext.form.TextField({
				labelAlign : "left",
				fieldLabel : teamEnglishLabel
						+ '<span style="color: red;">*</span>',
				hiddenName : "teamEnglish",
				name : "teamEnglish",
				id : "teamEnglish",
				allowBlank : false,
				blankText : blankTextLabel,
				style : {
					textTransform : "uppercase"
				},
				anchor : "95%"
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
				header : isActiveLabel,
				dataIndex : 'isReview',
				hidden : isReviewHidden
			});
			var isPostGrid = new Ext.ux.grid.CheckColumn({
				header : isPostLabel,
				dataIndex : 'isReview',
				hidden : isApprovedHidden
			});

			var teamColumnModelGrid = [
					new Ext.grid.RowNumberer(),
					{
						dataIndex : "teamSequence",
						header : teamSequenceLabel,
						sortable : true,
						hidden : false,
						editor : teamSequence

					},
					{
						dataIndex : "teamCode",
						header : teamCodeLabel,
						sortable : true,
						hidden : false,
						editor : teamCode

					},
					{
						dataIndex : "teamEnglish",
						header : teamEnglishLabel,
						sortable : true,
						hidden : false,
						editor : teamEnglish

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
							return Ext.util.Format.date(value, 'd-m-Y H:i:s');
						}
					} ];
			var accessArray = [ 'isDefault', 'isNew', 'isDraft', 'isUpdate',
					'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost' ];
			var teamEditor = new Ext.ux.grid.RowEditor(
					{
						saveText : 'Save',
						listeners : {
							CancelEdit : function(rowEditor, changes, record,
									rowIndex) {
								teamStore.reload();
							},
							afteredit : function(rowEditor, changes, record,
									rowIndex) {
								var method;
								this.save = true; // update record manually
								var record = this.grid.getStore().getAt(
										rowIndex);
								if (record.get('teamId') > 0) {
									method = 'save';
								} else {
									method = 'create';
								}

								Ext.Ajax.request({
									url : '../controller/teamController.php',
									method : 'POST',
									params : {
										method : method,
										leafId : leafId,
										teamSequence : record
												.get('teamSequence'),
										teamCode : record.get('teamCode'),
										teamEnglish : record.get('teamEnglish'),
										teamId : record.get('teamId'),
										duplicateTest : true
									},
									success : function(response, options) {
										jsonResponse = Ext
												.decode(response.responseText);
										if (jsonResponse.success == false) {
											Ext.MessageBox.alert(systemLabel,
													jsonResponse.message);
										}
									},
									failure : function(response, options) {
										Ext.MessageBox.alert(systemErrorLabel,
												escape(response.status) + ":"
														+ response.statusText);
									}
								});
								teamStore.reload();
							}
						}
					});
			var teamEntity = Ext.data.Record.create([ {
				name : "teamId",
				type : "int"
			}, {
				name : "teamSequence",
				type : "string"
			}, {
				name : "teamCode",
				type : "string"
			}, {
				name : "teamEnglish",
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
			var teamGrid = new Ext.grid.GridPanel(
					{
						border : false,
						store : teamStore,
						autoHeight : false,
						height : 400,
						columns : teamColumnModelGrid,
						plugins : [ filters, teamEditor ],
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
										text : newButtonLabel,
										handler : function() {
											var e = new teamEntity({
												teamId : '',
												teamSequence : '',
												teamCode : '',
												teamEnglish : '',
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
											teamEditor.stopEditing();
											teamStore.insert(0, e);
											var s = teamGrid
													.getSelectionModel()
													.getSelections();
											teamEditor.startEditing(0);
										}
									},
									{
										text : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												teamStore
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
												teamStore
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
												url = '../controller/teamController.php?';
												var sub_url;
												sub_url = '';

												var modified = teamStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = teamStore
															.getAt(i);

													if (record.get('teamId')) {
														sub_url = sub_url
																+ '&teamId[]='
																+ record
																		.get('teamId');
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
														+'&isReview[]='
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
																	teamStore
																			.removeAll(); // force
																	
																	teamStore
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
							store : teamStore,
							pageSize : perPage
						})
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
										teamStore.reload();
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
													url : "../controller/teamController.php",
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
									store : teamStore,
									width : 320
								}) ],
						items : [ teamGrid ]
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