Ext
		.onReady(function() {

			var pageCreate;
			var pageReload;
			var pagePrint;
			if (leafAccessCreateValue == 1) {
				pageCreate = false;
			} else {
				pageCreate = true;
			}
			if (leafAccessReadValue == 1) {
				pageReload = false;
			} else {
				pageReload = true;
			}
			if (leafAccessPrintValue == 1) {
				pagePrint = false;
			} else {
				pagePrint = true;
			}
			// form panel + grid.When choose the form then activated filter the
			// grid.Grid will automatically update on demand
			// first viewport
			var perPage = 10;
			var encode = false;
			var local = false;
			leafAccessProxy = new Ext.data.HttpProxy({
				url : "../controller/leafAccessController.php",
				method : 'POST',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
						// uncomment it for debugging purpose
					} else {
						Ext.MessageBox.alert(systemErrorLabel,
								jsonResponse.message);

					}
				},
				failure : function(response, options) {

					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ":"
									+ escape(response.statusText));
				}
			});
			leafAccessReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "leafAccessId"

			});

			var leafAccessStore = new Ext.data.JsonStore({
				autoLoad : false,
				autoDestroy : true,
				proxy : leafAccessProxy,
				reader : leafAccessReader,
				root : 'data',
				baseParams : {
					method : "read",
					isAdmin : isAdmin,
					leafId : leafId
				},
				fields : [ {
					name : 'moduleId',
					type : 'int'
				}, {
					name : 'leafAccessId',
					type : 'int'
				}, {
					name : 'moduleEnglish',
					type : 'string'
				}, {
					name : 'teamId',
					type : 'int'
				}, {
					name : 'teamEnglish',
					type : 'string'
				}, {
					name : 'folderId',
					type : 'int'
				}, {
					name : 'folderEnglish',
					type : 'string'
				}, {
					name : 'leafId',
					type : 'int'
				}, {
					name : 'leafEnglish',
					type : 'string'
				}, {
					name : 'leafAccessCreateValue',
					type : 'boolean'
				}, {
					name : 'leafAccessReadValue',
					type : 'boolean'
				}, {
					name : 'leafAccessUpdateValue',
					type : 'boolean'
				}, {
					name : 'leafAccessDeleteValue',
					type : 'boolean'
				}, {
					name : 'leafAccessPrintValue',
					type : 'boolean'
				}, {
					name : 'leafAccessPostValue',
					type : 'boolean'
				} ]

			});

			var teamProxy = new Ext.data.HttpProxy({
				url : "../controller/leafAccessController.php?",
				method : 'GET',
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
						// uncomment it for debugging purpose
					} else {
						Ext.MessageBox.alert(systemErrorLabel,
								jsonResponse.message);

					}

				},
				failure : function(response, options) {

					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ":"
									+ escape(response.statusText));
				}
			});
			var teamReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "teamId"
			});

			var teamStore = new Ext.data.JsonStore({
				autoLoad : true,
				autoDestroy : true,
				proxy : teamProxy,
				reader : teamReader,
				root : 'team',
				baseParams : {
					method : "read",
					leafId : leafId,
					field : "teamId"
				},
				fields : [ {
					name : 'teamId',
					type : 'int'
				}, {
					name : 'teamEnglish',
					type : 'string'
				} ]

			});

			var moduleProxy = new Ext.data.HttpProxy({
				url : "../controller/leafAccessController.php",
				method : 'GET',

				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
						// uncomment it for debugging purpose
					} else {
						Ext.MessageBox.alert(systemErrorLabel,
								jsonResponse.message);

					}

				},
				failure : function(response, options) {

					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ":"
									+ escape(response.statusText));
				}
			});

			var moduleReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "moduleId"
			});
			var moduleStore = new Ext.data.JsonStore({
				autoLoad : false,
				autoDestroy : true,
				proxy : moduleProxy,
				reader : moduleReader,
				root : 'module',
				baseParams : {
					method : "read",
					leafId : leafId,
					field : "moduleId"
				},
				fields : [ {
					name : 'moduleId',
					type : 'int'
				}, {
					name : 'moduleEnglish',
					type : 'string'
				} ]

			});

			var folderProxy = new Ext.data.HttpProxy({
				url : "../controller/leafAccessController.php",
				method : 'GET',

				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
					} else {
						Ext.MessageBox.alert(systemErrorLabel,
								jsonResponse.message);
					}
				},
				failure : function(response, options) {
					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ":"
									+ escape(response.statusText));
				}
			});

			var folderReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "folderId"
			});
			var folderStore = new Ext.data.JsonStore({
				autoLoad : false,
				autoDestroy : true,
				proxy : folderProxy,
				reader : folderReader,
				root : 'folder',
				baseParams : {
					method : "read",
					leafId : leafId,
					field : "folderId"
				},
				fields : [ {
					name : 'folderId',
					type : 'int'
				}, {
					name : 'folderEnglish',
					type : 'string'
				} ]

			});

			var staffByProxy = new Ext.data.HttpProxy({
				url : "../controller/leafAccessController.php?",
				method : "GET",
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
						// uncomment it for debugging purpose
					} else {
						Ext.MessageBox.alert(systemErrorLabel,
								jsonResponse.message);

					}
				},
				failure : function(response, options) {
					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ":"
									+ escape(response.statusText));
				}
			});
			var staffByReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "staffId"
			});
			var staffByStore = new Ext.data.JsonStore({
				proxy : staffByProxy,
				reader : staffByReader,
				autoLoad : true,
				autoDestroy : true,
				baseParams : {
					method : 'read',
					field : 'staffId',
					leafId : leafId
				},
				root : 'staff',
				fields : [ {
					name : "staffId",
					type : "int"
				}, {
					name : "staffName",
					type : "string"
				} ]
			});

			var leafAccessCreateValue = new Ext.grid.CheckColumn({
				header : leafAccessCreateValueLabel,
				dataIndex : 'leafAccessCreateValue',
				id : 'leafAccessCreateValue',
				width : 55
			});

			var leafAccessReadValue = new Ext.grid.CheckColumn({
				header : leafAccessReadValueLabel,
				dataIndex : 'leafAccessReadValue',
				id : 'leafAccessReadValue',
				width : 55
			});

			var leafAccessUpdateValue = new Ext.grid.CheckColumn({
				header : leafAccessUpdateValueLabel,
				dataIndex : 'leafAccessUpdateValue',
				id : 'leafAccessUpdateValue',
				width : 55
			});

			var leafAccessDeleteValue = new Ext.grid.CheckColumn({
				header : leafAccessDeleteValueLabel,
				dataIndex : 'leafAccessDeleteValue',
				id : 'leafAccessDeleteValue',
				width : 55
			});

			var leafAccessPrintValue = new Ext.grid.CheckColumn({
				header : leafAccessPrintValueLabel,
				dataIndex : 'leafAccessPrintValue',
				id : 'leafAccessPrintValue',
				width : 55
			});

			var leafAccessPostValue = new Ext.grid.CheckColumn({
				header : leafAccessPostValueLabel,
				dataIndex : 'leafAccessPostValue',
				id : 'leafAccessPostValue',
				width : 55
			});

			var leafAccessReviewValue = new Ext.grid.CheckColumn({
				header : leafAccessReviewValueLabel,
				dataIndex : 'leafAccessReviewValue',
				id : 'leafAccessReviewValue',
				width : 55
			});

			var leafAccessDraftValue = new Ext.grid.CheckColumn({
				header : leafAccessDraftValueLabel,
				dataIndex : 'leafAccessDraftValue',
				id : 'leafAccessDraftValue',
				width : 55
			});

			var leafAccessColumnModel = new Ext.grid.ColumnModel({
				columns : [ {
					header : moduleEnglishLabel,
					dataIndex : 'moduleEnglish'
				}, {
					header : teamEnglishLabel,
					dataIndex : 'teamEnglish'
				}, {
					header : folderEnglishLabel,
					dataIndex : 'folderEnglish'
				}, {
					header : leafEnglishLabel,
					dataIndex : 'leafEnglish'
				}, {
					header : staffNameLabel,
					dataIndex : 'staffName'
				}, leafAccessDraftValue,leafAccessCreateValue, leafAccessReadValue,
						leafAccessUpdateValue, leafAccessDeleteValue,
						leafAccessPrintValue, leafAccessReviewValue,leafAccessPostValue ]
			});

			var teamId = new Ext.ux.form.ComboBoxMatch(
					{
						labelAlign : 'left',
						fieldLabel : teamIdLabel,
						name : 'teamId',
						hiddenName : 'teamId',
						valueField : 'teamId',
						hiddenId : 'team_fake',
						id : 'teamId',
						displayField : 'teamEnglish',
						typeAhead : false,
						triggerAction : 'all',
						store : teamStore,
						anchor : '95%',
						selectOnFocus : true,
						mode : 'local',
						allowBlank : false,
						blankText : blankTextLabel,
						createValueMatcher : function(value) {
							value = String(value).replace(/\s*/g, '');
							if (Ext.isEmpty(value, false)) {
								return new RegExp('^');
							}
							value = Ext.escapeRe(value.split('').join('\\s*'))
									.replace(/\\\\s\\\*/g, '\\s*');
							return new RegExp('\\b(' + value + ')', 'i');
						},
						listeners : {
							'select' : function(combo, record, index) {
								Ext.getCmp('moduleId').reset();
								
								moduleStore.load({
									params :{
										leafId : leafId ,
										isAdmin : isAdmin,
										teamId : Ext.getCmp('teamId').getValue(),
										type : 2
									}	
								});
								Ext.getCmp('moduleId').enable();
								Ext.getCmp('gridPanel').enable();
								
								leafAccessStore.load({
									params :{
										leafId : leafId ,
										isAdmin : isAdmin,
										teamId : Ext.getCmp('teamId').getValue()
									}	
								});
							}
						}
					});

			var moduleId = new Ext.ux.form.ComboBoxMatch(
					{
						labelAlign : 'left',
						fieldLabel : moduleIdLabel,
						name : 'moduleId',
						hiddenName : 'moduleId',
						valueField : 'moduleId',
						hiddenId : 'module_fake',
						id : 'moduleId',
						displayField : 'moduleEnglish',
						typeAhead : false,
						triggerAction : 'all',
						store : moduleStore,
						anchor : '95%',
						selectOnFocus : true,
						mode : 'local',
						allowBlank : false,
						blankText : blankTextLabel,
						createValueMatcher : function(value) {
							value = String(value).replace(/\s*/g, '');
							if (Ext.isEmpty(value, false)) {
								return new RegExp('^');
							}
							value = Ext.escapeRe(value.split('').join('\\s*'))
									.replace(/\\\\s\\\*/g, '\\s*');
							return new RegExp('\\b(' + value + ')', 'i');
						},
						disabled : true,
						listeners : {
							'select' : function(combo, record, index) {
								Ext.getCmp('folderId').reset();
								
								folderStore.load({
									params :{
										leafId : leafId ,
										isAdmin : isAdmin,
										teamId : Ext.getCmp('teamId').getValue(),
										moduleId : Ext.getCmp('moduleId').getValue(),
										type : 2
									}	
								});
								Ext.getCmp('folderId').enable();
								Ext.getCmp('gridPanel').enable();
								
								leafAccessStore.load({
									params :{
										leafId : leafId ,
										isAdmin : isAdmin,
										teamId : Ext.getCmp('teamId'),
										moduleId : Ext.getCmp('moduleId').getValue()
									}	
								});
							}
						}
					});

			var folderId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : folderIdLabel,
				name : 'folderId',
				hiddenName : 'folderId',
				valueField : 'folderId',
				hiddenId : 'folder_fake',
				id:'folderId',
				displayField : 'folderEnglish',
				typeAhead : false,
				triggerAction : 'all',
				store : folderStore,
				anchor : '95%',
				selectOnFocus : true,
				mode : 'local',
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
				},
				disabled : true,
				listeners : {
					'select' : function(combo, record, index) {
						if (this.value == '') {
							Ext.getCmp('gridPanel').disable();
						} else {
							Ext.getCmp('gridPanel').enable();
						}
						leafAccessStore.load({
							params :{
								leafId : leafId ,
								isAdmin : isAdmin,
								teamId : Ext.getCmp('teamId'),
								moduleId : Ext.getCmp('moduleId').getValue(),
								folderId : Ext.getCmp('folderId').getValue()
							}	
						});

					}
				}
			});

			var staffId = new Ext.ux.form.ComboBoxMatch(
					{
						labelAlign : 'left',
						fieldLabel : staffIdLabel,
						name : 'staffId',
						hiddenName : 'staffId',
						valueField : 'staffId',
						hiddenId : 'staff_fake',
						id : 'staffId',
						displayField : 'staffName',
						typeAhead : false,
						triggerAction : 'all',
						store : staffByStore,
						anchor : '95%',
						selectOnFocus : true,
						mode : 'local',
						allowBlank : false,
						blankText : blankTextLabel,
						createValueMatcher : function(value) {
							value = String(value).replace(/\s*/g, '');
							if (Ext.isEmpty(value, false)) {
								return new RegExp('^');
							}
							value = Ext.escapeRe(value.split('').join('\\s*'))
									.replace(/\\\\s\\\*/g, '\\s*');
							return new RegExp('\\b(' + value + ')', 'i');
						},
						disabled : true,
						listeners : {
							'select' : function(combo, record, index) {
								if (this.value == '') {
									gridPanel.disable();
								} else {
									gridPanel.enable();
								}
								folderStore.load({
									params :{
										leafId : leafId ,
										isAdmin : isAdmin,
										teamId : Ext.getCmp('teamId'),
										moduleId : Ext.getCmp('moduleId').getValue()
									}	
								});
								gridPanel.store.reload(); // force the grid
								// the reload

							}
						}
					});
			var formPanel = new Ext.Panel({
				region : 'center',
				layout : 'form',
				frame : true,
				title : 'leaf Form',
				iconCls : 'application_form',
				items : [ teamId, moduleId, folderId, staffId ]

			});
			var accessArray = [ 'leafAccessCreateValue',
					'leafAccessReadValue', 'leafAccessUpdateValue',
					'leafAccessDeleteValue', 'leafAccessPrintValue',
					'leafAccessPostValue', 'leafAccessReviewValue',
					'leafAccessDraftValue' ];
			var gridPanel = new Ext.grid.GridPanel(
					{
						id : 'gridPanel',
						region : 'west',
						store : leafAccessStore,
						cm : leafAccessColumnModel,
						autoHeight : false,
						height : 360,
						frame : true,
						title : 'Leaf Access Grid',
						disabled : true,
						iconCls : 'application_view_detail',
						plugins : [ leafAccessDraftValue,
								leafAccessCreateValue, leafAccessReadValue,
								leafAccessUpdateValue, leafAccessDeleteValue,
								leafAccessPrintValue, leafAccessReviewValue,
								leafAccessPostValue ],
						tbar : {
							items : [
									{
										text : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {

												leafAccessStore
														.each(function(rec) {
															for ( var access in accessArray) {

																rec
																		.set(
																				accessArray[access],
																				true);
															}
														});
											}
										}
									},
									{
										text : ClearAllLabel,
										iconCls : 'row-check-sprite-uncheck',
										listeners : {
											'click' : function() {
												leafAccessStore
														.each(function(rec) {
															for ( var access in accessArray) {
																rec
																		.set(
																				accessArray[access],
																				false);
															}
														});
											}
										}
									},
									{
										text : saveButtonLabel,
										iconCls : 'bullet_disk',
										listeners : {
											'click' : function(c) {
												var url;

												url = '../controller/leafAccessController.php?method=update&leafId='
														+ leafId;
												var sub_url;
												sub_url = '';
												var modified = leafAccessStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = leafAccessStore
															.getAt(i);
													sub_url = sub_url
															+ '&leafAccessId[]='
															+ record
																	.get('leafAccessId');
													sub_url = sub_url
															+ '&leafAccessCreateValue[]='
															+ record
																	.get('leafAccessCreateValue');
													sub_url = sub_url
															+ '&leafAccessReadValue[]='
															+ record
																	.get('leafAccessReadValue');
													sub_url = sub_url
															+ '&leafAccessUpdateValue[]='
															+ record
																	.get('leafAccessUpdateValue');
													sub_url = sub_url
															+ '&leafAccessDeleteValue[]='
															+ record
																	.get('leafAccessDeleteValue');
													sub_url = sub_url
															+ '&leafAccessPrintValue[]='
															+ record
																	.get('leafAccessPrintValue');
													sub_url = sub_url
															+ '&leafAccessPostValue[]='
															+ record
																	.get('leafAccessPostValue');
												}
												url = url + sub_url;
												// reques and ajax
												Ext.Ajax
														.request({
															url : url,
															success : function(
																	response,
																	options) {
																jsonResponse = Ext
																		.decode(response.responseText);

																if (jsonResponse.message == true) {

																	Ext.MessageBox
																			.alert(
																					systemLabel,
																					jsonResponse.message);
																} else if (jsonResponse.message == false) {

																	Ext.MessageBox
																			.alert(
																					systemErrorLabel,
																					jsonResponse.message);
																}

																// reload the
																// store
																leafAccessStore
																		.reload();
															},
															failure : function(
																	response,
																	options) {

																Ext.MessageBox
																		.alert(
																				systemErrorLabel,
																				escape(response.status)
																						+ ":"
																						+ escape(response.statusText));
															}
														});
												// refresh the store
											}

										}
									} ]
						}
					});

			var viewPort = new Ext.Viewport({
				id : 'viewport',
				layout : 'form',
				frame : true,
				items : [ formPanel, gridPanel ]
			});
		});
