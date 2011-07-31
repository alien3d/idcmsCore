/*!
 * Extensible 1.0.1
 * Copyright(c) 2010-2011 Extensible, LLC
 * licensing@ext.ensible.com
 * http://ext.ensible.com
 */
/**
 * @class Ext.ensible.cal.CalendarCombo
 * @extends Ext.form.ComboBox
 * <p>A custom combo used for choosing from the list of available calendars to assign an event to. You must
 * pass a populated calendar store as the store config or the combo will not work.</p>
 * <p>This is pretty much a standard combo that is simply pre-configured for the options needed by the
 * calendar components. The default configs are as follows:<pre><code>
fieldLabel: 'Calendar',
triggerAction: 'all',
mode: 'local',
forceSelection: true,
width: 200
</code></pre>
 * @constructor
 * @param {Object} config The config object
 */
Ext.ensible.cal.CalendarCombo = Ext.extend(Ext.form.ComboBox, {
    fieldLabel: 'Calendar',
    triggerAction: 'all',
    mode: 'local',
    forceSelection: true,
    selectOnFocus: true,
    width: 200,
    
    // private
    defaultCls: 'x-cal-default',
    
    // private
    initComponent: function(){
        var C = Ext.ensible.cal,
            M = C.CalendarMappings;
        
        C.CalendarCombo.superclass.initComponent.call(this);
        
        this.valueField = M.CalendarId.name;
        this.displayField = M.Title.name;
        
        this.tpl = this.tpl ||
              '<tpl for="."><div class="x-combo-list-item x-cal-{' + M.ColorId.name +
              '}"><div class="ext-cal-picker-icon">&#160;</div>{' + this.displayField + '}</div></tpl>';
    },
    
    // private
    afterRender: function(){
        Ext.ensible.cal.CalendarCombo.superclass.afterRender.call(this);
        
        this.wrap = this.el.up('.x-form-field-wrap');
        this.wrap.addClass('ext-calendar-picker');
        
        this.icon = Ext.DomHelper.append(this.wrap, {
            tag: 'div', cls: 'ext-cal-picker-icon ext-cal-picker-mainicon'
        });
    },
    
    // private
    assertValue  : function(){
        var val = this.getRawValue(),
            rec = this.findRecord(this.displayField, val);

        if(!rec && this.forceSelection){
            if(val.length > 0 && val != this.emptyText){
                // Override this method simply to fix the original logic that was here.
                // The orignal method simply reverts the displayed text but the store remains
                // filtered with the invalid query, meaning it contains no records. This causes
                // problems with redisplaying the field -- much better to clear the filter and
                // reset the original value so everything works as expected.
                this.store.clearFilter();
                this.setValue(this.value);
                this.applyEmptyText();
            }else{
                this.clearValue();
            }
        }else{
            if(rec){
                if (val == rec.get(this.displayField) && this.value == rec.get(this.valueField)){
                    return;
                }
                val = rec.get(this.valueField || this.displayField);
            }
            this.setValue(val);
        }
    },
    
    // private
    getStyleClass: function(calendarId){
        if(calendarId && calendarId !== ''){
            var rec = this.store.getById(calendarId);
            return 'x-cal-' + rec.data[Ext.ensible.cal.CalendarMappings.ColorId.name];
        }
    },
    
    // inherited docs
    setValue: function(value) {
        this.wrap.removeClass(this.getStyleClass(this.getValue()));
        value = value || this.store.getAt(0).data[Ext.ensible.cal.CalendarMappings.CalendarId.name];
        Ext.ensible.cal.CalendarCombo.superclass.setValue.call(this, value);
        this.wrap.addClass(this.getStyleClass(value));
    }
});

Ext.reg('extensible.calendarcombo', Ext.ensible.cal.CalendarCombo);
