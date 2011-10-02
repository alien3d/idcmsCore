<?php

require_once ("../../class/classValidation.php");
/**
 * this is Department model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Management
 * @subpackage Department
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class departmentModel extends validationClass
{
    /**
     * Department Identification
     * @var int
     */
    private $departmentId;
    /**
     * Department Sequence
     * @var int
     */
    private $departmentSequence;
    /**
     * Document Code
     * @var string
     */
    private $departmentCode;
    /**
     * Department Note
     * @var string
     */
    private $departmentNote;
    function execute ()
    {
        /**
         * Basic Information Table
         */
        $this->setTableName('department');
        $this->setPrimaryKeyName('departmentId');
        /*
		 *  All the $_POST enviroment.
		 */
        if (isset($_POST['departmentId'])) {
            $this->setDepartmentId(
            $this->strict($_POST['departmentId'], 'numeric'), 0, 'single');
        }
        if (isset($_POST['departmentSequence'])) {
            $this->setDepartmentSequence(
            $this->strict($_POST['departmentSequence'], 'memo'));
        }
        if (isset($_POST['departmentCode'])) {
            $this->setDepartmentCode(
            $this->strict($_POST['departmentCode'], 'memo'));
        }
        if (isset($_POST['departmentNote'])) {
            $this->setDepartmentNote(
            $this->strict($_POST['departmentNote'], 'memo'));
        }
        if (isset($_SESSION['staffId'])) {
            $this->setExecuteBy($_SESSION['staffId']);
        }
        if ($this->getVendor() == self::mysql) {
            $this->setExecuteTime("\"" . date("Y-m-d H:i:s") . "\"");
        } else 
            if ($this->getVendor() == self::mssql) {
                $this->setExecuteTime("\"" . date("Y-m-d H:i:s") . "\"");
            } else 
                if ($this->getVendor() == self::oracle) {
                    $this->setExecuteTime(
                    "to_date('" . date("Y-m-d H:i:s") .
                     "','YYYY-MM-DD HH24:MI:SS')");
                }
        $this->setTotal(count($_GET['departmentId']));
        $accessArray = array("isDefault", "isNew", "isDraft", "isUpdate", 
        "isDelete", "isActive", "isApproved");
        // auto assign as array if true
        if (is_array($_GET['departmentId'])) {
            $this->departmentId = array();
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
        for ($i = 0; $i < $this->getTotal(); $i ++) {
            $this->setDepartmentId(
            $this->strict($_GET['departmentId'][$i], 'numeric'), $i, 'array');
            if ($_GET['isDefault'][$i] == 'true') {
                $this->setIsDefault(1, $i, 'array');
            } else 
                if ($_GET['default'] == 'false') {
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
            } else 
                if ($_GET['isDelete'][$i] == 'false') {
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
            $primaryKeyAll .= $this->getDepartmentId($i, 'array') . ",";
        }
        $this->setPrimaryKeyAll((substr($primaryKeyAll, 0, - 1)));
    }
    /* (non-PHPdoc)
	 * @see validationClass::create()
	 */
    public function create ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(1, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(1, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
    }
    /* (non-PHPdoc)
	 * @see validationClass::update()
	 */
    public function update ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(0, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(1, 0, 'single');
        $this->setIsActive(1, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
    }
    /* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
    public function delete ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(0, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(0, 0, 'single');
        $this->setIsDelete(1, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
    }
    /* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
    public function draft ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(1, 0, 'single');
        $this->setIsDraft(1, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(0, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
    }
    /* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
    public function approved ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(1, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(0, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(1, 0, 'single');
    }
    /* (non-PHPdoc)
	 * @see validationClass::review()
	*/
    public function review ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(1, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(0, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
        $this->setIsReview(1, 0, 'single');
        $this->setIsPost(0, 0, 'single');
    }
    /* (non-PHPdoc)
	* @see validationClass::post()
	*/
    public function post ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(1, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(0, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(1, 0, 'single');
        $this->setIsReview(0, 0, 'single');
        $this->setIsPost(1, 0, 'single');
    }
    /**
     * Update  Table Status
     */
    public function updateStatus ()
    {
        if (! (is_array($_GET['isDefault']))) {
            $this->setIsDefault(0, 0, 'single');
        }
        if (! (is_array($_GET['isNew']))) {
            $this->setIsNew(0, 0, 'single');
        }
        if (! (is_array($_GET['isDraft']))) {
            $this->setIsDraft(0, 0, 'single');
        }
        if (! (is_array($_GET['isUpdate']))) {
            $this->setIsUpdate(0, 0, 'single');
        }
        if (! (is_array($_GET['isDelete']))) {
            $this->setIsDelete(1, 0, 'single');
        }
        if (! (is_array($_GET['isActive']))) {
            $this->setIsActive(0, 0, 'single');
        }
        if (! (is_array($_GET['isApproved']))) {
            $this->setIsApproved(0, 0, 'single');
        }
    }
    /**
     * Set department Identification  Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setDepartmentId ($value, $key, $type)
    {
        if ($type == 'single') {
            $this->departmentId = $value;
        } else 
            if ($type == 'array') {
                $this->departmentId[$key] = $value;
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:setDepartmentId ?"));
                exit();
            }
    }
    /**
     * Return Department Identification  Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return int|array
     */
    public function getDepartmentId ($key, $type)
    {
        if ($type == 'single') {
            return $this->departmentId;
        } else 
            if ($type == 'array') {
                return $this->departmentId[$key];
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:getDepartmentId ?"));
                exit();
            }
    }
    /**
     * Set  department Sequence
     * @param int $value
     */
    public function setDepartmentSequence ($value)
    {
        $this->departmentSequence = $value;
    }
    /**
     * Return Department  Sequence
     * @return  int
     */
    public function getDepartmentSequence ()
    {
        return $this->departmentSequence;
    }
    /**
     * Set  Department  Code (english)
     * @param string $value
     */
    public function setDepartmentCode ($value)
    {
        $this->departmentCode = $value;
    }
    /**
     * Return Department  Code
     * @return  string
     */
    public function getDepartmentCode ()
    {
        return $this->departmentCode;
    }
    /**
     * Set  Department Description (english)
     * @param string $value
     */
    public function setDepartmentNote ($value)
    {
        $this->departmentNote = $value;
    }
    /**
     * Return Department  Description (english)
     * @return  string
     */
    public function getDepartmentNote ()
    {
        return $this->departmentNote;
    }
}
?>