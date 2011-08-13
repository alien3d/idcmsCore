Ext
		.onReady(function() {

			if (leafCreateAccessValue == 1) {
				var pageCreate = false;
			} else {
				var pageCreate = true;
			}
			if (leafReadAccessValue == 1) {
				var pageReload = false;
			} else {
				var pageReload = true;
			}
			if (leafPrintAccessValue == 1) {
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
			var jsonResponse;
			var folderAccessProxy = new Ext.data.HttpProxy({
				url : "../controller/folderAccessController.php",
				method : 'POST',
				
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
			var folderAccessReader = new Ext.data.JsonReader({

				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "folderAccessId"

			});
			/*
			 * cannot create autoload here
			 */
			var folderAccessStore = new Ext.data.JsonStore({

				autoDestroy : true,
				proxy : folderAccessProxy,
				reader : folderAccessReader,
				baseParams : {
					method : "read",
					grid : "master",
					leafId : leafId
				},
				root : "data",
				fields : [ {
					name : 'moduleId',
					type : 'int'
				}, {
					name : 'moduleNote',
					type : 'string'
				}, {
					name : 'groupId',
					type : 'int'
				}, {
					name : 'groupNote',
					type : 'string'
				}, {
					name : 'folderId',
					type : 'int'
				}, {
					name : 'folderAccessId',
					type : 'int'
				}, {
					name : 'folderNote',
					type : 'string'
				}, {
					name : 'folderAccessValue',
					type : 'boolean'
				} ]
			});

			var groupProxy = new Ext.data.HttpProxy({
				url : "../controller/folderAccessController.php",
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
			var groupReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "groupId"
			});

			var groupStore = new Ext.data.JsonStore({
				proxy : groupProxy,
				reader : groupReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,

				baseParams : {
					method : "read",
					field : "groupId",
					leafId : leafId
				},
				root : 'group',
				fields : [ {
					name : 'groupId',
					type : 'int'
				}, {
					name : 'groupNote',
					type : 'string'
				} ]

			});

			var moduleProxy = new Ext.data.HttpProxy({
				url : "../controller/folderAccessController.php",
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

			var folderAccessValue = new Ext.ux.grid.CheckColumn({
				header : 'Access',
				dataIndex : 'folderAccessValue'
			});

			// the id for administrator to see in any problem.User cannot see
			// this page
			// information
			var columnModel = new Ext.grid.ColumnModel({
				columns : [ {
					header : moduleNameLabel,
					dataIndex : 'moduleNote'
				}, {
					header : moduleIdLabel,
					dataIndex : 'moduleId'
				}, {
					header : groupNameLabel,
					dataIndex : 'groupNote'
				}, {
					header : groupIdLabel,
					dataIndex : 'groupId'
				}, {
					header : folderNameLabel,
					dataIndex : 'folderNote'
				}, {
					header : folderIdLabel,
					dataIndex : 'folderId'
				}, folderAccessValue ]
			});

			var groupId = new Ext.ux.form.ComboBoxMatch(
					{
						labelAlign : 'left',
						fieldLabel : groupIdLabel,
						name : 'groupId',
						hiddenName : 'groupId',
						valueField : 'groupId',
						id : 'group_fake',
						displayField : 'groupNote',
						typeAhead : false,
						triggerAction : 'all',
						store : groupStore,
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
								Ext.getCmp('module_fake').reset(); // force the combobox to clear
								
								moduleStore.load({
									params:{
										method:'read',
										field:'moduleId',
										leafId:leafId,
										groupId:this.value,
										type:2
									}
								});
								Ext.getCmp('module_fake').enable();
							}
						}
					});

			var moduleId = new Ext.ux.form.ComboBoxMatch({
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
					value = Ext.escapeRe(value.split('').join('\\s*')).replace(
							/\\\\s\\\*/g, '\\s*');
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

						folderAccessStore.load({
							params : {
								method:'read',
								leafId : leafId,
								groupId : Ext.getCmp('group_fake').getValue(),
								moduleId : Ext.getCmp('module_fake').getValue()
							}

						});
					}
				}
			});

			var formPanel = new Ext.Panel({
				region : 'center',
				layout : 'form',
				frame : true,
				title : 'Folder Form',
				iconCls : 'application_form',
				items : [ groupId, moduleId ]
			});
			var access_array = [ 'folderAccessValue' ];

			var gridPanel = new Ext.grid.GridPanel(
					{
						region : 'west',
						store : folderAccessStore,
						cm : columnModel,
						frame : true,
						title : 'Folder Access Grid',
						autoHeight : true,
						disabled : true,
						selModel : folderAccessValue,
						iconCls : 'application_view_detail',
						viewConfig : {
							forceFit : true,
							emptyText : emptyTextLabel
						},
						tbar : {
							items : [
									{
										text : 'Check All',
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												var count = folderAccessStore
														.getCount();
												folderAccessStore
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
										text : 'Clear All',
										iconCls : 'row-check-sprite-uncheck',
										listeners : {
											'click' : function() {
												folderAccessStore
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
										text : 'save',
										iconCls : 'bullet_disk',
										listeners : {
											'click' : function(c) {
												var url;
												var count = folderAccessStore
														.getCount();

												url = '../controller/folderAccessController.php?method=update&leafId='
														+ leafId;
												var sub_url;
												sub_url = '';
												for (i = count - 1; i >= 0; i--) {
													var record = folderAccessStore
															.getAt(i);
													sub_url = sub_url
															+ '&groupId='
															+ Ext
																	.getCmp(
																			'group_fake')
																	.getValue()
															+ '&moduleId='
															+ Ext
																	.getCmp('module_fake').value
															+ '&folderAccessId[]='
															+ record
																	.get('folderAccessId')
															+ '&folderAccessValue[]='
															+ record
																	.get('folderAccessValue');
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
																title = 'Update ';
																if (jsonResponse == true) {
																	title = title
																			+ ' Success';
																	Ext.MessageBox
																			.alert(
																					title,
																					jsonResponse.message);
																} else if (jsonResponse == false) {
																	title = title
																			+ 'Failure';
																	Ext.MessageBox
																			.alert(
																					title,
																					jsonResponse.message);
																}
																// reload the
																// store
																folderAccessStore
																		.reload();
															},
															failure : function(
																	response,
																	options) {
																statusCode = response.status;
																statusMessage = response.statusText;
																Ext.MessageBox
																		.alert(
																				systemErrorLabel,
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
				items : [ formPanel, gridPanel ]
			});
		});