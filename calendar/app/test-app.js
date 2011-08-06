/*!
 * Ext JS Library 3.3.0
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */
App = function() {
    return {
        init : function() {
            
            Ext.BLANK_IMAGE_URL = 'http://extjs.cachefly.net/ext-3.1.0/resources/images/default/s.gif';

            this.calendarReader = new Ext.data.JsonReader({
				root : 'calendars',
				fields : [{
							name : 'CalendarId',
							mapping : 'calendar_uniqueId',
							type : 'int'
						}, {
							name : 'Title',
							mapping : 'cal_title',
							type : 'string'
						}]
			});

			this.calendarStore = new Ext.data.Store({
				storeId : 'calendarStore',
				sortInfo : {
					field : 'CalendarId',
					direction : 'ASC'
				},
				proxy : new Ext.data.HttpProxy({
					url : 'calendars_data.php?method=read&mode=calendar&leaf_uniqueId='
							+ leaf_uniqueId,
					method : 'GET'
				}),
				reader : this.calendarReader
			});
		
			this.calendarStore.load();
		
			this.eventReader = new Ext.data.JsonReader({
						root : 'evts',
						fields : Ext.calendar.EventRecord.prototype.fields
								.getRange()
					});
		
			this.eventStore = new Ext.data.Store({
				storeId : 'eventStore',
				proxy : new Ext.data.HttpProxy({
					url : 'calendars_data.php?method=read&mode=event&leaf_uniqueId='
							+ leaf_uniqueId,
					method : 'GET'
				}),
				reader : this.eventReader,
				sortInfo : {
					field : 'StartDate',
					direction : 'ASC'
				}
			});
		
			this.eventStore.load();
            
            // This is the app UI layout code.  All of the calendar views are subcomponents of
            // CalendarPanel, but the app title bar and sidebar/navigation calendar are separate
            // pieces that are composed in app-specific layout code since they could be ommitted
            // or placed elsewhere within the application.
            new Ext.Viewport({
                layout: 'border',
                renderTo: 'calendar-ct',
                items: [{
                    id: 'app-header',
                    region: 'north',
                    height: 35,
                    border: false,
                    contentEl: 'app-header-content'
                },{
                    id: 'app-center',
                    title: '...', // will be updated to view date range
                    region: 'center',
                    layout: 'border',
                    items: [{
                        id:'app-west',
                        region: 'west',
                        width: 176,
                        border: false,
                        items: [{
                            xtype: 'datepicker',
                            id: 'app-nav-picker',
                            cls: 'ext-cal-nav-picker',
                            listeners: {
                                'select': {
                                    fn: function(dp, dt){
                                        App.calendarPanel.setStartDate(dt);
                                    },
                                    scope: this
                                }
                            }
                        }]
                    },{
                        xtype: 'calendarpanel',
                        eventStore: this.eventStore,
                        calendarStore: this.calendarStore,
                        border: false,
                        id:'app-calendar',
                        region: 'center',
                        activeItem: 2, // month view
                        
                        // CalendarPanel supports view-specific configs that are passed through to the 
                        // underlying views to make configuration possible without explicitly having to 
                        // create those views at this level:
                        monthViewCfg: {
                            showHeader: true,
                            showWeekLinks: true,
                            showWeekNumbers: true
                        },
                        
                        // Some optional CalendarPanel configs to experiment with:
                        //showDayView: false,
                        //showWeekView: false,
                        //showMonthView: false,
                        //showNavBar: false,
                        //showTodayText: false,
                        //showTime: false,
                        //title: 'My Calendar', // the header of the calendar, could be a subtitle for the app
                        
                        // Once this component inits it will set a reference to itself as an application
                        // member property for easy reference in other functions within App.
                        initComponent: function() {
                            App.calendarPanel = this;
                            this.constructor.prototype.initComponent.apply(this, arguments);
                        },
                        
                        listeners: {
                            'eventclick': {
                                fn: function(vw, rec, el){
                                    this.showEditWindow(rec, el);
                                    this.clearMsg();
                                },
                                scope: this
                            },
                            'eventover': function(vw, rec, el){
                                //console.log('Entered evt rec='+rec.data.Title+', view='+ vw.id +', el='+el.id);
                            },
                            'eventout': function(vw, rec, el){
                                //console.log('Leaving evt rec='+rec.data.Title+', view='+ vw.id +', el='+el.id);
                            },
                            'eventadd': {
                                fn: function(cp, rec){
                                    this.showMsg('Event '+ rec.data.Title +' was added');
                                    var data;
                                    reminder = function(data){
                                    	var remind;
                                    	if (!data){
                                    		remind = null;
                                    	}else{
	                                    	remind = data;
		                                }
                                     return remind;
                                     };
                                    Ext.Ajax.request({
										url : 'calendars_data.php',
										params : {
											method : 'create',
											calendar_uniqueId : rec.data.CalendarId,
											title : rec.data.Title,
											start : rec.data.StartDate,
											end : rec.data.EndDate,
											ad : rec.data.IsAllDay,
											loc : rec.data.Location,
											rem :reminder(rec.data.Reminder),
											n : rec.data.IsNew,
											notes : rec.data.Notes,
											leaf_uniqueId : leaf_uniqueId
										},
										success : function(response,options) {
											var x = Ext.decode(response.responseText);
											var title = 'Message';
											if (x.success == 'true') {
												title = title
														+ ' Success';
											} else {
												title = title
														+ ' Failure';
											}
											Ext.MessageBox.alert(title,
													x.message);
										},
										failure : function(response,
												options) {
											// critical bug extjs
											var x = Ext
													.decode(response.responseText);
											var title = 'Message Failure';
											Ext.MessageBox.alert(title,
													x.message);
										}
									});
                                },
                                scope: this
                            },
                            'eventupdate': {
                                fn: function(cp, rec){
                                    this.showMsg('Event '+ rec.data.Title +' was updated');
                                    var data;
                                    reminder = function(data){
                                    	var remind;
                                    	if (!data){
                                    		remind = null;
                                    	}else{
	                                    	remind = data;
		                                }
                                     return remind;
                                     };
                                    
                                    //alert(reminder);
                                    Ext.Ajax.request({
										url : 'calendars_data.php',
										params : {
											method : 'update_event',
											event_uniqueId : rec.data.EventId,
											calendar_uniqueId : rec.data.CalendarId,
											title : rec.data.Title,
											start : rec.data.StartDate,
											end : rec.data.EndDate,
											ad : rec.data.IsAllDay,
											loc : rec.data.Location,
											rem :reminder(rec.data.Reminder),
									 		n : rec.data.IsNew,
											notes : rec.data.Notes,
											leaf_uniqueId : leaf_uniqueId
										},
										success : function(response,
												options) {
											var x = Ext
													.decode(response.responseText);
											var title = 'Message';
											if (x.success == 'true') {
												title = title
														+ ' Success';
											} else {
												title = title
														+ ' Failure';
											}
											Ext.MessageBox.alert(title,
													x.message);
										},
										failure : function(response,
												options) {
											// critical bug extjs
											var x = Ext
													.decode(response.responseText);
											var title = 'Message Failure';
											Ext.MessageBox.alert(title,
													x.message);
										}
									});
                                },
                                scope: this
                            },
                            'eventdelete': {
                                fn: function(cp, rec){
                                    this.showMsg('Event '+ rec.data.Title +' was deleted');
                                    Ext.Ajax.request({
										url : 'calendars_data.php',
										params : {
											method : 'delete_event',
											id : rec.data.EventId,
											leaf_uniqueId : leaf_uniqueId
										},
										success : function(response,
												options) {
										
											var x = Ext
													.decode(response.responseText);
											var title = 'Message';
											if (x.success == 'true') {
												title = title
														+ ' Success';
											} else {
												title = title
														+ ' Failure';
											}
											Ext.MessageBox.alert(title,
													x.message);
										},
										failure : function(response,
												options) {
											// critical bug extjs
											var x = Ext
													.decode(response.responseText);
											var title = 'Message Failure';
											Ext.MessageBox.alert(title,
													x.message);
										}
									});
                                },
                                scope: this
                            },
                            'eventcancel': {
                                fn: function(cp, rec){
                                    // edit canceled
                                },
                                scope: this
                            },
                            'viewchange': {
                                fn: function(p, vw, dateInfo){
                                    if(this.editWin){
                                        this.editWin.hide();
                                    };
                                    if(dateInfo !== null){
                                        // will be null when switching to the event edit form so ignore
                                        Ext.getCmp('app-nav-picker').setValue(dateInfo.activeDate);
                                        this.updateTitle(dateInfo.viewStart, dateInfo.viewEnd);
                                    }
                                },
                                scope: this
                            },
                            'dayclick': {
                                fn: function(vw, dt, ad, el){
                                    this.showEditWindow({
                                        StartDate: dt,
                                        IsAllDay: ad
                                    }, el);
                                    this.clearMsg();
                                },
                                scope: this
                            },
                            'rangeselect': {
                                fn: function(win, dates, onComplete){
                                    this.showEditWindow(dates);
                                    this.editWin.on('hide', onComplete, this, {single:true});
                                    this.clearMsg();
                                },
                                scope: this
                            },
                            'eventmove': {
                                fn: function(vw, rec){
                                    rec.commit();
                                    var time = rec.data.IsAllDay ? '' : ' \\a\\t g:i a';
                                    this.showMsg('Event '+ rec.data.Title +' was moved to '+rec.data.StartDate.format('F jS'+time));
                                    var data;
                                    reminder = function(data){
                                    	var remind;
                                    	if (!data){
                                    		remind = null;
                                    	}else{
	                                    	remind = data;
		                                }
                                     return remind;
                                     };
                                    Ext.Ajax.request({
										url : 'calendars_data.php',
										params : {
											method : 'update_event',
											event_uniqueId : rec.data.EventId,
											calendar_uniqueId : rec.data.CalendarId,
											title : rec.data.Title,
											start : rec.data.StartDate,
											end : rec.data.EndDate,
											ad : rec.data.IsAllDay,
											loc : rec.data.Location,
											rem :reminder(rec.data.Reminder),
											n : rec.data.IsNew,
											notes : rec.data.Notes,
											leaf_uniqueId : leaf_uniqueId
										},
										success : function(response,
												options) {
											var x = Ext
													.decode(response.responseText);
											var title = 'Message';
											if (x.success == 'true') {
												title = title
														+ ' Success';
											} else {
												title = title
														+ ' Failure';
											}
											Ext.MessageBox.alert(title,
													x.message);
										},
										failure : function(response,
												options) {
											// critical bug extjs
											var x = Ext
													.decode(response.responseText);
											var title = 'Message Failure';
											Ext.MessageBox.alert(title,
													x.message);
										}
									});
                                },
                                scope: this
                            },
                            'eventresize': {
                                fn: function(vw, rec){
                                    rec.commit();
                                    this.showMsg('Event '+ rec.data.Title +' was updated');
                                },
                                scope: this
                            },
                            'eventdelete': {
                                fn: function(win, rec){
                                    this.eventStore.remove(rec);
                                    this.showMsg('Event '+ rec.data.Title +' was deleted');
                                    Ext.Ajax.request({
										url : 'calendars_data.php',
										params : {
											method : 'delete_event',
										    event_uniqueId : rec.data.EventId,
											leaf_uniqueId : leaf_uniqueId
										},
										success : function(response,
												options) {
											var x = Ext
													.decode(response.responseText);
											var title = 'Message';
											if (x.success == 'true') {
												title = title
														+ ' Success';
											} else {
												title = title
														+ ' Failure';
											}
											Ext.MessageBox.alert(title,
													x.message);
										},
										failure : function(response,
												options) {
											// critical bug extjs
											var x = Ext
													.decode(response.responseText);
											var title = 'Message Failure';
											Ext.MessageBox.alert(title,
													x.message);
										}
									});
                                },
                                scope: this
                            },
                            'initdrag': {
                                fn: function(vw){
                                    if(this.editWin && this.editWin.isVisible()){
                                        this.editWin.hide();
                                    }
                                },
                                scope: this
                            }
                        }
                    }]
                }]
            });
        },
        
        // The edit popup window is not part of the CalendarPanel itself -- it is a separate component.
        // This makes it very easy to swap it out with a different type of window or custom view, or omit
        // it altogether. Because of this, it's up to the application code to tie the pieces together.
        // Note that this function is called from various event handlers in the CalendarPanel above.
		showEditWindow : function(rec, animateTarget){
	        if(!this.editWin){
	            this.editWin = new Ext.calendar.EventEditWindow({
                    calendarStore: this.calendarStore,
					listeners: {
						'eventadd': {
							fn: function(win, rec){
								win.hide();
								rec.data.IsNew = false;
								this.eventStore.add(rec);
                                this.showMsg('Event '+ rec.data.Title +' was added');
                                var data;
                                reminder = function(data){
                                	var remind;
                                	if (!data){
                                		remind = null;
                                	}else{
                                    	remind = data;
	                                }
                                 return remind;
                                 };
                                Ext.Ajax.request({
									url : 'calendars_data.php',
									params : {
										method : 'create',
										calendar_uniqueId : rec.data.CalendarId,
										title : rec.data.Title,
										start : rec.data.StartDate,
										end : rec.data.EndDate,
										ad : rec.data.IsAllDay,
										rem :reminder(rec.data.Reminder),
										n : rec.data.IsNew,
										leaf_uniqueId : leaf_uniqueId
									},
									success : function(response,
											options) {
										
										var x = Ext
												.decode(response.responseText);
										var title = 'Message';
										
										if (x.success == 'true') {
											title = title + ' Success';
										} else {
											title = title + ' Failure';
										}
										Ext.MessageBox.alert(title,x.message);
									},
									failure : function(response,
											options) {
										// critical bug extjs
										var x = Ext
												.decode(response.responseText);
										var title = 'Message Failure';
										Ext.MessageBox.alert(title,
												x.message);
									}
								});
							},
							scope: this
						},
						'eventupdate': {
							fn: function(win, rec){
								win.hide();
								rec.commit();
                                this.showMsg('Event '+ rec.data.Title +' was updated');
                                var data;
                                reminder = function(data){
                                	var remind;
                                	if (!data){
                                		remind = null;
                                	}else{
                                    	remind = data;
	                                }
                                 return remind;
                                 };
                                Ext.Ajax.request({
									url : 'calendars_data.php',
									params : {
										method : 'update_event',
										event_uniqueId : rec.data.EventId,
										calendar_uniqueId : rec.data.CalendarId,
										title : rec.data.Title,
										start : rec.data.StartDate,
										rem :reminder(rec.data.Reminder),
										end : rec.data.EndDate,
										ad : rec.data.IsAllDay,
										n : rec.data.IsNew,
										leaf_uniqueId : leaf_uniqueId
									},
									success : function(response,
											options) {
										var x = Ext
												.decode(response.responseText);
										var title = 'Message';
										if (x.success == 'true') {
											title = title + ' Success';
										} else {
											title = title + ' Failure';
										}
										Ext.MessageBox.alert(title,
												x.message);
									},
									failure : function(response,
											options) {
										// critical bug extjs
										var x = Ext
												.decode(response.responseText);
										var title = 'Message Failure';
										Ext.MessageBox.alert(title,
												x.message);
									}
								});
							},
							scope: this
						},
						'eventdelete': {
							fn: function(win, rec){
								this.eventStore.remove(rec);
								win.hide();
                                this.showMsg('Event '+ rec.data.Title +' was deleted');
                                Ext.Ajax.request({
									url : 'calendars_data.php',
									params : {
										method : 'delete_event',
										event_uniqueId : rec.data.EventId,
										leaf_uniqueId : leaf_uniqueId
									},
									success : function(response,
											options) {
										
										var x = Ext
												.decode(response.responseText);
										var title = 'Message';
										if (x.success == 'true') {
											title = title + ' Success';
										} else {
											title = title + ' Failure';
										}
										Ext.MessageBox.alert(title,
												x.message);
									},
									failure : function(response,
											options) {
										// critical bug extjs
										var x = Ext
												.decode(response.responseText);
										var title = 'Message Failure';
										Ext.MessageBox.alert(title,
												x.message);
									}
								});
							},
							scope: this
						},
                        'editdetails': {
                            fn: function(win, rec){
                                win.hide();
                                App.calendarPanel.showEditForm(rec);
                            }
                        }
					}
                });
	        }
	        this.editWin.show(rec, animateTarget);
		},
        
        // The CalendarPanel itself supports the standard Panel title config, but that title
        // only spans the calendar views.  For a title that spans the entire width of the app
        // we added a title to the layout's outer center region that is app-specific. This code
        // updates that outer title based on the currently-selected view range anytime the view changes.
        updateTitle: function(startDt, endDt){
            var p = Ext.getCmp('app-center');
            
            if(startDt.clearTime().getTime() == endDt.clearTime().getTime()){
                p.setTitle(startDt.format('F j, Y'));
            }
            else if(startDt.getFullYear() == endDt.getFullYear()){
                if(startDt.getMonth() == endDt.getMonth()){
                    p.setTitle(startDt.format('F j') + ' - ' + endDt.format('j, Y'));
                }
                else{
                    p.setTitle(startDt.format('F j') + ' - ' + endDt.format('F j, Y'));
                }
            }
            else{
                p.setTitle(startDt.format('F j, Y') + ' - ' + endDt.format('F j, Y'));
            }
        },
        
        // This is an application-specific way to communicate CalendarPanel event messages back to the user.
        // This could be replaced with a function to do "toast" style messages, growl messages, etc. This will
        // vary based on application requirements, which is why it's not baked into the CalendarPanel.
        showMsg: function(msg){
            Ext.fly('app-msg').update(msg).removeClass('x-hidden');
        },
        
        clearMsg: function(){
            Ext.fly('app-msg').update('').addClass('x-hidden');
        }
    }
}();

Ext.onReady(App.init, App);
