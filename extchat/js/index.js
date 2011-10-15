Ext.onReady(function(){
	Ext.QuickTips.init();

	var frmLogin = {
		//title: 'Login Terlebih Dahulu',
		//iconCls:'app_icon',
		layout:'hbox',
        layoutConfig: {
        	padding:'5',
        	pack:'center',
        	align:'middle'
    	},	
		items:[
		{
			id:'frm-login',
			xtype:'form',
			title:'Enter Your Nickname',
			width:300,
			autoHeight:true,
			url:'remote.php',
			labelAlign:'top',
			frame:true,
			labelWidth:70,
			bodyStyle:'padding:5px;',
			items:[{
				layout:'column',
				items:[
				{
					layout:'form',
					columnWidth:.2,
					xtype:'box',
				   autoEl: { tag: 'div',
							 html: '<img id="pic" src=images/amsn.png style="background:transparent;" />'
					}					
				},
				{
					layout:'form',
					columnWidth:.8, 
					items:[
						{
							xtype:'textfield',
							name:'txtuser',
							labelSeparator:'',
							fieldLabel:'User Name',
							anchor:'100%',
							vtype:'alphanum',
							maxLength:14,
							maxLengthText:'Karakter tidak Boleh Lebih dari 10',
							allowBlank:false,
							enableKeyEvents : true,
							listeners: {
								specialkey: function(o, e){
									if (e.getKey() == e.ENTER){
										if (Ext.getCmp('frm-login').getForm().isValid()){
											Ext.getCmp('content_panel').body.mask('Validating Nick Name','x-mask-loading'); 
											Ext.getCmp('frm-login').getForm().submit({
												success:function(a,b) {
													username = b.result.user;  
													Ext.getCmp('content_panel').body.unmask(); 
													Ext.getCmp('content_panel').layout.setActiveItem(1);
													Ext.getCmp('global').setTitle(username + ' on Global Chat');
													txtMsg.focus();
													repeatMsg();
													repeatsendNew();
													repeatView();
												},
												failure:function(){
													 Ext.getCmp('content_panel').body.unmask();
													Ext.MessageBox.show({
											        title: 'Alert',
											           msg: 'Nick Name sudah dipakai',
											           buttons: Ext.MessageBox.OK,
											           icon: Ext.MessageBox.ERROR
							       					});													 
												}
												
											});
										}
									}
										
								}								
							}
						}
					]
				}
				]
			}]
		}
		]
	};	

	var activeItem = (username =='')?0:1;

	var tabPanel = {
		xtype:'tabpanel',
		id:'tabPanel',
		activeItem:0,
		enableTabScroll:true,
		plugins:new Ext.ux.TabCloseMenu(),
		items:[chat]
	}; 
	
	var content_panel = {
		id:'content_panel',
		iconCls:'app_icon',
		region:'center',
		border:false,
		margins:'10 10 10 10',
		frame:false,
		layout:'card',
		activeItem:activeItem,
		items:[frmLogin,tabPanel]
	}; 	
	
	main_panel = new Ext.Viewport({
		border:false,
		id:'main_panel',
		layout:'border', 
		items: [
			content_panel
		],
		renderTo:Ext.getBody()
	}); 	
}); 