<?php require_once("../../class/classValidation.php");

/**
 * this is department model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package religion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class departmentModel extends validationClass{

	// table field
	private $departmentId;
	private $departmentSequence;
	private $departmentCode;
	private $departmentNote;


	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('department');
		$this->setPrimaryKeyName('departmentId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['departmentId'])){
			$this->setDepartmentId($this->strict($_POST['departmentId'],'numeric'),'','string');
		}
		if(isset($_POST['departmentSequence'])){
			$this->setDepartmentSequence($this->strict($_POST['departmentSequence'],'memo'));
		}
		if(isset($_POST['departmentCode'])){
			$this->setDepartmentCode($this->strict($_POST['departmentCode'],'memo'));
		}
		if(isset($_POST['departmentNote'])){
			$this->setDepartmentNote($this->strict($_POST['departmentNote'],'memo'));
		}
		if(isset($_SESSION['staffId'])){
			$this->setBy($_SESSION['staffId']);
		}
		if($this->getVendor()==self::mysql){
			$this->setTime("'".date("Y-m-d H:i:s")."'");
		} else if ($this->getVendor()==self::mssql){
			$this->setTime("'".date("Y-m-d H:i:s")."'");
		} else if ($this->getVendor()==self::oracle){
			$this->setTime("to_date('".date("Y-m-d H:i:s")."','YYYY-MM-DD HH24:MI:SS')");
		}


	}
	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	public function create()
	{
		$this->setIsDefault(0,'','string');
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
		$this->setIsDefault(0,'','string');
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


	/**
	 * Update Religion Table Status
	 */
	public function updateStatus() {
		if(!(is_array($_GET['isDefault']))) {
			$this->setIsDefault(0,'','string');
		}
		if(!(is_array($_GET['isNew']))) {
			$this->setIsNew(0,'','string');
		}
		if(!(is_array($_GET['isDraft']))) {
			$this->setIsDraft(0,'','string');
		}
		if(!(is_array($_GET['isUpdate']))) {
			$this->setIsUpdate(0,'','string');
		}
		if(!(is_array($_GET['isDelete']))) {

			$this->setIsDelete(1,'','string');
		}
		if(!(is_array($_GET['isActive']))) {
			$this->setIsActive(0,'','string');
		}

		if(!(is_array($_GET['isApproved']))) {
			$this->setIsApproved(0,'','string');
		}
	}
	/**
	 * Set department Identification  Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setDepartmentId($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->departmentId = $value;
		} else if ($type=='array'){
			$this->departmentId[$key]=$value;
		}
	}
	/**
	 * Return department Identification Value
	 * @return integer departmentId
	 */
	public function getDepartmentId($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->departmentId;
		} else if ($type=='array'){
			return $this->departmentId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set  department Sequence (english)
	 * @param boolean $value
	 */
	public function setDepartmentSequence($value) {
		$this->departmentSequence = $value;
	}
	/**
	 * Return department  Description (english)
	 * @return  string department Sequence
	 */
	public function getDepartmentSequence() {
		return $this->departmentSequence;
	}
	/**
	 * Set  department  Code (english)
	 * @param string $value
	 */
	public function setDepartmentCode($value) {
		$this->departmentCode = $value;
	}
	/**
	 * Return department  Code
	 * @return  string department Description
	 */
	public function getDepartmentCode() {
		return $this->departmentCode;
	}
	/**
	 * Set  department Translation (english)
	 * @param string $value
	 */
	public function setDepartmentNote($value) {
		$this->departmentNote = $value;
	}
	/**
	 * Return department  Description (english)
	 * @return  string department Description
	 */
	public function getdepartmentNote() {
		return $this->departmentNote;
	}

	function excel() {

	}


}
?>