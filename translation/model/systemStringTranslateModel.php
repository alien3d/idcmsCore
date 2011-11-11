<?php

require_once ("../../class/classValidation.php");
/**
 * this is Table Mapping Translation model file.This is to ensure strict setting enable for all variable enter to daFolderase
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Translation
 * @subpackage System String Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class SystemStringTranslateModel extends ValidationClass {
	/**
	 * Default Label Identification
	 * @var int
	 */
	private $systemStringTranslateId;
	/**
	 * Default Label Identification
	 * @var int
	 */
	private $systemStringd;
	/**
	 * Language Identification
	 * @var int
	 */
	private $languageId;
	/**
	* Default Label Native Translation
	* @var string
	*/
	private $systemStringNative;
	/**
	 * Class Loader to load outside variable and test it suppose variable type
	 */
	function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName ( 'systemString' );
		$this->setPrimaryKeyName ( 'systemStringId' );
		/*
		 *  All the $_POST enviroment.
		 */
		if (isset ( $_POST ['systemStringId'] )) {
			$this->setsystemStringId ( $this->strict ( $_POST ['systemStringId'], 'numeric' ), 0, 'single' );
		}
		if (isset ( $_POST ['systemStringSequence'] )) {
			$this->setsystemStringSequence ( $this->strict ( $_POST ['systemStringSequence'], 'memo' ) );
		}
		if (isset ( $_POST ['systemStringCode'] )) {
			$this->setsystemStringCode ( $this->strict ( $_POST ['systemStringCode'], 'memo' ) );
		}
		if (isset ( $_POST ['systemStringNote'] )) {
			$this->setsystemStringNote ( $this->strict ( $_POST ['systemStringNote'], 'memo' ) );
		}
		
		// auto assign as array if true
		if (isset ( $_GET ['systemStringTranslateId'] )) {
			if (is_array ( $_GET ['systemStringTranslateId'] )) {
				$this->systemStringTranslateId = array ();
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
			if (isset ( $_GET ['systemStringTranslateId'] )) {
				$this->setSystemStringTranslateId ( $this->strict ( $_GET ['systemStringTranslateId'] [$i], 'numeric' ), $i, 'array' );
			}
			if (isset($_GET ['isDefault'])) {
                if ($_GET ['isDefault'] [$i] == 'true') {
                    $this->setIsDefault(1, $i, 'array');
                } else if ($_GET ['isDefault'] [$i] == 'false') {
                    $this->setIsDefault(0, $i, 'array');
                }
            }
            if (isset($_GET ['isNew'])) {
                if ($_GET ['isNew'] [$i] == 'true') {
                    $this->setIsNew(1, $i, 'array');
                } else if ($_GET ['isNew'] [$i] == 'false') {
                    $this->setIsNew(0, $i, 'array');
                }
            }
            if (isset($_GET ['isDraft'])) {
                if ($_GET ['isDraft'] [$i] == 'true') {
                    $this->setIsDraft(1, $i, 'array');
                } else if ($_GET ['isDraft'] [$i] == 'false') {
                    $this->setIsDraft(0, $i, 'array');
                }
            }
            if (isset($_GET ['isUpdate'])) {
                if ($_GET ['isUpdate'] [$i] == 'true') {
                    $this->setIsUpdate(1, $i, 'array');
                } if ($_GET ['isUpdate'] [$i] == 'false') {
                    $this->setIsUpdate(0, $i, 'array');
                }
            }
            if (isset($_GET ['isDelete'])) {
                if ($_GET ['isDelete'] [$i] == 'true') {
                    $this->setIsDelete(1, $i, 'array');
                } else if ($_GET ['isDelete'] [$i] == 'false') {
                    $this->setIsDelete(0, $i, 'array');
                }
            }
            if (isset($_GET ['isActive'])) {
                if ($_GET ['isActive'] [$i] == 'true') {
                    $this->setIsActive(1, $i, 'array');
                } else if ($_GET ['isActive'] [$i] == 'false') {
                    $this->setIsActive(0, $i, 'array');
                }
            }
            if (isset($_GET ['isApproved'])) {
                if ($_GET ['isApproved'] [$i] == 'true') {
                    $this->setIsApproved(1, $i, 'array');
                } else if ($_GET ['isApproved'] [$i] == 'false') {
                    $this->setIsApproved(0, $i, 'array');
                }
            }
            if (isset($_GET ['isReview'])) {
                if ($_GET ['isReview'] [$i] == 'true') {
                    $this->setIsReview(1, $i, 'array');
                } else if ($_GET ['isReview'] [$i] == 'false') {
                    $this->setIsReview(0, $i, 'array');
                }
            }
            if (isset($_GET ['isPost'])) {
                if ($_GET ['isPost'] [$i] == 'true') {
                    $this->setIsPost(1, $i, 'array');
                } else if ($_GET ['isPost'] [$i] == 'false') {
                    $this->setIsPost(0, $i, 'array');
                }
            }
			$primaryKeyAll .= $this->getSystemStringId ( $i, 'array' ) . ",";
		}
		$this->setPrimaryKeyAll ( (substr ( $primaryKeyAll, 0, - 1 )) );
		
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
		if (isset ( $_GET ['systemStringTranslateId'] )) {
			$this->setTotal ( count ( $_GET ['systemStringTranslateId'] ) );
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
	public function setSystemStringTranslateId($value, $key, $type) {
		if ($type == 'single') {
			$this->systemStringTranslateId = $value;
		} else if ($type == 'array') {
			$this->systemStringTranslateId [$key] = $value;
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type Single Or Array:setSystemStringTranslateId ?" ) );
			exit ();
		}
	}
	/**
	 * Return Default Label Translation Identification
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getSystemStringTranslateId($key, $type) {
		if ($type == 'single') {
			return $this->systemStringTranslateId;
		} else if ($type == 'array') {
			return $this->systemStringTranslateId [$key];
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type Single Or Array:setSystemStringTranslateId ?" ) );
			exit ();
		}
	}
	/**
	 * Set Default Label Identication Value
	 * @param  string $value
	 */
	public function setSystemStringd($value) {
		$this->systemStringd = $value;
	}
	/**
	 * Return Default Label Identication Value
	 * @return string
	 */
	public function getSystemStringId() {
		return $this->systemStringd;
	}
	/**
	 * Set Default Label Translation  Value
	 * @param  string $value
	 */
	public function setsystemStringNative($value) {
		$this->systemStringNative = $value;
	}
	/**
	 * Return Default Label Translation 
	 * @return string
	 */
	public function getSystemStringNative() {
		return $this->systemStringNative;
	}
	/**
	 * Set Language Identification
	 * @param  int $value
	 */
	public function setLanguageId($value) {
		$this->languageId = $value;
	}
	/**
	 * Return Language Identification
	 * @return int
	 */
	public function getLanguageId() {
		return $this->languageId;
	}
}
?>