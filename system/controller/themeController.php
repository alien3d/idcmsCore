<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../model/themeModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package System
 * @subpackage theme
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class themeClass  extends configClass {
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

		$this->q              	= new vendor();
		$this->q->vendor      	= $this->getVendor();
		$this->q->leafId      	= $this->getLeafId();
		$this->q->staffId     	= $this->getStaffId();
		$this->q->fieldQuery	= $this->getFieldQuery();
		$this->q->gridQuery   = $this->getGridQuery();

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());
		$this->excel         = new PHPExcel();
		$this->audit         = 0;
		$this->log           = 1;
		$this->q->log        = $this->log;

		$this->model         = new themeModel();
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
	function create() 				{
		header('Content-Type','application/json; charset=utf-8');

		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->create();
		if($this->getVendor() == self::mysql) {
			$sql="
			INSERT INTO `theme`
					(
						`themeSequence`,				`themeCode`,
						`themeNote`,					`themePath`,
						`isDefault`,					`isNew`,							
						`isDraft`,						`isUpdate`,							
						`isDelete`,						`isActive`,							
						`isApproved`,					`executeBy`,								
						`executeTime`
					)
			VALUES
					(
						\"". $this->model->getThemeSequence() . "\",				\"". $this->model->getThemeCode() . "\",
						\"". $this->model->getThemeNote() . "\",					\"". $this->model->getThemeNote() . "\",
						\"". $this->model->getIsDefault(0,'single') . "\",			\"". $this->model->getIsNew(0,'single') . "\",					
						\"". $this->model->getIsDraft(0,'single') . "\",			\"". $this->model->getIsUpdate(0,'single') . "\",				
						\"". $this->model->getIsDelete(0,'single') . "\",			\"". $this->model->getIsActive(0,'single') . "\",				
						\"". $this->model->getIsApproved(0,'single') . "\",			\"". $this->model->getExecuteBy() . "\",								
						" . $this->model->getExecuteTime() . "
					);";
		}  else if ( $this->getVendor()==self::mssql) {
			$sql="
			INSERT INTO [theme]
					(
						[themeSequence],				[themeCode],
						[themeNote],					[themePath],
						[isDefault],					[isNew],							
						[isDraft],						[isUpdate],							
						[isDelete],						[isActive],							
						[isApproved],					[executeBy],								
						[executeTime]
					)
			VALUES
					(
						\"". $this->model->getThemeSequence() . "\",				\"". $this->model->getThemeCode() . "\",
						\"". $this->model->getThemeNote() . "\",					\"". $this->model->getThemeNote() . "\",
						\"". $this->model->getIsDefault(0,'single') . "\",			\"". $this->model->getIsNew(0,'single') . "\",					
						\"". $this->model->getIsDraft(0,'single') . "\",			\"". $this->model->getIsUpdate(0,'single') . "\",				
						\"". $this->model->getIsDelete(0,'single') . "\",			\"". $this->model->getIsActive(0,'single') . "\",				
						\"". $this->model->getIsApproved(0,'single') . "\",			\"". $this->model->getExecuteBy() . "\",								
						" . $this->model->getExecuteTime() . "
					);";
		}  else if ($this->getVendor()==self::oracle) {
			$sql="
			INSERT INTO \"theme`
					(
						\"themeSequence\",				\"themeCode\",
						\"themeNote\",					\"themePath\",	
						ISDEFAULT,					ISNEW,							
						ISDRAFT,					ISUPDATE,						
						ISDELETE,					ISACTIVE,						
						ISAPPROVED,					EXECUTEBY,								
						EXECUTETIME
					)
			VALUES
					(
						\"". $this->model->getThemeSequence() . "\",				\"". $this->model->getThemeCode() . "\",
						\"". $this->model->getThemeNote() . "\",					\"". $this->model->getThemeNote() . "\",
						\"". $this->model->getIsDefault(0,'single') . "\",			\"". $this->model->getIsNew(0,'single') . "\",					
						\"". $this->model->getIsDraft(0,'single') . "\",			\"". $this->model->getIsUpdate(0,'single') . "\",				
						\"". $this->model->getIsDelete(0,'single') . "\",			\"". $this->model->getIsActive(0,'single') . "\",				
						\"". $this->model->getIsApproved(0,'single') . "\",			\"". $this->model->getExecuteBy() . "\",								
						" . $this->model->getExecuteTime() . "
					);";

		}
		$this->q->create($sql);

		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
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
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	`theme`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[theme].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"theme\".ISACTIVE	=	1	";
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
					SELECT	`theme`.`themeId`,
							`theme`.`themeSequence`,
							`theme`.`themeCode`,
							`theme`.`themeNote`,
							`theme`.`themePath`,
							`theme`.`isDefault`,
							`theme`.`isNew`,
							`theme`.`isDraft`,
							`theme`.`isUpdate`,
							`theme`.`isDelete`,
							`theme`.`isActive`,
							`theme`.`isApproved`,
							`theme`.`executeBy`,
							`theme`.`executeTime`,
							`staff`.`staffName`
 					FROM 	`theme`
					JOIN	`staff`
					ON		`theme`.`executeBy` = `staff`.`staffId`
					WHERE 	".$this->auditFilter;
			if ($this->model->getThemeId(0,'single')) {
				$sql .= " AND `".$this->model->getTableName()."`.`".$this->model->getPrimaryKeyName()."`=\"". $this->model->getThemeId(0,'single') . "\"";

			}

		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
					SELECT	[theme].[themeId],
							[theme].[themeSequence],
							[theme].[themeCode],
							[theme].[themeNote],
							[theme].[themePath],
							[theme].[isDefault],
							[theme].[isNew],
							[theme].[isDraft],
							[theme].[isUpdate],
							[theme].[isDelete],
							[theme].[isActive],
							[theme].[isApproved],
							[theme].[executeBy],
							[theme].[executeTime],
							[staff].[staffName]
					FROM 	[theme]
					JOIN	[staff]
					ON		[theme].[executeBy] = [staff].[staffId]
					WHERE 	[theme].[isActive] 	=	'1'	";
			if ($this->model->getThemeId(0,'single')) {
				$sql .= " AND [".$this->model->getTableName()."].[".$this->model->getPrimaryKeyName()."]='". $this->model->getThemeId(0,'single') . "'";
			}
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT	THEME.THEMEID 		AS	\"themeId\",
					THEME.THEMECODE 	AS 	\"themeCode\",
					THEME.THEMESEQUENCE AS 	\"themeSequence\",
					THEME.THEMENOTE 	AS 	\"themeNote\",
					THEME.THEMEPATH 	AS 	\"themePath\",
					THEME.ISDEFAULT 	AS 	\"isDefault\",
					THEME.ISNEW 		AS	\"isNew\",
					THEME.ISDRAFT  		AS 	\"isDraft\",
					THEME.ISUPDATE 		AS 	\"isUpdate\",					
					THEME.ISDELETE 		AS 	\"isDelete\",
					THEME.ISACTIVE 		AS 	\"isActive\",
					THEME.ISAPPROVED 	AS 	\"isApproved\",
					THEME.EXECUTEBY 	AS 	\"executeBy\",
					THEME.EXECUTETIME 	AS  \"executeTime\",
					STAFF.STAFFNAME 	AS 	\"staffName\"
			FROM 	THEME
			JOIN	STAFF
			ON		THEME.EXECUTEBY 	= 	STAFF.STAFFID
			WHERE 	THEME.ISACTIVE	=	1 ";
			if ($this->model->getThemeId(0,'single')) {
				$sql .= " AND \"".$this->model->getTableName()."\".\"".$this->model->getPrimaryKeyName()."\"=\"". $this->model->getThemeId(0,'single') . "\"";
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
            'themeId'
            );
            /**
             *	filter table
             * @variables $tableArray
             */
            $tableArray  = null;
            $tableArray  = array(
            'theme'
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
            		$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . "  " . strtoupper($this->getOrder()). " ";
            	}
            }
            $_SESSION['sql']   = $sql; // push to session so can make report via excel and pdf
            $_SESSION['start'] = $this->getStart();
            $_SESSION['limit'] = $this->getLimit();
            if (!($this->getGridQuery())) {
            	if ($this->getLimit()) {
            		// only mysql have limit
            		if ($this->getVendor() == self::mysql) {
            			$sql .= " LIMIT  " . $this->getStart() . "," . $this->getLimit() . " ";
            		} else if ($this->getVendor() == self::mssql) {
            			/**
            			 *	 Sql Server and Oracle used row_number
            			 *	 Parameterize Query We don't support
            			 */
            			$sql = "
							WITH [themeDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [themeId]) AS 'RowNumber'
								FROM [theme]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[theme].[themeId],
										[theme].[themeSequence],
										[theme].[themeCode],
										[theme].[themeNote],
										[theme].[isDefault],
										[theme].[isNew],
										[theme].[isDraft],
										[theme].[isUpdate],
										[theme].[isDelete],
										[theme].[isApproved],
										[theme].[executeBy],
										[theme].[executeTime],
										[staff].[staffName]
							FROM 		[themeDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $_POST['start'] . "
							AND 			" . ($this->getStart() + $this->getLimit() - 1) . ";";
            		} else if ($this->getVendor() == self::oracle) {
            			/**
            			 *  Oracle using derived table also
            			 */
            			$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT	THEME.THEMEID 		AS	\"themeId\",
					THEME.THEMECODE 	AS 	\"themeCode\",
					THEME.THEMESEQUENCE AS 	\"themeSequence\",
					THEME.THEMENOTE 	AS 	\"themeNote\",
					THEME.THEMEPATH 	AS 	\"themePath\",
					THEME.ISDEFAULT 	AS 	\"isDefault\",
					THEME.ISNEW 		AS	\"isNew\",
					THEME.ISDRAFT  		AS 	\"isDraft\",
					THEME.ISUPDATE 		AS 	\"isUpdate\",					
					THEME.ISDELETE 		AS 	\"isDelete\",
					THEME.ISACTIVE 		AS 	\"isActive\",
					THEME.ISAPPROVED 	AS 	\"isApproved\",
					THEME.EXECUTEBY 	AS 	\"executeBy\",
					THEME.EXECUTETIME 	AS  \"executeTime\",
					STAFF.STAFFNAME 	AS 	\"staffName\"
			FROM 	THEME
			JOIN	STAFF
			ON		THEME.EXECUTEBY 	= 	STAFF.STAFFID
			WHERE 	THEME.ISACTIVE	=	1  " . $tempSql . $tempSql2 . $orderBy . "
								 ) a
						where rownum <= \"". ($this->getStart() + $this->getLimit() - 1) . "\" )
						where r >=  \"". $this->getStart() . "\"";
            		} else {
            			echo "undefine vendor";
            			exit();
            		}
            	}
            }
            /*
             *  Only Execute One Query
             */
            if (!($this->model->getThemeId(0,'single'))) {
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
            if ($this->model->getThemeId(0,'single')) {
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
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->commit();
		$this->model->update();
		if($this->getVendor() == self::mysql) {
			$sql="
				UPDATE 	`theme`
				SET		`themeSequence`	=	\"".$this->model->getThemeSequence()."\",
						`themeCode`		=	\"".$this->model->getThemeCode()."\",
						`themeNote` 	= 	\"".$this->model->getThemeNote()."\",
						`isDefault`		=	\"".$this->model->getIsDefault(0,'single')."\",
						`isActive`		=	\"".$this->model->getIsActive(0,'single')."\",
						`isNew`			=	\"".$this->model->getIsNew(0,'single')."\",
						`isDraft`		=	\"".$this->model->getIsDraft(0,'single')."\",
						`isUpdate`		=	\"".$this->model->getIsUpdate(0,'single')."\",
						`isDelete`		=	\"".$this->model->getIsDelete(0,'single')."\",
						`isApproved`	=	\"".$this->model->getIsApproved(0,'single')."\",
						`executeBy`		=	\"".$this->model->getExecuteBy()."\",
						`executeTime`	=	".$this->model->getExecuteTime()."
				WHERE 	`themeId`		=	\"".$this->model->getThemeId(0,'single')."\"";
		} else if ($this->getVendor()==self::mssql) {
			$sql="
				UPDATE 	[theme]
				SET 	[themeSequence]	=	'".$this->model->getThemeSequence()."',
						[themeCode]		=	'".$this->model->getThemeCode()."',
						[themeNote] 	= 	'".$this->model->getThemeNote()."',
						[isDefault]		=	'".$this->model->getIsDefault(0,'single')."',
						[isActive]		=	'".$this->model->getIsActive(0,'single')."',
						[isNew]			=	'".$this->model->getIsNew(0,'single')."',
						[isDraft]		=	'".$this->model->getIsDraft(0,'single')."',
						[isUpdate]		=	'".$this->model->getIsUpdate(0,'single')."',
						[isDelete]		=	'".$this->model->getIsDelete(0,'single')."',
						[isApproved]	=	'".$this->model->getIsApproved(0,'single')."',
						[executeBy]		=	'".$this->model->getExecuteBy()."',
						[executeTime]	=	".$this->model->getExecuteTime()."
				WHERE 	[themeId]		=	'".$this->model->getThemeId(0,'single')."'";

		} else if ($this->getVendor()==self::oracle) {
			$sql="
				UPDATE 	\"theme\"
				SET 	\"themeSequence\"	=	\"".$this->model->getThemeSequence()."\",
						\"themeCode\"		=	\"".$this->model->getThemeCode()."\",
						\"themeNote\" 		= 	\"".$this->model->getThemeNote()."\",
						ISDEFAULT		=	\"".$this->model->getIsDefault(0,'single')."\",
						ISACTIVE		=	\"".$this->model->getIsActive(0,'single')."\",
						ISNEW			=	\"".$this->model->getIsNew(0,'single')."\",
						ISDRAFT			=	\"".$this->model->getIsDraft(0,'single')."\",
						ISUPDATE		=	\"".$this->model->getIsUpdate(0,'single')."\",
						ISDELETE		=	\"".$this->model->getIsDelete(0,'single')."\",
						ISAPPROVED		=	\"".$this->model->getIsApproved(0,'single')."\",
						EXECUTEBY				=	\"".$this->model->getExecuteBy()."\",
						EXECUTETIME			=	".$this->model->getExecuteTime()."
				WHERE 	\"themeId\"			=	\"".$this->model->getThemeId(0,'single')."\"";

		}
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success"=>true,"message"=>"Record Update"));
		exit();
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete()				{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->commit();
		$this->model->delete();
		if($this->getVendor() == self::mysql) {
			$sql="
				UPDATE 	`theme`
				SET 	`isDefault`		=	\"".$this->model->getIsDefault(0,'single')."\",
						`isActive`		=	\"".$this->model->getIsActive(0,'single')."\",
						`isNew`			=	\"".$this->model->getIsNew(0,'single')."\",
						`isDraft`		=	\"".$this->model->getIsDraft(0,'single')."\",
						`isUpdate`		=	\"".$this->model->getIsUpdate(0,'single')."\",
						`isDelete`		=	\"".$this->model->getIsDelete(0,'single')."\",
						`isApproved`	=	\"".$this->model->getIsApproved(0,'single')."\",
						`executeBy`			=	\"".$this->model->getBy(0,'single')."\",
						`executeTime			=	".$this->model->getExecuteTime()."
				WHERE 	`themeId`		=	\"".$this->model->getDepartrmentId(0,'single')."\"";
		} else if ($this->getVendor()==self::mssql) {
			$sql="
				UPDATE 	[theme]
				SET 	[isDefault]		=	'".$this->model->getIsDefault(0,'single')."',
						[isActive]		=	'".$this->model->getIsActive(0,'single')."',
						[isNew]			=	'".$this->model->getIsNew(0,'single')."',
						[isDraft]		=	'".$this->model->getIsDraft(0,'single')."',
						[isUpdate]		=	'".$this->model->getIsUpdate(0,'single')."',
						[isDelete]		=	'".$this->model->getIsDelete(0,'single')."',
						[isApproved]	=	'".$this->model->getIsApproved(0,'single')."',
						[executeBy]		=	'".$this->model->getExecuteBy()."',
						[executeTime]	=	".$this->model->getExecuteTime()."
				WHERE 	[themeId]		=	\"".$this->model->getThemeId(0,'single')."\"";

		} else if ($this->getVendor()==self::oracle) {
			$sql="
				UPDATE 	\"theme\"
				SET 	ISDEFAULT	=	\"".$this->model->getIsDefault(0,'single')."\",
						ISACTIVE	=	\"".$this->model->getIsActive(0,'single')."\",
						ISNEW		=	\"".$this->model->getIsNew(0,'single')."\",
						ISDRAFT		=	\"".$this->model->getIsDraft(0,'single')."\",
						ISUPDATE	=	\"".$this->model->getIsUpdate(0,'single')."\",
						ISDELETE	=	\"".$this->model->getIsDelete(0,'single')."\",
						ISAPPROVED	=	\"".$this->model->getIsApproved(0,'single')."\",
						EXECUTEBY	=	\"".$this->model->getExecuteBy()."\",
						EXECUTETIME	=	".$this->model->getExecuteTime()."
				WHERE 	\"themeId\"		=	\"".$this->model->getThemeId(0,'single')."\"";

		}
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		$this->q->commit();

		echo json_encode(array("success"=>true,"message"=>"Record Remove"));
		exit();

	}
	/**
	 *  To Update flag Status
	 */
	function updateStatus () {
		$this->model-> updateStatus();
		$loop  = $this->model->getTotal();

		if($this->isAdmin==0){

			$this->model->delete();
			if ($this->getVendor() == self::mysql) {
				$sql = "
				UPDATE 	`".$this->model->getTableName()."`
				SET 	";

				$sql.="	   `isDefault`			=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getThemeId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getThemeId($i,'array')."\"
						THEN \"".$this->model->getIsDefault(0,'single')."\"";
					}
				}
				$sql.="	END, ";
				$sql.="	`isNew`	=	case `".$this->model->getPrimaryKeyName()."` ";

				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getThemeId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getThemeId($i,'array')."\"
						THEN \"".$this->model->getIsNew(0,'single')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isDraft`	=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getThemeId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getThemeId($i,'array')."\"
						THEN \"".$this->model->getIsDraft(0,'single')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isUpdate`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getThemeId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getThemeId($i,'array')."\"
						THEN \"".$this->model->getIsUpdate(0,'single')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isDelete`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getThemeId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getThemeId($i,'array')."\"
						THEN \"".$this->model->getIsDelete($i,'array')."\"";
					}
				}
				$sql.="	END,	";
				$sql.="	`isActive`	=		case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getThemeId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getThemeId($i,'array')."\"
						THEN \"".$this->model->getIsActive(0,'single')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isApproved`			=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getThemeId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getThemeId($i,'array')."\"
						THEN \"".$this->model->getIsApproved(0,'single')."\"";

					}
				}
				$sql.="
				END,
				`executeBy`				=	\"". $this->model->getExecuteBy() . "\",
				`executeTime`				=	" . $this->model->getExecuteTime() . " ";


				$this->model->setPrimaryKeyAll(substr($primaryKeyAll,0,-1));
				$sql.=" WHERE 	`".$this->model->getPrimaryKeyName()."`		IN	(". $this->model->getPrimaryKeyAll(). ")";

			} else if ($this->getVendor() ==  self::mssql) {
				$sql = "
			UPDATE 	[theme]
			SET 	[isDefault]			=	\"". $this->model->getIsDefault(0,'single') . "\",
					[isNew]				=	\"". $this->model->getIsNew(0,'single') . "\",
					[isDraft]			=	\"". $this->model->getIsDraft(0,'single') . "\",
					[isUpdate]			=	\"". $this->model->getIsUpdate(0,'single') . "\",
					[isDelete]			=	\"". $this->model->getIsDelete(0,'single') . "\",
					[isActive]			=	\"". $this->model->getIsActive(0,'single') . "\",
					[isApproved]		=	\"". $this->model->getIsApproved(0,'single') . "\",
					[executeBy]				=	\"". $this->model->getExecuteBy() . "\",
					[executeTime]				=	" . $this->model->getExecuteTime() . "
			WHERE 	[themeId]		IN	(". $this->model->getThemeIdAll() . ")";
			} else if ($this->getVendor() == self::oracle) {
				$sql = "
				UPDATE	\"theme\"
				SET 	ISDEFAULT		=	\"". $this->model->getIsDefault(0,'single') . "\",
					ISNEW			=	\"". $this->model->getIsNew(0,'single') . "\",
					ISDRAFT			=	\"". $this->model->getIsDraft(0,'single') . "\",
					ISUPDATE		=	\"". $this->model->getIsUpdate(0,'single') . "\",
					ISDELETE		=	\"". $this->model->getIsDelete(0,'single') . "\",
					ISACTIVE		=	\"". $this->model->getIsActive(0,'single') . "\",
					ISAPPROVED		=	\"". $this->model->getIsApproved(0,'single') . "\",
					EXECUTEBY				=	\"". $this->model->getExecuteBy() . "\",
					EXECUTETIME			=	" . $this->model->getExecuteTime() . "
			WHERE 	\"themeId\"		IN	(". $this->model->getThemeIdAll() . ")";
			}
		} else if ($this->isAdmin ==1){

			if($this->getVendor() == self::mysql) {
				$sql="
				UPDATE `".$this->model->getTableName()."`
				SET";
			} else if($this->getVendor()==self::mssql) {
				$sql="
			UPDATE 	[".$this->model->getTableName()."]
			SET 	";

			} else if ($this->getVendor()==self::oracle) {
				$sql="
			UPDATE \"".$this->model->getTableName()."\"
			SET    ";
			}
			//	echo "arnab[".$this->model->getThemeId(0,'array')."]";
			/**
			 *	System Validation Checking
			 *  @var $access
			 */
			$access  = array("isDefault","isNew","isDraft","isUpdate","isDelete","isActive","isApproved");
			foreach($access as $systemCheck) {


				if($this->getVendor() == self::mysql) {
					$sqlLooping.=" `".$systemCheck."` = CASE `".$this->model->getPrimaryKeyName()."`";
				} else if($this->getVendor()==self::mssql) {
					$sqlLooping.="  [".$systemCheck."] = CASE [".$this->model->getPrimaryKeyName()."]";

				} else if ($this->getVendor()==self::oracle) {
					$sqlLooping.="	\"".$systemCheck."\" = CASE \"".$this->model->getPrimaryKeyName()."\"";
				}
				switch ($systemCheck){
					case 'isDefault':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getThemeId($i,'array')."\"
							THEN \"".$this->model->getIsDefault($i,'array')."\"";
						}
						break;
					case 'isNew':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getThemeId($i,'array')."\"
							THEN \"".$this->model->getIsNew($i,'array')."\"";

						} break;
					case 'isDraft':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getThemeId($i,'array')."\"
							THEN \"".$this->model->getIsDraft($i,'array')."\"";
						}
						break;
					case 'isUpdate':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getThemeId($i,'array')."\"
							THEN \"".$this->model->getIsUpdate($i,'array')."\"";
						}
						break;
					case 'isDelete':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getThemeId($i,'array')."\"
							THEN \"".$this->model->getIsDelete($i,'array')."\"";
						}
						break;
					case 'isActive':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getThemeId($i,'array')."\"
							THEN \"".$this->model->getIsActive($i,'array')."\"";
						}
						break;
					case 'isApproved':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getThemeId($i,'array')."\"
							THEN \"".$this->model->getIsApproved($i,'array')."\"";
						}
						break;
				}


				$sqlLooping.= " END,";
			}

			$sql.=substr($sqlLooping,0,-1);
			if($this->getVendor() == self::mysql) {
				$sql.="
			WHERE `".$this->model->getPrimaryKeyName()."` IN (".$this->model->getPrimaryKeyAll().")";
			} else if($this->getVendor()==self::mssql) {
				$sql.="
			WHERE `=[".$this->model->getPrimaryKeyName()."] IN (".$this->model->getPrimaryKeyAll().")";
			} else if ($this->getVendor()==self::oracle) {
				$sql.="
			WHERE \"".$this->model->getPrimaryKeyName()."\" IN (".$this->model->getPrimaryKeyAll().")";
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
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
			SELECT	*
			FROM 	`theme`
			WHERE 	`themeCode` 	= 	\"". $this->model->getThemeCode(). "\"
			AND		`isActive`		=	1";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			SELECT	*
			FROM 	[theme]
			WHERE 	[themeCode] 	= 	'". $this->model->getThemeCode() . "'
			AND		[isActive]		=	1";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT	*
			FROM 	\"theme\"
			WHERE 	\"themeCode\" 	= 	\"". $this->model->getThemeCode() . "\"
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
		} else {
			$row = $this->q->fetchArray();
			if($this->duplicateTest == 1) {
				return $total."|".$row['themeCode'];
			} else {

				echo json_encode(array(
					"success" => "true",
					"total" => $total,
					"message" => "Duplicate Record",
					"themeCode" => $row['themeCode']
				));
				exit();
			}
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

                        if($this->isAdmin==1){
                        	$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
                        } else {
                        	$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                        	$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                        }
                        if($this->isAdmin==1){
                        	$start='B';
                        	$end='0';
                        } else {
                        	$start='B';
                        	$end='F';
                        }
                        // merge header title
                        $this->excel->getActiveSheet()->setCellValue($start.'2', $this->title);
                        $this->excel->getActiveSheet()->setCellValue($end.'2', '');
                        $this->excel->getActiveSheet()->mergeCells($start.'2:'.$end.'3');
                        // header of the row
                        if($this->isAdmin==1){
                        	// future should take from table mapping table
                        	$this->excel->getActiveSheet()->setCellValue('B3', 'No');
                        	$this->excel->getActiveSheet()->setCellValue('C3', 'theme Id');
                        	$this->excel->getActiveSheet()->setCellValue('D3', 'Sequence');
                        	$this->excel->getActiveSheet()->setCellValue('E3', 'Code');
                        	$this->excel->getActiveSheet()->setCellValue('F3', 'Note');

                        	$this->excel->getActiveSheet()->setCellValue('G3', 'isDefault');
                        	$this->excel->getActiveSheet()->setCellValue('H3', 'isNew');
                        	$this->excel->getActiveSheet()->setCellValue('I3', 'isDraft');
                        	$this->excel->getActiveSheet()->setCellValue('J3', 'isUpdate');
                        	$this->excel->getActiveSheet()->setCellValue('K3', 'isDelete');
                        	$this->excel->getActiveSheet()->setCellValue('L3', 'isActive');
                        	$this->excel->getActiveSheet()->setCellValue('M3', 'isApproved');
                        	$this->excel->getActiveSheet()->setCellValue('N3', 'By');
                        	$this->excel->getActiveSheet()->setCellValue('O3', 'Time');


                        } else {
                        	$this->excel->getActiveSheet()->setCellValue('B3', 'No');
                        	$this->excel->getActiveSheet()->setCellValue('C3', 'Sequence');
                        	$this->excel->getActiveSheet()->setCellValue('D3', 'Code');
                        	$this->excel->getActiveSheet()->setCellValue('E3', 'Note');
                        }
                        // fill color
                        $this->excel->getActiveSheet()->getStyle($start.'2:'.$end.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $this->excel->getActiveSheet()->getStyle($start.'2:'.$end.'2')->getFill()->getStartColor()->setARGB('66BBFF');
                        $this->excel->getActiveSheet()->getStyle($start.'3:'.$end.'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $this->excel->getActiveSheet()->getStyle($start.'3:'.$end.'3')->getFill()->getStartColor()->setARGB('66BBFF');
                        //
                        $loopRow = 4;
                        $i       = 0;
                        while ($row = $this->q->fetchAssoc()) {
                        	//	echo print_r($row);
                        	$this->excel->getActiveSheet()->setCellValue('B' . $loopRow, ++$i);
                        	if($this->isAdmin==1){
                        		$this->excel->getActiveSheet()->setCellValue('C' . $loopRow,$row['themeId']);
                        		$this->excel->getActiveSheet()->setCellValue('D' . $loopRow,$row['themeSequence']);
                        		$this->excel->getActiveSheet()->setCellValue('E' . $loopRow,$row['themeCode']);
                        		$this->excel->getActiveSheet()->setCellValue('F' . $loopRow,$row['themeNote']);

                        		$this->excel->getActiveSheet()->setCellValue('G' . $loopRow,$row['isDefault']);
                        		$this->excel->getActiveSheet()->setCellValue('H' . $loopRow,$row['isNew']);
                        		$this->excel->getActiveSheet()->setCellValue('I' . $loopRow,$row['isDraft']);
                        		$this->excel->getActiveSheet()->setCellValue('J' . $loopRow,$row['isUpdate']);
                        		$this->excel->getActiveSheet()->setCellValue('K' . $loopRow,$row['isDelete']);
                        		$this->excel->getActiveSheet()->setCellValue('L' . $loopRow,$row['isActive']);
                        		$this->excel->getActiveSheet()->setCellValue('M' . $loopRow,$row['isApproved']);
                        		$this->excel->getActiveSheet()->setCellValue('N' . $loopRow,$row['staffName']);
                        		$this->excel->getActiveSheet()->setCellValue('O' . $loopRow,$row['Time']);
                        	} else {

                        		$this->excel->getActiveSheet()->setCellValue('C' . $loopRow,$row['themeSequence']);
                        		$this->excel->getActiveSheet()->setCellValue('D' . $loopRow,$row['themeCode']);
                        		$this->excel->getActiveSheet()->setCellValue('E' . $loopRow,$row['themeNote']);
                        	}
                        	$loopRow++;

                        }

                        $lastRow = $end . $loopRow;

                        $from    = $start.'2';
                        $to      = $lastRow;
                        $formula = $from . ":" . $to;
                        $this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
                        $filename  = "theme" . rand(0, 10000000) . ".xlsx";
                        $path      = $_SERVER['DOCUMENT_ROOT'] . $this->getApplication() . "/management/document/excel/" . $filename;

                        $this->documentTrail->setDocumentPath($path);
                        $this->documentTrail->setDocumentFilename($filename);
                        $this->documentTrail->create();

                        $objWriter->save($path);
                        $file = fopen($path, 'r');
                        if ($file) {
                        	echo json_encode(array(
                "success" => true,
                "message" => "File generated",
                "filename" => $filename
                        	));
                        	exit();
                        } else {
                        	echo json_encode(array(
                "success" => false,
                "message" => "File not generated"
                ));
                exit();
                        }
	}




}


$themeObject  	= 	new themeClass();

/**
 *	crud -create,read,update,delete
 **/
if(isset($_POST['method']))	{
	/*
	 *  Initilize Value before load in the loader
	 */

	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_POST['leafId'])){
		$themeObject->setLeafId($_POST['leafId']);
	}
	/*
	 *  Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$themeObject->setIsAdmin($_POST['isAdmin']);
	}
	/*
	 *  Paging
	 */
	if(isset($_POST['start'])){
		$themeObject->setStart($_POST['start']);
	}
	if(isset($_POST['limit'])){
		$themeObject->setLimit($_POST['perPage']);
	}
	/**
	 *  Filtering
	 */
	if(isset($_POST['query'])){
		$themeObject->setFieldQuery($_POST['query']);
	}
	if(isset($_POST['filter'])){

		$themeObject->setGridQuery($_POST['filter']);
	}
	/**
	 * Ordering
	 */
	if(isset($_POST['order'])){
		$themeObject->setOrder($_POST['order']);
	}
	if(isset($_POST['sortField'])){
		$themeObject->setSortField($_POST['sortField']);
	}

	/*
	 *  Load the dynamic value
	 */
	$themeObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_POST['method']=='create') 	{
		$themeObject->create();
	}
	if($_POST['method']=='read') 	{
		$themeObject->read();
	}
	if($_POST['method']=='save') 	{
		$themeObject->update();
	}
	if($_POST['method']=='delete') 	{
		$themeObject->delete();
	}

}

if(isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_GET['leafId'])){
		$themeObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$themeObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$themeObject->execute();
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {
			$themeObject->staff();
		}
	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if($_GET['method']=='updateStatus'){
		$themeObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET['themeCode'])) {
		if (strlen($_GET['themeCode']) > 0) {
			$themeObject->duplicate();
		}
	}
	/*
	 *  Excel Reporing
	 */
	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {

			$themeObject->excel();
		}
	}
}

?>
