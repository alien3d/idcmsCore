<?php
require_once ("../../class/classValidation.php");
/**
 * this is religion Detail model file (Master And Detail Concept).This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package religionDetail
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ReligionDetailModel extends ValidationClass
{
    /**
     * @var int
     */
    private $religionDetailId;
    /**
     * @var int
     */
    private $religionId;
    /**
     * @var string
     */
    private $religionDetailTitle;
    /**
     * @var string
     */
    private $religionDetailDesc;
    /* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */
    public function execute ()
    {
        /*
		 *  Basic Information Table
		 */
        $this->setTableName('religionDetail');
        $this->setPrimaryKeyName('religionDetailId');
        $this->setMasterForeignKeyName('religionId');
        /*
		 * SET ALL OUTSIDE VARIABLE FROM POST OR GET OR PUT OR DELETE
		 * Restfull Format  POST 			-->Is to View Data
		 *                  GET  			-->Is to Receive Data
		 *                  PUT  			-->Is To Update Data
		 *                  DELETE/Destroy  -->Is To Delete/Destroy Data
		 */
        if (isset($_POST['religionDetailId'])) {
            $this->setReligionDetailId(
            $this->strict($_POST['religionDetailId'], 'numeric'), 0, 'single');
        }
        if (isset($_POST['religionId'])) {
            $this->setReligionId($this->strict($_POST['religionId'], 'numeric'));
        }
        if (isset($_POST['religionDetailTitle'])) {
            $this->setReligionDetailTitle(
            $this->strict($_POST['religionDetailTitle'], 'memo'));
        }
        if (isset($_POST['religionDetailDesc'])) {
            $this->setReligionDetailDesc(
            $this->strict($_POST['religionDetailDesc'], 'memo'));
        }
        /**
         * Don't change below code
         **/
        if (isset($_SESSION['staffId'])) {
            $this->setExecuteBy($_SESSION['staffId']);
        }
        if ($this->getVendor() == self::mysql) {
            $this->setExecuteTime("\"" . date("Y-m-d H:i:s") . "\"");
        } else 
            if ($this->getVendor() == self::mssql) {
                $this->setExecuteTime("'" . date("Y-m-d H:i:s.u") . "'");
            } else 
                if ($this->getVendor() == self::oracle) {
                    $this->setExecuteTime(
                    "to_date(\"" . date("Y-m-d H:i:s") .
                     "\",'YYYY-MM-DD HH24:MI:SS')");
                }
        if (isset($_GET['religionDetailId'])) {
            $this->setTotal(count($_GET['religionDetailId']));
        }
        $accessArray = array("isDefault", "isNew", "isDraft", "isUpdate", 
        "isDelete", "isActive", "isApproved", "isReview", "isPost");
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
        for ($i = 0; $i < $this->getTotal(); $i ++) {
            if (isset($_GET['religionDetailId'])) {
                $this->setReligionDetailId(
                $this->strict($_GET['religionDetailId'][$i], 'numeric'), $i, 
                'array');
            }
            if (isset($_GET['isDefault'])) {
                if ($_GET['isDefault'][$i] == 'true') {
                    $this->setIsDefault(1, $i, 'array');
                } else 
                    if ($_GET['default'] == 'false') {
                        $this->setIsDefault(0, $i, 'array');
                    }
            }
            if (isset($_GET['isNew'])) {
                if ($_GET['isNew'][$i] == 'true') {
                    $this->setIsNew(1, $i, 'array');
                } else {
                    $this->setIsNew(0, $i, 'array');
                }
            }
            if (isset($_GET['isDraft'])) {
                if ($_GET['isDraft'][$i] == 'true') {
                    $this->setIsDraft(1, $i, 'array');
                } else {
                    $this->setIsDraft(0, $i, 'array');
                }
            }
            if (isset($_GET['isUpdate'])) {
                if ($_GET['isUpdate'][$i] == 'true') {
                    $this->setIsUpdate(1, $i, 'array');
                } else {
                    $this->setIsUpdate(0, $i, 'array');
                }
            }
            if (isset($_GET['isDelete'])) {
                if ($_GET['isDelete'][$i] == 'true') {
                    $this->setIsDelete(1, $i, 'array');
                } else 
                    if ($_GET['isDelete'][$i] == 'false') {
                        $this->setIsDelete(0, $i, 'array');
                    }
            }
            if (isset($_GET['isActive'])) {
                if ($_GET['isActive'][$i] == 'true') {
                    $this->setIsActive(1, $i, 'array');
                } else {
                    $this->setIsActive(0, $i, 'array');
                }
            }
            if (isset($_GET['isApproved'])) {
                if ($_GET['isApproved'][$i] == 'true') {
                    $this->setIsApproved(1, $i, 'array');
                } else 
                    if ($_GET['isApproved'][$i] == 'false') {
                        $this->setIsApproved(0, $i, 'array');
                    }
            }
            if (isset($_GET['isReview'])) {
                if ($_GET['isReview'][$i] == 'true') {
                    $this->setIsReview(1, $i, 'array');
                } else 
                    if ($_GET['isReview'][$i] == 'false') {
                        $this->setIsReview(0, $i, 'array');
                    }
            }
            if (isset($_GET['isPost'])) {
                if ($_GET['isPost'][$i] == 'true') {
                    $this->setIsPost(1, $i, 'array');
                } else 
                    if ($_GET['isPost'][$i] == 'false') {
                        $this->setIsPost(0, $i, 'array');
                    }
            }
            $primaryKeyAll .= $this->getReligionDetailId($i, 'array') . ",";
        }
        $this->setPrimaryKeyAll((substr($primaryKeyAll, 0, - 1)));
    }
    /* (non-PHPdoc)
	 * @see ValidationClass::create()
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
	 * @see ValidationClass::update()
	 */
    public function update ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(0, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(1, '', 'single');
        $this->setIsActive(1, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
    }
    /* (non-PHPdoc)
	 * @see ValidationClass::delete()
	 */
    public function delete ()
    {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(0, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(0, '', 'string');
        $this->setIsDelete(1, '', 'string');
        $this->setIsApproved(0, 0, 'single');
    }
    /* (non-PHPdoc)
	 * @see ValidationClass::draft()
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
	 * @see ValidationClass::draft()
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
     * @see ValidationClass::review()
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
    * @see ValidationClass::post()
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
     * Update Religion Table Status
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
            $this->setIsDelete(1, '', 'string');
        }
        if (! (is_array($_GET['isActive']))) {
            $this->setIsActive(0, '', 'string');
        }
        if (! (is_array($_GET['isApproved']))) {
            $this->setIsApproved(0, 0, 'single');
        }
    }
    /**
     * Set Religion Detail Identification  Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setReligionDetailId ($value, $key, $type)
    {
        if ($type == 'single') {
            $this->religionDetailId = $value;
        } else 
            if ($type == 'array') {
                $this->religionDetailId[$key] = $value;
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:setReligionDetailId ?"));
                exit();
            }
    }
    /**
     * Return Religion Identification  Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return bool|array
     */
    public function getReligionDetailId ($key, $type)
    {
        if ($type == 'single') {
            return $this->religionDetailId;
        } else 
            if ($type == 'array') {
                return $this->religionDetailId[$key];
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:getReligionDetailId ?"));
                exit();
            }
    }
    /**
     * Set Religion Identification Value
     * @param int $value
     */
    public function setReligionId ($value)
    {
        $this->religionId = $value;
    }
    /**
     * Return Religion Identification
     * @return int
     */
    public function getReligionId ()
    {
        return $this->religionId;
    }
    /**
     * Set Religion Title Value
     * @param string $value
     */
    public function setReligionDetailTitle ($value)
    {
        $this->religionDetailTitle = $value;
    }
    /**
     * Return Religion Title
     * @return string
     */
    public function getReligionDetailTitle ()
    {
        return $this->religionDetailTitle;
    }
    /**
     * Set Religion Description Value
     * @param string $value
     */
    public function setReligionDetailDesc ($value)
    {
        $this->religionDetailDesc = $value;
    }
    /**
     * Return Religion Description
     * @return string
     */
    public function getReligionDetailDesc ()
    {
        return $this->religionDetailDesc;
    }
}
?>
