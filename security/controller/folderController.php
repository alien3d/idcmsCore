<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSecurity.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/folderModel.php");

/**
 * this folder menu creation
 * @name IDCMS
 * @version
 * @author hafizan
 * @package Security
 * @subpackage Folder Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class FolderClass extends ConfigClass {

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
	 * @var  string
	 */
	private $security;

	/**
	 * Class Loader
	 */
	function execute() {
		parent::__construct();
		// audit property
		$this->audit = 1;
		$this->log = 1;

		$this->model = new FolderModel ();
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
			INSERT INTO `folder`
					(
						`moduleId`,													`iconId`,
						`folderSequence`,											`folderCode`,					
						`folderPath`,												`folderEnglish`,
						`isDefault`,												`isNew`,
						`isDraft`,													`isUpdate`,
						`isDelete`,													`isActive`,
						`isApproved`,												`isReview`,
						`isPost`,													`ExecuteBy`,
						`executeTime`
					)
			VALUES
					(
						'" . $this->model->getModuleId() . "',						'" . $this->model->getIconId() . "',
						'" . $this->model->getFolderSequence() . "', 				'" . $this->model->getFolderCode() . "',
						'" . $this->model->getfolderPath() . "'	,				'" . $this->model->getfolderEnglish() . "',
						'" . $this->model->getIsDefault(0, 'single') . "',		'" . $this->model->getIsNew(0, 'single') . "',
						'" . $this->model->getIsDraft(0, 'single') . "',			'" . $this->model->getIsUpdate(0, 'single') . "',
						'" . $this->model->getIsDelete(0, 'single') . "',		'" . $this->model->getIsActive(0, 'single') . "',
						'" . $this->model->getIsApproved(0, 'single') . "',		'" . $this->model->getIsReview(0, 'single') . "',
						'" . $this->model->getIsPost(0, 'single') . "',			'" . $this->model->getExecuteBy() . "',
						" . $this->model->getExecuteTime() . "
						
					
					);";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			INSERT INTO [folder]
					(
						[moduleId],													[iconId],
						[folderSequence],											[folderCode],					
						[folderPath],												[folderEnglish],
						[isDefault],												[isNew],
						[isDraft],													[isUpdate],
						[isDelete],													[isActive],
						[isApproved],												[isReview'],
						[isPost],													[executeBy],
						[executeTime]
				)
			VALUES
				(
						'" . $this->model->getModuleId() . "',						'" . $this->model->getIconId() . "',
						'" . $this->model->getFolderSequence() . "', 				'" . $this->model->getFolderCode() . "',
						'" . $this->model->getfolderPath() . "'	,				'" . $this->model->getfolderEnglish() . "',
						'" . $this->model->getIsDefault(0, 'single') . "',		'" . $this->model->getIsNew(0, 'single') . "',
						'" . $this->model->getIsDraft(0, 'single') . "',			'" . $this->model->getIsUpdate(0, 'single') . "',
						'" . $this->model->getIsDelete(0, 'single') . "',		'" . $this->model->getIsActive(0, 'single') . "',
						'" . $this->model->getIsApproved(0, 'single') . "',		'" . $this->model->getIsReview(0, 'single') . "',
						'" . $this->model->getIsPost(0, 'single') . "',			'" . $this->model->getExecuteBy() . "',
						" . $this->model->getExecuteTime() . "
					
					);";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			INSERT INTO 	FOLDER
						(
							MODULEID,												ICONID,
							FOLDERSEQUENCE,											FOLDERCODE,					
							FOLDERPATH,												FOLDERENGLISH,
							ISDEFAULT,												ISNEW,
							ISDRAFT,												ISUPDATE,
							ISDELETE,												ISACTIVE,
							ISAPPROVED,												ISREVIEW,
							ISPOST,													EXECUTEBY,
							EXECUTETIME
				VALUES	(
							'" . $this->model->getModuleId() . "',					'" . $this->model->getIconId() . "',
							'" . $this->model->getFolderSequence() . "', 			'" . $this->model->getFolderCode() . "',
							'" . $this->model->getfolderPath() . "'	,			'" . $this->model->getfolderEnglish() . "',
							'" . $this->model->getIsDefault(0, 'single') . "',	'" . $this->model->getIsNew(0, 'single') . "',
							'" . $this->model->getIsDraft(0, 'single') . "',		'" . $this->model->getIsUpdate(0, 'single') . "',
							'" . $this->model->getIsDelete(0, 'single') . "',	'" . $this->model->getIsActive(0, 'single') . "',
							'" . $this->model->getIsApproved(0, 'single') . "',	'" . $this->model->getIsReview(0, 'single') . "',
							'" . $this->model->getIsPost(0, 'single') . "',		'" . $this->model->getExecuteBy() . "',
							" . $this->model->getExecuteTime() . "
					)";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			INSERT INTO 	FOLDER
						(
							MODULEID,												ICONID,
							FOLDERSEQUENCE,											FOLDERCODE,					
							FOLDERPATH,												FOLDERENGLISH,
							ISDEFAULT,												ISNEW,
							ISDRAFT,												ISUPDATE,
							ISDELETE,												ISACTIVE,
							ISAPPROVED,												ISREVIEW,
							ISPOST,													EXECUTEBY,
							EXECUTETIME
				VALUES	(
							'" . $this->model->getModuleId() . "',					'" . $this->model->getIconId() . "',
							'" . $this->model->getFolderSequence() . "', 			'" . $this->model->getFolderCode() . "',
							'" . $this->model->getfolderPath() . "'	,			'" . $this->model->getfolderEnglish() . "',
							'" . $this->model->getIsDefault(0, 'single') . "',	'" . $this->model->getIsNew(0, 'single') . "',
							'" . $this->model->getIsDraft(0, 'single') . "',		'" . $this->model->getIsUpdate(0, 'single') . "',
							'" . $this->model->getIsDelete(0, 'single') . "',	'" . $this->model->getIsActive(0, 'single') . "',
							'" . $this->model->getIsApproved(0, 'single') . "',	'" . $this->model->getIsReview(0, 'single') . "',
							'" . $this->model->getIsPost(0, 'single') . "',		'" . $this->model->getExecuteBy() . "',
							" . $this->model->getExecuteTime() . "
					)";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			INSERT INTO 	FOLDER
						(
							MODULEID,												ICONID,
							FOLDERSEQUENCE,											FOLDERCODE,					
							FOLDERPATH,												FOLDERENGLISH,
							ISDEFAULT,												ISNEW,
							ISDRAFT,												ISUPDATE,
							ISDELETE,												ISACTIVE,
							ISAPPROVED,												ISREVIEW,
							ISPOST,													EXECUTEBY,
							EXECUTETIME
				VALUES	(
							'" . $this->model->getModuleId() . "',					'" . $this->model->getIconId() . "',
							'" . $this->model->getFolderSequence() . "', 			'" . $this->model->getFolderCode() . "',
							'" . $this->model->getfolderPath() . "'	,			'" . $this->model->getfolderEnglish() . "',
							'" . $this->model->getIsDefault(0, 'single') . "',	'" . $this->model->getIsNew(0, 'single') . "',
							'" . $this->model->getIsDraft(0, 'single') . "',		'" . $this->model->getIsUpdate(0, 'single') . "',
							'" . $this->model->getIsDelete(0, 'single') . "',	'" . $this->model->getIsActive(0, 'single') . "',
							'" . $this->model->getIsApproved(0, 'single') . "',	'" . $this->model->getIsReview(0, 'single') . "',
							'" . $this->model->getIsPost(0, 'single') . "',		'" . $this->model->getExecuteBy() . "',
							" . $this->model->getExecuteTime() . "
					)";
		}
		$this->q->create($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$lastId = $this->q->lastInsertId();
		//  create a record  in folderAccess.update no effect
		// loop the group
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
					SELECT 	`teamId`
					FROM 	`team`
					WHERE 	`isActive`	=	1 ";
		} else if ($this->q->vendor == self::MSSQL) {
			$sql = "
					SELECT 	[teamId]
					FROM 	[team]
					WHERE 	[isActive]	=	1 ";
		} else if ($this->q->vendor == self::ORACLE) {
			$sql = "
					SELECT 	TEAMID		AS \"teamId\"
					FROM 	TEAM
					WHERE 	ISACTIVE	=	1 ";
		} else if ($this->q->vendor == self::DB2) {
			$sql = "
					SELECT 	TEAMID		AS \"teamId\"
					FROM 	TEAM
					WHERE 	ISACTIVE	=	1 ";
		} else if ($this->q->vendor == self::POSTGRESS) {
			$sql = "
					SELECT 	TEAMID		AS \"teamId\"
					FROM 	TEAM
					WHERE 	ISACTIVE	=	1 ";
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$data = $this->q->activeRecord();
		$sqlLooping = '';
		foreach ($data as $row) {

			$sqlLooping .= "(
			'" . $lastId . "',
			'" . $row ['teamId'] . "',
			'0'
			),";
		}
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
						INSERT INTO	`folderAccess`
								(
									`folderId`,
									`teamId`,
									`folderAccessValue`
								) VALUES";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
						INSERT INTO	[folderAccess]
								(
									[folderId],
									[teamId],
									[folderAccessValue]
							) VALUES";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
						INSERT INTO	FOLDERACCESS
								(
									FOLDERID,
									TEAMID,
									FOLDERACCESSVALUE
							) VALUES";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
						INSERT INTO	FOLDERACCESS
								(
									FOLDERID,
									TEAMID,
									FOLDERACCESSVALUE
							) VALUES";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
						INSERT INTO	FOLDERACCESS
								(
									FOLDERID,
									TEAMID,
									FOLDERACCESSVALUE
							) VALUES";
		}
		// optimize to 1 Query
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
		 * insert default value to detail folderle .English only
		 * */
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
				 	INSERT INTO `folderTranslate`
				 		(
						 	`folderId`,														`languageId`,
							`folderNative`,													`isDefault`,							
							`isNew`,														`isDraft`,								
							`isUpdate`,														`isDelete`,								
							`isActive`,														`isApproved`,							
							`isReview`,														`isPost`,
							`executeBy`,													`executeTime`
						) VALUES (
							'" . $lastId . "',												'" . $this->getDefaultLanguageId() . "',
							'" . $this->model->getFolderEnglish() . "',					'" . $this->model->getIsDefault(0, 'single') . "',			
							'" . $this->model->getIsNew(0, 'single') . "',					'" . $this->model->getIsDraft(0, 'single') . "',				
							'" . $this->model->getIsUpdate(0, 'single') . "',			'" . $this->model->getIsDelete(0, 'single') . "',			
							'" . $this->model->getIsActive(0, 'single') . "',			'" . $this->model->getIsApproved(0, 'single') . "',			
							'" . $this->model->getIsReview(0, 'single') . "',			'" . $this->model->getIsPost(0, 'single') . "',										
							'" . $this->model->getExecuteBy() . "',						" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			INSERT INTO [folderTranslate]
					(
						[folderId],														[languageId],
						[folderNative],													[isDefault],
						[isNew],														[isDraft],
						[isUpdate],														[isDelete],
						[isActive],														[isApproved],
						[isReview],														[isPost],
						[executeBy],													[executeTime]
				)
			VALUES
				(
						'" . $lastId . "',													'" . $this->getDefaultLanguageId() . "',
						'" . $this->model->getFolderEnglish() . "',						'" . $this->model->getIsDefault(0, 'single') . "',			
						'" . $this->model->getIsNew(0, 'single') . "',					'" . $this->model->getIsDraft(0, 'single') . "',				
						'" . $this->model->getIsUpdate(0, 'single') . "',				'" . $this->model->getIsDelete(0, 'single') . "',			
						'" . $this->model->getIsActive(0, 'single') . "',				'" . $this->model->getIsApproved(0, 'single') . "',			
						'" . $this->model->getIsReview(0, 'single') . "',				'" . $this->model->getIsPost(0, 'single') . "',										
						'" . $this->model->getExecuteBy() . "',							" . $this->model->getExecuteTime() . "
			);";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			INSERT INTO	FOLDERTRANSLATE
				(
						FOLDERID,														LANGUAGEID,
						FOLDERNATIVE,													ISDEFAULT,							
						ISNEW,															ISDRAFT,								
						ISUPDATE,														ISDELETE,								
						ISACTIVE,														ISAPPROVED,							
						ISREVIEW,														ISPOST,
						EXECUTEBY,														EXECUTETIME
			)VALUES	(
						'" . $lastId . "',												'" . $this->getDefaultLanguageId() . "',
						'" . $this->model->getFolderEnglish() . "',						'" . $this->model->getIsDefault(0, 'single') . "',	
						'" . $this->model->getIsNew(0, 'single') . "',				'" . $this->model->getIsDraft(0, 'single') . "',				
						'" . $this->model->getIsUpdate(0, 'single') . "',			'" . $this->model->getIsDelete(0, 'single') . "',			
						'" . $this->model->getIsActive(0, 'single') . "',			'" . $this->model->getIsApproved(0, 'single') . "',			
						'" . $this->model->getIsReview(0, 'single') . "',			'" . $this->model->getIsPost(0, 'single') . "',										
						'" . $this->model->getExecuteBy() . "',						" . $this->model->getExecuteTime() . "
			)";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			INSERT INTO 	FOLDERTRANSLATE
			(
							FOLDERID,														LANGUAGEID,
							FOLDERNATIVE,													ISDEFAULT,
							ISNEW,															ISDRAFT,
							ISUPDATE,														ISDELETE,
							ISACTIVE,														ISAPPROVED,
							ISREVIEW,														ISPOST,
							EXECUTEBY,														EXECUTETIME
			)VALUES	(
							'" . $lastId . "',												'" . $this->getDefaultLanguageId() . "',
							'" . $this->model->getFolderNative() . "',						'" . $this->model->getIsDefault(0, 'single') . "',
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
						FOLDERID,														LANGUAGEID,
						FOLDERNATIVE,													ISDEFAULT,
						ISNEW,															ISDRAFT,
						ISUPDATE,														ISDELETE,
						ISACTIVE,														ISAPPROVED,
						ISREVIEW,														ISPOST,
						EXECUTEBY,														EXECUTETIME
			)VALUES	(
						'" . $lastId . "',												'" . $this->getDefaultLanguageId() . "',
						'" . $this->model->getFolderNative() . "',						'" . $this->model->getIsDefault(0, 'single') . "',
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
		echo json_encode(
		array(	"success" => true,
					"folderId" => $lastId, 
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
		if ($this->getIsAdmin() == 0) {
			if ($this->getVendor() == self::MYSQL) {
				$this->auditFilter = "	`folder`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[folder].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	FOLDER.ISACTIVE	=	1	";
			}
		} else if ($this->getIsAdmin() == 1) {
			if ($this->getVendor() == self::MYSQL) {
				$this->auditFilter = "	1= 1 ";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	1= 1 ";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = " 1= 1 ";
			}
		}

		$items = array();
		if ($this->getVendor() == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		// everything given flexibility  on todo
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			SELECT		`folder`.`folderId`,
						`folder`.`moduleId`,
						`folder`.`folderPath`,
						`folder`.`iconId`,
						`folder`.`folderSequence`,
						`folder`.`folderEnglish`,
						`folder`.`folderCode`,
						`folder`.`isDefault`,
						`folder`.`isNew`,
						`folder`.`isDraft`,
						`folder`.`isUpdate`,
						`folder`.`isDelete`,
						`folder`.`isActive`,
						`folder`.`isApproved`,
						`folder`.`isReview`,
						`folder`.`isPost`,
						`folder`.`executeTime`,
						`folder`.`executeBy`,
						`module`.`moduleSequence`,
						`module`.`moduleCode`,
						`module`.`moduleEnglish`,
						`module`.`moduleId`,
						`module`.`iconId`,
						`icon`.`iconId`,
						`icon`.`iconName`
			FROM 		`folder`
			JOIN 		`module`
			ON			`module`.`moduleId` = `folder`.`moduleId`
			LEFT JOIN	`icon`
			ON			`folder`.`iconId`=`icon`.`iconId`
			WHERE		`module`.`isActive`	=	1
			AND			" . $this->auditFilter;
			if ($this->model->getFolderId(0, 'single')) {
				$sql .= " AND `" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`='" . $this->model->getFolderId(0, 'single') . "'";
			}
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			SELECT 		[folder].[folderId],
						[folder].[moduleId],
						[folder].[folderPath],
						[folder].[iconId],
						[folder].[folderSequence],
						[folder].[folderEnglish],
						[folder].[folderCode],
						[folder].[isDefault],
						[folder].[isNew],
						[folder].[isDraft],
						[folder].[isUpdate],
						[folder].[isDelete],
						[folder].[isActive],
						[folder].[isApproved],
						[folder].[isReview],
						[folder].[isPost],
						[folder].[executeTime],
						[folder].[executeBy],
						[module].[moduleSequence],
						[module].[moduleCode],
						[module].[moduleEnglish],
						[module].[moduleId],
						[module].[iconId],
						[icon`.[iconId],
						[icon`.[iconName]
			FROM 		[folder]
			JOIN		[folderTranslate]
			JOIN 		[module]
			ON			[module].[moduleId] = 	[folder].[moduleId]
			LEFT JOIN	[icon]
			ON			[folder].[iconId]	=	[icon].[iconId]
			WHERE		[module].[isActive]	=	1 
			AND			" . $this->auditFilter;
			if ($this->model->getFolderId(0, 'single')) {
				$sql .= " AND [" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]='" . $this->model->getFolderId(0, 'single') . "'";
			}
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			SELECT		FOLDER.FOLDERID,
						FOLDER.MODULEID,
						FOLDER.FOLDERPATH,
						FOLDER.ICONID,
						FOLDER.FOLDERSEQUENCE,
						FOLDER.FOLDERENGLISH,
						FOLDER.FOLDERCODE,
						FOLDER.ISDEFAULT,
						FOLDER.ISNEW,
						FOLDER.ISDRAFT,
						FOLDER.ISUPDATE,
						FOLDER.ISDELETE,
						FOLDER.ISACTIVE,
						FOLDER.ISAPPROVED,
						FOLDER.ISREVIEW,
						FOLDER.ISPOST,
						FOLDER.EXECUTETIME,
						FOLDER.EXECUTEBY,
						MODULE.MODULESEQUENCE,
						MODULE.MODULECODE,
						MODULE.MODULEENGLISH,
						MODULE.MODULEID,
						MODULE.ICONID,
						ICON.ICONID,
						ICON.ICONNAME
			FROM		FOLDER
			JOIN	 	MODULE 
			ON 			MODULE.MODULEID = FOLDER.MODULEID
			LEFT JOIN 	ICON 
			ON 			FOLDER.ICONID = ICON.ICONID
			WHERE		MODULE.ISACTIVE = 1
			AND			" . $this->auditFilter;
			if ($this->model->getFolderId(0, 'single')) {
				$sql .= " AND 	" . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "=" . $this->model->getFolderId(0, 'single') . "'";
			}
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = array('moduleId', 'moduleTranslateId', 'folderId', 'folderTranslateId');
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = array('module', 'moduleTranslate', 'folder', 'folderTranslate');
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
				$tempSql = $this->q->quickSearch($tableArray, $filterArray);
				$sql .= $tempSql;
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
				$tempSql2 = $this->q->searching();
				$sql .= $tempSql2;
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql .= $this->q->searching();
			}
		}
		//echo $sql;
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
			// only mysql have limit
			if ($this->getVendor() == self::MYSQL) {
				$sql .= " LIMIT  " . $this->getStart() . "," . $this->getLimit() . " ";
				$sqlLimit = $sql;
			} else if ($this->getVendor() == self::MSSQL) {
				/**
				 * Sql Server and Oracle used row_number
				 * Parameterize Query We don't support
				 */
				$sqlLimit = "
							WITH [folderDerived] AS
							(
								SELECT	*,
								[folder].[executeBy],
								[folder].[executeTime]
								ROW_NUMBER() OVER (ORDER BY [folderId]) AS 'RowNumber'
								FROM 		[folder]

								JOIN 		[module]
								ON			[module].[moduleId` = [folder].[moduleId]

								LEFT JOIN	[icon]
								ON			[folder].[iconId]=[icon].[iconId]
								WHERE		[tab].[isActive]	=	1
								AND			[folder].[isActive]		=	1  " . $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[folderDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $this->getStart() . "
							AND 			" . ($this->getStart() + $_POST ['limit'] - 1) . ";";
			} else if ($this->getVendor() == self::ORACLE) {
				/**
				 * Oracle using derived table also
				 */
				$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT 		*,
												FOLDER.EXECUTEBY,
												FOLDER.EXECUTETIME
									FROM 		FOLDER
									JOIN		FOLDERTRANSLATE
									ON			FOLDER.FOLDERID	=FOLDERTRANSLATE.FOLDERID
									JOIN 		MODULE
									ON			MODULE.MODULEID = FOLDER.MODULEID
									JOIN		MODULETRANSLATE
									ON			MODULE.MODULEID=	MODULETRANSLATE.MODULEID
									AND			MODULETRANSLATE.MODULEID =FOLDER.MODULEID
									LEFT JOIN	ICON
									ON			FOLDER.ICONID=ICON.ICONID
									WHERE		MODULE.ISACTIVE=1
									AND			FOLDER.ISACTIVE=1 " . $tempSql . $tempSql2 . "
								 ) a
						WHERE rownum <= '" . ($this->getStart() + $this->getLimit() - 1) . "' )
						where r >=  '" . $this->getStart() . "'";
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			}
		}

		/*
		 *  Only Execute One Query
		 */
		if (!($this->model->getFolderId(0, 'single'))) {
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
		if ($this->model->getFolderId(0, 'single')) {
			$end = microtime(true);
			$time = $end - $start;
			$json_encode = json_encode(
			array(	'success' => true,
					'total' => $total, 
					'time' => $time, 
            		'firstRecord' => $this->recordSet->firstRecord('value'), 
            		'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getFolderId(0, 'single')), 
            		'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getFolderId(0, 'single')), 
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
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getFolderId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getFolderId(0, 'single')), 
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
		}
		$result = $this->q->fast($sql);
		$total = $this->q->numberRows($result, $sql);
		if ($total == 0) {
			echo json_encode(array("success" => false, "message" => $this->systemString->getRecordNotFoundMessage()));
			exit();
		} else {
			if ($this->getVendor() == self::MYSQL) {
				$sql = "
					UPDATE 	`folder`
					SET 	`moduleId`			=	'" . $this->model->getModuleId() . "',
							`folderEnglish`		=	'" . $this->model->getfolderEnglish() . "',
							`folderSequence`	=	'" . $this->model->getfolderSequence() . "',
							`folderCode`		=	'" . $this->model->getfolderCode() . "',
							`folderPath`		=	'" . $this->model->getfolderPath() . "',
							`iconId`			=	'" . $this->model->getIconId() . "',
							`isDefault`			=	'" . $this->model->getIsDefault(0, 'single') . "',
							`isActive`			=	'" . $this->model->getIsActive(0, 'single') . "',
							`isNew`				=	'" . $this->model->getIsNew(0, 'single') . "',
							`isDraft`			=	'" . $this->model->getIsDraft(0, 'single') . "',
							`isUpdate`			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							`isDelete`			=	'" . $this->model->getIsDelete(0, 'single') . "',
							`isApproved`		=	'" . $this->model->getIsApproved(0, 'single') . "',
							`isReview`			=	'" . $this->model->getIsReview(0, 'single') . "',
							`isPost`			=	'" . $this->model->getIsPost(0, 'single') . "',
							`executeBy`			=	'" . $this->model->getExecuteBy() . "',
							`executeTime`		=	" . $this->model->getExecuteTime() . "
					WHERE 	`folderId`			=	'" . $this->model->getFolderId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
					UPDATE 	[folder]
					SET 	[moduleId]			=	'" . $this->model->getModuleId() . "',
							[folderEnglish]		=	'" . $this->model->getfolderEnglish() . "',
							[folderSequence]	=	'" . $this->model->getfolderSequence() . "',
							[folderPath]		=	'" . $this->model->getfolderPath() . "',
							[iconId]			=	'" . $this->strict($_POST ['iconId'], 'string') . "',
							[isActive]			=	'" . $this->model->getIsActive(0, 'single') . "',
							[isNew]				=	'" . $this->model->getIsNew(0, 'single') . "',
							[isDraft]			=	'" . $this->model->getIsDraft(0, 'single') . "',
							[isUpdate]			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							[isDelete]			=	'" . $this->model->getIsDelete(0, 'single') . "',
							[isApproved]		=	'" . $this->model->getIsApproved(0, 'single') . "',
							[isReview]			=	'" . $this->model->getIsReview(0, 'single') . "',
							[isPost]			=	'" . $this->model->getIsPost(0, 'single') . "',
							[executeBy]			=	'" . $this->model->getExecuteBy() . "',
							[executeTime]		=	" . $this->model->getExecuteTime() . "
					WHERE 	[folderId]			=	'" . $this->model->getFolderId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
					UPDATE 	FOLDER
					SET 	MODULEID			=	'" . $this->model->getModuleId() . "',
							FOLDERENGLISH		=	'" . $this->model->getfolderEnglish() . "',
							FOLDERSEQUENCE		=	'" . $this->model->getfolderSequence() . "',
							FOLDERPATH			=	'" . $this->model->getfolderPath() . "',
							ISDEFAULT			=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISACTIVE			=	'" . $this->model->getIsActive(0, 'single') . "',
							ISNEW				=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT				=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE			=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISAPPROVED			=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW			=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST				=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY			=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME			=	" . $this->model->getExecuteTime() . "
					WHERE 	FOLDERID			=	'" . $this->model->getFolderId(0, 'single') . "'";
			} else if ($this->getVendor() == self::DB2) {
				$sql = "
					UPDATE 	FOLDER
					SET 	MODULEID			=	'" . $this->model->getModuleId() . "',
							FOLDERENGLISH		=	'" . $this->model->getfolderEnglish() . "',
							FOLDERSEQUENCE		=	'" . $this->model->getfolderSequence() . "',
							FOLDERPATH			=	'" . $this->model->getfolderPath() . "',
							ISDEFAULT			=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISACTIVE			=	'" . $this->model->getIsActive(0, 'single') . "',
							ISNEW				=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT				=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE			=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISAPPROVED			=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW			=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST				=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY			=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME			=	" . $this->model->getExecuteTime() . "
					WHERE 	FOLDERID			=	'" . $this->model->getFolderId(0, 'single') . "'";
			} else if ($this->getVendor() == self::POSTGRESS) {
				$sql = "
					UPDATE 	FOLDER
					SET 	MODULEID			=	'" . $this->model->getModuleId() . "',
							FOLDERENGLISH		=	'" . $this->model->getfolderEnglish() . "',
							FOLDERSEQUENCE		=	'" . $this->model->getfolderSequence() . "',
							FOLDERPATH			=	'" . $this->model->getfolderPath() . "',
							ISDEFAULT			=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISACTIVE			=	'" . $this->model->getIsActive(0, 'single') . "',
							ISNEW				=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT				=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE			=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISAPPROVED			=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW			=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST				=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY			=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME			=	" . $this->model->getExecuteTime() . "
					WHERE 	FOLDERID			=	'" . $this->model->getFolderId(0, 'single') . "'";
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
		WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getFolderId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
		SELECT	[" . $this->model->getPrimaryKeyName() . "]
		FROM 	[" . $this->model->getTableName() . "]
		WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getFolderId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
		SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
		FROM 	" . strtoupper($this->model->getTableName()) . "
		WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getFolderId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
		SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
		FROM 	" . strtoupper($this->model->getTableName()) . "
				WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getFolderId(0, 'single') . "' ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getFolderId(0, 'single') . "' ";
		}
		$result = $this->q->fast($sql);
		$total = $this->q->numberRows($result, $sql);
		if ($total == 0) {
			echo json_encode(array("success" => false, "message" => $this->systemString->getRecordNotFoundMessage()));
			exit();
		} else {
			if ($this->getVendor() == self::MYSQL) {
				$sql = "
					UPDATE	`folder`
					SET		`isDefault`			=	'" . $this->model->getIsDefault(0, 'single') . "',
							`isActive`			=	'" . $this->model->getIsActive(0, 'single') . "',
							`isNew`				=	'" . $this->model->getIsNew(0, 'single') . "',
							`isDraft`			=	'" . $this->model->getIsDraft(0, 'single') . "',
							`isUpdate`			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							`isDelete`			=	'" . $this->model->getIsDelete(0, 'single') . "',
							`isApproved`		=	'" . $this->model->getIsApproved(0, 'single') . "',
							`isReview`			=	'" . $this->model->getIsReview(0, 'single') . "',
							`isPost`			=	'" . $this->model->getIsPost(0, 'single') . "',
							`executeBy`			=	'" . $this->model->getExecuteBy() . "',
							`executeTime`		=	" . $this->model->getExecuteTime() . "
					WHERE 	`folderId`			=	'" . $this->model->getFolderId(0, 'single') . "'";
			} else if ($this->getVendor() == self::MSSQL) {
				$sql = "
					UPDATE	[folder]
					SET		[isDefault]			=	'" . $this->model->getIsDefault(0, 'single') . "',
							[isActive]			=	'" . $this->model->getIsActive(0, 'single') . "',
							[isNew]				=	'" . $this->model->getIsNew(0, 'single') . "',
							[isDraft]			=	'" . $this->model->getIsDraft(0, 'single') . "',
							[isUpdate]			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							[isDelete]			=	'" . $this->model->getIsDelete(0, 'single') . "',
							[isApproved]		=	'" . $this->model->getIsApproved(0, 'single') . "',
							[isReview]			=	'" . $this->model->getIsReview(0, 'single') . "',
							[isPost]			=	'" . $this->model->getIsPost(0, 'single') . "',
							[executeBy]			=	'" . $this->model->getExecuteBy() . "',
							[executeTime]		=	" . $this->model->getExecuteTime() . "
					WHERE 	[folderId]			=	'" . $this->model->getFolderId(0, 'single') . "'";
			} else if ($this->getVendor() == self::ORACLE) {
				$sql = "
					UPDATE	FOLDER
					SET		ISDEFAULT			=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISACTIVE			=	'" . $this->model->getIsActive(0, 'single') . "',
							ISNEW				=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT				=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE			=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISAPPROVED			=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW			=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST				=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY			=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME			=	" . $this->model->getExecuteTime() . "
					WHERE 	FOLDERID			=	'" . $this->model->getFolderId(0, 'single') . "'";
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
							WHEN '" . $this->model->getFolderId($i, 'array') . "'
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
							WHEN '" . $this->model->getFolderId($i, 'array') . "'
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
							WHEN '" . $this->model->getFolderId($i, 'array') . "'
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
							WHEN '" . $this->model->getFolderId($i, 'array') . "'
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
							WHEN '" . $this->model->getFolderId($i, 'array') . "'
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
							WHEN '" . $this->model->getFolderId($i, 'array') . "'
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
							WHEN '" . $this->model->getFolderId($i, 'array') . "'
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
                            WHEN '" . $this->model->getFolderId($i, 'array') . "'
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
                                WHEN '" . $this->model->getFolderId($i, 'array') . "'
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
		echo json_encode(array("success" => true, "message" => $message,'time'=>$time)
		);
		exit();
	}

	function module() {
		$this->security->module($this->model->getType(), $this->model->getTeamId());
	}

	public function nextSequence() {
		$this->recordSet->nextSequence($this->model->getModuleId());
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
		$this->excel->getActiveSheet()->setCellValue('C3', 'Folder');
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
			$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, $row ['folderEnglish']);
			$loopRow++;
			$lastRow = 'D' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename = "folder" . rand(0, 10000000) . ".xlsx";
		$path = $_SERVER ['DOCUMENT_ROOT'] . "/" . $this->application . "/security/document/excel/" . $filename;
		$objWriter->save($path);
		$this->audit->create_trail($this->getLeafId(), $path, $filename);
		$file = fopen($path, 'r');
		if ($file) {
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode(
			array(	"success" => true,
						"message" => $this->systemString->getFileGenerateMessage(),
						"time"=>$time));
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getFileNotGenerateMessage()));
		}
	}

}

$folderObject = new FolderClass ();
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
		$folderObject->setLeafId($_POST ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$folderObject->setIsAdmin($_POST ['isAdmin']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$folderObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$folderObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Filtering
	 */
	if (isset($_POST ['query'])) {
		$folderObject->setFieldQuery($_POST ['query']);
	}
	if (isset($_POST ['filter'])) {
		$folderObject->setGridQuery($_POST ['filter']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST ['order'])) {
		$folderObject->setOrder($_POST ['order']);
	}
	if (isset($_POST ['sortField'])) {
		$folderObject->setSortField($_POST ['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$folderObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$folderObject->create();
	}
	if ($_POST ['method'] == 'read') {
		$folderObject->read();
	}
	if ($_POST ['method'] == 'save') {
		$folderObject->update();
	}
	if ($_POST ['method'] == 'delete') {
		$folderObject->delete();
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
		$folderObject->setLeafId($_GET ['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET ['isAdmin'])) {
		$folderObject->setIsAdmin($_GET ['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$folderObject->execute();
	if (isset($_GET ['field'])) {
		if ($_GET ['field'] == 'staffId') {
			$folderObject->staff();
		}
		if ($_GET ['field'] == 'moduleId') {
			$folderObject->module();
		}
		if ($_GET ['field'] == 'sequence') {
			$folderObject->nextSequence();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$folderObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET ['folderCode'])) {
		if (strlen($_GET ['folderCode']) > 0) {
			$folderObject->duplicate();
		}
	}
	/**
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {

		if ($_GET ['dataNavigation'] == 'firstRecord') {

			$folderObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$folderObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$folderObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$folderObject->lastRecord('json');
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$folderObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$folderObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$folderObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$folderObject->lastRecord('json');
		}
	}
	/*
	 *  Excel Reporting
	 */
	if (isset($_GET ['mode'])) {
		if ($_GET ['mode'] == 'excel') {
			$folderObject->excel();
		}
	}
}
?>

