Ext.onReady(function () {
	Ext.QuickTips.init();
	Ext.BLANK_IMAGE_URL = '../../javascript/resources/images/s.gif';
	Ext.form.Field.prototype.msgTarget = 'under';
	Ext.Ajax.timeout = 90000;
	var perPage = 15;
	var encode = false;
	var local = false;
	var jsonResponse;
	var duplicate = 0;
	// common Proxy,Reader,Store,Filter,Grid
	// start Staff Request
	var staffByProxy = new Ext.data.HttpProxy({
			url : '../controller/membershipController.php?',
			method : 'GET',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	var staffByReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'staffId'
		});
	var staffByStore = new Ext.data.JsonStore({
			proxy : staffByProxy,
			reader : staffByReader,
			autoLoad : true,
			autoDestroy : true,
			pruneModifiedRecords : true,
			baseParams : {
				method : 'read',
				field : 'staffId',
				leafId : leafId
			},
			root : 'staff',
			id : 'staffId',
			fields : [{
					name : 'staffId',
					type : 'int'
				}, {
					name : 'staffName',
					type : 'string'
				}
			]
		}); // end Staff Request
	// start log Request
	var logProxy = new Ext.data.HttpProxy({
			url : '../../security/controller/logController.php?',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	var logReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'logId'
		});
	var logStore = new Ext.data.JsonStore({
			proxy : logProxy,
			reader : logReader,
			autoLoad : true,
			autoDestroy : true,
			pruneModifiedRecords : true,
			baseParams : {
				method : 'read',
				leafId : leafId,
				isAdmin : isAdmin,
				start : 0,
				limit : perPage,
				perPage : perPage
			},
			root : 'data',
			fields : [{
					name : 'logId',
					type : 'int'
				}, {
					name : 'leafId',
					type : 'int'
				}, {
					name : 'operation',
					type : 'string'
				}, {
					name : 'sql',
					type : 'string'
				}, {
					name : 'date',
					type : 'date',
					dateFormat : 'Y-m-d'
				}, {
					name : 'staffId',
					type : 'int'
				}, {
					name : 'access',
					type : 'string'
				}, {
					name : 'logError',
					type : 'string'
				}
			]
		});
	var logFilters = new Ext.ux.grid.GridFilters({
			encode : encode,
			local : local,
			filters : [{
					type : 'numeric',
					dataIndex : 'logId',
					column : 'logId',
					table : 'log'
				}, {
					type : 'numeric',
					dataIndex : 'leafId',
					column : 'leafId',
					table : 'log'
				}, {
					type : 'string',
					dataIndex : 'operation',
					column : 'operation',
					table : 'log'
				}, {
					type : 'string',
					dataIndex : 'sql',
					column : 'sql',
					table : 'log'
				}, {
					type : 'date',
					dataIndex : 'date',
					column : 'date',
					table : 'log'
				}, {
					type : 'numeric',
					dataIndex : 'staffId',
					column : 'staffId',
					table : 'log'
				}, {
					type : 'string',
					dataIndex : 'access',
					column : 'access',
					table : 'log'
				}, {
					type : 'string',
					dataIndex : 'logError',
					column : 'logError',
					table : 'log'
				}
			]
		});
	var logExpander = new Ext.ux.grid.RowExpander({
			tpl : new Ext.Template('<br><p><b>Operation:</b> {operation}</p><br>', '<p><b>SQL STATEMENT:</b> {sql}</p><br>')
		});
	var logColumnModel = [logExpander, new Ext.grid.RowNumberer(), {
			dataIndex : 'logId',
			header : logIdLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'leafId',
			header : leafIdLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'operation',
			header : operationLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'sql',
			header : sqlLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'date',
			header : dateLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'staffId',
			header : staffIdLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'access',
			header : accessLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'logError',
			header : logErrorLabel,
			sortable : true,
			hidden : false
		}
	];
	var logGrid = new Ext.grid.GridPanel({
			border : false,
			store : logStore,
			autoHeight : false,
			height : 400,
			columns : logColumnModel,
			loadMask : true,
			plugins : [logFilters, logExpander],
			collapsible : true,
			animCollapse : false,
			selModel : new Ext.grid.RowSelectionModel({
				singleSelect : true
			}),
			viewConfig : {
				emptyText : emptyTextLabel
			},
			iconCls : 'application_view_detail',
			listeners : {
				render : {
					fn : function () {
						logStore.load({
							params : {
								start : 0,
								limit : perPage,
								method : 'read',
								mode : 'view',
								plugin : [logFilters]
							}
						});
					}
				}
			},
			bbar : new Ext.PagingToolbar({
				store : logStore,
				pageSize : perPage,
				plugins : [new Ext.ux.plugins.PageComboResizer()]
			})
		}); // end log Request
	// start Log Advance Request
	var logAdvanceProxy = new Ext.data.HttpProxy({
			url : '../../security/controller/logAdvanceController.php?',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(successLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	var logAdvanceReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'logAdvanceId'
		});
	var logAdvanceStore = new Ext.data.JsonStore({
			proxy : logAdvanceProxy,
			reader : logAdvanceReader,
			autoLoad : true,
			autoDestroy : true,
			pruneModifiedRecords : true,
			method : 'POST',
			baseParams : {
				method : 'read',
				leafId : leafId,
				isAdmin : isAdmin,
				start : 0,
				limit : perPage,
				perPage : perPage
			},
			root : 'data',
			fields : [{
					name : 'logAdvanceId',
					type : 'int'
				}, {
					name : 'logAdvanceText',
					type : 'string'
				}, {
					name : 'logAdvanceType',
					type : 'string'
				}, {
					name : 'logAdvanceComparison',
					type : 'string'
				}, {
					name : 'refTableName',
					type : 'int'
				}, {
					name : 'leafId',
					type : 'int'
				}
			]
		});
	var logAdvanceFilters = new Ext.ux.grid.GridFilters({
			encode : encode,
			local : local,
			filters : [{
					type : 'numeric',
					dataIndex : 'logAdvanceId',
					column : 'logAdvanceId',
					table : 'logAdvance'
				}, {
					type : 'string',
					dataIndex : 'logAdvanceText',
					column : 'logAdvanceText',
					table : 'logAdvance'
				}, {
					type : 'string',
					dataIndex : 'logAdvanceType',
					column : 'logAdvanceType',
					table : 'logAdvance'
				}, {
					type : 'string',
					dataIndex : 'logAdvanceComparison',
					column : 'logAdvanceComparison',
					table : 'logAdvance'
				}, {
					type : 'numeric',
					dataIndex : 'refTableName',
					column : 'refTableName',
					table : 'logAdvance'
				}, {
					type : 'list',
					dataIndex : 'executeBy',
					column : 'executeBy',
					table : 'logAdvance',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'logAdvance'
				}
			]
		});
	var logAdvanceColumnModel = [new Ext.grid.RowNumberer(), {
			dataIndex : 'logAdvanceId',
			header : logAdvanceIdLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'logAdvanceText',
			header : logAdvanceTextLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'logAdvanceType',
			header : logAdvanceTypeLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'logAdvanceComparision',
			header : logAdvanceComparisionLabel,
			sortable : true,
			hidden : false
		}, {
			dataIndex : 'refTableName',
			header : refTableNameLabel,
			sortable : true,
			hidden : false
		}
	];
	var logAdvanceGrid = new Ext.grid.GridPanel({
			border : false,
			store : logAdvanceStore,
			autoHeight : false,
			height : 400,
			columns : logAdvanceColumnModel,
			loadMask : true,
			plugins : [logAdvanceFilters],
			selModel : new Ext.grid.RowSelectionModel({
				singleSelect : true
			}),
			viewConfig : {
				forceFit : true,
				emptyText : emptyTextLabel
			},
			iconCls : 'application_view_detail',
			listeners : {
				render : {
					fn : function () {
						logAdvanceStore.load({
							params : {
								start : 0,
								limit : perPage,
								method : 'read',
								mode : 'view',
								plugin : [logAdvanceFilters]
							}
						});
					}
				}
			},
			bbar : new Ext.PagingToolbar({
				store : logAdvanceStore,
				pageSize : perPage,
				plugins : [new Ext.ux.plugins.PageComboResizer()]
			}),
			view : new Ext.ux.grid.BufferView({
				rowHeight : 34,
				scrollDelay : false
			})
		}); // end log Advance Request
	// popup  window for normal log and advance log
	var auditWindow = new Ext.Window({
			name : 'auditWindow',
			id : 'auditWindow',
			layout : 'fit',
			width : 500,
			height : 300,
			closeAction : 'hide',
			plain : true,
			items : {
				xtype : 'tabpanel',
				activeTab : 0,
				items : [{
						xtype : 'panel',
						layout : 'fit',
						title : 'Log Sql Statement',
						items : [logGrid]
					}, {
						xtype : 'panel',
						layout : 'fit',
						title : 'Log Sql Statement',
						items : [logAdvanceGrid]
					}
				]
			},
			title : 'Sql Statement audit',
			maximizable : true,
			autoScroll : true
		}); // end popup window for normal log and advance log
	// end common Proxy ,Reader,Store,Filter,Grid
	// atart additional Proxy ,Reader,Store,Filter,Grid
	var stateProxy = new Ext.data.HttpProxy({
			url : '../controller/stateController.php',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	var stateReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'stateId'
		});
	var stateStore = new Ext.data.JsonStore({
			proxy : stateProxy,
			reader : stateReader,
			autoLoad : true,
			autoDestroy : true,
			pruneModifiedRecords : true,
			baseParams : {
				method : 'read',
				leafId : leafId,
				isAdmin : isAdmin,
				start : 0,
				perPage : perPage
			},
			root : 'data',
			id : 'stateId',
			fields : [{
					name : 'stateId',
					type : 'int'
				}, {
					name : 'stateDesc',
					type : 'string'
				}
			]
		});
	// end additional Proxy ,Reader,Store,Filter,Grid
	// start application Proxy ,Reader,Store,Filter,Grid
	var membershipProxy = new Ext.data.HttpProxy({
			url : '../controller/membershipController.php',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { // Ext.MessageBox.alert(systemLabel,jsonResponse.message);
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
	var membershipReader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : 'membershipId'
		});
	var membershipStore = new Ext.data.JsonStore({
			proxy : membershipProxy,
			reader : membershipReader,
			autoLoad : true,
			autoDestroy : true,
			pruneModifiedRecords : true,
			baseParams : {
				method : 'read',
				leafId : leafId,
				isAdmin : isAdmin,
				start : 0,
				perPage : perPage
			},
			root : 'data',
			fields : [{
					name : 'membershipId',
					type : 'int'
				}, {
					name : 'stateId',
					type : 'int'
				}, {
					name : 'stateDesc',
					type : 'string'
				}, {
					name : 'membershipDesc',
					type : 'string'
				}, {
					name : 'executeBy',
					type : 'int'
				}, {
					name : 'staffName',
					type : 'string'
				}, {
					name : 'isDefault',
					type : 'boolean'
				}, {
					name : 'isNew',
					type : 'boolean'
				}, {
					name : 'isDraft',
					type : 'boolean'
				}, {
					name : 'isUpdate',
					type : 'boolean'
				}, {
					name : 'isDelete',
					type : 'boolean'
				}, {
					name : 'isActive',
					type : 'boolean'
				}, {
					name : 'isApproved',
					type : 'boolean'
				}, {
					name : 'isReview',
					type : 'boolean'
				}, {
					name : 'isPost',
					type : 'boolean'
				}, {
					name : 'executeBy',
					type : 'int'
				}, {
					name : 'executeTime',
					type : 'date',
					dateFormat : 'Y-m-d H:i:s'
				}
			]
		});
	var membershipFilters = new Ext.ux.grid.GridFilters({
			encode : false,
			local : false,
			filters : [{
					type : 'list',
					dataIndex : 'stateId',
					column : 'stateId',
					table : 'membership',
					labelField : 'stateDesc',
					store : stateStore,
					phpMode : true
				}, {
					type : 'string',
					dataIndex : 'membershipDesc',
					column : 'membershipDesc',
					table : 'membership'
				}, {
					type : 'list',
					dataIndex : 'executeBy',
					column : 'executeBy',
					table : 'membership',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				}, {
					type : 'date',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'membership'
				}
			]
		});
	var isDefaultGrid = new Ext.ux.grid.CheckColumn({
			header : isDefaultLabel,
			dataIndex : 'isDefault',
			hidden : isDefaultHidden
		});
	var isNewGrid = new Ext.ux.grid.CheckColumn({
			header : 'New',
			dataIndex : 'isNew',
			hidden : isNewHidden
		});
	var isDraftGrid = new Ext.ux.grid.CheckColumn({
			header : isDraftLabel,
			dataIndex : 'isDraft',
			hidden : isDraftHidden
		});
	var isUpdateGrid = new Ext.ux.grid.CheckColumn({
			header : isUpdateLabel,
			dataIndex : 'isUpdate',
			hidden : isUpdateHidden
		});
	var isDeleteGrid = new Ext.ux.grid.CheckColumn({
			header : isDeleteLabel,
			dataIndex : 'isDelete'
		});
	var isActiveGrid = new Ext.ux.grid.CheckColumn({
			header : isActiveLabel,
			dataIndex : 'isActive',
			hidden : isActiveHidden
		});
	var isApprovedGrid = new Ext.ux.grid.CheckColumn({
			header : isApprovedLabel,
			dataIndex : 'isApproved',
			hidden : isApprovedHidden
		});
	var isReviewGrid = new Ext.ux.grid.CheckColumn({
			header : isReviewLabel,
			dataIndex : 'isReview',
			hidden : isActiveHidden
		});
	var isPostGrid = new Ext.ux.grid.CheckColumn({
			header : 'Post',
			dataIndex : 'isPost',
			hidden : isPostHidden
		});
	var membershipColumnModel = [new Ext.grid.RowNumberer(), {
			dataIndex : 'membershipRegisterDate',
			header : membershipRegisterDateLabel,
			sortable : true,
			renderer : Ext.util.Format.dateRenderer('d-m-Y'),
			hidden : false,
			width : 50
		}, {
			dataIndex : 'membershipno',
			header : memberNoLabel,
			sortable : true,
			hidden : false,
			width : 50
		}, {
			dataIndex : 'staffNo',
			header : staffNoLabel,
			sortable : true,
			hidden : false,
			width : 50
		}, {
			dataIndex : 'designationDesc',
			header : designationDescLabel,
			sortable : true,
			hidden : true
		}, {
			dataIndex : 'membershipName',
			header : membershipNameLabel,
			sortable : true,
			hidden : false,
			width : 400
		}, {
			dataIndex : 'membershipSalary',
			header : membershipSalary,
			sortable : true,
			hidden : false,
			align : 'right',
			renderer : function (value) {
				return ' RM ' + Ext.util.Format.number(value, '0,0.00');
			}
		},
		isDefaultGrid, isNewGrid, isDraftGrid, isUpdateGrid, isDeleteGrid, isActiveGrid, isApprovedGrid, isReviewGrid, isPostGrid, {
			dataIndex : 'executeBy',
			header : executeByLabel,
			sortable : true,
			hidden : false,
			renderer : function (value, metaData, record, rowIndex, colIndex, store) {
				return record.data.staffName;
			}
		}, {
			dataIndex : 'executeTime',
			header : executeTimeLabel,
			sortable : true,
			hidden : false,
			renderer : function (value, metaData, record, rowIndex, colIndex, store) {
				return Ext.util.Format.date(value, 'd-m-Y H:i:s');
			}
		}
	];
	var membershipFlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isRejected', 'isReview', 'isPost'];
	var membershipGrid = new Ext.grid.GridPanel({
			name : 'membershipGrid',
			id : 'membershipGrid',
			border : false,
			store : membershipStore,
			autoHeight : false,
			height : 400,
			columns : membershipColumnModel,
			plugins : [membershipFilters],
			selModel : new Ext.grid.RowSelectionModel({
				singleSelect : true
			}),
			viewConfig : {
				emptyText : emptyRowLabel
			},
			iconCls : 'application_view_detail',
			listeners : {
				'rowclick' : function (object, rowIndex, e) {
					var record = membershipStore.getAt(rowIndex);
					formPanel.getForm().reset();
					formPanel.form.load({
						url : '../controller/membershipController.php',
						method : 'POST',
						waitTitle : systemLabel,
						waitMsg : waitMessageLabel,
						params : {
							method : 'read',
							mode : 'update',
							membershipId : record.data.membershipId,
							leafId : leafId,
							isAdmin : isAdmin
						},
						success : function (form, action) {
							Ext.getCmp('membershipDescTemp').setValue(record.data.membershipDesc);
							Ext.getCmp('deleteButton').enable();
							viewPort.items.get(1).expand();
						},
						failure : function (form, action) {
							Ext.MessageBox.alert(systemErrorLabel, action.result.message);
						}
					});
					
					Ext.getCmp('newButton').disable();
					Ext.getCmp('saveButton').enable();
					Ext.getCmp('deleteButton').enable();
				}
			},
			tbar : {
				items : [{
						text : CheckAllLabel,
						iconCls : 'row-check-sprite-check',
						listeners : {
							'click' : function (button, e) {
								membershipStore.each(function (record, fn, scope) {
									for (var access in membershipFlagArray) {
										record.set(membershipFlagArray[access], true);
									}
								});
							}
						}
					}, {
						xtype : 'button',
						text : ClearAllLabel,
						iconCls : 'row-check-sprite-uncheck',
						listeners : {
							'click' : function (button, e) {
								membershipStore.each(function (record, fn, scope) {
									for (var access in membershipFlagArray) {
										record.set(membershipFlagArray[access], false);
									}
								});
							}
						}
					}, {
						xtype : 'button',
						text : saveButtonLabel,
						iconCls : 'bullet_disk',
						listeners : {
							'click' : function (button, e) {
								var url = '../controller/membershipController.php?';
								var sub_url = '';
								var modified = membershipStore.getModifiedRecords();
								for (var i = 0; i < modified.length; i++) {
									var dataChanges = modified[i].getChanges();
									sub_url = sub_url + '&membershipId[]=' + modified[i].get('membershipId');
									if (isAdmin == 1) {
										if (dataChanges.isDefault == true || dataChanges.isDefault == false) {
											sub_url = sub_url + '&isDefault[]=' + modified[i].get('isDefault');
										}
										if (dataChanges.isDraft == true || dataChanges.isDraft == false) {
											sub_url = sub_url + '&isDraft[]=' + modified[i].get('isDraft');
										}
										if (dataChanges.isNew == true || dataChanges.isNew == false) {
											sub_url = sub_url + '&isNew[]=' + modified[i].get('isNew');
										}
										if (dataChanges.isUpdate == true || dataChanges.isUpdate == false) {
											sub_url = sub_url + '&isUpdate[]=' + modified[i].get('isUpdate');
										}
									}
									if (dataChanges.isDelete == true || dataChanges.isDelete == false) {
										sub_url = sub_url + '&isDelete[]=' + modified[i].get('isDelete');
									}
									if (isAdmin == 1) {
										if (dataChanges.isActive == true || dataChanges.isActive == false) {
											ssub_url = sub_url + '&isActive[]=' + modified[i].get('isActive');
										}
										if (dataChanges.isApproved == true || dataChanges.isApproved == false) {
											sub_url = sub_url + '&isApproved[]=' + modified[i].get('isApproved');
										}
										if (dataChanges.isReview == true || dataChanges.isReview == false) {
											sub_url = sub_url + '&isReview[]=' + modified[i].get('isReview');
										}
										if (dataChanges.isPost == true || dataChanges.isPost == false) {
											sub_url = sub_url + '&isPost[]=' + modified[i].get('isPost');
										}
									}
								}
								url = url + sub_url;
								Ext.Ajax.request({
									url : url,
									method : 'GET',
									params : {
										leafId : leafId,
										isAdmin : isAdmin,
										method : 'updateStatus'
									},
									success : function (response, options) {
										jsonResponse = Ext.decode(response.responseText);
										if (jsonResponse.success == true) {
											Ext.MessageBox.alert(systemLabel, jsonResponse.message);
											membershipStore.reload();
										} else if (jsonResponse.success == false) {
											Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
										}
									},
									failure : function (response, options) {
										Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
									}
								});
							}
						}
					}
				]
			},
			bbar : new Ext.PagingToolbar({
				store : membershipStore,
				pageSize : perPage,
				plugins : [membershipFilters]
			})
		});
	var gridPanel = new Ext.Panel({
			title : leafNative,
			iconCls : 'application_view_detail',
			layout : 'fit',
			tbar : [{
					text : reloadToolbarLabel,
					iconCls : 'database_refresh',
					id : 'pageReload',
					handler : function () {
						membershipStore.reload();
					}
				},
				'-', {
					text : addToolbarLabel,
					iconCls : 'add',
					id : 'pageCreate',
					
					handler : function () {
						viewPort.items.get(1).expand();
					}
				},
				'-', {
					text : excelToolbarLabel,
					iconCls : 'page_excel',
					id : 'page_excel',
					
					handler : function () {
						Ext.Ajax.request({
							url : '../controller/membershipController.php',
							method : 'GET',
							params : {
								method : 'report',
								mode : 'excel',
								limit : perPage,
								leafId : leafId
							},
							success : function (response, options) {
								jsonResponse = Ext.decode(response.responseText);
								if (jsonResponse.success == true) {
									window.open('../../basic/document/excel/' + jsonResponse.filename);
								} else {
									Ext.MessageBox.alert(successLabel, jsonResponse.message);
								}
							},
							failure : function (response, options) {
								Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
							}
						});
					}
				},
				'-', new Ext.ux.form.SearchField({
					store : membershipStore,
					width : 320
				})],
			items : [membershipGrid]
		});
	// form entry
	var membershipRegisterDate = new Ext.form.DateField({
			labelAlign : 'left',
			fieldLabel : membershipRegisterDateLabel,
			hiddenName : 'membershipRegisterDate',
			name : 'membershipRegisterDate',
			format : 'd-m-Y',
			dateConfig : {
				altFormats : 'Y-m-d',
				allowBlank : true
			},
			anchor : '90%'
		});
	
	var stateId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : emptyTextLabel,
			name : 'stateId',
			valueField : 'stateId',
			hiddenName : 'stateId',
			displayField : 'state_name',
			typeAhead : false,
			triggerAction : 'all',
			mode : 'local',
			store : stateStore,
			anchor : '90%',
			selectOnFocus : true,
			allowBlank : false,
			blankText : emptyTextLabel,
			style : {
				textTransform : "uppercase"
			},
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				value = Ext.escapeRe(value.split('').join('\\s*')).replace(
						/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			}
		});
	
	var religionId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : religionIdLabel,
			name : 'religionId',
			valueField : 'religionId',
			hiddenName : 'religionId',
			displayField : 'religionDesc',
			typeAhead : false,
			triggerAction : 'all',
			mode : 'local',
			store : religionStore,
			anchor : '90%',
			selectOnFocus : true,
			allowBlank : false,
			blankText : 'Sila isi Agama',
			style : {
				textTransform : "uppercase"
			},
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				value = Ext.escapeRe(value.split('').join('\\s*')).replace(
						/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			}
		});
	
	var raceId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : raceIdlabel,
			name : 'raceId',
			valueField : 'raceId',
			hiddenName : 'raceId',
			displayField : 'raceDesc',
			typeAhead : false,
			triggerAction : 'all',
			mode : 'local',
			store : raceStore,
			anchor : '90%',
			selectOnFocus : true,
			allowBlank : false,
			blankText : 'Sila isi Bangsa',
			style : {
				textTransform : "uppercase"
			},
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				value = Ext.escapeRe(value.split('').join('\\s*')).replace(
						/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			}
		});
	
	var departmentId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : departmentIdLabel,
			name : 'departmentId',
			valueField : 'departmentId',
			hiddenName : 'departmentId',
			displayField : 'departmentDesc',
			typeAhead : false,
			triggerAction : 'all',
			mode : 'local',
			store : depStore,
			anchor : '90%',
			selectOnFocus : true,
			allowBlank : false,
			blankText : blankTextLabel,
			style : {
				textTransform : "uppercase"
			},
			listeners : {
				'select' : function () {
					divId.reset();
					divId.enable();
					
					divStore.proxy = new Ext.data.HttpProxy({
							url : 'application_data.php?method=read&field=divId&depId='
							 + this.store.getAt(this.selectedIndex).data.depId
							 + '&leafId=' + leafId,
							method : 'GET',
							
							listeners : {
								exception : function (DataProxy, type, action, options,
									response, arg) {
									
									if (Ext.util.JSON.decode(response.responseText) !== null) {
										var serverMessage = Ext.util.JSON
											.decode(response.responseText);
										// exception only support create record response
										// only and read .. oodddd
										if (serverMessage.success == 'false') {
											Ext.MessageBox.alert("System Error",
												serverMessage.message);
										}
									}
								}
								
							}
						});
					divStore.load();
				}
			},
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				value = Ext.escapeRe(value.split('').join('\\s*')).replace(
						/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			}
		});
	
	var divisionId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : divisionIdLabel,
			name : 'divisionId',
			valueField : 'divisionId',
			hiddenName : 'divisionId',
			displayField : 'divisionDesc',
			typeAhead : false,
			triggerAction : 'all',
			mode : 'local',
			store : divisionStore,
			anchor : '90%',
			selectOnFocus : true,
			allowBlank : false,
			disabled : true,
			blankText : blankTextLabel,
			style : {
				textTransform : "uppercase"
			},
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				value = Ext.escapeRe(value.split('').join('\\s*')).replace(
						/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			}
		});
	
	var genderId = new Ext.ux.form.ComboBoxMatch({
			labelAlign : 'left',
			fieldLabel : genderIdLabel,
			name : 'genderId',
			valueField : 'genderId',
			hiddenName : 'genderId',
			displayField : 'genderDesc',
			typeAhead : false,
			triggerAction : 'all',
			mode : 'local',
			store : genderStore,
			anchor : '90%',
			selectOnFocus : true,
			allowBlank : false,
			disabled : true,
			blankText : blankTextLabel,
			style : {
				textTransform : "uppercase"
			},
			createValueMatcher : function (value) {
				value = String(value).replace(/\s*/g, '');
				if (Ext.isEmpty(value, false)) {
					return new RegExp('^');
				}
				value = Ext.escapeRe(value.split('').join('\\s*')).replace(
						/\\\\s\\\*/g, '\\s*');
				return new RegExp('\\b(' + value + ')', 'i');
			}
		});
	
	var membershipName = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : membershipNameLabel,
			hiddenName : 'membershipName',
			name : 'membershipName',
			allowBlank : false,
			style : {
				textTransform : "uppercase"
			},
			anchor : '90%'
		});
	
	var membershipDesignation = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : membershipDesignationLabel,
			hiddenName : 'membershipDesignation',
			name : 'membershipDesignation',
			allowBlank : false,
			style : {
				textTransform : "uppercase"
			},
			anchor : '90%'
		});
	
	var staffNo = new Ext.form.NumberField({
			labelAlign : 'left',
			fieldLabel : staffNoLabel,
			hiddenName : 'staffNo',
			name : 'staff_no',
			id : 'staff_no',
			allowBlank : false,
			blankText : blankTextLabel,
			autoCreate : {
				tag : 'input',
				type : 'text',
				maxlength : '4',
				autocomplete : 'off'
			},
			anchor : '90%',
			listeners : {
				blur : function () {
					Ext.Ajax.request({
						url : 'application_data.php?method=duplicate&leafId='
						 + leafId
						 + '&staff_no='
						 + Ext.getCmp('staff_no').getValue(),
						method : 'GET',
						success : function (response) {
							x = Ext.decode(response.responseText);
							if (x.total > 0) {
								Ext.MessageBox.alert('System',
									' No. Pekerja ada di dalam sistem :  '
									 + Ext.getCmp('staff_no').getValue()
									 + ' . Sila isi No. Pekerja lain  ');
								Ext.getCmp('staff_no').setValue('');
							} else {
								// nothing to do here just contin
								
							}
						},
						failure : function (response, options) {
							status_code = response.status;
							status_message = response.statusText;
							Ext.MessageBox.alert('system', escape(status_code)
								 + ":" + status_message);
						}
					});
				}
			}
		});
	
	var membershipNo = new Ext.form.NumberField({
			labelAlign : 'left',
			fieldLabel : membershipNoLabel,
			hiddenName : 'membershipNo',
			name : 'membershipNo',
			id : 'membershipNo',
			
			blankText : blankTextLabel,
			autoCreate : {
				tag : 'input',
				type : 'text',
				maxlength : '4',
				autocomplete : 'off'
			},
			anchor : '90%',
			listeners : {
				blur : function () {
					Ext.Ajax.request({
						url : '../controller/membershipController.php?method=duplicate&leafId='
						 + leafId
						 + '&membershipno='
						 + Ext.getCmp('membershipNo').getValue(),
						method : 'GET',
						success : function (response) {
							x = Ext.decode(response.responseText);
							if (x.total > 0) {
								Ext.MessageBox.alert('System',
									' No. Ahli Kospek ada di dalam sistem :  '
									 + Ext.getCmp('membershipno').getValue()
									 + ' . Sila isi No. Ahli Kospek lain  ');
								Ext.getCmp('membershipno').setValue('');
							} else {
								// nothing to do here just contin
								
							}
						},
						failure : function (response, options) {
							status_code = response.status;
							status_message = response.statusText;
							Ext.MessageBox.alert('system', escape(status_code)
								 + ":" + status_message);
						}
					});
				}
			}
		});
	var membershipIc = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : membershipIcLabel,
			hiddenName : 'membershipIc',
			name : 'membershipIc',
			allowBlank : false,
			anchor : '90%'
		});
	var membershipPhone = new Ext.form.TextField({
			labelAlign : 'left',
			fieldLabel : membershipPhoneLabel,
			hiddenName : ' membershipPhone ',
			name : ' membershipPhone ',
			anchor : ' 90 % '
		});
	var membershipMobile = new Ext.form.TextField({
			labelAlign : ' left ',
			fieldLabel : membershipMobileLabel,
			hiddenName : ' membershipMobile ',
			name : ' membershipMobile ',
			anchor : ' 90 % '
		});
	var membershipPostcode = new Ext.form.TextField({
			labelAlign : ' left ',
			fieldLabel : membershipPostcodeLabel,
										hiddenName : ' membershipPostcode ',
										name : ' membershipPostcode ',
										anchor : ' 90 % '
									});
								var membershipExt = new Ext.form.TextField({
										labelAlign : ' left ',
										fieldLabel : membershipExtensionLabel,
										hiddenName : ' membershipExt ',
										name : ' membershipExt ',
										anchor : ' 90 % '
									});
								var membershipEmail = new Ext.form.TextField({
										labelAlign : ' left ',
										fieldLabel : membershipEmailLabel,
										hiddenName : ' membershipEmail ',
										name : ' membershipeml ',
			
										anchor : ' 90 % '
									});
								var membershipSalary = new Ext.form.NumberField({
										labelAlign : ' left ',
										fieldLabel : membershipSalaryLabel,
										hiddenName : ' membershipSalary ',
										name : ' membershipSalary ',
										anchor : ' 90 % '
									});
			
								var membershipAddress = new Ext.form.TextArea({
										labelAlign : ' left ',
										fieldLabel : membershipAddressLabel,
										id : ' membershipAddress ',
										name : ' membershipAddress ',
										height : 50,
										style : {
											textTransform : "uppercase"
										},
										anchor : ' 90 % '
									});
			
								// using normal form instead of grid for other membership and inheritance
			
								// other membership
								var other_membership_one = new Ext.form.TextField({
										labelAlign : ' left ',
										fieldLabel : otherMembershipOneLabel,
										hiddenName : ' otherMembershipOne ',
										name : ' otherMembershipOne ',
										style : {
											textTransform : "uppercase"
										},
										anchor : ' 90 % '
									});
								var otherMembershipTwo = new Ext.form.TextField({
										labelAlign : ' left ',
										fieldLabel : otherMembershipTwoLabel,
										hiddenName : ' otherMembershipTwo ',
										name : ' other_membership_two ',
										style : {
											textTransform : "uppercase"
										},
										anchor : ' 90 % '
									});
								var otherMembershipThree = new Ext.form.TextField({
										labelAlign : ' left ',
										fieldLabel : otherMembershipThreeLabel,
										hiddenName : ' otherMembershipThree ',
										name : ' otherMembershipThree ',
										style : {
											textTransform : "uppercase"
										},
										anchor : ' 90 % '
									});
								var otherMembershipFour = new Ext.form.TextField({
										labelAlign : ' left ',
										fieldLabel : otherMembershipFourLabel,
										hiddenName : ' otherMembershipFour ',
										name : ' otherMembershipFour ',
										style : {
											textTransform : "uppercase"
										},
										anchor : ' 90 % '
									});
			
								// inheritance
								var inheritanceName = new Ext.form.TextField({
										labelAlign : ' left ',
										fieldLabel : inheritanceNameLabel,
										hiddenName : ' inheritanceName ',
										name : ' inheritanceName ',
										tabIndex : 1,
										style : {
											textTransform : "uppercase"
										},
										anchor : ' 90 % '
									});
			
								var inheritanceIc = new Ext.form.TextField({
										labelAlign : ' left ',
										fieldLabel : inheritanceIc,
										hiddenName : ' inheritanceIc ',
										name : ' inheritanceIc ',
										tabIndex : 2,
										style : {
											textTransform : "uppercase"
										},
										anchor : ' 90 % '
									});
			
								var inheritanceAddress = new Ext.form.TextArea({
										labelAlign : ' left ',
										fieldLabel : inheritanceAddressLabel,
										hiddenName : ' inheritanceAddress ',
										name : ' inheritanceAddress ',
										tabIndex : 6,
										style : {
											textTransform : "uppercase"
										},
										anchor : ' 90 % '
									});
			
								var familyId = new Ext.ux.form.ComboBoxMatch({
										labelAlign : ' left ',
										fieldLabel : familyIdLabel,
										name : ' familyId ',
										valueField : ' familyId ',
										hiddenName : ' familyId ',
										displayField : ' familyDesc ',
										autoSelect : true,
										typeAhead : false,
										triggerAction : ' all ',
										mode : ' local ',
										store : familyStore,
										anchor : ' 90 % ',
										selectOnFocus : true,
										allowBlank : false,
										blankText : blankTextLabel,
										tabIndex : 3,
										style : {
											textTransform : "uppercase"
										},
										createValueMatcher : function (value) {
											value = String(value).replace(/\s*/g, ' ');
											if (Ext.isEmpty(value, false)) {
												return new RegExp('^');
											}
											value = Ext.escapeRe(value.split(' ').join(' \\ s * ')).replace(
													/\\\\s\\\*/g, ' \\ s * ');
											return new RegExp(' \\ b(' + value + ')', ' i ');
										}
									});
			
								var inheritancePhone = new Ext.form.TextField({
										labelAlign : ' left ',
										fieldLabel : inheritancePhoneLabel,
										hiddenName : ' inheritancePhone ',
										name : ' inheritancePhone ',
										tabIndex : 4,
										anchor : ' 90 % '
									});
			
								var inheritanceMobile = new Ext.form.TextField({
										labelAlign : ' left ',
										fieldLabel : inheritanceMobileLabel,
										hiddenName : ' inheritanceMobile ',
										name : ' inheritanceMobile ',
										tabIndex : 5,
										anchor : ' 90 % '
									});
								// end form entry
								// hidden id for updated
								var membershipuniqueId = new Ext.form.Hidden({
										name : ' membershipuniqueId '
									});
			
								// start System Validation
								var isDefault = new Ext.form.Checkbox({
										name : ' isDefault ',
										id : ' isDefault ',
										fieldLabel : isDefaultLabel,
										hidden : isDefaultHidden
									});
								var isNew = new Ext.form.Checkbox({
										name : ' isNew ',
										id : ' isNew ',
										fieldLabel : isNewLabel,
										hidden : isNewHidden
									});
								var isDraft = new Ext.form.Checkbox({
										name : ' isDraft ',
										id : ' isDraft ',
										fieldLabel : isDraftLabel,
										hidden : isDraftHidden
									});
								var isUpdate = new Ext.form.Checkbox({
										name : ' isUpdate ',
										id : ' isUpdate ',
										fieldLabel : isUpdateLabel,
										hidden : isUpdateHidden
									});
								var isDelete = new Ext.form.Checkbox({
										name : ' isDelete ',
										id : ' isDelete ',
										fieldLabel : isDeleteLabel,
										hidden : isDeleteHidden
									});
								var isActive = new Ext.form.Checkbox({
										name : ' isActive ',
										id : ' isActive ',
										fieldLabel : isActiveLabel,
										hidden : isActiveHidden
									});
								var isApproved = new Ext.form.Checkbox({
										name : ' isApproved ',
										id : ' isApproved ',
										fieldLabel : isApprovedLabel,
										hidden : isApprovedHidden
									});
								var isReview = new Ext.form.Checkbox({
										name : ' isReview ',
										id : ' isReview ',
										fieldLabel : isReviewLabel,
										hidden : isReviewHidden
									});
								var isPost = new Ext.form.Checkbox({
										name : ' isPost ',
										id : ' isPost ',
										fieldLabel : isPostLabel,
										hidden : isPostHidden
									}); // hidden value for navigation button
								var firstRecord = new Ext.form.Hidden({
										name : ' firstRecord ',
										id : ' firstRecord ',
										value : ' '
									});
								var nextRecord = new Ext.form.Hidden({
										name : ' nextRecord ',
										id : ' nextRecord ',
										value : ' '
									});
								var previousRecord = new Ext.form.Hidden({
										name : ' previousRecord ',
										id : ' previousRecord ',
										value : ' '
									});
								var lastRecord = new Ext.form.Hidden({
										name : ' lastRecord ',
										id : ' lastRecord ',
										value : ' '
									});
								var endRecord = new Ext.form.Hidden({
										name : ' endRecord ',
										id : ' endRecord ',
										value : ' '
									}); // end of hidden value for navigation button
								// end System Validation
								var formPanel = new Ext.form.FormPanel({
										url : '.. / controller / membershipController.php ',
										name : ' formPanel ',
										id : ' formPanel ',
										method : ' post ',
										frame : true,
										title : leafNative,
										border : false,
										bodyStyle : ' padding : 5px ',
										width : 600,
										items : [{
			
												frame : true,
												xtype : ' tabpanel ',
												title : ' Borang Permohonan ',
												deferredRender : false,
												activeTab : 0,
												height : 300,
												items : [{
														layout : ' column ',
														xtype : ' panel ',
														frame : true,
														title : ' Maklumat Asas ',
														items : [{
																columnWidth : 0.5,
																layout : ' form ',
																items : [membershipId, membershipName, religionId,
																	membershipPhone, genderId, marrigeStatusId]
															}, {
																columnWidth : 0.5,
																layout : ' form ',
																items : [membershipIc, raceId, membershipMobile,
																	membershipEmail, membershipSalary]
															}
														]
			
													}, {
														xtype : ' panel ',
														title : ' Alamat ',
														frame : true,
														layout : ' form ',
														bodyStyle : ' padding : 15px ',
														items : [membershipAddress, membershipPostcode, stateId]
													}, {
														layout : ' column ',
														xtype : ' panel ',
														frame : true,
														title : ' Pejabat ',
														items : [{
																columnWidth : 0.5,
																layout : ' form ',
																items : [membershipExt, staffNo]
															}, {
																columnWidth : 0.5,
																layout : ' form ',
																items : [membershipDesignation, departmentId, membershipNo]
															}
														]
			
													}, {
														xtype : ' panel ',
														title : ' Keahlian Dalam Koperasi dan Pertubuhan Lain ',
														layout : ' form ',
														frame : true,
														items : [otherMembershipOne, otherMembershipTwo,
															otherMembershipThree, otherMembershipFour]
													}, {
														xtype : ' panel ',
														title : ' Pewaris ',
														layout : ' form ',
														frame : true,
														items : [inheritanceName, inheritanceIc, familyId,
															inheritancePhone, inheritanceMobile, inheritanceAddress]
													}
												]
											}
										],
										buttonVAlign : ' top ',
										buttonAlign : ' left ',
										iconCls : ' application_form ',
										bbar : new Ext.ux.StatusBar({
											id : ' form - statusbar ',
											defaultText : defaultTextLabel,
											plugins : new Ext.ux.ValidationStatus({
												form : ' formPanel '
											})
										}),
										buttons : [{
												text : auditButtonLabel,
												name : ' auditButtonLabel ',
												id : ' auditButtonLabel ',
												type : ' button ',
												iconCls : ' key ',
												disabled : auditButtonLabelDisabled,
												handler : function () {
													if (auditWindow) {
														membershipStore.reload();
														auditWindow.show().center();
													}
												}
											}, {
												text : newButtonLabel,
												name : ' newButton ',
												id : ' newButton ',
												type : ' button ',
												iconCls : ' new ',
												handler : function () {
													var id = Ext.getCmp(' membershipId ').getValue();
													var method = ' create ';
													formPanel.getForm().submit({
														waitMsg : waitMessageLabel,
														params : {
															method : method,
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function (form, action) {
															if (action.result.success == true) {
																Ext.MessageBox.alert(systemLabel, action.result.message);
																Ext.getCmp(' newButton ').disable();
																Ext.getCmp(' saveButton ').enable();
																Ext.getCmp(' deleteButton ').enable();
																membershipStore.reload({
																	params : {
																		leafId : leafId,
																		start : 0,
																		limit : perPage
																	}
																});
																Ext.getCmp(' membershipId ').setValue(action.result.membershipId);
															} else {
																Ext.MessageBox.alert(systemErrorLabel, action.result.message);
															}
														},
														failure : function (form, action) {
															if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																Ext.Msg.alert(systemErrorLabel, loadFailureLabel);
															} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
																Ext.Msg.alert(systemErrorLabel, clientInvalidLabel);
															} else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
																Ext.Msg.alert(form.response.status + ' ' + form.response.statusText);
															} else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
																Ext.Msg.alert(systemErrorLabel, action.result.message);
															}
														}
													});
												}
											}, {
												text : saveButtonLabel,
												name : ' saveButton ',
												id : ' saveButton ',
												iconCls : ' bullet_disk ',
												disabled : true,
												handler : function () {
													Ext.getCmp(' newButton ').disable();
													var id = Ext.getCmp(' membershipId ').getValue();
													var method = ' save ';
													formPanel.getForm().submit({
														waitMsg : waitMessageLabel,
														params : {
															method : method,
															leafId : leafId,
															isAdmin : isAdmin
														},
														success : function (form, action) {
															if (action.result.success == true) {
																Ext.MessageBox.alert(systemLabel, action.result.message);
																Ext.getCmp(' newButton ').disable();
																Ext.getCmp(' saveButton ').enable();
																Ext.getCmp(' deleteButton ').enable();
																membershipStore.reload({
																	params : {
																		leafId : leafId,
																		start : 0,
																		limit : perPage
																	}
																});
															} else {
																Ext.MessageBox.alert(systemErrorLabel, action.result.message);
															}
														},
														failure : function (form, action) {
															if (action.failureType === Ext.form.Action.LOAD_FAILURE) {
																Ext.Msg.alert(systemErrorLabel, loadFailureLabel);
															} else if (action.failureType === Ext.form.Action.CLIENT_INVALID) {
																Ext.Msg.alert(systemErrorLabel, clientInvalidLabel);
															} else if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
																Ext.Msg.alert(form.response.status + ' ' + form.response.statusText);
															} else if (action.failureType === Ext.form.Action.SERVER_INVALID) {
																Ext.Msg.alert(systemErrorLabel, action.result.message);
															}
														}
													});
												}
											}, {
												text : deleteButtonLabel,
												type : ' button ',
												name : ' deleteButton ',
												id : ' deleteButton ',
												iconCls : ' trash ',
												disabled : true,
												handler : function () {
													Ext.getCmp(' newButton ').disable();
													Ext.Msg.show({
														title : deleteRecordTitleMessageLabel,
														msg : deleteRecordMessageLabel,
														icon : Ext.Msg.QUESTION,
														buttons : Ext.Msg.YESNO,
														scope : this,
														fn : function (response) {
															if (' yes ' == response) {
																Ext.Ajax.request({
																	url : '.. / controller / membershipController.php ',
																	params : {
																		method : ' delete ',
																		membershipId : Ext.getCmp(' membershipId ').getValue(),
																		leafId : leafId,
																		isAdmin : isAdmin
																	},
																	success : function (response, options) {
																		jsonResponse = Ext.decode(response.responseText);
																		if (jsonResponse.success == true) {
																			Ext.MessageBox.alert(systemLabel, jsonResponse.message);
																			membershipStore.reload({
																				params : {
																					leafId : leafId,
																					start : 0,
																					limit : perPage
																				}
																			});
																			Ext.getCmp(' saveButton ').disable();
																			Ext.getCmp(' nextButton ').disable();
																			Ext.getCmp(' previousButton ').disable();
																		} else {
																			Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
																		}
																	},
																	failure : function (response, options) {
																		Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ' : ' + response.statusText);
																	}
																});
															}
														}
													});
												}
											}, {
												text : resetButtonLabel,
												type : ' reset ',
												name : ' resetButton ',
												id : ' resetButton ',
												iconCls : ' database_refresh ',
												handler : function () {
													Ext.getCmp(' newButton ').enable();
													Ext.getCmp(' saveButton ').disable();
													Ext.getCmp(' deleteButton ').disable();
													Ext.getCmp(' postButton ').disable();
													formPanel.getForm().reset();
												}
											}, {
												text : postButtonLabel,
												type : ' button ',
												name : ' postButton ',
												id : ' postButton ',
												iconCls : ' lock ',
												disabled : true,
												handler : function () {
													Ext.getCmp(' newButton ').disable();
													formPanel.getForm().reset();
												}
											}, {
												text : gridButtonLabel,
												type : ' button ',
												name : ' gridButton ',
												id : ' gridButton ',
												iconCls : ' table ',
												handler : function () {
													formPanel.getForm().reset();
													viewPort.items.get(0).expand();
												}
											}, {
												text : firstButtonLabel,
												name : ' firstButton ',
												id : ' firstButton ',
												type : ' button ',
												iconCls : ' resultset_first ',
												handler : function () {
													Ext.getCmp(' newButton ').disable();
													if (Ext.getCmp(' firstRecord ').getValue() == ' ') {
														Ext.Ajax.request({
															url : '.. / controller / membershipController.php ',
															method : ' GET ',
															params : {
																method : ' dataNavigationRequest ',
																leafId : leafId,
																dataNavigation : ' firstRecord '
															},
															success : function (response, options) {
																jsonResponse = Ext.decode(response.responseText);
																if (jsonResponse.success == true) {
																	Ext.getCmp(' firstRecord ').setValue(jsonResponse.firstRecord);
																	formPanel.form.load({
																		url : '.. / controller / membershipController.php ',
																		method : ' POST ',
																		waitTitle : systemLabel,
																		waitMsg : waitMessageLabel,
																		params : {
																			method : ' read ',
																			membershipId : Ext.getCmp(' firstRecord ').getValue(),
																			leafId : leafId,
																			isAdmin : isAdmin
																		},
																		success : function (form, action) {
																			if (action.result.success == true) {
																				if (action.result.nextRecord == 0) {
																					Ext.getCmp(' nextButton ').disable();
																				} else {
																					Ext.getCmp(' nextButton ').enable();
																				}
																				Ext.getCmp(' firstRecord ').setValue(action.result.firstRecord);
																				Ext.getCmp(' previousRecord ').setValue(action.result.previousRecord);
																				Ext.getCmp(' nextRecord ').setValue(action.result.nextRecord);
																				Ext.getCmp(' lastRecord ').setValue(action.result.lastRecord);
																				Ext.getCmp(' endRecord ').setValue((action.result.lastRecord + 1));
																				Ext.getCmp(' previousButton ').disable();
																			} else {
																				Ext.MessageBox.alert(systemErrorLabel, action.result.message);
																			}
																		},
																		failure : function (form, action) {
																			Ext.MessageBox.alert(systemErrorLabel, action.result.message);
																		}
																	});
																} else {
																	Ext.MessageBox.alert(systemLabel, jsonResponse.message);
																}
															},
															failure : function (response, options) {
																Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ' : ' + escape(response.statusText));
															}
														});
													} else {
														formPanel.form.load({
															url : '.. / controller / membershipController.php ',
															method : ' POST ',
															waitTitle : systemLabel,
															waitMsg : waitMessageLabel,
															params : {
																method : ' read ',
																membershipId : Ext.getCmp(' firstRecord ').getValue(),
																leafId : leafId,
																isAdmin : isAdmin
															},
															success : function (form, action) {
																if (action.result.success == true) {
																	if (action.result.nextRecord == 0) {
																		Ext.getCmp(' nextButton ').disable();
																	} else {
																		Ext.getCmp(' nextButton ').enable();
																	}
																	Ext.getCmp(' firstRecord ').setValue(action.result.firstRecord);
																	Ext.getCmp(' previousRecord ').setValue(action.result.previousRecord);
																	Ext.getCmp(' nextRecord ').setValue(action.result.nextRecord);
																	Ext.getCmp(' lastRecord ').setValue(action.result.lastRecord);
																	Ext.getCmp(' endRecord ').setValue((action.result.lastRecord + 1));
																	Ext.getCmp(' previousButton ').disable();
																} else {
																	Ext.MessageBox.alert(systemErrorLabel, action.result.message);
																}
															},
															failure : function (form, action) {
																Ext.MessageBox.alert(systemErrorLabel, action.result.message);
															}
														});
													}
												}
											}, {
												text : previousButtonLabel,
												name : ' previousButton ',
												id : ' previousButton ',
												type : ' button ',
												iconCls : ' resultset_previous ',
												disabled : true,
												handler : function () {
													Ext.getCmp(' newButton ').disable();
													if (Ext.getCmp(' previousRecord ').getValue() == ' ' || Ext.getCmp(' previousRecord ').getValue() == undefined) {
														Ext.MessageBox.alert(systemErrorLabel, chooseRecordLabel);
													}
													if (Ext.getCmp(' firstRecord ').getValue() >= 1) {
														formPanel.form.load({
															url : '.. / controller / membershipController.php ',
															method : ' POST ',
															waitTitle : systemLabel,
															waitMsg : waitMessageLabel,
															params : {
																method : ' read ',
																membershipId : Ext.getCmp(' previousRecord ').getValue(),
																leafId : leafId,
																isAdmin : isAdmin
															},
															success : function (form, action) {
																if (action.result.success == true) {
																	Ext.getCmp(' firstRecord ').setValue(action.result.firstRecord);
																	Ext.getCmp(' previousRecord ').setValue(action.result.previousRecord);
																	Ext.getCmp(' nextRecord ').setValue(action.result.nextRecord);
																	Ext.getCmp(' lastRecord ').setValue(action.result.lastRecord);
																	Ext.getCmp(' endRecord ').setValue((action.result.lastRecord + 1));
																	if (Ext.getCmp(' previousRecord ').getValue() == 0) {
																		Ext.getCmp(' previousButton ').disable();
																	}
																} else {
																	Ext.MessageBox.alert(systemErrorLabel, action.result.message);
																}
															},
															failure : function (form, action) {
																Ext.MessageBox.alert(systemErrorLabel, action.result.message);
															}
														});
													} else {
														Ext.MessageBox.alert(systemErrorLabel, recordNotFoundLabel);
													}
												}
											}, {
												text : nextButtonLabel,
												name : ' nextButton ',
												id : ' nextButton ',
												type : ' button ',
												disabled : true,
												iconCls : ' resultset_next ',
												handler : function () {
													Ext.getCmp(' newButton ').disable();
													if (Ext.getCmp(' nextRecord ').getValue() == ' ' || Ext.getCmp(' nextRecord ').getValue() == undefined) {
														Ext.MessageBox.alert(systemErrorLabel, chooseRecordLabel);
													}
													if (Ext.getCmp(' nextRecord ').getValue() <= Ext.getCmp(' lastRecord ').getValue()) {
														formPanel.form.load({
															url : '.. / controller / membershipController.php ',
															method : ' POST ',
															waitTitle : systemLabel,
															waitMsg : waitMessageLabel,
															params : {
																method : ' read ',
																membershipId : Ext.getCmp(' nextRecord ').getValue(),
																leafId : leafId,
																isAdmin : isAdmin
															},
															success : function (form, action) {
																if (action.result.success == true) {
																	Ext.getCmp(' firstRecord ').setValue(action.result.firstRecord);
																	Ext.getCmp(' previousRecord ').setValue(action.result.previousRecord);
																	Ext.getCmp(' nextRecord ').setValue(action.result.nextRecord);
																	Ext.getCmp(' lastRecord ').setValue(action.result.lastRecord);
																	Ext.getCmp(' endRecord ').setValue((action.result.lastRecord + 1));
																	if (Ext.getCmp(' nextRecord ').getValue() > Ext.getCmp(' lastRecord ').getValue()) {
																		Ext.getCmp(' nextButton ').disable();
																	}
																	if (Ext.getCmp(' nextRecord ').getValue() == 0) {
																		Ext.getCmp(' nextButton ').disable();
																	}
																	Ext.getCmp(' previousButton ').enable();
																} else {
																	Ext.MessageBox.alert(systemErrorLabel, action.result.message);
																}
															},
															failure : function (form, action) {
																Ext.MessageBox.alert(systemErrorLabel, action.result.message);
															}
														});
													} else {
														Ext.MessageBox.alert(systemErrorLabel, recordNotFoundLabel);
													}
												}
											}, {
												text : endButtonLabel,
												name : ' endButton ',
												id : ' endButton ',
												type : ' button ',
												iconCls : ' resultset_last ',
												handler : function () {
													Ext.getCmp(' newButton ').disable();
													if (Ext.getCmp(' lastRecord ').getValue() == ' ' || Ext.getCmp(' lastRecord ').getValue() == undefined) {
														Ext.Ajax.request({
															url : '.. / controller / membershipController.php ',
															method : ' GET ',
															params : {
																method : ' dataNavigationRequest ',
																leafId : leafId,
																dataNavigation : ' lastRecord '
															},
															success : function (response, options) {
																jsonResponse = Ext.decode(response.responseText);
																if (jsonResponse.success == true) {
																	Ext.getCmp(' lastRecord ').setValue(jsonResponse.lastRecord);
																	formPanel.form.load({
																		url : '.. / controller / membershipController.php ',
																		method : ' POST ',
																		waitTitle : systemLabel,
																		waitMsg : waitMessageLabel,
																		params : {
																			method : ' read ',
																			membershipId : Ext.getCmp(' lastRecord ').getValue(),
																			leafId : leafId,
																			isAdmin : isAdmin
																		},
																		success : function (form, action) {
																			if (action.result.success == true) {
																				if (action.result.previousRecord == 0) {
																					Ext.getCmp(' previousButton ').disable();
																				} else {
																					Ext.getCmp(' previousButton ').enable();
																				}
																				Ext.getCmp(' firstRecord ').setValue(action.result.firstRecord);
																				Ext.getCmp(' previousRecord ').setValue(action.result.previousRecord);
																				Ext.getCmp(' nextRecord ').setValue(action.result.nextRecord);
																				Ext.getCmp(' lastRecord ').setValue(action.result.lastRecord);
																				Ext.getCmp(' endRecord ').setValue((action.result.lastRecord + 1));
																				Ext.getCmp(' nextButton ').disable();
																				Ext.getCmp(' previousButton ').enable();
																			} else {
																				Ext.MessageBox.alert(systemErrorLabel, action.result.message);
																			}
																		},
																		failure : function (form, action) {
																			Ext.MessageBox.alert(systemErrorLabel, action.result.message);
																		}
																	});
																} else {
																	Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
																}
															},
															failure : function (response, options) {
																Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ' : ' + escape(response.statusText));
															}
														});
													}
													if (Ext.getCmp(' membershipId ').getValue() <= Ext.getCmp(' lastRecord ').getValue()) {
														formPanel.form.load({
															url : '.. / controller / membershipController.php ',
															method : ' POST ',
															waitTitle : systemLabel,
															waitMsg : waitMessageLabel,
															params : {
																method : ' read ',
																membershipId : Ext.getCmp(' lastRecord ').getValue(),
																leafId : leafId,
																isAdmin : isAdmin
															},
															success : function (form, action) {
																if (action.result.success == true) {
																	if (action.result.previousRecord == 0) {
																		Ext.getCmp(' previousButton ').disable();
																	} else {
																		Ext.getCmp(' previousButton ').enable();
																	}
																	Ext.getCmp(' firstRecord ').setValue(action.result.firstRecord);
																	Ext.getCmp(' previousRecord ').setValue(action.result.previousRecord);
																	Ext.getCmp(' nextRecord ').setValue(action.result.nextRecord);
																	Ext.getCmp(' lastRecord ').setValue(action.result.lastRecord);
																	Ext.getCmp(' endRecord ').setValue((action.result.lastRecord + 1));
																	Ext.getCmp(' nextButton ').disable();
																	Ext.getCmp(' previousButton ').enable();
																} else {
																	Ext.MessageBox.alert(systemErrorLabel, action.result.message);
																}
															},
															failure : function (form, action) {
																Ext.MessageBox.alert(systemErrorLabel, action.result.message);
															}
														});
													} else {
														Ext.MessageBox.alert(systemErrorLabel, recordNotFoundLabel);
													}
												}
											}
										]
									});
								var viewPort = new Ext.Viewport({
        id: 'viewport',
        region: 'center',
        layout: 'accordion',
        layoutConfig: {
            titleCollapse: true,
            animate: false,
            activeOnTop: true
        },
        items: [gridPanel, formPanel]
    });
});
