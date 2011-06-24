<?php require_once("../../class/classValidation.php");

/**
 * this is document model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Document
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class staffWebAcessModel extends validationClass{


	private $staffWebAccessId;
	private $staffId;
	private $staffWebAccessLogIn;
	private $staffWebAccessLogOut;

	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName 		('staffWebAcess');
		$this->setPrimaryKeyName 	('staffWebAcessId');

		if($this->getVendor()==self::mysql){
			$this->setStaffWebAccessLogIn("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::mssql){
			$this->setStaffWebAccessLogIn("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::oracle){
			$this->setStaffWebAccessLogIn("to_date(\"".date("Y-m-d H:i:s")."\",'YYYY-MM-DD HH24:MI:SS')");
		} else{
			echo "udentified vendor ?";
		}
		if($this->getVendor()==self::mysql){
			$this->setStaffWebAccessLogin("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::mssql){
			$this->setStaffWebAccessLogOut("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::oracle){
			$this->setStaffWebAccessLogOut("to_date(\"".date("Y-m-d H:i:s")."\",'YYYY-MM-DD HH24:MI:SS')");
		} else{
			echo "udentified vendor ?";
		}


	}
	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	public function create()
	{

	}
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	public function update()
	{

	}
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	public function delete()
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
	/**
	 * Set Staff Web Access Identification Value
	 * @param numeric $value
	 */
	public function setStaffWebAccessId($value) {
		$this->staffWebAccessId = $value;
	}
	/**
	 * Return Staff Web Access Identification Value
	 * @return numeric Staff Web Access Value
	 */
	public function getStaffWebAccessId() {
		return $this->staffWebAccessId;
	}
	/**
	 * Set Staff Web Access Login Value
	 * @param datetime $value
	 */
	public function setStaffWebAccessLogIn($value) {
		$this->staffWebAccessLogIn = $value;
	}
	/**
	 * Return Staff Web Access Login Value
	 * @return numeric Document Cateogory Identification Value
	 */
	public function getStaffWebAccessLogIn() {
		return $this->staffWebAccessLogIn;
	}
	/**
	 * Set Staff Web Access LogOut Value
	 * @param datetime $value
	 */
	public function setStaffWebAccessLogOut($value) {
		$this->staffWebAccessLogOut = $value;
	}
	/**
	 * Return Staff Web Access LogOut Value
	 * @return datetime Staff Web Access LogOut
	 */
	public function getStaffWebAccessLogOut() {
		return $this->staffWebAccessLogOut;
	}

}
?>
