<?php	session_start();
require_once("../../class/classAbstract.php");
require_once ("../../class/classValidation.php");
require_once ("../../class/classAudit.php");
require_once("../model/accordionModel.php");
require_once("../../class/class_security.php");

/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package accordion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class accordionClass extends  configClass{

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
	 * @var string $doc_$trail;
	 */
	private  $doc_trail;

	/**
	 *  Ascending ,Descending ASC,DESC
	 * @var string $order;`
	 */
	public $order;

	/**
	 * Sort the default field.Mostly consider as primary key default.
	 * @var string $sort_field
	 */
	public $sort_field;
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
	 * Current Table Accordion Indentification Value
	 * @var numeric $accordionId
	 */
	public $accordionId;
	/**
	 * Common class function for security menu
	 * @var  string $security
	 */
	private $security;
	/**
	 * Accordion Model
	 * @var string $religionModel
	 */
	public $model;
	/**
	 * Outside Variable from $_GET,POST validation
	 * @var string $validation
	 */
	public $validation;

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

		$this->log					=   1;

		$this->q->log 				= 	$this->log;

		$this->defaultLanguageId  	=	21;

		$this->security 	= 	new security();
		$this->security->vendor = $this->vendor;
		$this->security->leafId = $this->leafId;
		$this->security->execute();
		$this->model = new accordionModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->audit = new auditClass();
		$this->validation = new validationClass();

	}

	function create() 							{
		header('Content-Type','application/json; charset=utf-8');

		if($this->q->vendor	==	'normal' || $this->q->vendor	==	'lite') {

			//UTF8
			$sql	=	'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		$this->q->start();


		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {

			$sql="
			INSERT INTO `accordion`
					(
						`iconId`,							`accordionSequence`,	
						`accordionNote`,					`isNew`,
						`isDraft`,							`isUpdate`,	
						`isDelete`,							`isActive`,
						`isApproved`,						`By`,
						`Time`
					)
			VALUES
					(
						'".$this->model->iconId."',			'".$this->model->accordionSequence."',
						'".$this->model->accordionNote."',	'".$this->model->isNew."',
						'".$this->model->isDraft."',		'".$this->model->isUpdate."'
						'".$this->model->isDelete."',		'".$this->model->isActive."'
						'".$this->model->isApproved."'		'".$this->model->By."'
						".$this->model->Time."
					);";
		}  else if ($this->q->vendor=='microsoft') {

			$sql="
			INSERT INTO [accordion]
					(
						[iconId],							[accordionSequence],	
						[accordionNote],					[isNew],
						[isDraft],							[isUpdate],	
						[isDelete],							[isActive],
						[isApproved],						[By],
						[Time]
					)
			VALUES
					(
						'".$this->model->iconId."',			'".$this->model->accordionSequence."',
						'".$this->model->accordionNote."',	'".$this->model->isNew."',
						'".$this->model->isDraft."',		'".$this->model->isUpdate."'
						'".$this->model->isDelete."',		'".$this->model->isActive."'
						'".$this->model->isApproved."'		'".$this->model->By."'
						".$this->model->Time."
						);";
		}  else if ($this->q->vendor=='oracle') {

			$sql="
			INSERT INTO \"accordion\"
					(
						iconId\"							\"accordionSequence\",	
						\"accordionNote\",					\"isNew\"
						\"isDraft\",							\"isUpdate\"	
						\"isDelete\",							\"isActive\",
						\"isApproved\",						\"By\",
						\"Time\"
					)
			VALUES
					(
						'".$this->model->iconId."',			'".$this->model->accordionSequence."',
						'".$this->model->accordionNote."',	'".$this->model->isNew."',
						'".$this->model->isDraft."',		'".$this->model->isUpdate."'
						'".$this->model->isDelete."',		'".$this->model->isActive."'
						'".$this->model->isApproved."'		'".$this->model->By."'
						".$this->model->Time."
					);";
		}

		$this->q->create($sql);

		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
			exit();
		}

		if($this->q->vendor	==	'normal' || $this->q->vendor	==	'lite' ) {
			/*
			 * 	If anything wrong use this instead  SELECT LAST_INSERT_ID();
			 **/
			$sql="
			SELECT	MAX(`accordionId`)	AS `lastId`
			FROM 	`accordion`";
		} else if ($this->q->vendor	==	'microsoft') {
			/*
			 *  If anything wrong use this insert SELECT @@IDENTITY
			 **/
			$sql="
			SELECT	MAX([accordionId]) AS [lastId] 
			FROM 	[accordion] ";
		} else if ( $this->q->vendor	==	'oracle') {
			/**
			 *  If anthing wrong use this instead  SELECT accordionIdSeq
			 */
			$sql="
			SELECT 	MAX(\"accordionId\") AS \"lastId\"
			FROM 	\"accordion\"";
		}

		$resultd 	=	$this->q->fast($sql);
		$rowLastId	= 	$this->q->fetchAssoc($resultd);
		$lastId 	=	$rowLastId['lastId'];




		//  create a record  in accordionAccess.update no effect
		// loop the group
		if($this->q->vendor	==	'normal' || $this->q->vendor	==	'lite' ) {

			$sql	=	"
			SELECT 	*
			FROM 	`group`
			WHERE 	`isActive`	=	1 ";

		} else if ($this->q->vendor	==	'microsoft') {

			$sql="
			SELECT 	*
			FROM 	[group]
			WHERE 	[isActive]	=	1 ";

		} else if ( $this->q->vendor	==	'oracle') {

			$sql="
			SELECT 	*
			FROM 	\"group\"
			WHERE 	`\"isActive\"	=	1 ";

		}

		$this->q->read($sql);
		if($this->q->execute=='fail') {
			echo json_encode(
			array(
					  	"success"	=>	"false",
						"message"	=>	$this->q->result_text
			));
			exit();
		}
		$data = $this->q->activeRecord();

		foreach($data as $row) {
			/**
			 *	By Default  No Access
			 **/
			if($this->q->vendor=='normal' || $this->q->vendor=='lite') {

				$sql	=	"
				INSERT INTO	`accordionAccess`
						(
							`accordionId`,
							`groupId`,
							`accordionAccessValue`
						) VALUES(
							'".$lastId ."',
							 '".$row['groupId']."',
							 '0'
						)";

			}  else if ($this->q->vendor=='microsoft') {

				$sql	=	"
				INSERT INTO	[accordionAccess]
						(
							[accordionId],
							[groupId],
							[accordionAccessValue]
					) VALUES(
						'".$lastId ."',
						'".$row['groupId']."',
						'0'
					)	";

			}  else if ( $this->q->vendor=='oracle'){

				$sql	=	"
				INSERT INTO	\"accordionAccess\"
						(
							\"accordionId\",
							\"groupId\",
							\"accordionAccessValue\"
					) VALUES(
							'".$lastId ."',
							 '".$row['groupId']."',
							 '0'
					)";
			}
			$this->q->update($sql);
			if($this->q->execute=='fail') {
				echo json_encode(
				array(
					  	"success"	=>	"false",
						"message"	=>	$this->q->result_text
				));
				exit();
			}
		}
		/**
		 *	 insert default value to detail table .English only
		 **/
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {

			$sql	= "
		 	INSERT INTO `leafTranslate`
		 		(
				 	`leafId`,
				 	`languageId`,
					`leafTranslate`
				) VALUES (
					'".$lastId. "',
					21,
					'".$_POST['accordionNote']."'
				);";

		} else if ($this->q->vendor=='microsoft') {

			$sql	= "
		 	INSERT INTO  [leafTranslate]
					(
					 	[leafId],
						[languageId],
						[leafTranslate]
					) VALUES (
						'".$lastId ."',
						21,
						'".$_POST['accordionNote']."'
					);";

		} else if ($this->q->vendor=='oracle') {

			$sql	= "
		 	INSERT INTO	\"leafTranslate\"
					(
					 	\"leafId\",
						\"languageId\",
						\"leafTranslate\"
					) VALUES (
						'".$lastId ."',
						21,
						'".$_POST['accordionNote']."'
					);";
		}

		$this->q->create($sql);
		if($this->q->execute	==	'fail') {
			echo json_encode(
			array(
				  		"success"	=>	"false",
						"message"	=>	$this->q->result_text
			));
			exit();
		}

		$this->q->commit();
		echo json_encode(
		array(
				  	"success"	=>	"true",
					"message"	=>	"Insert Sucess",
					"accordionId"=> $lastId
		));
		exit();


	}
	/* (non-PHPdoc)
	 * @see class/config::read()
	 */
	function read() 							{

		header('Content-Type','application/json; charset=utf-8');
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			/**
			 *	UTF 8
			 **/
			$sql	=	'SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		if($this->q->vendor	==	'normal' || $this->q->vendor	==	'lite') {

			$sql	=	"
			SELECT		*
			FROM 		`accordion`
			LEFT JOIN 	`icon`
			USING 		(`iconId`)
			WHERE 		`accordion`.`isActive`	=	1
			AND			`icon`.`isActive`		=	1 ";

			if(($this->accordionId)) {
				$sql.=	" AND `accordionId`='".$this->strict($this->accordionId,'numeric')."'";
			}

		} else if ( $this->q->vendor=='microsoft') {
			$sql	=	"
			SELECT		*
			FROM 		[accordion]
			LEFT JOIN 	[icon]
			ON 			[icon].[iconId] = [accordion].[iconId]
			WHERE 		[accordion].[isActive]	=	1
			AND			[icon].[iconId]			=	1";

			if($this->accordionId) {
				$sql.=	" AND `accordionId`='".$this->strict($this->accordionId,'numeric')."'";
			}

		} else if ($this->q->vendor=='oracle') {

			$sql	=	"
			SELECT		*
			FROM 		\"accordion\"
			LEFT JOIN 	\"icon\"
			USING 		(\"iconId\")
			WHERE 		\"accordion\".\"isActive\"	=	1
			AND			\"icon\".\"isActive\"		=	1";

			if($this->accordionId) {
				$sql.=	" AND \"accordionId\"='".$this->strict($this->accordionId,'numeric')."'";
			}

		}

		if($this->quickFilter) {
			/**
			 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
			 *  E.g  $filterArray=array('`leaf`.`leafId`');
			 *  @variables $filterArray;
			 */
			$filterArray =	array("accordionId","accordionTranslateId");
			/**
			 *	filter table
			 *  @variables $tableArray
			 */
			$tableArray	= array('accordion','accordionTranslate');
			if($this->q->vendor	==	'normal' || $this->q->vendor	==	'lite') {

				$sql.=	$this->q->quickSearch($tableArray,$filterArray);

			} else if ($this->q->vendor	==	'microsoft') {

				$tempSql	=	$this->q->quickSearch($tableArray,$filterArray);
				$sql.=	$tempSql;

			} else if ($this->q->vendor	==	'oracle') {

				$tempSql	=	$this->q->quickSearch($tableArray,$filterArray);
				$sql.=	$tempSql;

			}
		}
		/**
		 *	Extjs filtering mode
		 */
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {

			$sql.=$this->q->searching();

		} else if ($this->q->vendor=='microsoft') {

			$tempSql2=$this->q->searching();
			$sql.=$tempSql2;

		}else if ($this->q->vendor=='oracle') {

			$tempSql2=$this->q->searching();
			$sql.=$tempSql2;

		}

		$this->q->read($sql);

		if($this->q->execute=='fail') {

			echo json_encode(
			array(
					  	"success"	=>	false,
						"message"	=>	$this->q->result_text
			));
			exit();

		}
		$total	= $this->q->numberRows();

		if($this->order && $this->sort_field){
			if($this->q->vendor=='lite' || $this->q->vendor=='normal') {
				$sql.="	ORDER BY `".$sort_field."` ".$dir." ";
			} else if ($this->q->vendor=='microsoft') {
				$sql.="	ORDER BY [".$sort_field."] ".$dir." ";
			} else if ($this->q->vendor=='oracle') {
				$sql.="	ORDER BY \"".$sort_field."\"  ".$dir." ";
			}
		}

		$_SESSION['sql']	=	$sql; // push to session so can make report via excel and pdf
		$_SESSION['start'] 	= 	$_POST['start'];
		$_SESSION['limit'] 	= 	$_POST['limit'];

		if(empty($_POST['filter']))      {

			if(isset($_POST['start']) && isset($_POST['limit'])) {


				if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
					/**
					 *	Mysql,Postgress and IBM using LIMIT
					 **/
					$sql.=" LIMIT  ".$_POST['start'].",".$_POST['limit']." ";
				} else if ($this->q->vendor=='microsoft') {
					/**
					 *	 Sql Server and Oracle used row_number
					 *	 Parameterize Query We don't support
					 **/
					$sql	=	"
					WITH [accordionDerived] AS
					(
						SELECT *,
						ROW_NUMBER() OVER (ORDER BY [accordionId]) AS 'RowNumber'
						FROM [accordion]
						WHERE [accordion].[isActive] =1   ".$tempSql.$tempSql2."
					)
					SELECT		*
					FROM 		[accordionDerived]
					WHERE 		[RowNumber]
					BETWEEN	".$_POST['start']."
					AND 			".($_POST['start']+$_POST['limit']-1).";";


				}  else if ($this->q->vendor=='oracle') {
					/**
					 *  Oracle using derived table also
					 */


					$sql="
				SELECT *
				FROM ( SELECT	a.*,
										rownum r
				FROM (
							SELECT *
							FROM 	\"accordion\"
							WHERE \"isActive\"=1  ".$tempSql.$tempSql2.$orderBy."
						 ) a
				where rownum <= '".($_POST['start']+$_POST['limit']-1)."' )
				where r >=  '".$_POST['start']."'";

				}
			}
		}
		$this->q->read($sql);

		if($this->q->execute=='fail') {

			echo json_encode(
			array(
					  	"success"	=>	false,
						"message"	=>	$this->q->result_text
			));
			exit();

		}

		$items			= 	array();
		while($row  	= 	$this->q->fetchAssoc()) {
			$items[]	=	$row;
		}

		if($this->accordionId) {

			$json_encode = json_encode(
			array(
					  	'success'		=>	'true',
						'total' 		=> 	$total,
       					'data' => 	$items
			));
			$json_encode=str_replace("[","",$json_encode);
			$json_encode=str_replace("]","",$json_encode);
			echo $json_encode;
			exit();

		} else {

			echo json_encode(
			array(
						'success'		=>	'true',
						'total' 		=>	$total,
       					'data' => 	$items
			));
			exit();
		}
	}

	/* (non-PHPdoc)
	 * @see configClass::update()
	 */
	function update() 							{
		header('Content-Type','application/json; charset=utf-8');

		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {

			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}

		$this->q->start();
		$this->model->update();
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			$sql="
			UPDATE 	`accordion`
			SET 	`accordionSequence`	= 	'".$this->model->accordionSequence."',
					`accordionNote`		=	'".$this->model->accordionNote."',
					`iconId`			=	'".$this->model->iconId."',
					`isNew`				=	'".$this->model->isNew."',
					`isDraft`			=	'".$this->model->isDraft."',
					`isUpdate`			=	'".$this->model->isUpdate."',
					`isActive`			=	'".$this->model->isActive."',
					`By`				=	'".$this->model->By."',
					`Time`				=	".$this->model->Time."
			WHERE 	`accordionId`		=	'".$this->model->accordionId."'";
		} else if ($this->q->vendor=='microsoft') {

			$sql="
			UPDATE 	[accordion]
			SET 	[accordionSequence]	= 	'".$this->model->accordionSequence."',
					[accordionNote]		=	'".$this->model->accordionNote."',
					[iconId]			=	'".$this->model->iconId."',
					[isNew]				=	'".$this->model->isNew."',
					[isDraft]			=	'".$this->model->isDraft."',
					[isUpdate]			=	'".$this->model->isUpdate."',
					[isActive]			=	'".$this->model->isActive."',,
					[By]				=	'".$this->model->By."',
					[Time]				=	 ".$this->model->Time."
			WHERE 	[accordionId]		=	'".$this->model->accordionId."'";
		} else if ($this->q->vendor=='oracle') {

			$sql="
			UPDATE 	\"accordion\"
			SET 	\"accordionSequence\"	= 	'".$this->model->accordionSequence."',
					\"accordionNote\"		=	'".$this->model->accordionNote."',
					\"iconId\"				=	'".$this->model->iconId."',
					\"isNew\"				=	'".$this->model->isNew."',
					\"isDraft\"				=	'".$this->model->isDraft."',
					\"isUpdate\"			=	'".$this->model->isUpdate."',
					\"isActive\"			=	'".$this->model->isActive."',
					\"By\"					=	'".$this->model->By."',
					\"Time\"				=	".$this->model->Time."
			WHERE 	\"accordionId\"			=	'".$this->model->accordionId."'";
		}

		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(
			array(
					  	"success"	=>	"false",
						"message"	=>	$this->q->result_text
			));
			exit();
		}
		$this->q->commit();
		echo json_encode(
		array(
				  	"success"	=>	"success",
					"message"	=>	"update success"
					));
					exit();


	}

	/* (non-PHPdoc)
	 * @see configClass::delete()
	 */
	function delete()							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			//UTF8
			$sql	=	'SET NAMES "utf8"';
			$this->q->fast($sql);
				
		}
		$this->q->start();
		$this->model->delete();
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
					$sql="
			UPDATE 	`accordion`
			SET 	`accordionSequence`	= 	'".$this->model->accordionSequence."',
					`accordionNote`		=	'".$this->model->accordionNote."',
					`iconId`			=	'".$this->model->iconId."',
					`isNew`				=	'".$this->model->isNew."',
					`isDraft`			=	'".$this->model->isDraft."',
					`isUpdate`			=	'".$this->model->isUpdate."',
					`isActive`			=	'".$this->model->isActive."',
					`By`				=	'".$this->model->By."',
					`Time`				=	".$this->model->Time."
			WHERE 	`accordionId`		=	'".$this->model->accordionId."'";
		}  else if ($this->q->vendor=='microsoft') {
					$sql="
			UPDATE 	[accordion]
			SET 	[accordionSequence]	= 	'".$this->model->accordionSequence."',
					[accordionNote]		=	'".$this->model->accordionNote."',
					[iconId]			=	'".$this->model->iconId."',
					[isNew]				=	'".$this->model->isNew."',
					[isDraft]			=	'".$this->model->isDraft."',
					[isUpdate]			=	'".$this->model->isUpdate."',
					[isActive]			=	'".$this->model->isActive."',,
					[By]				=	'".$this->model->By."',
					[Time]				=	 ".$this->model->Time."
			WHERE 	[accordionId]		=	'".$this->model->accordionId."'";
		}  else if ($this->q->vendor=='oracle') {
			$sql="
			UPDATE 	\"accordion\"
			SET 	\"accordionSequence\"	= 	'".$this->model->accordionSequence."',
					\"accordionNote\"		=	'".$this->model->accordionNote."',
					\"iconId\"				=	'".$this->model->iconId."',
					\"isNew\"				=	'".$this->model->isNew."',
					\"isDraft\"				=	'".$this->model->isDraft."',
					\"isUpdate\"			=	'".$this->model->isUpdate."',
					\"isActive\"			=	'".$this->model->isActive."',
					\"By\"					=	'".$this->model->By."',
					\"Time\"				=	".$this->model->Time."
			WHERE 	\"accordionId\"			=	'".$this->model->accordionId."'";
		}
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
			exit();

		}
		$this->q->commit();
		echo json_encode(array("success"=>"true","message"=>"Delete Succes"));
		exit();

	}
	/**
	 *  Read Record From accordionTranslate Table
	 */
	function translateRead() {
		header('Content-Type','application/json; charset=utf-8');
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			/**
			 *	UTF 8
			 **/
			$sql	=	'SET NAMES "utf8"';
			$this->q->fast($sql);
				
		}
		if($this->q->vendor=='normal' || $this->q->vendor='lite'){
			$sql="
			SELECT	*
			FROM 	`accordionTranslate`
			JOIN 	`language`
			USING (`languageId`)
			WHERE	`accordionTranslate`.`accordionId`='".$this->strict($_POST['accordionId'],'numeric')."'";
		} else if ($this->q->vendor=='microsoft'){
			$sql="
			SELECT	*
			FROM 	[accordionTranslate]
			JOIN 	[language]
			ON 		[accordionTranslate].[languageId] =[language].[languageId]
			WHERE	[accordionTranslate].[accordionId]='".$this->strict($_POST['accordionId'],'numeric')."'";
		} else if ($this->q->vendor=='oralce'){
			$sql="
			SELECT	*
			FROM 	\"accordionTranslate\"
			JOIN 	\"language\"
			USING (\"languageId\")
			WHERE	\"accordionTranslate\".\"accordionId\"='".$this->strict($_POST['accordionId'],'numeric')."'";
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
		if($this->q->vendor=='normal' || $this->q->vendor=='lite'){
			$sql="
		UPDATE	`accordionTranslate`
		SET		`accordionTranslate` 	=	'".$this->strict($_POST['accordionTranslate'],'string')."'
		WHERE 	`accordionTranslateId`	=	'".$this->strict($_POST['accordionTranslateId'],'numeric')."'";
		} else if ($this->q->vendor=='microsoft'){
			$sql="
		UPDATE	[accordionTranslate]
		SET		[accordionTranslate] 	=	'".$this->strict($_POST['accordionTranslate'],'string')."'
		WHERE 	[accordionTranslateId]	=	'".$this->strict($_POST['accordionTranslateId'],'numeric')."'";
		} else if ($this->q->vendor=='oracle'){
			$sql="
		UPDATE	\"accordionTranslate\"
		SET		\"accordionTranslate\" 		=	'".$this->strict($_POST['accordionTranslate'],'string')."'
		WHERE 	\"accordionTranslateId\"	=	'".$this->strict($_POST['accordionTranslateId'],'numeric')."'";
		}
		$this->q->update($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
			exit();
		}

		$this->q->commit();
		echo json_encode(array("success"=>true,"message"=>"Record Update"));
		exit();
	}
	/**
	 * Create Translation Accordion Note to the accordionTranslate Table
	 */
	function translateMe() {
		header('Content-Type','application/json; charset=utf-8');
		$this->q->start();
		if($this->q->vendor	==	'normal'	||	$this->q->vendor	==	'lite') {

			$sql	=	"
			SELECT	*
			FROM 	`accordion`
			WHERE 	`accordionId`	=	'".$this->accordionId."'";

		} else if ($this->q->vendor=='microsoft') {
			$sql	=	"
			SELECT	*
			FROM 	[accordion]
			WHERE 	`accordionId`	=	'".$this->accordionId."'";
		} else if ($this->q->vendor=='oracle') {
			$sql	=	"
			SELECT	*
			FROM 	\"accordion\"
			WHERE 	`accordionId`	=	'".$this->accordionId."'";
		}

		$resultDefault= $this->q->fast($sql);

		if($this->q->numberRows($resultDefault) > 0 ) {
			$rowDefault	= $this->q->fetch_array($resultDefault);
			$value 		= $rowDefault['accordionNote'];

		}
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			$sql	=	"
			SELECT	*
			FROM 	`language`";
		} else if ($this->q->vendor=='microsoft') {
			$sql	=	"
			SELECT 	*
			FROM 	[language] ";
		} else if ($this->q->vendor=='oracle') {
			$sql	=	"
			SELECT 	*
			FROM 	\"language\" ";
		}

		$result	=	$this->q->fast($sql);
		while ($row	=	$this->q->fetchAssoc($result)) {
			$languageId 		= 	$row['languageId'];
			$languageCode 		=	$row['languageCode'];
			$to 		  		=	$languageCode;
			$googleTranslate	= 	$this->changeLanguage($from="en",$to,$value);
			if($this->q->vendor	==	'normal' || $this->q->vendor	==	'lite') {
				$sql	=	"
				SELECT	*
				FROM 	`accordionTranslate`
				WHERE 	`accordionId`			=	'".$this->accordionId."'
				AND 	`languageId`			=	'".$languageId."'";
			} else if ($this->q->vendor=='microsoft') {
				$sql="
				SELECT	*
				FROM 	[accordionTranslate]
				WHERE 	[accordionId]			=	'".$this->accordionId."'
				AND 	[languageId]			=	'".$languageId."'";
			}  else if ($this->q->vendor=='oracle') {
				$sql	=	"
				SELECT	*
				FROM 	\"accordionTranslate\"
				WHERE 	\"accordionId\"			=	'".$this->accordionId."'
				AND 	\"languageId\"			=	'".$languageId."'";
			}
			$resultaccordionTranslate = $this->q->fast($sql);

			if($this->q->numberRows($resultaccordionTranslate) >  0 ) {
				if($this->q->vendor	==	'normal'  || $this->q->vendor	==	'lite') {

					$sql	=	"
					UPDATE	`accordionTranslate`
					SET 	`accordionTranslate`		=	'".$googleTranslate."'
					WHERE 	`accordionId`				=	'".$this->accordiondId."'
					AND 	`languageId`				=	'".$languageId."'";

				} else if ($this->q->vendor	==	'microsoft') {

					$sql	=	"
					UPDATE	[accordionTranslate]
					SET 	[accordionTranslate]		=	'".$googleTranslate."'
					WHERE 	[accordionId]				=	'".$this->accordiondId."'
					AND		[languageId]				=	'".$languageId."'";


				} else if ($this->q->vendor=='oracle') {

					$sql	=	"
					UPDATE 	\"accordionTranslate\"
					SET 	\"accordionTranslate\"		=	'".$googleTranslate."'
					WHERE 	`accordionId`				=	'".$this->accordiondId."'
					AND 	`languageId`				=	'".$languageId."'";

				}

				$this->q->update($sql);

				if($this->q->execute=='fail') {
					echo json_encode(
					array(
							  	"success"	=>	"false",
								"message"	=>	$this->q->result_text
					));
					exit();

				}
			} else {
				if($this->q->vendor=='normal'  || $this->q->vendor=='lite') {

					$sql	=	"
					INSERT INTO	`accordionTranslate`
							(
							 	`accordionId`,
								`languageId`,
								`accordionTranslate`
							) VALUES(
								'".$this->accordionId."',
								'".$languageId."',
								'".$googleTranslate."'
					)";
				} else if ($this->q->vendor=='microsoft') {

					$sql	=	"
					INSERT INTO [accordionTranslate]
							(
							 	[accordionId],
								[languageId],
								[accordionTranslate]
							) VALUES(
								'".$this->accordionId."',
								'".$languageId."',
								'".$googleTranslate."'
							)";
				} else if ($this->q->vendor=='oracle') {

					$sql	=	"
					INSERT INTO \"accordionTranslate\"
							(
							 	\"accordionId\",
								\"languageId\",
								\"accordionTranslate\"
							) VALUES(
								'".$this->accordionId."',
								'".$languageId."',
								'".$googleTranslate."'
							)";
				}

				$this->q->create($sql);

				if($this->q->execute=='fail') {
					echo json_encode(
					array(
							  	"success"	=>	"false",
								"message"	=>	$this->q->result_text
					));
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
	public function nextSequence() {
		$this->security->nextSequence();

	}
	/* (non-PHPdoc)
	 * @see configClass::excel()
	 */
	function excel() {
		header('Content-Type','application/json; charset=utf-8');
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
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
		$this->excel->getActiveSheet()->setCellValue('C3','Name');
		$this->excel->getActiveSheet()->setCellValue('D3','Description');
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');
		//
		$loopRow=4;
		$i=0;
		while($row  = 	$this->q->fetch_array()) {
			//	echo print_r($row);

			$this->excel->getActiveSheet()->setCellValue('B'.$loopRow,++$i);
			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['accordionName']);
			$this->excel->getActiveSheet()->setCellValue('D'.$loopRow,$row['accordionDesc']);
			$loopRow++;
			$lastRow='D'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="accordion".rand(0,10000000).".xlsx";
		$path=$_SERVER['DOCUMENT_ROOT']."/".$this->application."/basic/document/excel/".$filename;
		$objWriter->save($path);
		$this->audit->createTrail($this->leafId, $path,$filename);
		$file = fopen($path,'r');
		if($file){
			echo json_encode(array("success"=>"true","message"=>"File generated"));
		} else {
			echo json_encode(array("success"=>"false","message"=>"File not generated"));

		}
	}

}


/**
 *	Declare object
 **/
$accordionObject  = 	new accordionClass();
if(isset($_SESSION['staffId'])){
	$accordionObject->staffId = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$accordionObject->vendor = $_SESSION['vendor'];
}

/**
 *	Form Property .CRUD -create,read,update,delete
 **/
if(isset($_POST['method']))	{
	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_POST['leafId'])){
		$accordionObject->leafId  = $_POST['leafId'];
	}
	if(isset($_POST['accordionId'])) {
		$accordionObject->accordionId = $_POST['accordionId'];
	}

	if(isset($_POST['filter'])){
		$accordionObject->filter = $_POST['filter'];
	}
	if(isset($_POST['query'])){
		$accordionObject->quickFilter = $_POST['query'];
	}
	if(isset($_POST['order'])){
		$accordionObject->order= $_POST['order'];
	}
	if(isset($_POST['sort_field'])){
		$accordionObject->sort_field= $_POST['sort_field'];
	}
	/*
	 *  Load the dynamic value
	 */
	$accordionObject->execute();
	if($_POST['method']=='create')	{
		$accordionObject->create();
	}
	if($_POST['method']=='read') 	{
		if(isset($_POST['page'])){
			if($_POST['page']=='master') {
				$accordionObject->read();
			}
			if($_POST['page']=='detail') {
				$accordionObject->translateRead();
			}

		}
	}

	if($_POST['method']=='save') 	{
		if(isset($_POST['page'])) {
			if($_POST['page']=='master') {
				$accordionObject->update();
			}
			if($_POST['page']=='detail') {
				$accordionObject->translateUpdate();
			}

		}
	}
	if($_POST['method']=='delete') 	{
		$accordionObject->delete();
	}

}

if(isset($_GET['method'])) {

	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_GET['leafId'])){
		$accordionObject-> leafId  = $_GET['leafId'];
	}
	if(isset($_GET['accordionId'])) {
		$accordionObject->accordionId = $_GET['accordionId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$accordionObject->execute();
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {
			$accordionObject->staffId();
		}
		if($_GET['field']=='sequence'){

			$accordionObject->nextSequence();
		}
	}
	if(isset($_GET['mode'])) {
		if($_GET['mode']=='report'){
			$accordionObject->excel();
		}
	}
	if($_GET['method']=='translate'){
		$accordionObject->translateMe();
	}
}

?>

