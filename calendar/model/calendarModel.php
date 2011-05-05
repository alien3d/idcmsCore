<?php require_once("../../class/classValidation.php");

/**
 * this is calendar model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package religion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */ 
class calendarModel extends validationClass{
	public $calendarId;
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
	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->tableName 		=	'calendar';
		$this->primaryKeyName 	=	'calendarId';
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['religionId'])){
			$this->religionId = $this->strict($_POST['religionId'],'numeric');
		}
		if(isset($_POST['religionDesc'])){
			$this->religionDesc = $this->strict($_POST['religionDesc'],'memo');
		}
		if(isset($_SESSION['staffId'])){
			$this->staffId = $_SESSION['staffId'];
		}
		if($this->vendor=='normal' || $this->vendor=='lite'){
			$this->Time = "'".date("Y-m-d H:i:s")."'";
		} else if ($this->vendor=='microsoft'){
			$this->Time = "'".date("Y-m-d H:i:s")."'";
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
	 * @see configClass::read()
	 */
	function read() {

	}
	/* (non-PHPdoc)
	 * @see configClass::update()
	 */
	/* (non-PHPdoc)
	 * @see configClass::update()
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
	 * @see configClass::delete()
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
	/* (non-PHPdoc)
	 * @see configClass::excel()
	 */
	function excel() {

	}
}
?>