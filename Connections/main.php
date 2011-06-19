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
	/*
	 * Vendor
	 */
	public $v;
	function __construct(){
		/**
		 * calling basic property of the system
		 */
		parent :: __construct();
		$this->u = $this->getUsername();
		$this->p = $this->getPassword();
		$this->c = $this->getConnection();
		$this->d = $this->getDatabase();
		$this->v = $this->getVendor();
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
$vendor   =   $shared->v;
$username =   $shared->u; 												// your username
$password =   $shared->p;
  												// your database usernamer
$q=new vendor();													// declare object

$q->vendor =$vendor;
$q->connect($connection, $username, $database, $password);

?>