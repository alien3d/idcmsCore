<?php

session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../model/religionModel.php");

/**
 * this is religion setting files.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package religion
 * @subpackage religionv1,v2,v3,v4,v5
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ReligionClass extends ConfigClass {

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
	function execute() {
		parent::__construct();

		$this->q = new vendor();
		$this->q->vendor = $this->getVendor();
		$this->q->leafId = $this->getLeafId();
		$this->q->staffId = $this->getStaffId();
		$this->q->fieldQuery = $this->getFieldQuery();
		$this->q->gridQuery = $this->getGridQuery();
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->excel = new PHPExcel();

		$this->audit = 0;
		$this->log = 1;
		$this->q->log = $this->log;

		$this->model = new religionModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

		$this->documentTrail = new documentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->setStaffId($this->getStaffId());
		$this->documentTrail->setLanguageId($this->getLanguageId());
		$this->documentTrail->setLeafId($this->getLeafId());
		$this->documentTrail->execute();
	}

	/* (non-PHPdoc)
	 * @see config::create()
	 */

	public function create() {
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
			INSERT INTO `religion`
					(
						`religionDesc`,						`isDefault`,
						`isNew`,							`isDraft`,
						`isUpdate`,							`isDelete`,
						`isActive`,							`isApproved`,
						`executeBy`,								`executeTime`
					)
			VALUES
					(
						\"" . $this->model->getReligionDesc() . "\",	\"" . $this->model->getIsDefault(0, 'single') . "\",
						\"" . $this->model->getIsNew(0, 'single') . "\",			\"" . $this->model->getIsDraft(0, 'single') . "\",
						\"" . $this->model->getIsUpdate(0, 'single') . "\",		\"" . $this->model->getIsDelete(0, 'single') . "\",
						\"" . $this->model->getIsActive(0, 'single') . "\",		\"" . $this->model->getIsApproved(0, 'single') . "\",
						\"" . $this->model->getExecuteBy() . "\",				" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			INSERT INTO [religion]
					(
						[religionDesc],						[isDefault],
						[isNew],							[isDraft],
						[isUpdate],							[isDelete],
						[isActive],							[isApproved],
						[executeBy],						[executeTime]
					)
			VALUES
					(
						'" . $this->model->getReligionDesc() . "',				'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			INSERT INTO	RELIGION
					(
						RELIGIONDESC,					ISDEFAULT,
						ISNEW,							ISDRAFT,
						ISUPDATE,						ISDELETE,
						ISACTIVE,						ISAPPROVED,
						EXECUTEBY,						EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getReligionDesc() . "',			'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',		'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',	'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',	'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',				" . $this->model->getExecuteTime() . "
					)";
		}
		//advance logging future
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
		// $this->q->primaryKeyValue = $this->q->lastInsertId();  not use here

		$this->q->audit = $this->audit;
		$this->q->create($sql);
		$religionId = $this->q->lastInsertId();
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
            "message" => "Record Created",
            "religionId" => $religionId
		));
		exit();
	}

	/* (non-PHPdoc)
	 * @see config::read()
	 */

	public function read() {
		//	header('Content-Type', 'application/json; charset=utf-8');

		if ($this->isAdmin == 0) {
			if ($this->q->vendor == self::mysql) {

				$this->auditFilter = "	AND `religion`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	AND [religion].[isActive]		=	1	";
			} else if ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	AND RELIGION.ISACTIVE	=	1	";
			}
		} else if ($this->isAdmin == 1) {
			if ($this->getVendor() == self::mysql) {
				$this->auditFilter = "	1	=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	1	=	1 	";
			} else if ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	1	=	1 	";
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
					SELECT	`religion`.`religionId`,
							`religion`.`religionDesc`,
							`religion`.`isDefault`,
							`religion`.`isNew`,
							`religion`.`isDraft`,
							`religion`.`isUpdate`,
							`religion`.`isDelete`,
							`religion`.`isActive`,
							`religion`.`isApproved`,
							`religion`.`executeBy`,
							`religion`.`executeTime`,
							`staff`.`staffName`
 					FROM 	`religion`
					JOIN	`staff`
					ON		`religion`.`executeBy` = `staff`.`staffId`
					WHERE 	 " . $this->auditFilter;
			if ($this->model->getReligionId(0, 'single')) {
				$sql .= " AND `" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`=\"" . $this->model->getReligionId(0, 'single') . "\"";
			}
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
					SELECT	[religion].[religionId],
							[religion].[religionDesc],
							[religion].[isDefault],
							[religion].[isNew],
							[religion].[isDraft],
							[religion].[isUpdate],
							[religion].[isDelete],
							[religion].[isActive],
							[religion].[isApproved],
							[religion].[executeBy],
							[religion].[executeTime],
							[staff].[staffName]
					FROM 	[religion]
					JOIN	[staff]
					ON		[religion].[executeBy] = [staff].[staffId]
					WHERE 	".$this->auditFilter;
			if ($this->model->getReligionId(0, 'single')) {
				$sql .= " AND [" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]='" . $this->model->getReligionId(0, 'single') . "'";
			}
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT	RELIGION.RELIGIONID   		  AS 	\"religionId\",
							RELIGION.RELIGIONDESC AS 	\"religionDesc\",
							RELIGION.ISDEFAULT    AS	\"isDefault\",
							RELIGION.ISNEW		  AS	\"isNew\",
							RELIGION.ISDRAFT	  AS	\"isDraft\",
							RELIGION.ISUPDATE     AS	\"isUpdate\",
							RELIGION.ISDELETE	  AS	\"isDelete\",
							RELIGION.ISACTIVE	  AS	\"isActive\",
							RELIGION.ISAPPROVED   AS	\"isApproved\",
							RELIGION.EXECUTEBY    AS	\"executeBy\",
							RELIGION.EXECUTETIME  AS	\"executeTime\",
							STAFF.STAFFNAME		  AS	\"staffName\"	
					FROM 	RELIGION
					JOIN	STAFF
					ON		RELIGION.EXECUTEBY 	  	=	STAFF.STAFFID
					WHERE 	".$this->auditFilter;
			if ($this->model->getReligionId(0, 'single')) {
				$sql .= " AND " . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "='" . $this->model->getReligionId(0, 'single') . "'";
			}
		} else {
			echo json_encode(array(
                "success" => false,
                "message" => "Undefine Database Vendor"
                ));
                exit();
		}
		/**
		 * 	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array(
            'religionId'
            );
            /**
             * 	filter table
             * @variables $tableArray
             */
            $tableArray = null;
            $tableArray = array(
            'religion'
            );
            if ($this->quickFilter) {
            	if ($this->getVendor() == self::mysql) {
            		$sql .= $this->q->quickSearch($tableArray, $filterArray);
            	} else if ($this->getVendor() == self::mssql) {
            		$tempSql = $this->q->quickSearch($tableArray, $filterArray);
            		$sql .= $tempSql;
            	} else if ($this->getVendor() == self::oracle) {
            		$tempSql = $this->q->quickSearch($tableArray, $filterArray);
            		$sql .= $tempSql;
            	}
            }
            /**
             * 	Extjs filtering mode
             */
            if ($this->filter) {
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
            // optional debugger.uncomment if wanted to used
            //if ($this->q->execute == 'fail') {
            //	echo json_encode(array(
            //   "success" => false,
            //   "message" => $this->q->realEscapeString($sql)
            //	));
            //	exit();
            //}
            // end of optional debugger
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
            		$sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder() . " ";
            	} else if ($this->getVendor() == self::mssql) {
            		$sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
            	} else if ($this->getVendor() == self::oracle) {
            		$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
            	}
            }
            $_SESSION['sql'] = $sql; // push to session so can make report via excel and pdf
            $_SESSION['start'] = $this->getStart();
            $_SESSION['limit'] = $this->getLimit();
            if (empty($this->filter)) {

            	if ($this->getLimit()) {
            			
            		// only mysql have limit
            		if ($this->getVendor() == self::mysql) {
            			$sql .= " LIMIT  " . $this->getStart() . "," . $this->getLimit() . " ";
            		} else if ($this->getVendor() == self::mssql) {
            			/**
            			 * 	 Sql Server and Oracle used row_number
            			 * 	 Parameterize Query We don't support
            			 */
            			$sql = "
							WITH [religionDerived] AS
							(
								SELECT [religion].[religionId],
										[religion].[religionDesc],
										[religion].[isDefault],
										[religion].[isNew],
										[religion].[isDraft],
										[religion].[isUpdate],
										[religion].[isDelete],
										[religion].[isApproved],
										[religion].[executeBy],
										[religion].[executeTime],
										[staff].[staffName],
								ROW_NUMBER() OVER (ORDER BY [religionId]) AS 'RowNumber'
								FROM 	[religion]
								JOIN	[staff]
								ON		[religion].[executeBy] = [staff].[staffId]
								WHERE ".$this->auditFilter. $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[religionDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . ($this->getStart()+1) . "
							AND 			" . ($this->getStart() + $this->getLimit()) . ";";
            		} else if ($this->getVendor() == self::oracle) {
            			/**
            			 *  Oracle using derived table also
            			 */
            			$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
								SELECT	RELIGION.RELIGIONID   AS 	\"religionId\",
										RELIGION.RELIGIONDESC AS 	\"religionDesc\",
										RELIGION.ISDEFAULT    AS	\"isDefault\",
										RELIGION.ISNEW		  AS	\"isNew\",
										RELIGION.ISDRAFT	  AS	\"isDraft\",
										RELIGION.ISUPDATE     AS	\"isUpdate\",
										RELIGION.ISDELETE	  AS	\"isDelete\",
										RELIGION.ISACTIVE	  AS	\"isActive\",
										RELIGION.ISAPPROVED   AS	\"isApproved\",
										RELIGION.EXECUTEBY    AS	\"executeBy\",
										RELIGION.EXECUTETIME  AS	\"executeTime\",
										STAFF.STAFFNAME		  AS	\"staffName\"	
								FROM 	RELIGION
								JOIN	STAFF
								ON		RELIGION.EXECUTEBY 	  	=	STAFF.STAFFID
								WHERE 	".$this->auditFilter. $tempSql . $tempSql2 . $orderBy . "
								 ) a
						where rownum <= '" . ($this->getStart() + $this->getLimit()) . "' )
						where r >=  '" . ($this->getStart()+1) . "'";
            		} else {
            			echo "undefine vendor";
            			exit();
            		}
            	}
            }
            /*
             *  Only Execute One Query
             */
            if (!($this->model->getReligionId(0, 'single'))) {

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
            if ($this->model->getReligionId(0, 'single')) {
            	$json_encode = json_encode(array(
                'success' => true,
                'total' => $total,
                'message' => 'Data Loaded',
                'data' => $items,
				'firstRecord'=>$this->firstRecord('value'),
				'previousRecord'=>$this->previousRecord('value',$this->model->getReligionId(0, 'single')),
				'nextRecord'=>$this->nextRecord('value',$this->model->getReligionId(0, 'single')),
				'lastRecord'=>$this->lastRecord('value')
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

	function update() {
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->getVendor() == self::mysql) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
			if ($this->q->execute == 'fail') {
				echo json_encode(array(
                    "success" => false,
                    "message" => $this->q->responce
				));
				exit();
			}
		}
		$this->q->start();
		$this->model->update();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE 	`religion`
			SET 	`religionDesc`		=	\"" . $this->model->getReligionDesc() . "\",
					`isDefault`			=	\"" . $this->model->getIsDefault(0, 'single') . "\",
					`isNew`				=	\"" . $this->model->getIsNew(0, 'single') . "\",
					`isDraft`			=	\"" . $this->model->getIsDraft(0, 'single') . "\",
					`isUpdate`			=	\"" . $this->model->getIsUpdate(0, 'single') . "\",
					`isDelete`			=	\"" . $this->model->getIsDelete(0, 'single') . "\",
					`isActive`			=	\"" . $this->model->getIsActive(0, 'single') . "\",
					`isApproved`		=	\"" . $this->model->getIsApproved(0, 'single') . "\",
					`executeBy`			=	\"" . $this->model->getExecuteBy() . "\",
					`executeTime`		=	" . $this->model->getExecuteTime() . "
			WHERE 	`religionId`		=	\"" . $this->model->getReligionId(0, 'single') . "\"";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			UPDATE 	[religion]
			SET 	[religionDesc]		=	'" . $this->model->getReligionDesc() . "',
					[isDefault]			=	'" . $this->model->getIsDefault(0, 'single') . "',
					[isNew]				=	'" . $this->model->getIsNew(0, 'single') . "',
					[isDraft]			=	'" . $this->model->getIsDraft(0, 'single') . "',
					[isUpdate]			=	'" . $this->model->getIsUpdate(0, 'single') . "',
					[isDelete]			=	'" . $this->model->getIsDelete(0, 'single') . "',
					[isActive]			=	'" . $this->model->getIsActive(0, 'single') . "',
					[isApproved]		=	'" . $this->model->getIsApproved(0, 'single') . "',
					[executeBy]			=	'" . $this->model->getExecuteBy() . "',
					[executeTime]		=	" . $this->model->getExecuteTime() . "
			WHERE 	[religionId]		=	'" . $this->model->getReligionId(0, 'single') . "'";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	RELIGION
			SET 	RELIGIONDESC	=	'" . $this->model->getReligionDesc() . "',
					ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
					ISNEW			=	'" . $this->model->getIsNew(0, 'single') . "',
					ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
					ISUPDATE		=	'" . $this->model->getIsUpdate(0, 'single') . "',
					ISDELETE		=	'" . $this->model->getIsDelete(0, 'single') . "',
					ISACTIVE		=	'" . $this->model->getIsActive(0, 'single') . "',
					ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
					EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
					EXECUTETIME		=	" . $this->model->getExecuteTime() . "
			WHERE 	RELIGIONID		=	'" . $this->model->getReligionId(0, 'single') . "'";
		}
		/*
		 *  require three variable below to track  table audit
		 */
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
		$this->q->primaryKeyValue = $this->model->getReligionId(0,'single');
		$this->q->audit = $this->audit;
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
            "success" => "true",
            "message" => "Updated"
            ));
            exit();
	}

	/* (non-PHPdoc)
	 * @see config::delete()
	 */

	function delete() {
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
			UPDATE 	`religion`
			SET 	`isDefault`			=	\"" . $this->model->getIsDefault(0, 'single') . "\",
					`isNew`				=	\"" . $this->model->getIsNew(0, 'single') . "\",
					`isDraft`			=	\"" . $this->model->getIsDraft(0, 'single') . "\",
					`isUpdate`			=	\"" . $this->model->getIsUpdate(0, 'single') . "\",
					`isDelete`			=	\"" . $this->model->getIsDelete(0, 'single') . "\",
					`isActive`			=	\"" . $this->model->getIsActive(0, 'single') . "\",
					`isApproved`		=	\"" . $this->model->getIsApproved(0, 'single') . "\",
					`executeBy`			=	\"" . $this->model->getExecuteBy() . "\",
					`executeTime`		=	" . $this->model->getExecuteTime() . "
			WHERE 	`religionId`		=	\"" . $this->model->getReligionId(0, 'single') . "\"";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			UPDATE 	[religion]
			SET 	[isDefault]			=	'" . $this->model->getIsDefault(0, 'single') . "',
					[isNew]				=	'" . $this->model->getIsNew(0, 'single') . "',
					[isDraft]			=	'" . $this->model->getIsDraft(0, 'single') . "',
					[isUpdate]			=	'" . $this->model->getIsUpdate(0, 'single') . "',
					[isDelete]			=	'" . $this->model->getIsDelete(0, 'single') . "',
					[isActive]			=	'" . $this->model->getIsActive(0, 'single') . "',
					[isApproved]		=	'" . $this->model->getIsApproved(0, 'single') . "',
					[executeBy]			=	'" . $this->model->getExecuteBy() . "',
					[executeTime]		=	" . $this->model->getExecuteTime() . "
			WHERE 	[religionId]		=	'" . $this->model->getReligionId(0, 'single') . "'";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	RELIGION
			SET 	RELIGIONDESC	=	'" . $this->model->getReligionDesc(0, 'single') . "',
					ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
					ISNEW			=	'" . $this->model->getIsNew(0, 'single') . "',
					ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
					ISUPDATE		=	'" . $this->model->getIsUpdate(0, 'single') . "',
					ISDELETE		=	'" . $this->model->getIsDelete(0, 'single') . "',
					ISACTIVE		=	'" . $this->model->getIsActive(0, 'single') . "',
					ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
					EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
					EXECUTETIME		=	" . $this->model->getExecuteTime() . "
			WHERE 	RELIGIONID		=	'" . $this->model->getReligionId(0, 'single') . "'";
		}
		// advance logging future
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
		$this->q->primaryKeyValue = $this->model->getReligionId();
		$this->q->audit = $this->audit;
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
            "success" => true,
            "message" => "Deleted"
            ));
            exit();
	}

	/**
	 *  To Update flag Status
	 */
	function updateStatus() {
		header('Content-Type','application/json; charset=utf-8');

		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}

		$loop  = $this->model->getTotal();



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
			UPDATE '" . strtoupper($this->model->getTableName()) . "'
			SET    ";
		}
		//	echo "arnab[".$this->model->getReligionId(0,'array')."]";
		/**
		 * 	System Validation Checking
		 *  @var $access
		 */
		$access = array("isDefault", "isNew", "isDraft", "isUpdate", "isDelete", "isActive", "isApproved");
		foreach ($access as $systemCheck) {


			if ($this->getVendor() == self::mysql) {
				$sqlLooping.=" `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
			} else if ($this->getVendor() == self::mssql) {
				$sqlLooping.="  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
			} else if ($this->getVendor() == self::oracle) {
				$sqlLooping.="	" . strtoupper($systemCheck) . " = CASE \"" . strtoupper($this->model->getPrimaryKeyName()) . "\"";
			}
			switch ($systemCheck) {
				case 'isDefault':
					for ($i = 0; $i < $loop; $i++) {
						$sqlLooping.="
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsDefault($i, 'array') . "'";
					}
					break;
				case 'isNew':
					for ($i = 0; $i < $loop; $i++) {
						$sqlLooping.="
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsNew($i, 'array') . "'";
					} break;
				case 'isDraft':
					for ($i = 0; $i < $loop; $i++) {
						$sqlLooping.="
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsDraft($i, 'array') . "'";
					}
					break;
				case 'isUpdate':
					for ($i = 0; $i < $loop; $i++) {
						$sqlLooping.="
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsUpdate($i, 'array') . "'";
					}
					break;
				case 'isDelete':
					for ($i = 0; $i < $loop; $i++) {
						$sqlLooping.="
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsDelete($i, 'array') . "'";
					}
					break;
				case 'isActive':
					for ($i = 0; $i < $loop; $i++) {
						$sqlLooping.="
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsActive($i, 'array') . "'";
					}
					break;
				case 'isApproved':
					for ($i = 0; $i < $loop; $i++) {
						$sqlLooping.="
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsApproved($i, 'array') . "'";
					}
					break;
			}


			$sqlLooping.= " END,";
		}

		$sql.=substr($sqlLooping, 0, -1);
		if ($this->getVendor() == self::mysql) {
			$sql.="
			WHERE `" . $this->model->getPrimaryKeyName() . "` IN (" . $this->model->getReligionIdAll() . ")";
		} else if ($this->getVendor() == self::mssql) {
			$sql.="
			WHERE `=[" . $this->model->getPrimaryKeyName() . "] IN (" . $this->model->getReligionIdAll() . ")";
		} else if ($this->getVendor() == self::oracle) {
			$sql.="
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "\" IN (" . $this->model->getReligionIdAll() . ")";
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
	function duplicate() {
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
			SELECT	`religionDesc`
			FROM 	`religion`
			WHERE 	`religionDesc` 	= 	\"" . $this->model->getReligionDesc() . "\"
			AND		`isActive`		=	1";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			SELECT	[religionDesc]
			FROM 	[religion]
			WHERE 	[religionDesc] 	= 	'" . $this->model->getReligionDesc() . "'
			AND		[isActive]		=	1";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT	RELIGIONDESC
			FROM 	RELIGION
			WHERE 	RELIGIONDESC 	= 	'" . $this->model->getReligionDesc() . "'
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
		}
			
		if ($total > 0) {
			$row = $this->q->fetchArray();
			echo json_encode(array(
				"success" => "true",
				"total" => $total,
				"message" => "Duplicate Record",
				"religionDesc" => $row['religionDesc']
			));
			exit();
				
		} else {
			echo json_encode(array(
				"success" => "true",
				"total" => $total,
				"message" => "Duplicate Non"
				));
				exit();
		}

	}

	/* (non-PHPdoc)
	 * @see config::excel()
	 */

	function excel() {
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->getVendor() == self::mysql) {
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
                "success" => false,
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
                        $this->excel->getActiveSheet()->setCellValue('B2', $this->title);
                        $this->excel->getActiveSheet()->setCellValue('C2', '');
                        $this->excel->getActiveSheet()->mergeCells('B2:C2');
                        $this->excel->getActiveSheet()->setCellValue('B3', 'No');
                        $this->excel->getActiveSheet()->setCellValue('C3', 'Penerangan');
                        $this->excel->getActiveSheet()->getStyle('B2:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $this->excel->getActiveSheet()->getStyle('B2:C2')->getFill()->getStartColor()->setARGB('66BBFF');
                        $this->excel->getActiveSheet()->getStyle('B3:C3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $this->excel->getActiveSheet()->getStyle('B3:C3')->getFill()->getStartColor()->setARGB('66BBFF');
                        //
                        $loopRow = 4;
                        $i = 0;
                        while ($row = $this->q->fetchAssoc()) {
                        	//	echo print_r($row);
                        	$this->excel->getActiveSheet()->setCellValue('B' . $loopRow, ++$i);
                        	$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, 'a' . $row['religionDesc']);
                        	$loopRow++;
                        	$lastRow = 'C' . $loopRow;
                        }
                        $from = 'B2';
                        $to = $lastRow;
                        $formula = $from . ":" . $to;
                        $this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
                        $filename = "religion" . rand(0, 10000000) . ".xlsx";
                        $path = $_SERVER['DOCUMENT_ROOT'] . "/" . $this->application . "/basic/document/excel/" . $filename;
                        $this->documentTrail->create_trail($this->leafId, $path, $filename);
                        $objWriter->save($path);
                        $file = fopen($path, 'r');
                        if ($file) {
                        	echo json_encode(array(
                "success" => 'true',
                "message" => "File generated",
                "filename" => $filename
                        	));
                        	exit();
                        } else {
                        	echo json_encode(array(
                "success" => 'false',
                "message" => "File not generated"
                ));
                exit();
                        }
	}



}

$religionObject = new ReligionClass();
if (isset($_SESSION['staffId'])) {
	$religionObject->setStaffId($_SESSION['staffId']);
}
if (isset($_SESSION['vendor'])) {
	$religionObject->setVendor($_SESSION['vendor']);
}
if (isset($_SESSION['languageId'])) {
	$religionObject->setLanguageId($_SESSION['languageId']);
}
/**
 * 	crud -create,read,update,delete
 * */
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_POST['leafId'])) {
		$religionObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST['isAdmin'])) {
		$religionObject->setIsAdmin($_POST['isAdmin']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST['start'])) {
		$religionObject->setStart($_POST['start']);
	}
	if (isset($_POST['perPage'])) {
		$religionObject->setLimit($_POST['perPage']);
	}
	/*
	 *  Filtering
	 */
	if (isset($_POST['query'])) {
		$religionObject->setFieldQuery($_POST['query']);
	}
	if (isset($_POST['filter'])) {
		$religionObject->setGridQuery($_POST['filter']);
	}
	/*
	 * Ordering
	 */
	if (isset($_POST['order'])) {
		$religionObject->setOrder($_POST['order']);
	}
	if (isset($_POST['sortField'])) {
		$religionObject->setSortField($_POST['sortField']);
	}

	/*
	 *  Load the dynamic value
	 */
	$religionObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST['method'] == 'create') {
		$religionObject->create();
	}
	if ($_POST['method'] == 'save') {
		$religionObject->update();
	}
	if ($_POST['method'] == 'read') {
		$religionObject->read();
	}
	if ($_POST['method'] == 'delete') {
		$religionObject->delete();
	}
}

if (isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_GET['leafId'])) {
		$religionObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET['isAdmin'])) {
		$religionObject->setIsAdmin($_GET['isAdmin']);
	}

	/*
	 *  Load the dynamic value
	 */
	$religionObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$religionObject->staff();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if ($_GET['method'] == 'updateStatus') {
		$religionObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET['religionDesc'])) {
		if (strlen($_GET['religionDesc']) > 0) {
			$religionObject->duplicate();
		}
	}
	if($_GET['method']=='dataNavigationRequest') {
		if($_GET['dataNavigation']=='first') {
			$religionObject->firstRecord('json');
		}
		if($_GET['dataNavigation']=='previous') {
			$religionObject->previousRecord('json',0);
		}
		if($_GET['dataNavigation']=='next') {
			$religionObject->nextRecord('json',0);
		}
		if($_GET['dataNavigation']=='last') {
			$religionObject->lastRecord('json');
		}
	}
	/*
	 * Excel Reporting
	 */
	if (isset($_GET['mode'])) {
		if ($_GET['mode'] == 'excel') {
			$religionObject->excel();
		}
	}
}
?>
