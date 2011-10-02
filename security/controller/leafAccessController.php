<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../model/leafAccessModel.php");
/**
 * this is  leaf security access
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @package Leaf Security Access Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafAccessClass extends  configClass {
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

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->vendor;

		$this->q->leafId			=	$this->leafId;

		$this->q->staffId			=	$this->staffIdTemporally;

		$this->q->filter 			= 	$this->filter;

		$this->q->quickFilter		=	$this->quickFilter;

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

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
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		// by default if add new group will add access to module and leaf.
		if($this->getVendor() == self::mysql) {
			$sql="
				SELECT	`leaf`.`moduleId`,
						`leaf`.`folderId`,
						`folder`.`folderNote`,
						`leaf`.`leafNote`,
						`module`.`moduleNote`,
						`staff`.`staffName`,
						`group`.`groupNote`,
						`leafAccess`.`leafId`,
						`leafAccess`.`staffId`,
						`leafAccess`.`leafAccessId`,
						 (CASE `leafAccess`.`leafAccessCreateValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessCreateValue`,


						 (CASE `leafAccess`.`leafAccessReadValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessReadValue`,

						(CASE `leafAccess`.`leafAccessUpdateValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessUpdateValue`,

						(CASE `leafAccess`.`leafAccessDeleteValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessDeleteValue` ,

						(CASE `leafAccess`.`leafAccessPrintValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessPrintValue`,

						(CASE `leafAccess`.`leafAccessPostValue`
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafAccessPostValue`
				FROM 	`leafAccess`
				JOIN	`leaf`
				USING	(`leafId`)
				JOIN	(`module`)
				USING	(`moduleId`,`languageId`)
				JOIN	(`folder`)
				USING	(`folderId`,`languageId`)
				JOIN	`staff`
				USING	(`staffId`,`languageId`)
				JOIN	`group`
				USING	(`groupId`,`languageId`)
				WHERE 	`module`.`isActive` 	=	1
				AND		`folder`.`isActive` 	=	1
				AND		`leaf`.`isActive`		=	1 ";
			if($this->model->getModuleId()) {
				$sql.=" AND `leaf`.`moduleId`		=	\"".$this->model->getModuleId()."\"";
			}
			if($this->model->getFolderId()) {
				$sql.=" AND `leaf`.`folderId`		=	\"".$this->model->getFolderId()."\"";
			}
			if($this->model->getStaffId()) {
				$sql.=" AND `leafAccess`.`staffId`	=	\"".$this->model->getStaffId()."\"";
			}
		} else if ($this->getVendor()==self::mssql) {
			$sql="
				SELECT	[leaf].[moduleId],
						[leaf].[folderId],
						[folder].[folderNote],
						[leaf].[leafNote],
						[module].[moduleNote],
						[staff].[staffName],
						[group].[groupNote],
						[leafAccess].[leafId],
						[leafAccess].[staffId],
						[leafAccess].[leafAccessId],
						 (CASE [leafAccess].[leafAccessCreateValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessCreateValue],


						 (CASE [leafAccess].[leafAccessReadValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessReadValue],

						(CASE [leafAccess].[leafAccessUpdateValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessUpdateValue],

						(CASE [leafAccess].[leafAccessDeleteValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessDeleteValue] ,

						(CASE [leafAccess].[leafAccessPrintValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessPrintValue],

						(CASE [leafAccess].[leafAccessPostValue]
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessPostValue]
				FROM 	[leafAccess]
				JOIN	[leaf]
				ON		[leafAccess].[leafId] = [leaf].[leafId]
				JOIN	[module]
				ON		[leaf].[moduleId]=[module].[moduleId]
				JOIN	[folder]
				ON		[folder].[folderId]=[leaf].[folderId]
				JOIN	[staff]
				ON		[leaf].[staffId]=[staff].[staffId]
				JOIN	[group]
				USING	[group].[groupId]=[leafAccess].[groupId]
				WHERE 	[module].[isActive] 	=	1
				AND		[folder].[isActive] 	=	1
				AND		[leaf].[isActive]		=	1  ";
			if($this->model->getModuleId()) {
				$sql.=" AND [leaf].[moduleId]		=	'".$this->strict($this->moduleId,'numeric')."'";
			}
			if($this->model->getFolderId()) {
				$sql.=" AND [leaf].[folderId]		=	'".$this->strict($this->folderId,'numeric')."'";
			}
			if($this->model->getStaffId()) {
				$sql.=" AND [leafAccess`.[staffId]	=	'".$this->strict($this->staffId,'numeric')."'";
			}
		} else if ($this->getVendor()==self::oracle) {
			$sql="
				SELECT	LEAF.MODULEID,
						LEAF.FOLDERID,
						FOLDER.FOLDERNOTE,
						LEAF.LEAFNOTE,
						MODULE.MODULENOTE,
						STAFF.STAFFNAME,
						GROUP_.GROUPNOTE,
						LEAFACCESS.LEAFID,
						LEAFACCESS.STAFFID,
						LEAFACCESS.LEAFACCESSID,
						 (CASE LEAFACCESS.leafAccessCreateValue
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessCreateValue,


						 (CASE LEAFACCESS.leafAccessReadValue
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessReadValue,

						(CASE LEAFACCESS.LEAFACCESSUPDATEVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessUpdateValue,

						(CASE LEAFACCESS.LEAFACCESSDELETEVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessDeleteValue ,

						(CASE LEAFACCESS.LEAFACCESSPRINTVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessPrintValue,

						(CASE LEAFACCESS.LEAFACCESSPOSTVALUE
						 	WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafAccessPostValue
				FROM 	LEAFACCESS
				JOIN	LEAF
				USING	(LEAFID)
				JOIN	(MODULE)
				USING	(MODULEID,LANGUAGEID)
				JOIN	(FOLDER)
				USING	(FOLDERID,LANGUAGEID)
				JOIN	STAFF
				USING	(STAFFID,LANGUAGEID)
				JOIN	GROUP_
				USING	(GROUPID,LANGUAGEID)
				WHERE 	LEAF.ISACTIVE=1
				AND		FOLDER.ISACTIVE=1
				AND		MODULE.ISACTIVE=1
				AND		STAFF.ISACTIVE=1";
			if($this->model->getModuleId()) {
				$sql.=" AND LEAFACCESS.MODULEID='".$this->model->getModuleId()."'";
			}
			if($this->model->getFolderId()) {
				$sql.=" AND LEAFACCESS.FOLDERID='".$this->model->getFolderId()."'";
			}
			if($this->model->getStaffId()) {
				$sql.=" AND LEAFACCESS.STAFFID='".$this->model->getStaffId()."'";
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

		if(isset($this->getStart()) && isset($_POST['limit'])) {
			$sql.=" LIMIT  ".$this->getStart().",".$_POST['limit']." ";
		}



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
	function moduleId() {
		return $this->security->moduleId();
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
			$sql="SET NAMES \"utf8\"";
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
					SET 	`leafAccessCreateValue`	=	\"".$this->strict($_GET['leafAccessCreateValue'][$i],'numeric')."\",
							`leafAccessReadValue`	=	\"".$this->strict($_GET['leafAccessReadValue'][$i],'numeric')."\",
							`leafAccessUpdateValue`	=	\"".$this->strict($_GET['leafAccessUpdateValue'][$i],'numeric')."\",
							`leafAccessDeleteValue`	=	\"".$this->strict($_GET['leafAccessDeleteValue'][$i],'numeric')."\",
							`leafAccessDraftValue`	=	\"".$this->strict($_GET['leafAccessDraftValue'][$i],'numeric')."\",
							`leafAccessPrintValue`	=	\"".$this->strict($_GET['leafAccessPrintValue'][$i],'numeric')."\",
							`leafAccessPostValue`	=	\"".$this->strict($_GET['leafAccessPostValue'][$i],'numeric')."\"
					WHERE 	`leafAccessId`			=	\"".$this->strict($_GET['leafAccessId'][$i],'numeric')."\"";
			} else if ($this->getVendor()==self::mssql) {
				$sql="
					UPDATE 	[leafAccess]
					SET 	[leafAccessCreateValue]	=	'".$this->strict($_GET['leafAccessCreateValue'][$i],'numeric')."',
							[leafAccessReadValue]	=	'".$this->strict($_GET['leafAccessReadValue'][$i],'numeric')."',
							[leafAccessUpdateValue]	=	'".$this->strict($_GET['leafAccessUpdateValue'][$i],'numeric')."',
							[leafAccessDeleteValue]	=	'".$this->strict($_GET['leafAccessDeleteValue'][$i],'numeric')."',
							[leafAccessDraftValue]	=	'".$this->strict($_GET['leafAccessDraftValue'][$i],'numeric')."',
							[leafAccessPrintValue]	=	'".$this->strict($_GET['leafAccessPrintValue'][$i],'numeric')."',
							[leafAccessPostValue]	=	'".$this->strict($_GET['leafAccessPostValue'][$i],'numeric')."'
					WHERE 	[leafAccessId]			=	'".$this->strict($_GET['leafAccessId'][$i],'numeric')."'";
			} else if ($this->getVendor()==self::oracle) {
				$sql="
				UPDATE 	LEAFACCESS
				SET 	LEAFACCESSCREATEVALUE	=	'".$this->strict($_GET['leafAccessCreateValue'][$i],'numeric')."',
						LEAFACCESSREADVALUE		=	'".$this->strict($_GET['leafAccessReadValue'][$i],'numeric')."',
						LEAFACCESSUPDATEVALUE	=	'".$this->strict($_GET['leafAccessUpdateValue'][$i],'numeric')."',
						LEAFACCESSDELETEVALUE	=	'".$this->strict($_GET['leafAccessDeleteValue'][$i],'numeric')."',
						LEAFACCESSDRAFTVALUE	=	'".$this->strict($_GET['leafAccessDeleteValue'][$i],'numeric')."',
						LEAFACCESSPRINTVALUE	=	'".$this->strict($_GET['leafAccessPrintValue'][$i],'numeric')."',
						LEAFACCESSPOSTVALUE		=	'".$this->strict($_GET['leafAccessPostValue'][$i],'numeric')."'
				WHERE 	LEAFACCESSID			=	'".$this->strict($_GET['leafAccessId'][$i],'numeric')."'";
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


if(isset($_POST['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_POST['leafId'])){
		$leafAccessObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$leafAccessObject->setIsAdmin($_POST['isAdmin']);
	}

	/*
	 *  Load the dynamic value
	 */
	$leafAccessObject->execute();
	/*
	 *  Crud Operation
	 */
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
		$leafAccessObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$leafAccessObject->setIsAdmin($_GET['isAdmin']);
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
		if($_GET['field']=='moduleId'){
			$leafAccessObject -> module();
		}
		if($_GET['field']=='folderId'){
			$leafAccessObject -> folder();
		}
	}

}

?>
