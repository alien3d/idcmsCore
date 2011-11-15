<?php

require_once ("../../class/classValidation.php");

/**
 * this is purchaseOrderDetails model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package purchaseOrderDetails
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class PurchaseOrderDetailsModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $purchaseOrderDetailsId;
	/**
	 * @var int
	 */
	private $purchaseOrderId;
	/**
	 * @var int
	 */
	private $productsId;
	/**
	 * @var float
	 */
	private $purchaseOrderDetailsQty;
	/**
	 * @var float
	 */
	private $purchaseOrderDetailsUnitCost;
	/**
	 * @var date
	 */
	private $purchaseOrderDetailsDateRec;
	/**
	 * @var int
	 */
	private $postedToInventory;
	/**
	 * @var int
	 */
	private $inventoryId;


	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('purchaseOrderDetails');
		$this->setPrimaryKeyName('purchaseOrderDetailsId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['purchaseOrderDetailsId'])) {
			$this->setPurchaseOrderDetailsId($this->strict($_POST ['purchaseOrderDetailsId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['purchaseOrderId'])) {
			$this->setPurchaseOrderId($this->strict($_POST ['purchaseOrderId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['productsId'])) {
			$this->setProductsId($this->strict($_POST ['productsId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['purchaseOrderDetailsQty'])) {
			$this->setPurchaseOrderDetailsQty($this->strict($_POST ['purchaseOrderDetailsQty'], 'float'));
		}
		if(isset($_POST['purchaseOrderDetailsUnitCost'])){
			$this->setPurchaseOrderDetailsUnitCost($this->strict($_POST['purchaseOrderDetailsUnitCost'],'float'));
		}
		if(isset($_POST['purchaseOrderDetailsDateRec'])){
			$this->setPurchaseOrderDetailsDateRec($this->strict($_POST['purchaseOrderDetailsDateRec'],'date'));
		}
		if(isset($_POST['postedToInventory'])){
			$this->setPostedToInventory($this->strict($_POST['postedToInventory'],'numeric'), 0, 'single');
		}
		if(isset($_POST['inventoryId'])){
			$this->setInventoryId($this->strict($_POST['inventoryId'],'numeric'), 0, 'single');
		}
		
		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['purchaseOrderDetailsId'])) {
			$this->setTotal(count($_GET ['purchaseOrderDetailsId']));
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
			if (isset($_GET ['purchaseOrderDetailsId'])) {
				$this->setPurchaseOrderDetailsId($this->strict($_GET ['purchaseOrderDetailsId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getPurchaseOrderDetailsId($i, 'array') . ",";
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
	 * Set PurchaseOrderDetails Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setPurchaseOrderDetailsId($value, $key, $type) {
		if ($type == 'single') {
			$this->purchaseOrderDetailsId = $value;
		} else if ($type == 'array') {
			$this->purchaseOrderDetailsId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setPurchaseOrderDetailsId ?"));
			exit();
		}
	}

	/**
	 * Return PurchaseOrderDetails Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getPurchaseOrderDetailsId($key, $type) {
		if ($type == 'single') {
			return $this->purchaseOrderDetailsId;
		} else if ($type == 'array') {
			return $this->purchaseOrderDetailsId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getPurchaseOrderDetailsId ?"));
			exit();
		}
	}





	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrderId()
	{
	    return $this->purchaseOrderId;
	}

	/**
	 * 
	 * @param $purchaseOrderId
	 */
	public function setPurchaseOrderId($purchaseOrderId)
	{
	    $this->purchaseOrderId = $purchaseOrderId;
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
	public function getPurchaseOrderDetailsQty()
	{
	    return $this->purchaseOrderDetailsQty;
	}

	/**
	 * 
	 * @param $purchaseOrderDetailsQty
	 */
	public function setPurchaseOrderDetailsQty($purchaseOrderDetailsQty)
	{
	    $this->purchaseOrderDetailsQty = $purchaseOrderDetailsQty;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrderDetailsUnitCost()
	{
	    return $this->purchaseOrderDetailsUnitCost;
	}

	/**
	 * 
	 * @param $purchaseOrderDetailsUnitCost
	 */
	public function setPurchaseOrderDetailsUnitCost($purchaseOrderDetailsUnitCost)
	{
	    $this->purchaseOrderDetailsUnitCost = $purchaseOrderDetailsUnitCost;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPurchaseOrderDetailsDateRec()
	{
	    return $this->purchaseOrderDetailsDateRec;
	}

	/**
	 * 
	 * @param $purchaseOrderDetailsDateRec
	 */
	public function setPurchaseOrderDetailsDateRec($purchaseOrderDetailsDateRec)
	{
	    $this->purchaseOrderDetailsDateRec = $purchaseOrderDetailsDateRec;
	}

	/**
	 * 
	 * @return 
	 */
	public function getPostedToInventory()
	{
	    return $this->postedToInventory;
	}

	/**
	 * 
	 * @param $postedToInventory
	 */
	public function setPostedToInventory($postedToInventory)
	{
	    $this->postedToInventory = $postedToInventory;
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
