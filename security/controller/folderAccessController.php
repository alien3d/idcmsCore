<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/folderAccessModel.php");
/**
 * this is  folder security access
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @subpackage Folder Security Access Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */

class folderAccessClass  extends configClass {
	/*
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
	/*
	 * @var  string $security
	 */
	private $security;

	/**
	 * Class Loader
	 */
	function execute() {
		parent::__construct();

		$this->q              = new vendor();
		$this->q->vendor      = $this->getVendor();
		$this->q->leafId      = $this->getLeafId();
		$this->q->staffId     = $this->getStaffId();
		$this->q->fieldQuery     = $this->getFieldQuery();
		$this->q->gridQuery = $this->getGridQuery();
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->excel             = new PHPExcel();

		$this->audit             = 0;
		$this->log               = 1;
		$this->q->log            = $this->log;

		$this->security          = new security();
		$this->security->setVendor($this->getVendor());
		$this->security->execute();

		$this->model         = new folderAccessModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();
	}
	function create() {}
	function read() 				{
		header('Content-Type','application/json; charset=utf-8');
		$items =array();
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		// by default if add new group will add access to module and folder.
		if($this->getVendor() == self::mysql) {
			$sql="
				SELECT	`module`.`moduleNote`,
						`module`.`moduleId`,
						`folder`.`folderId`,
						`folder`.`folderNote`,
						`group`.`groupId`,
						`group`.`groupNote`,
						`folderAccess`.`folderAccessId`,
						(CASE `folderAccess`.`folderAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `folderAccessValue`
				FROM 	`folderAccess`
				JOIN	`folder`
				USING 	(`folderId`)
				JOIN 	`group`
				USING 	(`groupId`)
				JOIN 	`module`
				USING	(`moduleId`)
				WHERE 	`module`.`isActive` =1
				AND		`folder`.`isActive`=1
				AND		`group`.`isActive` =1";
			if($this->model->getGroupId()) {
				$sql.=" AND `group`.`groupId`=\"".$this->model->getGroupId()."\"";
			}
			if($this->model->getModuleId()) {
				$sql.=" AND `folder`.`moduleId`=\"".$this->model->getModuleId()."\"";
			}

		}  else if ( $this->getVendor()==self::mssql) {
			$sql="
				SELECT	[module].[moduleNote],
						[module].[moduleId],
						[folder].[folderId],
						[folder].[folderNote],
						[group].[groupId],
						[group].[groupNote],
						[folderAccess].[folderAccessId],
						(CASE [folderAccess].[folderAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [folderAccessValue]
				FROM 	[folderAccess]
				JOIN	[folder]
				ON 		[folder].[folderId]=[folderAccess].[folderId]
				JOIN 	[group]
				ON 		[group].[groupId]=[folderAccess].[groupId]
				JOIN 	[module]
				ON		[folder].[moduleId]=[module].[moduleId]
				WHERE 	[folder].[isActive]=1
				AND		[group].[isActive]=1
				AND		[module].[moduleId]=1";
			if($this->model->getGroupId()) {
				$sql.=" AND [group].[groupId]=\"".$this->model->getGroupId()."\"";
			}
			if($this->model->getModuleId()) {
				$sql.=" AND [folder].[moduleId]=\"".$this->model->getModuleId()."\"";
			}
		}  else if ($this->getVendor()==self::oracle) {
			$sql="
				SELECT	\"module\".\"moduleNote\",
						\"module\".\"moduleId\",
						\"folder\".\"folderId\",
						\"folder\".\"folderNote\",
						\"group\".\"groupId\",
						\"group\".\"groupNote\",
						\"folderAccess\".\"folderAccessId\",
						(CASE	\"folderAccess\".\"folderAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"folderAccessValue\"
				FROM 	\"folderAccess\"
				JOIN	\"folder\"
				USING 	(\"folderId\")
				JOIN 	\"group\"
				USING 	(\"groupId\")
				JOIN 	\"module\"
				USING	(\"moduleId\")
				WHERE 	\"folder\".\"isActive\"		=	1
				AND		\"module\".`isActive\"	=	1
				AND		\"group\".`isActive\"		=	1";
			if($this->model->getGroupId()) {
				$sql.=" AND \"group\".\"groupId\"=\"".$this->model->getGroupId()."\"";
			}
			if($this->model->getModuleId()) {
				$sql.=" AND \"folder\".\"moduleId\"=\"".$this->model->getModuleId()."\"";
			}
		}
		//echo $sql;
		// searching filtering
		$sql.=$this->q->searching();

		$this->q->read($sql);
		if($this->q->execute=='fail') {

			echo json_encode(
			array(
					  	"success"	=>	false,
						"message"	=>	$this->q->responce
			));
			exit();

		}
		$total  = 0 ;  //assign as number
		$total	= $this->q->numberRows();
		//paging

	 if ($this->getOrder() && $this->getSortField()) {
	 	if ($this->getVendor() == self::mysql) {
	 		$sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder(). " ";
	 	} else if ($this->getVendor() ==  self::mssql) {
	 		$sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
	 	} else if ($this->getVendor() == self::oracle) {
	 		$sql .= "	ORDER BY \"" . $this->getSortField() . "\"  " . $this->getOrder() . " ";
	 	}
	 }



		$this->q->read($sql);
		if($this->q->execute=='fail') {

			echo json_encode(
			array(
					  	"success"	=>	false,
						"message"	=>	$this->q->responce
			));
			exit();

		}

		while($row  = 	$this->q->fetchAssoc()) {
			// select module access

			$items[]=$row;
			// select module access
		}


		echo json_encode(
		array('success'=>true,
			'total' => $total,
			'data' => $items
		));



	}

	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() 				{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if($this->q->vendor==self::mysql){
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->model->update();
		$loop = $this->model->getTotal();

		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE 	`".$this->model->getTableName()."`
			SET 	";

			$sql.="	   `folderAccessValue`			=	case `".$this->model->getPrimaryKeyName()."` ";
			for($i=0;$i<$loop;$i++) {
				$sql.="
				WHEN \"".$this->model->getFolderAccessId($i, 'array')."\"
				THEN \"".$this->model->getFolderAccessValue($i,'array')."\"";

			}
			$sql.="	END ";
			$sql.=" WHERE 	`".$this->model->getPrimaryKeyName()."`		IN	(". $this->model->getPrimaryKeyAll(). ")";

		}


		//	echo $sql."<br>";
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                    "success" => false,
                    "message" => $this->q->responce
			));
			exit();
		}
		echo json_encode(array(
            "success" => true,
            "message" => "Update Success"
            ));
            exit();


	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete() { }



	/**
	 * Enter description here ...
	 */
	function group() {

		$this->security->group();
	}
	/**
	 * Enter description here ...
	 */
	function module() {
		$this->security->module();
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel(){

	}






}



