Ext
		.onReady(function() {
			Ext.QuickTips.init();
			Ext.BLANK_IMAGE_URL = "../../javascript/resources/images/s.gif";
			Ext.form.Field.prototype.msgTarget = "under";
			Ext.Ajax.timeout = 90000;
			var pageCreate;
			var pageCreateList;
			var pageReload;
			var pageReloadList;
			var pagePrint;
			var pagePrintList;
			var perPage = 15;
			var encode = false;
			var local = false;
			var jsonResponse;
			var duplicate = 0;
			if (leafReadAccessValue == 1) {
				pageCreate = false;
				pageCreateList = false;
			} else {
				pageCreate = true;
				pageCreateList = true;
			}
			if (leafReadAccessValue == 1) {
				pageReload = false;
				pageReloadList = false;
			} else {
				pageReload = true;
				pageReloadList = true;
			}
			if (leafPrintAccessValue == 1) {
				pagePrint = false;
				pagePrintList = false;
			} else {
				pagePrint = true;
				pagePrintList = true;
			}
			var moduleProxy = new Ext.data.HttpProxy({
				url : "../controller/moduleController.php",
				method:'POST',
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
				proxy : moduleProxy,
				reader : moduleReader,
				autoLoad : true,
				autoDestroy : true,
				pruneModifiedRecords : true,
				baseParams : {
					method : "read",
					grid : "master",
					leafId : leafId,
					isAdmin : isAdmin,
					start : 0,
					perPage : perPage
				},
				root : "data",
				fields : [ {
					name : 'moduleId',
					type : 'int'
				}, {
					name : 'moduleSequence',
					type : 'int'
				}, {
					name : 'moduleNote',
					type : 'string'
				}, {
					name : 'iconId',
					type : 'int'
				}, {
					name : 'iconName',
					type : 'string'
				}, {
					name : "isDefault",
					type : "boolean"
				}, {
					name : "isNew",
					type : "boolean"
				}, {
					name : "isDraft",
					type : "boolean"
				}, {
					name : "isUpdate",
					type : "boolean"
				}, {
					name : "isDelete",
					type : "boolean"
				}, {
					name : "isActive",
					type : "boolean"
				}, {
					name : "isApproved",
					type : "boolean"
				}, {
					name : "Time",
					type : "date",
					dateFormat : "Y-m-d H:i:s"
				} ]
			});

			var moduleTranslateProxy = new Ext.data.HttpProxy({
				url : "../controller/moduleController.php",
				method : 'POST',
				baseParams : {
					method : "read",
					page : "detail",
					leafId : leafId
				},
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
			var moduleTranslateReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "moduleTranslateId"
			});
			var moduleTranslateStore = new Ext.data.JsonStore({
				proxy : moduleTranslateProxy,
				reader : moduleTranslateReader,
				autoDestroy : true,
				pruneModifiedRecords : true,
				root : "data",
				fields : [ {
					name : 'moduleTranslateId',
					type : 'int'
				}, {
					name : 'moduleId',
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
					name : 'moduleTranslate',
					type : 'string'
				} ]
			});
			 var staffByProxy = new Ext.data.HttpProxy({
			        url: "../controller/moduleController.php?",
			        method: "GET",
			        success: function(response, options) {
			            jsonResponse = Ext.decode(response.responseText);
			            if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,
			                // jsonResponse.message);
			                // //uncommen for testing
			                // purpose
			            } else {
			                Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
			            }
			        },
			        failure: function(response, options) {
			            Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ":" + escape(response.statusText));
			        }
			    });
			var staffByReader = new Ext.data.JsonReader({
		        totalProperty: "total",
		        successProperty: "success",
		        messageProperty: "message",
		        idProperty: "staffId"
		    });
		    var staffByStore = new Ext.data.JsonStore({
		        proxy: staffByProxy,
		        reader: staffByReader,
		        autoLoad: true,
		        autoDestroy: true,
		        baseParams: {
		            method: 'read',
		            field: 'staffId',
		            leafId: leafId
		        },
		        root: 'staff',
		        fields: [{
		            name: "staffId",
		            type: "int"
		        },
		        {
		            name: "staffName",
		            type: "string"
		        }]
		    });
			var filters = new Ext.ux.grid.GridFilters({ // encode and local
				// configuration options
				// defined previously
				// for
				// easier reuse
				encode : encode,
				// json encode the filter query
				local : false,
				// defaults to false (remote filtering)
				filters : [ {
					type : 'numeric',
					dataIndex : 'moduleSequence',
					column : 'moduleSequence',
					modulele : 'module'
				},{
					type : 'numeric',
					dataIndex : 'moduleCode',
					column : 'moduleCode',
					modulele : 'module'
				}, {
					type : 'string',
					dataIndex : 'moduleNote',
					column : 'moduleNote',
					modulele : 'module'
				}, {
					type : 'string',
					dataIndex : 'iconId',
					column : 'iconId',
					modulele : 'module'
				},  {
					type : "list",
					dataIndex : "By",
					column : "By",
					modulele : "module",
					labelField : "staffName",
					store : staffByStore,
					phpMode : true
				},{
					type : 'date',
					dateFormat : 'Y-m-d H:i:s',
					dataIndex : 'createTime',
					column : 'createTime',
					modulele : 'module'
				} ]
			});
			var isDefaultGrid = new Ext.ux.grid.CheckColumn({
				header : 'Default',
				dataIndex : 'isDefault',
				hidden : isDefaultHidden
			});
			var isNewGrid = new Ext.ux.grid.CheckColumn({
				header : 'New',
				dataIndex : 'isNew',
				hidden : isNewHidden
			});
			var isDraftGrid = new Ext.ux.grid.CheckColumn({
				header : 'Draft',
				dataIndex : 'isDraft',
				hidden : isDraftHidden
			});
			var isUpdateGrid = new Ext.ux.grid.CheckColumn({
				header : 'Update',
				dataIndex : 'isUpdate',
				hidden : isUpdateHidden
			});
			var isDeleteGrid = new Ext.ux.grid.CheckColumn({
				header : 'Delete',
				dataIndex : 'isDelete'
			});
			var isActiveGrid = new Ext.ux.grid.CheckColumn({
				header : 'Active',
				dataIndex : 'isActive',
				hidden : isActiveHidden
			});
			var isApprovedGrid = new Ext.ux.grid.CheckColumn({
				header : 'Approved',
				dataIndex : 'isApproved',
				hidden : isApprovedHidden
			});
			var moduleColumnModel = [
					new Ext.grid.RowNumberer(),
				
					{
						dataIndex : "moduleSequence",
						header : moduleSequenceLabel,
						sormodulele : true,
						hidden : false,
						width : 50
					},
					{
						dataIndex : "moduleNote",
						header : moduleNoteLabel,
						sormodulele : true,
						hidden : false,
						width : 100
					},
					{
						dataIndex : 'iconName',
						header : iconNameLabel,
						sormodulele : false,
						hidden : false,
						width : 50,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return '<img src=\'../../javascript/resources/images/icon/'
									+ value
									+ '.png\' width=\'12\' height=\'12\'> '
									+ value;
						}
					}, isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid,
					isDeleteGrid, isActiveGrid, isApprovedGrid, {
						dataIndex : 'By',
						header : createByLabel,
						sormodulele : true,
						hidden : true,
						width : 100
					}, {
						dataIndex : 'Time',
						header : createTimeLabel,
						type : 'date',
						sormodulele : true,
						hidden : true,
						width : 100
					} ];
			var moduleTranslateColumnModel = [ new Ext.grid.RowNumberer(), {
				dataIndex : "moduleNote",
				header : moduleSequenceLabel,
				sormodulele : true,
				hidden : true,
				width : 50
			}, {
				dataIndex : "languageCode",
				header : "languageCode",
				sormodulele : true,
				hidden : false,
				width : 100
			}, {
				dataIndex : "languageDesc",
				header : "languageDesc",
				sormodulele : true,
				hidden : false,
				width : 100
			}, {
				dataIndex : "moduleTranslate",
				header : "moduleTranslate",
				sormodulele : true,
				hidden : false,
				width : 100,
				editor : {
					xtype : 'textfield',
					id : 'moduleTranslate'
				}
			} ];
			
			 var accessArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved'];
			 
			var moduleGrid = new Ext.grid.GridPanel(
					{
						border : false,
						store : moduleStore,
						autoHeight : false,
						columns : moduleColumnModel,
						loadMask : true,
						plugins : [ filters ],
						sm : new Ext.grid.RowSelectionModel({
							singleSelect : true
						}),
						viewConfig : {
							forceFit : true
						},
						iconCls : 'application_view_detail',
						listeners : {
							'rowclick' : function(object, rowIndex, e) {
								var record = moduleStore.getAt(rowIndex);
								formPanel.getForm().reset();
								formPanel.form.load({
									url : "../controller/moduleController.php",
									method : "POST",
									waitTitle : systemLabel,
									waitMsg : waitMessageLabel,
									params : {
										method : "read",
										mode : "update",
										moduleId : record.data.moduleId,
										leafId : leafId
									},
									success : function(form, action) {
									
										viewPort.items.get(1).expand();
									},
									failure : function(form, action) {
										Ext.MessageBox.alert(systemErrorLabel,
												action.result.message);
									}
								});
							}
						},
						tbar : {
							items : [
									{
										text : 'Check All',
										iconCls : 'row-check-sprite-check',
										listeners : {
											'click' : function() {
												var count = moduleStore.getCount();
												moduleStore
														.each(function(rec) {
															for ( var access in accessArray) { // alert(access);
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
										text : 'Clear All',
										iconCls : 'row-check-sprite-uncheck',
										listeners : {
											'click' : function() {
												moduleStore
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
										text : 'save',
										iconCls : 'bullet_disk',
										listeners : {
											'click' : function(c) {
												var url;
												var count = moduleStore.getCount();
												url = '../controller/moduleController.php?';
												var sub_url;
												sub_url = '';
												var modified = moduleStore
														.getModifiedRecords();
												for ( var i = 0; i < modified.length; i++) {
													var record = moduleStore
															.getAt(i);
													sub_url = sub_url
															+ '&moduleId[]='
															+ record
																	.get('moduleId');
													if (isAdmin == 1) {
														sub_url = sub_url
																+ '&isDraft[]='
																+ record
																		.get('isDraft');
														sub_url = sub_url
																+ '&isNew[]='
																+ record
																		.get('isNew');
														sub_url = sub_url
																+ '&isUpdate[]='
																+ record
																		.get('isUpdate');
													}
													sub_url = sub_url
															+ '&isDelete[]='
															+ record
																	.get('isDelete');
													if (isAdmin == 1) {
														sub_url = sub_url
																+ '&isActive[]='
																+ record
																		.get('isActive');
														sub_url = sub_url
																+ '&isApproved[]='
																+ record
																		.get('isApproved');
													}
												}
												url = url + sub_url; // reques
												// and
												// ajax
												Ext.Ajax
														.request({
															url : url,
															method : 'GET',
															params : {
																leafId : leafId,
																method : 'updateStatus'
															},
															success : function(
																	response,
																	options) {
																jsonResponse = Ext
																		.decode(response.responseText);
																if (jsonResponse.success == true) {
																	Ext.MessageBox
																			.alert(
																					systemLabel,
																					jsonResponse.message);
																	moduleStore
																			.reload();
																} else if (jsonResponse.success == false) {
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
														}); // refresh the store
											}
										}
									} ]
						},
						bbar : new Ext.PagingToolbar({
							store : moduleStore,
							pageSize : perPage
						})
					});
			var moduleTranslateEditor = new Ext.ux.grid.RowEditor(
					{
						saveText : 'Save',
						listeners : {
							cancelEdit : function(rowEditor, changes, record,
									rowIndex) {
								moduleStore.reload();
							},
							afteredit : function(rowEditor, changes, record,
									rowIndex) {
								this.save = true; // update record manually
								var record = this.grid.getStore().getAt(
										rowIndex);
								Ext.Ajax.request({
									url : '../controller/moduleController.php',
									method : 'POST',
									params : {
										leafId : leafId,
										method : 'save',
										page : 'detail',
										moduleTranslateId : record
												.get('moduleTranslateId'),
										moduleTranslate : Ext.getCmp(
												'moduleTranslate').getValue()
									},
									success : function(response, options) {
										jsonResponse = Ext
												.decode(response.responseText);
										if (jsonResponse.success == false) {
											Ext.MessageBox.alert(systemLabel,
													jsonResponse.message);
										}
									},
									failure : function(response, options) {
										Ext.MessageBox.alert(systemErrorLabel,
												escape(response.status) + ":"
														+ response.statusText);
									}
								});
							}
						}
					});
			var moduleTranslateGridTranslate = new Ext.grid.GridPanel({
				border : false,
				store : moduleTranslateStore,
				height : 250,
				autoScroll : true,
				columns : moduleTranslateColumnModel,
				viewConfig : {
					autoFill : true,
					forceFit : true
				},
				layout : 'fit',
				disabled: true,
				plugins : [ moduleTranslateEditor ]
			});
			var gridPanel = new Ext.Panel(
					{
						title : leafNote,
						height : 50,
						layout : 'fit',
						iconCls : 'application_view_detail',
						tbar : [
								' ',
								{
									text : reloadToolbarLabel,
									iconCls : 'damodulease_refresh',
									id : 'pageReload',
									disabled : pageReload,
									handler : function() {
										moduleStore.reload();
									}
								},
								'-',
								{
									text : addToolbarLabel,
									iconCls : 'add',
									id : 'pageCreate',
									disabled : pageCreate,
									xtype : 'button',
									handler : function() {
										Ext.Ajax
												.request({
													url : '../controller/moduleController.php',
													method : 'GET',
													params : {
														method : 'read',
														field : 'sequence',
														modulele : 'module',
														leafId : leafId
													},
													success : function(
															response, options) {
														jsonResponse = Ext
																.decode(response.responseText);
														if (jsonResponse.success == 'false') {
															Ext.MessageBox
																	.alert(
																			systemLabel,
																			jsonResponse.message);
														} else {
															Ext
																	.getCmp(
																			'moduleSequence')
																	.setValue(
																			jsonResponse.nextSequence);
														}
													},
													failure : function(
															response, options) {
														
														Ext.MessageBox
																.alert(
																		systemErrorLabel,
																		escape(response.status)
																				+ ":"
																				+ escape(response.statusText));
													}
												});
										viewPort.items.get(1).expand();
									}
								},
								'-',
								{
									text : excelToolbarLabel,
									iconCls : 'page_excel',
									id : 'page_excel',
									disabled : pagePrint,
									handler : function() {
										Ext.Ajax
												.request({
													url : '../moduleData.php?method=report&mode=excel&limit='
															+ perPage
															+ '&leafId='
															+ leafId,
													method : 'GET',
													success : function(
															response, options) {
														jsonResponse = Ext
																.decode(response.responseText);
														if (jsonResponse == true) {
															window
																	.open("../security/document/excel/module.xlsx");
														} else {
															Ext.MessageBox
																	.alert(
																			successLabel,
																			jsonResponse.message);
														}
													},
													failure : function(
															response, options) {
													
														Ext.MessageBox
																.alert(
																		systemErrorLabel,
																		escape(response.status)
																				+ ":"
																				+ escape(response.statusText));
													}
												});
									}
								}, '->', new Ext.ux.form.SearchField({
									store : moduleStore,
									width : 320
								}) ],
						items : [ moduleGrid ]
					}); // viewport just save information,items will do separate
			
			var moduleCode = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : moduleCodeLabel,
				hiddenName : 'moduleCode',
				name : 'moduleCode',
				anchor : '40%'
			});
			var moduleNote = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : moduleNoteLabel,
				hiddenName : 'moduleNote',
				name : 'moduleNote',
				anchor : '40%'
			});
			var moduleSequence = new Ext.form.NumberField({
				labelAlign : 'left',
				fieldLabel : moduleSequenceLabel,
				hiddenName : 'moduleSequence',
				name : 'moduleSequence',
				id : 'moduleSequence',
				anchor : '40%'
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
					[ '361', 'damodulease' ], [ '385', 'delete' ],
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
					[ '949', 'star' ], [ '954', 'stop' ], [ '963', 'module' ],
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
				anchor : '40%',
				triggerAction : 'all',
				valueField : 'iconId',
				displayField : 'iconName',
				iconClsTpl : '{iconName}'
			});
			
			var moduleId = new Ext.form.Hidden({
				name : 'moduleId',
				id : 'moduleId'
			});
			
			var firstRecord = new Ext.form.Hidden({
				name : 'firstRecord',
				id : 'firstRecord'
			});

			var nextRecord = new Ext.form.Hidden({
				name : 'nextRecord',
				id : 'nextRecord'
			});

			var previousRecord = new Ext.form.Hidden({
				name : 'previousRecord',
				id : 'previousRecord'
			});
			var lastRecord = new Ext.form.Hidden({
				name : 'lastRecord',
				id : 'lastRecord'
			});
			
			var formPanel = new Ext.form.FormPanel(
					{
						url : '../controller/moduleController.php',
						method : 'post',
						frame : true,
						title : 'Menu Administration',
						border : false,

						width : 600,

						items : [
								{
									xtype : 'panel',

									items : [ {
										xtype : 'panel',
										layout : 'form',
										title : leafNote,
										bodyStyle : "padding:5px",
										border: true,
										frame: true,
										items : [ moduleId,
										          moduleSequence,moduleCode,
												moduleNote, iconId,
												moduleId ]
									} ]
								}, {
									xtype : 'panel',
									title : 'module Translation',
									disable:true,
									items : [ moduleTranslateGridTranslate]
								} ],
						buttonVAlign : 'top',
						buttonAlign : 'left',
						buttons : [
								{
									text : saveButtonLabel,
									iconCls : 'bullet_disk',
									handler : function() {
										var id = 0;
										var id = Ext.getCmp('moduleId')
												.getValue();
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
																leafId : leafId,
																page : 'master'
															},
															success : function(
																	form,
																	action) {
																var title = successLabel;
																Ext.MessageBox
																		.alert(
																				title,
																				action.result.message);
																Ext
																		.getCmp(
																				'translation')
																		.enable();
																moduleStore
																		.reload({
																		params : {
																				leafId : leafId,
																				start : 0,
																				limit : perPage
																		}
																			});
																Ext
																		.getCmp(
																				'moduleId')
																		.setValue(
																				action.result.moduleId);
																			

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
																			.alert(form.response.status
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
									iconCls : 'modulele_refresh',
									handler : function() {
										formPanel.getForm().reset();
									}
								},
								{
									text : 'Translation',
									id : 'translation',
									disabled : true,
									handler : function() {
										
										Ext.Ajax
												.request({

													url : "../controller/moduleController.php",
													method : 'GET',
													params : {
														leafId : leafId,
														method : 'translate',
														moduleId : Ext
																.getCmp(
																		'moduleId')
																.getValue()
													},
													success : function(
															response, options) {
														jsonResponse = Ext
																.decode(response.responseText);
														if (jsonResponse.success == "true") {
															Ext.MessageBox
																	.alert(
																			systemLabel,
																			jsonResponse.message);

															moduleTranslateStore
																	.reload();
															box.hide();
														} else {
															Ext.MessageBox
																	.alert(
																			systemLabel,
																			jsonResponse.message);
														}
													},
													failure : function(
															response, options) {
													
														Ext.MessageBox
																.alert(
																		systemErrorLabel,
																		escape(response.status)
																				+ ":"
																				+ response.statusText);
													}
												});

									}
								} ]
					});
			var viewPort = new Ext.Viewport({
				id : 'viewport',
				region : 'center',
				layout : 'accordion',
				layoutConfig : { // layout-specific configs go here
					titleCollapse : true,
					animate : false,
					activeOnTop : true
				},
				items : [ gridPanel,formPanel ]
			});
		});