<?php
require_once("../../class/classValidation.php");
/**
 * this is module security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Security
 * @package Model Access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class moduleAccessModel extends validationClass
{

	private $moduleAccessId;
	private $moduleId;
	private $groupId;
	private $moduleAccessValue;

	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute()
	{
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('moduleAccess');
		$this->setPrimaryKeyName('moduleAccessId');
		/*
		 *  All the $_GET enviroment.
		 */
		if(isset($_GET['moduleAccessId'])) {
			$this->setTotal(count($_GET['moduleAccessId']));
		}
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['groupId'])){
			$this->setGroupId($_POST['groupId']);
		}
		// auto assign as array if true
		if(is_array($_GET['moduleAccessId'])){
			$this->moduleAccessId= array();
		}
		for ($i = 0; $i < $this->getTotal(); $i++) {
			$this->setModuleAccessId($this->strict($_GET['moduleAccessId'][$i], 'numeric'),$i,'array');
			if ($_GET['moduleAccessValue'][$i] == 'true') {
				$this->setModuleAccessValue(1,$i,'array');
			} else {
				$this->setModuleAccessValue(0, $i,'array');
			}
			$primaryKeyAll .= $this->getModuleAccessId($i, 'array') . ",";
		}
		$this->setPrimaryKeyAll((substr($primaryKeyAll, 0, -1)));
	}
	/* (non-PHPdoc)
	 * @see tab::create()
	 */
	function create()
	{
	}
	/* (non-PHPdoc)
	 * @see tab::update()
	 */
	function update()
	{
	}
	/* (non-PHPdoc)
	 * @see tab::delete()
	 */
	function delete()
	{
	}

	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function draft()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(1,0,'string');
		$this->setIsDraft(1,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(0,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(0,0,'string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function approved()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(1,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(0,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(1,0,'string');
	}
	/**
	 * Set Module Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setModuleAccessId($value,$key,$type) {
		if($type=='single'){
			$this->moduleAccessId = $value;
		} else if ($type=='array'){
			$this->moduleAccessId[$key]=$value;
		}
	}

	/**
	 * Return Module Access Identification
	 * @param array[int][int] $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getModuleAccessId($key,$type) {
		if($type=='single'){
			return $this->moduleAccessId;
		} else if ($type=='array'){
			return $this->moduleAccessId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Module Identification Value
	 * @param  int $value
	 */
	public function setModuleId($value) {
		$this->moduleId = $value;
	}
	/**
	 * Return Module Identiification Value
	 * @return int
	 */
	public function getModuleId() {

		return $this->moduleId;
	}

	/**
	 * Set Group Identification Value
	 * @param  int $value
	 */
	public function setGroupId($value) {
		$this->groupId = $value;
	}
	/**
	 * Return Group Identification Value
	 * @return int
	 */
	public function getGroupId() {

		return $this->groupId;
	}


	/**
	 * Set Module Access Value
	  * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'	
	 */
	public function setModuleAccessValue($value,$key,$type) {
		if($type=='string'){

		} else if ($type=='array'){
			$this->moduleAccessValue[$key] = $value;
		}
	}


	/**
	 * Return Module Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getModuleAccessValue($key,$type) {
		if($type=='string'){

		} else if ($type=='array'){
			return $this->moduleAccessValue[$key];
		}
	}




}
?>