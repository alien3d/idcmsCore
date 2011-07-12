<?php require_once("../../class/classValidation.php");

/**
 * this is leaf model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @category IDCMS
 * @package security
 * @subpackage leaf
 * @copyright IDCMS
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafModel extends validationClass{

	private $leafId;
	private $leafCategoryId;
	private $tabId;
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
		 *  Basic Information Table
		 */
		$this->setTableName('leaf');
		$this->setPrimaryKeyName('leafId');

		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['leafId'])){
			$this->setLeafId($this->strict($_POST['leafId'],'numeric'),'','single');
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

		$this->setTotal(count($_GET['leafId']));
        $accessArray = array(
            "isDefault",
            "isNew",
            "isDraft",
            "isUpdate",
            "isDelete",
            "isActive",
            "isApproved"
        );
        // auto assign as array if true
        if (is_array($_GET['isDefault'])) {
            $this->isDefault = array();
        }
        if (is_array($_GET['isNew'])) {
            $this->isNew = array();
        }
        if (is_array($_GET['isDraft'])) {
            $this->isDraft = array();
        }
        if (is_array($_GET['isUpdate'])) {
            $this->isUpdate = array();
        }
        if (is_array($_GET['isDelete'])) {
            $this->isDelete = array();
        }
        if (is_array($_GET['isActive'])) {
            $this->isActive = array();
        }
        if (is_array($_GET['isApproved'])) {
            $this->isApproved = array();
        }
        for ($i = 0; $i < $this->getTotal(); $i++) {
                $this->setLeafId($this->strict($_GET['leafId'][$i], 'numeric'), $i, 'array');
            if ($_GET['isDefault'][$i] == 'true') {
                $this->setIsDefault(1, $i, 'array');
            } else if ($_GET['default'] == 'false') {
                $this->setIsDefault(0, $i, 'array');
            }
            if ($_GET['isNew'][$i] == 'true') {
                $this->setIsNew(1, $i, 'array');
            } else {
                $this->setIsNew(0, $i, 'array');
            }
            if ($_GET['isDraft'][$i] == 'true') {
                $this->setIsDraft(1, $i, 'array');
            } else {
                $this->setIsDraft(0, $i, 'array');
            }
            if ($_GET['isUpdate'][$i] == 'true') {
                $this->setIsUpdate(1, $i, 'array');
            } else {
                $this->setIsUpdate(0, $i, 'array');
            }
            if ($_GET['isDelete'][$i] == 'true') {
                $this->setIsDelete(1, $i, 'array');
            } else if ($_GET['isDelete'][$i] == 'false') {
                $this->setIsDelete(0, $i, 'array');
            }
            if ($_GET['isActive'][$i] == 'true') {
                $this->setIsActive(1, $i, 'array');
            } else {
                $this->setIsActive(0, $i, 'array');
            }
            if ($_GET['isApproved'][$i] == 'true') {
                $this->setIsApproved(1, $i, 'array');
            } else {
                $this->setIsApproved(0, $i, 'array');
            }

            $primaryKeyAll .= $this->getLeafId($i, 'array') . ",";
        }
        $this->setPrimaryKeyAll((substr($primaryKeyAll, 0, -1)));


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



	/**
	 * Set Leaf Identification  Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setLeafId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
			$this->leafId = $value;
		} else if ($type=='array'){
			$this->leafId[$key]=$value;
		}
	}
	/**
	 * Return Leaf Identication Value
	 * @return integer $leafId
	 */
	public function getLeafId($key=NULL,$type=NULL) {
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
	 * Set Tab/Accordion Identification  Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setTabId($value) {
			$this->tabId = $value;

	}
	/**
	 * Return Tab/Accordion Identication Value
	 * @return integer $tabId
	 */
	public function getTabId() {

		return $this->tabId;

	}
	/**
	 * Set Folder Identification  Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setFolderId($value) {

		$this->folderId = $value;

	}
	/**
	 * Return Folder Identication Value
	 * @return integer folderId
	 */
	public function getFolderId() {

		return $this->folderId;

	}
	/**
	 * Set Icon Identification  Value
	 * @param integer $value
	 * @param integer $key  Array as value
	 * @param enum   $type   1->string,2->array
	 */
	public function setIconId($value) {

		$this->iconId = $value;

	}
	/**
	 * Return Icon Identification Value
	 * @return integer $iconId
	 */
	public function getIconId() {

		return $this->iconId;

	}
	/**
	 * Set Leaf Code Value
	 * @param string $leafCode
	 */
	public function setLeafCode($value) {
		$this->leafCode = $value;
	}
	/**
	 * Return Leaf Code
	 * @return numeric $folderCode
	 */
	public function getLeafCode() {
		return $this->leafCode;
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
	 * @return numeric $leafSequence
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