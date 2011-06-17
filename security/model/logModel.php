<?php require_once("../../class/classValidation.php");

/**
 * this is Log model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package accordion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class logModel extends validationClass{
	private $logId;
	private $leafId;
	private $operation;
	private $sql;
	private $date;
	private $staffId;
	private $access;
	private $logError;
	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('log');
		$this->setPrimaryKeyName('logId');
		/*
		 *  All the $_POST enviroment.
		 */

		if(isset($_SESSION['staffId'])){
			$this->setBy($_SESSION['staffId']);
		}
		if($this->vendor=='normal' || $this->vendor=='mysql'){
			$this->setTime("'".date("Y-m-d H:i:s")."'");
		} else if ($this->vendor=='microsoft'){
			$this->setTime("'".date("Y-m-d H:i:s")."'");
		} else if ($this->vendor=='oracle'){
			$this->setTime("to_date('".date("Y-m-d H:i:s")."','YYYY-MM-DD HH24:MI:SS')");
		}


	}

	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	function create() {
		$this->isDefaut =0;
		$this->isNew =1;
		$this->isDraft=0;
		$this->isUpdate=0;
		$this->isActive=0;
		$this->isDelete=0;
		$this->isApproved=0;

	}

	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	function update() {
		$this->isDefaut =0;
		$this->isNew =0;
		$this->isDraft=0;
		$this->isUpdate=1;
		$this->isActive=1;
		$this->isDelete=0;
		$this->isApproved=0;
	}

	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	function delete() {
		$this->isDefaut =0;
		$this->isNew =0;
		$this->isDraft=0;
		$this->isUpdate=0;
		$this->isActive=0;
		$this->isDelete=1;
		$this->isApproved=0;
	}

}
?>