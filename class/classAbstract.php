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
require_once('classMysql.php');
require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';
/**
 * Database Configuration File and Database
 * @author hafizan
 *
 */
abstract class configClass
{

	/**
	 * Program Identification
	 * @var numeric $leafId
	 */
	private $leafId;
	/**
	 * User Identification
	 * @var numeric $staffId
	 */
	private $staffId;
	/**
	 * Enter description here ...
	 * @var unknown_type
	 */
	public $connection;

	/**
	 * Enter description here ...
	 * @var unknown_type
	 */
	private $database;
	private $username;
	/**
	 * Enter description here ...
	 * @var unknown_type
	 */
	private $password;
	/**
	 * Database Vendor
	 * @var string $vendor
	 */
	private $vendor;
	/**
	 * Extjs Field Query UX
	 * @var string $fieldQuery
	 */
	private $fieldQuery;
	/**
	 * Extjs Grid  Filter Plugin
	 * @var string $gridQuery
	 */
	private $gridQuery;
	/**
	 * Start
	 * @var string $start;`
	 */
	private $start;
	/**
	 *  Limit
	 * @var string $limit
	 */
	private $limit;

	/**
	 /**
	 *  Ascending ,Descending ASC,DESC
	 * @var string $order;`
	 */
	private $order;
	/**
	 * Sort the default field.Mostly consider as primary key default.
	 * @var string $sortField
	 */
	private $sortField;
	/**
	 * Default Language  : English
	 * @var numeric $defaultLanguageId
	 */
	private $defaultLanguageId;
	/**
	 * Open To See Audit  Column --> approved,new,delete and e.g
	 * @var numeric $isAdmin
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
	 * @var string $application
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
		$this->setConnection('localhost');
		//	$this->connection   =  'UK0EG6KHE48\LOCALHOST'; // this is for Microsoft Sql Server Testing.
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

		$this->setUsername('root');
		//$this->username ='JOKERS'; // testing for oracle
		$this->setPassword('123456');
		//	$this->password="pa\$\$word4sph";
		$this->setApplication('idcmsCore');
		// define method
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
			SELECT 	\"staffId\",
					\"staffNo\",
					\"staffName\"
			FROM   	\"staff\"
			WHERE  	\"isActive\"=1";
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
	 * @return integer $first
	 */
	public function firstRecord() {
		$first=0;
		if($this->getVendor()==self::mysql){
			$sql="
			SELECT 	MIN(`".$this->model->getPrimaryKeyName()."`) AS `first`
			FROM 	`".$this->model->getTableName()."`";

		} else if ($this->getVendor()==self::mssql){
			$sql="
			SELECT 	MIN([".$this->model->getPrimaryKeyName()."]) AS [first]
			FROM 	[".$this->model->getTableName()."]";

		} else  if ($this->getVendor()== self::oracle){
			$sql="
			SELECT 	MIN(\"".$this->model->getPrimaryKeyName()."\") AS \"first\"
			FROM 	\"".$this->model->getTableName()."\"";

		}
		$result= $this->q->fast($sql);
		$row  =  $this->q->fetchAssoc($result);
		$first = $row['first'];
		return $first;
	}


	/**
	 * Return Next record
	 * @param integer $primaryKeyValue
	 * @return integer $next;
	 */
	public function nextRecord($primaryKeyValue) {
		$next=0;
		if($this->getVendor()==self::mysql){
			$sql="
		SELECT (`".$this->model->getPrimaryKeyName()."`) AS `next`
		FROM 	`".$this->model->getTableName()."`
		WHERE 	`".$this->model->getPrimaryKeyName()."` > ".$primaryKeyValue."
		LIMIT 	1";
		} else if ($this->getVendor() ==self::mssql){
			$sql="
		SELECT ([".$this->model->getPrimaryKeyName()."]) AS [next]
		FROM 	[".$this->model->getTableName()."]
		WHERE 	[".$this->model->getPrimaryKeyName()."] > ".$primaryKeyValue."
		LIMIT 	1";
		} else if ($this->getVendor()==self::oracle){
			$sql="
		SELECT (\"".$this->model->getPrimaryKeyName()."\") AS \"next\"
		FROM 	\"".$this->model->getTableName()."`
		WHERE 	\"".$this->model->getPrimaryKeyName()."\" > ".$primaryKeyValue."
		LIMIT 	1";
		}
		$result= $this->q->fast($sql);
		$row  =  $this->q->fetchAssoc($result);
		$next = $row['next'];
		return $next;
	}

	/**
	 * Return Previous Record
	 * @param  integer $primaryKeyValue
	 * @return integer $previous
	 */
	public function previousRecord($primaryKeyValue) {

		$previous=0;
		if($this->getVendor()==self::mysql){
			$sql="
		SELECT (`".$this->model->getPrimaryKeyName()."`) AS `previous`
		FROM 	`".$this->model->getTableName()."`
		WHERE 	`".$this->model->getPrimaryKeyName()."` < ".$primaryKeyValue."
		ORDER BY `staffId`	DESC
		LIMIT 	1";
		} else if ($this->getVendor()==self::mssql){
			$sql="
		SELECT ([".$this->model->getPrimaryKeyName()."]) AS [previous]
		FROM 	[".$this->model->getTableName()."]
		WHERE 	[".$this->model->getPrimaryKeyName()."] < ".$primaryKeyValue."
		ORDER BY [staffId]	DESC
		LIMIT 	1";
		} else if ($this->getVendor()==self::oracle){
			$sql="
		SELECT (\"".$this->model->getPrimaryKeyName()."\") AS \"previous\"
		FROM 	\"".$this->model->getTableName()."\"
		WHERE 	\"".$this->model->getPrimaryKeyName()."\" < ".$primaryKeyValue."
		ORDER BY \"staffId\" DESC
		LIMIT 	1";
		}
		$result= $this->q->fast($sql);
		$row  =  $this->q->fetchAssoc($result);
		$previous = $row['previous'];
		return $previous;
	}
	/**
	 * Return Last Record
	 * @return integer $last
	 */
	public function lastRecord() {
		$last=0;
		if($this->getVendor()==self::mysql){
			$sql="
		SELECT	MAX(`".$this->model->getPrimaryKeyName()."`) AS `last`
		FROM 	`".$this->model->getTableName()."`";
		} else if($this->getVendor()==self::mssql){
			$sql="
		SELECT	MAX([".$this->model->getPrimaryKeyName()."]) AS [last]
		FROM 	[".$this->model->getTableName()."]";
		} else if ($this->getVendor()==self::oracle){
			$sql="
		SELECT	MAX(\"".$this->model->getPrimaryKeyName()."\") AS \"last\"
		FROM 	\"".$this->model->getTableName()."\"";
		}
		$result= $this->q->fast($sql);
		$row  =  $this->q->fetchAssoc($result);
		$last = $row['last'];
		return $last;
	}
	public function setApplication($value){
		$this->application = $value;
	}
	public function getApplication(){
		return $this->application;
	}
	public function setStaffId($value){
		$this->staffId = $value;
	}
	public function getStaffId(){
		return $this->staffId;
	}
	public function setConnection($value){
		$this->connection = $value;
	}
	public function getConnection(){
		return $this->connection;
	}
	public function setDatabase($value){
		$this->database = $value;
	}
	public function getDatabase(){
		return $this->database;
	}
	public function setVendor($value){
		$this->vendor = $value;
	}
	public function getVendor(){
		return $this->vendor;
	}
	public function setUsername($value){
		$this->username = $value;
	}
	public function getUsername(){
		return $this->username;
	}
	public function setPassword($value){
		$this->password = $value;
	}
	public function getPassword(){
		return $this->password;
	}
	public function setLanguageId($value) {
		$this->languageId= $value;
	}
	public function getLanguageId(){
		return $this->languageId;
	}

	public function setLeafId($value){
		$this->leafId = $value;
	}
	public function getLeafId() {
		return $this->leafId;
	}
	public function setIsAdmin($value){
		$this->isAdmin = $value;
	}
	public function getIsAdmin() {
		return $this->isAdmin;
	}
	public function setFieldQuery($value){
		$this->fieldQuery = $value;
	}
	public function getFieldQuery() {
		return $this->fieldQuery;
	}
	public function setGridQuery($value){
		$this->gridQuery = $value;
	}
	public function getGridQuery() {

		return $this->gridQuery;
	}

	public function setStart($value){
		$this->start = $value;
	}
	public function getStart() {
		return $this->start;
	}

	public function setLimit($value){
		$this->limit = $value;
	}
	public function getLimit() {
		return $this->limit;
	}

	public function setOrder($value){
		$this->order = $value;
	}
	public function getOrder() {
		return $this->order;
	}

	public function setSortField($value){
		$this->sortField = $value;
	}
	public function getSortField() {
		return $this->sortField;
	}
}
?>
