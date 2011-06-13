<?php require_once("../../class/classValidation.php");

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
class groupModel extends validationClass{

	// table property
	private $tableName;
	private $primaryKeyName;

	// table field
	private $groupId;
	private $groupDesc;
	private $isDefault;
	private $isNew;
	private $isDraft;
	private $isUpdate;
	private $isActive;
	private $isDelete;
	private $isApproved;
	private $By;
	private $Time;
	private $vendor;
	private $staffId;

	private $staffIdAll; // this is not table field but collection of staffId
	/**
	 * Total Record receive from checkbox grid
	 * @var numeric
	 */
	private $total;
	// database vendor
	public  $vendor;

	// table property
	const	tableName = 'staff';
	const 	primaryKeyName = 'staffId';

	// table field
	const 	staffId='staffId';
	const   groupId='groupId';
	const   departmentId='departmentId';
	const   languageId='languageId';
	const   staffPassword='staffPassword';
	const   staffName='staffName';
	const   staffNo='staffNo';
	const  	staffIc='staffIc';
	const 	isDefault = 'isDefault';
	const 	isNew = 'isNew';
	const 	isDraft = 'isDraft';
	const 	isUpdate = 'isUpdate';
	const 	isActive = 'isActive';
	const 	isDelete = 'isDelete';
	const 	isApproved = 'isApproved';
	const 	By = 'By';
	const 	Time = 'Time';

	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->tableName 		=	'group';
		$this->primaryKeyName 	=	'groupId';
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['groupId'])){
			$this->groupId = $this->strict($_POST['groupId'],'numeric');
		}
		if(isset($_POST['groupDesc'])){
			$this->groupDesc = $this->strict($_POST['groupDesc'],'memo');
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
	/* (non-PHPdoc)
	 * @see configClass::excel()
	 */
	function excel() {

	}

	public function setIsDefault($value,$key=NULL,$type=NULL) {
		if($type=='string'){

			$this->isDefault = $value;
		} else if ($type=='array') {

			$this->isDefault[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isDefault Value
	 * @param numeric $key  Array as value
	 *  @param enum   $type   1->string,2->array
	 * @return boolean isDefault
	 */
	public function getIsDefault($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isDefault;
		} else if ($type=='array'){

			return $this->isDefault[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}

	/**
	 * Set isNew value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsNew($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isNew = $value;
		} else if ($type=='array'){
			$this->isNew[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isNew value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isNew
	 */
	public function getIsNew($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isNew;
		} else if ($type=='array'){
			return $this->isNew[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}

	/**
	 * Set IsDraft Value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @param boolean $value
	 */
	public function setIsDraft($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isDraft = $value;
		} elseif ($type=='array'){
			$this->isDraft[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isDraftValue
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isDraft
	 */
	public function getIsDraft($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isDraft;
		} else if ($type=='array'){
			return $this->isDraft[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}

	/**
	 * Set isUpdate Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsUpdate($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isUpdate = $value;
		} elseif ($type=='array'){
			$this->isUpdate[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isUpdate Value
	 * @return boolean isUpdate
	 */
	public function getIsUpdate($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isUpdate;
		} else if ($type=='array'){
			return $this->isUpdate[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set isDelete Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsDelete($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isDelete = $value;
		} elseif ($type=='array'){

			$this->isDelete[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}

	}
	/**
	 * Return isDelete Value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isDelete
	 */
	public function getIsDelete($key=NULL,$type=NULL) {
		if($type=='string'){

			return $this->isDelete;
		} else if ($type=='array'){

			return $this->isDelete[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set isActive Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsActive($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isActive = $value;
		} elseif ($type=='array'){
			$this->isActive[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}

	}
	/**
	 * Return isActive value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isActive
	 */
	public function getIsActive($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isActive;
		} else if ($type=='array'){
			return $this->isActive[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}



	/**
	 * Set isApproved Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsApproved($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isApproved = $value;
		} elseif ($type=='array'){
			$this->isApproved[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isApproved Value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isApproved
	 */
	public function getIsApproved($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isApproved;
		} else if ($type=='array'){
			return $this->isApproved[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}

	/**
	 * Set Activity User
	 * @param integer $value
	 */
	public function setBy($value) {
		$this->isBy = $value;
	}
	/**
	 * Get Activity User
	 * @return integer User
	 */
	public function getBy() {
		return $this->isBy;
	}

	/**
	 * Set Time Activity User
	 * @param date $value
	 */
	public function setTime($value) {
		$this->isTime = $value;
	}
	/**
	 *  Return Time Activity User
	 *  @return date Time Activity User
	 */
	public function getTime() {
		return $this->isTime;
	}

	/**
	 * Set All Group Identification Array To Sql Statement
	 * @param string $value
	 */
	public function setReligionIdAll($value){
		$this->religionIdAll= $value;
	}
	/**
	 * Return Group Identification Array
	 * @return string $departmentIdAll
	 */
	public function getReligionIdAll() {
		return $this->religionIdAll;
	}
	public function setTotal($value){
		$this->total = $value;
	}
	public function getTotal(){
		return $this->total;
	}
}
?>