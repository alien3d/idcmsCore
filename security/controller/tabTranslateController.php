<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../class/classDocumentTrail.php");
require_once("../../class/classSecurity.php");
require_once("../model/tabTranslateModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package tab
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class tabClass extends configClass
{
	/*
	 * Connection to the database
	 * @var string $excel
	 */
	public $q;
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
	 * Duplicate Testing either the key of table same or have been created.
	 * @var boolean $duplicateTest;
	 */
	public $duplicateTest;
	/**
	 * Common class function for security menu
	 * @var  string $security
	 */
	private $security;


	/**
	 * tab Translate Identification
	 * @var  numeric $tabTranslateId
	 */
	private $tabTranslateId;
	/**
	 * tab Translate
	 * @var string $tabTranslate
	 */
	public $tabTranslate;
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
		$this->excel             = new PHPExcel();
		$this->audit             = 0;
		$this->log               = 1;
		$this->q->log            = $this->log;
		$this->defaultLanguageId = 21;
		$this->security          = new security();
		$this->security->vendor  = $this->vendor;
		$this->security->leafId  = $this->leafId;
		$this->security->execute();
		$this->model         = new tabModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->documentTrail = new documentTrailClass();


	}
	function create()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->create();
		/**
		 * Example  using Constant .This much cleaner approch  to Sql Statement
		 */
		$sql = " INSERT INTO `" . tabModel::tableName . "` (`" . tabModel::tabNote . "`)  VALUES ('" . $this->model->tabNote . "')";
		if ($this->getVendor() == self::mysql) {
			$sql = "
			INSERT INTO `tab`
					(
						`iconId`,							`tabSequence`,
						`tabNote`,							`isDefault`
						`isNew`,							`isDraft`,
						`isUpdate`,							`isDelete`,
						`isActive`,							`isApproved`,						\
						`By`,								`Time`
					)
			VALUES
					(
						'" . $this->model->getIconId() . "',			'" . $this->model->getTabSequence() . "',
						'" . $this->model->getTabNote() . "',			'".$this->model->getIsDefault('','string')."',
						'" . $this->model->getIsNew('','string') . "',				'" . $this->model->getIsDraft('','string') . "',
						'" . $this->model->getIsUpdate('','string') . "'				'" . $this->model->getIsDelete('','string') . "',
						'" . $this->model->getIsActive('','string') . "',			'" . $this->model->getIsApproved('','string') . "',
						'" . $this->model->getBy() . "',				" . $this->model->getTime() . "
					);";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			INSERT INTO [tab]
					(
						[iconId],							[tabSequence],
						[tabNote],					[isNew],
						[isDraft],							[isUpdate],
						[isDelete],							[isActive],
						[isApproved],						[By],
						[Time]
					)
			VALUES
					(
						'" . $this->model->getIconId() . "',			'" . $this->model->getTabSequence() . "',
						'" . $this->model->getTabNote() . "',			'".$this->model->getIsDefault('','string')."',
						'" . $this->model->getIsNew('','string') . "',				'" . $this->model->getIsDraft('','string') . "',
						'" . $this->model->getIsUpdate('','string') . "'				'" . $this->model->getIsDelete('','string') . "',
						'" . $this->model->getIsActive('','string') . "',			'" . $this->model->getIsApproved('','string') . "',
						'" . $this->model->getBy() . "',				" . $this->model->getTime() . "
					);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			INSERT INTO \"tab\"
					(
						iconId\"							\"tabSequence\",
						\"tabNote\",					\"isNew\"
						\"isDraft\",							\"isUpdate\"
						\"isDelete\",							\"isActive\",
						\"isApproved\",						\"By\",
						\"Time\"
					)
			VALUES
					(
												'" . $this->model->getIconId() . "',			'" . $this->model->getTabSequence() . "',
						'" . $this->model->getTabNote() . "',			'".$this->model->getIsDefault('','string')."',
						'" . $this->model->getIsNew('','string') . "',				'" . $this->model->getIsDraft('','string') . "',
						'" . $this->model->getIsUpdate('','string') . "'				'" . $this->model->getIsDelete('','string') . "',
						'" . $this->model->getIsActive('','string') . "',			'" . $this->model->getIsApproved('','string') . "',
						'" . $this->model->getBy() . "',				" . $this->model->getTime() . "
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
			SELECT	MAX(`tabId`)	AS `lastId`
			FROM 	`tab`";
		} else if ($this->q->vendor == 'microsoft') {
			/*
			 *  If anything wrong use this insert SELECT @@IDENTITY
			 **/
			$sql = "
			SELECT	MAX([tabId]) AS [lastId]
			FROM 	[tab] ";
		} else if ($this->q->vendor == 'oracle') {
			/**
			 *  If anthing wrong use this instead  SELECT tabIdSeq
			 */
			$sql = "
			SELECT 	MAX(\"tabId\") AS \"lastId\"
			FROM 	\"tab\"";
		}
		$resultd   = $this->q->fast($sql);
		$rowLastId = $this->q->fetchAssoc($resultd);
		$lastId    = $rowLastId['lastId'];
		//  create a record  in tabAccess.update no effect
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
				INSERT INTO	`tabAccess`
						(
							`tabId`,
							`groupId`,
							`tabAccessValue`
						) VALUES";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
				INSERT INTO	[tabAccess]
						(
							[tabId],
							[groupId],
							[tabAccessValue]
					) VALUES";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
				INSERT INTO	\"tabAccess\"
						(
							\"tabId\",
							\"groupId\",
							\"tabAccessValue\"
					) VALUES";
		}
		foreach ($data as $row) {
			/**
			 *	By Default  No Access
			 **/
			$sqlLooping.="(
							'" . $lastId . "',
							 '" . $row['groupId'] . "',
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
		 *	 insert default value to detail table .English only
		 **/
		if ($this->getVendor() == self::mysql) {
			$sql = "
		 	INSERT INTO `leafTranslate`
		 		(
				 	`leafId`,
				 	`languageId`,
					`leafTranslate`
				) VALUES (
					'" . $lastId . "\",
					21,
					'" . $_POST['tabNote'] . "'
				);";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
		 	INSERT INTO  [leafTranslate]
					(
					 	[leafId],
						[languageId],
						[leafTranslate]
					) VALUES (
						'" . $lastId . "',
						21,
						'" . $_POST['tabNote'] . "'
					);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
		 	INSERT INTO	\"leafTranslate\"
					(
					 	\"leafId\",
						\"languageId\",
						\"leafTranslate\"
					) VALUES (
						'" . $lastId . "',
						21,
						'" . $_POST['tabNote'] . "'
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
            "tabId" => $lastId
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
			if($this->q->vendor == self :: mysql) {
				$this->auditFilter = "	`tab`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[tab].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"tab\".\"isActive\"	=	1	";
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
		if ($this->getVendor() == self::mysql) {
			/**
			 *	UTF 8
			 **/
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
			SELECT		*
			FROM 		`tab`
			LEFT JOIN 	`icon`
			USING 		(`iconId`)
			WHERE 		`tab`.`isActive`	=	1
			AND			`icon`.`isActive`		=	1 ";
			if (($this->model->gettabId('','string'))) {
				$sql .= " AND `".$this->model->getPrimaryKeyName()."`='" . $this->strict($this->model->gettabId('','string'), 'numeric') . "'";
			}
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			SELECT		*
			FROM 		[tab]
			LEFT JOIN 	[icon]
			ON 			[icon].[iconId] = [tab].[iconId]
			WHERE 		[tab].[isActive]	=	1
			AND			[icon].[iconId]			=	1";
			if (($this->model->gettabId('','string'))) {
				$sql .= " AND [".$this->model->getPrimaryKeyName()."]='" . $this->strict($this->model->gettabId('','string'), 'numeric') . "'";
			}
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT		*
			FROM 		\"tab\"
			LEFT JOIN 	\"icon\"
			USING 		(\"iconId\")
			WHERE 		\"tab\".\"isActive\"	=	1
			AND			\"icon\".\"isActive\"		=	1";
			if (($this->model->gettabId('','string'))) {
				$sql .= " AND \"".$this->model->getPrimaryKeyName()."\"='" . $this->strict($this->model->gettabId('','string'), 'numeric') . "'";
			}
		}
		if ($this->quickFilter) {
			/**
			 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
			 *  E.g  $filterArray=array('`leaf`.`leafId`');
			 *  @variables $filterArray;
			 */
			$filterArray = array(
                "tabId",
                "tabTranslateId"
                );
                /**
                 *	filter table
                 *  @variables $tableArray
                 */
                $tableArray  = array(
                'tab',
                'tabTranslate'
                );
                if ($this->q->vendor == 'normal' || $this->q->vendor == 'mysql') {
                	$sql .= $this->q->quickSearch($tableArray, $filterArray);
                } else if ($this->q->vendor == 'microsoft') {
                	$tempSql = $this->q->quickSearch($tableArray, $filterArray);
                	$sql .= $tempSql;
                } else if ($this->q->vendor == 'oracle') {
                	$tempSql = $this->q->quickSearch($tableArray, $filterArray);
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
					WITH [tabDerived] AS
					(
						SELECT *,
						ROW_NUMBER() OVER (ORDER BY [tabId]) AS 'RowNumber'
						FROM [tab]
						WHERE [tab].[isActive] =1   " . $tempSql . $tempSql2 . "
					)
					SELECT		*
					FROM 		[tabDerived]
					WHERE 		[RowNumber]
					BETWEEN	" . $_POST['start'] . "
					AND 			" . ($_POST['start'] + $_POST['limit'] - 1) . ";";
				} else if ($this->getVendor() == self::oracle) {
					/**
					 *  Oracle using derived table also
					 */
					$sql = "
				SELECT *
				FROM ( SELECT	a.*,
										rownum r
				FROM (
							SELECT *
							FROM 	\"tab\"
							WHERE \"isActive\"=1  " . $tempSql . $tempSql2 . $orderBy . "
						 ) a
				where rownum <= '" . ($_POST['start'] + $_POST['limit'] - 1) . "' )
				where r >=  '" . $_POST['start'] . "'";
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
	 if ($this->model->getTabId('','string')) {
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
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->update();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE 	`tab`
			SET 	`tabSequence`	= 	'" . $this->model->getTabSequence() . "',
					`tabNote`		=	'" . $this->model->getTabNote() . "',
					`iconId`			=	'" . $this->model->getIconId() . "',
					`isActive`			=	'" . $this->model->getIsActive('','string') . "',
					`isNew`				=	'" . $this->model->getIsNew('','string') . "',
					`isDraft`			=	'" . $this->model->getIsDraft('','string') . "',
					`isUpdate`			=	'" . $this->model->getIsUpdate('','string') . "',
					`isDelete`			=	'" . $this->model->getIsDelete('','string') . "',
					`isApproved`		=	'" . $this->model->getIsApproved('','string') . "',
					`By`				=	'" . $this->model->getBy() . "',
					`Time				=	" . $this->model->getTime() . "
			WHERE 	`tabId`		=	'" . $this->model->tabId . "'";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			UPDATE 	[tab]
			SET 	[tabSequence]	= 	'" . $this->model->tabSequence . "',
					[tabNote]		=	'" . $this->model->tabNote . "',
					[iconId]			=	'" . $this->model->iconId . "',
					[isActive]			=	'" . $this->model->getIsActive('','string') . "',
					[isNew]				=	'" . $this->model->getIsNew('','string') . "',
					[isDraft]			=	'" . $this->model->getIsDraft('','string') . "',
					[isUpdate]			=	'" . $this->model->getIsUpdate('','string') . "',
					[isDelete]			=	'" . $this->model->getIsDelete('','string') . "',
					[isApproved]		=	'" . $this->model->getIsApproved('','string') . "',
					[By]				=	'" . $this->model->getBy() . "',
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[tabId]		=	'" . $this->model->tabId . "'";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	\"tab\"
			SET 	\"tabSequence\"	= 	'" . $this->model->tabSequence . "',
					\"tabNote\"		=	'" . $this->model->tabNote . "',
					\"iconId\"				=	'" . $this->model->iconId . "',
					\"isActive\"			=	'" . $this->model->getIsActive('','string') . "',
					\"isNew\"				=	'" . $this->model->getIsNew('','string') . "',
					\"isDraft\"				=	'" . $this->model->getIsDraft('','string') . "',
					\"isUpdate\"			=	'" . $this->model->getIsUpdate('','string') . "',
					\"isDelete\"			=	'" . $this->model->getIsDelete('','string') . "',
					\"isApproved\"			=	'" . $this->model->getIsApproved('','string') . "',
					\"By\"					=	'" . $this->model->getBy() . "',
					\"Time\"				=	" . $this->model->getTime() . "
			WHERE 	\"tabId\"			=	'" . $this->model->tabId . "'";
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
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->delete();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE 	`tab`
			SET 	`isActive`			=	'" . $this->model->getIsActive('','string') . "',
					`isNew`				=	'" . $this->model->getIsNew('','string') . "',
					`isDraft`			=	'" . $this->model->getIsDraft('','string') . "',
					`isUpdate`			=	'" . $this->model->getIsUpdate('','string') . "',
					`isDelete`			=	'" . $this->model->getIsDelete('','string') . "',
					`isApproved`		=	'" . $this->model->getIsApproved('','string') . "',
					`By`				=	'" . $this->model->getBy() . "',
					`Time				=	" . $this->model->getTime() . "
			WHERE 	`tabId`		=	'" . $this->model->tabId . "'";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			UPDATE 	[tab]
			SET 	[isActive]			=	'" . $this->model->getIsActive('','string') . "',
					[isNew]				=	'" . $this->model->getIsNew('','string') . "',
					[isDraft]			=	'" . $this->model->getIsDraft('','string') . "',
					[isUpdate]			=	'" . $this->model->getIsUpdate('','string') . "',
					[isDelete]			=	'" . $this->model->getIsDelete('','string') . "',
					[isApproved]		=	'" . $this->model->getIsApproved('','string') . "',
					[By]				=	'" . $this->model->getBy() . "',
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[tabId]		=	'" . $this->model->tabId . "'";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	\"tab\"
			SET 	\"isActive\"	=	'" . $this->model->getIsActive('','string') . "',
					\"isNew\"		=	'" . $this->model->getIsNew('','string') . "',
					\"isDraft\"		=	'" . $this->model->getIsDraft('','string') . "',
					\"isUpdate\"	=	'" . $this->model->getIsUpdate('','string') . "',
					\"isDelete\"	=	'" . $this->model->getIsDelete('','string') . "',
					\"isApproved\"	=	'" . $this->model->getIsApproved('','string') . "',
					\"By\"			=	'" . $this->model->getBy() . "',
					\"Time\"		=	" . $this->model->getTime() . "
			WHERE 	\"tabId\"			=	'" . $this->model->tabId . "'";
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
	 *  Read Record From tabTranslate Table
	 */
	function translateRead()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			/**
			 *	UTF 8
			 **/
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		if ($this->q->vendor = 'mysql') {
			$sql = "
			SELECT	*
			FROM 	`tabTranslate`
			JOIN 	`language`
			USING (`languageId`)
			WHERE	`tabTranslate`.`tabId`='" . $this->strict($_POST['tabId'], 'numeric') . "'";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			SELECT	*
			FROM 	[tabTranslate]
			JOIN 	[language]
			ON 		[tabTranslate].[languageId] =[language].[languageId]
			WHERE	[tabTranslate].[tabId]='" . $this->strict($_POST['tabId'], 'numeric') . "'";
		} else if ($this->q->vendor == 'oralce') {
			$sql = "
			SELECT	*
			FROM 	\"tabTranslate\"
			JOIN 	\"language\"
			USING (\"languageId\")
			WHERE	\"tabTranslate\".\"tabId\"='" . $this->strict($_POST['tabId'], 'numeric') . "'";
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
	 * Update tab Translation in tabTranslate Table
	 */
	public function translateUpdate()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		$this->q->commit();
		if ($this->getVendor() == self::mysql) {
			$sql = "
		UPDATE	`tabTranslate`
		SET		`tabTranslate` 	=	'" . $this->strict($_POST['tabTranslate'], 'string') . "'
		WHERE 	`tabTranslateId`	=	'" . $this->strict($_POST['tabTranslateId'], 'numeric') . "'";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
		UPDATE	[tabTranslate]
		SET		[tabTranslate] 	=	'" . $this->strict($_POST['tabTranslate'], 'string') . "'
		WHERE 	[tabTranslateId]	=	'" . $this->strict($_POST['tabTranslateId'], 'numeric') . "'";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
		UPDATE	\"tabTranslate\"
		SET		\"tabTranslate\" 		=	'" . $this->strict($_POST['tabTranslate'], 'string') . "'
		WHERE 	\"tabTranslateId\"	=	'" . $this->strict($_POST['tabTranslateId'], 'numeric') . "'";
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
	 * Create Translation tab Note to the tabTranslate Table
	 */
	function translateMe()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		$this->q->start();
		if ($this->q->vendor == 'normal' || $this->q->vendor == 'mysql') {
			$sql = "
			SELECT	*
			FROM 	`tab`
			WHERE 	`tabId`	=	'" . $this->tabId . "'";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			SELECT	*
			FROM 	[tab]
			WHERE 	`tabId`	=	'" . $this->tabId . "'";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT	*
			FROM 	\"tab\"
			WHERE 	`tabId`	=	'" . $this->tabId . "'";
		}
		$resultDefault = $this->q->fast($sql);
		if ($this->q->numberRows($resultDefault) > 0) {
			$rowDefault = $this->q->fetch_array($resultDefault);
			$value      = $rowDefault['tabNote'];
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
				FROM 	`tabTranslate`
				WHERE 	`tabId`			=	'" . $this->tabId . "'
				AND 	`languageId`			=	'" . $languageId . "'";
			} else if ($this->getVendor() ==  self::mssql) {
				$sql = "
				SELECT	*
				FROM 	[tabTranslate]
				WHERE 	[tabId]			=	'" . $this->tabId . "'
				AND 	[languageId]			=	'" . $languageId . "'";
			} else if ($this->getVendor() == self::oracle) {
				$sql = "
				SELECT	*
				FROM 	\"tabTranslate\"
				WHERE 	\"tabId\"			=	'" . $this->tabId . "'
				AND 	\"languageId\"			=	'" . $languageId . "'";
			}
			$resulttabTranslate = $this->q->fast($sql);
			if ($this->q->numberRows($resulttabTranslate) > 0) {
				if ($this->q->vendor == 'normal' || $this->q->vendor == 'mysql') {
					$sql = "
					UPDATE	`tabTranslate`
					SET 	`tabTranslate`		=	'" . $googleTranslate . "'
					WHERE 	`tabId`				=	'" . $this->tabdId . "'
					AND 	`languageId`				=	'" . $languageId . "'";
				} else if ($this->q->vendor == 'microsoft') {
					$sql = "
					UPDATE	[tabTranslate]
					SET 	[tabTranslate]		=	'" . $googleTranslate . "'
					WHERE 	[tabId]				=	'" . $this->tabdId . "'
					AND		[languageId]				=	'" . $languageId . "'";
				} else if ($this->getVendor() == self::oracle) {
					$sql = "
					UPDATE 	\"tabTranslate\"
					SET 	\"tabTranslate\"		=	'" . $googleTranslate . "'
					WHERE 	`tabId`				=	'" . $this->tabdId . "'
					AND 	`languageId`				=	'" . $languageId . "'";
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
					INSERT INTO	`tabTranslate`
							(
							 	`tabId`,
								`languageId`,
								`tabTranslate`
							) VALUES(
								'" . $this->tabId . "',
								'" . $languageId . "',
								'" . $googleTranslate . "'
					)";
				} else if ($this->getVendor() ==  self::mssql) {
					$sql = "
					INSERT INTO [tabTranslate]
							(
							 	[tabId],
								[languageId],
								[tabTranslate]
							) VALUES(
								'" . $this->tabId . "',
								'" . $languageId . "',
								'" . $googleTranslate . "'
							)";
				} else if ($this->getVendor() == self::oracle) {
					$sql = "
					INSERT INTO \"tabTranslate\"
							(
							 	\"tabId\",
								\"languageId\",
								\"tabTranslate\"
							) VALUES(
								'" . $this->tabId . "',
								'" . $languageId . "',
								'" . $googleTranslate . "'
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
                        	$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, $row['tabNote']);
                        	$this->excel->getActiveSheet()->setCellValue('D' . $loopRow, $row['tabDesc']);
                        	$loopRow++;
                        	$lastRow = 'D' . $loopRow;
                        }
                        $from    = 'B2';
                        $to      = $lastRow;
                        $formula = $from . ":" . $to;
                        $this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
                        $filename  = "tab" . rand(0, 10000000) . ".xlsx";
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
$tabTranslateObject = new tabClass();
if (isset($_SESSION['staffId'])) {
	$tabTranslateObject->setStaffId($_SESSION['staffId']);
}
if (isset($_SESSION['vendor'])) {
	$tabTranslateObject->setVendor($_SESSION['vendor']);
}
if(isset($_SESSION['languageId'])){
	$tabTranslateObject->setLanguageId($_SESSION['languageId']);
}

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
		$tabTranslateObject->setlLeafId($_POST['leafId']);
	}
	if(isset($_POST['isAdmin'])){
		$tabTranslateObject->setIsAdmin($_POST['isAdmin']);
	}

	/*
	 * Filtering
	 */
	if (isset($_POST['query'])) {
		$tabTranslateObject->setFieldQuery($_POST['query']);
	}
	if (isset($_POST['filter'])) {
		$tabTranslateObject->setGridQuery($_POST['filter']);
	}

	/*
	 * Ordering
	 */
	if (isset($_POST['order'])) {
		$tabTranslateObject->setOrder($_POST['order']);
	}
	if (isset($_POST['sortField'])) {
		$tabTranslateObject->setSortField($_POST['sortField']);
	}



	/*
	 *  Load the dynamic value
	 */
	$tabTranslateObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST['method'] == 'create') {
		$tabTranslateObject->create();
	}
	if ($_POST['method'] == 'read') {

		$tabTranslateObject->read();

	}
	if ($_POST['method'] == 'save') {

		$tabTranslateObject->update();

	}
	if ($_POST['method'] == 'delete') {
		$tabTranslateObject->delete();
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
		$tabTranslateObject->leafId = $_GET['leafId'];
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$tabTranslateObject->isAdmin = $_GET['isAdmin'];
	}
	/*
	 *  Load the dynamic value
	 */
	$tabTranslateObject->execute();

	if ($_GET['method'] == 'translate') {
		$tabTranslateObject->translateMe();
	}
	/*
	 *  Excel Reporting
	 */
	if (isset($_GET['mode'])) {
		if ($_GET['mode'] == 'report') {
			$tabTranslateObject->excel();
		}

	}
}

?>

