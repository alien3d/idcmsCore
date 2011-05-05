<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../model/leafGroupAccessModel.php");
/**
 * this is  leaf security access
 * @name IDCMS
 * @version 2
 * @author hafizan,yusuf
 * @package leaf_group_security_access
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafGroupAccessClass  extends  configClass {
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
	 * Current Table Leaf Group Access Indentification Value
	 * @var numeric $leafGroupAccessId
	 */
	public $leafGroupAccessId;
	/**
	 * Common Security Function
	 * @var string $security
	 */
	private $security;

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

		$this->security 	= 	new security();


	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create(){

	}

	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() 				{
		header('Content-Type','application/json; charset=utf-8');
		if( $this->q->vendor=='mysql') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		// by default if add new group will add access to accordion and leaf.
		// just checking
		//	$this->checkLeaf();
		if( $this->q->vendor=='mysql') {
			$sql="
				SELECT	`leaf`.`accordionId`,
						`leaf`.`folderId`,
						`folder`.`folderName`,
						`leaf`.`leafName`,
						`accordion`.`accordionName`,
						`group`.`groupName`,
						`leafGroupAccess`.`leafId`,
						`leafGroupAccess`.`groupId`,
						`leafGroupAccess`.`leafGroupAccessId`,
						(CASE `leafGroupAccess`.`leafCreateAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafCreateAccessValue`,


						(CASE `leafGroupAccess`.`leafReadAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafReadAccessValue`,

						(CASE `leafGroupAccess`.`leafUpdateAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafUpdateAccessValue`,

						(CASE `leafGroupAccess`.`leafDeleteAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafDeleteAccessValue` ,

						(CASE `leafGroupAccess`.`leafPrintAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafPrintAccessValue`,

						(CASE `leafGroupAccess`.`leafPostAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafPostAccessValue`
				FROM 	`leafGroupAccess`
				JOIN	`leaf`
				USING	(`leafId`)
				JOIN	(`accordion`)
				USING	(`accordionId`)
				JOIN	(`folder`)
				USING	(`folderId`)
				JOIN	`group`
				USING	(`groupId`)
				WHERE 	`leaf`.`isActive`		=	1
				AND		`folder`.`isActive`		=	1
				AND		`accordion`.`isActive`	=	1
				AND		`group`.`isActive`		=	1";
			if($_GET['groupId']) {
				$sql.=" AND `leafGroupAccess`.`groupId`='".$this->strict($_GET['groupId'],'numeric')."'";

			}
			if($_GET['accordionId']) {
				$sql.=" AND `leaf`.`accordionId`='".$this->strict($_GET['accordionId'],'numeric')."'";
			}
			if($_GET['folderId']) {
				$sql.=" AND `leaf`.`folderId`='".$this->strict($_GET['folderId'],'numeric')."'";
			}
		} else if ($this->q->vendor=='microsoft') {
			$sql="
				SELECT	[leaf].[accordionId],
						[leaf].[folderId],
						[folder].[folderName],
						[leaf].[leafName],
						[accordion].[accordionName],
						[group].[groupName],
						[leafGroupAccess].[leafId],
						[leafGroupAccess].[groupId],
						[leafGroupAccess].[leafGroupAccessId],
						(CASE [leafGroupAccess].[leafCreateAccessValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafCreateAccessValue],


						(CASE [leafGroupAccess].[leafReadAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafReadAccessValue],

						(CASE [leafGroupAccess].[leafUpdateAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafUpdateAccessValue],

						(CASE [leafGroupAccess].[leafDeleteAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafDeleteAccessValue] ,

						(CASE [leafGroupAccess].[leafPrintAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafPrintAccessValue],

						(CASE [leafGroupAccess].[leafPostAccessValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafPostAccessValue]
				FROM 	[leafGroupAccess]
				JOIN	[leaf]
				ON		[leafGroupAccess].[leafId]=[leaf].[leafId]
				JOIN	[accordion]
				ON		[leaf].[accordionId]=[accordion].[accordionId]
				JOIN	[folder]
				ON		[leaf].[folderId] = [folder].[folderId]
				JOIN	[group]
				ON		[leafGroupAccess].[groupId]= [group].[groupId]
				WHERE 	[leaf].[isActive]		=	1
				AND		[folder].[isActive]		=	1
				AND		[accordion].[isActive]	=	1
				AND		[group].[isActive]		=	1";
			if($_GET['groupId']) {
				$sql.=" AND [leafGroupAccess].[groupId]='".$this->strict($_GET['groupId'],'numeric')."'";

			}
			if($_GET['accordionId']) {
				$sql.=" AND [leaf].[accordionId]='".$this->strict($_GET['accordionId'],'numeric')."'";
			}
			if($_GET['folderId']) {
				$sql.=" AND [leaf].[folderId]='".$this->strict($_GET['folderId'],'numeric')."'";
			}
		} else if ($this->q->vendor=='oracle') {
			$sql="
				SELECT	\"leaf\".\"accordionId\",
						\"leaf\".\"folderId\",
						\"folder\".\"folderName\",
						\"leaf\".\"leafName\",
						\"accordion\".\"accordionName\",
						\"group\".\"groupName\",
						\"leafGroupAccess\".\"leafId\",
						\"leafGroupAccess\".\"groupId\",
						\"leafGroupAccess\".\"leafGroupAccessId\",
						(CASE \"leafGroupAccess\".\"leafCreateAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafCreateAccessValue\",


						(CASE \"leafGroupAccess\".\"leafReadAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafReadAccessValue\",

						(CASE \"leafGroupAccess\".\"leafUpdateAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafUpdateAccessValue\",

						(CASE \"leafGroupAccess\".\"leafDeleteAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafDeleteAccessValue\" ,

						(CASE \"leafGroupAccess\".\"leafPrintAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafPrintAccessValue\",

						(CASE \"leafGroupAccess\".\"leafPostAccessValue\"
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS \"leafPostAccessValue\"
				FROM 	\"leafGroupAccess\"
				JOIN	\"leaf\"
				USING	(\"leafId\")
				JOIN	(\"accordion\")
				USING	(\"accordionId\")
				JOIN	(\"folder\")
				USING	(\"folderId\")
				JOIN	\"group\"
				USING	(\"groupId\")
				WHERE 	\"leaf\".\"isActive\"		=	1
				AND		\"folder\".\"isActive\"		=	1
				AND		\"accordion\".\"isActive\"	=	1
				AND		\"group\".\"isActive\"		=	1";
			if($_GET['groupId']) {
				$sql.=" AND \"leafGroupAccess\".\"groupId\"='".$this->strict($_GET['groupId'],'numeric')."'";

			}
			if($_GET['accordionId']) {
				$sql.=" AND \"leaf\".\"accordionId\"='".$this->strict($_GET['accordionId'],'numeric')."'";
			}
			if($_GET['folderId']) {
				$sql.=" AND \"leaf\".\"folderId\"='".$this->strict($_GET['folderId'],'numeric')."'";
			}
		}
		//echo $sql;
		// searching filtering
		$sql.=$this->q->searching();

		$record_all 	= $this->q->read($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
			exit();
		}
		$this->total	= $this->q->numberRows();
		//paging




		$this->q->read($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
			exit();
		}
		while($row  = 	$this->q->fetchAssoc()) {
			// select accordion access

			$items[]=$row;
			// select accordion access
		}


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

	function update() 				{
		header('Content-Type','application/json; charset=utf-8');
		if( $this->q->vendor=='mysql') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);
			
		}
		$data	= explode("|",$_POST['info']); // still using & for future reference
		$loop=count($data);
		for($i=0;$i<$loop;$i++) {
			// explode again
			// mysql doesn't support bolean expression
			$data_array = explode(",",$data[$i]);
			//echo print_r($data_array);

			if( $this->q->vendor=='mysql') {
				$sql="
					UPDATE 	`leafGroupAccess`
					SET 	`leafCreateAccessValue`	=	'".$this->strict($data_array[2],'boolean')."',
							`leafReadAccessValue`	=	'".$this->strict($data_array[2],'boolean')."',
							`leafUpdateAccessValue`	=	'".$this->strict($data_array[3],'boolean')."',
							`leafDeleteAccessValue`	=	'".$this->strict($data_array[4],'boolean')."',
							`leafPrintAccessValue`	=	'".$this->strict($data_array[5],'boolean')."',
							`leafPostAccessValue`	=	'".$this->strict($data_array[6],'boolean')."'
					WHERE 	`leafGroupAccessId`	=	'".$this->strict($data_array[0],'numeric')."'";
				//echo $sql."<br>";
			} else if ($this->q->vendor=='microsoft') {
				$sql="
					UPDATE 	[leafGroupAccess]
					SET 	[leafCreateAccessValue]	=	'".$this->strict($data_array[2],'boolean')."',
							[leafReadAccessValue]	=	'".$this->strict($data_array[2],'boolean')."',
							[leafUpdateAccessValue]	=	'".$this->strict($data_array[3],'boolean')."',
							[leafDeleteAccessValue]	=	'".$this->strict($data_array[4],'boolean')."',
							[leafPrintAccessValue]	=	'".$this->strict($data_array[5],'boolean')."',
							[leafPostAccessValue]	=	'".$this->strict($data_array[6],'boolean')."'
					WHERE 	[leafGroupAccessId]	=	'".$this->strict($data_array[0],'numeric')."'";
			} else if ($this->q->vendor=='oracle') {
				$sql="
					UPDATE 	\"leafGroupAccess\"
					SET 	\"leafCreateAccessValue\"	=	'".$this->strict($data_array[2],'boolean')."',
							\"leafReadAccessValue\"		=	'".$this->strict($data_array[2],'boolean')."',
							\"leafUpdateAccessValue\"	=	'".$this->strict($data_array[3],'boolean')."',
							\"leafDeleteAccessValue\"	=	'".$this->strict($data_array[4],'boolean')."',
							\"leafPrintAccessValue\"	=	'".$this->strict($data_array[5],'boolean')."',
							\"leafPostAccessValue\"		=	'".$this->strict($data_array[6],'boolean')."'
					WHERE 	\"leafGroupAccessId\"		=	'".$this->strict($data_array[0],'numeric')."'";
			}
			$this->q->update($sql);
			if($this->q->execute=='fail'){
				echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
				exit();
			}
		}
		echo json_encode(array("success"=>true,"message"=>"Update Success"));
		exit();



	}


	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete(){

	}

	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {}


}
$leafGroupAccessObject  	= 	new leafGroupAccessClass();
if(isset($_SESSION['staffId'])){
	$leafGroupAccessObject->staffId = $_SESSION['staffId'];
}
if(isset($_SESSION['vendor'])){
	$leafGroupAccessObject-> vendor = $_SESSION['vendor'];
}
// crud -create,read,update,delete.
if(isset($_POST['method'])){
	/*
	 *  Initilize Value before load in the loader
	 */

	if(isset($_POST['leafId'])){
		$leafGroupAccessObject->leafId = $_POST['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$folderAccess_obj->execute();
	if($_POST['method']=='read'){
		$leafGroupAccessObject-> read();
	}
}
if(isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */

	if(iset($_GET['leafId'])){
		$leafGroupAccessObject->leafId  = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$leafGroupAccessObject->execute();
	if($_GET['method']=='read'){
		$leafGroupAccessObject -> read();
	}
	if($_GET['method']=='update') {
		$leafGroupAccessObject -> update();
	}
	if(isset($_GET['field'])){
		if($_GET['field']=='staffId'){
			$leafGroupAccessObject -> staffId();
		}
		if($_GET['field']=='groupId'){
			$leafGroupAccessObject -> group;
		}
		if($_GET['field']=='accordionId'){
			$leafGroupAccessObject -> accordion();
		}
		if($_GET['field']=='folderId'){
			$leafGroupAccessObject -> folder();
		}
	}

}

?>
