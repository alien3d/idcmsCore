Ext.onReady(function () {
	Ext.QuickTips.init();
	Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';
	Ext.form.Field.prototype.msgTarget = 'under';
	Ext.Ajax.timeout = 90000;
	var perPage = 15;
	var encode = false;
	var local = false;
	var jsonResponse;
	var duplicate = 0; // common Proxy,Reader,Store,Filter,Grid
	// start Staff Request
	var staffByProxy = new Ext.data.HttpProxy({
			url : '../controller/adjustmentLedgerController.php?',
			method : 'GET',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
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
			fields : [{
					name : 'staffId',
					type : 'int'
				}, {
					name : 'staffName',
					type : 'string'
				}
			]
		}); // end Staff Request
	// start log Request
	var logProxy = new Ext.data.HttpProxy({
			url : '../../security/controller/logController.php?',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
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
			fields : [{
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
				}
			]
		});
	var logFilters = new Ext.ux.grid.GridFilters({
			encode : encode,
			local : local,
			filters : [{
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
				}
			]
		});
	var logExpander = new Ext.ux.grid.RowExpander({
			tpl : new Ext.Template('<br><p><b>Operation:</b> {operation}</p><br>', '<p><b>SQL STATEMENT:</b> {sql}</p><br>')
		});
	var logColumnModel = [logExpander, new Ext.grid.RowNumberer(), {
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
		}
	];
	var logGrid = new Ext.grid.GridPanel({
			border : false,
			store : logStore,
			autoHeight : false,
			height : 400,
			columns : logColumnModel,
			loadMask : true,
			plugins : [logFilters, logExpander],
			collapsible : true,
			animCollapse : false,
			selModel : new Ext.grid.RowSelectionModel({
				singleSelect : true
			}),
			viewConfig : {
				emptyText : emptyRowLabel
			},
			iconCls : 'application_view_detail',
			listeners : {
				render : {
					fn : function () {
						logStore.load({
							params : {
								start : 0,
								limit : perPage,
								method : 'read',
								mode : 'view',
								plugin : [logFilters]
							}
						});
					}
				}
			},
			bbar : new Ext.PagingToolbar({
				store : logStore,
				pageSize : perPage,
				plugins : [new Ext.ux.plugins.PageComboResizer()]
			})
		}); // end log Request
	// start Log Advance Request
	var logAdvanceProxy = new Ext.data.HttpProxy({
			url : '../../security/controller/logAdvanceController.php?',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
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
			fields : [{
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
				}
			]
		});
	var logAdvanceFilters = new Ext.ux.grid.GridFilters({
			encode : encode,
			local : local,
			filters : [{
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
				}
			]
		});
	var logAdvanceColumnModel = [new Ext.grid.RowNumberer(), {
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
		}
	];
	var logAdvanceGrid = new Ext.grid.GridPanel({
			border : false,
			store : logAdvanceStore,
			autoHeight : false,
			height : 400,
			columns : logAdvanceColumnModel,
			loadMask : true,
			plugins : [logAdvanceFilters],
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
					fn : function () {
						logAdvanceStore.load({
							params : {
								start : 0,
								limit : perPage,
								method : 'read',
								mode : 'view',
								plugin : [logAdvanceFilters]
							}
						});
					}
				}
			},
			bbar : new Ext.PagingToolbar({
				store : logAdvanceStore,
				pageSize : perPage,
				plugins : [new Ext.ux.plugins.PageComboResizer()]
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
				items : [{
						xtype : 'panel',
						layout : 'fit',
						title : 'Log Sql Statement',
						items : [logGrid]
					}, {
						xtype : 'panel',
						layout : 'fit',
						title : 'Log Sql Statement',
						items : [logAdvanceGrid]
					}
				]
			},
			title : 'Sql Statement audit',
			maximizable : true,
			autoScroll : true
		}); // end popup window for normal log and advance log
	// end common Proxy ,Reader,Store,Filter,Grid
	// start additional Proxy ,Reader,Store,Filter,Grid
	// start business Partner Request
	
	var businessPartnerProxy = new Ext.data.HttpProxy({
			url : '../controller/businessPartnerController.php',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	var businessPartnerReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'businessPartnerId'
		});
	var businessPartnerStore = new Ext.data.JsonStore({
			proxy : businessPartnerProxy,
			reader : businessPartnerReader,
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
			fields : [{
					name : 'businessPartnerId',
					type : 'int'
				}, {
					name : 'businessPartnerDesc',
					type : 'string'
				}, {
					name : 'businessPartnerCompany',
					type : 'string'
				}, {
					name : 'businessPartnerLastName',
					type : 'string'
				}, {
					name : 'businessPartnerFirstName',
					type : 'string'
				}, {
					name : 'businessPartnerEmail',
					type : 'string'
				}, {
					name : 'businessPartnerJobTitle',
					type : 'string'
				}, {
					name : 'businessPartnerBusinessPhone',
					type : 'string'
				}, {
					name : 'businessPartnerHomePhone',
					type : 'string'
				}, {
					name : 'businessPartnerMobilePhone',
					type : 'string'
				}, {
					name : 'businessPartnerFaxNum',
					type : 'string'
				}, {
					name : 'businessPartnerAddress',
					type : 'string'
				}, {
					name : 'businessPartnerCity',
					type : 'string'
				}, {
					name : 'businessPartnerState',
					type : 'string'
				}, {
					name : 'businessPartnerPostCode',
					type : 'string'
				}, {
					name : 'businessPartnerCountry',
					type : 'string'
				}, {
					name : 'businessPartnerWebPage',
					type : 'string'
				}, {
					name : 'businessPartnerNotes',
					type : 'string'
				}, {
					name : 'businessPartnerAttachments',
					type : 'string'
				}, {
					name : 'businessPartnerCategoryId',
					type : 'int'
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
					name : 'isReview',
					type : 'boolean'
				}, {
					name : 'isPost',
					type : 'boolean'
				}, {
					name : 'executeBy',
					type : 'int'
				}, {
					name : 'executeTime',
					type : 'date',
					dateFormat : 'Y-m-d H:i:s'
				}
			]
		});
	// end business Partner Request
	// start chart of account request
	var generalLedgerChartOfAccountProxy = new Ext.data.HttpProxy({
			url : '../controller/generalLedgerChartOfAccountController.php',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	var generalLedgerChartOfAccountReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'generalLedgerChartOfAccountId'
		});
	var generalLedgerChartOfAccountStore = new Ext.data.JsonStore({
			proxy : generalLedgerChartOfAccountProxy,
			reader : generalLedgerChartOfAccountReader,
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
			fields : [{
					key : 'PRI',
					foreignKey : 'no',
					name : 'generalLedgerChartOfAccountId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'generalLedgerChartOfAccountTitle',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'generalLedgerChartOfAccountDesc',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'generalLedgerChartOfAccountNo',
					type : 'string'
				}, {
					key : 'MUL',
					foreignKey : 'yes',
					name : 'generalLedgerChartOfAccountTypeId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'generalLedgerChartOfAccountReportType',
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
					name : 'isConsolidation',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'isSeperated',
					type : 'int'
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
				}
			]
		}); // end General Ledger Chart of account request
	
	// start currency code request
	var countryProxy = new Ext.data.HttpProxy({
			url : '../controller/countryController.php',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	var countryReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'countryId'
		});
	var countryStore = new Ext.data.JsonStore({
			proxy : countryProxy,
			reader : countryReader,
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
			id : 'countryCurrencyCode',
			fields : [{
					name : 'countryId',
					type : 'string'
				}, {
					name : 'countryCurrencyCode',
					type : 'string'
				}, {
					name : 'countryCurrencyCodeDesc',
					type : 'string'
				}
			]
		}); // end currency code request
	//  start invoice category request
	var invoiceLedgerProxy = new Ext.data.HttpProxy({
			url : '../controller/invoiceLedgerController.php',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) {
					
					// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
					
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	var invoiceCategoryProxy = new Ext.data.HttpProxy({
			url : '../controller/invoiceCategoryController.php',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) {
					
					// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
					
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	
	var invoiceCategoryReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'invoiceCategoryId'
		});
	
	var invoiceCategoryStore = new Ext.data.JsonStore({
			proxy : invoiceCategoryProxy,
			reader : invoiceCategoryReader,
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
			id : 'invoiceCategoryId',
			fields : [{
					key : 'PRI',
					foreignKey : 'no',
					name : 'invoiceCategoryId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceCategorySequence',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceCategoryCode',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceCategoryDesc',
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
				}
			]
		});
	
	// end invoiceCategory request
	//start invoiceType request
	
	var invoiceTypeProxy = new Ext.data.HttpProxy({
			url : '../controller/invoiceTypeController.php',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) {
					
					// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
					
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	
	var invoiceTypeReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'invoiceTypeId'
		});
	
	var invoiceTypeStore = new Ext.data.JsonStore({
			proxy : invoiceTypeProxy,
			reader : invoiceTypeReader,
			autoLoad : false,
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
			id : 'invoiceTypeId',
			fields : [{
					key : 'PRI',
					foreignKey : 'no',
					name : 'invoiceTypeId',
					type : 'int'
				}, {
					key : 'MUL',
					foreignKey : 'yes',
					name : 'invoiceCategoryId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceTypeSequence',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceTypeCode',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceTypeDesc',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceTypeCreditLimit',
					type : 'float'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceTypeInterestRate',
					type : 'float'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceTypeMinimumDeposit',
					type : 'float'
				}, {
					key : 'MUL',
					foreignKey : 'no',
					name : 'generalLedgerChartOfAccountDimensionId',
					type : 'int'
				}, {
					key : 'MUL',
					foreignKey : 'yes',
					name : 'lateInterestId',
					type : 'int'
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
				}
			]
		});
	
	// end invoiceType request
	// start invoice request
	var invoiceLedgerReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'invoiceLedgerId'
		});
	
	var invoiceLedgerStore = new Ext.data.JsonStore({
			proxy : invoiceLedgerProxy,
			reader : invoiceLedgerReader,
			autoLoad : false,
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
			id : 'invoiceLedgerId',
			fields : [{
					key : 'PRI',
					foreignKey : 'no',
					name : 'invoiceLedgerId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'documentNo',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'referenceNo',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceLedgerTitle',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceLedgerDesc',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceLedgerDate',
					type : 'date',
					dateFormat : 'Y-m-d'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceLedgerAmount',
					type : 'float'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'businessPartnerId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceCategoryId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceTypeId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'invoiceLedger',
					type : 'int'
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
				}
			]
		});
	// end invoice request
	//start adjustmentType request
	
	var adjustmentTypeProxy = new Ext.data.HttpProxy({
			url : '../controller/adjustmentTypeController.php',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) {
					
					// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
					
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	
	var adjustmentTypeReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'adjustmentTypeId'
		});
	
	var adjustmentTypeStore = new Ext.data.JsonStore({
			proxy : adjustmentTypeProxy,
			reader : adjustmentTypeReader,
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
			id : 'adjustmentTypeId',
			fields : [{
					key : 'PRI',
					foreignKey : 'no',
					name : 'adjustmentTypeId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'adjustmentTypeSequence',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'adjustmentTypeCode',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'adjustmentTypeDesc',
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
				}, {
		            key: '',
		            foreignKey: 'no',
		            name: 'transactionMode',
		            type: 'string'
		        }
			]
		});
	
	// end adjustmentType request
	// end additional Proxy ,Reader,Store,Filter,Grid
	// start application Proxy ,Reader,Store,Filter,Grid
	var adjustmentLedgerProxy = new Ext.data.HttpProxy({
			url : '../controller/adjustmentLedgerController.php',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	var adjustmentLedgerReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'adjustmentLedgerId'
		});
	var adjustmentLedgerStore = new Ext.data.JsonStore({
			proxy : adjustmentLedgerProxy,
			reader : adjustmentLedgerReader,
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
			fields : [{
					key : 'PRI',
					foreignKey : 'no',
					name : 'adjustmentLedgerId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'adjustmentTypeId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'documentNo',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'adjustmentLedgerTitle',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'adjustmentLedgerDesc',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'adjustmentLedgerDate',
					type : 'date',
					dateFormat : 'Y-m-d'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'adjustmentLedgerAmount',
					type : 'date',
					dateFormat : 'Y-m-d'
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
				}, {
					key : '',
					foreignKey : 'no',
					name : 'adjustmentTypeDesc',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'staffNo',
					type : 'string'
				}
			]
		});
	var adjustmentLedgerFilters = new Ext.ux.grid.GridFilters({
			encode : encode,
			local : local,
			filters : [{
					type : 'int',
					dataIndex : 'adjustmentLedgerId',
					column : 'adjustmentLedgerId',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'int',
					dataIndex : 'adjustmentTypeId',
					column : 'adjustmentTypeId',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'documentNo',
					column : 'documentNo',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'adjustmentLedgerTitle',
					column : 'adjustmentLedgerTitle',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'adjustmentLedgerDesc',
					column : 'adjustmentLedgerDesc',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'date',
					dataIndex : 'adjustmentLedgerDate',
					column : 'adjustmentLedgerDate',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'date',
					dataIndex : 'adjustmentLedgerAmount',
					column : 'adjustmentLedgerAmount',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isDefault',
					column : 'isDefault',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isNew',
					column : 'isNew',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isDraft',
					column : 'isDraft',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isUpdate',
					column : 'isUpdate',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isDelete',
					column : 'isDelete',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isActive',
					column : 'isActive',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isApproved',
					column : 'isApproved',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isReview',
					column : 'isReview',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isPost',
					column : 'isPost',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}, {
					type : 'list',
					dataIndex : 'executeBy',
					column : 'executeBy',
					table : 'adjustmentLedger',
					database : 'ifinancial',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'adjustmentLedger',
					database : 'ifinancial'
				}
			]
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
	var adjustmentLedgerColumnModel = [{
			dataIndex : 'adjustmentTypeId',
			header : adjustmentTypeForeignKeyLabel,
			sortable : true,
			hidden : false,
			renderer : function (value, metaData, record, rowIndex, colIndex, store) {
				return record.data.adjustmentTypeDesc;
			}
		}, {
			dataIndex : 'documentNo',
			header : documentNoLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'adjustmentLedgerTitle',
			header : adjustmentLedgerTitleLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'adjustmentLedgerDesc',
			header : adjustmentLedgerDescLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'adjustmentLedgerDate',
			header : adjustmentLedgerDateLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'adjustmentLedgerAmount',
			header : adjustmentLedgerAmountLabel,
			sortable : true,
			hidden : false
		},
		isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid, isDeleteGrid, isActiveGrid, isApprovedGrid, isReviewGrid, isPostGrid, {
			dataIndex : 'executeBy',
			header : executeByLabel,
			sortable : true,
			hidden : false,
			renderer : function (value, metaData, record, rowIndex, colIndex, store) {
				return record.data.staffName;
			}
		}, {
			dataIndex : 'executeTime',
			header : executeTimeLabel,
			sortable : true,
			hidden : false,
			renderer : function (value, metaData, record, rowIndex, colIndex, store) {
				return Ext.util.Format.date(value, 'd-m-Y H:i:s');
			}
		}
	];
	var adjustmentLedgerFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
	var adjustmentLedgerGrid = new Ext.grid.GridPanel({
			border : false,
			store : adjustmentLedgerStore,
			autoHeight : false,
			columns : adjustmentLedgerColumnModel,
			loadMask : true,
			plugins : [adjustmentLedgerFilters],
			autoScroll : true,
			selModel : new Ext.grid.RowSelectionModel({
				singleSelect : true
			}),
			viewConfig : {
				forceFit : true,
				emptyText : emptyRowLabel
			},
			iconCls : 'application_view_detail',
			listeners : {
				'rowclick' : function (object, rowIndex, e) {
					var record = adjustmentLedgerStore.getAt(rowIndex);
					formPanel.getForm().reset();
					formPanel.form.load({
						url : '../controller/adjustmentLedgerController.php',
						method : 'POST',
						waitTitle : systemLabel,
						waitMsg : waitMessageLabel,
						params : {
							method : 'read',
							mode : 'update',
							adjustmentLedgerId : record.data.adjustmentLedgerId,
							leafId : leafId,
							isAdmin : isAdmin
						},
						success : function (form, action) {
							Ext.getCmp('newButton').disable();
							Ext.getCmp('saveButton').enable();
							Ext.getCmp('deleteButton').enable();
							Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
							Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
							Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
							Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
							Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
							adjustmentLedgerDetailStore.load({
								params : {
									leafId : leafId,
									isAdmin : isAdmin,
									adjustmentLedgerId : record.data.adjustmentLedgerId
								}
							});
							if (Ext.getCmp('previousRecord').getValue() == 0) {
								Ext.getCmp('previousButton').disable();
							}
							if (Ext.getCmp('nextRecord').getValue() == 0) {
								Ext.getCmp('nextButton').disable();
							}
							adjustmentLedgerDetailGrid.enable();
							if (action.result.trialBalance > 0) {
								Ext.getCmp('postButton').disable();
								Ext.MessageBox.alert(systemErrorLabel, "Trial Balance no tally");
							}
							if (action.result.tally > 0) {
								Ext.getCmp('postButton').disable();
								Ext.MessageBox.alert(systemErrorLabel, "Total Debit and Credit not Tally");
							}
							if (action.result.tally == 0 && action.result.trialBalance == 0) {
								Ext.getCmp('postButton').enable();
							}
							viewPort.items.get(1).expand();
						},
						failure : function (form, action) {
							Ext.MessageBox.alert(systemErrorLabel, action.result.message);
						}
					});
				}
			},
			tbar : {
				items : [{
						text : addToolbarLabel,
						iconCls : 'add',
						id : 'pageCreate',
						iconCls : 'add',
						xtype : 'button',
						handler : function () {
							viewPort.items.get(1).expand();
						}
					}, {
						xtype : 'button',
						text : CheckAllLabel,
						iconCls : 'row-check-sprite-check',
						listeners : {
							'click' : function (button, e) {
								adjustmentLedgerStore.each(function (record, fn, scope) {
									for (var access in adjustmentLedgerFlagArray) {
										record.set(adjustmentLedgerFlagArray[access], true);
									}
								});
							}
						}
					}, {
						xtype : 'button',
						text : ClearAllLabel,
						iconCls : 'row-check-sprite-uncheck',
						listeners : {
							'click' : function (button, e) {
								adjustmentLedgerStore.each(function (record, fn, scope) {
									for (var access in adjustmentLedgerFlagArray) {
										record.set(adjustmentLedgerFlagArray[access], false);
									}
								});
							}
						}
					}, {
						xtype : 'button',
						text : saveButtonLabel,
						iconCls : 'bullet_disk',
						listeners : {
							'click' : function (button, e) {
								var url = '../controller/adjustmentLedgerController.php?';
								var sub_url = '';
								var modified = adjustmentLedgerStore.getModifiedRecords();
								for (var i = 0; i < modified.length; i++) {
									var dataChanges = modified[i].getChanges();
									sub_url = sub_url + '&adjustmentLedgerId[]=' + modified[i].get('adjustmentLedgerId');
									if (isAdmin == 1) {
										if (dataChanges.isDefault == true || dataChanges.isDefault == false) {
											sub_url = sub_url + '&isDefault[]=' + modified[i].get('isDefault');
										}
										if (dataChanges.isDraft == true || dataChanges.isDraft == false) {
											sub_url = sub_url + '&isDraft[]=' + modified[i].get('isDraft');
										}
										if (dataChanges.isNew == true || dataChanges.isNew == false) {
											sub_url = sub_url + '&isNew[]=' + modified[i].get('isNew');
										}
										if (dataChanges.isUpdate == true || dataChanges.isUpdate == false) {
											sub_url = sub_url + '&isUpdate[]=' + modified[i].get('isUpdate');
										}
									}
									if (dataChanges.isDelete == true || dataChanges.isDelete == false) {
										sub_url = sub_url + '&isDelete[]=' + modified[i].get('isDelete');
									}
									if (isAdmin == 1) {
										if (dataChanges.isActive == true || dataChanges.isActive == false) {
											ssub_url = sub_url + '&isActive[]=' + modified[i].get('isActive');
										}
										if (dataChanges.isApproved == true || dataChanges.isApproved == false) {
											sub_url = sub_url + '&isApproved[]=' + modified[i].get('isApproved');
										}
										if (dataChanges.isReview == true || dataChanges.isReview == false) {
											sub_url = sub_url + '&isReview[]=' + modified[i].get('isReview');
										}
										if (dataChanges.isPost == true || dataChanges.isPost == false) {
											sub_url = sub_url + '&isPost[]=' + modified[i].get('isPost');
										}
									}
								}
								url = url + sub_url;
								Ext.Ajax.request({
									url : url,
									method : 'GET',
									params : {
										leafId : leafId,
										isAdmin : isAdmin,
										method : 'updateStatus'
									},
									success : function (response, options) {
										jsonResponse = Ext.decode(response.responseText);
										if (jsonResponse.success == true) {
											Ext.MessageBox.alert(systemLabel, jsonResponse.message);
											adjustmentLedgerStore.reload();
										} else if (jsonResponse.success == false) {
											Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
										}
									},
									failure : function (response, options) {
										Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
									}
								});
							}
						}
					},
					'->', new Ext.ux.form.SearchField({
						store : adjustmentLedgerStore,
						width : 320
					})]
			},
			bbar : new Ext.PagingToolbar({
				store : adjustmentLedgerStore,
				pageSize : perPage
			}),
			view : new Ext.ux.grid.BufferView({
				rowHeight : 34,
				scrollDelay : false
			})
		});
	var dateRangeStart = new Ext.form.Hidden({
			name : 'dateRangeStart',
			id : 'dateRangeStart',
			value : ''
		});
	var dateRangeEnd = new Ext.form.Hidden({
			name : 'dateRangeEnd',
			id : 'dateRangeEnd',
			value : ''
		});
	var dateRangeType = new Ext.form.Hidden({
			name : 'dateRangeType',
			id : 'dateRangeType'
		});
	function zeroFill(value) {
		if (value.length == 1) {
			return "0" + value;
		} else {
			return value;
		}
	}
	function forwardDate(dateReceive, dateRangeType) {
		var explodeDate = dateReceive.split("-");
		var dayReceive = parseInt(explodeDate[2]);
		var monthReceive = parseInt(explodeDate[1]);
		var yearReceive = parseInt(explodeDate[0]);
		totalDayInMonth = 32 - new Date(yearReceive, monthReceive - 2, 32).getDate();
		if (dateRangeType == 'day') {
			dayReceive++;
			if (dayReceive >= totalDayInMonth) {
				dayReceive = 1;
				monthReceive++;
				if (monthReceive == 13) {
					monthReceive = 1;
					yearReceive++;
				} else {
					monthReceive++;
				}
			}
			return (yearReceive + "-" + zeroFill(monthReceive) + "-" + zeroFill(dayReceive));
		} else if (dateRangeType == 'week') {
			if (dayReceive > totalDayInMonth) {
				dayReceive = 1 + 7;
				if (monthReceive == 13) {
					yearReceive++;
					monthReceive = 1;
				} else {
					monthReceive++;
				}
			} else {
				dayReceive = dayReceive + 7;
				if (dayReceive > totalDayInMonth) {
					dayReceive = dayReceive - totalDayInMonth;
				}
			}
			return (yearReceive + "-" + zeroFill(monthReceive) + "-" + zeroFill(dayReceive));
		} else if (dateRangeType == 'month') {
			alert("v" + monthReceive);
			if (monthReceive == 12) {
				yearReceive++;
				monthReceive = 1;
				alert("ddd" + monthReceive);
			} else {
				alert("e" + monthReceive);
				monthReceive++;
				alert("aaa" + monthReceive);
			}
			alert(yearReceive + "-" + monthReceive + "-" + dayReceive);
			return (yearReceive + "-" + zeroFill(monthReceive) + "-" + zeroFill(dayReceive));
		} else if (dateRangeType == 'year') {
			yearReceive++;
			return (yearReceive + "-" + zeroFill(monthReceive) + "-" + zeroFill(dayReceive));
		}
	}
	function previousDate(dateReceive, dateRangeType) {
		var explodeDate = dateReceive.split("-");
		var dayReceive = parseInt(explodeDate[2]);
		var monthReceive = parseInt(explodeDate[1]);
		var yearReceive = parseInt(explodeDate[0]);
		if (dateRangeType == 'day') {
			dayReceive--;
			if (dayReceive == 0) {
				monthReceive--;
				dayReceive = 32 - new Date(yearReceive, monthReceive - 2, 32).getDate();
			}
			return (yearReceive + "-" + zeroFill(monthReceive) + "-" + zeroFill(dayReceive));
		} else if (dateRangeType == 'week') {
			date_day = dayReceive;
			dayReceive = parseInt(dayReceive - 7);
			if (dayReceive <= 0) {
				monthReceive--;
			}
			dayReceive = 32 - new Date(yearReceive, monthReceive - 2, 32).getDate();
			dayReceive = parseInt(dayReceive - 7 + date_day);
			if (monthReceive == 0 || monthReceive == '00') {
				dayReceive = 31;
				monthReceive = 12;
				yearReceive--;
			}
			return (yearReceive + "-" + zeroFill(monthReceive) + "-" + zeroFill(dayReceive));
		} else if (dateRangeType == 'month') {
			monthReceive--;
			if (monthReceive == 0) {
				monthReceive = 12;
				yearReceive--;
			}
			dayReceive = 32 - new Date(yearReceive, monthReceive - 2, 32).getDate();
			return (yearReceive + "-" + zeroFill(monthReceive) + "-" + zeroFill(dayReceive));
		} else if (dateRangeType == 'year') {
			yearReceive--;
			return (yearReceive + "-" + zeroFill(monthReceive) + "-" + zeroFill(dayReceive));
		}
	}
	function currentDay() {
		dateRangeStartValue = new Date();
		return dateRangeStartValue.getDate() + '-' + (dateRangeStartValue.getMonth() + 1) + '-' + dateRangeStartValue.getFullYear();
	}
	var gridPanel = new Ext.Panel({
			title : leafNative,
			height : 50,
			layout : 'fit',
			iconCls : 'application_view_detail',
			tbar : [{
					xtype : 'button',
					iconCls : 'resultset_first',
					handler : function (button, e) {
						var dateRangeStartValue = '';
						if (Ext.getCmp('dateRangeStart').getValue() == '' || Ext.getCmp('dateRangeStart').getValue() == undefined) {
							dateRangeStartValue = new Date();
							Ext.getCmp('dateRangeStart').setValue(dateRangeStartValue.getFullYear() + "-" + (dateRangeStartValue.getMonth() + 1) + "-" + dateRangeStartValue.getDate());
						}
						if (Ext.getCmp('dateRangeType').getValue() == '' || Ext.getCmp('dateRangeType').getValue() == undefined) {
							Ext.getCmp('dateRangeType').setValue('day');
						}
						Ext.getCmp('dateRangeStart').setValue(previousDate(Ext.getCmp('dateRangeStart').getValue(), Ext.getCmp('dateRangeType').getValue()));
						Ext.getCmp('currentDateRangeType').setText('Filter : ' + Ext.getCmp('dateRangeType').getValue());
						var dateRangeStartArray = Ext.getCmp('dateRangeStart').getValue();
						var dateRangeStartArrayData = dateRangeStartArray.split("-");
						var dayDateRangeStartArrayData = dateRangeStartArrayData[2];
						var monthDateRangeStartArrayData = dateRangeStartArrayData[1];
						var yearDateRangeStartArrayData = dateRangeStartArrayData[0];
						Ext.getCmp('filterDay').setText('Filter Day : ' + dayDateRangeStartArrayData);
						Ext.getCmp('filterMonth').setText('Filter Month : ' + monthDateRangeStartArrayData);
						Ext.getCmp('filterYear').setText('Filter Year:' + yearDateRangeStartArrayData);
						adjustmentLedgerStore.reload({
							params : {
								dateRangeType : Ext.getCmp('dateRangeType').getValue(),
								dateRangeStart : Ext.getCmp('dateRangeStart').getValue()
							}
						});
					}
				},
				'-', {
					xtype : 'button',
					text : 'Day',
					tooltip : 'Day',
					iconCls : 'calendar',
					handler : function (button, e) {
						Ext.getCmp('dateRangeType').setValue('day');
						if (Ext.getCmp('dateRangeStart').getValue() == '' || Ext.getCmp('dateRangeStart').getValue() == undefined) {
							dateRangeStartValue = new Date();
							Ext.getCmp('dateRangeStart').setValue(dateRangeStartValue.getFullYear() + "-" + (dateRangeStartValue.getMonth() + 1) + "-" + dateRangeStartValue.getDate());
							Ext.getCmp('filterDay').setText('Filter Day : ' + (dateRangeStartValue.getDate()));
							Ext.getCmp('filterMonth').setText('Filter Month : ' + (dateRangeStartValue.getMonth() + 1));
							Ext.getCmp('filterYear').setText('Filter Year:' + dateRangeStartValue.getFullYear());
						}
						Ext.getCmp('currentDateRangeType').setText('Filter : ' + Ext.getCmp('dateRangeType').getValue());
						adjustmentLedgerStore.reload({
							params : {
								dateRangeType : Ext.getCmp('dateRangeType').getValue(),
								dateRangeStart : Ext.getCmp('dateRangeStart').getValue()
							}
						});
					}
				},
				'-', {
					xtype : 'button',
					text : 'Week',
					tooltip : 'Week',
					iconCls : 'calendar',
					handler : function (button, e) {
						Ext.getCmp('dateRangeType').setValue('week');
						var curr = new Date();
						var first = curr.getDate() - curr.getDay();
						var last = first + 6;
						var f = new Date(curr.setDate(first));
						var l = new Date(curr.setDate(last));
						Ext.getCmp('dateRangeStart').setValue(f.getFullYear() + "-" + (f.getMonth() + 1) + "-" + f.getDate());
						Ext.getCmp('dateRangeEnd').setValue(l.getFullYear() + "-" + (l.getMonth() + 1) + "-" + l.getDate());
						Ext.getCmp('currentDateRangeType').setText('Filter : ' + Ext.getCmp('dateRangeType').getValue());
						adjustmentLedgerStore.reload({
							params : {
								dateRangeType : Ext.getCmp('dateRangeType').getValue(),
								dateRangeStart : Ext.getCmp('dateRangeStart').getValue(),
								dateRangeEnd : Ext.getCmp('dateRangeEnd').getValue()
							}
						});
					}
				},
				'-', {
					xtype : 'button',
					text : 'Month',
					tooltip : 'Month',
					iconCls : 'calendar',
					handler : function (button, e) {
						Ext.getCmp('dateRangeType').setValue('month');
						if (Ext.getCmp('dateRangeStart').getValue() == '' || Ext.getCmp('dateRangeStart').getValue() == undefined) {
							dateRangeStartValue = new Date();
							Ext.getCmp('dateRangeStart').setValue(dateRangeStartValue.getFullYear() + "-" + (dateRangeStartValue.getMonth() + 1) + "-" + dateRangeStartValue.getDate());
							Ext.getCmp('filterDay').setText('Filter Day : ' + (dateRangeStartValue.getDate()));
							Ext.getCmp('filterMonth').setText('Filter Month : ' + (dateRangeStartValue.getMonth() + 1));
							Ext.getCmp('filterYear').setText('Filter Year:' + dateRangeStartValue.getFullYear());
						}
						Ext.getCmp('currentDateRangeType').setText('Filter : ' + Ext.getCmp('dateRangeType').getValue());
						adjustmentLedgerStore.reload({
							params : {
								dateRangeType : Ext.getCmp('dateRangeType').getValue(),
								dateRangeStart : Ext.getCmp('dateRangeStart').getValue()
							}
						});
					}
				},
				'-', {
					xtype : 'button',
					text : 'Year',
					tooltip : 'Year',
					iconCls : 'calendar',
					handler : function (button, e) {
						Ext.getCmp('dateRangeType').setValue('year');
						if (Ext.getCmp('dateRangeStart').getValue() == '' || Ext.getCmp('dateRangeStart').getValue() == undefined) {
							dateRangeStartValue = new Date();
							Ext.getCmp('dateRangeStart').setValue(dateRangeStartValue.getFullYear() + "-" + (dateRangeStartValue.getMonth() + 1) + "-" + dateRangeStartValue.getDate());
							Ext.getCmp('filterDay').setText('Filter Day : ' + (dateRangeStartValue.getDate()));
							Ext.getCmp('filterMonth').setText('Filter Month : ' + (dateRangeStartValue.getMonth() + 1));
							Ext.getCmp('filterYear').setText('Filter Year:' + dateRangeStartValue.getFullYear());
						}
						Ext.getCmp('currentDateRangeType').setText('Filter : ' + Ext.getCmp('dateRangeType').getValue());
						adjustmentLedgerStore.reload({
							params : {
								dateRangeType : Ext.getCmp('dateRangeType').getValue(),
								dateRangeStart : Ext.getCmp('dateRangeStart').getValue()
							}
						});
					}
				},
				'-', {
					xtype : 'label',
					name : 'currentDay',
					id : 'currentDay',
					text : 'Current Day : ' + currentDay()
				},
				'-', {
					xtype : 'label',
					name : 'filterDay',
					id : 'filterDay',
					text : 'Filter Day : '
				},
				'-', {
					xtype : 'label',
					name : 'filterMonth',
					id : 'filterMonth',
					text : 'Filter Month : '
				},
				'-', {
					xtype : 'label',
					name : 'filterYear',
					id : 'filterYear',
					text : 'Filter Year : '
				},
				'-', {
					xtype : 'label',
					name : 'currentDateRangeType',
					id : 'currentDateRangeType',
					text : 'Filter : '
				},
				'-', {
					xtype : 'label',
					name : 'startdate',
					id : 'startdate',
					text : 'Start'
				},
				'-', {
					xtype : 'datefield',
					name : 'dateRangeBetweenStart',
					id : 'dateRangeBetweenStart'
				},
				'-', {
					xtype : 'label',
					name : 'endDate',
					id : 'endDate',
					text : 'End'
				},
				'-', {
					xtype : 'datefield',
					name : 'dateRangeBetweenEnd',
					id : 'dateRangeBetweenEnd'
				},
				'-', {
					xtype : 'button',
					name : 'filterBetweenButton',
					id : 'filterBetweenButton',
					text : 'Search Between Date',
					handler : function (e, a) {
						adjustmentLedgerStore.reload({
							params : {
								dateRangeType : Ext.getCmp('dateRangeType').getValue(),
								dateRangeStart : Ext.getCmp('dateRangeBetweenStart').getValue(),
								dateRangeEnd : Ext.getCmp('dateRangeBetweenEnd').getValue()
							}
						});
					}
				}, '-', {
					xtype : 'button',
					name : 'resetFilterDate',
					id : 'resetFilterDate',
					text : 'Reset Date',
					handler : function (button, e) {
						dateRangeStartValue = new Date();
						Ext.getCmp('dateRangeStart').setValue(dateRangeStartValue.getFullYear() + "-" + (dateRangeStartValue.getMonth() + 1) + "-" + dateRangeStartValue.getDate());
					}
				}, '->', {
					xtype : 'button',
					iconCls : 'resultset_last',
					handler : function (button, e) {
						if (Ext.getCmp('dateRangeStart').getValue() == '' || Ext.getCmp('dateRangeStart').getValue() == undefined) {
							dateRangeStartValue = new Date();
							Ext.getCmp('dateRangeStart').setValue(dateRangeStartValue.getFullYear() + "-" + (dateRangeStartValue.getMonth() + 1) + "-" + dateRangeStartValue.getDate());
						}
						dateRangeStartValue = Ext.getCmp('dateRangeStart').getValue();
						if (Ext.getCmp('dateRangeType').getValue() == '' || Ext.getCmp('dateRangeType').getValue() == undefined) {
							Ext.getCmp('dateRangeType').setValue('day');
						}
						Ext.getCmp('dateRangeStart').setValue(forwardDate(Ext.getCmp('dateRangeStart').getValue(), Ext.getCmp('dateRangeType').getValue()));
						Ext.getCmp('currentDateRangeType').setText('Filter : ' + Ext.getCmp('dateRangeType').getValue());
						var dateRangeStartArray = Ext.getCmp('dateRangeStart').getValue();
						var dateRangeStartArrayData = dateRangeStartArray.split("|");
						var dayDateRangeStartArrayData = dateRangeStartArrayData[2];
						var monthDateRangeStartArrayData = dateRangeStartArrayData[1];
						var yearDateRangeStartArrayData = dateRangeStartArrayData[0];
						Ext.getCmp('filterDay').setText('Filter Day : ' + dayDateRangeStartArrayData);
						Ext.getCmp('filterMonth').setText('Filter Month : ' + monthDateRangeStartArrayData);
						Ext.getCmp('filterYear').setText('Filter Year:' + yearDateRangeStartArrayData);
						var dateRangeStartArray = Ext.getCmp('dateRangeStart').getValue();
						var dateRangeStartArrayData = dateRangeStartArray.split("-");
						var dayDateRangeStartArrayData = dateRangeStartArrayData[2];
						var monthDateRangeStartArrayData = dateRangeStartArrayData[1];
						var yearDateRangeStartArrayData = dateRangeStartArrayData[0];
						Ext.getCmp('filterDay').setText('Filter Day : ' + dayDateRangeStartArrayData);
						Ext.getCmp('filterMonth').setText('Filter Month : ' + monthDateRangeStartArrayData);
						Ext.getCmp('filterYear').setText('Filter Year:' + yearDateRangeStartArrayData);
						adjustmentLedgerStore.reload({
							params : {
								dateRangeType : Ext.getCmp('dateRangeType').getValue(),
								dateRangeStart : Ext.getCmp('dateRangeStart').getValue()
							}
						});
					}
				}
			],
			items : [adjustmentLedgerGrid]
		}); // viewport just save information,items will do separate
	// start form entry
	var documentNoTemp = new Ext.form.Hidden({
			name : 'documentNoTemp',
			id : 'documentNoTemp'
		});
	var adjustmentLedgerId = new Ext.form.Hidden({
			name : 'adjustmentLedgerId',
			id : 'adjustmentLedgerId'
		});
	var businessPartnerId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : businessPartnerForeignKeyLabel,
			name : 'businessPartnerId',
			hiddenName : 'businessPartnerd',
			valueField : 'businessPartnerId',
			hiddenId : 'businessPartnerd_fake',
			id : 'businessPartnerId',
			displayField : 'businessPartnerDesc',
			typeAhead : false,
			triggerAction : 'all',
			store : businessPartnerStore,
			anchor : '95%',
			selectOnFocus : true,
			mode : 'local',
			allowBlank : false,
			blankText : blankTextLabel,
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				 value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			}
		});
	var adjustmentTypeId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : adjustmentTypeForeignKeyLabel,
			name : 'adjustmentTypeId',
			hiddenName : 'adjustmentTypeId',
			valueField : 'adjustmentTypeId',
			hiddenId : 'adjustmentTypeId_fake',
			id : 'adjustmentTypeId',
			displayField : 'adjustmentTypeDesc',
			typeAhead : false,
			triggerAction : 'all',
			store : adjustmentTypeStore,
			anchor : '95%',
			selectOnFocus : true,
			mode : 'local',
			allowBlank : false,
			blankText : blankTextLabel,
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				 value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			}
		});
	var invoiceCategoryId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : invoiceCategoryForeignKeyLabel,
			name : 'invoiceCategoryId',
			hiddenName : 'invoiceCategoryId',
			valueField : 'invoiceCategoryId',
			hiddenId : 'invoiceCategoryId_fake',
			id : 'invoiceCategoryId',
			displayField : 'invoiceCategoryDesc',
			typeAhead : false,
			triggerAction : 'all',
			store : invoiceCategoryStore,
			anchor : '95%',
			selectOnFocus : true,
			mode : 'local',
			allowBlank : false,
			blankText : blankTextLabel,
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				 value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			},
			listeners : {
				'select': function(combo, record, index) {
					Ext.Ajax.request({
						url: '../controller/invoiceTypeController.php',
						method: 'GET',
						params: {
							method: 'read',
							invoiceCategoryId: combo.value,
							leafId: leafId,
							isadmin:isAdmin
						},
						success: function(response, options) {
							jsonResponse = Ext.decode(response.responseText);
							if (jsonResponse.success == false) {
								Ext.MessageBox.alert(systemLabel, jsonResponse.message);
							} else {
								//Ext.MessageBox.alert(systemLabel, jsonResponse.message);
							}
						},
						failure: function(response, options) {
							Ext.MessageBox.alert(systemLabel, escape(response.status) + ':' + escape(response.statusText));
						}
					});
				}
			}
		});
	var invoiceTypeId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : invoiceTypeForeignKeyLabel,
			name : 'invoiceTypeId',
			hiddenName : 'invoiceTypeId',
			valueField : 'invoiceTypeId',
			hiddenId : 'invoiceTypeId_fake',
			id : 'invoiceTypeId',
			displayField : 'invoiceTypeDesc',
			typeAhead : false,
			triggerAction : 'all',
			store : invoiceTypeStore,
			anchor : '95%',
			selectOnFocus : true,
			mode : 'local',
			allowBlank : false,
			blankText : blankTextLabel,
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				 value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			},
			listeners : {
				'select': function(combo, record, index) {
					Ext.Ajax.request({
						url: '../controller/invoiceLedgerController.php',
						method: 'GET',
						params: {
							method: 'read',
							invoiceCategoryId: Ext.getCmp('invoiceCategoryId').getValue(),
							invoiceTypeId: combo.value,
							leafId:leafId,
							isAdmin:isAdmin
							
						},
						success: function(response, options) {
							jsonResponse = Ext.decode(response.responseText);
							if (jsonResponse.success == false) {
								Ext.MessageBox.alert(systemLabel, jsonResponse.message);
							} else {
								//Ext.MessageBox.alert(systemLabel, jsonResponse.message);
							}
						},
						failure: function(response, options) {
							Ext.MessageBox.alert(systemLabel, escape(response.status) + ':' + escape(response.statusText));
						}
					});
				}
			}
		});
	
	var invoiceLedgerId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : invoiceLedgerForeignKeyLabel,
			name : 'invoiceLedgerId',
			hiddenName : 'invoiceLedgerId',
			valueField : 'invoiceLedgerId',
			hiddenId : 'invoiceLedgerId_fake',
			id : 'invoiceLedger',
			displayField : 'invoiceLedgerDesc',
			typeAhead : false,
			triggerAction : 'all',
			store : invoiceLedgerStore,
			anchor : '95%',
			selectOnFocus : true,
			mode : 'local',
			allowBlank : false,
			blankText : blankTextLabel,
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				 value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			}
		});
	var documentNo = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : documentNoLabel + '*',
			hiddenName : 'documentNo',
			name : 'documentNo',
			id : 'documentNo',
			allowBlank : false,
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '90%'
		});
	var referenceNo = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : referenceNoLabel + '*',
			hiddenName : 'referenceNo',
			name : 'referenceNo',
			id : 'referenceNo',
			allowBlank : false,
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '90%'
		});
	var adjustmentLedgerTitle = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : adjustmentLedgerTitleLabel + '*',
			hiddenName : 'adjustmentLedgerTitle',
			name : 'adjustmentLedgerTitle',
			id : 'adjustmentLedgerTitle',
			allowBlank : false,
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '90%'
		});
	var adjustmentLedgerDesc = new Ext.form.HtmlEditor({
			labelAlign : 'top',
			fieldLabel : adjustmentLedgerDescLabel,
			hiddenName : 'adjustmentLedgerDesc',
			name : 'adjustmentLedgerDesc',
			id : 'adjustmentLedgerDesc',
			allowBlank : false,
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '90%',
			height : 55
		});
	var adjustmentLedgerDate = new Ext.form.DateField({
			labelAlign : 'left',
			fieldLabel : adjustmentLedgerDateLabel + '*',
			hiddenName : 'adjustmentLedgerDate',
			name : 'adjustmentLedgerDate',
			id : 'adjustmentLedgerDate',
			allowBlank : false,
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '90%'
		});
	
	var adjustmentLedgerAmount = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : adjustmentLedgerAmountLabel + '*',
			hiddenName : 'adjustmentLedgerAmount',
			name : 'adjustmentLedgerAmount',
			id : 'adjustmentLedgerAmount',
			allowBlank : false,
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '90%',
			decimalPrecision : 2,
			vtype : 'dollar',
			listeners : {
				blur : function () {
					var value = Ext.getCmp('adjustmentLedgerAmount').getValue();
					value = value.replace(",", "");
					value = value.replace(" ", "");
					Ext.getCmp('adjustmentLedgerAmount').setValue(value);
				}
			}
		});
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
	// start adjustmentLedgerDetail request
	var adjustmentLedgerDetailProxy = new Ext.data.HttpProxy({
			url : '../controller/adjustmentLedgerDetailController.php',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	var adjustmentLedgerDetailReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'adjustmentLedgerDetailId'
		});
	var adjustmentLedgerDetailStore = new Ext.data.JsonStore({
			proxy : adjustmentLedgerDetailProxy,
			reader : adjustmentLedgerDetailReader,
			autoLoad : false,
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
			id : 'adjustmentLedgerDetailId',
			fields : [{
					key : 'PRI',
					foreignKey : 'no',
					name : 'adjustmentLedgerDetailId',
					type : 'int'
				}, {
					key : 'MUL',
					foreignKey : 'yes',
					name : 'adjustmentLedgerId',
					type : 'int'
				}, {
					key : 'MUL',
					foreignKey : 'yes',
					name : 'generalLedgerChartOfAccountId',
					type : 'int'
				}, {
					key : 'MUL',
					foreignKey : 'yes',
					name : 'countryId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'transactionMode',
					type : 'string'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'adjustmentLedgerDetailAmount',
					type : 'float'
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
				}
			]
		}); // end adjustmentLedgerDetail request
	var generalLedgerChartOfAccountFilters = new Ext.ux.grid.GridFilters({
			encode : false,
			local : false,
			filters : [{
					type : 'int',
					dataIndex : 'adjustmentLedgerDetailId',
					column : 'adjustmentLedgerDetailId',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, , {
					type : 'list',
					dataIndex : 'adjustmentLedgerId',
					column : 'adjustmentLedgerId',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial',
					labelField : 'adjustmentLedgerDesc',
					store : adjustmentLedgerStore,
					phpMode : true
				}, , {
					type : 'list',
					dataIndex : 'generalLedgerChartOfAccountId',
					column : 'generalLedgerChartOfAccountId',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial',
					labelField : 'generalLedgerChartOfAccountDesc',
					store : generalLedgerChartOfAccountStore,
					phpMode : true
				}, , {
					type : 'list',
					dataIndex : 'countryId',
					column : 'countryId',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial',
					labelField : 'countryCurrencyCodeDesc',
					store : countryStore,
					phpMode : true
				}, {
					type : 'float',
					dataIndex : 'adjustmentLedgerDetailAmount',
					column : 'adjustmentLedgerDetailAmount',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isDefault',
					column : 'isDefault',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isNew',
					column : 'isNew',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isDraft',
					column : 'isDraft',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isUpdate',
					column : 'isUpdate',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isDelete',
					column : 'isDelete',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isActive',
					column : 'isActive',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isApproved',
					column : 'isApproved',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isReview',
					column : 'isReview',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isPost',
					column : 'isPost',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'list',
					dataIndex : 'executeBy',
					column : 'executeBy',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'int',
					dataIndex : 'adjustmentLedgerDetailId',
					column : 'adjustmentLedgerDetailId',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, , {
					type : 'list',
					dataIndex : 'adjustmentLedgerId',
					column : 'adjustmentLedgerId',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial',
					labelField : 'adjustmentLedgerDesc',
					store : adjustmentLedgerStore,
					phpMode : true
				}, , {
					type : 'list',
					dataIndex : 'generalLedgerChartOfAccountId',
					column : 'generalLedgerChartOfAccountId',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial',
					labelField : 'generalLedgerChartOfAccountDesc',
					store : generalLedgerChartOfAccountStore,
					phpMode : true
				}, , {
					type : 'list',
					dataIndex : 'countryId',
					column : 'countryId',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial',
					labelField : 'countryDesc',
					store : countryStore,
					phpMode : true
				}, {
					type : 'float',
					dataIndex : 'adjustmentLedgerDetailAmount',
					column : 'adjustmentLedgerDetailAmount',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isDefault',
					column : 'isDefault',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isNew',
					column : 'isNew',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isDraft',
					column : 'isDraft',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isUpdate',
					column : 'isUpdate',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isDelete',
					column : 'isDelete',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isActive',
					column : 'isActive',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isApproved',
					column : 'isApproved',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isReview',
					column : 'isReview',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isPost',
					column : 'isPost',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}, {
					type : 'list',
					dataIndex : 'executeBy',
					column : 'executeBy',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'adjustmentLedgerDetail',
					database : 'ifinancial'
				}
			]
		});
	var adjustmentLedgerDetailId = new Ext.form.Hidden({
			name : 'adjustmentLedgerDetailId',
			id : 'adjustmentLedgerDetailId'
		});
	var generalLedgerChartOfAccountId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : generalLedgerChartOfAccountIdLabel,
			name : 'stateId',
			hiddenName : 'generalLedgerChartOfAccountId',
			valueField : 'generalLedgerChartOfAccountId',
			hiddenId : 'generalLedgerChartOfAccountId_fake',
			id : 'generalLedgerChartOfAccountId',
			displayField : 'generalLedgerChartOfAccountDesc',
			typeAhead : false,
			triggerAction : 'all',
			store : generalLedgerChartOfAccountStore,
			anchor : '95%',
			selectOnFocus : true,
			mode : 'local',
			allowBlank : false,
			blankText : blankTextLabel,
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				 value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			}
		});
	var transactionModeArrayData = [
		['D', 'DEBIT'],
		['C', 'CREDIT']];
	var transactionModeRecord = Ext.data.Record.create([{
					name : 'mode'
				}, {
					name : 'modFlag'
				}
			]);
	var transactionModeArrayReader = new Ext.data.ArrayReader({},
			transactionModeRecord);
	var transactionModeMemoryProxy = new Ext.data.MemoryProxy(transactionModeArrayData);
	var transactionModeStore = new Ext.data.Store({
			reader : transactionModeArrayReader,
			proxy : transactionModeMemoryProxy
		});
	transactionModeStore.load();
	var transactionMode = new Ext.ux.form.ComboBoxMatch({
			fieldLabel : 'Mod',
			labelAlign : 'left',
			name : 'transactionMode',
			id : 'transactionMode',
			valueField : 'mode',
			displayField : 'modFlag',
			typeAhead : false,
			triggerAction : 'all',
			store : transactionModeStore,
			width : '50',
			selectOnFocus : true,
			mode : 'local',
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			}
		});
	var countryId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : countryIdLabel,
			name : 'stateId',
			hiddenName : 'countryId',
			valueField : 'countryId',
			hiddenId : 'countryId_fake',
			id : 'countryId',
			displayField : 'countryCurrencyCodeDesc',
			typeAhead : false,
			triggerAction : 'all',
			store : countryStore,
			anchor : '95%',
			selectOnFocus : true,
			mode : 'local',
			allowBlank : false,
			blankText : blankTextLabel,
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				 value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			}
		});
	var adjustmentLedgerDetailAmount = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : adjustmentLedgerDetailAmountLabel + '<span style="\'color:" red;\'="">*</span>',
			hiddenName : 'adjustmentLedgerDetailAmount',
			name : 'adjustmentLedgerDetailAmount',
			id : 'adjustmentLedgerDetailAmount',
			allowBlank : false,
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '40%',
			decimalPrecision : 2,
			vtype : 'dollar',
			listeners : {
				blur : function () {
					var value = Ext.getCmp('adjustmentLedgerDetailAmount').getValue();
					value = value.replace(",", "");
					value = value.replace(" ", "");
					Ext.getCmp('adjustmentLedgerDetailAmount').setValue(value);
				}
			}
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
	Ext.util.Format.comboRenderer = function (combo) {
		return function (value) {
			var record = combo.findRecord(combo.valueField || combo.displayField, value);
			if (record) { // remove special character
				res = record.get(combo.displayField); // res = res.replace(/[^a-zA-Z 0-9]+/g, '-');
			} else { // res = ("hmm, not found:" + value);
				res = (value);
			}
			return res;
		};
	};
	var adjustmentLedgerDetailColumnModel = [new Ext.grid.RowNumberer(), {
			dataIndex : 'generalLedgerChartOfAccountId',
			header : generalLedgerChartOfAccountForeignKeyLabel,
			width : 200,
			sortable : true,
			editor : generalLedgerChartOfAccountId,
			renderer : Ext.util.Format.comboRenderer(generalLedgerChartOfAccountId),
			hidden : false,
			jsonType : 'int'
		}, {
			dataIndex : 'countryId',
			header : countryForeignKeyLabel,
			width : 200,
			sortable : true,
			editor : countryId,
			renderer : Ext.util.Format.comboRenderer(countryId),
			hidden : false,
			jsonType : 'int'
		}, {
			dataIndex : 'transactionMode',
			header : transactionModeLabel,
			width : 200,
			sortable : true,
			editor : transactionMode,
			renderer : Ext.util.Format.comboRenderer(transactionMode)
		}, {
			dataIndex : 'adjustmentLedgerDetailAmount',
			header : adjustmentLedgerDetailAmountLabel,
			width : 75,
			sortable : true,
			summaryType : 'sum',
			renderer : function (value) {
				return ' RM ' + Ext.util.Format.number(value, '0,0.00');
			},
			editor : {
				xtype : 'textfield',
				labelAlign : 'left',
				fieldLabel : adjustmentLedgerDetailAmountLabel,
				hiddenName : 'adjustmentLedgerDetailAmount',
				name : 'adjustmentLedgerDetailAmount',
				id : 'adjustmentLedgerDetailAmount',
				blankText : blankTextLabel,
				decimalPrecision : 2,
				vtype : 'dollar',
				anchor : '95%',
				listeners : {
					blur : function () {
						var value = Ext.getCmp('adjustmentLedgerDetailAmount').getValue();
						value = value.replace(",", "");
						value = Ext.util.Format.usMoney(value);
						value = value.replace(" ", "");
						Ext.getCmp('adjustmentLedgerDetailAmount').setValue(value);
					}
				}
			}
		},
		isDefaultGridDetail, isNewGridDetail, isDraftGridDetail, isUpdateGridDetail, isDeleteGridDetail, isActiveGridDetail, isApprovedGridDetail, isReviewGridDetail, isPostGridDetail, {
			dataIndex : 'executeBy',
			header : executeByLabel,
			sortable : true,
			hidden : false,
			renderer : function (value, metaData, record, rowIndex, colIndex, store) {
				return record.data.staffName;
			}
		}, {
			dataIndex : 'executeTime',
			header : executeTimeLabel,
			sortable : true,
			hidden : false,
			renderer : function (value, metaData, record, rowIndex, colIndex, store) {
				return Ext.util.Format.date(value, 'd-m-Y H:i:s');
			}
		}
	];
	var adjustmentLedgerDetailEditor = new Ext.ux.grid.RowEditor({
			saveText : saveButtonLabel,
			cancelText : cancelButtonLabel,
			listeners : {
				cancelEdit : function (rowEditor, changes, record, rowIndex) {
					adjustmentLedgerDetailStore.reload({
						params : {
							adjustmentLedgerId : Ext.getCmp('adjustmentLedgerId').getValue()
						}
					});
				},
				afteredit : function (rowEditor, changes, record, rowIndex) {
					this.save = true;
					var record = this.grid.getStore().getAt(rowIndex);
					if (parseInt(record.get('adjustmentLedgerDetailId')) == 'NaN') {
						method = 'create';
					} else if (record.get('adjustmentLedgerDetailId') == '') {
						method = 'create';
					} else if (record.get('adjustmentLedgerDetailId') == undefined) {
						method = 'create';
					} else if (parseInt(record.get('adjustmentLedgerDetailId')) > 0) {
						method = 'save';
					} else {
						method = 'create';
					}
					Ext.Ajax.request({
						url : '../controller/adjustmentLedgerDetailController.php',
						method : 'POST',
						params : {
							leafId : leafId,
							isAdmin : isAdmin,
							method : method,
							adjustmentLedgerDetailId : record.get('adjustmentLedgerDetailId'),
							adjustmentLedgerId : Ext.getCmp('adjustmentLedgerId').getValue(),
							generalLedgerChartOfAccountId : record.get('generalLedgerChartOfAccountId'),
							transactionMode : record.get('transactionMode'),
							countryId : record.get('countryId'),
							adjustmentLedgerDetailAmount : record.get('adjustmentLedgerDetailAmount')
						},
						success : function (response, options) {
							jsonResponse = Ext.decode(response.responseText);
							if (jsonResponse.success == false) {
								Ext.MessageBox.alert(systemLabel, jsonResponse.message);
							} else {
								adjustmentLedgerDetailStore.reload({
									params : {
										adjustmentLedgerId : Ext.getCmp('adjustmentLedgerId').getValue()
									}
								});
								if (jsonResponse.masterDetail > 0) {
									Ext.getCmp('postButton').disable();
									Ext.MessageBox.alert(systemErrorLabel, "Master Amount and Detail Amount not tally");
								}
								if (jsonResponse.trialBalance > 0) {
									Ext.getCmp('postButton').disable();
									Ext.MessageBox.alert(systemErrorLabel, "Trial Balance no tally");
								}
								if (jsonResponse.tally > 0) {
									Ext.getCmp('postButton').disable();
									Ext.MessageBox.alert(systemErrorLabel, "Total Debit and Credit not Tally");
								}
								if (jsonResponse.tally == 0 && jsonResponse.trialBalance == 0 && jsonResponse.masterDetail == 0) {
									Ext.getCmp('postButton').enable();
								}
							}
						},
						failure : function (response, options) {
							Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + response.statusText);
						}
					});
				}
			}
		});
	var adjustmentLedgerDetailEntity = Ext.data.Record.create([{
					key : 'PRI',
					foreignKey : 'no',
					name : 'adjustmentLedgerDetailId',
					type : 'int'
				}, {
					key : 'MUL',
					foreignKey : 'yes',
					name : 'adjustmentLedgerId',
					type : 'int'
				}, {
					key : 'MUL',
					foreignKey : 'yes',
					name : 'generalLedgerChartOfAccountId',
					type : 'int'
				}, {
					key : 'MUL',
					foreignKey : 'yes',
					name : 'countryId',
					type : 'int'
				}, {
					key : '',
					foreignKey : 'no',
					name : 'adjustmentLedgerDetailAmount',
					type : 'float'
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
				}
			]);
	var adjustmentLedgerDetailFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
	var adjustmentLedgerDetailGrid = new Ext.grid.GridPanel({
			name : 'adjustmentLedgerDetailGrid',
			id : 'adjustmentLedgerDetailGrid',
			border : false,
			store : adjustmentLedgerDetailStore,
			height : 250,
			autoScroll : true,
			columns : adjustmentLedgerDetailColumnModel,
			viewConfig : {
				autoFill : true,
				forceFit : true,
				emptyRow : emptyRowLabel
			},
			layout : 'fit',
			disabled : true,
			plugins : [adjustmentLedgerDetailEditor],
			tbar : {
				items : [{
						xtype : 'button',
						iconCls : 'add',
						id : 'add_record',
						name : 'add_record',
						text : newButtonLabel,
						handler : function () {
							var newRecord = new adjustmentLedgerDetailEntity({
									adjustmentLedgerDetailId : '',
									adjustmentLedgerId : '',
									generalLedgerChartOfAccountId : '',
									countryId : '',
									adjustmentLedgerDetailAmount : '',
									isDefault : '',
									isNew : '',
									isDraft : '',
									isUpdate : '',
									isDelete : '',
									isActive : '',
									isApproved : '',
									isReview : '',
									isPost : '',
									executeBy : '',
									executeTime : ''
								});
							adjustmentLedgerDetailEditor.stopEditing();
							adjustmentLedgerDetailStore.insert(0, newRecord);
							adjustmentLedgerDetailGrid.getSelectionModel().getSelections();
							adjustmentLedgerDetailEditor.startEditing(0);
						}
					}, {
						xtype : 'button',
						text : CheckAllLabel,
						iconCls : 'row-check-sprite-check',
						listeners : {
							'click' : function (button, e) {
								adjustmentLedgerDetailStore.each(function (record, fn, scope) {
									for (var access in adjustmentLedgerDetailFlagArray) {
										record.set(adjustmentLedgerDetailFlagArray[access], true);
									}
								});
							}
						}
					}, {
						text : ClearAllLabel,
						iconCls : 'row-check-sprite-uncheck',
						listeners : {
							'click' : function (button, e) {
								adjustmentLedgerDetailStore.each(function (record, fn, scope) {
									for (var access in adjustmentLedgerDetailFlagArray) {
										record.set(adjustmentLedgerDetailFlagArray[access], false);
									}
								});
							}
						}
					}, {
						xtype : 'button',
						text : saveButtonLabel,
						iconCls : 'bullet_disk',
						listeners : {
							'click' : function (button, e) {
								var url = '../controller/adjustmentLedgerDetailController.php?';
								var sub_url = '';
								var modified = adjustmentLedgerDetailStore.getModifiedRecords();
								for (var i = 0; i < modified.length; i++) {
									var dataChanges = modified[i].getChanges();
									sub_url = sub_url + '&adjustmentLedgerDetailId[]=' + modified[i].get('adjustmentLedgerDetailId');
									if (isAdmin == 1) {
										if (dataChanges.isDefault == true || dataChanges.isDefault == false) {
											sub_url = sub_url + '&isDefault[]=' + modified[i].get('isDefault');
										}
										if (dataChanges.isDraft == true || dataChanges.isDraft == false) {
											sub_url = sub_url + '&isDraft[]=' + modified[i].get('isDraft');
										}
										if (dataChanges.isNew == true || dataChanges.isNew == false) {
											sub_url = sub_url + '&isNew[]=' + modified[i].get('isNew');
										}
										if (dataChanges.isUpdate == true || dataChanges.isUpdate == false) {
											sub_url = sub_url + '&isUpdate[]=' + modified[i].get('isUpdate');
										}
									}
									if (dataChanges.isDelete == true || dataChanges.isDelete == false) {
										sub_url = sub_url + '&isDelete[]=' + modified[i].get('isDelete');
									}
									if (isAdmin == 1) {
										if (dataChanges.isActive == true || dataChanges.isActive == false) {
											ssub_url = sub_url + '&isActive[]=' + modified[i].get('isActive');
										}
										if (dataChanges.isApproved == true || dataChanges.isApproved == false) {
											sub_url = sub_url + '&isApproved[]=' + modified[i].get('isApproved');
										}
										if (dataChanges.isReview == true || dataChanges.isReview == false) {
											sub_url = sub_url + '&isReview[]=' + modified[i].get('isReview');
										}
										if (dataChanges.isPost == true || dataChanges.isPost == false) {
											sub_url = sub_url + '&isPost[]=' + modified[i].get('isPost');
										}
									}
								}
								url = url + sub_url;
								Ext.Ajax.request({
									url : url,
									method : 'GET',
									params : {
										leafId : leafId,
										isAdmin : isAdmin,
										adjustmentLedgerId : Ext.getCmp('adjustmentLedgerId').getValue(),
										method : 'updateStatus'
									},
									success : function (response, options) {
										jsonResponse = Ext.decode(response.responseText);
										if (jsonResponse.success == true) {
											Ext.MessageBox.alert(systemLabel, jsonResponse.message);
											adjustmentLedgerDetailStore.reload({
												params : {
													adjustmentLedgerId : Ext.getCmp('adjustmentLedgerId').getValue()
												}
											});
											if (jsonResponse.trialBalance > 0) {
												Ext.getCmp('postButton').disable(); //  Ext.MessageBox.alert(systemErrorLabel, "Trial Balance no tally");
											}
											if (jsonResponse.tally > 0) {
												Ext.getCmp('postButton').disable(); // Ext.MessageBox.alert(systemErrorLabel, "Total Debit and Credit not Tally");
											}
											if (jsonResponse.tally == 0 && jsonResponse.trialBalance == 0) {
												Ext.getCmp('postButton').enable();
											}
										} else if (jsonResponse.success == false) {
											Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
										}
									},
									failure : function (response, options) {
										Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
									}
								});
							}
						}
					},
					'-', {
						xtype : 'label',
						name : 'trialBalanceStatus',
						text : 'Trial Balance Status : '
					},
					'-', {
						xtype : 'label',
						name : 'tallyStatus',
						text : 'Tally Status : '
					}
				]
			},
			bbar : new Ext.PagingToolbar({
				store : adjustmentLedgerDetailStore,
				pageSize : perPage
			}),
			view : new Ext.ux.grid.BufferView({
				rowHeight : 34,
				scrollDelay : false
			})
		});
	var formPanel = new Ext.form.FormPanel({
			url : '../controller/adjustmentLedgerController.php',
			name : 'formPanel',
			id : 'formPanel',
			method : 'post',
			frame : true,
			title : leafNative,
			border : false,
			width : 600,
			items : [{
					xtype : 'panel',
					items : [{
							xtype : 'fieldset',
							layout : 'form',
							bodyStyle : 'padding:5px',
							border : true,
							frame : true,
							items : [adjustmentLedgerId, adjustmentTypeId, businessPartnerId, invoiceCategoryId,
								invoiceTypeId,
								invoiceLedgerId, {
									layout : 'column',
									border : false,
									items : [{
											columnWidth : .5,
											layout : 'form',
											border : false,
											items : [adjustmentLedgerTitle, adjustmentLedgerDesc, adjustmentLedgerDate, adjustmentLedgerAmount, referenceNo]
										}, {
											columnWidth : .5,
											layout : 'form',
											border : false,
											labelAlign : 'top',
											items : [adjustmentLedgerDesc]
										}
									]
								}
							]
						}
					]
				},
				adjustmentLedgerDetailGrid],
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
			buttons : [{
					text : auditButtonLabel,
					name : 'auditButtonLabel',
					id : 'auditButtonLabel',
					type : 'button',
					iconCls : 'key',
					disabled : auditButtonLabelDisabled,
					handler : function () { // reload the store
						if (auditWindow) {
							adjustmentLedgerStore.reload();
							adjustmentLedgerDetailStore.reload();
							auditWindow.show().center();
						}
					}
				}, {
					text : newButtonLabel,
					name : 'newButton',
					id : 'newButton',
					type : 'button',
					iconCls : 'new',
					handler : function () {
						var method = 'create';
						formPanel.getForm().submit({
							waitMsg : waitMessageLabel,
							params : {
								method : method,
								leafId : leafId,
								isAdmin : isAdmin
							},
							success : function (form, action) {
								if (action.result.success == true) {
									Ext.MessageBox.alert(systemLabel, action.result.message);
									Ext.getCmp('adjustmentLedgerDetailGrid').enable();
									Ext.getCmp('newButton').disable();
									Ext.getCmp('saveButton').enable();
									Ext.getCmp('deleteButton').enable();
									Ext.getCmp('adjustmentLedgerId').setValue(action.result.adjustmentLedgerId);
									adjustmentLedgerStore.reload({
										params : {
											leafId : leafId,
											start : 0,
											limit : perPage
										}
									});
								} else {
									Ext.MessageBox.alert(systemErrorLabel, action.result.message);
								}
							},
							failure : function (form, action) {
								if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
									Ext.Msg.alert(systemErrorLabel, loadFailureLabel);
								} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
									Ext.Msg.alert(systemErrorLabel, clientInvalidLabel);
								} else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
									Ext.Msg.alert(form.response.status + ' ' + form.response.statusText);
								} else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
									Ext.Msg.alert(systemErrorLabel, action.result.message);
								}
							}
						});
					}
				}, {
					text : saveButtonLabel,
					name : 'saveButton',
					id : 'saveButton',
					iconCls : 'bullet_disk',
					disabled : true,
					handler : function () {
						var method = 'save';
						formPanel.getForm().submit({
							waitMsg : waitMessageLabel,
							params : {
								method : method,
								leafId : leafId,
								adjustmentLedgerId : Ext.getCmp('adjustmentLedgerId').getValue()
							},
							success : function (form, action) {
								if (action.result.success == true) {
									Ext.MessageBox.alert(systemLabel, jsonResponse.message);
									Ext.getCmp('adjustmentLedgerDetailGrid').enable();
									Ext.getCmp('newButton').disable();
									Ext.getCmp('saveButton').enable();
									Ext.getCmp('deleteButton').enable();
									adjustmentLedgerStore.reload({
										params : {
											leafId : leafId,
											start : 0,
											limit : perPage
										}
									});
									Ext.getCmp('adjustmentLedgerId').setValue(action.result.adjustmentLedgerId);
								} else {
									Ext.MessageBox.alert(systemErrorLabel, action.result.message);
								}
							},
							failure : function (form, action) {
								if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
									Ext.Msg.alert(systemErrorLabel, loadFailureLabel);
								} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
									Ext.Msg.alert(systemErrorLabel, clientInvalidLabel);
								} else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
									Ext.Msg.alert(form.response.status + ' ' + form.response.statusText);
								} else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
									Ext.Msg.alert(systemErrorLabel, action.result.message);
								}
							}
						});
					}
				}, {
					text : deleteButtonLabel,
					type : 'button',
					name : 'deleteButton',
					id : 'deleteButton',
					iconCls : 'trash',
					disabled : true,
					handler : function () {
						Ext.Msg.show({
							title : deleteRecordTitleMessageLabel,
							msg : deleteRecordMessageLabel,
							icon : Ext.Msg.QUESTION,
							buttons : Ext.Msg.YESNO,
							scope : this,
							fn : function (response) {
								if ('yes' == response) {
									Ext.Ajax.request({
										url : '../controller/adjustmentLedgerController.php',
										params : {
											method : 'delete',
											adjustmentLedgerId : record.data.adjustmentLedgerId,
											leafId : leafId,
											isAdmin : isAdmin
										},
										success : function (response, options) {
											jsonResponse = Ext.decode(response.responseText);
											if (jsonResponse.success == true) {
												Ext.MessageBox.alert(systemLabel, jsonResponse.message);
												adjustmentLedgerStore.reload({
													params : {
														leafId : leafId,
														start : 0,
														limit : perPage
													}
												});
												Ext.getCmp('adjustmentLedgerDetail').disable();
												Ext.getCmp('newButton').disable();
												Ext.getCmp('saveButton').disable();
												Ext.getCmp('nextButton').disable();
												Ext.getCmp('previousButton').disable();
												adjustmentLedgerStore.reload({
													params : {
														leafId : leafId,
														start : 0,
														limit : perPage
													}
												});
											} else {
												Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
											}
										},
										failure : function (response, options) {
											Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + response.statusText);
										}
									});
								}
							}
						});
					}
				}, {
					text : resetButtonLabel,
					type : 'reset',
					name : 'resetButton',
					id : 'resetButton',
					iconCls : 'database_refresh',
					handler : function () {
						Ext.getCmp('newButton').enable();
						Ext.getCmp('saveButton').disable();
						Ext.getCmp('deleteButton').disable();
						Ext.getCmp('postButton').disable();
						Ext.getCmp('adjustmentLedgerDetailGrid').disable();
						adjustmentLedgerDetailGrid.store.removeAll();
						formPanel.getForm().reset();
					}
				}, {
					text : postButtonLabel,
					type : 'button',
					name : 'postButton',
					id : 'postButton',
					iconCls : 'lock',
					disabled : true,
					handler : function () {
						
						Ext.Ajax.request({
							url : '../controller/adjustmentLedgerController.php',
							method : 'POST',
							params : {
								method : 'posting',
								leafId : leafId,
								isAdmin : isAdmin,
								adjustmentLedgerId : Ext.getCmp('adjustmentLedgerId').getValue()
								
							},
							success : function (response, options) {
								jsonResponse = Ext.decode(response.responseText);
								if (jsonResponse.success == false) {
									Ext.MessageBox.alert(systemLabel, jsonResponse.message);
								} else {
									Ext.MessageBox.alert(systemLabel, jsonResponse.message);
									Ext.getCmp('newButton').disable();
									Ext.getCmp('saveButton').disable();
									Ext.getCmp('deleteButton').disable();
									Ext.getCmp('postButton').disable();
									Ext.getCmp('adjustmentLedgerDetailGrid').disable();
									formPanel.getForm().reset();
									adjustmentLedgerDetailGrid.store.removeAll();
									adjustmentLedgerStore.reload({
										params : {
											leafId : leafId,
											start : 0,
											limit : perPage
										}
									});
								}
							},
							failure : function (response, options) {
								Ext.MessageBox.alert(systemLabel, escape(response.status) + ':' + escape(response.statusText));
							}
						});
						formPanel.getForm().reset();
					}
				}, {
					text : gridButtonLabel,
					type : 'button',
					name : 'gridButton',
					id : 'gridButton',
					iconCls : 'table',
					handler : function () {
						formPanel.getForm().reset();
						viewPort.items.get(0).expand();
					}
				}, {
					text : firstButtonLabel,
					name : 'firstButton',
					id : 'firstButton',
					type : 'button',
					iconCls : 'resultset_first',
					handler : function () {
						Ext.getCmp('newButton').disable();
						if (Ext.getCmp('firstRecord').getValue() == '') {
							Ext.Ajax.request({
								url : '../controller/adjustmentLedgerController.php',
								method : 'GET',
								params : {
									method : 'dataNavigationRequest',
									leafId : leafId,
									dataNavigation : 'firstRecord'
								},
								success : function (response, options) {
									jsonResponse = Ext.decode(response.responseText);
									if (jsonResponse.success == true) {
										Ext.getCmp('firstRecord').setValue(jsonResponse.firstRecord);
										formPanel.form.load({
											url : '../controller/adjustmentLedgerController.php',
											method : 'POST',
											waitTitle : systemLabel,
											waitMsg : waitMessageLabel,
											params : {
												method : 'read',
												adjustmentLedgerId : Ext.getCmp('firstRecord').getValue(),
												leafId : leafId,
												isAdmin : isAdmin
											},
											success : function (form, action) {
												if (action.result.success == true) {
													if (action.result.nextRecord == 0) {
														Ext.getCmp('nextButton').disable();
													} else {
														Ext.getCmp('nextButton').enable();
													}
													Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
													Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
													Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
													Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
													Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
													Ext.getCmp('previousButton').disable();
													adjustmentLedgerDetailStore.load({
														params : {
															leafId : leafId,
															isAdmin : isAdmin,
															adjustmentLedgerId : action.result.data.adjustmentLedgerId
														}
													});
													adjustmentLedgerDetailGrid.enable();
												} else {
													Ext.MessageBox.alert(systemErrorLabel, action.result.message);
												}
											},
											failure : function (form, action) {
												Ext.MessageBox.alert(systemErrorLabel, action.result.message);
											}
										});
									} else {
										Ext.MessageBox.alert(systemLabel, jsonResponse.message);
									}
								},
								failure : function (response, options) {
									Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
								}
							});
						} else {
							formPanel.form.load({
								url : '../controller/adjustmentLedgerController.php',
								method : 'POST',
								waitTitle : systemLabel,
								waitMsg : waitMessageLabel,
								params : {
									method : 'read',
									adjustmentLedgerId : Ext.getCmp('firstRecord').getValue(),
									leafId : leafId,
									isAdmin : isAdmin
								},
								success : function (form, action) {
									if (action.result.success == true) {
										if (action.result.nextRecord == 0) {
											Ext.getCmp('nextButton').disable();
										} else {
											Ext.getCmp('nextButton').enable();
										}
										Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
										Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
										Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
										Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
										Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
										Ext.getCmp('previousButton').disable();
										adjustmentLedgerDetailStore.load({
											params : {
												leafId : leafId,
												isAdmin : isAdmin,
												adjustmentLedgerId : action.result.data.adjustmentLedgerId
											}
										});
										adjustmentLedgerDetailGrid.enable();
									} else {
										Ext.MessageBox.alert(systemErrorLabel, action.result.message);
									}
								},
								failure : function (form, action) {
									Ext.MessageBox.alert(systemErrorLabel, action.result.message);
								}
							});
						}
					}
				}, {
					text : previousButtonLabel,
					name : 'previousButton',
					id : 'previousButton',
					type : 'button',
					iconCls : 'resultset_previous',
					disabled : true,
					handler : function () {
						Ext.getCmp('newButton').disable();
						if (Ext.getCmp('previousRecord').getValue() == '' || Ext.getCmp('previousRecord').getValue() == undefined) {
							Ext.MessageBox.alert(systemErrorLabel, chooseRecordLabel);
						}
						if (Ext.getCmp('firstRecord').getValue() >= 1) {
							formPanel.form.load({
								url : '../controller/adjustmentLedgerController.php',
								method : 'POST',
								waitTitle : systemLabel,
								waitMsg : waitMessageLabel,
								params : {
									method : 'read',
									adjustmentLedgerId : Ext.getCmp('previousRecord').getValue(),
									leafId : leafId,
									isAdmin : isAdmin
								},
								success : function (form, action) {
									if (action.result.success == true) {
										Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
										Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
										Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
										Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
										Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
										adjustmentLedgerDetailStore.load({
											params : {
												leafId : leafId,
												isAdmin : isAdmin,
												adjustmentLedgerId : action.result.data.adjustmentLedgerId
											}
										});
										if (Ext.getCmp('previousRecord').getValue() == 0) {
											Ext.getCmp('previousButton').disable();
										}
										adjustmentLedgerDetailGrid.enable();
									} else {
										Ext.MessageBox.alert(systemErrorLabel, action.result.message);
									}
								},
								failure : function (form, action) {
									Ext.MessageBox.alert(systemErrorLabel, action.result.message);
								}
							});
						} else {
							Ext.MessageBox.alert(systemErrorLabel, recordNotFoundLabel);
						}
					}
				}, {
					text : nextButtonLabel,
					name : 'nextButton',
					id : 'nextButton',
					type : 'button',
					disabled : true,
					iconCls : 'resultset_next',
					handler : function () {
						Ext.getCmp('newButton').disable();
						if (Ext.getCmp('nextRecord').getValue() == '' || Ext.getCmp('nextRecord').getValue() == undefined) {
							Ext.MessageBox.alert(systemErrorLabel, chooseRecordLabel);
						}
						if (Ext.getCmp('nextRecord').getValue() <= Ext.getCmp('lastRecord').getValue()) {
							formPanel.form.load({
								url : '../controller/adjustmentLedgerController.php',
								method : 'POST',
								waitTitle : systemLabel,
								waitMsg : waitMessageLabel,
								params : {
									method : 'read',
									adjustmentLedgerId : Ext.getCmp('nextRecord').getValue(),
									leafId : leafId,
									isAdmin : isAdmin
								},
								success : function (form, action) {
									if (action.result.success == true) {
										Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
										Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
										Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
										Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
										Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
										adjustmentLedgerDetailStore.load({
											params : {
												leafId : leafId,
												isAdmin : isAdmin,
												adjustmentLedgerId : action.result.data.adjustmentLedgerId
											}
										});
										if (Ext.getCmp('nextRecord').getValue() > Ext.getCmp('lastRecord').getValue()) {
											Ext.getCmp('nextButton').disable();
										}
										if (Ext.getCmp('nextRecord').getValue() == 0) {
											Ext.getCmp('nextButton').disable();
										}
										Ext.getCmp('previousButton').enable();
										adjustmentLedgerDetailGrid.enable();
									} else {
										Ext.MessageBox.alert(systemErrorLabel, action.result.message);
									}
								},
								failure : function (form, action) {
									Ext.MessageBox.alert(systemErrorLabel, action.result.message);
								}
							});
						} else {
							Ext.MessageBox.alert(systemErrorLabel, recordNotFoundLabel);
						}
					}
				}, {
					text : endButtonLabel,
					name : 'endButton',
					id : 'endButton',
					type : 'button',
					iconCls : 'resultset_last',
					handler : function () {
						Ext.getCmp('newButton').disable();
						if (Ext.getCmp('lastRecord').getValue() == '' || Ext.getCmp('lastRecord').getValue() == undefined) {
							Ext.Ajax.request({
								url : '../controller/adjustmentLedgerController.php',
								method : 'GET',
								params : {
									method : 'dataNavigationRequest',
									leafId : leafId,
									dataNavigation : 'lastRecord'
								},
								success : function (response, options) {
									jsonResponse = Ext.decode(response.responseText);
									if (jsonResponse.success == true) {
										Ext.getCmp('lastRecord').setValue(jsonResponse.lastRecord);
										formPanel.form.load({
											url : '../controller/adjustmentLedgerController.php',
											method : 'POST',
											waitTitle : systemLabel,
											waitMsg : waitMessageLabel,
											params : {
												method : 'read',
												adjustmentLedgerId : Ext.getCmp('lastRecord').getValue(),
												leafId : leafId,
												isAdmin : isAdmin
											},
											success : function (form, action) {
												if (action.result.success == true) {
													if (action.result.nextRecord == 0) {
														Ext.getCmp('previousButton').disable();
													} else {
														Ext.getCmp('previousButton').enable();
													}
													Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
													Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
													Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
													Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
													Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
													adjustmentLedgerDetailStore.load({
														params : {
															leafId : leafId,
															isAdmin : isAdmin,
															adjustmentLedgerId : action.result.data.adjustmentLedgerId
														}
													});
													Ext.getCmp('nextButton').disable();
													Ext.getCmp('previousButton').enable();
													adjustmentLedgerDetailGrid.enable();
												} else {
													Ext.MessageBox.alert(systemErrorLabel, action.result.message);
												}
											},
											failure : function (form, action) {
												Ext.MessageBox.alert(systemErrorLabel, action.result.message);
											}
										});
									} else {
										Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
									}
								},
								failure : function (response, options) {
									Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
								}
							});
						}
						if (Ext.getCmp('adjustmentLedgerId').getValue() <= Ext.getCmp('lastRecord').getValue()) {
							formPanel.form.load({
								url : '../controller/adjustmentLedgerController.php',
								method : 'POST',
								waitTitle : systemLabel,
								waitMsg : waitMessageLabel,
								params : {
									method : 'read',
									adjustmentLedgerId : Ext.getCmp('lastRecord').getValue(),
									leafId : leafId,
									isAdmin : isAdmin
								},
								success : function (form, action) {
									if (action.result.success == true) {
										if (action.result.nextRecord == 0) {
											Ext.getCmp('previousButton').disable();
										} else {
											Ext.getCmp('previousButton').enable();
										}
										Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
										Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
										Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
										Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
										Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
										adjustmentLedgerDetailStore.load({
											params : {
												leafId : leafId,
												isAdmin : isAdmin,
												adjustmentLedgerId : action.result.data.adjustmentLedgerId
											}
										});
										Ext.getCmp('nextButton').disable();
										Ext.getCmp('previousButton').enable();
										adjustmentLedgerDetailGrid.enable();
									} else {
										Ext.MessageBox.alert(systemErrorLabel, action.result.message);
									}
								},
								failure : function (form, action) {
									Ext.MessageBox.alert(systemErrorLabel, action.result.message);
								}
							});
						} else {
							Ext.MessageBox.alert(systemErrorLabel, recordNotFoundLabel);
						}
					}
				}
			]
		});
	var viewPort = new Ext.Viewport({
			name : 'viewport',
			id : 'viewport',
			region : 'center',
			layout : 'accordion',
			layoutConfig : { // layout-specific configs go here
				titleCollapse : true,
				animate : false,
				activeOnTop : true
			},
			items : [gridPanel, formPanel]
		});
});
