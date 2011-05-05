Ext
		.onReady(function() {
			Ext.Ajax.timeout = 90000000;
			var leaf_id = new Ext.form.Hidden({
				name : 'leaf_id',
				id : 'leaf_id'
			});
			var temp;

			var page_create;
			var page_reload;
			var page_print;
			var xg = Ext.grid;
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
			Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';
			var per_page = 15;
			var encode = false;
			var local = false;
			var leafStore = new Ext.data.JsonStore({
				autoDestroy : true,
				url : '../controller/leafController.php',
				remoteSort : true,
				storeId : 'myStore',
				root : 'data',
				totalProperty : 'total',
				baseParams : {
					method : 'read',
					page : 'master',
					leafId_temp : leafId_temp
				},
				fields : [ {
					name : 'leafId',
					type : 'int'
				}, {
					name : 'accordionId',
					type : 'int'
				}, {
					name : 'accordionNote',
					type : 'string'
				}, {
					name : 'folderId',
					type : 'int'
				}, {
					name : 'folderNote',
					type : 'string'
				}, {
					name : 'leafNote',
					type : 'string'
				}, {
					name : 'leafNote',
					type : 'string'
				}, {
					name : 'leafSequence',
					type : 'int'
				}, {
					name : 'leafFilename',
					type : 'string'
				}, {
					name : 'iconId',
					type : 'int'
				}, {
					name : 'iconName',
					type : 'string'
				}, {
					name : 'By',
					type : 'int'
				}, {
					name : 'Time',
					type : 'date',
					dateFormat : 'Y-m-d H:i:s'
				} ],
				listeners : {
					exception : function(DataProxy, type, action, options,
							response, arg) {
						var serverMessage = Ext.util.JSON
								.decode(response.responseText);
						if (serverMessage.success == false) {
							Ext.MessageBox.alert(systemErrorLabel,
									serverMessage.message);
						}
					}
				}
			});

			var leafTranslateStore = new Ext.data.JsonStore({
				autoDestroy : true,
				url : '../controller/leafController.php',
				remoteSort : true,
				storeId : 'leafTranslateStore',
				root : 'data',
				totalProperty : 'total',
				baseParams : {
					method : 'read',
					page : 'detail',
					leafId : leafId
				},
				fields : [ {
					name : 'leafTranslateId',
					type : 'int'
				}, {
					name : 'leafId',
					type : 'int'
				}, {
					name : 'languageId',
					type : 'int'
				}, {
					name : 'languageCode',
					type : 'string'
				}, {
					name : 'languageDesc',
					type : 'string'
				}, {
					name : 'leafTranslate',
					type : 'string'
				} ],
				listeners : {
					exception : function(DataProxy, type, action, options,
							response, arg) {
						var serverMessage = Ext.util.JSON
								.decode(response.responseText);
						if (serverMessage.success == false) {
							Ext.MessageBox.alert(systemErrorLabel,
									serverMessage.message);
						}
					}
				}
			});

			var staffReader = new Ext.data.JsonReader({
				root : "staff",
				id : "staffId"
			}, [ "staffId", "staffName" ]);
			var staffStore = new Ext.data.Store(
					{
						proxy : new Ext.data.HttpProxy(
								{
									url : "../controller/leafController.php?method=read&field=staffId&leafId_temp="
											+ leafId_temp,
									method : "GET",
									listeners : {
										exception : function(DataProxy, type,
												action, options, response, arg) {
											var serverMessage = Ext.util.JSON
													.decode(response.responseText);
											if (serverMessage.success == false) {
												Ext.MessageBox.alert(
														systemErrorLabel,
														serverMessage.message);
											}
										}
									}
								}),
						reader : staffReader,
						remoteSort : false
					});
			staffStore.load();
			var accordionReader = new Ext.data.JsonReader({
				root : 'accordion',
				id : 'accordionId'
			}, [ 'accordionId', 'accordionNote' ]);

			var accordionStore = new Ext.data.Store(
					{
						proxy : new Ext.data.HttpProxy(
								{
									url : '../controller/leafController.php?method=read&field=accordionId&type=1&leafId_temp='
											+ leafId_temp,
									method : 'GET',
									listeners : {
										exception : function(DataProxy, type,
												action, options, response, arg) {
											var serverMessage = Ext.util.JSON
													.decode(response.responseText);
											if (serverMessage.success == false) {
												Ext.MessageBox.alert(
														systemErrorLabel,
														serverMessage.message);
											}
										}
									}
								}),
						reader : accordionReader,
						remoteSort : false
					});

			var folderReader = new Ext.data.JsonReader({
				root : 'folder',
				id : 'folderId'
			}, [ 'folderId', 'folderNote' ]);
			var folderStore = new Ext.data.Store(
					{
						proxy : new Ext.data.HttpProxy(
								{
									url : '../controller/leafController.php?method=read&field=folderId&type=1&leafId_temp='
											+ leafId_temp,
									method : 'GET',
									listeners : {
										exception : function(DataProxy, type,
												action, options, response, arg) {
											var serverMessage = Ext.util.JSON
													.decode(response.responseText);
											if (serverMessage.success == false) {
												Ext.MessageBox.alert(
														systemErrorLabel,
														serverMessage.message);
											}
										}
									}
								}),
						reader : folderReader,
						remoteSort : false

					});

			leafStore.load();
			accordionStore.load();
			folderStore.load();

			var filters = new Ext.ux.grid.GridFilters({

				encode : encode,
				local : local,
				filters : [ {
					type : 'list',
					dataIndex : 'accordionTranslate',
					column : 'accordionId',
					table : 'accordion',
					labelField : 'accordionTranslate',
					store : accordionStore,
					phpMode : true
				}, {
					type : 'list',
					dataIndex : 'folderTranslate',
					column : 'folderId',
					table : 'folder',
					labelField : 'folderTranslate',
					store : folderStore,
					phpMode : true

				}, {
					type : 'string',
					dataIndex : 'leafNote',
					column : 'leafNote',
					column : 'leafNote',
					table : 'leaf'
				}, {
					type : 'numeric',
					dataIndex : 'leafSequence',
					column : 'leafSequence',
					table : 'leaf'
				}, {
					type : 'string',
					dataIndex : 'leafFilename',
					column : 'leafFilename',
					table : 'leaf'
				}, {
					type : 'string',
					dataIndex : 'iconId',
					column : 'iconId',
					table : 'leaf'
				}, {
					type : "list",
					dataIndex : "By",
					column : "By",
					table : "religion",
					labelField : "staffName",
					store : staffStore,
					phpMode : true
				}, {
					type : "date",
					dataIndex : "Time",
					column : "Time",
					table : "religion"
				} ]
			});

			this.action = new Ext.ux.grid.RowActions(
					{
						header : actionLabel,
						dataIndex : 'leafId',
						actions : [
								{
									iconCls : 'application_edit',
									callback : function(grid, record, action,
											row, col) {

										formPanel.getForm().reset();
										formPanel.form
												.load({
													url : '../controller/leafController.php',
													method : 'POST',
													waitMsg : waitMessageLabel,
													params : {
														method : 'read',
														page : 'master',
														leafId : record.data.leafId,
														leafId_temp : leafId_temp
													},
													success : function(form,
															action) {
														leafTranslateStore
																.load({
																	params : {
																		leafId_temp : leafId_temp,
																		leafId : record.data.leafId
																	}
																})
														Ext
																.getCmp(
																		'leaf_id')
																.setValue(
																		record.data.leafId);

														Ext.getCmp('folder_fake').enable(); // enable
														// cascading
														Ext.getCmp(
																'translation')
																.enable(); // information
														folderStore.proxy = new Ext.data.HttpProxy(
																{
																	url : '../controller/leafController.php?method=read&field=folderId&type=1&accordionId='
																			+ action.result.data.accordionId
																			+ '&leafId_temp='
																			+ leafId_temp,
																	method : 'GET',
																	listeners : {
																		exception : function(
																				DataProxy,
																				type,
																				action,
																				options,
																				response,
																				arg) {
																			var serverMessage = Ext.util.JSON
																					.decode(response.responseText);
																			if (serverMessage.success == false) {
																				Ext.MessageBox
																						.alert(
																								systemErrorLabel,
																								serverMessage.message);
																			}
																		}
																	}
																});
														folderStore.load();
														viewPort.items.get(1)
																.expand();
													},
													failure : function(action) {
														Ext.MessageBox
																.alert(
																		systemErrorLabel,
																		action.result.message);
													}
												});

									}
								},
								{
									iconCls : 'trash',
									dataIndex : 'leafId',
									callback : function(grid, record, action,
											row, col) {
										Ext.Msg
												.show({
													title : deleteRecordTitleMessageLabel,
													msg : deleteRecordMessageLabel,
													icon : Ext.Msg.QUESTION,
													buttons : Ext.Msg.YESNO,
													scope : this,
													fn : function(response) {
														if ('yes' == response) {

															Ext.Ajax
																	.request({
																		url : '../controller/leafController.php',
																		params : {
																			method : 'delete',
																			leafId : record.data.leafId,
																			leafId_temp : leafId_temp
																		},
																		success : function(
																				response,
																				options) {
																			x = Ext
																					.decode(response.responseText);
																			if (x.success == 'false') {
																				Ext.MessageBox
																						.alert(
																								systemLabel,
																								x.message);
																			} else {
																				Ext.MessageBox
																						.alert(
																								systemLabel,
																								x.message);
																				leafStore
																						.reload({
																							params : {
																								start : 0,
																								leafId : leafId,
																								limit : per_page
																							}
																						});
																			}

																		},
																		failure : function(
																				response,
																				options) {
																			status_code = response.status;
																			status_message = response.statusText;
																			Ext.MessageBox
																					.alert(
																							systemErrorLabel,
																							escape(status_code)
																									+ ":"
																									+ status_message);
																		}
																	});
														}
													}
												});
									}
								} ]
					});

			var columnModelMaster = [
					new Ext.grid.RowNumberer(),
					this.action,

					{
						dataIndex : 'leafSequence',
						header : leafSequenceLabel,
						type : 'string',
						sortable : false,
						hidden : false
					},
					{
						dataIndex : 'leafNote',
						header : leafNoteLabel,
						type : 'string',
						sortable : false,
						hidden : false
					},
					{
						dataIndex : 'leafFilename',
						header : leafFilenameLabel,
						type : 'string',
						sortable : false,
						hidden : false
					},
					{
						dataIndex : 'iconName',
						header : iconNameLabel,
						type : 'string',
						sortable : false,
						hidden : false,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return '<img src=\'../../javascript/resources/images/icon/'
									+ value
									+ '.png\' width=\'12\' height=\'12\'> '
									+ value;
						}
					}, {
						dataIndex : "byLabel",
						header : createByLabel,
						sortable : true,
						hidden : true
					}, {
						dataIndex : "timeLabel",
						header : timeLabel,
						sortable : true,
						hidden : true,
						renderer : function(value) {
							return Ext.util.Format.date(value, 'Y-m-d H:i:s');
						}
					} ];
			var columnModelDetail = [ new Ext.grid.RowNumberer(), {
				dataIndex : "leafNote",
				header : "leafNote",
				sortable : true,
				hidden : true,
				width : 50
			}, {
				dataIndex : "languageCode",
				header : "languageCode",
				sortable : true,
				hidden : false,
				width : 100
			}, {
				dataIndex : "languageDesc",
				header : "languageDesc",
				sortable : true,
				hidden : false,
				width : 100

			}, {
				dataIndex : "leafTranslate",
				header : "leafTranslate",
				sortable : true,
				hidden : false,
				width : 100,

				editor : {
					xtype : 'textfield',
					id : 'leafTranslate'
				}

			} ];
			var gridMaster = new Ext.grid.GridPanel({
				border : false,
				store : leafStore,
				autoHeight : false,
				columns : columnModelMaster,
				loadMask : true,
				plugins : [ this.action ],
				sm : new Ext.grid.RowSelectionModel({
					singleSelect : true
				}),
				viewConfig : {
					forceFit : true,
					emptyText : emptyRowLabel
				},
				iconCls : 'application_view_detail',
				listeners : {
					render : {
						fn : function() {
							leafStore.load({
								params : {
									start : 0,
									limit : per_page,
									method : 'read',
									page : 'master',
									plugin : [ filters ]
								}
							});
						}
					}
				},
				bbar : new Ext.PagingToolbar({
					store : leafStore,
					pageSize : per_page
				})
			});

			var editor = new Ext.ux.grid.RowEditor(
					{
						saveText : 'Save',
						listeners : {
							CancelEdit : function(rowEditor, changes, record,
									rowIndex) {
								leafTranslateStore.reload();

							},
							afteredit : function(rowEditor, changes, record,
									rowIndex) {

								this.save = true;
								// update record manually
								var curr_store = this.grid.getStore();
								var record = curr_store.getAt(rowIndex);

								Ext.Ajax.request({
									url : '../controller/leafController.php',
									method : 'POST',
									waitMsg : 'Harap Bersabar',
									params : {
										leafId : leafId,
										method : 'save',
										page : 'detail',
										leafTranslateId : record
												.get('leafTranslateId'),
										leafTranslate : Ext.getCmp(
												'leafTranslate').getValue()

									},
									success : function(response, options) {
										x = Ext.decode(response.responseText);
										if (x.success == 'false') {
											Ext.MessageBox.alert('system',
													x.message);
										} else {
											// if required messagebox to check
											// status uncomment below
											Ext.MessageBox.alert('system',
													x.message);
											leafTranslateStore.reload();
										}

									},
									failure : function(response, options) {
										statusCode = response.status;
										statusMessage = response.statusText;
										Ext.MessageBox.alert('system',
												escape(statusCode) + ":"
														+ statusMessage);
									}
								});

							}
						}
					});

			function deleteRow(btn) {
				if (btn == 'yes') {
					var selections = approved.selModel.getSelections();
					var prez = [];
					for (i = 0; i < approved.selModel.getCount(); i++) {
						prez.push(selections[i].json.accordionTranslateId);
					}
					var encoded_array = Ext.encode(prez);

					Ext.Ajax.request({
						url : '../controller/leafController.php',
						method : 'POST',
						params : {
							method : "DELETE",
							ids : encoded_array,
							leafId : leafId
						},
						success : function(response, options) {
							var x = Ext.decode(response.responseText);
							if (x.success == 'true') {
								Ext.MessageBox.alert('Message', x.message);
							} else {
								Ext.MessageBox.alert('Message', x.message);
							}

						},
						failure : function(response, options) {
							statusCode = response.status;
							statusMessage = response.statusText;
							Ext.MessageBox.alert('system', escape(statusCode)
									+ ":" + statusMessage);
						}
					});

					leafTranslate.reload();
				}
			}

			var gridDetail = new Ext.grid.GridPanel({
				name : 'gridDetail',
				id : 'gridDetail',
				border : false,
				store : leafTranslateStore,
				height : 400,
				autoScroll : true,
				columns : columnModelDetail,
				disable : true,
				viewConfig : {
					autoFill : true,
					forceFit : true
				},

				layout : 'fit',
				plugins : [ editor ]
			});

			var gridPanel = new Ext.Panel(
					{
						title : 'Menu Listing',
						height : 50,
						layout : 'fit',
						iconCls : 'application_view_detail',
						tbar : [
								' ',
								{
									text : reloadToolbarLabel,
									iconCls : 'database_refresh',
									id : 'page_reload',
									disabled : page_reload,
									handler : function() {
										leafStore.reload();
									}
								},
								'-',
								{
									text : addToolbarLabel,
									iconCls : 'add',
									id : 'page_create',
									disabled : page_create,
									handler : function() {

										viewPort.items.get(1).expand();
									}
								},
								'-',
								{
									text : excelToolbarLabel,
									iconCls : 'page_excel',
									id : 'page_excel',
									disabled : page_print,
									handler : function() {
										Ext.Ajax
												.request({
													url : '../controller/leafController.php?method=report&mode=excel&limit='
															+ per_page
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == 'true') {

															window
																	.open("../security/document/excel/leaf.xlsx");
														} else {
															Ext.MessageBox
																	.alert(
																			systemErrorLabel,
																			x.message);
														}

													},
													failure : function(
															response, options) {
														status_code = response.status;
														status_message = response.statusText;
														Ext.MessageBox
																.alert(
																		systemErrorLabel,
																		escape(status_code)
																				+ ":"
																				+ status_message);
													}

												});
									}
								}, '->', new Ext.ux.form.SearchField({
									store : leafStore,
									width : 320
								}) ],
						items : [ gridMaster ]
					});
			// viewport just save information,items will do separate

			var accordionId = new Ext.ux.form.ComboBoxMatch(
					{
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
							value = Ext.escapeRe(value.split('').join('\\s*'))
									.replace(/\\\\s\\\*/g, '\\s*');
							return new RegExp('\\b(' + value + ')', 'i');
						},
						listeners : {
							'select' : function() {

								folderStore.proxy = new Ext.data.HttpProxy(
										{
											url : '../controller/leafController.php?method=read&field=folderId&type=1&accordionId='
													+ this.value
													+ '&leafId_temp='
													+ leafId_temp,
											success : function(response,
													options) {
												x = Ext
														.decode(response.responseText);
												if (x.totalCount == 0) {

													folderId.disable();
												} else {

													folderId.enable();
												}
												if (x.success == "true") {
													/*
													 * Ext.MessageBox .alert(
													 * systemLabel, x.message);
													 * 
													 * leafTranslateStore
													 * .reload();
													 */

												} else {
													/*
													 * Ext.MessageBox .alert(
													 * systemLabel, x.message);
													 */
												}
											},
											listeners : {

												exception : function(DataProxy,
														type, action, options,
														response, arg) {
													var serverMessage = Ext.util.JSON
															.decode(response.responseText);

													if (serverMessage.success == false) {
														Ext.MessageBox
																.alert(
																		systemErrorLabel,
																		'Error ka'
																				+ serverMessage.message);
													}
												}
											}
										});

								folderStore.load();
							}
						}
					});

			var folderId = new Ext.ux.form.ComboBoxMatch({
				labelAlign : 'left',
				fieldLabel : folderIdLabel,
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
				disabled : true,
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
						Ext.Ajax.request({
							url : '../controller/leafController.php',
							method : 'GET',
							params : {
								method : 'read',
								field : 'sequence',
								table : 'leaf',
								accordionId : Ext.getCmp('accordion_fake')
										.getValue(),
								folderId : combo.value,
								leafId : leafId_temp
							},
							success : function(response, options) {
								x = Ext.decode(response.responseText);
								if (x.success == 'false') {
									Ext.MessageBox.alert('system', x.message);
								} else {

									Ext.getCmp('leafSequence').setValue(
											x.nextSequence);

								}

							},
							failure : function(response, options) {
								statusCode = response.status;
								statusMessage = response.statusText;
								Ext.MessageBox.alert('system',
										escape(statusCode) + ":"
												+ statusMessage);
							}

						});
					}
				}
			});

			var leafNote = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : leafNoteLabel,
				hiddenName : 'leafNote',
				name : 'leafNote',
				anchor : '95%'
			});

			var leafSequence = new Ext.form.NumberField({
				labelAlign : 'left',
				fieldLabel : leafSequenceLabel,
				hiddenName : 'leafSequence',
				name : 'leafSequence',
				id : 'leafSequence',
				anchor : '95%'
			});

			var leafFilename = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : leafFilenameLabel,
				hiddenName : 'leafFilename',
				name : 'leafFilename',
				anchor : '95%'
			});

			var iconData = [ [ '29', 'accept' ], [ '31', 'acroread' ],
					[ '32', 'add' ], [ '34', 'aktion' ], [ '35', 'anchor' ],
					[ '36', 'application' ], [ '40', 'application_double' ],
					[ '41', 'application_edit' ],
					[ '42', 'application_error' ],
					[ '43', 'application_form' ], [ '48', 'application_get' ],
					[ '49', 'application_go' ], [ '50', 'application_home' ],
					[ '51', 'application_key' ],
					[ '52', 'application_lightning' ],
					[ '53', 'application_link' ], [ '54', 'application_osx' ],
					[ '55', 'application_osx_terminal' ],
					[ '56', 'application_put' ], [ '71', 'application_xp' ],
					[ '72', 'application_xp_terminal' ], [ '73', 'ark' ],
					[ '94', 'arts' ], [ '95', 'ascend' ],
					[ '96', 'asterisk_orange' ], [ '97', 'asterisk_yellow' ],
					[ '98', 'attach' ], [ '100', 'award_star_add' ],
					[ '101', 'award_star_bronze_1' ],
					[ '102', 'award_star_bronze_2' ],
					[ '103', 'award_star_bronze_3' ],
					[ '104', 'award_star_delete' ],
					[ '105', 'award_star_gold_1' ],
					[ '106', 'award_star_gold_2' ],
					[ '107', 'award_star_gold_3' ],
					[ '108', 'award_star_silver_1' ],
					[ '109', 'award_star_silver_2' ],
					[ '110', 'award_star_silver_3' ], [ '111', 'basket' ],
					[ '119', 'bell' ], [ '125', 'bin' ], [ '130', 'bomb' ],
					[ '144', 'box' ], [ '358', 'cursor' ], [ '359', 'cut' ],
					[ '361', 'database' ], [ '385', 'delete' ],
					[ '386', 'descend' ], [ '387', 'disconnect' ],
					[ '389', 'disk_multiple' ], [ '391', 'document' ],
					[ '392', 'door' ], [ '395', 'door_out' ],
					[ '396', 'drink' ], [ '398', 'drive' ], [ '415', 'dvd' ],
					[ '423', 'email' ], [ '442', 'error' ],
					[ '445', 'error_go' ], [ '447', 'exclamation' ],
					[ '449', 'exec' ], [ '450', 'eye' ],
					[ '153', 'briefcase' ], [ '154', 'browser' ],
					[ '155', 'bug' ], [ '162', 'building' ], [ '197', 'cake' ],
					[ '198', 'calculator' ], [ '212', 'camera' ],
					[ '220', 'cancel' ], [ '221', 'car' ], [ '222', 'cart' ],
					[ '235', 'cd' ], [ '242', 'chart_bar' ],
					[ '270', 'clock' ], [ '281', 'cog' ], [ '287', 'coins' ],
					[ '290', 'colors' ], [ '291', 'color_swatch' ],
					[ '292', 'color_wheel' ], [ '300', 'compress' ],
					[ '301', 'computer' ], [ '309', 'connect' ],

					[ '339', 'cookie' ], [ '341', 'creditcards' ],
					[ '342', 'cross' ], [ '461', 'female' ], [ '481', 'find' ],
					[ '526', 'gimp' ], [ '491', 'folder' ], [ '527', 'group' ],
					[ '536', 'heart' ], [ '539', 'help' ],
					[ '541', 'hourglass' ], [ '546', 'house' ],
					[ '549', 'html' ], [ '556', 'image' ],
					[ '560', 'image_edit' ], [ '561', 'image_link' ],
					[ '565', 'information' ], [ '566', 'ipod' ],
					[ '571', 'java' ], [ '572', 'java_jar' ],
					[ '573', 'joystick' ], [ '578', 'key' ],
					[ '579', 'keyboard' ], [ '586', 'kservices' ],
					[ '587', 'layers' ], [ '597', 'lightbulb' ],
					[ '601', 'lightning' ], [ '605', 'link' ],
					[ '612', 'lock' ], [ '619', 'lorry' ],
					[ '626', 'magifier_zoom_out' ], [ '627', 'magnifier' ],
					[ '628', 'magnifier_zoom_in' ], [ '629', 'male' ],
					[ '630', 'map' ], [ '651', 'mime' ], [ '652', 'money' ],
					[ '655', 'money_dollar' ], [ '656', 'money_euro' ],
					[ '657', 'money_pound' ], [ '658', 'money_yen' ],
					[ '659', 'monitor' ], [ '667', 'mouse' ], [ '674', 'new' ],
					[ '675', 'newspaper' ], [ '680', 'note' ],
					[ '685', 'note_go' ], [ '686', 'ooo_gulls' ],
					[ '687', 'openoffice' ], [ '688', 'overlays' ],

					[ '783', 'paintbrush' ], [ '784', 'paintcan' ],
					[ '785', 'palette' ], [ '789', 'pencil' ],
					[ '793', 'phone' ], [ '797', 'photo' ],
					[ '798', 'photos' ], [ '802', 'php-icon' ],
					[ '803', 'picture' ], [ '814', 'pilcrow' ],
					[ '815', 'pill' ], [ '830', 'printer' ],
					[ '837', 'quicktime' ], [ '838', 'rainbow' ],
					[ '839', 'realplayer' ], [ '841', 'report' ],
					[ '842', 'report_add' ], [ '843', 'report_delete' ],
					[ '844', 'report_disk' ], [ '845', 'report_edit' ],
					[ '846', 'report_go' ], [ '847', 'report_key' ],
					[ '848', 'report_link' ], [ '849', 'report_magnify' ],
					[ '850', 'report_picture' ], [ '851', 'report_user' ],
					[ '852', 'report_word' ], [ '857', 'rosette' ],
					[ '858', 'rpm' ], [ '902', 'shading' ],
					[ '928', 'shield' ], [ '932', 'sitemap' ],
					[ '933', 'sitemap_color' ], [ '934', 'sound' ],
					[ '949', 'star' ], [ '954', 'stop' ], [ '963', 'tab' ],
					[ '985', 'tag' ], [ '986', 'tag_blue' ],
					[ '987', 'tag_blue_add' ], [ '988', 'tag_blue_delete' ],
					[ '989', 'tag_blue_edit' ], [ '990', 'tag_green' ],
					[ '991', 'tag_orange' ], [ '992', 'tag_pink' ],
					[ '993', 'tag_purple' ], [ '994', 'tag_red' ],
					[ '995', 'tag_yellow' ], [ '996', 'tar' ],
					[ '997', 'telephone' ], [ '1008', 'terminal' ],
					[ '1052', 'tgz' ], [ '1054', 'thumb_down' ],
					[ '1055', 'thumb_up' ], [ '1056', 'tick' ],
					[ '1058', 'time' ], [ '1062', 'time_go' ],
					[ '1063', 'transmit' ], [ '1070', 'tux' ],
					[ '1072', 'user' ], [ '1084', 'vcard' ],
					[ '1088', 'vector' ], [ '1091', 'video' ],
					[ '1093', 'wand' ], [ '1123', 'zoom' ],
					[ '1124', 'zoom_in' ], [ '1125', 'zoom_out' ] ];
			var iconId = new Ext.ux.form.IconCombo({
				name : 'iconId',
				hiddenName : 'iconId',
				mode : 'local',
				id : 'iconId',
				hiddenId : 'FakeiconId',
				store : new Ext.data.ArrayStore({
					fields : [ 'iconId', 'iconName' ],
					data : iconData
				}),
				emptyText : emptyTextLabel,
				fieldLabel : iconIdLabel,
				anchor : '95%',
				triggerAction : 'all',
				valueField : 'iconId',
				displayField : 'iconName',
				iconClsTpl : '{iconName}'
			});

			// hidden id for updated
			var leafId = new Ext.form.Hidden({
				name : 'leafId',
				id : 'leafId'
			});

			var formPanel = new Ext.form.FormPanel(
					{
						url : '../controller/leafController.php',
						method : 'post',
						frame : true,
						title : 'Menu Administration',
						border : false,
						bodyStyle : 'padding: 10px',
						width : 600,
						iconCls : 'application_form',
						items : [
								{
									xtype : 'panel',
									title : leafName,
									bodyStyle : "padding:5px",
									layout : 'form',
									frame : true,
									items : [ accordionId, folderId, leafNote,
											leafSequence, leafFilename, iconId,
											leafId ]
								}, {
									xtype : 'panel',
									title : 'Leaf Translation',
									items : [ gridDetail ]
								} ],
						buttonVAlign : 'top',
						buttonAlign : 'left',
						buttons : [
								{
									text : saveButtonLabel,
									iconCls : 'bullet_disk',
									handler : function() {
										var id = 0;
										id = Ext.getCmp('leafId').getValue();
										var method;
										if (id.length > 0) {
											method = 'save';
										} else {
											method = 'create';
										}
										formPanel
												.getForm()
												.submit(
														{
															waitMsg : waitMessageLabel,
															params : {
																method : method,
																page : 'master',
																leafId_temp : leafId_temp
															},
															success : function(
																	form,
																	action) {
																Ext.MessageBox
																		.alert(
																				systemLabel,
																				action.result.message);

															
																leafStore
																		.reload({
																			params : {
																				leafId : leafId_temp,
																				start : 0,
																				limit : per_page
																			}
																		});
																Ext
																		.getCmp(
																				'translation')
																		.enable();
																Ext
																		.getCmp(
																				'leafId')
																		.setValue(
																				action.result.leafId);
															},
															failure : function(
																	form,
																	action) {

																if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																	alert(loadFailureMessageLabel);
																} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {

																	alert(clientInvalidMessageLabel);
																} else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
																	Ext.Msg
																			.alert(connectFailureLabel
																					+ form.response.status
																					+ ' '
																					+ form.response.statusText);
																} else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
																	Ext.Msg
																			.alert(
																					systemErrorLabel,
																					action.result.message);
																}
															}

														});
									}
								},
								{
									text : resetButtonLabel,
									type : 'reset',
									iconCls : 'table_refresh',
									handler : function() {
										formPanel.getForm().reset();
									}
								},
								{
									text : 'Translation',
									id : 'translation',
									disabled : true,
									handler : function() {
										var box = Ext.MessageBox.wait(
												'Be patient',
												'Translation In Progress');
										Ext.Ajax
												.request({

													url : "../controller/leafController.php",
													method : 'GET',
													params : {
														leafId_temp : leafId_temp,
														method : 'translate',
														leafId : Ext
																.getCmp(
																		'leafId')
																.getValue()
													},
													success : function(
															response, options) {
														x = Ext
																.decode(response.responseText);
														if (x.success == "true") {
															Ext.MessageBox
																	.alert(
																			systemLabel,
																			x.message);

															leafTranslateStore
																	.reload();
															box.hide();
														} else {
															Ext.MessageBox
																	.alert(
																			systemLabel,
																			x.message);
														}
													},
													failure : function(
															response, options) {
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

									}
								} ]
					});

			var viewPort = new Ext.Viewport({
				id : 'viewport',
				region : 'center',
				layout : 'accordion',
				layoutConfig : {
					// layout-specific configs go here
					titleCollapse : true,
					animate : false,
					activeOnTop : true
				},
				items : [ gridPanel, formPanel ]
			});

		});
