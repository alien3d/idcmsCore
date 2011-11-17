<?php

require_once ("../../class/classValidation.php");

/**
 * this is Application Translation model file.This is to ensure strict setting enable for all variable enter to daFolderase
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Translation
 * @subpackage Application Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LeafTranslateModel extends ValidationClass {

	/**
	 * Leaf Identification
	 * @var int
	 */
	private $leafTranslateId;
	/**
	 * Leaf Native Translation
	 * @var string
	 */
	private $LeafNative;
	/**
	 * Leaf  Identification(** For Filtering only)
	 * @var int
	 */
	private $leafIdTemp;
	/**
	 * Leaf Identification
	 * @var int
	 */
	private $leafId;

	/**
	 * Language Identification
	 * @var int
	 */
	private $languageId;

	/**
	 * Class Loader to load outside variable and test it suppose variable type
	 */
	function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('leafTranslate');
		$this->setPrimaryKeyName('leafTranslateId');
		/*
		 *  All the $_POST enviroment.
		 */
		if (isset($_POST ['leafTranslateId'])) {
			$this->setLeafTranslateId($this->strict($_POST ['leafTranslateId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['leafIdTemp'])) {
			$this->setLeafIdTemp($this->strict($_POST ['leafIdTemp'], 'numeric'));
		}
		if (isset($_POST ['leafId'])) {
			$this->setLeafId($this->strict($_POST ['leafId'], 'numeric'));
		}
		if (isset($_POST ['leafSequence'])) {
			$this->setLeafSequence($this->strict($_POST ['leafSequence'], 'memo'));
		}
		if (isset($_POST ['LeafCode'])) {
			$this->setLeafCode($this->strict($_POST ['leafCode'], 'memo'));
		}
		if (isset($_POST ['leafNative'])) {
			$this->setLeafNative($this->strict($_POST ['leafNative'], 'memo'));
		}
		/*
		 *  All the $_GET enviroment.
		 */
		if (isset($_GET ['leafTranslateId'])) {
			$this->setTotal(count($_GET ['leafTranslateId']));
		}

		if (isset($_GET ['leafTranslateId'])) {
			if (is_array($_GET ['leafTranslateId'])) {
				$this->leafTranslateId = array();
			}
		}
		if (isset($_GET ['isDefault'])) {
			if (is_array($_GET ['isDefault']) ) {
				$this->isDefault = array();
			}
		}
		if (isset($_GET ['isNew']) ) {
			if (is_array($_GET ['isNew'])) {
				$this->isNew = array();
			}
		}
		if (isset($_GET ['isDraft']) ) {
			if (is_array($_GET ['isDraft'])) {
				$this->isDraft = array();
			}
		}
		if (isset($_GET ['isUpdate']) ) {
			if (is_array($_GET ['isUpdate'])) {
				$this->isUpdate = array();
			}
		}
		if (isset($_GET ['isDelete']) ) {
			if (is_array($_GET ['isDelete'])) {
				$this->isDelete = array();
			}
		}
		if (isset($_GET ['isActive']) ) {
			if (is_array($_GET ['isActive'])) {
				$this->isActive = array();
			}
		}
		if (isset($_GET ['isApproved']) ) {
			if (is_array($_GET ['isApproved'])) {
				$this->isApproved = array();
			}
		}
		if (isset($_GET ['isReview']) ) {
			if (is_array($_GET ['isReview'])) {
				$this->isReview = array();
			}
		}
		if (isset($_GET ['isPost']) ) {
			if (is_array($_GET ['isPost'])) {
				$this->isPost = array();
			}
		}
		$primaryKeyAll = '';
		for ($i = 0; $i < $this->getTotal(); $i++) {
			if (isset($_GET ['leafTranslateId'])) {
				$this->setLeafTranslateId($this->strict($_GET ['leafTranslateId'] [$i], 'numeric'), $i, 'array');
			}
			if (isset($_GET ['isDefault'])) {
				if ($_GET ['isDefault'] [$i] == 'true' ) {
					$this->setIsDefault(1, $i, 'array');
				} else if ($_GET ['isDefault'] [$i] == 'false') {
					$this->setIsDefault(0, $i, 'array');
				}
			}
			if (isset($_GET ['isNew'])) {
				if ($_GET ['isNew'] [$i] == 'true' ) {
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
				if ($_GET ['isUpdate'] [$i] == 'true' ) {
					$this->setIsUpdate(1, $i, 'array');
				} if ($_GET ['isUpdate'] [$i] == 'false') {
					$this->setIsUpdate(0, $i, 'array');
				}
			}
			if (isset($_GET ['isDelete'])) {
				if ($_GET ['isDelete'] [$i] == 'true') {
					$this->setIsDelete(1, $i, 'array');
				} else if ($_GET ['isDelete'] [$i] == 'false' ) {
					$this->setIsDelete(0, $i, 'array');
				}
			}
			if (isset($_GET ['isActive'])) {
				if ($_GET ['isActive'] [$i] == 'true' ) {
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
			if (isset($_GET ['isPost']) || isset($_GET ['isPostDetail']) ) {
				if ($_GET ['isPost'] [$i] == 'true') {
					$this->setIsPost(1, $i, 'array');
				} else if ($_GET ['isPost'] [$i] == 'false') {
					$this->setIsPost(0, $i, 'array');
				}
			}
			$primaryKeyAll .= $this->getLeafTranslateId($i, 'array') . ",";
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

	public function create() {
		$this->setIsDefault(0, 0, 'single');
		$this->setIsNew(1, 0, 'single');
		$this->setIsDraft(0, 0, 'single');
		$this->setIsUpdate(0, 0, 'single');
		$this->setIsActive(1, 0, 'single');
		$this->setIsDelete(0, 0, 'single');
		$this->setIsApproved(0, 0, 'single');
		$this->setIsReview(0, 0, 'single');
		$this->setIsPost(0, 0, 'single');
	}

	/* (non-PHPdoc)
	 * @see ValidationClass::update()
	 */

	public function update() {
		$this->setIsDefault(0, 0, 'single');
		$this->setIsNew(0, 0, 'single');
		$this->setIsDraft(0, 0, 'single');
		$this->setIsUpdate(1, 0, 'single');
		$this->setIsActive(1, 0, 'single');
		$this->setIsDelete(0, 0, 'single');
		$this->setIsApproved(0, 0, 'single');
		$this->setIsReview(0, 0, 'single');
		$this->setIsPost(0, 0, 'single');
	}

	/* (non-PHPdoc)
	 * @see ValidationClass::delete()
	 */

	public function delete() {
		$this->setIsDefault(0, 0, 'single');
		$this->setIsNew(0, 0, 'single');
		$this->setIsDraft(0, 0, 'single');
		$this->setIsUpdate(0, 0, 'single');
		$this->setIsActive(0, 0, 'single');
		$this->setIsDelete(1, 0, 'single');
		$this->setIsApproved(0, 0, 'single');
		$this->setIsReview(0, 0, 'single');
		$this->setIsPost(0, 0, 'single');
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
		$this->setIsApproved(0, 0, 'single');
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
	 * Set Leaf Translation   Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setLeafTranslateId($value, $key, $type) {
		if ($type == 'single') {
			$this->leafTranslateId = $value;
		} else if ($type == 'array') {
			$this->leafTranslateId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type Single Or Array:setLeafTranslateId ?"));
			exit();
		}
	}

	/**
	 * Return Leaf Translation Identification
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return int|array
	 */
	public function getLeafTranslateId($key, $type) {
		if ($type == 'single') {
			return $this->leafTranslateId;
		} else if ($type == 'array') {
			return $this->leafTranslateId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type Single Or Array:setLeafTranslateId ?"));
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
	 * Set Leaf Identication Value
	 * @param  string $value
	 */
	public function setLeafId($value) {
		$this->leafId = $value;
	}

	/**
	 * Return Leaf Identication Value
	 * @return string
	 */
	public function getLeafId() {
		return $this->leafId;
	}

	/**
	 * Set Leaf Translation Value
	 * @param  string $value
	 */
	public function setLeafNative($value) {
		$this->leafNative = $value;
	}

	/**
	 * Return Leaf Native Translation
	 * @return string
	 */
	public function getLeafNative() {
		return $this->leafNative;
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