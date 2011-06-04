<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../class/classDocumentTrail.php");
require_once("../model/religionModel.php");
/**
 * this is religion setting files.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package religion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class religionClass extends configClass
{
	/**
	 * Connection to the database
	 * @var string $excel
	 */
	public $q;
	/**
	 * Program Identification
	 * @var numeric $leafId
	 */
	public $leafId;
	/**
	 * User Identification
	 * @var numeric $staffId
	 */
	public $staffId;
	/**
	 * Selected Database or Tablespace
	 * @var string $database
	 */
	public $database;
	/**
	 * Database Vendor
	 * @var string $vendor
	 */
	public $vendor;
	/**
	 * Extjs Grid Filter Array
	 * @var string $filter
	 */
	public $filter;
	/**
	 * Extjs Grid  single query information
	 * @var string $query
	 */
	public $query;
	/**
	 * Fast Search Variable
	 * @var string $quickFilter
	 */
	public $quickFilter;
	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string $excel
	 */
	private $excel;
	/**
	 * Document Trail Audit.
	 * @var string $documentTrail;
	 */
	private $documentTrail;
	/**
	 * Start
	 * @var string $start;`
	 */
	public $start;
	/**
	 *  Limit
	 * @var string $limit
	 */
	public $limit;
	/**
	 /**
	 *  Ascending ,Descending ASC,DESC
	 * @var string $order;`
	 */
	public $order;
	/**
	 * Sort the default field.Mostly consider as primary key default.
	 * @var string $sortField
	 */
	public $sortField;
	/**
	 * Default Language  : English
	 * @var numeric $defaultLanguageId
	 */
	private $defaultLanguageId;
	/**
	 * Audit Row True or False
	 * @var boolean $audit
	 */
	private $audit;
	/**
	 * Log Sql Statement True or False
	 * @var unknown_type
	 */
	private $log;
	/**
	 * Current Table Religion Indentification Value
	 * @var numeric $religionId
	 */
	public $religionId;
	/**
	 * Religion Model
	 * @var string $religionModel
	 */
	public $model;
	/**
	 * Open To See Audit  Column --> approved,new,delete and e.g
	 * @var numeric $isAdmin
	 */
	public $isAdmin;
	/**
	 * Audit Filter
	 * @var string $auditFilter
	 */
	public $auditFilter;
	/**
	 * Audit Column
	 * @var string $auditColumn
	 */
	public $auditColumn;
	/**
	 * Class Loader
	 */
	function execute()
	{
		parent::__construct();

		$this->q              = new vendor();
		$this->q->vendor      = $this->vendor;
		$this->q->leafId      = $this->leafId;
		$this->q->staffId     = $this->staffId;
		$this->q->filter      = $this->filter;
		$this->q->quickFilter = $this->quickFilter;
		$this->q->connect($this->connection, $this->username, $this->database, $this->password);
		$this->excel         = new PHPExcel();
		$this->audit         = 0;
		$this->log           = 1;
		$this->q->log        = $this->log;

		$this->model         = new religionModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->documentTrail = new documentTrailClass();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->q->vendor == self::mysql) {
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}

		$sql = "
			INSERT INTO `" . religionModel::tableName . "`
					(
						`" . religionModel::religionDesc . "`,	`" . religionModel::isDefaut . "`,
						`" . religionModel::isNew . "`,			`" . religionModel::isDraft . "`,
						`" . religionModel::isUpdate . "`,		`" . religionModel::isDelete . "`,
						`" . religionModel::isActive . "`,		`" . religionModel::isApproved . "`,
						`" . religionModel::By . "`,			`" . religionModel::Time . "`
					)
			VALUES
					(
						\"". $this->model->getReligionDesc() . "\",	\"". $this->model->getIsDefault() . "\",
						\"". $this->model->getIsNew() . "\",			\"". $this->model->getIsDraft() . "\",
						\"". $this->model->getIsUpdate() . "\",		\"". $this->model->getIsDelete() . "\",
						\"". $this->model->getIsActive() . "\",		\"". $this->model->getIsApproved() . "\",
						\"". $this->model->getBy() . "\",				" . $this->model->getTime() . "
					);";
		$this->q->start();
		$this->model->create();
		if ($this->q->vendor == self::mysql) {
			$sql = "
			INSERT INTO `religion`
					(
						`religionDesc`,						`isDefault`,
						`isNew`,							`isDraft`,
						`isUpdate`,							`isDelete`,
						`isActive`,							`isApproved`,
						`By`,								`Time`
					)
			VALUES
					(
						\"". $this->model->religionDesc() . "\",	\"". $this->model->getIsDefault() . "\",
						\"". $this->model->getIsNew() . "\",			\"". $this->model->getIsDraft() . "\",
						\"". $this->model->getIsUpdate() . "\",		\"". $this->model->getIsDelete() . "\",
						\"". $this->model->getIsActive() . "\",		\"". $this->model->getIsApproved() . "\",
						\"". $this->model->getBy() . "\"				" . $this->model->getTime() . "
					);";
		} else if ($this->q->vendor == self::microsoft) {
			$sql = "
			INSERT INTO [religion]
					(
						[religionDesc],						[isDefault],
						[isNew],							[isDraft],
						[isUpdate],							[isDelete],
						[isActive],							[isApproved],
						[By],								[Time]
					)
			VALUES
					(
					\"". $this->model->religionDesc() . "\",	\"". $this->model->getIsDefault() . "\",
						\"". $this->model->getIsNew() . "\",			\"". $this->model->getIsDraft() . "\",
						\"". $this->model->getIsUpdate() . "\",		\"". $this->model->getIsDelete() . "\",
						\"". $this->model->getIsActive() . "\",		\"". $this->model->getIsApproved() . "\",
						\"". $this->model->getBy() . "\"				" . $this->model->getTime() . "
					);";
		} else if ($this->q->vendor == self::oracle) {
			$sql = "
			INSERT INTO	\"religion\"
					(
						\"religionDesc\",					\"isDefault\",
						\"isNew\",							\"isDraft\",
						\"isUpdate\",						\"isDelete\",
						\"isActive\",						\"isApproved\",
						\"By\",								\"Time\"
					)
			VALUES
					(
						\"". $this->model->religionDesc() . "\",	\"". $this->model->getIsDefault() . "\",
						\"". $this->model->getIsNew() . "\",			\"". $this->model->getIsDraft() . "\",
						\"". $this->model->getIsUpdate() . "\",		\"". $this->model->getIsDelete() . "\",
						\"". $this->model->getIsActive() . "\",		\"". $this->model->getIsApproved() . "\",
						\"". $this->model->getBy() . "\"				" . $this->model->getTime() . "
					)";
		}
		//advance logging future
		$this->q->tableName          = $this->model->tableName;
		$this->q->primaryKeyName  = $this->model->primaryKeyName;
		// $this->q->primaryKeyValue = $this->q->lastInsertId();  not use here

		$this->q->audit           = $this->audit;
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
			"religionId"=>$religionId
		));
		exit();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if($this->isAdmin == 0) {
			if($this->q->vendor == self :: mysql) {
				$this->auditFilter = "	`religion`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[religion].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"religion\".\"isActive\"	=	1	";
			}
		} else if($this->isAdmin ==1) {
			if($this->q->vendor == self :: mysql) {
				$this->auditFilter = "	 1 ";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	or 1 ";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = " or 1 ";
			}
		}
		//UTF8
		$items=array();
		if ($this->q->vendor == self::mysql) {
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		if ($this->q->vendor == self::mysql) {
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
							`religion`.`By`,
							`religion`.`Time`,
							`staff`.`staffName`
 					FROM 	`religion`
					JOIN	`staff`
					ON		`religion`.`By` = `staff`.`staffId`
					WHERE 	".$this->auditFilter;
			if ($this->model->getReligionId()) {
				$sql .= " AND `religionId`=\"". $this->model->getReligionId() . "\"";

			}
		} else if ($this->q->vendor == self::mssql) {
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
							[religion].[By],
							[religion].[Time],
							[staff].[staffName]
					FROM 	[religion]
					JOIN	[staff]
					ON		[religion].[By] = [staff].[staffId]
					WHERE 	[religion].[isActive] ='1'	";
			if ($this->model->getReligionId()) {
				$sql .= " AND [religionId]=\"". $this->model->getReligionId() . "\"";
			}
		} else if ($this->q->vendor == self::oracle) {
			$sql = "
					SELECT	\"religion\".\"religionId\",
							\"religion\".\"religionDesc\",
							\"religion\".\"isDefault\",
							\"religion\".\"isNew\",
							\"religion\".\"isDraft\",
							\"religion\".\"isUpdate\",
							\"religion\".\"isDelete\",
							\"religion\".\"isActive\",
							\"religion\".\"isApproved\",
							\"religion\".\"By\",
							\"religion\".\"Time\",
							\"staff\".\"staffName\"
					FROM 	\"religion\"
					JOIN	\"staff\"
					ON		\"religion\".\"By\" = \"staff\".\"staffId\"
					WHERE 	\"isActive\"='1'	";
			if ($this->model->getReligionId()) {
				$sql .= " AND \"religionId\"=\"". $this->model->getReligionId() . "\"";
			}
		} else {
			echo json_encode(array(
                "success" => false,
                "message" => "Undefine Database Vendor"
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
            'religionId'
            );
            /**
             *	filter table
             * @variables $tableArray
             */
            $tableArray  = null;
            $tableArray  = array(
            'religion'
            );
            if ($this->quickFilter) {
            	if ($this->q->vendor == self::mysql) {
            		$sql .= $this->q->quickSearch($tableArray, $filterArray);
            	} else if ($this->q->vendor == self::microsoft) {
            		$tempSql = $this->q->quickSearch($tableArray, $filterArray);
            		$sql .= $tempSql;
            	} else if ($this->q->vendor == self::oracle) {
            		$tempSql = $this->q->quickSearch($tableArray, $filterArray);
            		$sql .= $tempSql;
            	}
            }
            /**
             *	Extjs filtering mode
             */
            if ($this->filter) {
            	if ($this->q->vendor == self::mysql) {
            		$sql .= $this->q->searching();
            	} else if ($this->q->vendor == self::microsoft) {
            		$tempSql2 = $this->q->searching();
            		$sql .= $tempSql2;
            	} else if ($this->q->vendor == self::oracle) {
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
                "success" =>false,
                "message" => $this->q->responce
            	));
            	exit();
            }
            $total = $this->q->numberRows();
            if ($this->order && $this->sortField) {
            	if ($this->q->vendor == self::mysql) {
            		$sql .= "	ORDER BY `" . $sortField . "` " . $dir . " ";
            	} else if ($this->q->vendor  == self::mssql) {
            		$sql .= "	ORDER BY [" . $sortField . "] " . $dir . " ";
            	} else if ($this->q->vendor == self::oracle) {
            		$sql .= "	ORDER BY \"" . $sortField . "\"  " . $dir . " ";
            	}
            }
            $_SESSION['sql']   = $sql; // push to session so can make report via excel and pdf
            $_SESSION['start'] = $this->start;
            $_SESSION['limit'] = $this->limit;
            if (empty($this->filter)) {
            	if ($this->limit) {
            		// only mysql have limit
            		if ($this->q->vendor == self::mysql) {
            			$sql .= " LIMIT  " . $this->start . "," . $this->limit . " ";
            		} else if ($this->q->vendor == self::microsoft) {
            			/**
            			 *	 Sql Server and Oracle used row_number
            			 *	 Parameterize Query We don't support
            			 */
            			$sql = "
							WITH [religionDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [religionId]) AS 'RowNumber'
								FROM [religion]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[religion].[religionId],
										[religion].[religionDesc]
										[religion].[isDefault],
										[religion].[isNew],
										[religion].[isDraft],
										[religion].[isUpdate],
										[religion].[isDelete],
										[religion].[isApproved],
										[religion].[By],
										[religion].[Time],
										[staff].[staffName]
							FROM 		[religionDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $_POST['start'] . "
							AND 			" . ($this->start + $this->limit - 1) . ";";
            		} else if ($this->q->vendor == self::oracle) {
            			/**
            			 *  Oracle using derived table also
            			 */
            			$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT  \"religion\".\"religionId\",
											\"religion\".\"religionDesc\"
											\"religion\".\"isDefault\",
											\"religion\".\"isNew\",
											\"religion\".\"isDraft\",
											\"religion\".\"isUpdate\",
											\"religion\".\"isDelete\",
											\"religion\".\"isApproved\",
											\"religion\".\"By\",
											\"religion\".\"Time\",
											\"staff\".\"staffName\"
									FROM 	\"religion\"
									WHERE \"isActive\"=1  " . $tempSql . $tempSql2 . $orderBy . "
								 ) a
						where rownum <= \"". ($this->start + $this->limit - 1) . "\" )
						where r >=  \"". $this->start . "\"";
            		} else {
            			echo "undefine vendor";
            		}
            	}
            }
            /*
             *  Only Execute One Query
             */
            if (!($this->model->getReligionId())) {
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
            if ($this->model->getReligionId()) {
            	$json_encode = json_encode(array(
                'success' => true,
                'total' => $total,
				'message' => 'Data Loaded',
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
				'message'=>'data loaded',
                'data' => $items
            	));
            	exit();
            }
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->q->vendor == self::mysql) {
			$sql = 'SET NAMES "utf8"';
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
		if ($this->q->vendor == self::mysql) {
			$sql = "
			UPDATE 	`religion`
			SET 	`religionDesc`		=	\"". $this->model->getReligionDesc() . "\",
					`isActive`			=	\"". $this->model->getIsActive() . "\",
					`isNew`				=	\"". $this->model->getIsNew() . "\",
					`isDraft`			=	\"". $this->model->getIsDraft() . "\",
					`isUpdate`			=	\"". $this->model->getIsUpdate() . "\",
					`isDelete`			=	\"". $this->model->getIsDelete() . "\",
					`isApproved`		=	\"". $this->model->getIsApproved() . "\",
					`By`				=	\"". $this->model->getBy() . "\",
					`Time`				=	" . $this->model->getTime() . "
			WHERE 	`religionId`		=	\"". $this->model->getReligionId() . "\"";
		} else if ($this->q->vendor ==  self::mssql) {
			$sql = "
			UPDATE 	[religion]
			SET 	[religionDesc]		=	\"". $this->model->getReligionDesc() . "\",
					[isActive]			=	\"". $this->model->getIsActive() . "\",
					[isNew]				=	\"". $this->model->getIsNew() . "\",
					[isDraft]			=	\"". $this->model->getIsDraft() . "\",
					[isUpdate]			=	\"". $this->model->getIsUpdate() . "\",
					[isDelete]			=	\"". $this->model->getIsDelete() . "\",
					[isApproved]		=	\"". $this->model->getIsApproved() . "\",
					[By]				=	\"". $this->model->getBy() . "\",
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[religionId]		=	\"". $this->model->getReligionId() . "\"";
		} else if ($this->q->vendor == self::oracle) {
			$sql = "
			UPDATE 	\"religion\"
			SET 	\"religionDesc\"	=	\"". $this->model->getReligionDesc() . "\",
					\"isActive\"		=	\"". $this->model->getIsActive() . "\",
					\"isNew\"			=	\"". $this->model->getIsNew() . "\",
					\"isDraft\"			=	\"". $this->model->getIsDraft() . "\",
					\"isUpdate\"		=	\"". $this->model->getIsUpdate() . "\",
					\"isDelete\"		=	\"". $this->model->getIsDelete() . "\",
					\"isApproved\"		=	\"". $this->model->getIsApproved() . "\",
					\"By\"				=	\"". $this->model->getBy() . "\",
					\"Time\"			=	" . $this->model->getTime() . "
			WHERE 	\"religionId\"		=	\"". $this->model->getReligionId() . "\"";
		}
		/*
		 *  require three variable below to track  table audit
		 */
		$this->q->tableName       = $this->model->tableName;
		$this->q->primaryKeyName  = $this->model->primaryKeyName;
		$this->q->primaryKeyValue = $this->model->getreligionId();
		$this->q->audit           = $this->audit;
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
	function delete()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->q->vendor   == self :: mysql) {
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->delete();
		if ($this->q->vendor == self::mysql) {
			$sql = "
			UPDATE 	`religion`
			SET 	`isActive`			=	\"". $this->model->getIsActive() . "\",
					`isNew`				=	\"". $this->model->getIsNew() . "\",
					`isDraft`			=	\"". $this->model->getIsDraft() . "\",
					`isUpdate`			=	\"". $this->model->getIsUpdate() . "\",
					`isDelete`			=	\"". $this->model->getIsDelete() . "\",
					`isApproved`		=	\"". $this->model->getIsApproved() . "\",
					`By`				=	\"". $this->model->getBy() . "\",
					`Time`				=	" . $this->model->getTime() . "
			WHERE 	`religionId`		=	\"". $this->model->getReligionId() . "\"";
		} else if ($this->q->vendor == self::mssql) {
			$sql = "
			UPDATE 	[religion]
			SET 	[isActive]			=	\"". $this->model->getIsActive() . "\",
					[isNew]				=	\"". $this->model->getIsNew() . "\",
					[isDraft]			=	\"". $this->model->getIsDraft() . "\",
					[isUpdate]			=	\"". $this->model->getIsUpdate() . "\",
					[isDelete]			=	\"". $this->model->getIsDelete() . "\",
					[isApproved]		=	\"". $this->model->getIsApproved() . "\",
					[By]				=	\"". $this->model->getBy() . "\",
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[religionId]		=	\"". $this->model->getReligionId . "\"";
		} else if ($this->q->vendor == self::oracle) {
			$sql = "
			UPDATE 	\"religion\"
			SET 	\"religionDesc\"	=	\"". $this->model->getReligionDesc() . "\",
					\"isActive\"		=	\"". $this->model->getIsActive() . "\",
					\"isNew\"			=	\"". $this->model->getIsNew() . "\",
					\"isDraft\"			=	\"". $this->model->getIsDraft() . "\",
					\"isUpdate\"		=	\"". $this->model->getIsUpdate() . "\",
					\"isDelete\"		=	\"". $this->model->getIsDelete() . "\",
					\"isApproved\"		=	\"". $this->model->getIsApproved() . "\",
					\"By\"				=	\"". $this->model->getBy() . "\",
					\"Time\"			=	" . $this->model->getTime() . "
			WHERE 	\"religionId\"		=	\"". $this->model->getReligionId() . "\"";
		}
		// advance logging future
		$this->q->tableName       = $this->model->tableName;
		$this->q->primaryKeyName  = $this->model->primaryKeyName;
		$this->q->primaryKeyValue = $this->model->religionId;
		$this->q->audit           = $this->audit;
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
	function updateStatus () {

		if($this->isAdmin==0){
			$this->model->delete();
			if ($this->q->vendor == self::mysql) {
				$sql = "
			UPDATE 	`religion`
			SET 	`isActive`			=	\"". $this->model->getIsActive() . "\",
					`isNew`				=	\"". $this->model->getIsNew() . "\",
					`isDraft`			=	\"". $this->model->getIsDraft() . "\",
					`isUpdate`			=	\"". $this->model->getIsUpdate() . "\",
			UPDATE 	\"religion\"
					`isDelete`			=	\"". $this->model->getIsDelete() . "\",
					`isApproved`		=	\"". $this->model->getIsApproved() . "\",
					`By`				=	\"". $this->model->getBy() . "\",
					`Time`				=	" . $this->model->getTime() . "
			WHERE 	`religionId`		IN	(". $this->model->getReligionIdAll(). ")";
			} else if ($this->q->vendor == self::mssql) {
				$sql = "
			UPDATE 	[religion]
			SET 	[isActive]			=	\"". $this->model->getIsActive() . "\",
					[isNew]				=	\"". $this->model->getIsNew() . "\",
					[isDraft]			=	\"". $this->model->getIsDraft() . "\",
					[isUpdate]			=	\"". $this->model->getIsUpdate() . "\",
					[isDelete]			=	\"". $this->model->getIsDelete() . "\",
					[isApproved]		=	\"". $this->model->getIsApproved() . "\",
					[By]				=	\"". $this->model->getBy() . "\",
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[religionId]		IN	(". $this->model->getReligionIdAll() . ")";
			} else if ($this->q->vendor == self::oracle) {
				$sql = "
				UPDATE	\"religion\"
				SET 	\"isActive\"		=	\"". $this->model->getIsActive() . "\",
					\"isNew\"			=	\"". $this->model->getIsNew() . "\",
					\"isDraft\"			=	\"". $this->model->getIsDraft() . "\",
					\"isUpdate\"		=	\"". $this->model->getIsUpdate() . "\",
					\"isDelete\"		=	\"". $this->model->getIsDelete() . "\",
					\"isApproved\"		=	\"". $this->model->getIsApproved() . "\",
					\"By\"				=	\"". $this->model->getBy() . "\",
					\"Time\"			=	" . $this->model->getTime() . "
			WHERE 	\"religionId\"		IN	(". $this->model->getReligionIdAll() . ")";
			}
		} else if ($this->isAdmin ==1){
			$loop=$this->model->totalfolderAccessId;
			if( $this->q->vendor==self::mysql) {
				$sql="
				UPDATE `religion`
				SET";
			} else if($this->q->vendor==self::mssql) {
				$sql="
			UPDATE 	[religion]
			SET 	";

			} else if ($this->q->vendor==self::oracle) {
				$sql="
			UPDATE \"religion\"
			SET    ";
			}

			/**
			 *	System Validation Checking
			 *  @var $access
			 */
			$access  = array("isDefault","isNew","isDraft","isUpdate","isDelete","isActive","isApproved");
			foreach($access as $systemCheck) {

				for($i=0;$i<$loop;$i++) {
					if( $this->q->vendor==self::mysql) {
						$sqlLooping.=" `".$systemCheck."` = CASE `religionId`";
					} else if($this->q->vendor==self::mssql) {
						$sqlLooping.="  [".$systemCheck."] = CASE [religionId]";

					} else if ($this->q->vendor==self::oracle) {
						$sqlLooping.="	\"".$systemCheck."\" = CASE \"religionId\"";
					}
					switch ($systemCheck){
						case 'isDefault':
							$sqlLooping.="
							WHEN '".$this->model->getReligionId($i,'array')."'
							THEN '".$this->model->getIsDefault($i,'array')."'";
							break;
						case 'isNew':
							$sqlLooping.="
							WHEN '".$this->model->getReligionId($i,'array')."'
							THEN '".$this->model->getIsNew($i,'array')."'";
							break;
						case 'isDraft':
							$sqlLooping.="
							WHEN '".$this->model->getReligionId($i,'array')."'
							THEN '".$this->model->getIsDraft($i,'array')."'";
							break;
						case 'isUpdate':
							$sqlLooping.="
							WHEN '".$this->model->getReligionId($i,'array')."'
							THEN '".$this->model->getIsUpdate($i,'array')."'";
							break;
						case 'isDelete':
							$sqlLooping.="
							WHEN '".$this->model->getReligionId($i,'array')."'
							THEN '".$this->model->getIsDelete($i,'array')."'";
							break;
						case 'isActive':
							$sqlLooping.="
							WHEN '".$this->model->getReligionId($i,'array')."'
							THEN '".$this->model->getIsActive($i,'array')."'";
							break;
						case 'isApproved':
							$sqlLooping.="
							WHEN '".$this->model->getReligionId($i,'array')."'
							THEN '".$this->model->getIsApproved($i,'array')."'";
							break;
					}

				}
				$sqlLooping.= " END,";
			}
			$sqlLooping = substr($sqlLooping,0,-1);
			$sql.=$sqlLooping;
			if( $this->q->vendor==self::mysql) {
				$sql.="
			WHERE `religionId` IN (".$this->model->getfolderAccessIdAll.")";
			} else if($this->q->vendor==self::mssql) {
				$sql.="
			WHERE `=[religionId] IN (".$this->model->getfolderAccessIdAll.")";
			} else if ($this->q->vendor==self::oracle) {
				$sql.="
			WHERE \"religionId\" IN (".$this->model->getfolderAccessIdAll.")";
			}
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
		if ($this->q->vendor == self::mysql) {
			//UTF8
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		if ($this->q->vendor == self::mysql) {
			$sql = "
			SELECT	*
			FROM 	`religion`
			WHERE 	`religionDesc` 	= 	\"". $this->model->getReligionDesc(). "\"
			AND		`isActive`		=	1";
		} else if ($this->q->vendor == self::mssql) {
			$sql = "
			SELECT	*
			FROM 	[religion]
			WHERE 	[religionDesc] 	= 	\"". $this->model->getReligionDesc() . "\"
			AND		[isActive]		=	1";
		} else if ($this->q->vendor == self::oracle) {
			$sql = "
			SELECT	*
			FROM 	\"religion\"
			WHERE 	\"religionDesc\" 	= 	\"". $this->model->getReligionDesc() . "\"
			AND		\"isActive\"		=	1";
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
			echo json_encode(array(
                "success" => "true",
                "total" => $total,
                "message" => "Duplicate Record",
                "religionDesc" => $row['religionDesc']
			));
			exit();
		}
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->q->vendor == self::mysql) {
			$sql = 'SET NAMES "utf8"';
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
                        $i       = 0;
                        while ($row = $this->q->fetch_array()) {
                        	//	echo print_r($row);
                        	$this->excel->getActiveSheet()->setCellValue('B' . $loopRow, ++$i);
                        	$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, 'a' . $row['religionDesc']);
                        	$loopRow++;
                        	$lastRow = 'C' . $loopRow;
                        }
                        $from    = 'B2';
                        $to      = $lastRow;
                        $formula = $from . ":" . $to;
                        $this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
                        $filename  = "religion" . rand(0, 10000000) . ".xlsx";
                        $path      = $_SERVER['DOCUMENT_ROOT'] . "/" . $this->application . "/basic/document/excel/" . $filename;
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
/**
 *	Declare object
 **/
$religionObject = new religionClass();
if (isset($_SESSION['staffId'])) {
	$religionObject->staffId = $_SESSION['staffId'];
}
if (isset($_SESSION['vendor'])) {
	$religionObject->vendor = $_SESSION['vendor'];
}
/**
 *	crud -create,read,update,delete
 **/
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_POST['leafId'])) {
		$religionObject->leafId = $_POST['leafId'];
	}
	if (isset($_POST['religionId'])) {
		$religionObject->religionId = $_POST['religionId'];
	}
	if (isset($_POST['filter'])) {
		$religionObject->filter = $_POST['filter'];
	}
	if (isset($_POST['query'])) {
		$religionObject->quickFilter = $_POST['query'];
	}
	if (isset($_POST['start'])) {
		$religionObject->start = $_POST['start'];
	}
	if (isset($_POST['perPage'])) {
		$religionObject->limit = $_POST['perPage'];
	}
	if (isset($_POST['order'])) {
		$religionObject->order = $_POST['order'];
	}
	if (isset($_POST['sortField'])) {
		$religionObject->sortField = $_POST['sortField'];
	}
	if (isset($_POST['isAdmin'])) {
		$religionObject->isAdmin = $_POST['isAdmin'];
	}

	/*
	 *  Load the dynamic value
	 */
	$religionObject->execute();
	if ($_POST['method'] == 'create') {
		$religionObject->create();
	}
	if ($_POST['method'] == 'read') {
		$religionObject->read();
	}
	if ($_POST['method'] == 'save') {
		$religionObject->update();
	}
	if ($_POST['method'] == 'delete') {
		$religionObject->delete();
	}
	if($_POST['method'] =='updateStatus'){
		$religionObject->updateStatus();
	}
}
if (isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_GET['leafId'])) {
		$religionObject->leafId = $_GET['leafId'];
	}

	/*
	 *  Load the dynamic value
	 */
	$religionObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$religionObject->staffId();
		}
	}
	if (isset($_GET['religionDesc'])) {
		if (strlen($_GET['religionDesc']) > 0) {
			$religionObject->duplicate();
		}
	}
	if (isset($_GET['mode'])) {
		if ($_GET['mode'] == 'excel') {
			$religionObject->excel();
		}
	}
}
?>
