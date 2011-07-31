/*!
 * Extensible 1.0.1
 * Copyright(c) 2010-2011 Extensible, LLC
 * licensing@ext.ensible.com
 * http://ext.ensible.com
 */
/**
 * @class Ext.ensible.cal.WeekView
 * @extends Ext.ensible.cal.MultiDayView
 * <p>Displays a calendar view by week. This class does not usually need to be used directly as you can
 * use a {@link Ext.ensible.cal.CalendarPanel CalendarPanel} to manage multiple calendar views at once including
 * the week view.</p>
 * @constructor
 * @param {Object} config The config object
 */
Ext.ensible.cal.WeekView = Ext.extend(Ext.ensible.cal.MultiDayView, {
    /**
     * @cfg {Number} dayCount
     * The number of days to display in the view (defaults to 7)
     */
    dayCount: 7
});

Ext.reg('extensible.weekview', Ext.ensible.cal.WeekView);