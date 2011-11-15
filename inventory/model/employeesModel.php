<?php

require_once ("../../class/classValidation.php");

/**
 * this is Employees model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package Employees
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class EmployeesModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $employeesId;
	/**
	 * @var string
	 */
	private $employeesCompany;
	/**
	 * @var string
	 */
	private $employeesLastName;
	/**
	 * @var string
	 */
	private $employeesFirstName;
	/**
	 * @var string
	 */
	private $employeesEmail;
	/**
	 * @var string
	 */
	private $employeesJobTitle;
	/**
	 * @var string
	 */
	private $employeesBusinessPhone;
	/**
	 * @var string
	 */
	private $employeesHomePhone;
	/**
	 * @var string
	 */
	private $employeesMobilePhone;
	/**
	 * @var string
	 */
	private $employeesFaxNum;
	/**
	 * @var string
	 */
	private $employeesAddress;
	/**
	 * @var string
	 */
	private $employeesCity;
	/**
	 * @var string
	 */
	private $employeesState;
	/**
	 * @var string
	 */
	private $employeesPostCode;
	/**
	 * @var string
	 */
	private $employeesCountry;
	/**
	 * @var string
	 */
	private $employeesWebPage;
	/**
	 * @var string
	 */
	private $employeesNotes;
	/**
	 * @var string
	 */
	private $employeesAttachments;

	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('employees');
		$this->setPrimaryKeyName('employeesId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['employeesId'])) {
			$this->setEmployeesId($this->strict($_POST ['employeesId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['employeesCompany'])) {
			$this->setEmployeesCompany($this->strict($_POST ['employeesCompany'], 'string'));
		}
		if (isset($_POST ['employeesLastName'])) {
			$this->setEmployeesLastName($this->strict($_POST ['employeesLastName'], 'string'));
		}
		if (isset($_POST ['employeesFirstName'])) {
			$this->setEmployeesFirstName($this->strict($_POST ['employeesFirstName'], 'string'));
		}
		if (isset($_POST ['employeesEmail'])) {
			$this->setEmployeesEmail($this->strict($_POST ['employeesEmail'], 'string'));
		}
		if (isset($_POST ['employeesJobTitle'])) {
			$this->setEmployeesJobTitle($this->strict($_POST ['employeesJobTitle'], 'string'));
		}
		if (isset($_POST ['employeesBusinessPhone'])) {
			$this->setEmployeesBusinessPhone($this->strict($_POST ['employeesBusinessPhone'], 'string'));
		}
		if (isset($_POST ['employeesHomePhone'])) {
			$this->setEmployeesHomePhone($this->strict($_POST ['employeesHomePhone'], 'string'));
		}
		if (isset($_POST ['employeesMobilePhone'])) {
			$this->setEmployeesMobilePhone($this->strict($_POST ['employeesMobilePhone'], 'string'));
		}
		if (isset($_POST ['employeesFaxNum'])) {
			$this->setEmployeesFaxNum($this->strict($_POST ['employeesFaxNum'], 'string'));
		}
		if (isset($_POST ['employeesAddress'])) {
			$this->setEmployeesAddress($this->strict($_POST ['employeesAddress'], 'string'));
		}
		if (isset($_POST ['employeesCity'])) {
			$this->setEmployeesCity($this->strict($_POST ['employeesCity'], 'string'));
		}
		if (isset($_POST ['employeesState'])) {
			$this->setEmployeesState($this->strict($_POST ['employeesState'], 'string'));
		}
		if (isset($_POST ['employeesPostCode'])) {
			$this->setEmployeesPostCode($this->strict($_POST ['employeesPostCode'], 'string'));
		}
		if (isset($_POST ['employeesCountry'])) {
			$this->setEmployeesCountry($this->strict($_POST ['employeesCountry'], 'string'));
		}
		if (isset($_POST ['employeesWebPage'])) {
			$this->setEmployeesWebPage($this->strict($_POST ['employeesWebPage'], 'string'));
		}
		if (isset($_POST ['employeesNotes'])) {
			$this->setEmployeesNotes($this->strict($_POST ['employeesNotes'], 'string'));
		}
		if (isset($_POST ['employeesAttachments'])) {
			$this->setEmployeesAttachments($this->strict($_POST ['employeesAttachments'], 'string'));
		}

		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['employeesId'])) {
			$this->setTotal(count($_GET ['employeesId']));
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
			if (isset($_GET ['employeesId'])) {
				$this->setPaymentId($this->strict($_GET ['employeesId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getPaymentId($i, 'array') . ",";
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
	 * Set Payment Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setEmployeesId($value, $key, $type) {
		if ($type == 'single') {
			$this->employeesId = $value;
		} else if ($type == 'array') {
			$this->employeesId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setPaymentId ?"));
			exit();
		}
	}

	/**
	 * Return Payment Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getEmployeesId($key, $type) {
		if ($type == 'single') {
			return $this->employeesId;
		} else if ($type == 'array') {
			return $this->employeesId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getPaymentId ?"));
			exit();
		}
	}


	/**
	 * 
	 * @return 
	 */
	public function getEmployeesCompany()
	{
	    return $this->employeesCompany;
	}

	/**
	 * 
	 * @param $employeesCompany
	 */
	public function setEmployeesCompany($employeesCompany)
	{
	    $this->employeesCompany = $employeesCompany;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesLastName()
	{
	    return $this->employeesLastName;
	}

	/**
	 * 
	 * @param $employeesLastName
	 */
	public function setEmployeesLastName($employeesLastName)
	{
	    $this->employeesLastName = $employeesLastName;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesFirstName()
	{
	    return $this->employeesFirstName;
	}

	/**
	 * 
	 * @param $employeesFirstName
	 */
	public function setEmployeesFirstName($employeesFirstName)
	{
	    $this->employeesFirstName = $employeesFirstName;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesEmail()
	{
	    return $this->employeesEmail;
	}

	/**
	 * 
	 * @param $employeesEmail
	 */
	public function setEmployeesEmail($employeesEmail)
	{
	    $this->employeesEmail = $employeesEmail;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesJobTitle()
	{
	    return $this->employeesJobTitle;
	}

	/**
	 * 
	 * @param $employeesJobTitle
	 */
	public function setEmployeesJobTitle($employeesJobTitle)
	{
	    $this->employeesJobTitle = $employeesJobTitle;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesBusinessPhone()
	{
	    return $this->employeesBusinessPhone;
	}

	/**
	 * 
	 * @param $employeesBusinessPhone
	 */
	public function setEmployeesBusinessPhone($employeesBusinessPhone)
	{
	    $this->employeesBusinessPhone = $employeesBusinessPhone;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesHomePhone()
	{
	    return $this->employeesHomePhone;
	}

	/**
	 * 
	 * @param $employeesHomePhone
	 */
	public function setEmployeesHomePhone($employeesHomePhone)
	{
	    $this->employeesHomePhone = $employeesHomePhone;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesMobilePhone()
	{
	    return $this->employeesMobilePhone;
	}

	/**
	 * 
	 * @param $employeesMobilePhone
	 */
	public function setEmployeesMobilePhone($employeesMobilePhone)
	{
	    $this->employeesMobilePhone = $employeesMobilePhone;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesFaxNum()
	{
	    return $this->employeesFaxNum;
	}

	/**
	 * 
	 * @param $employeesFaxNum
	 */
	public function setEmployeesFaxNum($employeesFaxNum)
	{
	    $this->employeesFaxNum = $employeesFaxNum;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesAddress()
	{
	    return $this->employeesAddress;
	}

	/**
	 * 
	 * @param $employeesAddress
	 */
	public function setEmployeesAddress($employeesAddress)
	{
	    $this->employeesAddress = $employeesAddress;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesCity()
	{
	    return $this->employeesCity;
	}

	/**
	 * 
	 * @param $employeesCity
	 */
	public function setEmployeesCity($employeesCity)
	{
	    $this->employeesCity = $employeesCity;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesState()
	{
	    return $this->employeesState;
	}

	/**
	 * 
	 * @param $employeesState
	 */
	public function setEmployeesState($employeesState)
	{
	    $this->employeesState = $employeesState;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesPostCode()
	{
	    return $this->employeesPostCode;
	}

	/**
	 * 
	 * @param $employeesPostCode
	 */
	public function setEmployeesPostCode($employeesPostCode)
	{
	    $this->employeesPostCode = $employeesPostCode;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesCountry()
	{
	    return $this->employeesCountry;
	}

	/**
	 * 
	 * @param $employeesCountry
	 */
	public function setEmployeesCountry($employeesCountry)
	{
	    $this->employeesCountry = $employeesCountry;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesWebPage()
	{
	    return $this->employeesWebPage;
	}

	/**
	 * 
	 * @param $employeesWebPage
	 */
	public function setEmployeesWebPage($employeesWebPage)
	{
	    $this->employeesWebPage = $employeesWebPage;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesNotes()
	{
	    return $this->employeesNotes;
	}

	/**
	 * 
	 * @param $employeesNotes
	 */
	public function setEmployeesNotes($employeesNotes)
	{
	    $this->employeesNotes = $employeesNotes;
	}

	/**
	 * 
	 * @return 
	 */
	public function getEmployeesAttachments()
	{
	    return $this->employeesAttachments;
	}

	/**
	 * 
	 * @param $employeesAttachments
	 */
	public function setEmployeesAttachments($employeesAttachments)
	{
	    $this->employeesAttachments = $employeesAttachments;
	}
}

?>
