<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/extLabelModel.php");

/**
 * this extLabel menu creation
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package extLabel
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class extLabelClass extends  configClass {
	/*
	 * Connection to the database
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
	 * extLabel Model
	 * @var string $extLabelModel
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
	 * Duplicate Testing either the key of table same or have been created.
	 * @var boolean $duplicateTest;
	 */
	public $duplicateTest;

	/**
	 * Common class function for security menu
	 * @var  string $security
	 */
	private $security;
	/**
	 * extLabel Translation Identification
	 * @var  numeric $extLabelTranslateId
	 */
	public $extLabelTranslateId;
	/**
	 * Translation update
	 * @var string $extLabelTranslate
	 */
	public $extLabelTranslate;
	/**
	 * Class Loader
	 */
	function execute() {
		parent :: __construct();

		$this->q 					=	new vendor();

		$this->q->vendor			=	$this->getVendor();

		$this->q->leafId			=	$this->getLeafId();

		$this->q->staffId			=	$this->getStaffId();

		$this->q->fieldQuery 		= 	$this->getFieldQuery();

		$this->q->gridQuery			=	$this->getGridQuery();

		$this->q->connect($this->getConnection(), $this->getUsername(), $this->getDatabase(), $this->getPassword());

		$this->excel				=	new  PHPExcel();

		$this->audit 				=	0;

		$this->log					=   0;

		$this->q->log 				= $this->log;

		$this->defaultLanguageId  	= 21;

		$this->security 	= 	new security();
		$this->security->setVendor($this->getVendor());
		$this->security->setLeafId($this->getLeafId());
		$this->security->execute();

		$this->model = new extLabelModel();
		$this->model->setVendor($this->getVendor());
		$this->model->execute();

		$this->documentTrail = new documentTrailClass();
		$this->documentTrail->setVendor($this->getVendor());
		$this->documentTrail->execute();



	}

	/* (non-PHPdoc)
	 * @see config::create()
	*/
	function create() 							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->create();
		if($this->getVendor() == self::mysql) {
			$sql="
			INSERT INTO `extLabel`
					(
						`tabId`,							`iconId`,
						`extLabelSequence`,					`extLabelCode`,
						`extLabelPath`,						`extLabelNote`,
						`isDefault`,						`isNew`,
						`isDraft`,							`isUpdate`,
						`isDelete`,							`isActive`,
						`isApproved`,						`By`,
						`Time`
					)
			VALUES
					(
						\"".$this->model->getTabId()."\",						\"".$this->model->getIconId()."\",
						\"".$this->model->getextLabelSequence()."\", 				\"".$this->model->getextLabelCode()."\",
						\"".$this->model->getextLabelPath()."\"	,				\"".$this->model->getextLabelNote()."\",
						\"".$this->model->getIsDefault('','single')."\",		\"" . $this->model->getIsNew('','single') . "\",
						\"" . $this->model->getIsDraft('','single') . "\",		\"" . $this->model->getIsUpdate('','single') . "\",
						\"" . $this->model->getIsDelete('','single') . "\",		\"" . $this->model->getIsActive('','single') . "\",
						\"" . $this->model->getIsApproved('','single') . "\",	\"" . $this->model->getBy() . "\",
						" . $this->model->getTime() . "


					);";
		}else if ($this->getVendor()==self::mssql) {
			$sql="
			INSERT INTO [extLabel]
					(
						[tabId],							[iconId],
						[extLabelSequence],					[extLabelCode],
						[extLabelPath],						[extLabelNote],
						[isDefault],						[isNew],
						[isDraft],							[isUpdate],
						[isDelete],							[isActive],
						[isApproved],						[By],
						[Time]
				)
			VALUES
				(
						\"".$this->model->getTabId()."\",						\"".$this->model->getIconId()."\",
						\"".$this->model->getextLabelSequence()."\", 				\"".$this->model->getextLabelCode()."\",
						\"".$this->model->getextLabelPath()."\"	,				\"".$this->model->getextLabelNote()."\",
						\"".$this->model->getIsDefault('','single')."\",		\"" . $this->model->getIsNew('','single') . "\",
						\"" . $this->model->getIsDraft('','single') . "\",		\"" . $this->model->getIsUpdate('','single') . "\",
						\"" . $this->model->getIsDelete('','single') . "\",		\"" . $this->model->getIsActive('','single') . "\",
						\"" . $this->model->getIsApproved('','single') . "\",	\"" . $this->model->getBy() . "\",
						" . $this->model->getTime() . "

					);";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
			INSERT INTO 	\"extLabel\"
						(
							\"tabId\",							\"iconId\",
							\"extLabelSequence\",					\"extLabelCode\",
							\"extLabelPath\",						\"extLabelNote\",
							\"isDefault\",						\"isNew\",
							\"isDraft\",						\"isUpdate\",
							\"isDelete\",						\"isActive\",
							\"isApproved\",						\"By\",
							\"Time\"
				VALUES	(
							\"".$this->model->getTabId()."\",						\"".$this->model->getIconId()."\",
							\"".$this->model->getextLabelSequence()."\", 				\"".$this->model->getextLabelCode()."\",
							\"".$this->model->getextLabelPath()."\"	,				\"".$this->model->getextLabelNote()."\",
							\"".$this->model->getIsDefault('','single')."\",		\"" . $this->model->getIsNew('','single') . "\",
							\"" . $this->model->getIsDraft('','single') . "\",		\"" . $this->model->getIsUpdate('','single') . "\",
							\"" . $this->model->getIsDelete('','single') . "\",		\"" . $this->model->getIsActive('','single') . "\",
							\"" . $this->model->getIsApproved('','single') . "\",	\"" . $this->model->getBy() . "\",
							" . $this->model->getTime() . "

					)";
		}
		$this->q->create($sql);
		if($this->q->execute=='fail') {
			echo json_encode(
			array(
					  	"success"	=>	false,

						"message"	=>	$this->q->responce
			));
			exit();
		}

		$lastId    = $this->q->lastInsertId();
		//  create a record  in extLabelAccess.update no effect
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
						INSERT INTO	`extLabelAccess`
								(
									`extLabelId`,
									`groupId`,
									`extLabelAccessValue`
								) VALUES";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
						INSERT INTO	[extLabelAccess]
								(
									[extLabelId],
									[groupId],
									[extLabelAccessValue]
							) VALUES";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
						INSERT INTO	\"extLabelAccess\"
								(
									\"extLabelId\",
									\"groupId\",
									\"extLabelAccessValue\"
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
		*	 insert default value to detail extLabelle .English only
		**/
		if ($this->getVendor() == self::mysql) {
			$sql = "
				 	INSERT INTO `extLabelTranslate`
				 		(
						 	`extLabelId`,
						 	`languageId`,
							`extLabelTranslate`
						) VALUES (
							\"" . $lastId . "\",
							21,
							\"" . $this->model->getextLabelNote() . "\"
						);";
		} else if ($this->getVendor() ==  self::mssql) {
			$sql = "
				 	INSERT INTO  [extLabelTranslate]
							(
							 	[extLabelId],
								[languageId],
								[extLabelTranslate]
							) VALUES (
								\"" . $lastId . "\",
								21,
								\"" .  $this->model->getextLabelNote() . "\"
							);";
		} else if ($this->getVendor() == self::oracle) {
			$sql = "
				 	INSERT INTO	\"extLabelTranslate\"
							(
							 	\"extLabelId\",
								\"languageId\",
								\"extLabelTranslate\"
							) VALUES (
								\"" . $lastId . "\",
								21,
								\"" .  $this->model->getextLabelNote() . "\"
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
		echo json_encode(array("success"=>true,"extLabelId"=>$lastId,"message"=>"Record Created"));
		exit();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	*/
	function read() 							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->isAdmin == 0) {
			if($this->getVendor()==self::mysql) {
				$this->auditFilter = "	`extLabel`.`isActive`		=	1	";
			} else if ($this->q->vendor == self :: mssql) {
				$this->auditFilter = "	[extLabel].[isActive]		=	1	";
			} else if  ($this->q->vendor == self :: oracle) {
				$this->auditFilter = "	\"extLabel\".\"isActive\"	=	1	";
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
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		// everything given flexibility  on todo
		if($this->getVendor() == self::mysql) {
			$sql="
			SELECT 		*
			FROM 		`extLabel`
			JOIN 		`tab`
			ON			`tab`.`tabId` = `extLabel`.`tabId`
			LEFT JOIN	`icon`
			ON			`extLabel`.`iconId`=`icon`.`iconId`
			WHERE		`tab`.`isActive`	=	1
			AND			`extLabel`.`isActive`		=	1";
			if($this->model->getextLabelId('','single')) {
				$sql.=" AND `".$this->model->getTableName()."`.`".$this->model->getPrimaryKeyName()."`=\"".$this->model->getextLabelId('','single')."\"";
			}
		} else if ($this->getVendor()==self::mssql) {
			$sql	=	"
			SELECT 		*
			FROM 		[extLabel]
			JOIN		[extLabelTranslate]
			JOIN 		[tab]
			ON			[tab].[tabId] = [extLabel].[tabId]
			LEFT JOIN	[icon]
			ON			[extLabel].[iconId]=[icon].[iconId]
			WHERE		[tab].[isActive]	=	1
			AND			[extLabel].[isActive]		=	1";
			if($this->model->getextLabelId('','single')) {
				$sql.=" AND [".$this->model->getTableName()."].[".$this->model->getPrimaryKeyName()."]=\"".$this->model->getextLabelId('','single')."\"";
			}
		} else if ($this->getVendor()==self::oracle) {
			$sql	=	"
			SELECT 		*
			FROM 		\"extLabel\"
			JOIN 		\"tab\"
			ON			\"tab\".\"tabId\" = \"extLabel\".\"tabId\"
			LEFT JOIN	\"icon\"
			USING(\"iconId\")
			WHERE		\"tab\".\"isActive\"=1
			AND			\"extLabel\".\"isActive\"=1";
			if($this->model->getextLabelId('','single')) {
				$sql.=" AND \"".$this->model->getTableName()."`.".$this->model->getPrimaryKeyName()."\"=\"".$this->model->getextLabelId('','single')."\"";
			}
		}
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		$filterArray =array('tabId','tabTranslateId','extLabelId','extLabelTranslateId');
		/**
		 *	filter table
		 * @variables $tableArray
		 */
		$tableArray = array('tab','tabTranslate','extLabel','extLabelTranslate');

	 if ($this->getFieldQuery()) {
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
		//echo $sql;
		$this->q->read($sql);
		if($this->q->redirect=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		$total	= $this->q->numberRows();

		if ($this->getOrder() && $this->getSortField()) {
			if ($this->getVendor() == self::mysql) {
				$sql .= "	ORDER BY `" . $this->getSortField() . "` " . $this->getOrder(). " ";
			} else if ($this->getVendor() ==  self::mssql) {
				$sql .= "	ORDER BY [" . $this->getSortField() . "] " . $this->getOrder() . " ";
			} else if ($this->getVendor() == self::oracle) {
				$sql .= "	ORDER BY \"" . $this->getSortField() . "\"  " . $this->getOrder() . " ";
			}
		}
		$_SESSION['sql']	=	$sql; // push to session so can make report via excel and pdf
		$_SESSION['start'] 	= 	$_POST['start'];
		$_SESSION['limit'] 	= 	$_POST['limit'];

		if(empty($_POST['filter']))      {

			if(isset($_POST['start']) && isset($_POST['limit'])) {
				// only mysql have limit

				if($this->getVendor() == self::mysql) {
					$sql.=" LIMIT  ".$_POST['start'].",".$_POST['limit']." ";
					$sqlLimit = $sql;
				} else if ($this->getVendor()==self::mssql) {
					/**
					 *	 Sql Server and Oracle used row_number
					 *	 Parameterize Query We don't support
					 */
					$sqlLimit="
							WITH [extLabelDerived] AS
							(
								SELECT	*,
								[extLabel].[By],
								[extLabel].[Time]
								ROW_NUMBER() OVER (ORDER BY [extLabelId]) AS 'RowNumber'
								FROM 		[extLabel]

								JOIN 		[tab]
								ON			[tab].[tabId` = `extLabel`.`tabId`

								LEFT JOIN	[icon]
								ON			[extLabel].[iconId]=[icon].[iconId]
								WHERE		[tab].[isActive]	=	1
								AND			[extLabel].[isActive]		=	1  ".$tempSql.$tempSql2."
							)
							SELECT		*
							FROM 		[extLabelDerived]
							WHERE 		[RowNumber]
							BETWEEN	".$_POST['start']."
							AND 			".($_POST['start']+$_POST['limit']-1).";";


				}  else if ($this->getVendor()==self::oracle) {
					/**
					 *  Oracle using derived table also
					 */


					$sql="
						SELECT *
						FROM ( SELECT	a.*,
												rownum r
						FROM (
									SELECT 		*,
												\"extLabel\".\"By\",
												\"extLabel\".\"Time\"
									FROM 		\"extLabel\"
									JOIN		\"extLabelTranslate\"
									ON			\"extLabel\".\"extLabelId\"	=\"extLabelTranslate\".\"extLabelId\"
									JOIN 		\"tab\"
									ON			\"tab\".\"tabId\" = \"extLabel\".\"tabId\"
									JOIN		\"tabTranslate\"
									ON			\"tab\".\"tabId\"=	\"tabTranslate\".\"tabId\"
									AND			\"tabTranslate\".\"tabId\" =\"extLabel\".\"tabId\"
									LEFT JOIN	\"icon\"
									ON			\"extLabel\".\"iconId\"=\"icon\".\"iconId\"
									WHERE		\"tab\".\"isActive\"=1
									AND			\"extLabel\".\"isActive\"=1 ".$tempSql.$tempSql2.$orderBy."
								 ) a
						where rownum <= \"".($_POST['start']+$_POST['limit']-1)."\" )
						where r >=  \"".$_POST['start']."\"";

				} else {
					echo "undefine vendor";
				}
			}
		}

		/*
		 *  Only Execute One Query
		*/
		if(!($this->extLabelId)) {

			$this->q->read($sql);
			if($this->q->execute=='fail') {
				echo json_encode(
				array(
					  	"success"	=>	false,
						"message"	=>	$this->q->responce
				));
				exit();
			}
		}
		$items 			= 	array();
		while($row  	= 	$this->q->fetchAssoc()) {
			$items[]	=	$row;
		}



		if($this->extLabelId) {
			$json_encode = json_encode(
			array(
						'success'	=>	true,
						'total' 	=> 	$total,
						'data' 		=> 	$items
			));
			$json_encode=str_replace("[","",$json_encode);
			$json_encode=str_replace("]","",$json_encode);
			echo $json_encode;
		} else {
			if(count($items)==0) {
				$items='';
			}
			echo json_encode(
			array(
											'success'	=>	true,
											'total' 	=> 	$total,
											'data' 		=> 	$items
			)
			);
			exit();
		}



	}



	/* (non-PHPdoc)
	 * @see config::update()
	*/
	function update() 							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->update();
		if($this->getVendor() == self::mysql) {
			$sql="
					UPDATE 	`extLabel`
					SET 	`tabId`				=	\"".$this->model->getTabId()."\",
							`extLabelNote`		=	\"".$this->model->getextLabelNote()."\",
							`extLabelSequence`	=	\"".$this->model->getextLabelSequence()."\",
							`extLabelCode`		=	\"".$this->model->getextLabelCode()."\",
							`extLabelPath`		=	\"".$this->model->getextLabelPath()."\",
							`iconId`			=	\"".$this->model->getIconId()."\",
							`isDefault`			=	\"".$this->model->getIsDefault('','single')."\",
							`isActive`			=	\"".$this->model->getIsActive('','single')."\",
							`isNew`				=	\"".$this->model->getIsNew('','single')."\",
							`isDraft`			=	\"".$this->model->getIsDraft('','single')."\",
							`isUpdate`			=	\"".$this->model->getIsUpdate('','single')."\",
							`isDelete`			=	\"".$this->model->getIsDelete('','single')."\",
							`isApproved`		=	\"".$this->model->getIsApproved('','single')."\",
							`By`				=	\"".$this->model->getBy()."\",
							`Time`				=	".$this->model->getTime()."
					WHERE 	`extLabelId`			=	\"".$this->model->getextLabelId('','single')."\"";
		}  else if ( $this->getVendor()==self::mssql) {
			$sql="
					UPDATE 	[extLabel]
					SET 	[tabId]		=	\"".$this->model->getTabId()."\",
							[extLabelNote]		=	\"".$this->model->getextLabelNote()."\",
							[extLabelSequence]	=	\"".$this->model->getextLabelSequence()."\",
							[extLabelPath]		=	\"".$this->model->getextLabelPath()."\",
							[iconId]			=	\"".$this->strict($_POST['iconId'],'string')."\",
							[isActive]			=	\"".$this->model->getIsActive('','single')."\",
							[isNew]				=	\"".$this->model->getIsNew('','single')."\",
							[isDraft]			=	\"".$this->model->getIsDraft('','single')."\",
							[isUpdate]			=	\"".$this->model->getIsUpdate('','single')."\",
							[isDelete]			=	\"".$this->model->getIsDelete('','single')."\",
							[isApproved]		=	\"".$this->model->getIsApproved('','single')."\",
							[By]				=	\"".$this->model->getBy()."\",
							[Time]				=	".$this->model->getTime()."
					WHERE 	[extLabelId]			=	\"".$this->model->getextLabelId('','single')."\"";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
					UPDATE 	\"extLabel\"
					SET 	\"tabId\"		=	\"".$this->model->getTabId()."\",
							\"extLabelNote\"		=	\"".$this->model->getextLabelNote()."\",
							\"extLabelSequence\"	=	\"".$this->model->getextLabelSequence()."\",
							\"extLabelPath\"		=	\"".$this->model->getextLabelPath()."\",
							\"isDefault\"		=	\"".$this->model->getIsDefault('','single')."\",
							\"isActive\"		=	\"".$this->model->getIsActive('','single')."\",
							\"isNew\"			=	\"".$this->model->getIsNew('','single')."\",
							\"isDraft\"			=	\"".$this->model->getIsDraft('','single')."\",
							\"isUpdate\"		=	\"".$this->model->getIsUpdate('','single')."\",
							\"isDelete\"		=	\"".$this->model->getIsDelete('','single')."\",
							\"isApproved\"		=	\"".$this->model->getIsApproved('','single')."\",
							\"By\"				=	\"".$this->model->getBy()."\",
							\"Time\"			=	".$this->model->getTime()."
					WHERE 	\"extLabelId\"		=	\"".$this->model->getextLabelId('','single')."\"";
		}
		$this->q->update($sql);
		if($this->q->redirect=='fail') {
			echo json_encode(array("success"=>false,"message"=>$this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success"=>true,"message"=>"Record Update"));
		exit();


	}
	/* (non-PHPdoc)
	 * @see config::delete()
	*/
	function delete()							{
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		$this->q->start();
		$this->model->delete();
		if($this->getVendor() == self::mysql) {
			$sql="
					UPDATE	`extLabel`
					SET		`isDefault`		=	\"".$this->model->getIsDefault('','single')."\",
							`isActive`		=	\"".$this->model->getIsActive('','single')."\",
							`isNew`			=	\"".$this->model->getIsNew('','single')."\",
							`isDraft`		=	\"".$this->model->getIsDraft('','single')."\",
							`isUpdate`		=	\"".$this->model->getIsUpdate('','single')."\",
							`isDelete`		=	\"".$this->model->getIsDelete('','single')."\",
							`isApproved`	=	\"".$this->model->getIsApproved('','single')."\",
							`By`			=	\"".$this->model->getBy()."\",
							`Time`			=	".$this->model->getTime()."
					WHERE 	`extLabelId`		=	\"".$this->model->getextLabelId()."\"";

		} else if ($this->getVendor()==self::mssql) {
			$sql="
					UPDATE	[extLabel]
					SET		[isDefault]		=	\"".$this->model->getIsDefault('','single')."\",
							[isActive]		=	\"".$this->model->getIsActive('','single')."\",
							[isNew]			=	\"".$this->model->getIsNew('','single')."\",
							[isDraft]		=	\"".$this->model->getIsDraft('','single')."\",
							[isUpdate]		=	\"".$this->model->getIsUpdate('','single')."\",
							[isDelete]		=	\"".$this->model->getIsDelete('','single')."\",
							[isApproved]	=	\"".$this->model->getIsApproved('','single')."\",
							[By]			=	\"".$this->model->getBy()."\",
							[Time]			=	".$this->model->getTime()."
					WHERE 	[extLabelId]		=	\"".$this->model->getextLabelId()."\"";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
					UPDATE	\"extLabel\"
					SET		\"isDefault\"	=	\"".$this->model->getIsDefault('','single')."\",
							\"isActive\"	=	\"".$this->model->getIsActive('','single')."\",
							\"isNew\"		=	\"".$this->model->getIsNew('','single')."\",
							\"isDraft\"		=	\"".$this->model->getIsDraft('','single')."\",
							\"isUpdate\"	=	\"".$this->model->getIsUpdate('','single')."\",
							\"isDelete\"	=	\"".$this->model->getIsDelete('','single')."\",
							\"isApproved\"	=	\"".$this->model->getIsApproved('','single')."\",
							\"By\"			=	\"".$this->model->getBy()."\",
							\"Time\"		=	".$this->model->getTime()."
					WHERE 	\"extLabelId\"	=	\"".$this->model->getextLabelId()."\"";
		}
		$this->q->update($sql);
		if($this->q->redirect=='fail') {
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();
		}
		$this->q->commit();
		echo json_encode(array("success"=>"true","message"=>"Record Removed"));
		exit();


	}

	/**
	 *  Read Record From tabTranslate Table
	 **/
	function translateRead() {
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			/**
			 *	UTF 8
			 **/
			$sql	=	"SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
		if( $this->q->vendor='mysql'){
			$sql="
			SELECT	*
			FROM 	`extLabelTranslate`
			JOIN 	`language`
			USING (`languageId`)
			WHERE	`extLabelTranslate`.`extLabelId`=\"".$this->model->getextLabelId()."\"";
		} else if ($this->getVendor()==self::mssql){
			$sql="
			SELECT	*
			FROM 	[tabTranslate]
			JOIN 	[language]
			ON 		[extLabelTranslate].[languageId] =[language].[languageId]
			WHERE	[extLabelTranslate].[extLabelId]=\"".$this->model->getextLabelId()."\"";
		} else if ($this->q->vendor=='oralce'){
			$sql="
			SELECT	*
			FROM 	\"extLabelTranslate\"
			JOIN 	\"language\"
			USING (\"languageId\")
			WHERE	\"extLabelTranslate\".\"extLabelId\"=\"".$this->model->getextLabelId()."\"";
		}
		$this->q->read($sql);
		$total =$this->q->numberRows();
		$items = array();
		while ($row = $this->q->fetchAssoc()){
			$items[]= $row;
		}
		echo json_encode(
		array(
						'success'	=>	'true',
						'total' 	=>	$total,
       					'data' 		=> 	$items
		));
		exit();

	}

	/**
	 * Update tab Translation in tabTranslate Table
	 */
	public function translateUpdate(){
		header('Content-Type','application/json; charset=utf-8');

		$this->q->commit();
		if($this->getVendor() == self::mysql){
			$sql="
		UPDATE	`extLabelTranslate`
		SET		`extLabelTranslate` 	=	\"".$this->strict($_POST['extLabelTranslate'],'string')."\"
		WHERE 	`extLabelTranslateId`	=	\"".$this->strict($_POST['extLabelTranslateId'],'numeric')."\"";
		} else if ($this->getVendor()==self::mssql){
			$sql="
		UPDATE	[extLabelTranslate]
		SET		[extLabelTranslate] 	=	\"".$this->strict($_POST['extLabelTranslate'],'string')."\"
		WHERE 	[extLabelTranslateId]	=	\"".$this->strict($_POST['extLabelTranslateId'],'numeric')."\"";
		} else if ($this->getVendor()==self::oracle){
			$sql="
		UPDATE	\"extLabelTranslate\"
		SET		\"extLabelTranslate\" 		=	\"".$this->strict($_POST['extLabelTranslate'],'string')."\"
		WHERE 	\"extLabelTranslateId\"	=	\"".$this->strict($_POST['extLabelTranslateId'],'numeric')."\"";
		}
		$this->q->update($sql);
		if($this->q->execute=='fail'){
			echo json_encode(array("success"=>"false","message"=>$this->q->responce));
			exit();
		}

		$this->q->commit();
		echo json_encode(array("success"=>true,"message"=>"Record Update"));
		exit();
	}
	/*
	 * Create Translation extLabel Note to the extLabelTranslate Table
	*/
	function translateMe() {
		header('Content-Type','application/json; charset=utf-8');
		$this->q->start();

		$sql="
		SELECT	*
		FROM 	`extLabel`
		WHERE 	`extLabelId`	=	\"".$this->extLabelId."\"";
		$resultDefault= $this->q->fast($sql);
		if($this->q->numberRows($resultDefault) > 0 ) {
			$rowDefault = $this->q->fetch_array($resultDefault);
			$value 		= $rowDefault['extLabelNote'];
		}
		if($this->getVendor() == self::mysql) {
			$sql="
			SELECT	*
			FROM 	`language`";
		} else if ($this->getVendor()==self::mssql) {
			$sql="
			SELECT 	*
			FROM 	[language] ";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
			SELECT 	*
			FROM 	\"language\" ";
		}
		$result= $this->q->fast($sql);
		while ($row = $this->q->fetchAssoc($result)) {
			$languageId 	= 	$row['languageId'];
			$languageCode	= 	$row['languageCode'];
			$to 		  	=	$languageCode;
			$googleTranslate = $this->security->changeLanguage($from="en",$to,$value);
			if($this->getVendor() == self::mysql) {
				$sql="
				SELECT	*
				FROM 	`extLabelTranslate`
				WHERE 	`extLabelId`			=	\"".$this->extLabelId."\"
				AND 	`languageId`		=	\"".$languageId."\"";
			} else if ($this->getVendor()==self::mssql) {
				$sql="
				SELECT 	*
				FROM 	[extLabelTranslate]
				WHERE 	[extLabelId]			=	\"".$this->extLabelId."\"
				AND 	[languageId]		=	\"".$languageId."\"";
			}  else if ($this->getVendor()==self::oracle) {
				$sql="
				SELECT 	*
				FROM 	\"extLabelTranslate\"
				WHERE 	\"extLabelId\"		=	\"".$this->extLabelId."\"
				AND 	\"languageId\"		=	\"".$languageId."\"";
			}
			$resultextLabelTranslate = $this->q->fast($sql);
			if($this->q->numberRows($resultextLabelTranslate) >  0 ) {
				if($this->q->vendor=='normal'  ||$this->getVendor() == self::mysql) {
					$sql="
					UPDATE 	`extLabelTranslate`
					SET 	`extLabelTranslate`		=	\"".$googleTranslate."\"
					WHERE 	`extLabelId`				=	\"".$this->extLabelId."\"
					AND 	`languageId`			=	\"".$languageId."\"";
				} else if ($this->getVendor()==self::mssql) {
					$sql="
					UPDATE 	[extLabelTranslate]
					SET 	[extLabelTranslate]		=	\"".$googleTranslate."\"
					WHERE 	[extLabelId]				=	\"".$this->extLabelId."\"
					AND 	[languageId]			=	\"".$languageId."\"";
				} else if ($this->getVendor()==self::oracle) {
					$sql="
					UPDATE 	\"extLabelTranslate\"
					SET 	\"extLabelTranslate\"		=	\"".$googleTranslate."\"
					WHERE 	\"extLabelId\"			=	\"".$this->extLabelId."\"
					AND 	\"languageId\"			=	\"".$languageId."\"";
				}
				$this->q->update($sql);
				if($this->q->redirect=='fail') {
					echo json_encode(array("success"=>"false","message"=>$this->q->responce));
					exit();

				}
			} else {
				if($this->q->vendor=='normal'  ||$this->getVendor() == self::mysql) {
					$sql="
					INSERT INTO `extLabelTranslate`
							(
								`extLabelId`,
								`languageId`,
								`extLabelTranslate`
							)
					VALUES
						(
							\"".$extLabelId."\",
							\"".$languageId."\",
							\"".$googleTranslate."\"
						)";
				} else if ($this->getVendor()==self::mssql) {
					$sql="
					INSERT INTO [extLabelTranslate]
							(
								[extLabelId],
								[languageId],
								[extLabelTranslate]
							)
					VALUES
							(
								\"".$extLabelId."\",
								\"".$languageId."\",
								\"".$googleTranslate."\"
						)";
				} else if ($this->getVendor()==self::oracle) {
					$sql="
					INSERT INTO \"extLabelTranslate\"
							(
								\"extLabelId\",
								\"languageId\",
								\"extLabelTranslate\"
							)
					VALUES
							(
								\"".$extLabelId."\",
								\"".$languageId."\",
								\"".$googleTranslate."\"
							)";
				}
				$this->q->create($sql);
				if($this->q->redirect=='fail') {
					echo json_encode(array("success"=>"false","message"=>$this->q->responce));
					exit();

				}
			}
		}
		$this->q->commit();
		echo json_encode(
		array(
							  	"success"	=>	"true",
								"message"	=>	"Translation Complete"
		));
		exit();


	}
	/**
	 * Enter description here ...
	 */
	function tab(){
		return $this->security->tab();
	}
	/* (non-PHPdoc)
	 * @see config::excel()
	*/
	function excel() {
		header('Content-Type','application/json; charset=utf-8');
		if($this->getVendor() == self::mysql) {
			//UTF8
			$sql="SET NAMES \"utf8\"";
			$this->q->fast($sql);

		}
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
		$this->excel->getActiveSheet()->setCellValue('B2',$this->title);
		$this->excel->getActiveSheet()->setCellValue('D2','');
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->setCellValue('B3','No');
		$this->excel->getActiveSheet()->setCellValue('C3','extLabel');
		$this->excel->getActiveSheet()->setCellValue('D3','Description');
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B2:D2')->getFill()->getStartColor()->setARGB('66BBFF');
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('B3:D3')->getFill()->getStartColor()->setARGB('66BBFF');

		//
		$loopRow=4;
		$i=0;
		while($row  = 	$this->q->fetchAssoc()) {


			$this->excel->getActiveSheet()->setCellValue('B'.$loopRow,++$i);
			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['extLabelNote']);
			$loopRow++;
			$lastRow='D'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="extLabel".rand(0,10000000).".xlsx";
		$path=$_SERVER['DOCUMENT_ROOT']."/".$this->application."/security/document/excel/".$filename;
		$objWriter->save($path);
		$this->audit->create_trail($this->leafId, $path,$filename);
		$file = fopen($path,'r');
		if($file){
			echo json_encode(array("success"=>"true","message"=>"File generated"));
		} else {
			echo json_encode(array("success"=>"false","message"=>"File not generated"));

		}
	}




}

$extLabelObject  	= 	new extLabelClass();

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
		$extLabelObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	*/
	if(isset($_POST['isAdmin'])){
		$extLabelObject->setIsAdmin($_POST['isAdmin']);
	}

	/*
	 *  Filtering
	*/

	if(isset($_POST['query'])){
		$extLabelObject->setFieldQuery($_POST['query']);
	}
	if(isset($_POST['filter'])){
		$extLabelObject->setGridQuery($_POST['filter']);
	}
	/*
	 * Ordering
	*/
	if(isset($_POST['order'])){
		$extLabelObject->setOrder($_POST['order']);
	}
	if(isset($_POST['sortField'])){
		$extLabelObject->setSortField($_POST['sortField']);
	}

	/*
	 *  Load the dynamic value
	*/
	$extLabelObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	*/
	if($_POST['method']=='create')	{
		$extLabelObject->create();
	}
	if($_POST['method']=='read') 	{

		$extLabelObject->read();

	}

	if($_POST['method']=='save') 	{

		$extLabelObject->update();

	}
	if($_POST['method']=='delete') 	{
		$extLabelObject->delete();
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
		$extLabelObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	*/
	if(isset($_GET['isAdmin'])){
		$extLabelObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	*/
	$extLabelObject->execute();
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {

			$extLabelObject->staff();
		}
		if($_GET['field']=='tabId'){
			$extLabelObject->tab();
		}

	}
	/*
	* Update Status of The Table. Admin Level Only
	*/
	if($_GET['method']=='updateStatus'){
		$extLabelObject->updateStatus();
	}
	/*
	*  Checking Any Duplication  Key
	*/
	if (isset($_GET['extLabelCode'])) {
		if (strlen($_GET['extLabelCode']) > 0) {
			$extLabelObject->duplicate();
		}
	}
	/*
	*  Excel Reporting
	*/
	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$extLabelObject->excel();
		}
	}

}


?>

