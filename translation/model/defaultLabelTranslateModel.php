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
	public function setdefaultLabelTranslateId($value,$key=NULL,$type=NULL) {
		if($type=='single'){
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
		if($type=='single'){
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