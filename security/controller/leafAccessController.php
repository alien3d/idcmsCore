<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../class/classDocumentTrail.php");
require_once("../model/leafGroupAccessModel.php");
/**
 * this is  leaf security access
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package leaf_security_access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafAccessClass extends  configClass {
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

		$this->q->staffId			=	$this->staffIdTemporally;

		$this->q->filter 			= 	$this->filter;

		$this->q->quickFilter		=	$this->quickFilter;

		$this->q->connect($this->connection, $this->username,$this->database,$this->password);

		$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;

		$this->log					=   0;

		$this->q->log 				= $this->log;

		$this->model                = new leafAccessModel();


		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->documentTrail = new documentTrailClass();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create(){

	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() 				{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		// by default if add new group will add access to accordion and leaf.
		if($this->getVendor() == self::mysql) {
			$sql="
				SELECT	`leaf`.`accordionId`,
						`leaf`.`folderId`,
						`folder`.`folderNote`,
						`leaf`.`leafNote`,
						`accordion`.`accordionNote`,
						`staff`.`staffName`,
						`group`.`groupNote`,
						`leafAccess`.`leafId`,
						`leafAccess`.`staffId`,
						`leafAccess`.`leafAccessId`,
						 (CASE `leafAccess`.`leafCreateAccessValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafCreateAccessValue`,


						 (CASE `leafAccess`.`leafReadAccessValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafReadAccessValue`,

						(CASE `leafAccess`.`leafUpdateAccessValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafUpdateAccessValue`,

						(CASE `leafAccess`.`leafDeleteAccessValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafDeleteAccessValue` ,

						(CASE `leafAccess`.`leafPrintAccessValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafPrintAccessValue`,

						(CASE `leafAccess`.`leafPostAccessValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafPostAccessValue`
				FROM 	`leafAccess`
				JOIN	`leaf`
				USING	(`leafId`)
				JOIN	(`accordion`)
				USING	(`accordionId`,`languageId`)
				JOIN	(`folder`)
				USING	(`folderId`,`languageId`)
				JOIN	`staff`
				USING	(`staffId`,`languageId`)
				JOIN	`group`
				USING	(`groupId`,`languageId`)
				WHERE 	`accordion`.`isActive` 	=	1
				AND		`folder`.`isActive` 	=	1
				AND		`leaf`.`isActive`		=	1 ";
			if($this->accordionId) {
				$sql.=" AND `leaf`.`accordionId`='".$this->strict($this->accordionId,'numeric')."'";
			}
			if($this->folderId) {
				$sql.=" AND `leaf`.`folderId`='".$this->strict($this->folderId,'numeric')."'";
			}
			if($this->staffId) {
				$sql.=" AND `leafAccess`.`staffId`='".$this->strict($this->staffId,'numeric')."'";
			}
		} else if ($this->getVendor()==self::mssql) {
			$sql="
				SELECT	[leaf].[accordionId],
						[leaf].[folderId],
						[folder].[folderNote],
						[leaf].[leafNote],
						[accordion].[accordionNote],
						[staff].[staffName],
						[group].[groupNote],
						[leafAccess].[leafId],
						[leafAccess].[staffId],
						[leafAccess].[leafAccessId],
						 (CASE [leafAccess].[leafCreateAccessValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafCreateAccessValue],


						 (CASE [leafAccess].[leafReadAccessValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafReadAccessValue],

						(CASE [leafAccess].[leafUpdateAccessValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafUpdateAccessValue],

						(CASE [leafAccess].[leafDeleteAccessValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafDeleteAccessValue] ,

						(CASE [leafAccess].[leafPrintAccessValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafPrintAccessValue],

						(CASE [leafAccess].[leafPostAccessValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafPostAccessValue]
				FROM 	[leafAccess]
				JOIN	[leaf]
				ON		[leafAccess].[leafId] = [leaf].[leafId]
				JOIN	[accordion]
				ON		[leaf].[accordionId]=[accordion].[accordionId]
				JOIN	[folder]
				ON		[folder].[folderId]=[leaf].[folderId]
				JOIN	[staff]
				ON		[leaf].[staffId]=[staff].[staffId]
				JOIN	[group]
				USING	[group].[groupId]=[leafAccess].[groupId]
				WHERE 	[accordion].[isActive] 	=	1
				AND		[folder].[isActive] 	=	1
				AND		[leaf].[isActive]		=	1  ";
			if($this->accordionId) {
				$sql.=" AND [leaf].[accordionId]='".$this->strict($this->accordionId,'numeric')."'";
			}
			if($this->folderId) {
				$sql.=" AND [leaf].[folderId]='".$this->strict($this->folderId,'numeric')."'";
			}
			if($this->staffId) {
				$sql.=" AND [leafAccess`.[staffId]='".$this->strict($this->staffId,'numeric')."'";
			}
		} else if ($this->getVendor()==self::oracle) {
			$sql="
				SELECT	\"leaf\".\"accordionId\",
						\"leaf\".\"folderId\",
						\"folder\".\"folderNote\",
						\"leaf\".\"leafNote\",
						\"accordion\".\"accordionNote\",
						\"staff\".\"staffName\",
						\"group\".\"groupNote\",
						\"leafAccess\".\"leafId\",
						\"leafAccess\".\"staffId\",
						\"leafAccess\".\"leafAccessId\",
						 (CASE \"leafAccess\".\"leafCreateAccessValue\"
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafCreateAccessValue\",


						 (CASE \"leafAccess\".\"leafReadAccessValue\"
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafReadAccessValue\",

						(CASE \"leafAccess\".\"leafUpdateAccessValue\"
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafUpdateAccessValue\",

						(CASE \"leafAccess\".\"leafDeleteAccessValue\"
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafDeleteAccessValue\" ,

						(CASE \"leafAccess\".\"leafPrintAccessValue\"
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafPrintAccessValue\",

						(CASE \"leafAccess\".\"leafPostAccessValue\"
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafPostAccessValue\"
				FROM 	\"leafAccess\"
				JOIN	\"leaf\"
				USING	(\"leafId\")
				JOIN	(\"accordion\")
				USING	(\"accordionId\",\"languageId\")
				JOIN	(\"folder\")
				USING	(\"folderId\",\"languageId\")
				JOIN	\"staff\"
				USING	(\"staffId\",\"languageId\")
				JOIN	\"group\"
				USING	(\"groupId\",\"languageId\")
				WHERE 	\"leaf\".\"isActive\"=1
				AND		\"folder\".\"isActive\"=1
				AND		\"accordion\".\"isActive\"=1
				AND		\"staff\".\"isActive\"=1";
			if($this->accordionId) {
				$sql.=" AND \"leaf\".\"accordionId\"='".$this->strict($this->accordionId,'numeric')."'";
			}
			if($this->folderId) {
				$sql.=" AND \"leaf\".\"folderId\"='".$this->strict($this->folderId,'numeric')."'";
			}
			if($this->staffId) {
				$sql.=" AND \"leafAccess\".\"staffId\"='".$this->strict($this->staffId,'numeric')."'";
			}
		}
		//echo $sql;
		// searching filtering
		$sql.=$this->q->searching();

		$record_all 	= $this->q->read($sql);
		if($this->q->execute=='fail'){
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
			// select accordion access

			$items[]=$row;
			// select accordion access
		}



		echo json_encode(
		array('success'=>'true',
									   'total' => $total,
       								   'data' => $items
		));
		exit();


	}
	/**
	 * Enter description here ...
	 */
	function groupId() {
		return $this->security->groupId();
	}
	/**
	 * Enter description here ...
	 */
	function accordionId() {
		return $this->security->accordionId();
	}
	/**
	 * Enter description here ...
	 */
	function folderId() {
		return $this->security->folderId();
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() 				{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		$this->model->update();
		$loop=count($_GET['leafAccessId']);

		for($i=0;$i<$loop;$i++) {
			// mysql doesn't support bolean expression
			foreach($access_array as $access_type)  {
				if($_GET['leaf_'.$access_type.'_acs_val'][$i]=='true') {
					$_GET['leaf_'.$access_type.'_acs_val'][$i]=1;
				} else {
					$_GET['leaf_'.$access_type.'_acs_val'][$i]=0;
				}
			}

			if($this->getVendor() == self::mysql) {
				$sql="
					UPDATE 	`leafAccess`
					SET 	`leafCreateAccessValue`	=	'".$this->strict($_GET['leafCreateAccessValue'][$i],'numeric')."',
							`leafReadAccessValue`	=	'".$this->strict($_GET['leafReadAccessValue'][$i],'numeric')."',
							`leafUpdateAccessValue`	=	'".$this->strict($_GET['leafUpdateAccessValue'][$i],'numeric')."',
							`leafDeleteAccessValue`	=	'".$this->strict($_GET['leafDeleteAccessValue'][$i],'numeric')."',
							`leafDeleteAccessValue`	=	'".$this->strict($_GET['leafDeleteAccessValue'][$i],'numeric')."',
							`leafPrintAccessValue`	=	'".$this->strict($_GET['leafPrintAccessValue'][$i],'numeric')."',
							`leafPostAccessValue`	=	'".$this->strict($_GET['leafPostAccessValue'][$i],'numeric')."'
					WHERE 	`leafAccessId`	=	'".$this->strict($_GET['leafAccessId'][$i],'numeric')."'";
			} else if ($this->getVendor()==self::mssql) {
				$sql="
					UPDATE 	[leafAccess]
					SET 	[leafCreateAccessValue]	=	'".$this->strict($_GET['leafCreateAccessValue'][$i],'numeric')."',
							[leafReadAccessValue]	=	'".$this->strict($_GET['leafReadAccessValue'][$i],'numeric')."',
							[leafUpdateAccessValue]	=	'".$this->strict($_GET['leafUpdateAccessValue'][$i],'numeric')."',
							[leafDeleteAccessValue]	=	'".$this->strict($_GET['leafDeleteAccessValue'][$i],'numeric')."',
							[leafDeleteAccessValue]	=	'".$this->strict($_GET['leafDeleteAccessValue'][$i],'numeric')."',
							[leafPrintAccessValue]	=	'".$this->strict($_GET['leafPrintAccessValue'][$i],'numeric')."',
							[leafPostAccessValue]	=	'".$this->strict($_GET['leafPostAccessValue'][$i],'numeric')."'
					WHERE 	[leafAccessId]	=	'".$this->strict($_GET['leafAccessId'][$i],'numeric')."'";
			} else if ($this->getVendor()==self::oracle) {
				$sql="
				UPDATE 	\"leafAccess\"
				SET 	\"leafCreateAccessValue\"	=	'".$this->strict($_GET['leafCreateAccessValue'][$i],'numeric')."',
						\"leafReadAccessValue\"	=	'".$this->strict($_GET['leafReadAccessValue'][$i],'numeric')."',
						\"leafUpdateAccessValue\"	=	'".$this->strict($_GET['leafUpdateAccessValue'][$i],'numeric')."',
						\"leafDeleteAccessValue\"	=	'".$this->strict($_GET['leafDeleteAccessValue'][$i],'numeric')."',
						\"leafDeleteAccessValue\"	=	'".$this->strict($_GET['leafDeleteAccessValue'][$i],'numeric')."',
						\"leafPrintAccessValue\"	=	'".$this->strict($_GET['leafPrintAccessValue'][$i],'numeric')."',
						\"leafPostAccessValue\"	=	'".$this->strict($_GET['leafPostAccessValue'][$i],'numeric')."'
				WHERE 	\"leafAccessId\"	=	'".$this->strict($_GET['leafAccessId'][$i],'numeric')."'";
			}
			$this->q->update($sql);
		}
		if($this->q->execute=='fail') {

			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();
		} else {
			echo json_encode(array("success"=>"true","message"=>"Update Success"));
			exit();
		}

	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete(){

	}






	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {}

}



$leafAccessObject  	= 	new leafAccessClass();

if(isset($_SESSION['staffId'])){
	$leafAccessObject->staffIdTemporally = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$leafAccessObject-> vendor = $_SESSION['vendor'];
}
if(isset($_POST['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_POST['leafId'])){
		$leafAccessObject->leafId = $_POST['leafId'];
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$leafAccessObject->isAdmin = $_POST['isAdmin'];
	}
	if(isset($_POST['staffId'])){
		$leafAccessObject->staffId = $_POST['staffId'];
	}
	if(isset($_POST['accordionId'])){
		$leafAccessObject->accordionId = $_POST['accordionId'];
	}
	if(isset($_POST['folderId'])){
		$leafAccessObject->folderId = $_POST['folderId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$leafAccessObject->execute();
	if($_POST['method']=='read'){
		$leafAccessObject -> read();
	}
}
// crud -create,read,update,delete.
if(isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_GET['leafId'])){
		$leafAccessObject->leafId  = $_GET['leafId'];
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$leafAccessObject->isAdmin = $_GET['isAdmin'];
	}
	/*
	 *  Load the dynamic value
	 */
	$leafAccessObject->execute();
	if($_GET['method']=='read'){
		$leafAccessObject -> read();
	}
	if($_GET['method']=='update') {
		$leafAccessObject -> update();
	}
	if(isset($_GET['field'])){
		if($_GET['field']=='staffId'){
			$leafAccessObject ->staffId;
		}
		if($_GET['field']=='groupId'){
			$leafAccessObject -> group;
		}
		if($_GET['field']=='accordionId'){
			$leafAccessObject -> accordion();
		}
		if($_GET['field']=='folderId'){
			$leafAccessObject -> folder();
		}
	}

}

?>
