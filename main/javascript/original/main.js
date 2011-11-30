Ext.onReady(function() { 
    var perPage = 100;
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
    var tabPanel = new Ext.TabPanel({
        region: 'center',
        id: 'centerTabs',
        deferredRender: true,
        height: 50,
        activeTab: 0,
        defaults: {
            closable: true
        },
        autoScroll: true,
        enableTabScroll: true,
        plugins: new Ext.ux.TabCloseMenu(),
        items: [{
            id: 'tab1',
            title: 'Introduction',
            xtype: 'iframepanel',
            defaultSrc: './welcome.php'
        }]
    });
    var treePanel;
    function AddCenterTabIF(tabTitle, tabUrl) { // tabUrl='http://www.yahoo.com';
        var tab = tabPanel.add({
            xtype: 'iframepanel',
            title: tabTitle,
            defaultSrc: tabUrl,
            loadMask: false,
            closable: true,
            autoScroll: true
        });
        tabPanel.rendered && tabPanel.doLayout();
        tabPanel.setActiveTab(tab);
        return tab;
    }
    var tree = new Ext.tree.TreePanel({
        id: 'tree-panel',
        autoScroll: true,
        region: 'center',
        // tree-specific configs:
        rootVisible: false,
        lines: false,
        singleExpand: true,
        useArrows: true,
        animate: false,
        layoutConfig: {
            animate: false
        },
        loader: new Ext.tree.TreeLoader({
            dataUrl: '../controller/treeController.php',
            method: 'POST',
            baseParams: {
                method: 'read',
                leafId: leafId,
                isAdmin: isAdmin
            }
        }),
        lines: false,
        expanded: false,
        root: new Ext.tree.AsyncTreeNode({
            draggable: false,
            id: 'source'
        }),
        rootVisible: false,
        listeners: {
            'click': function(node, element) { // quack quack is this a  controller ? 
                if (node.attributes.emptyLeaf == false) {
                    AddCenterTabIF(node.attributes.leafFilename, '../../' + node.attributes.folderPath + '/view/' + node.attributes.leafFilename);
                } else {
                    Ext.MessageBox.alert(systemLabel, 'There are no program assign to leaf');
                }
            }
        }
    }); // treeJs.expand();
    var clock = new Ext.Toolbar.TextItem('');
    new Ext.Viewport({
        id: 'screenPage',
        layout: 'border',
        items: [
        {
            xtype: 'panel',
            region: 'west',
            title: 'Tree Menu',
            width: '250',
            minSize: 400,
            maxSize: 400,
            collapsible: true,
            items: [tree]
        },
        {
            region: 'center',
            layout: 'border',
            html: 'tstin',
            margins: '5 0 5 5',
            items: [tabPanel]
        },
        {
            region: 'south',
            xtype: 'panel',
            bbar: [{
                xtype: 'label',
                text: 'Welcome ' + username,
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
            '-', clock]
        }],
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