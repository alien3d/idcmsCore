<?php
require_once ("../../class/classValidation.php");
/**
 * this is Extjs Label  Translation model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Translation
 * @subpackage  Extjs / Sencha Label Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ExtLabelModel extends ValidationClass {
	/**
	 * ExtJS / Sencha Label Identification
	 * @var int
	 */
	private $extLabelId;
	/**
	 * Ext JS /Sencha  English 
	 * @var string
	 */
	private $extLabelEnglish;
	/**
	 * Class Loader to load outside variable and test it suppose variable type
	 */
	function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName ( 'extLabel' );
		$this->setPrimaryKeyName ( 'extLabelId' );
		/*
		 *  All the $_POST enviroment.
		 */
		if (isset ( $_POST ['extLabelId'] )) {
			$this->setextLabelId ( $this->strict ( $_POST ['extLabelId'], 'numeric' ), 0, 'single' );
		}
		if (isset ( $_POST ['extLabelSequence'] )) {
			$this->setextLabelSequence ( $this->strict ( $_POST ['extLabelSequence'], 'memo' ) );
		}
		if (isset ( $_POST ['extLabelCode'] )) {
			$this->setextLabelCode ( $this->strict ( $_POST ['extLabelCode'], 'memo' ) );
		}
		if (isset ( $_POST ['extLabelNote'] )) {
			$this->setextLabelNote ( $this->strict ( $_POST ['extLabelNote'], 'memo' ) );
		}
		
		if (isset ( $_GET ['extLabelId'] )) {
			$this->setTotal ( count ( $_GET ['extLabelId'] ) );
		}
		if (isset ( $_GET ['extLabelId'] )) {
			if (is_array ( $_GET ['extLabelId'] )) {
				$this->extLabelId = array ();
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
			if (isset ( $_GET ['extLabelId'] )) {
				$this->setExtLabelId ( $this->strict ( $_GET ['extLabelId'] [$i], 'numeric' ), $i, 'array' );
			}
			if (isset ( $_GET ['isDefault'] )) {
				if ($_GET ['isDefault'] [$i] == 'true') {
					$this->setIsDefault ( 1, $i, 'array' );
				} else {
					$this->setIsDefault ( 0, $i, 'array' );
				}

			} else {
				$this->setIsDefault ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isNew'] )) {
				if ($_GET ['isNew'] [$i] == 'true') {
					$this->setIsNew ( 1, $i, 'array' );
				}else {
					$this->setIsNew ( 0, $i, 'array' );
				}
			} else {
				$this->setIsNew ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isDraft'] )) {
				if ($_GET ['isDraft'] [$i] == 'true') {
					$this->setIsDraft ( 1, $i, 'array' );
				}else {
					$this->setIsDraft ( 0, $i, 'array' );
				}
			} else {
				$this->setIsDraft ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isUpdate'] )) {
				if ($_GET ['isUpdate'] [$i] == 'true') {
					$this->setIsUpdate ( 1, $i, 'array' );
				}else {
					$this->setIsUpdate ( 0, $i, 'array' );
				}
			} else {
				$this->setIsUpdate ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isDelete'] )) {
				if ($_GET ['isDelete'] [$i] == 'true') {
					$this->setIsDelete ( 1, $i, 'array' );
				}else {
					$this->setIsDelete ( 0, $i, 'array' );
				}
			} else {
				$this->setIsDelete ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isActive'] )) {
				if ($_GET ['isActive'] [$i] == 'true') {
					$this->setIsActive ( 1, $i, 'array' );
				}else {
					$this->setIsActive ( 0, $i, 'array' );
				}
			} else {
				$this->setIsActive ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isApproved'] )) {
				if ($_GET ['isApproved'] [$i] == 'true') {
					$this->setIsApproved ( 1, $i, 'array' );
				}else {
					$this->setIsApproved ( 0, $i, 'array' );
				}
			} else {
				$this->setIsApproved ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isReview'] )) {
				if ($_GET ['isReview'] [$i] == 'true') {
					$this->setIsReview ( 1, $i, 'array' );
				}else {
					$this->setIsReview ( 0, $i, 'array' );
				}
			} else {
				$this->setIsReview ( 0, $i, 'array' );
			}
			if (isset ( $_GET ['isPost'] )) {
				if ($_GET ['isPost'] [$i] == 'true') {
					$this->setIsPost ( 1, $i, 'array' );
				}	else {
					$this->setIsPost ( 0, $i, 'array' );
				}
			} else {
				$this->setIsPost ( 0, $i, 'array' );
			}
			$primaryKeyAll .= $this->getDefaultLabelId ( $i, 'array' ) . ",";
		}
		$this->setPrimaryKeyAll ( (substr ( $primaryKeyAll, 0, - 1 )) );
		if (isset ( $_SESSION ['staffId'] )) {
			$this->setExecuteBy ( $_SESSION ['staffId'] );
		}
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
		$this->setIsApproved ( 1, 0, 'single' );
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
	 * Set Default Label Translation   Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setExtLabelId($value, $key, $type) {
		if ($type == 'single') {
			$this->extLabelId = $value;
		} else if ($type == 'array') {
			$this->extLabelId [$key] = $value;
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type Single Or Array:setExtLabelId ?" ) );
			exit ();
		}
	}
	/**
	 * Return Ext Label Identification Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getExtLabelId($key, $type) {
		if ($type == 'single') {
			return $this->extLabelId;
		} else if ($type == 'array') {
			return $this->extLabelId [$key];
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type Single Or Array: getExtLabelId ?" ) );
			exit ();
		}
	}
	/**
	 * Set Extjs Label English Value
	 * @param  string $value
	 */
	public function setExtLabelEnglish($value) {
		$this->extLabelEnglish = $value;
	}
	/**
	 * Return Label English Value
	 * @return string
	 */
	public function getExtLabelEnglish() {
		return $this->extLabelEnglish;
	}
}
?>