<?php

require_once ("../../class/classValidation.php");

/**
 * this is suppliers model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package suppliers
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class SuppliersModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $suppliersId;
	/**
	 * @var string
	 */
	private $suppliersCompany;
	/**
	 * @var string
	 */
	private $suppliersLastName;
	/**
	 * @var string
	 */
	private $suppliersFirstName;
	/**
	 * @var string
	 */
	private $suppliersEmail;
	/**
	 * @var string
	 */
	private $suppliersJobTitle;
	/**
	 * @var string
	 */
	private $suppliersBusinessPhone;
	/**
	 * @var string
	 */
	private $suppliersHomePhone;
	/**
	 * @var string
	 */
	private $suppliersMobilePhone;
	/**
	 * @var string
	 */
	private $suppliersFaxNum;
	/**
	 * @var string
	 */
	private $suppliersAddress;
	/**
	 * @var string
	 */
	private $suppliersCity;
	/**
	 * @var string
	 */
	private $suppliersState;
	/**
	 * @var string
	 */
	private $suppliersPostcode;
	/**
	 * @var string
	 */
	private $suppliersCountry;
	/**
	 * @var string
	 */
	private $suppliersWebPage;
	/**
	 * @var string
	 */
	private $suppliersNotes;
	/**
	 * @var string
	 */
	private $suppliersAttachments;
	

	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('suppliers');
		$this->setPrimaryKeyName('suppliersId');
		/**
		 * All the $_POST enviroment.
		 */
			if (isset($_POST ['suppliersId'])) {
			$this->setShippersId($this->strict($_POST ['suppliersId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['suppliersCompany'])) {
			$this->setShippersCompany($this->strict($_POST ['suppliersCompany'], 'string'));
		}
		if(isset($_POST['suppliersLastName'])){
			$this->setShippersLastName($this->strict($_POST['suppliersLastName'],'string'));
		}
		if(isset($_POST['suppliersFirstName'])){
			$this->setShippersFirstName($this->strict($_POST['suppliersFirstName'],'string'));
		}
		if(isset($_POST['suppliersEmail'])){
			$this->setShippersEmail($this->strict($_POST['suppliersEmail'],'string'));
		}
		if(isset($_POST['suppliersJobTitle'])){
			$this->setShippersJobTitle($this->strict($_POST['suppliersJobTitle'],'string'));
		}
		if(isset($_POST['suppliersBusinessPhone'])){
			$this->setShippersBusinessPhone($this->strict($_POST['suppliersBusinessPhone'],'string'));
		}
		if(isset($_POST['suppliersHomePhone'])){
			$this->setShippersHomePhone($this->strict($_POST['suppliersHomePhone'],'string'));
		}
		if(isset($_POST['suppliersMobilePhone'])){
			$this->setShippersMobilePhone($this->strict($_POST['suppliersMobilePhone'],'string'));
		}
		if(isset($_POST['suppliersFaxNum'])){
			$this->setShippersFaxNum($this->strict($_POST['suppliersFaxNum'],'string'));
		}
		if(isset($_POST['suppliersAddress'])){
			$this->setShippersAddress($this->strict($_POST['suppliersAddress'],'string'));
		}
		if(isset($_POST['suppliersCity'])){
			$this->setShippersCity($this->strict($_POST['suppliersCity'],'string'));
		}
		if(isset($_POST['suppliersState'])){
			$this->setShippersState($this->strict($_POST['suppliersState'],'string'));
		}
		if(isset($_POST['suppliersPostcode'])){
			$this->setShippersPostcode($this->strict($_POST['suppliersPostcode'],'string'));
		}
		if(isset($_POST['suppliersCountry'])){
			$this->setShippersCountry($this->strict($_POST['suppliersCountry'],'string'));
		}
		if(isset($_POST['suppliersWebPage'])){
			$this->setShippersWebPage($this->strict($_POST['suppliersWebPage'],'string'));
		}
		if(isset($_POST['suppliersNotes'])){
			$this->setShippersNotes($this->strict($_POST['suppliersNotes'],'string'));
		}
		if(isset($_POST['suppliersAttachments'])){
			$this->setShippersAttachments($this->strict($_POST['suppliersAttachments'],'string'));
		}
		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['suppliersId'])) {
			$this->setTotal(count($_GET ['suppliersId']));
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
			if (isset($_GET ['suppliersId'])) {
				$this->setSuppliersId($this->strict($_GET ['suppliersId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getSuppliersId($i, 'array') . ",";
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
	 * Set Suppliers Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setSuppliersId($value, $key, $type) {
		if ($type == 'single') {
			$this->suppliersId = $value;
		} else if ($type == 'array') {
			$this->suppliersId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setSuppliersId ?"));
			exit();
		}
	}

	/**
	 * Return Suppliers Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getSuppliersId($key, $type) {
		if ($type == 'single') {
			return $this->suppliersId;
		} else if ($type == 'array') {
			return $this->suppliersId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getSuppliersId ?"));
			exit();
		}
	}



	/**
	 * 
	 * @return 
	 */
	public function getSuppliersCompany()
	{
	    return $this->suppliersCompany;
	}

	/**
	 * 
	 * @param $suppliersCompany
	 */
	public function setSuppliersCompany($suppliersCompany)
	{
	    $this->suppliersCompany = $suppliersCompany;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersLastName()
	{
	    return $this->suppliersLastName;
	}

	/**
	 * 
	 * @param $suppliersLastName
	 */
	public function setSuppliersLastName($suppliersLastName)
	{
	    $this->suppliersLastName = $suppliersLastName;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersFirstName()
	{
	    return $this->suppliersFirstName;
	}

	/**
	 * 
	 * @param $suppliersFirstName
	 */
	public function setSuppliersFirstName($suppliersFirstName)
	{
	    $this->suppliersFirstName = $suppliersFirstName;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersEmail()
	{
	    return $this->suppliersEmail;
	}

	/**
	 * 
	 * @param $suppliersEmail
	 */
	public function setSuppliersEmail($suppliersEmail)
	{
	    $this->suppliersEmail = $suppliersEmail;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersJobTitle()
	{
	    return $this->suppliersJobTitle;
	}

	/**
	 * 
	 * @param $suppliersJobTitle
	 */
	public function setSuppliersJobTitle($suppliersJobTitle)
	{
	    $this->suppliersJobTitle = $suppliersJobTitle;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersBusinessPhone()
	{
	    return $this->suppliersBusinessPhone;
	}

	/**
	 * 
	 * @param $suppliersBusinessPhone
	 */
	public function setSuppliersBusinessPhone($suppliersBusinessPhone)
	{
	    $this->suppliersBusinessPhone = $suppliersBusinessPhone;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersHomePhone()
	{
	    return $this->suppliersHomePhone;
	}

	/**
	 * 
	 * @param $suppliersHomePhone
	 */
	public function setSuppliersHomePhone($suppliersHomePhone)
	{
	    $this->suppliersHomePhone = $suppliersHomePhone;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersMobilePhone()
	{
	    return $this->suppliersMobilePhone;
	}

	/**
	 * 
	 * @param $suppliersMobilePhone
	 */
	public function setSuppliersMobilePhone($suppliersMobilePhone)
	{
	    $this->suppliersMobilePhone = $suppliersMobilePhone;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersFaxNum()
	{
	    return $this->suppliersFaxNum;
	}

	/**
	 * 
	 * @param $suppliersFaxNum
	 */
	public function setSuppliersFaxNum($suppliersFaxNum)
	{
	    $this->suppliersFaxNum = $suppliersFaxNum;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersAddress()
	{
	    return $this->suppliersAddress;
	}

	/**
	 * 
	 * @param $suppliersAddress
	 */
	public function setSuppliersAddress($suppliersAddress)
	{
	    $this->suppliersAddress = $suppliersAddress;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersCity()
	{
	    return $this->suppliersCity;
	}

	/**
	 * 
	 * @param $suppliersCity
	 */
	public function setSuppliersCity($suppliersCity)
	{
	    $this->suppliersCity = $suppliersCity;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersState()
	{
	    return $this->suppliersState;
	}

	/**
	 * 
	 * @param $suppliersState
	 */
	public function setSuppliersState($suppliersState)
	{
	    $this->suppliersState = $suppliersState;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersPostcode()
	{
	    return $this->suppliersPostcode;
	}

	/**
	 * 
	 * @param $suppliersPostcode
	 */
	public function setSuppliersPostcode($suppliersPostcode)
	{
	    $this->suppliersPostcode = $suppliersPostcode;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersCountry()
	{
	    return $this->suppliersCountry;
	}

	/**
	 * 
	 * @param $suppliersCountry
	 */
	public function setSuppliersCountry($suppliersCountry)
	{
	    $this->suppliersCountry = $suppliersCountry;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersWebPage()
	{
	    return $this->suppliersWebPage;
	}

	/**
	 * 
	 * @param $suppliersWebPage
	 */
	public function setSuppliersWebPage($suppliersWebPage)
	{
	    $this->suppliersWebPage = $suppliersWebPage;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersNotes()
	{
	    return $this->suppliersNotes;
	}

	/**
	 * 
	 * @param $suppliersNotes
	 */
	public function setSuppliersNotes($suppliersNotes)
	{
	    $this->suppliersNotes = $suppliersNotes;
	}

	/**
	 * 
	 * @return 
	 */
	public function getSuppliersAttachments()
	{
	    return $this->suppliersAttachments;
	}

	/**
	 * 
	 * @param $suppliersAttachments
	 */
	public function setSuppliersAttachments($suppliersAttachments)
	{
	    $this->suppliersAttachments = $suppliersAttachments;
	}
}

?>
