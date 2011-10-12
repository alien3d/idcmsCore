Ext.onReady(function(){
	
		var pageCreate;
	    var pageReload;
	    var pagePrint;
		if(leafCreateAccessValue  == 1 ) {
			var pageCreate = false;
		} else { 
			var pageCreate = true;
		}
		if(leafAccessReadValue  == 1 ){ 
			var pageReload=false;
		} else { 
			var pageReload=true;
		} 
		if(leafAccessPrintValue == 1 ) {
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
					leafId : leafId
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
		leafAccessReader = new Ext.data.JsonReader({
		      totalProperty: "total",
		        successProperty: "success",
		        messageProperty: "message",
		        idProperty: "leafAccessId"
				
		});
		
		var leafAccessStore 			= 	new Ext.data.JsonStore({
			autoDestroy		:	true,
			proxy 			: leafAccessProxy,
			reader			: leafAccessReader,
			root : "data",
			fields : [{	name		:	'moduleId',
                type        :   'int'					
		    },{
		 	    name		:	'leafAccessId',
                type        :   'int'							
		    },{
				name		:	'moduleNote',
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
				name		: 	'leafAccessReadValue',
                type        :   'boolean'							
			},{
				name		: 	'leafAccessUpdateValue',
                type        :   'boolean'							
			},{
				name		: 	'leafAccessDeleteValue',
                type        :   'boolean'							
			},{
				name		: 	'leafAccessPrintValue',
                type        :   'boolean'							
			},{
				name		: 	'leafAccessPostValue',
                type        :   'boolean'							
			}
		]
		});
		
		   var groupProxy = new Ext.data.HttpProxy({
		        url: "../controller/folderAccessController.php",
		        method: 'GET',
		        baseParams: {
		            method: "read",
		            leafId: leafId,
		            field:"groupId"
		        },
		        success: function (response, options) {
		            var jsonResponse = Ext.decode(response.responseText);
		            if (jsonResponse == "true") {
		                title = successLabel;
		            } else {
		               
		                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
		            }
		            
		        },
		        failure: function (response, options) {

		            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
		        }
		    });
		    var groupReader = new Ext.data.JsonReader({
		        totalProperty: "total",
		        successProperty: "success",
		        messageProperty: "message",
		        idProperty: "groupId"
		    });
		    
		    var groupStore = new Ext.data.JsonStore({
		        autoLoad : true,
		    	autoDestroy: true,
		        proxy: groupProxy,
		        reader: groupReader,
		        root: 'group',
		        fields:[{
		        	name:'groupId',
		        	type:'int'
		        },{
		        	name:'groupNote',
		        	type:'string'
		        }]
		        
		    });
		   
		    var moduleProxy = new Ext.data.HttpProxy({
		        url: "../controller/folderAccessController.php",
		        method: 'GET',
		        baseParams: {
		            method: "read",
		            leafId: leafId,
		            field:"moduleId"
		        },
		        success: function (response, options) {
		            var jsonResponse = Ext.decode(response.responseText);
		            if (jsonResponse == "true") {
		                title = successLabel;
		            } else {
		               
		                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
		            }
		            
		        },
		        failure: function (response, options) {

		            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
		        }
		    });

		    var moduleReader = new Ext.data.JsonReader({
		        totalProperty: "total",
		        successProperty: "success",
		        messageProperty: "message",
		        idProperty: "moduleId"
		    });
		    var moduleStore = new Ext.data.JsonStore({
		     	autoDestroy: true,
		         proxy: moduleProxy,
		         reader: moduleReader,
		         root: 'module',
		    	fields:[{
		    		name:'moduleId',
		    		type:'int'
		    	},{
		    		name:'moduleNote',
		    		type:'string'
		    	}]
		    	
		    });	
		    
		    var foldeProxy = new Ext.data.HttpProxy({
		        url: "../controller/folderAccessController.php",
		        method: 'GET',
		        baseParams: {
		            method: "read",
		            leafId: leafId,
		            field:"folderId"
		        },
		        success: function (response, options) {
		            var jsonResponse = Ext.decode(response.responseText);
		            if (jsonResponse == "true") {
		                title = successLabel;
		            } else {
		               
		                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
		            }
		            
		        },
		        failure: function (response, options) {

		            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
		        }
		    });

		    var folderReader = new Ext.data.JsonReader({
		        totalProperty: "total",
		        successProperty: "success",
		        messageProperty: "message",
		        idProperty: "folderId"
		    });
		    var folderStore = new Ext.data.JsonStore({
		     	autoDestroy: true,
		         proxy: folderProxy,
		         reader: folderReader,
		         root: 'folder',
		    	fields:[{
		    		name:'folderId',
		    		type:'int'
		    	},{
		    		name:'folderNote',
		    		type:'string'
		    	}]
		    	
		    });		
	
  var  leafCreateAccessValue = new Ext.grid.CheckColumn({
       header: leafCreateAccessValueLabel,
       dataIndex: 'leafCreateAccessValue',
	   id		:	'leafCreateAccessValue',
       width: 55
  });
  
  var  leafAccessReadValue = new Ext.grid.CheckColumn({
       header: leafAccessReadValueLabel,
       dataIndex: 'leafAccessReadValue',
	   id:'leafAccessReadValue',
       width: 55
  });
  
  var  leafAccessUpdateValue = new Ext.grid.CheckColumn({
       header: leafAccessUpdateValueLabel,
       dataIndex: 'leafAccessUpdateValue',
	   id:'leafAccessUpdateValue',
       width: 55
  });
  
  var  leafAccessDeleteValue = new Ext.grid.CheckColumn({
       header: leafAccessDeleteValueLabel,
       dataIndex: 'leafAccessDeleteValue',
	   id:'leafAccessDeleteValue',
       width: 55
  });
  
  var  leafAccessPrintValue = new Ext.grid.CheckColumn({
       header: leafAccessPrintValueLabel,
       dataIndex: 'leafAccessPrintValue',
	   id:'leafAccessPrintValue',
       width: 55
  });
  
  
  var  leafAccessPostValue = new Ext.grid.CheckColumn({
       header: leafAccessPostValueLabel,
       dataIndex: 'leafAccessPostValue',
	   id:'leafAccessPostValue',
       width: 55
  });
  

	// the id for administrator to see  in any problem.User cannot see this page information
	var columnModel = new Ext.grid.ColumnModel({
		columns:[{ 
			header		:	moduleNameLabel,
			dataIndex	:	'moduleNote'
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
		},leafCreateAccessValue,leafAccessReadValue,leafAccessUpdateValue,leafAccessDeleteValue,leafAccessPrintValue,leafAccessPostValue]
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
				Ext.getCmp('moduleId').reset();
				moduleStore.proxy= new Ext.data.HttpProxy({
					url			: 	'leaf_group_sec_data.php?method=read&field=moduleId&groupId=' + Ext.getCmp('groupId').getValue()+'&leafId='+leafId,
					method		:	'GET'
				});

				moduleStore.reload();
				Ext.getCmp('moduleId').enable();
				Ext.getCmp('gridPanel').enable();
				leafAccessStore.proxy= new Ext.data.HttpProxy({
					url		: 	'leaf_group_sec_data.php?groupId='+Ext.getCmp('groupId').getValue()+'&leafId='+leafId,
					method	:	'GET'					
				});
				leafAccessStore.reload();
			}
		}
	});
	
	var	moduleId  		=	new Ext.ux.form.ComboBoxMatch({ 
		labelAlign			:	'left',
		fieldLabel			:   moduleIdLabel,
		name				:  	'moduleId',
		hiddenName			:	'moduleId',
		valueField			:  	'moduleId',
		id					:	'module_fake',
		displayField		:	'moduleNote',
		typeAhead			: 	false,
    	triggerAction		: 	'all',
		store				: 	moduleStore,
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
					url			: 	'leaf_group_sec_data.php?method=read&field=folderId&groupId='+Ext.getCmp('groupId').getValue()+'&moduleId=' +Ext.getCmp('moduleId').getValue()+'&leafId='+leafId,
					method		:	'GET'
				});

				folderStore.reload();
				Ext.getCmp('folderId').enable();
				Ext.getCmp('gridPanel').enable();
				leafAccessStore.proxy= new Ext.data.HttpProxy({
					url		: 	'leaf_group_sec_data.php?groupId='+Ext.getCmp('groupId').getValue()+'&moduleId='+Ext.getCmp('moduleId').getValue()+'&leafId='+leafId,
					method	:	'GET'					
				});
				leafAccessStore.reload();
			}
		}
	});
	
	var	folderId  		=	new Ext.ux.form.ComboBoxMatch({ 
		labelAlign			:	'left',
		fieldLabel			:   moduleIdLabel,
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
					url			: 	'leaf_group_sec_data.php?groupId='+Ext.getCmp('groupId').getValue()+'&moduleId='+Ext.getCmp('moduleId').getValue()+'&folderId=' + Ext.getCmp('folderId').getValue()+'&leafId='+leafId,
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
		store : staffByStore,
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
					url			: 	'../controller/leafAccessController.php?moduleId='+Ext.getCmp('module_fake').value+'&folderId='+Ext.getCmp('folder_fake').value+'&staffId_temp=' + this.value+'&leafId='+leafId,
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
		items	:	[groupId,moduleId,folderId,staffId]
									  
	});
	var  access_array = ['leafCreateAccessValue','leafAccessReadValue','leafAccessUpdateValue','leafAccessDeleteValue','leafAccessPrintValue','leafAccessPostValue'];
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
							leafAccessReadValue,
							leafAccessUpdateValue,
							leafAccessDeleteValue,
							leafAccessPrintValue,
							leafAccessPostValue
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

					url ='../controller/leafAccessController.php?method=update&leafId='+leafId;
					var sub_url;
					sub_url='';
					 for (i = count - 1; i >= 0; i--) {
						var record = leafAccessStore.getAt(i);
						sub_url = sub_url + '&leafAccessId[]='+record.get('leafAccessId');
						sub_url = sub_url + '&leafCreateAccessValue[]='+record.get('leafCreateAccessValue');
						sub_url = sub_url + '&leafAccessReadValue[]='+record.get('leafAccessReadValue');
						sub_url = sub_url + '&leafAccessUpdateValue[]='+record.get('leafAccessUpdateValue');
						sub_url = sub_url + '&leafAccessDeleteValue[]='+record.get('leafAccessDeleteValue');
						sub_url = sub_url + '&leafAccessPrintValue[]='+record.get('leafAccessPrintValue');
						sub_url = sub_url + '&leafAccessPostValue[]='+record.get('leafAccessPostValue');
					}
					url = url+sub_url;
					// reques and ajax
					Ext.Ajax.request ({ 
						url:url,
						success:function(response,options) {
							jsonResponse = Ext.decode(response.responseText);
							var title ='Message';
							if(jsonResponse.message=='true') { 
								title  = title +'Success';
								Ext.MessageBox.alert(title,jsonResponse.message);
							} else if (jsonResponse.message=='false'){
								title  = title +'Failure';
								Ext.MessageBox.alert(title,jsonResponse.message);
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
