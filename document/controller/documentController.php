<?php
session_start ();
require_once ("../../class/classAbstract.php");
require_once("../../class/classRecordSet.php");
require_once ("../../class/classDate.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../../class/classSystemString.php");
require_once ("../model/documentModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Document
 * @subpackage Document
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class DocumentClass extends ConfigClass {
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
	 *  Record Pagination
	 * @var string
	 */
	private $recordSet;
	/**
	 * Document Trail Audit.
	 * @var string
	 */
	private $documentTrail;
	/**
	 * System String Message.
	 * @var string $systemString;
	 */
	public $systemString;
	/**
	 * Audit Row TRUE or False
	 * @var bool
	 */
	private $audit;
	/**
	 * Log Sql Statement TRUE or False
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
	 * Path document will be uploaded
	 * @var string
	 */
	public $path;
	/**
	 * Maximum File Size Upload
	 * @var float
	 */
	public $maximumFileSize;
	/**
	 * Valid file extensions (images, word, excel, powerpoint)
	 * @var string
	 */
	public $validFileType;
	/**
	 * Class Loader
	 */
	function execute() {
		parent::__construct ();
		//audit property
		$this->audit = 0;
		$this->log = 1;

		/*
		 * Upload Setting
		 */
		$this->maximumFileSize = 100 * 1024 * 1024; // eq to 100 mb
		$this->validFileType = "/^\\.(jpg|jpeg|gif|png|doc|docx|txt|rtf|pdf|xls|xlsx|ppt|pptx){1}$/i";
		$this->path = $_SERVER ["DOCUMENT_ROOT"] . "idcmsCore/document/document/user/" . $this->getStaffId () . "/";

		$this->model = new DocumentModel ();
		$this->model->setVendor ( $this->getVendor () );
		$this->model->execute ();

		$this->q = new Vendor ();
		$this->q->vendor = $this->getVendor ();
		$this->q->leafId = $this->getLeafId ();
		$this->q->staffId = $this->getStaffId ();
		$this->q->fieldQuery = $this->getFieldQuery ();
		$this->q->gridQuery = $this->getGridQuery ();
		$this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
		$this->q->log = $this->log;
		$this->q->audit = $this->audit;
		$this->q->setRequestDatabase($this->getRequestDatabase());
		$this->q->connect ( $this->getConnection (), $this->getUsername (), $this->getDatabase (), $this->getPassword () );

		$this->systemString = new SystemString();
		$this->systemString->setVendor($this->getVendor());
		$this->systemString->setLeafId($this->getLeafId());
		$this->systemString->execute();

		$this->recordSet =  new RecordSet();
		$this->recordSet->setTableName($this->model->getTableName());
		$this->recordSet->setPrimaryKeyName($this->model->getPrimaryKeyName());
		$this->recordSet->execute();

		$this->documentTrail = new DocumentTrailClass ();
		$this->documentTrail->setVendor ( $this->getVendor () );
		$this->documentTrail->setStaffId ( $this->getStaffId () );
		$this->documentTrail->setLanguageId ( $this->getLanguageId () );
		$this->documentTrail->setLeafId ( $this->getLeafId () );
		$this->documentTrail->execute ();

		$this->excel = new PHPExcel ();

	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	function create() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->start ();
		$this->model->create ();
		$isFile = is_uploaded_file ( $_FILES ['documentFilename'] ['tmp_name'] );
		if ($isFile) {
			$safeFilename = preg_replace ( array ("/\\s+/", "/[^-\\.\\w]+/" ), array ("_", "" ), trim ( $_FILES ['documentFilename'] ['name'] ) );
			$fileSize = $_FILES ['documentFilename'] ['size'];
			$maxSize = $this->maximumFileSize;
			if ($_FILES ['documentFilename'] ['size'] >= $this->maximumFileSize) {
				echo json_encode ( array ("success" => false, "message" => " File To Big .File Size : " . $fileSize . " Maximum File Size " . $maxSize ) );
				exit ();
			}
			if (! (preg_match ( $this->validFileType, strrchr ( $safeFilename, '.' ) ))) {
				echo json_encode ( array ("success" => false, "message" => "not valid type" ) );
				exit ();
			}
			//	echo '{success:TRUE,message:\' 3document size :'.$fileSize.' maxSize: '.$maxSize.' \'}';
			//	exit();
			if (! is_dir ( $this->path )) {
				echo json_encode ( array ("success" => false, "message" => "Path no correct.Please change the path.Current Wrong Path : " . $this->path ) );
				exit ();
			} else {
				$this->model->setDocumentPath ( $this->path );
			}
			$originalFilename = $_FILES ['documentFilename'] ['name'];
			$findExtensionArray = explode ( '.', $originalFilename );
			$filenameWithoutExtension = $findExtensionArray [0];
			$filenameExtension = $findExtensionArray [1];
			$downloadFilename = $filenameWithoutExtension . "-" . rand ( 0, 32768 ) . "." . $filenameExtension;
			$this->model->setDocumentOriginalFilename ( $originalFilename );
			$this->model->setDocumentDownloadFilename ( $downloadFilename );
			$this->model->setDocumentExtension ( $filenameExtension );
			$isMove = move_uploaded_file ( $_FILES ['documentFilename'] ['tmp_name'], $this->path . $downloadFilename );
			if (! $isMove) {
				echo json_encode ( array ("success" => false, "message" => "Error Moving file" ) );
				exit ();
			} else {
			}
		} else {
			echo json_encode ( array ("success" => false, "message" => "File Is not uploaded" ) );
			exit ();
		}
		// create versioning
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT 	count(*) 
			FROM 	`document` 
			WHERE 	`documentOriginalFilename`	=	'" . $this->model->getDocumentOriginalFilename () . "'
			AND		`executeBy`			=   '" . $this->model->getExecuteBy () . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT 	count(*) 
			FROM 	[document] 
			WHERE 	[documentOriginalFilename]	=	'" . $this->model->getDocumentOriginalFilename () . "'
			AND		[executeBy]			=   '" . $this->model->getExecuteBy () . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT 	count(*) 
			FROM 	DOCUMENT 
			WHERE 	DOCUMENTORIGINALFILENAME	=	'" . $this->model->getDocumentOriginalFilename () . "'
			AND		EXECUTEBY			=   '" . $this->model->getExecuteBy () . "'";
		}
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$total = $this->q->numberRows ();
		$this->model->setDocumentVersion ( $total );
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
		INSERT INTO `document` 
				(
				  	`documentCategoryId`,			`leafId`,
				  	`documentSequence`,				`documentCode`,
				  	`documentNote`,					`documentTitle`,		
				  	`documentDesc`,					`documentPath`,			
				  	`documentOriginalFilename`,		`documentDownloadFilename`,
				  	`documentExtension`,			`documentVersion`,
				  	`isDefault`,					`isNew`,							
				  	`isDraft`,						`isUpdate`,							
				  	`isDelete`,						`isActive`,							
				  	`isApproved`,					`executeBy`,								
				  	`executeTime`
				)
			VALUES
				(
							
						'" . $this->model->getDocumentCategoryId () . "',				'" . $this->model->getLeafId () . "',
						'" . $this->model->getDocumentSequence () . "',					'" . $this->model->getDocumentCode () . "',
						'" . $this->model->getDocumentNote () . "',						'" . $this->model->getDocumentTitle () . "',
						'" . $this->model->getDocumentDesc () . "',						'" . $this->model->getDocumentPath () . "',
						'" . $this->model->getDocumentOriginalFilename () . "',			'" . $this->model->getDocumentDownloadFilename () . "',
						'" . $this->model->getDocumentExtension () . "',				'" . $this->model->getDocumentVersion () . "',
						'" . $this->model->getIsDefault ( 0, 'single' ) . "'				,'" . $this->model->getIsNew ( 0, 'single' ) . "',
						'" . $this->model->getIsDraft ( 0, 'single' ) . "',				'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
						'" . $this->model->getIsDelete ( 0, 'single' ) . "',				'" . $this->model->getIsActive ( 0, 'single' ) . "',
						'" . $this->model->getIsApproved ( 0, 'single' ) . "',				'" . $this->model->getExecuteBy () . "',
						" . $this->model->getExecuteTime () . "
				);";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		INSERT INTO [document] 
				(
				  	[documentCategoryId],			[leafId],
				  	[documentSequence],				[documentCode],
				  	[documentNote],					[documentTitle],		
				  	[documentDesc],					[documentPath],			
				  	[documentOriginlFilename],		[documentOriginlFilename],	
				  	[documentExtension],			[documentVersion],
				  	[isDefault],					[isNew],							
				  	[isDraft],						[isUpdate],							
				  	[isDelete],						[isActive],							
				  	[isApproved],					[executeBy],								
				  	[executeTime]
				)
			VALUES
				(
					'" . $this->model->getDocumentCategoryId () . "',			'" . $this->model->getLeafId () . "',
					'" . $this->model->getDocumentSequence () . "',			'" . $this->model->getDocumentCode () . "',
					'" . $this->model->getDocumentNote () . "',				'" . $this->model->getDocumentTitle () . "',
					'" . $this->model->getDocumentDesc () . "',				'" . $this->model->getDocumentPath () . "',
					'" . $this->model->getDocumentOriginalFilename () . "',	'" . $this->model->getDocumentDownloadFilename () . "',
					'" . $this->model->getDocumentExtension () . "',			'" . $this->model->getDocumentVersion () . "',
					'" . $this->model->getIsDefault ( 0, 'single' ) . "',		'" . $this->model->getIsNew ( 0, 'single' ) . "',
					'" . $this->model->getIsDraft ( 0, 'single' ) . "',			'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					'" . $this->model->getIsDelete ( 0, 'single' ) . "',			'" . $this->model->getIsActive ( 0, 'single' ) . "',
					'" . $this->model->getIsApproved ( 0, 'single' ) . "',		'" . $this->model->getExecuteBy () . "',
					" . $this->model->getExecuteTime () . "	
				);";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		INSERT INTO DOCUMENT
				(
				  	DOCUMENTCATEGORYID,			LEAFID,
				  	DOCUMENTSEQUENCE,			DOCUMENTCODE,
				  	DOCUMENTNOTE,				DOCUMENTTITLE,		
				  	DOCUMENTDESC,				DOCUMENTPATH,			
				  	DOCUMENTORIGINALFILENAME,	DOCUMENTDOWNLOADFILENAME,
				  	DOCUMENTEXTENSION,			DOCUMENTVERSION,
				  	ISDEFAULT,					ISNEW,							
				  	ISDRAFT,					ISUPDATE,							
				  	ISDELETE,					ISACTIVE,						
				  	ISAPPROVED,					EXECUTEBY,								
				  	EXECUTETIME
				)
			VALUES
				(
					
					'" . $this->model->getDocumentCategoryId () . "',			'" . $this->model->getLeafId () . "',
					'" . $this->model->getDocumentSequence () . "',			'" . $this->model->getDocumentCode () . "',
					'" . $this->model->getDocumentNote () . "',				'" . $this->model->getDocumentTitle () . "',
					'" . $this->model->getDocumentDesc () . "',				'" . $this->model->getDocumentPath () . "',
					'" . $this->model->getDocumentOriginalFilename () . "',	'" . $this->model->getDocumentDownloadFilename () . "',
					'" . $this->model->getDocumentExtension () . "',			'" . $this->model->getDocumentVersion () . "',
					'" . $this->model->getIsDefault ( 0, 'single' ) . "',		'" . $this->model->getIsNew ( 0, 'single' ) . "',
					'" . $this->model->getIsDraft ( 0, 'single' ) . "',			'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
					'" . $this->model->getIsDelete ( 0, 'single' ) . "',			'" . $this->model->getIsActive ( 0, 'single' ) . "',
					'" . $this->model->getIsApproved ( 0, 'single' ) . "',		'" . $this->model->getExecuteBy () . "',
					" . $this->model->getExecuteTime () . "	
				);";
		}
		$this->q->create ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$documentId = $this->q->lastInsertId ();
		$source = $this->path . $this->model->getDocumentDownloadFilename ();
		chmod ( $source, 0777 );
		$this->q->commit ();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode (
		array (	"success" => true,
					"message" => $this->systemString->getCreateMessage(), 
					"documentId" => $documentId,
					"time"=>$time
		) );
		exit ();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getIsAdmin() == 0) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	`document`.`isActive`		=	1	";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	[document].[isActive]		=	1	";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = "	DOCUMENT.ISACTIVE	=	1	";
			}
		} else if ($this->getIsAdmin() == 1) {
			if ($this->getVendor () == self::MYSQL) {
				$this->auditFilter = "	1= 1 ";
			} else if ($this->q->vendor == self::MSSQL) {
				$this->auditFilter = "	1= 1 ";
			} else if ($this->q->vendor == self::ORACLE) {
				$this->auditFilter = " 1=  1 ";
			}
		}


		if ($this->getVendor () == self::MYSQL) {
			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$items = array();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT	`document`.`documentId`,
						`document`.`documentTitle`,
						`document`.`documentDesc`,
						`document`.`documentSequence`,
						`document`.`documentCode`,
						`document`.`documentNote`,
						`document`.`isDefault`,
						`document`.`isNew`,
						`document`.`isDraft`,
						`document`.`isUpdate`,
						`document`.`isDelete`,
						`document`.`isActive`,
						`document`.`isApproved`,
						`document`.`isReview`,
						`document`.`isPost`,
						`document`.`executeBy`,
						`document`.`executeTime`,
						`staff`.`staffName`
			FROM 	`document`
			JOIN		`staff`
			ON		`document`.`executeBy` = `staff`.`staffId`
			JOIN		`documentCategory`
			USING	(`documentCategoryId`)
			WHERE 	" . $this->auditFilter;
			if ($this->model->getDocumentId ( 0, 'single' )) {
				$sql .= " AND `" . $this->model->getTableName () . "`.`" . $this->model->getPrimaryKeyName () . "`='" . $this->model->getDocumentId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	[document].[documentId],
						[document].[documentTitle],
						[document].[documentDesc],
						[document].[documentSequence],
						[document].[documentCode],
						[document].[documentNote],
						[document].[isDefault],
						[document].[isNew],
						[document].[isDraft],
						[document].[isUpdate],
						[document].[isDelete],
						[document].[isActive],
						[document].[isApproved],
						[document].[isReview],
						[document].[isPost],
						[document].[executeBy],
						[document].[executeTime],
						[staff].[staffName]
			FROM 	[document]
			JOIN		[staff]
			ON		[document].[executeBy] = [staff].[staffId]
			JOIN		[documentCategory]
			ON		[document].[documentCategoryId]=[documentCategory].[documentCategoryId]
			WHERE 		" . $this->auditFilter;
			if ($this->model->getDocumentId ( 0, 'single' )) {
				$sql .= " AND [" . $this->model->getTableName () . "].[" . $this->model->getPrimaryKeyName () . "]='" . $this->model->getDocumentId ( 0, 'single' ) . "'";
			}
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	DOCUMENT.DOCUMENTID 				AS 	\"documentId\",
						DOCUMENT.DOCUMENTTITLE			AS	\"documentTitle\",
						DOCUMENT.DOCUMENTDESC   		AS  	\"documentDesc\",
						DOCUMENT.DOCUMENTCODE   		AS  	\"documentCode\",
						DOCUMENT.DOCUMENTSEQUENCE	AS  	\"documentSequence\",
						DOCUMENT.DOCUMENTNOTE 			AS 	\"documentNote\",
						DOCUMENT.ISDEFAULT	 				AS	\"isDefault\",
						DOCUMENT.ISNEW 						AS 	\"isNew\",
						DOCUMENT.ISDRAFT  					AS 	\"isDraft\",
						DOCUMENT.ISUPDATE 					AS 	\"isUpdate\",
						DOCUMENT.ISDELETE 					AS 	\"isDelete\",
						DOCUMENT.ISACTIVE 					AS 	\"isActive\",
						DOCUMENT.ISAPPROVED	 			AS	\"isApproved\",
						DOCUMENT.ISREVIEW 					AS 	\"isReview\",
						DOCUMENT.ISPOST			 			AS	\"isPost\",
						DOCUMENT.EXECUTEBY 				AS 	\"executeBy\",
						DOCUMENT.EXECUTETIME 				AS 	\"executeTime\",
						STAFF.STAFFNAME 						AS 	\"staffName\"
			FROM 	DOCUMENT
			JOIN		STAFF
			ON		DOCUMENT.EXECUTEBY = STAFF.STAFFID
			JOIN		DOCUMENTCATEGORY
			ON		DOCUMENTCATEGORY.DOCUMENTCATEGORYID = DOCUMENT.DOCUMENTCATEGORYID
			WHERE 	 	" . $this->auditFilter;
			if ($this->model->getDocumentId ( 0, 'single' )) {
				$sql .= " AND " . strtoupper ( $this->model->getTableName () ) . "." . strtoupper ( $this->model->getPrimaryKeyName () ) . "s='" . $this->model->getDocumentId ( 0, 'single' ) . "'";
			}
		} else {
			echo json_encode ( array ("success" => false, "message" => $this->systemString->getNonSupportedDatabase() ) );
			exit ();
		}
		/**
		 * filter column based on first character
		 */
		if($this->getCharacterQuery()){
			if($this->q->vendor==self::MYSQL){
				$sql.=" AND `".$this->model->getTableName()."`.`".$this->model->getFilterCharacter()."` like '".$this->getCharacterQuery()."%'";
			} else if($this->q->vendor==self::MSSQL){
				$sql.=" AND [".$this->model->getTableName()."].[".$this->model->getFilterCharacter()."] like '".$this->getCharacterQuery()."%'";
			} else if ($this->q->vendor==self::ORACLE){
				$sql.=" AND ".strtoupper($this->model->getTableName()).".".strtoupper($this->model->getFilterCharacter())." = '".$this->getCharacterQuery()."'";
			} else if ($this->q->vendor==self::DB2){
				$sql.=" AND ".strtoupper($this->model->getTableName()).".".strtoupper($this->model->getFilterCharacter())." = '".$this->getCharacterQuery()."'";
			} else if ($this->q->vendor==self::POSTGRESS){
				$sql.=" AND ".strtoupper($this->model->getTableName()).".".strtoupper($this->model->getFilterCharacter())." = '".$this->getCharacterQuery()."'";
			}
		}
		/**
		 * filter column based on Range Of Date
		 * Example Day,Week,Month,Year
		 */
		if($this->getDateRangeStartQuery()){
			$sql.=$this->q->dateFilter($this->model->getTableName(),$this->model->getFilterDate(),$this->getDateRangeStartQuery(),$this->getDateRangeEndQuery(),$this->getDateRangeTypeQuery());
		}
		/**
		 * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 * E.g  $filterArray=array('`leaf`.`leafId`');
		 * @variables $filterArray;
		 */
		$filterArray = null;
		$filterArray = array ('documentId', 'documentCategoryId' );
		/**
		 * filter table
		 * @variables $tableArray
		 */
		$tableArray = null;
		$tableArray = array ('document' );
		if ($this->getfieldQuery ()) {
			if ($this->getVendor () == self::MYSQL) {
				$sql .= $this->q->quickSearch ( $tableArray, $filterArray );
			} else if ($this->getVendor () == self::MSSQL) {
				$tempSql = $this->q->quickSearch ( $tableArray, $filterArray );
				$sql .= $tempSql;
			} else if ($this->getVendor () == self::ORACLE) {
				$tempSql = $this->q->quickSearch ( $tableArray, $filterArray );
				$sql .= $tempSql;
			}
		}
		/**
		 * Extjs filtering mode
		 */
		if ($this->getGridQuery ()) {
			if ($this->getVendor () == self::MYSQL) {
				$sql .= $this->q->searching ();
			} else if ($this->getVendor () == self::MSSQL) {
				$tempSql2 = $this->q->searching ();
				$sql .= $tempSql2;
			} else if ($this->getVendor () == self::ORACLE) {
				$tempSql2 = $this->q->searching ();
				$sql .= $tempSql2;
			}
		}
		/** // optional debugger.uncomment if wanted to used

		echo json_encode(array(
		"success" => false,
		"message" => $this->q->realEscapeString($sql)
		));
		exit();

		*/
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$total = $this->q->numberRows ();
		if ($this->getOrder () && $this->getSortField ()) {
			if ($this->getVendor () == self::MYSQL) {
				$sql .= "	ORDER BY `" . $this->getSortField () . "` " . $this->getOrder () . " ";
			} else if ($this->getVendor () == self::MSSQL) {
				$sql .= "	ORDER BY [" . $this->getSortField () . "] " . $this->getOrder () . " ";
			} else if ($this->getVendor () == self::ORACLE) {
				$sql .= "	ORDER BY " . strtoupper ( $this->getSortField () ) . "  " . strtoupper ( $this->getOrder () ) . " ";
			}
		}
		$_SESSION ['sql'] = $sql; // push to session so can make report via excel and pdf
		$_SESSION ['start'] = $this->getStart ();
		$_SESSION ['limit'] = $this->getLimit ();
		if (! ($this->getGridQuery ())) {
			if ($this->getLimit ()) {
				// only mysql have limit
				if ($this->getVendor () == self::MYSQL) {
					$sql .= " LIMIT  " . $this->getStart () . "," . $this->getLimit () . " ";
				} else if ($this->getVendor () == self::MSSQL) {
					/**
					 * Sql Server and Oracle used row_number
					 * Parameterize Query We don't support
					 */
					$sql = "
							WITH [documentDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [documentId]) AS 'RowNumber'
								FROM [document]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[document].[documentId],
											[document].[documentTitle],
											[document].[documentDesc],	
											[document].[documentSequence],
											[document].[documentCode],
											[document].[documentNote],
											[document].[isDefault],
											[document].[isNew],
											[document].[isDraft],
											[document].[isUpdate],
											[document].[isDelete],
											[document].[isApproved],
											[document].[isReview],
											[document].[isPost],
											[document].[executeBy],
											[document].[executeTime],
											[staff].[staffName]
							FROM 		[documentDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $this->getStart () . "
							AND 			" . ($this->getStart () + $this->getLimit () - 1) . ";";
				} else if ($this->getVendor () == self::ORACLE) {
					/**
					 * Oracle using derived table also
					 */
					$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT	DOCUMENT.DOCUMENTID 				AS 	\"DOCUMENTID\",
												DOCUMENT.DOCUMENTTITLE			AS	\"documentTitle\",
												DOCUMENT.DOCUMENTDESC   		AS  	\"documentDesc\",
												DOCUMENT.DOCUMENTCODE   		AS  	\"documentCode\",
												DOCUMENT.DOCUMENTSEQUENCE	AS  	\"documentSequence\",
												DOCUMENT.DOCUMENTNOTE 			AS 	\"documentNote\",
												DOCUMENT.ISDEFAULT	 				AS	\"isDefault\",
												DOCUMENT.ISNEW 						AS 	\"isNew\",
												DOCUMENT.ISDRAFT  					AS 	\"isDraft\",
												DOCUMENT.ISUPDATE 					AS 	\"isUpdate\",
												DOCUMENT.ISDELETE 					AS 	\"isDelete\",
												DOCUMENT.ISACTIVE 					AS 	\"isActive\",
												DOCUMENT.ISAPPROVED	 			AS	\"isApproved\",
												DOCUMENT.ISACTIVE 					AS 	\"isActive\",
												DOCUMENT.ISREVIEW	 				AS	\"isReview\",
												DOCUMENT.ISPOST 						AS 	\"isPost\",
												DOCUMENT.ISAPPROVED	 			AS	\"isApproved\",
												DOCUMENT.EXECUTEBY 				AS 	\"executeBy\",
												DOCUMENT.EXECUTETIME 				AS 	\"executeTime\",
												STAFF.STAFFNAME 						AS 	\"staffName\"
									FROM 	DOCUMENT
									JOIN		STAFF
									ON		DOCUMENT.EXECUTEBY = STAFF.STAFFID
									JOIN		DOCUMENTCATEGORY
									ON		DOCUMENTCATEGORY.DOCUMENTCATEGORYID = DOCUMENT.DOCUMENTCATEGORYID
									WHERE ISACTIVE=1  " . $tempSql . $tempSql2 . "
								 ) a
						WHERE rownum <= '" . ($this->getStart () + $this->getLimit () - 1) . "' )
						WHERE r >=  '" . $this->getStart () . "'";
				} else {
					echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
					exit ();
				}
			}
		}
		/*
		 *  Only Execute One Query
		 */
		if (! ($this->model->getDocumentId ( 0, 'single' ))) {
			$this->q->read ( $sql );
			if ($this->q->execute == 'fail') {
				echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
				exit ();
			}
		}
		$items = array ();
		while ( ($row = $this->q->fetchAssoc ()) == TRUE ) {
			$items [] = $row;
		}
		if ($this->model->getDocumentId ( 0, 'single' )) {
			$end = microtime(true);
			$time = $end - $start;
			$json_encode = json_encode (
			array (	'success' =>true,
						'total' => $total, 
						'message' => $this->systemString->getReadMessage(), 
						'data' => $items, 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getDocumentId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getDocumentId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value') ) );
			$json_encode = str_replace ( "[", "", $json_encode );
			$json_encode = str_replace ( "]", "", $json_encode );
			echo $json_encode;
		} else {
			$end = microtime(true);
			$time = $end - $start;
			if (count ( $items ) == 0) {
				$items = '';
			}
			echo json_encode (
			array (	'success' =>true,
						'total' => $total, 
						'message' => $this->systemString->getReadMessage(), 
						'data' => $items, 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getDocumentId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getDocumentId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value') ) );
			exit ();
		}
	}
	/* (non-PHPdoc)
	 * @see config::update()
	 */
	function update() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->start();

		$isFile = is_uploaded_file ( $_FILES ['documentFilename'] ['tmp_name'] );
		if ($isFile) {
			$safeFilename = preg_replace ( array ("/\\s+/", "/[^-\\.\\w]+/" ), array ("_", "" ), trim ( $_FILES ['documentFilename'] ['name'] ) );
			$fileSize = $_FILES ['documentFilename'] ['size'];
			$maxSize = $this->maximumFileSize;
			if ($_FILES ['documentFilename'] ['size'] >= $this->maximumFileSize) {
				echo json_encode ( array ("success" => false, "message" => " File To Big .File Size : " . $fileSize . " Maximum File Size " . $maxSize ) );
				exit ();
			}
			if (! (preg_match ( $this->validFileType, strrchr ( $safeFilename, '.' ) ))) {
				echo json_encode ( array ("success" => false, "message" => "not valid type" ) );
				exit ();
			}
			if (! is_dir ( $this->path )) {
				echo json_encode ( array ("success" => false, "message" => "Path no correct.Please change the path.Current Wrong Path : " . $this->path ) );
				exit ();
			} else {
				$this->model->setDocumentPath ( $this->path );
			}
			$originalFilename = $_FILES ['documentFilename'] ['name'];
			$findExtensionArray = explode ( ".", $originalFilename );
			$filenameWithoutExtension = $findExtensionArray [0];
			$filenameExtension = $findExtensionArray [1];
			$downloadFilename = $filenameWithoutExtension . "-" . rand ( 0, 32768 ) . "'" . $filenameExtension;
			$this->model->setDocumentOriginalFilename ( $originalFilename );
			$this->model->setDocumentDownloadFilename ( $downloadFilename );
			$this->model->setDocumentExtension ( $filenameExtension );
			$isMove = move_uploaded_file ( $_FILES ['documentFilename'] ['tmp_name'], $this->path . $downloadFilename );
			if (! $isMove) {
				echo json_encode ( array ("success" => false, "message" => "Error Moving file" ) );
				exit ();
			} else {
			}
		} else {
			echo json_encode ( array ("success" => false, "message" => "File Is not uploaded" ) );
			exit ();
		}
		// create versioning
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT 	count(*) 
			FROM 	`document` 
			WHERE 	`documentOriginalFilename`	=	'" . $this->model->getDocumentOriginalFilename () . "'
			AND		`executeBy`					=   '" . $this->model->getExecuteBy () . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT 	count(*) 
			FROM 	[document] 
			WHERE 	[documentOriginalFilename]	=	'" . $this->model->getDocumentOriginalFilename () . "'
			AND		[executeBy]					=   '" . $this->model->getExecuteBy () . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT 	COUNT(*) 
			FROM 	DOCUMENT 
			WHERE 	DOCUMENTORIGINALFILENAME	=	'" . $this->model->getDocumentOriginalFilename () . "'
			AND		EXECUTEBY					=   '" . $this->model->getExecuteBy () . "'";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
			SELECT 	COUNT(*) 
			FROM 	DOCUMENT 
			WHERE 	DOCUMENTORIGINALFILENAME	=	'" . $this->model->getDocumentOriginalFilename () . "'
			AND		EXECUTEBY					=   '" . $this->model->getExecuteBy () . "'";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT 	COUNT(*) 
			FROM 	DOCUMENT 
			WHERE 	DOCUMENTORIGINALFILENAME	=	'" . $this->model->getDocumentOriginalFilename () . "'
			AND		EXECUTEBY					=   '" . $this->model->getExecuteBy () . "'";
		}
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$total = $this->q->numberRows ();
		$this->model->setDocumentVersion ( $total );
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
		UPDATE 	`document`
		SET 	`documentCategoryId` 		=	'" . $this->model->getDocumentCategoryId () . "',
				`leafId`	        				=	'" . $this->model->getLeafId () . "',
				`documentCode`				=	'" . $this->model->getDocumentCode () . "',
				`documentSequence`		=	'" . $this->model->getDocumentSequence () . "',
				`documentNote`				=	'" . $this->model->getDocumentNote () . "',
				`documentTitle`	        	=	'" . $this->model->getDocumentTitle () . "',
				`documentDesc`	        	=	'" . $this->model->getDocumentDesc () . "',
				`documentPath`	        	=	'" . $this->model->getDocumentPath () . "',
				`documentFilename`	    	=	'" . $this->model->getDocumentFilename () . "',
				`documentExtension`	    	=	'" . $this->model->getDocumentExtension () . "',
				`documentVersion`	    	=	'" . $this->model->getDocumentVersion () . "',				
				`isDefault`						=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
				`isActive`							=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
				`isNew`							=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
				`isDraft`							=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
				`isUpdate`						=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
				`isDelete`							=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
				`isApproved`					=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
				`isReview`						=  '" . $this->model->getIsReview ( 0, 'single' ) . "',
				`isPost`							=  '" . $this->model->getIsPost( 0, 'single' ) . "',
				`executeBy`						=	'" . $this->model->getExecuteBy () . "',
				`executeTime`					=	" . $this->model->getExecuteTime () . "
		WHERE 	`documentId`				=	'" . $this->model->getDocumentId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
		UPDATE 	[document]
		SET 	[documentCategoryId] 		=	'" . $this->model->getDocumentCategoryId () . "',
				[leafId]	        					=	'" . $this->model->getLeafId () . "',
				[documentCode]	        	=	'" . $this->model->getDocumentCode () . "',
				[documentSequence]	        =	'" . $this->model->getDocumentSequence () . "',
				[documentNote]	        		=	'" . $this->model->getDocumentNote () . "',
				[documentTitle]	        		=	'" . $this->model->getDocumentTitle () . "',
				[documentDesc]	        	=	'" . $this->model->getDocumentDesc () . "',
				[documentPath]	        		=	'" . $this->model->getDocumentPath () . "',
				[documentFilename]	    	=	'" . $this->model->getDocumentFilename () . "',
				[documentExtension]	    	=	'" . $this->model->getDocumentExtension () . "',
				[isDefault]							=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
				[isActive]							=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
				[isNew]								=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
				[isDraft]							=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
				[isUpdate]							=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
				[isDelete]							=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
				[isApproved]						=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
				[isReview]							=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
				[isPost]								=	'" . $this->model->getIsPost( 0, 'single' ) . "',
				[executeBy]						=	'" . $this->model->getExecuteBy () . "',
				[executeTime]					=	" . $this->model->getExecuteTime () . "
		WHERE 	[documentId]				=	'" . $this->model->getDocumentId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
		UPDATE 	DOCUMENT
		SET 	DOCUMENTCATEGORYID 	=	'" . $this->model->getDocumentCategoryId () . "',
				LEAFID	        					=	'" . $this->model->getLeafId () . "',
				DOCUMENTCODE	        	=	'" . $this->model->getDocumentCode () . "',
				DOCUMENTSEQUENCE	    =	'" . $this->model->getDocumentSequence () . "',
				DOCUMENTNOTE	        	=	'" . $this->model->getDocumentNote () . "',
				DOCUMENTTITLE	        	=	'" . $this->model->getDocumentTitle () . "',
				DOCUMENTDESC	        	=	'" . $this->model->getDocumentDesc () . "',
				DOCUMENTPATH	        	=	'" . $this->model->getDocumentPath () . "',
				DOCUMENTFILENAME			=	'" . $this->model->getDocumentFilename () . "',
				DOCUMENTEXTENSION		=	'" . $this->model->getDocumentExtension () . "',
				ISDEFAULT						=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
				ISACTIVE							=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
				ISNEW								=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
				ISDRAFT							=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
				ISUPDATE							=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
				ISDELETE							=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
				ISAPPROVED						=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
				ISREVIEW							=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
				ISPOST								=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
				EXECUTEBY						=	'" . $this->model->getExecuteBy () . "',
				EXECUTETIME					=	" . $this->model->getExecuteTime () . "
		WHERE 	DOCUMENTID				=	'" . $this->model->getDocumentId ( 0, 'single' ) . "'";
		}
		$this->q->create ( $sql );
		$source = $this->path . $this->model->getDocumentExtension ();
		chmod ( $source, 0777 );
		$this->convert ( $source );
		$end = microtime(true);
		$time = $end - $start;
	}
	function delete() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		$this->q->start();

		$this->model->delete ();
		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			UPDATE	`document`
			SET 			`isDefault`			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							`isActive`				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							`isNew`				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							`isDraft`				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							`isUpdate`			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							`isDelete`				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							`isApproved`		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							`isReview`			=  '" . $this->model->getIsReview ( 0, 'single' ) . "',
							`isPost`				=  '" . $this->model->getIsPost( 0, 'single' ) . "',
							`executeBy`			=	'" . $this->model->getBy ( 0, 'single' ) . "',
							`Time					=	" . $this->model->getExecuteTime () . "
				WHERE 	`documentId`		=	'" . $this->model->getDepartrmentId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
				UPDATE 	[document]
				SET 			[isDefault]			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
								[isActive]			=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
								[isNew]				=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
								[isDraft]			=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
								[isUpdate]			=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
								[isDelete]			=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
								[isApproved]		=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
								[isReview]			=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
								[isPost]				=	'" . $this->model->getIsPost( 0, 'single' ) . "',
								[executeBy]		=	'" . $this->model->getExecuteBy () . "',
								[executeTime]	=	" . $this->model->getExecuteTime () . "
				WHERE 		[documentId]	=	'" . $this->model->getDocumentId ( 0, 'single' ) . "'";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			UPDATE	DOCUMENT
			SET 			ISDEFAULT			=	'" . $this->model->getIsDefault ( 0, 'single' ) . "',
							ISACTIVE				=	'" . $this->model->getIsActive ( 0, 'single' ) . "',
							ISNEW					=	'" . $this->model->getIsNew ( 0, 'single' ) . "',
							ISDRAFT				=	'" . $this->model->getIsDraft ( 0, 'single' ) . "',
							ISUPDATE				=	'" . $this->model->getIsUpdate ( 0, 'single' ) . "',
							ISDELETE				=	'" . $this->model->getIsDelete ( 0, 'single' ) . "',
							ISAPPROVED			=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							ISREVIEW				=	'" . $this->model->getIsReview ( 0, 'single' ) . "',
							ISPOST					=	'" . $this->model->getIsApproved ( 0, 'single' ) . "',
							EXECUTEBY			=	'" . $this->model->getExecuteBy () . "',
							EXECUTETIME		=	" . $this->model->getExecuteTime () . "
			WHERE 		DOCUMENTID		=	'" . $this->model->getDocumentId ( 0, 'single' ) . "'";
		}
		$this->q->update ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$this->q->commit ();
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode (
		array ("success" => true,
					"message" => $this->systemString->getDeleteMessage(),
					"time"=>$time ) );
		exit ();
	}
	/**
	 * To Update flag Status
	 */
	function updateStatus() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor() == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast($sql);
		}
		$this->q->start();
		$loop = $this->model->getTotal();
		if ($this->getVendor() == self::MYSQL) {
			$sql = "
			UPDATE `" . $this->model->getTableName() . "`
			SET";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql = "
			UPDATE 	[" . $this->model->getTableName() . "]
			SET 	";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else if ($this->getVendor() == self::DB2) {
			$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql = "
			UPDATE " . strtoupper($this->model->getTableName()) . "
			SET    ";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		/**
		 * System Validation Checking
		 * @var $access
		 */
		$access = array("isDefault", "isNew", "isDraft", "isUpdate", "isDelete", "isActive", "isApproved", "isReview", "isPost");
				$accessClear = array("isDefault", "isNew", "isDraft", "isUpdate",  "isActive", "isApproved", "isReview", "isPost");
		
		foreach ($access as $systemCheck) {

			switch ($systemCheck) {
				case 'isDefault' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDefault($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentId($i, 'array') . "'
							THEN '" . $this->model->getIsDefault($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isNew' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsNew($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentId($i, 'array') . "'
							THEN '" . $this->model->getIsNew($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isDraft' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDraft($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentId($i, 'array') . "'
							THEN '" . $this->model->getIsDraft($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isUpdate' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsUpdate($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentId($i, 'array') . "'
							THEN '" . $this->model->getIsUpdate($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isDelete' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsDelete($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentId($i, 'array') . "'
							THEN '" . $this->model->getIsDelete($i, 'array') . "'";
							$sqlLooping .= " END,";
							if(!$this->getIsAdmin()){
								foreach ($accessClear as $clear){
									// update delete status = 1
									if ($this->getVendor() == self::MYSQL) {
										$sqlLooping .= " `" . $clear . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
									} else if ($this->getVendor() == self::MSSQL) {
										$sqlLooping .= "  [" . $clear. "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
									} else if ($this->getVendor() == self::ORACLE) {
										$sqlLooping .= "	" . $clear . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
									} else if ($this->getVendor() == self::DB2) {
										$sqlLooping .= "	" . $clear . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
									} else if ($this->getVendor() == self::POSTGRESS) {
										$sqlLooping .= "	" .$clear . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
									} else {
										echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
										exit();
									}
									$sqlLooping .= "
							WHEN '" . $this->model->getDocumentId($i, 'array') . "'
							THEN '0'";
									$sqlLooping .= " END,";
								}
									
							}
						}
					}
					break;
				case 'isActive' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsActive($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentId($i, 'array') . "'
							THEN '" . $this->model->getIsActive($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isApproved' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsApproved($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
							WHEN '" . $this->model->getDocumentId($i, 'array') . "'
							THEN '" . $this->model->getIsApproved($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isReview' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsReview($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
                            WHEN '" . $this->model->getDocumentId($i, 'array') . "'
                            THEN '" . $this->model->getIsReview($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
				case 'isPost' :
					for ($i = 0; $i < $loop; $i++) {
						if (strlen($this->model->getIsPost($i, 'array')) > 0) {
							if ($this->getVendor() == self::MYSQL) {
								$sqlLooping .= " `" . $systemCheck . "` = CASE `iCore`.`".$this->model->getTableName()."`.`" . $this->model->getPrimaryKeyName() . "`";
							} else if ($this->getVendor() == self::MSSQL) {
								$sqlLooping .= "  [" . $systemCheck . "] = CASE [iCore].[".$this->model->getTableName()."].[" . $this->model->getPrimaryKeyName() . "]";
							} else if ($this->getVendor() == self::ORACLE) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::DB2) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else if ($this->getVendor() == self::POSTGRESS) {
								$sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE ICORE." . strtoupper($this->model->getTableName()).strtoupper($this->model->getPrimaryKeyName()) . " ";
							} else {
								echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
								exit();
							}
							$sqlLooping .= "
                                WHEN '" . $this->model->getDocumentId($i, 'array') . "'
                                THEN '" . $this->model->getIsPost($i, 'array') . "'";
							$sqlLooping .= " END,";
						}
					}
					break;
			}
		}
		$sql .= substr($sqlLooping, 0, - 1);
		if ($this->getVendor() == self::MYSQL) {
			$sql .= "
			WHERE `" . $this->model->getPrimaryKeyName() . "` IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::MSSQL) {
			$sql .= "
			WHERE [" . $this->model->getPrimaryKeyName() . "] IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::ORACLE) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "  IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::DB2) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "  IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else if ($this->getVendor() == self::POSTGRESS) {
			$sql .= "
			WHERE " . strtoupper($this->model->getPrimaryKeyName()) . "  IN (" . $this->model->getPrimaryKeyAll() . ")";
		} else {
			echo json_encode(array("success" => false, "message" => $this->systemString->getNonSupportedDatabase()));
			exit();
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array("success" => false, "message" => $this->q->responce));
			exit();
		}
		$this->q->commit();
		if ($this->getIsAdmin()) {
			$message = $this->systemString->getUpdateMessage();
		} else {
			$message = $this->systemString->getDeleteMessage();
		}
		$end = microtime(true);
		$time = $end - $start;
		echo json_encode(
		array(	"success" => true,
					"message" => $message,
					"time"=>$time)
		);
		exit();
	}
	function firstRecord($value) {
		$this->recordSet->firstRecord ( $value );
	}
	function nextRecord($value, $primaryKeyValue) {
		$this->recordSet->nextRecord ( $value, $primaryKeyValue );
	}
	function previousRecord($value, $primaryKeyValue) {
		$this->recordSet->previousRecord ( $value, $primaryKeyValue );
	}
	function lastRecord($value) {
		$this->recordSet->lastRecord ( $value );
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {
		header('Content-Type:application/json; charset=utf-8');
		$start = microtime(true);
		if ($this->getVendor () == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}
		if ($_SESSION ['start'] == 0) {
			$sql = str_replace ( "LIMIT", "", $_SESSION ['sql'] );
			$sql = str_replace ( $_SESSION ['start'] . "," . $_SESSION ['limit'], "", $sql );
		} else {
			$sql = $_SESSION ['sql'];
		}
		$this->q->read ( $sql );
		$this->excel->setActiveSheetIndex ( 0 );
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array ('borders' => array ('inside' => array ('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array ('argb' => '000000' ) ), 'outline' => array ('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array ('argb' => '000000' ) ) ) );
		// header all using  3 line  starting b
		$this->excel->getActiveSheet ()->getColumnDimension ( 'B' )->setAutoSize ( TRUE );
		$this->excel->getActiveSheet ()->getColumnDimension ( 'C' )->setAutoSize ( TRUE );
		$this->excel->getActiveSheet ()->getColumnDimension ( 'D' )->setAutoSize ( TRUE );
		$this->excel->getActiveSheet ()->getColumnDimension ( 'E' )->setAutoSize ( TRUE );
		$this->excel->getActiveSheet ()->setCellValue ( 'B2', $this->title );
		$this->excel->getActiveSheet ()->setCellValue ( 'E2', '' );
		$this->excel->getActiveSheet ()->mergeCells ( 'B2:E2' );
		$this->excel->getActiveSheet ()->setCellValue ( 'B3', 'No' );
		$this->excel->getActiveSheet ()->setCellValue ( 'C3', 'Dokumen' );
		$this->excel->getActiveSheet ()->setCellValue ( 'D3', 'Nama' );
		$this->excel->getActiveSheet ()->setCellValue ( 'E3', 'Penerangan' );
		$this->excel->getActiveSheet ()->getStyle ( 'B2:E2' )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$this->excel->getActiveSheet ()->getStyle ( 'B2:E2' )->getFill ()->getStartColor ()->setARGB ( '66BBFF' );
		$this->excel->getActiveSheet ()->getStyle ( 'B3:E3' )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
		$this->excel->getActiveSheet ()->getStyle ( 'B3:E3' )->getFill ()->getStartColor ()->setARGB ( '66BBFF' );
		//
		$loopRow = 4;
		$i = 0;
		while ( ($row = $this->q->fetchAssoc ()) == TRUE ) {
			//	echo print_r($row);
			$this->excel->getActiveSheet ()->setCellValue ( 'B' . $loopRow, ++ $i );
			$this->excel->getActiveSheet ()->setCellValue ( 'C' . $loopRow, $row ['doc_uniqueId'] );
			$this->excel->getActiveSheet ()->setCellValue ( 'D' . $loopRow, $row ['doc_nme'] );
			$this->excel->getActiveSheet ()->setCellValue ( 'E' . $loopRow, $row ['NoDoc'] );
			$loopRow ++;
			$lastRow = 'E' . $loopRow;
		}
		$from = 'B2';
		$to = $lastRow;
		$formula = $from . ":" . $to;
		$this->excel->getActiveSheet ()->getStyle ( $formula )->applyFromArray ( $styleThinBlackBorderOutline );
		$objWriter = PHPExcel_IOFactory::createWriter ( $this->excel, 'Excel2007' );
		$filename = "doc.xlsx";
		$objWriter->save ( "/kospek/document/document/excel/" . $filename );
		$file = fopen ( "/kospek/document/document/excel/" . $filename, 'r' );
		if ($file) {
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode (
			array ("success" => true,
						"message" => $this->systemString->getFileGenerateMessage(),
						"time"=>$time ) );
			exit ();
		} else {
			echo json_encode ( array ("success" => false, "message" => $this->systemString->getFileNotGenerateMessage() ) );
			exit ();
		}
	}
	function documentCategoryId() {
		header('Content-Type:application/json; charset=utf-8');
		if ($this->getVendor () == self::MYSQL) {

			$sql = "SET NAMES \"utf8\"";
			$this->q->fast ( $sql );
		}

		if ($this->getVendor () == self::MYSQL) {
			$sql = "
			SELECT	*
			FROM   `documentCategory`
			WHERE  `isActive`	=1 ";
		} else if ($this->getVendor () == self::MSSQL) {
			$sql = "
			SELECT	*
			FROM   [documentCategory]
			WHERE  [isActive]	=1 ";
		} else if ($this->getVendor () == self::ORACLE) {
			$sql = "
			SELECT	*
			FROM   	DOCUMENTCATEGORY
			WHERE 	ISACTIVE	=1 ";
		} else if ($this->getVendor () == self::DB2) {
			$sql = "
			SELECT	*
			FROM   	DOCUMENTCATEGORY
			WHERE 	ISACTIVE	=1 ";
		} else if ($this->getVendor () == self::POSTGRESS) {
			$sql = "
			SELECT	*
			FROM   	DOCUMENTCATEGORY
			WHERE 	ISACTIVE	=1 ";
		}
		$this->q->read ( $sql );
		if ($this->q->execute == 'fail') {
			echo json_encode ( array ("success" => false, "message" => $this->q->responce ) );
			exit ();
		}
		$total = $this->q->numberRows ();
		$items = array ();
		while ( ($row = $this->q->fetchAssoc ()) == TRUE ) {
			$items [] = $row;
		}
		if ($total == 1) {
			$end = microtime(true);
			$time = $end - $start;
			$json_encode = json_encode (
			array (	'success' => true,
						'total' => $total, 
						'documentCategory' => $items,
						'time'=>$time ) );
			$json_encode = str_replace ( "[", "", $json_encode );
			$json_encode = str_replace ( "]", "", $json_encode );
			echo json_encode;
		} else {
			$end = microtime(true);
			$time = $end - $start;
			echo json_encode (
			array ('success' =>true,
						'total' => $total, 
						'documentCategory' => $items,
						'time'=>$time ) );
		}
	}
}

