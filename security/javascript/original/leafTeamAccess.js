Ext
		.onReady(function() {
			Ext.form.Field.prototype.msgTarget = 'under';
			var pageCreate;
			var pageReload;
			var pagePrint;
			if (leafTeamAccessCreateValue == 1) {
				pageCreate = false;
			} else {
				pageCreate = true;
			}
			if (leafTeamAccessReadValue == 1) {
				pageReload = false;
			} else {
				pageReload = true;
			}
			if (leafTeamAccessPrintValue == 1) {
				pagePrint = false;
			} else {
				pagePrint = true;
			}

			var perPage = 10;
			var encode = false;
			var local = false;
			var leafTeamAccessProxy = new Ext.data.HttpProxy({
				url : "../controller/leafTeamAccessController.php",
				method : 'POST',
				baseParams : {
					method : "read",
					leafId : leafId,
					isAdmin : isAdmin
				},
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
			var leafTeamAccessReader = new Ext.data.JsonReader({
				root : "data",
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "leafTeamAccessReaderId"
			});
			var leafTeamAccessStore = new Ext.data.JsonStore({
				autoDestroy : true,
				proxy : leafTeamAccessProxy,
				reader : leafTeamAccessReader,
				fields : [ {
					name : 'moduleId',
					type : 'int'
				}, {
					name : 'leafTeamAccessId',
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
					name : 'staffName',
					type : 'string'
				}, {
					name : 'staffId',
					type : 'int'
				}, {
					name : 'leafTeamAccessCreateValue',
					type : 'boolean'
				}, {
					name : 'leafTeamAccessReadValue',
					type : 'boolean'
				}, {
					name : 'leafTeamAccessUpdateValue',
					type : 'boolean'
				}, {
					name : 'leafTeamAccessDeleteValue',
					type : 'boolean'
				}, {
					name : 'leafTeamAccessPrintValue',
					type : 'boolean'
				}, {
					name : 'leafTeamAccessPostValue',
					type : 'boolean'
				}, {
					name : 'leafTeamAccessDraftValue',
					type : 'boolean'
				}, {
					name : 'leafTeamAccessReviewValue',
					type : 'boolean'
				} ]
			});

			var teamProxy = new Ext.data.HttpProxy({
				url : "../controller/leafTeamAccessController.php",
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
				baseParams : {
					method : "read",
					leafId : leafId,
					field : "teamId"
				},
				root : 'team',
				fields : [ {
					name : 'teamId',
					type : 'int'
				}, {
					name : 'teamEnglish',
					type : 'string'
				} ]

			});

			var moduleProxy = new Ext.data.HttpProxy({
				url : "../controller/leafTeamAccessController.php",
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
				autoDestroy : true,
				proxy : moduleProxy,
				reader : moduleReader,
				baseParams : {
					method : "read",
					leafId : leafId,
					field : "moduleId"
				},
				root : 'module',
				fields : [ {
					name : 'moduleId',
					type : 'int'
				}, {
					name : 'moduleEnglish',
					type : 'string'
				} ]

			});

			var folderProxy = new Ext.data.HttpProxy({
				url : "../controller/leafTeamAccessController.php",
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

			var folderReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "folderId"
			});
			var folderStore = new Ext.data.JsonStore({
				autoDestroy : true,
				proxy : folderProxy,
				reader : folderReader,
				baseParams : {
					method : "read",
					leafId : leafId,
					field : "folderId"
				},
				root : 'folder',
				fields : [ {
					name : 'folderId',
					type : 'int'
				}, {
					name : 'folderEnglish',
					type : 'string'
				} ]

			});

			var leafTeamAccessCreateValue = new Ext.grid.CheckColumn({
				header : leafTeamAccessCreateValueLabel,
				dataIndex : 'leafTeamAccessCreateValue',
				id : 'leafTeamAccessCreateValue',
				width : 55
			});

			var leafTeamAccessReadValue = new Ext.grid.CheckColumn({
				header : leafTeamAccessReadValueLabel,
				dataIndex : 'leafTeamAccessReadValue',
				id : 'leafTeamAccessReadValue',
				width : 55
			});

			var leafTeamAccessUpdateValue = new Ext.grid.CheckColumn({
				header : leafTeamAccessUpdateValueLabel,
				dataIndex : 'leafTeamAccessUpdateValue',
				id : 'leafTeamAccessUpdateValue',
				width : 55
			});

			var leafTeamAccessDeleteValue = new Ext.grid.CheckColumn({
				header : leafTeamAccessDeleteValueLabel,
				dataIndex : 'leafTeamAccessDeleteValue',
				id : 'leafTeamAccessDeleteValue',
				width : 55
			});

			var leafTeamAccessPrintValue = new Ext.grid.CheckColumn({
				header : leafTeamAccessPrintValueLabel,
				dataIndex : 'leafTeamAccessPrintValue',
				id : 'leafTeamAccessPrintValue',
				width : 55
			});

			var leafTeamAccessPostValue = new Ext.grid.CheckColumn({
				header : leafTeamAccessPostValueLabel,
				dataIndex : 'leafTeamAccessPostValue',
				id : 'leafTeamAccessPostValue',
				width : 55
			});

			var leafTeamAccessReviewValue = new Ext.grid.CheckColumn({
				header : leafTeamAccessReviewValueLabel,
				dataIndex : 'leafTeamAccessReviewlue',
				id : 'leafTeamAccessReviewValue',
				width : 55
			});

			var leafTeamAccessDraftValue = new Ext.grid.CheckColumn({
				header : leafTeamAccessDraftValueLabel,
				dataIndex : 'leafTeamAccessDraftValue',
				id : 'leafTeamAccessDraftValue',
				width : 55
			});

			// the id for administrator to see in any problem.User cannot see
			// this page information
			var leafTeamAccessColumnModel = new Ext.grid.ColumnModel({
				columns : [ {
					header : moduleEnglishLabel,
					dataIndex : 'moduleNative'
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
				}, leafTeamAccessDraftValue, leafTeamAccessCreateValue,
						leafTeamAccessReadValue, leafTeamAccessUpdateValue,
						leafTeamAccessDeleteValue, leafTeamAccessPrintValue,
						leafTeamAccessReviewValue, leafTeamAccessPostValue ]
			});

			var teamId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : teamIdLabel,
				name : 'teamId',
				hiddenName : 'teamId',
				hiddenId : 'teamFakeId',
				valueField : 'teamId',
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
					value = Ext.escapeRe(value.split('').join('\\s*')).replace(
							/\\\\s\\\*/g, '\\s*');
					return new RegExp('\\b(' + value + ')', 'i');
				},
				listeners : {
					'select' : function(combo, record, index) {
						Ext.getCmp('moduleId').reset();
						moduleStore.load({
							params : {
								teamId : Ext.getCmp('teamId').getValue(),
								type :2,
								leafId : leafId,
								isAdmin : isAdmin

							}
						});
						Ext.getCmp('moduleId').enable();
						Ext.getCmp('gridPanel').enable();

						leafTeamAccessStore.load({
							params : {
								teamId : Ext.getCmp('teamId').getValue(),
								leafId : leafId,
								isAdmin : isAdmin,
								method : 'read'

							}
						});
					}
				}
			});

			var moduleId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : moduleIdLabel,
				name : 'moduleId',
				hiddenName : 'moduleId',
				hiddenId : 'moduleFake',
				valueField : 'moduleId',
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
					value = Ext.escapeRe(value.split('').join('\\s*')).replace(
							/\\\\s\\\*/g, '\\s*');
					return new RegExp('\\b(' + value + ')', 'i');
				},
				disabled : true,
				listeners : {
					'select' : function(combo, record, index) {
						Ext.getCmp('folderId').reset();

						folderStore.load({
							params : {
								teamId : Ext.getCmp('teamId').getValue(),
								moduleId : Ext.getCmp('moduleId').getValue(),
								type :2,
								leafId : leafId,
								isAdmin : isAdmin

							}
						});
					
						Ext.getCmp('folderId').enable();
						Ext.getCmp('gridPanel').enable();

						leafTeamAccessStore.load({
							params : {
								teamId : Ext.getCmp('teamId').getValue(),
								moduleId : Ext.getCmp('moduleId').getValue(),
								leafId : leafId,
								isAdmin : isAdmin,
								method : 'read'

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
				hiddenId : 'folderFakeId',
				id : 'folderId',
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
						leafTeamAccessStore.load({
							params : {
								teamId : Ext.getCmp('teamId').getValue(),
								moduleId : Ext.getCmp('moduleId').getValue(),
								folderId : Ext.getCmp('folderId').getValue(),
								leafId : leafId,
								isAdmin : isAdmin,
								method : 'read'

							}
						});

					}
				}
			});
			// compare with the user leaf.Here Module and Folder just filtering
			// mode
			var formPanel = new Ext.Panel({
				region : 'north',
				layout : 'form',
				frame : true,
				title : 'leaf Form',
				iconCls : 'application_form',
				autoScroll : true,
				items : [ teamId, moduleId, folderId ]
			});
			var access_array = [ 'leafTeamAccessCreateValue',
					'leafTeamAccessReadValue', 'leafTeamAccessUpdateValue',
					'leafTeamAccessDeleteValue', 'leafTeamAccessPrintValue',
					'leafTeamAccessPostValue' ];
			var grid = new Ext.grid.GridPanel(
					{
						region : 'west',
						id : 'gridPanel',
						store : leafTeamAccessStore,
						cm : leafTeamAccessColumnModel,
						frame : true,

						title : 'leaf Access Grid',
						disabled : true,
						iconCls : 'application_view_detail',
						viewConfig : {
							emptyText : 'No rows to display'
						},
						autoScroll : true,
						autoHeight : false,
						height : 400,
						plugins : [ leafTeamAccessCreateValue,
								leafTeamAccessReadValue,
								leafTeamAccessUpdateValue,
								leafTeamAccessDeleteValue,
								leafTeamAccessPrintValue,
								leafTeamAccessPostValue ],
						tbar : {
							items : [
									{
										text : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {

												leafTeamAccessStore
														.each(function(rec) {
															for ( var access in access_array) {
																rec
																		.set(
																				access_array[access],
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
												leafTeamAccessStore
														.each(function(rec) {
															for ( var access in access_array) {
																rec
																		.set(
																				access_array[access],
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

												url = '../controller/leafTeamAccessController.php?method=update&leafId='
														+ leafId;
												var sub_url;
												sub_url = '';
												var modified = leafTeamAccessStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = leafTeamAccessStore
															.getAt(i);
													sub_url = sub_url
															+ record
																	.get('leafTeamAccessId')
															+ ',';
													sub_url = sub_url
															+ record
																	.get('leafTeamAccessCreateValue')
															+ ',';
													sub_url = sub_url
															+ record
																	.get('leafTeamAccessReadValue')
															+ ',';
													sub_url = sub_url
															+ record
																	.get('leafTeamAccessUpdateValue')
															+ ',';
													sub_url = sub_url
															+ record
																	.get('leafTeamAccessDeleteValue')
															+ ',';
													sub_url = sub_url
															+ record
																	.get('leafTeamAccessPrintValue')
															+ ',';
													sub_url = sub_url
															+ record
																	.get('leafTeamAccessPostValue');
													sub_url = sub_url + '|';
												}
												// url = url+sub_url;
												// using post method because
												// limitation $_GET value post
												// on all browser.
												Ext.Ajax
														.request({
															url : url,
															params : {
																info : sub_url
															},
															method : 'POST',
															success : function(
																	response,
																	options) {
																jsonResponse = Ext
																		.decode(response.responseText);
																if (jsonResponse == false) {
																	Ext.MessageBox
																			.alert(
																					'System Error',
																					jsonResponse.message);
																} else {
																	Ext.MessageBox
																			.alert(
																					'System Okay',
																					'success updated');
																}

																// reload the
																// store
																leafTeamAccessStore
																		.reload();
															},
															failure : function(
																	response,
																	options) {
																statusCode = response.status;
																statusMessage = response.statusText;
																Ext.MessageBox
																		.alert(
																				systemLabel,
																				escape(statusCode)
																						+ ":"
																						+ statusMessage);
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
				items : [ formPanel, grid ]
			});
		});
