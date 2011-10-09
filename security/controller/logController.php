<?php
session_start ();
require_once ("../../class/classAbstract.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
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
	public function execute() {
		parent::__construct ();
		// audit property
		$this->audit = 0;
		$this->log = 0;
		
		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor ();
		$this->q->leafId = $this->getLeafId ();
		$this->q->staffId = $this->getStaffId ();
		$this->q->fieldQuery = $this->getFieldQuery ();
		$this->q->gridQuery = $this->getGridQuery ();
		$this->q->log = $this->log;
		$this->q->audit = $this->audit;
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );
		
		$this->security = new Security ();
		$this->security->setVendor ( $this->getVendor () );
		$this->security->setLeafId ( $this->getLeafId () );
		$this->security->execute ();
		
		$this->model = new LogModel ();
		$this->model->setVendor ( $this->getVendor () );
		$this->model->execute ();
		
		$this->documentTrail = new DocumentTrailClass ();
		$this->documentTrail->setVendor ( $this->getVendor () );
		$this->documentTrail->execute ();
		
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
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT	*
			FROM 	`log`
			JOIN	`leaf`
			USING	(`leafId`)
			JOIN	`staff`
			USING	(`staffId`)
			WHERE ";
			if ($_POST ['logId']) {
				$sql .= " AND `log`.`logId`='" . $this->strict ( $_POST ['logId'], 'n' ) . "'";
			}
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	*
			FROM 	[log]
			JOIN	[leaf]
			ON		[log].[leafId] = [leaf].[leafId]
			JOIN	[staff]
			ON		[log].[staffId]= [staff].[staffId]
			WHERE ";
			if ($_POST ['logId']) {
				$sql .= " AND `log`.`logId`='" . $this->strict ( $_POST ['logId'], 'n' ) . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	*
			FROM 	LOG
			JOIN	LEAF
			ON		LOG.LEAFID	=LEAF.LEAFID
			JOIN	STAFF
			ON		STAFF.STAFFID= LOG.STAFFID
			WHERE ";
			if ($_POST ['logId']) {
				$sql .= " AND `log`.`logId`='" . $this->strict ( $_POST ['logId'], 'n' ) . "'";
			}
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array ('logId' );
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = array ('staff', 'log' );
		
		if ($this->getfieldQuery ()) {
			if ($this->getVendor () == self::MYSQL) {
				$sql .= $this->q->quickSearch ( $tableArray, $filterArray );
			} else if ($this->getVendor () == self::MSSQL) {
				$tempSql = $this->q->quickSearch ( $tableArray, $filterArray );
				$sql .= $tempSql;
			} else if ($this->getVendor () == self::ORACLE) {
				$tempSql = $this->q->quickSearch ( $tableArray, $filterArray );
				$sql .= $tempSql;
			}
		}
		/**
		 * Extjs filtering mode
		 */
		if ($this->getGridQuery ()) {
			if ($this->getVendor () == self::MYSQL) {
				$sql .= $this->q->searching ();
			} else if ($this->getVendor () == self::MSSQL) {
				$tempSql2 = $this->q->searching ();
				$sql .= $tempSql2;
			} else if ($this->getVendor () == self::ORACLE) {
				$tempSql2 = $this->q->searching ();
				$sql .= $tempSql2;
			}
		}
		$this->q->read ( $sql );
		$total = $this->q->numberRows ();
		//paging
		if ($this->getOrder () && $this->getSortField ()) {
			if ($this->getVendor () == self::MYSQL) {
				$sql .= "	ORDER BY `" . $this->getSortField () . "` " . $this->getOrder () . " ";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql .= "	ORDER BY [" . $this->getSortField () . "] " . $this->getOrder () . " ";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql .= "	ORDER BY " . strtoupper ( $this->getSortField () ) . "  " . strtoupper ( $this->getOrder () ) . " ";
			}
		}
		$_SESSION ['sql'] = $sql; // push to session so can make report via excel and pdf
		$_SESSION ['start'] = $this->getStart ();
		$_SESSION ['limit'] = $this->getLimit ();
		$this->q->read ( $sql );
		while ( ($row = $this->q->fetchAssoc ()) == TRUE ) {
			$items [] = $row;
		}
		// bugs on extjs
		if ($_POST ['method'] == 'read' && $_POST ['mode'] == 'update') {
			$json_encode = json_encode ( array ('success' => 'true', 'total' => $this->total, 'data' => $items ) );
			$json_encode = str_replace ( "[", "", $json_encode );
			$json_encode = str_replace ( "]", "", $json_encode );
			echo $json_encode;
			exit ();
		} else {
			if (count ( $items ) == 0) {
				$items = '';
			}
			echo json_encode ( array ('success' => 'true', 'total' => $this->total, 'data' => $items ) );
			exit ();
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
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		if ($_SESSION ['start'] == 0) {
			$sql = str_replace ( "LIMIT", "", $_SESSION ['sql'] );
			$sql = str_replace ( $_SESSION ['start'] . "," . $_SESSION ['limit'], "", $sql );
		} else {
			$sql = $_SESSION ['sql'];
		}
		$this->q->read ( $sql );
		$this->excel->setActiveSheetIndex ( 0 );
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array ('borders' => array ('inside' => array ('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array ('argb' => '000000' ) ), 'outline' => array ('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array ('argb' => '000000' ) ) ) );
		// header all using  3 line  starting b
		$this->excel->getActiveSheet ()->setCellValue ( 'B2', $this->title );
		$this->excel->getActiveSheet ()->setCellValue ( 'J2', '' );
		$this->excel->getActiveSheet ()->mergeCells ( 'B2:J2' );
		$this->excel->getActiveSheet ()->setCellValue ( 'B3', 'No' );
		$this->excel->getActiveSheet ()->setCellValue ( 'C3', 'logId' );
		$this->excel->getActiveSheet ()->setCellValue ( 'D3', 'leafId' );
		$this->excel->getActiveSheet ()->setCellValue ( 'E3', 'operation' );
		$this->excel->getActiveSheet ()->setCellValue ( 'F3', 'sql' );
		$this->excel->getActiveSheet ()->setCellValue ( 'G3', 'date' );
		$this->excel->getActiveSheet ()->setCellValue ( 'H3', 'staffId' );
		$this->excel->getActiveSheet ()->setCellValue ( 'I3', 'access' );
		$this->excel->getActiveSheet ()->setCellValue ( 'J3', 'log_error' );
		$this->excel->getActiveSheet ()->getStyle ( 'B2:J2' )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$this->excel->getActiveSheet ()->getStyle ( 'B2:J2' )->getFill ()->getStartColor ()->setARGB ( '66BBFF' );
		$this->excel->getActiveSheet ()->getStyle ( 'B3:J3' )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$this->excel->getActiveSheet ()->getStyle ( 'B3:J3' )->getFill ()->getStartColor ()->setARGB ( '66BBFF' );
		//
		$loopRow = 4;
		$i = 0;
		while ( ($row = $this->q->fetchAssoc ()) == TRUE ) {
			//	echo print_r($row);
			$this->excel->getActiveSheet ()->setCellValue ( 'B' . $loopRow, ++ $i );
			$this->excel->getActiveSheet ()->setCellValue ( 'C' . $loopRow, $row ['logId'] );
			$this->excel->getActiveSheet ()->setCellValue ( 'D' . $loopRow, $row ['leafId'] );
			$this->excel->getActiveSheet ()->setCellValue ( 'E' . $loopRow, $row ['operation'] );
			$this->excel->getActiveSheet ()->setCellValue ( 'F' . $loopRow, $row ['sql'] );
			$this->excel->getActiveSheet ()->setCellValue ( 'G' . $loopRow, $row ['date'] );
			$this->excel->getActiveSheet ()->setCellValue ( 'H' . $loopRow, $row ['staffId'] );
			$this->excel->getActiveSheet ()->setCellValue ( 'I' . $loopRow, $row ['access'] );
			$this->excel->getActiveSheet ()->setCellValue ( 'J' . $loopRow, $row ['log_error'] );
			$loopRow ++;
			$lastRow = 'J' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet ()->getStyle ( $formula )->applyFromArray ( $styleThinBlackBorderOutline );
		$objWriter = PHPExcel_IOFactory::createWriter ( $this->excel, 'Excel2007' );
		$filename = "log" . rand ( 0, 10000000 ) . ".xlsx";
		$path = $_SERVER ['DOCUMENT_ROOT'] . "/" . $this->application . "/basic/document/excel/" . $filename;
		$objWriter->save ( $path );
		$this->create_trail ( $this->leafId, $path, $filename );
		$file = fopen ( $path, 'r' );
		if ($file) {
			echo json_encode ( array ("success" => "true", "message" => "File generated" ) );
			exit ();
		} else {
			echo json_encode ( array ("success" => "false", "message" => "File not generated" ) );
			exit ();
		}
	}
}
$logObject = new LogClass ();
// crud -create,read,update,delete
if (isset ( $_POST ['method'] )) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset ( $_POST ['leafId'] )) {
		$logObject->setLeafId ( $_POST ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_POST ['isAdmin'] )) {
		$logObject->setIsAdmin ( $_POST ['isAdmin'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$logObject->execute ();
	if ($_POST ['method'] == 'read') {
		$logObject->read ();
	}
}
if (isset ( $_GET ['method'] )) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset ( $_GET ['leafId'] )) {
		$logObject->setLeafId ( $_GET ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_GET ['isAdmin'] )) {
		$logObject->setIsAdmin ( $_GET ['isAdmin'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$logObject->execute ();
	/*
	 * Reporting Only
	 */
	if (isset ( $_GET ['mode'] )) {
		$logObject->excel ();
	}
}
?>
