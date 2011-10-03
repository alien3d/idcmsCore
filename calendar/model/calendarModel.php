<?php
require_once ("../../class/classValidation.php");
/**
 * this is calendar model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package calendar
 * @subpackage calendar
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class CalendarModel extends ValidationClass
{
    /**
     * Calendar Color Identification
     * @var int
     */
    private $calendarId;
    /**
     * Calendar Color Id . This is link back with the color in CSS File
     * @var int
     */
    private $calendarColorId;
    /**
     * Calendar Title.This is calendar color description
     * @var string
     */
    private $calendarTitle;
    /**
     * Enter description here ...
     * @var int
     */
    private $staffId;
    /**
     * Class Loader to load outside variable and test it suppose variable type
     */
    function execute ()
    {
        /*
		 *  Basic Information Table
		 */
        $this->setTableName('calendar');
        $this->setPrimaryKeyName('calendarId');
        /*
		 *  All the $_POST enviroment.
		 */
        if (isset($_POST['calendarId'])) {
            $this->setCalendarId($this->strict($_POST['calendarId'], 'numeric'));
        }
        if (isset($_POST['calendarColorId'])) {
            $this->setCalendarColorId(
            $this->strict($_POST['calendarTitle'], 'numeric'));
        }
        if (isset($_POST['calendarTitle'])) {
            $this->setCalendarTitle(
            $this->strict($_POST['calendarTitle'], 'memo'));
        }
        if (isset($_POST['staffId'])) {
            $this->setStaffId($this->strict($_POST['calendarId'], 'memo'));
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
        $this->setIsDelete(0, 0, 'single');
        $this->setIsApproved(0, 0, 'single');
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
     * Set Calendar Value
     * @param int|array $value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     */
    public function setCalendarId ($value, $key, $type)
    {
        if ($type == 'string') {
            $this->calendarId = $value;
        } else 
            if ($type == 'array') {
                $this->calendarId[$key] = $value;
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:setCalendarId ?"));
                exit();
            }
    }
    /**
     * Return Calendar Identification Value
     * @param array[int]int $key List Of Primary Key.
     * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
     * @return int|array
     */
    public function getCalendarId ($key, $type)
    {
        if ($type == 'string') {
            return $this->calendarId;
        } else 
            if ($type == 'array') {
                return $this->calendarId[$key];
            } else {
                echo json_encode(
                array("success" => false, 
                "message" => "Cannot Identifiy Type String Or Array:getCalendarId ?"));
                exit();
            }
    }
    /**
     * Set Calendar Color Value
     * @param  int $value
     */
    public function setCalendarColorId ($value)
    {
        $this->calendarColorId = $value;
    }
    /**
     * Return Calendar Color Value
     * @return int
     */
    public function getCalendarColorId ()
    {
        return $this->calendarColorId;
    }
    /**
     * Set Calendar Title Value
     * @param  int $value
     */
    public function setCalendarTitle ($value)
    {
        $this->calendarTitle = $value;
    }
    /**
     * Return Calendar Title Value
     * @return string
     */
    public function getCalendarTitle ()
    {
        return $this->calendarTitle;
    }
    /**
     * Set Staff Identification Value
     * @param  int $value
     */
    public function setStaffId ($value)
    {
        $this->staffId = $value;
    }
    /**
     * Return  Staff Identification value
     * @return int
     */
    public function getStaffId ()
    {
        return $this->staffId;
    }
}
?>
