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
class leafAccessModel extends validationClass{
	//table property
	public $tableName;
	public $primaryKeyName;

	//table field
	private $leafAccessId;
	private $leafId;
	private $staffId;
	private $leafCreateAccessValue;
	private $leafReadAccessValue;
	private $leafUpdateAccessValue;
	private $leafDeleteAccessValue;
	private $leafPrintAccessValue;
	private $leafPostAccessValue;
	private $totalleafAccessId;

	//table property
	const tableName='tableName';
	const primaryKeyName='primaryKeyName';

	//table field
	const leafAccessId='leafAccessId';
	const leafId='leafAccessId';
	const staffId='staffId';
	const leafCreateAccessValue='leafAccessId';
	const leafReadAccessValue='leafAccessId';
	const leafUpdateAccessValue='leafAccessId';
	const leafDeleteAccessValue='leafAccessId';
	const leafPrintAccessValue='leafAccessId';
	const leafPostAccessValue='leafAccessId';
	const totalleafAccessId='leafAccessId';


	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('leafAccess');
		$this->setPrimaryKeyName('leafAccessId');
		/*
		 *  All the $_POST enviroment.
		 */
		$this->leafAccessId 		= array();
		$this->leafAccessValue 	= array();
		$this->totalleafAccessId	=	count($_GET['leafAccessId']);


		for($i=0;$i<$this->totalleafAccessId;$i++) {
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