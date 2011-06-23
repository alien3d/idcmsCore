<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/tabModel.php");
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
	 * Class Loader
	 */
	function execute()
	{
		parent::__construct();
		$this->q              = new vendor();
		$this->q->vendor      = $this->getVendor();
		$this->q->leafId      = $this->getLeafId();
		$this->q->staffId     = $this->getStaffId();
		$this->q->fieldQuery     = $this->getFieldQuery();
		$this->q->gridQuery = $this->getGridQuery();
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());
		$this->excel             = new PHPExcel();
		$this->audit             = 0;
		$this->log               = 1;
		$this->q->log            = $this->log;
		$this->defaultLanguageId = 21;
		$this->security          = new security();
		$this->security->setVendor($this->getVendor());
		$this->security->setLeafId($this->getLeafId());
		$this->security->execute();
		$this->model         = new tabModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();
		$this->documentTrail = new documentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->execute();
	}
	function create()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES utf8";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->create();
		/**
		 * Example  using Constant .This much cleaner approch  to Sql Statement
		 */

		if ($this->getVendor() == self::mysql) {
			$sql = "
			INSERT INTO `tab`
					(
						`iconId`,							`tabSequence`,
						`tabCode`,							`tabNote`,
						`isDefault`,							`isNew`,
						`isDraft`,							`isUpdate`,
						`isDelete`,							`isActive`,
						`isApproved`,						`By`,
						`Time`
					)
			VALUES
					(
						\"" . $this->model->getIconId() . "\",					\"" . $this->model->getTabSequence() . "\",
						\"" . $this->model->getTabCode() . "\",					\"" . $this->model->getTabNote() . "\",
						\"".$this->model->getIsDefault('','string')."\",		\"" . $this->model->getIsNew('','string') . "\",
						\"" . $this->model->getIsDraft('','string') . "\",		\"" . $this->model->getIsUpdate('','string') . "\",
						\"" . $this->model->getIsDelete('','string') . "\",		\"" . $this->model->getIsActive('','string') . "\",
						\"" . $this->model->getIsApproved('','string') . "\",	\"" . $this->model->getBy() . "\",
						" . $this->model->getTime() . "
					);";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			INSERT INTO [tab]
					(
						[iconId],							[tabSequence],
						[tabCode],							[tabNote],
						[isDefault],						[isNew],
						[isDraft],							[isUpdate],
						[isDelete],							[isActive],
						[isApproved],						[By],
						[Time]
					)
			VALUES
					(
						\"" . $this->model->getIconId() . "\",					\"" . $this->model->getTabSequence() . "\",
						\"" . $this->model->getTabCode() . "\",					\"" . $this->model->getTabNote() . "\",
						\"".$this->model->getIsDefault('','string')."\",		\"" . $this->model->getIsNew('','string') . "\",
						\"" . $this->model->getIsDraft('','string') . "\",		\"" . $this->model->getIsUpdate('','string') . "\",
						\"" . $this->model->getIsDelete('','string') . "\",		\"" . $this->model->getIsActive('','string') . "\",
						\"" . $this->model->getIsApproved('','string') . "\",	\"" . $this->model->getBy() . "\",
						" . $this->model->getTime() . "
					);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			INSERT INTO \"tab\"
					(
						\"iconId\",							\"tabSequence\",
						\"tabCode\",						\"tabNote\",
						\"isDefault\",						\"isNew\",
						\"isDraft\",						\"isUpdate\",
						\"isDelete\",						\"isActive\",
						\"isApproved\",						\"By\",
						\"Time\"
					)
			VALUES
					(
						\"" . $this->model->getIconId() . "\",					\"" . $this->model->getTabSequence() . "\",
						\"" . $this->model->getTabCode() . "\",					\"" . $this->model->getTabNote() . "\",
						\"".$this->model->getIsDefault('','string')."\",		\"" . $this->model->getIsNew('','string') . "\",
						\"" . $this->model->getIsDraft('','string') . "\",		\"" . $this->model->getIsUpdate('','string') . "\",
						\"" . $this->model->getIsDelete('','string') . "\",		\"" . $this->model->getIsActive('','string') . "\",
						\"" . $this->model->getIsApproved('','string') . "\",	\"" . $this->model->getBy() . "\",
						" . $this->model->getTime() . "
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

		$lastId    = $this->q->lastInsertId();
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

		foreach ($data as $row) {
			/**
			 *	By Default  No Access
			 **/
			echo		$sqlLooping.="(
							\"" . $lastId . "\",
							 \"" . $row['groupId'] . "\",
							 \"0\"
						),";





		}
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
		// optimize to 1 Query
		// remove last comma
		$sqlLooping = substr($sqlLooping,0,-1);
		// combine SQL Statement
		$sql.=$sqlLooping;
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
		 	INSERT INTO `tabTranslate`
		 		(
				 	`tabId`,
				 	`languageId`,
					`tabTranslate`
				) VALUES (
					\"" . $lastId . "\",
					21,
					\"" . $this->model->getTabNote() . "\"
				);";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
		 	INSERT INTO  [tabTranslate]
					(
					 	[tabId],
						[languageId],
						[tabTranslate]
					) VALUES (
						\"" . $lastId . "\",
						21,
						\"" .  $this->model->getTabNote() . "\"
					);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
		 	INSERT INTO	\"tabTranslate\"
					(
					 	\"tabId\",
						\"languageId\",
						\"tabTranslate\"
					) VALUES (
						\"" . $lastId . "\",
						21,
						\"" .  $this->model->getTabNote() . "\"
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
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	`tab`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[tab].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"tab\".\"isActive\"	=	1	";
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
			$sql = "SET NAMES utf8";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
					SELECT	`tab`.`tabId`,
							`tab`.`iconId`,
							`tab`.`tabSequence`,
							`tab`.`tabCode`,
							`tab`.`tabNote`,
							`tab`.`isDefault`,
							`tab`.`isNew`,
							`tab`.`isDraft`,
							`tab`.`isUpdate`,
							`tab`.`isDelete`,
							`tab`.`isActive`,
							`tab`.`isApproved`,
							`tab`.`By`,
							`tab`.`Time`,
							`staff`.`staffName`,
							`icon`.`iconName`
 					FROM 	`tab`
					JOIN	`staff`
					ON		`tab`.`By` = `staff`.`staffId`
					LEFT 	JOIN	`icon`
					USING			(`iconId`)
					WHERE 	".$this->auditFilter;
			if ($this->model->getTabId('','string')) {
				$sql .= " AND `".$this->model->getTableName()."`.`".$this->model->getPrimaryKeyName()."`=\"". $this->model->gettabId('','string') . "\"";

			}

		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
					SELECT	[tab].[tabId],
							[tab].[iconId],
							[tab].[tabSequence],
							[tab].[tabCode],
							[tab].[tabNote],
							[tab].[isDefault],
							[tab].[isNew],
							[tab].[isDraft],
							[tab].[isUpdate],
							[tab].[isDelete],
							[tab].[isActive],
							[tab].[isApproved],
							[tab].[By],
							[tab].[Time],
							[staff].[staffName],
							[icon].[iconName]
					FROM 	[tab]
					JOIN	[staff]
					ON		[tab].[By] = [staff].[staffId]
					LEFT 	JOIN	`icon`
					ON		[iconId].[iconId] = [tab].[iconId]
					WHERE 	[tab].[isActive] ='1'	";
			if ($this->model->getTabId('','string')) {
				$sql .= " AND [".$this->model->getTableName()."].[".$this->model->getPrimaryKeyName()."]=\"". $this->model->gettabId('','string') . "\"";
			}
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
					SELECT	\"tab\".\"tabId\",
							\"tab\".\"iconId\",
							\"tab\".\"tabCode\",
							\"tab\".\"tabSequence\",
							\"tab\".\"tabNote\",
							\"tab\".\"isDefault\",
							\"tab\".\"isNew\",
							\"tab\".\"isDraft\",
							\"tab\".\"isUpdate\",
							\"tab\".\"isDelete\",
							\"tab\".\"isActive\",
							\"tab\".\"isApproved\",
							\"tab\".\"By\",
							\"tab\".\"Time\",
							\"staff\".\"staffName\",
							\"icon\".\"iconName\"
					FROM 	\"tab\"
					JOIN	\"staff\"
					ON		\"tab\".\"By\" = \"staff\".\"staffId\"
					LEFT 	JOIN	\"icon\"
					USING	(\"iconId\")
					WHERE 	\"isActive\"='1'	";
			if ($this->model->getTabId('','string')) {
				$sql .= " AND \"".$this->model->getTableName()."\".\"".$this->model->getPrimaryKeyName()."\"=\"". $this->model->gettabId('','string') . "\"";
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
            'tabId'
            );
            /**
             *	filter table
             * @variables $tableArray
             */
            $tableArray  = null;
            $tableArray  = array(
            'tab'
            );
            if ($this->getFieldQuery()) {
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
            "message" => $this->q->realEscapeString($sql)
            ));
            exit();

            // end of optional debugger */
            $this->q->read($sql);
            if ($this->q->execute == 'fail') {
            	echo json_encode(array(
                "success" =>false,
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
            		$sql .= "	ORDER BY \"" . $this->getSortField() . "\"  " . $this->getOrder() . " ";
            	}
            }
            $_SESSION['sql']   = $sql; // push to session so can make report via excel and pdf
            $_SESSION['start'] = $this->getStart();
            $_SESSION['limit'] = $this->getLimit();
            if (!($this->getGridQuery())) {
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
							WITH [tabDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [tabId]) AS 'RowNumber'
								FROM [tab]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[tab].[tabId],
										[tab].[iconId],
										[tab].[tabSequence],
										[tab].[tabCode],
										[tab].[tabNote],
										[tab].[isDefault],
										[tab].[isNew],
										[tab].[isDraft],
										[tab].[isUpdate],
										[tab].[isDelete],
										[tab].[isApproved],
										[tab].[By],
										[tab].[Time],
										[staff].[staffName]
							FROM 		[tabDerived]
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
									SELECT  \"tab\".\"tabId\",
											\"tab\".\"iconId\",
											\"tab\".\"tabSequence\",
											\"tab\".\"tabCode\",
											\"tab\".\"tabNote\",
											\"tab\".\"isDefault\",
											\"tab\".\"isNew\",
											\"tab\".\"isDraft\",
											\"tab\".\"isUpdate\",
											\"tab\".\"isDelete\",
											\"tab\".\"isApproved\",
											\"tab\".\"By\",
											\"tab\".\"Time\",
											\"staff\".\"staffName\"
									FROM 	\"tab\"
									WHERE 	\"tab\".\"isActive\"=1  " . $tempSql . $tempSql2 . $orderBy . "
								 ) a
						where rownum <= \"". ($this->start + $this->limit - 1) . "\" )
						where r >=  \"". $this->start . "\"";
            		} else {
            			echo "undefine vendor";
            			exit();
            		}
            	}
            }
            /*
             *  Only Execute One Query
             */
            if (!($this->model->getTabId('','string'))) {
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
			$sql = "SET NAMES utf8";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->update();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE 	`tab`
			SET 	`tabSequence`		= 	\"" . $this->model->getTabSequence() . "\",
					`tabNote`			=	\"" . $this->model->getTabNote() . "\",
					`iconId`			=	\"" . $this->model->getIconId() . "\",
					`isActive`			=	\"" . $this->model->getIsActive('','string') . "\",
					`isNew`				=	\"" . $this->model->getIsNew('','string') . "\",
					`isDraft`			=	\"" . $this->model->getIsDraft('','string') . "\",
					`isUpdate`			=	\"" . $this->model->getIsUpdate('','string') . "\",
					`isDelete`			=	\"" . $this->model->getIsDelete('','string') . "\",
					`isApproved`		=	\"" . $this->model->getIsApproved('','string') . "\",
					`By`				=	\"" . $this->model->getBy() . "\",
					`Time				=	" . $this->model->getTime() . "
			WHERE 	`tabId`				=	\"" . $this->model->getTabId('','string') . "\"";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			UPDATE 	[tab]
			SET 	[tabSequence]		= 	\"" . $this->model->tabSequence . "\",
					[tabNote]			=	\"" . $this->model->tabNote . "\",
					[iconId]			=	\"" . $this->model->iconId . "\",
					[isDefault]			=	\"".$this->model->getIsDefault('','string')."\",
					[isActive]			=	\"".$this->model->getIsActive('','string')."\",
					[isNew]				=	\"".$this->model->getIsNew('','string')."\",
					[isDraft]			=	\"".$this->model->getIsDraft('','string')."\",
					[isUpdate]			=	\"".$this->model->getIsUpdate('','string')."\",
					[isDelete]			=	\"".$this->model->getIsDelete('','string')."\",
					[isApproved]		=	\"".$this->model->getIsApproved('','string')."\",
					[By]				=	\"".$this->model->getBy()."\",
					[Time]				=	".$this->model->getTime()."
			WHERE 	[tabId]				=	\"" . $this->model->getTabId('','string') . "\"";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	\"tab\"
			SET 	\"tabSequence\"		= 	\"" . $this->model->tabSequence . "\",
					\"tabNote\"			=	\"" . $this->model->tabNote . "\",
					\"iconId\"			=	\"" . $this->model->iconId . "\",
					\"isActive\"		=	\"" . $this->model->getIsActive('','string') . "\",
					\"isNew\"			=	\"" . $this->model->getIsNew('','string') . "\",
					\"isDraft\"			=	\"" . $this->model->getIsDraft('','string') . "\",
					\"isUpdate\"		=	\"" . $this->model->getIsUpdate('','string') . "\",
					\"isDelete\"		=	\"" . $this->model->getIsDelete('','string') . "\",
					\"isApproved\"		=	\"" . $this->model->getIsApproved('','string') . "\",
					\"By\"				=	\"" . $this->model->getBy() . "\",
					\"Time\"			=	" . $this->model->getTime() . "
			WHERE 	\"tabId\"			=	\"" . $this->model->getTabId('','string') . "\"";
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
			$sql = "SET NAMES utf8";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->delete();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE 	`tab`
			SET 	`isDefault`		=	\"".$this->model->getIsDefault('','string')."\",
					`isActive`		=	\"".$this->model->getIsActive('','string')."\",
					`isNew`			=	\"".$this->model->getIsNew('','string')."\",
					`isDraft`		=	\"".$this->model->getIsDraft('','string')."\",
					`isUpdate`		=	\"".$this->model->getIsUpdate('','string')."\",
					`isDelete`		=	\"".$this->model->getIsDelete('','string')."\",
					`isApproved`	=	\"".$this->model->getIsApproved('','string')."\",
					`By`			=	\"".$this->model->getBy('','string')."\",
					`Time			=	".$this->model->getTime()."
			WHERE 	`tabId`		=	\"" . $this->model->tabId . "\"";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			UPDATE 	[tab]
			SET 	[isDefault]		=	\"".$this->model->getIsDefault('','string')."\",
					[isActive]		=	\"".$this->model->getIsActive('','string')."\",
					[isNew]			=	\"".$this->model->getIsNew('','string')."\",
					[isDraft]		=	\"".$this->model->getIsDraft('','string')."\",
					[isUpdate]		=	\"".$this->model->getIsUpdate('','string')."\",
					[isDelete]		=	\"".$this->model->getIsDelete('','string')."\",
					[isApproved]	=	\"".$this->model->getIsApproved('','string')."\",
					[By]			=	\"".$this->model->getBy('','string')."\",
					[Time]			=	".$this->model->getTime()."
			WHERE 	[tabId]			=	\"" . $this->model->getTabId('','string') . "\"";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	\"tab\"
			SET 	\"isDefault\"		=	\"".$this->model->getIsDefault('','string')."\",
					\"isActive\"		=	\"".$this->model->getIsActive('','string')."\",
					\"isNew\"			=	\"".$this->model->getIsNew('','string')."\",
					\"isDraft\"			=	\"".$this->model->getIsDraft('','string')."\",
					\"isUpdate\"		=	\"".$this->model->getIsUpdate('','string')."\",
					\"isDelete\"		=	\"".$this->model->getIsDelete('','string')."\",
					\"isApproved\"		=	\"".$this->model->getIsApproved('','string')."\",
					\"By\"				=	\"".$this->model->getBy('','string')."\",
					\"Time\"			=	".$this->model->getTime()."
			WHERE 	\"tabId\"			=	\"" . $this->model->getTabId('','string') . "\"";
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
			$sql = "SET NAMES utf8";
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
$tabObject = new tabClass();


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
		$tabObject->setLeafId($_POST['leafId']);
	}
	if(isset($_POST['isAdmin'])){
		$tabObject->setIsAdmin($_POST['isAdmin']);
	}

	/*
	 * Filtering
	 */
	if (isset($_POST['query'])) {
		$tabObject->setFieldQuery($_POST['query']);
	}
	if (isset($_POST['filter'])) {
		$tabObject->setGridQuery($_POST['filter']);
	}

	/*
	 * Ordering
	 */
	if (isset($_POST['order'])) {
		$tabObject->setOrder($_POST['order']);
	}
	if (isset($_POST['sortField'])) {
		$tabObject->setSortField($_POST['sortField']);
	}



	/*
	 *  Load the dynamic value
	 */
	$tabObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST['method'] == 'create') {
		$tabObject->create();
	}
	if ($_POST['method'] == 'read') {
		$tabObject->read();
	}
	if ($_POST['method'] == 'save') {
		if ($_POST['grid'] == 'master') {
			$tabObject->update();
		}

	}
	if ($_POST['method'] == 'delete') {
		$tabObject->delete();
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
		$tabObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$tabObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$tabObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$tabObject->staff();
		}
		if ($_GET['field'] == 'sequence') {
			$tabObject->nextSequence();
		}
	}
	/*
	* Update Status of The Table. Admin Level Only
	*/
	if($_GET['method']=='updateStatus'){
		$tabObject->updateStatus();
	}
	/*
	*  Checking Any Duplication  Key
	*/
	if (isset($_GET['tabCode'])) {
		if (strlen($_GET['tabCode']) > 0) {
			$tabObject->duplicate();
		}
	}
	/*
	 *  Excel Reporting
	 */
	if (isset($_GET['mode'])) {
		if ($_GET['mode'] == 'report') {
			$tabObject->excel();
		}

	}
}

?>

