<?php require_once("../../class/classValidation.php");


/**
 * this is folder security model file.This is to ensure strict setting enable for all variable enter to daFolderase
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package folder
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class folderAccessModel extends validationClass{

	// Folderle field
	private $folderAccessId;
	private $folderId;
	private $groupId;
	private $moduleId;
	private $folderAccessValue;



	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Folderle
		 */
		$this->setTableName		('folderAccess');
		$this->setPrimaryKeyName 	('folderAccessId');
		/*
		 *  All the $_POST enviroment.
		 */
		$this->folderAccessId 		= array();
		$this->folderAccessValue 	= array();
		$this->setTotal(count($_GET['folderAccessId']));

		if(isset($_POST['groupId'])){
			$this->setGroupId($this->strict($_POST['groupId'],'numeric'));
		}
		if(isset($_POST['moduleId'])){
			$this->setModuleId($this->strict($_POST['moduleId'],'numeric'));
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
			$this->setFolderAccessId($this->strict($_GET['folderAccessId'][$i],'numeric'),$i);
			if($_GET[$folderAccessValue][$i]=='true') {
				$this->setFolderAccessValue(1,$i);
			} else {
				$this->setFolderAccessValue(0,$i);
			}
			$primaryKeyAll .= $this->getFolderAccessId($i, 'array') . ",";

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
	 * Enter description here ...
	 * @param unknown_type $value
	 * @param unknown_type $key
	 * @param unknown_type $type
	 */
	public function setFolderAccessId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
			$this->folderAccessId = $value;
		} else if ($type=='array'){
			$this->folderAccessId[$key]=$value;
		}
	}

	/**
	 * Enter description here ...
	 * @param unknown_type $key
	 * @param unknown_type $type
	 * @return Ambigous <multitype:, unknown_type>
	 */
	public function getFolderAccessId($key=NULL,$type=NULL) {
		if($type=='single'){
			return $this->folderAccessId;
		} else if ($type=='array'){
			return $this->folderAccessId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Folder/Module/Accordion Identification Value
	 * @param  int $value
	 */
	public function setFolderId($value) {
		$this->folderId = $value;
	}
	/**
	 * Return Folder/Module/Accordion Identiification Value
	 * @return int Folder identification
	 */
	public function getFolderId() {

		return $this->folderId;
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
	 * @return int Folder identification
	 */
	public function getGroupId() {

		return $this->groupId;
	}
	/**
	 * Set Folder/Module/Accordion Identification Value
	 * @param  int $value
	 */
	public function setModuleId($value) {
		$this->moduleId = $value;
	}
	/**
	 * Return Folder/Module/Accordion Identiification Value
	 * @return int Folder identification
	 */
	public function getModuleId() {

		return $this->moduleId;
	}
	/**
	 * Set Folder Access  Value
	 * @param  int $value
	 */
	public function setFolderAccessValue($value,$key) {
		$this->folderAccessValue[$key] = $value;
	}
	/**
	 * Return Folder Access Value
	 * @return int Folder identification
	 */
	public function getFolderAccessValue($value,$key) {

		return $this->folderAccessValue[$key]=$value;
	}


}
?>