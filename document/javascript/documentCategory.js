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
				url : '../controller/documentCategoryController.php',
				remoteSort : true,
				root : 'data',
				totalProperty : 'total',
				baseParams : {
					method : 'read',
					mode : 'view',
					leafId : leafId
				},
				fields : [ {
					name : 'documentCategoryId',
					type : 'int'
				}, {
					name : 'documentCategoryTitle',
					type : 'string'
				}, {
					name : 'leafId',
					type : 'int'
				}, {
					name : 'leafName',
					type : 'string'
				}, {
				    name : 'Nleaf',
					type : 'string'
				}],
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
				url : '../controller/documentCategoryController.php',
				remoteSort : true,
				root : 'data',
				totalProperty : 'total',
				baseParams : {
					method : 'read',
					mode : 'view',
					leafId : leafId
				},
				fields : [ {
					name : 'documentCategoryId',
					type : 'int'
				}, {
					name : 'documentCategoryTitle',
					type : 'string'
				}, {
					name : 'leafId',
					type : 'int'
				}, {
					name : 'leafName',
					type : 'string'
				}, {
				    name : 'Nleaf',
					type : 'string'
				}],
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
									url : '../controller/documentCategoryController.php?method=read&field=staffId&leafId='
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
			
			var leaf_reader = new Ext.data.JsonReader({
				root : 'leaf',
				id : 'leafId'
			}, ['leafId', 'leafN']);
	        var leaf_store = new Ext.data.Store({
		    proxy : new Ext.data.HttpProxy({
			url : '../controller/documentCategoryController.php?method=read&field=leafId&leafId='
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
		    reader : leaf_reader,
		    remoteSort : false
	        });
	        leaf_store.load();
			
			var filters = new Ext.ux.grid.GridFilters( {
				encode : encode,
				local : false,
				filters : [ {
					type : 'string',
					dataIndex : 'documentCategoryTitle',
					column : 'documentCategoryTitle',
					table : 'doc_cat'
				}, {
				    type : 'string',
					dataIndex : 'Nleaf',
					column : 'leafName',
					table : 'leaf'
				} ]
			});

			var filtersList = new Ext.ux.grid.GridFilters( {
				encode : encode,
				local : false,
				filters : [ {
					type : 'string',
					dataIndex : 'documentCategoryTitle',
					column : 'documentCategoryTitle',
					table : 'doc_cat'
				}, {
				    type : 'string',
					dataIndex : 'Nleaf',
					column : 'leafName',
					table : 'leaf'
				} ]
			});

			this.action = new Ext.ux.grid.RowActions(
					{
						header : 'Actions',
						dataIndex : 'documentCategoryId',
						bodyStyle : 'padding:5px',
						actions : [
								{
									iconCls : 'application_edit',
									tooltip : 'Kemaskini rekod',
									bodyStyle : 'padding:5px',
									callback : function(grid, record, action,
											row, col) {
										//Ext.MessageBox.alert('message',
												//'This is for update button');
										formPanel.getForm().reset();
										formPanel.form
												.load( {
													url : '../controller/documentCategoryController.php',
													method : 'POST',
													waitMsg : 'Loading...',
													params : {
														method : 'read',
														mode : 'update',
														documentCategoryId : record.data.documentCategoryId,
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
									tooltip : 'Hapuskan Rekod',
									bodyStyle : 'padding:5px',
									callback : function(grid, record, action,
											row, col) {
										Ext.Msg
												.show( {
													title : 'Delete record?',
													msg : 'Do you really want to delete </b><br/>There is no undo.',
													icon : Ext.Msg.QUESTION,
													buttons : Ext.Msg.YESNO,
													scope : this,
													fn : function(response) {
														if ('yes' == response) {
															Ext.Ajax
																	.request( {
																		url : '../controller/documentCategoryController.php',
																		params : {
																			method : 'delete',
																			documentCategoryId : record.data.documentCategoryId,
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
																		failure : function(response, options) 
																		{
																			status_code = response.status;
																			status_message = response.statusText;
																			Ext.MessageBox.alert('system',escape(status_code)
																			+ ":"+ status_message);
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
						header : 'Actions',
						dataIndex : 'documentCategoryId',
						bodyStyle : 'padding:5px',
						actions : [
								{
									iconCls : 'application_edit',
									tooltip : 'Kemaskini rekod',
									bodyStyle : 'padding:5px',
									callback : function(grid, record, action,
											row, col) {
										//Ext.MessageBox.alert('message',
												//'This is for update button');
										formPanel.getForm().reset();
										formPanel.form
												.load( {
													url : '../controller/documentCategoryController.php',
													method : 'POST',
													waitMsg : 'Loading...',
													params : {
														method : 'read',
														mode : 'update',
														documentCategoryId : record.data.documentCategoryId,
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
									tooltip : 'Hapuskan Rekod',
									bodyStyle : 'padding:5px',
									callback : function(grid, record, action,
											row, col) {
										Ext.Msg
												.show( {
													title : 'Delete record?',
													msg : 'Do you really want to delete </b><br/>There is no undo.',
													icon : Ext.Msg.QUESTION,
													buttons : Ext.Msg.YESNO,
													scope : this,
													fn : function(response) {
														if ('yes' == response) {
															Ext.Ajax
																	.request( {
																		url : '../controller/documentCategoryController.php',
																		params : {
																			method : 'delete',
																			documentCategoryId : record.data.documentCategoryId,
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
																			store
																					.reload();
																			storeList
																					.reload();
																			Ext.MessageBox
																					.alert(
																							title,
																							x.message);
																		},
																		failure : function(response, options) 
																		{
																			status_code = response.status;
																			status_message = response.statusText;
																			Ext.MessageBox.alert('system',escape(status_code)
																			+ ":"+ status_message);
																		}
																	});
														}
													}
												});
									}
								} ]
					});
			var columnModel = [ new Ext.grid.RowNumberer(), this.action, {
			    dataIndex : 'documentCategoryTitle',
				header : 'Nama',
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'Nleaf',
				header : 'Leaf',
				sortable : true,
				hidden : false
			} ];

			var columnModelList = [ new Ext.grid.RowNumberer(),
			this.actionList, {
				dataIndex : 'documentCategoryTitle',
				header : 'Nama',
				sortable : true,
				hidden : false
			}, {
				dataIndex : 'Nleaf',
				header : 'Leaf',
				sortable : true,
				hidden : false
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
									text : 'Reload',
									iconCls : 'database_refresh',
									id : 'page_reload',
									disabled : page_reload,
									handler : function() {
										store.reload();
									}
								},
								{
									text : 'Rekod Baru',
									iconCls : 'add',
									id : 'page_create',
									disabled : page_create,
									handler : function() {
										viewPort.items.get(1).expand();
									}
								},
								{
									text : 'Printer',
									iconCls : 'printer',
									id : 'page_printer',
									disabled : page_print,
									handler : function() {
										Ext.ux.GridPrinter.print(grid);
									}
								},
								{
									text : 'Word',
									iconCls : 'page_word',
									id : 'page_word',
									disabled : page_print,
									handler : function() {
										// testing filter by grid
										
										Ext.Ajax
												.request( {
													url : '../controller/documentCategoryController.php?method=report&mode=word&limit='
															+ per_page
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == 'true') {
															//Ext.MessageBox.alert('SYSTEM',x.message);
															window
																	.open("../document/document/word/doc_cat.docx");
														} else {
															Ext.MessageBox
																	.alert(
																			'SYSTEM',
																			x.message);
														}

													},
													failure : function(response, options) 
													{
														status_code = response.status;
														status_message = response.statusText;
														Ext.MessageBox.alert('system',escape(status_code)
														+ ":"+ status_message);
													}

												});

									}
								},
								{
									text : 'Excel',
									iconCls : 'page_excel',
									id : 'page_excel',
									disabled : page_print,
									handler : function() {
										Ext.Ajax
												.request( {
													url : '../controller/documentCategoryController.php?method=report&mode=excel&limit='
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
																	.open("../document/document/excel/doc_cat.xlsx");
														} else {
															Ext.MessageBox
																	.alert(
																			'SYSTEM',
																			x.message);
														}

													},
													failure : function(response, options) 
													{
														status_code = response.status;
														status_message = response.statusText;
														Ext.MessageBox.alert('system',escape(status_code)
														+ ":"+ status_message);
													}

												});
									}
								},
								{
									text : 'PDF',
									iconCls : 'page_white_acrobat',
									id : 'page_white_acrobat',
									disabled : page_print,
									handler : function() {
										window.location
												.replace('../controller/documentCategoryController.php?method=report&mode=pdf&limit='
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
									text : 'Reload',
									iconCls : 'database_refresh',
									id : 'page_reloadList',
									disabled : page_reloadList,
									handler : function() {
										storeList.reload();
									}
								},
								{
									text : 'Rekod Baru',
									iconCls : 'add',
									id : 'page_createList',
									disabled : page_createList,
									handler : function() {
										viewPort.items.get(1).expand();
										win.hide();
									}
								},
								{
									text : 'Printer',
									iconCls : 'printer',
									id : 'printerList',
									disabled : page_printList,
									handler : function() {
										Ext.ux.GridPrinter.print(grid);
									}
								},
								{
									text : 'Word',
									iconCls : 'page_word',
									id : 'page_wordList',
									disabled : page_printList,
									handler : function() {
										Ext.Ajax
												.request( {
													url : '../controller/documentCategoryController.php?method=report&mode=word&limit='
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
																	.open("../ketetapan/document/word/doc_cat.docx");
														} else {
															Ext.MessageBox
																	.alert(
																			'SYSTEM FAILURE ',
																			x.message);
														}

													},
													failure : function(response, options) 
													{
														status_code = response.status;
														status_message = response.statusText;
														Ext.MessageBox.alert('system',escape(status_code)
														+ ":"+ status_message);
													}

												});
									}
								},
								{
									text : 'Excel',
									iconCls : 'page_excel',
									id : 'page_excelList',
									disabled : page_printList,
									handler : function() {
										Ext.Ajax
												.request( {
													url : '../controller/documentCategoryController.php?method=report&mode=excel&limit='
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
																	.open("../ketetapan/document/excel/doc_cat.xlsx");
														} else {
															Ext.MessageBox
																	.alert(
																			'SYSTEM',
																			x.message);
														}

													},
													failure : function(response, options) 
													{
														status_code = response.status;
														status_message = response.statusText;
														Ext.MessageBox.alert('system',escape(status_code)
														+ ":"+ status_message);
													}

												});
									}
								},
								{
									text : 'PDF',
									iconCls : 'page_white_acrobat',
									id : 'page_white_acrobatList',
									disabled : page_print,
									handler : function() {
										window.location
												.replace('../controller/documentCategoryController.php?method=report&mode=pdf&limit='
														+ per_page
														+ '&leafId='
														+ leafId);
									}
								} ]
					});
			var gridPanel = new Ext.Panel( {
				title : 'Senarai ' + leafName,
				height : 50,
				layout : 'fit',
				iconCls : 'application_view_detail',
				tbar : [toolbarPanel],
                items : [grid]
			});
			
			var leafF = new Ext.ux.form.ComboBoxMatch( {
				labelAlign  : 'left',
				fieldLabel  : 'Leaf ID <span style="color: red;">*</span>',
				name 		: 'leafId',
				valueField 	: 'leafId',
				hiddenName	: 'leafId',
				id 			: 'leaf',
				displayField : 'leafN',
				typeAhead : false,
				emptyText : 'Sila Pilih Leaf ID',
				triggerAction : 'all',
				mode : 'local',
				store : leaf_store,
				anchor : '95%',
				selectOnFocus : true,
				allowBlank : false,
				blankText : 'Sila Pilih Dokument ID',
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
			
			var documentCategoryTitle		  = 	new Ext.form.TextField({
			        labelAlign  :	'left',
			        fieldLabel  :	'Penerangan',
			        hiddenName  :	'Nama',
			        name		:	'documentCategoryTitle',
					allowBlank  :   false,
				    blankText   :   'Sila isi Nama',
			        anchor      :	'95%'
		        });

			
			var documentCategoryId = new Ext.form.Hidden( {
				name : 'documentCategoryId'
			});
			
			var formPanel = new Ext.form.FormPanel(
					{
						url : '../controller/documentCategoryController.php',
						id : 'formPanel',
						method : 'post',
						frame : true,
						title : 'Borang ' + leafName,
						border : false,
						bodyStyle : 'padding:5px',
						width : 600,
						items : [ documentCategoryId, leafF, documentCategoryTitle ],
						buttonVAlign : 'top',
						buttonAlign : 'left',
						iconCls : 'application_form',
						bbar : new Ext.ux.StatusBar( {
							id : 'form-statusbar',
							defaultText : 'Ready',
							plugins : new Ext.ux.ValidationStatus( {
								form : 'formPanel'
							})
						}),
						buttons : [
								{
									text : 'Save',
									iconCls : 'bullet_disk',
									handler : function() {
										if (formPanel.getForm().isValid()) {
											var id=0;
											id  = Ext.getCmp('documentCategoryId').getValue();
											var method ;
											if(id.length > 0 ) { 
												method = 'save';
											} else {
												method = 'create';
											}
											formPanel
													.getForm()
													.submit(
															{
																waitMsg : 'Saving',
																params : {
																	method : method,
																	leafId : leafId
																},
																success : function(
																		form,
																		action) {
																	var title='Message Successfull';
																	Ext.MessageBox
																			.alert(
																					title,
																					action.result.message);
																	formPanel
																			.getForm()
																			.reset();
																	store
																			.reload();
																	storeList
																			.reload();
																},
																failure : function(
																		form,
																		action) {
																	// be separate to avoid other error
																	var title='Message Failure';
																	if(duplicate  == 1) { 
																		Ext.MessageBox.alert(title,duplicateMsg);
																	}
																	
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
																	
																}
															});
										}
									}
								}, {
									text : 'Rekod Baru',
									type : 'button',
									iconCls : 'add',
									handler : function() {
										formPanel.getForm().reset();
									}
								}, {
									text : 'Reset',
									type : 'reset',
									iconCls : 'table_refresh',
									handler : function() {
										formPanel.getForm().reset();
									}
								}, {
									text : 'Senarai',
									type : 'button',
									iconCls : 'table',
									handler : function() {
										if (win) {
											win.show().center();
										}
									}
								}, {
									text : 'Cancel',
									type : 'button',
									iconCls : 'delete',
									handler : function() {
										if (win) {
											win.hide();
										}
										formPanel.getForm().reset();
										store.reload();
										viewPort.items.get(0).expand();
									}
								} ]
					});
			
			var win = new Ext.Window( {
				tbar : toolbarPanelList,
				items : [ gridList ],
				title : 'Senarai ' + leafName,
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
