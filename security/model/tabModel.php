<?php require_once("../../class/classValidation.php");

/**
 * this is tab model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package tab
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class tabModel extends validationClass{

	private $tabId;
	private $tabSequence;
	private $iconId;
	private $tabNote;

	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('tab');
		$this->setPrimaryKeyName('tabId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['tabId'])){
			$this->setTabId($this->strict($_POST['tabId'],'numeric'));
		}
		if(isset($_POST['iconId'])){
			$this->setIconId ($this->strict($_POST['iconId'],'numeric'));
		}

		if(isset($_POST['tabSequence'])){
			$this->setTabSequence($this->strict($_POST['tabSequence'],'numeric'));
		}
		if(isset($_POST['tabNote'])){
			$this->setTabNote($this->strict($_POST['tabNote'],'memo'));
		}
		if(isset($_SESSION['staffId'])){
			$this->setBy($_SESSION['staffId']);
		}
		if($this->vendor=='normal' || $this->vendor=='mysql'){
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
	 * Update tab Table Status
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

	public function setTabId($value,$key=NULL,$type=NULL) {
		if($type=='string'){
			$this->tabId = $value;
		} else if ($type=='array'){
			$this->tabId[$key]=$value;
		}
	}
	/**
	 * Return istabId Value
	 * @return integer tabId
	 */
	public function getTabId($key=NULL,$type=NULL) {
		if($type=='string'){
			return $this->tabId;
		} else if ($type=='array'){
			return $this->tabId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set icon for Tab
	 * @param  numeric $value
	 */
	public function setIconId($value) {
		$this->iconId = $value;
	}
	/**
	 * Return icon for Tab
	 * @return numeric icon for tab
	 */
	public function getIconId() {

		return $this->iconId;
	}
	/**
	 * Set Tab Sequence Value
	 * @param numeric $value
	 */
	public function setTabSequence($value) {
		$this->tabSequence = $value;
	}
	/**
	 * Return tab Sequence Value
	 * @return string tab sequence
	 */
	public function getTabSequence() {
		return $this->tabSequence;
	}
	/**
	 * Set Tab Note Value
	 * @param string $value Tab Note
	 */
	public function setTabNote($value) {
		$this->tabNote = $value;
	}
	/**
	 * Return Tab Note
	 * @return string Tab Note
	 */
	public function getTabNote() {
		return $this->tabNote;
	}

}
?>