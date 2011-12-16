<?php

require_once ("../../class/classValidation.php");

/**
 * A voucher is a bond which is worth a certain monetary value and which may be spent only for specific reasons or on specific goods. Examples include (but are not limited to) housing, travel, and food vouchers. The term voucher is also a synonym for receipt and is often used to refer to receipts used as evidence of, for example, the declaration that a service has been performed or that an expenditure has been made. *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Account Payable
 * @subpackage Voucher
 * @link http://www.idcms.org
 * @http://en.wikipedia.org/wiki/Voucher
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class VoucherLedgerModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $voucherLedgerId;
	/**
	 * @var int
	 */
	private $voucherTypeId;
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
	private $voucherLedgerTitle;
	/**
	* @var string
	*/
	private $voucherLedgerDesc;
	/**
	* @var date
	*/
	private $voucherLedgerDate;
	/**
	* @var float
	*/
	private $voucherLedgerAmount;

	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		$this->setTotal(0); // overide testing
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('voucherLedger');
		$this->setPrimaryKeyName('voucherLedgerId');
		//$this->setFilterCharacter($filterCharacter);
		$this->setFilterDate('voucherLedgerDate');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['voucherLedgerId'])) {
			$this->setVoucherLedgerId($this->strict($_POST ['voucherLedgerId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['voucherTypeId'])) {
			$this->setVoucherTypeId($this->strict($_POST ['voucherTypeId'], 'numeric'));
		}
		if (isset($_POST ['documentNo'])) {
			$this->setDocumentNo($this->strict($_POST ['documentNo'], 'string'));
		}
		if (isset($_POST ['referenceNo'])) {
			$this->setReferenceNo($this->strict($_POST ['referenceNo'], 'string'));
		}
		if (isset($_POST ['voucherLedgerTitle'])) {
			$this->setVoucherLedgerTitle($this->strict($_POST ['voucherLedgerTitle'], 'string'));
		}
		if (isset($_POST ['voucherLedgerDesc'])) {
			$this->setVoucherLedgerDesc($this->strict($_POST ['voucherLedgerDesc'], 'string'));
		}
		if (isset($_POST ['voucherLedgerAmount'])) {
			$this->setVoucherLedgerAmount($this->strict($_POST ['voucherLedgerAmount'], 'float'));
		}
		
		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['voucherLedgerId'])) {
			$this->setTotal(count($_GET ['voucherLedgerId']));
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
			if (isset($_GET ['voucherLedgerId'])) {
				$this->setVoucherLedgerId($this->strict($_GET ['voucherLedgerId'] [$i], 'numeric'), $i, 'array');				
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
			$primaryKeyAll .= $this->getVoucherLedgerId($i, 'array') . ",";
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
	 * Set VoucherLedger Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setVoucherLedgerId($value, $key, $type) {
		if ($type == 'single') {
			$this->voucherLedgerId = $value;
		} else if ($type == 'array') {
			$this->voucherLedgerId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setVoucherLedgerId ?"));
			exit();
		}
	}

	/**
	 * Return VoucherLedger Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getVoucherLedgerId($key, $type) {
		if ($type == 'single') {
			return $this->voucherLedgerId;
		} else if ($type == 'array') {
			return $this->voucherLedgerId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getVoucherLedgerId ?"));
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
	public function getVoucherLedgerTitle()
	{
	    return $this->voucherLedgerTitle;
	}

	/**
	 * 
	 * @param $voucherLedgerTitle
	 */
	public function setVoucherLedgerTitle($voucherLedgerTitle)
	{
	    $this->voucherLedgerTitle = $voucherLedgerTitle;
	}

	/**
	 * 
	 * @return 
	 */
	public function getVoucherLedgerDesc()
	{
	    return $this->voucherLedgerDesc;
	}

	/**
	 * 
	 * @param $voucherLedgerDesc
	 */
	public function setVoucherLedgerDesc($voucherLedgerDesc)
	{
	    $this->voucherLedgerDesc = $voucherLedgerDesc;
	}

	/**
	 * 
	 * @return 
	 */
	public function getVoucherLedgerDate()
	{
	    return $this->voucherLedgerDate;
	}

	/**
	 * 
	 * @param $voucherLedgerDate
	 */
	public function setVoucherLedgerDate($voucherLedgerDate)
	{
	    $this->voucherLedgerDate = $voucherLedgerDate;
	}
	
	/**
	 * 
	 * @return 
	 */
	public function getVoucherLedgerAmount()
	{
	    return $this->voucherLedgerAmount;
	}

	/**
	 * 
	 * @param $voucherLedgerAmount
	 */
	public function setVoucherLedgerAmount($voucherLedgerAmount)
	{
	    $this->voucherLedgerAmount = $voucherLedgerAmount;
	}	

	/**
	 * 
	 * @return 
	 */
	public function getVoucherTypeId()
	{
	    return $this->voucherTypeId;
	}

	/**
	 * 
	 * @param $voucherTypeId
	 */
	public function setVoucherTypeId($voucherTypeId)
	{
	    $this->voucherTypeId = $voucherTypeId;
	}
}

?>
