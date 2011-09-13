<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/staffModel.php");
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
class staffClass extends configClass
{
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
	 * @var string $documentTrail;
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
	 * Class Loader
	 */
	public function execute()
	{
		parent::__construct();
		$this->q             = new vendor();
		$this->q->vendor     = $this->getVendor();
		$this->q->leafId     = $this->getLeafId();
		$this->q->staffId    = $this->getStaffId();
		$this->q->fieldQuery = $this->getFieldQuery();
		$this->q->gridQuery  = $this->getGridQuery();
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->excel  = new PHPExcel();

		$this->audit  = 0;
		$this->log    = 0;
		$this->q->log = $this->log;

		$this->model  = new staffModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

		$this->documentTrail = new documentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->setStaffId($this->getStaffId());
		$this->documentTrail->setLanguageId($this->getLanguageId());

		$this->security = new security();
		$this->security->setVendor($this->getVendor());
		$this->security->setStaffId($this->getStaffId());
		$this->security->setLanguageId($this->getLanguageId());
		$this->security->execute();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->getVendor() == self::mysql) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->create();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			INSERT INTO `staff` 	(
						`staffName`,			`staffNo`,
						`staffPassword`,		`staffIc`,
						`groupId`,				`departmentId`,
						`isDefault`,			`isNew`,
						`isDraft`,				`isUpdate`,
						`isDelete`,				`isActive`,
						`isApproved`,			`executeBy`,
						`executeTime`

				)  VALUES	(
					\"" . $this->model->getStaffName() . "\",					\"" . $this->model->getStaffNo() . "\",
					\"" . md5($this->model->getStaffPassword()) . "\",			\"" . $this->model->getStaffIc() . "\",
					\"" . $this->model->getGroupId() . "\",						\"" . $this->model->getDepartmentId() . "\",
					\"" . $this->model->getIsDefault(0,'single') . "\",		\"" . $this->model->getIsNew(0,'single') . "\",
					\"" . $this->model->getIsDraft(0,'single') . "\",		\"" . $this->model->getIsUpdate(0,'single') . "\",
					\"" . $this->model->getIsDelete(0,'single') . "\",		\"" . $this->model->getIsActive(0,'single') . "\",
					\"" . $this->model->getIsApproved(0,'single') . "\",	\"" . $this->model->getExecuteBy() . "\",
					" . $this->model->getExecuteTime() . "
				);";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
				INSERT INTO [staff] 	(
							[staffName],		[staffNo],
							[staffPassword],	[staffIc],
							[groupId],			[executeBy],
							[executeTime]
				)  VALUES	(
					'" . $this->model->getStaffName() . "',				'" . $this->model->getStaffNo() . "',
					'" . md5($this->model->getStaffPassword()) . "',	'" . $this->model->getStaffIc() . "',
					'" . $this->model->getGroupId() . "',				'" . $this->model->getDepartmentId() . "',
					'" . $this->model->getIsDefault(0,'single') . "',	'" . $this->model->getIsNew(0,'single') . "',
					'" . $this->model->getIsDraft(0,'single') . "',		'" . $this->model->getIsUpdate(0,'single') . "',
					'" . $this->model->getIsDelete(0,'single') . "',	'" . $this->model->getIsActive(0,'single') . "',
					'" . $this->model->getIsApproved(0,'single') . "',	'" . $this->model->getExecuteBy() . "',
					" . $this->model->getExecuteTime() . "
				);";
		} else if ($this->q->vendor = 'oracle') {
			$sql = "
				INSERT INTO STAFF 	(
							STAFFNAME,		STAFFNO,
							STAFFPASSWORD,	STAFFIC,
							GROUPID,		EXECUTEBY,
							EXECUTETIME
				)  VALUES	(
					'" . $this->model->getStaffName() . "',				'" . $this->model->getStaffNo() . "',
					'" . md5($this->model->getStaffPassword()) . "',	'" . $this->model->getStaffIc() . "',
					'" . $this->model->getGroupId() . "',				'" . $this->model->getDepartmentId() . "',
					'" . $this->model->getIsDefault(0,'single') . "',	'" . $this->model->getIsNew(0,'single') . "',
					'" . $this->model->getIsDraft(0,'single') . "',		'" . $this->model->getIsUpdate(0,'single') . "',
					'" . $this->model->getIsDelete(0,'single') . "',	'" . $this->model->getIsActive(0,'single') . "',
					'" . $this->model->getIsApproved(0,'single') . "',	'" . $this->model->getExecuteBy() . "',
					" . $this->model->getExecuteTime() . "	
				);";
		}
		$this->q->create($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		$lastInsertId = $this->q->lastInsertId();
		// insert module access
		if ($this->getVendor() == self::mysql) {
			$sql = "
				SELECT	*
				FROM 	`module`
				WHERE 	`isActive`	=	1	";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
				SELECT	*
				FROM 	[module]
				WHERE 	[isActive]	=	1	";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
				SELECT	*
				FROM 	MODULE
				WHERE 	ISACTIVE	=	1	";
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		if ($this->q->numberRows() > 0) {
			$data = $this->q->activeRecord();
			foreach ($data as $rowTab) {
				// check if group access define in  moduleAccess else insert
				if ($this->getVendor() == self::mysql) {
					$sql = "
						SELECT *
						FROM 	`moduleAccess`
						WHERE 	`groupId`			=	\"" . $this->model->getGroupId() . "\"
						AND		`moduleId`		=	\"" . $rowTab['moduleId'] . "\"";
				} else if ($this->getVendor() == self::mssql) {
					$sql = "
						SELECT *
						FROM 	[moduleAccess]
						WHERE 	[groupId]			=	'" . $this->model->getGroupId() . "'
					AND		`moduleId`			=	'" . $rowTab['moduleId'] . "'";
				} else if ($this->getVendor() == self::oracle) {
					$sql = "
						SELECT *
						FROM 	MODULEACCESS
						WHERE 	GROUPID			=	'" . $this->model->getGroupId() . "'
						AND		MODULEID		=	'" . $rowTab['moduleId'] . "'";
				}
				$this->q->read($sql);
				if ($this->q->execute == 'fail') {
					echo json_encode(array(
                        "success" => false,
                        "message" => $this->q->responce
					));
					exit();
				}
				if ($this->q->numberRows() == 0) {
					// record don't exist create new
					if ($this->q->vendor == self::mysql || $this->q->vendor = 'mysql') {
						$sql = "
						INSERT INTO `moduleAccess`	(
									`moduleId`,				`groupId`,
									`moduleAccessValue`
						)	VALUES(
							\"" . $rowTab['moduleId'] . "\",
							\"" . $this->model->getGroupId() . "\",
							0
						)	";
					} else if ($this->q->vendor == 'microsft') {
						$sql = "
						INSERT INTO [moduleAccess]	(
									[moduleId],				[groupId],
									[moduleAccessValue]
						)	VALUES(
							'" . $rowTab['moduleId'] . "',
							'" . $this->model->getGroupId() . "',
							0					)	";
					} else if ($this->getVendor() == self::oracle) {
						$sql = "
						INSERT INTO MODULEACCESS	(
									MODULEID,				GROUPID,
									MODULEACCESSVALUE
						)	VALUES(
							'" . $rowTab['moduleId'] . "',
							'" . $this->model->getGroupId() . "',
							0
						)	";
					}
					$this->q->create($sql);
					if ($this->q->execute == 'fail') {
						echo json_encode(array(
                            "success" => false,
                            "message" => $this->q->responce
						));
						exit();
					}
				}
			}
		}
		// insert folder access
		if ($this->getVendor() == self::mysql) {
			$sql = "
				SELECT	*
				FROM 	`folder`
				WHERE 	`isActive`=1";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
				SELECT	*
				FROM 	[folder]
				WHERE 	[isActive]=1";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
				SELECT	*
				FROM 	FOLDER
				WHERE 	ISACTIVE=1";
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		if ($this->q->numberRows() > 0) {
			$data = $this->q->activeRecord();
			foreach ($data as $rowFolder) {
				// check if group access define in  moduleAccess else insert
				if ($this->getVendor() == self::mysql) {
					$sql = "
					SELECT *
					FROM 	`folderAccess`
					WHERE 	`groupId`		=	\"". $this->model->getGroupId() ."\"
					AND		`folderId`		=	\"". $rowFolder['folderId'] ."\"";
				} else if ($this->getVendor() == self::mssql) {
					$sql = "
					SELECT *
					FROM 	[folderAccess]
					WHERE 	[groupId]		=	'". $this->model->getGroupId() ."'
					AND		[folderId]		=	'". $rowFolder['folderId'] ."'";
				} else if ($this->getVendor() == self::oracle) {
					$sql = "
					SELECT *
					FROM 	FOLDERACCESS
					WHERE 	GROUPID			=	'". $this->model->getGroupId() ."'
					AND		FOLDERID		=	'". $rowFolder['folderId'] ."'";
				}
				$this->q->read($sql);
				if ($this->q->execute == 'fail') {
					echo json_encode(array(
                        "success" => false,
                        "message" => $this->q->responce
					));
					exit();
				}
				if ($this->q->numberRows() > 0) {
					// record exist do nothing
				} else {
					// record don't exist create new
					if ($this->getVendor() == self::mysql) {
						$sql = "
					INSERT INTO `folderAccess`
						(
								`folderId`,
								`groupId`,
								`folderAccessValue`
						)
					VALUES(
								\"". $rowFolder['folderId'] ."\",
								\"". $this->model->getGroupId() ."\",
								0
					)	";
					} else if ($this->getVendor() == self::mssql) {
						$sql = "
					INSERT INTO [folderAccess`
						(
								[folderId],
								[groupId],
								[folderAccessValue]
						)
					VALUES(
								'". $rowFolder['folderId'] ."',
								'". $this->model->getGroupId() ."',
								0
					)	";
					} else if ($this->getVendor() == self::oracle) {
						$sql = "
					INSERT INTO FOLDERACCESS
						(
								FOLDERID,
								GROUPID,
								FOLDERACCESSVALUE
						)
					VALUES(
								'". $rowFolder['folderId'] ."',
								'". $this->model->getGroupId() ."',
								0
					)	";
					}
					$this->q->create($sql);
					if ($this->q->execute == 'fail') {
						echo json_encode(array(
                            "success" => false,
                            "message" => $this->q->responce
						));
						exit();
					}
				}
			}
		}
		// insert leaf access according to the group choosen
		if ($this->getVendor() == self::mysql) {
			$sql = "
			SELECT	*
			FROM 	`leafGroupAccess`
			WHERE 	`groupId`=\"". $this->model->getGroupId() ."\" ";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			SELECT	*
			FROM 	[leafGroupAccess]
			WHERE 	[groupId]	=	'". $this->model->getGroupId() ."' ";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT	*
			FROM 	LEAFGROUPACCESS
			WHERE 	GROUPID		=	'". $this->model->getGroupId() ."' ";
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		if ($this->q->numberRows() > 0) {
			$data = $this->q->activeRecord();
			foreach ($data as $rowLeafGroupAccess) {
				if ($this->getVendor() == self::mysql) {
					$sql = "
				INSERT INTO	`leafAccess`
					(
							`leafId`,
							`staffId`,
							`leafCreateAccessValue`,
							`leafReadAccessValue`,
							`leafUpdateAccessValue`,
							`leafDeleteAccessValue`,
							`leafPrintAccessValue`,
							`leafPostAccessValue`
					)
				VALUES
					(
							\"" . $rowLeafGroupAcess['leafId'] . "\",
							\"" . $lastInsertId . "\",
							\"" . $rowLeafGroupAccess['leafCreateAccessValue'] . "\",
							\"" . $rowLeafGroupAccess['leafReadAccessValue'] . "\",
							\"" . $rowLeafGroupAccess['leafUpdateAccessValue'] . "\",
							\"" . $rowLeafGroupAccess['leafDeleteAccessValue'] . "\",
							\"" . $rowLeafGroupAccess['leafPrintAccessValue'] . "\",
							\"" . $rowLeafGroupAccess['leafPostAccessValue'] . "\"
					)	";
				} else if ($this->getVendor() == self::mssql) {
					$sql = "
				INSERT INTO	[leafAccess]
					(
							[leafId],
							[staffId],
							[leafCreateAccessValue],
							[leafReadAccessValue],
							[leafUpdateAccessValue],
							[leafDeleteAccessValue],
							[leafPrintAccessValue],
							[leafPostAccessValue]
					)
				VALUES
					(
							'" . $rowLeafGroupAccess['leafId'] . "',
							'" . $lastInsertId ."',
							'" . $rowLeafGroupAccess['leafCreateAccessValue'] . "',
							'" . $rowLeafGroupAccess['leafReadAccessValue'] . "',
							'" . $rowLeafGroupAccess['leafUpdateAccessValue'] . "',
							'" . $rowLeafGroupAccess['leafDeleteAccessValue'] . "',
							'" . $rowLeafGroupAccess['leafPrintAccessValue'] . "',
							'" . $rowLeafGroupAccess['leafPostAccessValue'] . "'
					)	";
				} else if ($this->getVendor() == self::oracle) {
					$sql = "
				INSERT INTO	LEAFACCESS
					(
							LEAFID,
							STAFFID,
							LEAFCREATEACCESSVALUE,
							LEAFREADACCESSVALUE,
							LEAFUPDATEACCESSVALUE,
							LEAFDELETEACCESSVALUE,
							LEAFPRINTACCESSVALUE,
							LEAFPOSTACCESSVALUE
					)
				VALUES
					(
							'" . $rowLeafGroupAccess['leafId'] ."',
							'" . $lastInsertId ."',
							'" . $rowLeafGroupAccess['leafCreateAccessValue'] . "',
							'" . $rowLeafGroupAccess['leafReadAccessValue'] . "',
							'" . $rowLeafGroupAccess['leafUpdateAccessValue'] . "',
							'" . $rowLeafGroupAccess['leafDeleteAccessValue'] . "',
							'" . $rowLeafGroupAccess['leafPrintAccessValue'] . "',
							'" . $rowLeafGroupAccess['leafPostAccessValue'] . "'
					)	";
				}
				$this->q->create($sql);
				if ($this->q->execute == 'fail') {
					echo json_encode(array(
                        "success" => false,
                        "message" => $this->q->responce
					));
					exit();
				}
			}
		}
		/**
		 * generate category for each staff
		 */
		for ($i = 1; $i <= 10; $i++) {
			if ($this->getVendor() == self::mysql) {
				$sql = "
				INSERT INTO 	`calendar`
							(
								`calendarColorId`,
								`calendarTitle`,
								`staffId`
							) VALUES	(
								\"". $i ."\",
								\"". "other" . $i ."\",
								\"". $lastInsertId ."\"
							)";
			} else if ($this->getVendor() == self::mssql) {
				$sql = "
				INSERT INTO 	[calendar]
							(
								[calendarColorId],
								[calendarTitle],
								[staffId]
							) VALUES	(
								'". $i ."',
								'". "other" . $i ."',
								'". $lastInsertId ."'
							)";
			} else if ($this->getVendor() == self::oracle) {
				$sql = "
				INSERT INTO 	CALENDAR
							(
								CALENDARCOLORID,
								CALENDARTITLE,
								STAFFID
							) VALUES	(
								'". $i ."',
								'". "other" . $i ."',
								'". $lastInsertId ."'
							)";
			}
			$this->q->create($sql);
			if ($this->q->execute == 'fail') {
				echo json_encode(array(
                    "success" => false,
                    "message" => $this->q->responce
				));
				exit();
			}
		}
		$this->q->commit();
		echo json_encode(array(
            "success" => "true",
            "message" => "Record Created"
            ));
            exit();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->isAdmin == 0) {
			if ($this->getVendor() == self::mysql) {
				$this->auditFilter = "	`staff`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::mssql) {
				$this->auditFilter = "	[staff].[isActive]		=	1	";
			} else if ($this->q->vendor == self::oracle) {
				$this->auditFilter = "	STAFF.ISACTIVE	=	1	";
			}
		} else if ($this->isAdmin == 1) {
			if ($this->getVendor() == self::mysql) {
				$this->auditFilter = "	 1 =  1 ";
			} else if ($this->q->vendor == self::mssql) {
				$this->auditFilter = "	1 = 1 ";
			} else if ($this->q->vendor == self::oracle) {
				$this->auditFilter = " 1 = 1 ";
			}
		}
		//UTF8
		$items = array();
		if ($this->getVendor() == self::mysql) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
					SELECT	`staff`.`staffId`,
							`staff`.`groupId`,
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
							`staff`.`executeBy`,
							`staff`.`executeTime`
 					FROM 	`staff`
 					JOIN	`group`
 					USING	(`groupId`)
 					JOIN	`department`
 					USING	(`departmentId`)
					WHERE 	" . $this->auditFilter . "
					AND		`group`.`isActive`=1
					AND		`department`.`isActive`=1
					";
			if ($this->model->getStaffId(0,'single')) {
				$sql .= " AND `" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`=\"" . $this->model->getStaffId(0,'single') . "\"";
			}
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
					SELECT	[staff].[staffId],
							[staff].[groupId],
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
							[staff].[isApproved],
							[staff].[executeBy],
							[staff].[executeTime],
							[staff].[staffName]
					FROM 	[staff]
					JOIN	[department]
					ON		[department].[departmentId]=[staff].[staffId]
					JOIN	[group]
					ON		[group].[groupId]=[staff].[groupId]
					WHERE 	[staff].[isActive]='1'
					AND		[group].[isActive] ='1'
					AND		[department].[isActive]='1'";
			if ($this->model->getStaffId(0,'single')) {
				$sql .= " AND [" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]=\"" . $this->model->getStaffId(0,'single') . "\"";
			}
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
					SELECT	STAFF.STAFFID 		AS 	\"staffId\",
							STAFF.GROUPID 		AS 	\"groupId\",
							STAFF.DEPARTMENTID 	AS 	\"departmentId\",
							STAFF.LANGUAGEID 	AS 	\"languageId\",
							STAFF.STAFFPASSWORD AS 	\"staffPassword\",
							STAFF.STAFFNAME 	AS 	\"staffName\",
							STAFF.STAFFNO 		AS 	\"staffNo\",
							STAFF.STAFFIC 		AS 	\"staffIc\",
							STAFF.ISDEFAULT 	AS 	\"isDefault\",
							STAFF.ISNEW 		AS 	\"isNew\",
							STAFF.ISDRAFT 		AS 	\"isDraft\",
							STAFF.ISUPDATE 		AS 	\"isUpdate\",
							STAFF.ISDELETE 		AS 	\"isDelete\",
							STAFF.ISACTIVE 		AS 	\"isActive\",
							STAFF.ISAPPROVED 	AS 	\"isApproved\",
							STAFF.EXECUTEBY 	AS 	\"executeBy\",
							STAFF.EXECUTETIME 	AS 	\"executeTime\",
							STAFF.STAFFNAME 	AS	\"staffName\"
					FROM 	STAFF
					JOIN	GROUP_
 					ON		GROUP_.GROUPID				=	STAFF.GROUPID
 					JOIN	DEPARTMENT
 					ON		DEPARTMENT.DEPARTMENTID		=	STAFF.DEPARTMENTID
					WHERE 	STAFF.ISACTIVE				=	'1'
					AND		GROUP_.ISACTIVE 			=	'1'
					AND		DEPARTMENT.ISACTIVE			=	'1' ";
			if ($this->model->getStaffId(0,'single')) {
				$sql .= " AND \"" . $this->model->getTableName() . "\".\"" . $this->model->getPrimaryKeyName() . "\"=\"" . $this->model->getStaffId(0,'single') . "\"";
			}
		} else {
			echo json_encode(array(
                "success" => false,
                "message" => "Undefine Damodulease Vendor"
                ));
                exit();
		}
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array(
            'staffId'
            );
            /**
             *	filter modulele
             * @variables $moduleleArray
             */
            $moduleleArray  = null;
            $moduleleArray  = array(
            'staff'
            );
            if ($this->getFieldQuery()) {
            	if ($this->getVendor() == self::mysql) {
            		$sql .= $this->q->quickSearch($moduleleArray, $filterArray);
            	} else if ($this->getVendor() == self::mssql) {
            		$tempSql = $this->q->quickSearch($moduleleArray, $filterArray);
            		$sql .= $tempSql;
            	} else if ($this->getVendor() == self::oracle) {
            		$tempSql = $this->q->quickSearch($moduleleArray, $filterArray);
            		$sql .= $tempSql;
            	}
            }
            /**
             *	Extjs filtering mode
             */
            if ($this->getGridQuery()) {
            	if ($this->getVendor() == self::mysql) {
            		$sql .= $this->q->searching();
            	} else if ($this->getVendor() == self::mssql) {
            		$tempSql2 = $this->q->searching();
            		$sql .= $tempSql2;
            	} else if ($this->getVendor() == self::oracle) {
            		$tempSql2 = $this->q->searching();
            		$sql .= $tempSql2;
            	}
            }
            /** // optional debugger.uncomment if wanted to used

            echo json_encode(array(
            "success" => false,
            "message" => $sql
            ));
            exit();

            // end of optional debugger */
            //echo $sql;
            $this->q->read($sql);
            if ($this->q->execute == 'fail') {
            	echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
            	));
            	exit();
            }
            $total = $this->q->numberRows();
            if ($this->getOrder() && $this->getSortField()) {
            	if ($this->getVendor() == self::mysql) {
            		$sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder(). " ";
            	} else if ($this->getVendor() ==  self::mssql) {
            		$sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
            	} else if ($this->getVendor() == self::oracle) {
            		$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . "  " . strtoupper($this->getOrder()). " ";
            	}
            }
            $_SESSION['sql']   = $sql; // push to session so can make report via excel and pdf
            $_SESSION['start'] = $this->getStart();
            $_SESSION['limit'] = $this->getLimit();
            if (empty($this->filter)) {
            	if ($this->getLimit()) {
            		// only mysql have limit
            		if ($this->getVendor() == self::mysql) {
            			$sql .= " LIMIT  " . $this->getStart() . "," . $this->getLimit() . " ";
            		} else if ($this->getVendor() == self::mssql) {
            			/**
            			 *	 Sql Server and Oracle used row_number
            			 *	 Parameterize Query We don't support
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
										[staff].[staffSequence],
										[staff].[staffCode],
										[staff].[staffNote],
										[staff].[isDefault],
										[staff].[isNew],
										[staff].[isDraft],
										[staff].[isUpdate],
										[staff].[isDelete],
										[staff].[isApproved],
										[staff].[executeBy],
										[staff].[executeTime],
										[staff].[staffName]
							FROM 		[staffDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $this->getStart() . "
							AND 			" . ($this->getStart() + $this->getLimit() - 1) . ";";
            		} else if ($this->getVendor() == self::oracle) {
            			/**
            			 *  Oracle using derived table also
            			 */
            			$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT  STAFF.STAFFID,
									SELECT	STAFF.STAFFID 		AS 	\"staffId\",
							STAFF.GROUPID 		AS 	\"groupId\",
							STAFF.DEPARTMENTID 	AS 	\"departmentId\",
							STAFF.LANGUAGEID 	AS 	\"languageId\",
							STAFF.STAFFPASSWORD AS 	\"staffPassword\",
							STAFF.STAFFNAME 	AS 	\"staffName\",
							STAFF.STAFFNO 		AS 	\"staffNo\",
							STAFF.STAFFIC 		AS 	\"staffIc\",
							STAFF.ISDEFAULT 	AS 	\"isDefault\",
							STAFF.ISNEW 		AS 	\"isNew\",
							STAFF.ISDRAFT 		AS 	\"isDraft\",
							STAFF.ISUPDATE 		AS 	\"isUpdate\",
							STAFF.ISDELETE 		AS 	\"isDelete\",
							STAFF.ISACTIVE 		AS 	\"isActive\",
							STAFF.ISAPPROVED 	AS 	\"isApproved\",
							STAFF.EXECUTEBY 	AS 	\"executeBy\",
							STAFF.EXECUTETIME 	AS 	\"executeTime\",
							STAFF.STAFFNAME 	AS	\"staffName\"
					FROM 	STAFF
					JOIN	GROUP_
 					ON		GROUP_.GROUPID				=	STAFF.GROUPID
 					JOIN	DEPARTMENT
 					ON		DEPARTMENT.DEPARTMENTID		=	STAFF.DEPARTMENTID
					WHERE 	STAFF.ISACTIVE				=	'1'
					AND		GROUP_.ISACTIVE 			=	'1'
					AND		DEPARTMENT.ISACTIVE			=	'1'  " . $tempSql . $tempSql2 . $orderBy . "
								 ) a
						where rownum <= '" . ($this->getStart() + $this->getLimit() - 1) . "' )
						where r >=  '" . $this->getStart() . "'";
            		} else {
            			echo "undefine vendor";
            			exit();
            		}
            	}
            }
            /*
             *  Only Execute One Query
             */
            if (!($this->model->getStaffId(0,'single'))) {
            	$this->q->read($sql);
            	if ($this->q->execute == 'fail') {
            		echo json_encode(array(
                    "success" => false,
                    "message" => $this->q->responce
            		));
            		exit();
            	}
            }
            $items = array();
            while ($row = $this->q->fetchAssoc()) {
            	$items[] = $row;
            }
            if ($this->model->getStaffId(0,'single')) {
            	$json_encode = json_encode(array(
                'success' => true,
                'total' => $total,
                'message' => 'Data Loaded',
                'firstRecord'=>$this->firstRecord(),
            	'nextRecord'=>$this->nextRecord($this->model->getStaffId(0,'single')),
            	'previousRecord'=>$this->previousRecord($this->model->getStaffId(0,'single')),
            	'lastRecord'=>$this->lastRecord(),
                'data' => $items
            	));
            	$json_encode = str_replace("[", "", $json_encode);
            	$json_encode = str_replace("]", "", $json_encode);
            	echo $json_encode;
            } else {
            	if (count($items) == 0) {
            		$items = '';
            	}
            	echo json_encode(array(
                'success' => true,
                'total' => $total,
                'message' => 'data loaded',
                'data' => $items
            	));
            	exit();
            }
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	public function update()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->update();
		//  original group
		if ($this->getVendor() == self::mysql) {
			$sql = "
			SELECT	`groupId`,
					`staffPassword`
			FROM 	`staff`
			WHERE 	`staffId`	=	\"". $this->model->getStaffId(0,'single') ."\"";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			SELECT 	[groupId],
					[staffPassword]
			FROM 	[staff]
			WHERE 	[staffId]	=	'". $this->model->getStaffId(0,'single') ."'";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT 	GROUPID 		AS 	\"groupId\",
					STAFFPASSWORD	AS	\"staffPassword\"
			FROM 	STAFF
			WHERE 	STAFFID	=	'". $this->model->getStaffId(0,'single') ."'";
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			$this->msg(false, $this->q->responce);
			exit();
		}
		$data = $this->q->fetchAssoc();
		if ($data['staffPassword'] == md5($this->model->getStaffPassword())) {
			$staffPassword = $data['staffPassword'];
		} else {
			$staffPassword = $this->model->getStaffPassword();
		}
		$groupId = $data['groupId'];
		if ($this->getVendor() == self::mysql) {
			$sql = "
				UPDATE 	`staff`
				SET 	`staffIc`		=	\"". $this->model->getStaffIc() ."\",
						`staffName`		=	\"". $this->model->getStaffName() ."\",
						`staffNo`		=	\"". $this->model->getStaffNo() ."\",
						`staffPassword`	=	\"". md5($this->model->getStaffPassword()) ."\",
						`groupId`		=	\"". $this->model->getGroupId() ."\",
						`departmentId`	=	\"". $this->model->getDepartmentId() ."\",
						`isDefault`		=	\"". $this->model->getIsDefault(0,'single') ."\",
						`isNew`			=	\"". $this->model->getIsNew(0,'single') ."\",
						`isDraft`		=	\"". $this->model->getIsDraft(0,'single') ."\",
						`isUpdate`		=	\"". $this->model->getIsUpdate(0,'single') ."\",
						`isDelete`		=	\"". $this->model->getIsDelete(0,'single') ."\",
						`isActive`		=	\"". $this->model->getIsActive(0,'single') ."\",
						`isApproved`	=	\"". $this->model->getIsApproved(0,'single') ."\",
						`executeBy`			=	\"". $this->model->getExecuteBy() ."\",
						`Time			=	" . $this->model->getExecuteTime() . "
				WHERE 	`staffId`		=	\"". $this->model->getStaffId(0,'single') ."\"";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
				UPDATE 	[staff]
				SET 	[staffIc]		=	'". $this->model->getStaffIc() ."',
						[staffName]		=	'". $this->model->getStaffName() ."',
						[staffNo]		=	'". $this->model->getStaffNo() ."',
						[staffPassword]	=	'". md5($this->model->getStaffPassword()) ."',
						[staffName]		=	'". $this->model->getStaffName() ."',
						[groupId]		=	'". $this->model->getGroupId() ."',
						[departmentId]	=	'". $this->model->getDepartmentId() ."',
						[isDraft]		=	'". $this->model->getIsDraft(0,'single') ."',
						[isNew]			=	'". $this->model->getIsNew(0,'single') ."',
						[isDraft]		=	'". $this->model->getIsDraft(0,'single') ."',
						[isUpdate]		=	'". $this->model->getIsUpdate(0,'single') ."',
						[isDelete]		=	'". $this->model->getIsDelete(0,'single') ."',
						[isActive]		=	'". $this->model->getIsActive(0,'single') ."',
						[isApproved]	=	'". $this->model->getIsApproved(0,'single') ."',
						[executeBy]		=	'". $this->model->getExecuteBy() ."',
						[executeTime]	=	" . $this->model->getExecuteTime() . "
				WHERE 	[staffId]		=	'". $this->model->getStaffId(0,'single') ."'";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
				UPDATE 	STAFF
				SET 	STAFFIC			=	'". $this->model->getStaffIc() ."',
						STAFFNAME		=	'". $this->model->getStaffName() ."',
						STAFFNO			=	'". $this->model->getStaffNo() ."',
						STAFFPASSWORD	=	'". md5($this->model->getStaffPassword()) ."',
						STAFFNAME		=	'". $this->model->getStaffName() ."',
						GROUPID			=	'". $this->model->getGroupId() ."',
						DEPARTMENTID	=	'". $this->model->getDepartmentId() ."',
						ISDEFAULT		=	'". $this->model->getIsDefault(0,'single') ."',
						ISNEW			=	'". $this->model->getIsNew(0,'single') ."',
						ISDRAFT			=	'". $this->model->getIsDraft(0,'single') ."',
						ISUPDATE		=	'". $this->model->getIsUpdate(0,'single') ."',
						ISDELETE		=	'". $this->model->getIsDelete(0,'single') ."',
						ISACTIVE		=	'". $this->model->getIsActive(0,'single') ."',
						ISAPPROVED		=	'". $this->model->getIsApproved(0,'single') ."',
						EXECUTEBY		=	'". $this->model->getExecuteBy() ."',
						EXECUTETIME		=	" . $this->model->getExecuteTime() . "
				WHERE 	STAFFID			=	'". $this->model->getStaffId(0,'single') ."'";
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => "false",
                "message" => $this->q->responce
			));
			exit();
		}
		// check change group or not
		if ($this->model->getGroupId() != $groupId) {
			/**
			 *  update  leaf group access
			 * */
			if ($this->getVendor() == self::mysql) {
				$sql = "
					SELECT	`leafId`
					FROM 	`leafGroupAccess`
					WHERE 	`groupId`			=	\"". $this->model->getGroupId() ."\" ";
			} else if ($this->getVendor() == self::mssql) {
				$sql = "
					SELECT	[leafId]
					FROM 	[leafGroupAccess]
					WHERE 	[groupId]			=	'". $this->model->getGroupId() ."'";
			} else if ($this->getVendor() == self::oracle) {
				$sql = "
					SELECT	LEAFID		AS 	\"leafId\"
					FROM 	LEAFGROUPACCESS
					WHERE 	GROUPID				=	'". $this->model->getGroupId() ."' ";
			}
			$this->q->read($sql);
			if ($this->q->execute == 'fail') {
				echo json_encode(array(
                    "success" => false,
                    "message" => $this->q->responce
				));
				exit();
			}
			$data = $this->q->activeRecord();
			foreach ($data as $rowLeafGroupAccess) {
				// check if exist record or not
				if ($this->getVendor() == self::mysql) {
					$sql = "
					SELECT	*
					FROM 	`leafAccess`
					WHERE 	`staffId`			=	\"". $this->model->getStaffId(0,'single') ."\"
					AND		`leafId`			=	\"". $rowLeafGroupAccess['leafId'] ."\" ";
				} else if ($this->getVendor() == self::mssql) {
					$sql = "
					SELECT	*
					FROM 	[leafAccess]
					WHERE 	[staffId]			=	'". $this->model->getStaffId(0,'single') ."'
					AND		[leafId]			=	'". $rowLeafGroupAccess['leafId'] ."' ";
				} else if ($this->getVendor() == self::oracle) {
					$sql = "
					SELECT	LEAFCREATEACCESSVALUE	AS	\"leafCreateAccessValue\",
							LEAFDELETEACCESSVALUE	AS  \"leafDeleteAccessValue\",
							LEAFPOSTACCESSVALUE 	AS	\"leafPostAccessValue\",
							LEAFPRINTACCESSVALUE 	AS	\"leafPrintAccessValue\",
							LEAFREADACCESSVALUE 	AS	\"leafReadAccessValue\",
							LEAFUPDATEACCESSVALUE 	AS	\"leafUpdateAccessValue\"
					FROM 	LEAFACCESS
					WHERE 	STAFFID			=	'". $this->model->getStaffId(0,'single') ."'
					AND		LEAFID			=	'". $rowLeafGroupAccess['leafId'] ."' ";
				}
				$this->q->read($sql);
				if ($this->q->numberRows() > 0) {
					if ($this->getVendor() == self::mysql) {
						$sql = "
						UPDATE 	`leafAccess`
						SET 	`leafCreateAccessValue`			=	\"". $rowLeafGroupAccess['leafCreateAccessValue'] ."\",
								`leafDeleteAccessValue`			=	\"". $rowLeafGroupAccess['leafReadAccessValue'] ."\",
								`leafPostAccessValue`			=	\"". $rowLeafGroupAccess['leafUpdateAccessValue'] ."\",
								`leafPrintAccessValue`			=	\"". $rowLeafGroupAccess['leafDeleteAccessValue'] ."\",
								`leafReadAccessValue`			=	\"". $rowLeafGroupAccess['leafPrintAccessValue'] ."\",
								`leafUpdateAccessValue`			=	\"". $rowLeafGroupAccess['leafPostAccessValue'] ."\"
						WHERE 	`staffId`						=	\"". $this->model->getStaffId(0,'single') ."\"
						AND		`leafId`						=	\"". $rowLeafGroupAccess['leafId'] ."\"";
					} else if ($this->getVendor() == self::mssql) {
						$sql = "
						UPDATE 	[leafAccess]
						SET 	[leafCreateAccessValue]			=	'". $rowLeafGroupAccess['leafCreateAccessValue'] ."',
								[leafDeleteAccessValue]			=	'". $rowLeafGroupAccess['leafReadAccessValue'] ."',
								[leafPostAccessValue]			=	'". $rowLeafGroupAccess['leafUpdateAccessValue'] ."',
								[leafPrintAccessValue]			=	'". $rowLeafGroupAccess['leafDeleteAccessValue'] ."',
								[leafReadAccessValue]			=	'". $rowLeafGroupAccess['leafPrintAccessValue'] ."',
								[leafUpdateAccessValue]			=	'". $rowLeafGroupAccess['leafPostAccessValue'] ."'
						WHERE 	[staffId]						=	'". $this->model->getStaffId(0,'single') ."'
						AND		[leafId]						=	'". $rowLeafGroupAccess['leafId'] ."'";
					} else if ($this->getVendor() == self::oracle) {
						$sql = "
								UPDATE 	LEAFACCESS
						SET 	LEAFCREATEACCESSVALUE		=	'". $rowLeafGroupAccess['leafCreateAccessValue'] ."',
								LEAFDELETEACCESSVALUE		=	'". $rowLeafGroupAccess['leafReadAccessValue'] ."',
								LEAFPOSTACCESSVALUE			=	'". $rowLeafGroupAccess['leafUpdateAccessValue'] ."',
								LEAFPRINTACCESSVALUE		=	'". $rowLeafGroupAccess['leafDeleteAccessValue'] ."',
								LEAFREADACCESSVALUE			=	'". $rowLeafGroupAccess['leafPrintAccessValue'] ."',
								LEAFUPDATEACCESSVALUE		=	'". $rowLeafGroupAccess['leafPostAccessValue'] ."'
						WHERE 	STAFFID						=	'". $this->model->getStaffId(0,'single') ."'
						AND		LEAFID						=	'". $rowLeafGroupAccess['leafId'] ."'";
					}
					$this->q->update($sql);
					if ($this->q->execute == 'fail') {
						echo json_encode(array(
                            "success" => "false",
                            "message" => $this->q->responce
						));
						exit();
					}
				} else {
					if ($this->getVendor() == self::mysql) {
						$sql = "
							INSERT INTO	`leafAccess`
								(
										`leafId`,
										`staffId`,
										`leafReadAccessValue`,
										`leafUpdateAccessValue`,
										`leafDeleteAccessValue`,
										`leafPrintAccessValue`,
										`leafPostAccessValue`
								)
							VALUES
								(
										\"". $rowLeafGroupAccess['leafId'] ."\",
										\"". $this->model->getStaffId(0,'single') ."\",
										\"". $rowLeafGroupAccess['leafReadAccessValue'] ."\",
										\"". $rowLeafGroupAccess['leafUpdateAccessValue'] ."\",
										\"". $rowLeafGroupAccess['leafDeleteAccessValue'] ."\",
										\"". $rowLeafGroupAccess['leafPrintAccessValue'] ."\",
										\"". $rowLeafGroupAccess['leafPostAccessValue'] ."\"
								)	";
					} else if ($this->getVendor() == self::mssql) {
						$sql = "
							INSERT INTO	[leafAccess`
								(
										[leafId],
										[staffId],
										[leafReadAccessValue],
										[leafUpdateAccessValue],
										[leafDeleteAccessValue],
										[leafPrintAccessValue],
										[leafPostAccessValue]
								)
							VALUES
								(
										'". $rowLeafGroupAccess['leafId'] ."',
										'". $this->model->getStaffId(0,'single') ."',
										'". $rowLeafGroupAccess['leafReadAccessValue'] ."',
										'". $rowLeafGroupAccess['leafUpdateAccessValue'] ."',
										'". $rowLeafGroupAccess['leafDeleteAccessValue'] ."',
										'". $rowLeafGroupAccess['leafPrintAccessValue'] ."',
										'". $rowLeafGroupAccess['leafPostAccessValue'] ."'
								)	";
					} else if ($this->getVendor() == self::oracle) {
						$sql = "
							INSERT INTO	LEAFACCESS
								(
										LEAFID,
										STAFFID,
										LEAFREADACCESSVALUE,
										LEAFUPDATEACCESSVALUE,
										LEAFDELETEACCESSVALUE,
										LEAFPRINTACCESSVALUE,
										LEAFPOSTACCESSVALUE
								)
							VALUES
								(
										'". $rowLeafGroupAccess['leafId'] ."',
										'". $this->model->getStaffId(0,'single') ."',
										'". $rowLeafGroupAccess['leafReadAccessValue'] ."',
										'". $rowLeafGroupAccess['leafUpdateAccessValue'] ."',
										'". $rowLeafGroupAccess['leafDeleteAccessValue'] ."',
										'". $rowLeafGroupAccess['leafPrintAccessValue'] ."',
										'". $rowLeafGroupAccess['leafPostAccessValue'] ."'
								)	";
					}
					$this->q->create($sql);
					if ($this->q->execute == 'fail') {
						echo json_encode(array(
                            "success" => false,
                            "message" => $this->q->responce
						));
						exit();
					}
				}
			}
		}
		// if change group .All access  before will deactivated
		// update leaf access to null
		$this->q->commit();
		echo json_encode(array(
            "success" => "success",
            "message" => "update success"
            ));
            exit();
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	public function delete()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->delete();
		if ($this->getVendor() == self::mysql) {
			$sql = "
				UPDATE	`staff`
				SET		`isDefault`			=	\"". $this->model->getIsActive(0,'single') ."\",
						`isNew`				=	\"". $this->model->getIsNew(0,'single') ."\",
						`isDraft`			=	\"". $this->model->getIsDraft(0,'single') ."\",
						`isUpdate`			=	\"". $this->model->getIsUpdate(0,'single') ."\",
						`isDelete`			=	\"". $this->model->getIsDelete(0,'single') ."\",
						`isActive`			=	\"". $this->model->getIsActive(0,'single') ."\",
						`isApproved`		=	\"". $this->model->getIsApproved(0,'single') ."\",
						`executeBy`			=	\"". $this->model->getExecuteBy() ."\",
						`Time				=	" . $this->model->getExecuteTime() . "
				WHERE 	`staffId`			=	\"". $this->model->staffId ."\"";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
				UPDATE	[staff]
				SET		[isDefault]		= 	'". $this->model->getIsDefault(0,'single') ."',
						[isNew]			=	'". $this->model->getIsNew(0,'single') ."',
						[isDraft]		=	'". $this->model->getIsDraft(0,'single') ."',
						[isUpdate]		=	'". $this->model->getIsUpdate(0,'single') ."',
						[isDelete]		=	'". $this->model->getIsDelete(0,'single') ."',
						[isActive]		=	'". $this->model->getIsActive(0,'single') ."',
						[isApproved]	=	'". $this->model->getIsApproved(0,'single') ."',
						[executeBy]		=	'". $this->model->getExecuteBy() ."',
						[executeTime]	=	" . $this->model->getExecuteTime() . "
				WHERE 	[staffId]		=	'". $this->model->getStaffId(0,'single') ."'";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
				UPDATE	STAFF
				SET		ISDEFAULT 		=   '". $this->model->getIsDefault(0,'single') ."',
						ISNEW			=	'". $this->model->getIsNew(0,'single') ."',
						ISDRAFT			=	'". $this->model->getIsDraft(0,'single') ."',
						ISUPDATE		=	'". $this->model->getIsUpdate(0,'single') ."',
						ISDELETE		=	'". $this->model->getIsDelete(0,'single') ."',
						ISACTIVE		=	'". $this->model->getIsActive(0,'single') ."',
						ISAPPROVED		=   '". $this->model->getIsApproved(0,'single') ."',
						EXECUTEBY		=	'". $this->model->getExecuteBy() ."',
						EXECUTETIME		=	" . $this->model->getExecuteTime() . "
				WHERE 	STAFFID			=	'". $this->model->getStaffId(0,'single') ."'";
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => "false",
                "message" => $this->q->responce
			));
			exit();
		}
		$this->q->commit();
		echo json_encode(array(
            "success" => "success",
            "message" => "Removed Success"
            ));
            exit();
	}

	function updateStatus()
	{
		$loop = $this->model->getTotal();
		if ($this->isAdmin == 0) {
			$this->model->delete();

			if ($this->getVendor() == self::mysql) {
				$sql = "
				UPDATE 	`" . $this->model->getTableName() . "`
				SET 	";
				$sql .= "	   `isDefault`			=	case `" . $this->model->getPrimaryKeyName() . "` ";
				for ($i = 0; $i < $loop; $i++) {
					if ($this->model->getIsDelete($i, 'array') == 1) {

						$primaryKeyAll .= $this->model->getStaffId($i, 'array') . ",";
						$sql .= "
						WHEN '". $this->model->getStaffId($i, 'array') ."'
						THEN \"". $this->model->getIsDefault(0,'single') ."\"";
					} else {
						//echo "salah";
					}
				}
				$sql .= "	END, ";
				$sql .= "	`isNew`	=	case `" . $this->model->getPrimaryKeyName() . "` ";
				for ($i = 0; $i < $loop; $i++) {
					if ($this->model->getIsDelete($i, 'array') == 1) {
						$primaryKeyAll .= $this->model->getStaffId($i, 'array') . ",";
						$sql .= "
						WHEN '". $this->model->getStaffId($i, 'array') ."'
						THEN \"". $this->model->getIsNew(0,'single') ."\"";
					}
				}
				$sql .= "	END,";
				$sql .= "	`isDraft`	=	case `" . $this->model->getPrimaryKeyName() . "` ";
				for ($i = 0; $i < $loop; $i++) {
					if ($this->model->getIsDelete($i, 'array') == 1) {
						$primaryKeyAll .= $this->model->getStaffId($i, 'array') . ",";
						$sql .= "
						WHEN '". $this->model->getStaffId($i, 'array') ."'
						THEN \"". $this->model->getIsDraft(0,'single') ."\"";
					}
				}
				$sql .= "	END,";
				$sql .= "	`isUpdate`	=	case `" . $this->model->getPrimaryKeyName() . "`";
				for ($i = 0; $i < $loop; $i++) {
					if ($this->model->getIsDelete($i, 'array') == 1) {
						$primaryKeyAll .= $this->model->getStaffId($i, 'array') . ",";
						$sql .= "
						WHEN '". $this->model->getStaffId($i, 'array') ."'
						THEN \"". $this->model->getIsUpdate(0,'single') ."\"";
					}
				}
				$sql .= "	END,";
				$sql .= "	`isDelete`	=	case `" . $this->model->getPrimaryKeyName() . "`";
				for ($i = 0; $i < $loop; $i++) {
					if ($this->model->getIsDelete($i, 'array') == 1) {
						$primaryKeyAll .= $this->model->getStaffId($i, 'array') . ",";
						$sql .= "
						WHEN '". $this->model->getStaffId($i, 'array') ."'
						THEN '". $this->model->getIsDelete($i, 'array') ."'";
					}
				}
				$sql .= "	END,	";
				$sql .= "	`isActive`	=		case `" . $this->model->getPrimaryKeyName() . "` ";
				for ($i = 0; $i < $loop; $i++) {
					if ($this->model->getIsDelete($i, 'array') == 1) {
						$primaryKeyAll .= $this->model->getStaffId($i, 'array') . ",";
						$sql .= "
						WHEN '". $this->model->getStaffId($i, 'array') ."'
						THEN \"". $this->model->getIsActive(0,'single') ."\"";
					}
				}
				$sql .= "	END,";
				$sql .= "	`isApproved`			=	case `" . $this->model->getPrimaryKeyName() . "` ";
				for ($i = 0; $i < $loop; $i++) {
					if ($this->model->getIsDelete($i, 'array') == 1) {
						$primaryKeyAll .= $this->model->getStaffId($i, 'array') . ",";
						$sql .= "
						WHEN '". $this->model->getStaffId($i, 'array') ."'
						THEN \"". $this->model->getIsApproved(0,'single') ."\"";
					}
				}
				$sql .= "
				END,
				`executeBy`				=	\"" . $this->model->getExecuteBy() . "\",
				`executeTime`				=	" . $this->model->getExecuteTime() . " ";
				$this->model->setPrimaryKeyAll(substr($primaryKeyAll, 0, -1));
				$sql .= " WHERE 	`" . $this->model->getPrimaryKeyName() . "`		IN	(" . $this->model->getPrimaryKeyAll() . ")";
			} else if ($this->getVendor() == self::mssql) {
				$sql = "
			UPDATE 	[Department]
			SET 	[isDefault]			=	\"" . $this->model->getIsDefault(0,'single') . "\",
					[isNew]				=	\"" . $this->model->getIsNew(0,'single') . "\",
					[isDraft]			=	\"" . $this->model->getIsDraft(0,'single') . "\",
					[isUpdate]			=	\"" . $this->model->getIsUpdate(0,'single') . "\",
					[isDelete]			=	\"" . $this->model->getIsDelete(0,'single') . "\",
					[isActive]			=	\"" . $this->model->getIsActive(0,'single') . "\",
					[isApproved]		=	\"" . $this->model->getIsApproved(0,'single') . "\",
					[executeBy]				=	\"" . $this->model->getExecuteBy() . "\",
					[executeTime]				=	" . $this->model->getExecuteTime() . "
			WHERE 	[DepartmentId]		IN	(" . $this->model->getStaffIdAll() . ")";
			} else if ($this->getVendor() == self::oracle) {
				$sql = "
				UPDATE	DEPARTMENT
				SET 	ISDEFAULT		=	\"" . $this->model->getIsDefault(0,'single') . "\",
					ISNEW			=	\"" . $this->model->getIsNew(0,'single') . "\",
					ISDRAFT			=	\"" . $this->model->getIsDraft(0,'single') . "\",
					ISUPDATE		=	\"" . $this->model->getIsUpdate(0,'single') . "\",
					ISDELETE		=	\"" . $this->model->getIsDelete(0,'single') . "\",
					ISACTIVE		=	\"" . $this->model->getIsActive(0,'single') . "\",
					ISAPPROVED		=	\"" . $this->model->getIsApproved(0,'single') . "\",
					EXECUTEBY				=	\"" . $this->model->getExecuteBy() . "\",
					EXECUTETIME			=	" . $this->model->getExecuteTime() . "
			WHERE 	DEPARTMENTID		IN	(" . $this->model->getStaffIdAll() . ")";
			}
		} else if ($this->isAdmin == 1) {
			if ($this->getVendor() == self::mysql) {
				$sql = "
				UPDATE `" . $this->model->getTableName() . "`
				SET";
			} else if ($this->getVendor() == self::mssql) {
				$sql = "
			UPDATE 	[" . $this->model->getTableName() . "]
			SET 	";
			} else if ($this->getVendor() == self::oracle) {
				$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
			}
			//	echo "arnab[".$this->model->getDepartmentId(0,'array')."]";

			/**
			 *	System Validation Checking
			 *  @var $access
			 */
			$access = array(
                "isDefault",
                "isNew",
                "isDraft",
                "isUpdate",
                "isDelete",
                "isActive",
                "isApproved"
                );
                foreach ($access as $systemCheck) {
                	if ($this->getVendor() == self::mysql) {
                		$sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
                	} else if ($this->getVendor() == self::mssql) {
                		$sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
                	} else if ($this->getVendor() == self::oracle) {
                		$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                	}
                	switch ($systemCheck) {
                		case 'isDefault':
                			for ($i = 0; $i < $loop; $i++) {
                				$sqlLooping .= "
							WHEN '". $this->model->getStaffId($i, 'array') ."'
							THEN '". $this->model->getIsDefault($i, 'array') ."'";
                			}
                			break;
                		case 'isNew':
                			for ($i = 0; $i < $loop; $i++) {
                				$sqlLooping .= "
							WHEN '". $this->model->getStaffId($i, 'array') ."'
							THEN '". $this->model->getIsNew($i, 'array') ."'";
                			}
                			break;
                		case 'isDraft':
                			for ($i = 0; $i < $loop; $i++) {
                				$sqlLooping .= "
							WHEN '". $this->model->getStaffId($i, 'array') ."'
							THEN '". $this->model->getIsDraft($i, 'array') ."'";
                			}
                			break;
                		case 'isUpdate':
                			for ($i = 0; $i < $loop; $i++) {
                				$sqlLooping .= "
							WHEN '". $this->model->getStaffId($i, 'array') ."'
							THEN '". $this->model->getIsUpdate($i, 'array') ."'";
                			}
                			break;
                		case 'isDelete':
                			for ($i = 0; $i < $loop; $i++) {
                				$sqlLooping .= "
							WHEN '". $this->model->getStaffId($i, 'array') ."'
							THEN '". $this->model->getIsDelete($i, 'array') ."'";
                			}
                			break;
                		case 'isActive':
                			for ($i = 0; $i < $loop; $i++) {
                				$sqlLooping .= "
							WHEN '". $this->model->getStaffId($i, 'array') ."'
							THEN '". $this->model->getIsActive($i, 'array') ."'";
                			}
                			break;
                		case 'isApproved':
                			for ($i = 0; $i < $loop; $i++) {
                				$sqlLooping .= "
							WHEN '". $this->model->getStaffId($i, 'array') ."'
							THEN '". $this->model->getIsApproved($i, 'array') ."'";
                			}
                			break;
                	}
                	$sqlLooping .= " END,";
                }
                $sql .= substr($sqlLooping, 0, -1);
                if ($this->getVendor() == self::mysql) {
                	$sql .= "
			WHERE `" . $this->model->getPrimaryKeyName() . "` IN (" . $this->model->getStaffIdAll() . ")";
                } else if ($this->getVendor() == self::mssql) {
                	$sql .= "
			WHERE `=[" . $this->model->getPrimaryKeyName() . "] IN (" . $this->model->getStaffIdAll() . ")";
                } else if ($this->getVendor() == self::oracle) {
                	$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "\" IN (" . $this->model->getStaffIdAll() . ")";
                }
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		$this->q->commit();
		echo json_encode(array(
            "success" => true,
            "message" => "Deleted"
            ));
            exit();
	}
	/**
	 *  To check if a key duplicate or not
	 */
	function duplicate()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
			SELECT	*
			FROM 	`staff`
			WHERE 	`staffNo` 	= 	\"" . $this->model->getStaffNo() . "\"
			AND		`isActive`		=	1";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			SELECT	*
			FROM 	[staff]
			WHERE 	[staffNo] 		= 	'" . $this->model->getStaffNo() . "'
			AND		[isActive]		=	1";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT	*
			FROM 	STAFF
			WHERE 	STAFFNO 		=	 '" . $this->model->getStaffNo() . "'
			AND		ISACTIVE		=	1";
		}
		$this->q->read($sql);
		$total = 0;
		$total = $this->q->numberRows();
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		} else {
			$row = $this->q->fetchArray();
			if ($this->duplicateTest == 1) {
				return $total . "|" . $row['staffNo'];
			} else {
				echo json_encode(array(
                    "success" => "true",
                    "total" => $total,
                    "message" => "Duplicate Record",
                    "staffNo" => $row['staffNo']
				));
				exit();
			}
		}
	}



	/**
	 * Enter description here ...
	 */
	public function group()
	{
		$this->security->group();

	}
	public function department()
	{
		$this->security->department();
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	public function excel()
	{
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($_SESSION['start'] == 0) {
			$sql = str_replace("LIMIT", "", $_SESSION['sql']);
			$sql = str_replace($_SESSION['start'] . "," . $_SESSION['limit'], "", $sql);
		} else {
			$sql = $_SESSION['sql'];
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => "false",
                "message" => $this->q->responce
			));
			exit();
		}
		$this->excel->setActiveSheetIndex(0);
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array(
            'borders' => array(
                'inside' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => '000000'
                        )
                        ),
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => '000000'
                        )
                        )
                        )
                        );
                        // header all using  3 line  starting b
                        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                        $this->excel->getActiveSheet()->setCellValue('B2', $this->title);
                        $this->excel->getActiveSheet()->setCellValue('D2', '');
                        $this->excel->getActiveSheet()->mergeCells('B2:D2');
                        $this->excel->getActiveSheet()->setCellValue('B3', 'No');
                        $this->excel->getActiveSheet()->setCellValue('C3', 'Nama');
                        $this->excel->getActiveSheet()->setCellValue('D3', 'Kumpulan');
                        $this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
                        $this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');
                        //
                        $loopRow = 4;
                        $i       = 0;
                        while ($row = $this->q->fetchAssoc()) {
                        	//	echo print_r($row);
                        	$this->excel->getActiveSheet()->setCellValue('B' . $loopRow, ++$i);
                        	$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, $row['staffName']);
                        	$this->excel->getActiveSheet()->setCellValue('D' . $loopRow, $row['groupNote']);
                        	$loopRow++;
                        	$lastRow = 'D' . $loopRow;
                        }
                        $from    = 'B2';
                        $to      = $lastRow;
                        $formula = $from . ":" . $to;
                        $this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
                        $filename  = "staff.xlsx";
                        $objWriter->save($_SERVER['document_root'] . "/idcmsCore/management/document/excel/" . $filename);
                        $file = fopen($_SERVER['document_root'] . "/idcmsCore/management/document/excel/" . $filename, 'r');
                        if ($file) {
                        	echo json_encode(array(
                "success" => "true",
                "message" => "File generated"
                ));
                        } else {
                        	echo json_encode(array(
                "success" => "false",
                "message" => "File not generated"
                ));
                        }
	}
}
$staffObject = new staffClass();
/**
 *	crud -create,read,update,delete
 **/
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST['leafId'])) {
		$staffObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST['isAdmin'])) {
		$staffObject->setIsAdmin($_POST['isAdmin']);
	}
	/*
	 * Filtering
	 */
	if (isset($_POST['query'])) {
		$staffObject->setFieldQuery($_POST['query']);
	}
	if (isset($_POST['filter'])) {
		$staffObject->setGridQuery($_POST['filter']);
	}
	/*
	 *
	 */
	if (isset($_POST['order'])) {
		$staffObject->setOrder($_POST['order']);
	}
	if (isset($_POST['sortField'])) {
		$staffObject->setSortField($_POST['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$staffObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST['method'] == 'create') {
		$staffObject->create();
	}
	if ($_POST['method'] == 'read') {
		$staffObject->read();
	}
	if ($_POST['method'] == 'save') {
		$staffObject->update();
	}
	if ($_POST['method'] == 'delete') {
		$staffObject->delete();
	}
}
if (isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_GET['leafId'])) {
		$staffObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET['isAdmin'])) {
		$staffObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$staffObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$staffObject->staff();
		}
		if ($_GET['field'] == 'group') {
			$staffObject->group();
		}
		if ($_GET['field'] == 'department') {
			$staffObject->department();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET['method'] == 'updateStatus') {
		$staffObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET['staffNo'])) {
		if (strlen($_GET['staffNo']) > 0) {
			$staffObject->duplicate();
		}
	}
	/*
	 *  Excel Reporting
	 */
	if (isset($_GET['mode'])) {
		if ($_GET['mode'] == 'excel') {
			$staffObject->excel();
		}
	}
}
?>



