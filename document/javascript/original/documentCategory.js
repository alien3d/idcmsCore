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
    // common Proxy,Reader,Store,Filter,Grid
    // start Staff Request
    var staffByProxy = new Ext.data.HttpProxy({
        url: '../controller/documentCategoryController.php?',
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
        id:'staffId',
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
    // end additional Proxy ,Reader,Store,Filter,Grid
    // start application Proxy ,Reader,Store,Filter,Grid
    var documentCategoryProxy = new Ext.data.HttpProxy({
        url: '../controller/documentCategoryController.php',
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
    var documentCategoryReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'documentCategoryId'
    });
    var documentCategoryStore = new Ext.data.JsonStore({
        proxy: documentCategoryProxy,
        reader: documentCategoryReader,
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
            name: 'documentCategoryId',
            type: 'int'
        },
        {
            name: 'documentCategoryTitle',
            type: 'string'
        },
        {
            name: 'documentCategoryDesc',
            type: 'string'
        },
        {
            name: 'documentCategorySequence',
            type: 'string'
        },
        {
            name: 'documentCategoryCode',
            type: 'string'
        },
        {
            name: 'documentCategoryEnglish',
            type: 'string'
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
    var documentCategoryFilters = new Ext.ux.grid.GridFilters({
        encode: encode,
        local: local,
        filters: [{
            type: 'string',
            dataIndex: 'documentCategoryTitle',
            column: 'documentCategoryTitle',
            table: 'documentCategory'
        },
        {
            type: 'string',
            dataIndex: 'documentCategoryDesc',
            column: 'documentCategoryDesc',
            table: 'documentCategory'
        },
        {
            type: 'string',
            dataIndex: 'documentCategorySequence',
            column: 'documentCategorySequence',
            table: 'documentCategory'
        },
        {
            type: 'string',
            dataIndex: 'documentCategoryCode',
            column: 'documentCategoryCode',
            table: 'documentCategory'
        },
        {
            type: 'string',
            dataIndex: 'documentCategoryEnglish',
            column: 'documentCategoryEnglish',
            table: 'documentCategory'
        },
        {
            type: 'list',
            dataIndex: 'executeBy',
            column: 'executeBy',
            table: 'documentCategory',
            labelField: 'staffName',
            store: staffByStore,
            phpMode: true
        },
        {
            type: 'date',
            dataIndex: 'executeTime',
            column: 'executeTime',
            table: 'documentCategory'
        }]
    });
    var documentCategoryTitle = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: documentCategoryTitleLabel + '<span style=\'color: red;\'>*</span>',
        hiddenName: 'documentCategoryTitle',
        name: 'documentCategoryTitle',
        id: 'documentCategoryTitle',
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '95%'
    });
    var documentCategoryDesc = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: documentCategoryDescLabel + '<span style=\'color: red;\'>*</span>',
        hiddenName: 'documentCategoryDesc',
        name: 'documentCategoryDesc',
        id: 'documentCategoryDesc',
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '95%'
    });
    var documentCategorySequence = new Ext.form.NumberField({
        labelAlign: 'left',
        fieldLabel: documentCategorySequenceLabel + '<span style=\'color: red;\'>*</span>',
        hiddenName: 'documentCategorySequence',
        name: 'documentCategorySequence',
        id: 'documentCategorySequence',
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '95%'
    });
    var documentCategoryCode = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: documentCategoryCodeLabel + '<span style=\'color: red;\'>*</span>',
        hiddenName: 'documentCategoryCode',
        name: 'documentCategoryCode',
        id: 'documentCategoryCode',
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '95%'
    });
    var documentCategoryEnglish = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: documentCategoryEnglishLabel + '<span style=\'color: red;\'>*</span>',
        hiddenName: 'documentCategoryEnglish',
        name: 'documentCategoryEnglish',
        id: 'documentCategoryEnglish',
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
        hidden: isApprovedHidden
    });
    var documentCategoryColumnModelGrid = [new Ext.grid.RowNumberer(), {
        dataIndex: 'documentCategoryTitle',
        header: documentCategoryTitleLabel,
        sortable: true,
        hidden: false,
        editor: documentCategoryTitle
    },
    {
        dataIndex: 'documentCategoryDesc',
        header: documentCategoryDescLabel,
        sortable: true,
        hidden: false,
        editor: documentCategoryDesc
    },
    {
        dataIndex: 'documentCategorySequence',
        header: documentCategorySequenceLabel,
        sortable: true,
        hidden: false,
        editor: documentCategorySequence
    },
    {
        dataIndex: 'documentCategoryCode',
        header: documentCategoryCodeLabel,
        sortable: true,
        hidden: false,
        editor: documentCategoryCode
    },
    {
        dataIndex: 'documentCategoryEnglish',
        header: documentCategoryEnglishLabel,
        sortable: true,
        hidden: false,
        editor: documentCategoryEnglish
    },
    isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid, isDeleteGrid, isActiveGrid, isReviewGrid, isApprovedGrid, isPostGrid, {
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
    var documentCategoryFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
    var documentCategoryEditor = new Ext.ux.grid.RowEditor({
        saveText: saveTextLabel,
        cancelText: cancelTextLabel,
        listeners: {
            CancelEdit: function(rowEditor, changes, record, rowIndex) {
                documentCategoryStore.reload();
            },
            afteredit: function(rowEditor, changes, record, rowIndex) {
                var method;
                this.save = true; // update record manually
                var record = this.grid.getStore().getAt(rowIndex);
                if (record.get('documentCategoryId') > 0) {
                    method = 'save';
                } else {
                    method = 'create';
                }
                Ext.Ajax.request({
                    url: '../controller/documentCategoryController.php',
                    method: 'POST',
                    params: {
                        method: method,
                        leafId: leafId,
                        documentCategoryTitle: record.get('documentCategoryTitle'),
                        documentCategoryDesc: record.get('documentCategoryDesc'),
                        documentCategorySequence: record.get('documentCategorySequence'),
                        documentCategoryCode: record.get('documentCategoryCode'),
                        documentCategoryEnglish: record.get('documentCategoryEnglish'),
                        documentCategoryId: record.get('documentCategoryId'),
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
                documentCategoryStore.reload();
            }
        }
    });
    var documentCategoryEntity = Ext.data.Record.create([{
        name: 'documentCategoryId',
        type: 'int'
    },
    {
        name: 'documentCategorySequence',
        type: 'string'
    },
    {
        name: 'documentCategoryCode',
        type: 'string'
    },
    {
        name: 'documentCategoryEnglish',
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
        name: 'executeTime',
        type: 'date',
        dateFormat: 'Y-m-d H:i:s'
    }]);
    var documentCategoryGrid = new Ext.grid.GridPanel({
        name: 'documentCategoryGrid',
        id: 'documentCategoryGrid',
        border: false,
        store: documentCategoryStore,
        autoHeight: false,
        height: 400,
        columns: documentCategoryColumnModelGrid,
        plugins: [documentCategoryFilters, documentCategoryEditor],
        selModel: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            emptyText: emptyTextLabel
        },
        iconCls: 'application_view_detail',
        tbar: {
            items: [{
            	xtype:'button',
                iconCls: 'add',
                id: 'add_record',
                name: 'add_record',
                text: newButtonLabel,
                listeners: {
                    'click': function(button,e) {
                    var newRecord = new documentCategoryEntity({
                        documentCategoryId: '',
                        documentCategorySequence: '',
                        documentCategoryCode: '',
                        documentCategoryEnglish: '',
                        executeBy: '',
                        staffName: '',
                        isDefault: '',
                        isNew: '',
                        isDraft: '',
                        isUpdate: '',
                        isDelete: '',
                        isActive: '',
                        isApproved: '',
                        executeTime: ''
                    });
                    documentCategoryEditor.stopEditing();
                    documentCategoryStore.insert(0, newRecord);
                    documentCategoryGrid.getSelectionModel().getSelections();
                    documentCategoryEditor.startEditing(0);
                }
            }
            },
            {
                xtype:'button',
            	text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function(button,e) {
                        documentCategoryStore.each(function(record,fn,scope) {
                            for (var access in documentCategoryFlagArray) {
                                record.set(documentCategoryFlagArray[access], true);
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
                        documentCategoryStore.each(function(record,fn,scope) {
                            for (var access in documentCategoryFlagArray) {
                                record.set(documentCategoryFlagArray[access], false);
                            }
                        });
                    }
                }
            },
            {
                text: saveButtonLabel,
                iconCls: 'bullet_disk',
                listeners: {
                    'click': function(button,e) {
                        var url = '../controller/documentCategoryController.php?';
                        var sub_url = '';
                        var modified = documentCategoryStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            sub_url = sub_url + '&documentCategoryId[]=' + modified[i].get('documentCategoryId');
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
                            success: function(response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse.success == true) {
                                    Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                    documentCategoryStore.removeAll();
                                    documentCategoryStore.reload();
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
        },
        bbar: new Ext.PagingToolbar({
            store: documentCategoryStore,
            pageSize: perPage
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
            
            handler: function() {
                documentCategoryStore.reload();
            }
        },
        '-', {
            text: excelToolbarLabel,
            iconCls: 'page_excel',
            id: 'page_excel',
            
            handler: function() {
                Ext.Ajax.request({
                    url: '../controller/documentCategoryController.php',
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
                            window.open('../../management/document/excel/' + jsonResponse.filename);
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
            store: documentCategoryStore,
            width: 320
        })],
        items: [documentCategoryGrid]
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