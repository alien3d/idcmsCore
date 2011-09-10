<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../class/classDocumentTrail.php");
require_once("../model/moduleModel.php");
require_once("../model/folderModel.php");
require_once("../model/leafModel.php");
require_once("../model/leafUserModel.php");
/**
 * this is main setting files.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package main
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class mainClass extends configClass
{
	/**
	 * Connection to the database
* @var string
	 */
	public $q;
	/**
	 * Program Identification
	 * @var numeric $leafId
	 */
	public $leafId;
	/**
	 * User Identification
	 * @var numeric $staffId
	 */
	public $staffId;
	/**
	 * Selected Database or Tablespace
	 * @var string $database
	 */
	public $database;
	/**
	 * Database Vendor
	 * @var string $vendor
	 */
	public $vendor;
	/**
	 * Extjs Grid Filter Array
	 * @var string $filter
	 */
	public $filter;
	/**
	 * Extjs Grid  single query information
* @var stringuery
	 */
	public $query;
	/**
	 * Fast Search Variable
* @var stringuickFilter
	 */
	public $quickFilter;
	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
* @var string
	 */
	private $excel;
	/**
	 * Document Trail Audit.
	 * @var string $documentTrail;
	 */
	private $documentTrail;
	/**
	 * Start
	 * @var string $start;`
	 */
	public $start;
	/**
	 *  Limit
	 * @var string $limit
	 */
	public $limit;
	/**
	/**
	 *  Ascending ,Descending ASC,DESC
	 * @var string $order;`
	 */
	public $order;
	/**
	 * Sort the default field.Mostly consider as primary key default.
	 * @var string $sortField
	 */
	public $sortField;
	/**
	 * Default Language  : English
	 * @var numeric $defaultLanguageId
	 */
	private $defaultLanguageId;
	/**
	 * Audit Row True or False
	 * @var boolean $audit
	 */
	private $audit;
	/**
	 * Log Sql Statement True or False
	 * @var unknown_type
	 */
	private $log;
	/**
	 * Current Table main Identification Value
	 * @var numeric $mainId
	 */
	public $mainId;
	/**
	 * main Model
	 * @var string $mainModel
	 */
	public $model;
	/**
	 * Open To See Audit  Column --> approved,new,delete and e.g
	 * @var numeric $isAdmin
	 */
	public $isAdmin;
	/**
	 * Audit Filter
	 * @var string $auditFilter
	 */
	public $auditFilter;
	/**
	 * Audit Column
	 * @var string $auditColumn
	 */
	public $auditColumn;
	/**
	 * Class Loader
	 */
	function execute()
	{
		parent::__construct();
		
		$this->q              = new vendor();
		$this->q->vendor      = $this->vendor;
		$this->q->leafId      = $this->leafId;
		$this->q->staffId     = $this->staffId;
		$this->q->filter      = $this->filter;
		$this->q->quickFilter = $this->quickFilter;
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());
		$this->excel         = new PHPExcel();
		$this->audit         = 0;
		$this->log           = 1;
		$this->q->log        = $this->log;
		
		$this->model         = new mainModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->documentTrail = new documentTrailClass();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->getVendor() == self::mysql) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$sql = "
			INSERT INTO `" . mainModel::tableName . "`	
					(
						`" . mainModel::mainDesc . "`,	`" . mainModel::isDefaut . "`,
						`" . mainModel::isNew . "`,			`" . mainModel::isDraft . "`,
						`" . mainModel::isUpdate . "`,		`" . mainModel::isDelete . "`,
						`" . mainModel::isActive . "`,		`" . mainModel::isApproved . "`,
						`" . mainModel::By . "`,			`" . mainModel::Time . "`
					)
			VALUES	
					(
						\"". $this->model->mainDesc . "\",	\"". $this->model->isDefaut . "\",
						\"". $this->model->getIsNew(0,'single') . "\",			\"". $this->model->getIsDraft(0,'single') . "\",
						\"". $this->model->getIsUpdate(0,'single') . "\",		\"". $this->model->getIsDelete(0,'single') . "\",
						\"". $this->model->getIsActive(0,'single') . "\",		\"". $this->model->getIsApproved(0,'single') . "\",
						\"". $this->model->getExecuteBy() . "\",				" . $this->model->getExecuteTime() . "
					);";
		$this->q->start();
		$this->model->create();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			INSERT INTO `main`	
					(
						`mainDesc`,						`isDefault`,
						`isNew`,							`isDraft`,
						`isUpdate`,							`isDelete`,
						`isActive`,							`isApproved`,
						`executeBy`,								`executeTime`
					)
			VALUES	
					(
						\"". $this->model->mainDesc . "\",	\"". $this->model->isDefaut . "\",
						\"". $this->model->getIsNew(0,'single') . "\",			\"". $this->model->getIsDraft(0,'single') . "\",
						\"". $this->model->getIsUpdate(0,'single') . "\",		\"". $this->model->getIsDelete(0,'single') . "\",
						\"". $this->model->getIsActive(0,'single') . "\",		\"". $this->model->getIsApproved(0,'single') . "\",
						\"". $this->model->getExecuteBy() . "\",				" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			INSERT INTO [main]
					(
						[mainDesc],						[isDefault],
						[isNew],							[isDraft],
						[isUpdate],							[isDelete],
						[isActive],							[isApproved],
						[executeBy],								[executeTime]
					)
			VALUES	
					(
						\"". $this->model->mainDesc . "\",	\"". $this->model->isDefaut . "\",
						\"". $this->model->getIsNew(0,'single') . "\",			\"". $this->model->getIsDraft(0,'single') . "\",
						\"". $this->model->getIsDraft(0,'single') . "\",		\"". $this->model->getIsDelete(0,'single') . "\",
						\"". $this->model->getIsUpdate(0,'single') . "\",		\"". $this->model->getIsApproved(0,'single') . "\",
						\"". $this->model->getIsActive(0,'single') . "\",		" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			INSERT INTO	\"main\"
					(
						\"mainDesc\",					\"isDefault\",
						\"isNew\",							\"isDraft\",
						\"isUpdate\",						\"isDelete\",
						\"isActive\",						\"isApproved\",
						\"executeBy\",								\"executeTime\"
					)	
			VALUES	
					(
						\"". $this->model->mainDesc . "\",	\"". $this->model->isDefaut . "\",
						\"". $this->model->getIsNew(0,'single') . "\",			\"". $this->model->getIsDraft(0,'single') . "\",
						\"". $this->model->getIsDraft(0,'single') . "\",		\"". $this->model->getIsDelete(0,'single') . "\",
						\"". $this->model->getIsUpdate(0,'single') . "\",		\"". $this->model->getIsApproved(0,'single') . "\",
						\"". $this->model->getIsActive(0,'single') . "\",		" . $this->model->getExecuteTime() . "
					)";
		}
		//advance logging future
		$this->q->tableName          = $this->model->tableName;
		$this->q->primaryKeyName  = $this->model->primaryKeyName;
		// $this->q->primaryKeyValue = $this->q->lastInsertId();  not use here
	
		$this->q->audit           = $this->audit;
		$this->q->create($sql);
		
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		
		
		$this->q->commit();
		echo json_encode(array(
            "success" => true,
            "message" => "Record Created"
            ));
            exit();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if($this->isAdmin == 0 || empty($this->auditColumn)) {
			if($this->getVendor()==self::mysql) { 
				$this->auditFilter = "	`main`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[main].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"main\".\"isActive\"	=	1	";
			}
		} else if($this->auditColumn) {
			if($this->getVendor()==self::mysql) { 
				$this->auditFilter = "	`main`.`".$this->auditColumn."` = 1 ";
			} else if ($this->q->vendor == self :: mssql) {	
			    $this->auditFilter = "	[main].[".$this->auditColumn."] = 1 ";
			} else if  ($this->q->vendor == self :: oracle) {
                  $this->auditFilter = " \"main\".\"".$this->auditColumn."\" = 1 ";			
			}
		}
		//UTF8
		$items=array();
		if ($this->getVendor() == self::mysql) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
									$counter_folder=0;
							   		if($q->vendor=='normal' || $q->vendor=='mysql') {
										$sql_folder	="
										SELECT		*
										FROM 		`folderAccess`
										JOIN		`folder`
										USING		(`folderId`)
										JOIN		`folderTranslate`
										USING		(`folderId`)
										JOIN		`icon`
										USING		(`iconId`)
										WHERE 		`accordionId`=\"".$accordionId."\"
										AND 		`folderAccess`.`groupId`=\"".$_SESSION['groupId']."\"
										AND 		`folderAccess`.`folderAccessValue`=	1
										AND			`folderTranslate`.`languageId`=\"".$_SESSION['languageId']."\"
										ORDER BY 	`folder`.`folderSequence`	";
									} else  if ($q->vendor=='microsoft') {
										$sql_folder	="
										SELECT		*
										FROM 		[folderAccess]
										JOIN			[folder]
										ON			[folderAccess].[folderId]=[folder].[folderId]
										JOIN			[folderTranslate]
										ON			[folderTranslate].[folderId]=[folder].[folderId]
										JOIN			[icon]
										ON			[icon].[iconId]=[folder].[iconId]
										WHERE 		[accordionId]='".$accordionId."'
										AND 			[folderAccess].[groupId]=(
																SELECT TOP 1 [groupId]
																FROM 	[staff]
																WHERE	[staff].[staffId]='".$_SESSION[$staffId]."'
															  )
										AND 	[folderAccess].[folderAccessValue]=	1
										AND		[folderTranslate].[languageId]='".$_SESSION['languageId']."'
										ORDER BY 	[folder].[folderSequence]	";

									} else if ($q->vendor=='oracle') {

									$sql_folder	="
										SELECT		*
										FROM 		\"folderAccess\"
										JOIN		\"folder\"
										USING		(\"folderId\")
										JOIN		\"folderTranslate\"
										USING		(\"folderId\")
										JOIN		\"icon\"
										USING		(\"iconId\")
										WHERE 		\"accordionId\"=\"".$accordionId."\"
										AND 		\"folderAccess\".\"groupId\"=(
																SELECT \"groupId\"
																FROM 	\"staff\"
																WHERE	\"staff\".\"staffId\"=\"".$_SESSION[$staffId]."\"
																AND		rownum <=1
															  )
										AND 		\"folderAccess\".\"folderAccessValue\"=	1
										AND			\"folderTranslate\".\"languageId\"=\"".$_SESSION['languageId']."\"
										ORDER BY 	\"folder\".\"folderSequence\"	";
									}
							   		//echo $sql_fol/der;
									$result_folder = $q->fast($sql_folder);
									$total_folder  = $q->numberRows($result_folder,$sql_folder);
									if( $total_folder > 0 ) {
										while($row_folder = $q->fetchArray($result_folder)) {
												$folderTranslate =$row_folder['folderTranslate'];
												$iconName=$row_folder['iconName'];
												$folderId	=$row_folder['folderId'];
												$folderPath = $row_folder['folderPath'];

											$counter_folder++; ?>
											<?php echo " { "; ?>
							expanded	: true,
							text		: '<?php echo $folderTranslate ; ?>',
							iconCls 	: '<?php echo $iconName; ?>',
							children	: [
						<?php  //  program configuration
							    $counter_leaf=0;
							   	if($q->vendor=='normal' || $q->vendor=='mysql') {
									$sql_leaf	="
									SELECT		*
									FROM		`leafAccess`
									JOIN		`leaf`
									USING		(`leafId`)
									JOIN		`leafTranslate`
									USING		(`leafId`)
									JOIN		`icon`
									USING		(`iconId`)
									WHERE 		`folderId`=\"".$folderId."\"
									AND			`accordionId`=\"".$accordionId."\"
									AND			`leafAccess`.`staffId`=\"".$_SESSION[$staffId]."\"
									AND			`leafTranslate`.`languageId`=\"".$_SESSION['languageId']."\"
								ORDER BY	`leaf`.`leafSequence`";
								} else if ($q->vendor=='microsoft') {
									$sql_leaf	="
									SELECT		*
									FROM		[leafAccess]
									JOIN			[leaf]
									ON			[leafAccess].[leafId]=[leaf].[leafId]
									JOIN			[leafTranslate]
									ON			[leafTranslate].[leafId]=[leaf].[leafId]
									JOIN			[icon]
									ON			[icon].[iconId]=[leaf].[iconId]
									WHERE 		[folderId]=\"".$folderId."\"
									AND			[accordionId]=\"".$accordionId."\"
									AND			[leafAccess].[staffId]=\"".$_SESSION[$staffId]."\"
									AND			[leafTranslate].[languageId]=\"".$_SESSION['languageId']."\"
									ORDER BY	[leaf].[leafSequence]";
								} else if ( $q->vendor=='oracle') {
									$sql_leaf	="
									SELECT		*
									FROM		\"leafAccess\"
									JOIN		\"leaf\"
									USING		(\"leafId\")
									JOIN		\"leafTranslate\"
									USING		(\"leafId\")
									JOIN		\"icon\"
									USING		(\"iconId\")
									WHERE 		\"folderId\"=\"".$folderId."\"
									AND			\"accordionId\"=\"".$accordionId."\"
									AND			\"leafAccess\".\"staffId\"=\"".$_SESSION[$staffId]."\"
									AND			\"leafTranslate\".\"languageId\"=\"".$_SESSION['languageId']."\"";
								}
								$result_leaf = $q->fast($sql_leaf);
								$total_leaf  = $q->numberRows($result_leaf,$sql_leaf);
								if($total_leaf > 0 ) {
									while($row_leaf = $q->fetchArray($result_leaf)) {

												$leafTranslate =	$row_leaf['leafTranslate'];
												$iconName	=	$row_leaf['iconName'];
												$leafFilename	=	$row_leaf['leafFilename'];

										$counter_leaf++;
										 echo " { "; ?>

									text		: '<?php echo $leafTranslate ; ?>\n',
									leaf		: true,
									iconCls 	: '<?php echo $iconName; ?>',
									listeners	: {
										click		:
										function	()	{
										Ext.getCmp('west-panel').collapse() ;
											// just alert to see the path

											AddCenterTabIF('<?php echo $leafTranslate; ?>','../../<?php echo $folderPath; ?>/view/<?php echo $leafFilename; ?>') ;

										}


									}
								} <?php if($counter_leaf != $total_leaf) { echo ","; } else { echo "]"; } // this is for javascript ',' ?>
									<?php } }  else { echo "{ text:'No Leaf Identify',leaf:true }]"; } //end looping ?>
							}<?php if($counter_folder != $total_folder) { echo ","; } else { echo "]"; } // this is for javascript ',' ?>
								<?php } }  else { echo "{ text:'No Folder Identify',expanded:true }]";  } 
								
								
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array(
            'mainId'
            );
            /**
             *	filter table
             * @variables $tableArray
             */
            $tableArray  = null;
            $tableArray  = array(
            'main'
            );
            if ($this->quickFilter) {
            	if ($this->getVendor() == self::mysql) {
            		$sql .= $this->q->quickSearch($tableArray, $filterArray);
            	} else if ($this->getVendor() == self::mssql) {
            		$tempSql = $this->q->quickSearch($tableArray, $filterArray);
            		$sql .= $tempSql;
            	} else if ($this->getVendor() == self::oracle) {
            		$tempSql = $this->q->quickSearch($tableArray, $filterArray);
            		$sql .= $tempSql;
            	}
            }
            /**
             *	Extjs filtering mode
             */
            if ($this->filter) {
            	if ($this->getVendor() == self::mysql) {
            		$sql .= $this->q->searching();
            	} else if ($this->getVendor() == self::mssql) {
            		$tempSql2 = $this->q->searching();
            		$sql .= $tempSql2;
            	} else if ($this->getVendor() == self::oracle) {
            		$tempSql2 = $this->q->searching();
            		$sql .= $tempSql2;
            	}
            }
            // optional debugger.uncomment if wanted to used
	 		//if ($this->q->execute == 'fail') {
            //	echo json_encode(array(
             //   "success" => false,
            //   "message" => $this->q->realEscapeString($sql)
            //	));
            //	exit();
            //}
            // end of optional debugger
            $this->q->read($sql);
            if ($this->q->execute == 'fail') {
            	echo json_encode(array(
                "success" =>false,
                "message" => $this->q->responce
            	));
            	exit();
            }
            $total = $this->q->numberRows();
            if ($this->order && $this->sortField) {
            	if ($this->getVendor() == self::mysql) {
            		$sql .= "	ORDER BY `" . $sortField . "` " . $dir . " ";
            	} else if ($this->getVendor() ==  self::mssql) {
            		$sql .= "	ORDER BY [" . $sortField . "] " . $dir . " ";
            	} else if ($this->getVendor() == self::oracle) {
            		$sql .= "	ORDER BY \"" . $sortField . "\"  " . $dir . " ";
            	}
            }
            $_SESSION['sql']   = $sql; // push to session so can make report via excel and pdf
            $_SESSION['start'] = $this->start;
            $_SESSION['limit'] = $this->limit;
            if (empty($_POST['filter'])) {
            	if ($this->getLimit()) {
            		// only mysql have limit
            		if ($this->getVendor() == self::mysql) {
            			$sql .= " LIMIT  " . $this->start . "," . $this->limit . " ";
            		} else if ($this->getVendor() == self::mssql) {
            			/**
            			 *	 Sql Server and Oracle used row_number
            			 *	 Parameterize Query We don't support
            			 */
            			$sql = "
							WITH [mainDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [tabId]) AS 'RowNumber'
								FROM [main]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[main].[mainId],
										[main].[mainDesc]
										[main].[isDefault],
										[main].[isNew],
										[main].[isDraft],
										[main].[isUpdate],
										[main].[isDelete],
										[main].[isApproved],
										[main].[executeBy],
										[main].[executeTime],
										[staff].[staffName]	
							FROM 		[mainDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $_POST['start'] . "
							AND 			" . ($this->start + $this->limit - 1) . ";";
            		} else if ($this->getVendor() == self::oracle) {
            			/**
            			 *  Oracle using derived table also
            			 */
            			$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT  \"main\".\"mainId\",
											\"main\".\"mainDesc\"
											\"main\".\"isDefault\",
											\"main\".\"isNew\",
											\"main\".\"isDraft\",
											\"main\".\"isUpdate\",
											\"main\".\"isDelete\",
											\"main\".\"isApproved\",
											\"main\".\"executeBy\",
											\"main\".\"executeTime\",
											\"staff\".\"staffName\"	
									FROM 	\"main\"
									WHERE \"isActive\"=1  " . $tempSql . $tempSql2 . $orderBy . "
								 ) a
						where rownum <= \"". ($this->start + $this->limit - 1) . "\" )
						where r >=  \"". $this->start . "\"";
            		} else {
            			echo "undefine vendor";
            		}
            	}
            }
            /*
             *  Only Execute One Query
             */
            if (!($this->mainId)) {
            	$this->q->read($sql);
            	if ($this->q->execute == 'fail') {
            		echo json_encode(array(
                    "success" => false,
                    "message" => $this->q->responce
            		));
            		exit();
            	}
            }
            $items = array();
            while ($row = $this->q->fetchAssoc()) {
            	$items[] = $row;
            }
            
            echo $json_encode;
            
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update()
	{
		
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete()
	{
		
	}
    
	function tab() {
	}	
	function themeId() {
	}
	
	function languageId() {
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel()
	{
		
	}
}
/**
 *	Declare object
 **/
$mainObject = new mainClass();
if (isset($_SESSION['staffId'])) {
	$mainObject->staffId = $_SESSION['staffId'];
}
if (isset($_SESSION['vendor'])) {
	$mainObject->vendor = $_SESSION['vendor'];
}
/**
 *	crud -create,read,update,delete
 **/
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_POST['leafId'])) {
		$mainObject->leafId = $_POST['leafId'];
	}
	if (isset($_POST['mainId'])) {
		$mainObject->mainId = $_POST['mainId'];
	}
	if (isset($_POST['filter'])) {
		$mainObject->filter = $_POST['filter'];
	}
	if (isset($_POST['query'])) {
		$mainObject->quickFilter = $_POST['query'];
	}
	if (isset($_POST['start'])) {
		$mainObject->start = $_POST['start'];
	} 
	if (isset($_POST['perPage'])) {
		$mainObject->limit = $_POST['perPage'];
	} 
	if (isset($_POST['order'])) {
		$mainObject->order = $_POST['order'];
	}
	if (isset($_POST['sortField'])) {
		$mainObject->sortField = $_POST['sortField'];
	}
	if (isset($_POST['isAdmin'])) {
		$mainObject->isAdmin = $_POST['isAdmin'];
	}
	if (isset($_POST['auditColumn'])) {
		$mainObject->auditColumn = $_POST['auditColumn'];
	}
	/*
	 *  Load the dynamic value
	 */
	$mainObject->execute();
	
	if ($_POST['method'] == 'read') {
		$mainObject->read();
	}
	if ($_POST['method'] == 'save') {
		$mainObject->update();
	}
	
}
if (isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_GET['leafId'])) {
		$mainObject->leafId = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$mainObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$mainObject->staffId();
		}
		if ($_GET['field'] == 'languageId') {
			$mainObject->languageId();
		}
	}
	
	
}
?>
