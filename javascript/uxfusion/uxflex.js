/* global Ext */
/* ux.Media.Flex
 * version  1.0 RC1.02
 * @author Doug Hendricks. doug[always-At]theactivegroup.com
 * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
 *
 ************************************************************************************
 *   This file is distributed on an AS IS BASIS WITHOUT ANY WARRANTY;
 *   without even the implied warranty of MERCHANTABILITY or
 *   FITNESS FOR A PARTICULAR PURPOSE.
 ************************************************************************************

 License: ux.Media.Flex class is licensed under the terms of
 the Open Source GPL 3.0 license (details: http://www.gnu.org/licenses/gpl.html).

 Commercial use is prohibited without a Commercial License. See http://licensing.theactivegroup.com.

 Donations are welcomed: http://donate.theactivegroup.com

 Notes: the <embed> tag is NOT used(or necessary) in this implementation

 Version:
        1.0 RC1.02

 Ext Component Implementation of the FAbridge (Flex/ActionScript -> Javascript bridge)
 FABridge.js is NOT required.

    mediaCfg: {Object}
         {
           url       : Url resource to load when rendered
          ,loop      : (true/false)
          ,start     : (true/false)
          ,height    : (defaults 100%)
          ,width     : (defaults 100%)
          ,scripting : (true/false) (@macro enabled)
          ,controls  : optional: show plugins control menu (true/false)
          ,eventSynch: (Bool) If true, this class initializes an internal event Handler for
                       ActionScript event synchronization
          ,listeners  : {"mouseover": function() {}, .... } DOM listeners to set on the media object each time the Media is rendered.
          ,requiredVersion: (String,Array,Number) If specified, used in version detection.
          ,unsupportedText: (String,DomHelper cfg) Text to render if plugin is not installed/available.
          ,installUrl:(string) Url to inline SWFInstaller, if specified activates inline Express Install.
          ,installRedirect : (string) optional post install redirect
          ,installDescriptor: (Object) optional Install descriptor config
         }
    */

