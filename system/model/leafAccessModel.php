<?php

require_once ("../../class/classValidation.php");

/**
 * this is leaf Access Security model file.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage Leaf Access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LeafAccessModel extends ValidationClass {

	/**
	 * Leaf Access  Identification
	 * @var int
	 */
	private $leafAccessId;

	/**
	 * Group Identification (** For Filtering Only)
	 * @var int
	 */
	private $teamId;

	/**
	 * Module   Identification (** For Filtering  Only)
	 * @var  int
	 */
	private $moduleId;

	/**
	 * Folder   Identification (** For Filtering Only)
	 * @var int
	 */
	private $folderId;

	/**
	 * Leaf  Identification(** For Filtering only)
	 * @var int
	 */
	private $leafIdTemp;
	/**
	 * Leaf  Identification(** For Filtering only)
	 * @var int
	 */
	private $leafId;

	/**
	 * Staff Identification
	 * @var int
	 */
	private $staffId;
	/**
	 * Leaf Draft Access Value
	 * @var bool
	 */
	private $leafAccessDraftValue;
	/**
	 * Leaf Create Access Value
	 * @var bool
	 */
	private $leafAccessCreateValue;

	/**
	 * Leaf Read Access Value
	 * @var bool
	 */
	private $leafAccessReadValue;

	/**
	 * Leaf Update Access Value
	 * @var bool
	 */
	private $leafAccessUpdateValue;

	/**
	 * Leaf Delete Access Value
	 * @var bool
	 */
	private $leafAccessDeleteValue;

	/**
	 * Leaf Review Access Value
	 * @var bool
	 */
	private $leafAccessReviewValue;
	/**
	 * Leaf Print Access Value
	 * @var bool
	 */
	private $leafAccessApprovedValue;

	/**
	 * Leaf Posting Access Value
	 * @var bool
	 */
	private $leafAccessPostValue;
	/**
	 * Leaf Print Access Value
	 * @var bool
	 */
	private $leafAccessPrintValue;

	/**
	 * Class Loader to load outside variable and test it suppose variable type
	 */
	function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('leafAccess');
		$this->setPrimaryKeyName('leafAccessId');
		/*
		 *  All the $_POST enviroment.
		 */
		$this->leafAccessId = array();
		$this->leafAccessValue = array();

		/*
		 *  All the $_POST enviroment.
		 */
		if (isset($_POST ['teamId'])) {
			$this->setTeamId($this->strict($_POST ['teamId'], 'numeric'));
		}
		if (isset($_POST ['moduleId'])) {
			$this->setModuleId($this->strict($_POST ['moduleId'], 'numeric'));
		}
		if (isset($_POST ['folderId'])) {
			$this->setFolderId($this->strict($_POST ['folderId'], 'numeric'));
		}
		if (isset($_POST ['leafIdTemp'])) {
			$this->setLeafIdTemp($this->strict($_POST ['leafIdTemp'], 'numeric'));
		}
		if (isset($_POST ['leafId'])) {
			$this->setLeafId($this->strict($_POST ['leafId'], 'numeric'));
		}
		if (isset($_POST ['staffId'])) {
			$this->setStaffId($this->strict($_POST ['staffId'], 'numeric'));
		}
		/*
		 *  All the $_GET enviroment.
		 */
		if (isset($_GET ['leafAccessId'])) {
			$this->setTotal(count($_GET ['leafAccessId']));
		}
		if (isset($_GET ['type'])) {
			$this->setType($this->strict($_GET ['type'], 'numeric'));
		}
		if (isset($_GET ['teamId'])) {
			$this->setTeamId($this->strict($_GET ['teamId'], 'numeric'));
		}
		if (isset($_GET ['moduleId'])) {
			$this->setModuleId($this->strict($_GET ['moduleId'], 'numeric'));
		}
		if (isset($_GET ['folderId'])) {
			$this->setFolderId($this->strict($_GET ['folderId'], 'numeric'));
		}
		if (isset($_GET ['leafIdTemp'])) {
			$this->setLeafIdTemp($this->strict($_GET ['leafIdTemp'], 'numeric'));
		}
		if (isset($_GET ['leafId'])) {
			$this->setLeafId($this->strict($_GET ['leafId'], 'numeric'));
		}
		if (isset($_GET ['staffId'])) {
			$this->setStafId($this->strict($_GET ['staffId'], 'numeric'));
		}

		$primaryKeyAll = '';
		for ($i = 0; $i < $this->getTotal(); $i++) {
			if (isset($_GET ['leafAccessId'])) {
				$this->setLeafAccessId($this->strict($_GET ['leafAccessId'] [$i], 'numeric'), $i,'array');
			}
			if (isset($_GET ['leafAccessDraftValue'])) {
				if ($_GET ['leafAccessDraftValue'] [$i] == 'true') {

					$this->setLeafAccessDraftValue(1, $i,'array');
				}else {
					$this->setLeafAccessDraftValue(0, $i,'array');
				}

			}
			if (isset($_GET ['leafAccessCreateValue'])) {
				if ($_GET ['leafAccessCreateValue'] [$i] == 'true') {
					$this->setLeafAccessCreateValue(1, $i,'array');
				}else {
					$this->setLeafAccessCreateValue(0, $i,'array');
				}
			}
			if (isset($_GET ['leafAccessReadValue'])) {
				if ($_GET ['leafAccessReadValue'] [$i] == 'true') {
					$this->setLeafAccessReadValue(1, $i,'array');
				}else {
					$this->setLeafAccessReadValue(0, $i,'array');
				}
			}
			if (isset($_GET ['leafAccessUpdateValue'])) {

				if ($_GET ['leafAccessUpdateValue'] [$i] == 'true') {
					$this->setLeafAccessUpdateValue(1, $i,'array');
				}else {
					$this->setLeafAccessUpdateValue(0, $i,'array');
				}
			}
			if (isset($_GET ['leafAccessDeleteValue'])) {

				if ($_GET ['leafAccessDeleteValue'] [$i] == 'true') {
					$this->setLeafAccessDeleteValue(1, $i,'array');
				}else {
					$this->setLeafAccessDeleteValue(0, $i,'array');
				}
			}
			if (isset($_GET ['leafAccessReviewValue'])) {
				if ($_GET ['leafAccessReviewValue'] [$i] == 'true') {
					$this->setLeafAccessReviewValue(1, $i,'array');
				}else {
					$this->setLeafAccessReviewValue(0, $i,'array');
				}
			}
			if (isset($_GET ['leafAccessApprovedValue'])) {
				if ($_GET ['leafAccessApprovedValue'] [$i] == 'true') {
					$this->setLeafAccessApprovedValue(1, $i,'array');
				}else {
					$this->setLeafAccessApprovedValue(0, $i,'array');
				}
			}
			if (isset($_GET ['leafAccessPostValue'])) {
				if ($_GET ['leafAccessPostValue'] [$i] == 'true') {
					$this->setLeafAccessPostValue(1, $i,'array');
				} else {
					$this->setLeafAccessPostValue(0, $i,'array');
				}
			}
			if (isset($_GET ['leafAccessPrintValue'])) {
				if ($_GET ['leafAccessPrintValue'] [$i] == 'true') {
					$this->setLeafAccessPrintValue(1, $i,'array');
				} else {
					$this->setLeafAccessPrintValue(0, $i,'array');
				}
			}
			$primaryKeyAll .= $this->getLeafAccessId($i, 'array') . ",";
		}
		$this->setPrimaryKeyAll((substr($primaryKeyAll, 0, - 1)));

		/**
		 * All the $_SESSION enviroment.
		 */
		if (isset($_SESSION ['staffId'])) {
			$this->setExecuteBy($_SESSION ['staffId']);
		}
		/**
		 * TimeStamp Value.
		 */
		if ($this->getVendor() == self::MYSQL) {
			$this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
		} else if ($this->getVendor() == self::MSSQL) {
			$this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
		} else if ($this->getVendor() == self::ORACLE) {
			$this->setExecuteTime("to_date('" . date("Y-m-d H:i:s") . "','YYYY-MM-DD HH24:MI:SS')");
		}
	}

	/* (non-PHPdoc)
	 * @see ValidationClass::create()
	 */

	function create() {

	}

	/* (non-PHPdoc)
	 * @see ValidationClass::update()
	 */

	function update() {

	}

	/* (non-PHPdoc)
	 * @see ValidationClass::delete()
	 */

	function delete() {

	}

	/* (non-PHPdoc)
	 * @see ValidationClass::draft()
	 */

	public function draft() {
		$this->setIsDefault(0, 0, 'single');
		$this->setIsNew(1, 0, 'single');
		$this->setIsDraft(1, 0, 'single');
		$this->setIsUpdate(0, 0, 'single');
		$this->setIsActive(0, 0, 'single');
		$this->setIsDelete(0, 0, 'single');
		$this->setIsApproved(0, 0, 'single');
		$this->setIsReview(0, 0, 'single');
		$this->setIsPost(0, 0, 'single');
	}

	/* (non-PHPdoc)
	 * @see ValidationClass::draft()
	 */

	public function approved() {
		$this->setIsDefault(0, 0, 'single');
		$this->setIsNew(1, 0, 'single');
		$this->setIsDraft(0, 0, 'single');
		$this->setIsUpdate(0, 0, 'single');
		$this->setIsActive(0, 0, 'single');
		$this->setIsDelete(0, 0, 'single');
		$this->setIsApproved(1, 0, 'single');
		$this->setIsReview(0, 0, 'single');
		$this->setIsPost(0, 0, 'single');
	}

	/* (non-PHPdoc)
	 * @see ValidationClass::review()
	 */

	public function review() {
		$this->setIsDefault(0, 0, 'single');
		$this->setIsNew(1, 0, 'single');
		$this->setIsDraft(0, 0, 'single');
		$this->setIsUpdate(0, 0, 'single');
		$this->setIsActive(0, 0, 'single');
		$this->setIsDelete(0, 0, 'single');
		$this->setIsApproved(0, 0, 'single');
		$this->setIsReview(1, 0, 'single');
		$this->setIsPost(0, 0, 'single');
	}

	/* (non-PHPdoc)
	 * @see ValidationClass::post()
	 */

	public function post() {
		$this->setIsDefault(0, 0, 'single');
		$this->setIsNew(1, 0, 'single');
		$this->setIsDraft(0, 0, 'single');
		$this->setIsUpdate(0, 0, 'single');
		$this->setIsActive(0, 0, 'single');
		$this->setIsDelete(0, 0, 'single');
		$this->setIsApproved(1, 0, 'single');
		$this->setIsReview(0, 0, 'single');
		$this->setIsPost(1, 0, 'single');
	}

	/**
	 * Set Leaf Access Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafAccessId($value, $key, $type) {
		if ($type == 'single') {
			$this->leafAccessId = $value;
		} else if ($type == 'array') {
			$this->leafAccessId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setLeafAccessId ?"));
			exit();
		}
	}

	/**
	 * Return Leaf Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getLeafAccessId($key, $type) {
		if ($type == 'single') {
			return $this->leafAccessId;
		} else if ($type == 'array') {
			return $this->leafAccessId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getLeafAccessId ?"));
			exit();
		}
	}

	/**
	 * Set Leaf Identification Value
	 * @param  int $value
	 */
	public function setLeafIdTemp($value) {
		$this->leafIdTemp = $value;
	}

	/**
	 * Return Leaf Identification Value
	 * @return int
	 */
	public function getLeafIdTemp() {
		return $this->leafIdTemp;
	}
	/**
	 * Set Leaf Identification Value
	 * @param  int $value
	 */
	public function setLeafId($value) {
		$this->leafId = $value;
	}

	/**
	 * Return Leaf Identification Value
	 * @return int
	 */
	public function getLeafId() {
		return $this->leafId;
	}

	/**
	 * Set Team Identification Value
	 * @param  int $value
	 */
	public function setTeamId($value) {
		$this->teamId = $value;
	}

	/**
	 * Return Team Identiification Value
	 * @return int
	 */
	public function getTeamId() {
		return $this->teamId;
	}

	/**
	 * Set Module Identification Value
	 * @param  int $value
	 */
	public function setModuleId($value) {
		$this->moduleId = $value;
	}

	/**
	 * Return Module Identification Value
	 * @return int
	 */
	public function getModuleId() {
		return $this->moduleId;
	}

	/**
	 * Set Folder Identification Value
	 * @param  int $value
	 */
	public function setFolderId($value) {
		$this->folderId = $value;
	}

	/**
	 * Return Folder Identiification Value
	 * @return int
	 */
	public function getFolderId() {
		return $this->folderId;
	}

	/**
	 * Set Staff Identification Value
	 * @param  int $value
	 */
	public function setStaffId($value) {
		$this->staffId = $value;
	}

	/**
	 * Return Staff Identification Value
	 * @return int
	 */
	public function getStaffId() {
		return $this->staffId;
	}

	/**
	 * Set  Type Filtering
	 * @param  int $value
	 */
	public function setType($value) {
		$this->type = $value;
	}

	/**
	 * Return Type Filtering
	 * @return int
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Set Leaf Draft Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafAccessDraftValue($value, $key, $type) {
		$this->leafAccessDraftValue [$key] = $value;
	}

	/**
	 * Return Leaf Draft Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafAccessDraftValue($key, $type) {
		return $this->leafAccessDraftValue [$key];
	}
	/**
	 * Set Leaf Create Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'e
	 */
	public function setLeafAccessCreateValue($value, $key, $type) {
		$this->leafAccessCreateValue [$key] = $value;
	}

	/**
	 * Return Leaf Create Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafAccessCreateValue($key, $type) {
		return $this->leafAccessCreateValue [$key];
	}

	/**
	 * Set Leaf Read Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafAccessReadValue($value, $key, $type) {
		$this->leafAccessReadValue [$key] = $value;
	}

	/**
	 * Return Leaf Read Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafAccessReadValue($key, $type) {
		return $this->leafAccessReadValue [$key];
	}

	/**
	 * Set Leaf Update Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafAccessUpdateValue($value, $key, $type) {
		$this->leafAccessUpdateValue [$key] = $value;
	}

	/**
	 * Return Leaf Update Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafAccessUpdateValue($key, $type) {
		return $this->leafAccessUpdateValue [$key];
	}

	/**
	 * Set Leaf Update Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafAccessDeleteValue($value, $key, $type) {
		$this->leafAccessDeleteValue [$key] = $value;
	}

	/**
	 * Return Leaf Delete Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafAccessDeleteValue($key, $type) {
		return $this->leafAccessDeleteValue [$key];
	}

	/**
	 * Set Leaf Approved Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafAccessApprovedValue($value, $key, $type) {
		$this->leafAccessApprovedValue [$key] = $value;
	}

	/**
	 * Return Leaf Approved Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafAccessApprovedValue($key, $type) {
		return $this->leafAccessApprovedValue [$key];
	}
	/**
	 * Set Leaf Review Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafAccessReviewValue($value, $key, $type) {
		$this->leafAccessReviewValue [$key] = $value;
	}

	/**
	 * Return Leaf Review Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafAccessReviewValue($key, $type) {
		return $this->leafAccessReviewValue [$key];
	}
	/**
	 * Set Leaf Print Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafAccessPrintValue($value, $key, $type) {
		$this->leafAccessPrintValue [$key] = $value;
	}

	/**
	 * Return Leaf Print Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafAccessPrintValue($key, $type) {
		return $this->leafAccessPrintValue [$key];
	}

	/**
	 * Set Leaf Post Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafAccessPostValue($value, $key, $type) {
		$this->leafAccessPostValue [$key] = $value;
	}

	/**
	 * Return Leaf Post  Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafAccessPostValue($key, $type) {
		return $this->leafAccessPostValue [$key];
	}
}

?>