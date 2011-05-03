/* global Ext */
/**
 * @class Ext.ux.Chart.OFC
 * @version 1.2
 * @author  Doug Hendricks. doug[always-At]theactivegroup.com
 * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
 */
 /************************************************************************************
 *   This file is distributed on an AS IS BASIS WITHOUT ANY WARRANTY;
 *   without even the implied warranty of MERCHANTABILITY or
 *   FITNESS FOR A PARTICULAR PURPOSE.
 ************************************************************************************

 License: ux.Chart.OFC is licensed under the terms of the Open Source GPL 3.0 license.

     This program is free software for non-commercial use:
     you can redistribute it and/or modify
     it under the terms of the GNU General Public License as published by
     the Free Software Foundation, either version 3 of the License, or
     any later version.

     This program is distributed in the hope that it will be useful,
     but WITHOUT ANY WARRANTY; without even the implied warranty of
     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     GNU General Public License for more details.

     You should have received a copy of the GNU General Public License
     along with this program.  If not, see < http://www.gnu.org/licenses/gpl.html>.

   Donations are welcomed: http://donate.theactivegroup.com
   Commercial use is prohibited without a Commercial License. See http://licensing.theactivegroup.com.


 Version:  1.2  10/25/2009
         Add: Implement setChartDataURL (via new reload method)
         Add: chartresize event. 
 
 Version:  1.1  10/14/2008
         Add: saveAsImage method since latest OFC2 beta now supports it.
         Add: imagesaved Event.
         Fixes: Corrected ofcCfg options merge for params and flashVars

 Component Config Options:

   chartUrl    : the URL to open_flash_chart.swf
   dataUrl     : the URL of a remote chart data resource (loaded by the chart object itself)
   dataFn      : the name of an accessible function which return the initial chart series as a JSON string.
   autoLoad    : Use Ext.Ajax to remote load a JSON chart series
   chartData   : (optional object/JSON string/Function) Chart data series to load when initially rendered.  May be an object, JSONString, or Function that returns either.
   ofcCfg  : {  //optional
            id    : String   id of <object> tag
            style : Obj  optional DomHelper style object

        }

 This class inherits from (thus requires):
  ux.Media(uxmedia.js) and
  ux.Media.Flash (uxflash.js),
  uxchart.js

  files and classes.

 */


