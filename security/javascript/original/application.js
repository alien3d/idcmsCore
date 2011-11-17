Ext.onReady(function () {
    Ext.QuickTips.init();
    Ext.BLANK_IMAGE_URL = "../../javascript/resources/images/s.gif";
    Ext.form.Field.prototype.msgTarget = "under";
    Ext.Ajax.timeout = 90000;
    var perPage = 15;
    var encode = false;
    var local = false;
    var jsonResponse;
    var duplicate = 0;
     // common Proxy,Reader,Store,Filter,Grid
    // start Staff Request
    var staffByProxy = new Ext.data.HttpProxy({
        url: "../controller/applicationController.php?",
        method: "GET",
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var staffByReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "staffId"
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
        fields: [{
            name: "staffId",
            type: "int"
        }, {
            name: "staffName",
            type: "string"
        }]
    }); // end Staff Request
    // start log Request
    var logProxy = new Ext.data.HttpProxy({
        url: "../../security/controller/logController.php?",
        method: "POST",
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var logReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "logId"
    });
    var logStore = new Ext.data.JsonStore({
        proxy: logProxy,
        reader: logReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: "read",
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
        }, {
            name: 'leafId',
            type: 'int'
        }, {
            name: 'operation',
            type: 'string'
        }, {
            name: 'sql',
            type: 'string'
        }, {
            name: 'date',
            type: 'date',
            dateFormat: 'Y-m-d'
        }, {
            name: 'staffId',
            type: 'int'
        }, {
            name: 'access',
            type: 'string'
        }, {
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
        }, {
            type: 'numeric',
            dataIndex: 'leafId',
            column: 'leafId',
            table: 'log'
        }, {
            type: 'string',
            dataIndex: 'operation',
            column: 'operation',
            table: 'log'
        }, {
            type: 'string',
            dataIndex: 'sql',
            column: 'sql',
            table: 'log'
        }, {
            type: 'date',
            dataIndex: 'date',
            column: 'date',
            table: 'log'
        }, {
            type: 'numeric',
            dataIndex: 'staffId',
            column: 'staffId',
            table: 'log'
        }, {
            type: 'string',
            dataIndex: 'access',
            column: 'access',
            table: 'log'
        }, {
            type: 'string',
            dataIndex: 'logError',
            column: 'logError',
            table: 'log'
        }]
    });
    var logExpander = new Ext.ux.grid.RowExpander({
        tpl: new Ext.Template('<br><p><b>Operation:</b> {operation}</p><br>', '<p><b>SQL STATEMENT:</b> {sql}</p><br>')
    });
    var logColumnModel = [logExpander, new Ext.grid.RowNumberer(),
    {
        dataIndex: 'logId',
        header: logIdLabel,
        sortable: true,
        hidden: false
    }, {
        dataIndex: 'leafId',
        header: leafIdLabel,
        sortable: true,
        hidden: false
    }, {
        dataIndex: 'operation',
        header: operationLabel,
        sortable: true,
        hidden: false
    }, {
        dataIndex: 'sql',
        header: sqlLabel,
        sortable: true,
        hidden: false
    }, {
        dataIndex: 'date',
        header: dateLabel,
        sortable: true,
        hidden: false
    }, {
        dataIndex: 'staffId',
        header: staffIdLabel,
        sortable: true,
        hidden: false
    }, {
        dataIndex: 'access',
        header: accessLabel,
        sortable: true,
        hidden: false
    }, {
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
        sm: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            emptyText: emptyRowLabel
        },
        iconCls: 'application_view_detail',
        listeners: {
            render: {
                fn: function () {
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
        url: "../../security/controller/logAdvanceController.php?",
        method: "POST",
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var logAdvanceReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "logAdvanceId"
    });
    var logAdvanceStore = new Ext.data.JsonStore({
        proxy: logAdvanceProxy,
        reader: logAdvanceReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        method: 'POST',
        baseParams: {
            method: "read",
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
        }, {
            name: 'logAdvanceText',
            type: 'string'
        }, {
            name: 'logAdvanceType',
            type: 'string'
        }, {
            name: 'logAdvanceComparison',
            type: 'string'
        }, {
            name: 'refTableName',
            type: 'int'
        }, {
            name: 'leafId',
            type: 'int'
        }]
    });
    var  logAdvanceFilters = new Ext.ux.grid.GridFilters({
        encode: encode,
        local: local,
        filters: [{
            type: 'numeric',
            dataIndex: 'logAdvanceId',
            column: 'logAdvanceId',
            table: 'logAdvance'
        }, {
            type: 'string',
            dataIndex: 'logAdvanceText',
            column: 'logAdvanceText',
            table: 'logAdvance'
        }, {
            type: 'string',
            dataIndex: 'logAdvanceType',
            column: 'logAdvanceType',
            table: 'logAdvance'
        }, {
            type: 'string',
            dataIndex: 'logAdvanceComparison',
            column: 'logAdvanceComparison',
            table: 'logAdvance'
        }, {
            type: 'numeric',
            dataIndex: 'refTableName',
            column: 'refTableName',
            table: 'logAdvance'
        }, {
            type: 'list',
            dataIndex: 'executeBy',
            column: 'executeBy',
            table: 'logAdvance',
            labelField: 'staffName',
            store: staffByStore,
            phpMode: true
        }, {
            type: 'date',
            dataIndex: 'executeTime',
            column: 'executeTime',
            table: 'logAdvance'
        }]
    });
    var logAdvanceColumnModel = [new Ext.grid.RowNumberer(),
    {
        dataIndex: 'logAdvanceId',
        header: logAdvanceIdLabel,
        sortable: true,
        hidden: false
    }, {
        dataIndex: 'logAdvanceText',
        header: logAdvanceTextLabel,
        sortable: true,
        hidden: false
    }, {
        dataIndex: 'logAdvanceType',
        header: logAdvanceTypeLabel,
        sortable: true,
        hidden: false
    }, {
        dataIndex: 'logAdvanceComparision',
        header: logAdvanceComparisionLabel,
        sortable: true,
        hidden: false
    }, {
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
        plugins: [ logAdvanceFilters],
        sm: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            forceFit: true,
            emptyText: emptyRowLabel
        },
        iconCls: 'application_view_detail',
        listeners: {
            render: {
                fn: function () {
                    logAdvanceStore.load({
                        params: {
                            start: 0,
                            limit: perPage,
                            method: 'read',
                            mode: 'view',
                            plugin: [ logAdvanceFilters]
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
    // popup  window for normal log and advance log
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
                layout: "fit",
                title: 'Log Sql Statement',
                items: [logGrid]
            }, {
                xtype: 'panel',
                layout: "fit",
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
    // start Team Request
    var teamProxy = new Ext.data.HttpProxy({
        url: '../controller/applicationAccessController.php',
        method: 'GET',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var teamReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'teamId'
    });
    var teamStore = new Ext.data.JsonStore({
        proxy: teamProxy,
        reader: teamReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: 'read',
            field: 'teamId',
            leafId: leafId
        },
        root: 'team',
        fields: [{
            name: 'teamId',
            type: 'int'
        }, {
            name: 'teamEnglish',
            type: 'string'
        }]
    }); // end team Request
 // start Language Request
    var languageProxy = new Ext.data.HttpProxy({
        url: '../../translation/controller/languageController.php',
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message); uncommen for testing purpose
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var languageReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'languageId'
    });
    var languageStore = new Ext.data.JsonStore({
        proxy: languageProxy,
        reader: languageReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: 'read',
            field: 'languageId',
            leafId: leafId
        },
        root: 'data',
        fields: [{
            name: 'languageId',
            type: 'int'
        },
        
        {
            name: 'languageCode',
            type: 'string'
        },
        
        {
            name: 'languageDesc',
            type: 'string'
        }]
    });
    // end Language Request
    // end additional Proxy ,Reader,Store,Filter,Grid
    // start application Proxy ,Reader,Store,Filter,Grid
    var applicationProxy = new Ext.data.HttpProxy({
        url: "../controller/applicationController.php",
        method: 'POST',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var applicationReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "applicationId"
    });
    var applicationStore = new Ext.data.JsonStore({
        proxy: applicationProxy,
        reader: applicationReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: "read",
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            perPage: perPage
        },
        root: "data",
        fields: [{
            name: 'applicationId',
            type: 'int'
        }, {
            name: 'applicationSequence',
            type: 'int'
        }, {
            name: 'applicationEnglish',
            type: 'string'
        }, {
            name: 'iconId',
            type: 'int'
        }, {
            name: 'iconName',
            type: 'string'
        }, {
            name: "isDefault",
            type: "boolean"
        }, {
            name: "isNew",
            type: "boolean"
        }, {
            name: "isDraft",
            type: "boolean"
        }, {
            name: "isUpdate",
            type: "boolean"
        }, {
            name: "isDelete",
            type: "boolean"
        }, {
            name: "isActive",
            type: "boolean"
        }, {
            name: "isApproved",
            type: "boolean"
        }, {
            name: 'executeBy',
            type: 'int'
        }, {
            name: "executeTime",
            type: "date",
            dateFormat: "Y-m-d H:i:s"
        }]
    });
    var applicationTranslateProxy = new Ext.data.HttpProxy({
        url: "../controller/applicationController.php",
        method: 'POST',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var applicationTranslateReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "applicationTranslateId"
    });
    var applicationTranslateStore = new Ext.data.JsonStore({
        proxy: applicationTranslateProxy,
        reader: applicationTranslateReader,
        autoDestroy: true,
        pruneModifiedRecords: true,
        root: "data",
        baseParams: {
            method: "read",
            leafId: leafId,
            isAdmin: isAdmin
        },
        fields: [{
            name: 'applicationTranslateId',
            type: 'int'
        }, {
            name: 'applicationId',
            type: 'int'
        }, {
            name: 'languageId',
            type: 'int'
        }, {
            name: 'languageCode',
            type: 'string'
        }, {
            name: 'languageDesc',
            type: 'string'
        }, {
            name: 'applicationNative',
            type: 'string'
        }]
    });
    var staffByProxy = new Ext.data.HttpProxy({
        url: "../controller/applicationController.php?",
        method: "GET",
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var staffByReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "staffId"
    });
    var staffByStore = new Ext.data.JsonStore({
        proxy: staffByProxy,
        reader: staffByReader,
        autoLoad: true,
        autoDestroy: true,
        baseParams: {
            method: 'read',
            field: 'staffId',
            leafId: leafId
        },
        root: 'staff',
        fields: [{
            name: "staffId",
            type: "int"
        }, {
            name: "staffName",
            type: "string"
        }]
    });
    var teamProxy = new Ext.data.HttpProxy({
        url: "../controller/applicationAccessController.php",
        method: 'GET',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var teamReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "teamId"
    });
    var teamStore = new Ext.data.JsonStore({
        proxy: teamProxy,
        reader: teamReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: "read",
            field: "teamId",
            leafId: leafId
        },
        root: 'team',
        fields: [{
            name: 'teamId',
            type: 'int'
        }, {
            name: 'teamEnglish',
            type: 'string'
        }]
    });
    var logProxy = new Ext.data.HttpProxy({
        url: "../../security/controller/logController.php?",
        method: "POST",
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var logReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "logId"
    });
    var logStore = new Ext.data.JsonStore({
        proxy: logProxy,
        reader: logReader,
        autoLoad: true,
        autoDestroy: true,
        baseParams: {
            method: "read",
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
        }, {
            name: 'leafId',
            type: 'int'
        }, {
            name: 'operation',
            type: 'string'
        }, {
            name: 'sql',
            type: 'string'
        }, {
            name: 'date',
            type: 'date',
            dateFormat: 'Y-m-d'
        }, {
            name: 'staffId',
            type: 'int'
        }, {
            name: 'access',
            type: 'string'
        }, {
            name: 'logError',
            type: 'string'
        }]
    });
    var logAdvanceProxy = new Ext.data.HttpProxy({
        url: "../../security/controller/logAdvanceController.php?",
        method: "POST",
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var logAdvanceReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "logAdvanceId"
    });
    var logAdvanceStore = new Ext.data.JsonStore({
        proxy: logAdvanceProxy,
        reader: logAdvanceReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: "read",
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
        }, {
            name: 'logAdvanceText',
            type: 'string'
        }, {
            name: 'logAdvanceType',
            type: 'string'
        }, {
            name: 'logAdvanceComparison',
            type: 'string'
        }, {
            name: 'refTableName',
            type: 'int'
        }, {
            name: 'leafId',
            type: 'int'
        }]
    });
    var applicationFilters = new Ext.ux.grid.GridFilters({
        encode: encode,
        local: local,
        filters: [{
            type: 'numeric',
            dataIndex: 'applicationSequence',
            column: 'applicationSequence',
            application: 'application'
        }, {
            type: 'numeric',
            dataIndex: 'applicationCode',
            column: 'applicationCode',
            application: 'application'
        }, {
            type: 'string',
            dataIndex: 'applicationEnglish',
            column: 'applicationEnglish',
            application: 'application'
        }, {
            type: 'string',
            dataIndex: 'iconId',
            column: 'iconId',
            application: 'application'
        }, {
            type: "list",
            dataIndex: "executeBy",
            column: "executeBy",
            application: "application",
            labelField: "staffName",
            store: staffByStore,
            phpMode: true
        }, {
            type: 'date',
            dateFormat: 'Y-m-d H:i:s',
            dataIndex: 'executeTime',
            column: 'executeTime',
            application: 'application'
        }]
    });
    var isDefaultGrid = new Ext.ux.grid.CheckColumn({
        header: isDefaultLabel,
        dataIndex: 'isDefault',
        hidden: isDefaultHidden
    });
    var isNewGrid = new Ext.ux.grid.CheckColumn({
        header: isNewLabel,
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
        header: isPostLabel,
        dataIndex: 'isPost',
        hidden: isPostHidden
    });
    var applicationColumnModel = [new Ext.grid.RowNumberer(),
    {
        dataIndex: "applicationSequence",
        header: applicationSequenceLabel,
        hidden: false,
        width: 50
    }, {
        dataIndex: "applicationEnglish",
        header: applicationEnglishLabel,
        hidden: false,
        width: 100
    }, {
        dataIndex: 'iconName',
        header: iconNameLabel,
        hidden: false,
        width: 50,
        renderer: function (value, metaData, record, rowIndex, colIndex, store) {
            iconLength = value;
            if (iconLength.length == 0) {
                value = 'cog';
            }
            return '<img src=\'../../javascript/resources/images/icon/' + value + '.png\' width=\'12\' height=\'12\'> ' + value;
        }
    },
    isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid, isDeleteGrid, isActiveGrid, isApprovedGrid, isReviewGrid, isPostGrid,
    {
        dataIndex: 'executeBy',
        header: executeByLabel,
        hidden: true,
        width: 100
    }, {
        dataIndex: 'executeTime',
        header: executeTimeLabel,
        type: 'date',
        hidden: true,
        width: 100
    }];
    var applicationTranslateColumnModel = [new Ext.grid.RowNumberer(),
    {
        dataIndex: "applicationEnglish",
        header: applicationSequenceLabel,
        sortable: true,
        hidden: true,
        width: 50
    }, {
        dataIndex: "languageCode",
        header: "languageCode",
        sortable: true,
        hidden: false,
        width: 100
    }, {
        dataIndex: "languageDesc",
        header: "languageDesc",
        sortable: true,
        hidden: false,
        width: 100
    }, {
        dataIndex: "applicationNative",
        header: "applicationNative",
        sortable: true,
        hidden: false,
        width: 100,
        editor: {
            xtype: 'textfield',
            id: 'applicationNative'
        }
    }];
    var applicationFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
    var applicationGrid = new Ext.grid.GridPanel({
        name: 'applicationGrid',
        id: 'applicationGrid',
        border: false,
        store: applicationStore,
        autoHeight: false,
        columns: applicationColumnModel,
        loadMask: true,
        plugins: [applicationFilters],
        selModel: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            forceFit: true,
            emptyText: emptyTextLabel
        },
        iconCls: 'application_view_detail',
        listeners: {
            'rowclick': function (object, rowIndex, e) {
                var record = applicationStore.getAt(rowIndex);
                formPanel.getForm().reset();
                formPanel.form.load({
                    url: "../controller/applicationController.php",
                    method: "POST",
                    waitTitle: systemLabel,
                    waitMsg: waitMessageLabel,
                    params: {
                        method: "read",
                        mode: "update",
                        applicationId: record.data.applicationId,
                        leafId: leafId
                    },
                    success: function (form, action) {
                        Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
                        Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
                        Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
                        Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
                        Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                        if (Ext.getCmp('previousRecord').getValue() == 0) {
                            Ext.getCmp('previousButton').disable();
                        }
                        if (Ext.getCmp('nextRecord').getValue() == 0) {
                            Ext.getCmp('nextButton').disable();
                        }
                        viewPort.items.get(1).expand();
                    },
                    failure: function (form, action) {
                        Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                    }
                });
                Ext.getCmp('applicationTranslateGrid').enable();
                Ext.getCmp('applicationAccessGrid').enable();
                applicationTranslateStore.load({
                    params: {
                        method: 'read',
                        applicationId: record.data.applicationId,
                        leafId: leafId,
                        isAdmin: isAdmin
                    }
                });
                applicationAccessStore.load({
                    params: {
                        method: 'read',
                        applicationId: record.data.applicationId,
                        leafId: leafId,
                        isAdmin: isAdmin
                    }
                });
            }
        },
        tbar: {
            items: [{
                xtype: 'button',
                text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function (button, e) {
                        applicationStore.each(function (record,fn,scope) {
                            for (var access in accessArray) {
                                record.set(accessArray[access], true);
                            }
                        });
                    }
                }
            }, {
                xtype: 'button',
                text: ClearAllLabel,
                iconCls: 'row-check-sprite-uncheck',
                listeners: {
                    'click': function (button, e) {
                        applicationStore.each(function (record,fn,scope) {
                            for (var access in accessArray) {
                                record.set(accessArray[access], false);
                            }
                        });
                    }
                }
            }, {
                xtype: 'button',
                text: saveButtonLabel,
                iconCls: 'bullet_disk',
                listeners: {
                    'click': function (button, e) {
                        var url = '../controller/applicationController.php?';
                        var sub_url = '';
                        var modified = applicationStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            var record = applicationStore.getAt(i);
                            sub_url = sub_url + '&applicationId[]=' + record.get('applicationId');
                            if (isAdmin == 1) {
                                if (dataChanges.isDefault == true || dataChanges.isDefault == false) {
                                    sub_url = sub_url + '&isDefault[]=' +modified[i].get('isDefault');
                                }
                                if (dataChanges.isDraft == true || dataChanges.isDraft == false) {
                                    sub_url = sub_url + '&isDraft[]=' +modified[i].get('isDraft');
                                }
                                if (dataChanges.isNew == true || dataChanges.isNew == false) {
                                    sub_url = sub_url + '&isNew[]=' +modified[i].get('isNew');
                                }
                                if (dataChanges.isUpdate == true || dataChanges.isUpdate == false) {
                                    sub_url = sub_url + '&isUpdate[]=' +modified[i].get('isUpdate');
                                }
                            }
                            if (dataChanges.isDelete == true || dataChanges.isDelete == false) {
                                sub_url = sub_url + '&isDelete[]=' +modified[i].get('isDelete');
                            }
                            if (isAdmin == 1) {
                                if (dataChanges.isActive == true || dataChanges.isActive == false) {
                                    ssub_url = sub_url + '&isActive[]=' +modified[i].get('isActive');
                                }
                                if (dataChanges.isApproved == true || dataChanges.isApproved == false) {
                                    sub_url = sub_url + '&isApproved[]=' +modified[i].get('isApproved');
                                }
                                if (dataChanges.isReview == true || dataChanges.isReview == false) {
                                    sub_url = sub_url + '&isReview[]=' +modified[i].get('isReview');
                                }
                                if (dataChanges.isPost == true || dataChanges.isPost == false) {
                                    sub_url = sub_url + '&isPost[]=' +modified[i].get('isPost');
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
                                method: 'update'
                            },
                            success: function (response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse.success == true) {
                                    Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                    applicationStore.reload();
                                } else if (jsonResponse.success == false) {
                                    Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                                }
                            },
                            failure: function (response, options) {
                                Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + escape(response.statusText));
                            }
                        });
                    }
                }
            }]
        },
        bbar: new Ext.PagingToolbar({
            store: applicationStore,
            pageSize: perPage
        })
    });
    // end  header Application Request
    // start detail application translate request
    var applicationTranslateProxy = new Ext.data.HttpProxy({
        url: '../controller/applicationTranslateController.php',
        method: 'POST',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var applicationTranslateReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'applicationTranslateId'
    });
    var applicationTranslateStore = new Ext.data.JsonStore({
        proxy: applicationTranslateProxy,
        reader: applicationTranslateReader,
        autoDestroy: true,
        pruneModifiedRecords: true,
        root: 'data',
        baseParams: {
            method: 'read',
            leafId: leafId,
            isAdmin: isAdmin
        },
        fields: [{
            name: 'applicationTranslateId',
            type: 'int'
        }, {
            name: 'applicationId',
            type: 'int'
        }, {
            name: 'languageId',
            type: 'int'
        }, {
            name: 'languageCode',
            type: 'string'
        }, {
            name: 'languageDesc',
            type: 'string'
        }, {
            name: 'applicationNative',
            type: 'string'
        }]
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
    var applicationTranslateColumnModel = [new Ext.grid.RowNumberer(),{
		header : 'language',
		width : 100,
		sortable : true,
		dataIndex : 'languageId',
		editor : languageId,
		renderer : Ext.util.Format.comboRenderer(languageId),
		hidden : false
	},
    {
        dataIndex: 'applicationEnglish',
        header: applicationSequenceLabel,
        sortable: true,
        hidden: true,
        width: 50
    }, {
        dataIndex: 'languageCode',
        header: 'languageCode',
        sortable: true,
        hidden: false,
        width: 100
    }, {
        dataIndex: 'languageDesc',
        header: 'languageDesc',
        sortable: true,
        hidden: false,
        width: 100
    }, {
        dataIndex: 'applicationNative',
        header: 'applicationNative',
        sortable: true,
        hidden: false,
        width: 100,
        editor: {
            xtype: 'textfield',
            id: 'applicationNative'
        }
    }, {
        name: 'isDefault',
        type: 'boolean'
    }, {
        name: 'isNew',
        type: 'boolean'
    }, {
        name: 'isDraft',
        type: 'boolean'
    }, {
        name: 'isUpdate',
        type: 'boolean'
    }, {
        name: 'isDelete',
        type: 'boolean'
    }, {
        name: 'isActive',
        type: 'boolean'
    }, {
        name: 'isApproved',
        type: 'boolean'
    }, {
        name: 'executeBy',
        type: 'int'
    }, {
        name: 'executeTime',
        type: 'date',
        dateFormat: 'Y-m-d H:i:s'
    }];
    var applicationTranslateEditor = new Ext.ux.grid.RowEditor({
        saveText: saveButtonLabel,
        cancelText: cancelButtonLabel,
        listeners: {
            cancelEdit: function (rowEditor, changes, record, rowIndex) {
                applicationStore.reload();
            },
            afteredit: function (rowEditor, changes, record, rowIndex) {
                this.save = true;
                var record = this.grid.getStore().getAt(rowIndex);
                var record = this.grid.getStore().getAt(
						rowIndex);
				if (parseInt(record.get('applicationTranslateId')) == 'NaN') {
                    method = 'create';
                } else if (record.get('applicationTranslateId') == '') {
                    method = 'create';
                } else if (record.get('applicationTranslateId') == undefined) {
                    method = 'create';
                } else if (record.get('applicationTranslateId') > 0) {
                    method = 'save';
                } else {
                    method = 'create';
                }
                Ext.Ajax.request({
                    url: '../controller/applicationTranslateController.php',
                    method: 'POST',
                    params: {
                        leafId: leafId,
                        isAdmin: isAdmin,
                        method: 'save',
                        applicationTranslateId: record.get('applicationTranslateId'),
                        languageId:record.get('languageId'),
                        applicationNative: record.get('applicationNative')
                    },
                    success: function (response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == false) {
                            Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                        }
                    },
                    failure: function (response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + response.statusText);
                    }
                });
            }
        }
    });
    var applicationTranslateEntity = Ext.data.Record.create([{
        name: 'applicationTranslateId',
        type: 'int'
    }, {
        name: 'applicationId',
        type: 'int'
    }, {
        name: 'aplicationNative',
        type: 'string'
    }, {
        name: 'languageId',
        type: 'int'
    }, {
        name: 'executeBy',
        type: 'int'
    }, {
        name: 'staffName',
        type: 'string'
    }, {
        name: 'isDefault',
        type: 'boolean'
    }, {
        name: 'isNew',
        type: 'boolean'
    }, {
        name: 'isDraft',
        type: 'boolean'
    }, {
        name: 'isUpdate',
        type: 'boolean'
    }, {
        name: 'isDelete',
        type: 'boolean'
    }, {
        name: 'isActive',
        type: 'boolean'
    }, {
        name: 'isApproved',
        type: 'boolean'
    }, {
        name: 'isReview',
        type: 'boolean'
    }, {
        name: 'isPost',
        type: 'boolean'
    }, {
        name: 'executeTime',
        type: 'date',
        dateFormat: 'Y-m-d H:i:s'
    }]);
    var applicationTranslateFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
    var applicationTranslateGrid = new Ext.grid.GridPanel({
        name: 'applicationTranslateGrid',
        id: 'applicationTranslateGrid',
        border: false,
        store: applicationTranslateStore,
        height: 250,
        autoScroll: true,
        columns: applicationTranslateColumnModel,
        viewConfig: {
            autoFill: true,
            forceFit: true
        },
        layout: 'fit',
        disabled: true,
        plugins: [applicationTranslateEditor],
        tbar: {
            items: [{
                xtype: 'button',
                iconCls: 'add',
                id: 'add_record',
                name: 'add_record',
                text: newButtonLabel,
                handler: function () {
                    var newRecord = new applicationTranslateEntity({
                        applicationTranslateId: '',
                        applicationId: '',
                        applicationNative: '',
                        languageId: '',
                        executeBy: '',
                        staffName: '',
                        isDefault: '',
                        isNew: '',
                        isDraft: '',
                        isUpdate: '',
                        isReview: '',
                        isPost: '',
                        isDelete: '',
                        isActive: '',
                        isApproved: '',
                        executeTime: ''
                    });
                    applicationTranslateEditor.stopEditing();
                    applicationTranslateStore.insert(0, newRecord);
                    applicationTranslateGrid.getSelectionModel().getSelections();
                    applicationTranslateEditor.startEditing(0);
                }
            }, {
                xtype: 'button',
                text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function (button, e) {
                        applicationTranslateStore.each(function (record,fn,scope) {
                            for (var access in applicationTranslateFlagArray) {
                                record.set(applicationTranslateFlagArray[access], true);
                            }
                        });
                    }
                }
            }, {
                text: ClearAllLabel,
                iconCls: 'row-check-sprite-uncheck',
                listeners: {
                    'click': function (button, e) {
                        applicationTranslateStore.each(function (record,fn,scope) {
                            for (var access in applicationTranslateFlagArray) {
                                record.set(applicationTranslateFlagArray[access], false);
                            }
                        });
                    }
                }
            }, {
                xtype: 'button',
                text: saveButtonLabel,
                iconCls: 'bullet_disk',
                listeners: {
                    'click': function (button, e) {
                        var url = '../controller/applicationTranslateController.php?';
                        var sub_url = '';
                        var modified = applicationTranslateStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            sub_url = sub_url + '&applicationTranslateId[]=' + modified[i].get('applicationTranslateId');
                            if (isAdmin == 1) {
                                if (dataChanges.isDefault == true || dataChanges.isDefault == false) {
                                    sub_url = sub_url + '&isDefault[]=' +modified[i].get('isDefault');
                                }
                                if (dataChanges.isDraft == true || dataChanges.isDraft == false) {
                                    sub_url = sub_url + '&isDraft[]=' +modified[i].get('isDraft');
                                }
                                if (dataChanges.isNew == true || dataChanges.isNew == false) {
                                    sub_url = sub_url + '&isNew[]=' +modified[i].get('isNew');
                                }
                                if (dataChanges.isUpdate == true || dataChanges.isUpdate == false) {
                                    sub_url = sub_url + '&isUpdate[]=' +modified[i].get('isUpdate');
                                }
                            }
                            if (dataChanges.isDelete == true || dataChanges.isDelete == false) {
                                sub_url = sub_url + '&isDelete[]=' +modified[i].get('isDelete');
                            }
                            if (isAdmin == 1) {
                                if (dataChanges.isActive == true || dataChanges.isActive == false) {
                                    ssub_url = sub_url + '&isActive[]=' +modified[i].get('isActive');
                                }
                                if (dataChanges.isApproved == true || dataChanges.isApproved == false) {
                                    sub_url = sub_url + '&isApproved[]=' +modified[i].get('isApproved');
                                }
                                if (dataChanges.isReview == true || dataChanges.isReview == false) {
                                    sub_url = sub_url + '&isReview[]=' +modified[i].get('isReview');
                                }
                                if (dataChanges.isPost == true || dataChanges.isPost == false) {
                                    sub_url = sub_url + '&isPost[]=' +modified[i].get('isPost');
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
                            success: function (response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse.success == true) {
                                    Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                    applicationTranslateStore.reload();
                                } else if (jsonResponse.success == false) {
                                    Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                                }
                            },
                            failure: function (response, options) {
                                Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                            }
                        }); 
                    }
                }
            }]
        },
        bbar: new Ext.PagingToolbar({
            store: applicationTranslateStore,
            pageSize: perPage
        }),
        view: new Ext.ux.grid.BufferView({
            rowHeight: 34,
            scrollDelay: false
        })
    });
    // end Application Translation Request
    // start Application Access Request
    var applicationAccessProxy = new Ext.data.HttpProxy({
        url: '../controller/applicationAccessController.php',
        method: 'POST',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var applicationAccessReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'applicationAccessId'
    });
    var applicationAccessStore = new Ext.data.JsonStore({
        autoDestroy: true,
        proxy: applicationAccessProxy,
        reader: applicationAccessReader,
        baseParams: {
            method: 'read',
            isAdmin: isAdmin,
            leafId: leafId
        },
        root: 'data',
        fields: [{
            name: 'applicationId',
            type: 'int'
        }, {
            name: 'applicationEnglish',
            type: 'string'
        }, {
            name: 'teamId',
            type: 'int'
        }, {
            name: 'teamEnglish',
            type: 'string'
        }, {
            name: 'applicationId',
            type: 'int'
        }, {
            name: 'applicationAccessId',
            type: 'int'
        }, {
            name: 'applicationEnglish',
            type: 'string'
        }, {
            name: 'applicationAccessValue',
            type: 'boolean'
        }]
    });
    
    var applicationAccessValue = new Ext.ux.grid.CheckColumn({
        header: 'Access',
        dataIndex: 'applicationAccessValue'
    });
    var applicationAccessColumnModel = new Ext.grid.ColumnModel({
        columns: [{
            header: 'team',
            dataIndex: 'teamEnglish'
        },
        {
            header: applicationEnglishLabel,
            dataIndex: 'applicationEnglish'
        },
        applicationAccessValue]
    });
    var applicationAccessArray = ['applicationAccessValue'];
    var applicationAccessGrid = new Ext.grid.GridPanel({
        name: 'applicationAccessGrid',
        id: 'applicationAccessGrid',
        region: 'west',
        store: applicationAccessStore,
        columns: applicationAccessColumnModel,
        frame: true,
        title: 'Application Access Grid',
        autoHeight: true,
        disabled: true,
        selModel: applicationAccessValue,
        iconCls: 'application_view_detail',
        viewConfig: {
            forceFit: true,
            emptyText: emptyTextLabel
        },
        tbar: {
            items: [{
                xtype: 'button',
                text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function (button, e) {
                        applicationAccessStore.each(function (record,fn,scope) {
                            for (var access in applicationAccessArray) {
                                record.set(applicationAccessArray[access], true);
                            }
                        });
                    }
                }
            }, {
                xtype: 'button',
                text: ClearAllLabel,
                iconCls: 'row-check-sprite-uncheck',
                listeners: {
                    'click': function (button, e) {
                        applicationAccessStore.each(function (record,fn,scope) {
                            for (var access in applicationAccessArray) {
                                record.set(applicationAccessArray[access], false);
                            }
                        });
                    }
                }
            }, {
                xtype: 'button',
                text: saveButtonLabel,
                iconCls: 'bullet_disk',
                listeners: {
                    'click': function (button, e) {
                        var url = '../controller/applicationAccessController.php?method=update&leafId=' + leafId;
                        var sub_url = '';
                        var modified = applicationAccessStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            var record = applicationAccessStore.getAt(i);
                            sub_url = sub_url + '&applicationAccessId[]=' + record.get('applicationAccessId');
                            if (dataChanges.applicationAccessId == true || dataChanges.applicationAccessId == false) {
                                sub_url = sub_url + '&applicationAccessValue[]=' + record.get('applicationAccessValue');
                            }
                        }
                        url = url + sub_url;
                        Ext.Ajax.request({
                            url: url,
                            success: function (response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse == true) {
                                    Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                } else if (jsonResponse == false) {
                                    Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                                }
                                applicationAccessStore.reload();
                            },
                            failure: function (response, options) {
                                Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                            }
                        });
                    }
                }
            }]
        }
    });

    // end Application Access Request
    var gridPanel = new Ext.Panel({
        name: 'gridPanel',
        id: 'gridPanel',
        title: leafNative,
        height: 50,
        layout: 'fit',
        iconCls: 'application_view_detail',
        tbar: [' ',
        {
            text: reloadToolbarLabel,
            iconCls: 'database_refresh',
            id: 'pageReload',
            
            handler: function () {
                applicationStore.reload();
            }
        }, '-',
        {
            text: addToolbarLabel,
            iconCls: 'add',
            id: 'pageCreate',
            
            xtype: 'button',
            handler: function () {
                Ext.Ajax.request({
                    url: '../controller/applicationController.php',
                    method: 'GET',
                    params: {
                        method: 'read',
                        field: 'sequence',
                        application: 'application',
                        leafId: leafId
                    },
                    success: function (response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == false) {
                            Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                        } else {
                            Ext.getCmp('applicationSequence').setValue(jsonResponse.nextSequence);
                        }
                    },
                    failure: function (response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + escape(response.statusText));
                    }
                });
                viewPort.items.get(1).expand();
            }
        }, '-',
        {
            text: excelToolbarLabel,
            iconCls: 'page_excel',
            id: 'page_excel',
            
            handler: function () {
                Ext.Ajax.request({
                    url: '../applicationData.php?method=report&mode=excel&limit=' + perPage + '&leafId=' + leafId,
                    method: 'GET',
                    success: function (response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse == true) {
                            window.open("../security/document/excel/application.xlsx");
                        } else {
                            Ext.MessageBox.alert(successLabel, jsonResponse.message);
                        }
                    },
                    failure: function (response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + escape(response.statusText));
                    }
                });
            }
        }, '->', new Ext.ux.form.SearchField({
            store: applicationStore,
            width: 320
        })],
        items: [applicationGrid]
    }); // viewport just save information,items will do separate
    var applicationCode = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: applicationCodeLabel,
        hiddenName: 'applicationCode',
        name: 'applicationCode',
        anchor: '40%'
    });
    var applicationEnglish = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: applicationEnglishLabel,
        hiddenName: 'applicationEnglish',
        name: 'applicationEnglish',
        anchor: '40%'
    });
    var applicationSequence = new Ext.form.NumberField({
        labelAlign: 'left',
        fieldLabel: applicationSequenceLabel,
        hiddenName: 'applicationSequence',
        name: 'applicationSequence',
        id: 'applicationSequence',
        anchor: '40%'
    });
    var iconData = [
        ['29', 'accept'],
        ['31', 'acroread'],
        ['32', 'add'],
        ['34', 'aktion'],
        ['35', 'anchor'],
        ['36', 'application'],
        ['40', 'application_double'],
        ['41', 'application_edit'],
        ['42', 'application_error'],
        ['43', 'application_form'],
        ['48', 'application_get'],
        ['49', 'application_go'],
        ['50', 'application_home'],
        ['51', 'application_key'],
        ['52', 'application_lightning'],
        ['53', 'application_link'],
        ['54', 'application_osx'],
        ['55', 'application_osx_terminal'],
        ['56', 'application_put'],
        ['71', 'application_xp'],
        ['72', 'application_xp_terminal'],
        ['73', 'ark'],
        ['94', 'arts'],
        ['95', 'ascend'],
        ['96', 'asterisk_orange'],
        ['97', 'asterisk_yellow'],
        ['98', 'attach'],
        ['100', 'award_star_add'],
        ['101', 'award_star_bronze_1'],
        ['102', 'award_star_bronze_2'],
        ['103', 'award_star_bronze_3'],
        ['104', 'award_star_delete'],
        ['105', 'award_star_gold_1'],
        ['106', 'award_star_gold_2'],
        ['107', 'award_star_gold_3'],
        ['108', 'award_star_silver_1'],
        ['109', 'award_star_silver_2'],
        ['110', 'award_star_silver_3'],
        ['111', 'basket'],
        ['119', 'bell'],
        ['125', 'bin'],
        ['130', 'bomb'],
        ['144', 'box'],
        ['358', 'cursor'],
        ['359', 'cut'],
        ['361', 'daapplicationase'],
        ['385', 'delete'],
        ['386', 'descend'],
        ['387', 'disconnect'],
        ['389', 'disk_multiple'],
        ['391', 'document'],
        ['392', 'door'],
        ['395', 'door_out'],
        ['396', 'drink'],
        ['398', 'drive'],
        ['415', 'dvd'],
        ['423', 'email'],
        ['442', 'error'],
        ['445', 'error_go'],
        ['447', 'exclamation'],
        ['449', 'exec'],
        ['450', 'eye'],
        ['153', 'briefcase'],
        ['154', 'browser'],
        ['155', 'bug'],
        ['162', 'building'],
        ['197', 'cake'],
        ['198', 'calculator'],
        ['212', 'camera'],
        ['220', 'cancel'],
        ['221', 'car'],
        ['222', 'cart'],
        ['235', 'cd'],
        ['242', 'chart_bar'],
        ['270', 'clock'],
        ['281', 'cog'],
        ['287', 'coins'],
        ['290', 'colors'],
        ['291', 'color_swatch'],
        ['292', 'color_wheel'],
        ['300', 'compress'],
        ['301', 'computer'],
        ['309', 'connect'],
        ['339', 'cookie'],
        ['341', 'creditcards'],
        ['342', 'cross'],
        ['461', 'female'],
        ['481', 'find'],
        ['526', 'gimp'],
        ['491', 'application'],
        ['527', 'group'],
        ['536', 'heart'],
        ['539', 'help'],
        ['541', 'hourglass'],
        ['546', 'house'],
        ['549', 'html'],
        ['556', 'image'],
        ['560', 'image_edit'],
        ['561', 'image_link'],
        ['565', 'information'],
        ['566', 'ipod'],
        ['571', 'java'],
        ['572', 'java_jar'],
        ['573', 'joystick'],
        ['578', 'key'],
        ['579', 'keyboard'],
        ['586', 'kservices'],
        ['587', 'layers'],
        ['597', 'lightbulb'],
        ['601', 'lightning'],
        ['605', 'link'],
        ['612', 'lock'],
        ['619', 'lorry'],
        ['626', 'magifier_zoom_out'],
        ['627', 'magnifier'],
        ['628', 'magnifier_zoom_in'],
        ['629', 'male'],
        ['630', 'map'],
        ['651', 'mime'],
        ['652', 'money'],
        ['655', 'money_dollar'],
        ['656', 'money_euro'],
        ['657', 'money_pound'],
        ['658', 'money_yen'],
        ['659', 'monitor'],
        ['667', 'mouse'],
        ['674', 'new'],
        ['675', 'newspaper'],
        ['680', 'note'],
        ['685', 'note_go'],
        ['686', 'ooo_gulls'],
        ['687', 'openoffice'],
        ['688', 'overlays'],
        ['783', 'paintbrush'],
        ['784', 'paintcan'],
        ['785', 'palette'],
        ['789', 'pencil'],
        ['793', 'phone'],
        ['797', 'photo'],
        ['798', 'photos'],
        ['802', 'php-icon'],
        ['803', 'picture'],
        ['814', 'pilcrow'],
        ['815', 'pill'],
        ['830', 'printer'],
        ['837', 'quicktime'],
        ['838', 'rainbow'],
        ['839', 'realplayer'],
        ['841', 'report'],
        ['842', 'report_add'],
        ['843', 'report_delete'],
        ['844', 'report_disk'],
        ['845', 'report_edit'],
        ['846', 'report_go'],
        ['847', 'report_key'],
        ['848', 'report_link'],
        ['849', 'report_magnify'],
        ['850', 'report_picture'],
        ['851', 'report_user'],
        ['852', 'report_word'],
        ['857', 'rosette'],
        ['858', 'rpm'],
        ['902', 'shading'],
        ['928', 'shield'],
        ['932', 'sitemap'],
        ['933', 'sitemap_color'],
        ['934', 'sound'],
        ['949', 'star'],
        ['954', 'stop'],
        ['963', 'application'],
        ['985', 'tag'],
        ['986', 'tag_blue'],
        ['987', 'tag_blue_add'],
        ['988', 'tag_blue_delete'],
        ['989', 'tag_blue_edit'],
        ['990', 'tag_green'],
        ['991', 'tag_orange'],
        ['992', 'tag_pink'],
        ['993', 'tag_purple'],
        ['994', 'tag_red'],
        ['995', 'tag_yellow'],
        ['996', 'tar'],
        ['997', 'telephone'],
        ['1008', 'terminal'],
        ['1052', 'tgz'],
        ['1054', 'thumb_down'],
        ['1055', 'thumb_up'],
        ['1056', 'tick'],
        ['1058', 'time'],
        ['1062', 'time_go'],
        ['1063', 'transmit'],
        ['1070', 'tux'],
        ['1072', 'user'],
        ['1084', 'vcard'],
        ['1088', 'vector'],
        ['1091', 'video'],
        ['1093', 'wand'],
        ['1123', 'zoom'],
        ['1124', 'zoom_in'],
        ['1125', 'zoom_out']
    ];
    var iconId = new Ext.ux.form.IconCombo({
        name: 'iconId',
        hiddenName: 'iconId',
        mode: 'local',
        id: 'iconId',
        hiddenId: 'FakeiconId',
        store: new Ext.data.ArrayStore({
            fields: ['iconId', 'iconName'],
            data: iconData
        }),
        emptyText: emptyTextLabel,
        fieldLabel: iconIdLabel,
        anchor: '40%',
        triggerAction: 'all',
        valueField: 'iconId',
        displayField: 'iconName',
        iconClsTpl: '{iconName}'
    }); // hidden value for navigation button
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
    var formPanel = new Ext.form.FormPanel({
        url: '../controller/applicationController.php',
        name: 'formPanel',
        id: 'formPanel',
        method: 'post',
        frame: true,
        title: leafNative,
        border: false,
        width: 600,
        items: [{
            xtype: 'panel',
            bodyStyle: 'padding:1px',
            layout: 'form',
            items: [{
                xtype: 'fieldset',
                layout: 'form',
                bodyStyle: 'padding:5px;',
                border: true,
                frame: true,
                items: [applicationId, applicationSequence, applicationCode, applicationEnglish, iconId, applicationId]
            }]
        }, {
            xtype: 'tabpanel',
            title: 'application Translation',
            activeTab: 0,
            items: [applicationTranslateGrid, applicationAccessGrid]
        }],
        buttonVAlign: 'top',
        buttonAlign: 'left',
        iconCls: 'application_form',
        bbar: new Ext.ux.StatusBar({
            id: "form-statusbar",
            defaultText: defaultTextLabel,
            plugins: new Ext.ux.ValidationStatus({
                form: "formPanel"
            })
        }),
        buttons: [{
            text: auditButtonLabel,
            name: 'auditButtonLabel',
            id: 'auditButtonLabel',
            type: 'button',
            iconCls: 'key',
            disabled: auditButtonLabelDisabled,
            handler: function () { // reload the store
                if (auditWindow) {
                    logStore.reload();
                    logAdvanceStore.reload();
                    auditWindow.show().center();
                }
            }
        }, {
            text: newButtonLabel,
            name: 'newButton',
            id: 'newButton',
            title: 'newButton',
            type: 'button',
            iconCls: 'new',
            handler: function () {
                Ext.getCmp('applicationTranslateGrid').enable();
                Ext.getCmp('applicationAccessGrid').enable();
                var id = Ext.getCmp('applicationId').getValue();
                var method = 'create';
                formPanel.getForm().submit({
                    waitMsg: waitMessageLabel,
                    params: {
                        method: method,
                        leafId: leafId
                    },
                    success: function (form, action) {
                        if (action.result.success == true) {
                            Ext.getCmp('applicationTranslateGrid').enable();
                            Ext.getCmp('applicationAccessGrid').enable();
                            Ext.getCmp('newButton').disable();
                            Ext.getCmp('saveButton').enable();
                            Ext.getCmp('deleteButton').enable();
                            Ext.getCmp('translationButton').enable();
                            Ext.getCmp('applicationId').setValue(action.result.applicationId);
                            applicationStore.reload({
                                params: {
                                    leafId: leafId,
                                    isadmin: isAdmin,
                                    applicationId: action.result.applicationId,
                                    start: 0,
                                    limit: perPage
                                }
                            });
                            applicationTranslateStore.reload({
                                params: {
                                    leafId: leafId,
                                    isAdmin: isAdmin,
                                    applicationId: action.result.applicationId,
                                    start: 0,
                                    limit: perPage
                                }
                            });
                            applicationAccessStore.reload({
                                params: {
                                    leafId: leafId,
                                    applicationId: action.result.applicationId,
                                    start: 0,
                                    limit: perPage
                                }
                            });
                        } else {
                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                        }
                    },
                    failure: function (form, action) {
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
            text: saveButtonLabel,
            name: 'saveButton',
            id: 'saveButton',
            iconCls: 'bullet_disk',
            disabled: true,
            handler: function () {
                Ext.getCmp('newButton').disable();
                Ext.getCmp('applicationTranslateGrid').disable();
                Ext.getCmp('applicationAccessGrid').disable();
                var id = Ext.getCmp('applicationId').getValue();
                var method = 'save';
                formPanel.getForm().submit({
                    waitTitle: systemLabel,
                    waitMsg: waitMessageLabel,
                    params: {
                        method: method,
                        leafId: leafId,
                        isAdmin: isAdmin
                    },
                    success: function (form, action) {
                        if (action.result.success == true) {
                            Ext.getCmp('applicationTranslateGrid').enable();
                            Ext.getCmp('applicationAccessGrid').enable();
                            Ext.getCmp('newButton').disable();
                            Ext.getCmp('saveButton').enable();
                            Ext.getCmp('deleteButton').enable();
                            Ext.getCmp('translationButton').enable();
                            Ext.getCmp('applicationId').setValue(action.result.applicationId);
                            applicationStore.reload({
                                params: {
                                    leafId: leafId,
                                    isadmin: isAdmin,
                                    applicationId: action.result.applicationId,
                                    start: 0,
                                    limit: perPage
                                }
                            });
                            applicationTranslateStore.reload({
                                params: {
                                    leafId: leafId,
                                    isAdmin: isAdmin,
                                    applicationId: action.result.applicationId,
                                    start: 0,
                                    limit: perPage
                                }
                            });
                            applicationAccessStore.reload({
                                params: {
                                    leafId: leafId,
                                    applicationId: action.result.applicationId,
                                    start: 0,
                                    limit: perPage
                                }
                            });
                        } else {
                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                        }
                    },
                    failure: function (form, action) {
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
            text: deleteButtonLabel,
            type: 'button',
            name: 'deleteButton',
            id: 'deleteButton',
            iconCls: 'trash',
            disabled: true,
            handler: function () {
                Ext.getCmp('newButton').disable();
                Ext.getCmp('applicationTranslateGrid').disable();
                Ext.getCmp('applicationAccessGrid').disable();
                Ext.Msg.show({
                    title: deleteRecordTitleMessageLabel,
                    msg: deleteRecordMessageLabel,
                    icon: Ext.Msg.QUESTION,
                    buttons: Ext.Msg.YESNO,
                    scope: this,
                    fn: function (response) {
                        if ("yes" == response) {
                            Ext.Ajax.request({
                                url: "../controller/applicationController.php",
                                params: {
                                    method: "delete",
                                    applicationId: Ext.getCmp('applicationId').getValue(),
                                    leafId: leafId,
                                    isAdmin: isAdmin
                                },
                                success: function (response, options) {
                                    jsonResponse = Ext.decode(response.responseText);
                                    if (jsonResponse.success == true) {
                                        Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                        applicationStore.reload({
                                            params: {
                                                leafId: leafId,
                                                start: 0,
                                                limit: perPage
                                            }
                                        });
                                        Ext.getCmp('applicationTranslateGrid').disable();
                                        Ext.getCmp('saveButton').disable();
                                        Ext.getCmp('nextButton').disable();
                                        Ext.getCmp('previousButton').disable();
                                        Ext.getCmp('translation').disable();
                                    } else {
                                        Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                                    }
                                },
                                failure: function (response, options) {
                                    Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + response.statusText);
                                }
                            });
                        }
                    }
                });
            }
        }, {
            text: resetButtonLabel,
            type: 'reset',
            name: 'resetButton',
            id: 'resetButton',
            iconCls: 'database_refresh',
            handler: function () {
            	Ext.getCmp('newButton').enable();
                Ext.getCmp('saveButton').disable();
                Ext.getCmp('deleteButton').disable();
                Ext.getCmp('postButton').disable();
                Ext.getCmp('translationButton').disable();
                Ext.getCmp('applicationTranslateGrid').disable();
                Ext.getCmp('applicationAccessGrid').disable();
                formPanel.getForm().reset();
            }
        }, {
            text: postButtonLabel,
            type: 'button',
            name: 'postButton',
            id: 'postButton',
            iconCls: 'lock',
            disabled: true,
            handler: function () {
                Ext.getCmp('newButton').disable();
                Ext.getCmp('applicationTranslateGrid').disable();
                Ext.getCmp('applicationAccessGrid').disable();
                formPanel.getForm().reset();
            }
        }, {
            text: gridButtonLabel,
            type: 'button',
            name: 'gridButton',
            id: 'gridButton',
            iconCls: 'table',
            handler: function () {
                formPanel.getForm().reset();
                viewPort.items.get(0).expand();
            }
        }, {
            text: firstButtonLabel,
            name: 'firstButton',
            id: 'firstButton',
            type: 'button',
            iconCls: 'resultset_first',
            handler: function () {
                Ext.getCmp('newButton').disable();
                Ext.getCmp('teamId').enable();
                Ext.getCmp('applicationAccessGrid').enable();
                if (Ext.getCmp('firstRecord').getValue() == '' || Ext.getCmp('firstRecord').getValue() == undefined) {
                    Ext.Ajax.request({
                        url: "../controller/applicationController.php",
                        method: "GET",
                        params: {
                            method: "dataNavigationRequest",
                            leafId: leafId,
                            dataNavigation: 'firstRecord'
                        },
                        success: function (response, options) {
                            jsonResponse = Ext.decode(response.responseText);
                            if (jsonResponse.success == true) {
                                Ext.getCmp('firstRecord').setValue(jsonResponse.firstRecord);
                                formPanel.form.load({
                                    url: "../controller/applicationController.php",
                                    method: "POST",
                                    waitTitle: systemLabel,
                                    waitMsg: waitMessageLabel,
                                    params: {
                                        method: "read",
                                        applicationId: Ext.getCmp('firstRecord').getValue(),
                                        leafId: leafId,
                                        isAdmin: isAdmin
                                    },
                                    success: function (form, action) {
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
                                            applicationTranslateStore.load({
                                                params: {
                                                    leafId: leafId,
                                                    isAdmin: isAdmin,
                                                    applicationId: action.result.data.applicationId
                                                }
                                            });
                                            
                                            applicationAccessStore.load({
                                                params: {
                                                    leafId: leafId,
                                                    isAdmin: isAdmin,
                                                    applicationId: action.result.data.applicationId
                                                }
                                            });
                                            
                                        } else {
                                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                                        }
                                    },
                                    failure: function (form, action) {
                                        Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                                    }
                                });
                            } else {
                                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                            }
                        },
                        failure: function (response, options) {
                            Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + escape(response.statusText));
                        }
                    });
                } else {
                    formPanel.form.load({
                        url: "../controller/applicationController.php",
                        method: "POST",
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: "read",
                            applicationId: Ext.getCmp('firstRecord').getValue(),
                            leafId: leafId,
                            isAdmin: isAdmin
                        },
                        success: function (form, action) {
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
                                applicationTranslateStore.load({
                                    params: {
                                        leafId: leafId,
                                        isAdmin: isAdmin,
                                        applicationId: action.result.data.applicationId
                                    }
                                });
                                applicationAccessStore.load({
                                    params: {
                                        leafId: leafId,
                                        isAdmin: isAdmin,
                                        applicationId: action.result.data.applicationId
                                    }
                                });
                                
                            } else {
                                Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                            }
                        },
                        failure: function (form, action) {
                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                        }
                    });
                }
            }
        }, {
            text: previousButtonLabel,
            name: 'previousButton',
            id: 'previousButton',
            type: 'button',
            iconCls: 'resultset_previous',
            disabled: true,
            handler: function () {
                Ext.getCmp('newButton').disable();
                Ext.getCmp('applicationTranslateGrid').enable();
                Ext.getCmp('applicationAccessGrid').enable();
                if (Ext.getCmp('previousRecord').getValue() == '' || Ext.getCmp('previousRecord').getValue() == undefined) {
                    Ext.MessageBox.alert("Please Pick A Record First Ya");
                }
                if (Ext.getCmp('firstRecord').getValue() >= 1) {
                    formPanel.form.load({
                        url: "../controller/applicationController.php",
                        method: "POST",
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: "read",
                            applicationId: Ext.getCmp('previousRecord').getValue(),
                            leafId: leafId,
                            isAdmin: isAdmin
                        },
                        success: function (form, action) {
                            if (action.result.success == true) {
                                Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
                                Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
                                Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
                                Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
                                Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                                applicationTranslateStore.load({
                                    params: {
                                        leafId: leafId,
                                        isAdmin: isAdmin,
                                        applicationId: action.result.data.applicationId
                                    }
                                });
                                applicationAccessStore.load({
                                    params: {
                                        leafId: leafId,
                                        isAdmin: isAdmin,
                                        applicationId: action.result.data.applicationId
                                    }
                                });
                                if (Ext.getCmp('previousRecord').getValue() == 0) {
                                    Ext.getCmp('previousButton').disable();
                                }
                                
                            } else {
                                Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                            }
                        },
                        failure: function (form, action) {
                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                        }
                    });
                } else { // empty record
                    Ext.MessageBox.alert(systemErrorLabel, 'Record Not Found');
                }
            }
        }, {
            text: nextButtonLabel,
            name: 'nextButton',
            id: 'nextButton',
            type: 'button',
            disabled: true,
            iconCls: 'resultset_next',
            handler: function () {
                Ext.getCmp('newButton').disable();
                Ext.getCmp('applicationTranslateGrid').enable();
                Ext.getCmp('applicationAccessGrid').enable();
                if (Ext.getCmp('nextRecord').getValue() == '' || Ext.getCmp('nextRecord').getValue() == undefined) {
                    Ext.MessageBox.alert("Please Pick A Record First Ya");
                }
                if (Ext.getCmp('nextRecord').getValue() <= Ext.getCmp('lastRecord').getValue()) {
                    formPanel.form.load({
                        url: "../controller/applicationController.php",
                        method: "POST",
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: "read",
                            applicationId: Ext.getCmp('nextRecord').getValue(),
                            leafId: leafId,
                            isAdmin: isAdmin
                        },
                        success: function (form, action) {
                            if (action.result.success == true) {
                                Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
                                Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
                                Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
                                Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
                                Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                                applicationTranslateStore.load({
                                    params: {
                                        leafId: leafId,
                                        isAdmin: isAdmin,
                                        applicationId: action.result.data.applicationId
                                    }
                                });
                                applicationAccessStore.load({
                                    params: {
                                        leafId: leafId,
                                        isAdmin: isAdmin,
                                        applicationId: action.result.data.applicationId
                                    }
                                });
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
                        failure: function (form, action) {
                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                        }
                    });
                } else {
                    Ext.MessageBox.alert(systemErrorLabel, recordNotFoundLabel);
                }
            }
        }, {
            text: endButtonLabel,
            name: 'endButton',
            id: 'endButton',
            type: 'button',
            iconCls: 'resultset_last',
            handler: function () {
                Ext.getCmp('newButton').disable();
                Ext.getCmp('applicationTranslateGrid').enable();
                Ext.getCmp('applicationAccessGrid').enable();
                if (Ext.getCmp('lastRecord').getValue() == '' || Ext.getCmp('lastRecord').getValue() == undefined) {
                    Ext.Ajax.request({
                        url: "../controller/applicationController.php",
                        method: "GET",
                        params: {
                            method: "dataNavigationRequest",
                            leafId: leafId,
                            dataNavigation: 'lastRecord'
                        },
                        success: function (response, options) {
                            jsonResponse = Ext.decode(response.responseText);
                            if (jsonResponse.success == true) {
                                Ext.getCmp('lastRecord').setValue(jsonResponse.lastRecord);
                                formPanel.form.load({
                                    url: "../controller/applicationController.php",
                                    method: "POST",
                                    waitTitle: systemLabel,
                                    waitMsg: waitMessageLabel,
                                    params: {
                                        method: "read",
                                        applicationId: Ext.getCmp('lastRecord').getValue(),
                                        leafId: leafId,
                                        isAdmin: isAdmin
                                    },
                                    success: function (form, action) {
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
                                            applicationTranslateStore.load({
                                                params: {
                                                    leafId: leafId,
                                                    isAdmin: isAdmin,
                                                    applicationId: action.result.data.applicationId
                                                }
                                            });
                                            applicationAccessStore.load({
                                                params: {
                                                    leafId: leafId,
                                                    isAdmin: isAdmin,
                                                    applicationId: action.result.data.applicationId
                                                }
                                            });
                                            Ext.getCmp('nextButton').disable();
                                            Ext.getCmp('previousButton').enable();
                                            
                                        } else {
                                            Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                                        }
                                    },
                                    failure: function (form, action) {
                                        Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                                    }
                                });
                            } else {
                                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                            }
                        },
                        failure: function (response, options) {
                            Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + escape(response.statusText));
                        }
                    });
                } else {
                    if (Ext.getCmp('applicationId').getValue() <= Ext.getCmp('lastRecord').getValue()) {
                        formPanel.form.load({
                            url: "../controller/applicationController.php",
                            method: "POST",
                            waitTitle: systemLabel,
                            waitMsg: waitMessageLabel,
                            params: {
                                method: "read",
                                applicationId: Ext.getCmp('lastRecord').getValue(),
                                leafId: leafId,
                                isAdmin: isAdmin
                            },
                            success: function (form, action) {
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
                                    applicationTranslateStore.load({
                                        params: {
                                            leafId: leafId,
                                            isAdmin: isAdmin,
                                            applicationId: action.result.data.applicationId
                                        }
                                    });
                                    Ext.getCmp('nextButton').disable();
                                    Ext.getCmp('previousButton').enable();
                                    
                                } else {
                                    Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                                }
                            },
                            failure: function (form, action) {
                                Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                            }
                        });
                    } else {
                        Ext.MessageBox.alert(systemErrorLabel, 'Record Not Found');
                    }
                }
            }
        }, {
            text: 'Translation',
            name: 'translationButton',
            id: 'translationButton',
            disabled: true,
            handler: function () {
                Ext.getCmp('newButton').disable();
                Ext.Ajax.request({
                    url: "../controller/applicationController.php",
                    method: 'GET',
                    params: {
                        leafId: leafId,
                        method: 'translate',
                        applicationId: Ext.getCmp('applicationId').getValue()
                    },
                    success: function (response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == true) {
                            Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                            applicationTranslateStore.reload();
                        } else {
                            Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                        }
                    },
                    failure: function (response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + escape(response.statusText));
                    }
                });
            }
        }]
    });
    var viewPort = new Ext.Viewport({
        id: 'viewport',
        region: 'center',
        layout: 'accordion',
        layoutConfig: {
            titleCollapse: true,
            animate: false,
            activeOnTop: true
        },
        items: [gridPanel, formPanel]
    });
});