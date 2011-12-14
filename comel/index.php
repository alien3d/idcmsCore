<?php 
	//include("controller.php");// file
    $targetFolder='iFinancial';
	$targetDatabase='mysql';
	$targetDb="ifinancial";
	$targetTable ='country';
	$targetTableId = $targetTable."Id";
	$targetMasterTable='generalLedgerJournalId'; // parent primary key
	$targetGridType="second"; // first -normal table ,second -edit in grid table
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
		
		// kita start isi model kat sini standard  create read update delete lallalala
		$crud="/* (non-PHPdoc)
	 * @see ValidationClass::create()
	 */

	public function create() {
		\$this->setIsDefault(0, 0, 'single');
		\$this->setIsNew(1, 0, 'single');
		\$this->setIsDraft(0, 0, 'single');
		\$this->setIsUpdate(0, 0, 'single');
		\$this->setIsActive(1, 0, 'single');
		\$this->setIsDelete(0, 0, 'single');
		\$this->setIsApproved(0, 0, 'single');
		\$this->setIsReview(0, 0, 'single');
		\$this->setIsPost(0, 0, 'single');
	}

	/* (non-PHPdoc)
	 * @see ValidationClass::update()
	 */

	public function update() {
		\$this->setIsDefault(0, 0, 'single');
		\$this->setIsNew(0, 0, 'single');
		\$this->setIsDraft(0, 0, 'single');
		\$this->setIsUpdate(1, '', 'single');
		\$this->setIsActive(1, 0, 'single');
		\$this->setIsDelete(0, 0, 'single');
		\$this->setIsApproved(0, 0, 'single');
		\$this->setIsReview(0, 0, 'single');
		\$this->setIsPost(0, 0, 'single');
	}

	/* (non-PHPdoc)
	 * @see ValidationClass::delete()
	 */

	public function delete() {
		\$this->setIsDefault(0, 0, 'single');
		\$this->setIsNew(0, 0, 'single');
		\$this->setIsDraft(0, 0, 'single');
		\$this->setIsUpdate(0, 0, 'single');
		\$this->setIsActive(0, '', 'single');
		\$this->setIsDelete(1, '', 'single');
		\$this->setIsApproved(0, 0, 'single');
		\$this->setIsReview(0, 0, 'single');
		\$this->setIsPost(0, 0, 'single');
	}

	/* (non-PHPdoc)
	 * @see ValidationClass::draft()
	 */

	public function draft() {
		\$this->setIsDefault(0, 0, 'single');
		\$this->setIsNew(1, 0, 'single');
		\$this->setIsDraft(1, 0, 'single');
		\$this->setIsUpdate(0, 0, 'single');
		\$this->setIsActive(0, 0, 'single');
		\$this->setIsDelete(0, 0, 'single');
		\$this->setIsApproved(0, 0, 'single');
		\$this->setIsReview(0, 0, 'single');
		\$this->setIsPost(0, 0, 'single');
	}

	/* (non-PHPdoc)
	 * @see ValidationClass::approved()
	 */

	public function approved() {
		\$this->setIsDefault(0, 0, 'single');
		\$this->setIsNew(1, 0, 'single');
		\$this->setIsDraft(0, 0, 'single');
		\$this->setIsUpdate(0, 0, 'single');
		\$this->setIsActive(0, 0, 'single');
		\$this->setIsDelete(0, 0, 'single');
		\$this->setIsApproved(1, 0, 'single');
		\$this->setIsReview(0, 0, 'single');
		\$this->setIsPost(0, 0, 'single');
	}

	/* (non-PHPdoc)
	 * @see ValidationClass::review()
	 */

	public function review() {
		\$this->setIsDefault(0, 0, 'single');
		\$this->setIsNew(1, 0, 'single');
		\$this->setIsDraft(0, 0, 'single');
		\$this->setIsUpdate(0, 0, 'single');
		\$this->setIsActive(0, 0, 'single');
		\$this->setIsDelete(0, 0, 'single');
		\$this->setIsApproved(0, 0, 'single');
		\$this->setIsReview(1, 0, 'single');
		\$this->setIsPost(0, 0, 'single');
	}

	/* (non-PHPdoc)
	 * @see ValidationClass::post()
	 */

	public function post() {
		\$this->setIsDefault(0, 0, 'single');
		\$this->setIsNew(1, 0, 'single');
		\$this->setIsDraft(0, 0, 'single');
		\$this->setIsUpdate(0, 0, 'single');
		\$this->setIsActive(0, 0, 'single');
		\$this->setIsDelete(0, 0, 'single');
		\$this->setIsApproved(1, 0, 'single');
		\$this->setIsReview(0, 0, 'single');
		\$this->setIsPost(1, 0, 'single');
	}";
		// end disini..
		
		
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
		$mainModelInside.="
		\n
		/**
		* @var ".$jsonType."
		*/
		private ".$columnName." ";
		}
				
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
					if($targetGridType=='first') {
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
							if($columnName !=$targetMasterTable){
							$str4.="{
								dataIndex : '".$columnName."',
							header : ".str_replace("Id","",$columnName)."DescLabel,
								width : 200,
								sortable : true,
								editor : ".$columnName.",
								renderer : Ext.util.Format.comboRenderer(".$columnName."),
								hidden : false,
								jsonType:'".$jsonType."'
							},";
						    }
					}
				
				} else if($jsonType=='float'){
								$str4.="{
									dataIndex : '".$columnName."',
									header : ".$columnName."Label,
									width : 75,
									sortable : true,
									summaryType : 'sum',
									renderer : function(value) {
										return ' RM ' + Ext.util.Format.number(value, '0,0.00');
									},
									editor : {
										xtype : 'textfield',
										labelAlign : 'left',
										fieldLabel : ".$columnName."Label,
										hiddenName : '".$columnName."',
										name : '".$columnName."',
										id : '".$columnName."',

										blankText : blankTextLabel,
										decimalPrecision : 2,
										vtype : 'dollar',
										anchor : '95%',
										listeners : {
											blur : function() {
												var value = Ext.getCmp('".$columnName."').getValue();
												value = value.replace(\",\", \"\"); 
												value = Ext.util.Format.usMoney(value);
												value = value.replace(\" \", \"\"); 
												Ext.getCmp('".$columnName."').setValue(value);
											}
										}
									}
								},";
						} else if ($jsonType=='boolean') { 
							if($targetTableType=='first') {
								$str4.=$columnName.","; // checkbox is outside
							} else {
								$str4.=$columnName."GridDetail,"; // checkbox is outside
							}
						}else { 
								if($columnName != $targetTableId) { 
								$str4.="{
									dataIndex : '".$columnName."',
									header : ".$columnName."Label,
									sortable : true,
									hidden : false
								},";
								}								
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
					$executeDalam.="if (isset(\$_POST ['".$columnName."'])) {
						\$this->set".ucfirst($columnName)."Id(\$this->strict(\$_POST ['".$columnName."'], '".$jsonType."'));
					}\n";
					$formItem.="var ".$columnName." = new Ext.form.".$formType."Field({
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
					
					$formItem.="var ".$columnName." = new Ext.form.".$formType."Field({
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
			$executeDalam.="if (isset(\$_POST ['".$columnName."'])) {
				\$this->set".ucfirst($columnName)."(\$this->strict(\$_POST ['".$columnName."'], 'numeric'), 0, 'single');
			}\n";
			
			$formItem.="var ".$columnName."  =  new Ext.form.Hidden({
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
				
			$model ="/**
	 * Set ".$targetTable." Identification  Value
	 * @param int|array \$value
	 * @param array[int]int \$key List Of Primary Key.
	 * @param array[int]string \$type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function set".ucfirst($columnName)." (\$value, \$key, \$type) {
		if (\$type == 'single') {
			\$this->".ucfirst($columnName)." = \$value;
		} else if (\$type == 'array') {
			\$this->".ucfirst($columnName)." [\$key] = \$value;
		} else {
			echo json_encode(array(\"success\" => false, \"message\" => \"Cannot Identifiy Type String Or Array:set".ucfirst($columnName)." ?\"));
			exit();
		}
	}

	/**
	 * Return ".$targetTable." Identification  Value
	 * @param array[int]int \$key List Of Primary Key.
	 * @param array[int]string \$type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function get".ucfirst($columnName)."(\$key, \$type) {
		if (\$type == 'single') {
			return \$this->".ucfirst($columnName).";
		} else if (\$type == 'array') {
			return \$this->".ucfirst($columnName)." [\$key];
		} else {
			echo json_encode(array(\"success\" => false, \"message\" => \"Cannot Identifiy Type String Or Array:get".ucfirst($columnName)." ?\"));
			exit();
		}
	}";

	
		}else {
			$executeDalam.="if (isset(\$_POST ['".$columnName."'])) {
						\$this->set".ucfirst($columnName)."(\$this->strict(\$_POST ['".$columnName."'], '".$jsonType."'));
					}\n";
		// asume foreign key  only used combo box 
				if($columnName !=$targetMasterTable && $targetGridType!='first'){
					$formItem.="var ".$columnName."  = new Ext.ux.form.ComboBoxMatch({
					
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
				}
				if($targetGridType=='first'){
					$formItem.="var ".$columnName."  = new Ext.ux.form.ComboBoxMatch({
						$targetGridType
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
				}
					
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
	
	
	$gridFilterJs.="var generalLedgerChartOfAccountFilters = new Ext.ux.grid.GridFilters(
					{
						encode : false,
						local : false,
						filters : [";
	$gridFilterJs.=$str5;
	$gridFilterJs.="]});";

	$str4=(substr($str4,0,-1));
	
	$columnModelJs.="var ".$targetTable."ColumnModel = [
					new Ext.grid.RowNumberer(),";
	$columnModelJs.=$str4;
	$columnModelJs.="];";				
	

	

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
			if($targetGridType=='first') { 
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
						$gridPanel.="{ xtype:'button', text:'".$z."', handler: function (button,e) { 
						
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
						

				$gridPanel.="'->', new Ext.ux.form.SearchField({
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
		} else {
		
			$gridPanel.="var ".$targetTable."FlagArray = ['isDefault', 'isNew', 'isDraft', 'isUpdate', 'isDelete', 'isActive', 'isApproved', 'isReview', 'isPost'];
    var ".$targetTable."Grid = new Ext.grid.GridPanel({
        name: '".$targetTable."Grid',
        id: '".$targetTable."Grid',
        border: false,
        store: ".$targetTable."Store,
        height: 250,
        autoScroll: true,
        columns: ".$targetTable."ColumnModel,
        viewConfig: {
            autoFill: true,
            forceFit: true,
			emptyRow : emptyRowLabel
        },
        layout: 'fit',
        disabled: true,
        plugins: [".$targetTable."Editor],
        tbar: {
            items: [{
                xtype: 'button',
                iconCls: 'add',
                id: 'add_record',
                name: 'add_record',
                text: newButtonLabel,
                handler: function () {";
                    $gridPanel.="var newRecord = new ".$targetTable."Entity({";
                        foreach($columnNameArray as $columnNameMysql) {
		
			$gridPanelInsideValue.="  ".$columnNameMysql.": '', \n";
		
	}
	$gridPanel.=substr($gridPanelInsideValue,0,-1);
                      
					$gridPanel.="});
                    ".$targetTable."Editor.stopEditing();
                    ".$targetTable."Store.insert(0, newRecord);
                    ".$targetTable."Grid.getSelectionModel().getSelections();
                    ".$targetTable."Editor.startEditing(0);
                }
            }, {
                xtype: 'button',
                text: CheckAllLabel,
                iconCls: 'row-check-sprite-check',
                listeners: {
                    'click': function (button, e) {
                        ".$targetTable."Store.each(function (record,fn,scope) {
                            for (var access in ".$targetTable."FlagArray) {
                                record.set(".$targetTable."FlagArray[access], true);
                            }
                        });
                    }
                }
            }, {
                text: ClearAllLabel,
                iconCls: 'row-check-sprite-uncheck',
                listeners: {
                    'click': function (button, e) {
                        ".$targetTable."Store.each(function (record,fn,scope) {
                            for (var access in ".$targetTable."FlagArray) {
                                record.set(".$targetTable."FlagArray[access], false);
                            }
                        });
                    }
                }
            }, {
                xtype: 'button',
                text: saveButtonLabel,
                iconCls: 'bullet_disk',
                listeners: {
                    'click': function (button, e) {
                        var url = '../controller/".$targetTable."Controller.php?';
                        var sub_url = '';
                        var modified = ".$targetTable."Store.getModifiedRecords();
                        for (var i = 0; i < modified.length; i++) {
                            var dataChanges = modified[i].getChanges();
                            sub_url = sub_url + '&".$targetTable."Id[]=' + modified[i].get('".$targetTable."Id');
                            if (isAdmin == 1) {
                                if (dataChanges.isDefault == true || dataChanges.isDefault == false) {
                                    sub_url = sub_url + '&isDefault[]=' +modified[i].get('isDefault');
                                }
                                if (dataChanges.isDraft == true || dataChanges.isDraft == false) {
                                    sub_url = sub_url + '&isDraft[]=' +modified[i].get('isDraft');
                                }
                                if (dataChanges.isNew == true || dataChanges.isNew == false) {
                                    sub_url = sub_url + '&isNew[]=' +modified[i].get('isNew');
                                }
                                if (dataChanges.isUpdate == true || dataChanges.isUpdate == false) {
                                    sub_url = sub_url + '&isUpdate[]=' +modified[i].get('isUpdate');
                                }
                            }
                            if (dataChanges.isDelete == true || dataChanges.isDelete == false) {
                                sub_url = sub_url + '&isDelete[]=' +modified[i].get('isDelete');
                            }
                            if (isAdmin == 1) {
                                if (dataChanges.isActive == true || dataChanges.isActive == false) {
                                    ssub_url = sub_url + '&isActive[]=' +modified[i].get('isActive');
                                }
                                if (dataChanges.isApproved == true || dataChanges.isApproved == false) {
                                    sub_url = sub_url + '&isApproved[]=' +modified[i].get('isApproved');
                                }
                                if (dataChanges.isReview == true || dataChanges.isReview == false) {
                                    sub_url = sub_url + '&isReview[]=' +modified[i].get('isReview');
                                }
                                if (dataChanges.isPost == true || dataChanges.isPost == false) {
                                    sub_url = sub_url + '&isPost[]=' +modified[i].get('isPost');
                                }
                            }
                        }
                        url = url + sub_url;
                        Ext.Ajax.request({
                            url: url,
                            method: 'GET',
                            params: {
                                leafId: leafId,
                                isAdmin: isAdmin,
                                method: 'updateStatus'
                            },
                            success: function (response, options) {
                                jsonResponse = Ext.decode(response.responseText);
                                if (jsonResponse.success == true) {
                                    Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                                    ".$targetTable."Store.reload({
									params :{
										".$targetMasterTable." : Ext.getCmp('".$targetMasterTable."').getValue()
									}
								  });
                                } else if (jsonResponse.success == false) {
                                    Ext.MessageBox.alert(systemErrorLabel, jsonResponse.message);
                                }
                            },
                            failure: function (response, options) {
                                Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + ':' + escape(response.statusText));
                            }
                        }); 
                    }
                }
            }]
        },
        bbar: new Ext.PagingToolbar({
            store: ".$targetTable."Store,
            pageSize: perPage
        }),
        view: new Ext.ux.grid.BufferView({
            rowHeight: 34,
            scrollDelay: false
        })
    });";
		}
		   $entity.="var ".$targetTable."Entity = Ext.data.Record.create([";
			$entity.=substr($str,0,-1);
	$entity.=substr($entityInside,0,-1);
                      
					$entity.="]);";
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

$comboRenderer.="Ext.util.Format.comboRenderer = function(combo) {
				return function(value) {
					var record = combo.findRecord(combo.valueField
							|| combo.displayField, value);
					if (record) {
						// remove special character

						res = record.get(combo.displayField);
						// res = res.replace(/[^a-zA-Z 0-9]+/g, '-');
					} else {
						// res = (\"hmm, not found:\" + value);
						res = (value);
					}
					return res;
				};
			};";
			
	if($targetGridType=='first') {
		$systemCheckBox="
	var isDefaultGrid = new Ext.ux.grid.CheckColumn({
        header: isDefaultLabel,
        dataIndex: 'isDefault',
        hidden: isDefaultHidden
    });
    var isNewGrid = new Ext.ux.grid.CheckColumn({
        header: 'New',
        dataIndex: 'isNew',
        hidden: isNewHidden
    });
    var isDraftGrid = new Ext.ux.grid.CheckColumn({
        header: isDraftLabel,
        dataIndex: 'isDraft',
        hidden: isDraftHidden
    });
    var isUpdateGrid = new Ext.ux.grid.CheckColumn({
        header: isUpdateLabel,
        dataIndex: 'isUpdate',
        hidden: isUpdateHidden
    });
    var isDeleteGrid = new Ext.ux.grid.CheckColumn({
        header: isDeleteLabel,
        dataIndex: 'isDelete'
    });
    var isActiveGrid = new Ext.ux.grid.CheckColumn({
        header: isActiveLabel,
        dataIndex: 'isActive',
        hidden: isActiveHidden
    });
    var isApprovedGrid = new Ext.ux.grid.CheckColumn({
        header: isApprovedLabel,
        dataIndex: 'isApproved',
        hidden: isApprovedHidden
    });
    var isReviewGrid = new Ext.ux.grid.CheckColumn({
        header: isReviewLabel,
        dataIndex: 'isReview',
        hidden: isReviewHidden
    });
    var isPostGrid = new Ext.ux.grid.CheckColumn({
        header: 'Post',
        dataIndex: 'isPost',
        hidden: isPostHidden
    });
    
	";
	}  else {
	
		$systemCheckbox="
			
    var isDefaultGridDetail = new Ext.ux.grid.CheckColumn({
        header: isDefaultLabel,
        dataIndex: 'isDefault',
        hidden: isDefaultHidden
    });
    var isNewGridDetail = new Ext.ux.grid.CheckColumn({
        header: isNewLabel,
        dataIndex: 'isNew',
        hidden: isNewHidden
    });
    var isDraftGridDetail = new Ext.ux.grid.CheckColumn({
        header: isDraftLabel,
        dataIndex: 'isDraft',
        hidden: isDraftHidden
    });
    var isUpdateGridDetail = new Ext.ux.grid.CheckColumn({
        header: isUpdateLabel,
        dataIndex: 'isUpdate',
        hidden: isUpdateHidden
    });
    var isDeleteGridDetail = new Ext.ux.grid.CheckColumn({
        header: isDeleteLabel,
        dataIndex: 'isDelete'
    });
    var isActiveGridDetail = new Ext.ux.grid.CheckColumn({
        header: isActiveLabel,
        dataIndex: 'isActive',
        hidden: isActiveHidden
    });
    var isApprovedGridDetail = new Ext.ux.grid.CheckColumn({
        header: isApprovedLabel,
        dataIndex: 'isApproved',
        hidden: isApprovedHidden
    });
    var isReviewGridDetail = new Ext.ux.grid.CheckColumn({
        header: isReviewLabel,
        dataIndex: 'isReview',
        hidden: isReviewHidden
    });
    var isPostGridDetail = new Ext.ux.grid.CheckColumn({
        header: isPostLabel,
        dataIndex: 'isPost',
        hidden: isPostHidden
    });
		";
		
		$jsonWriter="var ".$targetTable."Editor = new Ext.ux.grid.RowEditor({
        saveText: saveButtonLabel,
        cancelText: cancelButtonLabel,
        listeners: {
            cancelEdit: function (rowEditor, changes, record, rowIndex) {
               
				".$targetTable."Store.reload({
									params :{
										".$targetMasterTable." : Ext.getCmp('".$targetMasterTable."').getValue()
									}
								  });
            },
            afteredit: function (rowEditor, changes, record, rowIndex) {
                this.save = true;
                var record = this.grid.getStore().getAt(rowIndex);
				if (parseInt(record.get('".$targetTable."Id')) == 'NaN') {
                    method = 'create';
                } else if (record.get('".$targetTable."Id') == '') {
                    method = 'create';
                } else if (record.get('".$targetTable."Id') == undefined) {
                    method = 'create';
                } else if (parseInt(record.get('".$targetTable."Id')) > 0) {
                    method = 'save';
                } else {
                    method = 'create';
                }
                Ext.Ajax.request({
                    url: '../controller/".$targetTable."Controller.php',
                    method: 'POST',
                    params: {
                        leafId: leafId,
                        isAdmin: isAdmin,
                        method: method,";
                        
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
			   $columnNameMysql !='isConsolidation'&&
			   $columnNameMysql !='isReconciled' &&
			   $columnNameMysql !='executeBy'&&
			   $columnNameMysql !='executeTime' &&
			   $columnNameMysql !=$targetMasterTable) {	
			$jsonWriterInsideValue.="  ".$columnNameMysql.": record.get('". $columnNameMysql."'),";
		} else if ($columnNameMysql == $targetMasterTable) {
			$jsonWriterInsideValue.="  ".$columnNameMysql.": Ext.getCmp('". $columnNameMysql."').getValue(),";
		}		}
			$jsonWriter.=substr($jsonWriterInsideValue,0,-1);
			
					$jsonWriter.="},
                    success: function (response, options) {
                        jsonResponse = Ext.decode(response.responseText);
                        if (jsonResponse.success == false) {
                            Ext.MessageBox.alert(systemLabel, jsonResponse.message);
                        } else {
							".$targetTable."Store.reload({
									params :{
										".$targetMasterTable." : Ext.getCmp('".$targetMasterTable."').getValue()
									}
								  });
						}
                    },
                    failure: function (response, options) {
                        Ext.MessageBox.alert(systemErrorLabel, escape(response.status) + \":\" + response.statusText);
                    }
                });
            }
        }
    });";
}	

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
			   $columnNameMysql !='isConsolidation'&&
			   $columnNameMysql !='isReconciled' &&
			   $columnNameMysql !='executeBy'&&
			   $columnNameMysql !='executeTime' &&
			   $columnNameMysql !=$targetTableId) {	

	$getterSetter.="/**
	 * 
	 * @return 
	 */
	public function get".ucfirst($columnNameMysql)."()
	{
	    return \$this->".$columnNameMysql.";
	}

	/**
	 * 
	 * @param $countryDesc
	 */
	public function set".ucfirst($columnNameMysql)."(".$columnNameMysql.")
	{
	    \$this->".$columnNameMysql." = ".$columnNameMysql.";
	}";
	}
	}
	
