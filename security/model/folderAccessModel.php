<?php require_once("../../class/classValidation.php");

/**
 * this is folder security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package folder
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class folderAccessModel extends validationClass{
	// table property
	private $tableName;
	private $primaryKeyName;

	// table field
	private $folderAccessId;
	private $folderId;
	private $groupId;
	private $folderAccessValue;
	private $totalfolderAccessId;

	// table property
	const tableName = 'folderAcces';
	const primaryKeyName = 'folderAccesId';

	// table field
	const folderAccessId = 'folderAccessId';
	const folderId  ='folderId';
	const groupId = 'groupId';
	const folderAccessValue = 'folderAccessValue';

	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName 		('folderAccess');
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

	public function setTableName($value) {
		$this->tableName = $value;

	}
	public function getTableName() {
		return $this->tableName;
	}
	public function setPrimaryKeyName($value) {
		$this->primaryKeyName = $value;

	}
	public function getPrimaryKeyName() {
		return $this->primaryKeyName;
	}
	// generate basic information from outside
	/**
	 * Set folder indentification  Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setFolderAccessId($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->folderAccessId = $value;
		} else if ($type=='array'){
			$this->folderAccessId[$key]=$value;
		}
	}
	/**
	 * Return folder indentication Value
	 * @return integer folderId
	 */
	public function getFolderAccessId($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->folderId;
		} else if ($type=='array'){
			return $this->folderId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Group indentification  Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setGroupId() {

		$this->groupId = $value;

	}
	/**
	 * Return Group indentication Value
	 * @return integer folderId
	 */
	public function getGroupId() {

		return $this->groupId;

	}
	/**
	 * Set folder Access indentification  Value
	 * @param boolean $value
	 * @param integer $key  Array as value
	 */
	public function setFolderAccessValue($value,$key=NULL) {

		$this->folderAccessId[$key]=$value;

	}
	/**
	 * Return folder Access indentication Value
	 * @return boolean folderAccessId
	 */
	public function getFolderAccessValue($key=NULL) {

		return $this->folderValue[$key];

	}
	public function setTotal($value){
		$this->total = $value;
	}
	public function getTotal(){
		return $this->total;
	}
}
?>