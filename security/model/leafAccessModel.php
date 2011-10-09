<?php
require_once ("../../class/classValidation.php");
/**
 * this is leaf Access Security model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage Leaf Access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LeafAccessModel extends ValidationClass
{
    /**
     * Leaf Access  Identification
     * @var int
     */
    private $leafAccessId;
    /**
     * Group Identification (** For Filtering Only)
     * @var int
     */
    private $teamId;
    /**
     * Module   Identification (** For Filtering  Only)
     * @var bool
     */
    private $moduleId;
    /**
     * Folder   Identification (** For Filtering Only)
     * @var int
     */
    private $folderId;
    /**
     * Leaf  Identification(** For Filtering only)
     * @var int
     */
    private $leafTempId;
    /**
     * Staff Identification
     * @var int
     */
    private $staffId;
    /**
     * Leaf Create Access Value
     * @var bool
     */
    private $leafAccessCreateValue;
    /**
     * Leaf Read Access Value
     * @var bool
     */
    private $leafAccessReadValue;
    /**
     * Leaf Update Access Value
     * @var bool
     */
    private $leafAccessUpdateValue;
    /**
     * Leaf Delete Access Value
     * @var bool
     */
    private $leafAccessDeleteValue;
    /**
     * Leaf Print Access Value
     * @var bool
     */
    private $leafAccessPrintValue;
    /**
     * Leaf Posting Access Value
     * @var bool
     */
    private $leafAccessPostValue;
    /**
     * Class Loader to load outside variable and test it suppose variable type
     */
    function execute ()
    {
        /*
		 *  Basic Information Table
		 */
        $this->setTableName('leafAccess');
        $this->setPrimaryKeyName('leafAccessId');
        /*
		 *  All the $_POST enviroment.
		 */
        $this->leafAccessId = array();
        $this->leafAccessValue = array();
        $this->setTotal(count($_GET['leafAccessId']));
        /*
		 *  All the $_GET enviroment.
		 */
        /*
		 *  All the $_POST enviroment.
		 */
        if (isset($_POST['TEAMID'])) {
            $this->setTEAMID($this->strict($_POST['TEAMID'], 'numeric'));
        }
        if (isset($_POST['moduleId'])) {
            $this->setModuleId($this->strict($_POST['moduleId'], 'numeric'));
        }
        if (isset($_POST['folderId'])) {
            $this->setFolderId($this->strict($_POST['folderId'], 'numeric'));
        }
        if (isset($_POST['leafTempId'])) {
            $this->setleafTempId($this->strict($_POST['leafTempId'], 'numeric'));
        }
        if (isset($_POST['staffId'])) {
            $this->setStaffId($this->strict($_POST['staffId'], 'numeric'));
        }
        if (isset($_SESSION['staffId'])) {
            $this->setExecuteBy($_SESSION['staffId']);
        }
        if ($this->getVendor() == self::MYSQL) {
            $this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
        } else 
            if ($this->getVendor() == self::MSSQL) {
                $this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
            } else 
                if ($this->getVendor() == self::ORACLE) {
                    $this->setExecuteTime(
                    "to_date('" . date("Y-m-d H:i:s") .
                     "','YYYY-MM-DD HH24:MI:SS')");
                }
        for ($i = 0; $i < $this->getTotal(); $i ++) {
            $this->setLeafAccessId(
            $this->strict($_GET['leafAccessId'][$i], 'numeric'), $i);
            if ($_GET['leafAccessCreateValue'][$i] == 'true') {
                $this->setleafAccessCreateValue($i, 1);
            } else {
                $this->setleafAccessCreateValue($i, 0);
            }
            if ($_GET['leafAccessReadValue'][$i] == 'true') {
                $this->setleafAccessReadValue($i, 1);
            } else {
                $this->setleafAccessReadValue($i, 0);
            }
            if ($_GET['leafAccessUpdateValue'][$i] == 'true') {
                $this->setleafAccessUpdateValue($i, 1);
            } else {
                $this->setleafAccessUpdateValue($i, 0);
            }
            if ($_GET['leafAccessDeleteValue'][$i] == 'true') {
                $this->setleafAccessDeleteValue($i, 1);
            } else {
                $this->setleafAccessDeleteValue($i, 1);
            }
            if ($_GET['leafAccessPrintValue'][$i] == 'true') {
                $this->setleafAccessPrintValue($i, 1);
            } else {
                $this->setleafAccessPrintValue($i, 0);
            }
            if ($_GET['leafAccessPostValue'][$i] == 'true') {
                $this->setleafAccessPostValue($i, 1);
            } else {
                $this->setleafAccessPostValue($i, 0);
            }
            if ($_GET['leafAccessDraftValue'][$i] == 'true') {
                $this->leafAccessDraftValue[$i] = 1;
                $this->setleafAccessDraftValue($i, 1);
            } else {
                $this->leafAccessDraftValue[$i] = 0;
                $this->setleafAccessDraftValue($i, 0);
            }
            $primaryKeyAll .= $this->getLeafAccessId($i, 'array') . ",";
        }
        $this->setPrimaryKeyAll((substr($primaryKeyAll, 0, - 1)));
    }
    /* (non-PHPdoc)
	 * @see ValidationClass::create()
	 */
    function create ()
    {}
    /* (non-PHPdoc)
	 * @see ValidationClass::update()
	 */
    function update ()
    {}
    /* (non-PHPdoc)
	 * @see ValidationClass::delete()
	 */
    function delete ()
    {}
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
     * Set Leaf Access Identification  Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setLeafAccessId ($value, $key, $type)
    {
        if ($type == 'single') {
            $this->leafAccessId = $value;
        } else 
            if ($type == 'array') {
                $this->leafAccessId[$key] = $value;
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:setLeafAccessId ?"));
                exit();
            }
    }
    /**
     * Return Leaf Access Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return int|array
     */
    public function getLeafAccessId ($key, $type)
    {
        if ($type == 'single') {
            return $this->leafAccessId;
        } else 
            if ($type == 'array') {
                return $this->leafAccessId[$key];
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:getLeafAccessId ?"));
                exit();
            }
    }
    /**
     * Set Leaf Identification Value
     * @param  int $value
     */
    public function setLeafTempId ($value)
    {
        $this->leafTempId = $value;
    }
    /**
     * Return Leaf Identification Value
     * @return int
     */
    public function getLeafTempId ()
    {
        return $this->leafTempId;
    }
    /**
     * Set Group Identification Value
     * @param  int $value
     */
    public function setTEAMID ($value)
    {
        $this->TEAMID = $value;
    }
    /**
     * Return Group Identiification Value
     * @return int
     */
    public function getTEAMID ()
    {
        return $this->TEAMID;
    }
    /**
     * Set Module Identification Value
     * @param  int $value
     */
    public function setModuleId ($value)
    {
        $this->moduleId = $value;
    }
    /**
     * Return Module Identification Value
     * @return int
     */
    public function getModuleId ()
    {
        return $this->moduleId;
    }
    /**
     * Set Folder Identification Value
     * @param  int $value
     */
    public function setFolderId ($value)
    {
        $this->folderId = $value;
    }
    /**
     * Return Folder Identiification Value
     * @return int
     */
    public function getFolderId ()
    {
        return $this->folderId;
    }
    /**
     * Set Staff Identification Value
     * @param  int $value
     */
    public function setStaffId ($value)
    {
        $this->staffId = $value;
    }
    /**
     * Return Staff Identification Value
     * @return int
     */
    public function getStaffId ()
    {
        return $this->staffId;
    }
}
?>