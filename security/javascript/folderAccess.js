Ext
		.onReady(function() {

			if (leafCreateAccessValue == 1) {
				var page_create = false;
			} else {
				var page_create = true;
			}
			if (leafReadAccessValue == 1) {
				var page_reload = false;
			} else {
				var page_reload = true;
			}
			if (leafPrintAccessValue == 1) {
				var page_print = false;
			} else {
				var page_print = true;
			}
			// form panel + grid.When choose the form then activated filter the
			// grid.Grid will automatically update on demand
			// first viewport
			var per_page = 10;
			var encode = false;
			var local = false;
			var folderAccessProxy =  new Ext.data.HttpProxy({
				url : "../controller/folderAccessController.php",
				method : 'POST',
				baseParams : {
					method : "read",
					page : "master",
					leafId : leafId
				},
				success : function(response, options) {
					var x = Ext.decode(response.responseText);
					if (x.success == "true") {
						title = successLabel;
					} else {
						title = failureLabel;
					}
					Ext.MessageBox.alert(systemLabel, x.message);
				},
				failure : function(response, options) {

					Ext.MessageBox.alert(systemErrorLabel,
							escape(response.Status) + ":"
									+ escape(response.statusText));
				}
			});
			var folderAccessReader = new Ext.data.JsonReader({
				root : "data",
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				fields : [{
					name : 'accordionId',
					type : 'int'
				}, {
					name : 'accordionNote',
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
			var folderAccessStore = new Ext.data.JsonStore({
				autoDestroy : true,
			
				proxy : folderAccessProxy
				reader : folderAccessReader
				
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
					header : accordionNameLabel,
					dataIndex : 'accordionNote'
				}, {
					header : accordionIdLabel,
					dataIndex : 'accordionId'
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

			var groupReader = new Ext.data.JsonReader({
				root : 'group'
			}, [ 'groupId', 'groupNote' ]);
			var groupStore = new Ext.data.Store(
					{
						proxy : new Ext.data.HttpProxy(
								{
									url : '../controller/folderAccessController.php?method=read&field=groupId&leafId='
											+ leafId,
									method : 'GET'
								}),
						reader : groupReader,
						remoteSort : false
					});
			groupStore.load();

			var accordionReader = new Ext.data.JsonReader({
				root : 'accordion'
			}, [ 'accordionId', 'accordionNote' ]);
			var accordionStore = new Ext.data.Store(
					{
						proxy : new Ext.data.HttpProxy(
								{
									url : '../controller/folderAccessController.php?method=read&type=1&field=accordionId&leafId='
											+ leafId,
									method : 'GET'
								}),
						reader : accordionReader,
						remoteSort : false
					});
			accordionStore.load();
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
								Ext.getCmp('accordion_fake').reset(); // force
								// the
								// combobox
								// to
								// clear
								accordionStore.proxy = new Ext.data.HttpProxy(
										{
											url : '../controller/folderAccessController.php?method=read&field=accordionId&value='
													+ this.value
													+ '&leafId='
													+ leafId,
											method : 'GET'

										});
								Ext.getCmp('accordion_fake').enable();
							}
						}
					});

			var accordionId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : accordionIdLabel,
				name : 'accordionId',
				hiddenName : 'accordionId',
				valueField : 'accordionId',
				id : 'accordion_fake',
				displayField : 'accordionNote',
				typeAhead : false,
				triggerAction : 'all',
				store : accordionStore,
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
								leafId : leafId,
								groupId : Ext.getCmp('group_fake').getValue(),
								accordionId : Ext.getCmp('accordion_fake')
										.getValue()
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
				items : [ groupId, accordionId ]
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
															+ '&accordionId='
															+ Ext
																	.getCmp('accordion_fake').value
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
																x = Ext
																		.decode(response.responseText);
																title = 'Update ';
																if (x.success == 'true') {
																	title = title
																			+ ' Success';
																	Ext.MessageBox
																			.alert(
																					title,
																					x.message);
																} else if (x.success == 'false') {
																	title = title
																			+ 'Failure';
																	Ext.MessageBox
																			.alert(
																					title,
																					x.message);
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
