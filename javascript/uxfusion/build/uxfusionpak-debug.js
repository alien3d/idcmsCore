/*
 * ux.Media.ChartPack 2.1.3
 * Copyright(c) 2008-2010, Active Group, Inc.
 * licensing@theactivegroup.com
 * 
 * http://licensing.theactivegroup.com
 */

     
 Ext.namespace('Ext.ux.plugin');
 Ext.onReady(function(){
    
   
    var CSS = Ext.util.CSS;
    if(CSS){ 
        CSS.getRule('.x-hide-nosize') || //already defined?
            CSS.createStyleSheet('.x-hide-nosize{height:0px!important;width:0px!important;border:none!important;zoom:1;}.x-hide-nosize * {height:0px!important;width:0px!important;border:none!important;zoom:1;}');
        CSS.refreshCache();
    }
    
});

(function(){

      var El = Ext.Element, A = Ext.lib.Anim, supr = El.prototype; 
      var VISIBILITY = "visibility",
        DISPLAY = "display",
        HIDDEN = "hidden",
        NONE = "none";
        
      var fx = {};
    
      fx.El = {
	      	     
            
	       setDisplayed : function(value) {
                var me=this;
                me.visibilityCls ? (me[value !== false ?'removeClass':'addClass'](me.visibilityCls)) :
	                supr.setDisplayed.call(me, value);
                return me;
	        },
            
            
	        isDisplayed : function() {
	            return !(this.hasClass(this.visibilityCls) || this.isStyle(DISPLAY, NONE));
	        },
	        // private
	        fixDisplay : function(){
	            var me = this;
	            supr.fixDisplay.call(me);
                me.visibilityCls && me.removeClass(me.visibilityCls); 
	        },
	
	        
	        isVisible : function(deep) {
	            var vis = this.visible ||
				    (!this.isStyle(VISIBILITY, HIDDEN) && 
                        (this.visibilityCls ? 
                            !this.hasClass(this.visibilityCls) : 
                                !this.isStyle(DISPLAY, NONE))
                      );
				  
				  if (deep !== true || !vis) {
				    return vis;
				  }
				
				  var p = this.dom.parentNode,
                      bodyRE = /^body/i;
				
				  while (p && !bodyRE.test(p.tagName)) {
				    if (!Ext.fly(p, '_isVisible').isVisible()) {
				      return false;
				    }
				    p = p.parentNode;
				  }
				  return true;

	        },
            //Assert isStyle method for Ext 2.x
            isStyle: supr.isStyle || function(style, val) {
			    return this.getStyle(style) == val;
			}

	    };
        
        //Add basic capabilities to the Ext.Element.Flyweight class
        Ext.override(El.Flyweight, fx.El);

     
 Ext.ux.plugin.VisibilityMode = function(opt) {

    Ext.apply(this, opt||{});
    
    var CSS = Ext.util.CSS;

    if(CSS && !Ext.isIE && this.fixMaximizedWindow !== false && !Ext.ux.plugin.VisibilityMode.MaxWinFixed){
        //Prevent overflow:hidden (reflow) transitions when an Ext.Window is maximize.
        CSS.updateRule ( '.x-window-maximized-ct', 'overflow', '');
        Ext.ux.plugin.VisibilityMode.MaxWinFixed = true;  //only updates the CSS Rule once.
    }
    
   };


  Ext.extend(Ext.ux.plugin.VisibilityMode , Object, {

       
      bubble              :  true,

      
      fixMaximizedWindow  :  true,
     
      

      elements       :  null,

      

      visibilityCls   : 'x-hide-nosize',

      
      hideMode  :   'nosize' ,

      ptype     :  'uxvismode', 
      
      init : function(c) {

        var hideMode = this.hideMode || c.hideMode,
            plugin = this,
            bubble = Ext.Container.prototype.bubble,
            changeVis = function(){

	            var els = [this.collapseEl, this.actionMode].concat(plugin.elements||[]);
	
	            Ext.each(els, function(el){
		            plugin.extend( this[el] || el );
	            },this);
	
	            var cfg = {
                    visFixed  : true,
                    animCollapse : false,
                    animFloat   : false,
		            hideMode  : hideMode,
		            defaults  : this.defaults || {}
	            };
	
	            cfg.defaults.hideMode = hideMode;
	            
	            Ext.apply(this, cfg);
	            Ext.apply(this.initialConfig || {}, cfg);
            
            };

         c.on('render', function(){

            // Bubble up the layout and set the new
            // visibility mode on parent containers
            // which might also cause DOM reflow when
            // hidden or collapsed.
            if(plugin.bubble !== false && this.ownerCt){

               bubble.call(this.ownerCt, function(){
                  this.visFixed || this.on('afterlayout', changeVis, this, {single:true} );
               });
             }

             changeVis.call(this);

          }, c, {single:true});

     },
     
     extend : function(el, visibilityCls){
        el && Ext.each([].concat(el), function(e){
            
	        if(e && e.dom){
                 if('visibilityCls' in e)return;  //already applied or defined?
	             Ext.apply(e, fx.El);
	             e.visibilityCls = visibilityCls || this.visibilityCls;
	        }
        },this);
        return this;
     }

  });
  
  Ext.preg && Ext.preg('uxvismode', Ext.ux.plugin.VisibilityMode );
  
  Ext.provide && Ext.provide('uxvismode');
})();



