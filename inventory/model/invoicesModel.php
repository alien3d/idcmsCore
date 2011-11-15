<?php

require_once ("../../class/classValidation.php");

/**
 * this is invoices model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package invoices
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class InvoicesModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $invoicesId;
	/**
	 * @var int
	 */
	private $ordersId;
	/**
	 * @var date
	 */
	private $invoicesDate;
	/**
	 * @var date
	 */
	private $invoicesDueDate;
	/**
	 * @var decimal
	 */
	private $invoicesTax;
	/**
	 * @var decimal
	 */
	private $invoicesShipping;
	/**
	 * @var decimal
	 */
	private $invoicesAmtDue;


	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('invoices');
		$this->setPrimaryKeyName('invoicesId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['invoicesId'])) {
			$this->setInvoicesId($this->strict($_POST ['invoicesId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['ordersId'])) {
			$this->setOrdersId($this->strict($_POST ['ordersId'], 'float'));
		}

		if(isset($_POST['invoicesDate'])){
			$this->setInvoicesDate ($this->strict($_POST['invoicesDate'],'date'));
		}

		if(isset($_POST['invoicesDueDate'])){
			$this->setInvoicesDueDate ($this->strict($_POST['invoicesDueDate'],'date'));
		}

		if(isset($_POST['invoicesTax'])){
			$this->setInvoicesTax($this->strict($_POST['invoicesTax'],'date'));
		}

		if(isset($_POST['invoicesShipping'])){
			$this->setInvoicesShipping($this->strict($_POST['invoicesShipping'],'float'));
		}
		if(isset($_POST['invoicesAmtDue'])){
			$this->setInvoicesAmtDue($this->strict($_POST['invoicesAmtDue'],'float'));
		}

		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['invoicesId'])) {
			$this->setTotal(count($_GET ['invoicesId']));
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
			if (isset($_GET ['invoicesId'])) {
				$this->setInvoicesId($this->strict($_GET ['invoicesId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getInvoicesId($i, 'array') . ",";
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
	 * Set Invoices Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setInvoicesId($value, $key, $type) {
		if ($type == 'single') {
			$this->invoicesId = $value;
		} else if ($type == 'array') {
			$this->invoicesId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setInvoicesId ?"));
			exit();
		}
	}

	/**
	 * Return Invoices Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getInvoicesId($key, $type) {
		if ($type == 'single') {
			return $this->invoicesId;
		} else if ($type == 'array') {
			return $this->invoicesId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getInvoicesId ?"));
			exit();
		}
	}

	/**
	 * 
	 * @return 
	 */
	public function getInvoicesDate()
	{
	    return $this->invoicesDate;
	}

	/**
	 * 
	 * @param $invoicesDate
	 */
	public function setInvoicesDate($invoicesDate)
	{
	    $this->invoicesDate = $invoicesDate;
	}

	/**
	 * 
	 * @return 
	 */
	public function getInvoicesDueDate()
	{
	    return $this->invoicesDueDate;
	}

	/**
	 * 
	 * @param $invoicesDueDate
	 */
	public function setInvoicesDueDate($invoicesDueDate)
	{
	    $this->invoicesDueDate = $invoicesDueDate;
	}

	/**
	 * 
	 * @return 
	 */
	public function getInvoicesTax()
	{
	    return $this->invoicesTax;
	}

	/**
	 * 
	 * @param $invoicesTax
	 */
	public function setInvoicesTax($invoicesTax)
	{
	    $this->invoicesTax = $invoicesTax;
	}

	/**
	 * 
	 * @return 
	 */
	public function getInvoicesShipping()
	{
	    return $this->invoicesShipping;
	}

	/**
	 * 
	 * @param $invoicesShipping
	 */
	public function setInvoicesShipping($invoicesShipping)
	{
	    $this->invoicesShipping = $invoicesShipping;
	}

	/**
	 * 
	 * @return 
	 */
	public function getInvoicesAmtDue()
	{
	    return $this->invoicesAmtDue;
	}

	/**
	 * 
	 * @param $invoicesAmtDue
	 */
	public function setInvoicesAmtDue($invoicesAmtDue)
	{
	    $this->invoicesAmtDue = $invoicesAmtDue;
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
}

?>
