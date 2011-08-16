<?php require_once("../../class/classValidation.php");

/**
 * this is Module Translation Model file.This is to ensure strict setting enable for all variable enter to database
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage Module Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class moduleTranslationModel extends validationClass{


	// table field
	private $moduleTranslateId;
	private $moduleId;
	private $languageId;
	private $moduleTranslate;

	/* (non-PHPdoc)
	 * @see validationClass::execute()
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
		if(isset($_POST['moduleTranslateId'])){
			$this->setModuleTranslateId = $this->strict($_POST['moduleTranslateId'],'numeric');
		}
		if(isset($_POST['moduleId'])){
			$this->setModuleId = $this->strict($_POST['moduleId'],'numeric');
		}
		if(isset($_POST['languageId'])){
			$this->setLanguageId = $this->strict($_POST['languageId'],'numeric');
		}
		if(isset($_POST['moduleTranslate'])){
			$this->setModuleTranslate = $this->strict($_POST['moduleTranslate'],'memo');
		}


		if(isset($_SESSION['staffId'])){
			$this->setBy ($_SESSION['staffId']);
		}
		if($this->getVendor()==self::mysql){
			$this->setTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::mssql){
			$this->setTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::oracle){
			$this->setTime("to_date(\"".date("Y-m-d H:i:s")."\",'YYYY-MM-DD HH24:MI:SS')");
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
	 * Update module Table Status
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
	 * Set Module indentification  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setModuleTranslateId($value,$key,$type) {
		if($type=='single'){
			$this->moduleTranslateId = $value;
		} else if ($type=='array'){
			$this->moduleTranslateId[$key]=$value;
		}
	}
	/**
	 * Return Module Translate Identification Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getModuleTranslateId($key,$type) {
		if($type=='single'){
			return $this->moduleTranslateId;
		} else if ($type=='array'){
			return $this->moduleTranslateId[$key];
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

		$this->tabId = $value;

	}
	/**
	 * Return module Identification Value
	 * @return int
	 */
	public function getModuleId() {

		return $this->moduleId;

	}
	/**
	 * Set Language Identification  Value
	 * @param int $value
	 */
	public function setLanguageId() {

		$this->languageId = $value;

	}
	/**
	 * Return Language Identification Value
	 * @return int
	 */
	public function getLanguageId() {

		return $this->languageId;

	}
	
	/**
	 * Set Module Translate
	 * @param string $value
	 */
	public function setModuleTranslate($value) {
		$this->moduleTranslate = $value;
	}
	/**
	 * Return Module Translate
	 * @return string
	 */
	public function getTranslate() {
		return $this->moduleTranslate;
	}
	


}
?>