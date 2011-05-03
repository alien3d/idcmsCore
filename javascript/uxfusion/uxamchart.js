/* global Ext */
/*

 ************************************************************************************
 *   This file is distributed on an AS IS BASIS WITHOUT ANY WARRANTY;
 *   without even the implied warranty of MERCHANTABILITY or
 *   FITNESS FOR A PARTICULAR PURPOSE.
 ************************************************************************************

     License: Ext.ux.Chart.amChart/amStock is licensed under the
     terms of : GNU Open Source GPL 3.0 license:

     This program is free software for non-commercial use: you can redistribute
     it and/or modify it under the terms of the GNU General Public License as
     published by the Free Software Foundation, either version 3 of the License, or
     any later version.

     This program is distributed in the hope that it will be useful,
     but WITHOUT ANY WARRANTY; without even the implied warranty of
     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     GNU General Public License for more details.

     You should have received a copy of the GNU General Public License
     along with this program.  If not, see < http://www.gnu.org/licenses/gpl.html>.

   Donations are welcomed: http://donate.theactivegroup.com

   Commercial use is prohibited without a Commercial License.
   See http://licensing.theactivegroup.com for more details on Commercial Licensing.


 This class inherits from (thus requires) the :
     ux.Media(uxmedia.js),
     ux.Media.Flash (uxflash.js) ,
     ux.Chart.FlashAdapter (uxchart.js)
     classes

*/
(function(){
    Ext.namespace("Ext.ux.Chart.amChart");

    var chart = Ext.ux.Chart;
    /**
     * @class Ext.ux.Chart.amChart.Adapter
     * @extends Ext.ux.Chart.FlashAdapter
     * @version 2.1
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @abstract
     * @description Abstract class with support for amChart 1.6.0.0
     */
    Ext.ux.Chart.amChart.Adapter = Ext.extend( Ext.ux.Chart.FlashAdapter, {

       /**
        * @cfg {String|Float} requiredVersion The required Flash version necessary to support this Chart object.
        * @default "8"
        */
       requiredVersion : 8,

        /**
         * @cfg {String} settingsURL The URL of the related chart settings XML file.
         *
         */
       settingsURL     : null,

        /**
           * @cfg {String} chartURL Url of the Flash Chart object.
         */

        chartURL : null,


      /**
       * @cfg {Object/JSONstring/Function} chartData Chart data series to load when initially rendered. <p> May be an object, JSONString, or Function that returns either.
       */
        chartData  : null,

      /**
       * @cfg {String} dataURL Url of the chart series to load when initially rendered.
       */

        dataURL  : null,


       /** @private */
       initMedia   : function(){


           this.addEvents(

               /**
                * Fires when you request data from a chart by calling the getData() function.
                * @event returndata
                * @param {Ext.ux.Chart} chart this Chart Component
                * @param {Element} chartObject the underlying chart component DOM reference
                * @param {Mixed} data The data
                */

               'returndata',

              /**
               * Fires when you request settings from a chart by calling the getSettings() function.
               * @event returnsettings
               * @param {Ext.ux.Chart} chart this Chart Component
               * @param {Element} chartObject the underlying chart component DOM reference
               * @param {Mixed} settings The settings
               */
               'returnsettings',

               /**
                 * Fires when the underlying chart component has exported the chart as an image, the chart passes image data to this event.
                 * @event returnimagedata
                 * @param {Ext.ux.Chart} chart this Chart Component
                 * @param {Element} chartObject the underlying chart component DOM reference
                 * @param {Mixed} imageData The raw serialized image data.
                 */
               'returnimagedata',

                /**
                 * Fires when you request data from a chart by calling the getParam() function.
                 * @event returnparam
                 * @param {Ext.ux.Chart} chart this Chart Component
                 * @param {Element} chartObject the underlying chart component DOM reference
                 * @param {Mixed} value The param value
                 */
               'returnparam',

                /**
                 * Fires when the Flash object reports an Error condition.
                 * @event error
                 * @param {Ext.ux.Chart} chart this Chart Component
                 * @param {Element} chartObject the underlying chart component DOM reference
                 * @param {Mixed} error The Error.
                 */

               'error',

               /**
                 * Fires when the chart finishes doing some task triggered by another JavaScript function.
                 * @event processcompleted
                 * @param {Ext.ux.Chart} chart this Chart Component
                 * @param {Element} chartObject the underlying chart component DOM reference
                 * @param {String} process_name The name of the reporting process.
                 */

               'processcompleted',

               /**
                * Fires when the user clicks on a bullet.
                * @event clickedonbullet
                * @param {Ext.ux.Chart} chart this Chart Component
                * @param {Element} chartObject the underlying chart component DOM reference
                * @param {Number} graph_index
                * @param {Mixed} value
                * @param {Number} series
                * @param {String} url
                * @param {String} description
                */

               'clickedonbullet',

               /**
               * Fires when the user rolls over a bullet.
               * @event rolledoverbullet
               * @param {Ext.ux.Chart} chart this Chart Component
               * @param {Element} chartObject the underlying chart component DOM reference
               * @param {Number} graph_index
               * @param {Mixed} value
               * @param {Number} series
               * @param {String} url
               * @param {String} description
               */

               'rolledoverbullet',

              /**
               * Fires when the viewer moves the mouse over the plot area. It returns the value of the series over which the mouse is currently hovered.
               * @event rolledoverseries
               * @param {Ext.ux.Chart} chart this Chart Component
               * @param {Element} chartObject the underlying chart component DOM reference
               * @param {Mixed} series
               */

               'rolledoverseries',

                /**
                * Fires when the viewer clicks somewhere on the plot area. It returns the value of the series over which the mouse hovered when it was clicked.
                * @event clickedonseries
                * @param {Ext.ux.Chart} chart this Chart Component
                * @param {Element} chartObject the underlying chart component DOM reference
                * @param {Mixed} series
                */

               'clickedonseries',

                 /**
                  * Fires when the viewer rolls over the slice. It the sequential number of the slice (index), the title, value, percent value, color and description.
                  * @event sliceover
                  * @param {Ext.ux.Chart} chart this Chart Component
                  * @param {Element} chartObject the underlying chart component DOM reference
                  * @param {Number} index Slice index
                  * @param {String} title
                  * @param {Number} value
                  * @param {Number} percents
                  * @param {String} color
                  * @param {String} description
                  */

               'sliceover',
                /**
                  * Fires when the viewer clicks on the slice. It the sequential number of the slice (index), the title, value, percent value, color and description.
                  * @event sliceclick
                  * @param {Ext.ux.Chart} chart this Chart Component
                  * @param {Element} chartObject the underlying chart component DOM reference
                  * @param {Number} index Slice index
                  * @param {String} title
                  * @param {Number} value
                  * @param {Number} percents
                  * @param {String} color
                  * @param {String} description
                  */
                'sliceclick',


                 /**
                  * Fires when the viewer rolls away from the slice.
                  * @event sliceout
                  * @param {Ext.ux.Chart} chart this Chart Component
                  * @param {Element} chartObject the underlying chart component DOM reference
                  */

               'sliceout',

                 /**
                  * Fires when the viewer hides the graph by clicking on the checkbox in the legend. Index is the sequential number of a graph in your settings, counting from 0.
                  * @event graphhide
                  * @param {Ext.ux.Chart} chart this Chart Component
                  * @param {Element} chartObject the underlying chart component DOM reference
                  * @param {Number} index
                  * @param {String} title
                  */

               'graphhide',

                 /**
                  * Fires when the viewer shows the graph by clicking on the checkbox in the legend. Index is the sequential number of a graph in your settings, counting from 0.
                  * @event graphshow
                  * @param {Ext.ux.Chart} chart this Chart Component
                  * @param {Element} chartObject the underlying chart component DOM reference
                  * @param {Number} index
                  * @param {String} title
                  */

               'graphshow',

                 /**
                  * Fires when the viewer selects the graph by clicking on it or on the graph's legend entry. Index is the sequential number of a graph in your settings, counting from 0.
                  * @event graphselect
                  * @param {Ext.ux.Chart} chart this Chart Component
                  * @param {Element} chartObject the underlying chart component DOM reference
                  * @param {Number} index
                  * @param {String} title
                  */

               'graphselect',

                 /**
                  * Fires when the viewer deselects the graph by clicking on it or on the graph's legend entry. Index is the sequential number of a graph in your settings, counting from 0.
                  * @event graphdeselect
                  * @param {Ext.ux.Chart} chart this Chart Component
                  * @param {Element} chartObject the underlying chart component DOM reference
                  * @param {Number} index
                  * @param {String} title
                  */

               'graphdeselect',

                 /**
                  * Fires when the selected period is changed, also when the chart is initialized.
                  * @event getzoom
                  * @param {Ext.ux.Chart} chart this Chart Component
                  * @param {Element} chartObject the underlying chart component DOM reference
                  * @param {Date} from
                  * @param {Date} to
                  */

               'getzoom'
            );

            chart.amChart.Adapter.superclass.initMedia.call(this);

       },

       /**
        * Chart configuration options may be overriden by supplying alternate values only as necessary.
        * <br />See {@link Ext.ux.Media.Flash} for additional config options.
        * @cfg {Object} chartCfg/fusionCfg Flash configuration options.
        * @example chartCfg  : {
              id    : {String}  //id of &lt;object&gt; tag (auto-generated if not specified)
              name  : {String}  //should match the id value (defaults to the 'id')
              style : {Object}  //optional DomHelper style object
              start    : true,
              controls : true,
              height  : null,
              width   : null,
              autoSize : true,
              renderOnResize:false,
              scripting : 'always',
              cls     :'x-media x-media-swf x-chart-amchart',
              params: {
                  flashVars : {
                      "preloader_color"  : "#999999",
                       path : 'amChart/amstock/'  //location of fonts. image exports, icons
                       chart_id          : '@id',
                      "chart_data"       : (.chartData)
                      "chart_settings"   : {String} optional, additional inline settings
                      "data_file"        : (.dataURL)
                      "settings_file"    : (.settingsURL)
                      "additional_chart_settings" : {XMLString} appending settings to the ones you loaded from a file or set with the chart_settings (the line above).
                      "loading_settings" : {String} "Loading settings" text displayed while the settings are loaded
                      "loading_data" : {String} "Loading data" text displayed while the data is loaded.
                  }
              }
          }
        */
       chartCfg       : {},

       /** @private
        * default mediaCfg(chartCfg) for a Chart object
        */
       mediaCfg        : {url      : null,
                          id       : null,
                          start    : true,
                          controls : true,
                          height  : null,
                          width   : null,
                          autoSize : true,
                          renderOnResize:false,
                          scripting : 'always',
                          cls     :'x-media x-media-swf x-chart-amchart',

                           //Auto ExternalInterface Bindings (Flash v8 or higher)
                          boundExternals : ['setData', 'appendData', 'setSettings',
                                            'getSettings', 'rebuild', 'reloadData',
                                            'reloadSettings', 'reloadAll', 'setParam',
                                            'getParam', 'getData', 'exportImage',
                                            'print', 'printAsBitmap','setEvents',

                                            //line and area methods
                                            'showGraph',
                                            'hideGraph',
                                            'selectGraph',
                                            'deselectGraph',
                                            'setZoom',
                                            'showAll',

                                            //pie and donut methods
                                            'rollOverSlice',
                                            'rollOutSlice',
                                            'clickSlice'

                                            ]

        },



        /** @private called just prior to rendering the media */
        onBeforeMedia: function(){

         /* assemble a compatible mediaCfg for use with the defined Chart SWF variables */
          var mc = this.mediaCfg;
          var cCfg = this.chartCfg || (this.chartCfg = {});

          cCfg.params                = this.assert( cCfg.params,{});
          cCfg.params[this.varsName] = this.assert( cCfg.params[this.varsName],{});

          cCfg.params[this.varsName] = Ext.apply({
             "preloader_color"  : "#999999",
              path              : null,
              chart_id          : '@id',
             "chart_data"       : this.assert(this.chartData, null),
             "chart_settings"   : null,
             "data_file"        : this.dataURL ? encodeURI(this.prepareURL(this.dataURL)) : null,
             "settings_file"    : this.settingsURL ? encodeURI(this.prepareURL(this.settingsURL)) :null
          }, cCfg.params[this.varsName] );

          chart.amChart.Adapter.superclass.onBeforeMedia.call(this);

          mc = this.mediaCfg;
          //parse any current additional settings to add redraw and time_stamping
          var re = /(?:<settings([^>]*)?>)((\n|\r|.)*?)(?:<\/settings>)/ig;
          var match = re.exec(mc.params[this.varsName]["additional_chart_settings"]||'');

          var extras= match && match[2]?[match[2]]:[];
          if(mc.autoSize){
              extras.push('<redraw>true</redraw>');
              this.animCollapse = false;  //amChart has trouble with resizing after Ext anim effects on IE.
              }
          if(this.disableCaching){
              extras.push('<add_time_stamp>true</add_time_stamp>');
              }

          if(!!extras.length){
             mc.params[this.varsName]["additional_chart_settings"]= '<settings>'+extras.join('')+'</settings>';
          }


      },

      /**
       * Set/update the current chart with a new XML Data series
       * @param {CSV/XMLString} data The data stream to update with.
       * @param {Boolean} immediate false to defer rendering the new data until the next chart rendering.
       * @default true
       */
      setChartData : function(data, immediate){
           var o;
           this.chartData = data;
           if( data && immediate !== false && (o = this.getInterface())){

              if( o.setData !== undefined ){
                   o.setData(data);
              }
           }
           o = null;
           return this;
        },

       /**
       * Appends data to the current chart with a additional data.
       * @param {CSV/XMLString} data The data stream to append.
       * @param {Integer} removeCount Optional number of data points that should be removed from the beginning of dataset.
       * @default true
       */
       appendChartData : function(data, removeCount){
           var o;

           if( immediate !== false && (o = this.getInterface())){

              if( o.appendData!== undefined ){
                   o.appendData(data, removeCount|| 0 );
              }
           }
           o = null;
           return this;
        },

         /**
          * Set/update the current chart with a new Data series URL
          * @param {String} url The URL of the stream to update with.
          * @param {Boolean} immediate false to defer rendering the new data until the next chart rendering.
          */
        setChartDataURL  : function(url, immediate){
              var o;
              this.dataURL = url;
              if(url && (o = this.getInterface()) && immediate !== false){
                  o.reloadData(encodeURI(this.prepareURL(url)));

              }
              return this;
           }

    });

    window.amChartInited =
        typeof window.amChartInited == 'function'  ?
            window.amChartInited.createInterceptor(chart.FlashAdapter.chartOnLoad):
                 chart.FlashAdapter.chartOnLoad;



    var dispatchEvent = function(name, id){

        var c, d = Ext.get(id);
        if(d && (c = d.ownerCt)){
           c.fireEvent.apply(c, [name, c, c.getInterface()].concat(Array.prototype.slice.call(arguments,2)));
        }
        c = d =null;
    };

    var bindFunction = function(fnName){
        var cb = dispatchEvent.createDelegate(null,[fnName.toLowerCase().replace(/^am/i,'')],0);
        window[fnName] = typeof window[fnName] == 'function' ? window[fnName].createInterceptor(cb): cb ;
     };

    //Bind amChart callbacks to an Ext.Event for the corresponding chart.
    Ext.each([  'amProcessCompleted',
                'amReturnData',
                'amReturnSettings' ,
                'amReturnImageData',
                'amReturnParam',
                'amError',

                //These are unique to the stock Chart object
                'amRolledOver',
                'amClickedOn',

                'amClickedOnEvent',
                'amClickedOnBullet',
                'amClickedOnSeries',
                'amRolledOverEvent',
                'amRolledOverBullet',
                'amRolledOverSeries',
                'amGetZoom',
                'amGraphHide',
                'amGraphShow',
                'amGraphSelect',
                'amGraphDeselect',
                'amSelectDataSet',
                'amCompareDataSet',
                'amUncompareDataSet',
                'amGetStatus'
                ],
      bindFunction);

    /**
     * @class Ext.ux.Chart.amChart.Component
     * @extends Ext.ux.Chart.amChart.Adapter
     * @version 2.1
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     * @base Ext.ux.Media.Flash.Component
     */

    Ext.ux.Chart.amChart.Component = Ext.extend(Ext.ux.Media.Flash.Component, {
        ctype : 'Ext.ux.Chart.amChart.Component' ,
        mediaClass  : chart.amChart.Adapter

        });


    Ext.reg('amchart', Ext.ux.Chart.amChart.Component);
    /**
     * @class Ext.ux.Chart.amChart.Panel
     * @extends Ext.ux.Chart.amChart.Adapter
     * @version 2.1
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     * @base Ext.ux.Media.Flash.Panel
     */

    Ext.ux.Chart.amChart.Panel = Ext.extend(Ext.ux.Media.Flash.Panel, {
        ctype : 'Ext.ux.Chart.amChart.Panel',
        mediaClass  : chart.amChart.Adapter
        });

    Ext.reg('amchartpanel', chart.amChart.Panel);

    /**
     * @class Ext.ux.Chart.amChart.Portlet
     * @extends Ext.ux.Chart.amChart.Adapter

     * @version 2.1
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     * @base Ext.ux.Media.Flash.Panel
     */
    Ext.ux.Chart.amChart.Portlet = Ext.extend(Ext.ux.Media.Flash.Panel,  {
        anchor      : '100%',
        frame       : true,
        collapseEl  : 'bwrap',
        collapsible : true,
        draggable   : true,
        cls         : 'x-portlet x-chart-portlet',
        ctype : 'Ext.ux.Chart.amChart.Portlet',
        mediaClass  : chart.amChart.Adapter
    });

    Ext.reg('amchartportlet', Ext.ux.Chart.amChart.Portlet);
    /**
     * @class Ext.ux.Chart.amChart.Window
     * @extends Ext.ux.Chart.amChart.Adapter
     * @version 2.1
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     * @base Ext.ux.Media.Flash.Window
     */

    Ext.ux.Chart.amChart.Window = Ext.extend(Ext.ux.Media.Flash.Window, {
        ctype : "Ext.ux.Chart.amChart.Window",
        mediaClass  : chart.amChart.Adapter

        });

    Ext.reg('amchartwindow', chart.amChart.Window);

    Ext.namespace("Ext.ux.Chart.amStock");

    /*Stock chart class */
    /**
     * @class Ext.ux.Chart.amStock.Adapter
     * @extends Ext.ux.Chart.amChart.Adapter
     * @version 1.0
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     */

    Ext.ux.Chart.amStock.Adapter = Ext.extend( Ext.ux.Chart.amChart.Adapter, {

       /** @private
        * default mediaCfg(chartCfg) for a Chart object
        */
        mediaCfg   : {url      : null,
                      id       : null,
                      start    : true,
                      controls : true,
                      height  : null,
                      width   : null,
                      autoSize : true,
                      renderOnResize:false,
                      scripting : 'always',
                      cls     :'x-media x-media-swf x-chart-amstock',

                       //Auto ExternalInterface Bindings (Flash v8 or higher)
                      boundExternals : ['setData', 'appendData', 'setSettings',
                                        'getSettings', 'rebuild', 'reloadData',
                                        'reloadSettings', 'reloadAll', 'setParam',
                                        'getParam', 'getData', 'exportImage',
                                        'print', 'printAsBitmap', 'setZoom',
                                        'showAll', 'selectDataset', 'compareDataset',
                                        'uncompareDataset', 'uncompareAll', 'hideEvents',
                                        'showEvents','removeDataSet','removeChart',
                                        'removeGraph','hideGraph','showGraph','getStatus',
                                        'setStatus','setEvents' ]
          },

           /** @private */
          initMedia   : function(){


                 this.addEvents(

                     /**
                      * Fires when indicator position changes.
                      * @event rolledover
                      * @param {Ext.ux.Chart} this
                      * @param {object} chartObject the underlying chart component DOM reference
                      * @param {String} date The date.
                      * @param {String} period Period.
                      */

                     'rolledover',

                    /**
                     * Fires when when user clicks on plot area.
                     * @event clickedon
                     * @param {Ext.ux.Chart} this
                     * @param {object} chartObject the underlying chart component DOM reference
                     * @param {String} date The date.
                     * @param {String} period Period.
                     */
                     'clickedon',

                     /**
                       * Fires when the when user roll-overs some event.
                       * @event rolledoverevent
                       * @param {Ext.ux.Chart} this
                       * @param {object} chartObject the underlying chart component DOM reference
                       * @param {String} date The date.
                       * @param {String} description Description.
                       * @param {String} id id.
                       * @param {String} url URL.
                       */
                      'rolledoverevent',

                      /**
                       * Fires when when user clicks on some event.
                       * @event clickedonevent
                       * @param {Ext.ux.Chart} this
                       * @param {object} chartObject the underlying chart component DOM reference
                       * @param {String} date The date.
                       * @param {String} description Description.
                       * @param {String} id id.
                       * @param {String} url URL.
                       */
                       'clickedonevent',


                        /**
                         * Fires when the user changes main data set.
                         * @event selectdataset
                         * @param {Ext.ux.Chart} this
                         * @param {Element} chartObject the underlying chart component DOM reference
                         * @param {Mixed} did DatasetId
                         */

                     'selectdataset',

                        /**
                         * Fires when the user selects a data set for comparison.
                         * @event comparedataset
                         * @param {Ext.ux.Chart} this
                         * @param {Element} chartObject the underlying chart component DOM reference
                         * @param {Mixed} did DatasetId
                         */

                     'comparedataset',
                        /**
                         * Fires when the user deselects a data set for comparison.
                         * @event uncomparedataset
                         * @param {Ext.ux.Chart} this
                         * @param {Element} chartObject the underlying chart component DOM reference
                         * @param {Mixed} did DatasetId
                         */

                     'uncomparedataset',

                        /**
                         * Fires when the selected period is changed.
                         * @event getstatus
                         * @param {Ext.ux.Chart} this
                         * @param {Element} chartObject the underlying chart component DOM reference
                         * @param {Mixed} status DatasetId
                         */

                     'getstatus'

                  );

                  chart.amStock.Adapter.superclass.initMedia.call(this);

          }

    });

    /**
     * @class Ext.ux.Chart.amStock.Component
     * @extends Ext.ux.Chart.amStock.Adapter
     * @version 2.1
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     * @base Ext.ux.Media.Flash.Component
     */

    Ext.ux.Chart.amStock.Component = Ext.extend(Ext.ux.Media.Flash.Component, {
        ctype : 'Ext.ux.Chart.amStock',
        mediaClass  : chart.amStock.Adapter
        });

    Ext.reg('amstock', chart.amStock.Component);

    /**
     * @class Ext.ux.Chart.amStock.Panel
     * @version 2.1
     * @extends Ext.ux.Chart.amStock.Adapter
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     * @base Ext.ux.Media.Flash.Panel
     */

    Ext.ux.Chart.amStock.Panel = Ext.extend(Ext.ux.Media.Flash.Panel, {
        ctype : 'Ext.ux.Chart.amStock.Panel',
        mediaClass  : chart.amStock.Adapter
        });

    Ext.reg('amstockpanel', chart.amStock.Panel);
    /**
     * @class Ext.ux.Chart.amStock.Portlet
     * @extends Ext.ux.Media.Flash.Panel
     * @version 2.1
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     * @base Ext.ux.Chart.amStock.Adapter
     */


    Ext.ux.Chart.amStock.Portlet = Ext.extend(Ext.ux.Media.Flash.Panel, {
        anchor      : '100%',
        frame       : true,
        collapseEl  : 'bwrap',
        collapsible : true,
        draggable   : true,
        cls         : 'x-portlet x-chart-portlet',
        ctype : 'Ext.ux.Chart.amStock.Portlet',
        mediaClass  : chart.amStock.Adapter
    });

    Ext.reg('amstockportlet', chart.amStock.Portlet);

    /**
     * @class Ext.ux.Chart.amStock.Window
     * @extends Ext.ux.Chart.amStock.Adapter
     * @version 2.1
     * @author Doug Hendricks. doug[always-At]theactivegroup.com
     * @donate <a target="tag_donate" href="http://donate.theactivegroup.com"><img border="0" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" alt="Make a donation to support ongoing development"></a>
     * @copyright 2007-2009, Active Group, Inc.  All rights reserved.
     * @license <a href="http://www.gnu.org/licenses/gpl.html">GPL 3.0</a>
     * @constructor
     * @param {Object} config The config object
     * @base Ext.ux.Media.Flash.Window
     */

    Ext.ux.Chart.amStock.Window = Ext.extend(Ext.ux.Media.Flash.Window, {
        ctype : "Ext.ux.Chart.amStock.Window",
        mediaClass  : chart.amStock.Adapter
        });

    Ext.reg('amstockwindow', chart.amStock.Window);


})();

if (Ext.provide) {
    Ext.provide('uxamchart');
}