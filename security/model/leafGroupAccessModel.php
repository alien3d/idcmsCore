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
class LeafGroupAccessModel extends ValidationClass
{
	/**
	 * Leaf Access  Identification
	 * @var int
	 */
	private $leafGroupAccessId;
	/**
	 * Leaf Access  Identification
	 * @var int
	 */
	private $teamId;
	/**
	 * Module   Identification (** For Filtering  Only)
	 * @var bool
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
	private $leafTempId;
	/**
	 * Staff Identification
	 * @var int
	 */
	private $staffId;
	/**
	 * Leaf Create Access Value
	 * @var bool
	 */
	private $leafGroupAccessCreateValue;
	/**
	 * Leaf Read Access Value
	 * @var bool
	 */
	private $leafGroupAccessReadValue;
	/**
	 * Leaf Update Access Value
	 * @var bool
	 */
	private $leafGroupAccessUpdateValue;
	/**
	 * Leaf Delete Access Value
	 * @var bool
	 */
	private $leafGroupAccessDeleteValue;
	/**
	 * Leaf Print Access Value
	 * @var bool
	 */
	private $leafGroupAccessPrintValue;
	/**
	 * Leaf Posting Access Value
	 * @var bool
	 */
	private $leafGroupAccessPostValue;
	/**
	 * Class Loader to load outside variable and test it suppose variable type
	 */
	function execute ()
	{
		/**
		 * Basic Information Table
		 */
		$this->setTableName('leafGroupAccess');
		$this->setPrimaryKeyName('leafGroupAccessId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_GET['leafGroupAccessId'])) {
			$this->setTotal(count($_GET['leafGroupAccessId']));
		}
		if (isset($_POST['groupId'])) {
			$this->setGroupId($this->strict($_POST['groupId'], 'numeric'));
		}
		if (isset($_POST['moduleId'])) {
			$this->setModuleId($this->strict($_POST['moduleId'], 'numeric'));
		}
		if (isset($_POST['folderId'])) {
			$this->setFolderId($this->strict($_POST['folderId'], 'numeric'));
		}
		if (isset($_POST['staffId'])) {
			$this->setStaffId($this->strict($_POST['staffId'], 'numeric'));
		}
		if (isset($_SESSION['staffId'])) {
			$this->setExecuteBy($_SESSION['staffId']);
		}
		if ($this->getVendor() == self::MYSQL) {
			$this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
		} else
		if ($this->getVendor() == self::MSSQL) {
			$this->setExecuteTime("'" . date("Y-m-d H:i:s") . "'");
		} else
		if ($this->getVendor() == self::ORACLE) {
			$this->setExecuteTime(
                    "to_date('" . date("Y-m-d H:i:s") .
                     "','YYYY-MM-DD HH24:MI:SS')");
		}
		for ($i = 0; $i < $this->getTotal(); $i ++) {
			$this->setLeafGroupAccessId(
			$this->strict($_GET['leafGroupAccessId'][$i], 'numeric'), $i);
			if ($_GET['leafGroupAccessCreateValue'][$i] == 'true') {
				$this->setLeafGroupAccessCreateValue($i, 1);
			} else {
				$this->setLeafGroupAccessCreateValue($i, 0);
			}
			if ($_GET['leafGroupAccessReadValue'][$i] == 'true') {
				$this->setLeafGroupAccessReadValue($i, 1);
			} else {
				$this->setLeafGroupAccessReadValue($i, 0);
			}
			if ($_GET['leafGroupAccessUpdateValue'][$i] == 'true') {
				$this->setLeafGroupAccessUpdateValue($i, 1);
			} else {
				$this->setLeafGroupAccessUpdateValue($i, 0);
			}
			if ($_GET['leafGroupAccessDeleteValue'][$i] == 'true') {
				$this->setLeafGroupAccessDeleteValue($i, 1);
			} else {
				$this->setLeafGroupAccessDeleteValue($i, 1);
			}
			if ($_GET['leafGroupAccessPrintValue'][$i] == 'true') {
				$this->setLeafGroupAccessPrintValue($i, 1);
			} else {
				$this->setLeafGroupAccessPrintValue($i, 0);
			}
			if ($_GET['leafGroupAccessPostValue'][$i] == 'true') {
				$this->setLeafGroupAccessPostValue($i, 1);
			} else {
				$this->setLeafGroupAccessPostValue($i, 0);
			}
			if ($_GET['leafGroupAccessDraftValue'][$i] == 'true') {
				$this->leafGroupAccessDraftValue[$i] = 1;
				$this->setLeafAccessDraftValue($i, 1);
			} else {
				$this->leafGroupAccessDraftValue[$i] = 0;
				$this->setLeafGroupAccessDraftValue($i, 0);
			}
			$primaryKeyAll .= $this->getLeafGroupAccessId($i, 'array') . ",";
		}
		$this->setPrimaryKeyAll((substr($primaryKeyAll, 0, - 1)));
	}
	/* (non-PHPdoc)
	 * @see ValidationClass::create()
	 */
	function create ()
	{}
	/* (non-PHPdoc)
	 * @see ValidationClass::update()
	 */
	function update ()
	{}
	/* (non-PHPdoc)
	 * @see ValidationClass::delete()
	 */
	function delete ()
	{}
	/* (non-PHPdoc)
	 * @see ValidationClass::draft()
	 */
	public function draft ()
	{
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
	public function approved ()
	{
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
	public function review ()
	{
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
	public function post ()
	{
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
	public function setLeafGroupAccessId ($value, $key, $type)
	{
		if ($type == 'single') {
			$this->leafGroupAccessId = $value;
		} else
		if ($type == 'array') {
			$this->leafGroupAccessId[$key] = $value;
		} else {
			echo json_encode(
			array("success" => false,
                "message" => "Cannot Identifiy Type String Or Array:setLeafGroupAccessId ?"));
			exit();
		}
	}
	/**
	 * Return Leaf Group Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getLeafGroupAccessId ($key, $type)
	{
		if ($type == 'single') {
			return $this->leafGroupAccessId;
		} else
		if ($type == 'array') {
			return $this->leafGroupAccessId[$key];
		} else {
			echo json_encode(
			array("success" => false,
                "message" => "Cannot Identifiy Type String Or Array:getLeaGroupAccessId ?"));
			exit();
		}
	}
	/**
	 * Set Leaf Identification Value
	 * @param  int $value
	 */
	public function setLeafTempId ($value)
	{
		$this->leafTempId = $value;
	}
	/**
	 * Return Leaf Identification Value
	 * @return int
	 */
	public function getLeafTempId ()
	{
		return $this->leafTempId;
	}
	/**
	 * Set Group Identification Value
	 * @param  int $value
	 */
	public function setGroupId ($value)
	{
		$this->groupId = $value;
	}
	/**
	 * Return Group Identification Value
	 * @return int
	 */
	public function getGroupId ()
	{
		return $this->groupId;
	}
	/**
	 * Set Leaf Create Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'e
	 */
	public function setLeafGroupAccessCreateValue ($value, $key, $type)
	{
		$this->leafGroupAccessCreateValue[$key] = $value;
	}
	/**
	 * Return Leaf Create Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafGroupAccessCreateValue ($key, $type)
	{
		return $this->leafGroupAccessCreateValue[$key];
	}
	/**
	 * Set Leaf Read Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafGroupAccessReadValue ($value, $key, $type)
	{
		$this->leafGroupAccessReadValue[$key] = $value;
	}
	/**
	 * Return Leaf Read Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafGroupAccessReadValue ($key, $type)
	{
		return $this->leafGroupAccessReadValue[$key];
	}
	/**
	 * Set Leaf Update Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafGroupAccessUpdateValue ($value, $key, $type)
	{
		$this->leafGroupAccessUpdateValue[$key] = $value;
	}
	/**
	 * Return Leaf Update Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafGroupAccessUpdateValue ($key, $type)
	{
		return $this->leafGroupAccessUpdateValue[$key];
	}
	/**
	 * Set Leaf Update Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafGroupAccessDeleteValue ($value, $key, $type)
	{
		$this->leafGroupAccessUpdateValue[$key] = $value;
	}
	/**
	 * Return Leaf Delete Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafGroupAccessDeleteValue ($key, $type)
	{
		return $this->leafGroupAccessDeleteValue[$key];
	}
	/**
	 * Set Leaf Print Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafGroupAccessPrintValue ($value, $key, $type)
	{
		$this->leafGroupAccessPrintValue[$key] = $value;
	}
	/**
	 * Return Leaf Print Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getleafGroupAccessPrintValue ($key, $type)
	{
		return $this->leafGroupAccessPrintValue[$key];
	}
	/**
	 * Set Leaf Post Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafGroupAccessPostValue ($value, $key, $type)
	{
		$this->leafGroupAccessPostValue[$key] = $value;
	}
	/**
	 * Return Leaf Post  Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafGroupAccessPostValue ($key, $type)
	{
		return $this->leafGroupAccessPostValue[$key];
	}
	/**
	 * Set Leaf Draft Access  Value
	 * @param bool|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafGroupAccessDraftValue ($value, $key, $type)
	{
		$this->leafGroupAccessDraftValue[$key] = $value;
	}
	/**
	 * Return Leaf Draft Access Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getLeafGroupAccessDraftValue ($key, $type)
	{
		return $this->leafGroupAccessDraftValue[$key];
	}
	/**
	 * Set Module Identification Value
	 * @param  int $value
	 */
	public function setModuleId ($value)
	{
		$this->moduleId = $value;
	}
	/**
	 * Return Module Identification Value
	 * @return int
	 */
	public function getModuleId ()
	{
		return $this->moduleId;
	}
	/**
	 * Set Folder Identification Value
	 * @param  int $value
	 */
	public function setFolderId ($value)
	{
		$this->folderId = $value;
	}
	/**
	 * Return Folder Identification Value
	 * @return int
	 */
	public function getFolderId ()
	{
		return $this->folderId;
	}
	/**
	 * Set Staff Identification Value
	 * @param  int $value
	 */
	public function setStaffId ($value)
	{
		$this->staffId = $value;
	}
	/**
	 * Return Staff Identification Value
	 * @return int
	 */
	public function getStaffId ()
	{
		return $this->staffId;
	}
}
?>