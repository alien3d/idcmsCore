<?php	session_start();
require_once("../../class/classAbstract.php");
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
	 * Current Table Group Indentification Value
	 * @var numeric $groupId
	 */
	public $groupId;
	/**
	 * Last Insert Record
	 * @var numeric $insert_id
	 */
	private $insert_id;
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

	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create() 				{
		header('Content-Type','application/json; charset=utf-8');
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->read($sql);
			if($this->q->execute=='fail'){
				echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
				exit();
			}
		}
		$this->q->start();
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			$sql="INSERT INTO `group` (

								`groupNote`
								`isNew`,
								`isActive`)
				VALUES	(		   '".$this->strict($_POST['groupNote'],'string')."'
								1,1);";
		}  else if ( $this->q->vendor=='microsoft') {
			$sql="INSERT INTO [group] (

								[groupNote],
								[isNew],
								[isActive])
				VALUES	(		   '".$this->strict($_POST['groupNote'],'string')."'
								1,1);";
		}  else if ($this->q->vendor=='oracle') {
			$sql="INSERT INTO \"group\" (

								\"groupNote\",
								\"isNew\",
								\"isActive\")
				VALUES	(		   '".$this->strict($_POST['groupNote'],'string')."'
								1,1);";

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
			echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
			exit();
		}
		$data = $this->q->active_record();
		if($this->q->numberRows()> 0 ){
			foreach($data as $row){
				if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
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
				} else if ($this->q->vendor=='microsoft') {
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
				} else if ($this->q->vendor=='oracle') {
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
			echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
			exit();
		}
	}
}

// loop the folder and create new record;
if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
	$sql		=	"
		SELECT 	*
		FROM 	`folder`
		WHERE 	`isActive`=1";
}	else if ($this->q->vendor=='microsoft') {
	$sql		=	"
		SELECT 	*
		FROM 	[folder]
		WHERE 	[isActive]=1";
} else if ( $this->q->vendor=='oracle') {
	$sql		=	"
		SELECT 	*
		FROM 	\"folder\"
		WHERE 	\"isActive\"=1";
}
$this->q->read($sql);
if($this->q->execute=='fail'){
	echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
	exit();
}
if($this->q->numberRows()> 0 ){
	$data = $this->q->active_record();
	foreach($data as $row){

		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
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
		} else if ($this->q->vendor=='microsoft') {
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
		} else if ($this->q->vendor=='oracle') {
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
			echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
			exit();
		}
	}
}

