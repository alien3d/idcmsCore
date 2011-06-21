<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../model/languageModel.php");
/**
 * this is leafUser setting files.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package leafUser
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafUserClass extends configClass
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
	 * Current Table leafUser Identification Value
	 * @var numeric $leafUserId
	 */
	public $leafUserId;
	/**
	 * leafUser Model
	 * @var string $leafUserModel
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
	 * Language
	 * @var string $languageId
	 */
	public $languageId;
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
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->audit         = 0;
		$this->log           = 1;
		$this->q->log        = $this->log;

		$this->model         = new leafUserModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();

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

		$this->model->create();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			INSERT INTO `leafUser`
					(
						`leafId`,						`leafSequence`,
						`staffId`
			VALUES
					(
						\"". $this->model->leafUserDesc . "\",
						(
							SELECT 	(MAX(`leafSequence`) + 1)
							FROM 	`leafUser`
							WHERE 	`staffId`	=	\"".$this->staffId."\"
						),
						\"".$this->staffId."\",
						);";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			INSERT INTO [leafUser]
					(
						[leafUserDesc],						[isDefault],
						[isNew],							[isDraft],
						[isUpdate],							[isDelete],
						[isActive],							[isApproved],
						[By],								[Time]
					)
			VALUES
					(
						\"". $this->model->leafUserDesc . "\",	\"". $this->model->isDefaut . "\",
						\"". $this->model->getIsNew('','string') . "\",			\"". $this->model->getIsDraft('','string') . "\",
						\"". $this->model->getIsDraft('','string') . "\",		\"". $this->model->getIsDelete('','string') . "\",
						\"". $this->model->getIsUpdate('','string') . "\",		\"". $this->model->getIsApproved('','string') . "\",
						\"". $this->model->getIsActive('','string') . "\",		" . $this->model->getTime() . "
					);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			INSERT INTO	\"leafUser\"
					(
						\"leafUserDesc\",					\"isDefault\",
						\"isNew\",							\"isDraft\",
						\"isUpdate\",						\"isDelete\",
						\"isActive\",						\"isApproved\",
						\"By\",								\"Time\"
					)
			VALUES
					(
						\"". $this->model->leafUserDesc . "\",	\"". $this->model->isDefaut . "\",
						\"". $this->model->getIsNew('','string') . "\",			\"". $this->model->getIsDraft('','string') . "\",
						\"". $this->model->getIsDraft('','string') . "\",		\"". $this->model->getIsDelete('','string') . "\",
						\"". $this->model->getIsUpdate('','string') . "\",		\"". $this->model->getIsApproved('','string') . "\",
						\"". $this->model->getIsActive('','string') . "\",		" . $this->model->getTime() . "
					)";
		}
		//advance logging future
		$this->q->tableName          = $this->model->tableName;
		$this->q->primaryKeyName  = $this->model->primaryKeyName;
		// $this->q->primaryKeyValue = $this->q->lastInsertId();  not use here

		$this->q->audit           = $this->audit;
		$this->q->create($sql);

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
            "message" => "Record Created"
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
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	`religion`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[religion].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"religion\".\"isActive\"	=	1	";
			}
		} else if($this->isAdmin ==1) {
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	 1 ";
			} else if ($this->q->vendor == self :: mssql) {
			    $this->auditFilter = "	or 1 ";
			} else if  ($this->q->vendor == self :: oracle) {
                  $this->auditFilter = " or 1 ";
			}
		}
		//UTF8
		$items=array();
		if ($this->getVendor() == self::mysql) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
					SELECT	*
 					FROM 	`leafUser`
					JOIN	`leaf`
					ON		`leafUser`.`leafId` = `leaf`.`leafId`
					JOIN	`leafAccess`
					ON		`leafAccess`.`leafId` = `leafUser`.`leafId`
					AND		`leafAccess`.`leafId` = `leaf`.`leafId`
					AND		`leafAccess`.`staffId` = `leafUser`.`staffId`
					JOIN	`leafTranslate`
					ON		`leafTranslate`.`leafId` = `leafUser`.`leafId`
					AND		`leafTranslate`.`leafId` = `leaf`.`leafId`
					WHERE 	`leaf`.`isActive` =1
					AND		`leafUser`.`staffId` =\"".$this->staffId."\"
					AND		`leafTranslate`.`languageId` = \"".$this->languageId."\"";

		} else if ($this->getVendor() ==  self::mssql) {
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

		} else if ($this->getVendor() == self::oracle) {
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
             *	Extjs filtering mode
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
                "success" =>false,
                "message" => $this->q->responce
            	));
            	exit();
            }
            $total = $this->q->numberRows();
            if ($this->order && $this->sortField) {
            	if ($this->getVendor() == self::mysql) {
            		$sql .= "	ORDER BY `" . $sortField . "` " . $dir . " ";
            	} else if ($this->getVendor() ==  self::mssql) {
            		$sql .= "	ORDER BY [" . $sortField . "] " . $dir . " ";
            	} else if ($this->getVendor() == self::oracle) {
            		$sql .= "	ORDER BY \"" . $sortField . "\"  " . $dir . " ";
            	}
            }
            $_SESSION['sql']   = $sql; // push to session so can make report via excel and pdf
            $_SESSION['start'] = $this->start;
            $_SESSION['limit'] = $this->limit;
            if (empty($_POST['filter'])) {
            	if ($this->limit) {
            		// only mysql have limit
            		if ($this->getVendor() == self::mysql) {
            			$sql .= " LIMIT  " . $this->start . "," . $this->limit . " ";
            		} else if ($this->getVendor() == self::mssql) {
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
            		} else if ($this->getVendor() == self::oracle) {
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
            if (!($this->religionId)) {
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
            if ($this->religionId) {
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
		$this->leafUserModel->update();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE 	`leafUser`
			SET 	`leafSequence`		=	\"". $this->leafUserModel->leafSequence . " + ".$leafSequenceIncDec." \"
			WHERE 	`leafUserId`		=	\"". $this->leafUserModel->leafUserId . "\"";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			UPDATE 	[leafUser]
			SET 	[leafSequence]		=	\"". $this->leafUserModel->leafSequence . " + ".$leafSequenceIncDec." \"
			WHERE 	[leafUserId]		=	\"". $this->leafUserModel->leafUserId . "\"";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	\"leafUser\"
			SET 	\"leafSequence\"	=	\"". $this->leafUserModel->leafSequence . " + ".$leafSequenceIncDec." \"
			WHERE 	\"leafUserId\"		=	\"". $this->leafUserModel->leafUserId . "\"";
		}
		/*
		 *  require three variable below to track  table audit
		 */
		$this->q->tableName       = $this->leafUserModel->tableName;
		$this->q->primaryKeyName  = $this->leafUserModel->primaryKeyName;
		$this->q->primaryKeyValue = $this->leafUserModel->leafUserId;
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
		$this->leafUserModel->update();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			DELETE 	`leafUser`
			WHERE 	`leafUserId`		=	\"". $this->leafUserModel->leafUserId . "\"";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			DELETE 	[leafUser]
			WHERE 	[leafUserId]		=	\"". $this->leafUserModel->leafUserId . "\"";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			DELETE 	\"leafUser\"
			WHERE 	\"leafUserId\"		=	\"". $this->leafUserModel->leafUserId . "\"";
		}
		/*
		 *  require three variable below to track  table audit
		 */
		$this->q->tableName       = $this->leafUserModel->tableName;
		$this->q->primaryKeyName  = $this->leafUserModel->primaryKeyName;
		$this->q->primaryKeyValue = $this->leafUserModel->leafUserId;
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
            "message" => "Record Deleted"
            ));
            exit();
	}

	function tab() {
	}
	function theme() {
	}

	function language() {
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel()
	{

	}
}
/**
 *	Declare object
 **/
