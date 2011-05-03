Ext
		.onReady(function() {
			Ext.Ajax.timeout = 90000000;	
			Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';

			var page_create;
			var page_reload;
			var page_print;
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
			var per_page = 10;
			var encode = false;
			var local = false;
			var folderStore = new Ext.data.JsonStore({
				autoDestroy : true,
				url : '../controller/folderController.php',
				remoteSort : true,
				storeId : 'myStore',
				root : 'data',
				totalProperty : 'total',
				baseParams : {
					method : 'read',
					page : 'master',
					leafId : leafId
				},
				fields : [ {
					name : 'folderId',
					type : 'int'
				}, {
					name : 'folderSequence',
					type : 'int'
				}, {
					name : 'accordionId',
					type : 'int'
				}, {
					name : 'accordionNote',
					type : 'string'
				}, {
					name : 'folderNote',
					type : 'string'
				}, {
					name : 'folderPath',
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

			var folderTranslateStore = new Ext.data.JsonStore({
				autoDestroy : true,
				url : '../controller/folderController.php',
				remoteSort : true,
				storeId : 'folderTranslateStore',
				root : 'data',
				totalProperty : 'total',
				baseParams : {
					method : 'read',
					page : 'detail',
					leafId : leafId
				},
				fields : [ {
					name : 'folderTranslateId',
					type : 'int'
				}, {
					name : 'folderId',
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
					name : 'folderTranslate',
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
									url : "../controller/folderController.php?method=read&field=staffId&leafId="
											+ leafId,
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
									url : '../controller/folderController.php?method=read&field=accordionId&type=1&leafId='
											+ leafId,
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
			accordionStore.load();

			var filters = new Ext.ux.grid.GridFilters({
				// encode and local configuration options defined previously for
				// easier reuse
				encode : encode, // json encode the filter query
				local : false, // defaults to false (remote filtering)
				filters : [ {
					type : 'list',
					dataIndex : 'accordionNote',
					column : 'accordionId',
					table : 'accordion',
					labelField : 'accordionNote',
					store : accordionStore,
					phpMode : true
				}, {
					type : 'numeric',
					dataIndex : 'folderSequence',
					column : 'folderSequence',
					table : 'folder'
				}, {
					type : 'string',
					dataIndex : 'folderNote',
					column : 'folderNote',
					table : 'folder'
				}, {
					type : 'string',
					dataIndex : 'folderPath',
					column : 'folderPath',
					table : 'folder'
				}, {
					type : 'string',
					dataIndex : 'iconId',
					column : 'iconId',
					table : 'folder'
				}, {
					type : 'list',
					dataIndex : 'By',
					column : 'staffId',
					table : 'folder',
					labelField : 'staffName',
					store : staffStore,
					phpMode : true
				}, {
					type : 'date',
					dateFormat : 'Y-m-d H:i:s',
					dataIndex : 'Time',
					column : 'Time',
					table : 'folder'
				} ]
			});
			this.action = new Ext.ux.grid.RowActions(
					{
						header : actionLabel,
						dataIndex : 'folderId',
						actions : [
								{
									iconCls : 'application_edit',
									callback : function(grid, record, action,
											row, col) {
										formPanel.getForm().reset();
										formPanel.form
												.load({
													url : '../controller/folderController.php',
													method : 'POST',
													waitMsg : waitMessageLabel,
													params : {
														method : 'read',
														page :'master',
														folderId : record.data.folderId,
														leafId : leafId
													},
													success : function(form,
															action) {
														folderTranslateStore.load({
															params : {
																leafId:leafId,
																folderId : record.data.folderId
															}
														})
														viewPort.items.get(1)
																.expand();
														Ext.getCmp('translation').enable();
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
																		url : '../controller/folderController.php',
																		params : {
																			method : 'delete',
																			folderId : record.data.folderId,
																			leafId : leafId
																		},
																		success : function(
																				response,
																				options) {
																			var x = Ext
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

																			}
																			folderStore
																					.reload();
																			Ext
																			.getCmp(
																					'folderId')
																			.setValue(
																					action.result.folderId);
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
						dataIndex : 'folderSequence',
						header : folderSequenceLabel
					},
					{
						dataIndex : 'accordionNote',
						header : accordionTranslateLabel
					},
					{
						dataIndex : 'folderNote',
						header : folderTranslateLabel
					},
					{
						dataIndex : 'folderPath',
						header : folderPathLabel
					},
					{
						dataIndex : 'iconName',
						header : iconNameLabel,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return '<img src=\'../../js/resources/images/icon/'
									+ value
									+ '.png\' width=\'12\' height=\'12\'> '
									+ value;
						}
					}, {
						dataIndex : 'By',
						header : byLabel,
						hidden : true
					}, {
						dataIndex : 'Time',
						header : timeLabel,
						type : 'date',
						hidden : true,
						renderer : function(value) {
							return Ext.util.Format.date(value, 'Y-m-d H:i:s');
						}
					} ];

			var columnModelDetail = [ new Ext.grid.RowNumberer(), {
				dataIndex : "folderNote",
				header : accordionSequenceLabel,
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
				dataIndex : "folderTranslate",
				header : "folderTranslate",
				sortable : true,
				hidden : false,
				width : 100,

				editor : {
					xtype : 'textfield',
					id : 'folderTranslate'
				}

			} ];
			var gridMaster = new Ext.grid.GridPanel({
				border : false,
				store : folderStore,
				autoHeight : false,
				columns : columnModelMaster,
				loadMask : true,
				plugins : [ this.action, filters ],
				sm : new Ext.grid.RowSelectionModel({
					singleSelect : true
				}),
				viewConfig : {
					forceFit : true
				},
				iconCls : 'application_view_detail',
				listeners : {
					render : {
						fn : function() {
							folderStore.load({
								params : {
									start : 0,
									limit : per_page,
									method : 'read',
									mode : 'view'
								}
							});
						}
					}
				},
				bbar : new Ext.PagingToolbar({
					store : folderStore,
					pageSize : per_page,
					plugins : [ filters ]
				})
			});

			var editor = new Ext.ux.grid.RowEditor(
					{
						saveText : 'Save',
						listeners : {
							CancelEdit : function(rowEditor, changes, record,
									rowIndex) {
								folderStore.reload();

							},
							afteredit : function(rowEditor, changes, record,
									rowIndex) {

								this.save = true;
								// update record manually
								var curr_store = this.grid.getStore();
								var record = curr_store.getAt(rowIndex);

								Ext.Ajax.request({
									url : '../controller/folderController.php',
									method : 'POST',
									waitMsg : 'Harap Bersabar',
									params : {
										leafId : leafId,
										method : 'save',
										page : 'detail',
										folderTranslateId : record
												.get('folderTranslateId'),
										folderTranslate : Ext.getCmp(
												'folderTranslate').getValue()

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
											folderTranslateStore.reload();
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
						prez.push(selections[i].json.folderTranslateId);
					}
					var encoded_array = Ext.encode(prez);

					Ext.Ajax.request({
						url : 'folderData.php',
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

					folderTranslate.reload();
				}
			}

			var gridDetail = new Ext.grid.GridPanel({
				border : false,
				store : folderTranslateStore,
				height : 400,
				autoScroll : true,
				columns : columnModelDetail,
				viewConfig : {
					autoFill : true,
					forceFit : true
				},

				layout : 'fit',
				plugins : [ editor ]
			});
		

			var gridPanel = new Ext.Panel({
				title : 'Folder Listing',
				height : 50,
				layout : 'fit',
				iconCls : 'application_view_detail',
				tbar : [' ', {
					text : reloadToolbarLabel,
					iconCls : 'database_refresh',
					id : 'page_reload',
					disabled : page_reload,
					handler : function() {
						folderStore.reload();
					}
				},'-',
				{
					text : addToolbarLabel,
					iconCls : 'add',
					id : 'page_create',
					disabled : page_create,
					handler : function() {
						
						viewPort.items.get(1).expand();
					}
				},'-',

				{
					text : excelToolbarLabel,
					iconCls : 'page_excel',
					id : 'page_excel',
					disabled : page_print,
					handler : function() {
						Ext.Ajax
								.request({
									url : '../controller/folderController.php?method=report&mode=excel&limit='
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
													.open("../../security/document/excel/folder.xlsx");
										} else {
											Ext.MessageBox
													.alert(
															successLabel,
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
				}, '->', new Ext.ux.form.SearchField({
					store : folderStore,
					width : 320
				}) ],
				items : [ gridMaster ]
			});

			// viewport just save information,items will do separate
			// only load store when viewport is open

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
				listeners : {
			
					'select': function (combo,record,index) { 
						Ext.Ajax
						.request({
							url : '../data/accordionData.php',
							method : 'GET',
							params : {
								method:'read',
								field : 'sequence',
								table : 'folder',
								accordionId : combo.value,
								leafId : leafId
							},
							success : function(response, options) {
								x = Ext.decode(response.responseText);
								if (x.success == 'false') {
									Ext.MessageBox.alert('system',
											x.message);
								} else {
									
									Ext.getCmp('folderSequence').setValue(x.nextSequence);
									
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

			var folderNote = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : folderNoteLabel,
				hiddenName : 'folderNote',
				name : 'folderNote',
				anchor : '95%'
			});

			var folderSequence = new Ext.form.NumberField({
				labelAlign : 'left',
				fieldLabel : folderSequenceLabel,
				hiddenName : 'folderSequence',
				name : 'folderSequence',
				id : 'folderSequence',
				anchor : '95%'
			});

			var folderPath = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : folderPathLabel,
				hiddenName : 'folderPath',
				name : 'folderPath',
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
			var folderId = new Ext.form.Hidden({
				name : 'folderId',
				id :'folderId'
			});

			var formPanel = new Ext.form.FormPanel(
					{
						url : '../controller/folderController.php',
						method : 'post',
						frame : true,
						title : 'Menu Administration',
						border : false,

						width : 600,
						items : [ {
									xtype:'panel',
									title:leafName,
									bodyStyle : "padding:5px",
									layout:'form',
									items : [folderId, accordionId, folderNote,
									
								folderSequence, folderPath, iconId,
								folderId ]
						},{
							xtype:'panel',
							title:'Folder Translation',
							items:[gridDetail]
						}],
						buttonVAlign : 'top',
						buttonAlign : 'left',
						iconCls : 'application_form',
						buttons : [
								{
									text : saveButtonLabel,
									iconCls : 'bullet_disk',
									handler : function() {
										var id = 0;
										id = Ext.getCmp('folderId').getValue();
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
																page   : 'master',
																leafId : leafId
															},
															success : function(form,action) {
																Ext.MessageBox
																		.alert(
																				systemLabel,
																				action.result.message);

																folderStore
																		.reload({
																			params : {
																				leafId : leafId,
																				start : 0,
																				limit : per_page
																			}
																		});
																Ext.getCmp('translation').enable();
																Ext
																		.getCmp(
																				'folderId')
																		.setValue(
																				action.result.folderId);	
															},
															failure : function(form,action) {

																if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																	alert(loadFailureMessageLabel);
																} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
																	// here will
																	// be error
																	// if
																	// duplicate
																	// code
																	alert(clientInvalidMessageLabel);
																} else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
																	Ext.Msg
																			.alert(
																					connectFailureLabel,
																					'Server reported:'
																							+ form.response.status
																							+ ' '
																							+ form.response.statusText);
																} else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
																	Ext.Msg
																			.alert(
																					serverInvalidLabel,
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

													url : "../controller/folderController.php",
													method : 'GET',
													params : {
														leafId : leafId,
														method : 'translate',
														folderId : Ext
																.getCmp(
																		'folderId')
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

															folderTranslateStore
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
