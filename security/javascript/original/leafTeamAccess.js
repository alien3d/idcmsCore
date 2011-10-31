Ext.onReady(function() {
    Ext.QuickTips.init();
    Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';
    Ext.form.Field.prototype.msgTarget = 'under';
    Ext.Ajax.timeout = 90000;
    var pageCreate;
    var pageReload;
    var pagePrint;
    var perPage = 15;
    var encode = false;
    var local = false;
    var jsonResponse;
    var duplicate = 0;
    if (leafTeamAccessCreateValue == 1) {
        pageCreate = false;
    } else {
        pageCreate = true;
    }
    if (leafTeamAccessReadValue == 1) {
        pageReload = false;
    } else {
        pageReload = true;
    }
    if (leafTeamAccessPrintValue == 1) {
        pagePrint = false;
    } else {
        pagePrint = true;
    } // common Proxy,Reader,Store,Filter,Grid
    // start Staff Request
    var staffByProxy = new Ext.data.HttpProxy({
        url: '../controller/religionController.php?',
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
        baseParams: {
            method: 'read',
            field: 'staffId',
            leafId: leafId
        },
        root: 'staff',
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
        autoLoad: true,
        autoDestroy: true,
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
        sm: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            emptyText: emptyTextLabel
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
        autoLoad: true,
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
        sm: new Ext.grid.RowSelectionModel({
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
    // start Team Request
    var teamProxy = new Ext.data.HttpProxy({
        url: '../controller/leafTeamAccessController.php',
        method: 'GET',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) {
                Ext.MessageBox.alert(systemLabel, jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
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
        autoLoad: true,
        autoDestroy: true,
        proxy: teamProxy,
        reader: teamReader,
        baseParams: {
            method: 'read',
            leafId: leafId,
            field: 'teamId'
        },
        root: 'team',
        fields: [{
            name: 'teamId',
            type: 'int'
        },
        {
            name: 'teamEnglish',
            type: 'string'
        }]
    }); // end Team Request
    // start Module Request
    var moduleProxy = new Ext.data.HttpProxy({
        url: '../controller/leafTeamAccessController.php',
        method: 'GET',
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
    var moduleReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'moduleId'
    });
    var moduleStore = new Ext.data.JsonStore({
        autoDestroy: true,
        proxy: moduleProxy,
        reader: moduleReader,
        baseParams: {
            method: 'read',
            leafId: leafId,
            field: 'moduleId'
        },
        root: 'module',
        fields: [{
            name: 'moduleId',
            type: 'int'
        },
        {
            name: 'moduleEnglish',
            type: 'string'
        }]
    }); // end Module Request
    // start Folder Request
    var folderProxy = new Ext.data.HttpProxy({
        url: '../controller/leafTeamAccessController.php',
        method: 'GET',
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
    var folderReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'folderId'
    });
    var folderStore = new Ext.data.JsonStore({
        autoDestroy: true,
        proxy: folderProxy,
        reader: folderReader,
        baseParams: {
            method: 'read',
            leafId: leafId,
            field: 'folderId'
        },
        root: 'folder',
        fields: [{
            name: 'folderId',
            type: 'int'
        },
        {
            name: 'folderEnglish',
            type: 'string'
        }]
    }); // end Folder REquest
    // end additional Proxy ,Reader,Store,Filter,Grid
    // start application Proxy ,Reader,Store,Filter,Grid
    var leafTeamAccessProxy = new Ext.data.HttpProxy({
        url: '../controller/leafTeamAccessController.php',
        method: 'POST',
        baseParams: {
            method: 'read',
            leafId: leafId,
            isAdmin: isAdmin
        },
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
    var leafTeamAccessReader = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'leafTeamAccessId'
    });
    var leafTeamAccessStore = new Ext.data.JsonStore({
        autoDestroy: true,
        proxy: leafTeamAccessProxy,
        reader: leafTeamAccessReader,
        fields: [{
            name: 'moduleId',
            type: 'int'
        },
        {
            name: 'leafTeamAccessId',
            type: 'int'
        },
        {
            name: 'moduleEnglish',
            type: 'string'
        },
        {
            name: 'teamId',
            type: 'int'
        },
        {
            name: 'teamEnglish',
            type: 'string'
        },
        {
            name: 'folderId',
            type: 'int'
        },
        {
            name: 'folderEnglish',
            type: 'string'
        },
        {
            name: 'leafId',
            type: 'int'
        },
        {
            name: 'leafEnglish',
            type: 'string'
        },
        {
            name: 'staffName',
            type: 'string'
        },
        {
            name: 'staffId',
            type: 'int'
        },
        {
            name: 'leafTeamAccessCreateValue',
            type: 'boolean'
        },
        {
            name: 'leafTeamAccessReadValue',
            type: 'boolean'
        },
        {
            name: 'leafTeamAccessUpdateValue',
            type: 'boolean'
        },
        {
            name: 'leafTeamAccessDeleteValue',
            type: 'boolean'
        },
        {
            name: 'leafTeamAccessPrintValue',
            type: 'boolean'
        },
        {
            name: 'leafTeamAccessPostValue',
            type: 'boolean'
        },
        {
            name: 'leafTeamAccessDraftValue',
            type: 'boolean'
        },
        {
            name: 'leafTeamAccessReviewValue',
            type: 'boolean'
        }]
    });
    var leafTeamAccessCreateValue = new Ext.grid.CheckColumn({
        header: leafTeamAccessCreateValueLabel,
        dataIndex: 'leafTeamAccessCreateValue',
        id: 'leafTeamAccessCreateValue',
        width: 55
    });
    var leafTeamAccessReadValue = new Ext.grid.CheckColumn({
        header: leafTeamAccessReadValueLabel,
        dataIndex: 'leafTeamAccessReadValue',
        id: 'leafTeamAccessReadValue',
        width: 55
    });
    var leafTeamAccessUpdateValue = new Ext.grid.CheckColumn({
        header: leafTeamAccessUpdateValueLabel,
        dataIndex: 'leafTeamAccessUpdateValue',
        id: 'leafTeamAccessUpdateValue',
        width: 55
    });
    var leafTeamAccessDeleteValue = new Ext.grid.CheckColumn({
        header: leafTeamAccessDeleteValueLabel,
        dataIndex: 'leafTeamAccessDeleteValue',
        id: 'leafTeamAccessDeleteValue',
        width: 55
    });
    var leafTeamAccessPrintValue = new Ext.grid.CheckColumn({
        header: leafTeamAccessPrintValueLabel,
        dataIndex: 'leafTeamAccessPrintValue',
        id: 'leafTeamAccessPrintValue',
        width: 55
    });
    var leafTeamAccessPostValue = new Ext.grid.CheckColumn({
        header: leafTeamAccessPostValueLabel,
        dataIndex: 'leafTeamAccessPostValue',
        id: 'leafTeamAccessPostValue',
        width: 55
    });
    var leafTeamAccessReviewValue = new Ext.grid.CheckColumn({
        header: leafTeamAccessReviewValueLabel,
        dataIndex: 'leafTeamAccessReviewlue',
        id: 'leafTeamAccessReviewValue',
        width: 55
    });
    var leafTeamAccessDraftValue = new Ext.grid.CheckColumn({
        header: leafTeamAccessDraftValueLabel,
        dataIndex: 'leafTeamAccessDraftValue',
        id: 'leafTeamAccessDraftValue',
        width: 55
    });
    var leafTeamAccessColumnModel = new Ext.grid.ColumnModel({
        columns: [{
            header: moduleEnglishLabel,
            dataIndex: 'moduleNative'
        },
        {
            header: teamEnglishLabel,
            dataIndex: 'teamEnglish'
        },
        {
            header: folderEnglishLabel,
            dataIndex: 'folderEnglish'
        },
        {
            header: leafEnglishLabel,
            dataIndex: 'leafEnglish'
        },
        {
            header: staffNameLabel,
            dataIndex: 'staffName'
        },
        leafTeamAccessDraftValue, leafTeamAccessCreateValue, leafTeamAccessReadValue, leafTeamAccessUpdateValue, leafTeamAccessDeleteValue, leafTeamAccessPrintValue, leafTeamAccessReviewValue, leafTeamAccessPostValue]
    });
    var teamId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: teamIdLabel,
        name: 'teamId',
        hiddenName: 'teamId',
        hiddenId: 'teamFakeId',
        valueField: 'teamId',
        id: 'teamId',
        displayField: 'teamEnglish',
        typeAhead: false,
        triggerAction: 'all',
        store: teamStore,
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
        listeners: {
            'select': function(combo, record, index) {
                Ext.getCmp('moduleId').reset();
                moduleStore.load({
                    params: {
                        teamId: Ext.getCmp('teamId').getValue(),
                        type: 2,
                        leafId: leafId,
                        isAdmin: isAdmin
                    }
                });
                Ext.getCmp('moduleId').enable();
                Ext.getCmp('gridPanel').enable();
                leafTeamAccessStore.load({
                    params: {
                        teamId: Ext.getCmp('teamId').getValue(),
                        leafId: leafId,
                        isAdmin: isAdmin,
                        method: 'read'
                    }
                });
            }
        }
    });
    var moduleId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: moduleIdLabel,
        name: 'moduleId',
        hiddenName: 'moduleId',
        hiddenId: 'moduleFake',
        valueField: 'moduleId',
        id: 'moduleId',
        displayField: 'moduleEnglish',
        typeAhead: false,
        triggerAction: 'all',
        store: moduleStore,
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
        disabled: true,
        listeners: {
            'select': function(combo, record, index) {
                Ext.getCmp('folderId').reset();
                folderStore.load({
                    params: {
                        teamId: Ext.getCmp('teamId').getValue(),
                        moduleId: Ext.getCmp('moduleId').getValue(),
                        type: 2,
                        leafId: leafId,
                        isAdmin: isAdmin
                    }
                });
                Ext.getCmp('folderId').enable();
                Ext.getCmp('gridPanel').enable();
                leafTeamAccessStore.load({
                    params: {
                        teamId: Ext.getCmp('teamId').getValue(),
                        moduleId: Ext.getCmp('moduleId').getValue(),
                        leafId: leafId,
                        isAdmin: isAdmin,
                        method: 'read'
                    }
                });
            }
        }
    });
    var folderId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: folderIdLabel,
        name: 'folderId',
        hiddenName: 'folderId',
        valueField: 'folderId',
        hiddenId: 'folderFakeId',
        id: 'folderId',
        displayField: 'folderEnglish',
        typeAhead: false,
        triggerAction: 'all',
        store: folderStore,
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
        disabled: true,
        listeners: {
            'select': function(combo, record, index) {
                if (this.value == '') {
                    Ext.getCmp('gridPanel').disable();
                } else {
                    Ext.getCmp('gridPanel').enable();
                }
                leafTeamAccessStore.load({
                    params: {
                        teamId: Ext.getCmp('teamId').getValue(),
                        moduleId: Ext.getCmp('moduleId').getValue(),
                        folderId: Ext.getCmp('folderId').getValue(),
                        leafId: leafId,
                        isAdmin: isAdmin,
                        method: 'read'
                    }
                });
            }
        }
    });
    var formPanel = new Ext.Panel({
        name: 'formPanel',
        id: 'formPanel',
        region: 'north',
        layout: 'form',
        frame: true,
        title: leafNative,
        iconCls: 'application_form',
        autoScroll: true,
        items: [teamId, moduleId, folderId]
    });
    var accessArray = ['leafTeamAccessCreateValue', 'leafTeamAccessReadValue', 'leafTeamAccessUpdateValue', 'leafTeamAccessDeleteValue', 'leafTeamAccessPrintValue', 'leafTeamAccessPostValue'];
    var grid = new Ext.grid.GridPanel({
        region: 'west',
        name: 'gridPanel',
        id: 'gridPanel',
        store: leafTeamAccessStore,
        cm: leafTeamAccessColumnModel,
        frame: true,
        title: leafNative,
        disabled: true,
        iconCls: 'application_view_detail',
        viewConfig: {
            emptyText: emptyTextLabel
        },
        autoScroll: true,
        autoHeight: false,
        height: 400,
        plugins: [leafTeamAccessCreateValue, leafTeamAccessReadValue, leafTeamAccessUpdateValue, leafTeamAccessDeleteValue, leafTeamAccessPrintValue, leafTeamAccessPostValue],
        tbar: {
            items: [{
            	xtype:'button',
                text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function(button,e) {
                        leafTeamAccessStore.each(function(rec) {
                            for (var access in accessArray) {
                                rec.set(accessArray[access], true);
                            }
                        });
                    }
                }
            },
            {
                xtype:'button',
            	text: ClearAllLabel,
                iconCls: 'row-check-sprite-uncheck',
                listeners: {
                    'click': function(button,e) {
                        leafTeamAccessStore.each(function(rec) {
                            for (var access in accessArray) {
                                rec.set(accessArray[access], false);
                            }
                        });
                    }
                }
            },
            {
                xtype:'button',
            	text: saveButtonLabel,
                iconCls: 'bullet_disk',
                listeners: {
                    'click': function(button,e) {
                        var url = '../controller/leafTeamAccessController.php';
                        var sub_url = '';
                        var modified = leafTeamAccessStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            var record = leafTeamAccessStore.getAt(i);
                            if (dataChanges.leafTeamAccessDraftValue == true || dataChanges.leafTeamAccessDraftValue == false) {
                                sub_url = sub_url + '&leafTeamAccessDraftValue[]=' + record.get('leafTeamAccessDraftValue');
                            }
                            if (dataChanges.leafTeamAccessCreateValue == true || dataChanges.leafTeamAccessCreateValue == false) {
                                sub_url = sub_url + '&leafTeamAccessCreateValue[]=' + record.get('leafTeamAccessCreateValue');
                            }
                            if (dataChanges.leafTeamAccessReadValue == true || dataChanges.leafTeamAccessReadValue == false) {
                                sub_url = sub_url + '&leafTeamAccessReadValue[]=' + record.get('leafTeamAccessReadValue');
                            }
                            if (dataChanges.leafTeamAccessUpdateValue == true || dataChanges.leafTeamAccessUpdateValue == false) {
                                sub_url = sub_url + '&leafTeamAccessUpdateValue[]=' + record.get('leafTeamAccessUpdateValue');
                            }
                            if (dataChanges.leafTeamAccessDeleteValue == true || dataChanges.leafTeamAccessDeleteValue == false) {
                                sub_url = sub_url + '&leafTeamAccessDeleteValue[]=' + record.get('leafTeamAccessDeleteValue');
                            }
                            if (dataChanges.leafTeamAccessPrintValue == true || dataChanges.leafTeamAccessPrintValue == false) {
                                sub_url = sub_url + '&leafTeamAccessPrintValue[]=' + record.get('leafTeamAccessPrintValue');
                            }
                            if (dataChanges.leafTeamAccessReviewValue == true || dataChanges.leafTeamAccessReviewValue == false) {
                                sub_url = sub_url + '&leafTeamAccessReviewValue[]=' + record.get('leafTeamAccessReviewValue');
                            }
                            if (dataChanges.leafTeamAccessPostValue == true || dataChanges.leafTeamAccessPostValue == false) {
                                sub_url = sub_url + '&leafTeamAccessPostValue[]=' + record.get('leafTeamAccessPostValue');
                            }
                        }
                        url = url + sub_url;
                        Ext.Ajax.request({
                            url: url,
                            params: {
                                info: sub_url,
                                leafId: leafId,
                                isAdmin: isAdmin
                            },
                            method: 'POST',
                            success: function(response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse == false) {
                                    Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                                } else {
                                    Ext.MessageBox.alert(systemLabel, 'success updated');
                                }
                                leafTeamAccessStore.reload();
                            },
                            failure: function(response, options) {
                                Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                            }
                        });
                    }
                }
            }]
        }
    });
    var viewPort = new Ext.Viewport({
        id: 'viewport',
        layout: 'form',
        frame: true,
        items: [formPanel, grid]
    });
});