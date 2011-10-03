<?php

require_once ("../../class/classValidation.php");
/**
 * this is Module Translation Model file.This is to ensure strict setting enable for all variable enter to database
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage Module Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ModuleTranslationModel extends ValidationClass
{
    /**
     * Module Translation Identification
     * @var int
     */
    private $moduleTranslateId;
    /**
     * Module Identification
     * @var int
     */
    private $moduleId;
    /**
     * Language Identification
     * @var int
     */
    private $languageId;
    /**
     * Module Translation 
     * @var string
     */
    private $moduleTranslate;
    /* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */
    function execute ()
    {
        /*
		 *  Basic Information Table
		 */
        $this->setTableName('module');
        $this->setPrimaryKeyName('moduleId');
        /*
		 *  All the $_POST enviroment.
		 */
        if (isset($_POST['moduleTranslateId'])) {
            $this->setModuleTranslateId(
            $this->strict($_POST['moduleTranslateId'], 'numeric'));
        }
        if (isset($_POST['moduleId'])) {
            $this->setModuleId($this->strict($_POST['moduleId'], 'numeric'));
        }
        if (isset($_POST['languageId'])) {
            $this->setLanguageId($this->strict($_POST['languageId'], 'numeric'));
        }
        if (isset($_POST['moduleTranslate'])) {
            $this->setModuleTranslate(
            $this->strict($_POST['moduleTranslate'], 'memo'));
        }
        if (isset($_SESSION['staffId'])) {
            $this->setExecuteBy($_SESSION['staffId']);
        }
        if ($this->getVendor() == self::mysql) {
            $this->setExecuteTime("\"" . date("Y-m-d H:i:s") . "\"");
        } else 
            if ($this->getVendor() == self::mssql) {
                $this->setExecuteTime("\"" . date("Y-m-d H:i:s") . "\"");
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
     * Update module Table Status
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
     * Set Module indentification  Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setModuleTranslateId ($value, $key, $type)
    {
        if ($type == 'single') {
            $this->moduleTranslateId = $value;
        } else 
            if ($type == 'array') {
                $this->moduleTranslateId[$key] = $value;
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:setModuleTranslateId ?"));
                exit();
            }
    }
    /**
     * Return Module Translate Identification Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return int|array
     */
    public function getModuleTranslateId ($key, $type)
    {
        if ($type == 'single') {
            return $this->moduleTranslateId;
        } else 
            if ($type == 'array') {
                return $this->moduleTranslateId[$key];
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:getModuleTranslateId ?"));
                exit();
            }
    }
    /**
     * Set Module Identification  Value
     * @param int $value
     */
    public function setModuleId ($value)
    {
        $this->moduleId = $value;
    }
    /**
     * Return module Identification Value
     * @return int
     */
    public function getModuleId ()
    {
        return $this->moduleId;
    }
    /**
     * Set Language Identification  Value
     * @param int $value
     */
    public function setLanguageId ()
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
     * Set Module Translate
     * @param string $value
     */
    public function setModuleTranslate ($value)
    {
        $this->moduleTranslate = $value;
    }
    /**
     * Return Module Translate
     * @return string
     */
    public function getTranslate ()
    {
        return $this->moduleTranslate;
    }
}
?>