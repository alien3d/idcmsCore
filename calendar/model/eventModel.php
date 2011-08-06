<?php require_once("../../class/classValidation.php");

/**
 * this is religion model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package religion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class eventModel extends validationClass{



	private $eventId;
	private $calendarId;
	private $eventTitle;
	private $eventStart;
	private $eventEnd;
	private $eventIsAllDays;
	private $eventNotes;
	private $reminder;
	private $eventUrl;
	private $eventLocation;
	private $eventNotes;
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
			$this->eventStart = $this->strict($_POST['eventStart'],'date');
		}
		if(isset($_POST['eventEnd'])){
			$this->eventEnd = $this->strict($_POST['eventEnd'],'date');
		}
		if(isset($_POST['eventIsAllDays'])){
			$this->eventIsAllDays = $this->strict($_POST['eventIsAllDays'],'numeric');
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
		$this->setIsDefault(0);
		$this->setIsNew(1);
		$this->setIsDraft(0);
		$this->setIsUpdate(0);
		$this->setIsActive(1);
		$this->setIsDelete(0);
		$this->setIsApproved(0);
	}
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	public function update()
	{
		$this->setIsDefault(0);
		$this->setIsNew(0);
		$this->setIsDraft(0);
		$this->setIsUpdate(1);
		$this->setIsActive(1);
		$this->setIsDelete(0);
		$this->setIsApproved(0);
	}
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	public function delete()
	{
		$this->setIsDefault(0);
		$this->setIsNew(0);
		$this->setIsDraft(0);
		$this->setIsUpdate(0);
		$this->setIsActive(0);
		$this->setIsDelete(1);
		$this->setIsApproved(0);
	}


/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function draft()
	{
		$this->setIsDefault(0,'','string');
		$this->setIsNew(1,'','string');
		$this->setIsDraft(1,'','string');
		$this->setIsUpdate(0,'','string');
		$this->setIsActive(0,'','string');
		$this->setIsDelete(0,'','string');
		$this->setIsApproved(0,'','string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function approved()
	{
		$this->setIsDefault(0,'','string');
		$this->setIsNew(1,'','string');
		$this->setIsDraft(0,'','string');
		$this->setIsUpdate(0,'','string');
		$this->setIsActive(0,'','string');
		$this->setIsDelete(0,'','string');
		$this->setIsApproved(1,'','string');
	}	
	/**
	 * Set Event Identification Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setEventId($value, $key = NULL, $type = NULL)
	{
		if ($type=='single') {
			$this->eventId = $value;
		} else if ($type == 'array') {
			$this->eventId[$key] = $value;
		}
	}
	/**
	 * Return Event Identification Value
	 * @return integer eventId
	 */
	public function getEventId($key = NULL, $type = NULL)
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
	 * @param numeric $value
	 */
	public function setCalendarColorId($value)
	{
		$this->calendarId = $value;
	}
	/**
	 * Return Calendar Identification Value
	 * @return string calendar identification
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
	 * @return string Event Title
	 */
	public function getEventTitle()
	{
		return $this->eventTitle;
	}

	/**
	 * Set Event Start Value
	 * @param datetime $value
	 */
	public function setEventStart($value)
	{
		$this->eventStart = $value;
	}
	/**
	 * Return Event Start Value
	 * @return datetime Event Start
	 */
	public function getEventStart()
	{
		return $this->eventStart;
	}

	/**
	 * Set Event End Value
	 * @param datetime $value
	 */
	public function setEventEnd($value)
	{
		$this->eventEnd = $value;
	}
	/**
	 * Return Event End Value
	 * @return datetime Event Start
	 */
	public function getEventEnd()
	{
		return $this->eventEnd;
	}
	/**
	 * Set Event Address Value
	 * @param string $value
	 */
	public function setEventIsAllDays($value)
	{
		$this->eventIsAllDays = $value;
	}
	/**
	 * Return Event Address Value
	 * @return string Event Address
	 */
	public function getEventIsAllDays()
	{
		return $this->eventIsAllDays;
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
	 * @return string Event Notes
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
	 * @return string Event Reminder
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
	 * @return string Event Url
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
	 * @return string Event Location
	 */
	public function getEventLocation()
	{
		return $this->eventLocation;
	}

	/**
	 * Set Event New Value
	 * @param boolean $value
	 */
	public function setEventIsNew($value)
	{
		$this->eventIsNew = $value;
	}
	/**
	 * Return Event New Value
	 * @return boolean Event New
	 */
	public function getEventIsNew()
	{
		return $this->eventIsNew;
	}


	/**
	 * Set Staff Identification Value
	 * @param numeric $value
	 */
	public function setStaffId($value)
	{
		$this->staffId = $value;
	}
	/**
	 * Return  Staff Identification value
	 * @return numeric $staffId
	 */
	public function staffId()
	{
		return $this->staffId;
	}
}
?>
