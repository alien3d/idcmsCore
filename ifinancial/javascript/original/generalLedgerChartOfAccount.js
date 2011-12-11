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
			var staffByProxy = new Ext.data.HttpProxy(
					{
						url : '../controller/generalLedgerChartOfAccountController.php?',
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
				id : 'staffId',
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
				autoLoad : false,
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
				autoLoad : false,
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
					emptyText : emptyTextLabel
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
			// start generalLedgerChartOfAccountReportType request
			var generalLedgerChartOfAccountReportTypeProxy = new Ext.data.HttpProxy(
					{
						url : '../controller/generalLedgerChartOfAccountReportTypeController.php',
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
									escape(response.Status) + ':'
											+ escape(response.statusText));
						}
					});
			var generalLedgerChartOfAccountReportTypeReader = new Ext.data.JsonReader(
					{
						totalProperty : 'total',
						successProperty : 'success',
						messageProperty : 'message',
						idProperty : 'generalLedgerChartOfAccountReportTypeId'
					});
			var generalLedgerChartOfAccountReportTypeStore = new Ext.data.JsonStore(
					{
						proxy : generalLedgerChartOfAccountReportTypeProxy,
						reader : generalLedgerChartOfAccountReportTypeReader,
						autoLoad : true,
						autoDestroy : true,
						pruneModifiedRecords : true,
						baseParams : {
							method : 'read',
							leafId : leafId,
							isAdmin : isAdmin,
							start : 0,
							perPage : perPage
						},
						root : 'data',
						id : 'generalLedgerChartOfAccountReportTypeId',
						fields : [ {
							key : 'PRI',
							foreignKey : 'no',
							name : 'generalLedgerChartOfAccountReportTypeId',
							type : 'int'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'generalLedgerChartOfAccountReportTypeSequence',
							type : 'int'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'generalLedgerChartOfAccountReportTypeCode',
							type : 'string'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'generalLedgerChartOfAccountReportTypeDesc',
							type : 'string'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'isDefault',
							type : 'boolean'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'isNew',
							type : 'boolean'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'isDraft',
							type : 'boolean'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'isUpdate',
							type : 'boolean'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'isDelete',
							type : 'boolean'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'isActive',
							type : 'boolean'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'isApproved',
							type : 'boolean'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'isReview',
							type : 'boolean'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'isPost',
							type : 'boolean'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'executeBy',
							type : 'int'
						}, {
							key : '',
							foreignKey : 'no',
							name : 'executeTime',
							type : 'date',
							dateFormat : 'Y-m-d H:i:s'
						} ]
					});
			// end generalLedgerChartOfAccountReportType request
			// start request generalLedgerChartOfAccountType
			var generalLedgerChartOfAccountTypeProxy = new Ext.data.HttpProxy(
					{
						url : '../controller/generalLedgerChartOfAccountTypeController.php',
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
			var generalLedgerChartOfAccountTypeReader = new Ext.data.JsonReader(
					{
						totalProperty : 'total',
						successProperty : 'success',
						messageProperty : 'message',
						idProperty : 'stateId'
					});
			var generalLedgerChartOfAccountTypeStore = new Ext.data.JsonStore({
				proxy : generalLedgerChartOfAccountTypeProxy,
				reader : generalLedgerChartOfAccountTypeReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				baseParams : {
					method : 'read',
					leafId : leafId,
					isAdmin : isAdmin,
					start : 0,
					perPage : perPage
				},
				root : 'data',
				id : 'generalLedgerChartOfAccountTypeId',
				fields : [ {
					name : 'generalLedgerChartOfAccountTypeId',
					type : 'int'
				}, {
					name : 'generalLedgerChartOfAccountTypeDesc',
					type : 'string'
				} ]
			});
			// end request generalLedgerChartOfAccountType
			// end additional Proxy ,Reader,Store,Filter,Grid
			// start application Proxy ,Reader,Store,Filter,Grid
			// start generalLedgerChartOfAccount request
			var generalLedgerChartOfAccountProxy = new Ext.data.HttpProxy({ url : '../controller/generalLedgerChartOfAccountController.php', method : 'POST', success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) {
			// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
			} else { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText)); } });
			var generalLedgerChartOfAccountReader = new Ext.data.JsonReader({ totalProperty : 'total', successProperty : 'success', messageProperty : 'message', idProperty : 'generalLedgerChartOfAccountId' });
			var generalLedgerChartOfAccountStore = new Ext.data.JsonStore({ proxy : generalLedgerChartOfAccountProxy, reader : generalLedgerChartOfAccountReader, autoLoad : true, autoDestroy : true, pruneModifiedRecords : true, baseParams : { method : 'read', leafId : leafId, isAdmin : isAdmin, start : 0, perPage : perPage }, root : 'data', id : 'generalLedgerChartOfAccountId', fields : [{ key :'PRI', foreignKey : 'no', name : 'generalLedgerChartOfAccountId', type : 'int'},{ key :'', foreignKey : 'no', name : 'generalLedgerChartOfAccountTitle', type : 'string'},{ key :'', foreignKey : 'no', name : 'generalLedgerChartOfAccountDesc', type : 'string'},{ key :'', foreignKey : 'no', name : 'generalLedgerChartOfAccountNo', type : 'string'},{ key :'MUL', foreignKey : 'yes', name : 'generalLedgerChartOfAccountTypeId', type : 'int'},{ key :'MUL', foreignKey : 'yes', name : 'generalLedgerChartOfAccountReportTypeId', type : 'int'},{ key :'', foreignKey : 'no', name : 'isDefault', type : 'boolean'},{ key :'', foreignKey : 'no', name : 'isNew', type : 'boolean'},{ key :'', foreignKey : 'no', name : 'isDraft', type : 'boolean'},{ key :'', foreignKey : 'no', name : 'isUpdate', type : 'boolean'},{ key :'', foreignKey : 'no', name : 'isDelete', type : 'boolean'},{ key :'', foreignKey : 'no', name : 'isActive', type : 'boolean'},{ key :'', foreignKey : 'no', name : 'isApproved', type : 'boolean'},{ key :'', foreignKey : 'no', name : 'isReview', type : 'boolean'},{ key :'', foreignKey : 'no', name : 'isPost', type : 'boolean'},{ key :'', foreignKey : 'no', name : 'isConsolidation', type : 'int'},{ key :'', foreignKey : 'no', name : 'isSeperated', type : 'int'},{ key :'', foreignKey : 'no', name : 'executeBy', type : 'int'},{ key :'', foreignKey : 'no', name : 'executeTime', type : 'date',dateFormat : 'Y-m-d H:i:s'} ] });
			// end generalLedgerChartOfAccount request 
			var generalLedgerChartOfAccountFilters = new Ext.ux.grid.GridFilters(
					{
						encode : false,
						local : false,
						filters : [
								{
									type : 'int',
									dataIndex : 'generalLedgerChartOfAccountId',
									column : 'generalLedgerChartOfAccountId',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								},
								{
									type : 'string',
									dataIndex : 'generalLedgerChartOfAccountTitle',
									column : 'generalLedgerChartOfAccountTitle',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								},
								{
									type : 'string',
									dataIndex : 'generalLedgerChartOfAccountDesc',
									column : 'generalLedgerChartOfAccountDesc',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								},
								{
									type : 'string',
									dataIndex : 'generalLedgerChartOfAccountNo',
									column : 'generalLedgerChartOfAccountNo',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								},
								,
								{
									type : 'list',
									dataIndex : 'generalLedgerChartOfAccountTypeId',
									column : 'generalLedgerChartOfAccountTypeId',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial',
									labelField : 'generalLedgerChartOfAccountTypeDesc',
									store : generalLedgerChartOfAccountTypeStore,
									phpMode : true
								},
								,
								{
									type : 'list',
									dataIndex : 'generalLedgerChartOfAccountReportTypeId',
									column : 'generalLedgerChartOfAccountReportTypeId',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial',
									labelField : 'generalLedgerChartOfAccountReportTypeDesc',
									store : generalLedgerChartOfAccountReportTypeStore,
									phpMode : true
								}, {
									type : 'boolean',
									dataIndex : 'isDefault',
									column : 'isDefault',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								}, {
									type : 'boolean',
									dataIndex : 'isNew',
									column : 'isNew',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								}, {
									type : 'boolean',
									dataIndex : 'isDraft',
									column : 'isDraft',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								}, {
									type : 'boolean',
									dataIndex : 'isUpdate',
									column : 'isUpdate',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								}, {
									type : 'boolean',
									dataIndex : 'isDelete',
									column : 'isDelete',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								}, {
									type : 'boolean',
									dataIndex : 'isActive',
									column : 'isActive',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								}, {
									type : 'boolean',
									dataIndex : 'isApproved',
									column : 'isApproved',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								}, {
									type : 'boolean',
									dataIndex : 'isReview',
									column : 'isReview',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								}, {
									type : 'boolean',
									dataIndex : 'isPost',
									column : 'isPost',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								}, {
									type : 'int',
									dataIndex : 'isConsolidation',
									column : 'isConsolidation',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								}, {
									type : 'int',
									dataIndex : 'isSeperated',
									column : 'isSeperated',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
								}, {
									type : 'list',
									dataIndex : 'executeBy',
									column : 'executeBy',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial',
									labelField : 'staffName',
									store : staffByStore,
									phpMode : true
								}, {
									type : 'date',
									dataIndex : 'executeTime',
									column : 'executeTime',
									table : 'generalLedgerChartOfAccount',
									database : 'ifinancial'
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
				header : isReviewLabel,
				dataIndex : 'isPost',
				hidden : isPostHidden
			});
			var isConsolidationGrid = new Ext.ux.grid.CheckColumn({
				header : 'Post',
				dataIndex : 'isConsolidation'
			});
			var isSeperatedGrid = new Ext.ux.grid.CheckColumn({
				header : 'Post',
				dataIndex : 'isSeperated'
			});
			var generalLedgerChartOfAccountColumnModel = [ new Ext.grid.RowNumberer(),{ dataIndex : 'generalLedgerChartOfAccountId', header : generalLedgerChartOfAccountIdLabel, sortable : true, hidden : false },{ dataIndex : 'generalLedgerChartOfAccountTitle', header : generalLedgerChartOfAccountTitleLabel, sortable : true, hidden : false },{ dataIndex : 'generalLedgerChartOfAccountDesc', header : generalLedgerChartOfAccountDescLabel, sortable : true, hidden : false },{ dataIndex : 'generalLedgerChartOfAccountNo', header : generalLedgerChartOfAccountNoLabel, sortable : true, hidden : false }, { dataIndex : 'generalLedgerChartOfAccountTypeId', header : generalLedgerChartOfAccountTypeDescLabel, sortable : true, hidden : false, renderer : function(value, metaData, record, rowIndex, colIndex, store) { return record.data.generalLedgerChartOfAccountTypeDesc; } }, { dataIndex : 'generalLedgerChartOfAccountReportTypeId', header : generalLedgerChartOfAccountReportTypeDescLabel, sortable : true, hidden : false, renderer : function(value, metaData, record, rowIndex, colIndex, store) { return record.data.generalLedgerChartOfAccountReportTypeDesc; } }, { dataIndex : 'isDefault', header : isDefaultLabel, sortable : true, hidden : false },{ dataIndex : 'isNew', header : isNewLabel, sortable : true, hidden : false },{ dataIndex : 'isDraft', header : isDraftLabel, sortable : true, hidden : false },{ dataIndex : 'isUpdate', header : isUpdateLabel, sortable : true, hidden : false },{ dataIndex : 'isDelete', header : isDeleteLabel, sortable : true, hidden : false },{ dataIndex : 'isActive', header : isActiveLabel, sortable : true, hidden : false },{ dataIndex : 'isApproved', header : isApprovedLabel, sortable : true, hidden : false },{ dataIndex : 'isReview', header : isReviewLabel, sortable : true, hidden : false },{ dataIndex : 'isPost', header : isPostLabel, sortable : true, hidden : false },{ dataIndex : 'isConsolidation', header : isConsolidationLabel, sortable : true, hidden : false },{ dataIndex : 'isSeperated', header : isSeperatedLabel, sortable : true, hidden : false }, { dataIndex : 'executeBy', header : executeByLabel, sortable : true, hidden : false, renderer : function(value, metaData, record, rowIndex, colIndex, store) { return record.data.staffName; } }, { dataIndex : 'executeTime', header : executeTimeLabel, sortable : true, hidden : false, renderer : function(value, metaData, record, rowIndex, colIndex, store) { return Ext.util.Format.date(value, 'd-m-Y H:i:s'); } }];
			var generalLedgerChartOfAccountFlagArray = [ 'isDefault', 'isNew',
					'isDraft', 'isUpdate', 'isDelete', 'isActive',
					'isApproved', 'isReview', 'isPost', 'isConsolidation',
					'isSeperated' ];
			var generalLedgerChartOfAccountGrid = new Ext.grid.GridPanel(
					{
						name : 'generalLedgerChartOfAccountGrid',
						id : 'generalLedgerChartOfAccountGrid',
						border : false,
						store : generalLedgerChartOfAccountStore,
						autoHeight : false,
						height : 400,
						columns : generalLedgerChartOfAccountColumnModel,
						plugins : [ generalLedgerChartOfAccountFilters ],
						selModel : new Ext.grid.RowSelectionModel({
							singleSelect : true
						}),
						viewConfig : {
							emptyText : emptyRowLabel
						},
						iconCls : 'application_view_detail',
						listeners : {
							'rowclick' : function(object, rowIndex, e) {
								var record = generalLedgerChartOfAccountStore
										.getAt(rowIndex);
								formPanel.getForm().reset();
								formPanel.form
										.load({
											url : '../controller/generalLedgerChartOfAccountController.php',
											method : 'POST',
											waitTitle : systemLabel,
											waitMsg : waitMessageLabel,
											params : {
												method : 'read',
												mode : 'update',
												generalLedgerChartOfAccountId : record.data.generalLedgerChartOfAccountId,
												leafId : leafId,
												isAdmin : isAdmin
											},
											success : function(form, action) {
												Ext
														.getCmp(
																'generalLedgerChartOfAccountCodeNoTemp')
														.setValue(
																record.data.generalLedgerChartOfAccountNo);
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
							}
						},
						tbar : {
							items : [
									{
										xtype : 'button',
										text : ' ',
										tooltip : addToolbarLabel,
										iconCls : 'add',
										id : 'pageCreate',

										handler : function() {
											viewPort.items.get(1).expand();
										}
									},
									'-',
									{
										xtype : 'button',
										text : ' ',
										tooltip : excelToolbarLabel,
										iconCls : 'page_excel',
										id : 'page_excel',

										handler : function() {
											Ext.Ajax
													.request({
														url : '../controller/generalLedgerChartOfAccountController.php',
														method : 'GET',
														params : {
															method : 'report',
															mode : 'excel',
															limit : perPage,
															leafId : leafId
														},
														success : function(
																response,
																options) {
															jsonResponse = Ext
																	.decode(response.responseText);
															if (jsonResponse.success == true) {
																window
																		.open('../../basic/document/excel/'
																				+ jsonResponse.filename);
															} else {
																Ext.MessageBox
																		.alert(
																				successLabel,
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
									},
									'-',
									{
										xtype : 'button',
										text : ' ',
										tooltip : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function(button, e) {
												generalLedgerChartOfAccountStore
														.each(function(record,
																fn, scope) {
															for ( var access in generalLedgerChartOfAccountFlagArray) {
																record
																		.set(
																				generalLedgerChartOfAccountFlagArray[access],
																				true);
															}
														});
											}
										}
									},
									'-',
									{
										xtype : 'button',
										text : ' ',
										tooltip : ClearAllLabel,
										iconCls : 'row-check-sprite-uncheck',
										listeners : {
											'click' : function(button, e) {
												generalLedgerChartOfAccountStore
														.each(function(record,
																fn, scope) {
															for ( var access in generalLedgerChartOfAccountFlagArray) {
																record
																		.set(
																				generalLedgerChartOfAccountFlagArray[access],
																				false);
															}
														});
											}
										}
									},
									'-',
									{
										xtype : 'button',
										text : ' ',
										tooltip : saveButtonLabel,
										iconCls : 'bullet_disk',
										listeners : {
											'click' : function(button, e) {
												var url = '../controller/generalLedgerChartOfAccountController.php?';
												var sub_url = '';
												var modified = generalLedgerChartOfAccountStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var dataChanges = modified[i]
															.getChanges();
													sub_url = sub_url
															+ '&generalLedgerChartOfAccountId[]='
															+ modified[i]
																	.get('generalLedgerChartOfAccountId');
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
																	generalLedgerChartOfAccountStore
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
									},
									'-',
									{
										xtype : 'button',
										text : 'Asset - 1X',
										tooltip : 'Asset',
										handler : function(button, e) {
											generalLedgerChartOfAccountStore
													.reload({
														params : {
															leafId : leafId,
															start : 0,
															limit : perPage,
															character : '1'
														}
													});
										}
									},
									'-',
									{
										xtype : 'button',
										text : 'Liabilites - 2X',
										tooltip : 'Liabilites',
										handler : function(button, e) {
											generalLedgerChartOfAccountStore
													.reload({
														params : {
															leafId : leafId,
															start : 0,
															limit : perPage,
															character : '2'
														}
													});
										}
									},
									'-',
									{
										xtype : 'button',
										text : 'Income  - 3X',
										tooltip : 'Income',
										handler : function(button, e) {
											generalLedgerChartOfAccountStore
													.reload({
														params : {
															leafId : leafId,
															start : 0,
															limit : perPage,
															character : '3'
														}
													});
										}
									},
									'-',
									{
										xtype : 'button',
										text : 'Expenses - 4X',
										tooltip : 'Expenses',
										handler : function(button, e) {
											generalLedgerChartOfAccountStore
													.reload({
														params : {
															leafId : leafId,
															start : 0,
															limit : perPage,
															character : '4'
														}
													});
										}
									},
									'-',
									{
										xtype : 'button',
										text : 'Overhead - 5X',
										tooltip : 'Overhead',
										handler : function(button, e) {
											generalLedgerChartOfAccountStore
													.reload({
														params : {
															leafId : leafId,
															start : 0,
															limit : perPage,
															character : '5'
														}
													});
										}
									},
									'-',
									{
										xtype : 'button',
										text : 'Non Posting Account - 6X',
										tooltip : 'Non Posting Account',
										handler : function(button, e) {
											generalLedgerChartOfAccountStore
													.reload({
														params : {
															leafId : leafId,
															start : 0,
															limit : perPage,
															character : '6'
														}
													});
										}
									},
									'-',
									{
										xtype : 'button',
										text : 'Purchase Order - 7X',
										tooltip : 'Purchase Order',
										handler : function(button, e) {
											generalLedgerChartOfAccountStore
													.reload({
														params : {
															leafId : leafId,
															start : 0,
															limit : perPage,
															character : '7'
														}
													});
										}
									},
									'-',
									{
										xtype : 'button',
										text : 'Estimations - 8X',
										tooltip : 'Estimations',
										handler : function(button, e) {
											generalLedgerChartOfAccountStore
													.reload({
														params : {
															leafId : leafId,
															start : 0,
															limit : perPage,
															character : '8'
														}
													});
										}
									},
									'->',
									new Ext.ux.form.SearchField(
											{
												store : generalLedgerChartOfAccountStore,
												width : 320
											}) ]
						},
						bbar : new Ext.PagingToolbar({
							store : generalLedgerChartOfAccountStore,
							pageSize : perPage,
							plugins : [ generalLedgerChartOfAccountFilters ]
						})
					});
			var gridPanel = new Ext.Panel({
				title : leafNative,
				iconCls : 'application_view_detail',
				layout : 'fit',
				items : [ generalLedgerChartOfAccountGrid ]
			});
			// form entry
			var generalLedgerChartOfAccountReportTypeId  = new Ext.ux.form.ComboBoxMatch({
                labelAlign: 'left',
                fieldLabel: generalLedgerChartOfAccountReportTypeIdLabel,
                name: 'stateId',
                hiddenName: 'generalLedgerChartOfAccountReportTypeId',
                valueField: 'generalLedgerChartOfAccountReportTypeId',
                hiddenId: 'generalLedgerChartOfAccountReportTypeId_fake',
                id: 'generalLedgerChartOfAccountReportTypeId',
                displayField: 'generalLedgerChartOfAccountReportTypeDesc',
                typeAhead: false,
                triggerAction: 'all',
                store: generalLedgerChartOfAccountReportTypeStore,
                anchor: '95%',
                selectOnFocus: true,
                mode: 'local',
                allowBlank: false,
                blankText: blankTextLabel,
                createValueMatcher: function(value) {
                    value = String(value).replace(/\s*/g, '');
                    if (Ext.isEmpty(value, false)) {
                        return new RegExp('^');
                    }
                    value = Ext.escapeRe(value.split('').join('\s*')).replace(/\\s\\*/g, '\s*');
                    return new RegExp('\b(' + value + ')', 'i');
                }
            });
			
			var generalLedgerChartOfAccountTypeId = new Ext.ux.form.ComboBoxMatch(
					{
						labelAlign : 'left',
						fieldLabel : generalLedgerChartOfAccountTypeIdLabel,
						name : 'generalLedgerChartOfAccountTypeId',
						hiddenName : 'generalLedgerChartOfAccountTypeId',
						valueField : 'generalLedgerChartOfAccountTypeId',
						hiddenId : 'generalLedgerChartOfAccountTypeId_fake',
						id : 'generalLedgerChartOfAccountTypeId',
						displayField : 'generalLedgerChartOfAccountTypeDesc',
						typeAhead : false,
						triggerAction : 'all',
						store : generalLedgerChartOfAccountTypeStore,
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
						}
					});

			var generalLedgerChartOfAccountTitle = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : generalLedgerChartOfAccountTitleLabel
						+ '<span style=\'color: red;\'>*</span>',
				hiddenName : 'generalLedgerChartOfAccountTitle',
				name : 'generalLedgerChartOfAccountTitle',
				id : 'generalLedgerChartOfAccountTitle',
				allowBlank : false,
				blankText : blankTextLabel,
				style : {
					textTransform : 'uppercase'
				},
				anchor : '40%'
			});

			var generalLedgerChartOfAccountDesc = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : generalLedgerChartOfAccountDescLabel
						+ '<span style=\'color: red;\'>*</span>',
				hiddenName : 'generalLedgerChartOfAccountDesc',
				name : 'generalLedgerChartOfAccountDesc',
				id : 'generalLedgerChartOfAccountDesc',
				allowBlank : false,
				blankText : blankTextLabel,
				style : {
					textTransform : 'uppercase'
				},
				anchor : '40%'
			});

			

			var generalLedgerChartOfAccountNo = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : generalLedgerChartOfAccountNoLabel
						+ '<span style=\'color: red;\'>*</span>',
				hiddenName : 'generalLedgerChartOfAccountNo',
				name : 'generalLedgerChartOfAccountNo',
				id : 'generalLedgerChartOfAccountNo',
				allowBlank : false,
				blankText : blankTextLabel,
				style : {
					textTransform : 'uppercase'
				},
				anchor : '40%'
			});

			var generalLedgerChartOfAccountNoTemp = new Ext.form.Hidden({
				name : 'generalLedgerChartOfAccountNoTemp',
				id : 'generalLedgerChartOfAccountNoTemp'
			});
			var checkDuplicateCode = new Ext.Button(
					{
						name : 'checkDuplicateCode',
						id : 'checkDuplicateCode',
						text : checkDuplicateCodeLabel,
						listeners : {
							'click' : function(button, e) {
								if (Ext.getCmp('generalLedgerChartOfAccountNo')
										.getValue().length > 0) {
									Ext.Ajax
											.request({
												url : '../controller/generalLedgerChartOfAccountController.php',
												method : 'GET',
												params : {
													method : 'duplicate',
													leafId : leafId,
													generalLedgerChartOfAccountNo : Ext
															.getCmp(
																	'generalLedgerChartOfAccountNo')
															.getValue()
												},
												success : function(response,
														options) {
													jsonResponse = Ext
															.decode(response.responseText);
													if (jsonResponse.success == true) {
														if (jsonResponse.total > 0) {
															if (Ext
																	.getCmp(
																			'generalLedgerChartOfAccountNoTemp')
																	.getValue() != Ext
																	.getCmp(
																			'generalLedgerChartOfAccountNo')
																	.getValue()) {
																duplicate = 1;
																duplicateMessageLabel = duplicateMessageLabel
																		+ Ext.util.Format
																				.uppercase(Ext
																						.getCmp(
																								'generalLedgerChartOfAccountNo')
																						.getValue())
																		+ ':'
																		+ +Ext.util.Format
																				.uppercase(jsonResponse.generalLedgerChartOfAccountNo);
																Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				duplicateMessageLabel);
																Ext
																		.getCmp(
																				'generalLedgerChartOfAccountNo')
																		.setValue(
																				'');
															} else {
																Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				jsonResponse.message);
															}
														}
													} else {
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
																			+ ':'
																			+ escape(response.statusText));
												}
											});
								} else {
									Ext.MessageBox.alert(systemLabel,
											emptyTextLabel);
								}
							}
						}
					});
			var generalLedgerChartOfAccountId = new Ext.form.Hidden({
				name : 'generalLedgerChartOfAccountId',
				id : 'generalLedgerChartOfAccountId'
			}); // end form entry
			// start System Validation
			var isDefault = new Ext.form.Checkbox({
				name : 'isDefault',
				id : 'isDefault',
				fieldLabel : isDefaultLabel,
				hidden : isDefaultHidden
			});
			var isNew = new Ext.form.Checkbox({
				name : 'isNew',
				id : 'isNew',
				fieldLabel : isNewLabel,
				hidden : isNewHidden
			});
			var isDraft = new Ext.form.Checkbox({
				name : 'isDraft',
				id : 'isDraft',
				fieldLabel : isDraftLabel,
				hidden : isDraftHidden
			});
			var isUpdate = new Ext.form.Checkbox({
				name : 'isUpdate',
				id : 'isUpdate',
				fieldLabel : isUpdateLabel,
				hidden : isUpdateHidden
			});
			var isDelete = new Ext.form.Checkbox({
				name : 'isDelete',
				id : 'isDelete',
				fieldLabel : isDeleteLabel,
				hidden : isDeleteHidden
			});
			var isActive = new Ext.form.Checkbox({
				name : 'isActive',
				id : 'isActive',
				fieldLabel : isActiveLabel,
				hidden : isActiveHidden
			});
			var isApproved = new Ext.form.Checkbox({
				name : 'isApproved',
				id : 'isApproved',
				fieldLabel : isApprovedLabel,
				hidden : isApprovedHidden
			});
			var isReview = new Ext.form.Checkbox({
				name : 'isReview',
				id : 'isReview',
				fieldLabel : isReviewLabel,
				hidden : isReviewHidden
			});
			var isPost = new Ext.form.Checkbox({
				name : 'isPost',
				id : 'isPost',
				fieldLabel : isPostLabel,
				hidden : isPostHidden
			}); // hidden value for navigation button
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
			// end System Validation
			var formPanel = new Ext.form.FormPanel(
					{
						url : '../controller/generalLedgerChartOfAccountController.php',
						name : 'formPanel',
						id : 'formPanel',
						method : 'post',
						frame : true,
						title : leafNative,
						border : false,
						bodyStyle : 'padding:5px',
						width : 600,
						items : [ {
							xtype : 'fieldset',
							title : 'Form Entry',
							items : [
									generalLedgerChartOfAccountId,
									generalLedgerChartOfAccountReportTypeId,
									generalLedgerChartOfAccountTypeId,
									generalLedgerChartOfAccountTitle,
									generalLedgerChartOfAccountDesc,
									
									{
										xtype : 'compositefield',
										items : [
												generalLedgerChartOfAccountNo,
												checkDuplicateCode ]
									}, generalLedgerChartOfAccountNoTemp ]
						} ],
						buttonVAlign : 'top',
						buttonAlign : 'left',
						iconCls : 'application_form',
						bbar : new Ext.ux.StatusBar({
							id : 'form-statusbar',
							defaultText : defaultTextLabel,
							plugins : new Ext.ux.ValidationStatus({
								form : 'formPanel'
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
											generalLedgerChartOfAccountStore
													.reload();
											auditWindow.show().center();
										}
									}
								},
								{
									text : newButtonLabel,
									name : 'newButton',
									id : 'newButton',
									type : 'button',
									iconCls : 'new',
									handler : function() {
										var id = Ext
												.getCmp(
														'generalLedgerChartOfAccountId')
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
																if (action.result.success == true) {
																	Ext.MessageBox
																			.alert(
																					systemLabel,
																					action.result.message);
																	Ext
																			.getCmp(
																					'newButton')
																			.disable();
																	Ext
																			.getCmp(
																					'saveButton')
																			.enable();
																	Ext
																			.getCmp(
																					'deleteButton')
																			.enable();
																	generalLedgerChartOfAccountStore
																			.reload({
																				params : {
																					leafId : leafId,
																					start : 0,
																					limit : perPage
																				}
																			});
																	Ext
																			.getCmp(
																					'generalLedgerChartOfAccountId')
																			.setValue(
																					action.result.generalLedgerChartOfAccountId);
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
										var id = Ext
												.getCmp(
														'generalLedgerChartOfAccountId')
												.getValue();
										var method = 'save';
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
																if (action.result.success == true) {
																	Ext.MessageBox
																			.alert(
																					systemLabel,
																					action.result.message);
																	Ext
																			.getCmp(
																					'newButton')
																			.disable();
																	Ext
																			.getCmp(
																					'saveButton')
																			.enable();
																	Ext
																			.getCmp(
																					'deleteButton')
																			.enable();
																	generalLedgerChartOfAccountStore
																			.reload({
																				params : {
																					leafId : leafId,
																					start : 0,
																					limit : perPage
																				}
																			});
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
														if ('yes' == response) {
															Ext.Ajax
																	.request({
																		url : '../controller/generalLedgerChartOfAccountController.php',
																		params : {
																			method : 'delete',
																			generalLedgerChartOfAccountId : Ext
																					.getCmp(
																							'generalLedgerChartOfAccountId')
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
																				generalLedgerChartOfAccountStore
																						.reload({
																							params : {
																								leafId : leafId,
																								start : 0,
																								limit : perPage
																							}
																						});
																				Ext
																						.getCmp(
																								'saveButton')
																						.disable();
																				Ext
																						.getCmp(
																								'deleteButton')
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
																									+ ':'
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
										Ext.getCmp('saveButton').disable();
										Ext.getCmp('deleteButton').disable();
										Ext.getCmp('postButton').disable();
										formPanel.getForm().reset();
									}
								},
								{
									text : postButtonLabel,
									type : 'button',
									name : 'postButton',
									id : 'postButton',
									iconCls : 'lock',
									disabled : true,
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
														url : '../controller/generalLedgerChartOfAccountController.php',
														method : 'GET',
														params : {
															method : 'dataNavigationRequest',
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
																			url : '../controller/generalLedgerChartOfAccountController.php',
																			method : 'POST',
																			waitTitle : systemLabel,
																			waitMsg : waitMessageLabel,
																			params : {
																				method : 'read',
																				generalLedgerChartOfAccountId : Ext
																						.getCmp(
																								'firstRecord')
																						.getValue(),
																				leafId : leafId,
																				isAdmin : isAdmin
																			},
																			success : function(
																					form,
																					action) {
																				if (action.result.success == true) {
																					if (action.result.nextRecord == 0) {
																						Ext
																								.getCmp(
																										'nextButton')
																								.disable();
																					} else {
																						Ext
																								.getCmp(
																										'nextButton')
																								.enable();
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
																					+ ':'
																					+ escape(response.statusText));
														}
													});
										} else {
											formPanel.form
													.load({
														url : '../controller/generalLedgerChartOfAccountController.php',
														method : 'POST',
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : 'read',
															generalLedgerChartOfAccountId : Ext
																	.getCmp(
																			'firstRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {
															if (action.result.success == true) {
																if (action.result.nextRecord == 0) {
																	Ext
																			.getCmp(
																					'nextButton')
																			.disable();
																} else {
																	Ext
																			.getCmp(
																					'nextButton')
																			.enable();
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
															} else {
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
												|| Ext.getCmp('previousRecord')
														.getValue() == undefined) {
											Ext.MessageBox.alert(
													systemErrorLabel,
													chooseRecordLabel);
										}
										if (Ext.getCmp('firstRecord')
												.getValue() >= 1) {
											formPanel.form
													.load({
														url : '../controller/generalLedgerChartOfAccountController.php',
														method : 'POST',
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : 'read',
															generalLedgerChartOfAccountId : Ext
																	.getCmp(
																			'previousRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {
															if (action.result.success == true) {
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
																if (Ext
																		.getCmp(
																				'previousRecord')
																		.getValue() == 0) {
																	Ext
																			.getCmp(
																					'previousButton')
																			.disable();
																}
															} else {
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
														.getValue() == undefined) {
											Ext.MessageBox.alert(
													systemErrorLabel,
													chooseRecordLabel);
										}
										if (Ext.getCmp('nextRecord').getValue() <= Ext
												.getCmp('lastRecord')
												.getValue()) {
											formPanel.form
													.load({
														url : '../controller/generalLedgerChartOfAccountController.php',
														method : 'POST',
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : 'read',
															generalLedgerChartOfAccountId : Ext
																	.getCmp(
																			'nextRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {
															if (action.result.success == true) {
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
															} else {
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
														url : '../controller/generalLedgerChartOfAccountController.php',
														method : 'GET',
														params : {
															method : 'dataNavigationRequest',
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
																			url : '../controller/generalLedgerChartOfAccountController.php',
																			method : 'POST',
																			waitTitle : systemLabel,
																			waitMsg : waitMessageLabel,
																			params : {
																				method : 'read',
																				generalLedgerChartOfAccountId : Ext
																						.getCmp(
																								'lastRecord')
																						.getValue(),
																				leafId : leafId,
																				isAdmin : isAdmin
																			},
																			success : function(
																					form,
																					action) {
																				if (action.result.success == true) {
																					if (action.result.previousRecord == 0) {
																						Ext
																								.getCmp(
																										'previousButton')
																								.disable();
																					} else {
																						Ext
																								.getCmp(
																										'previousButton')
																								.enable();
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
																									'nextButton')
																							.disable();
																					Ext
																							.getCmp(
																									'previousButton')
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
																					+ ':'
																					+ escape(response.statusText));
														}
													});
										}
										if (Ext
												.getCmp(
														'generalLedgerChartOfAccountId')
												.getValue() <= Ext.getCmp(
												'lastRecord').getValue()) {
											formPanel.form
													.load({
														url : '../controller/generalLedgerChartOfAccountController.php',
														method : 'POST',
														waitTitle : systemLabel,
														waitMsg : waitMessageLabel,
														params : {
															method : 'read',
															generalLedgerChartOfAccountId : Ext
																	.getCmp(
																			'lastRecord')
																	.getValue(),
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function(
																form, action) {
															if (action.result.success == true) {
																if (action.result.previousRecord == 0) {
																	Ext
																			.getCmp(
																					'previousButton')
																			.disable();
																} else {
																	Ext
																			.getCmp(
																					'previousButton')
																			.enable();
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
																				'nextButton')
																		.disable();
																Ext
																		.getCmp(
																				'previousButton')
																		.enable();
															} else {
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
			var viewPort = new Ext.Viewport({
				id : 'viewport',
				region : 'center',
				layout : 'accordion',
				layoutConfig : {
					titleCollapse : true,
					animate : false,
					activeOnTop : true
				},
				items : [ gridPanel, formPanel ]
			});
		});
