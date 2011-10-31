<?php
require_once ("../../class/classValidation.php");
/**
 * this is staff model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Management
 * @subpackage staffModel
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class StaffModel extends ValidationClass {
	/**
	 * Staff Identification
	 * @var int
	 */
	private $staffId;
	/**
	 * Group Identification
	 * @var int
	 */
	private $teamId;
	/**
	 * Group Identification
	 * @var int
	 */
	private $departmentId;
	/**
	 * Language Identification
	 * @var int
	 */
	private $languageId;
	/**
	 * Staff Password
	 * @var string
	 */
	private $staffPassword;
	/**
	 * Staff Name
	 * @var string
	 */
	private $staffName;
	/**
	 * Staff Number
	 * @var string
	 */
	private $staffNo;
	/**
	 * Staff Identification Card Number. ** Only Valid in Malaysia
	 * @var string
	 */
	private $staffIc;
	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */
	function execute() {
		$primaryKeyAll = '';
		/*
		 *  Basic Information Table
		 */
		$this->setTableName ( 'staff' );
		$this->setPrimaryKeyName ( 'staffId' );
		/*
		 *  All the $_POST enviroment.
		 */
		if (isset ( $_POST ['staffId'] )) {
			$this->setStaffId ( $this->strict ( $_POST ['staffId'], 'numeric' ), '', 'string' );
		}
		if (isset ( $_POST ['teamId'] )) {
			$this->setTeamId ( $this->strict ( $_POST ['teamId'], 'numeric' ) );
		}
		if (isset ( $_POST ['departmentId'] )) {
			$this->setDepartmentId ( $this->strict ( $_POST ['departmentId'], 'numeric' ) );
		}
		if (isset ( $_POST ['languageId'] )) {
			$this->setLanguageId ( $this->strict ( $_POST ['languageId'], 'numeric' ) );
		} else {
			$this->setLanguageId ( 21 );
		}
		if (isset ( $_POST ['staffPassword'] )) {
			$this->setStaffPassword ( $this->strict ( $_POST ['staffPassword'], 'password' ) );
		}
		if (isset ( $_POST ['staffName'] )) {
			$this->setStaffName ( $this->strict ( $_POST ['staffName'], 'string' ) );
		}
		if (isset ( $_POST ['staffNo'] )) {
			$this->setStaffNo ( $this->strict ( $_POST ['staffNo'], 'numeric' ) );
		}
		if (isset ( $_POST ['staffIc'] )) {
			$this->setStaffIc ( $this->strict ( $_POST ['staffIc'], 'string' ) );
		}
		/**
		 * All the $_GET enviroment.
		 */
		if (isset ( $_GET ['staffId'] )) {
			$this->setTotal ( count ( $_GET ['staffId'] ) );
		}
		if (isset ( $_GET ['staffId'] )) {
			if (is_array ( $_GET ['staffId'] )) {
				$this->staffId = array ();
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
		if (isset ( $_GET ['iseDelete'] )) {
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
		for($i = 0; $i < $this->getTotal (); $i ++) {
			if (isset ( $_GET ['staffId'] )) {
				$this->setStaffId ( $this->strict ( $_GET ['staffId'] [$i], 'numeric' ), $i, 'array' );
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
			$primaryKeyAll .= $this->getStaffId ( $i, 'array' ) . ",";
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
	/* (non-PHPdoc)
     * @see ConfigClass::excel()
    */
	public function excel() {
	}
	/**
	 * Update Religion Table Status
	 */
	public function updateStatus() {
		if (! (is_array ( $_GET ['isDefault'] ))) {
			$this->setIsDefault ( 0, 0, 'single' );
		}
		if (! (is_array ( $_GET ['isNew'] ))) {
			$this->setIsNew ( 0, 0, 'single' );
		}
		if (! (is_array ( $_GET ['isDraft'] ))) {
			$this->setIsDraft ( 0, 0, 'single' );
		}
		if (! (is_array ( $_GET ['isUpdate'] ))) {
			$this->setIsUpdate ( 0, 0, 'single' );
		}
		if (! (is_array ( $_GET ['isDelete'] ))) {
			$this->setIsDelete ( 1, 0, 'single' );
		}
		if (! (is_array ( $_GET ['isActive'] ))) {
			$this->setIsActive ( 0, 0, 'single' );
		}
		if (! (is_array ( $_GET ['isApproved'] ))) {
			$this->setIsApproved ( 0, 0, 'single' );
		}
	}
	/**
	 * Set Staff Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $a  List Of Type.0 As 'string' 1 As 'array'
	 */
	public function setStaffId($value, $key, $type) {
		if ($type == 'single') {
			$this->staffId = $value;
		} else if ($type == 'array') {
			$this->staffId [$key] = $value;
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type String Or Array:setStaffId ?" ) );
			exit ();
		}
	}
	/**
	 * Return Staff Identification Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getStaffId($key = NULL, $type = NULL) {
		if ($type == 'single') {
			return $this->staffId;
		} else if ($type == 'array') {
			return $this->staffId [$key];
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type String Or Array:getStaffId ?" ) );
			exit ();
		}
	}
	/**
	 * Set  Team Identification (english)
	 * @param  int $value
	 */
	public function setTeamId($value) {
		$this->teamId = $value;
	}
	/**
	 * Return Team  Description (english)
	 * @return  int
	 */
	public function getTeamId() {
		return $this->TeamId;
	}
	/**
	 * Set  Department Identification
	 * @param  int $value
	 */
	public function setDepartmentId($value) {
		$this->departmentId = $value;
	}
	/**
	 * Return Department Identification
	 * @return int
	 */
	public function getDepartmentId() {
		return $this->departmentId;
	}
	/**
	 * Set  Language Identification
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
	/**
	 * Set  Staff Password
	 * @param  string $value
	 */
	public function setStaffPassword($value) {
		$this->staffPassword = $value;
	}
	/**
	 * Return Staff Password
	 * @return string
	 */
	public function getStaffPassword() {
		return $this->staffPassword;
	}
	/**
	 * Set  Staff Name
	 * @param  string $value
	 */
	public function setStaffName($value) {
		$this->staffName = $value;
	}
	/**
	 * Return Staff Name
	 * @return string
	 */
	public function getStaffName() {
		return $this->staffName;
	}
	/**
	 * Set  Staff No
	 * @param  string $value
	 */
	public function setStaffNo($value) {
		$this->staffNo = $value;
	}
	/**
	 * Return Staff No
	 * @return string
	 */
	public function getStaffNo() {
		return $this->staffNo;
	}
	/**
	 * Set  Staff Identification
	 * @param  string $value
	 */
	public function setStaffIc($value) {
		$this->staffIc = $value;
	}
	/**
	 * Return Staff Identification
	 * @return string $value
	 */
	public function getStaffIc() {
		return $this->staffIc;
	}
}
?>