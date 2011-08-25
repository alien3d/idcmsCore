<?php require_once("../../class/classValidation.php");

/**
 * this is Leaf model file.This is application  program
 * @category IDCMS
 * @package security
 * @subpackage leaf
 * @copyright IDCMS
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafModel extends validationClass{

	/**
	 * This is  real leaf Id. A bit change conflic with the leafId for application
	 * @var int
	 */
	private $leafId;
	/**
	 * Leaf Category Identification
	 * @var int
	 */
	private $leafCategoryId;
	/**
	 * Module Identification
	 * @var int
	 */
	private $moduleId;
	/**
	 * Folder Identification. 
	 * @var int
	 */
	private $folderId;
	/**
	 * Leaf Icon. Image appear on the  tree side.
	 * @var int
	 */
	private $iconId;
	/**
	 * Leaf Sequence . Ordering Number
	 * @var int
	 */
	private $leafSequence;
	/**
	 * Leaf Code. A String of Code .E.g  LEAF. Must contain 4 characters only
	 * @var string
	 */
	private $leafCode;
	/**
	 * Leaf  Filename .E.g  leaf.php
	 * @var string
	 */
	private $leafFilename;
	/**
	 * Leaf Translation Note
	 * @var string
	 */
	private $leafNote;
	



	/* (non-PHPdoc)
	 * @see validationClass::execute()
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('leaf');
		$this->setPrimaryKeyName('leafId');

		/*
		 *  All the $_POST enviroment.
		 */
	
		if(isset($_POST['leafId'])){
			$this->setLeafId($this->strict($_POST['leafId'],'numeric'),0,'single');
		}
		if(isset($_POST['moduleId'])){
			$this->setModuleId($this->strict($_POST['moduleId'],'numeric'));
		}
		if(isset($_POST['folderId'])){
			$this->setFolderId($this->strict($_POST['folderId'],'numeric'));
		}
		if(isset($_POST['iconId'])){
			$this->setIconId($this->strict($_POST['iconId'],'numeric'));
		}
		if(isset($_POST['leafSequence'])){
			$this->setLeafSequence($this->strict($_POST['leafSequence'],'numeric'));
		}
		if(isset($_POST['leafFilename'])){
			$this->setLeafFilename($this->strict($_POST['leafFilename'],'memo'));
		}

		if(isset($_POST['leafNote'])){
			$this->setLeafNote($this->strict($_POST['leafNote'],'memo'));
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
		}
		

		$this->setTotal(count($_GET['leafId']));
		$accessArray = array(
            "isDefault",
            "isNew",
            "isDraft",
            "isUpdate",
            "isDelete",
            "isActive",
            "isApproved"
            );
            // auto assign as array if true
            if (is_array($_GET['isDefault'])) {
            	$this->isDefault = array();
            }
            if (is_array($_GET['isNew'])) {
            	$this->isNew = array();
            }
            if (is_array($_GET['isDraft'])) {
            	$this->isDraft = array();
            }
            if (is_array($_GET['isUpdate'])) {
            	$this->isUpdate = array();
            }
            if (is_array($_GET['isDelete'])) {
            	$this->isDelete = array();
            }
            if (is_array($_GET['isActive'])) {
            	$this->isActive = array();
            }
            if (is_array($_GET['isApproved'])) {
            	$this->isApproved = array();
            }
            for ($i = 0; $i < $this->getTotal(); $i++) {
            	$this->setLeafId($this->strict($_GET['leafId'][$i], 'numeric'), $i, 'array');
            	if ($_GET['isDefault'][$i] == 'true') {
            		$this->setIsDefault(1, $i, 'array');
            	} else if ($_GET['default'] == 'false') {
            		$this->setIsDefault(0, $i, 'array');
            	}
            	if ($_GET['isNew'][$i] == 'true') {
            		$this->setIsNew(1, $i, 'array');
            	} else {
            		$this->setIsNew(0, $i, 'array');
            	}
            	if ($_GET['isDraft'][$i] == 'true') {
            		$this->setIsDraft(1, $i, 'array');
            	} else {
            		$this->setIsDraft(0, $i, 'array');
            	}
            	if ($_GET['isUpdate'][$i] == 'true') {
            		$this->setIsUpdate(1, $i, 'array');
            	} else {
            		$this->setIsUpdate(0, $i, 'array');
            	}
            	if ($_GET['isDelete'][$i] == 'true') {
            		$this->setIsDelete(1, $i, 'array');
            	} else if ($_GET['isDelete'][$i] == 'false') {
            		$this->setIsDelete(0, $i, 'array');
            	}
            	if ($_GET['isActive'][$i] == 'true') {
            		$this->setIsActive(1, $i, 'array');
            	} else {
            		$this->setIsActive(0, $i, 'array');
            	}
            	if ($_GET['isApproved'][$i] == 'true') {
            		$this->setIsApproved(1, $i, 'array');
            	} else {
            		$this->setIsApproved(0, $i, 'array');
            	}

            	$primaryKeyAll .= $this->getLeafId($i, 'array') . ",";
            }
            $this->setPrimaryKeyAll((substr($primaryKeyAll, 0, -1)));


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
	 * Update folder Table Status
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
	 * Set Leaf Identification  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafId($value,$key,$type) {
		if($type=='single'){
			$this->leafId = $value;
		} else if ($type=='array'){
			$this->leafId[$key]=$value;
		}
	}
	/**
	 * Return Leaf Identification Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafId($key,$type) {
		if($type=='single'){
			return $this->leafId;
		} else if ($type=='array'){
			return $this->leafId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Module Identification  Value
	 * @param int $value
	 */
	public function setModuleId($value) {
		$this->moduleId = $value;

	}
	/**
	 * Return Module Identification Value
	 * @return int
	 */
	public function getModuleId() {

		return $this->moduleId;

	}
	/**
	 * Set Folder Identification  Value
	 * @param int $value
	 */
	public function setFolderId($value) {

		$this->folderId = $value;

	}
	/**
	 * Return Folder Identication Value
	 * @return int
	 */
	public function getFolderId() {

		return $this->folderId;

	}
	/**
	 * Set Icon Identification  Value
	 * @param int $value
	 */
	public function setIconId($value) {

		$this->iconId = $value;

	}
	/**
	 * Return Icon Identification Value
	 * @return int
	 */
	public function getIconId() {

		return $this->iconId;

	}
	/**
	 * Set Leaf Code Value
	 * @param string $leafCode
	 */
	public function setLeafCode($value) {
		$this->leafCode = $value;
	}
	/**
	 * Return Leaf Code
	 * @return string
	 */
	public function getLeafCode() {
		return $this->leafCode;
	}
	/**
	 * Set Leaf Sequence Value
	 * @param int $value
	 */
	public function setLeafSequence($value) {
		$this->leafSequence = $value;
	}
	/**
	 * Return Leaf Sequence
	 * @return int
	 */
	public function getLeafSequence() {
		return $this->leafSequence;
	}
	/**
	 * Set Leaf Application Filename
	 * @param string $value
	 */
	public function setLeafFilename($value) {
		$this->leafFilename = $value;
	}
	/**
	 * Return Leaf /Application Filename
	 * @return string
	 */
	public function getLeafFilename() {
		return $this->leafFilename;
	}
	/**
	 * Set Leaf/Application Note (English Translation Value
	 * @param string $value
	 */
	public function setLeafNote($value) {
		$this->leafNote = $value;
	}
	/**
	 * Return Leaf/Application Note (English Translation Default)
	 * @return string
	 */
	public function getLeafNote() {
		return $this->leafNote;
	}


}
?>