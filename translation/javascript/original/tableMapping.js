Ext
		.onReady(function() {
			Ext.QuickTips.init();
			Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';
			Ext.form.Field.prototype.msgTarget = 'under';
			Ext.Ajax.timeout = 90000;
			var perPage = 15;
			var encode = false;
			var local = false;
			var jsonResponse;
			var duplicate = 0;
			// common Proxy,Reader,Store,Filter,Grid
			// start Staff Request
			var staffByProxy = new Ext.data.HttpProxy({
				url : '../controller/tableMappingController.php?',
				method : 'GET',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
					} else {
						Ext.MessageBox.alert(systemErrorLabel,
								jsonResponse.message);
					}
				},
				failure : function(response, options) {
					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ':'
									+ escape(response.statusText));
				}
			});
			var staffByReader = new Ext.data.JsonReader({
				totalProperty : 'total',
				successProperty : 'success',
				messageProperty : 'message',
				idProperty : 'staffId'
			});
			var staffByStore = new Ext.data.JsonStore({
				proxy : staffByProxy,
				reader : staffByReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				baseParams : {
					method : 'read',
					field : 'staffId',
					leafId : leafId
				},
				root : 'staff',
				   id:'staffId',
				fields : [ {
					name : 'staffId',
					type : 'int'
				}, {
					name : 'staffName',
					type : 'string'
				} ]
			}); // end Staff Request
			// start log Request
			var logProxy = new Ext.data.HttpProxy({
				url : '../../security/controller/logController.php?',
				method : 'POST',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
					} else {
						Ext.MessageBox.alert(systemErrorLabel,
								jsonResponse.message);
					}
				},
				failure : function(response, options) {
					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ':'
									+ escape(response.statusText));
				}
			});
			var logReader = new Ext.data.JsonReader({
				totalProperty : 'total',
				successProperty : 'success',
				messageProperty : 'message',
				idProperty : 'logId'
			});
			var logStore = new Ext.data.JsonStore({
				proxy : logProxy,
				reader : logReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				baseParams : {
					method : 'read',
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
			var logFilters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : local,
				filters : [ {
					type : 'numeric',
					dataIndex : 'logId',
					column : 'logId',
					table : 'log'
				}, {
					type : 'numeric',
					dataIndex : 'leafId',
					column : 'leafId',
					table : 'log'
				}, {
					type : 'string',
					dataIndex : 'operation',
					column : 'operation',
					table : 'log'
				}, {
					type : 'string',
					dataIndex : 'sql',
					column : 'sql',
					table : 'log'
				}, {
					type : 'date',
					dataIndex : 'date',
					column : 'date',
					table : 'log'
				}, {
					type : 'numeric',
					dataIndex : 'staffId',
					column : 'staffId',
					table : 'log'
				}, {
					type : 'string',
					dataIndex : 'access',
					column : 'access',
					table : 'log'
				}, {
					type : 'string',
					dataIndex : 'logError',
					column : 'logError',
					table : 'log'
				} ]
			});
			var logExpander = new Ext.ux.grid.RowExpander({
				tpl : new Ext.Template(
						'<br><p><b>Operation:</b> {operation}</p><br>',
						'<p><b>SQL STATEMENT:</b> {sql}</p><br>')
			});
			var logColumnModel = [ logExpander, new Ext.grid.RowNumberer(), {
				dataIndex : 'logId',
				header : logIdLabel,
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'leafId',
				header : leafIdLabel,
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'operation',
				header : operationLabel,
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'sql',
				header : sqlLabel,
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'date',
				header : dateLabel,
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'staffId',
				header : staffIdLabel,
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'access',
				header : accessLabel,
				sortable : true,
				hidden : false
			}, {
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
				plugins : [ logFilters, logExpander ],
				collapsible : true,
				animCollapse : false,
				selModel : new Ext.grid.RowSelectionModel({
					singleSelect : true
				}),
				viewConfig : {
					emptyText : emptyTextLabel
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
			}); // end log Request
			// start Log Advance Request
			var logAdvanceProxy = new Ext.data.HttpProxy({
				url : '../../security/controller/logAdvanceController.php?',
				method : 'POST',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
					} else {
						Ext.MessageBox.alert(systemErrorLabel,
								jsonResponse.message);
					}
				},
				failure : function(response, options) {
					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ':'
									+ escape(response.statusText));
				}
			});
			var logAdvanceReader = new Ext.data.JsonReader({
				totalProperty : 'total',
				successProperty : 'success',
				messageProperty : 'message',
				idProperty : 'logAdvanceId'
			});
			var logAdvanceStore = new Ext.data.JsonStore({
				proxy : logAdvanceProxy,
				reader : logAdvanceReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				method : 'POST',
				baseParams : {
					method : 'read',
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
			var logAdvanceFilters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : local,
				filters : [ {
					type : 'numeric',
					dataIndex : 'logAdvanceId',
					column : 'logAdvanceId',
					table : 'logAdvance'
				}, {
					type : 'string',
					dataIndex : 'logAdvanceText',
					column : 'logAdvanceText',
					table : 'logAdvance'
				}, {
					type : 'string',
					dataIndex : 'logAdvanceType',
					column : 'logAdvanceType',
					table : 'logAdvance'
				}, {
					type : 'string',
					dataIndex : 'logAdvanceComparison',
					column : 'logAdvanceComparison',
					table : 'logAdvance'
				}, {
					type : 'numeric',
					dataIndex : 'refTableName',
					column : 'refTableName',
					table : 'logAdvance'
				}, {
					type : 'list',
					dataIndex : 'executeBy',
					column : 'executeBy',
					table : 'logAdvance',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
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
			}, {
				dataIndex : 'logAdvanceText',
				header : logAdvanceTextLabel,
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'logAdvanceType',
				header : logAdvanceTypeLabel,
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'logAdvanceComparision',
				header : logAdvanceComparisionLabel,
				sortable : true,
				hidden : false
			}, {
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
				plugins : [ logAdvanceFilters ],
				selModel : new Ext.grid.RowSelectionModel({
					singleSelect : true
				}),
				viewConfig : {
					forceFit : true,
					emptyText : emptyRowLabel
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
									plugin : [ logAdvanceFilters ]
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
			}); // end log Advance Request
			// popup window for normal log and advance log
			var auditWindow = new Ext.Window({
				name : 'auditWindow',
				id : 'auditWindow',
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
						layout : 'fit',
						title : 'Log Sql Statement',
						items : [ logGrid ]
					}, {
						xtype : 'panel',
						layout : 'fit',
						title : 'Log Sql Statement',
						items : [ logAdvanceGrid ]
					} ]
				},
				title : 'Sql Statement audit',
				maximizable : true,
				autoScroll : true
			}); // end popup window for normal log and advance log
			// end common Proxy ,Reader,Store,Filter,Grid
			// start additional Proxy ,Reader,Store,Filter,Grid
			// start Language Request
			var languageProxy = new Ext.data.HttpProxy({
				url : '../../translation/controller/languageController.php',
				method : 'POST',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
														// uncommen for testing
														// purpose
					} else {
						Ext.MessageBox.alert(systemErrorLabel,
								jsonResponse.message);
					}
				},
				failure : function(response, options) {
					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ':'
									+ escape(response.statusText));
				}
			});
			var languageReader = new Ext.data.JsonReader({
				totalProperty : 'total',
				successProperty : 'success',
				messageProperty : 'message',
				idProperty : 'languageId'
			});
			var languageStore = new Ext.data.JsonStore({
				proxy : languageProxy,
				reader : languageReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				baseParams : {
					method : 'read',
					field : 'languageId',
					leafId : leafIdTemp
				},
				root : 'data',
				fields : [ {
					name : 'languageId',
					type : 'int'
				},

				{
					name : 'languageCode',
					type : 'string'
				},

				{
					name : 'languageDesc',
					type : 'string'
				} ]
			});
			// end Language Request
			// end additional Proxy ,Reader,Store,Filter,Grid
			// start application Proxy ,Reader,Store,Filter,Grid
			// start Header Table Mapping Request
			var tableMappingProxy = new Ext.data.HttpProxy({
				url : '../controller/tableMappingController.php',
				method : 'POST',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
					} else {
						Ext.MessageBox.alert(systemErrorLabel,
								jsonResponse.message);
					}
				},
				failure : function(response, options) {
					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ':'
									+ escape(response.statusText));
				}
			});
			var tableMappingReader = new Ext.data.JsonReader({
				totalProperty : 'total',
				successProperty : 'success',
				messageProperty : 'message',
				idProperty : 'tableMappingId'
			});
			var tableMappingStore = new Ext.data.JsonStore({
				proxy : tableMappingProxy,
				reader : tableMappingReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				method : 'POST',
				baseParams : {
					method : 'read',
					isAdmin : isAdmin,
					leafId : leafId
				},
				root : 'data',
				fields : [ {
					name : 'tableMappingId',
					type : 'int'
				}, {
					name : 'tableMappingName',
					type : 'string'
				}, {
					name : 'tableMappingColumnName',
					type : 'string'
				}, {
					name : 'tableMappingEnglish',
					type : 'string'
				}, {
					name : 'isDefault',
					type : 'boolean'
				}, {
					name : 'isNew',
					type : 'boolean'
				}, {
					name : 'isDraft',
					type : 'boolean'
				}, {
					name : 'isUpdate',
					type : 'boolean'
				}, {
					name : 'isDelete',
					type : 'boolean'
				}, {
					name : 'isActive',
					type : 'boolean'
				}, {
					name : 'isApproved',
					type : 'boolean'
				}, {
					name : 'executeBy',
					type : 'int'
				}, {
					name : 'executeTime',
					type : 'date',
					dateFormat : 'Y-m-d H:i:s'
				} ]
			});
			var tableMappingFilters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : local,
				filters : [ {
					type : 'numeric',
					dataIndex : 'tableMappingName',
					column : 'tableMappingName',
					table : 'tableMapping',
					database :'iCore'
				}, {
					type : 'string',
					dataIndex : 'tableMappingColumnName',
					column : 'tableMappingColumnName',
					table : 'tableMapping',
					database :'iCore'
				}, {
					type : 'string',
					dataIndex : 'tableMappingEnglish',
					column : 'tableMappingEnglish',
					table : 'tableMapping',
					database :'iCore'
				}, {
					type : 'string',
					dataIndex : 'languageId',
					column : 'languageId',
					table : 'tableMapping',
					database :'iCore'
				}, {
					type : 'list',
					dataIndex : 'executeBy',
					column : 'executeBy',
					table : 'tableMapping',
					database :'iCore',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dateFormat : 'Y-m-d H:i:s',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'tableMapping',
					database :'iCore'
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
			var tableMappingColumnModel = [
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
										var record = tableMappingStore
												.getAt(rowIndex);
										formPanel.getForm().reset();
										formPanel.form
												.load({
													url : '../controller/tableMappingController.php',
													method : 'POST',
													waitTitle : systemLabel,
													waitMsg : waitMessageLabel,
													params : {
														method : 'read',
														mode : 'update',
														tableMappingId : record.data.tableMappingId,
														leafId : leafId,
														isAdmin : isAdmin
													},
													success : function(form,
															action) {
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
										var record = tableMappingStore
												.getAt(rowIndex);
										Ext.Msg
												.show({
													title : deleteRecordTitleMessageLabel,
													msg : deleteRecordMessageLabel,
													icon : Ext.Msg.QUESTION,
													buttons : Ext.Msg.YESNO,
													scope : this,
													fn : function(response) {
														if ('yes' == response) {
															Ext.Ajax
																	.request({
																		url : '../controller/tableMappingController.php',
																		params : {
																			method : 'delete',
																			tableMappingId : record.data.tableMappingId,
																			leafId : leafId
																		},
																		success : function(
																				response,
																				options) {
																			jsonResponse = Ext
																					.decode(response.responseText);
																			if (jsonResponse.success == true) {
																			} else {
																			}
																			tableMappingStore
																					.reload({
																						params : {
																							leafId : leafId,
																							start : 0,
																							limit : perPage
																						}
																					});
																			tableMappingStoreList
																					.reload({
																						params : {
																							leafId : leafId,
																							start : 0,
																							limit : perPage
																						}
																					});
																			Ext.MessageBox
																					.alert(
																							systemLabel,
																							jsonResponse.message);
																		},
																		failure : function(
																				response,
																				options) {
																			Ext.MessageBox
																					.alert(
																							systemErrorLabel,
																							escape(response.status)
																									+ ':'
																									+ response.statusText);
																		}
																	});
														}
													}
												});
									}
								} ]
					}, {
						dataIndex : 'tableMappingNative',
						header : tableMappingNativeLabel
					}, isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid,
					isDeleteGrid, isActiveGrid, isApprovedGrid, isReviewGrid,
					isPostGrid, {
						dataIndex : 'executeBy',
						header : executeByLabel,
						sortable : true,
						hidden : true,
						width : 100
					}, {
						dataIndex : 'Time',
						header : executeTimeLabel,
						type : 'date',
						sortable : true,
						hidden : true,
						width : 100
					} ];
			var tableMappingAccessArray = [ 'isDefault', 'isNew', 'isDraft',
					'isUpdate', 'isDelete', 'isActive', 'isApproved',
					'isReview', 'isPost' ];
			var tableMappingGrid = new Ext.grid.GridPanel(
					{
						name : 'tableMappingGrid',
						id : 'tableMappingGrid',
						border : false,
						store : tableMappingStore,
						autoHeight : false,
						columns : tableMappingColumnModel,
						loadMask : true,
						plugins : [ tableMappingFilters ],
						selModel : new Ext.grid.RowSelectionModel({
							singleSelect : true
						}),
						viewConfig : {
							forceFit : true,
							emptyText : emptyRowLabel
						},
						iconCls : 'application_view_detail',
						listeners : {
							'rowclick' : function(object, rowIndex, e) {
								var record = tableMappingStore.getAt(rowIndex);
								formPanel.getForm().reset();
								formPanel.form
										.load({
											url : '../controller/tableMappingController.php',
											method : 'POST',
											waitTitle : systemLabel,
											waitMsg : waitMessageLabel,
											params : {
												method : 'read',
												mode : 'update',
												tableMappingId : record.data.tableMappingId,
												leafId : leafId
											},
											success : function(form, action) {
												Ext
														.getCmp(
																'tableMappingDesc_temp')
														.setValue(
																record.data.tableMappingDesc);
												viewPort.items.get(1).expand();
											},
											failure : function(form, action) {
												Ext.MessageBox.alert(
														systemErrorLabel,
														action.result.message);
											}
										});
								Ext.getCmp('newButton').disable();
								Ext.getCmp('saveButton').enable();
								Ext.getCmp('deleteButton').enable();
								Ext.getCmp('translation').enable();
							}
						},
						tbar : {
							items : [
									{
										xtype : 'button',
										text : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function(button, e) {
												tableMappingStore
														.each(function(record,
																fn, scope) {
															for ( var access in tableMappingFlagArray) {
																record
																		.set(
																				accessArray[access],
																				true);
															}
														});
											}
										}
									},
									{
										xtype : 'button',
										text : ClearAllLabel,
										iconCls : 'row-check-sprite-uncheck',
										listeners : {
											'click' : function(button, e) {
												tableMappingStore
														.each(function(record,
																fn, scope) {
															for ( var access in accessArray) {
																record
																		.set(
																				accessArray[access],
																				false);
															}
														});
											}
										}
									},
									{
										xtype : 'button',
										text : saveButtonLabel,
										iconCls : 'bullet_disk',
										listeners : {
											'click' : function(button, e) {
												var url = '../controller/tableMappingController.php?';
												var sub_url = '';
												var modified = tableMappingStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var dataChanges = modified[0]
															.getChanges();
													sub_url = sub_url
															+ '&tableMappingId[]='
															+ modified[i]
																	.get('tableMappingId');
													if (isAdmin == 1) {
														if (dataChanges.isDefault == true
																|| dataChanges.isDefault == false) {
															sub_url = sub_url
																	+ '&isDefault[]='
																	+ modified[i]
																			.get('isDefault');
														}
														if (dataChanges.isDraft == true
																|| dataChanges.isDraft == false) {
															sub_url = sub_url
																	+ '&isDraft[]='
																	+ modified[i]
																			.get('isDraft');
														}
														if (dataChanges.isNew == true
																|| dataChanges.isNew == false) {
															sub_url = sub_url
																	+ '&isNew[]='
																	+ modified[i]
																			.get('isNew');
														}
														if (dataChanges.isUpdate == true
																|| dataChanges.isUpdate == false) {
															sub_url = sub_url
																	+ '&isUpdate[]='
																	+ modified[i]
																			.get('isUpdate');
														}
													}
													if (dataChanges.isDelete == true
															|| dataChanges.isDelete == false) {
														sub_url = sub_url
																+ '&isDelete[]='
																+ modified[i]
																		.get('isDelete');
													}
													if (isAdmin == 1) {
														if (dataChanges.isActive == true
																|| dataChanges.isActive == false) {
															ssub_url = sub_url
																	+ '&isActive[]='
																	+ modified[i]
																			.get('isActive');
														}
														if (dataChanges.isApproved == true
																|| dataChanges.isApproved == false) {
															sub_url = sub_url
																	+ '&isApproved[]='
																	+ modified[i]
																			.get('isApproved');
														}
														if (dataChanges.isReview == true
																|| dataChanges.isReview == false) {
															sub_url = sub_url
																	+ '&isReview[]='
																	+ modified[i]
																			.get('isReview');
														}
														if (dataChanges.isPost == true
																|| dataChanges.isPost == false) {
															sub_url = sub_url
																	+ '&isPost[]='
																	+ modified[i]
																			.get('isPost');
														}
													}
												}
												url = url + sub_url;
												Ext.Ajax
														.request({
															url : url,
															method : 'GET',
															params : {
																leafId : leafId,
																isAdmin : isAdmin,
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
																	tableMappingStore
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
																						+ ':'
																						+ escape(response.statusText));
															}
														});
											}
										}
									} ]
						},
						bbar : new Ext.PagingToolbar({
							store : tableMappingStore,
							pageSize : perPage
						})
					}); // end of Header Table Mapping Request
			// start Detail Table Mapping Translation Request
			var tableMappingTranslateProxy = new Ext.data.HttpProxy({
				url : '../controller/tableMappingController.php',
				method : 'POST',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
					} else {
						Ext.MessageBox.alert(systemErrorLabel,
								jsonResponse.message);
					}
				},
				failure : function(response, options) {
					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ':'
									+ escape(response.statusText));
				}
			});
			var tableMappingTranslateReader = new Ext.data.JsonReader({
				totalProperty : 'total',
				successProperty : 'success',
				messageProperty : 'message',
				idProperty : 'tableMappingTranslateId'
			});
			var tableMappingTranslateStore = new Ext.data.JsonStore({
				autoDestroy : true,
				proxy : tableMappingTranslateProxy,
				reader : tableMappingTranslateReader,
				pruneModifiedRecords : true,
				baseParams : {
					method : 'read',
					page : 'detail',
					leafId : leafId
				},
				root : 'data',
				fields : [ {
					name : 'tableMappingTranslateId',
					type : 'int'
				}, {
					name : 'tableMappingId',
					type : 'int'
				}, {
					name : 'tableMappingNative',
					type : 'int'
				}, {
					name : 'languageId',
					type : 'string'
				} ]
			});
			Ext.util.Format.comboRenderer = function(combo) {
				return function(value) {
					var record = combo.findRecord(combo.valueField
							|| combo.displayField, value);
					if (record) {
						// remove special character

						res = record.get(combo.displayField);
						// res = res.replace(/[^a-zA-Z 0-9]+/g, '-');
					} else {
						// res = ("hmm, not found:" + value);
						res = (value);
					}
					return res;
				};
			};
		    var languageId = new Ext.ux.form.ComboBoxMatch({
		        labelAlign: 'left',
		        fieldLabel: languageIdLabel,
		        name: 'languageId',
		        hiddenName: 'languageId',
		        valueField: 'languageId',
		        hiddenId: 'language_fake',
		        id: 'languageId',
		        displayField: 'languageDesc',
		        typeAhead: false,
		        triggerAction: 'all',
		        store: languageStore,
		        anchor: '95%',
		        selectOnFocus: true,
		        mode: 'local',
		        blankText: blankTextLabel,
		        createValueMatcher: function(value) {
		            value = String(value).replace(/\s*/g, '');
		            if (Ext.isEmpty(value, false)) {
		                return new RegExp('^');
		            }
		            value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
		            return new RegExp('\\b(' + value + ')', 'i');
		        }
		    });
			var tableMappingTranslateColumnModel = [
					new Ext.grid.RowNumberer(), {
						header : 'language',
						width : 100,
						sortable : true,
						dataIndex : 'languageId',
						editor : languageId,
						renderer : Ext.util.Format.comboRenderer(languageId),
						hidden : false
					},{
						dataIndex : 'languageCode',
						header : languageCodeLabel,
						sortable : true,
						hidden : false,
						width : 100
					}, {
						dataIndex : 'languageDesc',
						header : languageDescLabel,
						sortable : true,
						hidden : false,
						width : 100
					}, {
						dataIndex : 'tableMappingEnglish',
						header : tableMappingEnglishLabel,
						sortable : true,
						hidden : false,
						width : 100
					}, {
						dataIndex : 'tableMappingNative',
						header : tableMappingNativeLabel,
						sortable : true,
						hidden : false,
						width : 100,
						editor : {
							xtype : 'textfield',
							id : 'tableMappingNative'
						}
					} ];
			var tableMappingTranslateEditor = new Ext.ux.grid.RowEditor({
						saveText : saveButtonLabel,
						cancelText : cancelButtonLabel,
						listeners : {
							CancelEdit : function(rowEditor, changes, record,
									rowIndex) {
								tableMappingStore.reload();
							},
							afteredit : function(rowEditor, changes, record,
									rowIndex) {
								var method;
								this.save = true;
								var record = this.grid.getStore().getAt(
										rowIndex);
								if (parseInt(record.get('tableMappingTranslateId')) == 'NaN') {
				                    method = 'create';
				                } else if (record.get('tableMappingTranslateId') == '') {
				                    method = 'create';
				                } else if (record.get('tableMappingTranslateId') == undefined) {
				                    method = 'create';
				                } else if (record.get('tableMappingTranslateId') > 0) {
				                    method = 'save';
				                } else {
				                    method = 'create';
				                }
								Ext.Ajax
										.request({
											url : '../controller/tableMappingTranslateController.php',
											method : 'POST',
											waitMsg : waitMessageLabel,
											params : {
												leafId : leafId,
												isAdmin : isAdmin,
												method : method,
												tableMappingTranslateId : record
														.get('tableMappingTranslateId'),
												languageId:record.get('languageId'),		
												tableMappingNative : record.get('tableMappingNative')
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
													Ext.MessageBox
															.alert(
																	systemLabel,
																	jsonResponse.message);
													tableMappingTranslateStore
															.reload();
												}
											},
											failure : function(response,
													options) {
												Ext.MessageBox
														.alert(
																systemLabel,
																escape(response.status)
																		+ ':'
																		+ escape(response.statusText));
											}
										});
							}
						}
					});
			var tableMappingTranslateFlagArray = [ 'isDefault', 'isNew',
					'isDraft', 'isUpdate', 'isDelete', 'isActive',
					'isApproved', 'isReview', 'isPost' ];

			var tableMappingTranslateGrid = new Ext.grid.GridPanel(
					{
						name : 'tableMappingTranslateGrid',
						id : 'tableMappingTranslateGrid',
						border : false,
						store : tableMappingTranslateStore,
						height : 400,
						autoScroll : true,
						columns : tableMappingTranslateColumnModel,
						viewConfig : {
							autoFill : true,
							forceFit : true,
							emptyText : emptyTextLabel
						},
						layout : 'fit',
						disable : true,
						selModel : new Ext.grid.RowSelectionModel({
							singleSelect : true
						}),
						plugins : [ tableMappingTranslateEditor ],
						tbar : {
							items : [
									{
										xtype : 'button',
										iconCls : 'add',
										id : 'add_record',
										name : 'add_record',
										text : newButtonLabel,
										handler : function() {
											var newRecord = new tableMappingTranslateEntity(
													{
														tableMappingTranslateId : '',
														tableMappingId : '',
														tableMappingNative : '',
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
											tableMappingTranslateEditor
													.stopEditing();
											tableMappingTranslateStore.insert(
													0, newRecord);
											tableMappingTranslateGrid
													.getSelectionModel()
													.getSelections();
											tableMappingTranslateEditor
													.startEditing(0);
										}
									},
									{
										xtype : 'button',
										text : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function(button, e) {
												tableMappingTranslateStore
														.each(function(record,
																fn, scope) {
															for ( var access in tableMappingTranslateFlagArray) {
																record
																		.set(
																				tableMappingTranslateFlagArray[access],
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
											'click' : function(button, e) {
												tableMappingTranslateStore
														.each(function(record,
																fn, scope) {
															for ( var access in tableMappingTranslateFlagArray) {
																record
																		.set(
																				tableMappingTranslateFlagArray[access],
																				false);
															}
														});
											}
										}
									},
									{
										xtype : 'button',
										text : saveButtonLabel,
										iconCls : 'bullet_disk',
										listeners : {
											'click' : function(button, e) {
												var url = '../controller/tableMappingTranslateController.php?';
												var sub_url = '';
												var modified = moduleTranslateStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var dataChanges = modified[i]
															.getChanges();
													var record = tableMappingTranslateStore
															.getAt(i);
													sub_url = sub_url
															+ '& tableMappingTranslateId[]='
															+ record
																	.get('moduleTranslateId');
													if (isAdmin == 1) {
														if (dataChanges.isDefault == true
																|| dataChanges.isDefault == false) {
															sub_url = sub_url
																	+ '&isDefault[]='
																	+ modified[i]
																			.get('isDefault');
														}
														if (dataChanges.isDraft == true
																|| dataChanges.isDraft == false) {
															sub_url = sub_url
																	+ '&isDraft[]='
																	+ modified[i]
																			.get('isDraft');
														}
														if (dataChanges.isNew == true
																|| dataChanges.isNew == false) {
															sub_url = sub_url
																	+ '&isNew[]='
																	+ modified[i]
																			.get('isNew');
														}
														if (dataChanges.isUpdate == true
																|| dataChanges.isUpdate == false) {
															sub_url = sub_url
																	+ '&isUpdate[]='
																	+ modified[i]
																			.get('isUpdate');
														}
													}
													if (dataChanges.isDelete == true
															|| dataChanges.isDelete == false) {
														sub_url = sub_url
																+ '&isDelete[]='
																+ modified[i]
																		.get('isDelete');
													}
													if (isAdmin == 1) {
														if (dataChanges.isActive == true
																|| dataChanges.isActive == false) {
															ssub_url = sub_url
																	+ '&isActive[]='
																	+ modified[i]
																			.get('isActive');
														}
														if (dataChanges.isApproved == true
																|| dataChanges.isApproved == false) {
															sub_url = sub_url
																	+ '&isApproved[]='
																	+ modified[i]
																			.get('isApproved');
														}
														if (dataChanges.isReview == true
																|| dataChanges.isReview == false) {
															sub_url = sub_url
																	+ '&isReview[]='
																	+ modified[i]
																			.get('isReview');
														}
														if (dataChanges.isPost == true
																|| dataChanges.isPost == false) {
															sub_url = sub_url
																	+ '&isPost[]='
																	+ modified[i]
																			.get('isPost');
														}
													}
												}
												url = url + sub_url;
												Ext.Ajax
														.request({
															url : url,
															method : 'GET',
															params : {
																leafId : leafId,
																isAdmin : isAdmin,
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
																	tableMappingTranslateStore
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
																						+ ':'
																						+ escape(response.statusText));
															}
														});
											}
										}
									} ]
						},
						bbar : new Ext.PagingToolbar({
							store : tableMappingTranslateStore,
							pageSize : perPage
						}),
						view : new Ext.ux.grid.BufferView({
							rowHeight : 34,
							scrollDelay : false
						})
					});
			// end Detail Table Mapping Translation Request
			var gridPanel = new Ext.Panel(
					{
						title : leafNative,
						height : 50,
						layout : 'fit',
						iconCls : 'application_view_detail',
						tbar : [
								' ',
								{
									text : reloadToolbarLabel,
									iconCls : 'database_refresh',
									id : 'pageReload',

									handler : function() {
										tableMappingStore.reload();
									}
								},
								'-',
								{
									text : addToolbarLabel,
									iconCls : 'add',
									id : 'pageCreate',

									handlfer : function() {
										viewPort.items.get(1).expand();
									}
								},
								'-',
								{
									text : excelToolbarLabel,
									iconCls : 'page_excel',
									id : 'page_excel',

									handler : function() {
										Ext.Ajax
												.request({
													url : '../controller/tableMappingController.php?method=report&mode=excel&limit='
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
																	.open('../../security/document/excel/tableMapping.xlsx');
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
																				+ ':'
																				+ escape(response.statusText));
													}
												});
									}
								}, '->', new Ext.ux.form.SearchField({
									store : tableMappingStore,
									width : 320
								}) ],
						items : [ tableMappingGrid ]
					}); // start Form Field Item.
			// hidden id for updated
			var tableMappingId = new Ext.form.Hidden({
				name : 'tableMappingId',
				id : 'tableMappingId'
			});
			var tableMappingName = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : tableMappingNameLabel,
				hiddenName : 'tableMappingName',
				name : 'tableMappingName',
				anchor : '95%'
			});
			var tableMappingColumnName = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : tableMappingColumnNameLabel,
				hiddenName : 'tableMappingColumnName',
				name : 'tableMappingColumnName',
				anchor : '95%'
			});
			var tableMappingEnglish = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : tableMappingEnglishLabel,
				hiddenName : 'tableMappingEnglish',
				name : 'tableMappingEnglish',
				anchor : '95%'
			}); // end Form Field Item
			// hidden value for navigation button
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
			}); // end of hidden value for navigation button
			var formPanel = new Ext.form.FormPanel(
					{
						url : '../controller/tableMappingController.php',
						name : 'formPanel',
						id : 'formPanel',
						method : 'post',
						frame : true,
						title : leafNative,
						border : false,
						width : 600,
						items : [
								{
									xtype : 'panel',
									title : leafNative,
									bodyStyle : 'padding:5px',
									layout : 'form',
									items : [ tableMappingId, tableMappingName,
											tableMappingColumnName,
											tableMappingEnglish ]
								}, {
									xtype : 'panel',
									title : 'tableMapping Translation',
									items : [ tableMappingTranslateGrid ]
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
										id = Ext.getCmp('tableMappingId')
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
															waitTitle : systemLabel,
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
																				systemLabel,
																				action.result.message);
																tableMappingStore
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
																				'tableMappingId')
																		.setValue(
																				action.result.tableMappingId);
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
										Ext.getCmp('newButton').enable();
										Ext.getCmp('saveButton').disable();
										Ext.getCmp('deleteButton').disable();
										Ext.getCmp('postButton').disable();
										Ext.getCmp('translationButton')
												.disable();
										Ext.getCmp('tableMappingTranslateGrid')
												.disable();
										formPanel.getForm().reset();
									}
								},
								{
									text : 'Translation',
									name : 'translationButton',
									id : 'translationButton',
									disabled : true,
									handler : function() {
										Ext.Ajax
												.request({
													url : '../controller/tableMappingController.php',
													method : 'GET',
													waitTitle : 'Translation',
													waitMessage : 'Translation in Progress',
													params : {
														leafId : leafId,
														method : 'translate',
														tableMappingId : Ext
																.getCmp(
																		'tableMappingId')
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
															tableMappingTranslateStore
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
																				+ ':'
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
				layoutConfig : { // layout-specific configs go here
					titleCollapse : true,
					animate : false,
					activeOnTop : true
				},
				items : [ gridPanel, formPanel ]
			});
		});