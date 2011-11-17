<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSecurity.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/applicationAccessModel.php");

/**
 * this is application security access
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @package Application Security Access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ApplicationAccessClass extends ConfigClass {

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
	 *  Record Pagination
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
	 * Duplicate Testing either the key of applicationle same or have been created.
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
		parent::__construct();
		// audit property
		$this->audit = 0;
		$this->log = 1;

		$this->model = new ApplicationAccessModel ();
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
		$items= array();
		// by default if add new group will add access to application and folder.
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
				SELECT	`applicationAccess`.`applicationAccessId`,
						`application`.`applicationId`,
						`application`.`applicationEnglish`,
						`team`.`teamId`,
						`team`.`teamEnglish`,
						(CASE `applicationAccess`.`applicationAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `applicationAccessValue`
				FROM 	`applicationAccess`
				JOIN	`application`
				USING 	(`applicationId`)
				JOIN 	`team`
				USING 	(`teamId`)
				WHERE 	`application`.`isActive` 	=	1
				AND		`team`.`isActive`		=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND `team`.`teamId`='" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getApplicationId()) {
				$sql .= " AND application.applicationId='" . $this->model->getApplicationId() . "'";
			}
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
				SELECT	[applicationAccess].[applicationAccessId],
						[application].[applicationId],
						[application].[applicationEnglish],
						[team].[teamId],
						[team].[teamEnglish],
						(CASE [applicationAccess].[applicationAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [applicationAccessValue]
				FROM 	[applicationAccess]
				JOIN	[application]
				ON		[applicationAccess].[applicationId] 	= 	[application].[applicationId]
				JOIN 	[team]
				on		[team].[teamId]  			= 	[applicationAccess].[teamId]
				WHERE 	[application].[isActive] 		=	1
				AND		[team].[isActive]			=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND [team].[teamId]		=	'" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getApplicationId()) {
				$sql .= " AND [application].[applicationId]='" . $this->model->getApplicationId() . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
				SELECT	APPLICATIONACCESS.APPLICATIONACCESSID AS \"applicationAccessId\",
						APPLICATION.APPLICATIONID AS \"applicationId\",
						APPLICATION.APPLICATIONENGLISH AS \"applicationEnglish\",
						TEAM.TEAMID AS\"teamId\",
						TEAM.TEAMNOTE AS \"teamNote\",
						(CASE APPLICATIONACCESS.APPLICATIONACCESSVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"applicationAccessValue\"
				FROM 	APPLICATIONACCESS
				JOIN	APPLICATION
				ON		APPLICATIONACCESS.APPLICATIONID 	= 	APPLICATION.APPLICATIONID
				JOIN 	TEAM
				ON		APPLICATIONACCESS.TEAMID 	= 	TEAM.TEAMID
				WHERE 	APPLICATION.ISACTIVE 		=	1
				AND		TEAM.ISACTIVE			=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND	TEAM.TEAMID	=	'" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getApplicationeId()) {
				$sql .= " AND	APPLICATION.APPLICATIONID='" . $this->model->getApplicationeId() . "'";
			}
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
				SELECT	APPLICATIONACCESS.APPLICATIONACCESSID AS \"applicationAccessId\",
						APPLICATION.APPLICATIONID AS \"applicationId\",
						APPLICATION.APPLICATIONENGLISH AS \"applicationEnglish\",
						TEAM.TEAMID AS\"teamId\",
						TEAM.TEAMNOTE AS \"teamNote\",
						(CASE APPLICATIONACCESS.APPLICATIONACCESSVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"applicationAccessValue\"
				FROM 	APPLICATIONACCESS
				JOIN	APPLICATION
				ON		APPLICATIONACCESS.APPLICATIONID 	= 	APPLICATION.APPLICATIONID
				JOIN 	TEAM
				ON		APPLICATIONACCESS.TEAMID 	= 	TEAM.TEAMID
				WHERE 	APPLICATION.ISACTIVE 		=	1
				AND		TEAM.ISACTIVE			=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND	TEAM.TEAMID	=	'" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getApplicationId()) {
				$sql .= " AND APPLICATION.APPLICATIONID='" . $this->model->getApplicationId() . "'";
			}
		}else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
				SELECT	APPLICATIONACCESS.APPLICATIONACCESSID AS \"applicationAccessId\",
						APPLICATION.APPLICATIONID AS \"applicationId\",
						APPLICATION.APPLICATIONENGLISH AS \"applicationEnglish\",
						TEAM.TEAMID AS\"teamId\",
						TEAM.TEAMNOTE AS \"teamNote\",
						(CASE APPLICATIONACCESS.APPLICATIONACCESSVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"applicationAccessValue\"
				FROM 	APPLICATIONACCESS
				JOIN	APPLICATION
				ON		APPLICATIONACCESS.APPLICATIONID 	= 	APPLICATION.APPLICATIONID
				JOIN 	TEAM
				ON		APPLICATIONACCESS.TEAMID 	= 	TEAM.TEAMID
				WHERE 	APPLICATION.ISACTIVE 		=	1
				AND		TEAM.ISACTIVE				=	1";
			if ($this->model->getTeamId()) {
				$sql .= " AND	TEAM.TEAMID	=	'" . $this->model->getTeamId() . "'";
			}
			if ($this->model->getApplicationeId()) {
				$sql .= " AND APPLICATION.APPLICATIONID='" . $this->model->getApplicationId() . "'";
			}
		}

		// searching filtering
		$sql .= $this->q->searching();
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$total = $this->q->numberRows();
		//paging
		if ($this->getStart() && $this->getLimit()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= " LIMIT  " . $this->getStart() . "," . $this->getLimit() . " ";
			} else if ($this->getVendor() == self::MSSQL) {

			} else if ($this->getVendor() == self::ORACLE) {

			} else if ($this->getVendor() == self::DB2) {

			} else if ($this->getVendor() == self::POSTGRESS) {

			}

			$this->q->read($sql);
			if ($this->q->execute == 'fail') {
				echo json_encode(array("success" => false, "message" => $this->q->responce));
				exit();
			}
		}

		$items = array();
		while (($row = $this->q->fetchAssoc()) == TRUE) {
			$items [] = $row;
		}
		if ($total == 1) {
			$end = microtime(true);
			$time = $end - $start;
			$json_encode = json_encode(
			array(	'success' => true,
					'total' => $total, 
					'time' => $time, 
            		'firstRecord' => $this->recordSet->firstRecord('value'), 
            		'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getApplicationAccessId(0, 'single')), 
            		'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getApplicationAccessId(0, 'single')), 
            		'lastRecord' => $this->recordSet->lastRecord('value'),
					'data' => $items));
			$json_encode = str_replace("[", "", $json_encode);
			$json_encode = str_replace("]", "", $json_encode);
			echo json_encode;
			exit();
		} else {
			if (count($items) == 0) {
				$items = '';
			}
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode(
			array(	'success' => true,
						'total' => $total, 
						'time' => $time, 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getApplicationAccessId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getApplicationAccessId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value'),
						'data' => $items));
			exit();
		}
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
			SET 	";
			$sql .= "	   `applicationAccessValue`			=	case `" . $this->model->getPrimaryKeyName() . "` ";
			for ($i = 0; $i < $loop; $i++) {
				$sql .= "
				WHEN '" . $this->model->getApplicationAccessId($i, 'array') . "'
				THEN '" . $this->model->getApplicationAccessValue($i, 'array') . "'";
			}
			$sql .= "	END ";
			$sql .= " WHERE 	`" . $this->model->getPrimaryKeyName() . "`		IN	(" . $this->model->getPrimaryKeyAll() . ")";
		}
		//	echo $sql."<br>";
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

	/**
	 * Return Team Identification
	 */
	function team() {
		return $this->security->team();
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

$applicationAccessObject = new ApplicationeAccessClass ();
// crud -create,read,update,delete.
if (isset($_POST ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST ['leafId'])) {
		$applicationAccessObject->setLeafId($_POST ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$applicationAccessObject->setIsAdmin($_POST ['isAdmin']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$applicationAccessObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$applicationAccessObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Load the dynamic value
	 */
	$applicationAccessObject->execute();
	if ($_POST ['method'] == 'read') {
		$applicationAccessObject->read();
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
		$applicationAccessObject->setLeafId($_GET ['leafId']);
	}
	if (isset($_GET ['isAdmin'])) {
		$applicationAccessObject->setIsAdmin($_GET ['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$applicationAccessObject->execute();
	if ($_GET ['method'] == 'update') {
		$applicationAccessObject->update();
	}
	if (isset($_GET ['field'])) {
		if($_GET['field'] == 'staffId') {
			$applicationAccessObject->staff();
		}
		if ($_GET ['field'] == 'teamId') {
			$applicationAccessObject->team();
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$applicationAccessObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$applicationAccessObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$applicationAccessObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$applicationAccessObject->lastRecord('json');
		}
	}
}
?>
