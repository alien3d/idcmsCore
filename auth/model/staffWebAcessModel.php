<?php

require_once ("../../class/classValidation.php");

/**
 * this is document model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Document
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class StaffWebAcessModel extends ValidationClass {

    /**
     * @var int
     */
    private $staffWebAccessId;

    /**
     * @var int
     */
    private $staffId;

    /**
     * @var datetime
     */
    private $staffWebAccessLogIn;

    /**
     * @var datetime
     */
    private $staffWebAccessLogOut;

    /**
     * @var string
     */
    private $phpSession;

    /**
     * Class Loader to load outside variable and test it suppose variable type
     */
    function execute() {
        /*
         *  Basic Information Table
         */
        $this->setTableName('staffWebAcess');
        $this->setPrimaryKeyName('staffWebAcessId');
        $this->setPhpSession(session_id());

        if ($this->getVendor() == self::MYSQL) {
            $this->setStaffWebAccessLogIn("'" . date("Y-m-d H:i:s") . "'");
        } else if ($this->getVendor() == self::MSSQL) {
            $this->setStaffWebAccessLogIn("'" . date("Y-m-d H:i:s") . "'");
        } else if ($this->getVendor() == self::ORACLE) {
            $this->setStaffWebAccessLogIn("to_date('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')");
        } else {
            echo "udentified vendor ?";
        }
        if ($this->getVendor() == self::MYSQL) {
            $this->setStaffWebAccessLogin("'" . date("Y-m-d H:i:s") . "'");
        } else if ($this->getVendor() == self::MSSQL) {
            $this->setStaffWebAccessLogOut("'" . date("Y-m-d H:i:s") . "'");
        } else if ($this->getVendor() == self::ORACLE) {
            $this->setStaffWebAccessLogOut("to_date('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')");
        } else {
            echo "udentified vendor ?";
        }
    }

    /* (non-PHPdoc)
     * @see ValidationClass::create()
     */

    public function create() {
        
    }

    /* (non-PHPdoc)
     * @see ValidationClass::update()
     */

    public function update() {
        
    }

    /* (non-PHPdoc)
     * @see ValidationClass::delete()
     */

    public function delete() {
        
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

    /**
     * Set Staff Web Access Identification Value
     * @param  int $value
     */
    public function setStaffWebAccessId($value) {
        $this->staffWebAccessId = $value;
    }

    /**
     * Return Staff Web Access Identification Value
     * @return int 
     */
    public function getStaffWebAccessId() {
        return $this->staffWebAccessId;
    }

    /*
     * Set Staff Identification Value
     * @param  int $value
     */

    public function setStaffId($value) {
        $this->staffId = $value;
    }

    /**
     * Return Staff Identification Value
     * @return int 
     */
    public function getStaffId() {
        return $this->staffId;
    }

    /**
     * Set Staff Web Access Login Value
     * @param datetime $value
     */
    public function setStaffWebAccessLogIn($value) {
        $this->staffWebAccessLogIn = $value;
    }

    /**
     * Return Staff Web Access Login Value
     * @return int 
     */
    public function getStaffWebAccessLogIn() {
        return $this->staffWebAccessLogIn;
    }

    /**
     * Set Staff Web Access LogOut Value
     * @param datetime $value
     */
    public function setStaffWebAccessLogOut($value) {
        $this->staffWebAccessLogOut = $value;
    }

    /**
     * Return Staff Web Access LogOut Value
     * @return datetime 
     */
    public function getStaffWebAccessLogOut() {
        return $this->staffWebAccessLogOut;
    }

    /**
     * Set Staff Php Session
     * @param string $value
     */
    public function setPhpSession($value) {
        $this->staffPhpSession = $value;
    }

    /**
     * Return Staff Php Session Value
     * @return string
     */
    public function getPhpSession() {
        return $this->phpSession;
    }

}

?>