// create a template access which user can access to
if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
	$sql			=	"SELECT * FROM `leaf` WHERE `isActive`=1  ";
} else if ($this->q->vendor=='microsoft') {
	$sql			=	"SELECT * FROM [leaf] WHERE [isActive]=1  ";
} else if ($this->q->vendor=='oracle') {
	$sql			=	"SELECT * FROM \"leaf\" WHERE \"isActive\"=1  ";
}
$this->q->read($sql);
$total = $this->q->numberRows();
if($this->q->execute=='fail'){
	echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
	exit();
}
if($total > 0 ){
	$data = $this->q->active_record();
	foreach($data as $row){
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
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
		} else if ($this->q->vendor=='microsoft') {
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
		} else if ($this->q->vendor=='oracle') {
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
			echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
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
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->read($sql);
			if($this->q->execute=='fail'){
				echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
				exit();
			}
		}
		// everything given flexibility  on todo
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			$sql="
		SELECT	*
		FROM 	`group`
		WHERE 	`group`.`isActive`=1 ";
			if($_POST['groupId']) {
				$sql.=" AND `group`.`groupId`='".$this->strict($_POST['groupId'],'numeric')."'";
			}
		} else if ($this->q->vendor=='microsoft') {
			$sql="
		SELECT	*
		FROM 	[group]

		WHERE 	[group].[isActive]=1 ";
			if($_POST['groupId']) {
				$sql.=" AND [group].[groupId]='".$this->strict($_POST['groupId'],'numeric')."'";
			}
		} else if ($this->q->vendor=='oracle') {
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
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->read($sql);
			if($this->q->execute=='fail'){
				echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
				exit();
			}
		}
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			$sql="
				UPDATE 	`group`
				SET 	`groupNote`		=	'".$this->strict($_POST['groupNote'],'string')."',
				AND		`isUpdate`		=	1
				AND		`isActive`		=	1
				AND		`isNew`			=	0
				WHERE 	`groupId`		=	'".$this->strict($_POST['groupId'],'numeric')."'";
		} else if ($this->q->vendor=='microsoft') {
			$sql="
				UPDATE 	[group]
				SET 	[groupNote]		=	'".$this->strict($_POST['groupNote'],'string')."',
				AND		[isUpdate]		=	1
				AND		[isActive]		=	1
				AND		[isNew]			=	0
				WHERE 	[groupId]		=	'".$this->strict($_POST['groupId'],'numeric')."'";
		} else if ($this->q->vendor=='oracle') {
			$sql="
				UPDATE 	\"group\"
				SET 	\"groupNote\"		=	'".$this->strict($_POST['groupNote'],'string')."',
				AND		\"isUpdate\"		=	1
				AND		\"isActive\"		=	1
				AND		\"isNew\"			=	0
				WHERE 	\"groupId\"		=	'".$this->strict($_POST['groupId'],'numeric')."'";
		}
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
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
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->read($sql);
			if($this->q->execute=='fail'){
				echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
				exit();
			}
		}
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			$sql="
				UPDATE 	`group`
				SET 	`groupNote`		=	'".$this->strict($_POST['groupNote'],'string')."',
				AND		`isDelete`		=	1
				AND		`isActive`		=	0
				AND		`isNew`			=	0
				WHERE 	`groupId`		=	'".$this->strict($_POST['groupId'],'numeric')."'";
		} else if ($this->q->vendor=='microsoft') {
			$sql="
				UPDATE 	[group]
				SET 	[groupNote]		=	'".$this->strict($_POST['groupNote'],'string')."',
				AND		[isDelete]		=	1
				AND		[isActive]		=	0
				AND		[isNew]			=	0
				WHERE 	[groupId]		=	'".$this->strict($_POST['groupId'],'numeric')."'";

		} else if ($this->q->vendor=='oracle') {
			$sql="
				UPDATE 	\"group\"
				SET 	\"groupNote\"		=	'".$this->strict($_POST['groupNote'],'string')."',
				AND		\"isDelete\"		=	1
				AND		\"isActive\"		=	0
				AND		\"isNew\"			=	0
				WHERE 	\"groupId\"			=	'".$this->strict($_POST['groupId'],'numeric')."'";

		}
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
			exit();
		}
		$this->q->commit();

		echo json_encode(array("success"=>"true","message"=>"Record Remove"));
		exit();

	}
	/**
	 * Enter description here ...
	 */
	function translateMe() {

		$this->q->start();

		$sql="SELECT * FROM `group` WHERE `groupId`='".$this->groupId."'";
		$resultDefault= $this->q->fast($sql);
		if($this->q->numberRows($resultDefault) > 0 ) {
			$rowDefault = $this->q->fetch_array($resultDefault);
			$value 		= $rowDefault['groupNote'];
		}
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			$sql="SELECT * FROM `language`";
		} else if ($this->q->vendor=='microsoft') {
			$sql="SELECT * FROM [language] ";
		} else if ($this->q->vendor=='oracle') {
			$sql="SELECT * FROM \"language\" ";
		}
		$result= $this->q->fast($sql);
		while ($row = $this->q->fetchAssoc($result)) {
			$languageId = $row['languageId'];
			$languageCode = $row['languageCode'];
			$to 		  =	$languageCode;
			$googleTranslate = $this->changeLanguage($from="en",$to,$value);
			if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
				$sql="SELECT * FROM `groupTranslate` WHERE `groupId`='".$groupId."' AND `languageId`='".$languageId."'";
			} else if ($this->q->vendor=='microsoft') {
				$sql="SELECT * FROM [groupTranslate] WHERE [groupId]='".$groupId."' AND [languageId]='".$languageId."'";
			}  else if ($this->q->vendor=='oracle') {
				$sql="SELECT * FROM \"groupTranslate\" WHERE \"groupId\"='".$groupId."' AND \"languageId\"='".$languageId."'";
			}
			$resultgroupTranslate = $this->q->fast($sql);
			if($this->q->numberRows($resultgroupTranslate) >  0 ) {
				if($this->q->vendor=='normal'  || $this->q->vendor=='lite') {
					$sql="UPDATE `groupTranslate` SET `groupTranslate`='".$googleTranslate."' WHERE `groupTranslateId`='".$groupTranslateId."' and `languageId`='".$languageId."'";
				} else if ($this->q->vendor=='microsoft') {
					$sql="UPDATE [groupTranslate] SET [groupTranslate]='".$googleTranslate."' WHERE [groupTranslateId]='".$groupTranslateId."' and [languageId]='".$languageId."'";
				} else if ($this->q->vendor=='oracle') {
					$sql="UPDATE \"groupTranslate\" SET \"groupTranslate\"='".$googleTranslate."' WHERE \"groupTranslateId\"='".$groupTranslateId."' and \"languageId\"='".$languageId."'";
				}
				$this->q->update($sql);
				if($this->q->execute=='fail') {
					echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
					exit();

				}
			} else {
				if($this->q->vendor=='normal'  || $this->q->vendor=='lite') {
					$sql="INSERT INTO `groupTranslate` (`groupId`,`languageId`,`groupTranslate`) VALUES('".$groupId."','".$languageId."','".$googleTranslate."')";
				} else if ($this->q->vendor=='microsoft') {
					$sql="INSERT INTO [groupTranslate] ([groupId],[languageId],[groupTranslate]) VALUES('".$groupId."','".$languageId."','".$googleTranslate."')";
				} else if ($this->q->vendor=='oracle') {
					$sql="INSERT INTO \"groupTranslate\" (\"groupId\",\"languageId\",\"groupTranslate\") VALUES('".$groupId."','".$languageId."','".$googleTranslate."')";
				}
				$this->q->create($sql);
				if($this->q->execute=='fail') {
					echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
					exit();

				}
			}
		}
		$this->q->commit();


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
