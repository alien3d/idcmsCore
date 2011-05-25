<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../class/classDocumentTrail.php");
require_once("../../class/classSecurity.php");
require_once("../model/folderModel.php");

/**
 * this folder menu creation
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package folder
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class folderClass extends  configClass {
	/**
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
	 *	 Database Selected
	 *   string $database;
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
	private  $excel;


	/**
	 * Document Trail Audit.
	 * @var string $documentTrail;
	 */
	private  $documentTrail;

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
	 * Current Table Folder Indentification Value
	 * @var numeric $folderId
	 */
	public $folderId;
	/**
	 * Common class function for security menu
	 * @var  string $security
	 */
	private $security;
	/**
	 * Folder Model
	 * @var string $model
	 */
	public $model;
	/**
	 * Class Loader
	 */
	function execute() {
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->vendor;

		$this->q->leafId			=	$this->leafId;

		$this->q->staffId			=	$this->staffId;

		$this->q->filter 			= 	$this->filter;

		$this->q->quickFilter		=	$this->quickFilter;

		$this->q->connect($this->connection, $this->username,$this->database,$this->password);

		$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;

		$this->log					=   0;

		$this->q->log 				= $this->log;

		$this->defaultLanguageId  	= 21;

		$this->security 	= 	new security();
		$this->security->vendor = $this->vendor;
		$this->security->leafId = $this->leafId;
		$this->security->execute();
		$this->model = new folderModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->documentTrail = new documentTrailClass();


	}

	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create() 							{
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
			INSERT INTO `folder` 
					(
						`accordionId`,						`folderNote`,
						`folderSequence`,					`folderPath`,
						`iconId`,							`isNew`,
						`isDraft`,							`isUpdate`,
						`isDelete`,							`isActive`,
						`isApproved`,						`By`,
						`Time`
					)
			VALUES	
					(
						'".$this->model->accordionId."',	'".$this->model->folderNote."',
						'".$this->model->folderSequence."', '".$this->model->folderPath."',
						'".$this->model->iconId."',			'".$this->model->isNew."',
						'".$this->model->isDraft."',		'".$this->model->isUpdate."',
						'".$this->model->isDelete."',		'".$this->model->isActive."',
						'".$this->model->isApproved."',		'".$this->model->isApproved."',
						".$this->model->Time."
					);";
		}else if ($this->q->vendor==self::mssql) {
			$sql="
			INSERT INTO [folder] 
					(
						[accordionId],						[folderNote],
						[folderSequence],					[folderPath],
						[iconId],							[isNew],
						[isDraft],							[isUpdate],
						[isDelete],							[isActive],
						[isApproved],						[By],
						[Time]
				)
			VALUES	
				(		
						'".$this->model->accordionId."',	'".$this->model->folderNote."',
						'".$this->model->folderSequence."', '".$this->model->folderPath."',
						'".$this->model->iconId."',			'".$this->model->isNew."',
						'".$this->model->isDraft."',		'".$this->model->isUpdate."',
						'".$this->model->isDelete."',		'".$this->model->isActive."',
						'".$this->model->isApproved."',		'".$this->model->isApproved."',
						".$this->model->Time."
				);";
		} else if ($this->q->vendor==self::oracle) {
			$sql="
			INSERT INTO 	\"folder\" 
						(
							\"accordionId\",					\"folderNote\",
							\"folderSequence\",					\"folderPath\",
							 \"iconId\",				 		\"isNew\",
							\"isDraft\",						\"isUpdate\",
							\"isDelete\",						\"isActive\",
							\"isApproved\",						\"By\",
							\"Time\")
				VALUES	(		
							'".$this->model->accordionId."',	'".$this->model->folderNote."',
							'".$this->model->folderSequence."', '".$this->model->folderPath."',
							'".$this->model->iconId."',			'".$this->model->isNew."',
							'".$this->model->isDraft."',		'".$this->model->isUpdate."',
							'".$this->model->isDelete."',		'".$this->model->isActive."',
							'".$this->model->isApproved."',		'".$this->model->isApproved."',
							".$this->model->Time."
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
			 *  If anthing wrong use this instead  SELECT accordionIdSeq
			 */
			$sql="
			SELECT MAX(\"folderId\") AS \"lastId\"
			FROM 	\"folder\"";
		}

		$resultd =$this->q->fast($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}

		$rowLastId= $this->q->fetchAssoc($resultd);
		$lastId = $rowLastId['lastId'];

		//  create a record  in accordionAccess.update no effect
		// loop the group
		if( $this->q->vendor==self::mysql) {
			$sql="SELECT * FROM `group` WHERE `isActive`=1 ";
		} else if ($this->q->vendor==self::mssql) {
			$sql="SELECT * FROM [group] WHERE [isActive]=1 ";
		} else if ($this->q->vendor==self::oracle) {
			$sql="SELECT * FROM \"group\" WHERE \"isActive\"=1 ";
		}
		$this->q->read($sql);
		$data = $this->q->activeRecord();
		foreach ($data as $row ) {
			// by default no access
			if( $this->q->vendor==self::mysql) {
				$sql="
				INSERT INTO	`folderAccess` 
						(
							`folderId`,
							`groupId`,
							`folderAccessValue`
						) 
				VALUES
						(
							'".$lastId."',
							 '".$row['groupId']."',
							 '0'	
						)	";
			} else if ($this->q->vendor==self::mssql) {
				$sql="
				INSERT INTO 	[folderAccess] 
							(
								[folderId],
								[groupId],
								[folderAccessValue]
							) 
				VALUES
							(	
								'".$lastId."',
							 	'".$row['groupId']."',
							 	'0'	
							 )	";
			} else if ($this->q->vendor==self::oracle) {
				$sql="
				INSERT INTO 	\"folderAccess\" 
							(
								\"folderId\",
								\"groupId\",
								\"folderAccessValue\"
							) 
					VALUES
							(	
								'".$lastId."',
							 	'".$row['groupId']."',
							 	'0'	
							 )	";
			}
			$this->q->update($sql);
			if($this->q->redirect=='fail') {
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
		if( $this->q->vendor==self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		// everything given flexibility  on todo
		if( $this->q->vendor==self::mysql) {
			$sql="
			SELECT 		*
			FROM 		`folder`
			JOIN 		`accordion`
			ON			`accordion`.`accordionId` = `folder`.`accordionId`
			LEFT JOIN	`icon`
			ON			`folder`.`iconId`=`icon`.`iconId`
			WHERE		`accordion`.`isActive`	=	1
			AND			`folder`.`isActive`		=	1";
			if($this->folderId) {
				$sql.=" AND `folderId`='".$this->folderId."'";
			}
		} else if ($this->q->vendor==self::mssql) {
			$sql	=	"
			SELECT 		*
			FROM 		[folder]
			JOIN		[folderTranslate]
			JOIN 		[accordion]
			ON			[accordion].[accordionId] = [folder].[accordionId]
			LEFT JOIN	[icon]
			ON			[folder].[iconId]=[icon].[iconId]
			WHERE		[accordion].[isActive]	=	1
			AND			[folder].[isActive]		=	1";
			if($this->folderId) {
				$sql.=" AND `folderId`='".$this->folderId."'";
			}
		} else if ($this->q->vendor==self::oracle) {
			$sql	=	"
			SELECT 		*
			FROM 		\"folder\"
			JOIN 		\"accordion\"
			ON			\"accordion\".\"accordionId\" = \"folder\".\"accordionId\"
			LEFT JOIN	\"icon\"
			USING(\"iconId\")
			WHERE		\"accordion\".\"isActive\"=1
			AND			\"folder\".\"isActive\"=1";
			if($this->folderId) {
				$sql.=" AND \"folderId\"='".$this->folderId."'";
			}
		}
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		$filterArray =array('accordionId','accordionTranslateId','folderId','folderTranslateId');
		/**
		 *	filter table
		 * @variables $tableArray
		 */
		$tableArray = array('accordian','accordionTranslate','folder','folderTranslate');

		if(isset($_GET['query'])) {
			$query = $_GET['query'];
		}  else if (isset($_POST['query'])) {
			$query = $_POST['query'];
		}
		if(isset($query)) {
			if( $this->q->vendor==self::mysql) {
				$sql.=$this->q->quickSearch($tableArray,$filterArray);
			} else if ($this->q->vendor==self::mssql) {
				$tempSql=$this->q->quickSearch($tableArray,$filterArray);
				$sql.=$tempSql;
			} else if ($this->q->vendor==self::oracle) {
				$tempSql=$this->q->quickSearch($tableArray,$filterArray);
				$sql.=$tempSql;
			}
		}
		/**
		 *	Extjs filtering mode
		 */
		if( $this->q->vendor==self::mysql) {

			$sql.=$this->q->searching();
		} else if ($this->q->vendor==self::mssql) {
			$tempSql2=$this->q->searching();
			$sql.=$tempSql2;
		}else if ($this->q->vendor==self::oracle) {
			$tempSql2=$this->q->searching();
			$sql.=$tempSql2;
		}
		//echo $sql;
		$this->q->read($sql);
		if($this->q->redirect=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		$total	= $this->q->numberRows();

		if($this->order && $this->sortField){
			if($this->q->vendor==self::mysql || $this->q->vendor=='normal') {
				$sql.="	ORDER BY `".$sortField."` ".$dir." ";
			} else if ($this->q->vendor==self::mssql) {
				$sql.="	ORDER BY [".$sortField."] ".$dir." ";
			} else if ($this->q->vendor==self::oracle) {
				$sql.="	ORDER BY \"".$sortField."\"  ".$dir." ";
			}
		}
		$_SESSION['sql']	=	$sql; // push to session so can make report via excel and pdf
		$_SESSION['start'] 	= 	$_POST['start'];
		$_SESSION['limit'] 	= 	$_POST['limit'];

		if(empty($_POST['filter']))      {

			if(isset($_POST['start']) && isset($_POST['limit'])) {
				// only mysql have limit

				if( $this->q->vendor==self::mysql) {
					$sql.=" LIMIT  ".$_POST['start'].",".$_POST['limit']." ";
					$sqlLimit = $sql;
				} else if ($this->q->vendor==self::mssql) {
					/**
					 *	 Sql Server and Oracle used row_number
					 *	 Parameterize Query We don't support
					 */
					$sqlLimit="
							WITH [religionDerived] AS
							(
								SELECT	*,
								[folder].[By],
								[folder].[Time]
								ROW_NUMBER() OVER (ORDER BY [folderId]) AS 'RowNumber'
								FROM 		[folder]

								JOIN 		[accordion]
								ON			[accordion].[accordionId` = `folder`.`accordionId`

								LEFT JOIN	[icon]
								ON			[folder].[iconId]=[icon].[iconId]
								WHERE		[accordion].[isActive]	=	1
								AND			[folder].[isActive]		=	1  ".$tempSql.$tempSql2."
							)
							SELECT		*
							FROM 		[religionDerived]
							WHERE 		[RowNumber]
							BETWEEN	".$_POST['start']."
							AND 			".($_POST['start']+$_POST['limit']-1).";";


				}  else if ($this->q->vendor==self::oracle) {
					/**
					 *  Oracle using derived table also
					 */


					$sql="
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT 		*,
												\"folder\".\"By\",
												\"folder\".\"Time\"
									FROM 		\"folder\"
									JOIN		\"folderTranslate\"
									ON			\"folder\".\"folderId\"	=\"folderTranslate\".\"folderId\"
									JOIN 		\"accordion\"
									ON			\"accordion\".\"accordionId\" = \"folder\".\"accordionId\"
									JOIN		\"accordionTranslate\"
									ON			\"accordion\".\"accordionId\"=	\"accordionTranslate\".\"accordionId\"
									AND			\"accordionTranslate\".\"accordionId\" =\"folder\".\"accordionId\"
									LEFT JOIN	\"icon\"
									ON			\"folder\".\"iconId\"=\"icon\".\"iconId\"
									WHERE		\"accordion\".\"isActive\"=1
									AND			\"folder\".\"isActive\"=1 ".$tempSql.$tempSql2.$orderBy."
								 ) a
						where rownum <= '".($_POST['start']+$_POST['limit']-1)."' )
						where r >=  '".$_POST['start']."'";

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
		while($row  	= 	$this->q->fetchAssoc()) {
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
		if( $this->q->vendor==self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->update();
		if( $this->q->vendor==self::mysql) {
			$sql="
					UPDATE 	`folder`
					SET 	`accordionId`		=	'".$this->strict($_POST['accordionId'],'string')."',
							`folderNote`		=	'".$this->strict($_POST['folderNote'],'memo')."',
							`folderSequence`	=	'".$this->strict($_POST['folderSequence'],'numeric')."',
							`folderPath`		=	'".$this->strict($_POST['folderPath'],'string')."',
							`iconId`			=	'".$this->strict($_POST['iconId'],'string')."',
							`isActive`			=	'".$this->model->isActive."',
							`isNew`				=	'".$this->model->isNew."',
							`isDraft`			=	'".$this->model->isDraft."',
							`isUpdate`			=	'".$this->model->isUpdate."',
							`isDelete`			=	'".$this->model->isDelete."',
							`isApproved`		=	'".$this->model->isApproved."',
							`By`				=	'".$this->model->By."',
							`Time				=	".$this->model->Time."
					WHERE 	`folderId`			=	'".$this->strict($_POST['folderId'],'numeric')."'";
		}  else if ( $this->q->vendor==self::mssql) {
			$sql="
					UPDATE 	[folder]
					SET 	[accordionId]		=	'".$this->strict($_POST['accordionId'],'string')."',
							[folderNote]		=	'".$this->strict($_POST['folderNote'],'memo')."',
							[folderSequence]	=	'".$this->strict($_POST['folderSequence'],'numeric')."',
							[folderPath]		=	'".$this->strict($_POST['folderPath'],'string')."',
							[iconId]			=	'".$this->strict($_POST['iconId'],'string')."',
							[isActive]			=	'".$this->model->isActive."',
							[isNew]				=	'".$this->model->isNew."',
							[isDraft]			=	'".$this->model->isDraft."',
							[isUpdate]			=	'".$this->model->isUpdate."',
							[isDelete]			=	'".$this->model->isDelete."',
							[isApproved]		=	'".$this->model->isApproved."',
							[By]				=	'".$this->model->By."',
							[Time]				=	".$this->model->Time."
					WHERE 	[folderId]			=	'".$this->strict($_POST['folderId'],'numeric')."'";
		} else if ($this->q->vendor==self::oracle) {
			$sql="
					UPDATE 	\"folder\"
					SET 	\"accordionId\"		=	'".$this->strict($_POST['accordionId'],'string')."',
							\"folderNote\"		=	'".$this->strict($_POST['folderNote'],'memo')."',
							\"folderSequence\"	=	'".$this->strict($_POST['folderSequence'],'numeric')."',
							\"folderPath\"		=	'".$this->strict($_POST['folderPath'],'string')."',
							\"isActive\"	=	'".$this->model->isActive."',
							\"isNew\"		=	'".$this->model->isNew."',
							\"isDraft\"		=	'".$this->model->isDraft."',
							\"isUpdate\"	=	'".$this->model->isUpdate."',
							\"isDelete\"	=	'".$this->model->isDelete."',
							\"isApproved\"	=	'".$this->model->isApproved."',
							\"By\"			=	'".$this->model->By."',
							\"Time\"		=	".$this->model->Time."
					WHERE 	\"folderId\"		=	'".$this->strict($_POST['folderId'],'numeric')."'";
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
		if( $this->q->vendor==self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->delete();
		if( $this->q->vendor==self::mysql) {
			$sql="
					UPDATE	`folder`
					SET		`isActive`			=	'".$this->model->isActive."',
							`isNew`				=	'".$this->model->isNew."',
							`isDraft`			=	'".$this->model->isDraft."',
							`isUpdate`			=	'".$this->model->isUpdate."',
							`isDelete`			=	'".$this->model->isDelete."',
							`isApproved`		=	'".$this->model->isApproved."',
							`By`				=	'".$this->model->By."',
							`Time				=	".$this->model->Time."
					WHERE 	`folderId`	=	'".$this->strict($_POST['folderId'],'numeric')."'";

		} else if ($this->q->vendor==self::mssql) {
			$sql="
					UPDATE	[folder]
					SET		[isActive]			=	'".$this->model->isActive."',
							[isNew]				=	'".$this->model->isNew."',
							[isDraft]			=	'".$this->model->isDraft."',
							[isUpdate]			=	'".$this->model->isUpdate."',
							[isDelete]			=	'".$this->model->isDelete."',
							[isApproved]		=	'".$this->model->isApproved."',
							[By]				=	'".$this->model->By."',
							[Time]				=	".$this->model->Time."
					WHERE 	[folderId]	=	'".$this->strict($_POST['folderId'],'numeric')."'";
		} else if ($this->q->vendor==self::oracle) {
			$sql="
					UPDATE	\"folder\"
					SET		\"isActive\"	=	'".$this->model->isActive."',
							\"isNew\"		=	'".$this->model->isNew."',
							\"isDraft\"		=	'".$this->model->isDraft."',
							\"isUpdate\"	=	'".$this->model->isUpdate."',
							\"isDelete\"	=	'".$this->model->isDelete."',
							\"isApproved\"	=	'".$this->model->isApproved."',
							\"By\"			=	'".$this->model->By."',
							\"Time\"		=	".$this->model->Time."
					WHERE 	\"folderId\"	=	'".$this->strict($_POST['folderId'],'numeric')."'";
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

	/**
	 *  Read Record From accordionTranslate Table
	 **/
	function translateRead() {
		header('Content-Type','application/json; charset=utf-8');
		if( $this->q->vendor==self::mysql) {
			/**
			 *	UTF 8
			 **/
			$sql	=	'SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		if( $this->q->vendor='mysql'){
			$sql="
			SELECT	*
			FROM 	`folderTranslate`
			JOIN 	`language`
			USING (`languageId`)
			WHERE	`folderTranslate`.`folderId`='".$this->strict($_POST['folderId'],'numeric')."'";
		} else if ($this->q->vendor==self::mssql){
			$sql="
			SELECT	*
			FROM 	[accordionTranslate]
			JOIN 	[language]
			ON 		[folderTranslate].[languageId] =[language].[languageId]
			WHERE	[folderTranslate].[folderId]='".$this->strict($_POST['folderId'],'numeric')."'";
		} else if ($this->q->vendor=='oralce'){
			$sql="
			SELECT	*
			FROM 	\"folderTranslate\"
			JOIN 	\"language\"
			USING (\"languageId\")
			WHERE	\"folderTranslate\".\"folderId\"='".$this->strict($_POST['folderId'],'numeric')."'";
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
	 * Update Accordion Translation in accordionTranslate Table
	 */
	public function translateUpdate(){
		header('Content-Type','application/json; charset=utf-8');

		$this->q->commit();
		if( $this->q->vendor==self::mysql){
			$sql="
		UPDATE	`folderTranslate`
		SET		`folderTranslate` 	=	'".$this->strict($_POST['folderTranslate'],'string')."'
		WHERE 	`folderTranslateId`	=	'".$this->strict($_POST['folderTranslateId'],'numeric')."'";
		} else if ($this->q->vendor==self::mssql){
			$sql="
		UPDATE	[folderTranslate]
		SET		[folderTranslate] 	=	'".$this->strict($_POST['folderTranslate'],'string')."'
		WHERE 	[folderTranslateId]	=	'".$this->strict($_POST['folderTranslateId'],'numeric')."'";
		} else if ($this->q->vendor==self::oracle){
			$sql="
		UPDATE	\"folderTranslate\"
		SET		\"folderTranslate\" 		=	'".$this->strict($_POST['folderTranslate'],'string')."'
		WHERE 	\"folderTranslateId\"	=	'".$this->strict($_POST['folderTranslateId'],'numeric')."'";
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
		WHERE 	`folderId`	=	'".$this->folderId."'";
		$resultDefault= $this->q->fast($sql);
		if($this->q->numberRows($resultDefault) > 0 ) {
			$rowDefault = $this->q->fetch_array($resultDefault);
			$value 		= $rowDefault['folderNote'];
		}
		if( $this->q->vendor==self::mysql) {
			$sql="
			SELECT	* 
			FROM 	`language`";
		} else if ($this->q->vendor==self::mssql) {
			$sql="
			SELECT 	* 
			FROM 	[language] ";
		} else if ($this->q->vendor==self::oracle) {
			$sql="
			SELECT 	* 
			FROM 	\"language\" ";
		}
		$result= $this->q->fast($sql);
		while ($row = $this->q->fetchAssoc($result)) {
			$languageId 	= 	$row['languageId'];
			$languageCode	= 	$row['languageCode'];
			$to 		  	=	$languageCode;
			$googleTranslate = $this->security->changeLanguage($from="en",$to,$value);
			if( $this->q->vendor==self::mysql) {
				$sql="
				SELECT	* 
				FROM 	`folderTranslate` 
				WHERE 	`folderId`			=	'".$this->folderId."' 
				AND 	`languageId`		=	'".$languageId."'";
			} else if ($this->q->vendor==self::mssql) {
				$sql="
				SELECT 	* 
				FROM 	[folderTranslate] 
				WHERE 	[folderId]			=	'".$this->folderId."' 
				AND 	[languageId]		=	'".$languageId."'";
			}  else if ($this->q->vendor==self::oracle) {
				$sql="
				SELECT 	* 
				FROM 	\"folderTranslate\" 
				WHERE 	\"folderId\"		=	'".$this->folderId."' 
				AND 	\"languageId\"		=	'".$languageId."'";
			}
			$resultfolderTranslate = $this->q->fast($sql);
			if($this->q->numberRows($resultfolderTranslate) >  0 ) {
				if($this->q->vendor=='normal'  || $this->q->vendor==self::mysql) {
					$sql="
					UPDATE 	`folderTranslate` 
					SET 	`folderTranslate`		=	'".$googleTranslate."' 
					WHERE 	`folderId`				=	'".$this->folderId."' 
					AND 	`languageId`			=	'".$languageId."'";
				} else if ($this->q->vendor==self::mssql) {
					$sql="
					UPDATE 	[folderTranslate] 
					SET 	[folderTranslate]		=	'".$googleTranslate."' 
					WHERE 	[folderId]				=	'".$this->folderId."' 
					AND 	[languageId]			=	'".$languageId."'";
				} else if ($this->q->vendor==self::oracle) {
					$sql="
					UPDATE 	\"folderTranslate\" 
					SET 	\"folderTranslate\"		=	'".$googleTranslate."' 
					WHERE 	\"folderId\"			=	'".$this->folderId."' 
					AND 	\"languageId\"			=	'".$languageId."'";
				}
				$this->q->update($sql);
				if($this->q->redirect=='fail') {
					echo json_encode(array("success"=>"false","message"=>$this->q->responce));
					exit();

				}
			} else {
				if($this->q->vendor=='normal'  || $this->q->vendor==self::mysql) {
					$sql="
					INSERT INTO `folderTranslate` 
							(
								`folderId`,		
								`languageId`,
								`folderTranslate`
							) 
					VALUES
						(	
							'".$folderId."',
							'".$languageId."',
							'".$googleTranslate."'
						)";
				} else if ($this->q->vendor==self::mssql) {
					$sql="
					INSERT INTO [folderTranslate] 
							(
								[folderId],
								[languageId],
								[folderTranslate]
							) 
					VALUES
							(
								'".$folderId."',
								'".$languageId."',
								'".$googleTranslate."'
						)";
				} else if ($this->q->vendor==self::oracle) {
					$sql="
					INSERT INTO \"folderTranslate\" 
							(
								\"folderId\",
								\"languageId\",
								\"folderTranslate\"
							) 
					VALUES
							(
								'".$folderId."',
								'".$languageId."',
								'".$googleTranslate."'
							)";
				}
				$this->q->create($sql);
				if($this->q->redirect=='fail') {
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
	function accordion(){
		return $this->security->accordion();
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {
		header('Content-Type','application/json; charset=utf-8');
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
		while($row  = 	$this->q->fetch_array()) {


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

$folderObject  	= 	new folderClass();
if(isset($_SESSION['staffId'])){
	$folderObject->staffId = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$folderObject->vendor = $_SESSION['vendor'];
}
/**
 *	crud -create,read,update,delete
 **/
if(isset($_POST['method']))	{

	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_POST['leafId'])){
		$folderObject->leafId = $_POST['leafId'];
	}
	if(isset($_POST['folderId'])) {
		$folderObject->folderId = $_POST['folderId'];
	}
	if(isset($_POST['filter'])){
		$folderObject->filter = $_POST['filter'];
	}
	if(isset($_POST['query'])){
		$folderObject->quickFilter = $_POST['query'];
	}
	if(isset($_POST['order'])){
		$folderObject->order= $_POST['order'];
	}
	if(isset($_POST['sortField'])){
		$folderObject-> sortField= $_POST['sortField'];
	}
	/*
	 *  Load the dynamic value
	 */
	$folderObject->execute();

	if($_POST['method']=='create')	{
		$folderObject->create();
	}
	if($_POST['method']=='read') 	{
		if(isset($_POST['page'])) {
			if($_POST['page']=='master') {
				$folderObject->read();
			}
			if($_POST['page']=='detail') {
				$folderObject->translateRead();
			}
		}
	}

	if($_POST['method']=='save') 	{
		if(isset($_POST['page'])) {
			if($_POST['page']=='master') {
				$folderObject->update();
			}
			if($_POST['page']=='detail') {
				$folderObject->translateUpdate();
			}
		}
	}
	if($_POST['method']=='delete') 	{
		$folderObject->delete();
	}

}

if(isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_GET['leafId'])){
		$folderObject->leafId  = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$folderObject->execute();
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {

			$folderObject->staffId();
		}
	}
	if(isset($_GET['field'])){
		if($_GET['field']=='accordionId'){
			$folderObject->accordion();
		}
	}


	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$folderObject->excel();
		}
	}
	if($_GET['method']=='translate'){
		$folderObject->translateMe();

	}
}


?>

