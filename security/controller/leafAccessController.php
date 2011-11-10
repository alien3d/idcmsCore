<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSecurity.php");
require_once ("../model/leafAccessModel.php");

/**
 * this is  leaf security access
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @package Leaf Security Access Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LeafAccessClass extends ConfigClass {

	/**
	 * Connection to the database
	 * @var string
	 */
	public $q;

	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string
	 */
	private $excel;

	/**
	 * Record Pagination
	 * @var string
	 */
	private $recordSet;

	/**
	 * Document Trail Audit.
	 * @var string
	 */
	private $documentTrail;

	/**
	 * Audit Row True or False
	 * @var bool
	 */
	private $audit;

	/**
	 * Log Sql Statement True or False
	 * @var string
	 */
	private $log;

	/**
	 * Model
	 * @var string
	 */
	public $model;

	/**
	 * Audit Filter
	 * @var string
	 */
	public $auditFilter;

	/**
	 * Audit Column
	 * @var string
	 */
	public $auditColumn;

	/**
	 * Duplicate Testing either the key of table same or have been created.
	 * @var bool
	 */
	public $duplicateTest;

	/**
	 * Class Loader
	 */
	function execute() {
		parent::__construct();
		// audit property
		$this->audit = 0;
		$this->log = 1;

		$this->model = new LeafAccessModel ();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();
		
		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor();
		if($this->model->getLeafIdTemp()) { 
			$this->q->leafId = $this->model->getLeafIdTemp();	
		} else {
			$this->q->leafId = $this->getLeafId();
		}
		$this->q->staffId = $this->getStaffId();
		$this->q->fieldQuery = $this->getFieldQuery();
		$this->q->gridQuery = $this->getGridQuery();
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
		$this->q->log = $this->log;
		$this->q->audit = $this->audit;
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->security = new Security ();
		$this->security->setVendor($this->getVendor());
		$this->security->execute();
		
		
		$this->recordSet = new RecordSet ();
		$this->recordSet->setTableName($this->model->getTableName());
		$this->recordSet->setPrimaryKeyName($this->model->getPrimaryKeyName());
		$this->recordSet->execute();

		$this->documentTrail = new DocumentTrailClass ();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->execute();

		$this->excel = new PHPExcel ();
	}

	/* (non-PHPdoc)
	 * @see config::create()
	 */

	function create() {

	}

	/* (non-PHPdoc)
	 * @see config::read()
	 */

	function read() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
			
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		// by default if add new group will add access to module and leaf.
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
				SELECT	`leaf`.`moduleId`,
						`leaf`.`folderId`,
						`folder`.`folderEnglish`,
						`leaf`.`leafEnglish`,
						`module`.`moduleEnglish`,
						`staff`.`staffName`,
						`team`.`teamEnglish`,
						`leafAccess`.`leafId`,
						`leafAccess`.`staffId`,
						`leafAccess`.`leafAccessId`,
						 (CASE `leafAccess`.`leafAccessCreateValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessCreateValue`,


						 (CASE `leafAccess`.`leafAccessReadValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessReadValue`,

						(CASE `leafAccess`.`leafAccessUpdateValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessUpdateValue`,

						(CASE `leafAccess`.`leafAccessDeleteValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessDeleteValue` ,

						(CASE `leafAccess`.`leafAccessPrintValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessPrintValue`,

						(CASE `leafAccess`.`leafAccessPostValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessPostValue`
				FROM 	`leafAccess`
				JOIN	`leaf`
				USING	(`leafId`)
				JOIN	(`module`)
				USING	(`moduleId`)
				JOIN	(`folder`)
				USING	(`folderId`)
				JOIN	`staff`
				USING	(`staffId`)
				JOIN	`team`
				USING	(`teamId`)
				WHERE 	`module`.`isActive` 	=	1
				AND		`folder`.`isActive` 	=	1
				AND		`leaf`.`isActive`		=	1 
				AND		`team`.`isActive`		=	1";
			if ($this->model->getModuleId()) {
				$sql .= " AND `leaf`.`moduleId`		=	'" . $this->model->getModuleId() . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND `leaf`.`folderId`		=	'" . $this->model->getFolderId() . "'";
			}
			if ($this->model->getStaffId()) {
				$sql .= " AND `leafAccess`.`staffId`	=	'" . $this->model->getStaffId() . "'";
			}
			if ($this->model->getLeafIdTemp() &&  $this->model->getLeafId()) {
				$sql .= " AND `leafAccess`.`leafId`	=	'" . $this->model->getLeafId() . "'";
			}
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
				SELECT	[leaf].[moduleId],
						[leaf].[folderId],
						[folder].[folderEnglish],
						[leaf].[leafEnglish],
						[module].[moduleEnglish],
						[staff].[staffName],
						[team].[teamEnglish],
						[leafAccess].[leafId],
						[leafAccess].[staffId],
						[leafAccess].[leafAccessId],
						 (CASE [leafAccess].[leafAccessCreateValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessCreateValue],


						 (CASE [leafAccess].[leafAccessReadValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessReadValue],

						(CASE [leafAccess].[leafAccessUpdateValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessUpdateValue],

						(CASE [leafAccess].[leafAccessDeleteValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessDeleteValue] ,

						(CASE [leafAccess].[leafAccessPrintValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessPrintValue],

						(CASE [leafAccess].[leafAccessPostValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessPostValue]
				FROM 	[leafAccess]
				JOIN	[leaf]
				ON		[leafAccess].[leafId] = [leaf].[leafId]
				JOIN	[module]
				ON		[leaf].[moduleId]=[module].[moduleId]
				JOIN	[folder]
				ON		[folder].[folderId]=[leaf].[folderId]
				JOIN	[staff]
				ON		[leaf].[staffId]=[staff].[staffId]
				JOIN	[team]
				ON		[team].[teamId]=[leafAccess].[teamId]
				WHERE 	[module].[isActive] 	=	1
				AND		[folder].[isActive] 	=	1
				AND		[leaf].[isActive]		=	1  ";
			if ($this->model->getModuleId()) {
				$sql .= " AND [leaf].[moduleId]		=	'" . $this->strict($this->moduleId, 'numeric') . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND [leaf].[folderId]		=	'" . $this->strict($this->folderId, 'numeric') . "'";
			}
			if ($this->model->getStaffId()) {
				$sql .= " AND [leafAccess`.[staffId]	=	'" . $this->strict($this->staffId, 'numeric') . "'";
			}
			if ($this->model->getLeafIdTemp() && $this->model->getLeafId()) {
				$sql .= " AND `leafAccess`.`leafId`	=	'" . $this->model->getLeafId(). "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
				SELECT	LEAF.MODULEID,
						LEAF.FOLDERID,
						FOLDER.FOLDERENGLISH,
						LEAF.LEAFNOTE,
						MODULE.MODULEENGLISH,
						STAFF.STAFFNAME,
						TEAM.TEAMENGLISH,
						LEAFACCESS.LEAFID,
						LEAFACCESS.STAFFID,
						LEAFACCESS.LEAFACCESSID,
						 (CASE LEAFACCESS.leafAccessCreateValue
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessCreateValue,


						 (CASE LEAFACCESS.leafAccessReadValue
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessReadValue,

						(CASE LEAFACCESS.LEAFACCESSUPDATEVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessUpdateValue,

						(CASE LEAFACCESS.LEAFACCESSDELETEVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessDeleteValue ,

						(CASE LEAFACCESS.LEAFACCESSPRINTVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessPrintValue,

						(CASE LEAFACCESS.LEAFACCESSPOSTVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessPostValue
				FROM 	LEAFACCESS
				JOIN	LEAF
				USING	(LEAFID)
				JOIN	(MODULE)
				USING	(MODULEID,LANGUAGEID)
				JOIN	(FOLDER)
				USING	(FOLDERID,LANGUAGEID)
				JOIN	STAFF
				USING	(STAFFID,LANGUAGEID)
				JOIN	TEAM
				USING	(TEAMID,LANGUAGEID)
				WHERE 	LEAF.ISACTIVE=1
				AND		FOLDER.ISACTIVE=1
				AND		MODULE.ISACTIVE=1
				AND		STAFF.ISACTIVE=1";
			if ($this->model->getModuleId()) {
				$sql .= " AND LEAFACCESS.MODULEID='" . $this->model->getModuleId() . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND LEAFACCESS.FOLDERID='" . $this->model->getFolderId() . "'";
			}
			if ($this->model->getStaffId()) {
				$sql .= " AND LEAFACCESS.STAFFID='" . $this->model->getStaffId() . "'";
			}
			if ($this->model->getLeafIdTemp() &&  $this->model->getLeafId()) {
				$sql .= " AND LEAFACESS.LEAFID	=	'" . $this->model->getLeafId() . "'";
			}
		}
		
		$sql .= $this->q->searching();

		$record_all = $this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => FALSE, "message" => $this->q->responce));
			exit();
		}

		$total = $this->q->numberRows();
		
		if ($this->getStart() && $this->getLimit()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= " LIMIT  " . $this->getStart() . "," . $this->getLimit() . " ";
			} else if ($this->getVendor() == self::MSSQL) {

			} else if ($this->getVendor() == self::ORACLE) {

			} else if ($this->getVendor() == self::DB2) {
				$sql .= " LIMIT  " . $this->getStart() . " OFFSET " . $this->getLimit() . " ";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql .= " LIMIT  " . $this->getStart() . " OFFSET " . $this->getLimit() . " ";
			}
		}

		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}

		while (($row = $this->q->fetchAssoc()) == TRUE) {
			$items [] = $row;
		}

		echo json_encode(array(
			'success' => true, 
			'total' => $total, 
			'time' => $time, 
            'firstRecord' => $this->recordSet->firstRecord('value'), 
            'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getLeafAccessId(0, 'single')), 
            'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getLeafAccessId(0, 'single')), 
            'lastRecord' => $this->recordSet->lastRecord('value'),
			'data' => $items));
		exit();
	}

	/**
	 * Enter description here ...
	 */
	function team() {
		return $this->security->team();
	}

	/**
	 * Enter description here ...
	 */
	function module() {
		$this->security->module($this->model->getType(), $this->model->getTeamId());
	}

	/**
	 * Enter description here ...
	 */
	function folder() {
		$this->security->folder($this->model->getType(), $this->model->getTeamId(), $this->model->getModuleId());
	}

	/* (non-PHPdoc)
	 * @see config::update()
	 */

	function update() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
			
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
				$this->q->start();
		
		$this->model->update();
		$loop = count($_GET ['leafAccessId']);
		// @todo  repair this code !!!
		for ($i = 0; $i < $loop; $i++) {
			// mysql doesn't support bolean expression
			foreach ($this->model->getLeafTempId() as $access_type) {
				if ($_GET ['leaf_' . $access_type . '_acs_val'] [$i] == 'true') {
					$_GET ['leaf_' . $access_type . '_acs_val'] [$i] = 1;
				} else {
					$_GET ['leaf_' . $access_type . '_acs_val'] [$i] = 0;
				}
			}

			if ($this->getVendor() == self::MYSQL) {
				$sql = "
					UPDATE 	`leafAccess`
					SET 	`leafAccessCreateValue`	=	'" . $this->strict($_GET ['leafAccessCreateValue'] [$i], 'numeric') . "',
							`leafAccessReadValue`	=	'" . $this->strict($_GET ['leafAccessReadValue'] [$i], 'numeric') . "',
							`leafAccessUpdateValue`	=	'" . $this->strict($_GET ['leafAccessUpdateValue'] [$i], 'numeric') . "',
							`leafAccessDeleteValue`	=	'" . $this->strict($_GET ['leafAccessDeleteValue'] [$i], 'numeric') . "',
							`leafAccessDraftValue`	=	'" . $this->strict($_GET ['leafAccessDraftValue'] [$i], 'numeric') . "',
							`leafAccessPrintValue`	=	'" . $this->strict($_GET ['leafAccessPrintValue'] [$i], 'numeric') . "',
							`leafAccessPostValue`	=	'" . $this->strict($_GET ['leafAccessPostValue'] [$i], 'numeric') . "'
					WHERE 	`leafAccessId`			=	'" . $this->strict($_GET ['leafAccessId'] [$i], 'numeric') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
					UPDATE 	[leafAccess]
					SET 	[leafAccessCreateValue]	=	'" . $this->strict($_GET ['leafAccessCreateValue'] [$i], 'numeric') . "',
							[leafAccessReadValue]	=	'" . $this->strict($_GET ['leafAccessReadValue'] [$i], 'numeric') . "',
							[leafAccessUpdateValue]	=	'" . $this->strict($_GET ['leafAccessUpdateValue'] [$i], 'numeric') . "',
							[leafAccessDeleteValue]	=	'" . $this->strict($_GET ['leafAccessDeleteValue'] [$i], 'numeric') . "',
							[leafAccessDraftValue]	=	'" . $this->strict($_GET ['leafAccessDraftValue'] [$i], 'numeric') . "',
							[leafAccessPrintValue]	=	'" . $this->strict($_GET ['leafAccessPrintValue'] [$i], 'numeric') . "',
							[leafAccessPostValue]	=	'" . $this->strict($_GET ['leafAccessPostValue'] [$i], 'numeric') . "'
					WHERE 	[leafAccessId]			=	'" . $this->strict($_GET ['leafAccessId'] [$i], 'numeric') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
				UPDATE 	LEAFACCESS
				SET 	LEAFACCESSCREATEVALUE	=	'" . $this->strict($_GET ['leafAccessCreateValue'] [$i], 'numeric') . "',
						LEAFACCESSREADVALUE		=	'" . $this->strict($_GET ['leafAccessReadValue'] [$i], 'numeric') . "',
						LEAFACCESSUPDATEVALUE	=	'" . $this->strict($_GET ['leafAccessUpdateValue'] [$i], 'numeric') . "',
						LEAFACCESSDELETEVALUE	=	'" . $this->strict($_GET ['leafAccessDeleteValue'] [$i], 'numeric') . "',
						LEAFACCESSDRAFTVALUE	=	'" . $this->strict($_GET ['leafAccessDeleteValue'] [$i], 'numeric') . "',
						LEAFACCESSPRINTVALUE	=	'" . $this->strict($_GET ['leafAccessPrintValue'] [$i], 'numeric') . "',
						LEAFACCESSPOSTVALUE		=	'" . $this->strict($_GET ['leafAccessPostValue'] [$i], 'numeric') . "'
				WHERE 	LEAFACCESSID			=	'" . $this->strict($_GET ['leafAccessId'] [$i], 'numeric') . "'";
			}
			$this->q->update($sql);
		}
		if ($this->q->execute == 'fail') {

			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		} else {
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode(array("success" => true, "message" => $this->system->getUpdateMessage(),"time"=>$time));
			exit();
		}
	}

	/* (non-PHPdoc)
	 * @see config::delete()
	 */

	function delete() {

	}

	function firstRecord($value) {
		$this->recordSet->firstRecord($value);
	}

	function nextRecord($value, $primaryKeyValue) {
		$this->recordSet->nextRecord($value, $primaryKeyValue);
	}

	function previousRecord($value, $primaryKeyValue) {
		$this->recordSet->previousRecord($value, $primaryKeyValue);
	}

	function lastRecord($value) {
		$this->recordSet->lastRecord($value);
	}

	/* (non-PHPdoc)
	 * @see config::excel()
	 */

	function excel() {

	}

}

$leafAccessObject = new LeafAccessClass ();

if (isset($_POST ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST ['leafId'])) {
		$leafAccessObject->setLeafId($_POST ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$leafAccessObject->setIsAdmin($_POST ['isAdmin']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$leafAccessObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$leafAccessObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Load the dynamic value
	 */
	$leafAccessObject->execute();
	/*
	 *  Crud Operation
	 */
	if ($_POST ['method'] == 'read') {
		$leafAccessObject->read();
	}
}
// crud -create,read,update,delete.
if (isset($_GET ['method'])) {

	/*
	 *  Initilize Value before load in the loader
	 */

	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_GET ['leafId'])) {
		$leafAccessObject->setLeafId($_GET ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET ['isAdmin'])) {
		$leafAccessObject->setIsAdmin($_GET ['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$leafAccessObject->execute();

	if ($_GET ['method'] == 'update') {
		$leafAccessObject->update();
	}
	if (isset($_GET ['field'])) {
		if ($_GET ['field'] == 'staffId') {
			$leafAccessObject->staff();
		}
		if ($_GET ['field'] == 'teamId') {
			$leafAccessObject->team();
		}
		if ($_GET ['field'] == 'moduleId') {
			$leafAccessObject->module();
		}
		if ($_GET ['field'] == 'folderId') {
			$leafAccessObject->folder();
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$leafAccessObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$leafAccessObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$leafAccessObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$leafAccessObject->lastRecord('json');
		}
	}
}
?>
