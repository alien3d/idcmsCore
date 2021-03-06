<?php
session_start ();
require_once ("../../class/classAbstract.php");
/**
 * this is main setting files.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package main
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class TreeClass extends ConfigClass {
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
	 * Selected Database or Tablespace
	 * @var string $database
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
	 * Start
	 * @var string $start;`
	 */
	public $start;
	/**
	 * Limit
	 * @var string $limit
	 */
	public $limit;
	/**
	 **
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
	 * Log Sql Statement TRUE or False
	 * @var unknown_type
	 */
	private $log;
	/**
	 * Current Table main Identification Value
	 * @var numeric $mainId
	 */
	public $mainId;
	/**
	 * main Model
	 * @var string $mainModel
	 */
	public $model;
	/**
	 * Open To See Audit  Column --> approved,new,delete and e.g
	 * @var numeric $isAdmin
	 */
	public $isAdmin;
	/**
	 * Audit Filter
	 * @var string $auditFilter
	 */
	public $auditFilter;
	/**
	 * Audit Column
	 * @var string $auditColumn
	 */
	public $auditColumn;
	/**
	 * Class Loader
	 */
	function execute() {
		parent::__construct ();
		//audit property
		$this->audit 			= 	0;
		$this->log 				= 	1;

		$this->q 				= 	new Vendor ();
		$this->q->vendor 		=	$this->getVendor ();
		$this->q->leafId 		= 	$this->getLeafId ();
		$this->q->staffId 		= 	$this->getStaffId ();
		$this->q->fieldQuery 	= 	$this->getFieldQuery ();
		$this->q->gridQuery 	= 	$this->getGridQuery ();
		$this->q->log 			= 	$this->log;
		$this->q->audit 		= 	$this->audit;
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );

		$this->excel = new PHPExcel ();
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
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		$items = array ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$counterModule = 0;
		$treeJsonString = " [";
		if ($this->getVendor () == self::MYSQL) {
			 $sqlModule = "
		      SELECT    `iCore`.`moduleAccess`.`moduleAccessId`,
		      			`iCore`.`moduleAccess`.`moduleId`,
		      			`iManagement`.`team`.`teamId`,
		      			`iCore`.`moduleAccess`.`moduleAccessValue`,
		      			`iCore`.`moduleAccess`.`moduleId`,
		      			`iCore`.`moduleTranslate`.`moduleNative`,
		      			`iCore`.`icon`.`iconName`
		      FROM		`iCore`.`moduleAccess`
		      JOIN    	`iCore`.`module`
		      USING    	(`moduleId`)
		      JOIN    	`iCore`.`moduleTranslate`
		      USING    	(`moduleId`)
		      LEFT JOIN `icon`
		      USING    	(`iconId`)
		      JOIN		`iManagement`.`team`
		      USING  	(`teamId`)
		      WHERE   	`iCore`.`moduleAccess`.`teamId`			=	'" . $_SESSION ['teamId'] . "'
		      AND   	`iCore`.`moduleAccess`.`moduleAccessValue`	=  	1
		      AND    	`iCore`.`moduleTranslate`.`languageId`		=	'" . $_SESSION ['languageId'] . "'
		      AND		`iCore`.`module`.`applicationId`			=	'".$_SESSION['applicationId']."'
		      AND		`iCore`.`module`.`isActive`					=	1
		      AND		`iCore`.`moduleTranslate`.`isActive`		=	1
		      AND		`iManagement`.`team`.`isActive`							=	1
		      ORDER BY  `iCore`.`module`.`moduleSequence`   ";


		} elseif ($this->getVendor () == self::MSSQL) {
			$sqlModule = "
		      SELECT    [moduleAccessId],
		      			[moduleId],
		      			[teamId],
		      			[moduleAccessValue],
		      			[moduleId],
		      			[moduleNative],
		      			[iconName]
		      FROM     	[moduleAccess]
		      JOIN      [module]
		      ON      	[moduleAccess].[moduleId]=[module].[moduleId]
		      JOIN      [moduleTranslate]
		      ON      	[moduleTranslate].[moduleId]=[module].[moduleId]
		      LEFT JOIN [icon]
		      ON      	[icon].[iconId]=[module].[iconId]
		      JOIN		[team]
		      ON		[team].[teamId] = [moduleAccess].[teamId]
		      WHERE     [moduleAccess].[teamId]				=	'" . $_SESSION ['teamId'] . "'
		      AND   	[moduleAccess].[moduleAccessValue]	=  	1
		      AND    	[moduleTranslate].[languageId]		=	'" . $_SESSION ['languageId'] . "'
		      AND		[module].[isActive]					=	1
		      AND		[moduleTranslate].[isActive]		=	1
		      AND		[team].[isActive]					=	1
		      ORDER BY  [module].[moduleSequence]  ";
		} elseif ($this->getVendor () == self::ORACLE) {
			$sqlModule = "
		      SELECT    MODULEACCESS.MODULEACCESSID 	AS \"moduleAccessId\",
		      			MODULEACCESS.MODULEID 			AS \"moduleId\",
		      			MODULEACCESS.TEAMID 			AS \"teamId\",
		      			MODULEACCESS.MODULEACCESSVALUE 	AS \"moduleAccessValue\",
		      			MODULE.MODULEID 			 	AS \"moduleId\",
		      			MODULETRANSLATE.MODULENATIVE 	AS \"moduleNative\",
		      			ICON.ICONNAME 					AS \"iconName\"
		      FROM    	MODULEACCESS
		      JOIN    	MODULE
		      ON		MODULEACCESS.MODULEID 			= 	MODULE.MODULEID	
		      JOIN    	MODULETRANSLATE
		      ON		MODULETRANSLATE.MODULEID		= 	MODULE.MODULEID
		      LEFT	JOIN    	ICON
		      ON		ICON.ICONID						= 	MODULE.ICONID	 
		      JOIN		TEAM
		      ON		TEAM.TEAMID						= 	MODULEACCESS.TEAMID
		      WHERE    	MODULEACCESS.TEAMID				=	'" . $_SESSION ['teamId'] . "'
		      AND     	MODULEACCESS.MODULEACCESSVALUE	=  	1
		      AND      	MODULETRANSLATE.LANGUAGEID		=	'" . $_SESSION ['languageId'] . "'
		      AND		TEAM.ISACTIVE 					=	1
		      AND		MODULE.ISACTIVE`				=	1
		      AND		MODULETRANSLATE.ISACTIVE`		=	1
		      ORDER BY  MODULE.MODULESEQUENCE  ";
		}
		$resultModule = $this->q->fast ( $sqlModule );
		$totalModule = $this->q->numberRows ( $resultModule, $sqlModule );
		if ($totalModule > 0) {
			$counterModule = 0;
			while ( ($rowModule = $this->q->fetchArray ( $resultModule )) == TRUE ) {
				$moduleNative = $rowModule ['moduleNative'];
				$iconName = $rowModule ['iconName'];
				$moduleId = $rowModule ['moduleId'];
				$counterModule ++;
				$treeJsonString .= "{
						\"leaf\"	:	false,
						\"text\"	:	\"" . $moduleNative . "\",
					    \"iconCls\"	:	\"" . $iconName . "\",
					    \"expanded\":	true,";
				if ($this->getVendor () == self::MYSQL) {
							$sqlFolder = "
					      SELECT    `iCore`.`folderAccess`.`folderAccessId`,
				      				`iCore`.`folderAccess`.`folderAccessValue`,									
				      				`iCore`.`folder`.`folderId`,
				      				`iCore`.`folder`.`folderPath`,
				      				`iCore`.`folderTranslate`.`folderNative`,
				      				`iManagement`.`team`.`teamId`,
									`iCore`.`icon`.`iconName`	
					      FROM    	`iCore`.`folderAccess`
					      JOIN    	`iCore`.`folder`
					      USING    	(`folderId`)
					      JOIN    	`iCore`.`folderTranslate`
					      USING    	(`folderId`)
					      JOIN    	`iCore`.`icon`
					      USING    	(`iconId`)
					      JOIN		`iManagement`.`team`
					      USING		(`teamId`)
					      WHERE     `iCore`.`folder`.`moduleId`					=	'" . $moduleId . "'
					      AND     	`iCore`.`folderAccess`.`teamId`				=	'" . $_SESSION ['teamId'] . "'
					      AND   	`iCore`.`folderAccess`.`folderAccessValue`	=  	1
					      AND    	`iCore`.`folderTranslate`.`languageId`		=	'" . $_SESSION ['languageId'] . "'
					      AND		`iCore`.`folder`.`applicationId`			=	'".$_SESSION['applicationId']."'					      
					      AND		`iManagement`.`team`.`isActive`				=	1
					      AND		`iCore`.`folderTranslate`.`isActive`		=   1
					      AND		`iCore`.`folder`.`isActive`					=	1 		
					      ORDER BY  `iCore`.`folder`.`folderSequence`  ";
				} elseif ($this->getVendor () == self::MSSQL) {
					$sqlFolder = "
				      SELECT    [folderAccessId],
				      			[teamId],
				      			[folderAccessValue],
				      			[folderId],
				      			[folderPath],
				      			[folderNative],
				      			[iconName]
				      FROM     	[folderAccess]
				      JOIN      [folder]
				      ON      	[folderAccess].[folderId]=[folder].[folderId]
				      JOIN      [folderTranslate]
				      ON      	[folderTranslate].[folderId]=[folder].[folderId]
				      JOIN      [icon]
				      ON      	[icon].[iconId]=[folder].[iconId]
				      JOIN		[team]
				      ON		[team].[teamId] = [folderAccess].[teamId]
				      WHERE     [moduleId]							=	'" . $moduleId . "'
				      AND       [folderAccess].[teamId]			=	'" . $_SESSION ['teamId'] . "'
				      AND   	[folderAccess].[folderAccessValue]	=   1
				      AND    	[folderTranslate].[languageId]		=	'" . $_SESSION ['languageId'] . "'
				      AND		[team].[isActive]					=	1
				      AND		[folderTranslate].[isActive]		=   1
					  AND		[folder].[isActive`					=	1 	
				      ORDER BY	[folder].[folderSequence]  	";
				} elseif ($this->getVendor () == self::ORACLE) {
					$sqlFolder = "
				      SELECT    FOLDERACCESS.FOLDERACCESSID 	AS	\"folderAccessId\",
				      			FOLDERACCESS.TEAMID 			AS 	\"teamId\",
				      			FOLDERACCESS.FOLDERACCESSVALUE 	AS 	\"folderAccessValue\",
				      			FOLDER.FOLDERID 				AS 	\"folderId\",
				      			FOLDER.FOLDERPATH				AS	\"folderPath\",
				      			FOLDERTRANSLATE.FOLDERNATIVE 	AS 	\"folderNative\",
				      			ICON.ICONNAME 					AS 	\"iconName\"
				      FROM     	FOLDERACCESS
				      JOIN    	FOLDER
				      ON		FOLDERACCESS.FOLDERID			= 	FOLDER.FOLDERID
				      JOIN    	FOLDERTRANSLATE
				      ON		FOLDERTRANSLATE.FOLDERID		= 	FOLDER.FOLDERID
				      LEFT JOIN	ICON
				      ON		ICON.ICONID						= 	FOLDER.ICONID
				      JOIN      TEAM
				      ON		TEAM.TEAMID						= 	FOLDERACCESS.TEAMID
				      WHERE     FOLDER.MODULEID					=	'" . $moduleId . "'
				      AND       FOLDERACCESS.TEAMID				=	'" . $_SESSION ['teamId'] . "'
				      AND     	FOLDERACCESS.FOLDERACCESSVALUE	=  	1
				      AND      	FOLDERTRANSLATE.LANGUAGEID		=	'" . $_SESSION ['languageId'] . "'
				      AND		TEAM.ISACTIVE 					=	1
				      AND		FOLDERTRANSLATE.ISACTIVE`		=   1
					  AND		FOLDER.ISACTIVE					=	1 	
				      ORDER BY  FOLDER.FOLDERSEQUENCE  ";
				}
				$resultFolder = $this->q->fast ( $sqlFolder );
				$totalFolder = $this->q->numberRows ( $resultFolder, $sqlFolder );
				$counterFolder = 0;
				if ($totalFolder > 0) {
					$treeJsonString .= "\"children\":[";
					while ( ($rowFolder = $this->q->fetchArray ( $resultFolder )) == TRUE ) {
						$folderNative = $rowFolder ['folderNative'];
						$iconName = $rowFolder ['iconName'];
						$folderId = $rowFolder ['folderId'];
						$folderPath = $rowFolder ['folderPath'];
						$counterFolder ++;
						$treeJsonString .= " {
              						\"leaf\"		:	false,
									\"expanded\"  	: 	true, 
              						\"text\" 	  	:	\"" . $folderNative. "\", 
              						\"iconCls\"		:	\"" . $iconName . "\",";
						$counter_leaf = 0;
						if ($this->getVendor () == self::MYSQL) {
							  $sqlLeaf = "
					          SELECT   	`iCore`.`leafAccess`.`leafAccessId`,
						      			`iCore`.`leafAccess`.`staffId`,
						      			`iCore`.`leafAccess`.`leafAccessReadValue`,
						      			`iCore`.`leaf`.`leafId`,
						      			`iCore`.`leaf`.`leafFilename`,
						      			`iCore`.`leafTranslate`.`leafNative`,
						      			`iCore`.`icon`.`iconName`
					          FROM    	`iCore`.`leafAccess`
					          JOIN    	`iCore`.`leaf`
					          USING    (`leafId`)
					          JOIN    	`iCore`.`leafTranslate`
					          USING    (`leafId`)
					          JOIN    	`iCore`.`icon`
					          USING    (`iconId`)
					          WHERE    	`iCore`.`leaf`.`folderId`					=	'" . $folderId . "'
					          AND      	`iCore`.`leaf`.`moduleId`					=	'" . $moduleId . "'
					          AND      	`iCore`.`leafAccess`.`staffId`		=	'" . $_SESSION ['staffId'] . "'
					          AND      	`iCore`.`leafTranslate`.`languageId`	=	'" . $_SESSION ['languageId'] . "'
					          AND		`iCore`.`leaf`.`applicationId`		=	'".$_SESSION['applicationId']."'
					          AND		`iCore`.`leaf`.`isActive`			=	1
					          AND		`iCore`.`leafTranslate`.`isActive`  =   1			          
					          ORDER BY  `iCore`.`leaf`.`leafSequence`  ";

							//print"<br>".$sqlLeaf."<br>";
						} elseif ($this->getVendor () == self::MSSQL) {
							$sqlLeaf = "
					          SELECT   	[leafAccessId],
						      			[staffId],
						      			[leafAccessReadValue],
						      			[leafId],
						      			[leafFilename],
						      			[leafNative],
						      			[iconName]
					          FROM    	[leafAccess]
					          JOIN      [leaf]
					          ON      	[leafAccess].[leafId]=[leaf].[leafId]
					          JOIN      [leafTranslate]
					          ON      	[leafTranslate].[leafId]=[leaf].[leafId]
					          JOIN      [icon]
					          ON      	[icon].[iconId]=[leaf].[iconId]
					          WHERE     [folderId]						=	'" . $folderId . "'
					          AND      	[moduleId]						=	'" . $moduleId . "'
					          AND      	[leafAccess].[staffId]			=	'" . $_SESSION ['staffId'] . "'
					          AND      	[leafTranslate].[languageId]	=	'" . $_SESSION ['languageId'] . "'
					          ORDER BY  [leaf].[leafSequence]";
						} elseif ($this->getVendor () == self::ORACLE) {
							$sqlLeaf = "
					          SELECT  	LEAFACCESS.LEAFACCESSID 		AS 	\"leafAccessId\",
						      			LEAFACCESS.STAFFID 				AS 	\"staffId\",
						      			LEAFACCESS.leafAccessReadValue 	AS	\"leafAccessReadValue\",
						      			LEAF.LEAFID 					AS 	\"leafId\",
						      			LEAF.LEAFFILENAME				AS	\"leafFilename\",
						      			LEAFTRANSLATE.LEAFNATIVE 		AS 	\"leafNative\",
						      			ICON.ICONNAME 					AS	\"iconName\"
					          FROM   	LEAFACCESS
					          JOIN    	LEAF
					          ON		LEAF.LEAFID						= 	LEAFACCESS.LEAFID
					          JOIN      LEAFTRANSLATE
					          ON		LEAFTRANSLATE.LEAFID			= 	LEAF.LEAFID
					          LEFT JOIN ICON
					          ON		ICON.ICONID						= 	LEAF.ICONID
					          JOIN		STAFF	
					          ON		STAFF.STAFFID					=  	LEAFACCESS.STAFFID
					          WHERE     LEAF.FOLDERID					=	'" . $folderId . "'
					          AND		LEAF.MODULEID					=	'" . $moduleId . "'
					          AND      	LEAFACCESS.STAFFID				=	'" . $_SESSION ['staffId'] . "'
					          AND      	LEAFTRANSLATE.LANGUAGEID		=	'" . $_SESSION ['languageId'] . "'
					          AND		LEAFACCESS.leafAccessReadValue 	=	1
					          ORDER BY  LEAF.LEAFSEQUENCE";
						}
						$resultLeaf = $this->q->fast ( $sqlLeaf );
						$totalLeaf = $this->q->numberRows ( $resultLeaf, $sqlLeaf );
						$counterLeaf = 0;
						if ($totalLeaf > 0) {
							$treeJsonString .= "\"children\":[";
							while ( ($rowLeaf = $this->q->fetchArray ( $resultLeaf )) == TRUE ) {
								$leafNative = $rowLeaf ['leafNative'];
								$iconName = $rowLeaf ['iconName'];
								$leafFilename = $rowLeaf ['leafFilename'];
								$counterLeaf ++;
								$treeJsonString .= " {
											
											\"text\" 			: 	\"" . $leafNative . "\", 
							                \"folderPath\"		:	\"" . $folderPath . "\",
							                \"leafFilename\"	:	\"" . $leafFilename . "\",
											\"emptyLeaf\"		:	false,
							                \"leaf\" 			:	true, 
							                \"iconCls\" 		: 	\"" . $iconName . "\"
							            } ";
								if ($counterLeaf != $totalLeaf) {
									$treeJsonString .= ",";
								} else {
									$treeJsonString .= "]";
								}
							}
						} else {
							$treeJsonString .= "  \"children\" :  {
                										\"text\"		:	\"No Leaf Identify\",
                										\"emptyLeaf\"	:	true,
                										\"leaf\"		:	true 
              										}";
						}
						if ($counterFolder != $totalFolder) {
							$treeJsonString .= "},";
						} else {
							$treeJsonString .= "}]";
						}
					}
				} else {
					$treeJsonString .= "	\"children\" : {
									    		\"leaf\"		:	true,	
												\"text\"		:	\"No Folder Identify\",
												\"expanded\"	:	true
											}";
				}
				if ($counterModule != $totalModule) {
					$treeJsonString .= "},";
				} else {
					$treeJsonString .= "}]";
				}
			}
		} else {
			$treeJsonString .= " \"children\" :{
									\"leaf\"		:	true,
									\"text\"		:	\"No module Identify\",
									\"expanded\"	:	true 
								}]";
		}
//		$treeJsonString = preg_replace('/\s+/', '', $treeJsonString);
		$x = json_decode($treeJsonString);
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode($x);
		exit();
		//echo $treeJsonString;
	}
	/*
	 (non-PHPdoc) * @see config::update() */	function update() {
	 }
	 /*
	  (non-PHPdoc) * @see config::delete() */	function delete() {
	  }
	  /*
	   (non-PHPdoc) * @see config::excel() */	function excel() {
	   }
}
$treeObject = new TreeClass ();
/** * crud
 **/
if (isset ( $_POST ['method'] )) {
	/* *
	 Initilize Value before load in the loader */
	if (isset ( $_POST ['leafId'] )) {
		$treeObject->setLeafId ( $_POST ['leafId'] );
	}
	if (isset ( $_POST ['isAdmin'] )) {
		$treeObject->setIsAdmin ( $_POST ['isAdmin'] );
	}
	/* * Load the dynamic value */
	$treeObject->execute ();
	if ($_POST ['method'] == 'read') {
		$treeObject->read ();
	}
}
?>

