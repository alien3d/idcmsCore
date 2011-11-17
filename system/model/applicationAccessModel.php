<?php

require_once ("../../class/classValidation.php");

/**
 * this is application security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Security
 * @package Model Access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ApplicationAccessModel extends ValidationClass {

    /**
     * Application Access  Identification
     * @var int
     */
    private $applicationAccessId;

    /**
     * Application Identification
     * @var int
     */
    private $applicationId;

    /**
     * Crew Identification
     * @var int
     */
    private $teamId;

    /**
     * Application Access Value
     * @var bool
     */
    private $applicationAccessValue;

    /**
     * Class Loader to load outside variable and test it suppose variable type
     */
    function execute() {
        /*
         *  Basic Information Table
         */
        $this->setTableName('applicationAccess');
        $this->setPrimaryKeyName('applicationAccessId');

        /*
         *  All the $_POST enviroment.
         */
        if (isset($_POST ['type'])) {
            $this->setType($this->strict($_POST ['type'], 'numeric'));
        }
        if (isset($_POST ['teamId'])) {
            $this->setTeamId($_POST ['teamId']);
        }
        if (isset($_POST ['applicationId'])) {
            $this->setApplicationId($this->strict($_POST ['applicationId'], 'numeric'));
        }
        /*
         *  All the $_GET enviroment.
         */
        if (isset($_GET ['applicationAccessId'])) {
            $this->setTotal(count($_GET ['applicationAccessId']));
        }
        if (isset($_GET ['type'])) {
            $this->setType($this->strict($_GET ['type'], 'numeric'));
        }
        if (isset($_GET ['teamId'])) {
            $this->setTeamId($this->strict($_GET ['teamId'], 'numeric'));
        }
        if (isset($_GET ['applicationAccessId'])) {
            if (is_array($_GET ['applicationAccessId'])) {
                $this->applicationAccessId = array();
            }
        }
        if (isset($_GET ['applicationId'])) {
            $this->setApplicationId($this->strict($_GET ['applicationId'], 'numeric'));
        }

        $primaryKeyAll = '';
        for ($i = 0; $i < $this->getTotal(); $i++) {
            if (isset($_GET ['applicationAccessValue'])) {
                $this->setApplicationAccessId($this->strict($_GET ['applicationAccessId'] [$i], 'numeric'), $i, 'array');
            }
            if (isset($_GET ['applicationAccessValue'])) {
                if ($_GET ['applicationAccessValue'] [$i] == 'true') {
                    $this->setApplicationAccessValue(1, $i, 'array');
                } else {
                    $this->setApplicationAccessValue(0, $i, 'array');
                }
            }
            $primaryKeyAll .= $this->getApplicationAccessId($i, 'array') . ",";
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
     * Set Application Access  Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setApplicationAccessId($value, $key, $type) {
        if ($type == 'single') {
            $this->applicationAccessId = $value;
        } else if ($type == 'array') {
            $this->applicationAccessId [$key] = $value;
        } else {
            echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setApplicationAccessId ?"));
            exit();
        }
    }

    /**
     * Return Application Access Identification
     * @param array[int][int] $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return int|array
     */
    public function getApplicationAccessId($key, $type) {
        if ($type == 'single') {
            return $this->applicationAccessId;
        } else if ($type == 'array') {
            return $this->applicationAccessId [$key];
        } else {
            echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getApplicationAccessId ?"));
            exit();
        }
    }

    /**
     * Set Application Identification Value
     * @param  int $value
     */
    public function setApplicationId($value) {
        $this->applicationId = $value;
    }

    /**
     * Return Application Identiification Value
     * @return int
     */
    public function getApplicationId() {
        return $this->applicationId;
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
     * Set Application Access Value
     * @param bool|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setApplicationAccessValue($value, $key, $type) {
        if ($type == 'single') {
            
        } else if ($type == 'array') {
            $this->applicationAccessValue [$key] = $value;
        }
    }

    /**
     * Return Application Access Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return bool|array
     */
    public function getApplicationAccessValue($key, $type) {
        if ($type == 'single') {
            
        } else if ($type == 'array') {
            return $this->applicationAccessValue [$key];
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