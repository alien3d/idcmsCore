<?php

require_once ("../../class/classValidation.php");

/**
 * this is generalLedgerForecastType model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package General Ledger
 * @subpackage Chart Of Account Type
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
       
class GeneralLedgerForecastTypeModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $generalLedgerForecastTypeId;
	/**
	 * @var string
	 */
	private $generalLedgerForecastTypeSequence;
	/**
	 * @var int
	 */
	private $generalLedgerForecastTypeCode;
	/**
	 * @var string
	 */
	private $generalLedgerForecastTypeDesc;


	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('generalLedgerForecastType');
		$this->setPrimaryKeyName('generalLedgerForecastTypeId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['generalLedgerForecastTypeId'])) {
			$this->setGeneralLedgerForecastTypeId($this->strict($_POST ['generalLedgerForecastTypeId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['generalLedgerForecastTypeSequence'])) {
			$this->setGeneralLedgerForecastTypeSequence($this->strict($_POST ['generalLedgerForecastTypeSequence'], 'string'));
		}
		if (isset($_POST ['generalLedgerForecastTypeCode'])) {
			$this->setGeneralLedgerForecastTypeCode($this->strict($_POST ['generalLedgerForecastTypeCode'], 'numeric'));
		}
		if (isset($_POST ['generalLedgerForecastTypeDesc'])) {
			$this->setGeneralLedgerForecastTypeDesc($this->strict($_POST ['generalLedgerForecastTypeDesc'], 'string'));
		}

		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['generalLedgerForecastTypeId'])) {
			$this->setTotal(count($_GET ['generalLedgerForecastTypeId']));
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
			if (isset($_GET ['generalLedgerForecastTypeId'])) {
				$this->setGeneralLedgerChartOfAccountId($this->strict($_GET ['generalLedgerForecastTypeId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getGeneralledgerId($i, 'array') . ",";
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
	 * Set Generalledger Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setGeneralLedgerForecastTypeId($value, $key, $type) {
		if ($type == 'single') {
			$this->generalLedgerForecastTypeId = $value;
		} else if ($type == 'array') {
			$this->generalLedgerForecastTypeId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setGeneralledgerId ?"));
			exit();
		}
	}

	/**
	 * Return Generalledger Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getGeneralLedgerForecastTypeId($key, $type) {
		if ($type == 'single') {
			return $this->generalLedgerForecastTypeId;
		} else if ($type == 'array') {
			return $this->generalLedgerForecastTypeId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getGeneralledgerId ?"));
			exit();
		}
	}



	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerForecastTypeSequence()
	{
	    return $this->generalLedgerForecastTypeSequence;
	}

	/**
	 * 
	 * @param $generalLedgerForecastTypeSequence
	 */
	public function setGeneralLedgerForecastTypeSequence($generalLedgerForecastTypeSequence)
	{
	    $this->generalLedgerForecastTypeSequence = $generalLedgerForecastTypeSequence;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerForecastTypeCode()
	{
	    return $this->generalLedgerForecastTypeCode;
	}

	/**
	 * 
	 * @param $generalLedgerForecastTypeCode
	 */
	public function setGeneralLedgerForecastTypeCode($generalLedgerForecastTypeCode)
	{
	    $this->generalLedgerForecastTypeCode = $generalLedgerForecastTypeCode;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerForecastTypeDesc()
	{
	    return $this->generalLedgerForecastTypeDesc;
	}

	/**
	 * 
	 * @param $generalLedgerForecastTypeDesc
	 */
	public function setGeneralLedgerForecastTypeDesc($generalLedgerForecastTypeDesc)
	{
	    $this->generalLedgerForecastTypeDesc = $generalLedgerForecastTypeDesc;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerForecastTypeSequenceDesc()
	{
	    return $this->generalLedgerForecastTypeSequenceDesc;
	}

	/**
	 * 
	 * @param $generalLedgerForecastTypeSequenceDesc
	 */
	public function setGeneralLedgerForecastTypeSequenceDesc($generalLedgerForecastTypeSequenceDesc)
	{
	    $this->generalLedgerForecastTypeSequenceDesc = $generalLedgerForecastTypeSequenceDesc;
	}
}

?>
