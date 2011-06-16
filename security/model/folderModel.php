<?php require_once("../../class/classValidation.php");

/**
 * this is folder model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package folder
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class folderModel extends validationClass{

	// table property
	private $tableName;
	private $primaryKeyName;

	// table field
	private $folderId;
	private $tabId;
	private $iconId;
	private $folderSequence;
	private $folderPath;
	private $folderNote;
	private $isDefault;
	private $isNew;
	private $isDraft;
	private $isUpdate;
	private $isActive;
	private $isDelete;
	private $isApproved;
	private $By;
	private $Time;

	private $folderIdAll; // this is not table field but collection of folderId
	/**
	 * Total Record receive from checkbox grid
	 * @var numeric
	 */
	private $total;
	// database vendor
	public  $vendor;


	// table property
	const tableName = 'folder';
	const primaryKeyName = 'folderId';

	// table field
	const folderId = 'folderId';
	const tabId  ='tabId';
	const iconId = 'iconId';
	const folderSequence = 'folderSequence';
	const folderPath ='folderPath';
	const folderNote = 'folderNote';
	const isDefault = 'isDefault';
	const isNew = 'isNew';
	const isDraft = 'isDraft';
	const isUpdate = 'isUpdate';
	const isActive = 'isActive';
	const isDelete = 'isDelete';
	const isApproved = 'isApproved';
	const By = 'By';
	const Time = 'Time';
	const staffId = 'staffId';
	/* (non-PHPdoc)
	 * @see validationClass::execute()
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('folder');
		$this->setPrimaryKeyName('folderId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['folderId'])){
			$this->setFolderId = $this->strict($_POST['folderId'],'numeric');
		}
		if(isset($_POST['accordionId'])){
			$this->setTabId = $this->strict($_POST['accordionId'],'numeric');
		}
		if(isset($_POST['iconId'])){
			$this->setIconId = $this->strict($_POST['iconId'],'numeric');
		}
		if(isset($_POST['folderPath'])){
			$this->setFolderPath = $this->strict($_POST['folderPath'],'memo');
		}

		if(isset($_POST['folderNote'])){
			$this->setFolderNote = $this->strict($_POST['folderNote'],'memo');
		}
		if(isset($_SESSION['staffId'])){
			$this->setBy ($_SESSION['staffId']);
		}
		if($this->vendor=='mysql'){
			$this->setTime("'".date("Y-m-d H:i:s")."'");
		} else if ($this->vendor=='microsoft'){
			$this->setTime("'".date("Y-m-d H:i:s")."'");
		} else if ($this->vendor=='oracle'){
			$this->setTime("to_date('".date("Y-m-d H:i:s")."','YYYY-MM-DD HH24:MI:SS')");
		}


	}


	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	public function create()
	{
		$this->setIsDefault(0,'','string');
		$this->setIsNew(1,'','string');
		$this->setIsDraft(0,'','string');
		$this->setIsUpdate(0,'','string');
		$this->setIsActive(1,'','string');
		$this->setIsDelete(0,'','string');
		$this->setIsApproved(0,'','string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	public function update()
	{
		$this->setIsDefault(0,'','string');
		$this->setIsNew(0,'','string');
		$this->setIsDraft(0,'','string');
		$this->setIsUpdate(1,'','string');
		$this->setIsActive(1,'','string');
		$this->setIsDelete(0,'','string');
		$this->setIsApproved(0,'','string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	public function delete()
	{
		$this->setIsDefault(0,'','string');
		$this->setIsNew(0,'','string');
		$this->setIsDraft(0,'','string');
		$this->setIsUpdate(0,'','string');
		$this->setIsActive(0,'','string');
		$this->setIsDelete(1,'','string');
		$this->setIsApproved(0,'','string');
	}
	/**
	 * Update folder Table Status
	 */
	public function updateStatus() {
		if(!(is_array($_GET['isDefault']))) {
			$this->setIsDefault(0,'','string');
		}
		if(!(is_array($_GET['isNew']))) {
			$this->setIsNew(0,'','string');
		}
		if(!(is_array($_GET['isDraft']))) {
			$this->setIsDraft(0,'','string');
		}
		if(!(is_array($_GET['isUpdate']))) {
			$this->setIsUpdate(0,'','string');
		}
		if(!(is_array($_GET['isDelete']))) {

			$this->setIsDelete(1,'','string');
		}
		if(!(is_array($_GET['isActive']))) {
			$this->setIsActive(0,'','string');
		}

		if(!(is_array($_GET['isApproved']))) {
			$this->setIsApproved(0,'','string');
		}
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
	public function setFolderId($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->folderId = $value;
		} else if ($type=='array'){
			$this->folderId[$key]=$value;
		}
	}
	/**
	 * Return folder indentication Value
	 * @return integer folderId
	 */
	public function getFolderId($key=NULL,$type=NULL) {
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
	 * Set tab indentification  Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setTabId() {

			$this->tabId = $value;

	}
	/**
	 * Return folder indentication Value
	 * @return integer folderId
	 */
	public function getTabId() {

			return $this->tabId;

	}
/**
	 * Set icon indentification  Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIconId() {

			$this->iconId = $value;

	}
	/**
	 * Return folder indentication Value
	 * @return integer folderId
	 */
	public function getIconId() {

			return $this->IconId;

	}
/**
	 * Set Folder Sequence Value (english)
	 * @param numeric $value
	 */
	public function setfolderSequence($value) {
		$this->folderSequence = $value;
	}
	/**
	 * Return folder Sequence
	 * @return numeric folder description
	 */
	public function getfolderSequence() {
		return $this->folderSequence;
	}
/**
	 * Set Folder Path
	 * @param string $value
	 */
	public function setFolderPath($value) {
		$this->folderPath = $value;
	}
	/**
	 * Return folder Path
	 * @return string folder description
	 */
	public function getfolderPath() {
		return $this->folderPath;
	}
	/**
	 * Set Folder Note Value (english)
	 * @param string $value
	 */
	public function setfolderNote($value) {
		$this->folderNote = $value;
	}
	/**
	 * Return folder Description (english)
	 * @return string folder description
	 */
	public function getfolderNote() {
		return $this->folderNote;
	}
	/**
	 * Set isDefault Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsDefault($value,$key=NULL,$type=NULL) {
		if($type=='string'){

			$this->isDefault = $value;
		} else if ($type=='array') {

			$this->isDefault[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isDefault Value
	 * @param numeric $key  Array as value
	 *  @param enum   $type   1->string,2->array
	 * @return boolean isDefault
	 */
	public function getIsDefault($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isDefault;
		} else if ($type=='array'){

			return $this->isDefault[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}

	/**
	 * Set isNew value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsNew($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isNew = $value;
		} else if ($type=='array'){
			$this->isNew[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isNew value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isNew
	 */
	public function getIsNew($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isNew;
		} else if ($type=='array'){
			return $this->isNew[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}

	/**
	 * Set IsDraft Value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @param boolean $value
	 */
	public function setIsDraft($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isDraft = $value;
		} elseif ($type=='array'){
			$this->isDraft[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isDraftValue
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isDraft
	 */
	public function getIsDraft($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isDraft;
		} else if ($type=='array'){
			return $this->isDraft[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}

	/**
	 * Set isUpdate Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsUpdate($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isUpdate = $value;
		} elseif ($type=='array'){
			$this->isUpdate[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isUpdate Value
	 * @return boolean isUpdate
	 */
	public function getIsUpdate($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isUpdate;
		} else if ($type=='array'){
			return $this->isUpdate[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set isDelete Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsDelete($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isDelete = $value;
		} elseif ($type=='array'){

			$this->isDelete[$key]=$value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}

	}
	/**
	 * Return isDelete Value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isDelete
	 */
	public function getIsDelete($key=NULL,$type=NULL) {
		if($type=='string'){

			return $this->isDelete;
		} else if ($type=='array'){

			return $this->isDelete[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set isActive Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsActive($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isActive = $value;
		} elseif ($type=='array'){
			$this->isActive[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}

	}
	/**
	 * Return isActive value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isActive
	 */
	public function getIsActive($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isActive;
		} else if ($type=='array'){
			return $this->isActive[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}



	/**
	 * Set isApproved Value
	 * @param boolean $value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIsApproved($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->isApproved = $value;
		} elseif ($type=='array'){
			$this->isApproved[$key]=$value;
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Return isApproved Value
	 * @param numeric $key  Array as value
	 * @param enum   $type   1->string,2->array
	 * @return boolean isApproved
	 */
	public function getIsApproved($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->isApproved;
		} else if ($type=='array'){
			return $this->isApproved[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}

	/**
	 * Set Activity User
	 * @param integer $value
	 */
	public function setBy($value) {
		$this->isBy = $value;
	}
	/**
	 * Get Activity User
	 * @return integer User
	 */
	public function getBy() {
		return $this->isBy;
	}

	/**
	 * Set Time Activity User
	 * @param date $value
	 */
	public function setTime($value) {
		$this->isTime = $value;
	}
	/**
	 *  Return Time Activity User
	 *  @return date Time Activity User
	 */
	public function getTime() {
		return $this->isTime;
	}

	/**
	 * Set All folder Identification Array To Sql Statement
	 * @param string $value
	 */
	public function setFolderIdAll($value){
		$this->folderIdAll= $value;
	}
	/**
	 * Return folder Identification Array
	 * @return string $folderIdAll
	 */
	public function getFolderIdAll() {
		return $this->FolderIdAll;
	}
	public function setTotal($value){
		$this->total = $value;
	}
	public function getTotal(){
		return $this->total;
	}

}
?>