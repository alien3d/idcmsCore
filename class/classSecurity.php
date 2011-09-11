<?php
/**
 * this is common library output for security program like icon,folder,tab and leaf.Here we don't require log..Slower the process
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package leaf
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class security extends configClass {
	/**
	 * Connection to the database
* @var string
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
* @var stringuery
	 */
	public $query;
	/**
	 * Fast Search Variable
* @var stringuickFilter
	 */
	public $quickFilter;

	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
* @var string
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
	 * Current Table Log Identification Value
	 **/

	private $moduleId;
	/**
	 * Folder Identification
	 * @var numeric $folderId
	 */
	private $folderId;
	/**
	 * Leaf Identification
	 * @var numeric $leafId
	 */
	//	private $leafId;
	/**
	 * Group Identification
	 * @var numeric $groupId
	 */
	private $groupId;
	/**
	 * Language Identification
	 * @var numeric $languageId
	 */
	private $languageId;
	/*
	 * Google API Translation
	 * @var string $googleId
	 */
	private $googleId='AIzaSyCKRpBlJzhuO0GWEvgq4WwlYus0O2qI0Ws';
	/*
	 * Microsoft Bing API Translation
	 * @var string $bingId
	 */
	private $bingId='17ABBA6C7400D761EE28324EC320B5D0093F3557';
	/**
	 *	Class Loader
	 */
	function execute() {
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->getVendor();

		$this->q->leafId			=	$this->getLeafId();

		$this->q->staffId			=	$this->getStaffId();

		//	$this->q->filter 			= 	$this->filter;

		//	$this->q->quickFilter		=	$this->quickFilter;

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		//	$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;


	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create(){}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read() {}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	public function update(){}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	public function delete(){}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	public function excel(){}

	public function group() 				{
		header('Content-Type','application/json; charset=utf-8');

		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		if($this->getVendor() == self::mysql) {
			$sql="
			SELECT 	`group`.`groupId`,
					`group`.`groupNote`
			FROM   	`group`
			WHERE 	`group`.`isActive`=1";
		} else if ($this->getVendor()==self::mssql) {
			$sql="
			SELECT 	[group].[groupId],
					[group].[groupNote]
			FROM   	[group]
			WHERE   [group].[isActive]=1";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
			SELECT 	GROUP_.GROUPID,
					GROUP_.GROUPNOTE
			FROM   	GROUP_
			WHERE   ISACTIVE=1";
		}

		$result =$this->q->fast($sql);

		$total	= $this->q->numberRows($result);
		$items =array();
		if($total > 0 ) {
			while($row  = 	$this->q->fetchAssoc($result)) {
				$items[] =$row;
			}
		} else {
			echo json_encode(array(
										'success'	=>false,
										'total' => $total,
										'group' => $items,
										'message' =>'Empty Record'
										));
										exit();
		}
		if($total ==1 ){
			$jsonEncode=json_encode(array(
		'success'=>true,
		'total' => $total,
		'group' => $items,
		'message'=>'Data loaded'
		));
		$jsonEncode=str_replace("[","",$jsonEncode);
		$jsonEncode=str_replace("]","",$jsonEncode);
		echo $jsonEncode;
		exit();
		} else {
			echo json_encode(array(
		'success'=>true,
		'total' => $total,
		'group' => $items
			));
			exit();
		}
	}
	public function department() 				{
		header('Content-Type','application/json; charset=utf-8');

		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		if($this->getVendor() == self::mysql) {
			$sql="
			SELECT 	`department`.`departmentId`,
					`department`.`departmentNote`
			FROM   	`department`
			WHERE   `department`.`isActive`=1";
		} else if ($this->getVendor()==self::mssql) {
			$sql="
			SELECT 	[department].[departmentId],
					[department].[departmentNote]
			FROM   	[department]
			WHERE   [department].[isActive]=1";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
			SELECT 	DEPARTMENT.\"departmentId\",
					DEPARTMENT.DEPARTMENTNOTE
			FROM   	DEPARTMENT
			WHERE   ISACTIVE=1";
		}

		$result =$this->q->fast($sql);

		$total=0;
		$total	= $this->q->numberRows($result);
		$items =array();
		if($total > 0 ) {
			while($row  = 	$this->q->fetchAssoc($result)) {
				$items[] =$row;
			}
		} else {

			echo json_encode(array(
										'success'	=>false,
										'total' => 0,

										'message' =>'Empty Record'
										));
										exit();

		}


		if($total ==1 ){
			$jsonEncode=json_encode(array(
		'success'=>true,
		'total' => $total,
		'department' => $items
			));
			$jsonEncode=str_replace("[","",$jsonEncode);
			$jsonEncode=str_replace("]","",$jsonEncode);
			echo $jsonEncode;
			exit();
		} else {
			echo json_encode(array(
		'success'=>true,
		'total' => $total,
		'department' => $items
			));
			exit();
		}
	}

	/**
	 * Give Output tab
	 * @version  0.1 remove the session  language
	 */
	function module() {
		// only filter tab which have access group
		//	header('Content-Type','application/json; charset=utf-8');
		/**
		 * $type =1 tab only ,$type=2  tab  + access
		 **/

		if(isset($_GET['type'])) {
			$type = intval($_GET['type']);
		}
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		if($this->getVendor() == self::mysql) {

			if($type==1) {
				$sql="
				SELECT 	`module`.`moduleId`,
						`module`.`moduleNote`
				FROM   	`module`
				WHERE   `module`.`isActive`=1";
			} else if ($type ==2) {
				$sql="
				SELECT 	`moduleAccess`.`moduleId`,
						`module`.`moduleNote`,
						`moduleAccess`.`groupId`,
						`moduleAccess`.`moduleAccessValue`
				FROM   	`moduleAccess`
				JOIN	`module`
				USING	(`moduleId`)
				WHERE   `module`.`isActive`=1";
				if(isset($_GET['groupId'])) {
					$sql.=" AND `moduleAccess`.`groupId`=\"".$this->strict($_GET['groupId'],'numeric')."\"";
				}
				
			}
		} else if ($this->getVendor()==self::mssql) {
			if($type ==1 ) {
				$sql="
			SELECT 	[module].[moduleId],
					[module].[moduleNote]
			FROM   	[module]
			WHERE   [module].[isActive]=1";


			} else if ($type==2) {
				$sql="
			SELECT 	[moduleAccess].[moduleId],
					[module].[moduleNote],
					[moduleAccess].[groupId],
					[moduleAccess].[moduleAccessValue]
			FROM   	[moduleAccess]
			JOIN	[module]
			ON		[module].[moduleId]=[moduleAccess].[moduleId]
			WHERE   [module].[isActive]=1";
				if(isset($_GET['groupId'])) {
					$sql.=" AND [moduleAccess].[groupId]=\"".$this->strict($_GET['groupId'],'numeric')."\"";
				}
			}
		} else if ($this->getVendor()==self::oracle) {
			if($type == 1) {
				$sql="
			SELECT 	MODULE.MODULEID,
					MODULE.MODULENOTE
			FROM   	MODULE
			WHERE   MODULE.ISACTIVE=1";
			} else if ($type==2) {
				$sql="
			SELECT 	MODULEACCESS.MODULEID,
					MODULEACCESS.MODULENOTE,
					MODULEACCESS.GROUPID,
					MODULEACCESS.MODULEACCESSVALUE
			FROM   	MODULEACCESS
			JOIN	MODULE
			USING	(MODULEID)
			WHERE   MODULE.ISACTIVE=1";
				if(isset($_GET['groupId'])) {
					$sql.=" AND MODULEACCESS.GROUPID=\"".$this->strict($_GET['groupId'],'numeric')."\"";
				}
			}
		} else{
			echo "undefine";
		}
		//echo "salah";
		$result=$this->q->fast($sql);

		$total	= $this->q->numberRows($result);
		$items =array();
		if($total > 0 ){

			while($row  = 	$this->q->fetchAssoc($result)) {
				$items[] =$row;
			}
		}
		if($total==1) {
			$jsonEncode=json_encode(array(
		'success'=>true,
		'total' => $total,
		'module' => $items,
		'message'=>"data loaded"	
		));
		$jsonEncode=str_replace("[","",$jsonEncode);
		$jsonEncode=str_replace("]","",$jsonEncode);
		echo $jsonEncode;
		exit();
		} else{
			echo json_encode(
			array(
											'success'	=>true,
											'total' => $total,
       								    	'module' => $items,
		'message'=>"data loaded"
		));
		exit();
		}

	}
	/**
	 * Enter description here ...
	 * @param unknown_type $moduleId
	 * @param unknown_type $folderId
	 * @param unknown_type $languageId
	 */
	function folder() {

		//  have to distinct group from tab acs  table
		//header('Content-Type','application/json; charset=utf-8');
		/**
		 * $type =1 tab only ,$type=2  tab  + access
		 **/


		if(isset($_GET['type'])) {
			$type = intval($_GET['type']);
		}
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}

		if($this->getVendor() == self::mysql) {
			if($type ==1 ) {
				$sql	=	"
			SELECT	`folder`.`folderId`,
					`folder`.`folderNote`
			FROM   	`folder`
			WHERE   `isActive`	=	1 ";
			} else {
				$sql="
			SELECT 	`folderAccess`.`moduleId`,
					`folderAccess`.`groupId`,
					`folderAccess`.`moduleAccessValue`,
			FROM   	`folderAccess`
			JOIN	`folder`
			USING	(`folderId`)
			WHERE   `folder`.`isActive`	=	1	";

			}
			if(isset($_GET['groupId'])) {
				$sql.=" AND `folder`.`groupId`=\"".$this->strict($_GET['groupId'],'numeric')."\"";
			}
			if(isset($_GET['moduleId'])) {
				$sql.=" AND `folder`.`moduleId`	=	\"".$this->strict($_GET['moduleId'],'numeric')."\"";
			}

		} else if ($this->getVendor()==self::mssql) {
			if($type==1){
				$sql	=	"
			SELECT	[folder].[folderId],
					[folder].[folderNote]
			FROM   	[folder]
			WHERE   [isActive]=1 ";
			} else {
				$sql="
			SELECT 	[folderAccess].[moduleId],
					[folderAccess].[groupId],
					[folderAccess].[moduleAccessValue],
			FROM   	[folderAccess]
			JOIN	[folder]
			ON		[folder].[folderId] = [folderAccess].[folderId]
			WHERE   [folder].[isActive]=1";

			}
			if(isset($_GET['groupId'])) {
				$sql.=" AND [folder].[groupId]=\"".$this->strict($_GET['groupId'],'numeric')."\"";
			}
			if(isset($_GET['moduleId'])) {
				$sql.=" AND [folder].[moduleId]=\"".$this->strict($_GET['moduleId'],'numeric')."\"";
			}

		} else if ($this->getVendor()==self::oracle) {
			if($type==1){
				$sql	=	"
			SELECT 	FOLDER.FOLDERID,
					FOLDER.FOLDERNOTE
			FROM   	FOLDER
			WHERE   ISACTIVE=1";
			} else {
				$sql="
			SELECT 	FOLDERACCESS.MODULEID,
					FOLDERACCESS.GROUPID,
					FOLDERACCESS.MODULEACCESSVALUE,
			FROM   	FOLDERACCESS
			JOIN	FOLDER
			USING	(FOLDERID)
			WHERE   FOLDER.ISACTIVE=1";

			}
			if(isset($_GET['groupId'])) {
				$sql.=" AND FOLDER.GROUPID=\"".$this->strict($_GET['groupId'],'numeric')."\"";
			}
			if(isset($_GET['moduleId'])) {
				$sql.=" AND FOLDER.MODULEID=\"".$this->strict($_GET['moduleId'],'numeric')."\"";
			}

		}
		$result= $this->q->fast($sql);

		$total			= 	$this->q->numberRows($result);
		$items 			=	array();
		if($total > 0 ) {
			while($row  	= 	$this->q->fetchAssoc($result)) {
				$items[] 	=	$row;
			}
		}
		if($total==1){
			$jsonEncode=json_encode(array(
		'success'=>true,
		'total' => $total,
		'folder' => $items,
		'message'=>"data loaded"
		));
		$jsonEncode=str_replace("[","",$jsonEncode);
		$jsonEncode=str_replace("]","",$jsonEncode);
		echo $jsonEncode;
		exit();
		}else{
			echo json_encode(array(
		'success'=>true,
		'total' => $total,
			'folder' => $items,
		'message'=>"data loaded"
		));
		exit();
		}

	}
	/**
	 *  Generate Sequence Order
	 */
	public function nextSequence() {
		header('Content-Type','application/json; charset=utf-8');
		/**
		 * initilize dummy value  to 0
		 */
		$nextSequence=0;
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		if(isset($_GET['table'])){
			$table = $_GET['table'];
		}
		if($this->getVendor() == self::mysql){
			$sql="
			SELECT 	(MAX(`".$table."Sequence`)+1) AS `nextSequence`
			FROM 	`".$table."`
			WHERE	`isActive` = 1";
		} else if ($this->getVendor()==self::mssql){
			$sql="
			SELECT 	(MAX([".$table."Sequence])+1) AS [nextSequence]
			FROM 	[".$table."]
			WHERE 	[isActive]=1";
		} else if ($this->getVendor()==self::oracle){
			$sql="
			SELECT 	(MAX(\"".$table."Sequence\")+1) AS \"nextSequence\"
			FROM 	\"".$table."\"
			WHERE	ISACTIVE=1";
		}
		if($table=='folder'){
			if(isset($_GET['moduleId'])){
				$sql.=" AND `moduleId`=\"".$_GET['moduleId']."\"";
			}


		}
		if($table=='leaf'){
			if(isset($_GET['moduleId'])){
				$sql.=" AND `moduleId`=\"".$_GET['moduleId']."\"";
			}
			if(isset($_GET['folderId'])){
				$sql.=" AND `folderId`=\"".$_GET['folderId']."\"";
			}
		}
		$result = $this->q->fast($sql);
		$row = $this->q->fetchAssoc($result);
		$nextSequence = $row['nextSequence'];
		if($nextSequence==0){
			$nextSequence=1;
		}
		echo  json_encode(array("success"=>true,"nextSequence"=>$nextSequence));
	}
	/**
	 * Google Api Change Language
	 * @param string $from
	 * @param string $to
	 * @param string $value
	 * @return Ambigous <string, multitype:>
	 */
	function changeLanguage($from,$to,$value) {

		$value = urlencode($value);
		$handle = fopen("https://www.googleapis.com/language/translate/v2?key=".$this->googleId."&q=".$value."&source=".$from."&target=".$to."&callback=handleResponse&prettyprint=true", "rb");
		$contents = stream_get_contents($handle);

		$a=explode(":",$contents);
		$x =explode("\"",$a[3]);
		fclose($handle);
		if(strlen($x[1])==0) {
			$x[1]='undefined';
		}

		return $x[1];

	}

	function setLanguageId($value) {
		$this->languageId= $value;
	}
	function getLanguageId(){
		return $this->languageId;
	}
}
?>
