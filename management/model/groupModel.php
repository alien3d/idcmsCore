<?php require_once("../../class/classValidation.php");

/**
 * this is religion model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package religion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class groupModel extends validationClass{


	// table field
	private $groupId;
	private $groupSequence;
	private $groupCode;
	private $groupNote;


function execute(){
			/*
		 *  Basic Information Table
		 */
		$this->setTableName('department');
		$this->setPrimaryKeyName('departmentId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['departmentId'])){
			$this->setDepartmentId($this->strict($_POST['departmentId'],'numeric'),'','single');
		}
		if(isset($_POST['departmentSequence'])){
			$this->setDepartmentSequence($this->strict($_POST['departmentSequence'],'memo'));
		}
		if(isset($_POST['departmentCode'])){
			$this->setDepartmentCode($this->strict($_POST['departmentCode'],'memo'));
		}
		if(isset($_POST['departmentNote'])){
			$this->setDepartmentNote($this->strict($_POST['departmentNote'],'memo'));
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

		$this->setTotal(count($_GET['departmentId']));
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
        if(is_array($_GET['departmentId'])){
        	$this->departmentId= array();
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
            $this->setDepartmentId($this->strict($_GET['departmentId'][$i], 'numeric'), $i, 'array');
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
	 * Set Group Identification  Value
	 * @param int $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setGroupId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
			$this->groupId = $value;
		} else if ($type=='array'){
			$this->groupId[$key]=$value;
		}
	}
	/**
	 * Return Group Identification Value
	 * @return integer groupId
	 */
	public function getGroupId($key=NULL,$type=NULL) {
		if($type=='single'){
			return $this->groupId;
		} else if ($type=='array'){
			return $this->groupId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
/**
	 * Set  Group Sequence (english)
	 * @param boolean $value
	 */
	public function setGroupSequence($value) {
		$this->groupSequence = $value;
	}
	/**
	 * Return Group  Description (english)
	 * @return  string Group Sequence
	 */
	public function getGroupSequence() {
		return $this->groupSequence;
	}
/**
	 * Set  Group  Code (english)
	 * @param string $value
	 */
	public function setGroupCode($value) {

		$this->groupCode = $value;
	}
	/**
	 * Return Group  Code
	 * @return  string Group Description
	 */
	public function getGroupCode() {

		return $this->groupCode;
	}
	/**
	 * Set  Group Translation (english)
	 * @param string $value
	 */
	public function setGroupNote($value) {

		$this->groupNote = $value;
	}
	/**
	 * Return Group  Description (english)
	 * @return  string Group Description
	 */
	public function getGroupNote() {

		return $this->groupNote;
	}

}
?>