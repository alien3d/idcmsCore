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
	public $tableName;
	public $primaryKeyName;
	public $eventId;
	public $calendarId;
	public $eventTitle;
	public $eventStart;
	public $eventEnd;
	public $eventAddress;
	public $eventNotes;
	public $reminder;
	public $eventUrl;
	public $eventLocation;
	public $eventN;
	public $staffId;
	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->tableName 		=	'event';
		$this->primaryKeyName 	=	'eventId';
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
			$this->eventStart = $this->strict($_POST['eventStart'],'datetime');
		}
		if(isset($_POST['eventEnd'])){
			$this->eventEnd = $this->strict($_POST['eventEnd'],'datetime');
		}
		if(isset($_POST['eventAddress'])){
			$this->eventAddress = $this->strict($_POST['eventAddress'],'numeric');
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
		if(isset($_POST['eventN'])){
			$this->eventN = $this->strict($_POST['eventN'],'numeric');
		}

		if(isset($_SESSION['staffId'])){
			$this->By = $_SESSION['staffId'];
		}
		if($this->vendor=='normal' || $this->vendor=='mysql'){
			$this->Time = "'".date("Y-m-d H:i:s")."'";
		} else if ($this->vendor=='microsoft'){
			$this->Time = "'".date("Y-m-d H:i:s")."'";
		} else if ($this->vendor=='oracle'){
			$this->Time = "to_date('".date("Y-m-d H:i:s")."','YYYY-MM-DD HH24:MI:SS')";
		}


	}
	
	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	function create() {
	

	}

	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	function update() {
	
	}
	/* (non-PHPdoc)
	 * @see configClass::delete()
	 */
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	function delete() {
	
	}
	
}
?>