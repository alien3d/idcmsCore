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
        url: '../controller/teamController.php?',
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
    // end additional Proxy ,Reader,Store,Filter,Grid
    // start application Proxy ,Reader,Store,Filter,Grid
    var teamProxy = new Ext.data.HttpProxy({
        url: '../controller/teamController.php',
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
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            perPage: perPage
        },
        root: 'data',
        fields: [{
            name: 'teamId',
            type: 'int'
        },
        {
            name: 'teamSequence',
            type: 'string'
        },
        {
            name: 'teamCode',
            type: 'string'
        },
        {
            name: 'teamEnglish',
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
            type: 'int'
        },
        {
            name: 'isPost',
            type: 'boolean'
        },
        {
            name: 'executeTime',
            type: 'date',
            dateFormat: 'Y-m-d H:i:s'
        }]
    });
    var teamFilters = new Ext.ux.grid.GridFilters({
        encode: encode,
        local: local,
        filters: [{
            type: 'string',
            dataIndex: 'teamSequence',
            column: 'teamSequence',
            table: 'team'
        },
        {
            type: 'string',
            dataIndex: 'teamCode',
            column: 'teamCode',
            table: 'team'
        },
        {
            type: 'string',
            dataIndex: 'teamEnglish',
            column: 'teamEnglish',
            table: 'team'
        },
        {
            type: 'list',
            dataIndex: 'executeBy',
            column: 'executeBy',
            table: 'team',
            labelField: 'staffName',
            store: staffByStore,
            phpMode: true
        },
        {
            type: 'date',
            dataIndex: 'executeTime',
            column: 'executeTime',
            table: 'team'
        }]
    });
    var teamSequence = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: teamSequenceLabel + '<span style=\'color: red;\'>*</span>',
        hiddenName: 'teamSequence',
        name: 'teamSequence',
        id: 'teamSequence',
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '95%'
    });
    var teamCode = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: teamCodeLabel + '<span style=\'color: red;\'>*</span>',
        hiddenName: 'teamCode',
        name: 'teamCode',
        id: 'teamCode',
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: 'uppercase'
        },
        anchor: '95%'
    });
    var teamEnglish = new Ext.form.TextField({
        labelAlign: 'left',
        fieldLabel: teamEnglishLabel + '<span style=\'color: red;\'>*</span>',
        hiddenName: 'teamEnglish',
        name: 'teamEnglish',
        id: 'teamEnglish',
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
        header: isActiveLabel,
        dataIndex: 'isReview',
        hidden: isReviewHidden
    });
    var isPostGrid = new Ext.ux.grid.CheckColumn({
        header: isPostLabel,
        dataIndex: 'isReview',
        hidden: isApprovedHidden
    });
    var teamColumnModelGrid = [new Ext.grid.RowNumberer(), {
        dataIndex: 'teamSequence',
        header: teamSequenceLabel,
        sortable: true,
        hidden: false,
        editor: teamSequence
    },
    {
        dataIndex: 'teamCode',
        header: teamCodeLabel,
        sortable: true,
        hidden: false,
        editor: teamCode
    },
    {
        dataIndex: 'teamEnglish',
        header: teamEnglishLabel,
        sortable: true,
        hidden: false,
        editor: teamEnglish
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
    var teamFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
    var teamEditor = new Ext.ux.grid.RowEditor({
        saveText: saveButtonLabel,
        cancelText: cancelButtonLabel,
        listeners: {
            CancelEdit: function(rowEditor, changes, record, rowIndex) {
                teamStore.reload();
            },
            afteredit: function(rowEditor, changes, record, rowIndex) {
                var method;
                this.save = true;
                var record = this.grid.getStore().getAt(rowIndex);
                if (record.get('teamId') > 0) {
                    method = 'save';
                } else {
                    method = 'create';
                }
                Ext.Ajax.request({
                    url: '../controller/teamController.php',
                    method: 'POST',
                    params: {
                        method: method,
                        leafId: leafId,
                        isAdmin: isAdmin,
                        teamSequence: record.get('teamSequence'),
                        teamCode: record.get('teamCode'),
                        teamEnglish: record.get('teamEnglish'),
                        teamId: record.get('teamId'),
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
                teamStore.reload();
            }
        }
    });
    var teamEntity = Ext.data.Record.create([{
        name: 'teamId',
        type: 'int'
    },
    {
        name: 'teamSequence',
        type: 'string'
    },
    {
        name: 'teamCode',
        type: 'string'
    },
    {
        name: 'teamEnglish',
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
    var teamGrid = new Ext.grid.GridPanel({
        name: 'teamGrid',
        id: 'teamGrid',
        border: false,
        store: teamStore,
        autoHeight: false,
        height: 400,
        columns: teamColumnModelGrid,
        plugins: [teamFilters, teamEditor],
        selModel: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            emptyText: emptyTextLabel
        },
        iconCls: 'application_view_detail',
        tbar: [{
       
                iconCls: 'add',
                id: 'add_record',
                name: 'add_record',
                text: newButtonLabel,
                handler: function() {
                    var newRecord = new teamEntity({
                        teamId: '',
                        teamSequence: '',
                        teamCode: '',
                        teamEnglish: '',
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
                    teamEditor.stopEditing();
                    teamStore.insert(0, newRecord);
                    teamGrid.getSelectionModel().getSelections();
                    teamEditor.startEditing(0);
                }
            },
            {
                xtype:'button',
            	text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function(button,e) {
                        teamStore.each(function(record,fn,scope) {
                            for (var access in teamFlagArray) {
                                record.set(teamFlagArray[access], true);
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
                        teamStore.each(function(record,fn,scope) {
                            for (var access in teamFlagArray) {
                                record.set(teamFlagArray[access], false);
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
                        var url = '../controller/teamController.php?';
                        var sub_url = '';
                        var modified = teamStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            sub_url = sub_url + '&teamId[]=' + modified[i].get('teamId');
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
                                        teamStore.removeAll();
                                        teamStore.reload();
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
                }
            }],
            bbar: new Ext.PagingToolbar({
                store: teamStore,
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
                    teamStore.reload();
                }
            },
            '-', {
                text: excelToolbarLabel,
                iconCls: 'page_excel',
                id: 'page_excel',
                
                handler: function() {
                    Ext.Ajax.request({
                        url: '../controller/teamController.php',
                        method: 'GET',
                        params: {
                            method: 'report',
                            mode: 'excel',
                            limit: perPage,
                            leafId: leafId,
                            isAdmin: isAdmin
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
                store: teamStore,
                width: 320
            })],
            items: [teamGrid]
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