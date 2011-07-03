Ext.onReady(function(){
		Ext.form.Field.prototype.msgTarget = 'under';
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
		var leafGroupAccessProxy  =  new Ext.data.HttpProxy({
				url : "../controller/leaf/GroupAccessController.php",
				method : 'POST',
				baseParams : {
					method : "read",
					page : "master",
					leafId_temp : leafId_temp
				},
				success : function(response, options) {
					var jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse == "true") {
						title = successLabel;
					} else {
						title = failureLabel;
					}
					Ext.MessageBox.alert(systemLabel, jsonResponse.message);
				},
				failure : function(response, options) {

					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ":"
									+ escape(response.statusText));
				}
			});
		var leafGroupAccessReader = new Ext.data.JsonReader({
				root : "data",
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				fields : [{	name		:	'accordionId',
                            type        :   'int'					
					    },{
					 	    name		:	'leafGroupAccessId',
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
						 	name		:	'staffName',
                            type        :   'string'							
						},{
						    name		:	'staffId',
                            type        :   'int'							
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
		var leafGroupAccessStore 		 = 	 new Ext.data.JsonStore({
			autoDestroy		:	true,
			proxy : leafGroupAccessProxy,
			reader : leafGroupAccessReader
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
	
	var groupReader	= new Ext.data.JsonReader({ root:'group' }, [ 'groupId', 'groupNote']);
	var groupStore 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'../controller/leafGroupAccessController.php?method=read&field=groupId&leafId_temp='+leafId_temp,
					method:'GET'
				}),
			reader		:	groupReader,
			remoteSort	:	false 
	});
	groupStore.load();
	
	var accordionReader	= new Ext.data.JsonReader({ root:'accordion' }, [ 'accordionId', 'accordionNote']);
	var accordionStore 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'../controller/leafGroupAccessController.php?method=read&field=accordionId&leafId_temp='+leafId_temp,
					method:'GET'
				}),
			reader		:	accordionReader,
			remoteSort	:	false 
	});
	
	var folderReader	= new Ext.data.JsonReader({ root:'folder' }, [ 'folderId', 'folderNote']);
	var folderStore 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'../controller/leafGroupAccessController.php?method=read&field=folderId&leafId_temp='+leafId_temp,
					method:'GET'
				}),
			reader		:	folderReader,
			remoteSort	:	false 
	});
	
	var staffReader	= new Ext.data.JsonReader({ root:'staff' }, [ 'staffId', 'staffName']);
	var staffStore 		= 	new Ext.data.Store({
			proxy		: 	new Ext.data.HttpProxy({
        			url	: 	'../controller/leafGroupAccessController.php?method=read&field=staffId&leafId_temp='+leafId_temp,
					method:'GET'
				}),
			reader		:	staffReader,
			remoteSort	:	false 
	});
	
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
				accordion_store.proxy= new Ext.data.HttpProxy({
					url			: 	'../controller/leafGroupAccessController.php?method=read&field=accordionId&groupId=' + Ext.getCmp('groupId').getValue()+'&leafId_temp='+leafId_temp,
					method		:	'GET'
				});

				accordion_store.reload();
				Ext.getCmp('accordionId').enable();
				Ext.getCmp('gridPanel').enable();
				leafGroupAccessStore.proxy= new Ext.data.HttpProxy({
					url		: 	'../controller/leafGroupAccessController.php?groupId='+Ext.getCmp('groupId').getValue()+'&leafId_temp='+leafId_temp,
					method	:	'GET'					
				});
				leafGroupAccessStore.reload();
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
				folder_store.proxy= new Ext.data.HttpProxy({
					url			: 	'../controller/leafGroupAccessController.php?method=read&field=folderId&groupId='+Ext.getCmp('groupId').getValue()+'&accordionId=' +Ext.getCmp('accordionId').getValue()+'&leafId_temp='+leafId_temp,
					method		:	'GET'
				});

				folder_store.reload();
				Ext.getCmp('folderId').enable();
				Ext.getCmp('gridPanel').enable();
				leafGroupAccessStore.proxy= new Ext.data.HttpProxy({
					url		: 	'../controller/leafGroupAccessController.php?groupId='+Ext.getCmp('groupId').getValue()+'&accordionId='+Ext.getCmp('accordionId').getValue()+'&leafId_temp='+leafId_temp,
					method	:	'GET'					
				});
				leafGroupAccessStore.reload();
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
				leafGroupAccessStore.proxy= new Ext.data.HttpProxy({
					url			: 	'../controller/leafGroupAccessController.php?groupId='+Ext.getCmp('groupId').getValue()+'&accordionId='+Ext.getCmp('accordionId').getValue()+'&folderId=' + Ext.getCmp('folderId').getValue()+'&leafId_temp='+leafId_temp,
					method:'GET'					
				});
					leafGroupAccessStore.reload();
			
			}
		}
	});
	// compare with the user leaf.Here Accordian and Folder just filtering mode
	var formPanel = new Ext.Panel({
		region	:	'north',
		layout	:	'form',
		frame	:	true,
		title	:	'leaf Form',
		iconCls	:	'application_form',
		autoScroll 	:true, 
		items	:	[groupId,accordionId,folderId]							  
	});
	var  access_array = ['leafCreateAccessValue','leafReadAccessValue','leafUpdateAccessValue','leafDeleteAccessValue','leafPrintAccessValue','leafPostAccessValue'];
	var grid = new Ext.grid.GridPanel({ 
		region		:	'west',
		id			:	'gridPanel',
		store		:	leafGroupAccessStore,
		cm			:	columnModel,
		frame		:	true,
		
		title		:	'leaf Access Grid',
		disabled	:	true,
        iconCls		:	'application_view_detail',
		viewConfig			: {		emptyText :	'No rows to display' },
		autoScroll: true,
		autoHeight : false,
		height:400,
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
								var count = leafGroupAccessStore.getCount();
								 leafGroupAccessStore.each(function(rec) {
									for (var access in access_array) { 
										//alert(access);
										rec.set(access_array[access], true);
									}
								 });
							} 
						} 
				   },{
				   		text:ClearAllLabel,
						iconCls:'row-check-sprite-uncheck',
						listeners : { 
							'click':function () { 
								 leafGroupAccessStore.each(function(rec) {
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
					var count = leafGroupAccessStore.getCount();

					url ='../controller/leafGroupAccessController.php?method=update&leafId_temp='+leafId_temp;
					var sub_url;
					sub_url='';
					 for (i = count - 1; i >= 0; i--) {
						var record = leafGroupAccessStore.getAt(i);
						sub_url = sub_url +record.get('leafGroupAccessId')+',';
						sub_url = sub_url +record.get('leafCreateAccessValue')+',';
						sub_url = sub_url +record.get('leafReadAccessValue')+',';
						sub_url = sub_url +record.get('leafUpdateAccessValue')+',';
						sub_url = sub_url +record.get('leafDeleteAccessValue')+',';
						sub_url = sub_url +record.get('leafPrintAccessValue')+',';
						sub_url = sub_url +record.get('leafPostAccessValue');
						sub_url  = sub_url+'|'; // this is to diffirenciate the array field
					}
				//	url = url+sub_url;
					// using post method  because limitation  $_GET value post on all browser.
					Ext.Ajax.request ({ 
						url:url,
						params:{ info: sub_url } ,
						method:'POST',
						success:function(response,options) {
							jsonResponse = Ext.decode(response.responseText);
							if (jsonResponse == false){
								Ext.MessageBox.alert('System Error',jsonResponse.message);
							} else { 
								Ext.MessageBox.alert('System Okay','success updated');
							}
							
							// reload the store 
							leafGroupAccessStore.reload(); 
						} ,
						failure : function(response, options) 
							{
								statusCode = response.status;
								statusMessage = response.statusText;
								Ext.MessageBox.alert(systemLabel,escape(statusCode)
								+ ":"+ statusMessage);
							}
						/*failure:function(response,options) { 
							var title='Message Failure';
							if (action.failureType === Ext.form.Action.LOAD_FAILURE){
							    alert("Client ada Error 1 ");
							}
							else if (action.failureType === Ext.form.Action.CLIENT_INVALID){
							    // here will be error if duplicate code
							    alert("Client ada Error 2");
							}
							else if (action.failureType === Ext.form.Action.CONNECT_FAILURE){
                                Ext.Msg.alert('Failure', 'Server reported:'+form.response.status+' '+form.response.statusText);
                            }
                            else if (action.failureType === Ext.form.Action.SERVER_INVALID){
                                Ext.Msg.alert(title, action.result.message);
                            }
						}*/ 
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
			items			:	[formPanel,grid]
		});
	});
