<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/ordersModel.php");

/**
 * this is orders setting files.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @subpackage orders
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class OrdersClass extends ConfigClass {

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

		$this->model = new OrdersModel ();
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
			INSERT INTO `northwindgood`.`orders`
					(
						`northwindgood`.`orders`.`employeesId`,	 	 
						`northwindgood`.`orders`.`customersId`,	 	 
						`northwindgood`.`orders`.`ordersDate`, 	 	 
						`northwindgood`.`orders`.`ordersShippedDate`, 	 
						`northwindgood`.`orders`.`shipperId`,
						`northwindgood`.`orders`.`ordersShipName`,	 	 
						`northwindgood`.`orders`.`ordersShipAddress`,	 	 
						`northwindgood`.`orders`.`ordersShipCity`, 
						`northwindgood`.`orders`.`ordersShipState`, 	 
						`northwindgood`.`orders`.`ordersShipPostCode`,	 	 
						`northwindgood`.`orders`.`ordersShipCountry`, 	 
						`northwindgood`.`orders`.`ordersShippingFee`, 	 
						`northwindgood`.`orders`.`ordersTaxes`,
						`northwindgood`.`orders`.`ordersPaymentType`,	 	 
						`northwindgood`.`orders`.`ordersPaidDate`, 
						`northwindgood`.`orders`.`ordersNotes`, 
						`northwindgood`.`orders`.`ordersTaxRate`, 	 
						`northwindgood`.`orders`.`ordersTaxStatusId`,	 	 
						`northwindgood`.`orders`.`ordersStatusId`,
						
						`northwindgood`.`orders`.`isDefault`,
						`northwindgood`.`orders`.`isNew`,													`northwindgood`.`orders`.`isDraft`,
						`northwindgood`.`orders`.`isUpdate`,													`northwindgood`.`orders`.`isDelete`,
						`northwindgood`.`orders`.`isActive`,													`northwindgood`.`orders`.`isApproved`,
						`northwindgood`.`orders`.`isReview`,                      		  	 				`northwindgood`.`orders`.`isPost`,
						`northwindgood`.`orders`.`executeBy`,												`northwindgood`.`orders`.`executeTime`
					)
			VALUES
					(
						'" . $this->model->getEmployeeId() . "',
						'" . $this->model->getCustomerId() . "',
						'" . $this->model->getOrdersDate() . "',
						'" . $this->model->getOrdersShippedDate() . "',
						'" . $this->model->getShipperId() . "',
						'" . $this->model->getOrdersShipName() . "',
						'" . $this->model->getOrdersShipAddress() . "',
						'" . $this->model->getOrdersShipCity() . "',
						'" . $this->model->getOrdersShipState() . "',
						'" . $this->model->getOrdersShipPostCode() . "',
						'" . $this->model->getOrdersShipCountry() . "',
						'" . $this->model->getOrdersShippingFee() . "',
						'" . $this->model->getOrdersTaxes() . "',
						'" . $this->model->getOrdersPaymentType() . "',
						'" . $this->model->getOrdersPaidDate() . "',
						'" . $this->model->getOrdersNotes() . "',
						'" . $this->model->getOrdersTaxRate() . "',
						'" . $this->model->getOrdersTaxStatusId() . "',
						'" . $this->model->getOrdersStatusId() . "',		
															
												'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
             			'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			INSERT INTO [orders]
					(
						[employeesId],
						[customersId],
						[ordersDate],
						[ordersShippedDate], 
						[shipperId],
						[ordersShipName],	 	 
						[ordersShipAddress],	 	 
						[ordersShipCity], 
						[ordersShipState], 	 
						[ordersShipPostCode],	 	 
						[ordersShipCountry], 	 
						[ordersShippingFee], 	 
						[ordersTaxes],
						[ordersPaymentType],	 	 
						[ordersPaidDate], 
						[ordersNotes], 
						[ordersTaxRate], 	 
						[ordersTaxStatusId],	 	 
						[ordersStatusId],												
						
						[isDefault],
						[isNew],														[isDraft],
						[isUpdate],														[isDelete],
						[isActive],														[isApproved],
						[isReview],														[isPost],
						[executeBy],													[executeTime]
					)
			VALUES
					(
						'" . $this->model->getEmployeeId() . "',
						'" . $this->model->getCustomerId() . "',
						'" . $this->model->getOrdersDate() . "',
						'" . $this->model->getOrdersShippedDate() . "',
						'" . $this->model->getShipperId() . "',
						'" . $this->model->getOrdersShipName() . "',
						'" . $this->model->getOrdersShipAddress() . "',
						'" . $this->model->getOrdersShipCity() . "',
						'" . $this->model->getOrdersShipState() . "',
						'" . $this->model->getOrdersShipPostCode() . "',
						'" . $this->model->getOrdersShipCountry() . "',
						'" . $this->model->getOrdersShippingFee() . "',
						'" . $this->model->getOrdersTaxes() . "',
						'" . $this->model->getOrdersPaymentType() . "',
						'" . $this->model->getOrdersPaidDate() . "',
						'" . $this->model->getOrdersNotes() . "',
						'" . $this->model->getOrdersTaxRate() . "',
						'" . $this->model->getOrdersTaxStatusId() . "',
						'" . $this->model->getOrdersStatusId() . "',					
												'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',				'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',			'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',			'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',			'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',						" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::ORACLE) {

			$sql = "
			INSERT INTO	ORDERS
					(
						EMPLOYEESID,
						CUSTOMERSID,
						ORDERSDATE,
						ORDERSSHIPPEDDATE,
						SHIPPERID,
						ORDERSSHIPNAME,
						ORDERSSHIPADDRESS, 
						ORDERSSHIPCITY,
						ORDERSSHIPSTATE,
						ORDERSSHIPPOSTCODE,
						ORDERSSHIPCOUNTRY,
						ORDERSSHIPPINGFEE,
						ORDERSTAXES,
						ORDERSPAYMENTTYPE,	 
						ORDERSPAIDDATE,
						ORDERSNOTES,
						ORDERSTAXRATE,
						ORDERSTAXSTATUSID,
						ORDERSSTATUSID,
																		ISDEFAULT,
						ISNEW,														ISDRAFT,
						ISUPDATE,													ISDELETE,
						ISACTIVE,													ISAPPROVED,
						ISREVIEW,													ISPOST,
						EXECUTEBY,													EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getEmployeeId() . "',
						'" . $this->model->getCustomerId() . "',
						'" . $this->model->getOrdersDate() . "',
						'" . $this->model->getOrdersShippedDate() . "',
						'" . $this->model->getShipperId() . "',
						'" . $this->model->getOrdersShipName() . "',
						'" . $this->model->getOrdersShipAddress() . "',
						'" . $this->model->getOrdersShipCity() . "',
						'" . $this->model->getOrdersShipState() . "',
						'" . $this->model->getOrdersShipPostCode() . "',
						'" . $this->model->getOrdersShipCountry() . "',
						'" . $this->model->getOrdersShippingFee() . "',
						'" . $this->model->getOrdersTaxes() . "',
						'" . $this->model->getOrdersPaymentType() . "',
						'" . $this->model->getOrdersPaidDate() . "',
						'" . $this->model->getOrdersNotes() . "',
						'" . $this->model->getOrdersTaxRate() . "',
						'" . $this->model->getOrdersTaxStatusId() . "',
						'" . $this->model->getOrdersStatusId() . "',				
											'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',						
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					)";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			INSERT INTO	ORDERS
			(
						EMPLOYEESID,
						CUSTOMERSID,
						ORDERSDATE,
						ORDERSSHIPPEDDATE,
						SHIPPERID,
						ORDERSSHIPNAME,
						ORDERSSHIPADDRESS, 
						ORDERSSHIPCITY,
						ORDERSSHIPSTATE,
						ORDERSSHIPPOSTCODE,
						ORDERSSHIPCOUNTRY,
						ORDERSSHIPPINGFEE,
						ORDERSTAXES,
						ORDERSPAYMENTTYPE,	 
						ORDERSPAIDDATE,
						ORDERSNOTES,
						ORDERSTAXRATE,
						ORDERSTAXSTATUSID,
						ORDERSSTATUSID,												ISDEFAULT,
			ISNEW,														ISDRAFT,
			ISUPDATE,													ISDELETE,
			ISACTIVE,													ISAPPROVED,
			ISREVIEW,													ISPOST,
			EXECUTEBY,													EXECUTETIME
			)
			VALUES
			(
			'" . $this->model->getEmployeeId() . "',
						'" . $this->model->getCustomerId() . "',
						'" . $this->model->getOrdersDate() . "',
						'" . $this->model->getOrdersShippedDate() . "',
						'" . $this->model->getShipperId() . "',
						'" . $this->model->getOrdersShipName() . "',
						'" . $this->model->getOrdersShipAddress() . "',
						'" . $this->model->getOrdersShipCity() . "',
						'" . $this->model->getOrdersShipState() . "',
						'" . $this->model->getOrdersShipPostCode() . "',
						'" . $this->model->getOrdersShipCountry() . "',
						'" . $this->model->getOrdersShippingFee() . "',
						'" . $this->model->getOrdersTaxes() . "',
						'" . $this->model->getOrdersPaymentType() . "',
						'" . $this->model->getOrdersPaidDate() . "',
						'" . $this->model->getOrdersNotes() . "',
						'" . $this->model->getOrdersTaxRate() . "',
						'" . $this->model->getOrdersTaxStatusId() . "',
						'" . $this->model->getOrdersStatusId() . "',				
											'" . $this->model->getIsDefault(0, 'single') . "',
			'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
			'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
			'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
			'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',
			'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
			)";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			INSERT INTO	ORDERS
			(
						EMPLOYEESID,
						CUSTOMERSID,
						ORDERSDATE,
						ORDERSSHIPPEDDATE,
						SHIPPERID,
						ORDERSSHIPNAME,
						ORDERSSHIPADDRESS, 
						ORDERSSHIPCITY,
						ORDERSSHIPSTATE,
						ORDERSSHIPPOSTCODE,
						ORDERSSHIPCOUNTRY,
						ORDERSSHIPPINGFEE,
						ORDERSTAXES,
						ORDERSPAYMENTTYPE,	 
						ORDERSPAIDDATE,
						ORDERSNOTES,
						ORDERSTAXRATE,
						ORDERSTAXSTATUSID,
						ORDERSSTATUSID,												ISDEFAULT,
			ISNEW,														ISDRAFT,
			ISUPDATE,													ISDELETE,
			ISACTIVE,													ISAPPROVED,
			ISREVIEW,													ISPOST,
			EXECUTEBY,													EXECUTETIME
			)
			VALUES
			(
			'" . $this->model->getEmployeeId() . "',
						'" . $this->model->getCustomerId() . "',
						'" . $this->model->getOrdersDate() . "',
						'" . $this->model->getOrdersShippedDate() . "',
						'" . $this->model->getShipperId() . "',
						'" . $this->model->getOrdersShipName() . "',
						'" . $this->model->getOrdersShipAddress() . "',
						'" . $this->model->getOrdersShipCity() . "',
						'" . $this->model->getOrdersShipState() . "',
						'" . $this->model->getOrdersShipPostCode() . "',
						'" . $this->model->getOrdersShipCountry() . "',
						'" . $this->model->getOrdersShippingFee() . "',
						'" . $this->model->getOrdersTaxes() . "',
						'" . $this->model->getOrdersPaymentType() . "',
						'" . $this->model->getOrdersPaidDate() . "',
						'" . $this->model->getOrdersNotes() . "',
						'" . $this->model->getOrdersTaxRate() . "',
						'" . $this->model->getOrdersTaxStatusId() . "',
						'" . $this->model->getOrdersStatusId() . "',				
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
		$ordersId = $this->q->lastInsertId();
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success" => true, "message" =>  $this->systemString->getCreateMessage(), "ordersId" => $ordersId));
		exit();
	}

	/* (non-PHPdoc)
	 * @see config::read()
	 */

	public function read() {
		header('Content-Type:application/json; charset=utf-8');
		if ($this->getIsAdmin() == 0) {
			if ($this->q->vendor == self::MYSQL) {
				$this->auditFilter = "	`orders`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[orders].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	ORDERS.ISACTIVE	=	1	";
			} else if ($this->q->vendor == self::DB2) {
				$this->auditFilter = "	ORDERS.ISACTIVE	=	1	";
			} else if ($this->q->vendor == self::POSTGRESS) {
				$this->auditFilter = "	ORDERS.ISACTIVE	=	1	";
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
			SELECT		`orders`.`ordersId`,
						`orders`.`employeesId`,	 	 
						`orders`.`customersId`,	 	 
						`orders`.`ordersDate`, 	 	 
						`orders`.`ordersShippedDate`, 	 
						`orders`.`shipperId`,
						`orders`.`ordersShipName`,	 	 
						`orders`.`ordersShipAddress`,	 	 
						`orders`.`ordersShipCity`, 
						`orders`.`ordersShipState`, 	 
						`orders`.`ordersShipPostCode`,	 	 
						`orders`.`ordersShipCountry`,
						`orders`.`ordersShippingFee`, 	 
						`orders`.`ordersTaxes`,
						`orders`.`ordersPaymentType`,	 	 
						`orders`.`ordersPaidDate`, 
						`orders`.`ordersNotes`, 
						`orders`.`ordersTaxRate`, 	 
						`orders`.`ordersTaxStatusId`,	 	 
						`orders`.`ordersStatusId`,
						`staff`.`staffName`
			FROM 	`orders`
			JOIN	`staff`
			ON		`orders`.`executeBy` = `staff`.`staffId`
			WHERE 	 " . $this->auditFilter;
			if ($this->model->getOrdersId(0, 'single')) {
				$sql .= " AND `" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`='" . $this->model->getOrdersId(0, 'single') . "'";
			}
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[orders].[ordersId],
					[orders].[employeesId],
					[orders].[customersId],
					[orders].[ordersDate],
					[orders].[ordersShippedDate], 
					[orders].[shipperId],
					[orders].[ordersShipName],	 	 
					[orders].[ordersShipAddress],	 	 
					[orders].[ordersShipCity], 
					[orders].[ordersShipState], 	 
					[orders].[ordersShipPostCode],	 	 
					[orders].[ordersShipCountry], 	 
					[orders].[ordersShippingFee], 	 
					[orders].[ordersTaxes],
					[orders].[ordersPaymentType],	 	 
					[orders].[ordersPaidDate], 
					[orders].[ordersNotes], 
					[orders].[ordersTaxRate], 	 
					[orders].[ordersTaxStatusId],	 	 
					[orders].[ordersStatusId],
						[staff].[staffName]
			FROM 	[orders]
			JOIN		[staff]
			ON		[orders].[executeBy] = [staff].[staffId]
			WHERE 	" . $this->auditFilter;
			if ($this->model->getOrdersId(0, 'single')) {
				$sql .= " AND [" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]='" . $this->model->getOrdersId(0, 'single') . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT		ORDERS.ORDERSID   		 	AS 	\"ordersId\",					
						ORDERS.EMPLOYEESID			AS 	\"employeesId\",
						ORDERS.CUSTOMERSID			AS 	\"customersId\",
						ORDERS.ORDERSDATE			AS 	\"ordersDate\",
						ORDERS.ORDERSSHIPPEDDATE	AS 	\"ordersShippedDate\",
						ORDERS.SHIPPERID			AS	\"shipperId\",
						ORDERS.ORDERSSHIPNAME 		AS	\"ordersShipName\",
						ORDERS.ORDERSSHIPADDRESS	AS	\"ordersShipAddress\",
						ORDERS.ORDERSSHIPCITY		AS	\"ordersShipCity\", 
						ORDERS.ORDERSSHIPSTATE		AS	\"ordersShipState\",
						ORDERS.ORDERSSHIPPOSTCODE	AS	\"ordersShipPostCode\",
						ORDERS.ORDERSSHIPCOUNTRY	AS	\"ordersShipCountry\",
						ORDERS.ORDERSSHIPPINGFEE	AS	\"ordersShippingFee\", 
						ORDERS.ORDERSTAXES			AS	\"ordersTaxes\",
						ORDERS.ORDERSPAYMENTTYPE 	AS	\"ordersPaymentType\",
						ORDERS.ORDERSPAIDDATE		AS	\"ordersPaidDate\",
						ORDERS.ORDERSNOTES			AS	\"ordersNotes\", 
						ORDERS.ORDERSTAXRATE		AS	\"ordersTaxRate\", 
						ORDERS.ORDERSTAXSTATUSID	AS	\"ordersTaxStatusId\",
						ORDERS.ORDERSSTATUSID		AS	\"ordersStatusId\",				
						
						ORDERS.ISDEFAULT    			AS	\"isDefault\",
						ORDERS.ISNEW		  			AS	\"isNew\",
						ORDERS.ISDRAFT	  				AS	\"isDraft\",
						ORDERS.ISUPDATE     			AS	\"isUpdate\",
						ORDERS.ISDELETE	  			AS	\"isDelete\",
						ORDERS.ISACTIVE	  			AS	\"isActive\",
						ORDERS.ISAPPROVED   			AS	\"isApproved\",
						ORDERS.ISREVIEW	  			AS	\"isReview\",
						ORDERS.ISPOST  	  			AS	\"isPost\",
						ORDERS.EXECUTEBY    			AS	\"executeBy\",
						ORDERS.EXECUTETIME  			AS	\"executeTime\",
						STAFF.STAFFNAME		  			AS	\"staffName\"	
			FROM 		ORDERS
			JOIN		STAFF
			ON			ORDERS.EXECUTEBY 	  	=	STAFF.STAFFID
			WHERE 	" . $this->auditFilter;
			if ($this->model->getOrdersId(0, 'single')) {
				$sql .= " AND " . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "='" . $this->model->getOrdersId(0, 'single') . "'";
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
		$filterArray = array('ordersId');
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array('orders');
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
							WITH [ordersDerived] AS
							(
								SELECT 		[orders].[ordersId],
											[orders].[employeesId],
											[orders].[customersId],
											[orders].[ordersDate],
											[orders].[ordersShippedDate], 
											[orders].[shipperId],
											[orders].[ordersShipName],	 	 
											[orders].[ordersShipAddress],	 	 
											[orders].[ordersShipCity], 
											[orders].[ordersShipState], 	 
											[orders].[ordersShipPostCode],	 	 
											[orders].[ordersShipCountry], 	 
											[orders].[ordersShippingFee], 	 
											[orders].[ordersTaxes],
											[orders].[ordersPaymentType],	 	 
											[orders].[ordersPaidDate], 
											[orders].[ordersNotes], 
											[orders].[ordersTaxRate], 	 
											[orders].[ordersTaxStatusId],	 	 
											[orders].[ordersStatusId],
											
											[orders].[isDefault],
											[orders].[isNew],
											[orders].[isDraft],
											[orders].[isUpdate],
											[orders].[isDelete],
											[orders].[isApproved],
											[orders].[isReview],
											[orders].[isPost],
											[orders].[executeBy],
											[orders].[executeTime],
											[staff].[staffName],
								ROW_NUMBER() OVER (ORDER BY [ordersId]) AS 'RowNumber'
								FROM 	[orders]
								JOIN		[staff]
								ON		[orders].[executeBy] = [staff].[staffId]
								WHERE " . $this->auditFilter . $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[ordersDerived]
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
								SELECT	ORDERS.ORDERSID   		AS 	\"ordersId\",
										ORDERS.EMPLOYEESID			AS 	\"employeesId\",
										ORDERS.CUSTOMERSID			AS 	\"customersId\",
										ORDERS.ORDERSDATE			AS 	\"ordersDate\",
										ORDERS.ORDERSSHIPPEDDATE	AS 	\"ordersShippedDate\",
										ORDERS.SHIPPERID			AS	\"shipperId\",
										ORDERS.ORDERSSHIPNAME 		AS	\"ordersShipName\",
										ORDERS.ORDERSSHIPADDRESS	AS	\"ordersShipAddress\",
										ORDERS.ORDERSSHIPCITY		AS	\"ordersShipCity\", 
										ORDERS.ORDERSSHIPSTATE		AS	\"ordersShipState\",
										ORDERS.ORDERSSHIPPOSTCODE	AS	\"ordersShipPostCode\",
										ORDERS.ORDERSSHIPCOUNTRY	AS	\"ordersShipCountry\",
										ORDERS.ORDERSSHIPPINGFEE	AS	\"ordersShippingFee\", 
										ORDERS.ORDERSTAXES			AS	\"ordersTaxes\",
										ORDERS.ORDERSPAYMENTTYPE 	AS	\"ordersPaymentType\",
										ORDERS.ORDERSPAIDDATE		AS	\"ordersPaidDate\",
										ORDERS.ORDERSNOTES			AS	\"ordersNotes\", 
										ORDERS.ORDERSTAXRATE		AS	\"ordersTaxRate\", 
										ORDERS.ORDERSTAXSTATUSID	AS	\"ordersTaxStatusId\",
										ORDERS.ORDERSSTATUSID		AS	\"ordersStatusId\",	
										
										ORDERS.ISDEFAULT    		AS	\"isDefault\",
										ORDERS.ISNEW		  		AS	\"isNew\",
										ORDERS.ISDRAFT	 			AS	\"isDraft\",
										ORDERS.ISUPDATE     		AS	\"isUpdate\",
										ORDERS.ISDELETE	  		AS	\"isDelete\",
										ORDERS.ISACTIVE	  		AS	\"isActive\",
										ORDERS.ISAPPROVED   		AS	\"isApproved\",
										ORDERS.ISREVIEW	  		AS 	\"isReview\",
										ORDERS.ISPOST		  		AS	\"isPost\",
										ORDERS.EXECUTEBY    		AS	\"executeBy\",
										ORDERS.EXECUTETIME  		AS	\"executeTime\",
										STAFF.STAFFNAME		  		AS	\"staffName\"	
								FROM 	ORDERS
								JOIN	STAFF
								ON		ORDERS.EXECUTEBY 	  	=	STAFF.STAFFID
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
		if (!($this->model->getOrdersId(0, 'single'))) {
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
		if ($this->model->getOrdersId(0, 'single')) {
			$json_encode = json_encode(array('success' => true, 'total' => $total, 'message' =>  $this->systemString->getReadMessage(), 'data' => $items, 'firstRecord' => $this->recordSet->firstRecord('value'), 'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getOrdersId(0, 'single')), 'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getOrdersId(0, 'single')), 'lastRecord' => $this->recordSet->lastRecord('value')));
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
			WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getOrdersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[" . $this->model->getTableName() . "]
			WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getOrdersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getOrdersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getOrdersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getOrdersId(0, 'single') . "' ";
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
				UPDATE		`orders`
				SET 		
							`employeesId`	 	 	=	'" . $this->model->getEmployeeId() . "',
							`customersId`	 	 	=	'" . $this->model->getCustomerId() . "',
							`ordersDate` 	 	 	=	'" . $this->model->getOrdersDate() . "',
							`ordersShippedDate` 	=	'" . $this->model->getOrdersShippedDate(). "', 
							`shipperId`				=	'" . $this->model->getShipperId() . "',
							`ordersShipName`	 	=	'" . $this->model->getOrdersShipName() . "', 
							`ordersShipAddress`	 	=	'" . $this->model->getOrdersShipAddress() . "', 
							`ordersShipCity` 		=	'" . $this->model->getOrdersShipCity() . "',
							`ordersShipState` 	 	=	'" . $this->model->getOrdersShipState() . "',
							`ordersShipPostCode`	=	'" . $this->model->getOrdersShipPostCode() . "', 	 
							`ordersShipCountry`		=	'" . $this->model->getOrdersShipCountry() . "',
							`ordersShippingFee` 	=	'" . $this->model->getOrdersShippingFee() . "', 
							`ordersTaxes`			=	'" . $this->model->getOrdersTaxes() . "',
							`ordersPaymentType`	 	=	'" . $this->model->getOrdersPaymentType() . "', 
							`ordersPaidDate` 		=	'" . $this->model->getOrdersPaidDate() . "',
							`ordersNotes` 			=	'" . $this->model->getOrdersNotes() . "',			
							`ordersTaxRate` 	 	=	'" . $this->model->getOrdersTaxRate() . "',
							`ordersTaxStatusId`	 	=	'" . $this->model->getOrdersTaxStatusId() . "', 
							`ordersStatusId`		=	'" . $this->model->getOrdersStatusId() . "',
				
							`receiptNo`			=	'" . $this->model->getReceiptNo() . "',
							`membershipId`		=	'" . $this->model->getMembershipId() . "',
							`ordersType`		=	'" . $this->model->getOrdersType() . "',
							`ordersDate`		=	'" . $this->model->getOrdersDate() . "',
							`ordersAmount`		=	'" . $this->model->getOrdersAmount() . "',				
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
				WHERE 		`ordersId`		=	'" . $this->model->getOrdersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
				UPDATE 		[orders]
				SET 		[employeesId]	 	 	=	'" . $this->model->getEmployeeId() . "',
							[customersId]	 	 	=	'" . $this->model->getCustomerId() . "',
							[ordersDate] 	 	 	=	'" . $this->model->getOrdersDate() . "',
							[ordersShippedDate] 	=	'" . $this->model->getOrdersShippedDate(). "', 
							[shipperId]				=	'" . $this->model->getShipperId() . "',
							[ordersShipName]	 	=	'" . $this->model->getOrdersShipName() . "', 
							[ordersShipAddress]	 	=	'" . $this->model->getOrdersShipAddress() . "', 
							[ordersShipCity] 		=	'" . $this->model->getOrdersShipCity() . "',
							[ordersShipState] 	 	=	'" . $this->model->getOrdersShipState() . "',
							[ordersShipPostCode]	=	'" . $this->model->getOrdersShipPostCode() . "', 	 
							[ordersShipCountry]		=	'" . $this->model->getOrdersShipCountry() . "',
							[ordersShippingFee] 	=	'" . $this->model->getOrdersShippingFee() . "', 
							[ordersTaxes]			=	'" . $this->model->getOrdersTaxes() . "',
							[ordersPaymentType]	 	=	'" . $this->model->getOrdersPaymentType() . "', 
							[ordersPaidDate] 		=	'" . $this->model->getOrdersPaidDate() . "',
							[ordersNotes] 			=	'" . $this->model->getOrdersNotes() . "',			
							[ordersTaxRate] 	 	=	'" . $this->model->getOrdersTaxRate() . "',
							[ordersTaxStatusId]	 	=	'" . $this->model->getOrdersTaxStatusId() . "', 
							[ordersStatusId]		=	'" . $this->model->getOrdersStatusId() . "',	
							
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
			WHERE 		[ordersId]			=	'" . $this->model->getOrdersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
				UPDATE		ORDERS
				SET 		
							EMPLOYEESID			=	'" . $this->model->getEmployeeId() . "',
							CUSTOMERSID			=	'" . $this->model->getCustomerId() . "',
							ORDERSDATE			=	'" . $this->model->getOrdersDate() . "',
							ORDERSSHIPPEDDATE	=	'" . $this->model->getOrdersShippedDate(). "', 
							SHIPPERID			=	'" . $this->model->getShipperId() . "',
							ORDERSSHIPNAME 		=	'" . $this->model->getOrdersShipName() . "', 
							ORDERSSHIPADDRESS	=	'" . $this->model->getOrdersShipAddress() . "',  
							ORDERSSHIPCITY		=	'" . $this->model->getOrdersShipCity() . "',
							ORDERSSHIPSTATE		=	'" . $this->model->getOrdersShipState() . "',
							ORDERSSHIPPOSTCODE	=	'" . $this->model->getOrdersShipPostCode() . "',
							ORDERSSHIPCOUNTRY	=	'" . $this->model->getOrdersShipCountry() . "',
							ORDERSSHIPPINGFEE	=	'" . $this->model->getOrdersShippingFee() . "',
							ORDERSTAXES			=	'" . $this->model->getOrdersTaxes() . "',
							ORDERSPAYMENTTYPE 	=	'" . $this->model->getOrdersPaymentType() . "', 
							ORDERSPAIDDATE		=	'" . $this->model->getOrdersPaidDate() . "',
							ORDERSNOTES			=	'" . $this->model->getOrdersNotes() . "',
							ORDERSTAXRATE		=	'" . $this->model->getOrdersTaxRate() . "',
							ORDERSTAXSTATUSID	=	'" . $this->model->getOrdersTaxStatusId() . "', 
							ORDERSSTATUSID		=	'" . $this->model->getOrdersStatusId() . "',		
													
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
			WHERE 		ORDERSID		=	'" . $this->model->getOrdersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
			UPDATE	ORDERS
			SET 			EMPLOYEESID			=	'" . $this->model->getEmployeeId() . "',
							CUSTOMERSID			=	'" . $this->model->getCustomerId() . "',
							ORDERSDATE			=	'" . $this->model->getOrdersDate() . "',
							ORDERSSHIPPEDDATE	=	'" . $this->model->getOrdersShippedDate(). "', 
							SHIPPERID			=	'" . $this->model->getShipperId() . "',
							ORDERSSHIPNAME 		=	'" . $this->model->getOrdersShipName() . "', 
							ORDERSSHIPADDRESS	=	'" . $this->model->getOrdersShipAddress() . "',  
							ORDERSSHIPCITY		=	'" . $this->model->getOrdersShipCity() . "',
							ORDERSSHIPSTATE		=	'" . $this->model->getOrdersShipState() . "',
							ORDERSSHIPPOSTCODE	=	'" . $this->model->getOrdersShipPostCode() . "',
							ORDERSSHIPCOUNTRY	=	'" . $this->model->getOrdersShipCountry() . "',
							ORDERSSHIPPINGFEE	=	'" . $this->model->getOrdersShippingFee() . "',
							ORDERSTAXES			=	'" . $this->model->getOrdersTaxes() . "',
							ORDERSPAYMENTTYPE 	=	'" . $this->model->getOrdersPaymentType() . "', 
							ORDERSPAIDDATE		=	'" . $this->model->getOrdersPaidDate() . "',
							ORDERSNOTES			=	'" . $this->model->getOrdersNotes() . "',
							ORDERSTAXRATE		=	'" . $this->model->getOrdersTaxRate() . "',
							ORDERSTAXSTATUSID	=	'" . $this->model->getOrdersTaxStatusId() . "', 
							ORDERSSTATUSID		=	'" . $this->model->getOrdersStatusId() . "',
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
			WHERE 		ORDERSID		=	'" . $this->model->getOrdersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
				UPDATE		ORDERS
				SET 		
							EMPLOYEESID			=	'" . $this->model->getEmployeeId() . "',
							CUSTOMERSID			=	'" . $this->model->getCustomerId() . "',
							ORDERSDATE			=	'" . $this->model->getOrdersDate() . "',
							ORDERSSHIPPEDDATE	=	'" . $this->model->getOrdersShippedDate(). "', 
							SHIPPERID			=	'" . $this->model->getShipperId() . "',
							ORDERSSHIPNAME 		=	'" . $this->model->getOrdersShipName() . "', 
							ORDERSSHIPADDRESS	=	'" . $this->model->getOrdersShipAddress() . "',  
							ORDERSSHIPCITY		=	'" . $this->model->getOrdersShipCity() . "',
							ORDERSSHIPSTATE		=	'" . $this->model->getOrdersShipState() . "',
							ORDERSSHIPPOSTCODE	=	'" . $this->model->getOrdersShipPostCode() . "',
							ORDERSSHIPCOUNTRY	=	'" . $this->model->getOrdersShipCountry() . "',
							ORDERSSHIPPINGFEE	=	'" . $this->model->getOrdersShippingFee() . "',
							ORDERSTAXES			=	'" . $this->model->getOrdersTaxes() . "',
							ORDERSPAYMENTTYPE 	=	'" . $this->model->getOrdersPaymentType() . "', 
							ORDERSPAIDDATE		=	'" . $this->model->getOrdersPaidDate() . "',
							ORDERSNOTES			=	'" . $this->model->getOrdersNotes() . "',
							ORDERSTAXRATE		=	'" . $this->model->getOrdersTaxRate() . "',
							ORDERSTAXSTATUSID	=	'" . $this->model->getOrdersTaxStatusId() . "', 
							ORDERSSTATUSID		=	'" . $this->model->getOrdersStatusId() . "',
				
							RECEIPTNO	=	'" . $this->model->getReceiptNo() . "',
							MEMBERSHIPID		=	'" . $this->model->getMembershipId() . "',
							ORDERSTYPE		=	'" . $this->model->getOrdersType() . "',
							ORDERSDATE		=	'" . $this->model->getOrdersDate() . "',
							ORDERSAMOUNT		=	'" . $this->model->getOrdersAmount() . "',
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
				WHERE 		ORDERSID			=	'" . $this->model->getOrdersId(0, 'single') . "'";
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
			WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getOrdersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[" . $this->model->getTableName() . "]
			WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getOrdersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getOrdersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getOrdersId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getOrdersId(0, 'single') . "' ";
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
				UPDATE 	`orders`
				SET 	`isDefault`			=	'" . $this->model->getIsDefault(0, 'single') . "',
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
				WHERE 	`ordersId`		=	'" . $this->model->getOrdersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
				UPDATE 	[orders]
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
				WHERE 	[ordersId]		=	'" . $this->model->getOrdersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
				UPDATE 	ORDERS
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
				WHERE 	ORDERSID		=	'" . $this->model->getOrdersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
				UPDATE 	ORDERS
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
				WHERE 	ORDERSID		=	'" . $this->model->getOrdersId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
				UPDATE 	ORDERS
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
				WHERE 	ORDERSID		=	'" . $this->model->getOrdersId(0, 'single') . "'";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}
			// advance logging future
			$this->q->tableName = $this->model->getTableName();
			$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
			$this->q->primaryKeyValue = $this->model->getOrdersId(0, 'single');
			$this->q->audit = $this->audit;
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
			SELECT	`customersId`
			FROM 	`orders`
			WHERE 	`customersId` 	=	'" . $this->model->getCustomerId() . "',
			AND		`isActive`		=	1";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[customersId]
			FROM 	[orders]
			WHERE 	[receiptNo] 	=	'" . $this->model->getCustomerId() . "',
			AND		[isActive]		=	1";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	CUSTOMERSID
			FROM 	ORDERS
			WHERE 	CUSTOMERSID			=	'" . $this->model->getCustomerId() . "',
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	CUSTOMERSID
			FROM 	ORDERS
			WHERE 	CUSTOMERSID			=	'" . $this->model->getCustomerId() . "',
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	CUSTOMERSID
			FROM 	ORDERS
			WHERE 	CUSTOMERSID			=	'" . $this->model->getCustomerId() . "',
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
			echo json_encode(array("success" => true, "total" => $total, "message" => $this->systemString->getDuplicateMessage(), "ordersDesc" => $row ['ordersDesc']));
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
			$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, 'a' . $row ['ordersDesc']);
			$loopRow++;
			$lastRow = 'C' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename = "orders" . rand(0, 10000000) . ".xlsx";
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

$ordersObject = new OrdersClass ();

/**
 * crud -create,read,update,delete
 * */
if (isset($_POST ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_POST ['leafId'])) {
		$ordersObject->setLeafId($_POST ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$ordersObject->setIsAdmin($_POST ['isAdmin']);
	}
	/**
	 * Database Request
	 */
	if (isset($_POST ['databaseRequest'])) {
		$ordersObject->setDatabaseRequest($_POST ['databaseRequest']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$ordersObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$ordersObject->setLimit($_POST ['perPage']);
	}
	if (isset($_POST ['character'])) {
		$ordersObject->setCharacterQuery($_POST['character']);
	}
	if (isset($_POST ['dateRangeStart'])) {
		$ordersObject->setDateRangeStartQuery($_POST['dateRangeStart']);
	}
	if (isset($_POST ['dateRangeEnd'])) {
		$ordersObject->setDateRangeEndQuery($_POST['dateRangeEnd']);
	}
	if (isset($_POST ['dateRangeType'])) {
		$ordersObject->setDateRangeTypeQuery($_POST['dateRangeType']);
	}
	/*
	 *  Filtering
	 */
	if (isset($_POST ['query'])) {
		$ordersObject->setFieldQuery($_POST ['query']);
	}
	if (isset($_POST ['filter'])) {
		$ordersObject->setGridQuery($_POST ['filter']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST ['order'])) {
		$ordersObject->setOrder($_POST ['order']);
	}
	if (isset($_POST ['sortField'])) {
		$ordersObject->setSortField($_POST ['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$ordersObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$ordersObject->create();
	}
	if ($_POST ['method'] == 'save') {
		$ordersObject->update();
	}
	if ($_POST ['method'] == 'read') {
		$ordersObject->read();
	}
	if ($_POST ['method'] == 'delete') {
		$ordersObject->delete();
	}
}
if (isset($_GET ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_GET ['leafId'])) {
		$ordersObject->setLeafId($_GET ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET ['isAdmin'])) {
		$ordersObject->setIsAdmin($_GET ['isAdmin']);
	}
	/**
	 * Database Request
	 */
	if (isset($_GET ['databaseRequest'])) {
		$ordersObject->setDatabaseRequest($_GET ['databaseRequest']);
	}
	/*
	 *  Load the dynamic value
	 */
	$ordersObject->execute();
	if (isset($_GET ['field'])) {
		if ($_GET ['field'] == 'staffId') {
			$ordersObject->staff();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$ordersObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET ['ordersDesc'])) {
		if (strlen($_GET ['ordersDesc']) > 0) {
			$ordersObject->duplicate();
		}
	}
	/**
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$ordersObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$ordersObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$ordersObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$ordersObject->lastRecord('json');
		}
	}
	/*
	 * Excel Reporting
	 */
	if (isset($_GET ['mode'])) {
		if ($_GET ['mode'] == 'excel') {
			$ordersObject->excel();
		}
	}
}
?>
