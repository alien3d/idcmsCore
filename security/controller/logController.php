<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../model/logModel.php");
/**
 * this is  log file
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package log
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class logClass extends  configClass {
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
	public function execute() {
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

		$this->model         = new logModel();
        $this->model->vendor = $this->vendor;
        $this->model->execute();
        $this->documentTrail = new documentTrailClass();
	}


	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create() 				{

	}

	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read() 				{

		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		if($this->getVendor() == self::mysql) {
			$sql	=	"
			SELECT	*
			FROM 	`log`";
			if($_POST['logId']) {
				$sql.=" AND `logId`='".$this->strict($_POST['logId'],'n')."'";
			}
		}
		/**
		 *	filter table
		 * @variables $tableArray
		 */
		$tableArray = array('staff','log');
		// searching filtering
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		//$filterArray	=	array();
		if(isset($_GET['query'])) {
			$query = $_GET['query'];
		}  else if (isset($_POST['query'])) {
			$query = $_POST['query'];
		}
		if($query) {
			$sql.=$this->q->quickSearch($tableArray,$filterArray);
		}

		$this->q->read($sql);
		$total	= $this->q->numberRows();
		//paging

		$sql.="	ORDER BY `".$sortField."` ".$dir." ";
		if(empty($_POST['filter']))      {
			if(isset($_POST['start']) && isset($_POST['limit'])) {
				$sql.=" LIMIT  ".$_POST['start'].",".$_POST['limit']." ";
			}
		}

		$_SESSION['sql']	=	$sql; // push to session so can make report via excel and pdf
		$_SESSION['start'] 	= 	$_POST['start'];
		$_SESSION['limit'] 	= 	$_POST['limit'];
		$this->q->read($sql);

		while($row  = 	$this->q->fetchAssoc()) {

			$items[]			=	$row;
		}



		// bugs on extjs
		if($_POST['method']=='read' && $_POST['mode']=='update') {
			$json_encode = json_encode(
			array(
				'success'	=>	'true',
				'total' 	=> 	$this->total,
				'data' 		=> 	$items
			)
			);
			$json_encode=str_replace("[","",$json_encode);
			$json_encode=str_replace("]","",$json_encode);
			echo $json_encode;
			exit();
		} else {
			if(count($items)==0) {
				$items='';
			}
			echo json_encode(
			array(
				'success'	=>	'true',
				'total' 	=> 	$this->total,
				'data' 		=> 	$items
			)
			);
			exit();
		}


	}

	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() 				{

	}

	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete()				{

	}





	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		if($_SESSION['start']==0) {
			$sql=str_replace("LIMIT","",$_SESSION['sql']);
			$sql=str_replace($_SESSION['start'].",".$_SESSION['limit'],"",$sql);
		} else {
			$sql=$_SESSION['sql'];
		}
		$this->q->read($sql);

		$this->excel->setActiveSheetIndex(0);
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array(
		'borders' => array(
		'inside' => array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('argb' => '000000'),
		),
		'outline' => array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('argb' => '000000'),
		),
		),
		);
		// header all using  3 line  starting b
		$this->excel->getActiveSheet()->setCellValue('B2',$this->title);
		$this->excel->getActiveSheet()->setCellValue('J2','');
		$this->excel->getActiveSheet()->mergeCells('B2:J2');
		$this->excel->getActiveSheet()->setCellValue('B3','No');


		$this->excel->getActiveSheet()->setCellValue('C3','logId');


		$this->excel->getActiveSheet()->setCellValue('D3','leafId');


		$this->excel->getActiveSheet()->setCellValue('E3','operation');


		$this->excel->getActiveSheet()->setCellValue('F3','sql');


		$this->excel->getActiveSheet()->setCellValue('G3','date');


		$this->excel->getActiveSheet()->setCellValue('H3','staffId');


		$this->excel->getActiveSheet()->setCellValue('I3','access');


		$this->excel->getActiveSheet()->setCellValue('J3','log_error');

		$this->excel->getActiveSheet()->getStyle('B2:J2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:J2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:J3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:J3')->getFill()->getStartColor()->setARGB('66BBFF');

		//
		$loopRow=4;
		$i=0;
		while($row  = 	$this->q->fetchAssoc()) {
			//	echo print_r($row);

			$this->excel->getActiveSheet()->setCellValue('B'.$loopRow,++$i);


			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['logId']);


			$this->excel->getActiveSheet()->setCellValue('D'.$loopRow,$row['leafId']);


			$this->excel->getActiveSheet()->setCellValue('E'.$loopRow,$row['operation']);


			$this->excel->getActiveSheet()->setCellValue('F'.$loopRow,$row['sql']);


			$this->excel->getActiveSheet()->setCellValue('G'.$loopRow,$row['date']);


			$this->excel->getActiveSheet()->setCellValue('H'.$loopRow,$row['staffId']);


			$this->excel->getActiveSheet()->setCellValue('I'.$loopRow,$row['access']);


			$this->excel->getActiveSheet()->setCellValue('J'.$loopRow,$row['log_error']);

			$loopRow++;
			$lastRow='J'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="log".rand(0,10000000).".xlsx";
		$path=$_SERVER['DOCUMENT_ROOT']."/".$this->application."/basic/document/excel/".$filename;
		$objWriter->save($path);
		$this->create_trail($this->leafId, $path,$filename);

		$file = fopen($path,'r');
		if($file){
			echo json_encode(array("success"=>"true","message"=>"File generated"));
			exit();
		} else {
			echo json_encode(array("success"=>"false","message"=>"File not generated"));
			exit();

		}
	}


}

$logObject  	= 	new logClass();
if(isset($_SESSION['staffId'])){
	$logObject->staffId = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$logObject-> vendor = $_SESSION['vendor'];
}
// crud -create,read,update,delete

if(isset($_POST['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_POST['leafId'])){
		$logObject->leafId  = $_POST['leafId'];
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$logObject->isAdmin = $_POST['isAdmin'];
	}
	/*
	 *  Load the dynamic value
	 */
	$logObject->execute();
	if($_POST['method']=='read'){
		$logObject->read();
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
		$logObject->leafId = $_GET['leafId'];
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$logObject->isAdmin = $_GET['isAdmin'];
	}
	if(isset($_GET['field'])){
		$logObject-> staffId = $_GET['staffId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$logObject->execute();
	/*
	 * Reporting Only
	 */
	if(isset($_GET['mode'])){
		$logObject->excel();
	}
}


?>
