<?php

require_once ("../../class/classValidation.php");

/**
 * this is shippers model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package shippers
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ShippersModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $shippersId;
	/**
	 * @var string
	 */
	private $shippersCompany;
	/**
	 * @var string
	 */
	private $shippersLastName;
	/**
	 * @var string
	 */
	private $shippersFirstName;
	/**
	 * @var string
	 */
	private $shippersEmail;
	/**
	 * @var string
	 */
	private $shippersJobTitle;
	/**
	 * @var string
	 */
	private $shippersBusinessPhone;
	/**
	 * @var string
	 */
	private $shippersHomePhone;
	/**
	 * @var string
	 */
	private $shippersMobilePhone;
	/**
	 * @var string
	 */
	private $shippersFaxNum;
	/**
	 * @var string
	 */
	private $shippersAddress;
	/**
	 * @var string
	 */
	private $shippersCity;
	/**
	 * @var string
	 */
	private $shippersState;
	/**
	 * @var string
	 */
	private $shippersPostcode;
	/**
	 * @var string
	 */
	private $shippersCountry;
	/**
	 * @var string
	 */
	private $shippersWebPage;
	/**
	 * @var string
	 */
	private $shippersNotes;
	/**
	 * @var string
	 */
	private $shippersAttachments;

	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('shippers');
		$this->setPrimaryKeyName('shippersId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['shippersId'])) {
			$this->setShippersId($this->strict($_POST ['shippersId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['shippersCompany'])) {
			$this->setShippersCompany($this->strict($_POST ['shippersCompany'], 'string'));
		}
		if(isset($_POST['shippersLastName'])){
			$this->setShippersLastName($this->strict($_POST['shippersLastName'],'string'));
		}
		if(isset($_POST['shippersFirstName'])){
			$this->setShippersFirstName($this->strict($_POST['shippersFirstName'],'string'));
		}
		if(isset($_POST['shippersEmail'])){
			$this->setShippersEmail($this->strict($_POST['shippersEmail'],'string'));
		}
		if(isset($_POST['shippersJobTitle'])){
			$this->setShippersJobTitle($this->strict($_POST['shippersJobTitle'],'string'));
		}
		if(isset($_POST['shippersBusinessPhone'])){
			$this->setShippersBusinessPhone($this->strict($_POST['shippersBusinessPhone'],'string'));
		}
		if(isset($_POST['shippersHomePhone'])){
			$this->setShippersHomePhone($this->strict($_POST['shippersHomePhone'],'string'));
		}
		if(isset($_POST['shippersMobilePhone'])){
			$this->setShippersMobilePhone($this->strict($_POST['shippersMobilePhone'],'string'));
		}
		if(isset($_POST['shippersFaxNum'])){
			$this->setShippersFaxNum($this->strict($_POST['shippersFaxNum'],'string'));
		}
		if(isset($_POST['shippersAddress'])){
			$this->setShippersAddress($this->strict($_POST['shippersAddress'],'string'));
		}
		if(isset($_POST['shippersCity'])){
			$this->setShippersCity($this->strict($_POST['shippersCity'],'string'));
		}
		if(isset($_POST['shippersState'])){
			$this->setShippersState($this->strict($_POST['shippersState'],'string'));
		}
		if(isset($_POST['shippersPostcode'])){
			$this->setShippersPostcode($this->strict($_POST['shippersPostcode'],'string'));
		}
		if(isset($_POST['shippersCountry'])){
			$this->setShippersCountry($this->strict($_POST['shippersCountry'],'string'));
		}
		if(isset($_POST['shippersWebPage'])){
			$this->setShippersWebPage($this->strict($_POST['shippersWebPage'],'string'));
		}
		if(isset($_POST['shippersNotes'])){
			$this->setShippersNotes($this->strict($_POST['shippersNotes'],'string'));
		}
		if(isset($_POST['shippersAttachments'])){
			$this->setShippersAttachments($this->strict($_POST['shippersAttachments'],'string'));
		}
		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['shippersId'])) {
			$this->setTotal(count($_GET ['shippersId']));
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
			if (isset($_GET ['shippersId'])) {
				$this->setShippersId($this->strict($_GET ['shippersId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getShippersId($i, 'array') . ",";
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
	 * Set Shippers Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setShippersId($value, $key, $type) {
		if ($type == 'single') {
			$this->shippersId = $value;
		} else if ($type == 'array') {
			$this->shippersId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setShippersId ?"));
			exit();
		}
	}

	/**
	 * Return Shippers Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getShippersId($key, $type) {
		if ($type == 'single') {
			return $this->shippersId;
		} else if ($type == 'array') {
			return $this->shippersId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getShippersId ?"));
			exit();
		}
	}




	/**
	 * 
	 * @return 
	 */
	public function getShippersCompany()
	{
	    return $this->shippersCompany;
	}

	/**
	 * 
	 * @param $shippersCompany
	 */
	public function setShippersCompany($shippersCompany)
	{
	    $this->shippersCompany = $shippersCompany;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersLastName()
	{
	    return $this->shippersLastName;
	}

	/**
	 * 
	 * @param $shippersLastName
	 */
	public function setShippersLastName($shippersLastName)
	{
	    $this->shippersLastName = $shippersLastName;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersFirstName()
	{
	    return $this->shippersFirstName;
	}

	/**
	 * 
	 * @param $shippersFirstName
	 */
	public function setShippersFirstName($shippersFirstName)
	{
	    $this->shippersFirstName = $shippersFirstName;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersEmail()
	{
	    return $this->shippersEmail;
	}

	/**
	 * 
	 * @param $shippersEmail
	 */
	public function setShippersEmail($shippersEmail)
	{
	    $this->shippersEmail = $shippersEmail;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersJobTitle()
	{
	    return $this->shippersJobTitle;
	}

	/**
	 * 
	 * @param $shippersJobTitle
	 */
	public function setShippersJobTitle($shippersJobTitle)
	{
	    $this->shippersJobTitle = $shippersJobTitle;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersBusinessPhone()
	{
	    return $this->shippersBusinessPhone;
	}

	/**
	 * 
	 * @param $shippersBusinessPhone
	 */
	public function setShippersBusinessPhone($shippersBusinessPhone)
	{
	    $this->shippersBusinessPhone = $shippersBusinessPhone;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersHomePhone()
	{
	    return $this->shippersHomePhone;
	}

	/**
	 * 
	 * @param $shippersHomePhone
	 */
	public function setShippersHomePhone($shippersHomePhone)
	{
	    $this->shippersHomePhone = $shippersHomePhone;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersMobilePhone()
	{
	    return $this->shippersMobilePhone;
	}

	/**
	 * 
	 * @param $shippersMobilePhone
	 */
	public function setShippersMobilePhone($shippersMobilePhone)
	{
	    $this->shippersMobilePhone = $shippersMobilePhone;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersFaxNum()
	{
	    return $this->shippersFaxNum;
	}

	/**
	 * 
	 * @param $shippersFaxNum
	 */
	public function setShippersFaxNum($shippersFaxNum)
	{
	    $this->shippersFaxNum = $shippersFaxNum;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersAddress()
	{
	    return $this->shippersAddress;
	}

	/**
	 * 
	 * @param $shippersAddress
	 */
	public function setShippersAddress($shippersAddress)
	{
	    $this->shippersAddress = $shippersAddress;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersCity()
	{
	    return $this->shippersCity;
	}

	/**
	 * 
	 * @param $shippersCity
	 */
	public function setShippersCity($shippersCity)
	{
	    $this->shippersCity = $shippersCity;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersState()
	{
	    return $this->shippersState;
	}

	/**
	 * 
	 * @param $shippersState
	 */
	public function setShippersState($shippersState)
	{
	    $this->shippersState = $shippersState;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersPostcode()
	{
	    return $this->shippersPostcode;
	}

	/**
	 * 
	 * @param $shippersPostcode
	 */
	public function setShippersPostcode($shippersPostcode)
	{
	    $this->shippersPostcode = $shippersPostcode;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersCountry()
	{
	    return $this->shippersCountry;
	}

	/**
	 * 
	 * @param $shippersCountry
	 */
	public function setShippersCountry($shippersCountry)
	{
	    $this->shippersCountry = $shippersCountry;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersWebPage()
	{
	    return $this->shippersWebPage;
	}

	/**
	 * 
	 * @param $shippersWebPage
	 */
	public function setShippersWebPage($shippersWebPage)
	{
	    $this->shippersWebPage = $shippersWebPage;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersNotes()
	{
	    return $this->shippersNotes;
	}

	/**
	 * 
	 * @param $shippersNotes
	 */
	public function setShippersNotes($shippersNotes)
	{
	    $this->shippersNotes = $shippersNotes;
	}

	/**
	 * 
	 * @return 
	 */
	public function getShippersAttachments()
	{
	    return $this->shippersAttachments;
	}

	/**
	 * 
	 * @param $shippersAttachments
	 */
	public function setShippersAttachments($shippersAttachments)
	{
	    $this->shippersAttachments = $shippersAttachments;
	}
}

?>
