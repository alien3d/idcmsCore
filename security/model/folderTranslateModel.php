<?php
require_once ("../../class/classValidation.php");
/**
 * this is Folder Translation Model file.This is to ensure strict setting enable for all variable enter to database
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage Folder Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class FolderTranslationModel extends ValidationClass
{
    /**
     * Folder  Translate Identification
     * @var int
     */
    private $folderTranslateId;
    /**
     * Folder  Identification
     * @var int
     */
    private $folderId;
    /**
     * Language  Identification
     * @var int
     */
    private $languageId;
    /**
     * Folder  Translate
     * @var string
     */
    private $folderTranslate;
    /* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */
    function execute ()
    {
        /**
         * Basic Information Table
         */
        $this->setTableName('folderTranslate');
        $this->setPrimaryKeyName('folderTranslateId');
        /**
         * All the $_POST enviroment.
         */
        if (isset($_POST['folderTranslateId'])) {
            $this->setFolderTranslateId(
            $this->strict($_POST['folderTranslateId'], 'numeric'));
        }
        if (isset($_POST['folderId'])) {
            $this->setFolderId($this->strict($_POST['folderId'], 'numeric'));
        }
        if (isset($_POST['languageId'])) {
            $this->setLanguageId($this->strict($_POST['languageId'], 'numeric'));
        }
        if (isset($_POST['folderTranslate'])) {
            $this->setFolderTranslate(
            $this->strict($_POST['folderTranslate'], 'memo'));
        }
        if (isset($_SESSION['staffId'])) {
            $this->setExecuteBy($_SESSION['staffId']);
        }
        if ($this->getVendor() == self::mysql) {
            $this->setExecuteTime("\"" . date("Y-m-d H:i:s") . "\"");
        } else 
            if ($this->getVendor() == self::mssql) {
                $this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
            } else 
                if ($this->getVendor() == self::oracle) {
                    $this->setExecuteTime(
                    "to_date('" . date("Y-m-d H:i:s") .
                     "','YYYY-MM-DD HH24:MI:SS')");
                }
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
     * Set Folder indentification  Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setFolderTranslateId ($value, $key, $type)
    {
        if ($type == 'single') {
            $this->folderTranslateId = $value;
        } else 
            if ($type == 'array') {
                $this->folderTranslateId[$key] = $value;
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:setFolderTranslateId ?"));
                exit();
            }
    }
    /**
     * Return Folder Translate Identification Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return int|array
     */
    public function getFolderTranslateId ($key, $type)
    {
        if ($type == 'single') {
            return $this->folderTranslateId;
        } else 
            if ($type == 'array') {
                return $this->folderTranslateId[$key];
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:getFolderTranslateId ?"));
                exit();
            }
    }
    /**
     * Set Folder Identification  Value
     * @param int $value
     */
    public function setFolderId ($value)
    {
        $this->folderId = $value;
    }
    /**
     * Return folder Identification Value
     * @return int
     */
    public function getFolderId ()
    {
        return $this->folderId;
    }
    /**
     * Set Language Identification  Value
     * @param int $value
     */
    public function setLanguageId ($value)
    {
        $this->languageId = $value;
    }
    /**
     * Return Language Identification Value
     * @return int
     */
    public function getLanguageId ()
    {
        return $this->languageId;
    }
    /**
     * Set Folder Translate
     * @param string $value
     */
    public function setFolderTranslate ($value)
    {
        $this->folderTranslate = $value;
    }
    /**
     * Return Folder Translate
     * @return string
     */
    public function getTranslate ()
    {
        return $this->folderTranslate;
    }
}
?>