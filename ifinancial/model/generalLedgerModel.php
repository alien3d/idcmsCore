<?php

require_once ("../../class/classValidation.php");

/**
 * General Ledger Transaction.All Transaction  From Subside Account Will Be put here.Subside Account- Account Payable,Account Receivable,Fix Asset,Payroll etc
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package General Ledger
 * @subpackage General Ledger
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class GeneralledgerModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $generalLedgerId;
	/**
	* @var string
	*/
	private $documentNo;
	/**
	* @var string
	*/
	private $invoiceNo;
	/**
	* @var string
	*/
	private $paymentNo;
	/**
	* @var string
	*/
	private $adjustmentNo;
	/**
	* @var string
	*/
	private $generalLedgerTitle;
	/**
	* @var string
	*/
	private $generalLedgerDesc;
	/**
	* @var date
	*/
	private $generalLedgerDate;
	/**
	* @var float
	*/
	private $generalLedgerAmount;
	/**
	* @var string
	*/
	private $generalLedgerChartOfAccountNo;
	/**
	* @var string
	*/
	private $generalLedgerChartOfAccountDesc;
	/**
	* @var int
	*/
	private $businessPartnerId;
	/**
	* @var string
	*/
	private $businessPartnerDesc;


	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('generalledger');
		$this->setPrimaryKeyName('generalLedgerId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['generalLedgerId'])) {
			$this->setGeneralLedgerId($this->strict($_POST ['generalLedgerId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['documentNo'])) {
			$this->setDocumentNo($this->strict($_POST ['documentNo'], 'string'));
		}
		if (isset($_POST ['invoiceNo'])) {
			$this->setInvoiceNo($this->strict($_POST ['invoiceNo'], 'string'));
		}
		if (isset($_POST ['paymentNo'])) {
			$this->setPaymentNo($this->strict($_POST ['paymentNo'], 'string'));
		}
		if (isset($_POST ['adjustmentNo'])) {
			$this->setAdjustmentNo($this->strict($_POST ['adjustmentNo'], 'string'));
		}
		if (isset($_POST ['generalLedgerTitle'])) {
			$this->setGeneralLedgerTitle($this->strict($_POST ['generalLedgerTitle'], 'string'));
		}
		if (isset($_POST ['generalLedgerDesc'])) {
			$this->setGeneralLedgerDesc($this->strict($_POST ['generalLedgerDesc'], 'string'));
		}
		if (isset($_POST ['generalLedgerDate'])) {
			$this->setGeneralLedgerDate($this->strict($_POST ['generalLedgerDate'], 'date'));
		}
		if (isset($_POST ['generalLedgerAmount'])) {
			$this->setGeneralLedgerAmount($this->strict($_POST ['generalLedgerAmount'], 'float'));
		}
		if (isset($_POST ['generalLedgerChartOfAccountNo'])) {
			$this->setGeneralLedgerChartOfAccountNo($this->strict($_POST ['generalLedgerChartOfAccountNo'], 'string'));
		}
		if (isset($_POST ['generalLedgerChartOfAccountDesc'])) {
			$this->setGeneralLedgerChartOfAccountDesc($this->strict($_POST ['generalLedgerChartOfAccountDesc'], 'string'));
		}
		if (isset($_POST ['businessPartnerId'])) {
			$this->setBusinessPartnerId($this->strict($_POST ['businessPartnerId'], 'numeric'));
		}
		if (isset($_POST ['businessPartnerDesc'])) {
			$this->setBusinessPartnerDesc($this->strict($_POST ['businessPartnerDesc'], 'string'));
		}

		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['generalledgerId'])) {
			$this->setTotal(count($_GET ['generalLedgerId']));
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
			if (isset($_GET ['generalLedgerId'])) {
				$this->setGeneralLedgerId($this->strict($_GET ['generalLedgerId'] [$i], 'numeric'), $i, 'array');
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
	public function setGeneralLedgerId($value, $key, $type) {
		if ($type == 'single') {
			$this->generalLedgerId = $value;
		} else if ($type == 'array') {
			$this->generalLedgerId [$key] = $value;
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
	public function getGeneralLedgerId($key, $type) {
		if ($type == 'single') {
			return $this->generalLedgerId;
		} else if ($type == 'array') {
			return $this->generalLedgerId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getGeneralledgerId ?"));
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
	public function getInvoiceNo()
	{
	    return $this->invoiceNo;
	}

	/**
	 * 
	 * @param $invoiceNo
	 */
	public function setInvoiceNo($invoiceNo)
	{
	    $this->invoiceNo = $invoiceNo;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPaymentNo()
	{
	    return $this->paymentNo;
	}

	/**
	 * 
	 * @param $paymentNo
	 */
	public function setPaymentNo($paymentNo)
	{
	    $this->paymentNo = $paymentNo;
	}

	/**
	 * 
	 * @return 
	 */
	public function getAdjustmentNo()
	{
	    return $this->adjustmentNo;
	}

	/**
	 * 
	 * @param $adjustmentNo
	 */
	public function setAdjustmentNo($adjustmentNo)
	{
	    $this->adjustmentNo = $adjustmentNo;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerTitle()
	{
	    return $this->generalLedgerTitle;
	}

	/**
	 * 
	 * @param $generalLedgerTitle
	 */
	public function setGeneralLedgerTitle($generalLedgerTitle)
	{
	    $this->generalLedgerTitle = $generalLedgerTitle;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerDesc()
	{
	    return $this->generalLedgerDesc;
	}

	/**
	 * 
	 * @param $generalLedgerDesc
	 */
	public function setGeneralLedgerDesc($generalLedgerDesc)
	{
	    $this->generalLedgerDesc = $generalLedgerDesc;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerDate()
	{
	    return $this->generalLedgerDate;
	}

	/**
	 * 
	 * @param $generalLedgerDate
	 */
	public function setGeneralLedgerDate($generalLedgerDate)
	{
	    $this->generalLedgerDate = $generalLedgerDate;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerAmount()
	{
	    return $this->generalLedgerAmount;
	}

	/**
	 * 
	 * @param $generalLedgerAmount
	 */
	public function setGeneralLedgerAmount($generalLedgerAmount)
	{
	    $this->generalLedgerAmount = $generalLedgerAmount;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerChartOfAccountNo()
	{
	    return $this->generalLedgerChartOfAccountNo;
	}

	/**
	 * 
	 * @param $generalLedgerChartOfAccountNo
	 */
	public function setGeneralLedgerChartOfAccountNo($generalLedgerChartOfAccountNo)
	{
	    $this->generalLedgerChartOfAccountNo = $generalLedgerChartOfAccountNo;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerChartOfAccountDesc()
	{
	    return $this->generalLedgerChartOfAccountDesc;
	}

	/**
	 * 
	 * @param $generalLedgerChartOfAccountDesc
	 */
	public function setGeneralLedgerChartOfAccountDesc($generalLedgerChartOfAccountDesc)
	{
	    $this->generalLedgerChartOfAccountDesc = $generalLedgerChartOfAccountDesc;
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
	public function getBusinessPartnerDesc()
	{
	    return $this->businessPartnerDesc;
	}

	/**
	 * 
	 * @param $businessPartnerDesc
	 */
	public function setBusinessPartnerDesc($businessPartnerDesc)
	{
	    $this->businessPartnerDesc = $businessPartnerDesc;
	}
}

?>
