<?php require_once("../../class/classValidation.php");

/**
 * this is leaf model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package religion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafModel extends validationClass{
	public $tableName;
	public $primaryKeyName;
	public $leafId;
	public $accordionId;
	public $folderId;
	public $iconId;
	public $leafSequence;
	public $leafCode;
	public $leafFilename;
	public $leafNote;
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
		 *  All the $_POST enviroment.
		 */
		if(isset($_POST['leafId'])){
			$this->leafId = $this->strict($_POST['leafId'],'numeric');
		}
		if(isset($_POST['accordionId'])){
			$this->accordionId = $this->strict($_POST['accordionId'],'numeric');
		}
		if(isset($_POST['folderId'])){
			$this->folderId = $this->strict($_POST['folderId'],'numeric');
		}
		if(isset($_POST['iconId'])){
			$this->iconId = $this->strict($_POST['iconId'],'numeric');
		}
		if(isset($_POST['leafSequence'])){
			$this->leafSequence = $this->strict($_POST['leafSequence'],'numeric');
		}
		if(isset($_POST['leafFilename'])){
			$this->leafFilename = $this->strict($_POST['leafFilename'],'memo');
		}

		if(isset($_POST['leafNote'])){
			$this->leafNote = $this->strict($_POST['leafNote'],'memo');
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
		$this->isDefaut 	=	0;
		$this->isNew 		=	1;
		$this->isDraft		=	0;
		$this->isUpdate		=	0;
		$this->isActive		=	1;
		$this->isDelete		=	0;
		$this->isApproved	=	0;

	}

	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	function update() {
		$this->isDefaut 	=	0;
		$this->isNew 		=	0;
		$this-> isDraft		=	0;
		$this->isUpdate	=	1;
		$this->isActive	=	1;
		$this->isDelete	=	0;
		$this->isApproved	=	0;
	}

	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	function delete() {
		$this->isDefaut 	=	0;
		$this->isNew 		=	0;
		$this->isDraft		=	0;
		$this->isUpdate		=	0;
		$this->isActive		=	0;
		$this->isDelete		=	1;
		$this->isApproved	=	0;
	}
	

}
?>