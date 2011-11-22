<?php
session_start ();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/languageModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Translation
 * @subpackage language
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LanguageClass extends ConfigClass {
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
	 * Class Loader
	 */
	function execute() {
		parent::__construct ();
		//audit property
		$this->audit = 0;
		$this->log = 1;

		// default translation property
		$this->defaultLanguageId = 21;

		$this->model = new LanguageModel ();
		$this->model->setVendor ( $this->getVendor () );
		$this->model->execute ();

		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor ();
		$this->q->leafId = $this->getLeafId ();
		$this->q->staffId = $this->getStaffId ();
		$this->q->fieldQuery = $this->getFieldQuery ();
		$this->q->gridQuery = $this->getGridQuery ();
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
		$this->q->log = $this->log;
		$this->q->audit = $this->audit;
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );
		
		$this->systemString = new SystemString();
		$this->systemString->setVendor($this->getVendor());
		$this->systemString->setLeafId($this->getLeafId());
		$this->systemString->execute();
		
		$this->recordSet = new RecordSet ();
		$this->recordSet->setTableName ( $this->model->getTableName () );
		$this->recordSet->setPrimaryKeyName ( $this->model->getPrimaryKeyName () );
		$this->recordSet->execute ();
		

		$this->documentTrail = new DocumentTrailClass ();
		$this->documentTrail->setVendor ( $this->getVendor () );
		$this->documentTrail->setStaffId ( $this->getStaffId () );
		$this->documentTrail->setLanguageId ( $this->getLanguageId () );
		$this->documentTrail->setLeafId ( $this->getLeafId () );
		$this->documentTrail->execute ();

		$this->excel = new PHPExcel ();

	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {
				
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );

		}
		$this->q->start ();
		$this->model->create ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			INSERT INTO `language`
					(
						`languageCode`,
						`languageDesc`,					`isDefault`,
						`isNew`,							`isDraft`,
						`isUpdate`,							`isDelete`,
						`isActive`,							`isApproved`,
						`executeBy`,								`executeTime`
					)
			VALUES
					(
						'" . $this->model->getLanguageCode () . "',
						'" . $this->model->getLanguageDesc () . "',		'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',					'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',				'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',				'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',								" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			INSERT INTO [language]
					(
									[languageCode],
						[languageDesc],					[isDefault],
						[isNew],							[isDraft],
						[isUpdate],							[isDelete],
						[isActive],							[isApproved],
						[executeBy],								[executeTime]
					)
			VALUES
					(
						'" . $this->model->getLanguageSequence () . "',
						'" . $this->model->getLanguageDesc ( 0, 'single' ) . "',		'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',				'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',				'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',				'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',								" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			INSERT INTO LANGUAGE
					(
								LANGUAGECODE,
						LANGUAGEDESC,					ISDEFAULT,
						ISNEW,							ISDRAFT,
						ISUPDATE,						ISDELETE,
						ISACTIVE,						ISAPPROVED,
						EXECUTEBY,								EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getLanguageSequence () . "',	'" . $this->model->getLanguageSequence () . "',
						'" . $this->model->getLanguageDesc ( 0, 'single' ) . "',		'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',					'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',				'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',				'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',								" . $this->model->getExecuteTime () . "
					);";

		}
		$this->q->create ( $sql );

		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => FALSE, "message" => $this->q->responce ) );
			exit ();
		}

		$this->q->commit ();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode (
		array (	"success" =>true,
					"message" => $this->systemString->getCreateMessage(),
					"time"=>$time ) );
		exit ();

	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getIsAdmin() == 0) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	`language`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::mssql) {
				$this->auditFilter = "	[language].[isActive]		=	1	";
			} else if ($this->q->vendor == self::oracle) {
				$this->auditFilter = "	LANGUAGE.ISACTIVE	=	1	";
			}
		} else if ($this->getIsAdmin() == 1) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	 1 = 1 ";
			} else if ($this->q->vendor == self::mssql) {
				$this->auditFilter = "	1 = 1 ";
			} else if ($this->q->vendor == self::oracle) {
				$this->auditFilter = " 1 = 1 ";
			}
		}

	
		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$items = array();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
					SELECT	`language`.`languageId`,
							`language`.`languageCode`,
							`language`.`languageDesc`,
							`language`.`isDefault`,
							`language`.`isNew`,
							`language`.`isDraft`,
							`language`.`isUpdate`,
							`language`.`isDelete`,
							`language`.`isActive`,
							`language`.`isApproved`,
							`language`.`executeBy`,
							`language`.`executeTime`,
							`staff`.`staffName`
 					FROM 	`language`
					JOIN	`staff`
					ON		`language`.`executeBy` = `staff`.`staffId`
					WHERE 	" . $this->auditFilter;
			if ($this->model->getLanguageId ( 0, 'single' )) {
				$sql .= " AND `" . $this->model->getTableName () . "`.`" . $this->model->getPrimaryKeyName () . "`='" . $this->model->getLanguageId ( 0, 'single' ) . "'";
					
			}

		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
					SELECT	[language].[languageId],

							[language].[languageCode],
							[language].[languageDesc],
							[language].[isDefault],
							[language].[isNew],
							[language].[isDraft],
							[language].[isUpdate],
							[language].[isDelete],
							[language].[isActive],
							[language].[isApproved],
							[language].[executeBy],
							[language].[executeTime],
							[staff].[staffName]
					FROM 	[language]
					JOIN	[staff]
					ON		[language].[executeBy] = [staff].[staffId]
					WHERE 	[language].[isActive] ='1'	";
			if ($this->model->getLanguageId ( 0, 'single' )) {
				$sql .= " AND [" . $this->model->getTableName () . "].[" . $this->model->getPrimaryKeyName () . "]='" . $this->model->getLanguageId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					SELECT	LANGUAGE.LANGUAGEID 	AS	\"languageId\",
							LANGUAGE.LANGUAGECODE 	AS 	\"languageCode\",
							LANGUAGE.LANGUAGEDESC 	AS 	\"languageDesc\",
							LANGUAGE.ISDEFAULT 		AS 	\"isDefault\",
							LANGUAGE.ISNEW 			AS	\"isNew\",
							LANGUAGE.ISDRAFT  		AS 	\"isDraft\",
							LANGUAGE.ISUPDATE 		AS 	\"isUpdate\",
							LANGUAGE.ISDELETE 		AS 	\"isDelete\",
							LANGUAGE.ISACTIVE 		AS 	\"isActive\",
							LANGUAGE.ISAPPROVED 	AS 	\"isApproved\",
							LANGUAGE.EXECUTEBY 		AS 	\"executeBy\",
							LANGUAGE.EXECUTETIME 	AS  \"executeTime\",
							STAFF.STAFFNAME 		AS 	\"staffName\"		
					FROM 	LANGUAGE
					JOIN	STAFF
					ON		LANGUAGE.EXECUTEBY = STAFF.STAFFID
					WHERE 	LANGUAGE.ISACTIVE='1'	";
			if ($this->model->getLanguageId ( 0, 'single' )) {
				$sql .= " AND  " . strtoupper ( $this->model->getTableName () ) . "." . strtoupper ( $this->model->getPrimaryKeyName () ) . "='" . $this->model->getLanguageId ( 0, 'single' ) . "'";
			}
		} else {
			echo json_encode ( array ("success" => false, "message" => "Undefine Database Vendor" ) );
			exit ();
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array ('languageId' );
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array ('language' );
		if ($this->getfieldQuery ()) {
			if ($this->getVendor () == self::MYSQL) {
				$sql .= $this->q->quickSearch ( $tableArray, $filterArray );
			} else if ($this->getVendor () == self::MSSQL) {
				$tempSql = $this->q->quickSearch ( $tableArray, $filterArray );
				$sql .= $tempSql;
			} else if ($this->getVendor () == self::ORACLE) {
				$tempSql = $this->q->quickSearch ( $tableArray, $filterArray );
				$sql .= $tempSql;
			}
		}
		/**
		 * Extjs filtering mode
		 */
		if ($this->getGridQuery ()) {

			if ($this->getVendor () == self::MYSQL) {
				$sql .= $this->q->searching ();
			} else if ($this->getVendor () == self::MSSQL) {
				$tempSql2 = $this->q->searching ();
				$sql .= $tempSql2;
			} else if ($this->getVendor () == self::ORACLE) {
				$tempSql2 = $this->q->searching ();
				$sql .= $tempSql2;
			}
		}
		/** // optional debugger.uncomment if wanted to used

		echo json_encode(array(
		"success" => false,
		"message" => $this->q->realEscapeString($sql)
		));
		exit();

		*/
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$total = $this->q->numberRows ();
		if ($this->getOrder () && $this->getSortField ()) {
			if ($this->getVendor () == self::MYSQL) {
				$sql .= "	ORDER BY `" . $this->getSortField () . "` " . $this->getOrder () . " ";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql .= "	ORDER BY [" . $this->getSortField () . "] " . $this->getOrder () . " ";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql .= "	ORDER BY " . strtoupper ( $this->getSortField () ) . "  " . strtoupper ( $this->getOrder () ) . " ";
			}
		}
		$_SESSION ['sql'] = $sql; // push to session so can make report via excel and pdf
		$_SESSION ['start'] = $this->getStart ();
		$_SESSION ['limit'] = $this->getLimit ();

		if ($this->getStart () && $this->getLimit ()) {
			// only mysql have limit
			if ($this->getVendor () == self::MYSQL) {
				$sql .= " LIMIT  " . $this->getStart () . "," . $this->getLimit () . " ";
			} else if ($this->getVendor () == self::MSSQL) {
				/**
				 * Sql Server and Oracle used row_number
				 * Parameterize Query We don't support
				 */
				$sql = "
							WITH [languageDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [languageId]) AS 'RowNumber'
								FROM [language]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[language].[languageId],

										[language].[languageCode],
										[language].[languageDesc],
										[language].[isDefault],
										[language].[isNew],
										[language].[isDraft],
										[language].[isUpdate],
										[language].[isDelete],
										[language].[isApproved],
										[language].[executeBy],
										[language].[executeTime],
										[staff].[staffName]
							FROM 		[languageDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $this->getStart () . "
							AND 			" . ($this->getStart () + $this->getLimit () - 1) . ";";
			} else if ($this->getVendor () == self::ORACLE) {
				/**
				 * Oracle using derived table also
				 */
				$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
							SELECT	LANGUAGE.LANGUAGEID 	AS	\"languageId\",
							LANGUAGE.LANGUAGECODE 	AS 	\"languageCode\",
							LANGUAGE.LANGUAGEDESC 	AS 	\"languageDesc\",
							LANGUAGE.ISDEFAULT 		AS 	\"isDefault\",
							LANGUAGE.ISNEW 			AS	\"isNew\",
							LANGUAGE.ISDRAFT  		AS 	\"isDraft\",
							LANGUAGE.ISUPDATE 		AS 	\"isUpdate\",
							LANGUAGE.ISDELETE 		AS 	\"isDelete\",
							LANGUAGE.ISACTIVE 		AS 	\"isActive\",
							LANGUAGE.ISAPPROVED 	AS 	\"isApproved\",
							LANGUAGE.EXECUTEBY 		AS 	\"executeBy\",
							LANGUAGE.EXECUTETIME 	AS  \"executeTime\",
							STAFF.STAFFNAME 		AS 	\"staffName\"		
					FROM 	LANGUAGE
					JOIN	STAFF
					ON		LANGUAGE.EXECUTEBY = STAFF.STAFFID
					WHERE 	LANGUAGE.ISACTIVE='1'  " . $tempSql . $tempSql2 . "
								 ) a
						where rownum <= '" . ($this->getStart () + $this->getLimit () - 1) . "' )
						where r >=  '" . $this->getStart () . "'";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				exit ();
			}
		}

		/*
		 *  Only Execute One Query
		 */
		if (! ($this->model->getLanguageId ( 0, 'single' ))) {
			$this->q->read ( $sql );
			if ($this->q->execute == 'fail') {
				echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
				exit ();
			}
		}
		$items = array ();
		while ( ($row = $this->q->fetchAssoc ()) == true ) {
			$items [] = $row;
		}
		if ($this->model->getLanguageId ( 0, 'single' )) {
			$end = microtime(true);
			$time = $end - $start;
			$json_encode = json_encode (
			array (	'success' => true,
						'total' => $total, 
						'message' => $this->systemString->getReadMessage(), 
						'time' => $time , 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getLanguageId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getLanguageId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value'), 
						'data' => $items) );
			$json_encode = str_replace ( "[", "", $json_encode );
			$json_encode = str_replace ( "]", "", $json_encode );
			echo $json_encode;
		} else {
			if (count ( $items ) == 0) {
				$items = '';
			}
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode (
			array (	'success' => true,
						'total' => $total, 
						'message' => $this->systemString->getReadMessage(), 
						'time' => $time , 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getLanguageId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getLanguageId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value'), 
						'data' => $items) );
			exit ();
		}

	}

	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {
				
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );

		}
		$this->q->start();

		$this->model->update ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
				UPDATE 	`language`
				SET		`languageCode`		=	'" . $this->model->getLanguageCode () . "',
						`languageDesc` 		= 	'" . $this->model->getLanguageDesc () . "',
						`isDefault`			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						`isActive`			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
						`isNew`				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
						`isDraft`			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						`isUpdate`			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						`isDelete`			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						`isApproved`		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						`executeBy`			=	'" . $this->model->getExecuteBy () . "',
						`executeTime`		=	" . $this->model->getExecuteTime () . "
				WHERE 	`languageId`		=	'" . $this->model->getLanguageId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
				UPDATE 	[language]
				SET 	[languageCode]		=	'" . $this->model->getLanguageCode () . "',
						[languageDesc] 		= 	'" . $this->model->getLanguageDesc () . "',
						[isDefault]			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						[isActive]			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
						[isNew]				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
						[isDraft]			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						[isUpdate]			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						[isDelete]			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						[isApproved]		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						[executeBy]			=	'" . $this->model->getExecuteBy () . "',
						[executeTime]		=	" . $this->model->getExecuteTime () . "
				WHERE 	[languageId]		=	'" . $this->model->getLanguageId ( 0, 'single' ) . "'";

		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
				UPDATE 	LANGUAGE
				SET 	LANGUAGECODE	=	'" . $this->model->getLanguageCode () . "',
						LANGUAGEDESC 	= 	'" . $this->model->getLanguageDesc () . "',
						ISDEFAULT		=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						ISACTIVE		=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
						ISNEW			=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
						ISDRAFT			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						ISUPDATE		=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						ISDELETE		=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						ISAPPROVED		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						ISREVIEW		=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							ISPOST			=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
						EXECUTEBY		=	'" . $this->model->getExecuteBy () . "',
						EXECUTETIME		=	" . $this->model->getExecuteTime () . "
				WHERE 	LANGUAGEID		=	'" . $this->model->getLanguageId ( 0, 'single' ) . "'";

		}
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" =>false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode (
		array (	"success" => true,
					"message" => $this->systemString->getUpdateMessage(),
					"time"=>$time ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {
				
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );

		}
		$this->q->start();

		$this->model->delete ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
				UPDATE 	`language`
				SET 	`isDefault`		=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						`isActive`		=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
						`isNew`			=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
						`isDraft`		=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						`isUpdate`		=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						`isDelete`		=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						`isApproved`	=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						`executeBy`		=	'" . $this->model->getBy ( 0, 'single' ) . "',
						`executeTime`	=	" . $this->model->getExecuteTime () . "
				WHERE 	`languageId`	=	'" . $this->model->getDepartrmentId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
				UPDATE 	[language]
				SET 	[isDefault]		=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						[isActive]		=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
						[isNew]			=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
						[isDraft]		=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						[isUpdate]		=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						[isDelete]		=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						[isApproved]	=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						[executeBy]		=	'" . $this->model->getExecuteBy () . "',
						[executeTime]	=	" . $this->model->getExecuteTime () . "
				WHERE 	[languageId]	=	'" . $this->model->getLanguageId ( 0, 'single' ) . "'";

		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
				UPDATE 	LANGUAGE
				SET 	ISDEFAULT	=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						ISACTIVE	=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
						ISNEW		=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
						ISDRAFT		=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						ISUPDATE	=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						ISDELETE	=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						ISAPPROVED	=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						ISREVIEW		=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
						ISPOST			=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
						EXECUTEBY	=	'" . $this->model->getExecuteBy () . "',
						EXECUTETIME	=	" . $this->model->getExecuteTime () . "
				WHERE 	LANGUAGEID	=	'" . $this->model->getLanguageId ( 0, 'single' ) . "'";

		}
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => FALSE, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode (
		array (	"success" => true,
					"message" => $this->systemString->getDeleteMessage(),
					"time"=>$time ) );
		exit ();

	}
	/**
	 * To Update flag Status
	 */
	function updateStatus() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {
				
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );

		}
		$this->q->start();
		$loop = $this->model->getTotal ();

		if ($this->getVendor () == self::MYSQL) {
			$sql = "
				UPDATE `" . $this->model->getTableName () . "`
				SET";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			UPDATE 	[" . $this->model->getTableName () . "]
			SET 	";

		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			UPDATE  " . strtoupper ( $this->model->getTableName () ) . "
			SET    ";
		}
		/**
		 * System Validation Checking
		 * @var $access
		 */
		$access = array ("isDefault", "isNew", "isDraft", "isUpdate", "isDelete", "isActive", "isApproved", "isReview", "isPost" );
		foreach ( $access as $systemCheck ) {

			if ($this->getVendor () == self::MYSQL) {
				$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName () . "`";
			} else if ($this->getVendor () == self::MSSQL) {
				$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName () . "]";
					
			} else if ($this->getVendor () == self::ORACLE) {
				$sqlLooping .= "	" . strtoupper ( $systemCheck ) . " = CASE " . strtoupper ( $this->model->getPrimaryKeyName () ) . " ";
			}
			switch ($systemCheck) {
				case 'isDefault' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDefault ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getLanguageId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsDefault ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isNew' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsNew ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getLanguageId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsNew ( $i, 'array' ) . "'";

						}
					}
					break;
				case 'isDraft' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDraft ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getLanguageId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsDraft ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isUpdate' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsUpdate ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getLanguageId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsUpdate ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isDelete' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDelete ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getLanguageId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsDelete ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isActive' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsUpdate ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getLanguageId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsUpdate ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isApproved' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsApproved ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getLanguageId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsApproved ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isReview' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsReview ( $i, 'array' )) {
							$sqlLooping .= "
								WHEN '" . $this->model->getLanguageId ( $i, 'array' ) . "'
								THEN '" . $this->model->getIsReview ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isApproved' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsPost ( $i, 'array' )) {
							$sqlLooping .= "
								WHEN '" . $this->model->getLanguageId ( $i, 'array' ) . "'
								THEN '" . $this->model->getIsPost ( $i, 'array' ) . "'";
						}
					}
					break;
			}

			$sqlLooping .= " END,";
		}

		$sql .= substr ( $sqlLooping, 0, - 1 );
		if ($this->getVendor () == self::MYSQL) {
			$sql .= "
			WHERE `" . $this->model->getPrimaryKeyName () . "` IN (" . $this->model->getPrimaryKeyAll () . ")";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql .= "
			WHERE  [" . $this->model->getPrimaryKeyName () . "] IN (" . $this->model->getPrimaryKeyAll () . ")";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql .= "
			WHERE " . strtoupper ( $this->model->getPrimaryKeyName () ) . " IN (" . $this->model->getPrimaryKeyAll () . ")";
		}

		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode (
		array (	"success" => true,
					"message" => $this->systemString->getDeleteMessage(),
					"time"=>$time ) );
		exit ();

	}
	/**
	 * To check if a key duplicate or not
	 */
	function duplicate() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {
				
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT	*
			FROM 	`language`
			WHERE 	`languageCode` 	= 	'" . $this->model->getLanguageCode () . "'
			AND		`isActive`		=	1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	*
			FROM 	[language]
			WHERE 	[languageCode] 	= 	'" . $this->model->getLanguageCode () . "'
			AND		[isActive]		=	1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	*
			FROM 	LANGUAGE
			WHERE 	LANGUAGECODE 	= 	'" . $this->model->getLanguageCode () . "'
			AND		ISACTIVE		=	1";
		}
		$this->q->read ( $sql );
		$total = 0;
		$total = $this->q->numberRows ();
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		} else {
			$row = $this->q->fetchArray ();
			if ($this->duplicateTest == 1) {
				return $total . "|" . $row ['languageCode'];
			} else {
				$end = microtime(true);
				$time = $end - $start;
				echo json_encode (
				array (	"success" =>true,
							"total" => $total, 
							"message" => $this->systemString->getDuplicateMessage(), 
							"languageCode" => $row ['languageCode'],
							"time"=>$time ) );
				exit ();
			}
		}
	}
	function firstRecord($value) {
		$this->recordSet->firstRecord ( $value );
	}
	function nextRecord($value, $primaryKeyValue) {
		$this->recordSet->nextRecord ( $value, $primaryKeyValue );
	}
	function previousRecord($value, $primaryKeyValue) {
		$this->recordSet->previousRecord ( $value, $primaryKeyValue );
	}
	function lastRecord($value) {
		$this->recordSet->lastRecord ( $value );
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		if ($_SESSION ['start'] == 0) {
			$sql = str_replace ( "LIMIT", "", $_SESSION ['sql'] );
			$sql = str_replace ( $_SESSION ['start'] . "," . $_SESSION ['limit'], "", $sql );
		} else {
			$sql = $_SESSION ['sql'];
		}
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->excel->setActiveSheetIndex ( 0 );
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array ('borders' => array ('inside' => array ('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array ('argb' => '000000' ) ), 'outline' => array ('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array ('argb' => '000000' ) ) ) );
		// header all using  3 line  starting b


		if ($this->getIsAdmin() == 1) {
			$this->excel->getActiveSheet ()->getColumnDimension ( 'B' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'C' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'D' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'E' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'F' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'G' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'H' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'I' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'J' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'K' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'L' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'M' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'N' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'O' )->setAutoSize ( true );
		} else {
			$this->excel->getActiveSheet ()->getColumnDimension ( 'B' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'C' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'D' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'E' )->setAutoSize ( true );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'F' )->setAutoSize ( true );
		}
		if ($this->getIsAdmin() == 1) {
			$start = 'B';
			$end = '0';
		} else {
			$start = 'B';
			$end = 'F';
		}
		// merge header title
		$this->excel->getActiveSheet ()->setCellValue ( $start . '2', $this->title );
		$this->excel->getActiveSheet ()->setCellValue ( $end . '2', '' );
		$this->excel->getActiveSheet ()->mergeCells ( $start . '2:' . $end . '3' );
		// header of the row
		if ($this->getIsAdmin() == 1) {
			// future should take from table mapping table
			$this->excel->getActiveSheet ()->setCellValue ( 'B3', 'No' );
			$this->excel->getActiveSheet ()->setCellValue ( 'C3', 'language Id' );
			$this->excel->getActiveSheet ()->setCellValue ( 'D3', 'Sequence' );
			$this->excel->getActiveSheet ()->setCellValue ( 'E3', 'Code' );
			$this->excel->getActiveSheet ()->setCellValue ( 'F3', 'Note' );

			$this->excel->getActiveSheet ()->setCellValue ( 'G3', 'isDefault' );
			$this->excel->getActiveSheet ()->setCellValue ( 'H3', 'isNew' );
			$this->excel->getActiveSheet ()->setCellValue ( 'I3', 'isDraft' );
			$this->excel->getActiveSheet ()->setCellValue ( 'J3', 'isUpdate' );
			$this->excel->getActiveSheet ()->setCellValue ( 'K3', 'isDelete' );
			$this->excel->getActiveSheet ()->setCellValue ( 'L3', 'isActive' );
			$this->excel->getActiveSheet ()->setCellValue ( 'M3', 'isApproved' );
			$this->excel->getActiveSheet ()->setCellValue ( 'N3', 'By' );
			$this->excel->getActiveSheet ()->setCellValue ( 'O3', 'Time' );

		} else {
			$this->excel->getActiveSheet ()->setCellValue ( 'B3', 'No' );
			$this->excel->getActiveSheet ()->setCellValue ( 'C3', 'Sequence' );
			$this->excel->getActiveSheet ()->setCellValue ( 'D3', 'Code' );
			$this->excel->getActiveSheet ()->setCellValue ( 'E3', 'Note' );
		}
		// fill color
		$this->excel->getActiveSheet ()->getStyle ( $start . '2:' . $end . '2' )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$this->excel->getActiveSheet ()->getStyle ( $start . '2:' . $end . '2' )->getFill ()->getStartColor ()->setARGB ( '66BBFF' );
		$this->excel->getActiveSheet ()->getStyle ( $start . '3:' . $end . '3' )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$this->excel->getActiveSheet ()->getStyle ( $start . '3:' . $end . '3' )->getFill ()->getStartColor ()->setARGB ( '66BBFF' );
		//
		$loopRow = 4;
		$i = 0;
		while ( ($row = $this->q->fetchAssoc ()) == true ) {
			//	echo print_r($row);
			$this->excel->getActiveSheet ()->setCellValue ( 'B' . $loopRow, ++ $i );
			if ($this->getIsAdmin() == 1) {
				$this->excel->getActiveSheet ()->setCellValue ( 'C' . $loopRow, $row ['languageId'] );

				$this->excel->getActiveSheet ()->setCellValue ( 'E' . $loopRow, $row ['languageCode'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'F' . $loopRow, $row ['languageDesc'] );

				$this->excel->getActiveSheet ()->setCellValue ( 'G' . $loopRow, $row ['isDefault'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'H' . $loopRow, $row ['isNew'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'I' . $loopRow, $row ['isDraft'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'J' . $loopRow, $row ['isUpdate'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'K' . $loopRow, $row ['isDelete'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'L' . $loopRow, $row ['isActive'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'M' . $loopRow, $row ['isApproved'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'N' . $loopRow, $row ['staffName'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'O' . $loopRow, $row ['Time'] );
			} else {

				$this->excel->getActiveSheet ()->setCellValue ( 'D' . $loopRow, $row ['languageCode'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'E' . $loopRow, $row ['languageDesc'] );
			}
			$loopRow ++;

		}

		$lastRow = $end . $loopRow;

		$from = $start . '2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet ()->getStyle ( $formula )->applyFromArray ( $styleThinBlackBorderOutline );
		$objWriter = PHPExcel_IOFactory::createWriter ( $this->excel, 'Excel2007' );
		$filename = "language" . rand ( 0, 10000000 ) . ".xlsx";
		$path = $_SERVER ['DOCUMENT_ROOT'] . $this->getApplication () . "/management/document/excel/" . $filename;

		$this->documentTrail->setDocumentPath ( $path );
		$this->documentTrail->setDocumentFilename ( $filename );
		$this->documentTrail->create ();

		$objWriter->save ( $path );
		$file = fopen ( $path, 'r' );
		if ($file) {
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode (
			array (	"success" => true,
						"message" => $this->systemString->getFileGenerateMessage(), 
						"filename" => $filename,
						"time"=>$time ) );
			exit ();
		} else {
			echo json_encode ( array ("success" => false, "message" => $this->systemString->getFileNotGenerateMessage() ) );
			exit ();
		}
	}

}

$languageObject = new LanguageClass ();

/**
 * crud -create,read,update,delete
 **/
if (isset ( $_POST ['method'] )) {
	/*
	 *  Initilize Value before load in the loader
	 */

	/*
	 *  Leaf / Application Identification
	 */
	if (isset ( $_POST ['leafId'] )) {
		$languageObject->setLeafId ( $_POST ['leafId'] );
	}
	/*
	 *  Admin Only
	 */
	if (isset ( $_POST ['isAdmin'] )) {
		$languageObject->setIsAdmin ( $_POST ['isAdmin'] );
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$languageObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$languageObject->setLimit($_POST ['perPage']);
	}
	/*
	 * Filtering
	 */
	if (isset ( $_POST ['query'] )) {
		$languageObject->setFieldQuery ( $_POST ['query'] );
	}
	if (isset ( $_POST ['filter'] )) {

		$languageObject->setGridQuery ( $_POST ['filter'] );
	}
	/**
	 * Ordering
	 */
	if (isset ( $_POST ['order'] )) {
		$languageObject->setOrder ( $_POST ['order'] );
	}
	if (isset ( $_POST ['sortField'] )) {
		$languageObject->setSortField ( $_POST ['sortField'] );
	}

	/*
	 *  Load the dynamic value
	 */
	$languageObject->execute ();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$languageObject->create ();
	}
	if ($_POST ['method'] == 'read') {
		$languageObject->read ();
	}
	if ($_POST ['method'] == 'save') {
		$languageObject->update ();
	}
	if ($_POST ['method'] == 'delete') {
		$languageObject->delete ();
	}

}

if (isset ( $_GET ['method'] )) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset ( $_GET ['leafId'] )) {
		$languageObject->setLeafId ( $_GET ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_GET ['isAdmin'] )) {
		$languageObject->setIsAdmin ( $_GET ['isAdmin'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$languageObject->execute ();
	if (isset ( $_GET ['field'] )) {
		if ($_GET ['field'] == 'staffId') {
			$languageObject->staff ();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$languageObject->updateStatus ();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset ( $_GET ['languageCode'] )) {
		if (strlen ( $_GET ['languageCode'] ) > 0) {
			$languageObject->duplicate ();
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$languageObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$languageObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$languageObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$languageObject->lastRecord('json');
		}
	}
	/*
	 *  Excel Reporing
	 */
	if (isset ( $_GET ['mode'] )) {
		if ($_GET ['mode'] == 'excel') {

			$languageObject->excel ();
		}
	}
}

?>
