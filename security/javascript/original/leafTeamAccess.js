Ext
		.onReady(function() {
			Ext.form.Field.prototype.msgTarget = 'under';
			var pageCreate;
			var pageReload;
			var pagePrint;
			if (leafCreateAccessValue == 1) {
				var pageCreate = false;
			} else {
				var pageCreate = true;
			}
			if (leafAccessReadValue == 1) {
				var pageReload = false;
			} else {
				var pageReload = true;
			}
			if (leafAccessPrintValue == 1) {
				var pagePrint = false;
			} else {
				var pagePrint = true;
			}
			// form panel + grid.When choose the form then activated filter the
			// grid.Grid will automatically update on demand
			// first viewport
			var perPage = 10;
			var encode = false;
			var local = false;
			var leafGroupAccessProxy = new Ext.data.HttpProxy({
				url : "../controller/leaf/leafTeamAccessController.php",
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
			var leafGroupAccessReader = new Ext.data.JsonReader({
				root : "data",
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				fields : [ {
					name : 'moduleId',
					type : 'int'
				}, {
					name : 'leafGroupAccessId',
					type : 'int'
				}, {
					name : 'moduleNote',
					type : 'string'
				}, {
					name : 'teamId',
					type : 'int'
				}, {
					name : 'teamNote',
					type : 'string'
				}, {
					name : 'folderId',
					type : 'int'
				}, {
					name : 'folderNote',
					type : 'string'
				}, {
					name : 'leafId',
					type : 'int'
				}, {
					name : 'leafNote',
					type : 'string'
				}, {
					name : 'staffName',
					type : 'string'
				}, {
					name : 'staffId',
					type : 'int'
				}, {
					name : 'leafCreateAccessValue',
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
			var leafTeamAccessStore = new Ext.data.JsonStore({
				autoDestroy : true,
				proxy : leafGroupAccessProxy,
				reader : leafGroupAccessReader
			});

			var groupProxy = new Ext.data.HttpProxy({
				url : "../controller/folderAccessController.php",
				method : 'GET',

				success : function(response, options) {
					var jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse == "true") {
						title = successLabel;
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
			var groupReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "teamId"
			});

			var teamStore = new Ext.data.JsonStore({
				autoLoad : true,
				autoDestroy : true,
				proxy : groupProxy,
				reader : groupReader,
				baseParams : {
					method : "read",
					leafId : leafId,
					field : "teamId"
				},
				root : 'group',
				fields : [ {
					name : 'teamId',
					type : 'int'
				}, {
					name : 'teamNote',
					type : 'string'
				} ]

			});

			var moduleProxy = new Ext.data.HttpProxy({
				url : "../controller/folderAccessController.php",
				method : 'GET',

				success : function(response, options) {
					var jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse == "true") {
						title = successLabel;
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
					name : 'moduleNote',
					type : 'string'
				} ]

			});

			var folderProxy = new Ext.data.HttpProxy({
				url : "../controller/folderAccessController.php",
				method : 'GET',

				success : function(response, options) {
					var jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse == "true") {
						title = successLabel;
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
					name : 'folderNote',
					type : 'string'
				} ]

			});

			var leafCreateAccessValue = new Ext.grid.CheckColumn({
				header : leafCreateAccessValueLabel,
				dataIndex : 'leafCreateAccessValue',
				id : 'leafCreateAccessValue',
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

			// the id for administrator to see in any problem.User cannot see
			// this page information
			var columnModel = new Ext.grid.ColumnModel({
				columns : [ {
					header : moduleNameLabel,
					dataIndex : 'moduleNote'
				}, {
					header : groupNameLabel,
					dataIndex : 'teamNote'
				}, {
					header : folderNameLabel,
					dataIndex : 'folderNote'
				}, {
					header : leafNoteLabel,
					dataIndex : 'leafNote'
				}, {
					header : staffNameLabel,
					dataIndex : 'staffName'
				}, leafCreateAccessValue, leafAccessReadValue,
						leafAccessUpdateValue, leafAccessDeleteValue,
						leafAccessPrintValue, leafAccessPostValue ]
			});

			var teamId = new Ext.ux.form.ComboBoxMatch(
					{
						labelAlign : 'left',
						fieldLabel : teamIdLabel,
						name : 'teamId',
						hiddenName : 'teamId',
						valueField : 'teamId',
						id : 'tam_fake',
						displayField : 'teamNote',
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
								module_store.proxy = new Ext.data.HttpProxy(
										{
											url : '../controller/leafGroupAccessController.php?method=read&field=moduleId&teamId='
													+ Ext.getCmp('teamId')
															.getValue()
													+ '&leafId=' + leafId,
											method : 'GET'
										});

								module_store.reload();
								Ext.getCmp('moduleId').enable();
								Ext.getCmp('gridPanel').enable();
								leafTeamAccessStore.proxy = new Ext.data.HttpProxy(
										{
											url : '../controller/leafGroupAccessController.php?teamId='
													+ Ext.getCmp('teamId')
															.getValue()
													+ '&leafId=' + leafId,
											method : 'GET'
										});
								leafTeamAccessStore.reload();
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
						id : 'module_fake',
						displayField : 'moduleNote',
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
								folder_store.proxy = new Ext.data.HttpProxy(
										{
											url : '../controller/leafGroupAccessController.php?method=read&field=folderId&teamId='
													+ Ext.getCmp('teamId')
															.getValue()
													+ '&moduleId='
													+ Ext.getCmp('moduleId')
															.getValue()
													+ '&leafId=' + leafId,
											method : 'GET'
										});

								folder_store.reload();
								Ext.getCmp('folderId').enable();
								Ext.getCmp('gridPanel').enable();
								leafTeamAccessStore.proxy = new Ext.data.HttpProxy(
										{
											url : '../controller/leafGroupAccessController.php?teamId='
													+ Ext.getCmp('teamId')
															.getValue()
													+ '&moduleId='
													+ Ext.getCmp('moduleId')
															.getValue()
													+ '&leafId=' + leafId,
											method : 'GET'
										});
								leafTeamAccessStore.reload();
							}
						}
					});

			var folderId = new Ext.ux.form.ComboBoxMatch(
					{
						labelAlign : 'left',
						fieldLabel : moduleIdLabel,
						name : 'folderId',
						hiddenName : 'folderId',
						valueField : 'folderId',
						id : 'folder_fake',
						displayField : 'folderNote',
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
							value = Ext.escapeRe(value.split('').join('\\s*'))
									.replace(/\\\\s\\\*/g, '\\s*');
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
								leafTeamAccessStore.proxy = new Ext.data.HttpProxy(
										{
											url : '../controller/leafGroupAccessController.php?teamId='
													+ Ext.getCmp('teamId')
															.getValue()
													+ '&moduleId='
													+ Ext.getCmp('moduleId')
															.getValue()
													+ '&folderId='
													+ Ext.getCmp('folderId')
															.getValue()
													+ '&leafId=' + leafId,
											method : 'GET'
										});
								leafTeamAccessStore.reload();

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
			var access_array = [ 'leafCreateAccessValue',
					'leafAccessReadValue', 'leafAccessUpdateValue',
					'leafAccessDeleteValue', 'leafAccessPrintValue',
					'leafAccessPostValue' ];
			var grid = new Ext.grid.GridPanel(
					{
						region : 'west',
						id : 'gridPanel',
						store : leafTeamAccessStore,
						cm : columnModel,
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
						plugins : [ leafCreateAccessValue, leafAccessReadValue,
								leafAccessUpdateValue, leafAccessDeleteValue,
								leafAccessPrintValue, leafAccessPostValue ],
						tbar : {
							items : [
									{
										text : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												var count = leafTeamAccessStore
														.getCount();
												leafTeamAccessStore
														.each(function(rec) {
															for ( var access in access_array) {
																// alert(access);
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
												var count = leafTeamAccessStore
														.getCount();

												url = '../controller/leafGroupAccessController.php?method=update&leafId='
														+ leafId;
												var sub_url;
												sub_url = '';
												for (i = count - 1; i >= 0; i--) {
													var record = leafTeamAccessStore
															.getAt(i);
													sub_url = sub_url
															+ record
																	.get('leafGroupAccessId')
															+ ',';
													sub_url = sub_url
															+ record
																	.get('leafCreateAccessValue')
															+ ',';
													sub_url = sub_url
															+ record
																	.get('leafAccessReadValue')
															+ ',';
													sub_url = sub_url
															+ record
																	.get('leafAccessUpdateValue')
															+ ',';
													sub_url = sub_url
															+ record
																	.get('leafAccessDeleteValue')
															+ ',';
													sub_url = sub_url
															+ record
																	.get('leafAccessPrintValue')
															+ ',';
													sub_url = sub_url
															+ record
																	.get('leafAccessPostValue');
													sub_url = sub_url + '|'; // this
																				// is
																				// to
																				// diffirenciate
																				// the
																				// array
																				// field
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
														/*
														 * failure:function(response,options) {
														 * var title='Message
														 * Failure'; if
														 * (action.failureType
														 * ===
														 * Ext.form.Action.LOAD_FAILURE){
														 * alert("Client ada
														 * Error 1 "); } else if
														 * (action.failureType
														 * ===
														 * Ext.form.Action.CLIENT_INVALID){ //
														 * here will be error if
														 * duplicate code
														 * alert("Client ada
														 * Error 2"); } else if
														 * (action.failureType
														 * ===
														 * Ext.form.Action.CONNECT_FAILURE){
														 * Ext.Msg.alert('Failure',
														 * 'Server
														 * reported:'+form.response.status+'
														 * '+form.response.statusText); }
														 * else if
														 * (action.failureType
														 * ===
														 * Ext.form.Action.SERVER_INVALID){
														 * Ext.Msg.alert(title,
														 * action.result.message); } }
														 */
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
