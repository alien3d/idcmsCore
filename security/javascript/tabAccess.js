Ext.onReady(function(){
		
		if(leafCreateAccessValue  == 1 ) {
			var pageCreate = false;
		} else { 
			var pageCreate = true;
		}
		if(leafReadAccessValue  == 1 ){ 
			var pageReload=false;
		} else { 
			var pageReload=true;
		} 
		if(leafPrintAccessValue == 1 ) {
			var pagePrint=false;
		} else {
			var pagePrint=true;
		}
		// form panel + grid.When choose the form then activated filter the
		// grid.Grid will automatically update on demand
		// first viewport
		var perPage		= 	10;
		var encode 			=	false;
		var local 			= 	false;
		var accordionProxy  =  new Ext.data.HttpProxy({
	        url: "../controller/accordionAccessController.php",
	        method: 'POST',
	        success: function (response, options) {
	            jsonResponse = Ext.decode(response.responseText);
	            if (jsonResponse.success == true) {
	                //Ext.MessageBox.alert(systemLabel, jsonResponse.message); //uncomment it for debugging purpose
	            } else {
	                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
	            }
	        },
	        failure: function (response, options) {
	            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
	        }
	    });
		var accordionReader = new Ext.data.JsonReader({
	        totalProperty: "total",
	        successProperty: "success",
	        messageProperty: "message",
	        idProperty: "accordionAccessId"
	    });
			
		var accordionAccessStore 			= 	new Ext.data.JsonStore({
			autoDestroy		:	true,
			url				: 	'../controller/accordionAccessController.php',
			remoteSort		: 	true,
			storeId			:	'myStore',
			root			:	'data',
			totalProperty	:	'total',
			baseParams		: 	{  
									method			:	'read',	
									mode			:	'view',
									leafId	:	leafId
								}, 
			fields			: 
					[	{	name		:	'accordionAccessId',
                            type        :   'int'					
					   },{
					 		name		:	'accordionId',
                            type        :   'int'							
					   },{
							name		:	'accordionNote',
                            type        :   'string'							
					   },{ 
						 	name		:	'groupId',
                            type        :   'int'							
					   },{
							name		:	'groupNote',
                            type        :   'string'							
					   },{
							name		: 	'accordionAccessValue',
                            type        :   'boolean'							
					   }
					]
		});
	
	
	
	var accordionAccessValue = new Ext.ux.grid.CheckColumn({
		header		:	accordionAccessValueLabel,
		dataIndex	:	'accordionAccessValue'
	});
	// the id for administrator to see in any problem.User cannot see this page
	// information
	var columnModel = new Ext.grid.ColumnModel({
		columns:[{ 
			header: accordionNameLabel,
			dataIndex:'accordionNote'
		},{
			header: accordionIdLabel,
			dataIndex:'accordionId'
		},{
			header: groupNameLabel,
			dataIndex:'groupNote'
		},{ 
			header: groupIdLabel,
			dataIndex:'groupId'
		},accordionAccessValue]
	});
	
	var groupReader	= new Ext.data.JsonReader({ root:'group' }, [ 'groupId', 'groupNote']);
	var groupStore 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'../controller/accordionAccessController.php?method=read&field=groupId&leafId='+leafId,
					method:'GET'
				}),
			reader		:	groupReader,
			remoteSort	:	false 
	});
	groupStore.load();	
	
	var groupId  		=	new Ext.ux.form.ComboBoxMatch({ 
		labelAlign			:	'left',
		fieldLabel			:   groupIdLabel,
		name				:  	'groupId',
		hiddenName			:	'groupId',
		valueField			:  	'groupId',
		id					:	'group_fake',
		displayField		:	'groupNote',
		typeAhead			: 	false,
    	triggerAction		: 	'all',
		store				: 	groupStore,
		anchor      		:	'95%',
		selectOnFocus		:	true,
		mode				:	'local',
		allowBlank			: 	false ,
		blankText			:	blankTextLabel,
		createValueMatcher	: function(value) {
        	value = String(value).replace(/\s*/g, '');
        	if(Ext.isEmpty(value, false)){
            	return new RegExp('^');
        	}
        	value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
        	return new RegExp('\\b(' + value + ')', 'i');
    	},
    	listeners		:	{
			'select'	:	function (combo,record,index) {
				if(this.value =='' ) { 
					gridPanel.disable();
				} else { 
					gridPanel.enable(); 
				}
				accordionAccessStore.proxy= new Ext.data.HttpProxy({
					url			: 	'../controller/accordionAccessController.php',
					method		: 'POST',
					params		: {
						leafId : leafId,
						groupId : Ext.getCmp('group_fake').getValue()
					}
								
				});

				accordionAccessStore.reload();
			}
	}
	});
	
	var formPanel = new Ext.Panel({
		region	:	'center',
		layout	:	'form',
		frame	:	true,
		title	:	'Accordian Access Form',
		iconCls	: 	'application_form',
		items	:	[groupId]							  
	});
	
	var access_array = ['accordionAccessValue'];
	var gridPanel = new Ext.grid.GridPanel({ 
		region		:	'west',
		store		:	accordionAccessStore,
		cm			:	columnModel,
		frame		:	true,
		title		:	'Accordian Access Grid',
		height      :   200,
		autoHeight	:	true,
		autoScroll  :   true,
		layout      :   'anchor',
		disabled	:	true,
		selModel	: 	accordionAccessValue,
		iconCls		:	'application_view_detail',
		tbar 		: 	{ 
			items:[{
				   		text:'Check All',
						iconCls:'row-check-sprite-check',
						listeners : { 
							'click':function () {
								var count = accordionAccessStore.getCount();
								 accordionAccessStore.each(function(rec) {
									for (var access in access_array) { 
										// alert(access);
										rec.set(access_array[access], true);
									}
								 });
							} 
						} 
				   },{
				   		text:'Clear All',
						iconCls:'row-check-sprite-uncheck',
						listeners : { 
							'click':function () { 
								 accordionAccessStore.each(function(rec) {
									for (var access in access_array) { 
										rec.set(access_array[access], false);
									}
								 });
							} 
						}
				   },{ 
				text: saveButtonLabel,
				iconCls:'bullet_disk',
				listeners: { 
					'click':function(c) { 
					var url;
					var count = accordionAccessStore.getCount();

					url ='../controller/accordionAccessController.php?method=update&leafId='+leafId;
					var sub_url;
					sub_url='';
					 for (i = count - 1; i >= 0; i--) {
						var record = accordionAccessStore.getAt(i);
						sub_url = sub_url+'&accordionAccessId[]='+record.get('accordionAccessId')+'&accordionAccessValue[]='+record.get('accordionAccessValue');
					}
					url = url+sub_url;
					// reques and ajax
					Ext.Ajax.request ({ 
						url:url,
						success:function(response,options) { 
							Ext.MessageBox.alert('success updated');
							// reload the store
								accordionAccessStore.proxy= new Ext.data.HttpProxy({
									url			: 	'../controller/accordionAccessController.php?method=read&groupId=' + Ext.getCmp('group_fake').value,
									method		: 'POST'
								});
								
							accordionAccessStore.reload(); 
							x = Ext.decode(response.responseText);
							title='Updated ';
							if(x.success=='true') {
								title = title + ' True';
								Ext.MessageBox.alert(title,x.message); 
							} else if (x.success=='false') { 
								title = title + 'False';
								Ext.MessageBox.alert(systemLabel,x.message); 
							}		
						} ,
						failure : function(response, options) 
							{
								status_code = response.status;
								status_message = response.statusText;
								Ext.MessageBox.alert(systemErrorLabel,escape(status_code)
								+ ":"+ status_message);
							} 
					});	
					// refresh the store
					}

				} 
			}]
		}
	});
	
		var viewPort		=	new Ext.Viewport({
			id			 	:	'viewport',
			layout			:	'form',
			frame			:	true,
			items			:	[formPanel,gridPanel]
		});
	});
	