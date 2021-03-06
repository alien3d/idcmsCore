<?php
session_start ();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../class/classDate.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/departmentModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Management
 * @subpackage Department Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class DepartmentClass extends ConfigClass {
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
	 * Title Of Microsoft Excel Report
	 * @var string
	 */
	public $title;
	/**
	 * Class Loader
	 */
	function execute() {
		parent::__construct ();
		//default property
		$this->audit = 0;
		$this->log = 1;

		$this->model = new DepartmentModel ();
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
			INSERT INTO `department`
					(
						`departmentSequence`,													`departmentCode`,
						`departmentEnglish`,														`isDefault`,
						`isNew`,																		`isDraft`,
						`isUpdate`,																	`isDelete`,
						`isActive`,																	`isApproved`,
						`isReview`,																	`isPost`,
						`executeBy`,																`executeTime`
					)
			VALUES
					(
						'" . $this->model->getDepartmentSequence () . "',			'" . $this->model->getDepartmentCode () . "',
						'" . $this->model->getDepartmentNote () . "',					'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',					'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',				'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',				'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getIsReview ( 0, 'single' ) . "',				'" . $this->model->getIsPost ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',							" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			INSERT INTO [department]
					(
						[departmentSequence],													[departmentCode],
						[departmentEnglish],															[isDefault],
						[isNew],																		[isDraft],
						[isUpdate],																	[isDelete],
						[isActive],																		[isApproved],
						[isReview],																	[isPost],
						[executeBy],																	[executeTime]
					)
			VALUES
					(
						'" . $this->model->getDepartmentSequence () . "',			'" . $this->model->getDepartmentSequence () . "',
						'" . $this->model->getDepartmentNote () . "',					'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',					'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',				'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',				'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getIsReview ( 0, 'single' ) . "',				'" . $this->model->getIsPost ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',							" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			INSERT INTO DEPARTMENT
					(
						DEPARTMENTSEQUENCE,												DEPARTMENTCODE,
						DEPARTMENTNOTE,														ISDEFAULT,
						ISNEW,																			ISDRAFT,
						ISUPDATE,																	ISDELETE,
						ISACTIVE,																		ISAPPROVED,
						ISREVIEW,																	ISPOST,
						EXECUTEBY,																	EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getDepartmentSequence () . "',			'" . $this->model->getDepartmentSequence () . "',
						'" . $this->model->getDepartmentNote () . "',					'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',					'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',				'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',				'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getIsReview ( 0, 'single' ) . "',				'" . $this->model->getIsPost ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',							" . $this->model->getExecuteTime () . "
					);";
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
				$this->auditFilter = "	`department`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[department].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	DEPARTMENT.ISACTIVE	=	1	";
			}
		} else if ($this->getIsAdmin() == 1) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	 1 = 1 ";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	1 = 1 ";
			} else if ($this->q->vendor == self::ORACLE) {
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
					SELECT	`department`.`departmentId`,
							`department`.`departmentSequence`,
							`department`.`departmentCode`,
							`department`.`departmentEnglish`,
							`department`.`isDefault`,
							`department`.`isNew`,
							`department`.`isDraft`,
							`department`.`isUpdate`,
							`department`.`isDelete`,
							`department`.`isActive`,
							`department`.`isApproved`,
							`department`.`isReview`,
							`department`.`isPost`,
							`department`.`executeBy`,
							`department`.`executeTime`,
							`staff`.`staffName`
 					FROM 	`department`
					JOIN	`staff`
					ON		`department`.`executeBy` = `staff`.`staffId`
					WHERE 	" . $this->auditFilter;
			if ($this->model->getDepartmentId ( 0, 'single' )) {
				$sql .= " AND `" . $this->model->getTableName () . "`.`" . $this->model->getPrimaryKeyName () . "`='" . $this->model->getDepartmentId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
					SELECT	[department].[departmentId],
							[department].[departmentSequence],
							[department].[departmentCode],
							[department].[departmentEnglish],
							[department].[isDefault],
							[department].[isNew],
							[department].[isDraft],
							[department].[isUpdate],
							[department].[isDelete],
							[department].[isActive],
							[department].[isApproved],
							[department].[isReview],
							[department].[isPost],
							[department].[executeBy],
							[department].[executeTime],
							[staff].[staffName]
					FROM 	[department]
					JOIN	[staff]
					ON		[department].[executeBy] = [staff].[staffId]
					WHERE 	" . $this->auditFilter;
			if ($this->model->getDepartmentId ( 0, 'single' )) {
				$sql .= " AND [" . $this->model->getTableName () . "].[" . $this->model->getPrimaryKeyName () . "]='" . $this->model->getDepartmentId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					SELECT	DEPARTMENT.DEPARTMENT	 			AS 	\"departmentId\",
							DEPARTMENT.DEPARTMENTCODE 			AS 	\"departmentCode\",
							DEPARTMENT.DEPARTMENTSEQUENCE 	AS 	\"departmentSequence\",
							DEPARTMENT.DEPARTMENTNOTE 			AS	\"departmentEnglish\",
							DEPARTMENT.ISDEFAULT 						AS 	\"isDefault\",
							DEPARTMENT.ISNEW 								AS 	\"isNew\",
							DEPARTMENT.ISDRAFT 							AS 	\"isDraft\",
							DEPARTMENT.ISUPDATE 						AS	\"isUpdate\",
							DEPARTMENT.ISDELETE 							AS 	\"isDelete\",
							DEPARTMENT.ISACTIVE 						AS 	\"isActive\",
							DEPARTMENT.ISAPPROVED 					AS 	\"isApproved\",
							DEPARTMENT.ISREVIEW							AS 	\"isReview\",
							DEPARTMENT.ISPOST 							AS 	\"isPost\",
							DEPARTMENT.EXECUTEBY 						AS 	\"executeBy\",
							DEPARTMENT.EXECUTETIME 					AS 	\"executeTime\",
							STAFF.STAFFNAME 								AS 	\"staffName\"
					FROM 	DEPARTMENT
					JOIN	STAFF
					ON		DEPARTMENT.EXECUTEBY = STAFF.STAFFID
					WHERE 	" . $this->auditFilter;
			if ($this->model->getDepartmentId ( 0, 'single' )) {
				$sql .= " AND " . strtoupper ( $this->model->getTableName () ) . "." . strtoupper ( $this->model->getPrimaryKeyName () ) . "='" . $this->model->getDepartmentId ( 0, 'single' ) . "'";
			}
		} else {
			echo json_encode ( array ("success" => false, "message" => $this->systemString->getNonSupportedDatabase() ) );
			exit ();
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
			$sql.=$this->q->dateFilter($this->model->getTableName(),$this->model->getFilterDate(),$this->getDateRangeStartQuery(),$this->getDateRangeEndQuery(),$this->getDateRangeTypeQuery());
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array ('departmentId' );
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array ('department' );
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
					WITH [departmentDerived] AS
					(
						SELECT *,
						ROW_NUMBER() OVER (ORDER BY [departmentId]) AS 'RowNumber'
						FROM [department]
						WHERE " . $this->auditFilter . $tempSql . $tempSql2 . "
					)
					SELECT		[department].[departmentId],
									[department].[departmentSequence],
									[department].[departmentCode],
									[department].[departmentEnglish],
									[department].[isDefault],
									[department].[isNew],
									[department].[isDraft],
									[department].[isUpdate],
									[department].[isDelete],
									[department].[isApproved],
									[department].[isReview],
									[department].[isPost],
									[department].[executeBy],
									[department].[executeTime],
									[staff].[staffName]
					FROM 		[departmentDerived]
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
									SELECT	DEPARTMENT.DEPARTMENT	 				AS 	\"departmentId\",
												DEPARTMENT.DEPARTMENTCODE 			AS 	\"departmentCode\",
												DEPARTMENT.DEPARTMENTSEQUENCE 	AS 	\"departmentSequence\",
												DEPARTMENT.DEPARTMENTNOTE 			AS	\"departmentEnglish\",
												DEPARTMENT.ISDEFAULT 						AS 	\"isDefault\",
												DEPARTMENT.ISNEW 								AS 	\"isNew\",
												DEPARTMENT.ISDRAFT 							AS 	\"isDraft\",
												DEPARTMENT.ISUPDATE 						AS	\"isUpdate\",
												DEPARTMENT.ISDELETE 							AS 	\"isDelete\",
												DEPARTMENT.ISACTIVE 						AS 	\"isActive\",
												DEPARTMENT.ISAPPROVED 					AS 	\"isApproved\",
												DEPARTMENT.ISAPPROVED 					AS 	\"isApproved\",
												DEPARTMENT.ISREVIEW							AS 	\"isReview\",
												DEPARTMENT.EXECUTEBY 						AS 	\"executeBy\",
												DEPARTMENT.EXECUTETIME 					AS 	\"executeTime\",
												STAFF.STAFFNAME 								AS 	\"staffName\"
									FROM 	DEPARTMENT
									JOIN	STAFF
									ON		DEPARTMENT.EXECUTEBY = STAFF.STAFFID
									WHERE 	" . $this->auditFilter . $tempSql . $tempSql2 . "
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
		if (! ($this->model->getDepartmentId ( 0, 'single' ))) {
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
		if ($this->model->getDepartmentId ( 0, 'single' )) {
			$end = microtime(true);
			$time = $end - $start;
			$json_encode = json_encode (
			array (	'success' => true,
					'total' => $total, 
					'message' => $this->systemString->getReadMessage(), 
					'time' => $time, 
            		'firstRecord' => $this->recordSet->firstRecord('value'), 
            		'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getDepartmentId(0, 'single')), 
            		'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getDepartmentId(0, 'single')), 
            		'lastRecord' => $this->recordSet->lastRecord('value'),
					'data' => $items, ) );
			$json_encode = str_replace ( "[", "", $json_encode );
			$json_encode = str_replace ( "]", "", $json_encode );
			echo $json_encode;
		} else {
			$end = microtime(true);
			$time = $end - $start;
			if (count ( $items ) == 0) {
				$items = '';
			}

			echo json_encode (
			array ('success' => true,
							'total' => $total, 
							'message' => $this->systemString->getReadMessage(), 
							'time'=>$time, 
            				'firstRecord' => $this->recordSet->firstRecord('value'), 
            				'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getDepartmentId(0, 'single')), 
            				'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getDepartmentId(0, 'single')), 
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
		// before updating check the id exist or not . if exist continue to update else warning the user
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
		SELECT	`" . $this->model->getPrimaryKeyName () . "`
		FROM 	`" . $this->model->getTableName () . "`
		WHERE  	`" . $this->model->getPrimaryKeyName () . "` = '" . $this->model->getDepartmentId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		SELECT	[" . $this->model->getPrimaryKeyName () . "]
		FROM 	[" . $this->model->getTableName () . "]
		WHERE  	[" . $this->model->getPrimaryKeyName () . "] = '" . $this->model->getDepartmentId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
		FROM 	" . strtoupper ( $this->model->getTableName () ) . "
		WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getDepartmentId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
		SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
		FROM 	" . strtoupper ( $this->model->getTableName () ) . "
				WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getDepartmentId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
			FROM 	" . strtoupper ( $this->model->getTableName () ) . "
			WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getDepartmentId ( 0, 'single' ) . "' ";
		}
		$result = $this->q->fast ( $sql );
		$total = $this->q->numberRows ( $result, $sql );
		if ($total == 0) {
			echo json_encode ( array ("success" => false, "message" => $this->systemString->getRecordNotFoundMessage() ) );
			exit ();
		} else {
			if ($this->getVendor () == self::MYSQL) {
				$sql = "
			UPDATE	`department`
			SET			`departmentSequence`		=	'" . $this->model->getDepartmentSequence () . "',
							`departmentCode`			=	'" . $this->model->getDepartmentCode () . "',
							`departmentEnglish` 			= 	'" . $this->model->getDepartmentNote () . "',
							`isDefault`						=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							`isActive`							=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							`isNew`							=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							`isDraft`							=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							`isUpdate`						=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							`isDelete`							=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							`isApproved`					=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							`isReview`						=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							`isPost`							=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							`executeBy`						=	'" . $this->model->getExecuteBy () . "',
							`executeTime`					=	" . $this->model->getExecuteTime () . "
			WHERE 		`departmentId`					=	'" . $this->model->getDepartmentId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql = "
			UPDATE	[department]
			SET 			[departmentSequence]		=	'" . $this->model->getDepartmentSequence () . "',
							[departmentCode]				=	'" . $this->model->getDepartmentCode () . "',
							[departmentEnglish] 				= 	'" . $this->model->getDepartmentNote () . "',
							[isDefault]							=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							[isActive]							=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							[isNew]								=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							[isDraft]							=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							[isUpdate]							=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							[isDelete]							=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							[isApproved]						=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							[isReview]							=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							[isPost]								=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							[executeBy]						=	'" . $this->model->getExecuteBy () . "',
							[executeTime]					=	" . $this->model->getExecuteTime () . "
			WHERE 		[departmentId]					=	'" . $this->model->getDepartmentId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql = "
			UPDATE 	DEPARTMENT
			SET 			DEPARTMENTSEQUENCE	=	'" . $this->model->getDepartmentSequence () . "',
							DEPARTMENTCODE		=	'" . $this->model->getDepartmentCode () . "',
							DEPARTMENTNOTE 		= 	'" . $this->model->getDepartmentNote () . "',
							ISDEFAULT					=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							ISACTIVE						=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							ISNEW							=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							ISDRAFT						=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							ISUPDATE						=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							ISDELETE						=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							ISAPPROVED					=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							ISREVIEW						=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							ISPOST							= '" . $this->model->getIsPost ( 0, 'single' ) . "',
							EXECUTEBY					=	'" . $this->model->getExecuteBy () . "',
							EXECUTETIME				=	" . $this->model->getExecuteTime () . "
			WHERE 		DEPARTMENTID				=	'" . $this->model->getDepartmentId ( 0, 'single' ) . "'";
			}
			$this->q->update ( $sql );
			if ($this->q->execute == 'fail') {
				echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
				exit ();
			}
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
		// before updating check the id exist or not . if exist continue to update else warning the user
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
		SELECT	`" . $this->model->getPrimaryKeyName () . "`
		FROM 	`" . $this->model->getTableName () . "`
		WHERE  	`" . $this->model->getPrimaryKeyName () . "` = '" . $this->model->getDepartmentId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		SELECT	[" . $this->model->getPrimaryKeyName () . "]
		FROM 	[" . $this->model->getTableName () . "]
		WHERE  	[" . $this->model->getPrimaryKeyName () . "] = '" . $this->model->getDepartmentId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
		FROM 	" . strtoupper ( $this->model->getTableName () ) . "
		WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getDepartmentId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
		SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
		FROM 	" . strtoupper ( $this->model->getTableName () ) . "
				WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getDepartmentId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
			FROM 	" . strtoupper ( $this->model->getTableName () ) . "
			WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getDepartmentId ( 0, 'single' ) . "' ";
		}
		$result = $this->q->fast ( $sql );
		$total = $this->q->numberRows ( $result, $sql );
		if ($total == 0) {
			echo json_encode ( array ("success" => false, "message" => $this->systemString->getRecordNotFoundMessage() ) );
			exit ();
		} else {
			if ($this->getVendor () == self::MYSQL) {
				$sql = "
			UPDATE 	`department`
			SET 			`isDefault`			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							`isActive`				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							`isNew`				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							`isDraft`				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							`isUpdate`			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							`isDelete`				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							`isApproved`		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							`isReview`			=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							`isPost`				=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							`executeBy`			=	'" . $this->model->getBy ( 0, 'single' ) . "',
							`executeTime		=	" . $this->model->getExecuteTime () . "
			WHERE 		`departmentId`		=	'" . $this->model->getDepartrmentId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql = "
			UPDATE 	[department]
			SET 			[isDefault]				=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							[isActive]				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							[isNew]					=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							[isDraft]				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							[isUpdate]				=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							[isDelete]				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							[isApproved]			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							[isApproved]			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							[isReview]				=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							[isPost]					=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							[executeBy]			=	'" . $this->model->getExecuteBy () . "',
							[executeTime]		=	" . $this->model->getExecuteTime () . "
			WHERE 		[departmentId]		=	'" . $this->model->getDepartmentId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql = "
			UPDATE 	DEPARTMENT
			SET 			ISDEFAULT			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							ISACTIVE				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							ISNEW					=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							ISDRAFT				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							ISUPDATE				=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							ISDELETE				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							ISAPPROVED			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							ISREVIEW				=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							ISPOST					= 	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							EXECUTEBY			=	'" . $this->model->getExecuteBy () . "',
							EXECUTETIME		=	" . $this->model->getExecuteTime () . "
			WHERE 		DEPARTMENTID		=	'" . $this->model->getdepartmentId ( 0, 'single' ) . "'";
			}
			$this->q->update ( $sql );
			if ($this->q->execute == 'fail') {
				echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
				exit ();
			}
		}
		$this->q->commit ();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode (
		array ("success" => true,
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
							WHEN '" . $this->model->getDepartmentId($i, 'array') . "'
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
							WHEN '" . $this->model->getDepartmentId($i, 'array') . "'
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
							WHEN '" . $this->model->getDepartmentId($i, 'array') . "'
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
							WHEN '" . $this->model->getDepartmentId($i, 'array') . "'
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
							WHEN '" . $this->model->getDepartmentId($i, 'array') . "'
							THEN '" . $this->model->getIsDelete($i, 'array') . "'";
							$sqlLooping .= " END,";
							if(!$this->getIsAdmin()){
								foreach ($accessClear as $clear){
									// update delete status = 1
									if ($this->getVendor() == self::MYSQL) {
										$sqlLooping .= " `" . $clear . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
									} else if ($this->getVendor() == self::MSSQL) {
										$sqlLooping .= "  [" . $clear. "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
									} else if ($this->getVendor() == self::ORACLE) {
										$sqlLooping .= "	" . $clear . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
									} else if ($this->getVendor() == self::DB2) {
										$sqlLooping .= "	" . $clear . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
									} else if ($this->getVendor() == self::POSTGRESS) {
										$sqlLooping .= "	" .$clear . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
									} else {
										echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
										exit();
									}
									$sqlLooping .= "
							WHEN '" . $this->model->getDepartmentId($i, 'array') . "'
							THEN '0'";
									$sqlLooping .= " END,";
								}
									
							}
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
							WHEN '" . $this->model->getDepartmentId($i, 'array') . "'
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
							WHEN '" . $this->model->getDepartmentId($i, 'array') . "'
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
                            WHEN '" . $this->model->getDepartmentId($i, 'array') . "'
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
                                WHEN '" . $this->model->getDepartmentId($i, 'array') . "'
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
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->start();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT	*
			FROM 	`department`
			WHERE 	`departmentCode` 	= 	'" . $this->model->getDepartmentCode () . "'
			AND		`isActive`			=	1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	*
			FROM 	[department]
			WHERE 	[departmentCode] 	= 	'" . $this->model->getDepartmentCode () . "'
			AND		[isActive]			=	1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	*
			FROM 	DEPARTMENT
			WHERE 	DEPARTMENTCODE 	= 	'" . $this->model->getDepartmentCode () . "'
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
			SELECT	*
			FROM 	DEPARTMENT
			WHERE 	DEPARTMENTCODE 	= 	'" . $this->model->getDepartmentCode () . "'
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT	*
			FROM 	DEPARTMENT
			WHERE 	DEPARTMENTCODE 	= 	'" . $this->model->getDepartmentCode () . "'
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
				return $total . "|" . $row ['departmentCode'];
			} else {
				$end = microtime(true);
				$time = $end - $start;
				echo json_encode (
				array (	"success" => true,
							"total" => $total, 
							"message" => $this->systemString->getDuplicateMessage(), 
							"departmentCode" => $row ['departmentCode'],
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
			$this->excel->getActiveSheet ()->setCellValue ( 'C3', 'Department Id' );
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
			if ($this->getIsAdmin() == 1) {
				$this->excel->getActiveSheet ()->setCellValue ( 'C' . $loopRow, $row ['departmentId'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'D' . $loopRow, $row ['departmentSequence'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'E' . $loopRow, $row ['departmentCode'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'F' . $loopRow, $row ['departmentEnglish'] );
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
				$this->excel->getActiveSheet ()->setCellValue ( 'C' . $loopRow, $row ['departmentSequence'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'D' . $loopRow, $row ['departmentCode'] );
				$this->excel->getActiveSheet ()->setCellValue ( 'E' . $loopRow, $row ['departmentEnglish'] );
			}
			$loopRow ++;
		}
		$lastRow = $end . $loopRow;
		$from = $start . '2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet ()->getStyle ( $formula )->applyFromArray ( $styleThinBlackBorderOutline );
		$objWriter = PHPExcel_IOFactory::createWriter ( $this->excel, 'Excel2007' );
		$filename = "department" . rand ( 0, 10000000 ) . ".xlsx";
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
$departmentObject = new DepartmentClass ();
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
	if (isset($_POST ['leafId'])) {
		$departmentObject->setLeafId($_POST ['leafId']);
	}
	/*
	 *  Admin Only
	 */
	if (isset($_POST ['isAdmin'])) {
		$departmentObject->setIsAdmin($_POST ['isAdmin']);
	}
	/**
	 * Database Request
	 */
	if (isset($_POST ['databaseRequest'])) {
		$departmentObject->setDatabaseRequest($_POST ['databaseRequest']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$departmentObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$departmentObject->setLimit($_POST ['perPage']);
	}
	/*
	 * Filtering
	 */
	if (isset($_POST ['query'])) {
		$departmentObject->setFieldQuery($_POST ['query']);
	}
	if (isset($_POST ['filter'])) {
		$departmentObject->setGridQuery($_POST ['filter']);
	}
	if (isset($_POST ['character'])) {
		$departmentObject->setCharacterQuery($_POST['character']);
	}
	if (isset($_POST ['dateRangeStart'])) {
		$departmentObject->setDateRangeStartQuery($_POST['dateRangeStart']);
	}
	if (isset($_POST ['dateRangeEnd'])) {
		$departmentObject->setDateRangeEndQuery($_POST['dateRangeEnd']);
	}
	if (isset($_POST ['dateRangeType'])) {
		$departmentObject->setDateRangeTypeQuery($_POST['dateRangeType']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST ['order'])) {
		$departmentObject->setOrder($_POST ['order']);
	}
	if (isset($_POST ['sortField'])) {
		$departmentObject->setSortField($_POST ['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$departmentObject->execute ();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$departmentObject->create ();
	}
	if ($_POST ['method'] == 'read') {
		$departmentObject->read ();
	}
	if ($_POST ['method'] == 'save') {
		$departmentObject->update ();
	}
	if ($_POST ['method'] == 'delete') {
		$departmentObject->delete ();
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
		$departmentObject->setLeafId ( $_GET ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_GET ['isAdmin'] )) {
		$departmentObject->setIsAdmin ( $_GET ['isAdmin'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$departmentObject->execute ();
	if (isset ( $_GET ['field'] )) {
		if ($_GET ['field'] == 'staffId') {
			$departmentObject->staff ();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$departmentObject->updateStatus ();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset ( $_GET ['departmentCode'] )) {
		if (strlen ( $_GET ['departmentCode'] ) > 0) {
			$departmentObject->duplicate ();
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$departmentObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$departmentObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$departmentObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$departmentObject->lastRecord('json');
		}
	}
	/*
	 *  Excel Reporing
	 */
	if (isset ( $_GET ['mode'] )) {
		if ($_GET ['mode'] == 'excel') {
			$departmentObject->excel ();
		}
	}
}
?>
