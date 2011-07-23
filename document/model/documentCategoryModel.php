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
	private $documentCategoryId;
	private $documentCategoryTitle;
	private $documentCategoryDesc;
	private $documentCategorySequence;
	private $documentCategoryCode;
	private $documentCategoryNote;

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
			$this->setDocumentCategoryId($this->strict($_POST['documentCategoryId'],'numeric'),'','single');
		}
		if(isset($_POST['documentCategoryTitle'])){
			$this->setDocumentCategoryTitle($this->strict($_POST['documentCategoryTitle'],'memo'));
		}
		if(isset($_POST['documentCategoryDesc'])){
			$this->setDocumentCategoryDesc($this->strict($_POST['documentCategoryDesc'],'memo'));
		}
		if(isset($_POST['documentCategoryCode'])){
			$this->setDocumentCategoryCode($this->strict($_POST['documentCategoryCode'],'string'));
		}
		if(isset($_POST['documentCategorySequence'])){
			$this->setDocumentCategorySequence($this->strict($_POST['documentCategorySequence'],'numeric'));
		}
		if(isset($_POST['documentCategoryNote'])){
			$this->setDocumentCategoryNote($this->strict($_POST['documentCategoryNote'],'memo'));
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
	 * Update  Table Status
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

	// generate basic information from outside
	/**
	 * Set  Document Category Identification Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setDocumentCategoryId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
			$this->documentCategoryId = $value;
		} else if ($type=='array'){
			$this->documentCategoryId[$key]=$value;
		}
	}
	/**
	 * Return Document Category Identification Value
	 * @return integer documentCategoryId
	 */
	public function getDocumentCategoryId($key=NULL,$type=NULL) {
		if($type=='single'){
			return $this->documentCategoryId;
		} else if ($type=='array'){
			return $this->documentCategoryId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Document Category  Title  Value
	 * @param string $value
	 */
	public function setDocumentCategoryTitle($value) {

		$this->documentCategoryTitle = $value;

	}
	/**
	 * Return Document Category Desc Value
	 * @return string $documentCategoryTitle
	 */
	public function getDocumentCategoryTitle() {

		return $this->documentCategoryTitle;

	}
	/**
	 * Set Document Category  Description Value
	 * @param string $value
	 */
	public function setDocumentCategoryDesc($value) {

		$this->documentCategoryDesc = $value;

	}
	/**
	 * Return Document Category Description Value
	 * @return string $documentCategoryDesc
	 */
	public function getDocumentCategoryDesc() {

		return $this->documentCategoryDesc;

	}

	/**
	 * Set Document Category  Sequence Value
	 * @param string $value
	 */
	public function setDocumentCategorySequence($value) {

		$this->documentCategorySequence = $value;

	}
	/**
	 * Return Document Category Sequence Value
	 * @return string $documentCategorySequence
	 */
	public function getDocumentCategorySequence() {

		return $this->documentCategorySequence;

	}

	/**
	 * Set Document Category  Code Value
	 * @param string $value
	 */
	public function setDocumentCategoryCode($value) {

		$this->documentCategoryCode = $value;

	}
	/**
	 * Return Document Category Code Value
	 * @return string $documentCategoryCode
	 */
	public function getDocumentCategoryCode() {

		return $this->documentCategoryCode;

	}

	/**
	 * Set Document Category  Note Value
	 * @param string $value
	 */
	public function setDocumentCategoryNote($value) {

		$this->documentCategoryNote = $value;

	}
	/**
	 * Return Document Category Note Value
	 * @return string $documentCategoryNote
	 */
	public function getDocumentCategoryNote() {

		return $this->documentCategoryNote;

	}



}
?>
