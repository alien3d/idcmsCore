<?php

session_start();
require_once ("../../class/classAbstract.php");
require_once ("../../class/classRecordSet.php");
require_once ("../../document/class/classDocumentTrail.php");
require_once ("../../document/model/documentModel.php");
require_once ("../model/religionModel.php");

/**
 * this is religion setting files.This sample template file for master record
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package religion
 * @subpackage religionv1,v2,v3,v4,v5
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class ReligionClass extends ConfigClass {

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
     * Class Loader
     */
    function execute() {
        parent::__construct();

        // audit property
        $this->audit = 0;
        $this->log = 0;

        $this->model = new ReligionModel ();
        $this->model->setVendor($this->getVendor());
        $this->model->execute();
        
        $this->q = new Vendor ();
        $this->q->vendor = $this->getVendor();
        $this->q->leafId = $this->getLeafId();
        $this->q->staffId = $this->getStaffId();
        $this->q->fieldQuery = $this->getFieldQuery();
        $this->q->gridQuery = $this->getGridQuery();
        $this->q->tableName = $this->model->getTableName();
		$this->q->primaryKeyName = $this->model->getPrimaryKeyName();
        $this->q->log = $this->log;
        $this->q->audit = $this->audit;
        $this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

        $this->recordSet = new RecordSet ();
        $this->recordSet->setTableName($this->model->getTableName());
        $this->recordSet->setPrimaryKeyName($this->model->getPrimaryKeyName());
        $this->recordSet->execute();

        $this->documentTrail = new DocumentTrailClass ();
        $this->documentTrail->setVendor($this->getVendor());
        $this->documentTrail->setStaffId($this->getStaffId());
        $this->documentTrail->setLeafId($this->getLeafId());
        $this->documentTrail->execute();

        $this->excel = new PHPExcel ();
    }

    /* (non-PHPdoc)
     * @see config::create()
     */

    public function create() {
        header('Content-Type:application/json; charset=utf-8');
        $start = microtime(true);
        if ($this->getVendor() == self::MYSQL) {
            $sql = "SET NAMES \"utf8\"";
            $this->q->fast($sql);
        }
        $this->q->start();
        $this->model->create();
        if ($this->getVendor() == self::MYSQL) {
            $sql = "
			INSERT INTO `religion`
					(
						`religionDesc`,												`isDefault`,
						`isNew`,													`isDraft`,
						`isUpdate`,													`isDelete`,
						`isActive`,													`isApproved`,
						`isReview`,                      		  	 				`isPost`,
						`executeBy`,												`executeTime`
					)
			VALUES
					(
						'" . $this->model->getReligionDesc() . "',					'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
             			'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					);";
        } else if ($this->getVendor() == self::MSSQL) {
            $sql = "
			INSERT INTO [religion]
					(
						[religionDesc],													[isDefault],
						[isNew],														[isDraft],
						[isUpdate],														[isDelete],
						[isActive],														[isApproved],
						[isReview],														[isPost],
						[executeBy],													[executeTime]
					)
			VALUES
					(
						'" . $this->model->getReligionDesc() . "',						'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',				'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',			'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',			'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',			'" . $this->model->getIsPost(0, 'single') . "',
						'" . $this->model->getExecuteBy() . "',						" . $this->model->getExecuteTime() . "
					);";
        } else if ($this->getVendor() == self::ORACLE) {

            $sql = "
			INSERT INTO	RELIGION
					(
						RELIGIONDESC,												ISDEFAULT,
						ISNEW,														ISDRAFT,
						ISUPDATE,													ISDELETE,
						ISACTIVE,													ISAPPROVED,
						ISREVIEW,													ISPOST,
						EXECUTEBY,													EXECUTETIME
					)
			VALUES
					(
						'" . $this->model->getReligionDesc() . "',					'" . $this->model->getIsDefault(0, 'single') . "',
						'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
						'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
						'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
						'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',						
						'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
					)";
        } else if ($this->getVendor() == self::DB2) {
            $sql = "
			INSERT INTO	RELIGION
			(
			RELIGIONDESC,												ISDEFAULT,
			ISNEW,														ISDRAFT,
			ISUPDATE,													ISDELETE,
			ISACTIVE,													ISAPPROVED,
			ISREVIEW,													ISPOST,
			EXECUTEBY,													EXECUTETIME
			)
			VALUES
			(
			'" . $this->model->getReligionDesc() . "',					'" . $this->model->getIsDefault(0, 'single') . "',
			'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
			'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
			'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
			'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',
			'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
			)";
        } else if ($this->getVendor() == self::POSTGRESS) {
            $sql = "
			INSERT INTO	RELIGION
			(
			RELIGIONDESC,												ISDEFAULT,
			ISNEW,														ISDRAFT,
			ISUPDATE,													ISDELETE,
			ISACTIVE,													ISAPPROVED,
			ISREVIEW,													ISPOST,
			EXECUTEBY,													EXECUTETIME
			)
			VALUES
			(
			'" . $this->model->getReligionDesc() . "',					'" . $this->model->getIsDefault(0, 'single') . "',
			'" . $this->model->getIsNew(0, 'single') . "',			'" . $this->model->getIsDraft(0, 'single') . "',
			'" . $this->model->getIsUpdate(0, 'single') . "',		'" . $this->model->getIsDelete(0, 'single') . "',
			'" . $this->model->getIsActive(0, 'single') . "',		'" . $this->model->getIsApproved(0, 'single') . "',
			'" . $this->model->getIsReview(0, 'single') . "',		'" . $this->model->getIsPost(0, 'single') . "',
			'" . $this->model->getExecuteBy() . "',					" . $this->model->getExecuteTime() . "
			)";
        } else {
            echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
            exit();
        }
        
        $this->q->create($sql);
        $religionId = $this->q->lastInsertId();
        if ($this->q->execute == 'fail') {
            echo json_encode(array("success" => false, "message" => $this->q->responce));
            exit();
        }
        $this->q->commit();
        $end = microtime(true);
		$time = $end - $start;
        echo json_encode(
        		array(	"success" => true, 
        				"message" => "Record Created", 
        				"religionId" => $religionId,
        				"time"=>$time));
        exit();
    }

    /* (non-PHPdoc)
     * @see config::read()
     */

    public function read() {
        header('Content-Type:application/json; charset=utf-8');
        $start = microtime(true);
        if ($this->isAdmin == 0) {
            if ($this->q->vendor == self::MYSQL) {
                $this->auditFilter = "	AND `religion`.`isActive`		=	1	";
            } else if ($this->q->vendor == self::MSSQL) {
                $this->auditFilter = "	AND [religion].[isActive]		=	1	";
            } else if ($this->q->vendor == self::ORACLE) {
                $this->auditFilter = "	AND RELIGION.ISACTIVE	=	1	";
            } else if ($this->q->vendor == self::DB2) {
                $this->auditFilter = "	AND RELIGION.ISACTIVE	=	1	";
            } else if ($this->q->vendor == self::POSTGRESS) {
                $this->auditFilter = "	AND RELIGION.ISACTIVE	=	1	";
            } else {
                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                exit();
            }
        } else if ($this->isAdmin == 1) {
            if ($this->getVendor() == self::MYSQL) {
                $this->auditFilter = "	1	=	1	";
            } else if ($this->q->vendor == self::MSSQL) {
                $this->auditFilter = "	1	=	1 	";
            } else if ($this->q->vendor == self::ORACLE) {
                $this->auditFilter = "	1	=	1 	";
            } else if ($this->q->vendor == self::DB2) {
                $this->auditFilter = "	1	=	1 	";
            } else if ($this->q->vendor == self::POSTGRESS) {
                $this->auditFilter = "	1	=	1 	";
            } else {
                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                exit();
            }
        }
        
        $items = array();
        if ($this->getVendor() == self::MYSQL) {
            $sql = "SET NAMES \"utf8\"";
            $this->q->fast($sql);
        }
        if ($this->getVendor() == self::MYSQL) {
            $sql = "
			SELECT	`religion`.`religionId`,
						`religion`.`religionDesc`,
						`religion`.`isDefault`,
						`religion`.`isNew`,
						`religion`.`isDraft`,
						`religion`.`isUpdate`,
						`religion`.`isDelete`,
						`religion`.`isActive`,
						`religion`.`isApproved`,
						`religion`.`isReview`,
						`religion`.`isPost`,
						`religion`.`executeBy`,
						`religion`.`executeTime`,
						`staff`.`staffName`
			FROM 	`religion`
			JOIN		`staff`
			ON		`religion`.`executeBy` = `staff`.`staffId`
			WHERE 	 " . $this->auditFilter;
            if ($this->model->getReligionId(0, 'single')) {
                $sql .= " AND `" . $this->model->getTableName() . "`.`" . $this->model->getPrimaryKeyName() . "`='" . $this->model->getReligionId(0, 'single') . "'";
            }
        } else if ($this->getVendor() == self::MSSQL) {
            $sql = "
			SELECT	[religion].[religionId],
						[religion].[religionDesc],
						[religion].[isDefault],
						[religion].[isNew],
						[religion].[isDraft],
						[religion].[isUpdate],
						[religion].[isDelete],
						[religion].[isActive],
						[religion].[isApproved],
						[religion].[isReview],
						[religion].[isPost],
						[religion].[executeBy],
						[religion].[executeTime],
						[staff].[staffName]
			FROM 	[religion]
			JOIN		[staff]
			ON		[religion].[executeBy] = [staff].[staffId]
			WHERE 	" . $this->auditFilter;
            if ($this->model->getReligionId(0, 'single')) {
                $sql .= " AND [" . $this->model->getTableName() . "].[" . $this->model->getPrimaryKeyName() . "]='" . $this->model->getReligionId(0, 'single') . "'";
            }
        } else if ($this->getVendor() == self::ORACLE) {
            $sql = "
			SELECT		RELIGION.RELIGIONID   		 	AS 	\"religionId\",
						RELIGION.RELIGIONDESC 			AS 	\"religionDesc\",
						RELIGION.ISDEFAULT    			AS	\"isDefault\",
						RELIGION.ISNEW		  			AS	\"isNew\",
						RELIGION.ISDRAFT	  			AS	\"isDraft\",
						RELIGION.ISUPDATE     			AS	\"isUpdate\",
						RELIGION.ISDELETE	  			AS	\"isDelete\",
						RELIGION.ISACTIVE	  			AS	\"isActive\",
						RELIGION.ISAPPROVED   			AS	\"isApproved\",
						RELIGION.ISREVIEW	  			AS	\"isReview\",
						RELIGION.ISPOST  	  			AS	\"isPost\",
						RELIGION.EXECUTEBY    			AS	\"executeBy\",
						RELIGION.EXECUTETIME  			AS	\"executeTime\",
						STAFF.STAFFNAME		  			AS	\"staffName\"	
			FROM 		RELIGION
			JOIN		STAFF
			ON			RELIGION.EXECUTEBY 	  	=	STAFF.STAFFID
			WHERE 	" . $this->auditFilter;
            if ($this->model->getReligionId(0, 'single')) {
                $sql .= " AND " . strtoupper($this->model->getTableName()) . "." . strtoupper($this->model->getPrimaryKeyName()) . "='" . $this->model->getReligionId(0, 'single') . "'";
            }
        } else if ($this->q->vendor == self::DB2) {
            
        } else if ($this->q->vendor == self::POSTGRESS) {
            
        } else {
            echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
            exit();
        }
        /**
         * filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
         * E.g  $filterArray=array('`leaf`.`leafId`');
         * @variables $filterArray;
         */
        $filterArray = null;
        $filterArray = array('religionId');
        /**
         * filter table
         * @variables $tableArray
         */
        $tableArray = null;
        $tableArray = array('religion');
        if ($this->getFieldQuery()) {
            if ($this->getVendor() == self::MYSQL) {
                $sql .= $this->q->quickSearch($tableArray, $filterArray);
            } else if ($this->getVendor() == self::MSSQL) {
                $tempSql = $this->q->quickSearch($tableArray, $filterArray);
                $sql .= $tempSql;
            } else if ($this->getVendor() == self::ORACLE) {
                $tempSql = $this->q->quickSearch($tableArray, $filterArray);
                $sql .= $tempSql;
            } else if ($this->getVendor() == self::DB2) {
                $sql .= $this->q->quickSearch($tableArray, $filterArray);
            } else if ($this->getVendor() == self::POSTGRESS) {
                $sql .= $this->q->quickSearch($tableArray, $filterArray);
            } else {
                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                exit();
            }
        }
        /**
         * Extjs filtering mode
         */
        if ($this->getGridQuery()) {
            if ($this->getVendor() == self::MYSQL) {
                $sql .= $this->q->searching();
            } else if ($this->getVendor() == self::MSSQL) {
                $tempSql2 = $this->q->searching();
                $sql .= $tempSql2;
            } else if ($this->getVendor() == self::ORACLE) {
                $tempSql2 = $this->q->searching();
                $sql .= $tempSql2;
            } else if ($this->getVendor() == self::DB2) {
                $sql .= $this->q->searching();
            } else if ($this->getVendor() == self::POSTGRESS) {
                $sql .= $this->q->searching();
            } else {
                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                exit();
            }
        }
        // optional debugger.uncomment if wanted to used
        //if ($this->q->execute == 'fail') {
        //	echo json_encode(array(
        //   "success" => false,
        //   "message" => $this->q->realEscapeString($sql)
        //	));
        //	exit();
        //}
        // end of optional debugger
        $this->q->read($sql);
        if ($this->q->execute == 'fail') {
            echo json_encode(array("success" => false, "message" => $this->q->responce));
            exit();
        }
        $total = $this->q->numberRows();
        if ($this->getOrder() && $this->getSortField()) {
            if ($this->getVendor() == self::MYSQL) {
                $sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder() . " ";
            } else if ($this->getVendor() == self::MSSQL) {
                $sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
            } else if ($this->getVendor() == self::ORACLE) {
                $sql .= "	ORDER BY " . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
            } else if ($this->getVendor() == self::DB2) {
                $sql .= "	ORDER BY " . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
            } else if ($this->getVendor() == self::POSTGRESS) {
                $sql .= "	ORDER BY " . strtoupper($this->getSortField()) . " " . strtoupper($this->getOrder()) . " ";
            } else {
                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                exit();
            }
        }
        $_SESSION ['sql'] = $sql; // push to session so can make report via excel and pdf
        $_SESSION ['start'] = $this->getStart();
        $_SESSION ['limit'] = $this->getLimit();

        if ($this->getStart() && $this->getLimit()) {
            // only mysql have limit
            if ($this->getVendor() == self::MYSQL) {
                $sql .= " LIMIT  " . $this->getStart() . "," . $this->getLimit() . " ";
            } else if ($this->getVendor() == self::MSSQL) {
                /**
                 * Sql Server and Oracle used row_number
                 * Parameterize Query We don't support
                 */
                /**
                 * Only On Sql Server Denali
                 * select * from Production.Product order by name asc 
                 * offset 10 rows fetch first 10 rows only
                 * 
                 */
                $sql = "
							WITH [religionDerived] AS
							(
								SELECT [religion].[religionId],
											[religion].[religionDesc],
											[religion].[isDefault],
											[religion].[isNew],
											[religion].[isDraft],
											[religion].[isUpdate],
											[religion].[isDelete],
											[religion].[isApproved],
											[religion].[isReview],
											[religion].[isPost],
											[religion].[executeBy],
											[religion].[executeTime],
											[staff].[staffName],
								ROW_NUMBER() OVER (ORDER BY [religionId]) AS 'RowNumber'
								FROM 	[religion]
								JOIN		[staff]
								ON		[religion].[executeBy] = [staff].[staffId]
								WHERE " . $this->auditFilter . $tempSql . $tempSql2 . "
							)
							SELECT		*
							FROM 		[religionDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . ($this->getStart() + 1) . "
							AND 			" . ($this->getStart() + $this->getLimit()) . ";";
            } else if ($this->getVendor() == self::ORACLE) {
                /**
                 * Oracle using derived table also
                 */
                $sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
								SELECT	RELIGION.RELIGIONID   		AS 	\"religionId\",
										RELIGION.RELIGIONDESC 		AS 	\"religionDesc\",
										RELIGION.ISDEFAULT    		AS	\"isDefault\",
										RELIGION.ISNEW		  		AS	\"isNew\",
										RELIGION.ISDRAFT	 		AS	\"isDraft\",
										RELIGION.ISUPDATE     		AS	\"isUpdate\",
										RELIGION.ISDELETE	  		AS	\"isDelete\",
										RELIGION.ISACTIVE	  		AS	\"isActive\",
										RELIGION.ISAPPROVED   		AS	\"isApproved\",
										RELIGION.ISREVIEW	  		AS 	\"isReview\",
										RELIGION.ISPOST		  		AS	\"isPost\",
										RELIGION.EXECUTEBY    		AS	\"executeBy\",
										RELIGION.EXECUTETIME  		AS	\"executeTime\",
										STAFF.STAFFNAME		  		AS	\"staffName\"	
								FROM 	RELIGION
								JOIN	STAFF
								ON		RELIGION.EXECUTEBY 	  	=	STAFF.STAFFID
								WHERE 	" . $this->auditFilter . $tempSql . $tempSql2 . "
								 ) a
						where rownum <= '" . ($this->getStart() + $this->getLimit()) . "' )
						where r >=  '" . ($this->getStart() + 1) . "'";
            } else if ($this->getVendor() == self::DB2) {
                /*
                 * Old Version db2.same as oracle and microsoft sql server
                 * SELECT * FROM (
                  SELECT
                  ROW_NUMBER() OVER (ORDER BY ID_USER ASC) AS ROWNUM,
                  ID_EMPLOYEE, FIRSTNAME, LASTNAME
                  FROM EMPLOYEE
                  WHERE FIRSTNAME LIKE 'DEL%'
                  )  AS A WHERE A.rownum
                  BETWEEN 1 AND 25 */

                $sql .= " LIMIT  " . $this->getStart() . " AND " . $this->getLimit() . " ";
            } else if ($this->getVendor() == self::POSTGRESS) {
                $sql .= " LIMIT  " . $this->getStart() . " OFFSET " . $this->getLimit() . " ";
            } else {
                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                exit();
            }
        }

        /*
         *  Only Execute One Query
         */
        if (!($this->model->getReligionId(0, 'single'))) {
            $this->q->read($sql);
            if ($this->q->execute == 'fail') {
                echo json_encode(array("success" => false, "message" => $this->q->responce));
                exit();
            }
        }
        $items = array();
        while (($row = $this->q->fetchAssoc()) == TRUE) {
            $items [] = $row;
        }
        if ($this->model->getReligionId(0, 'single')) {
            $end = microtime(true);
			$time = $end - $start;
        	$json_encode = json_encode(
            	array(	'success' =>true, 
            			'total' => $total, 
            			'message' => 'Data Loaded', 
            			'time' => $time, 
            			'firstRecord' => $this->recordSet->firstRecord('value'), 
            			'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getReligionId(0, 'single')), 
            			'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getReligionId(0, 'single')), 
            			'lastRecord' => $this->recordSet->lastRecord('value'), 
            			'data' => $items));
            $json_encode = str_replace("[", "", $json_encode);
            $json_encode = str_replace("]", "", $json_encode);
            echo $json_encode;
        } else {
            if (count($items) == 0) {
                $items = '';
            }
            $end = microtime(true);
			$time = $end - $start;
            echo json_encode(array(
            	'success' => true, 
            	'total' => $total, 
            	'message' => 'data loaded', 
            	'time' => $time, 
            	'firstRecord' => $this->recordSet->firstRecord('value'), 
            	'previousRecord' => $this->recordSet->previousRecord('value', $this->model->getReligionId(0, 'single')), 
            	'nextRecord' => $this->recordSet->nextRecord('value', $this->model->getReligionId(0, 'single')), 
            	'lastRecord' => $this->recordSet->lastRecord('value'), 
            	'data' => $items));
            exit();
        }
    }

    /* (non-PHPdoc)
     * @see config::update()
     */

    function update() {
        header('Content-Type:application/json; charset=utf-8');
        $start = microtime(true);
        
        if ($this->getVendor() == self::MYSQL) {
            $sql = "SET NAMES \"utf8\"";
            $this->q->fast($sql);
            if ($this->q->execute == 'fail') {
                echo json_encode(array("success" => false, "message" => $this->q->responce));
                exit();
            }
        }
        $this->q->start();
        $this->model->update();
        // before updating check the id exist or not . if exist continue to update else warning the user
        if ($this->getVendor() == self::MYSQL) {
            $sql = "
			SELECT	`" . $this->model->getPrimaryKeyName() . "`
			FROM 	`" . $this->model->getTableName() . "`
			WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getReligionId(0, 'single') . "' ";
        } else if ($this->getVendor() == self::MSSQL) {
            $sql = "
			SELECT	[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[" . $this->model->getTableName() . "]
			WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getReligionId(0, 'single') . "' ";
        } else if ($this->getVendor() == self::ORACLE) {
            $sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getReligionId(0, 'single') . "' ";
        } else if ($this->getVendor() == self::DB2) {
            $sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getReligionId(0, 'single') . "' ";
        } else if ($this->getVendor() == self::POSTGRESS) {
            $sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getReligionId(0, 'single') . "' ";
        } else {
            echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
            exit();
        }
        $result = $this->q->fast($sql);
        $total = $this->q->numberRows($result, $sql);
        if ($total == 0) {
            echo json_encode(array("success" => false, "message" => 'Cannot find the record'));
            exit();
        } else {
            if ($this->getVendor() == self::MYSQL) {
                $sql = "
				UPDATE		`religion`
				SET 		`religionDesc`		=	'" . $this->model->getReligionDesc() . "',
							`isDefault`			=	'" . $this->model->getIsDefault(0, 'single') . "',
							`isNew`				=	'" . $this->model->getIsNew(0, 'single') . "',
							`isDraft`			=	'" . $this->model->getIsDraft(0, 'single') . "',
							`isUpdate`			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							`isDelete`			=	'" . $this->model->getIsDelete(0, 'single') . "',
							`isActive`			=	'" . $this->model->getIsActive(0, 'single') . "',
							`isApproved`		=	'" . $this->model->getIsApproved(0, 'single') . "',
							`isReview`			=	'" . $this->model->getIsReview(0, 'single') . "',
							`isPost`			=	'" . $this->model->getIsPost(0, 'single') . "',
							`executeBy`			=	'" . $this->model->getExecuteBy() . "',
							`executeTime`		=	" . $this->model->getExecuteTime() . "
				WHERE 		`religionId`		=	'" . $this->model->getReligionId(0, 'single') . "'";
            } else if ($this->getVendor() == self::MSSQL) {
                $sql = "
				UPDATE 		[religion]
				SET 		[religionDesc]		=	'" . $this->model->getReligionDesc() . "',
							[isDefault]			=	'" . $this->model->getIsDefault(0, 'single') . "',
							[isNew]				=	'" . $this->model->getIsNew(0, 'single') . "',
							[isDraft]			=	'" . $this->model->getIsDraft(0, 'single') . "',
							[isUpdate]			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							[isDelete]			=	'" . $this->model->getIsDelete(0, 'single') . "',
							[isActive]			=	'" . $this->model->getIsActive(0, 'single') . "',
							[isApproved]		=	'" . $this->model->getIsApproved(0, 'single') . "',
							[isReview]			=	'" . $this->model->getIsReview(0, 'single') . "',
							[isPost]			=	'" . $this->model->getIsPost(0, 'single') . "',
							[executeBy]			=	'" . $this->model->getExecuteBy() . "',
							[executeTime]		=	" . $this->model->getExecuteTime() . "
			WHERE 		[religionId]			=	'" . $this->model->getReligionId(0, 'single') . "'";
            } else if ($this->getVendor() == self::ORACLE) {
                $sql = "
				UPDATE		RELIGION
				SET 		RELIGIONDESC	=	'" . $this->model->getReligionDesc() . "',
							ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISNEW				=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE			=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISACTIVE			=	'" . $this->model->getIsActive(0, 'single') . "',
							ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW			=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST				=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME	=	" . $this->model->getExecuteTime() . "
			WHERE 		RELIGIONID		=	'" . $this->model->getReligionId(0, 'single') . "'";
            } else if ($this->getVendor() == self::DB2) {
                $sql = "
			UPDATE	RELIGION
			SET 			RELIGIONDESC	=	'" . $this->model->getReligionDesc() . "',
							ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISNEW				=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE			=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISACTIVE			=	'" . $this->model->getIsActive(0, 'single') . "',
							ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW			=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST				=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME	=	" . $this->model->getExecuteTime() . "
			WHERE 		RELIGIONID		=	'" . $this->model->getReligionId(0, 'single') . "'";
            } else if ($this->getVendor() == self::POSTGRESS) {
                $sql = "
				UPDATE		RELIGION
				SET 		RELIGIONDESC		=	'" . $this->model->getReligionDesc() . "',
							ISDEFAULT			=	'" . $this->model->getIsDefault(0, 'single') . "',
							ISNEW				=	'" . $this->model->getIsNew(0, 'single') . "',
							ISDRAFT				=	'" . $this->model->getIsDraft(0, 'single') . "',
							ISUPDATE			=	'" . $this->model->getIsUpdate(0, 'single') . "',
							ISDELETE			=	'" . $this->model->getIsDelete(0, 'single') . "',
							ISACTIVE			=	'" . $this->model->getIsActive(0, 'single') . "',
							ISAPPROVED			=	'" . $this->model->getIsApproved(0, 'single') . "',
							ISREVIEW			=	'" . $this->model->getIsReview(0, 'single') . "',
							ISPOST				=	'" . $this->model->getIsPost(0, 'single') . "',
							EXECUTEBY			=	'" . $this->model->getExecuteBy() . "',
							EXECUTETIME			=	" . $this->model->getExecuteTime() . "
				WHERE 		RELIGIONID			=	'" . $this->model->getReligionId(0, 'single') . "'";
            } else {
                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                exit();
            }
            /*
             *  require three variable below to track  table audit
             */
            $this->q->tableName = $this->model->getTableName();
            $this->q->primaryKeyName = $this->model->getPrimaryKeyName();
            $this->q->primaryKeyValue = $this->model->getReligionId(0, 'single');
            $this->q->audit = $this->audit;
            $this->q->update($sql);
            if ($this->q->execute == 'fail') {
                echo json_encode(array("success" => false, "message" => $this->q->responce));
                exit();
            }
        }
        $this->q->commit();
        $end = microtime(true);
		$time = $end - $start;
        echo json_encode(
        	array(	"success" => true, 
        			"message" => "Updated",
        			"time"=>$time));
        exit();
    }

    /* (non-PHPdoc)
     * @see config::delete()
     */

    function delete() {
        header('Content-Type:application/json; charset=utf-8');
        $start = microtime(true);
        if ($this->getVendor() == self::MYSQL) {
            $sql = "SET NAMES \"utf8\"";
            $this->q->fast($sql);
        }
        $this->q->start();
        $this->model->delete();
        // before updating check the id exist or not . if exist continue to update else warning the user
        if ($this->getVendor() == self::MYSQL) {
            $sql = "
			SELECT	`" . $this->model->getPrimaryKeyName() . "`
			FROM 	`" . $this->model->getTableName() . "`
			WHERE  	`" . $this->model->getPrimaryKeyName() . "` = '" . $this->model->getReligionId(0, 'single') . "' ";
        } else if ($this->getVendor() == self::MSSQL) {
            $sql = "
			SELECT	[" . $this->model->getPrimaryKeyName() . "]
			FROM 	[" . $this->model->getTableName() . "]
			WHERE  	[" . $this->model->getPrimaryKeyName() . "] = '" . $this->model->getReligionId(0, 'single') . "' ";
        } else if ($this->getVendor() == self::ORACLE) {
            $sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getReligionId(0, 'single') . "' ";
        } else if ($this->getVendor() == self::DB2) {
            $sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getReligionId(0, 'single') . "' ";
        } else if ($this->getVendor() == self::POSTGRESS) {
            $sql = "
			SELECT	" . strtoupper($this->model->getPrimaryKeyName()) . "
			FROM 	" . strtoupper($this->model->getTableName()) . "
			WHERE  	" . strtoupper($this->model->getPrimaryKeyName()) . " = '" . $this->model->getReligionId(0, 'single') . "' ";
        } else {
            echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
            exit();
        }
        $result = $this->q->fast($sql);
        $total = $this->q->numberRows($result, $sql);
        if ($total == 0) {
            echo json_encode(array("success" => false, "message" => 'Cannot find the record'));
            exit();
        } else {
            if ($this->getVendor() == self::MYSQL) {
                $sql = "
				UPDATE 	`religion`
				SET 	`isDefault`			=	'" . $this->model->getIsDefault(0, 'single') . "',
						`isNew`				=	'" . $this->model->getIsNew(0, 'single') . "',
						`isDraft`			=	'" . $this->model->getIsDraft(0, 'single') . "',
						`isUpdate`			=	'" . $this->model->getIsUpdate(0, 'single') . "',
						`isDelete`			=	'" . $this->model->getIsDelete(0, 'single') . "',
						`isActive`			=	'" . $this->model->getIsActive(0, 'single') . "',
						`isApproved`		=	'" . $this->model->getIsApproved(0, 'single') . "',
						`isReview`			=	'" . $this->model->getIsReview(0, 'single') . "',
						`isPost`			=	'" . $this->model->getIsPost(0, 'single') . "',
						`executeBy`			=	'" . $this->model->getExecuteBy() . "',
						`executeTime`		=	" . $this->model->getExecuteTime() . "
				WHERE 	`religionId`		=	'" . $this->model->getReligionId(0, 'single') . "'";
            } else if ($this->getVendor() == self::MSSQL) {
                $sql = "
				UPDATE 	[religion]
				SET 	[isDefault]			=	'" . $this->model->getIsDefault(0, 'single') . "',
						[isNew]				=	'" . $this->model->getIsNew(0, 'single') . "',
						[isDraft]			=	'" . $this->model->getIsDraft(0, 'single') . "',
						[isUpdate]			=	'" . $this->model->getIsUpdate(0, 'single') . "',
						[isDelete]			=	'" . $this->model->getIsDelete(0, 'single') . "',
						[isActive]			=	'" . $this->model->getIsActive(0, 'single') . "',
						[isApproved]		=	'" . $this->model->getIsApproved(0, 'single') . "',
						[isReview]			=	'" . $this->model->getIsReview(0, 'single') . "',
						[isPost]			=	'" . $this->model->getIsPost(0, 'single') . "',
						[executeBy]			=	'" . $this->model->getExecuteBy() . "',
						[executeTime]		=	" . $this->model->getExecuteTime() . "
				WHERE 	[religionId]		=	'" . $this->model->getReligionId(0, 'single') . "'";
            } else if ($this->getVendor() == self::ORACLE) {
                $sql = "
				UPDATE 	RELIGION
				SET 	ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
						ISNEW			=	'" . $this->model->getIsNew(0, 'single') . "',
						ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
						ISUPDATE		=	'" . $this->model->getIsUpdate(0, 'single') . "',
						ISDELETE		=	'" . $this->model->getIsDelete(0, 'single') . "',
						ISACTIVE		=	'" . $this->model->getIsActive(0, 'single') . "',
						ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
						ISREVIEW		=	'" . $this->model->getIsReview(0, 'single') . "',
						ISPOST			=	'" . $this->model->getIsPost(0, 'single') . "',
						EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
						EXECUTETIME		=	" . $this->model->getExecuteTime() . "
				WHERE 	RELIGIONID		=	'" . $this->model->getReligionId(0, 'single') . "'";
            } else if ($this->getVendor() == self::DB2) {
                $sql = "
				UPDATE 	RELIGION
				SET 	ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
						ISNEW			=	'" . $this->model->getIsNew(0, 'single') . "',
						ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
						ISUPDATE		=	'" . $this->model->getIsUpdate(0, 'single') . "',
						ISDELETE		=	'" . $this->model->getIsDelete(0, 'single') . "',
						ISACTIVE		=	'" . $this->model->getIsActive(0, 'single') . "',
						ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
						ISREVIEW		=	'" . $this->model->getIsReview(0, 'single') . "',
						ISPOST			=	'" . $this->model->getIsPost(0, 'single') . "',
						EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
						EXECUTETIME		=	" . $this->model->getExecuteTime() . "
				WHERE 	RELIGIONID		=	'" . $this->model->getReligionId(0, 'single') . "'";
            } else if ($this->getVendor() == self::POSTGRESS) {
                $sql = "
				UPDATE 	RELIGION
				SET 	ISDEFAULT		=	'" . $this->model->getIsDefault(0, 'single') . "',
						ISNEW			=	'" . $this->model->getIsNew(0, 'single') . "',
						ISDRAFT			=	'" . $this->model->getIsDraft(0, 'single') . "',
						ISUPDATE		=	'" . $this->model->getIsUpdate(0, 'single') . "',
						ISDELETE		=	'" . $this->model->getIsDelete(0, 'single') . "',
						ISACTIVE		=	'" . $this->model->getIsActive(0, 'single') . "',
						ISAPPROVED		=	'" . $this->model->getIsApproved(0, 'single') . "',
						ISREVIEW		=	'" . $this->model->getIsReview(0, 'single') . "',
						ISPOST			=	'" . $this->model->getIsPost(0, 'single') . "',
						EXECUTEBY		=	'" . $this->model->getExecuteBy() . "',
						EXECUTETIME		=	" . $this->model->getExecuteTime() . "
				WHERE 	RELIGIONID		=	'" . $this->model->getReligionId(0, 'single') . "'";
            } else {
                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                exit();
            }
           
            $this->q->update($sql);
            if ($this->q->execute == 'fail') {
                echo json_encode(array("success" => false, "message" => $this->q->responce));
                exit();
            }
        }
        $this->q->commit();
        $end = microtime(true);
		$time = $end - $start;
        echo json_encode(
        	array(	"success" => true, 
        			"message" => "Deleted",
        			"time"=>$time));
        exit();
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
            echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
            exit();
        }
        /**
         * System Validation Checking
         * @var $access
         */
        $access = array("isDefault", "isNew", "isDraft", "isUpdate", "isDelete", "isActive", "isApproved", "isReview", "isPost");
        foreach ($access as $systemCheck) {

            switch ($systemCheck) {
                case 'isDefault' :
                    for ($i = 0; $i < $loop; $i++) {
                        if (strlen($this->model->getIsDefault($i, 'array')) > 0) {
                            if ($this->getVendor() == self::MYSQL) {
                                $sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
                            } else if ($this->getVendor() == self::MSSQL) {
                                $sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
                            } else if ($this->getVendor() == self::ORACLE) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::DB2) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::POSTGRESS) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else {
                                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                                exit();
                            }
                            $sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsDefault($i, 'array') . "'";
                            $sqlLooping .= " END,";
                        }
                    }
                    break;
                case 'isNew' :
                    for ($i = 0; $i < $loop; $i++) {
                        if (strlen($this->model->getIsNew($i, 'array')) > 0) {
                            if ($this->getVendor() == self::MYSQL) {
                                $sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
                            } else if ($this->getVendor() == self::MSSQL) {
                                $sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
                            } else if ($this->getVendor() == self::ORACLE) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::DB2) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::POSTGRESS) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else {
                                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                                exit();
                            }
                            $sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsNew($i, 'array') . "'";
                            $sqlLooping .= " END,";
                        }
                    }
                    break;
                case 'isDraft' :
                    for ($i = 0; $i < $loop; $i++) {
                        if (strlen($this->model->getIsDraft($i, 'array')) > 0) {
                            if ($this->getVendor() == self::MYSQL) {
                                $sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
                            } else if ($this->getVendor() == self::MSSQL) {
                                $sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
                            } else if ($this->getVendor() == self::ORACLE) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::DB2) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::POSTGRESS) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else {
                                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                                exit();
                            }
                            $sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsDraft($i, 'array') . "'";
                            $sqlLooping .= " END,";
                        }
                    }
                    break;
                case 'isUpdate' :
                    for ($i = 0; $i < $loop; $i++) {
                        if (strlen($this->model->getIsUpdate($i, 'array')) > 0) {
                            if ($this->getVendor() == self::MYSQL) {
                                $sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
                            } else if ($this->getVendor() == self::MSSQL) {
                                $sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
                            } else if ($this->getVendor() == self::ORACLE) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::DB2) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::POSTGRESS) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else {
                                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                                exit();
                            }
                            $sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsUpdate($i, 'array') . "'";
                            $sqlLooping .= " END,";
                        }
                    }
                    break;
                case 'isDelete' :
                    for ($i = 0; $i < $loop; $i++) {
                        if (strlen($this->model->getIsDelete($i, 'array')) > 0) {
                            if ($this->getVendor() == self::MYSQL) {
                                $sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
                            } else if ($this->getVendor() == self::MSSQL) {
                                $sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
                            } else if ($this->getVendor() == self::ORACLE) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::DB2) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::POSTGRESS) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else {
                                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                                exit();
                            }
                            $sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsDelete($i, 'array') . "'";
                            $sqlLooping .= " END,";
                        }
                    }
                    break;
                case 'isActive' :
                    for ($i = 0; $i < $loop; $i++) {
                        if (strlen($this->model->getIsActive($i, 'array')) > 0) {
                            if ($this->getVendor() == self::MYSQL) {
                                $sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
                            } else if ($this->getVendor() == self::MSSQL) {
                                $sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
                            } else if ($this->getVendor() == self::ORACLE) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::DB2) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::POSTGRESS) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else {
                                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                                exit();
                            }
                            $sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsActive($i, 'array') . "'";
                            $sqlLooping .= " END,";
                        }
                    }
                    break;
                case 'isApproved' :
                    for ($i = 0; $i < $loop; $i++) {
                        if (strlen($this->model->getIsApproved($i, 'array')) > 0) {
                            if ($this->getVendor() == self::MYSQL) {
                                $sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
                            } else if ($this->getVendor() == self::MSSQL) {
                                $sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
                            } else if ($this->getVendor() == self::ORACLE) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::DB2) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::POSTGRESS) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else {
                                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                                exit();
                            }
                            $sqlLooping .= "
							WHEN '" . $this->model->getReligionId($i, 'array') . "'
							THEN '" . $this->model->getIsApproved($i, 'array') . "'";
                            $sqlLooping .= " END,";
                        }
                    }
                    break;
                case 'isReview' :
                    for ($i = 0; $i < $loop; $i++) {
                        if (strlen($this->model->getIsReview($i, 'array')) > 0) {
                            if ($this->getVendor() == self::MYSQL) {
                                $sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
                            } else if ($this->getVendor() == self::MSSQL) {
                                $sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
                            } else if ($this->getVendor() == self::ORACLE) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::DB2) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::POSTGRESS) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else {
                                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                                exit();
                            }
                            $sqlLooping .= "
                            WHEN '" . $this->model->getReligionId($i, 'array') . "'
                            THEN '" . $this->model->getIsReview($i, 'array') . "'";
                            $sqlLooping .= " END,";
                        }
                    }
                    break;
                case 'isPost' :
                    for ($i = 0; $i < $loop; $i++) {
                        if (strlen($this->model->getIsPost($i, 'array')) > 0) {
                            if ($this->getVendor() == self::MYSQL) {
                                $sqlLooping .= " `" . $systemCheck . "` = CASE `" . $this->model->getPrimaryKeyName() . "`";
                            } else if ($this->getVendor() == self::MSSQL) {
                                $sqlLooping .= "  [" . $systemCheck . "] = CASE [" . $this->model->getPrimaryKeyName() . "]";
                            } else if ($this->getVendor() == self::ORACLE) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::DB2) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else if ($this->getVendor() == self::POSTGRESS) {
                                $sqlLooping .= "	" . strtoupper($systemCheck) . " = CASE " . strtoupper($this->model->getPrimaryKeyName()) . " ";
                            } else {
                                echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
                                exit();
                            }
                            $sqlLooping .= "
                                WHEN '" . $this->model->getReligionId($i, 'array') . "'
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
            echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
            exit();
        }
        $this->q->update($sql);
        if ($this->q->execute == 'fail') {
            echo json_encode(array("success" => false, "message" => $this->q->responce));
            exit();
        }
        $this->q->commit();
        if ($this->getIsAdmin()) {
            $message = "Updated";
        } else {
            $message = "deleted";
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

    /**
     * To check if a key duplicate or not
     */
    function duplicate() {
        header('Content-Type:application/json; charset=utf-8');
        $start = microtime(true);
        if ($this->getVendor() == self::MYSQL) {
            
            $sql = "SET NAMES \"utf8\"";
            $this->q->fast($sql);
        }
        if ($this->getVendor() == self::MYSQL) {
            $sql = "
			SELECT	`religionDesc`
			FROM 	`religion`
			WHERE 	`religionDesc` 	= 	'" . $this->model->getReligionDesc() . "'
			AND		`isActive`		=	1";
        } else if ($this->getVendor() == self::MSSQL) {
            $sql = "
			SELECT	[religionDesc]
			FROM 	[religion]
			WHERE 	[religionDesc] 	= 	'" . $this->model->getReligionDesc() . "'
			AND		[isActive]		=	1";
        } else if ($this->getVendor() == self::ORACLE) {
            $sql = "
			SELECT	RELIGIONDESC
			FROM 	RELIGION
			WHERE 	RELIGIONDESC 	= 	'" . $this->model->getReligionDesc() . "'
			AND		ISACTIVE		=	1";
        } else if ($this->getVendor() == self::DB2) {
            $sql = "
			SELECT	RELIGIONDESC
			FROM 	RELIGION
			WHERE 	RELIGIONDESC 	= 	'" . $this->model->getReligionDesc() . "'
			AND		ISACTIVE		=	1";
        } else if ($this->getVendor() == self::POSTGRESS) {
            $sql = "
			SELECT	RELIGIONDESC
			FROM 	RELIGION
			WHERE 	RELIGIONDESC 	= 	'" . $this->model->getReligionDesc() . "'
			AND		ISACTIVE		=	1";
        } else {
            echo json_encode(array("success" => false, "message" => "Unsupported Database Vendor"));
            exit();
        }
        $this->q->read($sql);
        $total = 0;
        $total = $this->q->numberRows();
        if ($this->q->execute == 'fail') {
            echo json_encode(array("success" => false, "message" => $this->q->responce));
            exit();
        }
        if ($total > 0) {
            $row = $this->q->fetchArray();
            $end = microtime(true);
			$time = $end - $start;
            echo json_encode(
            		array(	"success" => true, 
            				"total" => $total, 
            				"message" => "Duplicate Record", 
            				"religionDesc" => $row ['religionDesc'],
            				"time"=>$time));
            exit();
        } else {
        	$end = microtime(true);
			$time = $end - $start;
            echo json_encode(
            	array(	"success" => true, 
            			"total" => $total, 
            			"message" => "Duplicate Non",
            			"time"=>$time));
            exit();
        }
    }

    function firstRecord($value) {
        $this->recordSet->firstRecord($value);
    }

    function nextRecord($value, $primaryKeyValue) {
        $this->recordSet->nextRecord($value, $primaryKeyValue);
    }

    function previousRecord($value, $primaryKeyValue) {
        $this->recordSet->previousRecord($value, $primaryKeyValue);
    }

    function lastRecord($value) {
        $this->recordSet->lastRecord($value);
    }

    /* (non-PHPdoc)
     * @see config::excel()
     */

    function excel() {
        header('Content-Type:application/json; charset=utf-8');
        $start = microtime(true);
        if ($this->getVendor() == self::MYSQL) {
            $sql = "SET NAMES \"utf8\"";
            $this->q->fast($sql);
        }
        if ($_SESSION ['start'] == 0) {
            $sql = str_replace("LIMIT", "", $_SESSION ['sql']);
            $sql = str_replace($_SESSION ['start'] . "," . $_SESSION ['limit'], "", $sql);
        } else {
            $sql = $_SESSION ['sql'];
        }
        $this->q->read($sql);
        if ($this->q->execute == 'fail') {
            echo json_encode(array("success" => false, "message" => $this->q->responce));
            exit();
        }
        $this->excel->setActiveSheetIndex(0);
        // check file exist or not and return response
        $styleThinBlackBorderOutline = array('borders' => array('inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '000000')), 'outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '000000'))));
        // header all using  3 line  starting b
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
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
        $i = 0;
        while (($row = $this->q->fetchAssoc()) == TRUE) {
            //	echo print_r($row);
            $this->excel->getActiveSheet()->setCellValue('B' . $loopRow, ++$i);
            $this->excel->getActiveSheet()->setCellValue('C' . $loopRow, 'a' . $row ['religionDesc']);
            $loopRow++;
            $lastRow = 'C' . $loopRow;
        }
        $from = 'B2';
        $to = $lastRow;
        $formula = $from . ":" . $to;
        $this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $filename = "religion" . rand(0, 10000000) . ".xlsx";
        $path = $_SERVER ['DOCUMENT_ROOT'] . "/" . $this->application . "/basic/document/excel/" . $filename;
        $this->documentTrail->create_trail($this->leafId, $path, $filename);
        $objWriter->save($path);
        $file = fopen($path, 'r');
        if ($file) {
            echo json_encode(
            	array(	"success" =>true, 
            			"message" => "File generated", 
            			"filename" => $filename,
            			"time"=>$time));
            exit();
        } else {
            echo json_encode(
            		array(	"success" => false, 
            				"message" => "File not generated",
            				"time"=>$time));
            exit();
        }
    }

}

