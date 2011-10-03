<?php

require_once ("../../class/classValidation.php");
/**
 * this is Crew model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package management
 * @subpackage crew
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class CrewModel extends ValidationClass
{
    /**
     * crew Identification
     * @var int
     */
    private $crewId;
    /**
     * crew Sequence
     * @var int
     */
    private $crewSequence;
    /**
     * crew Code
     * @var string
     */
    private $crewCode;
    /**
     * crew Note
     * @var string
     */
    private $crewNote;
    function execute ()
    {
        /**
         * Basic Information Table
         */
        $this->setTableName('crew');
        $this->setPrimaryKeyName('crewId');
        /**
         * All the $_POST enviroment.
         */
        if (isset($_POST['Id'])) {
            $this->setcrewId($this->strict($_POST['crewId'], 'numeric'), 0, 
            'single');
        }
        if (isset($_POST['crewSequence'])) {
            $this->setcrewSequence(
            $this->strict($_POST['crewSequence'], 'memo'));
        }
        if (isset($_POST['crewCode'])) {
            $this->setcrewCode($this->strict($_POST['crewCode'], 'memo'));
        }
        if (isset($_POST['crewNote'])) {
            $this->setcrewNote($this->strict($_POST['crewNote'], 'memo'));
        }
        if (isset($_SESSION['staffId'])) {
            $this->setExecuteBy($_SESSION['staffId']);
        }
        if ($this->getVendor() == self::mysql) {
            $this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
        } else 
            if ($this->getVendor() == self::mssql) {
                $this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
            } else 
                if ($this->getVendor() == self::oracle) {
                    $this->setExecuteTime(
                    "to_date('" . date("Y-m-d H:i:s") .
                     "','YYYY-MM-DD HH24:MI:SS')");
                }
        $this->setTotal(count($_GET['crewId']));
        $accessArray = array("isDefault", "isNew", "isDraft", "isUpdate", 
        "isDelete", "isActive", "isApproved","isReview","isPost");
        // auto assign as array if true
        if (is_array($_GET['crewId'])) {
            $this->crewId = array();
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
            $this->setcrewId($this->strict($_GET['crewId'][$i], 'numeric'), 
            $i, 'array');
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
            $primaryKeyAll .= $this->getDefaultLabelId($i, 'array') . ",";
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
        $this->setIsUpdate(1, 0, 'single');
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
        $this->setIsActive(0, 0, 'single');
        $this->setIsDelete(1, 0, 'single');
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
    /* (non-PHPdoc)
	 * @see ConfigClass::excel()
	 */
    function excel ()
    {}
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
     * Set crew Identification  Value
     * @param array[int] $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setCrewId ($value, $key, $type)
    {
        if ($type == 'single') {
            $this->crewId = $value;
        } else 
            if ($type == 'array') {
                $this->crewId[$key] = $value;
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:setCrewId ?"));
                exit();
            }
    }
    /**
     * Return crew Identification  Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return bool|array
     */
    public function getCrewId ($key, $type)
    {
        if ($type == 'single') {
            return $this->crewId;
        } else 
            if ($type == 'array') {
                return $this->crewId[$key];
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:getcrewId ?"));
                exit();
            }
    }
    /**
     * Set  crew Sequence (english)
     * @param int $value
     */
    public function setCrewSequence ($value)
    {
        $this->crewSequence = $value;
    }
    /**
     * Return crew  Sequence
     * @return  int
     */
    public function getCrewSequence ()
    {
        return $this->CrewSequence;
    }
    /**
     * Set  crew  Code (english)
     * @param string $value
     */
    public function setCrewCode ($value)
    {
        $this->crewCode = $value;
    }
    /**
     * Return crew  Code
     * @return  string
     */
    public function getCrewCode ()
    {
        return $this->crewCode;
    }
    /**
     * Set  crew Translation (english)
     * @param string $value
     */
    public function setCrewNote ($value)
    {
        $this->crewNote = $value;
    }
    /**
     * Return crew  Description (english)
     * @return  string
     */
    public function getCrewNote ()
    {
        return $this->crewNote;
    }
}
?>