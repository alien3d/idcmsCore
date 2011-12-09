<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/businessPartnerModel.php");

/**
 * this is businessPartner setting files.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 *  @package account receivable
 * @subpackage businessPartner
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class BusinesspartnerClass extends ConfigClass {

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
	 * System String Message.
	 * @var string $systemString;
	 */
	public $systemString;
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

		$this->model = new BusinessPartnerModel ();
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
			INSERT INTO `businessPartner`
					(
						`businessPartnerCompany`,
						`businessPartnerLastName`,
						`businessPartnerFirstName`,
						`businessPartnerEmail`,
						`businessPartnerJobTitle`,
						`businessPartnerBusinessPhone`,
						`businessPartnerHomePhone`,
						`businessPartnerMobilePhone`,
						`businessPartnerFaxNum`,
						`businessPartnerAddress`,
						`businessPartnerCity`,
						`businessPartnerState`,
						`businessPartnerPostcode`,
						`businessPartnerCountry`,
						`businessPartnerWebPage`,
						`businessPartnerNotes`,
						`businessPartnerAttachments,				
						`isDefault`,
						`isNew`,													`isDraft`,
						`isUpdate`,													`isDelete`,
						`isActive`,													`isApproved`,
						`isReview`,                      		  	 				`isPost`,
						`executeBy`,												`executeTime`
					)
			VALUES
					(
						'" . $this->model->getBusinessPartnerCompany() . "',					
						'" . $this->model->getBusinessPartnerLastName() . "',
						'" . $this->model->getBusinessPartnerFirstName() . "',
						'" . $this->model->getBusinessPartnerEmail() . "',
						'" . $this->model->getBusinessPartnerJobTitle() . "',
						'" . $this->model->getBusinessPartnerBusinessPhone() . "',
						'" . $this->model->getBusinessPartnerHomePhone() . "',
						'" . $this->model->getBusinessPartnerMobilePhone() . "',
						'" . $this->model->getBusinessPartnerFaxNum() . "',
						'" . $this->model->getBusinessPartnerAddress() . "',
						'" . $this->model->getBusinessPartnerCity() . "',
						'" . $this->model->getBusinessPartnerState() . "',
						'" . $this->model->getBusinessPartnerPostcode() . "',
						'" . $this->model->getBusinessPartnerCountry() . "',
						'" . $this->model->getBusinessPartnerWebPage() . "',
						'" . $this->model->getBusinessPartnerNotes() . "',
						'" . $this->model->getBusinessPartnerAttachments() . "',
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
             			'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			INSERT INTO [businessPartner]
					(
						[businessPartnerCompany],
						[businessPartnerLastName],
						[businessPartnerFirstName],
						[businessPartnerEmail],
						[businessPartnerJobTitle],
						[businessPartnerBusinessPhone],
						[businessPartnerHomePhone],
						[businessPartnerMobilePhone],
						[businessPartnerFaxNum],
						[businessPartnerAddress],
						[businessPartnerCity],
						[businessPartnerState],
						[businessPartnerPostcode],
						[businessPartnerCountry],
						[businessPartnerWebPage],
						[businessPartnerNotes],
						[businessPartnerAttachments],	
						[isDefault],
						[isNew],														[isDraft],
						[isUpdate],														[isDelete],
						[isActive],														[isApproved],
						[isReview],														[isPost],
						[executeBy],													[executeTime]
					)
			VALUES
					(
						'" . $this->model->getBusinessPartnerCompany() . "',					
						'" . $this->model->getBusinessPartnerLastName() . "',
						'" . $this->model->getBusinessPartnerFirstName() . "',
						'" . $this->model->getBusinessPartnerEmail() . "',
						'" . $this->model->getBusinessPartnerJobTitle() . "',
						'" . $this->model->getBusinessPartnerBusinessPhone() . "',
						'" . $this->model->getBusinessPartnerHomePhone() . "',
						'" . $this->model->getBusinessPartnerMobilePhone() . "',
						'" . $this->model->getBusinessPartnerFaxNum() . "',
						'" . $this->model->getBusinessPartnerAddress() . "',
						'" . $this->model->getBusinessPartnerCity() . "',
						'" . $this->model->getBusinessPartnerState() . "',
						'" . $this->model->getBusinessPartnerPostcode() . "',
						'" . $this->model->getBusinessPartnerCountry() . "',
						'" . $this->model->getBusinessPartnerWebPage() . "',
						'" . $this->model->getBusinessPartnerNotes() . "',
						'" . $this->model->getBusinessPartnerAttachments() . "',				
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',				'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',			'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',			'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',			'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',						" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::ORACLE) {

			$sql = "
			INSERT INTO	BUSINESSPARTNER
					(
						BUSINESSPARTNERCOMPANY,
						BUSINESSPARTNERLASTNAME,
						BUSINESSPARTNERFIRSTNAME,
						BUSINESSPARTNEREMAIL,
						BUSINESSPARTNERJOBTITLE,
						BUSINESSPARTNERBUISNESSPHONE,
						BUSINESSPARTNERHOMEPHONE,
						BUSINESSPARTNERMOBILEPHONE,
						BUSINESSPARTNERFAXNUM,
						BUSINESSPARTNERADDRESS,
						BUSINESSPARTNERCITY,
						BUSINESSPARTNERSTATE,
						BUSINESSPARTNERPOSTCODE,
						BUSINESSPARTNERCOUNTRY,
						BUSINESSPARTNERWEBPAGE,
						BUSINESSPARTNERNOTES,
						BUSINESSPARTNERATTACHMENTS,	
						ISDEFAULT,
						ISNEW,														ISDRAFT,
						ISUPDATE,													ISDELETE,
						ISACTIVE,													ISAPPROVED,
						ISREVIEW,													ISPOST,
						EXECUTEBY,													EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getBusinessPartnerCompany() . "',					
						'" . $this->model->getBusinessPartnerLastName() . "',
						'" . $this->model->getBusinessPartnerFirstName() . "',
						'" . $this->model->getBusinessPartnerEmail() . "',
						'" . $this->model->getBusinessPartnerJobTitle() . "',
						'" . $this->model->getBusinessPartnerBusinessPhone() . "',
						'" . $this->model->getBusinessPartnerHomePhone() . "',
						'" . $this->model->getBusinessPartnerMobilePhone() . "',
						'" . $this->model->getBusinessPartnerFaxNum() . "',
						'" . $this->model->getBusinessPartnerAddress() . "',
						'" . $this->model->getBusinessPartnerCity() . "',
						'" . $this->model->getBusinessPartnerState() . "',
						'" . $this->model->getBusinessPartnerPostcode() . "',
						'" . $this->model->getBusinessPartnerCountry() . "',
						'" . $this->model->getBusinessPartnerWebPage() . "',
						'" . $this->model->getBusinessPartnerNotes() . "',
						'" . $this->model->getBusinessPartnerAttachments() . "',					
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',						
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					)";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			INSERT INTO	BUSINESSPARTNER
			(					
						BUSINESSPARTNERCOMPANY,
						BUSINESSPARTNERLASTNAME,
						BUSINESSPARTNERFIRSTNAME,
						BUSINESSPARTNEREMAIL,
						BUSINESSPARTNERJOBTITLE,
						BUSINESSPARTNERBUISNESSPHONE,
						BUSINESSPARTNERHOMEPHONE,
						BUSINESSPARTNERMOBILEPHONE,
						BUSINESSPARTNERFAXNUM,
						BUSINESSPARTNERADDRESS,
						BUSINESSPARTNERCITY,
						BUSINESSPARTNERSTATE,
						BUSINESSPARTNERPOSTCODE,
						BUSINESSPARTNERCOUNTRY,
						BUSINESSPARTNERWEBPAGE,
						BUSINESSPARTNERNOTES,
						BUSINESSPARTNERATTACHMENTS,
						ISDEFAULT,
						ISNEW,														ISDRAFT,
						ISUPDATE,													ISDELETE,
						ISACTIVE,													ISAPPROVED,
						ISREVIEW,													ISPOST,
						EXECUTEBY,													EXECUTETIME
			)
			VALUES
			(
						'" . $this->model->getBusinessPartnerCompany() . "',					
						'" . $this->model->getBusinessPartnerLastName() . "',
						'" . $this->model->getBusinessPartnerFirstName() . "',
						'" . $this->model->getBusinessPartnerEmail() . "',
						'" . $this->model->getBusinessPartnerJobTitle() . "',
						'" . $this->model->getBusinessPartnerBusinessPhone() . "',
						'" . $this->model->getBusinessPartnerHomePhone() . "',
						'" . $this->model->getBusinessPartnerMobilePhone() . "',
						'" . $this->model->getBusinessPartnerFaxNum() . "',
						'" . $this->model->getBusinessPartnerAddress() . "',
						'" . $this->model->getBusinessPartnerCity() . "',
						'" . $this->model->getBusinessPartnerState() . "',
						'" . $this->model->getBusinessPartnerPostcode() . "',
						'" . $this->model->getBusinessPartnerCountry() . "',
						'" . $this->model->getBusinessPartnerWebPage() . "',
						'" . $this->model->getBusinessPartnerNotes() . "',
						'" . $this->model->getBusinessPartnerAttachments() . "',							
						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
			)";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			INSERT INTO	BUSINESSPARTNER
			(
						BUSINESSPARTNERCOMPANY,
						BUSINESSPARTNERLASTNAME,
						BUSINESSPARTNERFIRSTNAME,
						BUSINESSPARTNEREMAIL,
						BUSINESSPARTNERJOBTITLE,
						BUSINESSPARTNERBUISNESSPHONE,
						BUSINESSPARTNERHOMEPHONE,
						BUSINESSPARTNERMOBILEPHONE,
						BUSINESSPARTNERFAXNUM,
						BUSINESSPARTNERADDRESS,
						BUSINESSPARTNERCITY,
						BUSINESSPARTNERSTATE,
						BUSINESSPARTNERPOSTCODE,
						BUSINESSPARTNERCOUNTRY,
						BUSINESSPARTNERWEBPAGE,
						BUSINESSPARTNERNOTES,
						BUSINESSPARTNERATTACHMENTS,
						ISDEFAULT,
						ISNEW,														ISDRAFT,
						ISUPDATE,													ISDELETE,
						ISACTIVE,													ISAPPROVED,
						ISREVIEW,													ISPOST,
						EXECUTEBY,													EXECUTETIME
			)
			VALUES
			(
						'" . $this->model->getBusinessPartnerCompany() . "',					
						'" . $this->model->getBusinessPartnerLastName() . "',
						'" . $this->model->getBusinessPartnerFirstName() . "',
						'" . $this->model->getBusinessPartnerEmail() . "',
						'" . $this->model->getBusinessPartnerJobTitle() . "',
						'" . $this->model->getBusinessPartnerBusinessPhone() . "',
						'" . $this->model->getBusinessPartnerHomePhone() . "',
						'" . $this->model->getBusinessPartnerMobilePhone() . "',
						'" . $this->model->getBusinessPartnerFaxNum() . "',
						'" . $this->model->getBusinessPartnerAddress() . "',
						'" . $this->model->getBusinessPartnerCity() . "',
						'" . $this->model->getBusinessPartnerState() . "',
						'" . $this->model->getBusinessPartnerPostcode() . "',
						'" . $this->model->getBusinessPartnerCountry() . "',
						'" . $this->model->getBusinessPartnerWebPage() . "',
						'" . $this->model->getBusinessPartnerNotes() . "',
						'" . $this->model->getBusinessPartnerAttachments() . "',
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
		//advance logging future
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();

		$this->q->audit = $this->audit;
		$this->q->create($sql);
		$businessPartnerId = $this->q->lastInsertId();
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success" => true, "message" =>  $this->systemString->getCreateMessage(), "businessPartnerId" => $businessPartnerId));
		exit();
	}

	/* (non-PHPdoc)
	 * @see config::read()
	 */

	public function read() {
		header('Content-Type:application/json; charset=utf-8');
		if ($this->getIsAdmin() == 0) {
			if ($this->q->vendor == self::MYSQL) {
				$this->auditFilter = "	`iFinancial`.`businessPartner`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[businessPartner].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	BUSINESSPARTNER.ISACTIVE	=	1	";
			} else if ($this->q->vendor == self::DB2) {
				$this->auditFilter = "	BUSINESSPARTNER.ISACTIVE	=	1	";
			} else if ($this->q->vendor == self::POSTGRESS) {
				$this->auditFilter = "	BUSINESSPARTNER.ISACTIVE	=	1	";
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
			SELECT	`iFinancial`.`businessPartner`.`businessPartnerId`,
					`iFinancial`.`businessPartner`.`businessPartnerCompany`,
					`iFinancial`.`businessPartner`.`businessPartnerLastName`,
					`iFinancial`.`businessPartner`.`businessPartnerFirstName`,
					`iFinancial`.`businessPartner`.`businessPartnerEmail`,
					`iFinancial`.`businessPartner`.`businessPartnerJobTitle`,
					`iFinancial`.`businessPartner`.`businessPartnerBusinessPhone`,
					`iFinancial`.`businessPartner`.`businessPartnerHomePhone`,
					`iFinancial`.`businessPartner`.`businessPartnerMobilePhone`,
					`iFinancial`.`businessPartner`.`businessPartnerFaxNum`,
					`iFinancial`.`businessPartner`.`businessPartnerAddress`,
					`iFinancial`.`businessPartner`.`businessPartnerCity`,
					`iFinancial`.`businessPartner`.`businessPartnerState`,
					`iFinancial`.`businessPartner`.`businessPartnerPostcode`,
					`iFinancial`.`businessPartner`.`businessPartnerCountry`,
					`iFinancial`.`businessPartner`.`businessPartnerWebPage`,
					`iFinancial`.`businessPartner`.`businessPartnerNotes`,
					`iFinancial`.`businessPartner`.`businessPartnerAttachments`,						
					`iFinancial`.`businessPartner`.`isDefault`,
					`iFinancial`.`businessPartner`.`isNew`,
					`iFinancial`.`businessPartner`.`isDraft`,
					`iFinancial`.`businessPartner`.`isUpdate`,
					`iFinancial`.`businessPartner`.`isDelete`,
					`iFinancial`.`businessPartner`.`isActive`,
					`iFinancial`.`businessPartner`.`isApproved`,
					`iFinancial`.`businessPartner`.`isReview`,
					`iFinancial`.`businessPartner`.`isPost`,
					`iFinancial`.`businessPartner`.`executeBy`,
					`iFinancial`.`businessPartner`.`executeTime`,
					`iManagement`.`staff`.`staffName`
			FROM 	`iFinancial`.`businessPartner`
			JOIN	`iManagement`.`staff`
			ON		`iFinancial`.`businessPartner`.`executeBy` = `iManagement`.`staff`.`staffId`
			WHERE 	 " . $this->auditFilter;
			if ($this->model->getBusinessPartnerId(0, 'single')) {
				$sql .= " AND `iFinancial`.`" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`='" . $this->model->getBusinessPartnerId(0, 'single') . "'";
			}
				
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[businessPartner].[businessPartnerId],
					[businessPartner].[businessPartnerCompany],
					[businessPartner].[businessPartnerLastName],
					[businessPartner].[businessPartnerFirstName],
					[businessPartner].[businessPartnerEmail],
					[businessPartner].[businessPartnerJobTitle],
					[businessPartner].[businessPartnerBusinessPhone],
					[businessPartner].[businessPartnerHomePhone],
					[businessPartner].[businessPartnerMobilePhone],
					[businessPartner].[businessPartnerFaxNum],
					[businessPartner].[businessPartnerAddress],
					[businessPartner].[businessPartnerCity],
					[businessPartner].[businessPartnerState],
					[businessPartner].[businessPartnerPostcode],
					[businessPartner].[businessPartnerCountry],
					[businessPartner].[businessPartnerWebPage],
					[businessPartner].[businessPartnerNotes],
					[businessPartner].[businessPartnerAttachments],
					[businessPartner].[isDefault],
					[businessPartner].[isNew],
					[businessPartner].[isDraft],
					[businessPartner].[isUpdate],
					[businessPartner].[isDelete],
					[businessPartner].[isActive],
					[businessPartner].[isApproved],
					[businessPartner].[isReview],
					[businessPartner].[isPost],
					[businessPartner].[executeBy],
					[businessPartner].[executeTime],
					[staff].[staffName]
			FROM 	[businessPartner]
			JOIN	[staff]
			ON		[businessPartner].[executeBy] = [staff].[staffId]
			WHERE 	" . $this->auditFilter;
			if ($this->model->getBusinessPartnerId(0, 'single')) {
				$sql .= " AND [" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]='" . $this->model->getBusinessPartnerId(0, 'single') . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT		BUSINESSPARTNER.BUSINESSPARTNERID   		 	AS 	\"businessPartnerId\",
						BUSINESSPARTNER.BUSINESSPARTNERCOMPANY			AS 	\"businessPartnerCompany\",
						BUSINESSPARTNER.BUSINESSPARTNERLASTNAME			AS 	\"businessPartnerLastName\",
						BUSINESSPARTNER.BUSINESSPARTNERFIRSTNAME		AS 	\"businessPartnerFirstName\",
						BUSINESSPARTNER.BUSINESSPARTNEREMAIL			AS 	\"businessPartnerEmail\",
						BUSINESSPARTNER.BUSINESSPARTNERJOBTITLE			AS 	\"businessPartnerJobTitle\",
						BUSINESSPARTNER.BUSINESSPARTNERBUISNESSPHONE	AS 	\"businessPartnerBusinessPhone\",
						BUSINESSPARTNER.BUSINESSPARTNERHOMEPHONE		AS 	\"businessPartnerHomePhone\",
						BUSINESSPARTNER.BUSINESSPARTNERMOBILEPHONE		AS 	\"businessPartnerMobilePhone\",
						BUSINESSPARTNER.BUSINESSPARTNERFAXNUM			AS 	\"businessPartnerFaxNum\",
						BUSINESSPARTNER.BUSINESSPARTNERADDRESS			AS 	\"businessPartnerAddress\",
						BUSINESSPARTNER.BUSINESSPARTNERCITY				AS 	\"businessPartnerCity\",
						BUSINESSPARTNER.BUSINESSPARTNERSTATE			AS 	\"businessPartnerState\",
						BUSINESSPARTNER.BUSINESSPARTNERPOSTCODE			AS 	\"businessPartnerPostcode\",
						BUSINESSPARTNER.BUSINESSPARTNERCOUNTRY			AS 	\"businessPartnerCountry\",
						BUSINESSPARTNER.BUSINESSPARTNERWEBPAGE			AS 	\"businessPartnerWebPage\",
						BUSINESSPARTNER.BUSINESSPARTNERNOTES			AS 	\"businessPartnerNotes\",
						BUSINESSPARTNER.BUSINESSPARTNERATTACHMENTS		AS 	\"businessPartnerAttachments\",					
						BUSINESSPARTNER.ISDEFAULT    				AS	\"isDefault\",
						BUSINESSPARTNER.ISNEW		  				AS	\"isNew\",
						BUSINESSPARTNER.ISDRAFT	  				AS	\"isDraft\",
						BUSINESSPARTNER.ISUPDATE     				AS	\"isUpdate\",
						BUSINESSPARTNER.ISDELETE	  				AS	\"isDelete\",
						BUSINESSPARTNER.ISACTIVE	  				AS	\"isActive\",
						BUSINESSPARTNER.ISAPPROVED   				AS	\"isApproved\",
						BUSINESSPARTNER.ISREVIEW	  				AS	\"isReview\",
						BUSINESSPARTNER.ISPOST  	  				AS	\"isPost\",
						BUSINESSPARTNER.EXECUTEBY    				AS	\"executeBy\",
						BUSINESSPARTNER.EXECUTETIME  				AS	\"executeTime\",
						STAFF.STAFFNAME		  				AS	\"staffName\"	
			FROM 		BUSINESSPARTNER
			JOIN		STAFF
			ON			BUSINESSPARTNER.EXECUTEBY 	  	=	STAFF.STAFFID
			WHERE 	" . $this->auditFilter;
			if ($this->model->getBusinessPartnerId(0, 'single')) {
				$sql .= " AND " . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "='" . $this->model->getBusinessPartnerId(0, 'single') . "'";
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
		$filterArray = array('businessPartnerId','businessPartnerCategoryId','staff');
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array('businessPartner','businessPartner','staff');
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
							WITH [businessPartnerDerived] AS
							(
								SELECT 		[businessPartner].[businessPartnerId],
											[businessPartner].[businessPartnerCompany],
											[businessPartner].[businessPartnerLastName],
											[businessPartner].[businessPartnerFirstName],
											[businessPartner].[businessPartnerEmail],
											[businessPartner].[businessPartnerJobTitle],
											[businessPartner].[businessPartnerBusinessPhone],
											[businessPartner].[businessPartnerHomePhone],
											[businessPartner].[businessPartnerMobilePhone],
											[businessPartner].[businessPartnerFaxNum],
											[businessPartner].[businessPartnerAddress],
											[businessPartner].[businessPartnerCity],
											[businessPartner].[businessPartnerState],
											[businessPartner].[businessPartnerPostcode],
											[businessPartner].[businessPartnerCountry],
											[businessPartner].[businessPartnerWebPage],
											[businessPartner].[businessPartnerNotes],
											[businessPartner].[businessPartnerAttachments],					
											[businessPartner].[isDefault],
											[businessPartner].[isNew],
											[businessPartner].[isDraft],
											[businessPartner].[isUpdate],
											[businessPartner].[isDelete],
											[businessPartner].[isApproved],
											[businessPartner].[isReview],
											[businessPartner].[isPost],
											[businessPartner].[executeBy],
											[businessPartner].[executeTime],
											[staff].[staffName],
								ROW_NUMBER() OVER (ORDER BY [businessPartnerId]) AS 'RowNumber'
								FROM 	[businessPartner]
								JOIN		[staff]
								ON		[businessPartner].[executeBy] = [staff].[staffId]
								WHERE " . $this->auditFilter . $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[businessPartnerDerived]
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
								SELECT	BUSINESSPARTNER.BUSINESSPARTNERID   			AS 	\"businessPartnerId\",
										BUSINESSPARTNER.BUSINESSPARTNERCOMPANY			AS 	\"businessPartnerCompany\",
										BUSINESSPARTNER.BUSINESSPARTNERLASTNAME			AS 	\"businessPartnerLastName\",
										BUSINESSPARTNER.BUSINESSPARTNERFIRSTNAME		AS 	\"businessPartnerFirstName\",
										BUSINESSPARTNER.BUSINESSPARTNEREMAIL			AS 	\"businessPartnerEmail\",
										BUSINESSPARTNER.BUSINESSPARTNERJOBTITLE			AS 	\"businessPartnerJobTitle\",
										BUSINESSPARTNER.BUSINESSPARTNERBUISNESSPHONE	AS 	\"businessPartnerBusinessPhone\",
										BUSINESSPARTNER.BUSINESSPARTNERHOMEPHONE		AS 	\"businessPartnerHomePhone\",
										BUSINESSPARTNER.BUSINESSPARTNERMOBILEPHONE		AS 	\"businessPartnerMobilePhone\",
										BUSINESSPARTNER.BUSINESSPARTNERFAXNUM			AS 	\"businessPartnerFaxNum\",
										BUSINESSPARTNER.BUSINESSPARTNERADDRESS			AS 	\"businessPartnerAddress\",
										BUSINESSPARTNER.BUSINESSPARTNERCITY				AS 	\"businessPartnerCity\",
										BUSINESSPARTNER.BUSINESSPARTNERSTATE			AS 	\"businessPartnerState\",
										BUSINESSPARTNER.BUSINESSPARTNERPOSTCODE			AS 	\"businessPartnerPostcode\",
										BUSINESSPARTNER.BUSINESSPARTNERCOUNTRY			AS 	\"businessPartnerCountry\",
										BUSINESSPARTNER.BUSINESSPARTNERWEBPAGE			AS 	\"businessPartnerWebPage\",
										BUSINESSPARTNER.BUSINESSPARTNERNOTES			AS 	\"businessPartnerNotes\",
										BUSINESSPARTNER.BUSINESSPARTNERATTACHMENTS		AS 	\"businessPartnerAttachments\",										
										BUSINESSPARTNER.ISDEFAULT    		AS	\"isDefault\",
										BUSINESSPARTNER.ISNEW		  		AS	\"isNew\",
										BUSINESSPARTNER.ISDRAFT	 		AS	\"isDraft\",
										BUSINESSPARTNER.ISUPDATE     		AS	\"isUpdate\",
										BUSINESSPARTNER.ISDELETE	  		AS	\"isDelete\",
										BUSINESSPARTNER.ISACTIVE	  		AS	\"isActive\",
										BUSINESSPARTNER.ISAPPROVED   		AS	\"isApproved\",
										BUSINESSPARTNER.ISREVIEW	  		AS 	\"isReview\",
										BUSINESSPARTNER.ISPOST		  		AS	\"isPost\",
										BUSINESSPARTNER.EXECUTEBY    		AS	\"executeBy\",
										BUSINESSPARTNER.EXECUTETIME  		AS	\"executeTime\",
										STAFF.STAFFNAME		  		AS	\"staffName\"	
								FROM 	BUSINESSPARTNER
								JOIN	STAFF
								ON		BUSINESSPARTNER.EXECUTEBY 	  	=	STAFF.STAFFID
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
		if (!($this->model->getBusinessPartnerId(0, 'single'))) {
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
		if ($this->model->getBusinessPartnerId(0, 'single')) {
			$json_encode = json_encode(array('success' => true, 'total' => $total, 'message' =>  $this->systemString->getReadMessage(), 'data' => $items, 'firstRecord' => $this->recordSet->firstRecord('value'), 'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getBusinessPartnerId(0, 'single')), 'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getBusinessPartnerId(0, 'single')), 'lastRecord' => $this->recordSet->lastRecord('value')));
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
			WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getBusinessPartnerId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[" . $this->model->getTableName() . "]
			WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getBusinessPartnerId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getBusinessPartnerId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getBusinessPartnerId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getBusinessPartnerId(0, 'single') . "' ";
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
				UPDATE		`businessPartner`
				SET 		`businessPartnerCompany`			=	'" . $this->model->getBusinessPartnerCompany() . "',
							`businessPartnerLastName`			=	'" . $this->model->getBusinessPartnerLastName() . "',
							`businessPartnerFirstName`		=	'" . $this->model->getBusinessPartnerFirstName() . "',
							`businessPartnerEmail`			=	'" . $this->model->getBusinessPartnerEmail() . "',
							`businessPartnerJobTitle`			=	'" . $this->model->getBusinessPartnerJobTitle() . "',
							`businessPartnerBusinessPhone`	=	'" . $this->model->getBusinessPartnerBusinessPhone() . "',
							`businessPartnerHomePhone`		=	'" . $this->model->getBusinessPartnerHomePhone() . "',
							`businessPartnerMobilePhone`		=	'" . $this->model->getBusinessPartnerMobilePhone() . "',
							`businessPartnerFaxNum`			=	'" . $this->model->getBusinessPartnerFaxNum() . "',
							`businessPartnerAddress`			=	'" . $this->model->getBusinessPartnerAddress() . "',
							`businessPartnerCity`				=	'" . $this->model->getBusinessPartnerCity() . "',
							`businessPartnerState`			=	'" . $this->model->getBusinessPartnerState() . "',
							`businessPartnerPostcode`			=	'" . $this->model->getBusinessPartnerPostcode() . "',
							`businessPartnerCountry`			=	'" . $this->model->getBusinessPartnerCountry() . "',
							`businessPartnerWebPage`			=	'" . $this->model->getBusinessPartnerWebPage() . "',
							`businessPartnerNotes`			=	'" . $this->model->getBusinessPartnerNotes() . "',
							`businessPartnerAttachments`		=	'" . $this->model->getBusinessPartnerAttachments() . "',								
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
				WHERE 		`businessPartnerId`		=	'" . $this->model->getBusinessPartnerId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
				UPDATE 		[businessPartner]
				SET 		[businessPartnerCompany]			=	'" . $this->model->getBusinessPartnerCompany() . "',
							[businessPartnerLastName]			=	'" . $this->model->getBusinessPartnerLastName() . "',
							[businessPartnerFirstName]		=	'" . $this->model->getBusinessPartnerFirstName() . "',
							[businessPartnerEmail]			=	'" . $this->model->getBusinessPartnerEmail() . "',
							[businessPartnerJobTitle]			=	'" . $this->model->getBusinessPartnerJobTitle() . "',
							[businessPartnerBusinessPhone]	=	'" . $this->model->getBusinessPartnerBusinessPhone() . "',
							[businessPartnerHomePhone]		=	'" . $this->model->getBusinessPartnerHomePhone() . "',
							[businessPartnerMobilePhone]		=	'" . $this->model->getBusinessPartnerMobilePhone() . "',
							[businessPartnerFaxNum]			=	'" . $this->model->getBusinessPartnerFaxNum() . "',
							[businessPartnerAddress]			=	'" . $this->model->getBusinessPartnerAddress() . "',
							[businessPartnerCity]				=	'" . $this->model->getBusinessPartnerCity() . "',
							[businessPartnerState]			=	'" . $this->model->getBusinessPartnerState() . "',
							[businessPartnerPostcode]			=	'" . $this->model->getBusinessPartnerPostcode() . "',
							[businessPartnerCountry]			=	'" . $this->model->getBusinessPartnerCountry() . "',
							[businessPartnerWebPage]			=	'" . $this->model->getBusinessPartnerWebPage() . "',
							[businessPartnerNotes]			=	'" . $this->model->getBusinessPartnerNotes() . "',
							[businessPartnerAttachments]		=	'" . $this->model->getBusinessPartnerAttachments() . "',								
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
			WHERE 		[businessPartnerId]			=	'" . $this->model->getBusinessPartnerId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
				UPDATE		BUSINESSPARTNER
				SET 		BUSINESSPARTNERCOMPANY 			=	'" . $this->model->getBusinessPartnerCompany() . "',	
							BUSINESSPARTNERLASTNAME			=	'" . $this->model->getBusinessPartnerLastName() . "',
							BUSINESSPARTNERFIRSTNAME			=	'" . $this->model->getBusinessPartnerFirstName() . "',
							BUSINESSPARTNEREMAIL				=	'" . $this->model->getBusinessPartnerEmail() . "',
							BUSINESSPARTNERJOBTITLE			=	'" . $this->model->getBusinessPartnerJobTitle() . "',
							BUSINESSPARTNERBUISNESSPHONE		=	'" . $this->model->getBusinessPartnerBusinessPhone() . "',
							BUSINESSPARTNERHOMEPHONE			=	'" . $this->model->getBusinessPartnerHomePhone() . "',
							BUSINESSPARTNERMOBILEPHONE		=	'" . $this->model->getBusinessPartnerBirthday() . "',
							BUSINESSPARTNERFAXNUM				=	'" . $this->model->getBusinessPartnerFaxNum() . "',
							BUSINESSPARTNERADDRESS			=	'" . $this->model->getBusinessPartnerAddress() . "',
							BUSINESSPARTNERCITY				=	'" . $this->model->getBusinessPartnerCity() . "',
							BUSINESSPARTNERSTATE				=	'" . $this->model->getBusinessPartnerState() . "',
							BUSINESSPARTNERPOSTCODE			=	'" . $this->model->getBusinessPartnerPostcode() . "',
							BUSINESSPARTNERCOUNTRY			=	'" . $this->model->getBusinessPartnerCountry() . "',
							BUSINESSPARTNERWEBPAGE			=	'" . $this->model->getBusinessPartnerWebPage() . "',
							BUSINESSPARTNERNOTES				=	'" . $this->model->getBusinessPartnerNotes() . "',
							BUSINESSPARTNERATTACHMENTS		=	'" . $this->model->getBusinessPartnerAttachments() . "',						
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
			WHERE 		BUSINESSPARTNERID		=	'" . $this->model->getBusinessPartnerId(0, 'single') . "'";
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
			UPDATE	BUSINESSPARTNER
			SET 			BUSINESSPARTNERCOMPANY 			=	'" . $this->model->getBusinessPartnerCompany() . "',	
							BUSINESSPARTNERLASTNAME			=	'" . $this->model->getBusinessPartnerLastName() . "',
							BUSINESSPARTNERFIRSTNAME			=	'" . $this->model->getBusinessPartnerFirstName() . "',
							BUSINESSPARTNEREMAIL				=	'" . $this->model->getBusinessPartnerEmail() . "',
							BUSINESSPARTNERJOBTITLE			=	'" . $this->model->getBusinessPartnerJobTitle() . "',
							BUSINESSPARTNERBUISNESSPHONE		=	'" . $this->model->getBusinessPartnerBusinessPhone() . "',
							BUSINESSPARTNERHOMEPHONE			=	'" . $this->model->getBusinessPartnerHomePhone() . "',
							BUSINESSPARTNERMOBILEPHONE		=	'" . $this->model->getBusinessPartnerBirthday() . "',
							BUSINESSPARTNERFAXNUM				=	'" . $this->model->getBusinessPartnerFaxNum() . "',
							BUSINESSPARTNERADDRESS			=	'" . $this->model->getBusinessPartnerAddress() . "',
							BUSINESSPARTNERCITY				=	'" . $this->model->getBusinessPartnerCity() . "',
							BUSINESSPARTNERSTATE				=	'" . $this->model->getBusinessPartnerState() . "',
							BUSINESSPARTNERPOSTCODE			=	'" . $this->model->getBusinessPartnerPostcode() . "',
							BUSINESSPARTNERCOUNTRY			=	'" . $this->model->getBusinessPartnerCountry() . "',
							BUSINESSPARTNERWEBPAGE			=	'" . $this->model->getBusinessPartnerWebPage() . "',
							BUSINESSPARTNERNOTES				=	'" . $this->model->getBusinessPartnerNotes() . "',
							BUSINESSPARTNERATTACHMENTS		=	'" . $this->model->getBusinessPartnerAttachments() . "',						
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
			WHERE 		BUSINESSPARTNERID		=	'" . $this->model->getBusinessPartnerId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
				UPDATE		BUSINESSPARTNER
					SET 	BUSINESSPARTNERCOMPANY 			=	'" . $this->model->getBusinessPartnerCompany() . "',	
							BUSINESSPARTNERLASTNAME			=	'" . $this->model->getBusinessPartnerLastName() . "',
							BUSINESSPARTNERFIRSTNAME			=	'" . $this->model->getBusinessPartnerFirstName() . "',
							BUSINESSPARTNEREMAIL				=	'" . $this->model->getBusinessPartnerEmail() . "',
							BUSINESSPARTNERJOBTITLE			=	'" . $this->model->getBusinessPartnerJobTitle() . "',
							BUSINESSPARTNERBUISNESSPHONE		=	'" . $this->model->getBusinessPartnerBusinessPhone() . "',
							BUSINESSPARTNERHOMEPHONE			=	'" . $this->model->getBusinessPartnerHomePhone() . "',
							BUSINESSPARTNERMOBILEPHONE		=	'" . $this->model->getBusinessPartnerBirthday() . "',
							BUSINESSPARTNERFAXNUM				=	'" . $this->model->getBusinessPartnerFaxNum() . "',
							BUSINESSPARTNERADDRESS			=	'" . $this->model->getBusinessPartnerAddress() . "',
							BUSINESSPARTNERCITY				=	'" . $this->model->getBusinessPartnerCity() . "',
							BUSINESSPARTNERSTATE				=	'" . $this->model->getBusinessPartnerState() . "',
							BUSINESSPARTNERPOSTCODE			=	'" . $this->model->getBusinessPartnerPostcode() . "',
							BUSINESSPARTNERCOUNTRY			=	'" . $this->model->getBusinessPartnerCountry() . "',
							BUSINESSPARTNERWEBPAGE			=	'" . $this->model->getBusinessPartnerWebPage() . "',
							BUSINESSPARTNERNOTES				=	'" . $this->model->getBusinessPartnerNotes() . "',
							BUSINESSPARTNERATTACHMENTS		=	'" . $this->model->getBusinessPartnerAttachments() . "',						
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
				WHERE 		BUSINESSPARTNERID			=	'" . $this->model->getBusinessPartnerId(0, 'single') . "'";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}
			/*
			 *  require three variable below to track  table audit
			 */
			$this->q->tableName = $this->model->getTableName();
			$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
			$this->q->primaryKeyValue = $this->model->getBusinessPartnerId(0, 'single');
			$this->q->audit = $this->audit;
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
			WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getBusinessPartnerId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[" . $this->model->getTableName() . "]
			WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getBusinessPartnerId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getBusinessPartnerId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getBusinessPartnerId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getBusinessPartnerId(0, 'single') . "' ";
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
				UPDATE 	`businessPartner`
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
				WHERE 	`businessPartnerId`		=	'" . $this->model->getBusinessPartnerId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
				UPDATE 	[businessPartner]
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
				WHERE 	[businessPartnerId]		=	'" . $this->model->getBusinessPartnerId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
				UPDATE 	BUSINESSPARTNER
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
				WHERE 	BUSINESSPARTNERID		=	'" . $this->model->getBusinessPartnerId(0, 'single') . "'";
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
				UPDATE 	BUSINESSPARTNER
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
				WHERE 	BUSINESSPARTNERID		=	'" . $this->model->getBusinessPartnerId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
				UPDATE 	BUSINESSPARTNER
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
				WHERE 	BUSINESSPARTNERID		=	'" . $this->model->getBusinessPartnerId(0, 'single') . "'";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}
			// advance logging future
			$this->q->tableName = $this->model->getTableName();
			$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
			$this->q->primaryKeyValue = $this->model->getBusinessPartnerId(0, 'single');
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
							WHEN '" . $this->model->getBusinessPartnerId($i, 'array') . "'
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
							WHEN '" . $this->model->getBusinessPartnerId($i, 'array') . "'
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
							WHEN '" . $this->model->getBusinessPartnerId($i, 'array') . "'
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
							WHEN '" . $this->model->getBusinessPartnerId($i, 'array') . "'
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
							WHEN '" . $this->model->getBusinessPartnerId($i, 'array') . "'
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
							WHEN '" . $this->model->getBusinessPartnerId($i, 'array') . "'
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
							WHEN '" . $this->model->getBusinessPartnerId($i, 'array') . "'
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
                            WHEN '" . $this->model->getBusinessPartnerId($i, 'array') . "'
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
                                WHEN '" . $this->model->getBusinessPartnerId($i, 'array') . "'
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
		if ($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT	`businessPartnerId`
			FROM 	`businessPartner`
			WHERE 	`businessPartnerId` 	= 	'" . $this->model->getBusinessPartnerId() . "'
			AND		`isActive`		=	1";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[businessPartnerId]
			FROM 	[businessPartner]
			WHERE 	[businessPartnerId] 	= 	'" . $this->model->getBusinessPartnerId() . "'
			AND		[isActive]		=	1";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	BUSINESSPARTNERID
			FROM 	BUSINESSPARTNER
			WHERE 	BUSINESSPARTNERID 	= 	'" . $this->model->getBusinessPartnerId() . "'
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	BUSINESSPARTNERID
			FROM 	BUSINESSPARTNER
			WHERE 	BUSINESSPARTNERID 	= 	'" . $this->model->getBusinessPartnerId() . "'
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	BUSINESSPARTNERID
			FROM 	BUSINESSPARTNER
			WHERE 	BUSINESSPARTNERID 	= 	'" . $this->model->getBusinessPartnerId() . "'
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
			echo json_encode(array("success" => true, "total" => $total, "message" => $this->systemString->getDuplicateMessage(), "businessPartnerDesc" => $row ['businessPartnerDesc']));
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
			$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, 'a' . $row ['businessPartnerDesc']);
			$loopRow++;
			$lastRow = 'C' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename = "businessPartner" . rand(0, 10000000) . ".xlsx";
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

$businessPartnerObject = new BusinessPartnerClass ();

/**
 * crud -create,read,update,delete
 * */
if (isset($_POST ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_POST ['leafId'])) {
		$businessPartnerObject->setLeafId($_POST ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$businessPartnerObject->setIsAdmin($_POST ['isAdmin']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$businessPartnerObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$businessPartnerObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Filtering
	 */
	if (isset($_POST ['query'])) {
		$businessPartnerObject->setFieldQuery($_POST ['query']);
	}
	if (isset($_POST ['filter'])) {
		$businessPartnerObject->setGridQuery($_POST ['filter']);
	}
	if (isset($_POST ['character'])) {
		$businessPartnerObject->setCharacterQuery($_POST['character']);
	}
	if (isset($_POST ['dateRangeStart'])) {
		$businessPartnerObject->setDateRangeStartQuery($_POST['dateRangeStart']);
	}
	if (isset($_POST ['dateRangeEnd'])) {
		$businessPartnerObject->setDateRangeEndQuery($_POST['dateRangeEnd']);
	}
	if (isset($_POST ['dateRangeType'])) {
		$businessPartnerObject->setDateRangeTypeQuery($_POST['dateRangeType']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST ['order'])) {
		$businessPartnerObject->setOrder($_POST ['order']);
	}
	if (isset($_POST ['sortField'])) {
		$businessPartnerObject->setSortField($_POST ['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$businessPartnerObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$businessPartnerObject->create();
	}
	if ($_POST ['method'] == 'save') {
		$businessPartnerObject->update();
	}
	if ($_POST ['method'] == 'read') {
		$businessPartnerObject->read();
	}
	if ($_POST ['method'] == 'delete') {
		$businessPartnerObject->delete();
	}
}
if (isset($_GET ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_GET ['leafId'])) {
		$businessPartnerObject->setLeafId($_GET ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET ['isAdmin'])) {
		$businessPartnerObject->setIsAdmin($_GET ['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$businessPartnerObject->execute();
	if (isset($_GET ['field'])) {
		if ($_GET ['field'] == 'staffId') {
			$businessPartnerObject->staff();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$businessPartnerObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET ['businessPartnerDesc'])) {
		if (strlen($_GET ['businessPartnerDesc']) > 0) {
			$businessPartnerObject->duplicate();
		}
	}
	/**
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$businessPartnerObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$businessPartnerObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$businessPartnerObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$businessPartnerObject->lastRecord('json');
		}
	}
	/*
	 * Excel Reporting
	 */
	if (isset($_GET ['mode'])) {
		if ($_GET ['mode'] == 'excel') {
			$businessPartnerObject->excel();
		}
	}
}
?>
