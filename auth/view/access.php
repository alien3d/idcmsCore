<?php 	session_start();
require_once("../../class/classAbstract.php");

/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package accordion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class loginClass extends configClass {
	/**
	 *	Username which login to the system
	 *	string $user
	 */
	public $User;
	/**
	 *	Password  user which login to the system
	 *	string $Pass
	 */
	public $Pass;
	/**
	 *	 Database vendor
	 *   string $vendor;
	 */
	public $vendor;
	/**
	 *	 Database Selected
	 *   string $database;
	 */
	public $database;

	/**
	 * Class Loader
	 */
	public function execute(){
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->vendor;

		//$this->q->leafId			=	$this->leafId;

		//$this->q->staffId			=	$this->staffId;

		//$this->q->filter 			= 	$this->filter;

		//$this->q->quickFilter		=	$this->quickFilter;

		$this->q->connect($this->connection, $this->username,$this->database,$this->password);

		//$this->excel				=	new  PHPExcel();

		//$this->audit 				=	0;
		
		 
		
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public  function create(){

	}

	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read(){
		header('Content-Type','application/json; charset=utf-8');
		//UTF8

		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			$sql='SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		/**
		 *  Most Vendor don't much implement ansi 92 standard.Sql Statement Prefer Follow  Vendor Database Rule Standard.
		 **/
		if($this->q->vendor=='normal' || $this->q->vendor=='lite') {
			$sql	=	"
			SELECT	*
			FROM 	`staff`
			WHERE 	`staffName`		=	'".$this->strict($this->User,'s')."'
			AND		`staffPassword`	=	'".$this->strict(md5($this->Pass),'p')."'";
		} else if ($this->q->vendor=='microsoft') {
			$sql	=	"
			SELECT	*
			FROM 	[staff]
			WHERE 	[staffName]		=	'".$this->strict($this->User,'s')."'
			AND		[staffPassword]	=	'".$this->strict(md5($this->Pass),'p')."'";
		} else if ($this->q->vendor=='oracle') {
			$sql	=	"
			SELECT	*
			FROM 	\"staff\"
			WHERE 	\"staffName\"		=	'".$this->strict($this->User,'s')."'
			AND		\"staffPassword\"	=	'".$this->strict(md5($this->Pass),'p')."'";
		} else {
			echo json_encode(array("success"=>false,"message"=>"cannot identify vendor db[".$this->vendor."]"));
			exit();
		}

		$result=$this->q->fast($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->result_text));
			exit();
		}

		if($this->q->numberRows($result) > 0 ) {

			$row = $this->q->fetchAssoc($result);

			$_SESSION['staffId']		=	$row['staffId'];
			$_SESSION['staffNo'] 		= 	$row['staffNo'];
			$_SESSION['languageId']		=  	$row['languageId'];
			$_SESSION['database']		=	$_POST['database'];
			$_SESSION['vendor']			= 	$_POST['vendor'];
			echo json_encode(array("success"=>"true","message"=>"sucess login"));
			exit();

		} else {

			echo json_encode(array("success"=>false,"message"=>'The system could not login this user'.$sql));
			exit();


		}
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	public function  update(){

	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	public function delete(){

	}

	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	public function excel(){

	}




}

$loginObject = new loginClass;

if(isset($_POST['username'])){
	$loginObject->User = $_POST['username'];
}
if(isset($_POST['password'])){
	$loginObject->Pass = $_POST['password'];
}
if(isset($_POST['database'])){
	$loginObject->database = $_POST['database'];
}
if(isset($_POST['vendor'])){
	$loginObject->vendor = $_POST['vendor'];
}
$loginObject->execute();
$loginObject->read();

?>