(function(){

    //remove null and undefined members from an object and optionally URL encode the results
    var compactObj =  function(obj, encodeIt){
            var out = obj && Ext.isObject(obj)? {} : obj;
            if(out && Ext.isObject(out)){
	            for (var member in obj){
	               (obj[member] === null || obj[member] === undefined) || (out[member] = obj[member]);
	            }
            }
            return encodeIt ? 
                 ((out && Ext.isObject(out)) ? Ext.urlEncode(out) : encodeURI(out))
                 : out;
        },
        toString = Object.prototype.toString;
        
    
    Ext.ns('Ext.ux.plugin');
    
    
   

    Ext.ux.Media = function(config){
         this.toString = this.asMarkup;  //Inline rendering support for this and all subclasses
         Ext.apply(this,config||{});
         this.initMedia();
    };
    var ux = Ext.ux.Media,
        stateRE = /4$/i;

    if(parseFloat(Ext.version) < 2.2){ throw "Ext.ux.Media and sub-classes are not License-Compatible with your Ext release.";}

    Ext.ux.Media.prototype = {
        
         hasVisModeFix : !!Ext.ux.plugin.VisibilityMode, 
         
         mediaObject     : null,

         
         mediaCfg        : null,
         mediaVersion    : null,
         requiredVersion : null,
         
         
         hideMode        : 'display',

         
         unsupportedText : null,

         animCollapse  :  Ext.enableFx && Ext.isIE,

         animFloat     :  Ext.enableFx && Ext.isIE,

         autoScroll    : true,

         bodyStyle     : {position: 'relative'},

        
         initMedia      : function(){
            this.hasVisModeFix = !!Ext.ux.plugin.VisibilityMode; 
         },

         
         disableCaching  : false,

         _maxPoll        : 200,

         
         getMediaType: function(type){
             return ux.mediaTypes[type];
         },

         
         assert : function(v,def){
              v= typeof v === 'function'?v.call(v.scope||null):v;
              return Ext.value(v ,def);
         },

        
         assertId : function(id, def){
             id || (id = def || Ext.id());
             return id;
         },

        
         prepareURL : function(url, disableCaching){
            var parts = url ? url.split('#') : [''];
            if(!!url && (disableCaching = disableCaching === undefined ? this.disableCaching : disableCaching) ){
                var u = parts[0];
                if( !(/_dc=/i).test(u) ){
                    var append = "_dc=" + (new Date().getTime());
                    if(u.indexOf("?") !== -1){
                        u += "&" + append;
                    }else{
                        u += "?" + append;
                    }
                    parts[0] = u;
                }
            }
            return parts.length > 1 ? parts.join('#') : parts[0];
         },

          
         prepareMedia : function(mediaCfg, width, height, ct){

             mediaCfg = mediaCfg ||this.mediaCfg;

             if(!mediaCfg){return '';}

             var m= Ext.apply({url:false,autoSize:false}, mediaCfg); //make a copy

             m.url = this.prepareURL(this.assert(m.url,false),m.disableCaching);

             if( m.mediaType){

                 var value,tag, p, El = Ext.Element.prototype;
                 var media = Ext.apply({}, this.getMediaType(this.assert(m.mediaType,false)) || false );
                 var params = compactObj(Ext.apply(media.params||{},m.params || {}));
                 for(var key in params){

                    if(params.hasOwnProperty(key)){
                      m.children || (m.children = []);
                      p = this.assert(params[key],null);
                      p && (p = compactObj(p, m.encodeParams !== false));
                      tag = 
                        {tag:'param'
                         ,name:key
                         ,value: p 
                       };
                       (tag.value == key) && delete tag.value;
                       p && m.children.push(tag);

                    }
                 }
                 delete   media.params;

                 //childNode Text if plugin/object is not installed.
                 var unsup = this.assert(m.unsupportedText|| this.unsupportedText || media.unsupportedText,null);
                 if(unsup){
                     m.children || (m.children = []);
                     m.children.push(unsup);
                 }

                 if(m.style && typeof m.style != "object") { throw 'Style must be JSON formatted'; }

                 m.style = this.assert(Ext.apply(media.style || {}, m.style || {}) , {});
                 delete media.style;

                 m.height = this.assert(height || m.height || media.height || m.style.height, null);
                 m.width  = this.assert(width  || m.width  || media.width || m.style.width ,null);

                 m = Ext.apply({tag:'object'},m,media);

                 //Convert element height and width to inline style to avoid issues with display:none;
                 if(m.height || m.autoSize)
                 {
                    Ext.apply(m.style, {
                        //Ext 2 & 3 compatibility -- Use the defaultUnit from the Component's el for default
                      height:(Ext.Element.addUnits || El.addUnits).call(this.mediaEl, m.autoSize ? '100%' : m.height ,El.defaultUnit||'px')});
                 }
                 if(m.width || m.autoSize)
                 {
                    Ext.apply(m.style, {
                        //Ext 2 & 3 compatibility -- Use the defaultUnit from the Component's el for default
                      width :(Ext.Element.addUnits || El.addUnits).call(this.mediaEl, m.autoSize ? '100%' : m.width ,El.defaultUnit||'px')});
                 }

                 m.id   = this.assertId(m.id);
                 m.name = this.assertId(m.name, m.id);

                 m._macros= {
                   url       : m.url || ''
                  ,height    : (/%$/.test(m.height)) ? m.height : parseInt(m.height,10)||null
                  ,width     : (/%$/.test(m.width)) ? m.width : parseInt(m.width,10)||null
                  ,scripting : this.assert(m.scripting,false)
                  ,controls  : this.assert(m.controls,false)
                  ,scale     : this.assert(m.scale,1)
                  ,status    : this.assert(m.status,false)
                  ,start     : this.assert(m.start, false)
                  ,loop      : this.assert(m.loop, false)
                  ,volume    : this.assert(m.volume, 20)
                  ,id        : m.id
                 };

                 delete   m.url;
                 delete   m.mediaType;
                 delete   m.controls;
                 delete   m.status;
                 delete   m.start;
                 delete   m.loop;
                 delete   m.scale;
                 delete   m.scripting;
                 delete   m.volume;
                 delete   m.autoSize;
                 delete   m.autoScale;
                 delete   m.params;
                 delete   m.unsupportedText;
                 delete   m.renderOnResize;
                 delete   m.disableCaching;
                 delete   m.listeners;
                 delete   m.height;
                 delete   m.width;
                 delete   m.encodeParams;
                 return m;
              }else{
                 var unsup = this.assert(m.unsupportedText|| this.unsupportedText || media.unsupportedText,null);
                 unsup = unsup ? Ext.DomHelper.markup(unsup): null;
                 return String.format(unsup || 'Media Configuration/Plugin Error',' ',' ');
             }
           },

           
         asMarkup  : function(mediaCfg){
              return this.mediaMarkup(this.prepareMedia(mediaCfg));
         },

          
         mediaMarkup : function(mediaCfg){
            mediaCfg = mediaCfg || this.mediaCfg;
            if(mediaCfg){
                 var _macros = mediaCfg._macros;
                 delete mediaCfg._macros;
                 var m = Ext.DomHelper.markup(mediaCfg);
                 if(_macros){
                   var _m, n;
                    for ( n in _macros){
                      _m = _macros[n];
                      if(_m !== null){
                           m = m.replace(new RegExp('((%40|@)'+n+')','g'),_m+'');
                      }
                    }
                  }
                  
                  return m;
            }
         },

         
         setMask  : function(el) {
             var mm;
             if((mm = this.mediaMask)){
                    mm.el || (mm = this.mediaMask = new Ext.ux.IntelliMask(el,Ext.isObject(mm) ? mm : {msg : mm}));
                    mm.el.addClass('x-media-mask');
             }

         },
         
          refreshMedia  : function(target){
                 if(this.mediaCfg) {this.renderMedia(null,target);}
                 return this;
          },

          
          renderMedia : function(mediaCfg, ct, domPosition , w , h){
              if(!Ext.isReady){
                  Ext.onReady(this.renderMedia.createDelegate(this,Array.prototype.slice.call(arguments,0)));
                  return;
              }
              var mc = (this.mediaCfg = mediaCfg || this.mediaCfg) ;
              ct = Ext.get(this.lastCt || ct || (this.mediaObject?this.mediaObject.dom.parentNode:null));
              this.onBeforeMedia.call(this, mc, ct, domPosition , w , h);
              
              if(ct){
                  this.lastCt = ct;
                  if(mc && (mc = this.prepareMedia(mc, w, h, ct))){
                     this.setMask(ct);
                     this.mediaMask && this.autoMask && this.mediaMask.show();
                     this.clearMedia().writeMedia(mc, ct, domPosition || 'afterbegin');
                  }
              }
              this.onAfterMedia(ct);
          },

          
          writeMedia : function(mediaCfg, container, domPosition ){
              var ct = Ext.get(container), markup;
              if(ct){
                markup = this.mediaMarkup(mediaCfg);
                domPosition ? Ext.DomHelper.insertHtml(domPosition, ct.dom, markup)
                  :ct.update(markup);
              }
          },

          
          clearMedia : function(){
            var mo;
            if(Ext.isReady && (mo = this.mediaObject)){
                mo.remove(true,true);
            }
            this.mediaObject = null;
            return this;
          },

           
          resizeMedia   : function(comp, aw, ah, w, h){
              var mc = this.mediaCfg;
              if(mc && this.rendered && mc.renderOnResize && (!!aw || !!ah)){
                  // Ext.Window.resizer fires this event a second time
                  if(arguments.length > 3 && (!this.mediaObject || mc.renderOnResize )){
                      this.refreshMedia(this[this.mediaEl]);
                  }
              }
          },

          
          onBeforeMedia  : function(mediaCfg, ct, domPosition, width, height){

            var m = mediaCfg || this.mediaCfg, mt;

            if( m && (mt = this.getMediaType(m.mediaType)) ){
                m.autoSize = m.autoSize || mt.autoSize===true;
                var autoSizeEl;
                //Calculate parent container size for macros (if available)
                if(m.autoSize && (autoSizeEl = Ext.isReady?
                    //Are we in a layout ? autoSize to the container el.
                     Ext.get(this[this.mediaEl] || this.lastCt || ct) :null)
                 ){
                  m.height = this.autoHeight ? null : autoSizeEl.getHeight(true);
                  m.width  = this.autoWidth ? null : autoSizeEl.getWidth(true);
                }

             }
             this.assert(m.height,height);
             this.assert(m.width ,width);
             mediaCfg = m;

          },

          
          onMediaLoad : function(e){
               if(e && e.type == 'load'){
                  this.fireEvent('mediaload',this, this.mediaObject );
                  this.mediaMask && this.autoMask && this.mediaMask.hide();
               }
          },
          
          onAfterMedia   : function(ct){
               var mo;
               if(this.mediaCfg && ct && 
                  (mo = new (this.elementClass || Ext.ux.Media.Element)(ct.child('.x-media', true),true )) &&
                   mo.dom
                  ){
                   //Update ElCache with the new Instance
                   this.mediaObject = mo;
                   mo.ownerCt = this;

                   var L; //Reattach any DOM Listeners after rendering.
                   if(L = this.mediaCfg.listeners ||null){
                      mo.on(L);  //set any DOM listeners
                    }
                   this.fireEvent('mediarender',this, this.mediaObject );

                    //Load detection for non-<object> media (iframe, img)
                   if(mo.dom.tagName !== 'OBJECT'){
                      mo.on({
                       load  :this.onMediaLoad
                      ,scope:this
                      ,single:true
                     });
                   } else {
                       //IE, Opera possibly others, support a readyState on <object>s
                       this._countPoll = 0;
                       this.pollReadyState( this.onMediaLoad.createDelegate(this,[{type:'load'}],0));
                   }
               }
              (this.autoWidth || this.autoHeight) && this.syncSize();
          },

          
         pollReadyState : function( cb, readyRE){

            var media = this.getInterface();
            if(media && 'readyState' in media){
                (readyRE || stateRE).test(media.readyState) ? cb() : arguments.callee.defer(10,this,arguments);
            }
         },

          
          getInterface  : function(){
              return this.mediaObject?this.mediaObject.dom||null:null;
          },

         detectVersion  : Ext.emptyFn,

         

         autoMask   : false
    };

    var componentAdapter = {

        init         : function(){

            this.getId = function(){
                return this.id || (this.id = "media-comp" + (++Ext.Component.AUTO_ID));
            };

            this.html = this.contentEl = this.items = null;
           
            this.initMedia();
             
            //Attach the Visibility Fix (if available) to the current instance
            if(this.hideMode == 'nosize' && this.hasVisModeFix ){
                  new Ext.ux.plugin.VisibilityMode({ 
                      elements: ['bwrap','mediaEl'],
                      hideMode:'nosize'}).init(this); 
            } 

            //Inline rendering support for this and all subclasses
            this.toString = this.asMarkup;

            this.addEvents(

              
                'mediarender',
               

                'mediaload');

        },
        
        afterRender  : function(ct){
            //set the mediaMask
            this.setMask(this[this.mediaEl] || ct);
            componentAdapter.setAutoScroll.call(this);
            this.renderMedia(this.mediaCfg, this[this.mediaEl]);
        },
        
        beforeDestroy  :  function(){
            this.clearMedia();
            Ext.destroy(this.mediaMask, this.loadMask);
            this.lastCt = this.mediaObject = this.renderTo = this.applyTo = this.mediaMask = this.loadMask = null;
        },
         
        setAutoScroll   : function(){
            if(this.rendered){
                this.getContentTarget().setOverflow(!!this.autoScroll ? 'auto':'hidden');
            }
        },
        
        getContentTarget : function(){
            return this[this.mediaEl];
        },
        
        onResize : function(){
            if(this.mediaObject && this.mediaCfg.renderOnResize){
                this.refreshMedia();
            }
        }
    };

    

    Ext.ux.Media.Component= Ext.extend ( Ext.BoxComponent, {

        ctype         : "Ext.ux.Media.Component",

        
        mediaEl         : 'el',
        
        autoScroll    : true,

        autoEl  : {tag:'div',style : { overflow: 'hidden', display:'block',position: 'relative'}},

        cls     : "x-media-comp",

        mediaClass    : Ext.ux.Media,
        constructor   : function(config){
          //Inherit the ux.Media class
          Ext.apply(this , config, this.mediaClass.prototype );
          ux.Component.superclass.constructor.apply(this, arguments);
        },
        
        initComponent   : function(){
            ux.Component.superclass.initComponent.apply(this,arguments);
            componentAdapter.init.apply(this,arguments);
        },
        
        afterRender  : function(ct){
            ux.Component.superclass.afterRender.apply(this,arguments);
            componentAdapter.afterRender.apply(this,arguments);
         },
         
        beforeDestroy   : function(){
            componentAdapter.beforeDestroy.apply(this,arguments);
            this.rendered && ux.Component.superclass.beforeDestroy.apply(this,arguments);
         },
        doAutoLoad : Ext.emptyFn,
        
        getContentTarget : componentAdapter.getContentTarget,
        //Ext 2.x does not have Box setAutoscroll
        setAutoScroll : componentAdapter.setAutoScroll,
        
        onResize : function(){
            ux.Component.superclass.onResize.apply(this,arguments);
            componentAdapter.onResize.apply(this,arguments);
        }
        
    });

    Ext.reg('uxmedia', Ext.ux.Media.Component);
    Ext.reg('media', Ext.ux.Media.Component);

    

    Ext.ux.Media.Panel = Ext.extend( Ext.Panel,  {

        cls           : "x-media-panel",

        ctype         : "Ext.ux.Media.Panel",
         
        autoScroll    : false,

          
        mediaEl       : 'body',

        mediaClass    : Ext.ux.Media,

        constructor   : function(config){
	         //Inherit the ux.Media class
	          Ext.apply(this , this.mediaClass.prototype );
	          ux.Panel.superclass.constructor.apply(this, arguments);
        },

        
        initComponent   : function(){
            ux.Panel.superclass.initComponent.apply(this,arguments);
            componentAdapter.init.apply(this,arguments);
        },
        
        afterRender  : function(ct){
            ux.Panel.superclass.afterRender.apply(this,arguments);
            componentAdapter.afterRender.apply(this,arguments);
         },
         
        beforeDestroy  : function(){
            componentAdapter.beforeDestroy.apply(this,arguments);
            this.rendered && ux.Panel.superclass.beforeDestroy.apply(this,arguments);
         },
        doAutoLoad : Ext.emptyFn,
        
        getContentTarget : componentAdapter.getContentTarget,

        setAutoScroll : componentAdapter.setAutoScroll,
        
        onResize : function(){
            ux.Panel.superclass.onResize.apply(this,arguments);
            componentAdapter.onResize.apply(this,arguments);
        }

    });


    Ext.reg('mediapanel', Ext.ux.Media.Panel);
    

    Ext.ux.Media.Portlet = Ext.extend ( Ext.ux.Media.Panel , {
       anchor       : '100%',
       frame        : true,
       collapseEl   : 'bwrap',
       collapsible  : true,
       draggable    : true,
       autoWidth    : true,
       ctype        : "Ext.ux.Media.Portlet",
       cls          : 'x-portlet x-media-portlet'

    });

    Ext.reg('mediaportlet', Ext.ux.Media.Portlet);

   

    Ext.ux.Media.Window = Ext.extend( Ext.Window ,{

        
        constructor   : function(){
          Ext.applyIf(this , this.mediaClass.prototype );
          ux.Window.superclass.constructor.apply(this, arguments);
        },

         cls           : "x-media-window",
         
         autoScroll    : false,
         
         ctype         : "Ext.ux.Media.Window",

         mediaClass    : Ext.ux.Media,

          
         mediaEl       : 'body',

        
        initComponent   : function(){
            ux.Window.superclass.initComponent.apply(this,arguments);
            componentAdapter.init.apply(this,arguments);
        },

        
        afterRender  : function(){
            ux.Window.superclass.afterRender.apply(this,arguments);  //wait for sizing
            componentAdapter.afterRender.apply(this,arguments);
         },
         
        beforeDestroy   : function(){
            componentAdapter.beforeDestroy.apply(this,arguments);
            this.rendered && ux.Window.superclass.beforeDestroy.apply(this,arguments);
         },

        doAutoLoad : Ext.emptyFn,
        
        getContentTarget : componentAdapter.getContentTarget,

        setAutoScroll : componentAdapter.setAutoScroll,
        
        onResize : function(){
            ux.Window.superclass.onResize.apply(this,arguments);
            componentAdapter.onResize.apply(this,arguments);
        }

    });

    Ext.reg('mediawindow', ux.Window);

    Ext.ns('Ext.capabilities');
    Ext.ns('Ext.ux.Media.plugin');
    
    var CAPS = (Ext.capabilities.hasAudio || 
       (Ext.capabilities.hasAudio = function(){
                
                var aTag = !!document.createElement('audio').canPlayType,
                    aAudio = ('Audio' in window) ? new Audio('') : {},
                    caps = aTag || ('canPlayType' in aAudio) ? { tag : aTag, object : ('play' in aAudio)} : false,
                    mime,
                    chk,
                    mimes = {
                            mp3 : 'audio/mpeg', //mp3
                            ogg : 'audio/ogg',  //Ogg Vorbis
                            wav : 'audio/x-wav', //wav 
                            basic : 'audio/basic', //au, snd
                            aif  : 'audio/x-aiff' //aif, aifc, aiff
                        };
                    
                    if(caps && ('canPlayType' in aAudio)){
                       for (chk in mimes){ 
                            caps[chk] = (mime = aAudio.canPlayType(mimes[chk])) != 'no' && (mime != '');
                        }
                    }                     
                    return caps;
            }()));
            
     Ext.iterate || Ext.apply (Ext, {
        iterate : function(obj, fn, scope){
            if(Ext.isEmpty(obj)){
                return;
            }
            if(Ext.isIterable(obj)){
                Ext.each(obj, fn, scope);
                return;
            }else if(Ext.isObject(obj)){
                for(var prop in obj){
                    if(obj.hasOwnProperty(prop)){
                        if(fn.call(scope || obj, prop, obj[prop], obj) === false){
                            return;
                        };
                    }
                }
            }
        },
        isIterable : function(v){
            //check for array or arguments
            if(Ext.isArray(v) || v.callee){
                return true;
            }
            //check for node list type
            if(/NodeList|HTMLCollection/.test(toString.call(v))){
                return true;
            }
            //NodeList has an item and length property
            //IXMLDOMNodeList has nextNode method, needs to be checked first.
            return ((v.nextNode || v.item) && Ext.isNumber(v.length));
        },
        
        isObject : function(obj){
            return !!obj && toString.apply(obj) == '[object Object]';
        }
     });
    
     
    Ext.ux.Media.plugin.AudioEvents = Ext.extend(Ext.ux.Media.Component,{
    
       autoEl  : {tag:'div' },
       
       cls: 'x-hide-offsets',
       
       disableCaching : false,
       
       
       audioEvents : {},
       
       
       volume     : .5,
       
       ptype      : 'audioevents',
       
       
       initComponent : function(){
          this.mediaCfg || (this.mediaCfg = {
              mediaType : 'WAV',
              start     : true,
              url       : ''
          });
          Ext.ux.Media.plugin.AudioEvents.superclass.initComponent.apply(this,arguments);
          
          this.addEvents(
          
           'beforeaudio');
           
           this.setVolume(this.volume);
       },
       
       
       init : function( target ){
        
            this.rendered || this.render(Ext.getBody());
            
            if(target.dom || target.ctype){
                var plugin = this;
                Ext.iterate(this.audioEvents || {}, 
                 function(event){
                   
                    if(target.events && !target.events[event]) return;
                    
                    
                    Ext.applyIf(target, {
                       audioPlugin : plugin,
                       audioListeners : {},
                       
                       
                       removeAudioListener : function(audioEvent){
                          if(audioEvent && this.audioListeners[audioEvent]){ 
                               this.removeListener && 
                                 this.removeListener(audioEvent, this.audioListeners[audioEvent], this);
                               delete this.audioListeners[audioEvent];
                          }
                       },
                       
                       removeAudioListeners : function(){
                          var c = [];
                          Ext.iterate(this.audioListeners, function(audioEvent){c.push(audioEvent);});
                          Ext.iterate(c, this.removeAudioListener, this);
                       },
                       
                       addAudioListener : function(audioEvent){
                           if(this.audioListeners[audioEvent]){
                               this.removeAudioListener(audioEvent);
                           }
                           this.addListener && 
                             this.addListener (audioEvent, 
                               this.audioListeners[audioEvent] = function(){
                               this.audioPlugin.onEvent(this, audioEvent);
                             }, this);
                        
                       } ,

                       enableAudio : function(){
                          this.audioPlugin && this.audioPlugin.enable();
                       },
                       
                       disableAudio : function(){
                          this.audioPlugin && this.audioPlugin.disable();
                       },
                       
                       setVolume : function(volume){
                          this.audioPlugin && this.audioPlugin.setVolume(volume);
                       }
                    });
                    
                    target.addAudioListener(event);
                    
                },this);
            }
       },
       
       
       setVolume   : function(volume){
            var AO = this.audioObject, v = Math.max(Math.min(parseFloat(volume)||0, 1),0);
            this.mediaCfg && (this.mediaCfg.volume = v*100);
            this.volume = v;
            AO && (AO.volume = v);
            return this;
       },
       
       
       onEvent : function(comp, event){
           if(!this.disabled && this.audioEvents && this.audioEvents[event]){
              if(this.fireEvent('beforeaudio',this, comp, event) !== false ){
                  this.mediaCfg.url = this.audioEvents[event];

                  if(CAPS.object){  //HTML5 Audio support?
                        this.audioObject && this.audioObject.stop && this.audioObject.stop();
                        if(this.audioObject = new Audio(this.mediaCfg.url || '')){
                            this.setVolume(this.volume);
                            this.audioObject.play && this.audioObject.play();
                        }
                  } else {
                        var O = this.getInterface();
                        if(O){ 
                            if(O.object){  //IE ActiveX
                                O= O.object;
	                            ('Open' in O) && O.Open(this.mediaCfg.url || '');
	                            ('Play' in O) && O.Play();
                            }else {  //All Others - just rerender the tag
                                this.refreshMedia();      
                            }
                            
                        }
                  }
              }
              
           }
       }
    
    });
    
    Ext.preg && Ext.preg('audioevents', Ext.ux.Media.plugin.AudioEvents);

    Ext.onReady(function(){
        //Generate CSS Rules if not defined in markup
        var CSS = Ext.util.CSS, rules=[];

        CSS.getRule('.x-media', true) || (rules.push('.x-media{width:100%;height:100%;outline:none;overflow:hidden;}'));
        CSS.getRule('.x-media-mask') || (rules.push('.x-media-mask{width:100%;height:100%;overflow:hidden;position:relative;zoom:1;}'));

        //default Rule for IMG:  h/w: auto;
        CSS.getRule('.x-media-img') || (rules.push('.x-media-img{background-color:transparent;width:auto;height:auto;position:relative;}'));

        // Add the new masking rule if not present.
        CSS.getRule('.x-masked-relative') || (rules.push('.x-masked-relative{position:relative!important;}'));

        if(!!rules.length){
             CSS.createStyleSheet(rules.join(''));
             CSS.refreshCache();
        }

    });

    
    
    Ext.ux.Media.Element = Ext.extend ( Ext.Element , {
    
        
        constructor   : function( element ) {
            
            Ext.ux.Media.Element.superclass.constructor.apply(this, arguments);
           
            
            if(Ext.elCache){  //Ext 3.1 compat
                Ext.elCache[this.id] || (Ext.elCache[this.id] = {
                    events : {},
                    data : {}
                });
                Ext.elCache[this.id].el = this;
            }else {
                Ext.Element.cache[this.id] = this;
            }

        },

        
        mask : function(msg, msgCls){

            this.maskEl || (this.maskEl = this.parent('.x-media-mask') || this.parent());

            return this.maskEl.mask.apply(this.maskEl, arguments);

        },
        unmask : function(remove){

            if(this.maskEl){
                this.maskEl.unmask(remove);
                this.maskEl = null;
            }
        },
        
        

        remove : function(cleanse, deep){
              if(this.dom){
                this.unmask(true);
                this.removeAllListeners();    //remove any Ext-defined DOM listeners
                Ext.ux.Media.Element.superclass.remove.apply(this,arguments);
                this.dom = null;  //clear ANY DOM references
              }
         }

    });

    Ext.ux.Media.prototype.elementClass  =  Ext.ux.Media.Element;

    
    Ext.ux.IntelliMask = function(el, config){

        Ext.apply(this, config || {msg : this.msg});
        this.el = Ext.get(el);

    };

    Ext.ux.IntelliMask.prototype = {

        

         removeMask  : false,

        
        msg : 'Loading Media...',
        
        msgCls : 'x-mask-loading',


        
        zIndex : null,

        
        disabled: false,

        
        active: false,

        
        autoHide: false,

        
        disable : function(){
           this.disabled = true;
        },

        
        enable : function(){
            this.disabled = false;
        },

        
        show: function(msg, msgCls, fn, fnDelay ){

            var opt={}, autoHide = this.autoHide;
            fnDelay = parseInt(fnDelay,10) || 20; //ms delay to allow mask to quiesce if fn specified

            if(Ext.isObject(msg)){
                opt = msg;
                msg = opt.msg;
                msgCls = opt.msgCls;
                fn = opt.fn;
                autoHide = typeof opt.autoHide != 'undefined' ?  opt.autoHide : autoHide;
                fnDelay = opt.fnDelay || fnDelay ;
            }
            if(!this.active && !this.disabled && this.el){
                var mask = this.el.mask(msg || this.msg, msgCls || this.msgCls);

                this.active = !!this.el._mask;
                if(this.active){
                    if(this.zIndex){
                        this.el._mask.setStyle("z-index", this.zIndex);
                        if(this.el._maskMsg){
                            this.el._maskMsg.setStyle("z-index", this.zIndex+1);
                        }
                    }
                }
            } else {fnDelay = 0;}

            //passed function is called regardless of the mask state.
            if(typeof fn === 'function'){
                fn.defer(fnDelay ,opt.scope || null);
            } else { fnDelay = 0; }

            if(autoHide && (autoHide = parseInt(autoHide , 10)||2000)){
                this.hide.defer(autoHide+(fnDelay ||0),this );
            }

            return this.active? {mask: this.el._mask , maskMsg: this.el._maskMsg} : null;
        },

        
        hide: function(remove){
            if(this.el){
                this.el.unmask(remove || this.removeMask);
            }
            this.active = false;
            return this;
        },

        // private
        destroy : function(){this.hide(true); this.el = null; }
     };




Ext.ux.Media.mediaTypes = {

     
       
      WAV : 
            Ext.apply(
            { tag      : 'object'
             ,cls      : 'x-media x-media-wav'
             ,data      : "@url"
             ,type     : 'audio/x-wav'
             ,loop  : false
             ,params  : {

                  filename     : "@url"
                 ,displaysize  : 0
                 ,autostart    : '@start'
                 ,showControls : '@controls'
                 ,showStatusBar:  false
                 ,showaudiocontrols : '@controls'
                 ,stretchToFit  : false
                 ,Volume        : "@volume"
                 ,PlayCount     : 1

               }
           },Ext.isIE?{
               classid :"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" //default for WMP installed w/Windows
               ,codebase:"http" + ((Ext.isSecure) ? 's' : '') + "://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701"
               ,type:'application/x-oleobject'
               }:
               {src:"@url"}),
    
        

       PDF : Ext.apply({  //Acrobat plugin thru release 8.0 all crash FF3
                tag     : 'object'
               ,cls     : 'x-media x-media-pdf'
               ,type    : "application/pdf"
               ,data    : "@url"
               ,autoSize:true
               ,params  : { src : "@url"}
               },Ext.isIE?{
                   classid :"CLSID:CA8A9780-280D-11CF-A24D-444553540000"
                   }:false),


      
      PDFFRAME  : {
                  tag      : 'iframe'
                 ,cls      : 'x-media x-media-pdf-frame'
                 ,frameBorder : 0
                 ,style    : { 'z-index' : 2}
                 ,src      : "@url"
                 ,autoSize :true
        },

       

      WMV : Ext.apply(
              {tag      :'object'
              ,cls      : 'x-media x-media-wmv'
              ,type     : 'application/x-mplayer2'
              //,type   : "video/x-ms-wmv"
              ,data     : "@url"
              ,autoSize : true
              ,params  : {

                  filename     : "@url"
                 ,displaysize  : 0
                 ,autostart    : "@start"
                 ,showControls : "@controls"
                 ,showStatusBar: "@status"
                 ,showaudiocontrols : true
                 ,stretchToFit  : true
                 ,Volume        :"@volume"
                 ,PlayCount     : 1

               }
               },Ext.isIE?{
                   classid :"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" //default for WMP installed w/Windows
                   ,codebase:"http" + ((Ext.isSecure) ? 's' : '') + "://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701"
                   ,type:'application/x-oleobject'
                   }:
               {src:"@url"}
             ),
                   
       APPLET  : {
                  tag      :'object'
                 ,cls      : 'x-media x-media-applet'
                 ,type     : 'application/x-java-applet'
                 ,unsupportedText : {tag : 'p', html:'Java is not installed/enabled.'}
                 ,params : {
                   url : '@url',
                   archive : '',  //the jar file
                   code    : '' //the Java class
                  }
       },
       
       "AUDIO-OGG"   : {
           tag      : 'audio',
           controls : '@controls',
           src      : '@url'
       },
       
       "VIDEO-OGG"   : {
           tag      : 'video',
           controls : '@controls',
           src      : '@url'
       },

     
       SWF   :  Ext.apply({
                  tag      :'object'
                 ,cls      : 'x-media x-media-swf'
                 ,type     : 'application/x-shockwave-flash'
                 ,scripting: 'sameDomain'
                 ,standby  : 'Loading..'
                 ,loop     :  true
                 ,start    :  false
                 ,unsupportedText : {cn:['The Adobe Flash Player is required.',{tag:'br'},{tag:'a',cn:[{tag:'img',src:'http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif'}],href:'http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash',target:'_flash'}]}
                 ,params   : {
                      movie     : "@url"
                     ,menu      : "@controls"
                     ,play      : "@start"
                     ,quality   : "high"
                     ,allowscriptaccess : "@scripting"
                     ,allownetworking : 'all'
                     ,allowfullScreen : false
                     ,bgcolor   : "#FFFFFF"
                     ,wmode     : "opaque"
                     ,loop      : "@loop"
                    }

                },Ext.isIE?
                    {classid :"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",
                     codebase:"http" + ((Ext.isSecure) ? 's' : '') + "://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0"
                    }:
                    {data     : "@url"}),
      
       SCRIBD :  Ext.apply({
                  tag      :'object'
                 ,cls      : 'x-media x-media-scribd'
                 ,type     : 'application/x-shockwave-flash'
                 ,scripting: 'always'
                 ,standby  : 'Loading..'
                 ,loop     :  true
                 ,start    :  false
                 ,unsupportedText : {cn:['The Adobe Flash Player is required.',{tag:'br'},{tag:'a',cn:[{tag:'img',src:'http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif'}],href:'http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash',target:'_flash'}]}
                 ,params   : {
                      movie     : "@url"
                     ,menu      : "@controls"
                     ,play      : "@start"
                     ,quality   : "high"
                     ,menu      : true
                     ,scale     : 'showall'
                     ,salign    : ' '
                     ,allowscriptaccess : "@scripting"
                     ,allownetworking : 'all'
                     ,allowfullScreen : true
                     ,bgcolor   : "#FFFFFF"
                     ,wmode     : "opaque"
                     ,loop      : "@loop"
                    }

                },Ext.isIE?
                    {classid :"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",
                     codebase:"http" + ((Ext.isSecure) ? 's' : '') + "://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0"
                    }:
                    {data     : "@url"}),
                    
      

        JWP :  Ext.apply({
              tag      :'object'
             ,cls      : 'x-media x-media-swf x-media-flv'
             ,type     : 'application/x-shockwave-flash'
             ,data     : "@url"
             ,loop     :  false
             ,start    :  false
             //ExternalInterface bindings
             ,boundExternals : ['sendEvent' , 'addModelListener', 'addControllerListener', 'addViewListener', 'getConfig', 'getPlaylist']
             ,params   : {
                 movie     : "@url"
                ,flashVars : {
                               autostart:'@start'
                              ,repeat   :'@loop'
                              ,height   :'@height'
                              ,width    :'@width'
                              ,id       :'@id'
                              }
                }

        },Ext.isIE?{
             classid :"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
            ,codebase:"http" + ((Ext.isSecure) ? 's' : '') + "://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"
            }:false),


        
        QT : Ext.apply({
                       tag      : 'object'
                      ,cls      : 'x-media x-media-quicktime'
                      ,type     : "video/quicktime"
                      ,style    : {position:'relative',"z-index":1 ,behavior:'url(#qt_event_source)'}
                      ,scale    : 'aspect'  // ( .5, 1, 2 , ToFit, Aspect )
                      ,unsupportedText : '<a href="http://www.apple.com/quicktime/download/">Get QuickTime</a>'
                      ,scripting : true
                      ,volume   : '50%'   //also 0-255
                      ,data     : '@url'
                      ,params   : {
                           src          : Ext.isIE?'@url': null
                          ,href        : "http://quicktime.com"
                          ,target      : "_blank"
                          ,autoplay     : "@start"
                          ,targetcache  : true
                          ,cache        : true
                          ,wmode        : 'opaque'
                          ,controller   : "@controls"
                      ,enablejavascript : "@scripting"
                          ,loop         : '@loop'
                          ,scale        : '@scale'
                          ,volume       : '@volume'
                          ,QTSRC        : '@url'

                       }

                     },Ext.isIE?
                          { classid      :'clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B'
                           ,codebase     :"http" + ((Ext.isSecure) ? 's' : '') + '://www.apple.com/qtactivex/qtplugin.cab#version=7,2,1,0'

                       }:
                       {
                         PLUGINSPAGE  : "http://www.apple.com/quicktime/download/"

                    }),

        


        QTEVENTS : {
                   tag      : 'object'
                  ,id       : 'qt_event_source'
                  ,cls      : 'x-media x-media-qtevents'
                  ,type     : "video/quicktime"
                  ,params   : {}
                  ,classid      :'clsid:CB927D12-4FF7-4a9e-A169-56E4B8A75598'
                  ,codebase     :"http" + ((Ext.isSecure) ? 's' : '') + '://www.apple.com/qtactivex/qtplugin.cab#version=7,2,1,0'
                 },

        

        WPMP3 : Ext.apply({
                       tag      : 'object'
                      ,cls      : 'x-media x-media-audio x-media-wordpress'
                      ,type     : 'application/x-shockwave-flash'
                      ,data     : '@url'
                      ,start    : true
                      ,loop     : false
                      ,boundExternals : ['open','close','setVolume','load']
                      ,params   : {
                           movie        : "@url"
                          ,width        :'@width'  //required
                          ,flashVars : {
                               autostart    : "@start"
                              ,controller   : "@controls"
                              ,enablejavascript : "@scripting"
                              ,loop         :'@loop'
                              ,scale        :'@scale'
                              ,initialvolume:'@volume'
                              ,width        :'@width'  //required
                              ,encode       : 'no'  //mp3 urls will be encoded
                              ,soundFile    : ''   //required
                          }
                       }
                    },Ext.isIE?{classid :"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"}:false),

        

        REAL : Ext.apply({
                tag     :'object'
               ,cls     : 'x-media x-media-real'
               ,type    : "audio/x-pn-realaudio-plugin"
               ,data    : "@url"
               ,controls: 'all'
               ,start   : -1
               ,standby : "Loading Real Media Player components..."
               ,params   : {
                          src        : "@url"
                         ,autostart  : "@start"
                         ,center     : false
                         ,maintainaspect : true
                         ,prefetch   : false
                         ,controller : "@controls"
                         ,controls   : "@controls"
                         ,volume     :'@volume'
                         ,loop       : "@loop"
                         ,numloop    : null
                         ,shuffle    : false
                         ,console    : "_master"
                         ,backgroundcolor : '#000000'
                         }

                },Ext.isIE?{classid :"clsid:CFCDAA03-8BE4-11CF-B84B-0020AFBBCCFA"}:false),

        

        SVG : {
                  tag      : 'object'
                 ,cls      : 'x-media x-media-img x-media-svg'
                 ,type     : "image/svg+xml"
                 ,data     : "@url"
                 ,params   : { src : "@url"}

        },

        

        GIF : {
                  tag      : 'img'
                 ,cls      : 'x-media x-media-img x-media-gif'
                 ,src     : "@url"
        },

        

        TIFF : {
                  tag      : 'object'
                 ,type     : "image/tiff"
                 ,cls      : 'x-media x-media-img x-media-tiff'
                 ,data     : "@url"
        },
        

        JPEG : {
                  tag      : 'img'
                 ,cls      : 'x-media x-media-img x-media-jpeg'
                 //,style    : {overflow:'hidden', display:'inline'}
                 ,src     : "@url"
        },
        

        JP2 :{
                  tag      : 'object'
                 ,cls      : 'x-media x-media-img x-media-jp2'
                 ,type     : Ext.isIE ? "image/jpeg2000-image" : "image/jp2"
                 ,data     : "@url"
                },
        
        PNG : {
                  tag      : 'img'
                 ,cls      : 'x-media x-media-img x-media-png'
                 ,src     : "@url"
        },
        

        HTM : {
                  tag      : 'iframe'
                 ,cls      : 'x-media x-media-html'
                 ,frameBorder : 0
                 ,autoSize : true
                 ,style    : {overflow:'auto', 'z-index' : 2}
                 ,src     : "@url"
        },
        

        TXT : {
                  tag      : 'object'
                 ,cls      : 'x-media x-media-text'
                 ,type     : "text/plain"
                 ,style    : {overflow:'auto',width:'100%',height:'100%'}
                 ,data     : "@url"
        },

        

        RTF : {
                  tag      : 'object'
                 ,cls      : 'x-media x-media-rtf'
                 ,type     : "application/rtf"
                 ,style    : {overflow:'auto',width:'100%',height:'100%'}
                 ,data     : "@url"
        },
        

        JS : {
                  tag      : 'object'
                 ,cls      : 'x-media x-media-js'
                 ,type     : "text/javascript"
                 ,style    : {overflow:'auto',width:'100%',height:'100%'}
                 ,data     : "@url"
        },
        

        CSS : {
                  tag      : 'object'
                 ,cls      : 'x-media x-media-css'
                 ,type     : "text/css"
                 ,style    : {overflow:'auto',width:'100%',height:'100%'}
                 ,data     : "@url"
        },
        

        SILVERLIGHT : {
              tag      : 'object'
             ,cls      : 'x-media x-media-silverlight'
             ,type      :"application/ag-plugin"
             ,data     : "@url"
             ,params  : { MinRuntimeVersion: "1.0" , source : "@url" }
        },
        

        SILVERLIGHT2 : {
              tag      : 'object'
             ,cls      : 'x-media x-media-silverlight'
             ,type      :"application/x-silverlight-2"
             ,data     : "data:application/x-silverlight,"
             ,params  : { MinRuntimeVersion: "2.0" }
             ,unsupportedText: '<a href="http://go2.microsoft.com/fwlink/?LinkID=114576&v=2.0"><img style="border-width: 0pt;" alt="Get Microsoft Silverlight" src="http://go2.microsoft.com/fwlink/?LinkID=108181"/></a>'
        },
 
        

        XML : {
              tag      : 'iframe'
             ,cls      : 'x-media x-media-xml'
             ,style    : {overflow:'auto'}
             ,src     : "@url"
        },

        

        //VLC ActiveX Player -- Suffers the same fate as the Acrobat ActiveX Plugin
        VLC : Ext.apply({
              tag      : 'object'
             ,cls      : 'x-media x-media-vlc'
             ,type     : "application/x-google-vlc-plugin"
             ,pluginspage:"http://www.videolan.org"
             ,events   : true
             ,start    : false
             ,params   : {
                   Src        : "@url"
                  ,MRL        : "@url"
                  ,autoplay  :  "@start"
                  ,ShowDisplay: "@controls"
                  ,Volume     : '@volume'
                  ,Autoloop   : "@loop"

                }

             },Ext.isIE?{
                  classid     :"clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921"
                 ,CODEBASE    :"http" + ((Ext.isSecure) ? 's' : '') + "://downloads.videolan.org/pub/videolan/vlc/latest/win32/axvlc.cab"
             }:{target : '@url'}),
             
        
        
        ODT : Ext.apply({
              tag      : 'object'
             ,cls      : 'x-media x-media-odt'
             ,type     : "application/vnd.oasis.opendocument.text"
             ,data     : "@url"
             ,params   : {
                   src        : '@url'
                } 
             },Ext.isIE?{
                  classid     :"clsid:67F2A879-82D5-4A6D-8CC5-FFB3C114B69D"
             }:false),
        
        
             
        ODS : Ext.apply({
              tag      : 'object'
             ,cls      : 'x-media x-media-odt'
             ,type     : "application/vnd.oasis.opendocument.spreadsheet"
             ,data     : "@url"
             ,params   : {
                   src        : '@url' 
                }
             },Ext.isIE?{
                  classid     :"clsid:67F2A879-82D5-4A6D-8CC5-FFB3C114B69D"
             }:false),
             
         
             
        IMPRESS : Ext.apply({
              tag      : 'object'
             ,cls      : 'x-media x-media-sxi'
             ,start    : false
             ,type     : "application/vnd.sun.xml.impress"
             ,data     : "@url"
             ,params   : {
                   wmode      : 'transparent',
                   src        : Ext.isIE ? '@url' : null
                }
             },Ext.isIE?{
                  classid     :"clsid:67F2A879-82D5-4A6D-8CC5-FFB3C114B69D"
                 
             }:{
               data     : "@url"
              
             }) 
 
    };

if (Ext.provide) {
    Ext.provide('uxmedia');
}

Ext.applyIf(Array.prototype, {

    
    map : function(fun, scope) {
        var len = this.length;
        if (typeof fun != "function") {
            throw new TypeError();
        }
        var res = new Array(len);

        for (var i = 0; i < len; i++) {
            if (i in this) {
                res[i] = fun.call(scope || this, this[i], i, this);
            }
        }
        return res;
    }
});





Ext.ux.MediaComponent = Ext.ux.Media.Component;
Ext.ux.MediaPanel     = Ext.ux.Media.Panel;
Ext.ux.MediaPortlet   = Ext.ux.Media.Portlet;
Ext.ux.MediaWindow    = Ext.ux.Media.Window;

})();



