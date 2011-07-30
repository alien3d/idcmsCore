<?php
require_once("../../class/classValidation.php");
/**
 * this is tab security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package tab
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
		 *  All the $_POST enviroment.
		 */
		if(isset($_GET['moduleAccessId'])) {
			$this->setTotal(count($_GET['moduleAccessId']));
		}
		if(isset($_GET['groupId'])){
			$this->setGroupId($_GET['groupId']);
		}
		for ($i = 0; $i < $this->getTotal(); $i++) {
			$this->setModuleAccessId($this->strict($_GET['moduleAccessId'][$i], 'numeric'),$i,'array');
			if ($_GET['moduleAccessValue'][$i] == 'true') {
				$this->setModuleAccessValue(1,$i);
			} else {
				$this->setModuleAccessValue(0, $i);
			}
		}
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
		$this->setIsDefault(0,'','string');
		$this->setIsNew(1,'','string');
		$this->setIsDraft(1,'','string');
		$this->setIsUpdate(0,'','string');
		$this->setIsActive(0,'','string');
		$this->setIsDelete(0,'','string');
		$this->setIsApproved(0,'','string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function approved()
	{
		$this->setIsDefault(0,'','string');
		$this->setIsNew(1,'','string');
		$this->setIsDraft(0,'','string');
		$this->setIsUpdate(0,'','string');
		$this->setIsActive(0,'','string');
		$this->setIsDelete(0,'','string');
		$this->setIsApproved(1,'','string');
	}
	public function setTabAccessId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
			$this->tabAccessId = $value;
		} else if ($type=='array'){
			$this->tabAccessId[$key]=$value;
		}
	}
	/**
	 * Return Module Value
	 * @return integer moduleId
	 */
	public function getModuleAccessId($key=NULL,$type=NULL) {
		if($type=='single'){
			return $this->tabAccessId;
		} else if ($type=='array'){
			return $this->tabAccessId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Tab/Module Identification Value
	 * @param  numeric $value
	 */
	public function setModuleId($value) {
		$this->moduleId = $value;
	}
	/**
	 * Return Module Identiification Value
	 * @return numeric module identification
	 */
	public function getModuleId() {

		return $this->moduleId;
	}

	/**
	 * Set Tab/Module/Accordion Identification Value
	 * @param  numeric $value
	 */
	public function setGroupId($value) {
		$this->groupId = $value;
	}
	/**
	 * Return Tab/Module/Accordion Identiification Value
	 * @return numeric tab identification
	 */
	public function getGroupId() {

		return $this->groupId;
	}
/**
	 * Set Tab Access  Value
	 * @param  numeric $value
	 */
	public function setModuleAccessValue($value,$key) {
		$this->moduleAccessValue[$key] = $value;
	}
	/**
	 * Return Module Access Value
	 * @return numeric module identification
	 */
	public function getModuleAccessValue($value,$key) {

		return $this->moduleAccessValue[$key]=$value;
	}




}
?>