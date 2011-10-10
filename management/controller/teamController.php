<?php

session_start ();
require_once ("../../class/classAbstract.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../model/teamModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Management
 * @subpackage Crew Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class TeamClass extends ConfigClass {
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
		//audit property
		$this->audit = 0; // By Default 0 - Off  1 - On
		$this->log = 1; // By Default 0 - Off  1 - On
		

		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor ();
		$this->q->leafId = $this->getLeafId ();
		$this->q->staffId = $this->getStaffId ();
		$this->q->fieldQuery = $this->getFieldQuery ();
		$this->q->gridQuery = $this->getGridQuery ();
		$this->q->log = $this->log;
		$this->q->audit = $this->log;
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );
		
		$this->model = new TeamModel ();
		$this->model->setVendor ( $this->getVendor () );
		$this->model->execute ();
		
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
			INSERT INTO `team`
					(
						`teamSequence`,				`teamCode`,
						`teamNote`,					`isDefault`,
						`isNew`,					`isDraft`,
						`isUpdate`,					`isDelete`,
						`isActive`,					`isApproved`,
						`isReview`,					`isPost`,
						`executeBy`,				`executeTime`
					)
			VALUES
					(
						'" . $this->model->getTeamSequence () . "',					'" . $this->model->getTeamCode () . "',
						'" . $this->model->getTeamNote () . "',						'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',					'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',				'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',				'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',								" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			INSERT INTO [team]
					(
						[teamSequence],				[teamCode],
						[teamNote],					[isDefault],
						[isNew],							[isDraft],
						[isUpdate],							[isDelete],
						[isActive],							[isApproved],
						
						[executeBy],								[executeTime]
					)
			VALUES
					(
						'" . $this->model->getTeamSequence () . "',			'" . $this->model->getTeamCode () . "',
						'" . $this->model->getTeamNote () . "',				'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',		'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',		'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',		'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',				" . $this->model->getExecuteTime () . "
					);";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			INSERT INTO TEAM
					(
						GROUPSEQUENCE,				GROUPCODE,
						GROUPNOTE,					ISDEFAULT,
						ISNEW,							ISDRAFT,
						ISUPDATE,						ISDELETE,
						ISACTIVE,						ISAPPROVED,
						EXECUTEBY,								EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getTeamSequence () . "',			'" . $this->model->getTeamCode () . "',
						'" . $this->model->getTeamNote () . "',				'" . $this->model->getIsDefault ( 0, 'single' ) . "',
						'" . $this->model->getIsNew ( 0, 'single' ) . "',		'" . $this->model->getIsDraft ( 0, 'single' ) . "',
						'" . $this->model->getIsUpdate ( 0, 'single' ) . "',		'" . $this->model->getIsDelete ( 0, 'single' ) . "',
						'" . $this->model->getIsActive ( 0, 'single' ) . "',		'" . $this->model->getIsApproved ( 0, 'single' ) . "',
						'" . $this->model->getExecuteBy () . "',				" . $this->model->getExecuteTime () . "
					);";
		}
		$this->q->create ( $sql );
		// take from last insert id
		$lastInsertId = $this->q->lastInsertId ();
		// loop the tab and create new record
		//** no need to log in db
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
		SELECT 	*
		FROM 	`module`
		WHERE 	`isActive`=1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		SELECT 	*
		FROM 	[module]
		WHERE 	[isActive]=1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		SELECT 	*
		FROM 	MODULE
		WHERE 	ISACTIVE=1";
		}
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$data = $this->q->activeRecord ();
		$sqlLooping = null;
		if ($this->q->numberRows () > 0) {
			foreach ( $data as $row ) {
				if ($this->getVendor () == self::MYSQL) {
					$sqlLooping .= "
					(
									'" . $row ['tabId'] . "',
									0,
									'" . $lastInsertId . "'
					),";
				} else if ($this->getVendor () == self::MSSQL || $this->getVendor () == self::ORACLE) {
					$sqlLooping .= "
					(
									'" . $row ['tabId'] . "',
									0,
									'" . $lastInsertId . "'
					),";
				}
			}
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "	INSERT INTO	`moduleAccess`
				(
									`moduleId`,
									`moduleAccessValue`,
									`teamId`
				)
				VALUES ";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "	INSERT INTO	[moduleAccess]
				(
									[moduleId],
									[moduleAccessValue],
									[teamId]
				)
				VALUES ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "	INSERT INTO	TABACCESS
				(
									MODULEID,
									MODULEACCESSVALUE,
									TEAMID
				)
				VALUES ";
		}
		$sqlLooping .= substr ( $sqlLooping, 0, - 1 );
		$sql .= $sqlLooping;
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		// loop the folder and create new record;
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
		SELECT 	*
		FROM 	`folder`
		WHERE 	`isActive`=1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		SELECT 	*
		FROM 	[folder]
		WHERE 	[isActive]=1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		SELECT 	*
		FROM 	FOLDER
		WHERE 	ISACTIVE=1";
		}
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$sqlLooping = null;
		if ($this->q->numberRows () > 0) {
			$data = $this->q->activeRecord ();
			foreach ( $data as $row ) {
				if ($this->getVendor () == self::MYSQL) {
					$sqlLooping .= "
					(
						'" . $row ['folderId'] . "',
						0,
						'" . $lastInsertId . "'
					),";
				} else if ($this->getVendor () == self::MSSQL || $this->getVendor () == self::ORACLE) {
					$sqlLooping .= "
					(
						'" . $row ['folderId'] . "',
						0,
						'" . $lastInsertId . "'
					),";
				}
			}
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
					INSERT INTO 	`folderAccess`
								(
									`folderId`,
									`folderAccessValue`,
									`teamId`
								)
					VALUES";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
					INSERT INTO 	[folderAccess]
								(
									[folderId],
									[folderAccessValue],
									[teamId]
								)
					";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					INSERT INTO 	FOLDERACCESS
								(
									FOLDERID,
									FOLDERACCESSVALUE,
									TEAMID
								)
					VALUES ";
		}
		$sqlLooping .= substr ( $sqlLooping, 0, - 1 );
		$sql .= $sqlLooping;
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		// create a template access which user can access to
		if ($this->getVendor () == self::MYSQL) {
			$sql = "SELECT * FROM `leaf` WHERE `isActive`=1  ";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "SELECT * FROM [leaf] WHERE [isActive]=1  ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "SELECT * FROM LEAF WHERE ISACTIVE=1  ";
		}
		$this->q->read ( $sql );
		$sqlLooping = null;
		$total = $this->q->numberRows ();
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		if ($total > 0) {
			$data = $this->q->activeRecord ();
			foreach ( $data as $row ) {
				if ($this->getVendor () == self::MYSQL) {
					$sqlLooping .= "
					(
						'" . $row ['leafId'] . "',
						0,
						0,
						0,
						0,
						0,
						0,
						'" . $lastInsertId . "'
					),";
				} else if ($this->getVendor () == self::MSSQL || $this->getVendor () = self::ORACLE) {
					$sqlLooping .= "
					(
						'" . $row ['leafId'] . "',
						0,
						0,
						0,
						0,
						0,
						0,
						'" . $lastInsertId . "'
					),";
				}
			}
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
					INSERT INTO 	`leafCrewAccess`
								(
									`leafId`,
									`leafAccessReadValue`,
									`leafAccessCreateValue`,
									`leafAccessUpdateValue`,
									`leafAccessDeleteValue`,
									`leafAccessPrintValue`,
									`leafAccessPostValue`,
									`teamId`
								)
					VALUES";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
					INSERT INTO 	[leafCrewAccess]
								(	[leafId],
									[leafAccessReadValue],
									[leafAccessCreateValue],
									[leafAccessUpdateValue],
									[leafAccessDeleteValue],
									[leafAccessPrintValue],
									[leafAccessPostValue],
									[teamId]
								)
					VALUES";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					INSERT INTO 	LEAFGROUPACCESS
								(
									LEAFID,
									leafAccessReadValue,
									leafAccessCreateValue,
									leafAccessUpdateValue,
									leafAccessDeleteValue,
									leafAccessPrintValue,
									leafAccessPostValue,
									TEAMID
								)
					VALUES ";
		}
		$sqlLooping .= substr ( $sqlLooping, 0, - 1 );
		$sql .= $sqlLooping;
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => "TRUE", "message" => "Record Created" ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->isAdmin == 0) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	`team`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[team].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	TEAM.ISACTIVE	=	1	";
			}
		} else if ($this->isAdmin == 1) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	 1 = 1 ";
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
					SELECT	`team`.`teamId`,
							`team`.`teamSequence`,
							`team`.`teamCode`,
							`team`.`teamNote`,
							`team`.`isDefault`,
							`team`.`isNew`,
							`team`.`isDraft`,
							`team`.`isUpdate`,
							`team`.`isDelete`,
							`team`.`isActive`,
							`team`.`isApproved`,
							`team`.`executeBy`,
							`team`.`executeTime`,
							`staff`.`staffName`
 					FROM 	`team`
					JOIN	`staff`
					ON		`team`.`executeBy` = `staff`.`staffId`
					WHERE 	" . $this->auditFilter;
			if ($this->model->getTeamId ( 0, 'single' )) {
				$sql .= " AND `" . $this->model->getTableName () . "`." . $this->model->getPrimaryKeyName () . "`='" . $this->model->getTeamId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
					SELECT	[team].[teamId],
							[team].[teamSequence],
							[team].[teamCode],
							[team].[teamNote],
							[team].[isDefault],
							[team].[isNew],
							[team].[isDraft],
							[team].[isUpdate],
							[team].[isDelete],
							[team].[isActive],
							[team].[isApproved],
							[team].[executeBy],
							[team].[executeTime],
							[staff].[staffName]
					FROM 	[team]
					JOIN	[staff]
					ON		[team].[executeBy] = [staff].[staffId]
					WHERE 	[team].[isActive] ='1'	";
			if ($this->model->getTeamId ( 0, 'single' )) {
				$sql .= " AND [" . $this->model->getTableName () . "].[" . $this->model->getPrimaryKeyName () . "]='" . $this->model->getTeamId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
					SELECT	TEAM.TEAMID  		AS	\"teamId\",
							TEAM.GROUPCODE 		AS 	\"teamCode\",
							TEAM.GROUPSEQUENCE	AS 	\"teamSequence\",
							TEAM.GROUPNOTE 		AS 	\"teamNote\",
							TEAM.ISDEFAULT 		AS 	\"isDefault\",
							TEAM.ISNEW 			AS 	\"isNew\",
							TEAM.ISDRAFT 			AS 	\"isDraft\",
							TEAM.ISUPDATE 		AS 	\"isUpdate\",
							TEAM.ISDELETE 		AS 	\"isDelete\",
							TEAM.ISACTIVE 		AS 	\"isActive\",
							TEAM.ISAPPROVED 		AS 	\"isApproved\",
							TEAM.EXECUTEBY 		AS 	\"executeBy\",
							TEAM.EXECUTETIME 		AS 	\"executeTime\",
							STAFF.STAFFNAME 		AS 	\"staffName\"
					FROM 	TEAM
					JOIN	STAFF
					ON		TEAM.EXECUTEBY = STAFF.STAFFID
					WHERE 	ISACTIVE='1'	";
			if ($this->model->getTeamId ( 0, 'single' )) {
				$sql .= " AND '" . strtoupper ( $this->model->getTableName () ) . "'.'" . strtoupper ( $this->model->getPrimaryKeyName () ) . "'='" . $this->model->getTeamId ( 0, 'single' ) . "'";
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
		$filterArray = array ('teamId' );
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array ('team' );
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
		if (empty ( $this->model->getTeamId ( $key, $type ) )) {
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
							WITH [teamDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [teamId]) AS 'RowNumber'
								FROM [team]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[team].[teamId],
										[team].[teamSequence],
										[team].[teamCode],
										[team].[teamNote],
										[team].[isDefault],
										[team].[isNew],
										[team].[isDraft],
										[team].[isUpdate],
										[team].[isDelete],
										[team].[isApproved],
										[team].[executeBy],
										[team].[executeTime],
										[staff].[staffName]
							FROM 		[teamDerived]
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
									SELECT TEAM.TEAMID  		AS	\"teamId\",
							TEAM.GROUPCODE 		AS 	\"teamCode\",
							TEAM.GROUPSEQUENCE	AS 	\"teamSequence\",
							TEAM.GROUPNOTE 		AS 	\"teamNote\",
							TEAM.ISDEFAULT 		AS 	\"isDefault\",
							TEAM.ISNEW 			AS 	\"isNew\",
							TEAM.ISDRAFT 			AS 	\"isDraft\",
							TEAM.ISUPDATE 		AS 	\"isUpdate\",
							TEAM.ISDELETE 		AS 	\"isDelete\",
							TEAM.ISACTIVE 		AS 	\"isActive\",
							TEAM.ISAPPROVED 		AS 	\"isApproved\",
							TEAM.EXECUTEBY 		AS 	\"executeBy\",
							TEAM.EXECUTETIME 		AS 	\"executeTime\",
							STAFF.STAFFNAME 		AS 	\"staffName\"
									FROM 	TEAM
									WHERE ISACTIVE=1  " . $tempSql . $tempSql2 . "
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
		if (! ($this->model->getTeamId ( 0, 'single' ))) {
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
		if ($this->model->getTeamId ( 0, 'single' )) {
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
			UPDATE 	`team`
			SET 	`teamSequence` =   '" . $this->model->getTeamSequence () . "',
					`teamCode`		=	'" . $this->model->getTeamCode () . "',
					`teamNote`		=	'" . $this->model->getTeamNote () . "',
					`isDefault`		=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					`isNew`			=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					`isDraft`		=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					`isUpdate`		=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					`isDelete`		=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					`isActive`		=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					`isApproved`	=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					`executeBy`		=	'" . $this->model->getExecuteBy () . "',
					`executeTime`	=	" . $this->model->getExecuteTime () . "
			WHERE 	`teamId`		=	'" . $this->model->getTeamId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			UPDATE 	[team]
			SET 	[teamSequence] =   '" . $this->model->getTeamSequence () . "',
					[teamCode]		=	'" . $this->model->getTeamCode () . "',
					[teamNote]		=	'" . $this->model->getTeamNote () . "',
					[isDefault]		=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					[isNew]			=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					[isDraft]		=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					[isUpdate]		=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					[isDelete]		=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					[isActive]		=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					[isApproved]	=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					[executeBy]		=	'" . $this->model->getExecuteBy () . "',
					[executeTime]	=	" . $this->model->getExecuteTime () . "
			WHERE 	[teamId]		=	'" . $this->model->getTeamId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			UPDATE 	TEAM
			SET 	GROUPSEQUENCE	=   '" . $this->model->getTeamSequence () . "',
					GROUPCODE		=	'" . $this->model->getTeamCode () . "',
					GROUPNOTE		=	'" . $this->model->getTeamNote () . "',
					ISACTIVE		=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					ISNEW			=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					ISDRAFT			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					ISUPDATE		=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					ISDELETE		=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					ISAPPROVED		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					EXECUTEBY		=	'" . $this->model->getExecuteBy () . "',
					EXECUTETIME		=	" . $this->model->getExecuteTime () . "
			WHERE 	TEAMID			=	'" . $this->model->getTeamCode ( 0, 'single' ) . "'";
		}
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		echo json_encode ( array ("success" => TRUE, "message" => "Record Update" ) );
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
			UPDATE 	`team`
			SET 	`isDefault`			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					`isNew`				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					`isDraft`			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					`isUpdate`			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					`isDelete`			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					`isActive`			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					`isApproved`		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					`executeBy`				=	'" . $this->model->getExecuteBy () . "',
					`executeTime`				=	" . $this->model->getExecuteTime () . "
			WHERE 	`teamId`		=	'" . $this->model->getTeamId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			UPDATE 	[team]
			SET 	[isDefault]			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					[isNew]				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					[isDraft]			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					[isUpdate]			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					[isDelete]			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					[isActive]			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					[isApproved]		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					[executeBy]			=	'" . $this->model->getExecuteBy () . "',
					[executeTime]		=	" . $this->model->getExecuteTime () . "
			WHERE 	[teamId]			=	'" . $this->model->getTeamId . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			UPDATE 	TEAM
			SET 	GROUPDESC		=	'" . $this->model->getTeamDesc ( 0, 'single' ) . "',
					ISDEFAULT		=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
					ISNEW			=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
					ISDRAFT			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
					ISUPDATE		=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					ISDELETE		=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
					ISACTIVE		=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
					ISAPPROVED		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
					EXECUTEBY		=	'" . $this->model->getExecuteBy () . "',
					EXECUTETIME		=	" . $this->model->getExecuteTime () . "
			WHERE 	TEAMID			=	'" . $this->model->getTeamId () . "'";
		}
		// advance logging future
		$this->q->tableName = $this->model->getTableName ();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName ();
		$this->q->primaryKeyValue = $this->model->getTeamId ();
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
			UPDATE  " . strtoupper ( $this->model->getTableName () ) . "
			SET    ";
		}
		//	echo "arnab[".$this->model->getTeamId(0,'array')."]";
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
				$sqlLooping .= "	" . strtoupper ( $systemCheck ) . " = CASE " . $this->model->getPrimaryKeyName () . " ";
			}
			switch ($systemCheck) {
				case 'isDefault' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDefault ( $i, 'array' )) {
							
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsDefault ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isNew' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDefault ( $i, 'array' )) {
							
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsNew ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isDraft' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDefault ( $i, 'array' )) {
							
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsDraft ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isUpdate' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDefault ( $i, 'array' )) {
							
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsUpdate ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isDelete' :
					for($i = 0; $i < $loop; $i ++) {
						$sqlLooping .= "
							WHEN '" . $this->model->getTeamId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsDelete ( $i, 'array' ) . "'";
					}
					break;
				case 'isActive' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDefault ( $i, 'array' )) {
							
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsActive ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isApproved' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDefault ( $i, 'array' )) {
							
							$sqlLooping .= "
							WHEN '" . $this->model->getTeamId ( $i, 'array' ) . "'
							THEN '" . $this->model->getIsApproved ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isReview' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDefault ( $i, 'array' )) {
							
							$sqlLooping .= "
                            WHEN '" . $this->model->getTeamId ( $i, 'array' ) . "'
                            THEN '" . $this->model->getIsReview ( $i, 'array' ) . "'";
						}
					}
					break;
				case 'isPost' :
					for($i = 0; $i < $loop; $i ++) {
						if ($this->model->getIsDefault ( $i, 'array' )) {
							
							$sqlLooping .= "
                                WHEN '" . $this->model->getTeamId ( $i, 'array' ) . "'
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
			WHERE `" . $this->model->getPrimaryKeyName () . "` IN (" . $this->model->getTeamIdAll () . ")";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql .= "
			WHERE [" . $this->model->getPrimaryKeyName () . "] IN (" . $this->model->getTeamIdAll () . ")";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName ()) . " IN (" . $this->model->getTeamIdAll () . ")";
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
			SELECT	*
			FROM 	`team`
			WHERE 	`teamCode` 	= 	'" . $this->model->getTeamCode () . "'
			AND		`isActive`		=	1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	*
			FROM 	[team]
			WHERE 	[teamCode] 	= 	'" . $this->model->getTeamCode () . "'
			AND		[isActive]		=	1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	*
			FROM 	CREW_
			WHERE 	CREWCODE 		= 	'" . $this->model->getTeamCode () . "'
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
				return $total . "|" . $row ['teamCode'];
			} else {
				echo json_encode ( array ("success" => "TRUE", "total" => $total, "message" => "Duplicate Record", "teamCode" => $row ['teamCode'] ) );
				exit ();
			}
		}
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {
	}
}
$teamObject = new TeamClass ();
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
		$teamObject->setLeafId ( $_POST ['leafId'] );
	}
	if (isset ( $_POST ['query'] )) {
		$teamObject->setFieldQuery ( $_POST ['query'] );
	}
	if (isset ( $_POST ['filter'] )) {
		$teamObject->setGridQuery ( $_POST ['filter'] );
	}
	/*
	 * Ordering
	 */
	if (isset ( $_POST ['order'] )) {
		$teamObject->setOrder ( $_POST ['order'] );
	}
	if (isset ( $_POST ['sortField'] )) {
		$teamObject->setSortField ( $_POST ['sortField'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$teamObject->execute ();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$teamObject->create ();
	}
	if ($_POST ['method'] == 'read') {
		$teamObject->read ();
	}
	if ($_POST ['method'] == 'save') {
		$teamObject->update ();
	}
	if ($_POST ['method'] == 'delete') {
		$teamObject->delete ();
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
		$teamObject->setLeafId ( $_GET ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_GET ['isAdmin'] )) {
		$teamObject->setIsAdmin ( $_GET ['isAdmin'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$teamObject->execute ();
	if (isset ( $_GET ['field'] )) {
		if ($_GET ['field'] == 'staffId') {
			$teamObject->staff ();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$teamObject->updateStatus ();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset ( $_GET ['teamCode'] )) {
		if (strlen ( $_GET ['teamCode'] ) > 0) {
			$teamObject->duplicate ();
		}
	}
	/*
	 * Excel Reporting
	 */
	if (isset ( $_GET ['mode'] )) {
		if ($_GET ['mode'] == 'excel') {
			$teamObject->excel ();
		}
	}
}
?>