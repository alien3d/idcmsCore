<?php

require_once ("../../class/classValidation.php");

/**
 * The general journal is where double entry bookkeeping entries are recorded by debiting one or more accounts and crediting another one or more accounts with the same total amount. The total amount debited and the total amount credited should always be equal, thereby ensuring the accounting equation is maintained.Depending on the business's accounting information system, specialized journals may be used in conjunction with the general journal for record-keeping. In such case, use of the general journal may be limited to non-routine and adjusting entries.
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package General Ledger
 * @subpackage Journal
 * @link http://www.idcms.org
 * @http://en.wikipedia.org/wiki/Journal_%28accounting%29
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class InvoiceLedgerModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $invoiceLedgerId;
	/**
	 * @var int
	 */
	private $invoiceId;
	/**
	 * @var int
	 */
	private $businessPartnerId;
	/**
	 * @var int
	 */
	private $invoiceCategoryId;
	/**
	 * @var int
	 */
	private $invoiceTypeId;
	/**
	 * @var string
	 */
	private $documentNo;
	/**
	 * @var string
	 */
	private $referenceNo;
	/**
	 * @var string
	 */
	private $invoiceLedgerTitle;
	/**
	 * @var string
	 */
	private $invoiceLedgerDesc;
	/**
	 * @var date
	 */
	private $invoiceLedgerDate;
	/**
	 * @var date
	 */
	private $invoiceLedgerStartDate;
	/**
	 * @var date
	 */
	private $invoiceLedgerEndDate;
	/**
	 * @var float
	 */
	private $invoiceLedgerAmount;

	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		$this->setTotal(0); // overide testing
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('invoiceLedger');
		$this->setPrimaryKeyName('invoiceLedgerId');
		//$this->setFilterCharacter($filterCharacter);
		$this->setFilterDate('invoiceLedgerDate');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['invoiceLedgerId'])) {
			$this->setInvoiceLedgerId($this->strict($_POST ['invoiceLedgerId'], 'numeric'), 0, 'single');
		}if (isset($_POST ['businessPartnerId'])) {
			$this->setBusinessPartnerId($this->strict($_POST ['businessPartnerId'], 'numeric'));
		}
		if (isset($_POST ['invoiceCategoryId'])) {
			$this->setInvoiceCategoryId($this->strict($_POST ['invoiceCategoryId'], 'numeric'));
		}
		if (isset($_POST ['invoiceLedgerTypeId'])) {
			$this->setInvoiceTypeId($this->strict($_POST ['invoiceTypeId'], 'numeric'));
		}
		if (isset($_POST ['invoiceId'])) {
			$this->setInvoiceLedgerId($this->strict($_POST ['invoiceId'], 'numeric'));
		}
		if (isset($_POST ['documentNo'])) {
			$this->setDocumentNo($this->strict($_POST ['documentNo'], 'string'));
		}
		if (isset($_POST ['referenceNo'])) {
			$this->setReferenceNo($this->strict($_POST ['referenceNo'], 'string'));
		}
		if (isset($_POST ['invoiceLedgerTitle'])) {
			$this->setInvoiceLedgerTitle($this->strict($_POST ['invoiceLedgerTitle'], 'string'));
		}
		if (isset($_POST ['invoiceLedgerDesc'])) {
			$this->setInvoiceLedgerDesc($this->strict($_POST ['invoiceLedgerDesc'], 'string'));
		}
		if (isset($_POST ['invoiceLedgerDate'])) {
			$this->setInvoiceLedgerDate($this->strict($_POST ['invoiceLedgerDate'], 'date'));
		}
		if (isset($_POST ['invoiceLedgerStartDate'])) {
			$this->setInvoiceLedgerStartDate($this->strict($_POST ['invoiceLedgerStartDate'], 'date'));
		}
		if (isset($_POST ['invoiceLedgerEndDate'])) {
			$this->setInvoiceLedgerEndDate($this->strict($_POST ['invoiceLedgerEndDate'], 'date'));
		}
		if (isset($_POST ['invoiceLedgerAmount'])) {
			$this->setInvoiceLedgerAmount($this->strict($_POST ['invoiceLedgerAmount'], 'float'));
		}

		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['invoiceLedgerId'])) {
			$this->setTotal(count($_GET ['invoiceLedgerId']));
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
			if (isset($_GET ['invoiceLedgerId'])) {
				$this->setInvoiceLedgerId($this->strict($_GET ['invoiceLedgerId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getInvoiceLedgerId($i, 'array') . ",";
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
	 * Set InvoiceLedger Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setInvoiceLedgerId($value, $key, $type) {
		if ($type == 'single') {
			$this->invoiceLedgerId = $value;
		} else if ($type == 'array') {
			$this->invoiceLedgerId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setInvoiceLedgerId ?"));
			exit();
		}
	}

	/**
	 * Return InvoiceLedger Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getInvoiceLedgerId($key, $type) {
		if ($type == 'single') {
			return $this->invoiceLedgerId;
		} else if ($type == 'array') {
			return $this->invoiceLedgerId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getInvoiceLedgerId ?"));
			exit();
		}
	}


	/**
	 *
	 * @return
	 */
	public function getDocumentNo()
	{
		return $this->documentNo;
	}

	/**
	 *
	 * @param $documentNo
	 */
	public function setDocumentNo($documentNo)
	{
		$this->documentNo = $documentNo;
	}
	/**
	 *
	 * @return
	 */
	public function getReferenceNo()
	{
		return $this->referenceNo;
	}

	/**
	 *
	 * @param $referenceNo
	 */
	public function setReferenceNo($referenceNo)
	{
		$this->referenceNo = $referenceNo;
	}


	/**
	 *
	 * @return
	 */
	public function getInvoiceLedgerTitle()
	{
		return $this->invoiceLedgerTitle;
	}

	/**
	 *
	 * @param $invoiceLedgerTitle
	 */
	public function setInvoiceLedgerTitle($invoiceLedgerTitle)
	{
		$this->invoiceLedgerTitle = $invoiceLedgerTitle;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceLedgerDesc()
	{
		return $this->invoiceLedgerDesc;
	}

	/**
	 *
	 * @param $invoiceLedgerDesc
	 */
	public function setInvoiceLedgerDesc($invoiceLedgerDesc)
	{
		$this->invoiceLedgerDesc = $invoiceLedgerDesc;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceLedgerDate()
	{
		return $this->invoiceLedgerDate;
	}

	/**
	 *
	 * @param $invoiceLedgerDate
	 */
	public function setInvoiceLedgerDate($invoiceLedgerDate)
	{
		$this->invoiceLedgerDate = $invoiceLedgerDate;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceLedgerStartDate()
	{
		return $this->invoiceLedgerStartDate;
	}

	/**
	 *
	 * @param $invoiceLedgerStartDate
	 */
	public function setInvoiceLedgerStartDate($invoiceLedgerStartDate)
	{
		$this->invoiceLedgerStartDate = $invoiceLedgerStartDate;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceLedgerEndDate()
	{
		return $this->invoiceLedgerEndDate;
	}

	/**
	 *
	 * @param $invoiceLedgerDate
	 */
	public function setInvoiceLedgerEndDate($invoiceLedgerEndDate)
	{
		$this->invoiceLedgerEndDate = $invoiceLedgerEndDate;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceLedgerAmount()
	{
		return $this->invoiceLedgerAmount;
	}

	/**
	 *
	 * @param $invoiceLedgerAmount
	 */
	public function setInvoiceLedgerAmount($invoiceLedgerAmount)
	{
		$this->invoiceLedgerAmount = $invoiceLedgerAmount;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceLedgerTypeId()
	{
		return $this->invoiceLedgerTypeId;
	}

	/**
	 *
	 * @param $invoiceLedgerTypeId
	 */
	public function setInvoiceLedgerTypeId($invoiceLedgerTypeId)
	{
		$this->invoiceLedgerTypeId = $invoiceLedgerTypeId;
	}

	/**
	 *
	 * @return
	 */
	public function getInvoiceId()
	{
		return $this->invoiceId;
	}

	/**
	 *
	 * @param $invoiceId
	 */
	public function setInvoiceId($invoiceId)
	{
		$this->invoiceId = $invoiceId;
	}

	/**
	 *
	 * @return
	 */
	public function getBusinessPartnerId()
	{
		return $this->businessPartnerId;
	}

	/**
	 *
	 * @param $businessPartnerId
	 */
	public function setBusinessPartnerId($businessPartnerId)
	{
		$this->businessPartnerId = $businessPartnerId;
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
	public function getInvoiceTypeId()
	{
		return $this->invoiceTypeId;
	}

	/**
	 *
	 * @param $invoiceTypeId
	 */
	public function setInvoiceTypeId($invoiceTypeId)
	{
		$this->invoiceTypeId = $invoiceTypeId;
	}
}

?>
