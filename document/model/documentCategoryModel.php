<?php require_once("../../class/classValidation.php");

/**
 * this is document category model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Document
 * @subpackage Document Category
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class documentCategoryModel extends validationClass{
	/**
	 * Document Category Identification
	 * @var int
	 */
	private $documentCategoryId;
	/**
	 * Document Category Title
	 * @var string
	 */
	private $documentCategoryTitle;
	/**
	 * Document Category Description
	 * @var string
	 */
	private $documentCategoryDesc;
	/**
	 * Document Category Sequence
	 * @var int
	 */
	private $documentCategorySequence;
	/**
	 * Document Category Code
	 * @var string
	 */
	private $documentCategoryCode;
	/**
	 * Document Category Note
	 * @var string
	 */
	private $documentCategoryNote;

	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/**
		 *  Basic Information Table
		 */
		$this->setTableName('documentCategory');
		$this->setPrimaryKeyName('documentCategoryId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['documentCategoryId'])){
			$this->setDocumentCategoryId($this->strict($_POST['documentCategoryId'],'numeric'),0,'single');
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
			$this->setExecuteBy($_SESSION['staffId']);
		}
		if($this->getVendor()==self::mysql){
			$this->setExecuteTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::mssql){
			$this->setExecuteTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::oracle){
			$this->setExecuteTime("to_date('".date("Y-m-d H:i:s")."','YYYY-MM-DD HH24:MI:SS')");
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
	 * Set  Document Category Identification Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setDocumentCategoryId($value,$key,$type) {
		if($type=='single'){
			$this->documentCategoryId = $value;
		} else if ($type=='array'){
			$this->documentCategoryId[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:setDocumentCategoryId ?"));
			exit();
		}
	}
	/**
	 * Return Document Category Identification Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getDocumentCategoryId($key,$type) {
		if($type=='single'){
			return $this->documentCategoryId;
		} else if ($type=='array'){
			return $this->documentCategoryId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:getDocumentCategoryId ?"));
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
	 * @return string
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
	 * @return string
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
	 * @return string
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
	 * @return string
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
	 * @return string
	 */
	public function getDocumentCategoryNote() {

		return $this->documentCategoryNote;

	}



}
?>
