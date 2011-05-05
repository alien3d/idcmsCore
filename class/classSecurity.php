<?php
/**
 * this is common library output for security program like icon,folder,accordion and leaf.Here we don't require log..Slower the process
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
	 * Current Table Log Indentification Value
	 **/

	private $accordionId;
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
	/**
	 *	Class Loader
	 */
	function execute() {
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->vendor;

		$this->q->leafId			=	$this->leafId;

		$this->q->staffId			=	$this->staffId;

		//	$this->q->filter 			= 	$this->filter;

		//	$this->q->quickFilter		=	$this->quickFilter;

		$this->q->connect($this->connection, $this->username,$this->database,$this->password);

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

		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			$sql="
			SELECT 	`group`.`groupId`,
					`group`.`groupNote`
			FROM   	`group`
			WHERE   `isActive`=1 ";
		} else if ($this->q->vendor=='microsoft') {
			$sql="
			SELECT 	[group].[groupId],
					[group].[groupNote]
			FROM   	[group]
			WHERE   [isActive]=1 ";
		} else if ($this->q->vendor=='oracle') {
			$sql="
			SELECT 	\"group\".\"groupId\",
					\"group\".\"groupNote\"
			FROM   	\"group`
			WHERE   \"isActive\"=1 ";
		}

		$result =$this->q->fast($sql);

		$total	= $this->q->numberRows($result);
		$items =array();
		if($total > 0 ) {
			while($row  = 	$this->q->fetchAssoc($result)) {
				$items[] =$row;
			}
		}
		echo json_encode(array('totalCount' => $total,
		'group' => $items
		));
		exit();
	}

	/**
	 * Give Output Accordion
	 * @version  0.1 remove the session  language
	 */
	function accordion() {
		// only filter accordion which have access group
		//	header('Content-Type','application/json; charset=utf-8');
		/**
		 * $type =1 accordion only ,$type=2  accordion  + access
		 **/

		if(isset($_GET['type'])) {
			$type = intval($_GET['type']);
		}
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);
			
		}
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {

			if($type==1) {
				$sql="
				SELECT 	`accordion`.`accordionId`,
						`accordion`.`accordionNote`
				FROM   	`accordion`
				WHERE   `accordion`.`isActive`=1";
			} else if ($type ==2) {
				$sql="
				SELECT 	`accordionAccess`.`accordionId`,
						`accordionAccess`.`groupId`,
						`accordionAccess`.`accordionAccessValue`
				FROM   	`accordionAccess`
				JOIN	`accordion`
				USING	(`accordionId`)
				WHERE   `accordion`.`isActive`=1";
				if(isset($_GET['groupId'])) {
					$sql.=" AND `accordionAccess`.`groupId`='".$this->strict($_GET['groupId'],'numeric')."'";
				}
			}
		} else if ($this->q->vendor=='microsoft') {
			if($type ==1 ) {
				$sql="
			SELECT 	[accordion].[accordionId],
					[accordion].[accordionNote]
			FROM   	[accordion]
			WHERE   [accordion].[isActive]=1";


			} else if ($type==2) {
				$sql="
			SELECT 	[accordionAccess].[accordionId],
					[accordionAccess].[groupId],
					[accordionAccess].[accordionAccessValue]
			FROM   	[accordionAccess]
			JOIN	[accordion]
			ON		[accordion].[accordionId]=[accordionAccess].[accordionId]
			WHERE   [accordion].[isActive]=1";
				if(isset($_GET['groupId'])) {
					$sql.=" AND [ccordionAccess].[groupId]='".$this->strict($_GET['groupId'],'numeric')."'";
				}
			}
		} else if ($this->q->vendor=='oracle') {
			if($type == 1) {
				$sql="
			SELECT 	\"accordion\".\"accordionId\",
					\"accordion\".\"accordionNote\"
			FROM   	\"accordion\"
			WHERE   \"accordion\".\"isActive\"=1";
			} else if ($type==2) {
				$sql="
			SELECT 	\"accordionAccess\".\"accordionId\",
					\"accordionAccess\".\"groupId\",
					\"accordionAccess\".\"accordionAccessValue\",
			FROM   	\"accordionAccess\"
			JOIN	\"accordion\"
			USING	(\"accordionId\")
			WHERE   \"accordion\".\"isActive\"=1";
				if(isset($_GET['groupId'])) {
					$sql.=" AND \"accordionAccess\".\"groupId\"='".$this->strict($_GET['groupId'],'numeric')."'";
				}
			}
		}

		$result=$this->q->fast($sql);

		$total	= $this->q->numberRows($result);
		$items =array();
		if($total > 0 ){

			while($row  = 	$this->q->fetchAssoc($result)) {
				$items[] =$row;
			}
		}
		echo json_encode(
		array(
											'success'	=>"true",
											'totalCount' => $total,
       								    	'accordion' => $items
		));
		exit();

	}
	/**
	 * Enter description here ...
	 * @param unknown_type $accordionId
	 * @param unknown_type $folderId
	 * @param unknown_type $languageId
	 */
	function folder() {

		//  have to distinct group from accordion acs  table
		header('Content-Type','application/json; charset=utf-8');
		/**
		 * $type =1 accordion only ,$type=2  accordion  + access
		 **/
		if(isset($_GET['type'])) {
			$type = intval($_GET['type']);
		}
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			if($type ==1 ) {
				$sql	=	"
			SELECT	`folder`.`folderId`,
					`folder`.`folderNote`
			FROM   	`folder`
			WHERE   `isActive`	=	1";
			} else {
				$sql="
			SELECT 	`folderAccess`.`accordionId`,
					`folderAccess`.`groupId`,
					`folderAccess`.`accordionAccessValue`,
			FROM   	`folderAccess`
			JOIN	`folder`
			USING	(`folderId`)
			WHERE   `folder`.`isActive`	=	1	";

			}
			if(isset($_GET['groupId'])) {
				$sql.=" AND `accordionAccess`.`groupId`='".$this->strict($_GET['groupId'],'numeric')."'";
			}
			if(isset($_GET['accordionId'])) {
				$sql.=" AND `accordionId`	=	'".$this->strict($_GET['accordionId'],'numeric')."'";
			}
		} else if ($this->q->vendor=='microsoft') {
			if($type==1){
				$sql	=	"
			SELECT	[folder].[folderId],
					[folder].[folderNote]
			FROM   	[folder]
			WHERE   [isActive]=1 ";
			} else {
				$sql="
			SELECT 	[folderAccess].[accordionId],
					[folderAccess].[groupId],
					[folderAccess].[accordionAccessValue],
			FROM   	[folderAccess]
			JOIN	[folder]
			ON		[folder].[folderId] = [folderAccess].[folderId]
			WHERE   [folder].[isActive]=1";

			}
			if(isset($_GET['groupId'])) {
				$sql.=" AND [accordionAccess].[groupId]='".$this->strict($_GET['groupId'],'numeric')."'";
			}
			if(isset($_GET['accordionId'])) {
				$sql.=" AND [folder].[accordionId]='".$this->strict($_GET['accordionId'],'numeric')."'";
			}
		} else if ($this->q->vendor=='oracle') {
			if($type==1){
				$sql	=	"
			SELECT 	\"folder\".\"folderId\",
					\"folder\".\"folderNote\"
			FROM   	\"folder\"
			WHERE   \"isActive\"=1";
			} else {
				$sql="
			SELECT 	\"folderAccess\".\"accordionId\",
					\"folderAccess\".\"groupId\",
					\"folderAccess\".\"accordionAccessValue\",
			FROM   	\"folderAccess\"
			JOIN	\"folder\"
			USING	(\"folderId\")
			WHERE   \"folder\".\"isActive\"=1";

			}
			if(isset($_GET['groupId'])) {
				$sql.=" AND \"accordionAccess\".\"groupId\"='".$this->strict($_GET['groupId'],'numeric')."'";
			}
			if(isset($_GET['accordionId'])) {
				$sql.=" AND \"folder\".\"accordionId\"='".$this->strict($_GET['accordionId'],'numeric')."'";
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

		echo json_encode(array('totalCount' => $total,
			'folder' => $items
		));
		exit();

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
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			//UTF8
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);

		}
		if(isset($_GET['table'])){
			$table = $_GET['table'];
		}
		if($this->q->vendor=='normal' || $this->q->vendor=='lite'){
			$sql="
			SELECT 	(MAX(`".$table."Sequence`)+1) AS `nextSequence`
			FROM 	`".$table."`
			WHERE	`isActive` = 1";
		} else if ($this->q->vendor=='microsoft'){
			$sql="
			SELECT 	(MAX([".$table."Sequence])+1) AS [nextSequence]
			FROM 	[".$table."]
			WHERE 	[isActive]=1";
		} else if ($this->q->vendor=='oracle'){
			$sql="
			SELECT 	(MAX(\"".$table."Sequence\")+1) AS \"nextSequence\"
			FROM 	\"".$table."\"
			WHERE	\"isActive\"=1";
		}
		if($table=='folder'){
			if(isset($_GET['accordionId'])){
				$sql.=" AND `accordionId`='".$_GET['accordionId']."'";
			}


		}
		if($table=='leaf'){
			if(isset($_GET['accordionId'])){
				$sql.=" AND `accordionId`='".$_GET['accordionId']."'";
			}
			if(isset($_GET['folderId'])){
				$sql.=" AND `folderId`='".$_GET['folderId']."'";
			}
		}
		$result = $this->q->fast($sql);
		$row = $this->q->fetchAssoc($result);
		$nextSequence = $row['nextSequence'];
		if($nextSequence==0){
			$nextSequence=1;
		}
		echo  json_encode(array("success"=>"true","nextSequence"=>$nextSequence));
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
		$handle = fopen("https://www.googleapis.com/language/translate/v2?key=AIzaSyCKRpBlJzhuO0GWEvgq4WwlYus0O2qI0Ws&q=".$value."&source=".$from."&target=".$to."&callback=handleResponse&prettyprint=true", "rb");
		$contents = stream_get_contents($handle);

		$a=explode(":",$contents);
		$x =explode("\"",$a[3]);
		fclose($handle);
		if(strlen($x[1])==0) {
			$x[1]='undefined';
		}

		return $x[1];

	}
}
?>