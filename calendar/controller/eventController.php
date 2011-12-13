<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once("../../class/classRecordSet.php");
require_once ("../../class/classDate.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/eventModel.php");

/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package calendars
 * @subpackage event
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class EventClass extends ConfigClass {

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
	 * Audit Row TRUE or False
	 * @var bool
	 */
	private $audit;

	/**
	 * Log Sql Statement TRUE or False
	 * @var bool
	 */
	private $log;

	/**
	 * department Model
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
		$this->log = 1;

		$this->model = new EventModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

		$this->q = new Vendor();
		$this->q->vendor = $this->getVendor();
		$this->q->leafId = $this->getLeafId();
		$this->q->staffId = $this->getStaffId();
		$this->q->fieldQuery = $this->getFieldQuery();
		$this->q->gridQuery = $this->getGridQuery();
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
		$this->q->log = $this->log;
		$this->q->audit = $this->audit;
		$this->q->setRequestDatabase($this->getRequestDatabase());
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->systemString = new SystemString();
		$this->systemString->setVendor($this->getVendor());
		$this->systemString->setLeafId($this->getLeafId());
		$this->systemString->execute();

		$this->recordSet = new RecordSet ();
		$this->recordSet->setTableName($this->model->getTableName());
		$this->recordSet->setPrimaryKeyName($this->model->getPrimaryKeyName());
		$this->recordSet->execute();

		$this->documentTrail = new DocumentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->execute();

		$this->excel = new PHPExcel();
	}

	/* (non-PHPdoc)
	 * @see ConfigClass::create()
	 */

	public function create() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->create();

		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			INSERT INTO `icalendar`.`event`(
						`icalendar`.`event`.`calendarId`,		`icalendar`.`event`.`eventTitle`,
						`icalendar`.`event`.`eventStart`,		`icalendar`.`event`.`eventEnd`,
						`icalendar`.`event`.`eventIsAllDay`,	`icalendar`.`event`.`eventNotes`,
						`icalendar`.`event`.`eventReminder`,	`icalendar`.`event`.`eventUrl`,
						`icalendar`.`event`.`eventLocation`,	`icalendar`.`event`.`eventIsNew`,
						`icalendar`.`event`.`staffId`,			`icalendar`.`event`.`executeTime`
			)VALUES	(
				'" . $this->model->getCalendarId() . "',		
				'" .$this->model->getEventTitle() . "',
				'" . $this->model->getEventStart() . "',		
				'" .$this->model->getEventEnd() . "',
				'" . $this->model->geteventIsAllDay() . "',	
				'" .$this->model->getEventNotes() . "',
				'" . $this->model->getEventReminder() . "',	'" .
			$this->model->getEventUrl() . "',
				'" . $this->model->getEventLocation() . "',	'" .
			$this->model->getEventIsNew() . "',
				'" . $this->model->getExecuteBy() . "',		" .
			$this->model->getExecuteTime() . "
				
							);";
		} else
		if ($this->getVendor() == self::MSSQL) {
			$sql = "
			INSERT INTO [icalendar].[event](
						[icalendar].[event].[calendarId],		[icalendar].[event].[eventTitle],
						[icalendar].[event].[eventStart],		[icalendar].[event].[eventEnd],
						[icalendar].[event].[eventIsAllDay],	[icalendar].[event].[eventNotes],
						[icalendar].[event].[eventReminder],	[icalendar].[event].[eventUrl],
						[icalendar].[event].[eventLocation],	[icalendar].[event].[eventIsNew],
						[icalendar].[event].[staffId],			[icalendar].[event].[executeTime]
			)VALUES	(
				'" . $this->model->getCalendarId() . "',		'" .
			$this->model->getEventTitle() . "',
				'" . $this->model->getEventStart() . "',		'" .
			$this->model->getEventEnd() . "',
				'" . $this->model->geteventIsAllDay() . "',	'" .
			$this->model->getEventNotes() . "',
				'" . $this->model->getEventReminder() . "',	'" .
			$this->model->getEventUrl() . "',
				'" . $this->model->getExecuteBy() . "',		" .
			$this->model->getExecuteTime() . "
				
							);";
		} elseif ($this->getVendor() == self::ORACLE) {
			$sql = "
			INSERT INTO ICALENDAR.EVENT (
						ICALENDAR.EVENT.CALENDARID,			ICALENDAR.EVENT.EVENTTITLE,
						ICALENDAR.EVENT.EVENTSTART,			ICALENDAR.EVENT.EVENTEND,
						ICALENDAR.EVENT.EVENTISALLDAY,		ICALENDAR.EVENT.EVENTNOTES,
						ICALENDAR.EVENT.EVENTREMINDER,		ICALENDAR.EVENT.EVENTURL,
						ICALENDAR.EVENT.EVENTLOCATION,		ICALENDAR.EVENT.EVENTISNEW,
						ICALENDAR.EVENTSTAFFID,				ICALENDAR.EVENT.EXECUTETIME
			)VALUES	(
				'" . $this->model->getCalendarId() . "',		'" .
			$this->model->getEventTitle() . "',
				'" . $this->model->getEventStart() . "',		'" .
			$this->model->getEventEnd() . "',
				'" . $this->model->geteventIsAllDay() . "',	'" .
			$this->model->getEventNotes() . "',
				'" . $this->model->getEventReminder() . "',	'" .
			$this->model->getEventUrl() . "',
				'" . $this->model->getEventLocation() . "',	'" .
			$this->model->getEventIsNew() . "',
				'" . $this->model->getExecuteBy() . "',		" .
			$this->model->getExecuteTime() . "
				
							);";
		}
		$this->q->create($sql);
		$eventId = $this->q->lastInsertId();
		// try to return  json data  hope phantom record will updated..if
		$data = array('eventId' => $eventId);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array(	"success" =>true,
				"message" => $this->systemString->getCreateMessage(),
				"evts" => $data,
                "eventId" => $eventId,
				"time"=>$time));
		exit();
	}

	/* (non-PHPdoc)
	 * @see ConfigClass::read()
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
			FROM 	`icalendar`.`event`
			JOIN    `icalendar`.`calendar`
			USING	(`calendarId`,`staffId`)
			JOIN	`icalendar`.`calendarColor`
			USING   (`calendarColorId`)
			WHERE 	`icalendar`.`calendar`.`staffId` = '" . $this->model->getExecuteBy() . "'";
			if ($this->model->getEventStart() && $this->model->getEventEnd()) {
				$sql .= "
				AND	`icalendar`.`event`.`eventStart`	>= 	'" . $this->model->getEventStart() . "'
				AND	`icalendar`.`event`.`eventEnd` 		<=	'" . $this->model->getEventEnd() . "'";
			}
		} else
		if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	*
			FROM 	[icalendar].[event]
			JOIN    [icalendar].[calendar]
			ON		[icalendar].[event].[calendarId]				= 	[icalendar].[calendar].[calendarId]
			AND		[event].[staffId] 								=	[icalendar].[calendar].[staffId]
			JOIN	[icalendar].[calendarColor]
			ON		[icalendar].[calendarColor].[calendarColorId]	=	[icalendar].[calendar].[calendarColorId]
			WHERE 	[icalendar].[calendar].[staffId] 				= 	'" . $this->model->getExecuteBy() . "'";
			if ($this->model->getEventStart() && $this->model->getEventEnd()) {
				$sql .= "
				AND	[icalendar].[event].[eventStart]	>= 	'" . $this->model->getEventStart() . "'
				AND	[icalendar].[event].[eventEnd] 		<=	'" . $this->model->getEventEnd() . "'";
			}
		} else
		if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	*
			FROM 	ICALENDAR.EVENT
			JOIN	ICALENDAR.CALENDAR
			ON		ICALENDAR.CALENDAR.CALENDARID 			= 	ICALENDAR.EVENT.CALENDARID
			AND		ICALENDAR.CALENDAR.STAFFID				= 	ICALENDAR.EVENT.STAFFID
			JOIN    ICALENDAR.CALENDARCOLOR
			ON		ICALENDAR.CALENDARCOLOR.CALENDARCOLORID	=	ICALENDAR.CALENDAR.CALENDARCOLORID
			WHERE 	ICALENDAR.CALENDAR.STAFFID 				= 	'" . $this->model->getExecuteBy() . "'";
			if ($this->model->getEventStart() &&
			$this->model->getEventEnd()) {
				$sql .= "
				AND	ICALENDAR.EVENT.EVENTSTART 	>=	'" . $this->model->getEventStart() . "'
				AND	ICALENDAR.EVENT.EVENTEND 		<= 	'" . $this->model->getEventEnd() . "'";
			}
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$total = $this->q->numberRows();
		$items = array();
		while (($row = $this->q->fetchAssoc()) == TRUE) {
			$items[] = $row;
		}
		if ($this->model->getEventId(0, 'single')) {
			$end = microtime(true);
			$time = $end - $start;
			$json_encode = json_encode(
			array(
					'success' => true, 
					'total' => $total,
                    'message' => $this->systemString->getReadMessage(), 
                    'time'=>$time,
                    'evts' => $items,
            		'firstRecord' => $this->recordSet->firstRecord('value'), 
            		'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getEventId(0, 'single')), 
            		'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getEventId(0, 'single')), 
            		'lastRecord' => $this->recordSet->lastRecord('value')));
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
                    'time'=>$time,
                    'evts' => $items, 
            		'firstRecord' => $this->recordSet->firstRecord('value'), 
            		'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getEventId(0, 'single')), 
            		'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getEventId(0, 'single')), 
            		'lastRecord' => $this->recordSet->lastRecord('value')));
		}
	}

	/* (non-PHPdoc)
	 * @see ConfigClass::update()
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
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			UPDATE	`icalendar`.`event`
			SET		`icalendar`.`event`.`calendarId`		=	'" . $this->model->getCalendarId() . "',
					`icalendar`.`event`.`eventTitle`		=	'" . $this->model->getEventTitle() . "',
					`icalendar`.`event`.`eventStart`		=	'" . $this->model->getEventStart() . "',
					`icalendar`.`event`.`eventEnd`			=	'" . $this->model->getEventEnd() . "',
					`icalendar`.`event`.`eventIsAllDay`  	= 	'" . $this->model->geteventIsAllDay() . "',
					`icalendar`.`event`.`eventNotes` 		= 	'" . $this->model->getEventNotes() . "',
					`icalendar`.`event`.`eventReminder`		=	'" . $this->model->getEventReminder() . "',
					`icalendar`.`event`.`eventUrl`			=	'" . $this->model->getEventUrl() . "',
					`icalendar`.`event`.`eventLocation`		=	'" . $this->model->getEventLocation() . "',
					`icalendar`.`event`.`eventIsNew`		=	'" . $this->model->getEventIsNew() . "'
			WHERE 	`icalendar`.`event`.`eventId`			=	'" . $this->model->getEventId(0, 'single') . "'";
		} else
		if ($this->q->vendor == self::MSSQL) {
			$sql = "
			UPDATE	[icalendar].[event]
			SET		[icalendar].[event].[calendarId]		=	'" . $this->model->getCalendarId() . "',
					[icalendar].[event].[eventTitle]		=	'" . $this->model->getEventTitle() . "',
					[icalendar].[event].[eventStart]		=	'" . $this->model->getEventStart() . "',
					[icalendar].[event].[eventEnd]			=	'" . $this->model->getEventEnd() . "',
					[icalendar].[event].[eventIsAllDay]  	= 	'" . $this->model->geteventIsAllDay() . "',
					[icalendar].[event].[eventNotes] 		= 	'" . $this->model->getEventNotes() . "',
					[icalendar].[event].[eventReminder]		=	'" . $this->model->getEventReminder() . "',
					[icalendar].[event].[eventUrl]			=	'" . $this->model->getEventUrl() . "',
					[icalendar].[event].[eventLocation]		=	'" . $this->model->getEventLocation() . "',
					[icalendar].[event].[eventIsNew]		=	'" . $this->model->getEventIsNew() . "'
			WHERE 	[icalendar].[event].[eventId]			=	'" . $this->model->getEventId(0, 'single') . "'";
		} else
		if ($this->q->vendor == self::ORACLE) {
			$sql = "
			UPDATE	ICALENDAR.EVENT
			SET		ICALENDAR.EVENT.CALENDARID		=	'" . $this->model->getCalendarId() . "',
					ICALENDAR.EVENT.EVENTTITLE		=	'" . $this->model->getEventTitle() . "',
					ICALENDAR.EVENT.EVENTSTART		=	'" . $this->model->getEventStart() . "',
					ICALENDAR.EVENT.EVENTEND		=	'" . $this->model->getEventEnd() . "',
					ICALENDAR.EVENT.EVENTISALLDAY  	= 	'" . $this->model->geteventIsAllDay() . "',
					ICALENDAR.EVENT.EVENTNOTES 		= 	'" . $this->model->getEventNotes() . "',
					ICALENDAR.EVENT.EVENTREMINDER	=	'" . $this->model->getEventReminder() . "',
					ICALENDAR.EVENT.EVENTURL		=	'" . $this->model->getEventUrl() . "',
					ICALENDAR.EVENT.EVENTLOCATION	=	'" . $this->model->getEventLocation() . "',
					ICALENDAR.EVENT.EVENTISNEW		=	'" . $this->model->getEventIsNew() . "'
			WHERE 	ICALENDAR.EVENT.EVENTID			=	'" . $this->model->getEventId(0, 'single') . "'";
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array("success" =>true, "message" => $this->systemString->getUpdateMessage(),"time"=>$time));
		exit();
	}

	/* (non-PHPdoc)
	 * @see ConfigClass::delete()
	 */

	function delete() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->model->delete();
		$this->q->start();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			DELETE 	FROM	`icalendar`.`event`
			WHERE 			`icalendar`.`event`.`eventId`		=	'" . $this->model->getEventId(0, 'single') . "'";
		} else
		if ($this->q->vendor == self::MSSQL) {
			$sql = "
			DELETE 	FROM	[icalendar].[event]
			WHERE 			[icalendar].[event].[eventId]		=	'" . $this->model->getEventId(0, 'single') . "'";
		} else
		if ($this->q->vendor == self::ORACLE) {
			$sql = "
			DELETE 	FROM	ICALENDAR.EVENT
			WHERE 			ICALENDAR.EVENT.EVENTID		=	'" . $this->model->getEventId(0, 'single') . "'";
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$end = microtime(true);
		$time = $end - $start;
		$this->q->commit();
		echo json_encode(
		array("success" => true, "message" => $this->systemString->getDeleteMessage(),"time"=>$time));
		exit();
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
	}

}

$eventObject = new EventClass();
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST['leafId'])) {
		$eventObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST['isAdmin'])) {
		$eventObject->setIsAdmin($_POST['isAdmin']);
	}
	/**
	 * Database Request
	 */
	if (isset($_POST ['databaseRequest'])) {
		$eventObject->setDatabaseRequest($_POST ['databaseRequest']);
	}
	/*
	 *  Load the dynamic value
	 */
	$eventObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST['method'] == 'create') {
		$eventObject->create();
	}
	if ($_POST['method'] == 'read') {
		$eventObject->read();
	}
	if ($_POST['method'] == 'update') {
		$eventObject->update();
	}
	if ($_POST['method'] == 'delete') {
		$eventObject->delete();
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
		$eventObject->setLeafId($_GET['leafId']);
	}
	if (isset($_GET['isAdmin'])) {
		$eventObject->setLeafId($_GET['isAdmin']);
	}

	/*
	 *  Load the dynamic value
	 */
	$eventObject->execute();
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$eventObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$eventObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$eventObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$eventObject->lastRecord('json');
		}
	}
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$eventObject->staff();
		}
	}
}
?>

