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
    var groupProxy = new Ext.data.HttpProxy({
        url: "../controller/groupController.php",
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { 
            	//Ext.MessageBox.alert(systemLabel,jsonResponse.message);
                
            } else {
            	 Ext.MessageBox.alert(systemErrorLabel,jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var groupReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "groupId"
    });
    var groupStore = new Ext.data.JsonStore({
        proxy: groupProxy,
        reader: groupReader,
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
            name: "groupId",
            type: "int"
        },
        {
            name: "groupSequence",
            type: "string"
        },
        {
            name: "groupCode",
            type: "string"
        },
        {
            name: "groupNote",
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
        url: "../controller/groupController.php?",
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
            dataIndex: "groupSequence",
            column: "groupSequence",
            table: "group"
        },{
            type: "string",
            dataIndex: "groupCode",
            column: "groupCode",
            table: "group"
        },{
            type: "string",
            dataIndex: "groupNote",
            column: "groupNote",
            table: "group"
        },
        {
            type: "list",
            dataIndex: "By",
            column: "By",
            table: "group",
            labelField: "staffName",
            store: staffByStore,
            phpMode: true
        },
        {
            type: "date",
            dataIndex: "Time",
            column: "Time",
            table: "group"
        }]
    });
	
    
    var groupSequence = new Ext.form.TextField({
        labelAlign: "left",
        fieldLabel: groupSequenceLabel + '<span style="color: red;">*</span>',
        hiddenName: "groupSequence",
        name: "groupSequence",
        id: "groupSequence",
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: "uppercase"
        },
        anchor: "95%"
    });
    
	 var groupCode = new Ext.form.TextField({
        labelAlign: "left",
        fieldLabel: groupCodeLabel + '<span style="color: red;">*</span>',
        hiddenName: "groupCode",
        name: "groupCode",
        id: "groupCode",
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: "uppercase"
        },
        anchor: "95%"
    });
	 
	 var groupNote = new Ext.form.TextField({
	        labelAlign: "left",
	        fieldLabel: groupNoteLabel + '<span style="color: red;">*</span>',
	        hiddenName: "groupNote",
	        name: "groupNote",
	        id: "groupNote",
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
    var groupColumnModelGrid = [new Ext.grid.RowNumberer(),
         {
        dataIndex: "groupSequence",
        header: groupSequenceLabel,
        sortable: true,
        hidden: false,
		editor : groupSequence
					
    },
                                     {
        dataIndex: "groupCode",
        header: groupCodeLabel,
        sortable: true,
        hidden: false,
		editor : groupCode
					
    },{
        dataIndex: "groupNote",
        header: groupNoteLabel,
        sortable: true,
        hidden: false,
		editor : groupNote
					
    },
    isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid, isDeleteGrid, isActiveGrid, isApprovedGrid{
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
    var accessArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved'];
    var groupEditor = new Ext.ux.grid.RowEditor({
        saveText: 'Save',
        listeners: {
            CancelEdit: function(rowEditor, changes, record, rowIndex) {
                groupStore.reload();
            },
            afteredit: function(rowEditor, changes, record, rowIndex) {
                var method;
				this.save = true; // update record manually
                var record = this.grid.getStore().getAt(rowIndex);
				if(record.get('groupId')  > 0 ) {
					method ='save';
				} else {
					method='create';
				}
			
                Ext.Ajax.request({
                    url: '../controller/groupController.php',
                    method: 'POST',
                    params: {
                        method: method,
                        leafId: leafId,
                        groupSequence : record.get('groupSequence'),
                        groupCode : record.get('groupCode'),
                        groupNote: record.get('groupNote'),
						groupId:record.get('groupId'),
						duplicateTest : true
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
                groupStore.reload();
            }
        }
    });
    var groupEntity = Ext.data.Record.create([{
        name: "groupId",
        type: "int"
    },
    {
        name: "groupSequence",
        type: "string"
    },
    {
        name: "groupCode",
        type: "string"
    },
    {
        name: "groupNote",
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
    var groupGrid = new Ext.grid.GridPanel({
        border: false,
        store: groupStore,
        autoHeight: false,
        height: 400,
        columns: groupColumnModelGrid,
        plugins: [filters, groupEditor],
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
                    var e = new groupEntity({
                        groupId: '',
                        groupSequence : '',
                        groupCode :'',
                        groupNote: '',
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
                    groupEditor.stopEditing();
                    groupStore.insert(0, e);
                    var s = groupGrid.getSelectionModel().getSelections();
                    groupEditor.startEditing(0);
                }
            },
            {
                text: 'Check All',
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function() {
                        var count = groupStore.getCount();
                        groupStore.each(function(rec) {
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
                        groupStore.each(function(rec) {
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
                        var count = groupStore.getCount();
                        url = '../controller/groupController.php?';
                        var sub_url;
                        sub_url = '';
                   
                        var modified = groupStore.getModifiedRecords();
                        for(var i = 0; i < modified.length; i++) {
                            var record = groupStore.getAt(i);
                            
                            if(record.get('groupId')){
                            	sub_url = sub_url + '&groupId[]=' + record.get('groupId');
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
                                    groupStore.removeAll(); // force to remove all data
                                    groupStore.reload();
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
            store: groupStore,
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
                groupStore.reload();
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
                    url: "../controller/groupController.php?method=report&mode=excel&limit=" + perPage + "&leafId=" + leafId,
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
                groupStore.reload();
            }
        },
        
        '-', {
            text: excelToolbarLabel,
            iconCls: "page_excel",
            id: "page_excel",
            disabled: pagePrint,
            handler: function() {
                Ext.Ajax.request({
                    url: "../controller/groupController.php",
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
                            window.open("../../management/document/excel/" + jsonResponse.filename);
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
            store: groupStore,
            width: 320
        })],
        items: [groupGrid]
    });
    var groupDescTemp = new Ext.form.Hidden({
        name: "groupCodeTemp",
        id: "groupCodeTemp"
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