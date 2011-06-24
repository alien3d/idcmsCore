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
            $this->setReligionId($this->strict($_POST['religionId'], 'numeric'), '', 'string');
        }
        if (isset($_POST['religionDesc'])) {
            $this->setReligionDesc($this->strict($_POST['religionDesc'], 'memo'));
        }
        /**
         *      Don't change below code
         **/
        if (isset($_SESSION['staffId'])) {
            $this->setBy($_SESSION['staffId']);
        }

        if ($this->getVendor()==self::mysql) {
            $this->setTime("\"" . date("Y-m-d H:i:s") . "\"");
        } else if ($this->getVendor()==self::mssql) {
            $this->setTime("\"" . date("Y-m-d H:i:s") . "\"");
        } else if ($this->getVendor()==self::oracle) {
            $this->setTime("to_date(\"" . date("Y-m-d H:i:s") . "\",'YYYY-MM-DD HH24:MI:SS')");
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
        $this->setIsDefault(0, '', 'string');
        $this->setIsNew(1, '', 'string');
        $this->setIsDraft(0, '', 'string');
        $this->setIsUpdate(0, '', 'string');
        $this->setIsActive(1, '', 'string');
        $this->setIsDelete(0, '', 'string');
        $this->setIsApproved(0, '', 'string');
    }
    /* (non-PHPdoc)
     * @see validationClass::update()
     */
    public function update()
    {
        $this->setIsDefault(0, '', 'string');
        $this->setIsNew(0, '', 'string');
        $this->setIsDraft(0, '', 'string');
        $this->setIsUpdate(1, '', 'string');
        $this->setIsActive(1, '', 'string');
        $this->setIsDelete(0, '', 'string');
        $this->setIsApproved(0, '', 'string');
    }
    /* (non-PHPdoc)
     * @see validationClass::delete()
     */
    public function delete()
    {
        $this->setIsDefault(0, '', 'string');
        $this->setIsNew(0, '', 'string');
        $this->setIsDraft(0, '', 'string');
        $this->setIsUpdate(0, '', 'string');
        $this->setIsActive(0, '', 'string');
        $this->setIsDelete(1, '', 'string');
        $this->setIsApproved(0, '', 'string');
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
     * Update Religion Table Status
     */
    public function updateStatus()
    {
        if (!(is_array($_GET['isDefault']))) {
            $this->setIsDefault(0, '', 'string');
        }
        if (!(is_array($_GET['isNew']))) {
            $this->setIsNew(0, '', 'string');
        }
        if (!(is_array($_GET['isDraft']))) {
            $this->setIsDraft(0, '', 'string');
        }
        if (!(is_array($_GET['isUpdate']))) {
            $this->setIsUpdate(0, '', 'string');
        }
        if (!(is_array($_GET['isDelete']))) {
            $this->setIsDelete(1, '', 'string');
        }
        if (!(is_array($_GET['isActive']))) {
            $this->setIsActive(0, '', 'string');
        }
        if (!(is_array($_GET['isApproved']))) {
            $this->setIsApproved(0, '', 'string');
        }
    }
    /**
     * Set isDefault Value
     * @param integer $value
     * @param integer $key  Array as value
     * @param enum   $type   1->string,2->array
     */
    public function setReligionId($value, $key = NULL, $type = NULL)
    {
        if ($type == 'string') {
            $this->religionId = $value;
        } else if ($type == 'array') {
            $this->religionId[$key] = $value;
        }
    }
    /**
     * Return isReligionId Value
     * @return integer religionId
     */
    public function getReligionId($key = NULL, $type = NULL)
    {
        if ($type == 'string') {
            return $this->religionId;
        } else if ($type == 'array') {
            return $this->religionId[$key];
        } else {
            echo json_encode(array(
                "success" => false,
                "message" => "Cannot Identifiy Type"
            ));
            exit();
        }
    }
    /**
     * Set isDefault Value
     * @param string $value
     */
    public function setReligionDesc($value)
    {
        $this->religionDesc = $value;
    }
    /**
     * Return Religion Description
     * @return string religion description
     */
    public function getReligionDesc()
    {
        return $this->religionDesc;
    }
}
?>
