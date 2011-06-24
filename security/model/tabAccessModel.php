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
class tabAccessModel extends validationClass
{

	private $tabAccessId;
	private $tabId;
	private $groupId;
	private $tabAccessValue;

	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute()
	{
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('tabAccess');
		$this->setPrimaryKeyName('tabAccessId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_GET['tabAccessId'])) {
			$this->setTotal(count($_GET['tabAccessId']));
		}
		if(isset($_GET['groupId'])){
			$this->setGroupId($_GET['groupId']);
		}
		for ($i = 0; $i < $this->getTotal(); $i++) {
			$this->setTabAccessId($this->strict($_GET['tabAccessId'][$i], 'numeric'),$i,'array');
			if ($_GET['tabAccessValue'][$i] == 'true') {
				$this->setTabAccessValue(1,$i);
			} else {
				$this->setTabAccessValue(0, $i);
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
		if($type=='string'){
			$this->tabAccessId = $value;
		} else if ($type=='array'){
			$this->tabAccessId[$key]=$value;
		}
	}
	/**
	 * Return istabId Value
	 * @return integer tabId
	 */
	public function getTabAccessId($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->tabAccessId;
		} else if ($type=='array'){
			return $this->tabAccessId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Tab/Module/Accordion Identification Value
	 * @param  numeric $value
	 */
	public function setTabId($value) {
		$this->iconId = $value;
	}
	/**
	 * Return Tab/Module/Accordion Identiification Value
	 * @return numeric tab identification
	 */
	public function getTabId() {

		return $this->tabId;
	}
	/**
	 * Set Tab/Module/Accordion Identification Value
	 * @param  numeric $value
	 */
	public function setTabId($value) {
		$this->iconId = $value;
	}
	/**
	 * Return Tab/Module/Accordion Identiification Value
	 * @return numeric tab identification
	 */
	public function getTabId() {

		return $this->tabId;
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
	public function setTabAccessValue($value,$key) {
		$this->tabAccessValue[$key] = $value;
	}
	/**
	 * Return Tab Access Value
	 * @return numeric tab identification
	 */
	public function getTabAccessValue($value,$key) {

		return $this->tabAccessValue[$key]=$value;
	}




}
?>