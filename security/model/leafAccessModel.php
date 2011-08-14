<?php require_once("../../class/classValidation.php");

/**
 * this is leaf security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage leaf
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafAccessModel extends validationClass{
	//table property
	public $tableName;
	public $primaryKeyName;

	//table field
	private $leafAccessId;
	private $groupId;
	private $moduleId;
	private $folderId;
	private $leafId;
	private $staffId;
	private $leafCreateAccessValue;
	private $leafReadAccessValue;
	private $leafUpdateAccessValue;
	private $leafDeleteAccessValue;
	private $leafPrintAccessValue;
	private $leafPostAccessValue;
	private $totalleafAccessId;




	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('leafAccess');
		$this->setPrimaryKeyName('leafAccessId');
		/*
		 *  All the $_POST enviroment.
		 */
		$this->leafAccessId 		= array();
		$this->leafAccessValue 		= array();
		$this->setTotal(count($_GET['leafAccessId']));

		if(isset($_POST['groupId'])){
			$this->setGroupId($this->strict($_POST['groupId'],'numeric'));
		}
		if(isset($_POST['moduleId'])){
			$this->setModuleId($this->strict($_POST['moduleId'],'numeric'));
		}
		if(isset($_POST['folderId'])){
			$this->setFolderId($this->strict($_POST['folderId'],'numeric'));
		}
		if(isset($_POST['staffId'])){
			$this->setStaffId($this->strict($_POST['staffId'],'numeric'));
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


		for($i=0;$i<$this->getTotal();$i++) {


			$this->setLeafGroupAccessId($this->strict($_GET['leafGroupAccessId'][$i],'numeric'),$i);


			if($_GET['leafCreateAccessValue'][$i]=='true') {
				$this->setLeafCreateAccessValue($i, 1);

			} else {
				$this->setLeafCreateAccessValue($i, 0);
			}

			if($_GET['leafReadAccessValue'][$i]=='true') {

				$this->setLeafReadAccessValue($i, 1);
			} else {

				$this->setLeafReadAccessValue($i, 0);
			}

			if($_GET['leafUpdateAccessValue'][$i]=='true') {
					
				$this->setLeafUpdateAccessValue($i, 1);
			} else {
					
				$this->setLeafUpdateAccessValue($i, 0);
			}

			if($_GET['leafDeleteAccessValue'][$i]=='true') {
				$this->setLeafDeleteAccessValue($i, 1);
			} else {
				$this->setLeafDeleteAccessValue($i, 1);
			}

			if($_GET['leafPrintAccessValue'][$i]=='true') {
				$this->setLeafPrintAccessValue($i, 1);
			} else {
				$this->setLeafPrintAccessValue($i, 0);
			}

			if($_GET['leafPostAccessValue'][$i]=='true') {
				$this->setLeafPostAccessValue($i, 1);
			} else {
				$this->setLeafPostAccessValue($i, 0);
			}
			if($_GET['leafDraftAccessValue'][$i]=='true') {
				$this->leafDraftAccessValue[$i] =1;
				$this->setLeafDraftAccessValue($i, 1);
			} else {
				$this->leafDraftAccessValue[$i]=0;
				$this->setLeafDraftAccessValue($i, 0);
			}
			$primaryKeyAll .= $this->getLeafGroupAccessId($i, 'array') . ",";


		}

		$this->setPrimaryKeyAll((substr($primaryKeyAll, 0, -1)));


	}

	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	function create() {
	}

	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	function update() {

	}

	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	function delete() {
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
	 * Set Leaf Access Identification  Value
	 * @param int $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafAccessId($value,$key,$type) {
		if($type=='single'){
			$this->leafAccessId = $value;
		} else if ($type=='array'){
			$this->leafAccessId[$key]=$value;
		}
	}

	/**
	 * Return Leaf Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafAccessId($key,$type) {
		if($type=='single'){
			return $this->leafAccessId;
		} else if ($type=='array'){
			return $this->leafAccessId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Leaf Identification Value
	 * @param  int $value
	 */
	public function setLeafId($value) {
		$this->leafId = $value;
	}
	/**
	 * Return Leaf Identiification Value
	 * @return int 
	 */
	public function getLeafId() {

		return $this->leafId;
	}
	/**
	 * Set Group Identification Value
	 * @param  int $value
	 */
	public function setGroupId($value) {
		$this->groupId = $value;
	}
	/**
	 * Return Group Identiification Value
	 * @return int 
	 */
	public function getGroupId() {

		return $this->groupId;
	}
	/**
	 * Set Module Identification Value
	 * @param  int $value
	 */
	public function setModuleId($value) {
		$this->moduleId = $value;
	}
	/**
	 * Return Module Identiification Value
	 * @return int 
	 */
	public function getModuleId() {

		return $this->moduleId;
	}
	/**
	 * Set Folder Identification Value
	 * @param  int $value
	 */
	public function setFolderId($value) {
		$this->folderId = $value;
	}
	/**
	 * Return Folder Identiification Value
	 * @return int 
	 */
	public function getFolderId() {

		return $this->folderId;
	}
	/**
	 * Set Staff Identification Value
	 * @param  int $value
	 */
	public function setStaffId($value) {
		$this->staffId = $value;
	}
	/**
	 * Return Staff Identification Value
	 * @return int 
	 */
	public function getStaffId() {

		return $this->staffId;
	}
}
?>