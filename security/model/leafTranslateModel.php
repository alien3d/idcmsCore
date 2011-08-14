<?php require_once("../../class/classValidation.php");

/**
 * this is Leaf Translation model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @category IDCMS
 * @package security
 * @subpackage Leaf Translation
 * @copyright IDCMS
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafTranslationModel extends validationClass{

	private $leafId;
	private $moduleId;
	private $folderId;
	private $iconId;
	private $leafSequence;
	private $leafCode;
	private $leafFilename;
	private $leafNote;


	/* (non-PHPdoc)
	 * @see validationClass::execute()
	 */
	function execute(){

		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['leafId'])){
			$this->setLeafId($this->strict($_POST['leafId'],'numeric'));
		}
		if(isset($_POST['tabId'])){
			$this->setTabId($this->strict($_POST['tabId'],'numeric'));
		}
		if(isset($_POST['folderId'])){
			$this->setFolderId($this->strict($_POST['folderId'],'numeric'));
		}
		if(isset($_POST['iconId'])){
			$this->setIconId($this->strict($_POST['iconId'],'numeric'));
		}
		if(isset($_POST['leafSequence'])){
			$this->setLeafSequence($this->strict($_POST['leafSequence'],'numeric'));
		}
		if(isset($_POST['leafFilename'])){
			$this->setLeafFilename($this->strict($_POST['leafFilename'],'memo'));
		}

		if(isset($_POST['leafNote'])){
			$this->setLeafNote($this->strict($_POST['leafNote'],'memo'));
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


	}

	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	function create() {
		$this->isDefaut 	=	0;
		$this->isNew 		=	1;
		$this->isDraft		=	0;
		$this->isUpdate		=	0;
		$this->isActive		=	1;
		$this->isDelete		=	0;
		$this->isApproved	=	0;

	}

	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	function update() {
		$this->isDefaut 	=	0;
		$this->isNew 		=	0;
		$this-> isDraft		=	0;
		$this->isUpdate	=	1;
		$this->isActive	=	1;
		$this->isDelete	=	0;
		$this->isApproved	=	0;
	}

	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	function delete() {
		$this->isDefaut 	=	0;
		$this->isNew 		=	0;
		$this->isDraft		=	0;
		$this->isUpdate		=	0;
		$this->isActive		=	0;
		$this->isDelete		=	1;
		$this->isApproved	=	0;
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
	 * Set Leaf Identification  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafId($value,$key,$type) {
		if($type=='single'){
			$this->leafId = $value;
		} else if ($type=='array'){
			$this->leafId[$key]=$value;
		}
	}
	/**
	 * Return Leaf Identication Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafId($key,$type) {
		if($type=='single'){
			return $this->leafId;
		} else if ($type=='array'){
			return $this->leafId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type"));
			exit();
		}
	}
	/**
	 * Set Module Identification  Value
	 * @param int $value
	 */
	public function setTabId() {

		$this->moduleId = $value;

	}
	/**
	 * Return Module Identication Value
	 * @return int
	 */
	public function getTabId() {

		return $this->moduleId;

	}
	/**
	 * Set Folder Identification  Value
	 * @param int $value
	 */
	public function setFolderId() {

		$this->folderId = $value;

	}
	/**
	 * Return Folder Identication Value
	 * @return int
	 */
	public function getFolderId() {

		return $this->folderId;

	}
	/**
	 * Set Icon Identification  Value
	 * @param int $value
	 */
	public function setIconId() {

		$this->iconId = $value;

	}
	/**
	 * Return Icon Identification Value
	 * @return int
	 */
	public function getIconId() {

		return $this->iconId;

	}
	/**
	 * Set Leaf Sequence Value
	 * @param numeric $leafSequence
	 */
	public function setLeafSequence($value) {
		$this->leafSequence = $value;
	}
	/**
	 * Return Leaf Sequence
	 * @return int $folderSequence
	 */
	public function getLeafSequence() {
		return $this->leafSequence;
	}
	/**
	 * Set Leaf Application
	 * @param string $value
	 */
	public function setLeafFilename($value) {
		$this->leafFilename = $value;
	}
	/**
	 * Return Leaf /Application
	 * @return string leaf /Application
	 */
	public function getLeafFilename() {
		return $this->leafFilename;
	}
	/**
	 * Set Leaf/Application Note (English Translation Value
	 * @param string $value
	 */
	public function setLeafNote($value) {
		$this->leafNote = $value;
	}
	/**
	 * Return Leaf/Application Note (English Translation Default)
	 * @return string folder Note
	 */
	public function getLeafNote() {
		return $this->leafNote;
	}

}
?>