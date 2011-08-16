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


	private $documentId;
	private $documentCategoryId;
	private $leafId;
	private $documentSequence;
	private $documentCode;
	private $documentNote;
	private $documentTitle;
	private $documentDesc;
	private $documentPath;
	private $documentFilename;
	private $documentExtension;

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
			$this->setDocumentId($this->strict($_POST['documentId'],'numeric'),0,'single');
		}
		if(isset($_POST['documentCategoryId'])){
			$this->setDocumentCategoryId($this->strict($_POST['documentCategoryId'],'numeric'));
		}
		if(isset($_POST['leafId'])){
			$this->setLeafId($this->strict($_POST['leafId'],'numeric'));
		}


		if(isset($_POST['documentSequence'])){
			$this->setDocumentSequence($this->strict($_POST['docuementSequence'],'numeric'));
		}
		if(isset($_POST['documentCode'])){
			$this->setDocumentCode($this->strict($_POST['docuementCode'],'memo'));
		}

		if(isset($_POST['documentNote'])){
			$this->setDocumentNote($this->strict($_POST['docuementNote'],'memo'));
		}


		if(isset($_POST['documentTitle'])){
			$this->setDocumentTitle($this->strict($_POST['docuementTitle'],'memo'));
		}
		if(isset($_POST['documentDesc'])){
			$this->setDocumentDesc($this->strict($_POST['docuementDesc'],'memo'));
		}

		if(isset($_POST['documentPath'])){
			$this->setDocumentPath($this->strict($_POST['docuementPath'],'memo'));
		}

		if(isset($_POST['documentFilename'])){
			$this->setdocumentFilename($this->strict($_POST['docuementFilename'],'memo'));
		}
		if(isset($_POST['documentFilename'])){
			$this->setdocumentExtension($this->strict($_POST['docuementExtension'],'memo'));
		}
		if(isset($_SESSION['staffId'])){
			$this->setBy($_SESSION['staffId']);
		}
		if($this->getVendor()==self::mysql){
			$this->setTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::mssql){
			$this->setTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::oracle){
			$this->setTime("to_date(\"".date("Y-m-d H:i:s")."\",'YYYY-MM-DD HH24:MI:SS')");
		} else{
			echo "udentified vendor ?";
		}


	}
	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	public function create()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(1,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(1,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(0,0,'string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	public function update()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(0,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(1,0,'string');
		$this->setIsActive(1,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(0,0,'string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	public function delete()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(0,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(0,0,'string');
		$this->setIsDelete(1,0,'string');
		$this->setIsApproved(0,0,'string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function draft()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(1,0,'string');
		$this->setIsDraft(1,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(0,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(0,0,'string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function approved()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(1,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(0,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(1,0,'string');
	}
	/**
	 * Update  Table Status
	 */
	public function updateStatus() {
		if(!(is_array($_GET['isDefault']))) {
			$this->setIsDefault(0,0,'string');
		}
		if(!(is_array($_GET['isNew']))) {
			$this->setIsNew(0,0,'string');
		}
		if(!(is_array($_GET['isDraft']))) {
			$this->setIsDraft(0,0,'string');
		}
		if(!(is_array($_GET['isUpdate']))) {
			$this->setIsUpdate(0,0,'string');
		}
		if(!(is_array($_GET['isDelete']))) {

			$this->setIsDelete(1,0,'string');
		}
		if(!(is_array($_GET['isActive']))) {
			$this->setIsActive(0,0,'string');
		}

		if(!(is_array($_GET['isApproved']))) {
			$this->setIsApproved(0,0,'string');
		}
	}
	/**
	 * Set isDefault Value
	 * @param int $value
	 * @param array[int]int $key List Of Primary Key.
* @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setDocumentId($value,$key,$type) {
		if($type=='single'){
			$this->documentId = $value;
		} else if ($type=='array'){
			$this->documentId[$key]=$value;
		}
	}
	/**
	 * Return Document Identification Value
	 * @return int
	 */
	public function getDocumentId($key,$type) {
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
	 * Set Document Category Identification Value
	 * @param  int $value
	 */
	public function setDocumentCategoryId($value) {
		$this->documentCategoryId = $value;
	}
	/**
	 * Return Document Category Identification Value
	 * @return int 
	 */
	public function getDocumentCategoryId() {
		return $this->documentCategoryId;
	}
	/**
	 * Set Leaf Identification Value
	 * @param  int $value
	 */
	public function setLeafId($value) {
		$this->leafId = $value;
	}
	/**
	 * Return Leaf Identification Value
	 * @return int 
	 */
	public function getLeafId() {
		return $this->leafId;
	}
	/**
	 * Set Document Sequence Number Value
	 * @param  int $value
	 */
	public function setDocumentSequence($value) {
		$this->documentSequence = $value;
	}
	/**
	 * Return Document Sequence Number
	 * @return int 
	 */
	public function getDocumentSequence() {
		return $this->documentSequence;
	}
	/**
	 * Set Document Code Value
	 * @param string $value
	 */
	public function setDocumentCode($value) {
		$this->documentCode = $value;
	}
	/**
	 * Return Document Code
	 * @return string 
	 */
	public function getDocumentCode() {
		return $this->documentCode;
	}

	/**
	 * Set Document Note Value
	 * @param string $value
	 */
	public function setDocumentNote($value) {
		$this->documentNote = $value;
	}
	/**
	 * Return Document Note
	 * @return string 
	 */
	public function getDocumentNote() {
		return $this->documentNote;
	}
	/**
	 * Set Document Title Value
	 * @param string $value
	 */
	public function setDocumentTitle($value) {
		$this->documentTitle = $value;
	}
	/**
	 * Return Document title
	 * @return string 
	 */
	public function getDocumentTitle() {
		return $this->documentTitle;
	}

	/**
	 * Set Document Description Value
	 * @param string $value
	 */

	public function setDocumentDesc($value) {
		$this->documentTitle = $value;
	}
	/**
	 * Return Document Description
	 * @return string 
	 */
	public function getDocumentDesc() {
		return $this->documentDesc;
	}
	/**
	 * Set Document Path Value
	 * @param string $value
	 */
	public function setDocumentPath($value) {
		$this->documentPath = $value;
	}
	/**
	 * Return Document title
	 * @return string 
	 */
	public function getDocumentPath() {
		return $this->documentPath;
	}
	/**
	 * Set Document Filename Value
	 * @param string $value
	 */
	public function setDocumentFilename($value) {
		$this->documentFilename = $value;
	}
	/**
	 * Return Document Filename
	 * @return string 
	 */
	public function getDocumentFilename() {
		return $this->documentFilename;
	}
	/**
	 * Set Document Extension Value
	 * @param string $value
	 */
	public function setDocumentExtension($value) {
		$this->documentFilename = $value;
	}
	/**
	 * Return Document Extension
	 * @return string
	 */
	public function getDocumentExtension() {
		return $this->documentExtension;
	}

}
?>
