<?php require_once("../../class/classValidation.php");

/**
 * this is logAdvance model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage logAdvance
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class logAdvanceModel extends validationClass{
	/**
	 * Log Advance Identification
	 * @var int
	 */
	private  $logAdvanceId;
	/**
	 * Log Advance Text.Containing json   on create,update,delete
	 * @var int
	 */
	private $logAdvanceText;
	/**
	 * Log Advance Type - create ,update,delete
	 * @var int
	 */
	private $logAdvanceType;
	/**
	 * Log Advance Comparision. Containing Before and After  Sql Statement on each column
	 * @var int
	 */
	private $logAdvanceComparison;
	/**
	 * Reference Table Name
	 * @var int
	 */
	private $refTableName;
	/**
	 * Reference Identification equivilant to Reference Table Name Primary Key
	 * @var int
	 */
	private $refId;



	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->settableName('logAdvance');
		$this->setPrimaryKeyName('logAdvanceId');
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['logAdvanceId'])){
			$this->strict($_POST['logAdvanceId'],'numeric');
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
		$this->setIsDefault(0,0,'single');
		$this->setIsNew(1,0,'single');
		$this->setIsDraft(1,0,'single');
		$this->setIsUpdate(0,0,'single');
		$this->setIsActive(0,0,'single');
		$this->setIsDelete(0,0,'single');
		$this->setIsApproved(0,0,'single');
	}
	/* (non-PHPdoc)
	 * @see validationClass::draft()
	 */
	public function approved()
	{
		$this->setIsDefault(0,0,'single');
		$this->setIsNew(1,0,'single');
		$this->setIsDraft(0,0,'single');
		$this->setIsUpdate(0,0,'single');
		$this->setIsActive(0,0,'single');
		$this->setIsDelete(0,0,'single');
		$this->setIsApproved(1,0,'single');
	}
}
?>