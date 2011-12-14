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
        url: '../controller/countryController.php?',
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
    
    // end additional Proxy ,Reader,Store,Filter,Grid
    // start application Proxy ,Reader,Store,Filter,Grid
    
    var countryProxy = new Ext.data.HttpProxy({
            url : '../controller/countryController.php',
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
         
    var countryReader = new Ext.data.JsonReader({
            totalProperty : 'total',
            successProperty : 'success',
            messageProperty : 'message',
            idProperty : 'countryId'
        });
         
    var countryStore = new Ext.data.JsonStore({
            proxy : countryProxy,
            reader : countryReader,
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
            id : 'countryId',
            fields : [{
            key :'PRI',
            foreignKey : 'no',
            name : 'countryId',
            type : 'int'},{
            key :'',
            foreignKey : 'no',
            name : 'countrySequence',
            type : 'int'},{
            key :'',
            foreignKey : 'no',
            name : 'countryCode',
            type : 'string'},{
            key :'',
            foreignKey : 'no',
            name : 'countryCurrencyCode',
            type : 'string'},{
            key :'',
            foreignKey : 'no',
            name : 'countryCurrencyCodeDesc',
            type : 'string'},{
            key :'',
            foreignKey : 'no',
            name : 'countryDesc',
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
            type : 'boolean'},{
            key :'',
            foreignKey : 'no',
            name : 'executeTime',
            type : 'boolean'}
            ]
        });
     
    // end country request
    var countryFilters = new Ext.ux.grid.GridFilters(
            {
                encode : false,
                local : false,
                filters : [
        {
            type : 'int',
            dataIndex : 'countryId',
            column : 'countryId',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'int',
            dataIndex : 'countrySequence',
            column : 'countrySequence',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'string',
            dataIndex : 'countryCode',
            column : 'countryCode',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'string',
            dataIndex : 'countryCurrencyCode',
            column : 'countryCurrencyCode',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'string',
            dataIndex : 'countryCurrencyCodeDesc',
            column : 'countryCurrencyCodeDesc',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'string',
            dataIndex : 'countryDesc',
            column : 'countryDesc',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isDefault',
            column : 'isDefault',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isNew',
            column : 'isNew',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isDraft',
            column : 'isDraft',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isUpdate',
            column : 'isUpdate',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isDelete',
            column : 'isDelete',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isActive',
            column : 'isActive',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isApproved',
            column : 'isApproved',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isReview',
            column : 'isReview',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isPost',
            column : 'isPost',
            table : 'country',
            database : 'ifinancial'
        },{
            type : 'list',
            dataIndex : 'executeBy',
            column : 'executeBy',
            table : 'country',
            database : 'ifinancial',
            labelField : 'staffName',
            store : staffByStore,
            phpMode : true
        },
        {
            type : 'boolean',
            dataIndex : 'executeTime',
            column : 'executeTime',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'int',
            dataIndex : 'countryId',
            column : 'countryId',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'int',
            dataIndex : 'countrySequence',
            column : 'countrySequence',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'string',
            dataIndex : 'countryCode',
            column : 'countryCode',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'string',
            dataIndex : 'countryCurrencyCode',
            column : 'countryCurrencyCode',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'string',
            dataIndex : 'countryCurrencyCodeDesc',
            column : 'countryCurrencyCodeDesc',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'string',
            dataIndex : 'countryDesc',
            column : 'countryDesc',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isDefault',
            column : 'isDefault',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isNew',
            column : 'isNew',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isDraft',
            column : 'isDraft',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isUpdate',
            column : 'isUpdate',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isDelete',
            column : 'isDelete',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isActive',
            column : 'isActive',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isApproved',
            column : 'isApproved',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isReview',
            column : 'isReview',
            table : 'country',
            database : 'ifinancial'
        },
        {
            type : 'boolean',
            dataIndex : 'isPost',
            column : 'isPost',
            table : 'country',
            database : 'ifinancial'
        },{
            type : 'list',
            dataIndex : 'executeBy',
            column : 'executeBy',
            table : 'country',
            database : 'ifinancial',
            labelField : 'staffName',
            store : staffByStore,
            phpMode : true
        },
        {
            type : 'boolean',
            dataIndex : 'executeTime',
            column : 'executeTime',
            table : 'country',
            database : 'ifinancial'
        }]});
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
        hidden: isActiveHidden
    });
    var isPostGrid = new Ext.ux.grid.CheckColumn({
        header: 'Post',
        dataIndex: 'isPost',
        hidden: isPostHidden
    });
    var countryColumnModel = [
                              new Ext.grid.RowNumberer(),{
                                              dataIndex : 'countrySequence',
                                              header : countrySequenceLabel,
                                              sortable : true,
                                              hidden : false
                                          },{
                                              dataIndex : 'countryCode',
                                              header : countryCodeLabel,
                                              sortable : true,
                                              hidden : false
                                          },{
                                              dataIndex : 'countryCurrencyCode',
                                              header : countryCurrencyCodeLabel,
                                              sortable : true,
                                              hidden : false
                                          },{
                                              dataIndex : 'countryCurrencyCodeDesc',
                                              header : countryCurrencyCodeDescLabel,
                                              sortable : true,
                                              hidden : false
                                          },{
                                              dataIndex : 'countryDesc',
                                              header : countryDescLabel,
                                              sortable : true,
                                              hidden : false
                                          },isDefaultGrid,isNewGrid,isDraftGrid,isUpdateGrid,isDeleteGrid,isActiveGrid,isApprovedGrid,isReviewGrid,isPostGrid,
                                  {
                                  dataIndex : 'executeBy',
                                  header : executeByLabel,
                                  sortable : true,
                                  hidden : false,
                                  renderer : function(value, metaData, record, rowIndex,
                                          colIndex, store) {
                                      return record.data.staffName;
                                  }
                              },
                              {
                                  dataIndex : 'executeTime',
                                  header : executeTimeLabel,
                                  sortable : true,
                                  hidden : false,
                                  renderer : function(value, metaData, record, rowIndex,
                                          colIndex, store) {
                                      return Ext.util.Format.date(value, 'd-m-Y H:i:s');
                                  }
                              }];
    var countryFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
    var countryGrid = new Ext.grid.GridPanel({
        name: 'countryGrid',
        id: 'countryGrid',
        border: false,
        store: countryStore,
        autoHeight: false,
        height: 400,
        columns: countryColumnModel,
        plugins: [countryFilters],
        selModel: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            emptyText: emptyRowLabel
        },
        iconCls: 'application_view_detail',
        listeners: {
            'rowclick': function(object, rowIndex, e) {
                var record = countryStore.getAt(rowIndex);
                formPanel.getForm().reset();
                formPanel.form.load({
                    url: '../controller/countryController.php',
                    method: 'POST',
                    waitTitle: systemLabel,
                    waitMsg: waitMessageLabel,
                    params: {
                        method: 'read',
                        mode: 'update',
                        countryId: record.data.countryId,
                        leafId: leafId,
                        isAdmin: isAdmin
                    },
                    success: function(form, action) {
                        Ext.getCmp('countryDescTemp').setValue(record.data.countryDesc);
                        Ext.getCmp('deleteButton').enable();
                        viewPort.items.get(1).expand();
                    },
                    failure: function(form, action) {
                        Ext.MessageBox.alert(systemErrorLabel, action.result.message);
                    }
                });
                
            	Ext.getCmp('newButton').disable();
				Ext.getCmp('saveButton').enable();
				Ext.getCmp('deleteButton').enable();
            }
        },
        tbar: {
            items: [{
                text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function(button,e) {
                        countryStore.each(function(record,fn,scope) {
                            for (var access in countryFlagArray) {
                                record.set(countryFlagArray[access], true);
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
                        countryStore.each(function(record,fn,scope) {
                            for (var access in countryFlagArray) {
                                record.set(countryFlagArray[access], false);
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
                        var url = '../controller/countryController.php?';
                        var sub_url = '';
                        var modified = countryStore.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            sub_url = sub_url + '&countryId[]=' + modified[i].get('countryId');
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
                                isAdmin:isAdmin,
                                method: 'updateStatus'
                            },
                            success: function(response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse.success == true) {
                                    Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                    countryStore.reload();
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
            store: countryStore,
            pageSize: perPage,
            plugins:[countryFilters]
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
                countryStore.reload();
            }
        },
        '-', {
            text: addToolbarLabel,
            iconCls: 'add',
            id: 'pageCreate',
            
            handler: function() {
                viewPort.items.get(1).expand();
            }
        },
        '-', {
            text: excelToolbarLabel,
            iconCls: 'page_excel',
            id: 'page_excel',
            
            handler: function() {
                Ext.Ajax.request({
                    url: '../controller/countryController.php',
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
            store: countryStore,
            width: 320
        })],
        items: [countryGrid]
    });
     // form entry
    var countryId  =  new Ext.form.Hidden({
        name : 'countryId',
        id : 'countryId'
        });var countrySequence = new Ext.form.NumberField({
                    labelAlign : 'left',
                    fieldLabel : countrySequenceLabel + '<span style="\'color:" red;\'="">*</span>',
                    hiddenName : 'countrySequence',
                    name : 'countrySequence',
                    id : 'countrySequence',
                    allowBlank : false,
                    blankText : blankTextLabel,
                    style : {
                        textTransform : 'uppercase'
                    },
                    anchor : '40%'
                });var countryCode = new Ext.form.TextField({
                    labelAlign : 'left',
                    fieldLabel : countryCodeLabel + '<span style="\'color:" red;\'="">*</span>',
                    hiddenName : 'countryCode',
                    name : 'countryCode',
                    id : 'countryCode',
                    allowBlank : false,
                    blankText : blankTextLabel,
                    style : {
                        textTransform : 'uppercase'
                    },
                    anchor : '40%'
                });var countryCurrencyCode = new Ext.form.TextField({
                    labelAlign : 'left',
                    fieldLabel : countryCurrencyCodeLabel + '<span style="\'color:" red;\'="">*</span>',
                    hiddenName : 'countryCurrencyCode',
                    name : 'countryCurrencyCode',
                    id : 'countryCurrencyCode',
                    allowBlank : false,
                    blankText : blankTextLabel,
                    style : {
                        textTransform : 'uppercase'
                    },
                    anchor : '40%'
                });var countryCurrencyCodeDesc = new Ext.form.TextField({
                    labelAlign : 'left',
                    fieldLabel : countryCurrencyCodeDescLabel + '<span style="\'color:" red;\'="">*</span>',
                    hiddenName : 'countryCurrencyCodeDesc',
                    name : 'countryCurrencyCodeDesc',
                    id : 'countryCurrencyCodeDesc',
                    allowBlank : false,
                    blankText : blankTextLabel,
                    style : {
                        textTransform : 'uppercase'
                    },
                    anchor : '40%'
                });var countryDesc = new Ext.form.TextField({
                    labelAlign : 'left',
                    fieldLabel : countryDescLabel + '<span style="\'color:" red;\'="">*</span>',
                    hiddenName : 'countryDesc',
                    name : 'countryDesc',
                    id : 'countryDesc',
                    allowBlank : false,
                    blankText : blankTextLabel,
                    style : {
                        textTransform : 'uppercase'
                    },
                    anchor : '40%'
                });
  
     // end form entry
    // start System Validation
    var isDefault = new Ext.form.Checkbox({
        name: 'isDefault',
        id: 'isDefault',
        fieldLabel: isDefaultLabel,
        hidden: isDefaultHidden
    });
    var isNew = new Ext.form.Checkbox({
        name: 'isNew',
        id: 'isNew',	
        fieldLabel: isNewLabel,
        hidden: isNewHidden
    });
    var isDraft = new Ext.form.Checkbox({
        name: 'isDraft',
        id: 'isDraft',
        fieldLabel: isDraftLabel,
        hidden: isDraftHidden
    });
    var isUpdate = new Ext.form.Checkbox({
        name: 'isUpdate',
        id: 'isUpdate',
        fieldLabel: isUpdateLabel,
        hidden: isUpdateHidden
    });
    var isDelete = new Ext.form.Checkbox({
        name: 'isDelete',
        id: 'isDelete',
        fieldLabel: isDeleteLabel,
        hidden: isDeleteHidden
    });
    var isActive = new Ext.form.Checkbox({
        name: 'isActive',
        id: 'isActive',
        fieldLabel: isActiveLabel,
        hidden: isActiveHidden
    });
    var isApproved = new Ext.form.Checkbox({
        name: 'isApproved',
        id: 'isApproved',
        fieldLabel: isApprovedLabel,
        hidden: isApprovedHidden
    });
    var isReview = new Ext.form.Checkbox({
        name: 'isReview',
        id: 'isReview',
        fieldLabel: isReviewLabel,
        hidden: isReviewHidden
    });
    var isPost = new Ext.form.Checkbox({
        name: 'isPost',
        id: 'isPost',
        fieldLabel: isPostLabel,
        hidden: isPostHidden
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
    // end System Validation
    var formPanel = new Ext.form.FormPanel({
        url: '../controller/countryController.php',
        name: 'formPanel',
        id: 'formPanel',
        method: 'post',
        frame: true,
        title: leafNative,
        border: false,
        bodyStyle: 'padding:5px',
        width: 600,
        items: [{
            xtype: 'fieldset',
            title: 'Form Entry',
            items: [countryId,countrySequence,countryCode,countryCurrencyCode,countryCurrencyCodeDesc,countryDesc,countryId,countrySequence,countryCode,countryCurrencyCode,countryCurrencyCodeDesc,countryDesc]
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
            handler: function() {
                if (auditWindow) {
                    countryStore.reload();
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
                var id = Ext.getCmp('countryId').getValue();
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
                            Ext.getCmp('newButton').disable();
                            Ext.getCmp('saveButton').enable();
                            Ext.getCmp('deleteButton').enable();
                            countryStore.reload({
                                params: {
                                    leafId: leafId,	
                                    start: 0,
                                    limit: perPage
                                }
                            });
                            Ext.getCmp('countryId').setValue(action.result.countryId);
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
                Ext.getCmp('newButton').disable();
                var id = Ext.getCmp('countryId').getValue();
                var method = 'save';
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
                            Ext.getCmp('newButton').disable();
                            Ext.getCmp('saveButton').enable();
                            Ext.getCmp('deleteButton').enable();
                            countryStore.reload({
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
            text: deleteButtonLabel,
            type: 'button',
            name: 'deleteButton',
            id: 'deleteButton',
            iconCls: 'trash',
            disabled: true,
            handler: function() {
                Ext.getCmp('newButton').disable();
                Ext.Msg.show({
                    title: deleteRecordTitleMessageLabel,
                    msg: deleteRecordMessageLabel,
                    icon: Ext.Msg.QUESTION,
                    buttons: Ext.Msg.YESNO,
                    scope: this,
                    fn: function(response) {
                        if ('yes' == response) {
                            Ext.Ajax.request({
                                url: '../controller/countryController.php',
                                params: {
                                    method: 'delete',
                                    countryId: Ext.getCmp('countryId').getValue(),
                                    leafId: leafId,
                                    isAdmin: isAdmin
                                },
                                success: function(response, options) {
                                    jsonResponse = Ext.decode(response.responseText);
                                    if (jsonResponse.success == true) {
                                        Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                        countryStore.reload({
                                            params: {
                                                leafId: leafId,
                                                start: 0,
                                                limit: perPage
                                            }
                                        });
                                        Ext.getCmp('saveButton').disable();
                                        Ext.getCmp('nextButton').disable();
                                        Ext.getCmp('previousButton').disable();
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
                Ext.getCmp('newButton').disable();
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
                        url: '../controller/countryController.php',
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
                                    url: '../controller/countryController.php',
                                    method: 'POST',
                                    waitTitle: systemLabel,
                                    waitMsg: waitMessageLabel,
                                    params: {
                                        method: 'read',
                                        countryId: Ext.getCmp('firstRecord').getValue(),
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
                        url: '../controller/countryController.php',
                        method: 'POST',
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: 'read',
                            countryId: Ext.getCmp('firstRecord').getValue(),
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
                        url: '../controller/countryController.php',
                        method: 'POST',
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: 'read',
                            countryId: Ext.getCmp('previousRecord').getValue(),
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
                                if (Ext.getCmp('previousRecord').getValue() == 0) {
                                    Ext.getCmp('previousButton').disable();
                                }
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
                        url: '../controller/countryController.php',
                        method: 'POST',
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: 'read',
                            countryId: Ext.getCmp('nextRecord').getValue(),
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
                        url: '../controller/countryController.php',
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
                                    url: '../controller/countryController.php',
                                    method: 'POST',
                                    waitTitle: systemLabel,
                                    waitMsg: waitMessageLabel,
                                    params: {
                                        method: 'read',
                                        countryId: Ext.getCmp('lastRecord').getValue(),
                                        leafId: leafId,
                                        isAdmin: isAdmin
                                    },
                                    success: function(form, action) {
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
                if (Ext.getCmp('countryId').getValue() <= Ext.getCmp('lastRecord').getValue()) {
                    formPanel.form.load({
                        url: '../controller/countryController.php',
                        method: 'POST',
                        waitTitle: systemLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: 'read',
                            countryId: Ext.getCmp('lastRecord').getValue(),
                            leafId: leafId,
                            isAdmin: isAdmin
                        },
                        success: function(form, action) {
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