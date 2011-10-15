var chatURL = "request/chat.php";
var cache = new Array();
var lastMessageID = -1;
var updateInterval = 1000; 
var params;
var tid =0; 
var MsgSign = false; 
var userList = {
	//title:'Chat List',
	id:'userList',	
	region:'east',
	width:120,
	margins:'0 0 0 2',
	autoScroll: true,
	bodyStyle:'padding:5px;'
};

var chatPanel = new Ext.form.DisplayField({
	id:'chatPanel',
	border:true,	
	region:'center',
	cls: 'x-form-text',
	autoScroll:true
});  

var NorthPanel = {
	border:false,
	margins:'2 2 2 2',	
	region:'center',
	layout:'border',
	items:[chatPanel,userList]
};

var txtMsg = new Ext.form.TextField({
	name:'txtMsg',
	region:'center',
	enableKeyEvents : true,
	listeners: {
		specialkey: function(o, e){
			if (e.getKey() == e.ENTER)
				sendMessage(); 
		}
	}
}); 

var btnSend = new Ext.Button({
	text:'Send',
	flex:1,
	handler:function(){
		sendMessage(); 
		txtMsg.focus(); 
	}
}); 

var btnPanel = {
	border:false,
	region:'east',
	margins:'0 0 0 2',
	width:50,
	layout:'vbox',
    layoutConfig: {
    	padding:'0',
    	align:'stretch'
	},
	items:[btnSend]
}

var SouthPanel = {
	region:'south',
	height:30,
	layout:'border',
	border:false,
	margins:'2 2 2 2',
	items:[txtMsg,btnPanel]
};
var chat = {
	id:'global',
	border:false,
	title: username + ' on Global Chat',
	iconCls:'global-chat',
	layout:'border',
	items:[NorthPanel,SouthPanel],
	listeners:{
		activate:function(){
			txtMsg.focus();
			if (MsgSign)
				chatPanel.el.scroll('b', 100000, true);
			MsgSign = false;
			Ext.getCmp('global').setTitle(username + ' on Global Chat');
		},
		deactivate:function(){
			MsgSign =true; 
		}
	}
};

function sendMessage() {
	if (txtMsg.getValue() =='')
		return false; 
	cache.push({
		mode	:'SendAndRetrieveNew',
		//id		:lastMessageID,
		name	:username,
		message : txtMsg.getValue()
		
	}); 
	txtMsg.setValue(''); 
}

requestNewMessages = function(){
	if (cache.length>0)
		params = cache.shift();	
	else
		params = {
			mode 	: 'RetrieveNew'
			//id		: lastMessageID
		}; 	
	Ext.apply(params,{id: lastMessageID})
	Ext.Ajax.request({
		url : chatURL,
		params : params,
		success : function(response) {
			var res = Ext.decode(response.responseText);
			if (res.success) {
				readMessages(res.messages); 
				readUser(res.users); 
			}
		}
	});
		
}

function readUser(user){
	tpl = "<div style='padding-bottom:3px;'>" +
			"<a href=# onclick=\"startPrivate('{1}',1)\" title='Pesan Pribadi dengan {1}'><img src=\"images/user.png\" " +
			"class=\"x-panel-inline-icon\"/> <b>{0}</b></a></div>";
	html =""; 
	Ext.each(user,function(r,i){
		html += String.format(tpl,r.user,r.user); 
	}); 
	if (Ext.get('userList'))
		Ext.getCmp('userList').body.update(html); 
}
function startPrivate(nameUser,mode) {
	 if (nameUser ==username)
	 	return false;
	 id = 'chat-'+ nameUser; 
	 tabs = Ext.getCmp('tabPanel');
	 var tab = tabs.getComponent(id);
	if(tab){
		if (mode==1){
			tabs.setActiveTab(tab);
		}
	
	} else {
		tab = tabs.add(
			new privChat({
				id : id,
				title:nameUser,
				tUser:nameUser,
				username:username				
			})
		);
		tabs.setActiveTab(tab);
	
	}
}
function readMessages(msg){
	tpl = "<div class='box-chat'><div style='color:{3};'>" +
			" <img src=\"images/comment.png\" " +
			"class=\"x-panel-inline-icon\">" +
			"[{0}] <b>{1} :</b></div>" +
			"<div style='color:blue;padding-left:20px;'>{2}</div> </div>";
	
	Ext.each(msg,function(r,i){
		if (r.message != "_priv_chat_1209"){
			
			color = (r.userName ==username)?'green':'olive'; 		
			html = String.format(tpl,r.time,r.userName,r.message,color);
			if (!r.message.priv){
				chatPanel.append(html); 
				//chatPanel.el.scroll('b', 100000, true);
				oScroll = chatPanel.el.dom; 
				scrollDown = (oScroll.scrollHeight - oScroll.scrollTop <=
							oScroll.offsetHeight );
				if (!scrollDown){			
					sc = (oScroll.scrollTop>0)?oScroll.scrollTop:oScroll.scrollHeight;
					chatPanel.el.scroll('b',sc, true);
				}
				if (r.userName != username)
				if (MsgSign)
					Ext.getCmp('global').setTitle(String.format("<span class='blink'>{0}</span>",username + ' on Global Chat'));
				
				
			}
		}else {
 			tujuan   = r.userName.split('|');
 			penerima = tujuan[0];
 			pengirim = tujuan[1];			
			if (penerima == username) 
  				startPrivate(pengirim,2);			
		}
	}); 
	
	if (msg.length>0)
		lastMessageID = msg[msg.length-1].id; 
	repeatMsg(); 
	
}

function repeatMsg(){
	clearTimeout(tid);
	tid =0;	
	tid = requestNewMessages.defer(updateInterval,Ext.getCmp('global')); 
}