(function(){
    Ext.namespace("Ext.ux.Chart.OFC");

    var chart = Ext.ux.Chart;
    /**
     * @class Ext.ux.Chart.OFC.Adapter
     * @extends Ext.ux.Chart.FlashAdapter
     * @version 1.2
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     */

    var adapter = Ext.ux.Chart.OFC.Adapter = Ext.extend( Ext.ux.Chart.FlashAdapter , {

       /**
        * @cfg {String|Float} requiredVersion The required Flash version necessary to support the Chart object.
        * @default "9"
        */
       requiredVersion : 9,

       /**
       * Chart configuration options may be overriden by supplying alternate values only as necessary.
       * <br />See {@link Ext.ux.Media.Flash} for additional config options.
       * @cfg {Object} chartCfg/fusionCfg Flash configuration options.
       * @memberof Ext.ux.Chart.OFC.Adapter
       * @example chartCfg  : {
             id    : {String}  //id of &lt;object&gt; tag (auto-generated if not specified)
             name      : '@id', //set automatically
             style : {Object}  //optional DomHelper style object
             controls  : true,
             height    : '@height',
             width     : '@width',
             autoSize  : false,
             renderOnResize:false,  //force re-render when the ux.Chart.Component is resized
             scripting : 'always',
             params: {
               allowscriptaccess : '@scripting',
               flashVars : {
                   id          : DOM Id of SWF object (macro '@id')
                   get-data    : {String} Function name to call to gather initial chart series data (.dataFn)
                   data-file   : A Url to initially load a chart series (.dataURL),
                   loading     : Custom Loading Message
               }
           }
          }
        */

       chartCfg  : null,

       /**
        * @cfg {String} dataFn The named function for the chart object to invoke to retrieve its initial chart series data.
        * This function must return a compatible JSON string.  If defined this method supercedes the class default data retrieval
        * autoLoad mechamism.
        * @optional
        * @example 'MyApp.getMyChartData'
        *
        */
       dataFn : null,

       /**
        * @cfg {Mixed} blankChartData The default data value used to render an empty/blank chart.
        * @default null
        */

       blankChartData : { "elements": []},

       /** @private */
       mediaCfg        : {url       : null,
                          id        : null,
                          start     : true,
                          controls  : true,
                          name      :'@id',
                          height    : '@height',
                          width     : '@width',
                          autoSize  : false,
                          start     : false,
                          renderOnResize:false,
                          scripting : 'always',
                          cls       :'x-media x-media-swf x-chart-ofc',
                          params    : {
                             allowscriptaccess : '@scripting',
                             flashVars : {
                                 'get-data'  : null,  //function name to call for initial data
                                 'data-file' : null,  //URL for initial data
                                 id: '@id'
                             }
                          },

                          //Auto ExternalInterface Bindings (Flash v8 or higher)
                          boundExternals : ['post_image',    //from OFC2 beta 2.2 Hyperion?
                                            'get_img_binary', //new for OFC2 beta 2.2 : returns PNG image as a base64:String
                                            'get_version',
                                            'load',
                                            'reload'
                                            ]

        },

        /** @private */
       initMedia  : function(){

           this.addEvents(

             /**
              * Fires when the image_saved callback is return by the OFC component
              * @event imagesaved
              * @param {Ext.ux.Chart.OFC} this Chart Component
              * @param {object} chart the underlying chart component DOM reference
              */
              'imagesaved',
             /**
              * Fires when the image_saved callback is return by the OFC component
              * @event chartresize
              * @param {Ext.ux.Chart.OFC} this Chart Component
              * @param {object} chart the underlying chart component DOM reference
              */
              'chartresize'

            );

           //For compat with previous versions < 2.1
           this.chartCfg || (this.chartCfg = this.ofcCfg);


           /*
            * Custom autoLoad handling for OFC
            * Must wait for its 'open_flash_chart_data' callBack, indicating its ready
            * to accept new Data
            */
           this._autoLoad = this.dataFn ? null : this.autoLoad;
           delete this.autoLoad;

           adapter.superclass.initMedia.call(this);

       },

        /** @private */
       //called just prior to rendering the media
       onBeforeMedia: function(){

         /* assemble a compatible mediaCfg for use with the defined Chart SWF variables */
           var mc = this.mediaCfg;
           var cCfg = this.chartCfg || (this.chartCfg = {});
           cCfg.params                = this.assert( cCfg.params,{});
           cCfg.params[this.varsName] = this.assert( cCfg.params[this.varsName],{});

           cCfg.params[this.varsName] = Ext.apply({
                'data-file' : this.dataURL ? this.prepareURL(this.dataURL || null) : null,
                'get-data'  : this.dataFn ? String(this.dataFn) : null,
                allowResize : !!this.resizable,
                loading     : (this.loadMask || {}).msg || null 
               }, cCfg.params[this.varsName] );

           adapter.superclass.onBeforeMedia.call(this);

       },
       /**
       * @private
       * @cfg {String} setDataMethod The method name to use to set the charts current data series.
       */
       setDataMethod : 'loadData',


       /**
        *
        * @param {JSONString/Object/Function} data The data (or Function that returns the data) to apply to the chart immediately.
        * @return {ux.Chart.OFC} this
        */
       setChartData: function(data){
           var o, j;
           j = this.assert(data ,null);  //Value/Function assertion
           if(j && (o = this.getInterface()) && typeof o.load != 'undefined'){
                  if(this.loadMask && this.autoMask && !this.loadMask.active ){
                       this.loadMask.show();
                  }
                  j = this.chartData = (typeof j == 'object'? Ext.encode(j) : j);
                  o.load(j);
                  //OFC2 does not raise the ofc_ready callback for a load method,
                  //so we will.
                  this.onChartLoaded();

           }
           return this;
       },

       /**
       * <strong>Not implemented by all versions of OFC2 </strong><p>
       * Set/update the current chart with a new URL returning a data series.
       * @param {String} url The URL of the stream to update with (null to reload the last-known dataURL).
       * @param {Boolean} immediate false to defer rendering the new data until the next chart rendering.
       * @default true
       * @return this
       */
       setChartDataURL  : function(url, immediate){
        
         var o;
         if((o = this.getInterface()) && typeof o.reload != 'undefined'){
              url && (this.dataURL = url);
              if(immediate === false)return this;
              if(this.loadMask && this.autoMask && !this.loadMask.active ){
                  this.loadMask.show();
              }
              o.reload(this.prepareURL(this.dataURL));
         }
         return this;
        },

       /**
       * When initially rendered, the OFC Flash object will invoke the 'window.open_flash_chart_data' method
       * in an effort to render an initial chart series of choice.
       * ux.Chart.OFC proxies this method when called.<p>You can use this method in several ways.
       * <ul><li>If the class {@link #chartData} property contains a value, it is returned.</li><li>Otherwise, autoLoad is initiated if defined.</li>
       * <li>Or, redefine this method of your chart instance to return the desired initial data series.</li></ul>
       * @return {JSONString} Return a JSON string used to <b>initially</b> render the chart. <p>If a value is not available, the value of {@link #blankChartData} is returned.
       */

       onDataRequest : function() {

           var json = this.assert(this.chartData ,this.assert(this.blankChartData,null) );

           if(!this.chartData && this._autoLoad){
               this.doAutoLoad();
               this._autoLoad = null;
           }

           return json && typeof json == 'object'? Ext.encode(json) : json;

        },

      /** @private */
      doAutoLoad  : function(){
          this.load (
           typeof this._autoLoad === 'object' ?
               this._autoLoad : {url: this._autoLoad});
      },

      loadMask : false,

      /**
       * Open Flash Chart 2 has an external interface method that you can call to make it save an image.
       * @param {String} url The URL of the upload PHP script Example: http://example.com/php-ofc-library/ofc_upload_image.php?name=my_chart.jpg
       * @param {Boolean} debug (optional) If debug is true the browser will open a new window showing the results (and any echo/print statements) but, the imagesaved event is NOT raised.
       *  If it is false, no redirect happens and the imagesaved event is raised.
       *  <p>This feature requires a serverside script (included in the OCF2 Chart Distribution: ofc_upload_image.php<p>
       *  For a Tutorial on this feature, @see http://teethgrinder.co.uk/open-flash-chart-2/adv-upload-image.php
       */

       //OFC2 beta 2 has changed the saveAsImage process, final details are pending, but earlier beta
       //releases are still supported here (but, likely subject to CHANGE )
      saveAsImage : function(url, debug ){
        var o;
        if(url && (o = this.getInterface()) ){
            var method = this.chart.post_image || o.post_image;

            if(method !== undefined){
               method(url, 'Ext.ux.Chart.OFC.Adapter._saveImageCallback(\''+this.id+'\')', debug || false);
            }
            return this;
        }
      },

      /**
       * Open Flash Chart 2 has an external interface method that you can call to to return a base64 encoded stream of the current chart.
       * @return {base64:String} The encoded PNG image stream suitable for browsers that support data URLs.
       */
      getBinaryImage  : function(){
         var o;
        if(o = this.getInterface()){
            if(o.get_img_binary !== undefined){
               return o.get_img_binary();
            }
        }

      },

      /**
       * Returns the release number of the Chart object.
       * @return {string}
       */
      getChartVersion  :  function(){
          var ns = this[this.externalsNamespace] || this;
          ns = typeof ns.get_version != 'undefined' ? ns : this.getInterface();

          return (ns && typeof ns.get_version != 'undefined') ? ns.get_version() : '';

      },
      /**
       * <strong>Not implemented by all versions of OFC2 </strong><p>
       * Reload the chart with the lastknown dataURL
       * @return this
       */
      reload : Ext.emptyFn

    });

    adapter.prototype.reload = adapter.prototype.setChartDataURL;
    
    /**
     * @class Ext.ux.Chart.OFC.Component
     * @extends Ext.ux.Chart.OFC.Adapter
     * @version 2.1
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     * @base Ext.ux.Media.Flash.Component
     */
    Ext.ux.Chart.OFC.Component = Ext.extend(Ext.ux.Media.Flash.Component, {
        ctype : 'Ext.ux.Chart.OFC',
        mediaClass  : adapter
        });

    Ext.reg('openchart', chart.OFC.Component);
    /**
     * @class Ext.ux.Chart.OFC.Panel
     * @extends Ext.ux.Chart.OFC.Adapter
     * @version 1.2
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     * @base Ext.ux.Media.Flash.Panel
     */
    Ext.ux.Chart.OFC.Panel = Ext.extend(Ext.ux.Media.Flash.Panel, {
        ctype : 'Ext.ux.Chart.OFC.Panel',
        mediaClass  : adapter
        });

    Ext.reg('openchartpanel', chart.OFC.Panel);
    /**
     * @class Ext.ux.Chart.OFC.Portlet
     * @extends Ext.ux.Chart.OFC.Adapter
     * @version 1.2
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     * @base Ext.ux.Media.Flash.Panel
     */

    Ext.ux.Chart.OFC.Portlet = Ext.extend(Ext.ux.Media.Flash.Panel, {
        anchor      : '100%',
        frame       : true,
        collapseEl  : 'bwrap',
        collapsible : true,
        draggable   : true,
        cls         : 'x-portlet x-chart-portlet',
        mediaClass  : adapter
    });

    Ext.reg('openchartportlet', chart.OFC.Portlet);

    /**
     * @class Ext.ux.Chart.OFC.Window
     * @extends Ext.ux.Media.Flash.Window
     * @version 1.0
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     * @base Ext.ux.Chart.OFC.Adapter
     */

    Ext.ux.Chart.OFC.Window = Ext.extend(Ext.ux.Media.Flash.Window, {
        ctype : "Ext.ux.Chart.OFC.Window",
        mediaClass  : adapter
        });

    Ext.reg('openchartwindow', chart.OFC.Window);
     
    /* Class Proxy Methods */
    Ext.apply(adapter,{

        /** @private  Class method callbacks */
        chartDataRequest : function(DOMId){
            var c, d = Ext.get(DOMId);
            if(d && (c = d.ownerCt)){
                return c.onDataRequest?c.onDataRequest() :c.assert(c.blankChartData,null);
            }
            d= null;
        },

        /** @private
         * Class Method
         * Saved Image Callback handler
         */
        _saveImageCallback : function(ofcComp){
              var c;
              if(c = Ext.getCmp(ofcComp)){
                 //return to Flash asap to expose any callback errors.
                 c.fireEvent.defer(1,c,['imagesaved', c, c.getInterface()]);
              }
          },
         
         /** @private
          * Class Method
          * chart-resize Callback handler
          */
          
        onChartResize : function(left, width, top, height, DOMId){
            var args = Ext.isArray(left) ? args = left : Array.prototype.slice.call(arguments,0);
            var c, d = Ext.get(args[4] || DOMId);
            if(d && (c = d.ownerCt)){
                 c.fireEvent.defer(1,c,['chartresize', c, c.getInterface(), {top:args[2], left:args[0], height:args[3], width:args[1]}]);
            }
            d= null;
          }

        });

        window.ofc_ready = window.ofc_ready ?
                window.ofc_ready.createInterceptor(chart.FlashAdapter.chartOnLoad )
               :chart.FlashAdapter.chartOnLoad;
               
        window.ofc_resize = window.ofc_resize ?
                window.ofc_resize.createInterceptor(adapter.onChartResize )
               :adapter.onChartResize;
               
        window.open_flash_chart_data = window.open_flash_chart_data ?
                window.open_flash_chart_data.createInterceptor(adapter.chartDataRequest )
           :adapter.chartDataRequest;


})();

if (Ext.provide) {
    Ext.provide('uxofc');
}