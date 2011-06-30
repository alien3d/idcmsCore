<?php require_once("../../class/classValidation.php");

/**
 * this is Table Mapping Translation model file.This is to ensure strict setting enable for all variable enter to daFolderase
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Table
 * @subpackage Table Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class defaultLabelTranslateModel extends validationClass{


	private $defaultLabelTranslateId;
	private $defaultLabelText;
	private $defaultLabeld;
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
	public function setdefaultLabelTranslateId($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->defaultLabelTranslateId = $value;
		} else if ($type=='array'){
			$this->defaultLabelTranslateId[$key]=$value;
		}
	}
	/**
	 * Return defaultLabelTranslateId Value
	 * @return integer defaultLabelTranslateId
	 */
	public function getdefaultLabelTranslateId($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->defaultLabelTranslateId;
		} else if ($type=='array'){
			return $this->defaultLabelTranslateId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Table Mapping Identication Value
	 * @param  string $value
	 */
	public function setDefaultLabel($value) {
		$this->defaultLabeld = $value;
	}
	/**
	 * Return Table Mapping Identication Value
	 * @return string Table Mapping Identication
	 */
	public function getDefaultLabelId() {

		return $this->defaultLabeld;
	}
	/**
	 * Set defaultLabelText  Value
	 * @param  string $value
	 */
	public function setdefaultLabelText ($value) {
		$this->defaultLabelText = $value;
	}
	/**
	 * Return defaultLabelText
	 * @return string defaultLabelText
	 */
	public function getDefaultLabelText () {

		return $this->defaultLabelText;
	}


	/**
	 * Set Language Identification
	 * @param  string $value
	 */
	public function setLanguageLabel($value) {
		$this->languageId = $value;
	}
	/**
	 * Return Language Identification
	 * @return string Language Identification
	 */
	public function getLanguageId() {

		return $this->languageId;
	}
}
?>