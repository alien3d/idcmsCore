<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../class/classDocumentTrail.php");

/**
 * this is Quick Code Combo.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package main
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class quickCodeClass extends configClass
{
	/**
	 * Connection to the database
	 * @var string $excel
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
	 * @var string $query
	 */
	public $query;
	/**
	 * Fast Search Variable
	 * @var string $quickFilter
	 */
	public $quickFilter;
	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string $excel
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
	 *  Limit
	 * @var string $limit
	 */
	public $limit;
	/**
	 /**
	 *  Ascending ,Descending ASC,DESC
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
	 * Audit Row True or False
	 * @var boolean $audit
	 */
	private $audit;
	/**
	 * Log Sql Statement True or False
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
	function execute()
	{
		parent::__construct();

		$this->q = new vendor();
		$this->q->vendor = $this->getVendor();
		$this->q->leafId = $this->getLeafId();
		$this->q->staffId = $this->getStaffId();
		$this->q->fieldQuery = $this->getFieldQuery();
		$this->q->gridQuery = $this->getGridQuery();

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());
		$this->excel = new PHPExcel();
		$this->audit = 0;
		$this->log = 1;
		$this->q->log = $this->log;

			
		$this->documentTrail = new documentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->setStaffId($this->getStaffId());
		$this->documentTrail->setLanguageId($this->getLanguageId());
		$this->documentTrail->setLeafId($this->getLeafId());
		$this->documentTrail->execute();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create()
	{
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read()
	{
		header('Content-Type', 'application/json; charset=utf-8');

		//UTF8
		$items = array();
		if ($this->getVendor() == self::mysql) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$counterModule = 0;
		echo " [";
		if ($this->getVendor() == self::mysql) {
			$sqlModule = "
      SELECT    *
      FROM     `moduleAccess`
      JOIN    `module`
      USING    (`moduleId`)
      JOIN    `moduleTranslate`
      USING    (`moduleId`)
      JOIN    `icon`
      USING    (`iconId`)
      WHERE   `moduleAccess`.`groupId`='" . $_SESSION['groupId'] . "'
      AND   `moduleAccess`.`moduleAccessValue`=  1
      AND    `moduleTranslate`.`languageId`=\"" . $_SESSION['languageId'] . "\"
      ORDER BY   `module`.`moduleSequence`   ";
			//	print"<br><br>";
		} elseif ($this->getVendor() == 'microsoft') {
			$sqlModule = "
      SELECT    *
      FROM     [moduleAccess]
      JOIN      [module]
      ON      [moduleAccess].[moduleId]=[module].[moduleId]
      JOIN      [moduleTranslate]
      ON      [moduleTranslate].[moduleId]=[module].[moduleId]
      JOIN      [icon]
      ON      [icon].[iconId]=[module].[iconId]
      WHERE     [moduleAccess].[groupId]='" . $_SESSION['groupId'] . "'
      AND   [moduleAccess].[moduleAccessValue]=  1
      AND    [moduleTranslate].[languageId]=\"" . $_SESSION['languageId'] . "\"
      ORDER BY   [module].[moduleSequence]  ";

		} elseif ($this->getVendor() == 'oracle') {
			$sqlModule = "
      SELECT    *
      FROM     \"moduleAccess\"
      JOIN    \"module\"
      USING    (\"moduleId\")
      JOIN    \"moduleTranslate\"
      USING    (\"moduleId\")
      JOIN    \"icon\"
      USING    (\"iconId\")
      WHERE    \"moduleAccess\".\"groupId\"='" . $_SESSION['groupId'] . "'
      AND     \"moduleAccess\".\"moduleAccessValue\"=  1
      AND      \"moduleTranslate\".\"languageId\"=\"" . $_SESSION['languageId'] . "\"
      ORDER BY   \"module\".\"moduleSequence\"   ";
		}
		
		$resultModule = $this->q->fast($sqlModule);
		$totalModule = $this->q->numberRows($resultModule, $sqlModule);

		if ($totalModule > 0) {
			$counterModule=0;
			while ($rowModule = $this->q->fetchArray($resultModule)) {
				$moduleTranslate = $rowModule['moduleTranslate'];
				$iconName = $rowModule['iconName'];
				$moduleId = $rowModule['moduleId'];
				$counterModule++;
				echo "{
						\"leaf\":false,
						\"text\":\"".$moduleTranslate."\",
					    \"iconCls\":\"".$iconName."\",
					    \"expanded\": true,";
				if ($this->getVendor() == self::mysql) {
					$sqlFolder = "
      SELECT    *
      FROM     `folderAccess`
      JOIN    `folder`
      USING    (`folderId`)
      JOIN    `folderTranslate`
      USING    (`folderId`)
      JOIN    `icon`
      USING    (`iconId`)
      WHERE     `moduleId`=\"" . $moduleId . "\"
      AND     `folderAccess`.`groupId`='" . $_SESSION['groupId'] . "'
      AND   `folderAccess`.`folderAccessValue`=  1
      AND    `folderTranslate`.`languageId`=\"" . $_SESSION['languageId'] . "\"
      ORDER BY   `folder`.`folderSequence`  ";
					//	print"<br>";
				} elseif ($this->getVendor() == 'microsoft') {
					$sqlFolder = "
      SELECT    *
      FROM     [folderAccess]
      JOIN      [folder]
      ON      [folderAccess].[folderId]=[folder].[folderId]
      JOIN      [folderTranslate]
      ON      [folderTranslate].[folderId]=[folder].[folderId]
      JOIN      [icon]
      ON      [icon].[iconId]=[folder].[iconId]
      WHERE     [moduleId]=\"" . $moduleId . "\"
      AND       [folderAccess].[groupId]='" . $_SESSION['groupId'] . "'
      AND   [folderAccess].[folderAccessValue]=  1
      AND    [folderTranslate].[languageId]=\"" . $_SESSION['languageId'] . "\"
      ORDER BY   [folder].[folderSequence]  ";
				} elseif ($this->getVendor() == 'oracle') {
					$sqlFolder = "
      SELECT    *
      FROM     \"folderAccess\"
      JOIN    \"folder\"
      USING    (\"folderId\")
      JOIN    \"folderTranslate\"
      USING    (\"folderId\")
      JOIN    \"icon\"
      USING    (\"iconId\")
      WHERE     \"moduleId\"=\"" . $moduleId . "\"
      AND     \"folderAccess\".\"groupId\"='" . $_SESSION['groupId'] . "'
      AND     \"folderAccess\".\"folderAccessValue\"=  1
      AND      \"folderTranslate\".\"languageId\"=\"" . $_SESSION['languageId'] . "\"
      ORDER BY   \"folder\".\"folderSequence\"  ";
				}

				$resultFolder = $this->q->fast($sqlFolder);
				$totalFolder = $this->q->numberRows($resultFolder, $sqlFolder);
				$counterFolder=0;
			
				if ($totalFolder > 0) {
						echo "\"children\":[";
					while ($rowFolder = $this->q->fetchArray($resultFolder)) {
						$folderTranslate = $rowFolder['folderTranslate'];
						$iconName = $rowFolder['iconName'];
						$folderId = $rowFolder['folderId'];
						$folderPath = $rowFolder['folderPath'];

						$counterFolder++;
						echo " {
              						\"leaf\":false,
									\"expanded\"  : true, 
              						\"text\" 	  : \"" . $folderTranslate . "\", 
              						\"iconCls\"   : \"" . $iconName . "\",";
						$counter_leaf = 0;
						if ($this->getVendor() == self::mysql) {
							$sqlLeaf = "
          SELECT    *
          FROM    `leafAccess`
          JOIN    `leaf`
          USING    (`leafId`)
          JOIN    `leafTranslate`
          USING    (`leafId`)
          JOIN    `icon`
          USING    (`iconId`)
          WHERE     `folderId`=\"" . $folderId . "\"
          AND      `moduleId`=\"" . $moduleId . "\"
          AND      `leafAccess`.`staffId`=\"" . $_SESSION['staffId'] . "\"
          AND      `leafTranslate`.`languageId`=\"" . $_SESSION['languageId'] . "\"
          ORDER BY  `leaf`.`leafSequence`  ";
							//	print"<br><br>";
						} elseif ($this->getVendor() == 'microsoft') {
							$sqlLeaf = "
          SELECT    *
          FROM    [leafAccess]
          JOIN      [leaf]
          ON      [leafAccess].[leafId]=[leaf].[leafId]
          JOIN      [leafTranslate]
          ON      [leafTranslate].[leafId]=[leaf].[leafId]
          JOIN      [icon]
          ON      [icon].[iconId]=[leaf].[iconId]
          WHERE     [folderId]=\"" . $folderId . "\"
          AND      [moduleId]=\"" . $moduleId . "\"
          AND      [leafAccess].[staffId]=\"" . $_SESSION['staffId'] . "\"
          AND      [leafTranslate].[languageId]=\"" . $_SESSION['languageId'] . "\"
          ORDER BY  [leaf].[leafSequence]";
						} elseif ($this->getVendor() == 'oracle') {
							$sqlLeaf = "
          SELECT    *
          FROM    \"leafAccess\"
          JOIN    \"leaf\"
          USING    (\"leafId\")
          JOIN    \"leafTranslate\"
          USING    (\"leafId\")
          JOIN    \"icon\"
          USING    (\"iconId\")
          WHERE     \"folderId\"=\"" . $folderId . "\"
          AND      \"moduleId\"=\"" . $moduleId . "\"
          AND      \"leafAccess\".\"staffId\"=\"" . $_SESSION['staffId'] . "\"
          AND      \"leafTranslate\".\"languageId\"=\"" . $_SESSION['languageId'] . "\"";
						}
						$resultLeaf = $this->q->fast($sqlLeaf);
						$totalLeaf = $this->q->numberRows($resultLeaf, $sqlLeaf);
						$counterLeaf=0;
						if ($totalLeaf > 0) {
							echo "\"children\":[";
							while ($rowLeaf = $this->q->fetchArray($resultLeaf)) {
								$leafTranslate = $rowLeaf['leafTranslate'];
								$iconName = $rowLeaf['iconName'];
								$leafFilename = $rowLeaf['leafFilename'];

								$counterLeaf++;
								echo " {
											
											\"text\" : \"" . $leafTranslate . "\", 
							                \"leaf\" : true, 
							                \"iconCls\" : \"" . $iconName . "\"
							            } ";
								if ($counterLeaf != $totalLeaf) {
									echo ",";
								} else {
									echo "]";
								}
							}
						} else {
							
							echo "  \"children\" :  {
                									\"text\":\"No Leaf Identify\",
                									\"leaf\":true 
              				}";
              				
						}
							
						if ($counterFolder != $totalFolder) {
							echo "},";
						} else {
							echo "}]";
						}
					}
						
				} else {
					
					echo "	\"children\" : { 
										\"leaf\":true,	
										\"text\":\"No Folder Identify\",
										\"expanded\":true
									}";
					
				}
				if($counterModule != $totalModule) {
					echo "},";
				}else {
					echo "}]";
				}
			}

		} else {
			echo " \"children\" :{ 
									\"leaf\":true,
									\"text\":\"No module Identify\",
									\"expanded\":true 
								}";
		}
			
	}

	/*
	 (non-PHPdoc) * @see config::update() */ function update()
	{
	}
	/*
	 (non-PHPdoc) * @see config::delete() */ function delete()
	{
	}
	function
	tab()
	{
	}
	function themeId()
	{
	}
	function languageId()
	{
	}
	/*
	 (non-PHPdoc) * @see config::excel() */ function excel()
	{
	}
}
/** *
 Declare object **/ $quickCodeObject = new quickCodeClass();
