<?php
/*
 Author:Hafizan Bin  Abd Aziz
 This page is the connection the your mysql server database.
 */
require_once("../../class/classAbstract.php");
include("../../class/classValidation.php");
class  sharedx extends  configClass  {
	/**
	 * Username
	 * @var string $u
	 */
	public  $u;
	/**
	 * Connection
	 * @var string $c
	 */
	public $c;
	/**
	 *  Password
	 * @var md5 password
	 */
	public $p;
	/**
	 * Database Connection
	 * @var string $d
	 */
	public $d;
	function __construct(){
		/**
		 * calling basic property of the system
		 */
		parent :: __construct();
		$this->u = $this->username;
		$this->p = $this->password;
		$this->c = $this->connection;
		$this->d = $this->database;
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create(){}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() {}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() {}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete() {}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {}
}

$shared = new sharedx();

$connection = $shared->c;											// your host name.ip address or dns name
$database =   $shared->d; 												// your database connection
$username =   $shared->u; 												// your username
$password =   $shared->p;  												// your database usernamer
$q=new vendor();													// declare object

$q->vendor =	$_SESSION['vendor']; 									// normal for mysql and lite for mysqli
$q->staffId =   $_SESSION['staffId'];
$q->connect($connection, $username, $database, $password);

?>