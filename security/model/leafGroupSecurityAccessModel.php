<?php require_once("../../class/classValidation.php");

/**
 * this is leaf security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package leaf
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafGroupAccessModel extends validationClass{
	public $tableName;
	public $primaryKeyName;
	public $leafAccessId;
	public $leafId;
	public $staffId;
	public $leafCreateAccessValue;
	public $leafReadAccessValue;
	public $leafUpdateAccessValue;
	public $leafDeleteAccessValue;
	public $leafPrintAccessValue;
	public $leafPostAccessValue;
	public $totalleafAccessId;
	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->tableName 		=	'leafGroupAccess';
		$this->primaryKeyName 	=	'leafGroupAccessId';
		/*
		 *  All the $_POST enviroment.
		 */
		$this->leafAccessId 		= array();
		$this->leafAccessValue 	= array();
		$this->totalleafGroupAccessId	=	count($_GET['leafGroupAccessId']);


		for($i=0;$i<$this->totalleafGroupAccessId;$i++) {
			$this->leafAccessId[$i]  = $this->strict($_GET['leafAccessId'][$i],'numeric');



			if($_GET['leafCreateAccessValue'][$i]=='true') {
				$this->leafCreateAccessValue[$i] =1;
			} else {
				$this->leafCreateAccessValue[$i]=0;
			}

			if($_GET['leafReadAccessValue'][$i]=='true') {
				$this->leafReadAccessValue[$i] =1;
			} else {
				$this->leafReadccessValue[$i]=0;
			}

			if($_GET['leafUpdateAccessValue'][$i]=='true') {
				$this->leafUpdateAccessValue[$i] =1;
			} else {
				$this->leafUpdateAccessValue[$i]=0;
			}

			if($_GET['leafDeleteAccessValue'][$i]=='true') {
				$this->leafDeleteAccessValue[$i] =1;
			} else {
				$this->leafDeleteAccessValue[$i]=0;
			}

			if($_GET['leafPrintAccessValue'][$i]=='true') {
				$this->leafPrintAccessValue[$i] =1;
			} else {
				$this->leafPrintAccessValue[$i]=0;
			}

			if($_GET['leafPostAccessValue'][$i]=='true') {
				$this->leafPostAccessValue[$i] =1;
			} else {
				$this->leafPostAccessValue[$i]=0;
			}

		}


	}

	/* (non-PHPdoc)
	 * @see validationClass::create()
	 */
	function create() {
	}

	/* (non-PHPdoc)
	 * @see validationClass::update()
	 */
	function update() {

	}

	/* (non-PHPdoc)
	 * @see validationClass::delete()
	 */
	function delete() {
	}

}
?>