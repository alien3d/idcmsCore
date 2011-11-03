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
    
	var store = new Ext.data.ArrayStore({
        proxy   : new Ext.data.MemoryProxy(),
        fields  : ['applicationId', 'iconId', 'iconName', 'applicationCode', 'applicationEnglish']
    });
    
    store.loadData([
        [1,1,'BooksY.png','c','General Ledger'],
        [2,1,'Converter.png','s','Payment'],
        [3,1,'IPod.png','c','Invoice'],
        [4,1,'Contacts.png','s','Contact/Membership'],
        [5,1,'SysInfo.png','s','Banks'],
        [6,1,'Chuzzle.png','c','Preview Account'],
        [7,1,'Calendar.png','s','Calendar'],
        [8,1,'Chat1.png','s','Chat'],
        [9,1,'Todolist.png','s','Todo'],
        [10,1,'Settings.png','s','Setting']
    ]);
    
    var dataview = new Ext.DataView({
        store: store,
        tpl  : new Ext.XTemplate(
            '<ul>',
                '<tpl for=".">',
                	'<li>',
                        '<img width="64" height="64" src="../../javascript/resources/images/bigicon/{iconName}" />',                  
                        '<strong>{applicationEnglish}</strong>',
                        '</li>',
                   '</tpl>',
            '</ul>'
        ),
        id: 'phones',        
        itemSelector: 'li.phone',
        overClass   : 'phone-hover',
        singleSelect: true,
        multiSelect : true,
        autoScroll  : true
    });
    
  
    
    var listViewApplicationPanel= new Ext.Panel({
        region: 'center',    	
        layout: 'fit',
        items : dataview,
        height: 615,
        width : 500
    });
    var clock = new Ext.Toolbar.TextItem('');
    var panelBelow = new Ext.Panel({
    		 
    	            region: 'south',
    	           height:100,
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
    	            '-',
    	            
    	            clock]
    	
    });

    var viewPort = new Ext.Viewport({
        id: 'viewport',
        layout: 'border',
        items: [listViewApplicationPanel,panelBelow],
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