(function(){

   var ux = Ext.ux.Media;
    

    Ext.ux.Media.Flash = Ext.extend( Ext.ux.Media, {

        varsName       :'flashVars',

       
        externalsNamespace :  null,

        
        mediaType: Ext.apply({
              tag      : 'object'
             ,cls      : 'x-media x-media-swf'
             ,type     : 'application/x-shockwave-flash'
             ,loop     : null
             ,style   : {'z-index':0}
             ,scripting: "sameDomain"
             ,start    : true
             ,unsupportedText : {cn:['The Adobe Flash Player{0}is required.',{tag:'br'},{tag:'a',cn:[{tag:'img',src:'http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif'}],href:'http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash',target:'_flash'}]}
             ,params   : {
                  movie     : "@url"
                 ,play      : "@start"
                 ,loop      : "@loop"
                 ,menu      : "@controls"
                 ,quality   : "high"
                 ,bgcolor   : "#FFFFFF"
                 ,wmode     : "opaque"
                 ,allowscriptaccess : "@scripting"
                 ,allowfullscreen : false
                 ,allownetworking : 'all'
                }
             },Ext.isIE?
                    {classid :"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",
                     codebase:"http" + ((Ext.isSecure) ? 's' : '') + "://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"
                    }:
                    {data     : "@url"}),

        
        getMediaType: function(){
             return this.mediaType;
        },

        
        assertId : function(id, def){
             id || (id = def || Ext.id());
             return id.replace(/\+|-|\\|\/|\*/g,'');
         },

        
        initMedia : function(){

            ux.Flash.superclass.initMedia.call(this);

            var mc = Ext.apply({}, this.mediaCfg||{});
            var requiredVersion = (this.requiredVersion = mc.requiredVersion || this.requiredVersion|| false ) ;
            var hasFlash  = !!(this.playerVersion = this.detectFlashVersion());
            var hasRequired = hasFlash && (requiredVersion?this.assertVersion(requiredVersion):true);

            var unsupportedText = this.assert(mc.unsupportedText || this.unsupportedText || (this.getMediaType()||{}).unsupportedText,null);
            if(unsupportedText){
                 unsupportedText = Ext.DomHelper.markup(unsupportedText);
                 unsupportedText = mc.unsupportedText = String.format(unsupportedText,
                     (requiredVersion?' '+requiredVersion+' ':' '),
                     (this.playerVersion?' '+this.playerVersion+' ':' Not installed.'));
            }
            mc.mediaType = "SWF";

            if(!hasRequired ){
                this.autoMask = false;

                //Version check for the Flash Player that has the ability to start Player Product Install (6.0r65)
                var canInstall = hasFlash && this.assertVersion('6.0.65');
                if(canInstall && mc.installUrl){

                       mc =  mc.installDescriptor || {
                           mediaType  : 'SWF'
                            ,tag      : 'object'
                            ,cls      : 'x-media x-media-swf x-media-swfinstaller'
                            ,id       : 'SWFInstaller'
                            ,type     : 'application/x-shockwave-flash'
                            ,data     : "@url"
                            ,url              : this.prepareURL(mc.installUrl)
                            //The dimensions of playerProductInstall.swf must be at least 310 x 138 pixels,
                            ,width            : (/%$/.test(mc.width)) ? mc.width : ((parseInt(mc.width,10) || 0) < 310 ? 310 :mc.width)
                            ,height           : (/%$/.test(mc.height))? mc.height :((parseInt(mc.height,10) || 0) < 138 ? 138 :mc.height)
                            ,loop             : false
                            ,start            : true
                            ,unsupportedText  : unsupportedText
                            ,params:{
                                      quality          : "high"
                                     ,movie            : '@url'
                                     ,allowscriptacess : "always"
                                     ,wmode            : "opaque"
                                     ,align            : "middle"
                                     ,bgcolor          : "#3A6EA5"
                                     ,pluginspage      : mc.pluginsPage || this.pluginsPage || "http://www.adobe.com/go/getflashplayer"
                                   }
                        };
                        mc.params[this.varsName] = "MMredirectURL="+( mc.installRedirect || window.location)+
                                            "&MMplayerType="+(Ext.isIE?"ActiveX":"Plugin")+
                                            "&MMdoctitle="+(document.title = document.title.slice(0, 47) + " - Flash Player Installation");
                } else {
                    //Let superclass handle with unsupportedText property
                    mc.mediaType=null;
                }
            }

            

            if(mc.eventSynch){
                mc.params || (mc.params = {});
                var vars = mc.params[this.varsName] || (mc.params[this.varsName] = {});
                if(typeof vars === 'string'){ vars = Ext.urlDecode(vars,true); }
                var eventVars = (mc.eventSynch === true ? {
                         allowedDomain  : vars.allowedDomain || document.location.hostname
                        ,elementID      : mc.id || (mc.id = Ext.id())
                        ,eventHandler   : 'Ext.ux.Media.Flash.eventSynch'
                        }: mc.eventSynch );

                Ext.apply(mc.params,{
                     allowscriptaccess  : 'always'
                })[this.varsName] = Ext.applyIf(vars,eventVars);
            }

            this.bindExternals(mc.boundExternals);

            delete mc.requiredVersion;
            delete mc.installUrl;
            delete mc.installRedirect;
            delete mc.installDescriptor;
            delete mc.eventSynch;
            delete mc.boundExternals;

            this.mediaCfg = mc;


        },


        
        assertVersion : function(versionMap){

            var compare;
            versionMap || (versionMap = []);

            if(Ext.isArray(versionMap)){
                compare = versionMap;
            } else {
                compare = String(versionMap).split('.');
            }
            compare = (compare.concat([0,0,0,0])).slice(0,3); //normalize

            var tpv;
            if(!(tpv = this.playerVersion || (this.playerVersion = this.detectFlashVersion()) )){ return false; }

            if (tpv.major > parseFloat(compare[0])) {
                        return true;
            } else if (tpv.major == parseFloat(compare[0])) {
                   if (tpv.minor > parseFloat(compare[1]))
                            {return true;}
                   else if (tpv.minor == parseFloat(compare[1])) {
                        if (tpv.rev >= parseFloat(compare[2])) { return true;}
                        }
                   }
            return false;
        },

       
        detectFlashVersion : function(){
            if(ux.Flash.prototype.flashVersion ){
                return this.playerVersion = ux.Flash.prototype.flashVersion;
            }
            var version=false;
            var formatVersion = function(version){
              return version && !!version.length?
                {major:version[0] !== null? parseInt(version[0],10): 0
                ,minor:version[1] !== null? parseInt(version[1],10): 0
                ,rev  :version[2] !== null? parseInt(version[2],10): 0
                ,toString : function(){return this.major+'.'+this.minor+'.'+this.rev;}
                }:false;
            };
            var sfo= null;
            if(Ext.isIE){

                try{
                    sfo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
                }catch(e){
                    try {
                        sfo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");
                        version = [6,0,21];
                        // error if player version < 6.0.47 (thanks to Michael Williams @ Adobe for this solution)
                        sfo.allowscriptaccess = "always";
                    } catch(ex) {
                        if(version && version[0] === 6)
                            {return formatVersion(version); }
                        }
                    try {
                        sfo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
                    } catch(ex1) {}
                }
                if (sfo) {
                    version = sfo.GetVariable("$version").split(" ")[1].split(",");
                }
             }else if(navigator.plugins && navigator.mimeTypes.length){
                sfo = navigator.plugins["Shockwave Flash"];
                if(sfo && sfo.description) {
                    version = sfo.description.replace(/([a-zA-Z]|\s)+/, "").replace(/(\s+r|\s+b[0-9]+)/, ".").split(".");
                }
            }
            return (this.playerVersion = ux.Flash.prototype.flashVersion = formatVersion(version));

        }

        
        ,onAfterMedia : function(ct){

              ux.Flash.superclass.onAfterMedia.apply(this,arguments);
              var mo;
              if(mo = this.mediaObject){

                  var id = mo.id;
                  if(Ext.isIE ){

                    //fscommand bindings
                    //implement a fsCommand event interface since its not supported on IE when writing innerHTML

                    if(!(Ext.query('script[for='+id+']').length)){
                      writeScript('var c;if(c=Ext.getCmp("'+this.id+'")){c.onfsCommand.apply(c,arguments);}',
                                  {event:"FSCommand", htmlFor:id});
                    }
                  }else{
                      window[id+'_DoFSCommand'] || (window[id+'_DoFSCommand']= this.onfsCommand.createDelegate(this));
                  }
              }
         },

        
        clearMedia  : function(){

           //de-register fscommand hooks
           if(this.mediaObject){
               var id = this.mediaObject.id;
               if(Ext.isIE){
                    Ext.select('script[for='+id+']',true).remove();
               } else {
                    window[id+'_DoFSCommand']= null;
                    delete window[id+'_DoFSCommand'];
               }
           }

           return ux.Flash.superclass.clearMedia.call(this) || this;

        },

        
        getSWFObject : function() {
            return this.getInterface();
        },


        

        onfsCommand : function( command, args){

            if(this.events){
                this.fireEvent('fscommand', this, command ,args );
            }

        },

        

        setVariable : function(varName, value){
            var fo = this.getInterface();
            if(fo && 'SetVariable' in fo){
                fo.SetVariable(varName,value);
                return true;
            }
            fo = null;
            return false;

        },

       
        getVariable : function(varName ){
            var fo = this.getInterface();
            if(fo && 'GetVariable' in fo){
                return fo.GetVariable(varName );
            }
            fo = null;
            return undefined;

        },

        
        bindExternals : function(methods){

            if(methods && this.playerVersion.major >= 8){
                methods = new Array().concat(methods);
            }else{
                return;
            }

            var nameSpace = (typeof this.externalsNamespace == 'string' ?
                  this[this.externalsNamespace] || (this[this.externalsNamespace] = {} )
                     : this );

            Ext.each(methods,function(method){

               var m = method.name || method;
               var returnType = method.returnType || 'javascript';

                //Do not overwrite existing function with the same name.
               nameSpace[m] || (nameSpace[m] = function(){
                      return this.invoke.apply(this,[m, returnType].concat(Array.prototype.slice.call(arguments,0)));
               }.createDelegate(this));

            },this);
        },

        
        invoke   : function(method , returnType  ){

            var obj,r;

            if(method && (obj = this.getInterface()) && 'CallFunction' in obj ){
                var c = [
                    String.format('<invoke name="{0}" returntype="{1}">',method, returnType),
                    '<arguments>',
                    (Array.prototype.slice.call(arguments,2)).map(this._toXML, this).join(''),
                    '</arguments>',
                    '</invoke>'].join('');
                
                r = obj.CallFunction(c);

                typeof r === 'string' && returnType ==='javascript' && (r= Ext.decode(r));

            }
            return r;

        },

        
        onFlashInit  :  function(){

            if(this.mediaMask && this.autoMask){this.mediaMask.hide();}
            this.fireEvent.defer(300,this,['flashinit',this, this.getInterface()]);


        },

        
        pollReadyState : function(cb, readyRE){
            var media;

            if(media= this.getInterface()){
                if(typeof media.PercentLoaded != 'undefined'){
                   var perc = media.PercentLoaded() ;

                   this.fireEvent( 'progress' ,this , this.getInterface(), perc) ;
                   if( perc = 100 ) { cb(); return; }
                }

                this._countPoll++ > this._maxPoll || arguments.callee.defer(10,this,arguments);

            }

         },

        
        _handleSWFEvent: function(event)
        {
            var type = event.type||event||false;
            if(type){
                 if(this.events && !this.events[String(type)])
                     { this.addEvents(String(type));}

                 return this.fireEvent.apply(this, [String(type), this].concat(Array.prototype.slice.call(arguments,0)));
            }
        },


       _toXML    : function(value){

           var format = Ext.util.Format;
           var type = typeof value;
           if (type == "string") {
               return "<string>" + format.xmlEncode(value) + "</string>";}
           else if (type == "undefined")
              {return "<undefined/>";}
           else if (type == "number")
              {return "<number>" + value + "</number>";}
           else if (value == null)
              {return "<null/>";}
           else if (type == "boolean")
              {return value ? "<true/>" : "<false/>";}
           else if (value instanceof Date)
              {return "<date>" + value.getTime() + "</date>";}
           else if (Ext.isArray(value))
              {return this._arrayToXML(value);}
           else if (type == "object")
              {return this._objectToXML(value);}
           else {return "<null/>";}
         },

        _arrayToXML  : function(arrObj){

            var s = "<array>";
            for (var i = 0,l = arrObj.length ; i < l; i++) {
                s += "<property id=\"" + i + "\">" + this._toXML(arrObj[i]) + "</property>";
            }
            return s + "</array>";
        },

        _objectToXML  : function(obj){

            var s = "<object>";
            for (var prop in obj) {
                if(obj.hasOwnProperty(prop)){
                   s += "<property id=\"" + prop + "\">" + this._toXML(obj[prop]) + "</property>";
                }
              }
            return s + "</object>";

        }

    });

    
    Ext.ux.Media.Flash.eventSynch = function(elementID, event  ){
            var SWF = Ext.get(elementID), inst;
            if(SWF && (inst = SWF.ownerCt)){
                return inst._handleSWFEvent.apply(inst, Array.prototype.slice.call(arguments,1));
            }
        };


    var componentAdapter = {
       init         : function(){

          this.getId = function(){
              return this.id || (this.id = "flash-comp" + (++Ext.Component.AUTO_ID));
          };

          this.addEvents(

             
              'flashinit',

             
              'fscommand',

             
             'progress' );

        }

    };


     
   Ext.ux.Media.Flash.Component = Ext.extend(Ext.ux.Media.Component, {
         
         ctype         : "Ext.ux.Media.Flash.Component",


        
         cls    : "x-media-flash-comp",

         
         autoEl  : {tag:'div',style : { overflow: 'hidden', display:'block'}},

        
         mediaClass    : Ext.ux.Media.Flash,

        
         initComponent   : function(){

            componentAdapter.init.apply(this,arguments);
            Ext.ux.Media.Flash.Component.superclass.initComponent.apply(this,arguments);

         }



   });

   Ext.reg('uxflash', Ext.ux.Media.Flash.Component);

   ux.Flash.prototype.detectFlashVersion();

   

   Ext.ux.Media.Flash.Panel = Ext.extend(Ext.ux.Media.Panel,{

        ctype         : "Ext.ux.Media.Flash.Panel",

        mediaClass    : Ext.ux.Media.Flash,

        autoScroll    : false,

        
        shadow        : false,


        
        initComponent   : function(){
            componentAdapter.init.apply(this,arguments);
            Ext.ux.Media.Flash.Panel.superclass.initComponent.apply(this,arguments);

       }

   });

   Ext.reg('flashpanel', ux.Flash.Panel);
   Ext.reg('uxflashpanel', ux.Flash.Panel);

   

   Ext.ux.Media.Flash.Portlet = Ext.extend(Ext.ux.Media.Portlet,{
       ctype         : "Ext.ux.Media.Flash.Portlet",
       anchor       : '100%',
       frame        : true,
       collapseEl   : 'bwrap',
       collapsible  : true,
       draggable    : true,
       autoScroll    : false,
       autoWidth    : true,
       cls          : 'x-portlet x-flash-portlet',
       mediaClass    : Ext.ux.Media.Flash,
       
       initComponent   : function(){
           componentAdapter.init.apply(this,arguments);
           Ext.ux.Media.Flash.Panel.superclass.initComponent.apply(this,arguments);

       }

   });

   Ext.reg('flashportlet', ux.Flash.Portlet);
   Ext.reg('uxflashportlet', ux.Flash.Portlet);

   

   Ext.ux.Media.Flash.Window  = Ext.extend( Ext.ux.Media.Window , {

        ctype         : "Ext.ux.Media.Flash.Window",
        mediaClass    : Ext.ux.Media.Flash,

        autoScroll    : false,

        
        shadow        : false,


        
        initComponent   : function(){
            componentAdapter.init.apply(this,arguments);
            Ext.ux.Media.Flash.Window.superclass.initComponent.apply(this,arguments);

       }

   });

   Ext.reg('flashwindow', ux.Flash.Window);

   


   Ext.ux.Media.Flash.Element = Ext.extend ( Ext.ux.Media.Element , {

        

       remove : function(){

             var d ;
             // Fix streaming media troubles for IE
             // IE has issues with loose references when removing an <object>
             // before the onload event fires (all <object>s should have readyState == 4 after browsers onload)

             // Advice: do not attempt to remove the Component before onload has fired on IE/Win.

            if(Ext.isIE && Ext.isWindows && (d = this.dom)){

                this.removeAllListeners();
                d.style.display = 'none'; //hide it regardless of state
                if(d.readyState == 4){
                    for (var x in d) {
                        if (x.toLowerCase() != 'flashvars' && typeof d[x] == 'function') {
                            d[x] = null;
                        }
                    }
                }

             }

             Ext.ux.Media.Flash.Element.superclass.remove.apply(this, arguments);

         }

   });

   Ext.ux.Media.Flash.prototype.elementClass  =  Ext.ux.Media.Flash.Element;

   var writeScript = function(block, attributes) {
        attributes = Ext.apply({},attributes||{},{type :"text/javascript",text:block});

         try{
            var head,script, doc= document;
            if(doc && doc.getElementsByTagName){
                if(!(head = doc.getElementsByTagName("head")[0] )){

                    head =doc.createElement("head");
                    doc.getElementsByTagName("html")[0].appendChild(head);
                }
                if(head && (script = doc.createElement("script"))){
                    for(var attrib in attributes){
                          if(attributes.hasOwnProperty(attrib) && attrib in script){
                              script[attrib] = attributes[attrib];
                          }
                    }
                    return !!head.appendChild(script);
                }
            }
         }catch(ex){}
         return false;
    };

    
    if(Ext.isIE && Ext.isWindows && ux.Flash.prototype.flashVersion.major == 9) {

        window.attachEvent('onbeforeunload', function() {
              __flash_unloadHandler = __flash_savedUnloadHandler = function() {};
        });

        //Note: we cannot use IE's onbeforeunload event because an internal Flash Form-POST
        // raises the browsers onbeforeunload event when the server returns a response.  that is crazy!
        window.attachEvent('onunload', function() {

            Ext.each(Ext.query('.x-media-swf'), function(item, index) {
                item.style.display = 'none';
                for (var x in item) {
                    if (x.toLowerCase() != 'flashvars' && typeof item[x] == 'function') {
                        item[x] = null;
                    }
                }
            });
        });

    }

 Ext.apply(Ext.util.Format , {
       
        xmlEncode : function(value){
            return !value ? value : String(value)
                .replace(/&/g, "&amp;")
                .replace(/>/g, "&gt;")
                .replace(/</g, "&lt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&apos;");
        },

        
        xmlDecode : function(value){
            return !value ? value : String(value)
                .replace(/&gt;/g, ">")
                .replace(/&lt;/g, "<")
                .replace(/&quot;/g, '"')
                .replace(/&amp;/g, "&")
                .replace(/&apos;/g, "'");

        }

    });


 Ext.ux.FlashComponent  = Ext.ux.Media.Flash.Component ;
 Ext.ux.FlashPanel      = Ext.ux.Media.Flash.Panel;
 Ext.ux.FlashPortlet    = Ext.ux.Media.Flash.Portlet;
 Ext.ux.FlashWindow     = Ext.ux.Media.Flash.Window;

})();



 

