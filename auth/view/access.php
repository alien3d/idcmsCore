<?php

session_start ();
require_once ("../../class/classAbstract.php");
require_once ("../../management/model/staffModel.php");
require_once ("../model/staffWebAcessModel.php");

/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package accordion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LoginClass extends ConfigClass {
	
	public $model;
	
	public $staffWebAceess;
	
	/**
	 * Class Loader
	 */
	public function execute() {
		parent::__construct ();
		
		$this->q = new Vendor ();
		
		$this->q->vendor = $this->getVendor ();
		
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );
		
		$this->model = new StaffModel ();
		$this->model->setVendor ( $this->getVendor () );
		$this->model->execute ();
		
		$this->staffWebAceess = new StaffWebAcessModel ();
		$this->staffWebAceess->setVendor ( $this->getVendor () );
		$this->staffWebAceess->execute ();
	
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create() {
	
	}
	
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		//UTF8
		

		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
	//		$this->q->fast ( $sql );
		}
		/**
		 * Most Vendor don't much implement ansi 92 standard.Sql Statement Prefer Follow  Vendor Database Rule Standard.
		 **/
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT	*
			FROM 	`staff`
			JOIN	`team`
			USING	(`teamId`)
			JOIN	`department`
			USING	(`departmentId`)
			WHERE 	`staff`.`staffName`			=	'" . $this->model->getStaffName () . "'
			AND		`staff`.`staffPassword`		=	'" . md5 ( $this->model->getStaffPassword () ) . "'
			AND		`staff`.`isActive`			=	1
			AND		`team`.`isActive`			=	1
			AND		`department`.`isActive`		=	1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	*
			FROM 	[staff]
			JOIN	[team]	
			ON		[staff].[teamId]  			= 	[team].[teamId]
			JOIN	[department]
			ON		[department].[departmentId] = 	[staff].[departmentId]
			WHERE 	[staff].[staffName]			=	'" . $this->model->getStaffName () . "'
			AND		[staff].[staffPassword]		=	'" . md5 ( $this->model->getStaffPassword () ) . "'
			AND		[staff].[isActive]			=	1
			AND		[team].[isActive]			=	1
			AND		[department].[isActive]		=	1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	STAFF.STAFFID 			AS	\"staffId\",
					STAFF.STAFFNO 			AS 	\"staffNo\",
					STAFF.STAFFNAME 		AS 	\"staffName\",
					STAFF.LANGUAGEID 		AS 	\"languageId\",
					TEAM.TEAMID 			AS  \"teamId\",
					DEPARTMENT.DEPARTMENTID AS 	\"departmentId\"
						
			FROM 	STAFF
			JOIN	TEAM
			ON		TEAM.TEAMID			= 	STAFF.TEAMID
			JOIN	DEPARTMENT
			ON		DEPARTMENT.DEPARTMENTID	= 	STAFF.DEPARTMENTID
			WHERE 	STAFF.STAFFNAME			=	'" . $this->model->getStaffName () . "'
			AND		STAFF.STAFFPASSWORD		=	'" . md5 ( $this->model->getStaffPassword () ) . "'
			AND		STAFF.ISACTIVE			=  1
			AND		TEAM.ISACTIVE 			=  1
			AND		DEPARTMENT.ISACTIVE	 	=  1";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
			SELECT	STAFF.STAFFID 			AS	\"staffId\",
			STAFF.STAFFNO 			AS 	\"staffNo\",
			STAFF.STAFFNAME 		AS 	\"staffName\",
			STAFF.LANGUAGEID 		AS 	\"languageId\",
			TEAM.TEAMID 			AS  \"teamId\",
			DEPARTMENT.DEPARTMENTID AS 	\"departmentId\"
			
			FROM 	STAFF
			JOIN	TEAM
			ON		TEAM.TEAMID			= 	STAFF.TEAMID
			JOIN	DEPARTMENT
			ON		DEPARTMENT.DEPARTMENTID	= 	STAFF.DEPARTMENTID
			WHERE 	STAFF.STAFFNAME			=	'" . $this->model->getStaffName () . "'
			AND		STAFF.STAFFPASSWORD		=	'" . md5 ( $this->model->getStaffPassword () ) . "'
			AND		STAFF.ISACTIVE			=  1
			AND		TEAM.ISACTIVE 		=  1
			AND		DEPARTMENT.ISACTIVE	 	=  1";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT	STAFF.STAFFID 			AS	\"staffId\",
			STAFF.STAFFNO 			AS 	\"staffNo\",
			STAFF.STAFFNAME 		AS 	\"staffName\",
			STAFF.LANGUAGEID 		AS 	\"languageId\",
			TEAM.TEAMID 			AS  \"teamId\",
			DEPARTMENT.DEPARTMENTID AS 	\"departmentId\"
			
			FROM 	STAFF
			JOIN	TEAM
			ON		TEAM.TEAMID			= 	STAFF.TEAMID
			JOIN	DEPARTMENT
			ON		DEPARTMENT.DEPARTMENTID	= 	STAFF.DEPARTMENTID
			WHERE 	STAFF.STAFFNAME			=	'" . $this->model->getStaffName () . "'
			AND		STAFF.STAFFPASSWORD		=	'" . md5 ( $this->model->getStaffPassword () ) . "'
			AND		STAFF.ISACTIVE			=  1
			AND		TEAM.ISACTIVE 			=  1
			AND		DEPARTMENT.ISACTIVE	 	=  1";
		} else {
			echo json_encode ( array ("success" => FALSE, "message" => "cannot identify vendor db[" . $this->getVendor () . "]" ) );
			exit ();
		}
	
		$result = $this->q->fast ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => FALSE, "message" => $this->q->responce ) );
			exit ();
		}
		
		if ($this->q->numberRows ( $result ) > 0) {
			
			$row = $this->q->fetchAssoc ( $result );
			
			$_SESSION ['staffId'] = $row ['staffId'];
			$_SESSION ['staffNo'] = $row ['staffNo'];
			$_SESSION ['staffName'] = $row ['staffName'];
			$_SESSION ['languageId'] = $row ['languageId'];
			$_SESSION ['teamId'] = $row ['teamId'];
			$_SESSION ['departmentId'] = $row ['departmentId'];
			$_SESSION ['database'] = $_POST ['database'];
			$_SESSION ['vendor'] = $_POST ['vendor'];
			
			$this->staffWebAceess->setStaffId ( $_SESSION ['staffId'] );
			
			// audit Log Time In
			if ($this->getVendor () == self::MYSQL) {
				$sql = "
				INSERT INTO `staffWebAccess`
						(
							`staffId`,
							`staffWebAccessLogIn`
						)
				VALUES (
							'" . $this->staffWebAceess->getStaffId () . "',
							'" . $this->staffWebAceess->getStaffWebAccessLogIn () . "'
						)";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql = "
				INSERT INTO [staffWebAccess]
						(
							[staffId],
							[staffWebAccessLogIn]
						)
				VALUES (
							'" . $this->staffWebAceess->getStaffId () . "',
							'" . $this->staffWebAceess->getStaffWebAccessLogIn () . "'
						)";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql = "
				INSERT INTO STAFFWEBACCESS
						(
							STAFFID,
							STAFFWEBACCESSLOGIN
						)
				VALUES (
							'" . $this->staffWebAceess->getStaffId () . "',
							" . $this->staffWebAceess->getStaffWebAccessLogIn () . "
						)";
			}
			$this->q->update ( $sql );
			
			echo json_encode ( array ("success" => true, "message" => "success login" ) );
			exit ();
		
		} else {
			
			echo json_encode ( array ("success" => FALSE, "message" => 'The system could not login this user' . $sql ) );
			exit ();
		
		}
		
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	public function update() {
	
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	public function delete() {
	
	}
	
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	public function excel() {
	
	}

}

$loginObject = new LoginClass ();

if (isset ( $_POST ['database'] )) {
	$loginObject->setDatabase ( $_POST ['database'] );
}
if (isset ( $_POST ['vendor'] )) {
	$loginObject->setVendor ( $_POST ['vendor'] );
}
$loginObject->execute ();
$loginObject->read ();

?>