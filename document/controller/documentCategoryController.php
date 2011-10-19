<?php
session_start ();
require_once ("../../class/classAbstract.php");
require_once("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../model/documentCategoryModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Document
 * @package Document Category
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class DocumentCategoryClass extends ConfigClass {
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
	 *  Record Pagination
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
	 * documentCategory Model
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
		// audit property
		$this->audit = 0;
		$this->log = 1;
		
		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor ();
		$this->q->leafId = $this->getLeafId ();
		$this->q->staffId = $this->getStaffId ();
		$this->q->fieldQuery = $this->getFieldQuery ();
		$this->q->gridQuery = $this->getGridQuery ();
		$this->q->log = $this->log;
		$this->q->audit = $this->audit;
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );
		
		$this->model = new DocumentCategoryModel ();
		$this->model->setVendor ( $this->getVendor () );
		$this->model->execute ();
		
		$this->recordSet =  new RecordSet();
		$this->recordSet->setTableName($this->model->getTableName());
		$this->recordSet->setPrimaryKeyName($this->model->getPrimaryKeyName());
		$this->recordSet->execute();
		
		$this->documentTrail = new DocumentTrailClass ();
		$this->documentTrail->setVendor ( $this->getVendor () );
		$this->documentTrail->setStaffId ( $this->getStaffId () );
		$this->documentTrail->setLeafId ( $this->getLeafId () );
		$this->documentTrail->execute ();
		
		$this->excel = new PHPExcel ();
	
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->start ();
		$this->model->create ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			INSERT INTO `documentCategory`
					(
						`documentCategoryTitle`,												`documentCategoryDesc`,
						`documentCategorySequence`,										`documentCategoryCode`,
						`documentCategoryNote`,												`isDefault`,
						`isNew`,																		`isDraft`,
						`isUpdate`,																	`isDelete`,
						`isActive`,																	`isApproved`,
						`isReview`,																	`isPost`,
						`executeBy`,																`executeTime`
					)
			VALUES
					(
						'" . $this->model->getDocumentCategoryTitle () . "',				'" . $this->model->getDocumentCategoryDesc () . "',
						'" . $this->model->getDocumentCategorySequence () . "',		'" . $this->model->getDocumentCategoryCode () . "',
						'" . $this->model->getDocumentCategoryNote () . "',			'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',						'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',					'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',					'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getIsReview ( 0, 'single' ) . "',					'" . $this->model->getIsPost ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',								" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			INSERT INTO [documentCategory]
					(
						[documentCategoryTitle],													[documentCategoryDesc],
						[documentCategorySequence],											[documentCategoryCode],
						[documentCategoryNote],													[isDefault],
						[isNew],																			[isDraft],
						[isUpdate],																		[isDelete],
						[isActive],																			[isApproved],
						[isReview],																		[isPost],
						[executeBy],																		[executeTime]
					)
			VALUES
					(
						'" . $this->model->getDocumentCategoryTitle () . "',				'" . $this->model->getDocumentCategoryDesc () . "',
						'" . $this->model->getDocumentCategorySequence () . "',		'" . $this->model->getDocumentCategorySequence () . "',
						'" . $this->model->getDocumentCategoryNote () . "',			'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',						'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',					'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',					'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getIsReview ( 0, 'single' ) . "',					'" . $this->model->getIsPost ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',								" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			INSERT INTO DOCUMENTCATEGORY
					(
						DOCUMENTCATEGORYTITLE,												DOCUMENTCATEGORYDESC,
						DOCUMENTCATEGORYSEQUENCE,										DOCUMENTCATEGORYCODE,
						DOCUMENTCATEGORYNOTE,												ISDEFAULT,
						ISNEW,																				ISDRAFT,
						ISUPDATE,																		ISDELETE,
						ISACTIVE,																			ISAPPROVED,
						ISREVIEW,																		ISPOST,
						EXECUTEBY,																		EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getDocumentCategoryTitle () . "',				'" . $this->model->getDocumentCategoryDesc () . "',
						'" . $this->model->getDocumentCategorySequence () . "',		'" . $this->model->getDocumentCategorySequence () . "',
						'" . $this->model->getDocumentCategoryNote () . "',			'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',						'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',					'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',					'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getIsReview ( 0, 'single' ) . "',					'" . $this->model->getIsPost ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',								" . $this->model->getExecuteTime () . "
					);";
		}
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => true, "message" => "Record Created" ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->isAdmin == 0) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	`documentCategory`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[documentCategory].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	DOCUMENTCATEGORY.ISACTIVE	=	1	";
			}
		} else if ($this->isAdmin == 1) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	1 =	 1 ";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	1 = 1 ";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = " 1 = 1 ";
			}
		}
		//UTF8
		$items = array ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT	`documentCategory`.`documentCategoryId`,
						`documentCategory`.`documentCategoryTitle`,
						`documentCategory`.`documentCategoryDesc`,
						`documentCategory`.`documentCategorySequence`,
						`documentCategory`.`documentCategoryCode`,
						`documentCategory`.`documentCategoryNote`,
						`documentCategory`.`isDefault`,
						`documentCategory`.`isNew`,
						`documentCategory`.`isDraft`,
						`documentCategory`.`isUpdate`,
						`documentCategory`.`isDelete`,
						`documentCategory`.`isActive`,
						`documentCategory`.`isApproved`,
						`documentCategory`.`isReview`,
						`documentCategory`.`isPost`,
						`documentCategory`.`executeBy`,
						`documentCategory`.`executeTime`,
						`staff`.`staffName`
			FROM 	`documentCategory`
			JOIN		`staff`
			ON		`documentCategory`.`executeBy` = `staff`.`staffId`
			WHERE 	" . $this->auditFilter;
			if ($this->model->getDocumentCategoryId ( 0, 'single' )) {
				$sql .= " AND `" . $this->model->getTableName () . "`.`" . $this->model->getPrimaryKeyName () . "`='" . $this->model->getDocumentCategoryId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
					SELECT	[documentCategory].[documentCategoryId],
							[documentCategory].[documentCategoryTitle],
							[documentCategory].[documentCategoryDesc],
							[documentCategory].[documentCategorySequence],
							[documentCategory].[documentCategoryCode],
							[documentCategory].[documentCategoryNote],
							[documentCategory].[isDefault],
							[documentCategory].[isNew],
							[documentCategory].[isDraft],
							[documentCategory].[isUpdate],
							[documentCategory].[isDelete],
							[documentCategory].[isActive],
							[documentCategory].[isApproved],
							[documentCategory].[isReview],
							[documentCategory].[isPost],
							[documentCategory].[executeBy],
							[documentCategory].[executeTime],
							[staff].[staffName]
					FROM 	[documentCategory]
					JOIN	[staff]
					ON		[documentCategory].[executeBy] = [staff].[staffId]
					WHERE 	[documentCategory].[isActive] ='1'	";
			if ($this->model->getDocumentCategoryId ( 0, 'single' )) {
				$sql .= " AND [" . $this->model->getTableName () . "].[" . $this->model->getPrimaryKeyName () . "]='" . $this->model->getDocumentCategoryId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					SELECT	DOCUMENTCATEGORY.DOCUMENTCATEGORYID			AS		\"documentCategoryId\",
							DOCUMENTCATEGORY.DOCUMENTCATEGORYTITLE      	AS		\"documentCategoryTitle\",
							DOCUMENTCATEGORY.DOCUMENTCATEGORYDESC			AS		\"documentCategoryDesc\",
							DOCUMENTCATEGORY.DOCUMENTCATEGORYCODE			AS		\"documentCategoryCode\",
							DOCUMENTCATEGORY.DOCUMENTCATEGORYSEQUENCE	AS		\"documentCategorySequence\",
							DOCUMENTCATEGORY.DOCUMENTCATEGORYNOTE			AS		\"documentCategoryNote\",
							DOCUMENTCATEGORY.ISDEFAULT									AS		\"isDefault\",
							DOCUMENTCATEGORY.ISNEW											AS		\"isNew\",
							DOCUMENTCATEGORY.ISDRAFT										AS		\"isDraft\",
							DOCUMENTCATEGORY.ISUPDATE									AS		\"isUpdate\",
							DOCUMENTCATEGORY.ISDELETE									AS		\"isDelete\",
							DOCUMENTCATEGORY.ISACTIVE									AS		\"isActive\",
							DOCUMENTCATEGORY.ISAPPROVED								AS		\"isApproved\",
							DOCUMENTCATEGORY.ISREVIEW									AS		\"isReview\",
							DOCUMENTCATEGORY.ISPOST										AS		\"isPost\",
							DOCUMENTCATEGORY.EXECUTEBY									AS		\"executeBy\",
							DOCUMENTCATEGORY.EXECUTETIME								AS		\"executeTime\",
							STAFF.STAFFNAME															AS		\"staffName\"
					FROM 	DOCUMENTCATEGORY			
					JOIN	STAFF
					ON		DOCUMENTCATEGORY.EXECUTEBY = STAFF.STAFFID
					WHERE 	ISACTIVE='1'	";
			if ($this->model->getDocumentCategoryId ( 0, 'single' )) {
				$sql .= " AND " . strtoupper ( $this->model->getTableName () ) . "." . strtoupper ( $this->model->getPrimaryKeyName () ) . "='" . $this->model->getDocumentCategoryId ( 0, 'single' ) . "'";
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
		$filterArray = array ('documentCategoryId' );
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array ('documentCategory' );
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
		
			if ($this->getStart() && $this->getLimit ()) {
				// only mysql have limit
				if ($this->getVendor () == self::MYSQL) {
					$sql .= " LIMIT  " . $this->getStart () . "," . $this->getLimit () . " ";
				} else if ($this->getVendor () == self::MSSQL) {
					/**
					 * Sql Server and Oracle used row_number
					 * Parameterize Query We don't support
					 */
					$sql = "
							WITH [documentCategoryDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [documentCategoryId]) AS 'RowNumber'
								FROM [documentCategory]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[documentCategory].[documentCategoryId],
											[documentCategory].[documentCategoryTitle],
											[documentCategory].[documentCategoryDesc],	
											[documentCategory].[documentCategorySequence],
											[documentCategory].[documentCategoryCode],
											[documentCategory].[documentCategoryNote],
											[documentCategory].[isDefault],
											[documentCategory].[isNew],
											[documentCategory].[isDraft],
											[documentCategory].[isUpdate],
											[documentCategory].[isDelete],
											[documentCategory].[isApproved],
											[documentCategory].[isReview],
											[documentCategory].[isPost],
											[documentCategory].[executeBy],
											[documentCategory].[executeTime],
											[staff].[staffName]
							FROM 		[documentCategoryDerived]
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
									SELECT	DOCUMENTCATEGORY.DOCUMENTCATEGORYID				AS		\"documentCategoryId\",
												DOCUMENTCATEGORY.DOCUMENTCATEGORYTITLE      	AS		\"documentCategoryTitle\",
												DOCUMENTCATEGORY.DOCUMENTCATEGORYDESC			AS		\"documentCategoryDesc\",
												DOCUMENTCATEGORY.DOCUMENTCATEGORYCODE			AS		\"documentCategoryCode\",
												DOCUMENTCATEGORY.DOCUMENTCATEGORYSEQUENCE	AS		\"documentCategorySequence\",
												DOCUMENTCATEGORY.DOCUMENTCATEGORYNOTE			AS		\"documentCategoryNote\",
												DOCUMENTCATEGORY.ISDEFAULT									AS		\"isDefault\",
												DOCUMENTCATEGORY.ISNEW											AS		\"isNew\",
												DOCUMENTCATEGORY.ISDRAFT										AS		\"isDraft\",
												DOCUMENTCATEGORY.ISUPDATE									AS		\"isUpdate\",
												DOCUMENTCATEGORY.ISDELETE									AS		\"isDelete\",
												DOCUMENTCATEGORY.ISACTIVE									AS		\"isActive\",
												DOCUMENTCATEGORY.ISAPPROVED								AS		\"isApproved\",
												DOCUMENTCATEGORY.ISREVIEW									AS		\"isReview\",
												DOCUMENTCATEGORY.ISPOST										AS		\"isPost\",
												DOCUMENTCATEGORY.EXECUTEBY									AS		\"executeBy\",
												DOCUMENTCATEGORY.EXECUTETIME								AS		\"executeTime\",
												STAFF.STAFFNAME															AS		\"staffName\"
									FROM 	DOCUMENTCATEGORY			
									JOIN		STAFF
									ON		DOCUMENTCATEGORY.EXECUTEBY = STAFF.STAFFID
									WHERE 	ISACTIVE='1'  " . $tempSql . $tempSql2 . "
								 ) a
						where rownum <= '" . ($this->getStart () + $this->getLimit () - 1) . "' )
						where r >=  '" . $this->getStart () . "'";
				} else {
					echo "undefine vendor";
					exit ();
				}
			}
		
		/*
		 *  Only Execute One Query
		 */
		if (! ($this->model->getDocumentCategoryId ( 0, 'single' ))) {
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
		if ($this->model->getDocumentCategoryId ( 0, 'single' )) {
			$json_encode = json_encode ( array ('success' => TRUE, 'total' => $total, 'message' => 'Data Loaded', 'data' => $items ) );
			$json_encode = str_replace ( "[", "", $json_encode );
			$json_encode = str_replace ( "]", "", $json_encode );
			echo $json_encode;
		} else {
			if (count ( $items ) == 0) {
				$items = '';
			}
			echo json_encode ( array ('success' => TRUE, 'total' => $total, 'message' => 'data loaded', 'data' => $items ) );
			exit ();
		}
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->commit ();
		$this->model->update ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			UPDATE 	`documentCategory`
			SET			`documentCategoryTitle`				=	'" . $this->model->getDocumentCategoryTitle () . "',
							`documentCategoryDesc`				=	'" . $this->model->getDocumentCategoryDesc () . "',
							`documentCategorySequence`		=	'" . $this->model->getDocumentCategorySequence () . "',
							`documentCategoryCode`				=	'" . $this->model->getDocumentCategoryCode () . "',
							`documentCategoryNote` 				= 	'" . $this->model->getDocumentCategoryNote () . "',
							`isDefault`									=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							`isActive`										=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							`isNew`										=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							`isDraft`										=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							`isUpdate`									=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							`isDelete`										=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							`isApproved`								=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							`isReview`									=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							`isPost`										=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							`executeBy`									=	'" . $this->model->getExecuteBy () . "',
							`executeTime`								=	" . $this->model->getExecuteTime () . "
			WHERE 		`documentCategoryId`					=	'" . $this->model->getDocumentCategoryId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			UPDATE 	[documentCategory]
			SET 			[documentCategoryTitle]				=	'" . $this->model->getDocumentCategoryTitle () . "',
							[documentCategoryDesc]				=	'" . $this->model->getDocumentCategoryDesc () . "',
							[documentCategorySequence]		=	'" . $this->model->getDocumentCategorySequence () . "',
							[documentCategoryCode]				=	'" . $this->model->getDocumentCategoryCode () . "',
							[documentCategoryNote] 				= 	'" . $this->model->getDocumentCategoryNote () . "',
							[isDefault]										=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							[isActive]										=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							[isNew]											=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							[isDraft]										=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							[isUpdate]										=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							[isDelete]										=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							[isApproved]									=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							[executeBy]									=	'" . $this->model->getExecuteBy () . "',
							[executeTime]								=	" . $this->model->getExecuteTime () . "
			WHERE 		[documentCategoryId]					=	'" . $this->model->getDocumentCategoryId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			UPDATE 	DOCUMENTCATEGORY
			SET 			DOCUMENTCATEGORYTITLE			=	'" . $this->model->getDocumentCategoryTitle () . "',
							DOCUMENTCATEGORYDESC			=	'" . $this->model->getDocumentCategoryDesc () . "',
							DOCUMENTCATEGORYSEQUENCE	=	'" . $this->model->getDocumentCategorySequence () . "',
							DOCUMENTCATEGORYCODE			=	'" . $this->model->getDocumentCategoryCode () . "',
							DOCUMENTCATEGORYNOTE 			= 	'" . $this->model->getDocumentCategoryNote () . "',
							ISDEFAULT									=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							ISACTIVE										=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							ISNEW											=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							ISDRAFT										=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							ISUPDATE										=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							ISDELETE										=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							ISAPPROVED									=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							ISDELETE										=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							ISAPPROVED									=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							ISREVIEW										=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							ISPOST											=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							EXECUTEBY									=	'" . $this->model->getExecuteBy () . "',
							EXECUTETIME								=	" . $this->model->getExecuteTime () . "
				WHERE 	DOCUMENTCATEGORYID				=	'" . $this->model->getDocumentCategoryId ( 0, 'single' ) . "'";
		}
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => true, "message" => "Record Update" ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->commit ();
		$this->model->delete ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			UPDATE 	`documentCategory`
			SET 			`isDefault`							=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							`isActive`								=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							`isNew`								=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							`isDraft`								=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							`isUpdate`							=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							`isDelete`								=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							`isApproved`						=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							`isReview`							=	'" . $this->model->getIsReview( 0, 'single' ) . "',
							`isPost`								=	'" . $this->model->getIsPost ( 0, 'single' ) . "',					
							`executeBy`							=	'" . $this->model->getBy ( 0, 'single' ) . "',
							`executeTime						=	" . $this->model->getExecuteTime () . "
			WHERE 		`documentCategoryId`			=	'" . $this->model->getDepartrmentId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			UPDATE 	[documentCategory]
			SET 			[isDefault]								=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							[isActive]								=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							[isNew]									=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							[isDraft]								=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							[isUpdate]								=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							[isDelete]								=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							[isApproved]							=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							[isReview]								=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							[isPost]									=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							[executeBy]							=	'" . $this->model->getExecuteBy () . "',
							[executeTime]						=	" . $this->model->getExecuteTime () . "
			WHERE 		[documentCategoryId]			=	'" . $this->model->getDocumentCategoryId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			UPDATE DOCUMENTCATEGORY
			SET 		ISDEFAULT							=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						ISACTIVE								=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
						ISNEW									=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
						ISDRAFT								=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						ISUPDATE								=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						ISDELETE								=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						ISAPPROVED							=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						ISREVIEW								=  '" . $this->model->getIsReview ( 0, 'single' ) . "',
						ISPOST									=  '" . $this->model->getIsPost( 0, 'single' ) . "',
						EXECUTEBY							=	'" . $this->model->getExecuteBy () . "',
						EXECUTETIME						=	" . $this->model->getExecuteTime () . "
			WHERE 	DOCUMENTCATEGORYID	=	'" . $this->model->getDocumentCategoryId ( 0, 'single' ) . "'";
		}
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => true, "message" => "Record Remove" ) );
		exit ();
	}
	/**
	 * To Update flag Status
	 */
	function updateStatus() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
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
			UPDATE 	" . strtoupper ( $this->model->getTableName () ) . "
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
				$sqlLooping .= "	'" . $systemCheck . "' = CASE '" . $this->model->getPrimaryKeyName () . "'";
			}
			switch ($systemCheck) {
				case 'isDefault' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDefault ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentCategoryId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsDefault ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isNew' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsNew ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentCategoryId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsNew ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isDraft' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDraft ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentCategoryId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsDraft ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isUpdate' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsUpdate ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentCategoryId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsUpdate ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isDelete' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDelete ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentCategoryId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsDelete ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isActive' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsActive ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentCategoryId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsActive ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isApproved' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsApproved ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentCategoryId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsApproved ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isReview' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsReview ( $i, 'array' )) {
							$sqlLooping .= "
                            WHEN '" . $this->model->getDocumentCategoryId ( $i, 'array' ) . "'
                            THEN '" . $this->model->getIsReview ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isPost' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsPost ( $i, 'array' )) {
							$sqlLooping .= "
                                WHEN '" . $this->model->getDocumentCategoryId ( $i, 'array' ) . "'
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
			WHERE 	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " IN (" . $this->model->getPrimaryKeyAll () . ")";
		}
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => true, "message" => "Deleted" ) );
		exit ();
	}
	/**
	 * To check if a key duplicate or not
	 */
	function duplicate() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT	*
			FROM 	`documentCategory`
			WHERE 	`documentCategoryCode` 	= 	'" . $this->model->getDocumentCategoryCode () . "'
			AND		`isActive`		=	1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	*
			FROM 	[documentCategory]
			WHERE 	[documentCategoryCode] 	= 	'" . $this->model->getDocumentCategoryCode () . "'
			AND		[isActive]				=	1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	*
			FROM 	DOCUMENTCATEGORY
			WHERE 	DOCUMENTCATEGORYCODE 	= 	'" . $this->model->getDocumentCategoryCode () . "'
			AND		ISACTIVE				=	1";
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
				return $total . "|" . $row ['documentCategoryCode'];
			} else {
				echo json_encode ( array ("success" => "TRUE", "total" => $total, "message" => "Duplicate Record", "documentCategoryCode" => $row ['documentCategoryCode'] ) );
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
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		//UTF8
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
		if ($this->isAdmin == 1) {
			$this->excel->getActiveSheet ()->getColumnDimension ( 'B' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'C' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'D' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'E' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'F' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'G' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'H' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'I' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'J' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'K' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'L' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'M' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'N' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'O' )->setAutoSize ( TRUE );
		} else {
			$this->excel->getActiveSheet ()->getColumnDimension ( 'B' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'C' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'D' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'E' )->setAutoSize ( TRUE );
			$this->excel->getActiveSheet ()->getColumnDimension ( 'F' )->setAutoSize ( TRUE );
		}
		if ($this->isAdmin == 1) {
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
		if ($this->isAdmin == 1) {
			// future should take from table mapping table
			$this->excel->getActiveSheet ()->setCellValue ( 'B3', 'No' );
			$this->excel->getActiveSheet ()->setCellValue ( 'C3', 'documentCategory Id' );
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
		while ( ($row = $this->q->fetchAssoc ()) == TRUE ) {
			//	echo print_r($row);
			$this->excel->getActiveSheet ()->setCellValue ( 'B' . $loopRow, ++ $i );
			if ($this->isAdmin == 1) {
				$this->excel->getActiveSheet ()->setCellValue ( 'C' . $loopRow, $row ['documentCategoryId'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'D' . $loopRow, $row ['documentCategorySequence'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'E' . $loopRow, $row ['documentCategoryCode'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'F' . $loopRow, $row ['documentCategoryNote'] );
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
				$this->excel->getActiveSheet ()->setCellValue ( 'C' . $loopRow, $row ['documentCategorySequence'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'D' . $loopRow, $row ['documentCategoryCode'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'E' . $loopRow, $row ['documentCategoryNote'] );
			}
			$loopRow ++;
		}
		$lastRow = $end . $loopRow;
		$from = $start . '2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet ()->getStyle ( $formula )->applyFromArray ( $styleThinBlackBorderOutline );
		$objWriter = PHPExcel_IOFactory::createWriter ( $this->excel, 'Excel2007' );
		$filename = "documentCategory" . rand ( 0, 10000000 ) . ".xlsx";
		$path = $_SERVER ['DOCUMENT_ROOT'] . $this->getApplication () . "/management/document/excel/" . $filename;
		$this->documentTrail->setDocumentPath ( $path );
		$this->documentTrail->setDocumentFilename ( $filename );
		$this->documentTrail->create ();
		$objWriter->save ( $path );
		$file = fopen ( $path, 'r' );
		if ($file) {
			echo json_encode ( array ("success" => true, "message" => "File generated", "filename" => $filename ) );
			exit ();
		} else {
			echo json_encode ( array ("success" => false, "message" => "File not generated" ) );
			exit ();
		}
	}
}
$documentCategoryObject = new DocumentCategoryClass ();
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
		$documentCategoryObject->setLeafId ( $_POST ['leafId'] );
	}
	/*
	 *  Admin Only
	 */
	if (isset ( $_POST ['isAdmin'] )) {
		$documentCategoryObject->setIsAdmin ( $_POST ['isAdmin'] );
	}
	/*
	 *  Paging
	 */
	if (isset ( $_POST['start'] )) {
		$documentCategoryObject->setStart ( $_POST ['start'] );
	}
	if (isset ( $_POST ['limit'] )) {
		$documentCategoryObject->setLimit ( $_POST ['perPage'] );
	}
	/**
	 * Filtering
	 */
	if (isset ( $_POST ['query'] )) {
		$documentCategoryObject->setFieldQuery ( $_POST ['query'] );
	}
	if (isset ( $_POST ['filter'] )) {
		$documentCategoryObject->setGridQuery ( $_POST ['filter'] );
	}
	/**
	 * Ordering
	 */
	if (isset ( $_POST ['order'] )) {
		$documentCategoryObject->setOrder ( $_POST ['order'] );
	}
	if (isset ( $_POST ['sortField'] )) {
		$documentCategoryObject->setSortField ( $_POST ['sortField'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$documentCategoryObject->execute ();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$documentCategoryObject->create ();
	}
	if ($_POST ['method'] == 'read') {
		$documentCategoryObject->read ();
	}
	if ($_POST ['method'] == 'save') {
		$documentCategoryObject->update ();
	}
	if ($_POST ['method'] == 'delete') {
		$documentCategoryObject->delete ();
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
		$documentCategoryObject->setLeafId ( $_GET ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_GET ['isAdmin'] )) {
		$documentCategoryObject->setIsAdmin ( $_GET ['isAdmin'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$documentCategoryObject->execute ();
	if (isset ( $_GET ['field'] )) {
		if ($_GET ['field'] == 'staffId') {
			$documentCategoryObject->staff ();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$documentCategoryObject->updateStatus ();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset ( $_GET ['documentCategoryCode'] )) {
		if (strlen ( $_GET ['documentCategoryCode'] ) > 0) {
			$documentCategoryObject->duplicate ();
		}
	}
	/*
	 *  Excel Reporing
	 */
	if (isset ( $_GET ['mode'] )) {
		if ($_GET ['mode'] == 'excel') {
			$documentCategoryObject->excel ();
		}
	}
}
?>
