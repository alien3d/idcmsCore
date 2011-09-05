<?php require_once("../../class/classValidation.php");

/**
 * this is Default Label Translation model file.This is to ensure strict setting enable for all variable enter to daFolderase
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Translation
 * @subpackage Table Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class defaultLabelModel extends validationClass{

	/**
	 * Default Label Identification
	 * @var int
	 */
	private $defaultLabelId;
	/**
	 * Default Label
	 * @var string
	 */
	private $defaultLabel;
	/**
	 * Default Label English
	 * @var string
	 */
	private $defaultLabelEnglish;
	/**
	 * Language Identification
	 * @var int
	 */
	private $languageId;



	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('defaultLabel');
		$this->setPrimaryKeyName('defaultLabelId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['defaultLabelId'])){
			$this->setdefaultLabelId($this->strict($_POST['defaultLabelId'],'numeric'),0,'single');
		}
		if(isset($_POST['defaultLabel'])){
			$this->setdefaultLabel($this->strict($_POST['defaultLabel'],'memo'));
		}
		if(isset($_POST['defaultLabelEnglish'])){
			$this->setdefaultLabelEnglish($this->strict($_POST['defaultLabelEnglish'],'memo'));
		}
		if(isset($_POST['defaultLabelSequence'])){
			$this->setdefaultLabelSequence($this->strict($_POST['defaultLabelSequence'],'memo'));
		}
		if(isset($_POST['defaultLabelCode'])){
			$this->setdefaultLabelCode($this->strict($_POST['defaultLabelCode'],'memo'));
		}
		if(isset($_POST['defaultLabelNote'])){
			$this->setdefaultLabelNote($this->strict($_POST['defaultLabelNote'],'memo'));
		}
		if(isset($_SESSION['staffId'])){
			$this->setExecuteBy($_SESSION['staffId']);
		}
		if($this->getVendor()==self::mysql){
			$this->setExecuteTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::mssql){
			$this->setExecuteTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::oracle){
			$this->setExecuteTime("to_date(\"".date("Y-m-d H:i:s")."\",'YYYY-MM-DD HH24:MI:SS')");
		}

		$this->setTotal(count($_GET['defaultLabelId']));
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
            if(is_array($_GET['defaultLabelId'])){
            	$this->defaultLabelId= array();
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
            	$this->setdefaultLabelId($this->strict($_GET['defaultLabelId'][$i], 'numeric'), $i, 'array');
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
	}
	/**
	 * Set Default Label   Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setDefaultLabelId($value,$key,$type) {
		if($type=='single'){
			$this->defaultLabelId = $value;
		} else if ($type=='array'){
			$this->defaultLabelId[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type Single Or Array:setDefaultLabelId ?"));
			exit();
		}
	}
	/**
	 * Return defaultLabel Identification Value
	 * Return Default Label Identification
	 * @param array[int][int] $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getDefaultLabelId($key,$type) {
		if($type=='single'){
			return $this->defaultLabelId;
		} else if ($type=='array'){
			return $this->defaultLabelId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type Single Or Array:getDefaultLabelId ?"));
			exit();
		}
	}
	/**
	 * Set Default Label Value
	 * @param  string $value
	 */
	public function setDefaultLabel($value) {
		$this->defaultLabel = $value;
	}
	/**
	 * Return Default Label Value
	 * @return string
	 */
	public function getDefaultLabel() {

		return $this->defaultLabel;
	}
	/**
	 * Set Default Label Value
	 * @param  string $value
	 */
	public function setDefaultLabelEnglish($value) {
		$this->defaultLabelEnglish = $value;
	}
	/**
	 * Return Default Label Value
	 * @return string
	 */
	public function getDefaultLabelEnglish() {

		return $this->defaultLabelEnglish;
	}



}
?>