<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../class/classDocumentTrail.php");
require_once("../model/religionModel.php");
/**
 * this is religion setting files.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package religion
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class religionClass extends configClass
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
	 *  Ascending ,Descending ASC,DESC
	 * @var string $order;`
	 */
	public $order;
	/**
	 * Sort the default field.Mostly consider as primary key default.
	 * @var string $sort_field
	 */
	public $sort_field;
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
	 * Current Table Religion Indentification Value
	 * @var numeric $religionId
	 */
	public $religionId;
	/**
	 * Religion Model
	 * @var string $religionModel
	 */
	public $model;
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
		$this->q->connect($this->connection, $this->username, $this->database, $this->password);
		$this->excel         = new PHPExcel();
		$this->audit         = 0;
		$this->log           = 0;
		$this->q->log        = $this->log;
		$this->model         = new religionModel();
		$this->model->vendor = $this->vendor;
		$this->model->execute();
		$this->documentTrail = new documentTrailClass();
	}
	/* (non-PHPdoc)
	 * @see config::create()
	 */
	public function create()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->q->vendor == 'mysql' || $this->q->vendor == 'mysql') {
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		$sql = "
			INSERT INTO `" . religionModel::tableName . "`	
					(
						`" . religionModel::religionDesc . "`,	`" . religionModel::isDefaut . "`,
						`" . religionModel::isNew . "`,			`" . religionModel::isDraft . "`,
						`" . religionModel::isUpdate . "`,		`" . religionModel::isDelete . "`,
						`" . religionModel::isActive . "`,		`" . religionModel::isApproved . "`,
						`" . religionModel::By . "`,			`" . religionModel::Time . "`
					)
			VALUES	
					(
						'" . $this->model->religionDesc . "',	'" . $this->model->isDefaut . "',
						'" . $this->model->isNew . "',			'" . $this->model->isDraft . "',
						'" . $this->model->isUpdate . "',		'" . $this->model->isDelete . "',
						'" . $this->model->isActive . "',		'" . $this->model->isApproved . "',
						'" . $this->model->By . "',				" . $this->model->Time . "
					);";
		$this->q->start();
		$this->model->create();
		if ($this->q->vendor == 'mysql' || $this->q->vendor == 'mysql') {
			$sql = "
			INSERT INTO `religion`	
					(
						`religionDesc`,						`isDefault`,
						`isNew`,							`isDraft`,
						`isUpdate`,							`isDelete`,
						`isActive`,							`isApproved`,
						`By`,								`Time`
					)
			VALUES	
					(
						'" . $this->model->religionDesc . "',	'" . $this->model->isDefaut . "',
						'" . $this->model->isNew . "',			'" . $this->model->isDraft . "',
						'" . $this->model->isUpdate . "',		'" . $this->model->isDelete . "',
						'" . $this->model->isActive . "',		'" . $this->model->isApproved . "',
						'" . $this->model->By . "',				" . $this->model->Time . "
					);";
		} else if ($this->q->vendor == 'microsoft') {
			$sql = "
			INSERT INTO [religion]
					(
						[religionDesc],						[isDefault],
						[isNew],							[isDraft],
						[isUpdate],							[isDelete],
						[isActive],							[isApproved],
						[By],								[Time]
					)
			VALUES	
					(
						'" . $this->model->religionDesc . "',	'" . $this->model->isDefaut . "',
						'" . $this->model->isNew . "',			'" . $this->model->isDraft . "',
						'" . $this->model->isDraft . "',		'" . $this->model->isDelete . "',
						'" . $this->model->isUpdate . "',		'" . $this->model->isApproved . "',
						'" . $this->model->isActive . "',		" . $this->model->Time . "
					);";
		} else if ($this->q->vendor == 'oracle') {
			$sql = "
			INSERT INTO	\"religion\"
					(
						\"religionDesc\",					\"isDefault\",
						\"isNew\",							\"isDraft\",
						\"isUpdate\",						\"isDelete\",
						\"isActive\",						\"isApproved\",
						\"By\",								\"Time\"
					)	
			VALUES	
					(
						'" . $this->model->religionDesc . "',	'" . $this->model->isDefaut . "',
						'" . $this->model->isNew . "',			'" . $this->model->isDraft . "',
						'" . $this->model->isDraft . "',		'" . $this->model->isDelete . "',
						'" . $this->model->isUpdate . "',		'" . $this->model->isApproved . "',
						'" . $this->model->isActive . "',		" . $this->model->Time . "
					)";
		}
		//advance logging future
		$this->q->table           = $this->model->tableName;
		$this->q->primaryKeyName  = $this->model->primaryKeyName;
		// $this->q->primaryKeyValue = $this->q->lastInsertId();  not use here
		echo "audit value".$this->audit;
		$this->q->audit           = $this->audit;
		$this->q->create($sql);
		
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->result_text
			));
			exit();
		}
		
		
		$this->q->commit();
		echo json_encode(array(
            "success" => true,
            "message" => "Record Created"
            ));
            exit();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	public function read()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->q->vendor == 'mysql' || $this->q->vendor == 'mysql') {
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		if ($this->q->vendor == 'mysql' || $this->q->vendor == 'mysql') {
			$sql = "
					SELECT	*
					FROM 	`religion`
					WHERE 	`isActive` ='1'	";
			if ($this->religionId) {
				$sql .= " AND `religionId`='" . $this->strict($this->religionId, 'n') . "'";
			}
		} else if ($this->q->vendor == 'microsoft') {
			$sql = "
					SELECT	*
					FROM 	[religion]
					WHERE 	[isActive] ='1'	";
			if ($this->religionId) {
				$sql .= " AND [religionId]='" . $this->strict($this->religionId, 'n') . "'";
			}
		} else if ($this->q->vendor == 'oracle') {
			$sql = "
					SELECT	*
					FROM 	\"religion\"
					WHERE \"isActive\"='1'	";
			if ($this->religionId) {
				$sql .= " AND \"religionId\"='" . $this->strict($this->religionId, 'n') . "'";
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
            'religionId'
            );
            /**
             *	filter table
             * @variables $tableArray
             */
            $tableArray  = null;
            $tableArray  = array(
            'religion'
            );
            if ($this->quickFilter) {
            	if ($this->q->vendor == 'mysql') {
            		$sql .= $this->q->quickSearch($tableArray, $filterArray);
            	} else if ($this->q->vendor == 'microsoft') {
            		$tempSql = $this->q->quickSearch($tableArray, $filterArray);
            		$sql .= $tempSql;
            	} else if ($this->q->vendor == 'oracle') {
            		$tempSql = $this->q->quickSearch($tableArray, $filterArray);
            		$sql .= $tempSql;
            	}
            }
            /**
             *	Extjs filtering mode
             */
            if ($this->filter) {
            	if ($this->q->vendor == 'mysql') {
            		$sql .= $this->q->searching();
            	} else if ($this->q->vendor == 'microsoft') {
            		$tempSql2 = $this->q->searching();
            		$sql .= $tempSql2;
            	} else if ($this->q->vendor == 'oracle') {
            		$tempSql2 = $this->q->searching();
            		$sql .= $tempSql2;
            	}
            }
            $this->q->read($sql);
            if ($this->q->execute == 'fail') {
            	echo json_encode(array(
                "success" => false,
                "message" => $this->q->result_text
            	));
            	exit();
            }
            $total = $this->q->numberRows();
            if ($this->order && $this->sort_field) {
            	if ($this->q->vendor == 'mysql' || $this->q->vendor == 'normal') {
            		$sql .= "	ORDER BY `" . $sort_field . "` " . $dir . " ";
            	} else if ($this->q->vendor == 'microsoft') {
            		$sql .= "	ORDER BY [" . $sort_field . "] " . $dir . " ";
            	} else if ($this->q->vendor == 'oracle') {
            		$sql .= "	ORDER BY \"" . $sort_field . "\"  " . $dir . " ";
            	}
            }
            $_SESSION['sql']   = $sql; // push to session so can make report via excel and pdf
            $_SESSION['start'] = $_POST['start'];
            $_SESSION['limit'] = $_POST['limit'];
            if (empty($_POST['filter'])) {
            	if (isset($_POST['start']) && isset($_POST['limit'])) {
            		// only mysql have limit
            		if ($this->q->vendor == 'mysql') {
            			$sql .= " LIMIT  " . $_POST['start'] . "," . $_POST['limit'] . " ";
            		} else if ($this->q->vendor == 'microsoft') {
            			/**
            			 *	 Sql Server and Oracle used row_number
            			 *	 Parameterize Query We don't support
            			 */
            			$sql = "
							WITH [religionDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [religionId]) AS 'RowNumber'
								FROM [religion]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[religionDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $_POST['start'] . "
							AND 			" . ($_POST['start'] + $_POST['limit'] - 1) . ";";
            		} else if ($this->q->vendor == 'oracle') {
            			/**
            			 *  Oracle using derived table also
            			 */
            			$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT *
									FROM 	\"religion\"
									WHERE \"isActive\"=1  " . $tempSql . $tempSql2 . $orderBy . "
								 ) a
						where rownum <= '" . ($_POST['start'] + $_POST['limit'] - 1) . "' )
						where r >=  '" . $_POST['start'] . "'";
            		} else {
            			echo "undefine vendor";
            		}
            	}
            }
            /*
             *  Only Execute One Query
             */
            if (!($this->religionId)) {
            	$this->q->read($sql);
            	if ($this->q->execute == 'fail') {
            		echo json_encode(array(
                    "success" => false,
                    "message" => $this->q->result_text
            		));
            		exit();
            	}
            }
            $items = array();
            while ($row = $this->q->fetchAssoc()) {
            	$items[] = $row;
            }
            if ($this->religionId) {
            	$json_encode = json_encode(array(
                'success' => true,
                'total' => $total,
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
		//UTF8
		if ($this->q->vendor == 'mysql') {
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
			if ($this->q->execute == 'fail') {
				echo json_encode(array(
                    "success" => false,
                    "message" => $this->q->result_text
				));
				exit();
			}
		}
		$this->q->start();
		$this->model->update();
		if ($this->q->vendor == 'mysql') {
			$sql = "
			UPDATE 	`religion`
			SET 	`religionDesc`		=	'" . $this->model->religionDesc . "',
					`isActive`			=	'" . $this->model->isActive . "',
					`isNew`				=	'" . $this->model->isNew . "',
					`isDraft`			=	'" . $this->model->isDraft . "',
					`isUpdate`			=	'" . $this->model->isUpdate . "',
					`isDelete`			=	'" . $this->model->isDelete . "',
					`isApproved`		=	'" . $this->model->isApproved . "',
					`By`				=	'" . $this->model->By . "',
					`Time				=	" . $this->model->Time . "
			WHERE 	`religionId`		=	'" . $this->model->religionId . "'";
		} else if ($this->q->vendor == 'microsoft') {
			$sql = "
			UPDATE 	[religion]
			SET 	[religionDesc]		=	'" . $this->strict($_POST['religionDesc'], 's') . "',
					[isActive]			=	'" . $this->model->isActive . "',
					[isNew]				=	'" . $this->model->isNew . "',
					[isDraft]			=	'" . $this->model->isDraft . "',
					[isUpdate]			=	'" . $this->model->isUpdate . "',
					[isDelete]			=	'" . $this->model->isDelete . "',
					[isApproved]		=	'" . $this->model->isApproved . "',
					[By]				=	'" . $this->model->By . "',
					[Time]				=	" . $this->model->Time . "
			WHERE 	[religionId]		=	'" . $this->strict($_POST['religionId'], 'n') . "'";
		} else if ($this->q->vendor == 'oracle') {
			$sql = "
			UPDATE 	\"religion\"
			SET 	\"religionDesc\"	=	'" . $this->model->religionDesc . "',
					\"isActive\"		=	'" . $this->model->isActive . "',
					\"isNew\"			=	'" . $this->model->isNew . "',
					\"isDraft\"			=	'" . $this->model->isDraft . "',
					\"isUpdate\"		=	'" . $this->model->isUpdate . "',
					\"isDelete\"		=	'" . $this->model->isDelete . "',
					\"isApproved\"		=	'" . $this->model->isApproved . "',
					\"By\"				=	'" . $this->model->By . "',
					\"Time\"			=	" . $this->model->Time . "
			WHERE 	\"religionId\"		=	'" . $this->model->religionId . "'";
		}
		/*
		 *  require three variable below to track  table audit
		 */
		$this->q->tableName       = $this->model->tableName;
		$this->q->primaryKeyName  = $this->model->primaryKeyName;
		$this->q->primaryKeyValue = $this->model->religionId;
		$this->q->audit           = $this->audit;
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => "false",
                "message" => $this->q->result_text
			));
			exit();
		}
		$this->q->commit();
		echo json_encode(array(
            "success" => "true",
            "message" => "Updated"
            ));
            exit();
	}
	/* (non-PHPdoc)
	 * @see config::delete()
	 */
	function delete()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->q->vendor == 'mysql') {
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->delete();
		if ($this->q->vendor == 'mysql') {
			$sql = "
			UPDATE 	`religion`
			SET 	`isActive`			=	'" . $this->model->isActive . "',
					`isNew`				=	'" . $this->model->isNew . "',
					`isDraft`			=	'" . $this->model->isDraft . "',
					`isUpdate`			=	'" . $this->model->isUpdate . "',
					`isDelete`			=	'" . $this->model->isDelete . "',
					`isApproved`		=	'" . $this->model->isApproved . "',
					`By`				=	'" . $this->model->By . "',
					`Time				=	" . $this->model->Time . "
			WHERE 	`religionId`		=	'" . $this->model->religionId . "'";
		} else if ($this->q->vendor == 'microsoft') {
			$sql = "
			UPDATE 	[religion]
			SET 	[isActive]			=	'" . $this->model->isActive . "',
					[isNew]				=	'" . $this->model->isNew . "',
					[isDraft]			=	'" . $this->model->isDraft . "',
					[isUpdate]			=	'" . $this->model->isUpdate . "',
					[isDelete]			=	'" . $this->model->isDelete . "',
					[isApproved]		=	'" . $this->model->isApproved . "',
					[By]				=	'" . $this->model->By . "',
					[Time]				=	" . $this->model->Time . "
			WHERE 	[religionId]		=	'" . $this->model->religionId . "'";
		} else if ($this->q->vendor == 'oracle') {
			$sql = "
			UPDATE 	\"religion\"
			SET 	\"religionDesc\"	=	'" . $this->model->religionDesc . "',
					\"isActive\"		=	'" . $this->model->isActive . "',
					\"isNew\"			=	'" . $this->model->isNew . "',
					\"isDraft\"			=	'" . $this->model->isDraft . "',
					\"isUpdate\"		=	'" . $this->model->isUpdate . "',
					\"isDelete\"		=	'" . $this->model->isDelete . "',
					\"isApproved\"		=	'" . $this->model->isApproved . "',
					\"By\"				=	'" . $this->model->By . "',
					\"Time\"			=	" . $this->model->Time . "
			WHERE 	\"religionId\"		=	'" . $this->model->religionId . "'";
		}
		// advance logging future
		$this->q->table           = $this->model->tableName;
		$this->q->primaryKeyName  = $this->model->primaryKeyName;
		$this->q->primaryKeyValue = $this->model->religionId;
		$this->q->audit           = $this->audit;
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => "false",
                "message" => $this->q->result_text
			));
			exit();
		}
		$this->q->commit();
		echo json_encode(array(
            "success" => "true",
            "message" => "Deleted"
            ));
            exit();
	}
	/**
	 *  To check if a key duplicate or not
	 */
	function duplicate()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->q->vendor == 'mysql') {
			//UTF8
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		if ($this->q->vendor == 'mysql') {
			$sql = "
			SELECT	*
			FROM 	`religion`
			WHERE 	`religionDesc` 	= 	'" . $this->model->religionDesc . "'
			AND		`isActive`		=	1";
		} else if ($this->q->vendor == 'microsoft') {
			$sql = "
			SELECT	*
			FROM 	[religion]
			WHERE 	[religionDesc] 	= 	'" . $this->model->religionDesc . "'
			AND		[isActive]		=	1";
		} else if ($this->q->vendor == 'oracle') {
			$sql = "
			SELECT	*
			FROM 	\"religion\"
			WHERE 	\"religionDesc\" 	= 	'" . $this->model->religionDesc . "'
			AND		\"isActive\"		=	1";
		}
		$this->q->read($sql);
		$total = 0;
		$total = $this->q->numberRows();
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->result_text
			));
			exit();
		} else {
			$row = $this->q->fetchArray();
			echo json_encode(array(
                "success" => "true",
                "total" => $total,
                "message" => "Duplicate Record",
                "religionDesc" => $row['religionDesc']
			));
			exit();
		}
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	 */
	function excel()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		//UTF8
		if ($this->q->vendor == 'normal' || $this->q->vendor == 'mysql') {
			$sql = 'SET NAMES "utf8"';
			$this->q->fast($sql);
		}
		if ($_SESSION['start'] == 0) {
			$sql = str_replace("LIMIT", "", $_SESSION['sql']);
			$sql = str_replace($_SESSION['start'] . "," . $_SESSION['limit'], "", $sql);
		} else {
			$sql = $_SESSION['sql'];
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->result_text
			));
			exit();
		}
		$this->excel->setActiveSheetIndex(0);
		// check file exist or not and return response
		$styleThinBlackBorderOutline = array(
            'borders' => array(
                'inside' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => '000000'
                        )
                        ),
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'argb' => '000000'
                        )
                        )
                        )
                        );
                        // header all using  3 line  starting b
                        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                        $this->excel->getActiveSheet()->setCellValue('B2', $this->title);
                        $this->excel->getActiveSheet()->setCellValue('C2', '');
                        $this->excel->getActiveSheet()->mergeCells('B2:C2');
                        $this->excel->getActiveSheet()->setCellValue('B3', 'No');
                        $this->excel->getActiveSheet()->setCellValue('C3', 'Penerangan');
                        $this->excel->getActiveSheet()->getStyle('B2:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $this->excel->getActiveSheet()->getStyle('B2:C2')->getFill()->getStartColor()->setARGB('66BBFF');
                        $this->excel->getActiveSheet()->getStyle('B3:C3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $this->excel->getActiveSheet()->getStyle('B3:C3')->getFill()->getStartColor()->setARGB('66BBFF');
                        //
                        $loopRow = 4;
                        $i       = 0;
                        while ($row = $this->q->fetch_array()) {
                        	//	echo print_r($row);
                        	$this->excel->getActiveSheet()->setCellValue('B' . $loopRow, ++$i);
                        	$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, 'a' . $row['religionDesc']);
                        	$loopRow++;
                        	$lastRow = 'C' . $loopRow;
                        }
                        $from    = 'B2';
                        $to      = $lastRow;
                        $formula = $from . ":" . $to;
                        $this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
                        $filename  = "religion" . rand(0, 10000000) . ".xlsx";
                        $path      = $_SERVER['DOCUMENT_ROOT'] . "/" . $this->application . "/basic/document/excel/" . $filename;
                        $this->audit->create_trail($this->leafId, $path, $filename);
                        $objWriter->save($path);
                        $file = fopen($path, 'r');
                        if ($file) {
                        	echo json_encode(array(
                "success" => 'true',
                "message" => "File generated",
                "filename" => $filename
                        	));
                        	exit();
                        } else {
                        	echo json_encode(array(
                "success" => 'false',
                "message" => "File not generated"
                ));
                exit();
                        }
	}
}
/**
 *	Declare object
 **/
