<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSecurity.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/leafModel.php");

/**
 * this is leaf creation
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @package Leaf Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LeafClass extends ConfigClass {

	/**
	 * Connection to the database
	 * @var string
	 */
	public $q;

	/**
	 * Program Identification
	 * @var int
	 */
	public $leafTempId;

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
	 * Duplicate Testing either the key of modulele same or have been created.
	 * @var bool
	 */
	public $duplicateTest;

	/**
	 * Common class function for security menu
	 * @var  string
	 */
	private $security;

	/**
	 * Class Loader
	 */
	public function execute() {
		parent::__construct();
		// audit property
		$this->audit = 0;
		$this->log = 0;

		$this->model = new LeafModel ();
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
			INSERT INTO `leaf`
					(
						`moduleId`,												`folderId`,
						`leafEnglish`,											`leafSequence`,
						`leafcode`,												`leafFilename`,
						`iconId`,												`isDefault`,
						`isNew`,												`isDraft`,
						`isUpdate`,												`isDelete`,
						`isActive`,												`isApproved`,
						`executeBy`,											`executeTime`
					)
			VALUES
					(
						'" . $this->model->getModuleId() . "',					'" . $this->model->getFolderId() . "',
						'" . $this->model->getLeafNote() . "',					'" . $this->model->getLeafSequence() . "',
						'" . $this->model->getLeafCode() . "',					'" . $this->model->getLeafFilename() . "',
						'" . $this->model->getIconId() . "',					'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',		
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',		
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',		
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					) ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			INSERT INTO [leaf]
					(
						[moduleId],												[folderId],
						[leafEnglish],											[leafSequence],
						[leafCode],												[leafFilename],
						[iconId],												[isDefault],
						[isNew],												[isDraft],
						[isUpdate],												[isDelete],
						[isActive],												[isApproved],
						[executeBy],											[executeTime]
				VALUES
					(
						'" . $this->model->getModuleId() . "',					'" . $this->model->getFolderId() . "',
						'" . $this->model->getLeafNote() . "',					'" . $this->model->getLeafSequence() . "',
						'" . $this->model->getLeafCode() . "',					'" . $this->model->getLeafFilename() . "',
						'" . $this->model->getIconId() . "',					'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',		
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',		
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',		
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					)";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			INSERT INTO LEAF
					(
						MODULEID,												FOLDERID,
						LEAFNOTE,												LEAFSEQUENCE,
						LEAFCODE,												LEAFFILENAME,
						ICONID,													ISDEFAULT,
						ISNEW,													ISDRAFT,
						ISUPDATE,												ISDELETE,
						ISACTIVE,												ISAPPROVED,
						EXECUTEBY,												EXECUTETIME
					)
				VALUES
					(
						'" . $this->model->getModuleId() . "',					'" . $this->model->getFolderId() . "',
						'" . $this->model->getLeafNote() . "',					'" . $this->model->getLeafSequence() . "',
						'" . $this->model->getLeafCode() . "',					'" . $this->model->getLeafFilename() . "',
						'" . $this->model->getIconId() . "',					'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',		
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',		
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',		
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					);";
		}else if ($this->getVendor() == self::DB2) {
			$sql = "
			INSERT INTO LEAF
					(
						MODULEID,												FOLDERID,
						LEAFNOTE,												LEAFSEQUENCE,
						LEAFCODE,												LEAFFILENAME,
						ICONID,													ISDEFAULT,
						ISNEW,													ISDRAFT,
						ISUPDATE,												ISDELETE,
						ISACTIVE,												ISAPPROVED,
						EXECUTEBY,												EXECUTETIME
					)
				VALUES
					(
						'" . $this->model->getModuleId() . "',					'" . $this->model->getFolderId() . "',
						'" . $this->model->getLeafNote() . "',					'" . $this->model->getLeafSequence() . "',
						'" . $this->model->getLeafCode() . "',					'" . $this->model->getLeafFilename() . "',
						'" . $this->model->getIconId() . "',					'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',		
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',		
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',		
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					);";
		}else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			INSERT INTO LEAF
					(
						MODULEID,												FOLDERID,
						LEAFNOTE,												LEAFSEQUENCE,
						LEAFCODE,												LEAFFILENAME,
						ICONID,													ISDEFAULT,
						ISNEW,													ISDRAFT,
						ISUPDATE,												ISDELETE,
						ISACTIVE,												ISAPPROVED,
						EXECUTEBY,												EXECUTETIME
					)
				VALUES
					(
						'" . $this->model->getModuleId() . "',					'" . $this->model->getFolderId() . "',
						'" . $this->model->getLeafNote() . "',					'" . $this->model->getLeafSequence() . "',
						'" . $this->model->getLeafCode() . "',					'" . $this->model->getLeafFilename() . "',
						'" . $this->model->getIconId() . "',					'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',		
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',		
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',		
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					);";
		}
		$this->q->create($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$lastId = $this->q->lastInsertId();
		// loop the group
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT 	`staffId`
			FROM 	`staff`
			WHERE 	`isActive`	=	1 ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT 	[staffId]
			FROM 	[staff]
			WHERE 	[isActive]	=	1 ";
		} else if ($this->q->vendor == self::MYSQL) {
			$sql = "
			SELECT 	STAFFID
			FROM 	STAFF 
			WHERE 	ISACTIVE	=	1 ";
		}
		$this->q->read($sql);
		$data = $this->q->activeRecord();
		$sqlLooping='';
		foreach ($data as $row) {
			// by default no access
			$sqlLooping .= "
				(
					'" . $lastId . "',				'" . $row ['staffId'] . "',
					'0',							'0',
					'0',							'0',
					'0',							'0',
					'0',							'0',
					'0'
				),";
		}
		// optimize to 1 Query
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			INSERT INTO	`leafAccess`
					(
						`leafId`,					`staffId`,
						`leafAccessDraftValue`,		`leafAccessCreateValue`,
						`leafAccessReadValue`,		`leafAccessUpdateValue`,
						`leafAccessDeleteValue`,	`leafAccessReviewValue`,
						`leafAccessApprovedValue`,	`leafAccessPostValue`,
						`leafAccessPrintValue`
					)
			VALUES";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			INSERT INTO	[leafAccess]
				(
					[leafId],					[staffId],
					[leafAccessDraftValue],		[leafAccessCreateValue],
					[leafAccessReadValue],		[leafAccessUpdateValue],
					[leafAccessDeleteValue],	[leafAccessReviewValue],
					[leafAccessApprovedValue],	[leafAccessPostValue],
					[leafAccessPrintValue]
				)
			VALUES";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			INSERT INTO 	LEAFACCESS
						(
							LEAFID,						STAFFID,
							LEAFACCESSDRAFT,			LEAFACCESSCREATEVALUE,
							LEAFACCESSREADVALUE,		LEAFACCESSUPDATEVALUE,
							LEAFACCESSDELETEVALUE,		LEAFACCESSREVIEWVALUE,
							LEAFACCESSAPPROVEDVALUE,	LEAFACCESSPOSTVALUE,
							LEAFACCESSPRINTVALUE
						)
			VALUES";
		}
		// remove last comma
		$sqlLooping = substr($sqlLooping, 0, - 1);
		// combine SQL Statement
		$sql .= $sqlLooping;
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		/**
		 * insert default value to detail leaf.English only
		 * */
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
						) VALUES (
							'" . $lastId . "',												'" . $this->getDefaultLanguageId() . "',
							'" . $this->model->getLeafEnglish() . "',					'" . $this->model->getIsDefault(0, 'single') . "',			
							'" . $this->model->getIsNew(0, 'single') . "',					'" . $this->model->getIsDraft(0, 'single') . "',				
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
						'" . $lastId . "',													'" . $this->getDefaultLanguageId() . "',
						'" . $this->model->getLeafEnglish() . "',						'" . $this->model->getIsDefault(0, 'single') . "',			
						'" . $this->model->getIsNew(0, 'single') . "',					'" . $this->model->getIsDraft(0, 'single') . "',				
						'" . $this->model->getIsUpdate(0, 'single') . "',				'" . $this->model->getIsDelete(0, 'single') . "',			
						'" . $this->model->getIsActive(0, 'single') . "',				'" . $this->model->getIsApproved(0, 'single') . "',			
						'" . $this->model->getIsReview(0, 'single') . "',				'" . $this->model->getIsPost(0, 'single') . "',										
						'" . $this->model->getExecuteBy() . "',							" . $this->model->getExecuteTime() . "
			);";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			INSERT INTO	LEAFTRANSLATE
				(
						LEAFID,														LANGUAGEID,
						LEAFNATIVE,													ISDEFAULT,							
						ISNEW,															ISDRAFT,								
						ISUPDATE,														ISDELETE,								
						ISACTIVE,														ISAPPROVED,							
						ISREVIEW,														ISPOST,
						EXECUTEBY,														EXECUTETIME
			)VALUES	(
						'" . $lastId . "',												'" . $this->getDefaultLanguageId() . "',
						'" . $this->model->geLeafEnglish() . "',						'" . $this->model->getIsDefault(0, 'single') . "',	
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
							LEAFID,														LANGUAGEID,
							LEAFNATIVE,													ISDEFAULT,
							ISNEW,															ISDRAFT,
							ISUPDATE,														ISDELETE,
							ISACTIVE,														ISAPPROVED,
							ISREVIEW,														ISPOST,
							EXECUTEBY,														EXECUTETIME
			)VALUES	(
							'" . $lastId . "',												'" . $this->getDefaultLanguageId() . "',
							'" . $this->model->getLeafNative() . "',						'" . $this->model->getIsDefault(0, 'single') . "',
							'" . $this->model->getIsNew(0, 'single') . "',				'" . $this->model->getIsDraft(0, 'single') . "',
							'" . $this->model->getIsUpdate(0, 'single') . "',			'" . $this->model->getIsDelete(0, 'single') . "',
							'" . $this->model->getIsActive(0, 'single') . "',			'" . $this->model->getIsApproved(0, 'single') . "',
							'" . $this->model->getIsReview(0, 'single') . "',			'" . $this->model->getIsPost(0, 'single') . "',
							'" . $this->model->getExecuteBy() . "',						" . $this->model->getExecuteTime() . "
			)";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			INSERT INTO	FOLDERTRANSLATE
			(
						LEAFID,														LANGUAGEID,
						LEAFNATIVE,													ISDEFAULT,
						ISNEW,															ISDRAFT,
						ISUPDATE,														ISDELETE,
						ISACTIVE,														ISAPPROVED,
						ISREVIEW,														ISPOST,
						EXECUTEBY,														EXECUTETIME
			)VALUES	(
						'" . $lastId . "',												'" . $this->getDefaultLanguageId() . "',
						'" . $this->model->getLeafNative() . "',						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',				'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',			'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',			'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',			'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',						" . $this->model->getExecuteTime() . "
			)";
		}
		$this->q->create($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(array("success" => true, "leafId" => $lastId, "message" => $this->systemString->getCreateMessage()));
		exit();
	}

	function read() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getIsAdmin() == 0) {
			if ($this->getVendor() == self::MYSQL) {
				$this->auditFilter = "	`leaf`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[leaf].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	LEAF.ISACTIVE	=	1	";
			}
		} else if ($this->getIsAdmin() == 1) {
			if ($this->getVendor() == self::MYSQL) {
				$this->auditFilter = "	 1 ";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	1 = 1 ";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = " 1 = 1 ";
			}
		}

		
		if ($this->getVendor() == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$items = array();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT		*
			FROM 		`leaf`
			JOIN		`folder`
			USING		(`folderId`,`moduleId`)
			JOIN		`module`
			USING		(`moduleId`)
			LEFT JOIN	`icon`
			ON			`leaf`.`iconId`=`icon`.`iconId`
			WHERE 		" . $this->auditFilter . "
			AND			`folder`.`isActive`		=	1
			AND			`module`.`isActive`	= 1 ";
			if ($this->model->getLeafId(0, 'single')) {
				$sql .= " AND `" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`='" . $this->model->getLeafId(0, 'single') . "'";
			}
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT		*
			FROM 		[leaf]
			JOIN		[folder]
			ON			[leaf].[folderId] 			=	[folder].[folderId]
			AND			[leaf].[moduleId] 		=	[folder].[moduleId]
			JOIN		[module]
			ON			[leaf].[moduleId] 		=	[module].[moduleId]
			LEFT JOIN	[icon]
			ON			[leaf].[iconId]				=	[icon].[iconId]
			WHERE 		" . $this->auditFilter . "
			AND			[folder].[isActive]			=	1
			AND			[module].[isActive]			=	1 ";
			if ($this->model->getLeafId(0, 'single')) {
				$sql .= " AND [" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]='" . $this->model->getLeafId(0, 'single') . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT		LEAF.LEAFID 		AS	\"leafId\",
						LEAF.LEAFCODE 		AS 	\"leafCode\",
						LEAF.LEAFSEQUENCE 	AS 	\"leafSequence\",
						LEAF.LEAFNOTE 		AS 	\"leafEnglish\",
						LEAF.LEAFFILENAME 	AS 	\"leafFilename\",
						LEAF.ISDEFAULT 		AS 	\"isDefault\",
						LEAF.ISNEW 			AS	\"isNew\",
						LEAF.ISDRAFT  		AS 	\"isDraft\",
						LEAF.ISUPDATE 		AS 	\"isUpdate\",
						LEAF.ISDELETE 		AS 	\"isDelete\",
						LEAF.ISACTIVE 		AS 	\"isActive\",
						LEAF.ISAPPROVED 	AS 	\"isApproved\",
						LEAF.EXECUTEBY 		AS 	\"executeBy\",
						LEAF.EXECUTETIME 	AS  \"executeTime\",
						FOLDER.FOLDERID		AS	\"folderId\",
						FOLDER.FOLDERENGLISH	AS	\"folderEnglish\",
						MODULE.MODULEID		AS 	\"moduleId\",		
						MODULE.MODULEENGLISH	AS  \"moduleEnglish\",
						LEAF.LEAFCATEGORYID AS  \"leafCategoryId\",
						STAFF.STAFFNAME 	AS 	\"staffName\"
			FROM 		LEAF
			JOIN		FOLDER
			ON			LEAF.MODULEID 	= FOLDER.MODULEID
			AND			LEAF.FOLDERID	= FOLDER.FOLDERID
			JOIN		MODULE
			ON			LEAF.MODULEID 	= MODULE.MODULEID
			LEFT JOIN	ICON
			ON			LEAF.ICONID		= ICON.ICONID
			JOIN		STAFF
			ON			LEAF.EXECUTEBY = STAFF.STAFFID
			WHERE 		" . $this->auditFilter . "
			AND			FOLDER.ISACTIVE = 1
			AND			MODULE.ISACTIVE = 1 ";
			if ($this->model->getLeafId(0, 'single')) {
				$sql .= " AND " . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "='" . $this->model->getLeafId(0, 'single') . "'";
			}
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = array("`leaf`.`leafFilename`");
		/**
		 * filter modulele
		 * @variables $tableArray
		 */
		$tableArray = array('module', 'moduleTranslate', 'folder', 'folderTranslate', 'leaf', 'leafTranslate');
		if ($this->getfieldQuery()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= $this->q->quickSearch($tableArray, $filterArray);
			} else if ($this->getVendor() == self::MSSQL) {
				$tempSql = $this->q->quickSearch($tableArray, $filterArray);
				$sql .= $tempSql;
			} else if ($this->getVendor() == self::ORACLE) {
				$tempSql = $this->q->quickSearch($tableArray, $filterArray);
				$sql .= $tempSql;
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
			}
		}
		//echo $sql;
		$this->q->read($sql);
		$total = $this->q->numberRows();
		if (empty($_GET ['dir'])) {
			$dir = 'ASC';
		} else {
			$dir = $_GET ['dir'];
		}
		if (empty($_POST ['sort'])) {
			$sortField = "leafId";
		} else {
			$sortField = $_POST ['sort'];
		}
		if ($this->getOrder() && $this->getSortField()) {
			if ($this->getVendor() == self::MYSQL) {
				$sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . "  " . strtoupper($this->getOrder()) . " ";
			}
		}
		$_SESSION ['sql'] = $sql;
		$_SESSION ['start'] = $this->getStart();
		$_SESSION ['limit'] = $this->getLimit();
		if (!($this->getGridQuery())) {
			if ($this->getLimit()) {
				// only mysql have limit
				if ($this->getVendor() == self::MYSQL) {
					$sql .= " LIMIT  " . $this->getStart() . "," . $this->getLimit() . " ";
				} else if ($this->getVendor() == self::MSSQL) {
					/**
					 * Sql Server and Oracle used row_number
					 * Parameterize Query We don't support
					 */
					$sql = "
							WITH [religionDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [leafId]) AS 'RowNumber'
							
			FROM 		[leaf]
			JOIN		[folder]
			ON			[leaf].[folderId] 			=	[folder].[folderId]
			AND			[leaf].[moduleId] 		=	[folder].[moduleId]
			JOIN		[module]
			ON			[leaf].[moduleId] 		=	[module].[moduleId]
			LEFT JOIN	[icon]
			ON			[leaf].[iconId]				=	[icon].[iconId]
			WHERE 		" . $this->auditFilter . "
			AND			[folder].[isActive]			=	1
			AND			[module].[isActive]			=	1   " . $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[religionDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $this->getStart() . "
							AND 			" . ($this->getStart() + $_POST ['limit'] - 1) . ";";
				} else if ($this->getVendor() == self::ORACLE) {
					/**
					 * Oracle using derived modulele also
					 */
					$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT		LEAF.LEAFID 		AS	\"leafId\",
						LEAF.LEAFCODE 		AS 	\"leafCode\",
						LEAF.LEAFSEQUENCE 	AS 	\"leafSequence\",
						LEAF.LEAFNOTE 		AS 	\"leafEnglish\",
						LEAF.LEAFFILENAME 	AS 	\"leafFilename\",
						LEAF.ISDEFAULT 		AS 	\"isDefault\",
						LEAF.ISNEW 			AS	\"isNew\",
						LEAF.ISDRAFT  		AS 	\"isDraft\",
						LEAF.ISUPDATE 		AS 	\"isUpdate\",
						LEAF.ISDELETE 		AS 	\"isDelete\",
						LEAF.ISACTIVE 		AS 	\"isActive\",
						LEAF.ISAPPROVED 	AS 	\"isApproved\",
						LEAF.EXECUTEBY 		AS 	\"executeBy\",
						LEAF.EXECUTETIME 	AS  \"executeTime\",
						FOLDER.FOLDERID		AS	\"folderId\",
						FOLDER.FOLDERENGLISH	AS	\"folderEnglish\",
						MODULE.MODULEID		AS 	\"moduleId\",		
						MODULE.MODULEENGLISH	AS  \"moduleEnglish\",
						LEAF.LEAFCATEGORYID AS  \"leafCategoryId\",
						STAFF.STAFFNAME 	AS 	\"staffName\"
			FROM 		LEAF
			JOIN		FOLDER
			ON			LEAF.MODULEID 	= FOLDER.MODULEID
			AND			LEAF.FOLDERID	= FOLDER.FOLDERID
			JOIN		MODULE
			ON			LEAF.MODULEID 	= MODULE.MODULEID
			LEFT JOIN	ICON
			ON			LEAF.ICONID		= ICON.ICONID
			JOIN		STAFF
			ON			LEAF.EXECUTEBY = STAFF.STAFFID
			WHERE 		" . $this->auditFilter . "
			AND			FOLDER.ISACTIVE = 1
			AND			MODULE.ISACTIVE = 1  " . $tempSql . $tempSql2 . "
								 ) a
						where rownum <= '" . ($this->getStart() + $_POST ['limit'] - 1) . "' )
						where r >=  '" . $this->getStart() . "'";
				} else {
					echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
				}
			}
		}
		/*
		 *  Only Execute One Query
		 */
		if (!($this->model->getLeafId(0, 'single'))) {
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

		if ($this->model->getLeafId(0, 'single')) {
			$end = microtime(true);
			$time = $end - $start;
			$json_encode = json_encode(
			array(	'success' => true,
						'total' => $total, 
						'time' => $time, 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getLeafId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getLeafId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value'),
						'data' => $items));
			$json_encode = str_replace("[", "", $json_encode);
			$json_encode = str_replace("]", "", $json_encode);
			echo $json_encode;
		} else {
			$end = microtime(true);
			$time = $end - $start;
			if (count($items) == 0) {
				$items = '';
			}
			echo json_encode(
			array(	'success' => true,
							'total' => $total, 
							'time' => $time, 
            				'firstRecord' => $this->recordSet->firstRecord('value'), 
            				'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getLeafId(0, 'single')), 
            				'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getLeafId(0, 'single')), 
            				'lastRecord' => $this->recordSet->lastRecord('value'),
							'data' => $items));
			exit();
		}
	}

	/**
	 * Return module Identification
	 */
	function module() {
		$this->security->module($this->model->getType(), $this->model->getTeamId());
	}

	/**
	 * Return Folder Identification
	 */
	function folder() {

		$this->security->folder($this->model->getType(), $this->model->getTeamId(), $this->model->getModuleId());
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
		WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getLeafId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
		SELECT	[" . $this->model->getPrimaryKeyName() . "]
		FROM 	[" . $this->model->getTableName() . "]
		WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getLeafId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
		SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
		FROM 	" . strtoupper($this->model->getTableName()) . "
		WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getLeafId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
		SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
		FROM 	" . strtoupper($this->model->getTableName()) . "
				WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getLeafId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getLeafId(0, 'single') . "' ";
		}
		$result = $this->q->fast($sql);
		$total = $this->q->numberRows($result, $sql);
		if ($total == 0) {
			echo json_encode(array("success" => false, "message" => $this->systemString->getRecordNotFoundMessage()));
			exit();
		} else {
			if ($this->getVendor() == self::MYSQL) {
				$sql = "
			UPDATE	`leaf`
			SET		`isDefault`				=	'" . $this->model->getIsDefault(0, 'single') . "',
					`isActive`				=	'" . $this->model->getIsActive(0, 'single') . "',
					`isNew`					=	'" . $this->model->getIsNew(0, 'single') . "',
					`isDraft`				=	'" . $this->model->getIsDraft(0, 'single') . "',
					`isUpdate`				=	'" . $this->model->getIsUpdate(0, 'single') . "',
					`isDelete`				=	'" . $this->model->getIsDelete(0, 'single') . "',
					`isApproved`			=	'" . $this->model->getIsApproved(0, 'single') . "',
					`executeBy`				=	'" . $this->model->getExecuteBy() . "',
					`executeTime`			=	" . $this->model->getExecuteTime() . "
			WHERE 	`leafId`				=	'" . $this->getLeafId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
			UPDATE	[leaf]
			SET		 [isDefault]			=	'" . $this->model->getIsDefault(0, 'single') . "',
					[isActive]				=	'" . $this->model->getIsActive(0, 'single') . "',
					[isNew]					=	'" . $this->model->getIsNew(0, 'single') . "',
					[isDraft]				=	'" . $this->model->getIsDraft(0, 'single') . "',
					[isUpdate]				=	'" . $this->model->getIsUpdate(0, 'single') . "',
					[isDelete]				=	'" . $this->model->getIsDelete(0, 'single') . "',
					[isApproved]			=	'" . $this->model->getIsApproved(0, 'single') . "',
					[executeBy]				=	'" . $this->model->getExecuteBy() . "',
					[executeTime]			=	" . $this->model->getExecuteTime() . "
			WHERE 	[leafId]				=	'" . $this->getLeafId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
			UPDATE	LEAF
			SET		ISACTIVE		=	'" . $this->model->getIsActive . "',
					ISNEW			=	'" . $this->model->getIsNew . "',
					ISDRAFT			=	'" . $this->model->getIsDraft . "',
					ISUPDATE		=	'" . $this->model->getIsUpdate . "',
					ISDELETE		=	'" . $this->model->getIsDelete . "',
					ISAPPROVED		=	'" . $this->model->getIsApproved . "',
					EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
					EXECUTETIME		=	" . $this->model->getTime . "
			WHERE 	LEAFID			=	'" . $this->getLeafId(0, 'single') . "'";
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
		WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getLeafId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
		SELECT	[" . $this->model->getPrimaryKeyName() . "]
		FROM 	[" . $this->model->getTableName() . "]
		WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getLeafId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
		SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
		FROM 	" . strtoupper($this->model->getTableName()) . "
		WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getLeafId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
		SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
		FROM 	" . strtoupper($this->model->getTableName()) . "
				WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getLeafId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getLeafId(0, 'single') . "' ";
		}
		$result = $this->q->fast($sql);
		$total = $this->q->numberRows($result, $sql);
		if ($total == 0) {
			echo json_encode(array("success" => false, "message" => $this->systemString->getRecordNotFoundMessage()));
			exit();
		} else {
			if ($this->getVendor() == self::MYSQL) {
				$sql = "
			UPDATE	`leaf`
			SET		`isDefault`				=	'" . $this->model->getIsDefault(0, 'single') . "',
					`isActive`				=	'" . $this->model->getIsActive . "',
					`isNew`					=	'" . $this->model->getIsNew . "',
					`isDraft`				=	'" . $this->model->getIsDraft . "',
					`isUpdate`				=	'" . $this->model->getIsUpdate . "',
					`isDelete`				=	'" . $this->model->getIsDelete . "',
					`isApproved`			=	'" . $this->model->getIsApproved . "',
					`executeBy`				=	'" . $this->model->getExecuteBy() . "',
					`executeTime`			=	" . $this->model->getExecuteTime() . "
			WHERE 	`leafId`				=	'" . $this->model->getLeafId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
			UPDATE	[leaf]
			SET		[isDefault]				=	'" . $this->model->getIsDefault(0, 'single') . "',
					[isActive]				=	'" . $this->model->getIsActive(0, 'single') . "',
					[isNew]					=	'" . $this->model->getIsNew(0, 'single') . "',
					[isDraft]				=	'" . $this->model->getIsDraft(0, 'single') . "',
					[isUpdate]				=	'" . $this->model->getIsUpdate(0, 'single') . "',
					[isDelete]				=	'" . $this->model->getIsDelete(0, 'single') . "',
					[isApproved]			=	'" . $this->model->getIsApproved(0, 'single') . "',
					[executeBy]				=	'" . $this->model->getExecuteBy() . "',
					[executeTime]			=	" . $this->model->getExecuteTime() . "
			WHERE 	[leafId]				=	'" . $this->getLeafId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
			UPDATE	LEAF
			SET		ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
					ISACTIVE		=	'" . $this->model->getIsActive(0, 'single') . "',
					ISNEW			=	'" . $this->model->getIsNew(0, 'single') . "',
					ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
					ISUPDATE		=	'" . $this->model->getIsUpdate(0, 'single') . "',
					ISDELETE		=	'" . $this->model->getIsDelete(0, 'single') . "',
					ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
					EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
					EXECUTETIME		=	" . $this->model->getExecuteTime() . "
			WHERE 	LEAFID			=	'" . $this->model->getLeafId(0, 'single') . "'";
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
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {

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
							WHEN '" . $this->model->getLeafId($i, 'array') . "'
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
							WHEN '" . $this->model->getLeafId($i, 'array') . "'
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
							WHEN '" . $this->model->getLeafId($i, 'array') . "'
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
							WHEN '" . $this->model->getLeafId($i, 'array') . "'
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
							WHEN '" . $this->model->getLeafId($i, 'array') . "'
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
							WHEN '" . $this->model->getLeafId($i, 'array') . "'
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
							WHEN '" . $this->model->getLeafId($i, 'array') . "'
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
                            WHEN '" . $this->model->getLeafId($i, 'array') . "'
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
                                WHEN '" . $this->model->getLeafId($i, 'array') . "'
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
	public function nextSequence() {
		$this->recordSet->nextSequence($this->model->getModuleId(), $this->model->getFolderId());
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
		$this->excel->getActiveSheet()->setCellValue('C3', 'Name');
		$this->excel->getActiveSheet()->setCellValue('D3', 'Description');
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');
		//
		$loopRow = 4;
		$this->q->numberRows();
		$i = 0;
		while (($row = $this->q->fetchAssoc()) == TRUE) {
			//	echo print_r($row);
			$this->excel->getActiveSheet()->setCellValue('B' . $loopRow, ++$i);
			$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, $row ['leafEnglish']);
			$this->excel->getActiveSheet()->setCellValue('D' . $loopRow, $row ['leafCode']);
			$loopRow++;
			$lastRow = 'D' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename = "leaf" . rand(0, 10000000) . ".xlsx";
		$path = $_SERVER ['document_root'] . "/" . $this->application . "/security/document/excel/" . $filename;
		$objWriter->save($path);
		$file = fopen($path, 'r');
		if ($file) {
			echo json_encode(array("success" => true, "message" => $this->systemString->getFileGenerateMessage(),"time"=>$time));
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getFileNotGenerateMessage()));
		}
	}

}

//echo "string".$_GET['leafId'];
$leafObject = new LeafClass ();
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
	if (isset($_POST ['leafIdTemp'])) {
		$leafObject->setLeafId($_POST ['leafIdTemp']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$leafObject->setIsAdmin($_POST ['isAdmin']);
	}
	/**
	 * Paging
	 */
	if (isset($_POST ['start'])) {
		$leafObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$leafObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Filtering
	 */
	if (isset($_POST ['query'])) {
		$leafObject->setFieldQuery($_POST ['query']);
	}
	if (isset($_POST ['filter'])) {
		$leafObject->setGridQuery($_POST ['filter']);
	}
	/*
	 *  Ordering
	 */
	if (isset($_POST ['order'])) {
		$leafObject->setOrder($_POST ['order']);
	}
	if (isset($_POST ['sortField'])) {
		$leafObject->setSortField($_POST ['sortField']);
	}
	/*
	 *
	 * Translation
	 */
	if (isset($_POST ['leafTranslate'])) {
		$leafObject->leafTranslate = $_POST ['leafTranslate'];
	}
	/*
	 *  Load the dynamic value
	 */
	$leafObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$leafObject->create();
	}
	if ($_POST ['method'] == 'read') {
		$leafObject->read();
	}
	if ($_POST ['method'] == 'save') {
		$leafObject->update();
	}
	if ($_POST ['method'] == 'delete') {
		$leafObject->delete();
	}
}
if (isset($_GET ['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf /Application
	 */
	if (isset($_GET ['leafIdTemp'])) {
		$leafObject->setLeafId($_GET ['leafIdTemp']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET ['isAdmin'])) {
		$leafObject->setIsAdmin($_GET ['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$leafObject->execute();
	if (isset($_GET ['field'])) {
		if ($_GET ['field'] == 'staffId') {
			$leafObject->staff();
		}
		if ($_GET ['field'] == 'moduleId') {
			$leafObject->module();
		}
		if ($_GET ['field'] == 'folderId') {
			$leafObject->folder();
		}
		if ($_GET ['field'] == 'sequence') {
			$leafObject->nextSequence();
		}
	}
	/*
	 * Update Status of The modulele. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$leafObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET ['leafCode'])) {
		if (strlen($_GET ['leafCode']) > 0) {
			$leafObject->duplicate();
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$leafObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$leafObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$leafObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$leafObject->lastRecord('json');
		}
	}
	/*
	 *  Excel Reporting
	 */
	if (isset($_GET ['mode'])) {
		if ($_GET ['mode'] == 'report') {
			$leafObject->excel();
		}
	}
}
?>
