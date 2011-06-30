<?php
require_once("../../class/classValidation.php");
/**
 * this is leafUser model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package leafUser
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafUserModel extends validationClass
{
    public $tableName;
    public $primaryKeyName;
    public $leafUserId;
    public $leafId;
    public $leafSequence;
    public $staffId;

    private $test;
    // constant method if lazy
    const tableName = 'tableName';
    const primaryKeyName = 'primaryKeyName';
    const leafUserId = 'leafUserId';
    const leafUserDesc = 'leafUserDesc';
    const isDefaut = 'isDefault';
    const isNew = 'isNew';
    const isDraft = 'isDraft';
    const isUpdate = 'isUpdate';
    const isActive = 'isActive';
    const isDelete = 'isDelete';
    const isApproved = 'isApproved';
    const By = 'By';
    const Time = 'Time';
    const staffId = 'staffId';
    /* (non-PHPdoc)
     * @see validationClass::execute()
     */
    function execute()
    {
        /*
         *  Basic Information Table
         */
        $this->tableName      = 'leafUser';
        $this->primaryKeyName = 'leafUserId';
        /*
         * SET ALL OUTSIDE VARIABLE FROM POST OR GET OR PUT OR DELETE
		 * Restfull Format  POST 			-->Is to View Data
		 *                  GET  			-->Is to Receive Data
		 *                  PUT  			-->Is To Update Data
		 *                  DELETE/Destroy  -->Is To Delete/Destroy Data
         */
        if (isset($_POST['leafUserId'])) {
            $this->leafUserId = $this->strict($_POST['leafUserId'], 'numeric');
        }
        if (isset($_POST['leafUserDesc'])) {
            $this->leafUserDesc = $this->strict($_POST['leafUserDesc'], 'memo');
        }
        if (isset($_SESSION['staffId'])) {
            $this->By = $_SESSION['staffId'];
        }
        if ($this->vendor == 'normal' || $this->getVendor()==self::mysql) {
            $this->Time = "\"". date("Y-m-d H:i:s") . "\"";
        } else if ($this->getVendor()==self::mssql) {
            $this->Time = "\"". date("Y-m-d H:i:s") . "\"";
        } else if ($this->getVendor()==self::oracle) {
            $this->Time = "to_date(\"". date("Y-m-d H:i:s") . "\",'YYYY-MM-DD HH24:MI:SS')";
        }
    }
    /* (non-PHPdoc)
     * @see validationClass::create()
     */
    function create()
    {
        $this->isDefaut   = 0;
        $this->isNew      = 1;
        $this->isDraft    = 0;
        $this->isUpdate   = 0;
        $this->isActive   = 1;
        $this->isDelete   = 0;
        $this->isApproved = 0;
    }
    /* (non-PHPdoc)
     * @see validationClass::update()
     */
    function update()
    {
        $this->isDefaut   = 0;
        $this->isNew      = 0;
        $this->isDraft    = 0;
        $this->isUpdate   = 1;
        $this->isActive   = 1;
        $this->isDelete   = 0;
        $this->isApproved = 0;
    }
    /* (non-PHPdoc)
     * @see validationClass::delete()
     */
    function delete()
    {
        $this->isDefaut   = 0;
        $this->isNew      = 0;
        $this->isDraft    = 0;
        $this->isUpdate   = 0;
        $this->isActive   = 0;
        $this->isDelete   = 1;
        $this->isApproved = 0;
    }

    function draft(){}
    function approved(){}
}
?>