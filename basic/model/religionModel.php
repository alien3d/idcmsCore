<?php
require_once("../../class/classValidation.php");
/**
 * this is religion model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package religion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class religionModel extends validationClass
{

	// table field
	private $religionId;
	private $religionDesc;

	/* (non-PHPdoc)
	 * @see validationClass::execute()
	 */
	public function execute()
	{
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('religion');
		$this->setPrimaryKeyName('religionId');
		/*
		 * SET ALL OUTSIDE VARIABLE FROM POST OR GET OR PUT OR DELETE
		 * Restfull Format  POST 			-->Is to View Data
		 *                  GET  			-->Is to Receive Data
		 *                  PUT  			-->Is To Update Data
		 *                  DELETE/Destroy  -->Is To Delete/Destroy Data
		 */
		if (isset($_POST['religionId'])) {
			$this->setReligionId($this->strict($_POST['religionId'], 'numeric'),0,'single');
		}
		if (isset($_POST['religionDesc'])) {
			$this->setReligionDesc($this->strict($_POST['religionDesc'], 'memo'));
		}
		/**
		 *      Don't change below code
		 **/
		if (isset($_SESSION['staffId'])) {
			$this->setExecuteBy($_SESSION['staffId']);
		}

		if ($this->getVendor()==self::mysql) {
			$this->setExecuteTime("\"" . date("Y-m-d H:i:s") . "\"");
		} else if ($this->getVendor()==self::mssql) {
			$this->setExecuteTime("\"" . date("Y-m-d H:i:s") . "\"");
		} else if ($this->getVendor()==self::oracle) {
			$this->setExecuteTime("to_date(\"" . date("Y-m-d H:i:s") . "\",'YYYY-MM-DD HH24:MI:SS')");
		}
                
		// updateStatus
		//	echo "Jumlah record ".count($_GET['religionId']);
		$this->setTotal(count($_GET['religionId']));
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
            	$this->setReligionId($this->strict($_GET['religionId'][$i], 'numeric'), $i, 'array');
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
            	$primaryKeyAll .= $this->getReligionId($i, 'array') . ",";
            }
            $this->setPrimaryKeyAll((substr($primaryKeyAll, 0, -1)));
	}
	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	public function create()
	{
		$this->setIsDefault(0,0,'single');
		$this->setIsNew(1,0,'single');
		$this->setIsDraft(0,0,'single');
		$this->setIsUpdate(0,0,'single');
		$this->setIsActive(1,0,'single');
		$this->setIsDelete(0,0,'single');
		$this->setIsApproved(0,0,'single');
	}
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	public function update()
	{
		$this->setIsDefault(0,0,'single');
		$this->setIsNew(0,0,'single');
		$this->setIsDraft(0,0,'single');
		$this->setIsUpdate(1, '', 'string');
		$this->setIsActive(1,0,'single');
		$this->setIsDelete(0,0,'single');
		$this->setIsApproved(0,0,'single');
	}
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	public function delete()
	{
		$this->setIsDefault(0,0,'single');
		$this->setIsNew(0,0,'single');
		$this->setIsDraft(0,0,'single');
		$this->setIsUpdate(0,0,'single');
		$this->setIsActive(0, '', 'string');
		$this->setIsDelete(1, '', 'string');
		$this->setIsApproved(0,0,'single');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function draft()
	{
		$this->setIsDefault(0,0,'single');
		$this->setIsNew(1,0,'single');
		$this->setIsDraft(1,0,'single');
		$this->setIsUpdate(0,0,'single');
		$this->setIsActive(0,0,'single');
		$this->setIsDelete(0,0,'single');
		$this->setIsApproved(0,0,'single');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function approved()
	{
		$this->setIsDefault(0,0,'single');
		$this->setIsNew(1,0,'single');
		$this->setIsDraft(0,0,'single');
		$this->setIsUpdate(0,0,'single');
		$this->setIsActive(0,0,'single');
		$this->setIsDelete(0,0,'single');
		$this->setIsApproved(1,0,'single');
	}
	/**
	 * Update Religion Table Status
	 */
	public function updateStatus()
	{
		if (!(is_array($_GET['isDefault']))) {
			$this->setIsDefault(0,0,'single');
		}
		if (!(is_array($_GET['isNew']))) {
			$this->setIsNew(0,0,'single');
		}
		if (!(is_array($_GET['isDraft']))) {
			$this->setIsDraft(0,0,'single');
		}
		if (!(is_array($_GET['isUpdate']))) {
			$this->setIsUpdate(0,0,'single');
		}
		if (!(is_array($_GET['isDelete']))) {
			$this->setIsDelete(1, '', 'string');
		}
		if (!(is_array($_GET['isActive']))) {
			$this->setIsActive(0, '', 'string');
		}
		if (!(is_array($_GET['isApproved']))) {
			$this->setIsApproved(0,0,'single');
		}
	}
	/**
	 * Set Religion Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setReligionId($value, $key, $type)
	{
		if ($type=='single') {
			$this->religionId = $value;
		} else if ($type == 'array') {
			$this->religionId[$key] = $value;
		}else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:setReligionId ?"));
			exit();
		}
	}
	/**
	 * Return Religion Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getReligionId($key, $type)
	{
		if ($type=='single') {
			return $this->religionId;
		} else if ($type == 'array') {
			return $this->religionId[$key];
		} else {
			echo json_encode(array("success"=>false,"message"=>"Cannot Identifiy Type String Or Array:getReligionId ?"));
			exit();
		}
	}
	/**
	 * Set Religion Description Value
	 * @param string $value
	 */
	public function setReligionDesc($value)
	{
		$this->religionDesc = $value;
	}
	/**
	 * Return Religion Description
	 * @return string
	 */
	public function getReligionDesc()
	{
		return $this->religionDesc;
	}
}
?>
