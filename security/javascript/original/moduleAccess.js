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
			// form panel + grid.When choose the form then activated filter the

			var perPage = 10;
			var encode = false;
			var local = false;
			var moduleAccessProxy = new Ext.data.HttpProxy({
				url : "../controller/moduleAccessController.php",
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
			var moduleAccessReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "moduleAccessId"
			});

			var moduleAccessStore = new Ext.data.JsonStore({
				proxy : moduleAccessProxy,
				reader : moduleAccessReader,
				autoDestroy : true,
				url : '../controller/moduleAccessController.php',
				remoteSort : true,
				storeId : 'myStore',
				root : 'data',
				totalProperty : 'total',
				baseParams : {
					method : 'read',
					mode : 'view',
					leafId : leafId
				},
				fields : [ {
					name : 'moduleAccessId',
					type : 'int'
				}, {
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
					name : 'moduleAccessValue',
					type : 'boolean'
				} ]
			});

			var teamProxy = new Ext.data.HttpProxy({
				url : "../controller/moduleAccessController.php",
				method : 'GET',

				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(successLabel,jsonResponse.message);
						// uncomment for testing purpose

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
			var moduleAccessValue = new Ext.ux.grid.CheckColumn({
				header : moduleAccessValueLabel,
				dataIndex : 'moduleAccessValue'
			});

			var moduleAccessColumnModel = new Ext.grid.ColumnModel({
				columns : [ {
					header : moduleEnglishLabel,
					hidden : false,
					dataIndex : 'moduleEnglish'
				}, {
					header : teamIdLabel,
					hidden : true,
					dataIndex : 'teamId'
				}, moduleAccessValue ]
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
						if (this.value == '') {
							gridPanel.disable();
						} else {
							gridPanel.enable();
						}

						moduleAccessStore.load({
							params : {
								leafId : leafId,
								teamId : this.value
							}
						});

					}
				}
			});

			var formPanel = new Ext.Panel({
				region : 'center',
				layout : 'form',
				frame : true,
				title : 'Accordian Access Form',
				iconCls : 'application_form',
				items : [ teamId ]
			});

			var accessArray = [ 'moduleAccessValue' ];
			var gridPanel = new Ext.grid.GridPanel(
					{
						region : 'west',
						store : moduleAccessStore,
						cm : moduleAccessColumnModel,
						frame : true,
						title : 'Module Access Grid',
						height : 200,
						autoHeight : true,
						autoScroll : true,
						layout : 'anchor',
						disabled : true,
						selModel : moduleAccessValue,
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

												moduleAccessStore
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
												moduleAccessStore
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

												url = '../controller/moduleAccessController.php?method=update&leafId='
														+ leafId;
												var sub_url;
												sub_url = '';
												var modified = moduleAccessStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = moduleAccessStore
															.getAt(i);
													sub_url = sub_url
															+ '&moduleAccessId[]='
															+ record
																	.get('moduleAccessId')
															+ '&moduleAccessValue[]='
															+ record
																	.get('moduleAccessValue');
												}
												url = url + sub_url;
										
												Ext.Ajax
														.request({
															url : url,
															success : function(
																	response,
																	options) {
																Ext.MessageBox
																		.alert('success updated');

																moduleAccessStore
																		.load({
																			params : {
																				teamId : Ext
																						.getCmp(
																								'teamId')
																						.getValue()
																			}
																		})
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
