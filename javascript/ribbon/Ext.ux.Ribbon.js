Ext.namespace('Ext.ux.Ribbon');

Ext.ux.Ribbon = Ext.extend(Ext.TabPanel, {
    titleId : null,
    constructor : function(config){
        this.titleId = new Array();

        Ext.apply(config, {
            baseCls: "x-plain ui-ribbon",
            margins: "3 0 0 0",
            plugins: new Ext.ux.TabScrollerMenu({
                maxText  : 15,
                pageSize : 5
            }),
            enableTabScroll : true,
            plain: true,
            border: false,
            deferredRender : false,
            layoutOnTabChange : true,
            title : '&nbsp;',
            collapsible : false,
            listeners : {
                beforetabchange : function(tp, ntb, ctb){
                    tp.expand();
                },                
                afterrender : {
                    scope : this,
                    fn : function(){                        
                        if(this.titleId.length > 0){
                            for(var key = 0; key < this.titleId.length;  key++){
                                r = Ext.get(this.titleId[key].id);
                                if(r)
                                    r.on('click', this.titleId[key].fn);
                            }
                        }
                    }
                }
            }
        });

        Ext.apply(this, Ext.apply(this.initialConfig, config));

        if(config.items){
            for(var i = 0; i < config.items.length; i++)
                this.initRibbon(config.items[i], i);
        }

        Ext.ux.Ribbon.superclass.constructor.apply(this, arguments);
    },

    initRibbon : function(item, index){
        var tbarr = new Array();
        for(var j = 0; j < item.ribbon.length; j++){
            for (var i = 0; i < item.ribbon[j].items.length; i++) {
                if (item.ribbon[j].items[i].scale !== "small") {
                    item.ribbon[j].items[i].text = String(item.ribbon[j].items[i].text).replace(/[ +]/gi, "<br/>");
                }
            }            
            c = {
                xtype : "buttongroup",
                cls : "x-btn-group-ribbonstyle",
                defaults : {
                    scale : "large",
                    iconAlign : "top",
                    minWidth : 40                    
                },
                items : item.ribbon[j].items
            };

            title = item.ribbon[j].title || 'Ribbon Title';
            topTitle = item.ribbon[j].topTitle || false;
            onTitleClick = item.ribbon[j].onTitleClick || false;                        
            
            if(onTitleClick){
                titleId = 'ux-ribbon-' + Ext.id();
                title = '<span id="' + titleId + '" style="cursor:pointer;">' + title + '</span>';
                this.titleId.push({
                    id : titleId,
                    fn : onTitleClick
                });
            }

            if(!topTitle){
                Ext.apply(c, {
                    footerCfg: {
                        cls : "x-btn-group-header",
                        tag : "span",
                        html : title
                    }
                });
            } else {
                Ext.apply(c, {
                    title : title
                });
            }            
            cfg = item.ribbon[j].cfg || null;

            if(cfg){
                Ext.applyIf(c, item.ribbon[j].cfg);
                if(cfg.defaults)
                    Ext.apply(c.defaults, cfg.defaults);
            }            
            tbarr.push(c);
        }

        Ext.apply(item, {
            baseCls : "x-plain",
            tbar : tbarr
        });
    }
});