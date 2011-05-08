<?php require_once("../../class/classValidation.php");

/**
 * this is accordion security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package accordion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class accordionSecurityAccessModel extends validationClass{
	public $tableName;
	public $primaryKeyName;
	public $accordionAccessId;
	public $accordionId;
	public $groupId;
	public $accordionAccessValue;
	public $totalAccordionAccessId;
	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->tableName 		=	'accordionAccess';
		$this->primaryKeyName 	=	'accordionAccessId';
		/*
		 *  All the $_POST enviroment.
		 */
		$this->accordionAccessId 		= array();
		$this->accordionAccessValue 	= array();
		$this->totalAccordionAccessId	=	count($_GET[$accordionAccessId]);


		for($i=0;$i<$this->totalAccordionAccessId;$i++) {
			$this->accordionAccessId[$i]  = $this->strict($_GET['accordionAccessId'][$i],'numeric');
			if($_GET[$accordionAccessValue][$i]=='true') {
				$this->accordionAccessValue[$i] =1;
			} else {
				$this->accordionAccessValue[$i]=0;
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