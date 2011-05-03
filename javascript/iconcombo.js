// JavaScript Document
/**
 * Ext.ux.form.IconComboBox Extension Class for Ext 2.x Library
 *
 * @author  Ing. Jozef Sakalos
 * @version $Id: IconCombo.js,v 1.1 2010/01/29 10:14:25 jcarbou Exp $
 *
 * @license Ext.ux.form.IconComboBox is licensed under the terms of
 * the Open Source LGPL 3.0 license.  Commercial use is permitted to the extent
 * that the code/component(s) do NOT become part of another Open Source or Commercially
 * licensed development library or toolkit without explicit permission.
 * 
 * License details: http://www.gnu.org/licenses/lgpl.html
 */

/**
 * @class Ext.ux.form.IconComboBox
 * @extends Ext.form.ComboBox
 */
Ext.namespace('Ext.ux.form');
Ext.ux.form.IconCombo = Ext.extend(Ext.form.ComboBox, {
    initComponent:function() {
		this.iconWidth = this.iconWidth || 16;
		var iw = this.iconWidth;
		
		// Add, if not already exist, css for icon width
		if (!Ext.util.CSS.getRule('ux-icon-combo-icon-'+iw)) {
			var css = '.ux-icon-combo-icon-'+iw+' {background-repeat: no-repeat;background-position: 0 50%;width: '+(iw+2)+'px;height: 14px;}'
	        + '.ux-icon-combo-input-'+iw+' {padding-left: '+(iw+9)+'px;}'
	        + '.x-form-field-wrap .ux-icon-combo-icon-'+iw+' {top: 4px;left: 5px;}'
	        + '.ux-icon-combo-item-'+iw+' {background-repeat: no-repeat ! important;background-position: 3px 50% ! important;padding-left: '+(iw+8)+'px ! important;}';
			Ext.util.CSS.createStyleSheet(css, 'ux-IconCombo-css-'+iw);
		}
        
        this.iconClsTpl = this.iconClsTpl || ('{' + this.iconClsField + '}');	
		
        Ext.apply(this, {
            tpl:  '<tpl for=".">'
                + '<div class="x-combo-list-item ux-icon-combo-item-'+iw+' '+ this.iconClsTpl+'">'
                + '{' + this.displayField + '}'
                + '</div></tpl>'
        });
		
		this.iconClsTpl = new Ext.Template(this.iconClsTpl);

        // call parent initComponent
        Ext.ux.form.IconCombo.superclass.initComponent.apply(this, arguments);

    } // eo function initComponent

    ,onRender:function(ct, position) {
        // call parent onRender
        Ext.ux.form.IconCombo.superclass.onRender.apply(this, arguments);

        // adjust styles
        this.wrap.applyStyles({position:'relative'});
        this.el.addClass('ux-icon-combo-input-'+this.iconWidth);

        // add div for icon
        this.icon = Ext.DomHelper.append(this.el.up('div.x-form-field-wrap'), {
            tag: 'div', style:'position:absolute'
        });
    } // eo function onRender

    ,afterRender:function() {
        Ext.ux.form.IconCombo.superclass.afterRender.apply(this, arguments);
        if(undefined !== this.value) {
            this.setValue(this.value);
        }
    } // eo function afterRender
    ,setIconCls:function() {
        var rec = this.store.query(this.valueField || this.displayField, this.getValue()).itemAt(0);
        if(rec && this.icon) {
			this.icon.className = 'ux-icon-combo-icon-'+this.iconWidth +' '+ this.iconClsTpl.apply(rec.data);
        }
    } // eo function setIconCls

    ,reset:function(value) {
       Ext.ux.form.IconCombo.superclass.reset.apply(this, arguments);
       this.icon.className = ''; 
    } // eo function reset

    ,setValue: function(value) {
        Ext.ux.form.IconCombo.superclass.setValue.call(this, value);
        this.setIconCls();
    } // eo function setValue


});

// register xtype
Ext.reg('iconcombo', Ext.ux.form.IconCombo);