<?php require_once("../../class/classValidation.php");

/**
 * this is table mapping model file.This is to ensure strict setting enable for all variable enter to daFolderase
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package translation
 * @subpackage table
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class tableMappingModel extends validationClass{


	private $tableMappingId;
	private $tableMappingName;
	private $tableMappingColumnName;
	private $tableMappingEnglishLabel;



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
	public function setTableMappingId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
			$this->tableMappingId = $value;
		} else if ($type=='array'){
			$this->tableMappingId[$key]=$value;
		}
	}
	/**
	 * Return Language Id Value
	 * @return integer languageId
	 */
	public function getTableMappingId($key=NULL,$type=NULL) {
		if($type=='single'){
			return $this->tableMappingId;
		} else if ($type=='array'){
			return $this->tableMappingId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Language Description Value
	 * @param  string $value
	 */
	public function setTableMappingColumnName($value) {
		$this->tableMappingColumnName = $value;
	}
	/**
	 * Return Language Description Value
	 * @return string Language Description
	 */
	public function getTableMappingColumnName() {

		return $this->tableMappingColumnName;
	}
	/**
	 * Set Table Mapping English Label Value
	 * @param  string $value
	 */
	public function setTableMappingEnglishLabel($value) {
		$this->tableMappingEnglishLabel = $value;
	}
	/**
	 * Return Table Mapping English Label Value
	 * @return string Language Code
	 */
	public function getTableMappingEnglishLabel() {

		return $this->tableMappingEnglishLabel;
	}


}
?>