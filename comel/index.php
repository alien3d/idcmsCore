<?php 
	
    $targetFolder='iFinancial';
	$targetDatabase='mysql';
	$targetDb="ifinancial";
	$targetTable ='generalLedgerJournalDetail';
	$managementDb="imanagement";
	$mysqlOpenTag="`";
	$mysqlCloseTag="`";
	$mssqlOpenTag="[";
	$mssqlCloseTag="]";
	if($_GET['tag']=='mysql'){
		$openTag = $mysqlOpenTag;
		$closeTag = $mysqlCloseTag;
	} else {
		$openTag = $mssqlOpenTag;
		$closeTag = $mssqlCloseTag;
	}
	mysql_connect("localhost","root","123456");
	
	mysql_select_db($targetDb);
	mysql_query("SET autocommit=0");
	

	$resultTable= mysql_query($sqlTable);
	$sqlFieldTable     ="describe `".$targetDb."`.`".$targetTable."`";

	$resultFieldTable  = mysql_query($sqlFieldTable);
	while($rowFieldTable = mysql_fetch_array($resultFieldTable)) {
		$columnName=$rowFieldTable['Field'];
		$columnNameArray[]=$columnName;
		$mystring=$rowFieldTable['Type'];
		$key  = $rowFieldTable['Key'];
		
		$sql="
		SELECT table_schema, table_name, column_name, referenced_table_schema, referenced_table_name, referenced_column_name
FROM information_schema.KEY_COLUMN_USAGE
WHERE 
table_schema='".$targetDb."'
AND table_name = '".$targetTable."'
AND  column_name ='".$columnName."'		";
	
		$resultForeignKey = mysql_query($sql) or die(mysql_error());
		$rowForeignKey  = mysql_fetch_array($resultForeignKey);
		if($rowForeignKey['referenced_table_schema'] != null  && $rowForeignKey['referenced_table_name'] != null && $rowForeignKey['referenced_column_name'] != null) {
	
			$foreignKey='yes';
		} else {
			$foreignKey='no';
		}
		$findme='varchar';
		$pos = strpos($mystring, $findme);
		if ($pos !== false) {
			$formType="Text";
			$jsonType='string';
		}
		$findme='text';
		$pos = strpos($mystring, $findme);
		if ($pos !== false) {
			$formType="Text";
			$jsonType='string';
		}
		$findme='int';
		$pos = strpos($mystring, $findme);
		if ($pos !== false) {
			$formType="Number";
			$jsonType='int';
		}
		$findme='date';
		$pos = strpos($mystring, $findme);
		if ($pos !== false) {
			$formType="Date";
			$dateType='Y-m-d';
			$jsonType='date';
		}
		$findme='datetime';	
		$pos = strpos($mystring, $findme);
		if ($pos !== false) {
			$formType="Date";
			$dateType='Y-m-d H:i:s';
			$jsonType='date';
		}
		$findme='tiny';
		$pos = strpos($mystring, $findme);
		if ($pos !== false) {
			$formType="Number";
			$jsonType='boolean';
		}
		
		$findme='double';
		$pos = strpos($mystring, $findme);
		if ($pos !== false) {
			$formType="Text";
			$jsonType='float';
		}
		$str.="{
			key :'".$key."',
			foreignKey : '".$foreignKey."',
			name : '".$columnName."',
			type : '".$jsonType."'";
		if($jsonType=='date') {
			$str.=",dateFormat : '".$dateType."'";
		}
		$str.="},";
		
		$str2.=$columnName.",";
				
				if($columnName=='executeBy') {
					$str4.="
						{
						dataIndex : 'executeBy',
						header : executeByLabel,
						sortable : true,
						hidden : false,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return record.data.staffName;
						}
					},
					";
				} else if ($columnName=='executeTime') {
					$str4.="{
						dataIndex : 'executeTime',
						header : executeTimeLabel,
						sortable : true,
						hidden : false,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return Ext.util.Format.date(value, 'd-m-Y H:i:s');
						}
					},";
				} else if ($foreignKey=='yes') { 
					$str4.="
						{
						dataIndex : '".$columnName."',
						header : ".str_replace("Id","",$columnName)."DescLabel,
						sortable : true,
						hidden : false,
						renderer : function(value, metaData, record, rowIndex,
								colIndex, store) {
							return record.data.".str_replace("Id","",$columnName)."Desc;
						}
					},
					";
				
				} else { 
				$str4.="{
					dataIndex : '".$columnName."',
					header : ".$columnName."Label,
					sortable : true,
					hidden : false
				},";	
				}
		if($foreignKey=='no' && ($key=='MUL' || $key=='')) { 
			if($columnName !='isDefault' &&
			   $columnName !='isNew' &&
			   $columnName !='isDraft'&&
			   $columnName !='isUpdate'&&
			   $columnName !='isDelete'&&
			   $columnName !='isActive'&&
			   $columnName !='isApproved'&&
			   $columnName !='isReview'&&
			   $columnName !='isPost'&&
			   $columnName !='executeBy'&&
			   $columnName !='executeTime') {
			   
				if($jsonType=='float') {
					$str3.="var ".$columnName." = new Ext.form.".$formType."Field({
							labelAlign : 'left',
						fieldLabel : ".$columnName."Label + '<span style=\'color: red;\'>*</span>',
						hiddenName : '".$columnName."',
						name : '".$columnName."',
						id : '".$columnName."',
						allowBlank : false,
						blankText : blankTextLabel,
						style : {
							textTransform : 'uppercase'
						},
						anchor : '40%',
						decimalPrecision: 2,
						vtype: 'dollar',
						listeners: {
							blur: function() {
								var value = Ext.getCmp('".$columnName."').getValue();
								value = value.replace(\",\", \"\"); 
								value = value.replace(\" \", \"\"); 					
								Ext.getCmp('".$columnName."').setValue(value);
							}
						}
					}); ";
				
				} else{
			   
					$str3.="var ".$columnName." = new Ext.form.".$formType."Field({
						labelAlign : 'left',
						fieldLabel : ".$columnName."Label + '<span style=\'color: red;\'>*</span>',
						hiddenName : '".$columnName."',
						name : '".$columnName."',
						id : '".$columnName."',
						allowBlank : false,
						blankText : blankTextLabel,
						style : {
							textTransform : 'uppercase'
						},
						anchor : '40%'
					});";
				}	
		}
	
			if($columnName=='executeBy') { 
				$str5.="{
					type : 'list',
					dataIndex : '".$columnName."',
					column : '".$columnName."',
					table : '".$targetTable."',
					database : '".$targetDb."',
					labelField : 'staffName',
					store : staffByStore,
					phpMode : true
				},";
			}  else {
			$str5.="
				{
					type : '".$jsonType."',
					dataIndex : '".$columnName."',
					column : '".$columnName."',
					table : '".$targetTable."',
					database : '".$targetDb."'
				},";
			}
			
			
		
		}  else if ($key=='PRI') {
			
			$str3.="var ".$columnName."  =  new Ext.form.Hidden({
			name : '".$columnName."',
			id : '".$columnName."'
			});";
			
			
			$str5.="
				{
					type : '".$jsonType."',
					dataIndex : '".$columnName."',
					column : '".$columnName."',
					table : '".$targetTable."',
					database : '".$targetDb."'
				},";
		}else {
		// asume foreign key  only used combo box 
				$str3.="var ".$columnName."  = new Ext.ux.form.ComboBoxMatch({
					labelAlign: 'left',
					fieldLabel: ".$columnName."Label,
					name: 'stateId',
					hiddenName: '".$columnName."',
					valueField: '".$columnName."',
					hiddenId: '".$columnName."_fake',
					id: '".$columnName."',
					displayField: '".str_replace("Id","",$columnName)."Desc',
					typeAhead: false,
					triggerAction: 'all',
					store: ".str_replace("Id","",$columnName)."Store,
					anchor: '95%',
					selectOnFocus: true,
					mode: 'local',
					allowBlank: false,
					blankText: blankTextLabel,
					createValueMatcher: function(value) {
						value = String(value).replace(/\s*/g, '');
						if (Ext.isEmpty(value, false)) {
							return new RegExp('^');
						}
						value = Ext.escapeRe(value.split('').join('\\s*')).replace(/\\\\s\\\*/g, '\\s*');
						return new RegExp('\\b(' + value + ')', 'i');
					}
				});";
				
					
				$str5.="
				,{
					type : 'list',
					dataIndex : '".$columnName."',
					column : '".$columnName."',
					table : '".$targetTable."',
					database : '".$targetDb."',
					labelField : '".str_replace("Id","",$columnName)."Desc',
					store : ".str_replace("Id","",$columnName)."Store,
					phpMode : true
				},	
				";
			
					
				
	
		}
	
	}
	
	
	$jsonStoreString="
	// start ".$targetTable." request
	
	var ".$targetTable."Proxy = new Ext.data.HttpProxy({
			url : '../controller/".$targetTable."Controller.php',
			method : 'POST',
			success : function (response, options) {
				jsonResponse = Ext.decode(response.responseText);
				if (jsonResponse.success == true) { 
				
				// Ext.MessageBox.alert(systemLabel,jsonResponse.message);
				
				} else {
					Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
				}
			},
			failure : function (response, options) {
				Ext.MessageBox.alert(systemErrorLabel, escape(response.Status) + ':' + escape(response.statusText));
			}
		});
		
	var ".$targetTable."Reader = new Ext.data.JsonReader({
			totalProperty : 'total',
			successProperty : 'success',
			messageProperty : 'message',
			idProperty : '".$targetTable."Id'
		});
		
	var ".$targetTable."Store = new Ext.data.JsonStore({
			proxy : ".$targetTable."Proxy,
			reader : ".$targetTable."Reader,
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
			id : '".$targetTable."Id',
			fields : [".substr($str,0,-1)."
			]
		});
	
	// end ".$targetTable." request
	";
	
	

	$str5.=substr($str5,0,-1);
	
	
	$str5x.="var generalLedgerChartOfAccountFilters = new Ext.ux.grid.GridFilters(
					{
						encode : false,
						local : false,
						filters : [";
	$str5x.=(substr($str5,0,-1));
	$str5x.="]});";

	$str4.=(substr($str4,0,-1));
	
	$str41.="var ".$targetTable."ColumnModel = [
					new Ext.grid.RowNumberer(),";
	$str41.=(substr($str4,0,-1));
	$str41.="];";				
	

	

	$filterItem=array('isDefault','isNew','isDraft','isUpdate','isDelete','isActive','isApproved','isReview','isPost','executeBy','executeTime'); 
	foreach ($filterItem as $item) {
		$str2= str_replace($item.",",'',$str2);
	}
	$str2.=(substr($str2,0,-1));
	
	
	$insertStatement.="
	\$sql=\"INSERT INTO `".$targetDb."`.`".$targetTable."` ( ";
	foreach($columnNameArray as $columnNameMysql) { 
		$insertStatementAField.="	`".$columnNameMysql."`,";
	}
	$insertStatementField.= (substr($insertStatementAField,0,-1));
	$insertStatement.=$insertStatementField;
	$insertStatement.=") VALUES ( ";
	foreach($columnNameArray as $columnNameMysql) {
		$i++;
		if($i==1){
			$insertStatementInsideValue.="null,";
		}else if ($columnNameMysql=='executeTime'){
			$insertStatementInsideValue.=" \".\$this->model->get".ucFirst($columnNameMysql)."().\",\n";
		}else if($columnNameMysql !='isDefault' &&
			   $columnNameMysql !='isNew' &&
			   $columnNameMysql !='isDraft'&&
			   $columnNameMysql !='isUpdate'&&
			   $columnNameMysql !='isDelete'&&
			   $columnNameMysql !='isActive'&&
			   $columnNameMysql !='isApproved'&&
			   $columnNameMysql !='isReview'&&
			   $columnNameMysql !='isPost'&&
			   $columnNameMysql !='isSeperated'&&
			   $columnNameMysql !='isConsolidation') {	
				$insertStatementInsideValue.=" '\".\$this->model->get".ucFirst($columnNameMysql)."().\"',\n";
		}  else {
			$insertStatementInsideValue.=" '\".\$this->model->get".ucFirst($columnNameMysql)."(0, 'single').\"',\n";
		}
	}
	$insertStatementValue.=(substr($insertStatementInsideValue,0,-2));
	$insertStatement.=$insertStatementValue;
	$insertStatement.=");\";";
	
	$updateStatement="\$sql=\"UPDATE `".$targetDb."`.`".$targetTable."` SET ";
	foreach($columnNameArray as $columnNameMysql) {
		if($columnNameMysql !='isDefault' &&
			   $columnNameMysql !='isNew' &&
			   $columnNameMysql !='isDraft'&&
			   $columnNameMysql !='isUpdate'&&
			   $columnNameMysql !='isDelete'&&
			   $columnNameMysql !='isActive'&&
			   $columnNameMysql !='isApproved'&&
			   $columnNameMysql !='isReview'&&
			   $columnNameMysql !='isPost'&&
			   $columnNameMysql !='isSeperated'&&
			   $columnNameMysql !='isConsolidation') {	
			$updateStatementInsideValue.=" `".$columnNameMysql."` = '\".\$this->model->get".ucFirst($columnNameMysql)."().\"',\n";
		} else {
			$updateStatementInsideValue.=" `".$columnNameMysql."` = '\".\$this->model->get".ucFirst($columnNameMysql)."(0, 'single').\"',\n";
		}
	}
	$updateStatementValue.=(substr($updateStatementInsideValue,0,-2));
	
	$updateStatement.=$updateStatementValue;
	$updateStatement.=" WHERE `".($targetTable)."Id`='\".get".ucfirst($targetTable)."Id('0','single').\"'\";";
	$deleteStatement = "
	\$sql=\"  	UPDATE 	`".$targetDb."`.`".$targetTable."`
				SET 	`isDefault`				=	'\" . \$this->model->getIsDefault(0, 'single') . \"',
						`isNew`					=	'\" . \$this->model->getIsNew(0, 'single') . \"',
						`isDraft`				=	'\" . \$this->model->getIsDraft(0, 'single') . \"',
						`isUpdate`				=	'\" . \$this->model->getIsUpdate(0, 'single') . \"',
						`isDelete`				=	'\" . \$this->model->getIsDelete(0, 'single') . \"',
						`isActive`				=	'\" . \$this->model->getIsActive(0, 'single') . \"',
						`isApproved`			=	'\" . \$this->model->getIsApproved(0, 'single') . \"',
						`isReview`				=	'\" . \$this->model->getIsReview(0, 'single') . \"',
						`isPost`				=	'\" . \$this->model->getIsPost(0, 'single') . \"',
						`executeBy`				=	'\" . \$this->model->getExecuteBy() . \"',
						`executeTime`			=	\" . \$this->model->getExecuteTime() . \"
				WHERE 	`".$targetTable."Id`	=  '\" . \$this->model->getGeneralLedgerChartOfAccountId(0, 'single') . \"'\";";
	
	$readStatement.="\$sql = \"SELECT";
			foreach($columnNameArray as $columnNameMysql) {
				$readInsideStatement.="`".$targetTable."`.`".$columnNameMysql."`,";
			}	
			$readStatement.=(substr($readInsideStatement,0,-1));		
			$readStatement.="
					,`iManagement`.`staff`.`staffName`
			FROM 	`".$targetDb."`.`".$targetTable."`
			JOIN	`".$managementDb."`.`staff`
			ON		`".$targetTable."`.`executeBy` = `staff`.`staffId`
			WHERE 	;";
			
			$gridPanel.=
			"var ".$targetTable."FlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
	var ".$targetTable."Grid = new Ext.grid.GridPanel({
			name : '".$targetTable."Grid',
			id : '".$targetTable."Grid',
			border : false,
			store : ".$targetTable."Store,
			autoHeight : false,
			height : 400,
			columns : ".$targetTable."ColumnModel,
			plugins : [".$targetTable."Filters],
			selModel : new Ext.grid.RowSelectionModel({
				singleSelect : true
			}),
			viewConfig : {
				emptyText : emptyRowLabel
			},
			iconCls : 'application_view_detail',
			listeners : {
				'rowclick' : function (object, rowIndex, e) {
					var record = ".$targetTable."Store.getAt(rowIndex);
					formPanel.getForm().reset();
					formPanel.form.load({
						url : '../controller/".$targetTable."Controller.php',
						method : 'POST',
						waitTitle : systemLabel,
						waitMsg : waitMessageLabel,
						params : {
							method : 'read',
							mode : 'update',
							".$targetTable."Id : record.data.".$targetTable."Id,
							leafId : leafId,
							isAdmin : isAdmin
						},
						success : function (form, action) {
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
					xtype:'button',
					text: ' ',
					tooltip:excelToolbarLabel,
					iconCls : 'page_excel',
					id : 'page_excel',
					
					handler : function () {
						Ext.Ajax.request({
							url : '../controller/".$targetTable."Controller.php',
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
									window.open('../document/excel/' + jsonResponse.filename);
								} else {
									Ext.MessageBox.alert(successLabel, jsonResponse.message);
								}
							},
							failure : function (response, options) {
								Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
							}
						});
					}
				},'-',{
					xtype:'button',
					text : '',
					tooltip:addToolbarLabel,
					iconCls : 'add',
					id : 'pageCreate',
					
					handler : function (button,e) {
						viewPort.items.get(1).expand();
					}},'-',{
						xtype:'button',
						text:' ',
						tooltip:CheckAllLabel,
						iconCls : 'row-check-sprite-check',
						listeners : {
							'click' : function (button, e) {
								".$targetTable."Store.each(function (record, fn, scope) {
									for (var access in ".$targetTable."FlagArray) {
										record.set(".$targetTable."FlagArray[access], true);
									}
								});
							}
						}
					}, '-',{
						text:' ',
						tooltip:ClearAllLabel,
						xtype : 'button',
						iconCls : 'row-check-sprite-uncheck',
						listeners : {
							'click' : function (button, e) {
								".$targetTable."Store.each(function (record, fn, scope) {
									for (var access in ".$targetTable."FlagArray) {
										record.set(".$targetTable."FlagArray[access], false);
									}
								});
							}
						}
					},'-', {
						xtype : 'button',
						tooltip : saveButtonLabel,
						iconCls : 'bullet_disk',
						listeners : {
							'click' : function (button, e) {
								var url = '../controller/".$targetTable."Controller.php?';
								var sub_url = '';
								var modified = ".$targetTable."Store.getModifiedRecords();
								for (var i = 0; i < modified.length; i++) {
									var dataChanges = modified[i].getChanges();
									sub_url = sub_url + '&".$targetTable."Id[]=' + modified[i].get('".$targetTable."Id');
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
											businessPartnerStore.reload();
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
					},'-',";
					if($targetFilter=='character'){
					$a = range('A','Z');
					//$a = range(1,12);
					foreach($a as $z) {
						$gridFilter.="{ xtype:'button', text:'".$z."', handler: function (button,e) { 
						
								".$targetTable."Store
													.reload({
														params : {
															leafId : leafId,
															start : 0,
															limit : perPage,
															character : '".$z."'
														}
													});
							
							} 
						},'-',";
					}
				}
						

				$gridFilter.="'->', new Ext.ux.form.SearchField({
					store : ".$targetTable."Store,
					width : 200
				})]
			},
			bbar : new Ext.PagingToolbar({
				store : ".$targetTable."Store,
				pageSize : perPage,
				plugins : [".$targetTable."Filters]
			})
		});
	var gridPanel = new Ext.Panel({
			title : leafNative,
			iconCls : 'application_view_detail',
			layout : 'fit',		
			items : [".$targetTable."Grid]
		});";
		
		$formPanel.="var formPanel = new Ext.form.FormPanel({
			url : '../controller/".$targetTable."Controller.php',
			name : 'formPanel',
			id : 'formPanel',
			method : 'post',
			frame : true,
			title : leafNative,
			border : false,
			bodyStyle : 'padding:5px',
			width : 600,
			items : [{
					xtype : 'fieldset',
					title : 'Form Entry',
					items : [".$str2."]
				}
			],
			buttonVAlign : 'top',
			buttonAlign : 'left',
			iconCls : 'application_form',
			bbar : new Ext.ux.StatusBar({
				id : 'form-statusbar',
				defaultText : defaultTextLabel,
				plugins : new Ext.ux.ValidationStatus({
					form : 'formPanel'
				})
			}),
			buttons : [{
					text : auditButtonLabel,
					name : 'auditButtonLabel',
					id : 'auditButtonLabel',
					type : 'button',
					iconCls : 'key',
					disabled : auditButtonLabelDisabled,
					handler : function () {
						if (auditWindow) {
							".$targetTable."Store.reload();
							auditWindow.show().center();
						}
					}
				}, {
					text : newButtonLabel,
					name : 'newButton',
					id : 'newButton',
					type : 'button',
					iconCls : 'new',
					handler : function () {
						var id = Ext.getCmp('".$targetTableId."').getValue();
						var method = 'create';
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
									Ext.getCmp('newButton').disable();
									Ext.getCmp('saveButton').enable();
									Ext.getCmp('deleteButton').enable();
									".$targetTable."Store.reload({
										params : {
											leafId : leafId,
											start : 0,
											limit : perPage
										}
									});
									Ext.getCmp('".$targetTableId."').setValue(action.result.$targetTableId);
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
					name : 'saveButton',
					id : 'saveButton',
					iconCls : 'bullet_disk',
					disabled : true,
					handler : function () {
						Ext.getCmp('newButton').disable();
						var id = Ext.getCmp('".$targetTableId."').getValue();
						var method = 'save';
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
									Ext.getCmp('newButton').disable();
									Ext.getCmp('saveButton').enable();
									Ext.getCmp('deleteButton').enable();
									".$targetTable."Store.reload({
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
					type : 'button',
					name : 'deleteButton',
					id : 'deleteButton',
					iconCls : 'trash',
					disabled : true,
					handler : function () {
						Ext.getCmp('newButton').disable();
						Ext.Msg.show({
							title : deleteRecordTitleMessageLabel,
							msg : deleteRecordMessageLabel,
							icon : Ext.Msg.QUESTION,
							buttons : Ext.Msg.YESNO,
							scope : this,
							fn : function (response) {
								if ('yes' == response) {
									Ext.Ajax.request({
										url : '../controller/".$targetTable."Controller.php',
										params : {
											method : 'delete',
											$targetTableId : Ext.getCmp('".$targetTableId."').getValue(),
											leafId : leafId,
											isAdmin : isAdmin
										},
										success : function (response, options) {
											jsonResponse = Ext.decode(response.responseText);
											if (jsonResponse.success == true) {
												Ext.MessageBox.alert(systemLabel, jsonResponse.message);
												".$targetTable."Store.reload({
													params : {
														leafId : leafId,
														start : 0,
														limit : perPage
													}
												});
												Ext.getCmp('saveButton').disable();
												Ext.getCmp('deleteButton').disable();
												Ext.getCmp('nextButton').disable();
												Ext.getCmp('previousButton').disable();
											} else {
												Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
											}
										},
										failure : function (response, options) {
											Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + response.statusText);
										}
									});
								}
							}
						});
					}
				}, {
					text : resetButtonLabel,
					type : 'reset',
					name : 'resetButton',
					id : 'resetButton',
					iconCls : 'database_refresh',
					handler : function () {
						Ext.getCmp('newButton').enable();
						Ext.getCmp('saveButton').disable();
						Ext.getCmp('deleteButton').disable();
						Ext.getCmp('postButton').disable();
						formPanel.getForm().reset();
					}
				}, {
					text : postButtonLabel,
					type : 'button',
					name : 'postButton',
					id : 'postButton',
					iconCls : 'lock',
					disabled : true,
					handler : function () {
						Ext.getCmp('newButton').disable();
						formPanel.getForm().reset();
					}
				}, {
					text : gridButtonLabel,
					type : 'button',
					name : 'gridButton',
					id : 'gridButton',
					iconCls : 'table',
					handler : function () {
						formPanel.getForm().reset();
						viewPort.items.get(0).expand();
					}
				}, {
					text : firstButtonLabel,
					name : 'firstButton',
					id : 'firstButton',
					type : 'button',
					iconCls : 'resultset_first',
					handler : function () {
						Ext.getCmp('newButton').disable();
						if (Ext.getCmp('firstRecord').getValue() == '') {
							Ext.Ajax.request({
								url : '../controller/".$targetTable."Controller.php',
								method : 'GET',
								params : {
									method : 'dataNavigationRequest',
									leafId : leafId,
									dataNavigation : 'firstRecord'
								},
								success : function (response, options) {
									jsonResponse = Ext.decode(response.responseText);
									if (jsonResponse.success == true) {
										Ext.getCmp('firstRecord').setValue(jsonResponse.firstRecord);
										formPanel.form.load({
											url : '../controller/".$targetTable."Controller.php',
											method : 'POST',
											waitTitle : systemLabel,
											waitMsg : waitMessageLabel,
											params : {
												method : 'read',
												$targetTableId : Ext.getCmp('firstRecord').getValue(),
												leafId : leafId,
												isAdmin : isAdmin
											},
											success : function (form, action) {
												if (action.result.success == true) {
													if (action.result.nextRecord == 0) {
														Ext.getCmp('nextButton').disable();
													} else {
														Ext.getCmp('nextButton').enable();
													}
													Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
													Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
													Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
													Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
													Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
													Ext.getCmp('previousButton').disable();
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
									Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
								}
							});
						} else {
							formPanel.form.load({
								url : '../controller/".$targetTable."Controller.php',
								method : 'POST',
								waitTitle : systemLabel,
								waitMsg : waitMessageLabel,
								params : {
									method : 'read',
									$targetTableId : Ext.getCmp('firstRecord').getValue(),
									leafId : leafId,
									isAdmin : isAdmin
								},
								success : function (form, action) {
									if (action.result.success == true) {
										if (action.result.nextRecord == 0) {
											Ext.getCmp('nextButton').disable();
										} else {
											Ext.getCmp('nextButton').enable();
										}
										Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
										Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
										Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
										Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
										Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
										Ext.getCmp('previousButton').disable();
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
					name : 'previousButton',
					id : 'previousButton',
					type : 'button',
					iconCls : 'resultset_previous',
					disabled : true,
					handler : function () {
						Ext.getCmp('newButton').disable();
						if (Ext.getCmp('previousRecord').getValue() == '' || Ext.getCmp('previousRecord').getValue() == undefined) {
							Ext.MessageBox.alert(systemErrorLabel, chooseRecordLabel);
						}
						if (Ext.getCmp('firstRecord').getValue() >= 1) {
							formPanel.form.load({
								url : '../controller/".$targetTable."Controller.php',
								method : 'POST',
								waitTitle : systemLabel,
								waitMsg : waitMessageLabel,
								params : {
									method : 'read',
									$targetTableId : Ext.getCmp('previousRecord').getValue(),
									leafId : leafId,
									isAdmin : isAdmin
								},
								success : function (form, action) {
									if (action.result.success == true) {
										Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
										Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
										Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
										Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
										Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
										if (Ext.getCmp('previousRecord').getValue() == 0) {
											Ext.getCmp('previousButton').disable();
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
					name : 'nextButton',
					id : 'nextButton',
					type : 'button',
					disabled : true,
					iconCls : 'resultset_next',
					handler : function () {
						Ext.getCmp('newButton').disable();
						if (Ext.getCmp('nextRecord').getValue() == '' || Ext.getCmp('nextRecord').getValue() == undefined) {
							Ext.MessageBox.alert(systemErrorLabel, chooseRecordLabel);
						}
						if (Ext.getCmp('nextRecord').getValue() <= Ext.getCmp('lastRecord').getValue()) {
							formPanel.form.load({
								url : '../controller/".$targetTable."Controller.php',
								method : 'POST',
								waitTitle : systemLabel,
								waitMsg : waitMessageLabel,
								params : {
									method : 'read',
									$targetTableId : Ext.getCmp('nextRecord').getValue(),
									leafId : leafId,
									isAdmin : isAdmin
								},
								success : function (form, action) {
									if (action.result.success == true) {
										Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
										Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
										Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
										Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
										Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
										if (Ext.getCmp('nextRecord').getValue() > Ext.getCmp('lastRecord').getValue()) {
											Ext.getCmp('nextButton').disable();
										}
										if (Ext.getCmp('nextRecord').getValue() == 0) {
											Ext.getCmp('nextButton').disable();
										}
										Ext.getCmp('previousButton').enable();
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
					name : 'endButton',
					id : 'endButton',
					type : 'button',
					iconCls : 'resultset_last',
					handler : function () {
						Ext.getCmp('newButton').disable();
						if (Ext.getCmp('lastRecord').getValue() == '' || Ext.getCmp('lastRecord').getValue() == undefined) {
							Ext.Ajax.request({
								url : '../controller/".$targetTable."Controller.php',
								method : 'GET',
								params : {
									method : 'dataNavigationRequest',
									leafId : leafId,
									dataNavigation : 'lastRecord'
								},
								success : function (response, options) {
									jsonResponse = Ext.decode(response.responseText);
									if (jsonResponse.success == true) {
										Ext.getCmp('lastRecord').setValue(jsonResponse.lastRecord);
										formPanel.form.load({
											url : '../controller/".$targetTable."Controller.php',
											method : 'POST',
											waitTitle : systemLabel,
											waitMsg : waitMessageLabel,
											params : {
												method : 'read',
												$targetTableId : Ext.getCmp('lastRecord').getValue(),
												leafId : leafId,
												isAdmin : isAdmin
											},
											success : function (form, action) {
												if (action.result.success == true) {
													if (action.result.previousRecord == 0) {
														Ext.getCmp('previousButton').disable();
													} else {
														Ext.getCmp('previousButton').enable();
													}
													Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
													Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
													Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
													Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
													Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
													Ext.getCmp('nextButton').disable();
													Ext.getCmp('previousButton').enable();
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
									Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
								}
							});
						}
						if (Ext.getCmp('".$targetTableId."').getValue() <= Ext.getCmp('lastRecord').getValue()) {
							formPanel.form.load({
								url : '../controller/".$targetTable."Controller.php',
								method : 'POST',
								waitTitle : systemLabel,
								waitMsg : waitMessageLabel,
								params : {
									method : 'read',
									$targetTableId : Ext.getCmp('lastRecord').getValue(),
									leafId : leafId,
									isAdmin : isAdmin
								},
								success : function (form, action) {
									if (action.result.success == true) {
										if (action.result.previousRecord == 0) {
											Ext.getCmp('previousButton').disable();
										} else {
											Ext.getCmp('previousButton').enable();
										}
										Ext.getCmp('firstRecord').setValue(action.result.firstRecord);
										Ext.getCmp('previousRecord').setValue(action.result.previousRecord);
										Ext.getCmp('nextRecord').setValue(action.result.nextRecord);
										Ext.getCmp('lastRecord').setValue(action.result.lastRecord);
										Ext.getCmp('endRecord').setValue((action.result.lastRecord + 1));
										Ext.getCmp('nextButton').disable();
										Ext.getCmp('previousButton').enable();
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
		});";
		
		$systemValidation.="
			// start System Validation
	var isDefault = new Ext.form.Checkbox({
			name : 'isDefault',
			id : 'isDefault',
			fieldLabel : isDefaultLabel,
			hidden : isDefaultHidden
		});
	var isNew = new Ext.form.Checkbox({
			name : 'isNew',
			id : 'isNew',
			fieldLabel : isNewLabel,
			hidden : isNewHidden
		});
	var isDraft = new Ext.form.Checkbox({
			name : 'isDraft',
			id : 'isDraft',
			fieldLabel : isDraftLabel,
			hidden : isDraftHidden
		});
	var isUpdate = new Ext.form.Checkbox({
			name : 'isUpdate',
			id : 'isUpdate',
			fieldLabel : isUpdateLabel,
			hidden : isUpdateHidden
		});
	var isDelete = new Ext.form.Checkbox({
			name : 'isDelete',
			id : 'isDelete',
			fieldLabel : isDeleteLabel,
			hidden : isDeleteHidden
		});
	var isActive = new Ext.form.Checkbox({
			name : 'isActive',
			id : 'isActive',
			fieldLabel : isActiveLabel,
			hidden : isActiveHidden
		});
	var isApproved = new Ext.form.Checkbox({
			name : 'isApproved',
			id : 'isApproved',
			fieldLabel : isApprovedLabel,
			hidden : isApprovedHidden
		});
	var isReview = new Ext.form.Checkbox({
			name : 'isReview',
			id : 'isReview',
			fieldLabel : isReviewLabel,
			hidden : isReviewHidden
		});
	var isPost = new Ext.form.Checkbox({
			name : 'isPost',
			id : 'isPost',
			fieldLabel : isPostLabel,
			hidden : isPostHidden
		}); // hidden value for navigation button
	var firstRecord = new Ext.form.Hidden({
			name : 'firstRecord',
			id : 'firstRecord',
			value : ''
		});
	var nextRecord = new Ext.form.Hidden({
			name : 'nextRecord',
			id : 'nextRecord',
			value : ''
		});
	var previousRecord = new Ext.form.Hidden({
			name : 'previousRecord',
			id : 'previousRecord',
			value : ''
		});
	var lastRecord = new Ext.form.Hidden({
			name : 'lastRecord',
			id : 'lastRecord',
			value : ''
		});
	var endRecord = new Ext.form.Hidden({
			name : 'endRecord',
			id : 'endRecord',
			value : ''
		}); // end of hidden value for navigation button
	// end System Validation
		";
		
	$firstCodeJs.="
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
			url : '../controller/".$targetTable."Controller.php?',
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
			autoLoad : false,
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
			autoLoad : false,
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
	// start additional Proxy ,Reader,Store,Filter,Grid
	";	
	
	$lastCodejs.="var viewPort = new Ext.Viewport({
			id : 'viewport',
			region : 'center',
			layout : 'accordion',
			layoutConfig : {
				titleCollapse : true,
				animate : false,
				activeOnTop : true
			},
			items : [gridPanel, formPanel]
		});
});";
?>
		
		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Hello SyntaxHighlighter</title>
	<script type="text/javascript" src="scripts/shCore.js"></script>
	<script type="text/javascript" src="scripts/shBrushJScript.js"></script>
	<script type="text/javascript" src="scripts/shBrushPhp.js"></script>
	<link type="text/css" rel="stylesheet" href="styles/shCoreDefault.css"/>
	<script type="text/javascript">SyntaxHighlighter.all();</script>
</head>

<body style="background: white; font-family: Helvetica">
<?php if($_GET['type']=='javascript') { ?>	
<?php if($_GET['mode']=='copy') { ?>
<h1>Copy To Json Store</h1>
<pre class="brush: js;">
<?php echo (substr($str,0,-1)); ?>
</pre>
<h1>Copy To GridFilter</h1>
<pre class="brush: js;">
<?php echo $str5; ?>
</pre>
<h1>Copy To ColumnModel</h1>
<pre class="brush: js;">
<?php echo $str4; ?>
</pre>
<h1>Copy To Form Item</h1>
<pre class="brush: js;">
<?php echo $str2; ?>
</pre>
<?php } ?>
<h1>Request,Reader,JsonStore</h1>
<pre class="brush: js;">
<?php echo $jsonStoreString; ?>
</pre>

<h1>GridFilter</h1>
<pre class="brush: js;">
<?php echo $str5x; ?>
</pre>

<h1>ColumnModel</h1>
<pre class="brush: js;">
<?php echo $str41; ?>
</pre>
<h1>GridPanel</h1>
<pre class="brush: js;">
<?php echo $gridPanel; ?>
</pre>
<h1>Copy To Form Item</h1>
<pre class="brush: js;">
<?php echo $str3; ?>
</pre>
<h1>System Validation</h1>
<pre class="brush: js;">
<?php echo $systemValidation; ?>
</pre>
<h1>Form Panel</h1>
<pre class="brush: js;">
<?php echo $formPanel; ?>
</pre>
<?php } ?>
<?php if($_GET['type']=='fulljs') { ?>
<h1>Full Javascript</h1>
<pre class="brush: js;">
<?php //echo $firstCodeJs.$jsonCodeString.$str5x.$str41.$gridPanel.$str3.$systemValidation.$formPanel.$lastCodeJs; ?>
</pre>
<pre>
<?php //echo $firstCodeJs.$jsonCodeString.$str5x.$str41.$gridPanel.$str3.$systemValidation.$formPanel.$lastCodeJs; ?>
</pre>
<?php echo $firstCodeJs.$jsonCodeString.$str5x.$str41.$gridPanel.$str3.$systemValidation.$formPanel.$lastCodeJs; ?>

<?php } ?>
<?php if ($_GET['type']=='controller') { ?>
<h1>Create Statement</h1>
<pre class="brush: php;">
<?php echo $insertStatement; ?>
</pre>
<h1>Read Statement</h1>
<pre class="brush: php;">
<?php echo $readStatement; ?>
</pre>
<h1>Update Statement</h1>
<pre class="brush: php;">
<?php echo $updateStatement; ?>
</pre>
<h1>Delete Statement</h1>
<pre class="brush: php;">
<?php echo $deleteStatement; ?>
</pre>
<h1>Update Status Statement</h1>
<pre class="brush: php;">
<?php //echo $deleteStatement; ?>
</pre>
<?php } ?>
</html>
