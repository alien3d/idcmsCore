<?php require_once("../../class/classValidation.php");

/**
 * this is tab model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package tab
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class tabModel extends validationClass{

	// table property
	private $tableName;
	private $primaryKeyName;

	// table field
	private $iconId;
	private $tabId;
	private $tabSequence;
	private $tabNote;
	private $isDefault;
	private $isNew;
	private $isDraft;
	private $isUpdate;
	private $isActive;
	private $isDelete;
	private $isApproved;
	private $By;
	private $Time;
	private $staffId;
	private $tabIdAll; // this is not table field but collection of tabId
	/**
	 * Total Record receive from checkbox grid
	 * @var numeric
	 */
	private $total;
	// database vendor
	public  $vendor;


	// table property
	const tableName = 'tab';
	const primaryKeyName = 'tabId';

	// table field
	const tabId = 'tabId';
	const tabSequence = 'tabSequence';
	const tabNote = 'tabNote';
	const isDefault = 'isDefault';
	const isNew = 'isNew';
	const isDraft = 'isDraft';
	const isUpdate = 'isUpdate';
	const isActive = 'isActive';
	const isDelete = 'isDelete';
	const isApproved = 'isApproved';
	const By = 'By';
	const Time = 'Time';
	const staffId = 'staffId';

	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->tableName 		=	'tab';
		$this->primaryKeyName 	=	'tabId';
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['iconId'])){
			$this->iconId = $this->strict($_POST['iconId'],'numeric');
		}
		if(isset($_POST['tabId'])){
			$this->tabId = $this->strict($_POST['tabId'],'numeric');
		}
		if(isset($_POST['tabSequence'])){
			$this->tabSequence = $this->strict($_POST['tabSequence'],'numeric');
		}
		if(isset($_POST['tabNote'])){
			$this->tabNote = $this->strict($_POST['tabNote'],'memo');
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
	/**
	 * Update tab Table Status
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
	public function setTableName($value) {
		$this->tableName = $value;

	}
	public function getTableName() {
		return $this->tableName;
	}
	public function setPrimaryKeyName($value) {
		$this->primaryKeyName = $value;

	}
	public function getPrimaryKeyName() {
		return $this->primaryKeyName;
	}
	// generate basic information from outside
	/**
	 * Set isDefault Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function settabId($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->tabId = $value;
		} else if ($type=='array'){
			$this->tabId[$key]=$value;
		}
	}
	/**
	 * Return istabId Value
	 * @return integer tabId
	 */
	public function gettabId($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->tabId;
		} else if ($type=='array'){
			return $this->tabId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
/**
	 * Set icon for Tab
	 * @param  numeric $value
	 */
	public function setIconId($value) {
		$this->iconId = $value;
	}
	/**
	 * Return icon for Tab
	 * @return numeric icon for tab
	 */
	public function getIconId() {

		return $this->iconId;
	}
/**
	 * Set Tab Sequence Value
	 * @param numeric $value
	 */
	public function settabSequence($value) {
		$this->tabSequence = $value;
	}
	/**
	 * Return tab Sequence Value
	 * @return string tab sequence
	 */
	public function gettabSequence() {
		return $this->tabSequence;
	}
	/**
	 * Set Tab Note Value
	 * @param string $value Tab Note
	 */
	public function setTabNote($value) {
		$this->tabNote = $value;
	}
	/**
	 * Return Tab Note
	 * @return string Tab Note
	 */
	public function getTabNote() {
		return $this->tabNote;
	}
	/**
	 * Set isDefault Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
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
	 * Set All tab Identification Array To Sql Statement
	 * @param string $value
	 */
	public function settabIdAll($value){
		$this->tabIdAll= $value;
	}
	/**
	 * Return tab Identification Array
	 * @return string $tabIdAll
	 */
	public function gettabIdAll() {
		return $this->tabIdAll;
	}
	public function setTotal($value){
		$this->total = $value;
	}
	public function getTotal(){
		return $this->total;
	}

}
?>