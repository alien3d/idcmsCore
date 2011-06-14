<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../class/classDocumentTrail.php");
require_once("../model/departmentModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package department
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class departmentClass  extends configClass {
	/*
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
	 * Current Table department Indentification Value
	 * @var numeric $departmentId
	 */
	public $departmentId;
	/**
	 * department Model
	 * @var string $departmentModel
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
	 * Duplicate Testing either the key of table same or have been created.
	 * @var boolean $duplicateTest;
	 */
	public $duplicateTest;
	/**
	 * Class Loader
	 */
	function execute() {
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

		$this->model         = new departmentModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->documentTrail = new documentTrailClass();
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
			INSERT INTO `department`
					(
						`departmentSequence`,				`departmentCode`,
						`departmentNote`,					`isDefault`,
						`isNew`,							`isDraft`,
						`isUpdate`,							`isDelete`,
						`isActive`,							`isApproved`,
						`By`,								`Time`
					)
			VALUES
					(
						\"". $this->model->getDepartmentSequence('','string') . "\",	\"". $this->model->getDepartmentSequence('','string') . "\",
						\"". $this->model->getDepartmentNote('','string') . "\",		\"". $this->model->getIsDefault('','string') . "\",
						\"". $this->model->getIsNew('','string') . "\",					\"". $this->model->getIsDraft('','string') . "\",
						\"". $this->model->getIsUpdate('','string') . "\",				\"". $this->model->getIsDelete('','string') . "\",
						\"". $this->model->getIsActive('','string') . "\",				\"". $this->model->getIsApproved('','string') . "\",
						\"". $this->model->getBy() . "\",								" . $this->model->getTime() . "
					);";
		}  else if ( $this->q->vendor==self::mssql) {
			$sql="
			INSERT INTO [department]
					(
						[departmentSequence],				[departmentCode],
						[departmentNote],					[isDefault],
						[isNew],							[isDraft],
						[isUpdate],							[isDelete],
						[isActive],							[isApproved],
						[By],								[Time]
					)
			VALUES
					(
						\"". $this->model->getDepartmentSequence('','string') . "\",	\"". $this->model->getDepartmentSequence('','string') . "\",
						\"". $this->model->getDepartmentNote('','string') . "\",		\"". $this->model->getIsDefault('','string') . "\",
						\"". $this->model->getIsNew('','string') . "\",					\"". $this->model->getIsDraft('','string') . "\",
						\"". $this->model->getIsUpdate('','string') . "\",				\"". $this->model->getIsDelete('','string') . "\",
						\"". $this->model->getIsActive('','string') . "\",				\"". $this->model->getIsApproved('','string') . "\",
						\"". $this->model->getBy() . "\",								" . $this->model->getTime() . "
					);";
		}  else if ($this->q->vendor==self::oracle) {
			$sql="
			INSERT INTO \"department`
					(
						\"departmentSequence\",				\"departmentCode\",
						\"departmentNote\",					\"isDefault\",
						\"isNew\",							\"isDraft\",
						\"isUpdate\",						\"isDelete\",
						\"isActive\",						\"isApproved\",
						\"By\",								\"Time\"
					)
			VALUES
					(
						\"". $this->model->getDepartmentSequence('','string') . "\",	\"". $this->model->getDepartmentSequence('','string') . "\",
						\"". $this->model->getDepartmentNote('','string') . "\",		\"". $this->model->getIsDefault('','string') . "\",
						\"". $this->model->getIsNew('','string') . "\",					\"". $this->model->getIsDraft('','string') . "\",
						\"". $this->model->getIsUpdate('','string') . "\",				\"". $this->model->getIsDelete('','string') . "\",
						\"". $this->model->getIsActive('','string') . "\",				\"". $this->model->getIsApproved('','string') . "\",
						\"". $this->model->getBy() . "\",								" . $this->model->getTime() . "
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
									`departmentId`
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
				[departmentId]
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
									\"departmentId\"
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
				$this->auditFilter = "	`department`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[department].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"department\".\"isActive\"	=	1	";
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
					SELECT	`department`.`departmentId`,
							`department`.`departmentSequence`,
							`department`.`departmentCode`,
							`department`.`departmentNote`,
							`department`.`isDefault`,
							`department`.`isNew`,
							`department`.`isDraft`,
							`department`.`isUpdate`,
							`department`.`isDelete`,
							`department`.`isActive`,
							`department`.`isApproved`,
							`department`.`By`,
							`department`.`Time`,
							`staff`.`staffName`
 					FROM 	`department`
					JOIN	`staff`
					ON		`department`.`By` = `staff`.`staffId`
					WHERE 	".$this->auditFilter;
			if ($this->model->getDepartmentId('','string')) {
				$sql .= " AND `".$this->model->getTableName()."`.".$this->model->getPrimaryKeyName()."`=\"". $this->model->getDepartmentId('','string') . "\"";

			}

		} else if ($this->q->vendor == self::mssql) {
			$sql = "
					SELECT	[department].[departmentId],
							[department].[departmentSequence],
							[department].[departmentCode],
							[department].[departmentNote],
							[department].[isDefault],
							[department].[isNew],
							[department].[isDraft],
							[department].[isUpdate],
							[department].[isDelete],
							[department].[isActive],
							[department].[isApproved],
							[department].[By],
							[department].[Time],
							[staff].[staffName]
					FROM 	[department]
					JOIN	[staff]
					ON		[department].[By] = [staff].[staffId]
					WHERE 	[department].[isActive] ='1'	";
			if ($this->model->getDepartmentId('','string')) {
				$sql .= " AND [".$this->model->getTableName()."].[".$this->model->getPrimaryKeyName()."]=\"". $this->model->getDepartmentId('','string') . "\"";
			}
		} else if ($this->q->vendor == self::oracle) {
			$sql = "
					SELECT	\"department\".\"departmentId\",
							\"department\".\"departmentCode\",
							\"department\".\"departmentSequence\",
							\"department\".\"departmentNote\",
							\"department\".\"isDefault\",
							\"department\".\"isNew\",
							\"department\".\"isDraft\",
							\"department\".\"isUpdate\",
							\"department\".\"isDelete\",
							\"department\".\"isActive\",
							\"department\".\"isApproved\",
							\"department\".\"By\",
							\"department\".\"Time\",
							\"staff\".\"staffName\"
					FROM 	\"department\"
					JOIN	\"staff\"
					ON		\"department\".\"By\" = \"staff\".\"staffId\"
					WHERE 	\"isActive\"='1'	";
			if ($this->model->getDepartmentId('','string')) {
				$sql .= " AND \"".$this->model->getTableName()."\".\"".$this->model->getPrimaryKeyName()."\"=\"". $this->model->getDepartmentId('','string') . "\"";
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
            'departmentId'
            );
            /**
             *	filter table
             * @variables $tableArray
             */
            $tableArray  = null;
            $tableArray  = array(
            'department'
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
							WITH [departmentDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [departmentId]) AS 'RowNumber'
								FROM [department]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[department].[departmentId],
										[department].[departmentSequence],
										[department].[departmentCode],
										[department].[departmentNote],
										[department].[isDefault],
										[department].[isNew],
										[department].[isDraft],
										[department].[isUpdate],
										[department].[isDelete],
										[department].[isApproved],
										[department].[By],
										[department].[Time],
										[staff].[staffName]
							FROM 		[departmentDerived]
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
									SELECT  \"department\".\"departmentId\",
											\"department\".\"departmentSequence\",
											\"department\".\"departmentCode\",
											\"department\".\"departmentNote\",
											\"department\".\"isDefault\",
											\"department\".\"isNew\",
											\"department\".\"isDraft\",
											\"department\".\"isUpdate\",
											\"department\".\"isDelete\",
											\"department\".\"isApproved\",
											\"department\".\"By\",
											\"department\".\"Time\",
											\"staff\".\"staffName\"
									FROM 	\"department\"
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
            if (!($this->model->getDepartmentId('','string'))) {
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
            if ($this->model->getDepartmentId('','string')) {
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
				UPDATE 	`department`
				SET 	`isDefault`		=	'".$this->model->getIsDefault()."',
						`isActive`		=	'".$this->model->getIsActive()."',
						`isNew`			=	'".$this->model->getIsNew()."',
						`isDraft`		=	'".$this->model->getIsDraft()."',
						`isUpdate`		=	'".$this->model->getIsUpdate()."',
						`isDelete`		=	'".$this->model->getIsDelete()."',
						`isApproved`	=	'".$this->model->getIsApproved()."',
						`By`			=	'".$this->model->getBy()."',
						`Time			=	".$this->model->getTime()."
				WHERE 	`departmentId`		=	'".$this->getDepartrmentId()."'";
		} else if ($this->q->vendor==self::mssql) {
			$sql="
				UPDATE 	[department]
				SET 	[isActive]		=	'".$this->model->getIsActive()."',
						[isNew]			=	'".$this->model->getIsNew()."',
						[isDraft]		=	'".$this->model->getIsDraft()."',
						[isUpdate]		=	'".$this->model->getIsUpdate()."',
						[isDelete]		=	'".$this->model->getIsDelete()."',
						[isApproved]	=	'".$this->model->getIsApproved()."',
						[By]			=	'".$this->model->getBy()."',
						[Time]			=	".$this->model->getTime()."
				WHERE 	[departmentId]		=	'".$this->getDepartmentId()."'";

		} else if ($this->q->vendor==self::oracle) {
			$sql="
				UPDATE 	\"department\"
				SET 	\"isActive\"	=	'".$this->model->getIsActive()."',
						\"isNew\"		=	'".$this->model->getIsNew()."',
						\"isDraft\"		=	'".$this->model->getIsDraft()."',
						\"isUpdate\"	=	'".$this->model->getIsUpdate()."',
						\"isDelete\"	=	'".$this->model->getIsDelete()."',
						\"isApproved\"	=	'".$this->model->getIsApproved()."',
						\"By\"			=	'".$this->model->getBy()."',
						\"Time\"		=	".$this->model->getTime()."
				WHERE 	\"departmentId\"		=	'".$this->getdepartmentId()."'";

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
	function delete()				{
		header('Content-Type','application/json; charset=utf-8');
		if( $this->q->vendor==self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		$this->q->commit();
		$this->model->delete();
		if( $this->q->vendor==self::mysql) {
			$sql="
				UPDATE 	`department`
				SET 	`isDefault`		=	'".$this->model->getIsDefault()."',
						`isActive`		=	'".$this->model->getIsActive()."',
						`isNew`			=	'".$this->model->getIsNew()."',
						`isDraft`		=	'".$this->model->getIsDraft()."',
						`isUpdate`		=	'".$this->model->getIsUpdate()."',
						`isDelete`		=	'".$this->model->getIsDelete()."',
						`isApproved`	=	'".$this->model->getIsApproved()."',
						`By`			=	'".$this->model->getBy()."',
						`Time			=	".$this->model->getTime()."
				WHERE 	`departmentId`		=	'".$this->getDepartrmentId()."'";
		} else if ($this->q->vendor==self::mssql) {
			$sql="
				UPDATE 	[department]
				SET 	[isActive]		=	'".$this->model->getIsActive()."',
						[isNew]			=	'".$this->model->getIsNew()."',
						[isDraft]		=	'".$this->model->getIsDraft()."',
						[isUpdate]		=	'".$this->model->getIsUpdate()."',
						[isDelete]		=	'".$this->model->getIsDelete()."',
						[isApproved]	=	'".$this->model->getIsApproved()."',
						[By]			=	'".$this->model->getBy()."',
						[Time]			=	".$this->model->getTime()."
				WHERE 	[departmentId]		=	'".$this->getDepartmentId()."'";

		} else if ($this->q->vendor==self::oracle) {
			$sql="
				UPDATE 	\"department\"
				SET 	\"isActive\"	=	'".$this->model->getIsActive()."',
						\"isNew\"		=	'".$this->model->getIsNew()."',
						\"isDraft\"		=	'".$this->model->getIsDraft()."',
						\"isUpdate\"	=	'".$this->model->getIsUpdate()."',
						\"isDelete\"	=	'".$this->model->getIsDelete()."',
						\"isApproved\"	=	'".$this->model->getIsApproved()."',
						\"By\"			=	'".$this->model->getBy()."',
						\"Time\"		=	".$this->model->getTime()."
				WHERE 	\"departmentId\"		=	'".$this->getdepartmentId()."'";

		}
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();
		}
		$this->q->commit();

		echo json_encode(array("success"=>"true","message"=>"Record Remove"));
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
						$DepartmentIdDelete.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getDepartmentId($i,'array')."'
						THEN '".$this->model->getIsDefault('','string')."'";
					}
				}
				$sql.="	END, ";
				$sql.="	`isNew`	=	case `".$this->model->getPrimaryKeyName()."` ";

				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$DepartmentIdDelete.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getDepartmentId($i,'array')."'
						THEN '".$this->model->getIsNew('','string')."'";
					}
				}
				$sql.="	END,";
				$sql.="	`isDraft`	=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$DepartmentIdDelete.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getDepartmentId($i,'array')."'
						THEN '".$this->model->getIsDraft('','string')."'";
					}
				}
				$sql.="	END,";
				$sql.="	`isUpdate`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$DepartmentIdDelete.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getDepartmentId($i,'array')."'
						THEN '".$this->model->getIsUpdate('','string')."'";
					}
				}
				$sql.="	END,";
				$sql.="	`isDelete`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$DepartmentIdDelete.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getDepartmentId($i,'array')."'
						THEN '".$this->model->getIsDelete($i,'array')."'";
					}
				}
				$sql.="	END,	";
				$sql.="	`isActive`	=		case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$DepartmentIdDelete.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getDepartmentId($i,'array')."'
						THEN '".$this->model->getIsActive('','string')."'";
					}
				}
				$sql.="	END,";
				$sql.="	`isApproved`			=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$DepartmentIdDelete.=$this->model->getDepartmentId($i,'array').",";
						$sql.="
						WHEN '".$this->model->getDepartmentId($i,'array')."'
						THEN '".$this->model->getIsApproved('','string')."'";

					}
				}
				$sql.="
				END,
				`By`				=	\"". $this->model->getBy() . "\",
				`Time`				=	" . $this->model->getTime() . " ";


				$this->model->setDepartmentIdAll(substr($DepartmentIdDelete,0,-1));
				$sql.=" WHERE 	`".$this->model->getPrimaryKeyName()."`		IN	(". $this->model->getDepartmentIdAll(). ")";

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
			WHERE 	[DepartmentId]		IN	(". $this->model->getDepartmentIdAll() . ")";
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
			WHERE 	\"DepartmentId\"		IN	(". $this->model->getDepartmentIdAll() . ")";
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
							WHEN '".$this->model->getDepartmentId($i,'array')."'
							THEN '".$this->model->getIsDefault($i,'array')."'";
						}
						break;
					case 'isNew':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getDepartmentId($i,'array')."'
							THEN '".$this->model->getIsNew($i,'array')."'";

						} break;
					case 'isDraft':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getDepartmentId($i,'array')."'
							THEN '".$this->model->getIsDraft($i,'array')."'";
						}
						break;
					case 'isUpdate':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getDepartmentId($i,'array')."'
							THEN '".$this->model->getIsUpdate($i,'array')."'";
						}
						break;
					case 'isDelete':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getDepartmentId($i,'array')."'
							THEN '".$this->model->getIsDelete($i,'array')."'";
						}
						break;
					case 'isActive':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getDepartmentId($i,'array')."'
							THEN '".$this->model->getIsActive($i,'array')."'";
						}
						break;
					case 'isApproved':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN '".$this->model->getDepartmentId($i,'array')."'
							THEN '".$this->model->getIsApproved($i,'array')."'";
						}
						break;
				}


				$sqlLooping.= " END,";
			}

			$sql.=substr($sqlLooping,0,-1);
			if( $this->q->vendor==self::mysql) {
				$sql.="
			WHERE `".$this->model->getPrimaryKeyName()."` IN (".$this->model->getDepartmentIdAll().")";
			} else if($this->q->vendor==self::mssql) {
				$sql.="
			WHERE `=[".$this->model->getPrimaryKeyName()."] IN (".$this->model->getDepartmentIdAll().")";
			} else if ($this->q->vendor==self::oracle) {
				$sql.="
			WHERE \"".$this->model->getPrimaryKeyName()."\" IN (".$this->model->getDepartmentIdAll().")";
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
			FROM 	`department`
			WHERE 	`departmentCode` 	= 	\"". $this->model->getDepartmentCode(). "\"
			AND		`isActive`		=	1";
		} else if ($this->q->vendor == self::mssql) {
			$sql = "
			SELECT	*
			FROM 	[department]
			WHERE 	[departmentCode] 	= 	\"". $this->model->getDepartmentCode() . "\"
			AND		[isActive]		=	1";
		} else if ($this->q->vendor == self::oracle) {
			$sql = "
			SELECT	*
			FROM 	\"department\"
			WHERE 	\"departmentCode\" 	= 	\"". $this->model->getDepartmentCode() . "\"
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
				return $total."|".$row['departmentCode'];
			} else {

				echo json_encode(array(
					"success" => "true",
					"total" => $total,
					"message" => "Duplicate Record",
					"departmentCode" => $row['departmentCode']
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


$departmentObject  	= 	new departmentClass();
if(isset($_SESSION['staffId'])){
	$departmentObject->staffId = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$departmentObject-> vendor = $_SESSION['vendor'];
}
/**
 *	crud -create,read,update,delete
 **/
if(isset($_POST['method']))	{
	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_POST['leafId'])){
		$departmentObject-> leafId = $_POST['leafId'];
	}
	if($_POST['method']=='create')	{
		$departmentObject->create();
	}
	if(isset($_POST['filter'])){
		$departmentObject->filter = $_POST['filter'];
	}
	if(isset($_POST['query'])){
		$departmentObject->query = $_POST['query'];
	}
	if(isset($_POST['order'])){
		$departmentObject-> order= $_POST['order'];
	}
	if(isset($_POST['sortField'])){
		$departmentObject-> sortField= $_POST['sortField'];
	}
	/*
	 *  Load the dynamic value
	 */
	$departmentObject->execute();
	if($_POST['method']=='read') 	{
		$departmentObject->read();
	}
	if($_POST['method']=='create') 	{
		$departmentObject->create();
	}
	if($_POST['method']=='save') 	{
		$departmentObject->read();
	}
	if($_POST['method']=='delete') 	{
		$departmentObject->delete();
	}

}

if(isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_GET['leafId'])){
		$departmentObject-> leafId  = $_GET['leafId'];
	}
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {
			$departmentObject->staffId();
		}
	}

	if($_GET['method']=='updateStatus'){
		$departmentObject->updateStatus();
	}
	if (isset($_GET['departmentCode'])) {
		if (strlen($_GET['departmentCode']) > 0) {
			$departmentObject->duplicate();
		}
	}
	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$departmentObject->excel();
		}
	}
}
echo print_r($_SESSION);
?>
