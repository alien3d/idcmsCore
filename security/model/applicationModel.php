<?php

require_once ("../../class/classValidation.php");

/**
 * this is application model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Security
 * @subpackage application
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ApplicationModel extends ValidationClass {

    /**
     * Application Identification
     * @var int
     */
    private $applicationId;

    /**
     * Icon Identification
     * @var int
     */
    private $iconId;

    /**
     * Application Sequence
     * @var int
     */
    private $applicationSequence;

    /**
     * Application Code
     * @var string
     */
    private $applicationCode;

    /**
     * Application Note .English Only
     * @var string
     */
    private $applicationEnglish;

    /**
     * Class Loader to load outside variable and test it suppose variable type
     */
    function execute() {
        /*
         *  Basic Information Table
         */
        $this->setTableName('application');
        $this->setPrimaryKeyName('applicationId');
        /*
         *  All the $_POST enviroment.
         */
        if (isset($_POST ['applicationId'])) {
            $this->setApplicationId($this->strict($_POST ['applicationId'], 'numeric'), 0, 'single');
        }
        if (isset($_POST ['iconId'])) {
            $this->setIconId($this->strict($_POST ['iconId'], 'numeric'));
        }
        if (isset($_POST ['applicationSequence'])) {
            $this->setApplicationSequence($this->strict($_POST ['applicationSequence'], 'numeric'));
        }
        if (isset($_POST ['applicationCode'])) {
            $this->setApplicationCode($this->strict($_POST ['applicationCode'], 'string'));
        }
        if (isset($_POST ['applicationEnglish'])) {
            $this->setApplicationEnglish($this->strict($_POST ['applicationEnglish'], 'memo'));
        }

        /*
         *  All the $_GET enviroment.
         */
        if (isset($_GET ['applicationId'])) {
            $this->setTotal(count($_GET ['applicationId']));
        }
        if (isset($_GET ['applicationId'])) {
            if (is_array($_GET ['applicationId'])) {
                $this->applicationId = array();
            }
        }
        if (isset($_GET ['isDefault'])) {
            if (is_array($_GET ['isDefault'])) {
                $this->isDefault = array();
            }
        }
        if (isset($_GET ['isNew'])) {
            if (is_array($_GET ['isNew'])) {
                $this->isNew = array();
            }
        }
        if (isset($_GET ['isDraft'])) {
            if (is_array($_GET ['isDraft'])) {
                $this->isDraft = array();
            }
        }
        if (isset($_GET ['isUpdate'])) {
            if (is_array($_GET ['isUpdate'])) {
                $this->isUpdate = array();
            }
        }
        if (isset($_GET ['isDelete'])) {
            if (is_array($_GET ['isDelete'])) {
                $this->isDelete = array();
            }
        }
        if (isset($_GET ['isActive'])) {
            if (is_array($_GET ['isActive'])) {
                $this->isActive = array();
            }
        }
        if (isset($_GET ['isApproved'])) {
            if (is_array($_GET ['isApproved'])) {
                $this->isApproved = array();
            }
        }
        if (isset($_GET ['isReview'])) {
            if (is_array($_GET ['isReview'])) {
                $this->isReview = array();
            }
        }
        if (isset($_GET ['isPost'])) {
            if (is_array($_GET ['isPost'])) {
                $this->isPost = array();
            }
        }
        $primaryKeyAll = '';
        for ($i = 0; $i < $this->getTotal(); $i++) {
            if (isset($_GET['applicationId'])) {
                $this->setApplicationId($this->strict($_GET ['applicationId'] [$i], 'numeric'), $i, 'array');
            }
            if (isset($_GET ['isDefault'])) {
                if ($_GET ['isDefault'] [$i] == 'true') {
                    $this->setIsDefault(1, $i, 'array');
                } else if ($_GET ['isDefault'] [$i] == 'false') {
                    $this->setIsDefault(0, $i, 'array');
                }
            }
            if (isset($_GET ['isNew'])) {
                if ($_GET ['isNew'] [$i] == 'true') {
                    $this->setIsNew(1, $i, 'array');
                } else if ($_GET ['isNew'] [$i] == 'false') {
                    $this->setIsNew(0, $i, 'array');
                }
            }
            if (isset($_GET ['isDraft'])) {
                if ($_GET ['isDraft'] [$i] == 'true') {
                    $this->setIsDraft(1, $i, 'array');
                } else if ($_GET ['isDraft'] [$i] == 'false') {
                    $this->setIsDraft(0, $i, 'array');
                }
            }
            if (isset($_GET ['isUpdate'])) {
                if ($_GET ['isUpdate'] [$i] == 'true') {
                    $this->setIsUpdate(1, $i, 'array');
                } if ($_GET ['isUpdate'] [$i] == 'false') {
                    $this->setIsUpdate(0, $i, 'array');
                }
            }
            if (isset($_GET ['isDelete'])) {
                if ($_GET ['isDelete'] [$i] == 'true') {
                    $this->setIsDelete(1, $i, 'array');
                } else if ($_GET ['isDelete'] [$i] == 'false') {
                    $this->setIsDelete(0, $i, 'array');
                }
            }
            if (isset($_GET ['isActive'])) {
                if ($_GET ['isActive'] [$i] == 'true') {
                    $this->setIsActive(1, $i, 'array');
                } else if ($_GET ['isActive'] [$i] == 'false') {
                    $this->setIsActive(0, $i, 'array');
                }
            }
            if (isset($_GET ['isApproved'])) {
                if ($_GET ['isApproved'] [$i] == 'true') {
                    $this->setIsApproved(1, $i, 'array');
                } else if ($_GET ['isApproved'] [$i] == 'false') {
                    $this->setIsApproved(0, $i, 'array');
                }
            }
            if (isset($_GET ['isReview'])) {
                if ($_GET ['isReview'] [$i] == 'true') {
                    $this->setIsReview(1, $i, 'array');
                } else if ($_GET ['isReview'] [$i] == 'false') {
                    $this->setIsReview(0, $i, 'array');
                }
            }
            if (isset($_GET ['isPost'])) {
                if ($_GET ['isPost'] [$i] == 'true') {
                    $this->setIsPost(1, $i, 'array');
                } else if ($_GET ['isPost'] [$i] == 'false') {
                    $this->setIsPost(0, $i, 'array');
                }
            }
            $primaryKeyAll .= $this->getTabId($i, 'array') . ",";
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
     * @see ValidationClass::create()
     */

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
        $this->setIsUpdate(1, 0, 'single');
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
        $this->setIsActive(0, 0, 'single');
        $this->setIsDelete(1, 0, 'single');
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
     * Update tab Table Status
     */
    public function updateStatus() {
        if (!(is_array($_GET ['isDefault']))) {
            $this->setIsDefault(0, 0, 'single');
        }
        if (!(is_array($_GET ['isNew']))) {
            $this->setIsNew(0, 0, 'single');
        }
        if (!(is_array($_GET ['isDraft']))) {
            $this->setIsDraft(0, 0, 'single');
        }
        if (!(is_array($_GET ['isUpdate']))) {
            $this->setIsUpdate(0, 0, 'single');
        }
        if (!(is_array($_GET ['isDelete']))) {
            $this->setIsDelete(1, 0, 'single');
        }
        if (!(is_array($_GET ['isActive']))) {
            $this->setIsActive(0, 0, 'single');
        }
        if (!(is_array($_GET ['isApproved']))) {
            $this->setIsApproved(0, 0, 'single');
        }
    }

    /**
     * Set Application   Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setApplicationId($value, $key, $type) {
        if ($type == 'single') {
            $this->applicationId = $value;
        } else if ($type == 'array') {
            $this->applicationId [$key] = $value;
        } else {
            echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setApplicationId ?"));
            exit();
        }
    }

    /**
     * Return Application  Identification
     * @param array[int][int] $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return int|array
     */
    public function getApplicationId($key, $type) {
        if ($type == 'single') {
            return $this->applicationId;
        } else if ($type == 'array') {
            return $this->applicationId [$key];
        } else {
            echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getApplicationId ?"));
            exit();
        }
    }

    /**
     * Set Icon Identification
     * @param  int $value
     */
    public function setIconId($value) {
        $this->iconId = $value;
    }

    /**
     * Return Icon Identification
     * @return int
     */
    public function getIconId() {
        return $this->iconId;
    }

    /**
     * Set Application Sequence Value
     * @param  int $value
     */
    public function setApplicationSequence($value) {
        $this->applicationSequence = $value;
    }

    /**
     * Return application Sequence Value
     * @return int
     */
    public function getApplicationSequence() {
        return $this->applicationSequence;
    }

    /**
     * Set Application Code Value
     * @param string $value
     */
    public function setApplicationCode($value) {
        $this->applicationCode = $value;
    }

    /**
     * Return Application Code
     * @return string
     */
    public function getApplicationCode() {
        return $this->applicationCode;
    }

    /**
     * Set Application Note Value
     * @param string $value
     */
    public function setApplicationEnglish($value) {
        $this->applicationEnglish = $value;
    }

    /**
     * Return application Note
     * @return string
     */
    public function getApplicationEnglish() {
        return $this->applicationEnglish;
    }

}

?>