<?php

require_once ("../../class/classValidation.php");

/**
 * this is generalLedgerChartOfAccountSegmentType model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package General Ledger
 * @subpackage Chart Of Account Type
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
       
class GeneralLedgerChartOfAccountSegmentTypeModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $generalLedgerChartOfAccountSegmentTypeId;
	/**
	 * @var string
	 */
	private $generalLedgerChartOfAccountSegmentTypeSequence;
	/**
	 * @var int
	 */
	private $generalLedgerChartOfAccountSegmentTypeCode;
	/**
	 * @var string
	 */
	private $generalLedgerChartOfAccountSegmentTypeDesc;


	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('generalLedgerChartOfAccountSegmentType');
		$this->setPrimaryKeyName('generalLedgerChartOfAccountSegmentTypeId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['generalLedgerChartOfAccountSegmentTypeId'])) {
			$this->setGeneralLedgerChartOfAccountSegmentTypeId($this->strict($_POST ['generalLedgerChartOfAccountSegmentTypeId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['generalLedgerChartOfAccountSegmentTypeSequence'])) {
			$this->setGeneralLedgerChartOfAccountSegmentTypeSequence($this->strict($_POST ['generalLedgerChartOfAccountSegmentTypeSequence'], 'string'));
		}
		if (isset($_POST ['generalLedgerChartOfAccountSegmentTypeCode'])) {
			$this->setGeneralLedgerChartOfAccountSegmentTypeCode($this->strict($_POST ['generalLedgerChartOfAccountSegmentTypeCode'], 'numeric'));
		}
		if (isset($_POST ['generalLedgerChartOfAccountSegmentTypeDesc'])) {
			$this->setGeneralLedgerChartOfAccountSegmentTypeDesc($this->strict($_POST ['generalLedgerChartOfAccountSegmentTypeDesc'], 'string'));
		}

		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['generalLedgerChartOfAccountSegmentTypeId'])) {
			$this->setTotal(count($_GET ['generalLedgerChartOfAccountSegmentTypeId']));
		}

		if (isset($_GET ['isDefault'])) {
			if (is_array($_GET ['isDefault'])) {
				$this->isDefault = array();
			}
		}
		if (isset($_GET ['isNew'])) {
			if (is_array($_GET ['isNew'])) {
				$this->isNew = array();
			}
		}
		if (isset($_GET ['isDraft'])) {
			if (is_array($_GET ['isDraft'])) {
				$this->isDraft = array();
			}
		}
		if (isset($_GET ['isUpdate'])) {
			if (is_array($_GET ['isUpdate'])) {
				$this->isUpdate = array();
			}
		}
		if (isset($_GET ['isDelete'])) {
			if (is_array($_GET ['isDelete'])) {
				$this->isDelete = array();
			}
		}
		if (isset($_GET ['isActive'])) {
			if (is_array($_GET ['isActive'])) {
				$this->isActive = array();
			}
		}
		if (isset($_GET ['isApproved'])) {
			if (is_array($_GET ['isApproved'])) {
				$this->isApproved = array();
			}
		}
		if (isset($_GET ['isReview'])) {
			if (is_array($_GET ['isReview'])) {
				$this->isReview = array();
			}
		}
		if (isset($_GET ['isPost'])) {
			if (is_array($_GET ['isPost'])) {
				$this->isPost = array();
			}
		}
		$primaryKeyAll = '';
		for ($i = 0; $i < $this->getTotal(); $i++) {
			if (isset($_GET ['generalLedgerChartOfAccountSegmentTypeId'])) {
				$this->setGeneralLedgerChartOfAccountId($this->strict($_GET ['generalLedgerChartOfAccountSegmentTypeId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getGeneralledgerId($i, 'array') . ",";
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
			$this->setExecuteTime("'" . date("Y-m-d H:i:s.u") . "'");
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
		$this->setIsUpdate(1, '', 'single');
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
		$this->setIsActive(0, '', 'single');
		$this->setIsDelete(1, '', 'single');
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
	 * @see ValidationClass::approved()
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
	 * Set Generalledger Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setGeneralLedgerChartOfAccountSegmentTypeId($value, $key, $type) {
		if ($type == 'single') {
			$this->generalLedgerChartOfAccountSegmentTypeId = $value;
		} else if ($type == 'array') {
			$this->generalLedgerChartOfAccountSegmentTypeId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setGeneralledgerId ?"));
			exit();
		}
	}

	/**
	 * Return Generalledger Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getGeneralLedgerChartOfAccountSegmentTypeId($key, $type) {
		if ($type == 'single') {
			return $this->generalLedgerChartOfAccountSegmentTypeId;
		} else if ($type == 'array') {
			return $this->generalLedgerChartOfAccountSegmentTypeId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getGeneralledgerId ?"));
			exit();
		}
	}



	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerChartOfAccountSegmentTypeSequence()
	{
	    return $this->generalLedgerChartOfAccountSegmentTypeSequence;
	}

	/**
	 * 
	 * @param $generalLedgerChartOfAccountSegmentTypeSequence
	 */
	public function setGeneralLedgerChartOfAccountSegmentTypeSequence($generalLedgerChartOfAccountSegmentTypeSequence)
	{
	    $this->generalLedgerChartOfAccountSegmentTypeSequence = $generalLedgerChartOfAccountSegmentTypeSequence;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerChartOfAccountSegmentTypeCode()
	{
	    return $this->generalLedgerChartOfAccountSegmentTypeCode;
	}

	/**
	 * 
	 * @param $generalLedgerChartOfAccountSegmentTypeCode
	 */
	public function setGeneralLedgerChartOfAccountSegmentTypeCode($generalLedgerChartOfAccountSegmentTypeCode)
	{
	    $this->generalLedgerChartOfAccountSegmentTypeCode = $generalLedgerChartOfAccountSegmentTypeCode;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerChartOfAccountSegmentTypeDesc()
	{
	    return $this->generalLedgerChartOfAccountSegmentTypeDesc;
	}

	/**
	 * 
	 * @param $generalLedgerChartOfAccountSegmentTypeDesc
	 */
	public function setGeneralLedgerChartOfAccountSegmentTypeDesc($generalLedgerChartOfAccountSegmentTypeDesc)
	{
	    $this->generalLedgerChartOfAccountSegmentTypeDesc = $generalLedgerChartOfAccountSegmentTypeDesc;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerChartOfAccountSegmentTypeSequenceDesc()
	{
	    return $this->generalLedgerChartOfAccountSegmentTypeSequenceDesc;
	}

	/**
	 * 
	 * @param $generalLedgerChartOfAccountSegmentTypeSequenceDesc
	 */
	public function setGeneralLedgerChartOfAccountSegmentTypeSequenceDesc($generalLedgerChartOfAccountSegmentTypeSequenceDesc)
	{
	    $this->generalLedgerChartOfAccountSegmentTypeSequenceDesc = $generalLedgerChartOfAccountSegmentTypeSequenceDesc;
	}
}

?>
