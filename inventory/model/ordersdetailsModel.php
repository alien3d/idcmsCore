<?php

require_once ("../../class/classValidation.php");

/**
 * this is OrderDetails model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package OrderDetails
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class OrderDetailsModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $orderDetailsId;

	/**
	 * @var int
	 */
	private $ordersId;
	/**
	 * @var int
	 */
	private $productsId;
	/**
	 * @var decimal
	 */
	private $orderDetailsQty;
	/**
	 * @var date
	 */
	private $orderDetailsUnitPrice;
	/**
	 * @var date
	 */
	private $orderDetailsDiscount;
	/**
	 * @var date
	 */
	private $orderDetailsStatusId;
	/**
	 * @var date
	 */
	private $orderDetailsDateAllocated;
	/**
	 * @var date
	 */
	private $purchaseOrdersId;
	/**
	 * @var float
	 */
	private $inventoryId;
  
	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('orderDetails');
		$this->setPrimaryKeyName('orderDetailsId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['orderDetailsId'])) {
			$this->setOrderDetailsId($this->strict($_POST ['orderDetailsId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['ordersId'])) {
			$this->setOrdersId($this->strict($_POST ['ordersId'], 'numeric'),0,'single');
		}
		if (isset($_POST ['productsId'])) {
			$this->setProductsId($this->strict($_POST ['productsId'], 'numeric'),0,'single');
		}
		if (isset($_POST ['orderDetailsQty'])) {
			$this->setOrderDetailsQty($this->strict($_POST ['orderDetailsQty'], 'float'));
		}
		if (isset($_POST ['orderDetailsUnitPrice'])) {
			$this->setOrderDetailsUnitPrice($this->strict($_POST ['orderDetailsUnitPrice'], 'date'));
		}
		if (isset($_POST ['orderDetailsDiscount'])) {
			$this->setOrderDetailsDiscount($this->strict($_POST ['orderDetailsDiscount'], 'float'));
		}
		if (isset($_POST ['orderDetailsStatusId'])) {
			$this->setOrderDetailsStatusId($this->strict($_POST ['orderDetailsStatusId'], 'numeric'),0,'single');
		}
		if (isset($_POST ['orderDetailsDateAllocated'])) {
			$this->setOrderDetailsDateAllocated($this->strict($_POST ['orderDetailsDateAllocated'], 'date'));
		}
		if (isset($_POST ['purchaseOrdersId'])) {
			$this->sePurchaseOrdersId($this->strict($_POST ['purchaseOrdersId'], 'numeric'),0,'single');
		}
		if (isset($_POST ['inventoryId'])) {
			$this->setInventoryId($this->strict($_POST ['inventoryId'], 'numeric'),0,'single');
		}

		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['orderDetailsId'])) {
			$this->setTotal(count($_GET ['orderDetailsId']));
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
			if (isset($_GET ['orderDetailsId'])) {
				$this->setOrderDetailsId($this->strict($_GET ['orderDetailsId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getOrderDetailsId($i, 'array') . ",";
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
	 * Set OrderDetails Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setOrderDetailsId($value, $key, $type) {
		if ($type == 'single') {
			$this->OrderDetailsId = $value;
		} else if ($type == 'array') {
			$this->OrderDetailsId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setOrderDetailsId ?"));
			exit();
		}
	}

	/**
	 * Return OrderDetails Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getOrderDetailsId($key, $type) {
		if ($type == 'single') {
			return $this->OrderDetailsId;
		} else if ($type == 'array') {
			return $this->OrderDetailsId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getOrderDetailsId ?"));
			exit();
		}
	}


	/**
	 * 
	 * @return 
	 */
	public function getOrdersId()
	{
	    return $this->ordersId;
	}

	/**
	 * 
	 * @param $ordersId
	 */
	public function setOrdersId($ordersId)
	{
	    $this->ordersId = $ordersId;
	}

	/**
	 * 
	 * @return 
	 */
	public function getProductsId()
	{
	    return $this->productsId;
	}

	/**
	 * 
	 * @param $productsId
	 */
	public function setProductsId($productsId)
	{
	    $this->productsId = $productsId;
	}

	/**
	 * 
	 * @return 
	 */
	public function getOrderDetailsQty()
	{
	    return $this->orderDetailsQty;
	}

	/**
	 * 
	 * @param $orderDetailsQty
	 */
	public function setOrderDetailsQty($orderDetailsQty)
	{
	    $this->orderDetailsQty = $orderDetailsQty;
	}

	/**
	 * 
	 * @return 
	 */
	public function getOrderDetailsUnitPrice()
	{
	    return $this->orderDetailsUnitPrice;
	}

	/**
	 * 
	 * @param $orderDetailsUnitPrice
	 */
	public function setOrderDetailsUnitPrice($orderDetailsUnitPrice)
	{
	    $this->orderDetailsUnitPrice = $orderDetailsUnitPrice;
	}

	/**
	 * 
	 * @return 
	 */
	public function getOrderDetailsDiscount()
	{
	    return $this->orderDetailsDiscount;
	}

	/**
	 * 
	 * @param $orderDetailsDiscount
	 */
	public function setOrderDetailsDiscount($orderDetailsDiscount)
	{
	    $this->orderDetailsDiscount = $orderDetailsDiscount;
	}

	/**
	 * 
	 * @return 
	 */
	public function getOrderDetailsStatusId()
	{
	    return $this->orderDetailsStatusId;
	}

	/**
	 * 
	 * @param $orderDetailsStatusId
	 */
	public function setOrderDetailsStatusId($statusId)
	{
	    $this->statusId = $orderDetailsStatusId;
	}

	/**
	 * 
	 * @return 
	 */
	public function getOrderDetailsDateAllocated()
	{
	    return $this->orderDetailsDateAllocated;
	}

	/**
	 * 
	 * @param $orderDetailsDateAllocated
	 */
	public function setOrderDetailsDateAllocated($orderDetailsDateAllocated)
	{
	    $this->orderDetailsDateAllocated = $orderDetailsDateAllocated;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrdersId()
	{
	    return $this->purchaseOrdersId;
	}

	/**
	 * 
	 * @param $purchaseOrdersId
	 */
	public function setPurchaseOrdersId($purchaseOrdersId)
	{
	    $this->purchaseOrdersId = $purchaseOrdersId;
	}

	/**
	 * 
	 * @return 
	 */
	public function getInventoryId()
	{
	    return $this->inventoryId;
	}

	/**
	 * 
	 * @param $inventoryId
	 */
	public function setInventoryId($inventoryId)
	{
	    $this->inventoryId = $inventoryId;
	}
}

?>
