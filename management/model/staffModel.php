<?php require_once("../../class/classValidation.php");

/**
 * this is staff model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package staffModel
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class staffModel extends validationClass{
	public $staffId_temp;
	public $groupId;
	public $languageId;
	public $staffPassword;
	public $staffName;
	public $staffNo;
	public $staffIc;
	public $isDefaut;
	public $isNew;
	public $isDraft;
	public $isUpdate;
	public $isActive;
	public $isDelete;
	public $isApproved;
	public $By;
	public $Time;
	public $vendor;
	public $staffId;

	/* (non-PHPdoc)
	 * @see validationClass::execute()
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->tableName 		=	'staff';
		$this->primaryKeyName 	=	'staffId';
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['staffId_temp'])){
			$this->staffId_temp = $this->strict($_POST['staffId_temp'],'numeric');
		}
		if(isset($_POST['groupId'])){
			$this->groupId = $this->strict($_POST['groupId'],'numeric');
		}
		if(isset($_POST['languageId'])){
			$this->languageId = $this->strict($_POST['languageId'],'numeric');
		}
		if(isset($_POST['staffPassword'])){
			$this->staffPassword = $this->strict($_POST['staffPassword'],'password');
		}
		if(isset($_POST['staffName'])){
			$this->staffName = $this->strict($_POST['staffName'],'string');
		}
		if(isset($_POST['staffNo'])){
			$this->staffNo = $this->strict($_POST['staffNo'],'numeric');
		}
		if(isset($_POST['staffIc'])){
			$this->staffIc = $this->strict($_POST['staffIc'],'string');
		}
		if($this->vendor=='normal' || $this->vendor=='lite'){
			$this->Time = date("Y-m-d H:i:s");
		} else if ($this->vendor=='microsoft'){
			$this->Time = date("Y-m-d H:i:s");
		} else if ($this->vendor=='oracle'){
			$this->Time = "to_date('".date("Y-m-d H:i:s")."','YYYY-MM-DD HH24:MI:SS')";
		}


	}
	/* (non-PHPdoc)
	 * @see configClass::create()
	 */
	function create() {
		$this-> isDefaut =0;
		$this-> isNew =1;
		$this-> isDraft=0;
		$this-> isUpdate=0;
		$this-> isActive=0;
		$this-> isDelete=0;
		$this-> isApproved=0;

	}
	
	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	function update() {
		$this-> isDefaut =0;
		$this-> isNew =0;
		$this-> isDraft=0;
		$this-> isUpdate=1;
		$this-> isActive=1;
		$this-> isDelete=0;
		$this-> isApproved=0;
	}
	
	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	function delete() {
		$this-> isDefaut =0;
		$this-> isNew =0;
		$this-> isDraft=0;
		$this-> isUpdate=0;
		$this-> isActive=0;
		$this-> isDelete=1;
		$this-> isApproved=0;
	}

}
?>