<?php

require_once ("../../class/classValidation.php");

/**
 * this is membership model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package membership
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class MembershipModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $membershipId;


	/**
	 * @var float
	 */
	private $membershipSalary;
	/**
	 * @var date
	 */
	private $membershipRegisterDate;
	/**
	 * @var string
	 */
	private $membershipName;
	/**
	 * @var int
	 */
	private $membershipNumber;
	/**
	 * @var int
	 */
	private $staffNumber;
	/**
	 * @var string
	 */
	private $membershipDesignation;
	/**
	 * @var string
	 */
	private $membershipIC;
	/**
	 * @var date
	 */
	private $membershipBirthday;
	/**
	 * @var string
	 */
	private $membershipPhone;
	/**
	 * @var string
	 */
	private $membershipMobile;
	/**
	 * @var string
	 */
	private $membershipAddress;
	/**
	 * @var string
	 */
	private $membershipPostcode;
	/**
	 * @var string
	 */
	private $membershipExt;
	/**
	 * @var string
	 */
	private $membershipEmail;

	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('membership');
		$this->setPrimaryKeyName('membershipId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['membershipId'])) {
			$this->setMembershipId($this->strict($_POST ['membershipId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['membershipDesc'])) {
			$this->setMembershipDesc($this->strict($_POST ['membershipDesc'], 'memo'));
		}
		if(isset($_POST['membershipSalary'])){
			$this->setMembershipSalary($this->strict($_POST['membershipSalary'],'float'));
		}

		if(isset($_POST['membershipRegisterDate'])){
			$this->setMembershipRegisterDate ($this->strict($_POST['membershipRegisterDate'],'date'));
		}
		if(isset($_POST['membershipName'])){
			$this->setMembershipName($this->strict($_POST['membershipName'],'string'));
		}

		if(isset($_POST['membershipNumber'])){
			$this->setMembershipNumber($this->strict($_POST['membershipNumber'],'numeric'));
		}
		if(isset($_POST['staffNumber'])){
			$this->setStaffNumber($this->strict($_POST['staffNumber'],'numeric'));
		}
		if(isset($_POST['membershipDesignation'])){
			$this->setMembershipDesignation($this->strict($_POST['membershipDesignation'],'string'));
		}
		if(isset($_POST['membershipIC'])){
			$this->setMembershipIC($this->strict($_POST['membershipIC'],'string'));
		}
		if(isset($_POST['membershipBirthday'])){
			$this->setMembershipBirthday($this->strict($_POST['membershipBirthday'],'date'));
		}
		if(isset($_POST['membershipPhone'])){
			$this->setMembershipPhone($this->strict($_POST['membershipPhone'],'string'));
		}
		if(isset($_POST['membershipMobile'])){
			$this->setMembershipMobile($this->strict($_POST['membershipMobile'],'string'));
		}
		if(isset($_POST['membershipAddress'])){
			$this->setMembershipAddress($this->strict($_POST['membershipAddress'],'string'));
		}
		if(isset($_POST['membershipPostcode'])){
			$this->setMembershipPostcode($this->strict($_POST['membershipPostcode'],'string'));
		}
		if(isset($_POST['membershipExt'])){
			$this->setMembershipExt($this->strict($_POST['membershipExt'],'string'));
		}
		if(isset($_POST['membershipEmail'])){
			$this->setMembershipEmail($this->strict($_POST['membershipEmail'],'string'));
		}
		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['membershipId'])) {
			$this->setTotal(count($_GET ['membershipId']));
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
			if (isset($_GET ['membershipId'])) {
				$this->setMembershipId($this->strict($_GET ['membershipId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getMembershipId($i, 'array') . ",";
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
	 * Set Membership Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setMembershipId($value, $key, $type) {
		if ($type == 'single') {
			$this->membershipId = $value;
		} else if ($type == 'array') {
			$this->membershipId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setMembershipId ?"));
			exit();
		}
	}

	/**
	 * Return Membership Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getMembershipId($key, $type) {
		if ($type == 'single') {
			return $this->membershipId;
		} else if ($type == 'array') {
			return $this->membershipId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getMembershipId ?"));
			exit();
		}
	}




	public function getMembershipSalary()
	{
		return $this->membershipSalary;
	}

	public function setMembershipSalary($membershipSalary)
	{
		$this->membershipSalary = $membershipSalary;
	}

	public function getMembershipRegisterDate()
	{
		return $this->membershipRegisterDate;
	}

	public function setMembershipRegisterDate($membershipRegisterDate)
	{
		$this->membershipRegisterDate = $membershipRegisterDate;
	}

	public function getMembershipName()
	{
		return $this->membershipName;
	}

	public function setMembershipName($membershipName)
	{
		$this->membershipName = $membershipName;
	}

	public function getMembershipNumber()
	{
		return $this->membershipNumber;
	}

	public function setMembershipNumber($membershipNumber)
	{
		$this->membershipNumber = $membershipNumber;
	}

	public function getStaffNumber()
	{
		return $this->staffNumber;
	}

	public function setStaffNumber($staffNumber)
	{
		$this->staffNumber = $staffNumber;
	}

	public function getMembershipDesignation()
	{
		return $this->membershipDesignation;
	}

	public function setMembershipDesignation($membershipDesignation)
	{
		$this->membershipDesignation = $membershipDesignation;
	}

	public function getMembershipIC()
	{
		return $this->membershipIC;
	}

	public function setMembershipIC($membershipIC)
	{
		$this->membershipIC = $membershipIC;
	}

	public function getMembershipBirthday()
	{
		return $this->membershipBirthday;
	}

	public function setMembershipBirthday($membershipBirthday)
	{
		$this->membershipBirthday = $membershipBirthday;
	}

	public function getMembershipPhone()
	{
		return $this->membershipPhone;
	}

	public function setMembershipPhone($membershipPhone)
	{
		$this->membershipPhone = $membershipPhone;
	}

	public function getMembershipMobile()
	{
		return $this->membershipMobile;
	}

	public function setMembershipMobile($membershipMobile)
	{
		$this->membershipMobile = $membershipMobile;
	}

	public function getMembershipAddress()
	{
		return $this->membershipAddress;
	}

	public function setMembershipAddress($membershipAddress)
	{
		$this->membershipAddress = $membershipAddress;
	}

	public function getMembershipPostcode()
	{
		return $this->membershipPostcode;
	}

	public function setMembershipPostcode($membershipPostcode)
	{
		$this->membershipPostcode = $membershipPostcode;
	}

	public function getMembershipExt()
	{
		return $this->membershipExt;
	}

	public function setMembershipExt($membershipExt)
	{
		$this->membershipExt = $membershipExt;
	}

	public function getMembershipEmail()
	{
		return $this->membershipEmail;
	}

	public function setMembershipEmail($membershipEmail)
	{
		$this->membershipEmail = $membershipEmail;
	}
}

?>
