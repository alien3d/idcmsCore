<?php require_once("../../class/classValidation.php");

/**
 * this is module model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Security
 * @subpackage module
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class moduleModel extends validationClass{
	/**
	 * Module Identification
	 * @var int
	 */
	private $moduleId;
	/**
	 * Icon Identification
	 * @var int
	 */
	private $iconId;
	/**
	 *  Module Sequence
	 * @var int
	 */
	private $moduleSequence;
	/**
	 * Module Code
	 * @var string
	 */
	private $moduleCode;
	/**
	 * Module Note .English Only
	 * @var string
	 */
	private $moduleNote;

	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('module');
		$this->setPrimaryKeyName('moduleId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['moduleId'])){
			$this->setModuleId($this->strict($_POST['moduleId'],'numeric'),0,'single');
		}
		if(isset($_POST['iconId'])){
			$this->setIconId ($this->strict($_POST['iconId'],'numeric'));
		}

		if(isset($_POST['moduleSequence'])){
			$this->setModuleSequence($this->strict($_POST['moduleSequence'],'numeric'));
		}
		if(isset($_POST['moduleCode'])){
			$this->setModuleCode($this->strict($_POST['moduleCode'],'numeric'));
		}
		if(isset($_POST['moduleNote'])){
			$this->setModuleNote($this->strict($_POST['moduleNote'],'memo'));
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

		$this->setTotal(count($_GET['tabId']));
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
            if(is_array($_GET['tabId'])){
            	$this->tabId=array();
            }
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

            	$this->setModuleId($this->strict($_GET['moduleId'][$i], 'numeric'), $i, 'array');
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
            	$primaryKeyAll .= $this->getTabId($i, 'array') . ",";
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
	 * Update tab Table Status
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
	 * Set Module   Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setModuleId($value,$key,$type) {
		if($type=='single'){
			$this->moduleId = $value;
		} else if ($type=='array'){
			$this->moduleId[$key]=$value;
		}
	}
	/**
	 * Return Module  Identification
	 * @param array[int][int] $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getModuleId($key,$type) {
		if($type=='single'){
			return $this->moduleId;
		} else if ($type=='array'){
			return $this->moduleId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Single Or Array Value"));
			exit();
		}
	}
	/**
	 * Set Icon Identification
	 * @param  int $value
	 */
	public function setIconId($value) {
		$this->iconId = $value;
	}
	/**
	 * Return Icon Identification
	 * @return int
	 */
	public function getIconId() {

		return $this->iconId;
	}
	/**
	 * Set Module Sequence Value
	 * @param  int $value
	 */
	public function setModuleSequence($value) {
		$this->moduleSequence = $value;
	}
	/**
	 * Return module Sequence Value
	 * @return int
	 */
	public function getModuleSequence() {
		return $this->moduleSequence;
	}
	/**
	 * Set Module Code Value
	 * @param string $value
	 */
	public function setModuleCode($value) {
		$this->moduleCode = $value;
	}
	/**
	 * Return Module Code
	 * @return string
	 */
	public function getModuleCode() {
		return $this->moduleCode;
	}
	/**
	 * Set Module Note Value
	 * @param string $value
	 */
	public function setModuleNote($value) {
		$this->moduleNote = $value;
	}
	/**
	 * Return module Note
	 * @return string
	 */
	public function getModuleNote() {
		return $this->moduleNote;
	}

}
?>