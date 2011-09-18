<?php
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
date_default_timezone_set("Asia/Kuala_Lumpur");
require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';
/**
 * Database Configuration File and Database
 * @author hafizan
 *
 */
abstract class ConfigClass
{

	/**
	 * Program Identification
	 * @var int
	 */
	private $leafId;
	/**
	 * User Identification
	 * @var int
	 */
	private $staffId;
	/**
	 * Database Connection
	 * @var string
	 */
	private $connection;

	/**
	 * Database Name
	 * @var string
	 */
	private $database;
	/**
	 * Database Name
	 * @var string
	 */
	private $username;
	/**
	 * Staff Password.
	 * @var string
	 */
	private $password;
	/**
	 * Database Vendor
	 * @var string
	 */
	private $vendor;
	/**
	 * Extjs Field Query UX
	 * @var string
	 */
	private $fieldQuery;
	/**
	 * Extjs Grid  Filter Plugin
	 * @var string
	 */
	private $gridQuery;
	/**
	 * Start
	 * @var string
	 */
	private $start;
	/**
	 *  Limit
	 * @var string
	 */
	private $limit;

	/**
	 /**
	 *  Ascending ,Descending ASC,DESC
	 * @var string
	 */
	private $order;
	/**
	 * Sort the default field.Mostly consider as primary key default.
	 * @var string
	 */
	private $sortField;
	/**
	 * Default Language  : English
	 * @var int
	 */
	private $defaultLanguageId;
	/**
	 * Open To See Audit  Column --> approved,new,delete and e.g
	 * @var int
	 */
	public $isAdmin;
	/**
	 * Enter description here ...
	 * @var unknown_type
	 */
	public $value;
	/**
	 * Enter description here ...
	 * @var unknown_type
	 */
	public $type;



	/**
	 * Path Of the application
	 * @var string
	 */
	private $application;
	/**
	 * Mysql Database
	 * @var const string
	 */
	const mysql ='mysql';
	/**
	 * Microsoft Sql Server Database
	 * @var const string
	 */
	const mssql ='microsoft';
	/**
	 * Oracle Database
	 * @var const string
	 */
	const oracle = 'oracle';
	// end basic access database

