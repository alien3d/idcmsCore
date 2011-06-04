<?php require_once("../../class/classValidation.php");

/**
 * this is calendar model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package religion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */ 
class calendarModel extends validationClass{
	public $calendarId;
	public $isDefaut;
	public $isNew;
	public $isDraft;
	public $isUpdate;
	public $isActive;
	public $isDelete;
	public $isApproved;
	public $By;
	public $Time;
	public $vendor;
	public $staffId;
	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->tableName 		=	'calendar';
		$this->primaryKeyName 	=	'calendarId';
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['religionId'])){
			$this->religionId = $this->strict($_POST['religionId'],'numeric');
		}
		if(isset($_POST['religionDesc'])){
			$this->religionDesc = $this->strict($_POST['religionDesc'],'memo');
		}
		if(isset($_SESSION['staffId'])){
			$this->By = $_SESSION['staffId'];
		}
		if($this->vendor=='normal' || $this->vendor=='mysql'){
			$this->Time = "'".date("Y-m-d H:i:s")."'";
		} else if ($this->vendor=='microsoft'){
			$this->Time = "'".date("Y-m-d H:i:s")."'";
		} else if ($this->vendor=='oracle'){
			$this->Time = "to_date('".date("Y-m-d H:i:s")."','YYYY-MM-DD HH24:MI:SS')";
		}


	}
	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	public function create()
	{
		$this->setIsDefaut(0);
		$this->setIsNew(1);
		$this->setIsDraft(0);
		$this->setIsUpdate(0);
		$this->setIsActive(1);
		$this->setIsDelete(0);
		$this->setIsApproved(0);
	}
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	public function update()
	{
		$this->setIsDefaut(0);
		$this->setIsNew(0);
		$this->setIsDraft(0);
		$this->setIsUpdate(1);
		$this->setIsActive(1);
		$this->setIsDelete(0);
		$this->setIsApproved(0);
	}
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	public function delete()
	{
		$this->setIsDefault(0);
		$this->setIsNew(0);
		$this->setIsDraft(0);
		$this->setIsUpdate(0);
		$this->setIsActive(0);
		$this->setIsDelete(1);
		$this->setIsApproved(0);
	}
	/**
	 * Set isDefault Value
	 * @param boolean $value
	 */
	public function setIsDefault($value) {
		$this->isDefault = $value;
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
	 */
	public function setIsNew($value) {
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
	public function setIsDraft($value) {
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
	 */
	public function setIsUpdate($value) {
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
	 */
	public function setIsActive($value) {
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
	 */
	public function setIsDelete($value) {
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
	 */
	public function setIsApproved($value) {
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
