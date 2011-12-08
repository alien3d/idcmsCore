<?php

require_once ("../../class/classValidation.php");

/**
 * this is generalledgerforecast model file.This is to ensure strict setting enable for all variable enter to database
 *
 * @name IDCMS.
 * @version 2
 * @author hafizan
 * @package General Ledger
 * @subpackage Forecast
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class GeneralledgerforecastModel extends ValidationClass {

	/**
	 * @var int
	 */
	private $generalLedgerForecastId;
	/**
	* @var string
	*/
	private $documentNo;
	/**
	* @var string
	*/
	private $generalLedgerChartOfAccountDimensionId;
	/**
	* @var int
	*/
	private $generalLedgerForecastMonth;
	/**
	* @var int
	*/
	private $generalLedgerForecastYear;
	/**
	* @var float
	*/
	private $generalLedgerForecastAmount;

	/* (non-PHPdoc)
	 * @see ValidationClass::execute()
	 */

	public function execute() {
		/*
		 *  Basic Information Table
		 */
		$this->setTableName('generalledgerforecast');
		$this->setPrimaryKeyName('generalLedgerForecastId');
		/**
		 * All the $_POST enviroment.
		 */
		if (isset($_POST ['generalLedgerForecastId'])) {
			$this->setGeneralLedgerForecastId($this->strict($_POST ['generalLedgerForecastId'], 'numeric'), 0, 'single');
		}
		if (isset($_POST ['documentNo'])) {
			$this->setDocumentNo($this->strict($_POST ['documentNo'], 'string'));
		}
		if (isset($_POST ['generalLedgerChartOfAccountDimensionId'])) {
			$this->setGeneralLedgerChartAccountDimensionNo($this->strict($_POST ['generalLedgerChartOfAccountDimensionId'], 'string'));
		}
		if (isset($_POST ['generalLedgerForecastMonth'])) {
			$this->setGeneralLedgerForecastMonth($this->strict($_POST ['generalLedgerForecastMonth'], 'numeric'));
		}
		if (isset($_POST ['generalLedgerForecastYear'])) {
			$this->setGeneralLedgerForecastYear($this->strict($_POST ['generalLedgerForecastYear'], 'numeric'));
		}
		if (isset($_POST ['generalLedgerForecastAmount'])) {
			$this->setGeneralLedgerForecastAmount($this->strict($_POST ['generalLedgerForecastAmount'], 'float'));
		}
		
		/**
		 * All the $_GET enviroment.
		 */
		if (isset($_GET ['generalledgerforecastId'])) {
			$this->setTotal(count($_GET ['generalLedgerForecastId']));
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
			if (isset($_GET ['generalLedgerForecastId'])) {
				$this->setGeneralLedgerForecastId($this->strict($_GET ['generalLedgerForecastId'] [$i], 'numeric'), $i, 'array');
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
			$primaryKeyAll .= $this->getGeneralledgerforecastId($i, 'array') . ",";
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
	 * Set Generalledgerforecast Identification  Value
	 * @param int|array $value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 */
	public function setGeneralLedgerForecastId($value, $key, $type) {
		if ($type == 'single') {
			$this->generalLedgerForecastId = $value;
		} else if ($type == 'array') {
			$this->generalLedgerForecastId [$key] = $value;
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:setGeneralledgerforecastId ?"));
			exit();
		}
	}

	/**
	 * Return Generalledgerforecast Identification  Value
	 * @param array[int]int $key List Of Primary Key.
	 * @param array[int]string $type  List Of Type.0 As 'single' 1 As 'array'
	 * @return bool|array
	 */
	public function getGeneralLedgerForecastId($key, $type) {
		if ($type == 'single') {
			return $this->generalLedgerForecastId;
		} else if ($type == 'array') {
			return $this->generalLedgerForecastId [$key];
		} else {
			echo json_encode(array("success" => false, "message" => "Cannot Identifiy Type String Or Array:getGeneralledgerforecastId ?"));
			exit();
		}
	}




	/**
	 * 
	 * @return 
	 */
	public function getDocumentNo()
	{
	    return $this->documentNo;
	}

	/**
	 * 
	 * @param $documentNo
	 */
	public function setDocumentNo($documentNo)
	{
	    $this->documentNo = $documentNo;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerChartOfAccountDimensionId()
	{
	    return $this->generalLedgerChartOfAccountDimensionId;
	}

	/**
	 * 
	 * @param $generalLedgerChartOfAccountDimensionId
	 */
	public function setGeneralLedgerChartOfAccountDimensionId($generalLedgerChartOfAccountDimensionId)
	{
	    $this->generalLedgerChartOfAccountDimensionId = $generalLedgerChartOfAccountDimensionId;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerForecastMonth()
	{
	    return $this->generalLedgerForecastMonth;
	}

	/**
	 * 
	 * @param $generalLedgerForecastMonth
	 */
	public function setGeneralLedgerForecastMonth($generalLedgerForecastMonth)
	{
	    $this->generalLedgerForecastMonth = $generalLedgerForecastMonth;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerForecastYear()
	{
	    return $this->generalLedgerForecastYear;
	}

	/**
	 * 
	 * @param $generalLedgerForecastYear
	 */
	public function setGeneralLedgerForecastYear($generalLedgerForecastYear)
	{
	    $this->generalLedgerForecastYear = $generalLedgerForecastYear;
	}

	/**
	 * 
	 * @return 
	 */
	public function getGeneralLedgerForecastAmount()
	{
	    return $this->generalLedgerForecastAmount;
	}

	/**
	 * 
	 * @param $generalLedgerForecastAmount
	 */
	public function setGeneralLedgerForecastAmount($generalLedgerForecastAmount)
	{
	    $this->generalLedgerForecastAmount = $generalLedgerForecastAmount;
	}
}

?>
