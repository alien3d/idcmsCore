<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../model/documentModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package doc
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class documentClass extends  configClass {
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
	 *	 Database Selected
	 *   string $database;
	 */
	public $database;
	/**
	 * Database Vendor
	 * @var string $vendor
	 */

	public $vendor;
	/**
	 * Extjs Field Query UX
	 * @var string $fieldQuery
	 */
	public $fieldQuery;
	/**
	 * Extjs Grid  Filter Plugin
	 * @var string $gridQuery
	 */
	public $gridQuery;
	/**
	 * Fast Search Variable
	 * @var string $quickFilter
	 */
	public $quickFilter;

	/**
	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx
	 * @var string $excel
	 */
	private  $excel;


	/**
	 * Document Trail Audit.
	 * @var string $documentTrail;
	 */
	private  $documentTrail;

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
	 * Current Table Document  Identification Value
	 * @var numeric $docId
	 */
	public $documentId;
	public $model;
	function execute() {
		parent::__construct();

		$this->q              	= new vendor();
		$this->q->vendor      	= $this->getVendor();
		$this->q->leafId      	= $this->getLeafId();
		$this->q->staffId     	= $this->getStaffId();
		$this->q->fieldQuery	= $this->getFieldQuery();
		$this->q->gridQuery   = $this->getGridQuery();

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());
		$this->excel         = new PHPExcel();
		$this->audit         = 0;
		$this->log           = 1;
		$this->q->log        = $this->log;

		$this->model         = new documentModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

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
	function create(){

		move_uploaded_file ($_FILES['docname']['tmp_name'],$this->path.$doc_ext);
		if($this->getVendor()==self::mysql){
			$sql = "
		INSERT INTO `document` 
				(
				  	`documentCategoryId`,	`leafId`,
				  	`documentSequence`,		`documentCode`,
				  	`documentNote`			`documentTitle`,		
				  	`documentDesc`,			`documentPath`,			
				  	`documentFilename`,		`documentExtension`,	
				  	`isDefault`,			`isNew`,							
				  	`isDraft`,				`isUpdate`,							
				  	`isDelete`,				`isActive`,							
				  	`isApproved`,			`By`,								
				  	`Time`
				)
			VALUES
				(
						\"". $this->model->getDocumentCategoryId() . "\",				\"". $this->model->getLeafId() . "\",
						\"". $this->model->getDocumentSequence() . "\",					\"". $this->model->getDocumentCode() . "\",	
						\"". $this->model->getDocumentCategoryNote() . "\",				\"". $this->model->getDocumentTitle() . "\",
						\"". $this->model->getDocumentDesc() . "\",						\"". $this->model->getDocumentPath() . "\",
						\"". $this->model->getDocumentFilename() . "\",					\"". $this->model->getDocumentExtension() . "\",
						\"". $this->model->getIsDefault(0,'string') . "\"				,\"". $this->model->getIsNew(0,'string') . "\",				
						\"". $this->model->getIsDraft(0,'string') . "\",				\"". $this->model->getIsUpdate(0,'string') . "\",				
						\"". $this->model->getIsDelete(0,'string') . "\",				\"". $this->model->getIsActive(0,'string') . "\",				
						\"". $this->model->getIsApproved(0,'string') . "\",			\"". $this->model->getBy() . "\",						
						" . $this->model->getTime() . "
				);";

		} else if ($this->getVendor()==self::mssql){
			$sql = "
		INSERT INTO `document` 
				(
				  	[documentCategoryId],	[leafId,
				  	[documentSequence],		[documentCode],
				  	[documentCode],			[documentTitle],		
				  	[documentDesc],			[documentPath],			
				  	[documentFilename],		[documentExtension],	
				  	[isDefault],			[isNew],							
				  	[isDraft],				[isUpdate],							
				  	[isDelete],				[isActive],							
				  	[isApproved],			[By],								
				  	[Time]
				)
			VALUES
				(
					\"". $this->model->getDocumentCategoryId() . "\",				\"". $this->model->getLeafId() . "\",
						\"". $this->model->getDocumentSequence() . "\",					\"". $this->model->getDocumentCode() . "\",	
						\"". $this->model->getDocumentCategoryNote() . "\",				\"". $this->model->getDocumentTitle() . "\",
						\"". $this->model->getDocumentDesc() . "\",						\"". $this->model->getDocumentPath() . "\",
						\"". $this->model->getDocumentFilename() . "\",					\"". $this->model->getDocumentExtension() . "\",
						\"". $this->model->getIsDefault(0,'string') . "\"				,\"". $this->model->getIsNew(0,'string') . "\",				
						\"". $this->model->getIsDraft(0,'string') . "\",				\"". $this->model->getIsUpdate(0,'string') . "\",				
						\"". $this->model->getIsDelete(0,'string') . "\",				\"". $this->model->getIsActive(0,'string') . "\",				
						\"". $this->model->getIsApproved(0,'string') . "\",			\"". $this->model->getBy() . "\",						
						" . $this->model->getTime() . "	
				);";	
		} else if ($this->getVendor()==self::oracle){
			$sql = "
		INSERT INTO `document` 
				(
				  	\"documentCategoryId\",	\"leafId\",
				  	\"documentSequence\",	\"documentCode\",
				  	\"documentNote\",		\"documentTitle\",		
				  	\"documentDesc\",		\"documentPath\",			
				  	\"documentFilename\",	\"documentExtension\",	
				  	\"isDefault\",			\"isNew\",							
				  	\"isDraft\",			\"isUpdate\",							
				  	\"isDelete\",			\"isActive\",						
				  	\"isApproved\",			\"By\",								
				  	\"Time\"
				)
			VALUES
				(
					\"". $this->model->getDocumentCategoryId() . "\",				\"". $this->model->getLeafId() . "\",
						\"". $this->model->getDocumentSequence() . "\",					\"". $this->model->getDocumentCode() . "\",	
						\"". $this->model->getDocumentCategoryNote() . "\",				\"". $this->model->getDocumentTitle() . "\",
						\"". $this->model->getDocumentDesc() . "\",						\"". $this->model->getDocumentPath() . "\",
						\"". $this->model->getDocumentFilename() . "\",					\"". $this->model->getDocumentExtension() . "\",
						\"". $this->model->getIsDefault(0,'string') . "\"				,\"". $this->model->getIsNew(0,'string') . "\",				
						\"". $this->model->getIsDraft(0,'string') . "\",				\"". $this->model->getIsUpdate(0,'string') . "\",				
						\"". $this->model->getIsDelete(0,'string') . "\",				\"". $this->model->getIsActive(0,'string') . "\",				
						\"". $this->model->getIsApproved(0,'string') . "\",			\"". $this->model->getBy() . "\",						
						" . $this->model->getTime() . "		
				);";
		}
		$this->q->create($sql);
		$source = $this->path.$doc_ext;
		chmod($source, 0777);
		//$this->convert($source);
		$this->convert($source);
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read() 				{

		header('Content-Type', 'application/json; charset=utf-8');
		if($this->isAdmin == 0) {
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	`document`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[document].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"document\".\"isActive\"	=	1	";
			}
		} else if($this->isAdmin ==1) {
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	1= 1 ";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	1= 1 ";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = " 1=  1 ";
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
							`document`.`By`,
							`document`.`Time`,
							`staff`.`staffName`
 					FROM 	`document`
					JOIN	`staff`
					ON		`document`.`By` = `staff`.`staffId`
					JOIN	`documentCategory`
					USING	(`documentCategoryId`)
					WHERE 	".$this->auditFilter;
			if ($this->model->getDocumentId(0,'single')) {
				$sql .= " AND `".$this->model->getTableName()."`.`".$this->model->getPrimaryKeyName()."`=\"". $this->model->getDocumentId(0,'single') . "\"";

			}

		} else if ($this->getVendor() ==  self::mssql) {
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
							[document].[By],
							[document].[Time],
							[staff].[staffName]
					FROM 	[document]
					JOIN	[staff]
					ON		[document].[By] = [staff].[staffId]
					JOIN	`documentCategory`
					ON		[document].[documentCategoryId]=[documentCategory].[documentCategoryId]
					WHERE 	[document].[isActive] ='1'	";
			if ($this->model->getDocumentId(0,'single')) {
				$sql .= " AND [".$this->model->getTableName()."].[".$this->model->getPrimaryKeyName()."]=\"". $this->model->getDocumentId(0,'single') . "\"";
			}
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
					SELECT	\"document\".\"documentId\",
							\"document\".\"documentTitle\",
							\"document\".\"documentDesc\",
							\"document\".\"documentCode\",
							\"document\".\"documentSequence\",
							\"document\".\"documentNote\",
							\"document\".\"isDefault\",
							\"document\".\"isNew\",
							\"document\".\"isDraft\",
							\"document\".\"isUpdate\",
							\"document\".\"isDelete\",
							\"document\".\"isActive\",
							\"document\".\"isApproved\",
							\"document\".\"By\",
							\"document\".\"Time\",
							\"staff\".\"staffName\"
					FROM 	\"document\"
					JOIN	\"staff\"
					ON		\"document\".\"By\" = \"staff\".\"staffId\"
					JOIN	`documentCategory`
					USING	(`documentCategoryId`)
					WHERE 		";
			if ($this->model->getDocumentId(0,'single')) {
				$sql .= " AND \"".$this->model->getTableName()."\".\"".$this->model->getPrimaryKeyName()."\"=\"". $this->model->getDocumentId(0,'single') . "\"";
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
            'documentId'
            );
            /**
             *	filter table
             * @variables $tableArray
             */
            $tableArray  = null;
            $tableArray  = array(
            'document'
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
										[document].[By],
										[document].[Time],
										[staff].[staffName]
							FROM 		[documentDerived]
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
									SELECT  \"document\".\"documentId\",
											\"document\".\"documentTitle\",
											\"document\".\"documentDesc\",
											\"document\".\"documentSequence\",
											\"document\".\"documentCode\",
											\"document\".\"documentNote\",
											\"document\".\"isDefault\",
											\"document\".\"isNew\",
											\"document\".\"isDraft\",
											\"document\".\"isUpdate\",
											\"document\".\"isDelete\",
											\"document\".\"isApproved\",
											\"document\".\"By\",
											\"document\".\"Time\",
											\"staff\".\"staffName\"
									FROM 	\"document\"
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
            if (!($this->model->getDocumentId(0,'single'))) {
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
            if ($this->model->getDocumentId(0,'single')) {
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
	function update() 				{
		$filecontent  = $_FILES['docname']['name'];

		move_uploaded_file ($_FILES['docname']['tmp_name'],$this->path.$doc_ext);
		if($this->getVendor()==self::mysql){
			$sql = "
		UPDATE 	`document`
		SET 	`documentCategoryId` 		=	\"".$this->model->getDocumentCategoryId()."\",
				`leafId`	        		=	\"".$this->model->getLeafId()."\",
				`documentCode`				=	\"".$this->model->getDocumentCode()."\",
				`documentSequence`			=	\"".$this->model->getDocumentSequence()."\",
				`documentNote`				=	\"".$this->model->getDocumentNote()."\",
				`documentTitle`	        	=	\"".$this->model->getDocumentTitle()."\",
				`documentDesc`	        	=	\"".$this->model->getDocumentDesc()."\",
				`documentPath`	        	=	\"".$this->model->getDocumentPath()."\",
				`documentFilename`	    	=	\"".$this->model->getDocumentFilename()."\",
				`documentExtension`	    	=	\"".$this->model->getDocumentExtension()."\",
				`isDefault`					=	\"".$this->model->getIsDefault(0,'string')."\",
				`isActive`					=	\"".$this->model->getIsActive(0,'string')."\",
				`isNew`						=	\"".$this->model->getIsNew(0,'string')."\",
				`isDraft`					=	\"".$this->model->getIsDraft(0,'string')."\",
				`isUpdate`					=	\"".$this->model->getIsUpdate(0,'string')."\",
				`isDelete`					=	\"".$this->model->getIsDelete(0,'string')."\",
				`isApproved`				=	\"".$this->model->getIsApproved(0,'string')."\",
				`By`						=	\"".$this->model->getBy()."\",
				`Time`						=	".$this->model->getTime()."
		WHERE 	`documentId`				=	\"".$this->model->getDocumentId(0,'single')."\"";

		} else if ($this->getVendor()==self::mssql){
			$sql = "
		UPDATE 	[document]
		SET 	[documentCategoryId] 		=	\"".$this->model->getDocumentCategoryId()."\",
				[leafId]	        		=	\"".$this->model->getLeafId()."\",
				[documentCode]	        	=	\"".$this->model->getDocumentCode()."\",
				[documentSequence]	        =	\"".$this->model->getDocumentSequence()."\",
				[documentNote]	        	=	\"".$this->model->getDocumentNote()."\",
				[documentFilename]	    	=	\"".$this->model->getDocumentFilename()."\",
				[documentTitle]	        	=	\"".$this->model->getDocumentTitle()."\",
				[documentDesc]	        	=	\"".$this->model->getDocumentDesc()."\",
				[documentPath]	        	=	\"".$this->model->getDocumentPath()."\",
				[documentFilename]	    	=	\"".$this->model->getDocumentFilename()."\",
				[documentExtension]	    	=	\"".$this->model->getDocumentExtension()."\",
				[isDefault]					=	\"".$this->model->getIsDefault(0,'string')."\",
				[isActive]					=	\"".$this->model->getIsActive(0,'string')."\",
				[isNew]						=	\"".$this->model->getIsNew(0,'string')."\",
				[isDraft]					=	\"".$this->model->getIsDraft(0,'string')."\",
				[isUpdate]					=	\"".$this->model->getIsUpdate(0,'string')."\",
				[isDelete]					=	\"".$this->model->getIsDelete(0,'string')."\",
				[isApproved]				=	\"".$this->model->getIsApproved(0,'string')."\",
				[By]						=	\"".$this->model->getBy()."\",
				[Time]						=	".$this->model->getTime()."
		WHERE 	[documentId]				=	\"".$this->model->getDocumentId(0,'single')."\"";

		} else if ($this->getVendor()==self::oracle){
			$sql = "
		UPDATE 	\"document\"
		SET 	\"documentCategoryId\" 		=	\"".$this->model->getDocumentCategoryId()."\",
				\"leafId\"	        		=	\"".$this->model->getLeafId()."\",
				\"documentCode\"	        =	\"".$this->model->getDocumentCode()."\",
				\"documentSequence\"	    =	\"".$this->model->getDocumentSequence()."\",
				\"documentNote\"	        =	\"".$this->model->getDocumentNote()."\",
				\"documentFilename\"	    =	\"".$this->model->getDocumentFilename()."\",
				\"documentTitle\"	        =	\"".$this->model->getDocumentTitle()."\",
				\"documentDesc\"	        =	\"".$this->model->getDocumentDesc()."\",
				\"documentPath\"	        =	\"".$this->model->getDocumentPath()."\",
				\"documentFilename\"	    =	\"".$this->model->getDocumentFilename()."\",
				\"documentExtension\"	    =	\"".$this->model->getDocumentExtension()."\",
				\"isDefault\"				=	\"".$this->model->getIsDefault(0,'string')."\",
				\"isActive\"				=	\"".$this->model->getIsActive(0,'string')."\",
				\"isNew\"					=	\"".$this->model->getIsNew(0,'string')."\",
				\"isDraft\"					=	\"".$this->model->getIsDraft(0,'string')."\",
				\"isUpdate\"				=	\"".$this->model->getIsUpdate(0,'string')."\",
				\"isDelete\"				=	\"".$this->model->getIsDelete(0,'string')."\",
				\"isApproved\"				=	\"".$this->model->getIsApproved(0,'string')."\",
				\"By\"						=	\"".$this->model->getBy()."\",
				\"Time\"					=	".$this->model->getTime()."
		WHERE 	\"documentId\"				=	\"".$this->model->getDocumentId(0,'single')."\"";

		}
		$this->q->create($sql);
		$source = $this->path.$doc_ext;
		chmod($source, 0777);

		$this->convert($source);

	}
	function delete()				{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->commit();
		$this->model->delete();
		if($this->getVendor() == self::mysql) {
			$sql="
				UPDATE 	`document`
				SET 	`isDefault`		=	\"".$this->model->getIsDefault(0,'string')."\",
						`isActive`		=	\"".$this->model->getIsActive(0,'string')."\",
						`isNew`			=	\"".$this->model->getIsNew(0,'string')."\",
						`isDraft`		=	\"".$this->model->getIsDraft(0,'string')."\",
						`isUpdate`		=	\"".$this->model->getIsUpdate(0,'string')."\",
						`isDelete`		=	\"".$this->model->getIsDelete(0,'string')."\",
						`isApproved`	=	\"".$this->model->getIsApproved(0,'string')."\",
						`By`			=	\"".$this->model->getBy(0,'single')."\",
						`Time			=	".$this->model->getTime()."
				WHERE 	`documentId`	=	\"".$this->model->getDepartrmentId(0,'single')."\"";
		} else if ($this->getVendor()==self::mssql) {
			$sql="
				UPDATE 	[document]
				SET 	[isDefault]		=	\"".$this->model->getIsDefault(0,'string')."\",
						[isActive]		=	\"".$this->model->getIsActive(0,'string')."\",
						[isNew]			=	\"".$this->model->getIsNew(0,'string')."\",
						[isDraft]		=	\"".$this->model->getIsDraft(0,'string')."\",
						[isUpdate]		=	\"".$this->model->getIsUpdate(0,'string')."\",
						[isDelete]		=	\"".$this->model->getIsDelete(0,'string')."\",
						[isApproved]	=	\"".$this->model->getIsApproved(0,'string')."\",
						[By]			=	\"".$this->model->getBy()."\",
						[Time]			=	".$this->model->getTime()."
				WHERE 	[documentId]	=	\"".$this->model->getDocumentId(0,'single')."\"";

		} else if ($this->getVendor()==self::oracle) {
			$sql="
				UPDATE 	\"document\"
				SET 	\"isDefault\"		=	\"".$this->model->getIsDefault(0,'string')."\",
						\"isActive\"		=	\"".$this->model->getIsActive(0,'string')."\",
						\"isNew\"			=	\"".$this->model->getIsNew(0,'string')."\",
						\"isDraft\"			=	\"".$this->model->getIsDraft(0,'string')."\",
						\"isUpdate\"		=	\"".$this->model->getIsUpdate(0,'string')."\",
						\"isDelete\"		=	\"".$this->model->getIsDelete(0,'string')."\",
						\"isApproved\"		=	\"".$this->model->getIsApproved(0,'string')."\",
						\"By\"				=	\"".$this->model->getBy()."\",
						\"Time\"			=	".$this->model->getTime()."
				WHERE 	\"documentId\"	=	\"".$this->model->getDocumentId(0,'single')."\"";

		}
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		$this->q->commit();

		echo json_encode(array("success"=>true,"message"=>"Record Remove"));
		exit();

	}
	/**
	 *  To Update flag Status
	 */
	function updateStatus () {
		$this->model-> updateStatus();
		$loop  = $this->model->getTotal();

		if($this->isAdmin==0){

			$this->model->delete();
			if ($this->getVendor() == self::mysql) {
				$sql = "
				UPDATE 	`".$this->model->getTableName()."`
				SET 	";

				$sql.="	   `isDefault`			=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDocumentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDocumentId($i,'array')."\"
						THEN \"".$this->model->getIsDefault(0,'string')."\"";
					}
				}
				$sql.="	END, ";
				$sql.="	`isNew`	=	case `".$this->model->getPrimaryKeyName()."` ";

				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDocumentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDocumentId($i,'array')."\"
						THEN \"".$this->model->getIsNew(0,'string')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isDraft`	=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDocumentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDocumentId($i,'array')."\"
						THEN \"".$this->model->getIsDraft(0,'string')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isUpdate`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDocumentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDocumentId($i,'array')."\"
						THEN \"".$this->model->getIsUpdate(0,'string')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isDelete`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDocumentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDocumentId($i,'array')."\"
						THEN \"".$this->model->getIsDelete($i,'array')."\"";
					}
				}
				$sql.="	END,	";
				$sql.="	`isActive`	=		case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDocumentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDocumentId($i,'array')."\"
						THEN \"".$this->model->getIsActive(0,'string')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isApproved`			=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->getDocumentId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->getDocumentId($i,'array')."\"
						THEN \"".$this->model->getIsApproved(0,'string')."\"";

					}
				}
				$sql.="
				END,
				`By`				=	\"". $this->model->getBy() . "\",
				`Time`				=	" . $this->model->getTime() . " ";


				$this->model->setPrimaryKeyAll(substr($primaryKeyAll,0,-1));
				$sql.=" WHERE 	`".$this->model->getPrimaryKeyName()."`		IN	(". $this->model->getPrimaryKeyAll(). ")";

			} else if ($this->getVendor() ==  self::mssql) {
				$sql = "
			UPDATE 	[document]
			SET 	[isDefault]			=	\"". $this->model->getIsDefault(0,'string') . "\",
					[isNew]				=	\"". $this->model->getIsNew(0,'string') . "\",
					[isDraft]			=	\"". $this->model->getIsDraft(0,'string') . "\",
					[isUpdate]			=	\"". $this->model->getIsUpdate(0,'string') . "\",
					[isDelete]			=	\"". $this->model->getIsDelete(0,'string') . "\",
					[isActive]			=	\"". $this->model->getIsActive(0,'string') . "\",
					[isApproved]		=	\"". $this->model->getIsApproved(0,'string') . "\",
					[By]				=	\"". $this->model->getBy() . "\",
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[documentId]		IN	(". $this->model->getDocumentIdAll() . ")";
			} else if ($this->getVendor() == self::oracle) {
				$sql = "
				UPDATE	\"document\"
				SET 	\"isDefault\"		=	\"". $this->model->getIsDefault(0,'string') . "\",
					\"isNew\"			=	\"". $this->model->getIsNew(0,'string') . "\",
					\"isDraft\"			=	\"". $this->model->getIsDraft(0,'string') . "\",
					\"isUpdate\"		=	\"". $this->model->getIsUpdate(0,'string') . "\",
					\"isDelete\"		=	\"". $this->model->getIsDelete(0,'string') . "\",
					\"isActive\"		=	\"". $this->model->getIsActive(0,'string') . "\",
					\"isApproved\"		=	\"". $this->model->getIsApproved(0,'string') . "\",
					\"By\"				=	\"". $this->model->getBy() . "\",
					\"Time\"			=	" . $this->model->getTime() . "
			WHERE 	\"documentId\"		IN	(". $this->model->getDocumentIdAll() . ")";
			}
		} else if ($this->isAdmin ==1){

			if($this->getVendor() == self::mysql) {
				$sql="
				UPDATE `".$this->model->getTableName()."`
				SET";
			} else if($this->getVendor()==self::mssql) {
				$sql="
			UPDATE 	[".$this->model->getTableName()."]
			SET 	";

			} else if ($this->getVendor()==self::oracle) {
				$sql="
			UPDATE \"".$this->model->getTableName()."\"
			SET    ";
			}
			//	echo "arnab[".$this->model->getDocumentId(0,'array')."]";
			/**
			 *	System Validation Checking
			 *  @var $access
			 */
			$access  = array("isDefault","isNew","isDraft","isUpdate","isDelete","isActive","isApproved");
			foreach($access as $systemCheck) {


				if($this->getVendor() == self::mysql) {
					$sqlLooping.=" `".$systemCheck."` = CASE `".$this->model->getPrimaryKeyName()."`";
				} else if($this->getVendor()==self::mssql) {
					$sqlLooping.="  [".$systemCheck."] = CASE [".$this->model->getPrimaryKeyName()."]";

				} else if ($this->getVendor()==self::oracle) {
					$sqlLooping.="	\"".$systemCheck."\" = CASE \"".$this->model->getPrimaryKeyName()."\"";
				}
				switch ($systemCheck){
					case 'isDefault':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDocumentId($i,'array')."\"
							THEN \"".$this->model->getIsDefault($i,'array')."\"";
						}
						break;
					case 'isNew':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDocumentId($i,'array')."\"
							THEN \"".$this->model->getIsNew($i,'array')."\"";

						} break;
					case 'isDraft':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDocumentId($i,'array')."\"
							THEN \"".$this->model->getIsDraft($i,'array')."\"";
						}
						break;
					case 'isUpdate':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDocumentId($i,'array')."\"
							THEN \"".$this->model->getIsUpdate($i,'array')."\"";
						}
						break;
					case 'isDelete':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDocumentId($i,'array')."\"
							THEN \"".$this->model->getIsDelete($i,'array')."\"";
						}
						break;
					case 'isActive':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDocumentId($i,'array')."\"
							THEN \"".$this->model->getIsActive($i,'array')."\"";
						}
						break;
					case 'isApproved':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->getDocumentId($i,'array')."\"
							THEN \"".$this->model->getIsApproved($i,'array')."\"";
						}
						break;
				}


				$sqlLooping.= " END,";
			}

			$sql.=substr($sqlLooping,0,-1);
			if($this->getVendor() == self::mysql) {
				$sql.="
			WHERE `".$this->model->getPrimaryKeyName()."` IN (".$this->model->getPrimaryKeyAll().")";
			} else if($this->getVendor()==self::mssql) {
				$sql.="
			WHERE `=[".$this->model->getPrimaryKeyName()."] IN (".$this->model->getPrimaryKeyAll().")";
			} else if ($this->getVendor()==self::oracle) {
				$sql.="
			WHERE \"".$this->model->getPrimaryKeyName()."\" IN (".$this->model->getPrimaryKeyAll().")";
			}
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		$this->q->commit();
		echo json_encode(array(
            "success" => true,
            "message" => "Deleted"
            ));
            exit();

	}



	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel() {
		header('Content-Type','application/json; charset=utf-8');
		if($_SESSION['start']==0) {
			$sql=str_replace("LIMIT","",$_SESSION['sql']);
			$sql=str_replace($_SESSION['start'].",".$_SESSION['limit'],"",$sql);
		} else {
			$sql=$_SESSION['sql'];
		}
		$this->q->read($sql);

		$this->excel->setActiveSheetIndex(0);
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array(
					'borders' => array(
						'inside' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '000000'),
		),
						'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '000000'),
		),
		),
		);
		// header all using  3 line  starting b
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$this->excel->getActiveSheet()->setCellValue('B2',$this->title);
		$this->excel->getActiveSheet()->setCellValue('E2','');
		$this->excel->getActiveSheet()->mergeCells('B2:E2');
		$this->excel->getActiveSheet()->setCellValue('B3','No');
		$this->excel->getActiveSheet()->setCellValue('C3','Dokumen');
		$this->excel->getActiveSheet()->setCellValue('D3','Nama');
		$this->excel->getActiveSheet()->setCellValue('E3','Penerangan');
		$this->excel->getActiveSheet()->getStyle('B2:E2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:E2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:E3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:E3')->getFill()->getStartColor()->setARGB('66BBFF');
		//
		$loopRow=4;
		$i=0;
		while($row  = 	$this->q->fetchAssoc()) {
			//	echo print_r($row);

			$this->excel->getActiveSheet()->setCellValue('B'.$loopRow,++$i);
			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['doc_uniqueId']);
			$this->excel->getActiveSheet()->setCellValue('D'.$loopRow,$row['doc_nme']);
			$this->excel->getActiveSheet()->setCellValue('E'.$loopRow,$row['NoDoc']);
			$loopRow++;
			$lastRow='E'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="doc.xlsx";
		$objWriter->save("/var/www/html/kospek/document/document/excel/".$filename);

		$file = fopen("/var/www/html/kospek/document/document/excel/".$filename,'r');
		if($file){
			echo json_encode(array("success"=>'true',"message"=>"File generated"));
			exit();
		} else {
			echo json_encode(array("success"=>'false',"message"=>"File not generated"));
			exit();

		}
	}

	function documentCategoryId() {
		header('Content-Type','application/json; charset=utf-8');
		$sql	=	"
		SELECT	*
		FROM   `documentCategory`
		WHERE   1 ";
		$this->q->read($sql);
		$total = $this->q->numberRows();
		$items		 =	array();
		while($row   = 	$this->q->fetchAssoc()) {
			$items[] =	$row;
		}
		echo json_encode(
		array(
											'totalCount' 		=>	$total,
											'documentCategory'	=> 	$items
		)
		);
	}
}

$documentObject  	= 	new documentClass();


/**
 *	crud -create,read,update,delete
 **/
if(isset($_POST['method']))	{
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_POST['leafId'])){
		$documentObject->setLeafId($_POST['leafId']);
	}
	if(isset($_POST['isAdmin'])){
		$documentObject->setIsAdmin($_POST['isAdmin']);
	}

	/*
	 *  Filtering
	 */

	if(isset($_POST['query'])){
		$documentObject->setFieldQuery($_POST['query']);
	}
	if(isset($_POST['filter'])){
		$documentObject->setGridQuery($_POST['filter']);
	}
	/*
	 *  Ordering
	 */
	if(isset($_POST['order'])){
		$documentObject->setOrder($_POST['order']);
	}
	if(isset($_POST['sortField'])){
		$documentObject->setSortField($_POST['sortField']);
	}
	/*
	 *  Load the dynamic value
	 */
	$documentObject -> execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_POST['method']=='create')	{
		$documentObject->create();
	}
	if($_POST['method']=='read') 	{
		$documentObject->read();
	}

	if($_POST['method']=='save') 	{
		$documentObject->update();
	}
	if($_POST['method']=='delete') 	{
		$documentObject->delete();
	}

}

if(isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if(isset($_GET['leafId'])){
		$documentObject->setLeafId($_GET['leafId']);
	}
	/*
	 *  Load the dynamic value
	 */
	$documentObject -> execute();
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {
			$documentObject->staff();
		}
	}
	/*
	 *  Excel Reporting
	 */
	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$documentObject->excel();
		}
	}
}
?>