(function(){

    Ext.namespace("Ext.ux.Chart");
    var chart = Ext.ux.Chart;
    var flash = Ext.ux.Media.Flash;

    Ext.ux.Chart.FlashAdapter = Ext.extend( Ext.ux.Media.Flash, {

       
       requiredVersion : 8,


       
       unsupportedText : {cn:['The Adobe Flash Player{0}is required.',{tag:'br'},{tag:'a',cn:[{tag:'img',src:'http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif'}],href:'http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash',target:'_flash'}]},

       
       chartURL        : null,

       
       chartData       : null,

       
       dataURL         : null,

       
       autoLoad        : null,

       
       loadMask        : null,

       
       mediaMask       : null,

       autoMask        : null,
       
       
       disableCaching : true,

       
       blankChartData  : '',


       
       externalsNamespace  : 'chart',

       
       chartCfg       : null,

       

       chart          : null,


       
       mediaCfg        : {url      : null,
                          id       : null,
                          start    : true,
                          controls : true,
                          height  : null,
                          width   : null,
                          autoSize : true,
                          renderOnResize:false,
                          scripting : 'always',
                          cls     :'x-media x-media-swf x-chart',
                          params  : {
                              allowscriptaccess : '@scripting',
                              wmode     :'opaque',
                              scale     :'exactfit',
                              scale       : null,
                              salign      : null
                           }
        },

       
       initMedia   : function(){

           this.addEvents(

               

               'beforeload',

               

               'loadexception',

               

               'chartload',

              
               'chartrender'
            );


           this.mediaCfg.renderOnResize =
                this.mediaCfg.renderOnResize || (this.chartCfg || {}).renderOnResize;

           chart.FlashAdapter.superclass.initMedia.call(this);

           if(this.autoLoad){
                this.on('mediarender', this.doAutoLoad, this, {single:true} );
           }
       },

       
       onBeforeMedia: function(){

          
          var mc =  this.mediaCfg;
          var mp = mc.params||{};
          delete mc.params;
          var mv = mp[this.varsName]||{};
          delete mp[this.varsName];

          //chartCfg
          var cCfg = Ext.apply({},this.chartCfg || {});

           //chart params
          var cp = Ext.apply({}, this.assert( cCfg.params,{}));
          delete cCfg.params;

           //chart.params.flashVars
          var cv = Ext.apply({}, this.assert( cp[this.varsName],{}));
          delete cp[this.varsName];

          Ext.apply(mc , cCfg, {
              url  : this.assert(this.chartURL, null)
          });

          mc.params = Ext.apply(mp,cp);
          mc.params[this.varsName] = Ext.apply(mv,cv);

          chart.FlashAdapter.superclass.onBeforeMedia.call(this);

      },

     
     setChartDataURL  : function(url, immediate){

           return this;

         },

     

       load :  function(url, params, callback, scope){

           if(!url){return null;}

           this.connection || (this.connection = new Ext.data.Connection() );

           if(this.loadMask && this.autoMask && !this.loadMask.active ){

                this.loadMask.show({
                     msg : url.text || null
                    ,fn : arguments.callee.createDelegate(this,arguments)
                    ,fnDelay : 100
                 });
                return this.connection;
           }

           var method , dataUrl, cfg, callerScope,timeout,disableCaching ;

           if(typeof url === "object"){ // must be config object
               cfg = Ext.apply({},url);
               dataUrl = cfg.url;
               params = params || cfg.params;
               callback = callback || cfg.callback;
               callerScope = scope || cfg.scope;
               method = cfg.method || params ? 'POST': 'GET';
               disableCaching = cfg.disableCaching ;
               timeout = cfg.timeout || 30;
           } else {
               dataUrl  = url;
           }

           //resolve Function if supplied
           if(!(dataUrl = this.assert(dataUrl, null)) ){return null;}

           method = method || (params ? "POST" : "GET");
           if(method === "GET"){
               dataUrl= this.prepareURL(dataUrl, disableCaching );
           }
           var o;
           o = Ext.apply(cfg ||{}, {
               url : dataUrl,
               params:  params,
               method: method,
               success: function(response, options){
                    o.loadData = this.fireEvent('beforeload', this, this.getInterface(), response, options) !== false;
               },
               failure: function(response, options){
                    this.fireEvent('loadexception', this, this.getInterface(), response, options);
                   },
               scope: this,
               //Actual response is managed here
               callback: function(options, success, response ) {
                   o.loadData = success;
                   if(callback){
                       o.loadData = callback.call(callerScope , this, success, response, options )!== false;
                   }
                   if(success && o.loadData){
                        
                        this.setChartData(options.chartResponse || response.responseText);
                    }
                   if(this.autoMask){ this.onChartLoaded(); }

               },
               timeout: (timeout*1000),
               argument: {
                "options"   : cfg,
                "url"       : dataUrl,
                "form"      : null,
                "callback"  : callback,
                "scope"     : callerScope ,
                "params"    : params
               }
           });

           this.connection.request(o);
           return this.connection;
      },
      
      setChartData  : function(data){

          return this;
      },
       
      setMask  : function(ct) {

          chart.FlashAdapter.superclass.setMask.apply(this, arguments);

          //loadMask reserved for data loading operations only
          //see: @cfg:mediaMask for Chart object masking
          var lm=this.loadMask;
          if(lm && !lm.disabled){
              lm.el || (this.loadMask = lm = new Ext.ux.IntelliMask( this[this.mediaEl] || ct, 
                 Ext.isObject(lm) ? lm : {msg : lm}));
          }

      },

       
      doAutoLoad  : function(){
          this.load (
           typeof this.autoLoad === 'object' ?
               this.autoLoad : {url: this.autoLoad});

          this.autoLoad = null;
      },


       
       onChartRendered   :  function(){
        
             this.fireEvent('chartrender', this, this.getInterface());
             if(this.loadMask && this.autoMask){this.loadMask.hide();}
       },
       
       onChartLoaded   :  function(){
        
            this.fireEvent('chartload', this, this.getInterface());
            if(this.loadMask && this.autoMask){this.loadMask.hide();}
       },

       
       onFlashInit  :  function(id){
           chart.FlashAdapter.superclass.onFlashInit.apply(this,arguments);
           this.fireEvent.defer(1,this,['chartload',this, this.getInterface()]);
       },

       loadMask : false,

       

       getChartVersion :  function(){}

    });


    
    chart.FlashAdapter.chartOnLoad = function(DOMId){

        var c, d = Ext.get(DOMId);
        if(d && (c = d.ownerCt)){
            c.onChartLoaded.defer(1, c);
            c = d=null;
            return false;
        }
        d= null;
    };

    
    chart.FlashAdapter.chartOnRender = function(DOMId){
         
        var c, d = Ext.get(DOMId);
        
        if(d && (c = d.ownerCt)){
            c.onChartRendered.defer(1, c);
            c = d = null;
            return false;
        }
        d= null;
    };

    Ext.apply(Ext.util.Format , {
       
        xmlEncode : function(value){
            return !value ? value : String(value)
                .replace(/&/g, "&amp;")
                .replace(/>/g, "&gt;")
                .replace(/</g, "&lt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&apos;");
        },

        
        xmlDecode : function(value){
            return !value ? value : String(value)
                .replace(/&gt;/g, ">")
                .replace(/&lt;/g, "<")
                .replace(/&quot;/g, '"')
                .replace(/&amp;/g, "&")
                .replace(/&apos;/g, "'");

        }

    });

})();


