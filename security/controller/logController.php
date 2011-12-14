<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/logModel.php");

/**
 * this is  log file
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @subpackage log
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LogClass extends ConfigClass {

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
	 * Duplicate Testing either the key of table same or have been created.
	 * @var bool
	 */
	public $duplicateTest;

	/**
	 * Class Loader
	 */
	public function execute() {
		parent::__construct();
		// audit property
		$this->audit = 0;
		$this->log = 0;

		$this->model = new LogModel ();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor();
		$this->q->leafId = $this->getLeafId();
		$this->q->staffId = $this->getStaffId();
		$this->q->fieldQuery = $this->getFieldQuery();
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
		$this->q->gridQuery = $this->getGridQuery();
		$this->q->log = $this->log;
		$this->q->audit = $this->audit;
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->recordSet = new RecordSet ();
		$this->recordSet->setTableName ( $this->model->getTableName () );
		$this->recordSet->setPrimaryKeyName ( $this->model->getPrimaryKeyName () );
		$this->recordSet->execute ();
		
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

	public function create() {

	}

	/* (non-PHPdoc)
	 * @see config::read()
	 */

	public function read() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
				
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$items = array();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT	*
			FROM 	`".$this->q->getLogDatabase()."`.`log`
			JOIN	`".$this->q->getCoreDatabase()."`.`leaf`
			USING	(`leafId`)
			JOIN	`".$this->q->getManagementDatabase()."`.`staff`
			USING	(`staffId`)
			WHERE  1 ";
			if ($this->model->getLogId(0, 'single')) {
				$sql .= " AND `" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`='" . $this->model->getLogId(0, 'single') . "'";
			}
			if ($this->model->getLeafId()) {
				$sql .= " AND `log`.`leafId`='" . $this->model->getLeafId() . "'";
			}
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	*
			FROM 	[".$this->q->getLogDatabase()."].[log]
			JOIN	[".$this->q->getCoreDatabase()."].[leaf]
			ON		[log].[leafId] = [leaf].[leafId]
			JOIN	[".$this->q->getManagementDatabase()."].[staff]
			ON		[log].[staffId]= [staff].[staffId]
			WHERE ";
			if ($this->model->getLogId(0, 'single')) {
				$sql .= " AND [" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]='" . $this->model->getLogId(0, 'single') . "'";
			}
			if ($this->model->getLeafId()) {
				$sql .= " AND [log].[leafId]='" . $this->model->getLeafId() . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	*
			FROM 	LOG
			JOIN	LEAF
			ON		LOG.LEAFID	=LEAF.LEAFID
			JOIN	STAFF
			ON		STAFF.STAFFID= LOG.STAFFID
			WHERE ";
			if ($this->model->getLogId(0, 'single')) {
				$sql .= " AND `" . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "='" . $this->model->getLogId(0, 'single') . "'";
			}
			if ($this->model->getLeafId()) {
				$sql .= " AND LOG.LEAFID='" . $this->model->getLeafId() . "'";
			}
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array('logId');
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array('staff', 'log');
		if ($this->getFieldQuery()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= $this->q->quickSearch($tableArray, $filterArray);
			} else if ($this->getVendor() == self::MSSQL) {
				$tempSql = $this->q->quickSearch($tableArray, $filterArray);
				$sql .= $tempSql;
			} else if ($this->getVendor() == self::ORACLE) {
				$tempSql = $this->q->quickSearch($tableArray, $filterArray);
				$sql .= $tempSql;
			} else if ($this->getVendor() == self::DB2) {
				$tempSql = $this->q->quickSearch($tableArray, $filterArray);
				$sql .= $tempSql;
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql .= $this->q->quickSearch($tableArray, $filterArray);
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

			} else if ($this->getVendor() == self::POSTGRESS) {

			}
		}
		$_SESSION ['sql'] = $sql; // push to session so can make report via excel and pdf
		$_SESSION ['start'] = $this->getStart();
		$_SESSION ['limit'] = $this->getLimit();

		if ($this->getLimit()) {
			// only mysql have limit
			if ($this->getVendor() == self::MYSQL) {
				$sql .= " LIMIT  " . $this->getStart() . "," . $this->getLimit() . " ";
			} else if ($this->getVendor() == self::MSSQL) {
				/**
				 * Sql Server and Oracle used row_number
				 * Parameterize Query We don't support
				 */
				$sql = "
					WITH [logDerived] AS
					(
						SELECT	*
			FROM 	[log]
			JOIN	[leaf]
			ON		[log].[leafId] = [leaf].[leafId]
			JOIN	[staff]
			ON		[log].[staffId]= [staff].[staffId]
			WHERE " . $this->auditFilter . $tempSql . $tempSql2 . "
						 )
						 SELECT		*
						 FROM 		[logDerived]
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
					SELECT	*
			FROM 	LOG
			JOIN	LEAF
			ON		LOG.LEAFID	=LEAF.LEAFID
			JOIN	STAFF
			ON		STAFF.STAFFID= LOG.STAFFID
			WHERE 	" . $this->auditFilter . $tempSql . $tempSql2 . "
						) a
						where rownum <= '" . ($this->getStart() + $this->getLimit()) . "' )
						where r >=  '" . ($this->getStart() + 1) . "'";
			} else if ($this->getVendor() == self::DB2) {

			} else if ($this->getVendor() == self::POSTGRESS) {

			} else {

				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}
		}

		/*
		 *  Only Execute One Query
		 */
		if (!($this->model->getLogId(0, 'single'))) {
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
		$end = microtime(true);
		$time = $end - $start;
		if ($this->model->getLogId(0, 'single')) {
			$json_encode = json_encode(
			array('success' => true,
				'total' => $total, 
				'message' => $this->systemString->getReadMessage(), 
				'time' => $time, 
				'firstRecord' => $this->firstRecord('value'), 
				'previousRecord' => $this->previousRecord('value', $this->model->getLogId(0, 'single')), 
				'nextRecord' => $this->nextRecord('value', $this->model->getLogId(0, 'single')), 
				'lastRecord' => $this->lastRecord('value'), 
				'data' => $items));
			$json_encode = str_replace("[", "", $json_encode);
			$json_encode = str_replace("]", "", $json_encode);
			echo $json_encode;
		} else {
			if (count($items) == 0) {
				$items = '';
			}
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode(
			array(	'success' => true,
						'total' => $total, 
						'message' => $this->systemString->getReadMessage(), 
						'time' => $time, 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getLogId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getLogId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value'), 
						'data' => $items));
			exit();
		}
	}

	/* (non-PHPdoc)
	 * @see config::update()
	 */

	function update() {

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
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
				
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($_SESSION ['start'] == 0) {
			$sql = str_replace("LIMIT", "", $_SESSION ['sql']);
			$sql = str_replace($_SESSION ['start'] . "," . $_SESSION ['limit'], "", $sql);
		} else {
			$sql = $_SESSION ['sql'];
		}
		$this->q->read($sql);
		$this->excel->setActiveSheetIndex(0);
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array('borders' => array('inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '000000')), 'outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '000000'))));
		// header all using  3 line  starting b
		$this->excel->getActiveSheet()->setCellValue('B2', $this->title);
		$this->excel->getActiveSheet()->setCellValue('J2', '');
		$this->excel->getActiveSheet()->mergeCells('B2:J2');
		$this->excel->getActiveSheet()->setCellValue('B3', 'No');
		$this->excel->getActiveSheet()->setCellValue('C3', 'logId');
		$this->excel->getActiveSheet()->setCellValue('D3', 'leafId');
		$this->excel->getActiveSheet()->setCellValue('E3', 'operation');
		$this->excel->getActiveSheet()->setCellValue('F3', 'sql');
		$this->excel->getActiveSheet()->setCellValue('G3', 'date');
		$this->excel->getActiveSheet()->setCellValue('H3', 'staffId');
		$this->excel->getActiveSheet()->setCellValue('I3', 'access');
		$this->excel->getActiveSheet()->setCellValue('J3', 'log_error');
		$this->excel->getActiveSheet()->getStyle('B2:J2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:J2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:J3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:J3')->getFill()->getStartColor()->setARGB('66BBFF');
		//
		$loopRow = 4;
		$i = 0;
		while (($row = $this->q->fetchAssoc()) == TRUE) {
			//	echo print_r($row);
			$this->excel->getActiveSheet()->setCellValue('B' . $loopRow, ++$i);
			$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, $row ['logId']);
			$this->excel->getActiveSheet()->setCellValue('D' . $loopRow, $row ['leafId']);
			$this->excel->getActiveSheet()->setCellValue('E' . $loopRow, $row ['operation']);
			$this->excel->getActiveSheet()->setCellValue('F' . $loopRow, $row ['sql']);
			$this->excel->getActiveSheet()->setCellValue('G' . $loopRow, $row ['date']);
			$this->excel->getActiveSheet()->setCellValue('H' . $loopRow, $row ['staffId']);
			$this->excel->getActiveSheet()->setCellValue('I' . $loopRow, $row ['access']);
			$this->excel->getActiveSheet()->setCellValue('J' . $loopRow, $row ['log_error']);
			$loopRow++;
			$lastRow = 'J' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename = "log" . rand(0, 10000000) . ".xlsx";
		$path = $_SERVER ['DOCUMENT_ROOT'] . "/" . $this->application . "/basic/document/excel/" . $filename;
		$objWriter->save($path);
		$this->create_trail($this->leafId, $path, $filename);
		$file = fopen($path, 'r');
		if ($file) {
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode(array("success" => true, "message" => $this->systemString->getFileGenerateMessage(),"time"=>$time));
			exit();
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getFileNotGenerateMessage()));
			exit();
		}
	}

}

$logObject = new LogClass ();
// crud -create,read,update,delete
if (isset($_POST ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_POST ['leafId'])) {
		$logObject->setLeafId($_POST ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$logObject->setIsAdmin($_POST ['isAdmin']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$logObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$logObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Filtering
	 */
	if (isset($_POST ['query'])) {
		$logObject->setFieldQuery($_POST ['query']);
	}
	if (isset($_POST ['filter'])) {
		$logObject->setGridQuery($_POST ['filter']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST ['order'])) {
		$logObject->setOrder($_POST ['order']);
	}
	if (isset($_POST ['sortField'])) {
		$logObject->setSortField($_POST ['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$logObject->execute();
	if ($_POST ['method'] == 'read') {

		$logObject->read();
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
		$logObject->setLeafId($_GET ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET ['isAdmin'])) {
		$logObject->setIsAdmin($_GET ['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$logObject->execute();
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$logObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$logObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$logObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$logObject->lastRecord('json');
		}
	}
	/*
	 * Reporting Only
	 */
	if (isset($_GET ['mode'])) {
		if ($_GET ['mode'] == 'excel') {
			$logObject->excel();
		}
	}
}
?>