	/*
	 *   @version  0.1  filter strict php setting
	 */
	function __construct()
	{
		//optional

		if (isset($_SESSION['database'])) {
			$this->setDatabase($_SESSION['database']);
		}
		if (isset($_SESSION['vendor'])) {
			$this->setVendor($_SESSION['vendor']);
		}
		if (isset($_SESSION['languageId'])) {
			$this->setLanguageId($_SESSION['languageId']);
		}
		if (isset($_SESSION['staffId'])) {
			$this->setStaffId($_SESSION['staffId']);
		}
		if($this->getVendor()==self::mysql){
			require_once('classMysql.php');
			$this->setConnection('localhost');
			$this->setUsername('root');
			$this->setPassword('123456');
			$this->setApplication('idcmsCore');
		}  elseif($this->getVendor()==self::mssql){
			require_once('classMssql.php');
			$this->setConnection('ADMIN-PC\X2');
			$this->setUsername('root');
			$this->setpassword("pa\$\$word4SPH");
			$this->setApplication('idcmsCore');
		}  elseif ($this->getVendor()==self::oracle){
			require_once('classOracle.php');
			$this->setConnection('localhost');
			$this->setUsername('idcmsCore');
			$this->setPassword('pa$$word4SPH');	
			$this->setApplication('idcmsCore');
		} else {
			// undefined database vendor and application
		}

	}
	/**
	 * New Record From Database
	 */
	abstract protected function create();
	/**
	 * Read Record From Databaase
	 */
	abstract protected function read();
	/**
	 * Update Record From Database
	 */
	abstract protected function update();
	/**
	 * Delete Record From Database
	 */
	abstract protected function delete();
	/**
	 * Microsoft Excel 2007 Ouput File Generation
	 */
	abstract protected function excel();
	/**
	 *  Return Staff Name
	 */
	public function staff()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor()== self::mysql) {
			$sql = "
			SELECT 	`staffId`,
					`staffNo`,
					`staffName`
			FROM   	`staff`
			WHERE	`isActive`=1";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			SELECT 	[staffId],
					[staffNo],
					[staffName]
			FROM   	[staff]
			WHERE  	[isActive]=1";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			SELECT 	STAFFID 	AS 	STAFFID,
					STAFFNO 	AS 	STAFFNO,
					STAFFNAME 	AS 	STAFFNAME
			FROM   	STAFF 		
			WHERE	STAFF.ISACTIVE=1";
		}
		$result = $this->q->fast($sql);
		$total = $this->q->numberRows($result);
		$items  = array();
		while ($row = $this->q->fetchAssoc($result)) {
			$items[] = $row;
		}
		echo json_encode(array(
            'success' => true,
			'total'=>$total,
			'message'=>'Data loaded',
            'staff' => $items
		));
	}
	/**
	 * to filter data type.
	 * @param value $v
	 * value variable come from server request or variable
	 * @param type $t
	 * Available data type password or p ,
	 *                     numeric  or n,
	 *                     booleand or b,
	 *                     string   or s,
	 *                     wyswg    or w
	 *                     memo     or m,
	 *                     float    or f,
	 *                     date     or d
	 *                     username or u
	 *                     calender or
	 *                     web      or wb
	 *					  iconname   or i
	 * * @version 0.1 addd filter addslasshes
	 * @return NULL|string|Ambigous <NULL, number, value, string, mixed>|number|unknown
	 */
	public function strict($v, $t)
	{
		$this->value = $v;
		$this->type  = $t;
		// short form code available
		if ($this->type == 'password' || $this->type == 'p') {
			if (strlen($this->value) != 32) {
				if (empty($this->value)) {
					return null;
				}
			}
			return (addslashes($this->value));
		} elseif ($this->type == 'numeric' || $this->type == 'n') {
			if (!is_numeric($this->value)) {
				$this->value = 0;
				return ($this->value);
			} else {
				return (intval($this->value));
			}
		} elseif ($this->type == 'boolean' || $this->type == 'b') {
			if ($this->value == 'true') {
				return 1;
			} elseif ($this->value) {
				return 0;
			}
		} elseif ($this->type == 'string' || $this->type == 's') {
			if (empty($this->value) && (strlen($this->value) == 0)) {
				$this->value = null;
				return ($this->value);
			} elseif (strlen($this->value) == 0) {
				$this->value = null;
				return ($this->value);
			} else {
				//UTF8 bugs
				//$this->value=trim(strtoupper($this->value)); // trim any space better for searching issue
				$this->value = addslashes($this->value);
				return $this->value;
			}
		} else if (($this->type == 'email' || $this->type == 'e') || ($this->type == 'filename' || $this->type == 'f') || ($this->type == 'iconname' || $this->type == 'i') || ($this->type == 'calendar' || $this->type == 'c') || ($this->type == 'username' || $this->type == 'u') || ($this->type == 'web' || $this->type == 'wb')) {
			if (empty($this->value) && (strlen($this->value) == 0)) {
				$this->value = null;
				return ($this->value);
			} elseif (strlen($this->value) == 0) {
				$this->value = null;
				return ($this->value);
			} else {
				$this->value = trim($this->value); // trim any space better for searching issue
				return $this->value;
			}
		} elseif ($this->type == 'wyswyg' || $this->type == 'w') {
			// just return back
			// addslashes will destroy the code
			$this->value = addslashes($this->value);
			return (htmlspecialchars($this->value));
		} elseif ($this->type == 'blob') {
			// this is easy for php/mysql developer
			$this->value = addslashes($this->value);
			return (htmlspecialchars($this->value));
		} elseif ($this->type == 'memo' || $this->type == 'm') {
			// this is easy for vb/access developer
			$this->value = addslashes($this->value);
			return (htmlspecialchars($this->value));
		} elseif ($this->type == 'currency') {
			// make easier for vb.net programmer to understand float value
			$this->value = str_replace("$", "", $this->value); // filter for extjs if exist
			$this->value = str_replace(",", "", $this->value);
			return ($this->value);
		} elseif ($this->type == 'float' || $this->type == 'f') {
			// make easier c programmer to understand float value
			$this->value = str_replace("$", "", $this->value); // filter for extjs if exist
			$this->value = str_replace(",", "", $this->value);
			return ($this->value);
		} elseif ($this->type == 'date' || $this->type == 'd') {
			// ext date like this mm/dd yy03/03/07
			// ext date mm/dd/yy mysql date yyyymmdd
			//ext allready validate date at javascript runtime
			// check either the date empty or not if empty key in today value
			if (empty($this->value)) {
				return (date("Y-m-d"));
			} else {
				$day   = substr($this->value, 0, 2);
				$month = substr($this->value, 3, 2);
				$year  = substr($this->value, 6, 4);
				return ($year . "-" . $month . "-" . $day);
			}
		}
	}
	/**
	 * Return The First Record
	 * params @value . This return data type. When call by normal read.Value=='value'.When requested by ajax request button Value=='json'
	 * @return int
	 */
	public function firstRecord($value) {
		$first=0;
		if($this->getVendor()==self::mysql){
			$sql="
			SELECT 	MIN(`".$this->model->getPrimaryKeyName()."`) AS `firstRecord`
			FROM 	`".$this->model->getTableName()."`";

		} else if ($this->getVendor()==self::mssql){
			$sql="
			SELECT 	MIN([".$this->model->getPrimaryKeyName()."]) AS [firstRecord]
			FROM 	[".$this->model->getTableName()."]";

		} else  if ($this->getVendor()== self::oracle){
			$sql="
			SELECT 	MIN(".strtoupper($this->model->getPrimaryKeyName()).") AS \"firstRecord\"
			FROM 	".strtoupper($this->model->getTableName())." ";

		}
		$result= $this->q->fast($sql);
		if($this->q->numberRows($result)> 0 ){
			$row  =  $this->q->fetchAssoc($result);
			$firstRecord = $row['firstRecord'];
		} else {
			$firstRecord =0;
		}
		if($value =='value') { 
			return intval($firstRecord);
		} else {
			$json_encode = json_encode(array(
                'success' => true,
                'total' => $total,
                'firstRecord' => $firstRecord,
            	));
			exit();	
		}
	}
	


	/**
	 * Return Next record
	 * @param int $primaryKeyValue
	 * @return int
	 */
	public function nextRecord($value,$primaryKeyValue) {
		$next=0;
		if($this->getVendor()==self::mysql){
			$sql="
		SELECT (`".$this->model->getPrimaryKeyName()."`) AS `nextRecord`
		FROM 	`".$this->model->getTableName()."`
		WHERE 	`".$this->model->getPrimaryKeyName()."` > ".$primaryKeyValue."
		LIMIT 	1";
		} else if ($this->getVendor() ==self::mssql){
			$sql="
		SELECT  TOP 1 ([".$this->model->getPrimaryKeyName()."]) AS [nextRecord]
		FROM 	[".$this->model->getTableName()."]
		WHERE 	[".$this->model->getPrimaryKeyName()."] > ".$primaryKeyValue." ";
		} else if ($this->getVendor()==self::oracle){
			$sql="
		SELECT (".strtoupper($this->model->getPrimaryKeyName()).") AS \"nextRecord\"
		FROM 	".strtoupper($this->model->getTableName())."
		WHERE 	".strtoupper($this->model->getPrimaryKeyName())." > ".$primaryKeyValue."
		AND		ROWNUM = 1";
		}
		$result= $this->q->fast($sql);
		if($this->q->numberRows($result) > 0 ){
			$row  		=  $this->q->fetchAssoc($result);
			$nextRecord = $row['nextRecord'];
		} else {
			$nextRecord = 0;
		}
		if($value =='value') { 
			return intval($nextRecord);
		} else {
			$json_encode = json_encode(array(
                'success' => true,
                'total' => $total,
                'nextRecord' => $nextRecord,
            	));
			exit();	
		}
	}

	/**
	 * Return Previous Record
	 * @param int $primaryKeyValue
	 * @return int
	 */
	public function previousRecord($value,$primaryKeyValue) {

		$previous=0;
		if($this->getVendor()==self::mysql){
			$sql="
		SELECT (`".$this->model->getPrimaryKeyName()."`) AS `previousRecord`
		FROM 	`".$this->model->getTableName()."`
		WHERE 	`".$this->model->getPrimaryKeyName()."` < ".$primaryKeyValue."
		ORDER BY `staffId`	DESC
		LIMIT 	1";
		} else if ($this->getVendor()==self::mssql){
			$sql="
		SELECT TOP 1 ([".$this->model->getPrimaryKeyName()."]) AS [previousRecord]
		FROM 	[".$this->model->getTableName()."]
		WHERE 	[".$this->model->getPrimaryKeyName()."] < ".$primaryKeyValue." ";
		} else if ($this->getVendor()==self::oracle){
			$sql="
		SELECT (".strtoupper($this->model->getPrimaryKeyName()).") AS \"previous\"
		FROM 	".strtoupper($this->model->getTableName())."
		WHERE 	".strtoupper($this->model->getPrimaryKeyName())." < ".$primaryKeyValue."
		AND 	ROWNUM  = 1 
		";
		}
		$result= $this->q->fast($sql);
		if($this->q->numberRows($result)> 0 ){
			$row  			=	$this->q->fetchAssoc($result);
			$previousRecord = 	$row['previousRecord'];
		} else {
			$previous		=	0;
		}
		
		if($value =='value') { 
			return intval($previousRecord);
		} else {
			$json_encode = json_encode(array(
                'success' => true,
                'total' => $total,
                'previousRecord' => $previousRecord,
            	));
			exit();	
		}
	}
	/**
	 * Return Last Record
	 * @return int
	 */
	public function lastRecord($value) {
		$lastRecord=0;
		if($this->getVendor()==self::mysql){
			$sql="
		SELECT	MAX(`".$this->model->getPrimaryKeyName()."`) AS `lastRecord`
		FROM 	`".$this->model->getTableName()."`";
		} else if($this->getVendor()==self::mssql){
			$sql="
		SELECT	MAX([".$this->model->getPrimaryKeyName()."]) AS [lastRecord]
		FROM 	[".$this->model->getTableName()."]";
		} else if ($this->getVendor()==self::oracle){
			$sql="
		SELECT	MAX(".$this->model->getPrimaryKeyName().") AS \"lastRecord\"
		FROM 	".strtoupper($this->model->getTableName())." ";
		}
		$result= $this->q->fast($sql);
		if($this->q->numberRows($result)> 0 ){
			$row  		=  $this->q->fetchAssoc($result);
			$lastRecord = $row['lastRecord'];
		} else{
			$lastRecord	=	0;
		}
		if($value =='value') { 
			return intval($lastRecord);
		} else {
			$json_encode = json_encode(array(
                'success' => true,
                'total' => $total,
                'lastRecord' => $lastRecord,
            	));
			exit();	
		}
		
	}
	/**
	 * Set Application Path
	 * @param string $value
	 */
	public function setApplication($value){
		$this->application = $value;
	}
	/**
	 * Return Application Path
	 * @return string
	 */
	public function getApplication(){
		return $this->application;
	}
	/**
	 * Set Staff Identification
	 * @param int $value
	 */
	public function setStaffId($value){
		$this->staffId = $value;
	}
	/**
	 * Return Staff Identification
	 * @return int
	 */
	public function getStaffId(){
		return $this->staffId;
	}
	/**
	 * Set Connection
	 * @param string $value
	 */
	public function setConnection($value){
		$this->connection = $value;
	}
	/**
	 * Set Connection
	 * @return string
	 */
	public function getConnection(){
		return $this->connection;
	}
	/**
	 * Set Database
	 * @param string $value
	 */
	public function setDatabase($value){
		$this->database = $value;
	}
	/**
	 * Return Database
	 * @return string
	 */
	public function getDatabase(){
		return $this->database;
	}
	/**
	 * Set Vendor Value
	 * @param string $value
	 */
	public function setVendor($value){
		$this->vendor = $value;
	}
	/**
	 * Return Vendor
	 * @return string
	 */
	public function getVendor(){
		return $this->vendor;
	}
	/**
	 * Set Username
	 * @param string $value
	 */
	public function setUsername($value){
		$this->username = $value;
	}
	/**
	 * Return Username
	 * @return string
	 */
	public function getUsername(){
		return $this->username;
	}
	/**
	 * Set Password
	 * @param string $value
	 */
	public function setPassword($value){
		$this->password = $value;
	}
	/**
	 * Return Password
	 * @return string
	 */
	public function getPassword(){
		return $this->password;
	}
	/**
	 * Set Language Identification
	 * @param int $value
	 */
	public function setLanguageId($value) {
		$this->languageId= $value;
	}
	/**
	 * Return Language Identification
	 * @return int
	 */
	public function getLanguageId(){
		return $this->languageId;
	}

	/**
	 * Set leaf / Application Identification
	 * @param int $value
	 */
	public function setLeafId($value){
		$this->leafId = $value;
	}
	/**
	 * Return Leaf /Application Identification
	 * @return number
	 */
	public function getLeafId() {
		return $this->leafId;
	}
	/**
	 * Set Is Admin Value
	 * @param bool $value
	 */
	public function setIsAdmin($value){
		$this->isAdmin = $value;
	}
	/**
	 * Return Is Admin
	 * @return bool
	 */
	public function getIsAdmin() {
		return $this->isAdmin;
	}
	/**
	 * Set Filter Query
	 * @param string $value
	 */
	public function setFieldQuery($value){
		$this->fieldQuery = $value;
	}
	/**
	 * Return Field Query
	 * @return string
	 */
	public function getFieldQuery() {
		return $this->fieldQuery;
	}
	/**
	 * Set Grid Query Filtering
	 * @param string $value
	 */
	public function setGridQuery($value){
		$this->gridQuery = $value;
	}
	/**
	 * Return Grid Query Filtering
	 * @return string
	 */
	public function getGridQuery() {

		return $this->gridQuery;
	}

	/**
	 * Set Start Number Per Page
	 * @param int $value
	 */
	public function setStart($value){
		$this->start = $value;
	}
	/**
	 * Return Start Number Per Page
	 * @return int
	 */
	public function getStart() {
		return $this->start;
	}

	/**
	 * Set limit Per Page
	 * @param int $value
	 */
	public function setLimit($value){
		$this->limit = $value;
	}
	/**
	 * Return limit Per Page
	 * @return int
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * Set Sql Statement Ordering
	 * @param string $value
	 */
	public function setOrder($value){
		$this->order = $value;
	}
	/**
	 * Return Sql Statement Ordering
	 * @return string
	 */
	public function getOrder() {
		return $this->order;
	}

	/**
	 * Set Sql Statement Sorting
	 * @param string $value
	 */
	public function setSortField($value){
		$this->sortField = $value;
	}
	/**
	 * Return Sql Statement Sorting
	 * @return string
	 */
	public function getSortField() {
		return $this->sortField;
	}
}
?>
