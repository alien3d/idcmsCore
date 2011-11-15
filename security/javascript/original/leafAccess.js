Ext.onReady(function() {
    Ext.QuickTips.init();
    Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';
    Ext.form.Field.prototype.msgTarget = 'under';
    Ext.Ajax.timeout = 90000;
    var perPage = 15;
    var encode = false;
    var local = false;
    var jsonResponse;
    var duplicate = 0;
    // start Staff Request
    var staffByProxy = new Ext.data.HttpProxy({
        url: '../controller/leafAccessController.php?',
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
    var  logAdvanceFilters = new Ext.ux.grid.GridFilters({
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
        plugins: [ logAdvanceFilters],
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
    //start team request
    var teamProxy = new Ext.data.HttpProxy({
        url: '../controller/leafAccessController.php?',
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
        root: 'team',
        baseParams: {
            method: 'read',
            leafId: leafId,
            field: 'teamId'
        },
        fields: [{
            name: 'teamId',
            type: 'int'
        },
        {
            name: 'teamEnglish',
            type: 'string'
        }]
    }); // end team request
    //start module request
    var moduleProxy = new Ext.data.HttpProxy({
        url: '../controller/leafAccessController.php',
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
        autoLoad: false,
        autoDestroy: true,
        proxy: moduleProxy,
        reader: moduleReader,
        pruneModifiedRecords: true,
        root: 'module',
        baseParams: {
            method: 'read',
            leafId: leafId,
            field: 'moduleId'
        },
        fields: [{
            name: 'moduleId',
            type: 'int'
        },
        {
            name: 'moduleEnglish',
            type: 'string'
        }]
    }); // end module request
    // start folder request
    var folderProxy = new Ext.data.HttpProxy({
        url: '../controller/leafAccessController.php',
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
        autoLoad: false,
        autoDestroy: true,
        proxy: folderProxy,
        reader: folderReader,
        pruneModifiedRecords: true,
        root: 'folder',
        baseParams: {
            method: 'read',
            leafId: leafId,
            field: 'folderId'
        },
        fields: [{
            name: 'folderId',
            type: 'int'
        },
        {
            name: 'folderEnglish',
            type: 'string'
        }]
    }); // end folder request
    // end additional Proxy ,Reader,Store,Filter,Grid
    // start application Proxy ,Reader,Store,Filter,Grid
    leafAccessProxy = new Ext.data.HttpProxy({
        url: '../controller/leafAccessController.php',
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
    leafAccessReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'leafAccessId'
    });
    var leafAccessStore = new Ext.data.JsonStore({
        autoLoad: false,
        autoDestroy: true,
        proxy: leafAccessProxy,
        reader: leafAccessReader,
        pruneModifiedRecords: true,
        root: 'data',
        baseParams: {
            method: 'read',
            isAdmin: isAdmin,
            leafId: leafId
        },
        fields: [{
        	name:'staffId',
        	type :'string'
        },{
        	name :'staffName',
        	type:'string'
        },{
            name: 'moduleId',
            type: 'int'
        },
        {
            name: 'leafAccessId',
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
            name: 'leafAccessDraftValue',
            type: 'boolean'
        },
        {
            name: 'leafAccessCreateValue',
            type: 'boolean'
        },
        {
            name: 'leafAccessReadValue',
            type: 'boolean'
        },
        {
            name: 'leafAccessUpdateValue',
            type: 'boolean'
        },
        {
            name: 'leafAccessDeleteValue',
            type: 'boolean'
        },
        {
            name: 'leafAccessReviewValue',
            type: 'boolean'
        },
        {
            name: 'leafAccessApprovedValue',
            type: 'boolean'
        },
        
        {
            name: 'leafAccessPostValue',
            type: 'boolean'
        },
        {
            name: 'leafAccessPrintValue',
            type: 'boolean'
        }]
    });
    var leafAccessDraftValue = new Ext.grid.CheckColumn({
        header: leafAccessDraftValueLabel,
        dataIndex: 'leafAccessDraftValue',
        id: 'leafAccessDraftValue',
        width: 55
    });
    var leafAccessCreateValue = new Ext.grid.CheckColumn({
        header: leafAccessCreateValueLabel,
        dataIndex: 'leafAccessCreateValue',
        id: 'leafAccessCreateValue',
        width: 55
    });
    var leafAccessReadValue = new Ext.grid.CheckColumn({
        header: leafAccessReadValueLabel,
        dataIndex: 'leafAccessReadValue',
        id: 'leafAccessReadValue',
        width: 55
    });
    var leafAccessUpdateValue = new Ext.grid.CheckColumn({
        header: leafAccessUpdateValueLabel,
        dataIndex: 'leafAccessUpdateValue',
        id: 'leafAccessUpdateValue',
        width: 55
    });
    var leafAccessDeleteValue = new Ext.grid.CheckColumn({
        header: leafAccessDeleteValueLabel,
        dataIndex: 'leafAccessDeleteValue',
        id: 'leafAccessDeleteValue',
        width: 55
    });
    var leafAccessReviewValue = new Ext.grid.CheckColumn({
        header: leafAccessReviewValueLabel,
        dataIndex: 'leafAccessReviewValue',
        id: 'leafAccessReviewValue',
        width: 55
    });
    var leafAccessApprovedValue = new Ext.grid.CheckColumn({
        header: leafAccessApprovedValueLabel,
        dataIndex: 'leafAccessApprovedValue',
        id: 'leafAccessApprovedValue',
        width: 55
    });
    var leafAccessPostValue = new Ext.grid.CheckColumn({
        header: leafAccessPostValueLabel,
        dataIndex: 'leafAccessPostValue',
        id: 'leafAccessPostValue',
        width: 55
    });
    var leafAccessPrintValue = new Ext.grid.CheckColumn({
        header: leafAccessPrintValueLabel,
        dataIndex: 'leafAccessPrintValue',
        id: 'leafAccessPrintValue',
        width: 55
    });
    
    var leafAccessColumnModel =  [{
            header: moduleEnglishLabel,
            dataIndex: 'moduleEnglish'
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
        },leafAccessDraftValue, leafAccessCreateValue, leafAccessReadValue, leafAccessUpdateValue, leafAccessDeleteValue, leafAccessReviewValue, leafAccessApprovedValue, leafAccessPostValue, leafAccessPrintValue];
    var teamId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: teamIdLabel,
        name: 'teamId',
        hiddenName: 'teamId',
        valueField: 'teamId',
        hiddenId: 'team_fake',
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
                        leafId: leafId,
                        isAdmin: isAdmin,
                        teamId: Ext.getCmp('teamId').getValue(),
                        type: 2
                    }
                });
                Ext.getCmp('moduleId').enable();
                Ext.getCmp('leafAccessGrid').enable();
                leafAccessStore.load({
                    params: {
                        leafId: leafId,
                        isAdmin: isAdmin,
                        teamId: Ext.getCmp('teamId').getValue()
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
        valueField: 'moduleId',
        hiddenId: 'module_fake',
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
                        leafId: leafId,
                        isAdmin: isAdmin,
                        teamId: Ext.getCmp('teamId').getValue(),
                        moduleId: Ext.getCmp('moduleId').getValue(),
                        type: 2
                    }
                });
                Ext.getCmp('folderId').enable();
                 var leafAccessApprovedValue = new Ext.getCmp('leafAccessGrid').enable();
                leafAccessStore.load({
                    params: {
                        leafId: leafId,
                        isAdmin: isAdmin,
                        teamId: Ext.getCmp('teamId'),
                        moduleId: Ext.getCmp('moduleId').getValue()
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
        hiddenId: 'folder_fake',
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
                    Ext.getCmp('leafAccessGrid').disable();
                } else {
                     var leafAccessApprovedValue = new Ext.getCmp('leafAccessGrid').enable();
                }
                leafAccessStore.load({
                    params: {
                        leafId: leafId,
                        isAdmin: isAdmin,
                        teamId: Ext.getCmp('teamId'),
                        moduleId: Ext.getCmp('moduleId').getValue(),
                        folderId: Ext.getCmp('folderId').getValue()
                    }
                });
            }
        }
    });
    var staffId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: staffIdLabel,
        name: 'staffId',
        hiddenName: 'staffId',
        valueField: 'staffId',
        hiddenId: 'staff_fake',
        id: 'staffId',
        displayField: 'staffName',
        typeAhead: false,
        triggerAction: 'all',
        store: staffByStore,
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
                   
                    Ext.getCmp('leafAccessGrid').disable();
                } else {
                    
                    Ext.getCmp('leafAccessGrid').enable();
                }
                folderStore.load({
                    params: {
                        leafId: leafId,
                        isAdmin: isAdmin,
                        teamId: Ext.getCmp('teamId'),
                        moduleId: Ext.getCmp('moduleId').getValue(),
                        staffId: Ext.getCmp('staffId').getValue()
                    }
                });
                leafAccessStore.load({
                    params: {
                        leafId: leafId,
                        isAdmin: isAdmin,
                        teamId: Ext.getCmp('teamId'),
                        moduleId: Ext.getCmp('moduleId').getValue(),
                        folderId: Ext.getCmp('folderId').getValue(),
                        staffId : Ext.getCmp('leafId').getValue()
                    }
                });
            }
        }
    });
    var formPanel = new Ext.Panel({
        region: 'center',
        layout: 'form',
        frame: true,
        title: 'leaf Form',
        iconCls: 'application_form',
        items: [teamId, moduleId, folderId, staffId]
    });
    var leafAccessFlagArray = 
    	[
    	 'leafAccessDraftValue', 
    	 'leafAccessCreateValue', 
    	 'leafAccessReadValue', 
    	 'leafAccessUpdateValue', 
    	 'leafAccessDeleteValue', 
    	 'leafAccessApprovedValue',
    	 'leafAccessReviewValue', 
    	 'leafAccessPostValue',
    	 'leafAccessPrintValue'];
    var leafAccessGrid = new Ext.grid.GridPanel({
        name: 'leafAccessGrid',
        id: 'leafAccessGrid',
        region: 'west',
        store: leafAccessStore,
        columns: leafAccessColumnModel,
        autoHeight: false,
        height: 360,
        frame: true,
        title: leafNative,
        disabled: true,
        iconCls: 'application_view_detail',
        viewConfig : {
        	emptyText: emptyRowLabel
        },
        plugins: [ leafAccessDraftValue,leafAccessCreateValue, leafAccessReadValue, leafAccessUpdateValue, leafAccessDeleteValue, leafAccessReviewValue, leafAccessApprovedValue, leafAccessPostValue,leafAccessPrintValue,],
        tbar: {
            items: [{
            	xtype:'button',
                text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function(button,e) {
                        leafAccessStore.each(function(record,fn,scope) {
                            for (var access in leafAccessFlagArray) {
                                record.set(leafAccessFlagArray[access], true);
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
                        leafAccessStore.each(function(record,fn,scope) {
                            for (var access in leafAccessFlagArray) {
                                record.set(leafAccessFlagArray[access], false);
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
                        var url = '../controller/leafAccessController.php?securityCode='+Math.floor(Math.random()*11);
                        var sub_url = '';
                        var modified = leafAccessStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {                        	
                            var dataChanges = modified[i].getChanges();
                            sub_url = sub_url + '&leafAccessId[]=' + modified[i].get('leafAccessId');
                            if (dataChanges.leafAccessDraftValue == true || dataChanges.leafAccessDraftValue == false) {
                                sub_url = sub_url + '&leafAccessDraftValue[]=' + modified[i].get('leafAccessDraftValue');
                            }
                            if (dataChanges.leafAccessCreateValue == true || dataChanges.leafAccessCreateValue == false) {
                                sub_url = sub_url + '&leafAccessCreateValue[]=' + modified[i].get('leafAccessCreateValue');
                            }
                            if (dataChanges.leafAccessReadValue == true || dataChanges.leafAccessReadValue == false) {
                                sub_url = sub_url + '&leafAccessReadValue[]=' + modified[i].get('leafAccessReadValue');
                            }
                            if (dataChanges.leafAccessUpdateValue == true || dataChanges.leafAccessUpdateValue == false) {
                                sub_url = sub_url + '&leafAccessUpdateValue[]=' + modified[i].get('leafAccessUpdateValue');
                            }
                            if (dataChanges.leafAccessDeleteValue == true || dataChanges.leafAccessDeleteValue == false) {
                                sub_url = sub_url + '&leafAccessDeleteValue[]=' + modified[i].get('leafAccessDeleteValue');
                            }
                            if (dataChanges.leafAccessReviewValue == true || dataChanges.leafAccessReviewValue == false) {
                                sub_url = sub_url + '&leafAccessReviewValue[]=' + modified[i].get('leafAccessReviewValue');
                            }
                            if (dataChanges.leafAccessApprovedValue == true || dataChanges.leafAccessApprovedValue == false) {
                                sub_url = sub_url + '&leafAccessApprovedValue[]=' + modified[i].get('leafAccessApprovedValue');
                            }
                            if (dataChanges.leafAccessPostValue == true || dataChanges.leafAccessPostValue == false) {
                                sub_url = sub_url + '&leafAccessPostValue[]=' + modified[i].get('leafAccessPostValue');
                            }
                            if (dataChanges.leafAccessPrintValue == true || dataChanges.leafAccessPrintValue == false) {
                                sub_url = sub_url + '&leafAccessPrintValue[]=' + modified[i].get('leafAccessPrintValue');
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
                            success: function(response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse.success == true) {
                                    Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                    leafAccessStore.removeAll();
                                    leafAccessStore.load({
                                    	params:{
                                    		leafId:leafId,
                                    		teamId : Ext.getCmp('teamId').getValue(),
                                    		moduleId : Ext.getCmp('moduleId').getValue(),
                                    		folderId : Ext.getCmp('folderId').getValue(),
                                    		staffId : Ext.getCmp('staffId').getValue()                                    		
                                    	}
                                    });
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
            }]
        }
    });
    var viewPort = new Ext.Viewport({
        id: 'viewport',
        layout: 'form',
        frame: true,
        items: [formPanel,leafAccessGrid]
    });
});