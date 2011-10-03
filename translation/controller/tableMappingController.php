<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/tableMappingModel.php");

/**
 * this tableMapping menu creation
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Translation
 * @subpackage tableMapping
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class TableMappingClass extends  ConfigClass {
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
	 * Common class function for security menu
	 * @var  string 
	 */
	private $security;
	
	/**
	 * Class Loader
	 */
	function execute() {
		parent :: __construct();

		$this->q 					=	new Vendor();

		$this->q->vendor			=	$this->getVendor();

		$this->q->leafId			=	$this->getLeafId();

		$this->q->staffId			=	$this->getStaffId();

		$this->q->fieldQuery 		= 	$this->getFieldQuery();

		$this->q->gridQuery			=	$this->getGridQuery();

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;

		$this->log					=   0;

		$this->q->log 				= $this->log;

		$this->defaultLanguageId  	= 21;

		$this->security 	= 	new Security();
		$this->security->setVendor($this->getVendor());
		$this->security->setLeafId($this->getLeafId());
		$this->security->execute();

		$this->model = new TableMappingModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

		$this->documentTrail = new DocumentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->execute();



	}

	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create() 							{
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
			INSERT INTO `tableMapping`
					(
						`moduleId`,							`iconId`,
						`tableMappingSequence`,					`tableMappingCode`,
						`tableMappingPath`,						`tableMappingNote`,
						`isDefault`,						`isNew`,
						`isDraft`,							`isUpdate`,
						`isDelete`,							`isActive`,
						`isApproved`,						`executeBy`,
						`executeTime`
					)
			VALUES
					(
						\"".$this->model->getModuleId()."\",						\"".$this->model->getIconId()."\",
						\"".$this->model->gettableMappingSequence()."\", 				\"".$this->model->gettableMappingCode()."\",
						\"".$this->model->gettableMappingPath()."\"	,				\"".$this->model->gettableMappingNote()."\",
						\"".$this->model->getIsDefault(0,'single')."\",		\"" . $this->model->getIsNew(0,'single') . "\",
						\"" . $this->model->getIsDraft(0,'single') . "\",		\"" . $this->model->getIsUpdate(0,'single') . "\",
						\"" . $this->model->getIsDelete(0,'single') . "\",		\"" . $this->model->getIsActive(0,'single') . "\",
						\"" . $this->model->getIsApproved(0,'single') . "\",	\"" . $this->model->getExecuteBy() . "\",
						" . $this->model->getExecuteTime() . "


					);";
		}else if ($this->getVendor()==self::mssql) {
			$sql="
			INSERT INTO [tableMapping]
					(
						[moduleId],							[iconId],
						[tableMappingSequence],					[tableMappingCode],
						[tableMappingPath],						[tableMappingNote],
						[isDefault],						[isNew],
						[isDraft],							[isUpdate],
						[isDelete],							[isActive],
						[isApproved],						[executeBy],
						[executeTime]
				)
			VALUES
				(
						'".$this->model->getModuleId()."',						'".$this->model->getIconId()."',
						'".$this->model->gettableMappingSequence()."', 				'".$this->model->gettableMappingCode()."',
						'".$this->model->gettableMappingPath()."'	,				'".$this->model->gettableMappingNote()."',
						'".$this->model->getIsDefault(0,'single')."',		'" . $this->model->getIsNew(0,'single') . "',
						'" . $this->model->getIsDraft(0,'single') . "',		'" . $this->model->getIsUpdate(0,'single') . "',
						'" . $this->model->getIsDelete(0,'single') . "',		'" . $this->model->getIsActive(0,'single') . "',
						'" . $this->model->getIsApproved(0,'single') . "',	'" . $this->model->getExecuteBy() . "',
						" . $this->model->getExecuteTime() . "

					);";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
			INSERT INTO 	TABLEMAPPING
						(
							MODULEID,							ICONID,
							TABLEMAPPINGSEQUENCE,			TABLEMAPPINNGCODE,
							TABLEMAPPINGPATH,				TABLEMAPPINGNOTE,
							ISDEFAULT,						ISNEW,
							ISDRAFT,						ISUPDATE,
							ISDELETE,						ISACTIVE,
							ISAPPROVED,						EXECUTEBY,
							EXECUTETIME
				VALUES	(
							'".$this->model->getModuleId()."',						'".$this->model->getIconId()."',
							'".$this->model->gettableMappingSequence()."', 			'".$this->model->gettableMappingCode()."',
							'".$this->model->gettableMappingPath()."'	,			'".$this->model->gettableMappingNote()."',
							'".$this->model->getIsDefault(0,'single')."',			'" . $this->model->getIsNew(0,'single') . "',
							'" . $this->model->getIsDraft(0,'single') . "',			'" . $this->model->getIsUpdate(0,'single') . "',
							'" . $this->model->getIsDelete(0,'single') . "',		'" . $this->model->getIsActive(0,'single') . "',
							'" . $this->model->getIsApproved(0,'single') . "',		'" . $this->model->getExecuteBy() . "',
							" . $this->model->getExecuteTime() . "

					)";
		}
		$this->q->create($sql);
		if($this->q->execute=='fail') {
			echo json_encode(
			array(
					  	"success"	=>	false,

						"message"	=>	$this->q->responce
			));
			exit();
		}

		$lastId    = $this->q->lastInsertId();
		


		/**
		 *	 insert default value to detail tableMappingle .English only
		 **/
		if ($this->getVendor() == self::mysql) {
			$sql = "
				 	INSERT INTO `tableMapping`
				 		(
						 	`tableMappingId`,
						 	`languageId`,
							`tableMappingTranslate`
						) VALUES (
							\"" . $lastId . "\",
							21,
							\"" . $this->model->gettableMappingNote() . "\"
						);";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
				 	INSERT INTO  [tableMapping]
							(
							 	[tableMappingId],
								[languageId],
								[tableMappingTranslate]
							) VALUES (
								'" . $lastId . "',
								21,
								'" .  $this->model->gettableMappingNote() . "'
							);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
				 	INSERT INTO	TABLEMAPPING
							(
							 	TABLEMAPPINGID,
								LANGUAGEID,
								TABLEMAPPINGTRANSLATE
							) VALUES (
								'" . $lastId . "',
								21,
								'" .  $this->model->gettableMappingNote() . "'
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
		echo json_encode(array("success"=>true,"tableMappingId"=>$lastId,"message"=>"Record Created"));
		exit();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() 							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->isAdmin == 0) {
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	`tableMapping`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[tableMapping].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	TABLEMAPPING.ISACTIVE	=	1	";
			}
		} else if($this->isAdmin ==1) {
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	 1 = 1 ";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	1 = 1 ";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = " 1 = 1 ";
			}
		}
		//UTF8
		$items=array();
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		// everything given flexibility  on todo
		if($this->getVendor() == self::mysql) {
			$sql="
			SELECT 		*
			FROM 		`tableMapping`
			WHERE		`tableMapping`.`isActive`		=	1";
			if($this->model->gettableMappingId(0,'single')) {
				$sql.=" AND `".$this->model->getTableName()."`.`".$this->model->getPrimaryKeyName()."`=\"".$this->model->gettableMappingId(0,'single')."\"";
			}
		} else if ($this->getVendor()==self::mssql) {
			$sql	=	"
			SELECT 		*
			FROM 		[tableMapping]
			WHERE		[tableMapping].[isActive]		=	1";
			if($this->model->gettableMappingId(0,'single')) {
				$sql.=" AND [".$this->model->getTableName()."].[".$this->model->getPrimaryKeyName()."]='".$this->model->gettableMappingId(0,'single')."'";
			}
		} else if ($this->getVendor()==self::oracle) {
			$sql	=	"
			SELECT 		*
			FROM 		TABLEMAPPING
			WHERE		TABLEMAPPING.ISACTIVE=1";
			if($this->model->gettableMappingId(0,'single')) {
				$sql.=" AND ".strtoupper($this->model->getTableName()).".".strtoupper($this->model->getPrimaryKeyName())."='".$this->model->gettableMappingId(0,'single')."'";
			}
		}
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		$filterArray =array('moduleId','tabTranslateId','tableMappingId','tableMappingTranslateId');
		/**
		 *	filter table
		 * @variables $tableArray
		 */
		$tableArray = array('tab','tabTranslate','tableMapping','tableMappingTranslate');

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
		//echo $sql;
		$this->q->read($sql);
		if($this->q->redirect=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		$total	= $this->q->numberRows();

		if ($this->getOrder() && $this->getSortField()) {
			if ($this->getVendor() == self::mysql) {
				$sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder(). " ";
			} else if ($this->getVendor() ==  self::mssql) {
				$sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::oracle) {
				$sql .= "	ORDER BY " . strtoupper($this->getSortField()) . "  " . strtoupper($this->getOrder()). " ";
			}
		}
		$_SESSION['sql']	=	$sql; // push to session so can make report via excel and pdf
		$_SESSION['start'] 	= 	$this->getStart();
		$_SESSION['limit'] 	= 	$_POST['limit'];

		if(empty($_POST['filter']))      {

			if(isset($this->getStart()) && isset($_POST['limit'])) {
				// only mysql have limit

				if($this->getVendor() == self::mysql) {
					$sql.=" LIMIT  ".$this->getStart().",".$_POST['limit']." ";
					$sqlLimit = $sql;
				} else if ($this->getVendor()==self::mssql) {
					/**
					 *	 Sql Server and Oracle used row_number
					 *	 Parameterize Query We don't support
					 */
					$sqlLimit="
							WITH [tableMappingDerived] AS
							(
								SELECT	*,
								[tableMapping].[executeBy],
								[tableMapping].[executeTime]
								ROW_NUMBER() OVER (ORDER BY [tableMappingId]) AS 'RowNumber'
								FROM 		[tableMapping]

								JOIN 		[tab]
								ON			[tab].[moduleId` = `tableMapping`.`moduleId`

								LEFT JOIN	[icon]
								ON			[tableMapping].[iconId]=[icon].[iconId]
								WHERE		[tab].[isActive]	=	1
								AND			[tableMapping].[isActive]		=	1  ".$tempSql.$tempSql2."
							)
							SELECT		*
							FROM 		[tableMappingDerived]
							WHERE 		[RowNumber]
							BETWEEN	".$this->getStart()."
							AND 			".($this->getStart()+$_POST['limit']-1).";";


				}  else if ($this->getVendor()==self::oracle) {
					/**
					 *  Oracle using derived table also
					 */


					$sql="
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT 		*,
												TABLEMAPPING.EXECUTEBY,
												TABLEMAPPING.EXECUTETIME
									FROM 		TABLEMAPPING
									JOIN		TABLEMAPPINGTRANSLATE
									ON			TABLEMAPPING.TABLEMAPPINGID	=TABLEMAPPINGTRANSLATE.TABLEMAPPINGID
									JOIN 		\"tab\"
									ON			\"tab\".\"moduleId\" = TABLEMAPPING.\"moduleId\"
									JOIN		\"tabTranslate\"
									ON			\"tab\".\"moduleId\"=	\"tabTranslate\".\"moduleId\"
									AND			\"tabTranslate\".\"moduleId\" =TABLEMAPPING.\"moduleId\"
									LEFT JOIN	ICON
									ON			TABLEMAPPING.ICONID=ICON.ICONID
									WHERE		\"tab\".ISACTIVE=1
									AND			TABLEMAPPING.ISACTIVE=1 ".$tempSql.$tempSql2."
								 ) a
						WHERE rownum <= '".($this->getStart()+$this->getLimit()-1)."' )
						where r >=  '".$this->getStart()."'";

				} else {
					echo "undefine vendor";
				}
			}
		}

		/*
		 *  Only Execute One Query
		 */
		if(!($this->tableMappingId)) {

			$this->q->read($sql);
			if($this->q->execute=='fail') {
				echo json_encode(
				array(
					  	"success"	=>	false,
						"message"	=>	$this->q->responce
				));
				exit();
			}
		}
		$items 			= 	array();
		while(($row  	= 	$this->q->fetchAssoc()) == true) {
			$items[]	=	$row;
		}



		if($this->tableMappingId) {
			$json_encode = json_encode(
			array(
						'success'	=>	true,
						'total' 	=> 	$total,
						'data' 		=> 	$items
			));
			$json_encode=str_replace("[","",$json_encode);
			$json_encode=str_replace("]","",$json_encode);
			echo $json_encode;
		} else {
			if(count($items)==0) {
				$items='';
			}
			echo json_encode(
			array(
											'success'	=>	true,
											'total' 	=> 	$total,
											'data' 		=> 	$items
			)
			);
			exit();
		}



	}



	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() 							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->update();
		if($this->getVendor() == self::mysql) {
			$sql="
					UPDATE 	`tableMapping`
					SET 	`moduleId`				=	\"".$this->model->getmoduleId()."\",
							`tableMappingNote`		=	\"".$this->model->gettableMappingNote()."\",
							`tableMappingSequence`	=	\"".$this->model->gettableMappingSequence()."\",
							`tableMappingCode`		=	\"".$this->model->gettableMappingCode()."\",
							`tableMappingPath`		=	\"".$this->model->gettableMappingPath()."\",
							`iconId`			=	\"".$this->model->getIconId()."\",
							`isDefault`			=	\"".$this->model->getIsDefault(0,'single')."\",
							`isActive`			=	\"".$this->model->getIsActive(0,'single')."\",
							`isNew`				=	\"".$this->model->getIsNew(0,'single')."\",
							`isDraft`			=	\"".$this->model->getIsDraft(0,'single')."\",
							`isUpdate`			=	\"".$this->model->getIsUpdate(0,'single')."\",
							`isDelete`			=	\"".$this->model->getIsDelete(0,'single')."\",
							`isApproved`		=	\"".$this->model->getIsApproved(0,'single')."\",
							`executeBy`				=	\"".$this->model->getExecuteBy()."\",
							`executeTime`				=	".$this->model->getExecuteTime()."
					WHERE 	`tableMappingId`			=	\"".$this->model->gettableMappingId(0,'single')."\"";
		}  else if ( $this->getVendor()==self::mssql) {
			$sql="
					UPDATE 	[tableMapping]
					SET 	[moduleId]		=	'".$this->model->getmoduleId()."',
							[tableMappingNote]		=	'".$this->model->gettableMappingNote()."',
							[tableMappingSequence]	=	'".$this->model->gettableMappingSequence()."',
							[tableMappingPath]		=	'".$this->model->gettableMappingPath()."',
							[iconId]			=	'".$this->strict($_POST['iconId'],'string')."',
							[isActive]			=	'".$this->model->getIsActive(0,'single')."',
							[isNew]				=	'".$this->model->getIsNew(0,'single')."',
							[isDraft]			=	'".$this->model->getIsDraft(0,'single')."',
							[isUpdate]			=	'".$this->model->getIsUpdate(0,'single')."',
							[isDelete]			=	'".$this->model->getIsDelete(0,'single')."',
							[isApproved]		=	'".$this->model->getIsApproved(0,'single')."',
							[executeBy]				=	'".$this->model->getExecuteBy()."',
							[executeTime]				=	".$this->model->getExecuteTime()."
					WHERE 	[tableMappingId]			=	'".$this->model->gettableMappingId(0,'single')."'";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
					UPDATE 	TABLEMAPPING
					SET 	\"moduleId\"		=	'".$this->model->getmoduleId()."',
							\"tableMappingNote\"		=	'".$this->model->gettableMappingNote()."',
							\"tableMappingSequence\"	=	'".$this->model->gettableMappingSequence()."',
							\"tableMappingPath\"		=	'".$this->model->gettableMappingPath()."',
							ISDEFAULT		=	'".$this->model->getIsDefault(0,'single')."',
							ISACTIVE		=	'".$this->model->getIsActive(0,'single')."',
							ISNEW			=	'".$this->model->getIsNew(0,'single')."',
							ISDRAFT			=	'".$this->model->getIsDraft(0,'single')."',
							ISUPDATE		=	'".$this->model->getIsUpdate(0,'single')."',
							ISDELETE		=	'".$this->model->getIsDelete(0,'single')."',
							ISAPPROVED		=	'".$this->model->getIsApproved(0,'single')."',
							EXECUTEBY				=	'".$this->model->getExecuteBy()."',
							EXECUTETIME			=	".$this->model->getExecuteTime()."
					WHERE 	TABLEMAPPINGID		=	'".$this->model->gettableMappingId(0,'single')."'";
		}
		$this->q->update($sql);
		if($this->q->redirect=='fail') {
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
	function delete()							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->delete();
		if($this->getVendor() == self::mysql) {
			$sql="
					UPDATE	`tableMapping`
					SET		`isDefault`		=	\"".$this->model->getIsDefault(0,'single')."\",
							`isActive`		=	\"".$this->model->getIsActive(0,'single')."\",
							`isNew`			=	\"".$this->model->getIsNew(0,'single')."\",
							`isDraft`		=	\"".$this->model->getIsDraft(0,'single')."\",
							`isUpdate`		=	\"".$this->model->getIsUpdate(0,'single')."\",
							`isDelete`		=	\"".$this->model->getIsDelete(0,'single')."\",
							`isApproved`	=	\"".$this->model->getIsApproved(0,'single')."\",
							`executeBy`			=	\"".$this->model->getExecuteBy()."\",
							`executeTime`			=	".$this->model->getExecuteTime()."
					WHERE 	`tableMappingId`		=	\"".$this->model->gettableMappingId()."\"";

		} else if ($this->getVendor()==self::mssql) {
			$sql="
					UPDATE	[tableMapping]
					SET		[isDefault]		=	'".$this->model->getIsDefault(0,'single')."',
							[isActive]		=	'".$this->model->getIsActive(0,'single')."',
							[isNew]			=	'".$this->model->getIsNew(0,'single')."',
							[isDraft]		=	'".$this->model->getIsDraft(0,'single')."',
							[isUpdate]		=	'".$this->model->getIsUpdate(0,'single')."',
							[isDelete]		=	'".$this->model->getIsDelete(0,'single')."',
							[isApproved]	=	'".$this->model->getIsApproved(0,'single')."',
							[executeBy]			=	'".$this->model->getExecuteBy()."',
							[executeTime]			=	".$this->model->getExecuteTime()."
					WHERE 	[tableMappingId]		=	'".$this->model->gettableMappingId()."'";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
					UPDATE	TABLEMAPPING
					SET		ISDEFAULT	=	'".$this->model->getIsDefault(0,'single')."',
							ISACTIVE	=	'".$this->model->getIsActive(0,'single')."',
							ISNEW		=	'".$this->model->getIsNew(0,'single')."',
							ISDRAFT		=	'".$this->model->getIsDraft(0,'single')."',
							ISUPDATE	=	'".$this->model->getIsUpdate(0,'single')."',
							ISDELETE	=	'".$this->model->getIsDelete(0,'single')."',
							ISAPPROVED	=	'".$this->model->getIsApproved(0,'single')."',
							EXECUTEBY			=	'".$this->model->getExecuteBy()."',
							EXECUTETIME		=	".$this->model->getExecuteTime()."
					WHERE 	TABLEMAPPINGID	=	'".$this->model->gettableMappingId()."'";
		}
		$this->q->update($sql);
		if($this->q->redirect=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success"=>"true","message"=>"Record Removed"));
		exit();


	}

	
 
	function excel() {
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		if($_SESSION['start']==0) {
			$sql=str_replace("LIMIT","",$_SESSION['sql']);
			$sql=str_replace($_SESSION['start'].",".$_SESSION['limit'],"",$sql);
		} else {
			$sql=$_SESSION['sql'];
		}
		$this->q->read($sql);

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
		$this->excel->getActiveSheet()->setCellValue('B2',$this->title);
		$this->excel->getActiveSheet()->setCellValue('D2','');
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->setCellValue('B3','No');
		$this->excel->getActiveSheet()->setCellValue('C3','tableMapping');
		$this->excel->getActiveSheet()->setCellValue('D3','Description');
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');

		//
		$loopRow=4;
		$i=0;
		while(($row  = 	$this->q->fetchAssoc()) == true) {


			$this->excel->getActiveSheet()->setCellValue('B'.$loopRow,++$i);
			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['tableMappingNote']);
			$loopRow++;
			$lastRow='D'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="tableMapping".rand(0,10000000).".xlsx";
		$path=$_SERVER['DOCUMENT_ROOT']."/".$this->application."/security/document/excel/".$filename;
		$objWriter->save($path);
		$this->audit->create_trail($this->leafId, $path,$filename);
		$file = fopen($path,'r');
		if($file){
			echo json_encode(array("success"=>"true","message"=>"File generated"));
		} else {
			echo json_encode(array("success"=>"false","message"=>"File not generated"));

		}
	}




}

$tableMappingObject  	= 	new tableMappingClass();

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
		$tableMappingObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$tableMappingObject->setIsAdmin($_POST['isAdmin']);
	}

	/*
	 *  Filtering
	 */

	if(isset($_POST['query'])){
		$tableMappingObject->setFieldQuery($_POST['query']);
	}
	if(isset($_POST['filter'])){
		$tableMappingObject->setGridQuery($_POST['filter']);
	}
	/*
	 * Ordering
	 */
	if(isset($_POST['order'])){
		$tableMappingObject->setOrder($_POST['order']);
	}
	if(isset($_POST['sortField'])){
		$tableMappingObject->setSortField($_POST['sortField']);
	}

	/*
	 *  Load the dynamic value
	 */
	$tableMappingObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_POST['method']=='create')	{
		$tableMappingObject->create();
	}
	if($_POST['method']=='read') 	{

		$tableMappingObject->read();

	}

	if($_POST['method']=='save') 	{

		$tableMappingObject->update();

	}
	if($_POST['method']=='delete') 	{
		$tableMappingObject->delete();
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
		$tableMappingObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$tableMappingObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$tableMappingObject->execute();
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {

			$tableMappingObject->staff();
		}
		if($_GET['field']=='moduleId'){
			$tableMappingObject->module();
		}

	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if($_GET['method']=='updateStatus'){
		$tableMappingObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET['tableMappingCode'])) {
		if (strlen($_GET['tableMappingCode']) > 0) {
			$tableMappingObject->duplicate();
		}
	}
	/*
	 *  Excel Reporting
	 */
	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$tableMappingObject->excel();
		}
	}

}


?>

