<?php

require_once ("../../class/classValidation.php");
/**
 * this is  Extjs Sencha Label Translation model file.
 *
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Translation
 * @subpackage xtjs / Sencha Label Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class TableMappingTranslateModel extends ValidationClass
{
    /**
     * ExtJS / Sencha Label Identification
     * @var int
     */
    private $tableMappingTranslateId;
    /**
     * ExtJS / Sencha Label Identification
     * @var int
     */
    private $tableMappingId;
    /**
     * ExtJS / Sencha Label Identification
     * @var int
     */
    private $tableMappingTranslationNativeLabel;
    /**
     * ExtJS / Sencha Label Identification
     * @var int
     */
    private $languageId;
    /**
     * Class Loader to load outside variable and test it suppose variable type
     */
    function execute ()
    {
        /*
		 *  Basic Information Table
		 */
        $this->setTableName('tableMapping');
        $this->setPrimaryKeyName('tableMappingId');
        /*
		 *  All the $_POST enviroment.
		 */
        if (isset($_POST['tableMappingId'])) {
            $this->settableMappingId(
            $this->strict($_POST['tableMappingId'], 'numeric'), 0, 'single');
        }
        if (isset($_POST['tableMappingSequence'])) {
            $this->settableMappingSequence(
            $this->strict($_POST['tableMappingSequence'], 'memo'));
        }
        if (isset($_POST['tableMappingCode'])) {
            $this->settableMappingCode(
            $this->strict($_POST['tableMappingCode'], 'memo'));
        }
        if (isset($_POST['tableMappingNote'])) {
            $this->settableMappingNote(
            $this->strict($_POST['tableMappingNote'], 'memo'));
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
        $this->setTotal(count($_GET['tableMappingId']));
        $accessArray = array("isDefault", "isNew", "isDraft", "isUpdate", 
        "isDelete", "isActive", "isApproved","isReview","isPost");
        // auto assign as array if true
        if (is_array($_GET['tableMappingId'])) {
            $this->tableMappingId = array();
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
            $this->seTtableMappingId(
            $this->strict($_GET['tableMappingId'][$i], 'numeric'), $i, 'array');
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
    /**
     * Set Extjs/Sencha Label Translation   Value
     * @param int |array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setTableMappingTranslateId ($value, $key, $type)
    {
        if ($type == 'single') {
            $this->tableMappingTranslateId = $value;
        } else 
            if ($type == 'array') {
                $this->tableMappingTranslateId[$key] = $value;
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type Single Or Array:setThemeId ?"));
                exit();
            }
    }
    /**
     * Return Extjs/Sencha Label Identification Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return int|array
     */
    public function gettableMappingTranslateId ($key, $type)
    {
        if ($type == 'single') {
            return $this->tableMappingTranslateId;
        } else 
            if ($type == 'array') {
                return $this->tableMappingTranslateId[$key];
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type Single Or Array:setThemeId ?"));
                exit();
            }
    }
    /**
     * Set Table Mapping Identication Value
     * @param  string $value
     */
    public function setLanguageDesc ($value)
    {
        $this->languageDesc = $value;
    }
    /**
     * Return Table Mapping Identication Value
     * @return string
     */
    public function getLanguageDesc ()
    {
        return $this->languageDesc;
    }
    /**
     * Return Language Value
     * @return string
     */
    public function getTableMappingTranslationNativeLabel ()
    {
        return $this->tableMappingTranslationNativeLabel;
    }
    /**
     * Set Language Identification
     * @param  string $value
     */
    public function setTableMappingTranslationNativeLabel ($value)
    {
        $this->languageId = $value;
    }
    /**
     * Return Language Identification
     * @return string
     */
    public function getLanguageId ()
    {
        return $this->languageId;
    }
}
?>