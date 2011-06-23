Ext.onReady(function() {
    Ext.QuickTips.init();
    Ext.BLANK_IMAGE_URL = "../../javascript/resources/images/s.gif";
    Ext.form.Field.prototype.msgTarget = "under";
    Ext.Ajax.timeout = 90000;
    var pageCreate;
  
    var pageReload;
    
    var pagePrint;
    
    var perPage = 15;
    var encode = false;
   
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
            if (jsonResponse.success == true) { 
            	// Ext.MessageBox.alert(systemLabel,
                // jsonResponse.message);
                // //uncomment it for debugging
                // purpose
            } else { 
            	Ext.MessageBox.alert(systemErrorLabel,jsonResponse.message);
               
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
    	pruneModifiedRecords :true,
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
			type : "list",
			dataIndex : "updated_by",
			column : "updated_by",
			table : "religion",
			labelField : "staff_nme",
			store : staff_store,
			phpMode : true
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
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,
                // jsonResponse.message);
                // //uncommen for testing
                // purpose
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
        anchor: "95%"
    });
	 
    var isDefaultGrid = new Ext.ux.grid.CheckColumn({
        header: 'Default',
        dataIndex: 'isDefault',
        hidden: isDefaultHidden
    });
    var isNewGrid = new Ext.ux.grid.CheckColumn({
        header: 'New',
        dataIndex: 'isNew',
        hidden: isNewHidden
    });
    var isDraftGrid = new Ext.ux.grid.CheckColumn({
        header: 'Draft',
        dataIndex: 'isDraft',
        hidden: isDraftHidden
    });
    var isUpdateGrid = new Ext.ux.grid.CheckColumn({
        header: 'Update',
        dataIndex: 'isUpdate',
        hidden: isUpdateHidden
    });
    var isDeleteGrid = new Ext.ux.grid.CheckColumn({
        header: 'Delete',
        dataIndex: 'isDelete'
    });
    var isActiveGrid = new Ext.ux.grid.CheckColumn({
        header: 'Active',
        dataIndex: 'isActive',
        hidden: isActiveHidden
    });
    var isApprovedGrid = new Ext.ux.grid.CheckColumn({
        header: 'Approved',
        dataIndex: 'isApproved',
        hidden: isApprovedHidden
    });
    var religionColumnModelGrid = [new Ext.grid.RowNumberer(), {
        dataIndex: "religionDesc",
        header: religionDescLabel,
        sortable: true,
        hidden: false,
		editor : religionDesc
					
    },
    isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid, isDeleteGrid, isActiveGrid, isApprovedGrid];
    var accessArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved'];
    var religionEditor = new Ext.ux.grid.RowEditor({
        saveText: 'Save',
        listeners: {
            CancelEdit: function(rowEditor, changes, record, rowIndex) {
                religionStore.reload();
            },
            afteredit: function(rowEditor, changes, record, rowIndex) {
                var method;
				this.save = true; // update record manually
                var record = this.grid.getStore().getAt(rowIndex);
				if(record.get('religionId')  > 0 ) {
					method ='save';
				} else {
					method='create';
				}
			
                Ext.Ajax.request({
                    url: '../controller/religionController.php',
                    method: 'POST',
                    params: {
                        method: method,
                        leafId: leafId,
                        religionDesc: record.get('religionDesc'),
						religionId:record.get('religionId'),
						duplicateTest : true,
						test:test
                    },
                    success: function(response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == false) {
                            Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                        }
                    },
                    failure: function(response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + response.statusText);
                    }
                });
                religionStore.reload();
            }
        }
    });
    var religionEntity = Ext.data.Record.create([{
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
    }]);
    var religionGrid = new Ext.grid.GridPanel({
        border: false,
        store: religionStore,
        autoHeight: false,
        height: 400,
        columns: religionColumnModelGrid,
        plugins: [filters, religionEditor],
        sm: new Ext.grid.RowSelectionModel({
            singleSelect: true
        }),
        viewConfig: {
            emptyText: emptyTextLabel
        },
        iconCls: "application_view_detail",
        tbar: {
            items: [{
                iconCls: 'add',
                id: 'add_record',
                name: 'add_record',
                text: 'New Record',
                handler: function() {
                    var e = new religionEntity({
                        religionId: '',
                        religionDesc: '',
                        By: '',
                        staffName: '',
                        isDefault: '',
                        isNew: '',
                        isDraft: '',
                        isUpdate: '',
                        isDelete: '',
                        isActive: '',
                        isApproved: '',
                        Time: ''
                    });
                    religionEditor.stopEditing();
                    religionStore.insert(0, e);
                    var s = religionGrid.getSelectionModel().getSelections();
                    religionEditor.startEditing(0);
                }
            },
            {
                text: 'Check All',
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function() {
                        var count = religionStore.getCount();
                        religionStore.each(function(rec) {
                            for (var access in accessArray) { // alert(access);
                                rec.set(accessArray[access], true);
                            }
                        });
                    }
                }
            },
            {
                text: 'Clear All',
                iconCls: 'row-check-sprite-uncheck',
                listeners: {
                    'click': function() {
                        religionStore.each(function(rec) {
                            for (var access in accessArray) {
                                rec.set(accessArray[access], false);
                            }
                        });
                    }
                }
            },
            {
                text: 'save',
                iconCls: 'bullet_disk',
                listeners: {
                    'click': function(c) {
                        var url;
                        var count = religionStore.getCount();
                        url = '../controller/religionController.php?';
                        var sub_url;
                        sub_url = '';
                   
                        var modified = religionStore.getModifiedRecords();
                        for(var i = 0; i < modified.length; i++) {
                            var record = religionStore.getAt(i);
                            
                            if(record.get('religionId')){
                            	sub_url = sub_url + '&religionId[]=' + record.get('religionId');
                            } else {
                            	alert("testing for error"+i)
                            }
                            if (isAdmin == 1) {
                            	sub_url = sub_url + '&isDefault[]=' + record.get('isDefault');
                                sub_url = sub_url + '&isNew[]=' + record.get('isNew');
                                sub_url = sub_url + '&isDraft[]=' + record.get('isDraft');
                                sub_url = sub_url + '&isUpdate[]=' + record.get('isUpdate');
                            }
                           	
                            sub_url = sub_url + '&isDelete[]=' + record.get('isDelete');
                            if (isAdmin == 1) {
                                sub_url = sub_url + '&isActive[]=' + record.get('isActive');
                                sub_url = sub_url + '&isApproved[]=' + record.get('isApproved');
                            }
                        }
                        url = url + sub_url; // reques and ajax
                    	
        				
                        Ext.Ajax.request({
                            url: url,
                            method: 'GET',
                            params: {
                                leafId: leafId,
                                method: 'updateStatus',
                                isAdmin :isAdmin
                            },
                            success: function(response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse.success == true) {
                                    Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                    religionStore.removeAll(); // force to remove all data
                                    religionStore.reload();
                                } else if (jsonResponse.success == false) {
                                    Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                                }
                            },
                            failure: function(response, options) {
                                Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ":" + escape(response.statusText));
                            }
                        }); // refresh the store
                    }
                }
            }]
        },
        bbar: new Ext.PagingToolbar({
            store: religionStore,
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
        '-', {
            text: addToolbarLabel,
            iconCls: "add",
            id: "pageCreate",
            disabled: pageCreate,
            handler: function() {
                viewPort.items.get(1).expand();
            }
        },
        '-', {
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
    var gridPanel = new Ext.Panel({
        title: leafNote,
        iconCls: "application_view_detail",
        layout: 'fit',
        tbar: [{
            text: reloadToolbarLabel,
            iconCls: "database_refresh",
            id: "pageReload",
            disabled: pageReload,
            handler: function() {
                religionStore.reload();
            }
        },
        
        '-', {
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
        '-', new Ext.ux.form.SearchField({
            store: religionStore,
            width: 320
        })],
        items: [religionGrid]
    });
    var religionDesc_temp = new Ext.form.Hidden({
        name: "religionDesc_temp",
        id: "religionDesc_temp"
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
        items: [gridPanel]
    });
});