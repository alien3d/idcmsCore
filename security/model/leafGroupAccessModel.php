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
class leafGroupAccessModel extends validationClass{

	/**
	 * Leaf Access  Identification
	 * @var int
	 */
	private $leafGroupAccessId;
	/**
	 * Leaf Access  Identification
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
		/**
		 *  Basic Information Table
		 */
		$this->setTableName('leafGroupAccess');
		$this->setPrimaryKeyName('leafGroupAccessId');
		/**
		 *  All the $_POST enviroment.
		 */
		if(isset($_GET['leafGroupAccessId'])){
			$this->setTotal(count($_GET['leafGroupAccessId']));
		}
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
	 * Set Leaf Group Access Identification  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafGroupAccessId($value,$key,$type) {
		if($type=='single'){
			$this->leafGroupAccessId = $value;
		} else if ($type=='array'){
			$this->leafGroupAccessId[$key]=$value;
		}
	}
	/**
	 * Return Leaf Group Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafGroupAccessId($key,$type) {
		if($type=='single'){
			return $this->leafGroupAccessId;
		} else if ($type=='array'){
			return $this->leafGroupAccessId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
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
	 * Return Group Identification Value
	 * @return int
	 */
	public function getGroupId() {

		return $this->groupId;
	}
	/**
	 * Set Leaf Create Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'e
	 */
	public function setLeafCreateAccessValue($value,$key,$type) {
		$this->leafCreateAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Create Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getleafCreateAccessValue($key,$type) {

		return $this->leafCreateAccessValue[$key];
	}

	/**
	 * Set Leaf Read Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafReadAccessValue($value,$key,$type) {
		$this->leafReadAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Read Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafReadAccessValue($key,$type) {

		return $this->leafReadAccessValue[$key];
	}
	/**
	 * Set Leaf Update Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafUpdateAccessValue($value,$key,$type) {
		$this->leafUpdateAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Update Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafUpdateAccessValue($key,$type) {

		return $this->leafUpdateAccessValue[$key];
	}
	/**
	 * Set Leaf Update Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafUpdateAccessValue($value,$key,$type) {
		$this->leafUpdateAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Delete Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafDeleteAccessValue($key,$type) {

		return $this->leafDeleteAccessValue[$key];
	}
	/**
	 * Set Leaf Print Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafPrintAccessValue($value,$key,$type) {
		$this->leafPrintAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Print Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getleafPrintAccessValue($key,$type) {

		return $this->leafPrintAccessValue[$key];
	}
	/**
	 * Set Leaf Post Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafPostAccessValue($value,$key,$type) {
		$this->leafPostAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Post  Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getleafPostAccessValue($key,$type) {

		return $this->leafPostAccessValue[$key];
	}
	/**
	 * Set Leaf Draft Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafDraftAccessValue($value,$key,$type) {
		$this->leafDraftAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Draft Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafDraftAccessValue($key,$type) {

		return $this->leafDraftAccessValue[$key];
	}
	/**
	 * Set Group Identification Value
	 * @param  int $value
	 */
	public function setGroupId($value) {
		$this->groupId = $value;
	}
	/**
	 * Return Group Identification Value
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
	 * Return Folder Identification Value
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