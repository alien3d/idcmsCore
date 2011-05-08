<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../class/classSecurity.php");
require_once("../model/accordionAccessModel.php");
/**
 * this is accordion security access
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package accordion security access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class accordionAccessClass extends configClass {
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
	 * @var string $documentTrail;
	 */
	private  $documentTrail;

	/**
	 *  Ascending ,Descending ASC,DESC
	 * @var string $order;`
	 */
	public $order;

	/**
	 * Sort the default field.Mostly consider as primary key default.
	 * @var string $sortField
	 */
	public $sortField;
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
	 * Current Table Accordion Access Indentification Value
	 * @var numeric $accordionId
	 */
	public $accordionId;
	/**
	 *  Table Group Indentification Value
	 * @var numeric $groupId
	 */
	public $groupId;
	/**
	 * Common class function for security menu
	 * @var  string $security
	 */
	private $security;
	  /**
     * Accordion Access Model
     * @var string $model
     */
    public $model;

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

		$this->log					=   1;

		$this->q->log 				= $this->log;

		$this->security				=  new security();
		$this->security->vendor		= $this->vendor;
		$this->security->leafId		= $this->leafId;
		$this->security->staffId	= $this->staffId;
		$this->security->execute();
		$this->model         = new accordionAccessModel();
        $this->model->vendor = $this->vendor;
        $this->model->execute();
        $this->documentTrail = new documentTrailClass();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create() {}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() 				{
		header('Content-Type','application/json; charset=utf-8');
		//UTF8
		if($this->q->vendor==self::mysql) {
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		// by default if add new group will add access to accordion and folder.
		if($this->q->vendor==self::mysql){
			$sql="
				SELECT	`accordionAccess`.`accordionAccessId`,
						`accordion`.`accordionId`,
						`accordion`.`accordionNote`,
						`group`.`groupId`,
						`group`.`groupNote`,
						(CASE `accordionAccess`.`accordionAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `accordionAccessValue`
				FROM 	`accordionAccess`
				JOIN	`accordion`
				USING 	(`accordionId`)
				JOIN 	`group`
				USING 	(`groupId`)
				WHERE 	`accordion`.`isActive` 	=	1
				AND		`group`.`isActive`		=	1";
			if($this->groupId) {
				$sql.=" AND `group`.`groupId`='".$this->strict($this->groupId,'numeric')."'";
			}
		} else if ($this->q->vendor==self::mssql){
		$sql="
				SELECT	`accordionAccess`.`accordionAccessId`,
						`accordion`.`accordionId`,
						`accordion`.`accordionNote`,
						`group`.`groupId`,
						`group`.`groupNote`,
						(CASE `accordionAccess`.`accordionAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `accordionAccessValue`
				FROM 	`accordionAccess`
				JOIN	`accordion`
				USING 	(`accordionId`)
				JOIN 	`group`
				USING 	(`groupId`)
				WHERE 	`accordion`.`isActive` 	=	1
				AND		`group`.`isActive`		=	1";
			if($this->groupId) {
				$sql.=" AND `group`.`groupId`='".$this->strict($this->groupId,'numeric')."'";
			}
		} else if ($this->q->vendor==self::oracle){
			$sql="
				SELECT	`accordionAccess`.`accordionAccessId`,
						`accordion`.`accordionId`,
						`accordion`.`accordionNote`,
						`group`.`groupId`,
						`group`.`groupNote`,
						(CASE `accordionAccess`.`accordionAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `accordionAccessValue`
				FROM 	`accordionAccess`
				JOIN	`accordion`
				USING 	(`accordionId`)
				JOIN 	`group`
				USING 	(`groupId`)
				WHERE 	`accordion`.`isActive` 	=	1
				AND		`group`.`isActive`		=	1";
			if($this->groupId) {
				$sql.=" AND `group`.`groupId`='".$this->strict($this->groupId,'numeric')."'";
			}
		}
		//echo $sql;
		// searching filtering
		$sql.=$this->q->searching();

		$this->q->read($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));

			exit();
		}

		$total	= $this->q->numberRows();
		//paging

		if(isset($_POST['start']) && isset($_POST['limit'])) {
			$sql.=" LIMIT  ".$_POST['start'].",".$_POST['limit']." ";
		}



		$this->q->read($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		while($row  = 	$this->q->fetchAssoc()) {
			$items[]=$row;
		}


		echo json_encode(
		array('success'=>'true',
			'total' => $this->total,
			'data' => $items
		));

		exit();


	}

	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() 				{
		header('Content-Type','application/json; charset=utf-8');
		//UTF8
		$sql='SET NAMES "utf8"';
		$this->q->fast($sql);

		// first check the group.if exist update else create new one
		$accordionAccessId		=	'accordionAccessId';
		$accordionAccessValue	=	'accordionAccessValue';
		$loop=count($_GET[$accordionAccessId]);


		for($i=0;$i<$loop;$i++) {
			// mysql doesn't support bolean expression
			if($_GET[$accordionAccessValue][$i]=='true') {
				$_GET[$accordionAccessValue][$i]=1;
			} else {
				$_GET[$accordionAccessValue][$i]=0;
			}
			$sql="
			UPDATE 	`accordionAccess`
			SET 	`accordionAccessValue`	= 	'".$this->strict($_GET[$accordionAccessValue][$i],'string')."'
			WHERE 	`accordionAccessId`		=	'".$this->strict($_GET[$accordionAccessId][$i],'numeric')."'";
			//	echo $sql."<br>";
			$this->q->update($sql);
			if($this->q->execute=='fail'){
				echo json_encode(array("success"=>false,"message"=>$this->q->responce));
				exit();
			}

		}
		echo json_encode(array("success"=>true,"message"=>"Update Success"));
		exit();

	}

	/**
	 *  Return Group Indentification
	 */
	function group() {
		return $this->security->group();
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete() {}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {}
}



$accordionAccessObject  		= 	new accordionAccessClass();
if(isset($_SESSION['staffId'])){
	$accordionAccessObject->staffId = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$accordionAccessObject-> vendor = $_SESSION['vendor'];
}

// crud -create,read,update,delete.

if(isset($_POST['method'])){

	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_POST['leafId'])){
		$accordionAccessObject ->leafId = $_POST['leafId'];
	}
	if(isset($_POST['groupId'])){
		$accordionAccessObject->groupId = $_POST['groupId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$accordionAccessObject->execute();

	if($_POST['method']=='read'){
		$accordionAccessObject  -> read();
	}

}
if(isset($_GET['method'])){

	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_GET['leafId'])){
		$accordionAccessObject ->leafId = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$accordionAccessObject->execute();
	if($_GET['method']=='update'){
		$accordionAccessObject -> update();
	}
	if(isset($_GET['field'])){
		if($_GET['method']=='read' && $_GET['field']=='groupId'){
			$accordionAccessObject-> group();
		}
	}
}
?>
