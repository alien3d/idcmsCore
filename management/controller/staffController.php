<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../class/classDocumentTrail.php");
require_once("../../class/classSecurity.php");

require_once("../model/staffModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan,yusof
 * @package staff
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class staffClass extends  configClass {
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
	 * Class Loader
	 */
	public function execute() {
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->getVendor();

		$this->q->leafId			=	$this->getLeafId();

		$this->q->staffId			=	$this->getStaffId();

		$this->q->fieldQuery 			= 	$this->getFieldQuery();

		$this->q->gridQuery		=	$this->getGridQuery();

		$this->q->connect($this->connection, $this->username,$this->database,$this->password);

		$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;

		$this->log					=   0;

		$this->q->log 				= $this->log;

		$this->model				= new staffModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->documentTrail = new documentTrailClass();

		$this->security = new security();
		$this->security->setVendor($this->getVendor());
		$this->security->setLanguageId($this->getLanguageId());
		$this->security->execute();

	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create() 				{
		header('Content-Type','application/json; charset=utf-8');
		//UTF8
		if($this->q->vendor==self::mysql || $this->q->vendor==self::mysql){
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}

		$this->q->start();
		if( $this->q->vendor==self::mysql) {
			$sql	=	"
			INSERT INTO `staff` 	(
						`staffName`,			`staffNo`,
						`staffPassword`,		`staffIc`,
						`groupId`,				`departmentId`,
						`isDefault`,			`isNew`,
						`isDraft`,				`isUpdate`,
						`isDelete`,				`isActive`,
						`isApproved`,			`By`,
						`Time`

				)  VALUES	(
					\"".$this->model->getStaffName()."',					\"".$this->model->getStaffNo()."',
					\"".md5($this->model->getStaffPassword())."',			\"".$this->model->getStaffIc()."',
					\"".$this->model->getGroupId()."',						\"".$this->model->getDepartmentId()."',
					\"". $this->model->getIsDefault('','string') . "\",		\"". $this->model->getIsNew('','string') . "\",
					\"". $this->model->getIsDraft('','string') . "\",		\"". $this->model->getIsUpdate('','string') . "\",
					\"". $this->model->getIsDelete('','string') . "\",		\"". $this->model->getIsActive('','string') . "\",
					\"". $this->model->getIsApproved('','string') . "\",	\"".$this->model->getBy()."\",
					".$this->model->getTime()."
				);";
		} else if ($this->q->vendor==self::mssql){
			$sql	=	"
				INSERT INTO [staff] 	(
							[staffName],		[staffNo],
							[staffPassword],	[staffIc],
							[groupId],			[By],
							[Time]
				)  VALUES	(
					\"".$this->model->getStaffName()."',					\"".$this->model->getStaffNo()."',
					\"".md5($this->model->getStaffPassword())."',			\"".$this->model->getStaffIc()."',
					\"".$this->model->getGroupId()."',						\"".$this->model->getDepartmentId()."',
					\"". $this->model->getIsDefault('','string') . "\",		\"". $this->model->getIsNew('','string') . "\",
					\"". $this->model->getIsDraft('','string') . "\",		\"". $this->model->getIsUpdate('','string') . "\",
					\"". $this->model->getIsDelete('','string') . "\",		\"". $this->model->getIsActive('','string') . "\",
					\"". $this->model->getIsApproved('','string') . "\",	\"".$this->model->getBy()."\",
					".$this->model->getTime()."
				);";
		} else if ($this->q->vendor='oracle'){
			$sql	=	"
				INSERT INTO \"staff\" 	(
							\"staffName\",		\"staffNo\",
							\"staffPassword\",	\"staffIc\",
							\"groupId\",		\"By\",
							\"Time\"
				)  VALUES	(
					\"".$this->model->getStaffName()."',					\"".$this->model->getStaffNo()."',
					\"".md5($this->model->getStaffPassword())."',			\"".$this->model->getStaffIc()."',
					\"".$this->model->getGroupId()."',						\"".$this->model->getDepartmentId()."',
					\"". $this->model->getIsDefault('','string') . "\",		\"". $this->model->getIsNew('','string') . "\",
					\"". $this->model->getIsDraft('','string') . "\",		\"". $this->model->getIsUpdate('','string') . "\",
					\"". $this->model->getIsDelete('','string') . "\",		\"". $this->model->getIsActive('','string') . "\",
					\"". $this->model->getIsApproved('','string') . "\",	\"".$this->model->getBy()."\",
					".$this->model->getTime()."
				);";
		}
		$this->q->create($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		$lastInsertId = $this->q->lastInsertId();
		// insert tab access
		if( $this->q->vendor==self::mysql) {
			$sql="
				SELECT	*
				FROM 	`tab`
				WHERE 	`isActive`	=	1	";
		} else if ($this->q->vendor==self::mssql) {
			$sql="
				SELECT	*
				FROM 	[tab]
				WHERE 	[isActive]	=	1	";
		} else if($this->q->vendor==self::oracle) {
			$sql="
				SELECT	*
				FROM 	\"tab\"
				WHERE 	\"isActive\"	=	1	";
		}
		$this->q->read($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		if($this->q->numberRows()> 0 ){
			$data = $this->q->activeRecord();

			foreach($data as $rowTab) {
				// check if group access define in  tabAccess else insert
				if( $this->q->vendor==self::mysql) {
					$sql="
						SELECT *
						FROM 	`tabAccess`
						WHERE 	`groupId`			=	'".$this->model->getGroupId()."'
						AND		`tabId`		=	'".$rowTab['tabId']."'";
				} else if ($this->q->vendor==self::mssql) {
					$sql="
						SELECT *
						FROM 	[tabAccess]
						WHERE 	[groupId]			=	'".$this->model->getGroupId()."'
					AND		`tabId`			=	'".$rowTab['tabId']."'";
				} else if ($this->q->vendor==self::oracle) {
					$sql="
						SELECT *
						FROM 	\"tabAccess\"
						WHERE 	\"groupId\"			=	'".$this->model->getGroupId()."'
						AND		\"tabId\"		=	'".$rowTab['tabId']."'";
				}
				$this->q->read($sql);
				if($this->q->execute=='fail'){
					echo json_encode(array("success"=>false,"message"=>$this->q->responce));
					exit();
				}
				if($this->q->numberRows() ==  0 ){

					// record don't exist create new
					if($this->q->vendor==self::mysql || $this->q->vendor='mysql'){
						$sql="
						INSERT INTO `tabAccess`	(
									`tabId`,				`groupId`,
									`tabAccessValue`
						)	VALUES(
							'".$rowTab['tabId']."',
							'".$this->model->getGroupId()."',
							'0'
						)	";
					} else if ($this->q->vendor=='microsft'){
						$sql="
						INSERT INTO [tabAccess]	(
									[tabId],				[groupId],
									[tabAccessValue]
						)	VALUES(
							'".$rowTab['tabId']."',
							'".$this->model->getGroupId()."',
							'0'					)	";
					} else if ($this->q->vendor==self::oracle){
						$sql="
						INSERT INTO \"tabAccess\"	(
									\"tabId\",				\"groupId\",
									\"tabAccessValue\"
						)	VALUES(
							'".$rowTab['tabId']."',
							'".$this->model->getGroupId()."',
							'0'
						)	";
					}
					$this->q->create($sql);
					if($this->q->execute=='fail'){
						echo json_encode(array("success"=>false,"message"=>$this->q->responce));
						exit();
					}
				}
			}
		}
		// insert folder access
		if( $this->q->vendor==self::mysql) {
			$sql="
				SELECT	*
				FROM 	`folder`
				WHERE 	`isActive`=1";
		} else if ($this->q->vendor==self::mssql) {
			$sql="
				SELECT	*
				FROM 	[folder]
				WHERE 	[isActive]=1";
		} else if ($this->q->vendor==self::oracle) {
			$sql="
				SELECT	*
				FROM 	\"folder\"
				WHERE 	\"isActive\"=1";
		}
		$this->q->read($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		if($this->q->numberRows()>0){
			$data = $this->q->activeRecord();
			foreach($data as $rowFolder) {
				// check if group access define in  tabAccess else insert
				if( $this->q->vendor==self::mysql) {
					$sql="
					SELECT *
					FROM 	`folderAccess`
					WHERE 	`groupId`='".$this->model->getGroupId()."'
					AND		`folderId`='".$rowFolder['folderId']."'";
				} else if ($this->q->vendor==self::mssql) {
					$sql="
					SELECT *
					FROM 	[folderAccess]
					WHERE 	[groupId]='".$this->model->getGroupId()."'
					AND		[folderId]='".$rowFolder['folderId']."'";
				} else if ($this->q->vendor==self::oracle) {
					$sql="
					SELECT *
					FROM 	\"folderAccess\"
					WHERE 	\"groupId\"='".$this->model->getGroupId()."'
					AND		\"folderId\"='".$rowFolder['folderId']."'";
				}
				$this->q->read($sql);
				if($this->q->execute=='fail'){
					echo json_encode(array("success"=>false,"message"=>$this->q->responce));
					exit();
				}
				if($this->q->numberRows()> 0 ){
					// record exist do nothing
				} else {
					// record don't exist create new
					if( $this->q->vendor==self::mysql) {
						$sql="
					INSERT INTO `folderAccess`
						(
								`folderId`,
								`groupId`,
								`folderAccessValue`
						)
					VALUES(
								'".$rowFolder['folderId']."',
								'".$this->model->getGroupId()."',
								'0'
					)	";
					} else if ($this->q->vendor==self::mssql) {
						$sql="
					INSERT INTO [folderAccess`
						(
								[folderId],
								[groupId],
								[folderAccessValue]
						)
					VALUES(
								'".$rowFolder['folderId']."',
								'".$this->model->getGroupId()."',
								'0'
					)	";
					} else if ($this->q->vendor==self::oracle) {
						$sql="
					INSERT INTO \"folderAccess\"
						(
								\"folderId\",
								\"groupId\",
								\"folderAccessValue\"
						)
					VALUES(
								'".$rowFolder['folderId']."',
								'".$this->model->getGroupId()."',
								'0'
					)	";
					}
					$this->q->create($sql);
					if($this->q->execute=='fail'){
						echo json_encode(array("success"=>false,"message"=>$this->q->responce));
						exit();
					}
				}
			}
		}
		// insert leaf access according to the group choosen
		if( $this->q->vendor==self::mysql) {
			$sql="
			SELECT	*
			FROM 	`leafGroupAccess`
			WHERE 	`groupId`='".$this->model->getGroupId()."' ";
		} else if ($this->q->vendor==self::mssql) {
			$sql="
			SELECT	*
			FROM 	[leafGroupAccess]
			WHERE 	[groupId]='".$this->model->getGroupId()."' ";
		} else if  ($this->q->vendor==self::oracle) {
			$sql="
			SELECT	*
			FROM 	\"leafGroupAccess\"
			WHERE 	\"groupId\"='".$this->model->getGroupId()."' ";
		}
		$this->q->read($sql);


		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		if($this->q->numberRows()> 0 ) {
			$data = $this->q->activeRecord();

			foreach ($data as  $rowLeafGroupAccess) {
				if( $this->q->vendor==self::mysql) {
					$sql="
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
							'".$rowLeafGroupAcess['leafId']."',
							'".$lastInsertId."',
							'".$rowLeafGroupAccess['leafCreateAccessValue']."',
							'".$rowLeafGroupAccess['leafReadAccessValue']."',
							'".$rowLeafGroupAccess['leafUpdateAccessValue']."',
							'".$rowLeafGroupAccess['leafDeleteAccessValue']."',
							'".$rowLeafGroupAccess['leafPrintAccessValue']."',
							'".$rowLeafGroupAccess['leafPostAccessValue']."'
					)	";
				} else if ($this->q->vendor==self::mssql) {
					$sql="
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
							'".$rowLeafGroupAccess['leafId']."',
							'".$lastInsertId."',
							'".$rowLeafGroupAccess['leafCreateAccessValue']."',
							'".$rowLeafGroupAccess['leafReadAccessValue']."',
							'".$rowLeafGroupAccess['leafUpdateAccessValue']."',
							'".$rowLeafGroupAccess['leafDeleteAccessValue']."',
							'".$rowLeafGroupAccess['leafPrintAccessValue']."',
							'".$rowLeafGroupAccess['leafPostAccessValue']."'
					)	";
				} else if ($this->q->vendor==self::oracle) {
					$sql="
				INSERT INTO	\"leafAccess`
					(
							\"leafId\",
							\"staffId\",
							\"leafCreateAccessValue\",
							\"leafReadAccessValue\",
							\"leafUpdateAccessValue\",
							\"leafDeleteAccessValue\",
							\"leafPrintAccessValue\",
							\"leafPostAccessValue\"
					)
				VALUES
					(
							'".$rowLeafGroupAccess['leafId']."',
							'".$lastInsertId."',
							'".$rowLeafGroupAccess['leafCreateAccessValue']."',
							'".$rowLeafGroupAccess['leafReadAccessValue']."',
							'".$rowLeafGroupAccess['leafUpdateAccessValue']."',
							'".$rowLeafGroupAccess['leafDeleteAccessValue']."',
							'".$rowLeafGroupAccess['leafPrintAccessValue']."',
							'".$rowLeafGroupAccess['leafPostAccessValue']."'
					)	";
				}
				$this->q->create($sql);
				if($this->q->execute=='fail'){
					echo json_encode(array("success"=>false,"message"=>$this->q->responce));
					exit();
				}
			}
		}

		/**
		 * generate category for each staff
		 */
		for ($i = 1; $i <= 10; $i++) {
			if( $this->q->vendor==self::mysql) {
				$sql = "
				INSERT INTO 	`calendar`
							(
								`calendarColorId`,
								`calendarTitle`,
								`staffId`
							) VALUES	(
								'".$i."',
								'"."other".$i."',
								'".$lastInsertId."'
							)";
			} else if ($this->q->vendor==self::mssql) {
				$sql = "
				INSERT INTO 	[calendar]
							(
								[calendarColorId],
								[calendarTitle],
								[staffId]
							) VALUES	(
								'".$i."',
								'"."other".$i."',
								'".$lastInsertId."'
							)";
			} else if ($this->q->vendor==self::oracle) {
				$sql = "
				INSERT INTO 	\"calemdar\"
							(
								\"calendarColorId\",
								\"calendarTitle\",
								\"staffId\"
							) VALUES	(
								'".$i."',
								'"."other".$i."',
								'".$lastInsertId."'
							)";
			}
			$this->q->create($sql);
			if($this->q->execute=='fail'){
				echo json_encode(array("success"=>false,"message"=>$this->q->responce));
				exit();
			}
		}

		$this->q->commit();
		echo json_encode(array("success"=>"true","message"=>"Record Created"));
		exit();



	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() 				{
		header('Content-Type', 'application/json; charset=utf-8');
		if($this->isAdmin == 0) {
			if($this->q->vendor == self :: mysql) {
				$this->auditFilter = "	`staff`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[staff].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"staff\".\"isActive\"	=	1	";
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
					SELECT	`staff`.`staffId`,
							`staff`.`staffSequence`,
							`staff`.`staffCode`,
							`staff`.`staffNote`,
							`staff`.`isDefault`,
							`staff`.`isNew`,
							`staff`.`isDraft`,
							`staff`.`isUpdate`,
							`staff`.`isDelete`,
							`staff`.`isActive`,
							`staff`.`isApproved`,
							`staff`.`By`,
							`staff`.`Time`,
							`staff`.`staffName`
 					FROM 	`staff`
					JOIN	`staff`
					ON		`staff`.`By` = `staff`.`staffId`
					WHERE 	".$this->auditFilter;
			if ($this->model->getStaffId('','string')) {
				$sql .= " AND `".$this->model->getTableName()."`.".$this->model->getPrimaryKeyName()."`=\"". $this->model->getstaffId('','string') . "\"";

			}

		} else if ($this->q->vendor == self::mssql) {
			$sql = "
					SELECT	[staff].[staffId],
							[staff].[staffSequence],
							[staff].[staffCode],
							[staff].[staffNote],
							[staff].[isDefault],
							[staff].[isNew],
							[staff].[isDraft],
							[staff].[isUpdate],
							[staff].[isDelete],
							[staff].[isActive],
							[staff].[isApproved],
							[staff].[By],
							[staff].[Time],
							[staff].[staffName]
					FROM 	[staff]
					JOIN	[staff]
					ON		[staff].[By] = [staff].[staffId]
					WHERE 	[staff].[isActive] ='1'	";
			if ($this->model->getStaffId('','string')) {
				$sql .= " AND [".$this->model->getTableName()."].[".$this->model->getPrimaryKeyName()."]=\"". $this->model->getstaffId('','string') . "\"";
			}
		} else if ($this->q->vendor == self::oracle) {
			$sql = "
					SELECT	\"staff\".\"staffId\",
							\"staff\".\"staffCode\",
							\"staff\".\"staffSequence\",
							\"staff\".\"staffNote\",
							\"staff\".\"isDefault\",
							\"staff\".\"isNew\",
							\"staff\".\"isDraft\",
							\"staff\".\"isUpdate\",
							\"staff\".\"isDelete\",
							\"staff\".\"isActive\",
							\"staff\".\"isApproved\",
							\"staff\".\"By\",
							\"staff\".\"Time\",
							\"staff\".\"staffName\"
					FROM 	\"staff\"
					JOIN	\"staff\"
					ON		\"staff\".\"By\" = \"staff\".\"staffId\"
					WHERE 	\"isActive\"='1'	";
			if ($this->model->getStaffId('','string')) {
				$sql .= " AND \"".$this->model->getTableName()."\".\"".$this->model->getPrimaryKeyName()."\"=\"". $this->model->getstaffId('','string') . "\"";
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
            'staffId'
            );
            /**
             *	filter table
             * @variables $tableArray
             */
            $tableArray  = null;
            $tableArray  = array(
            'staff'
            );
            if ($this->fieldQuery) {
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
            if ($this->gridQuery) {

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
										[staff].[By],
										[staff].[Time],
										[staff].[staffName]
							FROM 		[staffDerived]
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
									SELECT  \"staff\".\"staffId\",
											\"staff\".\"staffSequence\",
											\"staff\".\"staffCode\",
											\"staff\".\"staffNote\",
											\"staff\".\"isDefault\",
											\"staff\".\"isNew\",
											\"staff\".\"isDraft\",
											\"staff\".\"isUpdate\",
											\"staff\".\"isDelete\",
											\"staff\".\"isApproved\",
											\"staff\".\"By\",
											\"staff\".\"Time\",
											\"staff\".\"staffName\"
									FROM 	\"staff\"
									WHERE \"isActive\"=1  " . $tempSql . $tempSql2 . $orderBy . "
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
            if (!($this->model->getstaffId('','string'))) {
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
            if ($this->model->getstaffId('','string')) {
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
	public function update() 				{
		header('Content-Type','application/json; charset=utf-8');
		if( $this->q->vendor==self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}

		$this->q->start();
		$this->model->update();
		//  original group
		if( $this->q->vendor==self::mysql) {
			$sql="
			SELECT	`groupId`,
					`staffPassword`
			FROM 	`staff`
			WHERE 	`staffId`	=	'".$this->model->getStaffId('','string')."'";
		} else if ($this->q->vendor==self::mssql) {
			$sql="
			SELECT 	[groupId],
					[staffPassword]
			FROM 	[staff]
			WHERE 	[staffId]	=	'".$this->model->getStaffId('','string')."'";
		} else if ($this->q->vendor==self::oracle) {
			$sql="
			SELECT 	\"groupId\",
					\"staffPassword\"
			FROM 	\"staff\"
			WHERE 	\"staffId\"	=	'".$this->model->getStaffId('','string')."'";
		}
		$this->q->read($sql);
		if($this->q->execute=='fail') {
			$this->msg(false,$this->q->responce);
			exit();
		}
		$data = $this->q->fetchAssoc();


		if($data['staffPassword'] == md5($this->model->getStaffPassword())){
			$staffPassword = $data['staffPassword'];
		}else{
			$staffPassword = $this->model->getStaffPassword();
		}

		$groupId = $data['groupId'];
		if( $this->q->vendor==self::mysql) {
			$sql="
				UPDATE 	`staff`
				SET 	`staffIc`		=	'".$this->model->getStaffIc()."',
						`staffName`		=	'".$this->model->getStaffName()."',
						`staffNo`		=	'".$this->model->getStaffNo()."',
						`staffPassword`	=	'".md5($this->model->getStaffPassword())."',
						`groupId`		=	'".$this->model->getGroupId()."',
						`departmentId`	=	'".$this->model->getDepartmentId()."',
						`isDefault`		=	'".$this->model->getIsDefault('','string')."',
						`isNew`			=	'".$this->model->getIsNew('','string')."',
						`isDraft`		=	'".$this->model->getIsDraft('','string')."',
						`isUpdate`		=	'".$this->model->getIsUpdate('','string')."',
						`isDelete`		=	'".$this->model->getIsDelete('','string')."',
						`isActive`		=	'".$this->model->getIsActive('','string')."',
						`isApproved`	=	'".$this->model->getIsApproved('','string')."',
						`By`			=	'".$this->model->getBy()."',
						`Time			=	".$this->model->getTime()."
				WHERE 	`staffId`		=	'".$this->model->getStaffId('','string')."'";
		} else if ($this->q->vendor==self::mssql) {
			$sql="
				UPDATE 	[staff]
				SET 	[staffIc]		=	'".$this->model->getStaffIc()."',
						[staffName]		=	'".$this->model->getStaffName()."',
						[staffNo]		=	'".$this->model->getStaffNo()."',
						[staffPassword]	=	'".md5($this->model->getStaffPassword())."',
						[staffName]		=	'".$this->model->getStaffName()."',
						[groupId]		=	'".$this->model->getGroupId()."',
						[departmentId]	=	'".$this->model->getDepartmentId()."',
						[isDraft]		=	'".$this->model->getIsDraft('','string')."',
						[isNew]			=	'".$this->model->getIsNew('','string')."',
						[isDraft]		=	'".$this->model->getIsDraft('','string')."',
						[isUpdate]		=	'".$this->model->getIsUpdate('','string')."',
						[isDelete]		=	'".$this->model->getIsDelete('','string')."',
						[isActive]		=	'".$this->model->getIsActive('','string')."',
						[isApproved]	=	'".$this->model->getIsApproved('','string')."',
						[By]			=	'".$this->model->getBy()."',
						[Time]			=	".$this->model->getTime()."
				WHERE 	[staffId]		=	'".$this->model->getStaffId('','string')."'";
		} else if ($this->q->vendor==self::oracle) {
			$sql="
				UPDATE 	\"staff\"
				SET 	\"staffIc\"			=	'".$this->model->getStaffIc()."',
						\"staffName\"		=	'".$this->model->getStaffName()."',
						\"staffNo\"			=	'".$this->model->getStaffNo()."',
						\"staffPassword\"	=	'".md5($this->model->getStaffPassword())."',
						\"staffName\"		=	'".$this->model->getStaffName()."',
						\"groupId\"			=	'".$this->model->getGroupId()."',
						\"departmentId\"	=	'".$this->model->getDepartmentId()."',
						\"isDefault\"		=	'".$this->model->getIsDefault('','string')."',
						\"isNew\"			=	'".$this->model->getIsNew('','string')."',
						\"isDraft\"			=	'".$this->model->getIsDraft('','string')."',
						\"isUpdate\"		=	'".$this->model->getIsUpdate('','string')."',
						\"isDelete\"		=	'".$this->model->getIsDelete('','string')."',
						\"isActive\"		=	'".$this->model->getIsActive('','string')."',
						\"isApproved\"		=	'".$this->model->getIsApproved('','string')."',
						\"By\"				=	'".$this->model->getBy()."',
						\"Time\"			=	".$this->model->getTime()."
				WHERE 	\"staffId\"			=	'".$this->model->staffId."'";
		}

		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();

		}
		// check change group or not
		if($this->model->getGroupId() != $groupId){

			/**
			 *  update  leaf group access
			 * */
			if( $this->q->vendor==self::mysql) {
				$sql="
					SELECT	*
					FROM 	`leafGroupAccess`
					WHERE 	`groupId`='".$this->model->getGroupId()."' ";
			} else if ($this->q->vendor==self::mssql) {
				$sql="
					SELECT	*
					FROM 	[leafGroupAccess]
					WHERE 	[groupId]='".$this->model->getGroupId()."' ";
			} else if ($this->q->vendor==self::oracle) {
				$sql="
					SELECT	*
					FROM 	\"leafGroupAccess\"
					WHERE 	\"groupId\"='".$this->model->getGroupId()."' ";
			}

			$this->q->read($sql);
			if($this->q->execute=='fail'){
				echo json_encode(array("success"=>false,"message"=>$this->q->responce));
				exit();
			}
			$data = $this->q->activeRecord();


			foreach($data as  $rowLeafGroupAccess) {

				// check if exist record or not
				if( $this->q->vendor==self::mysql) {
					$sql="
					SELECT	*
					FROM 	`leafAccess`
					WHERE 	`staffId`			=	'".$this->model->getStaffId('','string')."'
					AND		`leafId`			=	'".$rowLeafGroupAccess['leafId']."' ";
				} else if ($this->q->vendor==self::mssql) {
					$sql="
					SELECT	*
					FROM 	[leafAccess]
					WHERE 	[staffId]			=	'".$this->model->getStaffId('','string')."'
					AND		[leafId]			=	'".$rowLeafGroupAccess['leafId']."' ";
				} else if ($this->q->vendor==self::oracle) {
					$sql="
					SELECT	*
					FROM 	\"leafAccess\"
					WHERE 	\"staffId\"			=	'".$this->model->getStaffId('','string')."'
					AND		\"leafId\"			=	'".$rowLeafGroupAccess['leafId']."' ";
				}
				$this->q->read($sql);
				if($this->q->numberRows()> 0 ) {
					if( $this->q->vendor==self::mysql) {
						$sql="
						UPDATE 	`leafAccess`
						SET 	`leafCreateAccessValue`			=	'".$rowLeafGroupAccess['leafCreateAccessValue']."',
								`leafDeleteAccessValue`			=	'".$rowLeafGroupAccess['leafReadAccessValue']."',
								`leafPostAccessValue`			=	'".$rowLeafGroupAccess['leafUpdateAccessValue']."',
								`leafPrintAccessValue`			=	'".$rowLeafGroupAccess['leafDeleteAccessValue']."',
								`leafReadAccessValue`			=	'".$rowLeafGroupAccess['leafPrintAccessValue']."',
								`leafUpdateAccessValue`			=	'".$rowLeafGroupAccess['leafPostAccessValue']."'
						WHERE 	`staffId`						=	'".$this->model->getStaffId('','string')."'
						AND		`leafId`						=	'".$rowLeafGroupAccess['leafId']."'";
					} else if ($this->q->vendor==self::mssql) {
						$sql="
						UPDATE 	[leafAccess]
						SET 	[leafCreateAccessValue]			=	'".$rowLeafGroupAccess['leafCreateAccessValue']."',
								[leafDeleteAccessValue]			=	'".$rowLeafGroupAccess['leafReadAccessValue']."',
								[leafPostAccessValue]			=	'".$rowLeafGroupAccess['leafUpdateAccessValue']."',
								[leafPrintAccessValue]			=	'".$rowLeafGroupAccess['leafDeleteAccessValue']."',
								[leafReadAccessValue]			=	'".$rowLeafGroupAccess['leafPrintAccessValue']."',
								[leafUpdateAccessValue]			=	'".$rowLeafGroupAccess['leafPostAccessValue']."'
						WHERE 	[staffId]						=	'".$this->model->getStaffId('','string')."'
						AND		[leafId]						=	'".$rowLeafGroupAccess['leafId']."'";
					} else if ($this->q->vendor==self::oracle) {
						$sql="
								UPDATE 	\"leafAccess\"
						SET 	\"leafCreateAccessValue\"		=	'".$rowLeafGroupAccess['leafCreateAccessValue']."',
								\"leafDeleteAccessValue\"		=	'".$rowLeafGroupAccess['leafReadAccessValue']."',
								\"leafPostAccessValue\"			=	'".$rowLeafGroupAccess['leafUpdateAccessValue']."',
								\"leafPrintAccessValue\"		=	'".$rowLeafGroupAccess['leafDeleteAccessValue']."',
								\"leafReadAccessValue\"			=	'".$rowLeafGroupAccess['leafPrintAccessValue']."',
								\"leafUpdateAccessValue\"		=	'".$rowLeafGroupAccess['leafPostAccessValue']."'
						WHERE 	\"staffId\"						=	'".$this->model->getStaffId('','string')."'
						AND		\"leafId\"						=	'".$rowLeafGroupAccess['leafId']."'";
					}
					$this->q->update($sql);
					if($this->q->execute=='fail') {
						echo json_encode(array("success"=>"false","message"=>$this->q->responce));
						exit();

					}
				} else {
					if( $this->q->vendor==self::mysql) {
						$sql="
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
										'".$rowLeafGroupAccess['leafId']."',
										'".$this->model->getStaffId('','string')."',
										'".$rowLeafGroupAccess['leafReadAccessValue']."',
										'".$rowLeafGroupAccess['leafUpdateAccessValue']."',
										'".$rowLeafGroupAccess['leafDeleteAccessValue']."',
										'".$rowLeafGroupAccess['leafPrintAccessValue']."',
										'".$rowLeafGroupAccess['leafPostAccessValue']."'
								)	";
					} else if ($this->q->vendor==self::mssql) {
						$sql="
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
										'".$rowLeafGroupAccess['leafId']."',
										'".$this->model->getStaffId('','string')."',
										'".$rowLeafGroupAccess['leafReadAccessValue']."',
										'".$rowLeafGroupAccess['leafUpdateAccessValue']."',
										'".$rowLeafGroupAccess['leafDeleteAccessValue']."',
										'".$rowLeafGroupAccess['leafPrintAccessValue']."',
										'".$rowLeafGroupAccess['leafPostAccessValue']."'
								)	";
					} else if ($this->q->vendor==self::oracle) {
						$sql="
							INSERT INTO	\"leafAccess\"
								(
										\"leafId\",
										\"staffId\",
										\"leafReadAccessValue\",
										\"leafUpdateAccessValue\",
										\"leafDeleteAccessValue\",
										\"leafPrintAccessValue\",
										\"leafPostAccessValue\"
								)
							VALUES
								(
										'".$rowLeafGroupAccess['leafId']."',
										'".$this->model->getStaffId('','string')."',
										'".$rowLeafGroupAccess['leafReadAccessValue']."',
										'".$rowLeafGroupAccess['leafUpdateAccessValue']."',
										'".$rowLeafGroupAccess['leafDeleteAccessValue']."',
										'".$rowLeafGroupAccess['leafPrintAccessValue']."',
										'".$rowLeafGroupAccess['leafPostAccessValue']."'
								)	";
					}
					$this->q->create($sql);
					if($this->q->execute=='fail'){
						echo json_encode(array("success"=>false,"message"=>$this->q->responce));
						exit();
					}
				}
			}
		}
		// if change group .All access  before will deactivated
		// update leaf access to null
		$this->q->commit();
		echo json_encode(array("success"=>"success","message"=>"update success"));
		exit();


	}

	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	public function delete()				{
		header('Content-Type','application/json; charset=utf-8');
		if( $this->q->vendor==self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}

		$this->q->start();
		$this->model->delete();
		if( $this->q->vendor==self::mysql) {
			$sql="
				UPDATE	`staff`
				SET		`isDefault`			=	'".$this->model->getIsActive('','string')."',
						`isNew`				=	'".$this->model->getIsNew('','string')."',
						`isDraft`			=	'".$this->model->getIsDraft('','string')."',
						`isUpdate`			=	'".$this->model->getIsUpdate('','string')."',
						`isDelete`			=	'".$this->model->getIsDelete('','string')."',
						`isActive`			=	'".$this->model->getIsActive('','string')."',
						`isApproved`		=	'".$this->model->getIsApproved('','string')."',
						`By`				=	'".$this->model->getBy()."',
						`Time				=	".$this->model->getTime()."
				WHERE 	`staffId`			=	'".$this->model->staffId."'";
		} else if ($this->q->vendor==self::mssql) {
			$sql="
				UPDATE	[staff]
				SET		[isDefault]	= '".$this->model->getIsDefault('','string')."',
						[isNew]		=	'".$this->model->getIsNew('','string')."',
						[isDraft]	=	'".$this->model->getIsDraft('','string')."',
						[isUpdate]	=	'".$this->model->getIsUpdate('','string')."',
						[isDelete]	=	'".$this->model->getIsDelete('','string')."',
						[isActive]	=	'".$this->model->getIsActive('','string')."',
						[isApproved]=	'".$this->model->getIsApproved('','string')."',
						[By]		=	'".$this->model->getBy()."',
						[Time]		=	".$this->model->getTime()."
				WHERE 	[staffId]	=	'".$this->model->getStaffId('','string')."'";

		} else if ($this->q->vendor==self::oracle) {
			$sql="
				UPDATE	\"staff\"
				SET		\"isDefault\" 	=   '".$this->model->getIsDefault('','string')."',
						\"isNew\"		=	'".$this->model->getIsNew('','string')."',
						\"isDraft\"		=	'".$this->model->getIsDraft('','string')."'
						\"isUpdate\"	=	'".$this->model->getIsUpdate('','string')."',
						\"isDelete\"	=	'".$this->model->getIsDelete('','string')."',
						\"isActive\"	=	'".$this->model->getIsActive('','string')."',
						\"isApproved\"	=   '".$this->model->getIsApproved('','string')."',
						\"By\"			=	'".$this->model->getBy()."',
						\"Time\"		=	".$this->model->getTime()."
				WHERE 	\"staffId\"		=	'".$this->model->getStaffId('','string')."'";

		}
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success"=>"success","message"=>"Removed Success"));
		exit();


	}

	function updateStatus () {
		$loop  = $this->model->getTotal();

		if($this->isAdmin==0){

			$this->model->delete();
			if ($this->q->vendor == self::mysql) {
				$sql = "
				UPDATE 	`".$this->model->getTableName()."`
				SET 	";

				$sql.="	   `isDefault`			=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$staffIdDelete.=$this->model->getStaffId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getStaffId($i,'array')."'
						THEN '".$this->model->getIsDefault('','string')."'";
					}
				}
				$sql.="	END, ";
				$sql.="	`isNew`	=	case `".$this->model->getPrimaryKeyName()."` ";

				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$staffIdDelete.=$this->model->getStaffId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getStaffId($i,'array')."'
						THEN '".$this->model->getIsNew('','string')."'";
					}
				}
				$sql.="	END,";
				$sql.="	`isDraft`	=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$staffIdDelete.=$this->model->getStaffId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getStaffId($i,'array')."'
						THEN '".$this->model->getIsDraft('','string')."'";
					}
				}
				$sql.="	END,";
				$sql.="	`isUpdate`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$staffIdDelete.=$this->model->getStaffId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getStaffId($i,'array')."'
						THEN '".$this->model->getIsUpdate('','string')."'";
					}
				}
				$sql.="	END,";
				$sql.="	`isDelete`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$staffIdDelete.=$this->model->getStaffId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getStaffId($i,'array')."'
						THEN '".$this->model->getIsDelete($i,'array')."'";
					}
				}
				$sql.="	END,	";
				$sql.="	`isActive`	=		case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$staffIdDelete.=$this->model->getStaffId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getStaffId($i,'array')."'
						THEN '".$this->model->getIsActive('','string')."'";
					}
				}
				$sql.="	END,";
				$sql.="	`isApproved`			=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$staffIdDelete.=$this->model->getStaffId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getStaffId($i,'array')."'
						THEN '".$this->model->getIsApproved('','string')."'";

					}
				}
				$sql.="
				END,
				`By`				=	\"". $this->model->getBy() . "\",
				`Time`				=	" . $this->model->getTime() . " ";


				$this->model->setDepartmentIdAll(substr($staffIdDelete,0,-1));
				$sql.=" WHERE 	`".$this->model->getPrimaryKeyName()."`		IN	(". $this->model->getStaffIdAll(). ")";

			} else if ($this->q->vendor == self::mssql) {
				$sql = "
			UPDATE 	[Department]
			SET 	[isDefault]			=	\"". $this->model->getIsDefault('','string') . "\",
					[isNew]				=	\"". $this->model->getIsNew('','string') . "\",
					[isDraft]			=	\"". $this->model->getIsDraft('','string') . "\",
					[isUpdate]			=	\"". $this->model->getIsUpdate('','string') . "\",
					[isDelete]			=	\"". $this->model->getIsDelete('','string') . "\",
					[isActive]			=	\"". $this->model->getIsActive('','string') . "\",
					[isApproved]		=	\"". $this->model->getIsApproved('','string') . "\",
					[By]				=	\"". $this->model->getBy() . "\",
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[DepartmentId]		IN	(". $this->model->getStaffIdAll() . ")";
			} else if ($this->q->vendor == self::oracle) {
				$sql = "
				UPDATE	\"Department\"
				SET 	\"isDefault\"		=	\"". $this->model->getIsDefault('','string') . "\",
					\"isNew\"			=	\"". $this->model->getIsNew('','string') . "\",
					\"isDraft\"			=	\"". $this->model->getIsDraft('','string') . "\",
					\"isUpdate\"		=	\"". $this->model->getIsUpdate('','string') . "\",
					\"isDelete\"		=	\"". $this->model->getIsDelete('','string') . "\",
					\"isActive\"		=	\"". $this->model->getIsActive('','string') . "\",
					\"isApproved\"		=	\"". $this->model->getIsApproved('','string') . "\",
					\"By\"				=	\"". $this->model->getBy() . "\",
					\"Time\"			=	" . $this->model->getTime() . "
			WHERE 	\"DepartmentId\"		IN	(". $this->model->getStaffIdAll() . ")";
			}
		} else if ($this->isAdmin ==1){

			if( $this->q->vendor==self::mysql) {
				$sql="
				UPDATE `".$this->model->getTableName()."`
				SET";
			} else if($this->q->vendor==self::mssql) {
				$sql="
			UPDATE 	[".$this->model->getTableName()."]
			SET 	";

			} else if ($this->q->vendor==self::oracle) {
				$sql="
			UPDATE \"".$this->model->getTableName()."\"
			SET    ";
			}
			//	echo "arnab[".$this->model->getDepartmentId(0,'array')."]";
			/**
			 *	System Validation Checking
			 *  @var $access
			 */
			$access  = array("isDefault","isNew","isDraft","isUpdate","isDelete","isActive","isApproved");
			foreach($access as $systemCheck) {


				if( $this->q->vendor==self::mysql) {
					$sqlLooping.=" `".$systemCheck."` = CASE `".$this->model->getPrimaryKeyName()."`";
				} else if($this->q->vendor==self::mssql) {
					$sqlLooping.="  [".$systemCheck."] = CASE [".$this->model->getPrimaryKeyName()."]";

				} else if ($this->q->vendor==self::oracle) {
					$sqlLooping.="	\"".$systemCheck."\" = CASE \"".$this->model->getPrimaryKeyName()."\"";
				}
				switch ($systemCheck){
					case 'isDefault':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getStaffId($i,'array')."'
							THEN '".$this->model->getIsDefault($i,'array')."'";
						}
						break;
					case 'isNew':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getStaffId($i,'array')."'
							THEN '".$this->model->getIsNew($i,'array')."'";

						} break;
					case 'isDraft':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getStaffId($i,'array')."'
							THEN '".$this->model->getIsDraft($i,'array')."'";
						}
						break;
					case 'isUpdate':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getStaffId($i,'array')."'
							THEN '".$this->model->getIsUpdate($i,'array')."'";
						}
						break;
					case 'isDelete':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getStaffId($i,'array')."'
							THEN '".$this->model->getIsDelete($i,'array')."'";
						}
						break;
					case 'isActive':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getStaffId($i,'array')."'
							THEN '".$this->model->getIsActive($i,'array')."'";
						}
						break;
					case 'isApproved':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getStaffId($i,'array')."'
							THEN '".$this->model->getIsApproved($i,'array')."'";
						}
						break;
				}


				$sqlLooping.= " END,";
			}

			$sql.=substr($sqlLooping,0,-1);
			if( $this->q->vendor==self::mysql) {
				$sql.="
			WHERE `".$this->model->getPrimaryKeyName()."` IN (".$this->model->getStaffIdAll().")";
			} else if($this->q->vendor==self::mssql) {
				$sql.="
			WHERE `=[".$this->model->getPrimaryKeyName()."] IN (".$this->model->getStaffIdAll().")";
			} else if ($this->q->vendor==self::oracle) {
				$sql.="
			WHERE \"".$this->model->getPrimaryKeyName()."\" IN (".$this->model->getStaffIdAll().")";
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
		if ($this->q->vendor == self::mysql) {
			//UTF8
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		if ($this->q->vendor == self::mysql) {
			$sql = "
			SELECT	*
			FROM 	`staff`
			WHERE 	`staffNo` 	= 	\"". $this->model->getStaffNo(). "\"
			AND		`isActive`		=	1";
		} else if ($this->q->vendor == self::mssql) {
			$sql = "
			SELECT	*
			FROM 	[staff]
			WHERE 	[staffNo] 	= 	\"". $this->model->getStaffNo() . "\"
			AND		[isActive]		=	1";
		} else if ($this->q->vendor == self::oracle) {
			$sql = "
			SELECT	*
			FROM 	\"staff\"
			WHERE 	\"staffNo\" 	= 	\"". $this->model->getStaffNo() . "\"
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
			if($this->duplicateTest == 1) {
				return $total."|".$row['staffNo'];
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
	public function group() {
		$this->security->group();
	}
	public function department() {
		$this->security->department();
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	public function excel() {
		if( $this->q->vendor==self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		if($_SESSION['start']==0) {
			$sql=str_replace("LIMIT","",$_SESSION['sql']);
			$sql=str_replace($_SESSION['start'].",".$_SESSION['limit'],"",$sql);
		} else {
			$sql=$_SESSION['sql'];
		}
		$this->q->read($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();

		}
		$this->excel->setActiveSheetIndex(0);
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array(
		'borders' => array(
		'inside' => array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('argb' => '000000'),
		),
		'outline' => array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('argb' => '000000'),
		),
		),
		);
		// header all using  3 line  starting b
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$this->excel->getActiveSheet()->setCellValue('B2',$this->title);
		$this->excel->getActiveSheet()->setCellValue('D2','');
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->setCellValue('B3','No');
		$this->excel->getActiveSheet()->setCellValue('C3','Nama');
		$this->excel->getActiveSheet()->setCellValue('D3','Kumpulan');
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');

		//
		$loopRow=4;
		$i=0;
		while($row  = 	$this->q->fetchAssoc()) {
			//	echo print_r($row);

			$this->excel->getActiveSheet()->setCellValue('B'.$loopRow,++$i);
			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['staffName']);
			$this->excel->getActiveSheet()->setCellValue('D'.$loopRow,$row['groupNote']);
			$loopRow++;
			$lastRow='D'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="staff.xlsx";
		$objWriter->save($_SERVER['document_root']."/idcmsCore/management/document/excel/".$filename);

		$file = fopen($_SERVER['document_root']."/idcmsCore/management/document/excel/".$filename,'r');
		if($file){
			echo json_encode(array("success"=>"true","message"=>"File generated"));
		} else {
			echo json_encode(array("success"=>"false","message"=>"File not generated"));

		}
	}

}



$staffObject  	= 	new staffClass();
if(isset($_SESSION['staffId'])){
	$staffObject->setStaffId($_SESSION['staffId']);
}
if(isset($_SESSION['vendor'])){
	$staffObject->setVendor($_SESSION['vendor']);
}
if(isset($_SESSION['languageId'])){
	$staffObject->setLanguageId($_SESSION['languageId']);
}
/**
 *	crud -create,read,update,delete
 **/
if(isset($_POST['method']))	{
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Indentification
	 */
	if(isset($_POST['leafId'])){
		$staffObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$staffObject->setIsAdmin($_POST['isAdmin']);
	}
	/*
	 * Filtering
	 */

	if(isset($_POST['query'])){
		$staffObject->setFieldQuery($_POST['query']);
	}
	if(isset($_POST['filter'])){
		$staffObject->setGridQuery($_POST['filter']);
	}
	/*
	 *
	 */
	if(isset($_POST['order'])){
		$staffObject->setOrder($_POST['order']);
	}
	if(isset($_POST['sortField'])){
		$staffObject->setSortField($_POST['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$staffObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_POST['method']=='create'){
		$staffObject->create();
	}
	if($_POST['method']=='read') 	{
		$staffObject->read();
	}

	if($_POST['method']=='save') 	{
		$staffObject->update();
	}
	if($_POST['method']=='delete') 	{
		$staffObject->delete();
	}

}

if(isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Indentification
	 */
	if(isset($_GET['leafId'])){
		$staffObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$staffObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$staffObject->execute();
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {
			$staffObject->staff();
		}
		if($_GET['field']=='group'){
			$staffObject->group();
		}
		if($_GET['field']=='department'){
			$staffObject->department();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if($_GET['method']=='updateStatus'){
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
	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$staffObject->excel();
		}
	}
}
?>



