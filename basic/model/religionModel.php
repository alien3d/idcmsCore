<?php
require_once("../../class/classValidation.php");
/**
 * this is religion model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package religion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class religionModel extends validationClass
{
	// table property
	private $tableName;
	private $primaryKeyName;

	// table field
	private $religionId;
	private $religionDesc;
	private $isDefaut;
	private $isNew;
	private $isDraft;
	private $isUpdate;
	private $isActive;
	private $isDelete;
	private $isApproved;
	private $By;
	private $Time;
	private $staffId;

	// database vendor
	public  $vendor;


	// table property
	const tableName = 'religion';
	const primaryKeyName = 'religionId';

	// table field
	const religionId = 'religionId';
	const religionDesc = 'religionDesc';
	const isDefaut = 'isDefault';
	const isNew = 'isNew';
	const isDraft = 'isDraft';
	const isUpdate = 'isUpdate';
	const isActive = 'isActive';
	const isDelete = 'isDelete';
	const isApproved = 'isApproved';
	const By = 'By';
	const Time = 'Time';
	const staffId = 'staffId';
	/* (non-PHPdoc)
	 * @see validationClass::execute()
	 */
	public function execute()
	{
		/*
		 *  Basic Information Table
		 */
		$this->tableName      = 'religion';
		$this->primaryKeyName = 'religionId';
		/*
		 * SET ALL OUTSIDE VARIABLE FROM POST OR GET OR PUT OR DELETE
		 * Restfull Format  POST 			-->Is to View Data
		 *                  GET  			-->Is to Receive Data
		 *                  PUT  			-->Is To Update Data
		 *                  DELETE/Destroy  -->Is To Delete/Destroy Data
		 */
		if (isset($_POST['religionId'])) {
			$this->setReligionId = $this->strict($_POST['religionId'], 'numeric');
		}
		if (isset($_POST['religionDesc'])) {
			$this->setReligionDesc = $this->strict($_POST['religionDesc'], 'memo');
		}
		/**
		 *      Don't change below code
		 **/
		if (isset($_SESSION['staffId'])) {
			$this->setBy = $_SESSION['staffId'];
		}
		if ($this->vendor == 'normal' || $this->vendor == 'mysql') {
			$this->setTime = "\"". date("Y-m-d H:i:s") . "\"";
		} else if ($this->vendor == 'microsoft') {
			$this->setTime = "\"". date("Y-m-d H:i:s") . "\"";
		} else if ($this->vendor == 'oracle') {
			$this->setTime = "to_date(\"". date("Y-m-d H:i:s") . "\",'YYYY-MM-DD HH24:MI:SS')";
		}
		// updateStatus
		$this->totalreligionId	=	count($_GET['folderAccessId']);
		$accessArray = array("isDefault","isNew","isDraft","isUpdate","isDelete","isActive","isApproved");

		for($i=0;$i<$this->totalreligionId;$i++) {
			$this->religionId[$i]  = $this->strict($_GET['religionId'][$i],'numeric');
			if($_GET['isDefault'][$i]=='true') {
				$this->isDefaut = array();
				$this->setIsDefault(1,$i,'array');
			} else {
				$this->setIsDefault(0,$i,'array');
			}

			if($_GET['isNew'][$i]=='true') {
				$this->isNew = array();
				$this->setIsNew(1,$i,'array');
			} else {
				$this->setIsNew(0,$i,'array');
			}

			if($_GET['isDraft'][$i]=='true') {
				$this->isDraft = array();
				$this->setIsDraft(1,$i,'array');
			} else {
				$this->setIsDraft(0,$i,'array');
			}

			if($_GET['isUpdate'][$i]=='true') {
				$this->isUpdate = array();
				$this->setIsUpdate(1,$i,'array');
			} else {
				$this->setIsUpdate(0,$i,'array');
			}

			if($_GET['isDelete'][$i]=='true') {
				$this->isDelete = array();
				$this->setIsDelete(1,$i,'array');
			} else {
				$this->setIsDelete(0,$i,'array');
			}

			if($_GET['isActive'][$i]=='true') {
				$this->isActive = array();
				$this->setIsActive(1,$i,'array');
			} else {
				$this->setIsActive(0,$i,'array');
			}
			if($_GET['isApproved'][$i]=='true') {
				$this->isApproved = array();
				$this->setIsApproved(1,$i,'array');
			} else {
				$this->setIsApporved(0,$i,'array');
			}
			$this->religionIdAll.= $this->religionId[$i].",";
		}
		$this->religionIdAll = substr($this->religionIdAll,0,-1);
	}
	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	public function create()
	{
		$this->setIsDefaut(0,'','string');
		$this->setIsNew(1,'','string');
		$this->setIsDraft(0,'','string');
		$this->setIsUpdate(0,'','string');
		$this->setIsActive(1,'','string');
		$this->setIsDelete(0,'','string');
		$this->setIsApproved(0,'','string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	public function update()
	{
		$this->setIsDefaut(0,'','string');
		$this->setIsNew(0,'','string');
		$this->setIsDraft(0,'','string');
		$this->setIsUpdate(1,'','string');
		$this->setIsActive(1,'','string');
		$this->setIsDelete(0,'','string');
		$this->setIsApproved(0,'','string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	public function delete()
	{
		$this->setIsDefault(0,'','string');
		$this->setIsNew(0,'','string');
		$this->setIsDraft(0,'','string');
		$this->setIsUpdate(0,'','string');
		$this->setIsActive(0,'','string');
		$this->setIsDelete(1,'','string');
		$this->setIsApproved(0,'','string');
	}
	public function updateStatus() {

	}
	// generate basic information from outside
	/**
	 * Set isDefault Value
	 * @param integer $value
	 */
	public function setReligionId($value) {
		$this->religionId = $value;
	}
	/**
	 * Return isReligionId Value
	 * @return integer religionId
	 */
	public function getReligionId() {
		return $this->religionId;
	}
	/**
	 * Set isDefault Value
	 * @param boolean $value
	 */
	public function setReligionDesc($value) {
		$this->religionDesc = $value;
	}
	/**
	 * Return Religion Description
	 * @return string religion description
	 */
	public function getReligionDesc() {
		return $this->religionDesc;
	}
	/**
	 * Set isDefault Value
	 * @param boolean $value
	 * @params numeric $key  Array as value
	 * @params enum   $type   1->string,2->array
	 */
	public function setIsDefault($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isDefault = $value;
		} else {
			$this->isDefaut[$key]=$value;
		}
	}
	/**
	 * Return isDefault Value
	 * @return boolean isDefault
	 */
	public function getIsDefault() {
		return $this->isDefault;
	}

	/**
	 * Set isNew value
	 * @param boolean $value
	 * @params numeric $key  Array as value
	 * @params enum   $type   1->string,2->array
	 */
	public function setIsNew($value,$key=NULL,$type=NULL) {
		$this->isNew = $value;
	}
	/**
	 * Return isNew value
	 * @return boolean isNew
	 */
	public function getIsNew() {
		return $this->isNew;
	}

	/**
	 * Set IsDraft Value

	 * @param boolean $value
	 */
	public function setIsDraft($value,$key=NULL,$type=NULL) {
		$this->isDraft = $value;
	}
	/**
	 * Return isDraftValue
	 * @return boolean isDraft
	 */
	public function getIsDraft() {
		return $this->isDraft;
	}

	/**
	 * Set isUpdate Value
	 * @param boolean $value
	 * @params numeric $key  Array as value
	 * @params enum   $type   1->string,2->array
	 */
	public function setIsUpdate($value,$key=NULL,$type=NULL) {
		$this->isUpdate = $value;
	}
	/**
	 * Return isUpdate Value
	 * @return boolean isUpdate
	 */
	public function getIsUpdate() {
		return $this->isUpdate;
	}

	/**
	 * Set isActive Value
	 * @param boolean $value
	 * @params numeric $key  Array as value
	 * @params enum   $type   1->string,2->array
	 */
	public function setIsActive($value,$key=NULL,$type=NULL) {
		$this->isActive = $value;
	}
	/**
	 * Return isActive value
	 * @return boolean isActive
	 */
	public function getIsActive() {
		return $this->isActive;
	}

	/**
	 * Set isDelete Value
	 * @param boolean $value
	 * @params numeric $key  Array as value
	 * @params enum   $type   1->string,2->array
	 */
	public function setIsDelete($value,$key=NULL,$type=NULL) {
		$this->isDelete = $value;
	}
	/**
	 * Return isDelete Value
	 * @return boolean isDelete
	 */
	public function getIsDelete() {
		return $this->isDelete;
	}

	/**
	 * Set isApproved Value
	 * @param boolean $value
	 * @params numeric $key  Array as value
	 * @params enum   $type   1->string,2->array
	 */
	public function setIsApproved($value,$key=NULL,$type=NULL) {
		$this->isApproved = $value;
	}
	/**
	 * Return isApproved Value
	 * @return boolean isApproved
	 */
	public function getIsApproved() {
		return $this->isApproved;
	}

	/**
	 * Set Activity User
	 * @param integet $value
	 * @params numeric $key  Array as value
	 * @params enum   $type   1->string,2->array
	 */
	public function setIsBy($value) {
		$this->isBy = $value;
	}
	/**
	 * Get Activity User
	 * @return integer User
	 */
	public function getIsBy() {
		return $this->isBy;
	}

	/**
	 * Set Time Activity User
	 * @param date $value
	 */
	public function setIsTime($value) {
		$this->isTime = $value;
	}
	/**
	 *  Return Time Activity User
	 *  @return date Time Activity User
	 */
	public function getIsTime() {
		return $this->isTime;
	}

}
?>