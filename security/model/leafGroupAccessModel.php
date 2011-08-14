<?php require_once("../../class/classValidation.php");

/**
 * this is leaf security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package leaf
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafGroupAccessModel extends validationClass{

	private $leafGroupAccessId;
	private $leafId;
	private $groupId;
	private $moduleId;
	private $folderId;
	private $staffId;
	private $leafCreateAccessValue;
	private $leafReadAccessValue;
	private $leafUpdateAccessValue;
	private $leafDeleteAccessValue;
	private $leafPrintAccessValue;
	private $leafPostAccessValue;
	private $leafDraftAccessValue;

	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('leafGroupAccess');
		$this->setPrimaryKeyName('leafGroupAccessId');
		/*
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
	 * Set Leaf Group Access Value
	 * @param unknown_type $value
	 * @param unknown_type $key
	 * @param unknown_type $type
	 */
	public function setLeafGroupAccessId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
			$this->leafGroupAccessId = $value;
		} else if ($type=='array'){
			$this->leafGroupAccessId[$key]=$value;
		}
	}
	/**
	 * Return Leaf Group Access Value
	 * @return integer leafGroupAccessId
	 */
	public function getLeafGroupAccessId($key=NULL,$type=NULL) {
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
	public function setLeafId($value) {
		$this->leafId = $value;
	}
	/**
	 * Return Leaf Identification Value
	 * @return int tab identification
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
	 * Return Group Identification Value
	 * @return int Group Identification
	 */
	public function getGroupId() {

		return $this->groupId;
	}
	/**
	 * Set Leaf Create Access  Value
	 * @param  int $value
	 */
	public function setLeafCreateAccessValue($value,$key) {
		$this->leafCreateAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Create Access Value
	 * @return int tab identification
	 */
	public function getleafCreateAccessValue($value,$key) {

		return $this->leafCreateAccessValue[$key]=$value;
	}

	/**
	 * Set Leaf Read Access  Value
	 * @param  int $value
	 */
	public function setLeafReadAccessValue($value,$key) {
		$this->leafReadAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Read Access Value
	 * @return int tab identification
	 */
	public function getLeafReadAccessValue($value,$key) {

		return $this->leafReadAccessValue[$key]=$value;
	}
	/**
	 * Set Leaf Update Access  Value
	 * @param  int $value
	 */
	public function setLeafUpdateAccessValue($value,$key) {
		$this->leafUpdateAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Update Access Value
	 * @return int tab identification
	 */
	public function getLeafUpdateAccessValue($value,$key) {

		return $this->leafUpdateAccessValue[$key]=$value;
	}
	/**
	 * Set Leaf Update Access  Value
	 * @param  int $value
	 */
	public function setLeafUpdateAccessValue($value,$key) {
		$this->leafUpdateAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Delete Access Value
	 * @return int tab identification
	 */
	public function getLeafDeleteAccessValue($value,$key) {

		return $this->leafDeleteAccessValue[$key]=$value;
	}
	/**
	 * Set Leaf Print Access  Value
	 * @param  int $value
	 */
	public function setLeafPrintAccessValue($value,$key) {
		$this->leafPrintAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Print Access Value
	 * @return int tab identification
	 */
	public function getleafPrintAccessValue($value,$key) {

		return $this->leafPrintAccessValue[$key]=$value;
	}
	/**
	 * Set Leaf Post Access  Value
	 * @param  int $value
	 */
	public function setLeafPostAccessValue($value,$key) {
		$this->leafPostAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Post  Access Value
	 * @return int tab identification
	 */
	public function getleafPostAccessValue($value,$key) {

		return $this->leafPostAccessValue[$key]=$value;
	}
	/**
	 * Set Leaf Draft Access  Value
	 * @param  int $value
	 */
	public function setLeafDraftAccessValue($value,$key) {
		$this->tabAccessValue[$key] = $value;
	}
	/**
	 * Return Leaf Draft Access Value
	 * @return int Leaf Draft Access Identification
	 */
	public function getLeafDraftAccessValue($value,$key) {

		return $this->leafDraftAccessValue[$key]=$value;
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
	 * @return int Group
	 *  identification
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
	 * @return int Module identification
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
	 * @return int Folder Identification
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
	 * @return int Staff Identification
	 */
	public function getStaffId() {

		return $this->staffId;
	}

}
?>