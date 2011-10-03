<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../model/crewModel.php");
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
class CrewClass extends ConfigClass
{
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
	 * Class Loader
	 */
	function execute ()
	{
		parent::__construct();
		$this->q = new Vendor();
		$this->q->vendor = $this->getVendor();
		$this->q->leafId = $this->getLeafId();
		$this->q->staffId = $this->getStaffId();
		$this->q->fieldQuery = $this->getFieldQuery();
		$this->q->gridQuery = $this->getGridQuery();
		$this->q->connect($this->getConnection(), $this->getUsername(),
		$this->getDatabase(), $this->getPassword());
		$this->excel = new PHPExcel();
		$this->audit = 0; // By Default 0 - Off  1 - On
		$this->log = 1; // By Default 0 - Off  1 - On
		$this->q->log = $this->log;
		$this->model = new CrewModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();
		$this->documentTrail = new DocumentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->setStaffId($this->getStaffId());
		$this->documentTrail->setLanguageId($this->getLanguageId());
		$this->documentTrail->setLeafId($this->getLeafId());
		$this->documentTrail->execute();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create ()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->create();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			INSERT INTO `crew`
					(
						`crewSequence`,				`crewCode`,
						`crewNote`,					`isDefault`,
						`isNew`,					`isDraft`,
						`isUpdate`,					`isDelete`,
						`isActive`,					`isApproved`,
						`isReview`,					`isPost`,
						`executeBy`,				`executeTime`
					)
			VALUES
					(
						\"" .
			$this->model->getCrewSequence() . "\",					\"" .
			$this->model->getCrewCode() .
             "\",
						\"" .
			$this->model->getCrewNote() . "\",						\"" .
			$this->model->getIsDefault(0, 'single') .
             "\",
						\"" .
			$this->model->getIsNew(0, 'single') . "\",					\"" .
			$this->model->getIsDraft(0, 'single') .
             "\",
						\"" .
			$this->model->getIsUpdate(0, 'single') . "\",				\"" .
			$this->model->getIsDelete(0, 'single') .
             "\",
						\"" .
			$this->model->getIsActive(0, 'single') . "\",				\"" .
			$this->model->getIsApproved(0, 'single') .
             "\",
						\"" .
			$this->model->getExecuteBy() . "\",								" .
			$this->model->getExecuteTime() . "
					);";
		} else
		if ($this->getVendor() == self::mssql) {
			$sql = "
			INSERT INTO [crew]
					(
						[crewSequence],				[crewCode],
						[crewNote],					[isDefault],
						[isNew],							[isDraft],
						[isUpdate],							[isDelete],
						[isActive],							[isApproved],
						
						[executeBy],								[executeTime]
					)
			VALUES
					(
						'" .
			$this->model->getCrewSequence() . "',			'" .
			$this->model->getCrewCode() .
                 "',
						'" .
			$this->model->getCrewNote() . "',				'" .
			$this->model->getIsDefault(0, 'single') .
                 "',
						'" .
			$this->model->getIsNew(0, 'single') . "',		'" .
			$this->model->getIsDraft(0, 'single') .
                 "',
						'" .
			$this->model->getIsUpdate(0, 'single') . "',		'" .
			$this->model->getIsDelete(0, 'single') .
                 "',
						'" .
			$this->model->getIsActive(0, 'single') . "',		'" .
			$this->model->getIsApproved(0, 'single') .
                 "',
						'" .
			$this->model->getExecuteBy() . "',				" .
			$this->model->getExecuteTime() . "
					);";
		} else
		if ($this->getVendor() == self::oracle) {
			$sql = "
			INSERT INTO GROUP_
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
						'" .
			$this->model->getCrewSequence() . "',			'" .
			$this->model->getCrewCode() .
                     "',
						'" .
			$this->model->getCrewNote() . "',				'" .
			$this->model->getIsDefault(0, 'single') .
                     "',
						'" .
			$this->model->getIsNew(0, 'single') . "',		'" .
			$this->model->getIsDraft(0, 'single') .
                     "',
						'" .
			$this->model->getIsUpdate(0, 'single') . "',		'" .
			$this->model->getIsDelete(0, 'single') .
                     "',
						'" .
			$this->model->getIsActive(0, 'single') . "',		'" .
			$this->model->getIsApproved(0, 'single') .
                     "',
						'" .
			$this->model->getExecuteBy() . "',				" .
			$this->model->getExecuteTime() . "
					);";
		}
		$this->q->create($sql);
		// take from last insert id
		$lastInsertId = $this->q->lastInsertId();
		// loop the tab and create new record
		//** no need to log in db
		if ($this->getVendor() == self::mysql) {
			$sql = "
		SELECT 	*
		FROM 	`module`
		WHERE 	`isActive`=1";
		} else
		if ($this->getVendor() == self::mssql) {
			$sql = "
		SELECT 	*
		FROM 	[module]
		WHERE 	[isActive]=1";
		} else
		if ($this->getVendor() == self::oracle) {
			$sql = "
		SELECT 	*
		FROM 	MODULE
		WHERE 	ISACTIVE=1";
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$data = $this->q->activeRecord();
		$sqlLooping = null;
		if ($this->q->numberRows() > 0) {
			foreach ($data as $row) {
				if ($this->getVendor() == self::mysql) {
					$sqlLooping .= "
					(
									\"" . $row['tabId'] . "\",
									0,
									\"" . $lastInsertId . "\"
					),";
				} else
				if ($this->getVendor() == self::mssql ||
				$this->getVendor() == self::oracle) {
					$sqlLooping .= "
					(
									'" . $row['tabId'] . "',
									0,
									'" . $lastInsertId . "'
					),";
				}
			}
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "	INSERT INTO	`moduleAccess`
				(
									`moduleId`,
									`moduleAccessValue`,
									`crewId`
				)
				VALUES ";
		} else
		if ($this->getVendor() == self::mssql) {
			$sql = "	INSERT INTO	[moduleAccess]
				(
									[moduleId],
									[moduleAccessValue],
									[crewId]
				)
				VALUES ";
		} else
		if ($this->getVendor() == self::oracle) {
			$sql = "	INSERT INTO	TABACCESS
				(
									MODULEID,
									MODULEACCESSVALUE,
									GROUPID
				)
				VALUES ";
		}
		$sqlLooping .= substr($sqlLooping, 0, - 1);
		$sql .= $sqlLooping;
		$this->q->create($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		// loop the folder and create new record;
		if ($this->getVendor() == self::mysql) {
			$sql = "
		SELECT 	*
		FROM 	`folder`
		WHERE 	`isActive`=1";
		} else
		if ($this->getVendor() == self::mssql) {
			$sql = "
		SELECT 	*
		FROM 	[folder]
		WHERE 	[isActive]=1";
		} else
		if ($this->getVendor() == self::oracle) {
			$sql = "
		SELECT 	*
		FROM 	FOLDER
		WHERE 	ISACTIVE=1";
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$sqlLooping = null;
		if ($this->q->numberRows() > 0) {
			$data = $this->q->activeRecord();
			foreach ($data as $row) {
				if ($this->getVendor() == self::mysql) {
					$sqlLooping .= "
					(
						\"" . $row['folderId'] . "\",
						0,
						\"" . $lastInsertId . "\"
					),";
				} else
				if ($this->getVendor() == self::mssql ||
				$this->getVendor() == self::oracle) {
					$sqlLooping .= "
					(
						'" . $row['folderId'] . "',
						0,
						'" . $lastInsertId . "'
					),";
				}
			}
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
					INSERT INTO 	`folderAccess`
								(
									`folderId`,
									`folderAccessValue`,
									`crewId`
								)
					VALUES";
		} else
		if ($this->getVendor() == self::mssql) {
			$sql = "
					INSERT INTO 	[folderAccess]
								(
									[folderId],
									[folderAccessValue],
									[crewId]
								)
					";
		} else
		if ($this->getVendor() == self::oracle) {
			$sql = "
					INSERT INTO 	FOLDERACCESS
								(
									FOLDERID,
									FOLDERACCESSVALUE,
									GROUPID
								)
					VALUES ";
		}
		$sqlLooping .= substr($sqlLooping, 0, - 1);
		$sql .= $sqlLooping;
		$this->q->create($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		// create a template access which user can access to
		if ($this->getVendor() == self::mysql) {
			$sql = "SELECT * FROM `leaf` WHERE `isActive`=1  ";
		} else
		if ($this->getVendor() == self::mssql) {
			$sql = "SELECT * FROM [leaf] WHERE [isActive]=1  ";
		} else
		if ($this->getVendor() == self::oracle) {
			$sql = "SELECT * FROM LEAF WHERE ISACTIVE=1  ";
		}
		$this->q->read($sql);
		$sqlLooping = null;
		$total = $this->q->numberRows();
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		if ($total > 0) {
			$data = $this->q->activeRecord();
			foreach ($data as $row) {
				if ($this->getVendor() == self::mysql) {
					$sqlLooping .= "
					(
						\"" . $row['leafId'] . "\",
						0,
						0,
						0,
						0,
						0,
						0,
						\"" . $lastInsertId . "\"
					),";
				} else
				if ($this->getVendor() == self::mssql ||
				$this->getVendor() = self::oracle) {
					$sqlLooping .= "
					(
						'" . $row['leafId'] . "',
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
		if ($this->getVendor() == self::mysql) {
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
									`crewId`
								)
					VALUES";
		} else
		if ($this->getVendor() == self::mssql) {
			$sql = "
					INSERT INTO 	[leafCrewAccess]
								(	[leafId],
									[leafAccessReadValue],
									[leafAccessCreateValue],
									[leafAccessUpdateValue],
									[leafAccessDeleteValue],
									[leafAccessPrintValue],
									[leafAccessPostValue],
									[crewId]
								)
					VALUES";
		} else
		if ($this->getVendor() == self::oracle) {
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
									GROUPID
								)
					VALUES ";
		}
		$sqlLooping .= substr($sqlLooping, 0, - 1);
		$sql .= $sqlLooping;
		$this->q->create($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success" => "true",
        "message" => "Record Created"));
		exit();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read ()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->isAdmin == 0) {
			if ($this->getVendor() == self::mysql) {
				$this->auditFilter = "	`crew`.`isActive`		=	1	";
			} else
			if ($this->q->vendor == self::mssql) {
				$this->auditFilter = "	[crew].[isActive]		=	1	";
			} else
			if ($this->q->vendor == self::oracle) {
				$this->auditFilter = "	GROUP_.ISACTIVE	=	1	";
			}
		} else
		if ($this->isAdmin == 1) {
			if ($this->getVendor() == self::mysql) {
				$this->auditFilter = "	 1 = 1 ";
			} else
			if ($this->q->vendor == self::mssql) {
				$this->auditFilter = "	1 = 1 ";
			} else
			if ($this->q->vendor == self::oracle) {
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
					SELECT	`crew`.`crewId`,
							`crew`.`crewSequence`,
							`crew`.`crewCode`,
							`crew`.`crewNote`,
							`crew`.`isDefault`,
							`crew`.`isNew`,
							`crew`.`isDraft`,
							`crew`.`isUpdate`,
							`crew`.`isDelete`,
							`crew`.`isActive`,
							`crew`.`isApproved`,
							`crew`.`executeBy`,
							`crew`.`executeTime`,
							`staff`.`staffName`
 					FROM 	`crew`
					JOIN	`staff`
					ON		`crew`.`executeBy` = `staff`.`staffId`
					WHERE 	" . $this->auditFilter;
			if ($this->model->getCrewId(0, 'single')) {
				$sql .= " AND `" . $this->model->getTableName() . "`." .
				$this->model->getPrimaryKeyName() . "`=\"" .
				$this->model->getCrewId(0, 'single') . "\"";
			}
		} else
		if ($this->getVendor() == self::mssql) {
			$sql = "
					SELECT	[crew].[crewId],
							[crew].[crewSequence],
							[crew].[crewCode],
							[crew].[crewNote],
							[crew].[isDefault],
							[crew].[isNew],
							[crew].[isDraft],
							[crew].[isUpdate],
							[crew].[isDelete],
							[crew].[isActive],
							[crew].[isApproved],
							[crew].[executeBy],
							[crew].[executeTime],
							[staff].[staffName]
					FROM 	[crew]
					JOIN	[staff]
					ON		[crew].[executeBy] = [staff].[staffId]
					WHERE 	[crew].[isActive] ='1'	";
			if ($this->model->getCrewId(0, 'single')) {
				$sql .= " AND [" . $this->model->getTableName() . "].[" .
				$this->model->getPrimaryKeyName() . "]='" .
				$this->model->getCrewId(0, 'single') . "'";
			}
		} else
		if ($this->getVendor() == self::oracle) {
			$sql = "
					SELECT	GROUP_.GROUPID  		AS	\"crewId\",
							GROUP_.GROUPCODE 		AS 	\"crewCode\",
							GROUP_.GROUPSEQUENCE	AS 	\"crewSequence\",
							GROUP_.GROUPNOTE 		AS 	\"crewNote\",
							GROUP_.ISDEFAULT 		AS 	\"isDefault\",
							GROUP_.ISNEW 			AS 	\"isNew\",
							GROUP_.ISDRAFT 			AS 	\"isDraft\",
							GROUP_.ISUPDATE 		AS 	\"isUpdate\",
							GROUP_.ISDELETE 		AS 	\"isDelete\",
							GROUP_.ISACTIVE 		AS 	\"isActive\",
							GROUP_.ISAPPROVED 		AS 	\"isApproved\",
							GROUP_.EXECUTEBY 		AS 	\"executeBy\",
							GROUP_.EXECUTETIME 		AS 	\"executeTime\",
							STAFF.STAFFNAME 		AS 	\"staffName\"
					FROM 	GROUP_
					JOIN	STAFF
					ON		GROUP_.EXECUTEBY = STAFF.STAFFID
					WHERE 	ISACTIVE='1'	";
			if ($this->model->getcrewId(0, 'single')) {
				$sql .= " AND '" .
				strtoupper($this->model->getTableName()) . "'.'" .
				strtoupper($this->model->getPrimaryKeyName()) . "'='" .
				$this->model->getCrewId(0, 'single') . "'";
			}
		} else {
			echo json_encode(
			array("success" => false,
                    "message" => "Undefine Database Vendor"));
			exit();
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array('crewId');
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array('crew');
		if ($this->getFieldQuery()) {
			if ($this->getVendor() == self::mysql) {
				$sql .= $this->q->quickSearch($tableArray, $filterArray);
			} else
			if ($this->getVendor() == self::mssql) {
				$tempSql = $this->q->quickSearch($tableArray, $filterArray);
				$sql .= $tempSql;
			} else
			if ($this->getVendor() == self::oracle) {
				$tempSql = $this->q->quickSearch($tableArray,
				$filterArray);
				$sql .= $tempSql;
			}
		}
		/**
		 * Extjs filtering mode
		 */
		if ($this->getGridQuery()) {
			if ($this->getVendor() == self::mysql) {
				$sql .= $this->q->searching();
			} else
			if ($this->getVendor() == self::mssql) {
				$tempSql2 = $this->q->searching();
				$sql .= $tempSql2;
			} else
			if ($this->getVendor() == self::oracle) {
				$tempSql2 = $this->q->searching();
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
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$total = $this->q->numberRows();
		if ($this->getOrder() && $this->getSortField()) {
			if ($this->getVendor() == self::mysql) {
				$sql .= "	ORDER BY `" . $this->getSortField() . "` " .
				$this->getOrder() . " ";
			} else
			if ($this->getVendor() == self::mssql) {
				$sql .= "	ORDER BY [" . $this->getSortField() . "] " .
				$this->getOrder() . " ";
			} else
			if ($this->getVendor() == self::oracle) {
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) .
                         "  " . strtoupper($this->getOrder()) . " ";
			}
		}
		$_SESSION['sql'] = $sql; // push to session so can make report via excel and pdf
		$_SESSION['start'] = $this->getStart();
		$_SESSION['limit'] = $this->getLimit();
		if (empty($this->filter)) {
			if ($this->getLimit()) {
				// only mysql have limit
				if ($this->getVendor() == self::mysql) {
					$sql .= " LIMIT  " . $this->getStart() . "," .
					$this->getLimit() . " ";
				} else
				if ($this->getVendor() == self::mssql) {
					/**
					 * Sql Server and Oracle used row_number
					 * Parameterize Query We don't support
					 */
					$sql = "
							WITH [crewDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [crewId]) AS 'RowNumber'
								FROM [crew]
								WHERE [isActive] =1   " . $tempSql .
					$tempSql2 . "
							)
							SELECT		[crew].[crewId],
										[crew].[crewSequence],
										[crew].[crewCode],
										[crew].[crewNote],
										[crew].[isDefault],
										[crew].[isNew],
										[crew].[isDraft],
										[crew].[isUpdate],
										[crew].[isDelete],
										[crew].[isApproved],
										[crew].[executeBy],
										[crew].[executeTime],
										[staff].[staffName]
							FROM 		[crewDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $this->getStart() . "
							AND 			" .
					($this->getStart() + $this->getLimit() - 1) . ";";
				} else
				if ($this->getVendor() == self::oracle) {
					/**
					 * Oracle using derived table also
					 */
					$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT GROUP_.GROUPID  		AS	\"crewId\",
							GROUP_.GROUPCODE 		AS 	\"crewCode\",
							GROUP_.GROUPSEQUENCE	AS 	\"crewSequence\",
							GROUP_.GROUPNOTE 		AS 	\"crewNote\",
							GROUP_.ISDEFAULT 		AS 	\"isDefault\",
							GROUP_.ISNEW 			AS 	\"isNew\",
							GROUP_.ISDRAFT 			AS 	\"isDraft\",
							GROUP_.ISUPDATE 		AS 	\"isUpdate\",
							GROUP_.ISDELETE 		AS 	\"isDelete\",
							GROUP_.ISACTIVE 		AS 	\"isActive\",
							GROUP_.ISAPPROVED 		AS 	\"isApproved\",
							GROUP_.EXECUTEBY 		AS 	\"executeBy\",
							GROUP_.EXECUTETIME 		AS 	\"executeTime\",
							STAFF.STAFFNAME 		AS 	\"staffName\"
									FROM 	GROUP_
									WHERE ISACTIVE=1  " . $tempSql . $tempSql2 . "
								 ) a
						where rownum <= \"" .
					($this->getStart() + $this->getLimit() - 1) . "\" )
						where r >=  \"" . $this->getStart() . "\"";
				} else {
					echo "undefine vendor";
					exit();
				}
			}
		}
		/*
		 *  Only Execute One Query
		 */
		if (! ($this->model->getcrewId(0, 'single'))) {
			$this->q->read($sql);
			if ($this->q->execute == 'fail') {
				echo json_encode(
				array("success" => false, "message" => $this->q->responce));
				exit();
			}
		}
		$items = array();
		while (($row = $this->q->fetchAssoc()) == TRUE) {
			$items[] = $row;
		}
		if ($this->model->getCrewId(0, 'single')) {
			$json_encode = json_encode(
			array('success' => true, 'total' => $total,
            'message' => 'Data Loaded', 'data' => $items));
			$json_encode = str_replace("[", "", $json_encode);
			$json_encode = str_replace("]", "", $json_encode);
			echo $json_encode;
		} else {
			if (count($items) == 0) {
				$items = '';
			}
			echo json_encode(
			array('success' => true, 'total' => $total,
            'message' => 'data loaded', 'data' => $items));
			exit();
		}
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update ()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->commit();
		$this->model->update();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE 	`crew`
			SET 	`crewSequence` =   '" .
			$this->model->getCrewSequence() . "',
					`crewCode`		=	'" .
			$this->model->getCrewCode() . "',
					`crewNote`		=	'" .
			$this->model->getCrewNote() . "',
					`isDefault`		=	'" .
			$this->model->getIsDefault(0, 'single') . "',
					`isNew`			=	'" .
			$this->model->getIsNew(0, 'single') . "',
					`isDraft`		=	'" .
			$this->model->getIsDraft(0, 'single') . "',
					`isUpdate`		=	'" .
			$this->model->getIsUpdate(0, 'single') . "',
					`isDelete`		=	'" .
			$this->model->getIsDelete(0, 'single') . "',
					`isActive`		=	'" .
			$this->model->getIsActive(0, 'single') . "',
					`isApproved`	=	'" .
			$this->model->getIsApproved(0, 'single') . "',
					`executeBy`		=	'" .
			$this->model->getExecuteBy() . "',
					`executeTime`	=	" .
			$this->model->getExecuteTime() . "
			WHERE 	`crewId`		=	'" .
			$this->model->getCrewId(0, 'single') . "'";
		} else
		if ($this->getVendor() == self::mssql) {
			$sql = "
			UPDATE 	[crew]
			SET 	[crewSequence] =   '" .
			$this->model->getCrewSequence() . "',
					[crewCode]		=	'" .
			$this->model->getCrewCode() . "',
					[crewNote]		=	'" .
			$this->model->getCrewNote() . "',
					[isDefault]		=	'" .
			$this->model->getIsDefault(0, 'single') . "',
					[isNew]			=	'" .
			$this->model->getIsNew(0, 'single') . "',
					[isDraft]		=	'" .
			$this->model->getIsDraft(0, 'single') . "',
					[isUpdate]		=	'" .
			$this->model->getIsUpdate(0, 'single') . "',
					[isDelete]		=	'" .
			$this->model->getIsDelete(0, 'single') . "',
					[isActive]		=	'" .
			$this->model->getIsActive(0, 'single') . "',
					[isApproved]	=	'" .
			$this->model->getIsApproved(0, 'single') . "',
					[executeBy]		=	'" .
			$this->model->getExecuteBy() . "',
					[executeTime]	=	" .
			$this->model->getExecuteTime() . "
			WHERE 	[crewId]		=	'" .
			$this->model->getCrewId(0, 'single') . "'";
		} else
		if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	GROUP_
			SET 	GROUPSEQUENCE	=   '" .
			$this->model->getCrewSequence() . "',
					GROUPCODE		=	'" .
			$this->model->getCrewCode() . "',
					GROUPNOTE		=	'" .
			$this->model->getCrewNote() . "',
					ISACTIVE		=	'" .
			$this->model->getIsActive(0, 'single') . "',
					ISNEW			=	'" .
			$this->model->getIsNew(0, 'single') . "',
					ISDRAFT			=	'" .
			$this->model->getIsDraft(0, 'single') . "',
					ISUPDATE		=	'" .
			$this->model->getIsUpdate(0, 'single') . "',
					ISDELETE		=	'" .
			$this->model->getIsDelete(0, 'single') . "',
					ISAPPROVED		=	'" .
			$this->model->getIsApproved(0, 'single') . "',
					EXECUTEBY		=	'" .
			$this->model->getExecuteBy() . "',
					EXECUTETIME		=	" .
			$this->model->getExecuteTime() . "
			WHERE 	GROUPID			=	'" .
			$this->model->getCrewCode(0, 'single') . "'";
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success" => true, "message" => "Record Update"));
		exit();
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete ()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->getVendor() == self::mysql) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->delete();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE 	`crew`
			SET 	`isDefault`			=	\"" .
			$this->model->getIsDefault(0, 'single') . "\",
					`isNew`				=	\"" .
			$this->model->getIsNew(0, 'single') . "\",
					`isDraft`			=	\"" .
			$this->model->getIsDraft(0, 'single') . "\",
					`isUpdate`			=	\"" .
			$this->model->getIsUpdate(0, 'single') . "\",
					`isDelete`			=	\"" .
			$this->model->getIsDelete(0, 'single') . "\",
					`isActive`			=	\"" .
			$this->model->getIsActive(0, 'single') . "\",
					`isApproved`		=	\"" .
			$this->model->getIsApproved(0, 'single') . "\",
					`executeBy`				=	\"" .
			$this->model->getExecuteBy() . "\",
					`executeTime`				=	" .
			$this->model->getExecuteTime() . "
			WHERE 	`crewId`		=	\"" .
			$this->model->getCrewId(0, 'single') . "\"";
		} else
		if ($this->getVendor() == self::mssql) {
			$sql = "
			UPDATE 	[crew]
			SET 	[isDefault]			=	'" .
			$this->model->getIsDefault(0, 'single') . "',
					[isNew]				=	'" .
			$this->model->getIsNew(0, 'single') . "',
					[isDraft]			=	'" .
			$this->model->getIsDraft(0, 'single') . "',
					[isUpdate]			=	'" .
			$this->model->getIsUpdate(0, 'single') . "',
					[isDelete]			=	'" .
			$this->model->getIsDelete(0, 'single') . "',
					[isActive]			=	'" .
			$this->model->getIsActive(0, 'single') . "',
					[isApproved]		=	'" .
			$this->model->getIsApproved(0, 'single') . "',
					[executeBy]			=	'" .
			$this->model->getExecuteBy() . "',
					[executeTime]		=	" .
			$this->model->getExecuteTime() . "
			WHERE 	[crewId]			=	'" .
			$this->model->getCrewId . "\"";
		} else
		if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	GROUP_
			SET 	GROUPDESC		=	'" .
			$this->model->getCrewDesc(0, 'single') . "',
					ISDEFAULT		=	'" .
			$this->model->getIsDefault(0, 'single') . "',
					ISNEW			=	'" .
			$this->model->getIsNew(0, 'single') . "',
					ISDRAFT			=	'" .
			$this->model->getIsDraft(0, 'single') . "',
					ISUPDATE		=	'" .
			$this->model->getIsUpdate(0, 'single') . "',
					ISDELETE		=	'" .
			$this->model->getIsDelete(0, 'single') . "',
					ISACTIVE		=	'" .
			$this->model->getIsActive(0, 'single') . "',
					ISAPPROVED		=	'" .
			$this->model->getIsApproved(0, 'single') . "',
					EXECUTEBY		=	'" .
			$this->model->getExecuteBy() . "',
					EXECUTETIME		=	" .
			$this->model->getExecuteTime() . "
			WHERE 	GROUPID			=	'" .
			$this->model->getCrewId() . "\"";
		}
		// advance logging future
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
		$this->q->primaryKeyValue = $this->model->getCrewId();
		$this->q->audit = $this->audit;
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => "false", "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(
		array("success" => true, "message" => "Deleted"));
		exit();
	}
	/**
	 * To Update flag Status
	 */
	function updateStatus ()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$loop = $this->model->getTotal();
		if ($this->getVendor() == self::mysql) {
			$sql = "
				UPDATE `" . $this->model->getTableName() . "`
				SET";
		} else
		if ($this->getVendor() == self::mssql) {
			$sql = "
			UPDATE 	[" . $this->model->getTableName() . "]
			SET 	";
		} else
		if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE  " . strtoupper($this->model->getTableName()) . "
			SET    ";
		}
		//	echo "arnab[".$this->model->getCrewId(0,'array')."]";
		/**
		 * System Validation Checking
		 * @var $access
		 */
		$access = array("isDefault", "isNew", "isDraft", "isUpdate", "isDelete",
        "isActive", "isApproved","isReview","isPost");
		foreach ($access as $systemCheck) {
			if ($this->getVendor() == self::mysql) {
				$sqlLooping .= " `" . $systemCheck . "` = CASE `" .
				$this->model->getPrimaryKeyName() . "`";
			} else
			if ($this->getVendor() == self::mssql) {
				$sqlLooping .= "  [" . $systemCheck . "] = CASE [" .
				$this->model->getPrimaryKeyName() . "]";
			} else
			if ($this->getVendor() == self::oracle) {
				$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE '" .
				$this->model->getPrimaryKeyName() . "'";
			}
			switch ($systemCheck) {
				case 'isDefault':
					for ($i = 0; $i < $loop; $i ++) {
						$sqlLooping .= "
							WHEN '" .
						$this->model->getCrewId($i, 'array') . "'
							THEN '" .
						$this->model->getIsDefault($i, 'array') . "'";
					}
					break;
				case 'isNew':
					for ($i = 0; $i < $loop; $i ++) {
						$sqlLooping .= "
							WHEN '" .
						$this->model->getCrewId($i, 'array') . "'
							THEN '" .
						$this->model->getIsNew($i, 'array') . "'";
					}
					break;
				case 'isDraft':
					for ($i = 0; $i < $loop; $i ++) {
						$sqlLooping .= "
							WHEN '" .
						$this->model->getCrewId($i, 'array') . "'
							THEN '" .
						$this->model->getIsDraft($i, 'array') . "'";
					}
					break;
				case 'isUpdate':
					for ($i = 0; $i < $loop; $i ++) {
						$sqlLooping .= "
							WHEN '" .
						$this->model->getCrewId($i, 'array') . "'
							THEN '" .
						$this->model->getIsUpdate($i, 'array') . "'";
					}
					break;
				case 'isDelete':
					for ($i = 0; $i < $loop; $i ++) {
						$sqlLooping .= "
							WHEN '" .
						$this->model->getCrewId($i, 'array') . "'
							THEN '" .
						$this->model->getIsDelete($i, 'array') . "'";
					}
					break;
				case 'isActive':
					for ($i = 0; $i < $loop; $i ++) {
						$sqlLooping .= "
							WHEN '" .
						$this->model->getCrewId($i, 'array') . "'
							THEN '" .
						$this->model->getIsActive($i, 'array') . "'";
					}
					break;
				case 'isApproved':
					for ($i = 0; $i < $loop; $i ++) {
						$sqlLooping .= "
							WHEN '" .
						$this->model->getCrewId($i, 'array') . "'
							THEN '" .
						$this->model->getIsApproved($i, 'array') . "'";
					}
					break;
				case 'isReview' :
					for($i = 0; $i < $loop; $i ++) {
						$sqlLooping .= "
                            WHEN '" . $this->model->getCrewId ( $i, 'array' ) . "'
                            THEN '" . $this->model->getIsReview ( $i, 'array' ) . "'";
					}
					break;
				case 'isPost' :
					for($i = 0; $i < $loop; $i ++) {
						$sqlLooping .= "
                                WHEN '" . $this->model->getCrewId ( $i, 'array' ) . "'
                                THEN '" . $this->model->getIsPost ( $i, 'array' ) . "'";
					}
					break;
			}
			$sqlLooping .= " END,";
		}
		$sql .= substr($sqlLooping, 0, - 1);
		if ($this->getVendor() == self::mysql) {
			$sql .= "
			WHERE `" .
			$this->model->getPrimaryKeyName() . "` IN (" .
			$this->model->getCrewIdAll() . ")";
		} else
		if ($this->getVendor() == self::mssql) {
			$sql .= "
			WHERE [" .
			$this->model->getPrimaryKeyName() . "] IN (" .
			$this->model->getCrewIdAll() . ")";
		} else
		if ($this->getVendor() == self::oracle) {
			$sql .= "
			WHERE \"" .
			$this->model->getPrimaryKeyName() . "\" IN (" .
			$this->model->getCrewIdAll() . ")";
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(
		array("success" => true, "message" => "Deleted"));
		exit();
	}
	/**
	 * To check if a key duplicate or not
	 */
	function duplicate ()
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
			FROM 	`crew`
			WHERE 	`crewCode` 	= 	\"" .
			$this->model->getCrewCode() . "\"
			AND		`isActive`		=	1";
		} else
		if ($this->getVendor() == self::mssql) {
			$sql = "
			SELECT	*
			FROM 	[crew]
			WHERE 	[crewCode] 	= 	'" .
			$this->model->getCrewCode() . "'
			AND		[isActive]		=	1";
		} else
		if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT	*
			FROM 	CREW_
			WHERE 	CREWCODE 		= 	'" .
			$this->model->getCrewCode() . "'
			AND		ISACTIVE		=	1";
		}
		$this->q->read($sql);
		$total = 0;
		$total = $this->q->numberRows();
		if ($this->q->execute == 'fail') {
			echo json_encode(
			array("success" => false, "message" => $this->q->responce));
			exit();
		} else {
			$row = $this->q->fetchArray();
			if ($this->duplicateTest == 1) {
				return $total . "|" . $row['crewCode'];
			} else {
				echo json_encode(
				array("success" => "true", "total" => $total,
                "message" => "Duplicate Record", 
                "crewCode" => $row['crewCode']));
				exit();
			}
		}
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel ()
	{}
}
$crewObject = new CrewClass();
/**
 * crud -create,read,update,delete
 **/
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST['leafId'])) {
		$crewObject->setLeafId($_POST['leafId']);
	}
	if (isset($_POST['query'])) {
		$crewObject->setFieldQuery($_POST['query']);
	}
	if (isset($_POST['filter'])) {
		$crewObject->setGridQuery($_POST['filter']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST['order'])) {
		$crewObject->setOrder($_POST['order']);
	}
	if (isset($_POST['sortField'])) {
		$crewObject->setSortField($_POST['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$crewObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST['method'] == 'create') {
		$crewObject->create();
	}
	if ($_POST['method'] == 'read') {
		$crewObject->read();
	}
	if ($_POST['method'] == 'save') {
		$crewObject->update();
	}
	if ($_POST['method'] == 'delete') {
		$crewObject->delete();
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
		$crewObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET['isAdmin'])) {
		$crewObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$crewObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$crewObject->staff();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET['method'] == 'updateStatus') {
		$crewObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET['crewCode'])) {
		if (strlen($_GET['crewCode']) > 0) {
			$crewObject->duplicate();
		}
	}
	/*
	 * Excel Reporting
	 */
	if (isset($_GET['mode'])) {
		if ($_GET['mode'] == 'excel') {
			$crewObject->excel();
		}
	}
}
?>
