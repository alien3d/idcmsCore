/*!
 * Extensible 1.0.1
 * Copyright(c) 2010-2011 Extensible, LLC
 * licensing@ext.ensible.com
 * http://ext.ensible.com
 */

Ext.ensible.cal.EventStore = Ext.extend(Ext.data.Store, {
    constructor: function(config){
        // By default autoLoad will cause the store to load itself during the
        // constructor, before the owning calendar view has a chance to set up
        // the initial date params to use during loading.  We replace autoLoad
        // with a deferLoad property that the view can check for and use to set
        // up default params as needed, then call the load itself. 
        this.deferLoad = config.autoLoad;
        config.autoLoad = false;
        
        //this._dateCache = [];
        
        Ext.ensible.cal.EventStore.superclass.constructor.apply(this, arguments);
    },
    
    load : function(o){
        Ext.ensible.log('store load');
        
        // if params are passed delete the one-time defaults
        if(o.params){
            delete this.initialParams;
        }
        // this.initialParams will only be set if the store is being loaded manually
        // for the first time (autoLoad = false) so the owning calendar view set
        // the initial start and end date params to use. Every load after that will
        // have these params set automatically during normal UI navigation.
        if(this.initialParams){
            o = Ext.isObject(o) ? o : {};
            o.params = o.params || {};
            Ext.apply(o.params, this.initialParams);
            delete this.initialParams;
        }
        
        Ext.ensible.cal.EventStore.superclass.load.call(this, o);
    }
    
//    execute : function(action, rs, options, /* private */ batch) {
//        if(action=='read'){
//            var i = 0, 
//                dc = this._dateCache, 
//                len = dc.length,
//                range,
//                p = options.params,
//                start = p.start,
//                end = p.end;
//                
//            //options.add = true;
//            for(i; i<len; i++){
//                range = dc[i];
//                
//            }
//        }
//        Ext.ensible.cal.EventStore.superclass.execute.apply(this, arguments);
//    }
});

Ext.reg('extensible.eventstore', Ext.ensible.cal.EventStore);
