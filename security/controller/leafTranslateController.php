<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSecurity.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/leafTranslateModel.php");

/**
 * this leafTranslate menu creation
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Translation
 * @subpackage defaultLabel Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafTranslateClass extends ConfigClass {

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
	 * Audit Row True or False
	 * @var bool
	 */
	private $audit;

	/**
	 * Log Sql Statement True or False
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
	 * Common class function for security menu
	 * @var  string $security
	 */
	private $security;

	/**
	 * Class Loader
	 */
	function execute() {
		parent::__construct();
		//audit property
		$this->audit = 0;
		$this->log = 0;

		//default translation property
		$this->defaultLanguageId = 21;

		$this->model = new LeafTranslateModel ();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor();
		if($this->model->getLeafIdTemp()) {
			$this->q->leafId = $this->model->getLeafIdTemp();
		} else {
			$this->q->leafId = $this->getLeafId();
		}
		$this->q->staffId = $this->getStaffId();
		$this->q->fieldQuery = $this->getFieldQuery();
		$this->q->gridQuery = $this->getGridQuery();
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
		$this->q->log = $this->log;
		$this->q->audit = $this->audit;
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->security = new Security ();
		$this->security->setVendor($this->getVendor());
		$this->security->setLeafId($this->getLeafId());
		$this->security->execute();
		
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
		$this->documentTrail->execute();

		$this->excel = new PHPExcel ();
	}

	/* (non-PHPdoc)
	 * @see config::create()
	 */

	function create() {
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
			INSERT INTO `leafTranslate`
					(
						`leafId`,														`languageId`,
						`leafNative`,													`isDefault`,							
						`isNew`,														`isDraft`,								
						`isUpdate`,														`isDelete`,								
						`isActive`,														`isApproved`,							
						`isReview`,														`isPost`,
						`executeBy`,													`executeTime`
					)
			VALUES
					(
						'" . $this->model->getLeafId() . "',							'" . $this->model->getLanguageId() . "',
						'" . $this->model->getLeafNative() . "',						'" . $this->model->getIsDefault(0, 'single') . "',			
						'" . $this->model->getIsNew(0, 'single') . "',				'" . $this->model->getIsDraft(0, 'single') . "',				
						'" . $this->model->getIsUpdate(0, 'single') . "',			'" . $this->model->getIsDelete(0, 'single') . "',			
						'" . $this->model->getIsActive(0, 'single') . "',			'" . $this->model->getIsApproved(0, 'single') . "',			
						'" . $this->model->getIsReview(0, 'single') . "',			'" . $this->model->getIsPost(0, 'single') . "',										
						'" . $this->model->getExecuteBy() . "',						" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			INSERT INTO [leafTranslate]
					(
						[leafId],														[languageId],
						[leafNative],													[isDefault],
						[isNew],														[isDraft],
						[isUpdate],														[isDelete],
						[isActive],														[isApproved],
						[isReview],														[isPost],
						[executeBy],													[executeTime]
				)
			VALUES
				(
						'" . $this->model->getLeafId() . "',							'" . $this->model->getLanguageId() . "',
						'" . $this->model->getLeafNative() . "',						'" . $this->model->getIsDefault(0, 'single') . "',			
						'" . $this->model->getIsNew(0, 'single') . "',				'" . $this->model->getIsDraft(0, 'single') . "',				
						'" . $this->model->getIsUpdate(0, 'single') . "',			'" . $this->model->getIsDelete(0, 'single') . "',			
						'" . $this->model->getIsActive(0, 'single') . "',			'" . $this->model->getIsApproved(0, 'single') . "',			
						'" . $this->model->getIsReview(0, 'single') . "',			'" . $this->model->getIsPost(0, 'single') . "',										
						'" . $this->model->getExecuteBy() . "',						" . $this->model->getExecuteTime() . "
			);";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			INSERT INTO 	LEAFTRANSLATE
						(
							LEAFID,													LANGUAGEID,
							LEAFNATIVE,												ISDEFAULT,							
							ISNEW,														ISDRAFT,								
							ISUPDATE,													ISDELETE,								
							ISACTIVE,													ISAPPROVED,							
							ISREVIEW,													ISPOST,
							EXECUTEBY,													EXECUTETIME
				VALUES	(
							'" . $this->model->getLeafId() . "',						'" . $this->model->getLanguageId() . "',
						'" . $this->model->getLeafNative() . "',						'" . $this->model->getIsDefault(0, 'single') . "',			
						'" . $this->model->getIsNew(0, 'single') . "',				'" . $this->model->getIsDraft(0, 'single') . "',				
						'" . $this->model->getIsUpdate(0, 'single') . "',			'" . $this->model->getIsDelete(0, 'single') . "',			
						'" . $this->model->getIsActive(0, 'single') . "',			'" . $this->model->getIsApproved(0, 'single') . "',			
						'" . $this->model->getIsReview(0, 'single') . "',			'" . $this->model->getIsPost(0, 'single') . "',										
						'" . $this->model->getExecuteBy() . "',						" . $this->model->getExecuteTime() . "
			)";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			INSERT INTO 	LEAFTRANSLATE
						(
							LEAFID,													LANGUAGEID,
							LEAFNATIVE,												ISDEFAULT,							
							ISNEW,														ISDRAFT,								
							ISUPDATE,													ISDELETE,								
							ISACTIVE,													ISAPPROVED,							
							ISREVIEW,													ISPOST,
							EXECUTEBY,													EXECUTETIME
				VALUES	(
							'" . $this->model->getLeafId() . "',						'" . $this->model->getLanguageId() . "',
							'" . $this->model->getLeafNative() . "',					'" . $this->model->getIsDefault(0, 'single') . "',			
							'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',				
							'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',			
							'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',			
							'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',										
							'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
			)";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			INSERT INTO 	LEAFTRANSLATE
						(
							LEAFID,													LANGUAGEID,
							LEAFNATIVE,												ISDEFAULT,							
							ISNEW,														ISDRAFT,								
							ISUPDATE,													ISDELETE,								
							ISACTIVE,													ISAPPROVED,							
							ISREVIEW,													ISPOST,
							EXECUTEBY,													EXECUTETIME
				VALUES	(
							'" . $this->model->getLeafId() . "',						'" . $this->model->getLanguageId() . "',
							'" . $this->model->getLeafNative() . "',					'" . $this->model->getIsDefault(0, 'single') . "',			
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
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$lastId = $this->q->lastInsertId();
		$this->q->commit();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
			array(	"success" => true, 
					"leafTranslateId" => $lastId, 
					"message" => $this->systemString->getCreateMessage(),
					"time"=>$time));
		exit();
	}

	/* (non-PHPdoc)
	 * @see config::read()
	 */

	function read() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		
		if ($this->getVendor() == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$items = array();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT	`leafTranslate`.`leafTranslateId`,
					`leafTranslate`.`leafId`,
					`leafTranslate`.`languageId`,
					`leafTranslate`.`leafNative`,
					`leafTranslate`.`isDefault`,
					`leafTranslate`.`isNew`,
					`leafTranslate`.`isDraft`,
					`leafTranslate`.`isDelete`,
					`leafTranslate`.`isActive`,
					`leafTranslate`.`isUpdate`,
					`leafTranslate`.`isApproved`,
					`leafTranslate`.`isReview`,
					`leafTranslate`.`isPost`,
					`leafTranslate`.`executeBy`,
					`leafTranslate`.`executeTime`,
					`language`.`languageDesc`,
					`language`.`languageCode`
			FROM 	`leafTranslate`
			JOIN	`staff`
			ON		`leafTranslate`.`executeBy` = `staff`.`staffId`
			JOIN	`language`
			ON		`leafTranslate`.`languageId`	= `language`.`languageId`	
			WHERE 	1	=	1 ";
			if ($this->model->getLeafTranslateId(0, 'single')) {
				$sql .= " AND `" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`='" . $this->model->getLeafTranslateId(0, 'single') . "'";
			}
			
			if ($this->model->getLeafIdTemp() && $this->model->getLeafId()) {
				$sql.= " AND `leafTranslate`.`leafId`='" . $this->model->getLeafId() . "'";
			}

		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[leafTranslate].[leafTranslateId],
					[leafTranslate].[leafId],
					[leafTranslate].[languageId],
					[leafTranslate].[leafNative],
					[leafTranslate].[isDefault],
					[leafTranslate].[isNew],
					[leafTranslate].[isDraft],
					[leafTranslate].[isDelete],
					[leafTranslate].[isActive],
					[leafTranslate].[isUpdate],
					[leafTranslate].[isApproved],
					[leafTranslate].[isReview],
					[leafTranslate].[isPost],
					[leafTranslate].[executeBy],
					[leafTranslate].[executeTime],
					[language].[languageDesc],
					[language].[languageCode]
			FROM 	[leafTranslate]
			JOIN	[staff]
			ON		[leafTranslate].[executeBy] = [staff].[staffId]
			JOIN	[language]
			ON		[leafTranslate].[languageId]	= [language].[languageId] 
			WHERE 	1	=	1 ";
			if ($this->model->getLeafTranslateId(0, 'single')) {
				$sql .= " AND [" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]='" . $this->model->getLeafTranslateId(0, 'single') . "'";
			}
			if ($this->model->getLeafIdTemp() &&  $this->model->getLeafId()) {
				$sql.= " AND [leafTranslate].[leafId]='" . $this->model->getLeafId() . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	LEAFTRANSLATE.LEAFTRANSLATEID,
					LEAFTRANSLATE.LEAFID,
					LEAFTRANSLATE.LANGUAGEID,
					LEAFTRANSLATE.LEAFNATIVE,
					LEAFTRANSLATE.ISDEFAULT,
					LEAFTRANSLATE.ISNEW,
					LEAFTRANSLATE.ISDRAFT,
					LEAFTRANSLATE.ISDELETE,
					LEAFTRANSLATE.ISACTIVE,
					LEAFTRANSLATE.ISUPDATE,
					LEAFTRANSLATE.ISAPPROVED,
					LEAFTRANSLATE.ISREVIEW,
					LEAFTRANSLATE.ISPOST,
					LEAFTRANSLATE.EXECUTEBY,
					LEAFTRANSLATE.EXECUTETIME,
					LANGUAGE.LANGUAGEDESC,
					LANGUAGE.LANGUAGECODE
			FROM 	LEAFTRANSLATE
			JOIN	STAFF
			ON		LEAFTRANSLATE.EXECUTEBY = STAFF.STAFFID
			JOIN	LANGUAGE
			ON		LEAFTRANSLATE.LANGUAGEID	= LANGUAGE.LANGUAGEID
			WHERE 	1	=	1";
			if ($this->model->getLeafTranslateId(0, 'single')) {
				$sql .= " AND " . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "=" . $this->model->getLeafTranslateId(0, 'single') . "'";
			}
			if ($this->model->getLeafIdTemp() &&  $this->model->getLeafId()) {
				$sql.= " AND LEAFTRANSLATE.LEAFID='" .$this->model->getLeafId(). "'";
			}
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	LEAFTRANSLATE.LEAFTRANSLATEID,
					LEAFTRANSLATE.LEAFID,
					LEAFTRANSLATE.LANGUAGEID,
					LEAFTRANSLATE.LEAFNATIVE,
					LEAFTRANSLATE.ISDEFAULT,
					LEAFTRANSLATE.ISNEW,
					LEAFTRANSLATE.ISDRAFT,
					LEAFTRANSLATE.ISDELETE,
					LEAFTRANSLATE.ISACTIVE,
					LEAFTRANSLATE.ISUPDATE,
					LEAFTRANSLATE.ISAPPROVED,
					LEAFTRANSLATE.ISREVIEW,
					LEAFTRANSLATE.ISPOST,
					LEAFTRANSLATE.EXECUTEBY,
					LEAFTRANSLATE.EXECUTETIME,
					LANGUAGE.LANGUAGEDESC,
					LANGUAGE.LANGUAGECODE
			FROM 	LEAFTRANSLATE
			JOIN	STAFF
			ON		LEAFTRANSLATE.EXECUTEBY = STAFF.STAFFID
			JOIN	LANGUAGE
			ON		LEAFTRANSLATE.LANGUAGEID	= LANGUAGE.LANGUAGEID
			WHERE 	1	=	1";
			if ($this->model->getLeafTranslateId(0, 'single')) {
				$sql .= " AND " . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "=" . $this->model->getLeafTranslateId(0, 'single') . "'";
			}
			if ($this->model->getLeafIdTemp() &&  $this->model->getLeafId()) {
				$sql.= " AND LEAFTRANSLATE.LEAFID='" .$this->model->getLeafId(). "'";
			}
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	LEAFTRANSLATE.LEAFTRANSLATEID,
					LEAFTRANSLATE.LEAFID,
					LEAFTRANSLATE.LANGUAGEID,
					LEAFTRANSLATE.LEAFNATIVE,
					LEAFTRANSLATE.ISDEFAULT,
					LEAFTRANSLATE.ISNEW,
					LEAFTRANSLATE.ISDRAFT,
					LEAFTRANSLATE.ISDELETE,
					LEAFTRANSLATE.ISACTIVE,
					LEAFTRANSLATE.ISUPDATE,
					LEAFTRANSLATE.ISAPPROVED,
					LEAFTRANSLATE.ISREVIEW,
					LEAFTRANSLATE.ISPOST,
					LEAFTRANSLATE.EXECUTEBY,
					LEAFTRANSLATE.EXECUTETIME,
					LANGUAGE.LANGUAGEDESC,
					LANGUAGE.LANGUAGECODE
			FROM 	LEAFTRANSLATE
			JOIN	STAFF
			ON		LEAFTRANSLATE.EXECUTEBY = STAFF.STAFFID
			JOIN	LANGUAGE
			ON		LEAFTRANSLATE.LANGUAGEID	= LANGUAGE.LANGUAGEID
			WHERE 	1	=	1";
			if ($this->model->getLeafTranslateId(0, 'single')) {
				$sql .= " AND " . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "=" . $this->model->getLeafTranslateId(0, 'single') . "'";
			}
			if ($this->model->getLeafIdTemp() && $this->model->getLeafId()) {
				$sql.= " AND LEAFTRANSLATE.LEAFID='" .$this->model->getLeafId(). "'";
			}
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = array('leafTranslateId');
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = array('leafTranslate');
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
			}
		}

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
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . "  " . strtoupper($this->getOrder()) . " ";
			} else if ($this->getVendor() == self::DB2) {
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . "  " . strtoupper($this->getOrder()) . " ";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . "  " . strtoupper($this->getOrder()) . " ";
			}
		}
		$_SESSION ['sql'] = $sql; // push to session so can make report via excel and pdf
		$_SESSION ['start'] = $this->getStart();
		$_SESSION ['limit'] = $this->getLimit();
		if ($this->getStart() && $this->getLimit()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= " LIMIT  " . $this->getStart() . "," . $this->getLimit() . " ";
			} else if ($this->getVendor() == self::MSSQL) {
				/**
				 * Sql Server and Oracle used row_number
				 * Parameterize Query We don't support
				 */
				$sql = "
							WITH [leafTranslateDerived] AS
							(
								SELECT	[leafTranslate].[leafTranslateId],
										[leafTranslate].[leafId],
										[leafTranslate].[languageId],
										[leafTranslate].[leafNative],
										[leafTranslate].[isDefault],
										[leafTranslate].[isNew],
										[leafTranslate].[isDraft],
										[leafTranslate].[isDelete],
										[leafTranslate].[isActive],
										[leafTranslate].[isUpdate],
										[leafTranslate].[isApproved],
										[leafTranslate].[isReview],
										[leafTranslate].[isPost],
										[leafTranslate].[executeBy],
										ROW_NUMBER() OVER (ORDER BY [leafTranslateId]) AS 'RowNumber'
								FROM 	[leafTranslate]
								WHERE	1 =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[leafTranslateDerived]
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
									SELECT 		LEAFTRANSLATE.LEAFTRANSLATEID,
												LEAFTRANSLATE.LEAFID,
												LEAFTRANSLATE.LANGUAGEID,
												LEAFTRANSLATE.LEAFNATIVE,
												LEAFTRANSLATE.ISDEFAULT,
												LEAFTRANSLATE.ISNEW,
												LEAFTRANSLATE.ISDRAFT,
												LEAFTRANSLATE.ISDELETE,
												LEAFTRANSLATE.ISACTIVE,
												LEAFTRANSLATE.ISUPDATE,
												LEAFTRANSLATE.ISAPPROVED,
												LEAFTRANSLATE.ISREVIEW,
												LEAFTRANSLATE.ISPOST,
												LEAFTRANSLATE.EXECUTEBY,
												LEAFTRANSLATE.EXECUTETIME
									FROM 		LEAFTRANSLATE
									WHERE		1 	=	1
									AND 		" . $tempSql . $tempSql2 . "
								 ) a
						WHERE rownum <= '" . ($this->getStart() + $this->getLimit()) . "' )
						where r >=  '" . ($this->getStart() + 1) . "'";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit();
			}
		}

		/*
		 *  Only Execute One Query
		 */
		if (!($this->model->getLeafTranslateId(0, 'single'))) {
			$this->q->read($sql);
			if ($this->q->execute == 'fail') {
				echo json_encode(array("success" => false, "message" => $this->q->responce));
				exit();
			}
		}
		$items = array();
		while (($row = $this->q->fetchAssoc()) == true) {
			$items [] = $row;
		}
		if ($this->model->getLeafTranslateId(0, 'single')) {
			$end = microtime(true);
			$time = $end - $start;
			$json_encode = json_encode(
			array(	'success' => true,
						'total' => $total, 
						'time' => $time, 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getLeafTranslateId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getLeafTranslateId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value'),
						'data' => $items));
			$json_encode = str_replace("[", "", $json_encode);
			$json_encode = str_replace("]", "", $json_encode);
			echo $json_encode;
		} else {
			if (count($items) == 0) {
				$items = '';
			}
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode(
			array(	'success' => true,
							'total' => $total, 
							'time' => $time, 
            				'firstRecord' => $this->recordSet->firstRecord('value'), 
            				'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getLeafTranslateId(0, 'single')), 
            				'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getLeafTranslateId(0, 'single')), 
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
		}
		$this->q->start();
		$this->model->update();
		// before updating check the id exist or not . if exist continue to update else warning the user
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT	`" . $this->model->getPrimaryKeyName() . "`
			FROM 	`" . $this->model->getTableName() . "`
			WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getModuleId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[" . $this->model->getTableName() . "]
			WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getModuleId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getModuleId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getModuleId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getModuleId(0, 'single') . "' ";
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
					UPDATE 	`leafTranslate`
					SET 	`languageId`					=	'" . $this->model->getLanguageId() . "',
							`leafTranslateNative`			=	'" . $this->model->getLeafTranslateNative() . "',
							`isDefault`						=	'" . $this->model->getIsDefault(0, 'single') . "',
							`isActive`						=	'" . $this->model->getIsActive(0, 'single') . "',
							`isNew`							=	'" . $this->model->getIsNew(0, 'single') . "',
							`isDraft`						=	'" . $this->model->getIsDraft(0, 'single') . "',
							`isUpdate`						=	'" . $this->model->getIsUpdate(0, 'single') . "',
							`isDelete`						=	'" . $this->model->getIsDelete(0, 'single') . "',
							`isApproved`					=	'" . $this->model->getIsApproved(0, 'single') . "',
							`isReview`						=	'" . $this->model->getIsReview(0, 'single') . "',
							`isPost`						=	'" . $this->model->getIsPost(0, 'single') . "',
							`executeBy`						=	'" . $this->model->getExecuteBy() . "',
							`executeTime`					=	" . $this->model->getExecuteTime() . "
					WHERE 	`leafTranslateId`				=	'" . $this->model->getLeafTranslateId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
					UPDATE 	[leafTranslate]
					SET 	[languageId]					=	'" . $this->model->getLanguageId() . "',
							[leafTranslateNative]			=	'" . $this->model->getLeafTranslateNative() . "',
							[isDefault]						=	'" . $this->model->getIsDefault(0, 'single') . "',
							[isActive]						=	'" . $this->model->getIsActive(0, 'single') . "',
							[isNew]							=	'" . $this->model->getIsNew(0, 'single') . "',
							[isDraft]						=	'" . $this->model->getIsDraft(0, 'single') . "',
							[isUpdate]						=	'" . $this->model->getIsUpdate(0, 'single') . "',
							[isDelete]						=	'" . $this->model->getIsDelete(0, 'single') . "',
							[isApproved]					=	'" . $this->model->getIsApproved(0, 'single') . "',
							[isReview]						=	'" . $this->model->getIsReview(0, 'single') . "',
							[isPost]						=	'" . $this->model->getIsPost(0, 'single') . "',
							[executeBy]						=	'" . $this->model->getExecuteBy() . "',
							[executeTime]					=	" . $this->model->getExecuteTime() . "
					WHERE 	[leafTranslateId]				=	'" . $this->model->getLeafTranslateId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
					UPDATE 	LEAFTRANSLATE
					SET 	LANGUAGEID						=	'" . $this->model->getLanguageId() . "',
							LEAFTRANSLATENATIVE			=	'" . $this->model->getLeafTranslateNative() . "',
							ISDEFAULT						=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISACTIVE						=	'" . $this->model->getIsActive(0, 'single') . "',
							ISNEW							=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT							=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE						=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE						=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISAPPROVED						=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW						=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST							=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY						=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME						=	" . $this->model->getExecuteTime() . "
					WHERE 	LEAFTRANSLATEID				=	'" . $this->model->getLeafTranslateId(0, 'single') . "'";
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
					UPDATE 	LEAFTRANSLATE
					SET 	LANGUAGEID						=	'" . $this->model->getLanguageId() . "',
							LEAFTRANSLATENATIVE			=	'" . $this->model->getLeafTranslateNative() . "',
							ISDEFAULT						=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISACTIVE						=	'" . $this->model->getIsActive(0, 'single') . "',
							ISNEW							=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT							=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE						=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE						=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISAPPROVED						=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW						=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST							=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY						=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME						=	" . $this->model->getExecuteTime() . "
					WHERE 	LEAFTRANSLATEID				=	'" . $this->model->getLeafTranslateId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
					UPDATE 	LEAFTRANSLATE
					SET 	LANGUAGEID						=	'" . $this->model->getLanguageId() . "',
							LEAFTRANSLATENATIVE			=	'" . $this->model->getLeafTranslateNative() . "',
							ISDEFAULT						=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISACTIVE						=	'" . $this->model->getIsActive(0, 'single') . "',
							ISNEW							=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT							=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE						=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE						=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISAPPROVED						=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW						=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST							=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY						=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME						=	" . $this->model->getExecuteTime() . "
					WHERE 	LEAFTRANSLATEID				=	'" . $this->model->getLeafTranslateId(0, 'single') . "'";
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
			FROM 	`" . $this->model->getTableName() . "`
			WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getModuleId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT	[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[" . $this->model->getTableName() . "]
			WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getModuleId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getModuleId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getModuleId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getModuleId(0, 'single') . "' ";
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
				UPDATE 	`leafTranslate`
				SET 	`isDefault`						=	'" . $this->model->getIsDefault(0, 'single') . "',
						`isActive`						=	'" . $this->model->getIsActive(0, 'single') . "',
						`isNew`							=	'" . $this->model->getIsNew(0, 'single') . "',
						`isDraft`						=	'" . $this->model->getIsDraft(0, 'single') . "',
						`isUpdate`						=	'" . $this->model->getIsUpdate(0, 'single') . "',
						`isDelete`						=	'" . $this->model->getIsDelete(0, 'single') . "',
						`isApproved`					=	'" . $this->model->getIsApproved(0, 'single') . "',
						`isReview`						=	'" . $this->model->getIsReview(0, 'single') . "',
						`isPost`						=	'" . $this->model->getIsPost(0, 'single') . "',
						`executeBy`						=	'" . $this->model->getExecuteBy() . "',
						`executeTime`					=	" . $this->model->getExecuteTime() . "
				WHERE 	`leafTranslateId`				=	'" . $this->model->getLeafTranslateId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
				UPDATE 	[leafTranslate]
				SET 	[isDefault]						=	'" . $this->model->getIsDefault(0, 'single') . "',
						[isActive]						=	'" . $this->model->getIsActive(0, 'single') . "',
						[isNew]							=	'" . $this->model->getIsNew(0, 'single') . "',
						[isDraft]						=	'" . $this->model->getIsDraft(0, 'single') . "',
						[isUpdate]						=	'" . $this->model->getIsUpdate(0, 'single') . "',
						[isDelete]						=	'" . $this->model->getIsDelete(0, 'single') . "',
						[isApproved]					=	'" . $this->model->getIsApproved(0, 'single') . "',
						[isReview]						=	'" . $this->model->getIsReview(0, 'single') . "',
						[isPost]						=	'" . $this->model->getIsPost(0, 'single') . "',
						[executeBy]						=	'" . $this->model->getExecuteBy() . "',
						[executeTime]					=	" . $this->model->getExecuteTime() . "
				WHERE 	[leafTranslateId]				=	'" . $this->model->getLeafTranslateId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
				UPDATE 	LEAFTRANSLATE
				SET 	ISDEFAULT						=	'" . $this->model->getIsDefault(0, 'single') . "',
						ISACTIVE						=	'" . $this->model->getIsActive(0, 'single') . "',
						ISNEW							=	'" . $this->model->getIsNew(0, 'single') . "',
						ISDRAFT							=	'" . $this->model->getIsDraft(0, 'single') . "',
						ISUPDATE						=	'" . $this->model->getIsUpdate(0, 'single') . "',
						ISDELETE						=	'" . $this->model->getIsDelete(0, 'single') . "',
						ISAPPROVED						=	'" . $this->model->getIsApproved(0, 'single') . "',
						ISREVIEW						=	'" . $this->model->getIsReview(0, 'single') . "',
						ISPOST							=	'" . $this->model->getIsPost(0, 'single') . "',
						EXECUTEBY						=	'" . $this->model->getExecuteBy() . "',
						EXECUTETIME						=	" . $this->model->getExecuteTime() . "
				WHERE 	LEAFTRANSLATEID				=	'" . $this->model->getLeafTranslateId(0, 'single') . "'";
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
				UPDATE 	LEAFTRANSLATE
				SET 	LEAFTRANSLATENATIVE			=	'" . $this->model->getLeafTranslateNative() . "',
						ISDEFAULT						=	'" . $this->model->getIsDefault(0, 'single') . "',
						ISACTIVE						=	'" . $this->model->getIsActive(0, 'single') . "',
						ISNEW							=	'" . $this->model->getIsNew(0, 'single') . "',
						ISDRAFT							=	'" . $this->model->getIsDraft(0, 'single') . "',
						ISUPDATE						=	'" . $this->model->getIsUpdate(0, 'single') . "',
						ISDELETE						=	'" . $this->model->getIsDelete(0, 'single') . "',
						ISAPPROVED						=	'" . $this->model->getIsApproved(0, 'single') . "',
						ISREVIEW						=	'" . $this->model->getIsReview(0, 'single') . "',
						ISPOST							=	'" . $this->model->getIsPost(0, 'single') . "',
						EXECUTEBY						=	'" . $this->model->getExecuteBy() . "',
						EXECUTETIME						=	" . $this->model->getExecuteTime() . "
				WHERE 	LEAFTRANSLATEID				=	'" . $this->model->getLeafTranslateId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
				UPDATE 	LEAFTRANSLATE
				SET 	ISDEFAULT						=	'" . $this->model->getIsDefault(0, 'single') . "',
						ISACTIVE						=	'" . $this->model->getIsActive(0, 'single') . "',
						ISNEW							=	'" . $this->model->getIsNew(0, 'single') . "',
						ISDRAFT							=	'" . $this->model->getIsDraft(0, 'single') . "',
						ISUPDATE						=	'" . $this->model->getIsUpdate(0, 'single') . "',
						ISDELETE						=	'" . $this->model->getIsDelete(0, 'single') . "',
						ISAPPROVED						=	'" . $this->model->getIsApproved(0, 'single') . "',
						ISREVIEW						=	'" . $this->model->getIsReview(0, 'single') . "',
						ISPOST							=	'" . $this->model->getIsPost(0, 'single') . "',
						EXECUTEBY						=	'" . $this->model->getExecuteBy() . "',
						EXECUTETIME						=	" . $this->model->getExecuteTime() . "
				WHERE 	LEAFTRANSLATEID				=	'" . $this->model->getLeafTranslateId(0, 'single') . "'";
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
					"message" => $this->systemString->getDeleteMessage(),
					"time"=>$time));
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
		$sql='';
		$sqlLooping='';
		$this->q->start();

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
							WHEN '" . $this->model->getLeafTranslateId($i, 'array') . "'
							THEN '" . $this->model->getIsDefault($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isNew' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsNew($i, 'array')) > 0) {
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
							WHEN '" . $this->model->getLeafTranslateId($i, 'array') . "'
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
							WHEN '" . $this->model->getLeafTranslateId($i, 'array') . "'
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
							WHEN '" . $this->model->getLeafTranslateId($i, 'array') . "'
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
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getLeafTranslateId($i, 'array') . "'
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
							WHEN '" . $this->model->getLeafTranslateId($i, 'array') . "'
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
							WHEN '" . $this->model->getLeafTranslateId($i, 'array') . "'
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
                            WHEN '" . $this->model->getLeafTranslateId($i, 'array') . "'
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
                                WHEN '" . $this->model->getLeafTranslateId($i, 'array') . "'
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
		array("success" => true,
					"message" => $message,
					"time"=>$time)
		);
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
		$this->excel->setActiveSheetIndex(0);
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array('borders' => array('inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '000000')), 'outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '000000'))));
		// header all using  3 line  starting b
		$this->excel->getActiveSheet()->setCellValue('B2', $this->title);
		$this->excel->getActiveSheet()->setCellValue('D2', '');
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->setCellValue('B3', 'No');
		$this->excel->getActiveSheet()->setCellValue('C3', 'leafTranslate');
		$this->excel->getActiveSheet()->setCellValue('D3', 'Description');
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');
		//
		$loopRow = 4;
		$i = 0;
		while (($row = $this->q->fetchAssoc()) == true) {
			$this->excel->getActiveSheet()->setCellValue('B' . $loopRow, ++$i);
			$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, $row ['leafTranslateNote']);
			$loopRow++;
			$lastRow = 'D' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename = "leafTranslate" . rand(0, 10000000) . ".xlsx";
		$path = $_SERVER ['DOCUMENT_ROOT'] . "/" . $this->application . "/security/document/excel/" . $filename;
		$objWriter->save($path);
		$this->audit->create_trail($this->getLeafId(), $path, $filename);
		$file = fopen($path, 'r');
		if ($file) {
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode(array("success" => true, "message" => $this->systemString->getFileGenerateMessage(),"time"=>$time));
			exit();
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getFileNotGenerateMessage()));
			exit();
		}
	}

}

$leafTranslateObject = new leafTranslateClass ();
/**
 * crud -create,read,update,delete
 * */
if (isset($_POST ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST ['leafId'])) {
		$leafTranslateObject->setLeafId($_POST ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$leafTranslateObject->setIsAdmin($_POST ['isAdmin']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$leafTranslateObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$leafTranslateObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Filtering
	 */
	if (isset($_POST ['query'])) {
		$leafTranslateObject->setFieldQuery($_POST ['query']);
	}
	if (isset($_POST ['filter'])) {
		$leafTranslateObject->setGridQuery($_POST ['filter']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST ['order'])) {
		$leafTranslateObject->setOrder($_POST ['order']);
	}
	if (isset($_POST ['sortField'])) {
		$leafTranslateObject->setSortField($_POST ['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$leafTranslateObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$leafTranslateObject->create();
	}
	if ($_POST ['method'] == 'read') {
		$leafTranslateObject->read();
	}
	if ($_POST ['method'] == 'save') {
		$leafTranslateObject->update();
	}
	if ($_POST ['method'] == 'delete') {
		$leafTranslateObject->delete();
	}
}
if (isset($_GET ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_GET ['leafId'])) {
		$leafTranslateObject->setLeafId($_GET ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET ['isAdmin'])) {
		$leafTranslateObject->setIsAdmin($_GET ['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$leafTranslateObject->execute();
	if (isset($_GET ['field'])) {
		if ($_GET ['field'] == 'staffId') {
			$leafTranslateObject->staff();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$leafTranslateObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET ['leafTranslateCode'])) {
		if (strlen($_GET ['leafTranslateCode']) > 0) {
			$leafTranslateObject->duplicate();
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$leafTranslateObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$leafTranslateObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$leafTranslateObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$leafTranslateObject->lastRecord('json');
		}
	}
	/*
	 *  Excel Reporting
	 */
	if (isset($_GET ['mode'])) {
		if ($_GET ['mode'] == 'excel') {
			$leafTranslateObject->excel();
		}
	}
}
?>

