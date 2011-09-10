<?php require_once("../../class/classValidation.php");

/**
 * this is leaf Access Security model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage Leaf Access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafAccessModel extends validationClass{


	/**
	 * Leaf Access  Identification
	 * @var int
	 */
	private $leafAccessId;
	/**
	 * Group Identification (** For Filtering Only)
	 * @var int
	 */
	private $groupId;
	/**
	 * Module   Identification (** For Filtering  Only)
	 * @var bool
	 */
	private $moduleId;
	/**
	 * Folder   Identification (** For Filtering Only)
	 * @var int
	 */
	private $folderId;
	/**
	 * Leaf  Identification(** For Filtering only)
	 * @var int
	 */
	private $leafTempId;
	/**
	 * Staff Identification
	 * @var int
	 */
	private $staffId;
	/**
	 * Leaf Create Access Value
	 * @var bool
	 */
	private $leafCreateAccessValue;
	/**
	 * Leaf Read Access Value
	 * @var bool
	 */
	private $leafReadAccessValue;
	/**
	 * Leaf Update Access Value
	 * @var bool
	 */
	private $leafUpdateAccessValue;
	/**
	 * Leaf Delete Access Value
	 * @var bool
	 */
	private $leafDeleteAccessValue;
	/**
	 * Leaf Print Access Value
	 * @var bool
	 */
	private $leafPrintAccessValue;
	/**
	 * Leaf Posting Access Value
	 * @var bool
	 */
	private $leafPostAccessValue;





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
		/*
		 *  All the $_GET enviroment.
		 */
		
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['groupId'])){
			$this->setGroupId($this->strict($_POST['groupId'],'numeric'));
		}
		if(isset($_POST['moduleId'])){
			$this->setModuleId($this->strict($_POST['moduleId'],'numeric'));
		}
		if(isset($_POST['folderId'])){
			$this->setFolderId($this->strict($_POST['folderId'],'numeric'));
		}
		if(isset($_POST['leafTempId'])){
			$this->setleafTempId($this->strict($_POST['leafTempId'],'numeric'));
		}
		if(isset($_POST['staffId'])){
			$this->setStaffId($this->strict($_POST['staffId'],'numeric'));
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
		}


		for($i=0;$i<$this->getTotal();$i++) {


			$this->setLeafAccessId($this->strict($_GET['leafAccessId'][$i],'numeric'),$i);


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
			$primaryKeyAll .= $this->getLeafAccessId($i, 'array') . ",";


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
	 * Set Leaf Access Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafAccessId($value,$key,$type) {
		if($type=='single'){
			$this->leafAccessId = $value;
		} else if ($type=='array'){
			$this->leafAccessId[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:setLeafAccessId ?"));
			exit();
		}
	}

	/**
	 * Return Leaf Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getLeafAccessId($key,$type) {
		if($type=='single'){
			return $this->leafAccessId;
		} else if ($type=='array'){
			return $this->leafAccessId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:getLeafAccessId ?"));
			exit();
		}
	}
	/**
	 * Set Leaf Identification Value
	 * @param  int $value
	 */
	public function setLeafTempId($value) {
		$this->leafTempId = $value;
	}
	/**
	 * Return Leaf Identification Value
	 * @return int
	 */
	public function getLeafTempId() {

		return $this->leafTempId;
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
	 * Return Module Identification Value
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