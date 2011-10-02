<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../model/leafGroupAccessModel.php");
/**
 * this is  leaf security access
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @package Leaf Group Access Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafGroupAccessClass  extends  configClass {
	/**
	 * Connection to the database
	 * @var string
	 */
	public $q;
	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string
	 */
	private $excel;
	/**
	 * Document Trail Audit.
	 * @var string 
	 */
	private $documentTrail;
	/**
	 * Audit Row True or False
	 * @var bool
	 */
	private $audit;
	/**
	 * Log Sql Statement True or False
	 * @var string
	 */
	private $log;
	/**
	 * Model
	 * @var string 
	 */
	public $model;
	/**
	 * Audit Filter
	 * @var string 
	 */
	public $auditFilter;
	/**
	 * Audit Column
	 * @var string 
	 */
	public $auditColumn;
	/**
	 * Duplicate Testing either the key of table same or have been created.
	 * @var bool
	 */
	public $duplicateTest;

	/**
	 * Class Loader
	 */
	function execute() {
		parent :: __construct();

		$this->q 					=	new Vendor();

		$this->q->vendor			=	$this->vendor;

		$this->q->leafId			=	$this->leafId;

		$this->q->staffId			=	$this->staffId;

		$this->q->fieldQuery 		= 	$this->fieldQuery;

		$this->q->gridQuery         =	$this->gridQuery;

		$this->q->quickFilter		=	$this->quickFilter;

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;

		$this->security 	= 	new security();
		$this->security->vendor= $this->vendor;
		$this->security->execute();

		$this->model         = new leafGroupAccessModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->documentTrail = new DocumentTrailClass();


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
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		// by default if add new group will add access to module and leaf.
		// just checking
		//	$this->checkLeaf();
		if($this->getVendor() == self::mysql) {
			$sql="
				SELECT	`leaf`.`moduleId`,
						`leaf`.`folderId`,
						`folder`.`folderNote`,
						`leaf`.`leafNote`,
						`module`.`moduleNote`,
						`group`.`groupNote`,
						`leafGroupAccess`.`leafId`,
						`leafGroupAccess`.`groupId`,
						`leafGroupAccess`.`leafGroupAccessId`,
						(CASE `leafGroupAccess`.`leafAccessCreateValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessCreateValue`,


						(CASE `leafGroupAccess`.`leafAccessReadValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessReadValue`,

						(CASE `leafGroupAccess`.`leafAccessUpdateValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessUpdateValue`,

						(CASE `leafGroupAccess`.`leafAccessDeleteValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessDeleteValue` ,

						(CASE `leafGroupAccess`.`leafAccessPrintValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessPrintValue`,

						(CASE `leafGroupAccess`.`leafAccessPostValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessPostValue`
				FROM 	`leafGroupAccess`
				JOIN	`leaf`
				USING	(`leafId`)
				JOIN	(`module`)
				USING	(`moduleId`)
				JOIN	(`folder`)
				USING	(`folderId`)
				JOIN	`group`
				USING	(`groupId`)
				WHERE 	`leaf`.`isActive`		=	1
				AND		`folder`.`isActive`		=	1
				AND		`module`.`isActive`	=	1
				AND		`group`.`isActive`		=	1";
			if($this->groupId) {
				$sql.=" AND `leafGroupAccess`.`groupId`=\"".$this->strict($this->groupId,'numeric')."\"";

			}
			if($this->moduleId) {
				$sql.=" AND `leaf`.`moduleId`=\"".$this->strict($this->moduleId,'numeric')."\"";
			}
			if($this->folderId) {
				$sql.=" AND `leaf`.`folderId`=\"".$this->strict($this->folderId,'numeric')."\"";
			}
		} else if ($this->getVendor()==self::mssql) {
			$sql="
				SELECT	[leaf].[moduleId],
						[leaf].[folderId],
						[folder].[folderNote],
						[leaf].[leafNote],
						[module].[moduleNote],
						[group].[groupNote],
						[leafGroupAccess].[leafId],
						[leafGroupAccess].[groupId],
						[leafGroupAccess].[leafGroupAccessId],
						(CASE [leafGroupAccess].[leafAccessCreateValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessCreateValue],


						(CASE [leafGroupAccess].[leafAccessReadValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessReadValue],

						(CASE [leafGroupAccess].[leafAccessUpdateValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessUpdateValue],

						(CASE [leafGroupAccess].[leafAccessDeleteValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessDeleteValue] ,

						(CASE [leafGroupAccess].[leafAccessPrintValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessPrintValue],

						(CASE [leafGroupAccess].[leafAccessPostValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessPostValue]
				FROM 	[leafGroupAccess]
				JOIN	[leaf]
				ON		[leafGroupAccess].[leafId]=[leaf].[leafId]
				JOIN	[module]
				ON		[leaf].[moduleId]=[module].[moduleId]
				JOIN	[folder]
				ON		[leaf].[folderId] = [folder].[folderId]
				JOIN	[group]
				ON		[leafGroupAccess].[groupId]= [group].[groupId]
				WHERE 	[leaf].[isActive]		=	1
				AND		[folder].[isActive]		=	1
				AND		[module].[isActive]	=	1
				AND		[group].[isActive]		=	1";
			if($this->groupId) {
				$sql.=" AND [leafGroupAccess].[groupId]=\"".$this->strict($this->groupId,'numeric')."\"";

			}
			if($this->moduleId) {
				$sql.=" AND [leaf].[moduleId]=\"".$this->strict($this->moduleId,'numeric')."\"";
			}
			if($this->folderId) {
				$sql.=" AND [leaf].[folderId]=\"".$this->strict($this->folderId,'numeric')."\"";
			}
		} else if ($this->getVendor()==self::oracle) {
			$sql="
				SELECT	LEAF.MODULEID,
						LEAF.FOLDERID,
						FOLDER.FOLDERNOTE,
						LEAF.LEAFNOTE,
						MODULE.MODULENOTE,
						GROUP_.GROUPNOTE,
						LEAFGROUPACCESS.LEAFID,
						LEAFGROUPACCESS.GROUPID,
						LEAFGROUPACCESS.LEAFGROUPACCESSID,
						(CASE LEAFGROUPACCESS.leafAccessCreateValue
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessCreateValue,


						(CASE LEAFGROUPACCESS.leafAccessReadValue
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessReadValue,

						(CASE LEAFGROUPACCESS.leafAccessUpdateValue
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessUpdateValue,

						(CASE LEAFGROUPACCESS.leafAccessDeleteValue
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessDeleteValue ,

						(CASE LEAFGROUPACCESS.leafAccessPrintValue
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessPrintValue,

						(CASE LEAFGROUPACCESS.leafAccessPostValue
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessPostValue
				FROM 	LEAFGROUPACCESS
				JOIN	LEAF
				USING	(LEAFID)
				JOIN	(MODULE)
				USING	(MODULEID)
				JOIN	(FOLDER)
				USING	(FOLDERID)
				JOIN	GROUP_
				USING	(GROUPID)
				WHERE 	LEAF.ISACTIVE		=	1
				AND		FOLDER.ISACTIVE		=	1
				AND		MODULE.ISACTIVE	=	1
				AND		GROUP_.ISACTIVE		=	1";
			if($this->groupId) {
				$sql.=" AND LEAFGROUPACCESS.GROUPID=\"".$this->strict($this->groupId,'numeric')."\"";

			}
			if($this->moduleId) {
				$sql.=" AND LEAF.MODULEID=\"".$this->strict($this->moduleId,'numeric')."\"";
			}
			if($this->folderId) {
				$sql.=" AND LEAF.FOLDERID=\"".$this->strict($this->folderId,'numeric')."\"";
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
			// select module access

			$items[]=$row;
			// select module access
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
			$sql="SET NAMES \"utf8\"";
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
					SET 	`leafAccessCreateValue`	=	\"".$this->strict($data_array[2],'boolean')."\",
							`leafAccessReadValue`	=	\"".$this->strict($data_array[2],'boolean')."\",
							`leafAccessUpdateValue`	=	\"".$this->strict($data_array[3],'boolean')."\",
							`leafAccessDeleteValue`	=	\"".$this->strict($data_array[4],'boolean')."\",
							`leafAccessPrintValue`	=	\"".$this->strict($data_array[5],'boolean')."\",
							`leafAccessPostValue`	=	\"".$this->strict($data_array[6],'boolean')."\"
					WHERE 	`leafGroupAccessId`	=	\"".$this->strict($data_array[0],'numeric')."\"";
				//echo $sql."<br>";
			} else if ($this->getVendor()==self::mssql) {
				$sql="
					UPDATE 	[leafGroupAccess]
					SET 	[leafAccessCreateValue]	=	\"".$this->strict($data_array[2],'boolean')."\",
							[leafAccessReadValue]	=	\"".$this->strict($data_array[2],'boolean')."\",
							[leafAccessUpdateValue]	=	\"".$this->strict($data_array[3],'boolean')."\",
							[leafAccessDeleteValue]	=	\"".$this->strict($data_array[4],'boolean')."\",
							[leafAccessPrintValue]	=	\"".$this->strict($data_array[5],'boolean')."\",
							[leafAccessPostValue]	=	\"".$this->strict($data_array[6],'boolean')."\"
					WHERE 	[leafGroupAccessId]	=	\"".$this->strict($data_array[0],'numeric')."\"";
			} else if ($this->getVendor()==self::oracle) {
				$sql="
					UPDATE 	LEAFGROUPACCESS
					SET 	leafAccessCreateValue	=	\"".$this->strict($data_array[2],'boolean')."\",
							leafAccessReadValue		=	\"".$this->strict($data_array[2],'boolean')."\",
							leafAccessUpdateValue	=	\"".$this->strict($data_array[3],'boolean')."\",
							leafAccessDeleteValue	=	\"".$this->strict($data_array[4],'boolean')."\",
							leafAccessPrintValue	=	\"".$this->strict($data_array[5],'boolean')."\",
							leafAccessPostValue		=	\"".$this->strict($data_array[6],'boolean')."\"
					WHERE 	LEAFGROUPACCESSID		=	\"".$this->strict($data_array[0],'numeric')."\"";
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

// crud -create,read,update,delete.
if(isset($_POST['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_POST['leafId'])){
		$leafGroupAccessObject->setleafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$leafGroupAccessObject->setIsAdmin($_POST['isAdmin']);
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
		$leafGroupAccessObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$leafGroupAccessObject->setIsAdmin($_GET['isAdmin']);
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
		if($_GET['field']=='moduleId'){
			$leafGroupAccessObject -> module();
		}
		if($_GET['field']=='folderId'){
			$leafGroupAccessObject -> folder();
		}
	}

}

?>
