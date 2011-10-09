<?php

require_once ("../../class/classValidation.php");
/**
 * this is folder model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage folder
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class FolderModel extends ValidationClass
{
    /**
     * Folder  Identification
     * @var int
     */
    private $folderId;
    /**
     * Module Identification
     * @var int
     */
    private $moduleId;
    /**
     * Icon Identification
     * @var int
     */
    private $iconId;
    /**
     * Folder Sequence
     * @var int
     */
    private $folderSequence;
    /**
     * Folder Code
     * @var string
     */
    private $folderCode;
    /**
     * Folder Path
     * @var string
     */
    private $folderPath;
    /**
     * Folder Note
     * @var string
     */
    private $folderNote;
    /* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */
    function execute ()
    {
        /*
		 *  Basic Information Table
		 */
        $this->setTableName('folder');
        $this->setPrimaryKeyName('folderId');
        /*
		 *  All the $_POST enviroment.
		 */
        if (isset($_POST['folderId'])) {
            $this->setFolderId($this->strict($_POST['folderId'], 'numeric'), 0, 
            'single');
        }
        if (isset($_POST['moduleId'])) {
            $this->setModuleId($this->strict($_POST['moduleId'], 'numeric'));
        }
        if (isset($_POST['iconId'])) {
            $this->setIconId($this->strict($_POST['iconId'], 'numeric'));
        }
        if (isset($_POST['folderPath'])) {
            $this->setFolderPath($this->strict($_POST['folderPath'], 'memo'));
        }
        if (isset($_POST['folderSequence'])) {
            $this->setfolderSequence(
            $this->strict($_POST['folderSequence'], 'memo'));
        }
        if (isset($_POST['folderCode'])) {
            $this->setFolderCode($this->strict($_POST['folderCode'], 'memo'));
        }
        if (isset($_POST['folderNote'])) {
            $this->setFolderNote($this->strict($_POST['folderNote'], 'memo'));
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
        $this->setTotal(count($_GET['folderId']));
        $accessArray = array("isDefault", "isNew", "isDraft", "isUpdate", 
        "isDelete", "isActive", "isApproved","isReview","isPost");
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
            $this->setFolderId($this->strict($_GET['folderId'][$i], 'numeric'), 
            $i, 'array');
            if ($_GET['isDefault'][$i] == 'true') {
                $this->setIsDefault(1, $i, 'array');
            } else 
                if ($_GET['default'] == 'FALSE') {
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
                if ($_GET['isDelete'][$i] == 'FALSE') {
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
            $primaryKeyAll .= $this->getFolderId($i, 'array') . ",";
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
     * Update folder Table Status
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
     * Set folder indentification  Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setFolderId ($value, $key, $type)
    {
        if ($type == 'single') {
            $this->folderId = $value;
        } else 
            if ($type == 'array') {
                $this->folderId[$key] = $value;
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:setFolderId ?"));
                exit();
            }
    }
    /**
     * Return folder Identification
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return int|array
     */
    public function getFolderId ($key, $type)
    {
        if ($type == 'single') {
            return $this->folderId;
        } else 
            if ($type == 'array') {
                return $this->folderId[$key];
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:getFolderId ?"));
                exit();
            }
    }
    /**
     * Set Module Identification
     * @param int $value
     */
    public function setModuleId ($value)
    {
        $this->moduleId = $value;
    }
    /**
     * Return Module Identication Value
     * @return int
     */
    public function getModuleId ()
    {
        return $this->moduleId;
    }
    /**
     * Set icon identification  Value
     * @param int $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setIconId ()
    {
        $this->iconId = $value;
    }
    /**
     * Return Icon Identification Value
     * @return int
     */
    public function getIconId ()
    {
        return $this->iconId;
    }
    /**
     * Set Folder Sequence
     * @param  int $value
     */
    public function setFolderSequence ($value)
    {
        $this->folderSequence = $value;
    }
    /**
     * Return folder Sequence
     * @return int $folderSequence
     */
    public function getFolderSequence ()
    {
        return $this->folderSequence;
    }
    /**
     * Set Folder Code
     * @param  int $value
     */
    public function setFolderCode ($value)
    {
        $this->folderSequence = $value;
    }
    /**
     * Return folder Code
     * @return int $folderCode
     */
    public function getFolderCode ()
    {
        return $this->folderCode;
    }
    /**
     * Set Folder Path
     * @param string $value
     */
    public function setFolderPath ($value)
    {
        $this->folderPath = $value;
    }
    /**
     * Return folder Path
     * @return string $folderPath
     */
    public function getfolderPath ()
    {
        return $this->folderPath;
    }
    /**
     * Set Folder Note Value (english)
     * @param string $value
     */
    public function setfolderNote ($value)
    {
        $this->folderNote = $value;
    }
    /**
     * Return folder Note (english)
     * @return string $folderNote
     */
    public function getfolderNote ()
    {
        return $this->folderNote;
    }
}
?>