$leafUserObject = new leafUserClass();
if (isset($_SESSION['staffId'])) {
	$leafUserObject->staffId = $_SESSION['staffId'];
}
if (isset($_SESSION['languageId'])) {
	$leafUserObject->languageId = $_SESSION['languageId'];
}
if (isset($_SESSION['vendor'])) {
	$leafUserObject->vendor = $_SESSION['vendor'];
}
/**
 *	crud -create,read,update,delete
 **/
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_POST['leafId'])) {
		$leafUserObject->leafId = $_POST['leafId'];
	}
	if (isset($_POST['leafUserId'])) {
		$leafUserObject->leafUserId = $_POST['leafUserId'];
	}
	if (isset($_POST['filter'])) {
		$leafUserObject->filter = $_POST['filter'];
	}
	if (isset($_POST['query'])) {
		$leafUserObject->quickFilter = $_POST['query'];
	}
	if (isset($_POST['start'])) {
		$leafUserObject->start = $_POST['start'];
	}
	if (isset($_POST['perPage'])) {
		$leafUserObject->limit = $_POST['perPage'];
	}
	if (isset($_POST['order'])) {
		$leafUserObject->order = $_POST['order'];
	}
	if (isset($_POST['sortField'])) {
		$leafUserObject->sortField = $_POST['sortField'];
	}
	if (isset($_POST['isAdmin'])) {
		$leafUserObject->isAdmin = $_POST['isAdmin'];
	}

	/*
	 *  Load the dynamic value
	 */
	$leafUserObject->execute();

	if ($_POST['method'] == 'read') {
		$leafUserObject->read();
	}
	if ($_POST['method'] == 'save') {
		$leafUserObject->update();
	}

}
if (isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_GET['leafId'])) {
		$leafUserObject->leafId = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$leafUserObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$leafUserObject->staffId();
		}
		if ($_GET['field'] == 'languageId') {
			$leafUserObject->languageId();
		}
	}


}
?>
