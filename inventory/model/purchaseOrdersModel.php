<?php

require_once ("../../class/classValidation.php");

/**
 * this is PurchaseOrders model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package PurchaseOrders
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class PurchaseOrdersModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $purchaseOrdersId;
	/**
	 * @var int
	 */
	private $supplierId;
	/**
	 * @var int
	 */
	private $purchaseOrdersCreatedBy;
	/**
	 * @var date
	 */
	private $purchaseOrdersSubmitDate;
	/**
	 * @var date
	 */
	private $purchaseOrdersCreationDate;
	/**
	 * @var int
	 */
	private $purchaseOrdersStatusId;
	/**
	 * @var date
	 */
	private $purchaseOrdersExpectedDate;
	/**
	 * @var float
	 */
	private $purchaseOrdersShippingFee;
	/**
	 * @var float
	 */
	private $purchaseOrdersTaxes;
	/**
	 * @var date
	 */
	private $purchaseOrdersPaymentDate;
	/**
	 * @var float
	 */
	private $purchaseOrdersPaymentAmt;
	/**
	 * @var string
	 */
	private $purchaseOrdersPaymentMethod;
	/**
	 * @var string
	 */
	private $purchaseOrdersPaymentMethod;
	/**
	 * @var string
	 */
	private $purchaseOrdersPaymentMethod;
	/**
	 * @var string
	 */
	private $purchaseOrdersNotes;
	/**
	 * @var int
	 */
	private $purchaseOrdersApprovedBy;
	/**
	 * @var date
	 */
	private $purchaseOrdersApprovedDate;
	/**
	 * @var int
	 */
	private $purchaseOrdersSubmitBy;

	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('purchaseOrders');
		$this->setPrimaryKeyName('purchaseOrdersId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['purchaseOrdersId'])) {
			$this->setPurchaseOrdersId($this->strict($_POST ['purchaseOrdersId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['supplierId'])) {
			$this->setSupplierId($this->strict($_POST ['supplierId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['purchaseOrdersCreatedBy'])) {
			$this->setPurchaseOrdersId($this->strict($_POST ['purchaseOrdersCreatedBy'], 'string'));
		}
		if (isset($_POST ['purchaseOrdersSubmitDate'])) {
			$this->setPurchaseOrdersSubmitDate($this->strict($_POST ['purchaseOrdersSubmitDate'], 'date'));
		}
		if (isset($_POST ['purchaseOrdersCreationDate'])) {
			$this->setPurchaseOrdersCreationDate($this->strict($_POST ['purchaseOrdersCreationDate'], 'date'));
		}
		if (isset($_POST ['purchaseOrdersStatusId'])) {
			$this->purchaseOrdersStatusId($this->strict($_POST ['purchaseOrdersStatusId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['purchaseOrdersExpectedDate'])) {
			$this->setPurchaseOrdersExpectedDate($this->strict($_POST ['purchaseOrdersExpectedDate'], 'date'));
		}
		if (isset($_POST ['purchaseOrdersShippingFee'])) {
			$this->setPurchaseOrdersShippingFee($this->strict($_POST ['purchaseOrdersShippingFee'], 'float'));
		}
		if (isset($_POST ['purchaseOrdersTaxes'])) {
			$this->setPurchaseOrdersTaxes($this->strict($_POST ['purchaseOrdersTaxes'], 'float'));
		}
		if (isset($_POST ['purchaseOrdersPaymentDate'])) {
			$this->purchaseOrdersPaymentDate($this->strict($_POST ['purchaseOrdersPaymentDate'], 'date'));
		}
		if (isset($_POST ['purchaseOrdersPaymentAmt'])) {
			$this->setPurchaseOrdersPaymentAmt($this->strict($_POST ['purchaseOrdersPaymentAmt'], 'memo'));
		}
		if (isset($_POST ['purchaseOrdersPaymentMethod'])) {
			$this->setPurchaseOrdersPaymentMethod($this->strict($_POST ['purchaseOrdersPaymentMethod'], 'string'));
		}
		if (isset($_POST ['purchaseOrdersNotes'])) {
			$this->setPurchaseOrdersNotes($this->strict($_POST ['purchaseOrdersNotes'], 'string'));
		}
		if (isset($_POST ['purchaseOrdersApprovedBy'])) {
			$this->purchaseOrdersApprovedBy($this->strict($_POST ['purchaseOrdersApprovedBy'], 'numeric'));
		}
		if (isset($_POST ['purchaseOrdersApprovedDate'])) {
			$this->purchaseOrdersApprovedDate($this->strict($_POST ['purchaseOrdersApprovedDate'], 'date'));
		}
		if (isset($_POST ['purchaseOrdersSubmitBy'])) {
			$this->purchaseOrdersSubmitBy($this->strict($_POST ['purchaseOrdersSubmitBy'], 'numeric'));
		}
		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['purchaseOrdersId'])) {
			$this->setTotal(count($_GET ['purchaseOrdersId']));
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
			if (isset($_GET ['purchaseOrdersId'])) {
				$this->setPurchaseOrdersId($this->strict($_GET ['purchaseOrdersId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getPurchaseOrdersId($i, 'array') . ",";
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
	 * Set PurchaseOrders Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setPurchaseOrdersId($value, $key, $type) {
		if ($type == 'single') {
			$this->purchaseOrdersId = $value;
		} else if ($type == 'array') {
			$this->purchaseOrdersId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setPurchaseOrdersId ?"));
			exit();
		}
	}

	/**
	 * Return PurchaseOrders Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getPurchaseOrdersId($key, $type) {
		if ($type == 'single') {
			return $this->purchaseOrdersId;
		} else if ($type == 'array') {
			return $this->purchaseOrdersId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getPurchaseOrdersId ?"));
			exit();
		}
	}



	/**
	 * 
	 * @return 
	 */
	public function getSupplierId()
	{
	    return $this->supplierId;
	}

	/**
	 * 
	 * @param $supplierId
	 */
	public function setSupplierId($supplierId)
	{
	    $this->supplierId = $supplierId;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersCreatedBy()
	{
	    return $this->purchaseOrdersCreatedBy;
	}

	/**
	 * 
	 * @param $purchaseOrdersCreatedBy
	 */
	public function setPurchaseOrdersCreatedBy($purchaseOrdersCreatedBy)
	{
	    $this->purchaseOrdersCreatedBy = $purchaseOrdersCreatedBy;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersSubmitDate()
	{
	    return $this->purchaseOrdersSubmitDate;
	}

	/**
	 * 
	 * @param $purchaseOrdersSubmitDate
	 */
	public function setPurchaseOrdersSubmitDate($purchaseOrdersSubmitDate)
	{
	    $this->purchaseOrdersSubmitDate = $purchaseOrdersSubmitDate;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersCreationDate()
	{
	    return $this->purchaseOrdersCreationDate;
	}

	/**
	 * 
	 * @param $purchaseOrdersCreationDate
	 */
	public function setPurchaseOrdersCreationDate($purchaseOrdersCreationDate)
	{
	    $this->purchaseOrdersCreationDate = $purchaseOrdersCreationDate;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersStatusId()
	{
	    return $this->purchaseOrdersStatusId;
	}

	/**
	 * 
	 * @param $purchaseOrdersStatusId
	 */
	public function setPurchaseOrdersStatusId($purchaseOrdersStatusId)
	{
	    $this->purchaseOrdersStatusId = $purchaseOrdersStatusId;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersExpectedDate()
	{
	    return $this->purchaseOrdersExpectedDate;
	}

	/**
	 * 
	 * @param $purchaseOrdersExpectedDate
	 */
	public function setPurchaseOrdersExpectedDate($purchaseOrdersExpectedDate)
	{
	    $this->purchaseOrdersExpectedDate = $purchaseOrdersExpectedDate;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersShippingFee()
	{
	    return $this->purchaseOrdersShippingFee;
	}

	/**
	 * 
	 * @param $purchaseOrdersShippingFee
	 */
	public function setPurchaseOrdersShippingFee($purchaseOrdersShippingFee)
	{
	    $this->purchaseOrdersShippingFee = $purchaseOrdersShippingFee;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersTaxes()
	{
	    return $this->purchaseOrdersTaxes;
	}

	/**
	 * 
	 * @param $purchaseOrdersTaxes
	 */
	public function setPurchaseOrdersTaxes($purchaseOrdersTaxes)
	{
	    $this->purchaseOrdersTaxes = $purchaseOrdersTaxes;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersPaymentDate()
	{
	    return $this->purchaseOrdersPaymentDate;
	}

	/**
	 * 
	 * @param $purchaseOrdersPaymentDate
	 */
	public function setPurchaseOrdersPaymentDate($purchaseOrdersPaymentDate)
	{
	    $this->purchaseOrdersPaymentDate = $purchaseOrdersPaymentDate;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersPaymentAmt()
	{
	    return $this->purchaseOrdersPaymentAmt;
	}

	/**
	 * 
	 * @param $purchaseOrdersPaymentAmt
	 */
	public function setPurchaseOrdersPaymentAmt($purchaseOrdersPaymentAmt)
	{
	    $this->purchaseOrdersPaymentAmt = $purchaseOrdersPaymentAmt;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersPaymentMethod()
	{
	    return $this->purchaseOrdersPaymentMethod;
	}

	/**
	 * 
	 * @param $purchaseOrdersPaymentMethod
	 */
	public function setPurchaseOrdersPaymentMethod($purchaseOrdersPaymentMethod)
	{
	    $this->purchaseOrdersPaymentMethod = $purchaseOrdersPaymentMethod;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersPaymentMethod()
	{
	    return $this->purchaseOrdersPaymentMethod;
	}

	/**
	 * 
	 * @param $purchaseOrdersPaymentMethod
	 */
	public function setPurchaseOrdersPaymentMethod($purchaseOrdersPaymentMethod)
	{
	    $this->purchaseOrdersPaymentMethod = $purchaseOrdersPaymentMethod;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersPaymentMethod()
	{
	    return $this->purchaseOrdersPaymentMethod;
	}

	/**
	 * 
	 * @param $purchaseOrdersPaymentMethod
	 */
	public function setPurchaseOrdersPaymentMethod($purchaseOrdersPaymentMethod)
	{
	    $this->purchaseOrdersPaymentMethod = $purchaseOrdersPaymentMethod;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersNotes()
	{
	    return $this->purchaseOrdersNotes;
	}

	/**
	 * 
	 * @param $purchaseOrdersNotes
	 */
	public function setPurchaseOrdersNotes($purchaseOrdersNotes)
	{
	    $this->purchaseOrdersNotes = $purchaseOrdersNotes;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersApprovedBy()
	{
	    return $this->purchaseOrdersApprovedBy;
	}

	/**
	 * 
	 * @param $purchaseOrdersApprovedBy
	 */
	public function setPurchaseOrdersApprovedBy($purchaseOrdersApprovedBy)
	{
	    $this->purchaseOrdersApprovedBy = $purchaseOrdersApprovedBy;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersApprovedDate()
	{
	    return $this->purchaseOrdersApprovedDate;
	}

	/**
	 * 
	 * @param $purchaseOrdersApprovedDate
	 */
	public function setPurchaseOrdersApprovedDate($purchaseOrdersApprovedDate)
	{
	    $this->purchaseOrdersApprovedDate = $purchaseOrdersApprovedDate;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersSubmitBy()
	{
	    return $this->purchaseOrdersSubmitBy;
	}

	/**
	 * 
	 * @param $purchaseOrdersSubmitBy
	 */
	public function setPurchaseOrdersSubmitBy($purchaseOrdersSubmitBy)
	{
	    $this->purchaseOrdersSubmitBy = $purchaseOrdersSubmitBy;
	}
}

?>
