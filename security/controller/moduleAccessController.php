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
 * @package module security access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class moduleAccessClass extends configClass
{
			/*
	 * Connection to the damodulease
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
	 * Duplicate Testing either the key of modulele same or have been created.
	 * @var boolean $duplicateTest;
	 */
	public $duplicateTest;
	/**
	 * Common class function for security menu
	 * @var  string $security
	 */
	private $security;

	/**
	 * Class Loader
	 */
	function execute()
	{
		parent::__construct();
		$this->q              = new vendor();
		$this->q->vendor      = $this->vendor;
		$this->q->leafId      = $this->leafId;
		$this->q->staffId     = $this->staffId;
		$this->q->filter      = $this->filter;
		$this->q->quickFilter = $this->quickFilter;
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDamodulease(), $this->getPassword());
		$this->excel             = new PHPExcel();
		$this->audit             = 0;
		$this->log               = 1;
		$this->q->log            = $this->log;
		$this->security          = new security();
		$this->security->vendor  = $this->vendor;
		$this->security->execute();
		$this->model         = new moduleAccessModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->documentTrail = new documentTrailClass();
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
			if ($this->groupId) {
				$sql .= " AND `group`.`groupId`=\"". $this->strict($this->groupId, 'numeric') ."\"";
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
			if ($this->groupId) {
				$sql .= " AND `group`.`groupId`=\"". $this->strict($this->groupId, 'numeric') ."\"";
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
			if ($this->groupId) {
				$sql .= " AND `group`.`groupId`=\"". $this->strict($this->groupId, 'numeric') ."\"";
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
		if (isset($_POST['start']) && isset($_POST['limit'])) {
			$sql .= " LIMIT  " . $_POST['start'] . "," . $_POST['limit'] . " ";
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		while ($row = $this->q->fetchAssoc()) {
			$items[] = $row;
		}
		echo json_encode(array(
            'success' => 'true',
            'total' => $this->total,
            'data' => $items
		));
		exit();
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
		$loop = $this->model->totalmoduleAccessId;
		for ($i = 0; $i < $loop; $i++) {
			if($this->getVendor() == self::mysql){
				$sql = "
			UPDATE 	`moduleAccess`
			SET 	`moduleAccessValue`	= 	\"". $this->model->moduleAccessValue[$i] ."\"
			WHERE 	`moduleAccessId`		=	\"". $this->model->moduleAccessId[$i] ."\"";
			} else if ($this->getVendor() ==  self::mssql){
				$sql = "
			UPDATE 	[moduleAccess]
			SET 	[moduleAccessValue]	= 	\"". $this->model->moduleAccessValue[$i] ."\"
			WHERE 	[moduleAccessId]		=	\"". $this->model->moduleAccessId[$i] ."\"";
			} else if ($this->getVendor()==self::oracle){
				$sql = "
			UPDATE 	\"moduleAccess\"
			SET 	\"moduleAccessValue\"	= 	\"". $this->model->moduleAccessValue[$i] ."\"
			WHERE 	\"moduleAccessId\"		=	\"". $this->model->moduleAccessId[$i] ."\"";
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
		$moduleAccessObject->leafId = $_POST['leafId'];
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$moduleAccessObject->isAdmin = $_POST['isAdmin'];
	}
	if (isset($_POST['groupId'])) {
		$moduleAccessObject->groupId = $_POST['groupId'];
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
		$moduleAccessObject->leafId = $_GET['leafId'];
	}
	if(isset($_GET['isAdmin'])) {
		$moduleAccessObject->isAdmin = $_GET['isAdmin'];
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
