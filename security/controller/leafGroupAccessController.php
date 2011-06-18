<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../class/classDocumentTrail.php");
require_once("../model/leafGroupAccessModel.php");
/**
 * this is  leaf security access
 * @name IDCMS
 * @version 2
 * @author hafizan,yusuf
 * @package leaf_group_security_access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafGroupAccessClass  extends  configClass {
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

		$this->q->fieldQuery 		= 	$this->fieldQuery;

		$this->q->gridQuery         =	$this->gridQuery;

		$this->q->quickFilter		=	$this->quickFilter;

		$this->q->connect($this->connection, $this->username,$this->database,$this->password);

		$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;

		$this->security 	= 	new security();
		$this->security->vendor= $this->vendor;
		$this->security->execute();

		$this->model         = new leafGroupAccessModel();
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
		// just checking
		//	$this->checkLeaf();
		if($this->getVendor() == self::mysql) {
			$sql="
				SELECT	`leaf`.`accordionId`,
						`leaf`.`folderId`,
						`folder`.`folderNote`,
						`leaf`.`leafNote`,
						`accordion`.`accordionNote`,
						`group`.`groupNote`,
						`leafGroupAccess`.`leafId`,
						`leafGroupAccess`.`groupId`,
						`leafGroupAccess`.`leafGroupAccessId`,
						(CASE `leafGroupAccess`.`leafCreateAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafCreateAccessValue`,


						(CASE `leafGroupAccess`.`leafReadAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafReadAccessValue`,

						(CASE `leafGroupAccess`.`leafUpdateAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafUpdateAccessValue`,

						(CASE `leafGroupAccess`.`leafDeleteAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafDeleteAccessValue` ,

						(CASE `leafGroupAccess`.`leafPrintAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafPrintAccessValue`,

						(CASE `leafGroupAccess`.`leafPostAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafPostAccessValue`
				FROM 	`leafGroupAccess`
				JOIN	`leaf`
				USING	(`leafId`)
				JOIN	(`accordion`)
				USING	(`accordionId`)
				JOIN	(`folder`)
				USING	(`folderId`)
				JOIN	`group`
				USING	(`groupId`)
				WHERE 	`leaf`.`isActive`		=	1
				AND		`folder`.`isActive`		=	1
				AND		`accordion`.`isActive`	=	1
				AND		`group`.`isActive`		=	1";
			if($this->groupId) {
				$sql.=" AND `leafGroupAccess`.`groupId`='".$this->strict($this->groupId,'numeric')."'";

			}
			if($this->accordionId) {
				$sql.=" AND `leaf`.`accordionId`='".$this->strict($this->accordionId,'numeric')."'";
			}
			if($this->folderId) {
				$sql.=" AND `leaf`.`folderId`='".$this->strict($this->folderId,'numeric')."'";
			}
		} else if ($this->getVendor()==self::mssql) {
			$sql="
				SELECT	[leaf].[accordionId],
						[leaf].[folderId],
						[folder].[folderNote],
						[leaf].[leafNote],
						[accordion].[accordionNote],
						[group].[groupNote],
						[leafGroupAccess].[leafId],
						[leafGroupAccess].[groupId],
						[leafGroupAccess].[leafGroupAccessId],
						(CASE [leafGroupAccess].[leafCreateAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafCreateAccessValue],


						(CASE [leafGroupAccess].[leafReadAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafReadAccessValue],

						(CASE [leafGroupAccess].[leafUpdateAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafUpdateAccessValue],

						(CASE [leafGroupAccess].[leafDeleteAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafDeleteAccessValue] ,

						(CASE [leafGroupAccess].[leafPrintAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafPrintAccessValue],

						(CASE [leafGroupAccess].[leafPostAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafPostAccessValue]
				FROM 	[leafGroupAccess]
				JOIN	[leaf]
				ON		[leafGroupAccess].[leafId]=[leaf].[leafId]
				JOIN	[accordion]
				ON		[leaf].[accordionId]=[accordion].[accordionId]
				JOIN	[folder]
				ON		[leaf].[folderId] = [folder].[folderId]
				JOIN	[group]
				ON		[leafGroupAccess].[groupId]= [group].[groupId]
				WHERE 	[leaf].[isActive]		=	1
				AND		[folder].[isActive]		=	1
				AND		[accordion].[isActive]	=	1
				AND		[group].[isActive]		=	1";
			if($this->groupId) {
				$sql.=" AND [leafGroupAccess].[groupId]='".$this->strict($this->groupId,'numeric')."'";

			}
			if($this->accordionId) {
				$sql.=" AND [leaf].[accordionId]='".$this->strict($this->accordionId,'numeric')."'";
			}
			if($this->folderId) {
				$sql.=" AND [leaf].[folderId]='".$this->strict($this->folderId,'numeric')."'";
			}
		} else if ($this->getVendor()==self::oracle) {
			$sql="
				SELECT	\"leaf\".\"accordionId\",
						\"leaf\".\"folderId\",
						\"folder\".\"folderNote\",
						\"leaf\".\"leafNote\",
						\"accordion\".\"accordionNote\",
						\"group\".\"groupNote\",
						\"leafGroupAccess\".\"leafId\",
						\"leafGroupAccess\".\"groupId\",
						\"leafGroupAccess\".\"leafGroupAccessId\",
						(CASE \"leafGroupAccess\".\"leafCreateAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafCreateAccessValue\",


						(CASE \"leafGroupAccess\".\"leafReadAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafReadAccessValue\",

						(CASE \"leafGroupAccess\".\"leafUpdateAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafUpdateAccessValue\",

						(CASE \"leafGroupAccess\".\"leafDeleteAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafDeleteAccessValue\" ,

						(CASE \"leafGroupAccess\".\"leafPrintAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafPrintAccessValue\",

						(CASE \"leafGroupAccess\".\"leafPostAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafPostAccessValue\"
				FROM 	\"leafGroupAccess\"
				JOIN	\"leaf\"
				USING	(\"leafId\")
				JOIN	(\"accordion\")
				USING	(\"accordionId\")
				JOIN	(\"folder\")
				USING	(\"folderId\")
				JOIN	\"group\"
				USING	(\"groupId\")
				WHERE 	\"leaf\".\"isActive\"		=	1
				AND		\"folder\".\"isActive\"		=	1
				AND		\"accordion\".\"isActive\"	=	1
				AND		\"group\".\"isActive\"		=	1";
			if($this->groupId) {
				$sql.=" AND \"leafGroupAccess\".\"groupId\"='".$this->strict($this->groupId,'numeric')."'";

			}
			if($this->accordionId) {
				$sql.=" AND \"leaf\".\"accordionId\"='".$this->strict($this->accordionId,'numeric')."'";
			}
			if($this->folderId) {
				$sql.=" AND \"leaf\".\"folderId\"='".$this->strict($this->folderId,'numeric')."'";
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
		$this->total	= $this->q->numberRows();
		//paging




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


		if(count($items)==0) {
			$items='';
		}
		echo json_encode(
		array('success'=>'true',
			'total' => $this->total,
			'data' => $items
		));
		exit();
	}

	function update() 				{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		$data	= explode("|",$_POST['info']); // still using & for future reference
		$loop=count($data);
		for($i=0;$i<$loop;$i++) {
			// explode again
			// mysql doesn't support bolean expression
			$data_array = explode(",",$data[$i]);
			//echo print_r($data_array);

			if($this->getVendor() == self::mysql) {
				$sql="
					UPDATE 	`leafGroupAccess`
					SET 	`leafCreateAccessValue`	=	'".$this->strict($data_array[2],'boolean')."',
							`leafReadAccessValue`	=	'".$this->strict($data_array[2],'boolean')."',
							`leafUpdateAccessValue`	=	'".$this->strict($data_array[3],'boolean')."',
							`leafDeleteAccessValue`	=	'".$this->strict($data_array[4],'boolean')."',
							`leafPrintAccessValue`	=	'".$this->strict($data_array[5],'boolean')."',
							`leafPostAccessValue`	=	'".$this->strict($data_array[6],'boolean')."'
					WHERE 	`leafGroupAccessId`	=	'".$this->strict($data_array[0],'numeric')."'";
				//echo $sql."<br>";
			} else if ($this->getVendor()==self::mssql) {
				$sql="
					UPDATE 	[leafGroupAccess]
					SET 	[leafCreateAccessValue]	=	'".$this->strict($data_array[2],'boolean')."',
							[leafReadAccessValue]	=	'".$this->strict($data_array[2],'boolean')."',
							[leafUpdateAccessValue]	=	'".$this->strict($data_array[3],'boolean')."',
							[leafDeleteAccessValue]	=	'".$this->strict($data_array[4],'boolean')."',
							[leafPrintAccessValue]	=	'".$this->strict($data_array[5],'boolean')."',
							[leafPostAccessValue]	=	'".$this->strict($data_array[6],'boolean')."'
					WHERE 	[leafGroupAccessId]	=	'".$this->strict($data_array[0],'numeric')."'";
			} else if ($this->getVendor()==self::oracle) {
				$sql="
					UPDATE 	\"leafGroupAccess\"
					SET 	\"leafCreateAccessValue\"	=	'".$this->strict($data_array[2],'boolean')."',
							\"leafReadAccessValue\"		=	'".$this->strict($data_array[2],'boolean')."',
							\"leafUpdateAccessValue\"	=	'".$this->strict($data_array[3],'boolean')."',
							\"leafDeleteAccessValue\"	=	'".$this->strict($data_array[4],'boolean')."',
							\"leafPrintAccessValue\"	=	'".$this->strict($data_array[5],'boolean')."',
							\"leafPostAccessValue\"		=	'".$this->strict($data_array[6],'boolean')."'
					WHERE 	\"leafGroupAccessId\"		=	'".$this->strict($data_array[0],'numeric')."'";
			}
			$this->q->update($sql);
			if($this->q->execute=='fail'){
				echo json_encode(array("success"=>false,"message"=>$this->q->responce));
				exit();
			}
		}
		echo json_encode(array("success"=>true,"message"=>"Update Success"));
		exit();



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
$leafGroupAccessObject  	= 	new leafGroupAccessClass();
if(isset($_SESSION['staffId'])){
	$leafGroupAccessObject->staffId = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$leafGroupAccessObject-> vendor = $_SESSION['vendor'];
}
// crud -create,read,update,delete.
if(isset($_POST['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_POST['leafId'])){
		$leafGroupAccessObject->leafId = $_POST['leafId'];
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$leafGroupAccessObject->isAdmin = $_POST['isAdmin'];
	}
	if(isset($_POST['groupId'])){
		$leafGroupAccessObject->groupId = $_POST['groupId'];
	}
	if(isset($_POST['accordionId'])){
		$leafGroupAccessObject->accordionId = $_POST['accordionId'];
	}
	if(isset($_POST['folderId'])){
		$leafGroupAccessObject->folderId = $_POST['folderId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$leafGroupAccess_obj->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_POST['method']=='read'){
		$leafGroupAccessObject-> read();
	}
}
if(isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_GET['leafId'])){
		$leafGroupAccessObject->leafId  = $_GET['leafId'];
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$leafGroupAccessObject->isAdmin = $_GET['isAdmin'];
	}
	/*
	 *
	 *  Load the dynamic value
	 */
	$leafGroupAccessObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_GET['method']=='update') {
		$leafGroupAccessObject -> update();
	}
	if(isset($_GET['field'])){
		if($_GET['field']=='staffId'){
			$leafGroupAccessObject -> staffId();
		}
		if($_GET['field']=='groupId'){
			$leafGroupAccessObject -> group;
		}
		if($_GET['field']=='accordionId'){
			$leafGroupAccessObject -> accordion();
		}
		if($_GET['field']=='folderId'){
			$leafGroupAccessObject -> folder();
		}
	}

}

?>