$folderAccessObject  	= 	new folderAccessClass();

if(isset($_POST['method'])){

	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_POST['leafId'])){
		$folderAccessObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$folderAccessObject->setIsAdmin($_POST['isAdmin']);
	}


	/*
	 *  Paging
	 */
	if(isset($_POST['start'])){
		$folderAccessObject->setStart($_POST['start']);
	}
	if(isset($_POST['limit'])){
		$folderAccessObject->setLimit($_POST['perPage']);
	}
	/**
	 *  Filtering
	 */
	if(isset($_POST['query'])){
		$folderAccessObject->setFieldQuery($_POST['query']);
	}
	if(isset($_POST['filter'])){
		$folderAccessObject->setGridQuery($_POST['filter']);
	}
	/*
	 * Ordering
	 */
	if(isset($_POST['order'])){
		$folderAccessObject->setOrder($_POST['order']);
	}
	if(isset($_POST['sortField'])){
		$folderAccessObject->setSortField($_POST['sortField']);
	}

	/*
	 *  Load the dynamic value
	 */
	$folderAccessObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_POST['method']=='read'){
		$folderAccessObject -> read();
	}
}
if(isset($_GET['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_GET['method'])){
		$folderAccessObject ->setleafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$folderAccessObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$folderAccessObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_GET['method']=='update'){
		$folderAccessObject->update();
	}

	if(isset($_GET['field'])){
		if($_GET['field']=='groupId') {
			$folderAccessObject->group();
		}
		if($_GET['field']=='moduleId'){
			$folderAccessObject->module();
		}
	}
	/*
	 *  Excel Reporing
	 */
	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$folderAccessObject->excel();
		}
	}
}

?>
