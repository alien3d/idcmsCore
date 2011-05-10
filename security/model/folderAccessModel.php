<?php require_once("../../class/classValidation.php");

/**
 * this is folder security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package folder
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class folderAccessModel extends validationClass{
	public $tableName;
	public $primaryKeyName;
	public $folderAccessId;
	public $folderId;
	public $groupId;
	public $folderAccessValue;
	public $totalfolderAccessId;
	/**
	 *   Class Loader to load outside variable and test it suppose variable type
	 */
	function execute(){
		/*
		 *  Basic Information Table
		 */
		$this->tableName 		=	'folderAccess';
		$this->primaryKeyName 	=	'folderAccessId';
		/*
		 *  All the $_POST enviroment.
		 */
		$this->folderAccessId 		= array();
		$this->folderAccessValue 	= array();
		$this->totalfolderAccessId	=	count($_GET['folderAccessId']);


		for($i=0;$i<$this->totalfolderAccessId;$i++) {
			$this->folderAccessId[$i]  = $this->strict($_GET['folderAccessId'][$i],'numeric');
			if($_GET[$folderAccessValue][$i]=='true') {
				$this->folderAccessValue[$i] =1;
			} else {
				$this->folderAccessValue[$i]=0;
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