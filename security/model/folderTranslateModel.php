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


	// table field
	private $folderId;
	private $tabId;
	private $iconId;
	private $folderSequence;
	private $folderPath;
	private $folderNote;

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
		if($this->getVendor()==self::mysql){
			$this->setTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::mssql){
			$this->setTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::oracle){
			$this->setTime("to_date(\"".date("Y-m-d H:i:s")."\",'YYYY-MM-DD HH24:MI:SS')");
		}


	}


	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	public function create()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(1,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(1,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(0,0,'string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	public function update()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(0,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(1,0,'string');
		$this->setIsActive(1,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(0,0,'string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	public function delete()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(0,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(0,0,'string');
		$this->setIsDelete(1,0,'string');
		$this->setIsApproved(0,0,'string');
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
	 * Update folder Table Status
	 */
	public function updateStatus() {
		if(!(is_array($_GET['isDefault']))) {
			$this->setIsDefault(0,0,'string');
		}
		if(!(is_array($_GET['isNew']))) {
			$this->setIsNew(0,0,'string');
		}
		if(!(is_array($_GET['isDraft']))) {
			$this->setIsDraft(0,0,'string');
		}
		if(!(is_array($_GET['isUpdate']))) {
			$this->setIsUpdate(0,0,'string');
		}
		if(!(is_array($_GET['isDelete']))) {

			$this->setIsDelete(1,0,'string');
		}
		if(!(is_array($_GET['isActive']))) {
			$this->setIsActive(0,0,'string');
		}

		if(!(is_array($_GET['isApproved']))) {
			$this->setIsApproved(0,0,'string');
		}
	}



	/**
	 * Set folder indentification  Value
	 * @param int $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setFolderId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
			$this->folderId = $value;
		} else if ($type=='array'){
			$this->folderId[$key]=$value;
		}
	}
	/**
	 * Return folder Identification Value
	 * @return integer folderId
	 */
	public function getFolderId($key=NULL,$type=NULL) {
		if($type=='single'){
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
	 * @param int $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setTabId() {

			$this->tabId = $value;

	}
	/**
	 * Return folder Identification Value
	 * @return integer folderId
	 */
	public function getTabId() {

			return $this->tabId;

	}
/**
	 * Set icon indentification  Value
	 * @param int $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setIconId() {

			$this->iconId = $value;

	}
	/**
	 * Return folder Identification Value
	 * @return integer folderId
	 */
	public function getIconId() {

			return $this->IconId;

	}
/**
	 * Set Folder Sequence Value (english)
	 * @param  int $value
	 */
	public function setfolderSequence($value) {
		$this->folderSequence = $value;
	}
	/**
	 * Return folder Sequence
	 * @return int folder description
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


}
?>