<?php
require_once ("../../class/classValidation.php");
/**
 * this is Table Mapping Translation model file.This is to ensure strict setting enable for all variable enter to daFolderase
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Translation
 * @subpackage Table Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class FolderTranslateModel extends ValidationClass {
	/**
	 * Folder Identification
	 * @var int
	 */
	private $folderTranslateId;
	
	/**
	 * Folder Identification
	 * @var int
	 */
	private $folderId;
	/**
	 * Language Identification
	 * @var int
	 */
	private $languageId;
	/**
	 * Folder Native Translation
	 * @var string
	 */
	private $folderNative;
	/**
	 * Class Loader to load outside variable and test it suppose variable type
	 */
	function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName ( 'folderTranslate' );
		$this->setPrimaryKeyName ( 'folderTranslateId' );
		/**
		 * All the $_POST enviroment.
		 */
		if (isset ( $_POST ['folderTranslateId'] )) {
			$this->setFolderId ( $this->strict ( $_POST ['folderId'], 'numeric' ), 0, 'single' );
		}
		if (isset ( $_POST ['folderId'] )) {
			$this->setFolderId ( $this->strict ( $_POST ['folderId'], 'memo' ) );
		}
		if (isset ( $_POST ['folderCode'] )) {
			$this->setFolderCode ( $this->strict ( $_POST ['languageId'], 'memo' ) );
		}
		if (isset ( $_POST ['folderNative'] )) {
			$this->setFolderNative ( $this->strict ( $_POST ['folderNative'], 'memo' ) );
		}
		
		/**
		 * All the $_GET enviroment.
		 */
		if (isset ( $_GET ['folderTranslateId'] )) {
			$this->setTotal ( count ( $_GET ['folderTranslateId'] ) );
		}
		// auto assign as array if true
		if (isset ( $_GET ['folderTranslateId'] )) {
			if (is_array ( $_GET ['folderTranslateId'] )) {
				$this->folderTranslateId = array ();
			}
		}
		if (isset ( $_GET ['isDefault'] )) {
			if (is_array ( $_GET ['isDefault'] )) {
				$this->isDefault = array ();
			}
		}
		if (isset ( $_GET ['isNew'] )) {
			if (is_array ( $_GET ['isNew'] )) {
				$this->isNew = array ();
			}
		}
		if (isset ( $_GET ['isDraft'] )) {
			if (is_array ( $_GET ['isDraft'] )) {
				$this->isDraft = array ();
			}
		}
		if (isset ( $_GET ['isUpdate'] )) {
			if (is_array ( $_GET ['isUpdate'] )) {
				$this->isUpdate = array ();
			}
		}
		if (isset ( $_GET ['isDelete'] )) {
			if (is_array ( $_GET ['isDelete'] )) {
				$this->isDelete = array ();
			}
		}
		if (isset ( $_GET ['isActive'] )) {
			if (is_array ( $_GET ['isActive'] )) {
				$this->isActive = array ();
			}
		}
		if (isset ( $_GET ['isApproved'] )) {
			if (is_array ( $_GET ['isApproved'] )) {
				$this->isApproved = array ();
			}
		}
		if (isset ( $_GET ['isReview'] )) {
			if (is_array ( $_GET ['isReview'] )) {
				$this->isReview = array ();
			}
		}
		if (isset ( $_GET ['isPost'] )) {
			if (is_array ( $_GET ['isPost'] )) {
				$this->isPost = array ();
			}
		}
		$primaryKeyAll = '';
		for($i = 0; $i < $this->getTotal (); $i ++) {
			if (isset ( $_GET ['folderTranslateId'] )) {
				$this->setDefaultLabelTranslateId ( $this->strict ( $_GET ['folderTranslateId'] [$i], 'numeric' ), $i, 'array' );
			}
			if (isset ( $_GET ['isDefault'] )) {
				if ($_GET ['isDefault'] [$i] == 'true') {
					$this->setIsDefault ( 1, $i, 'array' );
				}
			} else {
				$this->setIsDefault ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isNew'] )) {
				if ($_GET ['isNew'] [$i] == 'true') {
					$this->setIsNew ( 1, $i, 'array' );
				}
			} else {
				$this->setIsNew ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isDraft'] )) {
				if ($_GET ['isDraft'] [$i] == 'true') {
					$this->setIsDraft ( 1, $i, 'array' );
				}
			} else {
				$this->setIsDraft ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isUpdate'] )) {
				if ($_GET ['isUpdate'] [$i] == 'true') {
					$this->setIsUpdate ( 1, $i, 'array' );
				}
			} else {
				$this->setIsUpdate ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isDelete'] )) {
				if ($_GET ['isDelete'] [$i] == 'true') {
					$this->setIsDelete ( 1, $i, 'array' );
				}
			} else {
				$this->setIsDelete ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isActive'] )) {
				if ($_GET ['isActive'] [$i] == 'true') {
					$this->setIsActive ( 1, $i, 'array' );
				}
			} else {
				$this->setIsActive ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isApproved'] )) {
				if ($_GET ['isApproved'] [$i] == 'true') {
					$this->setIsApproved ( 1, $i, 'array' );
				}
			} else {
				$this->setIsApproved ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isReview'] )) {
				if ($_GET ['isReview'] [$i] == 'true') {
					$this->setIsReview ( 1, $i, 'array' );
				}
			} else {
				$this->setIsReview ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isPost'] )) {
				if ($_GET ['isPost'] [$i] == 'true') {
					$this->setIsPost ( 1, $i, 'array' );
				}
			} else {
				$this->setIsPost ( 0, $i, 'array' );
			}
			$primaryKeyAll .= $this->getDefaultLabelId ( $i, 'array' ) . ",";
		}
		$this->setPrimaryKeyAll ( (substr ( $primaryKeyAll, 0, - 1 )) );
		/**
		 * All the $_SESSION enviroment.
		 */
		if (isset ( $_SESSION ['staffId'] )) {
			$this->setExecuteBy ( $_SESSION ['staffId'] );
		}
		/**
		 * TimeStamp Value.
		 */
		if ($this->getVendor () == self::MYSQL) {
			$this->setExecuteTime ( "'" . date ( "Y-m-d H:i:s" ) . "'" );
		} else if ($this->getVendor () == self::MSSQL) {
			$this->setExecuteTime ( "'" . date ( "Y-m-d H:i:s" ) . "'" );
		} else if ($this->getVendor () == self::ORACLE) {
			$this->setExecuteTime ( "to_date('" . date ( "Y-m-d H:i:s" ) . "','YYYY-MM-DD HH24:MI:SS')" );
		}
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::create()
	 */
	public function create() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 1, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 1, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 0, 0, 'single' );
		$this->setIsReview ( 0, 0, 'single' );
		$this->setIsPost ( 0, 0, 'single' );
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::update()
	 */
	public function update() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 0, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 1, 0, 'single' );
		$this->setIsActive ( 1, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 0, 0, 'single' );
		$this->setIsReview ( 0, 0, 'single' );
		$this->setIsPost ( 0, 0, 'single' );
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::delete()
	 */
	public function delete() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 0, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 0, 0, 'single' );
		$this->setIsDelete ( 1, 0, 'single' );
		$this->setIsApproved ( 0, 0, 'single' );
		$this->setIsReview ( 0, 0, 'single' );
		$this->setIsPost ( 0, 0, 'single' );
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::draft()
	 */
	public function draft() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 1, 0, 'single' );
		$this->setIsDraft ( 1, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 0, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 0, 0, 'single' );
		$this->setIsReview ( 0, 0, 'single' );
		$this->setIsPost ( 0, 0, 'single' );
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::draft()
	 */
	public function approved() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 1, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 0, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsReview ( 0, 0, 'single' );
		$this->setIsPost ( 0, 0, 'single' );
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::review()
	*/
	public function review() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 1, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 0, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 0, 0, 'single' );
		$this->setIsReview ( 1, 0, 'single' );
		$this->setIsPost ( 0, 0, 'single' );
	}
	/* (non-PHPdoc)
	* @see ValidationClass::post()
	*/
	public function post() {
		$this->setIsDefault ( 0, 0, 'single' );
		$this->setIsNew ( 1, 0, 'single' );
		$this->setIsDraft ( 0, 0, 'single' );
		$this->setIsUpdate ( 0, 0, 'single' );
		$this->setIsActive ( 0, 0, 'single' );
		$this->setIsDelete ( 0, 0, 'single' );
		$this->setIsApproved ( 1, 0, 'single' );
		$this->setIsReview ( 0, 0, 'single' );
		$this->setIsPost ( 1, 0, 'single' );
	}
	/**
	 * Set Folder Translation   Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setFolderTranslateId($value, $key, $type) {
		if ($type == 'single') {
			$this->folderTranslateId = $value;
		} else if ($type == 'array') {
			$this->folderTranslateId [$key] = $value;
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type Single Or Array:setFolderTranslateId ?" ) );
			exit ();
		}
	}
	/**
	 * Return Folder Translation Identification
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getFolderTranslateId($key, $type) {
		if ($type == 'single') {
			return $this->folderTranslateId;
		} else if ($type == 'array') {
			return $this->folderTranslateId [$key];
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type Single Or Array:setFolderTranslateId ?" ) );
			exit ();
		}
	}
	/**
	 * Set Folder Identication Value
	 * @param  int $value
	 */
	public function setFolderId($value) {
		$this->folderId = $value;
	}
	/**
	 * Return Folder Identication Value
	 * @return int
	 */
	public function getFolderId() {
		return $this->folderId;
	}
	/**
	 * Set folderText  Value
	 * @param  string $value
	 */
	public function setfolderNative($value) {
		$this->folderNative = $value;
	}
	/**
	 * Return folderNative
	 * @return string
	 */
	public function getFolderNative() {
		return $this->folderNative;
	}
	/**
	 * Set Language Identification
	 * @param  string $value
	 */
	public function setLanguageId($value) {
		$this->languageId = $value;
	}
	/**
	 * Return Language Identification
	 * @return string Language Identification
	 */
	public function getLanguageId() {
		return $this->languageId;
	}
}
?>