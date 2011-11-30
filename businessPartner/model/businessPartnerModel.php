<?php

require_once ("../../class/classValidation.php");

/**
 * this is businessPartner model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package businessPartner
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class BusinessPartnerModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $businessPartnerId;
	/**
	 * @var string
	 */
	private $businessPartnerCompany;
	/**
	 * @var string
	 */
	private $businessPartnerLastName;
	/**
	 * @var string
	 */
	private $businessPartnerFirstName;
	/**
	 * @var string
	 */
	private $businessPartnerEmail;
	/**
	 * @var int
	 */
	private $businessPartnerJobTitle;
	/**
	 * @var string
	 */
	private $businessPartnerBusinessPhone;
	/**
	 * @var string
	 */
	private $businessPartnerHomePhone;
	/**
	 * @var string
	 */
	private $businessPartnerMobilePhone;
	/**
	 * @var string
	 */
	private $businessPartnerFaxNum;
	/**
	 * @var string
	 */
	private $businessPartnerAddress;
	/**
	 * @var string
	 */
	private $businessPartnerCity;
	/**
	 * @var string
	 */
	private $businessPartnerState;
	/**
	 * @var string
	 */
	private $businessPartnerPostcode;
	/**
	 * @var string
	 */
	private $businessPartnerCountry;
	/**
	 * @var string
	 */
	private $businessPartnerWebPage;
	/**
	 * @var string
	 */
	private $businessPartnerNotes;
	/**
	 * @var string
	 */
	private $businessPartnerAttachments;
	/**
	* @var int
	*/
	private $businessPartnerCategoryId;



	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('businesspartner');
		$this->setPrimaryKeyName('businessPartnerId');
		$this->setFilterCharacter('businessPatnerCompany');
		$this->setFilterDate('businessPartner');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['businessPartnerId'])) {
			$this->setBusinessPartnerId($this->strict($_POST ['businessPartnerId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['businessPartnerCompany'])) {
			$this->setBusinessPartnerCompany($this->strict($_POST ['businessPartnerCompany'], 'string'));
		}
		if(isset($_POST['businessPartnerLastName'])){
			$this->setBusinessPartnerLastName($this->strict($_POST['businessPartnerLastName'],'string'));
		}
		if(isset($_POST['businessPartnerFirstName'])){
			$this->setBusinessPartnerFirstName($this->strict($_POST['businessPartnerFirstName'],'string'));
		}
		if(isset($_POST['businessPartnerEmail'])){
			$this->setBusinessPartnerEmail($this->strict($_POST['businessPartnerEmail'],'string'));
		}
		if(isset($_POST['businessPartnerJobTitle'])){
			$this->setBusinessPartnerJobTitle($this->strict($_POST['businessPartnerJobTitle'],'string'));
		}
		if(isset($_POST['businessPartnerBusinessPhone'])){
			$this->setBusinessPartnerBusinessPhone($this->strict($_POST['businessPartnerBusinessPhone'],'string'));
		}
		if(isset($_POST['businessPartnerMobilePhone'])){
			$this->setBusinessPartnerMobilePhone($this->strict($_POST['businessPartnerHomePhone'],'string'));
		}
		if(isset($_POST['businessPartnerFaxNum'])){
			$this->setBusinessPartnerFaxNum($this->strict($_POST['businessPartnerFaxNum'],'string'));
		}
		if(isset($_POST['businessPartnerAddress'])){
			$this->setBusinessPartnerAddress($this->strict($_POST['businessPartnerAddress'],'string'));
		}
		if(isset($_POST['businessPartnerCity'])){
			$this->setBusinessPartnerCity($this->strict($_POST['businessPartnerCity'],'string'));
		}
		if(isset($_POST['businessPartnerState'])){
			$this->setBusinessPartnerState($this->strict($_POST['businessPartnerState'],'string'));
		}
		if(isset($_POST['businessPartnerPostcode'])){
			$this->setBusinessPartnerPostcode($this->strict($_POST['businessPartnerPostcode'],'string'));
		}
		if(isset($_POST['businessPartnerCountry'])){
			$this->setBusinessPartnerCountry($this->strict($_POST['businessPartnerCountry'],'string'));
		}
		if(isset($_POST['businessPartnerWebPage'])){
			$this->setBusinessPartnerWebPage($this->strict($_POST['businessPartnerWebPage'],'string'));
		}
		if(isset($_POST['businessPartnerNotes'])){
			$this->setBusinessPartnerNotes($this->strict($_POST['businessPartnerNotes'],'string'));
		}
		if(isset($_POST['businessPartnerAttachments'])){
			$this->setBusinessPartnerCountry($this->strict($_POST['businessPartnerAttachments'],'string'));
		}
		if(isset($_POST['businessPartnerAttachments'])){
			$this->setBusinessPartnerAttachments($this->strict($_POST['businessPartnerAttachments'],'string'));
		}
		if(isset($_POST['businessPartnerCategoryId'])){
			$this->setBusinessPartnerCategoryId($this->strict($_POST['businessPartnerCategoryId'],'numeric'));
		}
		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['businessPartnerId'])) {
			$this->setTotal(count($_GET ['businessPartnerId']));
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
			if (isset($_GET ['businessPartnerId'])) {
				$this->setBusinessPartnerId($this->strict($_GET ['businessPartnerId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getBusinessPartnerId($i, 'array') . ",";
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
	 * Set BusinessPartner Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setBusinessPartnerId($value, $key, $type) {
		if ($type == 'single') {
			$this->businessPartnerId = $value;
		} else if ($type == 'array') {
			$this->businessPartnerId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setBusinessPartnerId ?"));
			exit();
		}
	}

	/**
	 * Return BusinessPartner Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getBusinessPartnerId($key, $type) {
		if ($type == 'single') {
			return $this->businessPartnerId;
		} else if ($type == 'array') {
			return $this->businessPartnerId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getBusinessPartnerId ?"));
			exit();
		}
	}


	public function getBusinessPartnerAddress()
	{
		return $this->businessPartnerAddress;
	}

	public function setBusinessPartnerAddress($businessPartnerAddress)
	{
		$this->businessPartnerAddress = $businessPartnerAddress;
	}

	public function getBusinessPartnerPostcode()
	{
		return $this->businessPartnerPostcode;
	}

	public function setBusinessPartnerPostcode($businessPartnerPostcode)
	{
		$this->businessPartnerPostcode = $businessPartnerPostcode;
	}

	public function getBusinessPartnerEmail()
	{
		return $this->businessPartnerEmail;
	}

	public function setBusinessPartnerEmail($businessPartnerEmail)
	{
		$this->businessPartnerEmail = $businessPartnerEmail;
	}

	public function getBusinessPartnerCompany()
	{
	    return $this->businessPartnerCompany;
	}

	public function setBusinessPartnerCompany($businessPartnerCompany)
	{
	    $this->businessPartnerCompany = $businessPartnerCompany;
	}

	public function getBusinessPartnerLastName()
	{
	    return $this->businessPartnerLastName;
	}

	public function setBusinessPartnerLastName($businessPartnerLastName)
	{
	    $this->businessPartnerLastName = $businessPartnerLastName;
	}

	public function getBusinessPartnerFirstName()
	{
	    return $this->businessPartnerFirstName;
	}

	public function setBusinessPartnerFirstName($businessPartnerFirstName)
	{
	    $this->businessPartnerFirstName = $businessPartnerFirstName;
	}

	public function getBusinessPartnerJobTitle()
	{
	    return $this->businessPartnerJobTitle;
	}

	public function setBusinessPartnerJobTitle($businessPartnerJobTitle)
	{
	    $this->businessPartnerJobTitle = $businessPartnerJobTitle;
	}

	public function getBusinessPartnerBusinessPhone()
	{
	    return $this->businessPartnerBusinessPhone;
	}

	public function setBusinessPartnerBusinessPhone($businessPartnerBusinessPhone)
	{
	    $this->businessPartnerBusinessPhone = $businessPartnerBusinessPhone;
	}

	public function getBusinessPartnerHomePhone()
	{
	    return $this->businessPartnerHomePhone;
	}

	public function setBusinessPartnerHomePhone($businessPartnerHomePhone)
	{
	    $this->businessPartnerHomePhone = $businessPartnerHomePhone;
	}

	public function getBusinessPartnerMobilePhone()
	{
	    return $this->businessPartnerMobilePhone;
	}

	public function setBusinessPartnerMobilePhone($businessPartnerMobilePhone)
	{
	    $this->businessPartnerMobilePhone = $businessPartnerMobilePhone;
	}

	public function getBusinessPartnerFaxNum()
	{
	    return $this->businessPartnerFaxNum;
	}

	public function setBusinessPartnerFaxNum($businessPartnerFaxNum)
	{
	    $this->businessPartnerFaxNum = $businessPartnerFaxNum;
	}

	public function getBusinessPartnerCity()
	{
	    return $this->businessPartnerCity;
	}

	public function setBusinessPartnerCity($businessPartnerCity)
	{
	    $this->businessPartnerCity = $businessPartnerCity;
	}

	public function getBusinessPartnerState()
	{
	    return $this->businessPartnerState;
	}

	public function setBusinessPartnerState($businessPartnerState)
	{
	    $this->businessPartnerState = $businessPartnerState;
	}

	public function getBusinessPartnerCountry()
	{
	    return $this->businessPartnerCountry;
	}

	public function setBusinessPartnerCountry($businessPartnerCountry)
	{
	    $this->businessPartnerCountry = $businessPartnerCountry;
	}

	public function getBusinessPartnerWebPage()
	{
	    return $this->businessPartnerWebPage;
	}

	public function setBusinessPartnerWebPage($businessPartnerWebPage)
	{
	    $this->businessPartnerWebPage = $businessPartnerWebPage;
	}

	public function getBusinessPartnerNotes()
	{
	    return $this->businessPartnerNotes;
	}

	public function setBusinessPartnerNotes($businessPartnerNotes)
	{
	    $this->businessPartnerNotes = $businessPartnerNotes;
	}

	public function getBusinessPartnerAttachments()
	{
	    return $this->businessPartnerAttachments;
	}

	public function setBusinessPartnerAttachments($businessPartnerAttachments)
	{
	    $this->businessPartnerAttachments = $businessPartnerAttachments;
	}

	/**
	 * 
	 * @return 
	 */
	public function getBusinessPartnerCategoryId()
	{
	    return $this->businessPartnerCategoryId;
	}

	/**
	 * 
	 * @param $businessPartnerCategoryId
	 */
	public function setBusinessPartnerCategoryId($businessPartnerCategoryId)
	{
	    $this->businessPartnerCategoryId = $businessPartnerCategoryId;
	}
}

?>