$religionObject = new religionClass();
if (isset($_SESSION['staffId'])) {
	$religionObject->staffId = $_SESSION['staffId'];
}
if (isset($_SESSION['vendor'])) {
	$religionObject->vendor = $_SESSION['vendor'];
}
/**
 *	crud -create,read,update,delete
 **/
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_POST['leafId'])) {
		$religionObject->leafId = $_POST['leafId'];
	}
	if (isset($_POST['religionId'])) {
		$religionObject->religionId = $_POST['religionId'];
	}
	if (isset($_POST['filter'])) {
		$religionObject->filter = $_POST['filter'];
	}
	if (isset($_POST['query'])) {
		$religionObject->quickFilter = $_POST['query'];
	}
	if (isset($_POST['order'])) {
		$religionObject->order = $_POST['order'];
	}
	if (isset($_POST['sort_field'])) {
		$religionObject->sort_field = $_POST['sort_field'];
	}
	/*
	 *  Load the dynamic value
	 */
	$religionObject->execute();
	if ($_POST['method'] == 'create') {
		$religionObject->create();
	}
	if ($_POST['method'] == 'read') {
		$religionObject->read();
	}
	if ($_POST['method'] == 'save') {
		$religionObject->update();
	}
	if ($_POST['method'] == 'delete') {
		$religionObject->delete();
	}
}
if (isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	if (isset($_GET['leafId'])) {
		$religionObject->leafId = $_GET['leafId'];
	}
	/*
	 *  Load the dynamic value
	 */
	$religionObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$religionObject->staffId();
		}
	}
	if (isset($_GET['religionDesc'])) {
		if (strlen($_GET['religionDesc']) > 0) {
			$religionObject->duplicate();
		}
	}
	if (isset($_GET['mode'])) {
		if ($_GET['mode'] == 'excel') {
			$religionObject->excel();
		}
	}
}
?>
