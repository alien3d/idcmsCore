<?php
session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/moduleModel.php");
/**
 * this is main setting files
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package module
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class moduleClass extends configClass
{
	/*
	 * Connection to the damodulease
	 * @var string $excel
	 */
	public $q;
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
	 * department Model
	 * @var string $departmentModel
	 */
	public $model;
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
	 * Duplicate Testing either the key of modulele same or have been created.
	 * @var boolean $duplicateTest;
	 */
	public $duplicateTest;
	/**
	 * Common class function for security menu
	 * @var  string $security
	 */
	private $security;


	/**
	 * Class Loader
	 */
	function execute()
	{
		parent::__construct();
		$this->q              = new vendor();
		$this->q->vendor      = $this->getVendor();
		$this->q->leafId      = $this->getLeafId();
		$this->q->staffId     = $this->getStaffId();
		$this->q->fieldQuery     = $this->getFieldQuery();
		$this->q->gridQuery = $this->getGridQuery();
		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDamodulease(), $this->getPassword());
		$this->excel             = new PHPExcel();
		$this->audit             = 0;
		$this->log               = 1;
		$this->q->log            = $this->log;
		$this->defaultLanguageId = 21;
		$this->security          = new security();
		$this->security->setVendor($this->getVendor());
		$this->security->setLeafId($this->getLeafId());
		$this->security->execute();
		$this->model         = new moduleModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();
		$this->documentTrail = new documentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->execute();
	}
	function create()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES utf8";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->create();
		/**
		 * Example  using Constant .This much cleaner approch  to Sql Statement
		 */

		if ($this->getVendor() == self::mysql) {
			$sql = "
			INSERT INTO `module`
					(
						`iconId`,							`moduleSequence`,
						`moduleCode`,							`moduleNote`,
						`isDefault`,							`isNew`,
						`isDraft`,							`isUpdate`,
						`isDelete`,							`isActive`,
						`isApproved`,						`By`,
						`Time`
					)
			VALUES
					(
						\"" . $this->model->getIconId() . "\",					\"" . $this->model->getmoduleSequence() . "\",
						\"" . $this->model->getmoduleCode() . "\",					\"" . $this->model->getmoduleNote() . "\",
						\"".$this->model->getIsDefault('','single')."\",		\"" . $this->model->getIsNew('','single') . "\",
						\"" . $this->model->getIsDraft('','single') . "\",		\"" . $this->model->getIsUpdate('','single') . "\",
						\"" . $this->model->getIsDelete('','single') . "\",		\"" . $this->model->getIsActive('','single') . "\",
						\"" . $this->model->getIsApproved('','single') . "\",	\"" . $this->model->getBy() . "\",
						" . $this->model->getTime() . "
					);";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			INSERT INTO [module]
					(
						[iconId],							[moduleSequence],
						[moduleCode],							[moduleNote],
						[isDefault],						[isNew],
						[isDraft],							[isUpdate],
						[isDelete],							[isActive],
						[isApproved],						[By],
						[Time]
					)
			VALUES
					(
						\"" . $this->model->getIconId() . "\",					\"" . $this->model->getmoduleSequence() . "\",
						\"" . $this->model->getmoduleCode() . "\",					\"" . $this->model->getmoduleNote() . "\",
						\"".$this->model->getIsDefault('','single')."\",		\"" . $this->model->getIsNew('','single') . "\",
						\"" . $this->model->getIsDraft('','single') . "\",		\"" . $this->model->getIsUpdate('','single') . "\",
						\"" . $this->model->getIsDelete('','single') . "\",		\"" . $this->model->getIsActive('','single') . "\",
						\"" . $this->model->getIsApproved('','single') . "\",	\"" . $this->model->getBy() . "\",
						" . $this->model->getTime() . "
					);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			INSERT INTO \"module\"
					(
						\"iconId\",							\"moduleSequence\",
						\"moduleCode\",						\"moduleNote\",
						\"isDefault\",						\"isNew\",
						\"isDraft\",						\"isUpdate\",
						\"isDelete\",						\"isActive\",
						\"isApproved\",						\"By\",
						\"Time\"
					)
			VALUES
					(
						\"" . $this->model->getIconId() . "\",					\"" . $this->model->getmoduleSequence() . "\",
						\"" . $this->model->getmoduleCode() . "\",					\"" . $this->model->getmoduleNote() . "\",
						\"".$this->model->getIsDefault('','single')."\",		\"" . $this->model->getIsNew('','single') . "\",
						\"" . $this->model->getIsDraft('','single') . "\",		\"" . $this->model->getIsUpdate('','single') . "\",
						\"" . $this->model->getIsDelete('','single') . "\",		\"" . $this->model->getIsActive('','single') . "\",
						\"" . $this->model->getIsApproved('','single') . "\",	\"" . $this->model->getBy() . "\",
						" . $this->model->getTime() . "
					);";
		}
		$this->q->create($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}

		$lastId    = $this->q->lastInsertId();
		//  create a record  in moduleAccess.update no effect
		// loop the group
		if ($this->getVendor() == self::mysql) {
			$sql = "
			SELECT 	*
			FROM 	`group`
			WHERE 	`isActive`	=	1 ";
		} else if ($this->q->vendor == 'microsoft') {
			$sql = "
			SELECT 	*
			FROM 	[group]
			WHERE 	[isActive]	=	1 ";
		} else if ($this->q->vendor == 'oracle') {
			$sql = "
			SELECT 	*
			FROM 	\"group\"
			WHERE 	`\"isActive\"	=	1 ";
		}
		$this->q->read($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => false,
                "message" => $this->q->responce
			));
			exit();
		}
		$data = $this->q->activeRecord();

		foreach ($data as $row) {
			/**
			 *	By Default  No Access
			 **/
			echo		$sqlLooping.="(
							\"" . $lastId . "\",
							 \"" . $row['groupId'] . "\",
							 \"0\"
						),";





		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
				INSERT INTO	`moduleAccess`
						(
							`moduleId`,
							`groupId`,
							`moduleAccessValue`
						) VALUES";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
				INSERT INTO	[moduleAccess]
						(
							[moduleId],
							[groupId],
							[moduleAccessValue]
					) VALUES";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
				INSERT INTO	\"moduleAccess\"
						(
							\"moduleId\",
							\"groupId\",
							\"moduleAccessValue\"
					) VALUES";
		}
		// optimize to 1 Query
		// remove last comma
		$sqlLooping = substr($sqlLooping,0,-1);
		// combine SQL Statement
		$sql.=$sqlLooping;
		$this->q->update($sql);
		if($this->q->execute=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		/**
		 *	 insert default value to detail modulele .English only
		 **/
		if ($this->getVendor() == self::mysql) {
			$sql = "
		 	INSERT INTO `moduleTranslate`
		 		(
				 	`moduleId`,
				 	`languageId`,
					`moduleTranslate`
				) VALUES (
					\"" . $lastId . "\",
					21,
					\"" . $this->model->getmoduleNote() . "\"
				);";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
		 	INSERT INTO  [moduleTranslate]
					(
					 	[moduleId],
						[languageId],
						[moduleTranslate]
					) VALUES (
						\"" . $lastId . "\",
						21,
						\"" .  $this->model->getmoduleNote() . "\"
					);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
		 	INSERT INTO	\"moduleTranslate\"
					(
					 	\"moduleId\",
						\"languageId\",
						\"moduleTranslate\"
					) VALUES (
						\"" . $lastId . "\",
						21,
						\"" .  $this->model->getmoduleNote() . "\"
					);";
		}
		$this->q->create($sql);
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
            "message" => "Insert Sucess",
            "moduleId" => $lastId
		));
		exit();
	}
	/* (non-PHPdoc)
	 * @see class/config::read()
	 */
	function read()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if($this->isAdmin == 0) {
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	`module`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[module].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"module\".\"isActive\"	=	1	";
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
			$sql = "SET NAMES utf8";
			$this->q->fast($sql);
		}
		if ($this->getVendor() == self::mysql) {
			$sql = "
					SELECT	`module`.`moduleId`,
							`module`.`iconId`,
							`module`.`moduleSequence`,
							`module`.`moduleCode`,
							`module`.`moduleNote`,
							`module`.`isDefault`,
							`module`.`isNew`,
							`module`.`isDraft`,
							`module`.`isUpdate`,
							`module`.`isDelete`,
							`module`.`isActive`,
							`module`.`isApproved`,
							`module`.`By`,
							`module`.`Time`,
							`staff`.`staffName`,
							`icon`.`iconName`
 					FROM 	`module`
					JOIN	`staff`
					ON		`module`.`By` = `staff`.`staffId`
					LEFT 	JOIN	`icon`
					USING			(`iconId`)
					WHERE 	".$this->auditFilter;
			if ($this->model->getmoduleId('','single')) {
				$sql .= " AND `".$this->model->getmoduleleName()."`.`".$this->model->getPrimaryKeyName()."`=\"". $this->model->getmoduleId('','single') . "\"";

			}

		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
					SELECT	[module].[moduleId],
							[module].[iconId],
							[module].[moduleSequence],
							[module].[moduleCode],
							[module].[moduleNote],
							[module].[isDefault],
							[module].[isNew],
							[module].[isDraft],
							[module].[isUpdate],
							[module].[isDelete],
							[module].[isActive],
							[module].[isApproved],
							[module].[By],
							[module].[Time],
							[staff].[staffName],
							[icon].[iconName]
					FROM 	[module]
					JOIN	[staff]
					ON		[module].[By] = [staff].[staffId]
					LEFT 	JOIN	`icon`
					ON		[iconId].[iconId] = [module].[iconId]
					WHERE 	[module].[isActive] ='1'	";
			if ($this->model->getmoduleId('','single')) {
				$sql .= " AND [".$this->model->getmoduleleName()."].[".$this->model->getPrimaryKeyName()."]=\"". $this->model->getmoduleId('','single') . "\"";
			}
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
					SELECT	\"module\".\"moduleId\",
							\"module\".\"iconId\",
							\"module\".\"moduleCode\",
							\"module\".\"moduleSequence\",
							\"module\".\"moduleNote\",
							\"module\".\"isDefault\",
							\"module\".\"isNew\",
							\"module\".\"isDraft\",
							\"module\".\"isUpdate\",
							\"module\".\"isDelete\",
							\"module\".\"isActive\",
							\"module\".\"isApproved\",
							\"module\".\"By\",
							\"module\".\"Time\",
							\"staff\".\"staffName\",
							\"icon\".\"iconName\"
					FROM 	\"module\"
					JOIN	\"staff\"
					ON		\"module\".\"By\" = \"staff\".\"staffId\"
					LEFT 	JOIN	\"icon\"
					USING	(\"iconId\")
					WHERE 	\"isActive\"='1'	";
			if ($this->model->getmoduleId('','single')) {
				$sql .= " AND \"".$this->model->getmoduleleName()."\".\"".$this->model->getPrimaryKeyName()."\"=\"". $this->model->getmoduleId('','single') . "\"";
			}
		} else {
			echo json_encode(array(
                "success" => false,
                "message" => "Undefine Damodulease Vendor"
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
            'moduleId'
            );
            /**
             *	filter modulele
             * @variables $moduleleArray
             */
            $moduleleArray  = null;
            $moduleleArray  = array(
            'module'
            );
            if ($this->getFieldQuery()) {
            	if ($this->getVendor() == self::mysql) {
            		$sql .= $this->q->quickSearch($moduleleArray, $filterArray);
            	} else if ($this->getVendor() == self::mssql) {
            		$tempSql = $this->q->quickSearch($moduleleArray, $filterArray);
            		$sql .= $tempSql;
            	} else if ($this->getVendor() == self::oracle) {
            		$tempSql = $this->q->quickSearch($moduleleArray, $filterArray);
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
							WITH [moduleDerived] AS
							(
								SELECT *,
								ROW_NUMBER() OVER (ORDER BY [moduleId]) AS 'RowNumber'
								FROM [module]
								WHERE [isActive] =1   " . $tempSql . $tempSql2 . "
							)
							SELECT		[module].[moduleId],
										[module].[iconId],
										[module].[moduleSequence],
										[module].[moduleCode],
										[module].[moduleNote],
										[module].[isDefault],
										[module].[isNew],
										[module].[isDraft],
										[module].[isUpdate],
										[module].[isDelete],
										[module].[isApproved],
										[module].[By],
										[module].[Time],
										[staff].[staffName]
							FROM 		[moduleDerived]
							WHERE 		[RowNumber]
							BETWEEN	" . $_POST['start'] . "
							AND 			" . ($this->start + $this->limit - 1) . ";";
            		} else if ($this->getVendor() == self::oracle) {
            			/**
            			 *  Oracle using derived modulele also
            			 */
            			$sql = "
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT  \"module\".\"moduleId\",
											\"module\".\"iconId\",
											\"module\".\"moduleSequence\",
											\"module\".\"moduleCode\",
											\"module\".\"moduleNote\",
											\"module\".\"isDefault\",
											\"module\".\"isNew\",
											\"module\".\"isDraft\",
											\"module\".\"isUpdate\",
											\"module\".\"isDelete\",
											\"module\".\"isApproved\",
											\"module\".\"By\",
											\"module\".\"Time\",
											\"staff\".\"staffName\"
									FROM 	\"module\"
									WHERE 	\"module\".\"isActive\"=1  " . $tempSql . $tempSql2 . $orderBy . "
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
            if (!($this->model->getmoduleId('','single'))) {
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
            if ($this->model->getmoduleId('','single')) {
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
	 * @see configClass::update()
	 */
	function update()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES utf8";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->update();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE 	`module`
			SET 	`moduleSequence`		= 	\"" . $this->model->getmoduleSequence() . "\",
					`moduleNote`			=	\"" . $this->model->getmoduleNote() . "\",
					`iconId`			=	\"" . $this->model->getIconId() . "\",
					`isActive`			=	\"" . $this->model->getIsActive('','single') . "\",
					`isNew`				=	\"" . $this->model->getIsNew('','single') . "\",
					`isDraft`			=	\"" . $this->model->getIsDraft('','single') . "\",
					`isUpdate`			=	\"" . $this->model->getIsUpdate('','single') . "\",
					`isDelete`			=	\"" . $this->model->getIsDelete('','single') . "\",
					`isApproved`		=	\"" . $this->model->getIsApproved('','single') . "\",
					`By`				=	\"" . $this->model->getBy() . "\",
					`Time				=	" . $this->model->getTime() . "
			WHERE 	`moduleId`				=	\"" . $this->model->getmoduleId('','single') . "\"";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			UPDATE 	[module]
			SET 	[moduleSequence]		= 	\"" . $this->model->moduleSequence . "\",
					[moduleNote]			=	\"" . $this->model->moduleNote . "\",
					[iconId]			=	\"" . $this->model->iconId . "\",
					[isDefault]			=	\"".$this->model->getIsDefault('','single')."\",
					[isActive]			=	\"".$this->model->getIsActive('','single')."\",
					[isNew]				=	\"".$this->model->getIsNew('','single')."\",
					[isDraft]			=	\"".$this->model->getIsDraft('','single')."\",
					[isUpdate]			=	\"".$this->model->getIsUpdate('','single')."\",
					[isDelete]			=	\"".$this->model->getIsDelete('','single')."\",
					[isApproved]		=	\"".$this->model->getIsApproved('','single')."\",
					[By]				=	\"".$this->model->getBy()."\",
					[Time]				=	".$this->model->getTime()."
			WHERE 	[moduleId]				=	\"" . $this->model->getmoduleId('','single') . "\"";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	\"module\"
			SET 	\"moduleSequence\"		= 	\"" . $this->model->moduleSequence . "\",
					\"moduleNote\"			=	\"" . $this->model->moduleNote . "\",
					\"iconId\"			=	\"" . $this->model->iconId . "\",
					\"isActive\"		=	\"" . $this->model->getIsActive('','single') . "\",
					\"isNew\"			=	\"" . $this->model->getIsNew('','single') . "\",
					\"isDraft\"			=	\"" . $this->model->getIsDraft('','single') . "\",
					\"isUpdate\"		=	\"" . $this->model->getIsUpdate('','single') . "\",
					\"isDelete\"		=	\"" . $this->model->getIsDelete('','single') . "\",
					\"isApproved\"		=	\"" . $this->model->getIsApproved('','single') . "\",
					\"By\"				=	\"" . $this->model->getBy() . "\",
					\"Time\"			=	" . $this->model->getTime() . "
			WHERE 	\"moduleId\"			=	\"" . $this->model->getmoduleId('','single') . "\"";
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
            "success" => success,
            "message" => "update success"
            ));
            exit();
	}
	/* (non-PHPdoc)
	 * @see configClass::delete()
	 */
	function delete()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES utf8";
			$this->q->fast($sql);
		}
		$this->q->start();
		$this->model->delete();
		if ($this->getVendor() == self::mysql) {
			$sql = "
			UPDATE 	`module`
			SET 	`isDefault`		=	\"".$this->model->getIsDefault('','single')."\",
					`isActive`		=	\"".$this->model->getIsActive('','single')."\",
					`isNew`			=	\"".$this->model->getIsNew('','single')."\",
					`isDraft`		=	\"".$this->model->getIsDraft('','single')."\",
					`isUpdate`		=	\"".$this->model->getIsUpdate('','single')."\",
					`isDelete`		=	\"".$this->model->getIsDelete('','single')."\",
					`isApproved`	=	\"".$this->model->getIsApproved('','single')."\",
					`By`			=	\"".$this->model->getBy('','single')."\",
					`Time			=	".$this->model->getTime()."
			WHERE 	`moduleId`		=	\"" . $this->model->moduleId . "\"";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
			UPDATE 	[module]
			SET 	[isDefault]		=	\"".$this->model->getIsDefault('','single')."\",
					[isActive]		=	\"".$this->model->getIsActive('','single')."\",
					[isNew]			=	\"".$this->model->getIsNew('','single')."\",
					[isDraft]		=	\"".$this->model->getIsDraft('','single')."\",
					[isUpdate]		=	\"".$this->model->getIsUpdate('','single')."\",
					[isDelete]		=	\"".$this->model->getIsDelete('','single')."\",
					[isApproved]	=	\"".$this->model->getIsApproved('','single')."\",
					[By]			=	\"".$this->model->getBy('','single')."\",
					[Time]			=	".$this->model->getTime()."
			WHERE 	[moduleId]			=	\"" . $this->model->getmoduleId('','single') . "\"";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
			UPDATE 	\"module\"
			SET 	\"isDefault\"		=	\"".$this->model->getIsDefault('','single')."\",
					\"isActive\"		=	\"".$this->model->getIsActive('','single')."\",
					\"isNew\"			=	\"".$this->model->getIsNew('','single')."\",
					\"isDraft\"			=	\"".$this->model->getIsDraft('','single')."\",
					\"isUpdate\"		=	\"".$this->model->getIsUpdate('','single')."\",
					\"isDelete\"		=	\"".$this->model->getIsDelete('','single')."\",
					\"isApproved\"		=	\"".$this->model->getIsApproved('','single')."\",
					\"By\"				=	\"".$this->model->getBy('','single')."\",
					\"Time\"			=	".$this->model->getTime()."
			WHERE 	\"moduleId\"			=	\"" . $this->model->getmoduleId('','single') . "\"";
		}
		$this->q->update($sql);
		if ($this->q->execute == 'fail') {
			echo json_encode(array(
                "success" => "false",
                "message" => $this->q->responce
			));
			exit();
		}
		$this->q->commit();
		echo json_encode(array(
            "success" => "true",
            "message" => "Delete Succes"
            ));
            exit();
	}


	public function nextSequence()
	{
		$this->security->nextSequence();
	}
	/* (non-PHPdoc)
	 * @see configClass::excel()
	 */
	function excel()
	{
		header('Content-Type', 'application/json; charset=utf-8');
		if ($this->getVendor() == self::mysql) {
			//UTF8
			$sql = "SET NAMES utf8";
			$this->q->fast($sql);
		}
		if ($_SESSION['start'] == 0) {
			$sql = str_replace("LIMIT", "", $_SESSION['sql']);
			$sql = str_replace($_SESSION['start'] . "," . $_SESSION['limit'], "", $sql);
		} else {
			$sql = $_SESSION['sql'];
		}
		$this->q->read($sql);
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
                        $this->excel->getActiveSheet()->setCellValue('B2', $this->title);
                        $this->excel->getActiveSheet()->setCellValue('D2', '');
                        $this->excel->getActiveSheet()->mergeCells('B2:D2');
                        $this->excel->getActiveSheet()->setCellValue('B3', 'No');
                        $this->excel->getActiveSheet()->setCellValue('C3', 'Name');
                        $this->excel->getActiveSheet()->setCellValue('D3', 'Description');
                        $this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
                        $this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                        $this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');
                        //
                        $loopRow = 4;
                        $i       = 0;
                        while ($row = $this->q->fetchAssoc()) {
                        	//	echo print_r($row);
                        	$this->excel->getActiveSheet()->setCellValue('B' . $loopRow, ++$i);
                        	$this->excel->getActiveSheet()->setCellValue('C' . $loopRow, $row['moduleNote']);
                        	$this->excel->getActiveSheet()->setCellValue('D' . $loopRow, $row['moduleDesc']);
                        	$loopRow++;
                        	$lastRow = 'D' . $loopRow;
                        }
                        $from    = 'B2';
                        $to      = $lastRow;
                        $formula = $from . ":" . $to;
                        $this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
                        $filename  = "module" . rand(0, 10000000) . ".xlsx";
                        $path      = $_SERVER['DOCUMENT_ROOT'] . "/" . $this->application . "/basic/document/excel/" . $filename;
                        $objWriter->save($path);
                        $this->audit->createTrail($this->leafId, $path, $filename);
                        $file = fopen($path, 'r');
                        if ($file) {
                        	echo json_encode(array(
                "success" => "true",
                "message" => "File generated"
                ));
                        } else {
                        	echo json_encode(array(
                "success" => "false",
                "message" => "File not generated"
                ));
                        }
	}
}
/**
 *	Declare object
 **/
$moduleObject = new moduleClass();


/**
 *	Form Property .CRUD -create,read,update,delete
 **/
if (isset($_POST['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_POST['leafId'])) {
		$moduleObject->setLeafId($_POST['leafId']);
	}
	if(isset($_POST['isAdmin'])){
		$moduleObject->setIsAdmin($_POST['isAdmin']);
	}

	/*
	 * Filtering
	 */
	if (isset($_POST['query'])) {
		$moduleObject->setFieldQuery($_POST['query']);
	}
	if (isset($_POST['filter'])) {
		$moduleObject->setGridQuery($_POST['filter']);
	}

	/*
	 * Ordering
	 */
	if (isset($_POST['order'])) {
		$moduleObject->setOrder($_POST['order']);
	}
	if (isset($_POST['sortField'])) {
		$moduleObject->setSortField($_POST['sortField']);
	}



	/*
	 *  Load the dynamic value
	 */
	$moduleObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if ($_POST['method'] == 'create') {
		$moduleObject->create();
	}
	if ($_POST['method'] == 'read') {
		$moduleObject->read();
	}
	if ($_POST['method'] == 'save') {
		if ($_POST['grid'] == 'master') {
			$moduleObject->update();
		}

	}
	if ($_POST['method'] == 'delete') {
		$moduleObject->delete();
	}
}
if (isset($_GET['method'])) {
	/*
	 *  Initilize Value before load in the loader
	 */
	/*
	 *  Leaf / Application Identification
	 */
	if (isset($_GET['leafId'])) {
		$moduleObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$moduleObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$moduleObject->execute();
	if (isset($_GET['field'])) {
		if ($_GET['field'] == 'staffId') {
			$moduleObject->staff();
		}
		if ($_GET['field'] == 'sequence') {
			$moduleObject->nextSequence();
		}
	}
	/*
	* Update Status of The modulele. Admin Level Only
	*/
	if($_GET['method']=='updateStatus'){
		$moduleObject->updateStatus();
	}
	/*
	*  Checking Any Duplication  Key
	*/
	if (isset($_GET['moduleCode'])) {
		if (strlen($_GET['moduleCode']) > 0) {
			$moduleObject->duplicate();
		}
	}
	/*
	 *  Excel Reporting
	 */
	if (isset($_GET['mode'])) {
		if ($_GET['mode'] == 'report') {
			$moduleObject->excel();
		}

	}
}

?>
