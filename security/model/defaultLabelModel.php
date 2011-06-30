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


	private $defaultLabelId;
	private $defaultLabel;
	private $defaultLabelEnglish;
	private $languageId;



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
	public function setdefaultLabelId($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->defaultLabelId = $value;
		} else if ($type=='array'){
			$this->defaultLabelId[$key]=$value;
		}
	}
	/**
	 * Return defaultLabelId Value
	 * @return integer defaultLabelId
	 */
	public function getdefaultLabelId($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->defaultLabelId;
		} else if ($type=='array'){
			return $this->defaultLabelId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Default Label Value
	 * @param  string $value
	 */
	public function setDefaultLabelDesc($value) {
		$this->defaultLabel = $value;
	}
	/**
	 * Return Default Label Value
	 * @return string Default Label
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
	 * @return string Language Code
	 */
	public function getDefaultLabelEnglish() {

		return $this->defaultLabelEnglish;
	}



}
?>