(function(){
    Ext.namespace("Ext.ux.Chart.Fusion");

    var chart = Ext.ux.Chart;

    
    Ext.ux.Chart.Fusion.Adapter = Ext.extend( Ext.ux.Chart.FlashAdapter, {

       
       requiredVersion : 8,

        

       blankChartData : '<chart></chart>',

        
       chartData       : null,

       
       disableCaching  : false,

       
       dataURL         : null,

        
       autoLoad        : null,

       
       chartCfg       : null,


       
       autoScroll      : true,

       
       mediaCfg        : {url      : null,
                          id       : null,
                          start    : true,
                          controls : true,
                          height  : null,
                          width   : null,
                          autoSize : true,
                          autoScale : false,
                          renderOnResize:true, //Fusion required after reflow for < Fusion 3.1 (use when autoScale is false)
                          scripting : 'always',
                          cls     :'x-media x-media-swf x-chart-fusion',
                          params  : {
                              wmode     :'opaque',
                              salign      : null
                               },
                          boundExternals :
                                ['print',
                                'saveAsImage',
                                'setDataXML',
                                'setDataURL',
                                'getDataAsCSV',
                                'getXML',
                                'getChartAttribute',
                                'hasRendered',
                                'signature',
                                'exportChart'
                                ]
        },

       
       initMedia   : function(){

           this.addEvents(
            //Defined in FlashAdaper superclass
              

             

              

              'dataloaded',

             
              'dataloaderror',

              
              'nodatatodisplay',

               
              'dataxmlinvalid',
              
               
              'exported',
              
              'exportready'
            );
            //For compat with previous versions < 2.1
           this.chartCfg || (this.chartCfg = this.fusionCfg || {});

           chart.Fusion.Adapter.superclass.initMedia.call(this);

       },

       
       onBeforeMedia: function(){

         
           var mc = this.mediaCfg;
           var cCfg = this.chartCfg || (this.chartCfg = {});

           cCfg.params                = this.assert( cCfg.params,{});
           cCfg.params[this.varsName] = this.assert( cCfg.params[this.varsName],{});

           cCfg.params[this.varsName] = Ext.apply({
              chartWidth  :  '@width' ,
              chartHeight :  '@height',
              scaleMode   : mc.autoScale ? 'exactFit' : 'noScale',
              debugMode   : 0,
              DOMId       : '@id',
            registerWithJS: 1,
         allowScriptAccess: "@scripting" ,
              lang        : 'EN',
              dataXML     : this.dataURL ? null : 
                     this.assert(this.dataXML || this.chartData || this.blankChartData,null),
              dataURL     : this.dataURL ? encodeURI(this.prepareURL(this.dataURL)) : null
          }, cCfg.params[this.varsName]);
          
          
          chart.Fusion.Adapter.superclass.onBeforeMedia.call(this);

      },

      
      setChartData : function(xml, immediate){
           var o;
           this.chartData = xml;
           this.dataURL = null;
           
           if( immediate !== false && (o = this.getInterface())){

              if( 'setDataXML' in o ){
                   o.setDataXML(xml);
              } else { //FC Free Interface
                   this.setVariable("_root.dataURL","");
                   //Set the flag
                   this.setVariable("_root.isNewData","1");
                    //Set the actual data
                   this.setVariable("_root.newData",xml);
                   //Go to the required frame
                   if('TGotoLabel' in o){
                       o.TGotoLabel("/", "JavaScriptHandler");
                   }
              }
           }
           o = null;
           return this;
        },


       
       setChartDataURL  : function(url, immediate){
          var o;
          this.dataURL = url;
          if(immediate !== false && (o = this.getInterface())){
              'setDataURL' in o ?
                 o.setDataURL(url) :
                   //FusionCharts Free has no support for dynamic loading of URLs
                   this.load({url:url, nocache:this.disableCaching} );
              o=null;
          }
        },

        
       getChartVersion  :  function(){
            return '';

       }


    });

    window.FC_Rendered = window.FC_Rendered ? window.FC_Rendered.createInterceptor(chart.FlashAdapter.chartOnRender):chart.FlashAdapter.chartOnRender;
    window.FC_Loaded   = window.FC_Loaded   ? window.FC_Loaded.createInterceptor(chart.FlashAdapter.chartOnLoad):chart.FlashAdapter.chartOnLoad;


    
    var dispatchEvent = function(name, id){
        
        var c, d = Ext.get(id);
        if(d && (c = d.ownerCt)){
           c.fireEvent.apply(c, [name, c, c.getInterface()].concat(Array.prototype.slice.call(arguments,2)));
        }
        c = d =null;
    };

    //Bind Fusion callbacks to an Ext.Event for the corresponding chart.
    Ext.each(['FC_DataLoaded', 'FC_DataLoadError' ,
        'FC_NoDataToDisplay','FC_DataXMLInvalid','FC_Exported','FC_ExportReady'],

      function(fnName){
        var cb = dispatchEvent.createDelegate(null,[fnName.toLowerCase().replace(/^FC_/i,'')],0);
        window[fnName] = typeof window[fnName] == 'function' ? window[fnName].createInterceptor(cb): cb ;

     });



    
    Ext.ux.Chart.Fusion.Component = Ext.extend(Ext.ux.Media.Flash.Component, {
        ctype : 'Ext.ux.Chart.Fusion.Component' ,
        mediaClass  : Ext.ux.Chart.Fusion.Adapter
        });

    Ext.reg('fusion', chart.Fusion.Component);
    
    Ext.ux.Chart.Fusion.Panel = Ext.extend(Ext.ux.Media.Flash.Panel, {
        ctype : 'Ext.ux.Chart.Fusion.Panel',
        mediaClass  : Ext.ux.Chart.Fusion.Adapter
        });

    Ext.reg('fusionpanel', chart.Fusion.Panel);

    
    Ext.ux.Chart.Fusion.Portlet = Ext.extend(Ext.ux.Media.Flash.Panel, {
        anchor      : '100%',
        frame       : true,
        collapseEl  : 'bwrap',
        collapsible : true,
        draggable   : true,
        cls         : 'x-portlet x-chart-portlet',
        ctype       : 'Ext.ux.Chart.Fusion.Portlet',
        mediaClass  : Ext.ux.Chart.Fusion.Adapter
    });

    Ext.reg('fusionportlet', chart.Fusion.Portlet);

    

    Ext.ux.Chart.Fusion.Window = Ext.extend(Ext.ux.Media.Flash.Window, {
        ctype : "Ext.ux.Chart.Fusion.Window",
        mediaClass  : chart.Fusion.Adapter
        });

    Ext.reg('fusionwindow', Ext.ux.Chart.Fusion.Window);
})();

if (Ext.provide) { Ext.provide('uxfusion');}
