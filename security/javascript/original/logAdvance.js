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
			
			var logAdvanceProxy = new Ext.data.HttpProxy({
				url : "../controller/logAdvanceController.php",
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
			var logAdvanceReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "logAdvanceId"
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
					mode : 'view',
					leafId : leafId
				},
				root : 'data',
				fields : [ {
					name : 'logAdvanceId',
					type : 'int'
				}, {
					name : 'logAdvanceText',
					type : 'string'
				}, {
					name : '',
					type : 'string'
				}, {
					name : 'logAdvanceComparison',
					type : 'string'
				}, {
					name : 'refId',
					type : 'int'
				} ]
			});

			var staffProxy = new Ext.data.HttpProxy({
				url : "../controller/religionController.php?",
				method : "GET",
				success : function(response, options) {
					jsonResponse = Ext.decode(response.responseText);
					if (jsonResponse.success == true) {
						// Ext.MessageBox.alert(successLabel,jsonResponse.message); 
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
			var staffReader = new Ext.data.JsonReader({
				totalProperty : "total",
				successProperty : "success",
				messageProperty : "message",
				idProperty : "staffId"
			});
			var staffStore = new Ext.data.JsonStore({
				proxy : staffProxy,
				reader : staffReader,
				autoLoad : true,
				autoDestroy : true,
				baseParams : {
					method : 'read',
					field : 'staffId',
					leafId : leafId
				},
				root : 'staff',
				fields : [ {
					name : "staffId",
					type : "int"
				}, {
					name : "staffName",
					type : "string"
				} ]
			});

			var filters = new Ext.ux.grid.GridFilters({
				encode : encode,
				local : local,
				filters : [

				{
					type : 'numeric',
					dataIndex : 'logAdvanceId',
					column : 'logAdvanceId',
					table : 'logAdvance'
				},

				{
					type : 'string',
					dataIndex : 'logAdvanceText',
					column : 'logAdvanceText',
					table : 'logAdvance'
				},

				{
					type : 'string',
					dataIndex : 'logAdvanceType',
					column : 'logAdvanceType',
					table : 'logAdvance'
				},

				{
					type : 'string',
					dataIndex : 'logAdvanceComparison',
					column : 'logAdvanceComparison',
					table : 'logAdvance'
				},

				{
					type : 'numeric',
					dataIndex : 'refId',
					column : 'refId',
					table : 'logAdvance'
				},

				{
					type : 'list',
					dataIndex : 'createBy',
					column : 'createBy',
					table : 'logAdvance',
					labelField : 'staffName',
					store : staffStore,
					phpMode : true
				},

				{
					type : 'date',
					dataIndex : 'executeTime',
					column : 'executeTime',
					table : 'logAdvance'
				},

				{
					type : 'list',
					dataIndex : 'updatedBy',
					column : 'updatedBy',
					table : 'logAdvance',
					labelField : 'staffName',
					store : staff_store,
					phpMode : true
				},

				{
					type : 'date',
					dataIndex : 'updatedTime',
					column : 'updatedTime',
					table : 'logAdvance'
				} ]
			});

			this.action = new Ext.ux.grid.RowActions({
				header : actionLabel,
				dataIndex : 'logAdvanceId',
				actions : [ {
					iconCls : 'application_edit',
					tooltip : updateRecordToolTipLabel,
					callback : function(grid, record, action, row, col) {
						
						formPanel.getForm().reset();
						formPanel.form.load({
							url : '../controller/logAdvanceController.php',
							method : 'POST',
							waitTitle:systemLabel,
							waitMsg : waitMessageLabel,
							params : {
								method : 'read',
								mode : 'update',
								logAdvanceId : record.data.logAdvanceId,
								leafId : leafId
							},
							success : function(form, action) {
								viewPort.items.get(1).expand();
							},
							failure : function(action) {
								Ext.MessageBox.alert('Message',
										'Load failed.grid');
							}
						});
					}
				} ]
			});
logAdvanceColumnModel = [ new Ext.grid.RowNumberer(), this.action, {
				dataIndex : 'logAdvanceId',
				header : logAdvanceIdLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'logAdvanceText',
				header : logAdvanceTextLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'logAdvanceType',
				header : logAdvanceTypeLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'logAdvanceComparison',
				header : logAdvanceComparisonLabel,
				sortable : true,
				hidden : false
			},

			{
				dataIndex : 'refId',
				header : refIdLabel,
				sortable : true,
				hidden : false
			} ];

			var logAdvanceGrid = new Ext.grid.GridPanel({
				border : false,
				store : store,
				autoHeight : false,
				height : 400,
				columns : logAdvanceColumnModel,
				loadMask : true,
				plugins : [ this.action, logAdvcanceFilters ],
				sm : new Ext.grid.RowSelectionModel({
					singleSelect : true
				}),
				viewConfig : {
					forceFit : true,
					emptyText : emptyTextLabel
				},
				iconCls : 'application_view_detail',
				listeners : {
					render : {
						fn : function() {
							store.load({
								params : {
									start : 0,
									limit : perPage,
									method : 'read',
									mode : 'view',
									plugin : [ logAdvanceFilters ]
								}
							});
						}
					}
				},
				bbar : new Ext.PagingToolbar({
					store : store,
					pageSize : perPage,
					plugins : [ new Ext.ux.plugins.PageComboResizer() ]
				})
			});

			

			var gridPanel = new Ext.Panel({
				title : leafEnglish,
				height : 50,
				layout : 'fit',
				iconCls : 'application_view_detail',
				items : [ logAdvanceGrid ]
			});

			var logAdvanceId = new Ext.form.Hidden({
				name : 'logAdvanceId'
			});

			var logAdvanceText = new Ext.form.TextArea({
				labelAlign : 'left',
				fieldLabel : logAdvanceText_view_Label,
				hiddenName : 'logAdvanceText',
				style : 'height: 20%',
				name : 'logAdvanceText',
				anchor : '95%'
			});

			var logAdvanceType = new Ext.form.TextField({
				labelAlign : 'left',
				fieldLabel : logAdvanceType_Label,
				hiddenName : 'logAdvanceType',
				name : 'logAdvanceType',
				vtype : 'alpha',
				allowBlank : false,
				blankText : blankTextLabel,
				anchor : '95%'
			});

			var logAdvanceComparison = new Ext.form.TextArea({
				labelAlign : 'left',
				fieldLabel : 'log advance comparison view',
				hiddenName : 'logAdvanceComparison',
				style : 'height: 60%',
				name : 'logAdvanceComparison',
				anchor : '95%'
			});

			var refId = new Ext.form.NumberField({
				labelAlign : 'left',
				fieldLabel : refId_Label,
				hiddenName : 'refId',
				name : 'refId',
				allowBlank : false,
				blankText : blankTextLabel,
				anchor : '95%'
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

			var formPanel = new Ext.form.FormPanel({
				url : '../controller/logAdvanceController.php',
				name:'formPanel',
				id : 'formPanel',
				method : 'post',
				frame : true,
				title : leafEnglish,
				border : false,
				width : 600,
				bodyStyle : 'padding:5px',
				items : [

				logAdvanceId,

				logAdvanceText,

				logAdvanceType,

				logAdvanceComparison,

				refId,

				],
				buttonVAlign : 'top',
				buttonAlign : 'left',
				iconCls : 'application_form'

			});

			var viewPort = new Ext.Viewport({
				id : 'viewport',
				region : 'center',
				layout : 'accordion',
				layoutConfig : {
					titleCollapse : true,
					animate : false,
					activeOnTop : true
				},
				items : [ gridPanel, formPanel ]
			});
		});
