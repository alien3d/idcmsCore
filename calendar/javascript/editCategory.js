Ext.onReady(function(){
			Ext.QuickTips.init();
	Ext.BLANK_IMAGE_URL = '../js/resources/images/s.gif';			 	
		 Ext.Ajax.timeout = 90000;
		
		Ext.BLANK_IMAGE_URL ='../js/resources/images/s.gif';
    	var per_page		= 	15;
		var encode 			=	false;
    	var local 			= 	false;
		var store 			= 	new Ext.data.JsonStore({
        	autoDestroy		:	true,
        	url				: 	'calendars_data.php',
        	remoteSort		: 	true,
        	storeId			:	'myStore',
        	root			:	'data',
        	totalProperty	:	'total',
			baseParams			: 	{  method:'read',	mode:'view' ,leaf_uniqueId	:	leaf_uniqueId	}, 
        	fields: [	{	name		:	'cal_own_uniqueId'		},
        	         	{ 	name		:	'cal_title'	}
					]
    	});

		var staff_reader	= new Ext.data.JsonReader({ root:'staff',id:'staffId' }, 
				[ 'staffId', 'staffName']);
	    
		
		var staff_store 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'calendars_data.php?method=read&field=staffId',
					method:'GET'
				}),
			reader		:	staff_reader,
			remoteSort	:	false 
		});
		

		var columnModel 	=	[ new Ext.grid.RowNumberer(),{
			    dataIndex : 'cal_title',
				header : 'Tajuk',
				sortable : true,
				editor : {
					xtype : 'textfield',
					labelAlign : 'left',
					hiddenName : 'cal_title',
					name : 'cal_title',
					id : 'cal_title',		
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
						url : 'calendars_data.php',
						method : 'POST',
						params : {
							method 		  :	'update',
							cal_own_uniqueId  : record.get('cal_own_uniqueId'),
							leaf_uniqueId : leaf_uniqueId,
							cal_title : record.get('cal_title')
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
											limit	: 	per_page,
											method	:	'read',
											mode	:	'view'
										}
									});
								}
							}
				},
			bbar				: 	new Ext.PagingToolbar({
				store				:	store,
				pageSize			:	per_page,
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