(function(){

   var ux = Ext.ux.Media;
    /**
     *
     * @class Ext.ux.Media.Flex
     * @extends Ext.ux.Media.Flash
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @constructor
     * @version 1.0 RC1
     * @desc
     * Media Class for Flex objects. Used for rendering Flash Objects for use with inline markup.
     */

    Ext.ux.Media.Flex = Ext.extend( Ext.ux.Media.Flash , {

        /** @private
         *  (called once by the constructor)
         */
        initMedia : function(){

            ux.Flex.superclass.initMedia.call(this);
            this.addEvents(
            /**
              * Fires when the FlexActionscript Bridge reports an initialized state via a public callback function.
              * @event flexinit
              * @memberOf Ext.ux.Media.Flex
              * @param {Ext.ux.Media.Flex} this Ext.ux.Media.Flex instance
              */
            'flexinit'
            );
        },

        /** @private */
        getMediaType: function(){
             var mt = Ext.apply({},{
                 cls      : 'x-media x-media-flex'
             }, this.mediaType);

             mt.params[this.varsName] || (mt.params[this.varsName]={});
             Ext.apply(mt.params[this.varsName],{
                bridgeName: '@id'   //default to the ID of the SWF object.
             });
             return mt;
        },

        /**
         * Returns a reference to the FABridge implementation
         * @return {Object} Flex Root
         */
        getBridge : function(){
            return this.mediaObject ? this.mediaObject.getRoot() : null;
        },
        //setVariable : Ext.emptyFn,
        //getVariable : Ext.emptyFn,
        //bindExternals : Ext.emptyFn,

        /** @private */
        onFlexInit : function(){
           var M;
           if(M = this.mediaObject){
                if(this.mediaMask && this.autoMask){this.mediaMask.hide();}
                this.fireEvent('flexinit',this);
           }
        }
    });

    /**
     * Class members
     * @memberOf Ext.ux.Media.Flex
     */
    Ext.apply(ux.Flex, {
        onFlexBridge : function(bridgeId){
            //console.log(arguments);
            var c, d = Ext.get(Ext.isArray(bridgeId) ? bridgeId[0]: bridgeId);
            if(d && (c = d.ownerCt)){
                c.onFlexInit && c.onFlexInit();
                c = d = null;
                //BridgeID was resolved by ux.Media.Flex so stop the interceptor
                return true;
            }
            d= null;
            return false;
        },

        extractBridgeFromID : function(id) {
            return ux.Flex.idMap[(id >> 16)];
        },
         /**
         * @memberOf Ext.ux.Media.Flex
         * @static
         */
        TYPE_ASINSTANCE : 1,
        /**
         * @memberOf Ext.ux.Media.Flex
         * @static
         */

        TYPE_ASFUNCTION : 2,
        /**
         * @memberOf Ext.ux.Media.Flex
         * @static
         */
        TYPE_JSFUNCTION : 3,
        /**
         * @memberOf Ext.ux.Media.Flex
         * @static
         */
        TYPE_ANONYMOUS  : 4,

        nextBridgeID : 0,
        idMap        : {},
        nextLocalFuncID : 0,
        argsToArray : function(args) {
            var result = [];
            for(var i=0;i<args.length;i++) {
                result[i] = args[i];
            }
            return result;
        },
        blockedMethods : {
            toString: true,
            get: true,
            set: true,
            call: true
        },

        refCount : 0,  //recursive call counter

        RECURSION_ERROR: "You are trying to call recursively into the Flash Player which is not allowed. In most cases the JavaScript setTimeout function, can be used as a workaround."
    });

    window.FABridge__bridgeInitialized =
      //typeof (window.FABridge__bridgeInitialized) === 'function' ?
      //  window.FABridge__bridgeInitialized.createInterceptor(ux.Flex.onFlexBridge):
            ux.Flex.onFlexBridge;

    window.FABridge__invokeJSFunction = function(args){

            var funcID = args[0];
            var callArgs = args.concat();
            callArgs.shift();
            var bridge = ux.Flex.extractBridgeFromID(funcID);

            return bridge ? bridge.invokeLocalFunction(funcID,callArgs) : undefined;
        };

     /**
      *
      * @class Ext.ux.Media.Flex.Component
      * @extends Ext.ux.Media.Flash.Component
      * @base Ext.ux.Media.Flex
      * @version 1.0 RC1.01
      * @author Doug Hendricks. doug[always-At]theactivegroup.com
      * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
      * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
      * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
      * @constructor
      * @param {Object} config The config object
      * @desc
      * Base Media Class for Flex objects
      * Used primarily for rendering Flash Objects for use with inline markup.
    */
   Ext.ux.Media.Flex.Component = Ext.extend(Ext.ux.Media.Flash.Component, {
         /**
         * @private
         */
         ctype         : "Ext.ux.Media.Flex.Component",

        /**
         * @private
         */
         cls    : "x-media-flex-comp",

        /**
         * @private
         * The className of the Media interface to inherit
         */
         mediaClass    : Ext.ux.Media.Flex

   });

   Ext.reg('uxflex', Ext.ux.Media.Flex.Component);

   /**
     *
     * @class Ext.ux.Media.Flex.Panel
     * @extends Ext.ux.Media.Flash.Panel
     * @version 1.0 RC1.01
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @constructor
     * @base Ext.ux.Media.Flex
     * @param {Object} config The config object
     * @desc
     * Base Media Class for Flash objects
     * Used primarily for rendering Flash Objects for use with inline markup.
    */

   Ext.ux.Media.Flex.Panel = Ext.extend(Ext.ux.Media.Flash.Panel,{

        ctype         : "Ext.ux.Media.Flex.Panel",
        /**
         * @private
         */
        cls           : "x-media-flex-panel",
        mediaClass    : Ext.ux.Media.Flex

   });

   Ext.reg('flexpanel', ux.Flex.Panel);
   Ext.reg('uxflashpanel', ux.Flex.Panel);

   /**
    *
    * @class Ext.ux.Media.Flex.Portlet
    * @extends Ext.ux.Media.Flash.Portlet
    * @version  1.0 RC1
    * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
    * @author Doug Hendricks. doug[always-At]theactivegroup.com
    * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
    * @desc
    * Base Media Class for Flex objects
    * Used primarily for rendering Flash Objects for use with inline markup.
    */

   Ext.ux.Media.Flex.Portlet = Ext.extend(Ext.ux.Media.Flash.Portlet,{
       ctype        : "Ext.ux.Media.Flash.Portlet",
       cls          : 'x-portlet x-media-flex-portlet',
       mediaClass    : Ext.ux.Media.Flex

   });

   Ext.reg('flexportlet', ux.Flex.Portlet);
   Ext.reg('uxflexportlet', ux.Flex.Portlet);

   /**
    *
    * @class Ext.ux.Media.Flex.Window
    * @extends Ext.ux.Media.Flash.Window
    * @version  RC1.1
    * @author Doug Hendricks. doug[always-At]theactivegroup.com
    * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
    * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
    * @constructor
    * @base Ext.ux.Media.Flex
    * @param {Object} config The config object
    * @desc
    * Base Media Class for Flex objects
    * Used primarily for rendering Flash Objects for use with inline markup.
    */

   Ext.ux.Media.Flex.Window  = Ext.extend( Ext.ux.Media.Flash.Window , {

        ctype         : 'Ext.ux.Media.Flex.Window',
        cls           : 'x-media-flex-window',
        mediaClass    : Ext.ux.Media.Flex

   });

   Ext.reg('flexwindow', ux.Flex.Window);

   /*
    * FABridge Bindings are maintained on the Flex.Element
    */
   Ext.ux.Media.Flex.Element = Ext.extend ( Ext.ux.Media.Flash.Element , {

        constructor : function(){
            Ext.apply(this,{
                remoteTypeCache : {},
                remoteInstanceCache : {},
                remoteFunctionCache : {},
                localFunctionCache : {},
                nextLocalFuncID : 0,
                bridgeID : ux.Flex.nextBridgeID++
            });
            ux.Flex.idMap[this.bridgeID] = this;
            ux.Flex.Element.superclass.constructor.apply(this, arguments);
        },


        /**
         * accessor for retrieving a proxy to the root object
         */
        getRoot : function(){
            return this.dom.getRoot ? this.deserialize(this.dom.getRoot()): undefined;
        },
        /**
         * release all AS Objects from the local cache maps
         */
        releaseASObjects: function(){
            return this.dom.releaseASObjects ? this.dom.releaseASObjects() : null;
        },

        /**
         * release a specific object, identified by its ID
         */
        releaseNamedASObject: function(object){
            return this.dom.releaseNamedASObject && object && object.id
              ? this.dom.releaseNamedASObject(object.id) : false;
        },

        /**
         * create a new AS class instance.
         */
        createObject: function(className){
            return this.dom.create ? this.deserialize(this.dom.create(className)): null;
        },

        /**
         * Increment the reference count of the AS Object.
         */
        addRef: function(objRef){
            return this.dom.incRef ? this.dom.incRef(objRef.id): null;
        },

        /**
         * Decrement the reference count of the AS Object.
         */
        release: function(objRef){
            return this.dom.releaseRef ? this.dom.releaseRef(objRef.id): null;
        },
        /*------------------------------------------------------------------------------------
        // low level access to the flash object
        /*----------------------------------------------------------------------------------*/

        /**
         * fetch a named property off the instanced associated with objRef
         */
        getPropertyFromAS: function(objRef,propName)
        {
            if(!!ux.Flex.refCount){

                throw new Error(ux.Flex.RECURSION_ERROR);
            }
            ux.Flex.refCount++;
            var result = this.handleError(this.dom.getPropFromAS(objRef,propName));
            ux.Flex.refCount--;
            return result;
        },

        /**
         * set a named property on the instance associated with objRef
         */
        setPropertyInAS: function(objRef,propName,value){
            if(!!ux.Flex.refCount){

                throw new Error(ux.Flex.RECURSION_ERROR);
            }
            ux.Flex.refCount++;
            var result = this.handleError(this.dom.setPropInAS(objRef,propName,this.serialize(value)));
            ux.Flex.refCount--;
            return result;
        },

        callASFunction: function(funcID, args){
            if(!!ux.Flex.refCount){
                throw new Error(ux.Flex.RECURSION_ERROR);
            }
            ux.Flex.refCount++;
            var result = this.handleError(this.dom.invokeASFunction(funcID,this.serialize(args)));
            ux.Flex.refCount--;
            return result;
        },

        callASMethod: function(objID, funcName, args){

            if(!!ux.Flex.refCount){
                throw new Error(ux.Flex.RECURSION_ERROR);
            }
            ux.Flex.refCount++;
            var result = this.handleError(this.dom.invokeASMethod(objID,funcName, this.serialize(args)));
            ux.Flex.refCount--;
            return result;
        },

        makeID: function(token){
            return (this.bridgeID << 16) + token;
        },

        // check the given value for the components of the hard-coded error code : __FLASHERROR
        // used to marshall NPE's into flash

        handleError: function(value){
             if (typeof(value)=="string" && value.indexOf("__FLASHERROR")==0){
                 var errorMessage = value.split("||");
                 !!ux.Flex.refCount && ux.Flex.refCount--;
                 throw new Error(errorMessage[1]||'FlashError');
             }
             return value;
       },

    /*------------------------------------------------------------------------------------
    // responders to remote calls from flash
    /*----------------------------------------------------------------------------------*/

        invokeLocalFunction: function(funcID,args){
            var func;
            return (func = this.localFunctionCache[funcID])?
                this.serialize(func.apply(null,this.deserialize(args))) : undefined;

        },

        /*------------------------------------------------------------------------------------
        // Object Types and Proxies
        /*----------------------------------------------------------------------------------*/

        // accepts an object reference, returns a type object matching the obj reference.
        getTypeFromName: function(objTypeName){
            return this.remoteTypeCache[objTypeName];
        },

        createProxy: function(objID,typeName){
            var objType = this.getTypeFromName(typeName);
            instanceFactory.prototype = objType;
            return this.remoteInstanceCache[objID] = new instanceFactory(objID);

        },

        getProxy: function(objID) {
            return this.remoteInstanceCache[objID];
        },

        // accepts a type structure, returns a constructed type
        addTypeDataToCache: function(typeData){
            var newType = new ASProxy(this,typeData.name);

            var accessors = typeData.accessors,
              i, L = accessors.length;
            for(i=0;i<L;i++) {
                this.addPropertyToType(newType,accessors[i]);
            }

            var methods = typeData.methods;
            L = methods.length;
            for(i=0;i<L;i++) {
                ux.Flex.blockedMethods[methods[i]] ||
                    this.addMethodToType(newType,methods[i]);
            }
            return this.remoteTypeCache[newType.typeName] = newType;
        },

        /**
         * //add a property to a typename; used to define the properties that can be called on an AS proxied object
         */
        addPropertyToType: function(ty,propName){

            var c = propName.charAt(0);
            var setterName;
            var getterName;
            if(c >= "a" && c <= "z")
            {
                getterName = "get" + c.toUpperCase() + propName.substr(1);
                setterName = "set" + c.toUpperCase() + propName.substr(1);
            }
            else
            {
                getterName = "get" + propName;
                setterName = "set" + propName;
            }
            ty[setterName] = function(val) {
                this.bridge.setPropertyInAS(this.id,propName,val);
            };
            //Maintain get accessor compat with older FABRidge implementations
            ty[propName] = ty[getterName] = function(){
                return this.bridge.deserialize(this.bridge.getPropertyFromAS(this.id, propName));
            };

        },

        addMethodToType: function(ty,methodName){
            ty[methodName] = function() {
                return this.bridge.deserialize(
                    this.bridge.callASMethod(this.id,methodName,ux.Flex.argsToArray(arguments))
                    );
            }
        },

        /*------------------------------------------------------------------------------------
        // Function Proxies
        /*----------------------------------------------------------------------------------*/

        getFunctionProxy: function(funcID)
        {
            var bridge = this;
            if(this.remoteFunctionCache[funcID] == null) {
                this.remoteFunctionCache[funcID] = function() {
                    bridge.callASFunction(funcID,ux.Flex.argsToArray(arguments));
                }
            }
            return this.remoteFunctionCache[funcID];
        },

        getFunctionID: function(func)
        {
            if(func.__bridge_id__ == undefined) {
                func.__bridge_id__ = this.makeID(this.nextLocalFuncID++);
                this.localFunctionCache[func.__bridge_id__] = func;
            }
            return func.__bridge_id__;
        },

        /*------------------------------------------------------------------------------------
        // serialization / deserialization
        /*----------------------------------------------------------------------------------*/

        serialize: function(value)
        {
            var result = {};
            var t = typeof(value);
            if(t == "number" || t == "string" || t == "boolean" || t == null || t == undefined) {
                result = value;
            }
            else if(Ext.isArray(value)){
                result = [];
                var L = value.length;
                for(var i=0;i<L;i++) {
                    result[i] = this.serialize(value[i]);
                }
            }
            else if(t == "function")
            {
                result.type = ux.Flex.TYPE_JSFUNCTION;
                result.value = this.getFunctionID(value);
            }
            else if (value instanceof ASProxy)
            {
                result.type = ux.Flex.TYPE_ASINSTANCE;
                result.value = value.id;
            }
            else
            {
                result.type = ux.Flex.TYPE_ANONYMOUS;
                result.value = value;
            }

            return result;
        },

        deserialize: function(packedValue)
        {

            var result, L, t = typeof(packedValue);
            if(t == "number" || t == "string" || t == "boolean" || packedValue == null || packedValue == undefined)
            {
                result = this.handleError(packedValue);
            }
            else if (Ext.isArray(packedValue)){
                result = [];
                L = packedValue.length;
                for(var i=0;i<L;i++)
                {
                    result[i] = this.deserialize(packedValue[i]);
                }
            }
            else if (t == "object")
            {
                L = packedValue.newTypes.length;
                for(var i=0;i<L;i++) {
                    this.addTypeDataToCache(packedValue.newTypes[i]);
                }
                for(var aRefID in packedValue.newRefs) {
                    this.createProxy(aRefID,packedValue.newRefs[aRefID]);
                }
                if (packedValue.type == ux.Flex.TYPE_PRIMITIVE)
                {
                    result = packedValue.value;
                }
                else if (packedValue.type == ux.Flex.TYPE_ASFUNCTION)
                {
                    result = this.getFunctionProxy(packedValue.value);
                }
                else if (packedValue.type == ux.Flex.TYPE_ASINSTANCE)
                {
                    result = this.getProxy(packedValue.value);
                }
                else if (packedValue.type == ux.Flex.TYPE_ANONYMOUS)
                {
                    result = packedValue.value;
                }
            }
            return result;
          },

          remove  : function(){
             this.releaseASObjects();

             delete this.remoteTypeCache;
             delete this.remoteInstanceCache;
             delete this.remoteFunctionCache;
             delete this.localFunctionCache;

             delete ux.Flex.idMap[this.bridgeID];
             ux.Flex.Element.superclass.remove.apply(this, arguments);
          }

    });

    /*------------------------------------------------------------------------------------
    * Factory
    * @private
    * @static
    /*----------------------------------------------------------------------------------*/

    function instanceFactory(objID) {
        this.id = objID;
        return this;
    }

   /*------------------------------------------------------------------------------------
    * ActionScript proxy facade
    * @private
    * @static
    /*----------------------------------------------------------------------------------*/

    var ASProxy = function(bridge,typeName) {
        this.bridge = bridge;
        this.typeName = typeName;
        return this;
    };

    Ext.override(ASProxy ,{
        get: function(propName){
            return this.bridge.deserialize(this.bridge.getPropertyFromAS(this.id,propName));
        },
        set: function(propName,value){
            this.bridge.setPropertyInAS(this.id,propName,value);
        },
        call: function(funcName,args){
            this.bridge.callASMethod(this.id,funcName,args);
        },
        addRef: function() {
             this.bridge.addRef(this);
         },
        release: function() {
             this.bridge.release(this);
         }
    });

     ux.Flex.prototype.elementClass  =  Ext.ux.Media.Flex.Element;

     Ext.ux.FlexComponent  = Ext.ux.Media.Flex.Component;
     Ext.ux.FlexPanel      = Ext.ux.Media.Flex.Panel;
     Ext.ux.FlexPortlet    = Ext.ux.Media.Flex.Portlet;
     Ext.ux.FlexWindow     = Ext.ux.Media.Flex.Window;

})();

