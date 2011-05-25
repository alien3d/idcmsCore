Ext.onReady(function(){
			Ext.QuickTips.init();
	Ext.BLANK_IMAGE_URL = '../js/resources/images/s.gif';			 	
		 Ext.Ajax.timeout = 90000;
		
		Ext.BLANK_IMAGE_URL ='../js/resources/images/s.gif';
    	var perPage		= 	15;
		var encode 			=	false;
    	var local 			= 	false;
		var store 			= 	new Ext.data.JsonStore({
        	autoDestroy		:	true,
        	url				: 	'calendarsController.php',
        	remoteSort		: 	true,
        	storeId			:	'myStore',
        	root			:	'data',
        	totalProperty	:	'total',
			baseParams			: 	{  method:'read',	mode:'view' ,leaf_uniqueId	:	leaf_uniqueId	}, 
        	fields: [	{	name		:	'cal_ownId'		},
        	         	{ 	name		:	'calendarTitle'	}
					]
    	});

		var staffReader	= new Ext.data.JsonReader({ root:'staff',id:'staffId' }, 
				[ 'staffId', 'staffName']);
	    
		
		var staffStore 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'calendarsController.php?method=read&field=staffId',
					method:'GET'
				}),
			reader		:	staffReader,
			remoteSort	:	false 
		});
		

		var columnModel 	=	[ new Ext.grid.RowNumberer(),{
			    dataIndex : 'calendarTitle',
				header : 'Tajuk',
				sortable : true,
				editor : {
					xtype : 'textfield',
					labelAlign : 'left',
					hiddenName : 'calendarTitle',
					name : 'calendarTitle',
					id : 'calendarTitle',		
					allowBlank : false,
					blankText : 'Sila isi Tajuk',
					anchor : '95%'
				}
			}];
		
		var editor = new Ext.ux.grid.RowEditor({
			saveText : 'Save',
			listeners : {
				afteredit : function(rowEditor, changes, record, rowIndex) {
					this.save = true;
					// update record manually
					var curr_store = this.grid.getStore();
					var record = curr_store.getAt(rowIndex);
					Ext.Ajax.request( {
						url : 'calendarsController.php',
						method : 'POST',
						params : {
							method 		  :	'update',
							cal_ownId  : record.get('cal_ownId'),
							leaf_uniqueId : leaf_uniqueId,
							calendarTitle : record.get('calendarTitle')
						},
						success : function(response, options) {
							x = Ext.decode(response.responseText);
							if (x.success == 'false') {
								// error la
								Ext.MessageBox.alert('system', x.message);
							} else {
								// Ext.MessageBox.alert('system',"Success
								// takde response ka"+x.message);

							}
						}
					});
					grid.store.reload();
				}
			}
		});


		var grid 			=	new Ext.grid.GridPanel({
			border				:	false,
			store				:	store,
			height				:   400,
			columns				:	columnModel,
			loadMask			: 	true,
			plugins				: 	[editor],
			sm					: 	new Ext.grid.RowSelectionModel({singleSelect: true}),
			viewConfig			: {		forceFit: true ,
			                            emptyText :	'No rows to display'
								   },
			iconCls				:	'application_view_detail',
			listeners			: 	{
				render			: {
					fn			: function(){
									store.load({
										params	:	{
											start	:	0,
											limit	: 	perPage,
											method	:	'read',
											mode	:	'view'
										}
									});
								}
							}
				},
			bbar				: 	new Ext.PagingToolbar({
				store				:	store,
				pageSize			:	perPage,
                                displayInfo : true,
				plugins             : [ new Ext.ux.plugins.PageComboResizer()]
			})
		});

		
		var gridPanel	  	= 	new Ext.Panel ({ 
			title:'Senarai '+leaf_nme,
			height:50,
			iconCls:'application_view_detail',
			items:[grid]
		});

		// viewport just save information,items will do separate
		var viewPort		=	new Ext.Viewport({
			id				:	'viewport',
			region			:	'center',
			layout			:	'accordion',
			layoutConfig	: 	{
        		// layout-specific configs go here
        	titleCollapse	: true,
        	animate			: false,
        	activeOnTop		: true
    		},
			items	:	[gridPanel]
		});
	
	});
