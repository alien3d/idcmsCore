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
		 *  Basic Information Table
		 */
		$this->setTableName('defaultLabel');
		$this->setPrimaryKeyName('defaultLabelId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['defaultLabelId'])){
			$this->setdefaultLabelId($this->strict($_POST['defaultLabelId'],'numeric'),'','single');
		}
		if(isset($_POST['defaultLabelSequence'])){
			$this->setdefaultLabelSequence($this->strict($_POST['defaultLabelSequence'],'memo'));
		}
		if(isset($_POST['defaultLabelCode'])){
			$this->setdefaultLabelCode($this->strict($_POST['defaultLabelCode'],'memo'));
		}
		if(isset($_POST['defaultLabelNote'])){
			$this->setdefaultLabelNote($this->strict($_POST['defaultLabelNote'],'memo'));
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

		$this->setTotal(count($_GET['defaultLabelId']));
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
        if(is_array($_GET['defaultLabelId'])){
        	$this->defaultLabelId= array();
        }
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
            $this->setdefaultLabelId($this->strict($_GET['defaultLabelId'][$i], 'numeric'), $i, 'array');
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
            $primaryKeyAll .= $this->getDefaultLabelId($i, 'array') . ",";
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
	}
	public function setDefaultLabelId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
			$this->defaultLabelId = $value;
		} else if ($type=='array'){
			$this->defaultLabelId[$key]=$value;
		}
	}
	/**
	 * Return defaultLabelId Value
	 * @return integer defaultLabelId
	 */
	public function getDefaultLabelId($key=NULL,$type=NULL) {
		if($type=='single'){
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