<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../model/languageModel.php");
/**
 * this is leafUser setting files.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package leafUser
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class leafUserClass extends configClass
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
	 * Current Table leafUser Identification Value
	 * @var numeric $leafUserId
	 */
	public $leafUserId;
	/**
	 * leafUser Model
	 * @var string $leafUserModel
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
	 * Language
	 * @var string $languageId
	 */
	public $languageId;
	/**
	 * Class Loader
	 */
	function execute()
	{
		parent::__construct();

		$this->q              = new vendor();
		$this->q->vendor      = $this->vendor;
		$this->q->leafId      = $this->leafId;
		$this->q->staffId     = $this->staffId;
		$this->q->filter      = $this->filter;
		$this->q->quickFilter = $this->quickFilter;
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->audit         = 0;
		$this->log           = 1;
		$this->q->log        = $this->log;

		$this->model         = new languageModel;
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

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
		if($this->isAdmin == 0) {
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	`language`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[language].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"language\".\"isActive\"	=	1	";
			}
		} else if($this->isAdmin ==1) {
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	 1 ";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	or 1 ";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = " or 1 ";
			}
		}
		//UTF8
		$items=array();
		if ($this->getVendor() == self::mysql) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
					SELECT	`language`.`languageId`,
							`language`.`languageCode`,
							`language`.`languageDesc`,
							`language`.`isDefault`,
							`language`.`isNew`,
							`language`.`isDraft`,
							`language`.`isUpdate`,
							`language`.`isDelete`,
							`language`.`isActive`,
							`language`.`isApproved`,
							`language`.`By`,
							`language`.`Time`,
							`staff`.`staffName`
 					FROM 	`language`
					JOIN	`staff`
					ON		`language`.`By` = `staff`.`staffId`
					WHERE 	".$this->auditFilter;
			if ($this->model->getlanguageId('','single')) {
				$sql .= " AND `".$this->model->getTableName()."`.`".$this->model->getPrimaryKeyName()."`=\"". $this->model->getlanguageId('','single') . "\"";

			}

		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
					SELECT	[language].[languageId],

							[language].[languageCode],
							[language].[languageDesc],
							[language].[isDefault],
							[language].[isNew],
							[language].[isDraft],
							[language].[isUpdate],
							[language].[isDelete],
							[language].[isActive],
							[language].[isApproved],
							[language].[By],
							[language].[Time],
							[staff].[staffName]
					FROM 	[language]
					JOIN	[staff]
					ON		[language].[By] = [staff].[staffId]
					WHERE 	[language].[isActive] ='1'	";
			if ($this->model->getlanguageId('','single')) {
				$sql .= " AND [".$this->model->getTableName()."].[".$this->model->getPrimaryKeyName()."]=\"". $this->model->getlanguageId('','single') . "\"";
			}
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
					SELECT	\"language\".\"languageId\",
							\"language\".\"languageCode\",

							\"language\".\"languageDesc\",
							\"language\".\"isDefault\",
							\"language\".\"isNew\",
							\"language\".\"isDraft\",
							\"language\".\"isUpdate\",
							\"language\".\"isDelete\",
							\"language\".\"isActive\",
							\"language\".\"isApproved\",
							\"language\".\"By\",
							\"language\".\"Time\",
							\"staff\".\"staffName\"
					FROM 	\"language\"
					JOIN	\"staff\"
					ON		\"language\".\"By\" = \"staff\".\"staffId\"
					WHERE 	\"isActive\"='1'	";
			if ($this->model->getlanguageId('','single')) {
				$sql .= " AND \"".$this->model->getTableName()."\".\"".$this->model->getPrimaryKeyName()."\"=\"". $this->model->getlanguageId('','single') . "\"";
			}
		} else {
			echo json_encode(array(
                "success" => false,
                "message" => "Undefine Database Vendor"
                ));
                exit();
		}
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array(
            'languageId'
            );
            /**
             *	filter table
             * @variables $tableArray
             */
            $tableArray  = null;
            $tableArray  = array(
            'language'
            );
            if ($this->getfieldQuery()) {
            	if ($this->getVendor() == self::mysql) {
            		$sql .= $this->q->quickSearch($tableArray, $filterArray);
            	} else if ($this->getVendor() == self::mssql) {
            		$tempSql = $this->q->quickSearch($tableArray, $filterArray);
            		$sql .= $tempSql;
            	} else if ($this->getVendor() == self::oracle) {
            		$tempSql = $this->q->quickSearch($tableArray, $filterArray);
            		$sql .= $tempSql;
            	}
            }
            /**
             *	Extjs filtering mode
             */
            if ($this->getGridQuery()) {

            	if ($this->getVendor() == self::mysql) {
            		$sql .= $this->q->searching();
            	} else if ($this->getVendor() == self::mssql) {
            		$tempSql2 = $this->q->searching();
            		$sql .= $tempSql2;
            	} else if ($this->getVendor() == self::oracle) {
            		$tempSql2 = $this->q->searching();
            		$sql .= $tempSql2;
            	}
            }
            /** // optional debugger.uncomment if wanted to used

            echo json_encode(array(
            "success" => false,
            "message" => $this->q->realEscapeString($sql)
            ));
            exit();

            // end of optional debugger */
            $this->q->read($sql);
            if ($this->q->execute == 'fail') {
            	echo json_encode(array(
                "success" =>false,
                "message" => $this->q->responce
            	));
            	exit();
            }
            $total = $this->q->numberRows();
            if ($this->getOrder() && $this->getSortField()) {
            	if ($this->getVendor() == self::mysql) {
            		$sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder(). " ";
            	} else if ($this->getVendor() ==  self::mssql) {
            		$sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
            	} else if ($this->getVendor() == self::oracle) {
            		$sql .= "	ORDER BY \"" . $this->getSortField() . "\"  " . $this->getOrder() . " ";
            	}
            }
            $_SESSION['sql']   = $sql; // push to session so can make report via excel and pdf
            $_SESSION['start'] = $this->getStart();
            $_SESSION['limit'] = $this->getLimit();
            if (!($this->getGridQuery())) {
            	if ($this->limit) {
            		// only mysql have limit
            		if ($this->getVendor() == self::mysql) {
            			$sql .= " LIMIT  " . $this->start . "," . $this->limit . " ";
            		} else if ($this->getVendor() == self::mssql) {
            			/**
            			 *	 Sql Server and Oracle used row_number
            			 *	 Parameterize Query We don't support
            			 */
            			$sql = "
							WITH [languageDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [languageId]) AS 'RowNumber'
								FROM [language]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[language].[languageId],

										[language].[languageCode],
										[language].[languageDesc],
										[language].[isDefault],
										[language].[isNew],
										[language].[isDraft],
										[language].[isUpdate],
										[language].[isDelete],
										[language].[isApproved],
										[language].[By],
										[language].[Time],
										[staff].[staffName]
							FROM 		[languageDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $_POST['start'] . "
							AND 			" . ($this->start + $this->limit - 1) . ";";
            		} else if ($this->getVendor() == self::oracle) {
            			/**
            			 *  Oracle using derived table also
            			 */
            			$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT  \"language\".\"languageId\",

											\"language\".\"languageCode\",
											\"language\".\"languageDesc\",
											\"language\".\"isDefault\",
											\"language\".\"isNew\",
											\"language\".\"isDraft\",
											\"language\".\"isUpdate\",
											\"language\".\"isDelete\",
											\"language\".\"isApproved\",
											\"language\".\"By\",
											\"language\".\"Time\",
											\"staff\".\"staffName\"
									FROM 	\"language\"
									WHERE \"isActive\"=1  " . $tempSql . $tempSql2 . $orderBy . "
								 ) a
						where rownum <= \"". ($this->start + $this->limit - 1) . "\" )
						where r >=  \"". $this->start . "\"";
            		} else {
            			echo "undefine vendor";
            			exit();
            		}
            	}
            }
            /*
             *  Only Execute One Query
             */
            if (!($this->model->getlanguageId('','single'))) {
            	$this->q->read($sql);
            	if ($this->q->execute == 'fail') {
            		echo json_encode(array(
                    "success" => false,
                    "message" => $this->q->responce
            		));
            		exit();
            	}
            }
            $items = array();
            while ($row = $this->q->fetchAssoc()) {
            	$items[] = $row;
            }
            if ($this->model->getlanguageId('','single')) {
            	$json_encode = json_encode(array(
                'success' => true,
                'total' => $total,
				'message' => 'Data Loaded',
                'data' => $items
            	));
            	$json_encode = str_replace("[", "", $json_encode);
            	$json_encode = str_replace("]", "", $json_encode);
            	echo $json_encode;
            } else {
            	if (count($items) == 0) {
            		$items = '';
            	}
            	echo json_encode(array(
                'success' => true,
                'total' => $total,
				'message'=>'data loaded',
                'data' => $items
            	));
            	exit();
            }
		

	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		
	}

	function tab() {
	}
	function theme() {
	}

	function language() {
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel()
	{

	}
}
/**
 *	Declare object
 **/
