<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../model/documentCategoryModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package doc_cat
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class documentCategoryClass extends  configClass {
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

		$this->model 				= new documentCategoryModel();

	}

	/**
	 *  to create record
	 */
	public function create() 				{
		header('Content-Type','application/json; charset=utf-8');

		$this->q->start();
		$sql="
					INSERT INTO `documentCategory`
							(
								`documentCategoryTitle`,
								`documentCategoryDesc`
							)
					VALUES	(

								'".$this->model->documentCategoryTitle."',
								'".$this->model->documentCategoryDesc."'
							);";

		$this->q->create($sql);
		$this->q->commit();




	}

	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read() 				{

		header('Content-Type','application/json; charset=utf-8');
		$sql	=	"
				SELECT

				FROM 	`documentCategory`
				WHERE 	1";
		if($_POST['documentCategoryId']) {
			$sql.=" AND `documentCategoryId`='".$this->strict($this->documentCategoryId,'n')."'";
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
			$sortField = "doc_cat_uniqueId";
		} else {
			$sortField = $_POST['sort'];
		}
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


		if($this->q->execute=='fail') {
			$this->msg(false,$this->q->responce);
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

	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() 				{

		header('Content-Type','application/json; charset=utf-8');
		$this->model->update();
		$this->q->start();

		$sql="
		UPDATE 	`doc_cat`
		SET 	`doc_cat_uniqueId`	    =	'".$this->strict($_POST['doc_cat_uniqueId'],'n')."',
		     	`doc_cat_nme`	            =	'".$this->strict($_POST['doc_cat_nme'],'s')."',
		     	`isActive`			=	'".$this->model->getIsActive('','string')."',
				`isNew`				=	'".$this->model->getIsNew('','string')."',
				`isDraft`			=	'".$this->model->getIsDraft('','string')."',
				`isUpdate`			=	'".$this->model->getIsUpdate('','string')."',
				`isDelete`			=	'".$this->model->getIsDelete('','string')."',
				`isApproved`		=	'".$this->model->getIsApproved('','string')."',
				`By`				=	'".$this->model->getBy()."',
				`Time				=	".$this->model->getTime()."
		WHERE 	`doc_cat_uniqueId`		=	'".$this->strict($_POST['doc_cat_uniqueId'],'n')."'";

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
	function delete()				{
		header('Content-Type','application/json; charset=utf-8');
		$this->model->delete();
		$this->q->start();
		$sql	=	"
					DELETE	FROM 	`doc_cat`
					`isActive`			=	'".$this->model->getIsActive('','string')."',
							`isNew`				=	'".$this->model->getIsNew('','string')."',
							`isDraft`			=	'".$this->model->getIsDraft('','string')."',
							`isUpdate`			=	'".$this->model->getIsUpdate('','string')."',
							`isDelete`			=	'".$this->model->getIsDelete('','string')."',
							`isApproved`		=	'".$this->model->getIsApproved('','string')."',
							`By`				=	'".$this->model->getBy()."',
							`Time				=	".$this->model->getTime()."
					WHERE 			`doc_cat_uniqueId`='".$this->strict($_POST['doc_cat_uniqueId'],'n')."'";
		$this->q->delete($sql);
		$this->q->commit();

		if($this->q->execute=='fail') {
			$this->msg('false',$this->q->responce);
			exit();
		} else {
			$this->msg(true,'Remove query Sucess');
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
		$this->excel->getActiveSheet()->setCellValue('B2',$this->title);
		$this->excel->getActiveSheet()->setCellValue('D2','');
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->setCellValue('B3','No');
		$this->excel->getActiveSheet()->setCellValue('C3','Nama');
		$this->excel->getActiveSheet()->setCellValue('D3','Leaf');
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');
		//
		$loopRow=4;
		$i=0;
		while($row  = 	$this->q->fetchAssoc()) {
			//	echo print_r($row);
			$this->excel->getActiveSheet()->setCellValue('B'.$loopRow,++$i);
			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['doc_cat_nme']);
			$this->excel->getActiveSheet()->setCellValue('D'.$loopRow,$row['leafNote']);
			$loopRow++;
			$lastRow='D'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="doc_cat.xlsx";
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

$documenCategoryObject  	= 	new documentCategoryClass();
if(isset($_SESSION['staffId'])){
	$documenCategoryObject->staffId = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$documenCategoryObject-> vendor = $_SESSION['vendor'];
}
/**
 *	crud -create,read,update,delete
 **/
if(isset($_POST['method']))	{
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Indentification
	 */
	if(isset($_POST['leafId'])){
		$documenCategoryObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$documenCategoryObject->setIsAdmin($_POST['isAdmin']);
	}
	/*
	 * Filtering
	 */
	if(isset($_POST['query'])){
		$documenCategoryObject->setFieldQuery($_POST['query']);
	}
	if(isset($_POST['filter'])){
		$documenCategoryObject->setGridQuery($_POST['filter']);
	}

	/*
	 * Ordering
	 */
	if(isset($_POST['order'])){
		$documenCategoryObject->setOrder($_POST['order']);
	}
	if(isset($_POST['sortField'])){
		$documenCategoryObject->setSortField($_POST['sortField']);
	}
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_POST['method']=='create')	{
		$documenCategoryObject->create();
	}
	if($_POST['method']=='read') 	{
		$documenCategoryObject->read();
	}
	if($_POST['method']=='save') 	{
		$documenCategoryObject->read();
	}
	if($_POST['method']=='delete') 	{
		$documenCategoryObject->delete();
	}
}

if(isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Indentification
	 */
	if(isset($_GET['leafId'])){
		$documenCategoryObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$documenCategoryObject->setIsAdmin($_GET['isAdmin']);
	}
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {
			$documenCategoryObject->staff();
		}
	}
	/*
	 *  Excel Reporting
	 */
	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$documenCategoryObject->excel();
		}
	}
}
?>
