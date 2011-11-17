<?php

require_once ("../../class/classValidation.php");

/**
 * this is module security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Security
 * @package Model Access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ModuleAccessModel extends ValidationClass {

    /**
     * Module Access  Identification
     * @var int
     */
    private $moduleAccessId;

    /**
     * Module Identification
     * @var int
     */
    private $moduleId;

    /**
     * Crew Identification
     * @var int
     */
    private $teamId;

    /**
     * Module Access Value
     * @var bool
     */
    private $moduleAccessValue;

    /**
     * Class Loader to load outside variable and test it suppose variable type
     */
    function execute() {
        /*
         *  Basic Information Table
         */
        $this->setTableName('moduleAccess');
        $this->setPrimaryKeyName('moduleAccessId');

        /*
         *  All the $_POST enviroment.
         */
        if (isset($_POST ['type'])) {
            $this->setType($this->strict($_POST ['type'], 'numeric'));
        }
        if (isset($_POST ['teamId'])) {
            $this->setTeamId($_POST ['teamId']);
        }
        if (isset($_POST ['moduleId'])) {
            $this->setModuleId($this->strict($_POST ['moduleId'], 'numeric'));
        }
        /*
         *  All the $_GET enviroment.
         */
        if (isset($_GET ['moduleAccessId'])) {
            $this->setTotal(count($_GET ['moduleAccessId']));
        }
        if (isset($_GET ['type'])) {
            $this->setType($this->strict($_GET ['type'], 'numeric'));
        }
        if (isset($_GET ['teamId'])) {
            $this->setTeamId($this->strict($_GET ['teamId'], 'numeric'));
        }
        if (isset($_GET ['moduleAccessId'])) {
            if (is_array($_GET ['moduleAccessId'])) {
                $this->moduleAccessId = array();
            }
        }
        if (isset($_GET ['moduleId'])) {
            $this->setModuleId($this->strict($_GET ['moduleId'], 'numeric'));
        }

        $primaryKeyAll = '';
        for ($i = 0; $i < $this->getTotal(); $i++) {
            if (isset($_GET ['moduleAccessValue'])) {
                $this->setModuleAccessId($this->strict($_GET ['moduleAccessId'] [$i], 'numeric'), $i, 'array');
            }
            if (isset($_GET ['moduleAccessValue'])) {
                if ($_GET ['moduleAccessValue'] [$i] == 'true') {
                    $this->setModuleAccessValue(1, $i, 'array');
                } else {
                    $this->setModuleAccessValue(0, $i, 'array');
                }
            }
            $primaryKeyAll .= $this->getModuleAccessId($i, 'array') . ",";
        }
        $this->setPrimaryKeyAll((substr($primaryKeyAll, 0, - 1)));

        /**
         * All the $_SESSION enviroment.
         */
        if (isset($_SESSION ['staffId'])) {
            $this->setExecuteBy($_SESSION ['staffId']);
        }
        /**
         * TimeStamp Value.
         */
        if ($this->getVendor() == self::MYSQL) {
            $this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
        } else if ($this->getVendor() == self::MSSQL) {
            $this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
        } else if ($this->getVendor() == self::ORACLE) {
            $this->setExecuteTime("to_date('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')");
        }
    }

    /* (non-PHPdoc)
     * @see tab::create()
     */

    function create() {
        
    }

    /* (non-PHPdoc)
     * @see tab::update()
     */

    function update() {
        
    }

    /* (non-PHPdoc)
     * @see tab::delete()
     */

    function delete() {
        
    }

    /* (non-PHPdoc)
     * @see ValidationClass::draft()
     */

    public function draft() {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(1, 0, 'single');
        $this->setIsDraft(1, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(0, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
        $this->setIsReview(0, 0, 'single');
        $this->setIsPost(0, 0, 'single');
    }

    /* (non-PHPdoc)
     * @see ValidationClass::draft()
     */

    public function approved() {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(1, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(0, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(1, 0, 'single');
        $this->setIsReview(0, 0, 'single');
        $this->setIsPost(0, 0, 'single');
    }

    /* (non-PHPdoc)
     * @see ValidationClass::review()
     */

    public function review() {
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

    public function post() {
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
     * Set Module Access  Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setModuleAccessId($value, $key, $type) {
        if ($type == 'single') {
            $this->moduleAccessId = $value;
        } else if ($type == 'array') {
            $this->moduleAccessId [$key] = $value;
        } else {
            echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setModuleAccessId ?"));
            exit();
        }
    }

    /**
     * Return Module Access Identification
     * @param array[int][int] $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return int|array
     */
    public function getModuleAccessId($key, $type) {
        if ($type == 'single') {
            return $this->moduleAccessId;
        } else if ($type == 'array') {
            return $this->moduleAccessId [$key];
        } else {
            echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getModuleAccessId ?"));
            exit();
        }
    }

    /**
     * Set Module Identification Value
     * @param  int $value
     */
    public function setModuleId($value) {
        $this->moduleId = $value;
    }

    /**
     * Return Module Identiification Value
     * @return int
     */
    public function getModuleId() {
        return $this->moduleId;
    }

    /**
     * Set Team Identification Value
     * @param  int $value
     */
    public function setTeamId($value) {
        $this->crewId = $value;
    }

    /**
     * Return Team Identification Value
     * @return int
     */
    public function getTeamId() {
        return $this->teamId;
    }

    /**
     * Set Module Access Value
     * @param bool|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setModuleAccessValue($value, $key, $type) {
        if ($type == 'single') {
            
        } else if ($type == 'array') {
            $this->moduleAccessValue [$key] = $value;
        }
    }

    /**
     * Return Module Access Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return bool|array
     */
    public function getModuleAccessValue($key, $type) {
        if ($type == 'single') {
            
        } else if ($type == 'array') {
            return $this->moduleAccessValue [$key];
        }
    }

    /**
     * Set  Type Filtering
     * @param  int $value
     */
    public function setType($value) {
        $this->type = $value;
    }

    /**
     * Return Type Filtering
     * @return int
     */
    public function getType() {
        return $this->type;
    }

}

?>