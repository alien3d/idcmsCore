<?php
session_start();
require_once ("../../class/classAbstract.php");
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
class CalendarClass extends ConfigClass
{
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
	function execute ()
	{
		parent::__construct();
		$this->q = new Vendor();
		$this->q->vendor = $this->getVendor();
		$this->q->leafId = $this->getLeafId();
		$this->q->staffId = $this->getStaffId();
		$this->q->fieldQuery = $this->getFieldQuery();
		$this->q->gridQuery = $this->getGridQuery();
		$this->q->connect($this->getConnection(), $this->getUsername(),
		$this->getDatabase(), $this->getPassword());
		$this->excel = new PHPExcel();
		$this->audit = 0;
		$this->log = 0;
		$this->q->log = $this->log;
		$this->model = new CalendarModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();
		$this->documentTrail = new DocumentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->execute();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create ()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read ()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
		SELECT	*
		FROM 	`calendarColor`
		JOIN    `calendar`
		USING   (`calendarColorId`)
		
		WHERE 	`staffId` = \"" . $this->model->getExecuteBy() . "\" ";
		} else
		if ($this->getVendor() == self::MSSQL) {
			$sql = "
		SELECT	*
		FROM 	[calendarColor]
		JOIN    [calendar]
		USING   [calendar].[calendarColorId] = [calendarColor].[colorColorId]
		WHERE 	`staffId` = '" . $this->model->getExecuteBy() . "' ";
		} else
		if ($this->getVendor() == self::ORACLE) {
			$sql = "
		SELECT	*
		FROM 	CALENDARCOLOR
		JOIN    CALENDAR
		
		WHERE 	STAFFID = '" . $this->model->getExecuteBy() . "'";
		}
		// searching filtering
		$sql .= $this->q->searching();
		$this->q->read($sql);
		$total = $this->q->numberRows();
		$this->q->read($sql);
		$items = array();
		while (($row = $this->q->fetchAssoc()) == TRUE) {
			$row['ColorId'] = $row['calendarColorId']; // testing maaping color
			$items[] = $row;
		}
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		} else {
			// bugs on extjs
			if ($_POST['method'] == 'read' &&
			$_POST['mode'] == 'update') {
				$json_encode = json_encode(
				array('success' => TRUE, 'total' => $total, 'data' => $items));
				$json_encode = str_replace("[", "", $json_encode);
				$json_encode = str_replace("]", "", $json_encode);
				echo $json_encode;
			} else {
				if (count($items) == 0) {
					$items = '';
				}
				echo json_encode(
				array('success' => TRUE, 'total' => $total, 'data' => $items));
			}
		}
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update ()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
					UPDATE 	`calendar`
					SET 	`calendarTitle`	=	\"" . $this->strict($_POST['cal_title'], 's') . "\"
					WHERE 	`calendarId`		=	\"" .
			$this->strict($_POST['cal_own_uniqueId'], 'n') . "\"";
		} else
		if ($this->getVendor() == self::MSSQL) {
			$sql = "
					UPDATE 	[calendar]
					SET 	[calendarTitle]	=	\"" . $this->strict($_POST['cal_title'], 's') . "\"
					WHERE 	[calendarId]		=	\"" . $this->strict($_POST['calendarId'], 'n') .
                 "\"";
		} else
		if ($this->getVendor() == self::ORACLE) {
			$sql = "
					UPDATE 	CALENDAR
					SET 	CALENDARTITLE	=	'" . $this->strict($_POST['cal_title'], 's') . "'
					WHERE 	CALENDARID	=	'" . $this->strict($_POST['calendarId'], 'n') . "'";
		}
		$this->q->update($sql);
		$this->q->commit();
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		} else {
			echo json_encode(
			array("success" => TRUE, "message" => "update success"));
			exit();
		}
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete ()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	/**
	 * Event Creation
	 */
	function excel ()
	{}
}
$calendarObject = new CalendarClass();
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST['leafId'])) {
		$calendarObject->setLeafId($_POST['leafId']);
	}
	if (isset($_POST['isAdmin'])) {
		$calendarObject->setIsAdmin($_POST['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$calendarObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST['method'] == 'create') {
		$calendarObject->create();
	}
	if ($_POST['method'] == 'read') {
		$calendarObject->read();
	}
	if ($_POST['method'] == 'update') {
		$calendarObject->update();
	}
	if ($_POST['method'] == 'delete') {
		$calendarObject->delete();
	}
}
if (isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_GET['leafId'])) {
		$calendarObject->setLeafId($_GET['leafId']);
	}
	if (isset($_GET['isAdmin'])) {
		$calendarObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$calendarObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$calendarObject->staff();
		}
	}
}
?>



