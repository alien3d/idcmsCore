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
	 * Current Table Group Indentification Value
	 * @var numeric $groupId
	 */
	public $groupId;
	/**
	 * Last Insert Record
	 * @var numeric $insert_id
	 */
	private $insert_id;
	
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
		header('Content-Type','application/json; charset=utf-8');
		if( $this->q->vendor==self::mysql) {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);
			
		}
		// everything given flexibility  on todo
		if( $this->q->vendor==self::mysql) {
			$sql="
		SELECT	*
		FROM 	`group`
		WHERE 	`group`.`isActive`=1 ";
			if($_POST['groupId']) {
				$sql.=" AND `group`.`groupId`='".$this->strict($_POST['groupId'],'numeric')."'";
			}
		} else if ($this->q->vendor==self::mssql) {
			$sql="
		SELECT	*
		FROM 	[group]

		WHERE 	[group].[isActive]=1 ";
			if($_POST['groupId']) {
				$sql.=" AND [group].[groupId]='".$this->strict($_POST['groupId'],'numeric')."'";
			}
		} else if ($this->q->vendor==self::oracle) {
			$sql="
		SELECT	*
		FROM 	\"group\"
		WHERE 	\"group\".\"isActive\"=1";
			if($_POST['groupId']) {
				$sql.=" AND \"group\".\"groupId\"='".$this->strict($_POST['groupId'],'numeric')."'";
			}
		}
		$filterArray=array('groupId','groupTranslateId');
		/**
			*	filter table
			* @variables $tableArray
			*/
		$tableArray = array('group','groupTranslate');
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		//$filterArray	=	array();
		if(isset($_GET['query'])) {
			$query = $_GET['query'];
		}  else if (isset($_POST['query'])) {
			$query = $_POST['query'];
		}
		if($query) {
			$sql.=$this->q->quickSearch($tableArray,$filterArray);
		}

		$record_all 	= $this->q->read($sql);
		$this->total	= $this->q->numberRows();
		//paging

		$sql.="	ORDER BY `groupId` ";
		if(isset($_POST['start']) && isset($_POST['limit'])) {
			$sql.=" LIMIT  ".$_POST['start'].",".$_POST['limit']." ";
		}



		$this->q->read($sql);

		while($row  = 	$this->q->fetch_array()) {
			$items[]=$row;
		}


			// bugs on extjs
			if($_POST['method']=='read' && $_POST['mode']=='update') {
				$json_encode = json_encode(
				array('success'=>'true',
				'total' => $this->total,
				'data' => $items
				));
				$json_encode=str_replace("[","",$json_encode);
				$json_encode=str_replace("]","",$json_encode);
				echo $json_encode;
				exit();
			} else {
				if(count($items)==0) {
					$items='';
				}
				echo json_encode(
				array('success'=>'true',
				'total' => $this->total,
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
					`isActive`		=	'".$this->model->isActive."',
					`isNew`			=	'".$this->model->isNew."',
					`isDraft`		=	'".$this->model->isDraft."',
					`isUpdate`		=	'".$this->model->isUpdate."',
					`isDelete`		=	'".$this->model->isDelete."',
					`isApproved`	=	'".$this->model->isApproved."',
					`By`			=	'".$this->model->By."',
					`Time			=	".$this->model->Time."
			WHERE 	`groupId`		=	'".$this->groupId."'";
		} else if ($this->q->vendor==self::mssql) {
			$sql="
			UPDATE 	[group]
			SET 	[groupDesc]		=	'".$this->model->groupDesc."',
					[isActive]		=	'".$this->model->isActive."',
					[isNew]			=	'".$this->model->isNew."',
					[isDraft]		=	'".$this->model->isDraft."',
					[isUpdate]		=	'".$this->model->isUpdate."',
					[isDelete]		=	'".$this->model->isDelete."',
					[isApproved]	=	'".$this->model->isApproved."',
					[By]			=	'".$this->model->By."',
					[Time]			=	".$this->model->Time."
			WHERE 	[groupId]		=	'".$this->groupId."'";
		} else if ($this->q->vendor==self::oracle) {
			$sql="
			UPDATE 	\"group\"
			SET 	\"groupDesc\"	=	'".$this->model->groupDesc."',
					\"isActive\"	=	'".$this->model->isActive."',
					\"isNew\"		=	'".$this->model->isNew."',
					\"isDraft\"		=	'".$this->model->isDraft."',
					\"isUpdate\"	=	'".$this->model->isUpdate."',
					\"isDelete\"	=	'".$this->model->isDelete."',
					\"isApproved\"	=	'".$this->model->isApproved."',
					\"By\"			=	'".$this->model->By."',
					\"Time\"		=	".$this->model->Time."
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
				UPDATE 	`group`
				SET 	`isActive`		=	'".$this->model->isActive."',
						`isNew`			=	'".$this->model->isNew."',
						`isDraft`		=	'".$this->model->isDraft."',
						`isUpdate`		=	'".$this->model->isUpdate."',
						`isDelete`		=	'".$this->model->isDelete."',
						`isApproved`	=	'".$this->model->isApproved."',
						`By`			=	'".$this->model->By."',
						`Time			=	".$this->model->Time."
				WHERE 	`groupId`		=	'".$this->groupId."'";
		} else if ($this->q->vendor==self::mssql) {
			$sql="
				UPDATE 	[group]
				SET 	[isActive]		=	'".$this->model->isActive."',
						[isNew]			=	'".$this->model->isNew."',
						[isDraft]		=	'".$this->model->isDraft."',
						[isUpdate]		=	'".$this->model->isUpdate."',
						[isDelete]		=	'".$this->model->isDelete."',
						[isApproved]	=	'".$this->model->isApproved."',
						[By]			=	'".$this->model->By."',
						[Time]			=	".$this->model->Time."
				WHERE 	[groupId]		=	'".$this->groupId."'";

		} else if ($this->q->vendor==self::oracle) {
			$sql="
				UPDATE 	\"group\"
				SET 	\"isActive\"	=	'".$this->model->isActive."',
						\"isNew\"		=	'".$this->model->isNew."',
						\"isDraft\"		=	'".$this->model->isDraft."',
						\"isUpdate\"	=	'".$this->model->isUpdate."',
						\"isDelete\"	=	'".$this->model->isDelete."',
						\"isApproved\"	=	'".$this->model->isApproved."',
						\"By\"			=	'".$this->model->By."',
						\"Time\"		=	".$this->model->Time."
				WHERE 	\"groupId\"		=	'".$this->groupId."'";

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
	
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {}




}


$groupObject  	= 	new groupClass();
if(isset($_SESSION['staffId'])){
	$groupObject->staffId = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$groupObject-> vendor = $_SESSION['vendor'];
}
/**
 *	crud -create,read,update,delete
 **/
if(isset($_POST['method']))	{
	if(isset($_POST['leafId'])){
		$groupObject-> leafId = $_POST['leafId'];
	}
	if($_POST['method']=='create')	{
		$groupObject->create();
	}
	if(isset($_POST['filter'])){
		$groupObject->filter = $_POST['filter'];
	}
	if(isset($_POST['query'])){
		$groupObject->query = $_POST['query'];
	}
	if(isset($_POST['order'])){
		$groupObject-> order= $_POST['order'];
	}
	if(isset($_POST['sort_field'])){
		$groupObject-> sort_field= $_POST['sort_field'];
	}
	if($_POST['method']=='read') 	{
		$groupObject->read();
	}
	if(isset($_POST['staffId'])) {
		$groupObject->staffId = $_POST['staffId'];
		if($_POST['method']=='save') 	{
			$groupObject->read();
		}
		if($_POST['method']=='delete') 	{
			$groupObject->delete();
		}
	}
}

if(isset($_GET['method'])) {
	if(isset($_GET['leafId'])){
		$groupObject-> leafId  = $_GET['leafId'];
	}
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {
			$groupObject->staffId();
		}
	}

	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$groupObject->excel();
		}
	}
}
?>
