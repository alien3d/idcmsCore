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
class documentModel extends validationClass{
	
	// table property
	private $tableName;
	private $primaryKeyName;
	
	//table field
	private $documentId;
	private $documentCategoryId;
	private $leafId;
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
	private $religionIdAll; // this is not table field but collection of religionId
	/**
	 * Total Record receive from checkbox grid
	 * @var numeric
	 */
	private $total;
	// database vendor
	public  $vendor;


	// table property
	const tableName = 'document';
	const primaryKeyName = 'documentId';

	// table field
	const documentId = 'documentId';
	const documentCategoryId = 'documentCategoryId';
	const documentDesc = 'documentDesc';
	const leafId = 'leafId';
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
		$this->setTableName 		('document');
		$this->setPrimaryKeyName 	('documentId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['documentId'])){
			$this->setDocumentId = $this->strict($_POST['documentId'],'numeric');
		}
		if(isset($_POST['documentCategoryId'])){
			$this->setDocumentCategory = $this->strict($_POST['documentCategoryId'],'numeric');
		}
		if(isset($_POST['documentTitle'])){
			$this->setDocumentTitle = $this->strict($_POST['docuementTitle'],'memo');
		}
		if(isset($_POST['documentDesc'])){
			$this->setDocumentDesc = $this->strict($_POST['docuementDesc'],'memo');
		}

		if(isset($_POST['documentPath'])){
			$this->setDocumentPath = $this->strict($_POST['docuementPath'],'memo');
		}

		if(isset($_POST['documentFilename'])){
			$this->setdocumentFilename = $this->strict($_POST['docuementFilename'],'memo');
		}
		if(isset($_SESSION['staffId'])){
			$this->setBy = $_SESSION['staffId'];
		}
		if($this->vendor=='normal' || $this->vendor=='mysql'){
			$this->setTime = "'".date("Y-m-d H:i:s")."'";
		} else if ($this->vendor=='microsoft'){
			$this->setTime = "'".date("Y-m-d H:i:s")."'";
		} else if ($this->vendor=='oracle'){
			$this->setTime = "to_date('".date("Y-m-d H:i:s")."','YYYY-MM-DD HH24:MI:SS')";
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
	public function setDocumentId($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->documentId = $value;
		} else if ($type=='array'){
			$this->documentId[$key]=$value;
		}
	}
	/**
	 * Return isDocumentId Value
	 * @return integer documentId
	 */
	public function getDocumentId($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->documentId;
		} else if ($type=='array'){
			return $this->documentId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Document Title Value
	 * @param boolean $value
	 */
	public function setDocumentTitle($value) {
		$this->documentTitle = $value;
	}
	/**
	 * Return Document title
	 * @return string document title
	 */
	public function getDocumentTitle() {
		return $this->documentTitle;
	}
	/**
	 * Set Document Description Value
	 * @param boolean $value
	 */
	public function setDocumentDesc($value) {
		$this->documentTitle = $value;
	}
	/**
	 * Return Document Description
	 * @return string document description
	 */
	public function getDocumentDesc() {
		return $this->documentDesc;
	}
	/**
	 * Set Document Path Value
	 * @param boolean $value
	 */
	public function setDocumentPath($value) {
		$this->documentPath = $value;
	}
	/**
	 * Return Document title
	 * @return string document title
	 */
	public function getDocumentPath() {
		return $this->documentPath;
	}
	/**
	 * Set Document Filename Value
	 * @param boolean $value
	 */
	public function setDocumentFilename($value) {
		$this->documentFilename = $value;
	}
	/**
	 * Return Document Filename
	 * @return string document title
	 */
	public function getDocumentFilename() {
		return $this->documentFilename;
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
