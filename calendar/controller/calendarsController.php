<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../model/calendarModel.php");
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
	/*
	 * Connection to the database
	 * @var string $excel
	 */
	public $q;
	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string $excel
	 */
	private $excel;
	/**
	 * Document Trail Audit.
	 * @var string $documentTrail;
	 */
	private $documentTrail;
	/**
	 * Audit Row True or False
	 * @var boolean $audit
	 */
	private $audit;
	/**
	 * Log Sql Statement True or False
	 * @var unknown_type
	 */
	private $log;
	/**
	 * department Model
	 * @var string $departmentModel
	 */
	public $model;
	/**
	 * Audit Filter
	 * @var string $auditFilter
	 */
	public $auditFilter;
	/**
	 * Audit Column
	 * @var string $auditColumn
	 */
	public $auditColumn;
	/**
	 * Duplicate Testing either the key of table same or have been created.
	 * @var boolean $duplicateTest;
	 */
	public $duplicateTest;

	/**
	 * Class Loader
	 */
	function execute() {
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->getVendor();

		$this->q->leafId			=	$this->getLeafId();

		$this->q->staffId			=	$this->getStaffId();

		$this->q->fieldQuery 			= 	$this->getFieldQuery();

		$this->q->gridQuery		=	$this->getGridQuery();

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;

		$this->log					=   0;

		$this->q->log 				= $this->log;
	}



	/**
	 * Read calendar
	 */
	public function read() 				{

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
		if ($this->getOrder() && $this->getSortField()) {
			if ($this->getVendor() == self::mysql) {
				$sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder(). " ";
			} else if ($this->getVendor() ==  self::mssql) {
				$sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::oracle) {
				$sql .= "	ORDER BY \"" . $this->getSortField() . "\"  " . $this->getOrder() . " ";
			}
		}
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
			$this->msg(false,$this->q->responce);
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
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_POST['leafId'])){
		$calendarsObject->setLeafId($_POST['leafId']);
	}
	if(isset($_POST['isAdmin'])){
		$calendarsObject->setIsAdmin($_POST['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$calendarsObject -> execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */

	if($_POST['method']=='update') {
		$calendarsObject ->update();
	}
	if($_POST['method']=='delete') {
		$calendarsObject ->delete();
	}


}
if(isset($_GET['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_GET['leafId'])){
		$calendarsObject->setLeafId($_GET['leafId']);
	}
	if(isset($_GET['isAdmin'])) {
		$calendarsObject->setIsAdmin($_GET['isAdmin']);
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
			$calendarsObject->staff();
		}
	}
}
?>

