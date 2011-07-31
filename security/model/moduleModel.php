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
class moduleModel extends validationClass{

	private $moduleId;
	private $iconId;
	private $moduleSequence;
	private $moduleCode;
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
			$this->setModuleId($this->strict($_POST['moduleId'],'numeric'),'','single');
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

              $this->setTabId($this->strict($_GET['tabId'][$i], 'numeric'), $i, 'array');
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

	/**
	 * Enter description here ...
	 * @param unknown_type $value
	 * @param unknown_type $key
	 * @param unknown_type $type
	 */
	public function setModuleId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
			$this->moduleId = $value;
		} else if ($type=='array'){
			$this->moduleId[$key]=$value;
		}
	}
	/**
	 * Return module Value
	 * @return integer moduleId
	 */
	public function getModuleId($key=NULL,$type=NULL) {
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
	 * Set icon for Tab
	 * @param  numeric $value
	 */
	public function setIconId($value) {
		$this->iconId = $value;
	}
	/**
	 * Return icon for module
	 * @return numeric icon for module
	 */
	public function getIconId() {

		return $this->iconId;
	}
	/**
	 * Set Module Sequence Value
	 * @param numeric $value
	 */
	public function setModuleSequence($value) {
		$this->moduleSequence = $value;
	}
	/**
	 * Return module Sequence Value
	 * @return numeric module sequence
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
	 * @return string Module Code
	 */
	public function getModuleCode() {
		return $this->moduleCode;
	}
/**
	 * Set Module Note Value
	 * @param string $value module Note
	 */
	public function setModuleNote($value) {
		$this->moduleNote = $value;
	}
	/**
	 * Return module Note
	 * @return string module Note
	 */
	public function getModuleNote() {
		return $this->moduleNote;
	}

}
?>