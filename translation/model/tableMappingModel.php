<?php require_once("../../class/classValidation.php");

/**
 * this is Table Mapping model file.This is to ensure strict setting enable for all variable enter to daFolderase
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Translation
 * @subpackage Table Mapping Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class tableMappingModel extends validationClass{


	private $tableMappingId;
	private $tableMapping;
	private $tableMappingEnglish;
	private $languageId;



	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('tableMapping');
		$this->setPrimaryKeyName('tableMappingId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['tableMappingId'])){
			$this->settableMappingId($this->strict($_POST['tableMappingId'],'numeric'),0,'single');
		}
		if(isset($_POST['tableMappingSequence'])){
			$this->settableMappingSequence($this->strict($_POST['tableMappingSequence'],'memo'));
		}
		if(isset($_POST['tableMappingCode'])){
			$this->settableMappingCode($this->strict($_POST['tableMappingCode'],'memo'));
		}
		if(isset($_POST['tableMappingNote'])){
			$this->settableMappingNote($this->strict($_POST['tableMappingNote'],'memo'));
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

		$this->setTotal(count($_GET['tableMappingId']));
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
            if(is_array($_GET['tableMappingId'])){
            	$this->tableMappingId= array();
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
            	$this->settableMappingId($this->strict($_GET['tableMappingId'][$i], 'numeric'), $i, 'array');
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
            	$primaryKeyAll .= $this->getDefaultLabelId($i, 'array') . ",";
            }
            $this->setPrimaryKeyAll((substr($primaryKeyAll, 0, -1)));


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
	}
	/**
	 * Set Table Mapping Identification   Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
* @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function settableMappingId($value,$key,$type) {
		if($type=='single'){
			$this->tableMappingId = $value;
		} else if ($type=='array'){
			$this->tableMappingId[$key]=$value;
		}
	}
	/**
	 * Return Table Mapping Identification Value
	 * Return Module Access Identification
	 * @param array[int]int $key List Of Primary Key.
* @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function gettableMappingId($key,$type) {
		if($type=='single'){
			return $this->tableMappingId;
		} else if ($type=='array'){
			return $this->tableMappingId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Default Label Value
	 * @param  string $value
	 */
	public function settableMappingDesc($value) {
		$this->tableMappingDesc = $value;
	}
	/**
	 * Return Default Label Value
	 * @return string Default Label
	 */
	public function getTableMappingDesc() {

		return $this->tableMappingDesc;
	}
	/**
	 * Set Default Label Value
	 * @param  string $value
	 */
	public function setTableMappingEnglish($value) {
		$this->tableMappingEnglish = $value;
	}
	/**
	 * Return Default Label Value
	 * @return string
	 */
	public function getTableMappingEnglish() {

		return $this->tableMappingEnglish;
	}



}
?>