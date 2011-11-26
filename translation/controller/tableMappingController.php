<?php

session_start ();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSecurity.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/tableMappingModel.php");

/**
 * this tableMapping menu creation
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Translation
 * @subpackage tableMapping
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class TableMappingClass extends ConfigClass {
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
		parent::__construct ();
		//audit property
		$this->audit = 0;
		$this->log = 0;

		// default translation property
		$this->defaultLanguageId = 21;

		$this->model = new TableMappingModel ();
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
		$this->q->setRequestDatabase($this->getRequestDatabase());
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );

		$this->security = new Security ();
		$this->security->setVendor ( $this->getVendor () );
		$this->security->setLeafId ( $this->getLeafId () );
		$this->security->execute ();

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
			INSERT INTO `tableMapping`
					(
						
						INSERT INTO `tablemapping`(
						`tableMappingId`, 											`tableMappingName`, 
						`tableMappingColumnName`, 									`tableMappingEnglish`, 
						`isDefault`, 												`isNew`, 
						`isDraft`, 													`isUpdate`, 
						`isDelete`, 												`isActive`, 
						`isApproved`, 												`isReview`, 
						`isPost`, 													`executeBy`, 
						`executeTime`
					)
			VALUES
					(
						null,														'" . $this->model->getTableMappingName() . "',
						'" . $this->model->getTableMappingColumnName() . "', 		'" . $this->model->getTableMappingEnglish() . "',
						'" . $this->model->getIsDefault ( 0, 'single' ) . "',		'" . $this->model->getIsNew ( 0, 'single' ) . "',
						'" . $this->model->getIsDraft ( 0, 'single' ) . "',			'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						'" . $this->model->getIsDelete ( 0, 'single' ) . "',		'" . $this->model->getIsActive ( 0, 'single' ) . "',
						'" . $this->model->getIsApproved ( 0, 'single' ) . "',		'" . $this->model->getIsReview ( 0, 'single' ) . "',
						'" . $this->model->getIsPost ( 0, 'single' ) . "',			'" . $this->model->getExecuteBy () . "',
						" . $this->model->getExecuteTime () . "


					);";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			INSERT INTO [tableMapping]
					(
						[tableMappingId], 											[tableMappingName], 
						[tableMappingColumnName], 									[tableMappingEnglish], 
						[isDefault], 												[isNew], 
						[isDraft], 													[isUpdate], 
						[isDelete], 												[isActive], 
						[isApproved], 												[isReview], 
						[isPost], 													[executeBy], 
						[executeTime]
				)
			VALUES
				(
						null,														'" . $this->model->getTableMappingName() . "',
						'" . $this->model->getTableMappingColumnName() . "', 		'" . $this->model->getTableMappingEnglish() . "',
						'" . $this->model->getIsDefault ( 0, 'single' ) . "',		'" . $this->model->getIsNew ( 0, 'single' ) . "',
						'" . $this->model->getIsDraft ( 0, 'single' ) . "',			'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						'" . $this->model->getIsDelete ( 0, 'single' ) . "',		'" . $this->model->getIsActive ( 0, 'single' ) . "',
						'" . $this->model->getIsApproved ( 0, 'single' ) . "',		'" . $this->model->getIsReview ( 0, 'single' ) . "',
						'" . $this->model->getIsPost ( 0, 'single' ) . "',			'" . $this->model->getExecuteBy () . "',
						" . $this->model->getExecuteTime () . "
				
				);";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			INSERT INTO 	TABLEMAPPING
						(
							TABLEMAPPINGID, 											TABLEMAPPINGNAME, 
							TABLEMAPPINGCOLUMNNAME, 									TABLEMAPPINGENGLISH, 
							ISDEFAULT, 													ISNEW, 
							ISDRAFT, 													ISUPDATE, 
							ISDELETE, 													ISACTIVE, 
							ISAPPROVED, 												ISREVIEW, 
							ISPOST, 													EXECUTEBY, 
							EXECUTETIME
				VALUES	(
							null,														'" . $this->model->getTableMappingName() . "',
							'" . $this->model->getTableMappingColumnName() . "', 		'" . $this->model->getTableMappingEnglish() . "',
							'" . $this->model->getIsDefault ( 0, 'single' ) . "',		'" . $this->model->getIsNew ( 0, 'single' ) . "',
							'" . $this->model->getIsDraft ( 0, 'single' ) . "',			'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							'" . $this->model->getIsDelete ( 0, 'single' ) . "',		'" . $this->model->getIsActive ( 0, 'single' ) . "',
							'" . $this->model->getIsApproved ( 0, 'single' ) . "',		'" . $this->model->getIsReview ( 0, 'single' ) . "',
							'" . $this->model->getIsPost ( 0, 'single' ) . "',			'" . $this->model->getExecuteBy () . "',
							" . $this->model->getExecuteTime () . "

					)";
		}
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false,

			"message" => $this->q->responce ) );
			exit ();
		}

		$lastId = $this->q->lastInsertId ();

		/**
		 * insert default value to detail tableMappingle .English only
		 **/
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
				 	INSERT INTO `tableMapping`
				 		(
						 	`tableMappingId`,
						 	`languageId`,
							`tableMappingTranslate`
						) VALUES (
							'" . $lastId . "',
							21,
							'" . $this->model->gettableMappingNote () . "'
						);";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
				 	INSERT INTO  [tableMapping]
							(
							 	[tableMappingId],
								[languageId],
								[tableMappingTranslate]
							) VALUES (
								'" . $lastId . "',
								21,
								'" . $this->model->gettableMappingNote () . "'
							);";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
				 	INSERT INTO	TABLEMAPPING
							(
							 	TABLEMAPPINGID,
								LANGUAGEID,
								TABLEMAPPINGTRANSLATE
							) VALUES (
								'" . $lastId . "',
								21,
								'" . $this->model->gettableMappingNote () . "'
							);";
		} else if ($this->getVendor () == self::DB2) {

		} else if ($this->getVendor () == self::POSTGRESS) {

		}
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode (
		array (	"success" => true,
					"tableMappingId" => $lastId, 
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
				$this->auditFilter = "	`tableMapping`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::mssql) {
				$this->auditFilter = "	[tableMapping].[isActive]		=	1	";
			} else if ($this->q->vendor == self::oracle) {
				$this->auditFilter = "	TABLEMAPPING.ISACTIVE	=	1	";
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
		// everything given flexibility  on todo
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT 		*
			FROM 		`tableMapping`
			WHERE		`tableMapping`.`isActive`		=	1";
			if ($this->model->gettableMappingId ( 0, 'single' )) {
				$sql .= " AND `" . $this->model->getTableName () . "`.`" . $this->model->getPrimaryKeyName () . "`='" . $this->model->gettableMappingId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT 		*
			FROM 		[tableMapping]
			WHERE		[tableMapping].[isActive]		=	1";
			if ($this->model->gettableMappingId ( 0, 'single' )) {
				$sql .= " AND [" . $this->model->getTableName () . "].[" . $this->model->getPrimaryKeyName () . "]='" . $this->model->gettableMappingId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT 		*
			FROM 		TABLEMAPPING
			WHERE		TABLEMAPPING.ISACTIVE=1";
			if ($this->model->gettableMappingId ( 0, 'single' )) {
				$sql .= " AND " . strtoupper ( $this->model->getTableName () ) . "." . strtoupper ( $this->model->getPrimaryKeyName () ) . "='" . $this->model->gettableMappingId ( 0, 'single' ) . "'";
			}
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = array ( 'tableMappingId', 'tableMappingTranslateId' );
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = array ( 'tableMapping', 'tableMappingTranslate' );

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
		//echo $sql;
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
				$sqlLimit = $sql;
			} else if ($this->getVendor () == self::MSSQL) {
				/**
				 * Sql Server and Oracle used row_number
				 * Parameterize Query We don't support
				 */
				$sqlLimit = "
							WITH [tableMappingDerived] AS
							(
								SELECT	*,
								[tableMapping].[executeBy],
								[tableMapping].[executeTime]
								ROW_NUMBER() OVER (ORDER BY [tableMappingId]) AS 'RowNumber'
								FROM 		[tableMapping]

								JOIN 		[module]
								ON			[module].[moduleId` = `tableMapping`.`moduleId`

								LEFT JOIN	[icon]
								ON			[tableMapping].[iconId]=[icon].[iconId]
								WHERE		[tab].[isActive]	=	1
								AND			[tableMapping].[isActive]		=	1  " . $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[tableMappingDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $this->getStart () . "
							AND 			" . ($this->getStart () + $_POST ['limit'] - 1) . ";";
					
			} else if ($this->getVendor () == self::ORACLE) {
				/**
				 * Oracle using derived table also
				 */

				$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT 		*,
												TABLEMAPPING.EXECUTEBY,
												TABLEMAPPING.EXECUTETIME
									FROM 		TABLEMAPPING
									JOIN		TABLEMAPPINGTRANSLATE
									ON			TABLEMAPPING.TABLEMAPPINGID	=TABLEMAPPINGTRANSLATE.TABLEMAPPINGID
									JOIN 		MODULE
									ON			MODULE.MODULEID = TABLEMAPPING.\"moduleId\"
									JOIN		MODULETRANSLATE
									ON			MODULE.MODULEID=	\"tabTranslate\".\"moduleId\"
									AND			MODULETRANSLATE.MODULEID =TABLEMAPPING.\"moduleId\"
									LEFT JOIN	ICON
									ON			TABLEMAPPING.ICONID=ICON.ICONID
									WHERE		\"tab\".ISACTIVE=1
									AND			TABLEMAPPING.ISACTIVE=1 " . $tempSql . $tempSql2 . "
								 ) a
						WHERE rownum <= '" . ($this->getStart () + $this->getLimit () - 1) . "' )
						where r >=  '" . $this->getStart () . "'";
					
			} else {
				echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			}
		}

		/*
		 *  Only Execute One Query
		 */
		if (! ($this->model->getTableMappingId(0, 'single'))) {

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

		if ($this->model->getTableMappingId(0, 'single')) {
			$end = microtime(true);
			$time = $end - $start;
			$json_encode = json_encode (
			array (	'success' => true,
						'total' => $total,
						'time'=>$time, 
						'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getTableMappingId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getTableMappingId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value'),
						'data' => $items, 
			) );
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
						'time'=>$time, 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getTableMappingId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getTableMappingId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value'), 
						'data' => $items ) );
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
		$this->q->start ();
		$this->model->update ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
					UPDATE 	`tableMapping`
					SET 	`moduleId`					=	'" . $this->model->getmoduleId () . "',
							`tableMappingNote`			=	'" . $this->model->gettableMappingNote () . "',
							`tableMappingSequence`		=	'" . $this->model->gettableMappingSequence () . "',
							`tableMappingCode`			=	'" . $this->model->gettableMappingCode () . "',
							`tableMappingPath`			=	'" . $this->model->gettableMappingPath () . "',
							`iconId`					=	'" . $this->model->getIconId () . "',
							`isDefault`					=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							`isActive`					=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							`isNew`						=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							`isDraft`					=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							`isUpdate`					=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							`isDelete`					=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							`isApproved`				=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							`executeBy`					=	'" . $this->model->getExecuteBy () . "',
							`executeTime`				=	" . $this->model->getExecuteTime () . "
					WHERE 	`tableMappingId`			=	'" . $this->model->gettableMappingId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
					UPDATE 	[tableMapping]
					SET 	[moduleId]					=	'" . $this->model->getmoduleId () . "',
							[tableMappingNote]			=	'" . $this->model->gettableMappingNote () . "',
							[tableMappingSequence]		=	'" . $this->model->gettableMappingSequence () . "',
							[tableMappingPath]			=	'" . $this->model->gettableMappingPath () . "',
							[iconId]					=	'" . $this->strict ( $_POST ['iconId'], 'string' ) . "',
							[isActive]					=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							[isNew]						=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							[isDraft]					=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							[isUpdate]					=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							[isDelete]					=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							[isApproved]				=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							[executeBy]					=	'" . $this->model->getExecuteBy () . "',
							[executeTime]				=	" . $this->model->getExecuteTime () . "
					WHERE 	[tableMappingId]			=	'" . $this->model->gettableMappingId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					UPDATE 	TABLEMAPPING
					SET 	MODULEID					=	'" . $this->model->getmoduleId () . "',
							TABLEMAPPINGNOTE			=	'" . $this->model->gettableMappingNote () . "',
							TABLEMAPPINGSEQUENCE		=	'" . $this->model->gettableMappingSequence () . "',
							TABLEMAPPINGPATH			=	'" . $this->model->gettableMappingPath () . "',
							ISDEFAULT					=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							ISACTIVE					=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							ISNEW						=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							ISDRAFT						=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							ISUPDATE					=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							ISDELETE					=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							ISAPPROVED					=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							ISREVIEW					=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							ISPOST						=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							EXECUTEBY					=	'" . $this->model->getExecuteBy () . "',
							EXECUTETIME					=	" . $this->model->getExecuteTime () . "
					WHERE 	TABLEMAPPINGID				=	'" . $this->model->gettableMappingId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::DB2) {

		} else if ($this->getVendor () == self::POSTGRESS) {

		}
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode (
			array (	"success" => false,
						"message" => $this->q->responce
			) );
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
		$this->q->start ();
		$this->model->delete ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
					UPDATE	`tableMapping`
					SET		`isDefault`			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							`isActive`			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							`isNew`				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							`isDraft`			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							`isUpdate`			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							`isDelete`			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							`isApproved`		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							`executeBy`			=	'" . $this->model->getExecuteBy () . "',
							`executeTime`		=	" . $this->model->getExecuteTime () . "
					WHERE 	`tableMappingId`	=	'" . $this->model->gettableMappingId () . "'";

		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
					UPDATE	[tableMapping]
					SET		[isDefault]			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							[isActive]			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							[isNew]				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							[isDraft]			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							[isUpdate]			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							[isDelete]			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							[isApproved]		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							[executeBy]			=	'" . $this->model->getExecuteBy () . "',
							[executeTime]		=	" . $this->model->getExecuteTime () . "
					WHERE 	[tableMappingId]	=	'" . $this->model->gettableMappingId () . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					UPDATE	TABLEMAPPING
					SET		ISDEFAULT			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							ISACTIVE			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							ISNEW				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							ISDRAFT				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							ISUPDATE			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							ISDELETE			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							ISAPPROVED			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							ISREVIEW			=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							ISPOST				=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							EXECUTEBY			=	'" . $this->model->getExecuteBy () . "',
							EXECUTETIME			=	" . $this->model->getExecuteTime () . "
					WHERE 	TABLEMAPPINGID		=	'" . $this->model->gettableMappingId () . "'";
		} else if ($this->getVendor () == self::DB2) {

		} else if ($this->getVendor () == self::POSTGRESS) {

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
		array (	"success" =>true,
					"message" => $this->systemString->getDeleteMessage(),
					"time"=>$time ) );
		exit ();

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

		$this->excel->setActiveSheetIndex ( 0 );
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array ('borders' => array ('inside' => array ('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array ('argb' => '000000' ) ), 'outline' => array ('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array ('argb' => '000000' ) ) ) );
		// header all using  3 line  starting b
		$this->excel->getActiveSheet ()->setCellValue ( 'B2', $this->title );
		$this->excel->getActiveSheet ()->setCellValue ( 'D2', '' );
		$this->excel->getActiveSheet ()->mergeCells ( 'B2:D2' );
		$this->excel->getActiveSheet ()->setCellValue ( 'B3', 'No' );
		$this->excel->getActiveSheet ()->setCellValue ( 'C3', 'tableMapping' );
		$this->excel->getActiveSheet ()->setCellValue ( 'D3', 'Description' );
		$this->excel->getActiveSheet ()->getStyle ( 'B2:D2' )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$this->excel->getActiveSheet ()->getStyle ( 'B2:D2' )->getFill ()->getStartColor ()->setARGB ( '66BBFF' );
		$this->excel->getActiveSheet ()->getStyle ( 'B3:D3' )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$this->excel->getActiveSheet ()->getStyle ( 'B3:D3' )->getFill ()->getStartColor ()->setARGB ( '66BBFF' );

		//
		$loopRow = 4;
		$i = 0;
		while ( ($row = $this->q->fetchAssoc ()) == true ) {

			$this->excel->getActiveSheet ()->setCellValue ( 'B' . $loopRow, ++ $i );
			$this->excel->getActiveSheet ()->setCellValue ( 'C' . $loopRow, $row ['tableMappingNote'] );
			$loopRow ++;
			$lastRow = 'D' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet ()->getStyle ( $formula )->applyFromArray ( $styleThinBlackBorderOutline );
		$objWriter = PHPExcel_IOFactory::createWriter ( $this->excel, 'Excel2007' );
		$filename = "tableMapping" . rand ( 0, 10000000 ) . ".xlsx";
		$path = $_SERVER ['DOCUMENT_ROOT'] . "/" . $this->application . "/security/document/excel/" . $filename;
		$objWriter->save ( $path );
		$this->audit->create_trail ( $this->getLeafId, $path, $filename );
		$file = fopen ( $path, 'r' );
		if ($file) {
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode (
			array (	"success" =>true,
						"message" => $this->systemString->getFileGenerateMessage(),
						"time"=>$time ) );
		} else {
			echo json_encode ( array ("success" => false, "message" => $this->systemString->getFileNotGenerateMessage() ) );

		}
	}

}

$tableMappingObject = new TableMappingClass ();

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
		$tableMappingObject->setLeafId ( $_POST ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_POST ['isAdmin'] )) {
		$tableMappingObject->setIsAdmin ( $_POST ['isAdmin'] );
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$tableMappingObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$tableMappingObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Filtering
	 */

	if (isset ( $_POST ['query'] )) {
		$tableMappingObject->setFieldQuery ( $_POST ['query'] );
	}
	if (isset ( $_POST ['filter'] )) {
		$tableMappingObject->setGridQuery ( $_POST ['filter'] );
	}
	/*
	 * Ordering
	 */
	if (isset ( $_POST ['order'] )) {
		$tableMappingObject->setOrder ( $_POST ['order'] );
	}
	if (isset ( $_POST ['sortField'] )) {
		$tableMappingObject->setSortField ( $_POST ['sortField'] );
	}

	/*
	 *  Load the dynamic value
	 */
	$tableMappingObject->execute ();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$tableMappingObject->create ();
	}
	if ($_POST ['method'] == 'read') {

		$tableMappingObject->read ();

	}

	if ($_POST ['method'] == 'save') {

		$tableMappingObject->update ();

	}
	if ($_POST ['method'] == 'delete') {
		$tableMappingObject->delete ();
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
		$tableMappingObject->setLeafId ( $_GET ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_GET ['isAdmin'] )) {
		$tableMappingObject->setIsAdmin ( $_GET ['isAdmin'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$tableMappingObject->execute ();
	if (isset ( $_GET ['field'] )) {
		if ($_GET ['field'] == 'staffId') {

			$tableMappingObject->staff ();
		}

	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$tableMappingObject->updateStatus ();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset ( $_GET ['tableMappingCode'] )) {
		if (strlen ( $_GET ['tableMappingCode'] ) > 0) {
			$tableMappingObject->duplicate ();
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$tableMappingObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$tableMappingObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$tableMappingObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$tableMappingObject->lastRecord('json');
		}
	}
	/*
	 *  Excel Reporting
	 */
	if (isset ( $_GET ['mode'] )) {
		if ($_GET ['mode'] == 'excel') {
			$tableMappingObject->excel ();
		}
	}

}

?>

