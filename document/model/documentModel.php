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
	private $documentTitle;
	private $documentDesc;
	private $documentPath;
	private $documentFilename;

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
			$this->setDocumentId($this->strict($_POST['documentId'],'numeric'));
		}
		if(isset($_POST['documentCategoryId'])){
			$this->setDocumentCategory($this->strict($_POST['documentCategoryId'],'numeric'));
		}
		if(isset($_POST['leafId'])){
			$this->setLeafId($this->strict($_POST['leafId'],'numeric'));
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
	 * Set Document Category Identification Value
	 * @param numeric $value
	 */
	public function setDocumentCategoryId($value) {
		$this->documentCategoryId = $value;
	}
	/**
	 * Return Document Category Identification Value
	 * @return numeric Document Cateogory Identification Value
	 */
	public function getDocumentCategoryId() {
		return $this->documentCategoryId;
	}
	/**
	 * Set Leaf Identification Value
	 * @param numeric $value
	 */
	public function setLeafId($value) {
		$this->leafId = $value;
	}
	/**
	 * Return Leaf Identification Value
	 * @return numeric Document Cateogory Identification Value
	 */
	public function getLeafId() {
		return $this->leafId;
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
	 * @return string document title
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

}
?>
