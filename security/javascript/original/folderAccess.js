Ext
		.onReady(function() {

			Ext.QuickTips.init();
			Ext.BLANK_IMAGE_URL = "../../javascript/resources/images/s.gif";
			Ext.form.Field.prototype.msgTarget = "under";
			Ext.Ajax.timeout = 90000;
			
			var pageCreate;
			var pageReload;
			var pagePrint;;
			var perPage = 15;
			var encode = false;
			var local = false;
			var jsonResponse;
			var duplicate = 0;
			
			
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
					isAdmin : isAdmin,
					leafId : leafId
				},
				root : "data",
				fields : [ {
					name : 'moduleId',
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
					name : 'folderAccessId',
					type : 'int'
				}, {
					name : 'folderEnglish',
					type : 'string'
				}, {
					name : 'folderAccessValue',
					type : 'boolean'
				} ]
			});

			var teamProxy = new Ext.data.HttpProxy({
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
			var teamReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "teamId"
			});

			var teamStore = new Ext.data.JsonStore({
				proxy : teamProxy,
				reader : teamReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,

				baseParams : {
					method : "read",
					field : "teamId",
					leafId : leafId
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
					name : 'moduleEnglish',
					type : 'string'
				} ]

			});

			var folderAccessValue = new Ext.ux.grid.CheckColumn({
				header : 'Access',
				dataIndex : 'folderAccessValue'
			});

			var folderAccessColumnModel = new Ext.grid.ColumnModel({
				columns : [ {
					header : moduleEnglishLabel,
					dataIndex : 'moduleEnglish'
				}, folderAccessValue ]
			});

			var teamId = new Ext.ux.form.ComboBoxMatch({
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
					value = Ext.escapeRe(value.split('').join('\\s*')).replace(
							/\\\\s\\\*/g, '\\s*');
					return new RegExp('\\b(' + value + ')', 'i');
				},
				listeners : {
					'select' : function(combo, record, index) {
						Ext.getCmp('moduleId').reset(); // force the combobox to
														// clear

						moduleStore.load({
							params : {
								method : 'read',
								field : 'moduleId',
								leafId : leafId,
								teamId : this.value,
								type : 2
							}
						});
						Ext.getCmp('moduleId').enable();
					}
				}
			});

			var moduleId = new Ext.ux.form.ComboBoxMatch({
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
								method : 'read',
								leafId : leafId,
								teamId : Ext.getCmp('teamId').getValue(),
								moduleId : Ext.getCmp('moduleId').getValue()
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
				items : [ teamId, moduleId ]
			});
			var accessArray = [ 'folderAccessValue' ];

			var gridPanel = new Ext.grid.GridPanel(
					{
						region : 'west',
						store : folderAccessStore,
						cm : folderAccessColumnModel,
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
										text : CheckAllLabel,
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {

												folderAccessStore
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
										text:ClearAllLabel,
										iconCls : 'row-check-sprite-uncheck',
										listeners : {
											'click' : function() {
												folderAccessStore
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
												

												url = '../controller/folderAccessController.php?method=update&leafId='
														+ leafId;
												var sub_url;
												sub_url = '';
												var modified = folderAccessStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = folderAccessStore
															.getAt(i);
													sub_url = sub_url
															+ '&teamId='
															+ Ext.getCmp(
																	'teamId')
																	.getValue()
															+ '&moduleId='
															+ Ext
																	.getCmp('moduleId').value
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
																
																if (jsonResponse == true) {
																
																	Ext.MessageBox
																			.alert(
																					systemLabel,
																					jsonResponse.message);
																} else if (jsonResponse == false) {
																	
																	Ext.MessageBox
																			.alert(
																					systemErrorLabel,
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