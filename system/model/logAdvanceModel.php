<?php

require_once ("../../class/classValidation.php");

/**
 * this is logAdvance model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage logAdvance
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LogAdvanceModel extends ValidationClass {

    /**
     * Log Advance Identification
     * @var int
     */
    private $logAdvanceId;

    /**
     * Log Advance Text.Containing json   on create,update,delete
     * @var int
     */
    private $logAdvanceText;

    /**
     * Log Advance Type - create ,update,delete
     * @var int
     */
    private $logAdvanceType;

    /**
     * Log Advance Comparision. Containing Before and After  Sql Statement on each column
     * @var int
     */
    private $logAdvanceComparision;

    /**
     * Reference Table Name
     * @var int
     */
    private $refTableName;

    /**
     * Reference Identification equivilant to Reference Table Name Primary Key
     * @var int
     */
    private $leafId;

    /**
     * Class Loader to load outside variable and test it suppose variable type
     */
    function execute() {
        /*
         *  Basic Information Table
         */
        $this->settableName('logAdvance');
        $this->setPrimaryKeyName('logAdvanceId');
        /*
         *  All the $_POST enviroment.
         */
        if (isset($_POST ['logAdvanceId'])) {
            $this->setLogAdvanceId($this->strict($_POST ['logAdvanceId'], 'numeric'));
        }
        if (isset($_POST ['logAdvanceText'])) {
            $this->setLogAdvanceText($this->strict($_POST ['logAdvanceText'], 'numeric'));
        }
        if (isset($_POST ['logAdvanceType'])) {
            $this->setLogAdvanceType($this->strict($_POST ['logAdvanceType'], 'numeric'));
        }
        if (isset($_POST ['logAdvanceComparision'])) {
            $this->setComparision($this->strict($_POST ['logAdvanceComparision'], 'numeric'));
        }
        /*
         * All the $_GET enviroment 
         */
        if (isset($_GET ['leafId'])) {

            $this->setLeafId($this->strict($_GET ['leafId'], 'numeric'));
        }
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

    public function create() {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(1, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(1, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
        $this->setIsReview(0, 0, 'single');
        $this->setIsPost(0, 0, 'single');
    }

    /* (non-PHPdoc)
     * @see ValidationClass::update()
     */

    public function update() {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(0, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(1, '', 'single');
        $this->setIsActive(1, 0, 'single');
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
        $this->setIsReview(0, 0, 'single');
        $this->setIsPost(0, 0, 'single');
    }

    /* (non-PHPdoc)
     * @see ValidationClass::delete()
     */

    public function delete() {
        $this->setIsDefault(0, 0, 'single');
        $this->setIsNew(0, 0, 'single');
        $this->setIsDraft(0, 0, 'single');
        $this->setIsUpdate(0, 0, 'single');
        $this->setIsActive(0, '', 'string');
        $this->setIsDelete(1, '', 'string');
        $this->setIsApproved(0, 0, 'single');
        $this->setIsReview(0, 0, 'single');
        $this->setIsPost(0, 0, 'single');
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
     * @see ValidationClass::approved()
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
     * Set Log Advance Identification  Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setLogAdvanceId($value, $key, $type) {
        if ($type == 'single') {
            $this->logAdvanceId = $value;
        } else if ($type == 'array') {
            $this->logAdvanceId [$key] = $value;
        } else {
            echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setLogAdvanceId ?"));
            exit();
        }
    }

    /**
     * Return LogAdvance Identification  Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return bool|array
     */
    public function getLogAdvanceId($key, $type) {
        if ($type == 'single') {
            return $this->logAdvanceId;
        } else if ($type == 'array') {
            return $this->logAdvanceId [$key];
        } else {
            echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getLogAdvanceId ?"));
            exit();
        }
    }

    /**
     * @return the $logAdvanceText
     */
    public function getLogAdvanceText() {
        return $this->logAdvanceText;
    }

    /**
     * @return the $logAdvanceType
     */
    public function getLogAdvanceType() {
        return $this->logAdvanceType;
    }

    /**
     * @return the $logAdvanceComparision
     */
    public function getLogAdvanceComparision() {
        return $this->logAdvanceComparision;
    }

    /**
     * @return the $refTableName
     */
    public function getRefTableName() {
        return $this->refTableName;
    }

    /**
     * @return the $leafId
     */
    public function getLeafId() {
        return $this->leafId;
    }

    /**
     * @param number $logAdvanceText
     */
    public function setLogAdvanceText($logAdvanceText) {
        $this->logAdvanceText = $logAdvanceText;
    }

    /**
     * @param number $logAdvanceType
     */
    public function setLogAdvanceType($logAdvanceType) {
        $this->logAdvanceType = $logAdvanceType;
    }

    /**
     * @param number $logAdvanceComparison
     */
    public function setLogAdvanceComparision($logAdvanceComparision) {
        $this->logAdvanceComparision = $logAdvanceComparision;
    }

    /**
     * @param number $refTableName
     */
    public function setRefTableName($refTableName) {
        $this->refTableName = $refTableName;
    }

    /**
     * @param number $leafId
     */
    public function setLeafId($leafId) {
        $this->leafId = $leafId;
    }

}

?>