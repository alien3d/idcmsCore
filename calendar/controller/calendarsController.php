<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../model/calendarModel.php");
require_once ("../model/calendarModel.php");;
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package calendars
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class calendarsClass extends  configClass {
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
	public $calendarId;
	/**
	 * Current Table Event Indentification Value
	 * @var numeric $eventId
	 */
	public $calendarColorId;
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
	}



	/**
	 * Read calendar
	 */
	public function read_calendar() 				{

		//header('Content-type: application/json');
		$sql	=	"
				SELECT	`calendarColorId`,
				        `calendartitle`
				FROM 	`calendarColor`
				JOIN    `calendar`
				USING   (`calendarColorId`)
				WHERE 	`staffId` = '".$this->staffId."'";
		$this->q->read($sql);
		$this->total	= $this->q->numberRows();
		$items =array();
	
		while($row  = 	$this->q->fetchAssoc()) {
			$items[] =$row;
		}
		echo json_encode(array('calendars' => $items
		));
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create(){}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() 				{
		header('Content-type: application/json');
		// everything given flexibility  on todo
		$sql="SELECT *
				      FROM `calendarColor`
				      JOIN    `calendar`
				USING   (`calendarColorId`)
				WHERE `staffId` = '".$this->staffId."' ";

		// searching filtering
		$sql.=$this->q->searching();

		$this->q->read($sql);
		$total	= $this->q->numberRows();
		//paging
		// this is sorting  future
		if(empty($_POST['dir'])) {
			$dir = 'ASC';
		} else {
			$dir  = $_POST['dir'];
		}
		if(empty($_POST['sort'])) {
			$sort_field = "calendar_uniqueId";
		} else {
			$sort_field = $_POST['sort'];
		}
		$sql.="	ORDER BY `".$sort_field."` ".$dir." ";
		if(isset($_POST['start']) && isset($_POST['limit'])) {
			$sql.=" LIMIT  ".$_POST['start'].",".$_POST['limit']." ";
		}

		$this->q->read($sql);
		$items = array();
		while($row  = 	$this->q->fetchAssoc()) {
			$items[]			=	$row;
		}

		if($this->q->execute=='fail') {
			$this->msg('false','Loading Data Error');
		}else {
			// bugs on extjs
			if($_POST['method']=='read' && $_POST['mode']=='update') {
				$json_encode = json_encode(
				array('success'=>'true',
									   'total' => $this->total,
       								   'data' => $items
				));
				$json_encode=str_replace("[","",$json_encode);
				$json_encode=str_replace("]","",$json_encode);
				echo $json_encode;
			} else {
				if(count($items)==0) {
					$items='';
				}
				echo json_encode(
				array('success'=>'true',
									   'total' => $this->total,
       								   'data' => $items
				));
			}
		}
		

	}



	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update(){

		header('Content-type: application/json');

		$this->q->start();
		$sql="
					UPDATE 	`calendar`
					SET 	`calendarTitle`	=	'".$this->strict($_POST['cal_title'],'s')."'
					WHERE 	`calendarId`		=	'".$this->strict($_POST['cal_own_uniqueId'],'n')."'";

		$this->q->update($sql);
		$this->q->commit();

		if($this->q->execute=='fail') {
			$this->msg(false,$this->q->result_text);
			exit();
		} else {
			$this->msg(true,'Update query Sucess');
			exit();
		}

	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete(){}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	/**
	 *  Event Creation
	 */
	
	function excel(){}
}

$calendarsObject  	= 	new calendarsClass();

if(isset($_POST['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_GET['leafId'])){
		$calendarsObject-> leafId  = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$calendarsObject -> execute();

	if(isset($_POST['calendarId'])){
		$calendarsObject -> calendarId = $_POST['calendarId'];
		if($_POST['method']=='update') {
			$calendarsObject ->update();
		}
		if($_POST['method']=='delete') {
			$calendarsObject ->delete();
		}
	}
	
}
if(isset($_GET['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_GET['leafId'])){
		$calendarsObject-> leafId  = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$calendarsObject -> execute();
	if(isset($_GET['mode'])){
		if($_GET['mode']=='calendar'){
			$calendarsObject ->read_calendar();
		}
		if($_GET['mode']=='event'){
			$calendarsObject ->read_event();
		}

	}
	if(isset($_GET['field'])){
		if($_GET['field']=='staffId'){
			$calendarsObject->staffId();
		}
	}
}
?>

