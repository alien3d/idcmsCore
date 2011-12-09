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
class Security extends ConfigClass {
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
	 * Database Selected
	 * string $database;
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
	private $excel;
	/**
	 * Document Trail Audit.
	 * @var string $documentTrail;
	 */
	private $documentTrail;
	/**
	 * Ascending ,Descending ASC,DESC
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
	 * Audit Row TRUE or False
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
	 * @var numeric $teamId
	 */
	private $teamId;
	/**
	 * Language Identification
	 * @var numeric $languageId
	 */
	private $languageId;
	/*
	 * @var string $googleId
	 */
	private $googleId = 'AIzaSyCKRpBlJzhuO0GWEvgq4WwlYus0O2qI0Ws';
	/*
	 * Microsoft Bing API Translation
	 * @var string $bingId
	 */
	private $bingId = '17ABBA6C7400D761EE28324EC320B5D0093F3557';
	/**
	 * Class Loader
	 */
	function execute() {
		parent::__construct ();
		
		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor ();
		$this->q->leafId = $this->getLeafId ();
		$this->q->staffId = $this->getStaffId ();
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );
		
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
	/**
	 * Give output Team/Department
	 */
	public function team() {
		header('Content-Type:application/json; charset=utf-8');
		if ($this->getVendor () == self::MYSQL) {
			
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT 	`team`.`teamId`,
					`team`.`teamEnglish`
			FROM   	`team`
			WHERE 	`team`.`isActive`=1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT 	[team].[teamId],
					[team].[teamEnglish]
			FROM   	[team]
			WHERE   [team].[isActive]=1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT 	TEAM.TEAMID as \"teamId\",
					TEAM.TEAMENGLISH
			FROM   	TEAM
			WHERE   ISACTIVE=1";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
			SELECT 	TEAM.TEAMID as \"teamId\",
					TEAM.TEAMENGLISH
			FROM   	TEAM
			WHERE   ISACTIVE=1";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT 	TEAM.TEAMID as \"teamId\",
					TEAM.TEAMENGLISH
			FROM   	TEAM
			WHERE   ISACTIVE=1";
		}
		$result = $this->q->fast ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ('success' => false, 'message' => $this->q->responce ) );
			
