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
    if (leafAccessReadValue == 1) {
        pageCreate = false;
        pageCreateList = false;
    } else {
        pageCreate = true;
        pageCreateList = true;
    }
    if (leafAccessReadValue == 1) {
        pageReload = false;
        pageReloadList = false;
    } else {
        pageReload = true;
        pageReloadList = true;
    }
    if (leafAccessPrintValue == 1) {
        pagePrint = false;
        pagePrintList = false;
    } else {
        pagePrint = true;
        pagePrintList = true;
    }
    var languageProxy = new Ext.data.HttpProxy({
        url: "../controller/languageController.php",
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
    var languageReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "languageId"
    });
    var languageStore = new Ext.data.JsonStore({
        proxy: languageProxy,
        reader: languageReader,
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
            name: "languageId",
            type: "int"
        },
      
        {
            name: "languageCode",
            type: "string"
        },
        {
            name: "languageDesc",
            type: "string"
        },
        {
            name: "executeBy",
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
            name: "isReview",
            type: "boolean"
        },
        {
            name: "isPost",
            type: "boolean"
        },
        {
            name: "executeTime",
            type: "date",
            dateFormat: "Y-m-d H:i:s"
        }]
    });
    var staffByProxy = new Ext.data.HttpProxy({
        url: "../controller/languageController.php?",
        method: "GET",
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { 
            	// Ext.MessageBox.alert(successLabel,jsonResponse.message);
                // uncomment for testing purpose
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
            dataIndex: "languageCode",
            column: "languageCode",
            table: "language"
        },{
            type: "string",
            dataIndex: "languageDesc",
            column: "languageDesc",
            table: "language"
        },
        {
            type: "list",
            dataIndex: "executeBy",
            column: "executeBy",
            table: "language",
            labelField: "staffName",
            store: staffByStore,
            phpMode: true
        },
        {
            type: "date",
            dataIndex: "executeTime",
            column: "excuteTime",
            table: "language"
        }]
    });
	
    
  
    
	 var languageCode = new Ext.form.TextField({
        labelAlign: "left",
        fieldLabel: languageCodeLabel + '<span style="color: red;">*</span>',
        hiddenName: "languageCode",
        name: "languageCode",
        id: "languageCode",
        allowBlank: false,
        blankText: blankTextLabel,
        style: {
            textTransform: "uppercase"
        },
        anchor: "95%"
    });
	 
	 var languageDesc = new Ext.form.TextField({
	        labelAlign: "left",
	        fieldLabel: languageDescLabel + '<span style="color: red;">*</span>',
	        hiddenName: "languageDesc",
	        name: "languageDesc",
	        id: "languageDesc",
	        allowBlank: false,
	        blankText: blankTextLabel,
	        style: {
	            textTransform: "uppercase"
	        },
	        anchor: "95%"
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
        header: IsActiveLabel,
        dataIndex: 'isActive',
        hidden: isActiveHidden
    });
    var isApprovedGrid = new Ext.ux.grid.CheckColumn({
        header: IsApprovedLabel,
        dataIndex: 'isApproved',
        hidden: isApprovedHidden
    });
    
    var isReviewGrid = new Ext.ux.grid.CheckColumn({
        header: isActiveLabel,
        dataIndex: 'isActive',
        hidden: isActiveHidden
    });
    var isPostGrid = new Ext.ux.grid.CheckColumn({
        header: isPostLabel,
        dataIndex: 'isPost',
        hidden: isApprovedHidden
    });
    var languageColumnModelGrid = [new Ext.grid.RowNumberer(),
                                     {
        dataIndex: "languageCode",
        header: languageCodeLabel,
        sortable: true,
        hidden: false,
		editor : languageCode
					
    },{
        dataIndex: "languageDesc",
        header: languageDescLabel,
        sortable: true,
        hidden: false,
		editor : languageDesc
					
    },
    isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid, isDeleteGrid, isActiveGrid, isApprovedGrid,isReviewGrid,isPostGrid,{
        dataIndex: "executeBy",
        header: executeByLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return record.data.staffName;
        }
    },
    {
        dataIndex: "executeTime",
        header: executeTimeLabel,
        sortable: true,
        hidden: false,
        renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            return Ext.util.Format.date(value, 'd-m-Y H:i:s');
        }
    }];
    var accessArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved','isReview','isPost'];
    var languageEditor = new Ext.ux.grid.RowEditor({
        saveText: 'Save',
        listeners: {
            CancelEdit: function(rowEditor, changes, record, rowIndex) {
                languageStore.reload();
            },
            afteredit: function(rowEditor, changes, record, rowIndex) {
                var method;
				this.save = true; // update record manually
                var record = this.grid.getStore().getAt(rowIndex);
				if(record.get('languageId')  > 0 ) {
					method ='save';
				} else {
					method='create';
				}
			
                Ext.Ajax.request({
                    url: '../controller/languageController.php',
                    method: 'POST',
                    params: {
                        method: method,
                        leafId: leafId,
                    
                        languageCode : record.get('languageCode'),
                        languageDesc: record.get('languageDesc'),
						languageId:record.get('languageId'),
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
                languageStore.reload();
            }
        }
    });
    var languageEntity = Ext.data.Record.create([{
        name: "languageId",
        type: "int"
    },
 
    {
        name: "languageCode",
        type: "string"
    },
    {
        name: "languageDesc",
        type: "string"
    },
    {
        name: "executeBy",
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
        name: "executeTime",
        type: "date",
        dateFormat: "Y-m-d H:i:s"
    }]);
    var languageGrid = new Ext.grid.GridPanel({
        border: false,
        store: languageStore,
        autoHeight: false,
        height: 400,
        columns: languageColumnModelGrid,
        plugins: [filters, languageEditor],
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
                    var e = new languageEntity({
                        languageId: '',
                      
                        languageCode :'',
                        languageDesc: '',
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
                    languageEditor.stopEditing();
                    languageStore.insert(0, e);
                    languageGrid.getSelectionModel().getSelections();
                    languageEditor.startEditing(0);
                }
            },
            {
                text: 'Check All',
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function() {
                        languageStore.each(function(rec) {
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
                        languageStore.each(function(rec) {
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
                        url = '../controller/languageController.php?';
                        var sub_url;
                        sub_url = '';
                   
                        var modified = languageStore.getModifiedRecords();
                        for(var i = 0; i < modified.length; i++) {
                            var record = languageStore.getAt(i);
                            
                            if(record.get('languageId')){
                            	sub_url = sub_url + '&languageId[]=' + record.get('languageId');
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
                                sub_url = sub_url + '&isReview[]=' + record.get('isReview');
                                sub_url = sub_url + '&isPost[]=' + record.get('isPost');
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
                                    languageStore.removeAll(); // force to remove all data
                                    languageStore.reload();
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
            store: languageStore,
            pageSize: perPage
        })
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
                languageStore.reload();
            }
        },
        
        '-', {
            text: excelToolbarLabel,
            iconCls: "page_excel",
            id: "page_excel",
            disabled: pagePrint,
            handler: function() {
                Ext.Ajax.request({
                    url: "../controller/languageController.php",
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
            store: languageStore,
            width: 320
        })],
        items: [languageGrid]
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