<?php

require_once ("../../class/classValidation.php");

/**
 * this is folder security model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage folderAccess
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class FolderAccessModel extends ValidationClass {

    /**
     * Folder Access Identification
     * @var int
     */
    private $folderAccessId;

    /**
     * Folder Identification
     * @var int
     */
    private $folderId;

    /**
     * Group Identification
     * @var int
     */
    private $teamId;

    /**
     * Module   Identification (** For Filtering  Only)
     * @var int
     */
    private $moduleId;

    /**
     * Type 1 filter  table only Type 2  Filter with access table
     * @var int
     */
    private $type;

    /**
     * Folder Access Value
     * @var bool
     */
    private $folderAccessValue;

    /**
     * Class Loader to load outside variable and test it suppose variable type
     */
    function execute() {
        /**
         * Basic Information Folderle
         */
        $this->setTableName('folderAccess');
        $this->setPrimaryKeyName('folderAccessId');
        $this->folderAccessId = array();
        $this->folderAccessValue = array();
        /**
         * All the $_POST enviroment.
         */
        if (isset($_POST ['type'])) {
            $this->setType($this->strict($_POST ['type'], 'numeric'));
        }
        if (isset($_POST ['teamId'])) {
            $this->setTeamId($this->strict($_POST ['teamId'], 'numeric'));
        }
        if (isset($_POST ['moduleId'])) {
            $this->setModuleId($this->strict($_POST ['moduleId'], 'numeric'));
        }
        if (isset($_POST ['folderId'])) {
            $this->setFolderId($this->strict($_POST ['folderId'], 'numeric'));
        }
        /**
         * All the $_GET enviroment.
         */
        if (isset($_GET ['folderAccessId'])) {
            $this->setTotal(count($_GET ['folderAccessId']));
        }
        if (isset($_GET ['type'])) {
            $this->setType($this->strict($_GET ['type'], 'numeric'));
        }
        if (isset($_GET ['teamId'])) {
            $this->setTeamId($this->strict($_GET ['teamId'], 'numeric'));
        }
        if (isset($_GET ['moduleId'])) {
            $this->setModuleId($this->strict($_GET ['moduleId'], 'numeric'));
        }
        if (isset($_GET ['folderId'])) {
            $this->setFolderId($this->strict($_GET ['folderId'], 'numeric'));
        }

        $primaryKeyAll = '';
        for ($i = 0; $i < $this->getTotal(); $i++) {
            $this->setFolderAccessId($this->strict($_GET ['folderAccessId'] [$i], 'numeric'), $i);
            if (isset($_GET ['folderAccessValue'])) {
                if ($_GET ['folderAccessValue'] [$i] == 'true') {
                    $this->setFolderAccessValue(1, $i);
                } else {
                    $this->setFolderAccessValue(0, $i);
                }
            }
            $primaryKeyAll .= $this->getFolderAccessId($i, 'array') . ",";
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

    function create() {
        
    }

    /* (non-PHPdoc)
     * @see ValidationClass::update()
     */

    function update() {
        
    }

    /* (non-PHPdoc)
     * @see ValidationClass::delete()
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
     * Set Folder Access  Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setFolderAccessId($value, $key, $type) {
        if ($type == 'single') {
            $this->folderAccessId = $value;
        } else if ($type == 'array') {
            $this->folderAccessId [$key] = $value;
        } else {
            echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setFolderAccessId ?"));
            exit();
        }
    }

    /**
     * Return Folder Access Identification
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return int|array
     */
    public function getFolderAccessId($key, $type) {
        if ($type == 'single') {
            return $this->folderAccessId;
        } else if ($type == 'array') {
            return $this->folderAccessId [$key];
        } else {
            echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setFolderAccessId ?"));
            exit();
        }
    }

    /**
     * Set Folder Identification Value
     * @param  int $value
     */
    public function setFolderId($value) {
        $this->folderId = $value;
    }

    /**
     * Return Folder Identification Value
     * @return int
     */
    public function getFolderId() {
        return $this->folderId;
    }

    /**
     * Set Group Identification Value
     * @param  int $value
     */
    public function setTeamId($value) {
        $this->teamId = $value;
    }

    /**
     * Return Group Identification Value
     * @return int
     */
    public function getTeamId() {
        return $this->teamId;
    }

    /**
     * Set Folder Access Value
     * @param bool|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setFolderAccessValue($value, $key, $type) {
        if ($type == 'single') {
            
        } else if ($type == 'array') {
            $this->folderAccessValue [$key] = $value;
        }
    }

    /**
     * Return Folder Access Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return bool|array
     */
    public function getFolderAccessValue($key, $type) {
        if ($type == 'single') {
            
        } else if ($type == 'array') {
            return $this->folderAccessValue [$key];
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

    /**
     * Set Module Identification Value
     * @param  int $value
     */
    public function setModuleId($value) {
        $this->moduleId = $value;
    }

    /**
     * Return Module Identification Value
     * @return int
     */
    public function getModuleId() {
        return $this->moduleId;
    }

}

?>