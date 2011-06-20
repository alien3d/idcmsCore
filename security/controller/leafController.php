<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/leafModel.php");
/**
 * this is leaf creation
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package leaf
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafClass extends configClass
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
	public $leafIdTemp;
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
	 * Leaf Translation Identification
	 * @var  numeric $leafTranslateId
	 */
	public $leafTranslateId;
	/**
	 * Translation update
	 * @var string $leafTranslate
	 */
	public $leafTranslate;
	/**
	 *  Class Loader
	 */
	public function execute()
	{
		parent::__construct();
		$this->q              = new vendor();
		$this->q->vendor      = $this->getVendor();
		$this->q->leafId      = $this->getLeafId();
		$this->q->staffId     = $this->getStaffId();
		$this->q->fieldQuery = $this->getFieldQuery();
		$this->q->gridQuery     = $this->getGridQuery();

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());
		$this->excel            = new PHPExcel();
		$this->audit            = 0;
		$this->log              = 1;
		$this->q->log           = $this->log;
		$this->security         = new security();
		$this->security->setVendor($this->getVendor());
		$this->security->setLeafId($this->getLeafId());
		$this->security->execute();
		$this->model         = new leafModel();
		$this->model->setVendor($this->getVendor());
		$this->model->setLeafId($this->getLeafId());
		$this->model->execute();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
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
		if ($this->getVendor() == self::mysql) {
			$sql = "
			INSERT INTO `leaf`
					(
						`tabId`,						`folderId`,
						`leafNote`,							`leafSequence`,
						`leafcode`,							`leafFilename`,
						`iconId`,							`isNew`,
						`isDraft`,							`isUpdate`,
						`isDelete`,							`isActive`,
						`isApproved`,						`By`,
						`Time`
					)
			VALUES
					(
						\"" . $this->model->getTabId('','string') . "\",			\"" . $this->model->getFolderId() . "\",
						\"" . $this->model->getLeafNote() . "\",					\"" . $this->model->getLeafSequence() . "\",
						\"" . $this->model->getLeafCode() . "\",					\"" . $this->model->getLeafFilename(). "\",
						\"" . $this->model->getIconId(). "\",						\"" . $this->model->getIsNew('', 'string') . "\",
						\"" . $this->model->getIsDraft('', 'string') . "\",			\"" . $this->model->getIsUpdate('', 'string') . "\",
						\"" . $this->model->getIsDelete('', 'string') . "\",		\"" . $this->model->getIsActive('', 'string') . "\",
						\"" . $this->model->getIsApproved('', 'string') . "\",		\"" . $this->model->staffId . "\",
						" . $this->model->getTime() . "
					) ";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			INSERT INTO [leaf]
					(
						[tabId],					[folderId],
						[leafNote],						[leafSequence],
						[leafCode],						[leafFilename],
						[iconId],						[isNew],
						[isDraft],						[isUpdate],
						[isDelete],						[isActive],
						[isApproved],					[By],
						[Time]
					)
			VALUES
					(
						\"" . $this->model->getTabId('','string') . "\",			\"" . $this->model->getFolderId() . "\",
						\"" . $this->model->getLeafNote() . "\",					\"" . $this->model->getLeafSequence() . "\",
						\"" . $this->model->getLeafCode() . "\",					\"" . $this->model->getLeafFilename(). "\",
						\"" . $this->model->getIconId(). "\",						\"" . $this->model->getIsNew('', 'string') . "\",
						\"" . $this->model->getIsDraft('', 'string') . "\",			\"" . $this->model->getIsUpdate('', 'string') . "\",
						\"" . $this->model->getIsDelete('', 'string') . "\",		\"" . $this->model->getIsActive('', 'string') . "\",
						\"" . $this->model->getIsApproved('', 'string') . "\",		\"" . $this->model->staffId . "\",
						" . $this->model->getTime() . "
					)";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			INSERT INTO \"leaf\"
					(
						\"tabId\",					\"folderId\",
						\"leafNote\",						\"leafSequence\",
						\"leafCode\",						\"leafFilename\",
						\"iconId\",							\"isNew\",
						\"isDraft\",						\"isUpdate\",
						\"isDelete\",						\"isActive\",
						\"isApproved\",						\"By\",
						\"Time\"
					)
			VALUES
					(
							\"" . $this->model->getTabId('','string') . "\",			\"" . $this->model->getFolderId() . "\",
						\"" . $this->model->getLeafNote() . "\",					\"" . $this->model->getLeafSequence() . "\",
						\"" . $this->model->getLeafCode() . "\",					\"" . $this->model->getLeafFilename(). "\",
						\"" . $this->model->getIconId(). "\",						\"" . $this->model->getIsNew('', 'string') . "\",
						\"" . $this->model->getIsDraft('', 'string') . "\",			\"" . $this->model->getIsUpdate('', 'string') . "\",
						\"" . $this->model->getIsDelete('', 'string') . "\",		\"" . $this->model->getIsActive('', 'string') . "\",
						\"" . $this->model->getIsApproved('', 'string') . "\",		\"" . $this->model->staffId . "\",
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
		// loop the group
		if($this->getVendor()==self::mysql) {
			$sql = "
			SELECT 	*
			FROM 	`staff`
			WHERE 	`isActive`	=	1 ";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			SELECT 	*
			FROM 	[staff]
			WHERE 	[isActive]	=	1 ";
		} else if ($this->q->vendor == self::mysql) {
			$sql = "SELECT * FROM \"staff\" WHERE \"isActive\"	=	1 ";
		}
		$this->q->read($sql);
		$data = $this->q->activeRecord();

		foreach ($data as $row) {
			// by default no access
			$sqlLooping .= "
				(
					\"" . $lastId . "\",				\"" . $row['staffId'] . "\",
					\"0\",						\"0\",
					\"0\",						\"0\",
					\"0\",						\"0\",
					\"0\"
				),";
		}
		// optimize to 1 Query
	if ($this->getVendor() == self::mysql) {
			$sql = "
			INSERT INTO	`leafAccess`
					(
						`leafId`,					`staffId`,
						`leafReadAccessValue`,		`leafCreateAccessValue`,
						`leafUpdateAccessValue`,	`leafDeleteAccessValue`,
						`leafPrintAccessValue`,		`leafPostAccessValue`,
						`leafDraftAccessValue`
					)
			VALUES";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			INSERT INTO	[leafAccess]
				(
					[leafId],					[staffId],
					[leafReadAccessValue],		[leafCreateAccessValue],
					[leafUpdateAccessValue],	[leafDeleteAccessValue],
					[leafPrintAccessValue],		[leafPostAccessValue],
					[leafDraftAccessValue]
				)
			VALUES";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			INSERT INTO 	\"leafAccess\"
						(
							\"leafId\",					\"staffId\",
							\"leafReadAccessValue\",	\"leafCreateAccessValue\",
							\"leafUpdateAccessValue\",	\"leafDeleteAccessValue\",
							\"leafPrintAccessValue\",	\"leafPostAccessValue\",
							\"leafDraftAccessValue\"
						)
			VALUES";
		}
		// remove last comma
		$sqlLooping= substr($sqlLooping, 0, -1);
		// combine SQL Statement
		$sql .= $sqlLooping;
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
            "leafId" => $lastId,
            "message" => "Record Created"
            ));
            exit();
	}
	function read()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if($this->isAdmin == 0) {
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	`leaf`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[leaf].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"leaf\".\"isActive\"	=	1	";
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
			//UTF8
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		// everything given flexibility  on todo
		if ($this->getVendor() == self::mysql) {
			$sql = "
			SELECT		*
			FROM 		`leaf`
			JOIN		`folder`
			USING		(`folderId`,`tabId`)
			JOIN		`tab`
			USING		(`tabId`)
			LEFT JOIN	`icon`
			ON			`leaf`.`iconId`=`icon`.`iconId`
			WHERE 		".$this->auditFilter."
			AND			`folder`.`isActive`		=	1
			AND			`tab`.`isActive`	= 1 ";
			if ($this->model->getLeafId('','string')) {
				$sql .= " AND `".$this->model->getTableName()."`.`".$this->model->getPrimaryKeyName()."`='" . $this->model->getLeafId('','string') . "'";
			}

		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			SELECT		*
			FROM 		[leaf]
			JOIN		[folder]
			ON			[leaf].[folderId] 			=	[folder].[folderId]
			AND			[leaf].[tabId] 		=	[folder].[tabId]
			JOIN		[tab]
			ON			[leaf].[tabId] 		=	[tab].[tabId]
			LEFT JOIN	[icon]
			ON			[leaf].[iconId]				=	[icon].[iconId]
			WHERE 		[folder].[isActive]			=	1
			AND			[tab].[isActive]		=	1
			AND			[leaf].[isActive]			=	1 ";
			if ($this->model->getLeafId('','string')) {
				$sql .= " AND [".$this->model->getTableName()."].[".$this->model->getPrimaryKeyName()."]='" . $this->model->getLeafId('','string') . "'";
			}
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT		*
			FROM 		\"leaf`
			JOIN		\"folder`
			USING		(\"folderId\",\"tabId\")
			JOIN		\"tab\"
			USING		(\"tabId\")
			LEFT JOIN	\"icon\"
			ON			\"leaf\".\"iconId\"=\"icon\".\"iconId\"
			WHERE 		\"folder\".\"isActive\"		=	1
			AND			\"tab\".`isActive\"	=	1
			AND			\"leaf\".`isActive\"		=	1 ";
			if ($this->model->getLeafId('','string')) {
				$sql .= " AND \"".$this->model->getTableName()."\".\"".$this->model->getPrimaryKeyName()."\"='" .$this->model->getLeafId('','string') . "'";
			}
		}
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		$filterArray = array(
            "`leaf`.`leafFilename`"
            );
            /**
             *	filter table
             * @variables $tableArray
             */
            $tableArray  = array(
            'tab',
            'tabTranslate',
            'folder',
            'folderTranslate',
            'leaf',
            'leafTranslate'
            );
            if ($this->getfieldQuery()) {
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
            //echo $sql;
            $this->q->read($sql);
            $total = $this->q->numberRows();
            if (empty($_GET['dir'])) {
            	$dir = 'ASC';
            } else {
            	$dir = $_GET['dir'];
            }
            if (empty($_POST['sort'])) {
            	$sortField = "leafId";
            } else {
            	$sortField = $_POST['sort'];
            }
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
            $_SESSION['start'] = $_POST['start'];
            $_SESSION['limit'] = $_POST['limit'];
            if (empty($_POST['filter'])) {
            	if (isset($_POST['start']) && isset($_POST['limit'])) {
            		// only mysql have limit
            		if ($this->getVendor() == self::mysql) {
            			$sql .= " LIMIT  " . $_POST['start'] . "," . $_POST['limit'] . " ";
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
							SELECT		*
							FROM 		[religionDerived]
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
									FROM 	\"religion\"
									WHERE \"isActive\"=1  " . $tempSql . $tempSql2 . $orderBy . "
								 ) a
						where rownum <= '" . ($_POST['start'] + $_POST['limit'] - 1) . "' )
						where r >=  '" . $_POST['start'] . "'";
            		} else {
            			echo "undefine vendor";
            		}
            	}
            }
            /*
             *  Only Execute One Query
             */
            if (!($this->model->getLeafId('','string'))) {
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
            //echo $strData;
            if ($this->model->getLeafId('','string')) {
            	$json_encode = json_encode(array(
                'success' => true,
                'total' => $total,
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
                'data' => $items
            	));
            	exit();
            }
	}
	/**
	 * Return tab Identification
	 */
	function tab()
	{

		return $this->security->tab();
	}
	/**
	 * Return Folder Identification
	 */
	function folder()
	{
		return $this->security->folder();
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->getVendor() == self::mysql) {
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->update();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE	`leaf`
			SET		`isActive`	=	'" . $this->model->getIsActive . "',
					`isNew`		=	'" . $this->model->getIsNew . "',
					`isDraft`	=	'" . $this->model->getIsDraft . "',
					`isUpdate`	=	'" . $this->model->getIsUpdate . "',
					`isDelete`	=	'" . $this->model->getIsDelete . "',
					`isApproved`=	'" . $this->model->getIsApproved . "',
					`By`		=	'" . $this->model->getBy() . "',
					`Time		=	" . $this->model->getTime . "
			WHERE 	`leafId`	=	'" . $this->leafId . "'";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			UPDATE	[leaf]
			SET		[isActive]	=	'" . $this->model->getIsActive . "',
					[isNew]		=	'" . $this->model->getIsNew . "',
					[isDraft]	=	'" . $this->model->getIsDraft . "',
					[isUpdate]	=	'" . $this->model->getIsUpdate . "',
					[isDelete]	=	'" . $this->model->getIsDelete . "',
					[isApproved]=	'" . $this->model->getIsApproved . "',
					[By]		=	'" . $this->model->getBy() . "',
					[Time]		=	" . $this->model->getTime . "
			WHERE 	[leafId]	=	'" . $this->leafId . "'";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE	\"leaf\"
			SET		\"isActive\"	=	'" . $this->model->getIsActive . "',
					\"isNew\"		=	'" . $this->model->getIsNew . "',
					\"isDraft\"		=	'" . $this->model->getIsDraft . "',
					\"isUpdate\"	=	'" . $this->model->getIsUpdate . "',
					\"isDelete\"	=	'" . $this->model->getIsDelete . "',
					\"isApproved\"	=	'" . $this->model->getIsApproved . "',
					\"By\"			=	'" . $this->model->getBy() . "',
					\"Time\"		=	" . $this->model->getTime . "
			WHERE 	\"leafId\"		=	'" . $this->leafId . "'";
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
            "message" => "Record Update"
            ));
            exit();
	}
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
			UPDATE	`leaf`
			SET		`isActive`	=	'" . $this->model->getIsActive . "',
					`isNew`		=	'" . $this->model->getIsNew . "',
					`isDraft`	=	'" . $this->model->getIsDraft . "',
					`isUpdate`	=	'" . $this->model->getIsUpdate . "',
					`isDelete`	=	'" . $this->model->getIsDelete . "',
					`isApproved`=	'" . $this->model->getIsApproved . "',
					`By`		=	'" . $this->model->getBy() . "',
					`Time		=	" . $this->model->getTime . "
			WHERE 	`leafId`	=	'" . $this->leafId . "'";
		} else if ($this->getVendor() == self::mssql) {
			$sql = "
			UPDATE	[leaf]
			SET		[isActive]	=	'" . $this->model->getIsActive . "',
					[isNew]		=	'" . $this->model->getIsNew . "',
					[isDraft]	=	'" . $this->model->getIsDraft . "',
					[isUpdate]	=	'" . $this->model->getIsUpdate . "',
					[isDelete]	=	'" . $this->model->getIsDelete . "',
					[isApproved]=	'" . $this->model->getIsApproved . "',
					[By]		=	'" . $this->model->getBy() . "',
					[Time]		=	" . $this->model->getTime . "
			WHERE 	[leafId]	=	'" . $this->leafId . "'";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE	\"leaf\"
			SET		\"isActive\"	=	'" . $this->model->getIsActive . "',
					\"isNew\"		=	'" . $this->model->getIsNew . "',
					\"isDraft\"		=	'" . $this->model->getIsDraft . "',
					\"isUpdate\"	=	'" . $this->model->getIsUpdate . "',
					\"isDelete\"	=	'" . $this->model->getIsDelete . "',
					\"isApproved\"	=	'" . $this->model->getIsApproved . "',
					\"By\"			=	'" . $this->model->getBy() . "',
					\"Time\"		=	" . $this->model->getTime . "
			WHERE 	\"leafId\"		=	'" . $this->leafId . "'";
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
            "message" => "Record Remove"
            ));
            exit();
	}

	public function nextSequence()
	{
		$this->security->nextSequence();
	}
	/* (non-PHPdoc)
	 * @see config::excel()
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
                        $this->q->numberRows();
                        $i = 0;
                        while ($row = $this->q->fetchAssoc()) {
                        	//	echo print_r($row);
                        	$this->excel->getActiveSheet()->setCellValue('B' . $loopRow, ++$i);
                        	$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, $row['leafNote']);
                        	$this->excel->getActiveSheet()->setCellValue('D' . $loopRow, $row['leafCode']);
                        	$loopRow++;
                        	$lastRow = 'D' . $loopRow;
                        }
                        $from    = 'B2';
                        $to      = $lastRow;
                        $formula = $from . ":" . $to;
                        $this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
                        $filename  = "leaf" . rand(0, 10000000) . ".xlsx";
                        $path      = $_SERVER['document_root'] . "/" . $this->application . "/security/document/excel/" . $filename;
                        $objWriter->save($path);
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
//echo "string".$_GET['leafId'];
$leafObject = new leafClass();
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
	if (isset($_POST['leafIdTemp'])) {
		$leafObject->setLeafId($_POST['leafIdTemp']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_POST['isAdmin'])) {
		$leafObject->setIsAdmin($_POST['isAdmin']);
	}
	/*
	 *  Filtering
	 */
	if (isset($_POST['query'])) {
		$leafObject->setFieldQuery($_POST['query']);
	}
	if (isset($_POST['filter'])) {
		$leafObject->setGridQuery($_POST['filter']);
	}
	/*
	 *  Ordering
	 */
	if (isset($_POST['order'])) {
		$leafObject->setOrder($_POST['order']);
	}
	if (isset($_POST['sortField'])) {
		$leafObject->setSortField($_POST['sortField']);
	}
	/*
	 * Translation
	 */
	if (isset($_POST['leafTranslate'])) {
		$leafObject->leafTranslate = $_POST['leafTranslate'];
	}
	/*
	 *  Load the dynamic value
	 */
	$leafObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST['method'] == 'create') {
		$leafObject->create();
	}
	if ($_POST['method'] == 'read') {
		$leafObject->read();
	}
	if ($_POST['method'] == 'save') {
		$leafObject->update();
	}
	if ($_POST['method'] == 'delete') {
		$leafObject->delete();
	}
}
if (isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf /Application
	 */
	if (isset($_GET['leafIdTemp'])) {
		$leafObject->setLeafId($_GET['leafIdTemp']);
	}
	/*
	 * Admin Only
	 */
	if (isset($_GET['isAdmin'])) {
		$leafObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$leafObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$leafObject->staff();
		}
		if ($_GET['field'] == 'tabId') {

			$leafObject->tab();
		}
		if ($_GET['field'] == 'folderId') {
			$leafObject->folder();
		}
		if ($_GET['field'] == 'sequence') {
			$leafObject->nextSequence();
		}
	}
	if (isset($_GET['mode'])) {
		if ($_GET['mode'] == 'excel') {
			$leafObject->excel();
		}
	}
}
?>
