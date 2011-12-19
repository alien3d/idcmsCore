Ext.onReady(function() {
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
        url: '../controller/refundLedgerController.php?',
        method: 'GET',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var staffByReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'staffId'
    });
    var staffByStore = new Ext.data.JsonStore({
        proxy: staffByProxy,
        reader: staffByReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: 'read',
            field: 'staffId',
            leafId: leafId
        },
        root: 'staff',
        id: 'staffId',
        fields: [{
            name: 'staffId',
            type: 'int'
        },
        {
            name: 'staffName',
            type: 'string'
        }]
    }); // end Staff Request
    // start log Request
    var logProxy = new Ext.data.HttpProxy({
        url: '../../security/controller/logController.php?',
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var logReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'logId'
    });
    var logStore = new Ext.data.JsonStore({
        proxy: logProxy,
        reader: logReader,
        autoLoad: false,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: 'read',
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            limit: perPage,
            perPage: perPage
        },
        root: 'data',
        fields: [{
            name: 'logId',
            type: 'int'
        },
        {
            name: 'leafId',
            type: 'int'
        },
        {
            name: 'operation',
            type: 'string'
        },
        {
            name: 'sql',
            type: 'string'
        },
        {
            name: 'date',
            type: 'date',
            dateFormat: 'Y-m-d'
        },
        {
            name: 'staffId',
            type: 'int'
        },
        {
            name: 'access',
            type: 'string'
        },
        {
            name: 'logError',
            type: 'string'
        }]
    });
    var logFilters = new Ext.ux.grid.GridFilters({
        encode: encode,
        local: local,
        filters: [{
            type: 'numeric',
            dataIndex: 'logId',
            column: 'logId',
            table: 'log'
        },
        {
            type: 'numeric',
            dataIndex: 'leafId',
            column: 'leafId',
            table: 'log'
        },
        {
            type: 'string',
            dataIndex: 'operation',
            column: 'operation',
            table: 'log'
        },
        {
            type: 'string',
            dataIndex: 'sql',
            column: 'sql',
            table: 'log'
        },
        {
            type: 'date',
            dataIndex: 'date',
            column: 'date',
            table: 'log'
        },
        {
            type: 'numeric',
            dataIndex: 'staffId',
            column: 'staffId',
            table: 'log'
        },
        {
            type: 'string',
            dataIndex: 'access',
            column: 'access',
            table: 'log'
        },
        {
            type: 'string',
            dataIndex: 'logError',
            column: 'logError',
            table: 'log'
        }]
    });
    var logExpander = new Ext.ux.grid.RowExpander({
        tpl: new Ext.Template('<br><p><b>Operation:</b> {operation}</p><br>', '<p><b>SQL STATEMENT:</b> {sql}</p><br>')
    });
    var logColumnModel = [logExpander, new Ext.grid.RowNumberer(), {
        dataIndex: 'logId',
        header: logIdLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'leafId',
        header: leafIdLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'operation',
        header: operationLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'sql',
        header: sqlLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'date',
        header: dateLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'staffId',
        header: staffIdLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'access',
        header: accessLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'logError',
        header: logErrorLabel,
        sortable: true,
        hidden: false
    }];
    var logGrid = new Ext.grid.GridPanel({
        border: false,
        store: logStore,
        autoHeight: false,
        height: 400,
        columns: logColumnModel,
        loadMask: true,
        plugins: [logFilters, logExpander],
        collapsible: true,
        animCollapse: false,
        selModel: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            emptyText: emptyRowLabel
        },
        iconCls: 'application_view_detail',
        listeners: {
            render: {
                fn: function() {
                    logStore.load({
                        params: {
                            start: 0,
                            limit: perPage,
                            method: 'read',
                            mode: 'view',
                            plugin: [logFilters]
                        }
                    });
                }
            }
        },
        bbar: new Ext.PagingToolbar({
            store: logStore,
            pageSize: perPage,
            plugins: [new Ext.ux.plugins.PageComboResizer()]
        })
    }); // end log Request
    // start Log Advance Request
    var logAdvanceProxy = new Ext.data.HttpProxy({
        url: '../../security/controller/logAdvanceController.php?',
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var logAdvanceReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'logAdvanceId'
    });
    var logAdvanceStore = new Ext.data.JsonStore({
        proxy: logAdvanceProxy,
        reader: logAdvanceReader,
        autoLoad: false,
        autoDestroy: true,
        pruneModifiedRecords: true,
        method: 'POST',
        baseParams: {
            method: 'read',
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            limit: perPage,
            perPage: perPage
        },
        root: 'data',
        fields: [{
            name: 'logAdvanceId',
            type: 'int'
        },
        {
            name: 'logAdvanceText',
            type: 'string'
        },
        {
            name: 'logAdvanceType',
            type: 'string'
        },
        {
            name: 'logAdvanceComparison',
            type: 'string'
        },
        {
            name: 'refTableName',
            type: 'int'
        },
        {
            name: 'leafId',
            type: 'int'
        }]
    });
    var logAdvanceFilters = new Ext.ux.grid.GridFilters({
        encode: encode,
        local: local,
        filters: [{
            type: 'numeric',
            dataIndex: 'logAdvanceId',
            column: 'logAdvanceId',
            table: 'logAdvance'
        },
        {
            type: 'string',
            dataIndex: 'logAdvanceText',
            column: 'logAdvanceText',
            table: 'logAdvance'
        },
        {
            type: 'string',
            dataIndex: 'logAdvanceType',
            column: 'logAdvanceType',
            table: 'logAdvance'
        },
        {
            type: 'string',
            dataIndex: 'logAdvanceComparison',
            column: 'logAdvanceComparison',
            table: 'logAdvance'
        },
        {
            type: 'numeric',
            dataIndex: 'refTableName',
            column: 'refTableName',
            table: 'logAdvance'
        },
        {
            type: 'list',
            dataIndex: 'executeBy',
            column: 'executeBy',
            table: 'logAdvance',
            labelField: 'staffName',
            store: staffByStore,
            phpMode: true
        },
        {
            type: 'date',
            dataIndex: 'executeTime',
            column: 'executeTime',
            table: 'logAdvance'
        }]
    });
    var logAdvanceColumnModel = [new Ext.grid.RowNumberer(), {
        dataIndex: 'logAdvanceId',
        header: logAdvanceIdLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'logAdvanceText',
        header: logAdvanceTextLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'logAdvanceType',
        header: logAdvanceTypeLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'logAdvanceComparision',
        header: logAdvanceComparisionLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'refTableName',
        header: refTableNameLabel,
        sortable: true,
        hidden: false
    }];
    var logAdvanceGrid = new Ext.grid.GridPanel({
        border: false,
        store: logAdvanceStore,
        autoHeight: false,
        height: 400,
        columns: logAdvanceColumnModel,
        loadMask: true,
        plugins: [logAdvanceFilters],
        selModel: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            forceFit: true,
            emptyText: emptyTextLabel
        },
        iconCls: 'application_view_detail',
        listeners: {
            render: {
                fn: function() {
                    logAdvanceStore.load({
                        params: {
                            start: 0,
                            limit: perPage,
                            method: 'read',
                            mode: 'view',
                            plugin: [logAdvanceFilters]
                        }
                    });
                }
            }
        },
        bbar: new Ext.PagingToolbar({
            store: logAdvanceStore,
            pageSize: perPage,
            plugins: [new Ext.ux.plugins.PageComboResizer()]
        }),
        view: new Ext.ux.grid.BufferView({
            rowHeight: 34,
            scrollDelay: false
        })
    }); // end log Advance Request
    // popup window for normal log and advance log
    var auditWindow = new Ext.Window({
        name: 'auditWindow',
        id: 'auditWindow',
        layout: 'fit',
        width: 500,
        height: 300,
        closeAction: 'hide',
        plain: true,
        items: {
            xtype: 'tabpanel',
            activeTab: 0,
            items: [{
                xtype: 'panel',
                layout: 'fit',
                title: 'Log Sql Statement',
                items: [logGrid]
            },
            {
                xtype: 'panel',
                layout: 'fit',
                title: 'Log Sql Statement',
                items: [logAdvanceGrid]
            }]
        },
        title: 'Sql Statement audit',
        maximizable: true,
        autoScroll: true
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
        url: '../controller/generalLedgerChartOfAccountController.php',
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var generalLedgerChartOfAccountReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'generalLedgerChartOfAccountId'
    });
    var generalLedgerChartOfAccountStore = new Ext.data.JsonStore({
        proxy: generalLedgerChartOfAccountProxy,
        reader: generalLedgerChartOfAccountReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: 'read',
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            perPage: perPage
        },
        root: 'data',
        fields: [{
            key: 'PRI',
            foreignKey: 'no',
            name: 'generalLedgerChartOfAccountId',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'generalLedgerChartOfAccountTitle',
            type: 'string'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'generalLedgerChartOfAccountDesc',
            type: 'string'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'generalLedgerChartOfAccountNo',
            type: 'string'
        },
        {
            key: 'MUL',
            foreignKey: 'yes',
            name: 'generalLedgerChartOfAccountTypeId',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'generalLedgerChartOfAccountReportType',
            type: 'string'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isDefault',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isNew',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isDraft',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isUpdate',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isDelete',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isActive',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isApproved',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isReview',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isPost',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isConsolidation',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isSeperated',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'executeBy',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'executeTime',
            type: 'date',
            dateFormat: 'Y-m-d H:i:s'
        }]
    }); // end General Ledger Chart of account request
    // start chart of account request
    var generalLedgerChartOfAccountProxy = new Ext.data.HttpProxy({
        url: '../controller/generalLedgerChartOfAccountController.php',
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var generalLedgerChartOfAccountReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'generalLedgerChartOfAccountId'
    });
    var generalLedgerChartOfAccountStore = new Ext.data.JsonStore({
        proxy: generalLedgerChartOfAccountProxy,
        reader: generalLedgerChartOfAccountReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: 'read',
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            perPage: perPage
        },
        root: 'data',
        fields: [{
            key: 'PRI',
            foreignKey: 'no',
            name: 'generalLedgerChartOfAccountId',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'generalLedgerChartOfAccountTitle',
            type: 'string'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'generalLedgerChartOfAccountDesc',
            type: 'string'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'generalLedgerChartOfAccountNo',
            type: 'string'
        },
        {
            key: 'MUL',
            foreignKey: 'yes',
            name: 'generalLedgerChartOfAccountTypeId',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'generalLedgerChartOfAccountReportType',
            type: 'string'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isDefault',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isNew',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isDraft',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isUpdate',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isDelete',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isActive',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isApproved',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isReview',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isPost',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isConsolidation',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isSeperated',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'executeBy',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'executeTime',
            type: 'date',
            dateFormat: 'Y-m-d H:i:s'
        }]
    }); // end General Ledger Chart of account request
    // start currency code request
    var countryProxy = new Ext.data.HttpProxy({
        url: '../controller/countryController.php',
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var countryReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'countryId'
    });
    var countryStore = new Ext.data.JsonStore({
        proxy: countryProxy,
        reader: countryReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: 'read',
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            perPage: perPage
        },
        root: 'data',
        id: 'countryCurrencyCode',
        fields: [{
            name: 'countryId',
            type: 'string'
        },
        {
            name: 'countryCurrencyCode',
            type: 'string'
        },
        {
            name: 'countryCurrencyCodeDesc',
            type: 'string'
        }]
    }); // end currency code request
    // start invoice category
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
        key :'PRI',
        foreignKey : 'no',
        name : 'invoiceCategoryId',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceCategorySequence',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceCategoryCode',
        type : 'string'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceCategoryDesc',
        type : 'string'},{
        key :'',
        foreignKey : 'no',
        name : 'isDefault',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isNew',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isDraft',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isUpdate',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isDelete',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isActive',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isApproved',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isReview',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isPost',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'executeBy',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'executeTime',
        type : 'date',dateFormat : 'Y-m-d H:i:s'}
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
        key :'PRI',
        foreignKey : 'no',
        name : 'invoiceTypeId',
        type : 'int'},{
        key :'MUL',
        foreignKey : 'yes',
        name : 'invoiceCategoryId',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceTypeSequence',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceTypeCode',
        type : 'string'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceTypeDesc',
        type : 'string'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceTypeCreditLimit',
        type : 'float'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceTypeInterestRate',
        type : 'float'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceTypeMinimumDeposit',
        type : 'float'},{
        key :'MUL',
        foreignKey : 'no',
        name : 'generalLedgerChartOfAccountDimensionId',
        type : 'int'},{
        key :'MUL',
        foreignKey : 'yes',
        name : 'lateInterestId',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'isDefault',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isNew',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isDraft',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isUpdate',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isDelete',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isActive',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isApproved',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isReview',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isPost',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'executeBy',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'executeTime',
        type : 'date',dateFormat : 'Y-m-d H:i:s'}
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
        key :'PRI',
        foreignKey : 'no',
        name : 'invoiceLedgerId',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'documentNo',
        type : 'string'},{
        key :'',
        foreignKey : 'no',
        name : 'referenceNo',
        type : 'string'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceLedgerTitle',
        type : 'string'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceLedgerDesc',
        type : 'string'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceLedgerDate',
        type : 'date',dateFormat : 'Y-m-d'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceLedgerAmount',
        type : 'float'},{
        key :'',
        foreignKey : 'no',
        name : 'businessPartnerId',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceCategoryId',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceTypeId',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceLedger',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'isDefault',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isNew',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isDraft',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isUpdate',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isDelete',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isActive',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isApproved',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isReview',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isPost',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'executeBy',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'executeTime',
        type : 'date',dateFormat : 'Y-m-d H:i:s'}
        ]
    });
	// end invoice request
