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
	private $folderAccessValue;



	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Folderle
		 */
		$this->setFolderleName 		('folderAccess');
		$this->setPrimaryKeyName 	('folderAccessId');
		/*
		 *  All the $_POST enviroment.
		 */
		$this->folderAccessId 		= array();
		$this->folderAccessValue 	= array();
		$this->setTotal(count($_GET['folderAccessId']));


		for($i=0;$i<$this->getTotalfolderAccessId;$i++) {
			$this->setFolderAccessId($this->strict($_GET['folderAccessId'][$i],'numeric'),$i);
			if($_GET[$folderAccessValue][$i]=='true') {
				$this->setFolderAccessValue(1,$i);
			} else {
				$this->setFolderAccessValue(0,$i);
			}
		}


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
		$this->setIsDefault(0,'','string');
		$this->setIsNew(1,'','string');
		$this->setIsDraft(1,'','string');
		$this->setIsUpdate(0,'','string');
		$this->setIsActive(0,'','string');
		$this->setIsDelete(0,'','string');
		$this->setIsApproved(0,'','string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function approved()
	{
		$this->setIsDefault(0,'','string');
		$this->setIsNew(1,'','string');
		$this->setIsDraft(0,'','string');
		$this->setIsUpdate(0,'','string');
		$this->setIsActive(0,'','string');
		$this->setIsDelete(0,'','string');
		$this->setIsApproved(1,'','string');
	}
		public function setFolderAccessId($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->FolderAccessId = $value;
		} else if ($type=='array'){
			$this->FolderAccessId[$key]=$value;
		}
	}
	/**
	 * Return isFolderId Value
	 * @return integer FolderId
	 */
	public function getFolderAccessId($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->FolderAccessId;
		} else if ($type=='array'){
			return $this->FolderAccessId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Folder/Module/Accordion Identification Value
	 * @param  numeric $value
	 */
	public function setFolderId($value) {
		$this->iconId = $value;
	}
	/**
	 * Return Folder/Module/Accordion Identiification Value
	 * @return numeric Folder identification
	 */
	public function getFolderId() {

		return $this->FolderId;
	}
	/**
	 * Set Folder/Module/Accordion Identification Value
	 * @param  numeric $value
	 */
	public function setFolderId($value) {
		$this->iconId = $value;
	}
	/**
	 * Return Folder/Module/Accordion Identiification Value
	 * @return numeric Folder identification
	 */
	public function getFolderId() {

		return $this->FolderId;
	}
	/**
	 * Set Folder/Module/Accordion Identification Value
	 * @param  numeric $value
	 */
	public function setGroupId($value) {
		$this->groupId = $value;
	}
	/**
	 * Return Folder/Module/Accordion Identiification Value
	 * @return numeric Folder identification
	 */
	public function getGroupId() {

		return $this->groupId;
	}
/**
	 * Set Folder Access  Value
	 * @param  numeric $value
	 */
	public function setFolderAccessValue($value,$key) {
		$this->folderAccessValue[$key] = $value;
	}
	/**
	 * Return Folder Access Value
	 * @return numeric Folder identification
	 */
	public function getFolderAccessValue($value,$key) {

		return $this->folderAccessValue[$key]=$value;
	}


}
?>