<?php require_once("../../class/classValidation.php");

/**
 * this is leaf security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package leaf
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafGroupAccessModel extends validationClass{

	private $leafGrooupAccessId;
	private $leafId;
	private $groupId;
	private $leafCreateAccessValue;
	private $leafReadAccessValue;
	private $leafUpdateAccessValue;
	private $leafDeleteAccessValue;
	private $leafPrintAccessValue;
	private $leafPostAccessValue;
	private $leafDraftAccessValue;

	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('leafGroupAccess');
		$this->setPrimaryKeyName('leafGroupAccessId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_GET['leafGroupAccessId'])){
			$this->setTotal(count($_GET['leafGroupAccessId']));
		}
		if(isset($_GET['groupId'])){
			$this->setGroupId($_GET['groupId']);
		}

		for($i=0;$i<$this->getTotal();$i++) {
			$this->leafAccessId[$i]  = $this->strict($_GET['leafGroupAccessId'][$i],'numeric');



			if($_GET['leafCreateAccessValue'][$i]=='true') {
				$this->leafCreateAccessValue[$i] =1;
			} else {
				$this->leafCreateAccessValue[$i]=0;
			}

			if($_GET['leafReadAccessValue'][$i]=='true') {
				$this->leafReadAccessValue[$i] =1;
			} else {
				$this->leafReadccessValue[$i]=0;
			}

			if($_GET['leafUpdateAccessValue'][$i]=='true') {
				$this->leafUpdateAccessValue[$i] =1;
			} else {
				$this->leafUpdateAccessValue[$i]=0;
			}

			if($_GET['leafDeleteAccessValue'][$i]=='true') {
				$this->leafDeleteAccessValue[$i] =1;
			} else {
				$this->leafDeleteAccessValue[$i]=0;
			}

			if($_GET['leafPrintAccessValue'][$i]=='true') {
				$this->leafPrintAccessValue[$i] =1;
			} else {
				$this->leafPrintAccessValue[$i]=0;
			}

			if($_GET['leafPostAccessValue'][$i]=='true') {
				$this->leafPostAccessValue[$i] =1;
			} else {
				$this->leafPostAccessValue[$i]=0;
			}
			if($_GET['leafPostAccessValue'][$i]=='true') {
				$this->leafPostAccessValue[$i] =1;
			} else {
				$this->leafPostAccessValue[$i]=0;
			}

		}


	}

	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	function create() {
	}

	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	function update() {

	}

	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	function delete() {
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
	public function setLeafGroupAccessId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
			$this->leafGroupAccessId = $value;
		} else if ($type=='array'){
			$this->leafGroupAccessId[$key]=$value;
		}
	}
	/**
	 * Return istabId Value
	 * @return integer tabId
	 */
	public function getLeafGroupAccessId($key=NULL,$type=NULL) {
		if($type=='single'){
			return $this->leafGroupAccessId;
		} else if ($type=='array'){
			return $this->leafGroupAccessId[$key];
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
	public function setLeafCreateAccessValue($value,$key) {
		$this->leafCreateAccessValue[$key] = $value;
	}
	/**
	 * Return Tab Access Value
	 * @return numeric tab identification
	 */
	public function getleafCreateAccessValue($value,$key) {

		return $this->leafCreateAccessValue[$key]=$value;
	}

	/**
	 * Set Tab Access  Value
	 * @param  numeric $value
	 */
	public function setLeafReadAccessValue($value,$key) {
		$this->leafReadAccessValue[$key] = $value;
	}
	/**
	 * Return Tab Access Value
	 * @return numeric tab identification
	 */
	public function getLeafReadAccessValue($value,$key) {

		return $this->leafReadAccessValue[$key]=$value;
	}
	/**
	 * Set Tab Access  Value
	 * @param  numeric $value
	 */
	public function setLeafUpdateAccessValue($value,$key) {
		$this->leafUpdateAccessValue[$key] = $value;
	}
	/**
	 * Return Tab Access Value
	 * @return numeric tab identification
	 */
	public function getLeafUpdateAccessValue($value,$key) {

		return $this->leafUpdateAccessValue[$key]=$value;
	}
	/**
	 * Set Tab Access  Value
	 * @param  numeric $value
	 */
	public function setLeafUpdateAccessValue($value,$key) {
		$this->leafUpdateAccessValue[$key] = $value;
	}
	/**
	 * Return Tab Access Value
	 * @return numeric tab identification
	 */
	public function getLeafDeleteAccessValue($value,$key) {

		return $this->leafDeleteAccessValue[$key]=$value;
	}
	/**
	 * Set Tab Access  Value
	 * @param  numeric $value
	 */
	public function setLeafPrintAccessValue($value,$key) {
		$this->leafPrintAccessValue[$key] = $value;
	}
	/**
	 * Return Tab Access Value
	 * @return numeric tab identification
	 */
	public function getleafPrintAccessValue($value,$key) {

		return $this->leafPrintAccessValue[$key]=$value;
	}
	/**
	 * Set Tab Access  Value
	 * @param  numeric $value
	 */
	public function setLeafPostAccessValue($value,$key) {
		$this->leafPostAccessValue[$key] = $value;
	}
	/**
	 * Return Tab Access Value
	 * @return numeric tab identification
	 */
	public function getleafPostAccessValue($value,$key) {

		return $this->leafPostAccessValue[$key]=$value;
	}
	/**
	 * Set Tab Access  Value
	 * @param  numeric $value
	 */
	public function setLeafDraftAccessValue($value,$key) {
		$this->tabAccessValue[$key] = $value;
	}
	/**
	 * Return Tab Access Value
	 * @return numeric tab identification
	 */
	public function getLeafDraftAccessValue($value,$key) {

		return $this->leafDraftAccessValue[$key]=$value;
	}


}
?>