$documentObject = new DocumentClass ();
//$documentObject->execute();
//$documentObject->create();
/**
 * crud -create,read,update,delete
 **/
if (isset ( $_POST ['method'] )) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset ( $_POST ['leafId'] )) {
		$documentObject->setLeafId ( $_POST ['leafId'] );
	}
	if (isset ( $_POST ['isAdmin'] )) {
		$documentObject->setIsAdmin ( $_POST ['isAdmin'] );
	}
	/**
	 * Database Request
	 */
	if (isset($_POST ['databaseRequest'])) {
		$documentObject->setDatabaseRequest($_POST ['databaseRequest']);
	}
	/*
	 *  Paging
	 */
	if (isset($_POST ['start'])) {
		$documentObject->setStart($_POST ['start']);
	}
	if (isset($_POST ['perPage'])) {
		$documentObject->setLimit($_POST ['perPage']);
	}
	/*
	 *  Filtering
	 */
	if (isset ( $_POST ['query'] )) {
		$documentObject->setFieldQuery ( $_POST ['query'] );
	}
	if (isset ( $_POST ['filter'] )) {
		$documentObject->setGridQuery ( $_POST ['filter'] );
	}
	if (isset($_POST ['character'])) {
		$documentObject->setCharacterQuery($_POST['character']);
	}
	if (isset($_POST ['dateRangeStart'])) {
		$documentObject->setDateRangeStartQuery($_POST['dateRangeStart']);
	}
	if (isset($_POST ['dateRangeEnd'])) {
		$documentObject->setDateRangeEndQuery($_POST['dateRangeEnd']);
	}
	if (isset($_POST ['dateRangeType'])) {
		$documentObject->setDateRangeTypeQuery($_POST['dateRangeType']);
	}
	/*
	 *  Ordering
	 */
	if (isset ( $_POST ['order'] )) {
		$documentObject->setOrder ( $_POST ['order'] );
	}
	if (isset ( $_POST ['sortField'] )) {
		$documentObject->setSortField ( $_POST ['sortField'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$documentObject->execute ();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST ['method'] == 'create') {
		$documentObject->create ();
	}
	if ($_POST ['method'] == 'read') {
		$documentObject->read ();
	}
	if ($_POST ['method'] == 'save') {
		$documentObject->update ();
	}
	if ($_POST ['method'] == 'delete') {
		$documentObject->delete ();
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
		$documentObject->setLeafId ( $_GET ['leafId'] );
	}
	/*
	 *  Load the dynamic value
	 */
	$documentObject->execute ();
	if (isset ( $_GET ['field'] )) {
		if ($_GET ['field'] == 'staffId') {
			$documentObject->staff ();
		}
		if ($_GET ['field'] == 'documentCategoryId') {
			$documentObject->documentCategoryId ();
		}
	}
	/*
	 * Button Navigation
	 */
	if ($_GET ['method'] == 'dataNavigationRequest') {
		if ($_GET ['dataNavigation'] == 'firstRecord') {
			$documentObject->firstRecord('json');
		}
		if ($_GET ['dataNavigation'] == 'previousRecord') {
			$documentObject->previousRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'nextRecord') {
			$documentObject->nextRecord('json', 0);
		}
		if ($_GET ['dataNavigation'] == 'lastRecord') {
			$documentObject->lastRecord('json');
		}
	}
	/*
	 *  Excel Reporting
	 */
	if (isset ( $_GET ['mode'] )) {
		if ($_GET ['mode'] == 'excel') {
			$documentObject->excel ();
		}
	}
}
?>
