<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../class/classDate.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/generalLedgerJournalModel.php");

/**
 * The general journal is where double entry bookkeeping entries are recorded by debiting one or more accounts and crediting another one or more accounts with the same total amount. The total amount debited and the total amount credited should always be equal, thereby ensuring the accounting equation is maintained.Depending on the business's accounting information system, specialized journals may be used in conjunction with the general journal for record-keeping. In such case, use of the general journal may be limited to non-routine and adjusting entries.
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package General Ledger
 * @subpackage Journal
 * @link http://www.idcms.org
 * @http://en.wikipedia.org/wiki/Journal_%28accounting%29
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class GeneralLedgerJournalClass extends ConfigClass {

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

		$this->model = new GeneralLedgerJournalModel ();
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
		$this->model->setDocumentNo($this->documentNumbering()); //override document numbering
		if ($this->getVendor() == self::MYSQL) {

			$sql="
			INSERT INTO `".$this->q->getFinancialDatabase()."`.`generalLedgerJournal` 
				(    
						`generalLedgerJournalId`,   `generalLedgerJournalTypeId`,   `documentNo`,`referenceNo`,   `generalLedgerJournalTitle`,    `generalLedgerJournalDesc`, `generalLedgerJournalDate`, `generalLedgerJournalStartDate`,    `generalLedgerJournalEndDate`,  `generalLedgerJournalAmount`,   `isDefault`,    `isNew`,    `isDraft`,  `isUpdate`, `isDelete`, `isActive`, `isApproved`,   `isReview`, `isPost`,   `executeBy`,    `executeTime`) VALUES ( null, '".$this->model->getGeneralLedgerJournalTypeId()."',
'".$this->model->getDocumentNo()."',
'".$this->model->getReferenceNo()."',
'".$this->model->getGeneralLedgerJournalTitle()."',
'".$this->model->getGeneralLedgerJournalDesc()."',
'".$this->model->getGeneralLedgerJournalDate()."',
'".$this->model->getGeneralLedgerJournalStartDate()."',
'".$this->model->getGeneralLedgerJournalEndDate()."',
'".$this->model->getGeneralLedgerJournalAmount()."',
'".$this->model->getIsDefault(0, 'single')."',
'".$this->model->getIsNew(0, 'single')."',
'".$this->model->getIsDraft(0, 'single')."',
'".$this->model->getIsUpdate(0, 'single')."',
'".$this->model->getIsDelete(0, 'single')."',
'".$this->model->getIsActive(0, 'single')."',
'".$this->model->getIsApproved(0, 'single')."',
'".$this->model->getIsReview(0, 'single')."',
'".$this->model->getIsPost(0, 'single')."',
'".$this->model->getExecuteBy()."',
".$this->model->getExecuteTime().");";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			INSERT INTO [".$this->q->getFinancialDatabase()."].[generalLedgerJournal]
					(
						[documentNo],												
						[generalLedgerJournalTitle],
						[generalLedgerJournalDesc],
						[generalLedgerJournalDate],
						[generalLedgerJournalAmount],													
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
						'" . $this->model->getDocumentNo() . "',
						'" . $this->model->getGeneralLedgerJournalTitle() . "',
						'" . $this->model->getGeneralLedgerJournalDesc() . "',
						'" . $this->model->getGeneralLedgerJournalDate() . "',
						'" . $this->model->getGeneralLedgerJournalAmount() . "',					
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
			INSERT INTO	GENERALLEDGERJOURNAL
					(
						DOCUMENTNO,												
						GENERALLEDGERJOURNALTITLE,
						GENERALLEDGERJOURNALDESC,
						GENERALLEDGERJOURNALDATE,
						GENERALLEDGERJOURNALAMOUNT,
						ISDEFAULT,
						ISNEW,														
						ISDRAFT,
						ISUPDATE,													
						ISDELETE,
						ISACTIVE,													
						ISAPPROVED,
						ISREVIEW,													
						ISPOST,
						EXECUTEBY,													
						EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getDocumentNo() . "',
						'" . $this->model->getGeneralLedgerJournalTitle() . "',
						'" . $this->model->getGeneralLedgerJournalDesc() . "',
						'" . $this->model->getGeneralLedgerJournalDate() . "',
						'" . $this->model->getGeneralLedgerJournalAmount() . "',					
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',						
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					)";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			INSERT INTO	GENERALLEDGERJOURNAL
					(
						DOCUMENTNO,												
						GENERALLEDGERJOURNALTITLE,
						GENERALLEDGERJOURNALDESC,
						GENERALLEDGERJOURNALDATE,
						GENERALLEDGERJOURNALAMOUNT,
						ISDEFAULT,
						ISNEW,														
						ISDRAFT,
						ISUPDATE,													
						ISDELETE,
						ISACTIVE,													
						ISAPPROVED,
						ISREVIEW,													
						ISPOST,
						EXECUTEBY,													
						EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getDocumentNo() . "',
						'" . $this->model->getGeneralLedgerJournalTitle() . "',
						'" . $this->model->getGeneralLedgerJournalDesc() . "',
						'" . $this->model->getGeneralLedgerJournalDate() . "',
						'" . $this->model->getGeneralLedgerJournalAmount() . "',					
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',						
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					)";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			INSERT INTO	GENERALLEDGERJOURNAL
					(
						DOCUMENTNO,												
						GENERALLEDGERJOURNALTITLE,
						GENERALLEDGERJOURNALDESC,
						GENERALLEDGERJOURNALDATE,
						GENERALLEDGERJOURNALAMOUNT,
						ISDEFAULT,
						ISNEW,														
						ISDRAFT,
						ISUPDATE,													
						ISDELETE,
						ISACTIVE,													
						ISAPPROVED,
						ISREVIEW,													
						ISPOST,
						EXECUTEBY,													
						EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getDocumentNo() . "',
						'" . $this->model->getGeneralLedgerJournalTitle() . "',
						'" . $this->model->getGeneralLedgerJournalDesc() . "',
						'" . $this->model->getGeneralLedgerJournalDate() . "',
						'" . $this->model->getGeneralLedgerJournalAmount() . "',					
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',						
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					)";
		} else {
			echo json_encode(array("success" => false,"sql"=>$sql, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		
		$this->q->create($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$generalLedgerJournalId = $this->q->lastInsertId();

		$this->q->commit();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array("success" => true,
			      "message" => $this->systemString->getCreateMessage(), 
			      "generalLedgerJournalId" => $generalLedgerJournalId,
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
				$this->auditFilter = "		`generalLedgerJournal`.`isActive`		=	1
										AND	`generalLedgerJournal`.`isPost`		=	0";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "  	[generalLedgerJournal].[isActive]		=	1
										AND	[generalLedgerJournal].[isPost]		=	0 ";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "		GENERALLEDGERJOURNAL.ISACTIVE			=	1
										AND GENERALLEDGERJOURNAL.ISPOST			=	0	";
			} else if ($this->q->vendor == self::DB2) {
				$this->auditFilter = "		GENERALLEDGERJOURNAL.ISACTIVE			=	1
										AND GENERALLEDGERJOURNAL.ISPOST			=	0	";
			} else if ($this->q->vendor == self::POSTGRESS) {
				$this->auditFilter = "		GENERALLEDGERJOURNAL.ISACTIVE			=	1
											AND GENERALLEDGERJOURNAL.ISPOST		=	0	";
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
			SELECT	`generalLedgerJournal`.`generalLedgerJournalId`,
					`generalLedgerJournal`.`generalLedgerJournalTypeId`,
					`generalLedgerJournal`.`documentNo`,
					`generalLedgerJournal`.`generalLedgerJournalTitle`,
					`generalLedgerJournal`.`generalLedgerJournalDesc`,
					`generalLedgerJournal`.`generalLedgerJournalDate`,
					`generalLedgerJournal`.`generalLedgerJournalStartDate`,
					`generalLedgerJournal`.`generalLedgerJournalEndDate`,
					`generalLedgerJournal`.`generalLedgerJournalAmount`,
					`generalLedgerJournal`.`isDefault`,
					`generalLedgerJournal`.`isNew`,
					`generalLedgerJournal`.`isDraft`,
					`generalLedgerJournal`.`isUpdate`,
					`generalLedgerJournal`.`isDelete`,
					`generalLedgerJournal`.`isActive`,
					`generalLedgerJournal`.`isApproved`,
					`generalLedgerJournal`.`isReview`,
					`generalLedgerJournal`.`isPost`,
					`generalLedgerJournal`.`executeBy`,
					`generalLedgerJournal`.`executeTime`,
					`generalLedgerJournalType`.`generalLedgerJournalTypeDesc`,
                   	`staff`.`staffName`
            FROM    `".$this->q->getFinancialDatabase()."`.`generalLedgerJournal`
            JOIN    `".$this->q->getManagementDatabase()."`.`staff`
            ON      `generalLedgerJournal`.`executeBy` = `staff`.`staffId`
            JOIN	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournalType`
            USING	(`generalLedgerJournalTypeId`)
            WHERE 	 " . $this->auditFilter;

			if ($this->model->getGeneralLedgerJournalId(0, 'single')) {
				$sql .= " AND `" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`='" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			}


		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT		[generalLedgerJournal].[generalLedgerJournalId],
						[generalLedgerJournal].[generalLedgerJournalTypeId],
						[generalLedgerJournal].[documentNo],
						[generalLedgerJournal].[generalLedgerJournalTitle],
						[generalLedgerJournal].[generalLedgerJournalDesc],
						[generalLedgerJournal].[generalLedgerJournalDate],
						[generalLedgerJournal].[generalLedgerJournalStartDate],
						[generalLedgerJournal].[generalLedgerJournalEndDate],
						[generalLedgerJournal].[generalLedgerJournalAmount],
						[generalLedgerJournal].[isDefault],
						[generalLedgerJournal].[isNew],
						[generalLedgerJournal].[isDraft],
						[generalLedgerJournal].[isUpdate],
						[generalLedgerJournal].[isDelete],
						[generalLedgerJournal].[isActive],
						[generalLedgerJournal].[isApproved],
						[generalLedgerJournal].[isReview],
						[generalLedgerJournal].[isPost],
						[generalLedgerJournal].[executeBy],
						[generalLedgerJournal].[executeTime],
						[staff].[staffName]
			FROM 	[".$this->q->getFinancialDatabase()."].[generalLedgerJournal]
			JOIN	[".$this->q->getManagementDatabase()."].[staff]
			ON		[generalLedgerJournal].[executeBy] = [staff].[staffId]
			WHERE 	" . $this->auditFilter;
			//	if ($this->model->getGeneralLedgerJournalId(0, 'single')) {
			//	$sql .= " AND [" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]='" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			//}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT		GENERALLEDGERJOURNAL.GENERALLEDGERJOURNALID   		 	AS 	\"generalLedgerJournalId\",
						GENERALLEDGERJOURNAL.DOCUMENTNO 				AS 	\"documentNo\",
						GENERALLEDGERJOURNAL.GENERALLEDGERJOURNALTITLE 			AS 	\"generalLedgerJournalTitle\",
						GENERALLEDGERJOURNAL.GENERALLEDGERJOURNALDESC 			AS 	\"generalLedgerJournalDesc\",
						GENERALLEDGERJOURNAL.GENERALLEDGERJOURNALDATE 			AS 	\"generalLedgerJournalDate\",
						GENERALLEDGERJOURNAL.GENERALLEDGERJOURNALAMOUNT 			AS 	\"generalLedgerJournalAmount\",
						GENERALLEDGERJOURNAL.ISDEFAULT    			AS	\"isDefault\",
						GENERALLEDGERJOURNAL.ISNEW		  			AS	\"isNew\",
						GENERALLEDGERJOURNAL.ISDRAFT	  				AS	\"isDraft\",
						GENERALLEDGERJOURNAL.ISUPDATE     			AS	\"isUpdate\",
						GENERALLEDGERJOURNAL.ISDELETE	  			AS	\"isDelete\",
						GENERALLEDGERJOURNAL.ISACTIVE	  			AS	\"isActive\",
						GENERALLEDGERJOURNAL.ISAPPROVED   			AS	\"isApproved\",
						GENERALLEDGERJOURNAL.ISREVIEW	  			AS	\"isReview\",
						GENERALLEDGERJOURNAL.ISPOST  	  			AS	\"isPost\",
						GENERALLEDGERJOURNAL.EXECUTEBY    			AS	\"executeBy\",
						GENERALLEDGERJOURNAL.EXECUTETIME  			AS	\"executeTime\",
						STAFF.STAFFNAME		  			AS	\"staffName\"	
			FROM 		GENERALLEDGERJOURNAL
			JOIN		STAFF
			ON			GENERALLEDGERJOURNAL.EXECUTEBY 	  	=	STAFF.STAFFID
			WHERE 	" . $this->auditFilter;
			//	if ($this->model->getGeneralLedgerJournalId(0, 'single')) {
			//		$sql .= " AND " . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "='" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			//	}
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

			$sql.=$this->q->dateFilter($this->model->getTableName(),$this->model->getFilterDate(),$this->getDateRangeStartQuery(),$this->getDateRangeEndQuery(),$this->getDateRangeTypeQuery());

		}

		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array('generalLedgerJournalId');
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array('generalLedgerJournal');
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
				$sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
			} else if ($this->getVendor() == self::DB2) {
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
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
							WITH [generalLedgerJournalDerived] AS
							(
								SELECT 		[generalLedgerJournal].[generalLedgerJournalId],
											[generalLedgerJournal].[documentNo],
											[generalLedgerJournal].[generalLedgerJournalTitle],
											[generalLedgerJournal].[generalLedgerJournalDesc],
											[generalLedgerJournal].[generalLedgerJournalDate],
											[generalLedgerJournal].[generalLedgerJournalAmount],
											[generalLedgerJournal].[isDefault],
											[generalLedgerJournal].[isNew],
											[generalLedgerJournal].[isDraft],
											[generalLedgerJournal].[isUpdate],
											[generalLedgerJournal].[isDelete],
											[generalLedgerJournal].[isApproved],
											[generalLedgerJournal].[isReview],
											[generalLedgerJournal].[isPost],
											[generalLedgerJournal].[executeBy],
											[generalLedgerJournal].[executeTime],
											[staff].[staffName],
								ROW_NUMBER() OVER (ORDER BY [generalLedgerJournal].[generalLedgerJournalId]) AS 'RowNumber'
								FROM 	[".$this->q->getFinancialDatabase()."].[generalLedgerJournal]
								JOIN	[".$this->q->getManagementDatabase()."].[staff]
								ON		[generalLedgerJournal].[executeBy] = [staff].[staffId]
								WHERE " . $this->auditFilter . $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[generalLedgerJournalDerived]
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
								SELECT	GENERALLEDGERJOURNAL.GENERALLEDGERJOURNALID   		AS 	\"generalLedgerJournalId\",
										GENERALLEDGERJOURNAL.DOCUMENTNO 			AS 	\"documentNo\",
										GENERALLEDGERJOURNAL.GENERALLEDGERJOURNALTITLE 		AS 	\"generalLedgerJournalTitle\",
										GENERALLEDGERJOURNAL.GENERALLEDGERJOURNALDESC 		AS 	\"generalLedgerJournalDesc\",
										GENERALLEDGERJOURNAL.GENERALLEDGERJOURNALDATE 		AS 	\"generalLedgerJournalDate\",
										GENERALLEDGERJOURNAL.GENERALLEDGERJOURNALAMOUNT 		AS 	\"generalLedgerJournalAmount\",
										GENERALLEDGERJOURNAL.ISDEFAULT    		AS	\"isDefault\",
										GENERALLEDGERJOURNAL.ISNEW		  		AS	\"isNew\",
										GENERALLEDGERJOURNAL.ISDRAFT	 			AS	\"isDraft\",
										GENERALLEDGERJOURNAL.ISUPDATE     		AS	\"isUpdate\",
										GENERALLEDGERJOURNAL.ISDELETE	  		AS	\"isDelete\",
										GENERALLEDGERJOURNAL.ISACTIVE	  		AS	\"isActive\",
										GENERALLEDGERJOURNAL.ISAPPROVED   		AS	\"isApproved\",
										GENERALLEDGERJOURNAL.ISREVIEW	  		AS 	\"isReview\",
										GENERALLEDGERJOURNAL.ISPOST		  		AS	\"isPost\",
										GENERALLEDGERJOURNAL.EXECUTEBY    		AS	\"executeBy\",
										GENERALLEDGERJOURNAL.EXECUTETIME  		AS	\"executeTime\",
										STAFF.STAFFNAME		  		AS	\"staffName\"	
								FROM 	GENERALLEDGERJOURNAL
								JOIN	STAFF
								ON		GENERALLEDGERJOURNAL.EXECUTEBY 	  	=	STAFF.STAFFID
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
		if (!($this->model->getGeneralLedgerJournalId(0, 'single'))) {
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
		if ($this->model->getGeneralLedgerJournalId(0, 'single')) {
			$json_encode = json_encode(
			array(	'sql'=>$sql,
						'success' => true, 
						'total' => $total, 
						'message' =>  $this->systemString->getReadMessage(),
						'time'=>$time,						
				  		'trialBalance'=>$this->trialBalanceChecking(),
				  		'tally'=>$this->tallyChecking(),
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
			echo json_encode(
			array(	'sql'=>$sql,
					'success' => true, 
					'total' => $total, 
					'message' =>  $this->systemString->getReadMessage(), 
					'time'=>$time,
					'masterDetail'=>$this->masterDetailChecking(),
				  	'trialBalance'=>$this->trialBalanceChecking(),
				  	'tally'=>$this->tallyChecking(),
					'firstRecord' => $this->recordSet->firstRecord('value'), 
					'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getGeneralLedgerJournalId(0, 'single')), 
					'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getGeneralLedgerJournalId(0, 'single')), 
					'lastRecord' => $this->recordSet->lastRecord('value'),
					'data' => $items));
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
			SELECT	`" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`
			FROM 	`".$this->q->getFinancialDatabase()."`.`" . $this->model->getTableName() . "`
			WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[" . $this->model->getTableName() . "]	[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[".$this->q->getFinancialDatabase()."].[" . $this->model->getTableName() . "]
			WHERE  	[".$this->q->getFinancialDatabase()."].[" . $this->model->getTableName() . "][" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
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
				UPDATE		`".$this->q->getFinancialDatabase()."`.`generalLedgerJournal`
				SET 		`generalLedgerJournalTypeId` = '".$this->model->getGeneralLedgerJournalTypeId()."',
							 `generalLedgerJournalTitle` = '".$this->model->getGeneralLedgerJournalTitle()."',
							 `generalLedgerJournalDesc` = '".$this->model->getGeneralLedgerJournalDesc()."',
							 `generalLedgerJournalDate` = '".$this->model->getGeneralLedgerJournalDate()."',
							 `generalLedgerJournalStartDate` = '".$this->model->getGeneralLedgerJournalStartDate()."',
							 `generalLedgerJournalEndDate` = '".$this->model->getGeneralLedgerJournalEndDate()."',
							 `generalLedgerJournalAmount` = '".$this->model->getGeneralLedgerJournalAmount()."',
 							`isDefault`			=	'" . $this->model->getIsDefault(0, 'single') . "',
							`isNew`				=	'" . $this->model->getIsNew(0, 'single') . "',
							`isDraft`			=	'" . $this->model->getIsDraft(0, 'single') . "',
							`isUpdate`			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							`isDelete`			=	'" . $this->model->getIsDelete(0, 'single') . "',
							`isActive`			=	'" . $this->model->getIsActive(0, 'single') . "',
							`isApproved`		=	'" . $this->model->getIsApproved(0, 'single') . "',
							`isReview`			=	'" . $this->model->getIsReview(0, 'single') . "',
							`isPost`			=	'" . $this->model->getIsPost(0, 'single') . "',
							`executeBy`			=	'" . $this->model->getExecuteBy() . "',
							`executeTime`		=	" . $this->model->getExecuteTime() . "
				WHERE 		`generalLedgerJournalId`		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
				UPDATE 		[".$this->q->getFinancialDatabase()."].[generalLedgerJournal]
				SET 		[generalLedgerJournalTypeId] = '".$this->model->getGeneralLedgerJournalTypeId()."',
							[generalLedgerJournalTitle] = '".$this->model->getGeneralLedgerJournalTitle()."',
							[generalLedgerJournalDesc] = '".$this->model->getGeneralLedgerJournalDesc()."',
							[generalLedgerJournalDate] = '".$this->model->getGeneralLedgerJournalDate()."',
							[generalLedgerJournalStartDate] = '".$this->model->getGeneralLedgerJournalStartDate()."',
							[generalLedgerJournalEndDate] = '".$this->model->getGeneralLedgerJournalEndDate()."',
							[generalLedgerJournalAmount] = '".$this->model->getGeneralLedgerJournalAmount()."',	
							[isDefault]			=	'" . $this->model->getIsDefault(0, 'single') . "',
							[isNew]				=	'" . $this->model->getIsNew(0, 'single') . "',
							[isDraft]			=	'" . $this->model->getIsDraft(0, 'single') . "',
							[isUpdate]			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							[isDelete]			=	'" . $this->model->getIsDelete(0, 'single') . "',
							[isActive]			=	'" . $this->model->getIsActive(0, 'single') . "',
							[isApproved]		=	'" . $this->model->getIsApproved(0, 'single') . "',
							[isReview]			=	'" . $this->model->getIsReview(0, 'single') . "',
							[isPost]			=	'" . $this->model->getIsPost(0, 'single') . "',
							[executeBy]			=	'" . $this->model->getExecuteBy() . "',
							[executeTime]		=	" . $this->model->getExecuteTime() . "
			WHERE 		[generalLedgerJournalId]			=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
				UPDATE		GENERALLEDGERJOURNAL
				SET 		DOCUMENTNO	=	'" . $this->model->getDocumentNo() . "',
							GENERALLEDGERJOURNALTITLE		=	'" . $this->model->getGeneralLedgerJournalTitle() . "',
							GENERALLEDGERJOURNALDESC		=	'" . $this->model->getGeneralLedgerJournalDesc() . "',
							GENERALLEDGERJOURNALDATE		=	'" . $this->model->getGeneralLedgerJournalDate() . "',
							GENERALLEDGERJOURNALAMOUNT		=	'" . $this->model->getGeneralLedgerJournalAmount() . "',									
							ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISNEW				=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE			=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISACTIVE			=	'" . $this->model->getIsActive(0, 'single') . "',
							ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW			=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST				=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME	=	" . $this->model->getExecuteTime() . "
			WHERE 		GENERALLEDGERJOURNALID		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
			UPDATE	GENERALLEDGERJOURNAL
			SET 			DOCUMENTNO	=	'" . $this->model->getDocumentNo() . "',
							GENERALLEDGERJOURNALTITLE		=	'" . $this->model->getGeneralLedgerJournalTitle() . "',
							GENERALLEDGERJOURNALDESC		=	'" . $this->model->getGeneralLedgerJournalDesc() . "',
							GENERALLEDGERJOURNALDATE		=	'" . $this->model->getGeneralLedgerJournalDate() . "',
							GENERALLEDGERJOURNALAMOUNT		=	'" . $this->model->getGeneralLedgerJournalAmount() . "',
							ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISNEW				=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE			=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISACTIVE			=	'" . $this->model->getIsActive(0, 'single') . "',
							ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW			=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST				=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME	=	" . $this->model->getExecuteTime() . "
			WHERE 		GENERALLEDGERJOURNALID		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
				UPDATE		GENERALLEDGERJOURNAL
				SET 		DOCUMENTNO	=	'" . $this->model->getDocumentNo() . "',
							GENERALLEDGERJOURNALTITLE		=	'" . $this->model->getGeneralLedgerJournalTitle() . "',
							GENERALLEDGERJOURNALDESC		=	'" . $this->model->getGeneralLedgerJournalDesc() . "',
							GENERALLEDGERJOURNALDATE		=	'" . $this->model->getGeneralLedgerJournalDate() . "',
							GENERALLEDGERJOURNALAMOUNT		=	'" . $this->model->getGeneralLedgerJournalAmount() . "',
							ISDEFAULT			=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISNEW				=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT				=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE			=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISACTIVE			=	'" . $this->model->getIsActive(0, 'single') . "',
							ISAPPROVED			=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW			=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST				=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY			=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME			=	" . $this->model->getExecuteTime() . "
				WHERE 		GENERALLEDGERJOURNALID			=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
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
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array("success" => true,
			      "message" => $this->systemString->getUpdateMessage(),
				   "time"=>$time));
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
			SELECT	`" . $this->model->getPrimaryKeyName() . "`
			FROM 	`".$this->q->getFinancialDatabase()."`.`" . $this->model->getTableName() . "`
			WHERE   `" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[".$this->q->getFinancialDatabase()."].[" . $this->model->getTableName() . "]
			WHERE  	[".$this->q->getFinancialDatabase()."].[" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getGeneralLedgerJournalId(0, 'single') . "' ";
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
				UPDATE 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournal`
				SET 	`generalLedgerJournal`.`isDefault`			=	'" . $this->model->getIsDefault(0, 'single') . "',
						`generalLedgerJournal`.`isNew`				=	'" . $this->model->getIsNew(0, 'single') . "',
						`generalLedgerJournal`.`isDraft`			=	'" . $this->model->getIsDraft(0, 'single') . "',
						`generalLedgerJournal`.`isUpdate`			=	'" . $this->model->getIsUpdate(0, 'single') . "',
						`generalLedgerJournal`.`isDelete`			=	'" . $this->model->getIsDelete(0, 'single') . "',
						`generalLedgerJournal`.`isActive`			=	'" . $this->model->getIsActive(0, 'single') . "',
						`generalLedgerJournal`.`isApproved`		=	'" . $this->model->getIsApproved(0, 'single') . "',
						`generalLedgerJournal`.`isReview`			=	'" . $this->model->getIsReview(0, 'single') . "',
						`generalLedgerJournal`.`isPost`			=	'" . $this->model->getIsPost(0, 'single') . "',
						`generalLedgerJournal`.`executeBy`			=	'" . $this->model->getExecuteBy() . "',
						`generalLedgerJournal`.`executeTime`		=	" . $this->model->getExecuteTime() . "
				WHERE 	`generalLedgerJournalId`		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
				UPDATE 	[".$this->q->getFinancialDatabase()."].[generalLedgerJournal]
				SET 	[generalLedgerJournal].[isDefault]			=	'" . $this->model->getIsDefault(0, 'single') . "',
						[generalLedgerJournal].[isNew]				=	'" . $this->model->getIsNew(0, 'single') . "',
						[generalLedgerJournal].[isDraft]			=	'" . $this->model->getIsDraft(0, 'single') . "',
						[generalLedgerJournal].[isUpdate]			=	'" . $this->model->getIsUpdate(0, 'single') . "',
						[generalLedgerJournal].[isDelete]			=	'" . $this->model->getIsDelete(0, 'single') . "',
						[generalLedgerJournal].[isActive]			=	'" . $this->model->getIsActive(0, 'single') . "',
						[generalLedgerJournal].[isApproved]		=	'" . $this->model->getIsApproved(0, 'single') . "',
						[generalLedgerJournal].[isReview]			=	'" . $this->model->getIsReview(0, 'single') . "',
						[generalLedgerJournal].[isPost]			=	'" . $this->model->getIsPost(0, 'single') . "',
						[generalLedgerJournal].[executeBy]			=	'" . $this->model->getExecuteBy() . "',
						[generalLedgerJournal].[executeTime]		=	" . $this->model->getExecuteTime() . "
				WHERE 	[generalLedgerJournalId]		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
				UPDATE 	GENERALLEDGERJOURNAL
				SET 	ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
						ISNEW			=	'" . $this->model->getIsNew(0, 'single') . "',
						ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
						ISUPDATE		=	'" . $this->model->getIsUpdate(0, 'single') . "',
						ISDELETE		=	'" . $this->model->getIsDelete(0, 'single') . "',
						ISACTIVE		=	'" . $this->model->getIsActive(0, 'single') . "',
						ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
						ISREVIEW		=	'" . $this->model->getIsReview(0, 'single') . "',
						ISPOST			=	'" . $this->model->getIsPost(0, 'single') . "',
						EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
						EXECUTETIME		=	" . $this->model->getExecuteTime() . "
				WHERE 	GENERALLEDGERJOURNALID		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
				UPDATE 	GENERALLEDGERJOURNAL
				SET 	ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
						ISNEW			=	'" . $this->model->getIsNew(0, 'single') . "',
						ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
						ISUPDATE		=	'" . $this->model->getIsUpdate(0, 'single') . "',
						ISDELETE		=	'" . $this->model->getIsDelete(0, 'single') . "',
						ISACTIVE		=	'" . $this->model->getIsActive(0, 'single') . "',
						ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
						ISREVIEW		=	'" . $this->model->getIsReview(0, 'single') . "',
						ISPOST			=	'" . $this->model->getIsPost(0, 'single') . "',
						EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
						EXECUTETIME		=	" . $this->model->getExecuteTime() . "
				WHERE 	GENERALLEDGERJOURNALID		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
				UPDATE 	GENERALLEDGERJOURNAL
				SET 	ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
						ISNEW			=	'" . $this->model->getIsNew(0, 'single') . "',
						ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
						ISUPDATE		=	'" . $this->model->getIsUpdate(0, 'single') . "',
						ISDELETE		=	'" . $this->model->getIsDelete(0, 'single') . "',
						ISACTIVE		=	'" . $this->model->getIsActive(0, 'single') . "',
						ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
						ISREVIEW		=	'" . $this->model->getIsReview(0, 'single') . "',
						ISPOST			=	'" . $this->model->getIsPost(0, 'single') . "',
						EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
						EXECUTETIME		=	" . $this->model->getExecuteTime() . "
				WHERE 	GENERALLEDGERJOURNALID		=	'" . $this->model->getGeneralLedgerJournalId(0, 'single') . "'";
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
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array(	"success" => true,
					"message" => $this->systemString->getDeleteMessage(),
					"time"=>$time));
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
			UPDATE `".$this->q->getFinancialDatabase()."`.`" . $this->model->getTableName() . "`
			SET";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			UPDATE 	[".$this->q->getFinancialDatabase()."].[" . $this->model->getTableName() . "]
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
		$access 	 = array("isDefault", "isNew", "isDraft", "isUpdate", "isDelete", "isActive", "isApproved", "isReview", "isPost");
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
							// update delete status = 1
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
							if(!$this->getIsAdmin()){
								foreach ($accessClear as $clear){
									// update delete status = 1
									if ($this->getVendor() == self::MYSQL) {
										$sqlLooping .= " `" . $clear . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
									} else if ($this->getVendor() == self::MSSQL) {
										$sqlLooping .= "  [" . $clear. "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
									} else if ($this->getVendor() == self::ORACLE) {
										$sqlLooping .= "	" . $clear . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
									} else if ($this->getVendor() == self::DB2) {
										$sqlLooping .= "	" . $clear . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
									} else if ($this->getVendor() == self::POSTGRESS) {
										$sqlLooping .= "	" .$clear . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
									} else {
										echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
										exit();
									}
									$sqlLooping .= "
							WHEN '" . $this->model->getGeneralLedgerJournalId($i, 'array') . "'
							THEN '0'";
									$sqlLooping .= " END,";
								}
									
							}
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
		echo json_encode(
		array("success" => true,
					"message" => $message,
            		"isAdmin" => $this->getIsAdmin(), 	
            		"sql" => $sql,
					"time"=>$time)
		);
		exit();
	}
	/*
	 * To Check  only valid transaction date push into the system
	 */
	function closingChecking(){
		$arrayDate = explode("-",$this->model->getGeneralLedgerJournalDate());
		$day=intval($arrayDate[2]);
		$month=intval($arrayDate[1]);
		$year=intval($arrayDate[0]);
		$sql="SELECT * FROM `financialDuration` WHERE `financialDurationYear`='".$year."'";
		$result=$this->q->fast($sql);
		$row = $this->q->fetchArray($result);
		switch($month){
			case 1 :
				if($row['financialDurationYearPeriodFirstClose']==1){
					return 0;
				} else{
					return 1;
				}
			break;
			case 2 :
				if($row['financialDurationYearPeriodSecondClose']==1){
					return 0;
				} else{
					return 1;
				}
			break;	
			case 3 :
				if($row['financialDurationYearPeriodThirdClose']==1){
					return 0;
				} else{
					return 1;
				}
			break;	
			case 4 :
				if($row['financialDurationYearPeriodFourthClose']==1){
					return 0;
				} else{
					return 1;
				}
			break;	
			case 5 :
				if($row['financialDurationYearPeriodFifthClose']==1){
					return 0;
				} else{
					return 1;
				}
			break;	
			case 6 :
				if($row['financialDurationYearPeriodSixClose']==1){
					return 0;
				} else{
					return 1;
				}
			break;	
			case 7 :
				if($row['financialDurationYearPeriodSevenClose']==1){
					return 0;
				} else{
					return 1;
				}
			break;	
			case 8 :
				if($row['financialDurationYearPeriodEigthClose']==1){
					return 0;
				} else{
					return 1;
				}
			break;	
			case 9 :
				if($row['financialDurationYearPeriodNineClose']==1){
					return 0;
				} else{
					return 1;
				}
			break;	
			case 10 :
				if($row['financialDurationYearPeriodTenClose']==1){
					return 0;
				} else{
					return 1;
				}
			break;	
			case 11 :
				if($row['financialDurationYearPeriodElevenClose']==1){
					return 0;
				} else{
					return 1;
				}
			break;	
			case 12 :
				if($row['financialDurationYearPeriodTwelveClose']==1){
					return 0;
				} else{
					return 1;
				}
			break;		
		}
	}
	/**
	 * To check if a key duplicate or not
	 */
	function duplicate() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT	`documentNo`
			FROM 	`generalLedgerJournal`
			WHERE 	`documentNo` 	= 	'" . $this->model->getDocumentNo() . "'
			AND		`isActive`		=	1";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[documentNo]
			FROM 	[generalLedgerJournal]
			WHERE 	[documentNo] 	= 	'" . $this->model->getDocumentNo() . "'
			AND		[isActive]		=	1";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	DOCUMENTNO
			FROM 	GENERALLEDGERJOURNAL
			WHERE 	DOCUMENTNO 	= 	'" . $this->model->getDocumentNo() . "'
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	DOCUMENTNO
			FROM 	GENERALLEDGERJOURNAL
			WHERE 	DOCUMENTNO 	= 	'" . $this->model->getDocumentNo() . "'
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	DOCUMENTNO
			FROM 	GENERALLEDGERJOURNAL
			WHERE 	DOCUMENTNO 	= 	'" . $this->model->getDocumentNo() . "'
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
			echo json_encode(array("success" => true, "total" => $total, "message" => $this->systemString->getDuplicateMessage(), "generalLedgerJournalDesc" => $row ['generalLedgerJournalDesc']));
			exit();
		} else {
			echo json_encode(array("success" => true, "total" => $total, "message" => $this->systemString->getNonDuplicateMessage()));
			exit();
		}
	}
	/**
	 * To ensure Master Form and Detail Transaction are equal
	 */
	function masterDetailChecking(){
		$sqlMaster="
		
			SELECT `generalLedgerJournalAmount` as total
			FROM 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournal`
			WHERE   `generalLedgerJournal`.`generalLedgerJournalId`='".$this->model->getGeneralLedgerJournalId(0,'single')."'
		";
		$resultMaster = $this->q->fast($sqlMaster);
		$rowMaster = $this->q->fetchArray($resultMaster);
		$master = $rowMaster['total'];
		
		$sqlDetail="	
			SELECT `generalLedgerJournalDetailAmount` as total
			FROM 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournalDetail`
			WHERE   `generalLedgerJournalDetail`.`generalLedgerJournalId`='".$this->model->getGeneralLedgerJournalId(0,'single')."'
		
		";
		$resultDetail = $this->q->fast($sqlDetail);
		$rowDetail = $this->q->fetchArray($resultDetail);
		$detail = $rowDetail['total'];
		return ($master - $detail);
	}
	/**
	 * To check Total Chart Of Account Categoris  Equal Both Side  So can Post  To General Ledger
	 * @return number
	 */
	function trialBalanceChecking(){
		// sum all asset amount
		$sqlAsset="
		SELECT 	SUM(`generalLedgerJournalDetailAmount`) as `total`
		FROM 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournalDetail`
		JOIN	`".$this->q->getFinancialDatabase()."`.`generalLedgerChartOfAccount`
		USING	(`generalLedgerChartOfAccountId`)
		WHERE	`generalLedgerChartOfAccount`.`isActive`=1
		AND		`generalLedgerChartOfAccount`.`generalLedgerChartOfAccountCategoryId`=1  
		AND		`generalLedgerJournalDetail`.`isActive`=1 
		WHERE   `generalLedgerJournalDetail`.`generalLedgerJournalId`='".$this->model->getGeneralLedgerJournalId(0,'single')."'";
		$resultAsset = $this->q->fast($sql);
		$rowAsset  = $this->q->fetchArray($resultAsset);
		$asset 	 	= $row['total'];
		// sum all liability amount
		$sqlLiability="
		SELECT 	SUM(`generalLedgerJournalDetailAmount`) as `total`
		FROM 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournalDetail`
		JOIN	`".$this->q->getFinancialDatabase()."`.`generalLedgerChartOfAccount`
		USING	(`generalLedgerChartOfAccountId`)
		WHERE	`generalLedgerChartOfAccount`.`isActive`=1
		AND		`generalLedgerChartOfAccount`.`generalLedgerChartOfAccountCategoryId`=2 
		AND		`generalLedgerJournalDetail`.`isActive`=1 
		WHERE   `generalLedgerJournalDetail`.`generalLedgerJournalId`='".$this->model->getGeneralLedgerJournalId(0,'single')."'";
		$resultLiability = $this->q->fast($sqlLiability);
		$rowLiability  = $this->q->fetchArray($resultLiability);
		$liability 	 	= $row['total'];
		// sum all income amount
		$sqlIncome="
		SELECT 	SUM(`generalLedgerJournalDetailAmount`) as `total`
		FROM 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournalDetail`
		JOIN	`".$this->q->getFinancialDatabase()."`.`generalLedgerChartOfAccount`
		USING	(`generalLedgerChartOfAccountId`)
		WHERE	`generalLedgerChartOfAccount`.`isActive`=1
		AND		`generalLedgerChartOfAccount`.`generalLedgerChartOfAccountCategoryId`=3  
		AND		`generalLedgerJournalDetail`.`isActive`=1 
		WHERE   `generalLedgerJournalDetail`.`generalLedgerJournalId`='".$this->model->getGeneralLedgerJournalId(0,'single')."'";
		$resultIncome = $this->q->fast($sqlIncome);
		$rowIncome  = $this->q->fetchArray($resultIncome);
		$income 	 	= $row['total'];
		// sum all expenses amount
		$sqlExpenses="
		SELECT 	SUM(`generalLedgerJournalDetailAmount`) as `total`
		FROM 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournalDetail`
		JOIN	`".$this->q->getFinancialDatabase()."`.`generalLedgerChartOfAccount`
		USING	(`generalLedgerChartOfAccountId`)
		WHERE	`generalLedgerChartOfAccount`.`isActive`=1
		AND		`generalLedgerChartOfAccount`.`generalLedgerChartOfAccountCategoryId`=4  
		AND		`generalLedgerJournalDetail`.`isActive`=1 
		WHERE   `generalLedgerJournalDetail`.`generalLedgerJournalId`='".$this->model->getGeneralLedgerJournalId(0,'single')."'";
		$resultExpenses= $this->q->fast($sqlExpenses);
		$rowExpenses  = $this->q->fetchArray($resultExpenses);
		$expenses 	 	= $row['total'];
		return(($asset - $liabilty)  + ($income - $expenses));

	}
	/**
	 * To check Total Debit  and Credit  Equal Both Side  So can Post  To General Ledger
	 * @return number
	 */
	function tallyChecking(){
		// sum all debit amount
		$sqlDebit="
		SELECT 	SUM(`generalLedgerJournalDetailAmount`) as `total`
		FROM 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournalDetail`
		JOIN	`".$this->q->getFinancialDatabase()."`.`generalLedgerChartOfAccount`
		USING	(`generalLedgerChartOfAccountId`)
		WHERE	`generalLedgerChartOfAccount`.`isActive`=1
		AND		`generalLedgerJournalDetail`.`transactionMode`='D'
		AND		`generalLedgerJournalDetail`.`isActive`=1 
		WHERE   `generalLedgerJournalDetail`.`generalLedgerJournalId`='".$this->model->getGeneralLedgerJournalId(0,'single')."'";
		$resultDebit = $this->q->fast($sqlDebit);
		$rowDebit  = $this->q->fetchArray($resultDebit);
		$debit 	 	= $rowDebit['total'];
		// sum all credit amount
		$sqlAsset="
		SELECT 	SUM(`generalLedgerJournalDetailAmount`) as `total`
		FROM 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournalDetail`
		JOIN	`".$this->q->getFinancialDatabase()."`.`generalLedgerChartOfAccount`
		USING	(`generalLedgerChartOfAccountId`)
		WHERE	`generalLedgerChartOfAccount`.`isActive`=1
		AND		`generalLedgerJournalDetail`.`transactionMode`='C'
		AND		`generalLedgerJournalDetail`.`isActive`=1 
		WHERE   `generalLedgerJournalDetail`.`generalLedgerJournalId`='".$this->model->getGeneralLedgerJournalId(0,'single')."'";
		$resultCredit = $this->q->fast($sqlCredit);
		$rowCredit  = $this->q->fetchArray($resultCredit);
		$credit	 	= $rowCredit['total'];
		return ($debit - $credit);
	}
	/**
	 * To Post data To General Ledger
	 */
	function posting() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$sqlGeneralLedgerJournalDetail="
		SELECT 	`generalLedgerJournalDetail`.`generalLedgerJournalDetailId`, 
			   	`generalLedgerJournalDetail`.`generalLedgerJournalId`, 
			   	`generalLedgerJournalDetail`.`generalLedgerChartOfAccountId`, 
			  	`generalLedgerJournalDetail`.`countryId`, 
			  	`generalLedgerJournalDetail`.`transactionMode`, 
			  	`generalLedgerJournalDetail`.`generalLedgerJournalDetailAmount` AS `generalLedgerLocalAmount`,  
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
			    `generalLedgerJournal`.`documentNo`,
			    `generalLedgerJournal`.`generalLedgerJournalTitle` AS `generalLedgerTitle`,  
			    `generalLedgerJournal`.`generalLedgerJournalDesc` AS `generalLedgerDesc`,
				`generalLedgerJournal`.`generalLedgerJournalDate` AS `generalLedgerDate`,
				`generalLedgerChartOfAccount`.`generalLedgerChartOfAccountId`,
				`generalLedgerChartOfAccount`.`generalLedgerChartOfAccountNo`,
				`generalLedgerChartOfAccount`.`generalLedgerChartOfAccountCategoryId`,
				`generalLedgerChartOfAccount`.`generalLedgerChartOfAccountTypeId`,
				`generalLedgerChartOfAccount`.`generalLedgerChartOfAccountDesc`,
				`country`.`countryCurrencyCode`,
				`generalLedgerChartOfAccountCategory`.`generalLedgerChartOfAccountCategoryDesc`,
				`generalLedgerChartOfAccountType`.`generalLedgerChartOfAccountTypeDesc`       
		FROM 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournalDetail`
		JOIN	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournal`
		USING	(`generalLedgerJournalId`) 
		JOIN	`".$this->q->getFinancialDatabase()."`.`country`
		USING	(`countryId`)
		JOIN	`".$this->q->getFinancialDatabase()."`.`generalLedgerChartOfAccountCategory`
		JOIN	`".$this->q->getFinancialDatabase()."`.`generalLedgerChartOfAccountType`
		USING	(`generalLedgerChartOfAccountCategoryId`)
		JOIN	`".$this->q->getFinancialDatabase()."`.`generalLedgerChartOfAccount`
		USING	(`generalLedgerChartOfAccountId`,`generalLedgerChartOfAccountCategoryId`,`generalLedgerChartOfAccountTypeId`)
		WHERE  `generalLedgerJournalDetail`.`generalLedgerJournalId`='".$this->model->getGeneralLedgerJournalId(0,'single')."'";
		//echo "<br>--------".$sqlGeneralLedgerJournalDetail."-------";
		$resultGeneralLedgerJournalDetail=$this->q->fast($sqlGeneralLedgerJournalDetail);
		while($row = $this->q->fetchArray($resultGeneralLedgerJournalDetail)) {
			$row['isDefault']=0;
			$row['isNew']=1;
			$row['isDraft']=0;
			$row['isUpdate']=0;
			$row['isDelete']=0;
			$row['isActive']=1;
			$row['isApproved']=0;
			$row['isReview']=0;
			$row['isPost']=0;
			$sqlGeneralLedger="
			INSERT INTO `".$this->q->getFinancialDatabase()."`.`generalLedger`
			(
				`generalLedgerId`, 
				`documentNo`,
				`generalLedgerTitle`, 
				`generalLedgerDesc`, 
				`generalLedgerDate`, 
				`countryId`, 
				`countryCurrencyCode`, 
				`transactionMode`, 
				`generalLedgerForeignAmount`, 
				`generalLedgerLocalAmount`, 
				`generalLedgerChartOfAccountCategoryId`,
				`generalLedgerChartOfAccountCategoryDesc`,  
				`generalLedgerChartOfAccountTypeId`,
				`generalLedgerChartOfAccountTypeDesc`, 
				`generalLedgerChartOfAccountId`, 
				`generalLedgerChartOfAccountNo`, 
				`generalLedgerChartOfAccountDesc`, 
				`businessPartnerId`, 
				`businessPartnerDesc`, 
				`isDefault`, 
				`isNew`, 
				`isDraft`, 
				`isUpdate`, 
				`isDelete`, 
				`isActive`, 
				`isApproved`, 
				`isReview`, 
				`isPost`, 
				`isAuthorized`, 
				`executeBy`, 
				`executeTime`
			) VALUES (
			null,
				'".$row['documentNo']."',
				'".$row['generalLedgerTitle']."', 
				'".$row['generalLedgerDesc']."', 
				'".$row['generalLedgerDate']."', 
				'".$row['countryId']."',
				'".$row['countryCurrencyCode']."',
				'".$row['transactionMode']."', 
				'".$row['generalLedgerForeignAmount']."',
				'".$row['generalLedgerLocalAmount']."', 
				'".$row['generalLedgerChartOfAccountCategoryId']."',
				'".$row['generalLedgerChartOfAccountCategoryDesc']."', 
				'".$row['generalLedgerChartOfAccountTypeId']."',
				'".$row['generalLedgerChartOfAccountTypeDesc']."', 
				'".$row['generalLedgerChartOfAccountId']."', 
				'".$row['generalLedgerChartOfAccountNo']."', 
				'".$row['generalLedgerChartOfAccountDesc']."', 
				'".$row['businessPartnerId']."',
				'".$row['businessPartnerDesc']."', 
				'".$row['isDefault']."', 
				'".$row['isNew']."', 
				'".$row['isDraft']."', 
				'".$row['isUpdate']."', 
				'".$row['isDelete']."', 
				'".$row['isActive']."', 
				'".$row['isApproved']."', 
				'".$row['isReview']."', 
				'".$row['isPost']."', 
				'".$row['isAuthorized']."',
				'".$row['executeBy']."',
				'".$row['executeTime']."'
			)";
			
			$this->q->create($sqlGeneralLedger);
			if ($this->q->execute == 'fail') {
				echo json_encode(array("success" => false, "message" => $this->q->responce));
				exit();
			}
		}
		/*
		 * Update The main Master Table isPost =1
		 */
		$sqlGeneralLedgerJournal="
		UPDATE 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournal` 
		SET 	`isPost`=1 
		WHERE 	`generalLedgerJournalId`='".$this->model->getGeneralLedgerJournalId(0, 'single')."'";
		$this->q->update($sqlGeneralLedgerJournal);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		/*
		 * Update The main Detail Table isPost =1
		 */
		$sqlGeneralLedgerJournal="
		UPDATE 	`".$this->q->getFinancialDatabase()."`.`generalLedgerJournalDetail` 
		SET 	`isPost`=1 
		WHERE 	`generalLedgerJournalId`='".$this->model->getGeneralLedgerJournalId(0, 'single')."'";
		$this->q->update($sqlGeneralLedgerJournal);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		
		$this->q->commit();

		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array(	"success" => true,
					"message" => $this->systemString->getPostingMessage(),
					"time"=>$time));
		exit();
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
			$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, 'a' . $row ['generalLedgerJournalDesc']);
			$loopRow++;
			$lastRow = 'C' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename = "generalLedgerJournal" . rand(0, 10000000) . ".xlsx";
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

$generalLedgerJournalObject = new GeneralLedgerJournalClass ();

/**
 * crud -create,read,update,delete
 * */
if (isset($_POST ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_POST ['leafId'])) {
		$generalLedgerJournalObject->setLeafId($_POST ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$generalLedgerJournalObject->setIsAdmin($_POST ['isAdmin']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$generalLedgerJournalObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$generalLedgerJournalObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Filtering
	 */
	if (isset($_POST ['query'])) {
		$generalLedgerJournalObject->setFieldQuery($_POST ['query']);
	}
	if (isset($_POST ['filter'])) {
		$generalLedgerJournalObject->setGridQuery($_POST ['filter']);
	}
	if (isset($_POST ['character'])) {
		$generalLedgerJournalObject->setCharacterQuery($_POST['character']);
	}
	if (isset($_POST ['dateRangeStart'])) {
		$generalLedgerJournalObject->setDateRangeStartQuery($_POST['dateRangeStart']);
	}
	if (isset($_POST ['dateRangeEnd'])) {
		$generalLedgerJournalObject->setDateRangeEndQuery($_POST['dateRangeEnd']);
	}
	if (isset($_POST ['dateRangeType'])) {

		$generalLedgerJournalObject->setDateRangeTypeQuery($_POST['dateRangeType']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST ['order'])) {
		$generalLedgerJournalObject->setOrder($_POST ['order']);
	}
	if (isset($_POST ['sortField'])) {
		$generalLedgerJournalObject->setSortField($_POST ['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$generalLedgerJournalObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$generalLedgerJournalObject->create();
	}
	if ($_POST ['method'] == 'save') {
		$generalLedgerJournalObject->update();
	}
	if ($_POST ['method'] == 'read') {
		$generalLedgerJournalObject->read();
	}
	if ($_POST ['method'] == 'delete') {
		$generalLedgerJournalObject->delete();
	}
	if($_POST['method'] == 'posting'){
		$generalLedgerJournalObject->posting();
	}
}
if (isset($_GET ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_GET ['leafId'])) {
		$generalLedgerJournalObject->setLeafId($_GET ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET ['isAdmin'])) {
		$generalLedgerJournalObject->setIsAdmin($_GET ['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$generalLedgerJournalObject->execute();
	if (isset($_GET ['field'])) {
		if ($_GET ['field'] == 'staffId') {
			$generalLedgerJournalObject->staff();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$generalLedgerJournalObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET ['generalLedgerJournalDesc'])) {
		if (strlen($_GET ['generalLedgerJournalDesc']) > 0) {
			$generalLedgerJournalObject->duplicate();
		}
	}
	/**
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$generalLedgerJournalObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$generalLedgerJournalObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$generalLedgerJournalObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$generalLedgerJournalObject->lastRecord('json');
		}
	}
	/*
	 * Excel Reporting
	 */
	if (isset($_GET ['mode'])) {
		if ($_GET ['mode'] == 'excel') {
			$generalLedgerJournalObject->excel();
		}
	}
}
?>
