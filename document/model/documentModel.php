<?php require_once("../../class/classValidation.php");

/**
 * this is Document model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Document
 * @subpackage Document
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class documentModel extends validationClass{

	/**
	 * Document Identification
	 * @var int
	 */
	private $documentId;
	/**
	 * Document Category Identification
	 * @var int
	 */
	private $documentCategoryId;
	/**
	 * Leaf Identification or using default.Leaf identification also will be based on which program installation
	 * @var int
	 */
	private $leafId;
	/**
	 * Document Sequence
	 * @var int
	 */
	private $documentSequence;
	/**
	 * Document Code
	 * @var string
	 */
	private $documentCode;
	/**
	 * Document Note
	 * @var string
	 */
	private $documentNote;
	/**
	 * Document Title.
	 * @var string
	 */
	private $documentTitle;
	/**
	 * Document Description
	 * @var string
	 */
	private $documentDesc;
	/**
	 * Document Path ... Customizeable based on user
	 * @var string
	 */
	private $documentPath;
	/**
	 * Document filename . E.g   financial.xlsx
	 * @var string
	 */
	private $documentFilename;
	/**
	 * Document Extension E.g  .pdf  .xlsx
	 * @var string
	 */
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
			$this->setDocumentFilename($this->strict($_POST['documentFilename'],'memo'));
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
	
		$this->setIsDefault(0,0,'single');
		$this->setIsNew(1,0,'single');
		$this->setIsDraft(0,0,'single');
		$this->setIsUpdate(0,0,'single');
		$this->setIsActive(1,0,'single');
		$this->setIsDelete(0,0,'single');
		$this->setIsApproved(0,0,'single');
	}
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	public function update()
	{
		$this->setIsDefault(0,0,'single');
		$this->setIsNew(0,0,'single');
		$this->setIsDraft(0,0,'single');
		$this->setIsUpdate(1,0,'single');
		$this->setIsActive(1,0,'single');
		$this->setIsDelete(0,0,'single');
		$this->setIsApproved(0,0,'single');
	}
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	public function delete()
	{
		$this->setIsDefault(0,0,'single');
		$this->setIsNew(0,0,'single');
		$this->setIsDraft(0,0,'single');
		$this->setIsUpdate(0,0,'single');
		$this->setIsActive(0,0,'single');
		$this->setIsDelete(1,0,'single');
		$this->setIsApproved(0,0,'single');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function draft()
	{
		$this->setIsDefault(0,0,'single');
		$this->setIsNew(1,0,'single');
		$this->setIsDraft(1,0,'single');
		$this->setIsUpdate(0,0,'single');
		$this->setIsActive(0,0,'single');
		$this->setIsDelete(0,0,'single');
		$this->setIsApproved(0,0,'single');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function approved()
	{
		$this->setIsDefault(0,0,'single');
		$this->setIsNew(1,0,'single');
		$this->setIsDraft(0,0,'single');
		$this->setIsUpdate(0,0,'single');
		$this->setIsActive(0,0,'single');
		$this->setIsDelete(0,0,'single');
		$this->setIsApproved(1,0,'single');
	}
	/**
	 * Update  Table Status
	 */
	public function updateStatus() {
		if(!(is_array($_GET['isDefault']))) {
			$this->setIsDefault(0,0,'single');
		}
		if(!(is_array($_GET['isNew']))) {
			$this->setIsNew(0,0,'single');
		}
		if(!(is_array($_GET['isDraft']))) {
			$this->setIsDraft(0,0,'single');
		}
		if(!(is_array($_GET['isUpdate']))) {
			$this->setIsUpdate(0,0,'single');
		}
		if(!(is_array($_GET['isDelete']))) {

			$this->setIsDelete(1,0,'single');
		}
		if(!(is_array($_GET['isActive']))) {
			$this->setIsActive(0,0,'single');
		}

		if(!(is_array($_GET['isApproved']))) {
			$this->setIsApproved(0,0,'single');
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
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array ?"));
			exit();
		}
	}
	/**
	 * Return Document Identification Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getDocumentId($key,$type) {
		if($type=='single'){
			return $this->documentId;
		} else if ($type=='array'){
			return $this->documentId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array ?"));
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
