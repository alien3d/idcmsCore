<?php
session_start ();
require_once ("../../class/classAbstract.php");
require_once("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSecurity.php");
require_once ("../model/moduleModel.php");
/**
 * this is module  files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @subpackage module
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ModuleClass extends ConfigClass {
	/**
	 * Connection to the damodulease
	 * @var string
	 */
	public $q;
	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string
	 */
	private $excel;
	/**
	 * Document Trail Audit.
	 * @var string 
	 */
	private $documentTrail;
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
	function execute() {
		parent::__construct ();
		// audit property
		$this->audit = 0;
		$this->log = 0;
		
		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor ();
		$this->q->leafId = $this->getLeafId ();
		$this->q->staffId = $this->getStaffId ();
		$this->q->fieldQuery = $this->getFieldQuery ();
		$this->q->gridQuery = $this->getGridQuery ();
		$this->q->log = $this->log;
		$this->q->audit = $this->audit;
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );
		
		
		$this->security = new Security ();
		$this->security->setVendor ( $this->getVendor () );
		$this->security->setLeafId ( $this->getLeafId () );
		$this->security->execute ();
		
		$this->model = new ModuleModel ();
		$this->model->setVendor ( $this->getVendor () );
		$this->model->execute ();
		
		$this->recordSet =  new RecordSet();
		$this->recordSet->setTableName($this->model->getTableName());
		$this->recordSet->setPrimaryKeyName($this->model->getPrimaryKeyName());
		$this->recordSet->execute();
		
		$this->documentTrail = new DocumentTrailClass ();
		$this->documentTrail->setVendor ( $this->getVendor () );
		$this->documentTrail->execute ();
		
		$this->excel = new PHPExcel ();
	}
	function create() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES utf8";
			$this->q->fast ( $sql );
		}
		$this->q->start ();
		$this->model->create ();
		/**
		 * Example  using Constant .This much cleaner approch  to Sql Statement
		 */
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			INSERT INTO `module`
					(
						`iconId`,							`moduleSequence`,
						`moduleCode`,							`moduleEnglish`,
						`isDefault`,							`isNew`,
						`isDraft`,							`isUpdate`,
						`isDelete`,							`isActive`,
						`isApproved`,						`executeBy`,
						`executeTime`
					)
			VALUES
					(
						'" . $this->model->getIconId () . "',					'" . $this->model->getmoduleSequence () . "',
						'" . $this->model->getmoduleCode () . "',					'" . $this->model->getmoduleEnglish () . "',
						'" . $this->model->getIsDefault ( 0, 'single' ) . "',		'" . $this->model->getIsNew ( 0, 'single' ) . "',
						'" . $this->model->getIsDraft ( 0, 'single' ) . "',		'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						'" . $this->model->getIsDelete ( 0, 'single' ) . "',		'" . $this->model->getIsActive ( 0, 'single' ) . "',
						'" . $this->model->getIsApproved ( 0, 'single' ) . "',	'" . $this->model->getExecuteBy () . "',
						" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			INSERT INTO [module]
					(
						[iconId],							[moduleSequence],
						[moduleCode],							[moduleEnglish],
						[isDefault],						[isNew],
						[isDraft],							[isUpdate],
						[isDelete],							[isActive],
						[isApproved],						[executeBy],
						[executeTime]
					)
			VALUES
					(
						'" . $this->model->getIconId () . "',					'" . $this->model->getmoduleSequence () . "',
						'" . $this->model->getmoduleCode () . "',				'" . $this->model->getmoduleEnglish () . "',
						'" . $this->model->getIsDefault ( 0, 'single' ) . "',			'" . $this->model->getIsNew ( 0, 'single' ) . "',
						'" . $this->model->getIsDraft ( 0, 'single' ) . "',			'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						'" . $this->model->getIsDelete ( 0, 'single' ) . "',		'" . $this->model->getIsActive ( 0, 'single' ) . "',
						'" . $this->model->getIsApproved ( 0, 'single' ) . "',		'" . $this->model->getExecuteBy () . "',
						" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			INSERT INTO MODULE
					(
						ICONID,							MODULESEQUENCE,
						MODULECODE,						MODULENOTE,
						ISDEFAULT,						ISNEW,
						ISDRAFT,						ISUPDATE,
						ISDELETE,						ISACTIVE,
						ISAPPROVED,						EXECUTEBY,
						EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getIconId () . "',					'" . $this->model->getmoduleSequence () . "',
						'" . $this->model->getmoduleCode () . "',				'" . $this->model->getmoduleEnglish () . "',
						'" . $this->model->getIsDefault ( 0, 'single' ) . "',			'" . $this->model->getIsNew ( 0, 'single' ) . "',
						'" . $this->model->getIsDraft ( 0, 'single' ) . "',			'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						'" . $this->model->getIsDelete ( 0, 'single' ) . "',		'" . $this->model->getIsActive ( 0, 'single' ) . "',
						'" . $this->model->getIsApproved ( 0, 'single' ) . "',		'" . $this->model->getExecuteBy () . "',
						" . $this->model->getExecuteTime () . "
					);";
		}
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$lastId = $this->q->lastInsertId ();
		//  create a record  in moduleAccess.update no effect
		// loop the group
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT 	*
			FROM 	`theme`
			WHERE 	`isActive`	=	1 ";
		} else if ($this->q->vendor == self::MSSQL) {
			$sql = "
			SELECT 	*
			FROM 	[team]
			WHERE 	[isActive]	=	1 ";
		} else if ($this->q->vendor == self::ORACLE) {
			$sql = "
			SELECT 	*
			FROM 	TEAM
			WHERE 	`ISACTIVE	=	1 ";
		}
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$data = $this->q->activeRecord ();
		foreach ( $data as $row ) {
			/**
			 * By Default  No Access
			 **/
			echo $sqlLooping .= "(
							'" . $lastId . "',
							 '" . $row ['TEAMID'] . "',
							 \"0\"
						),";
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
				INSERT INTO	`moduleAccess`
						(
							`moduleId`,
							`TEAMID`,
							`moduleAccessValue`
						) VALUES";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
				INSERT INTO	[moduleAccess]
						(
							[moduleId],
							\"teamId\",
							[moduleAccessValue]
					) VALUES";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
				INSERT INTO	MODULEACCESS
						(
							MODULEID,
							TEAMID,
							MODULEACCESSVALUE
					) VALUES";
		}
		// optimize to 1 Query
		// remove last comma
		$sqlLooping = substr ( $sqlLooping, 0, - 1 );
		// combine SQL Statement
		$sql .= $sqlLooping;
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		/**
		 * insert default value to detail modulele .English only
		 **/
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
		 	INSERT INTO `moduleTranslate`
		 		(
				 	`moduleId`,
				 	`languageId`,
					`moduleTranslate`
				) VALUES (
					'" . $lastId . "',
					21,
					'" . $this->model->getmoduleEnglish () . "'
				);";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		 	INSERT INTO  [moduleTranslate]
					(
					 	[moduleId],
						[languageId],
						[moduleTranslate]
					) VALUES (
						'" . $lastId . "',
						21,
						'" . $this->model->getmoduleEnglish () . "'
					);";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		 	INSERT INTO	MODULETRANSLATE
					(
					 	MODULEID,
						LANGUAGEID,
						MODULETRANSLATE
					) VALUES (
						'" . $lastId . "',
						21,
						'" . $this->model->getmoduleEnglish () . "'
					);";
		}
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => true, "message" => "Insert Sucess", "moduleId" => $lastId ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see class/config::read()
	 */
	function read() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->isAdmin == 0) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	`module`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[module].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	MODULE.ISACTIVE	=	1	";
			}
		} else if ($this->isAdmin == 1) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	 1=1 ";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	1 = 1 ";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "  1 = 1 ";
			}
		}
		//UTF8
		$items = array ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES utf8";
			$this->q->fast ( $sql );
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
					SELECT	`module`.`moduleId`,
							`module`.`iconId`,
							`module`.`moduleSequence`,
							`module`.`moduleCode`,
							`module`.`moduleEnglish`,
							`module`.`isDefault`,
							`module`.`isNew`,
							`module`.`isDraft`,
							`module`.`isUpdate`,
							`module`.`isDelete`,
							`module`.`isActive`,
							`module`.`isApproved`,
							`module`.`executeBy`,
							`module`.`executeTime`,
							`staff`.`staffName`,
							`icon`.`iconName`
 					FROM 	`module`
					JOIN	`staff`
					ON		`module`.`executeBy` = `staff`.`staffId`
					LEFT 	JOIN	`icon`
					USING			(`iconId`)
					WHERE 	" . $this->auditFilter;
			if ($this->model->getModuleId ( 0, 'single' )) {
				$sql .= " AND `" . $this->model->getmoduleleName () . "`.`" . $this->model->getPrimaryKeyName () . "`='" . $this->model->getModuleId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
					SELECT	[module].[moduleId],
							[module].[iconId],
							[module].[moduleSequence],
							[module].[moduleCode],
							[module].[moduleEnglish],
							[module].[isDefault],
							[module].[isNew],
							[module].[isDraft],
							[module].[isUpdate],
							[module].[isDelete],
							[module].[isActive],
							[module].[isApproved],
							[module].[executeBy],
							[module].[executeTime],
							[staff].[staffName],
							[icon].[iconName]
					FROM 	[module]
					JOIN	[staff]
					ON		[module].[executeBy] = [staff].[staffId]
					LEFT 	JOIN	`icon`
					ON		[iconId].[iconId] = [module].[iconId]
					WHERE 	[module].[isActive] ='1'	";
			if ($this->model->getModuleId ( 0, 'single' )) {
				$sql .= " AND [" . $this->model->getmoduleleName () . "].[" . $this->model->getPrimaryKeyName () . "]='" . $this->model->getModuleId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					SELECT	MODULE.MODULEID,
							MODULE.ICONID,
							MODULE.MODULECODE,
							MODULE.MODULESEQUENCE,
							MODULE.MODULENOTE,
							MODULE.ISDEFAULT,
							MODULE.ISNEW,
							MODULE.ISDRAFT,
							MODULE.ISUPDATE,
							MODULE.ISDELETE,
							MODULE.ISACTIVE,
							MODULE.ISAPPROVED,
							MODULE.EXECUTEBY,
							MODULE.EXECUTETIME,
							STAFF.STAFFNAME,
							ICON.ICONNAME
					FROM 	MODULE
					JOIN	STAFF
					ON		MODULE.EXECUTEBY = STAFF.STAFFID
					LEFT 	JOIN	ICON
					USING	(ICONID)
					WHERE 	ISACTIVE='1'	";
			if ($this->model->getModuleId ( 0, 'single' )) {
				$sql .= " AND '" . strtoupper ( $this->model->getmoduleleName () ) . "'.'" . strtoupper ( $this->model->getPrimaryKeyName () ) . "'='" . $this->model->getModuleId ( 0, 'single' ) . "'";
			}
		} else {
			echo json_encode ( array ("success" => false, "message" => "Undefine Damodulease Vendor" ) );
			exit ();
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array ('moduleId' );
		/**
		 * filter modulele
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array ('module' );
		if ($this->getFieldQuery ()) {
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
		if (! ($this->getGridQuery ())) {
			if ($this->getLimit ()) {
				// only mysql have limit
				if ($this->getVendor () == self::MYSQL) {
					$sql .= " LIMIT  " . $this->getStart () . "," . $this->getLimit () . " ";
				} else if ($this->getVendor () == self::MSSQL) {
					/**
					 * Sql Server and Oracle used row_number
					 * Parameterize Query We don't support
					 */
					$sql = "
							WITH [moduleDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [moduleId]) AS 'RowNumber'
								FROM [module]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[module].[moduleId],
										[module].[iconId],
										[module].[moduleSequence],
										[module].[moduleCode],
										[module].[moduleEnglish],
										[module].[isDefault],
										[module].[isNew],
										[module].[isDraft],
										[module].[isUpdate],
										[module].[isDelete],
										[module].[isApproved],
										[module].[executeBy],
										[module].[executeTime],
										[staff].[staffName]
							FROM 		[moduleDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $this->getStart () . "
							AND 			" . ($this->getStart () + $this->getLimit () - 1) . ";";
				} else if ($this->getVendor () == self::ORACLE) {
					/**
					 * Oracle using derived modulele also
					 */
					$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT  MODULE.MODULEID,
											MODULE.ICONID,
											MODULE.MODULESEQUENCE,
											MODULE.MODULECODE,
											MODULE.MODULENOTE,
											MODULE.ISDEFAULT,
											MODULE.ISNEW,
											MODULE.ISDRAFT,
											MODULE.ISUPDATE,
											MODULE.ISDELETE,
											MODULE.ISAPPROVED,
											MODULE.EXECUTEBY,
											MODULE.EXECUTETIME,
											STAFF.STAFFNAME
									FROM 	MODULE
									WHERE 	MODULE.ISACTIVE=1  " . $tempSql . $tempSql2 . "
								 ) a
						where rownum <= '" . ($this->getStart () + $this->getLimit () - 1) . "' )
						where r >=  '" . $this->getStart () . "'";
				} else {
					echo "undefine vendor";
					exit ();
				}
			}
		}
		/*
             *  Only Execute One Query
             */
		if (! ($this->model->getModuleId ( 0, 'single' ))) {
			$this->q->read ( $sql );
			if ($this->q->execute == 'fail') {
				echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
				exit ();
			}
		}
		$items = array ();
		while ( ($row = $this->q->fetchAssoc ()) == TRUE ) {
			$items [] = $row;
		}
		if ($this->model->getModuleId ( 0, 'single' )) {
			$json_encode = json_encode ( array ('success' => true, 'total' => $total, 'message' => 'Data Loaded', 'data' => $items ) );
			$json_encode = str_replace ( "[", "", $json_encode );
			$json_encode = str_replace ( "]", "", $json_encode );
			echo $json_encode;
		} else {
			if (count ( $items ) == 0) {
				$items = '';
			}
			echo json_encode ( array ('success' => true, 'total' => $total, 'message' => 'data loaded', 'data' => $items ) );
			exit ();
		}
	}
	/* (non-PHPdoc)
	 * @see ConfigClass::update()
	 */
	function update() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES utf8";
			$this->q->fast ( $sql );
		}
		$this->q->start ();
		$this->model->update ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			UPDATE 	`module`
			SET 	`moduleSequence`	= 	'" . $this->model->getmoduleSequence () . "',
					`moduleEnglish`		=	'" . $this->model->getmoduleEnglish () . "',
					`iconId`			=	'" . $this->model->getIconId () . "',
					`isActive`			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					`isNew`				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					`isDraft`			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					`isUpdate`			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					`isDelete`			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					`isApproved`		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					`executeBy`				=	'" . $this->model->getExecuteBy () . "',
					`executeTime`				=	" . $this->model->getExecuteTime () . "
			WHERE 	`moduleId`			=	'" . $this->model->getModuleId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			UPDATE 	[module]
			SET 	[moduleSequence]	= 	'" . $this->model->moduleSequence . "',
					[moduleEnglish]		=	'" . $this->model->moduleEnglish . "',
					[iconId]			=	'" . $this->model->iconId . "',
					[isDefault]			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					[isActive]			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					[isNew]				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					[isDraft]			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					[isUpdate]			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					[isDelete]			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					[isApproved]		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					[executeBy]				=	'" . $this->model->getExecuteBy () . ",
					[executeTime]				=	" . $this->model->getExecuteTime () . "
			WHERE 	[moduleId]			=	'" . $this->model->getModuleId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			UPDATE 	MODULE
			SET 	MODULESEQUENCE	= 	'" . $this->model->moduleSequence . "',
					MODULENOTE		=	'" . $this->model->moduleEnglish . "',
					ICONID			=	'" . $this->model->iconId . "',
					ISACTIVE		=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					ISNEW			=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					ISDRAFT			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					ISUPDATE		=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					ISDELETE		=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					ISAPPROVED		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					EXECUTEBY				=	'" . $this->model->getExecuteBy () . "',
					EXECUTETIME			=	" . $this->model->getExecuteTime () . "
			WHERE 	MODULEID		=	'" . $this->model->getModuleId ( 0, 'single' ) . "'";
		}
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => true, "message" => "update success", "moduleId" => $this->model->getModuleId ( 0, 'single' ) ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see ConfigClass::delete()
	 */
	function delete() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES utf8";
			$this->q->fast ( $sql );
		}
		$this->q->start ();
		$this->model->delete ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			UPDATE 	`module`
			SET 	`isDefault`		=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					`isActive`		=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					`isNew`			=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					`isDraft`		=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					`isUpdate`		=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					`isDelete`		=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					`isApproved`	=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					`executeBy`			=	'" . $this->model->getBy ( 0, 'single' ) . "',
					`Time			=	" . $this->model->getExecuteTime () . "
			WHERE 	`moduleId`		=	'" . $this->model->moduleId . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			UPDATE 	[module]
			SET 	[isDefault]		=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					[isActive]		=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					[isNew]			=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					[isDraft]		=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					[isUpdate]		=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					[isDelete]		=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					[isApproved]	=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					[executeBy]			=	'" . $this->model->getBy ( 0, 'single' ) . "',
					[executeTime]			=	" . $this->model->getExecuteTime () . "
			WHERE 	[moduleId]			=	'" . $this->model->getModuleId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			UPDATE 	MODULE
			SET 	ISDEFAULT		=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					ISACTIVE		=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					ISNEW			=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					ISDRAFT			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					ISUPDATE		=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					ISDELETE		=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					ISAPPROVED		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					EXECUTEBY				=	'" . $this->model->getBy ( 0, 'single' ) . "',
					EXECUTETIME			=	" . $this->model->getExecuteTime () . "
			WHERE 	MODULEID			=	'" . $this->model->getModuleId ( 0, 'single' ) . "'";
		}
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => "false", "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => "true", "message" => "Delete Succes" ) );
		exit ();
	}
	public function nextSequence() {
		$this->security->nextSequence ();
	}
	/* (non-PHPdoc)
	 * @see ConfigClass::excel()
	 */
	function excel() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES utf8";
			$this->q->fast ( $sql );
		}
		if ($_SESSION ['start'] == 0) {
			$sql = str_replace ( "LIMIT", "", $_SESSION ['sql'] );
			$sql = str_replace ( $_SESSION ['start'] . "," . $_SESSION ['limit'], "", $sql );
		} else {
			$sql = $_SESSION ['sql'];
		}
		$this->q->read ( $sql );
		$this->excel->setActiveSheetIndex ( 0 );
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array ('borders' => array ('inside' => array ('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array ('argb' => '000000' ) ), 'outline' => array ('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array ('argb' => '000000' ) ) ) );
		// header all using  3 line  starting b
		$this->excel->getActiveSheet ()->setCellValue ( 'B2', $this->title );
		$this->excel->getActiveSheet ()->setCellValue ( 'D2', '' );
		$this->excel->getActiveSheet ()->mergeCells ( 'B2:D2' );
		$this->excel->getActiveSheet ()->setCellValue ( 'B3', 'No' );
		$this->excel->getActiveSheet ()->setCellValue ( 'C3', 'Name' );
		$this->excel->getActiveSheet ()->setCellValue ( 'D3', 'Description' );
		$this->excel->getActiveSheet ()->getStyle ( 'B2:D2' )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$this->excel->getActiveSheet ()->getStyle ( 'B2:D2' )->getFill ()->getStartColor ()->setARGB ( '66BBFF' );
		$this->excel->getActiveSheet ()->getStyle ( 'B3:D3' )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$this->excel->getActiveSheet ()->getStyle ( 'B3:D3' )->getFill ()->getStartColor ()->setARGB ( '66BBFF' );
		//
		$loopRow = 4;
		$i = 0;
		while ( ($row = $this->q->fetchAssoc ()) == TRUE ) {
			//	echo print_r($row);
			$this->excel->getActiveSheet ()->setCellValue ( 'B' . $loopRow, ++ $i );
			$this->excel->getActiveSheet ()->setCellValue ( 'C' . $loopRow, $row ['moduleEnglish'] );
			$this->excel->getActiveSheet ()->setCellValue ( 'D' . $loopRow, $row ['moduleDesc'] );
			$loopRow ++;
			$lastRow = 'D' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet ()->getStyle ( $formula )->applyFromArray ( $styleThinBlackBorderOutline );
		$objWriter = PHPExcel_IOFactory::createWriter ( $this->excel, 'Excel2007' );
		$filename = "module" . rand ( 0, 10000000 ) . ".xlsx";
		$path = $_SERVER ['DOCUMENT_ROOT'] . "/" . $this->application . "/basic/document/excel/" . $filename;
		$objWriter->save ( $path );
		$this->audit->createTrail ( $this->leafId, $path, $filename );
		$file = fopen ( $path, 'r' );
		if ($file) {
			echo json_encode ( array ("success" => "true", "message" => "File generated" ) );
		} else {
			echo json_encode ( array ("success" => "false", "message" => "File not generated" ) );
		}
	}
}
/**
 * Declare object
 **/
