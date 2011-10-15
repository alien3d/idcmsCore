var tid_1;  
var tid_2; 
var globalArray = new Array();
var chatPriv = "request/chat.priv.php"; 
var loopTab =0; 

var sendNew = function(){
	if (globalArray.length >0){
		parameter = globalArray.shift(); 
		Ext.Ajax.request({
			url : chatPriv,
			params : parameter,
			success : function(response) {
				var res = Ext.decode(response.responseText);
				if (res.success) {
					if (Ext.get(res.tabId))
						Ext.getCmp(res.tabId).readMessages.call(Ext.getCmp(res.tabId),res.messages);
					repeatsendNew(); 
				}
			}
		});
		
	}else{
		repeatsendNew(); 
	}
}

function repeatsendNew(){
	clearTimeout(tid_1); 
	tid_1 =0; 
	sendNew.defer(updateInterval,sendNew); 
}

var retriViewNew  = function(){
	if (loopTab >0){
		itemTab = Ext.getCmp('tabPanel').get(loopTab);
		if (itemTab){
			paramY = {
				mode 	: 'RetrieveNew',
				chatid  :itemTab.chatPanel.id,
				id		:itemTab.lastMessageID,
				name	:itemTab.tUser,
				tabId	:itemTab.id
			}; 		
			Ext.Ajax.request({
				url : chatPriv,
				params : paramY,
				success : function(response) {
					var res = Ext.decode(response.responseText);
					if (res.success) {
						if (Ext.get(res.tabId))
							Ext.getCmp(res.tabId).readMessages.call(Ext.getCmp(res.tabId),res.messages);
						repeatView();  
					}
				}
			});		
		}else{
			repeatView(); 
		}
	}else {
		repeatView(); 
	}
}

function repeatView(){
	clearTimeout(tid_2); 
	tid_2 =0; 
	loopTab++;
	if (loopTab > Ext.getCmp('tabPanel').items.length -1)
		loopTab =0;
	retriViewNew.defer(updateInterval,retriViewNew); 	
	
}

privChat = Ext.extend(Ext.Panel, {
	closable:true,
	iconCls:'private-chat',
	layout:'border',
	//chatURL : "request/chat.priv.php",
	cache : new Array(),
	lastMessageID : -1,
	updateInterval : 1000, 
	paramx:null,
	tid :0,
	blink:false,
	listeners: {
		render:function(){this.repeatMessage();},
		destroy:function(){this.clearTime();},
		activate:function(){this.normalTitle()},
		deactivate:function(){this.setBlink()}
	},	
	clearTime: function(){
		clearTimeout(this.tid);
		this.tid=0;		
	},
	setBlink:function(){
		this.blink =true;
	},
	initComponent: function() {
		this.chatPanel = new Ext.form.DisplayField({
			border:true,	
			region:'center',
			cls: 'x-form-text',
			autoScroll:true
		});  
		this.NorthPanel = {
			border:false,
			margins:'2 2 2 2',	
			region:'center',
			layout:'border',
			items:[this.chatPanel]
		};	
		this.txtMsg = new Ext.form.TextField({
			region:'center',
			enableKeyEvents : true
		});	
		this.txtMsg.on('specialkey',
			function(o, e){
				if (e.getKey() == e.ENTER){
					this.sendMessage.call(this);
				}
				},
			this
		);
		this.btnSend = new Ext.Button({
			text:'Send',
			flex:1,
			handler:this.sendMessage.createDelegate(this)
		}); 		
		this.btnPanel = {
			border:false,
			region:'east',
			margins:'0 0 0 2',
			width:50,
			layout:'vbox',
		    layoutConfig: {
		    	padding:'0',
		    	align:'stretch'
			},
			items:[this.btnSend]
		}; 
		this.Spanel = {
			region:'south',
			height:30,
			layout:'border',
			border:false,
			margins:'2 2 2 2',
			items:[this.txtMsg,this.btnPanel]
		};		
		this.items = [this.NorthPanel,this.Spanel]; 		
		privChat.superclass.initComponent.apply(this, arguments);;
	},
	sendMessage:function() {	
		if (this.txtMsg.getValue() =='')
			return false; 
		this.cache.push({
			mode	:'SendAndRetrieveNew',
			chatid  :this.chatPanel.id,
			//id		:this.lastMessageID,
			name	:this.tUser,
			tabId	: this.id,
			message : this.txtMsg.getValue()
			
		}); 
		this.txtMsg.setValue(''); 
		this.txtMsg.focus();
	},	
	requestNewMessages:function(){	
		if (this.cache.length>0){
			this.paramx = this.cache.shift();	
			Ext.apply(this.paramx,{
				id	: this.lastMessageID
	
			});
			globalArray.push(this.paramx); 
		}
		this.repeatMessage.call(this);
	},
	readMessages:function(msg){
		tpl = "<div class='box-chat'><div style='color:{3};'>" +
				" <img src=\"images/comment.png\" " +
				"class=\"x-panel-inline-icon\">" +
				"[{0}] <b>{1} :</b></div>" +
				"<div style='color:blue;padding-left:20px;'>{2}</div> </div>";
		Ext.each(msg,function(r,i){
			color = (r.userName ==this.username)?'green':'olive'; 		
			html = String.format(tpl,r.time,r.userName,r.message,color); 
			this.chatPanel.append(html); 
			oScroll = this.chatPanel.el.dom; 
			scrollDown = (oScroll.scrollHeight - oScroll.scrollTop <=
						oScroll.offsetHeight );
			if (!scrollDown){			
				sc = (oScroll.scrollTop>0)?oScroll.scrollTop:oScroll.scrollHeight;
				this.chatPanel.el.scroll('b',sc, true);
			}
			if (r.userName != this.username)
			if (this.blink)
				this.blinkTitle.call(this,r.target);			
		},this); 
		if (msg.length>0){
			//this.chatPanel.el.scroll('b', 100000, true);
			this.lastMessageID = msg[msg.length-1].id;
		}
		//this.repeatMessage.call(this);
	},
	repeatMessage: function(){	
		clearTimeout(this.tid);
		this.tid=0;			
		xx = function xx(){
				this.requestNewMessages.call(this);
		}
		this.tid = xx.defer(this.updateInterval,this);		
	},
	normalTitle: function(){
		this.setTitle(this.tUser);
		this.blink = false;
		this.chatPanel.el.scroll('b', 100000, true);
		this.txtMsg.focus();
	},
	blinkTitle:function(p){
		this.setTitle(String.format("<span class='blink'>{0}</span>",p));
	}
}); 