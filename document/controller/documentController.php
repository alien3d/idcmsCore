<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../model/documentModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package doc
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class documentClass extends  configClass {
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
	 * Current Table Document  Indentification Value
	 * @var numeric $docId
	 */
	public $documentId;
	public $model;
	function __construct() {
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

		$this->model = new documentModel();
	}


	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read() 				{

		header('Content-Type','application/json; charset=utf-8');
		$sql	=	"
				SELECT
				        `doc`.`doc_uniqueId`,
				        `doc`.`doc_nme`,
				        `doc`.`doc_des`,
				        `doc`.`doc_ext`,
				        `doc`.`createBy`,
				        `doc`.`createTime`,
				        `doc`.`updatedBy`,
				        `doc`.`updatedTime`,
						`doc`.`doc_cat_uniqueId`,
						`doc_cat`.`doc_cat_nme`,
						`doc_cat`.`doc_cat_uniqueId`,
				        CONCAT('(','ID ',`doc_cat_uniqueId`,') ',`doc_cat_nme`) AS NoDoc
				FROM 	`doc`
                JOIN    `doc_cat`
                USING   (`doc_cat_uniqueId`)
				WHERE 	1";
		if($_POST['doc_uniqueId']) {
			$sql.=" AND `doc_uniqueId`='".$this->strict($_POST['doc_uniqueId'],'n')."'";
		}

		// searching filtering
		$sql.=$this->q->searching();
		//echo $sql;
		$record_all 	= $this->q->read($sql);
		$this->total	= $this->q->numberRows();
		//paging
		// this is sorting  future
		if(empty($_POST['dir'])) {
			$dir = 'ASC';
		} else {
			$dir  = $_POST['dir'];
		}
		if(empty($_POST['sort'])) {
			$sort_field = "doc_uniqueId";
		} else {
			$sort_field = $_POST['sort'];
		}
		$sql.="	ORDER BY `".$sort_field."` ".$dir." ";
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
			// add on to object create by  and updated by
			$row['createBy']	=	$this->staff_name($row['createBy']);
			$row['updatedBy']	=	$this->staff_name($row['updatedBy']);
			$items[]			=	$row;
		}


		if($this->q->execute=='fail') {
			$this->msg(false,$this->q->result_text);
			exit();
		}else {
			// bugs on extjs
			if($_POST['method']=='read' && $_POST['mode']=='update') {
				$json_encode = json_encode(
				array(
											'success'	=>	true,
											'total' 	=> 	$this->total,
											'data' 		=> 	$items
				)
				);
				$json_encode=str_replace("[","",$json_encode);
				$json_encode=str_replace("]","",$json_encode);
				echo $json_encode;
			} else {
				if(count($items)==0) {
					$items='';
				}
				echo json_encode(
				array(
											'success'	=>	true,
											'total' 	=> 	$this->total,
											'data' 		=> 	$items
				)
				);
				exit();
			}
		}
		


	}

	/**
	 * Enter description here ...
	 */
	function upload() {
		//$filename =  $_POST['filename'];
		$filecontent  = $_FILES['docname']['name'];
		$allowedExtensions = array("xlsx");
		foreach ($_FILES as $file) {
			if ($file['tmp_name'] > '') {
				if (!in_array(end(explode(".",strtolower($file['name']))),$allowedExtensions)) {
					// never die .should just return message
					$message= $file['name'].' is an invalid file type!<br/>';
					$this->msg(false,$message);
				}
			}
		}

		if ($_FILES['doc_nme']['type'] == "file/xlsx" || $_FILES['docname']['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
		{
			$doc_nme=$_FILES['docname']['name'];
			$doc_ext=rand(0,4).".xlsx";
			// for easy path it's better actual path to upload

			move_uploaded_file ($_FILES['docname']['tmp_name'],$this->path.$doc_ext);

			$sql = "INSERT INTO doc (
				  					  `doc_nme`,
									  `doc_ext`,
				  					  `doc_cat_uniqueId`,
									  `doc_des`,
				  					  `createBy`,
				  					  `createTime`)
				   VALUES    (         '$doc_nme',
							  		   '$doc_ext',
									   '".$this->strict($_POST['doc_cat_uniqueId'],'n')."',
									   '".$this->strict($_POST['doc_des'],'s')."',
				                       '".$_SESSION['staffId']."',
				                       '".date("Y-m-d H:i:s")."')";

			$this->q->create($sql);
			$source = $this->path.$doc_ext;
			chmod($source, 0777);
			//$this->convert($source);
			$this->convert($source);
		}
	}


	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create(){}

	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() 				{
		$filecontent  = $_FILES['docname']['name'];
		$allowedExtensions = array("xlsx");
		foreach ($_FILES as $file) {
			if ($file['tmp_name'] > '') {
				if (!in_array(end(explode(".",strtolower($file['name']))),$allowedExtensions)) {
					// never die .should just return message
					$message= $file['name'].' is an invalid file type!<br/>';
					$this->msg(false,$message);
				}
			}
		}

		if ($_FILES['doc_nme']['type'] == "file/xlsx" || $_FILES['docname']['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
		{
			$doc_nme=$_FILES['docname']['name'];
			$doc_ext=rand(0,4).".xlsx";
			// for easy path it's better actual path to upload

			move_uploaded_file ($_FILES['docname']['tmp_name'],$this->path.$doc_ext);

			$sql = "  UPDATE 	`doc`
					         SET 	`doc_cat_uniqueId`	        =	'".$this->strict($_POST['doc_cat_uniqueId'],'n')."',
					     	`doc_nme`	        =	'$doc_nme',
					     	`doc_ext`	        =	'$doc_ext',
					     	`doc_des`	        =	'".$this->strict($_POST['doc_des'],'s')."',
							`updatedBy`			=	'".$_SESSION['staffId']."',
							`updatedTime`			=	'".date("Y-m-d H:i:s")."'
					WHERE 	`doc_uniqueId`		=	'".$this->strict($_POST['doc_uniqueId'],'n')."'";

			$this->q->create($sql);
			$source = $this->path.$doc_ext;
			chmod($source, 0777);
			//$this->convert($source);
			$this->convert($source);
		}
	}










	/**
	 * Enter description here ...
	 */
	function docCategoryId() {
		header('Content-Type','application/json; charset=utf-8');
		$sql	=	"
				SELECT
				       `doc_cat`.`doc_cat_uniqueId`,
				       `doc_cat`.`doc_cat_nme`,
					   CONCAT('(','ID ',`doc_cat_uniqueId`,') ',`doc_cat_nme`) AS IdDoc
				FROM   `doc_cat`
				WHERE   1 ";
		$this->q->read($sql);
		$this->total = $this->q->numberRows();
		$items		 =	array();
		while($row   = 	$this->q->fetch_array()) {
			$items[] =	$row;
		}
		echo json_encode(
		array(
											'totalCount' 		=>	$this->total,
											'doc_cat'	=> 	$items
		)
		);
	}

	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete()				{
		header('Content-Type','application/json; charset=utf-8');
		if($this->access('delete')==1) {
			$this->q->start();
			$sql	=	"
					DELETE	FROM 	`doc`
					WHERE 			`doc_uniqueId`='".$this->strict($_POST['doc_uniqueId'],'n')."'";
			$this->q->delete($sql);
			$this->q->commit();

			if($this->q->execute=='fail') {
				$this->msg('false',$this->q->result_text);
				exit();
			} else {
				$this->msg(true,'Remove query Sucess');
				exit();
			}
		} else {
			$this->msg(false,'Don\'t have authority to delete record');
			exit();
		}
	}



	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {
		header('Content-Type','application/json; charset=utf-8');
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
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$this->excel->getActiveSheet()->setCellValue('B2',$this->title);
		$this->excel->getActiveSheet()->setCellValue('E2','');
		$this->excel->getActiveSheet()->mergeCells('B2:E2');
		$this->excel->getActiveSheet()->setCellValue('B3','No');
		$this->excel->getActiveSheet()->setCellValue('C3','Dokumen');
		$this->excel->getActiveSheet()->setCellValue('D3','Nama');
		$this->excel->getActiveSheet()->setCellValue('E3','Penerangan');
		$this->excel->getActiveSheet()->getStyle('B2:E2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:E2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:E3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:E3')->getFill()->getStartColor()->setARGB('66BBFF');
		//
		$loopRow=4;
		$i=0;
		while($row  = 	$this->q->fetch_array()) {
			//	echo print_r($row);

			$this->excel->getActiveSheet()->setCellValue('B'.$loopRow,++$i);
			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['doc_uniqueId']);
			$this->excel->getActiveSheet()->setCellValue('D'.$loopRow,$row['doc_nme']);
			$this->excel->getActiveSheet()->setCellValue('E'.$loopRow,$row['NoDoc']);
			$loopRow++;
			$lastRow='E'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="doc.xlsx";
		$objWriter->save("/var/www/html/kospek/document/document/excel/".$filename);

		$file = fopen("/var/www/html/kospek/document/document/excel/".$filename,'r');
		if($file){
			echo json_encode(array("success"=>'true',"message"=>"File generated"));
			exit();
		} else {
			echo json_encode(array("success"=>'false',"message"=>"File not generated"));
			exit();

		}
	}

}

$documentObject  	= 	new documentClass();
if(isset($_SESSION['staffId'])){
	$documentObject->staffId = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$documentObject-> vendor = $_SESSION['vendor'];
}


/**
 *	crud -create,read,update,delete
 **/
if(isset($_POST['method']))	{
	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_POST['leafId'])){
		$documentObject-> leafId = $_POST['leafId'];
	}
	if(isset($_POST['religionId'])) {
		$documentObject->religionId = $_POST['religionId'];
	}
	if($_POST['method']=='create')	{
		$documentObject->create();
	}
	if(isset($_POST['filter'])){
		$documentObject->filter = $_POST['filter'];
	}
	if(isset($_POST['query'])){
		$documentObject->quickFilter = $_POST['query'];
	}
	if(isset($_POST['order'])){
		$documentObject->order= $_POST['order'];
	}
	if(isset($_POST['sort_field'])){
		$documentObject-> sort_field= $_POST['sort_field'];
	}
	/*
	 *  Load the dynamic value
	 */
	$documentObject -> execute();

	if($_POST['method']=='read') 	{
		$documentObject->read();
	}

	if($_POST['method']=='save') 	{
		$documentObject->update();
	}
	if($_POST['method']=='delete') 	{
		$documentObject->delete();
	}

}

if(isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_GET['leafId'])){
		$documentObject->leafId  = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$documentObject -> execute();
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {
			$documentObject->staffId();
		}
	}

	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$documentObject->excel();
		}
	}
}
?>