if (isset($_SESSION['staffId'])) {
	$quickCodeObject->staffId = $_SESSION['staffId'];
}
if (isset($_SESSION['vendor'])) {
	$quickCodeObject->vendor = $_SESSION['vendor'];
}
/** * crud
 -create,read,update,delete **/ if (isset($_POST['method']))
{
	/* *
	 Initilize Value before load in the loader */ if (isset($_POST['leafId']))
	{
		$quickCodeObject->leafId = $_POST['leafId'];
	}
	if (isset($_POST['mainId'])) {
		$quickCodeObject->mainId = $_POST['mainId'];
	}
	if (isset($_POST['filter'])) {
		$quickCodeObject->filter = $_POST['filter'];
	}
	if (isset($_POST['query'])) {
		$quickCodeObject->quickFilter = $_POST['query'];
	}
	if (isset($_POST['start'])) {
		$quickCodeObject->start = $_POST['start'];
	}
	if (isset($_POST['perPage'])) {
		$quickCodeObject->limit = $_POST['perPage'];
	}
	if (isset($_POST['order'])) {
		$quickCodeObject->order = $_POST['order'];
	}
	if (isset($_POST['sortField'])) {
		$quickCodeObject->sortField = $_POST['sortField'];
	}
	if (isset($_POST['isAdmin'])) {
		$quickCodeObject->isAdmin = $_POST['isAdmin'];
	}
	if (isset($_POST['auditColumn'])) {
		$quickCodeObject->auditColumn = $_POST['auditColumn'];
	}
	/* * Load the dynamic value */
	$quickCodeObject->execute();
	if ($_POST['method'] == 'read') {
		$quickCodeObject->read();
	}
	if ($_POST['method'] == 'save') {
		$quickCodeObject->update();
	}
}
if (isset($_GET['method'])) {
	/* * Initilize
	 Value before load in the loader */ if (isset($_GET['leafId']))
	{
		$quickCodeObject->leafId = $_GET['leafId'];
	}
	/* * Load the dynamic value */
	$quickCodeObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$quickCodeObject->staffId();
		}
		if ($_GET['field'] == 'languageId') {
			$quickCodeObject->languageId();
		}
	}
}
$quickCodeObject->execute();
$quickCodeObject->read();
?>

