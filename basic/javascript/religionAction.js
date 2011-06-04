Ext.onReady(function() {
    Ext.QuickTips.init();
    Ext.BLANK_IMAGE_URL = "../../javascript/resources/images/s.gif";
    Ext.form.Field.prototype.msgTarget = "under";
    Ext.Ajax.timeout = 90000;
    var pageCreate;
    var pageCreateList;
    var pageReload;
    var pageReloadList;
    var pagePrint;
    var pagePrintList;
    var perPage = 15;
    var encode = false;
    var local = false;
    var jsonResponse;
    var duplicate = 0;
    if (leafReadAccessValue == 1) {
        pageCreate = false;
        pageCreateList = false;
    } else {
        pageCreate = true;
        pageCreateList = true;
    }
    if (leafReadAccessValue == 1) {
        pageReload = false;
        pageReloadList = false;
    } else {
        pageReload = true;
        pageReloadList = true;
    }
    if (leafPrintAccessValue == 1) {
        pagePrint = false;
        pagePrintList = false;
    } else {
        pagePrint = true;
        pagePrintList = true;
    }
    var religionProxy = new Ext.data.HttpProxy({
        url: "../controller/religionController.php",
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { //Ext.MessageBox.alert(systemLabel, jsonResponse.message); //uncomment it for debugging purpose
            } else {
          //      Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            	Ext.MessageBox.show({
				   title:systemErrorLabel,
				   msg: jsonResponse.message,
				   buttons: Ext.Msg.WARNING,
				
				   warning: 'emoticon_unhappy'
				});
			}
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var religionReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "religionId"
    });
    var religionStore = new Ext.data.JsonStore({
        proxy: religionProxy,
        reader: religionReader,
        autoLoad: true,
        autoDestroy: true,
        baseParams: {
            method: "read",
            grid: "master",
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            perPage: perPage
        },
        root: "data",
        fields: [{
            name: "religionId",
            type: "int"
        },
        {
            name: "religionDesc",
            type: "string"
        },
        {
            name: "By",
            type: "int"
        },
        {
            name: "staffName",
            type: "string"
        },
        {
            name: "isDefault",
            type: "boolean"
        },
        {
            name: "isNew",
            type: "boolean"
        },
        {
            name: "isDraft",
            type: "boolean"
        },
        {
            name: "isUpdate",
            type: "boolean"
        },
        {
            name: "isDelete",
            type: "boolean"
        },
        {
            name: "isActive",
            type: "boolean"
        },
        {
            name: "isApproved",
            type: "boolean"
        },
        {
            name: "Time",
            type: "date",
            dateFormat: "Y-m-d H:i:s"
        }]
    });
    var religionListProxy = new Ext.data.HttpProxy({
        url: "../controller/religionController.php",
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { //Ext.MessageBox.alert(successLabel, jsonResponse.message); //uncomment for testing
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var religionListReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "religionId"
    });
    var religionStoreList = new Ext.data.JsonStore({
        proxy: religionListProxy,
        reader: religionListProxy,
        autoLoad: true,
        autoDestroy: true,
        baseParams: {
            method: "read",
            grid: "master",
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            limit: perPage
        },
        root: "data",
        fields: [{
            name: "religionId",
            type: "int"
        },
        {
            name: "religionDesc",
            type: "string"
        },
        {
            name: "By",
            type: "int"
        },
        {
            name: "staffName",
            type: "string"
        },
        {
            name: "isDefault",
            type: "boolean"
        },
        {
            name: "isNew",
            type: "boolean"
        },
        {
            name: "isDraft",
            type: "boolean"
        },
        {
            name: "isUpdate",
            type: "boolean"
        },
        {
            name: "isDelete",
            type: "boolean"
        },
        {
            name: "isActive",
            type: "boolean"
        },
        {
            name: "isApproved",
            type: "boolean"
        },
        {
            name: "Time",
            type: "date",
            dateFormat: "Y-m-d H:i:s"
        }]
    });
    var staffByProxy = new Ext.data.HttpProxy({
        url: "../controller/religionController.php?",
        method: "GET",
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { //Ext.MessageBox.alert(successLabel, jsonResponse.message); //uncommen for testing purpose
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
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
        },
        {
            name: "staffName",
            type: "string"
        }]
    });
    var filters = new Ext.ux.grid.GridFilters({
        encode: encode,
        local: false,
        filters: [{
            type: "string",
            dataIndex: "religionDesc",
            column: "religionDesc",
            table: "religion"
        },
        {
            type: "list",
            dataIndex: "By",
            column: "By",
            table: "religion",
            labelField: "staffName",
            store: staffByStore,
            phpMode: true
        },
        {
            type: "date",
            dataIndex: "Time",
            column: "Time",
            table: "religion"
        }]
    });
    var filtersList = new Ext.ux.grid.GridFilters({
        encode: encode,
        local: false,
        filters: [{
            type: "string",
            dataIndex: "religionDesc",
            column: "religionDesc",
            table: "religion"
        },
        {
            type: "list",
            dataIndex: "By",
            column: "By",
            table: "religion",
            labelField: "staffName",
            store: staffByStore,
            phpMode: true
        },
        {
            type: "date",
            dataIndex: "Time",
            column: "Time",
            table: "religion"
        }]
    });
    var columnModel = [new Ext.grid.RowNumberer(), {
        id: 'action',
        header: 'Task',
        xtype: 'actioncolumn',
        width: 50,
        items: [{
            icon: '../../javascript/resources/images/icon/application_edit.png',
            tooltip: updateRecordToolTipLabel,
            handler: function(grid, rowIndex, colIndex) {
                var record = religionStore.getAt(rowIndex);
                formPanel.getForm().reset();
                formPanel.form.load({
                    url: "../controller/religionController.php",
                    method: "POST",
                    waitTitle: systemLabel,
                    waitMsg: waitMessageLabel,
                    params: {
                        method: "read",
                        mode: "update",
                        religionId: record.data.religionId,
                        leafId: leafId
                    },
                    success: function(form, action) {
                        Ext.getCmp("religionDesc_temp").setValue(record.data.religionDesc);
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
                var record = religionStore.getAt(rowIndex);
                Ext.Msg.show({
                    title: deleteRecordTitleMessageLabel,
                    msg: deleteRecordMessageLabel,
                    icon: Ext.Msg.QUESTION,
                    buttons: Ext.Msg.YESNO,
                    scope: this,
                    fn: function(response) {
                        if ("yes" == response) {
                            Ext.Ajax.request({
                                url: "../controller/religionController.php",
                                params: {
                                    method: "delete",
                                    religionId: record.data.religionId,
                                    leafId: leafId
                                },
                                success: function(response, options) {
                                    jsonResponse = Ext.decode(response.responseText);
                                    if (jsonResponse.success == true) {
                                        title = successLabel;
                                    } else {
                                        title = failureLabel;
                                    }
                                    religionStore.reload({
                                        params: {
                                            leafId: leafId,
                                            start: 0,
                                            limit: perPage
                                        }
                                    });
                                    religionStoreList.reload({
                                        params: {
                                            leafId: leafId,
                                            start: 0,
                                            limit: perPage
                                        }
                                    });
                                    Ext.MessageBox.alert(title, jsonResponse.message);
                                },
                                failure: function(response, options) {
                                    Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + response.statusText);
                                }
                            });
                        }
                    }
                });
            }
        }]
    },
    {
        dataIndex: "religionDesc",
        header: religionDescLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: "isDefault",
        header: isDefaultLabel,
        sortable: true,
        hidden: isDefaultHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isNew",
        header: isNewLabel,
        sortable: true,
        hidden: isNewHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isUpdate",
        header: isUpdateLabel,
        sortable: true,
        hidden: isUpdateHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isDelete",
        header: isDeleteLabel,
        sortable: true,
        hidden: isDeleteHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isActive",
        header: isActiveLabel,
        sortable: true,
        hidden: isActiveHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isApproved",
        header: isApprovedLabel,
        sortable: true,
        hidden: isApprovedHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "By",
        header: createByLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return record.data.staffName;
        }
    },
    {
        dataIndex: "Time",
        header: timeLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return Ext.util.Format.date(value, 'd-m-Y H:i:s');
        }
    }];
    var columnModelList = [new Ext.grid.RowNumberer(), {
        id: 'action',
        header: 'Task',
        xtype: 'actioncolumn',
        width: 50,
        items: [{
            icon: '../../javascript/resources/images/icon/application_edit.png',
            tooltip: updateRecordToolTipLabel,
            handler: function(grid, rowIndex, colIndex) {
                var record = religionStore.getAt(rowIndex);
                formPanel.getForm().reset();
                formPanel.form.load({
                    url: "../controller/religionController.php",
                    method: "POST",
                    waitTitle: systemLabel,
                    waitMsg: waitMessageLabel,
                    params: {
                        method: "read",
                        mode: "update",
                        religionId: record.data.religionId,
                        leafId: leafId
                    },
                    success: function(form, action) {
                        Ext.getCmp("religionDesc_temp").setValue(record.data.religionDesc);
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
                var record = religionStore.getAt(rowIndex);
                Ext.Msg.show({
                    title: deleteRecordTitleMessageLabel,
                    msg: deleteRecordMessageLabel,
                    icon: Ext.Msg.QUESTION,
                    buttons: Ext.Msg.YESNO,
                    scope: this,
                    fn: function(response) {
                        if ("yes" == response) {
                            Ext.Ajax.request({
                                url: "../controller/religionController.php",
                                params: {
                                    method: "delete",
                                    religionId: record.data.religionId,
                                    leafId: leafId
                                },
                                success: function(response, options) {
                                    jsonResponse = Ext.decode(response.responseText);
                                    if (jsonResponse.success == true) {
                                        title = successLabel;
                                    } else {
                                        title = failureLabel;
                                    }
                                    religionStore.reload({
                                        params: {
                                            leafId: leafId,
                                            start: 0,
                                            limit: perPage
                                        }
                                    });
                                    religionStoreList.reload({
                                        params: {
                                            leafId: leafId,
                                            start: 0,
                                            limit: perPage
                                        }
                                    });
                                    Ext.MessageBox.alert(title, jsonResponse.message);
                                },
                                failure: function(response, options) {
                                    Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + response.statusText);
                                }
                            });
                        }
                    }
                });
            }
        }]
    },
    {
        dataIndex: "religionDesc",
        header: religionDescLabel,
        sortable: true,
        hidden: false
    },
    {
        dataIndex: "isDefault",
        header: isDefaultLabel,
        sortable: true,
        hidden: isDefaultHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isNew",
        header: isNewLabel,
        sortable: true,
        hidden: isNewHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isUpdate",
        header: isUpdateLabel,
        sortable: true,
        hidden: isUpdateHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isDelete",
        header: isDeleteLabel,
        sortable: true,
        hidden: isDeleteHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isActive",
        header: isActiveLabel,
        sortable: true,
        hidden: isActiveHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "isApproved",
        header: isApprovedLabel,
        sortable: true,
        hidden: isApprovedHidden,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            if (value == true) {
                return '<img src=\'../../javascript/resources/images/icon/accept.png\' width=\'12\' height=\'12\'> ';
            } else if (value == false) {
                return '<img src=\'../../javascript/resources/images/icon/cancel.png\' width=\'12\' height=\'12\'> ';
            }
        }
    },
    {
        dataIndex: "By",
        header: createByLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return record.data.staffName;
        }
    },
    {
        dataIndex: "Time",
        header: timeLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return Ext.util.Format.date(value, 'Y-m-d H:i:s');
        }
    }];
    var religionGrid = new Ext.grid.GridPanel({
        border: false,
        store: religionStore,
        autoHeight: false,
        height: 400,
        columns: columnModel,
        plugins: [filters],
        sm: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            emptyText: emptyTextLabel
        },
        iconCls: "application_view_detail",
        bbar: new Ext.PagingToolbar({
            store: religionStore,
            pageSize: perPage
        })
    });
    var religionGridList = new Ext.grid.GridPanel({
        border: false,
        store: religionStoreList,
        autoHeight: false,
        height: 400,
        columns: columnModelList,
        loadMask: true,
        plugins: [filtersList],
        sm: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            emptyText: emptyTextLabel
        },
        iconCls: "application_view_detail",
        bbar: new Ext.PagingToolbar({
            store: religionStoreList,
            pageSize: perPage
        })
    });
    var toolbarPanel = new Ext.Toolbar({
        items: [{
            text: reloadToolbarLabel,
            iconCls: "database_refresh",
            id: "pageReload",
            disabled: pageReload,
            handler: function() {
                religionStore.reload();
            }
        },
        {
            text: addToolbarLabel,
            iconCls: "add",
            id: "pageCreate",
            disabled: pageCreate,
            handler: function() {
                viewPort.items.get(1).expand();
            }
        },
        {
            text: excelToolbarLabel,
            iconCls: "page_excel",
            id: "page_excel",
            disabled: pagePrint,
            handler: function() {
                Ext.Ajax.request({
                    url: "../controller/religionController.php?method=report&mode=excel&limit=" + perPage + "&leafId=" + leafId,
                    method: "GET",
                    success: function(response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == true) {
                            window.open("../../setting/document/excel/" + jsonResponse.filename);
                        } else {
                            Ext.MessageBox.alert(successLabel, jsonResponse.message);
                        }
                    },
                    failure: function(response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + escape(response.statusText));
                    }
                });
            }
        }]
    });
    var toolbarPanelList = new Ext.Toolbar({
        items: [{
            text: reloadToolbarLabel,
            iconCls: "database_refresh",
            id: "pageReloadList",
            disabled: pageReloadList,
            handler: function() {
                religionStoreList.reload();
            }
        },
        {
            text: addToolbarLabel,
            iconCls: "add",
            id: "pageCreateList",
            disabled: pageCreateList,
            handler: function() {
                viewPort.items.get(1).expand();
                win.hide();
            }
        },
        {
            text: excelToolbarLabel,
            iconCls: "page_excel",
            id: "page_excelList",
            disabled: pagePrintList,
            handler: function() {
                Ext.Ajax.request({
                    url: "../controller/religionController.php",
                    method: "GET",
                    params: {
                        method: 'report',
                        mode: 'excel',
                        limit: perPage,
                        leafId: leafId
                    },
                    success: function(response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == true) {
                            window.open("../../basic/document/excel/" + jsonResponse.filename);
                        } else {
                            Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                        }
                    },
                    failure: function(response, options) {
                        Ext.MessageBox.alert('system', escape(response.status) + ":" + escape(response.statusText));
                    }
                });
            }
        }]
    });
    var gridPanel = new Ext.Panel({
        title: leafNote,
        height: 50,
        layout: "fit",
        iconCls: "application_view_detail",
        tbar: [{
            text: reloadToolbarLabel,
            iconCls: "database_refresh",
            id: "pageReload",
            disabled: pageReload,
            handler: function() {
                religionStore.reload();
            }
        },
        {
            text: addToolbarLabel,
            iconCls: "add",
            id: "pageCreate",
            disabled: pageCreate,
            handler: function() {
                viewPort.items.get(1).expand();
            }
        },
        {
            text: excelToolbarLabel,
            iconCls: "page_excel",
            id: "page_excel",
            disabled: pagePrint,
            handler: function() {
                Ext.Ajax.request({
                    url: "../controller/religionController.php",
                    method: "GET",
                    params: {
                        method: 'report',
                        mode: 'excel',
                        limit: perPage,
                        leafId: leafId
                    },
                    success: function(response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == true) {
                            window.open("../../basic/document/excel/" + jsonResponse.filename);
                        } else {
                            Ext.MessageBox.alert(successLabel, jsonResponse.message);
                        }
                    },
                    failure: function(response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + escape(response.statusText));
                    }
                });
            }
        },
        new Ext.ux.form.SearchField({
            store: religionStore,
            width: 320
        })],
        items: [religionGrid]
    });
    var religionDesc_temp = new Ext.form.Hidden({
        name: "religionDesc_temp",
        id: "religionDesc_temp"
    });
    var religionDesc = new Ext.form.TextField({
        labelAlign: "left",
        fieldLabel: religionDescLabel + '<span style="color: red;">*</span>',
        hiddenName: "religionDesc",
        name: "religionDesc",
        id: "religionDesc",
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: "uppercase"
        },
        anchor: "95%",
        listeners: {
            blur: function() {
                if (Ext.getCmp("religionDesc").getValue().length > 0) {
                    Ext.Ajax.request({
                        url: "../controller/religionController.php",
                        method: "GET",
                        params: {
                            method: "duplicate",
                            leafId: leafId,
                            religionDesc: Ext.getCmp("religionDesc").getValue()
                        },
                        success: function(response, options) {
                            jsonResponse = Ext.decode(response.responseText);
                            if (jsonResponse.success == true) {
                                if (jsonResponse.total > 0) {
                                    if (Ext.getCmp("religionDesc_temp").getValue() != Ext.getCmp("religionDesc").getValue()) {
                                        duplicate = 1;
                                        duplicateMessageLabel = duplicateMessageLabel + Ext.util.Format.uppercase(Ext.getCmp("religionDesc").getValue()) + ":" + +Ext.util.Format.uppercase(jsonResponse.religionDesc);
                                        Ext.MessageBox.alert(systemErrorLabel, duplicateMessageLabel);
                                        Ext.getCmp("religionDesc").setValue("");
                                    }
                                }
                            } else {
                                Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                            }
                        },
                        failure: function(response, options) {
                            Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + escape(response.statusText));
                        }
                    });
                }
            }
        }
    });
    var religionId = new Ext.form.Hidden({
        name: "religionId",
        id: "religionId"
    });
    var formPanel = new Ext.form.FormPanel({
        url: "../controller/religionController.php",
        id: "formPanel",
        method: "post",
        frame: true,
        title: leafNote,
        border: false,
        bodyStyle: "padding:5px",
        width: 600,
        items: [religionId, religionDesc, religionDesc_temp],
        buttonVAlign: "top",
        buttonAlign: "left",
        iconCls: "application_form",
        bbar: new Ext.ux.StatusBar({
            id: "form-statusbar",
            defaultText: defaultTextLabel,
            plugins: new Ext.ux.ValidationStatus({
                form: "formPanel"
            })
        }),
        buttons: [{
            text: saveButtonLabel,
            iconCls: "bullet_disk",
            handler: function() {
                if (formPanel.getForm().isValid()) {
                    var id = 0;
                    id = Ext.getCmp('religionId').getValue();
                    var method;
                    if (id.length > 0) {
                        method = 'save';
                    } else {
                        method = 'create';
                    }
                    formPanel.getForm().submit({
                        waitTitle: waitTitleLabel,
                        waitMsg: waitMessageLabel,
                        params: {
                            method: method,
                            leafId: leafId
                        },
                        success: function(form, action) {
                            Ext.MessageBox.alert(successLabel, action.result.message);
                            Ext.getCmp('religionId').setValue(action.result.religionId);
                            formPanel.getForm().reset(); // comment it  if wanted to continue mode
                            religionStore.reload();
                            religionStoreList.reload();
                        },
                        failure: function(form, action) {
                            if (duplicate == 1) {
                                Ext.MessageBox.alert(systemErrorLabel, duplicateMessageLabel);
                            }
                            if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
                                alert(loadFailureMessageLabel);
                            } else {
                                if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
                                    alert(clientInvalidMessageLabel);
                                } else {
                                    if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
                                        Ext.Msg.alert(connectFailureLabel, "Server reported:" + form.response.status + " " + form.response.statusText);
                                    } else {
                                        if (action.failureType === Ext.form.Action.SERVER_INVALID) {
                                            Ext.Msg.alert(serverInvalidLabel, action.result.message);
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }
        },
        {
            text: newButtonLabel,
            type: "button",
            iconCls: "add",
            handler: function() {
                formPanel.getForm().reset();
            }
        },
        {
            text: resetButtonLabel,
            type: "reset",
            iconCls: "table_refresh",
            handler: function() {
                formPanel.getForm().reset();
            }
        },
        {
            text: listButtonLabel,
            type: "button",
            iconCls: "table",
            handler: function() {
                if (win) {
                    win.show().center();
                }
            }
        },
        {
            text: cancelButtonLabel,
            type: "button",
            iconCls: "delete",
            handler: function() {
                if (win) {
                    win.hide();
                }
                formPanel.getForm().reset();
                religionStore.reload();
                viewPort.items.get(0).expand();
            }
        }]
    });
    var win = new Ext.Window({
        tbar: toolbarPanelList,
        items: [religionGridList],
        title: leafNote,
        closeAction: "hide",
        maximizable: true,
        layout: "fit",
        width: 500,
        autoScroll: true
    });
    var viewPort = new Ext.Viewport({
        id: "viewport",
        region: "center",
        layout: "accordion",
        layoutConfig: {
            titleCollapse: true,
            animate: false,
            activeOnTop: true
        },
        items: [gridPanel, formPanel]
    });
});