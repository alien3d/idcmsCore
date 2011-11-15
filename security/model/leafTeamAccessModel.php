<?php

require_once ("../../class/classValidation.php");

/**
 * this is leaf security model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package security
 * @subpackage leaf
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafTeamAccessModel extends ValidationClass {

	/**
	 * Leaf Access  Identification
	 * @var int
	 */
	private $leafTeamAccessId;

	/**
	 * Team  Identification ( ** For Filtering Only(
	 * @var int
	 */
	private $teamId;

	/**
	 * Module   Identification (** For Filtering  Only)
	 * @var int
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
	 * Leaf  Identification
	 * @var int
	 */
	private $leafId;

	/**
	 * Staff Identification
	 * @var int
	 */
	private $staffId;

	/**
	 * Type 1 filter  table only Type 2  Filter with access table
	 * @var int
	 */
	private $type;

	/**
	 * Leaf Create Access Value
	 * @var bool
	 */
	private $leafTeamAccessCreateValue;

	/**
	 * Leaf Read Access Value
	 * @var bool
	 */
	private $leafTeamAccessReadValue;

	/**
	 * Leaf Update Access Value
	 * @var bool
	 */
	private $leafTeamAccessUpdateValue;

	/**
	 * Leaf Delete Access Value
	 * @var bool
	 */
	private $leafTeamAccessDeleteValue;

	/**
	 * Leaf Print Access Value
	 * @var bool
	 */
	private $leafTeamAccessPrintValue;

	/**
	 * Leaf Posting Access Value
	 * @var bool
	 */
	private $leafTeamAccessPostValue;

	/**
	 * Class Loader to load outside variable and test it suppose variable type
	 */
	function execute() {
		/*
		 * Basic Information Table
		 */
		$this->setTableName('leafTeamAccess');
		$this->setPrimaryKeyName('leafTeamAccessId');
		/*
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['type'])) {
			$this->setType($this->strict($_POST ['type'], 'numeric'));
		}
		if (isset($_POST ['teamId'])) {
			$this->setTeamId($this->strict($_POST ['teamId'], 'numeric'));
		}
		if (isset($_POST ['moduleId'])) {
			$this->setModuleId($this->strict($_POST ['moduleId'], 'numeric'));
		}
		if (isset($_POST ['folderId'])) {
			$this->setFolderId($this->strict($_POST ['folderId'], 'numeric'));
		}
		if (isset($_POST ['staffId'])) {
			$this->setStaffId($this->strict($_POST ['staffId'], 'numeric'));
		}
		if (isset($_POST ['leafIdTemp'])) {
			$this->setLeafIdTemp($this->strict($_POST ['leafIdTemp'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['leafId'])) {
			$this->setLeafId($this->strict($_POST ['leafId'], 'numeric'), 0, 'single');
		}
		/*
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['leafTeamAccessId'])) {
			$this->setTotal(count($_GET ['leafTeamAccessId']));
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

		$primaryKeyAll = '';
		for ($i = 0; $i < $this->getTotal(); $i++) {
			if (isset($_GET ['leafTeamAccessId'])) {
				$this->setLeafTeamAccessId($this->strict($_GET ['leafTeamAccessId'] [$i], 'numeric'), $i);
			}
			if (isset($_GET ['leafTeamAccessCreateValue'])) {
				if ($_GET ['leafTeamAccessCreateValue'] [$i] == 'true') {
					$this->setLeafTeamAccessCreateValue($i, 1);
				}else {
					$this->setLeafTeamAccessCreateValue($i, 0);
				}
			}
			if (isset($_GET ['leafTeamAccessCreateValue'])) {
				if ($_GET ['leafTeamAccessReadValue'] [$i] == 'true') {
					$this->setLeafTeamAccessReadValue($i, 1);
				}else {
					$this->setLeafTeamAccessReadValue($i, 0);
				}
			}
			if (isset($_GET ['leafTeamAccessCreateValue'])) {
				if ($_GET ['leafTeamAccessUpdateValue'] [$i] == 'true') {
					$this->setLeafTeamAccessUpdateValue($i, 1);
				} else {
					$this->setLeafTeamAccessUpdateValue($i, 0);
				}
			}
			if (isset($_GET ['leafTeamAccessCreateValue'])) {
				if ($_GET ['leafTeamAccessDeleteValue'] [$i] == 'true') {
					$this->setLeafTeamAccessDeleteValue($i, 1);
				} else {
					$this->setLeafTeamAccessDeleteValue($i, 1);
				}
			}
			if (isset($_GET ['leafTeamAccessCreateValue'])) {
				if ($_GET ['leafTeamAccessPrintValue'] [$i] == 'true') {
					$this->setLeafTeamAccessPrintValue($i, 1);
				}else {
					$this->setLeafTeamAccessPrintValue($i, 0);
				}
			}
			if (isset($_GET ['leafTeamAccessCreateValue'])) {
				if ($_GET ['leafTeamAccessPostValue'] [$i] == 'true') {
					$this->setLeafTeamAccessPostValue($i, 1);
				} else {
					$this->setLeafTeamAccessPostValue($i, 0);
				}
			}
			if (isset($_GET ['leafTeamAccessCreateValue'])) {
				if ($_GET ['leafTeamAccessDraftValue'] [$i] == 'true') {
					$this->leafTeamAccessDraftValue [$i] = 1;
					$this->setLeafAccessDraftValue($i, 1);
				}else {
					$this->leafTeamAccessDraftValue [$i] = 0;
					$this->setLeafTeamAccessDraftValue($i, 0);
				}
			}
			$primaryKeyAll .= $this->getLeafTeamAccessId($i, 'array') . ",";
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
	 * Set Leaf Group Access Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafTeamAccessId($value, $key, $type) {
		if ($type == 'single') {
			$this->leafTeamAccessId = $value;
		} else if ($type == 'array') {
			$this->leafTeamAccessId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setLeafTeamAccessId ?"));
			exit();
		}
	}

	/**
	 * Return Leaf Group Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getLeafTeamAccessId($key, $type) {
		if ($type == 'single') {
			return $this->leafTeamAccessId;
		} else if ($type == 'array') {
			return $this->leafTeamAccessId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getLeaGroupAccessId ?"));
			exit();
		}

	}

	/**
	 * Set Group Identification Value
	 * @param  int $value
	 */
	public function setTeamId($value) {
		$this->teamId = $value;
	}

	/**
	 * Return Group Identification Value
	 * @return int
	 */
	public function getTeamId() {
		return $this->teamId;
	}

	/**
	 * Set Leaf Create Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'e
	 */
	public function setLeafTeamAccessCreateValue($value, $key, $type) {
		$this->leafTeamAccessCreateValue [$key] = $value;
	}

	/**
	 * Return Leaf Create Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafTeamAccessCreateValue($key, $type) {
		return $this->leafTeamAccessCreateValue [$key];
	}

	/**
	 * Set Leaf Read Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafTeamAccessReadValue($value, $key, $type) {
		$this->leafTeamAccessReadValue [$key] = $value;
	}

	/**
	 * Return Leaf Read Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafTeamAccessReadValue($key, $type) {
		return $this->leafTeamAccessReadValue [$key];
	}

	/**
	 * Set Leaf Update Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafTeamAccessUpdateValue($value, $key, $type) {
		$this->leafTeamAccessUpdateValue [$key] = $value;
	}

	/**
	 * Return Leaf Update Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafTeamAccessUpdateValue($key, $type) {
		return $this->leafTeamAccessUpdateValue [$key];
	}

	/**
	 * Set Leaf Update Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafTeamAccessDeleteValue($value, $key, $type) {
		$this->leafTeamAccessUpdateValue [$key] = $value;
	}

	/**
	 * Return Leaf Delete Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafTeamAccessDeleteValue($key, $type) {
		return $this->leafTeamAccessDeleteValue [$key];
	}

	/**
	 * Set Leaf Print Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafTeamAccessPrintValue($value, $key, $type) {
		$this->leafTeamAccessPrintValue [$key] = $value;
	}

	/**
	 * Return Leaf Print Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafTeamAccessPrintValue($key, $type) {
		return $this->leafTeamAccessPrintValue [$key];
	}

	/**
	 * Set Leaf Post Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafTeamAccessPostValue($value, $key, $type) {
		$this->leafTeamAccessPostValue [$key] = $value;
	}

	/**
	 * Return Leaf Post  Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafTeamAccessPostValue($key, $type) {
		return $this->leafTeamAccessPostValue [$key];
	}

	/**
	 * Set Leaf Draft Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafTeamAccessDraftValue($value, $key, $type) {
		$this->leafTeamAccessDraftValue [$key] = $value;
	}

	/**
	 * Return Leaf Draft Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafTeamAccessDraftValue($key, $type) {
		return $this->leafTeamAccessDraftValue [$key];
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
	 * Return Folder Identification Value
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
	 * Set Leaf Identication Value
	 * @param  string $value
	 */
	public function setLeafId($value) {
		$this->leafd = $value;
	}

	/**
	 * Return Leaf Identication Value
	 * @return string
	 */
	public function getLeafId() {
		return $this->leafd;
	}

}

?>