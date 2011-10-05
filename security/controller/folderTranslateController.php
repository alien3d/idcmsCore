<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/folderModel.php");

/**
 * Folder Translation
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package folder
 * @subpackage Folder Translation Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class FolderTranslateClass extends  ConfigClass {
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
	 * Folder Translation Identification
	 * @var  numeric $folderTranslateId
	 */
	public $folderTranslateId;
	/**
	 * Translation update
	 * @var string $folderTranslate
	 */
	public $folderTranslate;
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
		$this->security->vendor = $this->getVendor();
		$this->security->leafId = $this->getLeafId();
		$this->security->execute();

		$this->model = new FolderModel();
		$this->model->vendor = $this->getVendor();
		$this->model->execute();
		$this->documentTrail = new DocumentTrailClass();


	}

	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create() 							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->create();
		if($this->getVendor() == self::MYSQL) {
			$sql="
			INSERT INTO `folder`
					(
						`tabId`,						`folderNote`,
						`folderSequence`,					`folderPath`,
						`iconId`,							`isNew`,
						`isDraft`,							`isUpdate`,
						`isDelete`,							`isActive`,
						`isApproved`,						`executeBy`,
						`executeTime`
					)
			VALUES
					(
						\"".$this->model->tabId."\",	\"".$this->model->folderNote."\",
						\"".$this->model->folderSequence."\", \"".$this->model->folderPath."\",
						\"".$this->model->iconId."\",			\"".$this->model->getIsNew(0,'single')."\",
						\"".$this->model->getIsDraft(0,'single')."\",		\"".$this->model->getIsUpdate(0,'single')."\",
						\"".$this->model->getIsDelete(0,'single')."\",		\"".$this->model->getIsActive(0,'single')."\",
						\"".$this->model->getIsApproved(0,'single')."\",		\"".$this->model->getIsApproved(0,'single')."\",
						".$this->model->getExecuteTime()."
					);";
		}else if ($this->getVendor()==self::MSSQL) {
			$sql="
			INSERT INTO [folder]
					(
						[tabId],						[folderNote],
						[folderSequence],					[folderPath],
						[iconId],							[isNew],
						[isDraft],							[isUpdate],
						[isDelete],							[isActive],
						[isApproved],						[executeBy],
						[executeTime]
				)
			VALUES
				(
						'".$this->model->tabId."\",	\"".$this->model->folderNote."\",
						'".$this->model->folderSequence."\", \"".$this->model->folderPath."\",
						'".$this->model->iconId."',			\"".$this->model->getIsNew(0,'single')."\",
						'".$this->model->getIsDraft(0,'single')."',		\"".$this->model->getIsUpdate(0,'single')."\",
						'".$this->model->getIsDelete(0,'single')."',		\"".$this->model->getIsActive(0,'single')."\",
						'".$this->model->getIsApproved(0,'single')."',		\"".$this->model->getIsApproved(0,'single')."\",
						".$this->model->getExecuteTime()."
				);";
		} else if ($this->getVendor()==self::ORACLE) {
			$sql="
			INSERT INTO 	FOLDER
						(
							\"tabId\",					FOLDERNOTE,
							FOLDERSEQUENCE,					FOLDERPATH,
							 ICONID,				 		ISNEW,
							ISDRAFT,						ISUPDATE,
							ISDELETE,						ISACTIVE,
							ISAPPROVED,						EXECUTEBY,
							EXECUTETIME)
				VALUES	(
							\"".$this->model->tabId."\",	\"".$this->model->folderNote."\",
							\"".$this->model->folderSequence."\", \"".$this->model->folderPath."\",
							\"".$this->model->iconId."\",			\"".$this->model->getIsNew(0,'single')."\",
							\"".$this->model->getIsDraft(0,'single')."\",		\"".$this->model->getIsUpdate(0,'single')."\",
							\"".$this->model->getIsDelete(0,'single')."\",		\"".$this->model->getIsActive(0,'single')."\",
							\"".$this->model->getIsApproved(0,'single')."\",		\"".$this->model->getIsApproved(0,'single')."\",
							".$this->model->getExecuteTime()."
						);";
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
		if($this->q->vendor	==	'normal' || $this->q->vendor	==	'mysql' ) {
			/*
			 * 	If anything wrong use this instead  SELECT LAST_INSERT_ID();
			 **/
			$sql="
			SELECT MAX(`folderId`)	AS `lastId`
			FROM `folder` ";
		} else if ($this->q->vendor	==	'microsoft') {
			/*
			 *  If anything wrong use this insert SELECT @@IDENTITY
			 **/
			$sql="
			SELECT MAX([folderId]) AS [lastId] FROM [folder] ";
		} else if ( $this->q->vendor	==	'oracle') {
			/**
			 *  If anthing wrong use this instead  SELECT tabIdSeq
			 */
			$sql="
			SELECT MAX(FOLDERID) AS \"lastId\"
			FROM 	FOLDER";
		}

		$resultd =$this->q->fast($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}

		$rowLastId= $this->q->fetchAssoc($resultd);
		$lastId = $rowLastId['lastId'];

		//  create a record  in tabAccess.update no effect
		// loop the group
		if($this->getVendor() == self::MYSQL) {
			$sql="SELECT * FROM `group` WHERE `isActive`=1 ";
		} else if ($this->getVendor()==self::MSSQL) {
			$sql="SELECT * FROM [group] WHERE [isActive]=1 ";
		} else if ($this->getVendor()==self::ORACLE) {
			$sql="SELECT * FROM GROUP_ WHERE ISACTIVE=1 ";
		}
		$this->q->read($sql);
		$data = $this->q->activeRecord();
		foreach ($data as $row ) {
			// by default no access
			if($this->getVendor() == self::MYSQL) {
				$sql="
				INSERT INTO	`folderAccess`
						(
							`folderId`,
							`groupId`,
							`folderAccessValue`
						)
				VALUES
						(
							\"".$lastId."\",
							 \"".$row['groupId']."\",
							 '0'
						)	";
			} else if ($this->getVendor()==self::MSSQL) {
				$sql="
				INSERT INTO 	[folderAccess]
							(
								[folderId],
								[groupId],
								[folderAccessValue]
							)
				VALUES
							(
								\"".$lastId."\",
							 	\"".$row['groupId']."\",
							 	'0'
							 )	";
			} else if ($this->getVendor()==self::ORACLE) {
				$sql="
				INSERT INTO 	FOLDERACCESS
							(
								FOLDERID,
								GROUPID,
								FOLDERACCESSVALUE
							)
					VALUES
							(
								\"".$lastId."\",
							 	\"".$row['groupId']."\",
							 	'0'
							 )	";
			}
			$this->q->update($sql);
			if($this->q->execute=='fail') {
				echo json_encode(array("success"=>false,"message"=>$this->q->responce));
				exit();
			}
		}

		$this->q->commit();
		echo json_encode(array("success"=>true,"folderId"=>$lastId,"message"=>"Record Created"));
		exit();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() 							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		// everything given flexibility  on todo
		if($this->getVendor() == self::MYSQL) {
			$sql="
			SELECT 		*
			FROM 		`folder`
			JOIN 		`tab`
			ON			`tab`.`tabId` = `folder`.`tabId`
			LEFT JOIN	`icon`
			ON			`folder`.`iconId`=`icon`.`iconId`
			WHERE		`tab`.`isActive`	=	1
			AND			`folder`.`isActive`		=	1";
			if($this->folderId) {
				$sql.=" AND `folderId`=\"".$this->folderId."\"";
			}
		} else if ($this->getVendor()==self::MSSQL) {
			$sql	=	"
			SELECT 		*
			FROM 		[folder]
			JOIN		[folderTranslate]
			JOIN 		[tab]
			ON			[tab].[tabId] = [folder].[tabId]
			LEFT JOIN	[icon]
			ON			[folder].[iconId]=[icon].[iconId]
			WHERE		[tab].[isActive]	=	1
			AND			[folder].[isActive]		=	1";
			if($this->folderId) {
				$sql.=" AND `folderId`=\"".$this->folderId."\"";
			}
		} else if ($this->getVendor()==self::ORACLE) {
			$sql	=	"
			SELECT 		*
			FROM 		FOLDER
			JOIN 		\"tab\"
			ON			\"tab\".\"tabId\" = FOLDER.\"tabId\"
			LEFT JOIN	ICON
			USING(ICONID)
			WHERE		\"tab\".ISACTIVE=1
			AND			FOLDER.ISACTIVE=1";
			if($this->folderId) {
				$sql.=" AND FOLDERID=\"".$this->folderId."\"";
			}
		}
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		$filterArray =array('tabId','tabTranslateId','folderId','folderTranslateId');
		/**
		 *	filter table
		 * @variables $tableArray
		 */
		$tableArray = array('accordian','tabTranslate','folder','folderTranslate');

		if(isset($_GET['query'])) {
			$query = $_GET['query'];
		}  else if (isset($_POST['query'])) {
			$query = $_POST['query'];
		}
		if(isset($query)) {
			if($this->getVendor() == self::MYSQL) {
				$sql.=$this->q->quickSearch($tableArray,$filterArray);
			} else if ($this->getVendor()==self::MSSQL) {
				$tempSql=$this->q->quickSearch($tableArray,$filterArray);
				$sql.=$tempSql;
			} else if ($this->getVendor()==self::ORACLE) {
				$tempSql=$this->q->quickSearch($tableArray,$filterArray);
				$sql.=$tempSql;
			}
		}
		/**
		 *	Extjs filtering mode
		 */
		if($this->getVendor() == self::MYSQL) {

			$sql.=$this->q->searching();
		} else if ($this->getVendor()==self::MSSQL) {
			$tempSql2=$this->q->searching();
			$sql.=$tempSql2;
		}else if ($this->getVendor()==self::ORACLE) {
			$tempSql2=$this->q->searching();
			$sql.=$tempSql2;
		}
		//echo $sql;
		$this->q->read($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		$total	= $this->q->numberRows();

		if($this->order && $this->sortField){
			if($this->q->vendor==self::MYSQL || $this->q->vendor=='normal') {
				$sql.="	ORDER BY `".$sortField."` ".$dir." ";
			} else if ($this->getVendor()==self::MSSQL) {
				$sql.="	ORDER BY [".$sortField."] ".$dir." ";
			} else if ($this->getVendor()==self::ORACLE) {
				$sql.="	ORDER BY \"".$sortField."\"  ".$dir." ";
			}
		}
		$_SESSION['sql']	=	$sql; // push to session so can make report via excel and pdf
		$_SESSION['start'] 	= 	$this->getStart();
		$_SESSION['limit'] 	= 	$_POST['limit'];

		if(empty($_POST['filter']))      {

			if(isset($this->getStart()) && isset($_POST['limit'])) {
				// only mysql have limit

				if($this->getVendor() == self::MYSQL) {
					$sql.=" LIMIT  ".$this->getStart().",".$_POST['limit']." ";
					$sqlLimit = $sql;
				} else if ($this->getVendor()==self::MSSQL) {
					/**
					 *	 Sql Server and Oracle used row_number
					 *	 Parameterize Query We don't support
					 */
					$sqlLimit="
							WITH [folderDerived] AS
							(
								SELECT	*,
								[folder].[executeBy],
								[folder].[executeTime]
								ROW_NUMBER() OVER (ORDER BY [folderId]) AS 'RowNumber'
								FROM 		[folder]

								JOIN 		[tab]
								ON			[tab].[tabId` = `folder`.`tabId`

								LEFT JOIN	[icon]
								ON			[folder].[iconId]=[icon].[iconId]
								WHERE		[tab].[isActive]	=	1
								AND			[folder].[isActive]		=	1  ".$tempSql.$tempSql2."
							)
							SELECT		*
							FROM 		[folderDerived]
							WHERE 		[RowNumber]
							BETWEEN	".$this->getStart()."
							AND 			".($this->getStart()+$_POST['limit']-1).";";


				}  else if ($this->getVendor()==self::ORACLE) {
					/**
					 *  Oracle using derived table also
					 */


					$sql="
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT 		*,
												FOLDER.EXECUTEBY,
												FOLDER.EXECUTETIME
									FROM 		FOLDER
									JOIN		\"folderTranslate\"
									ON			FOLDER.FOLDERID	=\"folderTranslate\".FOLDERID
									JOIN 		\"tab\"
									ON			\"tab\".\"tabId\" = FOLDER.\"tabId\"
									JOIN		\"tabTranslate\"
									ON			\"tab\".\"tabId\"=	\"tabTranslate\".\"tabId\"
									AND			\"tabTranslate\".\"tabId\" =FOLDER.\"tabId\"
									LEFT JOIN	ICON
									ON			FOLDER.ICONID=ICON.ICONID
									WHERE		\"tab\".ISACTIVE=1
									AND			FOLDER.ISACTIVE=1 ".$tempSql.$tempSql2."
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
		if(!($this->folderId)) {

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
		while(($row  	= 	$this->q->fetchAssoc()) == TRUE) {
			$items[]	=	$row;
		}



		if($this->folderId) {
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
		if($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->update();
		if($this->getVendor() == self::MYSQL) {
			$sql="
					UPDATE 	`folder`
					SET 	`tabId`				=	\"".$this->model->getTabId()."\",
							`folderNote`		=	\"".$this->model->getfolderNote()."\",
							`folderSequence`	=	\"".$this->model->getfolderSequence()."\",
							`folderPath`		=	\"".$this->model->getfolderPath()."\",
							`iconId`			=	\"".$this->model->getIconId()."\",
							`isActive`			=	\"".$this->model->getIsActive(0,'single')."\",
							`isNew`				=	\"".$this->model->getIsNew(0,'single')."\",
							`isDraft`			=	\"".$this->model->getIsDraft(0,'single')."\",
							`isUpdate`			=	\"".$this->model->getIsUpdate(0,'single')."\",
							`isDelete`			=	\"".$this->model->getIsDelete(0,'single')."\",
							`isApproved`		=	\"".$this->model->getIsApproved(0,'single')."\",
							`executeBy`				=	\"".$this->model->getExecuteBy()."\",
							`Time				=	".$this->model->getExecuteTime()."
					WHERE 	`folderId`			=	\"".$this->model->getFolderId()."\"";
		}  else if ( $this->getVendor()==self::MSSQL) {
			$sql="
					UPDATE 	[folder]
					SET 	[tabId]		=	\"".$this->model->getTabId()."\",
							[folderNote]		=	\"".$this->model->getfolderNote()."\",
							[folderSequence]	=	\"".$this->model->getfolderSequence()."\",
							[folderPath]		=	\"".$this->model->getfolderPath()."\",
							[iconId]			=	\"".$this->strict($_POST['iconId'],'string')."\",
							[isActive]			=	\"".$this->model->getIsActive(0,'single')."\",
							[isNew]				=	\"".$this->model->getIsNew(0,'single')."\",
							[isDraft]			=	\"".$this->model->getIsDraft(0,'single')."\",
							[isUpdate]			=	\"".$this->model->getIsUpdate(0,'single')."\",
							[isDelete]			=	\"".$this->model->getIsDelete(0,'single')."\",
							[isApproved]		=	\"".$this->model->getIsApproved(0,'single')."\",
							[executeBy]				=	\"".$this->model->getExecuteBy()."\",
							[executeTime]				=	".$this->model->getExecuteTime()."
					WHERE 	[folderId]			=	\"".$this->model->getFolderId()."\"";
		} else if ($this->getVendor()==self::ORACLE) {
			$sql="
					UPDATE 	FOLDER
					SET 	\"tabId\"		=	\"".$this->model->getTabId()."\",
							FOLDERNOTE		=	\"".$this->model->getfolderNote()."\",
							FOLDERSEQUENCE	=	\"".$this->model->getfolderSequence()."\",
							FOLDERPATH		=	\"".$this->model->getfolderPath()."\",
							ISACTIVE	=	\"".$this->model->getIsActive(0,'single')."\",
							ISNEW		=	\"".$this->model->getIsNew(0,'single')."\",
							ISDRAFT		=	\"".$this->model->getIsDraft(0,'single')."\",
							ISUPDATE	=	\"".$this->model->getIsUpdate(0,'single')."\",
							ISDELETE	=	\"".$this->model->getIsDelete(0,'single')."\",
							ISAPPROVED	=	\"".$this->model->getIsApproved(0,'single')."\",
							EXECUTEBY			=	\"".$this->model->getExecuteBy()."\",
							EXECUTETIME		=	".$this->model->getExecuteTime()."
					WHERE 	FOLDERID		=	\"".$this->model->getFolderId()."\"";
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
	function delete()							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::MYSQL) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->delete();
		if($this->getVendor() == self::MYSQL) {
			$sql="
					UPDATE	`folder`
					SET		`isActive`			=	\"".$this->model->getIsActive(0,'single')."\",
							`isNew`				=	\"".$this->model->getIsNew(0,'single')."\",
							`isDraft`			=	\"".$this->model->getIsDraft(0,'single')."\",
							`isUpdate`			=	\"".$this->model->getIsUpdate(0,'single')."\",
							`isDelete`			=	\"".$this->model->getIsDelete(0,'single')."\",
							`isApproved`		=	\"".$this->model->getIsApproved(0,'single')."\",
							`executeBy`				=	\"".$this->model->getExecuteBy()."\",
							`Time				=	".$this->model->getExecuteTime()."
					WHERE 	`folderId`	=	\"".$this->model->getFolderId()."\"";

		} else if ($this->getVendor()==self::MSSQL) {
			$sql="
					UPDATE	[folder]
					SET		[isActive]			=	\"".$this->model->getIsActive(0,'single')."\",
							[isNew]				=	\"".$this->model->getIsNew(0,'single')."\",
							[isDraft]			=	\"".$this->model->getIsDraft(0,'single')."\",
							[isUpdate]			=	\"".$this->model->getIsUpdate(0,'single')."\",
							[isDelete]			=	\"".$this->model->getIsDelete(0,'single')."\",
							[isApproved]		=	\"".$this->model->getIsApproved(0,'single')."\",
							[executeBy]				=	\"".$this->model->getExecuteBy()."\",
							[executeTime]				=	".$this->model->getExecuteTime()."
					WHERE 	[folderId]	=	\"".$this->model->getFolderId()."\"";
		} else if ($this->getVendor()==self::ORACLE) {
			$sql="
					UPDATE	FOLDER
					SET		ISACTIVE	=	\"".$this->model->getIsActive(0,'single')."\",
							ISNEW		=	\"".$this->model->getIsNew(0,'single')."\",
							ISDRAFT		=	\"".$this->model->getIsDraft(0,'single')."\",
							ISUPDATE	=	\"".$this->model->getIsUpdate(0,'single')."\",
							ISDELETE	=	\"".$this->model->getIsDelete(0,'single')."\",
							ISAPPROVED	=	\"".$this->model->getIsApproved(0,'single')."\",
							EXECUTEBY			=	\"".$this->model->getExecuteBy()."\",
							EXECUTETIME		=	".$this->model->getExecuteTime()."
					WHERE 	FOLDERID	=	\"".$this->model->getFolderId()."\"";
		}
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success"=>"true","message"=>"Record Removed"));
		exit();


	}

	/**
	 *  Read Record From tabTranslate Table
	 **/
	function translateRead() {
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::MYSQL) {
			/**
			 *	UTF 8
			 **/
			$sql	=	"SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		if( $this->q->vendor==self ::mysql){
			$sql="
			SELECT	*
			FROM 	`folderTranslate`
			JOIN 	`language`
			USING (`languageId`)
			WHERE	`folderTranslate`.`folderId`=\"".$this->model->getFolderId()."\"";
		} else if ($this->getVendor()==self::MSSQL){
			$sql="
			SELECT	*
			FROM 	[tabTranslate]
			JOIN 	[language]
			ON 		[folderTranslate].[languageId] =[language].[languageId]
			WHERE	[folderTranslate].[folderId]=\"".$this->model->getFolderId()."\"";
		} else if ($this->q->vendor=='oralce'){
			$sql="
			SELECT	*
			FROM 	\"folderTranslate\"
			JOIN 	LANGUAGE
			USING (LANGUAGEID)
			WHERE	\"folderTranslate\".FOLDERID=\"".$this->model->getFolderId()."\"";
		}
		$this->q->read($sql);
		$total =$this->q->numberRows();
		$items = array();
		while ($row = $this->q->fetchAssoc()){
			$items[]= $row;
		}
		echo json_encode(
		array(
						'success'	=>	'true',
						'total' 	=>	$total,
       					'data' 		=> 	$items
		));
		exit();

	}

	/**
	 * Update tab Translation in tabTranslate Table
	 */
	public function translateUpdate(){
		header('Content-Type','application/json; charset=utf-8');

		$this->q->commit();
		if($this->getVendor() == self::MYSQL){
			$sql="
		UPDATE	`folderTranslate`
		SET		`folderTranslate` 	=	\"".$this->strict($_POST['folderTranslate'],'string')."\"
		WHERE 	`folderTranslateId`	=	\"".$this->strict($_POST['folderTranslateId'],'numeric')."\"";
		} else if ($this->getVendor()==self::MSSQL){
			$sql="
		UPDATE	[folderTranslate]
		SET		[folderTranslate] 	=	\"".$this->strict($_POST['folderTranslate'],'string')."\"
		WHERE 	[folderTranslateId]	=	\"".$this->strict($_POST['folderTranslateId'],'numeric')."\"";
		} else if ($this->getVendor()==self::ORACLE){
			$sql="
		UPDATE	\"folderTranslate\"
		SET		\"folderTranslate\" 		=	\"".$this->strict($_POST['folderTranslate'],'string')."\"
		WHERE 	\"folderTranslateId\"	=	\"".$this->strict($_POST['folderTranslateId'],'numeric')."\"";
		}
		$this->q->update($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();
		}

		$this->q->commit();
		echo json_encode(array("success"=>true,"message"=>"Record Update"));
		exit();
	}
	/*
	 * Create Translation Folder Note to the folderTranslate Table
	 */
	function translateMe() {
		header('Content-Type','application/json; charset=utf-8');
		$this->q->start();

		$sql="
		SELECT	*
		FROM 	`folder`
		WHERE 	`folderId`	=	\"".$this->folderId."\"";
		$resultDefault= $this->q->fast($sql);
		if($this->q->numberRows($resultDefault) > 0 ) {
			$rowDefault = $this->q->fetch_array($resultDefault);
			$value 		= $rowDefault['folderNote'];
		}
		if($this->getVendor() == self::MYSQL) {
			$sql="
			SELECT	*
			FROM 	`language`";
		} else if ($this->getVendor()==self::MSSQL) {
			$sql="
			SELECT 	*
			FROM 	[language] ";
		} else if ($this->getVendor()==self::ORACLE) {
			$sql="
			SELECT 	*
			FROM 	LANGUAGE ";
		}
		$result= $this->q->fast($sql);
		while (($row = $this->q->fetchAssoc($result)) == TRUE) {
			$languageId 	= 	$row['languageId'];
			$languageCode	= 	$row['languageCode'];
			$to 		  	=	$languageCode;
			$googleTranslate = $this->security->changeLanguage($from="en",$to,$value);
			if($this->getVendor() == self::MYSQL) {
				$sql="
				SELECT	*
				FROM 	`folderTranslate`
				WHERE 	`folderId`			=	\"".$this->folderId."\"
				AND 	`languageId`		=	\"".$languageId."\"";
			} else if ($this->getVendor()==self::MSSQL) {
				$sql="
				SELECT 	*
				FROM 	[folderTranslate]
				WHERE 	[folderId]			=	\"".$this->folderId."\"
				AND 	[languageId]		=	\"".$languageId."\"";
			}  else if ($this->getVendor()==self::ORACLE) {
				$sql="
				SELECT 	*
				FROM 	FOLDERID        =
				WHERE 	FOLDERID		=	\"".$this->folderId."\"
				AND 	LANGUAGEID		=	\"".$languageId."\"";
			}
			$resultfolderTranslate = $this->q->fast($sql);
			if($this->q->numberRows($resultfolderTranslate) >  0 ) {
				if($this->getVendor() == self::MYSQL) {
					$sql="
					UPDATE 	`folderTranslate`
					SET 	`folderTranslate`		=	\"".$googleTranslate."\"
					WHERE 	`folderId`				=	\"".$this->folderId."\"
					AND 	`languageId`			=	\"".$languageId."\"";
				} else if ($this->getVendor()==self::MSSQL) {
					$sql="
					UPDATE 	[folderTranslate]
					SET 	[folderTranslate]		=	\"".$googleTranslate."\"
					WHERE 	[folderId]				=	\"".$this->folderId."\"
					AND 	[languageId]			=	\"".$languageId."\"";
				} else if ($this->getVendor()==self::ORACLE) {
					$sql="
					UPDATE 	FOLDERTRANSLATE
					SET 	FOLDERTRANSLATE		=	\"".$googleTranslate."\"
					WHERE 	FOLDERID			=	\"".$this->folderId."\"
					AND 	LANGUAGEID			=	\"".$languageId."\"";
				}
				$this->q->update($sql);
				if($this->q->execute=='fail') {
					echo json_encode(array("success"=>"false","message"=>$this->q->responce));
					exit();

				}
			} else {
				if($this->q->vendor=='normal'  ||$this->getVendor() == self::MYSQL) {
					$sql="
					INSERT INTO `folderTranslate`
							(
								`folderId`,
								`languageId`,
								`folderTranslate`
							)
					VALUES
						(
							\"".$folderId."\",
							\"".$languageId."\",
							\"".$googleTranslate."\"
						)";
				} else if ($this->getVendor()==self::MSSQL) {
					$sql="
					INSERT INTO [folderTranslate]
							(
								[folderId],
								[languageId],
								[folderTranslate]
							)
					VALUES
							(
								\"".$folderId."\",
								\"".$languageId."\",
								\"".$googleTranslate."\"
						)";
				} else if ($this->getVendor()==self::ORACLE) {
					$sql="
					INSERT INTO \"folderTranslate\"
							(
								FOLDERID,
								LANGUAGEID,
								\"folderTranslate\"
							)
					VALUES
							(
								\"".$folderId."\",
								\"".$languageId."\",
								\"".$googleTranslate."\"
							)";
				}
				$this->q->create($sql);
				if($this->q->execute=='fail') {
					echo json_encode(array("success"=>"false","message"=>$this->q->responce));
					exit();

				}
			}
		}
		$this->q->commit();
		echo json_encode(
		array(
							  	"success"	=>	"true",
								"message"	=>	"Translation Complete"
								));
								exit();


	}
	/**
	 * Enter description here ...
	 */
	function tab(){
		return $this->security->tab();
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::MYSQL) {
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
		$this->excel->getActiveSheet()->setCellValue('C3','Folder');
		$this->excel->getActiveSheet()->setCellValue('D3','Description');
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');

		//
		$loopRow=4;
		$i=0;
		while(($row  = 	$this->q->fetchAssoc()) == TRUE) {


			$this->excel->getActiveSheet()->setCellValue('B'.$loopRow,++$i);
			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['folderNote']);
			$loopRow++;
			$lastRow='D'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="folder".rand(0,10000000).".xlsx";
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

$folderTranslateObject  	= 	new folderTranslateClass();

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
		$folderTranslateObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$folderTranslateObject->setIsAdmin($_POST['isAdmin']);
	}

	/*
	 *  Filtering
	 */

	if(isset($_POST['query'])){
		$folderTranslateObject->setFieldQuery($_POST['query']);
	}
	if(isset($_POST['filter'])){
		$folderTranslateObject->setGridQuery($_POST['filter']);
	}
	/*
	 * Ordering
	 */
	if(isset($_POST['order'])){
		$folderTranslateObject->setOrder($_POST['order']);
	}
	if(isset($_POST['sortField'])){
		$folderTranslateObject->setSortField($_POST['sortField']);
	}

	/*
	 *  Load the dynamic value
	 */
	$folderTranslateObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_POST['method']=='create')	{
		$folderTranslateObject->create();
	}
	if($_POST['method']=='read') 	{

		$folderTranslateObject->read();

	}

	if($_POST['method']=='save') 	{

		$folderTranslateObject->update();


	}
	if($_POST['method']=='delete') 	{
		$folderTranslateObject->delete();
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
		$folderTranslateObject->setleafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$folderTranslateObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$folderTranslateObject->execute();
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {

			$folderTranslateObject->staff();
		}
	}



	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$folderTranslateObject->excel();
		}
	}
	if($_GET['method']=='translate'){
		$folderTranslateObject->translateMe();

	}
}


?>

