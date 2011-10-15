<?php
session_start ();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSecurity.php");
require_once ("../model/leafTeamAccessModel.php");
/**
 * this is  leaf security access
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Security
 * @package Leaf Group Access Controller
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class LeafTeamAccessClass extends ConfigClass {
	/**
	 * Connection to the database
	 * @var string
	 */
	public $q;
	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string
	 */
	private $excel;
	/**
	 * Record Pagination
	 * @var string
	 */
	private $recordSet;
	/**
	 * Document Trail Audit.
	 * @var string 
	 */
	private $documentTrail;
	/**
	 * Audit Row True or False
	 * @var bool
	 */
	private $audit;
	/**
	 * Log Sql Statement True or False
	 * @var string
	 */
	private $log;
	/**
	 * Model
	 * @var string 
	 */
	public $model;
	/**
	 * Audit Filter
	 * @var string 
	 */
	public $auditFilter;
	/**
	 * Audit Column
	 * @var string 
	 */
	public $auditColumn;
	/**
	 * Duplicate Testing either the key of table same or have been created.
	 * @var bool
	 */
	public $duplicateTest;
	/**
	 * Common class function for security menu
	 * @var  string
	 */
	private $security;
	/**
	 * Class Loader
	 */
	function execute() {
		// audit property
		$this->audit = 0;
		$this->log = 1;
		
		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor ();
		$this->q->leafId = $this->getLeafId ();
		$this->q->staffId = $this->getStaffId ();
		$this->q->fieldQuery = $this->getFieldQuery ();
		$this->q->gridQuery = $this->getGridQuery ();
		$this->q->log = $this->log;
		$this->q->audit = $this->audit;
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );
		
		$this->security = new Security ();
		$this->security->setVendor ( $this->getVendor () );
		$this->security->execute ();
		
		$this->model = new LeafTeamAccessModel ();
		$this->model->setVendor ( $this->getVendor () );
		$this->model->execute ();
		
		$this->excel = new PHPExcel ();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create() {
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		// by default if add new group will add access to module and leaf.
		// just checking
		//	$this->checkLeaf();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
				SELECT	`leaf`.`moduleId`,
						`leaf`.`folderId`,
						`folder`.`folderEnglish`,
						`leaf`.`leafEnglish`,
						`module`.`moduleEnglish`,
						`team`.`teamEnglish`,
						`leafTeamAccess`.`leafId`,
						`leafTeamAccess`.`teamId`,
						`leafTeamAccess`.`leafTeamAccessId`,
						(CASE `leafTeamAccess`.`leafTeamAccessCreateValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafTeamAccessCreateValue`,


						(CASE `leafTeamAccess`.`leafTeamAccessReadValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafTeamAccessReadValue`,

						(CASE `leafTeamAccess`.`leafTeamAccessUpdateValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafTeamAccessUpdateValue`,

						(CASE `leafTeamAccess`.`leafTeamAccessDeleteValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafTeamAccessDeleteValue` ,

						(CASE `leafTeamAccess`.`leafTeamAccessPrintValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafTeamAccessPrintValue`,

						(CASE `leafTeamAccess`.`leafTeamAccessPostValue`
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS `leafTeamAccessPostValue`
				FROM 	`leafTeamAccess`
				JOIN	`leaf`
				USING	(`leafId`)
				JOIN	(`module`)
				USING	(`moduleId`)
				JOIN	(`folder`)
				USING	(`folderId`)
				JOIN	`team`
				USING	(`teamId`)
				WHERE 	`leaf`.`isActive`		=	1
				AND		`folder`.`isActive`		=	1
				AND		`module`.`isActive`		=	1
				AND		`team`.`isActive`		=	1";
			if ($this->model->getTeamId ()) {
				$sql .= " AND `leafTeamAccess`.`teamId`='" . $this->model->getTeamId () . "'";
			}
			if ($this->model->getModuleId ()) {
				$sql .= " AND `leaf`.`moduleId`='" . $this->model->getModuleId () . "'";
			}
			if ($this->model->getFolderId ()) {
				$sql .= " AND `leaf`.`folderId`='" . $this->model->getFolderId () . "'";
			}
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
				SELECT	[leaf].[moduleId],
						[leaf].[folderId],
						[folder].[folderEnglish],
						[leaf].[leafEnglish],
						[module].[moduleEnglish],
						[team].[teamEnglish],
						[leafTeamAccess].[leafId],
						[leafTeamAccess].[teamId],
						[leafTeamAccess].[leafTeamAccessId],
						(CASE [leafTeamAccess].[leafTeamAccessCreateValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafTeamAccessCreateValue],


						(CASE [leafTeamAccess].[leafTeamAccessReadValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafTeamAccessReadValue],

						(CASE [leafTeamAccess].[leafTeamAccessUpdateValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafTeamAccessUpdateValue],

						(CASE [leafTeamAccess].[leafTeamAccessDeleteValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafTeamAccessDeleteValue] ,

						(CASE [leafTeamAccess].[leafTeamAccessPrintValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafAccessPrintValue],

						(CASE [leafTeamAccess].[leafTeamAccessPostValue]
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS [leafTeamAccessPostValue]
				FROM 	[leafTeamAccess]
				JOIN	[leaf]
				ON		[leafTeamAccess].[leafId]=[leaf].[leafId]
				JOIN	[module]
				ON		[leaf].[moduleId]=[module].[moduleId]
				JOIN	[folder]
				ON		[leaf].[folderId] = [folder].[folderId]
				JOIN	[team]
				ON		[leafTeamAccess].[teamId]= [team].[teamId]
				WHERE 	[leaf].[isActive]		=	1
				AND		[folder].[isActive]		=	1
				AND		[module].[isActive]	=	1
				AND		[team].[isActive]		=	1";
			if ($this->model->getTeamId ()) {
				$sql .= " AND [leafTeamAccess].[teamId]='" . $this->model->getTeamId () . "'";
			}
			if ($this->model->getModuleId ()) {
				$sql .= " AND [leaf].[moduleId]='" . $this->model->getModuleId () . "'";
			}
			if ($this->model->getFolderId ()) {
				$sql .= " AND [leaf].[folderId]='" . $this->model->getFolderId () . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
				SELECT	LEAF.MODULEID,
						LEAF.FOLDERID,
						FOLDER.FOLDERNOTE,
						LEAF.LEAFNOTE,
						MODULE.MODULEENGLISH,
						TEAM.GROUPNOTE,
						LEAFTEAMACCESS.LEAFID,
						LEAFTEAMACCESS.TEAMID,
						LEAFTEAMACCESS.LEAFTEAMACCESSID,
						(CASE LEAFTEAMACCESS.LEAFTEAMACCESSCREATEVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafTeamAccessCreateValue,


						(CASE LEAFTEAMACCESS.LEAFTEAMACCESSREADVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafTeamAccessReadValue,

						(CASE LEAFTEAMACCESS.LEAFTEAMUPDATECREATEVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafTeamAccessUpdateValue,

						(CASE LEAFTEAMACCESS.LEAFTEAMACCESSDELETEVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafTeamAccessDeleteValue ,

						(CASE LEAFTEAMACCESS.LEAFTEAMACCESSPRINTVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafTeamAccessPrintValue,

						(CASE LEAFTEAMACCESS.LEAFTEAMACCESSPRINTVALUE
							WHEN '1' THEN
								'true'
							WHEN '0' THEN
								''
						END) AS leafTeamAccessPostValue
				FROM 	LEAFTEAMACCESS
				JOIN	LEAF
				USING	(LEAFID)
				JOIN	(MODULE)
				USING	(MODULEID)
				JOIN	(FOLDER)
				USING	(FOLDERID)
				JOIN	TEAM
				USING	(TEAMID)
				WHERE 	LEAF.ISACTIVE		=	1
				AND		FOLDER.ISACTIVE		=	1
				AND		MODULE.ISACTIVE	=	1
				AND		TEAM.ISACTIVE		=	1";
			if ($this->model->getTeamId ()) {
				$sql .= " AND LEAFTEAMACCESS.TEAMID='" . $this->model->getTeamId () . "'";
			}
			if ($this->model->getModuleId ()) {
				$sql .= " AND LEAF.MODULEID='" . $this->model->getModuleId () . "'";
			}
			if ($this->model->getFolderId ()) {
				$sql .= " AND LEAF.FOLDERID='" . $this->model->getFolderId () . "'";
			}
		} else if ($this->getVendor()== self::DB2){
			$sql = "
			SELECT	LEAF.MODULEID,
			LEAF.FOLDERID,
			FOLDER.FOLDERNOTE,
			LEAF.LEAFNOTE,
			MODULE.MODULEENGLISH,
			TEAM.GROUPNOTE,
			LEAFTEAMACCESS.LEAFID,
			LEAFTEAMACCESS.TEAMID,
			LEAFTEAMACCESS.LEAFTEAMACCESSID,
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSCREATEVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessCreateValue,
			
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSREADVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessReadValue,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMUPDATECREATEVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessUpdateValue,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSDELETEVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessDeleteValue ,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSPRINTVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessPrintValue,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSPRINTVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessPostValue
			FROM 	LEAFTEAMACCESS
			JOIN	LEAF
			USING	(LEAFID)
			JOIN	(MODULE)
			USING	(MODULEID)
			JOIN	(FOLDER)
			USING	(FOLDERID)
			JOIN	TEAM
			USING	(TEAMID)
			WHERE 	LEAF.ISACTIVE		=	1
			AND		FOLDER.ISACTIVE		=	1
			AND		MODULE.ISACTIVE	=	1
			AND		TEAM.ISACTIVE		=	1";
			if ($this->model->getTeamId ()) {
			$sql .= " AND LEAFTEAMACCESS.TEAMID='" . $this->model->getTeamId () . "'";
			}
			if ($this->model->getModuleId ()) {
			$sql .= " AND LEAF.MODULEID='" . $this->model->getModuleId () . "'";
			}
			if ($this->model->getFolderId ()) {
			$sql .= " AND LEAF.FOLDERID='" . $this->model->getFolderId () . "'";
			}
		} elseif ($this->getVendor()==self::POSTGRESS){
			$sql = "
			SELECT	LEAF.MODULEID,
			LEAF.FOLDERID,
			FOLDER.FOLDERNOTE,
			LEAF.LEAFNOTE,
			MODULE.MODULEENGLISH,
			TEAM.GROUPNOTE,
			LEAFTEAMACCESS.LEAFID,
			LEAFTEAMACCESS.TEAMID,
			LEAFTEAMACCESS.LEAFTEAMACCESSID,
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSCREATEVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessCreateValue,
			
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSREADVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessReadValue,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMUPDATECREATEVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessUpdateValue,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSDELETEVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessDeleteValue ,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSPRINTVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessPrintValue,
			
			(CASE LEAFTEAMACCESS.LEAFTEAMACCESSPRINTVALUE
			WHEN '1' THEN
			'true'
			WHEN '0' THEN
			''
			END) AS leafTeamAccessPostValue
			FROM 	LEAFTEAMACCESS
			JOIN	LEAF
			USING	(LEAFID)
			JOIN	(MODULE)
			USING	(MODULEID)
			JOIN	(FOLDER)
			USING	(FOLDERID)
			JOIN	TEAM
			USING	(TEAMID)
			WHERE 	LEAF.ISACTIVE		=	1
			AND		FOLDER.ISACTIVE		=	1
			AND		MODULE.ISACTIVE	=	1
			AND		TEAM.ISACTIVE		=	1";
			if ($this->model->getTeamId ()) {
			$sql .= " AND LEAFTEAMACCESS.TEAMID='" . $this->model->getTeamId () . "'";
			}
			if ($this->model->getModuleId ()) {
			$sql .= " AND LEAF.MODULEID='" . $this->model->getModuleId () . "'";
			}
			if ($this->model->getFolderId ()) {
			$sql .= " AND LEAF.FOLDERID='" . $this->model->getFolderId () . "'";
			}
		}
		//echo $sql;
		// searching filtering
		$sql .= $this->q->searching ();
		$record_all = $this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->total = $this->q->numberRows ();
		//paging
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$items = array();
		while ( ($row = $this->q->fetchAssoc ()) == TRUE ) {
			// select module access
			$items [] = $row;
		
		// select module access
		}
		if (count ( $items ) == 0) {
			$items = '';
		}
		echo json_encode ( array ('success' => true, 'total' => $this->total, 'data' => $items ) );
		exit ();
	}
	function update() {
		header ( 'Content-Type', 'application/json; charset=utf-8' );
		if ($this->getVendor () == self::MYSQL) {
			//UTF8
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$data = explode ( "|", $_POST ['info'] ); // still using & for future reference
		$loop = count ( $data );
		for($i = 0; $i < $loop; $i ++) {
			// explode again
			// mysql doesn't support bolean expression
			$data_array = explode ( ",", $data [$i] );
			//echo print_r($data_array);
			if ($this->getVendor () == self::MYSQL) {
				$sql = "
					UPDATE 	`leafTeamAccess`
					SET 	`leafAccessCreateValue`	=	'" . $this->strict ( $data_array [2], 'boolean' ) . "',
							`leafAccessReadValue`	=	'" . $this->strict ( $data_array [2], 'boolean' ) . "',
							`leafAccessUpdateValue`	=	'" . $this->strict ( $data_array [3], 'boolean' ) . "',
							`leafAccessDeleteValue`	=	'" . $this->strict ( $data_array [4], 'boolean' ) . "',
							`leafAccessPrintValue`	=	'" . $this->strict ( $data_array [5], 'boolean' ) . "',
							`leafAccessPostValue`	=	'" . $this->strict ( $data_array [6], 'boolean' ) . "'
					WHERE 	`leafTeamAccessId`	=	'" . $this->strict ( $data_array [0], 'numeric' ) . "'";
			
		//echo $sql."<br>";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql = "
					UPDATE 	[leafTeamAccess]
					SET 	[leafAccessCreateValue]	=	'" . $this->strict ( $data_array [2], 'boolean' ) . "',
							[leafAccessReadValue]	=	'" . $this->strict ( $data_array [2], 'boolean' ) . "',
							[leafAccessUpdateValue]	=	'" . $this->strict ( $data_array [3], 'boolean' ) . "',
							[leafAccessDeleteValue]	=	'" . $this->strict ( $data_array [4], 'boolean' ) . "',
							[leafAccessPrintValue]	=	'" . $this->strict ( $data_array [5], 'boolean' ) . "',
							[leafAccessPostValue]	=	'" . $this->strict ( $data_array [6], 'boolean' ) . "'
					WHERE 	[leafTeamAccessId]	=	'" . $this->strict ( $data_array [0], 'numeric' ) . "'";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql = "
					UPDATE 	LEAFTEAMACCESS
					SET 	leafAccessCreateValue	=	'" . $this->strict ( $data_array [2], 'boolean' ) . "',
							leafAccessReadValue		=	'" . $this->strict ( $data_array [2], 'boolean' ) . "',
							leafAccessUpdateValue	=	'" . $this->strict ( $data_array [3], 'boolean' ) . "',
							leafAccessDeleteValue	=	'" . $this->strict ( $data_array [4], 'boolean' ) . "',
							leafAccessPrintValue	=	'" . $this->strict ( $data_array [5], 'boolean' ) . "',
							leafAccessPostValue		=	'" . $this->strict ( $data_array [6], 'boolean' ) . "'
					WHERE 	LEAFTEAMACCESSID		=	'" . $this->strict ( $data_array [0], 'numeric' ) . "'";
			}
			$this->q->update ( $sql );
			if ($this->q->execute == 'fail') {
				echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
				exit ();
			}
		}
		echo json_encode ( array ("success" => true, "message" => "Update Success" ) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete() {
	}
	/**
	 * Team Information
	 */
	function team() {
		$this->security->team ();
	}
	/**
	 * Module Information
	 */
	function module() {
		$this->security->module ( $this->model->getType (), $this->model->getTeamId () );
	}
	/**
	 * Folder Information
	 */
	function folder() {
		$this->security->folder ( $this->model->getType (), $this->model->getTeamId (), $this->model->getModuleId () );
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {
	}
}
$leafTeamAccessObject = new LeafTeamAccessClass ();
// crud -create,read,update,delete.
if (isset ( $_POST ['method'] )) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset ( $_POST ['leafId'] )) {
		$leafTeamAccessObject->setleafId ( $_POST ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_POST ['isAdmin'] )) {
		$leafTeamAccessObject->setIsAdmin ( $_POST ['isAdmin'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$leafTeamAccessObject->execute ();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'read') {
		$leafTeamAccessObject->read ();
	}
}
if (isset ( $_GET ['method'] )) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset ( $_GET ['leafId'] )) {
		$leafTeamAccessObject->setLeafId ( $_GET ['leafId'] );
	}
	/*
	 * Admin Only
	 */
	if (isset ( $_GET ['isAdmin'] )) {
		$leafTeamAccessObject->setIsAdmin ( $_GET ['isAdmin'] );
	}
	/*
	 *
	 *  Load the dynamic value
	 */
	$leafTeamAccessObject->execute ();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_GET ['method'] == 'update') {
		$leafTeamAccessObject->update ();
	}
	if (isset ( $_GET ['field'] )) {
		if ($_GET ['field'] == 'staffId') {
			$leafTeamAccessObject->staffId ();
		}
		if ($_GET ['field'] == 'teamId') {
			$leafTeamAccessObject->team ();
		}
		if ($_GET ['field'] == 'moduleId') {
			$leafTeamAccessObject->module ();
		}
		if ($_GET ['field'] == 'folderId') {
			$leafTeamAccessObject->folder ();
		}
	}
}
?>
