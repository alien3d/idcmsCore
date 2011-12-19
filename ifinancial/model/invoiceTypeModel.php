<?php

require_once ("../../class/classValidation.php");

/**
 * this is invoiceType model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package General Ledger
 * @subpackage Chart Of Account Type
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */

class InvoiceTypeModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $invoiceTypeId;
	/**
	 * @var int
	 */
	private $invoiceCategoryId;
	/**
	 * @var int
	 */
	private $lateInterestId;
	/**
	 * @var string
	 */
	private $invoiceTypeSequence;
	/**
	 * @var int
	 */
	private $invoiceTypeCode;
	/**
	 * @var string
	 */
	private $invoiceTypeDesc;
	/**
	 * @var int
	 */
	private $invoiceTypeCreditLimit;
	/**
	 * @var int
	 */
	private $invoiceTypePeriodLimit;
	/**
	 * @var float
	 */
	private $invoiceTypeInterestRate;
	/**
	 * @var float
	 */
	private $invoiceMinimumDeposit;


	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('invoiceType');
		$this->setPrimaryKeyName('invoiceTypeId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['invoiceTypeId'])) {
			$this->setInvoiceTypeId($this->strict($_POST ['invoiceTypeId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['invoiceCategoryId'])) {
			$this->setInvoiceCategoryId($this->strict($_POST ['invoiceCategoryId'], 'string'));
		}
		if (isset($_POST ['lateInterestId'])) {
			$this->setLateInterestId($this->strict($_POST ['lateInterestId'], 'string'));
		}
		if (isset($_POST ['invoiceTypeSequence'])) {
			$this->setInvoiceTypeSequence($this->strict($_POST ['invoiceTypeSequence'], 'string'));
		}
		if (isset($_POST ['invoiceTypeCode'])) {
			$this->setInvoiceTypeCode($this->strict($_POST ['invoiceTypeCode'], 'numeric'));
		}
		if (isset($_POST ['invoiceTypeDesc'])) {
			$this->setInvoiceTypeDesc($this->strict($_POST ['invoiceTypeDesc'], 'string'));
		}
		if (isset($_POST ['invoiceTypeCreditLimit'])) {
			$this->setInvoiceTypeCreditLimit($this->strict($_POST ['invoiceTypeCreditLimit'], 'currency'));
		}
		if (isset($_POST ['invoiceTypePeriodLimit'])) {
			$this->setInvoiceTypePeriodLimit($this->strict($_POST ['invoiceTypePeriodLimit'], 'currency'));
		}
		if (isset($_POST ['invoiceTypeInterestRate'])) {
			$this->setInvoiceTypeInterestRate($this->strict($_POST ['invoiceTypeInterestRate'], 'currency'));
		}
		if (isset($_POST ['invoiceTypeMinimumDeposit'])) {
			$this->setInvoiceTypeMinimumDeposit($this->strict($_POST ['invoiceTypeMinimumDeposit'], 'currency'));
		}
		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['invoiceTypeId'])) {
			$this->setTotal(count($_GET ['invoiceTypeId']));
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
			if (isset($_GET ['invoiceTypeId'])) {
				$this->setGeneralLedgerChartOfAccountId($this->strict($_GET ['invoiceTypeId'] [$i], 'numeric'), $i, 'array');
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
	public function setInvoiceTypeId($value, $key, $type) {
		if ($type == 'single') {
			$this->invoiceTypeId = $value;
		} else if ($type == 'array') {
			$this->invoiceTypeId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setInvoiceTypeId ?"));
			exit();
		}
	}

	/**
	 * Return Generalledger Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getInvoiceTypeId($key, $type) {
		if ($type == 'single') {
			return $this->invoiceTypeId;
		} else if ($type == 'array') {
			return $this->invoiceTypeId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getInvoiceTypeId ?"));
			exit();
		}
	}



	/**
	 *
	 * @return
	 */
	public function getInvoiceTypeSequence()
	{
		return $this->invoiceTypeSequence;
	}

	/**
	 *
	 * @param $invoiceTypeSequence
	 */
	public function setInvoiceTypeSequence($invoiceTypeSequence)
	{
		$this->invoiceTypeSequence = $invoiceTypeSequence;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceTypeCode()
	{
		return $this->invoiceTypeCode;
	}

	/**
	 *
	 * @param $invoiceTypeCode
	 */
	public function setInvoiceTypeCode($invoiceTypeCode)
	{
		$this->invoiceTypeCode = $invoiceTypeCode;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceTypeDesc()
	{
		return $this->invoiceTypeDesc;
	}

	/**
	 *
	 * @param $invoiceTypeDesc
	 */
	public function setInvoiceTypeDesc($invoiceTypeDesc)
	{
		$this->invoiceTypeDesc = $invoiceTypeDesc;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceTypeSequenceDesc()
	{
		return $this->invoiceTypeSequenceDesc;
	}

	/**
	 *
	 * @param $invoiceTypeSequenceDesc
	 */
	public function setInvoiceTypeSequenceDesc($invoiceTypeSequenceDesc)
	{
		$this->invoiceTypeSequenceDesc = $invoiceTypeSequenceDesc;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceCategoryId()
	{
		return $this->invoiceCategoryId;
	}

	/**
	 *
	 * @param $invoiceCategoryId
	 */
	public function setInvoiceCategoryId($invoiceCategoryId)
	{
		$this->invoiceCategoryId = $invoiceCategoryId;
	}

	/**
	 *
	 * @return
	 */
	public function getLateInterestId()
	{
		return $this->lateInterestId;
	}

	/**
	 *
	 * @param $lateInterestId
	 */
	public function setLateInterestId($lateInterestId)
	{
		$this->lateInterestId = $lateInterestId;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceTypeCreditLimit()
	{
		return $this->invoiceTypeCreditLimit;
	}

	/**
	 *
	 * @param $invoiceTypeCreditLimit
	 */
	public function setInvoiceTypeCreditLimit($invoiceTypeCreditLimit)
	{
		$this->invoiceTypeCreditLimit = $invoiceTypeCreditLimit;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceTypePeriodLimit()
	{
		return $this->invoiceTypePeriodLimit;
	}

	/**
	 *
	 * @param $invoiceTypePeriodLimit
	 */
	public function setInvoiceTypePeriodLimit($invoiceTypePeriodLimit)
	{
		$this->invoiceTypePeriodLimit = $invoiceTypePeriodLimit;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceTypeInterestRate()
	{
		return $this->invoiceTypeInterestRate;
	}

	/**
	 *
	 * @param $invoiceTypeInterestRate
	 */
	public function setInvoiceTypeInterestRate($invoiceTypeInterestRate)
	{
		$this->invoiceTypeInterestRate = $invoiceTypeInterestRate;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceMinimumDeposit()
	{
		return $this->invoiceMinimumDeposit;
	}

	/**
	 *
	 * @param $invoiceMinimumDeposit
	 */
	public function setInvoiceMinimumDeposit($invoiceMinimumDeposit)
	{
		$this->invoiceMinimumDeposit = $invoiceMinimumDeposit;
	}
}

?>
