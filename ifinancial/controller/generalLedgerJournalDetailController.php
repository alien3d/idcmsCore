<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/generalLedgerJournalDetailModel.php");

/**
 The general journal is where double entry bookkeeping entries are recorded by debiting one or more accounts and crediting another one or more accounts with the same total amount. The total amount debited and the total amount credited should always be equal, thereby ensuring the accounting equation is maintained.Depending on the business's accounting information system, specialized journals may be used in conjunction with the general journal for record-keeping. In such case, use of the general journal may be limited to non-routine and adjusting entries.
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package General Ledger
 * @subpackage Journal Detail
 * @link http://www.idcms.org
 * @link http://en.wikipedia.org/wiki/Journal_%28accounting%29
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class GeneralLedgerJournalDetailClass extends ConfigClass {

	/**
	 * Connection to the database
	 * @var string
	 */
	public $q;

	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string
	 */
	private $excel;

	/**
	 * Record Pagination
	 * @var string
	 */
	private $recordSet;

	/**
	 * Document Trail Audit.
	 * @var string
	 */
	private $documentTrail;

	/**
	 * Audit Row TRUE or False
	 * @var bool
	 */
	private $audit;

	/**
	 * Log Sql Statement TRUE or False
	 * @var string
	 */
	private $log;

	/**
	 * Model
	 * @var string
	 */
	public $model;

	/**
	 * Audit Filter
	 * @var string
	 */
	public $auditFilter;

	/**
	 * Audit Column
	 * @var string
	 */
	public $auditColumn;

	/**
	 * Duplicate Testing either the key of table same or have been created.
	 * @var bool
	 */
	public $duplicateTest;

	/**
	 * Class Loader
	 */
	function execute() {
		parent::__construct();

		// audit property
		$this->audit = 0;
		$this->log = 1;

		$this->model = new GeneralledgerjournaldetailModel ();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor();
		$this->q->leafId = $this->getLeafId();
		$this->q->staffId = $this->getStaffId();
		$this->q->fieldQuery = $this->getFieldQuery();
		$this->q->gridQuery = $this->getGridQuery();
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
		$this->q->log = $this->log;
		$this->q->audit = $this->audit;
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->systemString = new SystemString();
		$this->systemString->setVendor($this->getVendor());
		$this->systemString->setLeafId($this->getLeafId());
		$this->systemString->execute();

		$this->recordSet = new RecordSet ();
		$this->recordSet->setRequestDatabase($this->q->getFinancialDatabase());
		$this->recordSet->setTableName($this->model->getTableName());
		$this->recordSet->setPrimaryKeyName($this->model->getPrimaryKeyName());
		$this->recordSet->execute();

		$this->documentTrail = new DocumentTrailClass ();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->setStaffId($this->getStaffId());
		$this->documentTrail->setLeafId($this->getLeafId());
		$this->documentTrail->execute();

		$this->excel = new PHPExcel ();
	}

	/* (non-PHPdoc)
	 * @see config::create()
	 */

	public function create() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->create();
		if ($this->getVendor() == self::MYSQL) {

			$sql = "
			INSERT INTO `iFinancial`.`generalLedgerJournalDetail`
					(
						`iFinancial`.`generalLedgerJournalDetail`.`generalLedgerJournalId`,												
						`iFinancial`.`generalLedgerJournalDetail`.`generalLedgerChartOfAccountId`,
						`iFinancial`.`generalLedgerJournalDetail`.`countryCurrencyId`,
						`iFinancial`.`generalLedgerJournalDetail`.`generalLedgerJournalDetailAmount`,
						`iFinancial`.`generalLedgerJournalDetail`.`isDefault`,
						`iFinancial`.`generalLedgerJournalDetail`.`isNew`,													
						`iFinancial`.`generalLedgerJournalDetail`.`isDraft`,
						`iFinancial`.`generalLedgerJournalDetail`.`isUpdate`,													
						`iFinancial`.`generalLedgerJournalDetail`.`isDelete`,
						`iFinancial`.`generalLedgerJournalDetail`.`isActive`,													
						`iFinancial`.`generalLedgerJournalDetail`.`isApproved`,
						`iFinancial`.`generalLedgerJournalDetail`.`isReview`,                      		  	 				
						`iFinancial`.`generalLedgerJournalDetail`.`isPost`,
						`iFinancial`.`generalLedgerJournalDetail`.`executeBy`,												
						`iFinancial`.`generalLedgerJournalDetail`.`executeTime`
					)
			VALUES
					(
						'" . $this->model->getGeneralLedgerJournalId() . "',
						'" . $this->model->getGeneralLedgerChartOfAccountId() . "',
						'" . $this->model->getCountryCurrencyId() . "',
						'" . $this->model->getGeneralLedgerJournalDetailAmount() . "',
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			
						'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		
						'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		
						'" . $this->model->getIsApproved(0, 'single') . "',
             			'" . $this->model->getIsReview(0, 'single') . "',		
						'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',					
						" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			INSERT INTO [iFinancial].[generalLedgerJournalDetail]
					(
						[generalLedgerJournalId],												
						[generalLedgerChartOfAccountId],
						[countryCurrencyId],
						[generalLedgerJournalDetailAmount],
						[isDefault],
						[isNew],														
						[isDraft],
						[isUpdate],														
						[isDelete],
						[isActive],														
						[isApproved],
						[isReview],														
						[isPost],
						[executeBy],													
						[executeTime]
					)
			VALUES
					(
						'" . $this->model->getGeneralLedgerJournalId() . "',
						'" . $this->model->getGeneralLedgerChartOfAccountId() . "',
						'" . $this->model->getCountryCurrencyId() . "',
						'" . $this->model->getGeneralLedgerJournalDetailAmount() . "',
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',				
						'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',			
						'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',			
						'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',			
						'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',						
						 " . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::ORACLE) {

			$sql = "
			INSERT INTO	GENERALLEDGERJOURNALDETAIL
					(
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALID,												
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERCHARTOFACCOUNTID,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.COUNTRYCURRENCYID,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILAMOUNT,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDEFAULT,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISNEW,														
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDRAFT,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISUPDATE,													
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDELETE,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE,													
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISAPPROVED,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISREVIEW,													
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISPOST,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY,													
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getGeneralLedgerJournalId() . "',
						'" . $this->model->getGeneralLedgerChartOfAccountId() . "',
						'" . $this->model->getCountryCurrencyId() . "',
						'" . $this->model->getGeneralLedgerJournalDetailAmount() . "',
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			
						'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		
						'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		
						'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		
						'" . $this->model->getIsPost(0, 'single') . "',						
						'" . $this->model->getExecuteBy() . "',					
						" . $this->model->getExecuteTime() . "
					)";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			INSERT INTO	GENERALLEDGERJOURNALDETAIL
					(
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALID,												
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERCHARTOFACCOUNTID,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.COUNTRYCURRENCYID,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILAMOUNT,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDEFAULT,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISNEW,														
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDRAFT,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISUPDATE,													
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDELETE,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE,													
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISAPPROVED,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISREVIEW,													
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISPOST,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY,													
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getGeneralLedgerJournalId() . "',
						'" . $this->model->getGeneralLedgerChartOfAccountId() . "',
						'" . $this->model->getCountryCurrencyId() . "',
						'" . $this->model->getGeneralLedgerJournalDetailAmount() . "',
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			
						'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		
						'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		
						'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		
						'" . $this->model->getIsPost(0, 'single') . "',						
						'" . $this->model->getExecuteBy() . "',					
						" . $this->model->getExecuteTime() . "
					)";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			INSERT INTO	GENERALLEDGERJOURNALDETAIL
					(
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALID,												
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERCHARTOFACCOUNTID,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.COUNTRYCURRENCYID,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILAMOUNT,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDEFAULT,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISNEW,														
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDRAFT,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISUPDATE,													
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDELETE,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE,													
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISAPPROVED,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISREVIEW,													
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISPOST,
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY,													
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getGeneralLedgerJournalId() . "',
						'" . $this->model->getGeneralLedgerChartOfAccountId() . "',
						'" . $this->model->getCountryCurrencyId() . "',
						'" . $this->model->getGeneralLedgerJournalDetailAmount() . "',
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			
						'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		
						'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		
						'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		
						'" . $this->model->getIsPost(0, 'single') . "',						
						'" . $this->model->getExecuteBy() . "',					
						" . $this->model->getExecuteTime() . "
					)";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}

		$this->q->create($sql);
		$generalLedgerJournalDetailId = $this->q->lastInsertId();
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}

		$this->q->commit();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array("success" => true,
			      "message" => $this->systemString->getCreateMessage(), 
			      "generalLedgerJournalDetailId" => $generalLedgerJournalDetailId,
        		  "time"=>$time));
		exit();
	}

	/* (non-PHPdoc)
	 * @see config::read()
	 */

	public function read() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->isAdmin == 0) {
			if ($this->q->vendor == self::MYSQL) {
				$this->auditFilter = "	`iFinancial`.`generalLedgerJournalDetail`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[iFinancial].[generalLedgerJournalDetail].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE	=	1	";
			} else if ($this->q->vendor == self::DB2) {
				$this->auditFilter = "	IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE	=	1	";
			} else if ($this->q->vendor == self::POSTGRESS) {
				$this->auditFilter = "	IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE	=	1	";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}
		} else if ($this->isAdmin == 1) {
			if ($this->getVendor() == self::MYSQL) {
				$this->auditFilter = "	1	=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	1	=	1 	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	1	=	1 	";
			} else if ($this->q->vendor == self::DB2) {
				$this->auditFilter = "	1	=	1 	";
			} else if ($this->q->vendor == self::POSTGRESS) {
				$this->auditFilter = "	1	=	1 	";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}
		}
		//UTF8
		$items = array();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT		`generalLedgerJournalDetail`.`generalLedgerJournalDetailId`,`generalLedgerJournalDetail`.`generalLedgerJournalId`,`generalLedgerJournalDetail`.`generalLedgerChartOfAccountId`,`generalLedgerJournalDetail`.`countryCurrencyId`,`generalLedgerJournalDetail`.`generalLedgerJournalDetailAmount`,
						`generalLedgerJournalDetail`.`isDefault`,
						`generalLedgerJournalDetail`.`isNew`,
						`generalLedgerJournalDetail`.`isDraft`,
						`generalLedgerJournalDetail`.`isUpdate`,
						`generalLedgerJournalDetail`.`isDelete`,
						`generalLedgerJournalDetail`.`isActive`,
						`generalLedgerJournalDetail`.`isApproved`,
						`generalLedgerJournalDetail`.`isReview`,
						`generalLedgerJournalDetail`.`isPost`,
						`generalLedgerJournalDetail`.`executeBy`,
						`generalLedgerJournalDetail`.`executeTime`,
						`staff`.`staffName`
			FROM 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournalDetail`
			JOIN	`".$this->q->getManagementDatabase()."`.`staff`
			ON		`generalLedgerJournalDetail`.`executeBy` = `iManagement`.`staff`.`staffId`
			WHERE 	 " . $this->auditFilter;
			if ($this->model->getGeneralLedgerJournalDetailId(0, 'single')) {
				$sql .= " AND `" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`='" . $this->model->getGeneralLedgerJournalDetailId(0, 'single') . "'";
			}
			if ($this->model->getGeneralLedgerJournalId(0, 'single')) {
				$sql .= " AND `" . $this->model->getTableName() . "`.`generalLedgerJournalId`='" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			}
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT		[iFinancial].[generalLedgerJournalDetail].[generalLedgerJournalDetailId],
						[iFinancial].[generalLedgerJournalDetail].[generalLedgerJournalId],
						[iFinancial].[generalLedgerJournalDetail].[generalLedgerChartOfAccountId],
						[iFinancial].[generalLedgerJournalDetail].[gAmount],
						[iFinancial].[generalLedgerJournalDetail].[isDefault],
						[iFinancial].[generalLedgerJournalDetail].[isNew],
						[iFinancial].[generalLedgerJournalDetail].[isDraft],
						[iFinancial].[generalLedgerJournalDetail].[isUpdate],
						[iFinancial].[generalLedgerJournalDetail].[isDelete],
						[iFinancial].[generalLedgerJournalDetail].[isActive],
						[iFinancial].[generalLedgerJournalDetail].[isApproved],
						[iFinancial].[iFinancial].[generalLedgerJournalDetail].[isReview],
						[iFinancial].[generalLedgerJournalDetail].[isPost],
						[iFinancial].[generalLedgerJournalDetail].[executeBy],
						[iFinancial].[generalLedgerJournalDetail].[executeTime],
						[iManagement].[staff].[staffName]
			FROM 	[iFinancial].[generalLedgerJournalDetail]
			JOIN	[iManagement].[staff]
			ON		[iFinancial].[generalLedgerJournalDetail].[executeBy] = [iManagement].[staff].[staffId]
			WHERE 	" . $this->auditFilter;
			if ($this->model->getGeneralLedgerJournalId(0, 'single')) {
				$sql .= " AND [iFinancial].[" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]='" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT		IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILID   		 	AS 	\"generalLedgerJournalDetailId\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALID 				AS 	\"generalLedgerJournalId\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERCHARTOFACCOUNTID 			AS 	\"generalLedgerChartOfAccountId\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILAMOUNT 			AS 	\"gAmount\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDEFAULT    			AS	\"isDefault\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISNEW		  			AS	\"isNew\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDRAFT	  				AS	\"isDraft\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISUPDATE     			AS	\"isUpdate\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDELETE	  			AS	\"isDelete\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE	  			AS	\"isActive\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISAPPROVED   			AS	\"isApproved\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISREVIEW	  			AS	\"isReview\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISPOST  	  			AS	\"isPost\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY    			AS	\"executeBy\",
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTETIME  			AS	\"executeTime\",
						IMANAGEMENT.STAFF.STAFFNAME		  			AS	\"staffName\"	
			FROM 		IFINANCIAL.GENERALLEDGERJOURNALDETAIL
			JOIN		IMANAGEMENT.STAFF
			ON			IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY 	  	=	IMANAGEMENT.STAFF.STAFFID
			WHERE 	" . $this->auditFilter;
			if ($this->model->getGeneralLedgerJournalId(0, 'single')) {
				$sql .= " AND " . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "='" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			}
		} else if ($this->q->vendor == self::DB2) {

		} else if ($this->q->vendor == self::POSTGRESS) {

		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		/**
		 * filter column based on first character
		 */
		if($this->getCharacterQuery()){
			if($this->q->vendor==self::MYSQL){
				$sql.=" AND `".$this->model->getTableName()."`.`".$this->model->getFilterCharacter()."` like '".$this->getCharacterQuery()."%'";
			} else if($this->q->vendor==self::MSSQL){
				$sql.=" AND [".$this->model->getTableName()."].[".$this->model->getFilterCharacter()."] like '".$this->getCharacterQuery()."%'";
			} else if ($this->q->vendor==self::ORACLE){
				$sql.=" AND ".strtoupper($this->model->getTableName()).".".strtoupper($this->model->getFilterCharacter())." = '".$this->getCharacterQuery()."'";
			} else if ($this->q->vendor==self::DB2){
				$sql.=" AND ".strtoupper($this->model->getTableName()).".".strtoupper($this->model->getFilterCharacter())." = '".$this->getCharacterQuery()."'";
			} else if ($this->q->vendor==self::POSTGRESS){
				$sql.=" AND ".strtoupper($this->model->getTableName()).".".strtoupper($this->model->getFilterCharacter())." = '".$this->getCharacterQuery()."'";
			}
		}
		/**
		 * filter column based on Range Of Date
		 * Example Day,Week,Month,Year
		 */
		if($this->getDateRangeStartQuery()){
			$sql.=$this->q->dateFilter($sql, $this->model->getTableName(),$this->model->getFilterDate(),$this->getDateRangeStartQuery(),$this->getDateRangeEndQuery(),$this->getDateRangeType());
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array('generalLedgerJournalDetailId');
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array('generalLedgerJournalDetail');
		if ($this->getFieldQuery()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= $this->q->quickSearch($tableArray, $filterArray);
			} else if ($this->getVendor() == self::MSSQL) {
				$tempSql = $this->q->quickSearch($tableArray, $filterArray);
				$sql .= $tempSql;
			} else if ($this->getVendor() == self::ORACLE) {
				$tempSql = $this->q->quickSearch($tableArray, $filterArray);
				$sql .= $tempSql;
			} else if ($this->getVendor() == self::DB2) {
				$sql .= $this->q->quickSearch($tableArray, $filterArray);
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql .= $this->q->quickSearch($tableArray, $filterArray);
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}
		}
		/**
		 * Extjs filtering mode
		 */
		if ($this->getGridQuery()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= $this->q->searching();
			} else if ($this->getVendor() == self::MSSQL) {
				$tempSql2 = $this->q->searching();
				$sql .= $tempSql2;
			} else if ($this->getVendor() == self::ORACLE) {
				$tempSql2 = $this->q->searching();
				$sql .= $tempSql2;
			} else if ($this->getVendor() == self::DB2) {
				$sql .= $this->q->searching();
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql .= $this->q->searching();
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}
		}
		// optional debugger.uncomment if wanted to used
		//if ($this->q->execute == 'fail') {
		//	echo json_encode(array(
		//   "success" => false,
		//   "message" => $this->q->realEscapeString($sql)
		//	));
		//	exit();
		//}
		// end of optional debugger
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$total = $this->q->numberRows();
		if ($this->getOrder() && $this->getSortField()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql .= "	ORDER BY [iFinancial].[" . $this->getSortField() . "] " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql .= "	ORDER BY IFINANCIAL." . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
			} else if ($this->getVendor() == self::DB2) {
				$sql .= "	ORDER BY IFINANCIAL." . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql .= "	ORDER BY IFINANCIAL." . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}
		}
		$_SESSION ['sql'] = $sql; // push to session so can make report via excel and pdf
		$_SESSION ['start'] = $this->getStart();
		$_SESSION ['limit'] = $this->getLimit();

		if ($this->getStart() && $this->getLimit()) {
			// only mysql have limit
			if ($this->getVendor() == self::MYSQL) {
				$sql .= " LIMIT  " . $this->getStart() . "," . $this->getLimit() . " ";
			} else if ($this->getVendor() == self::MSSQL) {
				/**
				 * Sql Server and Oracle used row_number
				 * Parameterize Query We don't support
				 */
				/**
				 * Only On Sql Server Denali
				 * select * from Production.Product order by name asc
				 * offset 10 rows fetch first 10 rows only
				 *
				 */
				$sql = "
							WITH [generalLedgerJournalDetailDerived] AS
							(
								SELECT 		[iFinancial].[generalLedgerJournalDetail].[generalLedgerJournalDetailId],
											[iFinancial].[generalLedgerJournalDetail].[generalLedgerJournalId],
											[iFinancial].[generalLedgerJournalDetail].[generalLedgerChartOfAccountId],
											[iFinancial].[generalLedgerJournalDetail].[gAmount],
											[iFinancial].[generalLedgerJournalDetail].[isDefault],
											[iFinancial].[generalLedgerJournalDetail].[isNew],
											[iFinancial].[generalLedgerJournalDetail].[isDraft],
											[iFinancial].[generalLedgerJournalDetail].[isUpdate],
											[iFinancial].[generalLedgerJournalDetail].[isDelete],
											[iFinancial].[generalLedgerJournalDetail].[isApproved],
											[iFinancial].[generalLedgerJournalDetail].[isReview],
											[iFinancial].[generalLedgerJournalDetail].[isPost],
											[iFinancial].[generalLedgerJournalDetail].[executeBy],
											[iFinancial].[generalLedgerJournalDetail].[executeTime],
											[iManagement].[staff].[staffName],
								ROW_NUMBER() OVER (ORDER BY [iFinancial].[generalLedgerJournalDetail].[generalLedgerJournalDetailId]) AS 'RowNumber'
								FROM 	[iFinancial].[generalLedgerJournalDetail]
								JOIN		[iManagement].[staff]
								ON		[iFinancial].[generalLedgerJournalDetail].[executeBy] = [iManagement].[staff].[staffId]
								WHERE " . $this->auditFilter . $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[generalLedgerJournalDetailDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . ($this->getStart() + 1) . "
							AND 			" . ($this->getStart() + $this->getLimit()) . ";";
			} else if ($this->getVendor() == self::ORACLE) {
				/**
				 * Oracle using derived table also
				 */
				$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
								SELECT	IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILID   		AS 	\"generalLedgerJournalDetailId\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALID 			AS 	\"generalLedgerJournalId\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERCHARTOFACCOUNTID 		AS 	\"generalLedgerChartOfAccountId\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILAMOUNT 		AS 	\"gAmount\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDEFAULT    		AS	\"isDefault\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISNEW		  		AS	\"isNew\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDRAFT	 			AS	\"isDraft\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISUPDATE     		AS	\"isUpdate\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDELETE	  		AS	\"isDelete\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE	  		AS	\"isActive\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISAPPROVED   		AS	\"isApproved\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISREVIEW	  		AS 	\"isReview\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISPOST		  		AS	\"isPost\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY    		AS	\"executeBy\",
										IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTETIME  		AS	\"executeTime\",
										STAFF.STAFFNAME		  		AS	\"staffName\"	
								FROM 	IFINANCIAL.GENERALLEDGERJOURNALDETAIL
								JOIN	STAFF
								ON		IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY 	  	=	STAFF.STAFFID
								WHERE 	" . $this->auditFilter . $tempSql . $tempSql2 . "
								 ) a
						where rownum <= '" . ($this->getStart() + $this->getLimit()) . "' )
						where r >=  '" . ($this->getStart() + 1) . "'";
			} else if ($this->getVendor() == self::DB2) {
				/*
				 * Old Version db2.same as oracle and microsoft sql server
				 * SELECT * FROM (
				 SELECT
				 ROW_NUMBER() OVER (ORDER BY ID_USER ASC) AS ROWNUM,
				 ID_EMPLOYEE, FIRSTNAME, LASTNAME
				 FROM EMPLOYEE
				 WHERE FIRSTNAME LIKE 'DEL%'
				 )  AS A WHERE A.rownum
				 BETWEEN 1 AND 25 */

				$sql .= " LIMIT  " . $this->getStart() . " AND " . $this->getLimit() . " ";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql .= " LIMIT  " . $this->getStart() . " OFFSET " . $this->getLimit() . " ";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}
		}

		/*
		 *  Only Execute One Query
		 */
		if (!($this->model->getGeneralLedgerJournalDetailId(0, 'single'))) {
			$this->q->read($sql);
			if ($this->q->execute == 'fail') {
				echo json_encode(array("success" => false, "message" => $this->q->responce));
				exit();
			}
		}
		$items = array();
		while (($row = $this->q->fetchAssoc()) == TRUE) {
			$items [] = $row;
		}
		if ($this->model->getGeneralLedgerJournalDetailId(0, 'single')) {
			$json_encode = json_encode(
			array('success' => true, 
			      'total' => $total, 
			      'message' =>  $this->systemString->getReadMessage(), 
			      
			      'firstRecord' => $this->recordSet->firstRecord('value'), 
			      'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getGeneralLedgerJournalId(0, 'single')), 
			      'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getGeneralLedgerJournalId(0, 'single')), 
			      'lastRecord' => $this->recordSet->lastRecord('value'),
				  'data' => $items ));
			$json_encode = str_replace("[", "", $json_encode);
			$json_encode = str_replace("]", "", $json_encode);
			echo $json_encode;
		} else {
			if (count($items) == 0) {
				$items = '';
			}
			echo json_encode(array('success' => true, 'total' => $total, 'message' =>  $this->systemString->getReadMessage(), 'datas' => $items));
			exit();
		}
	}

	/* (non-PHPdoc)
	 * @see config::update()
	 */

	function update() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
			if ($this->q->execute == 'fail') {
				echo json_encode(array("success" => false, "message" => $this->q->responce));
				exit();
			}
		}
		$this->q->start();
		$this->model->update();
		// before updating check the id exist or not . if exist continue to update else warning the user
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT	`iFinancial`.`" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`
			FROM 	`iFinancial`.`" . $this->model->getTableName() . "`
			WHERE  	`iFinancial`.`" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[iFinancial].[" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[iFinancial].[" . $this->model->getTableName() . "]
			WHERE  	[iFinancial].[" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	IFINANCIAL." . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	IFINANCIAL." . strtoupper($this->model->getTableName()) . "
			WHERE  	IFINANCIAL." . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	IFINANCIAL." . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	IFINANCIAL." . strtoupper($this->model->getTableName()) . "
			WHERE  	IFINANCIAL." . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	IFINANCIAL." . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	IFINANCIAL." . strtoupper($this->model->getTableName()) . "
			WHERE  	IFINANCIAL." . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		$result = $this->q->fast($sql);
		$total = $this->q->numberRows($result, $sql);
		if ($total == 0) {
			echo json_encode(array("success" => false, "message" => $this->systemString->getRecordNotFoundMessage()));
			exit();
		} else {
			if ($this->getVendor() == self::MYSQL) {
				$sql = "
				UPDATE		`iFinancial`.`generalLedgerJournalDetail`
				SET 		`iFinancial`.`generalLedgerJournalDetail`.`generalLedgerJournalId`				=	'" . $this->model->getGeneralLedgerJournalId() . "',
							`iFinancial`.`generalLedgerJournalDetail`.`generalLedgerChartOfAccountId`		=	'" . $this->model->getGeneralLedgerChartOfAccountId() . "',
							`iFinancial`.`generalLedgerJournalDetail`.`countryCurrencyId`					=	'" . $this->model->getCountryCurrencyId() . "',
							`iFinancial`.`generalLedgerJournalDetail`.`generalLedgerJournalDetailAmount`	=	'" . $this->model->getGeneralLedgerJournalDetailAmount() . "',
							`iFinancial`.`generalLedgerJournalDetail`.`isDefault`							=	'" . $this->model->getIsDefault(0, 'single') . "',
							`iFinancial`.`generalLedgerJournalDetail`.`isNew`								=	'" . $this->model->getIsNew(0, 'single') . "',
							`iFinancial`.`generalLedgerJournalDetail`.`isDraft`								=	'" . $this->model->getIsDraft(0, 'single') . "',
							`iFinancial`.`generalLedgerJournalDetail`.`isUpdate`							=	'" . $this->model->getIsUpdate(0, 'single') . "',
							`iFinancial`.`generalLedgerJournalDetail`.`isDelete`							=	'" . $this->model->getIsDelete(0, 'single') . "',
							`iFinancial`.`generalLedgerJournalDetail`.`isActive`							=	'" . $this->model->getIsActive(0, 'single') . "',
							`iFinancial`.`generalLedgerJournalDetail`.`isApproved`							=	'" . $this->model->getIsApproved(0, 'single') . "',
							`iFinancial`.`generalLedgerJournalDetail`.`isReview`							=	'" . $this->model->getIsReview(0, 'single') . "',
							`iFinancial`.`generalLedgerJournalDetail`.`isPost`								=	'" . $this->model->getIsPost(0, 'single') . "',
							`iFinancial`.`generalLedgerJournalDetail`.`executeBy`							=	'" . $this->model->getExecuteBy() . "',
							`iFinancial`.`generalLedgerJournalDetail`.`executeTime`							=	" . $this->model->getExecuteTime() . "
				WHERE 		`iFinancial`.`generalLedgerJournalDetail`.`generalLedgerJournalDetailId`		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
				UPDATE 		[iFinancial].[generalLedgerJournalDetail]
				SET 		[iFinancial].[generalLedgerJournalDetail].[generalLedgerJournalId]				=	'" . $this->model->getGeneralLedgerJournalId() . "',
							[iFinancial].[generalLedgerJournalDetail].[generalLedgerChartOfAccountId]		=	'" . $this->model->getGeneralLedgerChartOfAccountId() . "',
							[iFinancial].[generalLedgerJournalDetail].[countryCurrencyId]					=	'" . $this->model->getCountryCurrencyId()  . "',
							[iFinancial].[generalLedgerJournalDetail].[generalLedgerJournalDetailAmount]	=	'" . $this->model->getGeneralLedgerJournalDetailAmount() . "',
							[iFinancial].[generalLedgerJournalDetail].[isDefault]							=	'" . $this->model->getIsDefault(0, 'single') . "',
							[iFinancial].[generalLedgerJournalDetail].[isNew]								=	'" . $this->model->getIsNew(0, 'single') . "',
							[iFinancial].[generalLedgerJournalDetail].[isDraft]								=	'" . $this->model->getIsDraft(0, 'single') . "',
							[iFinancial].[generalLedgerJournalDetail].[isUpdate]							=	'" . $this->model->getIsUpdate(0, 'single') . "',
							[iFinancial].[generalLedgerJournalDetail].[isDelete]							=	'" . $this->model->getIsDelete(0, 'single') . "',
							[iFinancial].[generalLedgerJournalDetail].[isActive]							=	'" . $this->model->getIsActive(0, 'single') . "',
							[iFinancial].[generalLedgerJournalDetail].[isApproved]							=	'" . $this->model->getIsApproved(0, 'single') . "',
							[iFinancial].[generalLedgerJournalDetail].[isReview]							=	'" . $this->model->getIsReview(0, 'single') . "',
							[iFinancial].[generalLedgerJournalDetail].[isPost]								=	'" . $this->model->getIsPost(0, 'single') . "',
							[iFinancial].[generalLedgerJournalDetail].[executeBy]							=	'" . $this->model->getExecuteBy() . "',
							[iFinancial].[generalLedgerJournalDetail].[executeTime]							=	" . $this->model->getExecuteTime() . "
			WHERE 			[iFinancial].[generalLedgerJournalDetail].[generalLedgerJournalDetailId]		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
			UPDATE		IFINANCIAL.GENERALLEDGERJOURNALDETAIL
			SET 		IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALID						=	'" . $this->model->getGeneralLedgerJournalId() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERCHARTOFACCOUNTID					=	'" . $this->model->getGeneralLedgerChartOfAccountId() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.COUNTRYCURRENCYID								=	'" . $this->model->getCountryCurrencyId()  . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILAMOUNT				=	'" . $this->model->getGeneralLedgerJournalDetailAmount() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDEFAULT										=	'" . $this->model->getIsDefault(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISNEW											=	'" . $this->model->getIsNew(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDRAFT										=	'" . $this->model->getIsDraft(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISUPDATE										=	'" . $this->model->getIsUpdate(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDELETE										=	'" . $this->model->getIsDelete(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE										=	'" . $this->model->getIsActive(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISAPPROVED									=	'" . $this->model->getIsApproved(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISREVIEW										=	'" . $this->model->getIsReview(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISPOST										=	'" . $this->model->getIsPost(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY										=	'" . $this->model->getExecuteBy() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTETIME									=	" . $this->model->getExecuteTime() . "
			WHERE 		IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILID					=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
					
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
			UPDATE		IFINANCIAL.GENERALLEDGERJOURNALDETAIL
			SET 		IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALID						=	'" . $this->model->getGeneralLedgerJournalId() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERCHARTOFACCOUNTID					=	'" . $this->model->getGeneralLedgerChartOfAccountId() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.COUNTRYCURRENCYID								=	'" . $this->model->getCountryCurrencyId()  . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILAMOUNT				=	'" . $this->model->getGeneralLedgerJournalDetailAmount() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDEFAULT										=	'" . $this->model->getIsDefault(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISNEW											=	'" . $this->model->getIsNew(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDRAFT										=	'" . $this->model->getIsDraft(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISUPDATE										=	'" . $this->model->getIsUpdate(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDELETE										=	'" . $this->model->getIsDelete(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE										=	'" . $this->model->getIsActive(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISAPPROVED									=	'" . $this->model->getIsApproved(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISREVIEW										=	'" . $this->model->getIsReview(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISPOST										=	'" . $this->model->getIsPost(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY										=	'" . $this->model->getExecuteBy() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTETIME									=	" . $this->model->getExecuteTime() . "
			WHERE 		IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILID					=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
			UPDATE		IFINANCIAL.GENERALLEDGERJOURNALDETAIL
			SET 		IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALID						=	'" . $this->model->getGeneralLedgerJournalId() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERCHARTOFACCOUNTID					=	'" . $this->model->getGeneralLedgerChartOfAccountId() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.COUNTRYCURRENCYID								=	'" . $this->model->getCountryCurrencyId()  . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILAMOUNT				=	'" . $this->model->getGeneralLedgerJournalDetailAmount() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDEFAULT										=	'" . $this->model->getIsDefault(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISNEW											=	'" . $this->model->getIsNew(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDRAFT										=	'" . $this->model->getIsDraft(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISUPDATE										=	'" . $this->model->getIsUpdate(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDELETE										=	'" . $this->model->getIsDelete(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE										=	'" . $this->model->getIsActive(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISAPPROVED									=	'" . $this->model->getIsApproved(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISREVIEW										=	'" . $this->model->getIsReview(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISPOST										=	'" . $this->model->getIsPost(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY										=	'" . $this->model->getExecuteBy() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTETIME									=	" . $this->model->getExecuteTime() . "
			WHERE 		IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILID					=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}

			$this->q->audit = $this->audit;
			$this->q->update($sql);
			if ($this->q->execute == 'fail') {
				echo json_encode(array("success" => false, "message" => $this->q->responce));
				exit();
			}
		}
		$this->q->commit();
		echo json_encode(array("success" => true, "message" => $this->systemString->getUpdateMessage()));
		exit();
	}

	/* (non-PHPdoc)
	 * @see config::delete()
	 */

	function delete() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->delete();
		// before updating check the id exist or not . if exist continue to update else warning the user
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT	`iFinancial`.`" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`
			FROM 	`iFinancial`.`" . $this->model->getTableName() . "`
			WHERE  	`iFinancial`.`" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[iFinancial].[" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[iFinancial].[" . $this->model->getTableName() . "]
			WHERE  	[iFinancial].[" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	IFINANCIAL." . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	IFINANCIAL." . strtoupper($this->model->getTableName()) . "
			WHERE  	IFINANCIAL." . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	IFINANCIAL." . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	IFINANCIAL." . strtoupper($this->model->getTableName()) . "
			WHERE  	IFINANCIAL." . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	IFINANCIAL." . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	IFINANCIAL." . strtoupper($this->model->getTableName()) . "
			WHERE  	IFINANCIAL." . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		$result = $this->q->fast($sql);
		$total = $this->q->numberRows($result, $sql);
		if ($total == 0) {
			echo json_encode(array("success" => false, "message" => $this->systemString->getRecordNotFoundMessage()));
			exit();
		} else {
			if ($this->getVendor() == self::MYSQL) {
				$sql = "
				UPDATE 	`generalLedgerJournalDetail`
				SET 	`iFinancial`.`generalLedgerJournalDetail`.`isDefault`			=	'" . $this->model->getIsDefault(0, 'single') . "',
						`iFinancial`.`generalLedgerJournalDetail`.`isNew`				=	'" . $this->model->getIsNew(0, 'single') . "',
						`iFinancial`.`generalLedgerJournalDetail`.`isDraft`			=	'" . $this->model->getIsDraft(0, 'single') . "',
						`iFinancial`.`generalLedgerJournalDetail`.`isUpdate`			=	'" . $this->model->getIsUpdate(0, 'single') . "',
						`iFinancial`.`generalLedgerJournalDetail`.`isDelete`			=	'" . $this->model->getIsDelete(0, 'single') . "',
						`iFinancial`.`generalLedgerJournalDetail`.`isActive`			=	'" . $this->model->getIsActive(0, 'single') . "',
						`iFinancial`.`generalLedgerJournalDetail`.`isApproved`		=	'" . $this->model->getIsApproved(0, 'single') . "',
						`iFinancial`.`generalLedgerJournalDetail`.`isReview`			=	'" . $this->model->getIsReview(0, 'single') . "',
						`iFinancial`.`generalLedgerJournalDetail`.`isPost`			=	'" . $this->model->getIsPost(0, 'single') . "',
						`iFinancial`.`generalLedgerJournalDetail`.`executeBy`			=	'" . $this->model->getExecuteBy() . "',
						`iFinancial`.`generalLedgerJournalDetail`.`executeTime`		=	" . $this->model->getExecuteTime() . "
				WHERE 	`iFinancial`.`generalLedgerJournalDetail`.`generalLedgerJournalDetailId`		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
				UPDATE 	[generalLedgerJournalDetail]
				SET 	[iFinancial].[generalLedgerJournalDetail].[isDefault]			=	'" . $this->model->getIsDefault(0, 'single') . "',
						[iFinancial].[generalLedgerJournalDetail].[isNew]				=	'" . $this->model->getIsNew(0, 'single') . "',
						[iFinancial].[generalLedgerJournalDetail].[isDraft]			=	'" . $this->model->getIsDraft(0, 'single') . "',
						[iFinancial].[generalLedgerJournalDetail].[isUpdate]			=	'" . $this->model->getIsUpdate(0, 'single') . "',
						[iFinancial].[generalLedgerJournalDetail].[isDelete]			=	'" . $this->model->getIsDelete(0, 'single') . "',
						[iFinancial].[generalLedgerJournalDetail].[isActive]			=	'" . $this->model->getIsActive(0, 'single') . "',
						[iFinancial].[generalLedgerJournalDetail].[isApproved]		=	'" . $this->model->getIsApproved(0, 'single') . "',
						[iFinancial].[generalLedgerJournalDetail].[isReview]			=	'" . $this->model->getIsReview(0, 'single') . "',
						[iFinancial].[generalLedgerJournalDetail].[isPost]			=	'" . $this->model->getIsPost(0, 'single') . "',
						[iFinancial].[generalLedgerJournalDetail].[executeBy]			=	'" . $this->model->getExecuteBy() . "',
						[iFinancial].[generalLedgerJournalDetail].[executeTime]		=	" . $this->model->getExecuteTime() . "
				WHERE 	[iFinancial].[generalLedgerJournalDetail].[generalLedgerJournalDetailId]		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
				UPDATE IFINANCIAL.GENERALLEDGERJOURNALDETAIL
				SET 	IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISNEW			=	'" . $this->model->getIsNew(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISUPDATE		=	'" . $this->model->getIsUpdate(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDELETE		=	'" . $this->model->getIsDelete(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE		=	'" . $this->model->getIsActive(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISREVIEW		=	'" . $this->model->getIsReview(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISPOST			=	'" . $this->model->getIsPost(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTETIME		=	" . $this->model->getExecuteTime() . "
				WHERE 	IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILID		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
				UPDATE IFINANCIAL.GENERALLEDGERJOURNALDETAIL
				SET 	IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISNEW			=	'" . $this->model->getIsNew(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISUPDATE		=	'" . $this->model->getIsUpdate(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDELETE		=	'" . $this->model->getIsDelete(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE		=	'" . $this->model->getIsActive(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISREVIEW		=	'" . $this->model->getIsReview(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISPOST			=	'" . $this->model->getIsPost(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTETIME		=	" . $this->model->getExecuteTime() . "
				WHERE 	IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILID		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
				UPDATE IFINANCIAL.GENERALLEDGERJOURNALDETAIL
				SET 	IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISNEW			=	'" . $this->model->getIsNew(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISUPDATE		=	'" . $this->model->getIsUpdate(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISDELETE		=	'" . $this->model->getIsDelete(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISACTIVE		=	'" . $this->model->getIsActive(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISREVIEW		=	'" . $this->model->getIsReview(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.ISPOST			=	'" . $this->model->getIsPost(0, 'single') . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
						IFINANCIAL.GENERALLEDGERJOURNALDETAIL.EXECUTETIME		=	" . $this->model->getExecuteTime() . "
				WHERE 	IFINANCIAL.GENERALLEDGERJOURNALDETAIL.GENERALLEDGERJOURNALDETAILID		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}

			$this->q->update($sql);
			if ($this->q->execute == 'fail') {
				echo json_encode(array("success" => false, "message" => $this->q->responce));
				exit();
			}
		}
		$this->q->commit();
		echo json_encode(array("success" => true, "message" => $this->systemString->getDeleteMessage()));
		exit();
	}

	/**
	 * To Update flag Status
	 */
	function updateStatus() {
		header('Content-Type:application/json; charset=utf-8');
		if ($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$loop = $this->model->getTotal();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			UPDATE `" . $this->model->getTableName() . "`
			SET";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			UPDATE 	[" . $this->model->getTableName() . "]
			SET 	";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}


		/**
		 * System Validation Checking
		 * @var $access
		 */
		$access = array("isDefault", "isNew", "isDraft", "isUpdate", "isDelete", "isActive", "isApproved", "isReview", "isPost");
				$accessClear = array("isDefault", "isNew", "isDraft", "isUpdate",  "isActive", "isApproved", "isReview", "isPost");
		
		foreach ($access as $systemCheck) {

			switch ($systemCheck) {
				case 'isDefault' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDefault($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getGeneralLedgerJournalId($i, 'array') . "'
							THEN '" . $this->model->getIsDefault($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isNew' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsNew($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getGeneralLedgerJournalId($i, 'array') . "'
							THEN '" . $this->model->getIsNew($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isDraft' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDraft($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getGeneralLedgerJournalId($i, 'array') . "'
							THEN '" . $this->model->getIsDraft($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isUpdate' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsUpdate($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getGeneralLedgerJournalId($i, 'array') . "'
							THEN '" . $this->model->getIsUpdate($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isDelete' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDelete($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getGeneralLedgerJournalId($i, 'array') . "'
							THEN '" . $this->model->getIsDelete($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isActive' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsActive($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getGeneralLedgerJournalId($i, 'array') . "'
							THEN '" . $this->model->getIsActive($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isApproved' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsApproved($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getGeneralLedgerJournalId($i, 'array') . "'
							THEN '" . $this->model->getIsApproved($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isReview' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsReview($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
                            WHEN '" . $this->model->getGeneralLedgerJournalId($i, 'array') . "'
                            THEN '" . $this->model->getIsReview($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isPost' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsPost($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
                                WHEN '" . $this->model->getGeneralLedgerJournalId($i, 'array') . "'
                                THEN '" . $this->model->getIsPost($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
			}
		}
		$sql .= substr($sqlLooping, 0, - 1);
		if ($this->getVendor() == self::MYSQL) {
			$sql .= "
			WHERE `" . $this->model->getPrimaryKeyName() . "` IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql .= "
			WHERE [" . $this->model->getPrimaryKeyName() . "] IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "  IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::DB2) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "  IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "  IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		if ($this->getIsAdmin()) {
			$message = $this->systemString->getUpdateMessage();
		} else {
			$message = $this->systemString->getDeleteMessage();
		}
		echo json_encode(array("success" => true, "message" => $message,
            "isAdmin" => $this->getIsAdmin()
		, "sql" => $sql)
		);
		exit();
	}

	/**
	 * To check if a key duplicate or not
	 */
	function duplicate() {
		header('Content-Type:application/json; charset=utf-8');
		/**
		 $start = microtime(true);
		 if ($this->getVendor() == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
			}
			if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT	`generalLedgerJournalId`
			FROM 	`generalLedgerJournalDetail`
			WHERE 	`generalLedgerJournalId` 	= 	'" . $this->model->getGeneralLedgerJournalId() . "'
			AND		`isActive`		=	1";
			} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[generalLedgerJournalId]
			FROM 	[iFinancial][generalLedgerJournalDetail]
			WHERE 	[generalLedgerJournalId] 	= 	'" . $this->model->getGeneralLedgerJournalId() . "'
			AND		[isActive]		=	1";
			} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	GENERALLEDGERJOURNALID
			FROM 	GENERALLEDGERJOURNALDETAIL
			WHERE 	GENERALLEDGERJOURNALID 	= 	'" . $this->model->getGeneralLedgerJournalId() . "'
			AND		ISACTIVE		=	1";
			} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	GENERALLEDGERJOURNALID
			FROM 	GENERALLEDGERJOURNALDETAIL
			WHERE 	GENERALLEDGERJOURNALID 	= 	'" . $this->model->getGeneralLedgerJournalId() . "'
			AND		ISACTIVE		=	1";
			} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	GENERALLEDGERJOURNALID
			FROM 	GENERALLEDGERJOURNALDETAIL
			WHERE 	GENERALLEDGERJOURNALID 	= 	'" . $this->model->getGeneralLedgerJournalId() . "'
			AND		ISACTIVE		=	1";
			} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
			}
			$this->q->read($sql);
			$total = 0;
			$total = $this->q->numberRows();
			if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
			}
			if ($total > 0) {
			$row = $this->q->fetchArray();
			echo json_encode(array("success" => true, "total" => $total, "message" => $this->systemString->getDuplicateMessage(), "generalLedgerJournalDetailDesc" => $row ['generalLedgerJournalDetailDesc']));
			exit();
			} else {
			echo json_encode(array("success" => true, "total" => $total, "message" => $this->systemString->getNonDuplicateMessage()));
			exit();
			}
			**/
	}

	function firstRecord($value) {
		$this->recordSet->firstRecord($value);
	}

	function nextRecord($value, $primaryKeyValue) {
		$this->recordSet->nextRecord($value, $primaryKeyValue);
	}

	function previousRecord($value, $primaryKeyValue) {
		$this->recordSet->previousRecord($value, $primaryKeyValue);
	}

	function lastRecord($value) {
		$this->recordSet->lastRecord($value);
	}

	/* (non-PHPdoc)
	 * @see config::excel()
	 */

	function excel() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($_SESSION ['start'] == 0) {
			$sql = str_replace("LIMIT", "", $_SESSION ['sql']);
			$sql = str_replace($_SESSION ['start'] . "," . $_SESSION ['limit'], "", $sql);
		} else {
			$sql = $_SESSION ['sql'];
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->excel->setActiveSheetIndex(0);
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array('borders' => array('inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '000000')), 'outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '000000'))));
		// header all using  3 line  starting b
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
		$this->excel->getActiveSheet()->setCellValue('B2', $this->title);
		$this->excel->getActiveSheet()->setCellValue('C2', '');
		$this->excel->getActiveSheet()->mergeCells('B2:C2');
		$this->excel->getActiveSheet()->setCellValue('B3', 'No');
		$this->excel->getActiveSheet()->setCellValue('C3', 'Penerangan');
		$this->excel->getActiveSheet()->getStyle('B2:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:C2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:C3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:C3')->getFill()->getStartColor()->setARGB('66BBFF');
		//
		$loopRow = 4;
		$i = 0;
		while (($row = $this->q->fetchAssoc()) == TRUE) {
			//	echo print_r($row);
			$this->excel->getActiveSheet()->setCellValue('B' . $loopRow, ++$i);
			$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, 'a' . $row ['generalLedgerJournalDetailDesc']);
			$loopRow++;
			$lastRow = 'C' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename = "generalLedgerJournalDetail" . rand(0, 10000000) . ".xlsx";
		$path = $_SERVER ['DOCUMENT_ROOT'] . "/" . $this->application . "/basic/document/excel/" . $filename;
		$this->documentTrail->create_trail($this->leafId, $path, $filename);
		$objWriter->save($path);
		$file = fopen($path, 'r');
		if ($file) {
			echo json_encode(array("success" =>true, "message" => $this->systemString->getFileGenerateMessage(), "filename" => $filename));
			exit();
		} else {
			echo json_encode(array("success" =>false, "message" => $this->systemString->getFileNotGenerateMessage()));
			exit();
		}
	}

}

$generalLedgerJournalDetailObject = new GeneralledgerjournaldetailClass ();

/**
 * crud -create,read,update,delete
 * */
if (isset($_POST ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_POST ['leafId'])) {
		$generalLedgerJournalDetailObject->setLeafId($_POST ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$generalLedgerJournalDetailObject->setIsAdmin($_POST ['isAdmin']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$generalLedgerJournalDetailObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$generalLedgerJournalDetailObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Filtering
	 */
	if (isset($_POST ['query'])) {
		$generalLedgerJournalDetailObject->setFieldQuery($_POST ['query']);
	}
	if (isset($_POST ['filter'])) {
		$generalLedgerJournalDetailObject->setGridQuery($_POST ['filter']);
	}
	if (isset($_POST ['character'])) {
		$generalLedgerJournalDetailObject->setCharacterQuery($_POST['character']);
	}
	if (isset($_POST ['dateRangeStart'])) {
		$generalLedgerJournalDetailObject->setDateRangeStartQuery($_POST['dateRangeStart']);
	}
	if (isset($_POST ['dateRangeEnd'])) {
		$generalLedgerJournalDetailObject->setDateRangeEndQuery($_POST['dateRangeEnd']);
	}
	if (isset($_POST ['dateRangeType'])) {
		$generalLedgerJournalDetailObject->setDateRangeTypeQuery($_POST['dateRangeType']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST ['order'])) {
		$generalLedgerJournalDetailObject->setOrder($_POST ['order']);
	}
	if (isset($_POST ['sortField'])) {
		$generalLedgerJournalDetailObject->setSortField($_POST ['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$generalLedgerJournalDetailObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$generalLedgerJournalDetailObject->create();
	}
	if ($_POST ['method'] == 'save') {
		$generalLedgerJournalDetailObject->update();
	}
	if ($_POST ['method'] == 'read') {
		$generalLedgerJournalDetailObject->read();
	}
	if ($_POST ['method'] == 'delete') {
		$generalLedgerJournalDetailObject->delete();
	}
}
if (isset($_GET ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_GET ['leafId'])) {
		$generalLedgerJournalDetailObject->setLeafId($_GET ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET ['isAdmin'])) {
		$generalLedgerJournalDetailObject->setIsAdmin($_GET ['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$generalLedgerJournalDetailObject->execute();
	if (isset($_GET ['field'])) {
		if ($_GET ['field'] == 'staffId') {
			$generalLedgerJournalDetailObject->staff();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$generalLedgerJournalDetailObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET ['generalLedgerJournalDetailDesc'])) {
		if (strlen($_GET ['generalLedgerJournalDetailDesc']) > 0) {
			$generalLedgerJournalDetailObject->duplicate();
		}
	}
	/**
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$generalLedgerJournalDetailObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$generalLedgerJournalDetailObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$generalLedgerJournalDetailObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$generalLedgerJournalDetailObject->lastRecord('json');
		}
	}
	/*
	 * Excel Reporting
	 */
	if (isset($_GET ['mode'])) {
		if ($_GET ['mode'] == 'excel') {
			$generalLedgerJournalDetailObject->excel();
		}
	}
}
?>
