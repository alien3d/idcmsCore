<?php	session_start();
require_once("../../class/class_abstract.php");
require_once("../../class/class_security.php");
/**
 * this is  folder security access
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package folder_security_access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */

class folderAccessClass  extends configClass {
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
	 * Current Table Folder Access Indentification Value
	 * @var numeric $folderAccessId
	 */
	public $folderAccessId;
	/**
	 * Accordion Indentification
	 * @var numeric $accordionId
	 */
	public  $accordionId;
	/**
	 *  Group Indentification
	 * @var numeric $groupId
	 */
	public $groupId;
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

		$this->security				= new security();

		$this->security->vendor = $this->vendor;
		$this->security->leafId = $this->leafId;
		$this->security->staffId = $this->staffId;
		$this->security->execute();
	}
	function create() {}
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
		// by default if add new group will add access to accordion and folder.
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			$sql="
				SELECT	`accordion`.`accordionName`,
						`accordion`.`accordionId`,
						`folder`.`folderId`,
						`folder`.`folderName`,
						`group`.`groupId`,
						`group`.`groupName`,
						`folderAccess`.`folderAccessId`,
						(CASE `folderAccess`.`folderAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `folderAccessValue`
				FROM 	`folderAccess`
				JOIN	`folder`
				USING 	(`folderId`)
				JOIN 	`group`
				USING 	(`groupId`)
				JOIN 	`accordion`
				USING	(`accordionId`)
				WHERE 	1
				AND		`folder`.`languageId`='".$_SESSION['languageId']."'";
			if($_GET['groupId']) {
				$sql.=" AND `group`.`groupId`='".$this->strict($_GET['groupId'],'numeric')."'";
			}
			if($_GET['accordionId']) {
				$sql.=" AND `folder`.`accordionId`='".$this->strict($_GET['accordionId'],'numeric')."'";
			}
		}  else if ( $this->q->vendor=='microsoft') {
			$sql="
				SELECT	[accordion].[accordionName],
						[accordion].[accordionId],
						[folder].[folderId],
						[folder].[folderName],
						[group].[groupId],
						[group].[groupName],
						[folderAccess].[folderAccessId],
						(CASE [folderAccess].[folderAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [folderAccessValue]
				FROM 	[folderAccess]
				JOIN	[folder]
				ON 		[folder].[folderId]=[folderAccess].[folderId]
				JOIN 	[group]
				ON 		[group].[groupId]=[folderAccess].[groupId]
				JOIN 	[accordion]
				ON		[folder].[accordionId]=[accordion].[accordionId]
				WHERE 	[folder].[isActive]=1
				AND		[group].[isActive]=1
				AND		[accordion].[accordionId]=1";
			if($_GET['groupId']) {
				$sql.=" AND [group].[groupId]='".$this->strict($_GET['groupId'],'numeric')."'";
			}
			if($_GET['accordionId']) {
				$sql.=" AND [folder].[accordionId]='".$this->strict($_GET['accordionId'],'numeric')."'";
			}
		}  else if ($this->q->vendor=='oracle') {
			$sql="
				SELECT	\"accordion\".\"accordionName\",
						\"accordion\".\"accordionId\",
						\"folder\".\"folderId\",
						\"folder\".\"folderName\",
						\"group\".\"groupId\",
						\"group\".\"groupName\",
						\"folderAccess\".\"folderAccessId\",
						(CASE	\"folderAccess\".\"folderAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"folderAccessValue\"
				FROM 	\"folderAccess\"
				JOIN	\"folder\"
				USING 	(\"folderId\")
				JOIN 	\"group\"
				USING 	(\"groupId\")
				JOIN 	\"accordion\"
				USING	(\"accordionId\")
				WHERE 	\"folder\".\"isActive\"		=	1
				AND		\"accordion\".`isActive\"	=	1
				AND		\"group\".`isActive\"		=	1";
			if($_GET['groupId']) {
				$sql.=" AND \"group\".\"groupId\"='".$this->strict($_GET['groupId'],'numeric')."'";
			}
			if($_GET['accordionId']) {
				$sql.=" AND \"folder\".\"accordionId\"='".$this->strict($_GET['accordionId'],'numeric')."'";
			}
		}
		//echo $sql;
		// searching filtering
		$sql.=$this->q->searching();

		$this->q->read($sql);
		$total	= $this->q->numberRows();
		//paging

		if(isset($_POST['start']) && isset($_POST['limit'])) {
			$sql.=" LIMIT  ".$_POST['start'].",".$_POST['limit']." ";
		}



		$this->q->read($sql);

		while($row  = 	$this->q->fetch_array()) {
			// select accordion access

			$items[]=$row;
			// select accordion access
		}

		if($this->q->execute=='fail') {
			$this->msg(false,$this->q->result_text);
			exit();
		}else {
			echo json_encode(
			array('success'=>'true',
			'total' => $this->total,
			'data' => $items
			));

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
		// first check the group.if exist update else create new one
		$folderAccessId		=	'folderAccessId';
		$folderAccessValue 	= 	'folderAccessValue';
		$loop=count($_GET[$folderAccessId]);

		for($i=0;$i<$loop;$i++) {
			// mysql doesn't support bolean expression
			if($_GET[$folderAccessValue][$i]=='true') {
				$_GET[$folderAccessValue][$i]=1;
			} else {
				$_GET[$folderAccessValue][$i]=0;
			}
			if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
				$sql="
					UPDATE 	`folderAccess`
					SET 	`folderAccessValue`		= 	'".$this->strict($_GET[$folderAccessValue][$i],'string')."'
					WHERE 	`folderAccessId`		=	'".$this->strict($_GET[$folderAccessId][$i],'numeric')."'";
				//	echo $sql."<br>";
			} else if($this->q->vendor=='microsoft') {
				$sql="
					UPDATE 	[folderAccess]
					SET 	[folderAccessValue]		= 	'".$this->strict($_GET[$folderAccessValue][$i],'string')."'
					WHERE 	[folderAccessId]		=	'".$this->strict($_GET[$folderAccessId][$i],'numeric')."'";
			} else if ($this->q->vendor=='oracle') {
				$sql="
					UPDATE 	\"folderAccess\"
					SET 	\"folderAccessValue\"	= 	'".$this->strict($_GET[$folderAccessValue][$i],'string')."'
					WHERE 	\"folderAccessId\"		=	'".$this->strict($_GET[$folderAccessId][$i],'numeric')."'";
			}
			$this->q->update($sql);
			if($this->q->execute=='fail') {
				echo json_encode(array("success"=>"false","message"=>$this->q->result_text));
				exit();

			}
		}
		echo json_encode(array("success"=>true,"message"=>"Update Success"));
		exit();


	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete() { }



	/**
	 * Enter description here ...
	 */
	function group() {

		$this->security->group();
	}
	/**
	 * Enter description here ...
	 */
	function accordion() {
		$this->security->accordion();
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel(){

	}






}



$folderAccessObject  	= 	new folderAccessClass();
if(isset($_SESSION['staffId'])){
	$folderAccessObject->staffId = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$folderAccessObject->vendor = $_SESSION['vendor'];
}
if(isset($_POST['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */

	if(isset($_POST['leafId'])){
		$folderAccessObject->leafId = $_POST['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$folderAccessObject->execute();
	if($_POST['method']=='read'){
		$folderAccessObject -> read();
	}
}
if(isset($_GET['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */
	if(isset($_GET['method'])){
		$folderAccessObject ->leafId = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$folderAccessObject->execute();
	if(isset($_GET['field'])){
		if($_GET['field']=='groupId') {
			$folderAccessObject->group();
		}
		if($_GET['field']=='accordionId'){
			$folderAccessObject->accordion();
		}
	}
}

?>
