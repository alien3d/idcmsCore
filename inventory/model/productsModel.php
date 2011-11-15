<?php

require_once ("../../class/classValidation.php");

/**
 * this is Products model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Products
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ProductsModel extends ValidationClass {


	/**
	 * @var int
	 */
	private $supplierId;
	/**
	 * @var int
	 */
	private $productsId;
	/**
	 * @var string
	 */
	private $productsCode;
	/**
	 * @var string
	 */
	private $productsName;
	/**
	 * @var string
	 */
	private $productsDescription;
	/**
	 * @var float
	 */
	private $productsStdCost;
	/**
	 * @var float
	 */
	private $productsListPrice;
	/**
	 * @var int
	 */
	private $productsReorderLevel;
	/**
	 * @var int
	 */
	private $productsTargetLevel;
	/**
	 * @var string
	 */
	private $productsQtyPerUnit;
	/**
	 * @var int
	 */
	private $productsDiscontinued;
	/**
	 * @var int
	 */
	private $productsMinReorderQty;
	/**
	 * @var string
	 */
	private $productsCategory;
	/**
	 * @var string
	 */
	private $productsAttachments;



	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('products');
		$this->setPrimaryKeyName('productsId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['supplierId'])) {
			$this->setSupplierId($this->strict($_POST ['supplierId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['productsId'])) {
			$this->setProductsId($this->strict($_POST ['productsId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['productsCode'])) {
			$this->setProductsCode($this->strict($_POST ['productsCode'], 'string'));
		}
		if (isset($_POST ['productsName'])) {
			$this->setProductsName($this->strict($_POST ['productsName'], 'string'));
		}
		if (isset($_POST ['productsDescription'])) {
			$this->setProductsDescription($this->strict($_POST ['productsDescription'], 'string'));
		}
		if (isset($_POST ['productsStdCost'])) {
			$this->setProductsStdCost($this->strict($_POST ['productsStdCost'], 'float'));
		}
		if (isset($_POST ['productsListPrice'])) {
			$this->setProductsListPrice($this->strict($_POST ['productsListPrice'], 'float'));
		}
		if (isset($_POST ['productsReorderLevel'])) {
			$this->setProductsReorderLevel($this->strict($_POST ['productsReorderLevel'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['productsTargetLevel'])) {
			$this->setProductsTargetLevel($this->strict($_POST ['productsTargetLevel'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['productsDescription'])) {
			$this->setProductsDescription($this->strict($_POST ['productsDescription'], 'string'));
		}
		if (isset($_POST ['productsQtyPerUnit'])) {
			$this->setProductsQtyPerUnit($this->strict($_POST ['productsQtyPerUnit'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['productsDiscontinued'])) {
			$this->setProductsDiscontinued($this->strict($_POST ['productsDiscontinued'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['productsMinReorderQty'])) {
			$this->setProductsMinReorderQty($this->strict($_POST ['productsMinReorderQty'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['productsCategory'])) {
			$this->setProductsCategoryn($this->strict($_POST ['productsCategory'], 'string'));
		}
		if (isset($_POST ['productsAttachments'])) {
			$this->setProductsAttachments($this->strict($_POST ['productsAttachments'], 'string'));
		}


		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['productsId'])) {
			$this->setTotal(count($_GET ['productsId']));
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
			if (isset($_GET ['productsId'])) {
				$this->setProductsId($this->strict($_GET ['productsId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getProductsId($i, 'array') . ",";
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
	 * Set Products Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setProductsId($value, $key, $type) {
		if ($type == 'single') {
			$this->productsId = $value;
		} else if ($type == 'array') {
			$this->productsId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setProductsId ?"));
			exit();
		}
	}

	/**
	 * Return Products Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getProductsId($key, $type) {
		if ($type == 'single') {
			return $this->productsId;
		} else if ($type == 'array') {
			return $this->productsId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getProductsId ?"));
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
	public function getProductsCode()
	{
	    return $this->productsCode;
	}

	/**
	 * 
	 * @param $productsCode
	 */
	public function setProductsCode($productsCode)
	{
	    $this->productsCode = $productsCode;
	}

	/**
	 * 
	 * @return 
	 */
	public function getProductsName()
	{
	    return $this->productsName;
	}

	/**
	 * 
	 * @param $productsName
	 */
	public function setProductsName($productsName)
	{
	    $this->productsName = $productsName;
	}

	/**
	 * 
	 * @return 
	 */
	public function getProductsDescription()
	{
	    return $this->productsDescription;
	}

	/**
	 * 
	 * @param $productsDescription
	 */
	public function setProductsDescription($productsDescription)
	{
	    $this->productsDescription = $productsDescription;
	}

	/**
	 * 
	 * @return 
	 */
	public function getProductsStdCost()
	{
	    return $this->productsStdCost;
	}

	/**
	 * 
	 * @param $productsStdCost
	 */
	public function setProductsStdCost($productsStdCost)
	{
	    $this->productsStdCost = $productsStdCost;
	}

	/**
	 * 
	 * @return 
	 */
	public function getProductsListPrice()
	{
	    return $this->productsListPrice;
	}

	/**
	 * 
	 * @param $productsListPrice
	 */
	public function setProductsListPrice($productsListPrice)
	{
	    $this->productsListPrice = $productsListPrice;
	}

	/**
	 * 
	 * @return 
	 */
	public function getProductsReorderLevel()
	{
	    return $this->productsReorderLevel;
	}

	/**
	 * 
	 * @param $productsReorderLevel
	 */
	public function setProductsReorderLevel($productsReorderLevel)
	{
	    $this->productsReorderLevel = $productsReorderLevel;
	}

	/**
	 * 
	 * @return 
	 */
	public function getProductsTargetLevel()
	{
	    return $this->productsTargetLevel;
	}

	/**
	 * 
	 * @param $productsTargetLevel
	 */
	public function setProductsTargetLevel($productsTargetLevel)
	{
	    $this->productsTargetLevel = $productsTargetLevel;
	}

	/**
	 * 
	 * @return 
	 */
	public function getProductsQtyPerUnit()
	{
	    return $this->productsQtyPerUnit;
	}

	/**
	 * 
	 * @param $productsQtyPerUnit
	 */
	public function setProductsQtyPerUnit($productsQtyPerUnit)
	{
	    $this->productsQtyPerUnit = $productsQtyPerUnit;
	}

	/**
	 * 
	 * @return 
	 */
	public function getProductsDiscontinued()
	{
	    return $this->productsDiscontinued;
	}

	/**
	 * 
	 * @param $productsDiscontinued
	 */
	public function setProductsDiscontinued($productsDiscontinued)
	{
	    $this->productsDiscontinued = $productsDiscontinued;
	}

	/**
	 * 
	 * @return 
	 */
	public function getProductsMinReorderQty()
	{
	    return $this->productsMinReorderQty;
	}

	/**
	 * 
	 * @param $productsMinReorderQty
	 */
	public function setProductsMinReorderQty($productsMinReorderQty)
	{
	    $this->productsMinReorderQty = $productsMinReorderQty;
	}

	/**
	 * 
	 * @return 
	 */
	public function getProductsCategory()
	{
	    return $this->productsCategory;
	}

	/**
	 * 
	 * @param $productsCategory
	 */
	public function setProductsCategory($productsCategory)
	{
	    $this->productsCategory = $productsCategory;
	}

	/**
	 * 
	 * @return 
	 */
	public function getProductsAttachments()
	{
	    return $this->productsAttachments;
	}

	/**
	 * 
	 * @param $productsAttachments
	 */
	public function setProductsAttachments($productsAttachments)
	{
	    $this->productsAttachments = $productsAttachments;
	}
}

?>
