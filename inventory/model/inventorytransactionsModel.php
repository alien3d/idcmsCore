<?php

require_once ("../../class/classValidation.php");

/**
 * this is inventoryTransactions model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package inventoryTransactions
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class InventoryTransactionsModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $inventoryTransactionsId;
	/**
	 * @var int
	 */
	private $inventoryTransactionsTypesId;
	/**
	 * @var date
	 */
	private $inventoryTransactionsCreatedDate;
	/**
	 * @var date
	 */
	private $inventoryTransactionsModifiedDate;
	/**
	 * @var int
	 */
	private $productsId;
	/**
	 * @var int
	 */
	private $inventoryTransactionsQty;
	/**
	 * @var int
	 */
	private $purchaseOrdersId;
	/**
	 * @var int
	 */
	private $customerOrdersId;
	/**
	 * @var string
	 */
	private $inventoryTransactionsComments;

	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('inventoryTransactions');
		$this->setPrimaryKeyName('inventoryTransactionsId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['inventoryTransactionsId'])) {
			$this->setInventoryTransactionsId($this->strict($_POST ['inventoryTransactionsId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['inventoryTransactionsTypesId'])) {
			$this->setInventoryTransactionsTypesId($this->strict($_POST ['inventoryTransactionsTypesId'], 'numeric'));
		}
		if(isset($_POST['inventoryTransactionsCreatedDate'])){
			$this->setInventoryTransactionsCreatedDate($this->strict($_POST['inventoryTransactionsCreatedDate'],'date'));
		}
		if(isset($_POST['inventoryTransactionsModifiedDate'])){
			$this->setInventoryTransactionsModifiedDate($this->strict($_POST['inventoryTransactionsModifiedDate'],'date'));
		}
		if(isset($_POST['productsId'])){
			$this->setProductsId($this->strict($_POST['productsId'],'numeric'));
		}
		if(isset($_POST['inventoryTransactionsQty'])){
			$this->setInventoryTransactionsQty($this->strict($_POST['inventoryTransactionsQty'],'numeric'));
		}
		if(isset($_POST['purchaseOrdersId'])){
			$this->setPurchaseOrdersId($this->strict($_POST['purchaseOrdersId'],'numeric'));
		}
		if(isset($_POST['customerOrdersId'])){
			$this->setCustomerOrdersId($this->strict($_POST['customerOrdersId'],'numeric'));
		}
		if(isset($_POST['inventoryTransactionsComments'])){
			$this->setInventoryTransactionsComments($this->strict($_POST['inventoryTransactionsComments'],'string'));
		}

		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['inventoryTransactionsId'])) {
			$this->setTotal(count($_GET ['inventoryTransactionsId']));
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
			if (isset($_GET ['inventoryTransactionsId'])) {
				$this->setInventoryTransactionsId($this->strict($_GET ['inventoryTransactionsId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getInventoryTransactionsId($i, 'array') . ",";
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
	 * Set InventoryTransactions Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setInventoryTransactionsId($value, $key, $type) {
		if ($type == 'single') {
			$this->inventoryTransactionsId = $value;
		} else if ($type == 'array') {
			$this->inventoryTransactionsId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setInventoryTransactionsId ?"));
			exit();
		}
	}

	/**
	 * Return InventoryTransactions Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getInventoryTransactionsId($key, $type) {
		if ($type == 'single') {
			return $this->inventoryTransactionsId;
		} else if ($type == 'array') {
			return $this->inventoryTransactionsId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getInventoryTransactionsId ?"));
			exit();
		}
	}



	/**
	 *
	 * @return
	 */
	public function getInventoryTransactionsTypesId()
	{
		return $this->inventoryTransactionsTypesId;
	}

	/**
	 *
	 * @param $inventoryTransactionsTypesId
	 */
	public function setInventoryTransactionsTypesId($inventoryTransactionsTypesId)
	{
		$this->inventoryTransactionsTypesId = $inventoryTransactionsTypesId;
	}

	/**
	 *
	 * @return
	 */
	public function getInventoryTransactionsCreatedDate()
	{
		return $this->inventoryTransactionsCreatedDate;
	}

	/**
	 *
	 * @param $inventoryTransactionsCreatedDate
	 */
	public function setInventoryTransactionsCreatedDate($inventoryTransactionsCreatedDate)
	{
		$this->inventoryTransactionsCreatedDate = $inventoryTransactionsCreatedDate;
	}

	/**
	 *
	 * @return
	 */
	public function getInventoryTransactionsModifiedDate()
	{
		return $this->inventoryTransactionsModifiedDate;
	}

	/**
	 *
	 * @param $inventoryTransactionsModifiedDate
	 */
	public function setInventoryTransactionsModifiedDate($inventoryTransactionsModifiedDate)
	{
		$this->inventoryTransactionsModifiedDate = $inventoryTransactionsModifiedDate;
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
	public function getCustomerOrdersId()
	{
		return $this->customerOrdersId;
	}

	/**
	 *
	 * @param $customerOrdersId
	 */
	public function setCustomerOrdersId($customerOrdersId)
	{
		$this->customerOrdersId = $customerOrdersId;
	}

	/**
	 *
	 * @return
	 */
	public function getInventoryTransactionsComments()
	{
		return $this->inventoryTransactionsComments;
	}

	/**
	 *
	 * @param $inventoryTransactionsComments
	 */
	public function setInventoryTransactionsComments($inventoryTransactionsComments)
	{
		$this->inventoryTransactionsComments = $inventoryTransactionsComments;
	}

	/**
	 * 
	 * @return 
	 */
	public function getInventoryTransactionsQty()
	{
	    return $this->inventoryTransactionsQty;
	}

	/**
	 * 
	 * @param $inventoryTransactionsQty
	 */
	public function setInventoryTransactionsQty($inventoryTransactionsQty)
	{
	    $this->inventoryTransactionsQty = $inventoryTransactionsQty;
	}
}

?>
