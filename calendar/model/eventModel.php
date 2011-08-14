<?php require_once("../../class/classValidation.php");

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
class eventModel extends validationClass{



	private $eventId;
	private $calendarId;
	private $eventTitle;
	private $eventStart;
	private $eventEnd;
	private $eventIsAllDay;
	private $eventNotes;
	private $reminder;
	private $eventUrl;
	private $eventLocation;
	private $staffId;

	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('event');
		$this->setPrimaryKeyName('eventId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['eventId'])){
			$this->eventId = $this->strict($_POST['eventId'],'numeric');
		}
		if(isset($_POST['calendarId'])){
			$this->calendarId = $this->strict($_POST['calendarId'],'numeric');
		}
		if(isset($_POST['eventTitle'])){
			$this->eventTitle = $this->strict($_POST['eventTitle'],'string');
		}
		if(isset($_POST['eventStart'])){
			$this->eventStart = date("Y-m-d H:i:s", strtotime($_POST['eventStart']));
		}
		if(isset($_POST['eventEnd'])){
			$this->eventEnd = date("Y-m-d H:i:s", strtotime($_POST['eventEnd']));
		}
		if(isset($_POST['eventIsAllDay'])){
			$this->eventIsAllDay = $this->strict($_POST['eventIsAllDay'],'numeric');
		}
		if(isset($_POST['eventNotes'])){
			$this->eventNotes = $this->strict($_POST['eventNotes'],'memo');
		}
		if(isset($_POST['eventUrl'])){
			$this->eventUrl = $this->strict($_POST['eventUrl'],'string');
		}
		if(isset($_POST['eventLocation'])){
			$this->eventLocation = $this->strict($_POST['eventLocation'],'numeric');
		}
		if(isset($_POST['eventIsNew'])){
			$this->eventIsNew = $this->strict($_POST['eventIsNew'],'numeric');
		}

		if(isset($_SESSION['staffId'])){
			$this->setBy($_SESSION['staffId']);
		}
		if($this->vendor=='normal' || $this->getVendor()==self::mysql){
			$this->setTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::mssql){
			$this->setTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::oracle){
			$this->setTime("to_date(\"".date("Y-m-d H:i:s")."\",'YYYY-MM-DD HH24:MI:SS')");
		}


	}

	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	public function create()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(1,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(1,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(0,0,'string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	public function update()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(0,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(1,0,'string');
		$this->setIsActive(1,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(0,0,'string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	public function delete()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(0,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(0,0,'string');
		$this->setIsDelete(1,0,'string');
		$this->setIsApproved(0,0,'string');
	}


	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function draft()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(1,0,'string');
		$this->setIsDraft(1,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(0,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(0,0,'string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function approved()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(1,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(0,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(1,0,'string');
	}
	/**
	 * Set Event Identification Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setEventId($value, $key, $type)
	{
		if ($type=='single') {
			$this->eventId = $value;
		} else if ($type == 'array') {
			$this->eventId[$key] = $value;
		}
	}
	/**
	 * Return Event Identification Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getEventId($key , $type)
	{
		if ($type=='single') {
			return $this->eventId;
		} else if ($type == 'array') {
			return $this->eventId[$key];
		} else {
			echo json_encode(array(
                "success" => false,
                "message" => "Cannot Identifiy Type"
                ));
                exit();
		}
	}
	/**
	 * Set Calendar Identification Value
	 * @param  int $value
	 */
	public function setCalendarColorId($value)
	{
		$this->calendarId = $value;
	}
	/**
	 * Return Calendar Identification Value
	 * @return int
	 */
	public function getCalendarId()
	{
		return $this->calendarId;
	}
	/**
	 * Set Event Title Value
	 * @param string $value
	 */
	public function setEventTitle($value)
	{
		$this->eventTitle = $value;
	}
	/**
	 * Return Event Title Value
	 * @return string
	 */
	public function getEventTitle()
	{
		return $this->eventTitle;
	}

	/**
	 * Set Event Start Value
	 * @param date $value
	 */
	public function setEventStart($value)
	{
		$this->eventStart = $value;
	}
	/**
	 * Return Event Start Value
	 * @return date
	 */
	public function getEventStart()
	{
		return $this->eventStart;
	}

	/**
	 * Set Event End Value
	 * @param date $value
	 */
	public function setEventEnd($value)
	{
		$this->eventEnd = $value;
	}
	/**
	 * Return Event End Value
	 * @return date
	 */
	public function getEventEnd()
	{
		return $this->eventEnd;
	}
	/**
	 * Set Event Is All Days Value
	 * @param bool
	 */
	public function setEventIsAllDay($value)
	{
		$this->eventIsAllDay = $value;
	}
	/**
	 * Return Event Is All Days Value
	 * @return bool
	 */
	public function getEventIsAllDay()
		
	{
		return $this->eventIsAllDay;
	}

	/**
	 * Set Event Notes Value
	 * @param string $value
	 */
	public function setEventNotes($value)
	{
		$this->eventNotes = $value;
	}
	/**
	 * Return Event Notes Value
	 * @return string 
	 */
	public function getEventNotes()
	{
		return $this->eventNotes;
	}

	/**
	 * Set Event Reminder Value
	 * @param string $value
	 */
	public function setEventReminder($value)
	{
		$this->eventReminder = $value;
	}
	/**
	 * Return Event Reminder Value
	 * @return string 
	 */
	public function getEventReminder()
	{
		return $this->eventReminder;
	}

	/**
	 * Set Event Url Value
	 * @param string $value
	 */
	public function setEventUrl($value)
	{
		$this->eventUrl = $value;
	}
	/**
	 * Return Event Url Value
	 * @return string 
	 */
	public function getEventUrl()
	{
		return $this->eventUrl;
	}


	/**
	 * Set Event Location Value
	 * @param string $value
	 */
	public function setEventLocation($value)
	{
		$this->eventLocation = $value;
	}
	/**
	 * Return Event Location Value
	 * @return string 
	 */
	public function getEventLocation()
	{
		return $this->eventLocation;
	}

	/**
	 * Set Event New Value
	 * @param bool $value
	 */
	public function setEventIsNew($value)
	{
		$this->eventIsNew = $value;
	}
	/**
	 * Return Event New Value
	 * @return bool
	 */
	public function getEventIsNew()
	{
		return $this->eventIsNew;
	}


	/**
	 * Set Staff Identification Value
	 * @param  int $value
	 */
	public function setStaffId($value)
	{
		$this->staffId = $value;
	}
	/**
	 * Return  Staff Identification value
	 * @return int
	 */
	public function staffId()
	{
		return $this->staffId;
	}
}
?>
