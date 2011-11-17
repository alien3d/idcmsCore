Ext.onReady(function() {
    Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';
    var username = 'this suppose to take ajax request';
    var leafProxy = new Ext.data.HttpProxy({
        url: '../../security/controller/leafController.php',
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message); uncommen for testing purpose
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
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
        baseParams: {
            method: 'read',
            isAdmin: isAdmin,
            leafIdTemp: leafId,
            filterLanguage: true
        },
        root: 'data',
        fields: [{
            name: 'leafId',
            type: 'int'
        },
        {
            name: 'leafNative',
            type: 'string'
        },
        {
            name: 'folderPath',
            type: 'string'
        }]
    });
    var themeProxy = new Ext.data.HttpProxy({
        url: '../../system/controller/themeController.php',
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message); uncommen for testing purpose
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var themeReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'themeId'
    });
    var themeStore = new Ext.data.JsonStore({
        proxy: themeProxy,
        reader: themeReader,
        autoLoad: true,
        autoDestroy: true,
        baseParams: {
            method: 'read',
            field: 'themeId',
            leafId: leafId
        },
        root: 'data',
        fields: [{
            name: 'themeId',
            type: 'int'
        },
        {
            name: 'themeNote',
            type: 'string'
        },
        {
            name: 'themePath',
            type: 'string'
        }]
    });
    var languageProxy = new Ext.data.HttpProxy({
        url: '../../translation/controller/languageController.php',
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message); uncommen for testing purpose
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
        }
    });
    var languageReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        messageProperty: 'message',
        idProperty: 'languageId'
    });
    var languageStore = new Ext.data.JsonStore({
        proxy: languageProxy,
        reader: languageReader,
        autoLoad: true,
        autoDestroy: true,
        baseParams: {
            method: 'read',
            field: 'languageId',
            leafId: leafId
        },
        root: 'data',
        fields: [{
            name: 'languageId',
            type: 'int'
        },
        {
            name: 'languageDesc',
            type: 'string'
        }]
    });
    var applicationProxy = new Ext.data.HttpProxy({
        url: "../../system/controller/applicationController.php",
        method: 'POST',
        success: function(response, options) {
            jsonResponse = Ext.decode(response.responseText);
            if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
            } else {
                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
            }
        },
        failure: function(response, options) {
            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
        }
    });
    var applicationReader = new Ext.data.JsonReader({
        totalProperty: "total",
        successProperty: "success",
        messageProperty: "message",
        idProperty: "applicationId"
    });
    var applicationStore = new Ext.data.JsonStore({
        proxy: applicationProxy,
        reader: applicationReader,
        autoLoad: true,
        autoDestroy: true,
        pruneModifiedRecords: true,
        baseParams: {
            method: "read",
            leafId: leafId,
            isAdmin: isAdmin,
            start: 0,
            perPage: 20000
        },
        root: "data",
        fields: [{
            name: 'applicationId',
            type: 'int'
        },
        {
            name: 'applicationSequence',
            type: 'int'
        },
        {
            name: 'applicationEnglish',
            type: 'string'
        },{
        	name: 'applicationFilename',
            type: 'string'
        },{
            name: 'iconId',
            type: 'int'
        },
        {
            name: 'iconName',
            type: 'string'
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
            name: 'executeBy',
            type: 'int'
        },
        {
            name: "executeTime",
            type: "date",
            dateFormat: "Y-m-d H:i:s"
        }]
    });
    var dataview = new Ext.DataView({
    	 viewConfig: {
             forceFit: true
         },
         autoHeight    : false,
         layout    : 'fit',
        store: applicationStore,
        tpl: new Ext.XTemplate('<ul>', '<tpl for=".">', '<li>', '<a href="filter.php?applicationId={applicationId}&applicationFilename={applicationFilename}"><img width="64" height="64" border=0 src="../../javascript/resources/images/bigicon/{iconName}.png" />', '<strong>{applicationEnglish}</strong>', '</li></a>', '</tpl>', '</ul>'),
        id: 'phones',
        itemSelector: 'li.phone',
        overClass: 'phone-hover',
        singleSelect: true,
        multiSelect: true,
        autoScroll: true
    });
    var listViewApplicationPanel = new Ext.Panel({
    	  viewConfig: {
              forceFit: true
          },
          autoHeight    : false,
          layout    : 'fit',
          region    : 'center',
        items: dataview,
        width: 500
    });
    var clock = new Ext.Toolbar.TextItem('');
    var panelBelow = new Ext.Panel({
        region: 'south',

        bbar: [{
            xtype: 'label',
            text: 'Welcome ',
            iconCls: 'user'
        },
        '->', {
            xtype: 'button',
            title: 'calendar',
            iconCls: 'calendar',
            disabled: true
        },
        '-', {
            xtype: 'button',
            title: 'chat',
            iconCls: 'group',
            disabled: true
        },
        '-', {
            xtype: 'button',
            title: 'mail',
            iconCls: 'email',
            disabled: true
        },
        '-', {
            xtype: 'button',
            title: 'todo',
            iconCls: 'lightbulb',
            disabled: true
        },
        '-', {
            xtype: 'combo',
            fieldLabel: 'Change Language',
            displayField: 'language',
            mode: 'local',
            triggerAction: 'all',
            selectOnFocus: true,
            resizable: false,
            listWidth: 100,
            width: 100,
            displayField: 'languageDesc',
            valueField: 'languageId',
            emptyText: 'Language',
            store: languageStore,
            listeners: {
                select: function() {
                    window.location.replace('language.php?languageId=' + this.getValue());
                }
            }
        },
        '-', {
            xtype: 'combo',
            fieldLabel: 'Change Theme',
            displayField: 'display',
            mode: 'local',
            triggerAction: 'all',
            selectOnFocus: true,
            resizable: false,
            listWidth: 100,
            width: 100,
            displayField: 'themeNote',
            valueField: 'themePath',
            emptyText: 'Color',
            store: themeStore,
            listeners: {
                select: function() {
                    window.location.replace('theme.php?theme=' + this.getValue());
                }
            }
        },
        '-', {
            xtype: 'button',
            text: 'Log Out',
            iconCls: 'house',
            handler: function() {
                window.location.replace('../../index.php');
            }
        },
        '-', clock]
    });
    var viewPort = new Ext.Viewport({
        id: 'viewport',
       layout:'border',
        items: [{
            xtype: 'panel',
            height: 30,
            region: 'north',
            items: [{
                xtype: 'box',
                html: 'IDCMS Core System',
                cls: 'header',
                height: 30
            }]
        },listViewApplicationPanel, panelBelow],
        listeners: {
            render: {
                fn: function() { // Kick off the clock timer that updates the
                    // clock el every second:
                    Ext.TaskMgr.start({
                        run: function() {
                            Ext.fly(clock.getEl()).update(new Date().format('g:i:s A')); // check status whos'online
                            // for chatting
                            // check status email
                        },
                        interval: 1000
                    });
                },
                delay: 100
            }
        }
    });
});