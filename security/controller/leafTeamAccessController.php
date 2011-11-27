<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSecurity.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/leafTeamAccessModel.php");

/**
 * this is  leaf security access
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @package Leaf Group Access Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LeafTeamAccessClass extends ConfigClass {

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
	 * Common class function for security menu
	 * @var  string
	 */
	private $security;

	/**
	 * Class Loader
	 */
	function execute() {
		// audit property
		$this->audit = 0;
		$this->log = 1;

		$this->model = new LeafTeamAccessModel ();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor();
		$this->q->leafId = $this->getLeafId();
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
		$items = array();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
				SELECT	`leaf`.`moduleId`,
						`leaf`.`folderId`,
						`folder`.`folderEnglish`,
						`leaf`.`leafEnglish`,
						`module`.`moduleEnglish`,
						`team`.`teamEnglish`,
						`leafTeamAccess`.`leafId`,
						`leafTeamAccess`.`teamId`,
						`leafTeamAccess`.`leafTeamAccessId`,
						(CASE `leafTeamAccess`.`leafTeamAccessCreateValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafTeamAccessCreateValue`,


						(CASE `leafTeamAccess`.`leafTeamAccessReadValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafTeamAccessReadValue`,

						(CASE `leafTeamAccess`.`leafTeamAccessUpdateValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafTeamAccessUpdateValue`,

						(CASE `leafTeamAccess`.`leafTeamAccessDeleteValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafTeamAccessDeleteValue` ,

						(CASE `leafTeamAccess`.`leafTeamAccessPrintValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafTeamAccessPrintValue`,

						(CASE `leafTeamAccess`.`leafTeamAccessPostValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafTeamAccessPostValue`
				FROM 	`leafTeamAccess`
				JOIN	`leaf`
				USING	(`leafId`)
				JOIN	(`module`)
				USING	(`moduleId`)
				JOIN	(`folder`)
				USING	(`folderId`)
				JOIN	`team`
				USING	(`teamId`)
				WHERE 	`leaf`.`isActive`		=	1
				AND		`folder`.`isActive`		=	1
				AND		`module`.`isActive`		=	1
				AND		`team`.`isActive`		=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND `leafTeamAccess`.`teamId`='" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getModuleId()) {
				$sql .= " AND `leaf`.`moduleId`='" . $this->model->getModuleId() . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND `leaf`.`folderId`='" . $this->model->getFolderId() . "'";
			}
			if ($this->model->getLeafId()) {
				$sql.= " AND `leaf`.`leafId`='" . $this->model->getLeafId() . "'";
			}

		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
				SELECT	[leaf].[moduleId],
						[leaf].[folderId],
						[folder].[folderEnglish],
						[leaf].[leafEnglish],
						[module].[moduleEnglish],
						[team].[teamEnglish],
						[leafTeamAccess].[leafId],
						[leafTeamAccess].[teamId],
						[leafTeamAccess].[leafTeamAccessId],
						(CASE [leafTeamAccess].[leafTeamAccessCreateValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafTeamAccessCreateValue],


						(CASE [leafTeamAccess].[leafTeamAccessReadValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafTeamAccessReadValue],

						(CASE [leafTeamAccess].[leafTeamAccessUpdateValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafTeamAccessUpdateValue],

						(CASE [leafTeamAccess].[leafTeamAccessDeleteValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafTeamAccessDeleteValue] ,

						(CASE [leafTeamAccess].[leafTeamAccessPrintValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafTeamAccessPrintValue],

						(CASE [leafTeamAccess].[leafTeamAccessPostValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafTeamAccessPostValue]
				FROM 	[leafTeamAccess]
				JOIN	[leaf]
				ON		[leafTeamAccess].[leafId]=[leaf].[leafId]
				JOIN	[module]
				ON		[leaf].[moduleId]=[module].[moduleId]
				JOIN	[folder]
				ON		[leaf].[folderId] = [folder].[folderId]
				JOIN	[team]
				ON		[leafTeamAccess].[teamId]= [team].[teamId]
				WHERE 	[leaf].[isActive]		=	1
				AND		[folder].[isActive]		=	1
				AND		[module].[isActive]	=	1
				AND		[team].[isActive]		=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND [leafTeamAccess].[teamId]='" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getModuleId()) {
				$sql .= " AND [leaf].[moduleId]='" . $this->model->getModuleId() . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND [leaf].[folderId]='" . $this->model->getFolderId() . "'";
			}
			if ($this->model->getLeafId()) {
				$sql.= " AND [leaf].[leafId]='" . $this->model->getLeafId() . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
				SELECT	LEAF.MODULEID,
						LEAF.FOLDERID,
						FOLDER.FOLDERENGLISH,
						LEAF.LEAFNOTE,
						MODULE.MODULEENGLISH,
						TEAM.TEAMENGLISH,
						LEAFTEAMACCESS.LEAFID,
						LEAFTEAMACCESS.TEAMID,
						LEAFTEAMACCESS.LEAFTEAMACCESSID,
						(CASE LEAFTEAMACCESS.LEAFTEAMACCESSCREATEVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafTeamAccessCreateValue,


						(CASE LEAFTEAMACCESS.LEAFTEAMACCESSREADVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafTeamAccessReadValue,

						(CASE LEAFTEAMACCESS.LEAFTEAMUPDATECREATEVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafTeamAccessUpdateValue,

						(CASE LEAFTEAMACCESS.LEAFTEAMACCESSDELETEVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafTeamAccessDeleteValue ,

						(CASE LEAFTEAMACCESS.LEAFTEAMACCESSPRINTVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafTeamAccessPrintValue,

						(CASE LEAFTEAMACCESS.LEAFTEAMACCESSPRINTVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafTeamAccessPostValue
				FROM 	LEAFTEAMACCESS
				JOIN	LEAF
				USING	(LEAFID)
				JOIN	(MODULE)
				USING	(MODULEID)
				JOIN	(FOLDER)
				USING	(FOLDERID)
				JOIN	TEAM
				USING	(TEAMID)
				WHERE 	LEAF.ISACTIVE		=	1
				AND		FOLDER.ISACTIVE		=	1
				AND		MODULE.ISACTIVE	=	1
				AND		TEAM.ISACTIVE		=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND LEAFTEAMACCESS.TEAMID='" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getModuleId()) {
				$sql .= " AND LEAF.MODULEID='" . $this->model->getModuleId() . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND LEAF.FOLDERID='" . $this->model->getFolderId() . "'";
			}
			if ($this->model->getLeafIdTemp() && $this->model->getLeafId()) {
				$sql.= " AND LEAF.LEAFID='" . $this->model->getLeafId() . "'";
			}
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	LEAF.MODULEID,
			LEAF.FOLDERID,
			FOLDER.FOLDERENGLISH,
			LEAF.LEAFNOTE,
			MODULE.MODULEENGLISH,
			TEAM.TEAMENGLISH,
			LEAFTEAMACCESS.LEAFID,
			LEAFTEAMACCESS.TEAMID,
			LEAFTEAMACCESS.LEAFTEAMACCESSID,
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSCREATEVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessCreateValue,
			
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSREADVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessReadValue,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMUPDATECREATEVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessUpdateValue,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSDELETEVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessDeleteValue ,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSPRINTVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessPrintValue,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSPRINTVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessPostValue
			FROM 	LEAFTEAMACCESS
			JOIN	LEAF
			USING	(LEAFID)
			JOIN	(MODULE)
			USING	(MODULEID)
			JOIN	(FOLDER)
			USING	(FOLDERID)
			JOIN	TEAM
			USING	(TEAMID)
			WHERE 	LEAF.ISACTIVE		=	1
			AND		FOLDER.ISACTIVE		=	1
			AND		MODULE.ISACTIVE	=	1
			AND		TEAM.ISACTIVE		=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND LEAFTEAMACCESS.TEAMID='" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getModuleId()) {
				$sql .= " AND LEAF.MODULEID='" . $this->model->getModuleId() . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND LEAF.FOLDERID='" . $this->model->getFolderId() . "'";
			}
			if ($this->model->getLeafId()) {
				$sql.= " AND LEAF.LEAFID='" . $this->model->getLeafId() . "'";
			}
		} elseif ($this->model->getLeafIdTemp() && $this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	LEAF.MODULEID,
			LEAF.FOLDERID,
			FOLDER.FOLDERENGLISH,
			LEAF.LEAFNOTE,
			MODULE.MODULEENGLISH,
			TEAM.TEAMENGLISH,
			LEAFTEAMACCESS.LEAFID,
			LEAFTEAMACCESS.TEAMID,
			LEAFTEAMACCESS.LEAFTEAMACCESSID,
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSCREATEVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessCreateValue,
			
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSREADVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessReadValue,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMUPDATECREATEVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessUpdateValue,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSDELETEVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessDeleteValue ,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSPRINTVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessPrintValue,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSPRINTVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessPostValue
			FROM 	LEAFTEAMACCESS
			JOIN	LEAF
			USING	(LEAFID)
			JOIN	(MODULE)
			USING	(MODULEID)
			JOIN	(FOLDER)
			USING	(FOLDERID)
			JOIN	TEAM
			USING	(TEAMID)
			WHERE 	LEAF.ISACTIVE		=	1
			AND		FOLDER.ISACTIVE		=	1
			AND		MODULE.ISACTIVE	=	1
			AND		TEAM.ISACTIVE		=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND LEAFTEAMACCESS.TEAMID='" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getModuleId()) {
				$sql .= " AND LEAF.MODULEID='" . $this->model->getModuleId() . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND LEAF.FOLDERID='" . $this->model->getFolderId() . "'";
			}
			if ($this->model->getLeafIdTemp() &&  $this->model->getLeafId()) {
				$sql.= " AND LEAF.LEAFID='" . $this->model->getLeafId() . "'";
			}
		}
		//echo $sql;
		// searching filtering
		$sql .= $this->q->searching();
		$record_all = $this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->total = $this->q->numberRows();
		//paging
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$items = array();
		while (($row = $this->q->fetchAssoc()) == TRUE) {
			// select module access
			$items [] = $row;

			// select module access
		}
		if (count($items) == 0) {
			$items = '';
		}
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array(	'success' => true,
					'total' => $this->total, 
					'time' => $time, 
            		'firstRecord' => $this->recordSet->firstRecord('value'), 
            		'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getLeafTeamAccessId(0, 'single')), 
            		'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getLeafTeamAccessId(0, 'single')), 
            		'lastRecord' => $this->recordSet->lastRecord('value'),
					'data' => $items));
		exit();
	}

	function update() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$total = $this->model->getTotal();

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
		$access = array("leafTeamAccessDefaultValue",
		                "leafTeamAccessNewValue", 
		                "leafTeamAccessDraftValue", 
		                "leafTeamAccessUpdateValue", 
		                "leafTeamAccessDeleteValue", 
		                "leafTeamAccessActiveValue", 
		                "leafTeamAccessApprovedValue", 
		                "leafTeamAccessReviewValue", 
		                "leafTeamAccessPostValue");
		foreach ($access as $systemCheck) {

			switch ($systemCheck) {
				case 'leafTeamAccessDefaultValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDefault($i, 'array')) > 0) {
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
							WHEN '" . $this->model->getLeafTeamAccessId($i, 'array') . "'
							THEN '" . $this->model->getIsDefault($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafTeamAccessNewValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsNew($i, 'array')) > 0) {
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
							WHEN '" . $this->model->getLeafTeamAccessId($i, 'array') . "'
							THEN '" . $this->model->getIsNew($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafTeamAccessDraftValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDraft($i, 'array')) > 0) {
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
							WHEN '" . $this->model->getLeafTeamAccessId($i, 'array') . "'
							THEN '" . $this->model->getIsDraft($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafTeamAccessUpdateValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsUpdate($i, 'array')) > 0) {
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
							WHEN '" . $this->model->getLeafTeamAccessId($i, 'array') . "'
							THEN '" . $this->model->getIsUpdate($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafTeamAccessDeleteValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDelete($i, 'array')) > 0) {
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
							WHEN '" . $this->model->getLeafTeamAccessId($i, 'array') . "'
							THEN '" . $this->model->getIsDelete($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafTeamAccessActiveValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsActive($i, 'array')) > 0) {
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
							WHEN '" . $this->model->getLeafTeamAccessId($i, 'array') . "'
							THEN '" . $this->model->getIsActive($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafTeamAccessApprovedValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsApproved($i, 'array')) > 0) {
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
							WHEN '" . $this->model->getLeafTeamAccessId($i, 'array') . "'
							THEN '" . $this->model->getIsApproved($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafTeamAccessReviewValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsReview($i, 'array')) > 0) {
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
                            WHEN '" . $this->model->getLeafTeamAccessId($i, 'array') . "'
                            THEN '" . $this->model->getIsReview($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'leafTeamAccessPostValue' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsPost($i, 'array')) > 0) {
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
                                WHEN '" . $this->model->getLeafTeamAccessId($i, 'array') . "'
                                THEN '" . $this->model->getIsPost($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
			}
		}
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array("success" => true,
			      "message" => $this->systemString->getUpdateMessage(),
				  "time"=>$time				
		));
		exit();
	}

	/* (non-PHPdoc)
	 * @see config::delete()
	 */

	function delete() {

	}

	/**
	 * Team Information
	 */
	function team() {
		$this->security->team();
	}

	/**
	 * Module Information
	 */
	function module() {
		$this->security->module($this->model->getType(), $this->model->getTeamId());
	}

	/**
	 * Folder Information
	 */
	function folder() {
		$this->security->folder($this->model->getType(), $this->model->getTeamId(), $this->model->getModuleId());
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

$leafTeamAccessObject = new LeafTeamAccessClass ();
// crud -create,read,update,delete.
if (isset($_POST ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST ['leafId'])) {
		$leafTeamAccessObject->setleafId($_POST ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$leafTeamAccessObject->setIsAdmin($_POST ['isAdmin']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$leafTeamAccessObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$leafTeamAccessObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Load the dynamic value
	 */
	$leafTeamAccessObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'read') {
		$leafTeamAccessObject->read();
	}
}
if (isset($_GET ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_GET ['leafId'])) {
		$leafTeamAccessObject->setLeafId($_GET ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET ['isAdmin'])) {
		$leafTeamAccessObject->setIsAdmin($_GET ['isAdmin']);
	}
	/*
	 *
	 *  Load the dynamic value
	 */
	$leafTeamAccessObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_GET ['method'] == 'update') {
		$leafTeamAccessObject->update();
	}
	if (isset($_GET ['field'])) {
		if ($_GET ['field'] == 'staffId') {
			$leafTeamAccessObject->staff();
		}
		if ($_GET ['field'] == 'teamId') {
			$leafTeamAccessObject->team();
		}
		if ($_GET ['field'] == 'moduleId') {
			$leafTeamAccessObject->module();
		}
		if ($_GET ['field'] == 'folderId') {
			$leafTeamAccessObject->folder();
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$leafTeamAccessObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$leafTeamAccessObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$leafTeamAccessObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$leafTeamAccessObject->lastRecord('json');
		}
		
	}
}
?>
