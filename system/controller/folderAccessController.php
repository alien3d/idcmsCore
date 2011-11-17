<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSecurity.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/folderAccessModel.php");

/**
 * this is  folder security access
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @subpackage Folder Security Access Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class FolderAccessClass extends ConfigClass {

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
	/*
	 * @var  string $security
	 */
	private $security;

	/**
	 * Class Loader
	 */
	function execute() {
		parent::__construct();
		// audit property
		$this->audit = 0;
		$this->log = 1;

		$this->model = new FolderAccessModel ();
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

	function create() {

	}

	function read() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		$items = array();
		if ($this->getVendor() == self::MYSQL) {
				
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$items= array();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
				SELECT	`module`.`moduleEnglish`,
						`module`.`moduleId`,
						`folder`.`folderId`,
						`folder`.`folderEnglish`,
						`team`.`teamId`,
						`team`.`teamEnglish`,
						`folderAccess`.`folderAccessId`,
						(CASE `folderAccess`.`folderAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `folderAccessValue`
				FROM 	`folderAccess`
				JOIN	`folder`
				USING 	(`folderId`)
				JOIN 	`team`
				USING 	(`teamId`)
				JOIN 	`module`
				USING	(`moduleId`)
				WHERE 	`module`.`isActive` =1
				AND		`folder`.`isActive`=1
				AND		`team`.`isActive` =1";
			if ($this->model->getTeamId()) {
				$sql .= " AND `team`.`teamId`='" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getModuleId()) {
				$sql .= " AND `folder`.`moduleId`='" . $this->model->getModuleId() . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND `folder`.`folderId`='" . $this->model->getFolderId() . "'";
			}
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
				SELECT	[module].[moduleEnglish],
						[module].[moduleId],
						[folder].[folderId],
						[folder].[folderEnglish],
						[team].[teamId],
						[team].[teamEnglish],
						[folderAccess].[folderAccessId],
						(CASE [folderAccess].[folderAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [folderAccessValue]
				FROM 	[folderAccess]
				JOIN	[folder]
				ON 		[folder].[folderId]=[folderAccess].[folderId]
				JOIN 	[team]
				ON 		[team].[teamId]=[folderAccess].[teamId]
				JOIN 	[module]
				ON		[folder].[moduleId]=[module].[moduleId]
				WHERE 	[folder].[isActive]=1
				AND		[team].[isActive]=1
				AND		[module].[moduleId]=1";
			if ($this->model->getTeamId()) {
				$sql .= " AND [team].[teamId]='" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getModuleId()) {
				$sql .= " AND [folder].[moduleId]='" . $this->model->getModuleId() . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
				SELECT	MODULE.MODULEENGLISH 			AS	\"moduleEnglish\",
						MODULE.MODULEID 				AS 	\"moduleId\",
						FOLDER.FOLDERID 				AS 	\"folderId\",
						FOLDER.FOLDERENGLISH 			AS 	\"folderEnglish\",
						TEAM.TEAMID 					AS 	\"teamId\",
						TEAM.TEAMENGLISH 				AS 	\"teamEnglish\",
						FOLDERACCESS.FOLDERACCESSID 	AS 	\"folderAccessId\",
						(CASE	FOLDERACCESS.FOLDERACCESSVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"folderAccessValue\"
				FROM 	FOLDERACCESS
				JOIN	FOLDER
				ON		FOLDER.FOLDERID		=	FOLDERACCESS.FOLDERID
				JOIN 	TEAM
				ON		TEAM.TEAMID		=	FOLDERACCESS.TEAMID
				JOIN 	MODULE
				ON		MODULE.MODULEID		=	FOLDER.MODULEID
				WHERE 	FOLDER.ISACTIVE		=	1
				AND		MODULE.ISACTIVE		=	1
				AND		TEAM.ISACTIVE		=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND TEAM.TEAMID='" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getModuleId()) {
				$sql .= " AND FOLDER.MODULEID='" . $this->model->getModuleId() . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND `folder`.`folderId`='" . $this->model->getFolderId() . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
				SELECT	MODULE.MODULEENGLISH 			AS	\"moduleEnglish\",
						MODULE.MODULEID 				AS 	\"moduleId\",
						FOLDER.FOLDERID 				AS 	\"folderId\",
						FOLDER.FOLDERENGLISH 			AS 	\"folderEnglish\",
						TEAM.TEAMID 					AS 	\"teamId\",
						TEAM.TEAMENGLISH 				AS 	\"teamEnglish\",
						FOLDERACCESS.FOLDERACCESSID 	AS 	\"folderAccessId\",
						(CASE	FOLDERACCESS.FOLDERACCESSVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"folderAccessValue\"
				FROM 	FOLDERACCESS
				JOIN	FOLDER
				ON		FOLDER.FOLDERID		=	FOLDERACCESS.FOLDERID
				JOIN 	TEAM
				ON		TEAM.TEAMID		=	FOLDERACCESS.TEAMID
				JOIN 	MODULE
				ON		MODULE.MODULEID		=	FOLDER.MODULEID
				WHERE 	FOLDER.ISACTIVE		=	1
				AND		MODULE.ISACTIVE		=	1
				AND		TEAM.ISACTIVE		=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND TEAM.TEAMID='" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getModuleId()) {
				$sql .= " AND FOLDER.MODULEID='" . $this->model->getModuleId() . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND `folder`.`folderId`='" . $this->model->getFolderId() . "'";
			}
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
				SELECT	MODULE.MODULEENGLISH 			AS	\"moduleEnglish\",
						MODULE.MODULEID 				AS 	\"moduleId\",
						FOLDER.FOLDERID 				AS 	\"folderId\",
						FOLDER.FOLDERENGLISH 			AS 	\"folderEnglish\",
						TEAM.TEAMID 					AS 	\"teamId\",
						TEAM.TEAMENGLISH 				AS 	\"teamEnglish\",
						FOLDERACCESS.FOLDERACCESSID 	AS 	\"folderAccessId\",
						(CASE	FOLDERACCESS.FOLDERACCESSVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"folderAccessValue\"
				FROM 	FOLDERACCESS
				JOIN	FOLDER
				ON		FOLDER.FOLDERID		=	FOLDERACCESS.FOLDERID
				JOIN 	TEAM
				ON		TEAM.TEAMID		=	FOLDERACCESS.TEAMID
				JOIN 	MODULE
				ON		MODULE.MODULEID		=	FOLDER.MODULEID
				WHERE 	FOLDER.ISACTIVE		=	1
				AND		MODULE.ISACTIVE		=	1
				AND		TEAM.ISACTIVE		=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND TEAM.TEAMID='" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getModuleId()) {
				$sql .= " AND FOLDER.MODULEID='" . $this->model->getModuleId() . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND `folder`.`folderId`='" . $this->model->getFolderId() . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
				SELECT	MODULE.MODULEENGLISH 			AS	\"moduleEnglish\",
						MODULE.MODULEID 				AS 	\"moduleId\",
						FOLDER.FOLDERID 				AS 	\"folderId\",
						FOLDER.FOLDERENGLISH 			AS 	\"folderEnglish\",
						TEAM.TEAMID 					AS 	\"teamId\",
						TEAM.TEAMENGLISH 				AS 	\"teamEnglish\",
						FOLDERACCESS.FOLDERACCESSID 	AS 	\"folderAccessId\",
						(CASE	FOLDERACCESS.FOLDERACCESSVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"folderAccessValue\"
				FROM 	FOLDERACCESS
				JOIN	FOLDER
				ON		FOLDER.FOLDERID		=	FOLDERACCESS.FOLDERID
				JOIN 	TEAM
				ON		TEAM.TEAMID		=	FOLDERACCESS.TEAMID
				JOIN 	MODULE
				ON		MODULE.MODULEID		=	FOLDER.MODULEID
				WHERE 	FOLDER.ISACTIVE		=	1
				AND		MODULE.ISACTIVE		=	1
				AND		TEAM.ISACTIVE		=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND TEAM.TEAMID='" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getModuleId()) {
				$sql .= " AND FOLDER.MODULEID='" . $this->model->getModuleId() . "'";
			}
			if ($this->model->getFolderId()) {
				$sql .= " AND `folder`.`folderId`='" . $this->model->getFolderId() . "'";
			}
		}

		$sql .= $this->q->searching();
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$total = 0; //assign as number
		$total = $this->q->numberRows();
		//paging
		if ($this->getOrder() && $this->getSortField()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . "  " . strtoupper($this->getOrder()) . " ";
			}
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		while (($row = $this->q->fetchAssoc()) == true) {
			$items [] = $row;
		}
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array(	'success' => true,
					'total' => $total, 
					'time'=>$time, 
            		'firstRecord' => $this->recordSet->firstRecord('value'), 
            		'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getFolderAccessId(0, 'single')), 
            		'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getFolderAccessId(0, 'single')), 
            		'lastRecord' => $this->recordSet->lastRecord('value'),
					'data' => $items));
	}

	/* (non-PHPdoc)
	 * @see config::update()
	 */

	function update() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->q->vendor == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->update();
		$loop = $this->model->getTotal();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			UPDATE 	`" . $this->model->getTableName() . "`
			SET     `folderAccessValue`			=	case `" . $this->model->getPrimaryKeyName() . "` ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			UPDATE 	[" . $this->model->getTableName() . "]
			SET     [folderAccessValue]			=	case [" . $this->model->getPrimaryKeyName() . "] ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			UPDATE 	" . strtoupper($this->model->getTableName()) . "
			SET     FOLDERACCESSVALUE			=	case " . strtoupper($this->model->getPrimaryKeyName()) . " ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			UPDATE 	" . strtoupper($this->model->getTableName()) . "
			SET     FOLDERACCESSVALUE			=	case " . strtoupper($this->model->getPrimaryKeyName()) . " ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			UPDATE 	" . strtoupper($this->model->getTableName()) . "
			SET     FOLDERACCESSVALUE			=	case " . strtoupper($this->model->getPrimaryKeyName()) . " ";
		}
		for ($i = 0; $i < $loop; $i++) {
			$sql .= "
				WHEN '" . $this->model->getFolderAccessId($i, 'array') . "'
				THEN '" . $this->model->getFolderAccessValue($i, 'array') . "'";
		}
		$sql .= "	END ";
		if ($this->getVendor() == self::MYSQL) {
			$sql .= " WHERE 	`" . $this->model->getPrimaryKeyName() . "`		IN	(" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql .= " WHERE 	[" . $this->model->getPrimaryKeyName() . "]		IN	(" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql .= " WHERE 	" . strtoupper($this->model->getPrimaryKeyName()) . "		IN	(" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::DB2) {
			$sql .= " WHERE 	" . strtoupper($this->model->getPrimaryKeyName()) . "		IN	(" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql .= " WHERE 	" . strtoupper($this->model->getPrimaryKeyName()) . "		IN	(" . $this->model->getPrimaryKeyAll() . ")";
		} else {

		}

		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array(	"success" => true,
					"message" => $this->systemString->getUpdateMessage(),
					"time"=>$time));
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

$folderAccessObject = new FolderAccessClass ();
if (isset($_POST ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST ['leafId'])) {
		$folderAccessObject->setLeafId($_POST ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$folderAccessObject->setIsAdmin($_POST ['isAdmin']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$folderAccessObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$folderAccessObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$religionObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$religionObject->setLimit($_POST ['perPage']);
	}
	/*
	 * Filtering
	 */
	if (isset($_POST ['query'])) {
		$folderAccessObject->setFieldQuery($_POST ['query']);
	}
	if (isset($_POST ['filter'])) {
		$folderAccessObject->setGridQuery($_POST ['filter']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST ['order'])) {
		$folderAccessObject->setOrder($_POST ['order']);
	}
	if (isset($_POST ['sortField'])) {
		$folderAccessObject->setSortField($_POST ['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$folderAccessObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'read') {
		$folderAccessObject->read();
	}
}
if (isset($_GET ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_GET ['method'])) {
		$folderAccessObject->setleafId($_GET ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET ['isAdmin'])) {
		$folderAccessObject->setIsAdmin($_GET ['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$folderAccessObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_GET ['method'] == 'update') {
		$folderAccessObject->update();
	}
	if (isset($_GET ['field'])) {
		if($_GET['field'] == 'staffId') {
			$folderAccessObject->staff();
		}
		if ($_GET ['field'] == 'teamId') {
			$folderAccessObject->team();
		}
		if ($_GET ['field'] == 'moduleId') {
			$folderAccessObject->module();
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$folderAccessObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$folderAccessObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$folderAccessObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$folderAccessObject->lastRecord('json');
		}
	}
	/*
	 *  Excel Reporing
	 */
	if (isset($_GET ['mode'])) {
		if ($_GET ['mode'] == 'excel') {
			$folderAccessObject->excel();
		}
	}
}
?>
