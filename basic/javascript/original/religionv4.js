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
    // start application Proxy ,Reader,Store,Filter,Grid
    var religionProxy = new Ext.data.HttpProxy({
        url: '../controller/religionController.php',
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
    var religionReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'religionId'
    });
    var religionStore = new Ext.data.JsonStore({
        proxy: religionProxy,
        reader: religionReader,
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
            name: 'religionId',
            type: 'int'
        },
        {
            name: 'religionDesc',
            type: 'string'
        },
        {
            name: 'executeBy',
            type: 'int'
        },
        {
            name: 'staffName',
            type: 'string'
        },
        {
            name: 'isDefault',
            type: 'boolean'
        },
        {
            name: 'isNew',
            type: 'boolean'
        },
        {
            name: 'isDraft',
            type: 'boolean'
        },
        {
            name: 'isUpdate',
            type: 'boolean'
        },
        {
            name: 'isDelete',
            type: 'boolean'
        },
        {
            name: 'isActive',
            type: 'boolean'
        },
        {
            name: 'isApproved',
            type: 'boolean'
        },
        {
            name: 'isReview',
            type: 'boolean'
        },
        {
            name: 'isPost',
            type: 'boolean'
        },
        {
            name: 'executeBy',
            type: 'int'
        },
        {
            name: 'executeTime',
            type: 'date',
            dateFormat: 'Y-m-d H:i:s'
        }]
    });
    var religionFilters = new Ext.ux.grid.GridFilters({
        encode: encode,
        local: local,
        filters: [{
            type: 'string',
            dataIndex: 'religionDesc',
            column: 'religionDesc',
            table: 'religion'
        },
        {
            type: 'list',
            dataIndex: 'executeBy',
            column: 'executeBy',
            table: 'religion',
            labelField: 'staffName',
            store: staffByStore,
            phpMode: true
        },
        {
            type: 'date',
            dataIndex: 'executeTime',
            column: 'executeTime',
            table: 'religion'
        }]
    });
    var religionDesc = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: religionDescLabel + '<span style=\'color: red;\'>*</span>',
        hiddenName: 'religionDesc',
        name: 'religionDesc',
        id: 'religionDesc',
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '95%'
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
    var religionColumnModelGrid = [new Ext.grid.RowNumberer(), {
        dataIndex: 'religionDesc',
        header: religionDescLabel,
        sortable: true,
        hidden: false,
        editor: religionDesc
    },
    isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid, isDeleteGrid, isActiveGrid, isApprovedGrid, isReviewGrid, isPostGrid];
    var religionFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
    var religionEditor = new Ext.ux.grid.RowEditor({
        saveText: saveTextLabel,
        cancelText: cancelTextLabel,
        listeners: {
            CancelEdit: function(rowEditor, changes, record, rowIndex) {
                religionStore.reload();
            },
            afteredit: function(rowEditor, changes, record, rowIndex) {
                var method;
                this.save = true;
                var record = this.grid.getStore().getAt(rowIndex);
                if (record.get('religionId') > 0) {
                    method = 'save';
                } else {
                    method = 'create';
                }
                Ext.Ajax.request({
                    url: '../controller/religionController.php',
                    method: 'POST',
                    params: {
                        method: method,
                        leafId: leafId,
                        religionDesc: record.get('religionDesc'),
                        religionId: record.get('religionId'),
                        duplicateTest: true
                    },
                    success: function(response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == false) {
                            Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                        }
                    },
                    failure: function(response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + response.statusText);
                    }
                });
                religionStore.reload();
            }
        }
    });
    var religionEntity = Ext.data.Record.create([{
        name: 'religionId',
        type: 'int'
    },
    {
        name: 'religionDesc',
        type: 'string'
    },
    {
        name: 'executeBy',
        type: 'int'
    },
    {
        name: 'staffName',
        type: 'string'
    },
    {
        name: 'isDefault',
        type: 'boolean'
    },
    {
        name: 'isNew',
        type: 'boolean'
    },
    {
        name: 'isDraft',
        type: 'boolean'
    },
    {
        name: 'isUpdate',
        type: 'boolean'
    },
    {
        name: 'isDelete',
        type: 'boolean'
    },
    {
        name: 'isActive',
        type: 'boolean'
    },
    {
        name: 'isApproved',
        type: 'boolean'
    },
    , {
        name: 'isReview',
        type: 'boolean'
    },
    {
        name: 'isPost',
        type: 'boolean'
    },
    {
        name: 'executeTime',
        type: 'date',
        dateFormat: 'Y-m-d H:i:s'
    }]);
    var religionGrid = new Ext.grid.GridPanel({
        name: 'religionGrid',
        id: 'religionGrid',
        border: false,
        store: religionStore,
        autoHeight: false,
        height: 400,
        autoScroll: true,
        columns: religionColumnModelGrid,
        plugins: [religionFilters, religionEditor],
        selModel: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            emptyText: emptyTextLabel
        },
        iconCls: 'application_view_detail',
        tbar: {
            items: [{
                xtype: 'button',
                iconCls: 'add',
                id: 'add_record',
                name: 'add_record',
                text: newButtonLabel,
                listeners: {
                    'click': function(button, e) {
                        var newRecord = new religionEntity({
                            religionId: '',
                            religionDesc: '',
                            executeBy: '',
                            staffName: '',
                            isDefault: '',
                            isNew: '',
                            isDraft: '',
                            isUpdate: '',
                            isDelete: '',
                            isActive: '',
                            isApproved: '',
                            isReview: '',
                            isPost: '',
                            executeTime: ''
                        });
                        religionEditor.stopEditing();
                        religionStore.insert(0, newRecord);
                        religionGrid.getSelectionModel().getSelections();
                        religionEditor.startEditing(0);
                    }
                }
            },
            {
                xtype: 'button',
                text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function(button, e) {
                        religionStore.each(function(record,fn,scope) {
                            for (var access in religionFlagArray) {
                                record.set(religionFlagArray[access], true);
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
                        religionStore.each(function(record,fn,scope) {
                            for (var access in religionFlagArray) {
                                record.set(religionFlagArray[access], false);
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
                        var url = '../controller/religionController.php?';
                        var sub_url = '';
                        var modified = religionStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            var record = religionStore.getAt(i);
                            if (record.get('religionId')) {
                                sub_url = sub_url + '&religionId[]=' + record.get('religionId');
                            }
                            if (isAdmin == 1) {
                                if (dataChanges.isDefault == true || dataChanges.isDefault == false) {
                                    sub_url = sub_url + '&isDefault[]=' + record.get('isDefault');
                                }
                                if (dataChanges.isDraft == true || dataChanges.isDraft == false) {
                                    sub_url = sub_url + '&isDraft[]=' + record.get('isDraft');
                                }
                                if (dataChanges.isNew == true || dataChanges.isNew == false) {
                                    sub_url = sub_url + '&isNew[]=' + record.get('isNew');
                                }
                                if (dataChanges.isUpdate == true || dataChanges.isUpdate == false) {
                                    sub_url = sub_url + '&isUpdate[]=' + record.get('isUpdate');
                                }
                            }
                            if (dataChanges.isDelete == true || dataChanges.isDelete == false) {
                                sub_url = sub_url + '&isDelete[]=' + record.get('isDelete');
                            }
                            if (isAdmin == 1) {
                                if (dataChanges.isActive == true || dataChanges.isActive == false) {
                                    sub_url = sub_url + '&isActive[]=' + record.get('isActive');
                                }
                                if (dataChanges.isApproved == true || dataChanges.isApproved == false) {
                                    sub_url = sub_url + '&isApproved[]=' + record.get('isApproved');
                                }
                                if (dataChanges.isReview == true || dataChanges.isReview == false) {
                                    sub_url = sub_url + '&isReview[]=' + record.get('isReview');
                                }
                                if (dataChanges.isPost == true || dataChanges.isPost == false) {
                                    sub_url = sub_url + '&isPost[]=' + record.get('isPost');
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
                                method: 'updateStatus',
                                isAdmin: isAdmin
                            },
                            success: function(response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse.success == true) {
                                    Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                    religionStore.removeAll();
                                    religionStore.reload();
                                } else if (jsonResponse.success == false) {
                                    Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                                }
                            },
                            failure: function(response, options) {
                                Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                            }
                        }); // refresh the store
                    }
                }
            }]
        },
        bbar: new Ext.PagingToolbar({
            store: religionStore,
            pageSize: perPage
        }),
        view: new Ext.ux.grid.BufferView({ // custom row height
            rowHeight: 34,
            // render rows as they come into viewable area.
            scrollDelay: false
        })
    });
    var gridPanel = new Ext.Panel({
        title: leafNative,
        iconCls: 'application_view_detail',
        layout: 'fit',
        tbar: [{
            text: reloadToolbarLabel,
            iconCls: 'database_refresh',
            id: 'pageReload',
            disabled: pageReload,
            handler: function() {
                religionStore.reload();
            }
        },
        '-', {
            text: excelToolbarLabel,
            iconCls: 'page_excel',
            id: 'page_excel',
            disabled: pagePrint,
            handler: function() {
                Ext.Ajax.request({
                    url: '../controller/religionController.php',
                    method: 'GET',
                    params: {
                        method: 'report',
                        mode: 'excel',
                        limit: perPage,
                        leafId: leafId
                    },
                    success: function(response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == true) {
                            window.open('../../basic/document/excel/' + jsonResponse.filename);
                        } else {
                            Ext.MessageBox.alert(successLabel, jsonResponse.message);
                        }
                    },
                    failure: function(response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                    }
                });
            }
        },
        '-', new Ext.ux.form.SearchField({
            store: religionStore,
            width: 320
        })],
        items: [religionGrid]
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
        items: [gridPanel]
    });
});