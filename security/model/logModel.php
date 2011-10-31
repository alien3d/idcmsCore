<?php

require_once ("../../class/classValidation.php");

/**
 * this is Log model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage log
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LogModel extends ValidationClass {

    /**
     * Log Identification
     * @var int
     */
    private $logId;

    /**
     * Leaf Identification
     * @var int
     */
    private $leafId;

    /**
     * Operation -  Showing which user have use access create,read ,update ,delete.
     * @var string
     */
    private $operation;

    /**
     * Sql Statement
     * @var string
     */
    private $sql;

    /**
     * Date -  Date and Time Sql Statment Execute.
     * @var date
     */
    private $date;

    /**
     * Starff Identification
     * @var int
     */
    private $staffId;

    /**
     * Access . Granted Or Denied
     * @var string
     */
    private $access;

    /**
     * Log error contain  sql statement and error message
     * @var string
     */
    private $logError;

    /**
     * Class Loader to load outside variable and test it suppose variable type
     */
    function execute() {
        /**
         *  Basic Information Table
         */
        $this->setTableName('log');
        $this->setPrimaryKeyName('logId');
        /**
         *  All the $_POST enviroment.
         */
        if (isset($_SESSION ['staffId'])) {
            $this->setExecuteBy($_SESSION ['staffId']);
        }
        if (isset($_POST ['leafId'])) {
            $this->setLeafId($this->strict($_POST ['leafId'], 'numeric'));
        }
        if (isset($_POST ['operation'])) {
            $this->setOperation($this->strict($_POST ['operation'], 'numeric'));
        }
        if (isset($_POST ['sql'])) {
            $this->setSql($this->strict($_POST ['sql'], 'numeric'));
        }
        if (isset($_POST ['date'])) {
            $this->setDate($this->strict($_POST ['date'], 'numeric'));
        }
        if (isset($_POST ['access'])) {
            $this->setAccess($this->strict($_POST ['access'], 'numeric'));
        }
        if (isset($_POST ['logError'])) {
            $this->setLogError($this->strict($_POST ['logError'], 'numeric'));
        }
        /**
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
     * Set Log Identification  Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setLogId($value, $key, $type) {
        if ($type == 'single') {
            $this->logId = $value;
        } else if ($type == 'array') {
            $this->logId [$key] = $value;
        } else {
            echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setLogId ?"));
            exit();
        }
    }

    /**
     * Return Log Identification  Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return bool|array
     */
    public function getLogId($key, $type) {
        if ($type == 'single') {
            return $this->logId;
        } else if ($type == 'array') {
            return $this->logId [$key];
        } else {
            echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getLogId ?"));
            exit();
        }
    }

    /**
     * @return the $leafId
     */
    public function getLeafId() {
        return $this->leafId;
    }

    /**
     * @return the $operation
     */
    public function getOperation() {
        return $this->operation;
    }

    /**
     * @return the $sql
     */
    public function getSql() {
        return $this->sql;
    }

    /**
     * @return the $date
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @return the $staffId
     */
    public function getStaffId() {
        return $this->staffId;
    }

    /**
     * @return the $access
     */
    public function getAccess() {
        return $this->access;
    }

    /**
     * @return the $logError
     */
    public function getLogError() {
        return $this->logError;
    }

    /**
     * @param number $leafId
     */
    public function setLeafId($leafId) {
        $this->leafId = $leafId;
    }

    /**
     * @param string $operation
     */
    public function setOperation($operation) {
        $this->operation = $operation;
    }

    /**
     * @param string $sql
     */
    public function setSql($sql) {
        $this->sql = $sql;
    }

    /**
     * @param date $date
     */
    public function setDate($date) {
        $this->date = $date;
    }

    /**
     * @param number $staffId
     */
    public function setStaffId($staffId) {
        $this->staffId = $staffId;
    }

    /**
     * @param string $access
     */
    public function setAccess($access) {
        $this->access = $access;
    }

    /**
     * @param string $logError
     */
    public function setLogError($logError) {
        $this->logError = $logError;
    }

}

?>