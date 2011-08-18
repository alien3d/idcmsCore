<?php require_once("../../class/classValidation.php");

/**
 * this is Log model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage log
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class logModel extends validationClass{
	/**
	 * Log Identification
	 * @var int
	 */
	private $logId;
	/**
	 * Leaf Identification
	 * @var int
	 */
	private $leafId;
	/**
	 * Operation -  Showing which user have use access create,read ,update ,delete.
	 * @var string
	 */
	private $operation;
	/**
	 *  Sql Statement
	 * @var string
	 */
	private $sql;
	/**
	 * Date -  Date and Time Sql Statment Execute.
	 * @var date
	 */
	private $date;
	/**
	 * Starff Identification
	 * @var int
	 */
	private $staffId;
	/**
	 * Access . Granted Or Denied
	 * @var string
	 */
	private $access;
	/**
	 * Log error contain  sql statement and error message
	 * @var string
	 */
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
		if($this->vendor=='normal' || $this->getVendor()==self::mysql){
			$this->setTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::mssql){
			$this->setTime("\"".date("Y-m-d H:i:s")."\"");
		} else if ($this->getVendor()==self::oracle){
			$this->setTime("to_date(\"".date("Y-m-d H:i:s")."\",'YYYY-MM-DD HH24:MI:SS')");
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

	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function draft()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(1,0,'string');
		$this->setIsDraft(1,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(0,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(0,0,'string');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function approved()
	{
		$this->setIsDefault(0,0,'string');
		$this->setIsNew(1,0,'string');
		$this->setIsDraft(0,0,'string');
		$this->setIsUpdate(0,0,'string');
		$this->setIsActive(0,0,'string');
		$this->setIsDelete(0,0,'string');
		$this->setIsApproved(1,0,'string');
	}
}
?>