<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/moduleTranslateModel.php");
/**
 * Module Translation
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @subpackage Module Translation Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class moduleTranslateClass extends configClass
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
	 * @var boolean $audit
	 */
	private $audit;
	/**
	 * Log Sql Statement True or False
	 * @var unknown_type
	 */
	private $log;
	/**
	 * department Model
	 * @var string $departmentModel
	 */
	public $model;
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
	 * Duplicate Testing either the key of modulele same or have been created.
	 * @var boolean $duplicateTest;
	 */
	public $duplicateTest;
	/**
	 * Common class function for security menu
	 * @var  string $security
	 */
	private $security;


	/**
	 * module Translate Identification
	 * @var  numeric $moduleTranslateId
	 */
	private $moduleTranslateId;
	/**
	 * module Translate
	 * @var string $moduleTranslate
	 */
	public $moduleTranslate;
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
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDamodulease(), $this->getPassword());
		$this->excel             = new PHPExcel();
		$this->audit             = 0;
		$this->log               = 1;
		$this->q->log            = $this->log;
		$this->defaultLanguageId = 21;
		$this->security          = new security();
		$this->security->vendor  = $this->vendor;
		$this->security->leafId  = $this->leafId;
		$this->security->execute();
		$this->model         = new moduleModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->documentTrail = new documentTrailClass();


	}
	function create()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->create();
		/**
		 * Example  using Constant .This much cleaner approch  to Sql Statement
		 */
		$sql = " INSERT INTO `" . moduleModel::moduleleName . "` (`" . moduleModel::moduleNote . "`)  VALUES (\"". $this->model->moduleNote ."\")";
		if ($this->getVendor() == self::mysql) {
			$sql = "
			INSERT INTO `module`
					(
						`iconId`,							`moduleSequence`,
						`moduleNote`,							`isDefault`
						`isNew`,							`isDraft`,
						`isUpdate`,							`isDelete`,
						`isActive`,							`isApproved`,						\
						`By`,								`Time`
					)
			VALUES
					(
						\"". $this->model->getIconId() ."\",			\"". $this->model->getmoduleSequence() ."\",
						\"". $this->model->getmoduleNote() ."\",			\"".$this->model->getIsDefault(0,'string')."\",
						\"". $this->model->getIsNew(0,'string') ."\",				\"". $this->model->getIsDraft(0,'string') ."\",
						\"". $this->model->getIsUpdate(0,'string') ."\"				\"". $this->model->getIsDelete(0,'string') ."\",
						\"". $this->model->getIsActive(0,'string') ."\",			\"". $this->model->getIsApproved(0,'string') ."\",
						\"". $this->model->getBy() ."\",				" . $this->model->getTime() . "
					);";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			INSERT INTO [module]
					(
						[iconId],							[moduleSequence],
						[moduleNote],					[isNew],
						[isDraft],							[isUpdate],
						[isDelete],							[isActive],
						[isApproved],						[By],
						[Time]
					)
			VALUES
					(
						\"". $this->model->getIconId() ."\",			\"". $this->model->getmoduleSequence() ."\",
						\"". $this->model->getmoduleNote() ."\",			\"".$this->model->getIsDefault(0,'string')."\",
						\"". $this->model->getIsNew(0,'string') ."\",				\"". $this->model->getIsDraft(0,'string') ."\",
						\"". $this->model->getIsUpdate(0,'string') ."\"				\"". $this->model->getIsDelete(0,'string') ."\",
						\"". $this->model->getIsActive(0,'string') ."\",			\"". $this->model->getIsApproved(0,'string') ."\",
						\"". $this->model->getBy() ."\",				" . $this->model->getTime() . "
					);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			INSERT INTO \"module\"
					(
						iconId\"							\"moduleSequence\",
						\"moduleNote\",					\"isNew\"
						\"isDraft\",							\"isUpdate\"
						\"isDelete\",							\"isActive\",
						\"isApproved\",						\"By\",
						\"Time\"
					)
			VALUES
					(
												\"". $this->model->getIconId() ."\",			\"". $this->model->getmoduleSequence() ."\",
						\"". $this->model->getmoduleNote() ."\",			\"".$this->model->getIsDefault(0,'string')."\",
						\"". $this->model->getIsNew(0,'string') ."\",				\"". $this->model->getIsDraft(0,'string') ."\",
						\"". $this->model->getIsUpdate(0,'string') ."\"				\"". $this->model->getIsDelete(0,'string') ."\",
						\"". $this->model->getIsActive(0,'string') ."\",			\"". $this->model->getIsApproved(0,'string') ."\",
						\"". $this->model->getBy() ."\",				" . $this->model->getTime() . "
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
		if ($this->getVendor() == self::mysql) {
			/*
			 * 	If anything wrong use this instead  SELECT LAST_INSERT_ID();
			 **/
			$sql = "
			SELECT	MAX(`moduleId`)	AS `lastId`
			FROM 	`module`";
		} else if ($this->q->vendor == 'microsoft') {
			/*
			 *  If anything wrong use this insert SELECT @@IDENTITY
			 **/
			$sql = "
			SELECT	MAX([moduleId]) AS [lastId]
			FROM 	[module] ";
		} else if ($this->q->vendor == 'oracle') {
			/**
			 *  If anthing wrong use this instead  SELECT moduleIdSeq
			 */
			$sql = "
			SELECT 	MAX(\"moduleId\") AS \"lastId\"
			FROM 	\"module\"";
		}
		$resultd   = $this->q->fast($sql);
		$rowLastId = $this->q->fetchAssoc($resultd);
		$lastId    = $rowLastId['lastId'];
		//  create a record  in moduleAccess.update no effect
		// loop the group
		if ($this->getVendor() == self::mysql) {
			$sql = "
			SELECT 	*
			FROM 	`group`
			WHERE 	`isActive`	=	1 ";
		} else if ($this->q->vendor == 'microsoft') {
			$sql = "
			SELECT 	*
			FROM 	[group]
			WHERE 	[isActive]	=	1 ";
		} else if ($this->q->vendor == 'oracle') {
			$sql = "
			SELECT 	*
			FROM 	\"group\"
			WHERE 	`\"isActive\"	=	1 ";
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
		if ($this->getVendor() == self::mysql) {
			$sql = "
				INSERT INTO	`moduleAccess`
						(
							`moduleId`,
							`groupId`,
							`moduleAccessValue`
						) VALUES";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
				INSERT INTO	[moduleAccess]
						(
							[moduleId],
							[groupId],
							[moduleAccessValue]
					) VALUES";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
				INSERT INTO	\"moduleAccess\"
						(
							\"moduleId\",
							\"groupId\",
							\"moduleAccessValue\"
					) VALUES";
		}
		foreach ($data as $row) {
			/**
			 *	By Default  No Access
			 **/
			$sqlLooping.="(
							\"". $lastId ."\",
							 \"". $row['groupId'] ."\",
							 '0'
						)";





		}
		// optimize to 1 Query
		// remove last comma
		$sqlLooping = substr($sqlLooping,0,-1);
		// combine SQL Statement
		$sql.=$sq1Looping;
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		/**
		 *	 insert default value to detail modulele .English only
		 **/
		if ($this->getVendor() == self::mysql) {
			$sql = "
		 	INSERT INTO `leafTranslate`
		 		(
				 	`leafId`,
				 	`languageId`,
					`leafTranslate`
				) VALUES (
					\"". $lastId . "\",
					21,
					\"". $_POST['moduleNote'] ."\"
				);";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
		 	INSERT INTO  [leafTranslate]
					(
					 	[leafId],
						[languageId],
						[leafTranslate]
					) VALUES (
						\"". $lastId ."\",
						21,
						\"". $_POST['moduleNote'] ."\"
					);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
		 	INSERT INTO	\"leafTranslate\"
					(
					 	\"leafId\",
						\"languageId\",
						\"leafTranslate\"
					) VALUES (
						\"". $lastId ."\",
						21,
						\"". $_POST['moduleNote'] ."\"
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
		$this->q->commit();
		echo json_encode(array(
            "success" => true,
            "message" => "Insert Sucess",
            "moduleId" => $lastId
		));
		exit();
	}
	/* (non-PHPdoc)
	 * @see class/config::read()
	 */
	function read()
	{
		header('Content-Type', 'application/json; charset=utf-8');

		if($this->isAdmin == 0) {
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	`module`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[module].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"module\".\"isActive\"	=	1	";
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
			/**
			 *	UTF 8
			 **/
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
			SELECT		*
			FROM 		`module`
			LEFT JOIN 	`icon`
			USING 		(`iconId`)
			WHERE 		`module`.`isActive`	=	1
			AND			`icon`.`isActive`		=	1 ";
			if (($this->model->getmoduleId(0,'single'))) {
				$sql .= " AND `".$this->model->getPrimaryKeyName()."`=\"". $this->strict($this->model->getmoduleId(0,'single'), 'numeric') ."\"";
			}
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			SELECT		*
			FROM 		[module]
			LEFT JOIN 	[icon]
			ON 			[icon].[iconId] = [module].[iconId]
			WHERE 		[module].[isActive]	=	1
			AND			[icon].[iconId]			=	1";
			if (($this->model->getmoduleId(0,'single'))) {
				$sql .= " AND [".$this->model->getPrimaryKeyName()."]=\"". $this->strict($this->model->getmoduleId(0,'single'), 'numeric') ."\"";
			}
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT		*
			FROM 		\"module\"
			LEFT JOIN 	\"icon\"
			USING 		(\"iconId\")
			WHERE 		\"module\".\"isActive\"	=	1
			AND			\"icon\".\"isActive\"		=	1";
			if (($this->model->getmoduleId(0,'single'))) {
				$sql .= " AND \"".$this->model->getPrimaryKeyName()."\"=\"". $this->strict($this->model->getmoduleId(0,'single'), 'numeric') ."\"";
			}
		}
		if ($this->quickFilter) {
			/**
			 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
			 *  E.g  $filterArray=array('`leaf`.`leafId`');
			 *  @variables $filterArray;
			 */
			$filterArray = array(
                "moduleId",
                "moduleTranslateId"
                );
                /**
                 *	filter modulele
                 *  @variables $moduleleArray
                 */
                $moduleleArray  = array(
                'module',
                'moduleTranslate'
                );
                if ($this->q->vendor == 'normal' || $this->q->vendor == 'mysql') {
                	$sql .= $this->q->quickSearch($moduleleArray, $filterArray);
                } else if ($this->q->vendor == 'microsoft') {
                	$tempSql = $this->q->quickSearch($moduleleArray, $filterArray);
                	$sql .= $tempSql;
                } else if ($this->q->vendor == 'oracle') {
                	$tempSql = $this->q->quickSearch($moduleleArray, $filterArray);
                	$sql .= $tempSql;
                }
		}
		/**
		 *	Extjs filtering mode
		 */
		if ($this->getVendor() == self::mysql) {
			$sql .= $this->q->searching();
		} else if ($this->getVendor() ==  self::mssql) {
			$tempSql2 = $this->q->searching();
			$sql .= $tempSql2;
		} else if ($this->getVendor() == self::oracle) {
			$tempSql2 = $this->q->searching();
			$sql .= $tempSql2;
		}

		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		$total = $this->q->numberRows();
		if ($this->order && $this->sortField) {
			if ($this->getVendor() == self::mysql || $this->q->vendor == 'normal') {
				$sql .= "	ORDER BY `" . $sortField . "` " . $dir . " ";
			} else if ($this->getVendor() ==  self::mssql) {
				$sql .= "	ORDER BY [" . $sortField . "] " . $dir . " ";
			} else if ($this->getVendor() == self::oracle) {
				$sql .= "	ORDER BY \"" . $sortField . "\"  " . $dir . " ";
			}
		}
		$_SESSION['sql']   = $sql; // push to session so can make report via excel and pdf
		$_SESSION['start'] = $_POST['start'];
		$_SESSION['limit'] = $_POST['limit'];
		if (empty($_POST['filter'])) {
			if (isset($_POST['start']) && isset($_POST['limit'])) {
				if ($this->getVendor() == self::mysql) {
					/**
					 *	Mysql,Postgress and IBM using LIMIT
					 **/
					$sql .= " LIMIT  " . $_POST['start'] . "," . $_POST['limit'] . " ";
				} else if ($this->getVendor() ==  self::mssql) {
					/**
					 *	 Sql Server and Oracle used row_number
					 *	 Parameterize Query We don't support
					 **/
					$sql = "
					WITH [moduleDerived] AS
					(
						SELECT *,
						ROW_NUMBER() OVER (ORDER BY [moduleId]) AS 'RowNumber'
						FROM [module]
						WHERE [module].[isActive] =1   " . $tempSql . $tempSql2 . "
					)
					SELECT		*
					FROM 		[moduleDerived]
					WHERE 		[RowNumber]
					BETWEEN	" . $_POST['start'] . "
					AND 			" . ($_POST['start'] + $_POST['limit'] - 1) . ";";
				} else if ($this->getVendor() == self::oracle) {
					/**
					 *  Oracle using derived modulele also
					 */
					$sql = "
				SELECT *
				FROM ( SELECT	a.*,
										rownum r
				FROM (
							SELECT *
							FROM 	\"module\"
							WHERE \"isActive\"=1  " . $tempSql . $tempSql2 . $orderBy . "
						 ) a
				where rownum <= \"". ($_POST['start'] + $_POST['limit'] - 1) ."\" )
				where r >=  \"". $_POST['start'] ."\"";
				}
			}
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		$items = array();
		while ($row = $this->q->fetchAssoc()) {
			$items[] = $row;
		}
	 if ($this->model->getmoduleId(0,'single')) {
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
	 * @see configClass::update()
	 */
	function update()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->update();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE 	`module`
			SET 	`moduleSequence`	= 	\"". $this->model->getmoduleSequence() ."\",
					`moduleNote`		=	\"". $this->model->getmoduleNote() ."\",
					`iconId`			=	\"". $this->model->getIconId() ."\",
					`isActive`			=	\"". $this->model->getIsActive(0,'string') ."\",
					`isNew`				=	\"". $this->model->getIsNew(0,'string') ."\",
					`isDraft`			=	\"". $this->model->getIsDraft(0,'string') ."\",
					`isUpdate`			=	\"". $this->model->getIsUpdate(0,'string') ."\",
					`isDelete`			=	\"". $this->model->getIsDelete(0,'string') ."\",
					`isApproved`		=	\"". $this->model->getIsApproved(0,'string') ."\",
					`By`				=	\"". $this->model->getBy() ."\",
					`Time				=	" . $this->model->getTime() . "
			WHERE 	`moduleId`		=	\"". $this->model->moduleId ."\"";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			UPDATE 	[module]
			SET 	[moduleSequence]	= 	\"". $this->model->moduleSequence ."\",
					[moduleNote]		=	\"". $this->model->moduleNote ."\",
					[iconId]			=	\"". $this->model->iconId ."\",
					[isActive]			=	\"". $this->model->getIsActive(0,'string') ."\",
					[isNew]				=	\"". $this->model->getIsNew(0,'string') ."\",
					[isDraft]			=	\"". $this->model->getIsDraft(0,'string') ."\",
					[isUpdate]			=	\"". $this->model->getIsUpdate(0,'string') ."\",
					[isDelete]			=	\"". $this->model->getIsDelete(0,'string') ."\",
					[isApproved]		=	\"". $this->model->getIsApproved(0,'string') ."\",
					[By]				=	\"". $this->model->getBy() ."\",
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[moduleId]		=	\"". $this->model->moduleId ."\"";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	\"module\"
			SET 	\"moduleSequence\"	= 	\"". $this->model->moduleSequence ."\",
					\"moduleNote\"		=	\"". $this->model->moduleNote ."\",
					\"iconId\"				=	\"". $this->model->iconId ."\",
					\"isActive\"			=	\"". $this->model->getIsActive(0,'string') ."\",
					\"isNew\"				=	\"". $this->model->getIsNew(0,'string') ."\",
					\"isDraft\"				=	\"". $this->model->getIsDraft(0,'string') ."\",
					\"isUpdate\"			=	\"". $this->model->getIsUpdate(0,'string') ."\",
					\"isDelete\"			=	\"". $this->model->getIsDelete(0,'string') ."\",
					\"isApproved\"			=	\"". $this->model->getIsApproved(0,'string') ."\",
					\"By\"					=	\"". $this->model->getBy() ."\",
					\"Time\"				=	" . $this->model->getTime() . "
			WHERE 	\"moduleId\"			=	\"". $this->model->moduleId ."\"";
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
            "success" => success,
            "message" => "update success"
            ));
            exit();
	}
	/* (non-PHPdoc)
	 * @see configClass::delete()
	 */
	function delete()
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
			UPDATE 	`module`
			SET 	`isActive`			=	\"". $this->model->getIsActive(0,'string') ."\",
					`isNew`				=	\"". $this->model->getIsNew(0,'string') ."\",
					`isDraft`			=	\"". $this->model->getIsDraft(0,'string') ."\",
					`isUpdate`			=	\"". $this->model->getIsUpdate(0,'string') ."\",
					`isDelete`			=	\"". $this->model->getIsDelete(0,'string') ."\",
					`isApproved`		=	\"". $this->model->getIsApproved(0,'string') ."\",
					`By`				=	\"". $this->model->getBy() ."\",
					`Time				=	" . $this->model->getTime() . "
			WHERE 	`moduleId`		=	\"". $this->model->moduleId ."\"";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			UPDATE 	[module]
			SET 	[isActive]			=	\"". $this->model->getIsActive(0,'string') ."\",
					[isNew]				=	\"". $this->model->getIsNew(0,'string') ."\",
					[isDraft]			=	\"". $this->model->getIsDraft(0,'string') ."\",
					[isUpdate]			=	\"". $this->model->getIsUpdate(0,'string') ."\",
					[isDelete]			=	\"". $this->model->getIsDelete(0,'string') ."\",
					[isApproved]		=	\"". $this->model->getIsApproved(0,'string') ."\",
					[By]				=	\"". $this->model->getBy() ."\",
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[moduleId]		=	\"". $this->model->moduleId ."\"";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	\"module\"
			SET 	\"isActive\"	=	\"". $this->model->getIsActive(0,'string') ."\",
					\"isNew\"		=	\"". $this->model->getIsNew(0,'string') ."\",
					\"isDraft\"		=	\"". $this->model->getIsDraft(0,'string') ."\",
					\"isUpdate\"	=	\"". $this->model->getIsUpdate(0,'string') ."\",
					\"isDelete\"	=	\"". $this->model->getIsDelete(0,'string') ."\",
					\"isApproved\"	=	\"". $this->model->getIsApproved(0,'string') ."\",
					\"By\"			=	\"". $this->model->getBy() ."\",
					\"Time\"		=	" . $this->model->getTime() . "
			WHERE 	\"moduleId\"			=	\"". $this->model->moduleId ."\"";
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
            "success" => "true",
            "message" => "Delete Succes"
            ));
            exit();
	}
	/**
	 *  Read Record From moduleTranslate modulele
	 */
	function translateRead()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			/**
			 *	UTF 8
			 **/
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->q->vendor = 'mysql') {
			$sql = "
			SELECT	*
			FROM 	`moduleTranslate`
			JOIN 	`language`
			USING (`languageId`)
			WHERE	`moduleTranslate`.`moduleId`=\"". $this->strict($_POST['moduleId'], 'numeric') ."\"";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			SELECT	*
			FROM 	[moduleTranslate]
			JOIN 	[language]
			ON 		[moduleTranslate].[languageId] =[language].[languageId]
			WHERE	[moduleTranslate].[moduleId]=\"". $this->strict($_POST['moduleId'], 'numeric') ."\"";
		} else if ($this->q->vendor == 'oralce') {
			$sql = "
			SELECT	*
			FROM 	\"moduleTranslate\"
			JOIN 	\"language\"
			USING (\"languageId\")
			WHERE	\"moduleTranslate\".\"moduleId\"=\"". $this->strict($_POST['moduleId'], 'numeric') ."\"";
		}
		$this->q->read($sql);
		$total = $this->q->numberRows();
		$items = array();
		while ($row = $this->q->fetchAssoc()) {
			$items[] = $row;
		}
		echo json_encode(array(
            'success' => 'true',
            'total' => $total,
            'data' => $items
		));
		exit();
	}
	/**
	 * Update module Translation in moduleTranslate modulele
	 */
	public function translateUpdate()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		$this->q->commit();
		if ($this->getVendor() == self::mysql) {
			$sql = "
		UPDATE	`moduleTranslate`
		SET		`moduleTranslate` 	=	\"". $this->strict($_POST['moduleTranslate'], 'string') ."\"
		WHERE 	`moduleTranslateId`	=	\"". $this->strict($_POST['moduleTranslateId'], 'numeric') ."\"";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
		UPDATE	[moduleTranslate]
		SET		[moduleTranslate] 	=	\"". $this->strict($_POST['moduleTranslate'], 'string') ."\"
		WHERE 	[moduleTranslateId]	=	\"". $this->strict($_POST['moduleTranslateId'], 'numeric') ."\"";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
		UPDATE	\"moduleTranslate\"
		SET		\"moduleTranslate\" 		=	\"". $this->strict($_POST['moduleTranslate'], 'string') ."\"
		WHERE 	\"moduleTranslateId\"	=	\"". $this->strict($_POST['moduleTranslateId'], 'numeric') ."\"";
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
            "message" => "Record Update"
            ));
            exit();
	}
	/**
	 * Create Translation module Note to the moduleTranslate modulele
	 */
	function translateMe()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		$this->q->start();
		if ($this->q->vendor == 'normal' || $this->q->vendor == 'mysql') {
			$sql = "
			SELECT	*
			FROM 	`module`
			WHERE 	`moduleId`	=	\"". $this->moduleId ."\"";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			SELECT	*
			FROM 	[module]
			WHERE 	`moduleId`	=	\"". $this->moduleId ."\"";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT	*
			FROM 	\"module\"
			WHERE 	`moduleId`	=	\"". $this->moduleId ."\"";
		}
		$resultDefault = $this->q->fast($sql);
		if ($this->q->numberRows($resultDefault) > 0) {
			$rowDefault = $this->q->fetch_array($resultDefault);
			$value      = $rowDefault['moduleNote'];
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
			SELECT	*
			FROM 	`language`";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			SELECT 	*
			FROM 	[language] ";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT 	*
			FROM 	\"language\" ";
		}
		$result = $this->q->fast($sql);
		while ($row = $this->q->fetchAssoc($result)) {
			$languageId      = $row['languageId'];
			$languageCode    = $row['languageCode'];
			$to              = $languageCode;
			$googleTranslate = $this->security->changeLanguage($from = "en", $to, $value);
			if ($this->q->vendor == 'normal' || $this->q->vendor == 'mysql') {
				$sql = "
				SELECT	*
				FROM 	`moduleTranslate`
				WHERE 	`moduleId`			=	\"". $this->moduleId ."\"
				AND 	`languageId`			=	\"". $languageId ."\"";
			} else if ($this->getVendor() ==  self::mssql) {
				$sql = "
				SELECT	*
				FROM 	[moduleTranslate]
				WHERE 	[moduleId]			=	\"". $this->moduleId ."\"
				AND 	[languageId]			=	\"". $languageId ."\"";
			} else if ($this->getVendor() == self::oracle) {
				$sql = "
				SELECT	*
				FROM 	\"moduleTranslate\"
				WHERE 	\"moduleId\"			=	\"". $this->moduleId ."\"
				AND 	\"languageId\"			=	\"". $languageId ."\"";
			}
			$resultmoduleTranslate = $this->q->fast($sql);
			if ($this->q->numberRows($resultmoduleTranslate) > 0) {
				if ($this->q->vendor == 'normal' || $this->q->vendor == 'mysql') {
					$sql = "
					UPDATE	`moduleTranslate`
					SET 	`moduleTranslate`		=	\"". $googleTranslate ."\"
					WHERE 	`moduleId`				=	\"". $this->moduledId ."\"
					AND 	`languageId`				=	\"". $languageId ."\"";
				} else if ($this->q->vendor == 'microsoft') {
					$sql = "
					UPDATE	[moduleTranslate]
					SET 	[moduleTranslate]		=	\"". $googleTranslate ."\"
					WHERE 	[moduleId]				=	\"". $this->moduledId ."\"
					AND		[languageId]				=	\"". $languageId ."\"";
				} else if ($this->getVendor() == self::oracle) {
					$sql = "
					UPDATE 	\"moduleTranslate\"
					SET 	\"moduleTranslate\"		=	\"". $googleTranslate ."\"
					WHERE 	`moduleId`				=	\"". $this->moduledId ."\"
					AND 	`languageId`				=	\"". $languageId ."\"";
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
					INSERT INTO	`moduleTranslate`
							(
							 	`moduleId`,
								`languageId`,
								`moduleTranslate`
							) VALUES(
								\"". $this->moduleId ."\",
								\"". $languageId ."\",
								\"". $googleTranslate ."\"
					)";
				} else if ($this->getVendor() ==  self::mssql) {
					$sql = "
					INSERT INTO [moduleTranslate]
							(
							 	[moduleId],
								[languageId],
								[moduleTranslate]
							) VALUES(
								\"". $this->moduleId ."\",
								\"". $languageId ."\",
								\"". $googleTranslate ."\"
							)";
				} else if ($this->getVendor() == self::oracle) {
					$sql = "
					INSERT INTO \"moduleTranslate\"
							(
							 	\"moduleId\",
								\"languageId\",
								\"moduleTranslate\"
							) VALUES(
								\"". $this->moduleId ."\",
								\"". $languageId ."\",
								\"". $googleTranslate ."\"
							)";
				}
				$this->q->create($sql);
				if ($this->q->execute == 'fail') {
					echo json_encode(array(
                        "success" => "false",
                        "message" => $this->q->responce
					));
					exit();
				}
			}
		}
		$this->q->commit();
		echo json_encode(array(
            "success" => "true",
            "message" => "Translation Complete"
            ));
            exit();
	}
	public function nextSequence()
	{
		$this->security->nextSequence();
	}
	/* (non-PHPdoc)
	 * @see configClass::excel()
	 */
	function excel()
	{
		header('Content-Type', 'application/json; charset=utf-8');
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
                        $this->excel->getActiveSheet()->setCellValue('B2', $this->title);
                        $this->excel->getActiveSheet()->setCellValue('D2', '');
                        $this->excel->getActiveSheet()->mergeCells('B2:D2');
                        $this->excel->getActiveSheet()->setCellValue('B3', 'No');
                        $this->excel->getActiveSheet()->setCellValue('C3', 'Name');
                        $this->excel->getActiveSheet()->setCellValue('D3', 'Description');
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
                        	$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, $row['moduleNote']);
                        	$this->excel->getActiveSheet()->setCellValue('D' . $loopRow, $row['moduleDesc']);
                        	$loopRow++;
                        	$lastRow = 'D' . $loopRow;
                        }
                        $from    = 'B2';
                        $to      = $lastRow;
                        $formula = $from . ":" . $to;
                        $this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
                        $filename  = "module" . rand(0, 10000000) . ".xlsx";
                        $path      = $_SERVER['DOCUMENT_ROOT'] . "/" . $this->application . "/basic/document/excel/" . $filename;
                        $objWriter->save($path);
                        $this->audit->createTrail($this->leafId, $path, $filename);
                        $file = fopen($path, 'r');
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
/**
 *	Declare object
 **/
$moduleTranslateObject = new moduleClass();


/**
 *	Form Property .CRUD -create,read,update,delete
 **/
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST['leafId'])) {
		$moduleTranslateObject->setlLeafId($_POST['leafId']);
	}
	if(isset($_POST['isAdmin'])){
		$moduleTranslateObject->setIsAdmin($_POST['isAdmin']);
	}

	/*
	 * Filtering
	 */
	if (isset($_POST['query'])) {
		$moduleTranslateObject->setFieldQuery($_POST['query']);
	}
	if (isset($_POST['filter'])) {
		$moduleTranslateObject->setGridQuery($_POST['filter']);
	}

	/*
	 * Ordering
	 */
	if (isset($_POST['order'])) {
		$moduleTranslateObject->setOrder($_POST['order']);
	}
	if (isset($_POST['sortField'])) {
		$moduleTranslateObject->setSortField($_POST['sortField']);
	}



	/*
	 *  Load the dynamic value
	 */
	$moduleTranslateObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST['method'] == 'create') {
		$moduleTranslateObject->create();
	}
	if ($_POST['method'] == 'read') {

		$moduleTranslateObject->read();

	}
	if ($_POST['method'] == 'save') {

		$moduleTranslateObject->update();

	}
	if ($_POST['method'] == 'delete') {
		$moduleTranslateObject->delete();
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
		$moduleTranslateObject->leafId = $_GET['leafId'];
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$moduleTranslateObject->isAdmin = $_GET['isAdmin'];
	}
	/*
	 *  Load the dynamic value
	 */
	$moduleTranslateObject->execute();

	if ($_GET['method'] == 'translate') {
		$moduleTranslateObject->translateMe();
	}
	/*
	 *  Excel Reporting
	 */
	if (isset($_GET['mode'])) {
		if ($_GET['mode'] == 'report') {
			$moduleTranslateObject->excel();
		}

	}
}

?>

