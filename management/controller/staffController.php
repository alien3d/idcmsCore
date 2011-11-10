<?php
session_start ();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSecurity.php");
require_once ("../model/staffModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Management
 * @subpackage Staff Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class StaffClass extends ConfigClass {
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
	 * Record Pagination
	 * @var string
	 */
	private $recordSet;
	/**
	 * Document Trail Audit.
	 * @var string $documentTrail;
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
	 * model
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
	 * Title Of Microsoft Excel Report
	 * @var string
	 */
	private $title;
	/**
	 * Security Object
	 * @var stri	 g
	 */
	private $security;
	/**
	 * Class Loader
	 */
	public function execute() {
		parent::__construct ();
		//audit property
		$this->audit = 0;
		$this->log = 0;

		$this->model = new StaffModel ();
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

		$this->recordSet = new RecordSet ();
		$this->recordSet->setTableName ( $this->model->getTableName () );
		$this->recordSet->setPrimaryKeyName ( $this->model->getPrimaryKeyName () );
		$this->recordSet->execute ();

		$this->documentTrail = new DocumentTrailClass ();
		$this->documentTrail->setVendor ( $this->getVendor () );
		$this->documentTrail->setStaffId ( $this->getStaffId () );
		$this->documentTrail->setLanguageId ( $this->getLanguageId () );

		$this->security = new Security ();
		$this->security->setVendor ( $this->getVendor () );
		$this->security->setStaffId ( $this->getStaffId () );
		$this->security->setLanguageId ( $this->getLanguageId () );
		$this->security->execute ();

		$this->excel = new PHPExcel ();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create() {
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
			INSERT INTO `staff` 	(
						`staffName`,														`staffNo`,
						`staffPassword`,												`staffIc`,
						`teamId`,															`departmentId`,
						`isDefault`,														`isNew`,
						`isDraft`,															`isUpdate`,
						`isDelete`,														`isActive`,
						`isApproved`,													`isReview`,
						`isPost`,															`executeBy`,
						`executeTime`

				)  VALUES	(
					'" . $this->model->getStaffName () . "',						'" . $this->model->getStaffNo () . "',
					'" . md5 ( $this->model->getStaffPassword () ) . "',		'" . $this->model->getStaffIc () . "',
					'" . $this->model->getTeamId () . "',							'" . $this->model->getDepartmentId () . "',
					'" . $this->model->getIsDefault ( 0, 'single' ) . "',			'" . $this->model->getIsNew ( 0, 'single' ) . "',
					'" . $this->model->getIsDraft ( 0, 'single' ) . "',				'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					'" . $this->model->getIsDelete ( 0, 'single' ) . "',			'" . $this->model->getIsActive ( 0, 'single' ) . "',
					'" . $this->model->getIsApproved ( 0, 'single' ) . "',		'" . $this->model->getIsReview ( 0, 'single' ) . "',
					'" . $this->model->getIsPost ( 0, 'single' ) . "',				'" . $this->model->getExecuteBy () . "',
					" . $this->model->getExecuteTime () . "
				);";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
				INSERT INTO [staff] 	(
							[staffName],														[staffNo],
							[staffPassword],													[staffIc],
							[teamId],															[departmentId],
							[isDefault],														[isNew],
							[isDraft],															[isUpdate],
							[sDelete],															[isActive],
							[isApproved],													[isReview],
							[isPost],															[executeBy],
							[executeTime]
				)  VALUES	(
					'" . $this->model->getStaffName () . "',						'" . $this->model->getStaffNo () . "',
					'" . md5 ( $this->model->getStaffPassword () ) . "',		'" . $this->model->getStaffIc () . "',
					'" . $this->model->getTeamId () . "',							'" . $this->model->getDepartmentId () . "',
					'" . $this->model->getIsDefault ( 0, 'single' ) . "',			'" . $this->model->getIsNew ( 0, 'single' ) . "',
					'" . $this->model->getIsDraft ( 0, 'single' ) . "',				'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					'" . $this->model->getIsDelete ( 0, 'single' ) . "',			'" . $this->model->getIsActive ( 0, 'single' ) . "',
					'" . $this->model->getIsApproved ( 0, 'single' ) . "',		'" . $this->model->getExecuteBy () . "',
					" . $this->model->getExecuteTime () . "
				);";
		} else if ($this->q->vendor == self::ORACLE) {
			$sql = "
				INSERT INTO STAFF 	(
							STAFFNAME,														STAFFNO,
							STAFFPASSWORD,												STAFFIC,
							TEAMID,															DEPARTMENTID
							ISDEFAULT,														ISNEW,																			
							ISDRAFT,															ISUPDATE,																	
							ISDELETE,															ISACTIVE,																		
							ISAPPROVED,													ISREVIEW,																	
							ISPOST,															EXECUTEBY,
							EXECUTETIME
				)  VALUES	(
					'" . $this->model->getStaffName () . "',						'" . $this->model->getStaffNo () . "',
					'" . md5 ( $this->model->getStaffPassword () ) . "',		'" . $this->model->getStaffIc () . "',
					'" . $this->model->getTeamId () . "',							'" . $this->model->getDepartmentId () . "',
					'" . $this->model->getIsDefault ( 0, 'single' ) . "',			'" . $this->model->getIsNew ( 0, 'single' ) . "',
					'" . $this->model->getIsDraft ( 0, 'single' ) . "',				'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					'" . $this->model->getIsDelete ( 0, 'single' ) . "',			'" . $this->model->getIsActive ( 0, 'single' ) . "',
					'" . $this->model->getIsApproved ( 0, 'single' ) . "',		'" . $this->model->getExecuteBy () . "',
					" . $this->model->getExecuteTime () . "	
				);";
		}
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$lastInsertId = $this->q->lastInsertId ();
		// insert module access
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
				SELECT	`moduleId`
				FROM 	`module`
				WHERE 	`isActive`	=	1	";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
				SELECT	[moduleId]
				FROM 	[module]
				WHERE 	[isActive]	=	1	";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
				SELECT	MODULEID  AS \"moduleId\"
				FROM 	MODULE
				WHERE 	ISACTIVE	=	1	";
		}
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		if ($this->q->numberRows () > 0) {
			$data = $this->q->activeRecord ();
			foreach ( $data as $rowModule ) {
				// check if group access define in  moduleAccess else insert
				if ($this->getVendor () == self::MYSQL) {
					$sql = "
						SELECT *
						FROM 	`moduleAccess`
						WHERE 	`teamId`			=	'" . $this->model->getTeamId () . "'
						AND		`moduleId`		=	'" . $rowModule ['moduleId'] . "'";
				} else if ($this->getVendor () == self::MSSQL) {
					$sql = "
					SELECT 	*
					FROM 		[moduleAccess]
					WHERE 		[teamId]			=	'" . $this->model->getTeamId () . "'
					AND			[moduleId]		=	'" . $rowModule ['moduleId'] . "'";
				} else if ($this->getVendor () == self::ORACLE) {
					$sql = "
					SELECT *
					FROM 	MODULEACCESS
					WHERE 	TEAMID					=	'" . $this->model->getTeamId () . "'
					AND		MODULEID			=	'" . $rowModule ['moduleId'] . "'";
				}
				$this->q->read ( $sql );
				if ($this->q->execute == 'fail') {
					echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
					exit ();
				}
				if ($this->q->numberRows () == 0) {
					// record don't exist create new
					if ($this->q->vendor == self::MYSQL) {
						$sql = "
						INSERT INTO `moduleAccess`	
						(
							`moduleId`,				
							`teamId`,
							`moduleAccessValue`
						)	VALUES(
							'" . $rowModule ['moduleId'] . "',
							'" . $this->model->getTeamId () . "',
							0
						)	";
					} else if ($this->q->vendor == self::MSSQL) {
						$sql = "
						INSERT INTO [moduleAccess]	
						(
							[moduleId],				
							[teamId],
							[moduleAccessValue]
						)	VALUES(
							'" . $rowModule ['moduleId'] . "',
							'" . $this->model->getTeamId () . "',
							0					
						)	";
					} else if ($this->getVendor () == self::ORACLE) {
						$sql = "
						INSERT INTO MODULEACCESS	
						(
							MODULEID,				
							TEAMID,
							MODULEACCESSVALUE
						)	VALUES(
							'" . $rowModule ['moduleId'] . "',
							'" . $this->model->getTeamId () . "',
							0
						)	";
					}
					$this->q->create ( $sql );
					if ($this->q->execute == 'fail') {
						echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
						exit ();
					}
				}
			}
		}
		// insert folder access
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
				SELECT	*
				FROM 	`folder`
				WHERE 	`isActive`=1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
				SELECT	*
				FROM 	[folder]
				WHERE 	[isActive]=1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
				SELECT	*
				FROM 	FOLDER
				WHERE 	ISACTIVE=1";
		}
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		if ($this->q->numberRows () > 0) {
			$data = $this->q->activeRecord ();
			foreach ( $data as $rowFolder ) {
				// check if group access define in  moduleAccess else insert
				if ($this->getVendor () == self::MYSQL) {
					$sql = "
					SELECT *
					FROM 	`folderAccess`
					WHERE 	`teamId`		=	'" . $this->model->getTeamId () . "'
					AND		`folderId`		=	'" . $rowFolder ['folderId'] . "'";
				} else if ($this->getVendor () == self::MSSQL) {
					$sql = "
					SELECT *
					FROM 	[folderAccess]
					WHERE 	[teamId]		=	'" . $this->model->getTeamId () . "'
					AND		[folderId]		=	'" . $rowFolder ['folderId'] . "'";
				} else if ($this->getVendor () == self::ORACLE) {
					$sql = "
					SELECT *
					FROM 	FOLDERACCESS
					WHERE 	TEAMID			=	'" . $this->model->getTeamId () . "'
					AND		FOLDERID		=	'" . $rowFolder ['folderId'] . "'";
				}
				$this->q->read ( $sql );
				if ($this->q->execute == 'fail') {
					echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
					exit ();
				}
				if ($this->q->numberRows () > 0) {
					// record exist do nothing
				} else {
					// record don't exist create new
					if ($this->getVendor () == self::MYSQL) {
						$sql = "
					INSERT INTO `folderAccess`
						(
								`folderId`,
								`teamId`,
								`folderAccessValue`
						)
					VALUES(
								'" . $rowFolder ['folderId'] . "',
								'" . $this->model->getTeamId () . "',
								0
					)	";
					} else if ($this->getVendor () == self::MSSQL) {
						$sql = "
					INSERT INTO [folderAccess`
						(
								[folderId],
								[teamId],
								[folderAccessValue]
						)
					VALUES(
								'" . $rowFolder ['folderId'] . "',
								'" . $this->model->getTeamId () . "',
								0
					)	";
					} else if ($this->getVendor () == self::ORACLE) {
						$sql = "
					INSERT INTO FOLDERACCESS
						(
								FOLDERID,
								TEAMID,
								FOLDERACCESSVALUE
						)
					VALUES(
								'" . $rowFolder ['folderId'] . "',
								'" . $this->model->getTeamId () . "',
								0
					)	";
					}
					$this->q->create ( $sql );
					if ($this->q->execute == 'fail') {
						echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
						exit ();
					}
				}
			}
		}
		// insert leaf access according to the group choosen
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT	*
			FROM 	`leafTeamAccess`
			WHERE 	`teamId`='" . $this->model->getTeamId () . "' ";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	*
			FROM 	[leafTeamAccess]
			WHERE 	[teamId]	=	'" . $this->model->getTeamId () . "' ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	*
			FROM 	LEAFTEAMACCESS
			WHERE 	TEAMID		=	'" . $this->model->getTeamId () . "' ";
		}
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		if ($this->q->numberRows () > 0) {
			$data = $this->q->activeRecord ();
			foreach ( $data as $rowLeafGroupAccess ) {
				if ($this->getVendor () == self::MYSQL) {
					$sql = "
				INSERT INTO	`leafAccess`
					(
							`leafId`,
							`staffId`,
							`leafAccessCreateValue`,
							`leafAccessReadValue`,
							`leafAccessUpdateValue`,
							`leafAccessDeleteValue`,
							`leafAccessPrintValue`,
							`leafAccessPostValue`
					)
				VALUES
					(
							'" . $rowLeafGroupAccess ['leafId'] . "',
							'" . $lastInsertId . "',
							'" . $rowLeafGroupAccess ['leafAccessCreateValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessReadValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessUpdateValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessDeleteValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessPrintValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessPostValue'] . "'
					)	";
				} else if ($this->getVendor () == self::MSSQL) {
					$sql = "
				INSERT INTO	[leafAccess]
					(
							[leafId],
							[staffId],
							[leafAccessCreateValue],
							[leafAccessReadValue],
							[leafAccessUpdateValue],
							[leafAccessDeleteValue],
							[leafAccessPrintValue],
							[leafAccessPostValue]
					)
				VALUES
					(
							'" . $rowLeafGroupAccess ['leafId'] . "',
							'" . $lastInsertId . "',
							'" . $rowLeafGroupAccess ['leafAccessCreateValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessReadValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessUpdateValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessDeleteValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessPrintValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessPostValue'] . "'
					)	";
				} else if ($this->getVendor () == self::ORACLE) {
					$sql = "
				INSERT INTO	LEAFACCESS
					(
							LEAFID,
							STAFFID,
							LEAFACCESSCREATEVALUE,
							LEAFACCESSREADVALUE,
							LEAFACCESSUPDATEVALUE,
							LEAFACCESSDELETEVALUE,
							LEAFACCESSPRINTVALUE,
							LEAFACCESSPOSTVALUE
					)
				VALUES
					(
							'" . $rowLeafGroupAccess ['leafId'] . "',
							'" . $lastInsertId . "',
							'" . $rowLeafGroupAccess ['leafAccessCreateValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessReadValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessUpdateValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessDeleteValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessPrintValue'] . "',
							'" . $rowLeafGroupAccess ['leafAccessPostValue'] . "'
					)	";
				}
				$this->q->create ( $sql );
				if ($this->q->execute == 'fail') {
					echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
					exit ();
				}
			}
		}
		/**
		 * generate category for each staff
		 */
		for($i = 1; $i <= 10; $i ++) {
			if ($this->getVendor () == self::MYSQL) {
				$sql = "
				INSERT INTO 	`calendar`
							(
								`calendarColorId`,
								`calendarTitle`,
								`staffId`
							) VALUES	(
								'" . $i . "',
								'" . "other" . $i . "',
								'" . $lastInsertId . "'
							)";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql = "
				INSERT INTO 	[calendar]
							(
								[calendarColorId],
								[calendarTitle],
								[staffId]
							) VALUES	(
								'" . $i . "',
								'" . "other" . $i . "',
								'" . $lastInsertId . "'
							)";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql = "
				INSERT INTO 	CALENDAR
							(
								CALENDARCOLORID,
								CALENDARTITLE,
								STAFFID
							) VALUES	(
								'" . $i . "',
								'" . "other" . $i . "',
								'" . $lastInsertId . "'
							)";
			}
			$this->q->create ( $sql );
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
					 "message" => $this->system->getCreateMessage(),
					 "time"=>$time ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->isAdmin == 0) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	`staff`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[staff].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	STAFF.ISACTIVE	=	1	";
			}
		} else if ($this->isAdmin == 1) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	 1 =  1 ";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	1 = 1 ";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = " 1 = 1 ";
			}
		}

		$items = array ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT		`staff`.`staffId`,
							`staff`.`teamId`,
							`staff`.`departmentId`,
							`staff`.`languageId`,
							`staff`.`staffPassword`,
							`staff`.`staffName`,
							`staff`.`staffNo`,
							`staff`.`staffIc`,
							`staff`.`isDefault`,
							`staff`.`isNew`,
							`staff`.`isDraft`,
							`staff`.`isUpdate`,
							`staff`.`isDelete`,
							`staff`.`isActive`,
							`staff`.`isApproved`,
							`staff`.`isReview`,
							`staff`.`isPost`,
							`staff`.`executeBy`,
							`staff`.`executeTime`
			FROM 		`staff`
			JOIN		`team`
			USING		(`teamId`)
			JOIN		`department`
			USING		(`departmentId`)
			WHERE 		" . $this->auditFilter . "
			AND			`team`.`isActive`=1
			AND			`department`.`isActive`=1
			";
			if ($this->model->getStaffId ( 0, 'single' )) {
				$sql .= " AND `" . $this->model->getTableName () . "`.`" . $this->model->getPrimaryKeyName () . "`='" . $this->model->getStaffId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT		[staff].[staffId],
							[staff].[teamId],
							[staff].[departmentId],
							[staff].[languageId],
							[staff].[staffPassword],
							[staff].[staffName],
							[staff].[staffNo],
							[staff].[staffIc],
							[staff].[isDefault],
							[staff].[isNew],
							[staff].[isDraft],
							[staff].[isUpdate],
							[staff].[isDelete],
							[staff].[isActive],
							[staff].[isReview],
							[staff].[isPost],
							[staff].[isApproved],
							[staff].[executeBy],
							[staff].[executeTime],
							[staff].[staffName]
			FROM 		[staff]
			JOIN			[department]
			ON			[department].[departmentId]=[staff].[staffId]
			JOIN			[team]
			ON			[team].[teamId]=[staff].[teamId]
			WHERE 		" . $this->auditFilter . "
			AND			[team].[isActive] ='1'
			AND			[department].[isActive]='1'";
			if ($this->model->getStaffId ( 0, 'single' )) {
				$sql .= " AND [" . $this->model->getTableName () . "].[" . $this->model->getPrimaryKeyName () . "]='" . $this->model->getStaffId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT		STAFF.STAFFID 					AS 	\"staffId\",
							STAFF.TEAMID 					AS 	\"teamId\",
							STAFF.DEPARTMENTID 		AS 	\"departmentId\",
							STAFF.LANGUAGEID 			AS 	\"languageId\",
							STAFF.STAFFPASSWORD	AS 	\"staffPassword\",
							STAFF.STAFFNAME 			AS 	\"staffName\",
							STAFF.STAFFNO 				AS 	\"staffNo\",
							STAFF.STAFFIC 					AS 	\"staffIc\",
							STAFF.ISDEFAULT 				AS 	\"isDefault\",
							STAFF.ISNEW 					AS 	\"isNew\",
							STAFF.ISDRAFT 				AS 	\"isDraft\",
							STAFF.ISUPDATE 				AS 	\"isUpdate\",
							STAFF.ISDELETE 				AS 	\"isDelete\",
							STAFF.ISACTIVE 				AS 	\"isActive\",
							STAFF.ISAPPROVED 			AS 	\"isApproved\",
							STAFF.ISREVIEW 				AS 	\"isReview\",
							STAFF.ISPOST 					AS 	\"isPost\",
							STAFF.EXECUTEBY 			AS 	\"executeBy\",
							STAFF.EXECUTETIME 			AS 	\"executeTime\",
							STAFF.STAFFNAME 			AS	\"staffName\"
			FROM 		STAFF
			JOIN			TEAM
			ON			TEAM.TEAMID							=	STAFF.TEAMID
			JOIN			DEPARTMENT
			ON			DEPARTMENT.DEPARTMENTID		=	STAFF.DEPARTMENTID
			WHERE 		" . $this->auditFilter . "
			AND			TEAM.ISACTIVE 						=	'1'
			AND			DEPARTMENT.ISACTIVE				=	'1' ";
			if ($this->model->getStaffId ( 0, 'single' )) {
				$sql .= " AND " . strtoupper ( $this->model->getTableName () ) . "." . strtoupper ( $this->model->getPrimaryKeyName () ) . "='" . $this->model->getStaffId ( 0, 'single' ) . "'";
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
		$filterArray = array ('staffId' );
		/**
		 * filter modulele
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array ('staff' );
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
		"message" => $sql
		));
		exit();

		*/
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
			} else if ($this->getVendor () == self::MSSQL) {
				/**
				 * Sql Server and Oracle used row_number
				 * Parameterize Query We don't support
				 */
				$sql = "
							WITH [staffDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [staffId]) AS 'RowNumber'
								FROM [staff]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[staff].[staffId],
											[staff].[teamId],
											[staff].[departmentId],
											[staff].[languageId],
											[staff].[staffPassword],
											[staff].[staffName],
											[staff].[staffNo],
											[staff].[staffIc],
											[staff].[isDefault],
											[staff].[isNew],
											[staff].[isDraft],
											[staff].[isUpdate],
											[staff].[isDelete],
											[staff].[isActive],
											[staff].[isReview],
											[staff].[isPost],
											[staff].[isApproved],
											[staff].[executeBy],
											[staff].[executeTime]
							FROM 		[staffDerived]
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
									SELECT		STAFF.STAFFID 					AS 	\"staffId\",
													STAFF.TEAMID 					AS 	\"teamId\",
													STAFF.DEPARTMENTID 		AS 	\"departmentId\",
													STAFF.LANGUAGEID 			AS 	\"languageId\",
													STAFF.STAFFPASSWORD	AS 	\"staffPassword\",
													STAFF.STAFFNAME 			AS 	\"staffName\",
													STAFF.STAFFNO 				AS 	\"staffNo\",
													STAFF.STAFFIC 					AS 	\"staffIc\",
													STAFF.ISDEFAULT 				AS 	\"isDefault\",
													STAFF.ISNEW 					AS 	\"isNew\",
													STAFF.ISDRAFT 				AS 	\"isDraft\",
													STAFF.ISUPDATE 				AS 	\"isUpdate\",
													STAFF.ISDELETE 				AS 	\"isDelete\",
													STAFF.ISACTIVE 				AS 	\"isActive\",
													STAFF.ISAPPROVED 			AS 	\"isApproved\",
													STAFF.ISREVIEW 				AS 	\"isReview\",
													STAFF.ISPOST 					AS 	\"isPost\",
													STAFF.EXECUTEBY 			AS 	\"executeBy\",
													STAFF.EXECUTETIME 			AS 	\"executeTime\",
													STAFF.STAFFNAME 			AS	\"staffName\"
									FROM 	STAFF
									JOIN		TEAM
									ON		TEAM.TEAMID							=	STAFF.TEAMID
									JOIN		DEPARTMENT
									ON		DEPARTMENT.DEPARTMENTID		=	STAFF.DEPARTMENTID
									WHERE 	" . $this->auditFilter . "
									AND		TEAM.ISACTIVE 						=	'1'
									AND		DEPARTMENT.ISACTIVE				=	'1'  " . $tempSql . $tempSql2 . "
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
		if (! ($this->model->getStaffId ( 0, 'single' ))) {
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
		if ($this->model->getStaffId ( 0, 'single' )) {
			$end = microtime(true);
			$time = $end - $start;
			$json_encode = json_encode (
			array (	'success' => true,
						'total' => $total, 
						'time'=>$time,
						'message' => $this->system->getReadMessage(), 
						'firstRecord' => $this->recordSet->firstRecord (), 
						'nextRecord' => $this->recordSet->nextRecord ( $this->model->getStaffId( 0, 'single' ) ), 
						'previousRecord' => $this->recordSet->previousRecord ( $this->model->getStaffId( 0, 'single' ) ), 
						'lastRecord' => $this->recordSet->lastRecord (), 
						'data' => $items ) );
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
			array (	'success' => true,
						'total' => $total, 
						'message' => $this->system->getReadMessage(), 
						'time' => $time, 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getStaffId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getStaffId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value'),
						'data' => $items ) );
			exit ();
		}
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	public function update() {
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
		WHERE  	`" . $this->model->getPrimaryKeyName () . "` = '" . $this->model->getStaffId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		SELECT	[" . $this->model->getPrimaryKeyName () . "]
		FROM 	[" . $this->model->getTableName () . "]
		WHERE  	[" . $this->model->getPrimaryKeyName () . "] = '" . $this->model->getStaffId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
		FROM 	" . strtoupper ( $this->model->getTableName () ) . "
		WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getStaffId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
		SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
		FROM 	" . strtoupper ( $this->model->getTableName () ) . "
				WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getStaffId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
			FROM 	" . strtoupper ( $this->model->getTableName () ) . "
			WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getStaffId ( 0, 'single' ) . "' ";
		}
		$result = $this->q->fast ( $sql );
		$total = $this->q->numberRows ( $result, $sql );
		if ($total == 0) {
			echo json_encode ( array ("success" => false, "message" => 'Cannot find the record' ) );
			exit ();
		} else {
			//  original group
			if ($this->getVendor () == self::MYSQL) {
				$sql = "
			SELECT		`teamId`,
							`staffPassword`
			FROM 		`staff`
			WHERE 		`staffId`	=	'" . $this->model->getStaffId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql = "
			SELECT 	[teamId],
							[staffPassword]
			FROM 		[staff]
			WHERE 		[staffId]	=	'" . $this->model->getStaffId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql = "
			SELECT 	TEAMID 				AS 	\"teamId\",
							STAFFPASSWORD	AS	\"staffPassword\"
			FROM 		STAFF
			WHERE 		STAFFID	=	'" . $this->model->getStaffId ( 0, 'single' ) . "'";
			}
			$this->q->read ( $sql );
			if ($this->q->execute == 'fail') {
				$this->msg ( false, $this->q->responce );
				exit ();
			}
			$data = $this->q->fetchAssoc ();
			if ($data ['staffPassword'] == md5 ( $this->model->getStaffPassword () )) {
				$staffPassword = $data ['staffPassword'];
			} else {
				$staffPassword = $this->model->getStaffPassword ();
			}
			$teamId = $data ['teamId'];
			if ($this->getVendor () == self::MYSQL) {
				$sql = "
			UPDATE 	`staff`
			SET 			`staffIc`				=	'" . $this->model->getStaffIc () . "',
							`staffName`			=	'" . $this->model->getStaffName () . "',
							`staffNo`				=	'" . $this->model->getStaffNo () . "',
							`staffPassword`		=	'" . md5 ( $this->model->getStaffPassword () ) . "',
							`teamId`				=	'" . $this->model->getTeamId () . "',
							`departmentId`		=	'" . $this->model->getDepartmentId () . "',
							`isDefault`			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							`isNew`				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							`isDraft`				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							`isUpdate`			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							`isDelete`				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							`isActive`				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							`isApproved`		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							`isReview`			=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							`isPost`				=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							`executeBy`			=	'" . $this->model->getExecuteBy () . "',
							`executeTime		=	" . $this->model->getExecuteTime () . "
			WHERE 		`staffId`				=	'" . $this->model->getStaffId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql = "
			UPDATE	[staff]
			SET 			[staffIc]				=	'" . $this->model->getStaffIc () . "',
							[staffName]			=	'" . $this->model->getStaffName () . "',
							[staffNo]				=	'" . $this->model->getStaffNo () . "',
							[staffPassword]		=	'" . md5 ( $this->model->getStaffPassword () ) . "',
							[staffName]			=	'" . $this->model->getStaffName () . "',
							[teamId]				=	'" . $this->model->getTeamId () . "',
							[departmentId]		=	'" . $this->model->getDepartmentId () . "',
							[isDraft]				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							[isNew]					=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							[isDraft]				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							[isUpdate]				=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							[isDelete]				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							[isActive]				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							[isApproved]			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							[isReview]				=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							[isPost]					=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							[executeBy]			=	'" . $this->model->getExecuteBy () . "',
							[executeTime]		=	" . $this->model->getExecuteTime () . "
			WHERE 		[staffId]				=	'" . $this->model->getStaffId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql = "
			UPDATE 	STAFF
			SET 			STAFFIC				=	'" . $this->model->getStaffIc () . "',
							STAFFNAME			=	'" . $this->model->getStaffName () . "',
							STAFFNO				=	'" . $this->model->getStaffNo () . "',
							STAFFPASSWORD	=	'" . md5 ( $this->model->getStaffPassword () ) . "',
							STAFFNAME			=	'" . $this->model->getStaffName () . "',
							TEAMID					=	'" . $this->model->getTeamId () . "',
							DEPARTMENTID		=	'" . $this->model->getDepartmentId () . "',
							ISDEFAULT			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							ISNEW					=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							ISDRAFT				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							ISUPDATE				=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							ISDELETE				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							ISACTIVE				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							ISAPPROVED			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							ISREVIEW				=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							ISPOST					=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							EXECUTEBY			=	'" . $this->model->getExecuteBy () . "',
							EXECUTETIME		=	" . $this->model->getExecuteTime () . "
			WHERE 		STAFFID				=	'" . $this->model->getStaffId ( 0, 'single' ) . "'";
			}
			$this->q->update ( $sql );
			if ($this->q->execute == 'fail') {
				echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
				exit ();
			}
			// check change group or not
			if ($this->model->getTeamId () != $teamId) {
				/**
				 * update  leaf group access
				 * */
				if ($this->getVendor () == self::MYSQL) {
					$sql = "
					SELECT	`leafId`
					FROM 	`leafTeamAccess`
					WHERE 	`teamId`			=	'" . $this->model->getTeamId () . "' ";
				} else if ($this->getVendor () == self::MSSQL) {
					$sql = "
					SELECT	[leafId]
					FROM 	[leafTeamAccess]
					WHERE 	[teamId]			=	'" . $this->model->getTeamId () . "'";
				} else if ($this->getVendor () == self::ORACLE) {
					$sql = "
					SELECT	LEAFID		AS 	\"leafId\"
					FROM 	LEAFTEAMACCESS
					WHERE 	TEAMID				=	'" . $this->model->getTeamId () . "' ";
				}
				$this->q->read ( $sql );
				if ($this->q->execute == 'fail') {
					echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
					exit ();
				}
				$data = $this->q->activeRecord ();
				foreach ( $data as $rowLeafGroupAccess ) {
					// check if exist record or not
					if ($this->getVendor () == self::MYSQL) {
						$sql = "
					SELECT	*
					FROM 	`leafAccess`
					WHERE 	`staffId`			=	'" . $this->model->getStaffId ( 0, 'single' ) . "'
					AND		`leafId`			=	'" . $rowLeafGroupAccess ['leafId'] . "' ";
					} else if ($this->getVendor () == self::MSSQL) {
						$sql = "
					SELECT	*
					FROM 	[leafAccess]
					WHERE 	[staffId]			=	'" . $this->model->getStaffId ( 0, 'single' ) . "'
					AND		[leafId]			=	'" . $rowLeafGroupAccess ['leafId'] . "' ";
					} else if ($this->getVendor () == self::ORACLE) {
						$sql = "
					SELECT	LEAFACCESSCREATEVALUE	AS	\"leafAccessCreateValue\",
								LEAFACCESSREADVALUE		AS  	\"leafAccessDeleteValue\",
								LEAFACCESSPOSTVALUE 		AS	\"leafAccessPostValue\",
								LEAFACCESSPRINTVALUE 		AS	\"leafAccessPrintValue\",
								lLEAFACCESSREADVALUE 		AS	\"leafAccessReadValue\",
								LEAFACCESSUPDATEVALUE	AS	\"leafAccessUpdateValue\"
					FROM 	LEAFACCESS
					WHERE 	STAFFID			=	'" . $this->model->getStaffId ( 0, 'single' ) . "'
					AND		LEAFID			=	'" . $rowLeafGroupAccess ['leafId'] . "' ";
					} else if ($this->getVendor () == self::DB2) {
						$sql = "
					SELECT	LEAFACCESSCREATEVALUE	AS	\"leafAccessCreateValue\",
								LEAFACCESSREADVALUE		AS  	\"leafAccessDeleteValue\",
								LEAFACCESSPOSTVALUE 		AS	\"leafAccessPostValue\",
								LEAFACCESSPRINTVALUE 		AS	\"leafAccessPrintValue\",
								lLEAFACCESSREADVALUE 		AS	\"leafAccessReadValue\",
								LEAFACCESSUPDATEVALUE	AS	\"leafAccessUpdateValue\"
					FROM 	LEAFACCESS
					WHERE 	STAFFID			=	'" . $this->model->getStaffId ( 0, 'single' ) . "'
					AND		LEAFID			=	'" . $rowLeafGroupAccess ['leafId'] . "' ";
					} else if ($this->getVendor () == self::POSTGRESS) {
						$sql = "
					SELECT	LEAFACCESSCREATEVALUE	AS	\"leafAccessCreateValue\",
								LEAFACCESSREADVALUE		AS  	\"leafAccessDeleteValue\",
								LEAFACCESSPOSTVALUE 		AS	\"leafAccessPostValue\",
								LEAFACCESSPRINTVALUE 		AS	\"leafAccessPrintValue\",
								lLEAFACCESSREADVALUE 		AS	\"leafAccessReadValue\",
								LEAFACCESSUPDATEVALUE	AS	\"leafAccessUpdateValue\"
					FROM 	LEAFACCESS
					WHERE 	STAFFID			=	'" . $this->model->getStaffId ( 0, 'single' ) . "'
					AND		LEAFID			=	'" . $rowLeafGroupAccess ['leafId'] . "' ";
					}
					$this->q->read ( $sql );
					if ($this->q->numberRows () > 0) {
						if ($this->getVendor () == self::MYSQL) {
							$sql = "
						UPDATE 	`leafAccess`
						SET 			`leafAccessCreateValue`		=	'" . $rowLeafGroupAccess ['leafAccessCreateValue'] . "',
										`leafAccessDeleteValue`		=	'" . $rowLeafGroupAccess ['leafAccessReadValue'] . "',
										`leafAccessPostValue`			=	'" . $rowLeafGroupAccess ['leafAccessUpdateValue'] . "',
										`leafAccessPrintValue`			=	'" . $rowLeafGroupAccess ['leafAccessDeleteValue'] . "',
										`leafAccessReadValue`			=	'" . $rowLeafGroupAccess ['leafAccessPrintValue'] . "',
										`leafAccessUpdateValue`		=	'" . $rowLeafGroupAccess ['leafAccessPostValue'] . "'
						WHERE 		`staffId`								=	'" . $this->model->getStaffId ( 0, 'single' ) . "'
						AND			`leafId`								=	'" . $rowLeafGroupAccess ['leafId'] . "'";
						} else if ($this->getVendor () == self::MSSQL) {
							$sql = "
						UPDATE 	[leafAccess]
						SET 			[leafAccessCreateValue]			=	'" . $rowLeafGroupAccess ['leafAccessCreateValue'] . "',
										[leafAccessDeleteValue]			=	'" . $rowLeafGroupAccess ['leafAccessReadValue'] . "',
										[leafAccessPostValue]			=	'" . $rowLeafGroupAccess ['leafAccessUpdateValue'] . "',
										[leafAccessPrintValue]			=	'" . $rowLeafGroupAccess ['leafAccessDeleteValue'] . "',
										[leafAccessReadValue]			=	'" . $rowLeafGroupAccess ['leafAccessPrintValue'] . "',
										[leafAccessUpdateValue]		=	'" . $rowLeafGroupAccess ['leafAccessPostValue'] . "'
						WHERE 		[staffId]								=	'" . $this->model->getStaffId ( 0, 'single' ) . "'
						AND			[leafId]									=	'" . $rowLeafGroupAccess ['leafId'] . "'";
						} else if ($this->getVendor () == self::ORACLE) {
							$sql = "
						UPDATE 	LEAFACCESS
						SET 			LEAFACCESSCREATEVALUE		=	'" . $rowLeafGroupAccess ['leafAccessCreateValue'] . "',
										LEAFACCESSREADVALUE			=	'" . $rowLeafGroupAccess ['leafAccessReadValue'] . "',
										LEAFACCESSUPDATEVALUE		=	'" . $rowLeafGroupAccess ['leafAccessUpdateValue'] . "',
										LEAFACCESSDELETEVALUE			=	'" . $rowLeafGroupAccess ['leafAccessDeleteValue'] . "',
										LEAFACCESSPRINTVALUE			=	'" . $rowLeafGroupAccess ['leafAccessPrintValue'] . "',
										LEAFACCESSPOSTVALUE			=	'" . $rowLeafGroupAccess ['leafAccessPostValue'] . "'
						WHERE 		STAFFID									=	'" . $this->model->getStaffId ( 0, 'single' ) . "'
						AND			LEAFID										=	'" . $rowLeafGroupAccess ['leafId'] . "'";
						}
						$this->q->update ( $sql );
						if ($this->q->execute == 'fail') {
							echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
							exit ();
						}
					} else {
						if ($this->getVendor () == self::MYSQL) {
							$sql = "
							INSERT INTO	`leafAccess`
								(
										`leafId`,
										`staffId`,
										`leafAccessReadValue`,
										`leafAccessUpdateValue`,
										`leafAccessDeleteValue`,
										`leafAccessPrintValue`,
										`leafAccessPostValue`
								)
							VALUES
								(
										'" . $rowLeafGroupAccess ['leafId'] . "',
										'" . $this->model->getStaffId ( 0, 'single' ) . "',
										'" . $rowLeafGroupAccess ['leafAccessReadValue'] . "',
										'" . $rowLeafGroupAccess ['leafAccessUpdateValue'] . "',
										'" . $rowLeafGroupAccess ['leafAccessDeleteValue'] . "',
										'" . $rowLeafGroupAccess ['leafAccessPrintValue'] . "',
										'" . $rowLeafGroupAccess ['leafAccessPostValue'] . "'
								)	";
						} else if ($this->getVendor () == self::MSSQL) {
							$sql = "
							INSERT INTO	[leafAccess`
								(
										[leafId],
										[staffId],
										[leafAccessReadValue],
										[leafAccessUpdateValue],
										[leafAccessDeleteValue],
										[leafAccessPrintValue],
										[leafAccessPostValue]
								)
							VALUES
								(
										'" . $rowLeafGroupAccess ['leafId'] . "',
										'" . $this->model->getStaffId ( 0, 'single' ) . "',
										'" . $rowLeafGroupAccess ['leafAccessReadValue'] . "',
										'" . $rowLeafGroupAccess ['leafAccessUpdateValue'] . "',
										'" . $rowLeafGroupAccess ['leafAccessDeleteValue'] . "',
										'" . $rowLeafGroupAccess ['leafAccessPrintValue'] . "',
										'" . $rowLeafGroupAccess ['leafAccessPostValue'] . "'
								)	";
						} else if ($this->getVendor () == self::ORACLE) {
							$sql = "
							INSERT INTO	LEAFACCESS
								(
										LEAFID,
										STAFFID,
										LEAFACCESSCREATEVALUE,
										LEAFACCESSREADVALUE,
										LEAFACCESSDELETEVALUE,
										LEAFACCESSPRINTVALUE,
										LEAFACCESSPOSTVALUE
								)
							VALUES
								(
										'" . $rowLeafGroupAccess ['leafId'] . "',
										'" . $this->model->getStaffId ( 0, 'single' ) . "',
										'" . $rowLeafGroupAccess ['leafAccessReadValue'] . "',
										'" . $rowLeafGroupAccess ['leafAccessUpdateValue'] . "',
										'" . $rowLeafGroupAccess ['leafAccessDeleteValue'] . "',
										'" . $rowLeafGroupAccess ['leafAccessPrintValue'] . "',
										'" . $rowLeafGroupAccess ['leafAccessPostValue'] . "'
								)	";
						}
						$this->q->create ( $sql );
						if ($this->q->execute == 'fail') {
							echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
							exit ();
						}
					}
				}
			}
		}
		// if change group .All access  before will deactivated
		// update leaf access to null
		$this->q->commit ();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode ( 
			array (	"success" => true, 
					"message" => "update success",
					"time"=>$time ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	public function delete() {
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
		WHERE  	`" . $this->model->getPrimaryKeyName () . "` = '" . $this->model->getStaffId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		SELECT	[" . $this->model->getPrimaryKeyName () . "]
		FROM 	[" . $this->model->getTableName () . "]
		WHERE  	[" . $this->model->getPrimaryKeyName () . "] = '" . $this->model->getStaffId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
		FROM 	" . strtoupper ( $this->model->getTableName () ) . "
		WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getStaffId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
		SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
		FROM 	" . strtoupper ( $this->model->getTableName () ) . "
				WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getStaffId ( 0, 'single' ) . "' ";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT	" . strtoupper ( $this->model->getPrimaryKeyName () ) . "
			FROM 	" . strtoupper ( $this->model->getTableName () ) . "
			WHERE  	" . strtoupper ( $this->model->getPrimaryKeyName () ) . " = '" . $this->model->getStaffId ( 0, 'single' ) . "' ";
		}
		$result = $this->q->fast ( $sql );
		$total = $this->q->numberRows ( $result, $sql );
		if ($total == 0) {
			echo json_encode ( array ("success" => false, "message" => 'Cannot find the record' ) );
			exit ();
		} else {
			if ($this->getVendor () == self::MYSQL) {
				$sql = "
			UPDATE	`staff`
			SET			`isDefault`		=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							`isNew`			=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							`isDraft`			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							`isUpdate`		=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							`isDelete`			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							`isActive`			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							`isApproved`	=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							`isReview`		=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							`isPost`			=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							`executeBy`		=	'" . $this->model->getExecuteBy () . "',
							`executeTime	=	" . $this->model->getExecuteTime () . "
			WHERE 		`staffId`			=	'" . $this->model->getStaffId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql = "
			UPDATE	[staff]
			SET			[isDefault]			= 	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							[isNew]				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							[isDraft]			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							[isUpdate]			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							[isDelete]			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							[isActive]			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							[isApproved]		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							[isReview]			=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							[isPost]				=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							[executeBy]		=	'" . $this->model->getExecuteBy () . "',
							[executeTime]	=	" . $this->model->getExecuteTime () . "
			WHERE 		[staffId]			=	'" . $this->model->getStaffId ( 0, 'single' ) . "'";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql = "
			UPDATE	STAFF
			SET			ISDEFAULT 		=  '" . $this->model->getIsDefault ( 0, 'single' ) . "',
							ISNEW				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							ISDRAFT			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							ISUPDATE			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							ISDELETE			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							ISACTIVE			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							ISAPPROVED		=  '" . $this->model->getIsApproved ( 0, 'single' ) . "',
							ISREVIEW			=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							ISPOST				=	'" . $this->model->getIsPost ( 0, 'single' ) . "',
							EXECUTEBY		=	'" . $this->model->getExecuteBy () . "',
							EXECUTETIME	=	" . $this->model->getExecuteTime () . "
			WHERE		STAFFID			=	'" . $this->model->getStaffId ( 0, 'single' ) . "'";
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
					"message" => "Removed Success",
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
			echo json_encode(array("success" => false, "message" => $this->system->getUnsupportedMessage()));
			exit();
		}
		/**
		 * System Validation Checking
		 * @var $access
		 */
		$access = array("isDefault", "isNew", "isDraft", "isUpdate", "isDelete", "isActive", "isApproved", "isReview", "isPost");
		foreach ($access as $systemCheck) {

			switch ($systemCheck) {
				case 'isDefault' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDefault($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->system->getUnsupportedMessage()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getStaffId($i, 'array') . "'
							THEN '" . $this->model->getIsDefault($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isNew' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsNew($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->system->getUnsupportedMessage()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getStaffId($i, 'array') . "'
							THEN '" . $this->model->getIsNew($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isDraft' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDraft($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->system->getUnsupportedMessage()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getStaffId($i, 'array') . "'
							THEN '" . $this->model->getIsDraft($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isUpdate' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsUpdate($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->system->getUnsupportedMessage()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getStaffId($i, 'array') . "'
							THEN '" . $this->model->getIsUpdate($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isDelete' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDelete($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->system->getUnsupportedMessage()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getStaffId($i, 'array') . "'
							THEN '" . $this->model->getIsDelete($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isActive' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsActive($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->system->getUnsupportedMessage()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getStaffId($i, 'array') . "'
							THEN '" . $this->model->getIsActive($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isApproved' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsApproved($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->system->getUnsupportedMessage()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getStaffId($i, 'array') . "'
							THEN '" . $this->model->getIsApproved($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isReview' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsReview($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->system->getUnsupportedMessage()));
								exit();
							}
							$sqlLooping .= "
                            WHEN '" . $this->model->getStaffId($i, 'array') . "'
                            THEN '" . $this->model->getIsReview($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isPost' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsPost($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->system->getUnsupportedMessage()));
								exit();
							}
							$sqlLooping .= "
                                WHEN '" . $this->model->getStaffId($i, 'array') . "'
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
			echo json_encode(array("success" => false, "message" => $this->system->getUnsupportedMessage()));
			exit();
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		if ($this->getIsAdmin()) {
			$message = $this->system->getUpdateMessage();
		} else {
			$message = $this->system->getDeleteMessage();
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
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT	*
			FROM 	`staff`
			WHERE 	`staffNo` 	= 	'" . $this->model->getStaffNo () . "'
			AND		`isActive`		=	1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	*
			FROM 	[staff]
			WHERE 	[staffNo] 		= 	'" . $this->model->getStaffNo () . "'
			AND		[isActive]		=	1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	*
			FROM 	STAFF
			WHERE 	STAFFNO 		=	 '" . $this->model->getStaffNo () . "'
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
			SELECT	*
			FROM 	STAFF
			WHERE 	STAFFNO 		=	 '" . $this->model->getStaffNo () . "'
			AND		ISACTIVE		=	1";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT	*
			FROM 	STAFF
			WHERE 	STAFFNO 		=	 '" . $this->model->getStaffNo () . "'
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
				return $total . "|" . $row ['staffNo'];
			} else {
				$end = microtime(true);
				$time = $end - $start;
				echo json_encode ( 
					array (	"success" => true, 
							"total" => $total, 
							"message" => $this->system->getDuplicateMessage(), 
							"staffNo" => $row ['staffNo'],
							"time"=>$time ) );
				exit ();
			}
		}
	}

	/**
	 * Enter description here ...
	 */
	public function team() {
		$this->security->team ();

	}
	public function department() {
		$this->security->department ();
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
	public function excel() {
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
		$this->excel->getActiveSheet ()->getColumnDimension ( 'B' )->setAutoSize ( TRUE );
		$this->excel->getActiveSheet ()->getColumnDimension ( 'C' )->setAutoSize ( TRUE );
		$this->excel->getActiveSheet ()->getColumnDimension ( 'D' )->setAutoSize ( TRUE );
		$this->excel->getActiveSheet ()->setCellValue ( 'B2', $this->title );
		$this->excel->getActiveSheet ()->setCellValue ( 'D2', '' );
		$this->excel->getActiveSheet ()->mergeCells ( 'B2:D2' );
		$this->excel->getActiveSheet ()->setCellValue ( 'B3', 'No' );
		$this->excel->getActiveSheet ()->setCellValue ( 'C3', 'Nama' );
		$this->excel->getActiveSheet ()->setCellValue ( 'D3', 'Kumpulan' );
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
			$this->excel->getActiveSheet ()->setCellValue ( 'C' . $loopRow, $row ['staffName'] );
			$this->excel->getActiveSheet ()->setCellValue ( 'D' . $loopRow, $row ['teamEnglish'] );
			$loopRow ++;
			$lastRow = 'D' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet ()->getStyle ( $formula )->applyFromArray ( $styleThinBlackBorderOutline );
		$objWriter = PHPExcel_IOFactory::createWriter ( $this->excel, 'Excel2007' );
		$filename = "staff.xlsx";
		$objWriter->save ( $_SERVER ['document_root'] . "/idcmsCore/management/document/excel/" . $filename );
		$file = fopen ( $_SERVER ['document_root'] . "/idcmsCore/management/document/excel/" . $filename, 'r' );
		if ($file) {
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode ( 
				array (	"success" => true, 
						"message" => $this->system->getFileGenerateMessage(),
						"time"=>$time ) );
		} else {
			echo json_encode ( array ("success" => false, "message" => $this->system->getFileNotGenerateMessage() ) );
		}
	}
}
$staffObject = new StaffClass ();
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
		$staffObject->setLeafId ( $_POST ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_POST ['isAdmin'] )) {
		$staffObject->setIsAdmin ( $_POST ['isAdmin'] );
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$staffObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$staffObject->setLimit($_POST ['perPage']);
	}
	/*
	 * Filtering
	 */
	if (isset ( $_POST ['query'] )) {
		$staffObject->setFieldQuery ( $_POST ['query'] );
	}
	if (isset ( $_POST ['filter'] )) {
		$staffObject->setGridQuery ( $_POST ['filter'] );
	}
	/*
	 *
	 */
	if (isset ( $_POST ['order'] )) {
		$staffObject->setOrder ( $_POST ['order'] );
	}
	if (isset ( $_POST ['sortField'] )) {
		$staffObject->setSortField ( $_POST ['sortField'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$staffObject->execute ();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$staffObject->create ();
	}
	if ($_POST ['method'] == 'read') {
		$staffObject->read ();
	}
	if ($_POST ['method'] == 'save') {
		$staffObject->update ();
	}
	if ($_POST ['method'] == 'delete') {
		$staffObject->delete ();
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
		$staffObject->setLeafId ( $_GET ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_GET ['isAdmin'] )) {
		$staffObject->setIsAdmin ( $_GET ['isAdmin'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$staffObject->execute ();
	if (isset ( $_GET ['field'] )) {
		if ($_GET ['field'] == 'staffId') {
			$staffObject->staff();
		}
		if ($_GET ['field'] == 'team') {
			$staffObject->team ();
		}
		if ($_GET ['field'] == 'department') {
			$staffObject->department ();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET ['method'] == 'updateStatus') {
		$staffObject->updateStatus ();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset ( $_GET ['staffNo'] )) {
		if (strlen ( $_GET ['staffNo'] ) > 0) {
			$staffObject->duplicate ();
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$documentObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$documentObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$documentObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$documentObject->lastRecord('json');
		}
	}
	/*
	 *  Excel Reporting
	 */
	if (isset ( $_GET ['mode'] )) {
		if ($_GET ['mode'] == 'excel') {
			$staffObject->excel ();
		}

	}
}
?>



