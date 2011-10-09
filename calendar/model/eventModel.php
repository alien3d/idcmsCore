<?php
require_once ("../../class/classValidation.php");
/**
 * this is event model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package calendar
 * @subpackage event
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class EventModel extends ValidationClass
{
    /**
     * Event Identification
     * @var int
     */
    private $eventId;
    /**
     * Calendar Identification. This is color identification will link up with the css file
     * @var int
     */
    private $calendarId;
    /**
     * Event Title
     * @var string
     */
    private $eventTitle;
    /**
     * Event Date
     * @var date
     */
    private $eventStart;
    /**
     * Event End.
     * @var date
     */
    private $eventEnd;
    /**
     * Event Is All Days.
     * @var bool
     */
    private $eventIsAllDay;
    /**
     * Event Notes
     * @var string
     */
    private $eventNotes;
    /**
     * Event Reminder
     * @var bool
     */
    private $reminder;
    /**
     * Event Url.E.g  www.idcmsCore.org
     * @var url
     */
    private $eventUrl;
    /**
     * Event Location. E.g  At the office ,Kuala Lumpur,
     * @var string
     */
    private $eventLocation;
    /**
     * Event Is New. ** Only available on Extensible
     * @var string
     */
    private $eventIsNew;
    /**
     * Staff Identification
     * @var int
     */
    private $staffId;
    /**
     * Class Loader to load outside variable and test it suppose variable type
     */
    function execute ()
    {
        /*
		 *  Basic Information Table
		 */
        $this->setTableName('event');
        $this->setPrimaryKeyName('eventId');
        /*
		 *  All the $_POST enviroment.
		 */
        if (isset($_POST['eventId'])) {
            $this->setEventId($this->strict($_POST['eventId'], 'numeric'), 0, 
            'single');
        }
        if (isset($_POST['calendarId'])) {
            $this->setCalendarId($this->strict($_POST['calendarId'], 'numeric'));
        }
        if (isset($_POST['eventTitle'])) {
            $this->setEventTitle($this->strict($_POST['eventTitle'], 'string'));
        }
        if (isset($_POST['eventStart'])) {
            $this->setEventStart(
            date("Y-m-d H:i:s", strtotime($_POST['eventStart'])));
        }
        if (isset($_POST['eventEnd'])) {
            $this->setEventEnd(
            date("Y-m-d H:i:s", strtotime($_POST['eventEnd'])));
        }
        if (isset($_POST['eventIsAllDay'])) {
            $this->setEventIsAllDay(
            $this->strict($_POST['eventIsAllDay'], 'numeric'));
        }
        if (isset($_POST['eventNotes'])) {
            $this->setEventNotes($this->strict($_POST['eventNotes'], 'memo'));
        }
        if (isset($_POST['eventUrl'])) {
            $this->setEventUrl($this->strict($_POST['eventUrl'], 'string'));
        }
        if (isset($_POST['eventLocation'])) {
            $this->setEventLocation(
            $this->strict($_POST['eventLocation'], 'numeric'));
        }
        if (isset($_POST['eventIsNew'])) {
            $this->setEventIsNew($this->strict($_POST['eventIsNew'], 'numeric'));
        }
        if (isset($_SESSION['staffId'])) {
            $this->setExecuteBy($_SESSION['staffId']);
        }
        if ($this->vendor == 'normal' || $this->getVendor() == self::MYSQL) {
            $this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
        } else 
            if ($this->getVendor() == self::MSSQL) {
                $this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
            } else 
                if ($this->getVendor() == self::ORACLE) {
                    $this->setExecuteTime(
                    "to_date('" . date("Y-m-d H:i:s") .
                     "','YYYY-MM-DD HH24:MI:SS')");
                }
    }
    /* (non-PHPdoc)
	 * @see ValidationClass::create()
	 */
    public function create ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(1, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(1, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
        $this->setIsReview(0, 0, 'single');
        $this->setIsPost(0, 0, 'single');
    }
    /* (non-PHPdoc)
	 * @see ValidationClass::update()
	 */
    public function update ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(0, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(1, 0, 'single');
        $this->setIsActive(1, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
        $this->setIsReview(0, 0, 'single');
        $this->setIsPost(0, 0, 'single');
    }
    /* (non-PHPdoc)
	 * @see ValidationClass::delete()
	 */
    public function delete ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(0, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(0, 0, 'single');
        $this->setIsDelete(1, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
        $this->setIsReview(0, 0, 'single');
        $this->setIsPost(0, 0, 'single');
    }
    /* (non-PHPdoc)
	 * @see ValidationClass::draft()
	 */
    public function draft ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(1, 0, 'single');
        $this->setIsDraft(1, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(0, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
        $this->setIsReview(0, 0, 'single');
        $this->setIsPost(0, 0, 'single');
    }
    /* (non-PHPdoc)
	 * @see ValidationClass::draft()
	 */
    public function approved ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(1, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(0, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(1, 0, 'single');
        $this->setIsReview(0, 0, 'single');
        $this->setIsPost(0, 0, 'single');
    }
    /* (non-PHPdoc)
     * @see ValidationClass::review()
    */
    public function review ()
    {
    $this->setIsDefault(0, 0, 'single');
    $this->setIsNew(1, 0, 'single');
    $this->setIsDraft(0, 0, 'single');
    $this->setIsUpdate(0, 0, 'single');
    $this->setIsActive(0, 0, 'single');
    $this->setIsDelete(0, 0, 'single');
    $this->setIsApproved(0, 0, 'single');
    $this->setIsReview(1, 0, 'single');
    $this->setIsPost(0, 0, 'single');
    }
    /* (non-PHPdoc)
    * @see ValidationClass::post()
    */
    public function post ()
    {
    $this->setIsDefault(0, 0, 'single');
    $this->setIsNew(1, 0, 'single');
    $this->setIsDraft(0, 0, 'single');
    $this->setIsUpdate(0, 0, 'single');
    $this->setIsActive(0, 0, 'single');
    $this->setIsDelete(0, 0, 'single');
    $this->setIsApproved(1, 0, 'single');
    $this->setIsReview(0, 0, 'single');
    $this->setIsPost(1, 0, 'single');
    }
    /**
     * Set Event Identification Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setEventId ($value, $key, $type)
    {
        if ($type == 'string') {
            $this->eventId = $value;
        } else 
            if ($type == 'array') {
                $this->eventId[$key] = $value;
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:setEventId ?"));
                exit();
            }
    }
    /**
     * Return Event Identification Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return int|array
     */
    public function getEventId ($key, $type)
    {
        if ($type == 'string') {
            return $this->eventId;
        } else 
            if ($type == 'array') {
                return $this->eventId[$key];
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:getEventId ?"));
                exit();
            }
    }
    /**
     * Set Calendar Identification Value
     * @param  int $value
     */
    public function setCalendarId ($value)
    {
        $this->calendarId = $value;
    }
    /**
     * Return Calendar Identification Value
     * @return int
     */
    public function getCalendarId ()
    {
        return $this->calendarId;
    }
    /**
     * Set Event Title Value
     * @param string $value
     */
    public function setEventTitle ($value)
    {
        $this->eventTitle = $value;
    }
    /**
     * Return Event Title Value
     * @return string
     */
    public function getEventTitle ()
    {
        return $this->eventTitle;
    }
    /**
     * Set Event Start Value
     * @param date $value
     */
    public function setEventStart ($value)
    {
        $this->eventStart = $value;
    }
    /**
     * Return Event Start Value
     * @return date
     */
    public function getEventStart ()
    {
        return $this->eventStart;
    }
    /**
     * Set Event End Value
     * @param date $value
     */
    public function setEventEnd ($value)
    {
        $this->eventEnd = $value;
    }
    /**
     * Return Event End Value
     * @return date
     */
    public function getEventEnd ()
    {
        return $this->eventEnd;
    }
    /**
     * Set Event Is All Days Value
     * @param bool
     */
    public function setEventIsAllDay ($value)
    {
        $this->eventIsAllDay = $value;
    }
    /**
     * Return Event Is All Days Value
     * @return bool
     */
    public function getEventIsAllDay ()
    {
        return $this->eventIsAllDay;
    }
    /**
     * Set Event Notes Value
     * @param string $value
     */
    public function setEventNotes ($value)
    {
        $this->eventNotes = $value;
    }
    /**
     * Return Event Notes Value
     * @return string
     */
    public function getEventNotes ()
    {
        return $this->eventNotes;
    }
    /**
     * Set Event Reminder Value
     * @param string $value
     */
    public function setEventReminder ($value)
    {
        $this->eventReminder = $value;
    }
    /**
     * Return Event Reminder Value
     * @return string
     */
    public function getEventReminder ()
    {
        return $this->eventReminder;
    }
    /**
     * Set Event Url Value
     * @param string $value
     */
    public function setEventUrl ($value)
    {
        $this->eventUrl = $value;
    }
    /**
     * Return Event Url Value
     * @return string
     */
    public function getEventUrl ()
    {
        return $this->eventUrl;
    }
    /**
     * Set Event Location Value
     * @param string $value
     */
    public function setEventLocation ($value)
    {
        $this->eventLocation = $value;
    }
    /**
     * Return Event Location Value
     * @return string
     */
    public function getEventLocation ()
    {
        return $this->eventLocation;
    }
    /**
     * Set Event New Value
     * @param bool $value
     */
    public function setEventIsNew ($value)
    {
        $this->eventIsNew = $value;
    }
    /**
     * Return Event New Value
     * @return bool
     */
    public function getEventIsNew ()
    {
        return $this->eventIsNew;
    }
    /**
     * Set Staff Identification Value
     * @param  int $value
     */
    public function setStaffId ($value)
    {
        $this->staffId = $value;
    }
    /**
     * Return  Staff Identification value
     * @return int
     */
    public function getStaffId ()
    {
        return $this->staffId;
    }
}
?>
