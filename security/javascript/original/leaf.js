Ext.onReady(function () {
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
    if (leafAccessCreateValue == 1) {
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
        url: '../controller/leafController.php?',
        method: 'GET',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
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
            leafId: leafIdTemp
        },
        root: 'staff',
        fields: [{
            name: 'staffId',
            type: 'int'
        }, {
            name: 'staffName',
            type: 'string'
        }]
    }); // end Staff Request
    // start log Request
    var logProxy = new Ext.data.HttpProxy({
        url: '../../security/controller/logController.php?',
        method: 'POST',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
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
            leafId: leafIdTemp,
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
            emptyText: emptyTextLabel
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
        url: '../../security/controller/logAdvanceController.php?',
        method: 'POST',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
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
            leafId: leafIdTemp,
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
            emptyText: emptyTextLabel
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
            }, {
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
    // start team request
    var teamProxy = new Ext.data.HttpProxy({
        url: '../controller/leafAccessController.php',
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
            leafId: leafIdTemp
        },
        root: 'team',
        fields: [{
            name: 'teamId',
            type: 'int'
        }, {
            name: 'teamEnglish',
            type: 'string'
        }]
    }); // end team request
    // start Module Request
    var moduleProxy = new Ext.data.HttpProxy({
        url: '../controller/leafController.php?',
        method: 'GET',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
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
        proxy: moduleProxy,
        reader: moduleReader,
        autoLoad: true,
        autoDestroy: true,
        baseParams: {
            method: 'read',
            field: 'moduleId',
            type: 1,
            leafId: leafIdTemp
        },
        root: 'module',
        fields: [{
            name: 'moduleId',
            type: 'int'
        }, {
            name: 'moduleEnglish',
            type: 'string'
        }]
    }); // end Module Request
    // start Folder Request
    var folderProxy = new Ext.data.HttpProxy({
        url: '../controller/leafController.php?',
        method: 'GET',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function (response, options) {
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
        proxy: folderProxy,
        reader: folderReader,
        autoLoad: true,
        autoDestroy: true,
        baseParams: {
            method: 'read',
            field: 'folderId',
            type: 1,
            leafId: leafIdTemp
        },
        root: 'folder',
        fields: [{
            name: 'folderId',
            type: 'int'
        }, {
            name: 'folderEnglish',
            type: 'string'
        }]
    }); // end Folder Request
    // end additional Proxy ,Reader,Store,Filter,Grid
    // start application Proxy ,Reader,Store,Filter,Grid
    var leafProxy = new Ext.data.HttpProxy({
        url: '../controller/leafController.php',
        method: 'POST',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText); // Ext.MessageBox.alert(systemLabel,
            // jsonResponse.message);
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var leafReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'leafId'
    });
    var leafStore = new Ext.data.JsonStore({
        proxy: leafProxy,
        reader: leafReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: 'read',
            leafIdTemp: leafIdTemp,
            isAdmin: isAdmin
        },
        root: 'data',
        fields: [{
            name: 'leafId',
            type: 'int'
        }, {
            name: 'moduleId',
            type: 'int'
        }, {
            name: 'moduleEnglish',
            type: 'string'
        }, {
            name: 'folderId',
            type: 'int'
        }, {
            name: 'folderEnglish',
            type: 'string'
        }, {
            name: 'leafEnglish',
            type: 'string'
        }, {
            name: 'leafEnglish',
            type: 'string'
        }, {
            name: 'leafSequence',
            type: 'int'
        }, {
            name: 'leafFilename',
            type: 'string'
        }, {
            name: 'iconId',
            type: 'int'
        }, {
            name: 'iconName',
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
        }]
    });
    var leafFilters = new Ext.ux.grid.GridFilters({
        encode: encode,
        local: local,
        filters: [{
            type: 'list',
            dataIndex: 'moduleNative',
            column: 'moduleId',
            table: 'module',
            labelField: 'moduleNative',
            store: moduleStore,
            phpMode: true
        }, {
            type: 'list',
            dataIndex: 'folderNative',
            column: 'folderId',
            table: 'folder',
            labelField: 'folderNative',
            store: folderStore,
            phpMode: true
        }, {
            type: 'string',
            dataIndex: 'leafEnglish',
            column: 'leafEnglish',
            column: 'leafEnglish',
            table: 'leaf'
        }, {
            type: 'numeric',
            dataIndex: 'leafSequence',
            column: 'leafSequence',
            table: 'leaf'
        }, {
            type: 'string',
            dataIndex: 'leafFilename',
            column: 'leafFilename',
            table: 'leaf'
        }, {
            type: 'string',
            dataIndex: 'iconId',
            column: 'iconId',
            table: 'leaf'
        }, {
            type: 'list',
            dataIndex: 'executeBy',
            column: 'executeBy',
            table: 'religion',
            labelField: 'staffName',
            store: staffByStore,
            phpMode: true
        }, {
            type: 'date',
            dataIndex: 'executeTime',
            column: 'executeTime',
            table: 'leaf'
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
    var leafColumnModel = [
    new Ext.grid.RowNumberer(),
    {
        dataIndex: 'leafSequence',
        header: leafSequenceLabel,
        type: 'string',
        sortable: false,
        hidden: false
    }, {
        dataIndex: 'leafEnglish',
        header: leafEnglishLabel,
        type: 'string',
        sortable: false,
        hidden: false
    }, {
        dataIndex: 'leafFilename',
        header: leafFilenameLabel,
        type: 'string',
        sortable: false,
        hidden: false
    }, {
        dataIndex: 'iconName',
        header: iconNameLabel,
        type: 'string',
        sortable: false,
        hidden: false,
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
        sortable: true,
        hidden: true,
        width: 100
    }, {
        dataIndex: 'executeTime',
        header: executeTimeLabel,
        type: 'date',
        sortable: true,
        hidden: true,
        width: 100
    }];
 
    var leafFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
    var leafGrid = new Ext.grid.GridPanel({
        name: 'leafGrid',
        id: 'leafGrid',
        border: false,
        store: leafStore,
        autoHeight: false,
        columns: leafColumnModel,
        plugins: [leafFilters],
        loadMask: true,
        sm: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            forceFit: true,
            emptyText: emptyTextLabel
        },
        iconCls: 'application_view_detail',
        listeners: {
            'rowclick': function (object, rowIndex, e) {
                var record = leafStore.getAt(rowIndex);
                formPanel.getForm().reset();
                formPanel.form.load({
                    url: '../controller/leafController.php',
                    method: 'POST',
                    waitTitle: systemLabel,
                    waitMsg: waitMessageLabel,
                    params: {
                        method: 'read',
                        mode: 'update',
                        leafId: record.data.leafId,
                        leafIdTemp: leafIdTemp
                    },
                    success: function (form, action) {
                        Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
                        Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
                        Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
                        Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
                        Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                        religionDetailStore.load({
                            params: {
                                leafId: leafId,
                                isAdmin: isAdmin,
                                religionId: record.data.religionId
                            }
                        });
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
                Ext.getCmp('newButton').disable();
                Ext.getCmp('saveButton').enable();
                Ext.getCmp('deleteButton').enable();
                Ext.getCmp('translation').enable();
                leafTranslateStore.load({
                    params: {
                        method: 'read',
                        leafId: record.data.leafId,
                        leafId: leafId,
                        isAdmin: isAdmin
                    }
                });
                leafAccessStore.load({
                    params: {
                        method: 'read',
                        leafId: record.data.leafId,
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
                        leafStore.each(function (rec) {
                            for (var access in leafFlagArray) {
                                rec.set(
                                leafFlagArray[access], true);
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
                        leafStore.each(function (rec) {
                            for (var access in leafFlagArray) {
                                rec.set(
                                leafFlagArray[access], false);
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
                        var url = '../controller/leafController.php?';
                        var sub_url = '';
                        var modified = leafStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            var record = leafStore.getAt(i);
                            sub_url = sub_url + '&leafId[]=' + record.get('leafId');
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
                                leafIdTemp: leafIdTemp,
                                isAdmin: isAdmin,
                                method: 'updateStatus'
                            },
                            success: function (
                            response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse.success == true) {
                                    Ext.MessageBox.alert(
                                    systemLabel, jsonResponse.message);
                                    leafStore.reload();
                                } else if (jsonResponse.success == false) {
                                    Ext.MessageBox.alert(
                                    systemErrorLabel, jsonResponse.message);
                                }
                            },
                            failure: function (
                            response, options) {
                                Ext.MessageBox.alert(
                                systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                            }
                        });
                    }
                }
            }]
        },
        bbar: new Ext.PagingToolbar({
            store: leafStore,
            pageSize: perPage
        })
    });
    var leafTranslateProxy = new Ext.data.HttpProxy({
        url: '../controller/leafTranslateController.php',
        method: 'POST',
        success: function (response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            }
        },
        failure: function (response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var leafTranslateReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'leafTranslateId'
    });
    var leafTranslateStore = new Ext.data.JsonStore({
        proxy: leafTranslateProxy,
        reader: leafTranslateReader,
        autoLoad: false,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: 'read',
            leafId: leafIdTemp
        },
        root: 'data',
        fields: [{
            name: 'leafTranslateId',
            type: 'int'
        }, {
            name: 'leafId',
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
            name: 'leafNative',
            type: 'string'
        }]
    });
    var leafTranslateColumnModel = [new Ext.grid.RowNumberer(),
                                    {
                                        dataIndex: 'leafEnglish',
                                        header: 'leafEnglish',
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
                                        dataIndex: 'leafNative',
                                        header: 'leafNative',
                                        sortable: true,
                                        hidden: false,
                                        width: 100,
                                        editor: {
                                            xtype: 'textfield',
                                            id: 'leafNative'
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
    var leafTranslateEditor = new Ext.ux.grid.RowEditor({
        saveText: saveButtonLabel,
        cancelText: cancelButtonLabel,
        listeners: {
            CancelEdit: function (rowEditor, changes, record, rowIndex) {
                leafTranslateStore.reload();
            },
            afteredit: function (rowEditor, changes, record, rowIndex) {
                this.save = true;
                var record = this.grid.getStore().getAt(
                rowIndex);
                Ext.Ajax.request({
                    url: '../controller/leafTranslateController.php',
                    method: 'POST',
                    waitTitle: systemLabel,
                    waitMsg: waitMessageLabel,
                    params: {
                        leafIdTemp: leafIdTemp,
                        method: method,
                        leafTranslateId: record.get('leafTranslateId'),
                        leafTranslate: Ext.getCmp('leafTranslate').getValue()
                    },
                    success: function (response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse == false) {
                            Ext.MessageBox.alert(
                            systemErrorLabel, jsonResponse.message);
                        } else { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
                            leafTranslateStore.reload();
                        }
                    },
                    failure: function (response, options) {
                        Ext.MessageBox.alert(
                        systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                    }
                });
            }
        }
    });
    var leafTranslateEntity = Ext.data.Record.create([{
        name: 'leafTranslateId',
        type: 'int'
    }, {
        name: 'leafId',
        type: 'int'
    }, {
        name: 'leafNative',
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
    var	leafTranslateFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];

    var leafTranslateGrid = new Ext.grid.GridPanel({
        name: 'leafTranslateGrid',
        id: 'leafTranslateGrid',
        border: false,
        store: leafTranslateStore,
        height: 400,
        autoScroll: true,
        columns: leafTranslateColumnModel,
        disabled: true,
        viewConfig: {
            autoFill: true,
            forceFit: true
        },
        layout: 'fit',
        disable : true,
        plugins: [leafTranslateEditor],
        tbar: {
            items: [{
                xtype: 'button',
                iconCls: 'add',
                id: 'add_record',
                name: 'add_record',
                text: newButtonLabel,
                handler: function () {
                    var newRecord = new leafTranslateEntity({
                        leafTranslateId: '',
                        leafId: '',
                        leafNative: '',
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
                    leafTranslateEditor.stopEditing();
                    leafTranslateStore.insert(0, newRecord);
                    leafTranslateGrid.getSelectionModel().getSelections();
                    leafTranslateEditor.startEditing(0);
                }
            }, {
                xtype: 'button',
                text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function (button, e) {
                        leafTranslateStore.each(function (rec) {
                            for (var access in leafTranslateFlagArray) {
                                rec.set(leafTranslateFlagArray[access], true);
                            }
                        });
                    }
                }
            }, {
                text: ClearAllLabel,
                iconCls: 'row-check-sprite-uncheck',
                listeners: {
                    'click': function (button, e) {
                        leafTranslateStore.each(function (rec) {
                            for (var access in leafTranslateFlagArray) {
                                rec.set(leafTranslateFlagArray[access], false);
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
                        var url = '../controller/leafTranslateController.php?';
                        var sub_url = '';
                        var modified = leafTranslateStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            var record = leafTranslateStore.getAt(i);
                            sub_url = sub_url + '&leafTranslateId[]=' + record.get('leafTranslateId');
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
                                method: 'updateStatus'
                            },
                            success: function (response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse.success == true) {
                                    Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                    leafTranslateStore.reload();
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
            store: leafTranslateStore,
            pageSize: perPage
        }),
        view: new Ext.ux.grid.BufferView({
            rowHeight: 34,
            scrollDelay: false
        })
    });
    // start leaf Access Request
    var leafAccessProxy = new Ext.data.HttpProxy({
        url: '../controller/leafAccessController.php',
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
    var leafAccessReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'leafAccessId'
    });
    var leafAccessStore = new Ext.data.JsonStore({
        autoDestroy: true,
        proxy: leafAccessProxy,
        reader: leafAccessReader,
        baseParams: {
            method: 'read',
            isAdmin: isAdmin,
            leafId: leafId
        },
        root: 'data',
        fields: [{
            name: 'leafId',
            type: 'int'
        }, {
            name: 'leafEnglish',
            type: 'string'
        }, {
            name: 'teamId',
            type: 'int'
        }, {
            name: 'teamEnglish',
            type: 'string'
        }, {
            name: 'leafId',
            type: 'int'
        }, {
            name: 'leafAccessId',
            type: 'int'
        }, {
            name: 'leafEnglish',
            type: 'string'
        }, {
            name: 'leafAccessValue',
            type: 'boolean'
        }]
    });

    var leafAccessValue = new Ext.ux.grid.CheckColumn({
        header: 'Access',
        dataIndex: 'leafAccessValue'
    });
    var leafAccessColumnModel = new Ext.grid.ColumnModel({
        columns: [{
            header: 'team',
            dataIndex: 'teamEnglish'
        }, {
            header: 'leaf',
            dataIndex: 'leafEnglish'
        },
        leafAccessValue]
    });
    var leafAccessFlagArray = ['leafAccessCreateValue', 'leafAccessReadValue', 'leafAccessUpdateValue', 'leafAccessDeleteValue', 'leafAccessPrintValue', 'leafAccessPostValue', 'leafAccessReviewValue', 'leafAccessDraftValue'];

    var leafAccessGrid = new Ext.grid.GridPanel({
        name: 'leafAccessGrid',
        id: 'leafAccessGrid',
        region: 'west',
        store: leafAccessStore,
        cm: leafAccessColumnModel,
        frame: true,
        title: 'leaf Access Grid',
        autoHeight: true,
        disabled: true,
        selModel: leafAccessValue,
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
                        leafAccessStore.each(function (rec) {                            
                        	for (var access in leafAccessFlagArray) {
                                rec.set(leafAccessFlagArray[access], true);
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
                        leafAccessStore.each(function (rec) {
                            for (var access in leafAccessFlagArray) {
                                rec.set(leafAccessFlagArray[access], false);
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
                        var url = '../controller/leafAccessController.php?method=update&leafId=' + leafId;
                        var sub_url = '';
                        var modified = leafAccessStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            var record = leafAccessStore.getAt(i);
                            sub_url = sub_url + '&leafAccessId[]=' + record.get('leafAccessId');
                            if (dataChanges.leafAccessId == true || dataChanges.leafAccessId == false) {
                                sub_url = sub_url + '&leafAccessValue[]=' + record.get('leafAccessValue');
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
                                leafAccessStore.reload();
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

    // end leaf Access Request
    // start leafTeam Access Request
    var leafTeamAccessProxy = new Ext.data.HttpProxy({
        url: '../controller/leafTeamAccessController.php',
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
    var leafTeamAccessReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'leafTeamAccessId'
    });
    var leafTeamAccessStore = new Ext.data.JsonStore({
        autoDestroy: true,
        proxy: leafTeamAccessProxy,
        reader: leafTeamAccessReader,
        baseParams: {
            method: 'read',
            isAdmin: isAdmin,
            leafTeamId: leafTeamId
        },
        root: 'data',
        fields: [{
            name: 'leafTeamId',
            type: 'int'
        }, {
            name: 'leafTeamEnglish',
            type: 'string'
        }, {
            name: 'teamId',
            type: 'int'
        }, {
            name: 'teamEnglish',
            type: 'string'
        }, {
            name: 'leafTeamId',
            type: 'int'
        }, {
            name: 'leafTeamAccessId',
            type: 'int'
        }, {
            name: 'leafTeamEnglish',
            type: 'string'
        }, {
            name: 'leafTeamAccessValue',
            type: 'boolean'
        }]
    });

    var leafTeamAccessValue = new Ext.ux.grid.CheckColumn({
        header: 'Access',
        dataIndex: 'leafTeamAccessValue'
    });
    var leafTeamAccessColumnModel = new Ext.grid.ColumnModel({
        columns: [{
            header: 'team',
            dataIndex: 'teamEnglish'
        }, {
            header: 'leafTeam',
            dataIndex: 'leafTeamEnglish'
        },
        leafTeamAccessValue]
    });
    var leafTeamAccessFlagArray = ['leafTeamAccessCreateValue', 'leafTeamAccessReadValue', 'leafTeamAccessUpdateValue', 'leafTeamAccessDeleteValue', 'leafTeamAccessPrintValue', 'leafTeamAccessPostValue'];

    var leafTeamAccessGrid = new Ext.grid.GridPanel({
        name: 'leafTeamAccessGrid',
        id: 'leafTeamAccessGrid',
        region: 'west',
        store: leafTeamAccessStore,
        cm: leafTeamAccessColumnModel,
        frame: true,
        title: 'leafTeam Access Grid',
        autoHeight: true,
        disabled: true,
        selModel: leafTeamAccessValue,
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
                        leafTeamAccessStore.each(function (rec) {                            
                        	for (var access in leafTeamAccessFlagArray) {
                                rec.set(leafTeamAccessFlagArray[access], true);
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
                        leafTeamAccessStore.each(function (rec) {
                            for (var access in leafTeamAccessFlagArray) {
                                rec.set(leafTeamAccessFlagArray[access], false);
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
                        var url = '../controller/leafTeamAccessController.php?method=update&leafTeamId=' + leafTeamId;
                        var sub_url = '';
                        var modified = leafTeamAccessStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            var record = leafTeamAccessStore.getAt(i);
                            sub_url = sub_url + '&leafTeamAccessId[]=' + record.get('leafTeamAccessId');
                            if (dataChanges.leafTeamAccessId == true || dataChanges.leafTeamAccessId == false) {
                                sub_url = sub_url + '&leafTeamAccessValue[]=' + record.get('leafTeamAccessValue');
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
                                leafTeamAccessStore.reload();
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

    // end leafTeam Access Request
    
    
    // start building form and grid
    var gridPanel = new Ext.Panel({
        name: 'gridPanel',
        id: 'gridPanel',
        title: leafNative,
        height: 50,
        layout: 'fit',
        iconCls: 'application_view_detail',
        tbar: [{
            text: reloadToolbarLabel,
            iconCls: 'database_refresh',
            id: 'pageReload',
            disabled: pageReload,
            handler: function () {
                leafStore.reload();
            }
        }, {
            text: addToolbarLabel,
            iconCls: 'add',
            id: 'pageCreate',
            disabled: pageCreate,
            handler: function () {
                viewPort.items.get(1).expand();
            }
        }, {
            text: excelToolbarLabel,
            iconCls: 'page_excel',
            id: 'page_excel',
            disabled: pagePrint,
            handler: function () {
                Ext.Ajax.request({
                    url: '../controller/leafController.php',
                    method: 'GET',
                    params: {
                        method: 'report',
                        mode: 'excel',
                        limit: perPage,
                        leafId: leafTempId
                    },
                    success: function (response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == true) {
                            window.open('../../security/document/excel/' + jsonResponse.filename);
                        } else {
                            Ext.MessageBox.alert(successLabel, jsonResponse.message);
                        }
                    },
                    failure: function (response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                    }
                });
            }
        },
        new Ext.ux.form.SearchField({
            store: leafStore,
            width: 320
        })],
        items: [leafGrid]
    }); // viewport just save information,items will do separate
    // only load store when viewport is open
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
        createValueMatcher: function (value) {
            value = String(value).replace(/\s*/g, '');
            if (Ext.isEmpty(value, false)) {
                return new RegExp('^');
            }
            value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
            return new RegExp('\\b(' + value + ')', 'i');
        },
        listeners: {
            'select': function (combo, record, index) {
                Ext.Ajax.request({
                    url: '../controller/leafController.php',
                    method: 'GET',
                    params: {
                        method: 'read',
                        field: 'sequence',
                        table: 'folder',
                        moduleId: combo.value,
                        leafIdTemp: leafIdTemp
                    },
                    success: function (response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == false) {
                            Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                        } else {
                            Ext.getCmp('folderSequence').setValue(
                            jsonResponse.nextSequence);
                        }
                    },
                    failure: function (response, options) {
                        Ext.MessageBox.alert(systemLabel, escape(response.status) + ':' + escape(response.statusText));
                    }
                });
            }
        }
    }); // viewport just save information,items will do separate
    var moduleId = new Ext.ux.form.ComboBoxMatch({
        labelAlign: 'left',
        fieldLabel: moduleIdLabel,
        name: 'moduleId',
        hiddenName: 'moduleId',
        valueField: 'moduleId',
        id: 'module_fake',
        displayField: 'moduleEnglish',
        typeAhead: false,
        triggerAction: 'all',
        store: moduleStore,
        anchor: '95%',
        selectOnFocus: true,
        mode: 'local',
        allowBlank: false,
        blankText: blankTextLabel,
        createValueMatcher: function (value) {
            value = String(value).replace(/\s*/g, '');
            if (Ext.isEmpty(value, false)) {
                return new RegExp('^');
            }
            value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
            return new RegExp('\\b(' + value + ')', 'i');
        },
        listeners: {
            'select': function () {
                folderStore.load({
                    params: {
                        leafIdTemp: leafIdTemp,
                        isAdmin: isAdmin,
                        method: 'read',
                        field: 'folderId',
                        type: 1,
                        moduleId: this.value
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
        id: 'folder_fake',
        displayField: 'folderEnglish',
        typeAhead: false,
        triggerAction: 'all',
        store: folderStore,
        anchor: '95%',
        selectOnFocus: true,
        mode: 'local',
        allowBlank: false,
        blankText: blankTextLabel,
        disabled: true,
        createValueMatcher: function (value) {
            value = String(value).replace(/\s*/g, '');
            if (Ext.isEmpty(value, false)) {
                return new RegExp('^');
            }
            value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
            return new RegExp('\\b(' + value + ')', 'i');
        },
        listeners: {
            'select': function (combo, record, index) {
                Ext.Ajax.request({
                    url: '../controller/leafController.php',
                    method: 'GET',
                    params: {
                        method: 'read',
                        field: 'sequence',
                        table: 'leaf',
                        moduleId: Ext.getCmp('tab_fake').getValue(),
                        folderId: combo.value,
                        leafIdTemp: leafIdTemp,
                        isAdmin: isAdmin
                    },
                    success: function (response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == false) {
                            Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                        } else {
                            Ext.getCmp('leafSequence').setValue(
                            jsonResponse.nextSequence);
                        }
                    },
                    failure: function (response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                    }
                });
            }
        }
    });
    var leafCode = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: leafCodeLabel,
        hiddenName: 'leafCode',
        name: 'leafCode',
        anchor: '95%'
    });
    var leafEnglish = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: leafEnglishLabel,
        hiddenName: 'leafEnglish',
        name: 'leafEnglish',
        anchor: '95%'
    });
    var leafSequence = new Ext.form.NumberField({
        labelAlign: 'left',
        fieldLabel: leafSequenceLabel,
        hiddenName: 'leafSequence',
        name: 'leafSequence',
        id: 'leafSequence',
        anchor: '95%'
    });
    var leafFilename = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: leafFilenameLabel,
        hiddenName: 'leafFilename',
        name: 'leafFilename',
        anchor: '95%'
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
        ['361', 'database'],
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
        ['491', 'folder'],
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
        ['963', 'tab'],
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
        anchor: '95%',
        triggerAction: 'all',
        valueField: 'iconId',
        displayField: 'iconName',
        iconClsTpl: '{iconName}'
    }); // hidden id for updated
    var leafId = new Ext.form.Hidden({
        name: 'leafId',
        id: 'leafId'
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
        url: '../controller/leafController.php',
        name: 'formPanel',
        id: 'formPanel',
        method: 'post',
        frame: true,
        title: leafNative,
        border: false,
        bodyStyle: 'padding: 10px',
        width: 600,
        iconCls: 'application_form',
        items: [{
            xtype: 'panel',
            title: leafNative,
            bodyStyle: 'padding:5px',
            layout: 'form',
            frame: true,
            items: [moduleId, folderId, leafCode, leafEnglish, leafSequence, leafFilename, iconId, leafId]
        }, {
            xtype: 'panel',
            title: 'Leaf Translation',
            items: [leafTranslateGrid]
        }],
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
            handler: function () {
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
                
                var id = Ext.getCmp('leafId').getValue();
                var method = 'create';
                formPanel.getForm().submit({
                    waitTitle: systemLabel,
                    waitMsg: waitMessageLabel,
                    params: {
                        method: method,
                        leafIdTemp: leafIdTemp,
                        isAdmin: isAdmin
                    },
                    success: function (
                    form, action) {
                        if (action.result.success == true) {
                            Ext.MessageBox.alert(
                            systemLabel, action.result.message);
                            Ext.getCmp('leafTranslateGrid').enable();
                            Ext.getCmp('deleteButton').enable();
                            leafStore.reload({
                                params: {
                                    leafTempId: leafTempId,
                                    start: 0,
                                    limit: perPage
                                }
                            });
                            Ext.getCmp('leafId').setValue(
                            action.result.leafId);
                        } else {
                            Ext.MessageBox.alert(
                            systemErrorLabel, action.result.message);
                        }
                    },
                    failure: function (
                    form, action) {
                        if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
                            Ext.Msg.alert(
                            systemErrorLabel, loadFailureLabel);
                        } else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
                            Ext.Msg.alert(
                            systemErrorLabel, clientInvalidLabel);
                        } else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
                            Ext.Msg.alert(form.response.status + ' ' + form.response.statusText);
                        } else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
                            Ext.Msg.alert(
                            systemErrorLabel, action.result.message);
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
                
                var id = Ext.getCmp('leafId').getValue();
                var method = 'save';
                formPanel.getForm().submit({
                    waitTitle: systemLabel,
                    waitMsg: waitMessageLabel,
                    params: {
                        method: method,
                        leafIdTemp: leafIdTemp,
                        isAdmin: isAdmin
                    },
                    success: function (
                    form, action) {
                        if (action.result.success == true) {
                            Ext.MessageBox.alert(
                            systemLabel, action.result.message);
                            Ext.getCmp('leafTranslateGrid').enable();
                            Ext.getCmp('deleteButton').enable();
                            leafStore.reload({
                                params: {
                                    leafIdTemp: leafIdTemp,
                                    isAdmin: isAdmin,
                                    start: 0,
                                    limit: perPage
                                }
                            });
                            Ext.getCmp('leafId').setValue(
                            action.result.leafId);
                        } else {
                            Ext.MessageBox.alert(
                            systemErrorLabel, action.result.message);
                        }
                    },
                    failure: function (
                    form, action) {
                        if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
                            Ext.Msg.alert(
                            systemErrorLabel, loadFailureLabel);
                        } else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
                            Ext.Msg.alert(
                            systemErrorLabel, clientInvalidLabel);
                        } else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
                            Ext.Msg.alert(form.response.status + ' ' + form.response.statusText);
                        } else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
                            Ext.Msg.alert(
                            systemErrorLabel, action.result.message);
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
                Ext.getCmp('leafTranslateGrid').disable();
                Ext.getCmp('leafAccessGrid').disable();
                Ext.Msg.show({
                    title: deleteRecordTitleMessageLabel,
                    msg: deleteRecordMessageLabel,
                    icon: Ext.Msg.QUESTION,
                    buttons: Ext.Msg.YESNO,
                    scope: this,
                    fn: function (response) {
                        if ('yes' == response) {
                            Ext.Ajax.request({
                                url: '../controller/leafController.php',
                                params: {
                                    method: 'delete',
                                    leafId: Ext.getCmp('leafId').getValue(),
                                    leafIdTemp: leafIdTemp,
                                    isAdmin: isAdmin
                                },
                                success: function (
                                response, options) {
                                    jsonResponse = Ext.decode(response.responseText);
                                    if (jsonResponse.success == true) {
                                        Ext.MessageBox.alert(
                                        systemLabel, jsonResponse.message);
                                        leafStore.reload({
                                            params: {
                                                leafIdTemp: leafIdTemp,
                                                isAdmin: isAdmin,
                                                start: 0,
                                                limit: perPage
                                            }
                                        });
                                        Ext.getCmp('leafTranslateGrid').disable();
                                        Ext.getCmp('saveButton').disable();
                                        Ext.getCmp('nextButton').disable();
                                        Ext.getCmp('previousButton').disable();
                                        Ext.getCmp('translation').disable();
                                    } else {
                                        Ext.MessageBox.alert(
                                        systemErrorLabel, jsonResponse.message);
                                    }
                                },
                                failure: function (
                                response, options) {
                                    Ext.MessageBox.alert(
                                    systemErrorLabel, escape(response.status) + ':' + response.statusText);
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
                Ext.getCmp('leafTranslateGrid').disable();
                Ext.getCmp('leafAccessGrid').disable();
                formPanel.getForm().reset();
            }
        }, {
            text: postButtonLabel,
            type: 'button',
            name: 'postButton',
            id: 'postButton',
            iconCls: 'lock',
            handler: function () {
                Ext.getCmp('newButton').disable();
                Ext.getCmp('leafTranslateGrid').disable();
                Ext.getCmp('leafAccessGrid').disable();
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
                Ext.getCmp('leafAccessGrid').enable();
                if (Ext.getCmp('firstRecord').getValue() == '' || Ext.getCmp('firstRecord').getValue() == undefined) {
                    Ext.Ajax.request({
                        url: '../controller/leafController.php',
                        method: 'GET',
                        params: {
                            method: 'dataNavigationRequest',
                            leafIdTemp: leafIdTemp,
                            dataNavigation: 'firstRecord'
                        },
                        success: function (
                        response, options) {
                            jsonResponse = Ext.decode(response.responseText);
                            if (jsonResponse.success == true) {
                                Ext.getCmp('firstRecord').setValue(
                                jsonResponse.firstRecord);
                                formPanel.form.load({
                                    url: '../controller/leafController.php',
                                    method: 'POST',
                                    waitTitle: systemLabel,
                                    waitMsg: waitMessageLabel,
                                    params: {
                                        method: 'read',
                                        leafId: Ext.getCmp('firstRecord').getValue(),
                                        leafTempId: leafTempId,
                                        isAdmin: isAdmin
                                    },
                                    success: function (
                                    form, action) {
                                        if (action.result.success == true) {
                                            if (action.result.nextRecord == 0) {
                                                Ext.getCmp('nextButton').disable();
                                            } else {
                                                Ext.getCmp('nextButton').enable();
                                            }
                                            Ext.getCmp('firstRecord').setValue(
                                            action.result.firstRecord);
                                            Ext.getCmp('previousRecord').setValue(
                                            action.result.previousRecord);
                                            Ext.getCmp('nextRecord').setValue(
                                            action.result.nextRecord);
                                            Ext.getCmp('lastRecord').setValue(
                                            action.result.lastRecord);
                                            Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                                            Ext.getCmp('previousButton').disable();
                                            leafTranslateStore.load({
                                                params: {
                                                    leafIdTemp: leafIdTemp,
                                                    isAdmin: isAdmin,
                                                    leafId: action.result.data.leafId
                                                }
                                            });
                                            leafTranslateGrid.enable();
                                            leafAccessStore.load({
                                                params: {
                                                    leafIdTemp: leafIdTemp,
                                                    isAdmin: isAdmin,
                                                    leafId: action.result.data.leafId
                                                }
                                            });
                                            leafAccessGrid.enable();
                                        } else {
                                            Ext.MessageBox.alert(
                                            systemErrorLabel, action.result.message);
                                        }
                                    },
                                    failure: function (
                                    form, action) {
                                        Ext.MessageBox.alert(
                                        systemErrorLabel, action.result.message);
                                    }
                                });
                            } else {
                                Ext.MessageBox.alert(
                                systemErrorLabel, jsonResponse.message);
                            }
                        },
                        failure: function (
                        response, options) {
                            Ext.MessageBox.alert(
                            systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                        }
                    });
                } else {
                    formPanel.form.load({
                        url: '../controller/leafController.php',
                        method: 'POST',
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: 'read',
                            leafId: Ext.getCmp('firstRecord').getValue(),
                            leafIdTemp: leafIdTemp,
                            isAdmin: isAdmin
                        },
                        success: function (
                        form, action) {
                            if (action.result.success == true) {
                                if (action.result.nextRecord == 0) {
                                    Ext.getCmp('nextButton').disable();
                                } else {
                                    Ext.getCmp('nextButton').enable();
                                }
                                Ext.getCmp('firstRecord').setValue(
                                action.result.firstRecord);
                                Ext.getCmp('previousRecord').setValue(
                                action.result.previousRecord);
                                Ext.getCmp('nextRecord').setValue(
                                action.result.nextRecord);
                                Ext.getCmp('lastRecord').setValue(
                                action.result.lastRecord);
                                Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                                Ext.getCmp('previousButton').disable();
                                leafTranslateStore.load({
                                    params: {
                                        leafIdTemp: leafIdTemp,
                                        isAdmin: isAdmin,
                                        leafId: action.result.data.leafId
                                    }
                                });
                                leafTranslateGrid.enable();
                                leafAccessStore.load({
                                    params: {
                                        leafIdTemp: leafIdTemp,
                                        isAdmin: isAdmin,
                                        leafId: action.result.data.leafId
                                    }
                                });
                                leafAccessGrid.enable();
                            } else {
                                Ext.MessageBox.alert(
                                systemErrorLabel, action.result.message);
                            }
                        },
                        failure: function (
                        form, action) {
                            Ext.MessageBox.alert(
                            systemErrorLabel, action.result.message);
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
                Ext.getCmp('leafTranslateGrid').enable();
                Ext.getCmp('leafAccessGrid').enable();
                if (Ext.getCmp('previousRecord').getValue() == '' || Ext.getCmp('previousRecord').getValue() == undefined) {
                    Ext.MessageBox.alert('Please Pick A Record First Ya');
                }
                if (Ext.getCmp('firstRecord').getValue() >= 1) {
                    formPanel.form.load({
                        url: '../controller/leafController.php',
                        method: 'POST',
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: 'read',
                            leafId: Ext.getCmp('previousRecord').getValue(),
                            leafIdTemp: leafIdTemp,
                            isAdmin: isAdmin
                        },
                        success: function (
                        form, action) {
                            if (action.result.success == true) {
                                Ext.getCmp('firstRecord').setValue(
                                action.result.firstRecord);
                                Ext.getCmp('previousRecord').setValue(
                                action.result.previousRecord);
                                Ext.getCmp('nextRecord').setValue(
                                action.result.nextRecord);
                                Ext.getCmp('lastRecord').setValue(
                                action.result.lastRecord);
                                Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                                leafTranslateStore.load({
                                    params: {
                                        leafIdTemp: leafIdTemp,
                                        isAdmin: isAdmin,
                                        leafId: action.result.data.leafId
                                    }
                                });
                                leafAccessStore.load({
                                    params: {
                                        leafIdTemp: leafIdTemp,
                                        isAdmin: isAdmin,
                                        leafId: action.result.data.leafId
                                    }
                                });
                                if (Ext.getCmp('previousRecord').getValue() == 0) {
                                    Ext.getCmp('previousButton').disable();
                                }
                                leafTranslateGrid.enable();
                            } else {
                                Ext.MessageBox.alert(
                                systemErrorLabel, action.result.message);
                            }
                        },
                        failure: function (
                        form, action) {
                            Ext.MessageBox.alert(
                            systemErrorLabel, action.result.message);
                        }
                    });
                } else { // empty record
                    Ext.MessageBox.alert(
                    systemErrorLabel, recordNotFoundLabel);
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
                Ext.getCmp('leafTranslateGrid').enable();
                Ext.getCmp('leafAccessGrid').enable();
                if (Ext.getCmp('nextRecord').getValue() == '' || Ext.getCmp('nextRecord').getValue() == undefined) {
                    Ext.MessageBox.alert('Please Pick A Record First Ya');
                }
                if (Ext.getCmp('nextRecord').getValue() <= Ext.getCmp('lastRecord').getValue()) {
                    formPanel.form.load({
                        url: '../controller/leafController.php',
                        method: 'POST',
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: 'read',
                            leafId: Ext.getCmp('nextRecord').getValue(),
                            leafIdTemp: leafIdTemp,
                            isAdmin: isAdmin
                        },
                        success: function (
                        form, action) {
                            if (action.result.success == true) {
                                Ext.getCmp('firstRecord').setValue(
                                action.result.firstRecord);
                                Ext.getCmp('previousRecord').setValue(
                                action.result.previousRecord);
                                Ext.getCmp('nextRecord').setValue(
                                action.result.nextRecord);
                                Ext.getCmp('lastRecord').setValue(
                                action.result.lastRecord);
                                Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                                leafTranslateStore.load({
                                    params: {
                                        leafTempd: leafIdTemp,
                                        isAdmin: isAdmin,
                                        leafId: action.result.data.leafId
                                    }
                                });
                                leafAccessStore.load({
                                    params: {
                                        leafIdTemp: leafIdTemp,
                                        isAdmin: isAdmin,
                                        leafId: action.result.data.leafId
                                    }
                                });
                                if (Ext.getCmp('nextRecord').getValue() > Ext.getCmp('lastRecord').getValue()) {
                                    Ext.getCmp('nextButton').disable();
                                }
                                if (Ext.getCmp('nextRecord').getValue() == 0) {
                                    Ext.getCmp('nextButton').disable();
                                }
                                Ext.getCmp('previousButton').enable();
                                leafTranslateGrid.enable();
                            } else {
                                Ext.MessageBox.alert(
                                systemErrorLabel, action.result.message);
                            }
                        },
                        failure: function (
                        form, action) {
                            Ext.MessageBox.alert(
                            systemErrorLabel, action.result.message);
                        }
                    });
                } else {
                    Ext.MessageBox.alert(
                    systemErrorLabel, 'Record Not Found');
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
                Ext.getCmp('leafTranslateGrid').enable();
                Ext.getCmp('leafAccessGrid').enable();
                if (Ext.getCmp('lastRecord').getValue() == '' || Ext.getCmp('lastRecord').getValue() == undefined) {
                    Ext.Ajax.request({
                        url: '../controller/leafController.php',
                        method: 'GET',
                        params: {
                            method: 'dataNavigationRequest',
                            leafIdTemp: leafIdTemp,
                            dataNavigation: 'lastRecord'
                        },
                        success: function (
                        response, options) {
                            jsonResponse = Ext.decode(response.responseText);
                            if (jsonResponse.success == true) {
                                Ext.getCmp('lastRecord').setValue(
                                jsonResponse.lastRecord);
                                formPanel.form.load({
                                    url: '../controller/leafController.php',
                                    method: 'POST',
                                    waitTitle: systemLabel,
                                    waitMsg: waitMessageLabel,
                                    params: {
                                        method: 'read',
                                        leafId: Ext.getCmp('lastRecord').getValue(),
                                        leafIdTemp: leafIdTemp,
                                        isAdmin: isAdmin
                                    },
                                    success: function (
                                    form, action) {
                                        if (action.result.success == true) {
                                            if (action.result.nextRecord == 0) {
                                                Ext.getCmp('previousButton').disable();
                                            } else {
                                                Ext.getCmp('previousButton').enable();
                                            }
                                            Ext.getCmp('firstRecord').setValue(
                                            action.result.firstRecord);
                                            Ext.getCmp('previousRecord').setValue(
                                            action.result.previousRecord);
                                            Ext.getCmp('nextRecord').setValue(
                                            action.result.nextRecord);
                                            Ext.getCmp('lastRecord').setValue(
                                            action.result.lastRecord);
                                            Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                                            leafTranslateStore.load({
                                                params: {
                                                    leafIdTemp: leafIdTemp,
                                                    isAdmin: isAdmin,
                                                    leafId: action.result.data.leafId
                                                }
                                            });
                                            leafAccessStore.load({
                                                params: {
                                                    leafIdTemp: leafIdTemp,
                                                    isAdmin: isAdmin,
                                                    leafId: action.result.data.leafId
                                                }
                                            });
                                            Ext.getCmp('nextButton').disable();
                                            Ext.getCmp('previousButton').enable();
                                            leafTranslateGrid.enable();
                                        } else {
                                            Ext.MessageBox.alert(
                                            systemErrorLabel, action.result.message);
                                        }
                                    },
                                    failure: function (
                                    form, action) {
                                        Ext.MessageBox.alert(
                                        systemErrorLabel, action.result.message);
                                    }
                                });
                            } else {
                                Ext.MessageBox.alert(
                                systemErrorLabel, jsonResponse.message);
                            }
                        },
                        failure: function (
                        response, options) {
                            Ext.MessageBox.alert(
                            systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                        }
                    });
                } else {
                    if (Ext.getCmp('leafId').getValue() <= Ext.getCmp('lastRecord').getValue()) {
                        formPanel.form.load({
                            url: '../controller/leafController.php',
                            method: 'POST',
                            waitTitle: systemLabel,
                            waitMsg: waitMessageLabel,
                            params: {
                                method: 'read',
                                leafId: Ext.getCmp('lastRecord').getValue(),
                                leafIdTemp: leafIdTemp,
                                isAdmin: isAdmin
                            },
                            success: function (
                            form, action) {
                                if (action.result.success == true) {
                                    if (action.result.previousRecord == 0) {
                                        Ext.getCmp('previousButton').disable();
                                    } else {
                                        Ext.getCmp('previousButton').enable();
                                    }
                                    Ext.getCmp('firstRecord').setValue(
                                    action.result.firstRecord);
                                    Ext.getCmp('previousRecord').setValue(
                                    action.result.previousRecord);
                                    Ext.getCmp('nextRecord').setValue(
                                    action.result.nextRecord);
                                    Ext.getCmp('lastRecord').setValue(
                                    action.result.lastRecord);
                                    Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
                                    leafTranslateStore.load({
                                        params: {
                                            leafIdTemp: leafIdTemp,
                                            isAdmin: isAdmin,
                                            leafId: action.result.data.leafId
                                        }
                                    });
                                    Ext.getCmp('nextButton').disable();
                                    Ext.getCmp('previousButton').enable();
                                    leafTranslateGrid.enable();
                                } else {
                                    Ext.MessageBox.alert(
                                    systemErrorLabel, action.result.message);
                                }
                            },
                            failure: function (
                            form, action) {
                                Ext.MessageBox.alert(
                                systemErrorLabel, action.result.message);
                            }
                        });
                    } else {
                        Ext.MessageBox.alert(
                        systemErrorLabel, recordNotFoundLabel);
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
                    url: '../controller/leafTranslateController.php',
                    method: 'GET',
                    params: {
                        leafIdTemp: leafIdTemp,
                        method: 'create',
                        leafId: Ext.getCmp('leafId').getValue()
                    },
                    success: function (
                    response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == true) {
                            Ext.MessageBox.alert(
                            systemLabel, jsonResponse.message);
                            leafTranslateStore.reload();
                        } else {
                            Ext.MessageBox.alert(
                            systemErrorLabel, jsonResponse.message);
                        }
                    },
                    failure: function (
                    response, options) {
                        Ext.MessageBox.alert(
                        systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                    }
                });
            }
        }]
    });
    var viewPort = new Ext.Viewport({
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