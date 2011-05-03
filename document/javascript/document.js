Ext.onReady(function() {
			Ext.QuickTips.init();
			Ext.form.Field.prototype.msgTarget = 'under';
			var page_create;
			var page_createList;
			var page_reload;
			var page_reloadList;
			var page_print;
			var page_printList;
			var duplicate =0; // bypassing the extjs bugs
			if (leafCreateAccessValue == 1) {
				page_create = false;
				page_createList = false;
			} else {
				page_create = true;
				page_createList = true;
			}
			if (leafReadAccessValue == 1) {
				page_reload = false;
				page_reloadList = false;
			} else {
				page_reload = true;
				page_reloadList = true;
			}
			if (leafPrintAccessValue == 1) {
				page_print = false;
				page_printList = false;
			} else {
				page_print = true;
				page_printList = true;
			}
			Ext.BLANK_IMAGE_URL = '../javascript/resources/images/s.gif';
			var per_page = 10;
			var encode = false;
			var local = false;
			var store = new Ext.data.JsonStore( {
				autoDestroy : true,
				url : '../controller/documentController.php',
				remoteSort : true,
				root : 'data',
				totalProperty : 'total',
				baseParams : {
					method : 'read',
					mode : 'view',
					leafId : leafId
				},
				fields : [ {
					name : 'documentId',
					type : 'int'
				}, {
					name : 'documentCategoryId',
					type : 'int'
				}, {
					name : 'documentTitle',
					type : 'string'
				}, {
				    name : 'documentDesc',
					type : 'string'
				}, {
				    name : 'documentExtension',
					type : 'string'
				}, {
				    name : 'documentCategoryTitle',
					type : 'string'
				},  {
					name : 'By',
					type : 'int'
				}, {
					name : 'Time',
					type : 'date',
					dateFormat : 'Y-m-d H:i:s'
				}, {
				    name : 'NoDoc',
					type : 'string'
				} ],
				listeners : {
					exception : function(DataProxy, type, action, options,
							response, arg) {
						var serverMessage = Ext.util.JSON
								.decode(response.responseText);
						if (serverMessage.success == false
								) {
							Ext.MessageBox
									.alert("Error", serverMessage.message);
						}
					}
				}
			});

			var storeList = new Ext.data.JsonStore( {
				autoDestroy : true,
				url : '../controller/documentController.php',
				remoteSort : true,
				root : 'data',
				totalProperty : 'total',
				baseParams : {
					method : 'read',
					mode : 'view',
					leafId : leafId
				},
				fields : [ {
					name : 'documentId',
					type : 'int'
				}, {
					name : 'documentCategoryId',
					type : 'int'
				}, {
					name : 'documentTitle',
					type : 'string'
				}, {
				    name : 'documentDesc',
					type : 'string'
				}, {
				    name : 'documentExtension',
					type : 'string'
				}, {
				    name : 'documentCategoryTitle',
					type : 'string'
				}, {
					name : 'By',
					type : 'int'
				}, {
					name : 'Time',
					type : 'date',
					dateFormat : 'Y-m-d H:i:s'
				}, {
				    name : 'NoDoc',
					type : 'string'
				} ],
				listeners : {
					exception : function(DataProxy, type, action, options,
							response, arg) {
						var serverMessage = Ext.util.JSON
								.decode(response.responseText);
						if (serverMessage.success == false
								) {
							Ext.MessageBox
									.alert("Error", serverMessage.message);
						}
					}
				}
			});

			var staff_reader = new Ext.data.JsonReader( {
				root : 'staff',
				id : 'staffId'
			}, [ 'staffId', 'staffName' ]);
			var staff_store = new Ext.data.Store(
					{
						proxy : new Ext.data.HttpProxy(
								{
									url : '../controller/documentController.php?method=read&field=staffId&leafId='
											+ leafId,
									method : 'GET',
									listeners : {
										exception : function(DataProxy, type,
												action, options, response, arg) {
											var serverMessage = Ext.util.JSON
													.decode(response.responseText);
											if (serverMessage.success == false
													) {
												Ext.MessageBox.alert("Error",
														serverMessage.message);
											}
										}
									}
								}),
						reader : staff_reader,
						remoteSort : false
					});
			staff_store.load();
			
			var documentCategoryReader = new Ext.data.JsonReader({
				root : 'documentCategory',
				id : 'documentCategoryId'
			}, ['documentCategoryId', 'IdDoc']);
	        var documentCategory_store = new Ext.data.Store({
		    proxy : new Ext.data.HttpProxy({
			url : '../controller/documentController.php?method=read&field=documentCategoryId&leafId='
					+ leafId,
			method : 'GET',
			listeners: {
            	exception: function(DataProxy, type, action, options, response, arg){
                	var serverMessage = Ext.util.JSON.decode(response.responseText);
                		if (serverMessage.success == false ) {
                    		Ext.MessageBox.alert("Error", serverMessage.message);
                		}
            		}
        		}
		    }),
		    reader : documentCategoryReader,
		    remoteSort : false
	        });
	        documentCategory_store.load();
			
			var filters = new Ext.ux.grid.GridFilters( {
				encode : encode,
				local : false,
				filters : [ {
					type : 'string',
					dataIndex : 'NoDoc',
					column : 'documentCategoryTitle',
					table : 'documentCategory'
				}, {
				    type : 'string',
					dataIndex : 'documentTitle',
					column : 'documentTitle',
					table : 'document'
				}, {
				    type : 'string',
					dataIndex : 'documentDesc',
					column : 'documentDesc',
					table : 'document'
				}, {
				    type : 'string',
					dataIndex : 'documentExtension',
					column : 'documentExtension',
					table : 'document'
				}, {
					type : 'list',
					dataIndex : 'By',
					column : 'By',
					table : 'document',
					labelField : 'staffName',
					store : staff_store,
					phpMode : true
				}, {
					type : 'date',
					dataIndex : 'Time',
					column : 'Time',
					table : 'document'
				} ]
			});

			var filtersList = new Ext.ux.grid.GridFilters( {
				encode : encode,
				local : false,
				filters : [ {
					type : 'string',
					dataIndex : 'NoDoc',
					column : 'documentCategoryTitle',
					table : 'documentCategory'
				}, {
				    type : 'string',
					dataIndex : 'documentTitle',
					column : 'documentTitle',
					table : 'document'
				}, {
				    type : 'string',
					dataIndex : 'documentDesc',
					column : 'documentDesc',
					table : 'document'
				}, {
				    type : 'string',
					dataIndex : 'documentExtension',
					column : 'documentExtension',
					table : 'document'
				}, {
					type : 'list',
					dataIndex : 'By',
					column : 'By',
					table : 'document',
					labelField : 'staffName',
					store : staff_store,
					phpMode : true
				}, {
					type : 'date',
					dataIndex : 'Time',
					column : 'Time',
					table : 'document'
				} ]
			});

			this.action = new Ext.ux.grid.RowActions(
					{
						header : actionLabel,
						dataIndex : 'documentId',
						bodyStyle : 'padding:5px',
						actions : [
								{
									iconCls : 'application_edit',
									tooltip : updateRecordToolTipLabel,
									bodyStyle : 'padding:5px',
									callback : function(grid, record, action,
											row, col) {
										//Ext.MessageBox.alert('message',
												//'This is for update button');
										formPanel.getForm().reset();
										formPanel.form
												.load( {
													url : '../controller/documentController.php',
													method : 'POST',
													waitMsg : waitMessageLabel,
													params : {
														method : 'read',
														mode : 'update',
														documentId : record.data.documentId,
														leafId : leafId
													},
													success : function(form,
															action) {
														viewPort.items.get(1)
																.expand();
													},
													failure : function(form,action) {
														var title = "Message Failure";
															
														Ext.MessageBox
																.alert(
																		title,
																		action.result.message);
													}
												});
									}
								},
								{
									iconCls : 'cancel',
									tooltip : deleteRecordToolTipLabel,
									bodyStyle : 'padding:5px',
									callback : function(grid, record, action,
											row, col) {
										Ext.Msg
												.show( {
													title : deleteRecordTitleMessageLabel,
													msg : deleteRecordMessageLabel,
													icon : Ext.Msg.QUESTION,
													buttons : Ext.Msg.YESNO,
													scope : this,
													fn : function(response) {
														if ('yes' == response) {
															Ext.Ajax
																	.request( {
																		url : '../controller/documentController.php',
																		params : {
																			method : 'delete',
																			documentId : record.data.documentId,
																			leafId : leafId
																		},
																		success : function(response,options) {
																			var x  = Ext.decode(response.responseText);
																			var title  = 'Message';
																			if(x.success == 'true'){
																				title = title + ' Success';
																			} else {
																				title = title + ' Failure';
																			}
																			Ext.MessageBox
																					.alert(
																							title,
																							x.message);
																			
																			store
																					.reload();
																			storeList
																					.reload();
																		},
																		failure : function(response,options) {
																			// critical bug extjs 
																			var x = Ext.decode(response.responseText);
																			var title = 'Message Failure';
																			Ext.MessageBox
																					.alert(
																							title,
																							x.message);
																		}
																	});
														}
													}
												});
									}
								} ]
					});

			this.actionList = new Ext.ux.grid.RowActions(
					{
						header : actionLabel,
						dataIndex : 'documentId',
						bodyStyle : 'padding:5px',
						actions : [
								{
									iconCls : 'application_edit',
									tooltip : updateRecordToolTipLabel,
									bodyStyle : 'padding:5px',
									callback : function(grid, record, action,
											row, col) {
										//Ext.MessageBox.alert('message',
												//'This is for update button');
										formPanel.getForm().reset();
										formPanel.form
												.load( {
													url : '../controller/documentController.php',
													method : 'POST',
													waitMsg : waitMessageLabel,
													params : {
														method : 'read',
														mode : 'update',
														documentId : record.data.documentId,
														leafId : leafId
													},
													success : function(form,
															action) {
														viewPort.items.get(1)
																.expand();
													},
													failure : function(form,action) {
														var title='Message Failure';
														
														Ext.MessageBox
																.alert(
																		title,
																		action.result.message);
													}
												});
												win.hide();
									}
								},
								{
									iconCls : 'cancel',
									tooltip : deleteRecordToolTipLabel,
									bodyStyle : 'padding:5px',
									callback : function(grid, record, action,
											row, col) {
										Ext.Msg
												.show( {
													title : deleteRecordTitleMessageLabel,
													msg : deleteRecordMessageLabel,
													icon : Ext.Msg.QUESTION,
													buttons : Ext.Msg.YESNO,
													scope : this,
													fn : function(response) {
														if ('yes' == response) {
															Ext.Ajax
																	.request( {
																		url : '../controller/documentController.php',
																		params : {
																			method : 'delete',
																			documentId : record.data.documentId,
																			leafId : leafId
																		},
																		success : function(response,options) {
																			var x  = Ext.decode(response.responseText);
																			var title  = 'Message';
																			if(x.success == 'true'){
																				title = successLabel;
																			} else {
																				title = failureLabel;
																			}
																			store
																					.reload();
																			storeList
																					.reload();
																			Ext.MessageBox
																					.alert(
																							title,
																							x.message);
																		},
																		failure : function(response,options) {
																			var x  = Ext.decode(response.responseText);
																			var title = "Message Failure";
																			Ext.MessageBox
																					.alert(
																							title,
																							x.message);
																		}
																	});
														}
													}
												});
									}
								} ]
					});
					
			var columnModel = [ new Ext.grid.RowNumberer(), this.action, {
				dataIndex : 'NoDoc',
				header : NoDocLabel,
				sortable : true,
				hidden : false
			}, {
			    dataIndex : 'documentTitle',
				header : documentTitleLabel,
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'documentDesc',
				header : documentDescLabel,
				sortable : true,
				hidden : false
			}, {
			    dataIndex : 'documentExtension',
				header : documentExtensionLabel,
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'createBy',
				header : createByLabel,
				sortable : true,
				hidden : true
			}, {
				dataIndex : 'createTime',
				header : createTimeLabel,
				sortable : true,
				hidden : true,
			    renderer : function(value) {
			                       return Ext.util.Format.date(value, 'Y-m-d H:i:s');
		                           }
			}, {
				dataIndex : 'updatedBy',
				header : updatedByLabel,
				sortable : true,
				hidden : true
			}, {
				dataIndex : 'updatedTime',
				header : updatedTimeLabel,
				sortable : true,
				hidden : true,
			    renderer : function(value) {
			                       return Ext.util.Format.date(value, 'Y-m-d H:i:s');
		                           }		
			} ];

			var columnModelList = [ new Ext.grid.RowNumberer(),
			this.actionList, {
				dataIndex : 'NoDoc',
				header : NoDocLabel,
				sortable : true,
				hidden : false
			}, {
			    dataIndex : 'documentTitle',
				header : documentTitleLabel,
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'documentDesc',
				header : documentDescLabel,
				sortable : true,
				hidden : false
			}, {
			    dataIndex : 'documentExtension',
				header : documentExtensionLabel,,
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'createBy',
				header : createByLabel,
				sortable : true,
				hidden : true
			}, {
				dataIndex : 'createTime',
				header :  createTimeLabel,,
				sortable : true,
				hidden : true,
			    renderer : function(value) {
			                       return Ext.util.Format.date(value, 'Y-m-d H:i:s');
		                           }		
			}, {
				dataIndex : 'updatedBy',
				header : updatedByLabel,
				sortable : true,
				hidden : true
			}, {
				dataIndex : 'updatedTime',
				header : updatedTimeLabel,
				sortable : true,
				hidden : true,
			    renderer : function(value) {
			                       return Ext.util.Format.date(value, 'Y-m-d H:i:s');
		                           }		
			} ];

			var grid = new Ext.grid.GridPanel( {
				border : false,
				store : store,
				autoHeight : false,
				height : 450,
				columns : columnModel,
				loadMask : true,
				plugins : [ this.action, filters ],
				sm : new Ext.grid.RowSelectionModel( {
					singleSelect : true
				}),
				viewConfig : {
					forceFit : true,
					emptyText : 'No rows to display'
				},
				iconCls : 'application_view_detail',
				listeners : {
					render : {
						fn : function() {
							store.load( {
								params : {
									start : 0,
									limit : per_page,
									method : 'read',
									mode : 'view',
									plugin : [ filters ]
								}
							});
						}
					}
				},
				bbar : new Ext.PagingToolbar( {
					store : store,
					pageSize : per_page,
					plugins : [ new Ext.ux.plugins.PageComboResizer() ]
				})
			});

			var gridList = new Ext.grid.GridPanel( {
				border : false,
				store : storeList,
				autoHeight : false,
				height : 400,
				columns : columnModelList,
				loadMask : true,
				plugins : [ this.actionList, filtersList ],
				sm : new Ext.grid.RowSelectionModel( {
					singleSelect : true
				}),
				viewConfig : {
					forceFit : true,
					emptyText : 'No rows to display'
				},
				iconCls : 'application_view_detail',
				listeners : {
					render : {
						fn : function() {
							storeList.load( {
								params : {
									start : 0,
									limit : per_page,
									method : 'read',
									mode : 'view',
									plugin : [ filtersList ]
								}
							});
						}
					}
				},
				bbar : new Ext.PagingToolbar( {
					store : storeList,
					pageSize : per_page,
					plugins : [ new Ext.ux.plugins.PageComboResizer() ]
				})
			});
			var toolbarPanel = new Ext.Toolbar(
					{
						items : [
								{
									text : reloadToolbarLabel,
									iconCls : 'database_refresh',
									id : 'page_reload',
									disabled : page_reload,
									handler : function() {
										store.reload();
									}
								},
								{
									text : addToolbarLabel,
									iconCls : 'add',
									id : 'page_create',
									disabled : page_create,
									handler : function() {
										viewPort.items.get(1).expand();
									}
								},
							
								{
									text : excelToolbarLabel,
									iconCls : 'page_excel',
									id : 'page_excel',
									disabled : page_print,
									handler : function() {
										Ext.Ajax
												.request( {
													url : '../controller/documentController.php?method=report&mode=excel&limit='
															+ per_page
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == 'true') {
															// Ext.MessageBox.alert('SYSTEM',x.message);
															window
																	.open("../document/document/excel/document.xlsx");
														} else {
															Ext.MessageBox
																	.alert(
																			'SYSTEM',
																			x.message);
														}

													}

												});
									}
								},
								{
									text : PDFToolbarLabel,
									iconCls : 'page_white_acrobat',
									id : 'page_white_acrobat',
									disabled : page_print,
									handler : function() {
										window.location
												.replace('../controller/documentController.php?method=report&mode=pdf&limit='
														+ per_page
														+ '&leafId='
														+ leafId);
									}
								} ]
					});
			var toolbarPanelList = new Ext.Toolbar(
					{
						items : [
								{
									text : reloadToolbarLabel,
									iconCls : 'database_refresh',
									id : 'page_reloadList',
									disabled : page_reloadList,
									handler : function() {
										storeList.reload();
									}
								},
								{
									text : addToolbarLabel,
									iconCls : 'add',
									id : 'page_createList',
									disabled : page_createList,
									handler : function() {
										viewPort.items.get(1).expand();
										win.hide();
									}
								},
								{
									text : printerToolbarLabel,
									iconCls : 'printer',
									id : 'printerList',
									disabled : page_printList,
									handler : function() {
										Ext.ux.GridPrinter.print(grid);
									}
								},
								{
									text : wordToolbarLabel,
									iconCls : 'page_word',
									id : 'page_wordList',
									disabled : page_printList,
									handler : function() {
										Ext.Ajax
												.request( {
													url : '../controller/documentController.php?method=report&mode=word&limit='
															+ per_page
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == true) {
															// Ext.MessageBox.alert('SYSTEM',x.message);
															window
																	.open("../ketetapan/document/word/document.docx");
														} else {
															Ext.MessageBox
																	.alert(
																			systemFailureLabel,
																			x.message);
														}

													}

												});
									}
								},
								{
									text : excelToolbarLabel,
									iconCls : 'page_excel',
									id : 'page_excelList',
									disabled : page_printList,
									handler : function() {
										Ext.Ajax
												.request( {
													url : '../controller/documentController.php?method=report&mode=excel&limit='
															+ per_page
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == 'true') {
															// Ext.MessageBox.alert('SYSTEM',x.message);
															window
																	.open("../ketetapan/document/excel/document.xlsx");
														} else {
															Ext.MessageBox
																	.alert(
																			'SYSTEM',
																			x.message);
														}

													}

												});
									}
								},
								{
									text : PDFToolbarLabel,
									iconCls : 'page_white_acrobat',
									id : 'page_white_acrobatList',
									disabled : page_print,
									handler : function() {
										window.location
												.replace('../controller/documentController.php?method=report&mode=pdf&limit='
														+ per_page
														+ '&leafId='
														+ leafId);
									}
								} ]
					});
			var gridPanel = new Ext.Panel( {
				title : leafName,
				height : 50,
				layout : 'fit',
				iconCls : 'application_view_detail',
				tbar : [toolbarPanel],
                items : [grid]
			});
            
			var docN = new Ext.ux.form.ComboBoxMatch( {
				labelAlign  : 'left',
				fieldLabel  : 'Dokument ID <span style="color: red;">*</span>',
				name 		: 'documentCategoryId',
				valueField 	: 'documentCategoryId',
				hiddenName	: 'documentCategoryId',
				id 			: 'documentCategory',
				displayField : 'IdDoc',
				typeAhead : false,
				emptyText : 'Sila Pilih Dokument ID',
				triggerAction : 'all',
				mode : 'local',
				store : documentCategory_store,
				anchor : '95%',
				selectOnFocus : true,
				allowBlank : false,
				blankText : blankTextLabel,
                createValueMatcher : function(value) {
					value = String(value).replace(/\s*/g, '');
					if (Ext.isEmpty(value, false)) {
						return new RegExp('^');
					}
					value = Ext.escapeRe(value.split('').join('\\s*')).replace(
							/\\\\s\\\*/g, '\\s*');
					return new RegExp('\\b(' + value + ')', 'i');
				}
			});
			
			var documentDesc		  = 	new Ext.form.TextField({
			        labelAlign  :	'left',
			        fieldLabel  :	'Penerangan',
			        hiddenName  :	'documentDesc',
			        name		:	'documentDesc',
					allowBlank  :   false,
				    blankText   :   blankTextLabel,
			        anchor      :	'95%'
		        });
			
			var documentId = new Ext.form.Hidden( {
				name : 'documentId'
			});
			
			var formPanel = new Ext.FormPanel({ 
			method		:  	'post',
			id			:	'formPanel',
			url			: 	'../controller/documentController.php',
			title       : 	leafName,
        	border      : 	false,
            width		: 	600,       
	        fileUpload	: 	true,
	        frame		: 	true,    		
			autoheight	:	true,
	        bodyStyle	: 	'padding: 10px 10px 0 10px;',
	        labelWidth	: 	60,
	        buttonVAlign: 	'top',
			buttonAlign	: 	'left',
	        defaults	: 	{
	            anchor		: '95%',           
	            msgTarget	: 'side'
	        },
	        iconCls		:	'application_form',
	        bbar		: 	new Ext.ux.StatusBar({
				  id: 'form-statusbar',

				defaultText	:	'Ready',
				plugins		: 	new Ext.ux.ValidationStatus({form:'formPanel'})
			}),
	        items: [
			docN, documentDesc, documentId,
			{
	            xtype		: 'fileuploadfield',
	            id			: 'form-file',
	            emptyText	: 'Sila pilih Dokumen',
	            fieldLabel	: 'Dokumen',
	            name		: 'docname',
	            allowBlank	:	false,
				blankText	:	blankTextLabel,
	            buttonCfg	: {
		                text	: '',
		                iconCls	: 'bullet_disk'
	            }
	        }],
	        buttons: [{
	            text: uploadButtonLabel,
	            iconCls	:	'bullet_disk',
	            handler: function(){
	                if(formPanel.getForm().isValid()){
	                	if(formPanel.getForm().isValid()) {
	                	formPanel.getForm().submit({
		                waitMsg  : waitMessageLabel,
		                params	 :	{ method:'upload', leafId:leafId }, 
		                success  : function(formPanel,o){
	                		    	Ext.MessageBox.alert(systemLabel);
		                            //formPanel.getForm().reset();
		                        	store.reload();
		                        	viewPort.items.get(0).expand();
		                    },
						failure: function(formPanel,o){							 
								  Ext.MessageBox.alert(loadFailureMessageLabel);    
								} 
								});
								}}
								}
								},{ 	
									text 	: 	newButtonLabel,
									type	:	'button',
									iconCls	:	'add',
									handler	: 	function(){ 
										formPanel.getForm().reset(); 
									} 
							   },{ 	
									text 	: 	resetButtonLabel,
									type	:	'reset',
									iconCls	:	'table_refresh',
									handler	: 	function(){ 
										formPanel.getForm().reset(); 
									} 
						        },{ 	
									text 	: 	 listButtonLabel,
									type	:	'button',
									iconCls	:   'table',
									handler	: 	function(){  
						        	if(win){
						        		 win.show().center();
						        	   }
						            } 
								},{ 	
									text 	: 	cancelButtonLabel,
									type	:	'button',
									iconCls	:	'delete',
									handler	: 	function(){ 
									    if(win){
									    	win.hide();
									    }
									    formPanel.getForm().reset();
										store.reload();
											viewPort.items.get(0).expand();
									} 
					        }]
	    });
		
			var win = new Ext.Window( {
				tbar : toolbarPanelList,
				items : [ gridList ],
				title : leafName,
				closeAction : 'hide',
				maximizable : true,
				layout : 'fit',
				width : 500,
				autoScroll : true
			});
			var viewPort = new Ext.Viewport( {
				id : 'viewport',
				region : 'center',
				layout : 'accordion',
				layoutConfig : {
					titleCollapse : true,
					animate : false,
					activeOnTop : true
				},
				items : [ gridPanel, formPanel ]
			});
		});