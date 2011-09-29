<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/leafModel.php");
/**
 * Leaf Translation
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @subpackage Leaf Translation Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafTranslateClass extends  configClass {
	/**
	 * Connection to the database
* @var string
	 */
	public $q;

	/**
	 * Program Identification
	 * @var numeric $leafId
	 */
	public $leafId_temp;

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
	public function execute() {
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->vendor;

		$this->q->leafId			=	$this->leafId_temp;

		$this->q->staffId			=	$this->staffId;

		$this->q->filter 			= 	$this->filter;

		$this->q->quickFilter		=	$this->quickFilter;

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;

		$this->log					=  1;

		$this->q->log 				= $this->log;

		$this->security 	= 	new security();
		$this->security->vendor = $this->vendor;
		$this->security->leafId =$this->leafId_temp;
		$this->security->execute();

		$this->model = new leafModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
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
			$sql	=	"
			INSERT INTO `leaf`
					(
						`accordionId`,						`folderId`,
						`leafNote`,							`leafSequence`,
						`leafcode`,							`leafFilename`,
						`iconId`,							`isNew`,
						`isDraft`,							`isUpdate`,
						`isDelete`,							`isActive`,
						`isApproved`,						`executeBy`,
						`executeTime`
					)
			VALUES
					(
						\"".$this->model->accordionId."\",	\"".$this->model->folderId."\",
						\"".$this->model->leafNote."\",		\"".$this->model->leafSequence."\",
						\"".$this->model->leafCode."\",		\"".$this->model->leafFilename."\",
						\"".$this->model->iconId."\",			\"".$this->model->getIsNew(0,'single')."\",
						\"".$this->model->getIsDraft(0,'single')."\",		\"".$this->model->getIsUpdate(0,'single')."\",
						\"".$this->model->getIsDelete(0,'single')."\",		\"".$this->model->getIsActive(0,'single')."\",
						\"".$this->model->getIsApproved(0,'single')."\",		\"".$this->model->staffId."\",
						".$this->model->getExecuteTime()."
					) ";
		} else if ($this->getVendor()==self::mssql) {
			$sql	=	"
			INSERT INTO [leaf]
					(
						[accordionId],					[folderId],
						[leafNote],						[leafSequence],
						[leafCode],						[leafFilename],
						[iconId],						[isNew],
						[isDraft],						[isUpdate],
						[isDelete],						[isActive],
						[isApproved],					[executeBy],
						[executeTime]
					)
			VALUES
					(
						\"".$this->model->accordionId."\",	\"".$this->model->folderId."\",
						\"".$this->model->leafNote."\",		\"".$this->model->leafSequence."\",
						\"".$this->model->leafCode."\",		\"".$this->model->leafFilename."\",
						\"".$this->model->iconId."\",			\"".$this->model->getIsNew(0,'single')."\",
						\"".$this->model->getIsDraft(0,'single')."\",		\"".$this->model->getIsUpdate(0,'single')."\",
						\"".$this->model->getIsDelete(0,'single')."\",		\"".$this->model->getIsActive(0,'single')."\",
						\"".$this->model->getIsApproved(0,'single')."\",		\"".$this->model->staffId."\",
						".$this->model->getExecuteTime()."
					)";
		} else if ($this->getVendor()==self::oracle) {
			$sql	=	"
			INSERT INTO LEAF
					(
						\"accordionId\",					FOLDERID,
						LEAFNOTE,						LEAFSEQUENCE,
						LEAFCODE,						LEAFFILENAME,
						ICONID,							ISNEW,
						ISDRAFT,						ISUPDATE,
						ISDELETE,						ISACTIVE,
						ISAPPROVED,						EXECUTEBY,
						EXECUTETIME
					)
			VALUES
					(
						\"".$this->model->accordionId."\",	\"".$this->model->folderId."\",
						\"".$this->model->leafNote."\",		\"".$this->model->leafSequence."\",
						\"".$this->model->leafCode."\",		\"".$this->model->leafFilename."\",
						\"".$this->model->iconId."\",			\"".$this->model->getIsNew(0,'single')."\",
						\"".$this->model->getIsDraft(0,'single')."\",		\"".$this->model->getIsUpdate(0,'single')."\",
						\"".$this->model->getIsDelete(0,'single')."\",		\"".$this->model->getIsActive(0,'single')."\",
						\"".$this->model->getIsApproved(0,'single')."\",		\"".$this->model->staffId."\",
						".$this->model->getExecuteTime()."
					);";
		}
		$this->q->create($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		if($this->q->vendor	==	'normal' || $this->q->vendor	==	'mysql' ) {
			/*
			 * 	If anything wrong use this instead  SELECT LAST_INSERT_ID();
			 **/
			$sql="
			SELECT MAX(`leafId`)	AS `lastId`
			FROM `leaf` ";
		} else if ($this->q->vendor	==	'microsoft') {
			/*
			 *  If anything wrong use this insert SELECT @@IDENTITY
			 **/
			$sql="
			SELECT MAX([leafId]) AS [lastId] FROM [leaf] ";
		} else if ( $this->q->vendor	==	'oracle') {
			/**
			 *  If anthing wrong use this instead  SELECT accordionIdSeq
			 */
			$sql="
			SELECT MAX(LEAFID) AS \"lastId\"
			FROM 	LEAF";
		}

		$resultd =$this->q->fast($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}

		$rowLastId= $this->q->fetchAssoc($resultd);
		$lastId = $rowLastId['lastId'];

		// loop the group
		if($this->q->vendor=='normal'  ||$this->getVendor() == self::mysql) {
			$sql="
			SELECT 	*
			FROM 	`staff`
			WHERE 	`isActive`	=	1 ";
		} else if ($this->getVendor()==self::mssql) {
			$sql="
			SELECT 	*
			FROM 	[staff]
			WHERE 	[isActive]	=	1 ";
		} else if ($this->q->vendor==self::mysql) {
			$sql="SELECT * FROM STAFF WHERE ISACTIVE	=	1 ";
		}
		$this->q->read($sql);
		$data= $this->q->activeRecord();
		if($this->getVendor() == self::mysql) {
			$sql="
			INSERT INTO	`leafAccess`
					(
						`leafId`,					`staffId`,
						`leafAccessReadValue`,		`leafAccessCreateValue`,
						`leafAccessUpdateValue`,	`leafAccessDeleteValue`,
						`leafAccessPrintValue`,		`leafPostAccessValue`,
						`leafAccessDraftValue`
					)
			VALUES";
		}  else if ($this->getVendor() ==  self::mssql) {
			$sql="
			INSERT INTO	[leafAccess]
				(
					[leafId],					[staffId],
					[leafAccessReadValue],		[leafAccessCreateValue],
					[leafAccessUpdateValue],	[leafAccessDeleteValue],
					[leafAccessPrintValue],		[leafPostAccessValue],
					[leafAccessDraftValue]
				)
			VALUES";
		} else if ($this->getVendor() == self::oracle) {
			$sql="
			INSERT INTO 	LEAFACCESS
						(
							LEAFID,					STAFFID,
							leafAccessReadValue,	leafAccessCreateValue,
							leafAccessUpdateValue,	leafAccessDeleteValue,
							leafAccessPrintValue,	leafPostAccessValue,
							leafAccessDraftValue
						)
			VALUES";
		}
		foreach ($data as $row) {
			// by default no access

			$sqlLooping.="
				(
					\"".$lastId."\",				\"".$row['staffId']."\",
					'0',						'0',
					'0',						'0',
					'0',						'0',
					'0'
				),";



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
		$this->q->commit();
		echo json_encode(array("success"=>true,"leafId"=>$lastId,"message"=>"Record Created"));
		exit();

	}
	function read() 							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		// everything given flexibility  on todo
		if($this->getVendor() == self::mysql) {
			$sql="
			SELECT		*
			FROM 		`leaf`
			JOIN		`folder`
			USING		(`folderId`,`accordionId`)
			JOIN		`accordion`
			USING		(`accordionId`)
			LEFT JOIN	`icon`
			ON			`leaf`.`iconId`=`icon`.`iconId`
			WHERE 		`folder`.`isActive`		=	1
			AND			`accordion`.`isActive`	=	1
			AND			`leaf`.`isActive`		=	1 ";
			if($this->leafId) {
				$sql.=" AND `leafId`=\"".$this->leafId."\"";
			}
		} else if ($this->getVendor()==self::mssql) {
			$sql="
			SELECT		*
			FROM 		[leaf]
			JOIN		[folder]
			ON			[leaf].[folderId] 			=	[folder].[folderId]
			AND			[leaf].[accordionId] 		=	[folder].[accordionId]
			JOIN		[accordion]
			ON			[leaf].[accordionId] 		=	[accordion].[accordionId]
			LEFT JOIN	[icon]
			ON			[leaf].[iconId]				=	[icon].[iconId]
			WHERE 		[folder].[isActive]			=	1
			AND			[accordion].[isActive]		=	1
			AND			[leaf].[isActive]			=	1 ";
			if($this->leafId) {
				$sql.=" AND `leafId`=\"".$this->leafId."\"";
			}
		} else if ($this->getVendor()==self::oracle) {
			$sql="
			SELECT		*
			FROM 		\"leaf`
			JOIN		\"folder`
			USING		(FOLDERID,\"accordionId\")
			JOIN		\"accordion\"
			USING		(\"accordionId\")
			LEFT JOIN	ICON
			ON			LEAF.ICONID=ICON.ICONID
			WHERE 		FOLDER.ISACTIVE		=	1
			AND			\"accordion\".`isActive\"	=	1
			AND			LEAF.`isActive\"		=	1 ";
			if($this->leafId) {

				$sql.=" AND `leafId`=\"".$this->leafId."\"";
			}
		}
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		$filterArray	=	array("`leaf`.`leafFilename`");
		/**
		 *	filter table
		 * @variables $tableArray
		 */
		$tableArray = array('accordion','accordionTranslate','folder','folderTranslate','leaf','leafTranslate');

		if(isset($_GET['query'])) {
			$query = $_GET['query'];
		}  else if (isset($_POST['query'])) {
			$query = $_POST['query'];
		}
		if($query) {
			if($this->getVendor() == self::mysql) {
				$sql.=$this->q->quickSearch($tableArray,$filterArray);
			} else if ($this->getVendor()==self::mssql) {
				$tempSql=$this->q->quickSearch($tableArray,$filterArray);
				$sql.=$tempSql;
			} else if ($this->getVendor()==self::oracle) {
				$tempSql=$this->q->quickSearch($tableArray,$filterArray);
				$sql.=$tempSql;
			}
		}
		/**
		 *	Extjs filtering mode
		 */
		if($this->getVendor() == self::mysql) {

			$sql.=$this->q->searching();
		} else if ($this->getVendor()==self::mssql) {
			$tempSql2=$this->q->searching();
			$sql.=$tempSql2;
		}else if ($this->getVendor()==self::oracle) {
			$tempSql2=$this->q->searching();
			$sql.=$tempSql2;
		}
		//echo $sql;
		$this->q->read($sql);
		$total	= $this->q->numberRows();

		if(empty($_GET['dir'])) {
			$dir = 'ASC';
		} else {
			$dir  = $_GET['dir'];
		}
		if(empty($_POST['sort'])) {
			$sortField = "leafId";
		} else {
			$sortField = $_POST['sort'];
		}
		if($this->q->vendor==self::mysql || $this->q->vendor=='normal') {
			$sql.="	ORDER BY `".$sortField."` ".$dir." ";
		} else if ($this->getVendor()==self::mssql) {
			$sql.="	ORDER BY [".$sortField."] ".$dir." ";
		} else if ($this->getVendor()==self::oracle) {
			$sql.="	ORDER BY \"".$sortField."\"  ".$dir." ";
		}


		$_SESSION['sql']  =   $sql; // push to session so can make report via excel and pdf
		$_SESSION['start'] 	= 	$this->getStart();
		$_SESSION['limit'] 	= 	$_POST['limit'];

		if(empty($_POST['filter']))      {

			if(isset($this->getStart()) && isset($_POST['limit'])) {
				// only mysql have limit

				if($this->getVendor() == self::mysql) {
					$sql.=" LIMIT  ".$this->getStart().",".$_POST['limit']." ";
				} else if ($this->getVendor()==self::mssql) {
					/**
					 *	 Sql Server and Oracle used row_number
					 *	 Parameterize Query We don't support
					 */
					$sql="
							WITH [religionDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [religionId]) AS 'RowNumber'
								FROM [religion]
								WHERE [isActive] =1   ".$tempSql.$tempSql2."
							)
							SELECT		*
							FROM 		[religionDerived]
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
									SELECT *
									FROM 	RELIGION
									WHERE ISACTIVE=1  ".$tempSql.$tempSql2.$orderBy."
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
		if(!($this->leafId)) {
			$this->q->read($sql);
			if($this->q->execute=='fail') {
				echo json_encode(array("success"=>false,"message"=>$this->q->responce));
				exit();
			}
		}

		$items			=	array();
		while($row  	= 	$this->q->fetchAssoc()) {
			$items[]	=	$row;
		}
		//echo $strData;

		if($this->leafId) {
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
	/**
	 * Return Accordion Identification
	 */
	function accordion() 				{
		return $this->security->accordion();
	}
	/**
	 * Return Folder Identification
	 */
	function folder() {
		return $this->security->folder();
	}

	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() 							{
		header('Content-Type','application/json; charset=utf-8');
		//UTF8
		if($this->getVendor() == self::mysql) {
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}

		$this->q->start();
		$this->model->update();
		if($this->getVendor() == self::mysql) {
			$sql="
			UPDATE	`leaf`
			SET		`isActive`	=	\"".$this->model->getIsActive."\",
					`isNew`		=	\"".$this->model->getIsNew."\",
					`isDraft`	=	\"".$this->model->getIsDraft."\",
					`isUpdate`	=	\"".$this->model->getIsUpdate."\",
					`isDelete`	=	\"".$this->model->getIsDelete."\",
					`isApproved`=	\"".$this->model->getIsApproved."\",
					`executeBy`		=	\"".$this->model->getExecuteBy()."\",
					`Time		=	".$this->model->getTime."
			WHERE 	`leafId`	=	\"".$this->leafId."\"";
		} else if ($this->getVendor()==self::mssql) {
			$sql="
			UPDATE	[leaf]
			SET		[isActive]	=	\"".$this->model->getIsActive."\",
					[isNew]		=	\"".$this->model->getIsNew."\",
					[isDraft]	=	\"".$this->model->getIsDraft."\",
					[isUpdate]	=	\"".$this->model->getIsUpdate."\",
					[isDelete]	=	\"".$this->model->getIsDelete."\",
					[isApproved]=	\"".$this->model->getIsApproved."\",
					[executeBy]		=	\"".$this->model->getExecuteBy()."\",
					[executeTime]		=	".$this->model->getTime."
			WHERE 	[leafId]	=	\"".$this->leafId."\"";

		} else if ($this->getVendor()==self::oracle) {
			$sql="
			UPDATE	LEAF
			SET		ISACTIVE	=	\"".$this->model->getIsActive."\",
					ISNEW		=	\"".$this->model->getIsNew."\",
					ISDRAFT		=	\"".$this->model->getIsDraft."\",
					ISUPDATE	=	\"".$this->model->getIsUpdate."\",
					ISDELETE	=	\"".$this->model->getIsDelete."\",
					ISAPPROVED	=	\"".$this->model->getIsApproved."\",
					EXECUTEBY			=	\"".$this->model->getExecuteBy()."\",
					EXECUTETIME		=	".$this->model->getTime."
			WHERE 	LEAFID		=	\"".$this->leafId."\"";

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
			UPDATE	`leaf`
			SET		`isActive`	=	\"".$this->model->getIsActive."\",
					`isNew`		=	\"".$this->model->getIsNew."\",
					`isDraft`	=	\"".$this->model->getIsDraft."\",
					`isUpdate`	=	\"".$this->model->getIsUpdate."\",
					`isDelete`	=	\"".$this->model->getIsDelete."\",
					`isApproved`=	\"".$this->model->getIsApproved."\",
					`executeBy`		=	\"".$this->model->getExecuteBy()."\",
					`Time		=	".$this->model->getTime."
			WHERE 	`leafId`	=	\"".$this->leafId."\"";
		} else if ($this->getVendor()==self::mssql) {
			$sql="
			UPDATE	[leaf]
			SET		[isActive]	=	\"".$this->model->getIsActive."\",
					[isNew]		=	\"".$this->model->getIsNew."\",
					[isDraft]	=	\"".$this->model->getIsDraft."\",
					[isUpdate]	=	\"".$this->model->getIsUpdate."\",
					[isDelete]	=	\"".$this->model->getIsDelete."\",
					[isApproved]=	\"".$this->model->getIsApproved."\",
					[executeBy]		=	\"".$this->model->getExecuteBy()."\",
					[executeTime]		=	".$this->model->getTime."
			WHERE 	[leafId]	=	\"".$this->leafId."\"";

		} else if ($this->getVendor()==self::oracle) {
			$sql="
			UPDATE	LEAF
			SET		ISACTIVE	=	\"".$this->model->getIsActive."\",
					ISNEW		=	\"".$this->model->getIsNew."\",
					ISDRAFT		=	\"".$this->model->getIsDraft."\",
					ISUPDATE	=	\"".$this->model->getIsUpdate."\",
					ISDELETE	=	\"".$this->model->getIsDelete."\",
					ISAPPROVED	=	\"".$this->model->getIsApproved."\",
					EXECUTEBY			=	\"".$this->model->getExecuteBy()."\",
					EXECUTETIME		=	".$this->model->getTime."
			WHERE 	LEAFID		=	\"".$this->leafId."\"";

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
	 *  Read Record From accordionTranslate Table
	 */
	function translateRead() {
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			/**
			 *	UTF 8
			 **/
			$sql	=	"SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		if( $this->q->vendor='mysql'){
			$sql="
			SELECT	*
			FROM 	`leafTranslate`
			JOIN 	`language`
			USING (`languageId`)
			WHERE	`leafTranslate`.`leafId`=\"".$this->strict($_POST['leafId'],'numeric')."\"";
		} else if ($this->getVendor()==self::mssql){
			$sql="
			SELECT	*
			FROM 	[leafTranslate]
			JOIN 	[language]
			ON 		[leafTranslate].[languageId] =[language].[languageId]
			WHERE	[leafTranslate].[leafId]=\"".$this->strict($_POST['leafId'],'numeric')."\"";
		} else if ($this->getVendor()==self::oracle){
			$sql="
			SELECT	*
			FROM 	\"leafTranslate\"
			JOIN 	LANGUAGE
			USING (LANGUAGEID)
			WHERE	\"leafTranslate\".LEAFID=\"".$this->strict($_POST['leafId'],'numeric')."\"";
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
	 * Update Leaf Translation in accordionTranslate Table
	 */
	public function translateUpdate(){
		header('Content-Type','application/json; charset=utf-8');

		$this->q->commit();
		if($this->getVendor() == self::mysql){
			$sql="
		UPDATE	`leafTranslate`
		SET		`leafTranslate` 	=	\"".$this->strict($_POST['leafTranslate'],'string')."\"
		WHERE 	`leafTranslateId`	=	\"".$this->strict($_POST['TranslateId'],'numeric')."\"";
		} else if ($this->getVendor()==self::mssql){
			$sql="
		UPDATE	[leafTranslate]
		SET		[leafTranslate] 	=	\"".$this->strict($_POST['leafTranslate'],'string')."\"
		WHERE 	[leafTranslateId]	=	\"".$this->strict($_POST['leafTranslateId'],'numeric')."\"";
		} else if ($this->getVendor()==self::oracle){
			$sql="
		UPDATE	\"leafTranslate\"
		SET		\"leafTranslate\" 		=	\"".$this->strict($_POST['leafTranslate'],'string')."\"
		WHERE 	\"leafTranslateId\"	=	\"".$this->strict($_POST['accordionTranslateId'],'numeric')."\"";
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
	/**
	 * Create Translation leaf Note to the leafTranslate Table
	 */
	function translateMe() {
		//	header('Content-Type','application/json; charset=utf-8');
		$this->q->start();
		if($this->getVendor() == self::mysql){
			$sql="SELECT * FROM `leaf` WHERE `leafId`=\"".$this->leafId."\"";
		} else if($this->getVendor()==self::mssql){
			$sql="SELECT * FROM [leaf] WHERE [leafId]=\"".$this->leafId."\"";
		} else if($this->getVendor()==self::oracle){
			$sql="SELECT * FROM LEAF WHERE LEAFID=\"".$this->leafId."\"";
		}

		$resultDefault= $this->q->fast($sql);
		if($this->q->numberRows($resultDefault) > 0 ) {
			$rowDefault = $this->q->fetchAssoc($resultDefault);
			$value 		= $rowDefault['leafNote'];
		}
		if($this->getVendor() == self::mysql) {
			$sql="SELECT * FROM `language`";
		} else if ($this->getVendor()==self::mssql) {
			$sql="SELECT * FROM [language] ";
		} else if ($this->getVendor()==self::oracle) {
			$sql="SELECT * FROM LANGUAGE ";
		}
		$result= $this->q->fast($sql);
		while ($row = $this->q->fetchAssoc($result)) {
			$languageId = $row['languageId'];
			$languageCode = $row['languageCode'];
			$to 		  =	$languageCode;
			$googleTranslate = $this->security->changeLanguage($from="en",$to,$value);
			if($this->getVendor() == self::mysql) {
				$sql="
				SELECT 	*
				FROM 	`leafTranslate`
				WHERE 	`leafId`		=	\"".$this->leafId."\"
				AND 	`languageId`	=	\"".$languageId."\"";
			} else if ($this->getVendor()==self::mssql) {
				$sql="
				SELECT 	*
				FROM 	[leafTranslate]
				WHERE 	[leafId]		=	\"".$leafId."\"
				AND 	[languageId]	=	\"".$languageId."\"";
			}  else if ($this->getVendor()==self::oracle) {
				$sql="
				SELECT 	*
				FROM 	\"leafTranslate\"
				WHERE 	LEAFID		=	\"".$this->leafId."\"
				AND 	LANGUAGEID=\"".$languageId."\"";
			}
			$resultleafTranslate = $this->q->fast($sql);
			if($this->q->numberRows($resultleafTranslate) >  0 ) {

				if($this->q->vendor=='normal'  ||$this->getVendor() == self::mysql) {
					$sql="
					UPDATE 	`leafTranslate`
					SET 	`leafTranslate`	=	\"".$googleTranslate."\"
					WHERE 	`leafId`		=	\"".$this->leafId."\"
					AND		`languageId`	=	\"".$languageId."\"";
				} else if ($this->getVendor()==self::mssql) {
					$sql="
					UPDATE 	[leafTranslate]
					SET 	[leafTranslate]	=	\"".$googleTranslate."\"
					WHERE 	[leafId]		=	\"".$this->leafId."\"
					AND 	[languageId]	=	\"".$languageId."\"";
				} else if ($this->getVendor()==self::oracle) {
					$sql="
					UPDATE 	\"leafTranslate\"
					SET 	\"leafTranslate\"	=	\"".$googleTranslate."\"
					WHERE 	LEAFID			=	\"".$this->leafId."\"
					AND 	LANGUAGEID		=	\"".$languageId."\"";
				}
				$this->q->update($sql);
				if($this->q->execute=='fail') {
					echo json_encode(array("success"=>"false","message"=>$this->q->responce));
					exit();

				}
			} else {
				if($this->q->vendor=='normal'  ||$this->getVendor() == self::mysql) {
					$sql="
					INSERT INTO `leafTranslate`
							(
								`leafId`,
								`languageId`,
								`leafTranslate`
							)
					VALUES
							(
								\"".$this->leafId."\",
								\"".$languageId."\",
								\"".$googleTranslate."\"
							)";
				} else if ($this->getVendor()==self::mssql) {
					$sql="
					INSERT INTO [leafTranslate]
							(
								[leafId],
								[languageId],
								[leafTranslate]
							)
					VALUES
							(
								\"".$this->leafId."\",
								\"".$languageId."\",
								\"".$googleTranslate."\"
							)";
				} else if ($this->getVendor()==self::oracle) {
					$sql="
					INSERT INTO \"leafTranslate\"
							(
								LEAFID,
								LANGUAGEID,
								\"leafTranslate\"
							) VALUES(
								\"".$leafId."\",
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
		echo json_encode(array(
							  	"success"	=>	"true",
								"message"	=>	"Translation Complete"
								));
								exit();

	}

	public function nextSequence() {
		$this->security->nextSequence();


	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
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
		$this->excel->getActiveSheet()->setCellValue('C3','Name');
		$this->excel->getActiveSheet()->setCellValue('D3','Description');
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');
		//
		$loopRow=4;
		$this->q->numberRows();
		$i=0;
		while($row  = 	$this->q->fetchAssoc()) {
			//	echo print_r($row);

			$this->excel->getActiveSheet()->setCellValue('B'.$loopRow,++$i);
			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['leafNote']);
			$this->excel->getActiveSheet()->setCellValue('D'.$loopRow,$row['leafCode']);
			$loopRow++;
			$lastRow='D'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;

		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="leaf".rand(0,10000000).".xlsx";
		$path=$_SERVER['document_root']."/".$this->application."/security/document/excel/".$filename;
		$objWriter->save($path);

		$file = fopen($path,'r');
		if($file){
			echo json_encode(array("success"=>"true","message"=>"File generated"));
		} else {
			echo json_encode(array("success"=>"false","message"=>"File not generated"));

		}
	}



}
//echo "string".$_GET['leafId'];

$leafObject 		= 	new leafClass();

/**
 *	crud -create,read,update,delete
 **/
if(isset($_POST['method']))	{
	/*
	 *  Initilize Value before load in the loader
	 */

	if(isset($_POST['leafId_temp'])){
		$leafObject->leafId_temp = $_POST['leafId_temp'];
	}
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_POST['leafId'])) {
		$leafObject-> leafId = $_POST['leafId'];
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$leafObject->setIsAdmin($_POST['isAdmin']);
	}
	/*
	 *  Filtering
	 */

	if(isset($_POST['query'])){
		$leafObject->setFieldQuery($_POST['query']);
	}
	if(isset($_POST['filter'])){
		$leafObject->setGridQuery($_POST['filter']);
	}
	/*
	 *  Ordering
	 */
	if(isset($_POST['order'])){
		$leafObject->setOrder($_POST['order']);
	}
	if(isset($_POST['sortField'])){
		$leafObject->setSortField($_POST['sortField']);
	}


	/*
	 *  Load the dynamic value
	 */
	$leafObject-> execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_POST['method']=='create')	{
		$leafObject->create();
	}

	if($_POST['method']=='read') 	{

			$leafObject->read();

	}

	$leafObject->leafId = $_POST['leafId'];

	if($_POST['method']=='save') 	{

				$leafObject->update();

	}
	if($_POST['method']=='delete') 	{
		$leafObject->delete();
	}

}

if(isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_GET['leafId_temp'])){
		$leafObject->leafId_temp  = $_GET['leafId_temp'];
	}
	if(isset($_GET['leafId'])){
		$leafObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])) {
		$leafObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$leafObject->execute();

	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {
			$leafObject->staffId();
		}
		if($_GET['field']=='accordionId'){
			$leafObject->accordion();
		}
		if($_GET['field']=='folderId'){
			$leafObject->folder();
		}
		if($_GET['field']=='sequence'){

			$leafObject->nextSequence();
		}
	}

	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$leafObject->excel();
		}
	}
	if($_GET['method']=='translate'){
		$leafObject->translateMe();
	}
}

?>