$religionObject = new ReligionClass ();

/**
 * crud -create,read,update,delete
 * */
if (isset($_POST ['method'])) {
    /*
     *  Initilize Value before load in the loader
     */
    if (isset($_POST ['leafId'])) {
        $religionObject->setLeafId($_POST ['leafId']);
    }
    /*
     * Admin Only
     */
    if (isset($_POST ['isAdmin'])) {
        $religionObject->setIsAdmin($_POST ['isAdmin']);
    }
    /*
     *  Paging
     */
    if (isset($_POST ['start'])) {
        $religionObject->setStart($_POST ['start']);
    }
    if (isset($_POST ['perPage'])) {
        $religionObject->setLimit($_POST ['perPage']);
    }
    /*
     *  Filtering
     */
    if (isset($_POST ['query'])) {
        $religionObject->setFieldQuery($_POST ['query']);
    }
    if (isset($_POST ['filter'])) {
        $religionObject->setGridQuery($_POST ['filter']);
    }
    /*
     * Ordering
     */
    if (isset($_POST ['order'])) {
        $religionObject->setOrder($_POST ['order']);
    }
    if (isset($_POST ['sortField'])) {
        $religionObject->setSortField($_POST ['sortField']);
    }
    /*
     *  Load the dynamic value
     */
    $religionObject->execute();
    /*
     *  Crud Operation (Create Read Update Delete/Destory)
     */
    if ($_POST ['method'] == 'create') {
        $religionObject->create();
    }
    if ($_POST ['method'] == 'save') {
        $religionObject->update();
    }
    if ($_POST ['method'] == 'read') {
        $religionObject->read();
    }
    if ($_POST ['method'] == 'delete') {
        $religionObject->delete();
    }
}
if (isset($_GET ['method'])) {
    /*
     *  Initilize Value before load in the loader
     */
    if (isset($_GET ['leafId'])) {
        $religionObject->setLeafId($_GET ['leafId']);
    }
    /*
     * Admin Only
     */
    if (isset($_GET ['isAdmin'])) {
        $religionObject->setIsAdmin($_GET ['isAdmin']);
    }
    /*
     *  Load the dynamic value
     */
    $religionObject->execute();
    if (isset($_GET ['field'])) {
        if ($_GET ['field'] == 'staffId') {
            $religionObject->staff();
        }
    }
    /*
     * Update Status of The Table. Admin Level Only
     */
    if ($_GET ['method'] == 'updateStatus') {
        $religionObject->updateStatus();
    }
    /*
     *  Checking Any Duplication  Key
     */
    if (isset($_GET ['religionDesc'])) {
        if (strlen($_GET ['religionDesc']) > 0) {
            $religionObject->duplicate();
        }
    }
    /*
     * Button Navigation
     */
    if ($_GET ['method'] == 'dataNavigationRequest') {
        if ($_GET ['dataNavigation'] == 'firstRecord') {
            $religionObject->firstRecord('json');
        }
        if ($_GET ['dataNavigation'] == 'previousRecord') {
            $religionObject->previousRecord('json', 0);
        }
        if ($_GET ['dataNavigation'] == 'nextRecord') {
            $religionObject->nextRecord('json', 0);
        }
        if ($_GET ['dataNavigation'] == 'lastRecord') {
            $religionObject->lastRecord('json');
        }
    }
    /*
     * Excel Reporting
     */
    if (isset($_GET ['mode'])) {
        if ($_GET ['mode'] == 'excel') {
            $religionObject->excel();
        }
    }
}
?>
