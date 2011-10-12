<?php
require_once ("../../class/classValidation.php");
/**
 * this is team model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package management
 * @subpackage team
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class TeamModel extends ValidationClass {
	/**
	 * team Identification
	 * @var int
	 */
	private $teamId;
	/**
	 * team Sequence
	 * @var int
	 */
	private $teamSequence;
	/**
	 * team Code
	 * @var string
	 */
	private $teamCode;
	/**
	 * team Note
	 * @var string
	 */
	private $teamNote;
	function execute() {
		/**
		 * Basic Information Table
		 */
		$this->setTableName ( 'team' );
		$this->setPrimaryKeyName ( 'teamId' );
		/**
		 * All the $_POST enviroment.
		 */
		if (isset ( $_POST ['Id'] )) {
			$this->setTeamId ( $this->strict ( $_POST ['teamId'], 'numeric' ), 0, 'single' );
		}
		if (isset ( $_POST ['teamSequence'] )) {
			$this->setTeamSequence ( $this->strict ( $_POST ['teamSequence'], 'memo' ) );
		}
		if (isset ( $_POST ['teamCode'] )) {
			$this->setTeamCode ( $this->strict ( $_POST ['teamCode'], 'memo' ) );
		}
		if (isset ( $_POST ['teamNote'] )) {
			$this->setTeamNote ( $this->strict ( $_POST ['teamNote'], 'memo' ) );
		}
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
		if (isset ( $_GET ['teamId'] )) {
			$this->setTotal ( count ( $_GET ['teamId'] ) );
		}
		$accessArray = array ("isDefault", "isNew", "isDraft", "isUpdate", "isDelete", "isActive", "isApproved", "isReview", "isPost" );
		// auto assign as array if TRUE
		if (isset ( $_GET ['teamId'] )) {
			
			if (is_array ( $_GET ['teamId'] )) {
				$this->teamId = array ();
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
			
			if (isset ( $_GET ['teamId'] )) {
				$this->setTeamId ( $this->strict ( $_GET ['teamId'] [$i], 'numeric' ), $i, 'array' );
			}
			if (isset ( $_GET ['isDefault'] )) {
				if ($_GET ['isDefault'] [$i] == 'TRUE') {
					$this->setIsDefault ( 1, $i, 'array' );
				} else if ($_GET ['default'] == 'FALSE') {
					$this->setIsDefault ( 0, $i, 'array' );
				}
			}
			if (isset ( $_GET ['isNew'] )) {
				if ($_GET ['isNew'] [$i] == 'TRUE') {
					$this->setIsNew ( 1, $i, 'array' );
				} else {
					$this->setIsNew ( 0, $i, 'array' );
				}
			}
			if (isset ( $_GET ['isDraft'] )) {
				if ($_GET ['isDraft'] [$i] == 'TRUE') {
					$this->setIsDraft ( 1, $i, 'array' );
				} else {
					$this->setIsDraft ( 0, $i, 'array' );
				}
			}
			if (isset ( $_GET ['isUpdate'] )) {
				if ($_GET ['isUpdate'] [$i] == 'TRUE') {
					$this->setIsUpdate ( 1, $i, 'array' );
				} else {
					$this->setIsUpdate ( 0, $i, 'array' );
				}
			}
			if (isset ( $_GET ['isDelete'] )) {
				if ($_GET ['isDelete'] [$i] == 'TRUE') {
					$this->setIsDelete ( 1, $i, 'array' );
				} else if ($_GET ['isDelete'] [$i] == 'FALSE') {
					$this->setIsDelete ( 0, $i, 'array' );
				}
			}
			if (isset ( $_GET ['isActive'] )) {
				if ($_GET ['isActive'] [$i] == 'TRUE') {
					$this->setIsActive ( 1, $i, 'array' );
				} else {
					$this->setIsActive ( 0, $i, 'array' );
				}
			}
			if (isset ( $_GET ['isApproved'] )) {
				if ($_GET ['isApproved'] [$i] == 'TRUE') {
					$this->setIsApproved ( 1, $i, 'array' );
				} else if ($_GET ['isApproved'] [$i] == 'FALSE') {
					$this->setIsApproved ( 0, $i, 'array' );
				}
			}
			if (isset ( $_GET ['isReview'] )) {
				if ($_GET ['isReview'] [$i] == 'TRUE') {
					$this->setIsReview ( 1, $i, 'array' );
				} else if ($_GET ['isReview'] [$i] == 'FALSE') {
					$this->setIsReview ( 0, $i, 'array' );
				}
			}
			if (isset ( $_GET ['isPost'] )) {
				if ($_GET ['isPost'] [$i] == 'TRUE') {
					$this->setIsPost ( 1, $i, 'array' );
				} else if ($_GET ['isPost'] [$i] == 'FALSE') {
					$this->setIsPost ( 0, $i, 'array' );
				}
			}
			$primaryKeyAll .= $this->getTeamId ( $i, 'array' ) . ",";
		}
		$this->setPrimaryKeyAll ( (substr ( $primaryKeyAll, 0, - 1 )) );
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
	/* (non-PHPdoc)
	 * @see ConfigClass::excel()
	 */
	function excel() {
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
	 * Set team Identification  Value
	 * @param array[int] $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setTeamId($value, $key, $type) {
		if ($type == 'single') {
			$this->teamId = $value;
		} else if ($type == 'array') {
			$this->teamId [$key] = $value;
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type String Or Array:setTeamId ?" ) );
			exit ();
		}
	}
	/**
	 * Return team Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getTeamId($key, $type) {
		if ($type == 'single') {
			return $this->teamId;
		} else if ($type == 'array') {
			return $this->teamId [$key];
		} else {
			echo json_encode ( array ("success" => false, "message" => "Cannot Identifiy Type String Or Array:getTeamId ?" ) );
			exit ();
		}
	}
	/**
	 * Set  team Sequence (english)
	 * @param int $value
	 */
	public function setTeamSequence($value) {
		$this->teamSequence = $value;
	}
	/**
	 * Return team  Sequence
	 * @return  int
	 */
	public function getTeamSequence() {
		return $this->teamSequence;
	}
	/**
	 * Set  team  Code (english)
	 * @param string $value
	 */
	public function setTeamCode($value) {
		$this->teamCode = $value;
	}
	/**
	 * Return team  Code
	 * @return  string
	 */
	public function getTeamCode() {
		return $this->teamCode;
	}
	/**
	 * Set  team Translation (english)
	 * @param string $value
	 */
	public function setTeamNote($value) {
		$this->teamNote = $value;
	}
	/**
	 * Return team  Description (english)
	 * @return  string
	 */
	public function getTeamNote() {
		return $this->teamNote;
	}
}
?>