Ext.onReady(function(){
	
		var pageCreate;
	    var pageReload;
	    var pagePrint;
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
		// form panel + grid.When choose the form then activated filter the grid.Grid will automatically update on demand
		// first viewport
		var perPage		= 	10;
		var encode 			=	false;
		var local 			= 	false;
		leafAccessProxy 	=	new Ext.data.HttpProxy({
				url : "../controller/leafAccessController.php",
				method : 'POST',
				baseParams : {
					method : "read",
					page : "master",
					leafId_temp : leafId_temp
				},
				success : function(response, options) {
					var x = Ext.decode(response.responseText);
					if (x.success == "true") {
						title = successLabel;
					} else {
						title = failureLabel;
					}
					Ext.MessageBox.alert(systemLabel, x.message);
				},
				failure : function(response, options) {

					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ":"
									+ escape(response.statusText));
				}
			});
		leafAccessReader = new Ext.data.JsonReader({
				root : "data",
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				fields : [{	name		:	'accordionId',
                            type        :   'int'					
					    },{
					 	    name		:	'leafAccessId',
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
							name		:	'folderId',
                            type        :   'int'							
						},{
						    name		:	'folderNote',
                            type        :   'string'							
						},{
						    name		:	'leafId',
                            type        :   'int'							
						},{
						    name		:	'leafNote',
                            type        :   'string'							
						},{
						 	name		: 	'leafCreateAccessValue',
                            type        :   'boolean'							
						},{
							name		: 	'leafReadAccessValue',
                            type        :   'boolean'							
						},{
							name		: 	'leafUpdateAccessValue',
                            type        :   'boolean'							
						},{
							name		: 	'leafDeleteAccessValue',
                            type        :   'boolean'							
						},{
							name		: 	'leafPrintAccessValue',
                            type        :   'boolean'							
						},{
							name		: 	'leafPostAccessValue',
                            type        :   'boolean'							
						}
					]
		});
		
		var leafAccessStore 			= 	new Ext.data.JsonStore({
			autoDestroy		:	true,
			proxy 			: leafAccessProxy,
			reader			: leafAccessReader
		});
	
  var  leafCreateAccessValue = new Ext.grid.CheckColumn({
       header: leafCreateAccessValueLabel,
       dataIndex: 'leafCreateAccessValue',
	   id		:	'leafCreateAccessValue',
       width: 55
  });
  
  var  leafReadAccessValue = new Ext.grid.CheckColumn({
       header: leafReadAccessValueLabel,
       dataIndex: 'leafReadAccessValue',
	   id:'leafReadAccessValue',
       width: 55
  });
  
  var  leafUpdateAccessValue = new Ext.grid.CheckColumn({
       header: leafUpdateAccessValueLabel,
       dataIndex: 'leafUpdateAccessValue',
	   id:'leafUpdateAccessValue',
       width: 55
  });
  
  var  leafDeleteAccessValue = new Ext.grid.CheckColumn({
       header: leafDeleteAccessValueLabel,
       dataIndex: 'leafDeleteAccessValue',
	   id:'leafDeleteAccessValue',
       width: 55
  });
  
  var  leafPrintAccessValue = new Ext.grid.CheckColumn({
       header: leafPrintAccessValueLabel,
       dataIndex: 'leafPrintAccessValue',
	   id:'leafPrintAccessValue',
       width: 55
  });
  
  
  var  leafPostAccessValue = new Ext.grid.CheckColumn({
       header: leafPostAccessValueLabel,
       dataIndex: 'leafPostAccessValue',
	   id:'leafPostAccessValue',
       width: 55
  });
  

	// the id for administrator to see  in any problem.User cannot see this page information
	var columnModel = new Ext.grid.ColumnModel({
		columns:[{ 
			header		:	accordionNameLabel,
			dataIndex	:	'accordionNote'
		},{
			header		:	groupNameLabel,
			dataIndex	:	'groupNote'
		},{
			header		:	folderNameLabel,
			dataIndex	:	'folderNote'
		},{
			header		:	leafNoteLabel,
			dataIndex	:	'leafNote'
		},{
			header		:	staffNameLabel,
			dataIndex	:	'staffName'
		},leafCreateAccessValue,leafReadAccessValue,leafUpdateAccessValue,leafDeleteAccessValue,leafPrintAccessValue,leafPostAccessValue]
	});
	
	var group_reader	= new Ext.data.JsonReader({ root:'group' }, [ 'groupId', 'groupNote']);
	var groupStore 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'../controller/leafAccessController.php?method=read&field=groupId&leafId_temp='+leafId_temp,
					method:'GET'
				}),
			reader		:	group_reader,
			remoteSort	:	false 
	});
	groupStore.load();
	
	var accordionReader	= new Ext.data.JsonReader({ root:'accordion' }, [ 'accordionId', 'accordionNote']);
	var accordionStore 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'../controller/leafAccessController.php?method=read&field=accordionId&leafId_temp='+leafId_temp,
					method:'GET'
				}),
			reader		:	accordionReader,
			remoteSort	:	false 
	});
	accordionStore.load();
	
	var folderReader	= new Ext.data.JsonReader({ root:'folder' }, [ 'folderId', 'folderNote']);
	var folderStore 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'../controller/leafAccessController.php?method=read&field=folderId&leafId_temp='+leafId_temp,
					method:'GET'
				}),
			reader		:	folderReader,
			remoteSort	:	false 
	});
	folderStore.load();	
	
	var staffReader	= new Ext.data.JsonReader({ root:'staff' }, [ 'staffId', 'staffName']);
	var staffStore 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'../controller/leafAccessController.php?method=read&field=staffId&leafId_temp='+leafId_temp,
					method:'GET'
				}),
			reader		:	staffReader,
			remoteSort	:	false 
	});
	staffStore.load();	
	
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
				Ext.getCmp('accordionId').reset();
				accordionStore.proxy= new Ext.data.HttpProxy({
					url			: 	'leaf_group_sec_data.php?method=read&field=accordionId&groupId=' + Ext.getCmp('groupId').getValue()+'&leafId_temp='+leafId_temp,
					method		:	'GET'
				});

				accordionStore.reload();
				Ext.getCmp('accordionId').enable();
				Ext.getCmp('gridPanel').enable();
				leafAccessStore.proxy= new Ext.data.HttpProxy({
					url		: 	'leaf_group_sec_data.php?groupId='+Ext.getCmp('groupId').getValue()+'&leafId_temp='+leafId_temp,
					method	:	'GET'					
				});
				leafAccessStore.reload();
			}
		}
	});
	
	var	accordionId  		=	new Ext.ux.form.ComboBoxMatch({ 
		labelAlign			:	'left',
		fieldLabel			:   accordionIdLabel,
		name				:  	'accordionId',
		hiddenName			:	'accordionId',
		valueField			:  	'accordionId',
		id					:	'accordion_fake',
		displayField		:	'accordionNote',
		typeAhead			: 	false,
    	triggerAction		: 	'all',
		store				: 	accordionStore,
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
    	disabled		:	true,
		listeners		:	{
			'select'	:	function (combo,record,index) {
				Ext.getCmp('folderId').reset();
				folderStore.proxy= new Ext.data.HttpProxy({
					url			: 	'leaf_group_sec_data.php?method=read&field=folderId&groupId='+Ext.getCmp('groupId').getValue()+'&accordionId=' +Ext.getCmp('accordionId').getValue()+'&leafId_temp='+leafId_temp,
					method		:	'GET'
				});

				folderStore.reload();
				Ext.getCmp('folderId').enable();
				Ext.getCmp('gridPanel').enable();
				leafAccessStore.proxy= new Ext.data.HttpProxy({
					url		: 	'leaf_group_sec_data.php?groupId='+Ext.getCmp('groupId').getValue()+'&accordionId='+Ext.getCmp('accordionId').getValue()+'&leafId_temp='+leafId_temp,
					method	:	'GET'					
				});
				leafAccessStore.reload();
			}
		}
	});
	
	var	folderId  		=	new Ext.ux.form.ComboBoxMatch({ 
		labelAlign			:	'left',
		fieldLabel			:   accordionIdLabel,
		name				:  	'folderId',
		hiddenName			:	'folderId',
		valueField			:  	'folderId',
		id					:	'folder_fake',
		displayField		:	'folderNote',
		typeAhead			: 	false,
    	triggerAction		: 	'all',
		store				: 	folderStore,
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
    	disabled		:	true,
    	listeners		:	{
			'select'	:	function (combo,record,index) {
				if(this.value =='' ) { 
					Ext.getCmp('gridPanel').disable();
				} else { 
					Ext.getCmp('gridPanel').enable();
				}
				leafAccessStore.proxy= new Ext.data.HttpProxy({
					url			: 	'leaf_group_sec_data.php?groupId='+Ext.getCmp('groupId').getValue()+'&accordionId='+Ext.getCmp('accordionId').getValue()+'&folderId=' + Ext.getCmp('folderId').getValue()+'&leafId_temp='+leafId_temp,
					method:'GET'					
				});
					leafAccessStore.reload();
			
			}
		}
	});
	
	var	staffId  		=	new Ext.ux.form.ComboBoxMatch({ 
		labelAlign			:	'left',
		fieldLabel			:   staffIdLabel,
		name				:  	'staffId',
		hiddenName			:	'staffId',
		valueField			:  	'staffId',
		id					:	'staff_fake',
		displayField		:	'staffName',
		typeAhead			: 	false,
    	triggerAction		: 	'all',
		store				: 	staffStore,
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
    	disabled		:	true,
    	listeners		:	{
			'select'	:	function (combo,record,index) {
				if(this.value =='' ) { 
					gridPanel.disable();
				} else { 
					gridPanel.enable(); 
				}
				leafAccessStore.proxy= new Ext.data.HttpProxy({
					url			: 	'../controller/leafAccessController.php?accordionId='+Ext.getCmp('accordion_fake').value+'&folderId='+Ext.getCmp('folder_fake').value+'&staffId_temp=' + this.value+'&leafId_temp='+leafId_temp,
					method:'GET'					
				});

					leafAccessStore.reload();
					gridPanel.store.reload(); // force the grid the reload
			
			}
		}
	});
	var formPanel = new Ext.Panel({
		region	:	'center',
		layout	:	'form',
		frame	:	true,
		title	:	'leaf Form',
		iconCls	:	'application_form',
		items	:	[groupId,accordionId,folderId,staffId]
									  
	});
	var  access_array = ['leafCreateAccessValue','leafReadAccessValue','leafUpdateAccessValue','leafDeleteAccessValue','leafPrintAccessValue','leafPostAccessValue'];
	var gridPanel = new Ext.grid.GridPanel({ 
		region		:	'west',
		store		:	leafAccessStore,
		cm			:	columnModel,
		autoHeight  :   false,
		height      : 	360,
		frame		:	true,
		title		:	'Leaf Access Grid',
		disabled	:	true,
        iconCls		:	'application_view_detail',
		plugins		: 	[	
					   		leafCreateAccessValue,
							leafReadAccessValue,
							leafUpdateAccessValue,
							leafDeleteAccessValue,
							leafPrintAccessValue,
							leafPostAccessValue
						],
		tbar 		: 	{ 
			items:[{
				   		text: CheckAllLabel,
						iconCls:'row-check-sprite-check',
						listeners : { 
							'click':function () {
								var count = leafAccessStore.getCount();
								 leafAccessStore.each(function(rec) {
									for (var access in access_array) { 
										//alert(access);
										rec.set(access_array[access], true);
									}
								 });
							} 
						} 
				   },{
				   		text: ClearAllLabel,
						iconCls:'row-check-sprite-uncheck',
						listeners : { 
							'click':function () { 
								 leafAccessStore.each(function(rec) {
									for (var access in access_array) { 
										rec.set(access_array[access], false);
									}
								 });
							} 
						}
				   },{ 
				text:saveButtonLabel,
				iconCls:'bullet_disk',
				listeners: { 
					'click':function(c) { 
					var url;
					var count = leafAccessStore.getCount();

					url ='../controller/leafAccessController.php?method=update&leafId_temp='+leafId_temp;
					var sub_url;
					sub_url='';
					 for (i = count - 1; i >= 0; i--) {
						var record = leafAccessStore.getAt(i);
						sub_url = sub_url + '&leafAccessId[]='+record.get('leafAccessId');
						sub_url = sub_url + '&leafCreateAccessValue[]='+record.get('leafCreateAccessValue');
						sub_url = sub_url + '&leafReadAccessValue[]='+record.get('leafReadAccessValue');
						sub_url = sub_url + '&leafUpdateAccessValue[]='+record.get('leafUpdateAccessValue');
						sub_url = sub_url + '&leafDeleteAccessValue[]='+record.get('leafDeleteAccessValue');
						sub_url = sub_url + '&leafPrintAccessValue[]='+record.get('leafPrintAccessValue');
						sub_url = sub_url + '&leafPostAccessValue[]='+record.get('leafPostAccessValue');
					}
					url = url+sub_url;
					// reques and ajax
					Ext.Ajax.request ({ 
						url:url,
						success:function(response,options) {
							x = Ext.decode(response.responseText);
							var title ='Message';
							if(x.message=='true') { 
								title  = title +'Success';
								Ext.MessageBox.alert(title,x.message);
							} else if (x.message=='false'){
								title  = title +'Failure';
								Ext.MessageBox.alert(title,x.message);
							}	 
							
							// reload the store 
							leafAccessStore.reload(); 
						} ,
						failure : function(response, options) 
							{
								status_code = response.status;
								status_message = response.statusText;
								Ext.MessageBox.alert(systemErrorLabel,escape(status_code)
								+ ":"+ status_message);
							} 
					});	
					//  refresh the store
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
