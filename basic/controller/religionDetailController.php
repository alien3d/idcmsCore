<?php
session_start ();
require_once ("../../class/classAbstract.php");
require_once("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../model/religionDetailModel.php");
/**
 * this is religionDetail setting files.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package religionDetail
 * @subpackage religionDetailv1,v2,v3
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ReligionDetailClass extends ConfigClass {
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
		
		$this->model = new ReligionDetailModel ();
		$this->model->setVendor ( $this->getVendor () );
		$this->model->execute ();
		
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
	public function create() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		//UTF8
		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->start ();
		$this->model->create ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			INSERT INTO `religionDetail`
					(
						`religionId`,											`religionDetailTitle`,						
						`religionDetailDesc`,									`isDefault`,
						`isNew`,												`isDraft`,
						`isUpdate`,												`isDelete`,
						`isActive`,												`isApproved`,
						`isReview`,                      		  	 			`isPost`,						
						`executeBy`,											`executeTime`
					)
			VALUES
					(
						'" . $this->model->getReligionId () . "',				'" . $this->model->getReligionDetailTitle () . "',					
						'" . $this->model->getReligionDetailDesc () . "',		'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',		'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getIsReview ( 0, 'single' ) . "',	'" . $this->model->getIsPost ( 0, 'single' ) . "',						
						'" . $this->model->getExecuteBy () . "',				" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			INSERT INTO [religionDetail]
					(
						[religionId],						[religionDetailTitle],					
						[religionDetailDesc],				[isDefault],
						[isNew],							[isDraft],
						[isUpdate],							[isDelete],
						[isActive],							[isApproved],
						[executeBy],						[executeTime]
					)
			VALUES
					(
						'" . $this->model->getReligionId () . "',					'" . $this->model->getReligionDetailTitle () . "',										
						'" . $this->model->getReligionDetailDesc () . "',			'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',			'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',		'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',		'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getIsReview ( 0, 'single' ) . "',		'" . $this->model->getIsPost ( 0, 'single' ) . "',						
						'" . $this->model->getExecuteBy () . "',					" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			INSERT INTO	RELIGIONDETAIL
					(
						RELIGIONID,						RELIGIONDETAILTITLE,
						RELIGIONDETAILDESC,				ISDEFAULT,
						ISNEW,							ISDRAFT,
						ISUPDATE,						ISDELETE,
						ISACTIVE,						ISAPPROVED,
						EXECUTEBY,						EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getReligionId () . "',				'" . $this->model->getReligionDetailTitle () . "',
						'" . $this->model->getReligionTitleDesc () . "',		'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',		'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getIsReview ( 0, 'single' ) . "',	'" . $this->model->getIsPost ( 0, 'single' ) . "',						
						'" . $this->model->getExecuteBy () . "',				" . $this->model->getExecuteTime () . "
					)";
		}
		//advance logging future
		$this->q->tableName = $this->model->getTableName ();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName ();
		// $this->q->primaryKeyValue = $this->q->lastInsertId();  not use here
		$this->q->audit = $this->audit;
		$this->q->create ( $sql );
		$religionDetailId = $this->q->lastInsertId ();
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => TRUE, "message" => "Record Created", "religionDetailId" => $religionDetailId ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read() {
		//	header('Content-Type', 'application/json; charset=utf-8');
		if ($this->isAdmin == 0) {
			if ($this->q->vendor == self::MYSQL) {
				$this->auditFilter = "	AND `religionDetail`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	AND [religionDetail].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	AND RELIGIONDETAIL.ISACTIVE	=	1	";
			}
		} else if ($this->isAdmin == 1) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	1	=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	1	=	1 	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	1	=	1 	";
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
					SELECT	`religionDetail`.`religionDetailId`,
							`religionDetail`.`religionDetailTitle`,
							`religionDetail`.`religionDetailDesc`,
							`religionDetail`.`isDefault`,
							`religionDetail`.`isNew`,
							`religionDetail`.`isDraft`,
							`religionDetail`.`isUpdate`,
							`religionDetail`.`isDelete`,
							`religionDetail`.`isActive`,
							`religionDetail`.`isApproved`,
							`religionDetail`.`isReview`,
							`religionDetail`.`isPost`,
							`religionDetail`.`executeBy`,
							`religionDetail`.`executeTime`,
							`religion`.`religionDesc`,
							`staff`.`staffName`
 					FROM 	`religionDetail`
 					JOIN	`religion`
 					USING	(`religionId`)
					JOIN	`staff`
					ON		`religionDetail`.`executeBy` = `staff`.`staffId`
					WHERE 	 " . $this->auditFilter;
			if ($this->model->getReligionDetailId ( 0, 'single' )) {
				$sql .= " AND `" . $this->model->getTableName () . "`.`" . $this->model->getPrimaryKeyName () . "`='" . $this->model->getReligionDetailId ( 0, 'single' ) . "'";
			}
			if ($this->model->getReligionId ()) {
				$sql .= " AND `" . $this->model->getTableName () . "`.`" . $this->model->getMasterForeignKeyName () . "`='" . $this->model->getReligionId () . "'";
			}
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
					SELECT	[religionDetail].[religionDetailId],
							[religionDetail].[religionDetailTitle],
							[religionDetail].[religionDetailDesc],
							[religionDetail].[isDefault],
							[religionDetail].[isNew],
							[religionDetail].[isDraft],
							[religionDetail].[isUpdate],
							[religionDetail].[isDelete],
							[religionDetail].[isActive],
							[religionDetail].[isApproved],
							[religionDetail].[isReview],
							[religionDetail].[isPost],
							[religionDetail].[executeBy],
							[religionDetail].[executeTime],
							[staff].[staffName]
					FROM 	[religionDetail]
					JOIN	[staff]
					ON		[religionDetail].[executeBy] = [staff].[staffId]
					WHERE 	" . $this->auditFilter;
			if ($this->model->getReligionDetailId ( 0, 'single' )) {
				$sql .= " AND [" . $this->model->getTableName () . "].[" . $this->model->getPrimaryKeyName () . "]		=	'" . $this->model->getReligionDetailId ( 0, 'single' ) . "'";
			}
			if ($this->model->getReligionId ()) {
				$sql .= " AND 	[" . $this->model->getTableName () . "].[" . $this->model->getMasterForeignKeyName () . "]	=	'" . $this->model->getReligionId () . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	RELIGIONDETAIL.RELIGIONDETAILID   		AS 	\"religionDetailId\",
						RELIGIONDETAIL.RELIGIONDETAILTITLE 	AS 	\"religionDetailTitle\",
						RELIGIONDETAIL.RELIGIONDETAILDESC 	AS 	\"religionDetailDesc\",
						RELIGIONDETAIL.ISDEFAULT    					AS	\"isDefault\",
						RELIGIONDETAIL.ISNEW		  					AS	\"isNew\",
						RELIGIONDETAIL.ISDRAFT	  						AS	\"isDraft\",
						RELIGIONDETAIL.ISUPDATE     					AS	\"isUpdate\",
						RELIGIONDETAIL.ISDELETE	  					AS	\"isDelete\",
						RELIGIONDETAIL.ISACTIVE	  					AS	\"isActive\",
						RELIGIONDETAIL.ISAPPROVED   				AS	\"isApproved\",
						RELIGIONDETAIL.ISREVIEW	  					AS	\"isReview\",
						RELIGIONDETAIL.ISPOST   						AS	\"isPost\",
						RELIGIONDETAIL.EXECUTEBY    					AS	\"executeBy\",
						RELIGIONDETAIL.EXECUTETIME  				AS	\"executeTime\",
						STAFF.STAFFNAME		  								AS	\"staffName\"	
			FROM 	RELIGIONDETAIL
			JOIN		STAFF
			ON		RELIGIONDETAIL.EXECUTEBY 	  	=	STAFF.STAFFID
			WHERE 	" . $this->auditFilter;
			if ($this->model->getReligionDetailId ( 0, 'single' )) {
				$sql .= " AND " . strtoupper ( $this->model->getTableName () ) . "." . strtoupper ( $this->model->getPrimaryKeyName () ) . "='" . $this->model->getReligionDetailId ( 0, 'single' ) . "'";
			}
			if ($this->model->getReligionId ()) {
				$sql .= " AND 	" . strtoupper ( $this->model->getTableName () ) . "." . strtoupper ( $this->model->getMasterForeignKeyName () ) . "	=	'" . $this->model->getReligionId () . "'";
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
		$filterArray = array ('religionDetailId' );
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array ('religionDetail' );
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
			} else if ($this->getVendor () == self::DB2) {
			
			} else if ($this->getVendor () == self::POSTGRESS) {
			
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
				$sql .= "	ORDER BY " . strtoupper ( $this->getSortField () ) . " " . strtoupper ( $this->getOrder () ) . " ";
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
							WITH [religionDetailDerived] AS
							(
								SELECT [religionDetail].[religionDetailId],
								        [religionDetail].[religionDetailTitle],								
										[religionDetail].[religionDetailDesc],
										[religionDetail].[isDefault],
										[religionDetail].[isNew],
										[religionDetail].[isDraft],
										[religionDetail].[isUpdate],
										[religionDetail].[isDelete],
										[religionDetail].[isApproved],
										[religionDetail].[isReview],
										[religionDetail].[isPost],
										[religionDetail].[executeBy],
										[religionDetail].[executeTime],
										[staff].[staffName],
								ROW_NUMBER() OVER (ORDER BY [religionDetailId]) AS 'RowNumber'
								FROM 	[religionDetail]
								JOIN	[staff]
								ON		[religionDetail].[executeBy] = [staff].[staffId]
								WHERE " . $this->auditFilter . $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[religionDetailDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . ($this->getStart () + 1) . "
							AND 			" . ($this->getStart () + $this->getLimit ()) . ";";
			} else if ($this->getVendor () == self::ORACLE) {
				/**
				 * Oracle using derived table also
				 */
				$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
								SELECT	RELIGIONDETAIL.RELIGIONDETAILID   	AS 	\"religionDetailId\",
										RELIGIONDETAIL.RELIGIONDETAILTITLE 	AS 	\"religionDetailTitle\",								
										RELIGIONDETAIL.RELIGIONDETAILDESC 	AS 	\"religionDetailDesc\",										
										RELIGIONDETAIL.ISDEFAULT    		AS	\"isDefault\",
										RELIGIONDETAIL.ISNEW		  		AS	\"isNew\",
										RELIGIONDETAIL.ISDRAFT	  			AS	\"isDraft\",
										RELIGIONDETAIL.ISUPDATE     		AS	\"isUpdate\",
										RELIGIONDETAIL.ISDELETE	  			AS	\"isDelete\",
										RELIGIONDETAIL.ISACTIVE	  			AS	\"isActive\",
										RELIGIONDETAIL.ISAPPROVED   		AS	\"isApproved\",
										RELIGIONDETAIL.ISREVIEW	  			AS	\"isReview\",
										RELIGIONDETAIL.ISPOST   			AS	\"isPost\",
										RELIGIONDETAIL.EXECUTEBY    		AS	\"executeBy\",
										RELIGIONDETAIL.EXECUTETIME  		AS	\"executeTime\",
										STAFF.STAFFNAME		  				AS	\"staffName\"	
								FROM 	RELIGIONDETAIL
								JOIN	STAFF
								ON		RELIGIONDETAIL.EXECUTEBY 	  	=	STAFF.STAFFID
								WHERE 	" . $this->auditFilter . $tempSql . $tempSql2 . "
								 ) a
						where rownum <= '" . ($this->getStart () + $this->getLimit ()) . "' )
						where r >=  '" . ($this->getStart () + 1) . "'";
			} else {
				echo "undefine vendor";
				exit ();
			}
		}
		
		/*
             *  Only Execute One Query
             */
		if (! ($this->model->getReligionDetailId ( 0, 'single' ))) {
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
		if ($this->model->getReligionDetailId ( 0, 'single' )) {
			$json_encode = json_encode ( array ('success' => TRUE, 'total' => $total, 'message' => 'Data Loaded', 'dataDetail' => $items, 'firstRecord' => $this->firstRecord ( 'value' ), 'previousRecord' => $this->previousRecord ( 'value', $this->model->getReligionDetailId ( 0, 'single' ) ), 'nextRecord' => $this->nextRecord ( 'value', $this->model->getReligionDetailId ( 0, 'single' ) ), 'lastRecord' => $this->lastRecord ( 'value' ) ) );
			$json_encode = str_replace ( "[", "", $json_encode );
			$json_encode = str_replace ( "]", "", $json_encode );
			echo $json_encode;
		} else {
			if (count ( $items ) == 0) {
				$items = '';
			}
			echo json_encode ( array ('success' => TRUE, 'total' => $total, 'message' => 'data loaded', 'dataDetail' => $items ) );
			exit ();
		}
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		//UTF8
		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
			if ($this->q->execute == 'fail') {
				echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
				exit ();
			}
		}
		$this->q->start ();
		$this->model->update ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			UPDATE 	`religionDetail`
			SET 	`religionDetailDesc`	=	'" . $this->model->getReligionDetailDesc () . "',
					`isDefault`				=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					`isNew`					=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					`isDraft`				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					`isUpdate`				=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					`isDelete`				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					`isActive`				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					`isApproved`			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					`isReview`				=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
					`isPost`				=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
					`executeBy`				=	'" . $this->model->getExecuteBy () . "',
					`executeTime`			=	" . $this->model->getExecuteTime () . "
			WHERE 	`religionDetailId`		=	'" . $this->model->getReligionDetailId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			UPDATE 	[religionDetail]
			SET 	[religionDetailDesc]	=	'" . $this->model->getReligionDetailDesc () . "',
					[isDefault]				=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					[isNew]					=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					[isDraft]				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					[isUpdate]				=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					[isDelete]				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					[isActive]				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					[isApproved]			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					[isReview]				=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
					[isPost]				=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
					[executeBy]				=	'" . $this->model->getExecuteBy () . "',
					[executeTime]			=	" . $this->model->getExecuteTime () . "
			WHERE 	[religionDetailId]		=	'" . $this->model->getReligionDetailId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			UPDATE 	RELIGIONDETAIL
			SET 	RELIGIONTITLE			=	'" . $this->model->getReligionDetailTitle () . "',
					RELIGIONDESC			=	'" . $this->model->getReligionDetailDesc () . "',
					ISDEFAULT				=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					ISNEW					=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					ISDRAFT					=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					ISUPDATE				=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					ISDELETE				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					ISACTIVE				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					ISAPPROVED				=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					ISREVIEW				=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
					ISPOST					=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
					EXECUTEBY				=	'" . $this->model->getExecuteBy () . "',
					EXECUTETIME				=	" . $this->model->getExecuteTime () . "
			WHERE 	RELIGIONDETAILID		=	'" . $this->model->getReligionDetailId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::DB2) {
		
		} else if ($this->getVendor () == self::POSTGRESS) {
		
		}
		/*
		 *  require three variable below to track  table audit
		 */
		$this->q->tableName = $this->model->getTableName ();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName ();
		$this->q->primaryKeyValue = $this->model->getReligionDetailId ( 0, 'single' );
		$this->q->audit = $this->audit;
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => "false", "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => "TRUE", "message" => "Updated" ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		//UTF8
		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->start ();
		$this->model->delete ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			UPDATE 	`religionDetail`
			SET 	`isDefault`			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					`isNew`				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					`isDraft`			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					`isUpdate`			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					`isDelete`			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					`isActive`			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					`isApproved`		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					`isReview`			=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
					`isPost`			=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
					`executeBy`			=	'" . $this->model->getExecuteBy () . "',
					`executeTime`		=	" . $this->model->getExecuteTime () . "
			WHERE 	`religionDetailId`	=	'" . $this->model->getReligionDetailId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			UPDATE 	[religionDetail]
			SET 	[isDefault]			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					[isNew]				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					[isDraft]			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					[isUpdate]			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					[isDelete]			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					[isActive]			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					[isApproved]		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					[isReview]			=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
					[isPost]			=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
					[executeBy]			=	'" . $this->model->getExecuteBy () . "',
					[executeTime]		=	" . $this->model->getExecuteTime () . "
			WHERE 	[religionDetailId]	=	'" . $this->model->getReligionDetailId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			UPDATE 	RELIGIONDETAIL
			SET 	RELIGIONDETAILDESC	=	'" . $this->model->getReligionDetailDesc ( 0, 'single' ) . "',
					ISDEFAULT			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					ISNEW				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					ISDRAFT				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					ISUPDATE			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					ISDELETE			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					ISACTIVE			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					ISAPPROVED			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					ISREVIEW			=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
					EXECUTEBY			=	'" . $this->model->getExecuteBy () . "',
					EXECUTETIME			=	" . $this->model->getExecuteTime () . "
			WHERE 	RELIGIONDETAILID	=	'" . $this->model->getReligionDetailId ( 0, 'single' ) . "'";
		}
		// advance logging future
		$this->q->tableName = $this->model->getTableName ();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName ();
		$this->q->primaryKeyValue = $this->model->getReligionDetailId ();
		$this->q->audit = $this->audit;
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => "false", "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => TRUE, "message" => "Deleted" ) );
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
			UPDATE " . strtoupper ( $this->model->getTableName () ) . "
			SET    ";
		}
		//	echo "arnab[".$this->model->getReligionDetailId(0,'array')."]";
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
							WHEN '" . $this->model->getReligionDetailId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsDefault ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isNew' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsNew ( $i, 'array' )) {
							
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionDetailId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsNew ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isDraft' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDraft ( $i, 'array' )) {
							
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionDetailId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsDraft ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isUpdate' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsUpdate ( $i, 'array' )) {
							
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionDetailId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsUpdate ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isDelete' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDelete ( $i, 'array' )) {
							
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionDetailId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsDelete ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isActive' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsActive ( $i, 'array' )) {
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionDetailId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsActive ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isApproved' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsApproved ( $i, 'array' )) {
							
							$sqlLooping .= "
							WHEN '" . $this->model->getReligionDetailId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsApproved ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isReview' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsReview ( $i, 'array' )) {
							
							$sqlLooping .= "
                            WHEN '" . $this->model->getReligionDetailId ( $i, 'array' ) . "'
                            THEN '" . $this->model->getIsReview ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isPost' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsPost ( $i, 'array' )) {
							
							$sqlLooping .= "
                                WHEN '" . $this->model->getReligionDetailId ( $i, 'array' ) . "'
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
			WHERE `" . $this->model->getPrimaryKeyName () . "` IN (" . $this->model->getReligionDetailIdAll () . ")";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql .= "
			WHERE [" . $this->model->getPrimaryKeyName () . "] IN (" . $this->model->getReligionDetailIdAll () . ")";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql .= "
			WHERE " . strtoupper ( $this->model->getPrimaryKeyName () ) . "' IN (" . $this->model->getReligionDetailIdAll () . ")";
		}
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => TRUE, "message" => "Deleted" ) );
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
			SELECT	`religionDetail`
			FROM 	`religionDetail`
			WHERE 	`religionDetailDesc` 	= 	'" . $this->model->getReligionDetailDesc () . "'
			AND		`isActive`				=	1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	[religionDetail]
			FROM 	[religionDetail]
			WHERE 	[religionDetailDesc] 	= 	'" . $this->model->getReligionDetailDesc () . "'
			AND		[isActive]				=	1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	RELIGIONDETAIL
			FROM 	RELIGIONDETAL
			WHERE 	religionDetailDESC 	= 	'" . $this->model->getReligionDetailDesc () . "'
			AND		ISACTIVE			=	1";
		}
		$this->q->read ( $sql );
		$total = 0;
		$total = $this->q->numberRows ();
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		if ($total > 0) {
			$row = $this->q->fetchArray ();
			echo json_encode ( array ("success" => "TRUE", "total" => $total, "message" => "Duplicate Record", "religionDetailDesc" => $row ['religionDetailDesc'] ) );
			exit ();
		} else {
			echo json_encode ( array ("success" => "TRUE", "total" => $total, "message" => "Duplicate Non" ) );
			exit ();
		}
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
		$this->excel->getActiveSheet ()->getColumnDimension ( 'B' )->setAutoSize ( TRUE );
		$this->excel->getActiveSheet ()->getColumnDimension ( 'C' )->setAutoSize ( TRUE );
		$this->excel->getActiveSheet ()->setCellValue ( 'B2', $this->title );
		$this->excel->getActiveSheet ()->setCellValue ( 'C2', '' );
		$this->excel->getActiveSheet ()->mergeCells ( 'B2:C2' );
		$this->excel->getActiveSheet ()->setCellValue ( 'B3', 'No' );
		$this->excel->getActiveSheet ()->setCellValue ( 'C3', 'Penerangan' );
		$this->excel->getActiveSheet ()->getStyle ( 'B2:C2' )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$this->excel->getActiveSheet ()->getStyle ( 'B2:C2' )->getFill ()->getStartColor ()->setARGB ( '66BBFF' );
		$this->excel->getActiveSheet ()->getStyle ( 'B3:C3' )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$this->excel->getActiveSheet ()->getStyle ( 'B3:C3' )->getFill ()->getStartColor ()->setARGB ( '66BBFF' );
		//
		$loopRow = 4;
		$i = 0;
		while ( ($row = $this->q->fetchAssoc ()) == TRUE ) {
			//	echo print_r($row);
			$this->excel->getActiveSheet ()->setCellValue ( 'B' . $loopRow, ++ $i );
			$this->excel->getActiveSheet ()->setCellValue ( 'C' . $loopRow, 'a' . $row ['religionDetailDesc'] );
			$loopRow ++;
			$lastRow = 'C' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet ()->getStyle ( $formula )->applyFromArray ( $styleThinBlackBorderOutline );
		$objWriter = PHPExcel_IOFactory::createWriter ( $this->excel, 'Excel2007' );
		$filename = "religionDetail" . rand ( 0, 10000000 ) . ".xlsx";
		$path = $_SERVER ['DOCUMENT_ROOT'] . "/" . $this->application . "/basic/document/excel/" . $filename;
		$this->documentTrail->create_trail ( $this->leafId, $path, $filename );
		$objWriter->save ( $path );
		$file = fopen ( $path, 'r' );
		if ($file) {
			echo json_encode ( array ("success" => TRUE, "message" => "File generated", "filename" => $filename ) );
			exit ();
		} else {
			echo json_encode ( array ("success" => FALSE, "message" => "File not generated" ) );
			exit ();
		}
	}
}
$religionDetailObject = new ReligionDetailClass ();
/**
 * crud -create,read,update,delete
 * */
