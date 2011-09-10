<?php 	session_start();
require_once("../../class/classAbstract.php");
require_once("../../management/model/staffModel.php");
require_once("../model/staffWebAcessModel.php");

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


	public $model;

	public $staffWebAceess;

	/**
	 * Class Loader
	 */
	public function execute(){
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->getVendor();

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->model  = new staffModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

		$this->staffWebAceess  = new staffWebAcessModel();
		$this->staffWebAceess->setVendor($this->getVendor());
		$this->staffWebAceess->execute();

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

		if($this->getVendor() == self::mysql) {
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		/**
		 *  Most Vendor don't much implement ansi 92 standard.Sql Statement Prefer Follow  Vendor Database Rule Standard.
		 **/
		if($this->getVendor() == self::mysql) {
			$sql	=	"
			SELECT	*
			FROM 	`staff`
			JOIN	`group`
			USING	(`groupId`)
			JOIN	`department`
			USING	(`departmentId`)
			WHERE 	`staff`.`staffName`		=	\"".$this->model->getStaffName()."\"
			AND		`staff`.`staffPassword`	=	\"".md5($this->model->getStaffPassword())."\"
			AND		`staff`.`isActive`			=	1
			AND		`group`.`isActive`			=	1
			AND		`department`.`isActive`		=	1";
		} else if ($this->getVendor()==self::mssql) {
			$sql	=	"
			SELECT	*
			FROM 	[staff]
			JOIN	[group]
			ON		[staff].[groupId]  = [group].[groupId]
			JOIN	[department]
			ON		[department].[departmentId] = [staff].[departmentId]
			WHERE 	[staff].[staffName]			=	'".$this->model->getStaffName()."'
			AND		[staff].[staffPassword]		=	'".md5($this->model->getStaffPassword())."'
			AND		[staff].[isActive]			=	1
			AND		[group].[isActive]			=	1
			AND		[department].[isActive]		=	1";
		} else if ($this->getVendor()==self::oracle) {
			$sql	=	"
			SELECT	STAFF.STAFFID 	AS \"staffId\",
					STAFF.STAFFNO 	AS \"staffNo\",
					STAFF.STAFFNAME AS \"staffName\",
					STAFF.LANGUAGEID AS \"languageId\",
					GROUP_.GROUPID AS \"groupId\",
					DEPARTMENT.DEPARTMENTID AS \"departmentId\"
						
			FROM 	STAFF
			JOIN	GROUP_
			ON		GROUP_.GROUPID		= 	STAFF.GROUPID
			JOIN	DEPARTMENT
			ON		DEPARTMENT.DEPARTMENTID		= 	STAFF.DEPARTMENTID
			WHERE 	STAFF.STAFFNAME		=	'".$this->model->getStaffName()."'
			AND		STAFF.STAFFPASSWORD	=	'".md5($this->model->getStaffPassword())."'
			AND		STAFF.ISACTIVE		=  1
			AND		GROUP_.ISACTIVE 	=  1
			AND		DEPARTMENT.ISACTIVE =  1";
		} else {
			echo json_encode(array("success"=>false,"message"=>"cannot identify vendor db[".$this->getVendor()."]"));
			exit();
		}

		$result=$this->q->fast($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}

		if($this->q->numberRows($result) > 0 ) {

			$row = $this->q->fetchAssoc($result);

			$_SESSION['staffId']		=	$row['staffId'];
			$_SESSION['staffNo'] 		= 	$row['staffNo'];
			$_SESSION['staffName']		=   $row['staffName'];
			$_SESSION['languageId']		=  	$row['languageId'];
			$_SESSION['groupId']		=   $row['groupId'];
			$_SESSION['departmentId']	=   $row['departmentId'];
			$_SESSION['database']		=	$_POST['database'];
			$_SESSION['vendor']			= 	$_POST['vendor'];

			$this->staffWebAceess->setStaffId($_SESSION['staffId']);

			// audit Log Time In
			if($this->getVendor()==self::mysql){
				$sql="
				INSERT INTO `staffWebAccess`
						(
							`staffId`,
							`staffWebAccessLogIn`
						)
				VALUES (
							\"".$this->staffWebAceess->getStaffId()."\",
							\"".$this->staffWebAceess->getStaffWebAccessLogIn()."\"
						)";
			} else if ($this->getVendor()==self::mssql){
				$sql="
				INSERT INTO [staffWebAccess]
						(
							[staffId],
							[staffWebAccessLogIn]
						)
				VALUES (
							'".$this->staffWebAceess->getStaffId()."',
							'".$this->staffWebAceess->getStaffWebAccessLogIn()."'
						)";
			} else if ($this->getVendor()==self::oracle){
				$sql="
				INSERT INTO STAFFWEBACCESS
						(
							STAFFID,
							STAFFWEBACCESSLOGIN
						)
				VALUES (
							'".$this->staffWebAceess->getStaffId()."',
							".$this->staffWebAceess->getStaffWebAccessLogIn()."
						)";
			}
			$this->q->update($sql);

			echo json_encode(array("success"=>"true","message"=>"success login"));
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

if(isset($_POST['database'])){
	$loginObject->setDatabase($_POST['database']);
}
if(isset($_POST['vendor'])){
	$loginObject->setVendor($_POST['vendor']);
}
$loginObject->execute();
$loginObject->read();

?>