$execute="
/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		\$this->setTableName('".$targetTable."');
		\$this->setPrimaryKeyName('".$targetTableId."');
		/**
		 * All the $_POST enviroment.
		 */ ";
			
		$execute.=$executeDalam;	
		$execute.="
		/**
		 * All the \$_GET enviroment.
		 */
		if (isset(\$_GET ['".$targetTableId."'])) {
			\$this->setTotal(count(\$_GET ['".$targetTableId."']));
		}

		if (isset(\$_GET ['isDefault'])) {
			if (is_array(\$_GET ['isDefault'])) {
				\$this->isDefault = array();
			}
		}
		if (isset(\$_GET ['isNew'])) {
			if (is_array($_GET ['isNew'])) {
				\$this->isNew = array();
			}
		}
		if (isset(\$_GET ['isDraft'])) {
			if (is_array(\$_GET ['isDraft'])) {
				\$this->isDraft = array();
			}
		}
		if (isset(\$_GET ['isUpdate'])) {
			if (is_array(\$_GET ['isUpdate'])) {
				\$this->isUpdate = array();
			}
		}
		if (isset(\$_GET ['isDelete'])) {
			if (is_array(\$_GET ['isDelete'])) {
				\$this->isDelete = array();
			}
		}
		if (isset(\$_GET ['isActive'])) {
			if (is_array(\$_GET ['isActive'])) {
				\$this->isActive = array();
			}
		}
		if (isset(\$_GET ['isApproved'])) {
			if (is_array(\$_GET ['isApproved'])) {
				\$this->isApproved = array();
			}
		}
		if (isset(\$_GET ['isReview'])) {
			if (is_array(\$_GET ['isReview'])) {
				\$this->isReview = array();
			}
		}
		if (isset(\$_GET ['isPost'])) {
			if (is_array(\$_GET ['isPost'])) {
				\$this->isPost = array();
			}
		}
		\$primaryKeyAll = '';
		for (\$i = 0; \$i < \$this->getTotal(); \$i++) {
			
			if (isset(\$_GET ['".$targetTableId."'])) {
				\$this->set".ucfirst($targetTableId)."(\$this->strict(\$_GET ['".$targetTableId."'] [\$i], 'numeric'), \$i, 'array');
			}
			
			if (isset(\$_GET ['isDefault'])) {
				if (\$_GET ['isDefault'] [\$i] == 'true') {
					\$this->setIsDefault(1, \$i, 'array');
				} else if (\$_GET ['isDefault'] [\$i] == 'false') {
					\$this->setIsDefault(0, \$i, 'array');
				}
			}
			if (isset(\$_GET ['isNew'])) {
				if (\$_GET ['isNew'] [\$i] == 'true') {
					\$this->setIsNew(1, \$i, 'array');
				} else if (\$_GET ['isNew'] [\$i] == 'false') {
					\$this->setIsNew(0, \$i, 'array');
				}
			}
			if (isset(\$_GET ['isDraft'])) {
				if (\$_GET ['isDraft'] [\$i] == 'true') {
					\$this->setIsDraft(1, \$i, 'array');
				} else if (\$_GET ['isDraft'] [\$i] == 'false') {
					\$this->setIsDraft(0, \$i, 'array');
				}
			}
			if (isset(\$_GET ['isUpdate'])) {
				if (\$_GET ['isUpdate'] [\$i] == 'true') {
					\$this->setIsUpdate(1, \$i, 'array');
				} if (\$_GET ['isUpdate'] [\$i] == 'false') {
					\$this->setIsUpdate(0, \$i, 'array');
				}
			}
			if (isset(\$_GET ['isDelete'])) {
				if (\$_GET ['isDelete'] [\$i] == 'true') {
					\$this->setIsDelete(1, \$i, 'array');
				} else if (\$_GET ['isDelete'] [\$i] == 'false') {
					\$this->setIsDelete(0, $i, 'array');
				}
			}
			if (isset(\$_GET ['isActive'])) {
				if (\$_GET ['isActive'] [\$i] == 'true') {
					\$this->setIsActive(1, \$i, 'array');
				} else if (\$_GET ['isActive'] [\$i] == 'false') {
					\$this->setIsActive(0, \$i, 'array');
				}
			}
			if (isset(\$_GET ['isApproved'])) {
				if (\$_GET ['isApproved'] [\$i] == 'true') {
					\$this->setIsApproved(1, \$i, 'array');
				} else if (\$_GET ['isApproved'] [\$i] == 'false') {
					\$this->setIsApproved(0, \$i, 'array');
				}
			}
			if (isset(\$_GET ['isReview'])) {
				if (\$_GET ['isReview'] [\$i] == 'true') {
					\$this->setIsReview(1, \$i, 'array');
				} else if (\$_GET ['isReview'] [\$i] == 'false') {
					\$this->setIsReview(0, \$i, 'array');
				}
			}
			if (isset(\$_GET ['isPost'])) {
				if (\$_GET ['isPost'] [\$i] == 'true') {
					\$this->setIsPost(1, \$i, 'array');
				} else if (\$_GET ['isPost'] [\$i] == 'false') {
					\$this->setIsPost(0, \$i, 'array');
				}
			}
			\$primaryKeyAll .= \$this->getAdjustmentId(\$i, 'array') . \",\";
		}
		\$this->setPrimaryKeyAll((substr(\$primaryKeyAll, 0, - 1)));
		/**
		 * All the \$_SESSION enviroment.
		 */
		if (isset(\$_SESSION ['staffId'])) {
			\$this->setExecuteBy(\$_SESSION ['staffId']);
		}
		/**
		 * TimeStamp Value.
		 */
		if (\$this->getVendor() == self::MYSQL) {
			\$this->setExecuteTime(\"'\" . date(\"Y-m-d H:i:s\") . \"'\");
		} else if (\$this->getVendor() == self::MSSQL) {
			\$this->setExecuteTime(\"'\" . date(\"Y-m-d H:i:s.u\") . \"'\");
		} else if (\$this->getVendor() == self::ORACLE) {
			\$this->setExecuteTime(\"to_date('\" . date(\"Y-m-d H:i:s\") . \"','YYYY-MM-DD HH24:MI:SS')\");
		}
	}
";

$mainModel.="

require_once (\"../../class/classValidation.php\");

/**
 * this is ".$targetTable." model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Account Receivable / Account Payable Invoice 
 * @subpackage adjustment
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ".ucfirst($targetTable)."Model extends ValidationClass { ";



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
<a name="copyJsonStore"></a>
<h1>Copy To Json Store</h1>
<pre class="brush: js;">
<?php echo (substr($str,0,-1)); ?>
</pre>
<a name="copyGridFilter"></a>
<h1>Copy To GridFilter</h1>
<pre class="brush: js;">
<?php echo $str5; ?>
</pre>
<a name="copyColumnModel"></a>
<h1>Copy To ColumnModel</h1>
<pre class="brush: js;">
<?php echo $str4; ?>
</pre>
<a name="copyFormItem"></a>
<h1>Copy To Form Item</h1>
<pre class="brush: js;">
<?php echo $str2; ?>
</pre>
<?php } ?>
<a name="jsonRequest"></a>
<h1>Request,Reader,JsonStore</h1>
<pre class="brush: js;">
<?php echo $jsonStoreString; ?>
</pre>
<a name="gridFilter"></a>
<h1>GridFilter</h1>
<pre class="brush: js;">
<?php echo $gridFilterJs; ?>
</pre>
<a name="columnModel"></a>
<h1>ColumnModel</h1>
<pre class="brush: js;">
<?php echo $columnModelJs; ?>
</pre>
<a name="gridPanel"></a>
<h1>GridPanel</h1>
<pre class="brush: js;">
<?php echo $gridPanel; ?>
</pre>
<a name="copyFormItem"></a>
<h1>Copy To Form Item</h1>
<pre class="brush: js;">
<?php echo $formItem; ?>
</pre>
<a name="systemValidation"></a>
<h1>System Validation</h1>
<pre class="brush: js;">
<?php echo $systemValidation; ?>
</pre>
<a name="formPanel"></a>
<h1>Form Panel</h1>
<pre class="brush: js;">
<?php echo $formPanel; ?>
</pre>
<?php } ?>
<?php if($_GET['type']=='fulljs') { ?>
<h1>Full Javascript</h1>
<?php 
if($targetTableType=='first') { 
echo $firstCodeJs.$jsonStoreString.$gridFilterJs.$systemCheckbox.$columnModelJs.$gridPanel.$formItem.$systemValidation.$formPanel.$lastCodeJs;
} else {
echo $jsonStoreString.$gridFilterJs.$formItem.$systemCheckbox.$comboRenderer.$columnModelJs.$jsonWriter.$entity.$gridPanel;

} ?>
<a name="fulljs"></a>
<pre class="brush: js;">

<?php 
if($targetTableType=='first') { 
echo $firstCodeJs.$jsonStoreString.$gridFilterJs.$systemCheckbox.$columnModelJs.$gridPanel.$formItem.$systemValidation.$formPanel.$lastCodeJs;
} else {
echo $jsonStoreString.$gridFilterJs.$formItem.$systemCheckbox.$comboRenderer.$columnModelJs.$jsonWriter.$entity.$gridPanel;

} ?>
</pre>


<?php } ?>
<?php if ($_GET['type']=='controller') { ?>
<a name="createStatement"></a>
<h1>Full Controller</h1>
<pre class="brush: php;">
<?php echo $fullController; ?>
</pre>
<a name="createStatement"></a>
<h1>Create Statement</h1>
<pre class="brush: php;">
<?php echo $insertStatement; ?>
</pre>
<a name="readStatement"></a>
<h1>Read Statement</h1>
<pre class="brush: php;">
<?php echo $readStatement; ?>
</pre>
<a name="updateStatement"></a>
<h1>Update Statement</h1>
<pre class="brush: php;">
<?php echo $updateStatement; ?>
</pre>
<a name="deletStatement"></a>
<h1>Delete Statement</h1>
<pre class="brush: php;">
<?php echo $deleteStatement; ?>
</pre>
<a name="updateStatus"></a>
<h1>Update Status Statement</h1>
<pre class="brush: php;">
<?php //echo $deleteStatement; ?>
</pre>
<?php } ?>
<?php if ($_GET['type']=='model') { ?>
<h1>haha Statement</h1>
<pre class="brush: php;">
<?php echo $mainModel.$mainModelInside.$execute.$crud.$model.$getterSetter." \n} "; ?>
</pre>
<?php } ?>
</html>
