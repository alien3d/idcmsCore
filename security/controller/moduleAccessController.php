<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/moduleAccessModel.php");
/**
 * this is module security access
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @package Module Security Access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class moduleAccessClass extends configClass
{
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
	 * Duplicate Testing either the key of modulele same or have been created.
	 * @var bool
	 */
	public $duplicateTest;
	/**
	 * Common class function for security menu
	 * @var  string 
	 */
	private $security;

	/**
	 * Class Loader
	 */
	function execute()
	{
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

		$this->model         = new moduleAccessModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();


		$this->documentTrail = new documentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->execute();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create()
	{
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->getVendor() == self::mysql) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		// by default if add new group will add access to module and folder.
		if ($this->getVendor() == self::mysql) {
			$sql = "
				SELECT	`moduleAccess`.`moduleAccessId`,
						`module`.`moduleId`,
						`module`.`moduleNote`,
						`group`.`groupId`,
						`group`.`groupNote`,
						(CASE `moduleAccess`.`moduleAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `moduleAccessValue`
				FROM 	`moduleAccess`
				JOIN	`module`
				USING 	(`moduleId`)
				JOIN 	`group`
				USING 	(`groupId`)
				WHERE 	`module`.`isActive` 	=	1
				AND		`group`.`isActive`		=	1";
			if ($this->model->getGroupId()) {
				$sql .= " AND `group`.`groupId`=\"". $this->model->getGroupId() ."\"";
			}
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
				SELECT	`moduleAccess`.`moduleAccessId`,
						`module`.`moduleId`,
						`module`.`moduleNote`,
						`group`.`groupId`,
						`group`.`groupNote`,
						(CASE `moduleAccess`.`moduleAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `moduleAccessValue`
				FROM 	`moduleAccess`
				JOIN	`module`
				USING 	(`moduleId`)
				JOIN 	`group`
				USING 	(`groupId`)
				WHERE 	`module`.`isActive` 	=	1
				AND		`group`.`isActive`		=	1";
			if ($this->model->getGroupId()) {
				$sql .= " AND `group`.`groupId`=\"". $this->model->getGroupId() ."\"";
			}
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
				SELECT	`moduleAccess`.`moduleAccessId`,
						`module`.`moduleId`,
						`module`.`moduleNote`,
						`group`.`groupId`,
						`group`.`groupNote`,
						(CASE `moduleAccess`.`moduleAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `moduleAccessValue`
				FROM 	`moduleAccess`
				JOIN	`module`
				USING 	(`moduleId`)
				JOIN 	`group`
				USING 	(`groupId`)
				WHERE 	`module`.`isActive` 	=	1
				AND		`group`.`isActive`		=	1";
			if ($this->model->getGroupId()) {
				$sql .= " AND `group`.`groupId`=\"". $this->model->getGroupId() ."\"";
			}
		}
		//echo $sql;
		// searching filtering
		$sql .= $this->q->searching();
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		$total = $this->q->numberRows();
		//paging
		if (isset($this->getStart()) && isset($_POST['limit'])) {
			$sql .= " LIMIT  " . $this->getStart() . "," . $_POST['limit'] . " ";
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		$items = array();
		while ($row = $this->q->fetchAssoc()) {
			$items[] = $row;
		}
		if($total==1){
			$json_encode=json_encode(array(
            'success' => true,
            'total' => $total,
            'data' => $items
			));
			$json_encode =str_replace("[","",$json_encode);
			$json_encode =str_replace("]","",$json_encode);
			echo json_encode;
			exit();
		} else  {
			if (count($items) == 0) {
				$items = '';
			}
			echo json_encode(array(
            'success' => true,
            'total' => $total,
            'data' => $items
			));
			exit();
		}
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update()
	{
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

			$sql.="	   `moduleAccessValue`			=	case `".$this->model->getPrimaryKeyName()."` ";
			for($i=0;$i<$loop;$i++) {
				$sql.="
				WHEN \"".$this->model->getModuleAccessId($i, 'array')."\"
				THEN \"".$this->model->getModuleAccessValue($i,'array')."\"";

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
	/**
	 *  Return Group Identification
	 */
	function group()
	{
		return $this->security->group();
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete()
	{
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel()
	{
	}
}
$moduleAccessObject = new moduleAccessClass();

// crud -create,read,update,delete.
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST['leafId'])) {
		$moduleAccessObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$moduleAccessObject->setIsAdmin($_POST['isAdmin']);
	}

	/*
	 *  Load the dynamic value
	 */
	$moduleAccessObject->execute();
	if ($_POST['method'] == 'read') {
		$moduleAccessObject->read();
	}
}
if (isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_GET['leafId'])) {
		$moduleAccessObject->setLeafId($_GET['leafId']);
	}
	if(isset($_GET['isAdmin'])) {
		$moduleAccessObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$moduleAccessObject->execute();
	if ($_GET['method'] == 'update') {
		$moduleAccessObject->update();
	}
	if (isset($_GET['field'])) {
		if ($_GET['method'] == 'read' && $_GET['field'] == 'groupId') {
			$moduleAccessObject->group();
		}
	}
}
?>
