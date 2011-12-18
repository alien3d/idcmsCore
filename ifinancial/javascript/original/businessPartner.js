Ext.onReady(function () {
	Ext.QuickTips.init();
	Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';
	Ext.form.Field.prototype.msgTarget = 'under';
	Ext.Ajax.timeout = 95000;
	var perPage = 15;
	var encode = false;
	var local = false;
	var jsonResponse;
	var duplicate = 0;
	// common Proxy,Reader,Store,Filter,Grid
	// start Staff Request
	var staffByProxy = new Ext.data.HttpProxy({
			url : '../controller/businessPartnerController.php?',
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
				emptyText : emptyTextLabel
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
	// popup  window for normal log and advance log
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
	// start Business Partner Category
	var businessPartnerCategoryProxy = new Ext.data.HttpProxy({
			url : '../controller/businessPartnerCategoryController.php?',
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
	var businessPartnerCategoryReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'businessPartnerCategoryId'
		});
	var businessPartnerCategoryStore = new Ext.data.JsonStore({
			proxy : businessPartnerCategoryProxy,
			reader : businessPartnerCategoryReader,
			autoLoad : false,
			autoDestroy : true,
			pruneModifiedRecords : true,
			baseParams : {
				method : 'read',
				field : 'businessPartnerCategoryId',
				leafId : leafId
			},
			root : 'staff',
			id : 'businessPartnerCategoryId',
			fields : [{
					name : 'businessPartnerCategoryId',
					type : 'int'
				}, {
					name : 'businessPartnerCategoryDesc',
					type : 'string'
				}
			]
		}); // end Business Partner Category Request
	// end additional Proxy ,Reader,Store,Filter,Grid
	// start application Proxy ,Reader,Store,Filter,Grid
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
	var businessPartnerFilters = new Ext.ux.grid.GridFilters({
			encode : false,
			local : false,
			filters : [{
					type : 'int',
					dataIndex : 'businessPartnerId',
					column : 'businessPartnerId',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerCompany',
					column : 'businessPartnerCompany',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerLastName',
					column : 'businessPartnerLastName',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerFirstName',
					column : 'businessPartnerFirstName',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerEmail',
					column : 'businessPartnerEmail',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerJobTitle',
					column : 'businessPartnerJobTitle',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerBusinessPhone',
					column : 'businessPartnerBusinessPhone',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerHomePhone',
					column : 'businessPartnerHomePhone',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerMobilePhone',
					column : 'businessPartnerMobilePhone',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerFaxNum',
					column : 'businessPartnerFaxNum',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerAddress',
					column : 'businessPartnerAddress',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerCity',
					column : 'businessPartnerCity',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerState',
					column : 'businessPartnerState',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerPostCode',
					column : 'businessPartnerPostCode',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerCountry',
					column : 'businessPartnerCountry',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerWebPage',
					column : 'businessPartnerWebPage',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerNotes',
					column : 'businessPartnerNotes',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'string',
					dataIndex : 'businessPartnerAttachments',
					column : 'businessPartnerAttachments',
					table : 'businessPartner',
					database : 'ifinancial'
				}, , {
					type : 'list',
					dataIndex : 'businessPartnerCategoryId',
					column : 'businessPartnerCategoryId',
					table : 'businessPartner',
					database : 'ifinancial',
					labelField : 'businessPartnerCategoryDesc',
					store : businessPartnerCategoryStore,
					phpMode : true
				}, {
					type : 'boolean',
					dataIndex : 'isDefault',
					column : 'isDefault',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isNew',
					column : 'isNew',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isDraft',
					column : 'isDraft',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isUpdate',
					column : 'isUpdate',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isDelete',
					column : 'isDelete',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isActive',
					column : 'isActive',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isApproved',
					column : 'isApproved',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isReview',
					column : 'isReview',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'boolean',
					dataIndex : 'isPost',
					column : 'isPost',
					table : 'businessPartner',
					database : 'ifinancial'
				}, {
					type : 'list',
					dataIndex : 'executeBy',
					column : 'executeBy',
					table : 'businessPartner',
					database : 'ifinancial',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'businessPartner',
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
			hidden : isActiveHidden
		});
	var isPostGrid = new Ext.ux.grid.CheckColumn({
			header : 'Post',
			dataIndex : 'isPost',
			hidden : isPostHidden
		});
	var businessPartnerColumnModel = [new Ext.grid.RowNumberer(), {
			dataIndex : 'businessPartnerId',
			header : businessPartnerIdLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerCompany',
			header : businessPartnerCompanyLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerLastName',
			header : businessPartnerLastNameLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerFirstName',
			header : businessPartnerFirstNameLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerEmail',
			header : businessPartnerEmailLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerJobTitle',
			header : businessPartnerJobTitleLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerBusinessPhone',
			header : businessPartnerBusinessPhoneLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerHomePhone',
			header : businessPartnerHomePhoneLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerMobilePhone',
			header : businessPartnerMobilePhoneLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerFaxNum',
			header : businessPartnerFaxNumLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerAddress',
			header : businessPartnerAddressLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerCity',
			header : businessPartnerCityLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerState',
			header : businessPartnerStateLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerPostCode',
			header : businessPartnerPostCodeLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerCountry',
			header : businessPartnerCountryLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerWebPage',
			header : businessPartnerWebPageLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerNotes',
			header : businessPartnerNotesLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerAttachments',
			header : businessPartnerAttachmentsLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'businessPartnerCategoryId',
			header : businessPartnerCategoryIdLabel,
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
	var businessPartnerFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
	var businessPartnerGrid = new Ext.grid.GridPanel({
			name : 'businessPartnerGrid',
			id : 'businessPartnerGrid',
			border : false,
			store : businessPartnerStore,
			autoHeight : false,
			height : 400,
			columns : businessPartnerColumnModel,
			plugins : [businessPartnerFilters],
			selModel : new Ext.grid.RowSelectionModel({
				singleSelect : true
			}),
			viewConfig : {
				emptyText : emptyRowLabel
			},
			iconCls : 'application_view_detail',
			listeners : {
				'rowclick' : function (object, rowIndex, e) {
					var record = businessPartnerStore.getAt(rowIndex);
					formPanel.getForm().reset();
					formPanel.form.load({
						url : '../controller/businessPartnerController.php',
						method : 'POST',
						waitTitle : systemLabel,
						waitMsg : waitMessageLabel,
						params : {
							method : 'read',
							mode : 'update',
							businessPartnerId : record.data.businessPartnerId,
							leafId : leafId,
							isAdmin : isAdmin
						},
						success : function (form, action) {
							viewPort.items.get(1).expand();
						},
						failure : function (form, action) {
							Ext.MessageBox.alert(systemErrorLabel, action.result.message);
						}
					});
					
					Ext.getCmp('newButton').disable();
					Ext.getCmp('saveButton').enable();
					Ext.getCmp('deleteButton').enable();
				}
			},
			tbar : {
				items : [{
					xtype:'button',
					text: ' ',
					tooltip:excelToolbarLabel,
					iconCls : 'page_excel',
					id : 'page_excel',
					
					handler : function () {
						Ext.Ajax.request({
							url : '../controller/businessPartnerController.php',
							method : 'GET',
							params : {
								method : 'report',
								mode : 'excel',
								limit : perPage,
								leafId : leafId
							},
							success : function (response, options) {
								jsonResponse = Ext.decode(response.responseText);
								if (jsonResponse.success == true) {
									window.open('../../basic/document/excel/' + jsonResponse.filename);
								} else {
									Ext.MessageBox.alert(successLabel, jsonResponse.message);
								}
							},
							failure : function (response, options) {
								Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
							}
						});
					}
				},'-',{
					xtype:'button',
					text : '',
					tooltip:addToolbarLabel,
					iconCls : 'add',
					id : 'pageCreate',
					
					handler : function (button,e) {
						viewPort.items.get(1).expand();
					}},'-',{
						text:' ',
						tooltip:CheckAllLabel,
						iconCls : 'row-check-sprite-check',
						listeners : {
							'click' : function (button, e) {
								businessPartnerStore.each(function (record, fn, scope) {
									for (var access in businessPartnerFlagArray) {
										record.set(businessPartnerFlagArray[access], true);
									}
								});
							}
						}
					}, '-',{
						text:' ',
						tooltip:ClearAllLabel,
						xtype : 'button',
						iconCls : 'row-check-sprite-uncheck',
						listeners : {
							'click' : function (button, e) {
								businessPartnerStore.each(function (record, fn, scope) {
									for (var access in businessPartnerFlagArray) {
										record.set(businessPartnerFlagArray[access], false);
									}
								});
							}
						}
					},'-', {
						xtype : 'button',
						tooltip : saveButtonLabel,
						iconCls : 'bullet_disk',
						listeners : {
							'click' : function (button, e) {
								var url = '../controller/businessPartnerController.php?';
								var sub_url = '';
								var modified = businessPartnerStore.getModifiedRecords();
								for (var i = 0; i < modified.length; i++) {
									var dataChanges = modified[i].getChanges();
									sub_url = sub_url + '&businessPartnerId[]=' + modified[i].get('businessPartnerId');
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
											businessPartnerStore.reload();
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
					},'-',{ xtype:'button', text:'A', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'A' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'B', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'B' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'C', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'C' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'D', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'D' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'E', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'E' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'F', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'F' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'G', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'G' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'H', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'H' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'I', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'I' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'J', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'J' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'K', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'K' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'L', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'L' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'M', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'M' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'N', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'N' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'O', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'O' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'P', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'P' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'Q', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'Q' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'R', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'R' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'S', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'S' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'T', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'T' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'U', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'U' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'V', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'V' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'W', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'W' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'X', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'X' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'Y', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'Y' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-',

{ xtype:'button', text:'Z', handler: function (button,e) { Ext.Ajax.request({ url :'../controller/businessPartnerController.php', method :'GET', params :{ leafId:leafId, isAdmin :isAdmin, method:'character', filter : 'Z' }, success : function (response, options) { jsonResponse = Ext.decode(response.responseText); if (jsonResponse.success == true) { Ext.MessageBox.alert(systemLabel, jsonResponse.message); businessPartnerStore.reload(); } else if (jsonResponse.success == false) { Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message); } }, failure : function (response, options) { Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText)); } }); } },'-'


				,'->', new Ext.ux.form.SearchField({
					store : businessPartnerStore,
					width : 200
				})]
			},
			bbar : new Ext.PagingToolbar({
				store : businessPartnerStore,
				pageSize : perPage,
				plugins : [businessPartnerFilters]
			})
		});
	var gridPanel = new Ext.Panel({
			title : leafNative,
			iconCls : 'application_view_detail',
			layout : 'fit',		
			items : [businessPartnerGrid]
		});
	// form entry
	var businessPartnerId = new Ext.form.NumberField({
			labelAlign : 'left',
			fieldLabel : businessPartnerIdLabel ,
			hiddenName : 'businessPartnerId',
			name : 'businessPartnerId',
			id : 'businessPartnerId',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerCompany = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerCompanyLabel ,
			hiddenName : 'businessPartnerCompany',
			name : 'businessPartnerCompany',
			id : 'businessPartnerCompany',
			allowBlank : false,
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerLastName = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerLastNameLabel ,
			hiddenName : 'businessPartnerLastName',
			name : 'businessPartnerLastName',
			id : 'businessPartnerLastName',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerFirstName = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerFirstNameLabel ,
			hiddenName : 'businessPartnerFirstName',
			name : 'businessPartnerFirstName',
			id : 'businessPartnerFirstName',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerEmail = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerEmailLabel ,
			hiddenName : 'businessPartnerEmail',
			name : 'businessPartnerEmail',
			id : 'businessPartnerEmail',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerJobTitle = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerJobTitleLabel ,
			hiddenName : 'businessPartnerJobTitle',
			name : 'businessPartnerJobTitle',
			id : 'businessPartnerJobTitle',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerBusinessPhone = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerBusinessPhoneLabel ,
			hiddenName : 'businessPartnerBusinessPhone',
			name : 'businessPartnerBusinessPhone',
			id : 'businessPartnerBusinessPhone',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerHomePhone = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerHomePhoneLabel ,
			hiddenName : 'businessPartnerHomePhone',
			name : 'businessPartnerHomePhone',
			id : 'businessPartnerHomePhone',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerMobilePhone = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerMobilePhoneLabel ,
			hiddenName : 'businessPartnerMobilePhone',
			name : 'businessPartnerMobilePhone',
			id : 'businessPartnerMobilePhone',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerFaxNum = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerFaxNumLabel ,
			hiddenName : 'businessPartnerFaxNum',
			name : 'businessPartnerFaxNum',
			id : 'businessPartnerFaxNum',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerAddress = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerAddressLabel ,
			hiddenName : 'businessPartnerAddress',
			name : 'businessPartnerAddress',
			id : 'businessPartnerAddress',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerCity = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerCityLabel ,
			hiddenName : 'businessPartnerCity',
			name : 'businessPartnerCity',
			id : 'businessPartnerCity',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerState = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerStateLabel ,
			hiddenName : 'businessPartnerState',
			name : 'businessPartnerState',
			id : 'businessPartnerState',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerPostCode = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerPostCodeLabel ,
			hiddenName : 'businessPartnerPostCode',
			name : 'businessPartnerPostCode',
			id : 'businessPartnerPostCode',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerCountry = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerCountryLabel ,
			hiddenName : 'businessPartnerCountry',
			name : 'businessPartnerCountry',
			id : 'businessPartnerCountry',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerWebPage = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerWebPageLabel ,
			hiddenName : 'businessPartnerWebPage',
			name : 'businessPartnerWebPage',
			id : 'businessPartnerWebPage',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerNotes = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerNotesLabel ,
			hiddenName : 'businessPartnerNotes',
			name : 'businessPartnerNotes',
			id : 'businessPartnerNotes',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerAttachments = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : businessPartnerAttachmentsLabel ,
			hiddenName : 'businessPartnerAttachments',
			name : 'businessPartnerAttachments',
			id : 'businessPartnerAttachments',
			
			blankText : blankTextLabel,
			style : {
				textTransform : 'uppercase'
			},
			anchor : '100%'
		});
	
	var businessPartnerCategoryId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : businessPartnerCategoryIdLabel,
			name : 'stateId',
			hiddenName : 'businessPartnerCategoryId',
			valueField : 'businessPartnerCategoryId',
			hiddenId : 'businessPartnerCategoryId_fake',
			id : 'businessPartnerCategoryId',
			displayField : 'businessPartnerCategoryDesc',
			typeAhead : false,
			triggerAction : 'all',
			store : businessPartnerCategoryStore,
			anchor : '100%',
			selectOnFocus : true,
			mode : 'local',
			
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
	
	var businessPartnerId = new Ext.form.Hidden({
			name : 'businessPartnerId',
			id : 'businessPartnerId'
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
	var formPanel = new Ext.form.FormPanel({
			url : '../controller/businessPartnerController.php',
			name : 'formPanel',
			id : 'formPanel',
			method : 'post',
			frame : true,
			title : leafNative,
			border : false,
			bodyStyle : 'padding:1px',
		
			items : [ {
					xtype : 'fieldset',
					title : 'General ',
					layout : 'column',
					bodyStyle : 'padding:1px',
					items : [businessPartnerId, 
					         
					         {
							columnWidth : 0.5,
							layout : 'form',
							border : false,
							bodyStyle : 'padding:10px',
							items : [businessPartnerCompany, businessPartnerCategoryId,{
								xtype:'fieldset',
								title:'Primary Contact',
								items :[
businessPartnerFirstName,
businessPartnerLastName,
businessPartnerJobTitle
							    ]
								
							},{
								xtype:'fieldset',
								title:'Phone Number',
								items :[
								        businessPartnerHomePhone,
businessPartnerBusinessPhone,
businessPartnerMobilePhone,
businessPartnerFaxNum
							    ]
								
							} ]
						}, {
							columnWidth : 0.5,
							layout : 'form',
							border : false,
							items : [ {
								xtype:'fieldset',
								title:'Address',
								items :[
								        businessPartnerAddress, 
								        businessPartnerCity,
								        businessPartnerState, 
								        businessPartnerPostCode, 
								        businessPartnerCountry
							    ]
								
							},{
								xtype:'fieldset',
								title:'Internet',
								items :[
								        	businessPartnerEmail,   
								        	businessPartnerWebPage
							    ]
								
							},businessPartnerNotes ]
						}
					]
				}
			],
			buttonVAlign : 'top',
			buttonAlign : 'left',
			iconCls : 'application_form',
			
			buttons : [{
					text : auditButtonLabel,
					name : 'auditButtonLabel',
					id : 'auditButtonLabel',
					type : 'button',
					iconCls : 'key',
					disabled : auditButtonLabelDisabled,
					handler : function () {
						if (auditWindow) {
							businessPartnerStore.reload();
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
						var id = Ext.getCmp('businessPartnerId').getValue();
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
									Ext.getCmp('newButton').disable();
									Ext.getCmp('saveButton').enable();
									Ext.getCmp('deleteButton').enable();
									businessPartnerStore.reload({
										params : {
											leafId : leafId,
											start : 0,
											limit : perPage
										}
									});
									Ext.getCmp('businessPartnerId').setValue(action.result.businessPartnerId);
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
						Ext.getCmp('newButton').disable();
						var id = Ext.getCmp('businessPartnerId').getValue();
						var method = 'save';
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
									Ext.getCmp('newButton').disable();
									Ext.getCmp('saveButton').enable();
									Ext.getCmp('deleteButton').enable();
									businessPartnerStore.reload({
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
					text : deleteButtonLabel,
					type : 'button',
					name : 'deleteButton',
					id : 'deleteButton',
					iconCls : 'trash',
					disabled : true,
					handler : function () {
						Ext.getCmp('newButton').disable();
						Ext.Msg.show({
							title : deleteRecordTitleMessageLabel,
							msg : deleteRecordMessageLabel,
							icon : Ext.Msg.QUESTION,
							buttons : Ext.Msg.YESNO,
							scope : this,
							fn : function (response) {
								if ('yes' == response) {
									Ext.Ajax.request({
										url : '../controller/businessPartnerController.php',
										params : {
											method : 'delete',
											businessPartnerId : Ext.getCmp('businessPartnerId').getValue(),
											leafId : leafId,
											isAdmin : isAdmin
										},
										success : function (response, options) {
											jsonResponse = Ext.decode(response.responseText);
											if (jsonResponse.success == true) {
												Ext.MessageBox.alert(systemLabel, jsonResponse.message);
												businessPartnerStore.reload({
													params : {
														leafId : leafId,
														start : 0,
														limit : perPage
													}
												});
												Ext.getCmp('saveButton').disable();
												Ext.getCmp('deleteButton').disable();
												Ext.getCmp('nextButton').disable();
												Ext.getCmp('previousButton').disable();
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
						Ext.getCmp('newButton').disable();
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
								url : '../controller/businessPartnerController.php',
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
											url : '../controller/businessPartnerController.php',
											method : 'POST',
											waitTitle : systemLabel,
											waitMsg : waitMessageLabel,
											params : {
												method : 'read',
												businessPartnerId : Ext.getCmp('firstRecord').getValue(),
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
								url : '../controller/businessPartnerController.php',
								method : 'POST',
								waitTitle : systemLabel,
								waitMsg : waitMessageLabel,
								params : {
									method : 'read',
									businessPartnerId : Ext.getCmp('firstRecord').getValue(),
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
								url : '../controller/businessPartnerController.php',
								method : 'POST',
								waitTitle : systemLabel,
								waitMsg : waitMessageLabel,
								params : {
									method : 'read',
									businessPartnerId : Ext.getCmp('previousRecord').getValue(),
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
										if (Ext.getCmp('previousRecord').getValue() == 0) {
											Ext.getCmp('previousButton').disable();
										}
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
								url : '../controller/businessPartnerController.php',
								method : 'POST',
								waitTitle : systemLabel,
								waitMsg : waitMessageLabel,
								params : {
									method : 'read',
									businessPartnerId : Ext.getCmp('nextRecord').getValue(),
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
										if (Ext.getCmp('nextRecord').getValue() > Ext.getCmp('lastRecord').getValue()) {
											Ext.getCmp('nextButton').disable();
										}
										if (Ext.getCmp('nextRecord').getValue() == 0) {
											Ext.getCmp('nextButton').disable();
										}
										Ext.getCmp('previousButton').enable();
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
								url : '../controller/businessPartnerController.php',
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
											url : '../controller/businessPartnerController.php',
											method : 'POST',
											waitTitle : systemLabel,
											waitMsg : waitMessageLabel,
											params : {
												method : 'read',
												businessPartnerId : Ext.getCmp('lastRecord').getValue(),
												leafId : leafId,
												isAdmin : isAdmin
											},
											success : function (form, action) {
												if (action.result.success == true) {
													if (action.result.previousRecord == 0) {
														Ext.getCmp('previousButton').disable();
													} else {
														Ext.getCmp('previousButton').enable();
													}
													Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
													Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
													Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
													Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
													Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
													Ext.getCmp('nextButton').disable();
													Ext.getCmp('previousButton').enable();
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
						if (Ext.getCmp('businessPartnerId').getValue() <= Ext.getCmp('lastRecord').getValue()) {
							formPanel.form.load({
								url : '../controller/businessPartnerController.php',
								method : 'POST',
								waitTitle : systemLabel,
								waitMsg : waitMessageLabel,
								params : {
									method : 'read',
									businessPartnerId : Ext.getCmp('lastRecord').getValue(),
									leafId : leafId,
									isAdmin : isAdmin
								},
								success : function (form, action) {
									if (action.result.success == true) {
										if (action.result.previousRecord == 0) {
											Ext.getCmp('previousButton').disable();
										} else {
											Ext.getCmp('previousButton').enable();
										}
										Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
										Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
										Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
										Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
										Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
										Ext.getCmp('nextButton').disable();
										Ext.getCmp('previousButton').enable();
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
			id : 'viewport',
			region : 'center',
			layout : 'accordion',
			layoutConfig : {
				titleCollapse : true,
				animate : false,
				activeOnTop : true
			},
			items : [gridPanel, formPanel]
		});
});
