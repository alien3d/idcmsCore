<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../model/eventModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package calendars
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class eventClass extends  configClass {
	/**
	 * Connection to the database
	 * @var string $excel
	 */
	public $q;

	/**
	 * Program Identification
	 * @var numeric $leafId
	 */
	public $leafId;
	/**
	 * User Identification
	 * @var numeric $staffId
	 */
	public $staffId;
	/**
	 *	 Database Selected
	 *   string $database;
	 */
	public $database;
	/**
	 * Database Vendor
	 * @var string $vendor
	 */
	public $vendor;
	/**
	 * Extjs Grid Filter Array
	 * @var string $filter
	 */
	public $filter;
	/**
	 * Extjs Grid  single query information
	 * @var string $query
	 */
	public $query;
	/**
	 * Fast Search Variable
	 * @var string $quickFilter
	 */
	public $quickFilter;

	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string $excel
	 */
	private  $excel;


	/**
	 * Document Trail Audit.
	 * @var string $doc_$trail;
	 */
	private  $doc_trail;

	/**
	 *  Ascending ,Descending ASC,DESC
	 * @var string $order;`
	 */
	public $order;

	/**
	 * Sort the default field.Mostly consider as primary key default.
	 * @var string $sort_field
	 */
	public $sort_field;
	/**
	 * Default Language  : English
	 * @var numeric $defaultLanguageId
	 */
	private $defaultLanguageId;
	/**
	 * Audit Row True or False
	 * @var boolean $audit
	 */
	private $audit;
	/**
	 * Current Table calendar Indentification Value
	 * @var numeric $calendarId
	 */
	public $calendarColorId;
	/**
	 * Current Table Event Indentification Value
	 * @var numeric $eventId
	 */
	public $eventId;
	/**
	 * Class Loader
	 */
	function execute() {
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->vendor;

		$this->q->leafId			=	$this->leafId;

		$this->q->staffId			=	$this->staffId;

		$this->q->filter 			= 	$this->filter;

		$this->q->quickFilter		=	$this->quickFilter;

		$this->q->connect($this->connection, $this->username,$this->database,$this->password);

		$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;

		$this->log					=   0;

		$this->q->log 				= $this->log;
		
		$this->model				= new eventModel();
	}







	/* (non-PHPdoc)
	 * @see configClass::create()
	 */
	public function create() 				{

		header('Content-type: application/json');
		$this->model->create();
		$this->q->start();
		if($this->q->vendor=='mysql' || $this->q->vendor=='normal'){
			
		} else if ($this->q->vendor=='microsoft')
		$sql="
					INSERT INTO `event`
							(
								`calendarId`,
								`calenderTitle`,
								`calendarStart`,
								`calendarEnd`,
								`calendarAd`,
								`calendarNotes`,
								`calenderRem`,
								`calenderUrl`,
								`calenderLoc`,
								`calendearN`,
								`staffId`,
								`isNew`
								`isDraft`,
								`isUpdate`,
								`isDelete`,
								`By`,
								`Time`
							)
					VALUES	(
								'".$this->strict($_POST['calendar_uniqueId'],'n')."',
								'".$this->strict($_POST['title'],'s')."',
								'".date("Y-m-d H:i:s", strtotime($_POST['start']))."',
								'".date("Y-m-d H:i:s", strtotime($_POST['end']))."',
								'".$this->strict($_POST['ad'],'c')."',
								'".$this->strict($_POST['notes'],'s')."',
								'".$this->strict($_POST['rem'],'c')."',
								'".$this->strict($_POST['url'],'c')."',
								'".$this->strict($_POST['loc'],'s')."',
								'".$this->strict($_POST['n'],'c')."',
								'".$_SESSION['staff_uniqueId']."'
							);";

		$this->q->create($sql);
		$this->q->commit();

		


	}
	
	/* (non-PHPdoc)
	 * @see configClass::read()
	 */
	public function read() 				{
		
		header('Content-type: application/json');
		$sql	=	"
				SELECT	*
				FROM 	`event`
				JOIN    `calendarColor`
				USING   (`calendarColorId`)
				WHERE 	1
				AND     `calendar`.`staffId` = '".$this->staffId."'";
		$this->q->read($sql);
		$total	= $this->q->numberRows();
		$items =array();

		while($row  = 	$this->q->fetchAssoc()) {
			$items[] =$row;
		}
		echo json_encode(array('evts' => $items
		));
	}

	
	/* (non-PHPdoc)
	 * @see configClass::update()
	 */
	function update() 				{

		header('Content-type: application/json');
		$this->model->update();
		$this->q->start();
		$sql="
					UPDATE 	`event`
					SET 	`calendarId`	=	'".$this->strict($_POST['calendar_uniqueId'],'n')."',
							`eventTitle`	=	'".$this->strict($_POST['title'],'s')."',
							`eventStart`	=	'".date("Y-m-d H:i:s", strtotime($_POST['start']))."',
							`eventEnd`	=	'".date("Y-m-d H:i:s", strtotime($_POST['end']))."',
							`eventAddress`    = 	'".$this->strict($_POST['ad'],'c')."',
							`EventNotes` = 	'".$this->strict($_POST['notes'],'s')."',
							`eventReminder`	=	'".$this->strict($_POST['rem'],'c')."',
							`eventUrl`	=	'".$this->strict($_POST['url'],'c')."',
							`eventLocation`	=	'".$this->strict($_POST['loc'],'s')."',
							`eventN`	=	'".$this->strict($_POST['n'],'c')."'
					WHERE 	`eventId`		=	'".$this->strict($_POST['eventId'],'n')."'";

		$this->q->update($sql);
		$this->q->commit();

		

	}
	
	/* (non-PHPdoc)
	 * @see configClass::delete()
	 */
	function delete()				{

		header('Content-type: application/json');
		$this->model->delete();
		$this->q->start();
		$sql="
			UPDATE	`event`
			SET		`isNew`		=	0
					`isUpdate`	=	0
					`isDraft`	= 	0
					`isDelete` 	=	1
			WHERE 	`eventId`	=	'".$this->strict($_POST['event_uniqueId'],'n')."'";
		$this->q->update($sql);
		$this->q->commit();
		

	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel(){}
}

$eventObject  	= 	new eventClass();

if(isset($_POST['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_GET['leafId'])){
		$eventObject-> leafId  = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$eventObject -> execute();
	if($_POST['method']=='create'){
		$eventObject->create_event();
	}

	if(isset($_POST['eventId'])){
		$eventObject -> eventId = $_POST['eventId'];
		if($_POST['method']=='update') {
			$eventObject ->update_event();
		}
		if($_POST['method']=='delete') {
			$eventObject ->delete_event();
		}
	}
}
if(isset($_GET['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_GET['leafId'])){
		$eventObject-> leafId  = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$eventObject -> execute();
	if(isset($_GET['mode'])){
		if($_GET['mode']=='calendar'){
			$eventObject ->read_calendar();
		}
		if($_GET['mode']=='event'){
			$eventObject ->read_event();
		}

	}
	if(isset($_GET['field'])){
		if($_GET['field']=='staffId'){
			$eventObject->staffId();
		}
	}
}
?>