if (isset ( $_POST ['method'] )) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset ( $_POST ['leafId'] )) {
		$religionDetailObject->setLeafId ( $_POST ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_POST ['isAdmin'] )) {
		$religionDetailObject->setIsAdmin ( $_POST ['isAdmin'] );
	}
	/*
	 *  Paging
	 */
	if (isset ( $_POST ['start'] )) {
		$religionDetailObject->setStart ( $_POST ['start'] );
	}
	if (isset ( $_POST ['limit'] )) {
		$religionDetailObject->setLimit ( $_POST ['perPage'] );
	}
	/*
	 *  Filtering
	 */
	if (isset ( $_POST ['query'] )) {
		$religionDetailObject->setFieldQuery ( $_POST ['query'] );
	}
	if (isset ( $_POST ['filter'] )) {
		$religionDetailObject->setGridQuery ( $_POST ['filter'] );
	}
	/*
	 * Ordering
	 */
	if (isset ( $_POST ['order'] )) {
		$religionDetailObject->setOrder ( $_POST ['order'] );
	}
	if (isset ( $_POST ['sortField'] )) {
		$religionDetailObject->setSortField ( $_POST ['sortField'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$religionDetailObject->execute ();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$religionDetailObject->create ();
	}
	if ($_POST ['method'] == 'save') {
		$religionDetailObject->update ();
	}
	if ($_POST ['method'] == 'read') {
		$religionDetailObject->read ();
	}
	if ($_POST ['method'] == 'delete') {
		$religionDetailObject->delete ();
	}
}
if (isset ( $_GET ['method'] )) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset ( $_GET ['leafId'] )) {
		$religionDetailObject->setLeafId ( $_GET ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_GET ['isAdmin'] )) {
		$religionDetailObject->setIsAdmin ( $_GET ['isAdmin'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$religionDetailObject->execute ();
	if (isset ( $_GET ['field'] )) {
		if ($_GET ['field'] == 'staffId') {
			$religionDetailObject->staff ();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$religionDetailObject->updateStatus ();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset ( $_GET ['religionDetailDesc'] )) {
		if (strlen ( $_GET ['religionDetailDesc'] ) > 0) {
			$religionDetailObject->duplicate ();
		}
	}
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'first') {
			$religionDetailObject->firstRecord ( 'json' );
		}
		if ($_GET ['dataNavigation'] == 'previous') {
			$religionDetailObject->previousRecord ( 'json', 0 );
		}
		if ($_GET ['dataNavigation'] == 'next') {
			$religionDetailObject->nextRecord ( 'json', 0 );
		}
		if ($_GET ['dataNavigation'] == 'last') {
			$religionDetailObject->lastRecord ( 'json' );
		}
	}
	/*
	 * Excel Reporting
	 */
	if (isset ( $_GET ['mode'] )) {
		if ($_GET ['mode'] == 'excel') {
			$religionDetailObject->excel ();
		}
	}
}
?>
