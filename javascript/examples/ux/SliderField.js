/*!
 * Ext JS Library 3.2.0
 * Copyright(c) 2006-2010 Ext JS, LLC
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
Ext.ns('Ext.ux.form');

/**
 * @class Ext.ux.form.SliderField
 * @extends Ext.form.Field
 * Wraps a {@link Ext.Slider Slider} so it can be used as a form field.
 * @constructor
 * Creates a new SliderField
 * @param {Object} config Configuration options. Note that you can pass in any slider configuration options, as well as
 * as any field configuration options.
 * @xtype sliderfield
 */
Ext.ux.form.SliderField = Ext.extend(Ext.form.Field, {
    
    /**
     * @cfg {Boolean} useTips
     * True to use the ux.SliderTip plugin to display tips for the value. This will only be included if
     * this plugin is enabled. Defaults to <tt>true</tt>.
     */
    useTips : true,
    
    /**
     * @cfg {Function} tipText
     * A function used to display custom text for the slider tip. Defaults to <tt>null</tt>, which will
     * use the default on the plugin.
     */
    tipText : null,
    
    // private override
    actionMode: 'wrap',
    
    /**
     * Initialize the component.
     * @private
     */
    initComponent : function() {
        var cfg = Ext.copyTo({
            id: this.id + '-slider'
        }, this.initialConfig, ['vertical', 'minValue', 'maxValue', 'decimalPrecision', 'keyIncrement', 'increment', 'clickToChange', 'animate']);
        
        // only can use it if it exists.
        if(this.useTips && Ext.ux.SliderTip){
            var plug = this.tipText ? {getText: this.tipText} : {};
            cfg.plugins = [new Ext.ux.SliderTip(plug)];
        }
        this.slider = new Ext.Slider(cfg);
        Ext.ux.form.SliderField.superclass.initComponent.call(this);
    },    
    
    /**
     * Set up the hidden field
     * @param {Object} ct The container to render to.
     * @param {Object} position The position in the container to render to.
     * @private
     */
    onRender : function(ct, position){
        this.autoCreate = {
            id: this.id,
            name: this.name,
            type: 'hidden',
            tag: 'input'    
        };
        Ext.ux.form.SliderField.superclass.onRender.call(this, ct, position);
        this.wrap = this.el.wrap({cls: 'x-form-field-wrap'});
        this.slider.render(this.wrap);
    },
    
    /**
     * Ensure that the slider size is set automatically when the field resizes.
     * @param {Object} w The width
     * @param {Object} h The height
     * @param {Object} aw The adjusted width
     * @param {Object} ah The adjusted height
     * @private
     */
    onResize : function(w, h, aw, ah){
        Ext.ux.form.SliderField.superclass.onResize.call(this, w, h, aw, ah);
        this.slider.setSize(w, h);    
    },
    
    /**
     * Initialize any events for this class.
     * @private
     */
    initEvents : function(){
        Ext.ux.form.SliderField.superclass.initEvents.call(this);
        this.slider.on('change', this.onChange, this);   
        
    },
    
    /**
     * Utility method to set the value of the field when the slider changes.
     * @param {Object} slider The slider object.
     * @param {Object} v The new value.
     * @private
     */
    onChange : function(slider, v){
        this.setValue(v, undefined, true);
    },
    
    /**
     * Enable the slider when the field is enabled.
     * @private
     */
    onEnable : function(){
        Ext.ux.form.SliderField.superclass.onEnable.call(this);
        this.slider.enable();
    },
    
    /**
     * Disable the slider when the field is disabled.
     * @private
     */
    onDisable : function(){
        Ext.ux.form.SliderField.superclass.onDisable.call(this);
        this.slider.disable();    
    },
    
    /**
     * Ensure the slider is destroyed when the field is destroyed.
     * @private
     */
    beforeDestroy : function(){
        Ext.destroy(this.slider);
        Ext.ux.form.SliderField.superclass.beforeDestroy.call(this);
    },
    
    /**
     * If a side icon is shown, do alignment to the slider
     * @private
     */
    alignErrorIcon : function(){
        this.errorIcon.alignTo(this.slider.el, 'tl-tr', [2, 0]);
    },
    
    /**
     * Sets the minimum field value.
     * @param {Number} v The new minimum value.
     * @return {Ext.ux.form.SliderField} this
     */
    setMinValue : function(v){
        this.slider.setMinValue(v);
        return this;    
    },
    
    /**
     * Sets the maximum field value.
     * @param {Number} v The new maximum value.
     * @return {Ext.ux.form.SliderField} this
     */
    setMaxValue : function(v){
        this.slider.setMaxValue(v);
        return this;    
    },
    
    /**
     * Sets the value for this field.
     * @param {Number} v The new value.
     * @param {Boolean} animate (optional) Whether to animate the transition. If not specified, it will default to the animate config.
     * @return {Ext.ux.form.SliderField} this
     */
    setValue : function(v, animate, /* private */ silent){
        // silent is used if the setValue method is invoked by the slider
        // which means we don't need to set the value on the slider.
        if(!silent){
            this.slider.setValue(v, animate);
        }
        return Ext.ux.form.SliderField.superclass.setValue.call(this, this.slider.getValue());
    },
    
    /**
     * Gets the current value for this field.
     * @return {Number} The current value.
     */
    getValue : function(){
        return this.slider.getValue();    
    }
});
Ext.reg('sliderfield', Ext.ux.form.SliderField);