<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../model/groupModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package group
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class groupClass  extends configClass {
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
	function execute() {
		parent :: __construct();

		$this->q 					=	new vendor();
		$this->q->vendor			=	$this->getVendor();
		$this->q->leafId			=	$this->getLeafId();
		$this->q->staffId			=	$this->getStaffId();
		$this->q->fieldQuery		=   $this->getFieldQuery();
		$this->q->filter 			= 	$this->getGridQuery();
		$this->q->connect($this->connection, $this->username,$this->database,$this->password);
		$this->excel				=	new  PHPExcel();
		$this->audit 				=	0;  // By Default 0 - Off  1 - On
		$this->log					=   0;  // By Default 0 - Off  1 - On
		$this->q->log 				= $this->log;
		$this->model 				= new groupModel();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create() 				{
		header('Content-Type','application/json; charset=utf-8');
		if( $this->q->vendor==self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->create();
		if( $this->q->vendor==self::mysql) {
			$sql="
			INSERT INTO `group`
					(
						`groupDesc`
						`isNew`,
						`isActive`
					)
			VALUES
					(
						'".$this->model->groupDesc."'
						1,1);";
		}  else if ( $this->q->vendor==self::mssql) {
			$sql="
			INSERT INTO [group]
					(
						[groupDesc],
						[isNew],
						[isActive]
					)
			VALUES
					(
						'".$this->strict($_POST['groupDesc'],'string')."'
						1,
						1);";
		}  else if ($this->q->vendor==self::oracle) {
			$sql="
			INSERT INTO \"group\"
					(
						\"groupDesc\",
						\"isNew\",
						\"isActive\"
					)
				VALUES
					(
						'".$this->strict($_POST['groupDesc'],'string')."'
						1,
						1
					);";

		}
		$this->q->create($sql);
		// take from last insert id
		$this->insert_id	=	$this->q->last_insert_id();

		// loop the accordion and create new record
		//** no need to log in db
		$sql=	"
		SELECT 	*
		FROM 	`accordion`
		WHERE 	`isActive`=1";
		$this->q->read($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		$data = $this->q->activeRecord();
		if($this->q->numberRows()> 0 ){
			foreach($data as $row){
				if( $this->q->vendor==self::mysql) {
					$sql =	"
				INSERT INTO	`accordionAccess`
				(
									`accordionId`,
									`accordionAccessValue`,
									`groupId`
				)
				VALUES
				(
									'".$row['accordionId']."',
									'0',
									'".$this->insert_id."'
									)";
				} else if ($this->q->vendor==self::mssql) {
					$sql =	"
				INSERT INTO	[accordionAccess]
				(
				[accordionId],
				[accordionAccessValue],
				[groupId]
				)
				VALUES
				(
									'".$row['accordionId']."',
									'0',
									'".$this->insert_id."'
									)";
				} else if ($this->q->vendor==self::oracle) {
					$sql =	"
				INSERT INTO	\"accordionAccess`
							(
									\"accordionId\",
									\"accordionAccessValue\",
									\"groupId\"
							)
					VALUES
							(
									'".$row['accordionId']."',
									'0',
									'".$this->insert_id."'
							)";
				}
				$this->q->create($sql);
				if($this->q->execute=='fail'){
					echo json_encode(array("success"=>false,"message"=>$this->q->responce));
					exit();
				}
			}
		}

		// loop the folder and create new record;
		if( $this->q->vendor==self::mysql) {
			$sql		=	"
		SELECT 	*
		FROM 	`folder`
		WHERE 	`isActive`=1";
		}	else if ($this->q->vendor==self::mssql) {
			$sql		=	"
		SELECT 	*
		FROM 	[folder]
		WHERE 	[isActive]=1";
		} else if ( $this->q->vendor==self::oracle) {
			$sql		=	"
		SELECT 	*
		FROM 	\"folder\"
		WHERE 	\"isActive\"=1";
		}
		$this->q->read($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		if($this->q->numberRows()> 0 ){
			$data = $this->q->activeRecord();
			foreach($data as $row){

				if( $this->q->vendor==self::mysql) {
					$sql =	"
					INSERT INTO 	`folderAccess`
								(
									`folderId`,
									`folderAccessValue`,
									`groupId`
								)
					VALUES(			'".$row['folderId']."',
									'0',
									'".$this->insert_id."')";
				} else if ($this->q->vendor==self::mssql) {
					$sql =	"
					INSERT INTO 	[folderAccess]
								(
									[folderId],
									[folderAccessValue],
									[groupId]
								)
					VALUES(			'".$row['folderId']."',
									'0',
									'".$this->insert_id."')";
				} else if ($this->q->vendor==self::oracle) {
					$sql =	"
					INSERT INTO 	`folderAccess`
								(
									\"folderId\",
									\"folderAccessValue\",
									\"groupId\"
								)
					VALUES(			'".$row['folderId']."',
									'0',
									'".$this->insert_id."')";
				}
				$this->q->create($sql);
				if($this->q->execute=='fail'){
					echo json_encode(array("success"=>false,"message"=>$this->q->responce));
					exit();
				}
			}
		}

		// create a template access which user can access to
		if( $this->q->vendor==self::mysql) {
			$sql			=	"SELECT * FROM `leaf` WHERE `isActive`=1  ";
		} else if ($this->q->vendor==self::mssql) {
			$sql			=	"SELECT * FROM [leaf] WHERE [isActive]=1  ";
		} else if ($this->q->vendor==self::oracle) {
			$sql			=	"SELECT * FROM \"leaf\" WHERE \"isActive\"=1  ";
		}
		$this->q->read($sql);
		$total = $this->q->numberRows();
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		if($total > 0 ){
			$data = $this->q->activeRecord();
			foreach($data as $row){
				if( $this->q->vendor==self::mysql) {
					$sql =	"
					INSERT INTO 	[leafGroupAccess]
								(	[leafId],
									[leafReadAccessValue],
									[leafCreateAccessValue],
									[leafUpdateAccessValue],
									[leafDeleteAccessValue],
									[leafPrintAccessValue],
									[leafPostAccessValue],
									[groupId])
					VALUES(			'".$row['leafId']."',
									'0',
									'0',
									'0',
									'0',
									'0',
									'0',
									'".$this->insert_id."')";
				} else if ($this->q->vendor==self::mssql) {
					$sql =	"
					INSERT INTO 	`leafGroupAccess`
								(	`leafId`,
									`leafReadAccessValue`,
									`leafCreateAccessValue`,
									`leafUpdateAccessValue`,
									`leafDeleteAccessValue`,
									`leafPrintAccessValue`,
									`leafPostAccessValue`,
									`groupId`)
					VALUES(			'".$row['leafId']."',
									'0',
									'0',
									'0',
									'0',
									'0',
									'0',
									'".$this->insert_id."')";
				} else if ($this->q->vendor==self::oracle) {
					$sql =	"
					INSERT INTO 	\"leafGroupAccess\"
								(	\"leafId\",
									\"leafReadAccessValue\",
									\"leafCreateAccessValue\",
									\"leafUpdateAccessValue\",
									\"leafDeleteAccessValue\",
									\"leafPrintAccessValue\",
									\"leafPostAccessValue\",
									\"groupId\")
					VALUES(			'".$row['leafId']."',
									'0',
									'0',
									'0',
									'0',
									'0',
									'0',
									'".$this->insert_id."')";
				}
				$this->q->create($sql);
				if($this->q->execute=='fail'){
					echo json_encode(array("success"=>false,"message"=>$this->q->responce));
					exit();
				}
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
				$this->auditFilter = "	`group`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[group].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"group\".\"isActive\"	=	1	";
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
					SELECT	`group`.`groupId`,
							`group`.`groupSequence`,
							`group`.`groupCode`,
							`group`.`groupNote`,
							`group`.`isDefault`,
							`group`.`isNew`,
							`group`.`isDraft`,
							`group`.`isUpdate`,
							`group`.`isDelete`,
							`group`.`isActive`,
							`group`.`isApproved`,
							`group`.`By`,
							`group`.`Time`,
							`staff`.`staffName`
 					FROM 	`group`
					JOIN	`staff`
					ON		`group`.`By` = `staff`.`staffId`
					WHERE 	".$this->auditFilter;
			if ($this->model->getgroupId('','string')) {
				$sql .= " AND `".$this->model->getTableName()."`.".$this->model->getPrimaryKeyName()."`=\"". $this->model->getgroupId('','string') . "\"";

			}

		} else if ($this->q->vendor == self::mssql) {
			$sql = "
					SELECT	[group].[groupId],
							[group].[groupSequence],
							[group].[groupCode],
							[group].[groupNote],
							[group].[isDefault],
							[group].[isNew],
							[group].[isDraft],
							[group].[isUpdate],
							[group].[isDelete],
							[group].[isActive],
							[group].[isApproved],
							[group].[By],
							[group].[Time],
							[staff].[staffName]
					FROM 	[group]
					JOIN	[staff]
					ON		[group].[By] = [staff].[staffId]
					WHERE 	[group].[isActive] ='1'	";
			if ($this->model->getgroupId('','string')) {
				$sql .= " AND [".$this->model->getTableName()."].[".$this->model->getPrimaryKeyName()."]=\"". $this->model->getgroupId('','string') . "\"";
			}
		} else if ($this->q->vendor == self::oracle) {
			$sql = "
					SELECT	\"group\".\"groupId\",
							\"group\".\"groupCode\",
							\"group\".\"groupSequence\",
							\"group\".\"groupNote\",
							\"group\".\"isDefault\",
							\"group\".\"isNew\",
							\"group\".\"isDraft\",
							\"group\".\"isUpdate\",
							\"group\".\"isDelete\",
							\"group\".\"isActive\",
							\"group\".\"isApproved\",
							\"group\".\"By\",
							\"group\".\"Time\",
							\"staff\".\"staffName\"
					FROM 	\"group\"
					JOIN	\"staff\"
					ON		\"group\".\"By\" = \"staff\".\"staffId\"
					WHERE 	\"isActive\"='1'	";
			if ($this->model->getgroupId('','string')) {
				$sql .= " AND \"".$this->model->getTableName()."\".\"".$this->model->getPrimaryKeyName()."\"=\"". $this->model->getgroupId('','string') . "\"";
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
            'groupId'
            );
            /**
             *	filter table
             * @variables $tableArray
             */
            $tableArray  = null;
            $tableArray  = array(
            'group'
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
							WITH [groupDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [groupId]) AS 'RowNumber'
								FROM [group]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[group].[groupId],
										[group].[groupSequence],
										[group].[groupCode],
										[group].[groupNote],
										[group].[isDefault],
										[group].[isNew],
										[group].[isDraft],
										[group].[isUpdate],
										[group].[isDelete],
										[group].[isApproved],
										[group].[By],
										[group].[Time],
										[staff].[staffName]
							FROM 		[groupDerived]
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
									SELECT  \"group\".\"groupId\",
											\"group\".\"groupSequence\",
											\"group\".\"groupCode\",
											\"group\".\"groupNote\",
											\"group\".\"isDefault\",
											\"group\".\"isNew\",
											\"group\".\"isDraft\",
											\"group\".\"isUpdate\",
											\"group\".\"isDelete\",
											\"group\".\"isApproved\",
											\"group\".\"By\",
											\"group\".\"Time\",
											\"staff\".\"staffName\"
									FROM 	\"group\"
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
            if (!($this->model->getgroupId('','string'))) {
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
            if ($this->model->getgroupId('','string')) {
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
	function update() 				{
		header('Content-Type','application/json; charset=utf-8');
		if( $this->q->vendor==self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		$this->q->commit();
		$this->model->update();
		if( $this->q->vendor==self::mysql) {
			$sql="
			UPDATE 	`group`
			SET 	`groupDesc`		=	'".$this->model->groupDesc."',
					`isActive`		=	'".$this->model->getIsActive('','string')."',
					`isNew`			=	'".$this->model->getIsNew('','string')."',
					`isDraft`		=	'".$this->model->getIsDraft('','string')."',
					`isUpdate`		=	'".$this->model->getIsUpdate('','string')."',
					`isDelete`		=	'".$this->model->getIsDelete('','string')."',
					`isApproved`	=	'".$this->model->getIsApproved('','string')."',
					`By`			=	'".$this->model->getBy()."',
					`Time			=	".$this->model->getTime()."
			WHERE 	`groupId`		=	'".$this->groupId."'";
		} else if ($this->q->vendor==self::mssql) {
			$sql="
			UPDATE 	[group]
			SET 	[groupDesc]		=	'".$this->model->groupDesc."',
					[isActive]		=	'".$this->model->getIsActive('','string')."',
					[isNew]			=	'".$this->model->getIsNew('','string')."',
					[isDraft]		=	'".$this->model->getIsDraft('','string')."',
					[isUpdate]		=	'".$this->model->getIsUpdate('','string')."',
					[isDelete]		=	'".$this->model->getIsDelete('','string')."',
					[isApproved]	=	'".$this->model->getIsApproved('','string')."',
					[By]			=	'".$this->model->getBy()."',
					[Time]			=	".$this->model->getTime()."
			WHERE 	[groupId]		=	'".$this->groupId."'";
		} else if ($this->q->vendor==self::oracle) {
			$sql="
			UPDATE 	\"group\"
			SET 	\"groupDesc\"	=	'".$this->model->groupDesc."',
					\"isActive\"	=	'".$this->model->getIsActive('','string')."',
					\"isNew\"		=	'".$this->model->getIsNew('','string')."',
					\"isDraft\"		=	'".$this->model->getIsDraft('','string')."',
					\"isUpdate\"	=	'".$this->model->getIsUpdate('','string')."',
					\"isDelete\"	=	'".$this->model->getIsDelete('','string')."',
					\"isApproved\"	=	'".$this->model->getIsApproved('','string')."',
					\"By\"			=	'".$this->model->getBy()."',
					\"Time\"		=	".$this->model->getTime()."
			WHERE 	\"groupId\"		=	'".$this->groupId."'";
		}
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success"=>"true","message"=>"Record Update"));
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
			UPDATE 	`Group`
			SET 	`isDefault`			=	\"". $this->model->getIsDefault('','string') . "\",
					`isNew`				=	\"". $this->model->getIsNew('','string') . "\",
					`isDraft`			=	\"". $this->model->getIsDraft('','string') . "\",
					`isUpdate`			=	\"". $this->model->getIsUpdate('','string') . "\",
					`isDelete`			=	\"". $this->model->getIsDelete('','string') . "\",
					`isActive`			=	\"". $this->model->getIsActive('','string') . "\",
					`isApproved`		=	\"". $this->model->getIsApproved('','string') . "\",
					`By`				=	\"". $this->model->getBy() . "\",
					`Time`				=	" . $this->model->getTime() . "
			WHERE 	`GroupId`		=	\"". $this->model->getGroupId('','string') . "\"";
		} else if ($this->q->vendor == self::mssql) {
			$sql = "
			UPDATE 	[Group]
			SET 	[isDefault]			=	\"". $this->model->getIsDefault('','string') . "\",
					[isNew]				=	\"". $this->model->getIsNew('','string') . "\",
					[isDraft]			=	\"". $this->model->getIsDraft('','string') . "\",
					[isUpdate]			=	\"". $this->model->getIsUpdate('','string') . "\",
					[isDelete]			=	\"". $this->model->getIsDelete('','string') . "\",
					[isActive]			=	\"". $this->model->getIsActive('','string') . "\",
					[isApproved]		=	\"". $this->model->getIsApproved('','string') . "\",
					[By]				=	\"". $this->model->getBy() . "\",
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[GroupId]		=	\"". $this->model->getGroupId . "\"";
		} else if ($this->q->vendor == self::oracle) {
			$sql = "
			UPDATE 	\"Group\"
			SET 	\"GroupDesc\"	=	\"". $this->model->getGroupDesc('','string') . "\",
					\"isDefault\"		=	\"". $this->model->getIsDefault('','string') . "\",
					\"isNew\"			=	\"". $this->model->getIsNew('','string') . "\",
					\"isDraft\"			=	\"". $this->model->getIsDraft('','string') . "\",
					\"isUpdate\"		=	\"". $this->model->getIsUpdate('','string') . "\",
					\"isDelete\"		=	\"". $this->model->getIsDelete('','string') . "\",
					\"isActive\"		=	\"". $this->model->getIsActive('','string') . "\",
					\"isApproved\"		=	\"". $this->model->getIsApproved('','string') . "\",
					\"By\"				=	\"". $this->model->getBy() . "\",
					\"Time\"			=	" . $this->model->getTime() . "
			WHERE 	\"GroupId\"		=	\"". $this->model->getGroupId() . "\"";
		}
		// advance logging future
		$this->q->tableName       = $this->model->getTableName();
		$this->q->primaryKeyName  = $this->model->getPrimaryKeyName();
		$this->q->primaryKeyValue = $this->model->getGroupId();
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
						$GroupIdDelete.=$this->model->getGroupId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getGroupId($i,'array')."'
						THEN '".$this->model->getIsDefault('','string')."'";
					}
				}
				$sql.="	END, ";
				$sql.="	`isNew`	=	case `".$this->model->getPrimaryKeyName()."` ";

				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$GroupIdDelete.=$this->model->getGroupId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getGroupId($i,'array')."'
						THEN '".$this->model->getIsNew('','string')."'";
					}
				}
				$sql.="	END,";
				$sql.="	`isDraft`	=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$GroupIdDelete.=$this->model->getGroupId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getGroupId($i,'array')."'
						THEN '".$this->model->getIsDraft('','string')."'";
					}
				}
				$sql.="	END,";
				$sql.="	`isUpdate`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$GroupIdDelete.=$this->model->getGroupId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getGroupId($i,'array')."'
						THEN '".$this->model->getIsUpdate('','string')."'";
					}
				}
				$sql.="	END,";
				$sql.="	`isDelete`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$GroupIdDelete.=$this->model->getGroupId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getGroupId($i,'array')."'
						THEN '".$this->model->getIsDelete($i,'array')."'";
					}
				}
				$sql.="	END,	";
				$sql.="	`isActive`	=		case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$GroupIdDelete.=$this->model->getGroupId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getGroupId($i,'array')."'
						THEN '".$this->model->getIsActive('','string')."'";
					}
				}
				$sql.="	END,";
				$sql.="	`isApproved`			=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$GroupIdDelete.=$this->model->getGroupId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getGroupId($i,'array')."'
						THEN '".$this->model->getIsApproved('','string')."'";

					}
				}
				$sql.="
				END,
				`By`				=	\"". $this->model->getBy() . "\",
				`Time`				=	" . $this->model->getTime() . " ";


				$this->model->setGroupIdAll(substr($GroupIdDelete,0,-1));
				$sql.=" WHERE 	`".$this->model->getPrimaryKeyName()."`		IN	(". $this->model->getGroupIdAll(). ")";

			} else if ($this->q->vendor == self::mssql) {
				$sql = "
			UPDATE 	[Group]
			SET 	[isDefault]			=	\"". $this->model->getIsDefault('','string') . "\",
					[isNew]				=	\"". $this->model->getIsNew('','string') . "\",
					[isDraft]			=	\"". $this->model->getIsDraft('','string') . "\",
					[isUpdate]			=	\"". $this->model->getIsUpdate('','string') . "\",
					[isDelete]			=	\"". $this->model->getIsDelete('','string') . "\",
					[isActive]			=	\"". $this->model->getIsActive('','string') . "\",
					[isApproved]		=	\"". $this->model->getIsApproved('','string') . "\",
					[By]				=	\"". $this->model->getBy() . "\",
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[GroupId]		IN	(". $this->model->getGroupIdAll() . ")";
			} else if ($this->q->vendor == self::oracle) {
				$sql = "
				UPDATE	\"Group\"
				SET 	\"isDefault\"		=	\"". $this->model->getIsDefault('','string') . "\",
					\"isNew\"			=	\"". $this->model->getIsNew('','string') . "\",
					\"isDraft\"			=	\"". $this->model->getIsDraft('','string') . "\",
					\"isUpdate\"		=	\"". $this->model->getIsUpdate('','string') . "\",
					\"isDelete\"		=	\"". $this->model->getIsDelete('','string') . "\",
					\"isActive\"		=	\"". $this->model->getIsActive('','string') . "\",
					\"isApproved\"		=	\"". $this->model->getIsApproved('','string') . "\",
					\"By\"				=	\"". $this->model->getBy() . "\",
					\"Time\"			=	" . $this->model->getTime() . "
			WHERE 	\"GroupId\"		IN	(". $this->model->getGroupIdAll() . ")";
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
			//	echo "arnab[".$this->model->getGroupId(0,'array')."]";
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
							WHEN '".$this->model->getGroupId($i,'array')."'
							THEN '".$this->model->getIsDefault($i,'array')."'";
						}
						break;
					case 'isNew':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getGroupId($i,'array')."'
							THEN '".$this->model->getIsNew($i,'array')."'";

						} break;
					case 'isDraft':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getGroupId($i,'array')."'
							THEN '".$this->model->getIsDraft($i,'array')."'";
						}
						break;
					case 'isUpdate':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getGroupId($i,'array')."'
							THEN '".$this->model->getIsUpdate($i,'array')."'";
						}
						break;
					case 'isDelete':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getGroupId($i,'array')."'
							THEN '".$this->model->getIsDelete($i,'array')."'";
						}
						break;
					case 'isActive':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getGroupId($i,'array')."'
							THEN '".$this->model->getIsActive($i,'array')."'";
						}
						break;
					case 'isApproved':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getGroupId($i,'array')."'
							THEN '".$this->model->getIsApproved($i,'array')."'";
						}
						break;
				}


				$sqlLooping.= " END,";
			}

			$sql.=substr($sqlLooping,0,-1);
			if( $this->q->vendor==self::mysql) {
				$sql.="
			WHERE `".$this->model->getPrimaryKeyName()."` IN (".$this->model->getGroupIdAll().")";
			} else if($this->q->vendor==self::mssql) {
				$sql.="
			WHERE `=[".$this->model->getPrimaryKeyName()."] IN (".$this->model->getGroupIdAll().")";
			} else if ($this->q->vendor==self::oracle) {
				$sql.="
			WHERE \"".$this->model->getPrimaryKeyName()."\" IN (".$this->model->getGroupIdAll().")";
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
			FROM 	`group`
			WHERE 	`groupCode` 	= 	\"". $this->model->getGroupCode(). "\"
			AND		`isActive`		=	1";
		} else if ($this->q->vendor == self::mssql) {
			$sql = "
			SELECT	*
			FROM 	[group]
			WHERE 	[groupCode] 	= 	\"". $this->model->getGroupCode() . "\"
			AND		[isActive]		=	1";
		} else if ($this->q->vendor == self::oracle) {
			$sql = "
			SELECT	*
			FROM 	\"group\"
			WHERE 	\"groupCode\" 	= 	\"". $this->model->getGroupCode() . "\"
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
				return $total."|".$row['groupCode'];
			} else {

				echo json_encode(array(
					"success" => "true",
					"total" => $total,
					"message" => "Duplicate Record",
					"groupCode" => $row['groupCode']
				));
				exit();
			}
		}
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {}




}




$groupObject  	= 	new groupClass();
if(isset($_SESSION['staffId'])){
	$groupObject->setStaffId($_SESSION['staffId']);
}
if(isset($_SESSION['vendor'])){
	$groupObject->setVendor($_SESSION['vendor']);
}
if(isset($_SESSION['languageId'])){
	$groupObject->setLanguageId($_SESSION['languageId']);
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
		$groupObject->setLeafId($_POST['leafId']);
	}
	if(isset($_POST['query'])){
		$groupObject->setFieldQuery($_POST['query']);
	}
	if(isset($_POST['filter'])){
		$groupObject->setGridQuery($_POST['filter']);
	}
	/*
	 * Ordering
	 */
	if(isset($_POST['order'])){
		$groupObject->setOrder($_POST['order']);
	}
	if(isset($_POST['sortField'])){
		$groupObject->setSortField($_POST['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$groupObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_POST['method']=='create'){
		$groupObject->create();
	}
	if($_POST['method']=='read') 	{
		$groupObject->read();
	}

	if($_POST['method']=='save') 	{
		$groupObject->update();
	}
	if($_POST['method']=='delete') 	{
		$groupObject->delete();
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
		$groupObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$groupObject->setIsAdmin($_GET['isAdmin']);
	}

	/*
	 *  Load the dynamic value
	 */
	$groupObject->execute();
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {
			$staffObject->staff();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if($_GET['method']=='updateStatus'){
		$groupObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET['groupCode'])) {
		if (strlen($_GET['groupCode']) > 0) {
			$groupObject->duplicate();
		}
	}
	/*
	 * Excel Reporting
	 */
	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$groupObject->excel();
		}
	}
}
?>