$moduleObject = new ModuleClass ();
/**
 * Form Property .CRUD -create,read,update,delete
 **/
if (isset ( $_POST ['method'] )) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset ( $_POST ['leafId'] )) {
		$moduleObject->setLeafId ( $_POST ['leafId'] );
	}
	if (isset ( $_POST ['isAdmin'] )) {
		$moduleObject->setIsAdmin ( $_POST ['isAdmin'] );
	}
	/*
	 * Filtering
	 */
	if (isset ( $_POST ['query'] )) {
		$moduleObject->setFieldQuery ( $_POST ['query'] );
	}
	if (isset ( $_POST ['filter'] )) {
		$moduleObject->setGridQuery ( $_POST ['filter'] );
	}
	/*
	 * Ordering
	 */
	if (isset ( $_POST ['order'] )) {
		$moduleObject->setOrder ( $_POST ['order'] );
	}
	if (isset ( $_POST ['sortField'] )) {
		$moduleObject->setSortField ( $_POST ['sortField'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$moduleObject->execute ();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$moduleObject->create ();
	}
	if ($_POST ['method'] == 'read') {
		$moduleObject->read ();
	}
	if ($_POST ['method'] == 'save') {
		$moduleObject->update ();
	}
	if ($_POST ['method'] == 'delete') {
		$moduleObject->delete ();
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
		$moduleObject->setLeafId ( $_GET ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_GET ['isAdmin'] )) {
		$moduleObject->setIsAdmin ( $_GET ['isAdmin'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$moduleObject->execute ();
	if (isset ( $_GET ['field'] )) {
		if ($_GET ['field'] == 'staffId') {
			$moduleObject->staff ();
		}
		if ($_GET ['field'] == 'sequence') {
			$moduleObject->nextSequence ();
		}
	}
	/*
	 * Update Status of The modulele. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$moduleObject->updateStatus ();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset ( $_GET ['moduleCode'] )) {
		if (strlen ( $_GET ['moduleCode'] ) > 0) {
			$moduleObject->duplicate ();
		}
	}
	/*
	 *  Excel Reporting
	 */
	if (isset ( $_GET ['mode'] )) {
		if ($_GET ['mode'] == 'report') {
			$moduleObject->excel ();
		}
	}
}
?>

