<?php
require_once("../../class/classValidation.php");
/**
 * this is tab security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package tab
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class tabAccessModel extends tab
{
    public $tableName;
    public $primaryKeyName;
    public $tabAccessId;
    public $tabId;
    public $groupId;
    public $tabAccessValue;
    public $totaltabAccessId;
    /**
     *   Class Loader to load outside variable and test it suppose variable type
     */
    function execute()
    {
        /*
         *  Basic Information Table
         */
        $this->setTableName('tabAccess');
        $this->setPrimaryKeyName('tabAccessId');
        /*
         *  All the $_POST enviroment.
         */
        $this->tabAccessId      = array();
        $this->tabAccessValue   = array();
        $this->totaltabAccessId = count($_GET['tabAccessId']);
        for ($i = 0; $i < $this->totaltabAccessId; $i++) {
            $this->tabAccessId[$i] = $this->strict($_GET['tabAccessId'][$i], 'numeric');
            if ($_GET['tabAccessValue'][$i] == 'true') {
                $this->tabAccessValue[$i] = 1;
            } else {
                $this->tabAccessValue[$i] = 0;
            }
        }
    }
    /* (non-PHPdoc)
     * @see tab::create()
     */
    function create()
    {
    }
    /* (non-PHPdoc)
     * @see tab::update()
     */
    function update()
    {
    }
    /* (non-PHPdoc)
     * @see tab::delete()
     */
    function delete()
    {
    }
}
?>