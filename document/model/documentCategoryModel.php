<?php require_once("../../class/classValidation.php");

/**
 * this is document category model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Document Category
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class documentCategoryModel extends validationClass{
	// table property
	private $tableName;
	private $primaryKeyName;

	//table field
	public $documentCategoryId;
	public $documentCategoryTitle;
	public $documentCategoryDesc;

	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->settableName('documentCategory');
		$this->setPrimaryKeyName('documentCategoryId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['documentCategoryId'])){
			$this->setDocumentCategory ($this->strict($_POST['documentCategoryId'],'numeric'));
		}
		if(isset($_POST['documentCategoryTitle'])){
			$this->setDocumentCategoryTitle($this->strict($_POST['documentCategoryTitle'],'memo'));
		}
		if(isset($_POST['documentCategoryDesc'])){
			$this->setDocumentCategoryDesc($this->strict($_POST['documentCategoryDesc'],'memo'));
		}
		if(isset($_SESSION['staffId'])){
			$this->setBy($_SESSION['staffId']);
		}
		if($this->getVendor()==self::mysql){
			$this->setTime = ("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::microsoft){
			$this->setTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::oracle){
			$this->setTime("to_date(\"".date("Y-m-d H:i:s")."\",'YYYY-MM-DD HH24:MI:SS')");
		}


	}
	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	public function create()
	{
		$this->setIsDefault(0);
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
		$this->setIsDefault(0);
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
	 * Set  Document Category Identification Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setDocumentCategoryId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
			$this->documentId = $value;
		} else if ($type=='array'){
			$this->documentId[$key]=$value;
		}
	}
	/**
	 * Return Document Category Identification Value
	 * @return integer documentId
	 */
	public function getDocumentCategoryId($key=NULL,$type=NULL) {
		if($type=='single'){
			return $this->documentId;
		} else if ($type=='array'){
			return $this->documentId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Document Category  Title  Value
	 * @param string $value
	 */
	public function setDocumentCategoryTitle() {

		$this->documentCategoryTitle = $value;

	}
	/**
	 * Return Document Category Desc Value
	 * @return string $groupId
	 */
	public function getDocumentCategoryTitle() {

		return $this->documentCategoryTitle;

	}
	/**
	 * Set Document Category  Description Value
	 * @param string $value
	 */
	public function setDocumentCategoryDesc() {

		$this->documentCategoryDesc = $value;

	}
	/**
	 * Return Document Category Description Value
	 * @return string $groupId
	 */
	public function getDocumentCategoryDesc() {

		return $this->documentCategoryDesc;

	}
	/**
	 * Set isDefault Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsDefault($value,$key=NULL,$type=NULL) {
		if($type=='single'){

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
		if($type=='single'){
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
		if($type=='single'){
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
		if($type=='single'){
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
		if($type=='single'){
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
		if($type=='single'){
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
		if($type=='single'){
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
		if($type=='single'){
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
		if($type=='single'){
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
		if($type=='single'){

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
		if($type=='single'){
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
		if($type=='single'){
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
		if($type=='single'){
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
		if($type=='single'){
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
	public function settTabIdAll($value){
		$this->tabIdAll= $value;
	}
	/**
	 * Return tab Identification Array
	 * @return string $tabIdAll
	 */
	public function gettTabIdAll() {
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
