<?php

require_once ("../../class/classValidation.php");

/**
 * this is Orders model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Orders
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class OrdersModel extends ValidationClass {

	/**
	 * ordersId
	 * @var int
	 */
	private $ordersId;

	/**
	 * employeeId
	 * @var int
	 */
	private $employeeId;
	/**
	 * customerId
	 * @var int
	 */
	private $customerId;
	/**
	 * ordersDate
	 * @var date
	 */
	private $ordersDate;
	/**
	 * ordersShippedDate
	 * @var date
	 */
	private $ordersShippedDate;
	/**
	 * ShippersID
	 * @var string
	 */
	private $shipperId;
	/**
	 * ordersShipName
	 * @var string
	 */
	private $ordersShipName;
	/**
	 * ordersShipAddress
	 * @var string
	 */
	private $ordersShipAddress;
	/**
	 * ordersShipCity
	 * @var string
	 */
	private $ordersShipCity;
	/**
	 * ordersShipState
	 * @var string
	 */
	private $ordersShipState;
	/**
	 * ordersShipPostCode
	 * @var string
	 */
	private $ordersShipPostCode;
	/**
	 * ordersShipCountry
	 * @var string
	 */
	private $ordersShipCountry;
	/**
	 * ordersShippingFee
	 * @var float
	 */
	private $ordersShippingFee;
	/**
	 * ordersTaxes
	 * @var float
	 */
	private $ordersTaxes;
	/**
	 * ordersPaymentType
	 * @var string
	 */
	private $ordersPaymentType;
	/**
	 * ordersPaidDate
	 * @var date
	 */
	private $ordersPaidDate;
	/**
	 * ordersNotes
	 * @var string
	 */
	private $ordersNotes;
	/**
	 * ordersTaxRate
	 * @var float
	 */
	private $ordersTaxRate;
	/**
	 * ordersTaxStatusId
	 * @var int
	 */
	private $ordersTaxStatusId;
	/**
	 * ordersStatusId
	 * @var int
	 */
	private $ordersStatusId;

	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('orders');
		$this->setPrimaryKeyName('ordersId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['ordersId'])) {
			$this->setOrdersId($this->strict($_POST ['ordersId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['employeeId'])) {
			$this->setEmployeeId($this->strict($_POST ['employeeId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['customerId'])) {
			$this->setCustomerId($this->strict($_POST ['customerId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['ordersDate'])) {
			$this->setOrdersDate($this->strict($_POST ['ordersDate'], 'string'));
		}
		if (isset($_POST ['ordersShippedDate'])) {
			$this->setOrdersShippedDate($this->strict($_POST ['ordersShippedDate'], 'string'));
		}
		if (isset($_POST ['ordersShippedDate'])) {
			$this->setOrdersShippedDate($this->strict($_POST ['ordersShippedDate'], 'string'));
		}
		if (isset($_POST ['shipperId'])) {
			$this->setShipperId($this->strict($_POST ['shipperId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['ordersShipName'])) {
			$this->setOrdersShipName($this->strict($_POST ['ordersShipName'], 'string'));
		}
		if (isset($_POST ['ordersShipAddress'])) {
			$this->setOrdersShipAddress($this->strict($_POST ['ordersShipAddress'], 'string'));
		}
		if (isset($_POST ['ordersShipCity'])) {
			$this->setOrdersShipCity($this->strict($_POST ['ordersShipCity'], 'string'));
		}
		if (isset($_POST ['ordersShipState'])) {
			$this->setOrdersShipState($this->strict($_POST ['ordersShipState'], 'string'));
		}
		if (isset($_POST ['ordersShipPostCode'])) {
			$this->setOrdersShipPostCode($this->strict($_POST ['ordersShipPostCode'], 'string'));
		}
		if (isset($_POST ['ordersShipCountry'])) {
			$this->setOrdersShipCountry($this->strict($_POST ['ordersShipCountry'], 'string'));
		}
		if (isset($_POST ['ordersShippingFee'])) {
			$this->setOrdersShippingFee($this->strict($_POST ['ordersShippingFee'], 'float'));
		}
		if (isset($_POST ['ordersTaxes'])) {
			$this->setOrdersTaxes($this->strict($_POST ['ordersTaxes'], 'float'));
		}
		if (isset($_POST ['ordersPaymentType'])) {
			$this->setOrdersPaymentType($this->strict($_POST ['ordersPaymentType'], 'string'));
		}
		if (isset($_POST ['ordersPaidDate'])) {
			$this->setOrdersPaidDate($this->strict($_POST ['ordersPaidDate'], 'date'));
		}
		if (isset($_POST ['ordersNotes'])) {
			$this->setOrdersNotes($this->strict($_POST ['ordersNotes'], 'string'));
		}
		if (isset($_POST ['ordersTaxRate'])) {
			$this->setOrdersTaxRate($this->strict($_POST ['ordersTaxRate'], 'float'));
		}
		if (isset($_POST ['ordersTaxStatusId'])) {
			$this->setOrdersTaxStatusId($this->strict($_POST ['ordersTaxStatusId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['ordersStatusId'])) {
			$this->setOrdersStatusId($this->strict($_POST ['ordersStatusId'], 'numeric'), 0, 'single');
		}

		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['ordersId'])) {
			$this->setTotal(count($_GET ['ordersId']));
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
			if (isset($_GET ['ordersId'])) {
				$this->setOrdersId($this->strict($_GET ['ordersId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getOrdersId($i, 'array') . ",";
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
	 * Set Orders Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setOrdersId($value, $key, $type) {
		if ($type == 'single') {
			$this->ordersId = $value;
		} else if ($type == 'array') {
			$this->ordersId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setOrdersId ?"));
			exit();
		}
	}

	/**
	 * Return Orders Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getOrdersId($key, $type) {
		if ($type == 'single') {
			return $this->ordersId;
		} else if ($type == 'array') {
			return $this->ordersId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getOrdersId ?"));
			exit();
		}
	}



	/**
	 *
	 * @return
	 */
	public function getEmployeeId()
	{
		return $this->employeeId;
	}

	/**
	 *
	 * @param $employeeId
	 */
	public function setEmployeeId($employeeId)
	{
		$this->employeeId = $employeeId;
	}

	/**
	 *
	 * @return
	 */
	public function getCustomerId()
	{
		return $this->customerId;
	}

	/**
	 *
	 * @param $customerId
	 */
	public function setCustomerId($customerId)
	{
		$this->customerId = $customerId;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersDate()
	{
		return $this->ordersDate;
	}

	/**
	 *
	 * @param $ordersDate
	 */
	public function setOrdersDate($ordersDate)
	{
		$this->ordersDate = $ordersDate;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersShippedDate()
	{
		return $this->ordersShippedDate;
	}

	/**
	 *
	 * @param $ordersShippedDate
	 */
	public function setOrdersShippedDate($ordersShippedDate)
	{
		$this->ordersShippedDate = $ordersShippedDate;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersShipName()
	{
		return $this->ordersShipName;
	}

	/**
	 *
	 * @param $ordersShipName
	 */
	public function setOrdersShipName($ordersShipName)
	{
		$this->ordersShipName = $ordersShipName;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersShipAddress()
	{
		return $this->ordersShipAddress;
	}

	/**
	 *
	 * @param $ordersShipAddress
	 */
	public function setOrdersShipAddress($ordersShipAddress)
	{
		$this->ordersShipAddress = $ordersShipAddress;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersShipCity()
	{
		return $this->ordersShipCity;
	}

	/**
	 *
	 * @param $ordersShipCity
	 */
	public function setOrdersShipCity($ordersShipCity)
	{
		$this->ordersShipCity = $ordersShipCity;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersShipState()
	{
		return $this->ordersShipState;
	}

	/**
	 *
	 * @param $ordersShipState
	 */
	public function setOrdersShipState($ordersShipState)
	{
		$this->ordersShipState = $ordersShipState;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersShipPostCode()
	{
		return $this->ordersShipPostCode;
	}

	/**
	 *
	 * @param $ordersShipPostCode
	 */
	public function setOrdersShipPostCode($ordersShipPostCode)
	{
		$this->ordersShipPostCode = $ordersShipPostCode;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersShipCountry()
	{
		return $this->ordersShipCountry;
	}

	/**
	 *
	 * @param $ordersShipCountry
	 */
	public function setOrdersShipCountry($ordersShipCountry)
	{
		$this->ordersShipCountry = $ordersShipCountry;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersShippingFee()
	{
		return $this->ordersShippingFee;
	}

	/**
	 *
	 * @param $ordersShippingFee
	 */
	public function setOrdersShippingFee($ordersShippingFee)
	{
		$this->ordersShippingFee = $ordersShippingFee;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersTaxes()
	{
		return $this->ordersTaxes;
	}

	/**
	 *
	 * @param $ordersTaxes
	 */
	public function setOrdersTaxes($ordersTaxes)
	{
		$this->ordersTaxes = $ordersTaxes;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersPaymentType()
	{
		return $this->ordersPaymentType;
	}

	/**
	 *
	 * @param $ordersPaymentType
	 */
	public function setOrdersPaymentType($ordersPaymentType)
	{
		$this->ordersPaymentType = $ordersPaymentType;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersPaidDate()
	{
		return $this->ordersPaidDate;
	}

	/**
	 *
	 * @param $ordersPaidDate
	 */
	public function setOrdersPaidDate($ordersPaidDate)
	{
		$this->ordersPaidDate = $ordersPaidDate;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersNotes()
	{
		return $this->ordersNotes;
	}

	/**
	 *
	 * @param $ordersNotes
	 */
	public function setOrdersNotes($ordersNotes)
	{
		$this->ordersNotes = $ordersNotes;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersTaxRate()
	{
		return $this->ordersTaxRate;
	}

	/**
	 *
	 * @param $ordersTaxRate
	 */
	public function setOrdersTaxRate($ordersTaxRate)
	{
		$this->ordersTaxRate = $ordersTaxRate;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersTaxStatusId()
	{
		return $this->ordersTaxStatusId;
	}

	/**
	 *
	 * @param $ordersTaxStatusId
	 */
	public function setOrdersTaxStatusId($ordersTaxStatusId)
	{
		$this->ordersTaxStatusId = $ordersTaxStatusId;
	}

	/**
	 *
	 * @return
	 */
	public function getOrdersStatusId()
	{
		return $this->ordersStatusId;
	}

	/**
	 *
	 * @param $ordersStatusId
	 */
	public function setOrdersStatusId($ordersStatusId)
	{
		$this->ordersStatusId = $ordersStatusId;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShipperId()
	{
	    return $this->shipperId;
	}

	/**
	 * 
	 * @param $shipperId
	 */
	public function setShipperId($shipperId)
	{
	    $this->shipperId = $shipperId;
	}
}

?>