$leafUserObject = new leafUserClass();
if (isset($_SESSION['staffId'])) {
	$leafUserObject->staffId = $_SESSION['staffId'];
}
if (isset($_SESSION['languageId'])) {
	$leafUserObject->languageId = $_SESSION['languageId'];
}
if (isset($_SESSION['vendor'])) {
	$leafUserObject->vendor = $_SESSION['vendor'];
}
/**
 *	crud -create,read,update,delete
 **/
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_POST['leafId'])) {
		$leafUserObject->leafId = $_POST['leafId'];
	}
	if (isset($_POST['leafUserId'])) {
		$leafUserObject->leafUserId = $_POST['leafUserId'];
	}
	if (isset($_POST['filter'])) {
		$leafUserObject->filter = $_POST['filter'];
	}
	if (isset($_POST['query'])) {
		$leafUserObject->quickFilter = $_POST['query'];
	}
	if (isset($_POST['start'])) {
		$leafUserObject->start = $_POST['start'];
	}
	if (isset($_POST['perPage'])) {
		$leafUserObject->limit = $_POST['perPage'];
	}
	if (isset($_POST['order'])) {
		$leafUserObject->order = $_POST['order'];
	}
	if (isset($_POST['sortField'])) {
		$leafUserObject->sortField = $_POST['sortField'];
	}
	if (isset($_POST['isAdmin'])) {
		$leafUserObject->isAdmin = $_POST['isAdmin'];
	}

	/*
	 *  Load the dynamic value
	 */
	$leafUserObject->execute();

	if ($_POST['method'] == 'read') {
		$leafUserObject->read();
	}
	if ($_POST['method'] == 'save') {
		$leafUserObject->update();
	}

}
if (isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_GET['leafId'])) {
		$leafUserObject->leafId = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$leafUserObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$leafUserObject->staffId();
		}
		if ($_GET['field'] == 'languageId') {
			$leafUserObject->languageId();
		}
	}


}
?>
