<?php
require_once ("../../class/classValidation.php");

/**
 * A voucher is a bond which is worth a certain monetary value and which may be spent only for specific reasons or on specific goods. Examples include (but are not limited to) housing, travel, and food voucherLedgers. The term voucherLedger is also a synonym for receipt and is often used to refer to receipts used as evidence of, for example, the declaration that a service has been performed or that an expenditure has been made
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Account Receivable
 * @subpackage Voucher Transaction Detail
 * @link http://www.idcms.org
 * @http://en.wikipedia.org/wiki/VoucherLedger
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class VoucherLedgerDetailModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $voucherLedgerDetailId;
	/**
	* @var int
	*/
	private $voucherLedgerId;
	/**
	* @var string
	*/
	private $generalLedgerChartOfAccountId;
	/**
	 * Transaction Mode D -Debit C - Credit
	 * @var string 
	 */
	private $transactionMode;
	/**
	* @var string
	*/
	private $countryId;
	/**
	* @var float
	*/
	private $voucherLedgerDetailAmount;

	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('voucherLedgerDetail');
		$this->setPrimaryKeyName('voucherLedgerDetailId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['voucherLedgerDetailId'])) {
			$this->setVoucherLedgerDetailId($this->strict($_POST ['voucherLedgerDetailId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['voucherLedgerId'])) {
			$this->setVoucherLedgerId($this->strict($_POST ['voucherLedgerId'], 'numeric'));
		}
		if (isset($_POST ['generalLedgerChartOfAccountId'])) {
			$this->setGeneralLedgerChartOfAccountId($this->strict($_POST ['generalLedgerChartOfAccountId'], 'numeric'));
		}
		if (isset($_POST ['transactionMode'])) {
			$this->setTransactionMode($this->strict($_POST ['transactionMode'], 'string'));
		}
		if (isset($_POST ['countryId'])) {
			$this->setCountryId($this->strict($_POST ['countryId'], 'numeric'));
		}
		if (isset($_POST ['voucherLedgerDetailAmount'])) {
			$this->setVoucherLedgerDetailAmount($this->strict($_POST ['voucherLedgerDetailAmount'], 'float'));
		}
		
		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['voucherLedgerDetailId'])) {
			$this->setTotal(count($_GET ['voucherLedgerDetailId']));
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
			if (isset($_GET ['voucherLedgerDetailId'])) {
				$this->setVoucherLedgerDetailId($this->strict($_GET ['voucherLedgerDetailId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getVoucherLedgerDetailId($i, 'array') . ",";
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
	 * Set VoucherLedgerDetail Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setVoucherLedgerDetailId($value, $key, $type) {
		if ($type == 'single') {
			$this->voucherLedgerDetailId = $value;
		} else if ($type == 'array') {
			$this->voucherLedgerDetailId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setVoucherLedgerDetailId ?"));
			exit();
		}
	}

	/**
	 * Return VoucherLedgerDetail Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getVoucherLedgerDetailId($key, $type) {
		if ($type == 'single') {
			return $this->voucherLedgerDetailId;
		} else if ($type == 'array') {
			return $this->voucherLedgerDetailId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getVoucherLedgerDetailId ?"));
			exit();
		}
	}
	


	/**
	 * 
	 * @return 
	 */
	public function getVoucherLedgerId()
	{
	    return $this->voucherLedgerId;
	}

	/**
	 * 
	 * @param $voucherLedgerId
	 */
	public function setVoucherLedgerId($voucherLedgerId)
	{
	    $this->voucherLedgerId = $voucherLedgerId;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerChartOfAccountId()
	{
	    return $this->generalLedgerChartOfAccountId;
	}

	/**
	 * 
	 * @param $generalLedgerChartOfAccountId
	 */
	public function setGeneralLedgerChartOfAccountId($generalLedgerChartOfAccountId)
	{
	    $this->generalLedgerChartOfAccountId = $generalLedgerChartOfAccountId;
	}

	/**
	 * 
	 * @return 
	 */
	public function getCountryId()
	{
	    return $this->countryId;
	}

	/**
	 * 
	 * @param $countryId
	 */
	public function setCountryId($countryId)
	{
	    $this->countryId = $countryId;
	}

	/**
	 * 
	 * @return 
	 */
	public function getVoucherLedgerDetailAmount()
	{
	    return $this->voucherLedgerDetailAmount;
	}

	/**
	 * 
	 * @param $voucherLedgerDetailAmount
	 */
	public function setVoucherLedgerDetailAmount($voucherLedgerDetailAmount)
	{
	    $this->voucherLedgerDetailAmount = $voucherLedgerDetailAmount;
	}

	/**
	 * 
	 * @return 
	 */
	public function getTransactionMode()
	{
	    return $this->transactionMode;
	}

	/**
	 * 
	 * @param $transactionMode
	 */
	public function setTransactionMode($transactionMode)
	{
	    $this->transactionMode = $transactionMode;
	}
}

?>
