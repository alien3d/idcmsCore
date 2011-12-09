<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/customersModel.php");

/**
 * this is customers setting files.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 *  @package account receivable
 * @subpackage customers
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class CustomersClass extends ConfigClass {

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

		$this->model = new CustomersModel ();
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
		$this->q->setRequestDatabase($this->getRequestDatabase());
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->recordSet = new RecordSet ();
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
		//UTF8
		if ($this->getVendor() == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->create();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			INSERT INTO `northwindgood`.`customers`
					(
						`northwindgood`.`customers`.`customersCompany`,
						`northwindgood`.`customers`.`customersLastName`,
						`northwindgood`.`customers`.`customersFirstName`,
						`northwindgood`.`customers`.`customersEmail`,
						`northwindgood`.`customers`.`customersJobTitle`,
						`northwindgood`.`customers`.`customersBusinessPhone`,
						`northwindgood`.`customers`.`customersHomePhone`,
						`northwindgood`.`customers`.`customersMobilePhone`,
						`northwindgood`.`customers`.`customersFaxNum`,
						`northwindgood`.`customers`.`customersAddress`,
						`northwindgood`.`customers`.`customersCity`,
						`northwindgood`.`customers`.`customersState`,
						`northwindgood`.`customers`.`customersPostcode`,
						`northwindgood`.`customers`.`customersCountry`,
						`northwindgood`.`customers`.`customersWebPage`,
						`northwindgood`.`customers`.`customersNotes`,
						`northwindgood`.`customers`.`customersAttachments,				
						`northwindgood`.`customers`.`isDefault`,
						`northwindgood`.`customers`.`isNew`,													
						`northwindgood`.`customers`.`isDraft`,
						`northwindgood`.`customers`.`isUpdate`,													
						`northwindgood`.`customers`.`isDelete`,
						`northwindgood`.`customers`.`isActive`,													
						`northwindgood`.`customers`.`isApproved`,
						`northwindgood`.`customers`.`isReview`,                      		  	 				
						`northwindgood`.`customers`.`isPost`,
						`northwindgood`.`customers`.`executeBy`,												
						`northwindgood`.`customers`.`executeTime`
					)
			VALUES
					(
						'" . $this->model->getCustomersCompany() . "',					
						'" . $this->model->getCustomersLastName() . "',
						'" . $this->model->getCustomersFirstName() . "',
						'" . $this->model->getCustomersEmail() . "',
						'" . $this->model->getCustomersJobTitle() . "',
						'" . $this->model->getCustomersBusinessPhone() . "',
						'" . $this->model->getCustomersHomePhone() . "',
						'" . $this->model->getCustomersMobilePhone() . "',
						'" . $this->model->getCustomersFaxNum() . "',
						'" . $this->model->getCustomersAddress() . "',
						'" . $this->model->getCustomersCity() . "',
						'" . $this->model->getCustomersState() . "',
						'" . $this->model->getCustomersPostcode() . "',
						'" . $this->model->getCustomersCountry() . "',
						'" . $this->model->getCustomersWebPage() . "',
						'" . $this->model->getCustomersNotes() . "',
						'" . $this->model->getCustomersAttachments() . "',
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
             			'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			INSERT INTO [customers]
					(
						[customersCompany],
						[customersLastName],
						[customersFirstName],
						[customersEmail],
						[customersJobTitle],
						[customersBusinessPhone],
						[customersHomePhone],
						[customersMobilePhone],
						[customersFaxNum],
						[customersAddress],
						[customersCity],
						[customersState],
						[customersPostcode],
						[customersCountry],
						[customersWebPage],
						[customersNotes],
						[customersAttachments],	
						[isDefault],
						[isNew],														[isDraft],
						[isUpdate],														[isDelete],
						[isActive],														[isApproved],
						[isReview],														[isPost],
						[executeBy],													[executeTime]
					)
			VALUES
					(
						'" . $this->model->getCustomersCompany() . "',					
						'" . $this->model->getCustomersLastName() . "',
						'" . $this->model->getCustomersFirstName() . "',
						'" . $this->model->getCustomersEmail() . "',
						'" . $this->model->getCustomersJobTitle() . "',
						'" . $this->model->getCustomersBusinessPhone() . "',
						'" . $this->model->getCustomersHomePhone() . "',
						'" . $this->model->getCustomersMobilePhone() . "',
						'" . $this->model->getCustomersFaxNum() . "',
						'" . $this->model->getCustomersAddress() . "',
						'" . $this->model->getCustomersCity() . "',
						'" . $this->model->getCustomersState() . "',
						'" . $this->model->getCustomersPostcode() . "',
						'" . $this->model->getCustomersCountry() . "',
						'" . $this->model->getCustomersWebPage() . "',
						'" . $this->model->getCustomersNotes() . "',
						'" . $this->model->getCustomersAttachments() . "',				
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',				'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',			'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',			'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',			'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',						" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::ORACLE) {

			$sql = "
			INSERT INTO	CUSTOMERS
					(
						CUSTOMERSCOMPANY,
						CUSTOMERSLASTNAME,
						CUSTOMERSFIRSTNAME,
						CUSTOMERSEMAIL,
						CUSTOMERSJOBTITLE,
						CUSTOMERSBUISNESSPHONE,
						CUSTOMERSHOMEPHONE,
						CUSTOMERSMOBILEPHONE,
						CUSTOMERSFAXNUM,
						CUSTOMERSADDRESS,
						CUSTOMERSCITY,
						CUSTOMERSSTATE,
						CUSTOMERSPOSTCODE,
						CUSTOMERSCOUNTRY,
						CUSTOMERSWEBPAGE,
						CUSTOMERSNOTES,
						CUSTOMERSATTACHMENTS,	
						ISDEFAULT,
						ISNEW,														ISDRAFT,
						ISUPDATE,													ISDELETE,
						ISACTIVE,													ISAPPROVED,
						ISREVIEW,													ISPOST,
						EXECUTEBY,													EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getCustomersCompany() . "',					
						'" . $this->model->getCustomersLastName() . "',
						'" . $this->model->getCustomersFirstName() . "',
						'" . $this->model->getCustomersEmail() . "',
						'" . $this->model->getCustomersJobTitle() . "',
						'" . $this->model->getCustomersBusinessPhone() . "',
						'" . $this->model->getCustomersHomePhone() . "',
						'" . $this->model->getCustomersMobilePhone() . "',
						'" . $this->model->getCustomersFaxNum() . "',
						'" . $this->model->getCustomersAddress() . "',
						'" . $this->model->getCustomersCity() . "',
						'" . $this->model->getCustomersState() . "',
						'" . $this->model->getCustomersPostcode() . "',
						'" . $this->model->getCustomersCountry() . "',
						'" . $this->model->getCustomersWebPage() . "',
						'" . $this->model->getCustomersNotes() . "',
						'" . $this->model->getCustomersAttachments() . "',					
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',						
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					)";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			INSERT INTO	CUSTOMERS
			(					
						CUSTOMERSCOMPANY,
						CUSTOMERSLASTNAME,
						CUSTOMERSFIRSTNAME,
						CUSTOMERSEMAIL,
						CUSTOMERSJOBTITLE,
						CUSTOMERSBUISNESSPHONE,
						CUSTOMERSHOMEPHONE,
						CUSTOMERSMOBILEPHONE,
						CUSTOMERSFAXNUM,
						CUSTOMERSADDRESS,
						CUSTOMERSCITY,
						CUSTOMERSSTATE,
						CUSTOMERSPOSTCODE,
						CUSTOMERSCOUNTRY,
						CUSTOMERSWEBPAGE,
						CUSTOMERSNOTES,
						CUSTOMERSATTACHMENTS,
						ISDEFAULT,
						ISNEW,														ISDRAFT,
						ISUPDATE,													ISDELETE,
						ISACTIVE,													ISAPPROVED,
						ISREVIEW,													ISPOST,
						EXECUTEBY,													EXECUTETIME
			)
			VALUES
			(
						'" . $this->model->getCustomersCompany() . "',					
						'" . $this->model->getCustomersLastName() . "',
						'" . $this->model->getCustomersFirstName() . "',
						'" . $this->model->getCustomersEmail() . "',
						'" . $this->model->getCustomersJobTitle() . "',
						'" . $this->model->getCustomersBusinessPhone() . "',
						'" . $this->model->getCustomersHomePhone() . "',
						'" . $this->model->getCustomersMobilePhone() . "',
						'" . $this->model->getCustomersFaxNum() . "',
						'" . $this->model->getCustomersAddress() . "',
						'" . $this->model->getCustomersCity() . "',
						'" . $this->model->getCustomersState() . "',
						'" . $this->model->getCustomersPostcode() . "',
						'" . $this->model->getCustomersCountry() . "',
						'" . $this->model->getCustomersWebPage() . "',
						'" . $this->model->getCustomersNotes() . "',
						'" . $this->model->getCustomersAttachments() . "',							
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
			)";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			INSERT INTO	CUSTOMERS
			(
						CUSTOMERSCOMPANY,
						CUSTOMERSLASTNAME,
						CUSTOMERSFIRSTNAME,
						CUSTOMERSEMAIL,
						CUSTOMERSJOBTITLE,
						CUSTOMERSBUISNESSPHONE,
						CUSTOMERSHOMEPHONE,
						CUSTOMERSMOBILEPHONE,
						CUSTOMERSFAXNUM,
						CUSTOMERSADDRESS,
						CUSTOMERSCITY,
						CUSTOMERSSTATE,
						CUSTOMERSPOSTCODE,
						CUSTOMERSCOUNTRY,
						CUSTOMERSWEBPAGE,
						CUSTOMERSNOTES,
						CUSTOMERSATTACHMENTS,
						ISDEFAULT,
						ISNEW,														ISDRAFT,
						ISUPDATE,													ISDELETE,
						ISACTIVE,													ISAPPROVED,
						ISREVIEW,													ISPOST,
						EXECUTEBY,													EXECUTETIME
			)
			VALUES
			(
						'" . $this->model->getCustomersCompany() . "',					
						'" . $this->model->getCustomersLastName() . "',
						'" . $this->model->getCustomersFirstName() . "',
						'" . $this->model->getCustomersEmail() . "',
						'" . $this->model->getCustomersJobTitle() . "',
						'" . $this->model->getCustomersBusinessPhone() . "',
						'" . $this->model->getCustomersHomePhone() . "',
						'" . $this->model->getCustomersMobilePhone() . "',
						'" . $this->model->getCustomersFaxNum() . "',
						'" . $this->model->getCustomersAddress() . "',
						'" . $this->model->getCustomersCity() . "',
						'" . $this->model->getCustomersState() . "',
						'" . $this->model->getCustomersPostcode() . "',
						'" . $this->model->getCustomersCountry() . "',
						'" . $this->model->getCustomersWebPage() . "',
						'" . $this->model->getCustomersNotes() . "',
						'" . $this->model->getCustomersAttachments() . "',
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
			)";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}

		$this->q->create($sql);
		$customersId = $this->q->lastInsertId();
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success" => true, "message" =>  $this->systemString->getCreateMessage(), "customersId" => $customersId));
		exit();
	}

	/* (non-PHPdoc)
	 * @see config::read()
	 */

	public function read() {
		header('Content-Type:application/json; charset=utf-8');
		if ($this->getIsAdmin() == 0) {
			if ($this->q->vendor == self::MYSQL) {
				$this->auditFilter = "	`customers`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[customers].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = " CUSTOMERS.ISACTIVE	=	1	";
			} else if ($this->q->vendor == self::DB2) {
				$this->auditFilter = "	CUSTOMERS.ISACTIVE	=	1	";
			} else if ($this->q->vendor == self::POSTGRESS) {
				$this->auditFilter = "	CUSTOMERS.ISACTIVE	=	1	";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}
		} else if ($this->getIsAdmin() == 1) {
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
			SELECT	`customers`.`customersId`,
					`customers`.`customersCompany`,
					`customers`.`customersLastName`,
					`customers`.`customersFirstName`,
					`customers`.`customersEmail`,
					`customers`.`customersJobTitle`,
					`customers`.`customersBusinessPhone`,
					`customers`.`customersHomePhone`,
					`customers`.`customersMobilePhone`,
					`customers`.`customersFaxNum`,
					`customers`.`customersAddress`,
					`customers`.`customersCity`,
					`customers`.`customersState`,
					`customers`.`customersPostcode`,
					`customers`.`customersCountry`,
					`customers`.`customersWebPage`,
					`customers`.`customersNotes`,
					`customers`.`customersAttachments`,						
					`customers`.`isDefault`,
					`customers`.`isNew`,
					`customers`.`isDraft`,
					`customers`.`isUpdate`,
					`customers`.`isDelete`,
					`customers`.`isActive`,
					`customers`.`isApproved`,
					`customers`.`isReview`,
					`customers`.`isPost`,
					`customers`.`executeBy`,
					`customers`.`executeTime`,
					`staff`.`staffName`
			FROM 	`customers`
			JOIN	`staff`
			ON		`customers`.`executeBy` = `staff`.`staffId`
			WHERE 	 " . $this->auditFilter;
			if ($this->model->getCustomersId(0, 'single')) {
				$sql .= " AND `" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`='" . $this->model->getCustomersId(0, 'single') . "'";
			}
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[customers].[customersId],
					[customers].[customersCompany],
					[customers].[customersLastName],
					[customers].[customersFirstName],
					[customers].[customersEmail],
					[customers].[customersJobTitle],
					[customers].[customersBusinessPhone],
					[customers].[customersHomePhone],
					[customers].[customersMobilePhone],
					[customers].[customersFaxNum],
					[customers].[customersAddress],
					[customers].[customersCity],
					[customers].[customersState],
					[customers].[customersPostcode],
					[customers].[customersCountry],
					[customers].[customersWebPage],
					[customers].[customersNotes],
					[customers].[customersAttachments],
					[customers].[isDefault],
					[customers].[isNew],
					[customers].[isDraft],
					[customers].[isUpdate],
					[customers].[isDelete],
					[customers].[isActive],
					[customers].[isApproved],
					[customers].[isReview],
					[customers].[isPost],
					[customers].[executeBy],
					[customers].[executeTime],
					[staff].[staffName]
			FROM 	[customers]
			JOIN	[staff]
			ON		[customers].[executeBy] = [staff].[staffId]
			WHERE 	" . $this->auditFilter;
			if ($this->model->getCustomersId(0, 'single')) {
				$sql .= " AND [" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]='" . $this->model->getCustomersId(0, 'single') . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT		CUSTOMERS.CUSTOMERSID   		 	AS 	\"customersId\",
						CUSTOMERS.CUSTOMERSCOMPANY			AS 	\"customersCompany\",
						CUSTOMERS.CUSTOMERSLASTNAME			AS 	\"customersLastName\",
						CUSTOMERS.CUSTOMERSFIRSTNAME		AS 	\"customersFirstName\",
						CUSTOMERS.CUSTOMERSEMAIL			AS 	\"customersEmail\",
						CUSTOMERS.CUSTOMERSJOBTITLE			AS 	\"customersJobTitle\",
						CUSTOMERS.CUSTOMERSBUISNESSPHONE	AS 	\"customersBusinessPhone\",
						CUSTOMERS.CUSTOMERSHOMEPHONE		AS 	\"customersHomePhone\",
						CUSTOMERS.CUSTOMERSMOBILEPHONE		AS 	\"customersMobilePhone\",
						CUSTOMERS.CUSTOMERSFAXNUM			AS 	\"customersFaxNum\",
						CUSTOMERS.CUSTOMERSADDRESS			AS 	\"customersAddress\",
						CUSTOMERS.CUSTOMERSCITY				AS 	\"customersCity\",
						CUSTOMERS.CUSTOMERSSTATE			AS 	\"customersState\",
						CUSTOMERS.CUSTOMERSPOSTCODE			AS 	\"customersPostcode\",
						CUSTOMERS.CUSTOMERSCOUNTRY			AS 	\"customersCountry\",
						CUSTOMERS.CUSTOMERSWEBPAGE			AS 	\"customersWebPage\",
						CUSTOMERS.CUSTOMERSNOTES			AS 	\"customersNotes\",
						CUSTOMERS.CUSTOMERSATTACHMENTS		AS 	\"customersAttachments\",					
						CUSTOMERS.ISDEFAULT    				AS	\"isDefault\",
						CUSTOMERS.ISNEW		  				AS	\"isNew\",
						CUSTOMERS.ISDRAFT	  				AS	\"isDraft\",
						CUSTOMERS.ISUPDATE     				AS	\"isUpdate\",
						CUSTOMERS.ISDELETE	  				AS	\"isDelete\",
						CUSTOMERS.ISACTIVE	  				AS	\"isActive\",
						CUSTOMERS.ISAPPROVED   				AS	\"isApproved\",
						CUSTOMERS.ISREVIEW	  				AS	\"isReview\",
						CUSTOMERS.ISPOST  	  				AS	\"isPost\",
						CUSTOMERS.EXECUTEBY    				AS	\"executeBy\",
						CUSTOMERS.EXECUTETIME  				AS	\"executeTime\",
						STAFF.STAFFNAME		  				AS	\"staffName\"	
			FROM 		CUSTOMERS
			JOIN		STAFF
			ON			CUSTOMERS.EXECUTEBY 	  	=	STAFF.STAFFID
			WHERE 	" . $this->auditFilter;
			if ($this->model->getCustomersId(0, 'single')) {
				$sql .= " AND " . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "='" . $this->model->getCustomersId(0, 'single') . "'";
			}
		} else if ($this->q->vendor == self::DB2) {

		} else if ($this->q->vendor == self::POSTGRESS) {

		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array('customersId');
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array('customers');
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
							WITH [customersDerived] AS
							(
								SELECT 		[customers].[customersId],
											[customers].[customersCompany],
											[customers].[customersLastName],
											[customers].[customersFirstName],
											[customers].[customersEmail],
											[customers].[customersJobTitle],
											[customers].[customersBusinessPhone],
											[customers].[customersHomePhone],
											[customers].[customersMobilePhone],
											[customers].[customersFaxNum],
											[customers].[customersAddress],
											[customers].[customersCity],
											[customers].[customersState],
											[customers].[customersPostcode],
											[customers].[customersCountry],
											[customers].[customersWebPage],
											[customers].[customersNotes],
											[customers].[customersAttachments],					
											[customers].[isDefault],
											[customers].[isNew],
											[customers].[isDraft],
											[customers].[isUpdate],
											[customers].[isDelete],
											[customers].[isApproved],
											[customers].[isReview],
											[customers].[isPost],
											[customers].[executeBy],
											[customers].[executeTime],
											[staff].[staffName],
								ROW_NUMBER() OVER (ORDER BY [customersId]) AS 'RowNumber'
								FROM 	[customers]
								JOIN		[staff]
								ON		[customers].[executeBy] = [staff].[staffId]
								WHERE " . $this->auditFilter . $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[customersDerived]
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
								SELECT	CUSTOMERS.CUSTOMERSID   			AS 	\"customersId\",
										CUSTOMERS.CUSTOMERSCOMPANY			AS 	\"customersCompany\",
										CUSTOMERS.CUSTOMERSLASTNAME			AS 	\"customersLastName\",
										CUSTOMERS.CUSTOMERSFIRSTNAME		AS 	\"customersFirstName\",
										CUSTOMERS.CUSTOMERSEMAIL			AS 	\"customersEmail\",
										CUSTOMERS.CUSTOMERSJOBTITLE			AS 	\"customersJobTitle\",
										CUSTOMERS.CUSTOMERSBUISNESSPHONE	AS 	\"customersBusinessPhone\",
										CUSTOMERS.CUSTOMERSHOMEPHONE		AS 	\"customersHomePhone\",
										CUSTOMERS.CUSTOMERSMOBILEPHONE		AS 	\"customersMobilePhone\",
										CUSTOMERS.CUSTOMERSFAXNUM			AS 	\"customersFaxNum\",
										CUSTOMERS.CUSTOMERSADDRESS			AS 	\"customersAddress\",
										CUSTOMERS.CUSTOMERSCITY				AS 	\"customersCity\",
										CUSTOMERS.CUSTOMERSSTATE			AS 	\"customersState\",
										CUSTOMERS.CUSTOMERSPOSTCODE			AS 	\"customersPostcode\",
										CUSTOMERS.CUSTOMERSCOUNTRY			AS 	\"customersCountry\",
										CUSTOMERS.CUSTOMERSWEBPAGE			AS 	\"customersWebPage\",
										CUSTOMERS.CUSTOMERSNOTES			AS 	\"customersNotes\",
										CUSTOMERS.CUSTOMERSATTACHMENTS		AS 	\"customersAttachments\",										
										CUSTOMERS.ISDEFAULT    		AS	\"isDefault\",
										CUSTOMERS.ISNEW		  		AS	\"isNew\",
										CUSTOMERS.ISDRAFT	 		AS	\"isDraft\",
										CUSTOMERS.ISUPDATE     		AS	\"isUpdate\",
										CUSTOMERS.ISDELETE	  		AS	\"isDelete\",
										CUSTOMERS.ISACTIVE	  		AS	\"isActive\",
										CUSTOMERS.ISAPPROVED   		AS	\"isApproved\",
										CUSTOMERS.ISREVIEW	  		AS 	\"isReview\",
										CUSTOMERS.ISPOST		  		AS	\"isPost\",
										CUSTOMERS.EXECUTEBY    		AS	\"executeBy\",
										CUSTOMERS.EXECUTETIME  		AS	\"executeTime\",
										STAFF.STAFFNAME		  		AS	\"staffName\"	
								FROM 	CUSTOMERS
								JOIN	STAFF
								ON		CUSTOMERS.EXECUTEBY 	  	=	STAFF.STAFFID
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
		if (!($this->model->getCustomersId(0, 'single'))) {
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
		if ($this->model->getCustomersId(0, 'single')) {
			$json_encode = json_encode(array('success' => true, 'total' => $total, 'message' =>  $this->systemString->getReadMessage(), 'data' => $items, 'firstRecord' => $this->recordSet->firstRecord('value'), 'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getCustomersId(0, 'single')), 'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getCustomersId(0, 'single')), 'lastRecord' => $this->recordSet->lastRecord('value')));
			$json_encode = str_replace("[", "", $json_encode);
			$json_encode = str_replace("]", "", $json_encode);
			echo $json_encode;
		} else {
			if (count($items) == 0) {
				$items = '';
			}
			echo json_encode(array('success' => true, 'total' => $total, 'message' =>  $this->systemString->getReadMessage(), 'data' => $items));
			exit();
		}
	}

	/* (non-PHPdoc)
	 * @see config::update()
	 */

	function update() {
		header('Content-Type:application/json; charset=utf-8');
		//UTF8
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
			SELECT	`" . $this->model->getPrimaryKeyName() . "`
			FROM 	`" . $this->model->getTableName() . "`
			WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getCustomersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[" . $this->model->getTableName() . "]
			WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getCustomersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getCustomersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getCustomersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getCustomersId(0, 'single') . "' ";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		$result = $this->q->fast($sql);
		$total = $this->q->numberRows($result, $sql);
		if ($total == 0) {
			echo json_encode(array("success" => false, "message" => $this->systemString->getRecordNotFound()));
			exit();
		} else {
			if ($this->getVendor() == self::MYSQL) {
				$sql = "
				UPDATE		`northwindgood`.`customers`
				SET 		`northwindgood`.`customers`.`customersCompany`			=	'" . $this->model->getCustomersCompany() . "',
							`northwindgood`.`customers`.`customersLastName`			=	'" . $this->model->getCustomersLastName() . "',
							`northwindgood`.`customers`.`customersFirstName`		=	'" . $this->model->getCustomersFirstName() . "',
							`northwindgood`.`customers`.`customersEmail`			=	'" . $this->model->getCustomersEmail() . "',
							`northwindgood`.`customers`.`customersJobTitle`			=	'" . $this->model->getCustomersJobTitle() . "',
							`northwindgood`.`customers`.`customersBusinessPhone`	=	'" . $this->model->getCustomersBusinessPhone() . "',
							`northwindgood`.`customers`.`customersHomePhone`		=	'" . $this->model->getCustomersHomePhone() . "',
							`northwindgood`.`customers`.`customersMobilePhone`		=	'" . $this->model->getCustomersMobilePhone() . "',
							`northwindgood`.`customers`.`customersFaxNum`			=	'" . $this->model->getCustomersFaxNum() . "',
							`northwindgood`.`customers`.`customersAddress`			=	'" . $this->model->getCustomersAddress() . "',
							`northwindgood`.`customers`.`customersCity`				=	'" . $this->model->getCustomersCity() . "',
							`northwindgood`.`customers`.`customersState`			=	'" . $this->model->getCustomersState() . "',
							`northwindgood`.`customers`.`customersPostcode`			=	'" . $this->model->getCustomersPostcode() . "',
							`northwindgood`.`customers`.`customersCountry`			=	'" . $this->model->getCustomersCountry() . "',
							`northwindgood`.`customers`.`customersWebPage`			=	'" . $this->model->getCustomersWebPage() . "',
							`northwindgood`.`customers`.`customersNotes`			=	'" . $this->model->getCustomersNotes() . "',
							`northwindgood`.`customers`.`customersAttachments`		=	'" . $this->model->getCustomersAttachments() . "',								
							`northwindgood`.`customers`.`isDefault`			=	'" . $this->model->getIsDefault(0, 'single') . "',
							`northwindgood`.`customers`.`isNew`				=	'" . $this->model->getIsNew(0, 'single') . "',
							`northwindgood`.`customers`.`isDraft`			=	'" . $this->model->getIsDraft(0, 'single') . "',
							`northwindgood`.`customers`.`isUpdate`			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							`northwindgood`.`customers`.`isDelete`			=	'" . $this->model->getIsDelete(0, 'single') . "',
							`northwindgood`.`customers`.`isActive`			=	'" . $this->model->getIsActive(0, 'single') . "',
							`northwindgood`.`customers`.`isApproved`		=	'" . $this->model->getIsApproved(0, 'single') . "',
							`northwindgood`.`customers`.`isReview`			=	'" . $this->model->getIsReview(0, 'single') . "',
							`northwindgood`.`customers`.`isPost`			=	'" . $this->model->getIsPost(0, 'single') . "',
							`northwindgood`.`customers`.`executeBy`			=	'" . $this->model->getExecuteBy() . "',
							`northwindgood`.`customers`.`executeTime`		=	" . $this->model->getExecuteTime() . "
				WHERE 		`northwindgood`.`customers`.`customersId`		=	'" . $this->model->getCustomersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
				UPDATE 		[customers]
				SET 		[customersCompany]			=	'" . $this->model->getCustomersCompany() . "',
							[customersLastName]			=	'" . $this->model->getCustomersLastName() . "',
							[customersFirstName]		=	'" . $this->model->getCustomersFirstName() . "',
							[customersEmail]			=	'" . $this->model->getCustomersEmail() . "',
							[customersJobTitle]			=	'" . $this->model->getCustomersJobTitle() . "',
							[customersBusinessPhone]	=	'" . $this->model->getCustomersBusinessPhone() . "',
							[customersHomePhone]		=	'" . $this->model->getCustomersHomePhone() . "',
							[customersMobilePhone]		=	'" . $this->model->getCustomersMobilePhone() . "',
							[customersFaxNum]			=	'" . $this->model->getCustomersFaxNum() . "',
							[customersAddress]			=	'" . $this->model->getCustomersAddress() . "',
							[customersCity]				=	'" . $this->model->getCustomersCity() . "',
							[customersState]			=	'" . $this->model->getCustomersState() . "',
							[customersPostcode]			=	'" . $this->model->getCustomersPostcode() . "',
							[customersCountry]			=	'" . $this->model->getCustomersCountry() . "',
							[customersWebPage]			=	'" . $this->model->getCustomersWebPage() . "',
							[customersNotes]			=	'" . $this->model->getCustomersNotes() . "',
							[customersAttachments]		=	'" . $this->model->getCustomersAttachments() . "',								
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
			WHERE 		[customersId]			=	'" . $this->model->getCustomersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
				UPDATE		CUSTOMERS
				SET 		CUSTOMERSCOMPANY 			=	'" . $this->model->getCustomersCompany() . "',	
							CUSTOMERSLASTNAME			=	'" . $this->model->getCustomersLastName() . "',
							CUSTOMERSFIRSTNAME			=	'" . $this->model->getCustomersFirstName() . "',
							CUSTOMERSEMAIL				=	'" . $this->model->getCustomersEmail() . "',
							CUSTOMERSJOBTITLE			=	'" . $this->model->getCustomersJobTitle() . "',
							CUSTOMERSBUISNESSPHONE		=	'" . $this->model->getCustomersBusinessPhone() . "',
							CUSTOMERSHOMEPHONE			=	'" . $this->model->getCustomersHomePhone() . "',
							CUSTOMERSMOBILEPHONE		=	'" . $this->model->getCustomersBirthday() . "',
							CUSTOMERSFAXNUM				=	'" . $this->model->getCustomersFaxNum() . "',
							CUSTOMERSADDRESS			=	'" . $this->model->getCustomersAddress() . "',
							CUSTOMERSCITY				=	'" . $this->model->getCustomersCity() . "',
							CUSTOMERSSTATE				=	'" . $this->model->getCustomersState() . "',
							CUSTOMERSPOSTCODE			=	'" . $this->model->getCustomersPostcode() . "',
							CUSTOMERSCOUNTRY			=	'" . $this->model->getCustomersCountry() . "',
							CUSTOMERSWEBPAGE			=	'" . $this->model->getCustomersWebPage() . "',
							CUSTOMERSNOTES				=	'" . $this->model->getCustomersNotes() . "',
							CUSTOMERSATTACHMENTS		=	'" . $this->model->getCustomersAttachments() . "',						
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
			WHERE 		CUSTOMERSID		=	'" . $this->model->getCustomersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
			UPDATE	CUSTOMERS
			SET 			CUSTOMERSCOMPANY 			=	'" . $this->model->getCustomersCompany() . "',	
							CUSTOMERSLASTNAME			=	'" . $this->model->getCustomersLastName() . "',
							CUSTOMERSFIRSTNAME			=	'" . $this->model->getCustomersFirstName() . "',
							CUSTOMERSEMAIL				=	'" . $this->model->getCustomersEmail() . "',
							CUSTOMERSJOBTITLE			=	'" . $this->model->getCustomersJobTitle() . "',
							CUSTOMERSBUISNESSPHONE		=	'" . $this->model->getCustomersBusinessPhone() . "',
							CUSTOMERSHOMEPHONE			=	'" . $this->model->getCustomersHomePhone() . "',
							CUSTOMERSMOBILEPHONE		=	'" . $this->model->getCustomersBirthday() . "',
							CUSTOMERSFAXNUM				=	'" . $this->model->getCustomersFaxNum() . "',
							CUSTOMERSADDRESS			=	'" . $this->model->getCustomersAddress() . "',
							CUSTOMERSCITY				=	'" . $this->model->getCustomersCity() . "',
							CUSTOMERSSTATE				=	'" . $this->model->getCustomersState() . "',
							CUSTOMERSPOSTCODE			=	'" . $this->model->getCustomersPostcode() . "',
							CUSTOMERSCOUNTRY			=	'" . $this->model->getCustomersCountry() . "',
							CUSTOMERSWEBPAGE			=	'" . $this->model->getCustomersWebPage() . "',
							CUSTOMERSNOTES				=	'" . $this->model->getCustomersNotes() . "',
							CUSTOMERSATTACHMENTS		=	'" . $this->model->getCustomersAttachments() . "',						
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
			WHERE 		CUSTOMERSID		=	'" . $this->model->getCustomersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
				UPDATE		CUSTOMERS
					SET 	CUSTOMERSCOMPANY 			=	'" . $this->model->getCustomersCompany() . "',	
							CUSTOMERSLASTNAME			=	'" . $this->model->getCustomersLastName() . "',
							CUSTOMERSFIRSTNAME			=	'" . $this->model->getCustomersFirstName() . "',
							CUSTOMERSEMAIL				=	'" . $this->model->getCustomersEmail() . "',
							CUSTOMERSJOBTITLE			=	'" . $this->model->getCustomersJobTitle() . "',
							CUSTOMERSBUISNESSPHONE		=	'" . $this->model->getCustomersBusinessPhone() . "',
							CUSTOMERSHOMEPHONE			=	'" . $this->model->getCustomersHomePhone() . "',
							CUSTOMERSMOBILEPHONE		=	'" . $this->model->getCustomersBirthday() . "',
							CUSTOMERSFAXNUM				=	'" . $this->model->getCustomersFaxNum() . "',
							CUSTOMERSADDRESS			=	'" . $this->model->getCustomersAddress() . "',
							CUSTOMERSCITY				=	'" . $this->model->getCustomersCity() . "',
							CUSTOMERSSTATE				=	'" . $this->model->getCustomersState() . "',
							CUSTOMERSPOSTCODE			=	'" . $this->model->getCustomersPostcode() . "',
							CUSTOMERSCOUNTRY			=	'" . $this->model->getCustomersCountry() . "',
							CUSTOMERSWEBPAGE			=	'" . $this->model->getCustomersWebPage() . "',
							CUSTOMERSNOTES				=	'" . $this->model->getCustomersNotes() . "',
							CUSTOMERSATTACHMENTS		=	'" . $this->model->getCustomersAttachments() . "',						
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
				WHERE 		CUSTOMERSID			=	'" . $this->model->getCustomersId(0, 'single') . "'";
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
		echo json_encode(array(	"success" => true,"message" => $this->systemString->getUpdateMessage(),"time"=>$time));
		exit();
	}

	/* (non-PHPdoc)
	 * @see config::delete()
	 */

	function delete() {
		header('Content-Type:application/json; charset=utf-8');
		//UTF8
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
			FROM 	`" . $this->model->getTableName() . "`
			WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getCustomersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[" . $this->model->getTableName() . "]
			WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getCustomersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getCustomersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getCustomersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getCustomersId(0, 'single') . "' ";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		$result = $this->q->fast($sql);
		$total = $this->q->numberRows($result, $sql);
		if ($total == 0) {
			echo json_encode(array("success" => false, "message" => $this->systemString->getRecordNotFound()));
			exit();
		} else {
			if ($this->getVendor() == self::MYSQL) {
				$sql = "
				UPDATE 	`northwindgood`.`customers`
				SET 	`northwindgood`.`customers`.`isDefault`			=	'" . $this->model->getIsDefault(0, 'single') . "',
						`northwindgood`.`customers`.`isNew`				=	'" . $this->model->getIsNew(0, 'single') . "',
						`northwindgood`.`customers`.`isDraft`			=	'" . $this->model->getIsDraft(0, 'single') . "',
						`northwindgood`.`customers`.`isUpdate`			=	'" . $this->model->getIsUpdate(0, 'single') . "',
						`northwindgood`.`customers`.`isDelete`			=	'" . $this->model->getIsDelete(0, 'single') . "',
						`northwindgood`.`customers`.`isActive`			=	'" . $this->model->getIsActive(0, 'single') . "',
						`northwindgood`.`customers`.`isApproved`		=	'" . $this->model->getIsApproved(0, 'single') . "',
						`northwindgood`.`customers`.`isReview`			=	'" . $this->model->getIsReview(0, 'single') . "',
						`northwindgood`.`customers`.`isPost`			=	'" . $this->model->getIsPost(0, 'single') . "',
						`northwindgood`.`customers`.`executeBy`			=	'" . $this->model->getExecuteBy() . "',
						`northwindgood`.`customers`.`executeTime`		=	" . $this->model->getExecuteTime() . "
				WHERE 	`northwindgood`.`customers`.`customersId`		=	'" . $this->model->getCustomersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
				UPDATE 	[customers]
				SET 	[isDefault]			=	'" . $this->model->getIsDefault(0, 'single') . "',
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
				WHERE 	[customersId]		=	'" . $this->model->getCustomersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
				UPDATE 	CUSTOMERS
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
				WHERE 	CUSTOMERSID		=	'" . $this->model->getCustomersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
				UPDATE 	CUSTOMERS
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
				WHERE 	CUSTOMERSID		=	'" . $this->model->getCustomersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
				UPDATE 	CUSTOMERS
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
				WHERE 	CUSTOMERSID		=	'" . $this->model->getCustomersId(0, 'single') . "'";
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
		echo json_encode(array(	"success" => true,"message" => $this->systemString->getDeleteMessage(),"time"=>$time));
		exit();
	}

	/**
	 * To Update flag Status
	 */
	function updateStatus() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$loop = $this->model->getTotal();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			UPDATE `iCore`.`" . $this->model->getTableName() . "`
			SET";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			UPDATE 	[iCore].[" . $this->model->getTableName() . "]
			SET 	";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			UPDATE ICORE." . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			UPDATE ICORE." . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			UPDATE ICORE." . strtoupper($this->model->getTableName()) . "
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
		foreach ($access as $systemCheck) {

			switch ($systemCheck) {
				case 'isDefault' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDefault($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." .strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsDefault($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isNew' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsNew($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`."  . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) .  " = CASE ICORE." .strtoupper($this->model->getTableName()). strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) .  " = CASE ICORE." .strtoupper($this->model->getTableName()). strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) .  " = CASE ICORE." .strtoupper($this->model->getTableName()). strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsNew($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isDraft' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDraft($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) .  " = CASE ICORE." .strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) .  " = CASE ICORE." .strtoupper($this->model->getTableName()). strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) .  " = CASE ICORE." .strtoupper($this->model->getTableName()). strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsDraft($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isUpdate' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsUpdate($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) .  " = CASE ICORE." .strtoupper($this->model->getTableName()). strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) .  " = CASE ICORE." .strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) .  " = CASE ICORE." .strtoupper($this->model->getTableName()). strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();

							}
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsUpdate($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isDelete' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDelete($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) .  " = CASE ICORE." .strtoupper($this->model->getTableName()). strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) .  " = CASE ICORE." .strtoupper($this->model->getTableName()). strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsDelete($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isActive' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsActive($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsActive($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isApproved' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsApproved($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsApproved($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isReview' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsReview($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
                            WHEN '" . $this->model->getReligionId($i, 'array') . "'
                            THEN '" . $this->model->getIsReview($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isPost' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsPost($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
                                WHEN '" . $this->model->getReligionId($i, 'array') . "'
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
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array(	"success" => true,
        			"message" => $message,
            		"time"=>$time)
		);
		exit();
	}

	/**
	 * To check if a key duplicate or not
	 */
	function duplicate() {
		header('Content-Type:application/json; charset=utf-8');
		if ($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT	`northwindgood`.`customers`.`customersId`
			FROM 	`northwindgood`.`customers`
			WHERE 	`northwindgood`.`customers`.`customersId` 	= 	'" . $this->model->getCustomersId() . "'
			AND		`northwindgood`.`customers`.`isActive`		=	1";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[customersId]
			FROM 	[customers]
			WHERE 	[customersId] 	= 	'" . $this->model->getCustomersId() . "'
			AND		[isActive]		=	1";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	CUSTOMERSID
			FROM 	CUSTOMERS
			WHERE 	CUSTOMERSID 	= 	'" . $this->model->getCustomersId() . "'
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	CUSTOMERSID
			FROM 	CUSTOMERS
			WHERE 	CUSTOMERSID 	= 	'" . $this->model->getCustomersId() . "'
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	CUSTOMERSID
			FROM 	CUSTOMERS
			WHERE 	CUSTOMERSID 	= 	'" . $this->model->getCustomersId() . "'
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
			echo json_encode(array("success" => true, "total" => $total, "message" => $this->systemString->getDuplicateMessage(), "customersDesc" => $row ['customersDesc']));
			exit();
		} else {
			echo json_encode(array("success" => true, "total" => $total, "message" => $this->systemString->getNonDuplicateMessage()));
			exit();
		}
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
		//UTF8
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
			$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, 'a' . $row ['customersDesc']);
			$loopRow++;
			$lastRow = 'C' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename = "customers" . rand(0, 10000000) . ".xlsx";
		$path = $_SERVER ['DOCUMENT_ROOT'] . "/" . $this->application . "/basic/document/excel/" . $filename;
		$this->documentTrail->create_trail($this->leafId, $path, $filename);
		$objWriter->save($path);
		$file = fopen($path, 'r');
		if ($file) {
			echo json_encode(array("success" => 'TRUE', "message" => $this->systemString->getFileGenerateMessage(), "filename" => $filename));
			exit();
		} else {
			echo json_encode(array("success" => 'FALSE', "message" => $this->systemString->getFileNotGenerateMessage()));
			exit();
		}
	}

}

$customersObject = new CustomersClass ();

/**
 * crud -create,read,update,delete
 * */
if (isset($_POST ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_POST ['leafId'])) {
		$customersObject->setLeafId($_POST ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$customersObject->setIsAdmin($_POST ['isAdmin']);
	}
	/**
	 * Database Request
	 */
	if (isset($_POST ['databaseRequest'])) {
		$customersObject->setDatabaseRequest($_POST ['databaseRequest']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$customersObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$customersObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Filtering
	 */
	if (isset($_POST ['query'])) {
		$customersObject->setFieldQuery($_POST ['query']);
	}
	if (isset($_POST ['filter'])) {
		$customersObject->setGridQuery($_POST ['filter']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST ['order'])) {
		$customersObject->setOrder($_POST ['order']);
	}
	if (isset($_POST ['sortField'])) {
		$customersObject->setSortField($_POST ['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$customersObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$customersObject->create();
	}
	if ($_POST ['method'] == 'save') {
		$customersObject->update();
	}
	if ($_POST ['method'] == 'read') {
		$customersObject->read();
	}
	if ($_POST ['method'] == 'delete') {
		$customersObject->delete();
	}
}
if (isset($_GET ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_GET ['leafId'])) {
		$customersObject->setLeafId($_GET ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET ['isAdmin'])) {
		$customersObject->setIsAdmin($_GET ['isAdmin']);
	}
	/**
	 * Database Request
	 */
	if (isset($_GET ['databaseRequest'])) {
		$customersObject->setDatabaseRequest($_GET ['databaseRequest']);
	}
	/*
	 *  Load the dynamic value
	 */
	$customersObject->execute();
	if (isset($_GET ['field'])) {
		if ($_GET ['field'] == 'staffId') {
			$customersObject->staff();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$customersObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET ['customersDesc'])) {
		if (strlen($_GET ['customersDesc']) > 0) {
			$customersObject->duplicate();
		}
	}
	/**
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$customersObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$customersObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$customersObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$customersObject->lastRecord('json');
		}
	}
	/*
	 * Excel Reporting
	 */
	if (isset($_GET ['mode'])) {
		if ($_GET ['mode'] == 'excel') {
			$customersObject->excel();
		}
	}
}
?>
