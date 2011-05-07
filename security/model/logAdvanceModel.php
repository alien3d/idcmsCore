<?php require_once("../../class/classValidation.php");

/**
 * this is accordion model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package accordion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class accordionModel extends validationClass{
	public $tableName;
	public $primaryKeyName;
	public $iconId;
	public $accordionId;
	public $accordionNote;
	public $accordionSequence;
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
		$this->tableName 		=	'accordion';
		$this->primaryKeyName 	=	'accordionId';
		/*
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['iconId'])){
			$this->iconId = $this->strict($_POST['iconId'],'numeric');
		}
		if(isset($_POST['accordionId'])){
			$this->accordionId = $this->strict($_POST['accordionId'],'numeric');
		}
		if(isset($_POST['accordionSequence'])){
			$this->accordionSequence = $this->strict($_POST['accordionSequence'],'numeric');
		}
		if(isset($_POST['accordionNote'])){
			$this->accordionNote = $this->strict($_POST['accordionNote'],'memo');
		}
		if(isset($_SESSION['staffId'])){
			$this->By = $_SESSION['staffId'];
		}
		if($this->vendor=='normal' || $this->vendor=='mysql'){
			$this->Time = "'".date("Y-m-d H:i:s")."'";
		} else if ($this->vendor=='microsoft'){
			$this->Time = "'".date("Y-m-d H:i:s")."'";
		} else if ($this->vendor=='oracle'){
			$this->Time = "to_date('".date("Y-m-d H:i:s")."','YYYY-MM-DD HH24:MI:SS')";
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