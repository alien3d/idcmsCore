<?php
session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
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
class EventClass extends ConfigClass
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
    function execute ()
    {
        parent::__construct();
        //audit property
        $this->audit = 0;
        $this->log = 1;
        
        $this->q = new Vendor();
        $this->q->vendor = $this->getVendor();
        $this->q->leafId = $this->getLeafId();
        $this->q->staffId = $this->getStaffId();
        $this->q->fieldQuery = $this->getFieldQuery();
        $this->q->gridQuery = $this->getGridQuery();
        $this->q->connect($this->getConnection(), $this->getUsername(), 
        $this->getDatabase(), $this->getPassword());
		$this->q->log = $this->log;
        $this->q->audit = $this->audit;
        
		$this->model = new EventModel();
        $this->model->setVendor($this->getVendor());
        $this->model->execute();
        
        $this->documentTrail = new DocumentTrailClass();
        $this->documentTrail->setVendor($this->getVendor());
        $this->documentTrail->execute();
    
        $this->excel = new PHPExcel();
    }
    /* (non-PHPdoc)
	 * @see ConfigClass::create()
	 */
    public function create ()
    {
        header('Content-Type', 'application/json; charset=utf-8');
        if ($this->getVendor() == self::MYSQL) {
            //UTF8
            $sql = "SET NAMES \"utf8\"";
            $this->q->fast($sql);
        }
        $this->model->create();
        $this->q->start();
        if ($this->getVendor() == self::MYSQL) {
            $sql = "
			INSERT INTO `event`(
						`calendarId`,		`eventTitle`,
						`eventStart`,		`eventEnd`,
						`eventIsAllDay`,	`eventNotes`,
						`eventReminder`,	`eventUrl`,
						`eventLocation`,	`eventIsNew`,
						`staffId`,			`executeTime`
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
        } else 
            if ($this->getVendor() == self::MSSQL) {
                $sql = "
			INSERT INTO [event`(
						[calendarId],		[eventTitle],
						[eventStart],		[eventEnd],
						[eventIsAllDay],	[eventNotes],
						[eventReminder],	[eventUrl],
						[eventLocation],	[eventIsNew],
						[staffId],			[executeTime]
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
			INSERT INTO EVENT (
						CALENDARID,			EVENTTITLE,
						EVENTSTART,			EVENTEND,
						EVENTISALLDAY,		EVENTNOTES,
						EVENTREMINDER,		EVENTURL,
						EVENTLOCATION,		EVENTISNEW,
						STAFFID,			EXECUTETIME
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
        echo json_encode(
        array("success" => TRUE, "message" => "Record Created", "evts" => $data, 
        "eventId" => $eventId));
        exit();
    }
    /* (non-PHPdoc)
	 * @see ConfigClass::read()
	 */
    public function read ()
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
			FROM 	`event`
			JOIN    `calendar`
			USING	(`calendarId`,`staffId`)
			JOIN	`calendarColor`
			USING   (`calendarColorId`)
			WHERE 	`calendar`.`staffId` = '" . $this->model->getExecuteBy() . "'";
            if ($this->model->getEventStart() && $this->model->getEventEnd()) {
                $sql .= "
				AND	`event`.`eventStart`	>= 	'" . $this->model->getEventStart() . "'
				AND	`event`.`eventEnd` 		<=	'" . $this->model->getEventEnd() . "'";
            }
        } else 
            if ($this->getVendor() == self::MSSQL) {
                $sql = "
			SELECT	*
			FROM 	[event]
			JOIN    [calendar]
			ON		[event].[calendarId]				= 	[calendar].[calendarId]
			AND		[event].[staffId] 					=	[calendar].[staffId]
			JOIN	[calendarColor]
			ON		[calendarColor].[calendarColorId]	=	[calendar].[calendarColorId]
			WHERE 	[calendar].[staffId] 				= 	'" . $this->model->getExecuteBy() . "'";
                if ($this->model->getEventStart() && $this->model->getEventEnd()) {
                    $sql .= "
				AND	[event].[eventStart]	>= 	'" . $this->model->getEventStart() . "'
				AND	[event].[eventEnd] 		<=	'" . $this->model->getEventEnd() . "'";
                }
            } else 
                if ($this->getVendor() == self::ORACLE) {
                    $sql = "
			SELECT	*
			FROM 	EVENT
			JOIN	CALENDAR
			ON		CALENDAR.CALENDARID 			= 	EVENT.CALENDARID
			AND		CALENDAR.STAFFID				= 	EVENT.STAFFID
			JOIN    CALENDARCOLOR
			ON		CALENDARCOLOR.CALENDARCOLORID	=	CALENDAR.CALENDARCOLORID
			WHERE 	CALENDAR.STAFFID 				= 	'" . $this->model->getExecuteBy() . "'";
                    if ($this->model->getEventStart() &&
                     $this->model->getEventEnd()) {
                        $sql .= "
				AND	EVENT.EVENTSTART 	>=	'" . $this->model->getEventStart() . "'
				AND	EVENT.EVENTEND 		<= 	'" . $this->model->getEventEnd() . "'";
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
            $json_encode = json_encode(
            array('success' => TRUE, 'total' => $total, 
            'message' => 'Data Loaded', 'data' => $items));
            $json_encode = str_replace("[", "", $json_encode);
            $json_encode = str_replace("]", "", $json_encode);
            echo $json_encode;
        } else {
            if (count($items) == 0) {
                $items = '';
            }
            echo json_encode(
            array('success' => TRUE, 'total' => $total, 
            'message' => 'data loaded', 'evts' => $items));
        }
    }
    /* (non-PHPdoc)
	 * @see ConfigClass::update()
	 */
    function update ()
    {
        header('Content-Type', 'application/json; charset=utf-8');
        if ($this->getVendor() == self::MYSQL) {
            //UTF8
            $sql = "SET NAMES \"utf8\"";
            $this->q->fast($sql);
        }
        $this->q->commit();
        $this->model->update();
        if ($this->getVendor() == self::MYSQL) {
            $sql = "
			UPDATE	`event`
			SET		`calendarId`		=	'" . $this->model->getCalendarId() . "',
					`eventTitle`		=	'" . $this->model->getEventTitle() . "',
					`eventStart`		=	'" . $this->model->getEventStart() . "',
					`eventEnd`			=	'" . $this->model->getEventEnd() . "',
					`eventIsAllDay`  	= 	'" . $this->model->geteventIsAllDay() . "',
					`eventNotes` 		= 	'" . $this->model->getEventNotes() . "',
					`eventReminder`		=	'" . $this->model->getEventReminder() . "',
					`eventUrl`			=	'" . $this->model->getEventUrl() . "',
					`eventLocation`		=	'" . $this->model->getEventLocation() . "',
					`eventIsNew`		=	'" . $this->model->getEventIsNew() . "'
			WHERE 	`eventId`			=	'" . $this->model->getEventId(0, 'single') . "'";
        } else 
            if ($this->q->vendor == self::MSSQL) {
                $sql = "
			UPDATE	[event]
			SET		[calendarId]		=	'" . $this->model->getCalendarId() . "',
					[eventTitle]		=	'" . $this->model->getEventTitle() . "',
					[eventStart]		=	'" . $this->model->getEventStart() . "',
					[eventEnd]			=	'" . $this->model->getEventEnd() . "',
					[eventIsAllDay]  	= 	'" . $this->model->geteventIsAllDay() . "',
					[eventNotes] 		= 	'" . $this->model->getEventNotes() . "',
					[eventReminder]		=	'" . $this->model->getEventReminder() . "',
					[eventUrl]			=	'" . $this->model->getEventUrl() . "',
					[eventLocation]		=	'" . $this->model->getEventLocation() . "',
					[eventIsNew]		=	'" . $this->model->getEventIsNew() . "'
			WHERE 	[eventId]			=	'" . $this->model->getEventId(0, 'single') . "'";
            } else 
                if ($this->q->vendor == self::ORACLE) {
                    $sql = "
			UPDATE	EVENT
			SET		CALENDARID		=	'" . $this->model->getCalendarId() . "',
					EVENTTITLE		=	'" . $this->model->getEventTitle() . "',
					EVENTSTART		=	'" . $this->model->getEventStart() . "',
					EVENTEND		=	'" . $this->model->getEventEnd() . "',
					EVENTISALLDAY  	= 	'" . $this->model->geteventIsAllDay() . "',
					EVENTNOTES 		= 	'" . $this->model->getEventNotes() . "',
					EVENTREMINDER	=	'" . $this->model->getEventReminder() . "',
					EVENTURL		=	'" . $this->model->getEventUrl() . "',
					EVENTLOCATION	=	'" . $this->model->getEventLocation() . "',
					EVENTISNEW		=	'" . $this->model->getEventIsNew() . "'
			WHERE 	EVENTID			=	'" . $this->model->getEventId(0, 'single') . "'";
                }
        $this->q->update($sql);
        if ($this->q->execute == 'fail') {
            echo json_encode(
            array("success" => false, "message" => $this->q->responce));
            exit();
        }
        $this->q->commit();
        echo json_encode(
        array("success" => TRUE, "message" => "Record updated"));
        exit();
    }
    /* (non-PHPdoc)
	 * @see ConfigClass::delete()
	 */
    function delete ()
    {
        header('Content-Type', 'application/json; charset=utf-8');
        if ($this->getVendor() == self::MYSQL) {
            //UTF8
            $sql = "SET NAMES \"utf8\"";
            $this->q->fast($sql);
        }
        $this->model->delete();
        $this->q->start();
        if ($this->getVendor() == self::MYSQL) {
            $sql = "
			DELETE 	FROM	`event`
			WHERE 			`eventId`		=	'" . $this->model->getEventId(0, 'single') . "'";
        } else 
            if ($this->q->vendor == self::MSSQL) {
                $sql = "
			DELETE 	FROM	[event]
			WHERE 			[eventId]		=	'" . $this->model->getEventId(0, 'single') . "'";
            } else 
                if ($this->q->vendor == self::ORACLE) {
                    $sql = "
			DELETE 	FROM	EVENT
			WHERE 			EVENT		=	'" . $this->model->getEventId(0, 'single') . "'";
                }
        $this->q->update($sql);
        if ($this->q->execute == 'fail') {
            echo json_encode(
            array("success" => false, "message" => $this->q->responce));
            exit();
        }
        $this->q->commit();
        echo json_encode(
        array("success" => TRUE, "message" => "Record updated"));
        exit();
    }
    /* (non-PHPdoc)
	 * @see config::excel()
	 */
    function excel ()
    {
        header('Content-Type', 'application/json; charset=utf-8');
        if ($this->getVendor() == self::MYSQL) {
            //UTF8
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
    if (isset($_GET['field'])) {
        if ($_GET['field'] == 'staffId') {
            $eventObject->staff();
        }
    }
}
?>

