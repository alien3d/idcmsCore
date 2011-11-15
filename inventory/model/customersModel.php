<?php

require_once ("../../class/classValidation.php");

/**
 * this is customers model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package customers
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class CustomersModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $customersId;
	/**
	 * @var string
	 */
	private $customersCompany;
	/**
	 * @var string
	 */
	private $customersLastName;
	/**
	 * @var string
	 */
	private $customersFirstName;
	/**
	 * @var string
	 */
	private $customersEmail;
	/**
	 * @var int
	 */
	private $customersJobTitle;
	/**
	 * @var string
	 */
	private $customersBusinessPhone;
	/**
	 * @var string
	 */
	private $customersHomePhone;
	/**
	 * @var string
	 */
	private $customersMobilePhone;
	/**
	 * @var date
	 */
	private $customersBirthday;
	/**
	 * @var string
	 */
	private $customersFaxNum;
	/**
	 * @var string
	 */
	private $customersAddress;
	/**
	 * @var string
	 */
	private $customersCity;
	/**
	 * @var string
	 */
	private $customersState;
	/**
	 * @var string
	 */
	private $customersPostcode;
	/**
	 * @var string
	 */
	private $customersCountry;
	/**
	 * @var string
	 */
	private $customersWebPage;
	/**
	 * @var string
	 */
	private $customersNotes;
	/**
	 * @var string
	 */
	private $customersAttachments;




	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('customers');
		$this->setPrimaryKeyName('customersId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['customersId'])) {
			$this->setCustomersId($this->strict($_POST ['customersId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['customersCompany'])) {
			$this->setCustomersCompany($this->strict($_POST ['customersCompany'], 'string'));
		}
		if(isset($_POST['customersLastName'])){
			$this->setCustomersLastName($this->strict($_POST['customersLastName'],'string'));
		}
		if(isset($_POST['customersFirstName'])){
			$this->setCustomersFirstName($this->strict($_POST['customersFirstName'],'string'));
		}
		if(isset($_POST['customersEmail'])){
			$this->setCustomersEmail($this->strict($_POST['customersEmail'],'string'));
		}
		if(isset($_POST['customersJobTitle'])){
			$this->setCustomersJobTitle($this->strict($_POST['customersJobTitle'],'string'));
		}
		if(isset($_POST['customersBusinessPhone'])){
			$this->setCustomersBusinessPhone($this->strict($_POST['customersBusinessPhone'],'string'));
		}
		if(isset($_POST['customersMobilePhone'])){
			$this->setCustomersMobilePhone($this->strict($_POST['customersHomePhone'],'string'));
		}
		if(isset($_POST['customersFaxNum'])){
			$this->setCustomersFaxNum($this->strict($_POST['customersFaxNum'],'string'));
		}
		if(isset($_POST['customersAddress'])){
			$this->setCustomersAddress($this->strict($_POST['customersAddress'],'string'));
		}
		if(isset($_POST['customersCity'])){
			$this->setCustomersCity($this->strict($_POST['customersCity'],'string'));
		}
		if(isset($_POST['customersState'])){
			$this->setCustomersState($this->strict($_POST['customersState'],'string'));
		}
		if(isset($_POST['customersPostcode'])){
			$this->setCustomersPostcode($this->strict($_POST['customersPostcode'],'string'));
		}
		if(isset($_POST['customersCountry'])){
			$this->setCustomersCountry($this->strict($_POST['customersCountry'],'string'));
		}
		if(isset($_POST['customersWebPage'])){
			$this->setCustomersWebPage($this->strict($_POST['customersWebPage'],'string'));
		}
		if(isset($_POST['customersNotes'])){
			$this->setCustomersNotes($this->strict($_POST['customersNotes'],'string'));
		}
		if(isset($_POST['customersAttachments'])){
			$this->setCustomersCountry($this->strict($_POST['customersAttachments'],'string'));
		}
		if(isset($_POST['customersAttachments'])){
			$this->setCustomersAttachments($this->strict($_POST['customersAttachments'],'string'));
		}
		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['customersId'])) {
			$this->setTotal(count($_GET ['customersId']));
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
			if (isset($_GET ['customersId'])) {
				$this->setCustomersId($this->strict($_GET ['customersId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getCustomersId($i, 'array') . ",";
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
	 * Set Customers Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setCustomersId($value, $key, $type) {
		if ($type == 'single') {
			$this->customersId = $value;
		} else if ($type == 'array') {
			$this->customersId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setCustomersId ?"));
			exit();
		}
	}

	/**
	 * Return Customers Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getCustomersId($key, $type) {
		if ($type == 'single') {
			return $this->customersId;
		} else if ($type == 'array') {
			return $this->customersId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getCustomersId ?"));
			exit();
		}
	}


	public function getCustomersAddress()
	{
		return $this->customersAddress;
	}

	public function setCustomersAddress($customersAddress)
	{
		$this->customersAddress = $customersAddress;
	}

	public function getCustomersPostcode()
	{
		return $this->customersPostcode;
	}

	public function setCustomersPostcode($customersPostcode)
	{
		$this->customersPostcode = $customersPostcode;
	}

	public function getCustomersEmail()
	{
		return $this->customersEmail;
	}

	public function setCustomersEmail($customersEmail)
	{
		$this->customersEmail = $customersEmail;
	}

	public function getCustomersCompany()
	{
	    return $this->customersCompany;
	}

	public function setCustomersCompany($customersCompany)
	{
	    $this->customersCompany = $customersCompany;
	}

	public function getCustomersLastName()
	{
	    return $this->customersLastName;
	}

	public function setCustomersLastName($customersLastName)
	{
	    $this->customersLastName = $customersLastName;
	}

	public function getCustomersFirstName()
	{
	    return $this->customersFirstName;
	}

	public function setCustomersFirstName($customersFirstName)
	{
	    $this->customersFirstName = $customersFirstName;
	}

	public function getCustomersJobTitle()
	{
	    return $this->customersJobTitle;
	}

	public function setCustomersJobTitle($customersJobTitle)
	{
	    $this->customersJobTitle = $customersJobTitle;
	}

	public function getCustomersBusinessPhone()
	{
	    return $this->customersBusinessPhone;
	}

	public function setCustomersBusinessPhone($customersBusinessPhone)
	{
	    $this->customersBusinessPhone = $customersBusinessPhone;
	}

	public function getCustomersHomePhone()
	{
	    return $this->customersHomePhone;
	}

	public function setCustomersHomePhone($customersHomePhone)
	{
	    $this->customersHomePhone = $customersHomePhone;
	}

	public function getCustomersMobilePhone()
	{
	    return $this->customersMobilePhone;
	}

	public function setCustomersMobilePhone($customersMobilePhone)
	{
	    $this->customersMobilePhone = $customersMobilePhone;
	}

	public function getCustomersFaxNum()
	{
	    return $this->customersFaxNum;
	}

	public function setCustomersFaxNum($customersFaxNum)
	{
	    $this->customersFaxNum = $customersFaxNum;
	}

	public function getCustomersCity()
	{
	    return $this->customersCity;
	}

	public function setCustomersCity($customersCity)
	{
	    $this->customersCity = $customersCity;
	}

	public function getCustomersState()
	{
	    return $this->customersState;
	}

	public function setCustomersState($customersState)
	{
	    $this->customersState = $customersState;
	}

	public function getCustomersCountry()
	{
	    return $this->customersCountry;
	}

	public function setCustomersCountry($customersCountry)
	{
	    $this->customersCountry = $customersCountry;
	}

	public function getCustomersWebPage()
	{
	    return $this->customersWebPage;
	}

	public function setCustomersWebPage($customersWebPage)
	{
	    $this->customersWebPage = $customersWebPage;
	}

	public function getCustomersNotes()
	{
	    return $this->customersNotes;
	}

	public function setCustomersNotes($customersNotes)
	{
	    $this->customersNotes = $customersNotes;
	}

	public function getCustomersAttachments()
	{
	    return $this->customersAttachments;
	}

	public function setCustomersAttachments($customersAttachments)
	{
	    $this->customersAttachments = $customersAttachments;
	}
}

?>
