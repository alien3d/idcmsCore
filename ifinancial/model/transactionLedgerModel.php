<?php

require_once ("../../class/classValidation.php");

/**
 * this is transactionLedger model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Cashbook / Account Receivable
 * @subpackage Transaction Ledger
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class TransactionledgerModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $transactionLedgerId;
	/**
	* @var float
	*/
	private $documentNo;
	/**
	* @var float
	*/
	private $transactionLedgerTitle;
	/**
	* @var int
	*/
	private $transactionLedgerDesc;
	/**
	* @var int
	*/
	private $transactionLedgerAmount;
	/**
	* @var int
	*/
	private $transactionLedgerDate;
	/**
	* @var int
	*/
	private $businessPartnerId;
	/**
	* @var int
	*/
	private $isReconciled;


	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('transactionledger');
		$this->setPrimaryKeyName('transactionLedgerId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['transactionLedgerId'])) {
			$this->setTransactionLedgerId($this->strict($_POST ['transactionLedgerId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['documentNo'])) {
			$this->setDocumentNo($this->strict($_POST ['documentNo'], 'numeric'));
		}
		if (isset($_POST ['transactionLedgerTitle'])) {
			$this->setTransactionLedgerTitle($this->strict($_POST ['transactionLedgerId'], 'string'));
		}
		if (isset($_POST ['transactionLedgerDesc'])) {
			$this->setTransactionLedgerDesc($this->strict($_POST ['transactionLedgerDesc'], 'string'));
		}
		if (isset($_POST ['transactionLedgerAmount'])) {
			$this->setTransactionLedgerAmount($this->strict($_POST ['transactionLedgerAmount'], 'float'));
		}
		if (isset($_POST ['transactionLedgerDate'])) {
			$this->setTransactionLedgerAmount($this->strict($_POST ['transactionLedgerAmount'], 'date'));
		}
		if (isset($_POST ['businessPartnerId'])) {
			$this->setBusinessPartnerId($this->strict($_POST ['businessPartnerId'], 'numeric'));
		}

		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['transactionLedgerId'])) {
			$this->setTotal(count($_GET ['transactionLedgerId']));
		}

		if (isset($_GET ['isReconciled'])) {
			if (is_array($_GET ['isReconciled'])) {
				$this->isDefault = array();
			}
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
			if (isset($_GET ['transactionLedgerId'])) {
				$this->setBankBalanceId($this->strict($_GET ['transactionLedgerId'] [$i], 'numeric'), $i, 'array');
			}
			if (isset($_GET ['isReconciled'])) {
				if ($_GET ['isReconciled'] [$i] == 'true') {
					$this->setIsReconciled(1, $i, 'array');
				} else if ($_GET ['isDefault'] [$i] == 'false') {
					$this->setIsReconciled(0, $i, 'array');
				}
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
			$primaryKeyAll .= $this->getBankBalanceId($i, 'array') . ",";
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
	 * Set BankBalance Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setTransactionLedgerId($value, $key, $type) {
		if ($type == 'single') {
			$this->transactionLedgerId = $value;
		} else if ($type == 'array') {
			$this->transactionLedgerId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setBankBalanceId ?"));
			exit();
		}
	}

	/**
	 * Return BankBalance Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getTransactionLedgerId($key, $type) {
		if ($type == 'single') {
			return $this->transactionLedgerId;
		} else if ($type == 'array') {
			return $this->transactionLedgerId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getBankBalanceId ?"));
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
	public function getTransactionLedgerTitle()
	{
	    return $this->transactionLedgerTitle;
	}

	/**
	 * 
	 * @param $transactionLedgerTitle
	 */
	public function setTransactionLedgerTitle($transactionLedgerTitle)
	{
	    $this->transactionLedgerTitle = $transactionLedgerTitle;
	}

	/**
	 * 
	 * @return 
	 */
	public function getTransactionLedgerDesc()
	{
	    return $this->transactionLedgerDesc;
	}

	/**
	 * 
	 * @param $transactionLedgerDesc
	 */
	public function setTransactionLedgerDesc($transactionLedgerDesc)
	{
	    $this->transactionLedgerDesc = $transactionLedgerDesc;
	}

	/**
	 * 
	 * @return 
	 */
	public function getTransactionLedgerAmount()
	{
	    return $this->transactionLedgerAmount;
	}

	/**
	 * 
	 * @param $transactionLedgerAmount
	 */
	public function setTransactionLedgerAmount($transactionLedgerAmount)
	{
	    $this->transactionLedgerAmount = $transactionLedgerAmount;
	}

	/**
	 * 
	 * @return 
	 */
	public function getTransactionLedgerDate()
	{
	    return $this->transactionLedgerDate;
	}

	/**
	 * 
	 * @param $transactionLedgerDate
	 */
	public function setTransactionLedgerDate($transactionLedgerDate)
	{
	    $this->transactionLedgerDate = $transactionLedgerDate;
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
	public function getIsReconciled()
	{
	    return $this->isReconciled;
	}

	/**
	 * 
	 * @param $reconciled
	 */
	public function setIsReconciled($isReconciled)
	{
	    $this->isReconciled = $isReconciled;
	}
}

?>
