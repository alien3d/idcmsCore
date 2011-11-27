<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSecurity.php");
require_once ("../../class/classSystemString.php");
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
	 * System String Message.
	 * @var string $systemString;
	 */
	public $systemString;
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

		$this->systemString = new SystemString();
		$this->systemString->setVendor($this->getVendor());
		$this->systemString->setLeafId($this->getLeafId());
		$this->systemString->execute();

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
		$items= array();
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
						 (CASE `leafAccess`.`leafAccessDraftValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessDraftValue`,
						
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

						 (CASE `leafAccess`.`leafAccessReviewValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessReviewValue`,
						(CASE `leafAccess`.`leafAccessApprovedValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessApprovedValue`,

						(CASE `leafAccess`.`leafAccessPostValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessPostValue`,
						(CASE `leafAccess`.`leafAccessPrintValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessPrintValue`
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
						(CASE [leafAccess].[leafAccessDraftValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessDraftValue], 
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
						(CASE [leafAccess].[leafAccessReviewValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessReviewValue],
						(CASE [leafAccess].[leafAccessApprovedValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessApprovedValue],

						(CASE [leafAccess].[leafAccessPostValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessPostValue],
						(CASE [leafAccess].[leafAccessPrintValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessPrintValue]
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
						(CASE LEAFACCESS.LEAFACCESSDRAFTVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafAccessDraftValue\",
						 (CASE LEAFACCESS.LEAFACCESSCREATEVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafAccessCreateValue\",


						 (CASE LEAFACCESS.lEAFACCESSREADVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafAccessReadValue\",

						(CASE LEAFACCESS.LEAFACCESSUPDATEVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafAccessUpdateValue\",

						(CASE LEAFACCESS.LEAFACCESSDELETEVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafAccessDeleteValue\",

						(CASE LEAFACCESS.LEAFACCESSAPPROVEDVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafAccessApprovedValue\",

						(CASE LEAFACCESS.LEAFACCESSPOSTVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafAcessPostValue\",
							(CASE LEAFACCESS.LEAFACCESSPRINTVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafAccessPrintValue\"
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
			echo json_encode(array("success" => false, "message" => $this->q->responce));
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
		$end = microtime(true);
		$time = $end - $start;
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
		$loop = $this->model->getTotal();

		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			UPDATE `" . $this->model->getTableName() . "`
			SET";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			UPDATE 	[" . $this->model->getTableName() . "]
			SET 	";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		$access = array(
						"leafAccessDraftValue", 
						"leafAccessCreateValue",
		                "leafAccessReadValue", 
		                "leafAccessUpdateValue", 
		                "leafAccessDeleteValue", 
		                "leafAccessReviewValue", 
		                "leafAccessApprovedValue", 		           
		                "leafAccessReviewValue", 
		                "leafAccessPostValue",
						"leafAccessPrintValue"	);
		$sqlLooping='';
		foreach ($access as $systemCheck) {

			switch ($systemCheck) {
				case 'leafAccessDraftValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getLeafAccessDraftValue($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getLeafAccessId($i, 'array') . "'
							THEN '" . $this->model->getLeafAccessDraftValue($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafAccessCreateValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getLeafAccessCreateValue($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getLeafAccessId($i, 'array') . "'
							THEN '" . $this->model->getLeafAccessCreateValue($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafAccessReadValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getLeafAccessReadValue($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getLeafAccessId($i, 'array') . "'
							THEN '" . $this->model->getLeafAccessReadValue($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafAccessUpdateValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getLeafAccessUpdateValue($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();

							}
							$sqlLooping .= "
							WHEN '" . $this->model->getLeafAccessId($i, 'array') . "'
							THEN '" . $this->model->getLeafAccessUpdateValue($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafAccessDeleteValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getLeafAccessDeleteValue($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getLeafAccessId($i, 'array') . "'
							THEN '" . $this->model->getLeafAccessDeleteValue($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafAccessReviewValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getLeafAccessReviewValue($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getLeafAccessId($i, 'array') . "'
							THEN '" . $this->model->getLeafAccessReviewValue($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafAccessApprovedValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getLeafAccessApprovedValue($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getLeafAccessId($i, 'array') . "'
							THEN '" . $this->model->getLeafAccessApprovedValue($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				
					case 'leafAccessPostValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getLeafAccessPostValue($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
                                WHEN '" . $this->model->getLeafAccessId($i, 'array') . "'
                                THEN '" . $this->model->getLeafAccessPostValue($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
					case 'leafAccessPrintValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getLeafAccessPrintValue($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
                                WHEN '" . $this->model->getLeafAccessId($i, 'array') . "'
                                THEN '" . $this->model->getLeafAccessPrintValue($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
			}
		}
		$sql .= substr($sqlLooping, 0, - 1);
		if ($this->getVendor() == self::MYSQL) {
			$sql .= "
			WHERE `" . $this->model->getPrimaryKeyName() . "` IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql .= "
			WHERE [" . $this->model->getPrimaryKeyName() . "] IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "  IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::DB2) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "  IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "  IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();

		$message = $this->systemString->getUpdateMessage();

		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array("success" => true,
			      "message" => $this->systemString->getUpdateMessage(),
				  "time"=>$time,
				  "sql"=>$sql				
		));
		exit();
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
