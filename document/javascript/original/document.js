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
    // common Proxy,Reader,Store,Filter,Grid
    // start Staff Request
    var staffByProxy = new Ext.data.HttpProxy({
        url: '../controller/documentController.php?',
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
    // atart additional Proxy ,Reader,Store,Filter,Grid
    var documentCategoryProxy = new Ext.data.HttpProxy({
        url: '../controller/documentController.php',
        method: 'GET',
        params: {
            mode: 'read',
            field: 'documentCategoryId',
            leafId: leafId
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
            field: 'documentCategoryId',
            leafId: leafId
        },
        root: 'documentCategory',
        fields: [{
            name: 'documentCategoryId',
            type: 'int'
        },
        {
            name: 'documentCategoryTitle',
            type: 'string'
        }]
    }); // end additional Proxy ,Reader,Store,Filter,Grid
    // start application Proxy ,Reader,Store,Filter,Grid
    var documentProxy = new Ext.data.HttpProxy({
        url: '../controller/documentController.php',
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel + 'kk', jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var documentReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'documentId'
    });
    var documentStore = new Ext.data.JsonStore({
        proxy: documentProxy,
        reader: documentReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        method: 'POST',
        baseParams: {
            method: 'read',
            leafId: leafId
        },
        root: 'data',
        fields: [{
            name: 'documentId',
            type: 'int'
        },
        {
            name: 'documentCategoryId',
            type: 'int'
        },
        {
            name: 'documentTitle',
            type: 'string'
        },
        {
            name: 'documentDesc',
            type: 'string'
        },
        {
            name: 'documentPath',
            type: 'string'
        },
        {
            name: 'documentOriginalFilename',
            type: 'string'
        },
        {
            name: 'documentDownloadFilename',
            type: 'string'
        },
        {
            name: 'documentExtension',
            type: 'string'
        },
        {
            name: 'documentVersion',
            type: 'string'
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
    var documentFilters = new Ext.ux.grid.GridFilters({
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
            dataIndex: 'documentTitle',
            column: 'documentTitle',
            table: 'document'
        },
        {
            type: 'string',
            dataIndex: 'documentPath',
            column: 'documentPath',
            table: 'document'
        },
        {
            type: 'string',
            dataIndex: 'documentOriginalFilename',
            column: 'documentOriginalFilename',
            table: 'document'
        },
        {
            type: 'string',
            dataIndex: 'documentDownloadFilename',
            column: 'documentDownloadFilename'
        },
        {
            type: 'string',
            dataIndex: 'documentExtension',
            column: 'documentExtension',
            table: 'document'
        },
        {
            type: 'string',
            dataIndex: 'documentVersion',
            column: 'documentVersion',
            table: 'document'
        },
        {
            type: 'list',
            dataIndex: 'executeBy',
            column: 'executeBy',
            table: 'document',
            labelField: 'staffName',
            store: staffByStore,
            phpMode: true
        },
        {
            type: 'date',
            dataIndex: 'executeTime',
            column: 'executeTime',
            table: 'document'
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
    var documentColumnModel = [new Ext.grid.RowNumberer(), {
        id: 'action',
        header: 'Task',
        xtype: 'actioncolumn',
        width: 50,
        items: [{
            icon: '../../javascript/resources/images/icon/application_edit.png',
            tooltip: updateRecordToolTipLabel,
            handler: function(grid, rowIndex, colIndex) {
                var record = documentStore.getAt(rowIndex);
                formPanel.getForm().reset();
                formPanel.form.load({
                    url: '../controller/documentController.php',
                    method: 'POST',
                    waitTitle: systemLabel,
                    waitMsg: waitMessageLabel,
                    params: {
                        method: 'read',
                        mode: 'update',
                        documentId: record.data.documentId,
                        leafId: leafId
                    },
                    success: function(form, action) {
                        Ext.getCmp('deleteButton').enable();
                        viewPort.items.get(1).expand();
                    },
                    failure: function(form, action) {
                        Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                    }
                });
                win.hide();
            }
        },
        {
            icon: '../../javascript/resources/images/icon/trash.gif',
            tooltip: deleteRecordToolTipLabel,
            handler: function(grid, rowIndex, colIndex) {
                var record = documentStore.getAt(rowIndex);
                Ext.Msg.show({
                    title: deleteRecordTitleMessageLabel,
                    msg: deleteRecordMessageLabel,
                    icon: Ext.Msg.QUESTION,
                    buttons: Ext.Msg.YESNO,
                    scope: this,
                    fn: function(response) {
                        if ('yes' == response) {
                            Ext.Ajax.request({
                                url: '../controller/documentController.php',
                                params: {
                                    method: 'delete',
                                    documentId: record.data.documentId,
                                    leafId: leafId
                                },
                                success: function(response, options) {
                                    jsonResponse = Ext.decode(response.responseText);
                                    if (jsonResponse.success == true) {
                                        title = successLabel;
                                    } else {
                                        title = failureLabel;
                                    }
                                    documentStore.reload({
                                        params: {
                                            leafId: leafId,
                                            start: 0,
                                            limit: perPage
                                        }
                                    });
                                    Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                                },
                                failure: function(response, options) {
                                    Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + response.statusText);
                                }
                            });
                        }
                    }
                });
            }
        }]
    },
    {
        dataIndex: 'documentId',
        header: documentIdLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'documentTitle',
        header: documentTitleLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'documentDesc',
        header: documentDescLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'documentPath',
        header: documentPathLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'documentOriginalFilename',
        header: documentOriginalFilenameLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'documentDownloadFilename',
        header: documentDownloadFilenameLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'documentExtension',
        header: documentExtensionLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: 'documentVersion',
        header: documentVersionLabel,
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
    var documentFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
    var documentGrid = new Ext.grid.GridPanel({
        name: 'documentGrid',
        id: 'documentGrid',
        border: false,
        store: documentStore,
        autoHeight: false,
        height: 450,
        columns: documentColumnModel,
        loadMask: true,
        plugins: [documentFilters],
        selModel: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            forceFit: true,
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
            		}
            	}
            },
            {
                xtype:'button',
            	text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function(button,e) {
                        var count = documentStore.getCount();
                        documentStore.each(function(record,fn,scope) {
                            for (var access in documentFlagArray) {
                                record.set(documentFlagArray[access], true);
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
                        documentStore.each(function(record,fn,scope) {
                            for (var access in documentFlagArray) {
                                record.set(documentFlagArray[access], false);
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
                        var url = '../controller/documentController.php?';
                        var sub_url = '';
                        var modified = documentStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            sub_url = sub_url + '&documentId[]=' + modified[i].get('documentId');
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
                                    documentStore.removeAll();
                                    documentStore.reload();
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
            store: documentStore,
            pageSize: perPage
        })
    });
    var documentCategoryId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: documentCategoryIdLabel + '<span style=\'color: red;\'>*</span>',
        name: 'documentCategoryId',
        valueField: 'documentCategoryId',
        hiddenName: 'documentCategoryId',
        id: 'documentCategoryId',
        hiddenId: 'documentCategoryFake',
        displayField: 'documentCategoryTitle',
        typeAhead: false,
        emptyText: emptyTextLabel,
        triggerAction: 'all',
        mode: 'local',
        store: documentCategoryStore,
        anchor: '95%',
        selectOnFocus: true,
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
    var documentCode = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: documentCodeLabel,
        hiddenName: 'documentCode',
        name: 'documentCode',
        allowBlank: false,
        blankText: blankTextLabel,
        anchor: '95%'
    });
    var documentSequence = new Ext.form.NumberField({
        labelAlign: 'left',
        fieldLabel: documentSequenceLabel,
        hiddenName: 'documentSequence',
        name: 'documentSequence',
        allowBlank: false,
        blankText: blankTextLabel,
        anchor: '95%'
    });
    var documentNote = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: documentNoteLabel,
        hiddenName: 'documentDesc',
        name: 'documentDesc',
        allowBlank: false,
        blankText: blankTextLabel,
        anchor: '95%'
    });
    var documentTitle = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: documentTitleLabel,
        hiddenName: 'documentDesc',
        name: 'documentDesc',
        allowBlank: false,
        blankText: blankTextLabel,
        anchor: '95%'
    });
    var documentDesc = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: documentDescLabel,
        hiddenName: 'documentDesc',
        name: 'documentDesc',
        allowBlank: false,
        blankText: blankTextLabel,
        anchor: '95%'
    });
    var documentPath = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: documentPathLabel,
        hiddenName: 'documentPath',
        name: 'documentPath',
        allowBlank: false,
        blankText: blankTextLabel,
        anchor: '95%'
    });
    var documentId = new Ext.form.Hidden({
        name: 'documentId',
        id: 'documentId'
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
    var formPanel = new Ext.FormPanel({
        method: 'POST',
        name: 'formPanel',
        id: 'formPanel',
        url: '../controller/documentController.php',
        title: leafEnglish,
        border: false,
        width: 600,
        fileUpload: true,
        frame: true,
        autoheight: true,
        bodyStyle: 'padding: 10px 10px 0 10px;',
        labelWidth: 60,
        buttonVAlign: 'top',
        buttonAlign: 'left',
        defaults: {
            anchor: '95%',
            msgTarget: 'side'
        },
        iconCls: 'application_form',
        bbar: new Ext.ux.StatusBar({
            id: 'form-statusbar',
            defaultText: 'Ready',
            plugins: new Ext.ux.ValidationStatus({
                form: 'formPanel'
            })
        }),
        items: [documentCategoryId, documentTitle, documentDesc, documentId, {
            xtype: 'fileuploadfield',
            fieldLabel: documentFilenameLabel,
            name: 'documentFilename',
            id: 'documentFilename',
            allowBlank: false,
            blankText: blankTextLabel,
            buttonCfg: {
                text: '',
                iconCls: 'bullet_disk'
            }
        }],
        buttons: [{
            text: uploadButtonLabel,
            iconCls: 'bullet_disk',
            handler: function() {
                if (formPanel.getForm().isValid()) {
                    var id = 0;
                    id = Ext.getCmp('documentId').getValue();
                    var method;
                    if (id.length > 0) {
                        method = 'save';
                    } else {
                        method = 'create';
                    }
                    formPanel.getForm().submit({
                        waitTitle: waitMessageLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: method,
                            leafId: leafId
                        },
                        success: function(form, action) {
                            if (action.result.success == true) {
                                Ext.MessageBox.alert(systemLabel, action.result.message);
                                formPanel.getForm().reset();
                                documentStore.reload({
                                    params: {
                                        leafId: leafId,
                                        start: 0,
                                        limit: perPage
                                    }
                                });
                                if (action.result.firstRecord > 0) {
                                    Ext.getCmp('firstButton').enable();
                                    Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
                                } else {
                                    Ext.getCmp('firstButton').disable();
                                }
                                if (action.result.nextRecord > 0) {
                                    Ext.getCmp('nextButton').enable();
                                    Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
                                } else {
                                    Ext.getCmp('nextButton').disable();
                                }
                                if (action.result.previousRecord > 0) {
                                    Ext.getCmp('previousButton').enable();
                                    Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
                                } else {
                                    Ext.getCmp('previousButton').disable();
                                }
                                if (action.result.firstRecord > 0) {
                                    Ext.getCmp('endButton').enable();
                                    Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
                                } else {
                                    Ext.getCmp('endButton').disable();
                                }
                                viewPort.items.get(0).expand();
                            } else {
                                alert(action.result.message);
                            }
                        },
                        failure: function(form, action) {
                            if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
                                Ext.Msg.alert(systemErrorLabel, loadFailureLabel);
                            } else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
                                Ext.Msg.alert(systemErrorLabel, clientInvalidLabel);
                            } else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
                                Ext.Msg.alert(connectFailureLabel + form.response.status + ' ' + form.response.statusText);
                            } else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
                                Ext.Msg.alert(systemErrorLabel, action.result.message);
                            }
                        }
                    });
                }
            }
        },
        {
            text: newButtonLabel,
            type: 'button',
            iconCls: 'add',
            handler: function() {
                formPanel.getForm().reset();
            }
        },
        {
            text: resetButtonLabel,
            type: 'reset',
            iconCls: 'table_refresh',
            handler: function() {
                formPanel.getForm().reset();
            }
        },
        {
            text: gridButtonLabel,
            type: 'button',
            iconCls: 'table',
            handler: function() {
                if (win) {
                    win.show().center();
                }
            }
        },
        {
            text: cancelButtonLabel,
            type: 'button',
            iconCls: 'delete',
            handler: function() {
                if (win) {
                    win.hide();
                }
                formPanel.getForm().reset();
                store.reload();
                viewPort.items.get(0).expand();
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
        items: [documentGrid, formPanel]
    });
});