			exit ();
		}
		$total = 0;
		$total = $this->q->numberRows ( $result );
		$items = array ();
		if ($total > 0) {
			while ( ($row = $this->q->fetchAssoc ( $result )) == TRUE ) {
				$items [] = $row;
			}
		} else {
			echo json_encode ( array ('success' => false, 'total' => $total, 'team' => $items, 'message' => 'Empty Record' ) );
			exit ();
		}
		if ($total == 1) {
			$jsonEncode = json_encode ( array ('success' => true, 'total' => $total, 'team' => $items, 'message' => $this->systemString->getReadMessage() ) );
			$jsonEncode = str_replace ( "[", "", $jsonEncode );
			$jsonEncode = str_replace ( "]", "", $jsonEncode );
			echo $jsonEncode;
			exit ();
		} else {
			echo json_encode ( array ('success' => true, 'total' => $total, 'team' => $items ) );
			exit ();
		}
	}
	/**
	 * Give Ouput Department
	 */
	public function department() {
		header('Content-Type:application/json; charset=utf-8');
		if ($this->getVendor () == self::MYSQL) {
			
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT 	`department`.`departmentId`,
					`department`.`departmentEnglish`
			FROM   	`department`
			WHERE   `department`.`isActive`=1";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT 	[department].[departmentId],
					[department].[departmentEnglish]
			FROM   	[department]
			WHERE   [department].[isActive]=1";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT 	DEPARTMENT.DEPARTMENTID,
					DEPARTMENT.DEPARTMENTENGLISH
			FROM   	DEPARTMENT
			WHERE   ISACTIVE=1";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
			SELECT 	DEPARTMENT.DEPARTMENTID,
					DEPARTMENT.DEPARTMENTENGLISH
			FROM   	DEPARTMENT
			WHERE   ISACTIVE=1";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT 	DEPARTMENT.DEPARTMENTID,
					DEPARTMENT.DEPARTMENTENGLISH
			FROM   	DEPARTMENT
			WHERE   ISACTIVE=1";
		}
		$result = $this->q->fast ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ('success' => false, 'message' => $this->q->responce ) );
			
			exit ();
		}
		$total = 0;
		$total = $this->q->numberRows ( $result );
		$items = array ();
		if ($total > 0) {
			while ( ($row = $this->q->fetchAssoc ( $result )) == TRUE ) {
				$items [] = $row;
			}
		} else {
			echo json_encode ( array ('success' => false, 'total' => 0, 'message' => 'Empty Record' ) );
			exit ();
		}
		if ($total == 1) {
			$jsonEncode = json_encode ( array ('success' => true, 'total' => $total, 'department' => $items ) );
			//$jsonEncode = str_replace ( "[", "", $jsonEncode );
			//$jsonEncode = str_replace ( "]", "", $jsonEncode );
			echo $jsonEncode;
			exit ();
		} else {
			echo json_encode ( array ('success' => true, 'total' => $total, 'department' => $items ) );
			exit ();
		}
	}
	/**
	 * Give Output Module
	 * @param int $type	1 = module only , 2 module  + access
	 * @param int $teamId  Team Identification Value
	 * @version  0.1 remove the session  language
	 */
	function module($type, $teamId = NULL) {
		header('Content-Type:application/json; charset=utf-8');
		
		if ($this->getVendor () == self::MYSQL) {
			
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		if (! ($type)) {
			echo json_encode ( array ("success" => false, "message" => "There are no Type Define" ) );
			exit ();
		}
		if ($this->getVendor () == self::MYSQL) {
			if ($type == 1) {
				$sql = "
				SELECT 	`module`.`moduleId`,
						`module`.`moduleEnglish`
				FROM   	`module`
				WHERE   `module`.`isActive`=1";
			} else if ($type == 2) {
				$sql = "
				SELECT 	`moduleAccess`.`moduleId`,
						`module`.`moduleEnglish`,
						`moduleAccess`.`teamId`,
						`moduleAccess`.`moduleAccessValue`
				FROM   	`moduleAccess`
				JOIN	`module`
				USING	(`moduleId`)
				WHERE   `module`.`isActive`=1";
				if (isset ( $teamId )) {
					$sql .= " AND `moduleAccess`.`teamId`='" . $teamId . "'";
				}
			}
		} else if ($this->getVendor () == self::MSSQL) {
			if ($type == 1) {
				$sql = "
			SELECT 	[module].[moduleId],
					[module].[moduleEnglish]
			FROM   	[module]
			WHERE   [module].[isActive]=1";
			} else if ($type == 2) {
				$sql = "
			SELECT 	[module].[moduleId],
					[module].[moduleEnglish],
					[moduleAccess].[teamId],
					[moduleAccess].[moduleAccessValue]
			FROM   	[moduleAccess]
			JOIN	[module]
			ON		[module].[moduleId]=[moduleAccess].[moduleId]
			WHERE   [module].[isActive]=1";
				if (isset ( $teamId )) {
					$sql .= " AND [moduleAccess].[teamId]='" . $teamId . "'";
				}
			}
		} else if ($this->getVendor () == self::ORACLE) {
			if ($type == 1) {
				$sql = "
			SELECT 	MODULE.MODULEID 		AS	\"moduleId\",
					MODULE.MODULEENGLISH	AS	\"moduleEnglish\"
			FROM   	MODULE
			WHERE   MODULE.ISACTIVE=1";
			} else if ($type == 2) {
				$sql = "
			SELECT 	MODULE.MODULEID 				AS	\"moduleId\",
					MODULE.MODULEENGLISH 			AS 	\"moduleEnglish\",
					MODULEACCESS.TEAMID 			AS 	\"teamId\",
					MODULEACCESS.MODULEACCESSVALUE	AS 	\"moduleAccessValue\"
			FROM   	MODULEACCESS
			JOIN	MODULE
			USING	(MODULEID)
			WHERE   MODULE.ISACTIVE=1";
				if (isset ( $teamId )) {
					$sql .= " AND MODULEACCESS.TEAMID='" . $teamId . "'";
				}
			}
		} else if ($this->getVendor () == self::DB2) {
			if ($type == 1) {
				$sql = "
				SELECT 	MODULE.MODULEID 		AS	\"moduleId\",
						MODULE.MODULEENGLISH	AS	\"moduleEnglish\"
				FROM   	MODULE
				WHERE   MODULE.ISACTIVE=1";
			} else if ($type == 2) {
				$sql = "
				SELECT 	MODULE.MODULEID 				AS	\"moduleId\",
						MODULE.MODULEENGLISH 			AS 	\"moduleEnglish\",
						MODULEACCESS.TEAMID 			AS 	\"teamId\",
						MODULEACCESS.MODULEACCESSVALUE	AS 	\"moduleAccessValue\"
				FROM   	MODULEACCESS
				JOIN	MODULE
				USING	(MODULEID)
				WHERE   MODULE.ISACTIVE=1";
				if (isset ( $teamId )) {
					$sql .= " AND MODULEACCESS.TEAMID='" . $teamId . "'";
				}
			}
		} else if ($this->getVendor () == self::POSTGRESS) {
			if ($type == 1) {
				$sql = "
				SELECT 	MODULE.MODULEID 		AS	\"moduleId\",
						MODULE.MODULEENGLISH	AS	\"moduleEnglish\"
				FROM   	MODULE
				WHERE   MODULE.ISACTIVE=1";
			} else if ($type == 2) {
				$sql = "
				SELECT 	MODULE.MODULEID 				AS	\"moduleId\",
						MODULE.MODULEENGLISH 			AS 	\"moduleEnglish\",
						MODULEACCESS.TEAMID 			AS 	\"teamId\",
						MODULEACCESS.MODULEACCESSVALUE	AS 	\"moduleAccessValue\"
				FROM   	MODULEACCESS
				JOIN	MODULE
				USING	(MODULEID)
				WHERE   MODULE.ISACTIVE=1";
				if (isset ( $teamId )) {
					$sql .= " AND MODULEACCESS.TEAMID='" . $teamId . "'";
				}
			}
		}
		
		$result = $this->q->fast ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ('success' => false, 'message' => $this->q->responce ) );
			
			exit ();
		}
		$total = $this->q->numberRows ( $result );
		$items = array ();
		if ($total > 0) {
			while ( ($row = $this->q->fetchAssoc ( $result )) == TRUE ) {
				$items [] = $row;
			}
		}
		if ($total == 1) {
			$jsonEncode = json_encode ( array ('success' => true, 'total' => $total, 'module' => $items, 'message' => "data loaded" ) );
			//$jsonEncode = str_replace ( "[", "", $jsonEncode );
			//$jsonEncode = str_replace ( "]", "", $jsonEncode );
			echo $jsonEncode;
			exit ();
		} else {
			echo json_encode ( array ('success' => true, 'total' => $total, 'module' => $items, 'message' => "data loaded" ) );
			exit ();
		}
	}
	/**
	 * Give Output Folder
	 * @param int $type	1 = folder only , 2 folder  + access
	 * @param int $moduleId  Module Identification Value
	 * @param int $teamId  Team Identification Value
	 * @version  0.1 remove the session  language
	 */
	function folder($type, $teamId = null,$moduleId = null) {
		header('Content-Type:application/json; charset=utf-8');
		
		if (! ($type)) {
			echo json_encode ( array ("success" => false, "message" => "There are no Type Define" ) );
			exit ();
		}
		if ($this->getVendor () == self::MYSQL) {
			
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		if ($this->getVendor () == self::MYSQL) {
			if ($type == 1) {
				$sql = "
			SELECT	`folder`.`folderId`,
					`folder`.`folderEnglish`
			FROM   	`folder`
			WHERE   `isActive`	=	1 ";
			} else {
				$sql = "
			SELECT 	`folder`.`folderId`,
					`folder`.`folderEnglish`,
					`folder`.`moduleId`,
					`folderAccess`.`teamId`,
					`folderAccess`.`folderAccessValue`
			FROM   	`folderAccess`
			JOIN	`folder`
			USING	(`folderId`)
			WHERE   `folder`.`isActive`	=	1	";
			}
			if (isset ( $teamId )) {
				$sql .= " AND `folderAccess`.`teamId`='" . $teamId . "'";
			}
			if (isset ( $moduleId )) {
				$sql .= " AND `folder`.`moduleId`	=	'" . $moduleId . "'";
			}
		
			
		} else if ($this->getVendor () == self::MSSQL) {
			if ($type == 1) {
				$sql = "
			SELECT	[folder].[folderId],
					[folder].[folderEnglish]
			FROM   	[folder]
			WHERE   [isActive]=1 ";
			} else {
				$sql = "
			SELECT 	[folder].[folderId],
					[folder].[folderEnglish],
					[folder].[moduleId],
					[folderAccess].[teamId],
					[folderAccess].[folderAccessValue],
			FROM   	[folderAccess]
			JOIN	[folder]
			ON		[folder].[folderId] = [folderAccess].[folderId]
			WHERE   [folder].[isActive]	=	1";
			}
			if (isset ( $teamId )) {
				$sql .= " AND [folderAccess].[teamId]='" . $teamId . "'";
			}
			if (isset ( $moduleId )) {
				$sql .= " AND [folder].[moduleId]='" . $moduleId . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			if ($type == 1) {
				$sql = "
			SELECT 	FOLDER.FOLDERID,
					FOLDER.FOLDERENGLISH
			FROM   	FOLDER
			WHERE   ISACTIVE=1";
			} else {
				$sql = "
			SELECT 	FOLDER.FOLDERID,
					FOLDER.FOLDERENGLISH,
					FOLDER.MODULEID,
					FOLDERACCESS.TEAMID,
					FOLDERACCESS.FOLDERACCESSVALUE,
			FROM   	FOLDERACCESS
			JOIN	FOLDER
			USING	(FOLDERID)
			WHERE   FOLDER.ISACTIVE=1";
			}
			if (isset ( $teamId )) {
				$sql .= " AND FOLDERACCESS.TEAMID='" . $teamId . "'";
			}
			if (isset ( $moduleId )) {
				$sql .= " AND FOLDER.MODULEID='" . $moduleId . "'";
			}
		
		} else if ($this->getVendor () == self::DB2) {
			if ($type == 1) {
				$sql = "
			SELECT 	FOLDER.FOLDERID,
					FOLDER.FOLDERENGLISH
			FROM   	FOLDER
			WHERE   ISACTIVE=1";
			} else {
				$sql = "
			SELECT 	FOLDER.FOLDERID,
					FOLDER.FOLDERENGLISH,
					FOLDER.MODULEID,
					FOLDERACCESS.TEAMID,
					FOLDERACCESS.FOLDERACCESSVALUE,
			FROM   	FOLDERACCESS
			JOIN	FOLDER
			USING	(FOLDERID)
			WHERE   FOLDER.ISACTIVE=1";
			}
			if (isset ( $teamId )) {
				$sql .= " AND FOLDERACCESS.TEAMID='" . $teamId . "'";
			}
			if (isset ( $moduleId )) {
				$sql .= " AND FOLDER.MODULEID='" . $moduleId . "'";
			}
		} else if ($this->getVendor () == self::POSTGRESS) {
			if ($type == 1) {
				$sql = "
			SELECT 	FOLDER.FOLDERID,
					FOLDER.FOLDERENGLISH
			FROM   	FOLDER
			WHERE   ISACTIVE=1";
			} else {
				$sql = "
			SELECT 	FOLDER.FOLDERID,
					FOLDER.FOLDERENGLISH,
					FOLDER.MODULEID,
					FOLDERACCESS.TEAMID,
					FOLDERACCESS.FOLDERACCESSVALUE,
			FROM   	FOLDERACCESS
			JOIN	FOLDER
			USING	(FOLDERID)
			WHERE   FOLDER.ISACTIVE=1";
			}
			if (isset ( $teamId )) {
				$sql .= " AND FOLDERACCESS.TEAMID='" . $teamId . "'";
			}
			if (isset ( $moduleId )) {
				$sql .= " AND FOLDER.MODULEID='" . $moduleId . "'";
			}
		}
	
		$result = $this->q->fast ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ('success' => false, 'message' => $this->q->responce ) );
			
			exit ();
		}
		$total = $this->q->numberRows ( $result );
		$items = array ();
		if ($total > 0) {
			while ( ($row = $this->q->fetchAssoc ( $result )) == TRUE ) {
				$items [] = $row;
			}
		}
		if ($total == 1) {
			$jsonEncode = json_encode ( array ('success' => true, 'total' => $total, 'message' => "data loaded" ,'folder' => $items ) );
		//	$jsonEncode = str_replace ( "[", "", $jsonEncode );
		//	$jsonEncode = str_replace ( "]", "", $jsonEncode );
			echo $jsonEncode;
			exit ();
		} else {
			echo json_encode ( array ('success' => true, 'total' => $total, 'folder' => $items, 'message' => "data loaded" ) );
			exit ();
		}
	}
	
	/**
	 * Google Api Change Language
	 * @param string $from
	 * @param string $to
	 * @param string $value
	 * @return Ambigous <string, multitype:>
	 */
	function changeLanguage($from, $to, $value) {
		$value = urlencode ( $value );
		$handle = fopen ( "https://www.googleapis.com/language/translate/v2?key=" . $this->googleId . "&q=" . $value . "&source=" . $from . "&target=" . $to . "&callback=handleResponse&prettyprint=TRUE", "rb" );
		$contents = stream_get_contents ( $handle );
		$a = explode ( ":", $contents );
		$x = explode ( "'", $a [3] );
		fclose ( $handle );
		if (strlen ( $x [1] ) == 0) {
			$x [1] = 'undefined';
		}
		return $x [1];
	}
	function setLanguageId($value) {
		$this->languageId = $value;
	}
	function getLanguageId() {
		return $this->languageId;
	}
}
?>
