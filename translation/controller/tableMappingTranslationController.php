<?php	session_start();
require_once("../../class/classAbstract.php");
require_once("../../document/class/classDocumentTrail.php");
require_once("../../document/model/documentModel.php");
require_once("../../class/classSecurity.php");
require_once("../model/tableMappingTranslationTranslationModel.php");

/**
 * this tableMappingTranslationTranslation menu creation
 * @name IDCMS
 * @version 2
 * @author hafizan
 * @package Translation
 * @package tableMappingTranslation Translation
 * @link http://www.idcms.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 */
class tableMappingTranslationTranslationClass extends  configClass {
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
	 * tableMappingTranslation Model
	 * @var string $tableMappingTranslationModel
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
	 * tableMappingTranslationTranslation Translation Identification
	 * @var  numeric $tableMappingTranslationTranslationTranslateId
	 */
	public $tableMappingTranslationTranslationTranslateId;
	/**
	 * Translation update
	 * @var string $tableMappingTranslationTranslationTranslate
	 */
	public $tableMappingTranslationTranslationTranslate;
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

		$this->model = new tableMappingTranslationTranslationModel();
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
			INSERT INTO `tableMappingTranslationTranslation`
					(
						`defautlLabel`,							`tableMappingTranslationTranslationEnglish`
						`isDefault`,							`isNew`,
						`isDraft`,								`isUpdate`,
						`isDelete`,								`isActive`,
						`isApproved`,							`By`,
						`Time`
					)
			VALUES
					(
						\"".$this->model->gettableMappingTranslationTranslation()."\",						\"".$this->model->gettableMappingTranslationTranslationEnglish()."\"
						\"". $this->model->getIsDefault(0,'single') . "\",				\"". $this->model->getIsNew(0,'single') . "\",
						\"". $this->model->getIsDraft(0,'single') . "\",				\"". $this->model->getIsUpdate(0,'single') . "\",
						\"". $this->model->getIsDelete(0,'single') . "\",				\"". $this->model->getIsActive(0,'single') . "\",
						\"". $this->model->getIsApproved(0,'single') . "\",			\"". $this->model->getBy() . "\",
						" . $this->model->getTime() . "
					);";
		}else if ($this->getVendor()==self::mssql) {
			$sql="
			INSERT INTO [tableMappingTranslationTranslation]
					(
						[tableMappingTranslationTranslation],							[tableMappingTranslationTranslationEnglish]
						[isDefault],
						[isNew],							[isDraft],
						[isUpdate],							[isDelete],
						[isActive],							[isApproved],
						[By],								[Time]
				)
			VALUES
				(
						\"".$this->model->gettableMappingTranslationTranslation()."\",						\"".$this->model->gettableMappingTranslationTranslationEnglish()."\"
						\"". $this->model->getIsDefault(0,'single') . "\",				\"". $this->model->getIsNew(0,'single') . "\",
						\"". $this->model->getIsDraft(0,'single') . "\",				\"". $this->model->getIsUpdate(0,'single') . "\",
						\"". $this->model->getIsDelete(0,'single') . "\",				\"". $this->model->getIsActive(0,'single') . "\",
						\"". $this->model->getIsApproved(0,'single') . "\",			\"". $this->model->getBy() . "\",
						" . $this->model->getTime() . "
			);";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
			INSERT INTO 	\"tableMappingTranslationTranslation\"
						(
							\"tableMappingTranslationTranslation\",							\"tableMappingTranslationTranslationEnglish\",
							\"isDefault\",								\"isNew\",
							\"isDraft\",								\"isUpdate\",
							\"isDelete\",								\"isActive\",
							\"isApproved\",								\"By\",
							\"Time\"
				VALUES	(
							\"".$this->model->gettableMappingTranslationTranslation()."\",						\"".$this->model->gettableMappingTranslationTranslationEnglish()."\"
							\"". $this->model->getIsDefault(0,'single') . "\",				\"". $this->model->getIsNew(0,'single') . "\",
							\"". $this->model->getIsDraft(0,'single') . "\",				\"". $this->model->getIsUpdate(0,'single') . "\",
							\"". $this->model->getIsDelete(0,'single') . "\",				\"". $this->model->getIsActive(0,'single') . "\",
							\"". $this->model->getIsApproved(0,'single') . "\",			\"". $this->model->getBy() . "\",
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

		$this->q->commit();
		echo json_encode(array("success"=>true,"tableMappingTranslationTranslationId"=>$lastId,"message"=>"Record Created"));
		exit();
	}
	/* (non-PHPdoc)
	 * @see config::read()
	 */
	function read() 							{
		header('Content-Type','application/json; charset=utf-8');

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
			FROM 		`tableMappingTranslationTranslation`
			WHERE 1 ";
			if($this->model->gettableMappingTranslationTranslationId(0,'single')) {
				$sql.=" AND `".$this->model->getTableName()."`.`".$this->model->getPrimaryKeyName()."`=\"".$this->model->gettableMappingTranslationTranslationId(0,'single')."\"";
			}
		} else if ($this->getVendor()==self::mssql) {
			$sql	=	"
			SELECT 		*
			FROM 		[tableMappingTranslationTranslation]
			WHERE 1 ";
			if($this->model->gettableMappingTranslationTranslationId(0,'single')) {
				$sql.=" AND [".$this->model->getTableName()."].[".$this->model->getPrimaryKeyName()."]=\"".$this->model->gettableMappingTranslationTranslationId(0,'single')."\"";
			}
		} else if ($this->getVendor()==self::oracle) {
			$sql	=	"
			SELECT 		*
			FROM 		\"tableMappingTranslationTranslation\"
			WHERE 1";
			if($this->model->gettableMappingTranslationTranslationId(0,'single')) {
				$sql.=" AND \"".$this->model->getTableName()."`.".$this->model->getPrimaryKeyName()."\"=\"".$this->model->gettableMappingTranslationTranslationId(0,'single')."\"";
			}
		}
		/**
		 *	filter column don't want to filter.Example may contain  sensetive information or unwanted to be search.
		 *  E.g  $filterArray=array('`leaf`.`leafId`');
		 *  @variables $filterArray;
		 */
		$filterArray =array('tableMappingTranslationTranslationId');
		/**
		 *	filter table
		 * @variables $tableArray
		 */
		$tableArray = array('tableMappingTranslationTranslation');

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
							WITH [tableMappingTranslationTranslationDerived] AS
							(
								SELECT	*,
								[tableMappingTranslationTranslation].[By],
								[tableMappingTranslationTranslation].[Time]
								ROW_NUMBER() OVER (ORDER BY [tableMappingTranslationTranslationId]) AS 'RowNumber'
								FROM 		[tableMappingTranslationTranslation]
								WHERE	1  ".$tempSql.$tempSql2."
							)
							SELECT		*
							FROM 		[tableMappingTranslationTranslationDerived]
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
									SELECT 		*
									FROM 		\"tableMappingTranslationTranslation\"
									WHERE		1
									AND 		".$tempSql.$tempSql2.$orderBy."
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
		if(!($this->gettableMappingTranslationTranslationId(0,'single'))) {

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



		if($this->gettableMappingTranslationTranslationId(0,'single')) {
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
					UPDATE 	`tableMappingTranslationTranslation`
					SET 	`tableMappingTranslationTranslationNote`		=	\"".$this->model->gettableMappingTranslationTranslationNote()."\",
							`tableMappingTranslationTranslationEnglish`	=	\"".$this->model->gettableMappingTranslationTranslationEnglish()."\",
							`isDefault`		=	\"".$this->model->getIsDefault(0,'single')."\",
							`isActive`		=	\"".$this->model->getIsActive(0,'single')."\",
							`isNew`			=	\"".$this->model->getIsNew(0,'single')."\",
							`isDraft`		=	\"".$this->model->getIsDraft(0,'single')."\",
							`isUpdate`		=	\"".$this->model->getIsUpdate(0,'single')."\",
							`isDelete`		=	\"".$this->model->getIsDelete(0,'single')."\",
							`isApproved`	=	\"".$this->model->getIsApproved(0,'single')."\",
							`By`			=	\"".$this->model->getBy()."\",
							`Time`			=	".$this->model->getTime()."
					WHERE 	`tableMappingTranslationTranslationId`			=	\"".$this->model->gettableMappingTranslationTranslationId(0,'single')."\"";
		}  else if ( $this->getVendor()==self::mssql) {
			$sql="
					UPDATE 	[tableMappingTranslationTranslation]
					SET 	[tableMappingTranslationTranslationNote]		=	\"".$this->model->gettableMappingTranslationTranslationNote()."\",
							[tableMappingTranslationTranslationEnglish]	=	\"".$this->model->gettableMappingTranslationTranslationEnglish()."\",
							[isDefault]		=	\"".$this->model->getIsDefault(0,'single')."\",
							[isActive]		=	\"".$this->model->getIsActive(0,'single')."\",
							[isNew]			=	\"".$this->model->getIsNew(0,'single')."\",
							[isDraft]		=	\"".$this->model->getIsDraft(0,'single')."\",
							[isUpdate]		=	\"".$this->model->getIsUpdate(0,'single')."\",
							[isDelete]		=	\"".$this->model->getIsDelete(0,'single')."\",
							[isApproved]	=	\"".$this->model->getIsApproved(0,'single')."\",
							[By]			=	\"".$this->model->getBy()."\",
							[Time]			=	".$this->model->getTime()."
					WHERE 	[tableMappingTranslationTranslationId]			=	\"".$this->model->gettableMappingTranslationTranslationId(0,'single')."\"";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
					UPDATE 	\"tableMappingTranslationTranslation\"
					SET 	\"tableMappingTranslationTranslationNote\"		=	\"".$this->model->gettableMappingTranslationTranslationNote()."\",
							\"tableMappingTranslationTranslationEnglish\"	=	\"".$this->model->gettableMappingTranslationTranslationEnglish()."\",
							\"isDefault\"	=	\"".$this->model->getIsDefault(0,'single')."\",
							\"isActive\"	=	\"".$this->model->getIsActive(0,'single')."\",
							\"isNew\"		=	\"".$this->model->getIsNew(0,'single')."\",
							\"isDraft\"		=	\"".$this->model->getIsDraft(0,'single')."\",
							\"isUpdate\"	=	\"".$this->model->getIsUpdate(0,'single')."\",
							\"isDelete\"	=	\"".$this->model->getIsDelete(0,'single')."\",
							\"isApproved\"	=	\"".$this->model->getIsApproved(0,'single')."\",
							\"By\"			=	\"".$this->model->getBy()."\",
							\"Time\"		=	".$this->model->getTime()."
					WHERE 	\"tableMappingTranslationTranslationId\"		=	\"".$this->model->gettableMappingTranslationTranslationId(0,'single')."\"";
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
					UPDATE	`tableMappingTranslationTranslation`
					SET		`isDefault`		=	\"".$this->model->getIsDefault(0,'single')."\",
							`isActive`		=	\"".$this->model->getIsActive(0,'single')."\",
							`isNew`			=	\"".$this->model->getIsNew(0,'single')."\",
							`isDraft`		=	\"".$this->model->getIsDraft(0,'single')."\",
							`isUpdate`		=	\"".$this->model->getIsUpdate(0,'single')."\",
							`isDelete`		=	\"".$this->model->getIsDelete(0,'single')."\",
							`isApproved`	=	\"".$this->model->getIsApproved(0,'single')."\",
							`By`			=	\"".$this->model->getBy()."\",
							`Time`			=	".$this->model->getTime()."
					WHERE 	`tableMappingTranslationTranslationId`		=	\"".$this->model->gettableMappingTranslationTranslationId()."\"";

		} else if ($this->getVendor()==self::mssql) {
			$sql="
					UPDATE	[tableMappingTranslationTranslation]
					SET		[isDefault]		=	\"".$this->model->getIsDefault(0,'single')."\",
							[isActive]		=	\"".$this->model->getIsActive(0,'single')."\",
							[isNew]			=	\"".$this->model->getIsNew(0,'single')."\",
							[isDraft]		=	\"".$this->model->getIsDraft(0,'single')."\",
							[isUpdate]		=	\"".$this->model->getIsUpdate(0,'single')."\",
							[isDelete]		=	\"".$this->model->getIsDelete(0,'single')."\",
							[isApproved]	=	\"".$this->model->getIsApproved(0,'single')."\",
							[By]			=	\"".$this->model->getBy()."\",
							[Time]			=	".$this->model->getTime()."
					WHERE 	[tableMappingTranslationTranslationId]		=	\"".$this->model->gettableMappingTranslationTranslationId()."\"";
		} else if ($this->getVendor()==self::oracle) {
			$sql="
					UPDATE	\"tableMappingTranslationTranslation\"
					SET		\"isDefault\"	=	\"".$this->model->getIsDefault(0,'single')."\",
							\"isActive\"	=	\"".$this->model->getIsActive(0,'single')."\",
							\"isNew\"		=	\"".$this->model->getIsNew(0,'single')."\",
							\"isDraft\"		=	\"".$this->model->getIsDraft(0,'single')."\",
							\"isUpdate\"	=	\"".$this->model->getIsUpdate(0,'single')."\",
							\"isDelete\"	=	\"".$this->model->getIsDelete(0,'single')."\",
							\"isApproved\"	=	\"".$this->model->getIsApproved(0,'single')."\",
							\"By\"			=	\"".$this->model->getBy()."\",
							\"Time\"		=	".$this->model->getTime()."
					WHERE 	\"tableMappingTranslationTranslationId\"	=	\"".$this->model->gettableMappingTranslationTranslationId()."\"";
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
						$primaryKeyAll.=$this->model->gettableMappingTranslationId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
						THEN \"".$this->model->getIsDefault(0,'single')."\"";
					}
				}
				$sql.="	END, ";
				$sql.="	`isNew`	=	case `".$this->model->getPrimaryKeyName()."` ";

				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->gettableMappingTranslationId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
						THEN \"".$this->model->getIsNew(0,'single')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isDraft`	=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->gettableMappingTranslationId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
						THEN \"".$this->model->getIsDraft(0,'single')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isUpdate`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->gettableMappingTranslationId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
						THEN \"".$this->model->getIsUpdate(0,'single')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isDelete`	=	case `".$this->model->getPrimaryKeyName()."`";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->gettableMappingTranslationId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
						THEN \"".$this->model->getIsDelete($i,'array')."\"";
					}
				}
				$sql.="	END,	";
				$sql.="	`isActive`	=		case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->gettableMappingTranslationId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
						THEN \"".$this->model->getIsActive(0,'single')."\"";
					}
				}
				$sql.="	END,";
				$sql.="	`isApproved`			=	case `".$this->model->getPrimaryKeyName()."` ";
				for($i=0;$i<$loop;$i++) {
					if($this->model->getIsDelete($i,'array')==1){
						$primaryKeyAll.=$this->model->gettableMappingTranslationId($i,'array').",";
						$sql.="
						WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
						THEN \"".$this->model->getIsApproved(0,'single')."\"";

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
			UPDATE 	[tableMappingTranslation]
			SET 	[isDefault]			=	\"". $this->model->getIsDefault(0,'single') . "\",
					[isNew]				=	\"". $this->model->getIsNew(0,'single') . "\",
					[isDraft]			=	\"". $this->model->getIsDraft(0,'single') . "\",
					[isUpdate]			=	\"". $this->model->getIsUpdate(0,'single') . "\",
					[isDelete]			=	\"". $this->model->getIsDelete(0,'single') . "\",
					[isActive]			=	\"". $this->model->getIsActive(0,'single') . "\",
					[isApproved]		=	\"". $this->model->getIsApproved(0,'single') . "\",
					[By]				=	\"". $this->model->getBy() . "\",
					[Time]				=	" . $this->model->getTime() . "
			WHERE 	[tableMappingTranslationId]		IN	(". $this->model->gettableMappingTranslationIdAll() . ")";
			} else if ($this->getVendor() == self::oracle) {
				$sql = "
				UPDATE	\"tableMappingTranslation\"
				SET 	\"isDefault\"		=	\"". $this->model->getIsDefault(0,'single') . "\",
					\"isNew\"			=	\"". $this->model->getIsNew(0,'single') . "\",
					\"isDraft\"			=	\"". $this->model->getIsDraft(0,'single') . "\",
					\"isUpdate\"		=	\"". $this->model->getIsUpdate(0,'single') . "\",
					\"isDelete\"		=	\"". $this->model->getIsDelete(0,'single') . "\",
					\"isActive\"		=	\"". $this->model->getIsActive(0,'single') . "\",
					\"isApproved\"		=	\"". $this->model->getIsApproved(0,'single') . "\",
					\"By\"				=	\"". $this->model->getBy() . "\",
					\"Time\"			=	" . $this->model->getTime() . "
			WHERE 	\"tableMappingTranslationId\"		IN	(". $this->model->gettableMappingTranslationIdAll() . ")";
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
			//	echo "arnab[".$this->model->gettableMappingTranslationId(0,'array')."]";
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
							WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
							THEN \"".$this->model->getIsDefault($i,'array')."\"";
						}
						break;
					case 'isNew':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
							THEN \"".$this->model->getIsNew($i,'array')."\"";

						} break;
					case 'isDraft':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
							THEN \"".$this->model->getIsDraft($i,'array')."\"";
						}
						break;
					case 'isUpdate':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
							THEN \"".$this->model->getIsUpdate($i,'array')."\"";
						}
						break;
					case 'isDelete':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
							THEN \"".$this->model->getIsDelete($i,'array')."\"";
						}
						break;
					case 'isActive':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
							THEN \"".$this->model->getIsActive($i,'array')."\"";
						}
						break;
					case 'isApproved':
						for($i=0;$i<$loop;$i++) {
							$sqlLooping.="
							WHEN \"".$this->model->gettableMappingTranslationId($i,'array')."\"
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
		$this->excel->getActiveSheet()->setCellValue('C3','tableMappingTranslationTranslation');
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
			$this->excel->getActiveSheet()->setCellValue('C'.$loopRow,$row['tableMappingTranslationTranslationNote']);
			$loopRow++;
			$lastRow='D'.$loopRow;
		}
		$from='B2';
		$to=$lastRow;
		$formula=$from.":".$to;
		$this->excel->getActiveSheet()->getStyle($formula)->applyFromArray($styleThinBlackBorderOutline);
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$filename="tableMappingTranslationTranslation".rand(0,10000000).".xlsx";
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

$tableMappingTranslationTranslationObject  	= 	new tableMappingTranslationTranslationClass();

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
		$tableMappingTranslationTranslationObject->setLeafId($_POST['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_POST['isAdmin'])){
		$tableMappingTranslationTranslationObject->setIsAdmin($_POST['isAdmin']);
	}

	/*
	 *  Filtering
	 */

	if(isset($_POST['query'])){
		$tableMappingTranslationTranslationObject->setFieldQuery($_POST['query']);
	}
	if(isset($_POST['filter'])){
		$tableMappingTranslationTranslationObject->setGridQuery($_POST['filter']);
	}
	/*
	 * Ordering
	 */
	if(isset($_POST['order'])){
		$tableMappingTranslationTranslationObject->setOrder($_POST['order']);
	}
	if(isset($_POST['sortField'])){
		$tableMappingTranslationTranslationObject->setSortField($_POST['sortField']);
	}

	/*
	 *  Load the dynamic value
	 */
	$tableMappingTranslationTranslationObject->execute();
	/*
	 *  Crud Operation (Create Read Update Delete/Destory)
	 */
	if($_POST['method']=='create')	{
		$tableMappingTranslationTranslationObject->create();
	}
	if($_POST['method']=='read') 	{

		$tableMappingTranslationTranslationObject->read();

	}

	if($_POST['method']=='save') 	{

		$tableMappingTranslationTranslationObject->update();

	}
	if($_POST['method']=='delete') 	{
		$tableMappingTranslationTranslationObject->delete();
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
		$tableMappingTranslationTranslationObject->setLeafId($_GET['leafId']);
	}
	/*
	 * Admin Only
	 */
	if(isset($_GET['isAdmin'])){
		$tableMappingTranslationTranslationObject->setIsAdmin($_GET['isAdmin']);
	}
	/*
	 *  Load the dynamic value
	 */
	$tableMappingTranslationTranslationObject->execute();
	if(isset($_GET['field'])) {
		if($_GET['field']=='staffId') {

			$tableMappingTranslationTranslationObject->staff();
		}
		if($_GET['field']=='tabId'){
			$tableMappingTranslationTranslationObject->tab();
		}

	}
	/*
	 * Update Status of The Table. Admin Level Only
	 */
	if($_GET['method']=='updateStatus'){
		$tableMappingTranslationTranslationObject->updateStatus();
	}
	/*
	 *  Checking Any Duplication  Key
	 */
	if (isset($_GET['tableMappingTranslationTranslationCode'])) {
		if (strlen($_GET['tableMappingTranslationTranslationCode']) > 0) {
			$tableMappingTranslationTranslationObject->duplicate();
		}
	}
	/*
	 *  Excel Reporting
	 */
	if(isset($_GET['mode'])){
		if($_GET['mode']=='excel') {
			$tableMappingTranslationTranslationObject->excel();
		}
	}

}


?>

