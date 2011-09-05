<?php require_once("../../class/classValidation.php");

/**
 * this is staff model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Management
 * @subpackage staffModel
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class staffModel extends validationClass{


	/**
	 * Staff Identification
	 * @var int
	 */
	private $staffId;
	/**
	 * Group Identification
	 * @var int
	 */
	private $groupId;
	/**
	 * Group Identification
	 * @var int
	 */
	private $departmentId;
	/**
	 * Language Identification
	 * @var int
	 */
	private $languageId;
	/**
	 * Staff Password
	 * @var string
	 */
	private $staffPassword;
	/**
	 * Staff Name
	 * @var string
	 */
	private $staffName;
	/**
	 * Staff Number
	 * @var string
	 */
	private $staffNo;
	/**
	 * Staff Identification Card Number. ** Only Valid in Malaysia
	 * @var string
	 */
	private $staffIc;


	/* (non-PHPdoc)
	 * @see validationClass::execute()
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('staff');
		$this->setPrimaryKeyName('staffId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['staffId'])){
			$this->setStaffId($this->strict($_POST['staffId'],'numeric'),'','string');
		}

		if(isset($_POST['groupId'])){
			$this->setGroupId($this->strict($_POST['groupId'],'numeric'));
		}
		if(isset($_POST['departmentId'])){
			$this->setDepartmentId($this->strict($_POST['departmentId'],'numeric'));
		}
		if(isset($_POST['languageId'])){
			$this->setLanguageId($this->strict($_POST['languageId'],'numeric'));
		} else{
			$this->setLanguageId(21);
		}
		if(isset($_POST['staffPassword'])){
			$this->setStaffPassword($this->strict($_POST['staffPassword'],'password'));
		}
		if(isset($_POST['staffName'])){
			$this->setStaffName($this->strict($_POST['staffName'],'string'));
		}
		if(isset($_POST['staffNo'])){
			$this->setStaffNo($this->strict($_POST['staffNo'],'numeric'));
		}
		if(isset($_POST['staffIc'])){
			$this->setStaffIc($this->strict($_POST['staffIc'],'string'));
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

		$this->setTotal(count($_GET['staffId']));
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
            if(is_array($_GET['staffId'])){
            	$this->staffId=array();
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

            	$this->setStaffId($this->strict($_GET['staffId'][$i], 'numeric'), $i, 'array');
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

            	$primaryKeyAll .= $this->getStaffId($i, 'array') . ",";
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
	public
	/* (non-PHPdoc)
	 * @see configClass::excel()
	 */
	function excel() {

	}


	/**
	 * Update Religion Table Status
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
	 * Set Staff Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'string' 1 As 'array'
	 */
	public function setStaffId($value,$key,$type) {
		if($type=='single'){
			$this->staffId = $value;
		} else if ($type=='array'){
			$this->staffId[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:setStaffId ?"));
			exit();
		}
	}
	/**
	 * Return Staff Identification Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getStaffId($key=NULL,$type=NULL) {
		if($type=='single'){
			return $this->staffId;
		} else if ($type=='array'){
			return $this->staffId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:getStaffId ?"));
			exit();
		}
	}

	/**
	 * Set  Group Identification (english)
	 * @param  int $value
	 */
	public function setGroupId($value) {
		$this->groupId = $value;
	}
	/**
	 * Return Group  Description (english)
	 * @return  int
	 */
	public function getGroupId() {
		return $this->groupId;
	}
	/**
	 * Set  Department Identification
	 * @param  int $value
	 */
	public function setDepartmentId($value) {
		$this->departmentId = $value;
	}
	/**
	 * Return Department Identification
	 * @return int
	 */
	public function getDepartmentId() {
		return $this->departmentId;
	}

	/**
	 * Set  Language Identification
	 * @param  int $value
	 */
	public function setLanguageId($value) {
		$this->languageId = $value;
	}
	/**
	 * Return Language Identification
	 * @return int
	 */
	public function getLanguageId() {
		return $this->languageId;
	}

	/**
	 * Set  Staff Password
	 * @param  string $value
	 */
	public function setStaffPassword($value) {
		$this->staffPassword = $value;
	}
	/**
	 * Return Staff Password
	 * @return string
	 */
	public function getStaffPassword() {
		return $this->staffPassword;
	}
	/**
	 * Set  Staff Name
	 * @param  string $value
	 */
	public function setStaffName($value) {
		$this->staffName = $value;
	}
	/**
	 * Return Staff Name
	 * @return string
	 */
	public function getStaffName() {
		return $this->staffName;
	}
	/**
	 * Set  Staff No
	 * @param  string $value
	 */
	public function setStaffNo($value) {
		$this->staffNo = $value;
	}
	/**
	 * Return Staff No
	 * @return string
	 */
	public function getStaffNo() {
		return $this->staffNo;
	}

	/**
	 * Set  Staff Identification
	 * @param  string $value
	 */
	public function setStaffIc($value) {
		$this->staffIc = $value;
	}
	/**
	 * Return Staff Identification
	 * @return string $value
	 */
	public function getStaffIc() {
		return $this->staffIc;
	}

}
?>