// start refund request
var refundTypeProxy = new Ext.data.HttpProxy({
    url : '../controller/refundTypeController.php',
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
 
var refundTypeReader = new Ext.data.JsonReader({
    totalProperty : 'total',
    successProperty : 'success',
    messageProperty : 'message',
    idProperty : 'refundTypeId'
});
 
var refundTypeStore = new Ext.data.JsonStore({
    proxy : refundTypeProxy,
    reader : refundTypeReader,
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
    id : 'refundTypeId',
    fields : [{
    key :'PRI',
    foreignKey : 'no',
    name : 'refundTypeId',
    type : 'int'},{
    key :'',
    foreignKey : 'no',
    name : 'refundTypeSequence',
    type : 'int'},{
    key :'',
    foreignKey : 'no',
    name : 'refundTypeCode',
    type : 'string'},{
    key :'',
    foreignKey : 'no',
    name : 'refundTypeDesc',
    type : 'string'},{
    key :'',
    foreignKey : 'no',
    name : 'isDefault',
    type : 'boolean'},{
    key :'',
    foreignKey : 'no',
    name : 'isNew',
    type : 'boolean'},{
    key :'',
    foreignKey : 'no',
    name : 'isDraft',
    type : 'boolean'},{
    key :'',
    foreignKey : 'no',
    name : 'isUpdate',
    type : 'boolean'},{
    key :'',
    foreignKey : 'no',
    name : 'isDelete',
    type : 'boolean'},{
    key :'',
    foreignKey : 'no',
    name : 'isActive',
    type : 'boolean'},{
    key :'',
    foreignKey : 'no',
    name : 'isApproved',
    type : 'boolean'},{
    key :'',
    foreignKey : 'no',
    name : 'isReview',
    type : 'boolean'},{
    key :'',
    foreignKey : 'no',
    name : 'isPost',
    type : 'boolean'},{
    key :'',
    foreignKey : 'no',
    name : 'executeBy',
    type : 'int'},{
    key :'',
    foreignKey : 'no',
    name : 'executeTime',
    type : 'date',dateFormat : 'Y-m-d H:i:s'}
    ]
});

//end refundType request
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
        id : 'invoiceLedgerId',
        fields : [{
        key :'PRI',
        foreignKey : 'no',
        name : 'invoiceLedgerId',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'documentNo',
        type : 'string'},{
        key :'',
        foreignKey : 'no',
        name : 'referenceNo',
        type : 'string'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceLedgerTitle',
        type : 'string'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceLedgerDesc',
        type : 'string'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceLedgerDate',
        type : 'date',dateFormat : 'Y-m-d'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceLedgerAmount',
        type : 'float'},{
        key :'',
        foreignKey : 'no',
        name : 'businessPartnerId',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceCategoryId',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceTypeId',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'invoiceLedger',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'isDefault',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isNew',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isDraft',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isUpdate',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isDelete',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isActive',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isApproved',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isReview',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'isPost',
        type : 'boolean'},{
        key :'',
        foreignKey : 'no',
        name : 'executeBy',
        type : 'int'},{
        key :'',
        foreignKey : 'no',
        name : 'executeTime',
        type : 'date',dateFormat : 'Y-m-d H:i:s'}
        ]
    });
	// end invoice request
    // end additional Proxy ,Reader,Store,Filter,Grid
    // start application Proxy ,Reader,Store,Filter,Grid
    var refundLedgerProxy = new Ext.data.HttpProxy({
        url: '../controller/refundLedgerController.php',
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var refundLedgerReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'refundLedgerId'
    });
    var refundLedgerStore = new Ext.data.JsonStore({
        proxy: refundLedgerProxy,
        reader: refundLedgerReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: 'read',
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            limit: perPage,
            perPage: perPage
        },
        root: 'data',
        fields: [{
            key: 'PRI',
            foreignKey: 'no',
            name: 'refundLedgerId',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'refundTypeId',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'documentNo',
            type: 'string'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'refundLedgerTitle',
            type: 'string'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'refundLedgerDesc',
            type: 'string'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'refundLedgerDate',
            type: 'date',
            dateFormat: 'Y-m-d'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'refundLedgerAmount',
            type: 'date',
            dateFormat: 'Y-m-d'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isDefault',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isNew',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isDraft',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isUpdate',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isDelete',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isActive',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isApproved',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isReview',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isPost',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'executeBy',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'executeTime',
            type: 'date',
            dateFormat: 'Y-m-d H:i:s'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'refundTypeDesc',
            type: 'string'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'staffNo',
            type: 'string'
        }]
    });
    var refundLedgerFilters = new Ext.ux.grid.GridFilters({
        encode: encode,
        local: local,
        filters: [{
            type: 'int',
            dataIndex: 'refundLedgerId',
            column: 'refundLedgerId',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'int',
            dataIndex: 'refundTypeId',
            column: 'refundTypeId',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'string',
            dataIndex: 'documentNo',
            column: 'documentNo',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'string',
            dataIndex: 'refundLedgerTitle',
            column: 'refundLedgerTitle',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'string',
            dataIndex: 'refundLedgerDesc',
            column: 'refundLedgerDesc',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'date',
            dataIndex: 'refundLedgerDate',
            column: 'refundLedgerDate',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'date',
            dataIndex: 'refundLedgerAmount',
            column: 'refundLedgerAmount',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isDefault',
            column: 'isDefault',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isNew',
            column: 'isNew',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isDraft',
            column: 'isDraft',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isUpdate',
            column: 'isUpdate',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isDelete',
            column: 'isDelete',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isActive',
            column: 'isActive',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isApproved',
            column: 'isApproved',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isReview',
            column: 'isReview',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isPost',
            column: 'isPost',
            table: 'refundLedger',
            database: 'ifinancial'
        },
        {
            type: 'list',
            dataIndex: 'executeBy',
            column: 'executeBy',
            table: 'refundLedger',
            database: 'ifinancial',
            labelField: 'staffName',
            store: staffByStore,
            phpMode: true
        },
        {
            type: 'date',
            dataIndex: 'executeTime',
            column: 'executeTime',
            table: 'refundLedger',
            database: 'ifinancial'
        }]
    });
    var isDefaultGrid = new Ext.ux.grid.CheckColumn({
        header: isDefaultLabel,
        dataIndex: 'isDefault',
        hidden: isDefaultHidden
    });
    var isNewGrid = new Ext.ux.grid.CheckColumn({
        header: 'New',
        dataIndex: 'isNew',
        hidden: isNewHidden
    });
    var isDraftGrid = new Ext.ux.grid.CheckColumn({
        header: isDraftLabel,
        dataIndex: 'isDraft',
        hidden: isDraftHidden
    });
    var isUpdateGrid = new Ext.ux.grid.CheckColumn({
        header: isUpdateLabel,
        dataIndex: 'isUpdate',
        hidden: isUpdateHidden
    });
    var isDeleteGrid = new Ext.ux.grid.CheckColumn({
        header: isDeleteLabel,
        dataIndex: 'isDelete'
    });
    var isActiveGrid = new Ext.ux.grid.CheckColumn({
        header: isActiveLabel,
        dataIndex: 'isActive',
        hidden: isActiveHidden
    });
    var isApprovedGrid = new Ext.ux.grid.CheckColumn({
        header: isApprovedLabel,
        dataIndex: 'isApproved',
        hidden: isApprovedHidden
    });
    var isReviewGrid = new Ext.ux.grid.CheckColumn({
        header: isReviewLabel,
        dataIndex: 'isReview',
        hidden: isReviewHidden
    });
    var isPostGrid = new Ext.ux.grid.CheckColumn({
        header: 'Post',
        dataIndex: 'isPost',
        hidden: isPostHidden
    });
    var isDefaultGridDetail = new Ext.ux.grid.CheckColumn({
        header: isDefaultLabel,
        dataIndex: 'isDefault',
        hidden: isDefaultHidden
    });
    var isNewGridDetail = new Ext.ux.grid.CheckColumn({
        header: isNewLabel,
        dataIndex: 'isNew',
        hidden: isNewHidden
    });
    var isDraftGridDetail = new Ext.ux.grid.CheckColumn({
        header: isDraftLabel,
        dataIndex: 'isDraft',
        hidden: isDraftHidden
    });
    var isUpdateGridDetail = new Ext.ux.grid.CheckColumn({
        header: isUpdateLabel,
        dataIndex: 'isUpdate',
        hidden: isUpdateHidden
    });
    var isDeleteGridDetail = new Ext.ux.grid.CheckColumn({
        header: isDeleteLabel,
        dataIndex: 'isDelete'
    });
    var isActiveGridDetail = new Ext.ux.grid.CheckColumn({
        header: isActiveLabel,
        dataIndex: 'isActive',
        hidden: isActiveHidden
    });
    var isApprovedGridDetail = new Ext.ux.grid.CheckColumn({
        header: isApprovedLabel,
        dataIndex: 'isApproved',
        hidden: isApprovedHidden
    });
    var isReviewGridDetail = new Ext.ux.grid.CheckColumn({
        header: isReviewLabel,
        dataIndex: 'isReview',
        hidden: isReviewHidden
    });
    var isPostGridDetail = new Ext.ux.grid.CheckColumn({
        header: isPostLabel,
        dataIndex: 'isPost',
        hidden: isPostHidden
    });
    var refundLedgerColumnModel = [{
        dataIndex: 'refundTypeId',
        header: refundTypeForeignKeyLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return record.data.refundTypeDesc;
        }
    },
    {
        dataIndex: 'documentNo',
        header: documentNoLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'refundLedgerTitle',
        header: refundLedgerTitleLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'refundLedgerDesc',
        header: refundLedgerDescLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'refundLedgerDate',
        header: refundLedgerDateLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'refundLedgerAmount',
        header: refundLedgerAmountLabel,
        sortable: true,
        hidden: false
    },
    isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid, isDeleteGrid, isActiveGrid, isApprovedGrid, isReviewGrid, isPostGrid, {
        dataIndex: 'executeBy',
        header: executeByLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return record.data.staffName;
        }
    },
    {
        dataIndex: 'executeTime',
        header: executeTimeLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return Ext.util.Format.date(value, 'd-m-Y H:i:s');
        }
    }];
    var refundLedgerFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
    var refundLedgerGrid = new Ext.grid.GridPanel({
        border: false,
        store: refundLedgerStore,
        autoHeight: false,
        columns: refundLedgerColumnModel,
        loadMask: true,
        plugins: [refundLedgerFilters],
        autoScroll: true,
        selModel: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            forceFit: true,
            emptyText: emptyRowLabel
        },
        iconCls: 'application_view_detail',
        listeners: {
            'rowclick': function(object, rowIndex, e) {
                var record = refundLedgerStore.getAt(rowIndex);
                formPanel.getForm().reset();
                formPanel.form.load({
                    url: '../controller/refundLedgerController.php',
                    method: 'POST',
                    waitTitle: systemLabel,
                    waitMsg: waitMessageLabel,
                    params: {
                        method: 'read',
                        mode: 'update',
                        refundLedgerId: record.data.refundLedgerId,
                        leafId: leafId,
                        isAdmin: isAdmin
                    },
                    success: function(form, action) {
                        Ext.getCmp('newButton').disable();
                        Ext.getCmp('saveButton').enable();
                        Ext.getCmp('deleteButton').enable();
                        Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
                        Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
                        Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
                        Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
                        Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                        refundLedgerDetailStore.load({
                            params: {
                                leafId: leafId,
                                isAdmin: isAdmin,
                                refundLedgerId: record.data.refundLedgerId
                            }
                        });
                        if (Ext.getCmp('previousRecord').getValue() == 0) {
                            Ext.getCmp('previousButton').disable();
                        }
                        if (Ext.getCmp('nextRecord').getValue() == 0) {
                            Ext.getCmp('nextButton').disable();
                        }
                        refundLedgerDetailGrid.enable();
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
                    failure: function(form, action) {
                        Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                    }
                });
            }
        },
        tbar: {
            items: [{
                text: addToolbarLabel,
                iconCls: 'add',
                id: 'pageCreate',
                iconCls: 'add',
                xtype: 'button',
                handler: function() {
                    viewPort.items.get(1).expand();
                }
            },
            {
                xtype: 'button',
                text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function(button, e) {
                        refundLedgerStore.each(function(record, fn, scope) {
                            for (var access in refundLedgerFlagArray) {
                                record.set(refundLedgerFlagArray[access], true);
                            }
                        });
                    }
                }
            },
            {
                xtype: 'button',
                text: ClearAllLabel,
                iconCls: 'row-check-sprite-uncheck',
                listeners: {
                    'click': function(button, e) {
                        refundLedgerStore.each(function(record, fn, scope) {
                            for (var access in refundLedgerFlagArray) {
                                record.set(refundLedgerFlagArray[access], false);
                            }
                        });
                    }
                }
            },
            {
                xtype: 'button',
                text: saveButtonLabel,
                iconCls: 'bullet_disk',
                listeners: {
                    'click': function(button, e) {
                        var url = '../controller/refundLedgerController.php?';
                        var sub_url = '';
                        var modified = refundLedgerStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            sub_url = sub_url + '&refundLedgerId[]=' + modified[i].get('refundLedgerId');
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
                            url: url,
                            method: 'GET',
                            params: {
                                leafId: leafId,
                                isAdmin: isAdmin,
                                method: 'updateStatus'
                            },
                            success: function(response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse.success == true) {
                                    Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                    refundLedgerStore.reload();
                                } else if (jsonResponse.success == false) {
                                    Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                                }
                            },
                            failure: function(response, options) {
                                Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                            }
                        });
                    }
                }
            },
            '->', new Ext.ux.form.SearchField({
                store: refundLedgerStore,
                width: 320
            })]
        },
        bbar: new Ext.PagingToolbar({
            store: refundLedgerStore,
            pageSize: perPage
        }),
        view: new Ext.ux.grid.BufferView({
            rowHeight: 34,
            scrollDelay: false
        })
    });
    var dateRangeStart = new Ext.form.Hidden({
        name: 'dateRangeStart',
        id: 'dateRangeStart',
        value: ''
    });
    var dateRangeEnd = new Ext.form.Hidden({
        name: 'dateRangeEnd',
        id: 'dateRangeEnd',
        value: ''
    });
    var dateRangeType = new Ext.form.Hidden({
        name: 'dateRangeType',
        id: 'dateRangeType'
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
        title: leafNative,
        height: 50,
        layout: 'fit',
        iconCls: 'application_view_detail',
        tbar: [{
            xtype: 'button',
            iconCls: 'resultset_first',
            handler: function(button, e) {
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
                refundLedgerStore.reload({
                    params: {
                        dateRangeType: Ext.getCmp('dateRangeType').getValue(),
                        dateRangeStart: Ext.getCmp('dateRangeStart').getValue()
                    }
                });
            }
        },
        '-', {
            xtype: 'button',
            text: 'Day',
            tooltip: 'Day',
            iconCls: 'calendar',
            handler: function(button, e) {
                Ext.getCmp('dateRangeType').setValue('day');
                if (Ext.getCmp('dateRangeStart').getValue() == '' || Ext.getCmp('dateRangeStart').getValue() == undefined) {
                    dateRangeStartValue = new Date();
                    Ext.getCmp('dateRangeStart').setValue(dateRangeStartValue.getFullYear() + "-" + (dateRangeStartValue.getMonth() + 1) + "-" + dateRangeStartValue.getDate());
                    Ext.getCmp('filterDay').setText('Filter Day : ' + (dateRangeStartValue.getDate()));
                    Ext.getCmp('filterMonth').setText('Filter Month : ' + (dateRangeStartValue.getMonth() + 1));
                    Ext.getCmp('filterYear').setText('Filter Year:' + dateRangeStartValue.getFullYear());
                }
                Ext.getCmp('currentDateRangeType').setText('Filter : ' + Ext.getCmp('dateRangeType').getValue());
                refundLedgerStore.reload({
                    params: {
                        dateRangeType: Ext.getCmp('dateRangeType').getValue(),
                        dateRangeStart: Ext.getCmp('dateRangeStart').getValue()
                    }
                });
            }
        },
        '-', {
            xtype: 'button',
            text: 'Week',
            tooltip: 'Week',
            iconCls: 'calendar',
            handler: function(button, e) {
                Ext.getCmp('dateRangeType').setValue('week');
                var curr = new Date();
                var first = curr.getDate() - curr.getDay();
                var last = first + 6;
                var f = new Date(curr.setDate(first));
                var l = new Date(curr.setDate(last));
                Ext.getCmp('dateRangeStart').setValue(f.getFullYear() + "-" + (f.getMonth() + 1) + "-" + f.getDate());
                Ext.getCmp('dateRangeEnd').setValue(l.getFullYear() + "-" + (l.getMonth() + 1) + "-" + l.getDate());
                Ext.getCmp('currentDateRangeType').setText('Filter : ' + Ext.getCmp('dateRangeType').getValue());
                refundLedgerStore.reload({
                    params: {
                        dateRangeType: Ext.getCmp('dateRangeType').getValue(),
                        dateRangeStart: Ext.getCmp('dateRangeStart').getValue(),
                        dateRangeEnd: Ext.getCmp('dateRangeEnd').getValue()
                    }
                });
            }
        },
        '-', {
            xtype: 'button',
            text: 'Month',
            tooltip: 'Month',
            iconCls: 'calendar',
            handler: function(button, e) {
                Ext.getCmp('dateRangeType').setValue('month');
                if (Ext.getCmp('dateRangeStart').getValue() == '' || Ext.getCmp('dateRangeStart').getValue() == undefined) {
                    dateRangeStartValue = new Date();
                    Ext.getCmp('dateRangeStart').setValue(dateRangeStartValue.getFullYear() + "-" + (dateRangeStartValue.getMonth() + 1) + "-" + dateRangeStartValue.getDate());
                    Ext.getCmp('filterDay').setText('Filter Day : ' + (dateRangeStartValue.getDate()));
                    Ext.getCmp('filterMonth').setText('Filter Month : ' + (dateRangeStartValue.getMonth() + 1));
                    Ext.getCmp('filterYear').setText('Filter Year:' + dateRangeStartValue.getFullYear());
                }
                Ext.getCmp('currentDateRangeType').setText('Filter : ' + Ext.getCmp('dateRangeType').getValue());
                refundLedgerStore.reload({
                    params: {
                        dateRangeType: Ext.getCmp('dateRangeType').getValue(),
                        dateRangeStart: Ext.getCmp('dateRangeStart').getValue()
                    }
                });
            }
        },
        '-', {
            xtype: 'button',
            text: 'Year',
            tooltip: 'Year',
            iconCls: 'calendar',
            handler: function(button, e) {
                Ext.getCmp('dateRangeType').setValue('year');
                if (Ext.getCmp('dateRangeStart').getValue() == '' || Ext.getCmp('dateRangeStart').getValue() == undefined) {
                    dateRangeStartValue = new Date();
                    Ext.getCmp('dateRangeStart').setValue(dateRangeStartValue.getFullYear() + "-" + (dateRangeStartValue.getMonth() + 1) + "-" + dateRangeStartValue.getDate());
                    Ext.getCmp('filterDay').setText('Filter Day : ' + (dateRangeStartValue.getDate()));
                    Ext.getCmp('filterMonth').setText('Filter Month : ' + (dateRangeStartValue.getMonth() + 1));
                    Ext.getCmp('filterYear').setText('Filter Year:' + dateRangeStartValue.getFullYear());
                }
                Ext.getCmp('currentDateRangeType').setText('Filter : ' + Ext.getCmp('dateRangeType').getValue());
                refundLedgerStore.reload({
                    params: {
                        dateRangeType: Ext.getCmp('dateRangeType').getValue(),
                        dateRangeStart: Ext.getCmp('dateRangeStart').getValue()
                    }
                });
            }
        },
        '-', {
            xtype: 'label',
            name: 'currentDay',
            id: 'currentDay',
            text: 'Current Day : ' + currentDay()
        },
        '-', {
            xtype: 'label',
            name: 'filterDay',
            id: 'filterDay',
            text: 'Filter Day : '
        },
        '-', {
            xtype: 'label',
            name: 'filterMonth',
            id: 'filterMonth',
            text: 'Filter Month : '
        },
        '-', {
            xtype: 'label',
            name: 'filterYear',
            id: 'filterYear',
            text: 'Filter Year : '
        },
        '-', {
            xtype: 'label',
            name: 'currentDateRangeType',
            id: 'currentDateRangeType',
            text: 'Filter : '
        },
        '-', {
            xtype: 'label',
            name: 'startdate',
            id: 'startdate',
            text: 'Start'
        },
        '-', {
            xtype: 'datefield',
            name: 'dateRangeBetweenStart',
            id: 'dateRangeBetweenStart'
        },
        '-', {
            xtype: 'label',
            name: 'endDate',
            id: 'endDate',
            text: 'End'
        },
        '-', {
            xtype: 'datefield',
            name: 'dateRangeBetweenEnd',
            id: 'dateRangeBetweenEnd'
        },
        '-', {
            xtype: 'button',
            name: 'filterBetweenButton',
            id: 'filterBetweenButton',
            text: 'Search Between Date',
            handler: function(e, a) {
                refundLedgerStore.reload({
                    params: {
                        dateRangeType: Ext.getCmp('dateRangeType').getValue(),
                        dateRangeStart: Ext.getCmp('dateRangeBetweenStart').getValue(),
                        dateRangeEnd: Ext.getCmp('dateRangeBetweenEnd').getValue()
                    }
                });
            }
        },'-',{
        	xtype:'button',
        	name :'resetFilterDate',
        	id :'resetFilterDate',
        	text : 'Reset Date',
        	handler : function(button,e){
        		   dateRangeStartValue = new Date();
                   Ext.getCmp('dateRangeStart').setValue(dateRangeStartValue.getFullYear() + "-" + (dateRangeStartValue.getMonth() + 1) + "-" + dateRangeStartValue.getDate());
        	}
        },'->', {
            xtype: 'button',
            iconCls: 'resultset_last',
            handler: function(button, e) {
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
                refundLedgerStore.reload({
                    params: {
                        dateRangeType: Ext.getCmp('dateRangeType').getValue(),
                        dateRangeStart: Ext.getCmp('dateRangeStart').getValue()
                    }
                });
            }
        }],
        items: [refundLedgerGrid]
    }); // viewport just save information,items will do separate
    // start form entry
    var documentNoTemp = new Ext.form.Hidden({
        name: 'documentNoTemp',
        id: 'documentNoTemp'
    });
    var refundLedgerId = new Ext.form.Hidden({
        name: 'refundLedgerId',
        id: 'refundLedgerId'
    });
	var businessPartnerId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: businessPartnerForeignKeyLabel,
        name: 'businessPartnerId',
        hiddenName: 'businessPartnerd',
        valueField: 'businessPartnerId',
        hiddenId: 'businessPartnerd_fake',
        id: 'businessPartnerId',
        displayField: 'businessPartnerDesc',
        typeAhead: false,
        triggerAction: 'all',
        store: businessPartnerStore,
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
             value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
            return new RegExp('\\b(' + value + ')', 'i');
        }
    });
    var refundTypeId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: refundTypeForeignKeyLabel,
        name: 'refundTypeId',
        hiddenName: 'refundTypeId',
        valueField: 'refundTypeId',
        hiddenId: 'refundTypeId_fake',
        id: 'refundTypeId',
        displayField: 'refundTypeDesc',
        typeAhead: false,
        triggerAction: 'all',
        store: refundTypeStore,
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
             value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
            return new RegExp('\\b(' + value + ')', 'i');
        }
    });
	
    var invoiceCategoryId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: invoiceCategoryForeignKeyLabel,
        name: 'invoiceCategoryId',
        hiddenName: 'invoiceCategoryId',
        valueField: 'invoiceCategoryId',
        hiddenId: 'invoiceCategoryId_fake',
        id: 'invoiceCategoryId',
        displayField: 'invoiceCategoryDesc',
        typeAhead: false,
        triggerAction: 'all',
        store: invoiceCategoryStore,
        anchor: '95%',
        selectOnFocus: true,
        mode: 'local',
        allowBlank: true,
        blankText: blankTextLabel,
        createValueMatcher: function(value) {
			
            value = String(value).replace(/\s*/g, '');
            if (Ext.isEmpty(value, false)) {
                return new RegExp('^');
            }
             value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
            return new RegExp('\\b(' + value + ')', 'i');
        },
		listeners : {
				'select': function(combo, record, index) {
					invoiceTypeStore.load ({
						params :{
							invoiceCategoryId : combo.value
						}
					});
				}
			}
    });
	var invoiceTypeId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: invoiceTypeForeignKeyLabel,
        name: 'invoiceTypeId',
        hiddenName: 'invoiceTypeId',
        valueField: 'invoiceTypeId',
        hiddenId: 'invoiceTypeId_fake',
        id: 'invoiceTypeId',
        displayField: 'invoiceTypeDesc',
        typeAhead: false,
        triggerAction: 'all',
        store: invoiceTypeStore,
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
             value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
            return new RegExp('\\b(' + value + ')', 'i');
        },
		listeners : {
				'select': function(combo, record, index) {
					invoiceLedgerStore.load ({
						params :{
							invoiceCategoryId : Ext.getCmp('invoiceCategoryId').getValue(),
							invoiceTypeId : combo.value
						}
					});
				}
			}
    });
	
	var invoiceLedgerId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: invoiceLedgerForeignKeyLabel,
        name: 'invoiceLedgerId',
        hiddenName: 'invoiceLedgerId',
        valueField: 'invoiceLedgerId',
        hiddenId: 'invoiceLedgerId_fake',
        id: 'invoiceLedger',
        displayField: 'invoiceLedgerDesc',
        typeAhead: false,
        triggerAction: 'all',
        store: invoiceLedgerStore,
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
             value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
            return new RegExp('\\b(' + value + ')', 'i');
        }
    });
    var documentNo = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: documentNoLabel + '*',
        hiddenName: 'documentNo',
        name: 'documentNo',
        id: 'documentNo',
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '90%'
    });
    var referenceNo = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: referenceNoLabel + '*',
        hiddenName: 'referenceNo',
        name: 'referenceNo',
        id: 'referenceNo',
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '90%'
    });
    var refundLedgerTitle = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: refundLedgerTitleLabel + '*',
        hiddenName: 'refundLedgerTitle',
        name: 'refundLedgerTitle',
        id: 'refundLedgerTitle',
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '90%'
    });
    var refundLedgerDesc = new Ext.form.HtmlEditor({
        labelAlign: 'top',
        fieldLabel: refundLedgerDescLabel,
        hiddenName: 'refundLedgerDesc',
        name: 'refundLedgerDesc',
        id: 'refundLedgerDesc',
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '90%',
        height: 55
    });
    var refundLedgerDate = new Ext.form.DateField({
        labelAlign: 'left',
        fieldLabel: refundLedgerDateLabel + '*',
        hiddenName: 'refundLedgerDate',
        name: 'refundLedgerDate',
        id: 'refundLedgerDate',
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '90%'
    });
  
    var refundLedgerAmount = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: refundLedgerAmountLabel + '*',
        hiddenName: 'refundLedgerAmount',
        name: 'refundLedgerAmount',
        id: 'refundLedgerAmount',
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '90%',
        decimalPrecision: 2,
        vtype: 'dollar',
        listeners: {
            blur: function() {
                var value = Ext.getCmp('refundLedgerAmount').getValue();
                value = value.replace(",", "");
                value = value.replace(" ", "");
                Ext.getCmp('refundLedgerAmount').setValue(value);
            }
        }
    });
    var firstRecord = new Ext.form.Hidden({
        name: 'firstRecord',
        id: 'firstRecord',
        value: ''
    });
    var nextRecord = new Ext.form.Hidden({
        name: 'nextRecord',
        id: 'nextRecord',
        value: ''
    });
    var previousRecord = new Ext.form.Hidden({
        name: 'previousRecord',
        id: 'previousRecord',
        value: ''
    });
    var lastRecord = new Ext.form.Hidden({
        name: 'lastRecord',
        id: 'lastRecord',
        value: ''
    });
    var endRecord = new Ext.form.Hidden({
        name: 'endRecord',
        id: 'endRecord',
        value: ''
    }); // end of hidden value for navigation button
    // start refundLedgerDetail request
    var refundLedgerDetailProxy = new Ext.data.HttpProxy({
        url: '../controller/refundLedgerDetailController.php',
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var refundLedgerDetailReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'refundLedgerDetailId'
    });
    var refundLedgerDetailStore = new Ext.data.JsonStore({
        proxy: refundLedgerDetailProxy,
        reader: refundLedgerDetailReader,
        autoLoad: false,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: 'read',
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            perPage: perPage
        },
        root: 'data',
        id: 'refundLedgerDetailId',
        fields: [{
            key: 'PRI',
            foreignKey: 'no',
            name: 'refundLedgerDetailId',
            type: 'int'
        },
        {
            key: 'MUL',
            foreignKey: 'yes',
            name: 'refundLedgerId',
            type: 'int'
        },
        {
            key: 'MUL',
            foreignKey: 'yes',
            name: 'generalLedgerChartOfAccountId',
            type: 'int'
        },
        {
            key: 'MUL',
            foreignKey: 'yes',
            name: 'countryId',
            type: 'int'
        }, {
            key: '',
            foreignKey: 'no',
            name: 'transactionMode',
            type: 'string'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'refundLedgerDetailAmount',
            type: 'float'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isDefault',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isNew',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isDraft',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isUpdate',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isDelete',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isActive',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isApproved',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isReview',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'isPost',
            type: 'boolean'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'executeBy',
            type: 'int'
        },
        {
            key: '',
            foreignKey: 'no',
            name: 'executeTime',
            type: 'date',
            dateFormat: 'Y-m-d H:i:s'
        }]
    }); // end refundLedgerDetail request
    var generalLedgerChartOfAccountFilters = new Ext.ux.grid.GridFilters({
        encode: false,
        local: false,
        filters: [{
            type: 'int',
            dataIndex: 'refundLedgerDetailId',
            column: 'refundLedgerDetailId',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        , {
            type: 'list',
            dataIndex: 'refundLedgerId',
            column: 'refundLedgerId',
            table: 'refundLedgerDetail',
            database: 'ifinancial',
            labelField: 'refundLedgerDesc',
            store: refundLedgerStore,
            phpMode: true
        },
        , {
            type: 'list',
            dataIndex: 'generalLedgerChartOfAccountId',
            column: 'generalLedgerChartOfAccountId',
            table: 'refundLedgerDetail',
            database: 'ifinancial',
            labelField: 'generalLedgerChartOfAccountDesc',
            store: generalLedgerChartOfAccountStore,
            phpMode: true
        },
        , {
            type: 'list',
            dataIndex: 'countryId',
            column: 'countryId',
            table: 'refundLedgerDetail',
            database: 'ifinancial',
            labelField: 'countryCurrencyCodeDesc',
            store: countryStore,
            phpMode: true
        },
        {
            type: 'float',
            dataIndex: 'refundLedgerDetailAmount',
            column: 'refundLedgerDetailAmount',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isDefault',
            column: 'isDefault',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isNew',
            column: 'isNew',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isDraft',
            column: 'isDraft',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isUpdate',
            column: 'isUpdate',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isDelete',
            column: 'isDelete',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isActive',
            column: 'isActive',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isApproved',
            column: 'isApproved',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isReview',
            column: 'isReview',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isPost',
            column: 'isPost',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'list',
            dataIndex: 'executeBy',
            column: 'executeBy',
            table: 'refundLedgerDetail',
            database: 'ifinancial',
            labelField: 'staffName',
            store: staffByStore,
            phpMode: true
        },
        {
            type: 'date',
            dataIndex: 'executeTime',
            column: 'executeTime',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'int',
            dataIndex: 'refundLedgerDetailId',
            column: 'refundLedgerDetailId',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        , {
            type: 'list',
            dataIndex: 'refundLedgerId',
            column: 'refundLedgerId',
            table: 'refundLedgerDetail',
            database: 'ifinancial',
            labelField: 'refundLedgerDesc',
            store: refundLedgerStore,
            phpMode: true
        },
        , {
            type: 'list',
            dataIndex: 'generalLedgerChartOfAccountId',
            column: 'generalLedgerChartOfAccountId',
            table: 'refundLedgerDetail',
            database: 'ifinancial',
            labelField: 'generalLedgerChartOfAccountDesc',
            store: generalLedgerChartOfAccountStore,
            phpMode: true
        },
        , {
            type: 'list',
            dataIndex: 'countryId',
            column: 'countryId',
            table: 'refundLedgerDetail',
            database: 'ifinancial',
            labelField: 'countryDesc',
            store: countryStore,
            phpMode: true
        },
        {
            type: 'float',
            dataIndex: 'refundLedgerDetailAmount',
            column: 'refundLedgerDetailAmount',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isDefault',
            column: 'isDefault',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isNew',
            column: 'isNew',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isDraft',
            column: 'isDraft',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isUpdate',
            column: 'isUpdate',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isDelete',
            column: 'isDelete',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isActive',
            column: 'isActive',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isApproved',
            column: 'isApproved',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isReview',
            column: 'isReview',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'boolean',
            dataIndex: 'isPost',
            column: 'isPost',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        },
        {
            type: 'list',
            dataIndex: 'executeBy',
            column: 'executeBy',
            table: 'refundLedgerDetail',
            database: 'ifinancial',
            labelField: 'staffName',
            store: staffByStore,
            phpMode: true
        },
        {
            type: 'date',
            dataIndex: 'executeTime',
            column: 'executeTime',
            table: 'refundLedgerDetail',
            database: 'ifinancial'
        }]
    });
    var refundLedgerDetailId = new Ext.form.Hidden({
        name: 'refundLedgerDetailId',
        id: 'refundLedgerDetailId'
    });
    var generalLedgerChartOfAccountId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: generalLedgerChartOfAccountIdLabel,
        name: 'stateId',
        hiddenName: 'generalLedgerChartOfAccountId',
        valueField: 'generalLedgerChartOfAccountId',
        hiddenId: 'generalLedgerChartOfAccountId_fake',
        id: 'generalLedgerChartOfAccountId',
        displayField: 'generalLedgerChartOfAccountDesc',
        typeAhead: false,
        triggerAction: 'all',
        store: generalLedgerChartOfAccountStore,
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
             value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
            return new RegExp('\\b(' + value + ')', 'i');
        }
    });
    var transactionModeArrayData = [
                                    ['D', 'DEBIT'], 
                                    ['C', 'CREDIT']];
    var transactionModeRecord = Ext.data.Record.create([{
        name: 'mode'
    },
    {
        name: 'modFlag'
    }]);
    var transactionModeArrayReader = new Ext.data.ArrayReader({},
    transactionModeRecord);
    var transactionModeMemoryProxy = new Ext.data.MemoryProxy(transactionModeArrayData);
    var transactionModeStore = new Ext.data.Store({
        reader: transactionModeArrayReader,
        proxy: transactionModeMemoryProxy
    });
    transactionModeStore.load();
    var transactionMode = new Ext.ux.form.ComboBoxMatch({
        fieldLabel: 'Mod',
        labelAlign: 'left',
        name: 'transactionMode',
        id: 'transactionMode',
        valueField: 'mode',
        displayField: 'modFlag',
        typeAhead: false,
        triggerAction: 'all',
        store: transactionModeStore,
        width: '50',
        selectOnFocus: true,
        mode: 'local',
        createValueMatcher: function(value) {
            value = String(value).replace(/\s*/g, '');
            if (Ext.isEmpty(value, false)) {
                return new RegExp('^');
            }
            value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
            return new RegExp('\\b(' + value + ')', 'i');
        }
    });
    var countryId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: countryIdLabel,
        name: 'stateId',
        hiddenName: 'countryId',
        valueField: 'countryId',
        hiddenId: 'countryId_fake',
        id: 'countryId',
        displayField: 'countryCurrencyCodeDesc',
        typeAhead: false,
        triggerAction: 'all',
        store: countryStore,
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
             value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
            return new RegExp('\\b(' + value + ')', 'i');
        }
    });
    var refundLedgerDetailAmount = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: refundLedgerDetailAmountLabel + '<span style="\'color:" red;\'="">*</span>',
        hiddenName: 'refundLedgerDetailAmount',
        name: 'refundLedgerDetailAmount',
        id: 'refundLedgerDetailAmount',
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '40%',
        decimalPrecision: 2,
        vtype: 'dollar',
        listeners: {
            blur: function() {
                var value = Ext.getCmp('refundLedgerDetailAmount').getValue();
                value = value.replace(",", "");
                value = value.replace(" ", "");
                Ext.getCmp('refundLedgerDetailAmount').setValue(value);
            }
        }
    });
    var isDefaultGridDetail = new Ext.ux.grid.CheckColumn({
        header: isDefaultLabel,
        dataIndex: 'isDefault',
        hidden: isDefaultHidden
    });
    var isNewGridDetail = new Ext.ux.grid.CheckColumn({
        header: isNewLabel,
        dataIndex: 'isNew',
        hidden: isNewHidden
    });
    var isDraftGridDetail = new Ext.ux.grid.CheckColumn({
        header: isDraftLabel,
        dataIndex: 'isDraft',
        hidden: isDraftHidden
    });
    var isUpdateGridDetail = new Ext.ux.grid.CheckColumn({
        header: isUpdateLabel,
        dataIndex: 'isUpdate',
        hidden: isUpdateHidden
    });
    var isDeleteGridDetail = new Ext.ux.grid.CheckColumn({
        header: isDeleteLabel,
        dataIndex: 'isDelete'
    });
    var isActiveGridDetail = new Ext.ux.grid.CheckColumn({
        header: isActiveLabel,
        dataIndex: 'isActive',
        hidden: isActiveHidden
    });
    var isApprovedGridDetail = new Ext.ux.grid.CheckColumn({
        header: isApprovedLabel,
        dataIndex: 'isApproved',
        hidden: isApprovedHidden
    });
    var isReviewGridDetail = new Ext.ux.grid.CheckColumn({
        header: isReviewLabel,
        dataIndex: 'isReview',
        hidden: isReviewHidden
    });
    var isPostGridDetail = new Ext.ux.grid.CheckColumn({
        header: isPostLabel,
        dataIndex: 'isPost',
        hidden: isPostHidden
    });
    Ext.util.Format.comboRenderer = function(combo) {
        return function(value) {
            var record = combo.findRecord(combo.valueField || combo.displayField, value);
            if (record) { // remove special character
                res = record.get(combo.displayField); // res = res.replace(/[^a-zA-Z 0-9]+/g, '-');
            } else { // res = ("hmm, not found:" + value);
                res = (value);
            }
            return res;
        };
    };
    var refundLedgerDetailColumnModel = [new Ext.grid.RowNumberer(), {
        dataIndex: 'generalLedgerChartOfAccountId',
        header: generalLedgerChartOfAccountForeignKeyLabel,
        width: 200,
        sortable: true,
        editor: generalLedgerChartOfAccountId,
        renderer: Ext.util.Format.comboRenderer(generalLedgerChartOfAccountId),
        hidden: false,
        jsonType: 'int'
    },
    {
        dataIndex: 'countryId',
        header: countryForeignKeyLabel,
        width: 200,
        sortable: true,
        editor: countryId,
        renderer: Ext.util.Format.comboRenderer(countryId),
        hidden: false,
        jsonType: 'int'
    },
    {
        dataIndex: 'transactionMode',
        header: transactionModeLabel,
        width: 200,
        sortable: true,
        editor: transactionMode,
        renderer: Ext.util.Format.comboRenderer(transactionMode)
    },
    {
        dataIndex: 'refundLedgerDetailAmount',
        header: refundLedgerDetailAmountLabel,
        width: 75,
        sortable: true,
        summaryType: 'sum',
        renderer: function(value) {
            return ' RM ' + Ext.util.Format.number(value, '0,0.00');
        },
        editor: {
            xtype: 'textfield',
            labelAlign: 'left',
            fieldLabel: refundLedgerDetailAmountLabel,
            hiddenName: 'refundLedgerDetailAmount',
            name: 'refundLedgerDetailAmount',
            id: 'refundLedgerDetailAmount',
            blankText: blankTextLabel,
            decimalPrecision: 2,
            vtype: 'dollar',
            anchor: '95%',
            listeners: {
                blur: function() {
                    var value = Ext.getCmp('refundLedgerDetailAmount').getValue();
                    value = value.replace(",", "");
                    value = Ext.util.Format.usMoney(value);
                    value = value.replace(" ", "");
                    Ext.getCmp('refundLedgerDetailAmount').setValue(value);
                }
            }
        }
    },
    isDefaultGridDetail, isNewGridDetail, isDraftGridDetail, isUpdateGridDetail, isDeleteGridDetail, isActiveGridDetail, isApprovedGridDetail, isReviewGridDetail, isPostGridDetail, {
        dataIndex: 'executeBy',
        header: executeByLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return record.data.staffName;
        }
    },
    {
        dataIndex: 'executeTime',
        header: executeTimeLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return Ext.util.Format.date(value, 'd-m-Y H:i:s');
        }
    }];
    var refundLedgerDetailEditor = new Ext.ux.grid.RowEditor({
        saveText: saveButtonLabel,
        cancelText: cancelButtonLabel,
        listeners: {
            cancelEdit: function(rowEditor, changes, record, rowIndex) {
                refundLedgerDetailStore.reload({
                    params: {
                        refundLedgerId: Ext.getCmp('refundLedgerId').getValue()
                    }
                });
            },
            afteredit: function(rowEditor, changes, record, rowIndex) {
                this.save = true;
                var record = this.grid.getStore().getAt(rowIndex);
                if (parseInt(record.get('refundLedgerDetailId')) == 'NaN') {
                    method = 'create';
                } else if (record.get('refundLedgerDetailId') == '') {
                    method = 'create';
                } else if (record.get('refundLedgerDetailId') == undefined) {
                    method = 'create';
                } else if (parseInt(record.get('refundLedgerDetailId')) > 0) {
                    method = 'save';
                } else {
                    method = 'create';
                }
                Ext.Ajax.request({
                    url: '../controller/refundLedgerDetailController.php',
                    method: 'POST',
                    params: {
                        leafId: leafId,
                        isAdmin: isAdmin,
                        method: method,
                        refundLedgerDetailId: record.get('refundLedgerDetailId'),
                        refundLedgerId: Ext.getCmp('refundLedgerId').getValue(),
                        generalLedgerChartOfAccountId: record.get('generalLedgerChartOfAccountId'),
                        transactionMode: record.get('transactionMode'),
                        countryId: record.get('countryId'),
                        refundLedgerDetailAmount: record.get('refundLedgerDetailAmount')
                    },
                    success: function(response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == false) {
                            Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                        } else {
                            refundLedgerDetailStore.reload({
                                params: {
                                    refundLedgerId: Ext.getCmp('refundLedgerId').getValue()
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
                            if (jsonResponse.tally == 0 && jsonResponse.trialBalance == 0 && jsonResponse.masterDetail == 0 ) {
                                Ext.getCmp('postButton').enable();
                            }
                        }
                    },
                    failure: function(response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + response.statusText);
                    }
                });
            }
        }
    });
    var refundLedgerDetailEntity = Ext.data.Record.create([{
        key: 'PRI',
        foreignKey: 'no',
        name: 'refundLedgerDetailId',
        type: 'int'
    },
    {
        key: 'MUL',
        foreignKey: 'yes',
        name: 'refundLedgerId',
        type: 'int'
    },
    {
        key: 'MUL',
        foreignKey: 'yes',
        name: 'generalLedgerChartOfAccountId',
        type: 'int'
    },
    {
        key: 'MUL',
        foreignKey: 'yes',
        name: 'countryId',
        type: 'int'
    },
    {
        key: '',
        foreignKey: 'no',
        name: 'refundLedgerDetailAmount',
        type: 'float'
    },
    {
        key: '',
        foreignKey: 'no',
        name: 'isDefault',
        type: 'boolean'
    },
    {
        key: '',
        foreignKey: 'no',
        name: 'isNew',
        type: 'boolean'
    },
    {
        key: '',
        foreignKey: 'no',
        name: 'isDraft',
        type: 'boolean'
    },
    {
        key: '',
        foreignKey: 'no',
        name: 'isUpdate',
        type: 'boolean'
    },
    {
        key: '',
        foreignKey: 'no',
        name: 'isDelete',
        type: 'boolean'
    },
    {
        key: '',
        foreignKey: 'no',
        name: 'isActive',
        type: 'boolean'
    },
    {
        key: '',
        foreignKey: 'no',
        name: 'isApproved',
        type: 'boolean'
    },
    {
        key: '',
        foreignKey: 'no',
        name: 'isReview',
        type: 'boolean'
    },
    {
        key: '',
        foreignKey: 'no',
        name: 'isPost',
        type: 'boolean'
    },
    {
        key: '',
        foreignKey: 'no',
        name: 'executeBy',
        type: 'int'
    },
    {
        key: '',
        foreignKey: 'no',
        name: 'executeTime',
        type: 'date',
        dateFormat: 'Y-m-d H:i:s'
    }]);
    var refundLedgerDetailFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
    var refundLedgerDetailGrid = new Ext.grid.GridPanel({
        name: 'refundLedgerDetailGrid',
        id: 'refundLedgerDetailGrid',
        border: false,
        store: refundLedgerDetailStore,
        height: 250,
        autoScroll: true,
        columns: refundLedgerDetailColumnModel,
        viewConfig: {
            autoFill: true,
            forceFit: true,
            emptyRow: emptyRowLabel
        },
        layout: 'fit',
        disabled: true,
        plugins: [refundLedgerDetailEditor],
        tbar: {
            items: [{
                xtype: 'button',
                iconCls: 'add',
                id: 'add_record',
                name: 'add_record',
                text: newButtonLabel,
                handler: function() {
                    var newRecord = new refundLedgerDetailEntity({
                        refundLedgerDetailId: '',
                        refundLedgerId: '',
                        generalLedgerChartOfAccountId: '',
                        countryId: '',
                        refundLedgerDetailAmount: '',
                        isDefault: '',
                        isNew: '',
                        isDraft: '',
                        isUpdate: '',
                        isDelete: '',
                        isActive: '',
                        isApproved: '',
                        isReview: '',
                        isPost: '',
                        executeBy: '',
                        executeTime: ''
                    });
                    refundLedgerDetailEditor.stopEditing();
                    refundLedgerDetailStore.insert(0, newRecord);
                    refundLedgerDetailGrid.getSelectionModel().getSelections();
                    refundLedgerDetailEditor.startEditing(0);
                }
            },
            {
                xtype: 'button',
                text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function(button, e) {
                        refundLedgerDetailStore.each(function(record, fn, scope) {
                            for (var access in refundLedgerDetailFlagArray) {
                                record.set(refundLedgerDetailFlagArray[access], true);
                            }
                        });
                    }
                }
            },
            {
                text: ClearAllLabel,
                iconCls: 'row-check-sprite-uncheck',
                listeners: {
                    'click': function(button, e) {
                        refundLedgerDetailStore.each(function(record, fn, scope) {
                            for (var access in refundLedgerDetailFlagArray) {
                                record.set(refundLedgerDetailFlagArray[access], false);
                            }
                        });
                    }
                }
            },
            {
                xtype: 'button',
                text: saveButtonLabel,
                iconCls: 'bullet_disk',
                listeners: {
                    'click': function(button, e) {
                        var url = '../controller/refundLedgerDetailController.php?';
                        var sub_url = '';
                        var modified = refundLedgerDetailStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            sub_url = sub_url + '&refundLedgerDetailId[]=' + modified[i].get('refundLedgerDetailId');
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
                            url: url,
                            method: 'GET',
                            params: {
                                leafId: leafId,
                                isAdmin: isAdmin,
                                refundLedgerId: Ext.getCmp('refundLedgerId').getValue(),
                                method: 'updateStatus'
                            },
                            success: function(response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse.success == true) {
                                    Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                    refundLedgerDetailStore.reload({
                                        params: {
                                            refundLedgerId: Ext.getCmp('refundLedgerId').getValue()
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
                            failure: function(response, options) {
                                Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                            }
                        });
                    }
                }
            },
            '-', {
                xtype: 'label',
                name: 'trialBalanceStatus',
                text: 'Trial Balance Status : '
            },
            '-', {
                xtype: 'label',
                name: 'tallyStatus',
                text: 'Tally Status : '
            }]
        },
        bbar: new Ext.PagingToolbar({
            store: refundLedgerDetailStore,
            pageSize: perPage
        }),
        view: new Ext.ux.grid.BufferView({
            rowHeight: 34,
            scrollDelay: false
        })
    });
    var formPanel = new Ext.form.FormPanel({
        url: '../controller/refundLedgerController.php',
        name: 'formPanel',
        id: 'formPanel',
        method: 'post',
        frame: true,
        title: leafNative,
        border: false,
        width: 600,
        items: [{
            xtype: 'panel',
            items: [{
                xtype: 'fieldset',
                layout: 'form',
                bodyStyle: 'padding:5px',
                border: true,
                frame: true,
                items: [refundLedgerId, refundTypeId,businessPartnerId,
                        invoiceCategoryId,
                        invoiceTypeId,
                        invoiceLedgerId, 
                {
                    layout: 'column',
                    border: false,
                    items: [{
                        columnWidth: .5,
                        layout: 'form',
                        border: false,
                        items: [refundLedgerTitle, refundLedgerDesc, refundLedgerDate, refundLedgerAmount, referenceNo]
                    },
                    {
                        columnWidth: .5,
                        layout: 'form',
                        border: false,
                        labelAlign: 'top',
                        items: [refundLedgerDesc]
                    }]
                }]
            }]
        },
        refundLedgerDetailGrid],
        buttonVAlign: 'top',
        buttonAlign: 'left',
        iconCls: 'application_form',
        bbar: new Ext.ux.StatusBar({
            id: 'form-statusbar',
            defaultText: defaultTextLabel,
            plugins: new Ext.ux.ValidationStatus({
                form: 'formPanel'
            })
        }),
        buttons: [{
            text: auditButtonLabel,
            name: 'auditButtonLabel',
            id: 'auditButtonLabel',
            type: 'button',
            iconCls: 'key',
            disabled: auditButtonLabelDisabled,
            handler: function() { // reload the store
                if (auditWindow) {
                    refundLedgerStore.reload();
                    refundLedgerDetailStore.reload();
                    auditWindow.show().center();
                }
            }
        },
        {
            text: newButtonLabel,
            name: 'newButton',
            id: 'newButton',
            type: 'button',
            iconCls: 'new',
            handler: function() {
                var method = 'create';
                formPanel.getForm().submit({
                    waitMsg: waitMessageLabel,
                    params: {
                        method: method,
                        leafId: leafId,
                        isAdmin: isAdmin
                    },
                    success: function(form, action) {
                        if (action.result.success == true) {
                            Ext.MessageBox.alert(systemLabel, action.result.message);
                            Ext.getCmp('refundLedgerDetailGrid').enable();
                            Ext.getCmp('newButton').disable();
                            Ext.getCmp('saveButton').enable();
                            Ext.getCmp('deleteButton').enable();
                            Ext.getCmp('refundLedgerId').setValue(action.result.refundLedgerId);
                            refundLedgerStore.reload({
                                params: {
                                    leafId: leafId,
                                    start: 0,
                                    limit: perPage
                                }
                            });
                        } else {
                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                        }
                    },
                    failure: function(form, action) {
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
        },
        {
            text: saveButtonLabel,
            name: 'saveButton',
            id: 'saveButton',
            iconCls: 'bullet_disk',
            disabled: true,
            handler: function() {
                var method = 'save';
                formPanel.getForm().submit({
                    waitMsg: waitMessageLabel,
                    params: {
                        method: method,
                        leafId: leafId,
                        refundLedgerId: Ext.getCmp('refundLedgerId').getValue()
                    },
                    success: function(form, action) {
                        if (action.result.success == true) {
                            Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                            Ext.getCmp('refundLedgerDetailGrid').enable();
                            Ext.getCmp('newButton').disable();
                            Ext.getCmp('saveButton').enable();
                            Ext.getCmp('deleteButton').enable();
                            refundLedgerStore.reload({
                                params: {
                                    leafId: leafId,
                                    start: 0,
                                    limit: perPage
                                }
                            });
                            Ext.getCmp('refundLedgerId').setValue(action.result.refundLedgerId);
                        } else {
                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                        }
                    },
                    failure: function(form, action) {
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
        },
        {
            text: deleteButtonLabel,
            type: 'button',
            name: 'deleteButton',
            id: 'deleteButton',
            iconCls: 'trash',
            disabled: true,
            handler: function() {
                Ext.Msg.show({
                    title: deleteRecordTitleMessageLabel,
                    msg: deleteRecordMessageLabel,
                    icon: Ext.Msg.QUESTION,
                    buttons: Ext.Msg.YESNO,
                    scope: this,
                    fn: function(response) {
                        if ('yes' == response) {
                            Ext.Ajax.request({
                                url: '../controller/refundLedgerController.php',
                                params: {
                                    method: 'delete',
                                    refundLedgerId: record.data.refundLedgerId,
                                    leafId: leafId,
                                    isAdmin: isAdmin
                                },
                                success: function(response, options) {
                                    jsonResponse = Ext.decode(response.responseText);
                                    if (jsonResponse.success == true) {
                                        Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                        refundLedgerStore.reload({
                                            params: {
                                                leafId: leafId,
                                                start: 0,
                                                limit: perPage
                                            }
                                        });
                                        Ext.getCmp('refundLedgerDetail').disable();
                                        Ext.getCmp('newButton').disable();
                                        Ext.getCmp('saveButton').disable();
                                        Ext.getCmp('nextButton').disable();
                                        Ext.getCmp('previousButton').disable();
                                        refundLedgerStore.reload({
                                            params: {
                                                leafId: leafId,
                                                start: 0,
                                                limit: perPage
                                            }
                                        });
                                    } else {
                                        Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                                    }
                                },
                                failure: function(response, options) {
                                    Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + response.statusText);
                                }
                            });
                        }
                    }
                });
            }
        },
        {
            text: resetButtonLabel,
            type: 'reset',
            name: 'resetButton',
            id: 'resetButton',
            iconCls: 'database_refresh',
            handler: function() {
                Ext.getCmp('newButton').enable();
                Ext.getCmp('saveButton').disable();
                Ext.getCmp('deleteButton').disable();
                Ext.getCmp('postButton').disable();
                Ext.getCmp('refundLedgerDetailGrid').disable();
                refundLedgerDetailGrid.store.removeAll();
                formPanel.getForm().reset();
            }
        },
        {
            text: postButtonLabel,
            type: 'button',
            name: 'postButton',
            id: 'postButton',
            iconCls: 'lock',
            disabled: true,
            handler: function() {
                
                Ext.Ajax.request({
                    url: '../controller/refundLedgerController.php',
                    method: 'POST',
                    params: {
                        method: 'posting',
                        leafId: leafId,
                        isAdmin: isAdmin,
                        refundLedgerId: Ext.getCmp('refundLedgerId').getValue()
                                                           				
                    },
                    success: function(response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == false) {
                            Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                        } else {
                        	Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                        	Ext.getCmp('newButton').disable();
                            Ext.getCmp('saveButton').disable();
                            Ext.getCmp('deleteButton').disable();
                            Ext.getCmp('postButton').disable();
                            Ext.getCmp('refundLedgerDetailGrid').disable();
                            formPanel.getForm().reset();
                            refundLedgerDetailGrid.store.removeAll();
                            refundLedgerStore.reload({
                                params: {
                                    leafId: leafId,
                                    start: 0,
                                    limit: perPage
                                }
                            });
                        }
                    },
                    failure: function(response, options) {
                        Ext.MessageBox.alert(systemLabel, escape(response.status) + ':' + escape(response.statusText));
                    }
                });
                formPanel.getForm().reset();
            }
        },
        {
            text: gridButtonLabel,
            type: 'button',
            name: 'gridButton',
            id: 'gridButton',
            iconCls: 'table',
            handler: function() {
                formPanel.getForm().reset();
                viewPort.items.get(0).expand();
            }
        },
        {
            text: firstButtonLabel,
            name: 'firstButton',
            id: 'firstButton',
            type: 'button',
            iconCls: 'resultset_first',
            handler: function() {
                Ext.getCmp('newButton').disable();
                if (Ext.getCmp('firstRecord').getValue() == '') {
                    Ext.Ajax.request({
                        url: '../controller/refundLedgerController.php',
                        method: 'GET',
                        params: {
                            method: 'dataNavigationRequest',
                            leafId: leafId,
                            dataNavigation: 'firstRecord'
                        },
                        success: function(response, options) {
                            jsonResponse = Ext.decode(response.responseText);
                            if (jsonResponse.success == true) {
                                Ext.getCmp('firstRecord').setValue(jsonResponse.firstRecord);
                                formPanel.form.load({
                                    url: '../controller/refundLedgerController.php',
                                    method: 'POST',
                                    waitTitle: systemLabel,
                                    waitMsg: waitMessageLabel,
                                    params: {
                                        method: 'read',
                                        refundLedgerId: Ext.getCmp('firstRecord').getValue(),
                                        leafId: leafId,
                                        isAdmin: isAdmin
                                    },
                                    success: function(form, action) {
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
                                            refundLedgerDetailStore.load({
                                                params: {
                                                    leafId: leafId,
                                                    isAdmin: isAdmin,
                                                    refundLedgerId: action.result.data.refundLedgerId
                                                }
                                            });
                                            refundLedgerDetailGrid.enable();
                                        } else {
                                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                                        }
                                    },
                                    failure: function(form, action) {
                                        Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                                    }
                                });
                            } else {
                                Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                            }
                        },
                        failure: function(response, options) {
                            Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                        }
                    });
                } else {
                    formPanel.form.load({
                        url: '../controller/refundLedgerController.php',
                        method: 'POST',
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: 'read',
                            refundLedgerId: Ext.getCmp('firstRecord').getValue(),
                            leafId: leafId,
                            isAdmin: isAdmin
                        },
                        success: function(form, action) {
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
                                refundLedgerDetailStore.load({
                                    params: {
                                        leafId: leafId,
                                        isAdmin: isAdmin,
                                        refundLedgerId: action.result.data.refundLedgerId
                                    }
                                });
                                refundLedgerDetailGrid.enable();
                            } else {
                                Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                            }
                        },
                        failure: function(form, action) {
                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                        }
                    });
                }
            }
        },
        {
            text: previousButtonLabel,
            name: 'previousButton',
            id: 'previousButton',
            type: 'button',
            iconCls: 'resultset_previous',
            disabled: true,
            handler: function() {
                Ext.getCmp('newButton').disable();
                if (Ext.getCmp('previousRecord').getValue() == '' || Ext.getCmp('previousRecord').getValue() == undefined) {
                    Ext.MessageBox.alert(systemErrorLabel, chooseRecordLabel);
                }
                if (Ext.getCmp('firstRecord').getValue() >= 1) {
                    formPanel.form.load({
                        url: '../controller/refundLedgerController.php',
                        method: 'POST',
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: 'read',
                            refundLedgerId: Ext.getCmp('previousRecord').getValue(),
                            leafId: leafId,
                            isAdmin: isAdmin
                        },
                        success: function(form, action) {
                            if (action.result.success == true) {
                                Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
                                Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
                                Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
                                Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
                                Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                                refundLedgerDetailStore.load({
                                    params: {
                                        leafId: leafId,
                                        isAdmin: isAdmin,
                                        refundLedgerId: action.result.data.refundLedgerId
                                    }
                                });
                                if (Ext.getCmp('previousRecord').getValue() == 0) {
                                    Ext.getCmp('previousButton').disable();
                                }
                                refundLedgerDetailGrid.enable();
                            } else {
                                Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                            }
                        },
                        failure: function(form, action) {
                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                        }
                    });
                } else {
                    Ext.MessageBox.alert(systemErrorLabel, recordNotFoundLabel);
                }
            }
        },
        {
            text: nextButtonLabel,
            name: 'nextButton',
            id: 'nextButton',
            type: 'button',
            disabled: true,
            iconCls: 'resultset_next',
            handler: function() {
                Ext.getCmp('newButton').disable();
                if (Ext.getCmp('nextRecord').getValue() == '' || Ext.getCmp('nextRecord').getValue() == undefined) {
                    Ext.MessageBox.alert(systemErrorLabel, chooseRecordLabel);
                }
                if (Ext.getCmp('nextRecord').getValue() <= Ext.getCmp('lastRecord').getValue()) {
                    formPanel.form.load({
                        url: '../controller/refundLedgerController.php',
                        method: 'POST',
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: 'read',
                            refundLedgerId: Ext.getCmp('nextRecord').getValue(),
                            leafId: leafId,
                            isAdmin: isAdmin
                        },
                        success: function(form, action) {
                            if (action.result.success == true) {
                                Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
                                Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
                                Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
                                Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
                                Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                                refundLedgerDetailStore.load({
                                    params: {
                                        leafId: leafId,
                                        isAdmin: isAdmin,
                                        refundLedgerId: action.result.data.refundLedgerId
                                    }
                                });
                                if (Ext.getCmp('nextRecord').getValue() > Ext.getCmp('lastRecord').getValue()) {
                                    Ext.getCmp('nextButton').disable();
                                }
                                if (Ext.getCmp('nextRecord').getValue() == 0) {
                                    Ext.getCmp('nextButton').disable();
                                }
                                Ext.getCmp('previousButton').enable();
                                refundLedgerDetailGrid.enable();
                            } else {
                                Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                            }
                        },
                        failure: function(form, action) {
                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                        }
                    });
                } else {
                    Ext.MessageBox.alert(systemErrorLabel, recordNotFoundLabel);
                }
            }
        },
        {
            text: endButtonLabel,
            name: 'endButton',
            id: 'endButton',
            type: 'button',
            iconCls: 'resultset_last',
            handler: function() {
                Ext.getCmp('newButton').disable();
                if (Ext.getCmp('lastRecord').getValue() == '' || Ext.getCmp('lastRecord').getValue() == undefined) {
                    Ext.Ajax.request({
                        url: '../controller/refundLedgerController.php',
                        method: 'GET',
                        params: {
                            method: 'dataNavigationRequest',
                            leafId: leafId,
                            dataNavigation: 'lastRecord'
                        },
                        success: function(response, options) {
                            jsonResponse = Ext.decode(response.responseText);
                            if (jsonResponse.success == true) {
                                Ext.getCmp('lastRecord').setValue(jsonResponse.lastRecord);
                                formPanel.form.load({
                                    url: '../controller/refundLedgerController.php',
                                    method: 'POST',
                                    waitTitle: systemLabel,
                                    waitMsg: waitMessageLabel,
                                    params: {
                                        method: 'read',
                                        refundLedgerId: Ext.getCmp('lastRecord').getValue(),
                                        leafId: leafId,
                                        isAdmin: isAdmin
                                    },
                                    success: function(form, action) {
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
                                            refundLedgerDetailStore.load({
                                                params: {
                                                    leafId: leafId,
                                                    isAdmin: isAdmin,
                                                    refundLedgerId: action.result.data.refundLedgerId
                                                }
                                            });
                                            Ext.getCmp('nextButton').disable();
                                            Ext.getCmp('previousButton').enable();
                                            refundLedgerDetailGrid.enable();
                                        } else {
                                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                                        }
                                    },
                                    failure: function(form, action) {
                                        Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                                    }
                                });
                            } else {
                                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                            }
                        },
                        failure: function(response, options) {
                            Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                        }
                    });
                }
                if (Ext.getCmp('refundLedgerId').getValue() <= Ext.getCmp('lastRecord').getValue()) {
                    formPanel.form.load({
                        url: '../controller/refundLedgerController.php',
                        method: 'POST',
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: 'read',
                            refundLedgerId: Ext.getCmp('lastRecord').getValue(),
                            leafId: leafId,
                            isAdmin: isAdmin
                        },
                        success: function(form, action) {
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
                                refundLedgerDetailStore.load({
                                    params: {
                                        leafId: leafId,
                                        isAdmin: isAdmin,
                                        refundLedgerId: action.result.data.refundLedgerId
                                    }
                                });
                                Ext.getCmp('nextButton').disable();
                                Ext.getCmp('previousButton').enable();
                                refundLedgerDetailGrid.enable();
                            } else {
                                Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                            }
                        },
                        failure: function(form, action) {
                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                        }
                    });
                } else {
                    Ext.MessageBox.alert(systemErrorLabel, recordNotFoundLabel);
                }
            }
        }]
    });
    var viewPort = new Ext.Viewport({
        name: 'viewport',
        id: 'viewport',
        region: 'center',
        layout: 'accordion',
        layoutConfig: { // layout-specific configs go here
            titleCollapse: true,
            animate: false,
            activeOnTop: true
        },
        items: [gridPanel, formPanel]
    });
});