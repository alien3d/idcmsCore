/*!
 * Extensible 1.0.1
 * Copyright(c) 2010-2011 Extensible, LLC
 * licensing@ext.ensible.com
 * http://ext.ensible.com
 */

Ext.onReady(function(){
    
    var today = new Date().clearTime();
        apiRoot = 'remote/php/app.php/events/';
    
    Ext.Msg.minWidth = 300;
    
    // Let's load the calendar store remotely also. All you have to do to get
    // color-coding is include this store with the CalendarPanel.
    
    calendarProxy = new Ext.data.HttpProxy({
		url : "../controller/calendarController.php",
		method : 'POST',
		success : function(response, options) {
			jsonResponse = Ext.decode(response.responseText);
			if (jsonResponse.success == true) {
				// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
			} else {
				Ext.MessageBox.alert(systemErrorLabel,
						jsonResponse.message);
			}
		},
		failure : function(response, options) {
			Ext.MessageBox.alert(systemErrorLabel,
					escape(response.Status) + ":"
							+ escape(response.statusText));
		}
	});

	calendarReader = new Ext.data.JsonReader({

		totalProperty : "total",
		successProperty : "success",
		messageProperty : "message",
		idProperty : "calendarId"

	});
	
    var calendarStore = new Ext.data.JsonStore({
        storeId: 'calendarStore',
        proxy :calendarProxy,
        reader : calendarReader,
        autoLoad:true,
        autoDestroy : true,
		pruneModifiedRecords : true,
		baseParams : {
			method : "read",
			leafId : leafId,
			isAdmin : isAdmin
		},
		root : "data",
        fields: Ext.ensible.cal.CalendarRecord.prototype.fields.getRange(),
        remoteSort: true,
        sortInfo: {
            field: Ext.ensible.cal.CalendarMappings.Title.name,
            direction: 'ASC'
        }
    });
    // Make sure this loads first so that the calendar records are available
    // when the event store loads and triggers the view to render
 
    
    var eventProxy = new Ext.data.HttpProxy({
		url : "../controller/eventController.php",
		method : 'POST',
		success : function(response, options) {
			jsonResponse = Ext.decode(response.responseText);
			if (jsonResponse.success == true) {
				// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
			} else {
				Ext.MessageBox.alert(systemErrorLabel,
						jsonResponse.message);
			}
		},
		failure : function(response, options) {
			Ext.MessageBox.alert(systemErrorLabel,
					escape(response.Status) + ":"
							+ escape(response.statusText));
		}
	});
    
    
    
    
    var eventReader = new Ext.data.JsonReader({
        totalProperty: 'total',
        successProperty: 'success',
        idProperty: 'eventId',
        messageProperty: 'message'
       
    });
    
    
    
  
    var eventStore = new Ext.data.JsonStore({
        storeId: 'eventStore',
        proxy :eventProxy,
        reader : eventReader,
        autoLoad:true,
        autoDestroy : true,
		pruneModifiedRecords : true,
		baseParams : {
			method : "read",
			leafId : leafId,
			isAdmin : isAdmin
		},
		root : "data",
		fields: Ext.ensible.cal.EventRecord.prototype.fields.getRange()
    });

    var cp = new Ext.ensible.cal.CalendarPanel({
        id: 'calendar-remote',
        eventStore: eventStore,
        calendarStore: calendarStore,
        renderTo: 'cal',
        title: 'Remote Calendar',
        width: 900,
        height: 700
    });
    
    // You can optionally call load() here if you prefer instead of using the 
    // autoLoad config.  Note that as long as you call load AFTER the store
    // has been passed into the CalendarPanel the default start and end date parameters
    // will be set for you automatically (same thing with autoLoad:true).  However, if
    // you call load manually BEFORE the store has been passed into the CalendarPanel 
    // it will call the remote read method without any date parameters, which is most 
    // likely not what you'll want. 
    // store.load({ ... });
    
    
    var errorCheckbox = Ext.get('forceError');
     
    var setRemoteErrorMode = function(){
        if(errorCheckbox.dom.checked){
            // force an error response to test handling of CUD (not R) actions. this param is 
            // only implemented in the back end code for this sample -- it's not default behavior.
            store.setBaseParam('fail', true);
            cp.setTitle('Remote Calendar <span id="errTitle">(Currently in remote error mode)</span>');
        }
        else{
            delete store.baseParams['fail'];
            cp.setTitle('Remote Calendar');
        }
    };
    
    setRemoteErrorMode();
    errorCheckbox.on('click', setRemoteErrorMode);
});