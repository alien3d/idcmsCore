<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../model/calendarModel.php");

/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package calendars
 * @subpackage calendar
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class CalendarClass extends ConfigClass {

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
	 * Audit Row TRUE or False
	 * @var bool
	 */
	private $audit;

	/**
	 * Log Sql Statement TRUE or False
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

		//audit property
		$this->audit = 0;
		$this->log = 0;

		$this->model = new CalendarModel ();
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
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
			
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
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
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT	`calendar`.`calendarId`,
					`calendar`.`calendarColorId`,
					`calendar`.`calendarTitle`,
					`calendar`.`calendarDesc`,
					`calendar`.`isHidden`,
					`calendar`.`staffId`,
					`calendarcolor`.`calendarColorId`
			FROM	`calendar`
			JOIN 	`calendarcolor` 
			ON 		`calendarcolor`.`calendarColorId` = `calendar`.`calendarColorId`	
			WHERE 	`calendar`.`staffId` = '" . $this->model->getExecuteBy() . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[calendar].[calendarId],
					[calendar].[calendarColorId],
					[calendar].[calendarTitle],
					[calendar].[calendarDesc],
					[calendar].[isHidden],
					[calendar].[staffId],
					[calendarcolor].[calendarColorId]
			FROM	[calendar]
			JOIN 	[calendarcolor] 
			ON 		[calendarcolor].[calendarColorId] = [calendar].[calendarColorId] 
			WHERE 	[staff].[staffId]= '" . $this->model->getExecuteBy() . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	CALENDAR.CALENDARID,
					CALENDAR.CALENDARCOLORID,
					CALENDAR.CALENDARTITLE,
					CALENDAR.CALENDARDESC,
					CALENDAR.ISHIDDEN,
					CALENDAR.STAFFID,
					CALENDARCOLOR.CALENDARCOLORID
			FROM	CALENDAR
			JOIN 	CALENDARCOLOR 
			ON 		CALENDARCOLOR.CALENDARCOLORID = CALENDAR.CALENDARCOLORID
			WHERE 	STAFFID = '" . $this->model->getExecuteBy() . "'";
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = array();
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array('calendar','calendarColor');
		if ($this->getFieldQuery()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= $this->q->quickSearch($tableArray, $filterArray);
			} else if ($this->getVendor() == self::MSSQL) {
				$tempSql = $this->q->quickSearch($tableArray, $filterArray);
				$sql .= $tempSql;
			} else if ($this->getVendor() == self::ORACLE) {
				$tempSql = $this->q->quickSearch($tableArray, $filterArray);
				$sql .= $tempSql;
			}
		}
		/**
		 * Extjs filtering mode
		 */
		if ($this->getGridQuery()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= $this->q->searching();
			} else if ($this->getVendor() == self::MSSQL) {
				$tempSql2 = $this->q->searching();
				$sql .= $tempSql2;
			} else if ($this->getVendor() == self::ORACLE) {
				$tempSql2 = $this->q->searching();
				$sql .= $tempSql2;
			} else if ($this->getVendor() == self::DB2) {

			} else if ($this->getVendor() == self::POSTGRESS) {

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
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$total = $this->q->numberRows();
		if ($this->getOrder() && $this->getSortField()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
			} else if ($this->getVendor() == self::DB2) {
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
			}
		}
		$_SESSION ['sql'] = $sql; // push to session so can make report via excel and pdf
		$_SESSION ['start'] = $this->getStart();
		$_SESSION ['limit'] = $this->getLimit();
		if ($this->getStart() && $this->getLimit()) {
			// only mysql have limit
			if ($this->getVendor() == self::MYSQL) {
				$sql .= " LIMIT  " . $this->getStart() . "," . $this->getLimit() . " ";
			} else if ($this->getVendor() == self::MSSQL) {
				/**
				 * Sql Server and Oracle used row_number
				 * Parameterize Query We don't support
				 */
				$sql = "
				WITH [calendarDerived] AS
				(
					SELECT	[calendar].[calendarId],
							[calendar].[calendarColorId],
							[calendar].[calendarTitle],
							[calendar].[calendarDesc],
							[calendar].[isHidden],
							[calendar].[staffId],
							[calendarcolor].[calendarColorId]
							ROW_NUMBER() OVER (ORDER BY [calendarId]) AS 'RowNumber'
					FROM	[calendar]
					JOIN 	[calendarcolor] 
					ON 		[calendarcolor].[calendarColorId] = [calendar].[calendarColorId] 
					WHERE 	[staff].[staffId]= '" . $this->model->getExecuteBy() . "' ". $tempSql . $tempSql2 . "
					)
					SELECT		*
					FROM 		[calendarDerived]
					WHERE 		[RowNumber]
					BETWEEN	" . ($this->getStart() + 1) . "
					AND 			" . ($this->getStart() + $this->getLimit()) . ";";
			} else if ($this->getVendor() == self::ORACLE) {
				/**
				 * Oracle using derived table also
				 */
				$sql = "
				SELECT *
				FROM ( SELECT	a.*,
				rownum r
				FROM (
						SELECT	CALENDAR.CALENDARID,
								CALENDAR.CALENDARCOLORID,
								CALENDAR.CALENDARTITLE,
								CALENDAR.CALENDARDESC,
								CALENDAR.ISHIDDEN,
								CALENDAR.STAFFID,
								CALENDARCOLOR.CALENDARCOLORID
						FROM		CALENDAR
						JOIN 	CALENDARCOLOR 
						ON 		CALENDARCOLOR.CALENDARCOLORID = CALENDAR.CALENDARCOLORID
						WHERE 	STAFFID = '" . $this->model->getExecuteBy() . "' ". $tempSql . $tempSql2 . "
					) a
					WHERE rownum <= '" . ($this->getStart() + $this->getLimit()) . "' )
				WHERE r >=  '" . ($this->getStart() + 1) . "'";
			} else {
				echo "undefine vendor";
				exit();
			}
		}

		/*
		 *  Only Execute One Query
		 */
		if (!($this->model->getCalendarId(0, 'single'))) {
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
		if ($this->model->getCalendarId(0, 'single')) {
			$json_encode = json_encode(
			array(	'success' => true,
												'total' => $total, 
												'message' => 'Data Loaded', 
												'data' => $items, 
												'firstRecord' => $this->firstRecord('value'), 
												'previousRecord' => $this->previousRecord('value', $this->model->getCalendarId(0, 'single')), 
												'nextRecord' => $this->nextRecord('value', $this->model->getCalendarId(0, 'single')), 
												'lastRecord' => $this->lastRecord('value')));
			$json_encode = str_replace("[", "", $json_encode);
			$json_encode = str_replace("]", "", $json_encode);
			echo $json_encode;
		} else {
			if (count($items) == 0) {
				$items = '';
			}
			echo json_encode(
				array(	'success' => true, 
						'total' => $total, 
						'message' => 'data loaded', 
						'data' => $items,
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getCalendarId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getCalendarId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value')));
			exit();
		}
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
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
					UPDATE 	`calendar`
					SET 			`calendarTitle`		=	'" . $this->strict($_POST ['cal_title'], 's') . "'
					WHERE 		`calendarId`			=	'" . $this->strict($_POST ['calendarId'], 'n') . "'";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
					UPDATE 	[calendar]
					SET 			[calendarTitle]		=	'" . $this->strict($_POST ['cal_title'], 's') . "'
					WHERE 		[calendarId]			=	'" . $this->strict($_POST ['calendarId'], 'n') . "'";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
					UPDATE 	CALENDAR
					SET 			CALENDARTITLE	=	'" . $this->strict($_POST ['cal_title'], 's') . "'
					WHERE 		CALENDARID			=	'" . $this->strict($_POST ['calendarId'], 'n') . "'";
		}
		$this->q->update($sql);
		$this->q->commit();
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		} else {
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode(
				array(	"success" => true, 
						"message" => "update success",
						"time"=>$time));
			exit();
		}
	}

	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	/* (non-PHPdoc)
	 * @see config::delete()
	 */

	function delete() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
			
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
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

	/**
	 * Event Creation
	 */
	function excel() {

	}

}

$calendarObject = new CalendarClass ();
if (isset($_POST ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST ['leafId'])) {
		$calendarObject->setLeafId($_POST ['leafId']);
	}
	if (isset($_POST ['isAdmin'])) {
		$calendarObject->setIsAdmin($_POST ['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$calendarObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$calendarObject->create();
	}
	if ($_POST ['method'] == 'read') {
		$calendarObject->read();
	}
	if ($_POST ['method'] == 'update') {
		$calendarObject->update();
	}
	if ($_POST ['method'] == 'delete') {
		$calendarObject->delete();
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
		$calendarObject->setLeafId($_GET ['leafId']);
	}
	if (isset($_GET ['isAdmin'])) {
		$calendarObject->setIsAdmin($_GET ['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$calendarObject->execute();
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$calendarObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$calendarObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$calendarObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$calendarObject->lastRecord('json');
		}
	}
	if (isset($_GET ['field'])) {
		if ($_GET ['field'] == 'staffId') {
			$calendarObject->staff();
		}
	}
}
?>



